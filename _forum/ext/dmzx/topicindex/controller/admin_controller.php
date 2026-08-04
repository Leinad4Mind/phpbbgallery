<?php
/**
 *
 * @package phpBB Extension - Topic Index
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\topicindex\controller;

use phpbb\config\config;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\event\dispatcher_interface;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class admin_controller
{
	/** @var config */
	protected $config;
	/** @var template */
	protected $template;
	/** @var log_interface */
	protected $log;
	/** @var language */
	protected $language;
	/** @var user */
	protected $user;
	/** @var db_interface */
	protected $db;
	/** @var request_interface */
	protected $request;
	/** @var dispatcher_interface */
	protected $dispatcher;
	/** @var string */
	protected $forum_lists_table;
	/** @var string */
	protected $u_action;

	public function __construct(
		config $config,
		template $template,
		log_interface $log,
		language $language,
		user $user,
		db_interface $db,
		request_interface $request,
		dispatcher_interface $dispatcher,
		$forum_lists_table
	)
	{
		$this->config = $config;
		$this->template = $template;
		$this->log = $log;
		$this->language = $language;
		$this->user = $user;
		$this->db = $db;
		$this->request = $request;
		$this->dispatcher = $dispatcher;
		$this->forum_lists_table = $forum_lists_table;
	}

	public function display_options()
	{
		$this->language->add_lang('acp_topicindex', 'dmzx/topicindex');
		add_form_key('acp_topicindex');

		$forum_rows = make_forum_select(false, false, true, false, false, false, true);
		$valid_forums = [];
		foreach ($forum_rows as $forum_id => $forum)
		{
			$forum_id = (int) $forum_id;
			$is_postable = empty($forum['disabled']) && (int) $forum['forum_type'] === FORUM_POST;
			if ($is_postable)
			{
				$valid_forums[$forum_id] = $forum['forum_name'];
			}
			$this->template->assign_block_vars('forum_options', [
				'ID' => $forum_id,
				'NAME' => $forum['padding'] . $forum['forum_name'],
				'S_DISABLED' => !$is_postable,
			]);
		}

		$lists = $this->get_lists();
		if ($this->request->is_set_post('delete_list'))
		{
			$this->check_form_key();
			$this->delete_list(max(0, $this->request->variable('list_id', 0)));
		}
		else if ($this->request->is_set_post('submit_list'))
		{
			$this->check_form_key();
			$this->add_list($valid_forums);
		}
		else if ($this->request->is_set_post('save_settings'))
		{
			$this->check_form_key();
			$this->save_settings($valid_forums, array_keys($lists));
		}

		$lists = $this->get_lists();
		foreach ($lists as $list)
		{
			$forum_ids = json_decode($list['list_forum'], true);
			$forum_ids = is_array($forum_ids) ? array_map('intval', $forum_ids) : [];
			$forum_names = [];
			foreach ($forum_ids as $forum_id)
			{
				$forum_names[] = isset($valid_forums[$forum_id]) ? $valid_forums[$forum_id] : $this->language->lang('TOPICINDEX_UNKNOWN_FORUM', $forum_id);
			}
			$this->template->assign_block_vars('list', [
				'ID' => $list['list_id'],
				'LIST_NAME' => $list['list_name'],
				'LIST_FORUMS' => implode(', ', $forum_names),
			]);
			$this->template->assign_block_vars('topicindex_available_lists', [
				'ID' => $list['list_id'],
				'NAME' => $list['list_name'],
			]);
		}

		$vars = ['lists', 'valid_forums'];
		$this->dispatcher->trigger_event('dmzx.topicindex.acp_display', compact($vars));

		$this->template->assign_vars([
			'U_ACTION' => $this->u_action,
			'S_OVERFLOW' => !empty($this->config['oindex_overflow']),
			'TOPICINDEX_MAX_TOPICS' => (int) $this->config['topicindex_max_topics'],
			'TOPICINDEX_NEW_TOPIC_FORUM' => (int) $this->config['topicindex_new_topic_forum'],
			'S_LIST' => !empty($lists),
		]);
	}

	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}

	protected function add_list(array $valid_forums)
	{
		$errors = [];
		$list_name = trim($this->request->variable('list_name', '', true));
		$forum_ids = array_values(array_unique(array_filter(array_map('intval', $this->request->variable('forum_id', [0])))));
		$forum_ids = array_values(array_intersect($forum_ids, array_keys($valid_forums)));
		if ($list_name === '')
		{
			$errors[] = $this->language->lang('NAME_FORUM_LIST_EMPTY');
		}
		if (mb_strlen($list_name) > 255)
		{
			$errors[] = $this->language->lang('TOPICINDEX_LIST_NAME_TOO_LONG');
		}
		if (empty($forum_ids))
		{
			$errors[] = $this->language->lang('SELECT_FORUM_LIST_EMPTY');
		}
		if ($this->list_name_exists($list_name))
		{
			$errors[] = $this->language->lang('TOPICINDEX_LIST_NAME_EXISTS');
		}
		if (!empty($errors))
		{
			$this->template->assign_var('ERROR', implode('<br />', $errors));

			return;
		}

		$sql_ary = [
			'list_name' => $list_name,
			'list_forum' => json_encode($forum_ids),
		];
		$sql = 'INSERT INTO ' . $this->forum_lists_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
		$this->db->sql_query($sql);
		$this->log_admin('LOG_OINDEX_ADDLIST', [$list_name]);
		trigger_error($this->language->lang('OINDEX_ADDED_LIST') . adm_back_link($this->u_action));
	}

	protected function delete_list($list_id)
	{
		if (!$list_id)
		{
			trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
		}
		if (!confirm_box(true))
		{
			confirm_box(false, $this->language->lang('TOPICINDEX_DELETE_LIST_CONFIRM'), build_hidden_fields([
				'delete_list' => 1,
				'list_id' => $list_id,
				'creation_time' => $this->request->variable('creation_time', 0),
				'form_token' => $this->request->variable('form_token', ''),
			]));

			return;
		}

		$sql = 'DELETE FROM ' . $this->forum_lists_table . '
			WHERE list_id = ' . $list_id;
		$this->db->sql_query($sql);
		$vars = ['list_id'];
		$this->dispatcher->trigger_event('dmzx.topicindex.list_deleted', compact($vars));
		$this->log_admin('LOG_OINDEX_DELETELIST', [$list_id]);
		trigger_error($this->language->lang('OINDEX_DELETED_LIST') . adm_back_link($this->u_action));
	}

	protected function save_settings(array $valid_forums, array $valid_lists)
	{
		$max_topics = max(1, min(5000, $this->request->variable('max_topics', 1000)));
		$new_topic_forum = max(0, $this->request->variable('new_topic_forum', 0));
		$new_topic_forum = isset($valid_forums[$new_topic_forum]) ? $new_topic_forum : 0;

		$this->config->set('oindex_overflow', $this->request->variable('overflow', 0) ? 1 : 0);
		$this->config->set('topicindex_max_topics', $max_topics);
		$this->config->set('topicindex_new_topic_forum', $new_topic_forum);
		$vars = ['valid_forums', 'valid_lists'];
		$this->dispatcher->trigger_event('dmzx.topicindex.acp_save', compact($vars));

		$this->log_admin('LOG_OINDEX_EDITCFG');
		trigger_error($this->language->lang('OINDEX_EDIT_CFG') . adm_back_link($this->u_action));
	}

	protected function get_lists()
	{
		$sql = 'SELECT list_id, list_name, list_forum
			FROM ' . $this->forum_lists_table . '
			ORDER BY list_name ASC';
		$result = $this->db->sql_query($sql);
		$lists = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$row['list_id'] = (int) $row['list_id'];
			$lists[$row['list_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		return $lists;
	}

	protected function list_name_exists($list_name)
	{
		$sql = 'SELECT list_id
			FROM ' . $this->forum_lists_table . "
			WHERE list_name = '" . $this->db->sql_escape($list_name) . "'";
		$result = $this->db->sql_query_limit($sql, 1);
		$exists = (bool) $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $exists;
	}

	protected function check_form_key()
	{
		if (!check_form_key('acp_topicindex'))
		{
			trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
		}
	}

	protected function log_admin($operation, array $data = [])
	{
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, $operation, false, $data);
	}
}
