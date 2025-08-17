<?php
/**
*
* @package Auto db Backup
* @copyright (c) 2015 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\autodbbackup\cron\task;

use Symfony\Component\DependencyInjection\ContainerInterface;
use phpbb\cron\task\base;
use phpbb\config\config;
use phpbb\language\language;
use phpbb\db\driver\driver_interface;
use phpbb\log\log;
use phpbb\user;
use phpbb\event\dispatcher_interface;
use phpbb\db\tools\tools_interface;
use david63\autodbbackup\core\functions;
use phpbb\filesystem\filesystem;

class auto_db_backup extends base
{
	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpBB extension */
	protected $php_ext;

	/** @var string phpBB table prefix */
	protected $table_prefix;

	/** @var config */
	protected $config;

	/** @var language */
	protected $language;

	/** @var driver_interface */
	protected $db;

	/** @var log */
	protected $log;

	/** @var user */
	protected $user;

	/** @var ContainerInterface */
	protected $container;

	/** @var dispatcher_interface */
	protected $dispatcher;

	/** @var tools_interface */
	protected $db_tools;

	/** @var functions */
	protected $functions;

	/** @var filesystem */
	protected $filesystem;

	/**
	* Constructor for cron auto_db_backup
	*
	* @param string					$root_path			phpBB root path
	* @param string					$php_ext			phpBB file extension
	* @param string					$table_prefix		phpBB table prefix
	* @param config					$config				Config object
	* @param language				$language			Language object
	* @param driver_interface		$db					Database object
	* @param log					$log    			phpBB log
	* @param user					$user   			User object
	* @param ContainerInterface		$phpbb_container	phpBBcontainer
	* @param dispatcher_interface	$dispatcher			phpBB dispatcher
	* @param tools_interface		$db_tools			phpBB db tools
	* @param functions				$functions			Functions for the extension
	* @param filesystem				$filesystem    		phpBB filesystem
	*
	* @access   public
	*/
	public function __construct(string $root_path, string $php_ext, string $table_prefix, config $config, language $language, driver_interface $db, log $log, user $user, ContainerInterface $phpbb_container, dispatcher_interface $dispatcher, tools_interface $db_tools, functions $functions, filesystem $filesystem)
	{
		$this->root_path		= $root_path;
		$this->php_ext			= $php_ext;
		$this->table_prefix		= $table_prefix;
		$this->config			= $config;
		$this->language			= $language;
		$this->db  				= $db;
		$this->log				= $log;
		$this->user				= $user;
		$this->container		= $phpbb_container;
		$this->dispatcher		= $dispatcher;
		$this->db_tools			= $db_tools;
		$this->functions		= $functions;
		$this->filesystem 		= $filesystem;
	}

	/**
	* Run this cron task.
	*
	* @return null
	*/
	public function run()
	{
		$time				= time();
		$additional_data	= [];

		// Add the language file
		$this->language->add_lang('acp_autobackup', $this->functions->get_ext_namespace());

		// Update the next backup time.
		$next_cron_backup = $time + ($this->config['auto_db_backup_gc'] * 3600); // Convert hours to seconds

		// Do we want to maintain the time?
		if ($this->config['auto_db_backup_maintain_freq'])
		{
			$next_cron_backup = $this->config['auto_db_backup_next_gc'];

			while ($next_cron_backup < $time)
			{
				$next_cron_backup += $this->config['auto_db_backup_gc'] * 3600;
			}
		}

		// We do this here to prevent the Auto Backup running twice
		$this->config->set('auto_db_backup_next_gc', $next_cron_backup, true);

		// Need to include this file for the get_usable_memory() function
		if (!function_exists('get_usable_memory'))
		{
			// Need to use "real path" as using dots in the path could fail
			$file_name = $this->filesystem->realpath($this->root_path) . '\includes\acp\acp_database.' . $this->php_ext;
			$file_name = str_replace('\\', '/', $file_name);
			include_once($file_name);
		}

		@set_time_limit(1200);
		@set_time_limit(0);

		$tables		= $this->db_tools->sql_list_tables();
		$filename	= 'backup_' . $time . '_' . unique_id();
		$file_type	= $this->config['auto_db_backup_filetype'];
		$location	= $this->root_path . 'store/';
		$extractor	= $this->container->get('dbal.extractor');
		$extension 	= $this->get_extension($file_type);

		$extractor->init_extractor($file_type, $filename, $time, false, true);
		$extractor->write_start($this->table_prefix);

		foreach ($tables as $table_name)
		{
			$extractor->write_table($table_name);

			if ($this->config['auto_db_backup_optimize'])
			{
				switch ($this->db->get_sql_layer())
				{
					case 'sqlite':
					case 'sqlite3':
						$extractor->flush('DELETE FROM ' . $table_name . ";\n");
					break;

					case 'mssql':
					case 'mssql_odbc':
					case 'mssqlnative':
						$extractor->flush('TRUNCATE TABLE ' . $table_name . "GO\n");
					break;

					case 'oracle':
						$extractor->flush('TRUNCATE TABLE ' . $table_name . "/\n");
					break;

					default:
						$extractor->flush('TRUNCATE TABLE ' . $table_name . ";\n");
					break;
				}
			}
			$extractor->write_data($table_name);
		}
		$extractor->write_end();

		/**
		* Event to allow exporting of a backup file
		*
		* @event david63.autodbbackup.backup_file_export
		* @var	string	filename	The backup filename
		* @var	string	file_type	The backup file type (text, bzip2 or gzip)
		* @var	string	extension	The file extension for the file type
		* @var	string	location	The location of the backup files
		*
		* @since 2.1.0
		*/
		$vars = array(
			'filename',
			'file_type',
			'extension',
			'location',
		);
		extract($this->dispatcher->trigger_event('david63.autodbbackup.backup_file_export', compact($vars)));

		// Delete backup copies
		if ($this->config['auto_db_backup_copies'] > 0)
		{
			$dir	= opendir($location);
			$files	= [];

			while (($file = readdir($dir)) !== false)
			{
				if (is_file($location . $file) && (substr($file, -3) == '.gz' || substr($file, -4) == '.bz2' || substr($file, -4) == '.sql' ))
				{
					$files[$file] = fileatime($location . $file);
				}
			}
			closedir($dir);

			arsort($files);
			reset($files);

			if (count($files) > $this->config['auto_db_backup_copies'])
			{
				$i = 0;
				foreach ($files as $key => $val)
				{
					$i++;
					if ($i > $this->config['auto_db_backup_copies'])
					{
						@unlink($location . $key);
					}
				}
			}
		}

		// Write the log entry
		$additional_data[] = $filename . $extension;
		$additional_data[] = $this->readable_filesize($location, $filename, $extension);
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_AUTO_DB_BACKUP', time(), $additional_data);
	}

	/**
	* Get the extension type.
	*
	* @param $file_type
	*
	* @return string $extension
	*/
	protected function get_extension($file_type)
	{
		switch ($file_type)
		{
			case 'gzip':
				$extension = '.sql.gz';
			break;

			case 'bzip2':
				$extension = '.sql.bz2';
			break;

			default:
				$extension = '.sql';
			break;
		}

		return $extension;
	}

	/**
	* Format the file size into a human readable format.
	*
	* @param $file_type
	*
	* @return string
	*/
	protected function readable_filesize($location, $filename, $extension)
	{
		$bytes	= filesize($location . $filename . $extension);
		$i		= floor(log($bytes, 1024));

		return round($bytes / pow(1024, $i), [0, 0, 2, 2, 3][$i]) . $this->language->lang(['FILE_SIZE', $i]);
	}

	/**
	* Returns whether this cron task can run, given current board configuration.
	*
	* @return bool
	*/
	public function is_runnable()
	{
		return (bool) $this->config['auto_db_backup_enable'];
	}

	/**
	* Returns whether this cron task should run now, because enough time
	* has passed since it was last run.
	*
	* @return bool
	*/
	public function should_run()
	{
		if (!in_array(ini_get('date.timezone'), timezone_identifiers_list()))
		{
			// Report this in the log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_AUTO_DB_BACKUP_TIMEZONE');
			return false;
		}
		else
		{
			return $this->config['auto_db_backup_next_gc'] < time();
		}
	}
}
