<?php
/**
*
* @package Topic description
* @copyright (c) 2016 RMcGirr83
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*
*/

namespace rmcgirr83\topicdescription\event;

/**
* @ignore
*/
use phpbb\search\fulltext_native;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	private $topic_desc = '';

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\search\fulltext_native */
	protected $search;

	/** @var string */
	protected $new_topic_desc;

	/** @var string */
	protected $old_topic_desc;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth					$auth				Auth object
	* @param \phpbb\request\request				$request			Request object
	* @param \phpbb\template\template           $template       	Template object
	* @param \phpbb\user                        $user           	User object
	* @param \phpbb\config\config				$config				Config object
	* @param \phpbb\db\driver\driver_interface	$db					Db object
	* @access public
	*/
	public function __construct(
			\phpbb\auth\auth $auth,
			\phpbb\request\request $request,
			\phpbb\template\template $template,
			\phpbb\user $user,
			\phpbb\config\config $config,
			\phpbb\db\driver\driver_interface $db
	)
	{
		$this->auth = $auth;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->db = $db;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.permissions'						=> 'add_permission',
			'core.posting_modify_template_vars'		=> 'topic_data_topic_desc',
			'core.posting_modify_submission_errors'		=> 'topic_desc_add_to_post_data',
			'core.posting_modify_submit_post_before'		=> 'topic_desc_add',
			'core.posting_modify_message_text'		=> 'modify_message_text',
			'core.submit_post_modify_sql_data'		=> 'submit_post_modify_sql_data',
			'core.viewtopic_modify_page_title'		=> 'topic_desc_add_viewtopic',
			'core.viewforum_modify_topicrow'		=> 'modify_topicrow',
			'core.search_modify_tpl_ary'			=> 'search_modify_tpl_ary',
			'core.mcp_view_forum_modify_topicrow'	=> 'modify_topicrow',
			'core.mcp_topic_review_modify_row'		=> 'mcp_topic_review_modify_row',
			// Native
			'core.search_native_index_before'					=> 'search_native_index_before',
			// MySQL
			'core.search_mysql_create_index_before'				=> 'search_mysql_create_index_before',
			'core.search_mysql_index_before'					=> 'search_mysql_index_before',
			'core.search_mysql_delete_index_before'				=> 'search_mysql_delete_index_before',
			'core.search_mysql_by_keyword_modify_search_key'	=> 'search_mysql_by_keyword_modify_search_key',
			'core.search_mysql_keywords_main_query_before'		=> 'search_mysql_keywords_main_query_before',
			// Postgres
			'core.search_postgres_create_index_before'			=> 'search_postgres_create_index_before',
			'core.search_postgres_index_before'					=> 'search_postgres_index_before',
			'core.search_postgres_delete_index_before'			=> 'search_postgres_delete_index_before',
			'core.search_postgres_by_keyword_modify_search_key'	=> 'search_postgres_by_keyword_modify_search_key',
			'core.search_postgres_keywords_main_query_before'	=> 'search_postgres_keywords_main_query_before',
		);
	}

	/**
	* Add administrative permissions to manage forums
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['f_topic_desc'] = array('lang' => 'ACL_F_TOPIC_DESC', 'cat' => 'post');
		$event['permissions'] = $permissions;
	}

	public function topic_data_topic_desc($event)
	{
		$mode = $event['mode'];
		$post_data = $event['post_data'];
		$page_data = $event['page_data'];
		$post_data['topic_desc'] = (!empty($post_data['topic_desc'])) ? $post_data['topic_desc'] : '';
		if ($this->auth->acl_get('f_topic_desc', $event['forum_id']) && ($mode == 'post' || ($mode == 'edit' && $post_data['topic_first_post_id'] == $post_data['post_id'])))
		{
			$this->user->add_lang_ext('rmcgirr83/topicdescription', 'common');
			$page_data['TOPIC_DESC'] = $this->request->variable('topic_desc', $post_data['topic_desc'], true);
			$page_data['S_DESC_TOPIC'] = true;
		}

		$event['page_data']	= $page_data;
	}

	public function topic_desc_add_to_post_data($event)
	{
		if ($this->auth->acl_get('f_topic_desc', $event['forum_id']))
		{
			$event['post_data'] = array_merge($event['post_data'], array(
				'topic_desc'	=> $this->request->variable('topic_desc', '', true),
			));
		}
	}

	public function topic_desc_add($event)
	{
		if ($this->new_topic_desc === null)
		{
			return;
		}

		if ($this->old_topic_desc !== null && $this->new_topic_desc != $this->old_topic_desc && !$event['update_subject'])
		{
			$event['update_subject'] = true;
		}

		$event['data'] = array_merge($event['data'], array(
			'topic_desc'	=> $this->new_topic_desc,
		));
	}

	public function modify_message_text($event)
	{
		$event['post_data'] = array_merge($event['post_data'], array(
			'topic_desc'	=> $this->request->variable('topic_desc', $event['post_data']['topic_desc'], true),
		));
	}

	public function submit_post_modify_sql_data($event)
	{
		$mode = $event['post_mode'];
		$topic_desc = $event['data']['topic_desc'];
		$data_sql = $event['sql_data'];
		if (in_array($mode, array('post', 'edit_topic', 'edit_first_post')))
		{
			$data_sql[TOPICS_TABLE]['sql']['topic_desc'] = $topic_desc;
		}
		$event['sql_data'] = $data_sql;
	}

	public function topic_desc_add_viewtopic($event)
	{
		$topic_data = $event['topic_data'];
		$this->template->assign_var('TOPIC_DESC', censor_text($topic_data['topic_desc']));
	}

	public function modify_message_text($event)
	{
		$post_data = $event['post_data'];

		$this->new_topic_desc = $this->request->variable('topic_desc', '', true);

		if (isset($post_data['topic_desc']))
		{
			$this->old_topic_desc = $event['post_data']['topic_desc'];
		}

		$event['post_data'] = array_merge($post_data, array(
			'topic_desc' => $this->new_topic_desc,
		));
	}

	public function modify_topicrow($event)
	{
		$row = $event['row'];
		if (!empty($row['topic_desc']))
		{
			$topic_row = $event['topic_row'];
			$topic_row['TOPIC_DESC'] = censor_text($row['topic_desc']);
			$event['topic_row'] = $topic_row;
		}
	}

	public function search_modify_tpl_ary($event)
	{
		$row = $event['row'];
		if ($event['show_results'] == 'topics' && !empty($row['topic_desc']))
		{
			$tpl_array = $event['tpl_ary'];
			$tpl_array['TOPIC_DESC'] = censor_text($row['topic_desc']);
			$event['tpl_ary'] = $tpl_array;
		}
	}

	public function mcp_topic_review_modify_row($event)
	{
		$row = $event['row'];
		$topic_info = $event['topic_info'];

		if ($topic_info['topic_first_post_id'] == $row['post_id'] && !empty($topic_info['topic_desc']))
		{
			$post_row = $event['post_row'];
			$post_row['TOPIC_DESC'] = censor_text($topic_info['topic_desc']);
			$event['post_row'] = $post_row;
		}
	}

	/**
	 * @param $event
	 */
	public function search_native_index_before($event)
	{
		if (!$this->auth->acl_get('f_topic_desc', $event['forum_id']))
		{
			return;
		}

		$topic_desc = $this->new_topic_desc;

		if ($topic_desc === null)
		{
			$topic_desc = $this->get_topic_desc($event['post_id']);
		}

		if ($topic_desc === '')
		{
			return;
		}

		if ($this->search === null)
		{
			$this->search = $this->get_search('native');
		}

		$words = $event['words'];
		$split_desc = $this->search->split_message($topic_desc);
		$split_title = array_merge($event['split_title'], $split_desc);

		if ($event['mode'] == 'edit')
		{
			$cur_title_words = array_keys($event['cur_words']['title']);
			$words['add']['title'] = array_diff($split_title, $cur_title_words);
			$words['del']['title'] = array_diff($cur_title_words, $split_title);
		}
		else
		{
			$words['add']['title'] = $split_title;
		}

		$event['words'] = $words;
	}

	/**
	 * @param $event
	 */
	public function search_mysql_create_index_before($event)
	{
		$stats = $event['stats'];

		if (!isset($stats['topic_desc']))
		{
			$alter_entry = [];

			if ($this->db->get_sql_layer() == 'mysqli' || version_compare($this->db->sql_server_info(true), '4.1.3', '>='))
			{
				$alter_entry[] = 'MODIFY topic_desc mediumtext COLLATE utf8_unicode_ci NOT NULL';
			}
			else
			{
				$alter_entry[] = 'MODIFY topic_desc mediumtext NOT NULL';
			}

			$alter_entry[] = 'ADD FULLTEXT topic_desc (topic_desc)';

			$event['sql_queries'] = array_merge($event['sql_queries'], [
				'ALTER TABLE ' . TOPICS_TABLE . ' ' . implode(', ', $alter_entry),
			]);
		}
	}

	/**
	 * @param $event
	 */
	public function search_mysql_index_before($event)
	{
		if (!$this->auth->acl_get('f_topic_desc', $event['forum_id']))
		{
			return;
		}

		$topic_desc = $this->new_topic_desc;

		if ($topic_desc === null)
		{
			$topic_desc = $this->get_topic_desc($event['post_id']);
		}

		if ($topic_desc === '')
		{
			return;
		}

		if ($this->search === null)
		{
			$this->search = $this->get_search('mysql');
		}

		$split_desc = $this->search->split_message($topic_desc);
		$event['words'] = array_unique(array_merge($event['words'], $split_desc));
	}

	/**
	 * @param $event
	 */
	public function search_mysql_delete_index_before($event)
	{
		$event['sql_queries'] = array_merge($event['sql_queries'], [
			'ALTER TABLE ' . TOPICS_TABLE . ' DROP INDEX topic_desc',
		]);
	}

	/**
	 * @param $event
	 */
	public function search_mysql_by_keyword_modify_search_key($event)
	{
		$this->search_fields = $event['fields'];
	}

	/**
	 * @param $event
	 */
	public function search_mysql_keywords_main_query_before($event)
	{
		if ($this->search_fields != 'msgonly')
		{
			$event['sql_match'] .= ', t.topic_desc';
			$event['join_topic'] = true;
		}
	}

	/**
	 * @param $event
	 */
	public function search_postgres_create_index_before($event)
	{
		$stats = $event['stats'];

		if (!isset($stats['post_subject']))
		{
			$event['sql_queries'] = array_merge($event['sql_queries'], [
				"CREATE INDEX " . TOPICS_TABLE . "_" . $this->config['fulltext_postgres_ts_name'] . "_topic_desc ON " . TOPICS_TABLE . " USING gin (to_tsvector ('" . $this->db->sql_escape($this->config['fulltext_postgres_ts_name']) . "', topic_desc))"
			]);
		}
	}

	/**
	 * @param $event
	 */
	public function search_postgres_index_before($event)
	{
		if (!$this->auth->acl_get('f_topic_desc', $event['forum_id']))
		{
			return;
		}

		$topic_desc = $this->new_topic_desc;

		if ($topic_desc === null)
		{
			$topic_desc = $this->get_topic_desc($event['post_id']);
		}

		if ($topic_desc === '')
		{
			return;
		}

		if ($this->search === null)
		{
			$this->search = $this->get_search('postgres');
		}

		$split_desc = $this->search->split_message($topic_desc);
		$event['words'] = array_unique(array_merge($event['words'], $split_desc));
	}

	/**
	 * @param $event
	 */
	public function search_postgres_delete_index_before($event)
	{
		$event['sql_queries'] = array_merge($event['sql_queries'], [
			$sql_queries[] = 'DROP INDEX ' . $event['stats']['topic_desc']['relname'],
		]);
	}

	/**
	 * @param $event
	 */
	public function search_postgres_by_keyword_modify_search_key($event)
	{
		$this->search_fields = $event['fields'];
	}

	/**
	 * @param $event
	 */
	public function search_postgres_keywords_main_query_before($event)
	{
		if ($this->search_fields != 'msgonly')
		{
			$event['sql_match'] .= ', t.topic_desc';
			$event['join_topic'] = true;
		}
	}

	/**
	 * @param int $post_id
	 * @return string
	 */
	protected function get_topic_desc($post_id)
	{
		$sql_ary = [
			'SELECT'	=> 't.topic_desc',
			'FROM'		=> [POSTS_TABLE => 'p'],
			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [TOPICS_TABLE => 't'],
					'ON'	=> 't.topic_id = p.topic_id',
				]
			],
			'WHERE'		=> 'p.post_id = ' . (int) $post_id,
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$topic_desc = $this->db->sql_fetchfield('topic_desc');
		$this->db->sql_freeresult($result);

		return (string) $topic_desc;
	}

	/**
	 * @param string $search
	 * @return \phpbb\search\base
	 */
	protected function get_search($search)
	{
		global $phpbb_root_path, $phpEx, $config, $phpbb_dispatcher;

		$search = '\phpbb\search\fulltext_' . $search;
		$error = null;

		return new $search($error, $phpbb_root_path, $phpEx, $this->auth, $config, $this->db, $this->user, $phpbb_dispatcher);
	}
}
