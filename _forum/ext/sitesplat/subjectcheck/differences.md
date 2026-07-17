Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\subjectcheck/composer.json" "[FORUM_EXT]/sitesplat\\subjectcheck/composer.json"
--- "[ORIGINAL]/sitesplat\\subjectcheck/composer.json"
+++ "[FORUM_EXT]/sitesplat\\subjectcheck/composer.json"
@@ -3,7 +3,7 @@
     "type": "phpbb-extension",
     "description": "When a new topic is attempted, a list of topics with similar subjects will first be displayed along with a message urging the user to see if perhaps this new topic is not needed. Includes AJAX support.",
     "homepage": "https://www.sitesplat.com",
-    "version": "1.0.7",
+    "version": "1.0.6",
     "keywords": ["phpbb", "extension", "BBcore", "BBOOTS", "FLATBOOTS", "sitesplat"],
     "license": "Proprietary/All rights reserved",
     "authors": [
diff --git "[ORIGINAL]/sitesplat\\subjectcheck/core/subject_check.php" "[FORUM_EXT]/sitesplat\\subjectcheck/core/subject_check.php"
--- "[ORIGINAL]/sitesplat\\subjectcheck/core/subject_check.php"
+++ "[FORUM_EXT]/sitesplat\\subjectcheck/core/subject_check.php"
@@ -40,23 +40,187 @@ class subject_check
 		$this->is_using_fulltext_native = strcmp($config['search_type'], '\phpbb\search\fulltext_native') === 0 ? true : false;
 	}
 	
+	public function can_bypass(&$event)
+	{
+		// init variables
+		$subject = $event['post_data']['post_subject'];
+		$checked = $this->request->variable('subject_checked', '', true);
+		$bypass = $this->request->variable('subject_check_bypass', (int) $this->config['subject_check_bypass']);
+		$topics = array();
+		
+		// Do we even need to be here?
+		if (!$this->config['subject_check_enable'] ||
+			($event['post_data']['forum_subject_check'] == 0) ||
+			$event['mode'] != 'post' ||
+			empty($subject) ||
+			($bypass && $subject === $checked) ||
+			($this->config['subject_check_admin'] && $this->auth->acl_get('a_')) ||
+			($this->config['subject_check_mod'] && $this->auth->acl_get('m_')) ||
+			($this->config['subject_check_postcount'] != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
+		)
+		{
+			return true;
+		}
+
+		$bypass = true; // This will be set to false later if the situation calls for it.
+
+		// prepare SQL statements
+		$sql_select	= ' t.topic_id, t.topic_title, t.forum_id' . ($this->config['subject_check_fnames'] ? ', f.forum_name' : '');
+		$sql_tables	= $this->topics_table . ' t' . ($this->config['subject_check_fnames'] ? ', ' . $this->forums_table . ' f' : '');
+		$sql_forum	= ($this->config['subject_check_forums'] ? '' : ' AND t.forum_id = ' . $event['forum_id']) . ($this->config['subject_check_fnames'] ? ' AND f.forum_id = t.forum_id' : '');
+		$sql_locked	= $this->config['subject_check_locked'] ? '' : ' AND t.topic_status <> ' . ITEM_LOCKED;
+		$sql_active	= $this->config['subject_check_active'] ? ' AND t.topic_last_post_time > ' . (time() - ($this->config['subject_check_active'] * 86400)) : ''; // 86400 = 60 * 60 * 24
+		$sql_shadow	= ' AND t.topic_status <> ' . ITEM_MOVED;
+		$sql_order	= ' ORDER BY t.topic_id DESC';
+
+		if ($subject === $checked) // Check for exact subject matches
+		{
+			$sql = 'SELECT' . $sql_select
+				. '	FROM ' . $sql_tables
+				. '	WHERE t.topic_title LIKE \'%' . $this->db->sql_escape($subject) . '%\''
+				. 		$sql_forum
+				. 		$sql_locked
+				.		$sql_shadow
+				. 		$sql_active
+				.	$sql_order
+			;
+			$result = $this->db->sql_query_limit($sql, $this->config['subject_check_limit']);
+			while (($row = $this->db->sql_fetchrow($result)))
+			{
+				if ($this->config['subject_check_forums'] && !$this->auth->acl_get('f_read', $row['forum_id'])) // Skip topics in forums that the user cannot see
+				{
+					continue;
+				}
+				$topics[$row['topic_id']] = array(	// Sorted by topic_id
+					'topic_id'		=> $row['topic_id'],
+					'forum_name' 	=> isset($row['forum_name']) ? $row['forum_name'] . ': ' : '',
+					'topic_title' 	=> $row['topic_title'],
+					'match_count'	=> 0,
+				);
+			}
+			$this->db->sql_freeresult();
+		}
+		else
+		{
+			// Get searchable words from the post subject
+			$search_words = $this->clean_and_split_words($subject);
+			$search_words_count = count($search_words);
+
+			// No words to search for
+			if (empty($search_words_count))
+			{
+				return $bypass;
+			}
+
+			// Now search for existing topics with subjects containing those words
+			// Leinad4Mind - Negar pois apesar de estar a usar native a pesquisa mysql aqui é mais rápida
+			if (!$this->is_using_fulltext_native)
+			{
+				$sql = 'SELECT DISTINCT' . $sql_select
+					 . '	FROM ' . SEARCH_WORDLIST_TABLE . ' w, ' . SEARCH_WORDMATCH_TABLE . ' m, ' . $sql_tables
+					 . '	WHERE (' . $this->db->sql_in_set('w.word_text', $search_words)
+					 . '		AND m.word_id = w.word_id'
+					 . '		AND m.title_match = 1'
+					 . '		AND m.post_id = t.topic_first_post_id'
+					 . '		AND w.word_common <> 1'
+					 .			$sql_forum
+					 .			$sql_locked
+					 .			$sql_shadow
+					 .			$sql_active
+					 . '	)'
+				     .		$sql_order
+				;
+			}
+			else
+			{
+				$sql_wordlist_array = array();
+				foreach ($search_words as $word)
+				{
+					$sql_wordlist_array[] = 't.topic_title LIKE \'%' . $this->db->sql_escape($word) . '%\'';
+				}
+
+				$sql_wordlist = implode(' AND ', $sql_wordlist_array) . ' ';
+				unset($sql_wordlist_array);
+				$sql = 'SELECT ' . $sql_select
+				     . '	FROM ' . $sql_tables
+				     . '	WHERE (' . $sql_wordlist . ') '
+					 .			$sql_forum
+					 .			$sql_locked
+					 .			$sql_shadow
+					 .			$sql_active
+				     .		$sql_order
+				;
+			}
+			$result = $this->db->sql_query_limit($sql, $this->config['subject_check_limit']);
+			while (($row = $this->db->sql_fetchrow($result)))
+			{
+				if ($this->config['subject_check_forums'] && !$this->auth->acl_get('f_read', $row['forum_id'])) // Skip topics in forums that the user cannot see
+				{
+					continue;
+				}
+				$title_words = $this->clean_and_split_words($row['topic_title']);
+				$matched_words = array_intersect($search_words, $title_words);
+				$matched_count = count($matched_words);
+				$topics[$row['topic_id']] = array(
+					'topic_id'		=> $row['topic_id'],
+					'forum_name' 	=> isset($row['forum_name']) ? $row['forum_name'] . ': ' : '',
+					'topic_title' 	=> $row['topic_title'],
+					'match_count'	=> $matched_count,
+				);
+			}
+			$this->db->sql_freeresult();
+		}
+
+		// We have found similar topic titles
+		if (!empty($topics))
+		{
+			// Sort by number of matched words, then by topic_id
+			$topic_ids = array();
+			$matches = array();
+			foreach ($topics as $key => $row)
+			{
+				$topic_ids[$key] = $row['topic_id'];
+				$matches[$key] = $row['match_count'];
+			}
+			array_multisort($matches, SORT_DESC, $topic_ids, SORT_DESC, $topics);
+
+			// Prepare topic list
+			$topic_list = '';
+
+			foreach ($topics as $row)
+			{
+				$topic_id		= $row['topic_id'];
+				$forum_name		= $row['forum_name'];
+				$topic_title	= $row['topic_title'];
+
+				// Check if we need to prevent the post from being made
+				if ($topic_title == $subject)
+				{
+					$bypass = false;
+				}
+			}
+		}
+
+		return $bypass;
+	}
+
 	public function look_for_posts(&$event)
 	{
 		// init variables
 		$subject = $event['post_data']['post_subject'];
-		$checked = $this->request->variable('subject_checked', '');
+		$checked = $this->request->variable('subject_checked', '', true);
 		$bypass = $this->request->variable('subject_check_bypass', (int) $this->config['subject_check_bypass']);
 		$topics = array();
 		
 		// Do we even need to be here?
-		if (empty($this->config['subject_check_enable']) ||
-			empty($event['post_data']['forum_subject_check']) ||
+		if (!$this->config['subject_check_enable'] ||
+			($event['post_data']['forum_subject_check'] == 0) ||
 			$event['mode'] != 'post' ||
 			empty($subject) ||
 			($bypass && $subject === $checked) ||
 			($this->config['subject_check_admin'] && $this->auth->acl_get('a_')) ||
 			($this->config['subject_check_mod'] && $this->auth->acl_get('m_')) ||
-			(intval($this->config['subject_check_postcount']) != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
+			($this->config['subject_check_postcount'] != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
 		)
 		{
 			$bypass = true;
@@ -74,11 +238,11 @@ class subject_check
 		$sql_shadow	= ' AND t.topic_status <> ' . ITEM_MOVED;
 		$sql_order	= ' ORDER BY t.topic_id DESC';
 
-		if ($this->config['subject_check_strict']) // Check for exact subject matches
+		if ($this->config['subject_check_strict'] || ($subject === $checked && $this->config['subject_check_bypass'] == 2)) // Check for exact subject matches
 		{
 			$sql = 'SELECT' . $sql_select
 				. '	FROM ' . $sql_tables
-				. '	WHERE t.topic_title = \'' . $this->db->sql_escape($subject) . '\''
+				. '	WHERE t.topic_title LIKE \'%' . $this->db->sql_escape($this->clean_words($subject)) . '%\''
 				. 		$sql_forum
 				. 		$sql_locked
 				.		$sql_shadow
@@ -114,7 +278,8 @@ class subject_check
 			}
 
 			// Now search for existing topics with subjects containing those words
-			if ($this->is_using_fulltext_native)
+			//Leinad4Mind - Negar pois apesar de estar a usar native a pesquisa mysql aqui é mais rápida
+			if (!$this->is_using_fulltext_native)
 			{
 				$sql = 'SELECT DISTINCT' . $sql_select
 					 . '	FROM ' . SEARCH_WORDLIST_TABLE . ' w, ' . SEARCH_WORDMATCH_TABLE . ' m, ' . $sql_tables
@@ -138,7 +303,8 @@ class subject_check
 				{
 					$sql_wordlist_array[] = 't.topic_title LIKE \'%' . $this->db->sql_escape($word) . '%\'';
 				}
-				$sql_wordlist = implode(' OR ', $sql_wordlist_array) . ' ';
+
+				$sql_wordlist = implode(' AND ', $sql_wordlist_array) . ' ';
 				unset($sql_wordlist_array);
 				$sql = 'SELECT ' . $sql_select
 				     . '	FROM ' . $sql_tables
@@ -188,6 +354,8 @@ class subject_check
 			$message = 'SUBJECT_CHECK_SIMILAR_TOPIC';
 			$topic_list = '';
 			$count = 0;
+			$count_exact = 0;
+
 			foreach ($topics as $row)
 			{
 				$topic_id		= $row['topic_id'];
@@ -195,14 +363,22 @@ class subject_check
 				$topic_title	= $row['topic_title'];
 
 				// Check if we need to prevent the post from being made
-				if ($this->config['subject_check_bypass'] == 0 || ($topic_title == $subject && $this->config['subject_check_bypass'] == 2))
+				if ($topic_title == $subject && $this->config['subject_check_bypass'] == 2)
 				{
-					$message = 'SUBJECT_CHECK_STRICT_TOPIC';
+					$message = 'SUBJECT_CHECK_EXACT_TOPIC';
 					$bypass = false;
+					$count_exact += 1;
+				}
+				if($this->config['subject_check_bypass'] == 0) {
+					$bypass = false;
+				}
+				if ($this->config['subject_check_strict'])
+				{
+					$message = 'SUBJECT_CHECK_STRICT_TOPIC';
 				}
 
 				$count += 1;
-				$topic_list .= '<a href="' . append_sid(generate_board_url() . '/viewtopic.php', "t={$topic_id}") . '" ' . ($this->config['subject_check_pop'] ? ' onclick="this.target=\'_blank\';"' : '') . '>&bull; ' . $forum_name . $topic_title . '</a>';
+				$topic_list .= '<a href="' . append_sid(generate_board_url() . '/viewtopic.' . $this->php_ext . '?t=' . $topic_id) . '" ' . ($this->config['subject_check_pop'] ? ' onclick="this.target=\'_blank\';"' : '') . '>&bull; ' . $forum_name . $topic_title . '</a>';
 				if ($this->ext_manager->is_enabled('sitesplat/bbtpreview'))
 				{
 					$topic_list .= '<a data-toggle="modal" data-id="' . $topic_id . '" href="#BBTPreviewDialog" class="btn btn-xs open-bbtpreview hidden-xs" title=""><i class="fa fa-search-plus"></i></a><span class="visible-xs"><a data-toggle="modal" data-id="' . $topic_id . '" href="#BBTPreviewDialog" class="btn-xs open-bbtpreview" title="">' . $this->user->lang('PREVIEW') . '</a></span>';
@@ -215,6 +391,10 @@ class subject_check
 				}
 			}
 
+			if ($message == 'SUBJECT_CHECK_EXACT_TOPIC') {
+				$count = $count_exact;
+			}
+
 			$error = $event['error'];
 			$error[] = $this->user->lang($message, $count) . ($this->config['subject_check_pop'] ? $this->user->lang('SUBJECT_CHECK_NEW_WINDOW') : $this->user->lang('SUBJECT_CHECK_SAME_WINDOW')) . '<br />' . $topic_list;
 			$event['error'] = $error;
@@ -227,6 +407,10 @@ class subject_check
 	{
 		$entry = ' ' . strip_tags(utf8_case_fold_nfc($entry)) . ' ';
 
+		// Remove text between colons, including the colons themselves.
+		$entry = preg_replace('/:\S+:/u', ' ', $entry);
+		$entry = preg_replace('/\[(.*?)\]|\((.*?)\)/', ' ', $entry);
+
 		$entry = $this->fulltext_native->cleanup($entry);
 
 		// Reduce multiple spaces to a single space and split this trimmed string into words.
@@ -234,4 +418,20 @@ class subject_check
 
 		return $word_list;
 	}
+
+	protected function clean_words($entry)
+	{
+		$entry = ' ' . strip_tags(utf8_case_fold_nfc($entry)) . ' ';
+
+		// Remove text between colons, including the colons themselves.
+		$entry = preg_replace('/:\S+:/u', ' ', $entry);
+		$entry = preg_replace('/\[(.*?)\]|\((.*?)\)/', ' ', $entry);
+
+		$entry = $this->fulltext_native->cleanup($entry);
+
+		// Reduce multiple spaces to a single space and split this trimmed string into words.
+		$entry = trim(preg_replace('#\s+#', ' ', $entry));
+
+		return $entry;
+	}
 }
diff --git "[FORUM_EXT]/sitesplat\\subjectcheck/diff_full.tmp" "[FORUM_EXT]/sitesplat\\subjectcheck/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\subjectcheck/diff_full.tmp"
@@ -0,0 +1,707 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/composer.json"
+index 243604803..8b6af7ee3 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/composer.json"
+@@ -3,7 +3,7 @@
+     "type": "phpbb-extension",
+     "description": "When a new topic is attempted, a list of topics with similar subjects will first be displayed along with a message urging the user to see if perhaps this new topic is not needed. Includes AJAX support.",
+     "homepage": "https://www.sitesplat.com",
+-    "version": "1.0.7",
++    "version": "1.0.6",
+     "keywords": ["phpbb", "extension", "BBcore", "BBOOTS", "FLATBOOTS", "sitesplat"],
+     "license": "Proprietary/All rights reserved",
+     "authors": [
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/core/subject_check.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/core/subject_check.php"
+index e716716ee..461d3529a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/core/subject_check.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/core/subject_check.php"
+@@ -39,24 +39,188 @@ class subject_check
+ 		$this->fulltext_native = new fulltext_native_cleanup($root_path, $php_ext);
+ 		$this->is_using_fulltext_native = strcmp($config['search_type'], '\phpbb\search\fulltext_native') === 0 ? true : false;
+ 	}
++	
++	public function can_bypass(&$event)
++	{
++		// init variables
++		$subject = $event['post_data']['post_subject'];
++		$checked = $this->request->variable('subject_checked', '', true);
++		$bypass = $this->request->variable('subject_check_bypass', (int) $this->config['subject_check_bypass']);
++		$topics = array();
++		
++		// Do we even need to be here?
++		if (!$this->config['subject_check_enable'] ||
++			($event['post_data']['forum_subject_check'] == 0) ||
++			$event['mode'] != 'post' ||
++			empty($subject) ||
++			($bypass && $subject === $checked) ||
++			($this->config['subject_check_admin'] && $this->auth->acl_get('a_')) ||
++			($this->config['subject_check_mod'] && $this->auth->acl_get('m_')) ||
++			($this->config['subject_check_postcount'] != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
++		)
++		{
++			return true;
++		}
++
++		$bypass = true; // This will be set to false later if the situation calls for it.
++
++		// prepare SQL statements
++		$sql_select	= ' t.topic_id, t.topic_title, t.forum_id' . ($this->config['subject_check_fnames'] ? ', f.forum_name' : '');
++		$sql_tables	= $this->topics_table . ' t' . ($this->config['subject_check_fnames'] ? ', ' . $this->forums_table . ' f' : '');
++		$sql_forum	= ($this->config['subject_check_forums'] ? '' : ' AND t.forum_id = ' . $event['forum_id']) . ($this->config['subject_check_fnames'] ? ' AND f.forum_id = t.forum_id' : '');
++		$sql_locked	= $this->config['subject_check_locked'] ? '' : ' AND t.topic_status <> ' . ITEM_LOCKED;
++		$sql_active	= $this->config['subject_check_active'] ? ' AND t.topic_last_post_time > ' . (time() - ($this->config['subject_check_active'] * 86400)) : ''; // 86400 = 60 * 60 * 24
++		$sql_shadow	= ' AND t.topic_status <> ' . ITEM_MOVED;
++		$sql_order	= ' ORDER BY t.topic_id DESC';
++
++		if ($subject === $checked) // Check for exact subject matches
++		{
++			$sql = 'SELECT' . $sql_select
++				. '	FROM ' . $sql_tables
++				. '	WHERE t.topic_title LIKE \'%' . $this->db->sql_escape($subject) . '%\''
++				. 		$sql_forum
++				. 		$sql_locked
++				.		$sql_shadow
++				. 		$sql_active
++				.	$sql_order
++			;
++			$result = $this->db->sql_query_limit($sql, $this->config['subject_check_limit']);
++			while (($row = $this->db->sql_fetchrow($result)))
++			{
++				if ($this->config['subject_check_forums'] && !$this->auth->acl_get('f_read', $row['forum_id'])) // Skip topics in forums that the user cannot see
++				{
++					continue;
++				}
++				$topics[$row['topic_id']] = array(	// Sorted by topic_id
++					'topic_id'		=> $row['topic_id'],
++					'forum_name' 	=> isset($row['forum_name']) ? $row['forum_name'] . ': ' : '',
++					'topic_title' 	=> $row['topic_title'],
++					'match_count'	=> 0,
++				);
++			}
++			$this->db->sql_freeresult();
++		}
++		else
++		{
++			// Get searchable words from the post subject
++			$search_words = $this->clean_and_split_words($subject);
++			$search_words_count = count($search_words);
++
++			// No words to search for
++			if (empty($search_words_count))
++			{
++				return $bypass;
++			}
++
++			// Now search for existing topics with subjects containing those words
++			// Leinad4Mind - Negar pois apesar de estar a usar native a pesquisa mysql aqui é mais rápida
++			if (!$this->is_using_fulltext_native)
++			{
++				$sql = 'SELECT DISTINCT' . $sql_select
++					 . '	FROM ' . SEARCH_WORDLIST_TABLE . ' w, ' . SEARCH_WORDMATCH_TABLE . ' m, ' . $sql_tables
++					 . '	WHERE (' . $this->db->sql_in_set('w.word_text', $search_words)
++					 . '		AND m.word_id = w.word_id'
++					 . '		AND m.title_match = 1'
++					 . '		AND m.post_id = t.topic_first_post_id'
++					 . '		AND w.word_common <> 1'
++					 .			$sql_forum
++					 .			$sql_locked
++					 .			$sql_shadow
++					 .			$sql_active
++					 . '	)'
++				     .		$sql_order
++				;
++			}
++			else
++			{
++				$sql_wordlist_array = array();
++				foreach ($search_words as $word)
++				{
++					$sql_wordlist_array[] = 't.topic_title LIKE \'%' . $this->db->sql_escape($word) . '%\'';
++				}
++
++				$sql_wordlist = implode(' AND ', $sql_wordlist_array) . ' ';
++				unset($sql_wordlist_array);
++				$sql = 'SELECT ' . $sql_select
++				     . '	FROM ' . $sql_tables
++				     . '	WHERE (' . $sql_wordlist . ') '
++					 .			$sql_forum
++					 .			$sql_locked
++					 .			$sql_shadow
++					 .			$sql_active
++				     .		$sql_order
++				;
++			}
++			$result = $this->db->sql_query_limit($sql, $this->config['subject_check_limit']);
++			while (($row = $this->db->sql_fetchrow($result)))
++			{
++				if ($this->config['subject_check_forums'] && !$this->auth->acl_get('f_read', $row['forum_id'])) // Skip topics in forums that the user cannot see
++				{
++					continue;
++				}
++				$title_words = $this->clean_and_split_words($row['topic_title']);
++				$matched_words = array_intersect($search_words, $title_words);
++				$matched_count = count($matched_words);
++				$topics[$row['topic_id']] = array(
++					'topic_id'		=> $row['topic_id'],
++					'forum_name' 	=> isset($row['forum_name']) ? $row['forum_name'] . ': ' : '',
++					'topic_title' 	=> $row['topic_title'],
++					'match_count'	=> $matched_count,
++				);
++			}
++			$this->db->sql_freeresult();
++		}
++
++		// We have found similar topic titles
++		if (!empty($topics))
++		{
++			// Sort by number of matched words, then by topic_id
++			$topic_ids = array();
++			$matches = array();
++			foreach ($topics as $key => $row)
++			{
++				$topic_ids[$key] = $row['topic_id'];
++				$matches[$key] = $row['match_count'];
++			}
++			array_multisort($matches, SORT_DESC, $topic_ids, SORT_DESC, $topics);
++
++			// Prepare topic list
++			$topic_list = '';
++
++			foreach ($topics as $row)
++			{
++				$topic_id		= $row['topic_id'];
++				$forum_name		= $row['forum_name'];
++				$topic_title	= $row['topic_title'];
++
++				// Check if we need to prevent the post from being made
++				if ($topic_title == $subject)
++				{
++					$bypass = false;
++				}
++			}
++		}
++
++		return $bypass;
++	}
+ 
+ 	public function look_for_posts(&$event)
+ 	{
+ 		// init variables
+ 		$subject = $event['post_data']['post_subject'];
+-		$checked = $this->request->variable('subject_checked', '');
++		$checked = $this->request->variable('subject_checked', '', true);
+ 		$bypass = $this->request->variable('subject_check_bypass', (int) $this->config['subject_check_bypass']);
+ 		$topics = array();
+-
++		
+ 		// Do we even need to be here?
+-		if (empty($this->config['subject_check_enable']) ||
+-			empty($event['post_data']['forum_subject_check']) ||
++		if (!$this->config['subject_check_enable'] ||
++			($event['post_data']['forum_subject_check'] == 0) ||
+ 			$event['mode'] != 'post' ||
+ 			empty($subject) ||
+ 			($bypass && $subject === $checked) ||
+ 			($this->config['subject_check_admin'] && $this->auth->acl_get('a_')) ||
+ 			($this->config['subject_check_mod'] && $this->auth->acl_get('m_')) ||
+-			(intval($this->config['subject_check_postcount']) != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
++			($this->config['subject_check_postcount'] != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
+ 		)
+ 		{
+ 			$bypass = true;
+@@ -74,11 +238,11 @@ class subject_check
+ 		$sql_shadow	= ' AND t.topic_status <> ' . ITEM_MOVED;
+ 		$sql_order	= ' ORDER BY t.topic_id DESC';
+ 
+-		if ($this->config['subject_check_strict']) // Check for exact subject matches
++		if ($this->config['subject_check_strict'] || ($subject === $checked && $this->config['subject_check_bypass'] == 2)) // Check for exact subject matches
+ 		{
+ 			$sql = 'SELECT' . $sql_select
+ 				. '	FROM ' . $sql_tables
+-				. '	WHERE t.topic_title = \'' . $this->db->sql_escape($subject) . '\''
++				. '	WHERE t.topic_title LIKE \'%' . $this->db->sql_escape($this->clean_words($subject)) . '%\''
+ 				. 		$sql_forum
+ 				. 		$sql_locked
+ 				.		$sql_shadow
+@@ -114,7 +278,8 @@ class subject_check
+ 			}
+ 
+ 			// Now search for existing topics with subjects containing those words
+-			if ($this->is_using_fulltext_native)
++			//Leinad4Mind - Negar pois apesar de estar a usar native a pesquisa mysql aqui é mais rápida
++			if (!$this->is_using_fulltext_native)
+ 			{
+ 				$sql = 'SELECT DISTINCT' . $sql_select
+ 					 . '	FROM ' . SEARCH_WORDLIST_TABLE . ' w, ' . SEARCH_WORDMATCH_TABLE . ' m, ' . $sql_tables
+@@ -138,7 +303,8 @@ class subject_check
+ 				{
+ 					$sql_wordlist_array[] = 't.topic_title LIKE \'%' . $this->db->sql_escape($word) . '%\'';
+ 				}
+-				$sql_wordlist = implode(' OR ', $sql_wordlist_array) . ' ';
++
++				$sql_wordlist = implode(' AND ', $sql_wordlist_array) . ' ';
+ 				unset($sql_wordlist_array);
+ 				$sql = 'SELECT ' . $sql_select
+ 				     . '	FROM ' . $sql_tables
+@@ -188,6 +354,8 @@ class subject_check
+ 			$message = 'SUBJECT_CHECK_SIMILAR_TOPIC';
+ 			$topic_list = '';
+ 			$count = 0;
++			$count_exact = 0;
++
+ 			foreach ($topics as $row)
+ 			{
+ 				$topic_id		= $row['topic_id'];
+@@ -195,14 +363,22 @@ class subject_check
+ 				$topic_title	= $row['topic_title'];
+ 
+ 				// Check if we need to prevent the post from being made
+-				if ($this->config['subject_check_bypass'] == 0 || ($topic_title == $subject && $this->config['subject_check_bypass'] == 2))
++				if ($topic_title == $subject && $this->config['subject_check_bypass'] == 2)
+ 				{
+-					$message = 'SUBJECT_CHECK_STRICT_TOPIC';
++					$message = 'SUBJECT_CHECK_EXACT_TOPIC';
+ 					$bypass = false;
++					$count_exact += 1;
++				}
++				if($this->config['subject_check_bypass'] == 0) {
++					$bypass = false;
++				}
++				if ($this->config['subject_check_strict'])
++				{
++					$message = 'SUBJECT_CHECK_STRICT_TOPIC';
+ 				}
+ 
+ 				$count += 1;
+-				$topic_list .= '<a href="' . append_sid(generate_board_url() . '/viewtopic.php', "t={$topic_id}") . '" ' . ($this->config['subject_check_pop'] ? ' onclick="this.target=\'_blank\';"' : '') . '>&bull; ' . $forum_name . $topic_title . '</a>';
++				$topic_list .= '<a href="' . append_sid(generate_board_url() . '/viewtopic.' . $this->php_ext . '?t=' . $topic_id) . '" ' . ($this->config['subject_check_pop'] ? ' onclick="this.target=\'_blank\';"' : '') . '>&bull; ' . $forum_name . $topic_title . '</a>';
+ 				if ($this->ext_manager->is_enabled('sitesplat/bbtpreview'))
+ 				{
+ 					$topic_list .= '<a data-toggle="modal" data-id="' . $topic_id . '" href="#BBTPreviewDialog" class="btn btn-xs open-bbtpreview hidden-xs" title=""><i class="fa fa-search-plus"></i></a><span class="visible-xs"><a data-toggle="modal" data-id="' . $topic_id . '" href="#BBTPreviewDialog" class="btn-xs open-bbtpreview" title="">' . $this->user->lang('PREVIEW') . '</a></span>';
+@@ -215,6 +391,10 @@ class subject_check
+ 				}
+ 			}
+ 
++			if ($message == 'SUBJECT_CHECK_EXACT_TOPIC') {
++				$count = $count_exact;
++			}
++
+ 			$error = $event['error'];
+ 			$error[] = $this->user->lang($message, $count) . ($this->config['subject_check_pop'] ? $this->user->lang('SUBJECT_CHECK_NEW_WINDOW') : $this->user->lang('SUBJECT_CHECK_SAME_WINDOW')) . '<br />' . $topic_list;
+ 			$event['error'] = $error;
+@@ -227,6 +407,10 @@ class subject_check
+ 	{
+ 		$entry = ' ' . strip_tags(utf8_case_fold_nfc($entry)) . ' ';
+ 
++		// Remove text between colons, including the colons themselves.
++		$entry = preg_replace('/:\S+:/u', ' ', $entry);
++		$entry = preg_replace('/\[(.*?)\]|\((.*?)\)/', ' ', $entry);
++
+ 		$entry = $this->fulltext_native->cleanup($entry);
+ 
+ 		// Reduce multiple spaces to a single space and split this trimmed string into words.
+@@ -234,4 +418,20 @@ class subject_check
+ 
+ 		return $word_list;
+ 	}
++
++	protected function clean_words($entry)
++	{
++		$entry = ' ' . strip_tags(utf8_case_fold_nfc($entry)) . ' ';
++
++		// Remove text between colons, including the colons themselves.
++		$entry = preg_replace('/:\S+:/u', ' ', $entry);
++		$entry = preg_replace('/\[(.*?)\]|\((.*?)\)/', ' ', $entry);
++
++		$entry = $this->fulltext_native->cleanup($entry);
++
++		// Reduce multiple spaces to a single space and split this trimmed string into words.
++		$entry = trim(preg_replace('#\s+#', ' ', $entry));
++
++		return $entry;
++	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/diff_full.tmp"
+new file mode 100644
+index 000000000..4e46f7258
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/diff_full.tmp"
+@@ -0,0 +1,280 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/composer.json"
++index 243604803..8b6af7ee3 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/composer.json"
++@@ -3,7 +3,7 @@
++     "type": "phpbb-extension",
++     "description": "When a new topic is attempted, a list of topics with similar subjects will first be displayed along with a message urging the user to see if perhaps this new topic is not needed. Includes AJAX support.",
++     "homepage": "https://www.sitesplat.com",
++-    "version": "1.0.7",
+++    "version": "1.0.6",
++     "keywords": ["phpbb", "extension", "BBcore", "BBOOTS", "FLATBOOTS", "sitesplat"],
++     "license": "Proprietary/All rights reserved",
++     "authors": [
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/core/subject_check.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/core/subject_check.php"
++index e716716ee..461d3529a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/core/subject_check.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/core/subject_check.php"
++@@ -39,24 +39,188 @@ class subject_check
++ 		$this->fulltext_native = new fulltext_native_cleanup($root_path, $php_ext);
++ 		$this->is_using_fulltext_native = strcmp($config['search_type'], '\phpbb\search\fulltext_native') === 0 ? true : false;
++ 	}
+++	
+++	public function can_bypass(&$event)
+++	{
+++		// init variables
+++		$subject = $event['post_data']['post_subject'];
+++		$checked = $this->request->variable('subject_checked', '', true);
+++		$bypass = $this->request->variable('subject_check_bypass', (int) $this->config['subject_check_bypass']);
+++		$topics = array();
+++		
+++		// Do we even need to be here?
+++		if (!$this->config['subject_check_enable'] ||
+++			($event['post_data']['forum_subject_check'] == 0) ||
+++			$event['mode'] != 'post' ||
+++			empty($subject) ||
+++			($bypass && $subject === $checked) ||
+++			($this->config['subject_check_admin'] && $this->auth->acl_get('a_')) ||
+++			($this->config['subject_check_mod'] && $this->auth->acl_get('m_')) ||
+++			($this->config['subject_check_postcount'] != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
+++		)
+++		{
+++			return true;
+++		}
+++
+++		$bypass = true; // This will be set to false later if the situation calls for it.
+++
+++		// prepare SQL statements
+++		$sql_select	= ' t.topic_id, t.topic_title, t.forum_id' . ($this->config['subject_check_fnames'] ? ', f.forum_name' : '');
+++		$sql_tables	= $this->topics_table . ' t' . ($this->config['subject_check_fnames'] ? ', ' . $this->forums_table . ' f' : '');
+++		$sql_forum	= ($this->config['subject_check_forums'] ? '' : ' AND t.forum_id = ' . $event['forum_id']) . ($this->config['subject_check_fnames'] ? ' AND f.forum_id = t.forum_id' : '');
+++		$sql_locked	= $this->config['subject_check_locked'] ? '' : ' AND t.topic_status <> ' . ITEM_LOCKED;
+++		$sql_active	= $this->config['subject_check_active'] ? ' AND t.topic_last_post_time > ' . (time() - ($this->config['subject_check_active'] * 86400)) : ''; // 86400 = 60 * 60 * 24
+++		$sql_shadow	= ' AND t.topic_status <> ' . ITEM_MOVED;
+++		$sql_order	= ' ORDER BY t.topic_id DESC';
+++
+++		if ($subject === $checked) // Check for exact subject matches
+++		{
+++			$sql = 'SELECT' . $sql_select
+++				. '	FROM ' . $sql_tables
+++				. '	WHERE t.topic_title LIKE \'%' . $this->db->sql_escape($subject) . '%\''
+++				. 		$sql_forum
+++				. 		$sql_locked
+++				.		$sql_shadow
+++				. 		$sql_active
+++				.	$sql_order
+++			;
+++			$result = $this->db->sql_query_limit($sql, $this->config['subject_check_limit']);
+++			while (($row = $this->db->sql_fetchrow($result)))
+++			{
+++				if ($this->config['subject_check_forums'] && !$this->auth->acl_get('f_read', $row['forum_id'])) // Skip topics in forums that the user cannot see
+++				{
+++					continue;
+++				}
+++				$topics[$row['topic_id']] = array(	// Sorted by topic_id
+++					'topic_id'		=> $row['topic_id'],
+++					'forum_name' 	=> isset($row['forum_name']) ? $row['forum_name'] . ': ' : '',
+++					'topic_title' 	=> $row['topic_title'],
+++					'match_count'	=> 0,
+++				);
+++			}
+++			$this->db->sql_freeresult();
+++		}
+++		else
+++		{
+++			// Get searchable words from the post subject
+++			$search_words = $this->clean_and_split_words($subject);
+++			$search_words_count = count($search_words);
+++
+++			// No words to search for
+++			if (empty($search_words_count))
+++			{
+++				return $bypass;
+++			}
+++
+++			// Now search for existing topics with subjects containing those words
+++			// Leinad4Mind - Negar pois apesar de estar a usar native a pesquisa mysql aqui é mais rápida
+++			if (!$this->is_using_fulltext_native)
+++			{
+++				$sql = 'SELECT DISTINCT' . $sql_select
+++					 . '	FROM ' . SEARCH_WORDLIST_TABLE . ' w, ' . SEARCH_WORDMATCH_TABLE . ' m, ' . $sql_tables
+++					 . '	WHERE (' . $this->db->sql_in_set('w.word_text', $search_words)
+++					 . '		AND m.word_id = w.word_id'
+++					 . '		AND m.title_match = 1'
+++					 . '		AND m.post_id = t.topic_first_post_id'
+++					 . '		AND w.word_common <> 1'
+++					 .			$sql_forum
+++					 .			$sql_locked
+++					 .			$sql_shadow
+++					 .			$sql_active
+++					 . '	)'
+++				     .		$sql_order
+++				;
+++			}
+++			else
+++			{
+++				$sql_wordlist_array = array();
+++				foreach ($search_words as $word)
+++				{
+++					$sql_wordlist_array[] = 't.topic_title LIKE \'%' . $this->db->sql_escape($word) . '%\'';
+++				}
+++
+++				$sql_wordlist = implode(' AND ', $sql_wordlist_array) . ' ';
+++				unset($sql_wordlist_array);
+++				$sql = 'SELECT ' . $sql_select
+++				     . '	FROM ' . $sql_tables
+++				     . '	WHERE (' . $sql_wordlist . ') '
+++					 .			$sql_forum
+++					 .			$sql_locked
+++					 .			$sql_shadow
+++					 .			$sql_active
+++				     .		$sql_order
+++				;
+++			}
+++			$result = $this->db->sql_query_limit($sql, $this->config['subject_check_limit']);
+++			while (($row = $this->db->sql_fetchrow($result)))
+++			{
+++				if ($this->config['subject_check_forums'] && !$this->auth->acl_get('f_read', $row['forum_id'])) // Skip topics in forums that the user cannot see
+++				{
+++					continue;
+++				}
+++				$title_words = $this->clean_and_split_words($row['topic_title']);
+++				$matched_words = array_intersect($search_words, $title_words);
+++				$matched_count = count($matched_words);
+++				$topics[$row['topic_id']] = array(
+++					'topic_id'		=> $row['topic_id'],
+++					'forum_name' 	=> isset($row['forum_name']) ? $row['forum_name'] . ': ' : '',
+++					'topic_title' 	=> $row['topic_title'],
+++					'match_count'	=> $matched_count,
+++				);
+++			}
+++			$this->db->sql_freeresult();
+++		}
+++
+++		// We have found similar topic titles
+++		if (!empty($topics))
+++		{
+++			// Sort by number of matched words, then by topic_id
+++			$topic_ids = array();
+++			$matches = array();
+++			foreach ($topics as $key => $row)
+++			{
+++				$topic_ids[$key] = $row['topic_id'];
+++				$matches[$key] = $row['match_count'];
+++			}
+++			array_multisort($matches, SORT_DESC, $topic_ids, SORT_DESC, $topics);
+++
+++			// Prepare topic list
+++			$topic_list = '';
+++
+++			foreach ($topics as $row)
+++			{
+++				$topic_id		= $row['topic_id'];
+++				$forum_name		= $row['forum_name'];
+++				$topic_title	= $row['topic_title'];
+++
+++				// Check if we need to prevent the post from being made
+++				if ($topic_title == $subject)
+++				{
+++					$bypass = false;
+++				}
+++			}
+++		}
+++
+++		return $bypass;
+++	}
++ 
++ 	public function look_for_posts(&$event)
++ 	{
++ 		// init variables
++ 		$subject = $event['post_data']['post_subject'];
++-		$checked = $this->request->variable('subject_checked', '');
+++		$checked = $this->request->variable('subject_checked', '', true);
++ 		$bypass = $this->request->variable('subject_check_bypass', (int) $this->config['subject_check_bypass']);
++ 		$topics = array();
++-
+++		
++ 		// Do we even need to be here?
++-		if (empty($this->config['subject_check_enable']) ||
++-			empty($event['post_data']['forum_subject_check']) ||
+++		if (!$this->config['subject_check_enable'] ||
+++			($event['post_data']['forum_subject_check'] == 0) ||
++ 			$event['mode'] != 'post' ||
++ 			empty($subject) ||
++ 			($bypass && $subject === $checked) ||
++ 			($this->config['subject_check_admin'] && $this->auth->acl_get('a_')) ||
++ 			($this->config['subject_check_mod'] && $this->auth->acl_get('m_')) ||
++-			(intval($this->config['subject_check_postcount']) != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
+++			($this->config['subject_check_postcount'] != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
++ 		)
++ 		{
++ 			$bypass = true;
++@@ -74,11 +238,11 @@ class subject_check
++ 		$sql_shadow	= ' AND t.topic_status <> ' . ITEM_MOVED;
++ 		$sql_order	= ' ORDER BY t.topic_id DESC';
++ 
++-		if ($this->config['subject_check_strict']) // Check for exact subject matches
+++		if ($this->config['subject_check_strict'] || ($subject === $checked && $this->config['subject_check_bypass'] == 2)) // Check for exact subject matches
++ 		{
++ 			$sql = 'SELECT' . $sql_select
++ 				. '	FROM ' . $sql_tables
++-				. '	WHERE t.topic_title = \'' . $this->db->sql_escape($subject) . '\''
+++				. '	WHERE t.topic_title LIKE \'%' . $this->db->sql_escape($this->clean_words($subject)) . '%\''
++ 				. 		$sql_forum
++ 				. 		$sql_locked
++ 				.		$sql_shadow
++@@ -114,7 +278,8 @@ class subject_check
++ 			}
++ 
++ 			// Now search for existing topics with subjects containing those words
++-			if ($this->is_using_fulltext_native)
+++			//Leinad4Mind - Negar pois apesar de estar a usar native a pesquisa mysql aqui é mais rápida
+++			if (!$this->is_using_fulltext_native)
++ 			{
++ 				$sql = 'SELECT DISTINCT' . $sql_select
++ 					 . '	FROM ' . SEARCH_WORDLIST_TABLE . ' w, ' . SEARCH_WORDMATCH_TABLE . ' m, ' . $sql_tables
++@@ -138,7 +303,8 @@ class subject_check
++ 				{
++ 					$sql_wordlist_array[] = 't.topic_title LIKE \'%' . $this->db->sql_escape($word) . '%\'';
++ 				}
++-				$sql_wordlist = implode(' OR ', $sql_wordlist_array) . ' ';
+++
+++				$sql_wordlist = implode(' AND ', $sql_wordlist_array) . ' ';
++ 				unset($sql_wordlist_array);
++ 				$sql = 'SELECT ' . $sql_select
++ 				     . '	FROM ' . $sql_tables
++@@ -188,6 +354,8 @@ class subject_check
++ 			$message = 'SUBJECT_CHECK_SIMILAR_TOPIC';
++ 			$topic_list = '';
++ 			$count = 0;
+++			$count_exact = 0;
+++
++ 			foreach ($topics as $row)
++ 			{
++ 				$topic_id		= $row['topic_id'];
++@@ -195,14 +363,22 @@ class subject_check
++ 				$topic_title	= $row['topic_title'];
++ 
++ 				// Check if we need to prevent the post from being made
++-				if ($this->config['subject_check_bypass'] == 0 || ($topic_title == $subject && $this->config['subject_check_bypass'] == 2))
+++				if ($topic_title == $subject && $this->config['subject_check_bypass'] == 2)
++ 				{
++-					$message = 'SUBJECT_CHECK_STRICT_TOPIC';
+++					$message = 'SUBJECT_CHECK_EXACT_TOPIC';
++ 					$bypass = false;
+++					$count_exact += 1;
+++				}
+++				if($this->config['subject_check_bypass'] == 0) {
+++					$bypass = false;
+++				}
+++				if ($this->config['subject_check_strict'])
+++				{
+++					$message = 'SUBJECT_CHECK_STRICT_TOPIC';
++ 				}
++ 
++ 				$count += 1;
++-				$topic_list .= '<a href="' . append_sid(generate_board_url() . '/viewtopic.php', "t={$topic_id}") . '" ' . ($this->config['subject_check_pop'] ? ' onclick="this.target=\'_blank\';"' : '') . '>&bull; ' . $forum_name . $topic_title . '</a>';
+++				$topic_list .= '<a href="' . append_sid(generate_board_url() . '/viewtopic.' . $this->php_ext . '?t=' . $topic_id) . '" ' . ($this->config['subject_check_pop'] ? ' onclick="this.target=\'_blank\';"' : '') . '>&bull; ' . $forum_name . $topic_title . '</a>';
++ 				if ($this->ext_manager->is_enabled('sitesplat/bbtpreview'))
++ 				{
++ 					$topic_list .= '<a data-toggle="modal" data-id="' . $topic_id . '" href="#BBTPreviewDialog" class="btn btn-xs open-bbtpreview hidden-xs" title=""><i class="fa fa-search-plus"></i></a><span class="visible-xs"><a data-toggle="modal" data-id="' . $topic_id . '" href="#BBTPreviewDialog" class="btn-xs open-bbtpreview" title="">' . $this->user->lang('PREVIEW') . '</a></span
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/event/main_listener.php"
+index 6beb1d5c6..68f3c393f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/event/main_listener.php"
+@@ -34,6 +34,7 @@ class main_listener implements EventSubscriberInterface
+ 	protected $config;
+ 	private $subject;
+ 	private $bypass;
++	private $checked;
+ 	public function __construct(\sitesplat\subjectcheck\core\subject_check $subject_check, \phpbb\template\template $template, \phpbb\user $user, \phpbb\controller\helper $helper, \phpbb\config\config $config)
+ 	{
+ 		$this->subject_check = $subject_check;
+@@ -45,7 +46,14 @@ class main_listener implements EventSubscriberInterface
+ 
+ 	public function check_subject($event)
+ 	{
++		$can_bypass = false;
++		if((int) $this->config['subject_check_bypass'] === 1 && $this->config['subject_check_ajax']) return;
++		if((int) $this->config['subject_check_bypass'] === 2 && $this->config['subject_check_ajax']) {
++			$can_bypass = $this->subject_check->can_bypass($event);
++		}
++		if($can_bypass) return;
+ 		list($this->subject, $this->bypass) = $this->subject_check->look_for_posts($event);
++		if($this->bypass) $this->subject = '';
+ 	}
+ 
+ 	public function setup_ajax_bypass($event)
+@@ -57,7 +65,7 @@ class main_listener implements EventSubscriberInterface
+ 				$this->user->add_lang_ext('sitesplat/subjectcheck', 'common');
+ 				$this->template->assign_vars(array(
+ 					'U_PRIME_SUBJECT_CHECK_AJAX'	=> $this->helper->route('sitesplat_subjectcheck_controller', array('forum_id' => $event['forum_id'], 'a' => '1')),
+-					'S_BYPASS_OPTION'				=> $this->config['subject_check_bypass'],
++					'S_BYPASS_OPTION'		=> $this->config['subject_check_bypass'],
+ 				));
+ 			}
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/language/en/common.php"
+index 9bdc4de60..0e8c9174a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/language/en/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/language/en/common.php"
+@@ -24,8 +24,12 @@ $lang = array_merge($lang, array(
+ 		2	=> 'The subject of your topic is similar to existing topics. Please check them out and/or reply there instead of creating a new topic.',
+ 	),
+ 	'SUBJECT_CHECK_STRICT_TOPIC'	=> array(
+-		1	=> 'The subject of your topic is similar to an existing topic. Please reply to this instead of creating a new topic.',
+-		2	=> 'The subject of your topic is similar to existing topics. Please reply to the one that most closely matches your message instead of creating a new topic.',
++		1	=> 'The subject of your topic is an exact match of an existing topic. Please reply to this instead of creating a new topic.',
++		2	=> 'The subject of your topic is an exact match of existing topics. Please reply to the one that most closely matches your message instead of creating a new topic.',
++	),
++	'SUBJECT_CHECK_EXACT_TOPIC'	=> array(
++		1	 => 'The subject of your topic is one exact match of an existing topic. Please reply to that one instead of creating a new topic.',
++		2	=> 'The subject of your topic has more then one exact match of existing topics. Please reply to the one that most closely matches your message instead of creating a new topic.',
+ 	),
+ 
+ 	// One of these two strings will be appended to the above strings, so they need a leading space or some other separator.
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/language/en/info_acp_subject_check.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/language/en/info_acp_subject_check.php"
+index fba8a1036..2dc60fee3 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/language/en/info_acp_subject_check.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/language/en/info_acp_subject_check.php"
+@@ -55,7 +55,7 @@ $lang = array_merge($lang, array(
+ 	
+ 	'ACP_SUBCHECK_SETTINGS'		    => 'Settings',
+ 	'ACP_SUBCHECK'					=> 'Subject Check',
+-	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+ 	'SUBCHECK_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Don\'t forget to check/set the permission for each forum if need be. <strong>ACP &#187; FORUMS &#187; Edit forum &#187; Enable subject check</strong></p></div>',
+ 
+ 	// ACP labels for individual forums
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/styles/FLATBOOTS/template/event/posting_editor_subject_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/styles/FLATBOOTS/template/event/ss_posting_editor_subject_before.html"
+similarity index 94%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/styles/FLATBOOTS/template/event/ss_posting_editor_subject_before.html"
+index b36eaa8e8..b89ed65a3 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/styles/FLATBOOTS/template/event/ss_posting_editor_subject_before.html"
+@@ -53,7 +53,7 @@
+ 		}
+ 		var obj_r = document.getElementById('prime_subject_check_ajax_results');
+ 		var obj_d = document.getElementById('prime_subject_check_ajax_display');
+-		obj_r.innerHTML = '{{ lang('SUBJECT_CHECK_WORKING') }}';
++		obj_r.innerHTML = "{{ lang('SUBJECT_CHECK_WORKING') }}";
+ 		obj_d.style.display = '';
+ 		postform.subject_checked.value = subject;
+ 
+@@ -95,12 +95,6 @@
+ 		postform.onsubmit = function() {
+ 			var result = prime_subject_check(true),
+ 				msg = document.getElementById('prime_subject_check_ajax_results').innerHTML;
+-
+-			if (!result && msg && (msg = msg.replace(/<br ?\/?>.*/i, "").replace(/(<([^>]+)>)/ig, "")))
+-			{
+-				alert(msg)
+-			}
+-			return result;
+ 		}
+ 
+ 		var subject_obj = document.getElementById('subject') || document.getElementsByName('subject')[0];
diff --git "[FORUM_EXT]/sitesplat\\subjectcheck/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\subjectcheck/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\subjectcheck/diff_nospace.tmp"
@@ -0,0 +1,988 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/composer.json"
+index 243604803..8b6af7ee3 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/composer.json"
+@@ -3,7 +3,7 @@
+     "type": "phpbb-extension",
+     "description": "When a new topic is attempted, a list of topics with similar subjects will first be displayed along with a message urging the user to see if perhaps this new topic is not needed. Includes AJAX support.",
+     "homepage": "https://www.sitesplat.com",
+-    "version": "1.0.7",
++    "version": "1.0.6",
+     "keywords": ["phpbb", "extension", "BBcore", "BBOOTS", "FLATBOOTS", "sitesplat"],
+     "license": "Proprietary/All rights reserved",
+     "authors": [
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/core/subject_check.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/core/subject_check.php"
+index e716716ee..461d3529a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/core/subject_check.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/core/subject_check.php"
+@@ -40,23 +40,187 @@ class subject_check
+ 		$this->is_using_fulltext_native = strcmp($config['search_type'], '\phpbb\search\fulltext_native') === 0 ? true : false;
+ 	}
+ 	
++	public function can_bypass(&$event)
++	{
++		// init variables
++		$subject = $event['post_data']['post_subject'];
++		$checked = $this->request->variable('subject_checked', '', true);
++		$bypass = $this->request->variable('subject_check_bypass', (int) $this->config['subject_check_bypass']);
++		$topics = array();
++		
++		// Do we even need to be here?
++		if (!$this->config['subject_check_enable'] ||
++			($event['post_data']['forum_subject_check'] == 0) ||
++			$event['mode'] != 'post' ||
++			empty($subject) ||
++			($bypass && $subject === $checked) ||
++			($this->config['subject_check_admin'] && $this->auth->acl_get('a_')) ||
++			($this->config['subject_check_mod'] && $this->auth->acl_get('m_')) ||
++			($this->config['subject_check_postcount'] != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
++		)
++		{
++			return true;
++		}
++
++		$bypass = true; // This will be set to false later if the situation calls for it.
++
++		// prepare SQL statements
++		$sql_select	= ' t.topic_id, t.topic_title, t.forum_id' . ($this->config['subject_check_fnames'] ? ', f.forum_name' : '');
++		$sql_tables	= $this->topics_table . ' t' . ($this->config['subject_check_fnames'] ? ', ' . $this->forums_table . ' f' : '');
++		$sql_forum	= ($this->config['subject_check_forums'] ? '' : ' AND t.forum_id = ' . $event['forum_id']) . ($this->config['subject_check_fnames'] ? ' AND f.forum_id = t.forum_id' : '');
++		$sql_locked	= $this->config['subject_check_locked'] ? '' : ' AND t.topic_status <> ' . ITEM_LOCKED;
++		$sql_active	= $this->config['subject_check_active'] ? ' AND t.topic_last_post_time > ' . (time() - ($this->config['subject_check_active'] * 86400)) : ''; // 86400 = 60 * 60 * 24
++		$sql_shadow	= ' AND t.topic_status <> ' . ITEM_MOVED;
++		$sql_order	= ' ORDER BY t.topic_id DESC';
++
++		if ($subject === $checked) // Check for exact subject matches
++		{
++			$sql = 'SELECT' . $sql_select
++				. '	FROM ' . $sql_tables
++				. '	WHERE t.topic_title LIKE \'%' . $this->db->sql_escape($subject) . '%\''
++				. 		$sql_forum
++				. 		$sql_locked
++				.		$sql_shadow
++				. 		$sql_active
++				.	$sql_order
++			;
++			$result = $this->db->sql_query_limit($sql, $this->config['subject_check_limit']);
++			while (($row = $this->db->sql_fetchrow($result)))
++			{
++				if ($this->config['subject_check_forums'] && !$this->auth->acl_get('f_read', $row['forum_id'])) // Skip topics in forums that the user cannot see
++				{
++					continue;
++				}
++				$topics[$row['topic_id']] = array(	// Sorted by topic_id
++					'topic_id'		=> $row['topic_id'],
++					'forum_name' 	=> isset($row['forum_name']) ? $row['forum_name'] . ': ' : '',
++					'topic_title' 	=> $row['topic_title'],
++					'match_count'	=> 0,
++				);
++			}
++			$this->db->sql_freeresult();
++		}
++		else
++		{
++			// Get searchable words from the post subject
++			$search_words = $this->clean_and_split_words($subject);
++			$search_words_count = count($search_words);
++
++			// No words to search for
++			if (empty($search_words_count))
++			{
++				return $bypass;
++			}
++
++			// Now search for existing topics with subjects containing those words
++			// Leinad4Mind - Negar pois apesar de estar a usar native a pesquisa mysql aqui é mais rápida
++			if (!$this->is_using_fulltext_native)
++			{
++				$sql = 'SELECT DISTINCT' . $sql_select
++					 . '	FROM ' . SEARCH_WORDLIST_TABLE . ' w, ' . SEARCH_WORDMATCH_TABLE . ' m, ' . $sql_tables
++					 . '	WHERE (' . $this->db->sql_in_set('w.word_text', $search_words)
++					 . '		AND m.word_id = w.word_id'
++					 . '		AND m.title_match = 1'
++					 . '		AND m.post_id = t.topic_first_post_id'
++					 . '		AND w.word_common <> 1'
++					 .			$sql_forum
++					 .			$sql_locked
++					 .			$sql_shadow
++					 .			$sql_active
++					 . '	)'
++				     .		$sql_order
++				;
++			}
++			else
++			{
++				$sql_wordlist_array = array();
++				foreach ($search_words as $word)
++				{
++					$sql_wordlist_array[] = 't.topic_title LIKE \'%' . $this->db->sql_escape($word) . '%\'';
++				}
++
++				$sql_wordlist = implode(' AND ', $sql_wordlist_array) . ' ';
++				unset($sql_wordlist_array);
++				$sql = 'SELECT ' . $sql_select
++				     . '	FROM ' . $sql_tables
++				     . '	WHERE (' . $sql_wordlist . ') '
++					 .			$sql_forum
++					 .			$sql_locked
++					 .			$sql_shadow
++					 .			$sql_active
++				     .		$sql_order
++				;
++			}
++			$result = $this->db->sql_query_limit($sql, $this->config['subject_check_limit']);
++			while (($row = $this->db->sql_fetchrow($result)))
++			{
++				if ($this->config['subject_check_forums'] && !$this->auth->acl_get('f_read', $row['forum_id'])) // Skip topics in forums that the user cannot see
++				{
++					continue;
++				}
++				$title_words = $this->clean_and_split_words($row['topic_title']);
++				$matched_words = array_intersect($search_words, $title_words);
++				$matched_count = count($matched_words);
++				$topics[$row['topic_id']] = array(
++					'topic_id'		=> $row['topic_id'],
++					'forum_name' 	=> isset($row['forum_name']) ? $row['forum_name'] . ': ' : '',
++					'topic_title' 	=> $row['topic_title'],
++					'match_count'	=> $matched_count,
++				);
++			}
++			$this->db->sql_freeresult();
++		}
++
++		// We have found similar topic titles
++		if (!empty($topics))
++		{
++			// Sort by number of matched words, then by topic_id
++			$topic_ids = array();
++			$matches = array();
++			foreach ($topics as $key => $row)
++			{
++				$topic_ids[$key] = $row['topic_id'];
++				$matches[$key] = $row['match_count'];
++			}
++			array_multisort($matches, SORT_DESC, $topic_ids, SORT_DESC, $topics);
++
++			// Prepare topic list
++			$topic_list = '';
++
++			foreach ($topics as $row)
++			{
++				$topic_id		= $row['topic_id'];
++				$forum_name		= $row['forum_name'];
++				$topic_title	= $row['topic_title'];
++
++				// Check if we need to prevent the post from being made
++				if ($topic_title == $subject)
++				{
++					$bypass = false;
++				}
++			}
++		}
++
++		return $bypass;
++	}
++
+ 	public function look_for_posts(&$event)
+ 	{
+ 		// init variables
+ 		$subject = $event['post_data']['post_subject'];
+-		$checked = $this->request->variable('subject_checked', '');
++		$checked = $this->request->variable('subject_checked', '', true);
+ 		$bypass = $this->request->variable('subject_check_bypass', (int) $this->config['subject_check_bypass']);
+ 		$topics = array();
+ 		
+ 		// Do we even need to be here?
+-		if (empty($this->config['subject_check_enable']) ||
+-			empty($event['post_data']['forum_subject_check']) ||
++		if (!$this->config['subject_check_enable'] ||
++			($event['post_data']['forum_subject_check'] == 0) ||
+ 			$event['mode'] != 'post' ||
+ 			empty($subject) ||
+ 			($bypass && $subject === $checked) ||
+ 			($this->config['subject_check_admin'] && $this->auth->acl_get('a_')) ||
+ 			($this->config['subject_check_mod'] && $this->auth->acl_get('m_')) ||
+-			(intval($this->config['subject_check_postcount']) != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
++			($this->config['subject_check_postcount'] != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
+ 		)
+ 		{
+ 			$bypass = true;
+@@ -74,11 +238,11 @@ class subject_check
+ 		$sql_shadow	= ' AND t.topic_status <> ' . ITEM_MOVED;
+ 		$sql_order	= ' ORDER BY t.topic_id DESC';
+ 
+-		if ($this->config['subject_check_strict']) // Check for exact subject matches
++		if ($this->config['subject_check_strict'] || ($subject === $checked && $this->config['subject_check_bypass'] == 2)) // Check for exact subject matches
+ 		{
+ 			$sql = 'SELECT' . $sql_select
+ 				. '	FROM ' . $sql_tables
+-				. '	WHERE t.topic_title = \'' . $this->db->sql_escape($subject) . '\''
++				. '	WHERE t.topic_title LIKE \'%' . $this->db->sql_escape($this->clean_words($subject)) . '%\''
+ 				. 		$sql_forum
+ 				. 		$sql_locked
+ 				.		$sql_shadow
+@@ -114,7 +278,8 @@ class subject_check
+ 			}
+ 
+ 			// Now search for existing topics with subjects containing those words
+-			if ($this->is_using_fulltext_native)
++			//Leinad4Mind - Negar pois apesar de estar a usar native a pesquisa mysql aqui é mais rápida
++			if (!$this->is_using_fulltext_native)
+ 			{
+ 				$sql = 'SELECT DISTINCT' . $sql_select
+ 					 . '	FROM ' . SEARCH_WORDLIST_TABLE . ' w, ' . SEARCH_WORDMATCH_TABLE . ' m, ' . $sql_tables
+@@ -138,7 +303,8 @@ class subject_check
+ 				{
+ 					$sql_wordlist_array[] = 't.topic_title LIKE \'%' . $this->db->sql_escape($word) . '%\'';
+ 				}
+-				$sql_wordlist = implode(' OR ', $sql_wordlist_array) . ' ';
++
++				$sql_wordlist = implode(' AND ', $sql_wordlist_array) . ' ';
+ 				unset($sql_wordlist_array);
+ 				$sql = 'SELECT ' . $sql_select
+ 				     . '	FROM ' . $sql_tables
+@@ -188,6 +354,8 @@ class subject_check
+ 			$message = 'SUBJECT_CHECK_SIMILAR_TOPIC';
+ 			$topic_list = '';
+ 			$count = 0;
++			$count_exact = 0;
++
+ 			foreach ($topics as $row)
+ 			{
+ 				$topic_id		= $row['topic_id'];
+@@ -195,14 +363,22 @@ class subject_check
+ 				$topic_title	= $row['topic_title'];
+ 
+ 				// Check if we need to prevent the post from being made
+-				if ($this->config['subject_check_bypass'] == 0 || ($topic_title == $subject && $this->config['subject_check_bypass'] == 2))
++				if ($topic_title == $subject && $this->config['subject_check_bypass'] == 2)
+ 				{
+-					$message = 'SUBJECT_CHECK_STRICT_TOPIC';
++					$message = 'SUBJECT_CHECK_EXACT_TOPIC';
+ 					$bypass = false;
++					$count_exact += 1;
++				}
++				if($this->config['subject_check_bypass'] == 0) {
++					$bypass = false;
++				}
++				if ($this->config['subject_check_strict'])
++				{
++					$message = 'SUBJECT_CHECK_STRICT_TOPIC';
+ 				}
+ 
+ 				$count += 1;
+-				$topic_list .= '<a href="' . append_sid(generate_board_url() . '/viewtopic.php', "t={$topic_id}") . '" ' . ($this->config['subject_check_pop'] ? ' onclick="this.target=\'_blank\';"' : '') . '>&bull; ' . $forum_name . $topic_title . '</a>';
++				$topic_list .= '<a href="' . append_sid(generate_board_url() . '/viewtopic.' . $this->php_ext . '?t=' . $topic_id) . '" ' . ($this->config['subject_check_pop'] ? ' onclick="this.target=\'_blank\';"' : '') . '>&bull; ' . $forum_name . $topic_title . '</a>';
+ 				if ($this->ext_manager->is_enabled('sitesplat/bbtpreview'))
+ 				{
+ 					$topic_list .= '<a data-toggle="modal" data-id="' . $topic_id . '" href="#BBTPreviewDialog" class="btn btn-xs open-bbtpreview hidden-xs" title=""><i class="fa fa-search-plus"></i></a><span class="visible-xs"><a data-toggle="modal" data-id="' . $topic_id . '" href="#BBTPreviewDialog" class="btn-xs open-bbtpreview" title="">' . $this->user->lang('PREVIEW') . '</a></span>';
+@@ -215,6 +391,10 @@ class subject_check
+ 				}
+ 			}
+ 
++			if ($message == 'SUBJECT_CHECK_EXACT_TOPIC') {
++				$count = $count_exact;
++			}
++
+ 			$error = $event['error'];
+ 			$error[] = $this->user->lang($message, $count) . ($this->config['subject_check_pop'] ? $this->user->lang('SUBJECT_CHECK_NEW_WINDOW') : $this->user->lang('SUBJECT_CHECK_SAME_WINDOW')) . '<br />' . $topic_list;
+ 			$event['error'] = $error;
+@@ -227,6 +407,10 @@ class subject_check
+ 	{
+ 		$entry = ' ' . strip_tags(utf8_case_fold_nfc($entry)) . ' ';
+ 
++		// Remove text between colons, including the colons themselves.
++		$entry = preg_replace('/:\S+:/u', ' ', $entry);
++		$entry = preg_replace('/\[(.*?)\]|\((.*?)\)/', ' ', $entry);
++
+ 		$entry = $this->fulltext_native->cleanup($entry);
+ 
+ 		// Reduce multiple spaces to a single space and split this trimmed string into words.
+@@ -234,4 +418,20 @@ class subject_check
+ 
+ 		return $word_list;
+ 	}
++
++	protected function clean_words($entry)
++	{
++		$entry = ' ' . strip_tags(utf8_case_fold_nfc($entry)) . ' ';
++
++		// Remove text between colons, including the colons themselves.
++		$entry = preg_replace('/:\S+:/u', ' ', $entry);
++		$entry = preg_replace('/\[(.*?)\]|\((.*?)\)/', ' ', $entry);
++
++		$entry = $this->fulltext_native->cleanup($entry);
++
++		// Reduce multiple spaces to a single space and split this trimmed string into words.
++		$entry = trim(preg_replace('#\s+#', ' ', $entry));
++
++		return $entry;
++	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/diff_full.tmp"
+new file mode 100644
+index 000000000..bf8c3d8fa
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/diff_full.tmp"
+@@ -0,0 +1,707 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/composer.json"
++index 243604803..8b6af7ee3 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/composer.json"
++@@ -3,7 +3,7 @@
++     "type": "phpbb-extension",
++     "description": "When a new topic is attempted, a list of topics with similar subjects will first be displayed along with a message urging the user to see if perhaps this new topic is not needed. Includes AJAX support.",
++     "homepage": "https://www.sitesplat.com",
++-    "version": "1.0.7",
+++    "version": "1.0.6",
++     "keywords": ["phpbb", "extension", "BBcore", "BBOOTS", "FLATBOOTS", "sitesplat"],
++     "license": "Proprietary/All rights reserved",
++     "authors": [
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/core/subject_check.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/core/subject_check.php"
++index e716716ee..461d3529a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/core/subject_check.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/core/subject_check.php"
++@@ -39,24 +39,188 @@ class subject_check
++ 		$this->fulltext_native = new fulltext_native_cleanup($root_path, $php_ext);
++ 		$this->is_using_fulltext_native = strcmp($config['search_type'], '\phpbb\search\fulltext_native') === 0 ? true : false;
++ 	}
+++	
+++	public function can_bypass(&$event)
+++	{
+++		// init variables
+++		$subject = $event['post_data']['post_subject'];
+++		$checked = $this->request->variable('subject_checked', '', true);
+++		$bypass = $this->request->variable('subject_check_bypass', (int) $this->config['subject_check_bypass']);
+++		$topics = array();
+++		
+++		// Do we even need to be here?
+++		if (!$this->config['subject_check_enable'] ||
+++			($event['post_data']['forum_subject_check'] == 0) ||
+++			$event['mode'] != 'post' ||
+++			empty($subject) ||
+++			($bypass && $subject === $checked) ||
+++			($this->config['subject_check_admin'] && $this->auth->acl_get('a_')) ||
+++			($this->config['subject_check_mod'] && $this->auth->acl_get('m_')) ||
+++			($this->config['subject_check_postcount'] != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
+++		)
+++		{
+++			return true;
+++		}
+++
+++		$bypass = true; // This will be set to false later if the situation calls for it.
+++
+++		// prepare SQL statements
+++		$sql_select	= ' t.topic_id, t.topic_title, t.forum_id' . ($this->config['subject_check_fnames'] ? ', f.forum_name' : '');
+++		$sql_tables	= $this->topics_table . ' t' . ($this->config['subject_check_fnames'] ? ', ' . $this->forums_table . ' f' : '');
+++		$sql_forum	= ($this->config['subject_check_forums'] ? '' : ' AND t.forum_id = ' . $event['forum_id']) . ($this->config['subject_check_fnames'] ? ' AND f.forum_id = t.forum_id' : '');
+++		$sql_locked	= $this->config['subject_check_locked'] ? '' : ' AND t.topic_status <> ' . ITEM_LOCKED;
+++		$sql_active	= $this->config['subject_check_active'] ? ' AND t.topic_last_post_time > ' . (time() - ($this->config['subject_check_active'] * 86400)) : ''; // 86400 = 60 * 60 * 24
+++		$sql_shadow	= ' AND t.topic_status <> ' . ITEM_MOVED;
+++		$sql_order	= ' ORDER BY t.topic_id DESC';
+++
+++		if ($subject === $checked) // Check for exact subject matches
+++		{
+++			$sql = 'SELECT' . $sql_select
+++				. '	FROM ' . $sql_tables
+++				. '	WHERE t.topic_title LIKE \'%' . $this->db->sql_escape($subject) . '%\''
+++				. 		$sql_forum
+++				. 		$sql_locked
+++				.		$sql_shadow
+++				. 		$sql_active
+++				.	$sql_order
+++			;
+++			$result = $this->db->sql_query_limit($sql, $this->config['subject_check_limit']);
+++			while (($row = $this->db->sql_fetchrow($result)))
+++			{
+++				if ($this->config['subject_check_forums'] && !$this->auth->acl_get('f_read', $row['forum_id'])) // Skip topics in forums that the user cannot see
+++				{
+++					continue;
+++				}
+++				$topics[$row['topic_id']] = array(	// Sorted by topic_id
+++					'topic_id'		=> $row['topic_id'],
+++					'forum_name' 	=> isset($row['forum_name']) ? $row['forum_name'] . ': ' : '',
+++					'topic_title' 	=> $row['topic_title'],
+++					'match_count'	=> 0,
+++				);
+++			}
+++			$this->db->sql_freeresult();
+++		}
+++		else
+++		{
+++			// Get searchable words from the post subject
+++			$search_words = $this->clean_and_split_words($subject);
+++			$search_words_count = count($search_words);
+++
+++			// No words to search for
+++			if (empty($search_words_count))
+++			{
+++				return $bypass;
+++			}
+++
+++			// Now search for existing topics with subjects containing those words
+++			// Leinad4Mind - Negar pois apesar de estar a usar native a pesquisa mysql aqui é mais rápida
+++			if (!$this->is_using_fulltext_native)
+++			{
+++				$sql = 'SELECT DISTINCT' . $sql_select
+++					 . '	FROM ' . SEARCH_WORDLIST_TABLE . ' w, ' . SEARCH_WORDMATCH_TABLE . ' m, ' . $sql_tables
+++					 . '	WHERE (' . $this->db->sql_in_set('w.word_text', $search_words)
+++					 . '		AND m.word_id = w.word_id'
+++					 . '		AND m.title_match = 1'
+++					 . '		AND m.post_id = t.topic_first_post_id'
+++					 . '		AND w.word_common <> 1'
+++					 .			$sql_forum
+++					 .			$sql_locked
+++					 .			$sql_shadow
+++					 .			$sql_active
+++					 . '	)'
+++				     .		$sql_order
+++				;
+++			}
+++			else
+++			{
+++				$sql_wordlist_array = array();
+++				foreach ($search_words as $word)
+++				{
+++					$sql_wordlist_array[] = 't.topic_title LIKE \'%' . $this->db->sql_escape($word) . '%\'';
+++				}
+++
+++				$sql_wordlist = implode(' AND ', $sql_wordlist_array) . ' ';
+++				unset($sql_wordlist_array);
+++				$sql = 'SELECT ' . $sql_select
+++				     . '	FROM ' . $sql_tables
+++				     . '	WHERE (' . $sql_wordlist . ') '
+++					 .			$sql_forum
+++					 .			$sql_locked
+++					 .			$sql_shadow
+++					 .			$sql_active
+++				     .		$sql_order
+++				;
+++			}
+++			$result = $this->db->sql_query_limit($sql, $this->config['subject_check_limit']);
+++			while (($row = $this->db->sql_fetchrow($result)))
+++			{
+++				if ($this->config['subject_check_forums'] && !$this->auth->acl_get('f_read', $row['forum_id'])) // Skip topics in forums that the user cannot see
+++				{
+++					continue;
+++				}
+++				$title_words = $this->clean_and_split_words($row['topic_title']);
+++				$matched_words = array_intersect($search_words, $title_words);
+++				$matched_count = count($matched_words);
+++				$topics[$row['topic_id']] = array(
+++					'topic_id'		=> $row['topic_id'],
+++					'forum_name' 	=> isset($row['forum_name']) ? $row['forum_name'] . ': ' : '',
+++					'topic_title' 	=> $row['topic_title'],
+++					'match_count'	=> $matched_count,
+++				);
+++			}
+++			$this->db->sql_freeresult();
+++		}
+++
+++		// We have found similar topic titles
+++		if (!empty($topics))
+++		{
+++			// Sort by number of matched words, then by topic_id
+++			$topic_ids = array();
+++			$matches = array();
+++			foreach ($topics as $key => $row)
+++			{
+++				$topic_ids[$key] = $row['topic_id'];
+++				$matches[$key] = $row['match_count'];
+++			}
+++			array_multisort($matches, SORT_DESC, $topic_ids, SORT_DESC, $topics);
+++
+++			// Prepare topic list
+++			$topic_list = '';
+++
+++			foreach ($topics as $row)
+++			{
+++				$topic_id		= $row['topic_id'];
+++				$forum_name		= $row['forum_name'];
+++				$topic_title	= $row['topic_title'];
+++
+++				// Check if we need to prevent the post from being made
+++				if ($topic_title == $subject)
+++				{
+++					$bypass = false;
+++				}
+++			}
+++		}
+++
+++		return $bypass;
+++	}
++ 
++ 	public function look_for_posts(&$event)
++ 	{
++ 		// init variables
++ 		$subject = $event['post_data']['post_subject'];
++-		$checked = $this->request->variable('subject_checked', '');
+++		$checked = $this->request->variable('subject_checked', '', true);
++ 		$bypass = $this->request->variable('subject_check_bypass', (int) $this->config['subject_check_bypass']);
++ 		$topics = array();
++-
+++		
++ 		// Do we even need to be here?
++-		if (empty($this->config['subject_check_enable']) ||
++-			empty($event['post_data']['forum_subject_check']) ||
+++		if (!$this->config['subject_check_enable'] ||
+++			($event['post_data']['forum_subject_check'] == 0) ||
++ 			$event['mode'] != 'post' ||
++ 			empty($subject) ||
++ 			($bypass && $subject === $checked) ||
++ 			($this->config['subject_check_admin'] && $this->auth->acl_get('a_')) ||
++ 			($this->config['subject_check_mod'] && $this->auth->acl_get('m_')) ||
++-			(intval($this->config['subject_check_postcount']) != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
+++			($this->config['subject_check_postcount'] != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
++ 		)
++ 		{
++ 			$bypass = true;
++@@ -74,11 +238,11 @@ class subject_check
++ 		$sql_shadow	= ' AND t.topic_status <> ' . ITEM_MOVED;
++ 		$sql_order	= ' ORDER BY t.topic_id DESC';
++ 
++-		if ($this->config['subject_check_strict']) // Check for exact subject matches
+++		if ($this->config['subject_check_strict'] || ($subject === $checked && $this->config['subject_check_bypass'] == 2)) // Check for exact subject matches
++ 		{
++ 			$sql = 'SELECT' . $sql_select
++ 				. '	FROM ' . $sql_tables
++-				. '	WHERE t.topic_title = \'' . $this->db->sql_escape($subject) . '\''
+++				. '	WHERE t.topic_title LIKE \'%' . $this->db->sql_escape($this->clean_words($subject)) . '%\''
++ 				. 		$sql_forum
++ 				. 		$sql_locked
++ 				.		$sql_shadow
++@@ -114,7 +278,8 @@ class subject_check
++ 			}
++ 
++ 			// Now search for existing topics with subjects containing those words
++-			if ($this->is_using_fulltext_native)
+++			//Leinad4Mind - Negar pois apesar de estar a usar native a pesquisa mysql aqui é mais rápida
+++			if (!$this->is_using_fulltext_native)
++ 			{
++ 				$sql = 'SELECT DISTINCT' . $sql_select
++ 					 . '	FROM ' . SEARCH_WORDLIST_TABLE . ' w, ' . SEARCH_WORDMATCH_TABLE . ' m, ' . $sql_tables
++@@ -138,7 +303,8 @@ class subject_check
++ 				{
++ 					$sql_wordlist_array[] = 't.topic_title LIKE \'%' . $this->db->sql_escape($word) . '%\'';
++ 				}
++-				$sql_wordlist = implode(' OR ', $sql_wordlist_array) . ' ';
+++
+++				$sql_wordlist = implode(' AND ', $sql_wordlist_array) . ' ';
++ 				unset($sql_wordlist_array);
++ 				$sql = 'SELECT ' . $sql_select
++ 				     . '	FROM ' . $sql_tables
++@@ -188,6 +354,8 @@ class subject_check
++ 			$message = 'SUBJECT_CHECK_SIMILAR_TOPIC';
++ 			$topic_list = '';
++ 			$count = 0;
+++			$count_exact = 0;
+++
++ 			foreach ($topics as $row)
++ 			{
++ 				$topic_id		= $row['topic_id'];
++@@ -195,14 +363,22 @@ class subject_check
++ 				$topic_title	= $row['topic_title'];
++ 
++ 				// Check if we need to prevent the post from being made
++-				if ($this->config['subject_check_bypass'] == 0 || ($topic_title == $subject && $this->config['subject_check_bypass'] == 2))
+++				if ($topic_title == $subject && $this->config['subject_check_bypass'] == 2)
++ 				{
++-					$message = 'SUBJECT_CHECK_STRICT_TOPIC';
+++					$message = 'SUBJECT_CHECK_EXACT_TOPIC';
++ 					$bypass = false;
+++					$count_exact += 1;
+++				}
+++				if($this->config['subject_check_bypass'] == 0) {
+++					$bypass = false;
+++				}
+++				if ($this->config['subject_check_strict'])
+++				{
+++					$message = 'SUBJECT_CHECK_STRICT_TOPIC';
++ 				}
++ 
++ 				$count += 1;
++-				$topic_list .= '<a href="' . append_sid(generate_board_url() . '/viewtopic.php', "t={$topic_id}") . '" ' . ($this->config['subject_check_pop'] ? ' onclick="this.target=\'_blank\';"' : '') . '>&bull; ' . $forum_name . $topic_title . '</a>';
+++				$topic_list .= '<a href="' . append_sid(generate_board_url() . '/viewtopic.' . $this->php_ext . '?t=' . $topic_id) . '" ' . ($this->config['subject_check_pop'] ? ' onclick="this.target=\'_blank\';"' : '') . '>&bull; ' . $forum_name . $topic_title . '</a>';
++ 				if ($this->ext_manager->is_enabled('sitesplat/bbtpreview'))
++ 				{
++ 					$topic_list .= '<a data-toggle="modal" data-id="' . $topic_id . '" href="#BBTPreviewDialog" class="btn btn-xs open-bbtpreview hidden-xs" title=""><i class="fa fa-search-plus"></i></a><span class="visible-xs"><a data-toggle="modal" data-id="' . $topic_id . '" href="#BBTPreviewDialog" class="btn-xs open-bbtpreview" title="">' . $this->user->lang('PREVIEW') . '</a></span>';
++@@ -215,6 +391,10 @@ class subject_check
++ 				}
++ 			}
++ 
+++			if ($message == 'SUBJECT_CHECK_EXACT_TOPIC') {
+++				$count = $count_exact;
+++			}
+++
++ 			$error = $event['error'];
++ 			$error[] = $this->user->lang($message, $count) . ($this->config['subject_check_pop'] ? $this->user->lang('SUBJECT_CHECK_NEW_WINDOW') : $this->user->lang('SUBJECT_CHECK_SAME_WINDOW')) . '<br />' . $topic_list;
++ 			$event['error'] = $error;
++@@ -227,6 +407,10 @@ class subject_check
++ 	{
++ 		$entry = ' ' . strip_tags(utf8_case_fold_nfc($entry)) . ' ';
++ 
+++		// Remove text between colons, including the colons themselves.
+++		$entry = preg_replace('/:\S+:/u', ' ', $entry);
+++		$entry = preg_replace('/\[(.*?)\]|\((.*?)\)/', ' ', $entry);
+++
++ 		$entry = $this->fulltext_native->cleanup($entry);
++ 
++ 		// Reduce multiple spaces to a single space and split this trimmed string into words.
++@@ -234,4 +418,20 @@ class subject_check
++ 
++ 		return $word_list;
++ 	}
+++
+++	protected function clean_words($entry)
+++	{
+++		$entry = ' ' . strip_tags(utf8_case_fold_nfc($entry)) . ' ';
+++
+++		// Remove text between colons, including the colons themselves.
+++		$entry = preg_replace('/:\S+:/u', ' ', $entry);
+++		$entry = preg_replace('/\[(.*?)\]|\((.*?)\)/', ' ', $entry);
+++
+++		$entry = $this->fulltext_native->cleanup($entry);
+++
+++		// Reduce multiple spaces to a single space and split this trimmed string into words.
+++		$entry = trim(preg_replace('#\s+#', ' ', $entry));
+++
+++		return $entry;
+++	}
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/diff_full.tmp"
++new file mode 100644
++index 000000000..4e46f7258
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/diff_full.tmp"
++@@ -0,0 +1,280 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/composer.json"
+++index 243604803..8b6af7ee3 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/composer.json"
+++@@ -3,7 +3,7 @@
+++     "type": "phpbb-extension",
+++     "description": "When a new topic is attempted, a list of topics with similar subjects will first be displayed along with a message urging the user to see if perhaps this new topic is not needed. Includes AJAX support.",
+++     "homepage": "https://www.sitesplat.com",
+++-    "version": "1.0.7",
++++    "version": "1.0.6",
+++     "keywords": ["phpbb", "extension", "BBcore", "BBOOTS", "FLATBOOTS", "sitesplat"],
+++     "license": "Proprietary/All rights reserved",
+++     "authors": [
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/core/subject_check.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/core/subject_check.php"
+++index e716716ee..461d3529a 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/core/subject_check.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/core/subject_check.php"
+++@@ -39,24 +39,188 @@ class subject_check
+++ 		$this->fulltext_native = new fulltext_native_cleanup($root_path, $php_ext);
+++ 		$this->is_using_fulltext_native = strcmp($config['search_type'], '\phpbb\search\fulltext_native') === 0 ? true : false;
+++ 	}
++++	
++++	public function can_bypass(&$event)
++++	{
++++		// init variables
++++		$subject = $event['post_data']['post_subject'];
++++		$checked = $this->request->variable('subject_checked', '', true);
++++		$bypass = $this->request->variable('subject_check_bypass', (int) $this->config['subject_check_bypass']);
++++		$topics = array();
++++		
++++		// Do we even need to be here?
++++		if (!$this->config['subject_check_enable'] ||
++++			($event['post_data']['forum_subject_check'] == 0) ||
++++			$event['mode'] != 'post' ||
++++			empty($subject) ||
++++			($bypass && $subject === $checked) ||
++++			($this->config['subject_check_admin'] && $this->auth->acl_get('a_')) ||
++++			($this->config['subject_check_mod'] && $this->auth->acl_get('m_')) ||
++++			($this->config['subject_check_postcount'] != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
++++		)
++++		{
++++			return true;
++++		}
++++
++++		$bypass = true; // This will be set to false later if the situation calls for it.
++++
++++		// prepare SQL statements
++++		$sql_select	= ' t.topic_id, t.topic_title, t.forum_id' . ($this->config['subject_check_fnames'] ? ', f.forum_name' : '');
++++		$sql_tables	= $this->topics_table . ' t' . ($this->config['subject_check_fnames'] ? ', ' . $this->forums_table . ' f' : '');
++++		$sql_forum	= ($this->config['subject_check_forums'] ? '' : ' AND t.forum_id = ' . $event['forum_id']) . ($this->config['subject_check_fnames'] ? ' AND f.forum_id = t.forum_id' : '');
++++		$sql_locked	= $this->config['subject_check_locked'] ? '' : ' AND t.topic_status <> ' . ITEM_LOCKED;
++++		$sql_active	= $this->config['subject_check_active'] ? ' AND t.topic_last_post_time > ' . (time() - ($this->config['subject_check_active'] * 86400)) : ''; // 86400 = 60 * 60 * 24
++++		$sql_shadow	= ' AND t.topic_status <> ' . ITEM_MOVED;
++++		$sql_order	= ' ORDER BY t.topic_id DESC';
++++
++++		if ($subject === $checked) // Check for exact subject matches
++++		{
++++			$sql = 'SELECT' . $sql_select
++++				. '	FROM ' . $sql_tables
++++				. '	WHERE t.topic_title LIKE \'%' . $this->db->sql_escape($subject) . '%\''
++++				. 		$sql_forum
++++				. 		$sql_locked
++++				.		$sql_shadow
++++				. 		$sql_active
++++				.	$sql_order
++++			;
++++			$result = $this->db->sql_query_limit($sql, $this->config['subject_check_limit']);
++++			while (($row = $this->db->sql_fetchrow($result)))
++++			{
++++				if ($this->config['subject_check_forums'] && !$this->auth->acl_get('f_read', $row['forum_id'])) // Skip topics in forums that the user cannot see
++++				{
++++					continue;
++++				}
++++				$topics[$row['topic_id']] = array(	// Sorted by topic_id
++++					'topic_id'		=> $row['topic_id'],
++++					'forum_name' 	=> isset($row['forum_name']) ? $row['forum_name'] . ': ' : '',
++++					'topic_title' 	=> $row['topic_title'],
++++					'match_count'	=> 0,
++++				);
++++			}
++++			$this->db->sql_freeresult();
++++		}
++++		else
++++		{
++++			// Get searchable words from the post subject
++++			$search_words = $this->clean_and_split_words($subject);
++++			$search_words_count = count($search_words);
++++
++++			// No words to search for
++++			if (empty($search_words_count))
++++			{
++++				return $bypass;
++++			}
++++
++++			// Now search for existing topics with subjects containing those words
++++			// Leinad4Mind - Negar pois apesar de estar a usar native a pesquisa mysql aqui é mais rápida
++++			if (!$this->is_using_fulltext_native)
++++			{
++++				$sql = 'SELECT DISTINCT' . $sql_select
++++					 . '	FROM ' . SEARCH_WORDLIST_TABLE . ' w, ' . SEARCH_WORDMATCH_TABLE . ' m, ' . $sql_tables
++++					 . '	WHERE (' . $this->db->sql_in_set('w.word_text', $search_words)
++++					 . '		AND m.word_id = w.word_id'
++++					 . '		AND m.title_match = 1'
++++					 . '		AND m.post_id = t.topic_first_post_id'
++++					 . '		AND w.word_common <> 1'
++++					 .			$sql_forum
++++					 .			$sql_locked
++++					 .			$sql_shadow
++++					 .			$sql_active
++++					 . '	)'
++++				     .		$sql_order
++++				;
++++			}
++++			else
++++			{
++++				$sql_wordlist_array = array();
++++				foreach ($search_words as $word)
++++				{
++++					$sql_wordlist_array[] = 't.topic_title LIKE \'%' . $this->db->sql_escape($word) . '%\'';
++++				}
++++
++++				$sql_wordlist = implode(' AND ', $sql_wordlist_array) . ' ';
++++				unset($sql_wordlist_array);
++++				$sql = 'SELECT ' . $sql_select
++++				     . '	FROM ' . $sql_tables
++++				     . '	WHERE (' . $sql_wordlist . ') '
++++					 .			$sql_forum
++++					 .			$sql_locked
++++					 .			$sql_shadow
++++					 .			$sql_active
++++				     .		$sql_order
++++				;
++++			}
++++			$result = $this->db->sql_query_limit($sql, $this->config['subject_check_limit']);
++++			while (($row = $this->db->sql_fetchrow($result)))
++++			{
++++				if ($this->config['subject_check_forums'] && !$this->auth->acl_get('f_read', $row['forum_id'])) // Skip topics in forums that the user cannot see
++++				{
++++					continue;
++++				}
++++				$title_words = $this->clean_and_split_words($row['topic_title']);
++++				$matched_words = array_intersect($search_words, $title_words);
++++				$matched_count = count($matched_words);
++++				$topics[$row['topic_id']] = array(
++++					'topic_id'		=> $row['topic_id'],
++++					'forum_name' 	=> isset($row['forum_name']) ? $row['forum_name'] . ': ' : '',
++++					'topic_title' 	=> $row['topic_title'],
++++					'match_count'	=> $matched_count,
++++				);
++++			}
++++			$this->db->sql_freeresult();
++++		}
++++
++++		// We have found similar topic titles
++++		if (!empty($topics))
++++		{
++++			// Sort by number of matched words, then by topic_id
++++			$topic_ids = array();
++++			$matches = array();
++++			foreach ($topics as $key => $row)
++++			{
++++				$topic_ids[$key] = $row['topic_id'];
++++				$matches[$key] = $row['match_count'];
++++			}
++++			array_multisort($matches, SORT_DESC, $topic_ids, SORT_DESC, $topics);
++++
++++			// Prepare topic list
++++			$topic_list = '';
++++
++++			foreach ($topics as $row)
++++			{
++++				$topic_id		= $row['topic_id'];
++++				$forum_name		= $row['forum_name'];
++++				$topic_title	= $row['topic_title'];
++++
++++				// Check if we need to prevent the post from being made
++++				if ($topic_title == $subject)
++++				{
++++					$bypass = false;
++++				}
++++			}
++++		}
++++
++++		return $bypass;
++++	}
+++ 
+++ 	public function look_for_posts(&$event)
+++ 	{
+++ 		// init variables
+++ 		$subject = $event['post_data']['post_subject'];
+++-		$checked = $this->request->variable('subject_checked', '');
++++		$checked = $this->request->variable('subject_checked', '', true);
+++ 		$bypass = $this->request->variable('subject_check_bypass', (int) $this->config['subject_check_bypass']);
+++ 		$topics = array();
+++-
++++		
+++ 		// Do we even need to be here?
+++-		if (empty($this->config['subject_check_enable']) ||
+++-			empty($event['post_data']['forum_subject_check']) ||
++++		if (!$this->config['subject_check_enable'] ||
++++			($event['post_data']['forum_subject_check'] == 0) ||
+++ 			$event['mode'] != 'post' ||
+++ 			empty($subject) ||
+++ 			($bypass && $subject === $checked) ||
+++ 			($this->config['subject_check_admin'] && $this->auth->acl_get('a_')) ||
+++ 			($this->config['subject_check_mod'] && $this->auth->acl_get('m_')) ||
+++-			(intval($this->config['subject_check_postcount']) != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
++++			($this->config['subject_check_postcount'] != 0 && $this->user->data['user_posts'] > $this->config['subject_check_postcount'])
+++ 		)
+++ 		{
+++ 			$bypass = true;
+++@@ -74,11 +238,11 @@ class subject_check
+++ 		$sql_shadow	= ' AND t.topic_status <> ' . ITEM_MOVED;
+++ 		$sql_order	= ' ORDER BY t.topic_id DESC';
+++ 
+++-		if ($this->config['subject_check_strict']) // Check for exact subject matches
++++		if ($this->config['subject_check_strict'] || ($subject === $checked && $this->config['subject_check_bypass'] == 2)) // Check for exact subject matches
+++ 		{
+++ 			$sql = 'SELECT' . $sql_select
+++ 				. '	FROM ' . $sql_tables
+++-				. '	WHERE t.topic_title = \'' . $this->db->sql_escape($subject) . '\''
++++				. '	WHERE t.topic_title LIKE \'%' . $this->db->sql_escape($this->clean_words($subject)) . '%\''
+++ 				. 		$sql_forum
+++ 				. 		$sql_locked
+++ 				.		$sql_shadow
+++@@ -114,7 +278,8 @@ class subject_check
+++ 			}
+++ 
+++ 			// Now search for existing topics with subjects containing those words
+++-			if ($this->is_using_fulltext_native)
++++			//Leinad4Mind - Negar pois apesar de estar a usar native a pesquisa mysql aqui é mais rápida
++++			if (!$this->is_using_fulltext_native)
+++ 			{
+++ 				$sql = 'SELECT DISTINCT' . $sql_select
+++ 					 . '	FROM ' . SEARCH_WORDLIST_TABLE . ' w, ' . SEARCH_WORDMATCH_TABLE . ' m, ' . $sql_tables
+++@@ -138,7 +303,8 @@ class subject_check
+++ 				{
+++ 					$sql_wordlist_array[] = 't.topic_title LIKE \'%' . $this->db->sql_escape($word) . '%\'';
+++ 				}
+++-				$sql_wordlist = implode(' OR ', $sql_wordlist_array) . ' ';
++++
++++				$sql_wordlist = implode(' AND ', $sql_wordlist_array) . ' ';
+++ 				unset($sql_wordlist_array);
+++ 				$sql = 'SELECT ' . $sql_select
+++ 				     . '	FROM ' . $sql_tables
+++@@ -188,6 +354,8 @@ class subject_check
+++ 			$message = 'SUBJECT_CHECK_SIMILAR_TOPIC';
+++ 			$topic_list = '';
+++ 			$count = 0;
++++			$count_exact = 0;
++++
+++ 			foreach ($topics as $row)
+++ 			{
+++ 				$topic_id		= $row['topic_id'];
+++@@ -195,14 +363,22 @@ class subject_check
+++ 				$topic_title	= $row['topic_title'];
+++ 
+++ 				// Check if we need to prevent the post from being made
+++-				if ($this->config['subject_check_bypass'] == 0 || ($topic_title == $subject && $this->config['subject_check_bypass'] == 2))
++++				if ($topic_title == $subject && $this->config['subject_check_bypass'] == 2)
+++ 				{
+++-					$message = 'SUBJECT_CHECK_STRICT_TOPIC';
++++					$message = 'SUBJECT_CHECK_EXACT_TOPIC';
+++ 					$bypass = false;
++++					$count_exact += 1;
++++				}
++++				if($this->config['subject_check_bypass'] == 0) {
++++					$bypass = false;
++++				}
++++				if ($this->config['subject_check_strict'])
++++				{
++++					$message = 'SUBJECT_CHECK_STRICT_TOPIC';
+++ 				}
+++ 
+++ 				$count += 1;
+++-				$topic_list .= '<a href="' . append_sid(generate_board_url() . '/viewtopic.php', "t={$topic_id}") . '" ' . ($this->config['subject_check_pop'] ? ' onclick="this.target=\'_blank\';"' : '') . '>&bull; ' . $forum_name . $topic_title . '</a>';
++++				$topic_list .= '<a href="' . append_sid(generate_board_url() . '/viewtopic.' . $this->php_ext . '?t=' . $topic_id) . '" ' . ($this->config['subject_check_pop'] ? ' onclick="this.target=\'_blank\';"' : '') . '>&bull; ' . $forum_name . $topic_title . '</a>';
+++ 				if ($this->ext_manager->is_enabled('sitesplat/bbtpreview'))
+++ 				{
+++ 					$topic_list .= '<a data-toggle="modal" data-id="' . $topic_id . '" href="#BBTPreviewDialog" class="btn btn-xs open-bbtpreview hidden-xs" title=""><i class="fa fa-search-plus"></i></a><span class="visible-xs"><a data-toggle="modal" data-id="' . $topic_id . '" href="#BBTPreviewDialog" class="btn-xs open-bbtpreview" title="">' . $this->user->lang('PREVIEW') . '</a></span
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/event/main_listener.php"
++index 6beb1d5c6..68f3c393f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/event/main_listener.php"
++@@ -34,6 +34,7 @@ class main_listener implements EventSubscriberInterface
++ 	protected $config;
++ 	private $subject;
++ 	private $bypass;
+++	private $checked;
++ 	public function __construct(\sitesplat\subjectcheck\core\subject_check $subject_check, \phpbb\template\template $template, \phpbb\user $user, \phpbb\controller\helper $helper, \phpbb\config\config $config)
++ 	{
++ 		$this->subject_check = $subject_check;
++@@ -45,7 +46,14 @@ class main_listener implements EventSubscriberInterface
++ 
++ 	public function check_subject($event)
++ 	{
+++		$can_bypass = false;
+++		if((int) $this->config['subject_check_bypass'] === 1 && $this->config['subject_check_ajax']) return;
+++		if((int) $this->config['subject_check_bypass'] === 2 && $this->config['subject_check_ajax']) {
+++			$can_bypass = $this->subject_check->can_bypass($event);
+++		}
+++		if($can_bypass) return;
++ 		list($this->subject, $this->bypass) = $this->subject_check->look_for_posts($event);
+++		if($this->bypass) $this->subject = '';
++ 	}
++ 
++ 	public function setup_ajax_bypass($event)
++@@ -57,7 +65,7 @@ class main_listener implements EventSubscriberInterface
++ 				$this->user->add_lang_ext('sitesplat/subjectcheck', 'common');
++ 				$this->template->assign_vars(array(
++ 					'U_PRIME_SUBJECT_CHECK_AJAX'	=> $this->helper->route('sitesplat_subjectcheck_controller', array('forum_id' => $event['forum_id'], 'a' => '1')),
++-					'S_BYPASS_OPTION'				=> $this->config['subject_check_bypass'],
+++					'S_BYPASS_OPTION'		=> $this->config['subject_check_bypass'],
++ 				));
++ 			}
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/language/en/common.php"
++index 9bdc4de60..0e8c9174a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/language/en/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/language/en/common.php"
++@@ -24,8 +24,12 @@ $lang = array_merge($lang, array(
++ 		2	=> 'The subject of your topic is similar to existing topics. Please check them out and/or reply there instead of creating a new topic.',
++ 	),
++ 	'SUBJECT_CHECK_STRICT_TOPIC'	=> array(
++-		1	=> 'The subject of your topic is similar to an existing topic. Please reply to this instead of creating a new topic.',
++-		2	=> 'The subject of your topic is similar to existing topics. Please reply to the one that most closely matches your message instead of creating a new topic.',
+++		1	=> 'The subject of your topic is an exact match of an existing topic. Please reply to this instead of creating a new topic.',
+++		2	=> 'The subject of your topic is an exact match of existing topics. Please reply to the one that most closely matches your message instead of creating a new topic.',
+++	),
+++	'SUBJECT_CHECK_EXACT_TOPIC'	=> array(
+++		1	 => 'The subject of your topic is one exact match of an existing topic. Please reply to that o
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\subjectcheck/event/main_listener.php" "[FORUM_EXT]/sitesplat\\subjectcheck/event/main_listener.php"
--- "[ORIGINAL]/sitesplat\\subjectcheck/event/main_listener.php"
+++ "[FORUM_EXT]/sitesplat\\subjectcheck/event/main_listener.php"
@@ -34,6 +34,7 @@ class main_listener implements EventSubscriberInterface
 	protected $config;
 	private $subject;
 	private $bypass;
+	private $checked;
 	public function __construct(\sitesplat\subjectcheck\core\subject_check $subject_check, \phpbb\template\template $template, \phpbb\user $user, \phpbb\controller\helper $helper, \phpbb\config\config $config)
 	{
 		$this->subject_check = $subject_check;
@@ -45,7 +46,14 @@ class main_listener implements EventSubscriberInterface
 
 	public function check_subject($event)
 	{
+		$can_bypass = false;
+		if((int) $this->config['subject_check_bypass'] === 1 && $this->config['subject_check_ajax']) return;
+		if((int) $this->config['subject_check_bypass'] === 2 && $this->config['subject_check_ajax']) {
+			$can_bypass = $this->subject_check->can_bypass($event);
+		}
+		if($can_bypass) return;
 		list($this->subject, $this->bypass) = $this->subject_check->look_for_posts($event);
+		if($this->bypass) $this->subject = '';
 	}
 
 	public function setup_ajax_bypass($event)
diff --git "[ORIGINAL]/sitesplat\\subjectcheck/language/en/common.php" "[FORUM_EXT]/sitesplat\\subjectcheck/language/en/common.php"
--- "[ORIGINAL]/sitesplat\\subjectcheck/language/en/common.php"
+++ "[FORUM_EXT]/sitesplat\\subjectcheck/language/en/common.php"
@@ -24,8 +24,12 @@ $lang = array_merge($lang, array(
 		2	=> 'The subject of your topic is similar to existing topics. Please check them out and/or reply there instead of creating a new topic.',
 	),
 	'SUBJECT_CHECK_STRICT_TOPIC'	=> array(
-		1	=> 'The subject of your topic is similar to an existing topic. Please reply to this instead of creating a new topic.',
-		2	=> 'The subject of your topic is similar to existing topics. Please reply to the one that most closely matches your message instead of creating a new topic.',
+		1	=> 'The subject of your topic is an exact match of an existing topic. Please reply to this instead of creating a new topic.',
+		2	=> 'The subject of your topic is an exact match of existing topics. Please reply to the one that most closely matches your message instead of creating a new topic.',
+	),
+	'SUBJECT_CHECK_EXACT_TOPIC'	=> array(
+		1	 => 'The subject of your topic is one exact match of an existing topic. Please reply to that one instead of creating a new topic.',
+		2	=> 'The subject of your topic has more then one exact match of existing topics. Please reply to the one that most closely matches your message instead of creating a new topic.',
 	),
 
 	// One of these two strings will be appended to the above strings, so they need a leading space or some other separator.
diff --git "[ORIGINAL]/sitesplat\\subjectcheck/language/en/info_acp_subject_check.php" "[FORUM_EXT]/sitesplat\\subjectcheck/language/en/info_acp_subject_check.php"
--- "[ORIGINAL]/sitesplat\\subjectcheck/language/en/info_acp_subject_check.php"
+++ "[FORUM_EXT]/sitesplat\\subjectcheck/language/en/info_acp_subject_check.php"
@@ -55,7 +55,7 @@ $lang = array_merge($lang, array(
 	
 	'ACP_SUBCHECK_SETTINGS'		    => 'Settings',
 	'ACP_SUBCHECK'					=> 'Subject Check',
-	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
 	'SUBCHECK_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Don\'t forget to check/set the permission for each forum if need be. <strong>ACP &#187; FORUMS &#187; Edit forum &#187; Enable subject check</strong></p></div>',
 
 	// ACP labels for individual forums
diff --git "[ORIGINAL]/sitesplat\\subjectcheck/styles/FLATBOOTS/template/event/posting_editor_subject_after.html" "[FORUM_EXT]/sitesplat\\subjectcheck/styles/FLATBOOTS/template/event/ss_posting_editor_subject_before.html"
similarity index 94%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\subjectcheck/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\subjectcheck/styles/FLATBOOTS/template/event/ss_posting_editor_subject_before.html"
--- "[ORIGINAL]/sitesplat\\subjectcheck/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
+++ "[FORUM_EXT]/sitesplat\\subjectcheck/styles/FLATBOOTS/template/event/ss_posting_editor_subject_before.html"
@@ -53,7 +53,7 @@
 		}
 		var obj_r = document.getElementById('prime_subject_check_ajax_results');
 		var obj_d = document.getElementById('prime_subject_check_ajax_display');
-		obj_r.innerHTML = '{{ lang('SUBJECT_CHECK_WORKING') }}';
+		obj_r.innerHTML = "{{ lang('SUBJECT_CHECK_WORKING') }}";
 		obj_d.style.display = '';
 		postform.subject_checked.value = subject;
 
@@ -95,12 +95,6 @@
 		postform.onsubmit = function() {
 			var result = prime_subject_check(true),
 				msg = document.getElementById('prime_subject_check_ajax_results').innerHTML;
-
-			if (!result && msg && (msg = msg.replace(/<br ?\/?>.*/i, "").replace(/(<([^>]+)>)/ig, "")))
-			{
-				alert(msg)
-			}
-			return result;
 		}
 
 		var subject_obj = document.getElementById('subject') || document.getElementsByName('subject')[0];
```
