<?php
/**
*
* @package ACP Version Check
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\acpversioncheck\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\config\config;
use phpbb\template\template;
use phpbb\language\language;
use david63\acpversioncheck\ext;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template\template */
	protected $template;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var \phpbb\language\language */
	protected $language;

	/**
	* Constructor for listener
	*
	* @param config|config				$config		Config object
	* @param template|template\template	$template	Template object
	* @param string 					root_path	phpBB root path
	* @param language|language			$language	Language object
	*
	* @access public
	*/
	public function __construct(config $config, template $template, $root_path, language $language)
	{
		$this->config		= $config;
		$this->template		= $template;
		$this->root_path	= $root_path;
		$this->language		= $language;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_main_notice' => 'check_versions',
		);
	}

	/**
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function check_versions($event)
	{
		$this->language->add_lang('acpversioncheck', 'david63/acpversioncheck');

		$version_check 	= true;
		$const_version	= PHPBB_VERSION;
		$db_version		= $this->config['version'];

		// Check const & config versions
		$version_check = phpbb_version_compare($db_version, $const_version, '=');

		// Get style names & versions
		$style_versions	= array();
		$style			= new \DirectoryIterator($this->root_path . 'styles');

		foreach ($style as $style_info)
		{
    		if ($style_info->isDir() && !$style_info->isDot() && $style_info->getFilename() != 'all')
			{
				$style_file = fopen($this->root_path . 'styles/' . $style_info->getFilename() . '/style.cfg', 'r');

				// Set the variables just in case one, or both, are missing in the .cfg files (this should never happen)
				$style_name = $style_version = $this->language->lang('MISSING');

				while($line = fgets($style_file))
				{
    				if (strpos(strtolower($line), 'name') === 0)
					{
						$style_name = $this->strip_data_from_line($line);
        				continue;
    				}

					if (strpos(strtolower($line), 'phpbb_version') === 0)
					{
						$style_version = $this->strip_data_from_line($line);
						// Let's check the version here rather than looping through later
						$check_version = phpbb_version_compare($db_version, $style_version, '=');
						$version_check = ($check_version == false) ? false : $version_check;
        				continue;
    				}
				}
				fclose($style_file);

				$style_versions[] = array(
					'name' 		=> $style_name,
					'version'	=> $style_version,
				);
    		}
		}

		foreach ($style_versions as $key => $row)
		{
			$this->template->assign_block_vars('style_versions', array(
				'STYLE_NAME'	=> $row['name'],
				'STYLE_VERSION'	=> $row['version'],
		   	));
		}

		// Output template data
		$this->template->assign_vars(array(
			'ACPVERSIONCHECK_VERSION'	=> ext::ACPVERSIONCHECK_VERSION,
			'CONSTANT_VERSION' 			=> $const_version,
			'DB_VERSION' 				=> $db_version,
			'S_ACP_VERSIONCHECK'		=> $version_check,
		));
	}

	/**
	* Clean the data
	*
	* @return string $data
	* @private
	* @access public
	*/
	private function strip_data_from_line($line)
	{
		$pos 	= strpos($line , '=');
		$data	= trim(substr($line, $pos + 1));

		return $data;
	}
}
