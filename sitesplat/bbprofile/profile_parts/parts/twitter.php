<?php

namespace sitesplat\bbprofile\profile_parts\parts;

class twitter extends base
{
	public function is_enabled($profile_fields)
	{
		return array_key_exists('phpbb_twitter', $profile_fields) && $this->auth->acl_get('u_chgprofileinfo');
	}

	public function is_completed($profile_fields)
	{
		return !empty($profile_fields['phpbb_twitter']['value']);
	}

	public function appeal_icon()
	{
		return 'twitter';
	}

	public function appeal_button()
	{
		return array(
			'label'	=> $this->language->lang('BBPROFILE_TWITTER_BUTTON'),
			'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_twitter'),
		);
	}
}
