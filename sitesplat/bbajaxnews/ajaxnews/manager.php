<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbajaxnews\ajaxnews;

class manager
{
	protected $config;
	protected $log;
	protected $user;
	protected $pubnub;
	protected $types;
	protected $casual_types;
	public function __construct($ajaxnews_types, \phpbb\config\config $config, \phpbb\log\log_interface $log, \phpbb\user $user)
	{
		$this->config = $config;
		$this->log = $log;
		$this->user = $user;

		$pnConfiguration = new \PubNub\PNConfiguration();
		$pnConfiguration->setSubscribeKey($this->config['sitesplat_bbajaxnews_pubnub_sub']);
		$pnConfiguration->setPublishKey($this->config['sitesplat_bbajaxnews_pubnub_pub']);
		$this->pubnub = new \PubNub\PubNub($pnConfiguration);

		$this->register_ajaxnews_types($ajaxnews_types);
	}

	public function add_ajaxnews($type, $data)
	{
		if ($this->config['sitesplat_bbajaxnews_' . $this->types[$type]->get_db_type()])
		{
			try {
				foreach ($this->types[$type]->get_receivers($data) as $receiver)
				{
					$this->pubnub->publish()
						->channel($receiver['session_id'])
						->message([
							'message'	=> $this->types[$type]->get_content($data),
						])
						->shouldStore(false)
						->usePost(true)
						->sync();
				}
			}
			catch (\Exception $e)
			{
				$user_id = empty($this->user->data) ? ANONYMOUS : $this->user->data['user_id'];
				$user_ip = empty($this->user->ip) ? '' : $this->user->ip;

				$this->log->add('critical', $user_id, $user_ip, 'LOG_BBAJAXNEWS_PUBLISH_FAIL', false, [$type, $e->getMessage()]);
			}
		}
	}

	public function retrieve_casual_ajaxnews()
	{
		if (empty($this->casual_types))
		{
			return false;
		}

		$random_type = array_rand($this->casual_types);
		return $this->casual_types[$random_type]->get_content();
	}

	public function get_ajaxnews_types()
	{
		return $this->types;
	}

	protected function register_ajaxnews_types($ajaxnews_types)
	{
		foreach ($ajaxnews_types as $type)
		{
			$this->types[$type->get_type()] = $type;
			if (!$type->is_special() && $this->config['sitesplat_bbajaxnews_' . $type->get_db_type()])
			{
				$this->casual_types[$type->get_type()] = $type;
			}
		}
	}
}
