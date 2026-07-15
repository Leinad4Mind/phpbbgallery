<?php

/**
 *
 * @package Topic description searchable
 * @copyright (c) 2016 RMcGirr83
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 *
 */

namespace rmcgirr83\topicdescription\event;

/**
 * @ignore
 */

use phpbb\path_helper;
use phpbb\auth\auth;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\language\language;
use phpbb\user;
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\search\fulltext_native;
use s9e\TextFormatter\Configurator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	private $topic_desc = '';

	/** @var auth */
	protected $auth;

	/** @var request */
	protected $request;

	/** @var template */
	protected $template;

	/** @var language */
	protected $language;

	/** @var user */
	protected $user;

	/** @var config */
	protected $config;

	/** @var driver_interface */
	protected $db;

	/** @var path_helper */
	protected $path_helper;

	/** @var fulltext_native */
	protected $search;

	/** @var string */
	protected $new_topic_desc;

	/** @var string */
	protected $old_topic_desc;

	/** @var string */
	protected $search_fields = '';

	/**
	 * Constructor
	 *
	 * @param auth				$auth			Auth object
	 * @param request			$request		Request object
	 * @param template			$template		Template object
	 * @param language			$language		Language object
	 * @param user				$user			User object
	 * @param config			$config			Config object
	 * @param driver_interface	$db				Db object
	 * @param path_helper		$path_helper	Path helper object
	 * @access public
	 */
	public function __construct(
		auth $auth,
		request $request,
		template $template,
		language $language,
		user $user,
		config $config,
		driver_interface $db,
		path_helper $path_helper
	) {
		$this->auth = $auth;
		$this->request = $request;
		$this->template = $template;
		$this->language = $language;
		$this->user = $user;
		$this->config = $config;
		$this->db = $db;
		$this->path_helper = $path_helper;
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
			'core.acp_extensions_run_action_after'			=> 'acp_extensions_run_action_after',
			'core.permissions'								=> 'add_permission',
			'core.user_setup_after'							=> 'user_setup_after',
			'core.posting_modify_message_text'				=> 'modify_message_text',
			'core.posting_modify_submission_errors'			=> 'topic_desc_add_to_post_data',
			'core.posting_modify_submit_post_before'		=> 'topic_desc_add',
			'core.submit_post_modify_sql_data'				=> 'submit_post_modify_sql_data',
			'core.posting_modify_template_vars'				=> 'topic_data_topic_desc',
			'core.viewtopic_modify_page_title'				=> 'topic_desc_add_viewtopic',
			'core.viewtopic_assign_template_vars_before'	=> 'viewtopic_assign_template_vars_before',
			'core.viewforum_modify_topicrow'				=> 'modify_topicrow',
			'core.search_modify_tpl_ary'					=> 'search_modify_tpl_ary',
			'core.mcp_view_forum_modify_topicrow'			=> 'modify_topicrow',
			'core.mcp_topic_review_modify_row'				=> 'mcp_topic_review_modify_row',
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
			// Sphinx
			// for phpBB 3.3 at least we need to edit sphinx.conf and change:
			// p.post_subject as title, \
			// to
			// CONCAT(p.post_subject, ' ', t.topic_desc) as title, \
			// 'core.search_sphinx_index_before'					=> 'search_sphinx_index_before',
		);
	}

	/* Display additional metdata in extension details
	*
	* @param $event			event object
	* @param return null
	* @access public
	*/
	public function acp_extensions_run_action_after($event)
	{
		if ($event['ext_name'] == 'rmcgirr83/topicdescription' && $event['action'] == 'details') {
			$this->template->assign_var('S_BUY_ME_A_BEER_TOPICDESCRIPTION', true);
		}
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
		$permissions['f_topic_desc'] = ['lang' => 'ACL_F_TOPIC_DESC', 'cat' => 'post'];
		$event['permissions'] = $permissions;
	}

	/**
	 * Add language
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function user_setup_after($event)
	{
		$this->language->add_lang('common', 'rmcgirr83/topicdescription');
	}

	public function topic_data_topic_desc($event)
	{
		global $phpbb_root_path;
		$mode = $event['mode'];
		$post_data = $event['post_data'];
		$page_data = $event['page_data'];

		// Check if 'topic_desc' index exists in $post_data before accessing it
		$topic_desc = (!empty($post_data['topic_desc'])) ? $post_data['topic_desc'] : '';

		if ($this->auth->acl_get('f_topic_desc', $event['forum_id']) && ($mode == 'post' || ($mode == 'edit' && $post_data['topic_first_post_id'] == $post_data['post_id']))) {
			$page_data['TOPIC_DESC'] = $this->request->variable('topic_desc', $topic_desc, true);
			// Avoid accessing $post_data['topic_desc'] directly without checking its existence
			$search_desc = !empty($post_data['topic_desc']) ? $post_data['topic_desc'] : '';
			$page_data['SEARCH_DESC'] = $phpbb_root_path . '/search.php?keywords=' . $this->request->variable('topic_desc', $search_desc, true) . '&sf=titleonly&sr=topics';
			$page_data['S_DESC_TOPIC'] = true;
			$event['page_data'] = $page_data;
		}
	}

	public function topic_desc_add_to_post_data($event)
	{
		if ($this->auth->acl_get('f_topic_desc', $event['forum_id'])) {
			$topic_desc = !empty($event['post_data']['topic_desc']) ? $event['post_data']['topic_desc'] : '';
			$topic_desc = $this->auth->acl_get('f_topic_desc', $event['forum_id']) ? $this->request->variable('topic_desc', $topic_desc, true) : $topic_desc;
			$error = [];

			/**
			 * Replace Emojis and other 4bit UTF-8 chars not allowed by MySQL to UCR/NCR.
			 * Using their Numeric Character Reference's Hexadecimal notation.
			 * Check the permissions for posting Emojis first.
			 */
			if ($this->auth->acl_get('u_emoji'))
			{
				$topic_desc = utf8_encode_ucr($topic_desc);
			}
			else
			{
				/**
				 * Check for out-of-bounds characters that are currently
				 * not supported by utf8_bin in MySQL
				 */
				if (preg_match_all('/[\x{10000}-\x{10FFFF}]/u', $topic_desc, $matches))
				{
					$character_list = implode('<br>', $matches[0]);

					$error[] = $this->user->lang('UNSUPPORTED_CHARACTERS_TD', $character_list);
					$event['error'] = array_merge($event['error'], $error);
				}
			}
			
			if (!count($error))
			{
				$event['post_data'] = array_merge($event['post_data'], [
					'topic_desc'	=> $topic_desc,
				]);
			}
		}
	}

	public function topic_desc_add($event)
	{
		if ($this->new_topic_desc === null) {
			return;
		}

		if ($this->old_topic_desc !== null && $this->new_topic_desc != $this->old_topic_desc && !$event['update_subject']) {
			$event['update_subject'] = true;
		}

		$event['data'] = array_merge($event['data'], [
			'topic_desc'	=> $this->new_topic_desc,
		]);
	}

	public function submit_post_modify_sql_data($event)
	{
		$mode = $event['post_mode'];
		$topic_desc = !empty($event['data']['topic_desc']) ? $event['data']['topic_desc'] : '';
		$data_sql = $event['sql_data'];
		if (in_array($mode, ['post', 'edit_topic', 'edit_first_post'])) {
			$data_sql[TOPICS_TABLE]['sql']['topic_desc'] = $topic_desc;
		}
		$event['sql_data'] = $data_sql;
	}

	public function topic_desc_add_viewtopic($event)
	{
		$topic_data = $event['topic_data'];
		$this->template->assign_var('TOPIC_DESC', $this->make_link($topic_data['topic_desc']));
	}

	public function modify_message_text($event)
	{
		$post_data = $event['post_data'];

		$this->old_topic_desc = !empty($post_data['topic_desc']) ? $post_data['topic_desc'] : '';

		if ($this->auth->acl_get('f_topic_desc', $event['forum_id'])) {
			$this->new_topic_desc = $this->request->variable('topic_desc', '', true);
		} else {
			$this->new_topic_desc = $this->old_topic_desc;
		}

		$event['post_data'] = array_merge($post_data, [
			'topic_desc' => $this->new_topic_desc,
		]);
	}

	public function modify_topicrow($event)
	{
		$row = $event['row'];
		if (!empty($row['topic_desc'])) {
			$topic_row = $event['topic_row'];
			$topic_row['TOPIC_DESC'] = $this->make_link($row['topic_desc']);
			$event['topic_row'] = $topic_row;
			
			$search = str_replace('&amp; ', '', $event['topic_row']['TOPIC_DESC']);
			$this->template->assign_var('U_VIEW_TDESC', append_sid($this->path_helper->get_phpbb_root_path() . 'search.' . $this->path_helper->get_php_ext(), [
				'terms'		=> 'all',
				'sr'		=> 'topics',
				'sf'		=> 'titleonly',
				'sk'		=> 't',
				'sd'		=> 'd',
				'st'		=> '0',
				'keywords'	=> '',
			]));
		}
	}

	public function viewtopic_assign_template_vars_before($event)
	{
		if (!empty($event['topic_data']['topic_desc'])) {
			$search = str_replace('&amp; ', '', $event['topic_data']['topic_desc']);
			$this->template->assign_var('U_VIEW_TDESC', append_sid($this->path_helper->get_phpbb_root_path() . 'search.' . $this->path_helper->get_php_ext(), [
				'terms'		=> 'all',
				'sr'		=> 'topics',
				'sf'		=> 'titleonly',
				'sk'		=> 't',
				'sd'		=> 'd',
				'st'		=> '0',
				'keywords'	=> urlencode($search),
			]));
		}
	}

	public function search_modify_tpl_ary($event)
	{
		$row = $event['row'];
		if ($event['show_results'] == 'topics' && !empty($row['topic_desc'])) {
			$tpl_array = $event['tpl_ary'];
			$tpl_array['TOPIC_DESC'] = $this->make_link($row['topic_desc']);
			$event['tpl_ary'] = $tpl_array;
			if (!empty($event['topic_row']['TOPIC_DESC'])) {
				$search = str_replace('&amp; ', '', $event['topic_row']['TOPIC_DESC']);
			}
			$this->template->assign_var('U_VIEW_TDESC', append_sid($this->path_helper->get_phpbb_root_path() . 'search.' . $this->path_helper->get_php_ext(), [
				'terms'		=> 'all',
				'sr'		=> 'topics',
				'sf'		=> 'titleonly',
				'sk'		=> 't',
				'sd'		=> 'd',
				'st'		=> '0',
				'keywords'	=> '',
			]));
		}
	}

	public function mcp_topic_review_modify_row($event)
	{
		$row = $event['row'];
		$topic_info = $event['topic_info'];

		if ($topic_info['topic_first_post_id'] == $row['post_id'] && !empty($topic_info['topic_desc'])) {
			$post_row = $event['post_row'];
			$post_row['TOPIC_DESC'] = $this->make_link($topic_info['topic_desc']);
			$event['post_row'] = $post_row;
		}
	}

	/**
	 * @param $event
	 */
	public function search_sphinx_index_before($event)
	{
		if (!$this->auth->acl_get('f_topic_desc', $event['forum_id'])) {
			return;
		}

		$topic_desc = $this->new_topic_desc;

		if ($topic_desc === null) {
			$topic_desc = $this->get_topic_desc($event['post_id']);
		}

		if ($topic_desc === '') {
			return;
		}

		$event['subject'] .= $topic_desc;
	}

	/**
	 * @param $event
	 */
	public function search_native_index_before($event)
	{
		if (!$this->auth->acl_get('f_topic_desc', $event['forum_id'])) {
			return;
		}

		$topic_desc = $this->new_topic_desc;

		if ($topic_desc === null) {
			$topic_desc = $this->get_topic_desc($event['post_id']);
		}

		if ($topic_desc === '') {
			return;
		}

		if ($this->search === null) {
			$this->search = $this->get_search('native');
		}

		$words = $event['words'];
		$split_desc = $this->search->split_message($topic_desc);
		$split_title = array_merge($event['split_title'], $split_desc);

		if ($event['mode'] == 'edit') {
			$cur_title_words = array_keys($event['cur_words']['title']);
			$words['add']['title'] = array_diff($split_title, $cur_title_words);
			$words['del']['title'] = array_diff($cur_title_words, $split_title);
		} else {
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

		if (empty($stats['topic_desc'])) {
			$alter_entry = [];

			if ($this->db->get_sql_layer() == 'mysqli' || version_compare($this->db->sql_server_info(true), '4.1.3', '>=')) {
				$alter_entry[] = 'MODIFY topic_desc mediumtext COLLATE utf8mb4_unicode_ci NOT NULL';
			} else {
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
		if (!$this->auth->acl_get('f_topic_desc', $event['forum_id'])) {
			return;
		}

		$topic_desc = $this->new_topic_desc;

		if ($topic_desc === null) {
			$topic_desc = $this->get_topic_desc($event['post_id']);
		}

		if ($topic_desc === '') {
			return;
		}

		if ($this->search === null) {
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
		$result = $this->db->sql_query('SHOW INDEX FROM ' . TOPICS_TABLE . ' WHERE Key_name = \'topic_desc\'');
		$index_exists = (bool) $this->db->sql_fetchfield('Key_name');

		if ($index_exists) {
			$event['sql_queries'] = array_merge($event['sql_queries'], [
					'ALTER TABLE ' . TOPICS_TABLE . ' DROP INDEX topic_desc',
			]);
		}
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
		if ($this->search_fields != 'msgonly') {
			if ($this->search_fields == 'titleonly') {
				$event['sql_match'] = "MATCH (t.topic_title, t.topic_desc) AGAINST ('" . $this->db->sql_escape(html_entity_decode($event['search_query'], ENT_COMPAT)) . "' IN BOOLEAN MODE)";
				$event['join_topic'] = true;
			}
			else {
				$clean_query = str_replace('+', '', $event['search_query']);
				$keywords = explode(' ', $clean_query); // Split query into words
				$like_clauses = [];

				foreach ($keywords as $word) {
					$word = trim($word);
					if ($word === '') {
						continue; // ignora palavras vazias
					}
					$word = $this->db->sql_escape($word);
					$like_clauses[] = "(p.post_subject LIKE '%$word%' OR t.topic_desc LIKE '%$word%')";
				}

				if (!empty($like_clauses)) {
					$event['sql_match_where'] .= ' AND (' . implode(' AND ', $like_clauses) . ')';
					$event['sql_match'] = '1=1';
					$event['join_topic'] = true;
				}
			}
		}
	}

	/**
	 * @param $event
	 */
	public function search_postgres_create_index_before($event)
	{
		$stats = $event['stats'];

		if (empty($stats['post_subject'])) {
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
		if (!$this->auth->acl_get('f_topic_desc', $event['forum_id'])) {
			return;
		}

		$topic_desc = $this->new_topic_desc;

		if ($topic_desc === null) {
			$topic_desc = $this->get_topic_desc($event['post_id']);
		}

		if ($topic_desc === '') {
			return;
		}

		if ($this->search === null) {
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
		if ($this->search_fields != 'msgonly') {
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

	private function make_link($text)
	{
			$configurator = new Configurator;
			$configurator->Autolink->matchWww = true;

			// Get an instance of the parser and the renderer
			extract($configurator->finalize());
			$text = censor_text($text);
			$xml  = $parser->parse($text);
			$html = $renderer->render($xml);
			return html_entity_decode($html);
	}
}
