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
		return $this->language->lang('BBPROFILE_CPF_TEXT', $this->language->lang($this->data['lang_name']));
	}

	public function appeal_icon()
	{
		return $this->data['field_ident'];
	}

	public function appeal_button()
	{
		return array(
			'label'	=> $this->language->lang('BBPROFILE_CPF_BTN_LABEL', $this->language->lang($this->data['lang_name'])),
			'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
		);
	}
}
