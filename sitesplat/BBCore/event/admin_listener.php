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
use Symfony\Component\Finder\Finder;

/**
* Event listener
*/
class admin_listener implements EventSubscriberInterface
{
	protected $db;
	protected $user;
	protected $template;
	protected $phpbb_extension_manager;
	protected $cache;
	protected $file_downloader;
	protected $request;
	protected $config;
	protected $config_text;
	protected $auth;
	protected $next_step_resolver;
	protected $text_formatter_cache;
	protected $phpbb_root_path;
	protected $php_ext;
	protected $host;
	protected $path;
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\template\template $template, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\cache\service $cache, \phpbb\file_downloader $file_downloader, \phpbb\request\request $request, \phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\auth\auth $auth, \sitesplat\BBCore\updater\next_step_resolver $next_step_resolver, \phpbb\textformatter\s9e\factory $text_formatter_cache, $phpbb_root_path, $php_ext, $host, $path)
	{
		$this->db = $db;
		$this->user = $user;
		$this->template = $template;
		$this->extension_manager = $phpbb_extension_manager;
		$this->cache = $cache;
		$this->file_downloader = $file_downloader;
		$this->request = $request;
		$this->config = $config;
		$this->config_text = $config_text;
		$this->auth = $auth;
		$this->next_step_resolver = $next_step_resolver;
		$this->text_formatter_cache = $text_formatter_cache;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->host = $host;
		$this->path = $path;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_styles_action_before' 	=> [['autoupdate'], ['version_check']],
			'core.acp_main_notice'				=> 'version_check',
			'core.acp_extensions_run_action'		=> 'run_action',
			'core.acp_extensions_run_action_before'	=> 'run_action'
		);
	}

	public function autoupdate($event)
	{
		if ($event['action'] === 'autoupdate_confirm')
		{
			$this->config_text->set('sitesplat_bbcore_updater', '');
			confirm_box(false, 'AUTOUPDATE_CONFIRM', build_hidden_fields([
				'id'		=> $event['id'],
				'mode'		=> $event['mode'],
				'action'	=> 'autoupdate',
			]));
		}

		if ($event['action'] !== 'autoupdate')
		{
			return;
		}

		$u_action = append_sid($this->root_path . 'adm/index.' . $this->php_ext, 'i=acp_styles');

		if ($this->request->is_set('cancel'))
		{
			redirect($u_action);
		}

		$style_name = $this->request->variable('style', '');
		if (empty($style_name))
		{
			trigger_error($this->user->lang('STYLE_NOT_DEFINED') . adm_back_link($u_action), E_USER_WARNING);
		}

		$this->config->set('board_disable', true);

		$finished = $this->next_step_resolver->run_task($style_name);
		if ($finished === true)
		{
			// purge cache (taken from acp_main.php)
			$this->config->increment('assets_version', 1);
			$this->cache->purge();
			$this->text_formatter_cache->tidy();
			$this->auth->acl_clear_prefetch();
			phpbb_cache_moderators($this->db, $this->cache, $this->auth);

			// enable board again
			$this->config->set('board_disable', false);

			// it's done!
			trigger_error($this->user->lang('UPDATE_SUCCESS') . adm_back_link($u_action));
		}
		else
		{
			if ($finished === false)
			{
				if ($this->request->is_ajax())
				{
					$sitesplat_bbcore_updater = json_decode($this->config_text->get('sitesplat_bbcore_updater'), true);
					$response = new \phpbb\json_response;
					$response->send([
						'continue'	=> true,
						'href'		=> $u_action . '&mode=style&action=autoupdate&style=' . $style_name,
						'last_step'	=> $sitesplat_bbcore_updater['last_step'],
					]);
				}
				else
				{
					// continue after redirection
					meta_refresh(0, $u_action . '&mode=style&action=autoupdate&style=' . $style_name);
					trigger_error('UPDATE_IN_PROGRESS');
				}
			}
			else
			{
				trigger_error($this->user->lang($finished) . adm_back_link($u_action), E_USER_WARNING);
			}
		}
	}

	public function version_check($event, $eventName)
	{
		// this is incompatible with phpBB 3.3!!!
//		$event_number = array_search($event->getName(), array_keys($this->getSubscribedEvents()));

		// this is compatible...
		$event_number = array_search($eventName, array_keys($this->getSubscribedEvents()));

		$sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'";
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
								'VERSIONNUMBERS'	=> sprintf($this->user->lang['VERSIONNUMBERS'], $cfg_ary['style_version'], $data['download_url'], $data['version'], append_sid($this->root_path . 'adm/index.' . $this->php_ext, 'i=acp_styles')),
								'MSG'				=> $data['changelog']
							)) :
							null;
				} else
				{
					$this->template->assign_block_vars('sitesplat_themes', array(
						'NAME'				=> strtoupper($row['style_name']),
						'VERSION'			=> $cfg_ary['style_version'],
						'DOWNLOAD_MSG'		=> sprintf($this->user->lang['DOWNLOAD_MSG'], $data['version'], $data['download_url'], $data['title']),
						'DOWNLOAD_BTN_ENVATO'		=> sprintf($this->user->lang['DOWNLOAD_BTN_ENVATO'], $data['download_url']),
						'CHANGE_LOG'		=> addslashes($data['changelog']),
						'CHANGE_LOG_MSG'	=> sprintf($this->user->lang['CHANGE_LOG_MSG'], $data['changelog_url'], $data['title']),
						'SUPPORT_FORUM_MSG'	=> sprintf($this->user->lang['SUPPORT_FORUM_MSG'], $data['support_forum']),
						'U_AUTOUPDATE'		=> (version_compare($cfg_ary['style_version'], $data['version'] , '<') && !empty($data['direct_download_dir'])) ? append_sid($this->root_path . 'adm/index.' . $this->php_ext, 'i=acp_styles&mode=style&action=autoupdate_confirm&style=' . $row['style_name']) : false,
						'U_AUTOUPDATE_STEP'	=> (version_compare($cfg_ary['style_version'], $data['version'] , '<') && !empty($data['direct_download_dir'])) ? append_sid($this->root_path . 'adm/index.' . $this->php_ext, 'i=acp_styles&mode=style&action=autoupdate&style=' . $row['style_name']) : false,
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
				$info = $this->file_downloader->get($this->host, $this->path, $what, 443);
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
