<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\types\type;

/**
 * Hot_topics class
 */
class hot_topics extends \sitesplat\sidebar\types\type\base
{
	/**
	 * Get sidebar block enable
	 *
	 * @return sidebar enabled
	 * @access public
	 */
	public function get_sidebar_enable()
	{
		return true;
	}
	/**
	 * Get sidebar block type
	 *
	 * @return string sidebar type
	 * @access public
	 */
	public function get_sidebar_type()
	{
		return 'sitesplat.sidebar.type.hot_topics';
	}

	/**
	 * Get sidebar type name
	 *
	 * @return string sidebar type name
	 * @access public
	 */
	public function get_sidebar_type_name()
	{
		return $this->user->lang('SIDEBAR_TYPE_HOT_TOPICS');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_sidebar/hot_topics.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function outputblock()
	{
		$phpbb_dispatcher = $this->container->get('dispatcher');

		$howmany = $this->howmany();
		$visibility = $this->container->get('content.visibility');
		$forum_ary = array();
		$forum_read_ary = $this->auth->acl_getf('f_read');

		foreach ($forum_read_ary as $forum_id => $allowed)
		{
			if ($allowed['f_read'])
			{
				$forum_ary[] = (int) $forum_id;
			}
		}
		$forum_ary = array_unique($forum_ary);

		if ($this->config['hot_threshold'] && sizeof($forum_ary))
		{
			$sql = 'SELECT forum_id, topic_id, topic_type
				FROM ' . TOPICS_TABLE . '
				WHERE ' . $visibility->get_forums_visibility_sql('topic', $forum_ary) . '
				AND topic_status <> ' . ITEM_MOVED . '
				ORDER BY topic_last_post_time DESC';

			$result = $this->db->sql_query_limit($sql, $howmany);
			$forums = $ga_topic_ids = $topic_ids = array();
			while ($row = $this->db->sql_fetchrow($result))
			{
				$topic_ids[] = $row['topic_id'];
				if ($row['topic_type'] == POST_GLOBAL)
				{
					$ga_topic_ids[] = $row['topic_id'];
				} else
				{
					$forums[$row['forum_id']][] = $row['topic_id'];
				}
			}
			$this->db->sql_freeresult($result);

			// Get topic tracking
			$topic_tracking_info = array();
			foreach ($forums as $forum_id => $topic_id)
			{
				$topic_tracking_info[$forum_id] = get_complete_topic_tracking($forum_id, $topic_id, $ga_topic_ids);
			}

			if (sizeof($topic_ids))
			{
				// grab all posts that meet criteria and auths
				$sql_array = array(
					'SELECT'	=> 'u.user_id, u.username, u.user_colour, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id,
									t.topic_last_post_time, t.topic_last_poster_name, f.forum_name,
									at.attr_name',
					'FROM'		=> array(TOPICS_TABLE => 't'),
					'LEFT_JOIN'	=> array(
						array(
							'FROM'	=> array(USERS_TABLE => 'u'),
							'ON'	=> 't.topic_last_poster_id = u.user_id',
						),
						array(
							'FROM'	=> array(FORUMS_TABLE => 'f'),
							'ON'	=> 't.forum_id = f.forum_id',
						),
						array(
							'FROM'	=> array('bbgta_topics_attr' => 'at'),
							'ON'	=> 'at.attr_id = t.topic_attr_id',
						),
					),
					'WHERE'		=> $this->db->sql_in_set('t.topic_id', $topic_ids) . ' AND topic_posts_approved >= ' . $this->config['hot_threshold'],
					'ORDER_BY'	=> 't.topic_last_post_time DESC',
				);

				// cache the query for 5 minute
				$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany, 0, 300);

				while ($row = $this->db->sql_fetchrow($result))
				{
					$topic_id = $row['topic_id'];
					$forum_id = $row['forum_id'];
					$forum_name = $row['forum_name'];

					$post_unread = (isset($topic_tracking_info[$forum_id][$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$forum_id][$topic_id]) ? true : false;
					$view_topic_url = append_sid("{$this->root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' .
										$row['topic_last_post_id']);
					$forum_name_url = append_sid("{$this->root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
					$topic_title = censor_text($row['attr_name'] . $row['topic_title']);
					if (utf8_strlen($topic_title) >= 60)
					{
						$topic_title = (utf8_strlen($topic_title) > 60 + 3) ? utf8_substr($topic_title, 0, 60) . '...' : $topic_title;
					}
					$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;

					$tpl_ary = array(
						'U_TOPIC'			=> $view_topic_url,
						'U_FORUM'			=> $forum_name_url,
						'S_UNREAD'			=> ($post_unread) ? true : false,
						'USERNAME_FULL'		=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . 
												get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : 
												$this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
						'LAST_TOPIC_TIME'	=> $this->user->format_date($row['topic_last_post_time']),
						'TOPIC_TITLE' 		=> $topic_title,
						'TOPIC_TITLE_NO_HTML'	=> $topic_title,
						'FORUM_NAME'		=> $forum_name,
					);

					/**
					* Event to modify reaction data before they are assigned
					*
					* @event sitesplat.bbsidebar.type.hot_topics_tpl_before
					* @var	array	tpl_ary	Template array
					* @since 1.5.0
					*/
					$vars = array(
						'tpl_ary',
					);
					extract($phpbb_dispatcher->trigger_event('sitesplat.bbsidebar.type.hot_topics_tpl_before', compact($vars)));

					$this->template->assign_block_vars('hot_topics', $tpl_ary);
				}
				$this->db->sql_freeresult($result);
			}
			else
			{
				$this->template->assign_block_vars('hot_topics', array(
					'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
				));
			}
		}
		else
		{
			$this->template->assign_block_vars('hot_topics', array(
				'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
			));
		}
	}
}
