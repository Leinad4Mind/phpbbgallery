<?php
/*
* @package cBB Debugger
* @version v1.0.0 21/06/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\debugger\libraries;

use Symfony\Component\Config\ConfigCache;

class config
{
	static $instance;

	protected $data;
	protected $cache_object;

	public function __construct()
	{
		$root_path 	= str_replace('ext/' . str_replace('\\', '/', __NAMESPACE__), '', str_replace('\\', '/', __DIR__));
		$filename 	= $root_path . 'cache/' . PHPBB_ENVIRONMENT . '/debugger_config.php';

		$this->data 		= array();
		$this->cache_object = new ConfigCache($filename, false);

		if($this->cache_object->isFresh())
		{
			require($this->cache_object->getPath());
		}
	}

	public function get($key)
	{
		return isset($this->data[$key]) ? $this->data[$key] : null;
	}

	public function get_all()
	{
		return $this->data;
	}

	public function set($key, $value = null)
	{
		$data = is_array($key) ? $key : array($key => $value);
		
		foreach($data as $key => $value)
		{
			$this->data[$key] = $value;
		}

		return $this;
	}

	public function destroy()
	{
		$this->data = array();
		@unlink($this->cache_object->getPath());
		@unlink($this->cache_object->getPath() . '.meta');
	}

	public function save()
	{
		$content = '<?php
/**
 * This file has been auto-generated.
 */

';

		$content .= "\$this->data = unserialize('" . serialize($this->data) . "');";

		$this->cache_object->write($content);

		return $this;
	}

	public static function instance()
	{
		if(!self::$instance)
		{
			self::$instance = new self();
		}

		return self::$instance;
	}
}