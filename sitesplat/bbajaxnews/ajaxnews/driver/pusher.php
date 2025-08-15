<?php
/**
 *
 * BBajaxnews. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\bbajaxnews\ajaxnews\driver;

class pusher implements driver_interface
{
	protected $config;
	protected $template;
	protected $pusher;
	public function __construct(\phpbb\config\config $config, \phpbb\template\template $template)
	{
		$this->config = $config;
		$this->template = $template;

		$this->pusher = new \Pusher\Pusher($config['sitesplat_bbajaxnews_pusher_app_key'], $config['sitesplat_bbajaxnews_pusher_app_sec'], $config['sitesplat_bbajaxnews_pusher_app_id'], ['cluster' => $config['sitesplat_bbajaxnews_pusher_app_cluster'], 'encrypted' => true]);
	}

	public function publish($receivers, $data)
	{
		$this->pusher->trigger(array_column($receivers, 'session_id'), 'ajaxnews', $data);
	}

	public function assign_template_vars()
	{
		$this->template->assign_vars([
			'BBAJAXNEWS_SUB_KEY'	=> $this->config['sitesplat_bbajaxnews_pusher_app_key'],
			'BBAJAXNEWS_CLUSTER'	=> $this->config['sitesplat_bbajaxnews_pusher_app_cluster'],
		]);
	}
}
