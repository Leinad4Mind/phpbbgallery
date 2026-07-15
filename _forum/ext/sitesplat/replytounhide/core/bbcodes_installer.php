<?php
/**
 *
 * @package ReplyToUnhide
 * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
 * @license Proprietary
 *
 */

namespace sitesplat\replytounhide\core;

use phpbb\db\driver\driver_interface;
use phpbb\request\request;
use phpbb\user;

/**
 * Class bbcodes_installer
 */
class bbcodes_installer extends acp_manager
{
	protected $acp_bbcodes;
	protected $phpbb_root_path;
	protected $php_ext;

	/**
	 * Constructor
	 */
	public function __construct(driver_interface $db, request $request, user $user, $phpbb_root_path, $php_ext)
	{
		parent::__construct($db, $request, $user);

		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext         = $php_ext;

		$this->acp_bbcodes     = $this->get_acp_bbcodes();
	}

	/**
	 * Installs bbcodes, used by migrations to perform add/updates
	 */
	public function install_bbcodes(array $bbcodes)
	{
		foreach ($bbcodes as $bbcode_name => $bbcode_data)
		{
			$bbcode_data = $this->build_bbcode($bbcode_data);

			if ($bbcode = $this->bbcode_exists($bbcode_name, $bbcode_data['bbcode_tag']))
			{
				$this->update_bbcode($bbcode, $bbcode_data);
				continue;
			}

			$this->add_bbcode($bbcode_data);
		}
	}

	/**
	 * Get the acp_bbcodes class
	 */
	protected function get_acp_bbcodes()
	{
		if (!class_exists('acp_bbcodes'))
		{
			include($this->phpbb_root_path . 'includes/acp/acp_bbcodes.' . $this->php_ext);
		}

		return new \acp_bbcodes();
	}

	/**
	 * Build the bbcode
	 */
	protected function build_bbcode(array $bbcode_data)
	{
		$data = $this->acp_bbcodes->build_regexp($bbcode_data['bbcode_match'], $bbcode_data['bbcode_tpl']);

		$bbcode_data = array_replace($bbcode_data, array(
			'bbcode_tag'          => $data['bbcode_tag'],
			'first_pass_match'    => $data['first_pass_match'],
			'first_pass_replace'  => $data['first_pass_replace'],
			'second_pass_match'   => $data['second_pass_match'],
			'second_pass_replace' => $data['second_pass_replace'],
		));

		return $bbcode_data;
	}

	/**
	 * Get the max bbcode id value
	 */
	protected function get_max_bbcode_id()
	{
		return $this->get_max_column_value('bbcode_id');
	}

	/**
	 * Check if bbcode exists
	 */
	protected function bbcode_exists($bbcode_name, $bbcode_tag)
	{
		$sql = 'SELECT bbcode_id
			FROM ' . BBCODES_TABLE . "
			WHERE LOWER(bbcode_tag) = '" . $this->db->sql_escape(strtolower($bbcode_name)) . "'
			OR LOWER(bbcode_tag) = '" . $this->db->sql_escape(strtolower($bbcode_tag)) . "'";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $row;
	}

	/**
	 * Update existing bbcode
	 */
	protected function update_bbcode(array $old_bbcode, array $new_bbcode)
	{
		$sql = 'UPDATE ' . BBCODES_TABLE . '
			SET ' . $this->db->sql_build_array('UPDATE', $new_bbcode) . '
			WHERE bbcode_id = ' . (int) $old_bbcode['bbcode_id'];
		$this->db->sql_query($sql);
	}

	/**
	 * Add new bbcode
	 */
	protected function add_bbcode(array $bbcode_data)
	{
		$bbcode_id = $this->get_max_bbcode_id() + 1;

		if ($bbcode_id <= NUM_CORE_BBCODES)
		{
			$bbcode_id = NUM_CORE_BBCODES + 1;
		}

		if ($bbcode_id <= BBCODE_LIMIT)
		{
			$bbcode_data['bbcode_id'] = (int) $bbcode_id;
			$bbcode_data['display_on_posting'] = (int) !array_key_exists('display_on_posting', $bbcode_data);
			$this->db->sql_query('INSERT INTO ' . BBCODES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $bbcode_data));
		}
	}
}
