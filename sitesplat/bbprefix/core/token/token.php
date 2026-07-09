<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\core\token;

abstract class token implements token_interface
{
	protected $user;
	protected $auth;
	protected $config;
	protected $template;
	protected $db;
	protected $table_prefix;

	public function __construct(\phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\db\driver\factory $db, $table_prefix)
	{
		$this->user = $user;
		$this->auth = $auth;
		$this->config = $config;
		$this->template = $template;
		$this->db = $db;
		$this->table_prefix;
	}

	/**
	 * @inheritdoc
	 */
	public function get_token_description_lang()
	{
		return 'PREFIXED_TOKEN_' . strtoupper(basename(get_class()));
	}

	/**
	 * @inheritdoc
	 */
	public function match_token($prefix_text)
	{
		$matches = [];
		preg_match(constant(get_class($this) . '::TOKEN_REGEX'), $prefix_text, $matches);
		return $matches ?: false;
	}

	/**
	 * @inheritdoc
	 */
	public function apply_token_data($prefix_text, $data)
	{
		return false !== $this->match_token($prefix_text) ? preg_replace(constant(get_class($this) . '::TOKEN_REGEX'), $data, $prefix_text) : false;
	}
}
