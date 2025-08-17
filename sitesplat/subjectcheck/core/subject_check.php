<?php
/**
 *
 * Subject Check. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\subjectcheck\core;

class subject_check
{
	protected $request;
	protected $config;
	protected $user;
	protected $auth;
	protected $db;
	protected $root_path;
	protected $php_ext;
	protected $topics_table;
	protected $forums_table;
	private $fulltext_native;
	private $is_using_fulltext_native;
	public function __construct(\phpbb\request\request $request, \phpbb\config\config $config, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $root_path, $php_ext, $topics_table, $forums_table)
	{
		$this->request = $request;
		$this->config = $config;
		$this->user = $user;
		$this->auth = $auth;
		$this->db = $db;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->topics_table = $topics_table;
		$this->forums_table = $forums_table;

		$this->fulltext_native = new fulltext_native_cleanup($root_path, $php_ext);
		$this->is_using_fulltext_native = strcmp($config['search_type'], '\phpbb\search\fulltext_native') === 0 ? true : false;
	}

	public function look_for_posts(&$event)
	{
		// init variables
		$subject = $event['post_data']['post_subject'];
		$checked = $this->request->variable('subject_checked', '');
		$bypass = $this->request->variable('subject_check_bypass', (int) $this->config['subject_check_bypass']);
		$topics = array();

		// Do we even need to be here?
		if (!$this->config['subject_check_enable'] ||
			($event['post_data']['forum_subject_check'] == 0) ||
			$event['mode'] != 'post' ||
			empty($subject) ||
			($bypass && $subject === $checked) ||
			($this->config['subject_check_admin'] && $this->auth->acl_get('a_')) ||
			($this->config['subject_check_mod'] && $this->auth->acl_get('m_')) ||
			($this->config['subject_check_postcount'] != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
		)
		{
			$bypass = true;
			return array($subject, $bypass);
		}

		$bypass = true; // This will be set to false later if the situation calls for it.

		// prepare SQL statements
		$sql_select	= ' t.topic_id, t.topic_title, t.forum_id' . ($this->config['subject_check_fnames'] ? ', f.forum_name' : '');
		$sql_tables	= $this->topics_table . ' t' . ($this->config['subject_check_fnames'] ? ', ' . $this->forums_table . ' f' : '');
		$sql_forum	= ($this->config['subject_check_forums'] ? '' : ' AND t.forum_id = ' . $event['forum_id']) . ($this->config['subject_check_fnames'] ? ' AND f.forum_id = t.forum_id' : '');
		$sql_locked	= $this->config['subject_check_locked'] ? '' : ' AND t.topic_status <> ' . ITEM_LOCKED;
		$sql_active	= $this->config['subject_check_active'] ? ' AND t.topic_last_post_time > ' . (time() - ($this->config['subject_check_active'] * 86400)) : ''; // 86400 = 60 * 60 * 24
		$sql_shadow	= ' AND t.topic_status <> ' . ITEM_MOVED;
		$sql_order	= ' ORDER BY t.topic_id DESC';

		if ($this->config['subject_check_strict']) // Check for exact subject matches
		{
			$sql = 'SELECT' . $sql_select
				. '	FROM ' . $sql_tables
				. '	WHERE t.topic_title = \'' . $this->db->sql_escape($subject) . '\''
				. 		$sql_forum
				. 		$sql_locked
				.		$sql_shadow
				. 		$sql_active
				.	$sql_order
			;
			$result = $this->db->sql_query_limit($sql, $this->config['subject_check_limit']);
			while (($row = $this->db->sql_fetchrow($result)))
			{
				if ($this->config['subject_check_forums'] && !$this->auth->acl_get('f_read', $row['forum_id'])) // Skip topics in forums that the user cannot see
				{
					continue;
				}
				$topics[$row['topic_id']] = array(	// Sorted by topic_id
					'topic_id'		=> $row['topic_id'],
					'forum_name' 	=> isset($row['forum_name']) ? $row['forum_name'] . ': ' : '',
					'topic_title' 	=> $row['topic_title'],
					'match_count'	=> 0,
				);
			}
			$this->db->sql_freeresult();
		}
		else
		{
			// Get searchable words from the post subject
			$search_words = $this->clean_and_split_words($subject);
			$search_words_count = count($search_words);

			// No words to search for
			if (empty($search_words_count))
			{
				return array($subject, $bypass);
			}

			// Now search for existing topics with subjects containing those words
			if ($this->is_using_fulltext_native)
			{
				$sql = 'SELECT DISTINCT' . $sql_select
					 . '	FROM ' . SEARCH_WORDLIST_TABLE . ' w, ' . SEARCH_WORDMATCH_TABLE . ' m, ' . $sql_tables
					 . '	WHERE (' . $this->db->sql_in_set('w.word_text', $search_words)
					 . '		AND m.word_id = w.word_id'
					 . '		AND m.title_match = 1'
					 . '		AND m.post_id = t.topic_first_post_id'
					 . '		AND w.word_common <> 1'
					 .			$sql_forum
					 .			$sql_locked
					 .			$sql_shadow
					 .			$sql_active
					 . '	)'
				     .		$sql_order
				;
			}
			else
			{
				$sql_wordlist_array = array();
				foreach ($search_words as $word)
				{
					$sql_wordlist_array[] = 't.topic_title LIKE \'%' . $this->db->sql_escape($word) . '%\'';
				}
				$sql_wordlist = implode(' OR ', $sql_wordlist_array) . ' ';
				unset($sql_wordlist_array);
				$sql = 'SELECT ' . $sql_select
				     . '	FROM ' . $sql_tables
				     . '	WHERE (' . $sql_wordlist . ') '
					 .			$sql_forum
					 .			$sql_locked
					 .			$sql_shadow
					 .			$sql_active
				     .		$sql_order
				;
			}
			$result = $this->db->sql_query_limit($sql, $this->config['subject_check_limit']);
			while (($row = $this->db->sql_fetchrow($result)))
			{
				if ($this->config['subject_check_forums'] && !$this->auth->acl_get('f_read', $row['forum_id'])) // Skip topics in forums that the user cannot see
				{
					continue;
				}
				$title_words = $this->clean_and_split_words($row['topic_title']);
				$matched_words = array_intersect($search_words, $title_words);
				$matched_count = count($matched_words);
				$topics[$row['topic_id']] = array(
					'topic_id'		=> $row['topic_id'],
					'forum_name' 	=> isset($row['forum_name']) ? $row['forum_name'] . ': ' : '',
					'topic_title' 	=> $row['topic_title'],
					'match_count'	=> $matched_count,
				);
			}
			$this->db->sql_freeresult();
		}

		// We have found similar topic titles
		if (!empty($topics))
		{
			// Sort by number of matched words, then by topic_id
			$topic_ids = array();
			$matches = array();
			foreach ($topics as $key => $row)
			{
				$topic_ids[$key] = $row['topic_id'];
				$matches[$key] = $row['match_count'];
			}
			array_multisort($matches, SORT_DESC, $topic_ids, SORT_DESC, $topics);

			// Prepare topic list
			$this->user->add_lang_ext('sitesplat/subjectcheck', 'common');
			$message = 'SUBJECT_CHECK_SIMILAR_TOPIC';
			$topic_list = '';
			$count = 0;
			foreach ($topics as $row)
			{
				$topic_id		= $row['topic_id'];
				$forum_name		= $row['forum_name'];
				$topic_title	= $row['topic_title'];

				// Check if we need to prevent the post from being made
				if ($this->config['subject_check_bypass'] == 0 || ($topic_title == $subject && $this->config['subject_check_bypass'] == 2))
				{
					$message = 'SUBJECT_CHECK_STRICT_TOPIC';
					$bypass = false;
				}

				$count += 1;
				$topic_list .= '<a href="' . append_sid($this->root_path . 'viewtopic.' . $this->php_ext . '?t=' . $topic_id) . '" ' . ($this->config['subject_check_pop'] ? ' onclick="this.target=\'_blank\';"' : '') . '>&bull; ' . $forum_name . $topic_title . '</a><br />';

				if (!empty($this->config['subject_check_limit']) && $count >= $this->config['subject_check_limit'])
				{
					break;
				}
			}

			$error = $event['error'];
			$error[] = $this->user->lang($message, $count) . ($this->config['subject_check_pop'] ? $this->user->lang('SUBJECT_CHECK_NEW_WINDOW') : $this->user->lang('SUBJECT_CHECK_SAME_WINDOW')) . '<br />' . $topic_list;
			$event['error'] = $error;
		}

		return array($subject, $bypass);
	}

	protected function clean_and_split_words($entry)
	{
		$entry = ' ' . strip_tags(utf8_case_fold_nfc($entry)) . ' ';

		$entry = $this->fulltext_native->cleanup($entry);

		// Reduce multiple spaces to a single space and split this trimmed string into words.
		$word_list = explode(' ', trim(preg_replace('#\s+#', ' ', $entry)));

		return $word_list;
	}
}
