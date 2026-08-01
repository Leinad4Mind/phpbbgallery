<?php
/**
 *
 * @package Auto db Backup
 * @copyright (c) 2015 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\autodbbackup\core;

use phpbb\exception\version_check_exception;
use phpbb\extension\manager;

/**
 * Shared extension helpers.
 */
class functions
{
	/** @var manager */
	protected $ext_manager;

	/** @var string */
	protected $namespace;

	/** @var array|null */
	protected $metadata;

	/** @var array|null */
	protected $metadata_flat;

	/**
	 * @param manager $ext_manager Extension manager
	 */
	public function __construct(manager $ext_manager)
	{
		$this->ext_manager = $ext_manager;
		$this->namespace = __NAMESPACE__;
	}

	/**
	 * Get the extension namespace in the requested notation.
	 *
	 * @param string $mode php or twig
	 *
	 * @return string
	 */
	public function get_ext_namespace($mode = 'php')
	{
		$extension_name = substr($this->namespace, 0, strrpos($this->namespace, '\\'));

		if ($mode === 'twig')
		{
			return str_replace('\\', '_', $extension_name);
		}

		return str_replace('\\', '/', $extension_name);
	}

	/**
	 * Check for an extension update using phpBB's cached version checker.
	 *
	 * @return array
	 */
	public function version_check()
	{
		$version_data = array();

		try
		{
			$metadata_manager = $this->ext_manager->create_extension_metadata_manager($this->get_ext_namespace());
			$version_data = $this->ext_manager->version_check($metadata_manager, false, false, null);
		}
		catch (version_check_exception $exception)
		{
			$version_data['current'] = 'fail';
		}

		return is_array($version_data) ? $version_data : array();
	}

	/**
	 * Get a flattened metadata value.
	 *
	 * @param string $key Metadata key
	 *
	 * @return mixed|string
	 */
	public function get_meta($key)
	{
		if ($this->metadata_flat === null)
		{
			$metadata_manager = $this->ext_manager->create_extension_metadata_manager($this->get_ext_namespace());
			$this->metadata = $metadata_manager->get_metadata('all');
			$this->metadata_flat = array();

			foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->metadata)) as $metadata_key => $value)
			{
				$this->metadata_flat[$metadata_key] = $value;
			}
		}

		return array_key_exists($key, $this->metadata_flat) ? $this->metadata_flat[$key] : '';
	}

	/**
	 * Check whether PHP and phpBB satisfy every declared constraint.
	 *
	 * @return array
	 */
	public function ext_requirements()
	{
		return array(
			$this->matches_constraints(PHP_VERSION, htmlspecialchars_decode((string) $this->get_meta('php'))),
			$this->matches_constraints(PHPBB_VERSION, htmlspecialchars_decode((string) $this->get_meta('phpbb/phpbb'))),
		);
	}

	/**
	 * Evaluate a comma-separated set of Composer-style comparison constraints.
	 *
	 * @param string $current Current version
	 * @param string $constraints Constraints to evaluate
	 *
	 * @return bool
	 */
	protected function matches_constraints($current, $constraints)
	{
		if (trim($constraints) === '')
		{
			return false;
		}

		foreach (explode(',', $constraints) as $constraint)
		{
			$constraint = trim(str_replace('@dev', '', $constraint));
			if (!preg_match('#^(<=|>=|!=|==|=|<|>)?\s*([0-9][0-9A-Za-z._+\-]*)$#', $constraint, $matches))
			{
				return false;
			}

			$operator = $matches[1] !== '' ? $matches[1] : '>=';
			$operator = $operator === '=' ? '==' : $operator;
			if (!phpbb_version_compare($current, $matches[2], $operator))
			{
				return false;
			}
		}

		return true;
	}
}
