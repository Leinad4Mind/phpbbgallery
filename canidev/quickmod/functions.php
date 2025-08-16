<?php
/*
* @name functions.php
* @package cBB QuickMod
* @version 1.1.0 17/01/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* Note: This file include some functions adapted from phpBB3 original admin/mcp to work property with this project.
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

// Rename Topic
function qm_rename_topic($topic_ids, &$data)
{
	global $auth, $config, $db, $user, $phpbb_dispatcher, $phpbb_log, $phpbb_root_path, $phpEx;

	if(empty($topic_ids) || sizeof($topic_ids) != 1)
	{
		return false;
	}

	$new_title = utf8_normalize_nfc(request_var('topic_title', '', true));

	// Get some data before changed
	$sql = 'SELECT t.forum_id, t.topic_id, t.topic_poster, t.topic_first_post_id, t.topic_first_poster_name, t.topic_moved_id,
		f.enable_indexing, p.post_text
		FROM ' . TOPICS_TABLE . ' t
			LEFT JOIN ' . FORUMS_TABLE . ' f ON(f.forum_id = t.forum_id)
			LEFT JOIN ' . POSTS_TABLE . ' p ON (p.post_id = t.topic_first_post_id)
		WHERE t.topic_id = ' . $topic_ids[0];
	$result = $db->sql_query($sql);
	$topic_data = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if(!$topic_data || !$new_title)
	{
		return false;
	}

	// Update the topic
	$sql = 'UPDATE ' . TOPICS_TABLE . "
		SET topic_title = '" . $db->sql_escape($new_title) . "'
		WHERE topic_id = " . $topic_data['topic_id'] .
		(($topic_data['topic_moved_id']) ? " OR topic_id = {$topic_data['topic_moved_id']} OR topic_moved_id = {$topic_data['topic_moved_id']}" : "");
	$db->sql_query($sql);

	// Update the first post
	$sql = 'UPDATE ' . POSTS_TABLE . "
		SET post_subject = '" . $db->sql_escape($new_title) . "'
		WHERE post_id = " . $topic_data['topic_first_post_id'];
	$db->sql_query($sql);
	
	// Update the last post subject in forums
	$sql = 'UPDATE ' . FORUMS_TABLE . "
		SET forum_last_post_subject = '" . $db->sql_escape($new_title) . "'
		WHERE forum_last_post_id = " . $topic_data['topic_first_post_id'];
	$db->sql_query($sql);
	
	// Index message contents
	if(!empty($topic_data['enable_indexing']))
	{
		// Select the search method and do some additional checks to ensure it can actually be utilised
		$search_type = $config['search_type'];

		if(class_exists($search_type))
		{
			$error	= false;
			$search	= new $search_type($error, $phpbb_root_path, $phpEx, $auth, $config, $db, $user, $phpbb_dispatcher);

			if(!$error)
			{
				$search->index('edit', $topic_data['topic_first_post_id'], $topic_data['post_text'], $new_title, $topic_data['topic_poster'], $topic_data['forum_id']);
			}
			
			unset($search);
		}
	}

	$phpbb_log->add('mod', $user->data['user_id'], $user->ip, 'LOG_POST_EDITED', false, array(
		'forum_id'	=> $topic_data['forum_id'],
		'topic_id'	=> $topic_data['topic_id'],
		$new_title,
		$topic_data['topic_first_poster_name'],
	));
	
	$data = htmlspecialchars_decode($new_title);

	return 'TOPIC_RENAMED_SUCCESS';
}

/**
*
* Functions based on phpBB3 original functions but adapted to ajax request and data return
* (the original functions is invalid for this)
*
*/

// Lock/Unlock Topic
function qm_lock_unlock($action, $ids)
{
	global $auth, $user, $db, $phpbb_dispatcher, $phpbb_log, $phpEx, $phpbb_root_path;

	if(($action != 'lock' && $action != 'unlock') || !is_array($ids))
	{
		return false;
	}

	$orig_ids = $ids;

	if (!qm_check_ids($ids, TOPICS_TABLE, 'topic_id', array('m_lock')))
	{
		// Make sure that for f_user_lock only the lock action is triggered.
		if ($action != 'lock')
		{
			return false;
		}

		$ids = $orig_ids;

		if (!qm_check_ids($ids, TOPICS_TABLE, 'topic_id', array('f_user_lock')))
		{
			return false;
		}
	}
	unset($orig_ids);

	$sql = 'UPDATE ' . TOPICS_TABLE . '
		SET topic_status = ' . (($action == 'lock') ? ITEM_LOCKED : ITEM_UNLOCKED) . '
		WHERE ' . $db->sql_in_set('topic_id', $ids) . '
		AND topic_moved_id = 0';
	$db->sql_query($sql);

	$data = qm_get_topic_data($ids);

	foreach($data as $id => $row)
	{
		if(!$row['topic_moved_id'])
		{
			$phpbb_log->add('mod', $user->data['user_id'], $user->ip, 'LOG_' . strtoupper($action), false, array(
				'forum_id'	=> $row['forum_id'],
				'topic_id'	=> $row['topic_id'],
				$row['topic_title'],
			));
		}
	}
	
	/**
	 * Perform additional actions after locking/unlocking topics
	 *
	 * @event core.mcp_lock_unlock_after
	 * @var	string	action				Variable containing the action we perform on the topics ('lock', 'unlock')
	 * @var	array	ids					Array containing the topic IDs that have been locked/unlocked
	 * @var	array	data				Array containing topics data
	 * @since 3.1.7-RC1
	 */
	$vars = array(
		'action',
		'ids',
		'data',
	);
	extract($phpbb_dispatcher->trigger_event('core.mcp_lock_unlock_after', compact($vars)));

	return ((sizeof($ids) == 1) ? 'TOPIC' : 'TOPICS') . '_' . (($action == 'lock') ? 'LOCKED' : 'UNLOCKED') . '_SUCCESS';
}


// Change Topic Type
function qm_change_topic_type($action, $topic_ids, $forum_id = 0, $global_involved = false)
{
	global $auth, $user, $db, $phpEx, $phpbb_log, $phpbb_root_path, $template;

	switch ($action)
	{
		case 'make_announce':
			$new_topic_type = POST_ANNOUNCE;
			$check_acl = 'f_announce';
		break;

		case 'make_global':
			$new_topic_type = POST_GLOBAL;
			$check_acl = 'f_announce';
		break;

		case 'make_sticky':
			$new_topic_type = POST_STICKY;
			$check_acl = 'f_sticky';
		break;

		default:
			$new_topic_type = POST_NORMAL;
			$check_acl = '';
		break;
	}

	// Exclude shadow topics
	$data = qm_get_topic_data($topic_ids);

	foreach($data as $topic_id => $row)
	{
		if ($row['topic_moved_id'])
		{
			if(($id = array_search($topic_id, $topic_ids, true)) !== false)
			{
				unset($topic_ids[$id]);
			}
		}
	}

	if(empty($topic_ids))
	{
		return false;
	}
	
	$sql = 'UPDATE ' . TOPICS_TABLE . "
		SET topic_type = $new_topic_type
		WHERE " . $db->sql_in_set('topic_id', $topic_ids);
	$db->sql_query($sql);

	if(($new_topic_type == POST_GLOBAL) && sizeof($topic_ids))
	{
		// Delete topic shadows for global announcements
		$sql = 'DELETE FROM ' . TOPICS_TABLE . '
			WHERE ' . $db->sql_in_set('topic_moved_id', $topic_ids);
		$db->sql_query($sql);
	}

	if (sizeof($topic_ids))
	{
		$data = qm_get_topic_data($topic_ids);

		foreach ($data as $topic_id => $row)
		{
			$phpbb_log->add('mod', $user->data['user_id'], $user->ip, 'LOG_TOPIC_TYPE_CHANGED', false, array(
				'forum_id'	=> $forum_id,
				'topic_id'	=> $topic_id,
				$row['topic_title'],
			));
		}
	}

	return (sizeof($topic_ids) == 1) ? 'TOPIC_TYPE_CHANGED' : 'TOPICS_TYPE_CHANGED';
}


// Delete Topics
function qm_delete_topic($topic_ids, $is_soft = false, $soft_delete_reason = '')
{
	global $auth, $user, $db, $phpbb_container, $phpbb_log, $phpEx, $phpbb_root_path;

	$check_permission	= ($is_soft) ? 'm_softdelete' : 'm_delete';
	$delete_ids			= array();
	
	if(!qm_check_ids($topic_ids, TOPICS_TABLE, 'topic_id', array($check_permission)))
	{
		return false;
	}

	$data = qm_get_topic_data($topic_ids);

	foreach($data as $topic_id => $row)
	{
		if($row['topic_moved_id'])
		{
			$phpbb_log->add('mod', $user->data['user_id'], $user->ip, 'LOG_DELETE_SHADOW_TOPIC', false, array(
				'forum_id'	=> $row['forum_id'],
				'topic_id'	=> $topic_id,
				$row['topic_title'],
			));
			
			$delete_ids[] = $topic_id;
		}
		else
		{
			// Only soft delete non-shadow topics
			if($is_soft)
			{
				$phpbb_content_visibility = $phpbb_container->get('content.visibility');
				$return = $phpbb_content_visibility->set_topic_visibility(ITEM_DELETED, $topic_id, $row['forum_id'], $user->data['user_id'], time(), $soft_delete_reason);
				
				if(!empty($return))
				{
					$phpbb_log->add('mod', $user->data['user_id'], $user->ip, 'LOG_SOFTDELETE_TOPIC', false, array(
						'forum_id'	=> $row['forum_id'],
						'topic_id'	=> $topic_id,
						$row['topic_title'],
						$row['topic_first_poster_name'],
						$soft_delete_reason,
					));
				}
			}
			else
			{
				$phpbb_log->add('mod', $user->data['user_id'], $user->ip, 'LOG_DELETE_TOPIC', false, array(
					'forum_id'	=> $row['forum_id'],
					'topic_id'	=> $topic_id,
					$row['topic_title'],
					$row['topic_first_poster_name'],
					$soft_delete_reason,
				));
				
				$delete_ids[] = $topic_id;
			}
		}
	}

	if(sizeof($delete_ids))
	{
		$return = delete_topics('topic_id', $delete_ids);
	}
	
	unset($delete_ids);

	return (sizeof($topic_ids) == 1) ? 'TOPIC_DELETED_SUCCESS' : 'TOPICS_DELETED_SUCCESS';
}

// Restore deleted (soft) topics
function qm_restore_topic($topic_ids)
{
	global $user, $phpbb_log, $phpbb_container;

	if(!qm_check_ids($topic_ids, TOPICS_TABLE, 'topic_id', array('m_approve')))
	{
		return;
	}

	$data = qm_get_topic_data($topic_ids);

	$phpbb_content_visibility = $phpbb_container->get('content.visibility');
		
	foreach($data as $topic_id => $row)
	{
		$return = $phpbb_content_visibility->set_topic_visibility(ITEM_APPROVED, $topic_id, $row['forum_id'], $user->data['user_id'], time(), '');
		
		if(!empty($return))
		{
			$phpbb_log->add('mod', $user->data['user_id'], $user->ip, 'LOG_RESTORE_TOPIC', false, array(
				'forum_id'	=> $row['forum_id'],
				'topic_id'	=> $topic_id,
				$row['topic_title'],
				$row['topic_first_poster_name'],
			));
		}
	}
	
	return (sizeof($topic_ids) == 1) ? 'TOPIC_RESTORED_SUCCESS' : 'TOPICS_RESTORED_SUCCESS';
}

// Move Topic
function qm_move_topic($topic_ids, $forum_id)
{
	global $auth, $user, $db, $request, $template, $phpbb_log, $phpEx, $phpbb_root_path;

	$to_forum_id = request_var('to_forum_id', 0);

	if($to_forum_id)
	{
		$forum_data = qm_get_forum_data($to_forum_id, 'f_post');

		if(!sizeof($forum_data))
		{
			return array('FORUM_NOT_EXIST', true);
		}

		$forum_data = $forum_data[$to_forum_id];

		if($forum_data['forum_type'] != FORUM_POST)
		{
			return array('FORUM_NOT_POSTABLE', true);
		}
		else if(!$auth->acl_get('f_post', $to_forum_id) || (!$auth->acl_get('m_approve', $to_forum_id) && !$auth->acl_get('f_noapprove', $to_forum_id)))
		{
			return array('USER_CANNOT_POST', true);
		}
		else if($forum_id == $to_forum_id)
		{
			return array('CANNOT_MOVE_SAME_FORUM', true);
		}
	}
	else
	{
		return array('FORUM_NOT_EXIST', true);
	}

	$topic_data = qm_get_topic_data($topic_ids, true);
	$leave_shadow = $request->is_set_post('move_leave_shadow');

	$forum_sync_data = array();

	$forum_sync_data[$forum_id] = current($topic_data);
	$forum_sync_data[$to_forum_id] = $forum_data;

	$topics_moved = $topics_moved_unapproved = $topics_moved_softdeleted = 0;
	$posts_moved = $posts_moved_unapproved = $posts_moved_softdeleted = 0;

	foreach($topic_data as $topic_id => $topic_info)
	{
		if($topic_info['topic_visibility'] == ITEM_APPROVED)
		{
			$topics_moved++;
		}
		else if($topic_info['topic_visibility'] == ITEM_UNAPPROVED || $topic_info['topic_visibility'] == ITEM_REAPPROVE)
		{
			$topics_moved_unapproved++;
		}
		else if($topic_info['topic_visibility'] == ITEM_DELETED)
		{
			$topics_moved_softdeleted++;
		}

		$posts_moved += $topic_info['topic_posts_approved'];
		$posts_moved_unapproved += $topic_info['topic_posts_unapproved'];
		$posts_moved_softdeleted += $topic_info['topic_posts_softdeleted'];
	}

	if(empty($topic_ids))
	{
		return false;
	}

	$db->sql_transaction('begin');

	// Move topics, but do not resync yet
	move_topics($topic_ids, $to_forum_id, false);

	$shadow_topics = 0;
	$forum_ids = array($to_forum_id);
	foreach($topic_data as $topic_id => $row)
	{
		// Get the list of forums to resync, add a log entry
		$forum_ids[] = $row['forum_id'];

		// We add the $to_forum_id twice, because 'forum_id' is updated
		// when the topic is moved again later.
		$phpbb_log->add('mod', $user->data['user_id'], $user->ip, 'LOG_MOVE', false, array(
			'forum_id'		=> (int) $to_forum_id,
			'topic_id'		=> (int) $topic_id,
			$row['forum_name'],
			$forum_data['forum_name'],
			(int) $row['forum_id'],
			(int) $forum_data['forum_id'],
		));

		// If we have moved a global announcement, we need to correct the topic type
		if($row['topic_type'] == POST_GLOBAL)
		{
			$sql = 'UPDATE ' . TOPICS_TABLE . '
				SET topic_type = ' . POST_ANNOUNCE . '
				WHERE topic_id = ' . (int) $row['topic_id'];
			$db->sql_query($sql);
		}

		// Leave a redirection if required and only if the topic is visible to users
		if($leave_shadow && $row['topic_visibility'] == ITEM_APPROVED && $row['topic_type'] != POST_GLOBAL)
		{
			$shadow = array(
				'forum_id'				=>	(int) $row['forum_id'],
				'icon_id'				=>	(int) $row['icon_id'],
				'topic_attachment'		=>	(int) $row['topic_attachment'],
				'topic_visibility'		=>	ITEM_APPROVED, // a shadow topic is always approved
				'topic_reported'		=>	0, // a shadow topic is never reported
				'topic_title'			=>	(string) $row['topic_title'],
				'topic_poster'			=>	(int) $row['topic_poster'],
				'topic_time'			=>	(int) $row['topic_time'],
				'topic_time_limit'		=>	(int) $row['topic_time_limit'],
				'topic_views'			=>	(int) $row['topic_views'],
				'topic_posts_approved'	=>	(int) $row['topic_posts_approved'],
				'topic_posts_unapproved'=>	(int) $row['topic_posts_unapproved'],
				'topic_posts_softdeleted'=>	(int) $row['topic_posts_softdeleted'],
				'topic_status'			=>	ITEM_MOVED,
				'topic_type'			=>	POST_NORMAL,
				'topic_first_post_id'	=>	(int) $row['topic_first_post_id'],
				'topic_first_poster_colour'=>(string) $row['topic_first_poster_colour'],
				'topic_first_poster_name'=>	(string) $row['topic_first_poster_name'],
				'topic_last_post_id'	=>	(int) $row['topic_last_post_id'],
				'topic_last_poster_id'	=>	(int) $row['topic_last_poster_id'],
				'topic_last_poster_colour'=>(string) $row['topic_last_poster_colour'],
				'topic_last_poster_name'=>	(string) $row['topic_last_poster_name'],
				'topic_last_post_subject'=>	(string)  $row['topic_last_post_subject'],
				'topic_last_post_time'	=>	(int) $row['topic_last_post_time'],
				'topic_last_view_time'	=>	(int) $row['topic_last_view_time'],
				'topic_moved_id'		=>	(int) $row['topic_id'],
				'topic_bumped'			=>	(int) $row['topic_bumped'],
				'topic_bumper'			=>	(int) $row['topic_bumper'],
				'poll_title'			=>	(string) $row['poll_title'],
				'poll_start'			=>	(int) $row['poll_start'],
				'poll_length'			=>	(int) $row['poll_length'],
				'poll_max_options'		=>	(int) $row['poll_max_options'],
				'poll_last_vote'		=>	(int) $row['poll_last_vote']
			);

			$db->sql_query('INSERT INTO ' . TOPICS_TABLE . $db->sql_build_array('INSERT', $shadow));

			// Shadow topics only count on new "topics" and not posts... a shadow topic alone has 0 posts
			$shadow_topics++;
		}
	}
	unset($topic_data);

	$sync_sql = array();
	if ($posts_moved)
	{
		$sync_sql[$to_forum_id][] = 'forum_posts_approved = forum_posts_approved + ' . (int) $posts_moved;
		$sync_sql[$forum_id][] = 'forum_posts_approved = forum_posts_approved - ' . (int) $posts_moved;
	}
	if ($posts_moved_unapproved)
	{
		$sync_sql[$to_forum_id][] = 'forum_posts_unapproved = forum_posts_unapproved + ' . (int) $posts_moved_unapproved;
		$sync_sql[$forum_id][] = 'forum_posts_unapproved = forum_posts_unapproved - ' . (int) $posts_moved_unapproved;
	}
	if ($posts_moved_softdeleted)
	{
		$sync_sql[$to_forum_id][] = 'forum_posts_softdeleted = forum_posts_softdeleted + ' . (int) $posts_moved_softdeleted;
		$sync_sql[$forum_id][] = 'forum_posts_softdeleted = forum_posts_softdeleted - ' . (int) $posts_moved_softdeleted;
	}

	if ($topics_moved)
	{
		$sync_sql[$to_forum_id][] = 'forum_topics_approved = forum_topics_approved + ' . (int) $topics_moved;
		if ($topics_moved - $shadow_topics > 0)
		{
			$sync_sql[$forum_id][] = 'forum_topics_approved = forum_topics_approved - ' . (int) ($topics_moved - $shadow_topics);
		}
	}
	if ($topics_moved_unapproved)
	{
		$sync_sql[$to_forum_id][] = 'forum_topics_unapproved = forum_topics_unapproved + ' . (int) $topics_moved_unapproved;
		$sync_sql[$forum_id][] = 'forum_topics_unapproved = forum_topics_unapproved - ' . (int) $topics_moved_unapproved;
	}
	if ($topics_moved_softdeleted)
	{
		$sync_sql[$to_forum_id][] = 'forum_topics_softdeleted = forum_topics_softdeleted + ' . (int) $topics_moved_softdeleted;
		$sync_sql[$forum_id][] = 'forum_topics_softdeleted = forum_topics_softdeleted - ' . (int) $topics_moved_softdeleted;
	}

	foreach($sync_sql as $forum_id_key => $array)
	{
		$sql = 'UPDATE ' . FORUMS_TABLE . '
			SET ' . implode(', ', $array) . '
			WHERE forum_id = ' . $forum_id_key;
		$db->sql_query($sql);
	}

	$db->sql_transaction('commit');

	sync('forum', 'forum_id', array($forum_id, $to_forum_id));

	return (sizeof($topic_ids) == 1) ? 'TOPIC_MOVED_SUCCESS' : 'TOPICS_MOVED_SUCCESS';
}

function qm_approve_topic($action, $topic_ids)
{
	global $db, $request, $user, $phpbb_container, $phpbb_dispatcher, $phpbb_log, $phpbb_root_path, $phpEx;

	include($phpbb_root_path . 'includes/functions_messenger.' . $phpEx);

	$notify_poster	= $request->is_set_post('send_notify');
	$topic_info		= qm_get_topic_data($topic_ids, true, 'm_approve');
	
	$phpbb_content_visibility = $phpbb_container->get('content.visibility');
	$first_post_ids = array();

	foreach($topic_info as $topic_id => $topic_data)
	{
		$phpbb_content_visibility->set_topic_visibility(ITEM_APPROVED, $topic_id, $topic_data['forum_id'], $user->data['user_id'], time(), '');
		$first_post_ids[$topic_id] = (int)$topic_data['topic_first_post_id'];

		$topic_url = append_sid("{$phpbb_root_path}viewtopic.$phpEx", "f={$topic_data['forum_id']}&amp;t={$topic_id}");

		$approve_log[] = array(
			'forum_id'		=> $topic_data['forum_id'],
			'topic_id'		=> $topic_data['topic_id'],
			'topic_title'	=> $topic_data['topic_title'],
		);
	}
	
	foreach($approve_log as $log_data)
	{
		$phpbb_log->add('mod', $user->data['user_id'], $user->ip, 'LOG_TOPIC_' . strtoupper($action) . 'D', false, array(
			'forum_id'	=> $log_data['forum_id'],
			'topic_id'	=> $log_data['topic_id'],
			$log_data['topic_title'],
		));
	}
	
	// Grab the first post text as it's needed for the quote notification.
	$sql = 'SELECT topic_id, post_text
		FROM ' . POSTS_TABLE . '
		WHERE ' . $db->sql_in_set('post_id', $first_post_ids);
	$result = $db->sql_query($sql);
	while($row = $db->sql_fetchrow($result))
	{
		$topic_info[$row['topic_id']]['post_text'] = $row['post_text'];
	}
	$db->sql_freeresult($result);

	// Handle notifications
	$phpbb_notifications = $phpbb_container->get('notification_manager');

	foreach($topic_info as $topic_id => $topic_data)
	{
		$topic_data = array_merge($topic_data, array(
			'post_id'		=> $topic_data['topic_first_post_id'],
			'post_subject'	=> $topic_data['topic_title'],
			'post_time'		=> $topic_data['topic_time'],
			'poster_id'		=> $topic_data['topic_poster'],
			'post_username'	=> $topic_data['topic_first_poster_name'],
		));

		$phpbb_notifications->delete_notifications('notification.type.topic_in_queue', $topic_id);

		// Only add notifications, if we are not reapproving post
		// When the topic was already approved, but was edited and
		// now needs re-approval, we don't want to notify the users
		// again.
		if($topic_data['topic_visibility'] == ITEM_UNAPPROVED)
		{
			$phpbb_notifications->add_notifications(array(
				'notification.type.quote',
				'notification.type.topic',
			), $topic_data);
		}

		if(phpbb_version_compare(PHPBB_VERSION, '3.2.0', '>='))
		{
			$phpbb_notifications->mark_notifications('notification.type.quote', $topic_data['post_id'], $user->data['user_id']);
			$phpbb_notifications->mark_notifications('notification.type.topic', $topic_id, $user->data['user_id']);
		}
		else
		{
			$phpbb_notifications->mark_notifications_read('notification.type.quote', $topic_data['post_id'], $user->data['user_id']);
			$phpbb_notifications->mark_notifications_read('notification.type.topic', $topic_id, $user->data['user_id']);
		}

		if($notify_poster)
		{
			$phpbb_notifications->add_notifications('notification.type.approve_topic', $topic_data);
		}
	}
	
	$success_msg	= (sizeof($topic_info) == 1) ? 'TOPIC_' . strtoupper($action) . 'D_SUCCESS' : 'TOPICS_' . strtoupper($action) . 'D_SUCCESS';
	$redirect		= '';
	
	/**
	 * Perform additional actions during topics(s) approval
	 *
	 * @event core.approve_topics_after
	 * @var	string	action				Variable containing the action we perform on the posts ('approve' or 'restore')
	 * @var	mixed	topic_info			Array containing info for all topics being approved
	 * @var	array	first_post_ids		Array containing ids of all first posts
	 * @var bool	notify_poster		Variable telling if the poster should be notified or not
	 * @var	string	success_msg			Variable containing the language key for the success message
	 * @var string	redirect			Variable containing the redirect url
	 * @since 3.1.4-RC1
	 */
	$vars = array(
		'action',
		'topic_info',
		'first_post_ids',
		'notify_poster',
		'success_msg',
		'redirect',
	);
	extract($phpbb_dispatcher->trigger_event('core.approve_topics_after', compact($vars)));

	return $success_msg;
}

function qm_change_poster($topic_ids)
{
	global $db, $auth, $phpbb_root_path, $phpEx;

	$post_ids = array();
	$username = utf8_normalize_nfc(request_var('username', '', true));
	
	$sql = 'SELECT *
		FROM ' . USERS_TABLE . "
		WHERE username_clean = '" . $db->sql_escape(utf8_clean_string($username)) . "'";
	$result = $db->sql_query($sql);
	$userdata = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	
	if(!$userdata)
	{
		return false;
	}
	
	// Get the posts ids
	$sql = 'SELECT topic_first_post_id
		FROM ' . TOPICS_TABLE . '
		WHERE ' . $db->sql_in_set('topic_id', $topic_ids);
	$result = $db->sql_query($sql);
	while($row = $db->sql_fetchrow($result))
	{
		$post_ids[] = $row['topic_first_post_id'];
	}
	$db->sql_freeresult($result);

	if(!empty($post_ids))
	{
		// Get posts data
		$posts_info = qm_get_post_data($post_ids, false, true);
		
		// Update all posts
		$sql = 'UPDATE ' . POSTS_TABLE . '
			SET poster_id = ' . $userdata['user_id'] . '
			WHERE ' . $db->sql_in_set('post_id', $post_ids);
		$db->sql_query($sql);
		
		// sync the posts info
		foreach($posts_info as $post_id => $post_info)
		{
			if($auth->acl_get('m_chgposter', $post_info['forum_id']))
			{
				_qm_change_poster($post_info, $userdata);
			}
		}
		
		return 'AUTHOR_CHANGE_SUCCESS';
	}
	
	return false;
}

/**
* Change a post's poster
*/
function _qm_change_poster($post_info, $userdata)
{
	global $auth, $db, $config, $user, $phpbb_dispatcher, $phpbb_log, $phpbb_root_path, $phpEx;

	if (empty($userdata) || $userdata['user_id'] == $post_info['user_id'])
	{
		return;
	}

	$post_id = $post_info['post_id'];

	// Resync topic/forum if needed
	if ($post_info['topic_last_post_id'] == $post_id || $post_info['forum_last_post_id'] == $post_id || $post_info['topic_first_post_id'] == $post_id)
	{
		sync('topic', 'topic_id', $post_info['topic_id'], false, false);
		sync('forum', 'forum_id', $post_info['forum_id'], false, false);
	}

	// Adjust post counts... only if the post is approved (else, it was not added the users post count anyway)
	if ($post_info['post_postcount'] && $post_info['post_visibility'] == ITEM_APPROVED)
	{
		$sql = 'UPDATE ' . USERS_TABLE . '
			SET user_posts = user_posts - 1
			WHERE user_id = ' . $post_info['user_id'] .'
			AND user_posts > 0';
		$db->sql_query($sql);

		$sql = 'UPDATE ' . USERS_TABLE . '
			SET user_posts = user_posts + 1
			WHERE user_id = ' . $userdata['user_id'];
		$db->sql_query($sql);
	}

	// Add posted to information for this topic for the new user
	markread('post', $post_info['forum_id'], $post_info['topic_id'], time(), $userdata['user_id']);

	// Remove the dotted topic option if the old user has no more posts within this topic
	if ($config['load_db_track'] && $post_info['user_id'] != ANONYMOUS)
	{
		$sql = 'SELECT topic_id
			FROM ' . POSTS_TABLE . '
			WHERE topic_id = ' . $post_info['topic_id'] . '
				AND poster_id = ' . $post_info['user_id'];
		$result = $db->sql_query_limit($sql, 1);
		$topic_id = (int) $db->sql_fetchfield('topic_id');
		$db->sql_freeresult($result);

		if (!$topic_id)
		{
			$sql = 'DELETE FROM ' . TOPICS_POSTED_TABLE . '
				WHERE user_id = ' . $post_info['user_id'] . '
					AND topic_id = ' . $post_info['topic_id'];
			$db->sql_query($sql);
		}
	}

	// change the poster_id within the attachments table, else the data becomes out of sync and errors displayed because of wrong ownership
	if($post_info['post_attachment'])
	{
		$sql = 'UPDATE ' . ATTACHMENTS_TABLE . '
			SET poster_id = ' . $userdata['user_id'] . '
			WHERE poster_id = ' . $post_info['user_id'] . '
				AND post_msg_id = ' . $post_info['post_id'] . '
				AND topic_id = ' . $post_info['topic_id'];
		$db->sql_query($sql);
	}

	// refresh search cache of this post
	$search_type = $config['search_type'];

	if(class_exists($search_type))
	{
		// We do some additional checks in the module to ensure it can actually be utilised
		$error = false;
		$search = new $search_type($error, $phpbb_root_path, $phpEx, $auth, $config, $db, $user, $phpbb_dispatcher);

		if(!$error && method_exists($search, 'destroy_cache'))
		{
			$search->destroy_cache(array(), array($post_info['user_id'], $userdata['user_id']));
		}
	}
	
	/**
	* This event allows you to perform additional tasks after changing a post's poster
	*
	* @event core.mcp_change_poster_after
	* @var	array	userdata	Information on a post's new poster
	* @var	array	post_info	Information on the affected post
	* @since 3.1.6-RC1
	* @changed 3.1.7-RC1		Change location to prevent post_info from being set to the new post information
	*/
	$vars = array('userdata', 'post_info');
	extract($phpbb_dispatcher->trigger_event('core.mcp_change_poster_after', compact($vars)));

	// Now add log entry
	$phpbb_log->add('mod', $user->data['user_id'], $user->ip, 'LOG_MCP_CHANGE_POSTER', false, array(
		'forum_id'	=> $post_info['forum_id'],
		'topic_id'	=> $post_info['topic_id'],
		$post_info['topic_title'],
		$post_info['username'],
		$userdata['username'],
	));	
}

function qm_change_icon($topic_ids)
{
	global $db;

	$post_ids = array();
	$icon_id = request_var('icon', 0);
	
	// Get the posts ids
	$sql = 'SELECT topic_first_post_id
		FROM ' . TOPICS_TABLE . '
		WHERE ' . $db->sql_in_set('topic_id', $topic_ids);
	$result = $db->sql_query($sql);
	while($row = $db->sql_fetchrow($result))
	{
		$post_ids[] = $row['topic_first_post_id'];
	}
	$db->sql_freeresult($result);
	
	// Update the topic's icons
	$sql = 'UPDATE ' . TOPICS_TABLE . '
		SET icon_id = ' . $icon_id . '
		WHERE ' . $db->sql_in_set('topic_id', $topic_ids);
	$db->sql_query($sql);

	// Update the first post's icons
	if(!empty($post_ids))
	{
		$sql = 'UPDATE ' . POSTS_TABLE . '
			SET icon_id = ' . $icon_id . '
			WHERE ' . $db->sql_in_set('post_id', $post_ids);
		$db->sql_query($sql);
	}
	
	return 'ICON_CHANGE_SUCCESS';
}

function qm_change_time($topic_ids)
{
	global $db, $user;
	
	$time	= $user->create_datetime();
	$now	= phpbb_gmgetdate($time->getTimestamp() + $time->getOffset());
	
	$new_day	= request_var('day', $now['mday']);
	$new_month	= request_var('month', $now['mon']);
	$new_year	= request_var('year', $now['year']);
	$new_hour	= array_map('intval', explode(':', request_var('hour', '00:00:00')));
	
	if(!$new_day || !$new_month || !$new_year || sizeof($new_hour) != 3)
	{
		return false;
	}

	$new_time = gmmktime($new_hour[0], $new_hour[1], $new_hour[2], (int)$new_month, (int)$new_day, (int)$new_year) - $time->getOffset();

	$post_ids = $updated_forums = $last_post_ids = array();
	$last_topic_id = $timeadd = 0;
	
	// Get some neccessary data before continue
	$sql = 'SELECT p.post_id, p.topic_id, p.forum_id, p.poster_id, p.post_subject, p.post_time, p.post_visibility,
		u.username, u.user_colour
		FROM ' . POSTS_TABLE . ' p
			LEFT JOIN ' . USERS_TABLE . ' u ON(u.user_id = p.poster_id)
		WHERE ' . $db->sql_in_set('p.topic_id', $topic_ids) . '
		ORDER BY p.topic_id ASC, p.post_time ASC';
	$result = $db->sql_query($sql);
	while($row = $db->sql_fetchrow($result))
	{
		$topic_id = (int)$row['topic_id'];
		$forum_id = (int)$row['forum_id'];

		if($row['post_time'] < $new_time)
		{
			// Add 1 minute to the last time
			$timeadd += 60;

			if($last_topic_id != $topic_id)
			{
				$last_topic_id = $topic_id;
				$time_add = 0;
			}
			
			// Maintain a time difference to keep post order
			$row['post_time'] = $new_time + $timeadd;
			
			$post_ids[$row['post_id']] = $row['post_time'];
		}
		
		// Maintain the order for the last post if required update
		if($row['post_visibility'] == ITEM_APPROVED)
		{
			$updated_forums[] = $forum_id;
		}
	}
	$db->sql_freeresult($result);

	// Set the new time for the first posts
	$sql = 'SELECT topic_first_post_id, topic_last_post_id
		FROM ' . TOPICS_TABLE . '
		WHERE ' . $db->sql_in_set('topic_id', $topic_ids);
	$result = $db->sql_query($sql);
	while($row = $db->sql_fetchrow($result))
	{
		$post_ids[$row['topic_first_post_id']] = $new_time;
		$last_post_ids[] = $row['topic_last_post_id'];
	}
	$db->sql_freeresult($result);
	
	// Update the time of the posts and topics
	$sql = 'UPDATE ' . TOPICS_TABLE . "
		SET topic_time = $new_time
		WHERE " . $db->sql_in_set('topic_id', $topic_ids);
	$db->sql_query($sql);

	foreach($post_ids as $post_id => $post_time)
	{
		$sql = 'UPDATE ' . POSTS_TABLE . "
			SET post_time = $post_time
			WHERE post_id = $post_id";
		$db->sql_query($sql);
		
		// Update the time of last post in topic
		if(in_array($post_id, $last_post_ids))
		{
			$sql = 'UPDATE ' . TOPICS_TABLE . "
				SET topic_last_post_time = $post_time
				WHERE topic_last_post_id = $post_id";
			$db->sql_query($sql);
		}
	}
	
	// Obtain and update the time of the last posts on involved forums
	if(sizeof($updated_forums))
	{
		$updated_forums = array_unique($updated_forums);

		$sql = 'SELECT t.forum_id, t.topic_last_post_id, t.topic_last_poster_id, t.topic_last_post_subject, t.topic_last_post_time, 
			t.topic_last_poster_name, t.topic_last_poster_colour, f.forum_last_post_time
			FROM ' . TOPICS_TABLE . ' t
				LEFT JOIN ' . FORUMS_TABLE . ' f ON(f.forum_id = t.forum_id)
			WHERE t.topic_last_post_id = (
				SELECT p.post_id
					FROM ' . POSTS_TABLE . ' p
					WHERE p.forum_id = t.forum_id
					ORDER BY p.post_time DESC
					LIMIT 1
			)
			AND ' . $db->sql_in_set('t.forum_id', $updated_forums);
		$result = $db->sql_query($sql);
		
		$updated_forums = array();
		
		while($row = $db->sql_fetchrow($result))
		{
			if($row['forum_last_post_time'] != $row['topic_last_post_time'])
			{
				$updated_forums[$row['forum_id']] = $row;
			}
		}
		$db->sql_freeresult($result);
		
		foreach($updated_forums as $forum_id => $row)
		{
			$sql_ary = array(
				'forum_last_post_id'		=> $row['topic_last_post_id'],
				'forum_last_poster_id'		=> $row['topic_last_poster_id'],
				'forum_last_post_subject'	=> $row['topic_last_post_subject'],
				'forum_last_post_time'		=> $row['topic_last_post_time'],
				'forum_last_poster_name'	=> $row['topic_last_poster_name'],
				'forum_last_poster_colour'	=> $row['topic_last_poster_colour'],
			);
			
			$sql = 'UPDATE ' . FORUMS_TABLE . '
				SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE forum_id = ' . $forum_id;
			$db->sql_query($sql);
		}
	}
	
	return 'TIME_CHANGE_SUCCESS';
}

function qm_get_topic_data($ids, $full = false, $acl_list = false)
{
	global $auth, $db;

	$topic_row = array();

	if($full)
	{
		$sql = 'SELECT t.*, f.*
			FROM ' . TOPICS_TABLE . ' t
			LEFT JOIN ' . FORUMS_TABLE . ' f ON(f.forum_id = t.forum_id)';
	}
	else
	{
		$sql = 'SELECT t.* FROM ' . TOPICS_TABLE . ' t';
	}

	$sql .= ' WHERE ' . $db->sql_in_set('t.topic_id', $ids);

	$result = $db->sql_query($sql);
	while($row = $db->sql_fetchrow($result))
	{
		if($acl_list && !$auth->acl_gets($acl_list, $row['forum_id']))
		{
			continue;
		}

		$topic_row[$row['topic_id']] = $row;
	}

	return $topic_row;
}

/**
* Get simple forum data
*/
function qm_get_forum_data($forum_id, $acl_list = 'f_list', $read_tracking = false)
{
	global $auth, $db, $user, $config, $phpbb_container;

	$rowset = array();

	if (!is_array($forum_id))
	{
		$forum_id = array($forum_id);
	}

	if (!sizeof($forum_id))
	{
		return array();
	}

	if ($read_tracking && $config['load_db_lastread'])
	{
		$read_tracking_join = ' LEFT JOIN ' . FORUMS_TRACK_TABLE . ' ft ON (ft.user_id = ' . $user->data['user_id'] . '
			AND ft.forum_id = f.forum_id)';
		$read_tracking_select = ', ft.mark_time';
	}
	else
	{
		$read_tracking_join = $read_tracking_select = '';
	}

	$sql = "SELECT f.* $read_tracking_select
		FROM " . FORUMS_TABLE . " f$read_tracking_join
		WHERE " . $db->sql_in_set('f.forum_id', $forum_id);
	$result = $db->sql_query($sql);
	
	$phpbb_content_visibility = $phpbb_container->get('content.visibility');

	while ($row = $db->sql_fetchrow($result))
	{
		if($acl_list && !$auth->acl_gets($acl_list, $row['forum_id']))
		{
			continue;
		}

		$row['forum_topics_approved'] = $phpbb_content_visibility->get_count('forum_topics', $row, $row['forum_id']);

		$rowset[$row['forum_id']] = $row;
	}
	$db->sql_freeresult($result);

	return $rowset;
}

/**
* Validate ids
*
* @param	array	&$ids			The relevant ids to check
* @param	string	$table			The table to find the ids in
* @param	string	$sql_id			The ids relevant column name
* @param	array	$acl_list		A list of permissions the user need to have
*
* @return	mixed	False if no ids were able to be retrieved, true if at least one id left.
*
*/
function qm_check_ids(&$ids, $table, $sql_id, $acl_list = false)
{
	global $db, $auth;

	if (!is_array($ids) || empty($ids))
	{
		return false;
	}

	$sql = "SELECT $sql_id, forum_id FROM $table
		WHERE " . $db->sql_in_set($sql_id, $ids);
	$result = $db->sql_query($sql);

	$ids = array();
	$forum_id = false;

	while($row = $db->sql_fetchrow($result))
	{
		if($acl_list && $row['forum_id'] && !$auth->acl_gets($acl_list, $row['forum_id']))
		{
			continue;
		}

		if($acl_list && !$row['forum_id'] && !$auth->acl_getf_global($acl_list))
		{
			continue;
		}

		// Always add a global topic
		$ids[] = $row[$sql_id];
	}
	$db->sql_freeresult($result);

	if (!sizeof($ids))
	{
		return false;
	}

	return true;
}

/**
* Get simple post data
*/
function qm_get_post_data($post_ids, $acl_list = false, $read_tracking = false)
{
	global $db, $auth, $config, $user;

	$rowset = array();

	if(!sizeof($post_ids))
	{
		return array();
	}

	$sql_array = array(
		'SELECT'	=> 'p.*, u.*, t.*, f.*',

		'FROM'		=> array(
			USERS_TABLE		=> 'u',
			POSTS_TABLE		=> 'p',
			TOPICS_TABLE	=> 't',
		),

		'LEFT_JOIN'	=> array(
			array(
				'FROM'	=> array(FORUMS_TABLE => 'f'),
				'ON'	=> 'f.forum_id = t.forum_id'
			)
		),

		'WHERE'		=> $db->sql_in_set('p.post_id', $post_ids) . '
			AND u.user_id = p.poster_id
			AND t.topic_id = p.topic_id',
	);

	if ($read_tracking && $config['load_db_lastread'])
	{
		$sql_array['SELECT'] .= ', tt.mark_time, ft.mark_time as forum_mark_time';

		$sql_array['LEFT_JOIN'][] = array(
			'FROM'	=> array(TOPICS_TRACK_TABLE => 'tt'),
			'ON'	=> 'tt.user_id = ' . $user->data['user_id'] . ' AND t.topic_id = tt.topic_id'
		);

		$sql_array['LEFT_JOIN'][] = array(
			'FROM'	=> array(FORUMS_TRACK_TABLE => 'ft'),
			'ON'	=> 'ft.user_id = ' . $user->data['user_id'] . ' AND t.forum_id = ft.forum_id'
		);
	}

	$sql = $db->sql_build_query('SELECT', $sql_array);
	$result = $db->sql_query($sql);
	unset($sql_array);

	while($row = $db->sql_fetchrow($result))
	{
		if (!$row['forum_id'])
		{
			// Global Announcement?
			$row['forum_id'] = request_var('f', 0);
		}

		if ($acl_list && !$auth->acl_gets($acl_list, $row['forum_id']))
		{
			continue;
		}

		if ($row['post_visibility'] != ITEM_APPROVED && !$auth->acl_get('m_approve', $row['forum_id']))
		{
			// Moderators without the permission to approve post should at least not see them. ;)
			continue;
		}

		$rowset[$row['post_id']] = $row;
	}
	$db->sql_freeresult($result);

	return $rowset;
}
