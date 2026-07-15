<?php
/**
* @package Ext Common Core
* @version 1.1.0 01/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\core;

/**
 * Creates an array that always have values,
 * never throws an error for a non-existent key
 */
class dummy_array implements \ArrayAccess
{
	protected $data = array();

	/**
	 * Constructor
	 * @param array 	$data 	Dummy data
	 */
	public function __construct($data = array())
	{
		$this->data = $data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function offsetExists($key)
	{
		return isset($this->data[$key]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function offsetGet($key)
	{
		return isset($this->data[$key]) ? $this->data[$key] : '';
	}

	/**
	 * {@inheritDoc}
	 */
	public function offsetSet($key, $value)
	{
		$this->data[$key] = $value;
	}

	/**
	 * {@inheritDoc}
	 */
	public function offsetUnset($key)
	{
		if(isset($this->data[$key]))
		{
			unset($this->data[$key]);
		}
	}
}
