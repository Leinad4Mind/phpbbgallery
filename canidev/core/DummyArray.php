<?php
/**
 * @package Ext Common Core
 * @version 1.1.2 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\core;

/**
 * Creates an array that always have values,
 * never throws an error for a non-existent key
 */
class DummyArray extends \ArrayObject
{
	protected $data = [];

	/**
	 * Constructor
	 * @param array 	$data 	Dummy data
	 */
	public function __construct($data = [])
	{
		$this->data = $data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function count()
	{
		return sizeof($this->data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getArrayCopy()
	{
		return $this->data;
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
