<?php
/**
 *
 * @package ACP Version Check
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\acpversioncheck\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Kernel;
use Twig\Environment;
use phpbb\config\config;
use phpbb\template\template;
use phpbb\language\language;
use devspace\acpversioncheck\core\functions;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var config */
	protected $config;

	/** @var template */
	protected $template;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var language */
	protected $language;

	/** @var functions */
	protected $functions;

	/**
	 * Constructor for listener
	 *
	 * @param config		$config     Config object
	 * @param template		$template   Template object
	 * @param string		root_path   phpBB root path
	 * @param language		$language   Language object
	 * @param functions		functions   Functions for the extension
	 *
	 * @access public
	 */
	public function __construct(config $config, template $template, string $root_path, language $language, functions $functions)
	{
		$this->config    	= $config;
		$this->template  	= $template;
		$this->root_path 	= $root_path;
		$this->language  	= $language;
		$this->functions	= $functions;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.acp_main_notice' => 'check_versions',
		];
	}

	/**
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function check_versions($event)
	{
		$this->language->add_lang('acpversioncheck', $this->functions->get_ext_namespace());

		$version_check 		= true;
		$const_version 		= PHPBB_VERSION;
		$db_version    		= $this->config['version'];
		$symfony_version	= Kernel::VERSION;
		$twig_version 		= Environment::VERSION;
		$is_phpbb_4			= ($const_version[0] === '4') ? true : false;

		// Check const & config versions
		$version_check = phpbb_version_compare($db_version, $const_version, '=');

		// Get style names & versions
		$style_versions = [];
		$style          = new \DirectoryIterator($this->root_path . 'styles');

		foreach ($style as $style_info)
		{
			if ($style_info->isDir() && !$style_info->isDot() && $style_info->getFilename() != 'all')
			{
				// Get style info for phpBB 3.x
				if (!$is_phpbb_4)
				{
					$style_file = fopen($this->root_path . 'styles/' . $style_info->getFilename() . '/style.cfg', 'r');

					// Set the variables just in case one, or both, are missing in the .cfg files (this should never happen)
					$style_name = $style_version = $this->language->lang('MISSING');

					while ($line = fgets($style_file))
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
				}
				else
				{
					// Get style info for phpBB 4.x
					if (is_readable($this->root_path . 'styles/' . $style_info->getFilename() . '/composer.json'))
					{
						$style_file 	= json_decode(file_get_contents($this->root_path . 'styles/' . $style_info->getFilename() . '/composer.json'), true);
						$style_name 	= $style_file['extra']['display-name'];
						$style_version	= $style_file['version'];

						// Let's check the style version here rather than looping through later
						$check_version = phpbb_version_compare($db_version, $style_version, '=');
						$version_check = ($check_version == false) ? false : $version_check;
					}
					else
					{
						$style_name 	= $style_info->getFilename();
						$style_version	= $this->language->lang('NOT_VALID_STYLE');
						$version_check	= false;
					}
				}

				$style_versions[] = [
					'name' 		=> $style_name,
					'version'	=> $style_version,
				];
			}
		}

		foreach ($style_versions as $key => $row)
		{
			$this->template->assign_block_vars('style_versions', [
				'STYLE_NAME' 	=> $row['name'],
				'STYLE_VERSION'	=> $row['version'],
			]);
		}

		// Get the language versions - only available in phpBB 4.x
		if ($is_phpbb_4)
		{
			$lang_versions = [];
			$lang          = new \DirectoryIterator($this->root_path . 'language');

			foreach ($lang as $lang_info)
			{
				if ($lang_info->isDir() && !$lang_info->isDot())
				{
					if (is_readable($this->root_path . 'language/' . $lang_info->getFilename() . '/composer.json'))
					{
						$lang_file 		= json_decode(file_get_contents($this->root_path . 'language/' . $lang_info->getFilename() . '/composer.json'), true);

						$lang_iso		= $lang_file['extra']['language-iso'];
						$lang_name		= $lang_file['extra']['local-name'];
						$lang_version	= $lang_file['version'];

						// Let's check the language version here rather than looping through later
						$check_version = phpbb_version_compare($db_version, $lang_version, '=');
						$version_check = ($check_version == false) ? false : $version_check;
					}
					else
					{
						$lang_iso		= $lang_info->getFilename();
						$lang_name		= $lang_info->getFilename();
						$lang_version	= $this->language->lang('NOT_VALID_LANG');
						$version_check	= false;
					}

					$lang_versions[] = [
						'iso' 		=> $lang_iso,
						'name' 		=> $lang_name,
						'version' 	=> $lang_version,
				   	];
				}
			}

			foreach ($lang_versions as $key => $row)
			{
				$this->template->assign_block_vars('lang_versions', [
					'LANG_ISO'		=> $row['iso'],
					'LANG_NAME' 	=> $row['name'],
					'LANG_VERSION'	=> $row['version'],
				]);
			}
		}

		// Output template data
		$this->template->assign_vars([
			'CONSTANT_VERSION' 		=> $const_version,

			'DB_VERSION' 			=> $db_version,

			'NAMESPACE'				=> $this->functions->get_ext_namespace('twig'),

			'S_ACP_VERSIONCHECK'	=> $version_check,
			'S_PHPBB_4'				=> $is_phpbb_4,
			'SYMFONY_VERSION' 		=> $symfony_version,

			'TWIG_VERSION' 			=> $twig_version,
		]);
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
		$pos  = strpos($line, '=');
		$data = trim(substr($line, $pos + 1));

		return $data;
	}
}
