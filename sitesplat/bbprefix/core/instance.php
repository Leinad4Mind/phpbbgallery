<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\core;

class instance extends \ArrayObject
{
	use \sitesplat\bbprefix\core\loadable {
		load as _load;
	}

	protected $db;
	protected $cache;
	protected $template;
	protected $tokens;
	protected $prefix_object = null;

	public function __construct(\phpbb\db\driver\factory $db, \phpbb\cache\driver\driver_interface $cache, \phpbb\template\template $template, \phpbb\di\service_collection $tokens, $id = 0)
	{
		parent::__construct();

		$this['id'] = $id;
		$this->db = $db;
		$this->cache = $cache;
		$this->template = $template;
		$this->tokens = $tokens;

		if ($this['id'])
		{
			$this->load();
		}
	}

	/**
	 * Parse a prefix instance
	 *
	 * @param	string	$block		If given, this name will be passed to
	 *								assign_block_vars (otherwise the variables
	 *								are assigned to the template globally)
	 * @param	array	$vars		Additional template variables
	 * @param	bool	$return_parsed If true, return is the parsed prefix
	 *								otherwise, it is the plaintext version
	 * @return	 string				Plaintext prefix
	 */
	public function parse($block = '', $vars = [], $return_parsed = false)
	{
		if (!isset($this['prefix_object']) || !$this['prefix_object'] instanceof \sitesplat\bbprefix\core\bbprefix)
		{
			$this->setPrefixObject(new \sitesplat\bbprefix\core\bbprefix($this->db, $this->cache, $this->template, $this['prefix']));
		}

		if (!$this['prefix_object']->loaded() && !$this['prefix_object']->load())
		{
			return '';
		}

		foreach (json_decode($this['token_data'], true) as $data)
		{
			// If a token was used and is no longer available
			// we skip parsing it. It will show up ugly in the prefix
			// but that's not my fault.
			if (!isset($this->tokens[$data['service']]))
			{
				continue;
			}

			$this['prefix_object']['prefix'] = $this->tokens[$data['service']]->apply_token_data($this['prefix_object']['prefix'], $data['data']);
		}

		// To clarify, the second argument here is simply replacing the prefix
		// ID with the instance ID in the template, and adding the prefix ID
		// as its own PREFIX variable
		$vars = array_merge([
			'ID'		=> $this['id'],
			'PREFIX_ID' => $this['prefix_object']['id'],
			'ORDER'		=> $this['ordered'],
		], $vars);
		return $this['prefix_object']->parse($block, $vars, '', $return_parsed);
	}

	/**
	 * Load a prefix instance's data
	 * Sets the internally stored ArrayObject storage array
	 *
	 * @return bool True if the instance exists, false if it doesn't
	 */
	public function load()
	{
		if ($this->loaded())
		{
			return true;
		}
		else if (!$this['id'])
		{
			return false;
		}

		$sql = 'SELECT id, prefix, topic, token_data, ordered FROM ' . BBPREFIX_INSTANCES_TABLE . ' WHERE id = ' . (int) $this['id'];

		// Uses the load() method of the 'loadable' trait, aliased as _load()
		$row = $this->_load('_prefixes_used', $this['id'], $sql);
		foreach ($row as $key => $value)
		{
			$this[$key] = $value;
		}

		return true;
	}

	/**
	 * Set the prefix ID for this instance
	 *
	 * @param int $id
	 */
	public function setId($id) {
		$this['id'] = (int) $id;
	}

	/**
	 * Set the prefix object for this instance
	 *
	 * @param prefix $prefix
	 * @return null
	 */
	public function setPrefix($prefix) {
		$this['prefix'] = (int) $prefix;
	}

	/**
	 * Set the prefix object for this instance
	 *
	 * @param \sitesplat\bbprefix\core\prefix $prefix
	 * @return null
	 */
	public function setPrefixObject(\sitesplat\bbprefix\core\bbprefix $prefix)
	{
		$this['prefix_object'] = $prefix;
	}

	/**
	 * Set the prefix topic ID for this instance
	 *
	 * @param int $topic
	 * @return null
	 */
	public function setTopic($topic) {
		$this['topic'] = (int) $topic;
	}

	/**
	 * Set the prefix object for this instance
	 *
	 * @param prefix $prefix
	 * @return null
	 */
	public function setTokenData($token_data) {
		$this['token_data'] = $token_data;
	}

	/**
	 * Set the prefix object for this instance
	 *
	 * @param prefix $prefix
	 * @return null
	 */
	public function setOrdered($ordered) {
		$this['ordered'] = $ordered;
	}

	/**
	 * Get the instance ID
	 *
	 * @return int
	 */
	public function getId() {
		return isset($this['id']) ? $this['id'] : 0;
	}

	/**
	 * Get the prefix ID
	 *
	 * @return int
	 */
	public function getPrefix() {
		return isset($this['prefix']) ? $this['prefix'] : 0;
	}

	/**
	 * Get the prefix object
	 *
	 * @return \sitesplat\bbprefix\core\prefix
	 */
	public function getPrefixObject() {
		return isset($this['prefix_object']) ? $this['prefix_object'] : null;
	}

	/**
	 * Get the topic ID
	 *
	 * @return int
	 */
	public function getTopic() {
		return isset($this['topic']) ? $this['topic'] : 0;
	}

	/**
	 * Get the token data
	 *
	 * @return string
	 */
	public function getTokenData() {
		return isset($this['token_data']) ? $this['token_data'] : '';
	}

	/**
	 * Get the order
	 *
	 * @return int
	 */
	public function getOrdered() {
		return isset($this['ordered']) ? $this['ordered'] : 0;
	}
}
