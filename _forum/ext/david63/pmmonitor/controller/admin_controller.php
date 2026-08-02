<?php
/**
 * @package PM Monitor
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\pmmonitor\controller;

use david63\pmmonitor\core\message_repository;
use david63\pmmonitor\core\selection_parser;
use david63\pmmonitor\core\sort_policy;
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\language\language;
use phpbb\log\log;
use phpbb\pagination;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class admin_controller
{
	const FORM_KEY = 'david63_pmmonitor';

	protected $config;
	protected $request;
	protected $template;
	protected $pagination;
	protected $user;
	protected $auth;
	protected $language;
	protected $log;
	protected $messages;
	protected $root_path;
	protected $php_ext;
	protected $u_action;

	public function __construct(config $config, request_interface $request, template $template, pagination $pagination, user $user, auth $auth, language $language, log $log, message_repository $messages, $root_path, $php_ext)
	{
		$this->config = $config;
		$this->request = $request;
		$this->template = $template;
		$this->pagination = $pagination;
		$this->user = $user;
		$this->auth = $auth;
		$this->language = $language;
		$this->log = $log;
		$this->messages = $messages;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public function display_output()
	{
		$this->language->add_lang('acp_pmmonitor', 'david63/pmmonitor');
		$this->assert_permission('a_pmmonitor_view');
		add_form_key(self::FORM_KEY);
		$this->handle_deletion();

		$start = max(0, $this->request->variable('start', 0));
		$sort_key = sort_policy::key($this->request->variable('sk', 'd'));
		$sort_direction = sort_policy::direction($this->request->variable('sd', 'd'));
		$per_page = max(1, min(100, (int) $this->config['topics_per_page']));
		$total = $this->messages->count_messages();
		$rows = $total > 0 ? $this->messages->fetch_page($sort_key, $sort_direction, $per_page, $start) : array();
		$sessions = $this->session_times($rows);
		$this->assign_selected_message($start, $sort_key, $sort_direction);

		foreach ($rows as $row)
		{
			$this->assign_message($row, $sessions, $start, $sort_key, $sort_direction);
		}

		$this->assign_sorting($sort_key, $sort_direction);
		$pagination_action = $this->u_action . '&amp;sk=' . $sort_key . '&amp;sd=' . $sort_direction;
		$this->pagination->generate_template_pagination($pagination_action, 'pagination', 'start', $total, $per_page, $start);
		$this->template->assign_vars(array(
			'MESSAGE_COUNT' => $total,
			'S_CAN_DELETE' => $this->auth->acl_get('a_pmmonitor_delete'),
			'S_HAS_MESSAGES' => !empty($rows),
			'U_ACTION' => $this->u_action,
		));
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PM_MONITOR_VIEW', false, array($start));
	}

	protected function handle_deletion()
	{
		if (!$this->request->is_set_post('delete'))
		{
			return;
		}
		$this->assert_permission('a_pmmonitor_delete');
		if (!check_form_key(self::FORM_KEY))
		{
			trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
		}

		$marked = $this->request->variable('mark', array(''));
		if (empty($marked))
		{
			trigger_error($this->language->lang('NO_PM_SELECTED') . adm_back_link($this->u_action), E_USER_WARNING);
		}
		$selections = selection_parser::parse($marked);
		if ($selections === false)
		{
			trigger_error($this->language->lang('INVALID_PM_SELECTION') . adm_back_link($this->u_action), E_USER_WARNING);
		}

		if (confirm_box(true))
		{
			$deleted = $this->messages->delete_recipient_copies($selections);
			if ($deleted === false)
			{
				trigger_error($this->language->lang('INVALID_PM_SELECTION') . adm_back_link($this->u_action), E_USER_WARNING);
			}
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PM_MONITOR_DELETE', false, array($deleted));
			trigger_error($this->language->lang('PM_DELETED_SUCCESS', $deleted) . adm_back_link($this->u_action));
		}

		confirm_box(false, $this->language->lang('CONFIRM_DELETE'), build_hidden_fields(array(
			'mark' => $marked,
			'delete' => 1,
			'creation_time' => $this->request->variable('creation_time', 0),
			'form_token' => $this->request->variable('form_token', ''),
		)));
	}

	protected function assign_message(array $row, array $sessions, $start, $sort_key, $sort_direction)
	{
		$author_id = (int) $row['author_id'];
		$recipient_id = (int) $row['user_id'];
		$author = $this->username($author_id, $row['author_username'], $row['author_colour']);
		$recipient = $this->username($recipient_id, $row['recipient_username'], $row['recipient_colour']);
		$folder_id = (int) $row['folder_id'];
		$folder_names = $this->folder_names();
		$selection = (int) $row['msg_id'] . ':' . $recipient_id . ':' . $folder_id;

		$this->template->assign_block_vars('pm_row', array(
			'AUTHOR_IP' => $row['author_ip'],
			'BCC' => !empty($row['bcc_address']) && $author_id !== $recipient_id ? $recipient : '',
			'DATE' => $this->user->format_date((int) $row['message_time']),
			'FOLDER' => $folder_id > PRIVMSGS_INBOX
				? $this->language->lang('PM_SAVED')
				: (isset($folder_names[$folder_id]) ? $folder_names[$folder_id] : $this->language->lang('PM_UNKNOWN_BOX')),
			'FROM' => $author_id === $recipient_id ? '' : $author,
			'IS_GROUP' => preg_match('/(?:^|:)g_[0-9]+(?::|$)/', (string) $row['to_address']) ? $this->language->lang('IS_GROUP') : '',
			'LAST_VISIT_FROM' => $author_id === $recipient_id ? '' : $this->last_visit($author_id, (int) $row['author_lastvisit'], $sessions),
			'LAST_VISIT_TO' => $author_id === $recipient_id ? '' : $this->last_visit($recipient_id, (int) $row['recipient_lastvisit'], $sessions),
			'PM_SELECTION' => $selection,
			'PM_SUBJECT' => censor_text($row['message_subject']),
			'TO' => $author_id === $recipient_id ? '' : $recipient,
			'U_PM_VIEW' => $this->u_action . '&amp;view=' . rawurlencode($selection) . '&amp;start=' . (int) $start . '&amp;sk=' . $sort_key . '&amp;sd=' . $sort_direction,
		));
	}

	protected function assign_selected_message($start, $sort_key, $sort_direction)
	{
		$value = $this->request->variable('view', '');
		if ($value === '')
		{
			return;
		}
		$parsed = selection_parser::parse(array($value));
		if ($parsed === false)
		{
			trigger_error($this->language->lang('INVALID_PM_SELECTION') . adm_back_link($this->u_action), E_USER_WARNING);
		}
		$message = $this->messages->fetch_message($parsed[0]);
		if ($message === null)
		{
			trigger_error($this->language->lang('INVALID_PM_SELECTION') . adm_back_link($this->u_action), E_USER_WARNING);
		}
		$this->template->assign_vars(array(
			'PM_DETAIL_SUBJECT' => censor_text($message['message_subject']),
			'PM_DETAIL_TEXT' => generate_text_for_display($message['message_text'], $message['bbcode_uid'], $message['bbcode_bitfield'], $this->display_flags(), true),
			'S_SHOW_MESSAGE' => true,
			'U_CLOSE_MESSAGE' => $this->u_action . '&amp;start=' . (int) $start . '&amp;sk=' . $sort_key . '&amp;sd=' . $sort_direction,
		));
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PM_MONITOR_MESSAGE_VIEW', false, array(
			$parsed[0]['msg_id'],
			$parsed[0]['user_id'],
		));
	}

	protected function display_flags()
	{
		return (!empty($this->config['auth_bbcode_pm']) ? OPTION_FLAG_BBCODE : 0)
			+ (!empty($this->config['auth_smilies_pm']) ? OPTION_FLAG_SMILIES : 0)
			+ (!empty($this->config['allow_post_links']) ? OPTION_FLAG_LINKS : 0);
	}

	protected function session_times(array $rows)
	{
		$user_ids = array();
		foreach ($rows as $row)
		{
			$user_ids[] = (int) $row['author_id'];
			$user_ids[] = (int) $row['user_id'];
		}
		return $this->messages->active_sessions($user_ids, time() - (int) $this->config['session_length']);
	}

	protected function username($user_id, $username, $colour)
	{
		if ($user_id <= 0 || $username === null || $username === '')
		{
			return $this->language->lang('GUEST');
		}
		return get_username_string('full', $user_id, $username, $colour);
	}

	protected function last_visit($user_id, $stored_time, array $sessions)
	{
		$time = isset($sessions[$user_id]) ? max($stored_time, $sessions[$user_id]) : $stored_time;
		return $time > 0 ? $this->user->format_date($time) : $this->language->lang('NEVER');
	}

	protected function folder_names()
	{
		return array(
			PRIVMSGS_HOLD_BOX => $this->language->lang('PM_HOLDBOX'),
			PRIVMSGS_NO_BOX => $this->language->lang('PM_NOBOX'),
			PRIVMSGS_OUTBOX => $this->language->lang('PM_OUTBOX'),
			PRIVMSGS_SENTBOX => $this->language->lang('PM_SENTBOX'),
			PRIVMSGS_INBOX => $this->language->lang('PM_INBOX'),
		);
	}

	protected function assign_sorting($sort_key, $sort_direction)
	{
		$sort_by_text = array(
			'f' => $this->language->lang('SORT_FROM'),
			't' => $this->language->lang('SORT_TO'),
			'b' => $this->language->lang('SORT_BCC'),
			'p' => $this->language->lang('SORT_PM_BOX'),
			'i' => $this->language->lang('SORT_IP'),
			'd' => $this->language->lang('SORT_DATE'),
		);
		$limit_days = array();
		$sort_days = 0;
		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_direction, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
		$this->template->assign_vars(array(
			'S_SORT_KEY' => $s_sort_key,
			'S_SORT_DIR' => $s_sort_dir,
		));
	}

	protected function assert_permission($permission)
	{
		if (!$this->auth->acl_get($permission))
		{
			send_status_line(403, 'Forbidden');
			trigger_error('NOT_AUTHORISED', E_USER_WARNING);
		}
	}

	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
