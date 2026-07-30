<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\event;

use sitesplat\bbprefix\core\manager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $db;
	protected $cache;
	protected $template;
	protected $request;
	protected $user;
	protected $config;
	protected $manager;
	protected $table_prefix;
	protected $active_prefix_ids = [];
	protected $last_post_topic_ids = [];
	protected $setup_has_been_run = false;

	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'							=> 'setup',
			'core.viewforum_modify_topicrow'			=> 'get_topiclist_topic_prefixes',
			'core.viewtopic_modify_page_title'			=> 'get_viewtopic_topic_prefix',
			'core.submit_post_end'						=> 'manage_prefixes_on_posting',
			'core.posting_modify_submission_errors'		=> 'validate_prefix_selection_limits',
			'core.posting_modify_template_vars'			=> 'generate_posting_form',
			'core.mcp_view_forum_modify_topicrow'		=> 'get_topiclist_topic_prefixes',
			'core.viewforum_get_topic_data'				=> 'prefilter_viewforum_by_prefix',
			'core.viewforum_get_announcement_topic_ids_data' => 'hack_out_announcements',
			'core.viewforum_get_topic_ids_data'			=> 'filter_viewforum_by_prefix',
			'core.pagination_generate_page_link'		=> 'fix_viewforum_base_url',
			'core.display_forums_modify_template_vars'	=> 'get_forumlist_topic_prefixes',
			'core.search_modify_tpl_ary'				=> 'get_searchlist_topic_prefixes',
		];
	}

	/**
	 * Set up the environment
	 *
	 * @param Event $event Event object
	 * @return null
	 */
	public function setup($event)
	{
		// The log entries the manager writes on a cache/database anomaly use
		// this language set, and it needs registering on every pass of this
		// event - including the ACP's own request - or the raw language key
		// shows up in the error log instead of the translated text.
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name'	=> 'sitesplat/bbprefix',
			'lang_set'	=> 'bbprefix_log',
		];
		$event['lang_set_ext'] = $lang_set_ext;

		// Keep this from running twice
		if(true === $this->setup_has_been_run)
		{
			return;
		}

		global $phpbb_container;

		$this->setup_has_been_run = true;

		$this->container = $phpbb_container;

		// Let's get our table constants out of the way
		$table_prefix = $this->container->getParameter('core.table_prefix');
		define('BBPREFIX_TABLE', $table_prefix . 'bbprefix');
		define('BBPREFIX_INSTANCES_TABLE', $table_prefix . 'bbprefix_instances');
		define('BBPREFIX_CATEGORIES_TABLE', $table_prefix . 'bbprefix_categories');

		$this->user = $this->container->get('user');
		$this->db = $this->container->get('dbal.conn');
		$this->config = $this->container->get('config');
		$this->request = $this->container->get('request');
		$this->manager = $this->container->get('bbprefix.manager');
	}

	/**
	 * Get the actual data to store in the DB for given tokens
	 * This handles the tokens available by default in this extension
	 *
	 * @param Event $event Event object
	 * @return null
	 */
	public function get_token_data($event)
	{
		$tokens =& $event['token_data'];

		if (false !== strpos($event['prefix'], '{DATE}'))
		{
			$tokens['DATE'] = $this->container->get('user')->format_date(microtime(true));
		}

		if (false !== strpos($event['prefix'], '{USERNAME}'))
		{
			$tokens['USERNAME'] = $this->container->get('user')->data['username'];
		}
	}

	/**
	 * Get the form things for the posting form
	 *
	 * @return Event $event Event object
	 */
	public function generate_posting_form($event)
	{
		$this->user->add_lang_ext('sitesplat/bbprefix', 'bbprefix');
		$this->manager->generate_posting_form($event);
	}

	/**
	 * Perform given actions with given prefix IDs on the posting screen
	 *
	 * @param Event $event Event object
	 * @return null
	 */
	public function manage_prefixes_on_posting($event)
	{
		// This event is only called when a post has been submitted.

		// We only want to do things when we're editing the first post
		// or posting a new topic, so those are the only cases in which
		// this function can continue.
		if ('edit' === $event['mode'])
		{
			$sql = 'SELECT topic_first_post_id FROM ' . TOPICS_TABLE . ' WHERE topic_id = ' . (int) $event['data']['topic_id'];
			$result = $this->db->sql_query($sql);
			$first_post_id = $this->db->sql_fetchfield('topic_first_post_id');
			$this->db->sql_freeresult($result);

			if ((int) $event['data']['post_id'] !== (int) $first_post_id)
			{
				return;
			}
		} elseif ('post' !== $event['mode']) {
			return;
		}

		$this->manager->set_topic_prefixes((int) $event['data']['topic_id'], $this->manager->get_submitted_prefixes(), (int) $event['data']['forum_id']);
	}

	/**
	 * Enforce the configured minimum/maximum number of prefixes (prefixes and
	 * suffixes counted together) a topic can carry.
	 *
	 * This has to run before the post is saved, not after - by the time
	 * manage_prefixes_on_posting() runs (core.submit_post_end), the post
	 * already exists and it is too late to refuse it. This event lets any
	 * string added to its `error` array abort the submission outright, with
	 * that string shown to the user as-is.
	 *
	 * @param Event $event Event object
	 * @return null
	 */
	public function validate_prefix_selection_limits($event)
	{
		if (!$event['submit'] || !in_array($event['mode'], ['post', 'edit']))
		{
			return;
		}

		$min = (int) $this->config['bbprefix_min_selected'];
		$max = (int) $this->config['bbprefix_max_selected'];
		if (!$min && !$max)
		{
			return;
		}

		$this->user->add_lang_ext('sitesplat/bbprefix', 'bbprefix');
		$selected = count($this->manager->get_submitted_prefixes());
		$error = $event['error'];

		if ($min && $selected < $min)
		{
			$error[] = sprintf($this->user->lang['BBPREFIX_MIN_SELECTED_ERROR'], $min);
		}

		if ($max && $selected > $max)
		{
			$error[] = sprintf($this->user->lang['BBPREFIX_MAX_SELECTED_ERROR'], $max);
		}

		$event['error'] = $error;
	}

	/**
	 * Get the parsed prefix for the current topic, output it to the template
	 * Also gets a plaintext version for the browser page title
	 *
	 * @param Event $event Event object
	 * @return null
	 */
	public function get_viewtopic_topic_prefix($event)
	{
		$prefix = $this->load_prefixes_topic($event, 'topic_data', 'prefix', false, 'prefix');
		$suffix = $this->load_prefixes_topic($event, 'topic_data', 'suffix', false, 'suffix');
		$event['page_title'] = $prefix . $event['page_title'] . $suffix;
	}

	/**
	 * Get the parsed prefix for each of the topics in the forum row
	 *
	 * @param Event $event Event object
	 * @return null
	 */
	public function get_topiclist_topic_prefixes($event)
	{
		$topic_row = $event['topic_row'];
		$topic_row['TOPIC_PREFIX'] = $this->load_prefixes_topic($event, 'row', '', true, 'prefix');

		// There is no template hook sitting right next to the topic title
		// itself here (the only "append" event this template exposes fires
		// at the very end of the whole row, well past the title) - so a
		// suffix is appended directly onto the title value instead.
		$suffix = $this->load_prefixes_topic($event, 'row', '', true, 'suffix');
		if ($suffix !== '')
		{
			$topic_row['TOPIC_TITLE'] = $topic_row['TOPIC_TITLE'] . ' ' . $suffix;
		}

		$event['topic_row'] = $topic_row;
	}

    public function get_searchlist_topic_prefixes($event)
    {
        $tpl_ary = $event['tpl_ary']; // Template variables
        $prefix = $this->load_prefixes_topic($event, 'row', '', true, 'prefix');
        $suffix = $this->load_prefixes_topic($event, 'row', '', true, 'suffix');
        $tpl_ary['TOPIC_TITLE'] = $prefix . $tpl_ary['TOPIC_TITLE'] . $suffix;
        if (!empty($tpl_ary['POST_SUBJECT']))
        {
            $tpl_ary['POST_SUBJECT'] = $prefix . $tpl_ary['POST_SUBJECT'] . $suffix;
        }
        $event['tpl_ary'] = $tpl_ary;
    }

	/**
	 * Get the parsed prefix for each of the last posts
	 *
	 * @param Event $event Event object
	 * @return null
	 */
	public function get_forumlist_topic_prefixes($event)
	{
		$this->fix_last_post_topic_id($event);

		if ($this->manager->get_on_index_enabled($event))
		{
			$forum_row = $event['forum_row'];
			$forum_row['TOPIC_PREFIX'] = $this->load_prefixes_topic($event, 'row', '', true, 'prefix');

			// Same reasoning as the topic list: no hook sits next to the
			// title here either, and this one runs after phpBB's own
			// truncation, so the suffix never gets cut off mid-tag.
			$suffix = $this->load_prefixes_topic($event, 'row', '', true, 'suffix');
			if ($suffix !== '' && isset($forum_row['LAST_POST_SUBJECT_TRUNCATED']))
			{
				$forum_row['LAST_POST_SUBJECT_TRUNCATED'] = $forum_row['LAST_POST_SUBJECT_TRUNCATED'] . ' ' . $suffix;
			}

			$event['forum_row'] = $forum_row;
		}
	}

	/**
	 * phpBB bubbles a subforum's own last post up onto its parent forum row
	 * (see display_forums() in includes/functions_display.php), but that
	 * bubbling only copies the core fields it knows about
	 * (forum_last_post_id, forum_last_post_subject, ...) - never the
	 * forum_last_post_topic_id this extension used to add with its own JOIN.
	 * So whenever the last post shown for a forum actually happened in one of
	 * its subforums, that field kept naming the parent forum's own (wrong or
	 * empty) last topic, and no prefix/suffix ever matched it - the title
	 * still showed correctly because phpBB resolves that part separately.
	 *
	 * Fixed by re-resolving the topic ID here from forum_last_post_id, which
	 * IS correctly bubbled by the time this event fires, instead of trusting
	 * the stale field.
	 *
	 * @param Event $event Event object
	 * @return null
	 */
	private function fix_last_post_topic_id($event)
	{
		$row = $event['row'];
		if (empty($row['forum_last_post_id']))
		{
			return;
		}

		$post_id = (int) $row['forum_last_post_id'];
		if (!isset($this->last_post_topic_ids[$post_id]))
		{
			$sql = 'SELECT topic_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id;
			$result = $this->db->sql_query($sql);
			$this->last_post_topic_ids[$post_id] = (int) $this->db->sql_fetchfield('topic_id');
			$this->db->sql_freeresult($result);
		}

		$row['forum_last_post_topic_id'] = $this->last_post_topic_ids[$post_id];
		$event['row'] = $row;
	}

	/**
	 * Functions to show approved topics with the given prefix in viewforum
	 */
	public function prefilter_viewforum_by_prefix($event)
	{
		$this->active_prefix_ids = $this->manager->get_active_prefix_ids();

		if (empty($this->active_prefix_ids))
		{
			return;
		}

		$exists_clause = $this->manager->build_prefix_filter_exists_clause($this->active_prefix_ids);
		$sql_where = 't.topic_visibility = ' . ITEM_APPROVED . " AND $exists_clause";

		$sql_ary = $event['sql_array'];
		if (!empty($sql_ary['WHERE'])) {
			$sql_ary['WHERE'] .= " AND $sql_where";
		}
		else {
			$sql_ary['WHERE'] = $sql_where;
		}

		// reset topic count - an EXISTS is self-contained, so unlike the old
		// prefix = N condition, this needs no join alias in FROM at all.
		$cnt_ary = $sql_ary;
		$cnt_ary['SELECT'] = 'COUNT(topic_id) AS cnt';
		$cnt_ary['WHERE'] .= " AND t.forum_id = {$event['forum_id']}";
		$sql = $this->db->sql_build_query('SELECT', $cnt_ary);

		$result = $this->db->sql_query($sql);
		$event['topics_count'] = (int) $this->db->sql_fetchfield('cnt');
		$this->db->sql_freeresult($result);

		$event['sql_array'] = $sql_ary;

		$this->assign_active_filter_chips();
	}

	public function hack_out_announcements($event)
	{
		if (!empty($this->active_prefix_ids))
		{
			// remove announcements from display (a necessary hack)
			$sql_ary = $event['sql_ary'];
			$sql_ary['SELECT'] = 't.topic_id';
			$sql_ary['FROM'] = [TOPICS_TABLE => 't'];
			$sql_ary['WHERE'] = '1 = 0';
			unset($sql_ary['LEFT_JOIN'], $sql_ary['ORDER_BY']);
			$event['sql_ary'] = $sql_ary;
		}
	}

	public function filter_viewforum_by_prefix($event)
	{
		if (!empty($this->active_prefix_ids))
		{
			// disable sorting (a necessary hack)
			$this->container->get('template')->assign_var('S_SELECT_SORT_DAYS', false);

			// approved topics only (a necessary hack)
			$exists_clause = $this->manager->build_prefix_filter_exists_clause($this->active_prefix_ids);
			$sql_ary = $event['sql_ary'];
			$sql_ary['WHERE'] .= ' AND t.topic_visibility = ' . ITEM_APPROVED . " AND $exists_clause";
			$event['sql_ary'] = $sql_ary;
		}
	}

	public function fix_viewforum_base_url($event)
	{
		if (!empty($this->active_prefix_ids))
		{
			// add the active prefixes to the query string in pagination
			$url = $event['base_url'];
			$delim = strpos($url, '?') ? '&amp;' : '?';
			foreach ($this->active_prefix_ids as $prefix_id)
			{
				$url .= "{$delim}prefix[]={$prefix_id}";
				$delim = '&amp;';
			}
			$event['base_url'] = $url;
		}
	}

	/**
	 * Assign a chip per active prefix filter, each linking back to the same
	 * viewforum with just that one prefix removed from the filter - the
	 * "currently filtering by" bar shown above the topic list.
	 *
	 * @return null
	 */
	private function assign_active_filter_chips()
	{
		$forum_id = $this->request->variable('f', 0);

		foreach ($this->active_prefix_ids as $prefix_id)
		{
			$remaining = array_values(array_diff($this->active_prefix_ids, [$prefix_id]));
			$remove_url = $this->manager->build_viewforum_url($forum_id, $remaining);

			$this->manager->get_prefix($prefix_id)->parse('bbprefix_active_filter', ['URL' => $remove_url]);
		}
	}

	/**
	 * Helper method that gets the topic prefixes for view(forum/topic) page
	 *
	 * @param Event $event Event object
	 * @param string $array_name Name of the array that contains the topic_id
	 * @param string $block The name of the template block
	 * @param bool $return_parsed
	 * @param string|null $type 'prefix', 'suffix', or null for both
	 * @return string Plaintext string of topic prefixes
	 */
	protected function load_prefixes_topic($event, $array_name = 'row', $block = 'prefix', $return_parsed = false, $type = null)
	{
		$topic_id = 0;
		if (isset($event[$array_name]['topic_id']))
		{
			$topic_id = (int) $event[$array_name]['topic_id'];
		}
		else if (isset($event[$array_name]['forum_last_post_topic_id']))
		{
			$topic_id = (int) $event[$array_name]['forum_last_post_topic_id'];
		}

		return $topic_id && $this->manager->count_prefixes() && $this->manager->count_prefix_instances()
			? $this->manager->load_prefixes_topic($topic_id, $block, $return_parsed, 0, $type)
			: ''
		;
	}
}
