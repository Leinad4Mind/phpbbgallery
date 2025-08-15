<?php
/**
 *
 * BBajaxnews. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\bbajaxnews\ajaxnews;

class manager
{
	protected $config;
	protected $log;
	protected $user;
	protected $template;

	protected $types;
	protected $casual_types;
	protected $driver;
	public function __construct($ajaxnews_types, \phpbb\config\config $config, \phpbb\log\log_interface $log, \phpbb\user $user, $template)
	{
		$this->config = $config;
		$this->log = $log;
		$this->user = $user;
		$this->template = $template;

		$this->register_ajaxnews_types($ajaxnews_types);
		$this->register_driver();
	}

	public function add_ajaxnews($type, $data)
	{
		if ($this->config['sitesplat_bbajaxnews_' . $this->types[$type]->get_db_type()])
		{
			try {
				$this->driver->publish($this->types[$type]->get_receivers($data), $this->types[$type]->get_content($data));
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

	public function assign_driver_vars()
	{
		return $this->driver->assign_template_vars();
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

	protected function register_driver()
	{
		$driver_class = '\sitesplat\bbajaxnews\ajaxnews\driver\\' . $this->config['sitesplat_bbajaxnews_driver'];
		$this->driver = new $driver_class($this->config, $this->template);
	}
}
