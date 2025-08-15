<?php
/**
*
* @package BBSwitch
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\accountswitch\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $config;
	protected $helper;
	protected $user;
	protected $db;
	protected $template;
	protected $phpbb_root_path;
	protected $php_ext;

	/**
	* Constructor
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, $phpbb_root_path, $php_ext)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->user = $user;
		$this->db = $db;
		$this->template				= $template;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->board_url = generate_board_url() . '/';
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'					=> 'load_lang',
			'core.page_header'					=> 'user_setup',
			'core.acp_users_modify_profile'		=> 'load_profile',
			'core.viewtopic_modify_post_row'	=> 'viewtopic_modify_post_row',
		);
	}

	public function load_lang($event)
	{
		$this->user->add_lang_ext('sitesplat/accountswitch', 'accountswitch');
	}
	
	public function user_setup($event)
	{
		if ($this->config['allow_emailreuse'])
		{
			$sql = 'SELECT user_id, username, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . ' 
					WHERE user_email_hash = ' . $this->user->data['user_email_hash'] . ' AND user_id <> ' . $this->user->data['user_id'] . ' 
					ORDER BY username';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$this->template->assign_block_vars('accountswitch', array(
					'USERNAME'	=> $row['username'],
					'USER_ID'	=> $row['user_id'],
					'URL'		=> $this->helper->route('sitesplat_accountswitch_controller', array('route' => $row['username'])),
					'AVATAR'	=> (($row['user_avatar']) ? 
								   str_replace(array('class="avatar"', 'alt=', './../../'), array('class="online_img"', 'alt=', $this->board_url),
								   phpbb_get_user_avatar(
									array('avatar'			=> $row['user_avatar'], 
									      'user_id'         => $row['user_id'],
										  'avatar_type'		=> $row['user_avatar_type'], 
										  'avatar_width'	=> $row['user_avatar_width'], 
										  'avatar_height'	=> $row['user_avatar_height']), $row['username'])) :
										  '<img class="online_img" src="' . $this->board_url . 'styles/prosilver/theme/images/no_avatar.gif" alt="' .  $row['username'] . '">')
				));
			}
		}
	}

	public function load_profile($event)
	{
		$user_data = $event['user_row'];
		$sql = 'SELECT user_id, username FROM ' . USERS_TABLE . ' 
				WHERE user_email_hash = ' . $user_data['user_email_hash'] . ' AND user_id <> ' . $user_data['user_id'] . ' 
				ORDER BY username';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('accountswitch_adm', array(
				'USERNAME'	=> $row['username'],
				'USER_ID'	=> $row['user_id'],
				'ADMURL'	=> $this->board_url. 'adm/index.php?i=users&mode=profile&u=' . $row['user_id'] . '&sid=' . $this->user->data['session_id']
			));
		}
	}

	public function viewtopic_modify_post_row($event)
	{
		$poster_id = $event['poster_id'];
		$post_row_ary = array();
		$sql = 'SELECT user_id, username, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . ' WHERE
				user_email_hash = (SELECT user_email_hash FROM  ' . USERS_TABLE . ' WHERE user_id = ' . $poster_id . ') AND user_id <> ' . $poster_id;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$post_row_ary[] = array(
				'AVATAR' => (($row['user_avatar']) ? 
							 str_replace(array('class="avatar"', 'alt=', './../../'), array('class="online_img"', 'title="' .  $row['username'] . '" alt=', './'), phpbb_get_user_avatar(
								array('avatar'			=> $row['user_avatar'],
                                      'user_id'         => $row['user_id'],								
									  'avatar_type'		=> $row['user_avatar_type'], 
									  'avatar_width'	=> $row['user_avatar_width'], 
									  'avatar_height'	=> $row['user_avatar_height']), $row['username'])) :
									  '<img class="online_img" src="' . $this->board_url . 'styles/prosilver/theme/images/no_avatar.gif" alt="' .  $row['username'] . '" title="' .  $row['username'] . '">')
			);
		}
		
		$event['post_row'] = array_merge($event['post_row'], array('accountswitch_post' => $post_row_ary));
	}
}
