<?php

/**
 *
 * @package sitesplat BBcore
 * @copyright (c) 2020 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\BBCore\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Finder\Finder;

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
	protected $fs;
	protected $next_step_resolver;
	protected $text_formatter_cache;
	protected $phpbb_root_path;
	protected $php_ext;
	protected $host;
	protected $path;
	protected $writable = true;
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
		$this->fs = \sitesplat\fs_instance();
		$this->next_step_resolver = $next_step_resolver;
		$this->text_formatter_cache = $text_formatter_cache;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->host = $host;
		$this->path = $path;
	}
	static public function getSubscribedEvents()
	{
		$events = ['core.acp_main_notice' => 'version_check', 'core.acp_extensions_run_action' => 'run_action', 'core.acp_extensions_run_action_before' => 'run_action',];
		return $events;
	}
	public function version_check($event, $eventName)
	{
		$sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'";
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result)) {
			$cfg_ary = parse_cfg_file($this->root_path . 'styles/' . strtoupper($row['style_name']) . '/style.cfg');
			$data = $this->get_data($row['style_name']);
			if (isset($data['version']) && version_compare($cfg_ary['style_version'], $data['version'], '<')) {
				$this->template->assign_block_vars('sitesplat_themes', array('NEW_BOOTS_VERSION' => sprintf($this->user->lang['NEW_BOOTS_VERSION'], strtoupper($row['style_name'])), 'VERSIONNUMBERS' => sprintf($this->user->lang['VERSIONNUMBERS'], $cfg_ary['style_version'], $data['download_url'], $data['version'], append_sid($this->root_path . 'adm/index.php', 'i=-sitesplat-BBCore-acp-bbcore_module&amp;mode=update')), 'MSG' => $data['changelog'],));
			}
		}
	}
	protected function get_data($what = '')
	{
		$cache_file = '_versioncheck_' . $this->host . $this->path . $what;
		if (($info = $this->cache->get($cache_file)) === false) {
			try {
				$info = $this->file_downloader->get($this->host, $this->path, $what, 443);
			} catch (\phpbb\exception\runtime_exception $exception) {
				$info = '';
			}
			$info = json_decode($info, true);
			if (!empty($info)) {
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
		global $phpbb_dispatcher;
		$this->template->assign_vars(array('DISABLE_ALL' => $event['u_action'] . '&action=disable-all',));
		if ($event['action'] == 'disable-all') {
			$safe_time_limit = (ini_get('max_execution_time') / 2);
			$start_time = time();
			$enabled_extensions = $this->extension_manager->all_enabled();
			unset($enabled_extensions['forumhulp/helper'], $enabled_extensions['sitesplat/BBCore']);
			extract($phpbb_dispatcher->trigger_event('sitesplat.bbcore_ext_list', compact('enabled_extensions')));
			foreach ($enabled_extensions as $ext_name => $value) {
				while ($this->extension_manager->disable_step($ext_name)) {
					if ((time() - $start_time) >= $safe_time_limit) {
						meta_refresh(0, $event['u_action'] . '&amp;action=disable-all');
					}
				}
			}
			trigger_error($this->user->lang('CONFIG_UPDATED') . adm_back_link($event['u_action']));
		}
	}
}
