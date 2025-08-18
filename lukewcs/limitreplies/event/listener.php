<?php
/**
*
* Limit Multiple Replies. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
* @license GNU General Public License, version 2 (GPL-2.0-only)
*
* Note: This extension is 100% genuine handcraft and consists of selected
*       natural raw materials. There was no AI involved in making it.
*
*/

namespace lukewcs\limitreplies\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $language;
	protected $template;
	protected $config;
	protected $auth;
	protected $user;
	protected $db;

	public function __construct(
		\phpbb\language\language $language,
		\phpbb\template\template $template,
		\phpbb\config\config $config,
		\phpbb\auth\auth $auth,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db
	)
	{
		$this->language			= $language;
		$this->template			= $template;
		$this->config			= $config;
		$this->auth				= $auth;
		$this->user				= $user;
		$this->db				= $db;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.viewtopic_modify_page_title' 	=> 'set_template_vars',
			'core.modify_posting_auth'			=> 'check_posting',
			'core.permissions'					=> 'add_permissions',
		];
	}

	public function set_template_vars($event): void
	{
		if ($this->user->data['user_type'] != USER_NORMAL
			|| $this->auth->acl_get('u_limitreplies_bypass_lock')
			|| !$this->config['limitreplies_switch_enable']
			|| $event['topic_data']['topic_status'] == ITEM_LOCKED
		)
		{
			return;
		}

		$locked_until_time = $this->get_lock_time($event['topic_data']);

		if ($locked_until_time)
		{
			$this->template->assign_vars([
				'S_QUICK_REPLY' 				=> false,
				'LIMITREPLIES_MESSAGE' 			=> $this->create_message($locked_until_time),
				'LIMITREPLIES_SELECT_HINT_MODE'	=> (int) $this->config['limitreplies_select_hint_mode'],
			]);
		}
	}

	public function check_posting($event): void
	{
		if ($this->user->data['user_type'] != USER_NORMAL
			|| !in_array($event['mode'], ['reply', 'quote', 'bump'])
			|| $this->auth->acl_get('u_limitreplies_bypass_lock')
			|| !$this->config['limitreplies_switch_enable']
			|| $event['post_data']['topic_status'] == ITEM_LOCKED
		)
		{
			return;
		}

		$locked_until_time = $this->get_lock_time($event['post_data']);

		if ($locked_until_time)
		{
			trigger_error($this->create_message($locked_until_time));
		}
	}

	public function add_permissions($event): void
	{
		$event->update_subarray('permissions', 'u_limitreplies_bypass_lock', ['lang' => 'ACL_U_LIMITREPLIES_BYPASS_LOCK', 'cat' => 'post']);
	}

	private function get_lock_time(array $topic_data): int
	{
		$wait_time			= $this->config['limitreplies_number_wait_time'] * 60;
		$locked_until_time	= 0;

		// Check whether there are posts in the queue of the topic.
		if ($topic_data['topic_posts_unapproved'])
		{
			// Get the data of the user's last post in the topic queue, if such a post exists.
			$sql = 'SELECT post_id, post_time
					FROM ' . POSTS_TABLE . '
					WHERE topic_id = ' . (int) $topic_data['topic_id'] . '
						AND poster_id = ' . (int) $this->user->data['user_id'] . '
						AND post_visibility = 0
					ORDER BY post_time DESC LIMIT 1';
			$result = $this->db->sql_query($sql);
			$last_unapproved_post = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			// Check if the timestamp of the user's last post in the queue is greater than the timestamp of the last visible post.
			if ($last_unapproved_post !== false && $last_unapproved_post['post_time'] > $topic_data['topic_last_post_time'])
			{
				$locked_until_time = $last_unapproved_post['post_time'] + $wait_time;
			}
		}

		// Check if the last visible post was from the same user.
		if ($locked_until_time == 0 && $topic_data['topic_last_poster_id'] == $this->user->data['user_id'])
		{
			$locked_until_time = $topic_data['topic_last_post_time'] + $wait_time;
		}

		return $locked_until_time > time() ? $locked_until_time : 0;
	}

	private function create_message(int $locked_until_time): string
	{
		$this->language->add_lang('limitreplies', 'lukewcs/limitreplies');

		return $this->language->lang('LIMITREPLIES_MSG_REPLY_DENIED',
			$this->language->lang('LIMITREPLIES_MINUTES_PLURAL', (int) $this->config['limitreplies_number_wait_time']),
			$this->user->format_date($locked_until_time)
		);
	}
}
