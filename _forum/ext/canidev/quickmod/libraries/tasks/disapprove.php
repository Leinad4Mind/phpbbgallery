<?php
/**
 * @package cBB QuickMod
 * @version 1.1.5 20/10/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

class disapprove extends base
{
	public $permissions = 'm_approve';
	public $category 	= 'OPTIONS_BASIC';
	public $icon 		= 'fa-ban';
	public $order 		= 2;
	public $title 		= 'DISAPPROVE_TOPIC';

	protected $container;
	protected $notifications;
	protected $visibility;

	/**
	 * {@inheritDoc}
	 */
	public function __construct($container)
	{
		parent::__construct($container);

		$this->container 		= $container;
		$this->notifications 	= $container->get('notification_manager');
		$this->visibility 		= $container->get('content.visibility');
	}

	/**
	 * {@inheritDoc}
	 */
	public function available_on_row($topic_type, $topic_status, $topic_visibility)
	{
		return $topic_visibility != ITEM_DELETED && $topic_status != ITEM_MOVED;
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(array $topic_ids, $forum_id)
	{
		if($this->core->modal_dialog(true))
		{
			$reason_id 			= $this->request->variable('reason_id', 0);
			$notify_poster		= $this->request->is_set_post('send_notify');
			$topic_info			= phpbb_get_topic_data($topic_ids, $this->permissions);

			$user_track = $delete_ary = [];

			// Get poster information
			foreach($topic_info as $topic_id => $topic_data)
			{
				$user_track[] = $topic_data['topic_poster'];
			}

			$sql = 'SELECT user_id, user_lang
				FROM ' . USERS_TABLE . '
				WHERE ' . $this->db->sql_in_set('user_id', array_unique($user_track));
			$result = $this->db->sql_query($sql);

			$user_track = [];

			while($row = $this->db->sql_fetchrow($result))
			{
				$user_track[$row['user_id']] = $row['user_lang'];
			}
			$this->db->sql_freeresult($result);

			// Get reason info
			$sql = 'SELECT reason_title, reason_description
				FROM ' . REPORTS_REASONS_TABLE . "
				WHERE reason_id = $reason_id";
			$result = $this->db->sql_query($sql);
			$reason_row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
	
			foreach($topic_info as $topic_id => $topic_data)
			{
				// Ignore deleted topics
				if($topic_data['topic_visibility'] == ITEM_DELETED)
				{
					continue;
				}

				// If topic is already approved, only mark as unapproved, else, delete it
				if($topic_data['topic_visibility'] == ITEM_APPROVED)
				{
					$this->visibility->set_topic_visibility(ITEM_REAPPROVE, $topic_id, $topic_data['forum_id'], $this->user->data['user_id'], time(), '');
				}
				else
				{
					$delete_ary[] = $topic_data['topic_id'];
				}

				// Save log
				$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_TOPIC_DISAPPROVED', false, [
					'forum_id'	=> $topic_data['forum_id'],
					'topic_id'	=> ($topic_data['topic_visibility'] == ITEM_APPROVED) ? $topic_data['topic_id'] : 0,
					$topic_data['topic_title'],
					$this->get_reason($reason_row),
					$topic_data['topic_first_poster_name']
				]);
			}

			if(sizeof($delete_ary))
			{
				delete_topics('topic_id', $delete_ary);
			}
	
			// Handle notifications
			foreach($topic_info as $topic_id => $topic_data)
			{
				$this->notifications->delete_notifications(
					[
						'notification.type.quote',
						'notification.type.topic',
						'notification.type.topic_in_queue',
					],
					$topic_id
				);

				if($notify_poster)
				{
					$topic_data = array_merge($topic_data, [
						'post_time'			=> $topic_data['topic_time'],
						'post_username'		=> $topic_data['topic_first_poster_name'],
						'poster_id'			=> $topic_data['topic_poster'],
						'disapprove_reason'	=> $this->get_reason($reason_row, isset($user_track[$topic_data['topic_poster']]) ? $user_track[$topic_data['topic_poster']] : null)
					]);

					$this->notifications->add_notifications('notification.type.disapprove_topic', $topic_data);
				}
			}
			
			$success_msg = ((sizeof($topic_ids) == 1) ? 'TOPIC' : 'TOPICS') . '_DISAPPROVED_SUCCESS';

			$this->response->add('message', $this->language->lang($success_msg));
			return true;
		}

		$this->template->assign_vars([
			'DIALOG_CONTENT'	=> true,
			'S_DISAPPROVE'		=> true,
		]);

		$this->container->get('phpbb.report.report_reason_list_provider')->display_reasons();

		$this->core->modal_dialog(
			false,
			$this->title,
			[
				'action'		=> 'disapprove',
				'topic_id_list'	=> $topic_ids,
			],
			'@canidev_quickmod/quickmod_ajax.html',
			[
				'dialogWidth'	=> 800
			]
		);
	}

	/**
	 * Get disapproved reason in correct language
	 * 
	 * @param array 	$reason_row 		Reason data
	 * @param string 	$user_lang 			User language ISO
	 * 
	 * @return string
	 * @access private
	 */
	protected function get_reason($reason_row, $user_lang = null)
	{
		$reason 			= $this->request->variable('reason', '', true);
		$disapprove_reason 	= '';
		$lang_key 			= strtoupper($reason_row['reason_title']);

		if($user_lang === null || $user_lang == $this->user->lang_name)
		{
			if(strtolower($reason_row['reason_title']) != 'other')
			{
				$report_reasons 	= $this->language->lang_raw('report_reasons');
				$disapprove_reason 	= (isset($report_reasons['DESCRIPTION'][$lang_key]) ? $report_reasons['DESCRIPTION'][$lang_key] : $reason_row['reason_description']);
			}

			$disapprove_reason .= ($reason) ? "\n\n" . $reason : '';

			return $disapprove_reason;
		}

		if(file_exists($this->phpbb_root_path . 'language/' . $user_lang . '/mcp.' . $this->php_ext))
		{
			// Load up the language pack
			$lang = [];
			include($this->phpbb_root_path . 'language/' . $user_lang . '/mcp.' . $this->php_ext);

			if(strtolower($reason_row['reason_title']) != 'other')
			{
				$report_reasons 	= isset($lang['report_reasons']) ? $lang['report_reasons'] : [];
				$disapprove_reason 	= (isset($report_reasons['DESCRIPTION'][$lang_key]) ? $report_reasons['DESCRIPTION'][$lang_key] : $reason_row['reason_description']);
			}

			$disapprove_reason .= ($reason) ? "\n\n" . $reason : '';

			unset($lang);

			return $disapprove_reason;
		}

		return ($user_lang == 'en') ? '' : $this->get_reason($reason_row, 'en');
	}
}
