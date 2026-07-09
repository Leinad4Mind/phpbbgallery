<?php
/**
 * @package cBB Debugger
 * @version 1.0.2 11/03/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\debugger\libraries;

use Symfony\Component\Config\ConfigCache;

class config
{
	static $instance;

	protected $data				= [];
	protected $original_data	= [];
	protected $cache_object;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$root_path 	= str_replace('ext/' . str_replace('\\', '/', __NAMESPACE__), '', str_replace('\\', '/', __DIR__));
		$filename 	= $root_path . 'cache/' . PHPBB_ENVIRONMENT . '/debugger_config.php';

		$this->cache_object = new ConfigCache($filename, false);

		if($this->cache_object->isFresh())
		{
			require($this->cache_object->getPath());

			$this->original_data = $this->data;
		}
	}

	/**
	 * Obtain specific config value
	 * 
	 * @param string 	$key
	 * @return mixed
	 */
	public function get($key)
	{
		return isset($this->data[$key]) ? $this->data[$key] : null;
	}

	/**
	 * Obtain all config values
	 * @return array
	 */
	public function get_all()
	{
		return $this->data;
	}

	/**
	 * Obtain original config values
	 * @return array
	 */
	public function get_source()
	{
		return $this->original_data;
	}

	/**
	 * Set specific config value
	 * 
	 * @param string|array 	$key
	 * @param mixed 		$value
	 * 
	 * @return static
	 */
	public function set($key, $value = null)
	{
		$data = is_array($key) ? $key : [$key => $value];
		
		foreach($data as $key => $value)
		{
			$this->data[$key] = $value;
		}

		return $this;
	}

	/**
	 * Destroy all config values from cache
	 */
	public function destroy()
	{
		$this->data = $this->original_data = [];
		@unlink($this->cache_object->getPath());
		@unlink($this->cache_object->getPath() . '.meta');
	}

	/**
	 * Save config to cache
	 * @return static
	 */
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

	/**
	 * Get class instance
	 * @return static
	 */
	public static function instance()
	{
		if(!self::$instance)
		{
			self::$instance = new self();
		}

		return self::$instance;
	}
}