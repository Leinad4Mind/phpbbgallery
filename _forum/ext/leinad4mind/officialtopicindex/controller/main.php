<?php
/**
 *
 * @package phpBB Extension - Official Topic Index
 * @copyright (c) 2015-2022 Leinad4Mind - https://leinad4mind.top/forum
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\officialtopicindex\controller;

use leinad4mind\officialtopicindex\core\functions_officialtopicindex;
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\exception\http_exception;
use phpbb\event\dispatcher_interface;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class main
{
	/** @var functions_officialtopicindex */
	protected $functions_officialtopicindex;
	/** @var template */
	protected $template;
	/** @var user */
	protected $user;
	/** @var auth */
	protected $auth;
	/** @var db_interface */
	protected $db;
	/** @var request_interface */
	protected $request;
	/** @var helper */
	protected $helper;
	/** @var language */
	protected $language;
	/** @var config */
	protected $config;
	/** @var dispatcher_interface */
	protected $dispatcher;
	/** @var string */
	protected $root_path;
	/** @var string */
	protected $php_ext;
	/** @var string */
	protected $forum_lists_table;

	public function __construct(
		functions_officialtopicindex $functions_officialtopicindex,
		template $template,
		user $user,
		auth $auth,
		db_interface $db,
		request_interface $request,
		helper $helper,
		language $language,
		config $config,
		dispatcher_interface $dispatcher,
		$root_path,
		$php_ext,
		$forum_lists_table
	)
	{
		$this->functions_officialtopicindex = $functions_officialtopicindex;
		$this->template = $template;
		$this->user = $user;
		$this->auth = $auth;
		$this->db = $db;
		$this->request = $request;
		$this->helper = $helper;
		$this->language = $language;
		$this->config = $config;
		$this->dispatcher = $dispatcher;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->forum_lists_table = $forum_lists_table;
	}

	/**
	 * Display an external topic index.
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function handle_topicindex()
	{
		if (!$this->auth->acl_get('u_officialtopicindex_view'))
		{
			throw new http_exception(403, 'NOT_AUTHORISED');
		}

		$list_id = max(0, $this->request->variable('list', 0));
		$filter = $this->normalise_filter($this->request->variable('ilimit', ''));
		$query_context = [
			'poster_id' => 0,
			'route_parameters' => [],
			'template_variables' => [],
			'not_found' => false,
		];
		$vars = ['list_id', 'query_context'];
		extract($this->dispatcher->trigger_event('leinad4mind.officialtopicindex.request_context', compact($vars)));
		if (!empty($query_context['not_found']))
		{
			throw new http_exception(404, 'NO_USER');
		}
		$user_id = max(0, (int) $query_context['poster_id']);
		$route_parameters = is_array($query_context['route_parameters']) ? $query_context['route_parameters'] : [];

		$lists = $this->get_lists();
		$current_list = isset($lists[$list_id]) ? $lists[$list_id] : null;
		if ($list_id && $current_list === null)
		{
			throw new http_exception(404, 'TOPICINDEX_LIST_NOT_FOUND');
		}

		foreach ($lists as $list)
		{
			$args = array_merge($route_parameters, ['list' => $list['list_id']]);
			$this->template->assign_block_vars('topicindex_lists', [
				'ID' => $list['list_id'],
				'NAME' => $list['list_name'],
				'S_SELECTED' => $list_id === $list['list_id'],
				'U_VIEW' => $this->helper->route('leinad4mind_officialtopicindex_controller', $args),
			]);
		}

		$selected_name = '';
		$topics = [];
		if ($current_list !== null)
		{
			$selected_name = $current_list['list_name'];
			$forum_ids = json_decode($current_list['list_forum'], true);
			$forum_ids = is_array($forum_ids) ? array_values(array_unique(array_filter(array_map('intval', $forum_ids)))) : [];
			$settings = $this->functions_officialtopicindex->get_forum_settings($forum_ids);
			$topics = $this->functions_officialtopicindex->get_topic_indexes($settings, 0, $user_id);
		}

		$filter_args = array_merge($route_parameters, ['list' => $list_id]);
		$this->assign_index_blocks($topics, $filter, $filter_args);

		add_form_key('topicindex_manage', '_TOPICINDEX');
		$title = implode(' - ', array_filter([$this->language->lang('OIINDEX_HEADER'), $selected_name]));
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME' => $title,
			'U_VIEW_FORUM' => $this->helper->route('leinad4mind_officialtopicindex_controller', $list_id ? ['list' => $list_id] : []),
		]);
		$this->functions_officialtopicindex->assign_authors();
		$this->template->assign_vars([
			'S_SHOWLIST' => $current_list !== null,
			'S_TOPICINDEX_ASSETS' => true,
			'S_CAN_MANAGE_TOPIC_INDEX' => count(array_filter($topics, function ($topic)
			{
				return $topic['can_manage'];
			})) > 0,
			'U_ACTION' => $this->helper->route('leinad4mind_officialtopicindex_controller'),
			'U_TOPICINDEX_MANAGE' => $this->helper->route('leinad4mind_officialtopicindex_manage'),
			'U_TOPICINDEX_ALL' => $this->helper->route('leinad4mind_officialtopicindex_controller', $filter_args),
			'U_TOPICINDEX_NEW_TOPIC' => $this->get_new_topic_url(),
			'TOPICINDEX_RETURN_LIST' => $list_id,
			'L_OIINDEX_HEADER' => $title,
		] + (is_array($query_context['template_variables']) ? $query_context['template_variables'] : []));

		return $this->helper->render('topiclist.html', $title);
	}

	/**
	 * Process an add/remove request.
	 *
	 * @return void
	 */
	public function handle_manage()
	{
		if (!$this->request->is_set_post('topicindex_action'))
		{
			throw new http_exception(405, 'FORM_INVALID');
		}
		if (!check_form_key('topicindex_manage'))
		{
			throw new http_exception(403, 'FORM_INVALID');
		}

		$action = $this->request->variable('topicindex_action', '');
		$topic_id = max(0, $this->request->variable('topic_id', 0));
		if (!in_array($action, ['add', 'remove'], true) || !$topic_id)
		{
			throw new http_exception(400, 'FORM_INVALID');
		}

		$sql = 'SELECT topic_id, forum_id
			FROM ' . TOPICS_TABLE . '
			WHERE topic_id = ' . $topic_id;
		$result = $this->db->sql_query_limit($sql, 1);
		$topic = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if (!$topic || !$this->functions_officialtopicindex->set_topic_in_list($topic['forum_id'], $topic_id, $action === 'add'))
		{
			throw new http_exception(403, 'NOT_AUTHORISED');
		}

		$return_list = max(0, $this->request->variable('return_list', 0));
		$return_user = max(0, $this->request->variable('return_user', 0));
		if ($return_list)
		{
			$args = ['list' => $return_list];
			if ($return_user)
			{
				$args['user'] = $return_user;
			}
			redirect($this->helper->route('leinad4mind_officialtopicindex_controller', $args));
		}

		$return_topic = max(0, $this->request->variable('return_topic', $topic_id));
		redirect(append_sid($this->root_path . 'viewtopic.' . $this->php_ext, [
			'f' => (int) $topic['forum_id'],
			't' => $return_topic,
		]));
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
			$forum_ids = json_decode($row['list_forum'], true);
			$forum_ids = is_array($forum_ids) ? array_map('intval', $forum_ids) : [];
			if (!empty($this->functions_officialtopicindex->get_readable_forum_ids($forum_ids)))
			{
				$lists[$row['list_id']] = $row;
			}
		}
		$this->db->sql_freeresult($result);

		return $lists;
	}

	protected function normalise_filter($filter)
	{
		$filter = mb_strtolower(trim((string) $filter));

		return preg_match('#^(?:[a-z]|09|_)$#', $filter) ? $filter : '';
	}

	protected function assign_index_blocks(array $topics, $filter, array $base_args)
	{
		$keys = $this->functions_officialtopicindex->create_key_list($topics);
		$filtered_topics = $this->functions_officialtopicindex->filter_topiclist($topics, $filter);
		foreach (range('a', 'z') as $letter)
		{
			$args = array_merge($base_args, ['ilimit' => $letter]);
			$this->template->assign_block_vars('block_filtrino', [
				'U_FILTER' => $this->helper->route('leinad4mind_officialtopicindex_controller', $args),
				'FILTRINO' => $letter,
				'S_ISWITH' => in_array($letter, $keys, true),
			]);
		}

		foreach ($keys as $key)
		{
			$this->template->assign_block_vars('block_list', [
				'FILTRINO' => $key === '_' ? $this->language->lang('SYMB') : mb_strtoupper($key),
				'S_ISWITH2' => $filter === '' || $filter === $key,
			]);
			$row_number = 0;
			foreach ($filtered_topics as $topic)
			{
				if ($topic['key'] !== $key)
				{
					continue;
				}

				$template_vars = [
					'ITOPIC_ID' => $topic['id'],
					'ITOPIC_URL' => append_sid($this->root_path . 'viewtopic.' . $this->php_ext, ['f' => $topic['forum_id'], 't' => $topic['id']]),
					'ITOPIC_TITLE' => $topic['title'],
					'ITOPIC_POSTER' => get_username_string('full', $topic['posterid'], $topic['poster'], $topic['postercol']),
					'ITOPIC_TOTREP' => $topic['posts'],
					'ITOPIC_CLASS' => $row_number % 2 ? 'row bg1' : 'row bg2',
					'U_FORUM' => append_sid($this->root_path . 'viewforum.' . $this->php_ext, ['f' => $topic['forum_id']]),
					'S_CAN_MANAGE' => $topic['can_manage'],
					'MANAGE_ACTION' => 'remove',
				];
				$template_vars = $this->functions_officialtopicindex->enrich_template_vars($topic, $template_vars);
				$this->template->assign_block_vars('block_list.block_topic_index', $template_vars);
				$row_number++;
			}
		}

		$this->template->assign_block_vars('block_nofiltrino', [
			'U_TUTTI' => $this->helper->route('leinad4mind_officialtopicindex_controller', $base_args),
			'U_09' => $this->helper->route('leinad4mind_officialtopicindex_controller', array_merge($base_args, ['ilimit' => '09'])),
			'U_SYMB' => $this->helper->route('leinad4mind_officialtopicindex_controller', array_merge($base_args, ['ilimit' => '_'])),
			'S_09' => in_array('09', $keys, true),
			'S_SYMB' => in_array('_', $keys, true),
		]);
	}

	protected function get_new_topic_url()
	{
		$forum_id = (int) $this->config['officialtopicindex_new_topic_forum'];
		if (!$forum_id || !$this->auth->acl_get('f_post', $forum_id))
		{
			return '';
		}

		return append_sid($this->root_path . 'posting.' . $this->php_ext, ['mode' => 'post', 'f' => $forum_id]);
	}

}
