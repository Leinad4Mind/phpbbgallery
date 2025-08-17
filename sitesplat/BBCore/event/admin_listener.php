<?php
/**
*
* BBCore.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class admin_listener implements EventSubscriberInterface
{
	protected $config;
	protected $db;
	protected $user;
	protected $template;
	protected $phpbb_root_path;

	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\template\template $template, $phpbb_root_path)
	{
		$this->config = $config;
		$this->db = $db;
		$this->user = $user;
		$this->template = $template;
		$this->root_path = $phpbb_root_path;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_styles_action_before' => 'version_info',
		);
	}

	public function version_info()
	{
		$sitesplat_themes = array('bboots', 'flatboots');

		foreach ($sitesplat_themes as $sitesplat_theme)
		{
			if (file_exists($this->root_path . 'styles/' . strtoupper($sitesplat_theme) . '/style.cfg'))
			{
				$cfg_ary = parse_cfg_file($this->root_path . 'styles/' . strtoupper($sitesplat_theme) . '/style.cfg');

				if ($cfg_ary)
				{
					$version = (!empty($cfg_ary[$sitesplat_theme])) ? $cfg_ary[$sitesplat_theme] : '0.0.0';

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, 'http://www.sitesplat.com/updatecheck/phpbb31/'.$sitesplat_theme.'.txt');
					curl_setopt($ch, CURLOPT_HEADER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

					$contents = curl_exec($ch);
					$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					curl_close($ch);

					if ($http >= 400) $contents = '';

					$this->template->assign_block_vars('sitesplat_themes', array(
						'NAME'		=> strtoupper($sitesplat_theme),
						'VERSION'	=> $version,
						'MSG'		=> $contents
					));
				}
			}
		}
	}
}
