<?php

namespace sitesplat\bbprofile\profile_parts;

class cpf_part implements parts\part_interface
{
	protected $language;
	protected $root_path;
	protected $php_ext;
	protected $value = '';
	protected $data = [];
	public function __construct(\phpbb\language\language $language, $root_path, $php_ext, $value = '', $data = [])
	{
		$this->language = $language;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->value = $value;
		$this->data = $data;
	}

	public function make($value, $data)
	{
		return new self($this->language, $this->root_path, $this->php_ext, $value, $data);
	}

	public function is_enabled()
	{
		return $this->data['field_active'];
	}

	public function is_completed()
	{
		return !empty($this->value);
	}

	public function appeal_text()
	{

		if($this->data['field_ident'] == 'phpbb_interests') {
			return $this->language->lang('BBPROFILE_INTERESTS_TEXT', $this->language->lang($this->data['lang_name']));
		}

		if($this->data['field_ident'] == 'phpbb_occupation') {
			return $this->language->lang('BBPROFILE_OCCUPATION_TEXT', $this->language->lang($this->data['lang_name']));
		}

		if($this->data['field_ident'] == 'phpbb_website') {
			return $this->language->lang('BBPROFILE_WEBSITE_TEXT', $this->language->lang($this->data['lang_name']));
		}

		if($this->data['field_ident'] == 'phpbb_location') {
			return $this->language->lang('BBPROFILE_LOCATION_TEXT', $this->language->lang($this->data['lang_name']));
		}

		if($this->data['field_ident'] == 'phpbb_facebook') {
			return $this->language->lang('BBPROFILE_FACEBOOK_TEXT', $this->language->lang($this->data['lang_name']));
		}

		if($this->data['field_ident'] == 'phpbb_skype') {
			return $this->language->lang('BBPROFILE_SKYPE_TEXT', $this->language->lang($this->data['lang_name']));
		}

		if($this->data['field_ident'] == 'phpbb_twitter') {
			return $this->language->lang('BBPROFILE_TWITTER_TEXT', $this->language->lang($this->data['lang_name']));
		}

		if($this->data['field_ident'] == 'phpbb_youtube') {
			return $this->language->lang('BBPROFILE_YOUTUBE_TEXT', $this->language->lang($this->data['lang_name']));
		}

		return $this->language->lang('BBPROFILE_CPF_TEXT', $this->language->lang($this->data['lang_name']));
	}

	public function appeal_icon()
	{
		return $this->data['field_ident'];
	}

	public function appeal_button()
	{
		if($this->data['field_ident'] == 'phpbb_interests') {
			return array(
				'label'	=> $this->language->lang('BBPROFILE_INTERESTS_BUTTON', $this->language->lang($this->data['lang_name'])),
				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
			);
		}

		if($this->data['field_ident'] == 'phpbb_occupation') {
			return array(
				'label'	=> $this->language->lang('BBPROFILE_OCCUPATION_BUTTON', $this->language->lang($this->data['lang_name'])),
				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
			);
		}
		
		if($this->data['field_ident'] == 'phpbb_website') {
			return array(
				'label'	=> $this->language->lang('BBPROFILE_WEBSITE_BUTTON', $this->language->lang($this->data['lang_name'])),
				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
			);
		}

		if($this->data['field_ident'] == 'phpbb_location') {
			return array(
				'label'	=> $this->language->lang('BBPROFILE_LOCATION_BUTTON', $this->language->lang($this->data['lang_name'])),
				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
			);
		}

		if($this->data['field_ident'] == 'phpbb_facebook') {
			return array(
				'label'	=> $this->language->lang('BBPROFILE_FACEBOOK_BUTTON', $this->language->lang($this->data['lang_name'])),
				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
			);
		}
		
		if($this->data['field_ident'] == 'phpbb_skype') {
			return array(
				'label'	=> $this->language->lang('BBPROFILE_SKYPE_BUTTON', $this->language->lang($this->data['lang_name'])),
				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
			);
		}

		if($this->data['field_ident'] == 'phpbb_twitter') {
			return array(
				'label'	=> $this->language->lang('BBPROFILE_TWITTER_BUTTON', $this->language->lang($this->data['lang_name'])),
				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
			);
		}
		
		if($this->data['field_ident'] == 'phpbb_youtube') {
			return array(
				'label'	=> $this->language->lang('BBPROFILE_YOUTUBE_BUTTON', $this->language->lang($this->data['lang_name'])),
				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
			);
		}

		return array(
			'label'	=> $this->language->lang('BBPROFILE_CPF_BTN_LABEL', $this->language->lang($this->data['lang_name'])),
			'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
		);
	}
}
