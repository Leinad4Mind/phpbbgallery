<?php

namespace sitesplat\bbprofile\profile_parts\parts;

class birthdate extends base
{
	public function is_enabled($profile_fields)
	{
		return $this->auth->acl_get('u_chgprofileinfo');
	}

	public function is_completed($profile_fields)
	{
		$empty = empty($this->user->data['user_birthday']) || $this->user->data['user_birthday'] == ' 0- 0-   0';
		return !$empty;
	}

	public function appeal_icon()
	{
		return 'birthdate';
	}

	public function appeal_button()
	{
		return array(
			'label'	=> $this->language->lang('BBPROFILE_BIRTHDATE_BUTTON'),
			'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_birtdate'),
		);
	}
}
