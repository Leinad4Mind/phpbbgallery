<?php

namespace sitesplat\bbprofile\profile_parts\parts;

class first_post extends base
{
	public function is_enabled($profile_fields)
	{
		return $this->config['allow_avatar'];
	}

	public function is_completed($profile_fields)
	{
		return $this->user->data['user_posts'] > 0;
	}

	public function appeal_icon()
	{
		return 'first_post';
	}

	public function appeal_button()
	{
		return array(
			'label'	=> $this->language->lang('BBPROFILE_FIRST_POST_BUTTON'),
			'url'	=> append_sid($this->root_path . 'index.' . $this->php_ext),
		);
	}
}
