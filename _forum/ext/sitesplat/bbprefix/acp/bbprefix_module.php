<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\acp;

class bbprefix_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $config, $request, $phpbb_container;
		$this->db		= $db;
		$this->user		= $user;
		$this->template	= $template;
		$this->config	= $config;
		$this->cache	= $phpbb_container->get('cache.driver');
		$this->request	= $request;
		$manager		= $phpbb_container->get('bbprefix.manager');

		$submit			= (bool) $this->request->is_set_post('submit');
		$prefix_id		= (int) $this->request->variable('prefix_id', 0);

		$form_key		= 'acp_prefixed';
		add_form_key($form_key);

		switch ($mode)
		{
			default:
			case 'prefixes':
				// Set up the page
				$this->tpl_name = 'acp_bbprefix';
				$this->template->assign_vars([
					'L_TITLE'			=> $this->user->lang('ACP_BBPREFIX_MANAGE'),
					'L_TITLE_EXPLAIN'	=> $this->user->lang('ACP_BBPREFIX_MANAGE_EXPLAIN'),
					'U_ACTION'			=> $this->u_action
				]);

				// Dragging and dropping the list submits through its own
				// button (submit_reorder), so it never collides with the
				// "add new prefix" row sharing the same <form> and action
				// field.
				if ($this->request->is_set_post('submit_reorder'))
				{
					$order = explode(',', $this->request->variable('bbprefix_order', ''));
					$manager->reorder_prefixes($order);
					trigger_error($this->user->lang('PREFIX_REORDERED_SUCCESS') . adm_back_link($this->u_action));
				}

				$action	= $this->request->variable('action', 'list');
				$prefix_id = $this->request->variable('prefix_id', 0);
				$prefix = $prefix_id ? new \sitesplat\bbprefix\core\bbprefix($this->db, $this->cache, $this->template, $prefix_id) : [];

				switch ($action)
				{
					case 'details':
						$this->user->add_lang_ext('sitesplat/bbprefix', 'info_acp_bbprefix');
						$phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/bbprefix');
						$this->tpl_name = 'acp_ext_details';
					break;

					case 'add':
							$this->template->assign_vars([
								'PREFIX_NAME'	=> $this->request->variable('prefix_name', '', true),
								'PREFIX_PREFIX'	=> $this->request->variable('prefix_prefix', '', true),
								'PREFIX_FORUMS'	=>  make_forum_select(0, 0, 0, 1),
								'BBPREFIX_FORUMS_EXCLUDE' => true,
								'ACTION'		=> $action
							]);

							$this->assign_usergroups_block([]);
							$this->assign_categories_block(0);

					case 'edit':
						// Declared unconditionally, not just inside the
						// $submit branch below, so the sizeof($error) checks
						// further down can never see it undefined.
						$error = [];

						if ($submit)
						{
							$prefix = [];
							foreach (['prefix', 'name', 'forums', 'groups', 'on_index', 'is_suffix'] as $prefix_key)
							{
								$prefix[$prefix_key] = (in_array($prefix_key, ['prefix', 'name', 'on_index', 'is_suffix']) ?
														$this->request->variable('prefix_' . $prefix_key, '', true ) :
														json_encode($this->request->variable('prefix_' . $prefix_key, array(0))));
							}
							$prefix['category_id'] = (int) $this->request->variable('prefix_category', 0);
							$prefix['forums_exclude'] = (int) ($this->request->variable('prefix_forums_mode', 'exclude') !== 'include');

							$uid = $bitfield = $options = '';
							$allow_bbcode = true;
							$allow_smilies = $allow_urls = false;
							generate_text_for_storage($prefix['prefix'], $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);

							$prefix['bbcode_uid'] = $uid;
							$prefix['bbcode_bitfield'] = $bitfield;

							$error = $manager->validate_prefix($prefix, $action);

							if (!sizeof($error))
							{
								// Update or insert the prefix in the database
								$sql = ($action === 'add') ? 'INSERT INTO ' . BBPREFIX_TABLE . ' ' . $this->db->sql_build_array('INSERT', $prefix) :
										'UPDATE ' . BBPREFIX_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $prefix) . ' WHERE id = ' . (int) $prefix_id;
								$this->db->sql_query($sql);

								$manager->clear_prefix_cache();
								trigger_error($this->user->lang('PREFIX_' . strtoupper($action) . 'ED_SUCCESS') . adm_back_link($this->u_action));
							}
						}

						// If the form was submitted and there was an error
						// or the form was not submitted and we are editing
						if ($submit && sizeof($error))
						{
							$error = implode('<br />', $error);
							$this->template->assign_vars([
								'S_ERROR'	=> true,
								'ERROR_MSG'	=> $error,
							]);
						}

						// If the form has not been submitted, and we're editing a prefix, prefill the form with current data
						if ((!$submit || sizeof($error)) && $action === 'edit')
						{
							$prefix['prefix'] = generate_text_for_edit($prefix['prefix'], $prefix['bbcode_uid'], OPTION_FLAG_BBCODE)['text'];

							$this->template->assign_vars([
								'PREFIX_ID'			=> $prefix_id,
								'PREFIX_PREFIX'		=> isset($prefix['prefix']) ? $prefix['prefix'] : '',
								'PREFIX_NAME'		=> isset($prefix['name']) ? $prefix['name'] : '',
								'BBPREFIX_ON_INDEX'	=> $prefix['on_index'],
								'BBPREFIX_IS_SUFFIX'	=> !empty($prefix['is_suffix']),
								'BBPREFIX_FORUMS_EXCLUDE' => !isset($prefix['forums_exclude']) || $prefix['forums_exclude'],
								'PREFIX_FORUMS'		=> make_forum_select(json_decode($prefix['forums'], true), 0, 0, 1),
								'ACTION'			=> $action
							]);

							$this->assign_usergroups_block(json_decode($prefix['groups'], true));
							$this->assign_categories_block(isset($prefix['category_id']) ? $prefix['category_id'] : 0);
						}
					break;

					case 'delete':
						if ($prefix_id)
						{
							if ($prefix->exists())
							{
								if (confirm_box(true))
								{
									// Format: table => prefix ID column
									$tables = [
										BBPREFIX_INSTANCES_TABLE => 'prefix',
										BBPREFIX_TABLE => 'id',
									];

									foreach ($tables as $table => $column)
									{
										// Delete all instances of this prefix
										$sql = 'DELETE FROM ' . $table . '
											WHERE ' . $column . ' = ' . (int) $prefix_id;
										$this->db->sql_query($sql);
									}

									$manager->clear_prefix_cache();
									trigger_error('PREFIX_DELETED_SUCCESS');
								}
								else
								{
									$s_hidden_fields = build_hidden_fields([
										'submit'    => true,
									]);

									//display mode
									confirm_box(false, 'DELETE_PREFIX', $s_hidden_fields);
								}
							}
						}

						trigger_error('NO_PREFIX_ID_SPECIFIED');
					break;

					case 'list':
						$this->template->assign_vars([
							'S_LIST'	=> true,
							'U_ACTION'	=> $this->u_action
						]);
						$prefixes = $manager->get_prefixes();

						if (false !== $prefixes)
						{
							$sql = 'SELECT prefix, COUNT(id) AS total FROM ' . BBPREFIX_INSTANCES_TABLE .  ' GROUP BY prefix';
							$result = $this->db->sql_query($sql);
							while ($row = $this->db->sql_fetchrow($result))
							{
								$prefix_total[$row['prefix']] = $row['total'];
							}
							$i = 0;
							foreach ($prefixes as $prefix)
							{
								$object = (new \sitesplat\bbprefix\core\bbprefix(
									$this->db, $this->cache, $this->template, (int) $prefix['id']
								))->parse('prefix', [
									'ID'		=> $prefix['id'],
									'NR'		=> ++$i,
									'GROUPS'	=> (isset($prefix['groupnames'])) ? implode(',', $prefix['groupnames']) : '',
									'FORUMS'	=> (isset($prefix['forumnames'])) ? implode(',', $prefix['forumnames']) : '',
									'CATEGORY'	=> (isset($prefix['category_name'])) ? $prefix['category_name'] : '',
									'TYPE'		=> !empty($prefix['is_suffix']) ? $this->user->lang('BBPREFIX_SUFFIX') : $this->user->lang('BBPREFIX_PREFIX'),
									'USED'		=> (isset($prefix_total[$prefix['id']])) ? $prefix_total[$prefix['id']] : 0,
									'U_DELETE'	=> $this->u_action . '&amp;action=delete&amp;prefix_id=' . $prefix['id'],
									'U_EDIT'	=> $this->u_action . '&amp;action=edit&amp;prefix_id=' . $prefix['id']
								]);
							}
					//	Max 9 or will mess the prefix order in topics - issue with jQurey Serialize
					//		$this->template->assign_vars(['PREFIX_MAX' => ($i >= 9) ? true: false]);
						}
					break;

					case 'categories':
						$this->template->assign_vars([
							'S_CATEGORIES_LIST'	=> true,
							'U_ACTION'			=> $this->u_action,
						]);

						$sql = 'SELECT c.category_id, c.category_name, COUNT(p.id) AS used
							FROM ' . BBPREFIX_CATEGORIES_TABLE . ' c
							LEFT JOIN ' . BBPREFIX_TABLE . ' p ON p.category_id = c.category_id
							GROUP BY c.category_id, c.category_name
							ORDER BY c.category_name ASC';
						$result = $this->db->sql_query($sql);
						$i = 0;
						while ($row = $this->db->sql_fetchrow($result))
						{
							$this->template->assign_block_vars('category', [
								'NR'			=> ++$i,
								'CATEGORY_ID'	=> $row['category_id'],
								'CATEGORY_NAME'	=> $row['category_name'],
								'USED'			=> $row['used'],
								'U_EDIT'		=> $this->u_action . '&amp;action=category_edit&amp;category_id=' . $row['category_id'],
								'U_DELETE'		=> $this->u_action . '&amp;action=category_delete&amp;category_id=' . $row['category_id'],
							]);
						}
						$this->db->sql_freeresult($result);
					break;

					case 'category_add':
					case 'category_edit':
						$category_id = (int) $this->request->variable('category_id', 0);
						$this->template->assign_vars([
							'S_CATEGORY_FORM'	=> true,
							'CATEGORY_ACTION'	=> $category_id ? 'category_edit' : 'category_add',
							'CATEGORY_ID'		=> $category_id,
						]);

						if ($submit)
						{
							$category_name = $this->request->variable('category_name', '', true);
							if ($category_name === '')
							{
								trigger_error($this->user->lang('BBPREFIX_CATEGORY_EMPTY_ERROR') . adm_back_link($this->u_action . '&amp;action=categories'), E_USER_WARNING);
							}

							$data = ['category_name' => $category_name];
							$sql = $category_id
								? 'UPDATE ' . BBPREFIX_CATEGORIES_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $data) . ' WHERE category_id = ' . $category_id
								: 'INSERT INTO ' . BBPREFIX_CATEGORIES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $data);
							$this->db->sql_query($sql);

							$manager->clear_prefix_cache();
							trigger_error($this->user->lang('BBPREFIX_CATEGORY_SAVED_SUCCESS') . adm_back_link($this->u_action . '&amp;action=categories'));
						}

						if ($category_id)
						{
							$sql = 'SELECT category_name FROM ' . BBPREFIX_CATEGORIES_TABLE . ' WHERE category_id = ' . $category_id;
							$result = $this->db->sql_query($sql);
							$row = $this->db->sql_fetchrow($result);
							$this->db->sql_freeresult($result);

							$this->template->assign_vars([
								'CATEGORY_NAME'	=> isset($row['category_name']) ? $row['category_name'] : '',
							]);
						}
					break;

					case 'category_delete':
						$category_id = (int) $this->request->variable('category_id', 0);
						if ($category_id)
						{
							if (confirm_box(true))
							{
								// Deleting a category never blocks on, or
								// cascade-deletes, the prefixes that
								// reference it - it just clears them back to
								// "no category".
								$sql = 'UPDATE ' . BBPREFIX_TABLE . ' SET category_id = 0 WHERE category_id = ' . $category_id;
								$this->db->sql_query($sql);
								$sql = 'DELETE FROM ' . BBPREFIX_CATEGORIES_TABLE . ' WHERE category_id = ' . $category_id;
								$this->db->sql_query($sql);

								$manager->clear_prefix_cache();
								trigger_error($this->user->lang('BBPREFIX_CATEGORY_DELETED_SUCCESS') . adm_back_link($this->u_action . '&amp;action=categories'));
							}
							else
							{
								confirm_box(false, 'DELETE_CATEGORY', build_hidden_fields([
									'category_id'	=> $category_id,
									'action'		=> 'category_delete',
								]));
							}
						}

						trigger_error('NO_CATEGORY_ID_SPECIFIED');
					break;

					case 'settings':
						if ($submit)
						{
							$this->config->set('bbprefix_min_selected', (int) $this->request->variable('bbprefix_min_selected', 0));
							$this->config->set('bbprefix_max_selected', (int) $this->request->variable('bbprefix_max_selected', 0));
							trigger_error($this->user->lang('CONFIG_UPDATED') . adm_back_link($this->u_action . '&amp;action=settings'));
						}

						$this->template->assign_vars([
							'S_SETTINGS_FORM'		=> true,
							'BBPREFIX_MIN_SELECTED'	=> (int) $this->config['bbprefix_min_selected'],
							'BBPREFIX_MAX_SELECTED'	=> (int) $this->config['bbprefix_max_selected'],
						]);
					break;
				}
			break;

				trigger_error('NO_MODE', E_USER_ERROR);
			break;
		}
	}

	/**
	 * Populate the usergroups multi-select used by the prefix add/edit form.
	 *
	 * @param array $selected_groups Group IDs already assigned to the prefix
	 * @return void
	 */
	private function assign_usergroups_block(array $selected_groups)
	{
		$sql = 'SELECT group_id, group_type, group_name	FROM ' . GROUPS_TABLE . ' ORDER BY group_name ASC';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('usergroups', array(
				'GROUP_ID'		=> $row['group_id'],
				'GROUP_NAME'	=> ($row['group_type'] == GROUP_SPECIAL) ? $this->user->lang('G_' . $row['group_name']) : $row['group_name'],
				'SELECTED'		=> (in_array($row['group_id'], $selected_groups)) ? ' selected="selected"' : ''
			));
		}
		$this->db->sql_freeresult($result);
	}

	/**
	 * Populate the category dropdown used by the prefix add/edit form.
	 *
	 * @param int $selected_category_id 0 for "no category"
	 * @return void
	 */
	private function assign_categories_block($selected_category_id)
	{
		$sql = 'SELECT category_id, category_name FROM ' . BBPREFIX_CATEGORIES_TABLE . ' ORDER BY category_name ASC';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('categories', [
				'CATEGORY_ID'	=> $row['category_id'],
				'CATEGORY_NAME'	=> $row['category_name'],
				'SELECTED'		=> ((int) $row['category_id'] === (int) $selected_category_id) ? ' selected="selected"' : '',
			]);
		}
		$this->db->sql_freeresult($result);
	}
}
