<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\loginredirect\core;

use phpbb\exception\version_check_exception;
use phpbb\extension\manager;

class functions
{
	protected $ext_manager;
	protected $metadata_flat;

	public function __construct(manager $ext_manager)
	{
		$this->ext_manager = $ext_manager;
	}

	public function get_ext_namespace($mode = 'php')
	{
		$extension_name = substr(__NAMESPACE__, 0, strrpos(__NAMESPACE__, '\\'));
		return str_replace('\\', $mode === 'twig' ? '_' : '/', $extension_name);
	}

	public function version_check()
	{
		try
		{
			$metadata_manager = $this->ext_manager->create_extension_metadata_manager($this->get_ext_namespace());
			$version_data = $this->ext_manager->version_check($metadata_manager, false, false, null);
		}
		catch (version_check_exception $exception)
		{
			$version_data = array('current' => 'fail');
		}
		return is_array($version_data) ? $version_data : array();
	}

	public function get_meta($key)
	{
		if ($this->metadata_flat === null)
		{
			$metadata_manager = $this->ext_manager->create_extension_metadata_manager($this->get_ext_namespace());
			$this->metadata_flat = array();
			foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($metadata_manager->get_metadata('all'))) as $metadata_key => $value)
			{
				$this->metadata_flat[$metadata_key] = $value;
			}
		}
		return array_key_exists($key, $this->metadata_flat) ? $this->metadata_flat[$key] : '';
	}
}
