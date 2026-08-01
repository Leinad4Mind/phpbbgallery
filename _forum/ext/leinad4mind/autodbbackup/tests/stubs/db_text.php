<?php

namespace phpbb\config;

class db_text
{
	public $values = array();

	public function get($key)
	{
		return isset($this->values[$key]) ? $this->values[$key] : null;
	}

	public function set($key, $value)
	{
		$this->values[$key] = $value;
	}
}
