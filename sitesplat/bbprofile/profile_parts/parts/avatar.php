<?php

namespace sitesplat\bbprofile\profile_parts\parts;

class avatar extends base
{
	public function is_enabled()
	{
		return $this->config['allow_avatar'] && $this->auth->acl_get('u_chgavatar');
	}

	public function is_completed()
	{
		return !empty($this->user->data['user_avatar']);
	}

	public function appeal_icon()
	{
		return 'user-circle-o';
	}

	public function appeal_button()
	{
		return array(
			'label'	=> $this->language->lang('BBPROFILE_AVATAR_BUTTON'),
			'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=avatar#bbprofile_avatar'),
		);
	}
}
