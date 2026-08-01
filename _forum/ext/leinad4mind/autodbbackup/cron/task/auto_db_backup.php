<?php
/**
 * @package Auto db Backup
 * @copyright (c) 2015 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\autodbbackup\cron\task;

use leinad4mind\autodbbackup\core\backup_policy;
use leinad4mind\autodbbackup\core\backup_registry;
use leinad4mind\autodbbackup\core\functions;
use phpbb\config\config;
use phpbb\cron\task\base;
use phpbb\db\tools\tools_interface;
use phpbb\event\dispatcher_interface;
use phpbb\filesystem\filesystem;
use phpbb\language\language;
use phpbb\log\log;
use phpbb\user;
use Symfony\Component\DependencyInjection\ContainerInterface;

/** Create and retain automatic phpBB database backups. */
class auto_db_backup extends base
{
	/** @var string */
	protected $root_path;
	/** @var string */
	protected $php_ext;
	/** @var string */
	protected $table_prefix;
	/** @var config */
	protected $config;
	/** @var language */
	protected $language;
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
	/** @var backup_registry */
	protected $backup_registry;

	/**
	 * @param string               $root_path phpBB root path
	 * @param string               $php_ext phpBB file extension
	 * @param string               $table_prefix phpBB table prefix
	 * @param config               $config Config object
	 * @param language             $language Language object
	 * @param log                  $log phpBB log
	 * @param user                 $user User object
	 * @param ContainerInterface   $container Service container
	 * @param dispatcher_interface $dispatcher Event dispatcher
	 * @param tools_interface      $db_tools Database tools
	 * @param functions            $functions Extension helpers
	 * @param filesystem           $filesystem Filesystem service
	 * @param backup_registry      $backup_registry Owned backup registry
	 */
	public function __construct(string $root_path, string $php_ext, string $table_prefix, config $config, language $language, log $log, user $user, ContainerInterface $container, dispatcher_interface $dispatcher, tools_interface $db_tools, functions $functions, filesystem $filesystem, backup_registry $backup_registry)
	{
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->table_prefix = $table_prefix;
		$this->config = $config;
		$this->language = $language;
		$this->log = $log;
		$this->user = $user;
		$this->container = $container;
		$this->dispatcher = $dispatcher;
		$this->db_tools = $db_tools;
		$this->functions = $functions;
		$this->filesystem = $filesystem;
		$this->backup_registry = $backup_registry;
	}

	/** Run the backup task. */
	public function run()
	{
		$started_at = time();
		$location = $this->root_path . 'store/';
		$temp_path = '';
		$extractor = null;
		$extractor_open = false;
		$error_handler_installed = false;

		$this->language->add_lang(array('acp_autobackup', 'info_acp_autodbbackup'), $this->functions->get_ext_namespace());

		try
		{
			$interval = (int) $this->config['auto_db_backup_gc'];
			$copies = (int) $this->config['auto_db_backup_copies'];
			$enabled = (int) $this->config['auto_db_backup_enable'];
			$maintain = (int) $this->config['auto_db_backup_maintain_freq'];
			$file_type = (string) $this->config['auto_db_backup_filetype'];
			backup_policy::validate_settings($interval, $copies, $enabled, $maintain, $file_type, $this->get_available_file_types());

			$next_run = backup_policy::calculate_next_run($started_at, (int) $this->config['auto_db_backup_next_gc'], $interval, (bool) $maintain);
			$this->include_database_helpers();
			@set_time_limit(1200);

			$tables = backup_policy::filter_tables($this->db_tools->sql_list_tables(), $this->table_prefix);
			if (!$tables)
			{
				throw new \RuntimeException('AUTO_DB_BACKUP_NO_TABLES');
			}

			$identifier = unique_id();
			$temp_base = 'autodbbackup_tmp_' . $started_at . '_' . $identifier;
			$final_base = 'backup_' . $started_at . '_' . $identifier;
			$extension = $this->get_extension($file_type);
			$temp_path = $location . $temp_base . $extension;
			$final_filename = $final_base . $extension;
			$final_path = $location . $final_filename;
			$marker = 'AUTO_DB_BACKUP_COMPLETE:' . $identifier;

			set_error_handler(function ($severity, $message, $file, $line)
			{
				if (!(error_reporting() & $severity))
				{
					return false;
				}

				throw new \ErrorException($message, 0, $severity, $file, $line);
			});
			$error_handler_installed = true;

			$extractor = $this->container->get('dbal.extractor');
			$extractor->init_extractor($file_type, $temp_base, $started_at, false, true);
			$extractor_open = true;
			$extractor->write_start($this->table_prefix);

			foreach ($tables as $table_name)
			{
				$extractor->write_table($table_name);
				$extractor->write_data($table_name);
			}

			$extractor->flush("\n-- " . $marker . "\n");
			$extractor->write_end();
			$extractor_open = false;
			$this->verify_backup($temp_path, $file_type, $marker);
			restore_error_handler();
			$error_handler_installed = false;

			$this->filesystem->rename($temp_path, $final_path, false);
			$temp_path = '';
			$metadata = $this->backup_registry->record($location, $final_filename, time());

			try
			{
				$this->backup_registry->prune($location, $copies);
			}
			catch (\Throwable $exception)
			{
				$this->add_failure_log('LOG_AUTO_DB_BACKUP_PRUNE_FAILED', $exception);
			}

			$this->config->set('auto_db_backup_next_gc', $next_run, true);
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_AUTO_DB_BACKUP', time(), array($final_filename, get_formatted_filesize($metadata['size'])));

			try
			{
				/**
				 * Event to allow exporting of a verified backup file.
				 *
				 * Event return values cannot alter the local publication or retention paths.
				 *
				 * @event leinad4mind.autodbbackup.backup_file_export
				 * @var string filename  Backup filename without extension
				 * @var string file_type Backup file type (text, bzip2 or gzip)
				 * @var string extension Backup filename extension
				 * @var string location  Location of backup files
				 * @since 2.1.0
				 * @changed 3.2.0 Runs only after verified publication and cannot mutate local paths
				 */
				$event_data = array(
					'filename'  => $final_base,
					'file_type' => $file_type,
					'extension' => $extension,
					'location'  => $location,
				);
				$this->dispatcher->trigger_event('leinad4mind.autodbbackup.backup_file_export', $event_data);
			}
			catch (\Throwable $exception)
			{
				$this->add_failure_log('LOG_AUTO_DB_BACKUP_EXPORT_FAILED', $exception);
			}
		}
		catch (\Throwable $exception)
		{
			if ($extractor_open && $extractor !== null)
			{
				try
				{
					$extractor->write_end();
				}
				catch (\Throwable $close_exception)
				{
					// Preserve the original error.
				}
			}

			if ($error_handler_installed)
			{
				restore_error_handler();
			}

			if ($temp_path !== '' && is_file($temp_path))
			{
				try
				{
					$this->filesystem->remove($temp_path);
				}
				catch (\Throwable $remove_exception)
				{
					// Preserve the original error.
				}
			}

			$retry_interval = min(3600, max(300, ((int) $this->config['auto_db_backup_gc']) * 60));
			$this->config->set('auto_db_backup_next_gc', time() + $retry_interval, true);
			$this->add_failure_log('LOG_AUTO_DB_BACKUP_FAILED', $exception);
		}
	}

	/** Include phpBB's database backup helper functions. */
	protected function include_database_helpers()
	{
		if (function_exists('get_usable_memory'))
		{
			return;
		}

		$root_path = $this->filesystem->realpath($this->root_path);
		if (!is_string($root_path) || $root_path === '')
		{
			throw new \RuntimeException('AUTO_DB_BACKUP_INVALID_PATH');
		}

		$helper = str_replace('\\', '/', $root_path) . '/includes/acp/acp_database.' . $this->php_ext;
		if (!is_file($helper))
		{
			throw new \RuntimeException('AUTO_DB_BACKUP_HELPER_MISSING');
		}

		include_once $helper;
	}

	/**
	 * Verify decompression to EOF and require a unique completion marker.
	 *
	 * @param string $path Backup path
	 * @param string $file_type Backup file type
	 * @param string $marker Completion marker
	 */
	protected function verify_backup($path, $file_type, $marker)
	{
		if (!is_file($path) || filesize($path) <= 0)
		{
			throw new \RuntimeException('AUTO_DB_BACKUP_VERIFY_FAILED');
		}

		$handle = $this->open_backup($path, $file_type);
		$tail = '';

		try
		{
			while (true)
			{
				$chunk = $this->read_backup_chunk($handle, $file_type);
				if ($chunk === false)
				{
					throw new \RuntimeException('AUTO_DB_BACKUP_VERIFY_FAILED');
				}

				if ($chunk === '')
				{
					break;
				}

				$tail = substr($tail . $chunk, -4096);
			}
		}
		finally
		{
			$this->close_backup($handle, $file_type);
		}

		if (strpos($tail, '-- ' . $marker) === false)
		{
			throw new \RuntimeException('AUTO_DB_BACKUP_VERIFY_FAILED');
		}
	}

	/**
	 * @param string $path Backup path
	 * @param string $file_type Backup file type
	 *
	 * @return resource
	 */
	protected function open_backup($path, $file_type)
	{
		if ($file_type === 'gzip')
		{
			$handle = gzopen($path, 'rb');
		}
		else if ($file_type === 'bzip2')
		{
			$handle = bzopen($path, 'r');
		}
		else
		{
			$handle = fopen($path, 'rb');
		}

		if ($handle === false)
		{
			throw new \RuntimeException('AUTO_DB_BACKUP_VERIFY_FAILED');
		}

		return $handle;
	}

	/**
	 * @param resource $handle Backup stream
	 * @param string   $file_type Backup file type
	 *
	 * @return string|false
	 */
	protected function read_backup_chunk($handle, $file_type)
	{
		if ($file_type === 'gzip')
		{
			return gzread($handle, 8192);
		}

		if ($file_type === 'bzip2')
		{
			return bzread($handle, 8192);
		}

		return fread($handle, 8192);
	}

	/**
	 * @param resource $handle Backup stream
	 * @param string   $file_type Backup file type
	 */
	protected function close_backup($handle, $file_type)
	{
		if ($file_type === 'gzip')
		{
			gzclose($handle);
		}
		else if ($file_type === 'bzip2')
		{
			bzclose($handle);
		}
		else
		{
			fclose($handle);
		}
	}

	/** @return array */
	protected function get_available_file_types()
	{
		$file_types = array('text');

		if (extension_loaded('zlib'))
		{
			$file_types[] = 'gzip';
		}

		if (extension_loaded('bz2'))
		{
			$file_types[] = 'bzip2';
		}

		return $file_types;
	}

	/**
	 * @param string $file_type Backup file type
	 *
	 * @return string
	 */
	protected function get_extension($file_type)
	{
		$extensions = array(
			'bzip2' => '.sql.bz2',
			'gzip'  => '.sql.gz',
			'text'  => '.sql',
		);

		if (!isset($extensions[$file_type]))
		{
			throw new \InvalidArgumentException('AUTO_DB_BACKUP_FILETYPE_ERROR');
		}

		return $extensions[$file_type];
	}

	/**
	 * @param string     $log_key Language key
	 * @param \Throwable $exception Failure
	 */
	protected function add_failure_log($log_key, \Throwable $exception)
	{
		$message = $exception->getMessage();
		if ($this->language->is_set($message))
		{
			$message = $this->language->lang($message);
		}

		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, $log_key, time(), array($message));
	}

	/** @return bool */
	public function is_runnable()
	{
		return (bool) $this->config['auto_db_backup_enable'];
	}

	/** @return bool */
	public function should_run()
	{
		return (int) $this->config['auto_db_backup_next_gc'] <= time();
	}
}
