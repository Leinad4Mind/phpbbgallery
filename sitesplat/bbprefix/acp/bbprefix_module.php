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
		global $db, $user, $auth, $template, $config, $request, $phpbb_container, $phpbb_extension_manager, $phpbb_root_path;
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
				]);

				$action	= $this->request->variable('action', 'list');
				$prefix_id = $this->request->variable('prefix_id', 0);
				$prefix = $prefix_id ? new \sitesplat\bbprefix\core\bbprefix($this->db, $this->cache, $this->template, $prefix_id) : [];

				switch ($action)
				{
					case 'details':
						$this->user->add_lang_ext('sitesplat/bbprefix', 'info_acp_bbprefix');
						$this->user->add_lang(array('install', 'acp/extensions', 'migrator'));
						$ext_name = 'sitesplat/bbprefix';
						$md_manager = (version_compare($this->config['version'], '3.2.*', '<')) ? 
								new \phpbb\extension\metadata_manager($ext_name, $this->config, $phpbb_extension_manager, $this->template, $this->user, $phpbb_root_path) :
								new \phpbb\extension\metadata_manager($ext_name, $this->config, $phpbb_extension_manager, $this->template, $phpbb_root_path);
						try
						{
							$this->metadata = $md_manager->get_metadata('all');
						}
						catch(\phpbb\extension\exception $e)
						{
							trigger_error($e, E_USER_WARNING);
						}
			
						$md_manager->output_template_data();
			
						if (isset($this->user->lang['ext_details']))
						{
							foreach($this->user->lang['ext_details'] as $key => $value)
							{
								foreach($value as $desc)
								{
									$this->template->assign_block_vars($key, array(
										'DESCRIPTION'	=> $desc,
									));
								}
							}
						}
						try
						{
							$updates_available = $this->version_check($md_manager, $this->request->variable('versioncheck_force', false));
			
							$template->assign_vars(array(
								'S_UP_TO_DATE'		=> empty($updates_available),
								'S_VERSIONCHECK'	=> true,
								'UP_TO_DATE_MSG'	=> $this->user->lang(empty($updates_available) ? 'UP_TO_DATE' : 'NOT_UP_TO_DATE', $md_manager->get_metadata('display-name')),
							));
			
							foreach ($updates_available as $branch => $version_data)
							{
								$this->template->assign_block_vars('updates_available', $version_data);
							}
						}
						catch (\RuntimeException $e)
						{
							$this->template->assign_vars(array(
								'S_VERSIONCHECK_STATUS'			=> $e->getCode(),
								'VERSIONCHECK_FAIL_REASON'		=> ($e->getMessage() !== $this->user->lang('VERSIONCHECK_FAIL')) ? $e->getMessage() : '',
							));
						}
			
						if ($this->request->is_ajax())
						{
							$this->template->assign_vars(array(
								'IS_AJAX'				=> true,
							));
						} else
						{
							$this->template->assign_vars(array(
								'U_BACK'				=> $this->u_action,
							));
						}
			
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

							$error = $manager->validate_prefix($prefix);

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
								'PREFIX_PREFIX'		=> isset($prefix['prefix']) ? $prefix['prefix'] : '',
								'PREFIX_NAME'		=> isset($prefix['name']) ? $prefix['name'] : '',
								'BBPREFIX_ON_INDEX'	=> $prefix['on_index'],
								'PREFIX_FORUMS'		=>  make_forum_select(json_decode($prefix['forums'], true), 0, 0, 1),
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
						}
					break;
				}
			break;

				trigger_error('NO_MODE', E_USER_ERROR);
			break;
		}
	}

	/**
	* Check the version and return the available updates.
	*
	* @param \phpbb\extension\metadata_manager $md_manager The metadata manager for the version to check.
	* @param bool $force_update Ignores cached data. Defaults to false.
	* @param bool $force_cache Force the use of the cache. Override $force_update.
	* @return string
	* @throws RuntimeException
	*/
	protected function version_check(\phpbb\extension\metadata_manager $md_manager, $force_update = false, $force_cache = false)
	{
		global $cache, $config, $user;
		$meta = $md_manager->get_metadata('all');

		if (!isset($meta['extra']['version-check']))
		{
			throw new \RuntimeException($this->user->lang('NO_VERSIONCHECK'), 1);
		}

		$version_check = $meta['extra']['version-check'];

		if (version_compare($config['version'], '1.0.0', '>'))
		{
			$version_helper = new \phpbb\version_helper($cache, $config, new \phpbb\file_downloader(), $user);
		}
		else
		{
			$version_helper = new \phpbb\version_helper($cache, $config, $user);
		}
		$version_helper->set_current_version($meta['version']);
		$version_helper->set_file_location($version_check['host'], $version_check['directory'], $version_check['filename']);
		$version_helper->force_stability($config['extension_force_unstable'] ? 'unstable' : null);

		return $updates = $version_helper->get_suggested_updates($force_update, $force_cache);
	}
}
