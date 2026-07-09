<?php

namespace sitesplat\bbprofile\profile_parts\parts;

abstract class base implements part_interface
{
	protected $user;
	protected $language;
	protected $config;
	protected $auth;
	protected $root_path;
	protected $php_ext;
	public function __construct(\phpbb\user $user, \phpbb\language\language $language, \phpbb\config\config $config, \phpbb\auth\auth $auth, $root_path, $php_ext)
	{
		$this->user = $user;
		$this->language = $language;
		$this->config = $config;
		$this->auth = $auth;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public function appeal_text()
	{
		return $this->language->lang('BBPROFILE_' . strtoupper((new \ReflectionClass($this))->getShortName()) . '_TEXT');
	}
}