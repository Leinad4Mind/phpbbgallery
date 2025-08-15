<?php
/**
*
* BBAvatars
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\titlesandavatars\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	protected $config;
	protected $user;
	protected $template;

	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\template\template $template)
	{
		$this->config = $config;
		$this->user = $user;
		$this->template = $template;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewforum_get_topic_data' 				=> 'modify_sql_array',
			'core.display_forums_modify_sql'				=> 'modify_display_sql_array',
			'core.display_forums_modify_first_last_avatar'	=> 'forums_modify_forum_rows',
			'core.display_forums_modify_template_vars'		=> 'forums_modify_template_vars',
			'core.viewforum_modify_topicrow'				=> 'modify_topicrow',
			
			'core.memberlist_memberrow_before'				=> 'memberlist_avatar',
			'core.viewtopic_modify_post_data'				=> 'participants_avatars',
			'core.obtain_users_online_string_sql'			=> 'online_userlist_sql',
//			'core.obtain_users_online_string_modify'		=> 'online_userlist'
			'core.obtain_users_online_string_before_modify'		=> 'online_userlist'
		);
	}

	public function online_userlist_sql($event)
	{
		if ($this->config['titles_avatar_online'])
		{
			$sql_ary = $event['sql_ary'];
			$sql_ary['SELECT'] .= ', u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height';
			$event['sql_ary'] = $sql_ary;
		}
	}

	public function online_userlist($event)
	{
		if ($this->config['titles_avatar_online'])
		{
//			$online_userlist = $event['online_userlist'];
			$user_online_link = $event['user_online_link'];
			
			$rows = $event['rowset']; 
			$avatars = array();
			foreach ($rows as $row)
			{
				if (preg_match('` href\="(.*?)"`', $user_online_link[intval($row['user_id'])], $matches)) {
					if ($row['user_avatar'])
					{
						$avatar = str_replace(
							array('class="avatar"', 'alt='),
							array('class="online_img"', 'alt="' . $this->user->lang['USER_AVATAR'] . '" title='),
							phpbb_get_user_avatar([
								'avatar' => $row['user_avatar'], 
								'id' => $row['user_id'], 
								'avatar_type' => $row['user_avatar_type'], 
								'avatar_width' => $row['user_avatar_width'], 
								'avatar_height' => $row['user_avatar_height'],
							], $row['username'])
						);
					}
					else
					{
						$avatar = '<img class="avatar" alt="" title="' .  $row['username'] . '" src="./styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png" alt="">';
					}

//					$avatars[] = '<a href="' . $matches[1] . '">' . $avatar . '</a>';
					$user_online_link[intval($row['user_id'])] = '<a href="' . $matches[1] . '">' . $avatar . '</a>';
				}
			}

//			$event['online_userlist'] = str_replace($user_online_link, $avatars, $online_userlist);
			$event['user_online_link'] = $user_online_link;
		}
	}

	public function participants_avatars($event)
	{
		$this->template->assign_vars(array(
			'PARTICIPANTS_AVATAR'	=> $this->config['titles_avatar_participants'],
			'PARTICIPANT_TOPIC_ID'	=> $event['topic_id']
		));
		if ($this->config['titles_avatar_participants'])
		{
			$this->user->add_lang_ext('sitesplat/titlesandavatars', 'titlesandavatars');
			$row = $event['user_cache'];
			shuffle($row);

			for ($i = 0; $i < min(10, sizeof($row)); $i++)
			{
				if ($row[$i]['author_username'])
				{
					$this->template->assign_block_vars('participants_avatars', array(
						'TOPIC_AVATAR'	=> $row[$i]['avatar'],
						'USERNAME'		=> $row[$i]['author_username'],
						'URL'			=> $row[$i]['author_profile'],
					));
				}
			}
		}
	}

	public function memberlist_avatar($event)
	{
		$this->template->assign_vars(array(
			'MEMBERLIST_AVATAR' => $this->config['titles_avatar_memberlist']
		));
	}
	
	public function modify_display_sql_array($event)
	{
		$sql_array = $event['sql_ary'];
		$sql_array['LEFT_JOIN'][] = array(
			'FROM'  => array(TOPICS_TABLE => 'tt'),
			'ON'    => 'tt.forum_id = f.forum_id AND tt.topic_last_post_id = f.forum_last_post_id'
		);
		$sql_array['LEFT_JOIN'][] = array(
			'FROM'  => array(USERS_TABLE => 'u'),
			'ON'    => 'u.user_id = tt.topic_last_poster_id'
		);
		$sql_array['LEFT_JOIN'][] = array(
			'FROM'  => array(USERS_TABLE => 'uu'),
			'ON'    => 'uu.user_id = tt.topic_poster'
		);
		$sql_array['SELECT'] .= ', tt.topic_id, tt.topic_title,
			u.user_avatar AS lpa, u.user_id AS lpa_id, u.user_avatar_type AS lpa_type, u.user_avatar_width AS lpa_width, u.user_avatar_height AS lpa_height, u.username AS lpa_username,
			uu.user_avatar AS fpa, uu.user_id AS fpa_id, uu.user_avatar_type AS fpa_type, uu.user_avatar_width AS fpa_width, uu.user_avatar_height AS fpa_height, uu.username AS fpa_username';

		$event['sql_ary'] = $sql_array ;
	}

	public function forums_modify_forum_rows($event)
	{
		$row = $event['row'];
		$parent_id = $event['parent_id'];
		$forum_rows = $event['forum_rows'];

		$forum_rows[$parent_id]['lpa']			= $row['lpa'];
		$forum_rows[$parent_id]['lpa_id']		= $row['lpa_id'];
		$forum_rows[$parent_id]['lpa_type']		= $row['lpa_type'];
		$forum_rows[$parent_id]['lpa_width']	= $row['lpa_width'];
		$forum_rows[$parent_id]['lpa_height']	= $row['lpa_height'];
		$forum_rows[$parent_id]['lpa_username']	= $row['lpa_username'];

		$forum_rows[$parent_id]['fpa']			= $row['fpa'];
		$forum_rows[$parent_id]['fpa_id']		= $row['fpa_id'];
		$forum_rows[$parent_id]['fpa_type']		= $row['fpa_type'];
		$forum_rows[$parent_id]['fpa_width']	= $row['fpa_width'];
		$forum_rows[$parent_id]['fpa_height']	= $row['fpa_height'];		
		$forum_rows[$parent_id]['fpa_username']	= $row['fpa_username'];		
			
		$event['forum_rows'] = $forum_rows;
	}

	public function forums_modify_template_vars($event)
	{
		$this->user->add_lang_ext('sitesplat/titlesandavatars', 'info_acp_titlesandavatars');
		$row = $event['row'];
		$template = $event['forum_row'];
				
		$template['FP_AVATAR'] = str_replace('alt=', 'alt="' . $this->user->lang['USER_AVATAR'] . '" title=', phpbb_get_user_avatar(
								array('avatar'			=> $row['fpa'], 
									  'id'				=> $row['fpa_id'], 
									  'avatar_type'		=> $row['fpa_type'], 
									  'avatar_width'	=> $row['fpa_width'], 
									  'avatar_height'	=> $row['fpa_height']), $this->user->lang['TAT_AVATAR_FIRST'] . ' ' . $row['fpa_username']));

		$template['LP_AVATAR'] = str_replace('alt=', 'alt="' . $this->user->lang['USER_AVATAR'] . '" title=', phpbb_get_user_avatar(
								array('avatar'			=> $row['lpa'], 
									  'id'				=> $row['lpa_id'], 
									  'avatar_type'		=> $row['lpa_type'], 
									  'avatar_width'	=> $row['lpa_width'], 
									  'avatar_height'	=> $row['lpa_height']), $this->user->lang['TAT_AVATAR_LAST'] . ' ' . $row['lpa_username']));

		$template['TAT_SETTING'] = $this->config['titles_avatar_setting'];
		$template['FORUM_POSTS'] = $row['forum_posts'];
		$event['forum_row'] = $template;
	}
		
	public function modify_topicrow($event)
	{
		$this->user->add_lang_ext('sitesplat/titlesandavatars', 'info_acp_titlesandavatars');
		$row = $event['row'];
		$template = $event['topic_row'];
		
		$template['FP_AVATAR'] = str_replace('alt=', 'alt="' . $this->user->lang['USER_AVATAR'] . '" title=', phpbb_get_user_avatar(
								array('avatar'			=> $row['fpa'], 
									  'id'				=> $row['fpa_id'], 
									  'avatar_type'		=> $row['fpa_type'], 
									  'avatar_width'	=> $row['fpa_width'], 
									  'avatar_height'	=> $row['fpa_height']), $this->user->lang['TAT_AVATAR_FIRST'] . ' ' . $row['fpa_username']));
		
		$template['LP_AVATAR'] = str_replace('alt=', 'alt="' . $this->user->lang['USER_AVATAR'] . '" title=', phpbb_get_user_avatar(
								array('avatar'			=> $row['lpa'], 
									  'id'				=> $row['lpa_id'], 
									  'avatar_type'		=> $row['lpa_type'], 
									  'avatar_width'	=> $row['lpa_width'], 
									  'avatar_height'	=> $row['lpa_height']), $this->user->lang['TAT_AVATAR_LAST'] . ' ' . $row['lpa_username']));
		
		$template['TAT_SETTING'] = $this->config['titles_avatar_setting'];
		$event['topic_row'] = $template;
	}

	public function modify_sql_array($event)
	{
		$sql_array = $event['sql_array'];

		$sql_array['LEFT_JOIN'][] = array(
			'FROM'	=> array(USERS_TABLE => 'u'),
			'ON'	=> 'u.user_id = t.topic_last_poster_id'
		);
	
		$sql_array['LEFT_JOIN'][] = array(
			'FROM'	=> array(USERS_TABLE => 'uu'),
			'ON'	=> 'uu.user_id = t.topic_poster'
		);

		$sql_array['SELECT'] .= ', u.user_avatar AS lpa, u.user_id AS lpa_id, u.user_avatar_type AS lpa_type, u.user_avatar_width AS lpa_width, u.user_avatar_height AS lpa_height, u.username AS lpa_username,
				uu.user_avatar AS fpa, uu.user_id AS fpa_id, uu.user_avatar_type AS fpa_type, uu.user_avatar_width AS fpa_width, uu.user_avatar_height AS fpa_height, uu.username AS fpa_username';

		$event['sql_array'] = $sql_array;
	}
}
