<?php

namespace sitesplat\bbprofile\profile_parts\parts;

class signature extends base
{
	public function is_enabled($profile_fields)
	{
		return $this->config['allow_sig'] && $this->auth->acl_get('u_sig');
	}

	public function is_completed($profile_fields)
	{
		return !empty($this->user->data['user_sig']);
	}

	public function appeal_icon()
	{
		return 'signature';
	}

	public function appeal_button()
	{
		return array(
			'label'	=> $this->language->lang('BBPROFILE_SIGNATURE_BUTTON'),
			'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=signature#bbprofile_signature'),
		);
	}
}
