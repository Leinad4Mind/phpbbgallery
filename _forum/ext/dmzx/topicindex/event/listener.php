<?php
/**
 *
 * @package phpBB Extension - Topic Index
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\topicindex\event;

use dmzx\topicindex\core\functions_topicindex;
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var functions_topicindex */
	protected $functions_topicindex;
	/** @var user */
	protected $user;
	/** @var auth */
	protected $auth;
	/** @var template */
	protected $template;
	/** @var db_interface */
	protected $db;
	/** @var config */
	protected $config;
	/** @var helper */
	protected $helper;
	/** @var request_interface */
	protected $request;
	/** @var language */
	protected $language;
	/** @var string */
	protected $root_path;
	/** @var string */
	protected $php_ext;

	public function __construct(
		functions_topicindex $functions_topicindex,
		user $user,
		auth $auth,
		template $template,
		db_interface $db,
		config $config,
		helper $helper,
		request_interface $request,
		language $language,
		$root_path,
		$php_ext
	)
	{
		$this->functions_topicindex = $functions_topicindex;
		$this->user = $user;
		$this->auth = $auth;
		$this->template = $template;
		$this->db = $db;
		$this->config = $config;
		$this->helper = $helper;
		$this->request = $request;
		$this->language = $language;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.viewonline_overwrite_location' => 'add_page_viewonline',
			'core.permissions' => 'permissions',
			'core.user_setup' => 'load_language_on_setup',
			'core.page_header' => 'page_header',
			'core.acp_manage_forums_request_data' => 'acp_manage_forums_request_data',
			'core.acp_manage_forums_initialise_data' => 'acp_manage_forums_initialise_data',
			'core.acp_manage_forums_display_form' => 'acp_manage_forums_display_form',
			'core.viewtopic_modify_post_row' => 'viewtopic_modify_post_row',
		];
	}

	public function add_page_viewonline($event)
	{
		if (strpos($event['row']['session_page'], 'app.' . $this->php_ext . '/topicindex') === 0)
		{
			$event['location'] = $this->language->lang('OIINDEX_HEADER');
			$event['location_url'] = $this->helper->route('dmzx_topicindex_controller');
		}
	}

	public function permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_topicindex_view'] = ['lang' => 'ACL_U_TOPICINDEX', 'cat' => 'misc'];
		$event['permissions'] = $permissions;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'dmzx/topicindex',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function page_header()
	{
		$this->template->assign_vars([
			'U_OTINDEX' => $this->helper->route('dmzx_topicindex_controller'),
			'TOPICINDEXLIST_VIEW' => $this->auth->acl_get('u_topicindex_view'),
		]);
	}

	public function acp_manage_forums_request_data($event)
	{
		$forum_data = $event['forum_data'];
		$post_index = max(0, $this->request->variable('post_index', 0));
		$forum_id = isset($forum_data['forum_id']) ? (int) $forum_data['forum_id'] : 0;
		if (!$this->is_valid_official_topic($forum_id, $post_index))
		{
			$post_index = 0;
		}
		$forum_data = array_merge($forum_data, [
			'post_index' => $post_index,
			'default_inindex' => $this->request->variable('default_inindex', 0) ? 1 : 0,
			'tag_filter' => $this->request->variable('index_filter', 0) ? 1 : 0,
			'topicindex_display_mode' => $this->functions_topicindex->normalise_display_mode($this->request->variable('topicindex_display_mode', 'after')),
		]);
		$event['forum_data'] = $forum_data;
	}

	public function acp_manage_forums_initialise_data($event)
	{
		$this->language->add_lang('acp_topicindex', 'dmzx/topicindex');
		$forum_data = $event['forum_data'];
		if ($event['action'] === 'add')
		{
			$forum_data['post_index'] = 0;
			$forum_data['default_inindex'] = 0;
			$forum_data['tag_filter'] = 0;
			$forum_data['topicindex_display_mode'] = 'after';
		}
		$event['forum_data'] = $forum_data;
	}

	public function acp_manage_forums_display_form($event)
	{
		$template_data = $event['template_data'];
		$forum_data = $event['forum_data'];
		$forum_id = (int) $event['forum_id'];
		if ($forum_id)
		{
			$sql = 'SELECT topic_id, topic_title
				FROM ' . TOPICS_TABLE . '
				WHERE forum_id = ' . $forum_id . '
					AND topic_posts_approved >= 1
					AND topic_visibility = ' . ITEM_APPROVED . '
					AND ' . $this->db->sql_in_set('topic_type', [POST_STICKY, POST_ANNOUNCE]) . '
				ORDER BY topic_title ASC';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$this->template->assign_block_vars('block_topic_index', [
					'ITOPIC_ID' => (int) $row['topic_id'],
					'S_SELECTED' => (int) $row['topic_id'] === (int) $forum_data['post_index'],
					'ITOPIC_NAME' => censor_text($row['topic_title']),
				]);
			}
			$this->db->sql_freeresult($result);
		}

		$display_mode = $this->functions_topicindex->normalise_display_mode(isset($forum_data['topicindex_display_mode']) ? $forum_data['topicindex_display_mode'] : 'after');
		$template_data = array_merge($template_data, [
			'S_TOPICINDEX_INACTIVE' => empty($forum_data['post_index']),
			'S_TOPICINDEX_MANUAL' => !empty($forum_data['default_inindex']),
			'S_TOPICINDEX_TAG_FILTER' => !empty($forum_data['tag_filter']),
			'TOPICINDEX_DISPLAY_MODE' => $display_mode,
			'S_SHOW_OINDEX' => in_array($event['action'], ['add', 'edit'], true),
		]);
		$event['template_data'] = $template_data;
	}

	public function viewtopic_modify_post_row($event)
	{
		$row = $event['row'];
		$post_row = $event['post_row'];
		$topic_data = $event['topic_data'];
		$topic_id = (int) $row['topic_id'];
		$forum_id = (int) $row['forum_id'];
		$is_first_post = (int) $row['post_id'] === (int) $topic_data['topic_first_post_id'];
		$official_topic_id = isset($topic_data['post_index']) ? (int) $topic_data['post_index'] : 0;
		$can_manage = $this->functions_topicindex->can_manage($forum_id);
		$action = '';

		if ($official_topic_id && $is_first_post && $official_topic_id !== $topic_id && $can_manage)
		{
			$included = $this->functions_topicindex->checkif_inlist(
				$topic_data['default_inindex'],
				$topic_data['inindex_topic'],
				$topic_data['outindex_topic']
			);
			$action = $included ? 'remove' : 'add';
			add_form_key('topicindex_manage', '_TOPICINDEX');
		}

		$active_index = false;
		$message = $post_row['MESSAGE'];
		if ($official_topic_id === $topic_id && $is_first_post)
		{
			$filter = $this->normalise_filter($this->request->variable('ilimit', ''));
			$topics = $this->functions_topicindex->get_topic_index(
				$forum_id,
				$topic_id,
				$topic_data['default_inindex'],
				$topic_data['tag_filter']
			);
			$this->assign_index_blocks($topics, $filter, $forum_id, $topic_id);
			add_form_key('topicindex_manage', '_TOPICINDEX');
			$this->functions_topicindex->assign_authors();
			$this->template->assign_vars([
				'S_ISTYLE' => !empty($this->config['oindex_overflow']) ? 'content_index_flow' : 'content_index',
				'S_TOPICINDEX_ASSETS' => true,
				'S_CAN_MANAGE_TOPIC_INDEX' => $can_manage,
				'U_TOPICINDEX_MANAGE' => $this->helper->route('dmzx_topicindex_manage'),
				'U_TOPICINDEX_NEW_TOPIC' => $this->get_new_topic_url(),
				'TOPICINDEX_RETURN_TOPIC' => $topic_id,
			]);
			$index_html = $this->template
				->set_filenames(['topic_index' => '@dmzx_topicindex/official_topic_index.html'])
				->assign_display('topic_index');

			$display_mode = $this->functions_topicindex->normalise_display_mode(
				isset($topic_data['topicindex_display_mode']) ? $topic_data['topicindex_display_mode'] : 'after'
			);
			if ($display_mode === 'replace')
			{
				$message = $index_html;
			}
			else if ($display_mode === 'before')
			{
				$message = $index_html . $message;
			}
			else
			{
				$message .= $index_html;
			}
			$active_index = true;
		}

		$post_row = array_merge($post_row, [
			'S_ACTIVEINDEX' => $active_index,
			'S_CAN_MANAGE_TOPIC_INDEX' => $can_manage,
			'TOPICINDEX_ACTION' => $action,
			'TOPICINDEX_TOPIC_ID' => $topic_id,
			'TOPICINDEX_RETURN_TOPIC' => $topic_id,
			'U_TOPICINDEX_MANAGE' => $this->helper->route('dmzx_topicindex_manage'),
			'IINDEX_ICON' => $action === 'remove' ? 'fa fa-minus fa-fw' : 'fa fa-plus fa-fw',
			'IINEDX_LANG' => $action === 'remove' ? $this->language->lang('REMOVE_INILIST') : $this->language->lang('ADD_INILIST'),
			'MESSAGE' => $message,
		]);
		$event['post_row'] = $post_row;
	}

	protected function assign_index_blocks(array $topics, $filter, $forum_id, $topic_id)
	{
		$keys = $this->functions_topicindex->create_key_list($topics);
		$filtered_topics = $this->functions_topicindex->filter_topiclist($topics, $filter);
		foreach (range('a', 'z') as $letter)
		{
			$this->template->assign_block_vars('block_filtrino', [
				'U_FILTER' => append_sid($this->root_path . 'viewtopic.' . $this->php_ext, ['f' => $forum_id, 't' => $topic_id, 'ilimit' => $letter]),
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
					'ITOPIC_CLASS' => $row_number % 2 ? 'row bg1' : 'row bg3',
					'U_FORUM' => append_sid($this->root_path . 'viewforum.' . $this->php_ext, ['f' => $topic['forum_id']]),
					'S_CAN_MANAGE' => $topic['can_manage'],
					'MANAGE_ACTION' => 'remove',
				];
				$template_vars = $this->functions_topicindex->enrich_template_vars($topic, $template_vars);
				$this->template->assign_block_vars('block_list.block_topic_index', $template_vars);
				$row_number++;
			}
		}

		$this->template->assign_block_vars('block_nofiltrino', [
			'U_TUTTI' => append_sid($this->root_path . 'viewtopic.' . $this->php_ext, ['f' => $forum_id, 't' => $topic_id]),
			'U_09' => append_sid($this->root_path . 'viewtopic.' . $this->php_ext, ['f' => $forum_id, 't' => $topic_id, 'ilimit' => '09']),
			'U_SYMB' => append_sid($this->root_path . 'viewtopic.' . $this->php_ext, ['f' => $forum_id, 't' => $topic_id, 'ilimit' => '_']),
			'S_09' => in_array('09', $keys, true),
			'S_SYMB' => in_array('_', $keys, true),
		]);
	}

	protected function normalise_filter($filter)
	{
		$filter = mb_strtolower(trim((string) $filter));

		return preg_match('#^(?:[a-z]|09|_)$#', $filter) ? $filter : '';
	}

	protected function get_new_topic_url()
	{
		$forum_id = (int) $this->config['topicindex_new_topic_forum'];
		if (!$forum_id || !$this->auth->acl_get('f_post', $forum_id))
		{
			return '';
		}

		return append_sid($this->root_path . 'posting.' . $this->php_ext, ['mode' => 'post', 'f' => $forum_id]);
	}

	protected function is_valid_official_topic($forum_id, $topic_id)
	{
		$forum_id = (int) $forum_id;
		$topic_id = (int) $topic_id;
		if (!$topic_id)
		{
			return true;
		}
		if (!$forum_id)
		{
			return false;
		}

		$sql = 'SELECT topic_id
			FROM ' . TOPICS_TABLE . '
			WHERE topic_id = ' . $topic_id . '
				AND forum_id = ' . $forum_id . '
				AND topic_visibility = ' . ITEM_APPROVED . '
				AND topic_posts_approved >= 1
				AND ' . $this->db->sql_in_set('topic_type', [POST_STICKY, POST_ANNOUNCE]);
		$result = $this->db->sql_query_limit($sql, 1);
		$is_valid = (bool) $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $is_valid;
	}
}
