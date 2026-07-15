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
								'ACTION'		=> $action
							]);
							
							$sql = 'SELECT group_id, group_type, group_name	FROM ' . GROUPS_TABLE . ' ORDER BY group_name ASC';
							$result = $this->db->sql_query($sql);
							while ($row = $this->db->sql_fetchrow($result))
							{
								$this->template->assign_block_vars('usergroups', array(
									'GROUP_ID'		=> $row['group_id'],
									'GROUP_NAME'	=> ($row['group_type'] == GROUP_SPECIAL) ? $this->user->lang('G_' . $row['group_name']) : $row['group_name'],
								));
							}

					case 'edit':
						if ($submit)
						{
							$error = $prefix = [];
							foreach (['prefix', 'name', 'forums', 'groups', 'on_index'] as $prefix_key)
							{
								$prefix[$prefix_key] = (in_array($prefix_key, ['prefix', 'name', 'on_index']) ?
														$this->request->variable('prefix_' . $prefix_key, '', true ) : 
														json_encode($this->request->variable('prefix_' . $prefix_key, array(0))));
							}

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
								'PREFIX_FORUMS'		=> make_forum_select(json_decode($prefix['forums'], true), 0, 0, 1),
								'ACTION'			=> $action
							]);
							
							$sql = 'SELECT group_id, group_type, group_name	FROM ' . GROUPS_TABLE . ' ORDER BY group_name ASC';
							$result = $this->db->sql_query($sql);
							while ($row = $this->db->sql_fetchrow($result))
							{
								$this->template->assign_block_vars('usergroups', array(
									'GROUP_ID'		=> $row['group_id'],
									'GROUP_NAME'	=> ($row['group_type'] == GROUP_SPECIAL) ? $this->user->lang('G_' . $row['group_name']) : $row['group_name'],
									'SELECTED'		=> (in_array($row['group_id'], json_decode($prefix['groups'], true))) ? ' selected="selected"' : ''
								));
							}
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
									'NR'		=> ++$i,
									'GROUPS'	=> (isset($prefix['groupnames'])) ? implode(',', $prefix['groupnames']) : '',
									'FORUMS'	=> (isset($prefix['forumnames'])) ? implode(',', $prefix['forumnames']) : '',
									'USED'		=> (isset($prefix_total[$prefix['id']])) ? $prefix_total[$prefix['id']] : 0,
									'U_DELETE'	=> $this->u_action . '&amp;action=delete&amp;prefix_id=' . $prefix['id'],
									'U_EDIT'	=> $this->u_action . '&amp;action=edit&amp;prefix_id=' . $prefix['id']
								]);
							}
					//	Max 9 or will mess the prefix order in topics - issue with jQurey Serialize	
					//		$this->template->assign_vars(['PREFIX_MAX' => ($i >= 9) ? true: false]);
						}
					break;
				}
			break;

				trigger_error('NO_MODE', E_USER_ERROR);
			break;
		}
	}
}
