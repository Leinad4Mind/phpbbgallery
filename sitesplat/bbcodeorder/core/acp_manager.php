<?php
/**
*
* BBcode Order+
*
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbcodeorder\core;

class acp_manager
{
	protected $db;
	protected $request;
	protected $user;
	protected $default_bbcodes_table;
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\user $user, $default_bbcodes_table)
	{
		$this->db = $db;
		$this->request = $request;
		$this->user = $user;
		$this->default_bbcodes_table = $default_bbcodes_table;
	}

	public function add_new_divider()
	{
		$sql = 'INSERT INTO ' . $this->default_bbcodes_table . '
				VALUES (' . ($this->get_max_column_value('bbcode_id') + 1) . ', "-", 1, 0, "")';
		$this->db->sql_query($sql);

		$this->resynchronize_bbcode_order();
	}

	public function delete_divider()
	{
		$bbcode_id = $this->request->variable('bbcode', 0);

		// Is it divider?
		$sql = 'SELECT bbcode_tag
				FROM ' . $this->default_bbcodes_table . '
				WHERE bbcode_id = ' . (int) $bbcode_id;
		$this->db->sql_query($sql);
		$bbcode_tag = $this->db->sql_fetchfield('bbcode_tag');


		if ($bbcode_tag == '-')
		{
			$sql = 'DELETE FROM ' . $this->default_bbcodes_table . '
					WHERE bbcode_id = ' . (int) $bbcode_id;
			$this->db->sql_query($sql);
		}
		else
		{
			$sql = 'UPDATE ' . $this->default_bbcodes_table . '
					SET display_on_posting = 0
					WHERE bbcode_id = ' . (int) $bbcode_id;
			$this->db->sql_query($sql);
		}
	}

	public function show_default_bbcode()
	{
		$bbcode_id = $this->request->variable('id', 0);
		$sql = 'UPDATE ' . $this->default_bbcodes_table . '
				SET display_on_posting = 1
				WHERE bbcode_id = ' . (int) $bbcode_id;
		$this->db->sql_query($sql);
	}

	public function move($action)
	{
		$bbcode_id = $this->request->variable('id', 0);
		$bbcode_table = $this->request->variable('is_default', false) ? $this->default_bbcodes_table : BBCODES_TABLE;

		if (!check_link_hash($this->request->variable('hash', ''), $action . $bbcode_id))
		{
			trigger_error($this->user->lang('FORM_INVALID'), E_USER_WARNING);
		}

		// Get current order
		$sql = 'SELECT bbcode_tag, bbcode_order
			FROM ' . $bbcode_table . "
			WHERE bbcode_id = $bbcode_id";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$current_tag = $row['bbcode_tag'];
		$current_order = (int) $row['bbcode_order'];
		$this->db->sql_freeresult($result);

		// We can't allow '-' to go below '--'
		if (($current_tag == '-' && $action == 'move_down') || ($current_tag == '--' && $action == 'move_up'))
		{
			// Get next bbcode
			$sql = 'SELECT bbcode_tag
					FROM ' . $this->default_bbcodes_table . '
					WHERE bbcode_order = ' . ($current_order + $this->increment($action));
			$this->db->sql_query($sql);
			$next_bbcode = $this->db->sql_fetchfield('bbcode_tag');

			if (($next_bbcode == '--' && $action == 'move_down') || ($next_bbcode == '-' && $action == 'move_up'))
			{
				$this->send_json_response(false);
			}
		}

		// First one can't be moved up
		if ($current_order <= 1 && $action == 'move_up')
		{
			return;
		}

		$order_total = $current_order * 2 + $this->increment($action);

		// Update the db
		$this->db->sql_transaction('begin');
		$sql = 'UPDATE ' . BBCODES_TABLE . '
			SET bbcode_order = ' . $order_total . ' - bbcode_order
			WHERE ' . $this->db->sql_in_set('bbcode_order', array(
				$current_order,
				$current_order + $this->increment($action),
			));
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . $this->default_bbcodes_table . '
			SET bbcode_order = ' . $order_total . ' - bbcode_order
			WHERE ' . $this->db->sql_in_set('bbcode_order', array(
				$current_order,
				$current_order + $this->increment($action),
			));
		$this->db->sql_query($sql);
		$this->db->sql_transaction('commit');

		$this->resynchronize_bbcode_order();

		$this->send_json_response(true);
	}

	public function drag_drop()
	{
		if (!$this->request->is_ajax())
		{
			return;
		}

		// Get the bbcodes html table's name
		$tablename = $this->request->variable('tablename', '');
		$is_default = $this->request->variable('is_default', false);

		// Fetch the posted list
		$bbcodes_list = $this->request->variable($tablename, array(0 => ''));

		// Make sure that every "-" is before "--"
		$sql = 'SELECT bbcode_id, bbcode_tag
				FROM ' . $this->default_bbcodes_table . '
				WHERE bbcode_tag = "-"
					OR bbcode_tag = "--"';
		$result = $this->db->sql_query($sql);
		$ids_ary = $this->db->sql_fetchrowset($result);
		$selectbox_id = $ids_ary[array_search('--', array_column($ids_ary, 'bbcode_tag'))]['bbcode_id'];
		$divider_ids = array();
		foreach ($ids_ary as $id)
		{
			if ($id['bbcode_tag'] == '-')
			{
				$divider_ids[] = $id['bbcode_id'] . '_true';
			}
		}
		$selectbox_position = array_search($selectbox_id . '_true', $bbcodes_list);
		$items_after_selecbox = array_slice($bbcodes_list, $selectbox_position + 1);
		if (array_intersect($items_after_selecbox, $divider_ids))
		{
			$this->send_json_response(false);
		}

		$this->db->sql_transaction('begin');
		// Run through the list
		foreach ($bbcodes_list as $order => $bbcode_data)
		{
			// First one is the header, skip it
			if ($order == 0)
			{
				continue;
			}

			list($bbcode_id, $is_default) = explode('_', $bbcode_data);

			if ($is_default == 'true')
			{
				$this->db->sql_query($this->update_default_bbcode_order($bbcode_id, $order));
			}
			else
			{
				$this->db->sql_query($this->update_bbcode_order($bbcode_id, $order));
			}
		}
		$this->db->sql_transaction('commit');

		$this->resynchronize_bbcode_order();

		$this->send_json_response(true);
	}

	public function get_max_bbcode_order()
	{
		return $this->get_max_column_value('bbcode_order');
	}

	public function get_bbcode_group_form_data()
	{
		$bbcode_group = $this->request->variable('bbcode_group', array(0));
		$bbcode_group = (!sizeof($bbcode_group)) ? $this->request->variable('bbcode_group', '') : implode(',', $bbcode_group);

		return $bbcode_group;
	}

	public function get_bbcode_group_data($bbcode_id)
	{
		$sql = 'SELECT bbcode_group
			FROM ' . BBCODES_TABLE . '
			WHERE bbcode_id = ' . (int) $bbcode_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return explode(',', $row['bbcode_group']);
	}

	public function get_bbcode_groups_data()
	{
		$sql = 'SELECT bbcode_tag, bbcode_group
			FROM ' . BBCODES_TABLE . "
			WHERE bbcode_group > ''";
		$result = $this->db->sql_query($sql);
		$groups = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$groups[$row['bbcode_tag']] = $row['bbcode_group'];
		}
		$this->db->sql_freeresult($result);

		return $groups;
	}

	public function bbcode_group_select_options($select_id = false)
	{
		// Get all groups except bots
		$sql = 'SELECT group_id, group_name, group_type
			FROM ' . GROUPS_TABLE . "
			WHERE group_name <> 'BOTS'
			ORDER BY group_name ASC";
		$result = $this->db->sql_query($sql);

		$group_options = '';
		while ($row = $this->db->sql_fetchrow($result))
		{
			$selected = (is_array($select_id)) ? ((in_array($row['group_id'], $select_id)) ? ' selected="selected"' : '') : (($row['group_id'] == $select_id) ? ' selected="selected"' : '');
			$group_options .= '<option value="' . $row['group_id'] . '"' . $selected . '>' . (($row['group_type'] == GROUP_SPECIAL) ? $this->user->lang('G_' . $row['group_name']) : $row['group_name']) . '</option>';
		}
		$this->db->sql_freeresult($result);

		return $group_options;
	}

	public function resynchronize_bbcode_order()
	{
		$this->db->sql_transaction('begin');
		// By default, check that order is valid and fix it if necessary
		$sql = 'SELECT bbcode_id, bbcode_order, FALSE as bbcode_default
			FROM ' . BBCODES_TABLE . '
			UNION ALL
			SELECT bbcode_id, bbcode_order, TRUE as bbcode_default
			FROM ' . $this->default_bbcodes_table . '
			ORDER BY bbcode_order, bbcode_id';
		$result = $this->db->sql_query($sql);
		if ($row = $this->db->sql_fetchrow($result))
		{
			$order = 0;
			do
			{
				// pre-increment $order
				++$order;

				if ($row['bbcode_order'] != $order)
				{
					if ($row['bbcode_default'])
					{
						$this->db->sql_query($this->update_default_bbcode_order($row['bbcode_id'], $order));
					}
					else
					{
						$this->db->sql_query($this->update_bbcode_order($row['bbcode_id'], $order));
					}
				}
			}
			while ($row = $this->db->sql_fetchrow($result));
		}
		$this->db->sql_freeresult($result);
		$this->db->sql_transaction('commit');
	}

	protected function update_default_bbcode_order($bbcode_id, $bbcode_order)
	{
		return 'UPDATE ' . $this->default_bbcodes_table . '
			SET bbcode_order = ' . (int) $bbcode_order . '
			WHERE bbcode_id = ' . (int) $bbcode_id;
	}

	protected function update_bbcode_order($bbcode_id, $bbcode_order)
	{
		return 'UPDATE ' . BBCODES_TABLE . '
			SET bbcode_order = ' . (int) $bbcode_order . '
			WHERE bbcode_id = ' . (int) $bbcode_id;
	}

	protected function increment($action)
	{
		return ($action == 'move_up') ? -1 : 1;
	}

	protected function get_max_column_value($column)
	{
		$sql = 'SELECT MAX(' . $this->db->sql_escape($column) . ') AS maximum
			FROM ' . $this->default_bbcodes_table;
		$result = $this->db->sql_query($sql);
		$maximum = $this->db->sql_fetchfield('maximum');
		$this->db->sql_freeresult($result);

		return (int) $maximum;
	}

	protected function send_json_response($content)
	{
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'success' => (bool) $content,
			));
		}
	}
}
