<?php
/**
*
* @package BBSwitch
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\accountswitch\ucp;

class accountswitch_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $db, $config, $user, $request, $template, $phpbb_root_path, $phpEx, $phpbb_container;
		$user->add_lang_ext('sitesplat/accountswitch', 'accountswitch');

		$this->page_title = $user->lang['ACCOUNTSWITCH'];
		$this->tpl_name = 'ucp_profile_accountswitch';

		if ($config['allow_emailreuse'])
		{
			$board_url = generate_board_url() . '/';
			$sql = 'SELECT user_id, username, user_colour, user_posts, user_lastvisit, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height 
					FROM ' . USERS_TABLE. ' 
					WHERE user_email_hash = "' . $user->data['user_email_hash'] . '" AND NOT user_id = ' . $user->data['user_id'] . '
					ORDER BY username';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result)) 
			{
				$template->assign_block_vars('accounts_linked', array(
					'USERNAME'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
					'USERPOSTS'		=> $row['user_posts'],
					'LAST_VISIT'	=> $user->format_date($row['user_lastvisit']),
					'AVATAR'	=> (($row['user_avatar']) ? 
								 str_replace(array('class="avatar"', 'alt=', './../../'), array('class="online_img"', 'class="online_img" title=', './'), phpbb_get_user_avatar(
									array('avatar'			=> $row['user_avatar'], 
									      'user_id'         => $row['user_id'],
										  'avatar_type'		=> $row['user_avatar_type'], 
										  'avatar_width'	=> $row['user_avatar_width'], 
										  'avatar_height'	=> $row['user_avatar_height']), $row['username'])) :
										  '<img class="online_img" title="' .  $row['username'] . '" src="' .
										  $board_url . 'styles/prosilver/theme/images/no_avatar.gif">'),
				));
			}
		}
	}
}
