<?php

/**
 *
 * Hide Profile Fields To Groups. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2020, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\hideprofilefieldstogroups;

use phpbb\group\helper;
use phpbb\profilefields\manager;

class profilefields_manager extends manager
{
	/** @var helper */
	protected $group_helper;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $table_profilefieldgroups;

	/**
	 * @param helper $group_helper
	 */
	public function set_group_helper(helper $group_helper)
	{
		$this->group_helper = $group_helper;
	}

	/**
	 * @param string $root_path
	 */
	public function set_root_path($root_path)
	{
		$this->root_path = $root_path;
	}

	/**
	 * @param string $php_ext
	 */
	public function set_php_ext($php_ext)
	{
		$this->php_ext = $php_ext;
	}

	/**
	 * @param string $table_profilefieldgroups
	 */
	public function set_table_profilefieldgroups($table_profilefieldgroups)
	{
		$this->table_profilefieldgroups = $table_profilefieldgroups;
	}

	/**
	 * Build profile cache, used for display
	 */
	protected function build_cache()
	{
		$this->profile_cache = [];

		// Display hidden/no_view fields for admin/moderator
		$sql = 'SELECT l.*, f.*
			FROM ' . $this->fields_lang_table . ' l, ' . $this->fields_table . ' f
			WHERE l.lang_id = ' . $this->user->get_iso_lang_id() . '
				AND f.field_active = 1 ' .
				((!$this->auth->acl_gets('a_', 'm_') && !$this->auth->acl_getf_global('m_')) ? ' AND f.field_hide = 0 ' : '') . '
				AND ' . $this->db->sql_in_set('f.field_id', $this->hidden_profilefields(), true, true) . '
				AND f.field_no_view = 0
				AND l.field_id = f.field_id
			ORDER BY f.field_order';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->profile_cache[$row['field_ident']] = $row;
		}
		$this->db->sql_freeresult($result);
	}

	/**
	 * @return array
	 */
	protected function hidden_profilefields()
	{
		if (!function_exists('group_memberships'))
		{
			include($this->root_path . 'includes/functions_user.' . $this->php_ext);
		}

		$groups = group_memberships(false, $this->user->data['user_id']); //Any Group
		//$groups = [$this->user->data['group_id']]; //Default Groups
		$group_ids = array_column($groups, 'group_id');

		return $this->get_profilefields($group_ids);
	}

	/**
	 * @param $group_ids
	 * @return array
	 */
	public function get_profilefields(array $group_ids)
	{
		if (!$group_ids)
		{
			return [];
		}

		$sql_ary = [
			'SELECT'	=> 'pfg.field_id',
			'FROM'		=> [$this->table_profilefieldgroups => 'pfg'],
			'WHERE'		=> $this->db->sql_in_set('pfg.group_id', array_map('intval', $group_ids)),
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		return array_unique(array_column($rows, 'field_id'));
	}

	/**
	 * @param int $field_id
	 * @return array
	 */
	public function get_profilefieldgroups($field_id)
	{
		$sql_ary = [
			'SELECT'	=> 'g.group_id, g.group_name, pfg.group_id AS hidden',
			'FROM'		=> [GROUPS_TABLE => 'g'],
			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [$this->table_profilefieldgroups => 'pfg'],
					'ON'	=> 'pfg.group_id = g.group_id AND pfg.field_id = ' . (int) $field_id,
				],
			],
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$groups = [];

		foreach ($rows as $row)
		{
			$groups[] = [
				'id'		=> $row['group_id'],
				'name'		=> $this->group_helper->get_name($row['group_name']),
				'is_hidden'	=> !empty($row['hidden']),
			];
		}

		return $groups;
	}

	/**
	 * @param int $field_id
	 * @param array $groups
	 */
	public function set_profilefieldgroups($field_id, array $groups)
	{
		$sql = 'DELETE FROM ' . $this->table_profilefieldgroups . '
			WHERE field_id = ' . (int) $field_id;
		$this->db->sql_query($sql);

		$insert_groups = [];

		foreach ($groups as $group)
		{
			$insert_groups[] = [
				'field_id' => (int) $field_id,
				'group_id' => $group,
			];
		}

		$this->db->sql_multi_insert($this->table_profilefieldgroups, $insert_groups);
	}
}
