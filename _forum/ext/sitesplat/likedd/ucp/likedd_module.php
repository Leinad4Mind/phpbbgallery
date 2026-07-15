<?php

/**
 *
 * phpBB Ajax likeBB.
 *
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\likedd\ucp;

class likedd_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $db, $config, $user, $request, $template, $phpbb_root_path, $phpEx, $phpbb_container, $phpbb_dispatcher;

		$user->add_lang_ext('sitesplat/likedd', 'likedd');

		$this->page_title = $user->lang['UCP_LIKEDD_TITLE'];
		$this->tpl_name = 'ucp_profile_likedd';
		$this->likes_table = $phpbb_container->getParameter('sitesplat.likedd.tables.likes');

		$userid = $user->data['user_id'];
		$sql = 'SELECT
				COUNT(CASE WHEN l.user_id = ' . $userid . ' AND l.ld = 0 THEN l.user_id END) AS lgiv,
				COUNT(CASE WHEN p.poster_id = ' . $userid . ' AND l.ld = 0 THEN p.poster_id END) AS lrec, 
				COUNT(CASE WHEN l.user_id = ' . $userid . ' AND l.ld = 1 THEN l.user_id END) AS dgiv,
				COUNT(CASE WHEN p.poster_id = ' . $userid . ' AND l.ld = 1 THEN p.poster_id END) AS drec,
				COUNT(CASE WHEN l.ld = 0 THEN l.user_id END) AS lgivtot,
				COUNT(CASE WHEN l.ld = 1 THEN l.user_id END) AS lrectot
				FROM ' . $this->likes_table . ' l
				LEFT JOIN ' . POSTS_TABLE . ' p ON p.post_id = l.post_id';
		$result = $db->sql_query($sql);
		$likes = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$i = 0;
		foreach ($likes as $key => $value) {
			if (++$i <= (($config['dislike_off']) ? 2 : 4)) {
				$percentvalue = (substr($key, 0, 1) == 'l') ? $likes['lgivtot'] : $likes['lrectot'];
				$template->assign_block_vars('likestat', [
					'ICON'				=> (substr($key, 0, 1) == 'l') ? $config['like_icon'] : $config['dislike_icon'],
					'GIVEN_RECEIVED'	=> ((substr($key, 0, 1) == 'l') ? ((substr($key, 1) == 'rec') ? $user->lang['LIKES_RECEIVED'] : $user->lang['LIKES_GIVEN']) : ((substr($key, 1) == 'rec') ? $user->lang['DISLIKES_RECEIVED'] : $user->lang['DISLIKES_GIVEN'])),
					'GIVE_RECEIVE'		=> $value . ' (' . (($percentvalue) ? number_format(($value / $percentvalue) * 100, 2) :  0) . ((substr($key, 0, 1) == 'l') ? '% ' . $user->lang['LIKES_ALL_LIKES'] . ')' :  '% ' . $user->lang['LIKES_ALL_DISLIKES'] . ')')
				]);
				$data[] = [
					'name'	=> ((substr($key, 0, 1) == 'l') ? ((substr($key, 1) == 'rec') ? $user->lang['LIKES_RECEIVED'] : $user->lang['LIKES_GIVEN']) : ((substr($key, 1) == 'rec') ? $user->lang['DISLIKES_RECEIVED'] : $user->lang['DISLIKES_GIVEN'])),
					'y'		=> $value
				];
			}
		}

		$template->assign_vars([
			'STATS'	=> str_replace(['"name"', '"y"'], ['name', 'y'], json_encode($data, JSON_NUMERIC_CHECK))
		]);

		$sql = 'SELECT COUNT(*) as total
				FROM
				(
					SELECT p.post_id
					FROM ' . $this->likes_table . ' l 
					LEFT JOIN ' . POSTS_TABLE . ' p ON p.post_id = l.post_id
					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = l.user_id
					WHERE l.user_id = ' . $user->data['user_id'] . '
					
					UNION
					
					SELECT p.post_id
					FROM ' . POSTS_TABLE . ' p
					INNER JOIN ' . $this->likes_table . ' l ON l.post_id = p.post_id
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


		$sql_ary1 = [
			'SELECT'	=> 'p.post_subject, p.post_id, p.topic_id, p.forum_id, l.user_id, u.username, l.ld, l.like_time',
			'FROM'		=> [$this->likes_table => 'l'],
			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [POSTS_TABLE => 'p'],
					'ON'	=> 'p.post_id = l.post_id',
				],
				[
					'FROM'	=> [USERS_TABLE => 'u'],
					'ON'	=> 'u.user_id = l.user_id',
				]
			],
			'WHERE'		=> 'l.user_id = ' . (int) $user->data['user_id'],
		];
		$sql_ary2 = [
			'SELECT'	=> 'p.post_subject, p.post_id, p.topic_id, p.forum_id, l.user_id, u.username, l.ld, l.like_time',
			'FROM'		=> [POSTS_TABLE => 'p'],
			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [$this->likes_table => 'l'],
					'ON'	=> 'l.post_id = p.post_id',
				],
				[
					'FROM'	=> [USERS_TABLE => 'u'],
					'ON'	=> 'u.user_id = l.user_id',
				]
			],
			'WHERE'		=> 'p.poster_id = ' . (int) $user->data['user_id'],
			'ORDER_BY'	=> 'like_time DESC',
		];

		/**
		 * Event to modify likes sql query
		 *
		 * @event sitesplat.likedd.ucp_likes_sql
		 * @var	array	sql_ary1	First SQL array
		 * @var	array	sql_ary2	Second SQL array
		 * @since 2.4.0
		 */
		$vars = [
			'sql_ary1',
			'sql_ary2',
		];
		extract($phpbb_dispatcher->trigger_event('sitesplat.likedd.ucp_likes_sql', compact($vars)));

		$sql1 = $db->sql_build_query('SELECT', $sql_ary1);
		$sql2 = $db->sql_build_query('SELECT', $sql_ary2);
		// replace join on likes table to inner
		$sql2 = preg_replace('/LEFT JOIN/', 'INNER JOIN', $sql2, 1);

		$sql = $sql1 . ' UNION ' . $sql2;
		$result = $db->sql_query_limit($sql, $per_page, $start);
		while ($row = $db->sql_fetchrow($result)) {
			$url = $phpbb_root_path . 'viewtopic.' . $phpEx . '?f=' . $row['forum_id'] . '&t=' . $row['topic_id'] . '&p=' . $row['post_id'];
			$template_data = [
				'SUBJECT'			=> $row['post_subject'],
				'SUBJECTURL'		=> append_sid($url),
				'ICON'				=> (!$row['ld']) ? $config['like_icon'] : $config['dislike_icon'],
				'GIVE_RECEIVE'		=> ($row['user_id'] == $user->data['user_id']) ? $user->lang['UCP_LD_GIVEN'] : $user->lang['UCP_LD_RECEIVED'],
				'LIKE_TIME'			=> $user->format_date($row['like_time']),
				'USERNAME'			=> $row['username']
			];

			/**
			 * Event to modify likes template variables
			 *
			 * @event sitesplat.likedd.ucp_likes_template
			 * @var	array	row	DB row
			 * @var	array	template_data	Template data
			 * @since 2.4.0
			 */
			$vars = [
				'row',
				'template_data',
			];
			extract($phpbb_dispatcher->trigger_event('sitesplat.likedd.ucp_likes_template', compact($vars)));

			$template->assign_block_vars('likes', $template_data);
		}

		$template->assign_vars([
			'U_ACTION'					=>	$this->u_action,
		]);
	}
}