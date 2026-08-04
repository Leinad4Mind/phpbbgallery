<?php
/**
 *
 * Topic Index Bridge. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kasimi\topicindexbridge\event;

use kasimi\topicindexbridge\core\bridge_manager;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use phpbb\user_loader;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	protected $manager;
	protected $config;
	protected $template;
	protected $request;
	protected $language;
	protected $user_loader;
	protected $helper;
	protected $user;
	protected $db;
	protected $forum_lists_table;
	protected $known_lists = [];

	public function __construct(
		bridge_manager $manager,
		config $config,
		template $template,
		request_interface $request,
		language $language,
		user_loader $user_loader,
		helper $helper,
		user $user,
		db_interface $db,
		$forum_lists_table
	)
	{
		$this->manager = $manager;
		$this->config = $config;
		$this->template = $template;
		$this->request = $request;
		$this->language = $language;
		$this->user_loader = $user_loader;
		$this->helper = $helper;
		$this->user = $user;
		$this->db = $db;
		$this->forum_lists_table = $forum_lists_table;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup' => 'load_language',
			'core.page_header' => 'page_header',
			'core.memberlist_view_profile' => 'member_profile',
			'dmzx.topicindex.sql_fetch_topics_before' => 'sql_before',
			'dmzx.topicindex.enrich_topiclist' => 'enrich_topics',
			'dmzx.topicindex.modify_block_topic_index_ary' => 'template_vars',
			'dmzx.topicindex.request_context' => 'request_context',
			'dmzx.topicindex.acp_display' => 'acp_display',
			'dmzx.topicindex.acp_save' => 'acp_save',
			'dmzx.topicindex.list_deleted' => 'list_deleted',
		];
	}

	public function load_language(data $event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = ['ext_name' => 'kasimi/topicindexbridge', 'lang_set' => 'common'];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function sql_before(data $event)
	{
		$event['sql_array'] = $this->manager->add_qte_fields($event['sql_array']);
	}

	public function enrich_topics(data $event)
	{
		$event['topiclist'] = $this->manager->enrich($event['topiclist']);
	}

	public function template_vars(data $event)
	{
		$event['template_vars'] = $this->manager->template_vars($event['indexdata'], $event['template_vars']);
	}

	public function request_context(data $event)
	{
		if (!$this->manager->is_effective('usertopics'))
		{
			return;
		}
		$user_id = max(0, $this->request->variable('user', 0));
		if (!$user_id)
		{
			return;
		}
		if (!$this->user_exists($user_id))
		{
			$context = $event['query_context'];
			$context['not_found'] = true;
			$event['query_context'] = $context;

			return;
		}

		$this->user_loader->load_users([$user_id]);
		$context = $event['query_context'];
		$context['poster_id'] = $user_id;
		$context['route_parameters']['user'] = $user_id;
		$context['template_variables'] += [
			'TOPICINDEX_RETURN_USER' => $user_id,
			'TOPIC_INDEX_USER_TOPICS_FILTERING_NAME' => $this->user_loader->get_username($user_id, 'full'),
			'U_TOPIC_INDEX_USER_TOPICS_NO_FILTER' => $this->helper->route('dmzx_topicindex_controller', $event['list_id'] ? ['list' => (int) $event['list_id']] : []),
		];
		$event['query_context'] = $context;
	}

	public function page_header()
	{
		if (!$this->manager->is_effective('usertopics') || (int) $this->user->data['user_id'] === ANONYMOUS)
		{
			return;
		}
		$list_id = (int) $this->config['topicindex_bridge_self_list'];
		if ($list_id && $this->list_exists($list_id))
		{
			$this->template->assign_var('U_TOPIC_INDEX_USER_TOPICS_SELF', $this->helper->route('dmzx_topicindex_controller', [
				'list' => $list_id,
				'user' => (int) $this->user->data['user_id'],
			]));
		}
	}

	public function member_profile(data $event)
	{
		if (!$this->manager->is_effective('usertopics'))
		{
			return;
		}
		$list_id = (int) $this->config['topicindex_bridge_profile_list'];
		if ($list_id && $this->list_exists($list_id) && !empty($event['member']['user_id']))
		{
			$this->template->assign_var('U_TOPIC_INDEX_USER_TOPICS', $this->helper->route('dmzx_topicindex_controller', [
				'list' => $list_id,
				'user' => (int) $event['member']['user_id'],
			]));
		}
	}

	public function acp_display()
	{
		$this->language->add_lang('acp', 'kasimi/topicindexbridge');
		foreach ($this->manager->get_modules() as $module)
		{
			$this->template->assign_block_vars('topicindex_bridge_modules', [
				'KEY' => $module['name'],
				'CONFIG_NAME' => $module['config'],
				'LABEL' => $this->language->lang('TOPICINDEX_BRIDGE_' . strtoupper($module['name'])),
				'S_CHECKED' => $module['enabled'],
				'S_AVAILABLE' => $module['available'],
				'S_LEGACY' => $module['legacy'],
				'S_EFFECTIVE' => $module['effective'],
			]);
		}
		$this->template->assign_vars([
			'S_TOPICINDEX_BRIDGE' => true,
			'TOPICINDEX_BRIDGE_PROFILE_LIST' => (int) $this->config['topicindex_bridge_profile_list'],
			'TOPICINDEX_BRIDGE_SELF_LIST' => (int) $this->config['topicindex_bridge_self_list'],
		]);
	}

	public function acp_save(data $event)
	{
		foreach ($this->manager->get_modules() as $module)
		{
			$this->config->set($module['config'], $this->request->variable($module['config'], 0) ? 1 : 0);
		}
		$valid_lists = array_map('intval', $event['valid_lists']);
		foreach (['profile', 'self'] as $type)
		{
			$list_id = max(0, $this->request->variable('topicindex_bridge_' . $type . '_list', 0));
			$this->config->set('topicindex_bridge_' . $type . '_list', in_array($list_id, $valid_lists, true) ? $list_id : 0);
		}
	}

	public function list_deleted(data $event)
	{
		$list_id = (int) $event['list_id'];
		$this->known_lists[$list_id] = false;
		foreach (['profile', 'self'] as $type)
		{
			$key = 'topicindex_bridge_' . $type . '_list';
			if ((int) $this->config[$key] === $list_id)
			{
				$this->config->set($key, 0);
			}
		}
	}

	protected function user_exists($user_id)
	{
		$sql = 'SELECT user_id
			FROM ' . USERS_TABLE . '
			WHERE user_id = ' . (int) $user_id . '
				AND user_type <> ' . USER_IGNORE;
		$result = $this->db->sql_query_limit($sql, 1);
		$exists = (bool) $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $exists;
	}

	protected function list_exists($list_id)
	{
		$list_id = (int) $list_id;
		if (!array_key_exists($list_id, $this->known_lists))
		{
			$sql = 'SELECT list_id
				FROM ' . $this->forum_lists_table . '
				WHERE list_id = ' . $list_id;
			$result = $this->db->sql_query_limit($sql, 1);
			$this->known_lists[$list_id] = (bool) $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
		}

		return $this->known_lists[$list_id];
	}
}
