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

class pubnub implements driver_interface
{
	protected $config;
	protected $template;
	protected $pubnub;
	public function __construct(\phpbb\config\config $config, \phpbb\template\template $template)
	{
		$this->config = $config;
		$this->template = $template;

		$pnConfiguration = new \PubNub\PNConfiguration();
		$pnConfiguration->setSubscribeKey($this->config['sitesplat_bbajaxnews_pubnub_sub']);
		$pnConfiguration->setPublishKey($this->config['sitesplat_bbajaxnews_pubnub_pub']);
		$this->pubnub = new \PubNub\PubNub($pnConfiguration);
	}

	public function publish($receivers, $data)
	{
		foreach ($receivers as $receiver)
		{
			$this->pubnub->publish()
				->channel($receiver['session_id'])
				->message([
					'message'	=> $data,
				])
				->shouldStore(false)
				->usePost(true)
				->sync();
		}
	}

	public function assign_template_vars()
	{
		$this->template->assign_vars([
			'BBAJAXNEWS_SUB_KEY'	=> $this->config['sitesplat_bbajaxnews_pubnub_sub'],
		]);
	}
}
