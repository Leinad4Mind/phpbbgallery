Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\bbprefix/core/manager.php" "[FORUM_EXT]/sitesplat\\bbprefix/core/manager.php"
--- "[ORIGINAL]/sitesplat\\bbprefix/core/manager.php"
+++ "[FORUM_EXT]/sitesplat\\bbprefix/core/manager.php"
@@ -47,8 +47,10 @@ class manager
 	 */
 	public function load_prefixes($refresh = false)
 	{
+		try {
 			if (false === ($this->prefixes = $this->cache->get('_prefixes')) || $refresh)
 			{
+				// $this->cache->destroy('_prefixes');
 				// If we're refreshing, we have to reset the array first
 				$this->prefixes = [];
 				$sql = 'SELECT id, prefix, name, forums, groups, on_index, bbcode_uid, bbcode_bitfield FROM ' . BBPREFIX_TABLE;
@@ -71,6 +73,11 @@ class manager
 				$this->prefixes = $this->get_prefixes_atributes($this->prefixes);
 				$this->cache->put('_prefixes', $this->prefixes);
 			}
+		} catch (Exception $e) {
+			// Log any exceptions
+			$this->log('Error loading prefixes: ' . $e->getMessage());
+			$this->log('prefixes: ' . $this->prefixes);
+		}
 
 		return $this;
 	}
@@ -100,16 +107,23 @@ class manager
 		
 		foreach($this->prefix_keys as $prefix)
 		{
+			if (isset($prefix['groups'])) {
 				foreach (json_decode($prefix['groups'], true) as $key)
 				{
 					$this->prefix_keys[$prefix['id']]['groupnames'][] = $this->group_names[$key];
 				}
-
-
+			}
+			if (isset($prefix['forums'])) {
 				foreach (json_decode($prefix['forums'], true) as $key)
 				{
+					if (isset($this->forum_names[$key])) {
 						$this->prefix_keys[$prefix['id']]['forumnames'][] = $this->forum_names[$key];
 					}
+					else {
+						error_log("Forum name index not found: " . $key);
+					}
+				}
+			}
 		}
 		return $this->prefix_keys;
 	}
@@ -164,8 +178,10 @@ class manager
 	 */
 	public function load_prefix_instances($refresh = false)
 	{
+		try {
 			if (false === ($this->prefix_instances = $this->cache->get('_prefixes_used')) || $refresh)
 			{
+				// $this->cache->destroy('_prefixes_used');
 				// If we're refreshing, we have to reset the array first
 				$this->prefix_instances = [];
 				$sql = 'SELECT id, prefix, topic, ordered, token_data FROM ' . BBPREFIX_INSTANCES_TABLE;
@@ -184,10 +200,22 @@ class manager
 
 				$this->cache->put('_prefixes_used', $this->prefix_instances);
 			}
+		} catch (Exception $e) {
+			// Log any exceptions
+			$this->log('Error loading prefix instances: ' . $e->getMessage());
+			$this->log('prefixes_used (instances): ' . $this->prefix_instances);
+		}
 
 		return $this;
 	}
 
+	private function log($message)
+	{
+		// Log to a file or any other preferred logging mechanism
+		$logFile = 'file.log';
+		error_log(date('[Y-m-d H:i:s]') . ' ' . $message . PHP_EOL, 3, $logFile);
+	}
+
 	/**
 	 * Get the array of prefix instances
 	 *
@@ -214,7 +242,7 @@ class manager
 	 *								otherwise, it is the plaintext version
 	 * @return	string	Plaintext string of a topic's prefixes
 	 */
-	public function load_prefixes_topic($topic_id, $block = '', $return_parsed = false)
+	public function load_prefixes_topic($topic_id, $block = '', $return_parsed = false, $forum_id = 0)
 	{
 		// If there aren't any instantiated prefixes, the topic won't have any
 		// to load, so let's just stop right here
@@ -250,7 +278,7 @@ class manager
 			// A URL to a viewforum view filtered by the prefix
 			if ($this->request->variable('f', 0))
 			{
-				$vars['URL'] = append_sid($this->root_path . 'viewforum.php', ['f' => $this->request->variable('f', 0), 'prefix' => $instance['prefix']]);
+				$vars['URL'] = append_sid($this->root_path . 'viewforum.php', ['f' => $forum_id ? $forum_id : $this->request->variable('f', 0), 'prefix' => $instance['prefix']]);
 			}
 			$return_string .= $instance->parse($block, $vars, $return_parsed) . '&nbsp;';
 		}
diff --git "[FORUM_EXT]/sitesplat\\bbprefix/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bbprefix/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbprefix/diff_full.tmp"
@@ -0,0 +1,316 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprefix/core/manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/core/manager.php"
+index 3ede6827f..d6c0c718a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprefix/core/manager.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/core/manager.php"
+@@ -47,29 +47,36 @@ class manager
+ 	 */
+ 	public function load_prefixes($refresh = false)
+ 	{
+-		if (false === ($this->prefixes = $this->cache->get('_prefixes')) || $refresh)
+-		{
+-			// If we're refreshing, we have to reset the array first
+-			$this->prefixes = [];
+-			$sql = 'SELECT id, prefix, name, forums, groups, on_index, bbcode_uid, bbcode_bitfield FROM ' . BBPREFIX_TABLE;
+-			$result = $this->db->sql_query($sql);
+-			while ($row = $this->db->sql_fetchrow($result))
++		try {
++			if (false === ($this->prefixes = $this->cache->get('_prefixes')) || $refresh)
+ 			{
+-				$this->prefixes[$row['id']] = [
+-					'id'				=> $row['id'],
+-					'prefix'			=> $row['prefix'],
+-					'name'				=> $row['name'],
+-					'forums'			=> $row['forums'],
+-					'groups'			=> $row['groups'],
+-					'on_index'			=> $row['on_index'],
+-					'bbcode_uid'		=> $row['bbcode_uid'],
+-					'bbcode_bitfield'	=> $row['bbcode_bitfield'],
+-				];
+-			}
+-			$this->db->sql_freeresult($result);
++				// $this->cache->destroy('_prefixes');
++				// If we're refreshing, we have to reset the array first
++				$this->prefixes = [];
++				$sql = 'SELECT id, prefix, name, forums, groups, on_index, bbcode_uid, bbcode_bitfield FROM ' . BBPREFIX_TABLE;
++				$result = $this->db->sql_query($sql);
++				while ($row = $this->db->sql_fetchrow($result))
++				{
++					$this->prefixes[$row['id']] = [
++						'id'				=> $row['id'],
++						'prefix'			=> $row['prefix'],
++						'name'				=> $row['name'],
++						'forums'			=> $row['forums'],
++						'groups'			=> $row['groups'],
++						'on_index'			=> $row['on_index'],
++						'bbcode_uid'		=> $row['bbcode_uid'],
++						'bbcode_bitfield'	=> $row['bbcode_bitfield'],
++					];
++				}
++				$this->db->sql_freeresult($result);
+ 
+-			$this->prefixes = $this->get_prefixes_atributes($this->prefixes);
+-			$this->cache->put('_prefixes', $this->prefixes);
++				$this->prefixes = $this->get_prefixes_atributes($this->prefixes);
++				$this->cache->put('_prefixes', $this->prefixes);
++			}
++		} catch (Exception $e) {
++			// Log any exceptions
++			$this->log('Error loading prefixes: ' . $e->getMessage());
++			$this->log('prefixes: ' . $this->prefixes);
+ 		}
+ 
+ 		return $this;
+@@ -100,15 +107,22 @@ class manager
+ 		
+ 		foreach($this->prefix_keys as $prefix)
+ 		{
+-			foreach (json_decode($prefix['groups'], true) as $key)
+-			{
+-				$this->prefix_keys[$prefix['id']]['groupnames'][] = $this->group_names[$key];
++			if (isset($prefix['groups'])) {
++				foreach (json_decode($prefix['groups'], true) as $key)
++				{
++					$this->prefix_keys[$prefix['id']]['groupnames'][] = $this->group_names[$key];
++				}
+ 			}
+-
+-
+-			foreach (json_decode($prefix['forums'], true) as $key)
+-			{
+-				$this->prefix_keys[$prefix['id']]['forumnames'][] = $this->forum_names[$key];
++			if (isset($prefix['forums'])) {
++				foreach (json_decode($prefix['forums'], true) as $key)
++				{
++					if (isset($this->forum_names[$key])) {
++						$this->prefix_keys[$prefix['id']]['forumnames'][] = $this->forum_names[$key];
++					}
++					else {
++						error_log("Forum name index not found: " . $key);
++					}
++				}
+ 			}
+ 		}
+ 		return $this->prefix_keys;
+@@ -164,30 +178,44 @@ class manager
+ 	 */
+ 	public function load_prefix_instances($refresh = false)
+ 	{
+-		if (false === ($this->prefix_instances = $this->cache->get('_prefixes_used')) || $refresh)
+-		{
+-			// If we're refreshing, we have to reset the array first
+-			$this->prefix_instances = [];
+-			$sql = 'SELECT id, prefix, topic, ordered, token_data FROM ' . BBPREFIX_INSTANCES_TABLE;
+-			$result = $this->db->sql_query($sql);
+-			while ($row = $this->db->sql_fetchrow($result))
++		try {
++			if (false === ($this->prefix_instances = $this->cache->get('_prefixes_used')) || $refresh)
+ 			{
+-				$this->prefix_instances[$row['id']] = [
+-					'id'			=> $row['id'],
+-					'prefix'		=> $row['prefix'],
+-					'topic'			=> $row['topic'],
+-					'ordered'		=> $row['ordered'],
+-					'token_data'	=> $row['token_data'],
+-				];
+-			}
+-			$this->db->sql_freeresult($result);
++				// $this->cache->destroy('_prefixes_used');
++				// If we're refreshing, we have to reset the array first
++				$this->prefix_instances = [];
++				$sql = 'SELECT id, prefix, topic, ordered, token_data FROM ' . BBPREFIX_INSTANCES_TABLE;
++				$result = $this->db->sql_query($sql);
++				while ($row = $this->db->sql_fetchrow($result))
++				{
++					$this->prefix_instances[$row['id']] = [
++						'id'			=> $row['id'],
++						'prefix'		=> $row['prefix'],
++						'topic'			=> $row['topic'],
++						'ordered'		=> $row['ordered'],
++						'token_data'	=> $row['token_data'],
++					];
++				}
++				$this->db->sql_freeresult($result);
+ 
+-			$this->cache->put('_prefixes_used', $this->prefix_instances);
++				$this->cache->put('_prefixes_used', $this->prefix_instances);
++			}
++		} catch (Exception $e) {
++			// Log any exceptions
++			$this->log('Error loading prefix instances: ' . $e->getMessage());
++			$this->log('prefixes_used (instances): ' . $this->prefix_instances);
+ 		}
+ 
+ 		return $this;
+ 	}
+ 
++	private function log($message)
++	{
++		// Log to a file or any other preferred logging mechanism
++		$logFile = 'file.log';
++		error_log(date('[Y-m-d H:i:s]') . ' ' . $message . PHP_EOL, 3, $logFile);
++	}
++
+ 	/**
+ 	 * Get the array of prefix instances
+ 	 *
+@@ -214,7 +242,7 @@ class manager
+ 	 *								otherwise, it is the plaintext version
+ 	 * @return	string	Plaintext string of a topic's prefixes
+ 	 */
+-	public function load_prefixes_topic($topic_id, $block = '', $return_parsed = false)
++	public function load_prefixes_topic($topic_id, $block = '', $return_parsed = false, $forum_id = 0)
+ 	{
+ 		// If there aren't any instantiated prefixes, the topic won't have any
+ 		// to load, so let's just stop right here
+@@ -250,7 +278,7 @@ class manager
+ 			// A URL to a viewforum view filtered by the prefix
+ 			if ($this->request->variable('f', 0))
+ 			{
+-				$vars['URL'] = append_sid($this->root_path . 'viewforum.php', ['f' => $this->request->variable('f', 0), 'prefix' => $instance['prefix']]);
++				$vars['URL'] = append_sid($this->root_path . 'viewforum.php', ['f' => $forum_id ? $forum_id : $this->request->variable('f', 0), 'prefix' => $instance['prefix']]);
+ 			}
+ 			$return_string .= $instance->parse($block, $vars, $return_parsed) . '&nbsp;';
+ 		}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/diff_full.tmp"
+new file mode 100644
+index 000000000..c129216a1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/diff_full.tmp"
+@@ -0,0 +1,105 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprefix/core/manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/core/manager.php"
++index 3ede6827f..d6c0c718a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprefix/core/manager.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/core/manager.php"
++@@ -47,29 +47,36 @@ class manager
++ 	 */
++ 	public function load_prefixes($refresh = false)
++ 	{
++-		if (false === ($this->prefixes = $this->cache->get('_prefixes')) || $refresh)
++-		{
++-			// If we're refreshing, we have to reset the array first
++-			$this->prefixes = [];
++-			$sql = 'SELECT id, prefix, name, forums, groups, on_index, bbcode_uid, bbcode_bitfield FROM ' . BBPREFIX_TABLE;
++-			$result = $this->db->sql_query($sql);
++-			while ($row = $this->db->sql_fetchrow($result))
+++		try {
+++			if (false === ($this->prefixes = $this->cache->get('_prefixes')) || $refresh)
++ 			{
++-				$this->prefixes[$row['id']] = [
++-					'id'				=> $row['id'],
++-					'prefix'			=> $row['prefix'],
++-					'name'				=> $row['name'],
++-					'forums'			=> $row['forums'],
++-					'groups'			=> $row['groups'],
++-					'on_index'			=> $row['on_index'],
++-					'bbcode_uid'		=> $row['bbcode_uid'],
++-					'bbcode_bitfield'	=> $row['bbcode_bitfield'],
++-				];
++-			}
++-			$this->db->sql_freeresult($result);
+++				// $this->cache->destroy('_prefixes');
+++				// If we're refreshing, we have to reset the array first
+++				$this->prefixes = [];
+++				$sql = 'SELECT id, prefix, name, forums, groups, on_index, bbcode_uid, bbcode_bitfield FROM ' . BBPREFIX_TABLE;
+++				$result = $this->db->sql_query($sql);
+++				while ($row = $this->db->sql_fetchrow($result))
+++				{
+++					$this->prefixes[$row['id']] = [
+++						'id'				=> $row['id'],
+++						'prefix'			=> $row['prefix'],
+++						'name'				=> $row['name'],
+++						'forums'			=> $row['forums'],
+++						'groups'			=> $row['groups'],
+++						'on_index'			=> $row['on_index'],
+++						'bbcode_uid'		=> $row['bbcode_uid'],
+++						'bbcode_bitfield'	=> $row['bbcode_bitfield'],
+++					];
+++				}
+++				$this->db->sql_freeresult($result);
++ 
++-			$this->prefixes = $this->get_prefixes_atributes($this->prefixes);
++-			$this->cache->put('_prefixes', $this->prefixes);
+++				$this->prefixes = $this->get_prefixes_atributes($this->prefixes);
+++				$this->cache->put('_prefixes', $this->prefixes);
+++			}
+++		} catch (Exception $e) {
+++			// Log any exceptions
+++			$this->log('Error loading prefixes: ' . $e->getMessage());
+++			$this->log('prefixes: ' . $this->prefixes);
++ 		}
++ 
++ 		return $this;
++@@ -100,15 +107,22 @@ class manager
++ 		
++ 		foreach($this->prefix_keys as $prefix)
++ 		{
++-			foreach (json_decode($prefix['groups'], true) as $key)
++-			{
++-				$this->prefix_keys[$prefix['id']]['groupnames'][] = $this->group_names[$key];
+++			if (isset($prefix['groups'])) {
+++				foreach (json_decode($prefix['groups'], true) as $key)
+++				{
+++					$this->prefix_keys[$prefix['id']]['groupnames'][] = $this->group_names[$key];
+++				}
++ 			}
++-
++-
++-			foreach (json_decode($prefix['forums'], true) as $key)
++-			{
++-				$this->prefix_keys[$prefix['id']]['forumnames'][] = $this->forum_names[$key];
+++			if (isset($prefix['forums'])) {
+++				foreach (json_decode($prefix['forums'], true) as $key)
+++				{
+++					if (isset($this->forum_names[$key])) {
+++						$this->prefix_keys[$prefix['id']]['forumnames'][] = $this->forum_names[$key];
+++					}
+++					else {
+++						error_log("Forum name index not found: " . $key);
+++					}
+++				}
++ 			}
++ 		}
++ 		return $this->prefix_keys;
++@@ -164,30 +178,44 @@ class manager
++ 	 */
++ 	public function load_prefix_instances($refresh = false)
++ 	{
++-		if (false === ($this->prefix_instances = $this->cache->get('_prefixes_used')) || $refresh)
++-		{
++-			// If we're refreshing, we have to reset the array first
++-			$this->prefix_instances = [];
++-			$sql = 'SELECT id, prefix, topic, ordered, token_data FROM ' . BBPREFIX_INSTANCES_TABLE;
++-			$result = $this->db->sql_query($sql);
++-			while ($row = $this->db->sql_fetchrow($result))
+++	
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprefix/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/event/listener.php"
+index aafaac7c2..de3896874 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprefix/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/event/listener.php"
+@@ -39,7 +39,7 @@ class listener implements EventSubscriberInterface
+ 			'core.pagination_generate_page_link'		=> 'fix_viewforum_base_url',
+ 			'core.display_forums_modify_sql'			=> 'modify_forumlist_sql',
+ 			'core.display_forums_modify_template_vars'	=> 'get_forumlist_topic_prefixes',
+-			'core.search_modify_tpl_ary'				=> 'get_searchlist_topic_prefixes', 
++			'core.search_modify_tpl_ary'				=> 'get_searchlist_topic_prefixes',
+ 		];
+ 	}
+ 
+@@ -212,13 +212,16 @@ class listener implements EventSubscriberInterface
+ 			}
+ 
+ 			// LEFT JOIN will mess up topic count, so use CROSS JOIN
+-			$sql_ary['FROM'] += [BBPREFIX_INSTANCES_TABLE => 'pr'];
++			// $sql_ary['FROM'] += [BBPREFIX_INSTANCES_TABLE => 'pr'];
+ 
+ 			// reset topic count
+ 			$cnt_ary = $sql_ary;
+ 			$cnt_ary['SELECT'] = 'COUNT(topic_id) AS cnt';
++			// Leinad4Mind Change - Improve SQL a LOT
++			$cnt_ary['FROM'] += [BBPREFIX_INSTANCES_TABLE => 'pr'];
+ 			$cnt_ary['WHERE'] .= " AND t.forum_id = {$event['forum_id']}";
+ 			$sql = $this->db->sql_build_query('SELECT', $cnt_ary);
++
+ 			$result = $this->db->sql_query($sql);
+ 			$event['topics_count'] = (int) $this->db->sql_fetchfield('cnt');
+ 			$this->db->sql_freeresult($result);
diff --git "[FORUM_EXT]/sitesplat\\bbprefix/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bbprefix/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbprefix/diff_nospace.tmp"
@@ -0,0 +1,399 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprefix/core/manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/core/manager.php"
+index 3ede6827f..d6c0c718a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprefix/core/manager.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/core/manager.php"
+@@ -47,8 +47,10 @@ class manager
+ 	 */
+ 	public function load_prefixes($refresh = false)
+ 	{
++		try {
+ 			if (false === ($this->prefixes = $this->cache->get('_prefixes')) || $refresh)
+ 			{
++				// $this->cache->destroy('_prefixes');
+ 				// If we're refreshing, we have to reset the array first
+ 				$this->prefixes = [];
+ 				$sql = 'SELECT id, prefix, name, forums, groups, on_index, bbcode_uid, bbcode_bitfield FROM ' . BBPREFIX_TABLE;
+@@ -71,6 +73,11 @@ class manager
+ 				$this->prefixes = $this->get_prefixes_atributes($this->prefixes);
+ 				$this->cache->put('_prefixes', $this->prefixes);
+ 			}
++		} catch (Exception $e) {
++			// Log any exceptions
++			$this->log('Error loading prefixes: ' . $e->getMessage());
++			$this->log('prefixes: ' . $this->prefixes);
++		}
+ 
+ 		return $this;
+ 	}
+@@ -100,16 +107,23 @@ class manager
+ 		
+ 		foreach($this->prefix_keys as $prefix)
+ 		{
++			if (isset($prefix['groups'])) {
+ 				foreach (json_decode($prefix['groups'], true) as $key)
+ 				{
+ 					$this->prefix_keys[$prefix['id']]['groupnames'][] = $this->group_names[$key];
+ 				}
+-
+-
++			}
++			if (isset($prefix['forums'])) {
+ 				foreach (json_decode($prefix['forums'], true) as $key)
+ 				{
++					if (isset($this->forum_names[$key])) {
+ 						$this->prefix_keys[$prefix['id']]['forumnames'][] = $this->forum_names[$key];
+ 					}
++					else {
++						error_log("Forum name index not found: " . $key);
++					}
++				}
++			}
+ 		}
+ 		return $this->prefix_keys;
+ 	}
+@@ -164,8 +178,10 @@ class manager
+ 	 */
+ 	public function load_prefix_instances($refresh = false)
+ 	{
++		try {
+ 			if (false === ($this->prefix_instances = $this->cache->get('_prefixes_used')) || $refresh)
+ 			{
++				// $this->cache->destroy('_prefixes_used');
+ 				// If we're refreshing, we have to reset the array first
+ 				$this->prefix_instances = [];
+ 				$sql = 'SELECT id, prefix, topic, ordered, token_data FROM ' . BBPREFIX_INSTANCES_TABLE;
+@@ -184,10 +200,22 @@ class manager
+ 
+ 				$this->cache->put('_prefixes_used', $this->prefix_instances);
+ 			}
++		} catch (Exception $e) {
++			// Log any exceptions
++			$this->log('Error loading prefix instances: ' . $e->getMessage());
++			$this->log('prefixes_used (instances): ' . $this->prefix_instances);
++		}
+ 
+ 		return $this;
+ 	}
+ 
++	private function log($message)
++	{
++		// Log to a file or any other preferred logging mechanism
++		$logFile = 'file.log';
++		error_log(date('[Y-m-d H:i:s]') . ' ' . $message . PHP_EOL, 3, $logFile);
++	}
++
+ 	/**
+ 	 * Get the array of prefix instances
+ 	 *
+@@ -214,7 +242,7 @@ class manager
+ 	 *								otherwise, it is the plaintext version
+ 	 * @return	string	Plaintext string of a topic's prefixes
+ 	 */
+-	public function load_prefixes_topic($topic_id, $block = '', $return_parsed = false)
++	public function load_prefixes_topic($topic_id, $block = '', $return_parsed = false, $forum_id = 0)
+ 	{
+ 		// If there aren't any instantiated prefixes, the topic won't have any
+ 		// to load, so let's just stop right here
+@@ -250,7 +278,7 @@ class manager
+ 			// A URL to a viewforum view filtered by the prefix
+ 			if ($this->request->variable('f', 0))
+ 			{
+-				$vars['URL'] = append_sid($this->root_path . 'viewforum.php', ['f' => $this->request->variable('f', 0), 'prefix' => $instance['prefix']]);
++				$vars['URL'] = append_sid($this->root_path . 'viewforum.php', ['f' => $forum_id ? $forum_id : $this->request->variable('f', 0), 'prefix' => $instance['prefix']]);
+ 			}
+ 			$return_string .= $instance->parse($block, $vars, $return_parsed) . '&nbsp;';
+ 		}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/diff_full.tmp"
+new file mode 100644
+index 000000000..f24999494
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/diff_full.tmp"
+@@ -0,0 +1,316 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprefix/core/manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/core/manager.php"
++index 3ede6827f..d6c0c718a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprefix/core/manager.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/core/manager.php"
++@@ -47,29 +47,36 @@ class manager
++ 	 */
++ 	public function load_prefixes($refresh = false)
++ 	{
++-		if (false === ($this->prefixes = $this->cache->get('_prefixes')) || $refresh)
++-		{
++-			// If we're refreshing, we have to reset the array first
++-			$this->prefixes = [];
++-			$sql = 'SELECT id, prefix, name, forums, groups, on_index, bbcode_uid, bbcode_bitfield FROM ' . BBPREFIX_TABLE;
++-			$result = $this->db->sql_query($sql);
++-			while ($row = $this->db->sql_fetchrow($result))
+++		try {
+++			if (false === ($this->prefixes = $this->cache->get('_prefixes')) || $refresh)
++ 			{
++-				$this->prefixes[$row['id']] = [
++-					'id'				=> $row['id'],
++-					'prefix'			=> $row['prefix'],
++-					'name'				=> $row['name'],
++-					'forums'			=> $row['forums'],
++-					'groups'			=> $row['groups'],
++-					'on_index'			=> $row['on_index'],
++-					'bbcode_uid'		=> $row['bbcode_uid'],
++-					'bbcode_bitfield'	=> $row['bbcode_bitfield'],
++-				];
++-			}
++-			$this->db->sql_freeresult($result);
+++				// $this->cache->destroy('_prefixes');
+++				// If we're refreshing, we have to reset the array first
+++				$this->prefixes = [];
+++				$sql = 'SELECT id, prefix, name, forums, groups, on_index, bbcode_uid, bbcode_bitfield FROM ' . BBPREFIX_TABLE;
+++				$result = $this->db->sql_query($sql);
+++				while ($row = $this->db->sql_fetchrow($result))
+++				{
+++					$this->prefixes[$row['id']] = [
+++						'id'				=> $row['id'],
+++						'prefix'			=> $row['prefix'],
+++						'name'				=> $row['name'],
+++						'forums'			=> $row['forums'],
+++						'groups'			=> $row['groups'],
+++						'on_index'			=> $row['on_index'],
+++						'bbcode_uid'		=> $row['bbcode_uid'],
+++						'bbcode_bitfield'	=> $row['bbcode_bitfield'],
+++					];
+++				}
+++				$this->db->sql_freeresult($result);
++ 
++-			$this->prefixes = $this->get_prefixes_atributes($this->prefixes);
++-			$this->cache->put('_prefixes', $this->prefixes);
+++				$this->prefixes = $this->get_prefixes_atributes($this->prefixes);
+++				$this->cache->put('_prefixes', $this->prefixes);
+++			}
+++		} catch (Exception $e) {
+++			// Log any exceptions
+++			$this->log('Error loading prefixes: ' . $e->getMessage());
+++			$this->log('prefixes: ' . $this->prefixes);
++ 		}
++ 
++ 		return $this;
++@@ -100,15 +107,22 @@ class manager
++ 		
++ 		foreach($this->prefix_keys as $prefix)
++ 		{
++-			foreach (json_decode($prefix['groups'], true) as $key)
++-			{
++-				$this->prefix_keys[$prefix['id']]['groupnames'][] = $this->group_names[$key];
+++			if (isset($prefix['groups'])) {
+++				foreach (json_decode($prefix['groups'], true) as $key)
+++				{
+++					$this->prefix_keys[$prefix['id']]['groupnames'][] = $this->group_names[$key];
+++				}
++ 			}
++-
++-
++-			foreach (json_decode($prefix['forums'], true) as $key)
++-			{
++-				$this->prefix_keys[$prefix['id']]['forumnames'][] = $this->forum_names[$key];
+++			if (isset($prefix['forums'])) {
+++				foreach (json_decode($prefix['forums'], true) as $key)
+++				{
+++					if (isset($this->forum_names[$key])) {
+++						$this->prefix_keys[$prefix['id']]['forumnames'][] = $this->forum_names[$key];
+++					}
+++					else {
+++						error_log("Forum name index not found: " . $key);
+++					}
+++				}
++ 			}
++ 		}
++ 		return $this->prefix_keys;
++@@ -164,30 +178,44 @@ class manager
++ 	 */
++ 	public function load_prefix_instances($refresh = false)
++ 	{
++-		if (false === ($this->prefix_instances = $this->cache->get('_prefixes_used')) || $refresh)
++-		{
++-			// If we're refreshing, we have to reset the array first
++-			$this->prefix_instances = [];
++-			$sql = 'SELECT id, prefix, topic, ordered, token_data FROM ' . BBPREFIX_INSTANCES_TABLE;
++-			$result = $this->db->sql_query($sql);
++-			while ($row = $this->db->sql_fetchrow($result))
+++		try {
+++			if (false === ($this->prefix_instances = $this->cache->get('_prefixes_used')) || $refresh)
++ 			{
++-				$this->prefix_instances[$row['id']] = [
++-					'id'			=> $row['id'],
++-					'prefix'		=> $row['prefix'],
++-					'topic'			=> $row['topic'],
++-					'ordered'		=> $row['ordered'],
++-					'token_data'	=> $row['token_data'],
++-				];
++-			}
++-			$this->db->sql_freeresult($result);
+++				// $this->cache->destroy('_prefixes_used');
+++				// If we're refreshing, we have to reset the array first
+++				$this->prefix_instances = [];
+++				$sql = 'SELECT id, prefix, topic, ordered, token_data FROM ' . BBPREFIX_INSTANCES_TABLE;
+++				$result = $this->db->sql_query($sql);
+++				while ($row = $this->db->sql_fetchrow($result))
+++				{
+++					$this->prefix_instances[$row['id']] = [
+++						'id'			=> $row['id'],
+++						'prefix'		=> $row['prefix'],
+++						'topic'			=> $row['topic'],
+++						'ordered'		=> $row['ordered'],
+++						'token_data'	=> $row['token_data'],
+++					];
+++				}
+++				$this->db->sql_freeresult($result);
++ 
++-			$this->cache->put('_prefixes_used', $this->prefix_instances);
+++				$this->cache->put('_prefixes_used', $this->prefix_instances);
+++			}
+++		} catch (Exception $e) {
+++			// Log any exceptions
+++			$this->log('Error loading prefix instances: ' . $e->getMessage());
+++			$this->log('prefixes_used (instances): ' . $this->prefix_instances);
++ 		}
++ 
++ 		return $this;
++ 	}
++ 
+++	private function log($message)
+++	{
+++		// Log to a file or any other preferred logging mechanism
+++		$logFile = 'file.log';
+++		error_log(date('[Y-m-d H:i:s]') . ' ' . $message . PHP_EOL, 3, $logFile);
+++	}
+++
++ 	/**
++ 	 * Get the array of prefix instances
++ 	 *
++@@ -214,7 +242,7 @@ class manager
++ 	 *								otherwise, it is the plaintext version
++ 	 * @return	string	Plaintext string of a topic's prefixes
++ 	 */
++-	public function load_prefixes_topic($topic_id, $block = '', $return_parsed = false)
+++	public function load_prefixes_topic($topic_id, $block = '', $return_parsed = false, $forum_id = 0)
++ 	{
++ 		// If there aren't any instantiated prefixes, the topic won't have any
++ 		// to load, so let's just stop right here
++@@ -250,7 +278,7 @@ class manager
++ 			// A URL to a viewforum view filtered by the prefix
++ 			if ($this->request->variable('f', 0))
++ 			{
++-				$vars['URL'] = append_sid($this->root_path . 'viewforum.php', ['f' => $this->request->variable('f', 0), 'prefix' => $instance['prefix']]);
+++				$vars['URL'] = append_sid($this->root_path . 'viewforum.php', ['f' => $forum_id ? $forum_id : $this->request->variable('f', 0), 'prefix' => $instance['prefix']]);
++ 			}
++ 			$return_string .= $instance->parse($block, $vars, $return_parsed) . '&nbsp;';
++ 		}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/diff_full.tmp"
++new file mode 100644
++index 000000000..c129216a1
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/diff_full.tmp"
++@@ -0,0 +1,105 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprefix/core/manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/core/manager.php"
+++index 3ede6827f..d6c0c718a 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprefix/core/manager.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/core/manager.php"
+++@@ -47,29 +47,36 @@ class manager
+++ 	 */
+++ 	public function load_prefixes($refresh = false)
+++ 	{
+++-		if (false === ($this->prefixes = $this->cache->get('_prefixes')) || $refresh)
+++-		{
+++-			// If we're refreshing, we have to reset the array first
+++-			$this->prefixes = [];
+++-			$sql = 'SELECT id, prefix, name, forums, groups, on_index, bbcode_uid, bbcode_bitfield FROM ' . BBPREFIX_TABLE;
+++-			$result = $this->db->sql_query($sql);
+++-			while ($row = $this->db->sql_fetchrow($result))
++++		try {
++++			if (false === ($this->prefixes = $this->cache->get('_prefixes')) || $refresh)
+++ 			{
+++-				$this->prefixes[$row['id']] = [
+++-					'id'				=> $row['id'],
+++-					'prefix'			=> $row['prefix'],
+++-					'name'				=> $row['name'],
+++-					'forums'			=> $row['forums'],
+++-					'groups'			=> $row['groups'],
+++-					'on_index'			=> $row['on_index'],
+++-					'bbcode_uid'		=> $row['bbcode_uid'],
+++-					'bbcode_bitfield'	=> $row['bbcode_bitfield'],
+++-				];
+++-			}
+++-			$this->db->sql_freeresult($result);
++++				// $this->cache->destroy('_prefixes');
++++				// If we're refreshing, we have to reset the array first
++++				$this->prefixes = [];
++++				$sql = 'SELECT id, prefix, name, forums, groups, on_index, bbcode_uid, bbcode_bitfield FROM ' . BBPREFIX_TABLE;
++++				$result = $this->db->sql_query($sql);
++++				while ($row = $this->db->sql_fetchrow($result))
++++				{
++++					$this->prefixes[$row['id']] = [
++++						'id'				=> $row['id'],
++++						'prefix'			=> $row['prefix'],
++++						'name'				=> $row['name'],
++++						'forums'			=> $row['forums'],
++++						'groups'			=> $row['groups'],
++++						'on_index'			=> $row['on_index'],
++++						'bbcode_uid'		=> $row['bbcode_uid'],
++++						'bbcode_bitfield'	=> $row['bbcode_bitfield'],
++++					];
++++				}
++++				$this->db->sql_freeresult($result);
+++ 
+++-			$this->prefixes = $this->get_prefixes_atributes($this->prefixes);
+++-			$this->cache->put('_prefixes', $this->prefixes);
++++				$this->prefixes = $this->get_prefixes_atributes($this->prefixes);
++++				$this->cache->put('_prefixes', $this->prefixes);
++++			}
++++		} catch (Exception $e) {
++++			// Log any exceptions
++++			$this->log('Error loading prefixes: ' . $e->getMessage());
++++			$this->log('prefixes: ' . $this->prefixes);
+++ 		}
+++ 
+++ 		return $this;
+++@@ -100,15 +107,22 @@ class manager
+++ 		
+++ 		foreach($this->prefix_keys as $prefix)
+++ 		{
+++-			foreach (json_decode($prefix['groups'], true) as $key)
+++-			{
+++-				$this->prefix_keys[$prefix['id']]['groupnames'][] = $this->group_names[$key];
++++			if (isset($prefix['groups'])) {
++++				foreach (json_decode($prefix['groups'], true) as $key)
++++				{
++++					$this->prefix_keys[$prefix['id']]['groupnames'][] = $this->group_names[$key];
++++				}
+++ 			}
+++-
+++-
+++-			foreach (json_decode($prefix['forums'], true) as $key)
+++-			{
+++-				$this->prefix_keys[$prefix['id']]['forumnames'][] = $this->forum_names[$key];
++++			if (isset($prefix['forums'])) {
++++				foreach (json_decode($prefix['forums'], true) as $key)
++++				{
++++					if (isset($this->forum_names[$key])) {
++++						$this->prefix_keys[$prefix['id']]['forumnames'][] = $this->forum_names[$key];
++++					}
++++					else {
++++						error_log("Forum name index not found: " . $key);
++++					}
++++				}
+++ 			}
+++ 		}
+++ 		return $this->prefix_keys;
+++@@ -164,30 +178,44 @@ class manager
+++ 	 */
+++ 	public function load_prefix_instances($refresh = false)
+++ 	{
+++-		if (false === ($this->prefix_instances = $this->cache->get('_prefixes_used')) || $refresh)
+++-		{
+++-			// If we're refreshing, we have to reset the array first
+++-			$this->prefix_instances = [];
+++-			$sql = 'SELECT id, prefix, topic, ordered, token_data FROM ' . BBPREFIX_INSTANCES_TABLE;
+++-			$result = $this->db->sql_query($sql);
+++-			while ($row = $this->db->sql_fetchrow($result))
++++	
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprefix/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprefix/event/listener.php"
++index aafaac7c2..de3896874 100644
++--- "a/c:\\Users\\Leinad4Mind
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bbprefix/event/listener.php" "[FORUM_EXT]/sitesplat\\bbprefix/event/listener.php"
--- "[ORIGINAL]/sitesplat\\bbprefix/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\bbprefix/event/listener.php"
@@ -212,13 +212,16 @@ class listener implements EventSubscriberInterface
 			}
 
 			// LEFT JOIN will mess up topic count, so use CROSS JOIN
-			$sql_ary['FROM'] += [BBPREFIX_INSTANCES_TABLE => 'pr'];
+			// $sql_ary['FROM'] += [BBPREFIX_INSTANCES_TABLE => 'pr'];
 
 			// reset topic count
 			$cnt_ary = $sql_ary;
 			$cnt_ary['SELECT'] = 'COUNT(topic_id) AS cnt';
+			// Leinad4Mind Change - Improve SQL a LOT
+			$cnt_ary['FROM'] += [BBPREFIX_INSTANCES_TABLE => 'pr'];
 			$cnt_ary['WHERE'] .= " AND t.forum_id = {$event['forum_id']}";
 			$sql = $this->db->sql_build_query('SELECT', $cnt_ary);
+
 			$result = $this->db->sql_query($sql);
 			$event['topics_count'] = (int) $this->db->sql_fetchfield('cnt');
 			$this->db->sql_freeresult($result);
```
