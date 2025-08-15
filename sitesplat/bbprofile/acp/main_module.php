<?php
/**
*
* BBbbprofile. An extension for the phpBB Forum Software package.
* @copyright (c) 2016, SiteSplat
* @license Proprietary
*
*/

namespace sitesplat\bbprofile\acp;

/**
 * BBprofile ACP module.
 */
class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main($id, $mode)
	{
		global $db, $config, $request, $template, $user, $phpbb_container, $phpbb_root_path, $phpEx;
		$config_text = $phpbb_container->get('config_text');
		$profilefields_manager = $phpbb_container->get('profilefields.manager');

		if (!class_exists('auth_admin'))
		{
			include($phpbb_root_path . 'includes/acp/auth.' . $phpEx);
		}
		$auth_admin = new \auth_admin();
		$sql = 'SELECT group_id
				FROM ' . GROUPS_TABLE . "
				WHERE group_name = '" . $db->sql_escape('ADMINISTRATORS') . "'
					OR group_name = '" . $db->sql_escape('GLOBAL_MODERATORS') . "'
				ORDER BY group_name";
		$result = $db->sql_query($sql);
		$admin_group_id = (int) $db->sql_fetchrow($result)['group_id'];
		$mod_group_id = (int) $db->sql_fetchrow($result)['group_id'];
		$db->sql_freeresult($result);

		$user->add_lang_ext('sitesplat/bbprofile', 'common');
		$this->tpl_name = 'acp_bbprofile';
		$this->page_title = $user->lang('ACP_BBPROFILE');
		add_form_key('sitesplat/bbprofile');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('sitesplat/bbprofile'))
			{
				trigger_error('FORM_INVALID');
			}

			$config->set('bbprofile_position', $request->variable('bbprofile_position', ''));
			$config_text->set('bbprofile_enabled', json_encode($request->variable('bbprofile_enabled', array(''))));

			if ($request->variable('bbprofile_hide_for_admins', 0))
			{
				$auth_admin->acl_set('group', 0, $admin_group_id, array('u_bbprofile' => 0));
			}
			else
			{
				$auth_admin->acl_set('group', 0, $admin_group_id, array('u_bbprofile' => 1));
			}
			if ($request->variable('bbprofile_hide_for_mods', 0))
			{
				$auth_admin->acl_set('group', 0, $mod_group_id, array('u_bbprofile' => 0));
			}
			else
			{
				$auth_admin->acl_set('group', 0, $mod_group_id, array('u_bbprofile' => 1));
			}

			trigger_error($user->lang('BBPROFILE_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		$enabled_parts = json_decode($config_text->get('bbprofile_enabled'));
		foreach ($phpbb_container->get('sitesplat.bbprofile.profile_parts.parts_collection') as $part)
		{
			$name = (new \ReflectionClass($part))->getShortName();
			$template->assign_block_vars('parts', array(
				'ID'		=> $name,
				'LABEL'		=> $user->lang('BBPROFILE_' . strtoupper($name) . '_BUTTON'),
				'SELECTED'	=> in_array($name, $enabled_parts),
			));
		}

		$profile_fields = $profilefields_manager->grab_profile_fields_data($user->data['user_id']);
		foreach ($profile_fields[$user->data['user_id']] as $field)
		{
			$id = 'cpf_' . $field['data']['field_id'];
			$template->assign_block_vars('cpfs', array(
				'ID'		=> $id,
				'LABEL'		=> $user->lang($field['data']['lang_name']),
				'SELECTED'	=> in_array($id, $enabled_parts),
			));
		}

		$template->assign_vars(array(
			'U_ACTION'					=> $this->u_action,
			'BBPROFILE_POSITION'		=> $config['bbprofile_position'],
			'BBPROFILE_HIDE_FOR_ADMINS'	=> !$auth_admin->get_mask('set', false, $admin_group_id, false, 'u_', 'global', ACL_YES)[$admin_group_id][0]['u_bbprofile'],
			'BBPROFILE_HIDE_FOR_MODS'	=> !$auth_admin->get_mask('set', false, $mod_group_id, false, 'u_', 'global', ACL_YES)[$mod_group_id][0]['u_bbprofile'],
		));
	}
}
