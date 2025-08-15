<?php
/**
*
* BBreaction
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\ucp;

class bbreaction_module
{
	public $u_action;
	private $bbemoji_enabled = false;
	private $bbemoji_parser;

	function main($id, $mode)
	{
		global $db, $config, $user, $request, $template, $phpbb_root_path, $phpEx, $phpbb_container, $phpbb_dispatcher;

		$user->add_lang_ext('sitesplat/bbreaction', 'bbreaction');

		$this->page_title = $user->lang['BBREACTION'];
		$this->tpl_name = 'ucp_profile_bbreaction';
		$this->reward_table = $phpbb_container->getParameter('sitesplat.bbreaction.tables.reward');
		$this->reward_type_table = $phpbb_container->getParameter('sitesplat.bbreaction.tables.reward_type');
		
		/**
		* Event to run code at the beginning of the UCP module
		*
		* @event sitesplat.bbreaction.ucp_before
		* @since 1.3.0
		*/
		extract($phpbb_dispatcher->trigger_event('sitesplat.bbreaction.ucp_before'));

		$userid = $user->data['user_id'];
		$sql = 'SELECT *, (SELECT COUNT(like_id) FROM ' . $this->reward_table . ' WHERE like_type = t.type_id AND user_id = ' . $userid . ') AS num, "given" AS type
				FROM ' . $this->reward_type_table . ' t WHERE active = 1 

				UNION

				SELECT *, (SELECT COUNT(r.like_id) FROM ' . $this->reward_table . ' r
				LEFT JOIN ' . POSTS_TABLE . ' p ON p.post_id = r.post_id WHERE r.like_type = t.type_id AND p.poster_id = ' . $userid . ') AS num, "recieved" AS type
				FROM ' . $this->reward_type_table . ' t WHERE active = 1 
				
				ORDER BY weight, type';
		$result = $db->sql_query($sql);
		while($row = $db->sql_fetchrow($result)) 
		{
				$ary_tpl = array(
					'TITLE'				=> $row['title'],
					'ICON'				=> $row['symbol'],
					'S_POSITIVE'		=> $row['positive'],
					'GIVEN_RECIEVED'	=> (($row['type'] == 'given') ? $user->lang['BBREACTION_GIVVEN'] : $user->lang['BBREACTION_RECIEVED']),
					'GIVE_RECIEVE'		=> $row['num'],

					'CLASSLIST'	=> 'fa ' . $row['symbol'],
					'CONTENTS'	=> '',
				);
				
				/**
				* Event to modify reward template variables
				*
				* @event sitesplat.bbreaction.ucp_likestat
				* @var	array	row	Reward data
				* @var	array	ary_tpl	Current reward template array
				* @since 1.3.0
				*/
				$vars = array(
					'row',
					'ary_tpl',
				);
				extract($phpbb_dispatcher->trigger_event('sitesplat.bbreaction.ucp_likestat', compact($vars)));

				$template->assign_block_vars('likestat', $ary_tpl);

				$data[] = array('name'	=> $row['title'] . ': ' . (($row['type'] == 'given') ? $user->lang['BBREACTION_GIVVEN'] : $user->lang['BBREACTION_RECIEVED']),
								'y'		=> $row['num']);
		}

		$template->assign_vars(array(
			'STATS'	=> str_replace(array('"name"', '"y"'), array('name', 'y'), json_encode($data, JSON_NUMERIC_CHECK))
		));

		$sql = 'SELECT SUM(subtotal) as total
				FROM
				(
					SELECT COUNT(p.post_id) AS subtotal
					FROM ' . $this->reward_table . ' l 
					LEFT JOIN ' . POSTS_TABLE . ' p ON p.post_id = l.post_id
					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = l.user_id
					WHERE l.user_id = ' . $user->data['user_id'] . '
					
					UNION
					
					SELECT COUNT(p.post_id) AS subtotal
					FROM ' . POSTS_TABLE . ' p
					INNER JOIN ' . $this->reward_table . ' l ON l.post_id = p.post_id
					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = l.user_id
					WHERE p.poster_id = ' . $user->data['user_id'] . '
				) x';
		$result = $db->sql_query($sql);
		$total_likes = $db->sql_fetchfield('total');

		$per_page = 12;
		$start = $request->variable('start', 0);
		$pagination = $phpbb_container->get('pagination');
		$start = $pagination->validate_start($start, $per_page, $total_likes);
		$base_url = append_sid($this->u_action);
		$pagination->generate_template_pagination($base_url, 'pagination', 'start', $total_likes, $per_page, $start);

		$select_append = '';
		$left_join_append = '';
		/**
		* Event to modify reward template variables
		*
		* @event sitesplat.bbreaction.ucp_likes_sql_before
		* @var	string	select_append	string to append to selects
		* @var	string	left_join_append	string to append to joins
		* @since 1.4.0
		*/
		$vars = array(
			'select_append',
			'left_join_append',
		);
		extract($phpbb_dispatcher->trigger_event('sitesplat.bbreaction.ucp_likes_sql_before', compact($vars)));

		$sql = 'SELECT p.post_subject, p.post_id, p.topic_id, p.forum_id, l.user_id, u.username, t.*, l.like_time' . $select_append . '
				FROM ' . $this->reward_table . ' l 
				LEFT JOIN ' . $this->reward_type_table . ' t ON t.type_id = l.like_type
				LEFT JOIN ' . POSTS_TABLE . ' p ON p.post_id = l.post_id
				LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = l.user_id
				' . $left_join_append . '
				WHERE l.user_id = ' . $user->data['user_id'] . '
				
				UNION
				
				SELECT p.post_subject, p.post_id, p.topic_id, p.forum_id, l.user_id, u.username, t.*, l.like_time' . $select_append . '
				FROM ' . POSTS_TABLE . ' p
				INNER JOIN ' . $this->reward_table . ' l ON l.post_id = p.post_id
				LEFT JOIN ' . $this->reward_type_table . ' t ON t.type_id = l.like_type
				LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = l.user_id
				' . $left_join_append . '
				WHERE p.poster_id = ' . $user->data['user_id'] . '
				
				ORDER BY like_time DESC ';
				$result = $db->sql_query_limit($sql, $per_page, $start);
				while($row = $db->sql_fetchrow($result)) 
				{
					$url = $phpbb_root_path . 'viewtopic.' . $phpEx . '?f=' . $row['forum_id'] . '&t=' . $row['topic_id'] . '&p='. $row['post_id'];
					$ary_tpl = array(
						'SUBJECT'			=> $row['post_subject'],
						'SUBJECTURL'		=> append_sid($url),
						'TITLE'				=> $row['title'],
						'ICON'				=> $row['symbol'],
						'S_POSITIVE'		=> $row['positive'],
						'GIVE_RECIEVE'		=> ($row['user_id'] == $user->data['user_id']) ? $user->lang['BBREACTION_GIVVEN'] : $user->lang['BBREACTION_RECIEVED'],
						'LIKE_TIME'			=> $user->format_date($row['like_time']),
						'USERNAME'			=> $row['username'],
						
						'CLASSLIST'	=> 'fa ' . $row['symbol'],
						'CONTENTS'	=> '',
					);

					/**
					* Event to modify reward template variables
					*
					* @event sitesplat.bbreaction.ucp_likes
					* @var	array	row	Reward data
					* @var	array	ary_tpl	Current reward template array
					* @since 1.3.0
					*/
					$vars = array(
						'row',
						'ary_tpl',
					);
					extract($phpbb_dispatcher->trigger_event('sitesplat.bbreaction.ucp_likes', compact($vars)));

					$template->assign_block_vars('likes', $ary_tpl);
				}

		$template->assign_vars(array(
			'U_ACTION'					=>	$this->u_action,
		));
	}

}
