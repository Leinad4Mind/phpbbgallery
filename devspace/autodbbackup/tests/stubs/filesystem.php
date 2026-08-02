<?php

namespace phpbb\filesystem;

class filesystem
{
	public $removed = array();

	public function realpath($path)
	{
		return realpath($path);
	}

	public function remove($path)
	{
		$this->removed[] = $path;
		unlink($path);
	}
}
