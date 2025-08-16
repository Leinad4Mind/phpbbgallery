<?php
/**
*
* @package phpBB Extension - Form Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace leinad4mind\formcreator\controller;

use leinad4mind\formcreator\ext;

class admin_controller
{
	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $table_formcreator;

	protected $u_action;

	/**
	* Constructor
	*
	* @param \phpbb\user						$user
	* @param \phpbb\template\template			$template
	* @param \phpbb\db\driver\driver_interface	$db
	* @param \phpbb\request\request		 		$request
	* @param string								$root_path
	* @param string								$php_ext
	* @param string								$table_formcreator
	*
	*/
	public function __construct(
		\phpbb\user $user,
		\phpbb\template\template $template,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\request\request $request,
		$root_path,
		$php_ext,
		$table_formcreator)
	{
		$this->user					= $user;
		$this->template				= $template;
		$this->db					= $db;
		$this->request 				= $request;
		$this->root_path 			= $root_path;
		$this->php_ext 				= $php_ext;
		$this->table_formcreator 	= $table_formcreator;
	}

	public function display_options()
	{
		$this->user->add_lang_ext('leinad4mind/formcreator', 'formcreator_acp');

		$form_key = 'leinad4mind/formcreator';
		add_form_key($form_key);

		$mode = $this->request->variable('mode', 'manage');
		$elements = 0;

		$form_id = $this->request->variable('form_id', $this->get_first_forum_id());
		$id = $this->request->variable('id', 0);

		$fname = $this->get_forums($form_id);

		$link 		= '<br><a href="' . append_sid("index.$this->php_ext", "i=form_creator&amp;mode=manage") . '">' . $this->user->lang['FORM_CREATOR_ACP_RETURN'] . '</a>';
		$copy_form 	= $this->request->is_set_post('copy_form');
		$update 	= $this->request->is_set_post('update');
		$addnew 	= $this->request->is_set_post('add');
		$move_up 	= $this->request->variable('move_up', '');
		$move_down 	= $this->request->variable('move_down', '');
		$delete 	= $this->request->variable('delete', '');

		if ($copy_form)
		{
			$source_forum = $this->request->variable('source_forum', 0);
			$destination_forums = $this->request->variable('destination_forums', [0 => 0]);

			if ($source_forum && $destination_forums)
			{
				$sql = 'DELETE FROM ' . $this->table_formcreator . '
					WHERE ' . $this->db->sql_in_set('form_id', $destination_forums);
				$this->db->sql_query($sql);

				$sql = 'SELECT m.*
					FROM ' . $this->table_formcreator . ' m
					WHERE m.form_id = ' . (int) $source_forum;
				$result = $this->db->sql_query($sql);
				$rows = $this->db->sql_fetchrowset($result);
				$this->db->sql_freeresult($result);

				foreach ($destination_forums as $destination_forum)
				{
					foreach (array_keys($rows) as $key)
					{
						unset($rows[$key]['id']);
						$rows[$key]['form_id'] = $destination_forum;
					}

					$this->db->sql_multi_insert($this->table_formcreator, $rows);
				}

				trigger_error($this->user->lang('COPY_FORM_SUCCESS') . adm_back_link($this->u_action), E_USER_NOTICE);
			}
		}

		if ($update)
		{
			// ignore the rest if updating //
			$addnew = $move_down = $move_up = $delete = 0;
		}

		if ($move_down || $move_up)
		{
			$form_id = $this->request->variable('form_id', 0);
			$id = $this->request->variable('id', 0);

			$sql = 'SELECT ndx_order
				FROM ' . $this->table_formcreator . '
				WHERE id =	' . $id . '
					AND form_id = ' . $form_id;
			$result = $this->db->sql_query($sql);
			$current_order = (int) $this->db->sql_fetchfield('ndx_order', 0, $result);
			$this->db->sql_freeresult($result);

			if ($move_down)
			{
				$new_order = $current_order + 1;
			}
			else
			{
				$new_order = ($current_order > 1) ? $current_order - 1 : 1;
			}

			// find current id with new order and move that one notch, if any
			$sql = 'UPDATE	' . $this->table_formcreator . '
				SET ndx_order = ' . $current_order . '
				WHERE ndx_order = ' . $new_order . '
					AND form_id = ' . $form_id;
			$this->db->sql_query($sql);

			// now increase old order
			$sql = 'UPDATE	' . $this->table_formcreator . '
				SET ndx_order = ' . $new_order . '
				WHERE id = ' . $id . '
					AND form_id = ' . $form_id;
			$this->db->sql_query($sql);
		}

		if ($delete)
		{
			if (!check_link_hash($this->request->variable('hash', ''), 'delete.' . $form_key))
			{
				trigger_error($this->user->lang('FORM_INVALID') . adm_back_link($this->u_action));
			}

			$sql = 'DELETE FROM ' . $this->table_formcreator . '
				WHERE id = ' . $id;
			$this->db->sql_query($sql);

			$form_id = $this->request->variable('form_id', 0);
		}

		//user pressed update contents
		if ($update)
		{
			if (!check_form_key($form_key))
			{
				trigger_error($this->user->lang('FORM_INVALID') . adm_back_link($this->u_action));
			}

			$q_types				= $this->request->variable('q_type', [0 => ''], true);
			$q_mandatory			= $this->request->variable('q_mandatory', [0 => 0]);
			$q_names				= $this->request->variable('q_name', [0 => ''], true);
			$q_names_visible		= $this->request->variable('q_name_visible', [0 => 0]);
			$q_explains				= $this->request->variable('q_explain', [0 => ''], true);
			$q_hint					= $this->request->variable('q_hint', [0 => ''], true);
			$q_options				= $this->request->variable('q_options', [0 => ''], true);
			$q_options_separators	= $this->request->untrimmed_variable('q_options_separator', [0 => ''], true);
			$q_mins					= $this->request->variable('q_mins', [0 => 0]);
			$q_maxs					= $this->request->variable('q_maxs', [0 => 0]);
			$q_name_before			= $this->request->untrimmed_variable('q_name_before', [0 => ''], true);
			$q_name_after			= $this->request->untrimmed_variable('q_name_after', [0 => ''], true);
			$q_value_before			= $this->request->untrimmed_variable('q_value_before', [0 => ''], true);
			$q_value_after			= $this->request->untrimmed_variable('q_value_after', [0 => ''], true);
			$form_id				= $this->request->variable('form_id', 1);
			$q_ndx_order			= $this->request->variable('q_ndx_order', [0 => ''], true);

			foreach ($q_hint as $key => $form_values)
			{
				$data = [
					'type'				=> $q_types[$key],
					'mandatory'			=> !empty($q_mandatory[$key]),
					'name'				=> $q_names[$key],
					'name_visible'		=> !empty($q_names_visible[$key]),
					'explanation'		=> $q_explains[$key],
					'hint'				=> $q_hint[$key],
					'options'			=> $q_options[$key],
					'options_separator'	=> $q_options_separators[$key],
					'min_value'			=> $q_mins[$key],
					'max_value'			=> $q_maxs[$key],
					'name_before'		=> $q_name_before[$key],
					'name_after'		=> $q_name_after[$key],
					'value_before'		=> $q_value_before[$key],
					'value_after'		=> $q_value_after[$key],
					'ndx_order' 		=> $q_ndx_order[$key]
				];

				$sql = 'UPDATE ' . $this->table_formcreator . '
					SET ' . $this->db->sql_build_array('UPDATE', $data) . '
					WHERE id = ' . (int) $key . '
						AND form_id = ' . (int) $form_id;
				$this->db->sql_query($sql);
			}

			$show_form = $this->request->variable('show_form', false);
			$force_form = $this->request->variable('force_form', false);

			$update_ary = [
				'forum_show_form'	=> $show_form ? 1 : 0,
				'forum_force_form'	=> $force_form ? 1 : 0,
			];

			$sql = 'UPDATE ' . FORUMS_TABLE . '
				SET ' . $this->db->sql_build_array('UPDATE', $update_ary) . '
				WHERE forum_id = ' . (int) $form_id;
			$this->db->sql_query($sql);

			$this->template->assign_vars([
				'L_FORM_NO_FORM'	=> $this->user->lang('FORM_NO_FORM', $fname),
				'S_SHOW_FORM'		=> $show_form,
				'S_FORCE_FORM'		=> $force_form,
			]);
		}

		if ($addnew)
		{
			if (!check_form_key($form_key))
			{
				trigger_error($this->user->lang('FORM_INVALID') . adm_back_link($this->u_action));
			}

			$form_id = $this->request->variable('form_id', 0);

			$sql = 'SELECT MAX(ndx_order) + 1 AS maxorder
				FROM ' . $this->table_formcreator . '
				WHERE form_id = ' . $form_id;
			$result = $this->db->sql_query($sql);

			$max_order = (int) $this->db->sql_fetchfield('maxorder', 0, $result);
			$this->db->sql_freeresult($result);

			$sql_ary = [
				'ndx_order' 		=> ($max_order > 0) ? $max_order : 1, // we don't use index 0 //
				'form_id'			=> $form_id,
				'name'				=> $this->request->variable('name', '', true),
				'name_visible'		=> $this->request->is_set_post('name_visible') ? 1 : 0,
				'explanation'		=> $this->request->variable('explanation', '', true),
				'hint'				=> $this->request->variable('hint', '', true),
				'options'			=> $this->request->variable('options', '', true),
				'options_separator'	=> $this->request->untrimmed_variable('options_separator', '', true),
				'min_value'			=> $this->request->variable('min_value', 0),
				'max_value'			=> $this->request->variable('max_value', 0),
				'name_before'		=> $this->request->untrimmed_variable('name_before', '', true),
				'name_after'		=> $this->request->untrimmed_variable('name_after', '', true),
				'value_before'		=> $this->request->untrimmed_variable('value_before', '', true),
				'value_after'		=> $this->request->untrimmed_variable('value_after', '', true),
				'type'				=> $this->request->variable('add_type', '', true),
				'mandatory' 		=> $this->request->is_set_post('mandatory') ? 1 : 0,
			];

			// insert new contents
			$sql = 'INSERT INTO ' . $this->table_formcreator . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
			$result = $this->db->sql_query($sql);

			if (!$result)
			{
				trigger_error($this->user->lang['FORM_CREATOR_ACP_QUESTNOTADD'] . $link, E_USER_WARNING);
			}
		}

		// main sql //
		$sql = 'SELECT m.*, f.forum_name, f.forum_id, f.forum_show_form, f.forum_force_form
			FROM ' . $this->table_formcreator . ' m, ' . FORUMS_TABLE . " f
			WHERE m.form_id = $form_id
				AND m.form_id = f.forum_id
			ORDER BY ndx_order ASC";
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('form_template', [
				'FID'				=> $row['form_id'],
				'NDX_ORDER'			=> $row['ndx_order'],
				'NAME'				=> $row['name'],
				'NAME_VISIBLE'		=> $row['name_visible'],
				'EXPLAIN'			=> $row['explanation'],
				'TYPE'				=> $row['type'],
				'HINT'				=> $row['hint'],
				'MANDATORY'			=> $row['mandatory'],
				'OPTIONS'			=> $row['options'],
				'OPTIONS_SEPARATOR'	=> $row['options_separator'],
				'MIN'				=> $row['min_value'],
				'MAX'				=> $row['max_value'],
				'NAME_BEFORE'		=> $row['name_before'],
				'NAME_AFTER'		=> $row['name_after'],
				'VALUE_BEFORE'		=> $row['value_before'],
				'VALUE_AFTER'		=> $row['value_after'],
				'ID'				=> $row['id'],
				'U_DELETE' 			=> append_sid($this->root_path . 'adm/index.' . $this->php_ext . '?sid=' . $this->user->session_id, "i=-leinad4mind-formcreator-acp-formcreator_module&mode=manage&amp;delete=1&amp;id={$row['id']}&amp;form_id={$row['form_id']}&amp;hash=" . generate_link_hash('delete.' . $form_key)),
				'U_MOVE_UP' 		=> append_sid($this->root_path . 'adm/index.' . $this->php_ext . '?sid=' . $this->user->session_id, "i=-leinad4mind-formcreator-acp-formcreator_module&mode=manage&amp;move_up=1&amp;id={$row['id']}&amp;form_id={$row['form_id']}") ,
				'U_MOVE_DOWN' 		=> append_sid($this->root_path . 'adm/index.' . $this->php_ext . '?sid=' . $this->user->session_id, "i=-leinad4mind-formcreator-acp-formcreator_module&mode=manage&amp;move_down=1&amp;id={$row['id']}&amp;form_id={$row['form_id']}"),
			]);

			$type = [
				'text',
				'textbox',
				'selectbox',
				'radiobuttons',
				'checkbox',
				'password',
				'email',
				'url',
				'file',
				'number',
				'date',
				'time',
			];

			foreach ($type as $t_name => $t_value)
			{
				$this->template->assign_block_vars('form_template.template_type', [
					'TYPE'		=> $t_value,
					'SELECTED'	=> $t_value == $row['type'] ? ' selected="selected"' : '',
				]);
				$elements++;
			}

			if ($row['forum_show_form'])
			{
				$this->template->assign_var('S_SHOW_FORM', true);
			}

			if ($row['forum_force_form'])
			{
				$this->template->assign_var('S_FORCE_FORM', true);
			}
		}

		$this->db->sql_freeresult($result);

		$this->template->assign_vars([
			'FID'			 	=> $form_id,
			'ELEMENTS'			=> $elements,
			'L_FORM_NO_FORM'	=> sprintf($this->user->lang('FORM_NO_FORM'), $fname),
			'REPORT'			=> $this->user->lang('MODE') . ' = [' . $mode . '] | ' . $this->user->lang('ELEMENTS') . ' = [' . $elements . '] | ' . $this->user->lang('FORUM_ID') . ' = [' . $form_id . '] | ' . $this->user->lang('FORM_NAME') . ' = [' . $fname . ']',
			'LINK'				=> $link,
		]);

		$this->build_preview($form_id);
		$this->build_copy_form($form_id);
	}

	private function get_forums($forum_id)
	{
		$store = '';

		$sql = 'SELECT forum_id, forum_name
			FROM ' . FORUMS_TABLE . '
			WHERE forum_type = ' . FORUM_POST . '
			ORDER BY forum_id ASC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('forms', [
				'FORUM_ID'		=> $row['forum_id'],
				'FORUM_NAME'	=> $row['forum_name'],
				'SELECT'		=> $row['forum_id'] == $forum_id ? ' selected="selected"' : '',
			]);

			if ($forum_id == $row['forum_id'])
			{
				$store = $row['forum_name'];
			}
		}
		$this->db->sql_freeresult($result);

		return $store;
	}

	private function get_first_forum_id()
	{
		$sql = 'SELECT forum_id
			FROM ' . FORUMS_TABLE . '
			WHERE forum_type = ' . FORUM_POST . '
			ORDER BY forum_id ASC';
		$result = $this->db->sql_query_limit($sql, 1);
		$forum_id = $this->db->sql_fetchfield('forum_id');
		$this->db->sql_freeresult($result);

		return (int) $forum_id;
	}

	private function build_preview($form_id)
	{
		$sql = 'SELECT m.*, f.forum_name, f.forum_id
			FROM ' . $this->table_formcreator . ' m, ' . FORUMS_TABLE . " f
			WHERE m.form_id = $form_id
				AND m.form_id = f.forum_id
			ORDER BY ndx_order ASC";
		$result = $this->db->sql_query($sql);

		$file_count = -1;

		while ($row = $this->db->sql_fetchrow($result))
		{

			if ($row['type'] == 'file')
			{
				$file_count++;
			}

			switch (strtolower($row['type']))
			{
				case 'email':
				case 'password':
				case 'url':
				case 'text':
				case 'file':
				case 'number':
				case 'date':
				case 'time':
					$type = '<input style="border-radius: 5px; width:300px" class="text" type="' . $row['type']. '" name="templatefield_' . $row['id'] . $file_count . '" placeholder="' . $row['hint'] . '" size="40" maxlength="255" tabindex="' . $row['ndx_order'] . '">';
				break;

				case 'textbox':
					$type = '<textarea style="border-radius: 5px;" class="text" name="templatefield_' . $row['id'] . '" rows="3" cols="76" tabindex="' . $row['ndx_order'] . '" onselect="storeCaret(this);" onclick="storeCaret(this);" placeholder="' . $row['hint'] . '" onkeyup="storeCaret(this);"></textarea>';
				break;
				case 'selectbox':
					$type = '<select style="border-radius: 5px;" class="inputbox" name="templatefield_' . $row['id'] . '" tabindex="' . $row['ndx_order'] . '">';
					$type .= '<option value="">----------------</option>';
					$select_option = ext::explode([',', "\n"], $row['options']);
					foreach ($select_option as $value)
					{
						$type .='<option value="'. $value .'">' . $value . '</option>';
					}
					$type .= '</select>';
				break;
				case 'radiobuttons':
					$radio_option = ext::explode([',', "\n"], $row['options']);

					$type = '';
					foreach ($radio_option as $value)
					{
						$type .= '<input type="radio" name="templatefield_' . $row['id'] . '" value="' . $value . '">&nbsp;'. $value . '&nbsp;&nbsp;';
					}
				break;
				case 'checkbox':
					$check_option = ext::explode([',', "\n"], $row['options']);

					$type = '';
					foreach ($check_option as $value)
					{
						$type .= '<input type="checkbox" name="templatefield_' . $row['id'] . '[]" value="' . $value .'">&nbsp;' . $value . '&nbsp;&nbsp;';
					}
				break;
			}

			$this->template->assign_block_vars('form_creator_template', [
				'ID'			=> $row['id'],
				'NDX_ORDER'		=> $row['ndx_order'],
				'NAME'			=> $row['name'],
				'NAME_VISIBLE'	=> $row['name_visible'],
				'EXPLAIN'		=> $row['explanation'],
				'HINT'			=> $row['hint'],
				'OPTIONS'		=> $row['options'],
				'MIN'			=> $row['min_value'],
				'MAX'			=> $row['max_value'],
				'TYPE'			=> isset($type) ? $type : '',
				'MANDATORY' 	=> $row['mandatory'] ? '<span class="mandatory">*</span>' : '',
			]);

		}
		$this->db->sql_freeresult($result);
	}

	private function build_copy_form($forum_id)
	{
		$this->template->assign_vars([
			'S_COPY_FORM_FORUMS' => make_forum_select(false, $forum_id, false, true),
		]);
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
