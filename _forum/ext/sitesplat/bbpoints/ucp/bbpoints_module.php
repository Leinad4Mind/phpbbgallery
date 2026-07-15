<?php

/**
 *
 * BBPoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbpoints\ucp;

class bbpoints_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $db, $config, $user, $request, $template, $phpbb_root_path, $phpEx, $phpbb_container, $phpbb_dispatcher;
		$user->add_lang_ext('sitesplat/bbpoints', 'bbpoints');

		$userid = $user->data['user_id'];
		$this->page_title = $user->lang['BBPOINTS'];
		$this->tpl_name = 'ucp_profile_bbpoints';
		$this->bbpoints_table = $phpbb_container->getParameter('sitesplat.bbpoints.table');
		$this->bbpoints_helper = $phpbb_container->get('sitesplat.bbpoints.helper');
		$this->bbpoints_config = json_decode($config['bbpoints_settings'], true);
		$this->bbpoints_config['currency'] = $this->bbpoints_helper->currency(0, $this->bbpoints_config['currency']);

		/**
		 * Before ucp main
		 *
		 * @event sitesplat.bbpoints.before_ucp_module_main
		 */
		$vars = array('userid', $this->page_title, $this->tpl_name, $this->bbpoints_config);
		if(isset($PontosGold)) {
			extract($phpbb_dispatcher->trigger_event('sitesplat.bbpoints.before_ucp_module_main', compact($vars)));
		}

		if ($this->bbpoints_config['transfer_notify'] && $request->is_set_post('submit')) {
			if ($request->variable('transfer_to', 0) && $request->variable('amount', 0) > 4) {
				$sql = 'SELECT ' . $userid . ' AS user_id,
				COALESCE((
					SELECT SUM(bbpoints)
					FROM bbgta_posts
					WHERE post_visibility = 1 AND poster_id = ' . $userid . '
				), 0)
				 + COALESCE((
					SELECT SUM(bbpoints)
					FROM bbgta_topics
					WHERE topic_poster = ' . $userid . '
				), 0)
				 + COALESCE((
					SELECT SUM(bbpoints)
					FROM bbgta_bbpoints
					WHERE to_id = ' . $userid . '
				), 0)
				 - COALESCE((
					SELECT SUM(bbpoints)
					FROM bbgta_bbpoints
					WHERE from_id = ' . $userid . '
				), 0) AS total;';
				$result = $db->sql_query($sql);
				$user_points  = $db->sql_fetchfield('total');

				if ($request->variable('amount', 0) <= $user_points) {
					$sql = 'INSERT INTO ' . $this->bbpoints_table . ' (from_id, to_id, bbpoints, reason, timestamp) 
							VALUES(' . $userid . ', ' . $request->variable('transfer_to', 0) . ', ' . $request->variable('amount', 0) . ', "' . $request->variable('comment', '') . '", ' . time() . ')';
					$db->sql_query($sql);
					$item_id = $db->sql_nextid();

					$amount = ($this->bbpoints_config['symbol_pos']) ? '<i class="fa ' . $this->bbpoints_config['currency'][0] . '"></i> ' . number_format($request->variable('amount', 0), 0) :
						number_format($request->variable('amount', 0), 0) . ' ' . '<i class="fa ' . $this->bbpoints_config['currency'][0] . '"></i>';

					$noti_ary = array(
						'user_ids'		=> $request->variable('transfer_to', 0),
						'parent_id'		=> 0,
						'post_id'		=> $item_id,
						'poster_id'		=> $userid,
						'amount'		=> $request->variable('amount', 0),
						'like_txt'		=> sprintf($user->lang('TRANSFER_NOTI'), $amount, $user->data['username'], $request->variable('comment', '')),
						'currency'		=> $this->bbpoints_config['currency'],
						'REFRESH_DATA'	=> array('time'	=> 3)
					);
					$this->bbpoints_helper->add_noti($noti_ary);
					$phpbb_container->get('cache')->destroy('sql', array($this->bbpoints_table));

					if ($request->is_ajax()) {
						$json_response = new \phpbb\json_response;
						$json_response->send(array(
							'MESSAGE_TITLE'	=> $user->lang['INFORMATION'],
							'MESSAGE_TEXT'	=> $user->lang['TRANSFER_SUCCESS'],
							'REFRESH_DATA'	=> array(
								'time'	=> 3,
								'url'	=> $this->u_action
							)
						));
					} else {
						trigger_error($user->lang['TRANSFER_SUCCESS'] . adm_back_link($this->u_action), E_USER_NOTICE);
					}
				} else {
					trigger_error($this->user->lang['TRANSFER_NOT_ENOUGH_POINTS']);
				}
			} else {
				trigger_error($user->lang[(!$request->variable('transfer_to', 0) ? 'NO_USER_SELECTED' : 'NO_AMOUNT_SELECTED')]);
			}
		} else {
			$sql = 'SELECT COUNT(t1.post_id) AS total FROM ( 
					SELECT post_id FROM ' . POSTS_TABLE . ' WHERE poster_id = ' . $userid . ' 
					UNION ALL 
					SELECT 1 AS post_id FROM ' . $this->bbpoints_table . ' WHERE to_id = ' . $userid . ' 
					UNION ALL 
					SELECT 1 AS post_id FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $userid . ' 
					) t1';
			$result = $db->sql_query($sql);
			$total = $db->sql_fetchfield('total');

			$per_page = 12;
			$start = $request->variable('start', 0);
			$pagination = $phpbb_container->get('pagination');
			$start = $pagination->validate_start($start, $per_page, $total);
			$base_url = append_sid($this->u_action);
			$pagination->generate_template_pagination($base_url, 'pagination', 'start', $total, $per_page, $start);

			$sql = 'SELECT t1.*, u.username, u.user_colour FROM (
					SELECT p.post_id, p.topic_id, p.forum_id, p.poster_id, p.post_time, p.post_subject, "" AS reason,
					p.bbpoints + IF(p.post_id = t.topic_first_post_id, t.bbpoints, 0) AS bbpoints
					FROM ' . POSTS_TABLE . ' p
					LEFT JOIN ' . TOPICS_TABLE . ' t ON t.topic_id = p.topic_id
					WHERE p.poster_id = ' . $userid . '
					UNION ALL
					
					SELECT 0 AS post_id, 0 AS topic_id, 0 AS forum_id, from_id AS poster_id, timestamp AS post_time, "BB_DONATION" AS post_subject, reason, bbpoints 
					FROM ' . $this->bbpoints_table . ' WHERE to_id = ' . $userid . '
	
					UNION ALL
					SELECT 0 AS post_id, 0 AS topic_id, 0 AS forum_id, to_id AS poster_id, timestamp AS post_time, "BB_TRANSFER" AS post_subject, reason, bbpoints 
					FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $userid . '
	
					) t1
					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = t1.poster_id
					ORDER BY post_time DESC';
			$result = $db->sql_query_limit($sql, $per_page, $start);
			while ($row = $db->sql_fetchrow($result)) {
				$template->assign_block_vars('pointsucp', array(
					'SUBJECT'			=> ($row['post_id']) ? $row['post_subject'] : $user->lang[$row['post_subject']],
					'SUBJECTURL'		=> ($row['post_id']) ? append_sid($phpbb_root_path . 'viewtopic.' . $phpEx . '?f=' . $row['forum_id'] . '&p=' .
						$row['post_id'] . '#p' . $row['post_id']) : '',
					'REASON'			=> ($row['reason']) ? $row['reason'] : '',
					'POINTS_TIME'		=> $user->format_date($row['post_time']),
					'GIVE_RECEIVE'		=> (($row['post_subject'] == 'BB_TRANSFER') ? '- ' : '') . number_format($row['bbpoints'], 0),
					'USERNAME'			=> ($row['poster_id']) ? get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour']) : $config['sitename'],
				));
			}

			$template->assign_vars(array(
				'U_ACTION'	=> ($this->bbpoints_config['transfer_notify']) ? $this->u_action : '', 'COMMENT_ENABLED' => $this->bbpoints_config['comments_enable']
			));
		}

		/**
		 * After ucp main
		 *
		 * @event sitesplat.bbpoints.after_ucp_module_main
		 */
		$vars = array('userid', $this->page_title, $this->tpl_name, $this->bbpoints_config);
		if(isset($PontosGold)) {
			extract($phpbb_dispatcher->trigger_event('sitesplat.bbpoints.after_ucp_module_main', compact($vars)));
		}
	}
}
