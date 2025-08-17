<?php
/**
*
* @package sitesplat BBcore
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
/**
* Path to the helper versioncheck
*/
	protected $host = 'sitesplat.com';
	protected $path = 'phpBB3/versioncheck';
//  protected $host = 'sitesplat.xyz';
//	protected $path = 'phpBB320/versioncheck';
	protected $config;
	protected $db;
	protected $user;
	protected $template;
	protected $phpbb_extension_manager;
	protected $cache;
	protected $file_downloader;
	protected $phpbb_root_path;

	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\template\template $template, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\cache\service $cache, \phpbb\file_downloader $file_downloader, $phpbb_root_path)
	{
		$this->config = $config;
		$this->db = $db;
		$this->user = $user;
		$this->template = $template;
		$this->extension_manager = $phpbb_extension_manager;
		$this->cache = $cache;
		$this->file_downloader = $file_downloader;
		$this->root_path = $phpbb_root_path;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_styles_action_before' 	=> 'version_check',
			'core.acp_main_notice'				=> 'version_check',
			'core.acp_extensions_run_action'		=> 'run_action',
			'core.acp_extensions_run_action_before'	=> 'run_action'
		);
	}

	public function version_check($event)
	{
		$event_number = array_search($event->getName(), array_keys($this->getSubscribedEvents()));

		$sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE style_copyright LIKE '© SiteSplat.com%'";
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$cfg_ary = parse_cfg_file($this->root_path . 'styles/' . strtoupper($row['style_name']) . '/style.cfg');
			$data = $this->get_data($row['style_name']);
	
			if (isset($data['version']))
			{
				if ($event_number)
				{
					(version_compare($cfg_ary['style_version'], $data['version'] , '<')) ? 
							$this->template->assign_block_vars('sitesplat_themes', array(
								'NEW_BOOTS_VERSION'	=> sprintf($this->user->lang['NEW_BOOTS_VERSION'], strtoupper($row['style_name'])),
								'VERSIONNUMBERS'	=> sprintf($this->user->lang['VERSIONNUMBERS'], $cfg_ary['style_version'], $data['download_url'], $data['version']),
								'MSG'				=> $data['changelog']
							)) :
							null;
				} else
				{
					$this->template->assign_block_vars('sitesplat_themes', array(
						'NAME'				=> strtoupper($row['style_name']),
						'VERSION'			=> $cfg_ary['style_version'],
						'DOWNLOAD_MSG'		=> sprintf($this->user->lang['DOWNLOAD_MSG'], $data['version'], $data['download_url'], $data['title']),
						'CHANGE_LOG'		=> addslashes($data['changelog']),
						'CHANGE_LOG_MSG'	=> sprintf($this->user->lang['CHANGE_LOG_MSG'], $data['changelog_url'], $data['title']),
						'SUPPORT_FORUM_MSG'	=> sprintf($this->user->lang['SUPPORT_FORUM_MSG'], $data['support_forum']),
					));
				}
			}
		}
	}

	protected function get_data($what = '')
	{
		$cache_file = '_versioncheck_' . $this->host . $this->path . $what;

		if (($info = $this->cache->get($cache_file)) === false)
		{
			try
			{
				$info = $this->file_downloader->get($this->host, '/' . $this->path, $what);
			}
			catch (\phpbb\exception\runtime_exception $exception)
			{
				$info = '';
			}

			$info = json_decode($info, true);
			if (!empty($info))
			{
				$json_sanitizer = function (&$value, $key) {
					$type_cast_helper = new \phpbb\request\type_cast_helper();
					$type_cast_helper->set_var($value, $value, gettype($value), true);
				};
				array_walk_recursive($info, $json_sanitizer);
				$this->cache->put($cache_file, $info, 86400);
			}
		}

		return $info;
	}

	public function run_action($event)
	{
		$this->template->assign_vars(array(
			'DISABLE_ALL'		=> $event['u_action'] . '&action=disable-all',
		));

		if ($event['action'] == 'disable-all')
		{
			$safe_time_limit = (ini_get('max_execution_time') / 2);
			$start_time = time();
			$enabled_extensions = $this->extension_manager->all_enabled();
			unset($enabled_extensions['forumhulp/helper'], $enabled_extensions['sitesplat/BBCore']);
			foreach ($enabled_extensions as $ext_name => $value)
			{
				while ($this->extension_manager->disable_step($ext_name))
				{
					if ((time() - $start_time) >= $safe_time_limit)
					{
						meta_refresh(0, $this->u_action . '&amp;action=disable-all');
					}
				}
			}
		}
	}
}
