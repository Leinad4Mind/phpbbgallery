<?php
/**
*
* @package BBemoji
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbemoji\acp;

class bbemoji_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $user, $db, $template, $request, $phpbb_container;
		global $table_prefix;

		$user->add_lang('acp/posting');

		$bbemoji_listener = $phpbb_container->get('sitesplat.bbemoji.listener');

		$this->page_title = $user->lang('ACP_BBEMOJI');
		$this->tpl_name = 'bbemoji_icons';

		$icon_id = $request->variable('id', 0);
		$action = $request->variable('action', '');
		switch ($action)
		{
			case 'add':

				if ($request->is_set_post('submit', false))
				{
					$data = array(
						'icons_emoji'			=> $request->variable('icons_emoji', '') ?: $request->variable('icon', ''),
						'icons_order'			=> $this->get_max_order() + 1,
						'display_on_posting'	=> $request->variable('display_on_posting', false),
					);
					$db->sql_query('INSERT INTO ' . $table_prefix . 'emoji_icons' . $db->sql_build_array('INSERT', $data));

					trigger_error($user->lang('ICON_ADDED') . adm_back_link($this->u_action));
				}

				$template->assign_vars(array(
					'S_ADD'	=> true,
				));

			break;

			case 'edit':

				$sql = 'SELECT *
						FROM ' . $table_prefix . 'emoji_icons
						WHERE icons_id = ' . (int) $icon_id;
				$result = $db->sql_query($sql);
				if (!$db->sql_affectedrows())
				{
					trigger_error($user->lang('ICON_NOT_EXIST') . adm_back_link($this->u_action));
				}

				if ($request->is_set_post('submit', false))
				{
					$data = array(
						'icons_emoji'			=> $request->variable('icons_emoji', '') ?: $request->variable('icon', ''),
						'display_on_posting'	=> $request->variable('display_on_posting', false),
					);
					$db->sql_query('UPDATE ' . $table_prefix . 'emoji_icons SET ' . $db->sql_build_array('UPDATE', $data) . ' WHERE icons_id = ' . (int) $icon_id);

					trigger_error($user->lang('ICON_ADDED') . adm_back_link($this->u_action));
				}

				$data = $db->sql_fetchrow($result);

				$template->assign_vars(array(
					'S_EDIT'				=> true,
					'ICON_ID'				=> $data['icons_id'],
					'ICON'					=> substr($data['icons_emoji'], 0, 1) !== ':' ? $data['icons_emoji'] : '',
					'ICON_EMOJI'			=> substr($data['icons_emoji'], 0, 1) === ':' ? $data['icons_emoji'] : '',
					'DISPLAY_ON_POSTING'	=> (bool) $data['display_on_posting'],
				));

			break;

			case 'delete':

				if (confirm_box(true))
				{
					$sql = 'DELETE FROM ' . $table_prefix . 'emoji_icons
						WHERE icons_id = ' . (int) $icon_id;
					$db->sql_query($sql);

					// Reset appropriate icon_ids
					$db->sql_query('UPDATE ' . TOPICS_TABLE . '
						SET icon_id = 0
						WHERE icon_id = ' . (int) $icon_id);

					$db->sql_query('UPDATE ' . POSTS_TABLE . '
						SET icon_id = 0
						WHERE icon_id = ' . (int) $icon_id);

					$notice = $user->lang['ICONS_DELETED'];

					if ($request->is_ajax())
					{
						$json_response = new \phpbb\json_response;
						$json_response->send(array(
							'MESSAGE_TITLE'	=> $user->lang['INFORMATION'],
							'MESSAGE_TEXT'	=> $notice,
							'REFRESH_DATA'	=> array(
								'time'	=> 3
							)
						));
					}
				}
				else
				{
					confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
						'i'			=> $id,
						'mode'		=> $mode,
						'id'		=> $icon_id,
						'action'	=> 'delete',
					)));
				}

			break;

			case 'move_up':
			case 'move_down':

				if (!check_link_hash($request->variable('hash', ''), 'acp_icons'))
				{
					trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

				// Get current order id...
				$sql = 'SELECT icons_order as current_order
					FROM ' . $table_prefix . 'emoji_icons
					WHERE icons_id = ' . (int) $icon_id;
				$result = $db->sql_query($sql);
				$current_order = (int) $db->sql_fetchfield('current_order');
				$db->sql_freeresult($result);

				if ($current_order == 0 && $action == 'move_up')
				{
					break;
				}

				// on move_down, switch position with next order_id...
				// on move_up, switch position with previous order_id...
				$switch_order_id = ($action == 'move_down') ? $current_order + 1 : $current_order - 1;

				$sql = 'UPDATE ' . $table_prefix . "emoji_icons
					SET icons_order = $current_order
					WHERE icons_order = $switch_order_id
						AND icons_id <> " . (int) $icon_id;
				$db->sql_query($sql);
				$move_executed = (bool) $db->sql_affectedrows();

				// Only update the other entry too if the previous entry got updated
				if ($move_executed)
				{
					$sql = 'UPDATE ' . $table_prefix . "emoji_icons
						SET icons_order = $switch_order_id
						WHERE icons_order = $current_order
							AND icons_id = " . (int) $icon_id;
					$db->sql_query($sql);
				}

				if ($request->is_ajax())
				{
					$json_response = new \phpbb\json_response;
					$json_response->send(array(
						'success'	=> $move_executed,
					));
				}

			break;
		}

		// By default, check that icons_order is valid and fix it if necessary
		$sql = 'SELECT icons_id AS order_id, icons_order AS fields_order
			FROM ' . $table_prefix . 'emoji_icons
			ORDER BY icons_order';
		$result = $db->sql_query($sql);
		if ($row = $db->sql_fetchrow($result))
		{
			$order = 0;
			do
			{
				++$order;
				if ($row['fields_order'] != $order)
				{
					$db->sql_query('UPDATE ' . $table_prefix . "emoji_icons
						SET icons_order = $order
						WHERE icons_id = " . $row['order_id']);
				}
			}
			while ($row = $db->sql_fetchrow($result));
		}
		$db->sql_freeresult($result);

		// Display table
		$sql = 'SELECT *
				FROM ' . $table_prefix . 'emoji_icons
				ORDER BY icons_order';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			if (substr($row['icons_emoji'], 0, 1) !== ':')
			{
				$img_src = '<img src="' . generate_board_url() . '/' . $row['icons_emoji'] . '">';
			}
			else
			{
				$img_src = $bbemoji_listener->render($bbemoji_listener->parse($row['icons_emoji']));
			}

			$template->assign_block_vars('items', array(
				'IMG_SRC'		=> $img_src,
				'ALT_TEXT'		=> $row['icons_emoji'],
				'U_EDIT'		=> $this->u_action . '&amp;action=edit&amp;id=' . $row['icons_id'],
				'U_DELETE'		=> $this->u_action . '&amp;action=delete&amp;id=' . $row['icons_id'],
				'U_MOVE_UP'		=> $this->u_action . '&amp;action=move_up&amp;id=' . $row['icons_id'] . '&amp;hash=' . generate_link_hash('acp_icons'),
				'U_MOVE_DOWN'	=> $this->u_action . '&amp;action=move_down&amp;id=' . $row['icons_id'] . '&amp;hash=' . generate_link_hash('acp_icons'),
			));
		}

		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action,
			'U_BACK'		=> $this->u_action,
			'U_ICON_ADD'	=> $this->u_action . '&amp;action=add'
		));
	}

	protected function get_max_order()
	{
		global $db, $table_prefix;

		$sql = 'SELECT MAX(icons_order) AS maximum
			FROM ' . $table_prefix . 'emoji_icons';
		$result = $db->sql_query($sql);
		$maximum = $db->sql_fetchfield('maximum');
		$db->sql_freeresult($result);

		return (int) $maximum;
	}
}
