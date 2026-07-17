Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/canidev\\blockgets/blocks/gallery_block.php" "[FORUM_EXT]/canidev\\blockgets/blocks/gallery_block.php"
--- "[ORIGINAL]/canidev\\blockgets/blocks/gallery_block.php"
+++ "[FORUM_EXT]/canidev\\blockgets/blocks/gallery_block.php"
@@ -236,7 +236,7 @@ class gallery_block extends base
 					'WHERE'			=> 'p.post_visibility = ' . ITEM_APPROVED . '
 						AND (' . implode(' OR ', $sql_where) . ")
 						AND p.bbcode_uid NOT LIKE ''
-						AND p.post_text " . $this->db->sql_like_expression($this->db->get_any_char() . '[img]' . $this->db->get_any_char()),
+						AND p.post_text " . $this->db->sql_like_expression($this->db->get_any_char() . '[album]' . $this->db->get_any_char()),
 					'ORDER_BY'		=> ($data['image_order'] == 'last') ? 'p.post_time DESC' : $random_key,
 				];
 
@@ -253,9 +253,41 @@ class gallery_block extends base
 				$result = $this->db->sql_query_limit($sql, $data['max_number']);
 				while($row = $this->db->sql_fetchrow($result))
 				{
+					$post_ary[] = $row;
+
+					// Prepare array for prefixes
+					if (!isset($prefix_ary[$row['topic_id']])) {
+						$prefix_ary[$row['topic_id']] = array();
+					}
+				}
+				$this->db->sql_freeresult($result);
+
+				// Obtain prefixes
+				$sql = 'SELECT i.*, p.*
+				   FROM ' . BBPREFIX_INSTANCES_TABLE . ' i
+				   LEFT JOIN ' . BBPREFIX_TABLE . ' p ON(p.id = i.prefix)
+				   WHERE ' . $this->db->sql_in_set('topic', array_keys($prefix_ary)) . '
+				   ORDER BY i.ordered';
+				$result = $this->db->sql_query($sql);
+
+				while ($row = $this->db->sql_fetchrow($result)) {
+					$prefix_ary[$row['topic']][] = $row;
+				}
+
+				// Parse data
+				foreach ($post_ary as $row) {
+					$row_prefixes = [];
 					$row_images = [];
 
-					preg_match_all('#<IMG src="(.*?)">#i', $row['post_text'], $matches, PREG_SET_ORDER);
+					preg_match_all('#<ALBUM content="(.*?)">#i', $row['post_text'], $matches, PREG_SET_ORDER);
+
+					if (!empty($prefix_ary[$row['topic_id']])) {
+						foreach ($prefix_ary[$row['topic_id']] as $prefix) {
+							$row_prefixes[] = array(
+								'NAME'   => $prefix['name']
+							);
+						}
+					}
 					
 					foreach($matches as $match)
 					{
@@ -265,8 +297,15 @@ class gallery_block extends base
 								'p'	=> $row['post_id'],
 								'#'	=> 'p' . $row['post_id']
 							]),
-							'SRC'		=> $match[1],
+							'SRC'		=> '/forum/gallery/image/' . $match[1] . '/mini',
 							'TITLE'		=> $row['post_subject'],
+							'PREFIX_STR'	=> implode('-', array_map(
+								function ($prefix) {
+									return $prefix['NAME'];
+								},
+								$row_prefixes
+							)),
+							'prefix'	=> $row_prefixes,
 						];
 					}
 
diff --git "[ORIGINAL]/canidev\\blockgets/blocks/login_block.php" "[FORUM_EXT]/canidev\\blockgets/blocks/login_block.php"
--- "[ORIGINAL]/canidev\\blockgets/blocks/login_block.php"
+++ "[FORUM_EXT]/canidev\\blockgets/blocks/login_block.php"
@@ -135,10 +135,10 @@ class login_block extends base
 		if($this->user->data['is_registered'])
 		{
 			$links = [
-				'SEARCH_NEW'	=> ['url' => 'U_SEARCH_NEW', 	'icon' => 'fa-file-o icon-red'],
-				'SEARCH_SELF'	=> ['url' => 'U_SEARCH_SELF', 	'icon' => 'fa-file-o'],
+				'SEARCH_NEW'	=> ['url' => 'U_SEARCH_NEW', 	'icon' => 'fa-commenting icon-red'],
+				'SEARCH_SELF'	=> ['url' => 'U_SEARCH_SELF', 	'icon' => 'fa-comment'],
 				'MY_BOOKMARKS'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=bookmarks'), 	'icon' => 'fa-star-o'],
-				'MY_SUBSCRIBED'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=subscribed'), 	'icon' => 'fa-bookmark-o'],
+				'MY_SUBSCRIBED'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=subscribed'), 	'icon' => 'fa-eye'],
 			];
 			
 			if($this->config['allow_privmsg'] && ($this->auth->acl_get('u_readpm') || $this->auth->acl_get('u_sendpm')))
@@ -147,7 +147,7 @@ class login_block extends base
 				
 				$links[$pm_title] = [
 					'url' => 'U_PRIVATEMSGS',
-					'icon' => 'fa-inbox',
+					'icon' => 'fa-envelope',
 				];
 			}
 
diff --git "[ORIGINAL]/canidev\\blockgets/blocks/news_block.php" "[FORUM_EXT]/canidev\\blockgets/blocks/news_block.php"
--- "[ORIGINAL]/canidev\\blockgets/blocks/news_block.php"
+++ "[FORUM_EXT]/canidev\\blockgets/blocks/news_block.php"
@@ -45,7 +45,7 @@ class news_block extends base
 		{
 			foreach($data['forums'] as $id => $forum_id)
 			{
-				if(!$this->auth->acl_get('f_read', $forum_id))
+				if(!$this->auth->acl_get('f_read', $forum_id) || !$this->auth->acl_get('f_read_others_topics_brunoais', $forum_id))
 				{
 					unset($data['forums'][$id]);
 				}
@@ -80,7 +80,7 @@ class news_block extends base
 				AND t.topic_visibility = ' . ITEM_APPROVED . '
 				AND ' . $this->db->sql_in_set('t.forum_id', $data['forums']),
 				
-			'ORDER_BY'	=> 't.topic_time DESC',
+			'ORDER_BY'	=> 't.topic_last_post_time DESC',
 		];
 
 		$forum_data 	= new \canidev\core\DummyArray;
@@ -227,12 +227,14 @@ class news_block extends base
 				'TOPIC_TITLE'			=> $topic_title,
 				'TOPIC_TITLE_RAW'		=> $topic_title, // Raw title (not modified by extensions)
 				'FIRST_POST_TIME'		=> $this->user->format_date($row['topic_time']),
+				'LAST_POST_TIME'		=> $this->user->format_date($row['topic_last_post_time']),
 				'S_HAS_ATTACHMENTS'		=> (!empty($attachments[$row['topic_first_post_id']])) ? true : false,
 				'FORUM_NAME'			=> $row['forum_name'],
 				'TEXT'					=> $message,
 				'VIEWS'					=> $row['topic_views'],
 				'S_HAS_POLL'			=> ($row['poll_start'] > 0) ? true : false,
 				'TOPIC_AUTHOR_FULL'		=> get_username_string('full', $row['topic_poster'], $row['username'], $row['user_colour'], $row['post_username']),
+				'LAST_POST_AUTHOR_FULL'	=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour'], $row['post_username']),
 				'REPLIES'				=> max(0, (int)$row['topic_posts_approved'] - 1),
 
 				'U_VIEW_TOPIC'			=> $u_view_topic,
diff --git "[ORIGINAL]/canidev\\blockgets/blocks/recent_topics_block.php" "[FORUM_EXT]/canidev\\blockgets/blocks/recent_topics_block.php"
--- "[ORIGINAL]/canidev\\blockgets/blocks/recent_topics_block.php"
+++ "[FORUM_EXT]/canidev\\blockgets/blocks/recent_topics_block.php"
@@ -47,7 +47,7 @@ class recent_topics_block extends base
 		{
 			foreach($data['forums'] as $forum_id)
 			{
-				if($this->auth->acl_get('f_read', $forum_id))
+				if($this->auth->acl_get('f_read', $forum_id) && $this->auth->acl_get('f_read_others_topics_brunoais', $forum_id))
 				{
 					$forum_ids[] = $forum_id;
 				}
@@ -67,7 +67,7 @@ class recent_topics_block extends base
 			self::TAB_TOPICS => [
 				'title'			=> 'BLG_RECENT_TOPICS',
 				'icon'			=> 'fa-comment',
-				'where'			=> '',
+				'where'			=> 'AND t.topic_posts_approved >= 1)',
 				'order_by'		=> 't.topic_time DESC',
 			],
 
@@ -82,7 +82,7 @@ class recent_topics_block extends base
 			self::TAB_ACTIVITY => [
 				'title'			=> 'BLG_RECENT_ACTIVITY',
 				'icon'			=> 'fa-comments-o',
-				'where'			=> 'AND t.topic_posts_approved > 1)',
+				'where'			=> ')',
 				'order_by'		=> 't.topic_last_post_time DESC',
 			],
 		];
@@ -286,6 +286,7 @@ class recent_topics_block extends base
 					'U_LAST_POST'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;p=' . $row['topic_last_post_id']) . '#p' . $row['topic_last_post_id'],
 					'U_VIEW_FORUM'		=> $this->helper->url('viewforum', 'f=' . $row['forum_id']),
 					'U_VIEW_TOPIC'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;view=unread#unread'),
+					'U_NEWEST_POST'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;view=unread#unread'),
 				];
 
 				/**
diff --git "[ORIGINAL]/canidev\\blockgets/blocks/topic_index_block.php" "[FORUM_EXT]/canidev\\blockgets/blocks/topic_index_block.php"
--- "[ORIGINAL]/canidev\\blockgets/blocks/topic_index_block.php"
+++ "[FORUM_EXT]/canidev\\blockgets/blocks/topic_index_block.php"
@@ -87,7 +87,10 @@ class topic_index_block extends base
 			case 'topic_title':
 				if($first_char)
 				{
-					$sql_array['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression(substr($first_char, 0, 1) . $this->db->get_any_char());
+					$sql_array['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression('[' . $this->db->get_any_char() . '] ' . substr($first_char, 0, 1) . $this->db->get_any_char());
+				}
+				else {
+					$sql_array['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression('[' . $this->db->get_any_char() . '] ' . $this->db->get_any_char());
 				}
 
 				$sql_array['ORDER_BY'] = 'LOWER(t.topic_title) ASC';
diff --git "[ORIGINAL]/canidev\\blockgets/controller/calendar_controller.php" "[FORUM_EXT]/canidev\\blockgets/controller/calendar_controller.php"
--- "[ORIGINAL]/canidev\\blockgets/controller/calendar_controller.php"
+++ "[FORUM_EXT]/canidev\\blockgets/controller/calendar_controller.php"
@@ -166,6 +166,7 @@ class calendar_controller
 					LEFT JOIN ' . BANLIST_TABLE . " b ON (u.user_id = b.ban_userid)
 					WHERE (b.ban_id IS NULL OR b.ban_exclude = 1)
 					AND ($sql_where)
+					AND u.user_posts > 100
 					AND u.user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ')
 					ORDER BY username_clean ASC';
 				$result = $this->db->sql_query($sql);
diff --git "[FORUM_EXT]/canidev\\blockgets/diff_full.tmp" "[FORUM_EXT]/canidev\\blockgets/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/diff_full.tmp"
@@ -0,0 +1,4686 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/gallery_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/gallery_block.php"
+index cc4b732d7..ca008eeec 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/gallery_block.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/gallery_block.php"
+@@ -236,7 +236,7 @@ class gallery_block extends base
+ 					'WHERE'			=> 'p.post_visibility = ' . ITEM_APPROVED . '
+ 						AND (' . implode(' OR ', $sql_where) . ")
+ 						AND p.bbcode_uid NOT LIKE ''
+-						AND p.post_text " . $this->db->sql_like_expression($this->db->get_any_char() . '[img]' . $this->db->get_any_char()),
++						AND p.post_text " . $this->db->sql_like_expression($this->db->get_any_char() . '[album]' . $this->db->get_any_char()),
+ 					'ORDER_BY'		=> ($data['image_order'] == 'last') ? 'p.post_time DESC' : $random_key,
+ 				];
+ 
+@@ -253,10 +253,42 @@ class gallery_block extends base
+ 				$result = $this->db->sql_query_limit($sql, $data['max_number']);
+ 				while($row = $this->db->sql_fetchrow($result))
+ 				{
++					$post_ary[] = $row;
++
++					// Prepare array for prefixes
++					if (!isset($prefix_ary[$row['topic_id']])) {
++						$prefix_ary[$row['topic_id']] = array();
++					}
++				}
++				$this->db->sql_freeresult($result);
++
++				// Obtain prefixes
++				$sql = 'SELECT i.*, p.*
++				   FROM ' . BBPREFIX_INSTANCES_TABLE . ' i
++				   LEFT JOIN ' . BBPREFIX_TABLE . ' p ON(p.id = i.prefix)
++				   WHERE ' . $this->db->sql_in_set('topic', array_keys($prefix_ary)) . '
++				   ORDER BY i.ordered';
++				$result = $this->db->sql_query($sql);
++
++				while ($row = $this->db->sql_fetchrow($result)) {
++					$prefix_ary[$row['topic']][] = $row;
++				}
++
++				// Parse data
++				foreach ($post_ary as $row) {
++					$row_prefixes = [];
+ 					$row_images = [];
+ 
+-					preg_match_all('#<IMG src="(.*?)">#i', $row['post_text'], $matches, PREG_SET_ORDER);
++					preg_match_all('#<ALBUM content="(.*?)">#i', $row['post_text'], $matches, PREG_SET_ORDER);
+ 
++					if (!empty($prefix_ary[$row['topic_id']])) {
++						foreach ($prefix_ary[$row['topic_id']] as $prefix) {
++							$row_prefixes[] = array(
++								'NAME'   => $prefix['name']
++							);
++						}
++					}
++					
+ 					foreach($matches as $match)
+ 					{
+ 						$row_images[] = [
+@@ -265,8 +297,15 @@ class gallery_block extends base
+ 								'p'	=> $row['post_id'],
+ 								'#'	=> 'p' . $row['post_id']
+ 							]),
+-							'SRC'		=> $match[1],
++							'SRC'		=> '/forum/gallery/image/' . $match[1] . '/mini',
+ 							'TITLE'		=> $row['post_subject'],
++							'PREFIX_STR'	=> implode('-', array_map(
++								function ($prefix) {
++									return $prefix['NAME'];
++								},
++								$row_prefixes
++							)),
++							'prefix'	=> $row_prefixes,
+ 						];
+ 					}
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/login_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/login_block.php"
+index daa168f28..86a6e72be 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/login_block.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/login_block.php"
+@@ -135,10 +135,10 @@ class login_block extends base
+ 		if($this->user->data['is_registered'])
+ 		{
+ 			$links = [
+-				'SEARCH_NEW'	=> ['url' => 'U_SEARCH_NEW', 	'icon' => 'fa-file-o icon-red'],
+-				'SEARCH_SELF'	=> ['url' => 'U_SEARCH_SELF', 	'icon' => 'fa-file-o'],
++				'SEARCH_NEW'	=> ['url' => 'U_SEARCH_NEW', 	'icon' => 'fa-commenting icon-red'],
++				'SEARCH_SELF'	=> ['url' => 'U_SEARCH_SELF', 	'icon' => 'fa-comment'],
+ 				'MY_BOOKMARKS'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=bookmarks'), 	'icon' => 'fa-star-o'],
+-				'MY_SUBSCRIBED'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=subscribed'), 	'icon' => 'fa-bookmark-o'],
++				'MY_SUBSCRIBED'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=subscribed'), 	'icon' => 'fa-eye'],
+ 			];
+ 			
+ 			if($this->config['allow_privmsg'] && ($this->auth->acl_get('u_readpm') || $this->auth->acl_get('u_sendpm')))
+@@ -147,7 +147,7 @@ class login_block extends base
+ 				
+ 				$links[$pm_title] = [
+ 					'url' => 'U_PRIVATEMSGS',
+-					'icon' => 'fa-inbox',
++					'icon' => 'fa-envelope',
+ 				];
+ 			}
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/news_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/news_block.php"
+index 42c0169b6..5ffe59b8c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/news_block.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/news_block.php"
+@@ -45,7 +45,7 @@ class news_block extends base
+ 		{
+ 			foreach($data['forums'] as $id => $forum_id)
+ 			{
+-				if(!$this->auth->acl_get('f_read', $forum_id))
++				if(!$this->auth->acl_get('f_read', $forum_id) || !$this->auth->acl_get('f_read_others_topics_brunoais', $forum_id))
+ 				{
+ 					unset($data['forums'][$id]);
+ 				}
+@@ -80,7 +80,7 @@ class news_block extends base
+ 				AND t.topic_visibility = ' . ITEM_APPROVED . '
+ 				AND ' . $this->db->sql_in_set('t.forum_id', $data['forums']),
+ 				
+-			'ORDER_BY'	=> 't.topic_time DESC',
++			'ORDER_BY'	=> 't.topic_last_post_time DESC',
+ 		];
+ 
+ 		$forum_data 	= new \canidev\core\DummyArray;
+@@ -227,12 +227,14 @@ class news_block extends base
+ 				'TOPIC_TITLE'			=> $topic_title,
+ 				'TOPIC_TITLE_RAW'		=> $topic_title, // Raw title (not modified by extensions)
+ 				'FIRST_POST_TIME'		=> $this->user->format_date($row['topic_time']),
++				'LAST_POST_TIME'		=> $this->user->format_date($row['topic_last_post_time']),
+ 				'S_HAS_ATTACHMENTS'		=> (!empty($attachments[$row['topic_first_post_id']])) ? true : false,
+ 				'FORUM_NAME'			=> $row['forum_name'],
+ 				'TEXT'					=> $message,
+ 				'VIEWS'					=> $row['topic_views'],
+ 				'S_HAS_POLL'			=> ($row['poll_start'] > 0) ? true : false,
+ 				'TOPIC_AUTHOR_FULL'		=> get_username_string('full', $row['topic_poster'], $row['username'], $row['user_colour'], $row['post_username']),
++				'LAST_POST_AUTHOR_FULL'	=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour'], $row['post_username']),
+ 				'REPLIES'				=> max(0, (int)$row['topic_posts_approved'] - 1),
+ 
+ 				'U_VIEW_TOPIC'			=> $u_view_topic,
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/recent_topics_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/recent_topics_block.php"
+index 774612e56..a09b27568 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/recent_topics_block.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/recent_topics_block.php"
+@@ -47,7 +47,7 @@ class recent_topics_block extends base
+ 		{
+ 			foreach($data['forums'] as $forum_id)
+ 			{
+-				if($this->auth->acl_get('f_read', $forum_id))
++				if($this->auth->acl_get('f_read', $forum_id) && $this->auth->acl_get('f_read_others_topics_brunoais', $forum_id))
+ 				{
+ 					$forum_ids[] = $forum_id;
+ 				}
+@@ -67,7 +67,7 @@ class recent_topics_block extends base
+ 			self::TAB_TOPICS => [
+ 				'title'			=> 'BLG_RECENT_TOPICS',
+ 				'icon'			=> 'fa-comment',
+-				'where'			=> '',
++				'where'			=> 'AND t.topic_posts_approved >= 1)',
+ 				'order_by'		=> 't.topic_time DESC',
+ 			],
+ 
+@@ -82,7 +82,7 @@ class recent_topics_block extends base
+ 			self::TAB_ACTIVITY => [
+ 				'title'			=> 'BLG_RECENT_ACTIVITY',
+ 				'icon'			=> 'fa-comments-o',
+-				'where'			=> 'AND t.topic_posts_approved > 1)',
++				'where'			=> ')',
+ 				'order_by'		=> 't.topic_last_post_time DESC',
+ 			],
+ 		];
+@@ -286,6 +286,7 @@ class recent_topics_block extends base
+ 					'U_LAST_POST'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;p=' . $row['topic_last_post_id']) . '#p' . $row['topic_last_post_id'],
+ 					'U_VIEW_FORUM'		=> $this->helper->url('viewforum', 'f=' . $row['forum_id']),
+ 					'U_VIEW_TOPIC'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;view=unread#unread'),
++					'U_NEWEST_POST'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;view=unread#unread'),
+ 				];
+ 
+ 				/**
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/topic_index_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/topic_index_block.php"
+index 655631b86..f689c8d07 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/topic_index_block.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/topic_index_block.php"
+@@ -87,7 +87,10 @@ class topic_index_block extends base
+ 			case 'topic_title':
+ 				if($first_char)
+ 				{
+-					$sql_array['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression(substr($first_char, 0, 1) . $this->db->get_any_char());
++					$sql_array['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression('[' . $this->db->get_any_char() . '] ' . substr($first_char, 0, 1) . $this->db->get_any_char());
++				}
++				else {
++					$sql_array['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression('[' . $this->db->get_any_char() . '] ' . $this->db->get_any_char());
+ 				}
+ 
+ 				$sql_array['ORDER_BY'] = 'LOWER(t.topic_title) ASC';
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/controller/calendar_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/controller/calendar_controller.php"
+index ef69c475c..dcfa9befc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/controller/calendar_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/controller/calendar_controller.php"
+@@ -166,6 +166,7 @@ class calendar_controller
+ 					LEFT JOIN ' . BANLIST_TABLE . " b ON (u.user_id = b.ban_userid)
+ 					WHERE (b.ban_id IS NULL OR b.ban_exclude = 1)
+ 					AND ($sql_where)
++					AND u.user_posts > 100
+ 					AND u.user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ')
+ 					ORDER BY username_clean ASC';
+ 				$result = $this->db->sql_query($sql);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/diff_full.tmp"
+new file mode 100644
+index 000000000..309c0cd77
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/diff_full.tmp"
+@@ -0,0 +1,170 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/gallery_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/gallery_block.php"
++index cc4b732d7..ca008eeec 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/gallery_block.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/gallery_block.php"
++@@ -236,7 +236,7 @@ class gallery_block extends base
++ 					'WHERE'			=> 'p.post_visibility = ' . ITEM_APPROVED . '
++ 						AND (' . implode(' OR ', $sql_where) . ")
++ 						AND p.bbcode_uid NOT LIKE ''
++-						AND p.post_text " . $this->db->sql_like_expression($this->db->get_any_char() . '[img]' . $this->db->get_any_char()),
+++						AND p.post_text " . $this->db->sql_like_expression($this->db->get_any_char() . '[album]' . $this->db->get_any_char()),
++ 					'ORDER_BY'		=> ($data['image_order'] == 'last') ? 'p.post_time DESC' : $random_key,
++ 				];
++ 
++@@ -253,10 +253,42 @@ class gallery_block extends base
++ 				$result = $this->db->sql_query_limit($sql, $data['max_number']);
++ 				while($row = $this->db->sql_fetchrow($result))
++ 				{
+++					$post_ary[] = $row;
+++
+++					// Prepare array for prefixes
+++					if (!isset($prefix_ary[$row['topic_id']])) {
+++						$prefix_ary[$row['topic_id']] = array();
+++					}
+++				}
+++				$this->db->sql_freeresult($result);
+++
+++				// Obtain prefixes
+++				$sql = 'SELECT i.*, p.*
+++				   FROM ' . BBPREFIX_INSTANCES_TABLE . ' i
+++				   LEFT JOIN ' . BBPREFIX_TABLE . ' p ON(p.id = i.prefix)
+++				   WHERE ' . $this->db->sql_in_set('topic', array_keys($prefix_ary)) . '
+++				   ORDER BY i.ordered';
+++				$result = $this->db->sql_query($sql);
+++
+++				while ($row = $this->db->sql_fetchrow($result)) {
+++					$prefix_ary[$row['topic']][] = $row;
+++				}
+++
+++				// Parse data
+++				foreach ($post_ary as $row) {
+++					$row_prefixes = [];
++ 					$row_images = [];
++ 
++-					preg_match_all('#<IMG src="(.*?)">#i', $row['post_text'], $matches, PREG_SET_ORDER);
+++					preg_match_all('#<ALBUM content="(.*?)">#i', $row['post_text'], $matches, PREG_SET_ORDER);
++ 
+++					if (!empty($prefix_ary[$row['topic_id']])) {
+++						foreach ($prefix_ary[$row['topic_id']] as $prefix) {
+++							$row_prefixes[] = array(
+++								'NAME'   => $prefix['name']
+++							);
+++						}
+++					}
+++					
++ 					foreach($matches as $match)
++ 					{
++ 						$row_images[] = [
++@@ -265,8 +297,15 @@ class gallery_block extends base
++ 								'p'	=> $row['post_id'],
++ 								'#'	=> 'p' . $row['post_id']
++ 							]),
++-							'SRC'		=> $match[1],
+++							'SRC'		=> '/forum/gallery/image/' . $match[1] . '/mini',
++ 							'TITLE'		=> $row['post_subject'],
+++							'PREFIX_STR'	=> implode('-', array_map(
+++								function ($prefix) {
+++									return $prefix['NAME'];
+++								},
+++								$row_prefixes
+++							)),
+++							'prefix'	=> $row_prefixes,
++ 						];
++ 					}
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/login_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/login_block.php"
++index daa168f28..86a6e72be 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/login_block.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/login_block.php"
++@@ -135,10 +135,10 @@ class login_block extends base
++ 		if($this->user->data['is_registered'])
++ 		{
++ 			$links = [
++-				'SEARCH_NEW'	=> ['url' => 'U_SEARCH_NEW', 	'icon' => 'fa-file-o icon-red'],
++-				'SEARCH_SELF'	=> ['url' => 'U_SEARCH_SELF', 	'icon' => 'fa-file-o'],
+++				'SEARCH_NEW'	=> ['url' => 'U_SEARCH_NEW', 	'icon' => 'fa-commenting icon-red'],
+++				'SEARCH_SELF'	=> ['url' => 'U_SEARCH_SELF', 	'icon' => 'fa-comment'],
++ 				'MY_BOOKMARKS'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=bookmarks'), 	'icon' => 'fa-star-o'],
++-				'MY_SUBSCRIBED'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=subscribed'), 	'icon' => 'fa-bookmark-o'],
+++				'MY_SUBSCRIBED'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=subscribed'), 	'icon' => 'fa-eye'],
++ 			];
++ 			
++ 			if($this->config['allow_privmsg'] && ($this->auth->acl_get('u_readpm') || $this->auth->acl_get('u_sendpm')))
++@@ -147,7 +147,7 @@ class login_block extends base
++ 				
++ 				$links[$pm_title] = [
++ 					'url' => 'U_PRIVATEMSGS',
++-					'icon' => 'fa-inbox',
+++					'icon' => 'fa-envelope',
++ 				];
++ 			}
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/news_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/news_block.php"
++index 42c0169b6..5ffe59b8c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/news_block.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/news_block.php"
++@@ -45,7 +45,7 @@ class news_block extends base
++ 		{
++ 			foreach($data['forums'] as $id => $forum_id)
++ 			{
++-				if(!$this->auth->acl_get('f_read', $forum_id))
+++				if(!$this->auth->acl_get('f_read', $forum_id) || !$this->auth->acl_get('f_read_others_topics_brunoais', $forum_id))
++ 				{
++ 					unset($data['forums'][$id]);
++ 				}
++@@ -80,7 +80,7 @@ class news_block extends base
++ 				AND t.topic_visibility = ' . ITEM_APPROVED . '
++ 				AND ' . $this->db->sql_in_set('t.forum_id', $data['forums']),
++ 				
++-			'ORDER_BY'	=> 't.topic_time DESC',
+++			'ORDER_BY'	=> 't.topic_last_post_time DESC',
++ 		];
++ 
++ 		$forum_data 	= new \canidev\core\DummyArray;
++@@ -227,12 +227,14 @@ class news_block extends base
++ 				'TOPIC_TITLE'			=> $topic_title,
++ 				'TOPIC_TITLE_RAW'		=> $topic_title, // Raw title (not modified by extensions)
++ 				'FIRST_POST_TIME'		=> $this->user->format_date($row['topic_time']),
+++				'LAST_POST_TIME'		=> $this->user->format_date($row['topic_last_post_time']),
++ 				'S_HAS_ATTACHMENTS'		=> (!empty($attachments[$row['topic_first_post_id']])) ? true : false,
++ 				'FORUM_NAME'			=> $row['forum_name'],
++ 				'TEXT'					=> $message,
++ 				'VIEWS'					=> $row['topic_views'],
++ 				'S_HAS_POLL'			=> ($row['poll_start'] > 0) ? true : false,
++ 				'TOPIC_AUTHOR_FULL'		=> get_username_string('full', $row['topic_poster'], $row['username'], $row['user_colour'], $row['post_username']),
+++				'LAST_POST_AUTHOR_FULL'	=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour'], $row['post_username']),
++ 				'REPLIES'				=> max(0, (int)$row['topic_posts_approved'] - 1),
++ 
++ 				'U_VIEW_TOPIC'			=> $u_view_topic,
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/recent_topics_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/recent_topics_block.php"
++index 774612e56..a09b27568 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/recent_topics_block.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/recent_topics_block.php"
++@@ -47,7 +47,7 @@ class recent_topics_block extends base
++ 		{
++ 			foreach($data['forums'] as $forum_id)
++ 			{
++-				if($this->auth->acl_get('f_read', $forum_id))
+++				if($this->auth->acl_get('f_read', $forum_id) && $this->auth->acl_get('f_read_others_topics_brunoais', $forum_id))
++ 				{
++ 					$forum_ids[] = $forum_id;
++ 				}
++@@ -67,7 +67,7 @@ class recent_topics_block extends base
++ 			self::TAB_TOPICS => [
++ 				'title'			=> 'BLG_RECENT_TOPICS',
++ 				'icon'			=> 'fa-comment',
++-				'where'			=> '',
+++				'where'			=> 'AND t.topic_posts_approved >= 1)',
++ 				'order_by'		=> 't.topic_time DESC',
++ 			],
++ 
++@@ -82,7 +82,7 @@ class recent_topics_block extends base
++ 			self::TAB_ACTIVITY => [
++ 				'title'			=> 'BLG_RECENT_ACTIVITY',
++ 				'icon'			=> 'fa-comments-o',
++-				'where'			=> 'AND t.topic_posts_approved > 1)',
+++				'where'			=> ')',
++ 				'order_by'		=> 't.topic_last_post_time DESC',
++ 			],
++ 		];
++@@ -286,6 +286,7 @@ class recent_topi
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/acp.php"
+new file mode 100644
+index 000000000..2006342cf
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/acp.php"
+@@ -0,0 +1,357 @@
++<?php
++/*
++* acp.php [English [En]]
++* @package cBB Blockgets
++* @version v2.0.2 12/01/2021
++*
++* @copyright (c) 2021 CaniDev
++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
++*/
++
++// @ignore
++if(!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++// @acp_blockgets
++$lang = array_merge($lang, array(
++	'BLG_CONFIG_TITLE'				=> 'General configuration',
++	'BLG_CONFIG_EXPLAIN'			=> 'Thank you for choosing cBB Blockgets as a complement for your forum!<br />From here you can set the main settings of the extension.<br />Lateral links allow you to access all the options to set comfortably the mod.',
++	'BLG_IMAGES_TITLE'				=> 'Available images',
++	'BLG_OPTIONAL_TITLE'			=> 'Additional configuration',
++	'BLG_OPTIONAL_EXPLAIN'			=> 'From here you can set additional settings for the site.',
++	
++	'BLG_ADMIN_BAR'					=> 'Show quick access bar',
++	'BLG_ADMIN_BAR_EXPLAIN'			=> 'If enabled, a bar will be displayed at the top of the forum that will allow you to quickly access the options of the page where you are.',
++	'BLG_BLOCK_AUTOFIT'				=> 'AutoFit blocks',
++	'BLG_BLOCK_AUTOFIT_EXPLAIN'		=> 'If enabled, the content and disposition of the blocks will be adjust to the column.',
++	'BLG_COLLAPSE'					=> 'Allow collapse blocks',
++	'BLG_COLLAPSE_EXPLAIN'			=> 'Enable/disable globally the possibility that each user can collapse/expand blocks individually. This option overwrite the individual block\'s configuration.',
++	'BLG_FULL_EDITOR'				=> 'Full editor',
++	'BLG_ON_BOARD'					=> 'Blocks within the forum',
++	'BLG_ON_BOARD_EXPLAIN'			=> 'Sets whether to display the blocks into the forum pages. This option overwrite the invidual page\'s configuration.<br /><br />
++		<em>
++			&nbsp;&nbsp;<strong>Not show:</strong> It does not show blocks on any page.<br />
++			&nbsp;&nbsp;<strong>Individual pages:</strong> It shows the blocks on the pages configured for it.<br />
++			&nbsp;&nbsp;<strong>Equal pages:</strong> The "General Index" blocks are shown on all pages.
++		</em>',
++	'BLG_REDIRECTIONS'				=> 'Redirections',
++	'BLG_REDIRECT_404'				=> 'Page not found',
++	'BLG_REDIRECT_404_EXPLAIN'		=> 'Sets the page to which the user will be taken when trying to access a location that does not exist.<br />
++		<em>Replace the message No route found for "GET" of phpBB.</em>',
++	'BLG_REDIRECT_LOGIN'			=> 'Login',
++	'BLG_REDIRECT_LOGIN_EXPLAIN'	=> 'Sets the page to which the user will be taken after login to the forum.',
++	'BLG_REDIRECT_LOGOUT'			=> 'Logout',
++	'BLG_REDIRECT_LOGOUT_EXPLAIN'	=> 'Sets the page to which the user will be taken when disconnecting.',
++
++	'DEFAULT'					=> 'By default',
++	'LINKS'						=> 'Links',
++	'OPEN_GALLERY'				=> 'Open gallery',
++	'SAVE_AND_ADD'				=> 'Save and add more',
++	'TYPE_DOMAIN_HOME'			=> 'Domain\'s main page',
++	'TYPE_FORUM_HOME'			=> 'Forum\'s main page',
++	'TYPE_FORUM_SECONDARY'		=> 'Forum\'s secondary page',
++
++	'BOARD_BLOCK_INDIVIDUAL'	=> 'Individual pages',
++	'BOARD_BLOCK_NONE'			=> 'Not show',
++	'BOARD_BLOCK_SAME'			=> 'Equal pages',
++
++	'AVATAR_RESIZE_WIDTH'			=> 'Size of avatars',
++	'AVATAR_RESIZE_WIDTH_EXPLAIN'	=> 'Maximum size allowed (in pixels) for avatars.<br />
++		<em>Set 0 to disable avatar resizing</em>.',
++	'CALENDAR'						=> 'Calendar',
++	'CALENDAR_ENABLED'				=> 'Calendar enabled',
++	'CALENDAR_ENABLED_EXPLAIN'		=> 'Defines whether the calendar will be available in both the<em>/calendar path</em> and blocks.',
++	'CALENDAR_BIRTHDAYS'			=> 'Show Birthdays',
++	'CALENDAR_BIRTHDAYS_EXPLAIN'	=> 'If enabled, user\'s birthdays will be marked and displayed on the calendar, as if they were events.',
++	'CALENDAR_LINK'					=> 'Link',
++	'CALENDAR_LINK_EXPLAIN'			=> 'Define in which part of the forum a link to the calendar will appear.',
++	'CALENDAR_FIRST_DAY'			=> 'First day of the week',
++	'CALENDAR_FIRST_DAY_EXPLAIN'	=> 'Define the first day of the week on the calendar.',
++	'COUNTER'						=> 'Hit Counter',
++	'COUNTER_RESET'					=> 'Reset hit counter',
++	'COUNTER_RESET_EXPLAIN'			=> 'Sets the visits to 0 and the counter start to the current date.',
++	'HOME_TYPE_DISPLAY'				=> 'Behavior of the home page',
++	'HOME_TYPE_DISPLAY_EXPLAIN'		=> 'Sets how the home page will work, if it is enabled.',
++	'IMAGE_RESIZE'					=> 'Resize images',
++	'IMAGE_RESIZE_POST'				=> 'Resize images in posts',
++	'IMAGE_RESIZE_POST_EXPLAIN'		=> 'Enable/Disable the resize in the images inside the forum posts.',
++	'IMAGE_RESIZE_WIDTH'			=> 'Images max size',
++	'IMAGE_RESIZE_WIDTH_EXPLAIN'	=> 'Maximum size (in pixels) for images. The default is 450.<br />
++		<em>Set 0 to disable image resizing</em>.',
++
++	'INDEX_FILE_ERROR'				=> 'Failed to complete setup',
++));
++
++// @acp_blockgets_lists
++$lang = array_merge($lang, array(
++	'ADD_ITEM'				=> 'Add item',
++	'CAT'					=> 'Category',
++
++	'LINK'						=> 'Link',
++	'LINK_DESCRIPTION'			=> 'Description',
++	'LINK_DESCRIPTION_EXPLAIN'	=> 'This text will be show in some blocks as aditional link information.',
++	'LINK_GROUP'				=> 'Groups',
++	'LINK_GROUP_EXPLAIN'		=> 'Select groups of users that can see this link in the menu.<br />You can select multiple groups using the <em>Ctrl</em> key on your keyboard.',
++	'LINK_IMG'					=> 'Image',
++	'LINK_TITLE'				=> 'Link title',
++	'LINK_TITLE_EXPLAIN'		=> 'Title that identifies the link. Limit 100 characters.',
++	'LINK_TYPE'					=> 'Link type',
++	'LINK_URL'					=> 'Link URL',
++	'LINK_URL_EXPLAIN'			=> 'The direction that opens when you click on the link. Limit 255 characters.',
++	'LINK_WINDOW'				=> 'Open in New Window',
++));
++
++// @acp_blockgets_pages
++$lang = array_merge($lang, array(
++	'ADD_BLOCK'					=> 'Add block',
++	'ADD_BLOCK_TIP'				=> 'Drag a block to the position you want to add it.',
++	'ADD_BLOCK_TITLE'			=> 'Add block :: %1$s',
++	'ADD_BLOCK_TITLE_EXPLAIN'	=> 'From here you can add a new block to your forum and set its configuration. You can also set additional settings, if the block you need.',
++	'ADD_GROUP'					=> 'Add group',
++	'ADD_GROUP_EXPLAIN'			=> 'Drag this button to the desired position to add a group',
++	'ADVANCED_OPTIONS'			=> 'Advanced options',
++
++	'BLOCK_SETTINGS'			=> 'General options for the block',
++	'BLOCK_SPACE'				=> 'Space between blocks',
++	'BLOCK_SPACE_EXPLAIN'		=> 'Value in pixels or percentage. The minimun value is 1.',
++	'BOTTOM_COLUMN'				=> 'Bottom column',
++	'CENTER_COLUMN'				=> 'Center column',
++	'CHG_GROUPS_BLOCK'			=> 'Change permissions',
++	'CHG_GROUP_EXPLAIN'			=> 'Choose groups who can see the selected blocks',
++	'COLUMN_SETTINGS'			=> 'Options for the columns',
++	'COPY_BLOCK'				=> 'Copy to other page',
++	'DELETE_BLOCK_CONFIRM'		=> 'Are you sure you want to delete the selected blocks?',
++	'DISABLE_BLOCK'				=> 'Disable',
++	'EDIT_BLOCK_TITLE'			=> 'Edit block :: %1$s',
++	'EDIT_BLOCK_TITLE_EXPLAIN'	=> 'Here you can edit the configuration of the block, as well as additional settings, if the block you need.',
++	'ENABLE_BLOCK'				=> 'Enable',
++	'EXT_ROUTES'				=> 'Extension\'s routes',
++	'FILTER_TYPE_GET'			=> 'Url (GET)',
++	'FILTER_TYPE_POST'			=> 'Form (POST)',
++	'FORUM_FILES'				=> 'Forum files',
++	'LEFT_COLUMN'				=> 'Left column',
++	'LEFT_COLUMN_EXPLAIN'		=> 'Width of the left column in pixels or percentage.<br />Set 0 to disable the column.',
++	'LINK_BOTTOM'				=> 'Bottom',
++	'LINK_QUICK'				=> 'Quick links',
++	'LINK_NONE'					=> 'No link',
++	'LINK_TOP'					=> 'Top',
++	'MANAGE_PAGE'				=> 'Manage page',
++	'MOVE_BLOCK'				=> 'Move to other page',
++	'NO_PAGES_CREATED'			=> 'No pages created.',
++	'NO_PAGE_FILTERS'			=> 'No filters',
++	
++	'PAGE'						=> 'Page',
++	'PAGE_ADD'					=> 'New page',
++	'PAGE_ALIAS'				=> 'Page alias',
++	'PAGE_ALIAS_EXPLAIN'		=> 'You can set an alias (letters, numbers and dashes) to create a separate page.<br />If you leave this field blank, it will create a separate page and will be used the ID as alias.',
++	'PAGE_ALIAS_ERROR'			=> 'The value inserted in "Alias page" field contains illegal characters or an invalid path.',
++	'PAGE_BACKGROUND'			=> 'Page background',
++	'PAGE_BACKGROUND_EXPLAIN'	=> 'You can set a color (ex. white, #FFFFFF) or an image (ex. http://mydomain.com/image.jpg). Leave this field blank to use the default background.',
++	'PAGE_CUSTOM'				=> 'Custom Pages',
++	'PAGE_CUSTOM_EXPLAIN'		=> 'These are pages created by you or another administrator of this site. You can add, edit and manage as many pages as you wish.',
++	'PAGE_CUSTOM_ONE'			=> 'Custom Page',
++	'PAGE_DESCRIPTION'			=> 'SEO Description',
++	'PAGE_DESCRIPTION_EXPLAIN'	=> 'Defines a description visible to search engines.<br /><em>Google, bing, etc...</em>',
++	'PAGE_ENABLED'				=> 'Page enabled',
++	'PAGE_ENABLED_EXPLAIN'		=> 'Enable or disable the page functions completely. This option overrides all others.',
++	'PAGE_FILTERS'				=> 'Filters',
++	'PAGE_FILTERS_EXPLAIN'		=> 'Define the required parameters (GET and POST) for the page is loaded.<br />Check <strong>Online Documentation</strong> for more information on how to set these filters.',
++	'PAGE_FILTER_PARAM'			=> 'Parameters',
++	'PAGE_FILTER_PARAM_EXPLAIN'	=> 'You can set as many as you want separated by ","<br />Ex: mode=mymode,style=1',
++	'PAGE_FILTER_TYPE'			=> 'Type',
++	'PAGE_FILTER_TYPE_EXPLAIN'	=> 'Select the type of location parameters.',
++	'PAGE_FORUM'				=> 'Pages inside the forum',
++	'PAGE_FORUM_EXPLAIN'		=> 'These are pages belonging to the forum to which you can add blocks. You can manage and edit their main parameters as in customized pages.',
++	'PAGE_GROUP'				=> 'Groups',
++	'PAGE_GROUP_EXPLAIN'		=> 'Choose groups who can see the blocks of this page.<br />You can select multiple groups using <em>Ctrl key</em> on your keyboard.',
++	'PAGE_HOME'					=> 'Home page',
++	'PAGE_HOME_EXPLAIN'			=> 'This is a page designed to be used as a site\'s home page as a "Portal".',
++	'PAGE_LINK'					=> 'Link',
++	'PAGE_LINK_ICON'			=> 'Link icon',
++	'PAGE_LINK_ICON_EXPLAIN'	=> 'Define the icon that will have the link to this page.',
++	'PAGE_LINK_POSITION'		=> 'Link position',
++	'PAGE_LINK_POSITION_EXPLAIN'	=> 'Define in which part of the forum a link to this page will appear.',
++	'PAGE_LOGO'					=> 'Logo',
++	'PAGE_LOGO_EXPLAIN'			=> 'Sets the url of the image to be used as logo.<br />Leave blank to use the default logo.',
++	'PAGE_STYLE'				=> 'Style',
++	'PAGE_STYLE_EXPLAIN'		=> 'Defines the style to be used on the page.<br /><em>This option will not be applied to the original pages of the forum.</em>',
++	'PAGE_STYLESHEET'			=> 'Custom theme',
++	'PAGE_STYLESHEET_EXPLAIN'	=> 'You can set the path to one or more files *.css (one per line) or directly set the variables of the theme that will be used.',
++	'PAGE_THEME'				=> 'Theme',
++	'PAGE_THEME_BACKGROUND'		=> 'Set background',
++	'PAGE_THEME_DEFAULT'		=> 'Use default configuration',
++	'PAGE_THEME_STYLE'			=> 'Set style',
++	'PAGE_THEME_STYLESHEET'		=> 'Use custom theme',
++	'PAGE_TITLE'				=> 'Page title',
++	'PAGE_TITLE_EXPLAIN'		=> 'Title will be displayed in the browser.',
++	'PAGE_URL'					=> 'Page url',
++	
++	'PAGES_ADD_TITLE'				=> 'Add new page',
++	'PAGES_ADD_TITLE_EXPLAIN'		=> 'From here you can add a new page and define custom configuration and appearance.',
++	'PAGES_BLOCKS_TITLE'			=> 'Manage blocks :: %s',
++	'PAGES_BLOCKS_TITLE_EXPLAIN'	=> 'From here you can create/edit/delete blocks to be shown on this page.<br />
++		The blocks can be divided into five columns (left, center, right, top and bottom). Drag the blocks to change their position.<br />
++		You can also add <strong>groups</strong> that will allow you to place blocks in up to 3 columns independently.',
++	'PAGES_EDIT_TITLE'				=> 'Edit page :: %s',
++	'PAGES_EDIT_TITLE_EXPLAIN'		=> 'From here you can edit the main configuration and look for the page.',
++	'PAGES_SELECT_TITLE_EXPLAIN'	=> 'Select the page to manage.',
++	'PAGES_TITLE'					=> 'Manage pages',
++	'PAGES_TITLE_EXPLAIN'			=> 'From here you can create/edit/delete additional pages for your forum. You can also edit the configuration and blocks on predefined pages.',
++	
++	'RIGHT_COLUMN'				=> 'Right column',
++	'RIGHT_COLUMN_EXPLAIN'		=> 'Width of the right column in pixels or percentage.<br />Set 0 to disable the column.',
++	'SHOW_FOOTER'				=> 'Show footer',
++	'SHOW_FOOTER_EXPLAIN'		=> 'This option lets you decide whether to display the forum footer on this page.',
++	'SHOW_HEADER'				=> 'Show header',
++	'SHOW_HEADER_EXPLAIN'		=> 'This option lets you decide whether to display the forum header on this page.',
++	'STYLE_DEFAULT'				=> 'Default style',
++	'STYLE_ALTERNATIVE'			=> 'Alternate style',
++	'STYLE_CONTENT_FULL'		=> 'Only content (with title)',
++	'STYLE_CONTENT_SIMPLE'		=> 'Only content (without title)',
++	'SUBMIT_CHANGES'			=> 'Apply changes',
++	'TARGET_PAGE_EXPLAIN'		=> 'Select the target page for the selected blocks.<br /><em>The blocks will be placed in it respective column</em>',
++	'TOP_COLUMN'				=> 'Top column',
++));
++
++// @general messages
++$lang = array_merge($lang, array(
++	'BLOCK_ADDED'					=> 'Block added successfully',
++	'BLOCK_COPIED'					=> 'Block(s) copied successfully',
++	'BLOCK_NEED_REQUIREMENTS'		=> 'The selected block will need some minimum requirements to be used.<br />See the documentation for more information.',
++	'BLOCK_MOVED'					=> 'Block(s) moved successfully',
++	'BLOCK_NOT_ADDED'				=> 'Error adding the block',
++	'BLOCK_NOT_EXISTS'				=> 'The selected block does not exist',
++	'BLOCK_NOT_UPDATED'				=> 'Error updating the block',
++	'BLOCK_POSITION_UPDATED'		=> 'Blocks position updated successfully',
++	'BLOCK_POSITION_NOT_UPDATED'	=> 'Error updating blocks position',
++	'BLOCK_REMOVED'					=> 'Block(s) removed successfully',
++	'BLOCK_UPDATED'					=> 'Block updated successfully',
++	'GROUPS_CHANGED'				=> 'Groups updated successfully',
++
++	'ITEM_REMOVED'				=> 'Element removed successfully',
++	'ITEM_UPDATED'				=> 'Element updated successfully',
++	'ITEM_ADDED'				=> 'Element added successfully',
++	'ITEM_NOT_ADDED'			=> 'Error adding the element',
++	'ITEM_NOT_UPDATED'			=> 'Error updating the element',
++
++	'PAGE_ADDED'				=> 'Page added successfully',
++
++	'PAGE_REMOVED'		=> array(
++		1	=> 'The page has been successfully removed',
++		2	=> '%d pages deleted successfully',
++	),
++
++	'PAGE_UPDATED'				=> 'Page configuration updated successfully',
++	'BLG_CONFIG_UPDATED'		=> 'Configuration updated successfully',
++
++	'CONFIRM_PAGE_DELETE'		=> 'Are you sure you wish to delete this page and all blocks in this?',
++));
++
++/**
++* Blocks names and explains from block_alias
++*/
++$lang = array_merge($lang, array(
++	'blocks'	=> array(
++		'announcements_title'		=> 'Announcements',
++		'announcements_explain'		=> 'Displays a set number of posts (announcements) of established forums.',
++		'attachments_title'			=> 'Attachments',
++		'attachments_explain'		=> 'Displays information and links to the specified attachments.',
++		'banners_title'				=> 'Banners',
++		'banners_explain'			=> 'Displays the specified list of banners. It\'s displayed in a fixed or scrolling form.',
++		'birthdays_title'			=> 'Birthdays',
++		'birthdays_explain'			=> 'Displays the list of birthdays for today and the next few days (optional).',
++		'empty_title'				=> 'Custom',
++		'empty_explain'				=> 'Totally blank block which can also include any text HTML, CSS, JavaScript, etc...',
++		'calendar_title'			=> 'Calendar',
++		'calendar_explain'			=> 'Calendar in which you can add custom events and show birthdays.',
++		'clock_title'				=> 'Clock',
++		'clock_explain'				=> 'Displays a clock in flash format (you can choose several models and add your own clock).',
++		'cloud_tag_title'			=> 'CloudTag',
++		'cloud_tag_explain'			=> 'Sample labels in a balloon in flash format. You can display the latest searched words or the users with more messages.',
++		'contact_title'				=> 'Contact',
++		'contact_explain'			=> 'Displays a standard contact form.',
++		'countdown_title'			=> 'CountDown',
++		'countdown_explain'			=> 'Show a countdown to the indicated date.',	
++		'counter_title'				=> 'Hit counter',
++		'counter_explain'			=> 'Displays a hit counter with statistics of visits, visits per day, visits per hour, weekly visits, visits per month and visits per year.',
++		'dockmenu_title'			=> 'Dock menu',
++		'dockmenu_explain'			=> 'Displays a menu with Mac Dock style with elements of the specified list.',
++		'forums_title'				=> 'Forums',
++		'forums_explain'			=> 'List with full or custom forums.',
++		'frame_title'				=> 'Frame',
++		'frame_explain'				=> 'Display a Web page, a PDF file, a Flash file or a text file within the block.', 
++		'gallery_title'				=> 'Photo gallery',
++		'gallery_explain'			=> 'Photo Gallery customizable with forum images (attachments) or external images. The images move and link the fate of each.',
++		'google_translate_title'	=> 'Google translator',
++		'google_translate_explain'	=> 'Block that allows you to translate the page on which it is installed, opening a new window and translating it through Google technology.',
++		'language_select_title'		=> 'Language select',
++		'language_select_explain'	=> 'It allows the user to view the forum with any language that is installed in the forum and set it as their default language.',
++		'latest_bots_title'			=> 'Bot\'s visits',
++		'latest_bots_explain'		=> 'Simple list of last bots who entered the forum and the date of their last visit.',
++		'latest_members_title'		=> 'Newest members',
++		'latest_members_explain'	=> 'List of latest sers registered on the forum and the date they were registered.',
++		'leaders_title'				=> 'Leaders',
++		'leaders_explain'			=> 'Displays a list of groups (customizable) with forum leaders.',
++		'link_us_title'				=> 'Link Us',
++		'link_us_explain'			=> 'Block that displays a user-selectable link to the page on which it is installed. You can set a mini banner attached to the link.',
++		'login_title'				=> 'Login',
++		'login_explain'				=> 'Allows a user to login directly from the block. Once identified, shows the user\'s primary information and links.',
++		'map_title'					=> 'Map',
++		'map_explain'				=> 'Displays a map that may contain marks with different locations.',
++		'menu_title'				=> 'Menu',
++		'menu_explain'				=> 'Menu in tree format that displays items from the selected list.',
++		'most_poster_title'			=> 'Most Posters',
++		'most_poster_explain'		=> 'Displays a dropdown with users who have posted more messages in the forum, and most relevant information.',
++		'news_title'				=> 'News',
++		'news_explain'				=> 'Dropdown menu showing the last posts of the specified forums as a news.',
++		'online_friends_title'		=> 'Friends online',
++		'online_friends_explain'	=> 'Simple list of friends and foes of the user, that are connected to the forum.',
++		'paypal_title'				=> 'Donations',
++		'paypal_explain'			=> 'Allows users to donate money through paypal.',
++		'player_title'				=> 'Music Player',
++		'player_explain'			=> 'Player to play songs in MP3 or WAV format. Allow to create a list of songs or use M3U, ASX or PLS playlists.',
++		'poll_title'				=> 'Poll',
++		'poll_explain'				=> 'Displays a single poll specified in its configuration.',
++		'poll_random_title'			=> 'Poll (random)',
++		'poll_random_explain'		=> 'Displays a selected number of polls that selected in random order, within the specified forum.',
++		'post_view_title'			=> 'Forum post',
++		'post_view_explain'			=> 'Displays the contents of a message. You can display the last message of a forum, the first or last post of a topic or a custom post.',
++		'quote_of_day_title'		=> 'Quote of day',
++		'quote_of_day_explain'		=> 'Shows a "quote" or phrase of the day or a different tip in each visit to the page.',
++		'random_member_title'		=> 'Random Member',
++		'random_member_explain'		=> 'Displays basic information and avatar of a random user.',
++		'ranks_title'				=> 'Ranks',
++		'ranks_explain'				=> 'Shows a list with the forum ranks.',
++		'recent_topics_title'		=> 'Recent Topics',
++		'recent_topics_explain'		=> 'Recent topics of the forum. Allow to select the forums from which to read the topics.',
++		'rss_title'					=> 'RSS Reader',
++		'rss_explain'				=> 'Show the latest articles from the specified RSS archives(feeds). Items will be displayed in scroll mode or accordion.', 
++		'share_title'				=> 'Share',
++		'share_explain'				=> 'Shows the buttons of most popular social networks in the desired format.',
++		'search_title'				=> 'Search',
++		'search_explain'			=> 'Allows users to do quickly searchs on the forum or in a search engine.',
++		'scroll_message_title'		=> 'Marquee',
++		'scroll_message_explain'	=> 'Text message that is rotating in the block. Allows use BBCode and HTML in the text.',
++		'stats_title'				=> 'Statistics',
++		'stats_explain'				=> 'Gets the most relevant information on the forum. This block shows the number of new messages and topics, the total number of posts and topics, message statistics and topics written per day, total number of attachments and the number of users that remaining active (posting messages).',
++		'style_select_title'		=> 'Style select',
++		'style_select_explain'		=> 'Allows the user to view the forum with any style that is installed on the forum and set it as their default style.',
++		'top_topics_title'			=> 'Top topics',
++		'top_topics_explain'		=> 'List of custom topics that can display the latest topics unread, the most active topics or the most viewed topics.',
++		'topic_index_title'			=> 'Topic Index',
++		'topic_index_explain'		=> 'Displays an orderly list with the topics of selected forums. The list can be order by topic title, topic date or topic last post date.',
++		'welcome_title'				=> 'Welcome',
++		'welcome_explain'			=> 'This block enables a different welcome message for guests and registered users. The block will decide which message display.',
++		'whos_online_title'			=> 'Who\'s online',
++		'whos_online_explain'		=> 'Displays the list of connected users (as is shown by default in the Index of the forum) and users who logged in last 24 hours.',
++		'youtube_title'				=> 'YouTube',
++		'youtube_explain'			=> 'Show videos or channels from youtube.',
++	)
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/acp_blocks.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/acp_blocks.php"
+new file mode 100644
+index 000000000..1a22369dd
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/acp_blocks.php"
+@@ -0,0 +1,478 @@
++<?php
++/*
++* acp_blocks.php [English [En]]
++*
++* @package cBB Blockgets
++* @version v2.0.2 12/01/2021
++*
++* @copyright (c) 2021 CaniDev
++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
++*/
++
++// @ignore
++if(!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if(empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++/**
++ * @acp_blockgets_pages
++*/
++$lang = array_merge($lang, array(
++	// Blocks global config
++	'BLOCK_COLLAPSE'			=> 'Allow collapse the block',
++	'BLOCK_COLLAPSE_EXPLAIN'	=> 'Enable or disable the ability for each user to collapse/expand this block and defines its initial state.',
++	'BLOCK_ENABLED'				=> 'Block enabled',
++	'BLOCK_ENABLED_EXPLAIN'		=> 'Defines whether this block display in the forum.',
++ 	'BLOCK_CURRENT_ICON'			=> 'Block icon',
++	'BLOCK_CURRENT_ICON_EXPLAIN'	=> 'Current icon set to the block.',
++	'BLOCK_GROUP'				=> 'Groups',
++	'BLOCK_GROUP_EXPLAIN'		=> 'Choose groups who may see this block in the forum.<br />You can select multiple groups using the <em>Ctrl</em> key on your keyboard.',
++	'BLOCK_NO_CONFIG'			=> 'This block does not require additional configuration',
++	'BLOCK_STYLE'				=> 'Look of the block',
++	'BLOCK_STYLE_EXPLAIN'		=> 'With this option you can choose the look of each block individually. Note that the way it is displayed depends on the style installed on the forum and its compatibility with the extension.',
++	'BLOCK_TITLE'				=> 'Block title',
++	'BLOCK_TITLE_EXPLAIN'		=> 'Unique name for your block.<br />This title will be shown in the block.<br />Limit: 100 characters.',
++
++	// Common tags
++	'ALL_FORUMS'				=> 'All forums',
++	'COLLAPSE_HIDDEN'			=> 'Allow (collapsed by default)',
++	'COLLAPSE_NONE'				=> 'Not Allow',
++	'COLLAPSE_VISIBLE'			=> 'Allow (displayed by default)',
++	'CONFIG'					=> 'Configuration',
++	'DESIGN_FULL'				=> 'Full',
++	'DESIGN_SIMPLE'				=> 'Simple',
++	'FORUMS'					=> 'Forums',
++	'FORUMS_EXPLAIN'			=> 'Forums that contain the topics to show. You can select as many as you like using the <em>Ctrl</em> key on your keyboard.',
++	'IGNORE_AUTH'				=> 'Ignore auth',
++	'IGNORE_AUTH_EXPLAIN'		=> 'If enabled, will be show all the content ignoring if the user have the permissions to view it.',
++	'NO_LISTS'					=> 'No avaliable lists',
++	'SHOW_PAGINATION'			=> 'Show pagination',
++	'SHOW_PAGINATION_EXPLAIN'	=> 'Show the pagination to allow user to view older posts.',
++	'TITLE_LIMIT'				=> 'Title limit',
++	'TITLE_LIMIT_EXPLAIN'		=> 'Maximum number of characters that will be displayed in the topic titles.<br />
++		<em>Set 0 to show the full title.</em>',
++	'TOPIC_DESIGN'				=> 'Block design',
++	'TOPIC_DESIGN_EXPLAIN'		=> 'Determine how the topics will be displayed in the block.<br />
++		<em><strong>Full:</strong> Show all information whenever possible.</em><br />
++		<em><strong>Simple:</strong> Show only basic information.</em>',
++	'TOPIC_PARENT_SHOW'			=> 'Show parent forum',
++	'TOPIC_PARENT_SHOW_EXPLAIN'	=> 'If enabled, a link to the forum for each topic will be displayed.',
++	
++	// age_ranges_block
++	'AGE_START'					=> 'Minimum age',
++	'AGE_END'					=> 'Maximum age',
++	'AGE_INTERVAL'				=> 'Interval',
++	
++	// announcements_block
++	'ANN_MAX_NUMBER'			=> 'Announcements number',
++	'ANN_MAX_NUMBER_EXPLAIN'	=> 'Maximum number of announcements that are displayed within the block.',
++	'ANN_MAX_SIZE'				=> 'Announcement size',
++	'ANN_MAX_SIZE_EXPLAIN'		=> 'Maximum size of characters allowed in announcements. The text is cut off if this value exceeds.',
++	'ANN_SHOW_GLOBALS'			=> 'Show global announcements',
++	'ANN_SHOW_GLOBALS_EXPLAIN'	=> 'If enabled, you also read the items marked as "global", otherwise only read simple announcements.',
++	'ANN_COLLAPSE'				=> 'Collapse announcements',
++	'ANN_COLLAPSE_EXPLAIN'		=> 'If enabled, the block only show one announcement and collapse the rest. Otherwise, the announcements will appear all at once on the block.',
++	
++	// attachments_block
++	'ATTACH_FORUM'				=> 'Forum attachments',
++	'ATTACH_FORUM_EXPLAIN'		=> 'If specified, only display attachments from this forum ignoring the rest.<br />The forum should be directly containing the topic where the attachment, the above categories or forums are ignored here.',
++	'ATTACH_EXTENSION'			=> 'Attachment extensions',
++	'ATTACH_EXTENSION_EXPLAIN'	=> 'If specified, all attachments which do not contain this extensions will be ignored.<br />Split the extensions with ",".<<br />Ex. valid extensions: jpg,png,gif...',
++	'ATTACH_NUM'				=> 'Attachment number',
++	'ATTACH_NUM_EXPLAIN'		=> 'Maximum number of attachments that are displayed simultaneously in the block.',
++	'ATTACH_SPECIFIC'			=> 'Specific attachment',
++	'ATTACH_SPECIFIC_EXPLAIN'	=> 'If specified, only attachment with the specified name will be show in the block. The field must contain the original filename of the attachment, Ex: myfile.jpg<br /><br /><strong>Note:</strong> this field overrides the other fields.',
++
++	// banners_block, banners_multiple_block
++	'BANNERS_TITLE'				=> 'Banner title',
++	'BANNERS_TITLE_EXPLAIN'		=> 'If enabled, the title will be appear below the banners in the block.',
++	'BANNERS_LS_TYPE'			=> 'List type',
++	'BANNERS_LS_TYPE_EXPLAIN'	=> 'Define how to display the banners.<br />Can be set a horizontal, vertical scroll or remain fixed.',
++	'BANNERS_NUMBER'			=> 'Banners to show',
++	'BANNERS_NUMBER_EXPLAIN'	=> 'Maximum number of banners to display on the block.<br />
++		<em>Set 0 to show all the list.</em>',
++	'BANNERS_RANDOM'			=> 'Random order',
++	'BANNERS_RANDOM_EXPLAIN'	=> 'Set if the elements will be show in the list order or in a random order.',
++	'LIST_NO_SCROLL'			=> 'No Scroll',
++	'LIST_SCROLL_H'				=> 'Horizontal scroll',
++	'LIST_SCROLL_V'				=> 'Vertical scroll',
++	'BANNERS_B_HEIGHT'			=> 'Block height',
++	'BANNERS_B_HEIGHT_EXPLAIN'	=> 'Enter the height of the block that will be used to scroll lists.',
++
++	// birthdays_block
++ 	'NEXT_BIRTHDAYS'			=> 'Upcoming Birthdays',
++ 	'NEXT_BIRTHDAYS_EXPLAIN'	=> 'Show birthdays that occur in the coming days.<br />
++ 		<em>Maximum 30 days. Set to 0 to disable it.</em>',
++
++	// calendar_block
++ 	'CALENDAR_BIRTHDAYS'			=> 'Show Birthdays',
++ 	'CALENDAR_BIRTHDAYS_EXPLAIN'	=> 'If enabled, the users birthdays are marked and displayed in the calendar, like events.',
++ 	'CALENDAR_EVENTS'				=> 'Show events',
++ 	'CALENDAR_EVENTS_EXPLAIN'		=> 'If enabled, events are marked and displayed in the calendar.',
++ 	'CALENDAR_MONTHS'				=> 'Months to show',
++ 	'CALENDAR_MONTHS_EXPLAIN'		=> 'Number of months to be displayed simultaneously on the block.',
++
++	// contact block
++	'CONTACT_CHECK_EMAIL'			=> 'Check email',
++	'CONTACT_CHECK_EMAIL_EXPLAIN'	=> 'If enabled, the domain of the user email will be checked and validated.',
++	'CONTACT_EMAIL'					=> 'Target email',
++	'CONTACT_HIDE_FIELDS'			=> 'Hide user data',
++	'CONTACT_HIDE_FIELDS_EXPLAIN'	=> 'If enabled, the "Name" and "Email" fields for the register users will be hidden and the block will be used their profile values.',
++ 
++	// countdown block
++	'COUNTDOWN_COMPLETE_MSG'			=> 'Text upon completion',
++	'COUNTDOWN_COMPLETE_MSG_EXPLAIN'	=> 'Text to be displayed when the counter reaches 0.',
++	'COUNTDOWN_TARGET'					=> 'Deadline',
++	'COUNTDOWN_TARGET_EXPLAIN'			=> 'Set the date and time the counter will reach 0.<br /><br />
++		<em><strong>Valid formats</strong>
++			<br />Year/Month/Day
++			<br />Year/Month/Day Hour:Minute:Second
++		</em>',
++	'COUNTDOWN_RUNNING_MSG'				=> 'Hold text',
++	'COUNTDOWN_RUNNING_MSG_EXPLAIN'		=> 'Text to be displayed while the counter is running.',
++
++	// counter block
++	'COUNTER_LOCAL'				=> 'Local counter',
++	'COUNTER_LOCAL_EXPLAIN'		=> 'If enabled, the counter only show the visits to it\'s page, otherwise, the counter show the total visits to the forum.',
++
++	// empty_block
++	'BLOCK_CONTENT'				=> 'Block content',
++	'BLOCK_CONTENT_EXPLAIN'		=> 'Content to display on the block.<br />Limit: 8000 characters.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
++
++	// clock_block
++	'DISPLAY_CLOCK'				=> 'Clock to show',
++	'DISPLAY_CLOCK_EXPLAIN'		=> 'Clock displayed on the block.',
++	'PREVIEW_CLOCK'				=> 'Preview',
++	'PREVIEW_CLOCK_EXPLAIN'		=> 'Selected clock preview.',
++
++	// cloud_tags_block
++	'CLOUD_ANIMATION'			=> 'Animation enabled',
++	'CLOUD_ANIMATION_EXPLAIN'	=> 'If enabled, the words "tags" appear in an animated cloud tag, otherwise, they appear as fixed words in block.',
++	'CLOUD_MODE'				=> 'Words type',
++	'CLOUD_MODE_EXPLAIN'		=> 'Specifies that words will be shown in block.',
++	'CLOUD_WORDS'				=> 'Words number',
++	'CLOUD_WORDS_EXPLAIN'		=> 'Maximum number of words that appear in the block.',
++	'MODE_SEARCH'				=> 'Last searched words',
++	'MODE_USERS'				=> 'Users with most posts',
++	
++	// forums block
++	'FORUMS_FORUM'		=> 'Forum to show',
++	
++	// frame_block
++	'MIME_HTML'			=> 'Web page',
++	'MIME_PDF'			=> 'PDF file',
++	'MIME_PLAIN'		=> 'Plain Text file',
++
++	'FRAME_HEIGHT'				=> 'Frame height',
++	'FRAME_HEIGHT_EXPLAIN'		=> 'Frame height in pixels. Set to 0 to auto adjust.',
++	'FRAME_MIMETYPE'			=> 'Document type',
++	'FRAME_MIMETYPE_EXPLAIN'	=> 'The document type displayed in the frame.',
++	'FRAME_URL'					=> 'Document URL',
++	'FRAME_URL_EXPLAIN'			=> 'URL of the document or page displayed in the frame.',
++	'FRAME_WIDTH'				=> 'Frame width',
++	'FRAME_WIDTH_EXPLAIN'		=> 'Frame width in pixels. Set to 0 to auto adjust.',
++	
++	// gallery_block
++	'GALLERY_CUSTOM'				=> 'Custom images',
++	'GALLERY_CUSTOM_EXPLAIN'		=> 'Specify the list containing the images to be displayed.',
++	'GALLERY_DIRECTION'				=> 'Scroll direction',
++	'GALLERY_FORUMS'				=> 'Forums',
++	'GALLERY_FORUMS_EXPLAIN'		=> 'Defines the forums to read the attachments.',
++	'GALLERY_FPS'					=> 'Scroll speed',
++	'GALLERY_HEIGHT'				=> 'Gallery height',
++	'GALLERY_MANAGE'				=> 'Manage gallery',
++	'GALLERY_MARGIN'				=> 'Image margin',
++	'GALLERY_MAX_NUMBER'			=> 'Number of images',
++	'GALLERY_MAX_NUMBER_EXPLAIN'	=> 'Maximum attachments that will be read from the forums/topics/posts',
++	'GALLERY_POSTS'					=> 'Posts',
++	'GALLERY_POSTS_EXPLAIN'			=> 'Posts IDs to read the attachments, splitted with commas. (Ex: 1,2,3).',
++	'GALLERY_SOURCE'				=> 'Origin of the images',
++	'GALLERY_SOURCE_EXPLAIN'		=> 'Define what type of images will be loaded from the forums, topics or messages specified.',
++	'GALLERY_TOPICS'				=> 'Topics',
++	'GALLERY_TOPICS_EXPLAIN'		=> 'Topics IDs to read the attachments, splitted with commas. (Ex: 1,2,3).',
++	'GALLERY_ZOOM'					=> 'Zoom',
++	'GALLERY_ZOOM_EXPLAIN'			=> 'Size difference on image\'s mouse over (in pixels)',
++	
++	'GALLERY_SOURCE_ALL'			=> 'All',
++	'GALLERY_SOURCE_ATTACHMENTS'	=> 'Only attachments',
++	'GALLERY_SOURCE_IMAGES'			=> 'Only embedded images',
++	
++	'IMG_TITLE'			=> 'Image title',
++	'IMG_URL'			=> 'Image url',
++	'IMG_URL_EXPLAIN'	=> 'Url of an JPG, GIF or PNG image. Ej:http://mydomain.com/image.jpg',
++	
++	// google_translate_block
++	'GOOGLE_LANGS'		=> 'Languages to show in the block',
++	'GOOGLE_SHOW_NAMES'			=> 'Show names',
++	'GOOGLE_SHOW_NAMES_EXPLAIN'	=> 'If enabled, the language name will be displayed next to its flag.',
++	
++	// latest_bots_block
++	'BOTS_NUMBER'				=> 'Bots to show',
++	'BOTS_NUMBER_EXPLAIN'		=> 'Maximum number of last visit bots that will be shown in the block.',
++
++	// latest_members_block
++	'MEMBERS_NUMBER'			=> 'Users to show',
++	'MEMBERS_NUMBER_EXPLAIN'	=> 'Maximum number of users that will be shown in block.',
++	
++	// leaders_block
++	'LEADERS_ALL_GROUPS'			=> 'Show users in all their groups',
++	'LEADERS_ALL_GROUPS_EXPLAIN'	=> 'If enabled, users will be shown in all groups of which they are members.
++		Otherwise they will only be shown in their default group.',
++	'LEADERS_GROUPS'				=> 'Groups',
++	'LEADERS_GROUPS_EXPLAIN'		=> 'Groups that will be show in the block. If you don\'t select groups, the block will be show the Administrators and Moderators.',
++	'LEADERS_MODE'					=> 'Display mode',
++	'LEADERS_MODE_ACCORDION'		=> 'Accordion',
++	'LEADERS_MODE_SIMPLE'			=> 'Simple List',
++	'LEADERS_ONLY_ONLINE'			=> 'Online users only',
++	'LEADERS_ONLY_ONLINE_EXPLAIN'	=> 'If enabled, only users from selected groups who are logged in will be displayed.',
++
++	// link_us_block
++	'US_BANNER'					=> 'Mini banner link',
++	'US_BANNER_EXPLAIN'			=> 'Mini banner that will be the image that you have to click to access the forum from the link.',
++
++	// Login Block
++ 	'FULL_LOGIN'				=> 'Show Full login',
++ 	'FULL_LOGIN_EXPLAIN'		=> 'Enable/disable the advanced options in the user identification.',
++ 	'SHOW_REGISTER'				=> 'Show register',
++ 	'SHOW_REGISTER_EXPLAIN'		=> 'Display option for the user registration.',
++	
++	// map_block
++	'LATITUDE'					=> 'Latitude',
++	'LONGITUDE'					=> 'Longitude',
++	'LOCATION_ADD'				=> 'Add location',
++	'LOCATION_EDIT'				=> 'Edit location',
++	'LOCATION_IMAGE'			=> 'Image',
++	'LOCATION_IMAGE_EXPLAIN'	=> 'Image that will mark the point on the map.<br /><em>If you do not define any, the default mark will be used</em>.',
++	'LOCATION_INCORRECT'		=> 'he position entered is incorrect.',
++	'LOCATION_POSITION'			=> 'Position',
++	'LOCATION_POSITION_EXPLAIN'	=> 'Defines the latitude and longitude of the location.',
++	'LOCATION_TEXT'				=> 'Content',
++	'LOCATION_TEXT_EXPLAIN'		=> 'Text to be displayed on the map, by clicking on the location icon.<br /><em>BBcode is allowed.</em>',
++	'LOCATION_TITLE'			=> 'Title',
++	'MAP'						=> 'Map',
++	'MAP_CENTER'				=> 'Central point',
++	'MAP_CENTER_EXPLAIN'		=> 'Defines the latitude and longitude of the default center point.',
++	'MAP_LOCATIONS'				=> 'Locations',
++	'MAP_ZOOM'					=> 'Zoom',
++	'MAP_ZOOM_EXPLAIN'			=> 'Set the default zoom.',
++	'SEARCH_ADDRESS'			=> 'Search location',
++	'SELECT_LOCATION'			=> 'Select location',
++
++	// menu_block
++	'DISPLAY_MENU'				=> 'Menu to show',
++	'DISPLAY_MENU_EXPLAIN'		=> 'Menu to be displayed in the block. The menu must be previously created in the correct section to be reflected here.',
++ 	'ICON_WIDTH'				=> 'Icon width',
++ 	'ICON_WIDTH_EXPLAIN'		=> 'The width of the block icons, in pixels.',
++
++	// most_poster_block
++	'POSTER_LIMIT'				=> 'User Limit',
++	'POSTER_LIMIT_EXPLAIN'		=> 'The limit of users that are displayed on the block.',
++ 	'POST_RANGE'				=> 'Message range',
++ 	'POST_RANGE_EXPLAIN'		=> 'Time limit for the message count.',
++ 
++ 	'ALL_POSTS'			=> 'All messages',
++ 	'LAST_DAY'			=> 'Last day',
++ 	'LAST_WEEK'			=> 'Last week',
++ 	'LAST_MONTH'		=> 'Last month',
++ 	'LAST_YEAR'			=> 'Last year',
++
++	// news_block
++	'NEWS_DISPLAY'				=> 'Information to show',
++	'NEWS_DISPLAY_EXPLAIN'		=> '<em><strong>Basic content:</strong>Show title, author and date.<br />
++		<strong>Full content:</strong>Show all news information.</em>',
++	'NEWS_NUMBER'				=> 'News number',
++	'NEWS_NUMBER_EXPLAIN'		=> 'Maximum number of news items displayed in the block.',
++	'NEWS_SIZE'					=> 'News size',
++	'NEWS_SIZE_EXPLAIN'			=> 'Maximum size of characters allowed in the news. The text of the news will be cut if this value exceeds.',
++	'NEWS_ALL'					=> 'Show all topics',
++	'NEWS_ALL_EXPLAIN'			=> 'If enabled, you also read the items marked as "announcement" and "fixed", otherwise, only read the "normal" topics.',
++	'NEWS_COLLAPSE'				=> 'Collapse news',
++	'NEWS_COLLAPSE_EXPLAIN'		=> 'If enabled, the block only show one notice and collapse the rest. Otherwise, the news will appear all at once on the block.',
++	'NEWS_SHOW_FULL'			=> 'Complete content',
++	'NEWS_SHOW_SIMPLE'			=> 'Basic content',
++	
++	// paypal_block
++	'PAYPAL_ACCOUNT'			=> 'Paypal account',
++	'PAYPAL_ACCOUNT_EXPLAIN'	=> 'Enter the e-mail address of your Paypal account ex: xxx@xxx.com',
++	'PAYPAL_ITEM'				=> 'Payment description',
++	'PAYPAL_ITEM_EXPLAIN'		=> 'Enter the name (description) to which payments will be identified through the block.',
++	'PAYPAL_MSG'				=> 'Message',
++	'PAYPAL_MSG_EXPLAIN'		=> 'Customizable message that will appear in the block.<br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
++	'PAYPAL_IMG'				=> 'Button Image',
++ 	'PAYPAL_IMG_EXPLAIN'		=> 'Image to be used for the "donate" button. Leave this field blank to use the default image.', 
++	'PAYPAL_AMOUNTS'			=> 'Amounts',
++	'PAYPAL_AMOUNTS_EXPLAIN'	=> 'Money amount in the select. Split the values with ";" (Ex: 5;10;15).',
++	'PAYPAL_CURRENCIES'			=> 'Currencies',
++	'PAYPAL_CURRENCIES_EXPLAIN'	=> 'Type of currency that will be show in the block. You can select more that one and select the default currency.',
++	
++	//player block
++	'PLAYER_AUTOPLAY'			=> 'Autoplay',
++	'PLAYER_AUTOPLAY_EXPLAIN'	=> 'Defines whether the player will automatically start playing the tracks when the page loads.<br /><br />
++		<em><strong>Note:</strong>Browsers limit this feature so playback will not begin until the user clicks anywhere on the page.</em>',
++	'PLAYER_PLAYLIST'			=> 'Show playlist',
++	'PLAYER_PLAYLIST_EXPLAIN'	=> 'Defines if the playlist is displayed in the player.',
++	'PLAYER_TRACKLIST'			=> 'Tracklist',
++	'PLAYER_TRACKLIST_EXPLAIN'	=> 'The player tracks or songs.',
++
++	'TRACK_TITLE'			=> 'Track title',
++	'TRACK_TITLE_EXPLAIN'	=> 'the name or title displayed in the player.',
++	'TRACK_URL'				=> 'Track URL',
++	'TRACK_URL_EXPLAIN'		=> 'A radio URL (Ex: http://127.0.0.1:8888), a mp3 or wav audio file (Ex: http://myserver.com/audio.mp3) or a valid playlist file (m3u, asx, pls).',
++
++	// poll_block
++	'DISPLAY_POLL'				=> 'Poll to show',
++	'DISPLAY_POLL_EXPLAIN'		=> 'Poll displayed in the block.',
++	'DISPLAY_RESULTS'			=> 'Show results',
++	'NO_POLLS'					=> 'No polls available',
++
++	// poll_random_block
++	'POLL_FORUM'				=> 'Poll forum',
++	'POLL_FORUM_EXPLAIN'		=> 'Forum containing the polls that show on the block.',
++	'POLL_NUM'					=> 'Poll number',
++	'POLL_NUM_EXPLAIN'			=> 'The number of polls that will be displayed at once within the block.',
++	'NO_FORUMS'					=> 'No forums avaliable',
++	
++	// post_view_block
++	'PV_ITEM_URL'			=> 'Referral URL',
++	'PV_ITEM_URL_EXPLAIN'	=> 'Specify here the URL of the forum, topic or message you want to display.<br />
++		<em><strong>Note:</strong> The url of a forum or topic will display it\'s last message.</em>',
++	
++	// quote_of_day_block
++	'QUOTE_AUTHOR'				=> 'Quote author',
++	'QUOTE_TEXT'				=> 'Quote Text',
++	'QUOTES_ALL_DAY'			=> 'Keep all day',
++	'QUOTES_ALL_DAY_EXPLAIN'	=> 'If enabled, you will see the same quote all day. Otherwise, every time the page loads you will see a different quote.',
++	'QUOTES_LIST'				=> 'Quote list',
++	'QUOTES_RAND'				=> 'Random order',
++	'QUOTES_RAND_EXPLAIN'		=> 'Defines if the quotes are displayed in random order or maintaining the order of the list.',
++	'QUOTES_SHOW_AUTHOR'		=> 'Show author',
++	'QUOTES_SHOW_AUTHOR_EXPLAIN'	=> 'Defines whether to display the author of the quote on the block.',
++	
++	// ranks_block
++	'ORPHAN_RANKS'				=> 'Show orphan ranks',
++	'ORPHAN_RANKS_EXPLAIN'		=> 'If enabled, will show the ranges are not assigned to any user.',
++	'ONLY_SPECIAL_RANKS'		=> 'Only special ranks',
++	
++	// recent_topics_block
++	'RECENT_FORUMS'					=> 'Topic forums',
++	'RECENT_FORUMS_EXPLAIN'			=> 'Forums containing items to be displayed. If you do not select any, it will use all the forums. You can select as many as you like using the <em>Ctrl</em> key on your keyboard.',
++	'RECENT_SECTIONS'				=> 'Sections',
++	'RECENT_SECTIONS_EXPLAIN'		=> 'Define the sections to be displayed in the block and their order.',
++	'RECENT_TOPIC_LIMIT'			=> 'Topic limit',
++	'RECENT_TOPIC_LIMIT_EXPLAIN'	=> 'Maximum number of items to be displayed in each tab.',
++
++	// Rss block
++	'1_HOUR'		=> 'One hour',
++	'2_HOURS'		=> 'Two hours',
++	'6_HOURS'		=> 'Siz hours',
++	
++	'RSS_COLLAPSABLE'			=> 'Collapsable',
++	'RSS_COLLAPSABLE_EXPLAIN'	=> 'Sets whether the items are displayed in an accordion or scrolling. If set to "Yes" will override the block scroll.',
++	'RSS_DIRECTION'				=> 'Scroll direction',
++	'RSS_DIRECTION_EXPLAIN'		=> 'Defining the direction of scrolling text. This option is canceled if the items are displayed in an accordion.',
++	'RSS_HEIGHT'				=> 'Block height',
++	'RSS_HEIGHT_EXPLAIN'		=> 'Sets the height of the block, in pixels. Only apply if items are not displayed in accordion format.',
++	'RSS_IGNORE_LANG'			=> 'Ignore feed lang',
++	'RSS_IGNORE_LANG_EXPLAIN'	=> 'If enabled, all URLs are read, regardless of their language, otherwise it will only display the contents written in the language of the user.',
++	'RSS_LIMIT'					=> 'Feed limit',
++	'RSS_LIMIT_EXPLAIN'			=> 'Maximum number of items to be read from each URL.',
++	'RSS_SOURCES'				=> 'Feed sources',
++	'RSS_TITLE'					=> 'Feed title',
++	'RSS_TTL'					=> 'Refresh time',
++	'RSS_TTL_EXPLAIN'			=> 'Time will remain cached items before attempting to read the source again.',
++	'RSS_URL'					=> 'File url',
++	'RSS_URL_EXPLAIN'			=> 'Ex: <em>http://midominio.com/rss.xml</em>',
++
++	// scroll_message_block
++	'MARQUEE_DIRECTION'				=> 'Scroll direction',
++	'MARQUEE_DIRECTION_EXPLAIN'		=> 'Scroll direction for the text. This attribute controls the direction of scrolling.',
++	'MARQUEE_SPEED'					=> 'Scroll amount',
++	'MARQUEE_SPEED_EXPLAIN'			=> 'This controls the amount of movement (in pixels) between the successive displays that give the impression of animation.',
++	'MARQUEE_SCROLLDELAY'			=> 'Scroll delay',
++	'MARQUEE_SCROLLDELAY_EXPLAIN'	=> 'This controls the delay (in milliseconds) between the successive displays that give the impression of animation.',
++	'MARQUEE_ALIGN'					=> 'Scroll align',
++	'MARQUEE_ALIGN_EXPLAIN'			=> 'This tag controls the positioning of the marquee display box relative to the current text in exactly the same manner as the img tag\'s align attribute.',
++	'MARQUEE_BGCOLOR'				=> 'Scroll bgcolor',
++	'MARQUEE_BGCOLOR_EXPLAIN'		=> 'This tag controls the background colour of the display box.',
++	'MARQUEE_HEIGHT'				=> 'Scroll height',
++	'MARQUEE_HEIGHT_EXPLAIN'		=> 'This controls the height of the display box.',
++	'MARQUEE_PADDING'				=> 'ScrollBox Padding',
++	'MARQUEE_PADDING_EXPLAIN'		=> 'Space around the scroll box. This attribute is equivalent to the attribute "padding" of CSS.',
++	'MARQUEE_TEXT'					=> 'Scroll message text',
++	'MARQUEE_TEXT_EXPLAIN'			=> 'Add/change a scrollable message here. Limit 2000 characters.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
++
++	'BOTTOM'		=> 'Bottom',
++	'DOWN'			=> 'Down',
++	'LEFT'			=> 'Left',
++	'CENTER'		=> 'Center',
++	'UP'			=> 'Up',
++	'RIGHT'			=> 'Right',
++	'TOP'			=> 'Top',
++	
++	//share_block
++	'SHARE_SHOW_NAMES'			=> 'Show names',
++	'SHARE_SHOW_NAMES_EXPLAIN'	=> 'If enabled, the name of the social network will be displayed next to its icon.',
++	'SHARE_URL'					=> 'Reference URL',
++	'SHARE_URL_EXPLAIN'			=> 'Set a fixed reference url for the buttons. Leave this field blank to use the displayed page.',
++	'SHARE_BUTTONS'				=> 'Buttons to show',
++	
++	// stats_block
++	'STATS_INLINE'			=> 'Show data in line',
++ 	'USER_STATS'			=> 'Display user statistics',
++	
++	// top_topics_block
++	'TOPT_LIMIT'			=> 'Topic limit',
++	'TOPT_LIMIT_EXPLAIN'	=> 'Maximun number of topic to show.',
++	'TOPT_MODE'				=> 'Topic to show',
++	'TOPT_MODE_ACTIVE'		=> 'Latest topics more active',
++	'TOPT_MODE_UNREAD'		=> 'Latest unread topics',
++	'TOPT_MODE_VIEWED'		=> 'More viewed topics',
++
++	// topic_index_block
++	'TINDEX_CHAR_SELECT'			=> 'Show Index',
++	'TINDEX_CHAR_SELECT_EXPLAIN'	=> 'Only avaliable if the sort method is <em>Topic title</em>.',
++	'TINDEX_PER_PAGE'			=> 'Topics per page',
++	'TINDEX_PER_PAGE_EXPLAIN'	=> 'Number of topics that will be show at the same time. Set 0 to disable pagination.',
++	'TINDEX_SORT_MODE'			=> 'Order by',
++	'TINDEX_SORT_MODE_EXPLAIN'	=> 'Method that will be used to set the topic\'s order in the list.',
++  
++	'TOPIC_TIME'		=> 'Topic date',
++	'LAST_POST_TIME'	=> 'Last post date',
++
++	// welcome_block
++	'WELCOME_GUEST'				=> 'Guests message',
++	'WELCOME_GUEST_EXPLAIN'		=> 'Message to display to all guests. 2000 characters max.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
++	'WELCOME_MEMBER'			=> 'Members message',
++	'WELCOME_MEMBER_EXPLAIN'	=> 'Message to display to all the forum registered users. 2000 characters max.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
++
++	// whos_online_block
++	'WHOS_ADVANCED'				=> 'Advanced mode',
++	'WHOS_ADVANCED_EXPLAIN'		=> 'If enabled, will display all the information, otherwise it will appear only basic information (suitable for side blocks).',
++	'WHOS_USERNAMES'			=> 'Show user list',
++	'WHOS_USERNAMES_EXPLAIN'	=> 'If enabled, displays the list of users online (only in advanced mode).',
++
++	// youtube_block
++	'YT_AUTOPLAY'				=> 'AutoPlay enabled',
++	'YT_AUTOPLAY_EXPLAIN'		=> 'If enabled, the video will play automatically.<br />If you have multiple videos, only the first autoplay.',
++	'YT_DISPLAY_MODE'			=> 'Display Mode',
++	'YT_FULL_PREVIEW'			=> 'Show thumbnails, title and description',
++	'YT_LIST'					=> 'Show a list with titles',
++	'YT_RANDOM_DISPLAY'			=> 'Random Display',
++	'YT_RANDOM_DISPLAY_EXPLAIN'	=> 'If enabled, only one video will be appear randomly. Otherwise, all the videos and channels appear at once.',
++	'YT_RESULT_LIMIT'			=> 'Number of channel videos',
++	'YT_RESULT_LIMIT_EXPLAIN'	=> 'Maximun number of videos loaded in each channel.',
++	'YT_SIMPLE_PREVIEW'			=> 'Show thumbnails and titles',
++	'YT_TEXT_LIMIT'				=> 'Text limit',
++	'YT_TEXT_LIMIT_EXPLAIN'		=> 'Maximun number of characters in the video description.',
++	'YT_VIDEO_PREVIEW'			=> 'Show video preview',
++	'YT_VIDEO_SIZE'				=> 'Player size',
++	'YT_VIDEO_TITLE'			=> 'Video title',
++	'YT_VIDEO_URL'				=> 'Video url',
++	'YT_VIDEO_URL_EXPLAIN'		=> 'Ex: <em>https://www.youtube.com/watch?v=NHH_v0k7Gus</em>',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/chat_addon.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/chat_addon.php"
+new file mode 100644
+index 000000000..726889601
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/chat_addon.php"
+@@ -0,0 +1,32 @@
++<?php
++/** 
++* chat_addon.php [English [En]]
++*
++* @package language cBB Blockgets
++* @version v2.0.1 04/05/2018
++*
++* @copyright (c) 2018 CaniDev
++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
++*/
++
++// @ignore
++if(!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if(empty($lang['blocks']))
++{
++	$lang['blocks'] = array();
++}
++
++$lang['blocks'] = array_merge($lang['blocks'], array(
++	'chat_title'	=> 'Chat',
++	'chat_explain'	=> 'Allows you to use cBB Chat as a block in the columns or show the users connected to the chat.',
++));
++
++$lang = array_merge($lang, array(
++	'CHAT_ADDON_MODE'		=> 'Display mode',
++	'CHAT_MODE_CHAT'		=> 'Chat room',
++	'CHAT_MODE_USERS'		=> 'Online Users',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/email/contact_block.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/email/contact_block.txt"
+new file mode 100644
+index 000000000..5ee2e8c3e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/email/contact_block.txt"
+@@ -0,0 +1,6 @@
++
++The following is an e-mail sent to you from "{SITENAME}" for {FROM_USERNAME} by the contact form:
++
++----------
++
++{MESSAGE}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/info_acp_blockgets.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/info_acp_blockgets.php"
+new file mode 100644
+index 000000000..263814a48
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/info_acp_blockgets.php"
+@@ -0,0 +1,53 @@
++<?php
++/*
++* info_acp_blockgets.php [English [En]]
++* @package cBB Blockgets
++* @version v2.0.2 12/01/2021
++*
++* @copyright (c) 2021 CaniDev
++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
++*/
++
++// @ignore
++if(!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++/**
++ * @general tags and messages
++*/
++$lang = array_merge($lang, array(
++	'ACP_BLOCKGETS'				=> 'Blockgets',
++	'ACP_BLOCKGETS_GENERAL'		=> 'General',
++	
++	'ACP_BLG_CONFIG_MAIN'		=> 'General configuration',
++	'ACP_BLG_CONFIG_OPTIONAL'	=> 'Additional configuration',
++	'ACP_BLG_IMAGES'			=> 'Images',
++	'ACP_PAGES_AND_BLOCKS'		=> 'Pages and Blocks',
++	
++	// Logs
++	'LOG_BLG_CONFIG'		=> '<strong>cBB Blockgets:</strong> Changed main configuration',
++	'LOG_BLOCK_ADDED'		=> '<strong>cBB Blockgets:</strong> New block added<br />» %1$s in %2$s',
++	'LOG_BLOCK_COPY_PAGE'	=> '<strong>cBB Blockgets:</strong> Blocks copied<br />» de %1$s a %2$s',
++	'LOG_BLOCK_MOVED'		=> '<strong>cBB Blockgets:</strong> Changed blocks position<br />» %1$s',
++	'LOG_BLOCK_MOVED_PAGE'	=> '<strong>cBB Blockgets:</strong> Blocks moved<br />» from %1$s to %2$s',
++	'LOG_BLOCK_REMOVED'		=> '<strong>cBB Blockgets:</strong> Block(s) deleted<br />» en %1$s',
++	'LOG_BLOCK_UPDATED'		=> '<strong>cBB Blockgets:</strong> Block edited<br />» %1$s en %2$s',
++	'LOG_EVENT_REMOVED'		=> '<strong>cBB Blockgets:</strong> Event deleted<br />» %1$s',
++	'LOG_LIST_REMOVED'		=> '<strong>cBB Blockgets:</strong> List deleted<br />» %1$s',
++	'LOG_PAGE_ADDED'		=> '<strong>cBB Blockgets:</strong> New page added<br />» %1$s',
++	'LOG_PAGE_UPDATED'		=> '<strong>cBB Blockgets:</strong> Changed page<br />» %1$s',
++	'LOG_PAGE_REMOVED'		=> '<strong>cBB Blockgets:</strong> Page deleted<br />» %1$s',
++	
++	// Permissions
++	'ACL_A_BLOCKGETS_MANAGE'	=> 'Can manage cBB Blockgets',
++	'ACL_U_BLOCKGETS_BIRTHDAYS'	=> 'Can see birthdays in the Calendar',
++	'ACL_U_BLOCKGETS_CALENDAR'	=> 'Can view calendar',
++	'ACL_U_BLOCKGETS_EVENTS'	=> 'Can manage calendar events',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/installer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/installer.php"
+new file mode 100644
+index 000000000..f9a800fc4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/installer.php"
+@@ -0,0 +1,43 @@
++<?php
++/*
++* installer.php [English [En]]
++* @package cBB Blockgets
++* @version v2.0.2 12/01/2021
++*
++* @copyright (c) 2021 CaniDev
++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
++*/
++
++// @ignore
++if(!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if(empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++// Local Variables
++$lang = array_merge($lang, array(
++	'PORTAL'			=> 'Portal',
++	'DOCK_MENU'			=> 'Dock menu',
++	'MAIN_MENU'			=> 'Main Menu',
++	'RECOMMENDED'		=> 'Recommended',
++
++	'P_ADMIN'			=> 'Administration',
++	'P_MAIN'			=> 'Main',
++	'P_MCP'				=> 'Moderation Panel',
++	'P_ACP'				=> 'Administration Panel',
++
++	'PHPBB_TITLE'		=> 'phpBB official website',
++	'XAMPP_TITLE'		=> 'Xampp',
++	'SOURCEFORGE_TITLE'	=> 'Open source applications',
++
++	'WELCOME_GUEST'		=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Forum equipped with cBB Blockgets</i><br /><br />Welcome to our forum!<br />Register to access all the content!.</strong></div>[/html]',
++	'WELCOME_MEMBER'	=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Forum equipped with cBB Blockgets</i><br /><br />Welcome back to our forum {S_USERNAME}</strong></div>[/html]',	
++
++	'CORE_INSTALL_ERROR'	=> 'You have not uploaded all the files from the installation package or you are trying to install an old package.<br />
++		Please make sure to upload all the files (including the <em>core</em> folder) and use a package downloaded from the official website.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/main.php"
+new file mode 100644
+index 000000000..9100727fa
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/main.php"
+@@ -0,0 +1,269 @@
++<?php
++/*
++* main.php [English [En]]
++* @package cBB Blockgets
++* @version v2.0.2 12/01/2021
++*
++* @copyright (c) 2021 CaniDev
++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
++*/
++
++// @ignore
++if(!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if(empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'PORTAL'			=> 'Portal',
++	'READ_FULL'			=> 'Read full topic',
++	'BLG_READ_MORE'		=> '%sLer mais%s',
++
++	'ADD_PAGE'					=> 'Criar página',
++	'BANNERS'					=> 'Banners',
++	'CALENDAR'					=> 'Calendário',
++	'CALENDAR_BIRTHDAY_TITLE'	=> '%1$s e <strong>mais %2$d</strong>.',
++	'CALENDAR_SELECT_DATE'		=> 'Seleccionar data',
++	'EDIT_CONFIGURATION'		=> 'Editar configuração',
++	'EDIT_THIS_PAGE'			=> 'Editar esta página',
++	'EDITOR'					=> 'Editor',
++	'EXPAND_CONTRACT'			=> 'Expandir/colapsar',
++	'INSERT_ON_ENTRY'			=> 'Inserir no texto',
++	'MANAGE_BLOCKS'				=> 'Gerir blocos',
++	'PRINT'						=> 'Imprimir',
++	'SELECT_COLOUR'				=> 'Seleccionar cor',
++	'SMILIES'					=> 'Emoticons',
++	'TODAY'						=> 'Hoje',
++
++	// Editor
++	'HTML_TITLE' 		=> 'Html:',
++	'INSERT_HTML' 		=> 'Inserir Código HTML',
++
++	// Login Block
++	'HIDE_ME_NOW'			=> 'Hide me in this session',
++	'MY_BOOKMARKS'			=> 'Favoritos',
++	'MY_SUBSCRIBED'			=> 'Subscrições',
++	'REMEMBER_ME'			=> 'Lembrar-me',
++
++	// Link Us Block
++	'LINK_US_TXT'			=> 'Please feel free to link to <strong>%s</strong>. Use the following HTML:',
++
++	// Stats Block and whos_online block
++	'GUEST_VISITS_TOTAL'		=> '%d Visitantes',
++	'GUEST_VISIT_TOTAL'			=> '%d Visitante',
++	'HIDDEN_VISITS_TOTAL'		=> '%d ocultos, ',
++	'HIDDEN_VISIT_TOTAL'		=> '%d oculto, ',
++	'LASTVISIT_VISITS_TOTAL'	=> 'In total there were <strong>%d</strong> users online in the last 24 hours :: ',
++	'LASTVISIT_VISIT_TOTAL'		=> 'In total there is <strong>%d</strong> user online in the last 24 hours  :: ',
++	'REG_VISITS_TOTAL'			=> '%d Registados, ',
++	'REG_VISIT_TOTAL'			=> '%d Registado, ',
++
++	'ST_ACTIVE_POSTERS'			=> 'Active posters',
++	'ST_ANNS'					=> 'Announcements',
++	'ST_ATTACHMENTS'			=> 'Anexos',
++	'ST_BOARD_STARTDATE'		=> 'Start date',
++	'ST_NEW'					=> 'Novo',
++	'ST_NEWEST_USER'			=> 'Último membro',
++	'ST_POSTS'					=> 'Mensagens',
++	'ST_POSTS_PER_DAY'			=> 'Mensagens por dia',
++	'ST_POSTS_PER_TOPIC'		=> 'Mensagens por tópico',
++	'ST_POSTS_PER_USER'			=> 'Mensagens por utilizador',
++	'ST_STICKYS'				=> 'Importantes',
++	'ST_TOP'					=> 'Total',
++	'ST_TOPICS'					=> 'Tópicos',
++	'ST_TOPICS_PER_DAY'			=> 'Tópicos por dia',
++	'ST_TOPICS_PER_USER'		=> 'Tópicos por utilizador',
++	'ST_TOTAL_USERS'			=> 'Total utilizadores',
++	'ST_USERS_PER_DAY'			=> 'Utilizadores por dia',
++	'ST_VISIT_IP'				=> 'O teu IP',
++
++	'WIO_ONLINE'			=> 'Utilizadores online',
++	'WIO_LASTDAY'			=> 'Utilizadores hoje',
++	'WIO_TOTAL'				=> 'Total',
++	'WIO_REGISTERED'		=> 'Registados',
++	'WIO_HIDDEN'			=> 'Ocultos',
++	'WIO_GUEST'				=> 'Visitantes',
++
++	// polls
++	'NO_POLL'			=> 'Votação indisponível',
++
++	// attachments_block
++	'ATTACH_DATE'			=> 'Publicado',
++	'ATTACH_SIZE'			=> 'Tamanho',
++	'ATTACH_DOWNLOAD'		=> 'Transferido',
++	'ATTACH_VIEW'			=> 'Visto',
++
++	'ATTACH_COUNT'				=> array(
++		0	=> 'Nunca',
++		1	=> '%d vez',
++		2	=> '%d vezes',
++	),
++
++	'VIEW_TOPIC'				=> 'Ver Tópico',
++	'DOWNLOAD'					=> 'Download',
++	'NO_ATTACHMENTS'			=> 'Sem anexos disponíveis',
++
++	// language_select_block
++	'LANGUAGE_CHANGE'		=> 'Alterar idioma',
++	'LANGUAGE_DEFAULT'		=> 'Idioma Original',
++	'LANGUAGE_SET_MINE'		=> 'Gravar como meu idioma',
++	'LANGUAGE_SELECT'		=> 'Selecionar Idioma',
++
++	// news_block
++	'POSTED_BY'			=> 'Criado por',
++	'LAST_REPLIED_BY'	=> 'Última resposta por',
++	'COMMENTS_PORTAL'	=> 'Comentários',
++	'POLL'				=> 'Votação',
++	'TOPIC_VIEWS'		=> 'Visto',
++	'NO_NEWS'			=> 'Sem notícias disponíveis',
++	'VIEW_COMMENTS'		=> 'Ver comentários',
++
++	// recent_topics_block
++	'BLG_RECENT_ACTIVITY'	=> 'Actividade Recente',
++	'BLG_RECENT_ANN'		=> 'Anúncios Recentes',
++	'BLG_RECENT_TOPICS'		=> 'Tópicos Recentes',
++
++	// paypal_block
++	'AMOUNT_MSG'		=> 'Amount to donate',
++	'CLICK_MSG'			=> 'Proceed to donation',
++	'CODE_MSG'			=> 'Currency',
++	
++	'currencies'	=> array(
++		'AUD'	=> 'Aussie',
++		'CAD' 	=> 'Canadian Dollar',
++		'CZK' 	=> 'Czech Koruna',
++		'DKK' 	=> 'Danish Kroner',
++		'HKD' 	=> 'Hong Kong Dollar',
++		'HUF' 	=> 'Hungarian Forint',
++		'NZD' 	=> 'New Zealand Dollar',
++		'NOK' 	=> 'Norwegian Kroner',
++		'PLN' 	=> 'Polish Zlotych',
++		'GBP' 	=> 'British Pounds',
++		'SGD' 	=> 'Singapore Dollar',
++		'SEK' 	=> 'Swedish Kronor',
++		'CHF' 	=> 'Swiss Francs',
++		'JPY' 	=> 'Japanese Yen',
++		'USD' 	=> 'Dollar',
++		'EUR' 	=> 'Euro',
++		'AUD' 	=> 'Mexican Peso',
++		'ILS' 	=> 'New Israeli Shekels'
++	),
++
++	// most_poster_block
++	'MEMBER_POSTS'		=> '%d (%.2f/dia)',
++	'USER'				=> 'Utilizador',
++	'NO_MOST_POSTER'	=> 'Sem utilizadores para exibir',
++
++	// contact block
++	'EMAIL_EMPTY'		=> 'You must set an email.',
++	'EMAIL_INVALID'		=> 'The entered email is invalid.',
++
++	// counter block
++	'COUNTER_LOCAL'		=> 'Visits to this page',
++	'COUNTER_TOTAL' 	=> 'Total visits',
++	'COUNTER_STARTDATE' => 'Counting from:<br />%s',
++	'HITS_PER_DAY'		=> 'Visits per day',
++	'HITS_PER_HOUR'		=> 'Visits per hour',
++	'HITS_PER_MONTH'	=> 'Visits per month',
++	'HITS_PER_USER'		=> 'Visits per user',
++	'HITS_PER_WEEK'		=> 'Visits per week',
++	'HITS_PER_YEAR'		=> 'Visits per year',
++
++	// style_select_block
++	'STYLE_CHANGE'		=> 'Change Style',
++	'STYLE_DEFAULT'		=> 'Original style',
++	'STYLE_SET_MINE'	=> 'Set as my style',
++	'STYLE_SELECT'		=> 'Select style',
++
++	// latest_bots_block
++	'NO_BOTS'			=> 'Nenhum bot visitou o fórum',
++
++	// latest_unread_block
++	'NO_UNREAD'			=> 'Sem tópicos',
++
++	// ranks_block
++	'MIN_POSTS'			=> 'Minimum Posts',
++	'SPECIAL_RANK'		=> 'Special Rank',
++
++	// online_friends_block
++	'FRIENDS_ONLINE'		=> 'Online friends',
++	'FRIENDS_OFFLINE'		=> 'Offline friends',
++	'NO_FRIENDS_ONLINE'		=> 'No friends online',
++	'NO_FRIENDS_OFFLINE'	=> 'No friends offline',
++	'NO_FRIENDS'			=> 'No friends found',
++
++	// age_ranges_block
++	'RANGE'				=> 'Rank',
++	'RANGE_USERS'		=> 'Utilizadores (%)',
++	'AGE_COUNTS'		=> 'Utilizadores contados',
++	'AGE_AV'			=> 'Idade média',
++	'AGE_AV_COUNT'		=> '%.2f anos',
++
++	// search_block
++	'SH_ENGINE'			=> 'Search Engines',
++
++	// announcements_block
++	'NO_ANNOUNCEMENTS'	=> 'Sem Anúncios',
++
++	//birthday_block
++	'TODAY_BIRTHDAYS'		=> 'Today Birthdays',
++	'TOMORROW_BIRTHDAYS'	=> 'Tomorrow Birthdays',
++	'BIRTHDAYS_FOR'			=> 'Birthdays for %1$s of %2$s',
++
++	// calendar
++	'ADD_EVENT'				=> 'Adicionar evento',
++	'DELETE_EVENT'			=> 'Remover Evento',
++	'EDIT_EVENT'			=> 'Editar Evento',
++	'EVENTS'				=> 'Eventos',
++
++	'EMPTY_EVENT_TITLE'	=> 'Tem de colocar um título para o evento.',
++	'EVENT_ADDED'		=> 'Evento adicionado com sucesso',
++	'EVENT_COLOR'		=> 'Cor',
++	'EVENT_EDITED'		=> 'Evento editado com sucesso',
++	'EVENT_GROUPS'		=> 'Grupos autorizados',
++	'EVENT_TITLE'		=> 'Título do Evento',
++	'EVENT_TIME'		=> 'Data do Evento',
++	'EVENT_DETAILS'		=> 'Detalhes',
++	'EVENT_REMOVED'		=> 'Evento removido com sucesso',
++	'NO_EVENTS'			=> 'Sem eventos',
++	
++	//player block
++	'MUTE'				=> 'Silenciar',
++	'WIN_CLOSE'			=> 'Fechar janela e regressar ao bloco',
++	'WIN_OPEN'			=> 'Abrir numa nova janela',
++	'WIN_OPEN_EXPLAIN'	=> 'Playing in Window',
++	'WIN_RETURN'		=> 'Forze player in the block',
++	'PLAY'				=> 'Play',
++	'PLAY_MSG'			=> 'Playing',
++	'PLAYER'			=> 'Player',
++	'STOP'				=> 'Parar',
++	'STOP_MSG'			=> 'Parou',
++	'VOLUME'			=> 'Volume',
++	'VOLUME_MSG'		=> 'Volume: %d%',
++	
++	// rss block
++	'NO_RSS'		=> 'Sem Rss/Feed para mostrar.',
++
++	// topic index block
++	'CHAR_ALL'		=> 'Todos',
++	
++	// youtube block
++	'YT_EMPTY'		=> 'Sem vídeos para mostrar',
++	'YT_VIEWS'		=> '%d vistos',
++));
++
++// General messages
++$lang = array_merge($lang, array(
++	'ACTION_ERROR'		=> 'No action taken',
++	'BLOCK_LOAD_ERROR'	=> 'Failed to load block',
++	'FORMAT_INVALID'	=> 'The format is not valid',
++	'EVENT_ERROR'		=> 'The selected event does not exist',
++	'NO_TRACKLIST'		=> 'No avaliable tracklist.',
++	'NO_PAGE'			=> 'This page no exists.',
++	'URL_INVALID'		=> 'The URL is not valid.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/acp.php"
+new file mode 100644
+index 000000000..2006342cf
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/acp.php"
+@@ -0,0 +1,357 @@
++<?php
++/*
++* acp.php [English [En]]
++* @package cBB Blockgets
++* @version v2.0.2 12/01/2021
++*
++* @copyright (c) 2021 CaniDev
++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
++*/
++
++// @ignore
++if(!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++// @acp_blockgets
++$lang = array_merge($lang, array(
++	'BLG_CONFIG_TITLE'				=> 'General configuration',
++	'BLG_CONFIG_EXPLAIN'			=> 'Thank you for choosing cBB Blockgets as a complement for your forum!<br />From here you can set the main settings of the extension.<br />Lateral links allow you to access all the options to set comfortably the mod.',
++	'BLG_IMAGES_TITLE'				=> 'Available images',
++	'BLG_OPTIONAL_TITLE'			=> 'Additional configuration',
++	'BLG_OPTIONAL_EXPLAIN'			=> 'From here you can set additional settings for the site.',
++	
++	'BLG_ADMIN_BAR'					=> 'Show quick access bar',
++	'BLG_ADMIN_BAR_EXPLAIN'			=> 'If enabled, a bar will be displayed at the top of the forum that will allow you to quickly access the options of the page where you are.',
++	'BLG_BLOCK_AUTOFIT'				=> 'AutoFit blocks',
++	'BLG_BLOCK_AUTOFIT_EXPLAIN'		=> 'If enabled, the content and disposition of the blocks will be adjust to the column.',
++	'BLG_COLLAPSE'					=> 'Allow collapse blocks',
++	'BLG_COLLAPSE_EXPLAIN'			=> 'Enable/disable globally the possibility that each user can collapse/expand blocks individually. This option overwrite the individual block\'s configuration.',
++	'BLG_FULL_EDITOR'				=> 'Full editor',
++	'BLG_ON_BOARD'					=> 'Blocks within the forum',
++	'BLG_ON_BOARD_EXPLAIN'			=> 'Sets whether to display the blocks into the forum pages. This option overwrite the invidual page\'s configuration.<br /><br />
++		<em>
++			&nbsp;&nbsp;<strong>Not show:</strong> It does not show blocks on any page.<br />
++			&nbsp;&nbsp;<strong>Individual pages:</strong> It shows the blocks on the pages configured for it.<br />
++			&nbsp;&nbsp;<strong>Equal pages:</strong> The "General Index" blocks are shown on all pages.
++		</em>',
++	'BLG_REDIRECTIONS'				=> 'Redirections',
++	'BLG_REDIRECT_404'				=> 'Page not found',
++	'BLG_REDIRECT_404_EXPLAIN'		=> 'Sets the page to which the user will be taken when trying to access a location that does not exist.<br />
++		<em>Replace the message No route found for "GET" of phpBB.</em>',
++	'BLG_REDIRECT_LOGIN'			=> 'Login',
++	'BLG_REDIRECT_LOGIN_EXPLAIN'	=> 'Sets the page to which the user will be taken after login to the forum.',
++	'BLG_REDIRECT_LOGOUT'			=> 'Logout',
++	'BLG_REDIRECT_LOGOUT_EXPLAIN'	=> 'Sets the page to which the user will be taken when disconnecting.',
++
++	'DEFAULT'					=> 'By default',
++	'LINKS'						=> 'Links',
++	'OPEN_GALLERY'				=> 'Open gallery',
++	'SAVE_AND_ADD'				=> 'Save and add more',
++	'TYPE_DOMAIN_HOME'			=> 'Domain\'s main page',
++	'TYPE_FORUM_HOME'			=> 'Forum\'s main page',
++	'TYPE_FORUM_SECONDARY'		=> 'Forum\'s secondary page',
++
++	'BOARD_BLOCK_INDIVIDUAL'	=> 'Individual pages',
++	'BOARD_BLOCK_NONE'			=> 'Not show',
++	'BOARD_BLOCK_SAME'			=> 'Equal pages',
++
++	'AVATAR_RESIZE_WIDTH'			=> 'Size of avatars',
++	'AVATAR_RESIZE_WIDTH_EXPLAIN'	=> 'Maximum size allowed (in pixels) for avatars.<br />
++		<em>Set 0 to disable avatar resizing</em>.',
++	'CALENDAR'						=> 'Calendar',
++	'CALENDAR_ENABLED'				=> 'Calendar enabled',
++	'CALENDAR_ENABLED_EXPLAIN'		=> 'Defines whether the calendar will be available in both the<em>/calendar path</em> and blocks.',
++	'CALENDAR_BIRTHDAYS'			=> 'Show Birthdays',
++	'CALENDAR_BIRTHDAYS_EXPLAIN'	=> 'If enabled, user\'s birthdays will be marked and displayed on the calendar, as if they were events.',
++	'CALENDAR_LINK'					=> 'Link',
++	'CALENDAR_LINK_EXPLAIN'			=> 'Define in which part of the forum a link to the calendar will appear.',
++	'CALENDAR_FIRST_DAY'			=> 'First day of the week',
++	'CALENDAR_FIRST_DAY_EXPLAIN'	=> 'Define the first day of the week on the calendar.',
++	'COUNTER'						=> 'Hit Counter',
++	'COUNTER_RESET'					=> 'Reset hit counter',
++	'COUNTER_RESET_EXPLAIN'			=> 'Sets the visits to 0 and the counter start to the current date.',
++	'HOME_TYPE_DISPLAY'				=> 'Behavior of the home page',
++	'HOME_TYPE_DISPLAY_EXPLAIN'		=> 'Sets how the home page will work, if it is enabled.',
++	'IMAGE_RESIZE'					=> 'Resize images',
++	'IMAGE_RESIZE_POST'				=> 'Resize images in posts',
++	'IMAGE_RESIZE_POST_EXPLAIN'		=> 'Enable/Disable the resize in the images inside the forum posts.',
++	'IMAGE_RESIZE_WIDTH'			=> 'Images max size',
++	'IMAGE_RESIZE_WIDTH_EXPLAIN'	=> 'Maximum size (in pixels) for images. The default is 450.<br />
++		<em>Set 0 to disable image resizing</em>.',
++
++	'INDEX_FILE_ERROR'				=> 'Failed to complete setup',
++));
++
++// @acp_blockgets_lists
++$lang = array_merge($lang, array(
++	'ADD_ITEM'				=> 'Add item',
++	'CAT'					=> 'Category',
++
++	'LINK'						=> 'Link',
++	'LINK_DESCRIPTION'			=> 'Description',
++	'LINK_DESCRIPTION_EXPLAIN'	=> 'This text will be show in some blocks as aditional link information.',
++	'LINK_GROUP'				=> 'Groups',
++	'LINK_GROUP_EXPLAIN'		=> 'Select groups of users that can see this link in the menu.<br />You can select multiple groups using the <em>Ctrl</em> key on your keyboard.',
++	'LINK_IMG'					=> 'Image',
++	'LINK_TITLE'				=> 'Link title',
++	'LINK_TITLE_EXPLAIN'		=> 'Title that identifies the link. Limit 100 characters.',
++	'LINK_TYPE'					=> 'Link type',
++	'LINK_URL'					=> 'Link URL',
++	'LINK_URL_EXPLAIN'			=> 'The direction that opens when you click on the link. Limit 255 characters.',
++	'LINK_WINDOW'				=> 'Open in New Window',
++));
++
++// @acp_blockgets_pages
++$lang = array_merge($lang, array(
++	'ADD_BLOCK'					=> 'Add block',
++	'ADD_BLOCK_TIP'				=> 'Drag a block to the position you want to add it.',
++	'ADD_BLOCK_TITLE'			=> 'Add block :: %1$s',
++	'ADD_BLOCK_TITLE_EXPLAIN'	=> 'From here you can add a new block to your forum and set its configuration. You can also set additional settings, if the block you need.',
++	'ADD_GROUP'					=> 'Add group',
++	'ADD_GROUP_EXPLAIN'			=> 'Drag this button to the desired position to add a group',
++	'ADVANCED_OPTIONS'			=> 'Advanced options',
++
++	'BLOCK_SETTINGS'			=> 'General options for the block',
++	'BLOCK_SPACE'				=> 'Space between blocks',
++	'BLOCK_SPACE_EXPLAIN'		=> 'Value in pixels or percentage. The minimun value is 1.',
++	'BOTTOM_COLUMN'				=> 'Bottom column',
++	'CENTER_COLUMN'				=> 'Center column',
++	'CHG_GROUPS_BLOCK'			=> 'Change permissions',
++	'CHG_GROUP_EXPLAIN'			=> 'Choose groups who can see the selected blocks',
++	'COLUMN_SETTINGS'			=> 'Options for the columns',
++	'COPY_BLOCK'				=> 'Copy to other page',
++	'DELETE_BLOCK_CONFIRM'		=> 'Are you sure you want to delete the selected blocks?',
++	'DISABLE_BLOCK'				=> 'Disable',
++	'EDIT_BLOCK_TITLE'			=> 'Edit block :: %1$s',
++	'EDIT_BLOCK_TITLE_EXPLAIN'	=> 'Here you can edit the configuration of the block, as well as additional settings, if the block you need.',
++	'ENABLE_BLOCK'				=> 'Enable',
++	'EXT_ROUTES'				=> 'Extension\'s routes',
++	'FILTER_TYPE_GET'			=> 'Url (GET)',
++	'FILTER_TYPE_POST'			=> 'Form (POST)',
++	'FORUM_FILES'				=> 'Forum files',
++	'LEFT_COLUMN'				=> 'Left column',
++	'LEFT_COLUMN_EXPLAIN'		=> 'Width of the left column in pixels or percentage.<br />Set 0 to disable the column.',
++	'LINK_BOTTOM'				=> 'Bottom',
++	'LINK_QUICK'				=> 'Quick links',
++	'LINK_NONE'					=> 'No link',
++	'LINK_TOP'					=> 'Top',
++	'MANAGE_PAGE'				=> 'Manage page',
++	'MOVE_BLOCK'				=> 'Move to other page',
++	'NO_PAGES_CREATED'			=> 'No pages created.',
++	'NO_PAGE_FILTERS'			=> 'No filters',
++	
++	'PAGE'						=> 'Page',
++	'PAGE_ADD'					=> 'New page',
++	'PAGE_ALIAS'				=> 'Page alias',
++	'PAGE_ALIAS_EXPLAIN'		=> 'You can set an alias (letters, numbers and dashes) to create a separate page.<br />If you leave this field blank, it will create a separate page and will be used the ID as alias.',
++	'PAGE_ALIAS_ERROR'			=> 'The value inserted in "Alias page" field contains illegal characters or an invalid path.',
++	'PAGE_BACKGROUND'			=> 'Page background',
++	'PAGE_BACKGROUND_EXPLAIN'	=> 'You can set a color (ex. white, #FFFFFF) or an image (ex. http://mydomain.com/image.jpg). Leave this field blank to use the default background.',
++	'PAGE_CUSTOM'				=> 'Custom Pages',
++	'PAGE_CUSTOM_EXPLAIN'		=> 'These are pages created by you or another administrator of this site. You can add, edit and manage as many pages as you wish.',
++	'PAGE_CUSTOM_ONE'			=> 'Custom Page',
++	'PAGE_DESCRIPTION'			=> 'SEO Description',
++	'PAGE_DESCRIPTION_EXPLAIN'	=> 'Defines a description visible to search engines.<br /><em>Google, bing, etc...</em>',
++	'PAGE_ENABLED'				=> 'Page enabled',
++	'PAGE_ENABLED_EXPLAIN'		=> 'Enable or disable the page functions completely. This option overrides all others.',
++	'PAGE_FILTERS'				=> 'Filters',
++	'PAGE_FILTERS_EXPLAIN'		=> 'Define the required parameters (GET and POST) for the page is loaded.<br />Check <strong>Online Documentation</strong> for more information on how to set these filters.',
++	'PAGE_FILTER_PARAM'			=> 'Parameters',
++	'PAGE_FILTER_PARAM_EXPLAIN'	=> 'You can set as many as you want separated by ","<br />Ex: mode=mymode,style=1',
++	'PAGE_FILTER_TYPE'			=> 'Type',
++	'PAGE_FILTER_TYPE_EXPLAIN'	=> 'Select the type of location parameters.',
++	'PAGE_FORUM'				=> 'Pages inside the forum',
++	'PAGE_FORUM_EXPLAIN'		=> 'These are pages belonging to the forum to which you can add blocks. You can manage and edit their main parameters as in customized pages.',
++	'PAGE_GROUP'				=> 'Groups',
++	'PAGE_GROUP_EXPLAIN'		=> 'Choose groups who can see the blocks of this page.<br />You can select multiple groups using <em>Ctrl key</em> on your keyboard.',
++	'PAGE_HOME'					=> 'Home page',
++	'PAGE_HOME_EXPLAIN'			=> 'This is a page designed to be used as a site\'s home page as a "Portal".',
++	'PAGE_LINK'					=> 'Link',
++	'PAGE_LINK_ICON'			=> 'Link icon',
++	'PAGE_LINK_ICON_EXPLAIN'	=> 'Define the icon that will have the link to this page.',
++	'PAGE_LINK_POSITION'		=> 'Link position',
++	'PAGE_LINK_POSITION_EXPLAIN'	=> 'Define in which part of the forum a link to this page will appear.',
++	'PAGE_LOGO'					=> 'Logo',
++	'PAGE_LOGO_EXPLAIN'			=> 'Sets the url of the image to be used as logo.<br />Leave blank to use the default logo.',
++	'PAGE_STYLE'				=> 'Style',
++	'PAGE_STYLE_EXPLAIN'		=> 'Defines the style to be used on the page.<br /><em>This option will not be applied to the original pages of the forum.</em>',
++	'PAGE_STYLESHEET'			=> 'Custom theme',
++	'PAGE_STYLESHEET_EXPLAIN'	=> 'You can set the path to one or more files *.css (one per line) or directly set the variables of the theme that will be used.',
++	'PAGE_THEME'				=> 'Theme',
++	'PAGE_THEME_BACKGROUND'		=> 'Set background',
++	'PAGE_THEME_DEFAULT'		=> 'Use default configuration',
++	'PAGE_THEME_STYLE'			=> 'Set style',
++	'PAGE_THEME_STYLESHEET'		=> 'Use custom theme',
++	'PAGE_TITLE'				=> 'Page title',
++	'PAGE_TITLE_EXPLAIN'		=> 'Title will be displayed in the browser.',
++	'PAGE_URL'					=> 'Page url',
++	
++	'PAGES_ADD_TITLE'				=> 'Add new page',
++	'PAGES_ADD_TITLE_EXPLAIN'		=> 'From here you can add a new page and define custom configuration and appearance.',
++	'PAGES_BLOCKS_TITLE'			=> 'Manage blocks :: %s',
++	'PAGES_BLOCKS_TITLE_EXPLAIN'	=> 'From here you can create/edit/delete blocks to be shown on this page.<br />
++		The blocks can be divided into five columns (left, center, right, top and bottom). Drag the blocks to change their position.<br />
++		You can also add <strong>groups</strong> that will allow you to place blocks in up to 3 columns independently.',
++	'PAGES_EDIT_TITLE'				=> 'Edit page :: %s',
++	'PAGES_EDIT_TITLE_EXPLAIN'		=> 'From here you can edit the main configuration and look for the page.',
++	'PAGES_SELECT_TITLE_EXPLAIN'	=> 'Select the page to manage.',
++	'PAGES_TITLE'					=> 'Manage pages',
++	'PAGES_TITLE_EXPLAIN'			=> 'From here you can create/edit/delete additional pages for your forum. You can also edit the configuration and blocks on predefined pages.',
++	
++	'RIGHT_COLUMN'				=> 'Right column',
++	'RIGHT_COLUMN_EXPLAIN'		=> 'Width of the right column in pixels or percentage.<br />Set 0 to disable the column.',
++	'SHOW_FOOTER'				=> 'Show footer',
++	'SHOW_FOOTER_EXPLAIN'		=> 'This option lets you decide whether to display the forum footer on this page.',
++	'SHOW_HEADER'				=> 'Show header',
++	'SHOW_HEADER_EXPLAIN'		=> 'This option lets you decide whether to display the forum header on this page.',
++	'STYLE_DEFAULT'				=> 'Default style',
++	'STYLE_ALTERNATIVE'			=> 'Alternate style',
++	'STYLE_CONTENT_FULL'		=> 'Only content (with title)',
++	'STYLE_CONTENT_SIMPLE'		=> 'Only content (without title)',
++	'SUBMIT_CHANGES'			=> 'Apply changes',
++	'TARGET_PAGE_EXPLAIN'		=> 'Select the target page for the selected blocks.<br /><em>The blocks will be placed in it respective column</em>',
++	'TOP_COLUMN'				=> 'Top column',
++));
++
++// @general messages
++$lang = array_merge($lang, array(
++	'BLOCK_ADDED'					=> 'Block added successfully',
++	'BLOCK_COPIED'					=> 'Block(s) copied successfully',
++	'BLOCK_NEED_REQUIREMENTS'		=> 'The selected block will need some minimum requirements to be used.<br />See the documentation for more information.',
++	'BLOCK_MOVED'					=> 'Block(s) moved successfully',
++	'BLOCK_NOT_ADDED'				=> 'Error adding the block',
++	'BLOCK_NOT_EXISTS'				=> 'The selected block does not exist',
++	'BLOCK_NOT_UPDATED'				=> 'Error updating the block',
++	'BLOCK_POSITION_UPDATED'		=> 'Blocks position updated successfully',
++	'BLOCK_POSITION_NOT_UPDATED'	=> 'Error updating blocks position',
++	'BLOCK_REMOVED'					=> 'Block(s) removed successfully',
++	'BLOCK_UPDATED'					=> 'Block updated successfully',
++	'GROUPS_CHANGED'				=> 'Groups updated successfully',
++
++	'ITEM_REMOVED'				=> 'Element removed successfully',
++	'ITEM_UPDATED'				=> 'Element updated successfully',
++	'ITEM_ADDED'				=> 'Element added successfully',
++	'ITEM_NOT_ADDED'			=> 'Error adding the element',
++	'ITEM_NOT_UPDATED'			=> 'Error updating the element',
++
++	'PAGE_ADDED'				=> 'Page added successfully',
++
++	'PAGE_REMOVED'		=> array(
++		1	=> 'The page has been successfully removed',
++		2	=> '%d pages deleted successfully',
++	),
++
++	'PAGE_UPDATED'				=> 'Page configuration updated successfully',
++	'BLG_CONFIG_UPDATED'		=> 'Configuration updated successfully',
++
++	'CONFIRM_PAGE_DELETE'		=> 'Are you sure you wish to delete this page and all blocks in this?',
++));
++
++/**
++* Blocks names and explains from block_alias
++*/
++$lang = array_merge($lang, array(
++	'blocks'	=> array(
++		'announcements_title'		=> 'Announcements',
++		'announcements_explain'		=> 'Displays a set number of posts (announcements) of established forums.',
++		'attachments_title'			=> 'Attachments',
++		'attachments_explain'		=> 'Displays information and links to the specified attachments.',
++		'banners_title'				=> 'Banners',
++		'banners_explain'			=> 'Displays the specified list of banners. It\'s displayed in a fixed or scrolling form.',
++		'birthdays_title'			=> 'Birthdays',
++		'birthdays_explain'			=> 'Displays the list of birthdays for today and the next few days (optional).',
++		'empty_title'				=> 'Custom',
++		'empty_explain'				=> 'Totally blank block which can also include any text HTML, CSS, JavaScript, etc...',
++		'calendar_title'			=> 'Calendar',
++		'calendar_explain'			=> 'Calendar in which you can add custom events and show birthdays.',
++		'clock_title'				=> 'Clock',
++		'clock_explain'				=> 'Displays a clock in flash format (you can choose several models and add your own clock).',
++		'cloud_tag_title'			=> 'CloudTag',
++		'cloud_tag_explain'			=> 'Sample labels in a balloon in flash format. You can display the latest searched words or the users with more messages.',
++		'contact_title'				=> 'Contact',
++		'contact_explain'			=> 'Displays a standard contact form.',
++		'countdown_title'			=> 'CountDown',
++		'countdown_explain'			=> 'Show a countdown to the indicated date.',	
++		'counter_title'				=> 'Hit counter',
++		'counter_explain'			=> 'Displays a hit counter with statistics of visits, visits per day, visits per hour, weekly visits, visits per month and visits per year.',
++		'dockmenu_title'			=> 'Dock menu',
++		'dockmenu_explain'			=> 'Displays a menu with Mac Dock style with elements of the specified list.',
++		'forums_title'				=> 'Forums',
++		'forums_explain'			=> 'List with full or custom forums.',
++		'frame_title'				=> 'Frame',
++		'frame_explain'				=> 'Display a Web page, a PDF file, a Flash file or a text file within the block.', 
++		'gallery_title'				=> 'Photo gallery',
++		'gallery_explain'			=> 'Photo Gallery customizable with forum images (attachments) or external images. The images move and link the fate of each.',
++		'google_translate_title'	=> 'Google translator',
++		'google_translate_explain'	=> 'Block that allows you to translate the page on which it is installed, opening a new window and translating it through Google technology.',
++		'language_select_title'		=> 'Language select',
++		'language_select_explain'	=> 'It allows the user to view the forum with any language that is installed in the forum and set it as their default language.',
++		'latest_bots_title'			=> 'Bot\'s visits',
++		'latest_bots_explain'		=> 'Simple list of last bots who entered the forum and the date of their last visit.',
++		'latest_members_title'		=> 'Newest members',
++		'latest_members_explain'	=> 'List of latest sers registered on the forum and the date they were registered.',
++		'leaders_title'				=> 'Leaders',
++		'leaders_explain'			=> 'Displays a list of groups (customizable) with forum leaders.',
++		'link_us_title'				=> 'Link Us',
++		'link_us_explain'			=> 'Block that displays a user-selectable link to the page on which it is installed. You can set a mini banner attached to the link.',
++		'login_title'				=> 'Login',
++		'login_explain'				=> 'Allows a user to login directly from the block. Once identified, shows the user\'s primary information and links.',
++		'map_title'					=> 'Map',
++		'map_explain'				=> 'Displays a map that may contain marks with different locations.',
++		'menu_title'				=> 'Menu',
++		'menu_explain'				=> 'Menu in tree format that displays items from the selected list.',
++		'most_poster_title'			=> 'Most Posters',
++		'most_poster_explain'		=> 'Displays a dropdown with users who have posted more messages in the forum, and most relevant information.',
++		'news_title'				=> 'News',
++		'news_explain'				=> 'Dropdown menu showing the last posts of the specified forums as a news.',
++		'online_friends_title'		=> 'Friends online',
++		'online_friends_explain'	=> 'Simple list of friends and foes of the user, that are connected to the forum.',
++		'paypal_title'				=> 'Donations',
++		'paypal_explain'			=> 'Allows users to donate money through paypal.',
++		'player_title'				=> 'Music Player',
++		'player_explain'			=> 'Player to play songs in MP3 or WAV format. Allow to create a list of songs or use M3U, ASX or PLS playlists.',
++		'poll_title'				=> 'Poll',
++		'poll_explain'				=> 'Displays a single poll specified in its configuration.',
++		'poll_random_title'			=> 'Poll (random)',
++		'poll_random_explain'		=> 'Displays a selected number of polls that selected in random order, within the specified forum.',
++		'post_view_title'			=> 'Forum post',
++		'post_view_explain'			=> 'Displays the contents of a message. You can display the last message of a forum, the first or last post of a topic or a custom post.',
++		'quote_of_day_title'		=> 'Quote of day',
++		'quote_of_day_explain'		=> 'Shows a "quote" or phrase of the day or a different tip in each visit to the page.',
++		'random_member_title'		=> 'Random Member',
++		'random_member_explain'		=> 'Displays basic information and avatar of a random user.',
++		'ranks_title'				=> 'Ranks',
++		'ranks_explain'				=> 'Shows a list with the forum ranks.',
++		'recent_topics_title'		=> 'Recent Topics',
++		'recent_topics_explain'		=> 'Recent topics of the forum. Allow to select the forums from which to read the topics.',
++		'rss_title'					=> 'RSS Reader',
++		'rss_explain'				=> 'Show the latest articles from the specified RSS archives(feeds). Items will be displayed in scroll mode or accordion.', 
++		'share_title'				=> 'Share',
++		'share_explain'				=> 'Shows the buttons of most popular social networks in the desired format.',
++		'search_title'				=> 'Search',
++		'search_explain'			=> 'Allows users to do quickly searchs on the forum or in a search engine.',
++		'scroll_message_title'		=> 'Marquee',
++		'scroll_message_explain'	=> 'Text message that is rotating in the block. Allows use BBCode and HTML in the text.',
++		'stats_title'				=> 'Statistics',
++		'stats_explain'				=> 'Gets the most relevant information on the forum. This block shows the number of new messages and topics, the total number of posts and topics, message statistics and topics written per day, total number of attachments and the number of users that remaining active (posting messages).',
++		'style_select_title'		=> 'Style select',
++		'style_select_explain'		=> 'Allows the user to view the forum with any style that is installed on the forum and set it as their default style.',
++		'top_topics_title'			=> 'Top topics',
++		'top_topics_explain'		=> 'List of custom topics that can display the latest topics unread, the most active topics or the most viewed topics.',
++		'topic_index_title'			=> 'Topic Index',
++		'topic_index_explain'		=> 'Displays an orderly list with the topics of selected forums. The list can be order by topic title, topic date or topic last post date.',
++		'welcome_title'				=> 'Welcome',
++		'welcome_explain'			=> 'This block enables a different welcome message for guests and registered users. The block will decide which message display.',
++		'whos_online_title'			=> 'Who\'s online',
++		'whos_online_explain'		=> 'Displays the list of connected users (as is shown by default in the Index of the forum) and users who logged in last 24 hours.',
++		'youtube_title'				=> 'YouTube',
++		'youtube_explain'			=> 'Show videos or channels from youtube.',
++	)
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/acp_blocks.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/acp_blocks.php"
+new file mode 100644
+index 000000000..1a22369dd
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/acp_blocks.php"
+@@ -0,0 +1,478 @@
++<?php
++/*
++* acp_blocks.php [English [En]]
++*
++* @package cBB Blockgets
++* @version v2.0.2 12/01/2021
++*
++* @copyright (c) 2021 CaniDev
++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
++*/
++
++// @ignore
++if(!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if(empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++/**
++ * @acp_blockgets_pages
++*/
++$lang = array_merge($lang, array(
++	// Blocks global config
++	'BLOCK_COLLAPSE'			=> 'Allow collapse the block',
++	'BLOCK_COLLAPSE_EXPLAIN'	=> 'Enable or disable the ability for each user to collapse/expand this block and defines its initial state.',
++	'BLOCK_ENABLED'				=> 'Block enabled',
++	'BLOCK_ENABLED_EXPLAIN'		=> 'Defines whether this block display in the forum.',
++ 	'BLOCK_CURRENT_ICON'			=> 'Block icon',
++	'BLOCK_CURRENT_ICON_EXPLAIN'	=> 'Current icon set to the block.',
++	'BLOCK_GROUP'				=> 'Groups',
++	'BLOCK_GROUP_EXPLAIN'		=> 'Choose groups who may see this block in the forum.<br />You can select multiple groups using the <em>Ctrl</em> key on your keyboard.',
++	'BLOCK_NO_CONFIG'			=> 'This block does not require additional configuration',
++	'BLOCK_STYLE'				=> 'Look of the block',
++	'BLOCK_STYLE_EXPLAIN'		=> 'With this option you can choose the look of each block individually. Note that the way it is displayed depends on the style installed on the forum and its compatibility with the extension.',
++	'BLOCK_TITLE'				=> 'Block title',
++	'BLOCK_TITLE_EXPLAIN'		=> 'Unique name for your block.<br />This title will be shown in the block.<br />Limit: 100 characters.',
++
++	// Common tags
++	'ALL_FORUMS'				=> 'All forums',
++	'COLLAPSE_HIDDEN'			=> 'Allow (collapsed by default)',
++	'COLLAPSE_NONE'				=> 'Not Allow',
++	'COLLAPSE_VISIBLE'			=> 'Allow (displayed by default)',
++	'CONFIG'					=> 'Configuration',
++	'DESIGN_FULL'				=> 'Full',
++	'DESIGN_SIMPLE'				=> 'Simple',
++	'FORUMS'					=> 'Forums',
++	'FORUMS_EXPLAIN'			=> 'Forums that contain the topics to show. You can select as many as you like using the <em>Ctrl</em> key on your keyboard.',
++	'IGNORE_AUTH'				=> 'Ignore auth',
++	'IGNORE_AUTH_EXPLAIN'		=> 'If enabled, will be show all the content ignoring if the user have the permissions to view it.',
++	'NO_LISTS'					=> 'No avaliable lists',
++	'SHOW_PAGINATION'			=> 'Show pagination',
++	'SHOW_PAGINATION_EXPLAIN'	=> 'Show the pagination to allow user to view older posts.',
++	'TITLE_LIMIT'				=> 'Title limit',
++	'TITLE_LIMIT_EXPLAIN'		=> 'Maximum number of characters that will be displayed in the topic titles.<br />
++		<em>Set 0 to show the full title.</em>',
++	'TOPIC_DESIGN'				=> 'Block design',
++	'TOPIC_DESIGN_EXPLAIN'		=> 'Determine how the topics will be displayed in the block.<br />
++		<em><strong>Full:</strong> Show all information whenever possible.</em><br />
++		<em><strong>Simple:</strong> Show only basic information.</em>',
++	'TOPIC_PARENT_SHOW'			=> 'Show parent forum',
++	'TOPIC_PARENT_SHOW_EXPLAIN'	=> 'If enabled, a link to the forum for each topic will be displayed.',
++	
++	// age_ranges_block
++	'AGE_START'					=> 'Minimum age',
++	'AGE_END'					=> 'Maximum age',
++	'AGE_INTERVAL'				=> 'Interval',
++	
++	// announcements_block
++	'ANN_MAX_NUMBER'			=> 'Announcements number',
++	'ANN_MAX_NUMBER_EXPLAIN'	=> 'Maximum number of announcements that are displayed within the block.',
++	'ANN_MAX_SIZE'				=> 'Announcement size',
++	'ANN_MAX_SIZE_EXPLAIN'		=> 'Maximum size of characters allowed in announcements. The text is cut off if this value exceeds.',
++	'ANN_SHOW_GLOBALS'			=> 'Show global announcements',
++	'ANN_SHOW_GLOBALS_EXPLAIN'	=> 'If enabled, you also read the items marked as "global", otherwise only read simple announcements.',
++	'ANN_COLLAPSE'				=> 'Collapse announcements',
++	'ANN_COLLAPSE_EXPLAIN'		=> 'If enabled, the block only show one announcement and collapse the rest. Otherwise, the announcements will appear all at once on the block.',
++	
++	// attachments_block
++	'ATTACH_FORUM'				=> 'Forum attachments',
++	'ATTACH_FORUM_EXPLAIN'		=> 'If specified, only display attachments from this forum ignoring the rest.<br />The forum should be directly containing the topic where the attachment, the above categories or forums are ignored here.',
++	'ATTACH_EXTENSION'			=> 'Attachment extensions',
++	'ATTACH_EXTENSION_EXPLAIN'	=> 'If specified, all attachments which do not contain this extensions will be ignored.<br />Split the extensions with ",".<<br />Ex. valid extensions: jpg,png,gif...',
++	'ATTACH_NUM'				=> 'Attachment number',
++	'ATTACH_NUM_EXPLAIN'		=> 'Maximum number of attachments that are displayed simultaneously in the block.',
++	'ATTACH_SPECIFIC'			=> 'Specific attachment',
++	'ATTACH_SPECIFIC_EXPLAIN'	=> 'If specified, only attachment with the specified name will be show in the block. The field must contain the original filename of the attachment, Ex: myfile.jpg<br /><br /><strong>Note:</strong> this field overrides the other fields.',
++
++	// banners_block, banners_multiple_block
++	'BANNERS_TITLE'				=> 'Banner title',
++	'BANNERS_TITLE_EXPLAIN'		=> 'If enabled, the title will be appear below the banners in the block.',
++	'BANNERS_LS_TYPE'			=> 'List type',
++	'BANNERS_LS_TYPE_EXPLAIN'	=> 'Define how to display the banners.<br />Can be set a horizontal, vertical scroll or remain fixed.',
++	'BANNERS_NUMBER'			=> 'Banners to show',
++	'BANNERS_NUMBER_EXPLAIN'	=> 'Maximum number of banners to display on the block.<br />
++		<em>Set 0 to show all the list.</em>',
++	'BANNERS_RANDOM'			=> 'Random order',
++	'BANNERS_RANDOM_EXPLAIN'	=> 'Set if the elements will be show in the list order or in a random order.',
++	'LIST_NO_SCROLL'			=> 'No Scroll',
++	'LIST_SCROLL_H'				=> 'Horizontal scroll',
++	'LIST_SCROLL_V'				=> 'Vertical scroll',
++	'BANNERS_B_HEIGHT'			=> 'Block height',
++	'BANNERS_B_HEIGHT_EXPLAIN'	=> 'Enter the height of the block that will be used to scroll lists.',
++
++	// birthdays_block
++ 	'NEXT_BIRTHDAYS'			=> 'Upcoming Birthdays',
++ 	'NEXT_BIRTHDAYS_EXPLAIN'	=> 'Show birthdays that occur in the coming days.<br />
++ 		<em>Maximum 30 days. Set to 0 to disable it.</em>',
++
++	// calendar_block
++ 	'CALENDAR_BIRTHDAYS'			=> 'Show Birthdays',
++ 	'CALENDAR_BIRTHDAYS_EXPLAIN'	=> 'If enabled, the users birthdays are marked and displayed in the calendar, like events.',
++ 	'CALENDAR_EVENTS'				=> 'Show events',
++ 	'CALENDAR_EVENTS_EXPLAIN'		=> 'If enabled, events are marked and displayed in the calendar.',
++ 	'CALENDAR_MONTHS'				=> 'Months to show',
++ 	'CALENDAR_MONTHS_EXPLAIN'		=> 'Number of months to be displayed simultaneously on the block.',
++
++	// contact block
++	'CONTACT_CHECK_EMAIL'			=> 'Check email',
++	'CONTACT_CHECK_EMAIL_EXPLAIN'	=> 'If enabled, the domain of the user email will be checked and validated.',
++	'CONTACT_EMAIL'					=> 'Target email',
++	'CONTACT_HIDE_FIELDS'			=> 'Hide user data',
++	'CONTACT_HIDE_FIELDS_EXPLAIN'	=> 'If enabled, the "Name" and "Email" fields for the register users will be hidden and the block will be used their profile values.',
++ 
++	// countdown block
++	'COUNTDOWN_COMPLETE_MSG'			=> 'Text upon completion',
++	'COUNTDOWN_COMPLETE_MSG_EXPLAIN'	=> 'Text to be displayed when the counter reaches 0.',
++	'COUNTDOWN_TARGET'					=> 'Deadline',
++	'COUNTDOWN_TARGET_EXPLAIN'			=> 'Set the date and time the counter will reach 0.<br /><br />
++		<em><strong>Valid formats</strong>
++			<br />Year/Month/Day
++			<br />Year/Month/Day Hour:Minute:Second
++		</em>',
++	'COUNTDOWN_RUNNING_MSG'				=> 'Hold text',
++	'COUNTDOWN_RUNNING_MSG_EXPLAIN'		=> 'Text to be displayed while the counter is running.',
++
++	// counter block
++	'COUNTER_LOCAL'				=> 'Local counter',
++	'COUNTER_LOCAL_EXPLAIN'		=> 'If enabled, the counter only show the visits to it\'s page, otherwise, the counter show the total visits to the forum.',
++
++	// empty_block
++	'BLOCK_CONTENT'				=> 'Block content',
++	'BLOCK_CONTENT_EXPLAIN'		=> 'Content to display on the block.<br />Limit: 8000 characters.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
++
++	// clock_block
++	'DISPLAY_CLOCK'				=> 'Clock to show',
++	'DISPLAY_CLOCK_EXPLAIN'		=> 'Clock displayed on the block.',
++	'PREVIEW_CLOCK'				=> 'Preview',
++	'PREVIEW_CLOCK_EXPLAIN'		=> 'Selected clock preview.',
++
++	// cloud_tags_block
++	'CLOUD_ANIMATION'			=> 'Animation enabled',
++	'CLOUD_ANIMATION_EXPLAIN'	=> 'If enabled, the words "tags" appear in an animated cloud tag, otherwise, they appear as fixed words in block.',
++	'CLOUD_MODE'				=> 'Words type',
++	'CLOUD_MODE_EXPLAIN'		=> 'Specifies that words will be shown in block.',
++	'CLOUD_WORDS'				=> 'Words number',
++	'CLOUD_WORDS_EXPLAIN'		=> 'Maximum number of words that appear in the block.',
++	'MODE_SEARCH'				=> 'Last searched words',
++	'MODE_USERS'				=> 'Users with most posts',
++	
++	// forums block
++	'FORUMS_FORUM'		=> 'Forum to show',
++	
++	// frame_block
++	'MIME_HTML'			=> 'Web page',
++	'MIME_PDF'			=> 'PDF file',
++	'MIME_PLAIN'		=> 'Plain Text file',
++
++	'FRAME_HEIGHT'				=> 'Frame height',
++	'FRAME_HEIGHT_EXPLAIN'		=> 'Frame height in pixels. Set to 0 to auto adjust.',
++	'FRAME_MIMETYPE'			=> 'Document type',
++	'FRAME_MIMETYPE_EXPLAIN'	=> 'The document type displayed in the frame.',
++	'FRAME_URL'					=> 'Document URL',
++	'FRAME_URL_EXPLAIN'			=> 'URL of the document or page displayed in the frame.',
++	'FRAME_WIDTH'				=> 'Frame width',
++	'FRAME_WIDTH_EXPLAIN'		=> 'Frame width in pixels. Set to 0 to auto adjust.',
++	
++	// gallery_block
++	'GALLERY_CUSTOM'				=> 'Custom images',
++	'GALLERY_CUSTOM_EXPLAIN'		=> 'Specify the list containing the images to be displayed.',
++	'GALLERY_DIRECTION'				=> 'Scroll direction',
++	'GALLERY_FORUMS'				=> 'Forums',
++	'GALLERY_FORUMS_EXPLAIN'		=> 'Defines the forums to read the attachments.',
++	'GALLERY_FPS'					=> 'Scroll speed',
++	'GALLERY_HEIGHT'				=> 'Gallery height',
++	'GALLERY_MANAGE'				=> 'Manage gallery',
++	'GALLERY_MARGIN'				=> 'Image margin',
++	'GALLERY_MAX_NUMBER'			=> 'Number of images',
++	'GALLERY_MAX_NUMBER_EXPLAIN'	=> 'Maximum attachments that will be read from the forums/topics/posts',
++	'GALLERY_POSTS'					=> 'Posts',
++	'GALLERY_POSTS_EXPLAIN'			=> 'Posts IDs to read the attachments, splitted with commas. (Ex: 1,2,3).',
++	'GALLERY_SOURCE'				=> 'Origin of the images',
++	'GALLERY_SOURCE_EXPLAIN'		=> 'Define what type of images will be loaded from the forums, topics or messages specified.',
++	'GALLERY_TOPICS'				=> 'Topics',
++	'GALLERY_TOPICS_EXPLAIN'		=> 'Topics IDs to read the attachments, splitted with commas. (Ex: 1,2,3).',
++	'GALLERY_ZOOM'					=> 'Zoom',
++	'GALLERY_ZOOM_EXPLAIN'			=> 'Size difference on image\'s mouse over (in pixels)',
++	
++	'GALLERY_SOURCE_ALL'			=> 'All',
++	'GALLERY_SOURCE_ATTACHMENTS'	=> 'Only attachments',
++	'GALLERY_SOURCE_IMAGES'			=> 'Only embedded images',
++	
++	'IMG_TITLE'			=> 'Image title',
++	'IMG_URL'			=> 'Image url',
++	'IMG_URL_EXPLAIN'	=> 'Url of an JPG, GIF or PNG image. Ej:http://mydomain.com/image.jpg',
++	
++	// google_translate_block
++	'GOOGLE_LANGS'		=> 'Languages to show in the block',
++	'GOOGLE_SHOW_NAMES'			=> 'Show names',
++	'GOOGLE_SHOW_NAMES_EXPLAIN'	=> 'If enabled, the language name will be displayed next to its flag.',
++	
++	// latest_bots_block
++	'BOTS_NUMBER'				=> 'Bots to show',
++	'BOTS_NUMBER_EXPLAIN'		=> 'Maximum number of last visit bots that will be shown in the block.',
++
++	// latest_members_block
++	'MEMBERS_NUMBER'			=> 'Users to show',
++	'MEMBERS_NUMBER_EXPLAIN'	=> 'Maximum number of users that will be shown in block.',
++	
++	// leaders_block
++	'LEADERS_ALL_GROUPS'			=> 'Show users in all their groups',
++	'LEADERS_ALL_GROUPS_EXPLAIN'	=> 'If enabled, users will be shown in all groups of which they are members.
++		Otherwise they will only be shown in their default group.',
++	'LEADERS_GROUPS'				=> 'Groups',
++	'LEADERS_GROUPS_EXPLAIN'		=> 'Groups that will be show in the block. If you don\'t select groups, the block will be show the Administrators and Moderators.',
++	'LEADERS_MODE'					=> 'Display mode',
++	'LEADERS_MODE_ACCORDION'		=> 'Accordion',
++	'LEADERS_MODE_SIMPLE'			=> 'Simple List',
++	'LEADERS_ONLY_ONLINE'			=> 'Online users only',
++	'LEADERS_ONLY_ONLINE_EXPLAIN'	=> 'If enabled, only users from selected groups who are logged in will be displayed.',
++
++	// link_us_block
++	'US_BANNER'					=> 'Mini banner link',
++	'US_BANNER_EXPLAIN'			=> 'Mini banner that will be the image that you have to click to access the forum from the link.',
++
++	// Login Block
++ 	'FULL_LOGIN'				=> 'Show Full login',
++ 	'FULL_LOGIN_EXPLAIN'		=> 'Enable/disable the advanced options in the user identification.',
++ 	'SHOW_REGISTER'				=> 'Show register',
++ 	'SHOW_REGISTER_EXPLAIN'		=> 'Display option for the user registration.',
++	
++	// map_block
++	'LATITUDE'					=> 'Latitude',
++	'LONGITUDE'					=> 'Longitude',
++	'LOCATION_ADD'				=> 'Add location',
++	'LOCATION_EDIT'				=> 'Edit location',
++	'LOCATION_IMAGE'			=> 'Image',
++	'LOCATION_IMAGE_EXPLAIN'	=> 'Image that will mark the point on the map.<br /><em>If you do not define any, the default mark will be used</em>.',
++	'LOCATION_INCORRECT'		=> 'he position entered is incorrect.',
++	'LOCATION_POSITION'			=> 'Position',
++	'LOCATION_POSITION_EXPLAIN'	=> 'Defines the latitude and longitude of the location.',
++	'LOCATION_TEXT'				=> 'Content',
++	'LOCATION_TEXT_EXPLAIN'		=> 'Text to be displayed on the map, by clicking on the location icon.<br /><em>BBcode is allowed.</em>',
++	'LOCATION_TITLE'			=> 'Title',
++	'MAP'						=> 'Map',
++	'MAP_CENTER'				=> 'Central point',
++	'MAP_CENTER_EXPLAIN'		=> 'Defines the latitude and longitude of the default center point.',
++	'MAP_LOCATIONS'				=> 'Locations',
++	'MAP_ZOOM'					=> 'Zoom',
++	'MAP_ZOOM_EXPLAIN'			=> 'Set the default zoom.',
++	'SEARCH_ADDRESS'			=> 'Search location',
++	'SELECT_LOCATION'			=> 'Select location',
++
++	// menu_block
++	'DISPLAY_MENU'				=> 'Menu to show',
++	'DISPLAY_MENU_EXPLAIN'		=> 'Menu to be displayed in the block. The menu must be previously created in the correct section to be reflected here.',
++ 	'ICON_WIDTH'				=> 'Icon width',
++ 	'ICON_WIDTH_EXPLAIN'		=> 'The width of the block icons, in pixels.',
++
++	// most_poster_block
++	'POSTER_LIMIT'				=> 'User Limit',
++	'POSTER_LIMIT_EXPLAIN'		=> 'The limit of users that are displayed on the block.',
++ 	'POST_RANGE'				=> 'Message range',
++ 	'POST_RANGE_EXPLAIN'		=> 'Time limit for the message count.',
++ 
++ 	'ALL_POSTS'			=> 'All messages',
++ 	'LAST_DAY'			=> 'Last day',
++ 	'LAST_WEEK'			=> 'Last week',
++ 	'LAST_MONTH'		=> 'Last month',
++ 	'LAST_YEAR'			=> 'Last year',
++
++	// news_block
++	'NEWS_DISPLAY'				=> 'Information to show',
++	'NEWS_DISPLAY_EXPLAIN'		=> '<em><strong>Basic content:</strong>Show title, author and date.<br />
++		<strong>Full content:</strong>Show all news information.</em>',
++	'NEWS_NUMBER'				=> 'News number',
++	'NEWS_NUMBER_EXPLAIN'		=> 'Maximum number of news items displayed in the block.',
++	'NEWS_SIZE'					=> 'News size',
++	'NEWS_SIZE_EXPLAIN'			=> 'Maximum size of characters allowed in the news. The text of the news will be cut if this value exceeds.',
++	'NEWS_ALL'					=> 'Show all topics',
++	'NEWS_ALL_EXPLAIN'			=> 'If enabled, you also read the items marked as "announcement" and "fixed", otherwise, only read the "normal" topics.',
++	'NEWS_COLLAPSE'				=> 'Collapse news',
++	'NEWS_COLLAPSE_EXPLAIN'		=> 'If enabled, the block only show one notice and collapse the rest. Otherwise, the news will appear all at once on the block.',
++	'NEWS_SHOW_FULL'			=> 'Complete content',
++	'NEWS_SHOW_SIMPLE'			=> 'Basic content',
++	
++	// paypal_block
++	'PAYPAL_ACCOUNT'			=> 'Paypal account',
++	'PAYPAL_ACCOUNT_EXPLAIN'	=> 'Enter the e-mail address of your Paypal account ex: xxx@xxx.com',
++	'PAYPAL_ITEM'				=> 'Payment description',
++	'PAYPAL_ITEM_EXPLAIN'		=> 'Enter the name (description) to which payments will be identified through the block.',
++	'PAYPAL_MSG'				=> 'Message',
++	'PAYPAL_MSG_EXPLAIN'		=> 'Customizable message that will appear in the block.<br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
++	'PAYPAL_IMG'				=> 'Button Image',
++ 	'PAYPAL_IMG_EXPLAIN'		=> 'Image to be used for the "donate" button. Leave this field blank to use the default image.', 
++	'PAYPAL_AMOUNTS'			=> 'Amounts',
++	'PAYPAL_AMOUNTS_EXPLAIN'	=> 'Money amount in the select. Split the values with ";" (Ex: 5;10;15).',
++	'PAYPAL_CURRENCIES'			=> 'Currencies',
++	'PAYPAL_CURRENCIES_EXPLAIN'	=> 'Type of currency that will be show in the block. You can select more that one and select the default currency.',
++	
++	//player block
++	'PLAYER_AUTOPLAY'			=> 'Autoplay',
++	'PLAYER_AUTOPLAY_EXPLAIN'	=> 'Defines whether the player will automatically start playing the tracks when the page loads.<br /><br />
++		<em><strong>Note:</strong>Browsers limit this feature so playback will not begin until the user clicks anywhere on the page.</em>',
++	'PLAYER_PLAYLIST'			=> 'Show playlist',
++	'PLAYER_PLAYLIST_EXPLAIN'	=> 'Defines if the playlist is displayed in the player.',
++	'PLAYER_TRACKLIST'			=> 'Tracklist',
++	'PLAYER_TRACKLIST_EXPLAIN'	=> 'The player tracks or songs.',
++
++	'TRACK_TITLE'			=> 'Track title',
++	'TRACK_TITLE_EXPLAIN'	=> 'the name or title displayed in the player.',
++	'TRACK_URL'				=> 'Track URL',
++	'TRACK_URL_EXPLAIN'		=> 'A radio URL (Ex: http://127.0.0.1:8888), a mp3 or wav audio file (Ex: http://myserver.com/audio.mp3) or a valid playlist file (m3u, asx, pls).',
++
++	// poll_block
++	'DISPLAY_POLL'				=> 'Poll to show',
++	'DISPLAY_POLL_EXPLAIN'		=> 'Poll displayed in the block.',
++	'DISPLAY_RESULTS'			=> 'Show results',
++	'NO_POLLS'					=> 'No polls available',
++
++	// poll_random_block
++	'POLL_FORUM'				=> 'Poll forum',
++	'POLL_FORUM_EXPLAIN'		=> 'Forum containing the polls that show on the block.',
++	'POLL_NUM'					=> 'Poll number',
++	'POLL_NUM_EXPLAIN'			=> 'The number of polls that will be displayed at once within the block.',
++	'NO_FORUMS'					=> 'No forums avaliable',
++	
++	// post_view_block
++	'PV_ITEM_URL'			=> 'Referral URL',
++	'PV_ITEM_URL_EXPLAIN'	=> 'Specify here the URL of the forum, topic or message you want to display.<br />
++		<em><strong>Note:</strong> The url of a forum or topic will display it\'s last message.</em>',
++	
++	// quote_of_day_block
++	'QUOTE_AUTHOR'				=> 'Quote author',
++	'QUOTE_TEXT'				=> 'Quote Text',
++	'QUOTES_ALL_DAY'			=> 'Keep all day',
++	'QUOTES_ALL_DAY_EXPLAIN'	=> 'If enabled, you will see the same quote all day. Otherwise, every time the page loads you will see a different quote.',
++	'QUOTES_LIST'				=> 'Quote list',
++	'QUOTES_RAND'				=> 'Random order',
++	'QUOTES_RAND_EXPLAIN'		=> 'Defines if the quotes are displayed in random order or maintaining the order of the list.',
++	'QUOTES_SHOW_AUTHOR'		=> 'Show author',
++	'QUOTES_SHOW_AUTHOR_EXPLAIN'	=> 'Defines whether to display the author of the quote on the block.',
++	
++	// ranks_block
++	'ORPHAN_RANKS'				=> 'Show orphan ranks',
++	'ORPHAN_RANKS_EXPLAIN'		=> 'If enabled, will show the ranges are not assigned to any user.',
++	'ONLY_SPECIAL_RANKS'		=> 'Only special ranks',
++	
++	// recent_topics_block
++	'RECENT_FORUMS'					=> 'Topic forums',
++	'RECENT_FORUMS_EXPLAIN'			=> 'Forums containing items to be displayed. If you do not select any, it will use all the forums. You can select as many as you like using the <em>Ctrl</em> key on your keyboard.',
++	'RECENT_SECTIONS'				=> 'Sections',
++	'RECENT_SECTIONS_EXPLAIN'		=> 'Define the sections to be displayed in the block and their order.',
++	'RECENT_TOPIC_LIMIT'			=> 'Topic limit',
++	'RECENT_TOPIC_LIMIT_EXPLAIN'	=> 'Maximum number of items to be displayed in each tab.',
++
++	// Rss block
++	'1_HOUR'		=> 'One hour',
++	'2_HOURS'		=> 'Two hours',
++	'6_HOURS'		=> 'Siz hours',
++	
++	'RSS_COLLAPSABLE'			=> 'Collapsable',
++	'RSS_COLLAPSABLE_EXPLAIN'	=> 'Sets whether the items are displayed in an accordion or scrolling. If set to "Yes" will override the block scroll.',
++	'RSS_DIRECTION'				=> 'Scroll direction',
++	'RSS_DIRECTION_EXPLAIN'		=> 'Defining the direction of scrolling text. This option is canceled if the items are displayed in an accordion.',
++	'RSS_HEIGHT'				=> 'Block height',
++	'RSS_HEIGHT_EXPLAIN'		=> 'Sets the height of the block, in pixels. Only apply if items are not displayed in accordion format.',
++	'RSS_IGNORE_LANG'			=> 'Ignore feed lang',
++	'RSS_IGNORE_LANG_EXPLAIN'	=> 'If enabled, all URLs are read, regardless of their language, otherwise it will only display the contents written in the language of the user.',
++	'RSS_LIMIT'					=> 'Feed limit',
++	'RSS_LIMIT_EXPLAIN'			=> 'Maximum number of items to be read from each URL.',
++	'RSS_SOURCES'				=> 'Feed sources',
++	'RSS_TITLE'					=> 'Feed title',
++	'RSS_TTL'					=> 'Refresh time',
++	'RSS_TTL_EXPLAIN'			=> 'Time will remain cached items before attempting to read the source again.',
++	'RSS_URL'					=> 'File url',
++	'RSS_URL_EXPLAIN'			=> 'Ex: <em>http://midominio.com/rss.xml</em>',
++
++	// scroll_message_block
++	'MARQUEE_DIRECTION'				=> 'Scroll direction',
++	'MARQUEE_DIRECTION_EXPLAIN'		=> 'Scroll direction for the text. This attribute controls the direction of scrolling.',
++	'MARQUEE_SPEED'					=> 'Scroll amount',
++	'MARQUEE_SPEED_EXPLAIN'			=> 'This controls the amount of movement (in pixels) between the successive displays that give the impression of animation.',
++	'MARQUEE_SCROLLDELAY'			=> 'Scroll delay',
++	'MARQUEE_SCROLLDELAY_EXPLAIN'	=> 'This controls the delay (in milliseconds) between the successive displays that give the impression of animation.',
++	'MARQUEE_ALIGN'					=> 'Scroll align',
++	'MARQUEE_ALIGN_EXPLAIN'			=> 'This tag controls the positioning of the marquee display box relative to the current text in exactly the same manner as the img tag\'s align attribute.',
++	'MARQUEE_BGCOLOR'				=> 'Scroll bgcolor',
++	'MARQUEE_BGCOLOR_EXPLAIN'		=> 'This tag controls the background colour of the display box.',
++	'MARQUEE_HEIGHT'				=> 'Scroll height',
++	'MARQUEE_HEIGHT_EXPLAIN'		=> 'This controls the height of the display box.',
++	'MARQUEE_PADDING'				=> 'ScrollBox Padding',
++	'MARQUEE_PADDING_EXPLAIN'		=> 'Space around the scroll box. This attribute is equivalent to the attribute "padding" of CSS.',
++	'MARQUEE_TEXT'					=> 'Scroll message text',
++	'MARQUEE_TEXT_EXPLAIN'			=> 'Add/change a scrollable message here. Limit 2000 characters.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
++
++	'BOTTOM'		=> 'Bottom',
++	'DOWN'			=> 'Down',
++	'LEFT'			=> 'Left',
++	'CENTER'		=> 'Center',
++	'UP'			=> 'Up',
++	'RIGHT'			=> 'Right',
++	'TOP'			=> 'Top',
++	
++	//share_block
++	'SHARE_SHOW_NAMES'			=> 'Show names',
++	'SHARE_SHOW_NAMES_EXPLAIN'	=> 'If enabled, the name of the social network will be displayed next to its icon.',
++	'SHARE_URL'					=> 'Reference URL',
++	'SHARE_URL_EXPLAIN'			=> 'Set a fixed reference url for the buttons. Leave this field blank to use the displayed page.',
++	'SHARE_BUTTONS'				=> 'Buttons to show',
++	
++	// stats_block
++	'STATS_INLINE'			=> 'Show data in line',
++ 	'USER_STATS'			=> 'Display user statistics',
++	
++	// top_topics_block
++	'TOPT_LIMIT'			=> 'Topic limit',
++	'TOPT_LIMIT_EXPLAIN'	=> 'Maximun number of topic to show.',
++	'TOPT_MODE'				=> 'Topic to show',
++	'TOPT_MODE_ACTIVE'		=> 'Latest topics more active',
++	'TOPT_MODE_UNREAD'		=> 'Latest unread topics',
++	'TOPT_MODE_VIEWED'		=> 'More viewed topics',
++
++	// topic_index_block
++	'TINDEX_CHAR_SELECT'			=> 'Show Index',
++	'TINDEX_CHAR_SELECT_EXPLAIN'	=> 'Only avaliable if the sort method is <em>Topic title</em>.',
++	'TINDEX_PER_PAGE'			=> 'Topics per page',
++	'TINDEX_PER_PAGE_EXPLAIN'	=> 'Number of topics that will be show at the same time. Set 0 to disable pagination.',
++	'TINDEX_SORT_MODE'			=> 'Order by',
++	'TINDEX_SORT_MODE_EXPLAIN'	=> 'Method that will be used to set the topic\'s order in the list.',
++  
++	'TOPIC_TIME'		=> 'Topic date',
++	'LAST_POST_TIME'	=> 'Last post date',
++
++	// welcome_block
++	'WELCOME_GUEST'				=> 'Guests message',
++	'WELCOME_GUEST_EXPLAIN'		=> 'Message to display to all guests. 2000 characters max.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
++	'WELCOME_MEMBER'			=> 'Members message',
++	'WELCOME_MEMBER_EXPLAIN'	=> 'Message to display to all the forum registered users. 2000 characters max.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
++
++	// whos_online_block
++	'WHOS_ADVANCED'				=> 'Advanced mode',
++	'WHOS_ADVANCED_EXPLAIN'		=> 'If enabled, will display all the information, otherwise it will appear only basic information (suitable for side blocks).',
++	'WHOS_USERNAMES'			=> 'Show user list',
++	'WHOS_USERNAMES_EXPLAIN'	=> 'If enabled, displays the list of users online (only in advanced mode).',
++
++	// youtube_block
++	'YT_AUTOPLAY'				=> 'AutoPlay enabled',
++	'YT_AUTOPLAY_EXPLAIN'		=> 'If enabled, the video will play automatically.<br />If you have multiple videos, only the first autoplay.',
++	'YT_DISPLAY_MODE'			=> 'Display Mode',
++	'YT_FULL_PREVIEW'			=> 'Show thumbnails, title and description',
++	'YT_LIST'					=> 'Show a list with titles',
++	'YT_RANDOM_DISPLAY'			=> 'Random Display',
++	'YT_RANDOM_DISPLAY_EXPLAIN'	=> 'If enabled, only one video will be appear randomly. Otherwise, all the videos and channels appear at once.',
++	'YT_RESULT_LIMIT'			=> 'Number of channel videos',
++	'YT_RESULT_LIMIT_EXPLAIN'	=> 'Maximun number of videos loaded in each channel.',
++	'YT_SIMPLE_PREVIEW'			=> 'Show thumbnails and titles',
++	'YT_TEXT_LIMIT'				=> 'Text limit',
++	'YT_TEXT_LIMIT_EXPLAIN'		=> 'Maximun number of characters in the video description.',
++	'YT_VIDEO_PREVIEW'			=> 'Show video preview',
++	'YT_VIDEO_SIZE'				=> 'Player size',
++	'YT_VIDEO_TITLE'			=> 'Video title',
++	'YT_VIDEO_URL'				=> 'Video url',
++	'YT_VIDEO_URL_EXPLAIN'		=> 'Ex: <em>https://www.youtube.com/watch?v=NHH_v0k7Gus</em>',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/chat_addon.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/chat_addon.php"
+new file mode 100644
+index 000000000..726889601
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/chat_addon.php"
+@@ -0,0 +1,32 @@
++<?php
++/** 
++* chat_addon.php [English [En]]
++*
++* @package language cBB Blockgets
++* @version v2.0.1 04/05/2018
++*
++* @copyright (c) 2018 CaniDev
++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
++*/
++
++// @ignore
++if(!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if(empty($lang['blocks']))
++{
++	$lang['blocks'] = array();
++}
++
++$lang['blocks'] = array_merge($lang['blocks'], array(
++	'chat_title'	=> 'Chat',
++	'chat_explain'	=> 'Allows you to use cBB Chat as a block in the columns or show the users connected to the chat.',
++));
++
++$lang = array_merge($lang, array(
++	'CHAT_ADDON_MODE'		=> 'Display mode',
++	'CHAT_MODE_CHAT'		=> 'Chat room',
++	'CHAT_MODE_USERS'		=> 'Online Users',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/email/contact_block.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/email/contact_block.txt"
+new file mode 100644
+index 000000000..5ee2e8c3e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/email/contact_block.txt"
+@@ -0,0 +1,6 @@
++
++The following is an e-mail sent to you from "{SITENAME}" for {FROM_USERNAME} by the contact form:
++
++----------
++
++{MESSAGE}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/info_acp_blockgets.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/info_acp_blockgets.php"
+new file mode 100644
+index 000000000..263814a48
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/info_acp_blockgets.php"
+@@ -0,0 +1,53 @@
++<?php
++/*
++* info_acp_blockgets.php [English [En]]
++* @package cBB Blockgets
++* @version v2.0.2 12/01/2021
++*
++* @copyright (c) 2021 CaniDev
++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
++*/
++
++// @ignore
++if(!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++/**
++ * @general tags and messages
++*/
++$lang = array_merge($lang, array(
++	'ACP_BLOCKGETS'				=> 'Blockgets',
++	'ACP_BLOCKGETS_GENERAL'		=> 'General',
++	
++	'ACP_BLG_CONFIG_MAIN'		=> 'General configuration',
++	'ACP_BLG_CONFIG_OPTIONAL'	=> 'Additional configuration',
++	'ACP_BLG_IMAGES'			=> 'Images',
++	'ACP_PAGES_AND_BLOCKS'		=> 'Pages and Blocks',
++	
++	// Logs
++	'LOG_BLG_CONFIG'		=> '<strong>cBB Blockgets:</strong> Changed main configuration',
++	'LOG_BLOCK_ADDED'		=> '<strong>cBB Blockgets:</strong> New block added<br />» %1$s in %2$s',
++	'LOG_BLOCK_COPY_PAGE'	=> '<strong>cBB Blockgets:</strong> Blocks copied<br />» de %1$s a %2$s',
++	'LOG_BLOCK_MOVED'		=> '<strong>cBB Blockgets:</strong> Changed blocks position<br />» %1$s',
++	'LOG_BLOCK_MOVED_PAGE'	=> '<strong>cBB Blockgets:</strong> Blocks moved<br />» from %1$s to %2$s',
++	'LOG_BLOCK_REMOVED'		=> '<strong>cBB Blockgets:</strong> Block(s) deleted<br />» en %1$s',
++	'LOG_BLOCK_UPDATED'		=> '<strong>cBB Blockgets:</strong> Block edited<br />» %1$s en %2$s',
++	'LOG_EVENT_REMOVED'		=> '<strong>cBB Blockgets:</strong> Event deleted<br />» %1$s',
++	'LOG_LIST_REMOVED'		=> '<strong>cBB Blockgets:</strong> List deleted<br />» %1$s',
++	'LOG_PAGE_ADDED'		=> '<strong>cBB Blockgets:</strong> New page added<br />» %1$s',
++	'LOG_PAGE_UPDATED'		=> '<strong>cBB Blockgets:</strong> Changed page<br />» %1$s',
++	'LOG_PAGE_REMOVED'		=> '<strong>cBB Blockgets:</strong> Page deleted<br />» %1$s',
++	
++	// Permissions
++	'ACL_A_BLOCKGETS_MANAGE'	=> 'Can manage cBB Blockgets',
++	'ACL_U_BLOCKGETS_BIRTHDAYS'	=> 'Can see birthdays in the Calendar',
++	'ACL_U_BLOCKGETS_CALENDAR'	=> 'Can view calendar',
++	'ACL_U_BLOCKGETS_EVENTS'	=> 'Can manage calendar events',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/installer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/installer.php"
+new file mode 100644
+index 000000000..f9a800fc4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/installer.php"
+@@ -0,0 +1,43 @@
++<?php
++/*
++* installer.php [English [En]]
++* @package cBB Blockgets
++* @version v2.0.2 12/01/2021
++*
++* @copyright (c) 2021 CaniDev
++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
++*/
++
++// @ignore
++if(!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if(empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++// Local Variables
++$lang = array_merge($lang, array(
++	'PORTAL'			=> 'Portal',
++	'DOCK_MENU'			=> 'Dock menu',
++	'MAIN_MENU'			=> 'Main Menu',
++	'RECOMMENDED'		=> 'Recommended',
++
++	'P_ADMIN'			=> 'Administration',
++	'P_MAIN'			=> 'Main',
++	'P_MCP'				=> 'Moderation Panel',
++	'P_ACP'				=> 'Administration Panel',
++
++	'PHPBB_TITLE'		=> 'phpBB official website',
++	'XAMPP_TITLE'		=> 'Xampp',
++	'SOURCEFORGE_TITLE'	=> 'Open source applications',
++
++	'WELCOME_GUEST'		=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Forum equipped with cBB Blockgets</i><br /><br />Welcome to our forum!<br />Register to access all the content!.</strong></div>[/html]',
++	'WELCOME_MEMBER'	=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Forum equipped with cBB Blockgets</i><br /><br />Welcome back to our forum {S_USERNAME}</strong></div>[/html]',	
++
++	'CORE_INSTALL_ERROR'	=> 'You have not uploaded all the files from the installation package or you are trying to install an old package.<br />
++		Please make sure to upload all the files (including the <em>core</em> folder) and use a package downloaded from the official website.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/main.php"
+new file mode 100644
+index 000000000..9100727fa
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/main.php"
+@@ -0,0 +1,269 @@
++<?php
++/*
++* main.php [English [En]]
++* @package cBB Blockgets
++* @version v2.0.2 12/01/2021
++*
++* @copyright (c) 2021 CaniDev
++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
++*/
++
++// @ignore
++if(!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if(empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'PORTAL'			=> 'Portal',
++	'READ_FULL'			=> 'Read full topic',
++	'BLG_READ_MORE'		=> '%sLer mais%s',
++
++	'ADD_PAGE'					=> 'Criar página',
++	'BANNERS'					=> 'Banners',
++	'CALENDAR'					=> 'Calendário',
++	'CALENDAR_BIRTHDAY_TITLE'	=> '%1$s e <strong>mais %2$d</strong>.',
++	'CALENDAR_SELECT_DATE'		=> 'Seleccionar data',
++	'EDIT_CONFIGURATION'		=> 'Editar configuração',
++	'EDIT_THIS_PAGE'			=> 'Editar esta página',
++	'EDITOR'					=> 'Editor',
++	'EXPAND_CONTRACT'			=> 'Expandir/colapsar',
++	'INSERT_ON_ENTRY'			=> 'Inserir no texto',
++	'MANAGE_BLOCKS'				=> 'Gerir blocos',
++	'PRINT'						=> 'Imprimir',
++	'SELECT_COLOUR'				=> 'Seleccionar cor',
++	'SMILIES'					=> 'Emoticons',
++	'TODAY'						=> 'Hoje',
++
++	// Editor
++	'HTML_TITLE' 		=> 'Html:',
++	'INSERT_HTML' 		=> 'Inserir Código HTML',
++
++	// Login Block
++	'HIDE_ME_NOW'			=> 'Hide me in this session',
++	'MY_BOOKMARKS'			=> 'Favoritos',
++	'MY_SUBSCRIBED'			=> 'Subscrições',
++	'REMEMBER_ME'			=> 'Lembrar-me',
++
++	// Link Us Block
++	'LINK_US_TXT'			=> 'Please feel free to link to <strong>%s</strong>. Use the following HTML:',
++
++	// Stats Block and whos_online block
++	'GUEST_VISITS_TOTAL'		=> '%d Visitantes',
++	'GUEST_VISIT_TOTAL'			=> '%d Visitante',
++	'HIDDEN_VISITS_TOTAL'		=> '%d ocultos, ',
++	'HIDDEN_VISIT_TOTAL'		=> '%d oculto, ',
++	'LASTVISIT_VISITS_TOTAL'	=> 'In total there were <strong>%d</strong> users online in the last 24 hours :: ',
++	'LASTVISIT_VISIT_TOTAL'		=> 'In total there is <strong>%d</strong> user online in the last 24 hours  :: ',
++	'REG_VISITS_TOTAL'			=> '%d Registados, ',
++	'REG_VISIT_TOTAL'			=> '%d Registado, ',
++
++	'ST_ACTIVE_POSTERS'			=> 'Active posters',
++	'ST_ANNS'					=> 'Announcements',
++	'ST_ATTACHMENTS'			=> 'Anexos',
++	'ST_BOARD_STARTDATE'		=> 'Start date',
++	'ST_NEW'					=> 'Novo',
++	'ST_NEWEST_USER'			=> 'Último membro',
++	'ST_POSTS'					=> 'Mensagens',
++	'ST_POSTS_PER_DAY'			=> 'Mensagens por dia',
++	'ST_POSTS_PER_TOPIC'		=> 'Mensagens por tópico',
++	'ST_POSTS_PER_USER'			=> 'Mensagens por utilizador',
++	'ST_STICKYS'				=> 'Importantes',
++	'ST_TOP'					=> 'Total',
++	'ST_TOPICS'					=> 'Tópicos',
++	'ST_TOPICS_PER_DAY'			=> 'Tópicos por dia',
++	'ST_TOPICS_PER_USER'		=> 'Tópicos por utilizador',
++	'ST_TOTAL_USERS'			=> 'Total utilizadores',
++	'ST_USERS_PER_DAY'			=> 'Utilizadores por dia',
++	'ST_VISIT_IP'				=> 'O teu IP',
++
++	'WIO_ONLINE'			=> 'Utilizadores online',
++	'WIO_LASTDAY'			=> 'Utilizadores hoje',
++	'WIO_TOTAL'				=> 'Total',
++	'WIO_REGISTERED'		=> 'Registados',
++	'WIO_HIDDEN'			=> 'Ocultos',
++	'WIO_GUEST'				=> 'Visitantes',
++
++	// polls
++	'NO_POLL'			=> 'Votação indisponível',
++
++	// attachments_block
++	'ATTACH_DATE'			=> 'Publicado',
++	'ATTACH_SIZE'			=> 'Tamanho',
++	'ATTACH_DOWNLOAD'		=> 'Transferido',
++	'ATTACH_VIEW'			=> 'Visto',
++
++	'ATTACH_COUNT'				=> array(
++		0	=> 'Nunca',
++		1	=> '%d vez',
++		2	=> '%d vezes',
++	),
++
++	'VIEW_TOPIC'				=> 'Ver Tópico',
++	'DOWNLOAD'					=> 'Download',
++	'NO_ATTACHMENTS'			=> 'Sem anexos disponíveis',
++
++	// language_select_block
++	'LANGUAGE_CHANGE'		=> 'Alterar idioma',
++	'LANGUAGE_DEFAULT'		=> 'Idioma Original',
++	'LANGUAGE_SET_MINE'		=> 'Gravar como meu idioma',
++	'LANGUAGE_SELECT'		=> 'Selecionar Idioma',
++
++	// news_block
++	'POSTED_BY'			=> 'Criado por',
++	'LAST_REPLIED_BY'	=> 'Última resposta por',
++	'COMMENTS_PORTAL'	=> 'Comentários',
++	'POLL'				=> 'Votação',
++	'TOPIC_VIEWS'		=> 'Visto',
++	'NO_NEWS'			=> 'Sem notícias disponíveis',
++	'VIEW_COMMENTS'		=> 'Ver comentários',
++
++	// recent_topics_block
++	'BLG_RECENT_ACTIVITY'	=> 'Actividade Recente',
++	'BLG_RECENT_ANN'		=> 'Anúncios Recentes',
++	'BLG_RECENT_TOPICS'		=> 'Tópicos Recentes',
++
++	// paypal_block
++	'AMOUNT_MSG'		=> 'Amount to donate',
++	'CLICK_MSG'			=> 'Proceed to donation',
++	'CODE_MSG'			=> 'Currency',
++	
++	'currencies'	=> array(
++		'AUD'	=> 'Aussie',
++		'CAD' 	=> 'Canadian Dollar',
++		'CZK' 	=> 'Czech Koruna',
++		'DKK' 	=> 'Danish Kroner',
++		'HKD' 	=> 'Hong Kong Dollar',
++		'HUF' 	=> 'Hungarian Forint',
++		'NZD' 	=> 'New Zealand Dollar',
++		'NOK' 	=> 'Norwegian Kroner',
++		'PLN' 	=> 'Polish Zlotych',
++		'GBP' 	=> 'British Pounds',
++		'SGD' 	=> 'Singapore Dollar',
++		'SEK' 	=> 'Swedish Kronor',
++		'CHF' 	=> 'Swiss Francs',
++		'JPY' 	=> 'Japanese Yen',
++		'USD' 	=> 'Dollar',
++		'EUR' 	=> 'Euro',
++		'AUD' 	=> 'Mexican Peso',
++		'ILS' 	=> 'New Israeli Shekels'
++	),
++
++	// most_poster_block
++	'MEMBER_POSTS'		=> '%d (%.2f/dia)',
++	'USER'				=> 'Utilizador',
++	'NO_MOST_POSTER'	=> 'Sem utilizadores para exibir',
++
++	// contact block
++	'EMAIL_EMPTY'		=> 'You must set an email.',
++	'EMAIL_INVALID'		=> 'The entered email is invalid.',
++
++	// counter block
++	'COUNTER_LOCAL'		=> 'Visits to this page',
++	'COUNTER_TOTAL' 	=> 'Total visits',
++	'COUNTER_STARTDATE' => 'Counting from:<br />%s',
++	'HITS_PER_DAY'		=> 'Visits per day',
++	'HITS_PER_HOUR'		=> 'Visits per hour',
++	'HITS_PER_MONTH'	=> 'Visits per month',
++	'HITS_PER_USER'		=> 'Visits per user',
++	'HITS_PER_WEEK'		=> 'Visits per week',
++	'HITS_PER_YEAR'		=> 'Visits per year',
++
++	// style_select_block
++	'STYLE_CHANGE'		=> 'Change Style',
++	'STYLE_DEFAULT'		=> 'Original style',
++	'STYLE_SET_MINE'	=> 'Set as my style',
++	'STYLE_SELECT'		=> 'Select style',
++
++	// latest_bots_block
++	'NO_BOTS'			=> 'Nenhum bot visitou o fórum',
++
++	// latest_unread_block
++	'NO_UNREAD'			=> 'Sem tópicos',
++
++	// ranks_block
++	'MIN_POSTS'			=> 'Minimum Posts',
++	'SPECIAL_RANK'		=> 'Special Rank',
++
++	// online_friends_block
++	'FRIENDS_ONLINE'		=> 'Online friends',
++	'FRIENDS_OFFLINE'		=> 'Offline friends',
++	'NO_FRIENDS_ONLINE'		=> 'No friends online',
++	'NO_FRIENDS_OFFLINE'	=> 'No friends offline',
++	'NO_FRIENDS'			=> 'No friends found',
++
++	// age_ranges_block
++	'RANGE'				=> 'Rank',
++	'RANGE_USERS'		=> 'Utilizadores (%)',
++	'AGE_COUNTS'		=> 'Utilizadores contados',
++	'AGE_AV'			=> 'Idade média',
++	'AGE_AV_COUNT'		=> '%.2f anos',
++
++	// search_block
++	'SH_ENGINE'			=> 'Search Engines',
++
++	// announcements_block
++	'NO_ANNOUNCEMENTS'	=> 'Sem Anúncios',
++
++	//birthday_block
++	'TODAY_BIRTHDAYS'		=> 'Today Birthdays',
++	'TOMORROW_BIRTHDAYS'	=> 'Tomorrow Birthdays',
++	'BIRTHDAYS_FOR'			=> 'Birthdays for %1$s of %2$s',
++
++	// calendar
++	'ADD_EVENT'				=> 'Adicionar evento',
++	'DELETE_EVENT'			=> 'Remover Evento',
++	'EDIT_EVENT'			=> 'Editar Evento',
++	'EVENTS'				=> 'Eventos',
++
++	'EMPTY_EVENT_TITLE'	=> 'Tem de colocar um título para o evento.',
++	'EVENT_ADDED'		=> 'Evento adicionado com sucesso',
++	'EVENT_COLOR'		=> 'Cor',
++	'EVENT_EDITED'		=> 'Evento editado com sucesso',
++	'EVENT_GROUPS'		=> 'Grupos autorizados',
++	'EVENT_TITLE'		=> 'Título do Evento',
++	'EVENT_TIME'		=> 'Data do Evento',
++	'EVENT_DETAILS'		=> 'Detalhes',
++	'EVENT_REMOVED'		=> 'Evento removido com sucesso',
++	'NO_EVENTS'			=> 'Sem eventos',
++	
++	//player block
++	'MUTE'				=> 'Silenciar',
++	'WIN_CLOSE'			=> 'Fechar janela e regressar ao bloco',
++	'WIN_OPEN'			=> 'Abrir numa nova janela',
++	'WIN_OPEN_EXPLAIN'	=> 'Playing in Window',
++	'WIN_RETURN'		=> 'Forze player in the block',
++	'PLAY'				=> 'Play',
++	'PLAY_MSG'			=> 'Playing',
++	'PLAYER'			=> 'Player',
++	'STOP'				=> 'Parar',
++	'STOP_MSG'			=> 'Parou',
++	'VOLUME'			=> 'Volume',
++	'VOLUME_MSG'		=> 'Volume: %d%',
++	
++	// rss block
++	'NO_RSS'		=> 'Sem Rss/Feed para mostrar.',
++
++	// topic index block
++	'CHAR_ALL'		=> 'Todos',
++	
++	// youtube block
++	'YT_EMPTY'		=> 'Sem vídeos para mostrar',
++	'YT_VIEWS'		=> '%d vistos',
++));
++
++// General messages
++$lang = array_merge($lang, array(
++	'ACTION_ERROR'		=> 'No action taken',
++	'BLOCK_LOAD_ERROR'	=> 'Failed to load block',
++	'FORMAT_INVALID'	=> 'The format is not valid',
++	'EVENT_ERROR'		=> 'The selected event does not exist',
++	'NO_TRACKLIST'		=> 'No avaliable tracklist.',
++	'NO_PAGE'			=> 'This page no exists.',
++	'URL_INVALID'		=> 'The URL is not valid.',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/block_view.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/block_view.html"
+deleted file mode 100644
+index 31ea38fac..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/block_view.html"
++++ /dev/null
+@@ -1,62 +0,0 @@
+-	
+-{% if block.IS_GROUP %}
+-	<div id="block-{{ block.BLOCK_ID }}" class="blg-grid">
+-	{% for sub in block.blocks %}
+-		<div id="block-{{ sub.BLOCK_ID }}" class="blg-block {{ sub.BLOCK_CLASSES }}"{% if sub.DOM_STYLE %} style="{{ sub.DOM_STYLE}} "{% endif %}>
+-		{% if sub.BLOCK_STYLE == 'content_simple' %}
+-			<div class="block-content">
+-				{{ sub.BLOCK_CONTENT }}
+-			</div>
+-		{% else %}
+-			<table class="footable table table-striped table-bordered table-white table-primary default footable-loaded">
+-			<thead>
+-				<tr>
+-					<th class="block-title">
+-						{{ sub.BLOCK_ICON }}
+-						<span class="cbb-helper-text cbb-inline">{{ sub.BLOCK_TITLE }}</span>
+-					</th>
+-				</tr>
+-			</thead>
+-			<tbody>
+-			<tr>
+-				<td>
+-					<div class="block-content">
+-						{{ sub.BLOCK_CONTENT }}
+-					</div>
+-				</td>
+-			</tr>
+-			</tbody>
+-			</table>
+-		{% endif %}
+-		</div>
+-	{% endfor %}
+-	</div>
+-{% else %}
+-	<div id="block-{{ block.BLOCK_ID }}" class="blg-block {{ block.BLOCK_CLASSES }}">
+-	{% if block.BLOCK_STYLE == 'content_simple' %}
+-		<div class="block-content">
+-			{{ block.BLOCK_CONTENT }}
+-		</div>
+-	{% else %}
+-		<table class="footable table table-striped table-bordered table-white table-primary default footable-loaded">
+-		<thead>
+-			<tr>
+-				<th class="block-title">
+-					{{ block.BLOCK_ICON }}
+-					<span class="cbb-helper-text cbb-inline">{{ block.BLOCK_TITLE }}</span>
+-				</th>
+-			</tr>
+-		</thead>
+-		<tbody>
+-		<tr>
+-			<td>
+-				<div class="block-content">
+-					{{ block.BLOCK_CONTENT }}
+-				</div>
+-			</td>
+-		</tr>
+-		</tbody>
+-		</table>
+-	{% endif %}
+-    </div>
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/contact_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/contact_block.html"
+deleted file mode 100644
+index 82cc5006b..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/contact_block.html"
++++ /dev/null
+@@ -1,59 +0,0 @@
+-
+-<script>
+-// <![CDATA[
+-	window._jPostponed = window._jPostponed || [];
+-	window._jPostponed.push(function() {
+-		$('#block-{{ BLOCK_ID }} form').cbbAjaxify({
+-			onSuccess: function() {
+-				this.element.find('[name=subject], [name=message]').val('');
+-			}
+-		});
+-	});
+-// ]]>
+-</script>
+-
+-<form method="post" action="{{ U_BLG_ACTION }}">
+-	<table class="blg-table contact-table {% if BLOCK_VIEW_SMALL %}short-view{% else %}full-table{% endif %}">
+-{% if BLOCK_VIEW_SMALL %}
+-	{% for fieldrow in loops.fieldrow %}
+-	<tr>
+-		<td>
+-			<strong>{{ fieldrow.TITLE ~ lang('COLON') }}</strong><br />
+-		{% if fieldrow.TYPE == 'text' %}
+-			<input type="text" name="{{ fieldrow.KEY }}" id="{{ fieldrow.KEY }}" size="35" value="{{ fieldrow.VALUE }}" class="cbb-inputbox" />
+-		{% elseif fieldrow.TYPE == 'textarea' %}
+-			<textarea name="{{ fieldrow.KEY }}" id="{{ fieldrow.KEY }}" cols="30" rows="6" class="cbb-inputbox">{{ fieldrow.VALUE }}</textarea>
+-		{% elseif fieldrow.TYPE == 'custom' %}
+-			{{ fieldrow.TEMPLATE }}
+-		{% endif %}
+-		</td>
+-	</tr>
+-	{% endfor %}
+-{% else %}
+-		<col width="35%" /><col width="65%" />
+-	{% for fieldrow in loops.fieldrow %}
+-		<tr>
+-			<td class="blg-align-right"{% if fieldrow.TYPE == 'textarea' %} valign="top"{% endif %}>
+-				<label for="{{ fieldrow.KEY }}"><strong>{{ fieldrow.TITLE ~ lang('COLON') }}</strong></label>
+-			</td>
+-			<td>
+-			{% if fieldrow.TYPE == 'text' %}
+-				<input type="text" name="{{ fieldrow.KEY }}" id="{{ fieldrow.KEY }}" size="35" value="{{ fieldrow.VALUE }}" class="cbb-inputbox autowidth" />
+-			{% elseif fieldrow.TYPE == 'textarea' %}
+-				<textarea name="{{ fieldrow.KEY }}" id="{{ fieldrow.KEY }}" cols="30" rows="8" class="cbb-inputbox">{{ fieldrow.VALUE }}</textarea>
+-			{% elseif fieldrow.TYPE == 'custom' %}
+-				{{ fieldrow.TEMPLATE }}
+-			{% endif %}
+-			</td>
+-		</tr>
+-	{% endfor %}
+-{% endif %}
+-	</table>
+-
+-	<br />
+-	<div class="blg-align-center">
+-		<input type="submit" class="btn btn-default" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />
+-		{{ BLOCK_HIDDEN_FIELDS }}
+-		{{ S_FORM_TOKEN_BLG_CONTACT }}
+-	</div>
+-</form>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/forums_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/forums_block.html"
+deleted file mode 100644
+index 7839fb0bb..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/forums_block.html"
++++ /dev/null
+@@ -1,110 +0,0 @@
+-
+-{% if BLOCK_VIEW_SMALL and not BLOCK_VIEW_MEDIUM %}
+-<ul class="blg-linear-list">
+-
+-{% for forum_row in loops.forum_row %}
+-	{% if forum_row.S_IS_CAT or forum_row.S_FIRST_ROW or forum_row.S_NO_CAT %}
+-	<li class="menu-cat">
+-		{% if forum_row.S_IS_CAT %}<a href="{{ forum_row.U_VIEWFORUM }}">{{ forum_row.FORUM_NAME }}</a>{% else %}{{ lang('FORUM') }}{% endif %}
+-	</li>
+-	{% endif %}
+-
+-	{% if not forum_row.S_IS_CAT %}
+-	<li class="subchild double-space">
+-		<i class="fa {{ forum_row.FORUM_ICON }} fa-lg"></i>
+-		<a href="{{ forum_row.U_VIEWFORUM }}">{{ forum_row.FORUM_NAME }}</a>
+-	</li>
+-	{% endif %}
+-
+-{% else %}
+-	<li><strong>{{ lang('NO_FORUMS') }}</strong></li>
+-{% endfor %}
+-
+-</ul>
+-
+-{% else %}
+-
+-<div class="blg-forum-list{% if BLOCK_VIEW_MEDIUM %} title-only{% endif %}">
+-
+-{% for forum_row in loops.forum_row %}
+-	{% if (forum_row.S_IS_CAT and not forum_row.S_FIRST_ROW) or forum_row.S_NO_CAT %}
+-		</tbody>
+-		</table>
+-
+-		{% if BLOCK_STYLE == 'content_simple' %}</div>{% endif %}
+-	{% endif %}
+-
+-	{% if forum_row.S_IS_CAT or forum_row.S_FIRST_ROW or forum_row.S_NO_CAT %}
+-		{% if BLOCK_STYLE == 'content_simple' %}
+-		<div class="panel panel-default">
+-		{% else %}
+-		<div class="blg-widget-header">
+-			{% if not BLOCK_VIEW_MEDIUM %}<div class="fb-lastpost-title">{{ lang('LAST_POST') }}</div>{% endif %}
+-			{% if forum_row.S_IS_CAT %}<a href="{{ forum_row.U_VIEWFORUM }}">{{ forum_row.FORUM_NAME }}</a>{% else %}{{ lang('FORUM') }}{% endif %}
+-		</div>
+-		{% endif %}
+-
+-		<table class="footable table table-striped table-bordered table-white table-primary table-hover topics-table">
+-		{% if BLOCK_STYLE == 'content_simple' %}
+-		<thead>
+-			<tr><th colspan="3">{{ BLOCK_TITLE }}</th></tr>
+-		</thead>
+-		{% endif %}
+-
+-		<tbody>
+-	{% endif %}
+-
+-	{% if not forum_row.S_IS_CAT %}
+-		<tr>
+-			<td>
+-				{% if forum_row.FORUM_IMAGE %}<span class="forum-image">{{ forum_row.FORUM_IMAGE }}</span>{% endif %}
+-				<span class="icon-wrapper">
+-					<i class="row-icon-font icon-moon-default{% if forum_row.S_IS_LINK %} icon-moon-link2{% endif %}{% if forum_row.S_UNREAD_FORUM %} forum-unread{% else %} forum-read{% endif %}"></i>
+-				</span>
+-				<span class="desc-wrapper">
+-					<a href="{{ forum_row.U_VIEWFORUM }}" class="forumtitle">{{ forum_row.FORUM_NAME }}</a><br />
+-					{{ forum_row.FORUM_DESC }}
+-					{% if forum_row.MODERATORS %}
+-						<span class="forum-mods"><strong>{{ forum_row.L_MODERATOR_STR ~ lang('COLON') }}</strong>&nbsp;{{ forum_row.MODERATORS }}</span>
+-					{% endif %}
+-					{% if forum_row.SUBFORUMS and forum_row.S_LIST_SUBFORUMS %}
+-					<br />
+-					<span class="subforums">
+-				 		 <strong>{{ forum_row.L_SUBFORUM_STR }}</strong>
+-				 		 {{ forum_row.SUBFORUMS }}
+-				 	</span>
+-					{% endif %}
+-
+-				</span>
+-			</td>
+-		{% if not BLOCK_VIEW_MEDIUM %}
+-			{% if forum_row.CLICKS %}
+-				<td colspan="2"><span class="stats-wrapper">{{ lang('REDIRECTS') ~ lang('COLON') }} {{ forum_row.CLICKS }}</td>
+-			{% elseif not forum_row.S_IS_LINK %}
+-				<td class="fb-stats blg-align-center">{{ forum_row.TOPICS }} {{ lang('TOPICS') }}<br />{{ forum_row.POSTS }} {{ lang('POSTS') }}</dd>
+-				<td class="lastpost">
+-				{% if forum_row.LAST_POST_TIME %}
+-					<a class="cbb-helper-text" href="{{ forum_row.U_LAST_POST }}" title="{{ forum_row.LAST_POST_SUBJECT }}">{{ forum_row.LAST_POST_SUBJECT }}</a>
+-					<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ forum_row.LAST_POSTER_FULL }}
+-					<br /><span class="forum-time"><i class="fa fa-clock-o"></i>&nbsp;{{ forum_row.LAST_POST_TIME }}</span>
+-				{% else %}
+-					{{ lang('NO_POSTS') }}<br />&nbsp;
+-				{% endif %}
+-				</td>
+-			{% endif %}
+-		{% endif %}
+-		</tr>
+-	{% endif %}
+-	
+-	{% if forum_row.S_LAST_ROW %}
+-	</tbody>
+-	</table>
+-
+-		{% if BLOCK_STYLE == 'content_simple' %}</div>{% endif %}
+-	{% endif %}
+-{% else %}
+-	<strong>{{ lang('NO_FORUMS') }}</strong>
+-{% endfor %}
+-
+-</div>
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/language_select_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/language_select_block.html"
+deleted file mode 100644
+index 9771df9ab..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/language_select_block.html"
++++ /dev/null
+@@ -1,21 +0,0 @@
+-
+-<script>
+-// <![CDATA[
+-	window._jPostponed = window._jPostponed || [];
+-	window._jPostponed.push(function() {
+-		$('#block-{{ BLOCK_ID }} form').cbbAjaxify();
+-	});
+-// ]]>
+-</script>
+-
+-<form method="post" action="{{ U_BLG_ACTION }}">
+-	<ul class="blg-linear-list blg-align-center">
+-		<li class="double-space"><select name="lng" class="cbb-inputbox">{{ LANGUAGE_SELECT }}</select></li>
+-		{% if CAN_SAVE_LANGUAGE %}<li class="doubl-space"><label><input type="checkbox" name="default" value="1" /> {{ lang('LANGUAGE_SET_MINE') }}</label></li>{% endif %}
+-		<li class="double-space">
+-			<input type="submit" name="submit" class="btn btn-default" value="{{ lang('LANGUAGE_CHANGE') }}" />
+-			{{ S_BLOCK_HIDDEN_FIELDS }}
+-		</li>
+-		{% if U_LANGUAGE_DEFAULT %}<li class="double-space"><a href="{{ U_LANGUAGE_DEFAULT }}">{{ lang('LANGUAGE_DEFAULT') }}</a></li>{% endif %}
+-	</ul>
+-</form>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/login_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/login_block.html"
+deleted file mode 100644
+index 2628376de..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/login_block.html"
++++ /dev/null
+@@ -1,103 +0,0 @@
+-
+-{% if S_USER_LOGGED_IN %}
+-<script>
+-// <![CDATA[
+-	window._jPostponed = window._jPostponed || [];
+-	window._jPostponed.push(function() {
+-		$('#block-{{ BLOCK_ID }} #blg-logout').cbbAjaxify();
+-	});
+-// ]]>
+-</script>
+-
+-<ul class="blg-linear-list blg-align-center">
+-	<li class="menu-cat">{{ USERNAME_FULL }}</li>
+-	<li class="double-space">
+-		<a href="{{ U_PROFILE }}">
+-			<span class="cbb-circular-avatar">{% if USER_AVATAR %}{{ USER_AVATAR }} {% else %}<span class="cbb-no-avatar"></span>{% endif %}</span>
+-		</a>
+-	</li>
+-
+-	{% if USER_RANK_IMG %}<li>{{ USER_RANK_TITLE }}<br />{{ USER_RANK_IMG }}</li>{% endif %}
+-	{% if S_LAST_VISIT %}<li class="double-space">{{ S_LAST_VISIT }}</li>{% endif %}
+-	{% if S_CURRENT_TIME %}<li class="double-space">{{ S_CURRENT_TIME }}</li>{% endif %}
+-	
+-	{{ S_BLG_LOGIN_FIELDS }}
+-</ul>
+-
+-<br />
+-
+-<ul class="blg-menu blg-linear-list">
+-{% for link in userlink %}
+-	<li>
+-		<i class="icon fa {% if link.ICON %}{{ link.ICON }}{% else %}fa-chevron-right{% endif %} fa-fw" aria-hidden="true"></i>
+-		<a href="{{ link.URL }}">{{ link.TITLE }}</a>
+-	</li>
+-{% endfor %}
+-
+-	<li class="blg-align-center double-space top-bordered"><a id="blg-logout" class="btn btn-default" href="{{ U_LOGOUT }}">{{ lang('LOGIN_LOGOUT') }}</a></li>
+-</ul>
+-
+-{% else %}
+-<script>
+-// <![CDATA[
+-	window._jPostponed = window._jPostponed || [];
+-	window._jPostponed.push(function() {
+-		$('#block-{{ BLOCK_ID }} form').cbbAjaxify();
+-	});
+-// ]]>
+-</script>
+-
+-<form action="{{ U_BLG_ACTION }}" method="post">
+-	<ul class="blg-linear-list blg-align-center">
+-		<li class="double-space bottom-bordered"><strong>{{ lang('LOGIN') }}</strong></li>
+-
+-		<li class="blg-align-left"><strong>{{ lang('USERNAME') ~ lang('COLON') }}</strong></li>
+-		<li><input class="cbb-inputbox full-width" type="text" name="username" value="{{ S_USERNAME }}" /></li>
+-		
+-		<li class="blg-align-left"><strong>{{ lang('PASSWORD') ~ lang('COLON') }}</strong></li>
+-		<li><input class="cbb-inputbox full-width" type="password" name="password" value="" /></li>
+-		{% if U_SEND_PASSWORD %}<li class="blg-align-left"><a href="{{ U_SEND_PASSWORD }}">{{ lang('FORGOT_PASS') }}</a></li>{% endif %}
+-		{% if U_RESEND_ACTIVATION %}<li class="blg-align-left"><a href="{{ U_RESEND_ACTIVATION }}">{{ lang('RESEND_ACTIVATION') }}</a></li>{% endif %}
+-	</ul>
+-	
+-	{% if S_DISPLAY_FULL_LOGIN %}
+-	<br />
+-	<ul class="blg-linear-list">
+-		{% if S_AUTOLOGIN_ENABLED %}
+-		<li>
+-			<input id="autologin-{{ BLOCK_ID }}" type="checkbox" class="radio cbb-checkbox" name="autologin" />
+-			<label for="autologin-{{ BLOCK_ID }}">{{ lang('REMEMBER_ME') }}</label>
+-		</li>
+-		{% endif %}
+-		
+-		<li>
+-			<input id="viewonline-{{ BLOCK_ID }}" type="checkbox" class="radio cbb-checkbox" name="viewonline" />
+-			<label for="viewonline-{{ BLOCK_ID }}">{{ lang('HIDE_ME_NOW') }}</label>
+-		</li>
+-	</ul>
+-	{% endif %}
+-
+-	<div class="blg-align-center">
+-		<br />
+-		<input type="submit" name="login" class="btn btn-default" value="{{ lang('LOGIN') }}" />
+-		{{ S_BLG_LOGIN_FIELDS }}
+-		{{ S_FORM_TOKEN_BLG_LOGIN }}
+-	</div>
+-</form>
+-
+-	{% if PROVIDER_TEMPLATE_FILE %}
+-		{% INCLUDE PROVIDER_TEMPLATE_FILE %}
+-	{% endif %}
+-
+-	{% if S_REGISTER_ENABLED and S_DISPLAY_REGISTER %}
+-	<br />
+-	<ul class="blg-linear-list">
+-		<li class="double-space bottom-bordered blg-align-center"><strong>{{ lang('REGISTER') }}</strong></li>
+-		<li><i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i> <a href="{{ U_TERMS_USE }}">{{ lang('TERMS_USE') }}</a></li>
+-		<li><i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i> <a href="{{ U_PRIVACY }}">{{ lang('PRIVACY') }}</a></li>
+-	
+-		<li class="double-space blg-align-center"><a href="{{ U_REGISTER }}"><input type="button" class="btn btn-default" value="{{ lang('REGISTER') }}" /></a></li>
+-	</ul>
+-	{% endif %}
+-
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/news_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/news_block.html"
+deleted file mode 100644
+index a6eb7f79f..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/news_block.html"
++++ /dev/null
+@@ -1,143 +0,0 @@
+-
+-<div id="news-{{ BLOCK_ID }}"{% if S_NEWS_FULL_CONTENT || S_NEWS_COLLAPSE %} class="cbb-helper-hidden"{% endif %}>
+-
+-<script>
+-// <![CDATA[
+-	window._jPostponed = window._jPostponed || [];
+-	window._jPostponed.push(function() {
+-
+-	{% if S_NEWS_FULL_CONTENT or S_NEWS_COLLAPSE %}
+-		$('#news-{{ BLOCK_ID }}').blgAccordion({
+-			collapsable: '{{ S_NEWS_COLLAPSE }}'
+-		});
+-	{% endif %}
+-
+-		$('#news-{{ BLOCK_ID }}').cbbLoader({
+-			replace: true,
+-			requestData: {
+-				jblgm: '{{ BLOCK_ID }}',
+-			}
+-		});
+-
+-		this.call('@blockgets/resizeImages', '#news-{{ BLOCK_ID }} .news-content');
+-	});
+-// ]]>
+-</script>
+-
+-{% if news_row|length %}
+-
+-{% if not S_NEWS_FULL_CONTENT and not S_NEWS_COLLAPSE %}
+-
+-	<ul class="blg-linear-list">
+-	{% for topicrow in news_row %}
+-		<li class="double-space">
+-			<div>
+-				<i class="fa fa-bullhorn fa-lg" aria-hidden="true"></i>
+-				{% EVENT topiclist_row_prepend %}
+-				<a href="{{ topicrow.U_VIEW_TOPIC }}"><strong>{{ topicrow.TOPIC_TITLE }}</strong></a>
+-			</div>
+-			<div>
+-				{{ lang('POSTED_BY') ~ lang('COLON') }}
+-				<strong>{{ topicrow.TOPIC_AUTHOR_FULL }}</strong>
+-				{% if BLOCK_VIEW_SMALL %}<br />{% else %}&bull;{% endif %} {{ topicrow.FIRST_POST_TIME }}
+-			</div>
+-		</li>
+-	{% endfor %}
+-	</ul>
+-
+-{% else %}
+-
+-	{% for topicrow in news_row %}
+-		<h5>
+-			{% EVENT topiclist_row_prepend %}
+-			<span>{{ topicrow.TOPIC_TITLE }}</span>
+-		</h5>
+-		<div>
+-		{% if BLOCK_VIEW_SMALL %}
+-			<div>{{ topicrow.FIRST_POST_TIME }}</div>
+-			<div>{{ lang('POSTED_BY') ~ lang('COLON') }} <strong>{{ topicrow.TOPIC_AUTHOR_FULL }}</strong></div>
+-			{% if topicrow.FORUM_NAME and S_NEWS_FULL_CONTENT %}<div>{{ lang('FORUM') ~ lang('COLON') }} <strong><a href="{{ topicrow.U_VIEW_FORUM }}">{{ topicrow.FORUM_NAME }}</a></strong></div>{% endif %}
+-		
+-			{% if S_NEWS_FULL_CONTENT %}
+-			<div class="news-content">{{ topicrow.TEXT }}</div>
+-			
+-			<div>
+-				<hr />
+-				<a href="{{ topicrow.U_VIEW_COMMENTS }}" title="{{ lang('VIEW_COMMENTS') }}">{{ lang('COMMENTS') ~ lang('COLON') }} {{ topicrow.REPLIES }}</a> <br />
+-				<a href="{{ topicrow.U_VIEW_TOPIC }}" title="{{ lang('READ_FULL') }}">{{ lang('TOPIC_VIEWS') ~ lang('COLON') }} {{ topicrow.VIEWS }}</a>
+-			</div>
+-			{% endif %}
+-		
+-		{% else %}
+-			<table class="blg-table">
+-			<tr>
+-				<td class="blg-align-left">{% if topicrow.S_HAS_ATTACHMENTS %}<i class="fa fa-paperclip fa-lg" aria-hidden="true"></i> {% endif %}{% if topicrow.S_HAS_POLL %}<strong>{{ lang('POLL') ~ lang('COLON') }} </strong>{% endif %}<a href="{{ topicrow.U_VIEW_TOPIC }}"><strong>{{ topicrow.TOPIC_TITLE }}</strong></a></td>
+-				<td class="blg-align-right">{{ topicrow.FIRST_POST_TIME }}</td>
+-			</tr>
+-		
+-			<tr>
+-				<td colspan="2">{{ lang('POSTED_BY') ~ lang('COLON') }} <strong>{{ topicrow.TOPIC_AUTHOR_FULL }}</strong></td>
+-			</tr>
+-		
+-		{% if S_NEWS_FULL_CONTENT %}
+-		
+-			{% if topicrow.FORUM_NAME %}<tr><td colspan="2">{{ lang('FORUM') ~ lang('COLON') }} <strong><a href="{{ topicrow.U_VIEW_FORUM }}">{{ topicrow.FORUM_NAME }}</a></strong></td></tr>{% endif %}
+-		
+-			<tr>
+-				<td colspan="2" class="blg-align-{{ S_CONTENT_FLOW_BEGIN }}">
+-		
+-					<div class="news-content">{{ topicrow.TEXT }}</div>
+-					  
+-				{% if topicrow.S_HAS_ATTACHMENTS %}
+-					<dl class="attachbox">
+-						<dt>{{ lang('ATTACHMENTS') }}</dt>
+-						{% for attachment in topicrow.attachment %}
+-							<dd>{{ attachment.DISPLAY_ATTACHMENT }}</dd>
+-						{% endfor %}
+-					</dl>
+-				{% endif %}
+-		
+-				</td>
+-			</tr>
+-		
+-			<tr>
+-				<td colspan="2" class="blg-align-left">
+-					<span>{{ lang('COMMENTS') ~ lang('COLON') }} {{ topicrow.REPLIES }}</span> &bull;
+-					<a href="{{ topicrow.U_POST_REPLY }}" title="{{ lang('POST_REPLY') }}">{{ lang('POST_REPLY') }}</a> &bull;
+-					<a href="{{ topicrow.U_VIEW_TOPIC }}" title="{{ lang('READ_FULL') }}">{{ lang('TOPIC_VIEWS') ~ lang('COLON') }} {{ topicrow.VIEWS }}</a>
+-				</td>
+-			</tr>
+-		{% endif %}
+-			</table>
+-		{% endif %}
+-		</div>
+-	{% endfor %}
+-
+-{% endif %}
+-
+-{% if block_pagination|length %}
+-	<div class="pull-right">	 
+-		<ul class="pagination pagination-forum {% if BLOCK_VIEW_SMALL %}pagination-xs{% else %}pagination-sm{% endif %} hidden-xs">
+-		{% for pagination in block_pagination %}
+-			{% if pagination.S_IS_PREV %}
+-			<li class="previous"><a href="{{ pagination.PAGE_URL }}" rel="prev" role="button">{{ lang('PREVIOUS') }}</a></li>
+-			{% elseif pagination.S_IS_CURRENT %}
+-			<li class="active"><span>{{ pagination.PAGE_NUMBER }}</span></li>
+-			{% elseif pagination.S_IS_ELLIPSIS %}
+-			<li class="ellipsis" role="separator"><span>{{ lang('ELLIPSIS') }}</span></li>
+-			{% elseif pagination.S_IS_NEXT %}
+-			<li class="next"><a href="{{ pagination.PAGE_URL }}" rel="next" role="button">{{ lang('NEXT') }}</a></li>
+-			{% else %}
+-			<li><a href="{{ pagination.PAGE_URL }}" role="button">{{ pagination.PAGE_NUMBER }}</a></li>
+-			{% endif %}
+-		{% endfor %}
+-		</ul>
+-	</div>
+-	<div class="cbb-helper-clear"></div>
+-{% endif %}
+-
+-{% else %}
+-<div class="blg-align-center">{{ lang('NO_NEWS') }}</div>
+-{% endif %}
+-
+-</div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/poll_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/poll_block.html"
+deleted file mode 100644
+index a268f2907..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/poll_block.html"
++++ /dev/null
+@@ -1,59 +0,0 @@
+-{% if poll|length %}
+-	<script>
+-	// <![CDATA[
+-		window._jPostponed = window._jPostponed || [];
+-		window._jPostponed.push(function() {
+-			$('#poll-{{ BLOCK_ID }}').cbbAjaxify({
+-				onSuccess: function(response) {
+-					this.element.replaceWith(response.htmlContent);
+-				}
+-			});
+-		});
+-	// ]]>
+-	</script>
+-
+-{% for poll in loops.poll %}
+-{% if poll.S_CAN_VOTE %}<form id="poll-{{ BLOCK_ID }}" method="post" action="{{ U_BLG_ACTION }}">{% endif %}
+-	<ul class="blg-linear-list blg-align-center">
+-		<li class="double-space menu-cat">{{ poll.S_POLL_QUESTION }}</li>
+-		{% if poll.S_POLL_LENGTH %}<li>{{ poll.S_POLL_LENGTH }}</li>{% endif %}
+-		{% if poll.S_CAN_VOTE %}<li>{{ poll.S_MAX_VOTES }}</li>{% endif %}
+-	</ul>
+-
+-	{% for poll_option in poll.poll_option %}
+-	<div class="blg-poll-option">
+-		<div class="poll-option-title">
+-			{% if poll.S_CAN_VOTE %}<input type="{% if poll.S_IS_MULTI_CHOICE %}checkbox{% else %}radio{% endif %}" name="poll_vote_id[]" id="vote_{{ poll_option.POLL_OPTION_ID }}" value="{{ poll_option.POLL_OPTION_ID }}"{% if poll_option.POLL_OPTION_VOTED %} checked="checked"{% endif %} />{% endif %}
+-			{{ poll_option.POLL_OPTION_CAPTION }}
+-		</div>
+-
+-		{% if poll.S_DISPLAY_RESULTS %}
+-		<div class="poll-option-results">
+-			<div class="blg-progressbar" title="{{ poll_option.POLL_OPTION_PERCENT }}"><div style="width:{{ poll_option.POLL_OPTION_PERCENT }};"></div></div>
+-			<div class="poll-option-text">
+-				{% if poll_option.POLL_OPTION_VOTED %}<i class="fa fa-check-circle-o fa-lg" title="{{ lang('POLL_VOTED_OPTION') }}"></i>{% endif %}
+-				{{ poll_option.POLL_OPTION_PERCENT }}
+-			</div>
+-		</div>
+-		{% endif %}
+-	</div>
+-	{% endfor %}
+-
+-	<br />
+-	
+-	<ul class="blg-linear-list blg-align-center">
+-		{% if poll.S_CAN_VOTE %}<li><input type="submit" name="update_vote" value="{{ lang('SUBMIT_VOTE') }}" class="btn btn-default" /></li>{% endif %}
+-		{% if poll.S_DISPLAY_RESULTS %}<li>{{ lang('TOTAL_VOTES') ~ lang('COLON') }} {{ poll.S_TOTAL_VOTES }}</li>{% endif %}
+-          
+-		<li><a href="{{ poll.U_POLL_RESULTS }}">{{ lang('VIEW_TOPIC') }}</a></li>
+-	</ul>
+-
+-{% if poll.S_CAN_VOTE %}
+-	<div>{{ poll.S_HIDDEN_FIELDS }}</div>
+-</form>
+-{% endif %}
+-{% endfor %}
+-
+-{% else %}
+-<div class="blg-align-center">{{ lang('NO_POLL') }}</div>
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/recent_topics_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/recent_topics_block.html"
+deleted file mode 100644
+index 41d16d466..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/recent_topics_block.html"
++++ /dev/null
+@@ -1,137 +0,0 @@
+-
+-{% if SHOW_TABS %}
+-<script>
+-// <![CDATA[
+-	window._jPostponed = window._jPostponed || [];
+-	window._jPostponed.push(function() {
+-		$('#recent-{{ BLOCK_ID }}'){% if BLOCK_VIEW_SMALL %}.blgAccordion();{% else %}.cbbTabs();{% endif %}
+-	});
+-// ]]>
+-</script>
+-{% endif %}
+-
+-<div id="recent-{{ BLOCK_ID }}"{% if SHOW_TABS %} class="cbb-helper-hidden"{% endif %}>
+-
+-{% if BLOCK_VIEW_SMALL %}
+-	{% for tab in recent_tab %}
+-		<h5><a href="#">{{ tab.TITLE }}</a></h5>
+-		<div class="no-wrap">
+-			{% if tab.IS_EMPTY %}{{ lang('NO_ITEMS') }}{% endif %}
+-
+-			<ul class="blg-linear-list">
+-			{% for topicrow in tab.rows %}
+-				<li>
+-					{% EVENT topiclist_row_prepend %}
+-					<a class="cbb-helper-text cbb-inline" href="{{ topicrow.U_VIEW_TOPIC }}">{{ topicrow.TOPIC_TITLE }}</a>
+-					{% EVENT topiclist_row_append %}
+-				</li>
+-			{% endfor %}
+-			</ul>
+-		</div>
+-	{% endfor %}
+-
+-{% else %}
+-
+-{% if SHOW_TABS %}
+-    <ul>
+-	{% for tab in recent_tab %}
+-		<li><a href="#{{ tab.ID }}-{{ BLOCK_ID }}"><i class="fa {{ tab.ICON }} fa-lg"></i>{% if not BLOCK_VIEW_MEDIUM %} <span class="tab-title">{{ tab.TITLE }}</span>{% endif %}</a></li>
+-	{% endfor %}
+-    </ul>
+-{% endif %}
+-
+-    {% if TOPIC_DESIGN == 'simple' %}
+-		{% for tab in recent_tab %}
+-			<div class="blg-align-center recent-content block-postbody" id="{{ tab.ID }}-{{ BLOCK_ID }}">
+-
+-				<div class="blg-table">
+-				{% if tab.IS_EMPTY %}
+-					<div class="blg-align-center"><span>{{ lang('NO_ITEMS') }}</span></div>
+-				{% else %}
+-					<div>
+-						<div class="blg-column-topic-title blg-widget-header">{{ lang('TOPIC_TITLE') }}</div>
+-						<div class="blg-column-posted-by blg-widget-header">{{ lang('POSTED_BY') }}</div>
+-					{% if not BLOCK_VIEW_MEDIUM %}
+-						<div class="blg-column-comments blg-widget-header">{{ lang('COMMENTS') }}</div>
+-						<div class="blg-column-topic-views blg-widget-header">{{ lang('TOPIC_VIEWS') }}</div>
+-					{% endif %}
+-					</div>
+-					
+-					{% for topicrow in tab.rows %}
+-						<div>
+-							<div class="blg-column-topic-title blg-align-left">
+-								{% EVENT topiclist_row_prepend %}
+-								<a href="{{ topicrow.U_VIEW_TOPIC }}" class="cbb-helper-text cbb-inline" title="{{ topicrow.TOPIC_TITLE_RAW|e }}">{{ topicrow.TOPIC_TITLE }}</a>
+-							</div>
+-							<div class="blg-column-posted-by blg-align-center">{{ topicrow.TOPIC_AUTHOR_FULL }}</div>
+-						{% if not BLOCK_VIEW_MEDIUM %}
+-							<div class="blg-column-comments blg-align-center"><a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_COMMENTS') }}">{{ topicrow.REPLIES }}</a></div>
+-							<div class="blg-column-topic-views blg-align-center">{{ topicrow.VIEWS }}</div>
+-						{% endif %}
+-						</div>
+-					{% endfor %}
+-				{% endif %}
+-				</div>
+-			</div>
+-		{% endfor %}
+-	{% else %}
+-		{% for tab in recent_tab %}
+-			<div id="{{ tab.ID }}-{{ BLOCK_ID }}" class="blg-forum-list{% if SHOW_TABS %} cbb-helper-hidden{% endif %}{% if BLOCK_VIEW_MEDIUM %} title-only{% endif %}">
+-			{% if tab.IS_EMPTY %}
+-				<div class="blg-message">{{ lang('NO_ITEMS') }}</div>
+-			{% else %}
+-				<div class="blg-widget-header">
+-					{% if not BLOCK_VIEW_MEDIUM %}<div class="fb-lastpost-title">{{ lang('LAST_POST') }}</div>{% endif %}
+-					<span>{{ lang('TOPIC') }}</span>
+-				</div>
+-				<table class="footable table table-striped table-bordered table-white table-primary table-hover topics-table">
+-				</tbody>
+-
+-				{% for topicrow in tab.rows %}
+-					{% EVENT viewforum_body_topicrow_row_before %}
+-					<tr>
+-						<td>
+-							{% if topicrow.TOPIC_ICON_IMG %}
+-							<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+-							{% endif %}
+-
+-							<span class="icon-wrapper">
+-						    	<i class="row-icon-font icon-moon-default2{% if topicrow.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if topicrow.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if topicrow.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if topicrow.S_HAS_POLL %} icon-moon-poll{% endif %}{% if topicrow.S_TOPIC_MOVED %} icon-moon-moved{% endif %}{% if topicrow.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+-							</span>
+-
+-							<i class="row-icon-font-mini{% if topicrow.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+-							
+-							<div class="desc-wrapper">
+-					  			{% EVENT topiclist_row_prepend %}
+-								{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}
+-
+-								<br />{{ lang('POST_BY_AUTHOR') }}&nbsp;{{ topicrow.TOPIC_AUTHOR_FULL }} 
+-								<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
+-					 		 	{% EVENT topiclist_row_append %}	
+-							</div>
+-						</td>
+-
+-					{% if not BLOCK_VIEW_MEDIUM %}
+-						<td class="fb-stats blg-align-center">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
+-						<td class="lastpost">
+-							<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.LAST_POST_AUTHOR_FULL }}
+-							{% if not S_IS_BOT %}
+-								<a href="{{ topicrow.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">
+-									<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
+-								</a>
+-							{% endif %}
+-							<br /><i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
+-						</td>
+-					{% endif %}
+-					</tr>
+-					{% EVENT viewforum_body_topicrow_row_after %}
+-				{% endfor %}
+-
+-				</tbody>
+-				</table>
+-			{% endif %}
+-			</div>
+-		{% endfor %}
+-	{% endif %}
+-{% endif %}
+-</div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/search_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/search_block.html"
+deleted file mode 100644
+index 2113918bf..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/search_block.html"
++++ /dev/null
+@@ -1,71 +0,0 @@
+-<script>
+-// <![CDATA[
+-	window._jPostponed = window._jPostponed || [];
+-	window._jPostponed.push(function() {
+-		$('#block-{{ BLOCK_ID }} form').submit(function() {
+-			var searchUrls = {
+-				google		: 'https://www.google.com/search?q=',
+-				yahoo		: 'https://search.yahoo.com/search?p=',
+-				bing		: 'https://www.bing.com/search?q='
+-			};
+-
+-			var data = $(this).serializeObject();
+-
+-			if(!data.keywords || data.keywords == $(this).find('[name="keywords"]').attr('placeholder'))
+-			{
+-				return false;
+-			}
+-
+-			switch(data.engine)
+-			{
+-				case 'author':
+-					$(this).find('[name="keywords"]').attr('name', 'author');
+-
+-				case 'site':
+-					return true;
+-				break;
+-	
+-				case 'google':
+-				case 'yahoo':
+-				case 'bing':
+-					var url = searchUrls[data.engine];
+-
+-					if(url)
+-					{
+-						window.open(url + encodeURIComponent(data.keywords), '_' + data.engine, '');
+-					}
+-				break;
+-			}
+-
+-			return false;
+-		});
+-	});
+-// ]]>
+-</script>
+-
+-<form method="get" action="{{ U_SEARCH }}">
+-	<ul class="blg-linear-list blg-align-center">
+-		<li class="double-space"><input type="text" class="cbb-inputbox full-width" name="keywords" size="22" value="" placeholder="{{ lang('SEARCH_MINI') }}" /></li>
+-		<li class="double-space">
+-			<select name="engine" class="cbb-inputbox">
+-			{% if S_DISPLAY_SEARCH %}
+-				<optgroup label="{{ lang('FORUMS') }}">
+-					<option value="site">{{ lang('MESSAGES') }}</option>
+-					<option value="author">{{ lang('AUTHOR') }}</option>
+-				</optgroup>
+-			{% endif %}
+-				<optgroup label="{{ lang('SH_ENGINE') }}">
+-					<option value="google">Google</option>
+-					<option value="yahoo">Yahoo</option>
+-					<option value="bing">Bing</option>
+-				</optgroup>
+-			</select>
+-		</li>
+-
+-		<li class="double-space"><input class="btn btn-default" type="submit" value="{{ lang('SEARCH') }}" /></li>
+-
+-		{% if S_DISPLAY_SEARCH %}<li class="double-space top-bordered"><a href="{{ U_SEARCH }}" title="{{ lang('SEARCH_ADV_EXPLAIN') }}">{{ lang('SEARCH_ADV') }}</a></li>{% endif %}
+-	</ul>
+-	
+-	<div>{{ S_BLOCK_HIDDEN_FIELDS }}</div>
+-</form>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/style_select_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/style_select_block.html"
+deleted file mode 100644
+index 69d3926bb..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/style_select_block.html"
++++ /dev/null
+@@ -1,21 +0,0 @@
+-
+-<script>
+-// <![CDATA[
+-	window._jPostponed = window._jPostponed || [];
+-	window._jPostponed.push(function() {
+-		$('#block-{{ BLOCK_ID }} form').cbbAjaxify();
+-	});
+-// ]]>
+-</script>
+-
+-<form method="post" action="{{ U_BLG_ACTION }}">
+-	<ul class="blg-linear-list blg-align-center">
+-		<li class="double-space"><select name="style" class="cbb-inputbox">{{ STYLE_SELECT }}</select></li>
+-		{% if CAN_SAVE_STYLE %}<li class="doubl-space"><label><input type="checkbox" name="default" value="1" /> {{ lang('STYLE_SET_MINE') }}</label></li>{% endif %}
+-		<li class="double-space">
+-			<input type="submit" name="submit" class="btn btn-default" value="{{ lang('STYLE_CHANGE') }}" />
+-			{{ S_BLOCK_HIDDEN_FIELDS }}
+-		</li>
+-		{% if U_STYLE_DEFAULT %}<li class="double-space"><a href="{{ U_STYLE_DEFAULT }}">{{ lang('STYLE_DEFAULT') }}</a></li>{% endif %}
+-	</ul>
+-</form>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/top_topics_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/top_topics_block.html"
+deleted file mode 100644
+index ee2986586..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/top_topics_block.html"
++++ /dev/null
+@@ -1,87 +0,0 @@
+-
+-{% if BLOCK_VIEW_SMALL or TOPIC_DESIGN == 'simple' %}
+-{% for topicrow in top_topic %}
+-	{% if not topicrow.S_FIRST_ROW %}<hr />{% endif %}
+-	<div class="lunread-row">
+-		{% EVENT topiclist_row_prepend %}
+-		<a class="cbb-helper-text cbb-inline half-size" href="{{ topicrow.U_VIEW_TOPIC }}"><strong>{{ topicrow.TOPIC_TITLE }}</strong></a>
+-		{% if not BLOCK_VIEW_SMALL %}<span>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.TOPIC_AUTHOR_FULL }}</span>{% endif %}
+-		<span> &raquo; <em>{{ topicrow.FIRST_POST_TIME }}</em></span>
+-		{% EVENT topiclist_row_append %}
+-	</div>
+-{% else %}
+-	<div class="blg-align-center">{{ lang('NO_UNREAD') }}</div>
+-{% endfor %}
+-
+-{% else %}
+-
+-<div class="blg-forum-list{% if BLOCK_VIEW_MEDIUM %} title-only{% endif %}">
+-
+-	{% if BLOCK_STYLE == 'content_simple' %}
+-	<div class="panel panel-default">
+-	{% elseif top_topic|length %}
+-		<div class="blg-widget-header">
+-			{% if not BLOCK_VIEW_MEDIUM %}<div class="fb-lastpost-title">{{ lang('LAST_POST') }}</div>{% endif %}
+-			<span>{{ lang('TOPIC') }}</span>
+-		</div>
+-	{% endif %}
+-
+-		<table class="footable table table-striped table-bordered table-white table-primary table-hover topics-table">
+-	{% if BLOCK_STYLE == 'content_simple' %}
+-		<thead>
+-			<tr><th colspan="3">{{ BLOCK_TITLE }}</th></tr>
+-		</thead>
+-	{% endif %}
+-		<tbody>
+-
+-		{% for topicrow in top_topic %}
+-			{% EVENT viewforum_body_topicrow_row_before %}
+-			<tr>
+-				<td>
+-					{% if topicrow.TOPIC_ICON_IMG %}
+-					<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+-					{% endif %}
+-
+-					<span class="icon-wrapper">
+-				    	<i class="row-icon-font icon-moon-default2{% if topicrow.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if topicrow.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if topicrow.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if topicrow.S_HAS_POLL %} icon-moon-poll{% endif %}{% if topicrow.S_TOPIC_MOVED %} icon-moon-moved{% endif %}{% if topicrow.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+-					</span>
+-
+-					<i class="row-icon-font-mini{% if topicrow.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+-					
+-					<div class="desc-wrapper">
+-			  			{% EVENT topiclist_row_prepend %}
+-						{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}
+-
+-						<br />{{ lang('POST_BY_AUTHOR') }}&nbsp;{{ topicrow.TOPIC_AUTHOR_FULL }} 
+-						<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
+-			 		 	{% EVENT topiclist_row_append %}	
+-					</div>
+-				</td>
+-
+-			{% if not BLOCK_VIEW_MEDIUM %}
+-				<td class="fb-stats blg-align-center">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
+-				<td class="lastpost">
+-					<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.LAST_POST_AUTHOR_FULL }}
+-					{% if not S_IS_BOT %}
+-						<a href="{{ topicrow.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">
+-							<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
+-						</a>
+-					{% endif %}
+-					<br /><i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
+-				</td>
+-			{% endif %}
+-			</tr>
+-			{% EVENT viewforum_body_topicrow_row_after %}
+-		{% else %}
+-			<tr><td colspan="3" class="blg-message">{{ lang('NO_UNREAD') }}</td></tr>
+-		{% endfor %}
+-		</tbody>
+-		</table>
+-
+-	{% if BLOCK_STYLE == 'content_simple' %}
+-	</div>
+-	{% endif %}
+-
+-</div>
+-
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/topic_index_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/topic_index_block.html"
+deleted file mode 100644
+index 0afbd0292..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/topic_index_block.html"
++++ /dev/null
+@@ -1,152 +0,0 @@
+-
+-<div id="topic-index-{{ BLOCK_ID }}">
+-
+-<script>
+-// <![CDATA[
+-	window._jPostponed = window._jPostponed || [];
+-	window._jPostponed.push(function() {
+-		$('#topic-index-{{ BLOCK_ID }}').cbbLoader({
+-			paginationSelector: '.pagination a, .char-select a',
+-			replace: true,
+-			requestData: {
+-				jblgm: '{{ BLOCK_ID }}',
+-				fchar: '{{ S_FIRST_CHAR }}'
+-			}
+-		});
+-	});
+-// ]]>
+-</script>
+-
+-{% if S_CHAR_SELECT %}
+-	<div class="char-select blg-align-center">
+-	{% for char in first_char %}
+-		{% if char.S_SELECTED %}<span>{{ char.DESC }}</span>{% else %}<a href="#?fchar={{ char.VALUE }}">{{ char.DESC }}</a>{% endif %}&nbsp; 
+-	{% endfor %}
+-	</div>
+-{% endif %}
+-
+-{% if BLOCK_VIEW_SMALL or TOPIC_DESIGN == 'simple' %}
+-	<div class="topic-index-content block-postbody blg-align-center blg-corner-all">
+-
+-	<div{% if not BLOCK_VIEW_SMALL and not BLOCK_VIEW_MEDIUM %} class="blg-table"{% endif %}>
+-		<div>
+-			<div class="blg-column-topic-title blg-widget-header">{{ lang('TOPIC_TITLE') }}</div>
+-		{% if not BLOCK_VIEW_SMALL and not BLOCK_VIEW_MEDIUM %}
+-			<div class="blg-column-posted-by blg-widget-header">{{ lang('POSTED_BY') }}</div>
+-			<div class="blg-column-comments blg-widget-header">{{ lang('COMMENTS') }}</div>
+-			<div class="blg-column-topic-views blg-widget-header">{{ lang('TOPIC_VIEWS') }}</div>
+-		{% endif %}
+-		</div>
+-		
+-	{% for topicrow in topic %}
+-		<div>
+-			<div class="blg-column-topic-title blg-align-left">
+-				{% EVENT topiclist_row_prepend %}
+-				<a href="{{ topicrow.U_VIEW_TOPIC }}" class="cbb-helper-text cbb-inline" title="{{ topicrow.TOPIC_TITLE_RAW|e }}">{{ topicrow.TOPIC_TITLE }}</a>
+-			</div>
+-		{% if not BLOCK_VIEW_SMALL and not BLOCK_VIEW_MEDIUM %}
+-			<div class="blg-column-posted-by blg-align-center">{{ topicrow.TOPIC_AUTHOR_FULL }}</div>
+-			<div class="blg-column-comments blg-align-center"><a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_COMMENTS') }}">{{ topicrow.REPLIES }}</a></div>
+-			<div class="blg-column-topic-views blg-align-center">{{ topicrow.VIEWS }}</div>
+-		{% endif %}
+-		</div>
+-	{% else %}
+-		<div><div class="blg-align-center" colspan="4">{{ lang('NO_TOPICS') }}</div></div>
+-	{% endfor %}
+-
+-	</div>
+-	</div>
+-
+-{% else %}
+-
+-<div class="blg-forum-list{% if BLOCK_VIEW_MEDIUM %} title-only{% endif %}">
+-
+-	{% if BLOCK_STYLE == 'content_simple' %}
+-	<div class="panel panel-default">
+-	{% elseif topic|length %}
+-		<div class="blg-widget-header">
+-			{% if not BLOCK_VIEW_MEDIUM %}<div class="fb-lastpost-title">{{ lang('LAST_POST') }}</div>{% endif %}
+-			<span>{{ lang('TOPIC') }}</span>
+-		</div>
+-	{% endif %}
+-
+-		<table class="footable table table-striped table-bordered table-white table-primary table-hover topics-table">
+-	{% if BLOCK_STYLE == 'content_simple' %}
+-		<thead>
+-			<tr><th colspan="3">{{ BLOCK_TITLE }}</th></tr>
+-		</thead>
+-	{% endif %}
+-		<tbody>
+-
+-		{% for topicrow in topic %}
+-			{% EVENT viewforum_body_topicrow_row_before %}
+-			<tr>
+-				<td>
+-					{% if topicrow.TOPIC_ICON_IMG %}
+-					<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+-					{% endif %}
+-
+-					<span class="icon-wrapper">
+-				    	<i class="row-icon-font icon-moon-default2{% if topicrow.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if topicrow.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if topicrow.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if topicrow.S_HAS_POLL %} icon-moon-poll{% endif %}{% if topicrow.S_TOPIC_MOVED %} icon-moon-moved{% endif %}{% if topicrow.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+-					</span>
+-
+-					<i class="row-icon-font-mini{% if topicrow.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+-					
+-					<div class="desc-wrapper">
+-			  			{% EVENT topiclist_row_prepend %}
+-						{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}
+-
+-						<br />{{ lang('POST_BY_AUTHOR') }}&nbsp;{{ topicrow.TOPIC_AUTHOR_FULL }} 
+-						<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
+-			 		 	{% EVENT topiclist_row_append %}	
+-					</div>
+-				</td>
+-
+-			{% if not BLOCK_VIEW_MEDIUM %}
+-				<td class="fb-stats blg-align-center">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
+-				<td class="lastpost">
+-					<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.LAST_POST_AUTHOR_FULL }}
+-					{% if not S_IS_BOT %}
+-						<a href="{{ topicrow.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">
+-							<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
+-						</a>
+-					{% endif %}
+-					<br /><i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
+-				</td>
+-			{% endif %}
+-			</tr>
+-			{% EVENT viewforum_body_topicrow_row_after %}
+-		{% endfor %}
+-		</tbody>
+-		</table>
+-
+-	{% if BLOCK_STYLE == 'content_simple' %}
+-	</div>
+-	{% endif %}
+-
+-</div>
+-
+-{% endif %}
+-
+-{% if block_pagination|length %}
+-	<div class="pull-right">	 
+-		<ul class="pagination pagination-forum {% if BLOCK_VIEW_SMALL %}pagination-xs{% else %}pagination-sm{% endif %} hidden-xs">
+-		{% for pagination in block_pagination %}
+-			{% if pagination.S_IS_PREV %}
+-			<li class="previous"><a href="{{ pagination.PAGE_URL }}" rel="prev" role="button">{{ lang('PREVIOUS') }}</a></li>
+-			{% elseif pagination.S_IS_CURRENT %}
+-			<li class="active"><span>{{ pagination.PAGE_NUMBER }}</span></li>
+-			{% elseif pagination.S_IS_ELLIPSIS %}
+-			<li class="ellipsis" role="separator"><span>{{ lang('ELLIPSIS') }}</span></li>
+-			{% elseif pagination.S_IS_NEXT %}
+-			<li class="next"><a href="{{ pagination.PAGE_URL }}" rel="next" role="button">{{ lang('NEXT') }}</a></li>
+-			{% else %}
+-			<li><a href="{{ pagination.PAGE_URL }}" role="button">{{ pagination.PAGE_NUMBER }}</a></li>
+-			{% endif %}
+-		{% endfor %}
+-		</ul>
+-	</div>
+-	<div class="cbb-helper-clear"></div>
+-{% endif %}
+-
+-</div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/calendar_body.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/calendar_body.html"
+deleted file mode 100644
+index 711283ca5..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/calendar_body.html"
++++ /dev/null
+@@ -1,116 +0,0 @@
+-{% if IN_EVENT %}
+-
+-<div title="{{ S_EVENT_TITLE }}">
+-	<form>
+-	<div class="cbb-dialog-content">{{ S_EVENT_CONTENT }}</div>
+-
+-{% if CAN_MANAGE_EVENT %}
+-	<div class="cbb-dialog-buttons">
+-		<button class="btn btn-default" value="submit" data-action="edit">{{ lang('EDIT') }}</button>
+-		<button class="btn btn-default" value="submit" data-action="delete">{{ lang('DELETE') }}</button>
+-		
+-		{{ S_HIDDEN_FIELDS }}
+-	</div>
+-{% endif %}
+-	</form>
+-</div>
+-
+-{% elseif IN_BIRTHDAY_LIST %}
+-
+-<div title="{{ lang('BIRTHDAYS') }}">
+-	<div class="cbb-dialog-content">
+-		<ul class="blg-linear-list blg-birthday-list">
+-		{% for user in loops.user %}
+-			<li class="double-space">
+-				<div class="cbb-circular-avatar size-small">{% if user.AVATAR %}{{ user.AVATAR }}{% else %}<span class="cbb-no-avatar"></span>{% endif %}</div>
+-				{{ user.USERNAME_FULL }}
+-				<span>({{ user.AGE }})</span>
+-			</li>
+-		{% endfor %}
+-		</ul>
+-	</div>
+-</div>
+-
+-{% else %}
+-
+-{% INCLUDE 'overall_header.html' %}
+-<div class="side-segment">
+-	<h3>{{ lang('CALENDAR') }}</h3>
+-</div>
+-
+-{% for calendar in loops.calendar %}
+-	<div class="blg-calendar-actionbar">
+-		<div class="calendar-printer blg-align-right floated">
+-			<a href="#" data-action="print" class="btn btn-default"><i class="fa fa-print" aria-hidden="true"></i> <span>{{ lang('PRINT') }}</span></a>
+-		</div>
+-
+-		<a href="{{ U_TODAY }}" class="btn btn-default" data-rel="today">{{ lang('TODAY') }}</a>
+-
+-		<div class="btn-group">
+-			<a href="{{ U_PREV }}" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
+-			<a href="#" class="btn btn-default" data-action="month-select">{{ calendar.S_MONTH }}</a>
+-			<a href="{{ U_NEXT }}" class="btn btn-default"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
+-		</div>
+-	</div>
+-	<div class="panel panel-poll">
+-		<div class="panel-body">
+-			<table class="blg-calendar">
+-			<tr>
+-			{% for day in calendar.days %}
+-
+-				{% if day.NEW_LINE and not day.S_FIRST_ROW %}</tr><tr>{% endif %}
+-
+-				{% if day.IS_HEADER %}
+-					<th><span class="short-day text-capitalize">{{ day.S_DAY_SHORT }}</span><span class="full-day text-capitalize">{{ day.S_DAY }}</span></th>
+-				{% elseif day.S_DAY %}
+-					<td id="day-{{ day.S_DATA }}" data-time="{{ day.S_DATA }}" class="blg-calendar-day{% if day.IS_TODAY %} today{% endif %}">
+-						<div class="blg-day-title">
+-							{% if S_CAN_CREATE_EVENT %}<a href="#" class="blg-event-add blg-align-right floated" title="{{ lang('ADD_EVENT') }}" data-time="{{ day.S_DATA }}"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>{% endif %}
+-							<span>{{ day.S_DAY }}</span>
+-						</div>
+-					
+-						<div class="blg-day-content">
+-						{% for event in day.event %}
+-							<div {{ event.S_ATTR }}>
+-								{% if event.S_TYPE == 'birthday' %}<i class="fa fa-birthday-cake" aria-hidden="true"></i> {% endif %}
+-								{{ event.S_TITLE }}
+-							</div>
+-						{% endfor %}
+-						</div>
+-					</td>
+-				{% else %}
+-					<td>&nbsp;</td>
+-				{% endif %}
+-			{% endfor %}
+-			</tr>
+-			</table>
+-		</div>
+-	</div>
+-{% endfor %}
+-
+-<div id="month-selector" class="cbb-helper-hidden" title="{{ lang('CALENDAR_SELECT_DATE') }}">
+-	<form>
+-		<div class="cbb-dialog-content blg-align-center">
+-			<div class="cbb-group">
+-				<select class="cbb-inputbox" name="month">{{ S_MONTH_OPTIONS }}</select>
+-				<input type="text" class="cbb-inputbox" name="year" value="" size="10" />
+-			</div>
+-		</div>
+-		<div class="cbb-dialog-buttons">
+-			<button class="btn btn-default" value="submit">{{ lang('GO') }}</button>
+-		</div>
+-	</form>
+-</div>
+-
+-<script>
+-// <![CDATA[
+-	window._jPostponed = window._jPostponed || [];
+-	window._jPostponed.push(function() {
+-		$('.blg-calendar').blgCalendar();
+-	});
+-// ]]>
+-</script>
+-
+-{% INCLUDE 'overall_footer.html' %}
+-
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_body_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_body_after.html"
+deleted file mode 100644
+index 9331334cf..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_body_after.html"
++++ /dev/null
+@@ -1,30 +0,0 @@
+-{% if BLG_ENABLED or BLG_ADMIN_BAR %}
+-
+-	{% if BLG_ADMIN_BAR %}
+-		<div class="blg-admin-bar">
+-			<ul class="blg-align-left floated">
+-				<li><a href="{{ U_BLG_MANAGE_BLOCKS }}" class="cbb-btn"><i class="fa fa-th-large" aria-hidden="true"></i> <span class="btn-title">{{ lang('MANAGE_BLOCKS') }}</span></a></li>
+-				<li><a href="{{ U_BLG_PAGE_EDIT }}" class="cbb-btn"><i class="fa fa-cog" aria-hidden="true"></i> <span class="btn-title">{{ lang('EDIT_CONFIGURATION') }}</span></a></li>
+-			</ul>
+-			
+-			<ul class="blg-align-right floated">
+-				<li><a href="{{ U_BLG_PAGE_ADD }}" class="cbb-btn"><i class="fa fa-plus-circle" aria-hidden="true"></i> <span class="btn-title">{{ lang('ADD_PAGE') }}</span></a></li>
+-			</ul>
+-
+-			<a href="#" class="blg-admin-opener" title="{{ lang('EDIT_THIS_PAGE') }}"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a>
+-		</div>
+-	{% endif %}
+-
+-	<script>
+-	// <![CDATA[
+-	head.ready(['cbbcore.min.js', 'jblockgets.min.js'], function () {
+-		cbbCore.initService('blockgets', $.extend({{ S_BLG_OPTIONS }}, {
+-			blockHeader: '.block-title',
+-			avatarContainer: '.avatar-frame',
+-			postContainer: '.postbody'
+-		}));
+-	});
+-	// ]]>
+-	</script>
+-	
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_teamlink_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_teamlink_after.html"
+deleted file mode 100644
+index a55ccf2b4..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_teamlink_after.html"
++++ /dev/null
+@@ -1,6 +0,0 @@
+-
+-{% for link in loops.blglink_bottom %}
+-	<li>
+-		<a href="{{ link.HREF }}">{{ link.ICON }} {{ link.TITLE }}</a>
+-	</li>
+-{% endfor %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_header_head_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_header_head_append.html"
+deleted file mode 100644
+index 8977f1bc6..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_header_head_append.html"
++++ /dev/null
+@@ -1,14 +0,0 @@
+-{% if (BLG_ENABLED or BLG_ADMIN_BAR) and CANIDEV_CORE_STARTED %}
+-	{% include '@canidev_core/event/overall_header_head_append.html' %}
+-	{% INCLUDECSS '@canidev_blockgets/bboots.css' %}
+-	
+-	{% if BLG_ENABLED %}
+-		<style>
+-		.blg-center-area 					{ grid-template-columns: {{ LEFT_COLUMN_WIDTH }} 1fr {{ RIGHT_COLUMN_WIDTH }}; }
+-		.blg-block, .blg-area, .blg-grid 	{ margin-bottom: {{ BLG_BLOCK_SPACE }}; }
+-		.blg-grid, .blg-center-area 		{ gap: {{ BLG_BLOCK_SPACE }}; }
+-
+-		{% if BLG_LOGO %}.site_logo, .imageset.site_logo { background-image: url('{{ BLG_LOGO }}'); }{% endif %}
+-		</style>
+-	{% endif %}
+-{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_header_navigation_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_header_navigation_append.html"
+deleted file mode 100644
+index 1e746526b..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_header_navigation_append.html"
++++ /dev/null
+@@ -1,8 +0,0 @@
+-
+-{% for link in loops.blglink_top %}
+-	<li><a href="{{ link.HREF }}">{{ link.ICON }} {{ link.TITLE }}</a><span></span></li>
+-{% endfor %}
+-
+-{% for link in loops.blglink_quick %}
+-	<li><a href="{{ link.HREF }}">{{ link.ICON }} {{ link.TITLE }}</a><span></span></li>
+-{% endfor %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/simple_footer_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/simple_footer_after.html"
+deleted file mode 100644
+index 16f58efdc..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/simple_footer_after.html"
++++ /dev/null
+@@ -1,15 +0,0 @@
+-{% if S_IN_PLAYER and CANIDEV_CORE_STARTED %}
+-	{% include '@canidev_core/event/overall_footer_after.html' %}
+-	
+-	<script>
+-	// <![CDATA[
+-	head.ready(['cbbcore.min.js', 'jblockgets.min.js'], function() {
+-		cbbCore.initService('blockgets', $.extend({{ S_BLG_OPTIONS }}, {
+-			blockHeader: '.block-title',
+-			avatarContainer: '.avatar-frame',
+-			postContainer: '.postbody'
+-		}));
+-	});
+-	// ]]>
+-	</script>
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/theme/bboots.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/theme/bboots.css"
+deleted file mode 100644
+index 2a9476fa8..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/theme/bboots.css"
++++ /dev/null
+@@ -1,69 +0,0 @@
+-/**
+- * cBB Blockgets (BBOOTS stylesheet)
+- * Copyright (c) 2023, CaniDev
+- * license https://creativecommons.org/licenses/by-nc/4.0/
+- */
+-
+- .blg-block.style-alternative .block-title,
+-.blg-block.style-content_full table,
+-.blg-block.style-content_full table tr,
+-.blg-block.style-content_full table td {
+-	background: none !important;
+-	border: none !important;
+-	box-shadow: none;
+-}
+-
+-.blg-block.style-alternative .block-title {
+-	padding: 8px !important;
+-}
+-
+-.blg-block.style-content_full .block-title {
+-	border-width: 0 0 1px 0;
+-}
+-
+-.blg-block.style-alternative .block-title,
+-.blg-block.style-alternative .block-title i,
+-.blg-block.style-content_full .block-title,
+-.blg-block.style-content_full .block-title i {
+-	color: #808080 !important;
+-}
+-
+-.blg-block.style-alternative .block-content {
+-	border: none !important;
+-	padding: 0 !important;
+-}
+-
+-.fb-lastpost-title {
+-	width: 150px !important;
+-}
+-
+-.blg-menu,
+-.blg-menu .fa,
+-.blg-message {
+-    font-size: 1em !important;
+-}
+-
+-.blg-admin-bar,
+-a.blg-admin-opener {
+-	box-sizing: content-box;
+-}
+-
+-/* Contact Block
+--------------------------- */
+-.contact-table {
+-	border-spacing: 8px !important;
+-}
+-
+-.contact-table.short-view .cbb-inputbox {
+-	max-width: 155px;
+-}
+-
+-/* Login Block
+--------------------------- */
+-.blg-block .oauth-content {
+-	margin-top: 15px;
+-}
+-
+-.blg-block .oauth-content h3 {
+-	font-size: 18px;
+-}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/theme/calendar_print.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/theme/calendar_print.css"
+deleted file mode 100644
+index f6a9a88ca..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/theme/calendar_print.css"
++++ /dev/null
+@@ -1,75 +0,0 @@
+-/**
+- * cBB Blockgets (Calendar Print stylesheet)
+- * Copyright (c) 2022, CaniDev
+- * license https://creativecommons.org/licenses/by-nc/4.0/
+- */
+- 
+-html	{ height: 100%; }
+-body	{ padding: 0; }
+-
+-header,
+-.header,
+-.flat-header,
+-section.section-page,
+-footer,
+-.section-pre-footer,
+-.mastbottom,
+-.breadcrumb-line,
+-.social-top,
+-.subheader,
+-.crumbs,
+-.sub-breadcrumb,
+-.copyright {
+-	display: none !important;
+-}
+-
+-#wrap {
+-	border: none;
+-	border-radius: 0;
+-    max-width: none;
+-    min-width: 0;
+-	padding: 0 15px;
+-}
+-
+-#page-body, .blg-area {
+-    margin: 0;
+-}
+-
+-.blg-calendar-actionbar {
+-	float: right;
+-	margin: 2em 0 0 0;
+-}
+-
+-.blg-calendar-actionbar .btn-group,
+-.blg-calendar-actionbar .btn {
+-	display: none;
+-}
+-
+-#blg-column-center h2 {
+-	float: left;
+-}
+-
+-.blg-calendar:before {
+-    content: "";
+-    display: block;
+-    clear: both;
+-    margin-bottom: 20px;
+-}
+-
+-.blg-calendar td.today {
+-	background: none;
+-}
+-
+-.blg-calendar td.today .blg-calendar-day,
+-.blg-calendar td.today .blg-calendar-content {
+-    border: inherit;
+-}
+-
+-.blg-calendar td.today .blg-calendar-day		{
+-	border-bottom: none;
+-	font-weight: normal;
+-}
+-
+-.blg-calendar td.today .blg-calendar-content {
+-	border-top: none;
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/login_block.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/login_block.html"
+index aa9a013b3..492882faf 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/login_block.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/login_block.html"
+@@ -13,13 +13,13 @@
+ 	<li class="menu-cat">{{ USERNAME_FULL }}</li>
+ 	<li class="double-space">
+ 		<a href="{{ U_PROFILE }}">
+-			<span class="cbb-circular-avatar">{% if USER_AVATAR %}{{ USER_AVATAR }} {% else %}<span class="cbb-no-avatar"></span>{% endif %}</span>
++			<span class="cbb-avatar">{% if USER_AVATAR %}{{ USER_AVATAR }} {% else %}<span class="cbb-no-avatar"></span>{% endif %}</span>
+ 		</a>
+ 	</li>
+ 
+ 	{% if USER_RANK_IMG %}<li>{{ USER_RANK_TITLE }}<br />{{ USER_RANK_IMG }}</li>{% endif %}
+ 	{% if S_LAST_VISIT %}<li class="double-space">{{ S_LAST_VISIT }}</li>{% endif %}
+-	{% if S_CURRENT_TIME %}<li class="double-space">{{ S_CURRENT_TIME }}</li>{% endif %}
++	<!-- {% if S_CURRENT_TIME %}<li class="double-space">{{ S_CURRENT_TIME }}</li>{% endif %} -->
+ 	
+ 	{{ S_BLG_LOGIN_FIELDS }}
+ </ul>
+@@ -28,7 +28,7 @@
+ 
+ <ul class="blg-menu blg-linear-list">
+ {% for link in userlink %}
+-	<li>
++	<li class="btn btn-default">
+ 		<i class="icon fa {% if link.ICON %}{{ link.ICON }}{% else %}fa-chevron-right{% endif %} fa-fw" aria-hidden="true"></i>
+ 		<a href="{{ link.URL }}">{{ link.TITLE }}</a>
+ 	</li>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/news_block.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/news_block.html"
+index 8d70807ba..97b84ea7f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/news_block.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/news_block.html"
+@@ -27,19 +27,28 @@
+ {% if news_row|length %}
+ 
+ {% if not S_NEWS_FULL_CONTENT and not S_NEWS_COLLAPSE %}
+-
+-	<ul class="blg-linear-list">
++	<div class="blg-widget-header">
++		<span>{{ lang('TOPIC') }}</span>
++	</div>
++	<ul class="blg-linear-list news-block">
+ 	{% for topicrow in news_row %}
+ 		<li class="double-space">
+-			<div>
+-				<i class="fa fa-bullhorn fa-lg" aria-hidden="true"></i>
+-				{% EVENT topiclist_row_prepend %}
+-				<a href="{{ topicrow.U_VIEW_TOPIC }}"><strong>{{ topicrow.TOPIC_TITLE }}</strong></a>
+-			</div>
+-			<div>
+-				{{ lang('POSTED_BY') ~ lang('COLON') }}
+-				<strong>{{ topicrow.TOPIC_AUTHOR_FULL }}</strong>
+-				{% if BLOCK_VIEW_SMALL %}<br />{% else %}&bull;{% endif %} {{ topicrow.FIRST_POST_TIME }}
++			<div class="desc-wrapper">
++				<div>
++					{% EVENT topiclist_row_prepend %}
++					<a href="{{ topicrow.U_VIEW_TOPIC }}"><strong>{{ topicrow.TOPIC_TITLE }}</strong></a>
++					{% EVENT topiclist_row_append_portal %}
++				</div>
++				<div>
++					{{ lang('POSTED_BY') ~ lang('COLON') }}
++					<strong>{{ topicrow.TOPIC_AUTHOR_FULL }}</strong>
++					{% if BLOCK_VIEW_SMALL %}<br />{% else %}&bull;{% endif %} {{ topicrow.FIRST_POST_TIME }}
++				</div>
++				<div>
++						{L_LAST_REPLIED_BY}{L_COLON}
++						<strong>{{ topicrow.LAST_POST_AUTHOR_FULL }}</strong>
++						{% if BLOCK_VIEW_SMALL %}<br />{% else %}&bull;{% endif %} <span>{{ topicrow.LAST_POST_TIME }}</span>
++				</div>
+ 			</div>
+ 		</li>
+ 	{% endfor %}
+@@ -123,7 +132,7 @@
+ 
+ {% if block_pagination|length %}
+ 	<div class="pull-right">	 
+-		<ul class="pagination pagination-forum {% if BLOCK_VIEW_SMALL %}pagination-xs{% else %}pagination-sm{% endif %} hidden-xs">
++		<ul class="pagination pagination-forum {% if BLOCK_VIEW_SMALL %}pagination-xs{% else %}pagination-sm{% endif %}">
+ 		{% for pagination in block_pagination %}
+ 			{% if pagination.S_IS_PREV %}
+ 			<li class="previous"><a href="{{ pagination.PAGE_URL }}" rel="prev" role="button">{{ lang('PREVIOUS') }}</a></li>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/recent_topics_block.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/recent_topics_block.html"
+index 41d16d466..58e6b7dbf 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/recent_topics_block.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/recent_topics_block.html"
+@@ -91,36 +91,62 @@
+ 					{% EVENT viewforum_body_topicrow_row_before %}
+ 					<tr>
+ 						<td>
+-							{% if topicrow.TOPIC_ICON_IMG %}
+-							<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+-							{% endif %}
+-
+ 							<span class="icon-wrapper">
+ 						    	<i class="row-icon-font icon-moon-default2{% if topicrow.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if topicrow.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if topicrow.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if topicrow.S_HAS_POLL %} icon-moon-poll{% endif %}{% if topicrow.S_TOPIC_MOVED %} icon-moon-moved{% endif %}{% if topicrow.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+ 							</span>
+ 
+ 							<i class="row-icon-font-mini{% if topicrow.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+-							
+-							<div class="desc-wrapper">
+-					  			{% EVENT topiclist_row_prepend %}
++
++							<div class="desc-wrapper hidden-xs" style="padding:0">
++								{% if topicrow.TOPIC_ICON_IMG %}
++									<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
++								{% endif %}
++					  		{% EVENT topiclist_row_prepend %}
+ 								{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}
+ 
+ 								<br />{{ lang('POST_BY_AUTHOR') }}&nbsp;{{ topicrow.TOPIC_AUTHOR_FULL }} 
+ 								<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
+ 					 		 	{% EVENT topiclist_row_append %}	
+ 							</div>
++							<div class="desc-wrapper visible-xs" style="padding:0">
++								{% if topicrow.TOPIC_ICON_IMG %}
++								<i class="topic-icon" style="margin:-8px;background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
++								{% endif %}
++					  			{% EVENT topiclist_row_prepend %}
++								<div>{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}</div>
++								{% if not S_IS_BOT %}
++									<a href="{{ topicrow.U_LAST_POST }}" title="{L_GOTO_LAST_POST}">
++										<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
++									</a>
++								{% endif %}
++								{{ lang('POST_BY_AUTHOR') }}&nbsp;{{ topicrow.TOPIC_AUTHOR_FULL }} 
++								<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
++							</div>
++							{% if not BLOCK_VIEW_MEDIUM %}
++								<div class="lastpost visible-xs">
++									<div class="nowrap-mobile">
++										<span>
++											<i class="fa fa-user"></i>&nbsp;<small>{{ topicrow.LAST_POST_AUTHOR_FULL }}</small>
++											<i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
++										</span>
++										
++									</div>
++								</div>
++							{% endif %}
+ 						</td>
+ 
+ 					{% if not BLOCK_VIEW_MEDIUM %}
+-						<td class="fb-stats blg-align-center">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
+-						<td class="lastpost">
+-							<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.LAST_POST_AUTHOR_FULL }}
+-							{% if not S_IS_BOT %}
+-								<a href="{{ topicrow.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">
+-									<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
+-								</a>
+-							{% endif %}
+-							<br /><i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
++						<td class="fb-stats blg-align-center hidden-xs">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
++						<td class="lastpost hidden-xs">
++							<span>
++								<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.LAST_POST_AUTHOR_FULL }}
++								{% if not S_IS_BOT %}
++									<a href="{{ topicrow.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">
++										<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
++									</a>
++								{% endif %}
++								<br /><i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
++							</span>
+ 						</td>
+ 					{% endif %}
+ 					</tr>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/calendar_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/calendar_body.html"
+index 711283ca5..7585c12aa 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/calendar_body.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/calendar_body.html"
+@@ -48,7 +48,7 @@
+ 
+ 		<div class="btn-group">
+ 			<a href="{{ U_PREV }}" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
+-			<a href="#" class="btn btn-default" data-action="month-select">{{ calendar.S_MONTH }}</a>
++			<a href="#" class="btn btn-default text-capitalize" data-action="month-select">{{ calendar.S_MONTH }}</a>
+ 			<a href="{{ U_NEXT }}" class="btn btn-default"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
+ 		</div>
+ 	</div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
+index 4042d6ac0..9a6473bbf 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
+@@ -1 +1 @@
+-{% if U_SITE_HOME %}<li class="blg-breadcrumb-fix"></li>{% endif %}
+\ No newline at end of file
++{% if U_SITE_HOME and SCRIPT_NAME == "portal" %}<li class="blg-breadcrumb-fix"></li>{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/theme/flatboots.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/theme/flatboots.css"
+index e0898b867..f211d2d5d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/theme/flatboots.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/theme/flatboots.css"
+@@ -95,4 +95,18 @@ a.blg-admin-opener {
+ .blg-block .oauth-list-btns {
+ 	margin-bottom: 0;
+ 	margin-left: 0;
+-}
+\ No newline at end of file
++}
++/* News Block
++-------------------------- */
++.blg-linear-list.news-block li.double-space {
++	display:flex;
++	margin:0!important;
++	border: 1px solid #e4e9eb;
++}
++.blg-linear-list.news-block li .desc-wrapper {
++	padding:10px 8px;
++	width: -webkit-fill-available;
++}
++.blg-linear-list.news-block li:first-child {
++	border-top: 4px solid #e4e9eb;
++}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/all/template/blocks/calendar_block.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/all/template/blocks/calendar_block.html"
+index b925ccd23..60266bf80 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/all/template/blocks/calendar_block.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/all/template/blocks/calendar_block.html"
+@@ -44,7 +44,7 @@
+ 			<thead>
+ 			<tr>
+ 				<td class="blg-align-left">{% if calendar.S_FIRST_ROW %}<a href="#" data-calendar="{{ BLOCK_ID }}-{{ calendar.S_ROW_COUNT }}" data-action="prev"><i class="fa fa-arrow-circle-left fa-lg" aria-hidden="true"></i></a>{% else %}&nbsp;{% endif %}</td>
+-				<td colspan="5" class="month-title blg-align-center"><a href="{{ calendar.U_ACTION }}">{{ calendar.S_MONTH }}</a></td>
++				<td colspan="5" class="month-title text-capitalize blg-align-center"><a href="{{ calendar.U_ACTION }}">{{ calendar.S_MONTH }}</a></td>
+ 				<td class="blg-align-right">{% if calendar.S_LAST_ROW %}<a href="#" data-calendar="{{ BLOCK_ID }}-{{ calendar.S_ROW_COUNT }}" data-action="next"><i class="fa fa-arrow-circle-right fa-lg" aria-hidden="true"></i></a>{% else %}&nbsp;{% endif %}</td>
+ 			</tr>
+ 			</thead>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/all/template/blocks/gallery_block.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/all/template/blocks/gallery_block.html"
+index 403aeca50..932123c14 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/all/template/blocks/gallery_block.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/all/template/blocks/gallery_block.html"
+@@ -51,7 +51,12 @@
+ 
+ <div class="gallery">
+ {% for image in loops.image %}
+-	<a href="{{ image.ACTION }}" title="{{ image.TITLE }}" class="blank"><img src="{{ image.SRC }}" alt="{{ image.TITLE }}" /></a>
++	<a href="{{ image.ACTION }}" title="{% for prefix in image.prefix %}{{ prefix.NAME }}&nbsp;{% endfor %}{{ image.TITLE }}" class="blank ribbon-holder">
++		<img src="{{ image.SRC }}" alt="" />
++		<span class="ribbon ribbon-holder">
++			{% for prefix in image.prefix %}&nbsp;&nbsp;{{ prefix.NAME }}&nbsp;{% endfor %}
++		</span>
++	</a>
+ {% endfor %}
+ </div>
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/all/theme/common.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/all/theme/common.css"
+index 7368f694f..4dbe92aa0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/all/theme/common.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/all/theme/common.css"
+@@ -1767,10 +1767,10 @@ label.blg-share-button {
+ 	color: #7b95f2;
+ }
+ 
+-.medium-dark-theme .blg-block,
+-.medium-dark-theme .blg-block a {
+-	color: #000;
+-}
++/* .medium-dark-theme .blg-block, */
++/* .medium-dark-theme .blg-block a { */
++	/* color: #000; */
++/* } */
+ 
+ .medium-dark-theme .blg-block.style-alternative li.header dt,
+ .medium-dark-theme .blg-block.style-alternative li.header a,
diff --git "[FORUM_EXT]/canidev\\blockgets/diff_nospace.tmp" "[FORUM_EXT]/canidev\\blockgets/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/diff_nospace.tmp"
@@ -0,0 +1,4878 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/gallery_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/gallery_block.php"
+index cc4b732d7..ca008eeec 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/gallery_block.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/gallery_block.php"
+@@ -236,7 +236,7 @@ class gallery_block extends base
+ 					'WHERE'			=> 'p.post_visibility = ' . ITEM_APPROVED . '
+ 						AND (' . implode(' OR ', $sql_where) . ")
+ 						AND p.bbcode_uid NOT LIKE ''
+-						AND p.post_text " . $this->db->sql_like_expression($this->db->get_any_char() . '[img]' . $this->db->get_any_char()),
++						AND p.post_text " . $this->db->sql_like_expression($this->db->get_any_char() . '[album]' . $this->db->get_any_char()),
+ 					'ORDER_BY'		=> ($data['image_order'] == 'last') ? 'p.post_time DESC' : $random_key,
+ 				];
+ 
+@@ -253,9 +253,41 @@ class gallery_block extends base
+ 				$result = $this->db->sql_query_limit($sql, $data['max_number']);
+ 				while($row = $this->db->sql_fetchrow($result))
+ 				{
++					$post_ary[] = $row;
++
++					// Prepare array for prefixes
++					if (!isset($prefix_ary[$row['topic_id']])) {
++						$prefix_ary[$row['topic_id']] = array();
++					}
++				}
++				$this->db->sql_freeresult($result);
++
++				// Obtain prefixes
++				$sql = 'SELECT i.*, p.*
++				   FROM ' . BBPREFIX_INSTANCES_TABLE . ' i
++				   LEFT JOIN ' . BBPREFIX_TABLE . ' p ON(p.id = i.prefix)
++				   WHERE ' . $this->db->sql_in_set('topic', array_keys($prefix_ary)) . '
++				   ORDER BY i.ordered';
++				$result = $this->db->sql_query($sql);
++
++				while ($row = $this->db->sql_fetchrow($result)) {
++					$prefix_ary[$row['topic']][] = $row;
++				}
++
++				// Parse data
++				foreach ($post_ary as $row) {
++					$row_prefixes = [];
+ 					$row_images = [];
+ 
+-					preg_match_all('#<IMG src="(.*?)">#i', $row['post_text'], $matches, PREG_SET_ORDER);
++					preg_match_all('#<ALBUM content="(.*?)">#i', $row['post_text'], $matches, PREG_SET_ORDER);
++
++					if (!empty($prefix_ary[$row['topic_id']])) {
++						foreach ($prefix_ary[$row['topic_id']] as $prefix) {
++							$row_prefixes[] = array(
++								'NAME'   => $prefix['name']
++							);
++						}
++					}
+ 					
+ 					foreach($matches as $match)
+ 					{
+@@ -265,8 +297,15 @@ class gallery_block extends base
+ 								'p'	=> $row['post_id'],
+ 								'#'	=> 'p' . $row['post_id']
+ 							]),
+-							'SRC'		=> $match[1],
++							'SRC'		=> '/forum/gallery/image/' . $match[1] . '/mini',
+ 							'TITLE'		=> $row['post_subject'],
++							'PREFIX_STR'	=> implode('-', array_map(
++								function ($prefix) {
++									return $prefix['NAME'];
++								},
++								$row_prefixes
++							)),
++							'prefix'	=> $row_prefixes,
+ 						];
+ 					}
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/login_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/login_block.php"
+index daa168f28..86a6e72be 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/login_block.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/login_block.php"
+@@ -135,10 +135,10 @@ class login_block extends base
+ 		if($this->user->data['is_registered'])
+ 		{
+ 			$links = [
+-				'SEARCH_NEW'	=> ['url' => 'U_SEARCH_NEW', 	'icon' => 'fa-file-o icon-red'],
+-				'SEARCH_SELF'	=> ['url' => 'U_SEARCH_SELF', 	'icon' => 'fa-file-o'],
++				'SEARCH_NEW'	=> ['url' => 'U_SEARCH_NEW', 	'icon' => 'fa-commenting icon-red'],
++				'SEARCH_SELF'	=> ['url' => 'U_SEARCH_SELF', 	'icon' => 'fa-comment'],
+ 				'MY_BOOKMARKS'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=bookmarks'), 	'icon' => 'fa-star-o'],
+-				'MY_SUBSCRIBED'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=subscribed'), 	'icon' => 'fa-bookmark-o'],
++				'MY_SUBSCRIBED'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=subscribed'), 	'icon' => 'fa-eye'],
+ 			];
+ 			
+ 			if($this->config['allow_privmsg'] && ($this->auth->acl_get('u_readpm') || $this->auth->acl_get('u_sendpm')))
+@@ -147,7 +147,7 @@ class login_block extends base
+ 				
+ 				$links[$pm_title] = [
+ 					'url' => 'U_PRIVATEMSGS',
+-					'icon' => 'fa-inbox',
++					'icon' => 'fa-envelope',
+ 				];
+ 			}
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/news_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/news_block.php"
+index 42c0169b6..5ffe59b8c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/news_block.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/news_block.php"
+@@ -45,7 +45,7 @@ class news_block extends base
+ 		{
+ 			foreach($data['forums'] as $id => $forum_id)
+ 			{
+-				if(!$this->auth->acl_get('f_read', $forum_id))
++				if(!$this->auth->acl_get('f_read', $forum_id) || !$this->auth->acl_get('f_read_others_topics_brunoais', $forum_id))
+ 				{
+ 					unset($data['forums'][$id]);
+ 				}
+@@ -80,7 +80,7 @@ class news_block extends base
+ 				AND t.topic_visibility = ' . ITEM_APPROVED . '
+ 				AND ' . $this->db->sql_in_set('t.forum_id', $data['forums']),
+ 				
+-			'ORDER_BY'	=> 't.topic_time DESC',
++			'ORDER_BY'	=> 't.topic_last_post_time DESC',
+ 		];
+ 
+ 		$forum_data 	= new \canidev\core\DummyArray;
+@@ -227,12 +227,14 @@ class news_block extends base
+ 				'TOPIC_TITLE'			=> $topic_title,
+ 				'TOPIC_TITLE_RAW'		=> $topic_title, // Raw title (not modified by extensions)
+ 				'FIRST_POST_TIME'		=> $this->user->format_date($row['topic_time']),
++				'LAST_POST_TIME'		=> $this->user->format_date($row['topic_last_post_time']),
+ 				'S_HAS_ATTACHMENTS'		=> (!empty($attachments[$row['topic_first_post_id']])) ? true : false,
+ 				'FORUM_NAME'			=> $row['forum_name'],
+ 				'TEXT'					=> $message,
+ 				'VIEWS'					=> $row['topic_views'],
+ 				'S_HAS_POLL'			=> ($row['poll_start'] > 0) ? true : false,
+ 				'TOPIC_AUTHOR_FULL'		=> get_username_string('full', $row['topic_poster'], $row['username'], $row['user_colour'], $row['post_username']),
++				'LAST_POST_AUTHOR_FULL'	=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour'], $row['post_username']),
+ 				'REPLIES'				=> max(0, (int)$row['topic_posts_approved'] - 1),
+ 
+ 				'U_VIEW_TOPIC'			=> $u_view_topic,
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/recent_topics_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/recent_topics_block.php"
+index 774612e56..a09b27568 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/recent_topics_block.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/recent_topics_block.php"
+@@ -47,7 +47,7 @@ class recent_topics_block extends base
+ 		{
+ 			foreach($data['forums'] as $forum_id)
+ 			{
+-				if($this->auth->acl_get('f_read', $forum_id))
++				if($this->auth->acl_get('f_read', $forum_id) && $this->auth->acl_get('f_read_others_topics_brunoais', $forum_id))
+ 				{
+ 					$forum_ids[] = $forum_id;
+ 				}
+@@ -67,7 +67,7 @@ class recent_topics_block extends base
+ 			self::TAB_TOPICS => [
+ 				'title'			=> 'BLG_RECENT_TOPICS',
+ 				'icon'			=> 'fa-comment',
+-				'where'			=> '',
++				'where'			=> 'AND t.topic_posts_approved >= 1)',
+ 				'order_by'		=> 't.topic_time DESC',
+ 			],
+ 
+@@ -82,7 +82,7 @@ class recent_topics_block extends base
+ 			self::TAB_ACTIVITY => [
+ 				'title'			=> 'BLG_RECENT_ACTIVITY',
+ 				'icon'			=> 'fa-comments-o',
+-				'where'			=> 'AND t.topic_posts_approved > 1)',
++				'where'			=> ')',
+ 				'order_by'		=> 't.topic_last_post_time DESC',
+ 			],
+ 		];
+@@ -286,6 +286,7 @@ class recent_topics_block extends base
+ 					'U_LAST_POST'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;p=' . $row['topic_last_post_id']) . '#p' . $row['topic_last_post_id'],
+ 					'U_VIEW_FORUM'		=> $this->helper->url('viewforum', 'f=' . $row['forum_id']),
+ 					'U_VIEW_TOPIC'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;view=unread#unread'),
++					'U_NEWEST_POST'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;view=unread#unread'),
+ 				];
+ 
+ 				/**
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/topic_index_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/topic_index_block.php"
+index 655631b86..f689c8d07 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/topic_index_block.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/topic_index_block.php"
+@@ -87,7 +87,10 @@ class topic_index_block extends base
+ 			case 'topic_title':
+ 				if($first_char)
+ 				{
+-					$sql_array['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression(substr($first_char, 0, 1) . $this->db->get_any_char());
++					$sql_array['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression('[' . $this->db->get_any_char() . '] ' . substr($first_char, 0, 1) . $this->db->get_any_char());
++				}
++				else {
++					$sql_array['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression('[' . $this->db->get_any_char() . '] ' . $this->db->get_any_char());
+ 				}
+ 
+ 				$sql_array['ORDER_BY'] = 'LOWER(t.topic_title) ASC';
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/controller/calendar_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/controller/calendar_controller.php"
+index ef69c475c..dcfa9befc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/controller/calendar_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/controller/calendar_controller.php"
+@@ -166,6 +166,7 @@ class calendar_controller
+ 					LEFT JOIN ' . BANLIST_TABLE . " b ON (u.user_id = b.ban_userid)
+ 					WHERE (b.ban_id IS NULL OR b.ban_exclude = 1)
+ 					AND ($sql_where)
++					AND u.user_posts > 100
+ 					AND u.user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ')
+ 					ORDER BY username_clean ASC';
+ 				$result = $this->db->sql_query($sql);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/diff_full.tmp"
+new file mode 100644
+index 000000000..16dfd0ef2
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/diff_full.tmp"
+@@ -0,0 +1,4686 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/gallery_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/gallery_block.php"
++index cc4b732d7..ca008eeec 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/gallery_block.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/gallery_block.php"
++@@ -236,7 +236,7 @@ class gallery_block extends base
++ 					'WHERE'			=> 'p.post_visibility = ' . ITEM_APPROVED . '
++ 						AND (' . implode(' OR ', $sql_where) . ")
++ 						AND p.bbcode_uid NOT LIKE ''
++-						AND p.post_text " . $this->db->sql_like_expression($this->db->get_any_char() . '[img]' . $this->db->get_any_char()),
+++						AND p.post_text " . $this->db->sql_like_expression($this->db->get_any_char() . '[album]' . $this->db->get_any_char()),
++ 					'ORDER_BY'		=> ($data['image_order'] == 'last') ? 'p.post_time DESC' : $random_key,
++ 				];
++ 
++@@ -253,10 +253,42 @@ class gallery_block extends base
++ 				$result = $this->db->sql_query_limit($sql, $data['max_number']);
++ 				while($row = $this->db->sql_fetchrow($result))
++ 				{
+++					$post_ary[] = $row;
+++
+++					// Prepare array for prefixes
+++					if (!isset($prefix_ary[$row['topic_id']])) {
+++						$prefix_ary[$row['topic_id']] = array();
+++					}
+++				}
+++				$this->db->sql_freeresult($result);
+++
+++				// Obtain prefixes
+++				$sql = 'SELECT i.*, p.*
+++				   FROM ' . BBPREFIX_INSTANCES_TABLE . ' i
+++				   LEFT JOIN ' . BBPREFIX_TABLE . ' p ON(p.id = i.prefix)
+++				   WHERE ' . $this->db->sql_in_set('topic', array_keys($prefix_ary)) . '
+++				   ORDER BY i.ordered';
+++				$result = $this->db->sql_query($sql);
+++
+++				while ($row = $this->db->sql_fetchrow($result)) {
+++					$prefix_ary[$row['topic']][] = $row;
+++				}
+++
+++				// Parse data
+++				foreach ($post_ary as $row) {
+++					$row_prefixes = [];
++ 					$row_images = [];
++ 
++-					preg_match_all('#<IMG src="(.*?)">#i', $row['post_text'], $matches, PREG_SET_ORDER);
+++					preg_match_all('#<ALBUM content="(.*?)">#i', $row['post_text'], $matches, PREG_SET_ORDER);
++ 
+++					if (!empty($prefix_ary[$row['topic_id']])) {
+++						foreach ($prefix_ary[$row['topic_id']] as $prefix) {
+++							$row_prefixes[] = array(
+++								'NAME'   => $prefix['name']
+++							);
+++						}
+++					}
+++					
++ 					foreach($matches as $match)
++ 					{
++ 						$row_images[] = [
++@@ -265,8 +297,15 @@ class gallery_block extends base
++ 								'p'	=> $row['post_id'],
++ 								'#'	=> 'p' . $row['post_id']
++ 							]),
++-							'SRC'		=> $match[1],
+++							'SRC'		=> '/forum/gallery/image/' . $match[1] . '/mini',
++ 							'TITLE'		=> $row['post_subject'],
+++							'PREFIX_STR'	=> implode('-', array_map(
+++								function ($prefix) {
+++									return $prefix['NAME'];
+++								},
+++								$row_prefixes
+++							)),
+++							'prefix'	=> $row_prefixes,
++ 						];
++ 					}
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/login_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/login_block.php"
++index daa168f28..86a6e72be 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/login_block.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/login_block.php"
++@@ -135,10 +135,10 @@ class login_block extends base
++ 		if($this->user->data['is_registered'])
++ 		{
++ 			$links = [
++-				'SEARCH_NEW'	=> ['url' => 'U_SEARCH_NEW', 	'icon' => 'fa-file-o icon-red'],
++-				'SEARCH_SELF'	=> ['url' => 'U_SEARCH_SELF', 	'icon' => 'fa-file-o'],
+++				'SEARCH_NEW'	=> ['url' => 'U_SEARCH_NEW', 	'icon' => 'fa-commenting icon-red'],
+++				'SEARCH_SELF'	=> ['url' => 'U_SEARCH_SELF', 	'icon' => 'fa-comment'],
++ 				'MY_BOOKMARKS'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=bookmarks'), 	'icon' => 'fa-star-o'],
++-				'MY_SUBSCRIBED'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=subscribed'), 	'icon' => 'fa-bookmark-o'],
+++				'MY_SUBSCRIBED'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=subscribed'), 	'icon' => 'fa-eye'],
++ 			];
++ 			
++ 			if($this->config['allow_privmsg'] && ($this->auth->acl_get('u_readpm') || $this->auth->acl_get('u_sendpm')))
++@@ -147,7 +147,7 @@ class login_block extends base
++ 				
++ 				$links[$pm_title] = [
++ 					'url' => 'U_PRIVATEMSGS',
++-					'icon' => 'fa-inbox',
+++					'icon' => 'fa-envelope',
++ 				];
++ 			}
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/news_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/news_block.php"
++index 42c0169b6..5ffe59b8c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/news_block.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/news_block.php"
++@@ -45,7 +45,7 @@ class news_block extends base
++ 		{
++ 			foreach($data['forums'] as $id => $forum_id)
++ 			{
++-				if(!$this->auth->acl_get('f_read', $forum_id))
+++				if(!$this->auth->acl_get('f_read', $forum_id) || !$this->auth->acl_get('f_read_others_topics_brunoais', $forum_id))
++ 				{
++ 					unset($data['forums'][$id]);
++ 				}
++@@ -80,7 +80,7 @@ class news_block extends base
++ 				AND t.topic_visibility = ' . ITEM_APPROVED . '
++ 				AND ' . $this->db->sql_in_set('t.forum_id', $data['forums']),
++ 				
++-			'ORDER_BY'	=> 't.topic_time DESC',
+++			'ORDER_BY'	=> 't.topic_last_post_time DESC',
++ 		];
++ 
++ 		$forum_data 	= new \canidev\core\DummyArray;
++@@ -227,12 +227,14 @@ class news_block extends base
++ 				'TOPIC_TITLE'			=> $topic_title,
++ 				'TOPIC_TITLE_RAW'		=> $topic_title, // Raw title (not modified by extensions)
++ 				'FIRST_POST_TIME'		=> $this->user->format_date($row['topic_time']),
+++				'LAST_POST_TIME'		=> $this->user->format_date($row['topic_last_post_time']),
++ 				'S_HAS_ATTACHMENTS'		=> (!empty($attachments[$row['topic_first_post_id']])) ? true : false,
++ 				'FORUM_NAME'			=> $row['forum_name'],
++ 				'TEXT'					=> $message,
++ 				'VIEWS'					=> $row['topic_views'],
++ 				'S_HAS_POLL'			=> ($row['poll_start'] > 0) ? true : false,
++ 				'TOPIC_AUTHOR_FULL'		=> get_username_string('full', $row['topic_poster'], $row['username'], $row['user_colour'], $row['post_username']),
+++				'LAST_POST_AUTHOR_FULL'	=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour'], $row['post_username']),
++ 				'REPLIES'				=> max(0, (int)$row['topic_posts_approved'] - 1),
++ 
++ 				'U_VIEW_TOPIC'			=> $u_view_topic,
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/recent_topics_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/recent_topics_block.php"
++index 774612e56..a09b27568 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/recent_topics_block.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/recent_topics_block.php"
++@@ -47,7 +47,7 @@ class recent_topics_block extends base
++ 		{
++ 			foreach($data['forums'] as $forum_id)
++ 			{
++-				if($this->auth->acl_get('f_read', $forum_id))
+++				if($this->auth->acl_get('f_read', $forum_id) && $this->auth->acl_get('f_read_others_topics_brunoais', $forum_id))
++ 				{
++ 					$forum_ids[] = $forum_id;
++ 				}
++@@ -67,7 +67,7 @@ class recent_topics_block extends base
++ 			self::TAB_TOPICS => [
++ 				'title'			=> 'BLG_RECENT_TOPICS',
++ 				'icon'			=> 'fa-comment',
++-				'where'			=> '',
+++				'where'			=> 'AND t.topic_posts_approved >= 1)',
++ 				'order_by'		=> 't.topic_time DESC',
++ 			],
++ 
++@@ -82,7 +82,7 @@ class recent_topics_block extends base
++ 			self::TAB_ACTIVITY => [
++ 				'title'			=> 'BLG_RECENT_ACTIVITY',
++ 				'icon'			=> 'fa-comments-o',
++-				'where'			=> 'AND t.topic_posts_approved > 1)',
+++				'where'			=> ')',
++ 				'order_by'		=> 't.topic_last_post_time DESC',
++ 			],
++ 		];
++@@ -286,6 +286,7 @@ class recent_topics_block extends base
++ 					'U_LAST_POST'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;p=' . $row['topic_last_post_id']) . '#p' . $row['topic_last_post_id'],
++ 					'U_VIEW_FORUM'		=> $this->helper->url('viewforum', 'f=' . $row['forum_id']),
++ 					'U_VIEW_TOPIC'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;view=unread#unread'),
+++					'U_NEWEST_POST'		=> $this->helper->url('viewtopic', $view_topic_url_params . '&amp;view=unread#unread'),
++ 				];
++ 
++ 				/**
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/topic_index_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/topic_index_block.php"
++index 655631b86..f689c8d07 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/topic_index_block.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/topic_index_block.php"
++@@ -87,7 +87,10 @@ class topic_index_block extends base
++ 			case 'topic_title':
++ 				if($first_char)
++ 				{
++-					$sql_array['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression(substr($first_char, 0, 1) . $this->db->get_any_char());
+++					$sql_array['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression('[' . $this->db->get_any_char() . '] ' . substr($first_char, 0, 1) . $this->db->get_any_char());
+++				}
+++				else {
+++					$sql_array['WHERE'] .= ' AND t.topic_title ' . $this->db->sql_like_expression('[' . $this->db->get_any_char() . '] ' . $this->db->get_any_char());
++ 				}
++ 
++ 				$sql_array['ORDER_BY'] = 'LOWER(t.topic_title) ASC';
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/controller/calendar_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/controller/calendar_controller.php"
++index ef69c475c..dcfa9befc 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/controller/calendar_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/controller/calendar_controller.php"
++@@ -166,6 +166,7 @@ class calendar_controller
++ 					LEFT JOIN ' . BANLIST_TABLE . " b ON (u.user_id = b.ban_userid)
++ 					WHERE (b.ban_id IS NULL OR b.ban_exclude = 1)
++ 					AND ($sql_where)
+++					AND u.user_posts > 100
++ 					AND u.user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ')
++ 					ORDER BY username_clean ASC';
++ 				$result = $this->db->sql_query($sql);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/diff_full.tmp"
++new file mode 100644
++index 000000000..309c0cd77
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/diff_full.tmp"
++@@ -0,0 +1,170 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/gallery_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/gallery_block.php"
+++index cc4b732d7..ca008eeec 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/gallery_block.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/gallery_block.php"
+++@@ -236,7 +236,7 @@ class gallery_block extends base
+++ 					'WHERE'			=> 'p.post_visibility = ' . ITEM_APPROVED . '
+++ 						AND (' . implode(' OR ', $sql_where) . ")
+++ 						AND p.bbcode_uid NOT LIKE ''
+++-						AND p.post_text " . $this->db->sql_like_expression($this->db->get_any_char() . '[img]' . $this->db->get_any_char()),
++++						AND p.post_text " . $this->db->sql_like_expression($this->db->get_any_char() . '[album]' . $this->db->get_any_char()),
+++ 					'ORDER_BY'		=> ($data['image_order'] == 'last') ? 'p.post_time DESC' : $random_key,
+++ 				];
+++ 
+++@@ -253,10 +253,42 @@ class gallery_block extends base
+++ 				$result = $this->db->sql_query_limit($sql, $data['max_number']);
+++ 				while($row = $this->db->sql_fetchrow($result))
+++ 				{
++++					$post_ary[] = $row;
++++
++++					// Prepare array for prefixes
++++					if (!isset($prefix_ary[$row['topic_id']])) {
++++						$prefix_ary[$row['topic_id']] = array();
++++					}
++++				}
++++				$this->db->sql_freeresult($result);
++++
++++				// Obtain prefixes
++++				$sql = 'SELECT i.*, p.*
++++				   FROM ' . BBPREFIX_INSTANCES_TABLE . ' i
++++				   LEFT JOIN ' . BBPREFIX_TABLE . ' p ON(p.id = i.prefix)
++++				   WHERE ' . $this->db->sql_in_set('topic', array_keys($prefix_ary)) . '
++++				   ORDER BY i.ordered';
++++				$result = $this->db->sql_query($sql);
++++
++++				while ($row = $this->db->sql_fetchrow($result)) {
++++					$prefix_ary[$row['topic']][] = $row;
++++				}
++++
++++				// Parse data
++++				foreach ($post_ary as $row) {
++++					$row_prefixes = [];
+++ 					$row_images = [];
+++ 
+++-					preg_match_all('#<IMG src="(.*?)">#i', $row['post_text'], $matches, PREG_SET_ORDER);
++++					preg_match_all('#<ALBUM content="(.*?)">#i', $row['post_text'], $matches, PREG_SET_ORDER);
+++ 
++++					if (!empty($prefix_ary[$row['topic_id']])) {
++++						foreach ($prefix_ary[$row['topic_id']] as $prefix) {
++++							$row_prefixes[] = array(
++++								'NAME'   => $prefix['name']
++++							);
++++						}
++++					}
++++					
+++ 					foreach($matches as $match)
+++ 					{
+++ 						$row_images[] = [
+++@@ -265,8 +297,15 @@ class gallery_block extends base
+++ 								'p'	=> $row['post_id'],
+++ 								'#'	=> 'p' . $row['post_id']
+++ 							]),
+++-							'SRC'		=> $match[1],
++++							'SRC'		=> '/forum/gallery/image/' . $match[1] . '/mini',
+++ 							'TITLE'		=> $row['post_subject'],
++++							'PREFIX_STR'	=> implode('-', array_map(
++++								function ($prefix) {
++++									return $prefix['NAME'];
++++								},
++++								$row_prefixes
++++							)),
++++							'prefix'	=> $row_prefixes,
+++ 						];
+++ 					}
+++ 
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/login_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/login_block.php"
+++index daa168f28..86a6e72be 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/login_block.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/login_block.php"
+++@@ -135,10 +135,10 @@ class login_block extends base
+++ 		if($this->user->data['is_registered'])
+++ 		{
+++ 			$links = [
+++-				'SEARCH_NEW'	=> ['url' => 'U_SEARCH_NEW', 	'icon' => 'fa-file-o icon-red'],
+++-				'SEARCH_SELF'	=> ['url' => 'U_SEARCH_SELF', 	'icon' => 'fa-file-o'],
++++				'SEARCH_NEW'	=> ['url' => 'U_SEARCH_NEW', 	'icon' => 'fa-commenting icon-red'],
++++				'SEARCH_SELF'	=> ['url' => 'U_SEARCH_SELF', 	'icon' => 'fa-comment'],
+++ 				'MY_BOOKMARKS'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=bookmarks'), 	'icon' => 'fa-star-o'],
+++-				'MY_SUBSCRIBED'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=subscribed'), 	'icon' => 'fa-bookmark-o'],
++++				'MY_SUBSCRIBED'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=subscribed'), 	'icon' => 'fa-eye'],
+++ 			];
+++ 			
+++ 			if($this->config['allow_privmsg'] && ($this->auth->acl_get('u_readpm') || $this->auth->acl_get('u_sendpm')))
+++@@ -147,7 +147,7 @@ class login_block extends base
+++ 				
+++ 				$links[$pm_title] = [
+++ 					'url' => 'U_PRIVATEMSGS',
+++-					'icon' => 'fa-inbox',
++++					'icon' => 'fa-envelope',
+++ 				];
+++ 			}
+++ 
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/news_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/news_block.php"
+++index 42c0169b6..5ffe59b8c 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/news_block.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/news_block.php"
+++@@ -45,7 +45,7 @@ class news_block extends base
+++ 		{
+++ 			foreach($data['forums'] as $id => $forum_id)
+++ 			{
+++-				if(!$this->auth->acl_get('f_read', $forum_id))
++++				if(!$this->auth->acl_get('f_read', $forum_id) || !$this->auth->acl_get('f_read_others_topics_brunoais', $forum_id))
+++ 				{
+++ 					unset($data['forums'][$id]);
+++ 				}
+++@@ -80,7 +80,7 @@ class news_block extends base
+++ 				AND t.topic_visibility = ' . ITEM_APPROVED . '
+++ 				AND ' . $this->db->sql_in_set('t.forum_id', $data['forums']),
+++ 				
+++-			'ORDER_BY'	=> 't.topic_time DESC',
++++			'ORDER_BY'	=> 't.topic_last_post_time DESC',
+++ 		];
+++ 
+++ 		$forum_data 	= new \canidev\core\DummyArray;
+++@@ -227,12 +227,14 @@ class news_block extends base
+++ 				'TOPIC_TITLE'			=> $topic_title,
+++ 				'TOPIC_TITLE_RAW'		=> $topic_title, // Raw title (not modified by extensions)
+++ 				'FIRST_POST_TIME'		=> $this->user->format_date($row['topic_time']),
++++				'LAST_POST_TIME'		=> $this->user->format_date($row['topic_last_post_time']),
+++ 				'S_HAS_ATTACHMENTS'		=> (!empty($attachments[$row['topic_first_post_id']])) ? true : false,
+++ 				'FORUM_NAME'			=> $row['forum_name'],
+++ 				'TEXT'					=> $message,
+++ 				'VIEWS'					=> $row['topic_views'],
+++ 				'S_HAS_POLL'			=> ($row['poll_start'] > 0) ? true : false,
+++ 				'TOPIC_AUTHOR_FULL'		=> get_username_string('full', $row['topic_poster'], $row['username'], $row['user_colour'], $row['post_username']),
++++				'LAST_POST_AUTHOR_FULL'	=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour'], $row['post_username']),
+++ 				'REPLIES'				=> max(0, (int)$row['topic_posts_approved'] - 1),
+++ 
+++ 				'U_VIEW_TOPIC'			=> $u_view_topic,
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/recent_topics_block.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/recent_topics_block.php"
+++index 774612e56..a09b27568 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/blocks/recent_topics_block.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/blocks/recent_topics_block.php"
+++@@ -47,7 +47,7 @@ class recent_topics_block extends base
+++ 		{
+++ 			foreach($data['forums'] as $forum_id)
+++ 			{
+++-				if($this->auth->acl_get('f_read', $forum_id))
++++				if($this->auth->acl_get('f_read', $forum_id) && $this->auth->acl_get('f_read_others_topics_brunoais', $forum_id))
+++ 				{
+++ 					$forum_ids[] = $forum_id;
+++ 				}
+++@@ -67,7 +67,7 @@ class recent_topics_block extends base
+++ 			self::TAB_TOPICS => [
+++ 				'title'			=> 'BLG_RECENT_TOPICS',
+++ 				'icon'			=> 'fa-comment',
+++-				'where'			=> '',
++++				'where'			=> 'AND t.topic_posts_approved >= 1)',
+++ 				'order_by'		=> 't.topic_time DESC',
+++ 			],
+++ 
+++@@ -82,7 +82,7 @@ class recent_topics_block extends base
+++ 			self::TAB_ACTIVITY => [
+++ 				'title'			=> 'BLG_RECENT_ACTIVITY',
+++ 				'icon'			=> 'fa-comments-o',
+++-				'where'			=> 'AND t.topic_posts_approved > 1)',
++++				'where'			=> ')',
+++ 				'order_by'		=> 't.topic_last_post_time DESC',
+++ 			],
+++ 		];
+++@@ -286,6 +286,7 @@ class recent_topi
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/acp.php"
++new file mode 100644
++index 000000000..2006342cf
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/acp.php"
++@@ -0,0 +1,357 @@
+++<?php
+++/*
+++* acp.php [English [En]]
+++* @package cBB Blockgets
+++* @version v2.0.2 12/01/2021
+++*
+++* @copyright (c) 2021 CaniDev
+++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+++*/
+++
+++// @ignore
+++if(!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++// @acp_blockgets
+++$lang = array_merge($lang, array(
+++	'BLG_CONFIG_TITLE'				=> 'General configuration',
+++	'BLG_CONFIG_EXPLAIN'			=> 'Thank you for choosing cBB Blockgets as a complement for your forum!<br />From here you can set the main settings of the extension.<br />Lateral links allow you to access all the options to set comfortably the mod.',
+++	'BLG_IMAGES_TITLE'				=> 'Available images',
+++	'BLG_OPTIONAL_TITLE'			=> 'Additional configuration',
+++	'BLG_OPTIONAL_EXPLAIN'			=> 'From here you can set additional settings for the site.',
+++	
+++	'BLG_ADMIN_BAR'					=> 'Show quick access bar',
+++	'BLG_ADMIN_BAR_EXPLAIN'			=> 'If enabled, a bar will be displayed at the top of the forum that will allow you to quickly access the options of the page where you are.',
+++	'BLG_BLOCK_AUTOFIT'				=> 'AutoFit blocks',
+++	'BLG_BLOCK_AUTOFIT_EXPLAIN'		=> 'If enabled, the content and disposition of the blocks will be adjust to the column.',
+++	'BLG_COLLAPSE'					=> 'Allow collapse blocks',
+++	'BLG_COLLAPSE_EXPLAIN'			=> 'Enable/disable globally the possibility that each user can collapse/expand blocks individually. This option overwrite the individual block\'s configuration.',
+++	'BLG_FULL_EDITOR'				=> 'Full editor',
+++	'BLG_ON_BOARD'					=> 'Blocks within the forum',
+++	'BLG_ON_BOARD_EXPLAIN'			=> 'Sets whether to display the blocks into the forum pages. This option overwrite the invidual page\'s configuration.<br /><br />
+++		<em>
+++			&nbsp;&nbsp;<strong>Not show:</strong> It does not show blocks on any page.<br />
+++			&nbsp;&nbsp;<strong>Individual pages:</strong> It shows the blocks on the pages configured for it.<br />
+++			&nbsp;&nbsp;<strong>Equal pages:</strong> The "General Index" blocks are shown on all pages.
+++		</em>',
+++	'BLG_REDIRECTIONS'				=> 'Redirections',
+++	'BLG_REDIRECT_404'				=> 'Page not found',
+++	'BLG_REDIRECT_404_EXPLAIN'		=> 'Sets the page to which the user will be taken when trying to access a location that does not exist.<br />
+++		<em>Replace the message No route found for "GET" of phpBB.</em>',
+++	'BLG_REDIRECT_LOGIN'			=> 'Login',
+++	'BLG_REDIRECT_LOGIN_EXPLAIN'	=> 'Sets the page to which the user will be taken after login to the forum.',
+++	'BLG_REDIRECT_LOGOUT'			=> 'Logout',
+++	'BLG_REDIRECT_LOGOUT_EXPLAIN'	=> 'Sets the page to which the user will be taken when disconnecting.',
+++
+++	'DEFAULT'					=> 'By default',
+++	'LINKS'						=> 'Links',
+++	'OPEN_GALLERY'				=> 'Open gallery',
+++	'SAVE_AND_ADD'				=> 'Save and add more',
+++	'TYPE_DOMAIN_HOME'			=> 'Domain\'s main page',
+++	'TYPE_FORUM_HOME'			=> 'Forum\'s main page',
+++	'TYPE_FORUM_SECONDARY'		=> 'Forum\'s secondary page',
+++
+++	'BOARD_BLOCK_INDIVIDUAL'	=> 'Individual pages',
+++	'BOARD_BLOCK_NONE'			=> 'Not show',
+++	'BOARD_BLOCK_SAME'			=> 'Equal pages',
+++
+++	'AVATAR_RESIZE_WIDTH'			=> 'Size of avatars',
+++	'AVATAR_RESIZE_WIDTH_EXPLAIN'	=> 'Maximum size allowed (in pixels) for avatars.<br />
+++		<em>Set 0 to disable avatar resizing</em>.',
+++	'CALENDAR'						=> 'Calendar',
+++	'CALENDAR_ENABLED'				=> 'Calendar enabled',
+++	'CALENDAR_ENABLED_EXPLAIN'		=> 'Defines whether the calendar will be available in both the<em>/calendar path</em> and blocks.',
+++	'CALENDAR_BIRTHDAYS'			=> 'Show Birthdays',
+++	'CALENDAR_BIRTHDAYS_EXPLAIN'	=> 'If enabled, user\'s birthdays will be marked and displayed on the calendar, as if they were events.',
+++	'CALENDAR_LINK'					=> 'Link',
+++	'CALENDAR_LINK_EXPLAIN'			=> 'Define in which part of the forum a link to the calendar will appear.',
+++	'CALENDAR_FIRST_DAY'			=> 'First day of the week',
+++	'CALENDAR_FIRST_DAY_EXPLAIN'	=> 'Define the first day of the week on the calendar.',
+++	'COUNTER'						=> 'Hit Counter',
+++	'COUNTER_RESET'					=> 'Reset hit counter',
+++	'COUNTER_RESET_EXPLAIN'			=> 'Sets the visits to 0 and the counter start to the current date.',
+++	'HOME_TYPE_DISPLAY'				=> 'Behavior of the home page',
+++	'HOME_TYPE_DISPLAY_EXPLAIN'		=> 'Sets how the home page will work, if it is enabled.',
+++	'IMAGE_RESIZE'					=> 'Resize images',
+++	'IMAGE_RESIZE_POST'				=> 'Resize images in posts',
+++	'IMAGE_RESIZE_POST_EXPLAIN'		=> 'Enable/Disable the resize in the images inside the forum posts.',
+++	'IMAGE_RESIZE_WIDTH'			=> 'Images max size',
+++	'IMAGE_RESIZE_WIDTH_EXPLAIN'	=> 'Maximum size (in pixels) for images. The default is 450.<br />
+++		<em>Set 0 to disable image resizing</em>.',
+++
+++	'INDEX_FILE_ERROR'				=> 'Failed to complete setup',
+++));
+++
+++// @acp_blockgets_lists
+++$lang = array_merge($lang, array(
+++	'ADD_ITEM'				=> 'Add item',
+++	'CAT'					=> 'Category',
+++
+++	'LINK'						=> 'Link',
+++	'LINK_DESCRIPTION'			=> 'Description',
+++	'LINK_DESCRIPTION_EXPLAIN'	=> 'This text will be show in some blocks as aditional link information.',
+++	'LINK_GROUP'				=> 'Groups',
+++	'LINK_GROUP_EXPLAIN'		=> 'Select groups of users that can see this link in the menu.<br />You can select multiple groups using the <em>Ctrl</em> key on your keyboard.',
+++	'LINK_IMG'					=> 'Image',
+++	'LINK_TITLE'				=> 'Link title',
+++	'LINK_TITLE_EXPLAIN'		=> 'Title that identifies the link. Limit 100 characters.',
+++	'LINK_TYPE'					=> 'Link type',
+++	'LINK_URL'					=> 'Link URL',
+++	'LINK_URL_EXPLAIN'			=> 'The direction that opens when you click on the link. Limit 255 characters.',
+++	'LINK_WINDOW'				=> 'Open in New Window',
+++));
+++
+++// @acp_blockgets_pages
+++$lang = array_merge($lang, array(
+++	'ADD_BLOCK'					=> 'Add block',
+++	'ADD_BLOCK_TIP'				=> 'Drag a block to the position you want to add it.',
+++	'ADD_BLOCK_TITLE'			=> 'Add block :: %1$s',
+++	'ADD_BLOCK_TITLE_EXPLAIN'	=> 'From here you can add a new block to your forum and set its configuration. You can also set additional settings, if the block you need.',
+++	'ADD_GROUP'					=> 'Add group',
+++	'ADD_GROUP_EXPLAIN'			=> 'Drag this button to the desired position to add a group',
+++	'ADVANCED_OPTIONS'			=> 'Advanced options',
+++
+++	'BLOCK_SETTINGS'			=> 'General options for the block',
+++	'BLOCK_SPACE'				=> 'Space between blocks',
+++	'BLOCK_SPACE_EXPLAIN'		=> 'Value in pixels or percentage. The minimun value is 1.',
+++	'BOTTOM_COLUMN'				=> 'Bottom column',
+++	'CENTER_COLUMN'				=> 'Center column',
+++	'CHG_GROUPS_BLOCK'			=> 'Change permissions',
+++	'CHG_GROUP_EXPLAIN'			=> 'Choose groups who can see the selected blocks',
+++	'COLUMN_SETTINGS'			=> 'Options for the columns',
+++	'COPY_BLOCK'				=> 'Copy to other page',
+++	'DELETE_BLOCK_CONFIRM'		=> 'Are you sure you want to delete the selected blocks?',
+++	'DISABLE_BLOCK'				=> 'Disable',
+++	'EDIT_BLOCK_TITLE'			=> 'Edit block :: %1$s',
+++	'EDIT_BLOCK_TITLE_EXPLAIN'	=> 'Here you can edit the configuration of the block, as well as additional settings, if the block you need.',
+++	'ENABLE_BLOCK'				=> 'Enable',
+++	'EXT_ROUTES'				=> 'Extension\'s routes',
+++	'FILTER_TYPE_GET'			=> 'Url (GET)',
+++	'FILTER_TYPE_POST'			=> 'Form (POST)',
+++	'FORUM_FILES'				=> 'Forum files',
+++	'LEFT_COLUMN'				=> 'Left column',
+++	'LEFT_COLUMN_EXPLAIN'		=> 'Width of the left column in pixels or percentage.<br />Set 0 to disable the column.',
+++	'LINK_BOTTOM'				=> 'Bottom',
+++	'LINK_QUICK'				=> 'Quick links',
+++	'LINK_NONE'					=> 'No link',
+++	'LINK_TOP'					=> 'Top',
+++	'MANAGE_PAGE'				=> 'Manage page',
+++	'MOVE_BLOCK'				=> 'Move to other page',
+++	'NO_PAGES_CREATED'			=> 'No pages created.',
+++	'NO_PAGE_FILTERS'			=> 'No filters',
+++	
+++	'PAGE'						=> 'Page',
+++	'PAGE_ADD'					=> 'New page',
+++	'PAGE_ALIAS'				=> 'Page alias',
+++	'PAGE_ALIAS_EXPLAIN'		=> 'You can set an alias (letters, numbers and dashes) to create a separate page.<br />If you leave this field blank, it will create a separate page and will be used the ID as alias.',
+++	'PAGE_ALIAS_ERROR'			=> 'The value inserted in "Alias page" field contains illegal characters or an invalid path.',
+++	'PAGE_BACKGROUND'			=> 'Page background',
+++	'PAGE_BACKGROUND_EXPLAIN'	=> 'You can set a color (ex. white, #FFFFFF) or an image (ex. http://mydomain.com/image.jpg). Leave this field blank to use the default background.',
+++	'PAGE_CUSTOM'				=> 'Custom Pages',
+++	'PAGE_CUSTOM_EXPLAIN'		=> 'These are pages created by you or another administrator of this site. You can add, edit and manage as many pages as you wish.',
+++	'PAGE_CUSTOM_ONE'			=> 'Custom Page',
+++	'PAGE_DESCRIPTION'			=> 'SEO Description',
+++	'PAGE_DESCRIPTION_EXPLAIN'	=> 'Defines a description visible to search engines.<br /><em>Google, bing, etc...</em>',
+++	'PAGE_ENABLED'				=> 'Page enabled',
+++	'PAGE_ENABLED_EXPLAIN'		=> 'Enable or disable the page functions completely. This option overrides all others.',
+++	'PAGE_FILTERS'				=> 'Filters',
+++	'PAGE_FILTERS_EXPLAIN'		=> 'Define the required parameters (GET and POST) for the page is loaded.<br />Check <strong>Online Documentation</strong> for more information on how to set these filters.',
+++	'PAGE_FILTER_PARAM'			=> 'Parameters',
+++	'PAGE_FILTER_PARAM_EXPLAIN'	=> 'You can set as many as you want separated by ","<br />Ex: mode=mymode,style=1',
+++	'PAGE_FILTER_TYPE'			=> 'Type',
+++	'PAGE_FILTER_TYPE_EXPLAIN'	=> 'Select the type of location parameters.',
+++	'PAGE_FORUM'				=> 'Pages inside the forum',
+++	'PAGE_FORUM_EXPLAIN'		=> 'These are pages belonging to the forum to which you can add blocks. You can manage and edit their main parameters as in customized pages.',
+++	'PAGE_GROUP'				=> 'Groups',
+++	'PAGE_GROUP_EXPLAIN'		=> 'Choose groups who can see the blocks of this page.<br />You can select multiple groups using <em>Ctrl key</em> on your keyboard.',
+++	'PAGE_HOME'					=> 'Home page',
+++	'PAGE_HOME_EXPLAIN'			=> 'This is a page designed to be used as a site\'s home page as a "Portal".',
+++	'PAGE_LINK'					=> 'Link',
+++	'PAGE_LINK_ICON'			=> 'Link icon',
+++	'PAGE_LINK_ICON_EXPLAIN'	=> 'Define the icon that will have the link to this page.',
+++	'PAGE_LINK_POSITION'		=> 'Link position',
+++	'PAGE_LINK_POSITION_EXPLAIN'	=> 'Define in which part of the forum a link to this page will appear.',
+++	'PAGE_LOGO'					=> 'Logo',
+++	'PAGE_LOGO_EXPLAIN'			=> 'Sets the url of the image to be used as logo.<br />Leave blank to use the default logo.',
+++	'PAGE_STYLE'				=> 'Style',
+++	'PAGE_STYLE_EXPLAIN'		=> 'Defines the style to be used on the page.<br /><em>This option will not be applied to the original pages of the forum.</em>',
+++	'PAGE_STYLESHEET'			=> 'Custom theme',
+++	'PAGE_STYLESHEET_EXPLAIN'	=> 'You can set the path to one or more files *.css (one per line) or directly set the variables of the theme that will be used.',
+++	'PAGE_THEME'				=> 'Theme',
+++	'PAGE_THEME_BACKGROUND'		=> 'Set background',
+++	'PAGE_THEME_DEFAULT'		=> 'Use default configuration',
+++	'PAGE_THEME_STYLE'			=> 'Set style',
+++	'PAGE_THEME_STYLESHEET'		=> 'Use custom theme',
+++	'PAGE_TITLE'				=> 'Page title',
+++	'PAGE_TITLE_EXPLAIN'		=> 'Title will be displayed in the browser.',
+++	'PAGE_URL'					=> 'Page url',
+++	
+++	'PAGES_ADD_TITLE'				=> 'Add new page',
+++	'PAGES_ADD_TITLE_EXPLAIN'		=> 'From here you can add a new page and define custom configuration and appearance.',
+++	'PAGES_BLOCKS_TITLE'			=> 'Manage blocks :: %s',
+++	'PAGES_BLOCKS_TITLE_EXPLAIN'	=> 'From here you can create/edit/delete blocks to be shown on this page.<br />
+++		The blocks can be divided into five columns (left, center, right, top and bottom). Drag the blocks to change their position.<br />
+++		You can also add <strong>groups</strong> that will allow you to place blocks in up to 3 columns independently.',
+++	'PAGES_EDIT_TITLE'				=> 'Edit page :: %s',
+++	'PAGES_EDIT_TITLE_EXPLAIN'		=> 'From here you can edit the main configuration and look for the page.',
+++	'PAGES_SELECT_TITLE_EXPLAIN'	=> 'Select the page to manage.',
+++	'PAGES_TITLE'					=> 'Manage pages',
+++	'PAGES_TITLE_EXPLAIN'			=> 'From here you can create/edit/delete additional pages for your forum. You can also edit the configuration and blocks on predefined pages.',
+++	
+++	'RIGHT_COLUMN'				=> 'Right column',
+++	'RIGHT_COLUMN_EXPLAIN'		=> 'Width of the right column in pixels or percentage.<br />Set 0 to disable the column.',
+++	'SHOW_FOOTER'				=> 'Show footer',
+++	'SHOW_FOOTER_EXPLAIN'		=> 'This option lets you decide whether to display the forum footer on this page.',
+++	'SHOW_HEADER'				=> 'Show header',
+++	'SHOW_HEADER_EXPLAIN'		=> 'This option lets you decide whether to display the forum header on this page.',
+++	'STYLE_DEFAULT'				=> 'Default style',
+++	'STYLE_ALTERNATIVE'			=> 'Alternate style',
+++	'STYLE_CONTENT_FULL'		=> 'Only content (with title)',
+++	'STYLE_CONTENT_SIMPLE'		=> 'Only content (without title)',
+++	'SUBMIT_CHANGES'			=> 'Apply changes',
+++	'TARGET_PAGE_EXPLAIN'		=> 'Select the target page for the selected blocks.<br /><em>The blocks will be placed in it respective column</em>',
+++	'TOP_COLUMN'				=> 'Top column',
+++));
+++
+++// @general messages
+++$lang = array_merge($lang, array(
+++	'BLOCK_ADDED'					=> 'Block added successfully',
+++	'BLOCK_COPIED'					=> 'Block(s) copied successfully',
+++	'BLOCK_NEED_REQUIREMENTS'		=> 'The selected block will need some minimum requirements to be used.<br />See the documentation for more information.',
+++	'BLOCK_MOVED'					=> 'Block(s) moved successfully',
+++	'BLOCK_NOT_ADDED'				=> 'Error adding the block',
+++	'BLOCK_NOT_EXISTS'				=> 'The selected block does not exist',
+++	'BLOCK_NOT_UPDATED'				=> 'Error updating the block',
+++	'BLOCK_POSITION_UPDATED'		=> 'Blocks position updated successfully',
+++	'BLOCK_POSITION_NOT_UPDATED'	=> 'Error updating blocks position',
+++	'BLOCK_REMOVED'					=> 'Block(s) removed successfully',
+++	'BLOCK_UPDATED'					=> 'Block updated successfully',
+++	'GROUPS_CHANGED'				=> 'Groups updated successfully',
+++
+++	'ITEM_REMOVED'				=> 'Element removed successfully',
+++	'ITEM_UPDATED'				=> 'Element updated successfully',
+++	'ITEM_ADDED'				=> 'Element added successfully',
+++	'ITEM_NOT_ADDED'			=> 'Error adding the element',
+++	'ITEM_NOT_UPDATED'			=> 'Error updating the element',
+++
+++	'PAGE_ADDED'				=> 'Page added successfully',
+++
+++	'PAGE_REMOVED'		=> array(
+++		1	=> 'The page has been successfully removed',
+++		2	=> '%d pages deleted successfully',
+++	),
+++
+++	'PAGE_UPDATED'				=> 'Page configuration updated successfully',
+++	'BLG_CONFIG_UPDATED'		=> 'Configuration updated successfully',
+++
+++	'CONFIRM_PAGE_DELETE'		=> 'Are you sure you wish to delete this page and all blocks in this?',
+++));
+++
+++/**
+++* Blocks names and explains from block_alias
+++*/
+++$lang = array_merge($lang, array(
+++	'blocks'	=> array(
+++		'announcements_title'		=> 'Announcements',
+++		'announcements_explain'		=> 'Displays a set number of posts (announcements) of established forums.',
+++		'attachments_title'			=> 'Attachments',
+++		'attachments_explain'		=> 'Displays information and links to the specified attachments.',
+++		'banners_title'				=> 'Banners',
+++		'banners_explain'			=> 'Displays the specified list of banners. It\'s displayed in a fixed or scrolling form.',
+++		'birthdays_title'			=> 'Birthdays',
+++		'birthdays_explain'			=> 'Displays the list of birthdays for today and the next few days (optional).',
+++		'empty_title'				=> 'Custom',
+++		'empty_explain'				=> 'Totally blank block which can also include any text HTML, CSS, JavaScript, etc...',
+++		'calendar_title'			=> 'Calendar',
+++		'calendar_explain'			=> 'Calendar in which you can add custom events and show birthdays.',
+++		'clock_title'				=> 'Clock',
+++		'clock_explain'				=> 'Displays a clock in flash format (you can choose several models and add your own clock).',
+++		'cloud_tag_title'			=> 'CloudTag',
+++		'cloud_tag_explain'			=> 'Sample labels in a balloon in flash format. You can display the latest searched words or the users with more messages.',
+++		'contact_title'				=> 'Contact',
+++		'contact_explain'			=> 'Displays a standard contact form.',
+++		'countdown_title'			=> 'CountDown',
+++		'countdown_explain'			=> 'Show a countdown to the indicated date.',	
+++		'counter_title'				=> 'Hit counter',
+++		'counter_explain'			=> 'Displays a hit counter with statistics of visits, visits per day, visits per hour, weekly visits, visits per month and visits per year.',
+++		'dockmenu_title'			=> 'Dock menu',
+++		'dockmenu_explain'			=> 'Displays a menu with Mac Dock style with elements of the specified list.',
+++		'forums_title'				=> 'Forums',
+++		'forums_explain'			=> 'List with full or custom forums.',
+++		'frame_title'				=> 'Frame',
+++		'frame_explain'				=> 'Display a Web page, a PDF file, a Flash file or a text file within the block.', 
+++		'gallery_title'				=> 'Photo gallery',
+++		'gallery_explain'			=> 'Photo Gallery customizable with forum images (attachments) or external images. The images move and link the fate of each.',
+++		'google_translate_title'	=> 'Google translator',
+++		'google_translate_explain'	=> 'Block that allows you to translate the page on which it is installed, opening a new window and translating it through Google technology.',
+++		'language_select_title'		=> 'Language select',
+++		'language_select_explain'	=> 'It allows the user to view the forum with any language that is installed in the forum and set it as their default language.',
+++		'latest_bots_title'			=> 'Bot\'s visits',
+++		'latest_bots_explain'		=> 'Simple list of last bots who entered the forum and the date of their last visit.',
+++		'latest_members_title'		=> 'Newest members',
+++		'latest_members_explain'	=> 'List of latest sers registered on the forum and the date they were registered.',
+++		'leaders_title'				=> 'Leaders',
+++		'leaders_explain'			=> 'Displays a list of groups (customizable) with forum leaders.',
+++		'link_us_title'				=> 'Link Us',
+++		'link_us_explain'			=> 'Block that displays a user-selectable link to the page on which it is installed. You can set a mini banner attached to the link.',
+++		'login_title'				=> 'Login',
+++		'login_explain'				=> 'Allows a user to login directly from the block. Once identified, shows the user\'s primary information and links.',
+++		'map_title'					=> 'Map',
+++		'map_explain'				=> 'Displays a map that may contain marks with different locations.',
+++		'menu_title'				=> 'Menu',
+++		'menu_explain'				=> 'Menu in tree format that displays items from the selected list.',
+++		'most_poster_title'			=> 'Most Posters',
+++		'most_poster_explain'		=> 'Displays a dropdown with users who have posted more messages in the forum, and most relevant information.',
+++		'news_title'				=> 'News',
+++		'news_explain'				=> 'Dropdown menu showing the last posts of the specified forums as a news.',
+++		'online_friends_title'		=> 'Friends online',
+++		'online_friends_explain'	=> 'Simple list of friends and foes of the user, that are connected to the forum.',
+++		'paypal_title'				=> 'Donations',
+++		'paypal_explain'			=> 'Allows users to donate money through paypal.',
+++		'player_title'				=> 'Music Player',
+++		'player_explain'			=> 'Player to play songs in MP3 or WAV format. Allow to create a list of songs or use M3U, ASX or PLS playlists.',
+++		'poll_title'				=> 'Poll',
+++		'poll_explain'				=> 'Displays a single poll specified in its configuration.',
+++		'poll_random_title'			=> 'Poll (random)',
+++		'poll_random_explain'		=> 'Displays a selected number of polls that selected in random order, within the specified forum.',
+++		'post_view_title'			=> 'Forum post',
+++		'post_view_explain'			=> 'Displays the contents of a message. You can display the last message of a forum, the first or last post of a topic or a custom post.',
+++		'quote_of_day_title'		=> 'Quote of day',
+++		'quote_of_day_explain'		=> 'Shows a "quote" or phrase of the day or a different tip in each visit to the page.',
+++		'random_member_title'		=> 'Random Member',
+++		'random_member_explain'		=> 'Displays basic information and avatar of a random user.',
+++		'ranks_title'				=> 'Ranks',
+++		'ranks_explain'				=> 'Shows a list with the forum ranks.',
+++		'recent_topics_title'		=> 'Recent Topics',
+++		'recent_topics_explain'		=> 'Recent topics of the forum. Allow to select the forums from which to read the topics.',
+++		'rss_title'					=> 'RSS Reader',
+++		'rss_explain'				=> 'Show the latest articles from the specified RSS archives(feeds). Items will be displayed in scroll mode or accordion.', 
+++		'share_title'				=> 'Share',
+++		'share_explain'				=> 'Shows the buttons of most popular social networks in the desired format.',
+++		'search_title'				=> 'Search',
+++		'search_explain'			=> 'Allows users to do quickly searchs on the forum or in a search engine.',
+++		'scroll_message_title'		=> 'Marquee',
+++		'scroll_message_explain'	=> 'Text message that is rotating in the block. Allows use BBCode and HTML in the text.',
+++		'stats_title'				=> 'Statistics',
+++		'stats_explain'				=> 'Gets the most relevant information on the forum. This block shows the number of new messages and topics, the total number of posts and topics, message statistics and topics written per day, total number of attachments and the number of users that remaining active (posting messages).',
+++		'style_select_title'		=> 'Style select',
+++		'style_select_explain'		=> 'Allows the user to view the forum with any style that is installed on the forum and set it as their default style.',
+++		'top_topics_title'			=> 'Top topics',
+++		'top_topics_explain'		=> 'List of custom topics that can display the latest topics unread, the most active topics or the most viewed topics.',
+++		'topic_index_title'			=> 'Topic Index',
+++		'topic_index_explain'		=> 'Displays an orderly list with the topics of selected forums. The list can be order by topic title, topic date or topic last post date.',
+++		'welcome_title'				=> 'Welcome',
+++		'welcome_explain'			=> 'This block enables a different welcome message for guests and registered users. The block will decide which message display.',
+++		'whos_online_title'			=> 'Who\'s online',
+++		'whos_online_explain'		=> 'Displays the list of connected users (as is shown by default in the Index of the forum) and users who logged in last 24 hours.',
+++		'youtube_title'				=> 'YouTube',
+++		'youtube_explain'			=> 'Show videos or channels from youtube.',
+++	)
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/acp_blocks.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/acp_blocks.php"
++new file mode 100644
++index 000000000..1a22369dd
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/acp_blocks.php"
++@@ -0,0 +1,478 @@
+++<?php
+++/*
+++* acp_blocks.php [English [En]]
+++*
+++* @package cBB Blockgets
+++* @version v2.0.2 12/01/2021
+++*
+++* @copyright (c) 2021 CaniDev
+++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+++*/
+++
+++// @ignore
+++if(!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if(empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++/**
+++ * @acp_blockgets_pages
+++*/
+++$lang = array_merge($lang, array(
+++	// Blocks global config
+++	'BLOCK_COLLAPSE'			=> 'Allow collapse the block',
+++	'BLOCK_COLLAPSE_EXPLAIN'	=> 'Enable or disable the ability for each user to collapse/expand this block and defines its initial state.',
+++	'BLOCK_ENABLED'				=> 'Block enabled',
+++	'BLOCK_ENABLED_EXPLAIN'		=> 'Defines whether this block display in the forum.',
+++ 	'BLOCK_CURRENT_ICON'			=> 'Block icon',
+++	'BLOCK_CURRENT_ICON_EXPLAIN'	=> 'Current icon set to the block.',
+++	'BLOCK_GROUP'				=> 'Groups',
+++	'BLOCK_GROUP_EXPLAIN'		=> 'Choose groups who may see this block in the forum.<br />You can select multiple groups using the <em>Ctrl</em> key on your keyboard.',
+++	'BLOCK_NO_CONFIG'			=> 'This block does not require additional configuration',
+++	'BLOCK_STYLE'				=> 'Look of the block',
+++	'BLOCK_STYLE_EXPLAIN'		=> 'With this option you can choose the look of each block individually. Note that the way it is displayed depends on the style installed on the forum and its compatibility with the extension.',
+++	'BLOCK_TITLE'				=> 'Block title',
+++	'BLOCK_TITLE_EXPLAIN'		=> 'Unique name for your block.<br />This title will be shown in the block.<br />Limit: 100 characters.',
+++
+++	// Common tags
+++	'ALL_FORUMS'				=> 'All forums',
+++	'COLLAPSE_HIDDEN'			=> 'Allow (collapsed by default)',
+++	'COLLAPSE_NONE'				=> 'Not Allow',
+++	'COLLAPSE_VISIBLE'			=> 'Allow (displayed by default)',
+++	'CONFIG'					=> 'Configuration',
+++	'DESIGN_FULL'				=> 'Full',
+++	'DESIGN_SIMPLE'				=> 'Simple',
+++	'FORUMS'					=> 'Forums',
+++	'FORUMS_EXPLAIN'			=> 'Forums that contain the topics to show. You can select as many as you like using the <em>Ctrl</em> key on your keyboard.',
+++	'IGNORE_AUTH'				=> 'Ignore auth',
+++	'IGNORE_AUTH_EXPLAIN'		=> 'If enabled, will be show all the content ignoring if the user have the permissions to view it.',
+++	'NO_LISTS'					=> 'No avaliable lists',
+++	'SHOW_PAGINATION'			=> 'Show pagination',
+++	'SHOW_PAGINATION_EXPLAIN'	=> 'Show the pagination to allow user to view older posts.',
+++	'TITLE_LIMIT'				=> 'Title limit',
+++	'TITLE_LIMIT_EXPLAIN'		=> 'Maximum number of characters that will be displayed in the topic titles.<br />
+++		<em>Set 0 to show the full title.</em>',
+++	'TOPIC_DESIGN'				=> 'Block design',
+++	'TOPIC_DESIGN_EXPLAIN'		=> 'Determine how the topics will be displayed in the block.<br />
+++		<em><strong>Full:</strong> Show all information whenever possible.</em><br />
+++		<em><strong>Simple:</strong> Show only basic information.</em>',
+++	'TOPIC_PARENT_SHOW'			=> 'Show parent forum',
+++	'TOPIC_PARENT_SHOW_EXPLAIN'	=> 'If enabled, a link to the forum for each topic will be displayed.',
+++	
+++	// age_ranges_block
+++	'AGE_START'					=> 'Minimum age',
+++	'AGE_END'					=> 'Maximum age',
+++	'AGE_INTERVAL'				=> 'Interval',
+++	
+++	// announcements_block
+++	'ANN_MAX_NUMBER'			=> 'Announcements number',
+++	'ANN_MAX_NUMBER_EXPLAIN'	=> 'Maximum number of announcements that are displayed within the block.',
+++	'ANN_MAX_SIZE'				=> 'Announcement size',
+++	'ANN_MAX_SIZE_EXPLAIN'		=> 'Maximum size of characters allowed in announcements. The text is cut off if this value exceeds.',
+++	'ANN_SHOW_GLOBALS'			=> 'Show global announcements',
+++	'ANN_SHOW_GLOBALS_EXPLAIN'	=> 'If enabled, you also read the items marked as "global", otherwise only read simple announcements.',
+++	'ANN_COLLAPSE'				=> 'Collapse announcements',
+++	'ANN_COLLAPSE_EXPLAIN'		=> 'If enabled, the block only show one announcement and collapse the rest. Otherwise, the announcements will appear all at once on the block.',
+++	
+++	// attachments_block
+++	'ATTACH_FORUM'				=> 'Forum attachments',
+++	'ATTACH_FORUM_EXPLAIN'		=> 'If specified, only display attachments from this forum ignoring the rest.<br />The forum should be directly containing the topic where the attachment, the above categories or forums are ignored here.',
+++	'ATTACH_EXTENSION'			=> 'Attachment extensions',
+++	'ATTACH_EXTENSION_EXPLAIN'	=> 'If specified, all attachments which do not contain this extensions will be ignored.<br />Split the extensions with ",".<<br />Ex. valid extensions: jpg,png,gif...',
+++	'ATTACH_NUM'				=> 'Attachment number',
+++	'ATTACH_NUM_EXPLAIN'		=> 'Maximum number of attachments that are displayed simultaneously in the block.',
+++	'ATTACH_SPECIFIC'			=> 'Specific attachment',
+++	'ATTACH_SPECIFIC_EXPLAIN'	=> 'If specified, only attachment with the specified name will be show in the block. The field must contain the original filename of the attachment, Ex: myfile.jpg<br /><br /><strong>Note:</strong> this field overrides the other fields.',
+++
+++	// banners_block, banners_multiple_block
+++	'BANNERS_TITLE'				=> 'Banner title',
+++	'BANNERS_TITLE_EXPLAIN'		=> 'If enabled, the title will be appear below the banners in the block.',
+++	'BANNERS_LS_TYPE'			=> 'List type',
+++	'BANNERS_LS_TYPE_EXPLAIN'	=> 'Define how to display the banners.<br />Can be set a horizontal, vertical scroll or remain fixed.',
+++	'BANNERS_NUMBER'			=> 'Banners to show',
+++	'BANNERS_NUMBER_EXPLAIN'	=> 'Maximum number of banners to display on the block.<br />
+++		<em>Set 0 to show all the list.</em>',
+++	'BANNERS_RANDOM'			=> 'Random order',
+++	'BANNERS_RANDOM_EXPLAIN'	=> 'Set if the elements will be show in the list order or in a random order.',
+++	'LIST_NO_SCROLL'			=> 'No Scroll',
+++	'LIST_SCROLL_H'				=> 'Horizontal scroll',
+++	'LIST_SCROLL_V'				=> 'Vertical scroll',
+++	'BANNERS_B_HEIGHT'			=> 'Block height',
+++	'BANNERS_B_HEIGHT_EXPLAIN'	=> 'Enter the height of the block that will be used to scroll lists.',
+++
+++	// birthdays_block
+++ 	'NEXT_BIRTHDAYS'			=> 'Upcoming Birthdays',
+++ 	'NEXT_BIRTHDAYS_EXPLAIN'	=> 'Show birthdays that occur in the coming days.<br />
+++ 		<em>Maximum 30 days. Set to 0 to disable it.</em>',
+++
+++	// calendar_block
+++ 	'CALENDAR_BIRTHDAYS'			=> 'Show Birthdays',
+++ 	'CALENDAR_BIRTHDAYS_EXPLAIN'	=> 'If enabled, the users birthdays are marked and displayed in the calendar, like events.',
+++ 	'CALENDAR_EVENTS'				=> 'Show events',
+++ 	'CALENDAR_EVENTS_EXPLAIN'		=> 'If enabled, events are marked and displayed in the calendar.',
+++ 	'CALENDAR_MONTHS'				=> 'Months to show',
+++ 	'CALENDAR_MONTHS_EXPLAIN'		=> 'Number of months to be displayed simultaneously on the block.',
+++
+++	// contact block
+++	'CONTACT_CHECK_EMAIL'			=> 'Check email',
+++	'CONTACT_CHECK_EMAIL_EXPLAIN'	=> 'If enabled, the domain of the user email will be checked and validated.',
+++	'CONTACT_EMAIL'					=> 'Target email',
+++	'CONTACT_HIDE_FIELDS'			=> 'Hide user data',
+++	'CONTACT_HIDE_FIELDS_EXPLAIN'	=> 'If enabled, the "Name" and "Email" fields for the register users will be hidden and the block will be used their profile values.',
+++ 
+++	// countdown block
+++	'COUNTDOWN_COMPLETE_MSG'			=> 'Text upon completion',
+++	'COUNTDOWN_COMPLETE_MSG_EXPLAIN'	=> 'Text to be displayed when the counter reaches 0.',
+++	'COUNTDOWN_TARGET'					=> 'Deadline',
+++	'COUNTDOWN_TARGET_EXPLAIN'			=> 'Set the date and time the counter will reach 0.<br /><br />
+++		<em><strong>Valid formats</strong>
+++			<br />Year/Month/Day
+++			<br />Year/Month/Day Hour:Minute:Second
+++		</em>',
+++	'COUNTDOWN_RUNNING_MSG'				=> 'Hold text',
+++	'COUNTDOWN_RUNNING_MSG_EXPLAIN'		=> 'Text to be displayed while the counter is running.',
+++
+++	// counter block
+++	'COUNTER_LOCAL'				=> 'Local counter',
+++	'COUNTER_LOCAL_EXPLAIN'		=> 'If enabled, the counter only show the visits to it\'s page, otherwise, the counter show the total visits to the forum.',
+++
+++	// empty_block
+++	'BLOCK_CONTENT'				=> 'Block content',
+++	'BLOCK_CONTENT_EXPLAIN'		=> 'Content to display on the block.<br />Limit: 8000 characters.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+++
+++	// clock_block
+++	'DISPLAY_CLOCK'				=> 'Clock to show',
+++	'DISPLAY_CLOCK_EXPLAIN'		=> 'Clock displayed on the block.',
+++	'PREVIEW_CLOCK'				=> 'Preview',
+++	'PREVIEW_CLOCK_EXPLAIN'		=> 'Selected clock preview.',
+++
+++	// cloud_tags_block
+++	'CLOUD_ANIMATION'			=> 'Animation enabled',
+++	'CLOUD_ANIMATION_EXPLAIN'	=> 'If enabled, the words "tags" appear in an animated cloud tag, otherwise, they appear as fixed words in block.',
+++	'CLOUD_MODE'				=> 'Words type',
+++	'CLOUD_MODE_EXPLAIN'		=> 'Specifies that words will be shown in block.',
+++	'CLOUD_WORDS'				=> 'Words number',
+++	'CLOUD_WORDS_EXPLAIN'		=> 'Maximum number of words that appear in the block.',
+++	'MODE_SEARCH'				=> 'Last searched words',
+++	'MODE_USERS'				=> 'Users with most posts',
+++	
+++	// forums block
+++	'FORUMS_FORUM'		=> 'Forum to show',
+++	
+++	// frame_block
+++	'MIME_HTML'			=> 'Web page',
+++	'MIME_PDF'			=> 'PDF file',
+++	'MIME_PLAIN'		=> 'Plain Text file',
+++
+++	'FRAME_HEIGHT'				=> 'Frame height',
+++	'FRAME_HEIGHT_EXPLAIN'		=> 'Frame height in pixels. Set to 0 to auto adjust.',
+++	'FRAME_MIMETYPE'			=> 'Document type',
+++	'FRAME_MIMETYPE_EXPLAIN'	=> 'The document type displayed in the frame.',
+++	'FRAME_URL'					=> 'Document URL',
+++	'FRAME_URL_EXPLAIN'			=> 'URL of the document or page displayed in the frame.',
+++	'FRAME_WIDTH'				=> 'Frame width',
+++	'FRAME_WIDTH_EXPLAIN'		=> 'Frame width in pixels. Set to 0 to auto adjust.',
+++	
+++	// gallery_block
+++	'GALLERY_CUSTOM'				=> 'Custom images',
+++	'GALLERY_CUSTOM_EXPLAIN'		=> 'Specify the list containing the images to be displayed.',
+++	'GALLERY_DIRECTION'				=> 'Scroll direction',
+++	'GALLERY_FORUMS'				=> 'Forums',
+++	'GALLERY_FORUMS_EXPLAIN'		=> 'Defines the forums to read the attachments.',
+++	'GALLERY_FPS'					=> 'Scroll speed',
+++	'GALLERY_HEIGHT'				=> 'Gallery height',
+++	'GALLERY_MANAGE'				=> 'Manage gallery',
+++	'GALLERY_MARGIN'				=> 'Image margin',
+++	'GALLERY_MAX_NUMBER'			=> 'Number of images',
+++	'GALLERY_MAX_NUMBER_EXPLAIN'	=> 'Maximum attachments that will be read from the forums/topics/posts',
+++	'GALLERY_POSTS'					=> 'Posts',
+++	'GALLERY_POSTS_EXPLAIN'			=> 'Posts IDs to read the attachments, splitted with commas. (Ex: 1,2,3).',
+++	'GALLERY_SOURCE'				=> 'Origin of the images',
+++	'GALLERY_SOURCE_EXPLAIN'		=> 'Define what type of images will be loaded from the forums, topics or messages specified.',
+++	'GALLERY_TOPICS'				=> 'Topics',
+++	'GALLERY_TOPICS_EXPLAIN'		=> 'Topics IDs to read the attachments, splitted with commas. (Ex: 1,2,3).',
+++	'GALLERY_ZOOM'					=> 'Zoom',
+++	'GALLERY_ZOOM_EXPLAIN'			=> 'Size difference on image\'s mouse over (in pixels)',
+++	
+++	'GALLERY_SOURCE_ALL'			=> 'All',
+++	'GALLERY_SOURCE_ATTACHMENTS'	=> 'Only attachments',
+++	'GALLERY_SOURCE_IMAGES'			=> 'Only embedded images',
+++	
+++	'IMG_TITLE'			=> 'Image title',
+++	'IMG_URL'			=> 'Image url',
+++	'IMG_URL_EXPLAIN'	=> 'Url of an JPG, GIF or PNG image. Ej:http://mydomain.com/image.jpg',
+++	
+++	// google_translate_block
+++	'GOOGLE_LANGS'		=> 'Languages to show in the block',
+++	'GOOGLE_SHOW_NAMES'			=> 'Show names',
+++	'GOOGLE_SHOW_NAMES_EXPLAIN'	=> 'If enabled, the language name will be displayed next to its flag.',
+++	
+++	// latest_bots_block
+++	'BOTS_NUMBER'				=> 'Bots to show',
+++	'BOTS_NUMBER_EXPLAIN'		=> 'Maximum number of last visit bots that will be shown in the block.',
+++
+++	// latest_members_block
+++	'MEMBERS_NUMBER'			=> 'Users to show',
+++	'MEMBERS_NUMBER_EXPLAIN'	=> 'Maximum number of users that will be shown in block.',
+++	
+++	// leaders_block
+++	'LEADERS_ALL_GROUPS'			=> 'Show users in all their groups',
+++	'LEADERS_ALL_GROUPS_EXPLAIN'	=> 'If enabled, users will be shown in all groups of which they are members.
+++		Otherwise they will only be shown in their default group.',
+++	'LEADERS_GROUPS'				=> 'Groups',
+++	'LEADERS_GROUPS_EXPLAIN'		=> 'Groups that will be show in the block. If you don\'t select groups, the block will be show the Administrators and Moderators.',
+++	'LEADERS_MODE'					=> 'Display mode',
+++	'LEADERS_MODE_ACCORDION'		=> 'Accordion',
+++	'LEADERS_MODE_SIMPLE'			=> 'Simple List',
+++	'LEADERS_ONLY_ONLINE'			=> 'Online users only',
+++	'LEADERS_ONLY_ONLINE_EXPLAIN'	=> 'If enabled, only users from selected groups who are logged in will be displayed.',
+++
+++	// link_us_block
+++	'US_BANNER'					=> 'Mini banner link',
+++	'US_BANNER_EXPLAIN'			=> 'Mini banner that will be the image that you have to click to access the forum from the link.',
+++
+++	// Login Block
+++ 	'FULL_LOGIN'				=> 'Show Full login',
+++ 	'FULL_LOGIN_EXPLAIN'		=> 'Enable/disable the advanced options in the user identification.',
+++ 	'SHOW_REGISTER'				=> 'Show register',
+++ 	'SHOW_REGISTER_EXPLAIN'		=> 'Display option for the user registration.',
+++	
+++	// map_block
+++	'LATITUDE'					=> 'Latitude',
+++	'LONGITUDE'					=> 'Longitude',
+++	'LOCATION_ADD'				=> 'Add location',
+++	'LOCATION_EDIT'				=> 'Edit location',
+++	'LOCATION_IMAGE'			=> 'Image',
+++	'LOCATION_IMAGE_EXPLAIN'	=> 'Image that will mark the point on the map.<br /><em>If you do not define any, the default mark will be used</em>.',
+++	'LOCATION_INCORRECT'		=> 'he position entered is incorrect.',
+++	'LOCATION_POSITION'			=> 'Position',
+++	'LOCATION_POSITION_EXPLAIN'	=> 'Defines the latitude and longitude of the location.',
+++	'LOCATION_TEXT'				=> 'Content',
+++	'LOCATION_TEXT_EXPLAIN'		=> 'Text to be displayed on the map, by clicking on the location icon.<br /><em>BBcode is allowed.</em>',
+++	'LOCATION_TITLE'			=> 'Title',
+++	'MAP'						=> 'Map',
+++	'MAP_CENTER'				=> 'Central point',
+++	'MAP_CENTER_EXPLAIN'		=> 'Defines the latitude and longitude of the default center point.',
+++	'MAP_LOCATIONS'				=> 'Locations',
+++	'MAP_ZOOM'					=> 'Zoom',
+++	'MAP_ZOOM_EXPLAIN'			=> 'Set the default zoom.',
+++	'SEARCH_ADDRESS'			=> 'Search location',
+++	'SELECT_LOCATION'			=> 'Select location',
+++
+++	// menu_block
+++	'DISPLAY_MENU'				=> 'Menu to show',
+++	'DISPLAY_MENU_EXPLAIN'		=> 'Menu to be displayed in the block. The menu must be previously created in the correct section to be reflected here.',
+++ 	'ICON_WIDTH'				=> 'Icon width',
+++ 	'ICON_WIDTH_EXPLAIN'		=> 'The width of the block icons, in pixels.',
+++
+++	// most_poster_block
+++	'POSTER_LIMIT'				=> 'User Limit',
+++	'POSTER_LIMIT_EXPLAIN'		=> 'The limit of users that are displayed on the block.',
+++ 	'POST_RANGE'				=> 'Message range',
+++ 	'POST_RANGE_EXPLAIN'		=> 'Time limit for the message count.',
+++ 
+++ 	'ALL_POSTS'			=> 'All messages',
+++ 	'LAST_DAY'			=> 'Last day',
+++ 	'LAST_WEEK'			=> 'Last week',
+++ 	'LAST_MONTH'		=> 'Last month',
+++ 	'LAST_YEAR'			=> 'Last year',
+++
+++	// news_block
+++	'NEWS_DISPLAY'				=> 'Information to show',
+++	'NEWS_DISPLAY_EXPLAIN'		=> '<em><strong>Basic content:</strong>Show title, author and date.<br />
+++		<strong>Full content:</strong>Show all news information.</em>',
+++	'NEWS_NUMBER'				=> 'News number',
+++	'NEWS_NUMBER_EXPLAIN'		=> 'Maximum number of news items displayed in the block.',
+++	'NEWS_SIZE'					=> 'News size',
+++	'NEWS_SIZE_EXPLAIN'			=> 'Maximum size of characters allowed in the news. The text of the news will be cut if this value exceeds.',
+++	'NEWS_ALL'					=> 'Show all topics',
+++	'NEWS_ALL_EXPLAIN'			=> 'If enabled, you also read the items marked as "announcement" and "fixed", otherwise, only read the "normal" topics.',
+++	'NEWS_COLLAPSE'				=> 'Collapse news',
+++	'NEWS_COLLAPSE_EXPLAIN'		=> 'If enabled, the block only show one notice and collapse the rest. Otherwise, the news will appear all at once on the block.',
+++	'NEWS_SHOW_FULL'			=> 'Complete content',
+++	'NEWS_SHOW_SIMPLE'			=> 'Basic content',
+++	
+++	// paypal_block
+++	'PAYPAL_ACCOUNT'			=> 'Paypal account',
+++	'PAYPAL_ACCOUNT_EXPLAIN'	=> 'Enter the e-mail address of your Paypal account ex: xxx@xxx.com',
+++	'PAYPAL_ITEM'				=> 'Payment description',
+++	'PAYPAL_ITEM_EXPLAIN'		=> 'Enter the name (description) to which payments will be identified through the block.',
+++	'PAYPAL_MSG'				=> 'Message',
+++	'PAYPAL_MSG_EXPLAIN'		=> 'Customizable message that will appear in the block.<br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+++	'PAYPAL_IMG'				=> 'Button Image',
+++ 	'PAYPAL_IMG_EXPLAIN'		=> 'Image to be used for the "donate" button. Leave this field blank to use the default image.', 
+++	'PAYPAL_AMOUNTS'			=> 'Amounts',
+++	'PAYPAL_AMOUNTS_EXPLAIN'	=> 'Money amount in the select. Split the values with ";" (Ex: 5;10;15).',
+++	'PAYPAL_CURRENCIES'			=> 'Currencies',
+++	'PAYPAL_CURRENCIES_EXPLAIN'	=> 'Type of currency that will be show in the block. You can select more that one and select the default currency.',
+++	
+++	//player block
+++	'PLAYER_AUTOPLAY'			=> 'Autoplay',
+++	'PLAYER_AUTOPLAY_EXPLAIN'	=> 'Defines whether the player will automatically start playing the tracks when the page loads.<br /><br />
+++		<em><strong>Note:</strong>Browsers limit this feature so playback will not begin until the user clicks anywhere on the page.</em>',
+++	'PLAYER_PLAYLIST'			=> 'Show playlist',
+++	'PLAYER_PLAYLIST_EXPLAIN'	=> 'Defines if the playlist is displayed in the player.',
+++	'PLAYER_TRACKLIST'			=> 'Tracklist',
+++	'PLAYER_TRACKLIST_EXPLAIN'	=> 'The player tracks or songs.',
+++
+++	'TRACK_TITLE'			=> 'Track title',
+++	'TRACK_TITLE_EXPLAIN'	=> 'the name or title displayed in the player.',
+++	'TRACK_URL'				=> 'Track URL',
+++	'TRACK_URL_EXPLAIN'		=> 'A radio URL (Ex: http://127.0.0.1:8888), a mp3 or wav audio file (Ex: http://myserver.com/audio.mp3) or a valid playlist file (m3u, asx, pls).',
+++
+++	// poll_block
+++	'DISPLAY_POLL'				=> 'Poll to show',
+++	'DISPLAY_POLL_EXPLAIN'		=> 'Poll displayed in the block.',
+++	'DISPLAY_RESULTS'			=> 'Show results',
+++	'NO_POLLS'					=> 'No polls available',
+++
+++	// poll_random_block
+++	'POLL_FORUM'				=> 'Poll forum',
+++	'POLL_FORUM_EXPLAIN'		=> 'Forum containing the polls that show on the block.',
+++	'POLL_NUM'					=> 'Poll number',
+++	'POLL_NUM_EXPLAIN'			=> 'The number of polls that will be displayed at once within the block.',
+++	'NO_FORUMS'					=> 'No forums avaliable',
+++	
+++	// post_view_block
+++	'PV_ITEM_URL'			=> 'Referral URL',
+++	'PV_ITEM_URL_EXPLAIN'	=> 'Specify here the URL of the forum, topic or message you want to display.<br />
+++		<em><strong>Note:</strong> The url of a forum or topic will display it\'s last message.</em>',
+++	
+++	// quote_of_day_block
+++	'QUOTE_AUTHOR'				=> 'Quote author',
+++	'QUOTE_TEXT'				=> 'Quote Text',
+++	'QUOTES_ALL_DAY'			=> 'Keep all day',
+++	'QUOTES_ALL_DAY_EXPLAIN'	=> 'If enabled, you will see the same quote all day. Otherwise, every time the page loads you will see a different quote.',
+++	'QUOTES_LIST'				=> 'Quote list',
+++	'QUOTES_RAND'				=> 'Random order',
+++	'QUOTES_RAND_EXPLAIN'		=> 'Defines if the quotes are displayed in random order or maintaining the order of the list.',
+++	'QUOTES_SHOW_AUTHOR'		=> 'Show author',
+++	'QUOTES_SHOW_AUTHOR_EXPLAIN'	=> 'Defines whether to display the author of the quote on the block.',
+++	
+++	// ranks_block
+++	'ORPHAN_RANKS'				=> 'Show orphan ranks',
+++	'ORPHAN_RANKS_EXPLAIN'		=> 'If enabled, will show the ranges are not assigned to any user.',
+++	'ONLY_SPECIAL_RANKS'		=> 'Only special ranks',
+++	
+++	// recent_topics_block
+++	'RECENT_FORUMS'					=> 'Topic forums',
+++	'RECENT_FORUMS_EXPLAIN'			=> 'Forums containing items to be displayed. If you do not select any, it will use all the forums. You can select as many as you like using the <em>Ctrl</em> key on your keyboard.',
+++	'RECENT_SECTIONS'				=> 'Sections',
+++	'RECENT_SECTIONS_EXPLAIN'		=> 'Define the sections to be displayed in the block and their order.',
+++	'RECENT_TOPIC_LIMIT'			=> 'Topic limit',
+++	'RECENT_TOPIC_LIMIT_EXPLAIN'	=> 'Maximum number of items to be displayed in each tab.',
+++
+++	// Rss block
+++	'1_HOUR'		=> 'One hour',
+++	'2_HOURS'		=> 'Two hours',
+++	'6_HOURS'		=> 'Siz hours',
+++	
+++	'RSS_COLLAPSABLE'			=> 'Collapsable',
+++	'RSS_COLLAPSABLE_EXPLAIN'	=> 'Sets whether the items are displayed in an accordion or scrolling. If set to "Yes" will override the block scroll.',
+++	'RSS_DIRECTION'				=> 'Scroll direction',
+++	'RSS_DIRECTION_EXPLAIN'		=> 'Defining the direction of scrolling text. This option is canceled if the items are displayed in an accordion.',
+++	'RSS_HEIGHT'				=> 'Block height',
+++	'RSS_HEIGHT_EXPLAIN'		=> 'Sets the height of the block, in pixels. Only apply if items are not displayed in accordion format.',
+++	'RSS_IGNORE_LANG'			=> 'Ignore feed lang',
+++	'RSS_IGNORE_LANG_EXPLAIN'	=> 'If enabled, all URLs are read, regardless of their language, otherwise it will only display the contents written in the language of the user.',
+++	'RSS_LIMIT'					=> 'Feed limit',
+++	'RSS_LIMIT_EXPLAIN'			=> 'Maximum number of items to be read from each URL.',
+++	'RSS_SOURCES'				=> 'Feed sources',
+++	'RSS_TITLE'					=> 'Feed title',
+++	'RSS_TTL'					=> 'Refresh time',
+++	'RSS_TTL_EXPLAIN'			=> 'Time will remain cached items before attempting to read the source again.',
+++	'RSS_URL'					=> 'File url',
+++	'RSS_URL_EXPLAIN'			=> 'Ex: <em>http://midominio.com/rss.xml</em>',
+++
+++	// scroll_message_block
+++	'MARQUEE_DIRECTION'				=> 'Scroll direction',
+++	'MARQUEE_DIRECTION_EXPLAIN'		=> 'Scroll direction for the text. This attribute controls the direction of scrolling.',
+++	'MARQUEE_SPEED'					=> 'Scroll amount',
+++	'MARQUEE_SPEED_EXPLAIN'			=> 'This controls the amount of movement (in pixels) between the successive displays that give the impression of animation.',
+++	'MARQUEE_SCROLLDELAY'			=> 'Scroll delay',
+++	'MARQUEE_SCROLLDELAY_EXPLAIN'	=> 'This controls the delay (in milliseconds) between the successive displays that give the impression of animation.',
+++	'MARQUEE_ALIGN'					=> 'Scroll align',
+++	'MARQUEE_ALIGN_EXPLAIN'			=> 'This tag controls the positioning of the marquee display box relative to the current text in exactly the same manner as the img tag\'s align attribute.',
+++	'MARQUEE_BGCOLOR'				=> 'Scroll bgcolor',
+++	'MARQUEE_BGCOLOR_EXPLAIN'		=> 'This tag controls the background colour of the display box.',
+++	'MARQUEE_HEIGHT'				=> 'Scroll height',
+++	'MARQUEE_HEIGHT_EXPLAIN'		=> 'This controls the height of the display box.',
+++	'MARQUEE_PADDING'				=> 'ScrollBox Padding',
+++	'MARQUEE_PADDING_EXPLAIN'		=> 'Space around the scroll box. This attribute is equivalent to the attribute "padding" of CSS.',
+++	'MARQUEE_TEXT'					=> 'Scroll message text',
+++	'MARQUEE_TEXT_EXPLAIN'			=> 'Add/change a scrollable message here. Limit 2000 characters.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+++
+++	'BOTTOM'		=> 'Bottom',
+++	'DOWN'			=> 'Down',
+++	'LEFT'			=> 'Left',
+++	'CENTER'		=> 'Center',
+++	'UP'			=> 'Up',
+++	'RIGHT'			=> 'Right',
+++	'TOP'			=> 'Top',
+++	
+++	//share_block
+++	'SHARE_SHOW_NAMES'			=> 'Show names',
+++	'SHARE_SHOW_NAMES_EXPLAIN'	=> 'If enabled, the name of the social network will be displayed next to its icon.',
+++	'SHARE_URL'					=> 'Reference URL',
+++	'SHARE_URL_EXPLAIN'			=> 'Set a fixed reference url for the buttons. Leave this field blank to use the displayed page.',
+++	'SHARE_BUTTONS'				=> 'Buttons to show',
+++	
+++	// stats_block
+++	'STATS_INLINE'			=> 'Show data in line',
+++ 	'USER_STATS'			=> 'Display user statistics',
+++	
+++	// top_topics_block
+++	'TOPT_LIMIT'			=> 'Topic limit',
+++	'TOPT_LIMIT_EXPLAIN'	=> 'Maximun number of topic to show.',
+++	'TOPT_MODE'				=> 'Topic to show',
+++	'TOPT_MODE_ACTIVE'		=> 'Latest topics more active',
+++	'TOPT_MODE_UNREAD'		=> 'Latest unread topics',
+++	'TOPT_MODE_VIEWED'		=> 'More viewed topics',
+++
+++	// topic_index_block
+++	'TINDEX_CHAR_SELECT'			=> 'Show Index',
+++	'TINDEX_CHAR_SELECT_EXPLAIN'	=> 'Only avaliable if the sort method is <em>Topic title</em>.',
+++	'TINDEX_PER_PAGE'			=> 'Topics per page',
+++	'TINDEX_PER_PAGE_EXPLAIN'	=> 'Number of topics that will be show at the same time. Set 0 to disable pagination.',
+++	'TINDEX_SORT_MODE'			=> 'Order by',
+++	'TINDEX_SORT_MODE_EXPLAIN'	=> 'Method that will be used to set the topic\'s order in the list.',
+++  
+++	'TOPIC_TIME'		=> 'Topic date',
+++	'LAST_POST_TIME'	=> 'Last post date',
+++
+++	// welcome_block
+++	'WELCOME_GUEST'				=> 'Guests message',
+++	'WELCOME_GUEST_EXPLAIN'		=> 'Message to display to all guests. 2000 characters max.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+++	'WELCOME_MEMBER'			=> 'Members message',
+++	'WELCOME_MEMBER_EXPLAIN'	=> 'Message to display to all the forum registered users. 2000 characters max.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+++
+++	// whos_online_block
+++	'WHOS_ADVANCED'				=> 'Advanced mode',
+++	'WHOS_ADVANCED_EXPLAIN'		=> 'If enabled, will display all the information, otherwise it will appear only basic information (suitable for side blocks).',
+++	'WHOS_USERNAMES'			=> 'Show user list',
+++	'WHOS_USERNAMES_EXPLAIN'	=> 'If enabled, displays the list of users online (only in advanced mode).',
+++
+++	// youtube_block
+++	'YT_AUTOPLAY'				=> 'AutoPlay enabled',
+++	'YT_AUTOPLAY_EXPLAIN'		=> 'If enabled, the video will play automatically.<br />If you have multiple videos, only the first autoplay.',
+++	'YT_DISPLAY_MODE'			=> 'Display Mode',
+++	'YT_FULL_PREVIEW'			=> 'Show thumbnails, title and description',
+++	'YT_LIST'					=> 'Show a list with titles',
+++	'YT_RANDOM_DISPLAY'			=> 'Random Display',
+++	'YT_RANDOM_DISPLAY_EXPLAIN'	=> 'If enabled, only one video will be appear randomly. Otherwise, all the videos and channels appear at once.',
+++	'YT_RESULT_LIMIT'			=> 'Number of channel videos',
+++	'YT_RESULT_LIMIT_EXPLAIN'	=> 'Maximun number of videos loaded in each channel.',
+++	'YT_SIMPLE_PREVIEW'			=> 'Show thumbnails and titles',
+++	'YT_TEXT_LIMIT'				=> 'Text limit',
+++	'YT_TEXT_LIMIT_EXPLAIN'		=> 'Maximun number of characters in the video description.',
+++	'YT_VIDEO_PREVIEW'			=> 'Show video preview',
+++	'YT_VIDEO_SIZE'				=> 'Player size',
+++	'YT_VIDEO_TITLE'			=> 'Video title',
+++	'YT_VIDEO_URL'				=> 'Video url',
+++	'YT_VIDEO_URL_EXPLAIN'		=> 'Ex: <em>https://www.youtube.com/watch?v=NHH_v0k7Gus</em>',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/chat_addon.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/chat_addon.php"
++new file mode 100644
++index 000000000..726889601
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/chat_addon.php"
++@@ -0,0 +1,32 @@
+++<?php
+++/** 
+++* chat_addon.php [English [En]]
+++*
+++* @package language cBB Blockgets
+++* @version v2.0.1 04/05/2018
+++*
+++* @copyright (c) 2018 CaniDev
+++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+++*/
+++
+++// @ignore
+++if(!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if(empty($lang['blocks']))
+++{
+++	$lang['blocks'] = array();
+++}
+++
+++$lang['blocks'] = array_merge($lang['blocks'], array(
+++	'chat_title'	=> 'Chat',
+++	'chat_explain'	=> 'Allows you to use cBB Chat as a block in the columns or show the users connected to the chat.',
+++));
+++
+++$lang = array_merge($lang, array(
+++	'CHAT_ADDON_MODE'		=> 'Display mode',
+++	'CHAT_MODE_CHAT'		=> 'Chat room',
+++	'CHAT_MODE_USERS'		=> 'Online Users',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/email/contact_block.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/email/contact_block.txt"
++new file mode 100644
++index 000000000..5ee2e8c3e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/email/contact_block.txt"
++@@ -0,0 +1,6 @@
+++
+++The following is an e-mail sent to you from "{SITENAME}" for {FROM_USERNAME} by the contact form:
+++
+++----------
+++
+++{MESSAGE}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/info_acp_blockgets.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/info_acp_blockgets.php"
++new file mode 100644
++index 000000000..263814a48
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/info_acp_blockgets.php"
++@@ -0,0 +1,53 @@
+++<?php
+++/*
+++* info_acp_blockgets.php [English [En]]
+++* @package cBB Blockgets
+++* @version v2.0.2 12/01/2021
+++*
+++* @copyright (c) 2021 CaniDev
+++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+++*/
+++
+++// @ignore
+++if(!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++/**
+++ * @general tags and messages
+++*/
+++$lang = array_merge($lang, array(
+++	'ACP_BLOCKGETS'				=> 'Blockgets',
+++	'ACP_BLOCKGETS_GENERAL'		=> 'General',
+++	
+++	'ACP_BLG_CONFIG_MAIN'		=> 'General configuration',
+++	'ACP_BLG_CONFIG_OPTIONAL'	=> 'Additional configuration',
+++	'ACP_BLG_IMAGES'			=> 'Images',
+++	'ACP_PAGES_AND_BLOCKS'		=> 'Pages and Blocks',
+++	
+++	// Logs
+++	'LOG_BLG_CONFIG'		=> '<strong>cBB Blockgets:</strong> Changed main configuration',
+++	'LOG_BLOCK_ADDED'		=> '<strong>cBB Blockgets:</strong> New block added<br />» %1$s in %2$s',
+++	'LOG_BLOCK_COPY_PAGE'	=> '<strong>cBB Blockgets:</strong> Blocks copied<br />» de %1$s a %2$s',
+++	'LOG_BLOCK_MOVED'		=> '<strong>cBB Blockgets:</strong> Changed blocks position<br />» %1$s',
+++	'LOG_BLOCK_MOVED_PAGE'	=> '<strong>cBB Blockgets:</strong> Blocks moved<br />» from %1$s to %2$s',
+++	'LOG_BLOCK_REMOVED'		=> '<strong>cBB Blockgets:</strong> Block(s) deleted<br />» en %1$s',
+++	'LOG_BLOCK_UPDATED'		=> '<strong>cBB Blockgets:</strong> Block edited<br />» %1$s en %2$s',
+++	'LOG_EVENT_REMOVED'		=> '<strong>cBB Blockgets:</strong> Event deleted<br />» %1$s',
+++	'LOG_LIST_REMOVED'		=> '<strong>cBB Blockgets:</strong> List deleted<br />» %1$s',
+++	'LOG_PAGE_ADDED'		=> '<strong>cBB Blockgets:</strong> New page added<br />» %1$s',
+++	'LOG_PAGE_UPDATED'		=> '<strong>cBB Blockgets:</strong> Changed page<br />» %1$s',
+++	'LOG_PAGE_REMOVED'		=> '<strong>cBB Blockgets:</strong> Page deleted<br />» %1$s',
+++	
+++	// Permissions
+++	'ACL_A_BLOCKGETS_MANAGE'	=> 'Can manage cBB Blockgets',
+++	'ACL_U_BLOCKGETS_BIRTHDAYS'	=> 'Can see birthdays in the Calendar',
+++	'ACL_U_BLOCKGETS_CALENDAR'	=> 'Can view calendar',
+++	'ACL_U_BLOCKGETS_EVENTS'	=> 'Can manage calendar events',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/installer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/installer.php"
++new file mode 100644
++index 000000000..f9a800fc4
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/installer.php"
++@@ -0,0 +1,43 @@
+++<?php
+++/*
+++* installer.php [English [En]]
+++* @package cBB Blockgets
+++* @version v2.0.2 12/01/2021
+++*
+++* @copyright (c) 2021 CaniDev
+++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+++*/
+++
+++// @ignore
+++if(!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if(empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++// Local Variables
+++$lang = array_merge($lang, array(
+++	'PORTAL'			=> 'Portal',
+++	'DOCK_MENU'			=> 'Dock menu',
+++	'MAIN_MENU'			=> 'Main Menu',
+++	'RECOMMENDED'		=> 'Recommended',
+++
+++	'P_ADMIN'			=> 'Administration',
+++	'P_MAIN'			=> 'Main',
+++	'P_MCP'				=> 'Moderation Panel',
+++	'P_ACP'				=> 'Administration Panel',
+++
+++	'PHPBB_TITLE'		=> 'phpBB official website',
+++	'XAMPP_TITLE'		=> 'Xampp',
+++	'SOURCEFORGE_TITLE'	=> 'Open source applications',
+++
+++	'WELCOME_GUEST'		=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Forum equipped with cBB Blockgets</i><br /><br />Welcome to our forum!<br />Register to access all the content!.</strong></div>[/html]',
+++	'WELCOME_MEMBER'	=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Forum equipped with cBB Blockgets</i><br /><br />Welcome back to our forum {S_USERNAME}</strong></div>[/html]',	
+++
+++	'CORE_INSTALL_ERROR'	=> 'You have not uploaded all the files from the installation package or you are trying to install an old package.<br />
+++		Please make sure to upload all the files (including the <em>core</em> folder) and use a package downloaded from the official website.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/main.php"
++new file mode 100644
++index 000000000..9100727fa
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt/main.php"
++@@ -0,0 +1,269 @@
+++<?php
+++/*
+++* main.php [English [En]]
+++* @package cBB Blockgets
+++* @version v2.0.2 12/01/2021
+++*
+++* @copyright (c) 2021 CaniDev
+++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+++*/
+++
+++// @ignore
+++if(!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if(empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'PORTAL'			=> 'Portal',
+++	'READ_FULL'			=> 'Read full topic',
+++	'BLG_READ_MORE'		=> '%sLer mais%s',
+++
+++	'ADD_PAGE'					=> 'Criar página',
+++	'BANNERS'					=> 'Banners',
+++	'CALENDAR'					=> 'Calendário',
+++	'CALENDAR_BIRTHDAY_TITLE'	=> '%1$s e <strong>mais %2$d</strong>.',
+++	'CALENDAR_SELECT_DATE'		=> 'Seleccionar data',
+++	'EDIT_CONFIGURATION'		=> 'Editar configuração',
+++	'EDIT_THIS_PAGE'			=> 'Editar esta página',
+++	'EDITOR'					=> 'Editor',
+++	'EXPAND_CONTRACT'			=> 'Expandir/colapsar',
+++	'INSERT_ON_ENTRY'			=> 'Inserir no texto',
+++	'MANAGE_BLOCKS'				=> 'Gerir blocos',
+++	'PRINT'						=> 'Imprimir',
+++	'SELECT_COLOUR'				=> 'Seleccionar cor',
+++	'SMILIES'					=> 'Emoticons',
+++	'TODAY'						=> 'Hoje',
+++
+++	// Editor
+++	'HTML_TITLE' 		=> 'Html:',
+++	'INSERT_HTML' 		=> 'Inserir Código HTML',
+++
+++	// Login Block
+++	'HIDE_ME_NOW'			=> 'Hide me in this session',
+++	'MY_BOOKMARKS'			=> 'Favoritos',
+++	'MY_SUBSCRIBED'			=> 'Subscrições',
+++	'REMEMBER_ME'			=> 'Lembrar-me',
+++
+++	// Link Us Block
+++	'LINK_US_TXT'			=> 'Please feel free to link to <strong>%s</strong>. Use the following HTML:',
+++
+++	// Stats Block and whos_online block
+++	'GUEST_VISITS_TOTAL'		=> '%d Visitantes',
+++	'GUEST_VISIT_TOTAL'			=> '%d Visitante',
+++	'HIDDEN_VISITS_TOTAL'		=> '%d ocultos, ',
+++	'HIDDEN_VISIT_TOTAL'		=> '%d oculto, ',
+++	'LASTVISIT_VISITS_TOTAL'	=> 'In total there were <strong>%d</strong> users online in the last 24 hours :: ',
+++	'LASTVISIT_VISIT_TOTAL'		=> 'In total there is <strong>%d</strong> user online in the last 24 hours  :: ',
+++	'REG_VISITS_TOTAL'			=> '%d Registados, ',
+++	'REG_VISIT_TOTAL'			=> '%d Registado, ',
+++
+++	'ST_ACTIVE_POSTERS'			=> 'Active posters',
+++	'ST_ANNS'					=> 'Announcements',
+++	'ST_ATTACHMENTS'			=> 'Anexos',
+++	'ST_BOARD_STARTDATE'		=> 'Start date',
+++	'ST_NEW'					=> 'Novo',
+++	'ST_NEWEST_USER'			=> 'Último membro',
+++	'ST_POSTS'					=> 'Mensagens',
+++	'ST_POSTS_PER_DAY'			=> 'Mensagens por dia',
+++	'ST_POSTS_PER_TOPIC'		=> 'Mensagens por tópico',
+++	'ST_POSTS_PER_USER'			=> 'Mensagens por utilizador',
+++	'ST_STICKYS'				=> 'Importantes',
+++	'ST_TOP'					=> 'Total',
+++	'ST_TOPICS'					=> 'Tópicos',
+++	'ST_TOPICS_PER_DAY'			=> 'Tópicos por dia',
+++	'ST_TOPICS_PER_USER'		=> 'Tópicos por utilizador',
+++	'ST_TOTAL_USERS'			=> 'Total utilizadores',
+++	'ST_USERS_PER_DAY'			=> 'Utilizadores por dia',
+++	'ST_VISIT_IP'				=> 'O teu IP',
+++
+++	'WIO_ONLINE'			=> 'Utilizadores online',
+++	'WIO_LASTDAY'			=> 'Utilizadores hoje',
+++	'WIO_TOTAL'				=> 'Total',
+++	'WIO_REGISTERED'		=> 'Registados',
+++	'WIO_HIDDEN'			=> 'Ocultos',
+++	'WIO_GUEST'				=> 'Visitantes',
+++
+++	// polls
+++	'NO_POLL'			=> 'Votação indisponível',
+++
+++	// attachments_block
+++	'ATTACH_DATE'			=> 'Publicado',
+++	'ATTACH_SIZE'			=> 'Tamanho',
+++	'ATTACH_DOWNLOAD'		=> 'Transferido',
+++	'ATTACH_VIEW'			=> 'Visto',
+++
+++	'ATTACH_COUNT'				=> array(
+++		0	=> 'Nunca',
+++		1	=> '%d vez',
+++		2	=> '%d vezes',
+++	),
+++
+++	'VIEW_TOPIC'				=> 'Ver Tópico',
+++	'DOWNLOAD'					=> 'Download',
+++	'NO_ATTACHMENTS'			=> 'Sem anexos disponíveis',
+++
+++	// language_select_block
+++	'LANGUAGE_CHANGE'		=> 'Alterar idioma',
+++	'LANGUAGE_DEFAULT'		=> 'Idioma Original',
+++	'LANGUAGE_SET_MINE'		=> 'Gravar como meu idioma',
+++	'LANGUAGE_SELECT'		=> 'Selecionar Idioma',
+++
+++	// news_block
+++	'POSTED_BY'			=> 'Criado por',
+++	'LAST_REPLIED_BY'	=> 'Última resposta por',
+++	'COMMENTS_PORTAL'	=> 'Comentários',
+++	'POLL'				=> 'Votação',
+++	'TOPIC_VIEWS'		=> 'Visto',
+++	'NO_NEWS'			=> 'Sem notícias disponíveis',
+++	'VIEW_COMMENTS'		=> 'Ver comentários',
+++
+++	// recent_topics_block
+++	'BLG_RECENT_ACTIVITY'	=> 'Actividade Recente',
+++	'BLG_RECENT_ANN'		=> 'Anúncios Recentes',
+++	'BLG_RECENT_TOPICS'		=> 'Tópicos Recentes',
+++
+++	// paypal_block
+++	'AMOUNT_MSG'		=> 'Amount to donate',
+++	'CLICK_MSG'			=> 'Proceed to donation',
+++	'CODE_MSG'			=> 'Currency',
+++	
+++	'currencies'	=> array(
+++		'AUD'	=> 'Aussie',
+++		'CAD' 	=> 'Canadian Dollar',
+++		'CZK' 	=> 'Czech Koruna',
+++		'DKK' 	=> 'Danish Kroner',
+++		'HKD' 	=> 'Hong Kong Dollar',
+++		'HUF' 	=> 'Hungarian Forint',
+++		'NZD' 	=> 'New Zealand Dollar',
+++		'NOK' 	=> 'Norwegian Kroner',
+++		'PLN' 	=> 'Polish Zlotych',
+++		'GBP' 	=> 'British Pounds',
+++		'SGD' 	=> 'Singapore Dollar',
+++		'SEK' 	=> 'Swedish Kronor',
+++		'CHF' 	=> 'Swiss Francs',
+++		'JPY' 	=> 'Japanese Yen',
+++		'USD' 	=> 'Dollar',
+++		'EUR' 	=> 'Euro',
+++		'AUD' 	=> 'Mexican Peso',
+++		'ILS' 	=> 'New Israeli Shekels'
+++	),
+++
+++	// most_poster_block
+++	'MEMBER_POSTS'		=> '%d (%.2f/dia)',
+++	'USER'				=> 'Utilizador',
+++	'NO_MOST_POSTER'	=> 'Sem utilizadores para exibir',
+++
+++	// contact block
+++	'EMAIL_EMPTY'		=> 'You must set an email.',
+++	'EMAIL_INVALID'		=> 'The entered email is invalid.',
+++
+++	// counter block
+++	'COUNTER_LOCAL'		=> 'Visits to this page',
+++	'COUNTER_TOTAL' 	=> 'Total visits',
+++	'COUNTER_STARTDATE' => 'Counting from:<br />%s',
+++	'HITS_PER_DAY'		=> 'Visits per day',
+++	'HITS_PER_HOUR'		=> 'Visits per hour',
+++	'HITS_PER_MONTH'	=> 'Visits per month',
+++	'HITS_PER_USER'		=> 'Visits per user',
+++	'HITS_PER_WEEK'		=> 'Visits per week',
+++	'HITS_PER_YEAR'		=> 'Visits per year',
+++
+++	// style_select_block
+++	'STYLE_CHANGE'		=> 'Change Style',
+++	'STYLE_DEFAULT'		=> 'Original style',
+++	'STYLE_SET_MINE'	=> 'Set as my style',
+++	'STYLE_SELECT'		=> 'Select style',
+++
+++	// latest_bots_block
+++	'NO_BOTS'			=> 'Nenhum bot visitou o fórum',
+++
+++	// latest_unread_block
+++	'NO_UNREAD'			=> 'Sem tópicos',
+++
+++	// ranks_block
+++	'MIN_POSTS'			=> 'Minimum Posts',
+++	'SPECIAL_RANK'		=> 'Special Rank',
+++
+++	// online_friends_block
+++	'FRIENDS_ONLINE'		=> 'Online friends',
+++	'FRIENDS_OFFLINE'		=> 'Offline friends',
+++	'NO_FRIENDS_ONLINE'		=> 'No friends online',
+++	'NO_FRIENDS_OFFLINE'	=> 'No friends offline',
+++	'NO_FRIENDS'			=> 'No friends found',
+++
+++	// age_ranges_block
+++	'RANGE'				=> 'Rank',
+++	'RANGE_USERS'		=> 'Utilizadores (%)',
+++	'AGE_COUNTS'		=> 'Utilizadores contados',
+++	'AGE_AV'			=> 'Idade média',
+++	'AGE_AV_COUNT'		=> '%.2f anos',
+++
+++	// search_block
+++	'SH_ENGINE'			=> 'Search Engines',
+++
+++	// announcements_block
+++	'NO_ANNOUNCEMENTS'	=> 'Sem Anúncios',
+++
+++	//birthday_block
+++	'TODAY_BIRTHDAYS'		=> 'Today Birthdays',
+++	'TOMORROW_BIRTHDAYS'	=> 'Tomorrow Birthdays',
+++	'BIRTHDAYS_FOR'			=> 'Birthdays for %1$s of %2$s',
+++
+++	// calendar
+++	'ADD_EVENT'				=> 'Adicionar evento',
+++	'DELETE_EVENT'			=> 'Remover Evento',
+++	'EDIT_EVENT'			=> 'Editar Evento',
+++	'EVENTS'				=> 'Eventos',
+++
+++	'EMPTY_EVENT_TITLE'	=> 'Tem de colocar um título para o evento.',
+++	'EVENT_ADDED'		=> 'Evento adicionado com sucesso',
+++	'EVENT_COLOR'		=> 'Cor',
+++	'EVENT_EDITED'		=> 'Evento editado com sucesso',
+++	'EVENT_GROUPS'		=> 'Grupos autorizados',
+++	'EVENT_TITLE'		=> 'Título do Evento',
+++	'EVENT_TIME'		=> 'Data do Evento',
+++	'EVENT_DETAILS'		=> 'Detalhes',
+++	'EVENT_REMOVED'		=> 'Evento removido com sucesso',
+++	'NO_EVENTS'			=> 'Sem eventos',
+++	
+++	//player block
+++	'MUTE'				=> 'Silenciar',
+++	'WIN_CLOSE'			=> 'Fechar janela e regressar ao bloco',
+++	'WIN_OPEN'			=> 'Abrir numa nova janela',
+++	'WIN_OPEN_EXPLAIN'	=> 'Playing in Window',
+++	'WIN_RETURN'		=> 'Forze player in the block',
+++	'PLAY'				=> 'Play',
+++	'PLAY_MSG'			=> 'Playing',
+++	'PLAYER'			=> 'Player',
+++	'STOP'				=> 'Parar',
+++	'STOP_MSG'			=> 'Parou',
+++	'VOLUME'			=> 'Volume',
+++	'VOLUME_MSG'		=> 'Volume: %d%',
+++	
+++	// rss block
+++	'NO_RSS'		=> 'Sem Rss/Feed para mostrar.',
+++
+++	// topic index block
+++	'CHAR_ALL'		=> 'Todos',
+++	
+++	// youtube block
+++	'YT_EMPTY'		=> 'Sem vídeos para mostrar',
+++	'YT_VIEWS'		=> '%d vistos',
+++));
+++
+++// General messages
+++$lang = array_merge($lang, array(
+++	'ACTION_ERROR'		=> 'No action taken',
+++	'BLOCK_LOAD_ERROR'	=> 'Failed to load block',
+++	'FORMAT_INVALID'	=> 'The format is not valid',
+++	'EVENT_ERROR'		=> 'The selected event does not exist',
+++	'NO_TRACKLIST'		=> 'No avaliable tracklist.',
+++	'NO_PAGE'			=> 'This page no exists.',
+++	'URL_INVALID'		=> 'The URL is not valid.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/acp.php"
++new file mode 100644
++index 000000000..2006342cf
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/acp.php"
++@@ -0,0 +1,357 @@
+++<?php
+++/*
+++* acp.php [English [En]]
+++* @package cBB Blockgets
+++* @version v2.0.2 12/01/2021
+++*
+++* @copyright (c) 2021 CaniDev
+++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+++*/
+++
+++// @ignore
+++if(!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++// @acp_blockgets
+++$lang = array_merge($lang, array(
+++	'BLG_CONFIG_TITLE'				=> 'General configuration',
+++	'BLG_CONFIG_EXPLAIN'			=> 'Thank you for choosing cBB Blockgets as a complement for your forum!<br />From here you can set the main settings of the extension.<br />Lateral links allow you to access all the options to set comfortably the mod.',
+++	'BLG_IMAGES_TITLE'				=> 'Available images',
+++	'BLG_OPTIONAL_TITLE'			=> 'Additional configuration',
+++	'BLG_OPTIONAL_EXPLAIN'			=> 'From here you can set additional settings for the site.',
+++	
+++	'BLG_ADMIN_BAR'					=> 'Show quick access bar',
+++	'BLG_ADMIN_BAR_EXPLAIN'			=> 'If enabled, a bar will be displayed at the top of the forum that will allow you to quickly access the options of the page where you are.',
+++	'BLG_BLOCK_AUTOFIT'				=> 'AutoFit blocks',
+++	'BLG_BLOCK_AUTOFIT_EXPLAIN'		=> 'If enabled, the content and disposition of the blocks will be adjust to the column.',
+++	'BLG_COLLAPSE'					=> 'Allow collapse blocks',
+++	'BLG_COLLAPSE_EXPLAIN'			=> 'Enable/disable globally the possibility that each user can collapse/expand blocks individually. This option overwrite the individual block\'s configuration.',
+++	'BLG_FULL_EDITOR'				=> 'Full editor',
+++	'BLG_ON_BOARD'					=> 'Blocks within the forum',
+++	'BLG_ON_BOARD_EXPLAIN'			=> 'Sets whether to display the blocks into the forum pages. This option overwrite the invidual page\'s configuration.<br /><br />
+++		<em>
+++			&nbsp;&nbsp;<strong>Not show:</strong> It does not show blocks on any page.<br />
+++			&nbsp;&nbsp;<strong>Individual pages:</strong> It shows the blocks on the pages configured for it.<br />
+++			&nbsp;&nbsp;<strong>Equal pages:</strong> The "General Index" blocks are shown on all pages.
+++		</em>',
+++	'BLG_REDIRECTIONS'				=> 'Redirections',
+++	'BLG_REDIRECT_404'				=> 'Page not found',
+++	'BLG_REDIRECT_404_EXPLAIN'		=> 'Sets the page to which the user will be taken when trying to access a location that does not exist.<br />
+++		<em>Replace the message No route found for "GET" of phpBB.</em>',
+++	'BLG_REDIRECT_LOGIN'			=> 'Login',
+++	'BLG_REDIRECT_LOGIN_EXPLAIN'	=> 'Sets the page to which the user will be taken after login to the forum.',
+++	'BLG_REDIRECT_LOGOUT'			=> 'Logout',
+++	'BLG_REDIRECT_LOGOUT_EXPLAIN'	=> 'Sets the page to which the user will be taken when disconnecting.',
+++
+++	'DEFAULT'					=> 'By default',
+++	'LINKS'						=> 'Links',
+++	'OPEN_GALLERY'				=> 'Open gallery',
+++	'SAVE_AND_ADD'				=> 'Save and add more',
+++	'TYPE_DOMAIN_HOME'			=> 'Domain\'s main page',
+++	'TYPE_FORUM_HOME'			=> 'Forum\'s main page',
+++	'TYPE_FORUM_SECONDARY'		=> 'Forum\'s secondary page',
+++
+++	'BOARD_BLOCK_INDIVIDUAL'	=> 'Individual pages',
+++	'BOARD_BLOCK_NONE'			=> 'Not show',
+++	'BOARD_BLOCK_SAME'			=> 'Equal pages',
+++
+++	'AVATAR_RESIZE_WIDTH'			=> 'Size of avatars',
+++	'AVATAR_RESIZE_WIDTH_EXPLAIN'	=> 'Maximum size allowed (in pixels) for avatars.<br />
+++		<em>Set 0 to disable avatar resizing</em>.',
+++	'CALENDAR'						=> 'Calendar',
+++	'CALENDAR_ENABLED'				=> 'Calendar enabled',
+++	'CALENDAR_ENABLED_EXPLAIN'		=> 'Defines whether the calendar will be available in both the<em>/calendar path</em> and blocks.',
+++	'CALENDAR_BIRTHDAYS'			=> 'Show Birthdays',
+++	'CALENDAR_BIRTHDAYS_EXPLAIN'	=> 'If enabled, user\'s birthdays will be marked and displayed on the calendar, as if they were events.',
+++	'CALENDAR_LINK'					=> 'Link',
+++	'CALENDAR_LINK_EXPLAIN'			=> 'Define in which part of the forum a link to the calendar will appear.',
+++	'CALENDAR_FIRST_DAY'			=> 'First day of the week',
+++	'CALENDAR_FIRST_DAY_EXPLAIN'	=> 'Define the first day of the week on the calendar.',
+++	'COUNTER'						=> 'Hit Counter',
+++	'COUNTER_RESET'					=> 'Reset hit counter',
+++	'COUNTER_RESET_EXPLAIN'			=> 'Sets the visits to 0 and the counter start to the current date.',
+++	'HOME_TYPE_DISPLAY'				=> 'Behavior of the home page',
+++	'HOME_TYPE_DISPLAY_EXPLAIN'		=> 'Sets how the home page will work, if it is enabled.',
+++	'IMAGE_RESIZE'					=> 'Resize images',
+++	'IMAGE_RESIZE_POST'				=> 'Resize images in posts',
+++	'IMAGE_RESIZE_POST_EXPLAIN'		=> 'Enable/Disable the resize in the images inside the forum posts.',
+++	'IMAGE_RESIZE_WIDTH'			=> 'Images max size',
+++	'IMAGE_RESIZE_WIDTH_EXPLAIN'	=> 'Maximum size (in pixels) for images. The default is 450.<br />
+++		<em>Set 0 to disable image resizing</em>.',
+++
+++	'INDEX_FILE_ERROR'				=> 'Failed to complete setup',
+++));
+++
+++// @acp_blockgets_lists
+++$lang = array_merge($lang, array(
+++	'ADD_ITEM'				=> 'Add item',
+++	'CAT'					=> 'Category',
+++
+++	'LINK'						=> 'Link',
+++	'LINK_DESCRIPTION'			=> 'Description',
+++	'LINK_DESCRIPTION_EXPLAIN'	=> 'This text will be show in some blocks as aditional link information.',
+++	'LINK_GROUP'				=> 'Groups',
+++	'LINK_GROUP_EXPLAIN'		=> 'Select groups of users that can see this link in the menu.<br />You can select multiple groups using the <em>Ctrl</em> key on your keyboard.',
+++	'LINK_IMG'					=> 'Image',
+++	'LINK_TITLE'				=> 'Link title',
+++	'LINK_TITLE_EXPLAIN'		=> 'Title that identifies the link. Limit 100 characters.',
+++	'LINK_TYPE'					=> 'Link type',
+++	'LINK_URL'					=> 'Link URL',
+++	'LINK_URL_EXPLAIN'			=> 'The direction that opens when you click on the link. Limit 255 characters.',
+++	'LINK_WINDOW'				=> 'Open in New Window',
+++));
+++
+++// @acp_blockgets_pages
+++$lang = array_merge($lang, array(
+++	'ADD_BLOCK'					=> 'Add block',
+++	'ADD_BLOCK_TIP'				=> 'Drag a block to the position you want to add it.',
+++	'ADD_BLOCK_TITLE'			=> 'Add block :: %1$s',
+++	'ADD_BLOCK_TITLE_EXPLAIN'	=> 'From here you can add a new block to your forum and set its configuration. You can also set additional settings, if the block you need.',
+++	'ADD_GROUP'					=> 'Add group',
+++	'ADD_GROUP_EXPLAIN'			=> 'Drag this button to the desired position to add a group',
+++	'ADVANCED_OPTIONS'			=> 'Advanced options',
+++
+++	'BLOCK_SETTINGS'			=> 'General options for the block',
+++	'BLOCK_SPACE'				=> 'Space between blocks',
+++	'BLOCK_SPACE_EXPLAIN'		=> 'Value in pixels or percentage. The minimun value is 1.',
+++	'BOTTOM_COLUMN'				=> 'Bottom column',
+++	'CENTER_COLUMN'				=> 'Center column',
+++	'CHG_GROUPS_BLOCK'			=> 'Change permissions',
+++	'CHG_GROUP_EXPLAIN'			=> 'Choose groups who can see the selected blocks',
+++	'COLUMN_SETTINGS'			=> 'Options for the columns',
+++	'COPY_BLOCK'				=> 'Copy to other page',
+++	'DELETE_BLOCK_CONFIRM'		=> 'Are you sure you want to delete the selected blocks?',
+++	'DISABLE_BLOCK'				=> 'Disable',
+++	'EDIT_BLOCK_TITLE'			=> 'Edit block :: %1$s',
+++	'EDIT_BLOCK_TITLE_EXPLAIN'	=> 'Here you can edit the configuration of the block, as well as additional settings, if the block you need.',
+++	'ENABLE_BLOCK'				=> 'Enable',
+++	'EXT_ROUTES'				=> 'Extension\'s routes',
+++	'FILTER_TYPE_GET'			=> 'Url (GET)',
+++	'FILTER_TYPE_POST'			=> 'Form (POST)',
+++	'FORUM_FILES'				=> 'Forum files',
+++	'LEFT_COLUMN'				=> 'Left column',
+++	'LEFT_COLUMN_EXPLAIN'		=> 'Width of the left column in pixels or percentage.<br />Set 0 to disable the column.',
+++	'LINK_BOTTOM'				=> 'Bottom',
+++	'LINK_QUICK'				=> 'Quick links',
+++	'LINK_NONE'					=> 'No link',
+++	'LINK_TOP'					=> 'Top',
+++	'MANAGE_PAGE'				=> 'Manage page',
+++	'MOVE_BLOCK'				=> 'Move to other page',
+++	'NO_PAGES_CREATED'			=> 'No pages created.',
+++	'NO_PAGE_FILTERS'			=> 'No filters',
+++	
+++	'PAGE'						=> 'Page',
+++	'PAGE_ADD'					=> 'New page',
+++	'PAGE_ALIAS'				=> 'Page alias',
+++	'PAGE_ALIAS_EXPLAIN'		=> 'You can set an alias (letters, numbers and dashes) to create a separate page.<br />If you leave this field blank, it will create a separate page and will be used the ID as alias.',
+++	'PAGE_ALIAS_ERROR'			=> 'The value inserted in "Alias page" field contains illegal characters or an invalid path.',
+++	'PAGE_BACKGROUND'			=> 'Page background',
+++	'PAGE_BACKGROUND_EXPLAIN'	=> 'You can set a color (ex. white, #FFFFFF) or an image (ex. http://mydomain.com/image.jpg). Leave this field blank to use the default background.',
+++	'PAGE_CUSTOM'				=> 'Custom Pages',
+++	'PAGE_CUSTOM_EXPLAIN'		=> 'These are pages created by you or another administrator of this site. You can add, edit and manage as many pages as you wish.',
+++	'PAGE_CUSTOM_ONE'			=> 'Custom Page',
+++	'PAGE_DESCRIPTION'			=> 'SEO Description',
+++	'PAGE_DESCRIPTION_EXPLAIN'	=> 'Defines a description visible to search engines.<br /><em>Google, bing, etc...</em>',
+++	'PAGE_ENABLED'				=> 'Page enabled',
+++	'PAGE_ENABLED_EXPLAIN'		=> 'Enable or disable the page functions completely. This option overrides all others.',
+++	'PAGE_FILTERS'				=> 'Filters',
+++	'PAGE_FILTERS_EXPLAIN'		=> 'Define the required parameters (GET and POST) for the page is loaded.<br />Check <strong>Online Documentation</strong> for more information on how to set these filters.',
+++	'PAGE_FILTER_PARAM'			=> 'Parameters',
+++	'PAGE_FILTER_PARAM_EXPLAIN'	=> 'You can set as many as you want separated by ","<br />Ex: mode=mymode,style=1',
+++	'PAGE_FILTER_TYPE'			=> 'Type',
+++	'PAGE_FILTER_TYPE_EXPLAIN'	=> 'Select the type of location parameters.',
+++	'PAGE_FORUM'				=> 'Pages inside the forum',
+++	'PAGE_FORUM_EXPLAIN'		=> 'These are pages belonging to the forum to which you can add blocks. You can manage and edit their main parameters as in customized pages.',
+++	'PAGE_GROUP'				=> 'Groups',
+++	'PAGE_GROUP_EXPLAIN'		=> 'Choose groups who can see the blocks of this page.<br />You can select multiple groups using <em>Ctrl key</em> on your keyboard.',
+++	'PAGE_HOME'					=> 'Home page',
+++	'PAGE_HOME_EXPLAIN'			=> 'This is a page designed to be used as a site\'s home page as a "Portal".',
+++	'PAGE_LINK'					=> 'Link',
+++	'PAGE_LINK_ICON'			=> 'Link icon',
+++	'PAGE_LINK_ICON_EXPLAIN'	=> 'Define the icon that will have the link to this page.',
+++	'PAGE_LINK_POSITION'		=> 'Link position',
+++	'PAGE_LINK_POSITION_EXPLAIN'	=> 'Define in which part of the forum a link to this page will appear.',
+++	'PAGE_LOGO'					=> 'Logo',
+++	'PAGE_LOGO_EXPLAIN'			=> 'Sets the url of the image to be used as logo.<br />Leave blank to use the default logo.',
+++	'PAGE_STYLE'				=> 'Style',
+++	'PAGE_STYLE_EXPLAIN'		=> 'Defines the style to be used on the page.<br /><em>This option will not be applied to the original pages of the forum.</em>',
+++	'PAGE_STYLESHEET'			=> 'Custom theme',
+++	'PAGE_STYLESHEET_EXPLAIN'	=> 'You can set the path to one or more files *.css (one per line) or directly set the variables of the theme that will be used.',
+++	'PAGE_THEME'				=> 'Theme',
+++	'PAGE_THEME_BACKGROUND'		=> 'Set background',
+++	'PAGE_THEME_DEFAULT'		=> 'Use default configuration',
+++	'PAGE_THEME_STYLE'			=> 'Set style',
+++	'PAGE_THEME_STYLESHEET'		=> 'Use custom theme',
+++	'PAGE_TITLE'				=> 'Page title',
+++	'PAGE_TITLE_EXPLAIN'		=> 'Title will be displayed in the browser.',
+++	'PAGE_URL'					=> 'Page url',
+++	
+++	'PAGES_ADD_TITLE'				=> 'Add new page',
+++	'PAGES_ADD_TITLE_EXPLAIN'		=> 'From here you can add a new page and define custom configuration and appearance.',
+++	'PAGES_BLOCKS_TITLE'			=> 'Manage blocks :: %s',
+++	'PAGES_BLOCKS_TITLE_EXPLAIN'	=> 'From here you can create/edit/delete blocks to be shown on this page.<br />
+++		The blocks can be divided into five columns (left, center, right, top and bottom). Drag the blocks to change their position.<br />
+++		You can also add <strong>groups</strong> that will allow you to place blocks in up to 3 columns independently.',
+++	'PAGES_EDIT_TITLE'				=> 'Edit page :: %s',
+++	'PAGES_EDIT_TITLE_EXPLAIN'		=> 'From here you can edit the main configuration and look for the page.',
+++	'PAGES_SELECT_TITLE_EXPLAIN'	=> 'Select the page to manage.',
+++	'PAGES_TITLE'					=> 'Manage pages',
+++	'PAGES_TITLE_EXPLAIN'			=> 'From here you can create/edit/delete additional pages for your forum. You can also edit the configuration and blocks on predefined pages.',
+++	
+++	'RIGHT_COLUMN'				=> 'Right column',
+++	'RIGHT_COLUMN_EXPLAIN'		=> 'Width of the right column in pixels or percentage.<br />Set 0 to disable the column.',
+++	'SHOW_FOOTER'				=> 'Show footer',
+++	'SHOW_FOOTER_EXPLAIN'		=> 'This option lets you decide whether to display the forum footer on this page.',
+++	'SHOW_HEADER'				=> 'Show header',
+++	'SHOW_HEADER_EXPLAIN'		=> 'This option lets you decide whether to display the forum header on this page.',
+++	'STYLE_DEFAULT'				=> 'Default style',
+++	'STYLE_ALTERNATIVE'			=> 'Alternate style',
+++	'STYLE_CONTENT_FULL'		=> 'Only content (with title)',
+++	'STYLE_CONTENT_SIMPLE'		=> 'Only content (without title)',
+++	'SUBMIT_CHANGES'			=> 'Apply changes',
+++	'TARGET_PAGE_EXPLAIN'		=> 'Select the target page for the selected blocks.<br /><em>The blocks will be placed in it respective column</em>',
+++	'TOP_COLUMN'				=> 'Top column',
+++));
+++
+++// @general messages
+++$lang = array_merge($lang, array(
+++	'BLOCK_ADDED'					=> 'Block added successfully',
+++	'BLOCK_COPIED'					=> 'Block(s) copied successfully',
+++	'BLOCK_NEED_REQUIREMENTS'		=> 'The selected block will need some minimum requirements to be used.<br />See the documentation for more information.',
+++	'BLOCK_MOVED'					=> 'Block(s) moved successfully',
+++	'BLOCK_NOT_ADDED'				=> 'Error adding the block',
+++	'BLOCK_NOT_EXISTS'				=> 'The selected block does not exist',
+++	'BLOCK_NOT_UPDATED'				=> 'Error updating the block',
+++	'BLOCK_POSITION_UPDATED'		=> 'Blocks position updated successfully',
+++	'BLOCK_POSITION_NOT_UPDATED'	=> 'Error updating blocks position',
+++	'BLOCK_REMOVED'					=> 'Block(s) removed successfully',
+++	'BLOCK_UPDATED'					=> 'Block updated successfully',
+++	'GROUPS_CHANGED'				=> 'Groups updated successfully',
+++
+++	'ITEM_REMOVED'				=> 'Element removed successfully',
+++	'ITEM_UPDATED'				=> 'Element updated successfully',
+++	'ITEM_ADDED'				=> 'Element added successfully',
+++	'ITEM_NOT_ADDED'			=> 'Error adding the element',
+++	'ITEM_NOT_UPDATED'			=> 'Error updating the element',
+++
+++	'PAGE_ADDED'				=> 'Page added successfully',
+++
+++	'PAGE_REMOVED'		=> array(
+++		1	=> 'The page has been successfully removed',
+++		2	=> '%d pages deleted successfully',
+++	),
+++
+++	'PAGE_UPDATED'				=> 'Page configuration updated successfully',
+++	'BLG_CONFIG_UPDATED'		=> 'Configuration updated successfully',
+++
+++	'CONFIRM_PAGE_DELETE'		=> 'Are you sure you wish to delete this page and all blocks in this?',
+++));
+++
+++/**
+++* Blocks names and explains from block_alias
+++*/
+++$lang = array_merge($lang, array(
+++	'blocks'	=> array(
+++		'announcements_title'		=> 'Announcements',
+++		'announcements_explain'		=> 'Displays a set number of posts (announcements) of established forums.',
+++		'attachments_title'			=> 'Attachments',
+++		'attachments_explain'		=> 'Displays information and links to the specified attachments.',
+++		'banners_title'				=> 'Banners',
+++		'banners_explain'			=> 'Displays the specified list of banners. It\'s displayed in a fixed or scrolling form.',
+++		'birthdays_title'			=> 'Birthdays',
+++		'birthdays_explain'			=> 'Displays the list of birthdays for today and the next few days (optional).',
+++		'empty_title'				=> 'Custom',
+++		'empty_explain'				=> 'Totally blank block which can also include any text HTML, CSS, JavaScript, etc...',
+++		'calendar_title'			=> 'Calendar',
+++		'calendar_explain'			=> 'Calendar in which you can add custom events and show birthdays.',
+++		'clock_title'				=> 'Clock',
+++		'clock_explain'				=> 'Displays a clock in flash format (you can choose several models and add your own clock).',
+++		'cloud_tag_title'			=> 'CloudTag',
+++		'cloud_tag_explain'			=> 'Sample labels in a balloon in flash format. You can display the latest searched words or the users with more messages.',
+++		'contact_title'				=> 'Contact',
+++		'contact_explain'			=> 'Displays a standard contact form.',
+++		'countdown_title'			=> 'CountDown',
+++		'countdown_explain'			=> 'Show a countdown to the indicated date.',	
+++		'counter_title'				=> 'Hit counter',
+++		'counter_explain'			=> 'Displays a hit counter with statistics of visits, visits per day, visits per hour, weekly visits, visits per month and visits per year.',
+++		'dockmenu_title'			=> 'Dock menu',
+++		'dockmenu_explain'			=> 'Displays a menu with Mac Dock style with elements of the specified list.',
+++		'forums_title'				=> 'Forums',
+++		'forums_explain'			=> 'List with full or custom forums.',
+++		'frame_title'				=> 'Frame',
+++		'frame_explain'				=> 'Display a Web page, a PDF file, a Flash file or a text file within the block.', 
+++		'gallery_title'				=> 'Photo gallery',
+++		'gallery_explain'			=> 'Photo Gallery customizable with forum images (attachments) or external images. The images move and link the fate of each.',
+++		'google_translate_title'	=> 'Google translator',
+++		'google_translate_explain'	=> 'Block that allows you to translate the page on which it is installed, opening a new window and translating it through Google technology.',
+++		'language_select_title'		=> 'Language select',
+++		'language_select_explain'	=> 'It allows the user to view the forum with any language that is installed in the forum and set it as their default language.',
+++		'latest_bots_title'			=> 'Bot\'s visits',
+++		'latest_bots_explain'		=> 'Simple list of last bots who entered the forum and the date of their last visit.',
+++		'latest_members_title'		=> 'Newest members',
+++		'latest_members_explain'	=> 'List of latest sers registered on the forum and the date they were registered.',
+++		'leaders_title'				=> 'Leaders',
+++		'leaders_explain'			=> 'Displays a list of groups (customizable) with forum leaders.',
+++		'link_us_title'				=> 'Link Us',
+++		'link_us_explain'			=> 'Block that displays a user-selectable link to the page on which it is installed. You can set a mini banner attached to the link.',
+++		'login_title'				=> 'Login',
+++		'login_explain'				=> 'Allows a user to login directly from the block. Once identified, shows the user\'s primary information and links.',
+++		'map_title'					=> 'Map',
+++		'map_explain'				=> 'Displays a map that may contain marks with different locations.',
+++		'menu_title'				=> 'Menu',
+++		'menu_explain'				=> 'Menu in tree format that displays items from the selected list.',
+++		'most_poster_title'			=> 'Most Posters',
+++		'most_poster_explain'		=> 'Displays a dropdown with users who have posted more messages in the forum, and most relevant information.',
+++		'news_title'				=> 'News',
+++		'news_explain'				=> 'Dropdown menu showing the last posts of the specified forums as a news.',
+++		'online_friends_title'		=> 'Friends online',
+++		'online_friends_explain'	=> 'Simple list of friends and foes of the user, that are connected to the forum.',
+++		'paypal_title'				=> 'Donations',
+++		'paypal_explain'			=> 'Allows users to donate money through paypal.',
+++		'player_title'				=> 'Music Player',
+++		'player_explain'			=> 'Player to play songs in MP3 or WAV format. Allow to create a list of songs or use M3U, ASX or PLS playlists.',
+++		'poll_title'				=> 'Poll',
+++		'poll_explain'				=> 'Displays a single poll specified in its configuration.',
+++		'poll_random_title'			=> 'Poll (random)',
+++		'poll_random_explain'		=> 'Displays a selected number of polls that selected in random order, within the specified forum.',
+++		'post_view_title'			=> 'Forum post',
+++		'post_view_explain'			=> 'Displays the contents of a message. You can display the last message of a forum, the first or last post of a topic or a custom post.',
+++		'quote_of_day_title'		=> 'Quote of day',
+++		'quote_of_day_explain'		=> 'Shows a "quote" or phrase of the day or a different tip in each visit to the page.',
+++		'random_member_title'		=> 'Random Member',
+++		'random_member_explain'		=> 'Displays basic information and avatar of a random user.',
+++		'ranks_title'				=> 'Ranks',
+++		'ranks_explain'				=> 'Shows a list with the forum ranks.',
+++		'recent_topics_title'		=> 'Recent Topics',
+++		'recent_topics_explain'		=> 'Recent topics of the forum. Allow to select the forums from which to read the topics.',
+++		'rss_title'					=> 'RSS Reader',
+++		'rss_explain'				=> 'Show the latest articles from the specified RSS archives(feeds). Items will be displayed in scroll mode or accordion.', 
+++		'share_title'				=> 'Share',
+++		'share_explain'				=> 'Shows the buttons of most popular social networks in the desired format.',
+++		'search_title'				=> 'Search',
+++		'search_explain'			=> 'Allows users to do quickly searchs on the forum or in a search engine.',
+++		'scroll_message_title'		=> 'Marquee',
+++		'scroll_message_explain'	=> 'Text message that is rotating in the block. Allows use BBCode and HTML in the text.',
+++		'stats_title'				=> 'Statistics',
+++		'stats_explain'				=> 'Gets the most relevant information on the forum. This block shows the number of new messages and topics, the total number of posts and topics, message statistics and topics written per day, total number of attachments and the number of users that remaining active (posting messages).',
+++		'style_select_title'		=> 'Style select',
+++		'style_select_explain'		=> 'Allows the user to view the forum with any style that is installed on the forum and set it as their default style.',
+++		'top_topics_title'			=> 'Top topics',
+++		'top_topics_explain'		=> 'List of custom topics that can display the latest topics unread, the most active topics or the most viewed topics.',
+++		'topic_index_title'			=> 'Topic Index',
+++		'topic_index_explain'		=> 'Displays an orderly list with the topics of selected forums. The list can be order by topic title, topic date or topic last post date.',
+++		'welcome_title'				=> 'Welcome',
+++		'welcome_explain'			=> 'This block enables a different welcome message for guests and registered users. The block will decide which message display.',
+++		'whos_online_title'			=> 'Who\'s online',
+++		'whos_online_explain'		=> 'Displays the list of connected users (as is shown by default in the Index of the forum) and users who logged in last 24 hours.',
+++		'youtube_title'				=> 'YouTube',
+++		'youtube_explain'			=> 'Show videos or channels from youtube.',
+++	)
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/acp_blocks.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/acp_blocks.php"
++new file mode 100644
++index 000000000..1a22369dd
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/acp_blocks.php"
++@@ -0,0 +1,478 @@
+++<?php
+++/*
+++* acp_blocks.php [English [En]]
+++*
+++* @package cBB Blockgets
+++* @version v2.0.2 12/01/2021
+++*
+++* @copyright (c) 2021 CaniDev
+++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+++*/
+++
+++// @ignore
+++if(!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if(empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++/**
+++ * @acp_blockgets_pages
+++*/
+++$lang = array_merge($lang, array(
+++	// Blocks global config
+++	'BLOCK_COLLAPSE'			=> 'Allow collapse the block',
+++	'BLOCK_COLLAPSE_EXPLAIN'	=> 'Enable or disable the ability for each user to collapse/expand this block and defines its initial state.',
+++	'BLOCK_ENABLED'				=> 'Block enabled',
+++	'BLOCK_ENABLED_EXPLAIN'		=> 'Defines whether this block display in the forum.',
+++ 	'BLOCK_CURRENT_ICON'			=> 'Block icon',
+++	'BLOCK_CURRENT_ICON_EXPLAIN'	=> 'Current icon set to the block.',
+++	'BLOCK_GROUP'				=> 'Groups',
+++	'BLOCK_GROUP_EXPLAIN'		=> 'Choose groups who may see this block in the forum.<br />You can select multiple groups using the <em>Ctrl</em> key on your keyboard.',
+++	'BLOCK_NO_CONFIG'			=> 'This block does not require additional configuration',
+++	'BLOCK_STYLE'				=> 'Look of the block',
+++	'BLOCK_STYLE_EXPLAIN'		=> 'With this option you can choose the look of each block individually. Note that the way it is displayed depends on the style installed on the forum and its compatibility with the extension.',
+++	'BLOCK_TITLE'				=> 'Block title',
+++	'BLOCK_TITLE_EXPLAIN'		=> 'Unique name for your block.<br />This title will be shown in the block.<br />Limit: 100 characters.',
+++
+++	// Common tags
+++	'ALL_FORUMS'				=> 'All forums',
+++	'COLLAPSE_HIDDEN'			=> 'Allow (collapsed by default)',
+++	'COLLAPSE_NONE'				=> 'Not Allow',
+++	'COLLAPSE_VISIBLE'			=> 'Allow (displayed by default)',
+++	'CONFIG'					=> 'Configuration',
+++	'DESIGN_FULL'				=> 'Full',
+++	'DESIGN_SIMPLE'				=> 'Simple',
+++	'FORUMS'					=> 'Forums',
+++	'FORUMS_EXPLAIN'			=> 'Forums that contain the topics to show. You can select as many as you like using the <em>Ctrl</em> key on your keyboard.',
+++	'IGNORE_AUTH'				=> 'Ignore auth',
+++	'IGNORE_AUTH_EXPLAIN'		=> 'If enabled, will be show all the content ignoring if the user have the permissions to view it.',
+++	'NO_LISTS'					=> 'No avaliable lists',
+++	'SHOW_PAGINATION'			=> 'Show pagination',
+++	'SHOW_PAGINATION_EXPLAIN'	=> 'Show the pagination to allow user to view older posts.',
+++	'TITLE_LIMIT'				=> 'Title limit',
+++	'TITLE_LIMIT_EXPLAIN'		=> 'Maximum number of characters that will be displayed in the topic titles.<br />
+++		<em>Set 0 to show the full title.</em>',
+++	'TOPIC_DESIGN'				=> 'Block design',
+++	'TOPIC_DESIGN_EXPLAIN'		=> 'Determine how the topics will be displayed in the block.<br />
+++		<em><strong>Full:</strong> Show all information whenever possible.</em><br />
+++		<em><strong>Simple:</strong> Show only basic information.</em>',
+++	'TOPIC_PARENT_SHOW'			=> 'Show parent forum',
+++	'TOPIC_PARENT_SHOW_EXPLAIN'	=> 'If enabled, a link to the forum for each topic will be displayed.',
+++	
+++	// age_ranges_block
+++	'AGE_START'					=> 'Minimum age',
+++	'AGE_END'					=> 'Maximum age',
+++	'AGE_INTERVAL'				=> 'Interval',
+++	
+++	// announcements_block
+++	'ANN_MAX_NUMBER'			=> 'Announcements number',
+++	'ANN_MAX_NUMBER_EXPLAIN'	=> 'Maximum number of announcements that are displayed within the block.',
+++	'ANN_MAX_SIZE'				=> 'Announcement size',
+++	'ANN_MAX_SIZE_EXPLAIN'		=> 'Maximum size of characters allowed in announcements. The text is cut off if this value exceeds.',
+++	'ANN_SHOW_GLOBALS'			=> 'Show global announcements',
+++	'ANN_SHOW_GLOBALS_EXPLAIN'	=> 'If enabled, you also read the items marked as "global", otherwise only read simple announcements.',
+++	'ANN_COLLAPSE'				=> 'Collapse announcements',
+++	'ANN_COLLAPSE_EXPLAIN'		=> 'If enabled, the block only show one announcement and collapse the rest. Otherwise, the announcements will appear all at once on the block.',
+++	
+++	// attachments_block
+++	'ATTACH_FORUM'				=> 'Forum attachments',
+++	'ATTACH_FORUM_EXPLAIN'		=> 'If specified, only display attachments from this forum ignoring the rest.<br />The forum should be directly containing the topic where the attachment, the above categories or forums are ignored here.',
+++	'ATTACH_EXTENSION'			=> 'Attachment extensions',
+++	'ATTACH_EXTENSION_EXPLAIN'	=> 'If specified, all attachments which do not contain this extensions will be ignored.<br />Split the extensions with ",".<<br />Ex. valid extensions: jpg,png,gif...',
+++	'ATTACH_NUM'				=> 'Attachment number',
+++	'ATTACH_NUM_EXPLAIN'		=> 'Maximum number of attachments that are displayed simultaneously in the block.',
+++	'ATTACH_SPECIFIC'			=> 'Specific attachment',
+++	'ATTACH_SPECIFIC_EXPLAIN'	=> 'If specified, only attachment with the specified name will be show in the block. The field must contain the original filename of the attachment, Ex: myfile.jpg<br /><br /><strong>Note:</strong> this field overrides the other fields.',
+++
+++	// banners_block, banners_multiple_block
+++	'BANNERS_TITLE'				=> 'Banner title',
+++	'BANNERS_TITLE_EXPLAIN'		=> 'If enabled, the title will be appear below the banners in the block.',
+++	'BANNERS_LS_TYPE'			=> 'List type',
+++	'BANNERS_LS_TYPE_EXPLAIN'	=> 'Define how to display the banners.<br />Can be set a horizontal, vertical scroll or remain fixed.',
+++	'BANNERS_NUMBER'			=> 'Banners to show',
+++	'BANNERS_NUMBER_EXPLAIN'	=> 'Maximum number of banners to display on the block.<br />
+++		<em>Set 0 to show all the list.</em>',
+++	'BANNERS_RANDOM'			=> 'Random order',
+++	'BANNERS_RANDOM_EXPLAIN'	=> 'Set if the elements will be show in the list order or in a random order.',
+++	'LIST_NO_SCROLL'			=> 'No Scroll',
+++	'LIST_SCROLL_H'				=> 'Horizontal scroll',
+++	'LIST_SCROLL_V'				=> 'Vertical scroll',
+++	'BANNERS_B_HEIGHT'			=> 'Block height',
+++	'BANNERS_B_HEIGHT_EXPLAIN'	=> 'Enter the height of the block that will be used to scroll lists.',
+++
+++	// birthdays_block
+++ 	'NEXT_BIRTHDAYS'			=> 'Upcoming Birthdays',
+++ 	'NEXT_BIRTHDAYS_EXPLAIN'	=> 'Show birthdays that occur in the coming days.<br />
+++ 		<em>Maximum 30 days. Set to 0 to disable it.</em>',
+++
+++	// calendar_block
+++ 	'CALENDAR_BIRTHDAYS'			=> 'Show Birthdays',
+++ 	'CALENDAR_BIRTHDAYS_EXPLAIN'	=> 'If enabled, the users birthdays are marked and displayed in the calendar, like events.',
+++ 	'CALENDAR_EVENTS'				=> 'Show events',
+++ 	'CALENDAR_EVENTS_EXPLAIN'		=> 'If enabled, events are marked and displayed in the calendar.',
+++ 	'CALENDAR_MONTHS'				=> 'Months to show',
+++ 	'CALENDAR_MONTHS_EXPLAIN'		=> 'Number of months to be displayed simultaneously on the block.',
+++
+++	// contact block
+++	'CONTACT_CHECK_EMAIL'			=> 'Check email',
+++	'CONTACT_CHECK_EMAIL_EXPLAIN'	=> 'If enabled, the domain of the user email will be checked and validated.',
+++	'CONTACT_EMAIL'					=> 'Target email',
+++	'CONTACT_HIDE_FIELDS'			=> 'Hide user data',
+++	'CONTACT_HIDE_FIELDS_EXPLAIN'	=> 'If enabled, the "Name" and "Email" fields for the register users will be hidden and the block will be used their profile values.',
+++ 
+++	// countdown block
+++	'COUNTDOWN_COMPLETE_MSG'			=> 'Text upon completion',
+++	'COUNTDOWN_COMPLETE_MSG_EXPLAIN'	=> 'Text to be displayed when the counter reaches 0.',
+++	'COUNTDOWN_TARGET'					=> 'Deadline',
+++	'COUNTDOWN_TARGET_EXPLAIN'			=> 'Set the date and time the counter will reach 0.<br /><br />
+++		<em><strong>Valid formats</strong>
+++			<br />Year/Month/Day
+++			<br />Year/Month/Day Hour:Minute:Second
+++		</em>',
+++	'COUNTDOWN_RUNNING_MSG'				=> 'Hold text',
+++	'COUNTDOWN_RUNNING_MSG_EXPLAIN'		=> 'Text to be displayed while the counter is running.',
+++
+++	// counter block
+++	'COUNTER_LOCAL'				=> 'Local counter',
+++	'COUNTER_LOCAL_EXPLAIN'		=> 'If enabled, the counter only show the visits to it\'s page, otherwise, the counter show the total visits to the forum.',
+++
+++	// empty_block
+++	'BLOCK_CONTENT'				=> 'Block content',
+++	'BLOCK_CONTENT_EXPLAIN'		=> 'Content to display on the block.<br />Limit: 8000 characters.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+++
+++	// clock_block
+++	'DISPLAY_CLOCK'				=> 'Clock to show',
+++	'DISPLAY_CLOCK_EXPLAIN'		=> 'Clock displayed on the block.',
+++	'PREVIEW_CLOCK'				=> 'Preview',
+++	'PREVIEW_CLOCK_EXPLAIN'		=> 'Selected clock preview.',
+++
+++	// cloud_tags_block
+++	'CLOUD_ANIMATION'			=> 'Animation enabled',
+++	'CLOUD_ANIMATION_EXPLAIN'	=> 'If enabled, the words "tags" appear in an animated cloud tag, otherwise, they appear as fixed words in block.',
+++	'CLOUD_MODE'				=> 'Words type',
+++	'CLOUD_MODE_EXPLAIN'		=> 'Specifies that words will be shown in block.',
+++	'CLOUD_WORDS'				=> 'Words number',
+++	'CLOUD_WORDS_EXPLAIN'		=> 'Maximum number of words that appear in the block.',
+++	'MODE_SEARCH'				=> 'Last searched words',
+++	'MODE_USERS'				=> 'Users with most posts',
+++	
+++	// forums block
+++	'FORUMS_FORUM'		=> 'Forum to show',
+++	
+++	// frame_block
+++	'MIME_HTML'			=> 'Web page',
+++	'MIME_PDF'			=> 'PDF file',
+++	'MIME_PLAIN'		=> 'Plain Text file',
+++
+++	'FRAME_HEIGHT'				=> 'Frame height',
+++	'FRAME_HEIGHT_EXPLAIN'		=> 'Frame height in pixels. Set to 0 to auto adjust.',
+++	'FRAME_MIMETYPE'			=> 'Document type',
+++	'FRAME_MIMETYPE_EXPLAIN'	=> 'The document type displayed in the frame.',
+++	'FRAME_URL'					=> 'Document URL',
+++	'FRAME_URL_EXPLAIN'			=> 'URL of the document or page displayed in the frame.',
+++	'FRAME_WIDTH'				=> 'Frame width',
+++	'FRAME_WIDTH_EXPLAIN'		=> 'Frame width in pixels. Set to 0 to auto adjust.',
+++	
+++	// gallery_block
+++	'GALLERY_CUSTOM'				=> 'Custom images',
+++	'GALLERY_CUSTOM_EXPLAIN'		=> 'Specify the list containing the images to be displayed.',
+++	'GALLERY_DIRECTION'				=> 'Scroll direction',
+++	'GALLERY_FORUMS'				=> 'Forums',
+++	'GALLERY_FORUMS_EXPLAIN'		=> 'Defines the forums to read the attachments.',
+++	'GALLERY_FPS'					=> 'Scroll speed',
+++	'GALLERY_HEIGHT'				=> 'Gallery height',
+++	'GALLERY_MANAGE'				=> 'Manage gallery',
+++	'GALLERY_MARGIN'				=> 'Image margin',
+++	'GALLERY_MAX_NUMBER'			=> 'Number of images',
+++	'GALLERY_MAX_NUMBER_EXPLAIN'	=> 'Maximum attachments that will be read from the forums/topics/posts',
+++	'GALLERY_POSTS'					=> 'Posts',
+++	'GALLERY_POSTS_EXPLAIN'			=> 'Posts IDs to read the attachments, splitted with commas. (Ex: 1,2,3).',
+++	'GALLERY_SOURCE'				=> 'Origin of the images',
+++	'GALLERY_SOURCE_EXPLAIN'		=> 'Define what type of images will be loaded from the forums, topics or messages specified.',
+++	'GALLERY_TOPICS'				=> 'Topics',
+++	'GALLERY_TOPICS_EXPLAIN'		=> 'Topics IDs to read the attachments, splitted with commas. (Ex: 1,2,3).',
+++	'GALLERY_ZOOM'					=> 'Zoom',
+++	'GALLERY_ZOOM_EXPLAIN'			=> 'Size difference on image\'s mouse over (in pixels)',
+++	
+++	'GALLERY_SOURCE_ALL'			=> 'All',
+++	'GALLERY_SOURCE_ATTACHMENTS'	=> 'Only attachments',
+++	'GALLERY_SOURCE_IMAGES'			=> 'Only embedded images',
+++	
+++	'IMG_TITLE'			=> 'Image title',
+++	'IMG_URL'			=> 'Image url',
+++	'IMG_URL_EXPLAIN'	=> 'Url of an JPG, GIF or PNG image. Ej:http://mydomain.com/image.jpg',
+++	
+++	// google_translate_block
+++	'GOOGLE_LANGS'		=> 'Languages to show in the block',
+++	'GOOGLE_SHOW_NAMES'			=> 'Show names',
+++	'GOOGLE_SHOW_NAMES_EXPLAIN'	=> 'If enabled, the language name will be displayed next to its flag.',
+++	
+++	// latest_bots_block
+++	'BOTS_NUMBER'				=> 'Bots to show',
+++	'BOTS_NUMBER_EXPLAIN'		=> 'Maximum number of last visit bots that will be shown in the block.',
+++
+++	// latest_members_block
+++	'MEMBERS_NUMBER'			=> 'Users to show',
+++	'MEMBERS_NUMBER_EXPLAIN'	=> 'Maximum number of users that will be shown in block.',
+++	
+++	// leaders_block
+++	'LEADERS_ALL_GROUPS'			=> 'Show users in all their groups',
+++	'LEADERS_ALL_GROUPS_EXPLAIN'	=> 'If enabled, users will be shown in all groups of which they are members.
+++		Otherwise they will only be shown in their default group.',
+++	'LEADERS_GROUPS'				=> 'Groups',
+++	'LEADERS_GROUPS_EXPLAIN'		=> 'Groups that will be show in the block. If you don\'t select groups, the block will be show the Administrators and Moderators.',
+++	'LEADERS_MODE'					=> 'Display mode',
+++	'LEADERS_MODE_ACCORDION'		=> 'Accordion',
+++	'LEADERS_MODE_SIMPLE'			=> 'Simple List',
+++	'LEADERS_ONLY_ONLINE'			=> 'Online users only',
+++	'LEADERS_ONLY_ONLINE_EXPLAIN'	=> 'If enabled, only users from selected groups who are logged in will be displayed.',
+++
+++	// link_us_block
+++	'US_BANNER'					=> 'Mini banner link',
+++	'US_BANNER_EXPLAIN'			=> 'Mini banner that will be the image that you have to click to access the forum from the link.',
+++
+++	// Login Block
+++ 	'FULL_LOGIN'				=> 'Show Full login',
+++ 	'FULL_LOGIN_EXPLAIN'		=> 'Enable/disable the advanced options in the user identification.',
+++ 	'SHOW_REGISTER'				=> 'Show register',
+++ 	'SHOW_REGISTER_EXPLAIN'		=> 'Display option for the user registration.',
+++	
+++	// map_block
+++	'LATITUDE'					=> 'Latitude',
+++	'LONGITUDE'					=> 'Longitude',
+++	'LOCATION_ADD'				=> 'Add location',
+++	'LOCATION_EDIT'				=> 'Edit location',
+++	'LOCATION_IMAGE'			=> 'Image',
+++	'LOCATION_IMAGE_EXPLAIN'	=> 'Image that will mark the point on the map.<br /><em>If you do not define any, the default mark will be used</em>.',
+++	'LOCATION_INCORRECT'		=> 'he position entered is incorrect.',
+++	'LOCATION_POSITION'			=> 'Position',
+++	'LOCATION_POSITION_EXPLAIN'	=> 'Defines the latitude and longitude of the location.',
+++	'LOCATION_TEXT'				=> 'Content',
+++	'LOCATION_TEXT_EXPLAIN'		=> 'Text to be displayed on the map, by clicking on the location icon.<br /><em>BBcode is allowed.</em>',
+++	'LOCATION_TITLE'			=> 'Title',
+++	'MAP'						=> 'Map',
+++	'MAP_CENTER'				=> 'Central point',
+++	'MAP_CENTER_EXPLAIN'		=> 'Defines the latitude and longitude of the default center point.',
+++	'MAP_LOCATIONS'				=> 'Locations',
+++	'MAP_ZOOM'					=> 'Zoom',
+++	'MAP_ZOOM_EXPLAIN'			=> 'Set the default zoom.',
+++	'SEARCH_ADDRESS'			=> 'Search location',
+++	'SELECT_LOCATION'			=> 'Select location',
+++
+++	// menu_block
+++	'DISPLAY_MENU'				=> 'Menu to show',
+++	'DISPLAY_MENU_EXPLAIN'		=> 'Menu to be displayed in the block. The menu must be previously created in the correct section to be reflected here.',
+++ 	'ICON_WIDTH'				=> 'Icon width',
+++ 	'ICON_WIDTH_EXPLAIN'		=> 'The width of the block icons, in pixels.',
+++
+++	// most_poster_block
+++	'POSTER_LIMIT'				=> 'User Limit',
+++	'POSTER_LIMIT_EXPLAIN'		=> 'The limit of users that are displayed on the block.',
+++ 	'POST_RANGE'				=> 'Message range',
+++ 	'POST_RANGE_EXPLAIN'		=> 'Time limit for the message count.',
+++ 
+++ 	'ALL_POSTS'			=> 'All messages',
+++ 	'LAST_DAY'			=> 'Last day',
+++ 	'LAST_WEEK'			=> 'Last week',
+++ 	'LAST_MONTH'		=> 'Last month',
+++ 	'LAST_YEAR'			=> 'Last year',
+++
+++	// news_block
+++	'NEWS_DISPLAY'				=> 'Information to show',
+++	'NEWS_DISPLAY_EXPLAIN'		=> '<em><strong>Basic content:</strong>Show title, author and date.<br />
+++		<strong>Full content:</strong>Show all news information.</em>',
+++	'NEWS_NUMBER'				=> 'News number',
+++	'NEWS_NUMBER_EXPLAIN'		=> 'Maximum number of news items displayed in the block.',
+++	'NEWS_SIZE'					=> 'News size',
+++	'NEWS_SIZE_EXPLAIN'			=> 'Maximum size of characters allowed in the news. The text of the news will be cut if this value exceeds.',
+++	'NEWS_ALL'					=> 'Show all topics',
+++	'NEWS_ALL_EXPLAIN'			=> 'If enabled, you also read the items marked as "announcement" and "fixed", otherwise, only read the "normal" topics.',
+++	'NEWS_COLLAPSE'				=> 'Collapse news',
+++	'NEWS_COLLAPSE_EXPLAIN'		=> 'If enabled, the block only show one notice and collapse the rest. Otherwise, the news will appear all at once on the block.',
+++	'NEWS_SHOW_FULL'			=> 'Complete content',
+++	'NEWS_SHOW_SIMPLE'			=> 'Basic content',
+++	
+++	// paypal_block
+++	'PAYPAL_ACCOUNT'			=> 'Paypal account',
+++	'PAYPAL_ACCOUNT_EXPLAIN'	=> 'Enter the e-mail address of your Paypal account ex: xxx@xxx.com',
+++	'PAYPAL_ITEM'				=> 'Payment description',
+++	'PAYPAL_ITEM_EXPLAIN'		=> 'Enter the name (description) to which payments will be identified through the block.',
+++	'PAYPAL_MSG'				=> 'Message',
+++	'PAYPAL_MSG_EXPLAIN'		=> 'Customizable message that will appear in the block.<br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+++	'PAYPAL_IMG'				=> 'Button Image',
+++ 	'PAYPAL_IMG_EXPLAIN'		=> 'Image to be used for the "donate" button. Leave this field blank to use the default image.', 
+++	'PAYPAL_AMOUNTS'			=> 'Amounts',
+++	'PAYPAL_AMOUNTS_EXPLAIN'	=> 'Money amount in the select. Split the values with ";" (Ex: 5;10;15).',
+++	'PAYPAL_CURRENCIES'			=> 'Currencies',
+++	'PAYPAL_CURRENCIES_EXPLAIN'	=> 'Type of currency that will be show in the block. You can select more that one and select the default currency.',
+++	
+++	//player block
+++	'PLAYER_AUTOPLAY'			=> 'Autoplay',
+++	'PLAYER_AUTOPLAY_EXPLAIN'	=> 'Defines whether the player will automatically start playing the tracks when the page loads.<br /><br />
+++		<em><strong>Note:</strong>Browsers limit this feature so playback will not begin until the user clicks anywhere on the page.</em>',
+++	'PLAYER_PLAYLIST'			=> 'Show playlist',
+++	'PLAYER_PLAYLIST_EXPLAIN'	=> 'Defines if the playlist is displayed in the player.',
+++	'PLAYER_TRACKLIST'			=> 'Tracklist',
+++	'PLAYER_TRACKLIST_EXPLAIN'	=> 'The player tracks or songs.',
+++
+++	'TRACK_TITLE'			=> 'Track title',
+++	'TRACK_TITLE_EXPLAIN'	=> 'the name or title displayed in the player.',
+++	'TRACK_URL'				=> 'Track URL',
+++	'TRACK_URL_EXPLAIN'		=> 'A radio URL (Ex: http://127.0.0.1:8888), a mp3 or wav audio file (Ex: http://myserver.com/audio.mp3) or a valid playlist file (m3u, asx, pls).',
+++
+++	// poll_block
+++	'DISPLAY_POLL'				=> 'Poll to show',
+++	'DISPLAY_POLL_EXPLAIN'		=> 'Poll displayed in the block.',
+++	'DISPLAY_RESULTS'			=> 'Show results',
+++	'NO_POLLS'					=> 'No polls available',
+++
+++	// poll_random_block
+++	'POLL_FORUM'				=> 'Poll forum',
+++	'POLL_FORUM_EXPLAIN'		=> 'Forum containing the polls that show on the block.',
+++	'POLL_NUM'					=> 'Poll number',
+++	'POLL_NUM_EXPLAIN'			=> 'The number of polls that will be displayed at once within the block.',
+++	'NO_FORUMS'					=> 'No forums avaliable',
+++	
+++	// post_view_block
+++	'PV_ITEM_URL'			=> 'Referral URL',
+++	'PV_ITEM_URL_EXPLAIN'	=> 'Specify here the URL of the forum, topic or message you want to display.<br />
+++		<em><strong>Note:</strong> The url of a forum or topic will display it\'s last message.</em>',
+++	
+++	// quote_of_day_block
+++	'QUOTE_AUTHOR'				=> 'Quote author',
+++	'QUOTE_TEXT'				=> 'Quote Text',
+++	'QUOTES_ALL_DAY'			=> 'Keep all day',
+++	'QUOTES_ALL_DAY_EXPLAIN'	=> 'If enabled, you will see the same quote all day. Otherwise, every time the page loads you will see a different quote.',
+++	'QUOTES_LIST'				=> 'Quote list',
+++	'QUOTES_RAND'				=> 'Random order',
+++	'QUOTES_RAND_EXPLAIN'		=> 'Defines if the quotes are displayed in random order or maintaining the order of the list.',
+++	'QUOTES_SHOW_AUTHOR'		=> 'Show author',
+++	'QUOTES_SHOW_AUTHOR_EXPLAIN'	=> 'Defines whether to display the author of the quote on the block.',
+++	
+++	// ranks_block
+++	'ORPHAN_RANKS'				=> 'Show orphan ranks',
+++	'ORPHAN_RANKS_EXPLAIN'		=> 'If enabled, will show the ranges are not assigned to any user.',
+++	'ONLY_SPECIAL_RANKS'		=> 'Only special ranks',
+++	
+++	// recent_topics_block
+++	'RECENT_FORUMS'					=> 'Topic forums',
+++	'RECENT_FORUMS_EXPLAIN'			=> 'Forums containing items to be displayed. If you do not select any, it will use all the forums. You can select as many as you like using the <em>Ctrl</em> key on your keyboard.',
+++	'RECENT_SECTIONS'				=> 'Sections',
+++	'RECENT_SECTIONS_EXPLAIN'		=> 'Define the sections to be displayed in the block and their order.',
+++	'RECENT_TOPIC_LIMIT'			=> 'Topic limit',
+++	'RECENT_TOPIC_LIMIT_EXPLAIN'	=> 'Maximum number of items to be displayed in each tab.',
+++
+++	// Rss block
+++	'1_HOUR'		=> 'One hour',
+++	'2_HOURS'		=> 'Two hours',
+++	'6_HOURS'		=> 'Siz hours',
+++	
+++	'RSS_COLLAPSABLE'			=> 'Collapsable',
+++	'RSS_COLLAPSABLE_EXPLAIN'	=> 'Sets whether the items are displayed in an accordion or scrolling. If set to "Yes" will override the block scroll.',
+++	'RSS_DIRECTION'				=> 'Scroll direction',
+++	'RSS_DIRECTION_EXPLAIN'		=> 'Defining the direction of scrolling text. This option is canceled if the items are displayed in an accordion.',
+++	'RSS_HEIGHT'				=> 'Block height',
+++	'RSS_HEIGHT_EXPLAIN'		=> 'Sets the height of the block, in pixels. Only apply if items are not displayed in accordion format.',
+++	'RSS_IGNORE_LANG'			=> 'Ignore feed lang',
+++	'RSS_IGNORE_LANG_EXPLAIN'	=> 'If enabled, all URLs are read, regardless of their language, otherwise it will only display the contents written in the language of the user.',
+++	'RSS_LIMIT'					=> 'Feed limit',
+++	'RSS_LIMIT_EXPLAIN'			=> 'Maximum number of items to be read from each URL.',
+++	'RSS_SOURCES'				=> 'Feed sources',
+++	'RSS_TITLE'					=> 'Feed title',
+++	'RSS_TTL'					=> 'Refresh time',
+++	'RSS_TTL_EXPLAIN'			=> 'Time will remain cached items before attempting to read the source again.',
+++	'RSS_URL'					=> 'File url',
+++	'RSS_URL_EXPLAIN'			=> 'Ex: <em>http://midominio.com/rss.xml</em>',
+++
+++	// scroll_message_block
+++	'MARQUEE_DIRECTION'				=> 'Scroll direction',
+++	'MARQUEE_DIRECTION_EXPLAIN'		=> 'Scroll direction for the text. This attribute controls the direction of scrolling.',
+++	'MARQUEE_SPEED'					=> 'Scroll amount',
+++	'MARQUEE_SPEED_EXPLAIN'			=> 'This controls the amount of movement (in pixels) between the successive displays that give the impression of animation.',
+++	'MARQUEE_SCROLLDELAY'			=> 'Scroll delay',
+++	'MARQUEE_SCROLLDELAY_EXPLAIN'	=> 'This controls the delay (in milliseconds) between the successive displays that give the impression of animation.',
+++	'MARQUEE_ALIGN'					=> 'Scroll align',
+++	'MARQUEE_ALIGN_EXPLAIN'			=> 'This tag controls the positioning of the marquee display box relative to the current text in exactly the same manner as the img tag\'s align attribute.',
+++	'MARQUEE_BGCOLOR'				=> 'Scroll bgcolor',
+++	'MARQUEE_BGCOLOR_EXPLAIN'		=> 'This tag controls the background colour of the display box.',
+++	'MARQUEE_HEIGHT'				=> 'Scroll height',
+++	'MARQUEE_HEIGHT_EXPLAIN'		=> 'This controls the height of the display box.',
+++	'MARQUEE_PADDING'				=> 'ScrollBox Padding',
+++	'MARQUEE_PADDING_EXPLAIN'		=> 'Space around the scroll box. This attribute is equivalent to the attribute "padding" of CSS.',
+++	'MARQUEE_TEXT'					=> 'Scroll message text',
+++	'MARQUEE_TEXT_EXPLAIN'			=> 'Add/change a scrollable message here. Limit 2000 characters.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+++
+++	'BOTTOM'		=> 'Bottom',
+++	'DOWN'			=> 'Down',
+++	'LEFT'			=> 'Left',
+++	'CENTER'		=> 'Center',
+++	'UP'			=> 'Up',
+++	'RIGHT'			=> 'Right',
+++	'TOP'			=> 'Top',
+++	
+++	//share_block
+++	'SHARE_SHOW_NAMES'			=> 'Show names',
+++	'SHARE_SHOW_NAMES_EXPLAIN'	=> 'If enabled, the name of the social network will be displayed next to its icon.',
+++	'SHARE_URL'					=> 'Reference URL',
+++	'SHARE_URL_EXPLAIN'			=> 'Set a fixed reference url for the buttons. Leave this field blank to use the displayed page.',
+++	'SHARE_BUTTONS'				=> 'Buttons to show',
+++	
+++	// stats_block
+++	'STATS_INLINE'			=> 'Show data in line',
+++ 	'USER_STATS'			=> 'Display user statistics',
+++	
+++	// top_topics_block
+++	'TOPT_LIMIT'			=> 'Topic limit',
+++	'TOPT_LIMIT_EXPLAIN'	=> 'Maximun number of topic to show.',
+++	'TOPT_MODE'				=> 'Topic to show',
+++	'TOPT_MODE_ACTIVE'		=> 'Latest topics more active',
+++	'TOPT_MODE_UNREAD'		=> 'Latest unread topics',
+++	'TOPT_MODE_VIEWED'		=> 'More viewed topics',
+++
+++	// topic_index_block
+++	'TINDEX_CHAR_SELECT'			=> 'Show Index',
+++	'TINDEX_CHAR_SELECT_EXPLAIN'	=> 'Only avaliable if the sort method is <em>Topic title</em>.',
+++	'TINDEX_PER_PAGE'			=> 'Topics per page',
+++	'TINDEX_PER_PAGE_EXPLAIN'	=> 'Number of topics that will be show at the same time. Set 0 to disable pagination.',
+++	'TINDEX_SORT_MODE'			=> 'Order by',
+++	'TINDEX_SORT_MODE_EXPLAIN'	=> 'Method that will be used to set the topic\'s order in the list.',
+++  
+++	'TOPIC_TIME'		=> 'Topic date',
+++	'LAST_POST_TIME'	=> 'Last post date',
+++
+++	// welcome_block
+++	'WELCOME_GUEST'				=> 'Guests message',
+++	'WELCOME_GUEST_EXPLAIN'		=> 'Message to display to all guests. 2000 characters max.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+++	'WELCOME_MEMBER'			=> 'Members message',
+++	'WELCOME_MEMBER_EXPLAIN'	=> 'Message to display to all the forum registered users. 2000 characters max.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+++
+++	// whos_online_block
+++	'WHOS_ADVANCED'				=> 'Advanced mode',
+++	'WHOS_ADVANCED_EXPLAIN'		=> 'If enabled, will display all the information, otherwise it will appear only basic information (suitable for side blocks).',
+++	'WHOS_USERNAMES'			=> 'Show user list',
+++	'WHOS_USERNAMES_EXPLAIN'	=> 'If enabled, displays the list of users online (only in advanced mode).',
+++
+++	// youtube_block
+++	'YT_AUTOPLAY'				=> 'AutoPlay enabled',
+++	'YT_AUTOPLAY_EXPLAIN'		=> 'If enabled, the video will play automatically.<br />If you have multiple videos, only the first autoplay.',
+++	'YT_DISPLAY_MODE'			=> 'Display Mode',
+++	'YT_FULL_PREVIEW'			=> 'Show thumbnails, title and description',
+++	'YT_LIST'					=> 'Show a list with titles',
+++	'YT_RANDOM_DISPLAY'			=> 'Random Display',
+++	'YT_RANDOM_DISPLAY_EXPLAIN'	=> 'If enabled, only one video will be appear randomly. Otherwise, all the videos and channels appear at once.',
+++	'YT_RESULT_LIMIT'			=> 'Number of channel videos',
+++	'YT_RESULT_LIMIT_EXPLAIN'	=> 'Maximun number of videos loaded in each channel.',
+++	'YT_SIMPLE_PREVIEW'			=> 'Show thumbnails and titles',
+++	'YT_TEXT_LIMIT'				=> 'Text limit',
+++	'YT_TEXT_LIMIT_EXPLAIN'		=> 'Maximun number of characters in the video description.',
+++	'YT_VIDEO_PREVIEW'			=> 'Show video preview',
+++	'YT_VIDEO_SIZE'				=> 'Player size',
+++	'YT_VIDEO_TITLE'			=> 'Video title',
+++	'YT_VIDEO_URL'				=> 'Video url',
+++	'YT_VIDEO_URL_EXPLAIN'		=> 'Ex: <em>https://www.youtube.com/watch?v=NHH_v0k7Gus</em>',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/chat_addon.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/chat_addon.php"
++new file mode 100644
++index 000000000..726889601
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/chat_addon.php"
++@@ -0,0 +1,32 @@
+++<?php
+++/** 
+++* chat_addon.php [English [En]]
+++*
+++* @package language cBB Blockgets
+++* @version v2.0.1 04/05/2018
+++*
+++* @copyright (c) 2018 CaniDev
+++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+++*/
+++
+++// @ignore
+++if(!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if(empty($lang['blocks']))
+++{
+++	$lang['blocks'] = array();
+++}
+++
+++$lang['blocks'] = array_merge($lang['blocks'], array(
+++	'chat_title'	=> 'Chat',
+++	'chat_explain'	=> 'Allows you to use cBB Chat as a block in the columns or show the users connected to the chat.',
+++));
+++
+++$lang = array_merge($lang, array(
+++	'CHAT_ADDON_MODE'		=> 'Display mode',
+++	'CHAT_MODE_CHAT'		=> 'Chat room',
+++	'CHAT_MODE_USERS'		=> 'Online Users',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/email/contact_block.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/email/contact_block.txt"
++new file mode 100644
++index 000000000..5ee2e8c3e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/email/contact_block.txt"
++@@ -0,0 +1,6 @@
+++
+++The following is an e-mail sent to you from "{SITENAME}" for {FROM_USERNAME} by the contact form:
+++
+++----------
+++
+++{MESSAGE}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/info_acp_blockgets.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/info_acp_blockgets.php"
++new file mode 100644
++index 000000000..263814a48
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/info_acp_blockgets.php"
++@@ -0,0 +1,53 @@
+++<?php
+++/*
+++* info_acp_blockgets.php [English [En]]
+++* @package cBB Blockgets
+++* @version v2.0.2 12/01/2021
+++*
+++* @copyright (c) 2021 CaniDev
+++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+++*/
+++
+++// @ignore
+++if(!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++/**
+++ * @general tags and messages
+++*/
+++$lang = array_merge($lang, array(
+++	'ACP_BLOCKGETS'				=> 'Blockgets',
+++	'ACP_BLOCKGETS_GENERAL'		=> 'General',
+++	
+++	'ACP_BLG_CONFIG_MAIN'		=> 'General configuration',
+++	'ACP_BLG_CONFIG_OPTIONAL'	=> 'Additional configuration',
+++	'ACP_BLG_IMAGES'			=> 'Images',
+++	'ACP_PAGES_AND_BLOCKS'		=> 'Pages and Blocks',
+++	
+++	// Logs
+++	'LOG_BLG_CONFIG'		=> '<strong>cBB Blockgets:</strong> Changed main configuration',
+++	'LOG_BLOCK_ADDED'		=> '<strong>cBB Blockgets:</strong> New block added<br />» %1$s in %2$s',
+++	'LOG_BLOCK_COPY_PAGE'	=> '<strong>cBB Blockgets:</strong> Blocks copied<br />» de %1$s a %2$s',
+++	'LOG_BLOCK_MOVED'		=> '<strong>cBB Blockgets:</strong> Changed blocks position<br />» %1$s',
+++	'LOG_BLOCK_MOVED_PAGE'	=> '<strong>cBB Blockgets:</strong> Blocks moved<br />» from %1$s to %2$s',
+++	'LOG_BLOCK_REMOVED'		=> '<strong>cBB Blockgets:</strong> Block(s) deleted<br />» en %1$s',
+++	'LOG_BLOCK_UPDATED'		=> '<strong>cBB Blockgets:</strong> Block edited<br />» %1$s en %2$s',
+++	'LOG_EVENT_REMOVED'		=> '<strong>cBB Blockgets:</strong> Event deleted<br />» %1$s',
+++	'LOG_LIST_REMOVED'		=> '<strong>cBB Blockgets:</strong> List deleted<br />» %1$s',
+++	'LOG_PAGE_ADDED'		=> '<strong>cBB Blockgets:</strong> New page added<br />» %1$s',
+++	'LOG_PAGE_UPDATED'		=> '<strong>cBB Blockgets:</strong> Changed page<br />» %1$s',
+++	'LOG_PAGE_REMOVED'		=> '<strong>cBB Blockgets:</strong> Page deleted<br />» %1$s',
+++	
+++	// Permissions
+++	'ACL_A_BLOCKGETS_MANAGE'	=> 'Can manage cBB Blockgets',
+++	'ACL_U_BLOCKGETS_BIRTHDAYS'	=> 'Can see birthdays in the Calendar',
+++	'ACL_U_BLOCKGETS_CALENDAR'	=> 'Can view calendar',
+++	'ACL_U_BLOCKGETS_EVENTS'	=> 'Can manage calendar events',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/installer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/installer.php"
++new file mode 100644
++index 000000000..f9a800fc4
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/installer.php"
++@@ -0,0 +1,43 @@
+++<?php
+++/*
+++* installer.php [English [En]]
+++* @package cBB Blockgets
+++* @version v2.0.2 12/01/2021
+++*
+++* @copyright (c) 2021 CaniDev
+++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+++*/
+++
+++// @ignore
+++if(!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if(empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++// Local Variables
+++$lang = array_merge($lang, array(
+++	'PORTAL'			=> 'Portal',
+++	'DOCK_MENU'			=> 'Dock menu',
+++	'MAIN_MENU'			=> 'Main Menu',
+++	'RECOMMENDED'		=> 'Recommended',
+++
+++	'P_ADMIN'			=> 'Administration',
+++	'P_MAIN'			=> 'Main',
+++	'P_MCP'				=> 'Moderation Panel',
+++	'P_ACP'				=> 'Administration Panel',
+++
+++	'PHPBB_TITLE'		=> 'phpBB official website',
+++	'XAMPP_TITLE'		=> 'Xampp',
+++	'SOURCEFORGE_TITLE'	=> 'Open source applications',
+++
+++	'WELCOME_GUEST'		=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Forum equipped with cBB Blockgets</i><br /><br />Welcome to our forum!<br />Register to access all the content!.</strong></div>[/html]',
+++	'WELCOME_MEMBER'	=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Forum equipped with cBB Blockgets</i><br /><br />Welcome back to our forum {S_USERNAME}</strong></div>[/html]',	
+++
+++	'CORE_INSTALL_ERROR'	=> 'You have not uploaded all the files from the installation package or you are trying to install an old package.<br />
+++		Please make sure to upload all the files (including the <em>core</em> folder) and use a package downloaded from the official website.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/main.php"
++new file mode 100644
++index 000000000..9100727fa
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/language/pt_preao/main.php"
++@@ -0,0 +1,269 @@
+++<?php
+++/*
+++* main.php [English [En]]
+++* @package cBB Blockgets
+++* @version v2.0.2 12/01/2021
+++*
+++* @copyright (c) 2021 CaniDev
+++* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+++*/
+++
+++// @ignore
+++if(!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if(empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'PORTAL'			=> 'Portal',
+++	'READ_FULL'			=> 'Read full topic',
+++	'BLG_READ_MORE'		=> '%sLer mais%s',
+++
+++	'ADD_PAGE'					=> 'Criar página',
+++	'BANNERS'					=> 'Banners',
+++	'CALENDAR'					=> 'Calendário',
+++	'CALENDAR_BIRTHDAY_TITLE'	=> '%1$s e <strong>mais %2$d</strong>.',
+++	'CALENDAR_SELECT_DATE'		=> 'Seleccionar data',
+++	'EDIT_CONFIGURATION'		=> 'Editar configuração',
+++	'EDIT_THIS_PAGE'			=> 'Editar esta página',
+++	'EDITOR'					=> 'Editor',
+++	'EXPAND_CONTRACT'			=> 'Expandir/colapsar',
+++	'INSERT_ON_ENTRY'			=> 'Inserir no texto',
+++	'MANAGE_BLOCKS'				=> 'Gerir blocos',
+++	'PRINT'						=> 'Imprimir',
+++	'SELECT_COLOUR'				=> 'Seleccionar cor',
+++	'SMILIES'					=> 'Emoticons',
+++	'TODAY'						=> 'Hoje',
+++
+++	// Editor
+++	'HTML_TITLE' 		=> 'Html:',
+++	'INSERT_HTML' 		=> 'Inserir Código HTML',
+++
+++	// Login Block
+++	'HIDE_ME_NOW'			=> 'Hide me in this session',
+++	'MY_BOOKMARKS'			=> 'Favoritos',
+++	'MY_SUBSCRIBED'			=> 'Subscrições',
+++	'REMEMBER_ME'			=> 'Lembrar-me',
+++
+++	// Link Us Block
+++	'LINK_US_TXT'			=> 'Please feel free to link to <strong>%s</strong>. Use the following HTML:',
+++
+++	// Stats Block and whos_online block
+++	'GUEST_VISITS_TOTAL'		=> '%d Visitantes',
+++	'GUEST_VISIT_TOTAL'			=> '%d Visitante',
+++	'HIDDEN_VISITS_TOTAL'		=> '%d ocultos, ',
+++	'HIDDEN_VISIT_TOTAL'		=> '%d oculto, ',
+++	'LASTVISIT_VISITS_TOTAL'	=> 'In total there were <strong>%d</strong> users online in the last 24 hours :: ',
+++	'LASTVISIT_VISIT_TOTAL'		=> 'In total there is <strong>%d</strong> user online in the last 24 hours  :: ',
+++	'REG_VISITS_TOTAL'			=> '%d Registados, ',
+++	'REG_VISIT_TOTAL'			=> '%d Registado, ',
+++
+++	'ST_ACTIVE_POSTERS'			=> 'Active posters',
+++	'ST_ANNS'					=> 'Announcements',
+++	'ST_ATTACHMENTS'			=> 'Anexos',
+++	'ST_BOARD_STARTDATE'		=> 'Start date',
+++	'ST_NEW'					=> 'Novo',
+++	'ST_NEWEST_USER'			=> 'Último membro',
+++	'ST_POSTS'					=> 'Mensagens',
+++	'ST_POSTS_PER_DAY'			=> 'Mensagens por dia',
+++	'ST_POSTS_PER_TOPIC'		=> 'Mensagens por tópico',
+++	'ST_POSTS_PER_USER'			=> 'Mensagens por utilizador',
+++	'ST_STICKYS'				=> 'Importantes',
+++	'ST_TOP'					=> 'Total',
+++	'ST_TOPICS'					=> 'Tópicos',
+++	'ST_TOPICS_PER_DAY'			=> 'Tópicos por dia',
+++	'ST_TOPICS_PER_USER'		=> 'Tópicos por utilizador',
+++	'ST_TOTAL_USERS'			=> 'Total utilizadores',
+++	'ST_USERS_PER_DAY'			=> 'Utilizadores por dia',
+++	'ST_VISIT_IP'				=> 'O teu IP',
+++
+++	'WIO_ONLINE'			=> 'Utilizadores online',
+++	'WIO_LASTDAY'			=> 'Utilizadores hoje',
+++	'WIO_TOTAL'				=> 'Total',
+++	'WIO_REGISTERED'		=> 'Registados',
+++	'WIO_HIDDEN'			=> 'Ocultos',
+++	'WIO_GUEST'				=> 'Visitantes',
+++
+++	// polls
+++	'NO_POLL'			=> 'Votação indisponível',
+++
+++	// attachments_block
+++	'ATTACH_DATE'			=> 'Publicado',
+++	'ATTACH_SIZE'			=> 'Tamanho',
+++	'ATTACH_DOWNLOAD'		=> 'Transferido',
+++	'ATTACH_VIEW'			=> 'Visto',
+++
+++	'ATTACH_COUNT'				=> array(
+++		0	=> 'Nunca',
+++		1	=> '%d vez',
+++		2	=> '%d vezes',
+++	),
+++
+++	'VIEW_TOPIC'				=> 'Ver Tópico',
+++	'DOWNLOAD'					=> 'Download',
+++	'NO_ATTACHMENTS'			=> 'Sem anexos disponíveis',
+++
+++	// language_select_block
+++	'LANGUAGE_CHANGE'		=> 'Alterar idioma',
+++	'LANGUAGE_DEFAULT'		=> 'Idioma Original',
+++	'LANGUAGE_SET_MINE'		=> 'Gravar como meu idioma',
+++	'LANGUAGE_SELECT'		=> 'Selecionar Idioma',
+++
+++	// news_block
+++	'POSTED_BY'			=> 'Criado por',
+++	'LAST_REPLIED_BY'	=> 'Última resposta por',
+++	'COMMENTS_PORTAL'	=> 'Comentários',
+++	'POLL'				=> 'Votação',
+++	'TOPIC_VIEWS'		=> 'Visto',
+++	'NO_NEWS'			=> 'Sem notícias disponíveis',
+++	'VIEW_COMMENTS'		=> 'Ver comentários',
+++
+++	// recent_topics_block
+++	'BLG_RECENT_ACTIVITY'	=> 'Actividade Recente',
+++	'BLG_RECENT_ANN'		=> 'Anúncios Recentes',
+++	'BLG_RECENT_TOPICS'		=> 'Tópicos Recentes',
+++
+++	// paypal_block
+++	'AMOUNT_MSG'		=> 'Amount to donate',
+++	'CLICK_MSG'			=> 'Proceed to donation',
+++	'CODE_MSG'			=> 'Currency',
+++	
+++	'currencies'	=> array(
+++		'AUD'	=> 'Aussie',
+++		'CAD' 	=> 'Canadian Dollar',
+++		'CZK' 	=> 'Czech Koruna',
+++		'DKK' 	=> 'Danish Kroner',
+++		'HKD' 	=> 'Hong Kong Dollar',
+++		'HUF' 	=> 'Hungarian Forint',
+++		'NZD' 	=> 'New Zealand Dollar',
+++		'NOK' 	=> 'Norwegian Kroner',
+++		'PLN' 	=> 'Polish Zlotych',
+++		'GBP' 	=> 'British Pounds',
+++		'SGD' 	=> 'Singapore Dollar',
+++		'SEK' 	=> 'Swedish Kronor',
+++		'CHF' 	=> 'Swiss Francs',
+++		'JPY' 	=> 'Japanese Yen',
+++		'USD' 	=> 'Dollar',
+++		'EUR' 	=> 'Euro',
+++		'AUD' 	=> 'Mexican Peso',
+++		'ILS' 	=> 'New Israeli Shekels'
+++	),
+++
+++	// most_poster_block
+++	'MEMBER_POSTS'		=> '%d (%.2f/dia)',
+++	'USER'				=> 'Utilizador',
+++	'NO_MOST_POSTER'	=> 'Sem utilizadores para exibir',
+++
+++	// contact block
+++	'EMAIL_EMPTY'		=> 'You must set an email.',
+++	'EMAIL_INVALID'		=> 'The entered email is invalid.',
+++
+++	// counter block
+++	'COUNTER_LOCAL'		=> 'Visits to this page',
+++	'COUNTER_TOTAL' 	=> 'Total visits',
+++	'COUNTER_STARTDATE' => 'Counting from:<br />%s',
+++	'HITS_PER_DAY'		=> 'Visits per day',
+++	'HITS_PER_HOUR'		=> 'Visits per hour',
+++	'HITS_PER_MONTH'	=> 'Visits per month',
+++	'HITS_PER_USER'		=> 'Visits per user',
+++	'HITS_PER_WEEK'		=> 'Visits per week',
+++	'HITS_PER_YEAR'		=> 'Visits per year',
+++
+++	// style_select_block
+++	'STYLE_CHANGE'		=> 'Change Style',
+++	'STYLE_DEFAULT'		=> 'Original style',
+++	'STYLE_SET_MINE'	=> 'Set as my style',
+++	'STYLE_SELECT'		=> 'Select style',
+++
+++	// latest_bots_block
+++	'NO_BOTS'			=> 'Nenhum bot visitou o fórum',
+++
+++	// latest_unread_block
+++	'NO_UNREAD'			=> 'Sem tópicos',
+++
+++	// ranks_block
+++	'MIN_POSTS'			=> 'Minimum Posts',
+++	'SPECIAL_RANK'		=> 'Special Rank',
+++
+++	// online_friends_block
+++	'FRIENDS_ONLINE'		=> 'Online friends',
+++	'FRIENDS_OFFLINE'		=> 'Offline friends',
+++	'NO_FRIENDS_ONLINE'		=> 'No friends online',
+++	'NO_FRIENDS_OFFLINE'	=> 'No friends offline',
+++	'NO_FRIENDS'			=> 'No friends found',
+++
+++	// age_ranges_block
+++	'RANGE'				=> 'Rank',
+++	'RANGE_USERS'		=> 'Utilizadores (%)',
+++	'AGE_COUNTS'		=> 'Utilizadores contados',
+++	'AGE_AV'			=> 'Idade média',
+++	'AGE_AV_COUNT'		=> '%.2f anos',
+++
+++	// search_block
+++	'SH_ENGINE'			=> 'Search Engines',
+++
+++	// announcements_block
+++	'NO_ANNOUNCEMENTS'	=> 'Sem Anúncios',
+++
+++	//birthday_block
+++	'TODAY_BIRTHDAYS'		=> 'Today Birthdays',
+++	'TOMORROW_BIRTHDAYS'	=> 'Tomorrow Birthdays',
+++	'BIRTHDAYS_FOR'			=> 'Birthdays for %1$s of %2$s',
+++
+++	// calendar
+++	'ADD_EVENT'				=> 'Adicionar evento',
+++	'DELETE_EVENT'			=> 'Remover Evento',
+++	'EDIT_EVENT'			=> 'Editar Evento',
+++	'EVENTS'				=> 'Eventos',
+++
+++	'EMPTY_EVENT_TITLE'	=> 'Tem de colocar um título para o evento.',
+++	'EVENT_ADDED'		=> 'Evento adicionado com sucesso',
+++	'EVENT_COLOR'		=> 'Cor',
+++	'EVENT_EDITED'		=> 'Evento editado com sucesso',
+++	'EVENT_GROUPS'		=> 'Grupos autorizados',
+++	'EVENT_TITLE'		=> 'Título do Evento',
+++	'EVENT_TIME'		=> 'Data do Evento',
+++	'EVENT_DETAILS'		=> 'Detalhes',
+++	'EVENT_REMOVED'		=> 'Evento removido com sucesso',
+++	'NO_EVENTS'			=> 'Sem eventos',
+++	
+++	//player block
+++	'MUTE'				=> 'Silenciar',
+++	'WIN_CLOSE'			=> 'Fechar janela e regressar ao bloco',
+++	'WIN_OPEN'			=> 'Abrir numa nova janela',
+++	'WIN_OPEN_EXPLAIN'	=> 'Playing in Window',
+++	'WIN_RETURN'		=> 'Forze player in the block',
+++	'PLAY'				=> 'Play',
+++	'PLAY_MSG'			=> 'Playing',
+++	'PLAYER'			=> 'Player',
+++	'STOP'				=> 'Parar',
+++	'STOP_MSG'			=> 'Parou',
+++	'VOLUME'			=> 'Volume',
+++	'VOLUME_MSG'		=> 'Volume: %d%',
+++	
+++	// rss block
+++	'NO_RSS'		=> 'Sem Rss/Feed para mostrar.',
+++
+++	// topic index block
+++	'CHAR_ALL'		=> 'Todos',
+++	
+++	// youtube block
+++	'YT_EMPTY'		=> 'Sem vídeos para mostrar',
+++	'YT_VIEWS'		=> '%d vistos',
+++));
+++
+++// General messages
+++$lang = array_merge($lang, array(
+++	'ACTION_ERROR'		=> 'No action taken',
+++	'BLOCK_LOAD_ERROR'	=> 'Failed to load block',
+++	'FORMAT_INVALID'	=> 'The format is not valid',
+++	'EVENT_ERROR'		=> 'The selected event does not exist',
+++	'NO_TRACKLIST'		=> 'No avaliable tracklist.',
+++	'NO_PAGE'			=> 'This page no exists.',
+++	'URL_INVALID'		=> 'The URL is not valid.',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/block_view.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/block_view.html"
++deleted file mode 100644
++index 31ea38fac..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/block_view.html"
+++++ /dev/null
++@@ -1,62 +0,0 @@
++-	
++-{% if block.IS_GROUP %}
++-	<div id="block-{{ block.BLOCK_ID }}" class="blg-grid">
++-	{% for sub in block.blocks %}
++-		<div id="block-{{ sub.BLOCK_ID }}" class="blg-block {{ sub.BLOCK_CLASSES }}"{% if sub.DOM_STYLE %} style="{{ sub.DOM_STYLE}} "{% endif %}>
++-		{% if sub.BLOCK_STYLE == 'content_simple' %}
++-			<div class="block-content">
++-				{{ sub.BLOCK_CONTENT }}
++-			</div>
++-		{% else %}
++-			<table class="footable table table-striped table-bordered table-white table-primary default footable-loaded">
++-			<thead>
++-				<tr>
++-					<th class="block-title">
++-						{{ sub.BLOCK_ICON }}
++-						<span class="cbb-helper-text cbb-inline">{{ sub.BLOCK_TITLE }}</span>
++-					</th>
++-				</tr>
++-			</thead>
++-			<tbody>
++-			<tr>
++-				<td>
++-					<div class="block-content">
++-						{{ sub.BLOCK_CONTENT }}
++-					</div>
++-				</td>
++-			</tr>
++-			</tbody>
++-			</table>
++-		{% endif %}
++-		</div>
++-	{% endfor %}
++-	</div>
++-{% else %}
++-	<div id="block-{{ block.BLOCK_ID }}" class="blg-block {{ block.BLOCK_CLASSES }}">
++-	{% if block.BLOCK_STYLE == 'content_simple' %}
++-		<div class="block-content">
++-			{{ block.BLOCK_CONTENT }}
++-		</div>
++-	{% else %}
++-		<table class="footable table table-striped table-bordered table-white table-primary default footable-loaded">
++-		<thead>
++-			<tr>
++-				<th class="block-title">
++-					{{ block.BLOCK_ICON }}
++-					<span class="cbb-helper-text cbb-inline">{{ block.BLOCK_TITLE }}</span>
++-				</th>
++-			</tr>
++-		</thead>
++-		<tbody>
++-		<tr>
++-			<td>
++-				<div class="block-content">
++-					{{ block.BLOCK_CONTENT }}
++-				</div>
++-			</td>
++-		</tr>
++-		</tbody>
++-		</table>
++-	{% endif %}
++-    </div>
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/contact_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/contact_block.html"
++deleted file mode 100644
++index 82cc5006b..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/contact_block.html"
+++++ /dev/null
++@@ -1,59 +0,0 @@
++-
++-<script>
++-// <![CDATA[
++-	window._jPostponed = window._jPostponed || [];
++-	window._jPostponed.push(function() {
++-		$('#block-{{ BLOCK_ID }} form').cbbAjaxify({
++-			onSuccess: function() {
++-				this.element.find('[name=subject], [name=message]').val('');
++-			}
++-		});
++-	});
++-// ]]>
++-</script>
++-
++-<form method="post" action="{{ U_BLG_ACTION }}">
++-	<table class="blg-table contact-table {% if BLOCK_VIEW_SMALL %}short-view{% else %}full-table{% endif %}">
++-{% if BLOCK_VIEW_SMALL %}
++-	{% for fieldrow in loops.fieldrow %}
++-	<tr>
++-		<td>
++-			<strong>{{ fieldrow.TITLE ~ lang('COLON') }}</strong><br />
++-		{% if fieldrow.TYPE == 'text' %}
++-			<input type="text" name="{{ fieldrow.KEY }}" id="{{ fieldrow.KEY }}" size="35" value="{{ fieldrow.VALUE }}" class="cbb-inputbox" />
++-		{% elseif fieldrow.TYPE == 'textarea' %}
++-			<textarea name="{{ fieldrow.KEY }}" id="{{ fieldrow.KEY }}" cols="30" rows="6" class="cbb-inputbox">{{ fieldrow.VALUE }}</textarea>
++-		{% elseif fieldrow.TYPE == 'custom' %}
++-			{{ fieldrow.TEMPLATE }}
++-		{% endif %}
++-		</td>
++-	</tr>
++-	{% endfor %}
++-{% else %}
++-		<col width="35%" /><col width="65%" />
++-	{% for fieldrow in loops.fieldrow %}
++-		<tr>
++-			<td class="blg-align-right"{% if fieldrow.TYPE == 'textarea' %} valign="top"{% endif %}>
++-				<label for="{{ fieldrow.KEY }}"><strong>{{ fieldrow.TITLE ~ lang('COLON') }}</strong></label>
++-			</td>
++-			<td>
++-			{% if fieldrow.TYPE == 'text' %}
++-				<input type="text" name="{{ fieldrow.KEY }}" id="{{ fieldrow.KEY }}" size="35" value="{{ fieldrow.VALUE }}" class="cbb-inputbox autowidth" />
++-			{% elseif fieldrow.TYPE == 'textarea' %}
++-				<textarea name="{{ fieldrow.KEY }}" id="{{ fieldrow.KEY }}" cols="30" rows="8" class="cbb-inputbox">{{ fieldrow.VALUE }}</textarea>
++-			{% elseif fieldrow.TYPE == 'custom' %}
++-				{{ fieldrow.TEMPLATE }}
++-			{% endif %}
++-			</td>
++-		</tr>
++-	{% endfor %}
++-{% endif %}
++-	</table>
++-
++-	<br />
++-	<div class="blg-align-center">
++-		<input type="submit" class="btn btn-default" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />
++-		{{ BLOCK_HIDDEN_FIELDS }}
++-		{{ S_FORM_TOKEN_BLG_CONTACT }}
++-	</div>
++-</form>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/forums_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/forums_block.html"
++deleted file mode 100644
++index 7839fb0bb..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/forums_block.html"
+++++ /dev/null
++@@ -1,110 +0,0 @@
++-
++-{% if BLOCK_VIEW_SMALL and not BLOCK_VIEW_MEDIUM %}
++-<ul class="blg-linear-list">
++-
++-{% for forum_row in loops.forum_row %}
++-	{% if forum_row.S_IS_CAT or forum_row.S_FIRST_ROW or forum_row.S_NO_CAT %}
++-	<li class="menu-cat">
++-		{% if forum_row.S_IS_CAT %}<a href="{{ forum_row.U_VIEWFORUM }}">{{ forum_row.FORUM_NAME }}</a>{% else %}{{ lang('FORUM') }}{% endif %}
++-	</li>
++-	{% endif %}
++-
++-	{% if not forum_row.S_IS_CAT %}
++-	<li class="subchild double-space">
++-		<i class="fa {{ forum_row.FORUM_ICON }} fa-lg"></i>
++-		<a href="{{ forum_row.U_VIEWFORUM }}">{{ forum_row.FORUM_NAME }}</a>
++-	</li>
++-	{% endif %}
++-
++-{% else %}
++-	<li><strong>{{ lang('NO_FORUMS') }}</strong></li>
++-{% endfor %}
++-
++-</ul>
++-
++-{% else %}
++-
++-<div class="blg-forum-list{% if BLOCK_VIEW_MEDIUM %} title-only{% endif %}">
++-
++-{% for forum_row in loops.forum_row %}
++-	{% if (forum_row.S_IS_CAT and not forum_row.S_FIRST_ROW) or forum_row.S_NO_CAT %}
++-		</tbody>
++-		</table>
++-
++-		{% if BLOCK_STYLE == 'content_simple' %}</div>{% endif %}
++-	{% endif %}
++-
++-	{% if forum_row.S_IS_CAT or forum_row.S_FIRST_ROW or forum_row.S_NO_CAT %}
++-		{% if BLOCK_STYLE == 'content_simple' %}
++-		<div class="panel panel-default">
++-		{% else %}
++-		<div class="blg-widget-header">
++-			{% if not BLOCK_VIEW_MEDIUM %}<div class="fb-lastpost-title">{{ lang('LAST_POST') }}</div>{% endif %}
++-			{% if forum_row.S_IS_CAT %}<a href="{{ forum_row.U_VIEWFORUM }}">{{ forum_row.FORUM_NAME }}</a>{% else %}{{ lang('FORUM') }}{% endif %}
++-		</div>
++-		{% endif %}
++-
++-		<table class="footable table table-striped table-bordered table-white table-primary table-hover topics-table">
++-		{% if BLOCK_STYLE == 'content_simple' %}
++-		<thead>
++-			<tr><th colspan="3">{{ BLOCK_TITLE }}</th></tr>
++-		</thead>
++-		{% endif %}
++-
++-		<tbody>
++-	{% endif %}
++-
++-	{% if not forum_row.S_IS_CAT %}
++-		<tr>
++-			<td>
++-				{% if forum_row.FORUM_IMAGE %}<span class="forum-image">{{ forum_row.FORUM_IMAGE }}</span>{% endif %}
++-				<span class="icon-wrapper">
++-					<i class="row-icon-font icon-moon-default{% if forum_row.S_IS_LINK %} icon-moon-link2{% endif %}{% if forum_row.S_UNREAD_FORUM %} forum-unread{% else %} forum-read{% endif %}"></i>
++-				</span>
++-				<span class="desc-wrapper">
++-					<a href="{{ forum_row.U_VIEWFORUM }}" class="forumtitle">{{ forum_row.FORUM_NAME }}</a><br />
++-					{{ forum_row.FORUM_DESC }}
++-					{% if forum_row.MODERATORS %}
++-						<span class="forum-mods"><strong>{{ forum_row.L_MODERATOR_STR ~ lang('COLON') }}</strong>&nbsp;{{ forum_row.MODERATORS }}</span>
++-					{% endif %}
++-					{% if forum_row.SUBFORUMS and forum_row.S_LIST_SUBFORUMS %}
++-					<br />
++-					<span class="subforums">
++-				 		 <strong>{{ forum_row.L_SUBFORUM_STR }}</strong>
++-				 		 {{ forum_row.SUBFORUMS }}
++-				 	</span>
++-					{% endif %}
++-
++-				</span>
++-			</td>
++-		{% if not BLOCK_VIEW_MEDIUM %}
++-			{% if forum_row.CLICKS %}
++-				<td colspan="2"><span class="stats-wrapper">{{ lang('REDIRECTS') ~ lang('COLON') }} {{ forum_row.CLICKS }}</td>
++-			{% elseif not forum_row.S_IS_LINK %}
++-				<td class="fb-stats blg-align-center">{{ forum_row.TOPICS }} {{ lang('TOPICS') }}<br />{{ forum_row.POSTS }} {{ lang('POSTS') }}</dd>
++-				<td class="lastpost">
++-				{% if forum_row.LAST_POST_TIME %}
++-					<a class="cbb-helper-text" href="{{ forum_row.U_LAST_POST }}" title="{{ forum_row.LAST_POST_SUBJECT }}">{{ forum_row.LAST_POST_SUBJECT }}</a>
++-					<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ forum_row.LAST_POSTER_FULL }}
++-					<br /><span class="forum-time"><i class="fa fa-clock-o"></i>&nbsp;{{ forum_row.LAST_POST_TIME }}</span>
++-				{% else %}
++-					{{ lang('NO_POSTS') }}<br />&nbsp;
++-				{% endif %}
++-				</td>
++-			{% endif %}
++-		{% endif %}
++-		</tr>
++-	{% endif %}
++-	
++-	{% if forum_row.S_LAST_ROW %}
++-	</tbody>
++-	</table>
++-
++-		{% if BLOCK_STYLE == 'content_simple' %}</div>{% endif %}
++-	{% endif %}
++-{% else %}
++-	<strong>{{ lang('NO_FORUMS') }}</strong>
++-{% endfor %}
++-
++-</div>
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/language_select_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/language_select_block.html"
++deleted file mode 100644
++index 9771df9ab..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/language_select_block.html"
+++++ /dev/null
++@@ -1,21 +0,0 @@
++-
++-<script>
++-// <![CDATA[
++-	window._jPostponed = window._jPostponed || [];
++-	window._jPostponed.push(function() {
++-		$('#block-{{ BLOCK_ID }} form').cbbAjaxify();
++-	});
++-// ]]>
++-</script>
++-
++-<form method="post" action="{{ U_BLG_ACTION }}">
++-	<ul class="blg-linear-list blg-align-center">
++-		<li class="double-space"><select name="lng" class="cbb-inputbox">{{ LANGUAGE_SELECT }}</select></li>
++-		{% if CAN_SAVE_LANGUAGE %}<li class="doubl-space"><label><input type="checkbox" name="default" value="1" /> {{ lang('LANGUAGE_SET_MINE') }}</label></li>{% endif %}
++-		<li class="double-space">
++-			<input type="submit" name="submit" class="btn btn-default" value="{{ lang('LANGUAGE_CHANGE') }}" />
++-			{{ S_BLOCK_HIDDEN_FIELDS }}
++-		</li>
++-		{% if U_LANGUAGE_DEFAULT %}<li class="double-space"><a href="{{ U_LANGUAGE_DEFAULT }}">{{ lang('LANGUAGE_DEFAULT') }}</a></li>{% endif %}
++-	</ul>
++-</form>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/login_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/login_block.html"
++deleted file mode 100644
++index 2628376de..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/login_block.html"
+++++ /dev/null
++@@ -1,103 +0,0 @@
++-
++-{% if S_USER_LOGGED_IN %}
++-<script>
++-// <![CDATA[
++-	window._jPostponed = window._jPostponed || [];
++-	window._jPostponed.push(function() {
++-		$('#block-{{ BLOCK_ID }} #blg-logout').cbbAjaxify();
++-	});
++-// ]]>
++-</script>
++-
++-<ul class="blg-linear-list blg-align-center">
++-	<li class="menu-cat">{{ USERNAME_FULL }}</li>
++-	<li class="double-space">
++-		<a href="{{ U_PROFILE }}">
++-			<span class="cbb-circular-avatar">{% if USER_AVATAR %}{{ USER_AVATAR }} {% else %}<span class="cbb-no-avatar"></span>{% endif %}</span>
++-		</a>
++-	</li>
++-
++-	{% if USER_RANK_IMG %}<li>{{ USER_RANK_TITLE }}<br />{{ USER_RANK_IMG }}</li>{% endif %}
++-	{% if S_LAST_VISIT %}<li class="double-space">{{ S_LAST_VISIT }}</li>{% endif %}
++-	{% if S_CURRENT_TIME %}<li class="double-space">{{ S_CURRENT_TIME }}</li>{% endif %}
++-	
++-	{{ S_BLG_LOGIN_FIELDS }}
++-</ul>
++-
++-<br />
++-
++-<ul class="blg-menu blg-linear-list">
++-{% for link in userlink %}
++-	<li>
++-		<i class="icon fa {% if link.ICON %}{{ link.ICON }}{% else %}fa-chevron-right{% endif %} fa-fw" aria-hidden="true"></i>
++-		<a href="{{ link.URL }}">{{ link.TITLE }}</a>
++-	</li>
++-{% endfor %}
++-
++-	<li class="blg-align-center double-space top-bordered"><a id="blg-logout" class="btn btn-default" href="{{ U_LOGOUT }}">{{ lang('LOGIN_LOGOUT') }}</a></li>
++-</ul>
++-
++-{% else %}
++-<script>
++-// <![CDATA[
++-	window._jPostponed = window._jPostponed || [];
++-	window._jPostponed.push(function() {
++-		$('#block-{{ BLOCK_ID }} form').cbbAjaxify();
++-	});
++-// ]]>
++-</script>
++-
++-<form action="{{ U_BLG_ACTION }}" method="post">
++-	<ul class="blg-linear-list blg-align-center">
++-		<li class="double-space bottom-bordered"><strong>{{ lang('LOGIN') }}</strong></li>
++-
++-		<li class="blg-align-left"><strong>{{ lang('USERNAME') ~ lang('COLON') }}</strong></li>
++-		<li><input class="cbb-inputbox full-width" type="text" name="username" value="{{ S_USERNAME }}" /></li>
++-		
++-		<li class="blg-align-left"><strong>{{ lang('PASSWORD') ~ lang('COLON') }}</strong></li>
++-		<li><input class="cbb-inputbox full-width" type="password" name="password" value="" /></li>
++-		{% if U_SEND_PASSWORD %}<li class="blg-align-left"><a href="{{ U_SEND_PASSWORD }}">{{ lang('FORGOT_PASS') }}</a></li>{% endif %}
++-		{% if U_RESEND_ACTIVATION %}<li class="blg-align-left"><a href="{{ U_RESEND_ACTIVATION }}">{{ lang('RESEND_ACTIVATION') }}</a></li>{% endif %}
++-	</ul>
++-	
++-	{% if S_DISPLAY_FULL_LOGIN %}
++-	<br />
++-	<ul class="blg-linear-list">
++-		{% if S_AUTOLOGIN_ENABLED %}
++-		<li>
++-			<input id="autologin-{{ BLOCK_ID }}" type="checkbox" class="radio cbb-checkbox" name="autologin" />
++-			<label for="autologin-{{ BLOCK_ID }}">{{ lang('REMEMBER_ME') }}</label>
++-		</li>
++-		{% endif %}
++-		
++-		<li>
++-			<input id="viewonline-{{ BLOCK_ID }}" type="checkbox" class="radio cbb-checkbox" name="viewonline" />
++-			<label for="viewonline-{{ BLOCK_ID }}">{{ lang('HIDE_ME_NOW') }}</label>
++-		</li>
++-	</ul>
++-	{% endif %}
++-
++-	<div class="blg-align-center">
++-		<br />
++-		<input type="submit" name="login" class="btn btn-default" value="{{ lang('LOGIN') }}" />
++-		{{ S_BLG_LOGIN_FIELDS }}
++-		{{ S_FORM_TOKEN_BLG_LOGIN }}
++-	</div>
++-</form>
++-
++-	{% if PROVIDER_TEMPLATE_FILE %}
++-		{% INCLUDE PROVIDER_TEMPLATE_FILE %}
++-	{% endif %}
++-
++-	{% if S_REGISTER_ENABLED and S_DISPLAY_REGISTER %}
++-	<br />
++-	<ul class="blg-linear-list">
++-		<li class="double-space bottom-bordered blg-align-center"><strong>{{ lang('REGISTER') }}</strong></li>
++-		<li><i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i> <a href="{{ U_TERMS_USE }}">{{ lang('TERMS_USE') }}</a></li>
++-		<li><i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i> <a href="{{ U_PRIVACY }}">{{ lang('PRIVACY') }}</a></li>
++-	
++-		<li class="double-space blg-align-center"><a href="{{ U_REGISTER }}"><input type="button" class="btn btn-default" value="{{ lang('REGISTER') }}" /></a></li>
++-	</ul>
++-	{% endif %}
++-
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/news_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/news_block.html"
++deleted file mode 100644
++index a6eb7f79f..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/news_block.html"
+++++ /dev/null
++@@ -1,143 +0,0 @@
++-
++-<div id="news-{{ BLOCK_ID }}"{% if S_NEWS_FULL_CONTENT || S_NEWS_COLLAPSE %} class="cbb-helper-hidden"{% endif %}>
++-
++-<script>
++-// <![CDATA[
++-	window._jPostponed = window._jPostponed || [];
++-	window._jPostponed.push(function() {
++-
++-	{% if S_NEWS_FULL_CONTENT or S_NEWS_COLLAPSE %}
++-		$('#news-{{ BLOCK_ID }}').blgAccordion({
++-			collapsable: '{{ S_NEWS_COLLAPSE }}'
++-		});
++-	{% endif %}
++-
++-		$('#news-{{ BLOCK_ID }}').cbbLoader({
++-			replace: true,
++-			requestData: {
++-				jblgm: '{{ BLOCK_ID }}',
++-			}
++-		});
++-
++-		this.call('@blockgets/resizeImages', '#news-{{ BLOCK_ID }} .news-content');
++-	});
++-// ]]>
++-</script>
++-
++-{% if news_row|length %}
++-
++-{% if not S_NEWS_FULL_CONTENT and not S_NEWS_COLLAPSE %}
++-
++-	<ul class="blg-linear-list">
++-	{% for topicrow in news_row %}
++-		<li class="double-space">
++-			<div>
++-				<i class="fa fa-bullhorn fa-lg" aria-hidden="true"></i>
++-				{% EVENT topiclist_row_prepend %}
++-				<a href="{{ topicrow.U_VIEW_TOPIC }}"><strong>{{ topicrow.TOPIC_TITLE }}</strong></a>
++-			</div>
++-			<div>
++-				{{ lang('POSTED_BY') ~ lang('COLON') }}
++-				<strong>{{ topicrow.TOPIC_AUTHOR_FULL }}</strong>
++-				{% if BLOCK_VIEW_SMALL %}<br />{% else %}&bull;{% endif %} {{ topicrow.FIRST_POST_TIME }}
++-			</div>
++-		</li>
++-	{% endfor %}
++-	</ul>
++-
++-{% else %}
++-
++-	{% for topicrow in news_row %}
++-		<h5>
++-			{% EVENT topiclist_row_prepend %}
++-			<span>{{ topicrow.TOPIC_TITLE }}</span>
++-		</h5>
++-		<div>
++-		{% if BLOCK_VIEW_SMALL %}
++-			<div>{{ topicrow.FIRST_POST_TIME }}</div>
++-			<div>{{ lang('POSTED_BY') ~ lang('COLON') }} <strong>{{ topicrow.TOPIC_AUTHOR_FULL }}</strong></div>
++-			{% if topicrow.FORUM_NAME and S_NEWS_FULL_CONTENT %}<div>{{ lang('FORUM') ~ lang('COLON') }} <strong><a href="{{ topicrow.U_VIEW_FORUM }}">{{ topicrow.FORUM_NAME }}</a></strong></div>{% endif %}
++-		
++-			{% if S_NEWS_FULL_CONTENT %}
++-			<div class="news-content">{{ topicrow.TEXT }}</div>
++-			
++-			<div>
++-				<hr />
++-				<a href="{{ topicrow.U_VIEW_COMMENTS }}" title="{{ lang('VIEW_COMMENTS') }}">{{ lang('COMMENTS') ~ lang('COLON') }} {{ topicrow.REPLIES }}</a> <br />
++-				<a href="{{ topicrow.U_VIEW_TOPIC }}" title="{{ lang('READ_FULL') }}">{{ lang('TOPIC_VIEWS') ~ lang('COLON') }} {{ topicrow.VIEWS }}</a>
++-			</div>
++-			{% endif %}
++-		
++-		{% else %}
++-			<table class="blg-table">
++-			<tr>
++-				<td class="blg-align-left">{% if topicrow.S_HAS_ATTACHMENTS %}<i class="fa fa-paperclip fa-lg" aria-hidden="true"></i> {% endif %}{% if topicrow.S_HAS_POLL %}<strong>{{ lang('POLL') ~ lang('COLON') }} </strong>{% endif %}<a href="{{ topicrow.U_VIEW_TOPIC }}"><strong>{{ topicrow.TOPIC_TITLE }}</strong></a></td>
++-				<td class="blg-align-right">{{ topicrow.FIRST_POST_TIME }}</td>
++-			</tr>
++-		
++-			<tr>
++-				<td colspan="2">{{ lang('POSTED_BY') ~ lang('COLON') }} <strong>{{ topicrow.TOPIC_AUTHOR_FULL }}</strong></td>
++-			</tr>
++-		
++-		{% if S_NEWS_FULL_CONTENT %}
++-		
++-			{% if topicrow.FORUM_NAME %}<tr><td colspan="2">{{ lang('FORUM') ~ lang('COLON') }} <strong><a href="{{ topicrow.U_VIEW_FORUM }}">{{ topicrow.FORUM_NAME }}</a></strong></td></tr>{% endif %}
++-		
++-			<tr>
++-				<td colspan="2" class="blg-align-{{ S_CONTENT_FLOW_BEGIN }}">
++-		
++-					<div class="news-content">{{ topicrow.TEXT }}</div>
++-					  
++-				{% if topicrow.S_HAS_ATTACHMENTS %}
++-					<dl class="attachbox">
++-						<dt>{{ lang('ATTACHMENTS') }}</dt>
++-						{% for attachment in topicrow.attachment %}
++-							<dd>{{ attachment.DISPLAY_ATTACHMENT }}</dd>
++-						{% endfor %}
++-					</dl>
++-				{% endif %}
++-		
++-				</td>
++-			</tr>
++-		
++-			<tr>
++-				<td colspan="2" class="blg-align-left">
++-					<span>{{ lang('COMMENTS') ~ lang('COLON') }} {{ topicrow.REPLIES }}</span> &bull;
++-					<a href="{{ topicrow.U_POST_REPLY }}" title="{{ lang('POST_REPLY') }}">{{ lang('POST_REPLY') }}</a> &bull;
++-					<a href="{{ topicrow.U_VIEW_TOPIC }}" title="{{ lang('READ_FULL') }}">{{ lang('TOPIC_VIEWS') ~ lang('COLON') }} {{ topicrow.VIEWS }}</a>
++-				</td>
++-			</tr>
++-		{% endif %}
++-			</table>
++-		{% endif %}
++-		</div>
++-	{% endfor %}
++-
++-{% endif %}
++-
++-{% if block_pagination|length %}
++-	<div class="pull-right">	 
++-		<ul class="pagination pagination-forum {% if BLOCK_VIEW_SMALL %}pagination-xs{% else %}pagination-sm{% endif %} hidden-xs">
++-		{% for pagination in block_pagination %}
++-			{% if pagination.S_IS_PREV %}
++-			<li class="previous"><a href="{{ pagination.PAGE_URL }}" rel="prev" role="button">{{ lang('PREVIOUS') }}</a></li>
++-			{% elseif pagination.S_IS_CURRENT %}
++-			<li class="active"><span>{{ pagination.PAGE_NUMBER }}</span></li>
++-			{% elseif pagination.S_IS_ELLIPSIS %}
++-			<li class="ellipsis" role="separator"><span>{{ lang('ELLIPSIS') }}</span></li>
++-			{% elseif pagination.S_IS_NEXT %}
++-			<li class="next"><a href="{{ pagination.PAGE_URL }}" rel="next" role="button">{{ lang('NEXT') }}</a></li>
++-			{% else %}
++-			<li><a href="{{ pagination.PAGE_URL }}" role="button">{{ pagination.PAGE_NUMBER }}</a></li>
++-			{% endif %}
++-		{% endfor %}
++-		</ul>
++-	</div>
++-	<div class="cbb-helper-clear"></div>
++-{% endif %}
++-
++-{% else %}
++-<div class="blg-align-center">{{ lang('NO_NEWS') }}</div>
++-{% endif %}
++-
++-</div>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/poll_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/poll_block.html"
++deleted file mode 100644
++index a268f2907..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/poll_block.html"
+++++ /dev/null
++@@ -1,59 +0,0 @@
++-{% if poll|length %}
++-	<script>
++-	// <![CDATA[
++-		window._jPostponed = window._jPostponed || [];
++-		window._jPostponed.push(function() {
++-			$('#poll-{{ BLOCK_ID }}').cbbAjaxify({
++-				onSuccess: function(response) {
++-					this.element.replaceWith(response.htmlContent);
++-				}
++-			});
++-		});
++-	// ]]>
++-	</script>
++-
++-{% for poll in loops.poll %}
++-{% if poll.S_CAN_VOTE %}<form id="poll-{{ BLOCK_ID }}" method="post" action="{{ U_BLG_ACTION }}">{% endif %}
++-	<ul class="blg-linear-list blg-align-center">
++-		<li class="double-space menu-cat">{{ poll.S_POLL_QUESTION }}</li>
++-		{% if poll.S_POLL_LENGTH %}<li>{{ poll.S_POLL_LENGTH }}</li>{% endif %}
++-		{% if poll.S_CAN_VOTE %}<li>{{ poll.S_MAX_VOTES }}</li>{% endif %}
++-	</ul>
++-
++-	{% for poll_option in poll.poll_option %}
++-	<div class="blg-poll-option">
++-		<div class="poll-option-title">
++-			{% if poll.S_CAN_VOTE %}<input type="{% if poll.S_IS_MULTI_CHOICE %}checkbox{% else %}radio{% endif %}" name="poll_vote_id[]" id="vote_{{ poll_option.POLL_OPTION_ID }}" value="{{ poll_option.POLL_OPTION_ID }}"{% if poll_option.POLL_OPTION_VOTED %} checked="checked"{% endif %} />{% endif %}
++-			{{ poll_option.POLL_OPTION_CAPTION }}
++-		</div>
++-
++-		{% if poll.S_DISPLAY_RESULTS %}
++-		<div class="poll-option-results">
++-			<div class="blg-progressbar" title="{{ poll_option.POLL_OPTION_PERCENT }}"><div style="width:{{ poll_option.POLL_OPTION_PERCENT }};"></div></div>
++-			<div class="poll-option-text">
++-				{% if poll_option.POLL_OPTION_VOTED %}<i class="fa fa-check-circle-o fa-lg" title="{{ lang('POLL_VOTED_OPTION') }}"></i>{% endif %}
++-				{{ poll_option.POLL_OPTION_PERCENT }}
++-			</div>
++-		</div>
++-		{% endif %}
++-	</div>
++-	{% endfor %}
++-
++-	<br />
++-	
++-	<ul class="blg-linear-list blg-align-center">
++-		{% if poll.S_CAN_VOTE %}<li><input type="submit" name="update_vote" value="{{ lang('SUBMIT_VOTE') }}" class="btn btn-default" /></li>{% endif %}
++-		{% if poll.S_DISPLAY_RESULTS %}<li>{{ lang('TOTAL_VOTES') ~ lang('COLON') }} {{ poll.S_TOTAL_VOTES }}</li>{% endif %}
++-          
++-		<li><a href="{{ poll.U_POLL_RESULTS }}">{{ lang('VIEW_TOPIC') }}</a></li>
++-	</ul>
++-
++-{% if poll.S_CAN_VOTE %}
++-	<div>{{ poll.S_HIDDEN_FIELDS }}</div>
++-</form>
++-{% endif %}
++-{% endfor %}
++-
++-{% else %}
++-<div class="blg-align-center">{{ lang('NO_POLL') }}</div>
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/recent_topics_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/recent_topics_block.html"
++deleted file mode 100644
++index 41d16d466..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/recent_topics_block.html"
+++++ /dev/null
++@@ -1,137 +0,0 @@
++-
++-{% if SHOW_TABS %}
++-<script>
++-// <![CDATA[
++-	window._jPostponed = window._jPostponed || [];
++-	window._jPostponed.push(function() {
++-		$('#recent-{{ BLOCK_ID }}'){% if BLOCK_VIEW_SMALL %}.blgAccordion();{% else %}.cbbTabs();{% endif %}
++-	});
++-// ]]>
++-</script>
++-{% endif %}
++-
++-<div id="recent-{{ BLOCK_ID }}"{% if SHOW_TABS %} class="cbb-helper-hidden"{% endif %}>
++-
++-{% if BLOCK_VIEW_SMALL %}
++-	{% for tab in recent_tab %}
++-		<h5><a href="#">{{ tab.TITLE }}</a></h5>
++-		<div class="no-wrap">
++-			{% if tab.IS_EMPTY %}{{ lang('NO_ITEMS') }}{% endif %}
++-
++-			<ul class="blg-linear-list">
++-			{% for topicrow in tab.rows %}
++-				<li>
++-					{% EVENT topiclist_row_prepend %}
++-					<a class="cbb-helper-text cbb-inline" href="{{ topicrow.U_VIEW_TOPIC }}">{{ topicrow.TOPIC_TITLE }}</a>
++-					{% EVENT topiclist_row_append %}
++-				</li>
++-			{% endfor %}
++-			</ul>
++-		</div>
++-	{% endfor %}
++-
++-{% else %}
++-
++-{% if SHOW_TABS %}
++-    <ul>
++-	{% for tab in recent_tab %}
++-		<li><a href="#{{ tab.ID }}-{{ BLOCK_ID }}"><i class="fa {{ tab.ICON }} fa-lg"></i>{% if not BLOCK_VIEW_MEDIUM %} <span class="tab-title">{{ tab.TITLE }}</span>{% endif %}</a></li>
++-	{% endfor %}
++-    </ul>
++-{% endif %}
++-
++-    {% if TOPIC_DESIGN == 'simple' %}
++-		{% for tab in recent_tab %}
++-			<div class="blg-align-center recent-content block-postbody" id="{{ tab.ID }}-{{ BLOCK_ID }}">
++-
++-				<div class="blg-table">
++-				{% if tab.IS_EMPTY %}
++-					<div class="blg-align-center"><span>{{ lang('NO_ITEMS') }}</span></div>
++-				{% else %}
++-					<div>
++-						<div class="blg-column-topic-title blg-widget-header">{{ lang('TOPIC_TITLE') }}</div>
++-						<div class="blg-column-posted-by blg-widget-header">{{ lang('POSTED_BY') }}</div>
++-					{% if not BLOCK_VIEW_MEDIUM %}
++-						<div class="blg-column-comments blg-widget-header">{{ lang('COMMENTS') }}</div>
++-						<div class="blg-column-topic-views blg-widget-header">{{ lang('TOPIC_VIEWS') }}</div>
++-					{% endif %}
++-					</div>
++-					
++-					{% for topicrow in tab.rows %}
++-						<div>
++-							<div class="blg-column-topic-title blg-align-left">
++-								{% EVENT topiclist_row_prepend %}
++-								<a href="{{ topicrow.U_VIEW_TOPIC }}" class="cbb-helper-text cbb-inline" title="{{ topicrow.TOPIC_TITLE_RAW|e }}">{{ topicrow.TOPIC_TITLE }}</a>
++-							</div>
++-							<div class="blg-column-posted-by blg-align-center">{{ topicrow.TOPIC_AUTHOR_FULL }}</div>
++-						{% if not BLOCK_VIEW_MEDIUM %}
++-							<div class="blg-column-comments blg-align-center"><a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_COMMENTS') }}">{{ topicrow.REPLIES }}</a></div>
++-							<div class="blg-column-topic-views blg-align-center">{{ topicrow.VIEWS }}</div>
++-						{% endif %}
++-						</div>
++-					{% endfor %}
++-				{% endif %}
++-				</div>
++-			</div>
++-		{% endfor %}
++-	{% else %}
++-		{% for tab in recent_tab %}
++-			<div id="{{ tab.ID }}-{{ BLOCK_ID }}" class="blg-forum-list{% if SHOW_TABS %} cbb-helper-hidden{% endif %}{% if BLOCK_VIEW_MEDIUM %} title-only{% endif %}">
++-			{% if tab.IS_EMPTY %}
++-				<div class="blg-message">{{ lang('NO_ITEMS') }}</div>
++-			{% else %}
++-				<div class="blg-widget-header">
++-					{% if not BLOCK_VIEW_MEDIUM %}<div class="fb-lastpost-title">{{ lang('LAST_POST') }}</div>{% endif %}
++-					<span>{{ lang('TOPIC') }}</span>
++-				</div>
++-				<table class="footable table table-striped table-bordered table-white table-primary table-hover topics-table">
++-				</tbody>
++-
++-				{% for topicrow in tab.rows %}
++-					{% EVENT viewforum_body_topicrow_row_before %}
++-					<tr>
++-						<td>
++-							{% if topicrow.TOPIC_ICON_IMG %}
++-							<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
++-							{% endif %}
++-
++-							<span class="icon-wrapper">
++-						    	<i class="row-icon-font icon-moon-default2{% if topicrow.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if topicrow.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if topicrow.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if topicrow.S_HAS_POLL %} icon-moon-poll{% endif %}{% if topicrow.S_TOPIC_MOVED %} icon-moon-moved{% endif %}{% if topicrow.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
++-							</span>
++-
++-							<i class="row-icon-font-mini{% if topicrow.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
++-							
++-							<div class="desc-wrapper">
++-					  			{% EVENT topiclist_row_prepend %}
++-								{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}
++-
++-								<br />{{ lang('POST_BY_AUTHOR') }}&nbsp;{{ topicrow.TOPIC_AUTHOR_FULL }} 
++-								<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
++-					 		 	{% EVENT topiclist_row_append %}	
++-							</div>
++-						</td>
++-
++-					{% if not BLOCK_VIEW_MEDIUM %}
++-						<td class="fb-stats blg-align-center">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
++-						<td class="lastpost">
++-							<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.LAST_POST_AUTHOR_FULL }}
++-							{% if not S_IS_BOT %}
++-								<a href="{{ topicrow.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">
++-									<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
++-								</a>
++-							{% endif %}
++-							<br /><i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
++-						</td>
++-					{% endif %}
++-					</tr>
++-					{% EVENT viewforum_body_topicrow_row_after %}
++-				{% endfor %}
++-
++-				</tbody>
++-				</table>
++-			{% endif %}
++-			</div>
++-		{% endfor %}
++-	{% endif %}
++-{% endif %}
++-</div>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/search_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/search_block.html"
++deleted file mode 100644
++index 2113918bf..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/search_block.html"
+++++ /dev/null
++@@ -1,71 +0,0 @@
++-<script>
++-// <![CDATA[
++-	window._jPostponed = window._jPostponed || [];
++-	window._jPostponed.push(function() {
++-		$('#block-{{ BLOCK_ID }} form').submit(function() {
++-			var searchUrls = {
++-				google		: 'https://www.google.com/search?q=',
++-				yahoo		: 'https://search.yahoo.com/search?p=',
++-				bing		: 'https://www.bing.com/search?q='
++-			};
++-
++-			var data = $(this).serializeObject();
++-
++-			if(!data.keywords || data.keywords == $(this).find('[name="keywords"]').attr('placeholder'))
++-			{
++-				return false;
++-			}
++-
++-			switch(data.engine)
++-			{
++-				case 'author':
++-					$(this).find('[name="keywords"]').attr('name', 'author');
++-
++-				case 'site':
++-					return true;
++-				break;
++-	
++-				case 'google':
++-				case 'yahoo':
++-				case 'bing':
++-					var url = searchUrls[data.engine];
++-
++-					if(url)
++-					{
++-						window.open(url + encodeURIComponent(data.keywords), '_' + data.engine, '');
++-					}
++-				break;
++-			}
++-
++-			return false;
++-		});
++-	});
++-// ]]>
++-</script>
++-
++-<form method="get" action="{{ U_SEARCH }}">
++-	<ul class="blg-linear-list blg-align-center">
++-		<li class="double-space"><input type="text" class="cbb-inputbox full-width" name="keywords" size="22" value="" placeholder="{{ lang('SEARCH_MINI') }}" /></li>
++-		<li class="double-space">
++-			<select name="engine" class="cbb-inputbox">
++-			{% if S_DISPLAY_SEARCH %}
++-				<optgroup label="{{ lang('FORUMS') }}">
++-					<option value="site">{{ lang('MESSAGES') }}</option>
++-					<option value="author">{{ lang('AUTHOR') }}</option>
++-				</optgroup>
++-			{% endif %}
++-				<optgroup label="{{ lang('SH_ENGINE') }}">
++-					<option value="google">Google</option>
++-					<option value="yahoo">Yahoo</option>
++-					<option value="bing">Bing</option>
++-				</optgroup>
++-			</select>
++-		</li>
++-
++-		<li class="double-space"><input class="btn btn-default" type="submit" value="{{ lang('SEARCH') }}" /></li>
++-
++-		{% if S_DISPLAY_SEARCH %}<li class="double-space top-bordered"><a href="{{ U_SEARCH }}" title="{{ lang('SEARCH_ADV_EXPLAIN') }}">{{ lang('SEARCH_ADV') }}</a></li>{% endif %}
++-	</ul>
++-	
++-	<div>{{ S_BLOCK_HIDDEN_FIELDS }}</div>
++-</form>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/style_select_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/style_select_block.html"
++deleted file mode 100644
++index 69d3926bb..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/style_select_block.html"
+++++ /dev/null
++@@ -1,21 +0,0 @@
++-
++-<script>
++-// <![CDATA[
++-	window._jPostponed = window._jPostponed || [];
++-	window._jPostponed.push(function() {
++-		$('#block-{{ BLOCK_ID }} form').cbbAjaxify();
++-	});
++-// ]]>
++-</script>
++-
++-<form method="post" action="{{ U_BLG_ACTION }}">
++-	<ul class="blg-linear-list blg-align-center">
++-		<li class="double-space"><select name="style" class="cbb-inputbox">{{ STYLE_SELECT }}</select></li>
++-		{% if CAN_SAVE_STYLE %}<li class="doubl-space"><label><input type="checkbox" name="default" value="1" /> {{ lang('STYLE_SET_MINE') }}</label></li>{% endif %}
++-		<li class="double-space">
++-			<input type="submit" name="submit" class="btn btn-default" value="{{ lang('STYLE_CHANGE') }}" />
++-			{{ S_BLOCK_HIDDEN_FIELDS }}
++-		</li>
++-		{% if U_STYLE_DEFAULT %}<li class="double-space"><a href="{{ U_STYLE_DEFAULT }}">{{ lang('STYLE_DEFAULT') }}</a></li>{% endif %}
++-	</ul>
++-</form>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/top_topics_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/top_topics_block.html"
++deleted file mode 100644
++index ee2986586..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/top_topics_block.html"
+++++ /dev/null
++@@ -1,87 +0,0 @@
++-
++-{% if BLOCK_VIEW_SMALL or TOPIC_DESIGN == 'simple' %}
++-{% for topicrow in top_topic %}
++-	{% if not topicrow.S_FIRST_ROW %}<hr />{% endif %}
++-	<div class="lunread-row">
++-		{% EVENT topiclist_row_prepend %}
++-		<a class="cbb-helper-text cbb-inline half-size" href="{{ topicrow.U_VIEW_TOPIC }}"><strong>{{ topicrow.TOPIC_TITLE }}</strong></a>
++-		{% if not BLOCK_VIEW_SMALL %}<span>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.TOPIC_AUTHOR_FULL }}</span>{% endif %}
++-		<span> &raquo; <em>{{ topicrow.FIRST_POST_TIME }}</em></span>
++-		{% EVENT topiclist_row_append %}
++-	</div>
++-{% else %}
++-	<div class="blg-align-center">{{ lang('NO_UNREAD') }}</div>
++-{% endfor %}
++-
++-{% else %}
++-
++-<div class="blg-forum-list{% if BLOCK_VIEW_MEDIUM %} title-only{% endif %}">
++-
++-	{% if BLOCK_STYLE == 'content_simple' %}
++-	<div class="panel panel-default">
++-	{% elseif top_topic|length %}
++-		<div class="blg-widget-header">
++-			{% if not BLOCK_VIEW_MEDIUM %}<div class="fb-lastpost-title">{{ lang('LAST_POST') }}</div>{% endif %}
++-			<span>{{ lang('TOPIC') }}</span>
++-		</div>
++-	{% endif %}
++-
++-		<table class="footable table table-striped table-bordered table-white table-primary table-hover topics-table">
++-	{% if BLOCK_STYLE == 'content_simple' %}
++-		<thead>
++-			<tr><th colspan="3">{{ BLOCK_TITLE }}</th></tr>
++-		</thead>
++-	{% endif %}
++-		<tbody>
++-
++-		{% for topicrow in top_topic %}
++-			{% EVENT viewforum_body_topicrow_row_before %}
++-			<tr>
++-				<td>
++-					{% if topicrow.TOPIC_ICON_IMG %}
++-					<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
++-					{% endif %}
++-
++-					<span class="icon-wrapper">
++-				    	<i class="row-icon-font icon-moon-default2{% if topicrow.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if topicrow.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if topicrow.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if topicrow.S_HAS_POLL %} icon-moon-poll{% endif %}{% if topicrow.S_TOPIC_MOVED %} icon-moon-moved{% endif %}{% if topicrow.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
++-					</span>
++-
++-					<i class="row-icon-font-mini{% if topicrow.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
++-					
++-					<div class="desc-wrapper">
++-			  			{% EVENT topiclist_row_prepend %}
++-						{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}
++-
++-						<br />{{ lang('POST_BY_AUTHOR') }}&nbsp;{{ topicrow.TOPIC_AUTHOR_FULL }} 
++-						<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
++-			 		 	{% EVENT topiclist_row_append %}	
++-					</div>
++-				</td>
++-
++-			{% if not BLOCK_VIEW_MEDIUM %}
++-				<td class="fb-stats blg-align-center">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
++-				<td class="lastpost">
++-					<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.LAST_POST_AUTHOR_FULL }}
++-					{% if not S_IS_BOT %}
++-						<a href="{{ topicrow.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">
++-							<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
++-						</a>
++-					{% endif %}
++-					<br /><i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
++-				</td>
++-			{% endif %}
++-			</tr>
++-			{% EVENT viewforum_body_topicrow_row_after %}
++-		{% else %}
++-			<tr><td colspan="3" class="blg-message">{{ lang('NO_UNREAD') }}</td></tr>
++-		{% endfor %}
++-		</tbody>
++-		</table>
++-
++-	{% if BLOCK_STYLE == 'content_simple' %}
++-	</div>
++-	{% endif %}
++-
++-</div>
++-
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/topic_index_block.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/topic_index_block.html"
++deleted file mode 100644
++index 0afbd0292..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/blocks/topic_index_block.html"
+++++ /dev/null
++@@ -1,152 +0,0 @@
++-
++-<div id="topic-index-{{ BLOCK_ID }}">
++-
++-<script>
++-// <![CDATA[
++-	window._jPostponed = window._jPostponed || [];
++-	window._jPostponed.push(function() {
++-		$('#topic-index-{{ BLOCK_ID }}').cbbLoader({
++-			paginationSelector: '.pagination a, .char-select a',
++-			replace: true,
++-			requestData: {
++-				jblgm: '{{ BLOCK_ID }}',
++-				fchar: '{{ S_FIRST_CHAR }}'
++-			}
++-		});
++-	});
++-// ]]>
++-</script>
++-
++-{% if S_CHAR_SELECT %}
++-	<div class="char-select blg-align-center">
++-	{% for char in first_char %}
++-		{% if char.S_SELECTED %}<span>{{ char.DESC }}</span>{% else %}<a href="#?fchar={{ char.VALUE }}">{{ char.DESC }}</a>{% endif %}&nbsp; 
++-	{% endfor %}
++-	</div>
++-{% endif %}
++-
++-{% if BLOCK_VIEW_SMALL or TOPIC_DESIGN == 'simple' %}
++-	<div class="topic-index-content block-postbody blg-align-center blg-corner-all">
++-
++-	<div{% if not BLOCK_VIEW_SMALL and not BLOCK_VIEW_MEDIUM %} class="blg-table"{% endif %}>
++-		<div>
++-			<div class="blg-column-topic-title blg-widget-header">{{ lang('TOPIC_TITLE') }}</div>
++-		{% if not BLOCK_VIEW_SMALL and not BLOCK_VIEW_MEDIUM %}
++-			<div class="blg-column-posted-by blg-widget-header">{{ lang('POSTED_BY') }}</div>
++-			<div class="blg-column-comments blg-widget-header">{{ lang('COMMENTS') }}</div>
++-			<div class="blg-column-topic-views blg-widget-header">{{ lang('TOPIC_VIEWS') }}</div>
++-		{% endif %}
++-		</div>
++-		
++-	{% for topicrow in topic %}
++-		<div>
++-			<div class="blg-column-topic-title blg-align-left">
++-				{% EVENT topiclist_row_prepend %}
++-				<a href="{{ topicrow.U_VIEW_TOPIC }}" class="cbb-helper-text cbb-inline" title="{{ topicrow.TOPIC_TITLE_RAW|e }}">{{ topicrow.TOPIC_TITLE }}</a>
++-			</div>
++-		{% if not BLOCK_VIEW_SMALL and not BLOCK_VIEW_MEDIUM %}
++-			<div class="blg-column-posted-by blg-align-center">{{ topicrow.TOPIC_AUTHOR_FULL }}</div>
++-			<div class="blg-column-comments blg-align-center"><a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_COMMENTS') }}">{{ topicrow.REPLIES }}</a></div>
++-			<div class="blg-column-topic-views blg-align-center">{{ topicrow.VIEWS }}</div>
++-		{% endif %}
++-		</div>
++-	{% else %}
++-		<div><div class="blg-align-center" colspan="4">{{ lang('NO_TOPICS') }}</div></div>
++-	{% endfor %}
++-
++-	</div>
++-	</div>
++-
++-{% else %}
++-
++-<div class="blg-forum-list{% if BLOCK_VIEW_MEDIUM %} title-only{% endif %}">
++-
++-	{% if BLOCK_STYLE == 'content_simple' %}
++-	<div class="panel panel-default">
++-	{% elseif topic|length %}
++-		<div class="blg-widget-header">
++-			{% if not BLOCK_VIEW_MEDIUM %}<div class="fb-lastpost-title">{{ lang('LAST_POST') }}</div>{% endif %}
++-			<span>{{ lang('TOPIC') }}</span>
++-		</div>
++-	{% endif %}
++-
++-		<table class="footable table table-striped table-bordered table-white table-primary table-hover topics-table">
++-	{% if BLOCK_STYLE == 'content_simple' %}
++-		<thead>
++-			<tr><th colspan="3">{{ BLOCK_TITLE }}</th></tr>
++-		</thead>
++-	{% endif %}
++-		<tbody>
++-
++-		{% for topicrow in topic %}
++-			{% EVENT viewforum_body_topicrow_row_before %}
++-			<tr>
++-				<td>
++-					{% if topicrow.TOPIC_ICON_IMG %}
++-					<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
++-					{% endif %}
++-
++-					<span class="icon-wrapper">
++-				    	<i class="row-icon-font icon-moon-default2{% if topicrow.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if topicrow.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if topicrow.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if topicrow.S_HAS_POLL %} icon-moon-poll{% endif %}{% if topicrow.S_TOPIC_MOVED %} icon-moon-moved{% endif %}{% if topicrow.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
++-					</span>
++-
++-					<i class="row-icon-font-mini{% if topicrow.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
++-					
++-					<div class="desc-wrapper">
++-			  			{% EVENT topiclist_row_prepend %}
++-						{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}
++-
++-						<br />{{ lang('POST_BY_AUTHOR') }}&nbsp;{{ topicrow.TOPIC_AUTHOR_FULL }} 
++-						<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
++-			 		 	{% EVENT topiclist_row_append %}	
++-					</div>
++-				</td>
++-
++-			{% if not BLOCK_VIEW_MEDIUM %}
++-				<td class="fb-stats blg-align-center">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
++-				<td class="lastpost">
++-					<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.LAST_POST_AUTHOR_FULL }}
++-					{% if not S_IS_BOT %}
++-						<a href="{{ topicrow.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">
++-							<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
++-						</a>
++-					{% endif %}
++-					<br /><i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
++-				</td>
++-			{% endif %}
++-			</tr>
++-			{% EVENT viewforum_body_topicrow_row_after %}
++-		{% endfor %}
++-		</tbody>
++-		</table>
++-
++-	{% if BLOCK_STYLE == 'content_simple' %}
++-	</div>
++-	{% endif %}
++-
++-</div>
++-
++-{% endif %}
++-
++-{% if block_pagination|length %}
++-	<div class="pull-right">	 
++-		<ul class="pagination pagination-forum {% if BLOCK_VIEW_SMALL %}pagination-xs{% else %}pagination-sm{% endif %} hidden-xs">
++-		{% for pagination in block_pagination %}
++-			{% if pagination.S_IS_PREV %}
++-			<li class="previous"><a href="{{ pagination.PAGE_URL }}" rel="prev" role="button">{{ lang('PREVIOUS') }}</a></li>
++-			{% elseif pagination.S_IS_CURRENT %}
++-			<li class="active"><span>{{ pagination.PAGE_NUMBER }}</span></li>
++-			{% elseif pagination.S_IS_ELLIPSIS %}
++-			<li class="ellipsis" role="separator"><span>{{ lang('ELLIPSIS') }}</span></li>
++-			{% elseif pagination.S_IS_NEXT %}
++-			<li class="next"><a href="{{ pagination.PAGE_URL }}" rel="next" role="button">{{ lang('NEXT') }}</a></li>
++-			{% else %}
++-			<li><a href="{{ pagination.PAGE_URL }}" role="button">{{ pagination.PAGE_NUMBER }}</a></li>
++-			{% endif %}
++-		{% endfor %}
++-		</ul>
++-	</div>
++-	<div class="cbb-helper-clear"></div>
++-{% endif %}
++-
++-</div>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/calendar_body.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/calendar_body.html"
++deleted file mode 100644
++index 711283ca5..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/calendar_body.html"
+++++ /dev/null
++@@ -1,116 +0,0 @@
++-{% if IN_EVENT %}
++-
++-<div title="{{ S_EVENT_TITLE }}">
++-	<form>
++-	<div class="cbb-dialog-content">{{ S_EVENT_CONTENT }}</div>
++-
++-{% if CAN_MANAGE_EVENT %}
++-	<div class="cbb-dialog-buttons">
++-		<button class="btn btn-default" value="submit" data-action="edit">{{ lang('EDIT') }}</button>
++-		<button class="btn btn-default" value="submit" data-action="delete">{{ lang('DELETE') }}</button>
++-		
++-		{{ S_HIDDEN_FIELDS }}
++-	</div>
++-{% endif %}
++-	</form>
++-</div>
++-
++-{% elseif IN_BIRTHDAY_LIST %}
++-
++-<div title="{{ lang('BIRTHDAYS') }}">
++-	<div class="cbb-dialog-content">
++-		<ul class="blg-linear-list blg-birthday-list">
++-		{% for user in loops.user %}
++-			<li class="double-space">
++-				<div class="cbb-circular-avatar size-small">{% if user.AVATAR %}{{ user.AVATAR }}{% else %}<span class="cbb-no-avatar"></span>{% endif %}</div>
++-				{{ user.USERNAME_FULL }}
++-				<span>({{ user.AGE }})</span>
++-			</li>
++-		{% endfor %}
++-		</ul>
++-	</div>
++-</div>
++-
++-{% else %}
++-
++-{% INCLUDE 'overall_header.html' %}
++-<div class="side-segment">
++-	<h3>{{ lang('CALENDAR') }}</h3>
++-</div>
++-
++-{% for calendar in loops.calendar %}
++-	<div class="blg-calendar-actionbar">
++-		<div class="calendar-printer blg-align-right floated">
++-			<a href="#" data-action="print" class="btn btn-default"><i class="fa fa-print" aria-hidden="true"></i> <span>{{ lang('PRINT') }}</span></a>
++-		</div>
++-
++-		<a href="{{ U_TODAY }}" class="btn btn-default" data-rel="today">{{ lang('TODAY') }}</a>
++-
++-		<div class="btn-group">
++-			<a href="{{ U_PREV }}" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
++-			<a href="#" class="btn btn-default" data-action="month-select">{{ calendar.S_MONTH }}</a>
++-			<a href="{{ U_NEXT }}" class="btn btn-default"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
++-		</div>
++-	</div>
++-	<div class="panel panel-poll">
++-		<div class="panel-body">
++-			<table class="blg-calendar">
++-			<tr>
++-			{% for day in calendar.days %}
++-
++-				{% if day.NEW_LINE and not day.S_FIRST_ROW %}</tr><tr>{% endif %}
++-
++-				{% if day.IS_HEADER %}
++-					<th><span class="short-day text-capitalize">{{ day.S_DAY_SHORT }}</span><span class="full-day text-capitalize">{{ day.S_DAY }}</span></th>
++-				{% elseif day.S_DAY %}
++-					<td id="day-{{ day.S_DATA }}" data-time="{{ day.S_DATA }}" class="blg-calendar-day{% if day.IS_TODAY %} today{% endif %}">
++-						<div class="blg-day-title">
++-							{% if S_CAN_CREATE_EVENT %}<a href="#" class="blg-event-add blg-align-right floated" title="{{ lang('ADD_EVENT') }}" data-time="{{ day.S_DATA }}"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>{% endif %}
++-							<span>{{ day.S_DAY }}</span>
++-						</div>
++-					
++-						<div class="blg-day-content">
++-						{% for event in day.event %}
++-							<div {{ event.S_ATTR }}>
++-								{% if event.S_TYPE == 'birthday' %}<i class="fa fa-birthday-cake" aria-hidden="true"></i> {% endif %}
++-								{{ event.S_TITLE }}
++-							</div>
++-						{% endfor %}
++-						</div>
++-					</td>
++-				{% else %}
++-					<td>&nbsp;</td>
++-				{% endif %}
++-			{% endfor %}
++-			</tr>
++-			</table>
++-		</div>
++-	</div>
++-{% endfor %}
++-
++-<div id="month-selector" class="cbb-helper-hidden" title="{{ lang('CALENDAR_SELECT_DATE') }}">
++-	<form>
++-		<div class="cbb-dialog-content blg-align-center">
++-			<div class="cbb-group">
++-				<select class="cbb-inputbox" name="month">{{ S_MONTH_OPTIONS }}</select>
++-				<input type="text" class="cbb-inputbox" name="year" value="" size="10" />
++-			</div>
++-		</div>
++-		<div class="cbb-dialog-buttons">
++-			<button class="btn btn-default" value="submit">{{ lang('GO') }}</button>
++-		</div>
++-	</form>
++-</div>
++-
++-<script>
++-// <![CDATA[
++-	window._jPostponed = window._jPostponed || [];
++-	window._jPostponed.push(function() {
++-		$('.blg-calendar').blgCalendar();
++-	});
++-// ]]>
++-</script>
++-
++-{% INCLUDE 'overall_footer.html' %}
++-
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_body_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_body_after.html"
++deleted file mode 100644
++index 9331334cf..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_body_after.html"
+++++ /dev/null
++@@ -1,30 +0,0 @@
++-{% if BLG_ENABLED or BLG_ADMIN_BAR %}
++-
++-	{% if BLG_ADMIN_BAR %}
++-		<div class="blg-admin-bar">
++-			<ul class="blg-align-left floated">
++-				<li><a href="{{ U_BLG_MANAGE_BLOCKS }}" class="cbb-btn"><i class="fa fa-th-large" aria-hidden="true"></i> <span class="btn-title">{{ lang('MANAGE_BLOCKS') }}</span></a></li>
++-				<li><a href="{{ U_BLG_PAGE_EDIT }}" class="cbb-btn"><i class="fa fa-cog" aria-hidden="true"></i> <span class="btn-title">{{ lang('EDIT_CONFIGURATION') }}</span></a></li>
++-			</ul>
++-			
++-			<ul class="blg-align-right floated">
++-				<li><a href="{{ U_BLG_PAGE_ADD }}" class="cbb-btn"><i class="fa fa-plus-circle" aria-hidden="true"></i> <span class="btn-title">{{ lang('ADD_PAGE') }}</span></a></li>
++-			</ul>
++-
++-			<a href="#" class="blg-admin-opener" title="{{ lang('EDIT_THIS_PAGE') }}"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a>
++-		</div>
++-	{% endif %}
++-
++-	<script>
++-	// <![CDATA[
++-	head.ready(['cbbcore.min.js', 'jblockgets.min.js'], function () {
++-		cbbCore.initService('blockgets', $.extend({{ S_BLG_OPTIONS }}, {
++-			blockHeader: '.block-title',
++-			avatarContainer: '.avatar-frame',
++-			postContainer: '.postbody'
++-		}));
++-	});
++-	// ]]>
++-	</script>
++-	
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_teamlink_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_teamlink_after.html"
++deleted file mode 100644
++index a55ccf2b4..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_teamlink_after.html"
+++++ /dev/null
++@@ -1,6 +0,0 @@
++-
++-{% for link in loops.blglink_bottom %}
++-	<li>
++-		<a href="{{ link.HREF }}">{{ link.ICON }} {{ link.TITLE }}</a>
++-	</li>
++-{% endfor %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_header_head_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_header_head_append.html"
++deleted file mode 100644
++index 8977f1bc6..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_header_head_append.html"
+++++ /dev/null
++@@ -1,14 +0,0 @@
++-{% if (BLG_ENABLED or BLG_ADMIN_BAR) and CANIDEV_CORE_STARTED %}
++-	{% include '@canidev_core/event/overall_header_head_append.html' %}
++-	{% INCLUDECSS '@canidev_blockgets/bboots.css' %}
++-	
++-	{% if BLG_ENABLED %}
++-		<style>
++-		.blg-center-area 					{ grid-template-columns: {{ LEFT_COLUMN_WIDTH }} 1fr {{ RIGHT_COLUMN_WIDTH }}; }
++-		.blg-block, .blg-area, .blg-grid 	{ margin-bottom: {{ BLG_BLOCK_SPACE }}; }
++-		.blg-grid, .blg-center-area 		{ gap: {{ BLG_BLOCK_SPACE }}; }
++-
++-		{% if BLG_LOGO %}.site_logo, .imageset.site_logo { background-image: url('{{ BLG_LOGO }}'); }{% endif %}
++-		</style>
++-	{% endif %}
++-{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_header_navigation_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_header_navigation_append.html"
++deleted file mode 100644
++index 1e746526b..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/overall_header_navigation_append.html"
+++++ /dev/null
++@@ -1,8 +0,0 @@
++-
++-{% for link in loops.blglink_top %}
++-	<li><a href="{{ link.HREF }}">{{ link.ICON }} {{ link.TITLE }}</a><span></span></li>
++-{% endfor %}
++-
++-{% for link in loops.blglink_quick %}
++-	<li><a href="{{ link.HREF }}">{{ link.ICON }} {{ link.TITLE }}</a><span></span></li>
++-{% endfor %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/simple_footer_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/simple_footer_after.html"
++deleted file mode 100644
++index 16f58efdc..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/template/event/simple_footer_after.html"
+++++ /dev/null
++@@ -1,15 +0,0 @@
++-{% if S_IN_PLAYER and CANIDEV_CORE_STARTED %}
++-	{% include '@canidev_core/event/overall_footer_after.html' %}
++-	
++-	<script>
++-	// <![CDATA[
++-	head.ready(['cbbcore.min.js', 'jblockgets.min.js'], function() {
++-		cbbCore.initService('blockgets', $.extend({{ S_BLG_OPTIONS }}, {
++-			blockHeader: '.block-title',
++-			avatarContainer: '.avatar-frame',
++-			postContainer: '.postbody'
++-		}));
++-	});
++-	// ]]>
++-	</script>
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/theme/bboots.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/theme/bboots.css"
++deleted file mode 100644
++index 2a9476fa8..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/theme/bboots.css"
+++++ /dev/null
++@@ -1,69 +0,0 @@
++-/**
++- * cBB Blockgets (BBOOTS stylesheet)
++- * Copyright (c) 2023, CaniDev
++- * license https://creativecommons.org/licenses/by-nc/4.0/
++- */
++-
++- .blg-block.style-alternative .block-title,
++-.blg-block.style-content_full table,
++-.blg-block.style-content_full table tr,
++-.blg-block.style-content_full table td {
++-	background: none !important;
++-	border: none !important;
++-	box-shadow: none;
++-}
++-
++-.blg-block.style-alternative .block-title {
++-	padding: 8px !important;
++-}
++-
++-.blg-block.style-content_full .block-title {
++-	border-width: 0 0 1px 0;
++-}
++-
++-.blg-block.style-alternative .block-title,
++-.blg-block.style-alternative .block-title i,
++-.blg-block.style-content_full .block-title,
++-.blg-block.style-content_full .block-title i {
++-	color: #808080 !important;
++-}
++-
++-.blg-block.style-alternative .block-content {
++-	border: none !important;
++-	padding: 0 !important;
++-}
++-
++-.fb-lastpost-title {
++-	width: 150px !important;
++-}
++-
++-.blg-menu,
++-.blg-menu .fa,
++-.blg-message {
++-    font-size: 1em !important;
++-}
++-
++-.blg-admin-bar,
++-a.blg-admin-opener {
++-	box-sizing: content-box;
++-}
++-
++-/* Contact Block
++--------------------------- */
++-.contact-table {
++-	border-spacing: 8px !important;
++-}
++-
++-.contact-table.short-view .cbb-inputbox {
++-	max-width: 155px;
++-}
++-
++-/* Login Block
++--------------------------- */
++-.blg-block .oauth-content {
++-	margin-top: 15px;
++-}
++-
++-.blg-block .oauth-content h3 {
++-	font-size: 18px;
++-}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/theme/calendar_print.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/theme/calendar_print.css"
++deleted file mode 100644
++index f6a9a88ca..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/BBOOTS/theme/calendar_print.css"
+++++ /dev/null
++@@ -1,75 +0,0 @@
++-/**
++- * cBB Blockgets (Calendar Print stylesheet)
++- * Copyright (c) 2022, CaniDev
++- * license https://creativecommons.org/licenses/by-nc/4.0/
++- */
++- 
++-html	{ height: 100%; }
++-body	{ padding: 0; }
++-
++-header,
++-.header,
++-.flat-header,
++-section.section-page,
++-footer,
++-.section-pre-footer,
++-.mastbottom,
++-.breadcrumb-line,
++-.social-top,
++-.subheader,
++-.crumbs,
++-.sub-breadcrumb,
++-.copyright {
++-	display: none !important;
++-}
++-
++-#wrap {
++-	border: none;
++-	border-radius: 0;
++-    max-width: none;
++-    min-width: 0;
++-	padding: 0 15px;
++-}
++-
++-#page-body, .blg-area {
++-    margin: 0;
++-}
++-
++-.blg-calendar-actionbar {
++-	float: right;
++-	margin: 2em 0 0 0;
++-}
++-
++-.blg-calendar-actionbar .btn-group,
++-.blg-calendar-actionbar .btn {
++-	display: none;
++-}
++-
++-#blg-column-center h2 {
++-	float: left;
++-}
++-
++-.blg-calendar:before {
++-    content: "";
++-    display: block;
++-    clear: both;
++-    margin-bottom: 20px;
++-}
++-
++-.blg-calendar td.today {
++-	background: none;
++-}
++-
++-.blg-calendar td.today .blg-calendar-day,
++-.blg-calendar td.today .blg-calendar-content {
++-    border: inherit;
++-}
++-
++-.blg-calendar td.today .blg-calendar-day		{
++-	border-bottom: none;
++-	font-weight: normal;
++-}
++-
++-.blg-calendar td.today .blg-calendar-content {
++-	border-top: none;
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/login_block.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/login_block.html"
++index aa9a013b3..492882faf 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/login_block.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/login_block.html"
++@@ -13,13 +13,13 @@
++ 	<li class="menu-cat">{{ USERNAME_FULL }}</li>
++ 	<li class="double-space">
++ 		<a href="{{ U_PROFILE }}">
++-			<span class="cbb-circular-avatar">{% if USER_AVATAR %}{{ USER_AVATAR }} {% else %}<span class="cbb-no-avatar"></span>{% endif %}</span>
+++			<span class="cbb-avatar">{% if USER_AVATAR %}{{ USER_AVATAR }} {% else %}<span class="cbb-no-avatar"></span>{% endif %}</span>
++ 		</a>
++ 	</li>
++ 
++ 	{% if USER_RANK_IMG %}<li>{{ USER_RANK_TITLE }}<br />{{ USER_RANK_IMG }}</li>{% endif %}
++ 	{% if S_LAST_VISIT %}<li class="double-space">{{ S_LAST_VISIT }}</li>{% endif %}
++-	{% if S_CURRENT_TIME %}<li class="double-space">{{ S_CURRENT_TIME }}</li>{% endif %}
+++	<!-- {% if S_CURRENT_TIME %}<li class="double-space">{{ S_CURRENT_TIME }}</li>{% endif %} -->
++ 	
++ 	{{ S_BLG_LOGIN_FIELDS }}
++ </ul>
++@@ -28,7 +28,7 @@
++ 
++ <ul class="blg-menu blg-linear-list">
++ {% for link in userlink %}
++-	<li>
+++	<li class="btn btn-default">
++ 		<i class="icon fa {% if link.ICON %}{{ link.ICON }}{% else %}fa-chevron-right{% endif %} fa-fw" aria-hidden="true"></i>
++ 		<a href="{{ link.URL }}">{{ link.TITLE }}</a>
++ 	</li>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/news_block.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/news_block.html"
++index 8d70807ba..97b84ea7f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/news_block.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/news_block.html"
++@@ -27,19 +27,28 @@
++ {% if news_row|length %}
++ 
++ {% if not S_NEWS_FULL_CONTENT and not S_NEWS_COLLAPSE %}
++-
++-	<ul class="blg-linear-list">
+++	<div class="blg-widget-header">
+++		<span>{{ lang('TOPIC') }}</span>
+++	</div>
+++	<ul class="blg-linear-list news-block">
++ 	{% for topicrow in news_row %}
++ 		<li class="double-space">
++-			<div>
++-				<i class="fa fa-bullhorn fa-lg" aria-hidden="true"></i>
++-				{% EVENT topiclist_row_prepend %}
++-				<a href="{{ topicrow.U_VIEW_TOPIC }}"><strong>{{ topicrow.TOPIC_TITLE }}</strong></a>
++-			</div>
++-			<div>
++-				{{ lang('POSTED_BY') ~ lang('COLON') }}
++-				<strong>{{ topicrow.TOPIC_AUTHOR_FULL }}</strong>
++-				{% if BLOCK_VIEW_SMALL %}<br />{% else %}&bull;{% endif %} {{ topicrow.FIRST_POST_TIME }}
+++			<div class="desc-wrapper">
+++				<div>
+++					{% EVENT topiclist_row_prepend %}
+++					<a href="{{ topicrow.U_VIEW_TOPIC }}"><strong>{{ topicrow.TOPIC_TITLE }}</strong></a>
+++					{% EVENT topiclist_row_append_portal %}
+++				</div>
+++				<div>
+++					{{ lang('POSTED_BY') ~ lang('COLON') }}
+++					<strong>{{ topicrow.TOPIC_AUTHOR_FULL }}</strong>
+++					{% if BLOCK_VIEW_SMALL %}<br />{% else %}&bull;{% endif %} {{ topicrow.FIRST_POST_TIME }}
+++				</div>
+++				<div>
+++						{L_LAST_REPLIED_BY}{L_COLON}
+++						<strong>{{ topicrow.LAST_POST_AUTHOR_FULL }}</strong>
+++						{% if BLOCK_VIEW_SMALL %}<br />{% else %}&bull;{% endif %} <span>{{ topicrow.LAST_POST_TIME }}</span>
+++				</div>
++ 			</div>
++ 		</li>
++ 	{% endfor %}
++@@ -123,7 +132,7 @@
++ 
++ {% if block_pagination|length %}
++ 	<div class="pull-right">	 
++-		<ul class="pagination pagination-forum {% if BLOCK_VIEW_SMALL %}pagination-xs{% else %}pagination-sm{% endif %} hidden-xs">
+++		<ul class="pagination pagination-forum {% if BLOCK_VIEW_SMALL %}pagination-xs{% else %}pagination-sm{% endif %}">
++ 		{% for pagination in block_pagination %}
++ 			{% if pagination.S_IS_PREV %}
++ 			<li class="previous"><a href="{{ pagination.PAGE_URL }}" rel="prev" role="button">{{ lang('PREVIOUS') }}</a></li>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/recent_topics_block.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/recent_topics_block.html"
++index 41d16d466..58e6b7dbf 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/recent_topics_block.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/blocks/recent_topics_block.html"
++@@ -91,36 +91,62 @@
++ 					{% EVENT viewforum_body_topicrow_row_before %}
++ 					<tr>
++ 						<td>
++-							{% if topicrow.TOPIC_ICON_IMG %}
++-							<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
++-							{% endif %}
++-
++ 							<span class="icon-wrapper">
++ 						    	<i class="row-icon-font icon-moon-default2{% if topicrow.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if topicrow.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if topicrow.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if topicrow.S_HAS_POLL %} icon-moon-poll{% endif %}{% if topicrow.S_TOPIC_MOVED %} icon-moon-moved{% endif %}{% if topicrow.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
++ 							</span>
++ 
++ 							<i class="row-icon-font-mini{% if topicrow.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
++-							
++-							<div class="desc-wrapper">
++-					  			{% EVENT topiclist_row_prepend %}
+++
+++							<div class="desc-wrapper hidden-xs" style="padding:0">
+++								{% if topicrow.TOPIC_ICON_IMG %}
+++									<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+++								{% endif %}
+++					  		{% EVENT topiclist_row_prepend %}
++ 								{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}
++ 
++ 								<br />{{ lang('POST_BY_AUTHOR') }}&nbsp;{{ topicrow.TOPIC_AUTHOR_FULL }} 
++ 								<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
++ 					 		 	{% EVENT topiclist_row_append %}	
++ 							</div>
+++							<div class="desc-wrapper visible-xs" style="padding:0">
+++								{% if topicrow.TOPIC_ICON_IMG %}
+++								<i class="topic-icon" style="margin:-8px;background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+++								{% endif %}
+++					  			{% EVENT topiclist_row_prepend %}
+++								<div>{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}</div>
+++								{% if not S_IS_BOT %}
+++									<a href="{{ topicrow.U_LAST_POST }}" title="{L_GOTO_LAST_POST}">
+++										<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
+++									</a>
+++								{% endif %}
+++								{{ lang('POST_BY_AUTHOR') }}&nbsp;{{ topicrow.TOPIC_AUTHOR_FULL }} 
+++								<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
+++							</div>
+++							{% if not BLOCK_VIEW_MEDIUM %}
+++								<div class="lastpost visible-xs">
+++									<div class="nowrap-mobile">
+++										<span>
+++											<i class="fa fa-user"></i>&nbsp;<small>{{ topicrow.LAST_POST_AUTHOR_FULL }}</small>
+++											<i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
+++										</span>
+++										
+++									</div>
+++								</div>
+++							{% endif %}
++ 						</td>
++ 
++ 					{% if not BLOCK_VIEW_MEDIUM %}
++-						<td class="fb-stats blg-align-center">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
++-						<td class="lastpost">
++-							<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.LAST_POST_AUTHOR_FULL }}
++-							{% if not S_IS_BOT %}
++-								<a href="{{ topicrow.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">
++-									<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
++-								</a>
++-							{% endif %}
++-							<br /><i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
+++						<td class="fb-stats blg-align-center hidden-xs">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
+++						<td class="lastpost hidden-xs">
+++							<span>
+++								<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.LAST_POST_AUTHOR_FULL }}
+++								{% if not S_IS_BOT %}
+++									<a href="{{ topicrow.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">
+++										<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
+++									</a>
+++								{% endif %}
+++								<br /><i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
+++							</span>
++ 						</td>
++ 					{% endif %}
++ 					</tr>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/calendar_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/calendar_body.html"
++index 711283ca5..7585c12aa 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/calendar_body.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/calendar_body.html"
++@@ -48,7 +48,7 @@
++ 
++ 		<div class="btn-group">
++ 			<a href="{{ U_PREV }}" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
++-			<a href="#" class="btn btn-default" data-action="month-select">{{ calendar.S_MONTH }}</a>
+++			<a href="#" class="btn btn-default text-capitalize" data-action="month-select">{{ calendar.S_MONTH }}</a>
++ 			<a href="{{ U_NEXT }}" class="btn btn-default"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
++ 		</div>
++ 	</div>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
++index 4042d6ac0..9a6473bbf 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
++@@ -1 +1 @@
++-{% if U_SITE_HOME %}<li class="blg-breadcrumb-fix"></li>{% endif %}
++\ No newline at end of file
+++{% if U_SITE_HOME and SCRIPT_NAME == "portal" %}<li class="blg-breadcrumb-fix"></li>{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/theme/flatboots.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/theme/flatboots.css"
++index e0898b867..f211d2d5d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/FLATBOOTS/theme/flatboots.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/FLATBOOTS/theme/flatboots.css"
++@@ -95,4 +95,18 @@ a.blg-admin-opener {
++ .blg-block .oauth-list-btns {
++ 	margin-bottom: 0;
++ 	margin-left: 0;
++-}
++\ No newline at end of file
+++}
+++/* News Block
+++-------------------------- */
+++.blg-linear-list.news-block li.double-space {
+++	display:flex;
+++	margin:0!important;
+++	border: 1px solid #e4e9eb;
+++}
+++.blg-linear-list.news-block li .desc-wrapper {
+++	padding:10px 8px;
+++	width: -webkit-fill-available;
+++}
+++.blg-linear-list.news-block li:first-child {
+++	border-top: 4px solid #e4e9eb;
+++}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/all/template/blocks/calendar_block.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/all/template/blocks/calendar_block.html"
++index b925ccd23..60266bf80 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/all/template/blocks/calendar_block.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/all/template/blocks/calendar_block.html"
++@@ -44,7 +44,7 @@
++ 			<thead>
++ 			<tr>
++ 				<td class="blg-align-left">{% if calendar.S_FIRST_ROW %}<a href="#" data-calendar="{{ BLOCK_ID }}-{{ calendar.S_ROW_COUNT }}" data-action="prev"><i class="fa fa-arrow-circle-left fa-lg" aria-hidden="true"></i></a>{% else %}&nbsp;{% endif %}</td>
++-				<td colspan="5" class="month-title blg-align-center"><a href="{{ calendar.U_ACTION }}">{{ calendar.S_MONTH }}</a></td>
+++				<td colspan="5" class="month-title text-capitalize blg-align-center"><a href="{{ calendar.U_ACTION }}">{{ calendar.S_MONTH }}</a></td>
++ 				<td class="blg-align-right">{% if calendar.S_LAST_ROW %}<a href="#" data-calendar="{{ BLOCK_ID }}-{{ calendar.S_ROW_COUNT }}" data-action="next"><i class="fa fa-arrow-circle-right fa-lg" aria-hidden="true"></i></a>{% else %}&nbsp;{% endif %}</td>
++ 			</tr>
++ 			</thead>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/all/template/blocks/gallery_block.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/all/template/blocks/gallery_block.html"
++index 403aeca50..932123c14 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\blockgets/styles/all/template/blocks/gallery_block.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\blockgets/styles/all/template/blocks/gallery_block.html"
++@@ -51,7 +51,12 @@
++ 
++ <div class="gallery">
++ {% for image in loops.image %}
++-	<a href="{{ image.ACTION }}" title="{{ image.TITLE }}" class="blank"><img src="{{ image.SRC }}" alt="{{ image.TITLE }}" /></a>
+++	<a href="{{ image.ACTION }}" title="{% for prefix in image.prefix %}{{ prefix.NAME }}&nbsp;{% endfor %}{{ image.TITLE }}" class="blank ribbon-holder">
+++		<img src="{{ image.SRC }}" alt="" />
+++		<span class="ribbon ribbon-holder">
+++			{% for prefix in image.prefix %}&nbsp;&nbsp;{{ prefix.NAME }}&nbsp;{% endfor %}
+++		</span>
+++	</a>
++ {% endfor %}
++ </div>
++ {% endif %}
++diff --git "a/c:\\Users\\Leina
\ No newline at end of file
diff --git "[FORUM_EXT]/canidev\\blockgets/language/pt/acp.php" "[FORUM_EXT]/canidev\\blockgets/language/pt/acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/language/pt/acp.php"
@@ -0,0 +1,357 @@
+<?php
+/*
+* acp.php [English [En]]
+* @package cBB Blockgets
+* @version v2.0.2 12/01/2021
+*
+* @copyright (c) 2021 CaniDev
+* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+*/
+
+// @ignore
+if(!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+// @acp_blockgets
+$lang = array_merge($lang, array(
+	'BLG_CONFIG_TITLE'				=> 'General configuration',
+	'BLG_CONFIG_EXPLAIN'			=> 'Thank you for choosing cBB Blockgets as a complement for your forum!<br />From here you can set the main settings of the extension.<br />Lateral links allow you to access all the options to set comfortably the mod.',
+	'BLG_IMAGES_TITLE'				=> 'Available images',
+	'BLG_OPTIONAL_TITLE'			=> 'Additional configuration',
+	'BLG_OPTIONAL_EXPLAIN'			=> 'From here you can set additional settings for the site.',
+	
+	'BLG_ADMIN_BAR'					=> 'Show quick access bar',
+	'BLG_ADMIN_BAR_EXPLAIN'			=> 'If enabled, a bar will be displayed at the top of the forum that will allow you to quickly access the options of the page where you are.',
+	'BLG_BLOCK_AUTOFIT'				=> 'AutoFit blocks',
+	'BLG_BLOCK_AUTOFIT_EXPLAIN'		=> 'If enabled, the content and disposition of the blocks will be adjust to the column.',
+	'BLG_COLLAPSE'					=> 'Allow collapse blocks',
+	'BLG_COLLAPSE_EXPLAIN'			=> 'Enable/disable globally the possibility that each user can collapse/expand blocks individually. This option overwrite the individual block\'s configuration.',
+	'BLG_FULL_EDITOR'				=> 'Full editor',
+	'BLG_ON_BOARD'					=> 'Blocks within the forum',
+	'BLG_ON_BOARD_EXPLAIN'			=> 'Sets whether to display the blocks into the forum pages. This option overwrite the invidual page\'s configuration.<br /><br />
+		<em>
+			&nbsp;&nbsp;<strong>Not show:</strong> It does not show blocks on any page.<br />
+			&nbsp;&nbsp;<strong>Individual pages:</strong> It shows the blocks on the pages configured for it.<br />
+			&nbsp;&nbsp;<strong>Equal pages:</strong> The "General Index" blocks are shown on all pages.
+		</em>',
+	'BLG_REDIRECTIONS'				=> 'Redirections',
+	'BLG_REDIRECT_404'				=> 'Page not found',
+	'BLG_REDIRECT_404_EXPLAIN'		=> 'Sets the page to which the user will be taken when trying to access a location that does not exist.<br />
+		<em>Replace the message No route found for "GET" of phpBB.</em>',
+	'BLG_REDIRECT_LOGIN'			=> 'Login',
+	'BLG_REDIRECT_LOGIN_EXPLAIN'	=> 'Sets the page to which the user will be taken after login to the forum.',
+	'BLG_REDIRECT_LOGOUT'			=> 'Logout',
+	'BLG_REDIRECT_LOGOUT_EXPLAIN'	=> 'Sets the page to which the user will be taken when disconnecting.',
+
+	'DEFAULT'					=> 'By default',
+	'LINKS'						=> 'Links',
+	'OPEN_GALLERY'				=> 'Open gallery',
+	'SAVE_AND_ADD'				=> 'Save and add more',
+	'TYPE_DOMAIN_HOME'			=> 'Domain\'s main page',
+	'TYPE_FORUM_HOME'			=> 'Forum\'s main page',
+	'TYPE_FORUM_SECONDARY'		=> 'Forum\'s secondary page',
+
+	'BOARD_BLOCK_INDIVIDUAL'	=> 'Individual pages',
+	'BOARD_BLOCK_NONE'			=> 'Not show',
+	'BOARD_BLOCK_SAME'			=> 'Equal pages',
+
+	'AVATAR_RESIZE_WIDTH'			=> 'Size of avatars',
+	'AVATAR_RESIZE_WIDTH_EXPLAIN'	=> 'Maximum size allowed (in pixels) for avatars.<br />
+		<em>Set 0 to disable avatar resizing</em>.',
+	'CALENDAR'						=> 'Calendar',
+	'CALENDAR_ENABLED'				=> 'Calendar enabled',
+	'CALENDAR_ENABLED_EXPLAIN'		=> 'Defines whether the calendar will be available in both the<em>/calendar path</em> and blocks.',
+	'CALENDAR_BIRTHDAYS'			=> 'Show Birthdays',
+	'CALENDAR_BIRTHDAYS_EXPLAIN'	=> 'If enabled, user\'s birthdays will be marked and displayed on the calendar, as if they were events.',
+	'CALENDAR_LINK'					=> 'Link',
+	'CALENDAR_LINK_EXPLAIN'			=> 'Define in which part of the forum a link to the calendar will appear.',
+	'CALENDAR_FIRST_DAY'			=> 'First day of the week',
+	'CALENDAR_FIRST_DAY_EXPLAIN'	=> 'Define the first day of the week on the calendar.',
+	'COUNTER'						=> 'Hit Counter',
+	'COUNTER_RESET'					=> 'Reset hit counter',
+	'COUNTER_RESET_EXPLAIN'			=> 'Sets the visits to 0 and the counter start to the current date.',
+	'HOME_TYPE_DISPLAY'				=> 'Behavior of the home page',
+	'HOME_TYPE_DISPLAY_EXPLAIN'		=> 'Sets how the home page will work, if it is enabled.',
+	'IMAGE_RESIZE'					=> 'Resize images',
+	'IMAGE_RESIZE_POST'				=> 'Resize images in posts',
+	'IMAGE_RESIZE_POST_EXPLAIN'		=> 'Enable/Disable the resize in the images inside the forum posts.',
+	'IMAGE_RESIZE_WIDTH'			=> 'Images max size',
+	'IMAGE_RESIZE_WIDTH_EXPLAIN'	=> 'Maximum size (in pixels) for images. The default is 450.<br />
+		<em>Set 0 to disable image resizing</em>.',
+
+	'INDEX_FILE_ERROR'				=> 'Failed to complete setup',
+));
+
+// @acp_blockgets_lists
+$lang = array_merge($lang, array(
+	'ADD_ITEM'				=> 'Add item',
+	'CAT'					=> 'Category',
+
+	'LINK'						=> 'Link',
+	'LINK_DESCRIPTION'			=> 'Description',
+	'LINK_DESCRIPTION_EXPLAIN'	=> 'This text will be show in some blocks as aditional link information.',
+	'LINK_GROUP'				=> 'Groups',
+	'LINK_GROUP_EXPLAIN'		=> 'Select groups of users that can see this link in the menu.<br />You can select multiple groups using the <em>Ctrl</em> key on your keyboard.',
+	'LINK_IMG'					=> 'Image',
+	'LINK_TITLE'				=> 'Link title',
+	'LINK_TITLE_EXPLAIN'		=> 'Title that identifies the link. Limit 100 characters.',
+	'LINK_TYPE'					=> 'Link type',
+	'LINK_URL'					=> 'Link URL',
+	'LINK_URL_EXPLAIN'			=> 'The direction that opens when you click on the link. Limit 255 characters.',
+	'LINK_WINDOW'				=> 'Open in New Window',
+));
+
+// @acp_blockgets_pages
+$lang = array_merge($lang, array(
+	'ADD_BLOCK'					=> 'Add block',
+	'ADD_BLOCK_TIP'				=> 'Drag a block to the position you want to add it.',
+	'ADD_BLOCK_TITLE'			=> 'Add block :: %1$s',
+	'ADD_BLOCK_TITLE_EXPLAIN'	=> 'From here you can add a new block to your forum and set its configuration. You can also set additional settings, if the block you need.',
+	'ADD_GROUP'					=> 'Add group',
+	'ADD_GROUP_EXPLAIN'			=> 'Drag this button to the desired position to add a group',
+	'ADVANCED_OPTIONS'			=> 'Advanced options',
+
+	'BLOCK_SETTINGS'			=> 'General options for the block',
+	'BLOCK_SPACE'				=> 'Space between blocks',
+	'BLOCK_SPACE_EXPLAIN'		=> 'Value in pixels or percentage. The minimun value is 1.',
+	'BOTTOM_COLUMN'				=> 'Bottom column',
+	'CENTER_COLUMN'				=> 'Center column',
+	'CHG_GROUPS_BLOCK'			=> 'Change permissions',
+	'CHG_GROUP_EXPLAIN'			=> 'Choose groups who can see the selected blocks',
+	'COLUMN_SETTINGS'			=> 'Options for the columns',
+	'COPY_BLOCK'				=> 'Copy to other page',
+	'DELETE_BLOCK_CONFIRM'		=> 'Are you sure you want to delete the selected blocks?',
+	'DISABLE_BLOCK'				=> 'Disable',
+	'EDIT_BLOCK_TITLE'			=> 'Edit block :: %1$s',
+	'EDIT_BLOCK_TITLE_EXPLAIN'	=> 'Here you can edit the configuration of the block, as well as additional settings, if the block you need.',
+	'ENABLE_BLOCK'				=> 'Enable',
+	'EXT_ROUTES'				=> 'Extension\'s routes',
+	'FILTER_TYPE_GET'			=> 'Url (GET)',
+	'FILTER_TYPE_POST'			=> 'Form (POST)',
+	'FORUM_FILES'				=> 'Forum files',
+	'LEFT_COLUMN'				=> 'Left column',
+	'LEFT_COLUMN_EXPLAIN'		=> 'Width of the left column in pixels or percentage.<br />Set 0 to disable the column.',
+	'LINK_BOTTOM'				=> 'Bottom',
+	'LINK_QUICK'				=> 'Quick links',
+	'LINK_NONE'					=> 'No link',
+	'LINK_TOP'					=> 'Top',
+	'MANAGE_PAGE'				=> 'Manage page',
+	'MOVE_BLOCK'				=> 'Move to other page',
+	'NO_PAGES_CREATED'			=> 'No pages created.',
+	'NO_PAGE_FILTERS'			=> 'No filters',
+	
+	'PAGE'						=> 'Page',
+	'PAGE_ADD'					=> 'New page',
+	'PAGE_ALIAS'				=> 'Page alias',
+	'PAGE_ALIAS_EXPLAIN'		=> 'You can set an alias (letters, numbers and dashes) to create a separate page.<br />If you leave this field blank, it will create a separate page and will be used the ID as alias.',
+	'PAGE_ALIAS_ERROR'			=> 'The value inserted in "Alias page" field contains illegal characters or an invalid path.',
+	'PAGE_BACKGROUND'			=> 'Page background',
+	'PAGE_BACKGROUND_EXPLAIN'	=> 'You can set a color (ex. white, #FFFFFF) or an image (ex. http://mydomain.com/image.jpg). Leave this field blank to use the default background.',
+	'PAGE_CUSTOM'				=> 'Custom Pages',
+	'PAGE_CUSTOM_EXPLAIN'		=> 'These are pages created by you or another administrator of this site. You can add, edit and manage as many pages as you wish.',
+	'PAGE_CUSTOM_ONE'			=> 'Custom Page',
+	'PAGE_DESCRIPTION'			=> 'SEO Description',
+	'PAGE_DESCRIPTION_EXPLAIN'	=> 'Defines a description visible to search engines.<br /><em>Google, bing, etc...</em>',
+	'PAGE_ENABLED'				=> 'Page enabled',
+	'PAGE_ENABLED_EXPLAIN'		=> 'Enable or disable the page functions completely. This option overrides all others.',
+	'PAGE_FILTERS'				=> 'Filters',
+	'PAGE_FILTERS_EXPLAIN'		=> 'Define the required parameters (GET and POST) for the page is loaded.<br />Check <strong>Online Documentation</strong> for more information on how to set these filters.',
+	'PAGE_FILTER_PARAM'			=> 'Parameters',
+	'PAGE_FILTER_PARAM_EXPLAIN'	=> 'You can set as many as you want separated by ","<br />Ex: mode=mymode,style=1',
+	'PAGE_FILTER_TYPE'			=> 'Type',
+	'PAGE_FILTER_TYPE_EXPLAIN'	=> 'Select the type of location parameters.',
+	'PAGE_FORUM'				=> 'Pages inside the forum',
+	'PAGE_FORUM_EXPLAIN'		=> 'These are pages belonging to the forum to which you can add blocks. You can manage and edit their main parameters as in customized pages.',
+	'PAGE_GROUP'				=> 'Groups',
+	'PAGE_GROUP_EXPLAIN'		=> 'Choose groups who can see the blocks of this page.<br />You can select multiple groups using <em>Ctrl key</em> on your keyboard.',
+	'PAGE_HOME'					=> 'Home page',
+	'PAGE_HOME_EXPLAIN'			=> 'This is a page designed to be used as a site\'s home page as a "Portal".',
+	'PAGE_LINK'					=> 'Link',
+	'PAGE_LINK_ICON'			=> 'Link icon',
+	'PAGE_LINK_ICON_EXPLAIN'	=> 'Define the icon that will have the link to this page.',
+	'PAGE_LINK_POSITION'		=> 'Link position',
+	'PAGE_LINK_POSITION_EXPLAIN'	=> 'Define in which part of the forum a link to this page will appear.',
+	'PAGE_LOGO'					=> 'Logo',
+	'PAGE_LOGO_EXPLAIN'			=> 'Sets the url of the image to be used as logo.<br />Leave blank to use the default logo.',
+	'PAGE_STYLE'				=> 'Style',
+	'PAGE_STYLE_EXPLAIN'		=> 'Defines the style to be used on the page.<br /><em>This option will not be applied to the original pages of the forum.</em>',
+	'PAGE_STYLESHEET'			=> 'Custom theme',
+	'PAGE_STYLESHEET_EXPLAIN'	=> 'You can set the path to one or more files *.css (one per line) or directly set the variables of the theme that will be used.',
+	'PAGE_THEME'				=> 'Theme',
+	'PAGE_THEME_BACKGROUND'		=> 'Set background',
+	'PAGE_THEME_DEFAULT'		=> 'Use default configuration',
+	'PAGE_THEME_STYLE'			=> 'Set style',
+	'PAGE_THEME_STYLESHEET'		=> 'Use custom theme',
+	'PAGE_TITLE'				=> 'Page title',
+	'PAGE_TITLE_EXPLAIN'		=> 'Title will be displayed in the browser.',
+	'PAGE_URL'					=> 'Page url',
+	
+	'PAGES_ADD_TITLE'				=> 'Add new page',
+	'PAGES_ADD_TITLE_EXPLAIN'		=> 'From here you can add a new page and define custom configuration and appearance.',
+	'PAGES_BLOCKS_TITLE'			=> 'Manage blocks :: %s',
+	'PAGES_BLOCKS_TITLE_EXPLAIN'	=> 'From here you can create/edit/delete blocks to be shown on this page.<br />
+		The blocks can be divided into five columns (left, center, right, top and bottom). Drag the blocks to change their position.<br />
+		You can also add <strong>groups</strong> that will allow you to place blocks in up to 3 columns independently.',
+	'PAGES_EDIT_TITLE'				=> 'Edit page :: %s',
+	'PAGES_EDIT_TITLE_EXPLAIN'		=> 'From here you can edit the main configuration and look for the page.',
+	'PAGES_SELECT_TITLE_EXPLAIN'	=> 'Select the page to manage.',
+	'PAGES_TITLE'					=> 'Manage pages',
+	'PAGES_TITLE_EXPLAIN'			=> 'From here you can create/edit/delete additional pages for your forum. You can also edit the configuration and blocks on predefined pages.',
+	
+	'RIGHT_COLUMN'				=> 'Right column',
+	'RIGHT_COLUMN_EXPLAIN'		=> 'Width of the right column in pixels or percentage.<br />Set 0 to disable the column.',
+	'SHOW_FOOTER'				=> 'Show footer',
+	'SHOW_FOOTER_EXPLAIN'		=> 'This option lets you decide whether to display the forum footer on this page.',
+	'SHOW_HEADER'				=> 'Show header',
+	'SHOW_HEADER_EXPLAIN'		=> 'This option lets you decide whether to display the forum header on this page.',
+	'STYLE_DEFAULT'				=> 'Default style',
+	'STYLE_ALTERNATIVE'			=> 'Alternate style',
+	'STYLE_CONTENT_FULL'		=> 'Only content (with title)',
+	'STYLE_CONTENT_SIMPLE'		=> 'Only content (without title)',
+	'SUBMIT_CHANGES'			=> 'Apply changes',
+	'TARGET_PAGE_EXPLAIN'		=> 'Select the target page for the selected blocks.<br /><em>The blocks will be placed in it respective column</em>',
+	'TOP_COLUMN'				=> 'Top column',
+));
+
+// @general messages
+$lang = array_merge($lang, array(
+	'BLOCK_ADDED'					=> 'Block added successfully',
+	'BLOCK_COPIED'					=> 'Block(s) copied successfully',
+	'BLOCK_NEED_REQUIREMENTS'		=> 'The selected block will need some minimum requirements to be used.<br />See the documentation for more information.',
+	'BLOCK_MOVED'					=> 'Block(s) moved successfully',
+	'BLOCK_NOT_ADDED'				=> 'Error adding the block',
+	'BLOCK_NOT_EXISTS'				=> 'The selected block does not exist',
+	'BLOCK_NOT_UPDATED'				=> 'Error updating the block',
+	'BLOCK_POSITION_UPDATED'		=> 'Blocks position updated successfully',
+	'BLOCK_POSITION_NOT_UPDATED'	=> 'Error updating blocks position',
+	'BLOCK_REMOVED'					=> 'Block(s) removed successfully',
+	'BLOCK_UPDATED'					=> 'Block updated successfully',
+	'GROUPS_CHANGED'				=> 'Groups updated successfully',
+
+	'ITEM_REMOVED'				=> 'Element removed successfully',
+	'ITEM_UPDATED'				=> 'Element updated successfully',
+	'ITEM_ADDED'				=> 'Element added successfully',
+	'ITEM_NOT_ADDED'			=> 'Error adding the element',
+	'ITEM_NOT_UPDATED'			=> 'Error updating the element',
+
+	'PAGE_ADDED'				=> 'Page added successfully',
+
+	'PAGE_REMOVED'		=> array(
+		1	=> 'The page has been successfully removed',
+		2	=> '%d pages deleted successfully',
+	),
+
+	'PAGE_UPDATED'				=> 'Page configuration updated successfully',
+	'BLG_CONFIG_UPDATED'		=> 'Configuration updated successfully',
+
+	'CONFIRM_PAGE_DELETE'		=> 'Are you sure you wish to delete this page and all blocks in this?',
+));
+
+/**
+* Blocks names and explains from block_alias
+*/
+$lang = array_merge($lang, array(
+	'blocks'	=> array(
+		'announcements_title'		=> 'Announcements',
+		'announcements_explain'		=> 'Displays a set number of posts (announcements) of established forums.',
+		'attachments_title'			=> 'Attachments',
+		'attachments_explain'		=> 'Displays information and links to the specified attachments.',
+		'banners_title'				=> 'Banners',
+		'banners_explain'			=> 'Displays the specified list of banners. It\'s displayed in a fixed or scrolling form.',
+		'birthdays_title'			=> 'Birthdays',
+		'birthdays_explain'			=> 'Displays the list of birthdays for today and the next few days (optional).',
+		'empty_title'				=> 'Custom',
+		'empty_explain'				=> 'Totally blank block which can also include any text HTML, CSS, JavaScript, etc...',
+		'calendar_title'			=> 'Calendar',
+		'calendar_explain'			=> 'Calendar in which you can add custom events and show birthdays.',
+		'clock_title'				=> 'Clock',
+		'clock_explain'				=> 'Displays a clock in flash format (you can choose several models and add your own clock).',
+		'cloud_tag_title'			=> 'CloudTag',
+		'cloud_tag_explain'			=> 'Sample labels in a balloon in flash format. You can display the latest searched words or the users with more messages.',
+		'contact_title'				=> 'Contact',
+		'contact_explain'			=> 'Displays a standard contact form.',
+		'countdown_title'			=> 'CountDown',
+		'countdown_explain'			=> 'Show a countdown to the indicated date.',	
+		'counter_title'				=> 'Hit counter',
+		'counter_explain'			=> 'Displays a hit counter with statistics of visits, visits per day, visits per hour, weekly visits, visits per month and visits per year.',
+		'dockmenu_title'			=> 'Dock menu',
+		'dockmenu_explain'			=> 'Displays a menu with Mac Dock style with elements of the specified list.',
+		'forums_title'				=> 'Forums',
+		'forums_explain'			=> 'List with full or custom forums.',
+		'frame_title'				=> 'Frame',
+		'frame_explain'				=> 'Display a Web page, a PDF file, a Flash file or a text file within the block.', 
+		'gallery_title'				=> 'Photo gallery',
+		'gallery_explain'			=> 'Photo Gallery customizable with forum images (attachments) or external images. The images move and link the fate of each.',
+		'google_translate_title'	=> 'Google translator',
+		'google_translate_explain'	=> 'Block that allows you to translate the page on which it is installed, opening a new window and translating it through Google technology.',
+		'language_select_title'		=> 'Language select',
+		'language_select_explain'	=> 'It allows the user to view the forum with any language that is installed in the forum and set it as their default language.',
+		'latest_bots_title'			=> 'Bot\'s visits',
+		'latest_bots_explain'		=> 'Simple list of last bots who entered the forum and the date of their last visit.',
+		'latest_members_title'		=> 'Newest members',
+		'latest_members_explain'	=> 'List of latest sers registered on the forum and the date they were registered.',
+		'leaders_title'				=> 'Leaders',
+		'leaders_explain'			=> 'Displays a list of groups (customizable) with forum leaders.',
+		'link_us_title'				=> 'Link Us',
+		'link_us_explain'			=> 'Block that displays a user-selectable link to the page on which it is installed. You can set a mini banner attached to the link.',
+		'login_title'				=> 'Login',
+		'login_explain'				=> 'Allows a user to login directly from the block. Once identified, shows the user\'s primary information and links.',
+		'map_title'					=> 'Map',
+		'map_explain'				=> 'Displays a map that may contain marks with different locations.',
+		'menu_title'				=> 'Menu',
+		'menu_explain'				=> 'Menu in tree format that displays items from the selected list.',
+		'most_poster_title'			=> 'Most Posters',
+		'most_poster_explain'		=> 'Displays a dropdown with users who have posted more messages in the forum, and most relevant information.',
+		'news_title'				=> 'News',
+		'news_explain'				=> 'Dropdown menu showing the last posts of the specified forums as a news.',
+		'online_friends_title'		=> 'Friends online',
+		'online_friends_explain'	=> 'Simple list of friends and foes of the user, that are connected to the forum.',
+		'paypal_title'				=> 'Donations',
+		'paypal_explain'			=> 'Allows users to donate money through paypal.',
+		'player_title'				=> 'Music Player',
+		'player_explain'			=> 'Player to play songs in MP3 or WAV format. Allow to create a list of songs or use M3U, ASX or PLS playlists.',
+		'poll_title'				=> 'Poll',
+		'poll_explain'				=> 'Displays a single poll specified in its configuration.',
+		'poll_random_title'			=> 'Poll (random)',
+		'poll_random_explain'		=> 'Displays a selected number of polls that selected in random order, within the specified forum.',
+		'post_view_title'			=> 'Forum post',
+		'post_view_explain'			=> 'Displays the contents of a message. You can display the last message of a forum, the first or last post of a topic or a custom post.',
+		'quote_of_day_title'		=> 'Quote of day',
+		'quote_of_day_explain'		=> 'Shows a "quote" or phrase of the day or a different tip in each visit to the page.',
+		'random_member_title'		=> 'Random Member',
+		'random_member_explain'		=> 'Displays basic information and avatar of a random user.',
+		'ranks_title'				=> 'Ranks',
+		'ranks_explain'				=> 'Shows a list with the forum ranks.',
+		'recent_topics_title'		=> 'Recent Topics',
+		'recent_topics_explain'		=> 'Recent topics of the forum. Allow to select the forums from which to read the topics.',
+		'rss_title'					=> 'RSS Reader',
+		'rss_explain'				=> 'Show the latest articles from the specified RSS archives(feeds). Items will be displayed in scroll mode or accordion.', 
+		'share_title'				=> 'Share',
+		'share_explain'				=> 'Shows the buttons of most popular social networks in the desired format.',
+		'search_title'				=> 'Search',
+		'search_explain'			=> 'Allows users to do quickly searchs on the forum or in a search engine.',
+		'scroll_message_title'		=> 'Marquee',
+		'scroll_message_explain'	=> 'Text message that is rotating in the block. Allows use BBCode and HTML in the text.',
+		'stats_title'				=> 'Statistics',
+		'stats_explain'				=> 'Gets the most relevant information on the forum. This block shows the number of new messages and topics, the total number of posts and topics, message statistics and topics written per day, total number of attachments and the number of users that remaining active (posting messages).',
+		'style_select_title'		=> 'Style select',
+		'style_select_explain'		=> 'Allows the user to view the forum with any style that is installed on the forum and set it as their default style.',
+		'top_topics_title'			=> 'Top topics',
+		'top_topics_explain'		=> 'List of custom topics that can display the latest topics unread, the most active topics or the most viewed topics.',
+		'topic_index_title'			=> 'Topic Index',
+		'topic_index_explain'		=> 'Displays an orderly list with the topics of selected forums. The list can be order by topic title, topic date or topic last post date.',
+		'welcome_title'				=> 'Welcome',
+		'welcome_explain'			=> 'This block enables a different welcome message for guests and registered users. The block will decide which message display.',
+		'whos_online_title'			=> 'Who\'s online',
+		'whos_online_explain'		=> 'Displays the list of connected users (as is shown by default in the Index of the forum) and users who logged in last 24 hours.',
+		'youtube_title'				=> 'YouTube',
+		'youtube_explain'			=> 'Show videos or channels from youtube.',
+	)
+));
diff --git "[FORUM_EXT]/canidev\\blockgets/language/pt/acp_blocks.php" "[FORUM_EXT]/canidev\\blockgets/language/pt/acp_blocks.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/language/pt/acp_blocks.php"
@@ -0,0 +1,478 @@
+<?php
+/*
+* acp_blocks.php [English [En]]
+*
+* @package cBB Blockgets
+* @version v2.0.2 12/01/2021
+*
+* @copyright (c) 2021 CaniDev
+* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+*/
+
+// @ignore
+if(!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if(empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+/**
+ * @acp_blockgets_pages
+*/
+$lang = array_merge($lang, array(
+	// Blocks global config
+	'BLOCK_COLLAPSE'			=> 'Allow collapse the block',
+	'BLOCK_COLLAPSE_EXPLAIN'	=> 'Enable or disable the ability for each user to collapse/expand this block and defines its initial state.',
+	'BLOCK_ENABLED'				=> 'Block enabled',
+	'BLOCK_ENABLED_EXPLAIN'		=> 'Defines whether this block display in the forum.',
+ 	'BLOCK_CURRENT_ICON'			=> 'Block icon',
+	'BLOCK_CURRENT_ICON_EXPLAIN'	=> 'Current icon set to the block.',
+	'BLOCK_GROUP'				=> 'Groups',
+	'BLOCK_GROUP_EXPLAIN'		=> 'Choose groups who may see this block in the forum.<br />You can select multiple groups using the <em>Ctrl</em> key on your keyboard.',
+	'BLOCK_NO_CONFIG'			=> 'This block does not require additional configuration',
+	'BLOCK_STYLE'				=> 'Look of the block',
+	'BLOCK_STYLE_EXPLAIN'		=> 'With this option you can choose the look of each block individually. Note that the way it is displayed depends on the style installed on the forum and its compatibility with the extension.',
+	'BLOCK_TITLE'				=> 'Block title',
+	'BLOCK_TITLE_EXPLAIN'		=> 'Unique name for your block.<br />This title will be shown in the block.<br />Limit: 100 characters.',
+
+	// Common tags
+	'ALL_FORUMS'				=> 'All forums',
+	'COLLAPSE_HIDDEN'			=> 'Allow (collapsed by default)',
+	'COLLAPSE_NONE'				=> 'Not Allow',
+	'COLLAPSE_VISIBLE'			=> 'Allow (displayed by default)',
+	'CONFIG'					=> 'Configuration',
+	'DESIGN_FULL'				=> 'Full',
+	'DESIGN_SIMPLE'				=> 'Simple',
+	'FORUMS'					=> 'Forums',
+	'FORUMS_EXPLAIN'			=> 'Forums that contain the topics to show. You can select as many as you like using the <em>Ctrl</em> key on your keyboard.',
+	'IGNORE_AUTH'				=> 'Ignore auth',
+	'IGNORE_AUTH_EXPLAIN'		=> 'If enabled, will be show all the content ignoring if the user have the permissions to view it.',
+	'NO_LISTS'					=> 'No avaliable lists',
+	'SHOW_PAGINATION'			=> 'Show pagination',
+	'SHOW_PAGINATION_EXPLAIN'	=> 'Show the pagination to allow user to view older posts.',
+	'TITLE_LIMIT'				=> 'Title limit',
+	'TITLE_LIMIT_EXPLAIN'		=> 'Maximum number of characters that will be displayed in the topic titles.<br />
+		<em>Set 0 to show the full title.</em>',
+	'TOPIC_DESIGN'				=> 'Block design',
+	'TOPIC_DESIGN_EXPLAIN'		=> 'Determine how the topics will be displayed in the block.<br />
+		<em><strong>Full:</strong> Show all information whenever possible.</em><br />
+		<em><strong>Simple:</strong> Show only basic information.</em>',
+	'TOPIC_PARENT_SHOW'			=> 'Show parent forum',
+	'TOPIC_PARENT_SHOW_EXPLAIN'	=> 'If enabled, a link to the forum for each topic will be displayed.',
+	
+	// age_ranges_block
+	'AGE_START'					=> 'Minimum age',
+	'AGE_END'					=> 'Maximum age',
+	'AGE_INTERVAL'				=> 'Interval',
+	
+	// announcements_block
+	'ANN_MAX_NUMBER'			=> 'Announcements number',
+	'ANN_MAX_NUMBER_EXPLAIN'	=> 'Maximum number of announcements that are displayed within the block.',
+	'ANN_MAX_SIZE'				=> 'Announcement size',
+	'ANN_MAX_SIZE_EXPLAIN'		=> 'Maximum size of characters allowed in announcements. The text is cut off if this value exceeds.',
+	'ANN_SHOW_GLOBALS'			=> 'Show global announcements',
+	'ANN_SHOW_GLOBALS_EXPLAIN'	=> 'If enabled, you also read the items marked as "global", otherwise only read simple announcements.',
+	'ANN_COLLAPSE'				=> 'Collapse announcements',
+	'ANN_COLLAPSE_EXPLAIN'		=> 'If enabled, the block only show one announcement and collapse the rest. Otherwise, the announcements will appear all at once on the block.',
+	
+	// attachments_block
+	'ATTACH_FORUM'				=> 'Forum attachments',
+	'ATTACH_FORUM_EXPLAIN'		=> 'If specified, only display attachments from this forum ignoring the rest.<br />The forum should be directly containing the topic where the attachment, the above categories or forums are ignored here.',
+	'ATTACH_EXTENSION'			=> 'Attachment extensions',
+	'ATTACH_EXTENSION_EXPLAIN'	=> 'If specified, all attachments which do not contain this extensions will be ignored.<br />Split the extensions with ",".<<br />Ex. valid extensions: jpg,png,gif...',
+	'ATTACH_NUM'				=> 'Attachment number',
+	'ATTACH_NUM_EXPLAIN'		=> 'Maximum number of attachments that are displayed simultaneously in the block.',
+	'ATTACH_SPECIFIC'			=> 'Specific attachment',
+	'ATTACH_SPECIFIC_EXPLAIN'	=> 'If specified, only attachment with the specified name will be show in the block. The field must contain the original filename of the attachment, Ex: myfile.jpg<br /><br /><strong>Note:</strong> this field overrides the other fields.',
+
+	// banners_block, banners_multiple_block
+	'BANNERS_TITLE'				=> 'Banner title',
+	'BANNERS_TITLE_EXPLAIN'		=> 'If enabled, the title will be appear below the banners in the block.',
+	'BANNERS_LS_TYPE'			=> 'List type',
+	'BANNERS_LS_TYPE_EXPLAIN'	=> 'Define how to display the banners.<br />Can be set a horizontal, vertical scroll or remain fixed.',
+	'BANNERS_NUMBER'			=> 'Banners to show',
+	'BANNERS_NUMBER_EXPLAIN'	=> 'Maximum number of banners to display on the block.<br />
+		<em>Set 0 to show all the list.</em>',
+	'BANNERS_RANDOM'			=> 'Random order',
+	'BANNERS_RANDOM_EXPLAIN'	=> 'Set if the elements will be show in the list order or in a random order.',
+	'LIST_NO_SCROLL'			=> 'No Scroll',
+	'LIST_SCROLL_H'				=> 'Horizontal scroll',
+	'LIST_SCROLL_V'				=> 'Vertical scroll',
+	'BANNERS_B_HEIGHT'			=> 'Block height',
+	'BANNERS_B_HEIGHT_EXPLAIN'	=> 'Enter the height of the block that will be used to scroll lists.',
+
+	// birthdays_block
+ 	'NEXT_BIRTHDAYS'			=> 'Upcoming Birthdays',
+ 	'NEXT_BIRTHDAYS_EXPLAIN'	=> 'Show birthdays that occur in the coming days.<br />
+ 		<em>Maximum 30 days. Set to 0 to disable it.</em>',
+
+	// calendar_block
+ 	'CALENDAR_BIRTHDAYS'			=> 'Show Birthdays',
+ 	'CALENDAR_BIRTHDAYS_EXPLAIN'	=> 'If enabled, the users birthdays are marked and displayed in the calendar, like events.',
+ 	'CALENDAR_EVENTS'				=> 'Show events',
+ 	'CALENDAR_EVENTS_EXPLAIN'		=> 'If enabled, events are marked and displayed in the calendar.',
+ 	'CALENDAR_MONTHS'				=> 'Months to show',
+ 	'CALENDAR_MONTHS_EXPLAIN'		=> 'Number of months to be displayed simultaneously on the block.',
+
+	// contact block
+	'CONTACT_CHECK_EMAIL'			=> 'Check email',
+	'CONTACT_CHECK_EMAIL_EXPLAIN'	=> 'If enabled, the domain of the user email will be checked and validated.',
+	'CONTACT_EMAIL'					=> 'Target email',
+	'CONTACT_HIDE_FIELDS'			=> 'Hide user data',
+	'CONTACT_HIDE_FIELDS_EXPLAIN'	=> 'If enabled, the "Name" and "Email" fields for the register users will be hidden and the block will be used their profile values.',
+ 
+	// countdown block
+	'COUNTDOWN_COMPLETE_MSG'			=> 'Text upon completion',
+	'COUNTDOWN_COMPLETE_MSG_EXPLAIN'	=> 'Text to be displayed when the counter reaches 0.',
+	'COUNTDOWN_TARGET'					=> 'Deadline',
+	'COUNTDOWN_TARGET_EXPLAIN'			=> 'Set the date and time the counter will reach 0.<br /><br />
+		<em><strong>Valid formats</strong>
+			<br />Year/Month/Day
+			<br />Year/Month/Day Hour:Minute:Second
+		</em>',
+	'COUNTDOWN_RUNNING_MSG'				=> 'Hold text',
+	'COUNTDOWN_RUNNING_MSG_EXPLAIN'		=> 'Text to be displayed while the counter is running.',
+
+	// counter block
+	'COUNTER_LOCAL'				=> 'Local counter',
+	'COUNTER_LOCAL_EXPLAIN'		=> 'If enabled, the counter only show the visits to it\'s page, otherwise, the counter show the total visits to the forum.',
+
+	// empty_block
+	'BLOCK_CONTENT'				=> 'Block content',
+	'BLOCK_CONTENT_EXPLAIN'		=> 'Content to display on the block.<br />Limit: 8000 characters.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+
+	// clock_block
+	'DISPLAY_CLOCK'				=> 'Clock to show',
+	'DISPLAY_CLOCK_EXPLAIN'		=> 'Clock displayed on the block.',
+	'PREVIEW_CLOCK'				=> 'Preview',
+	'PREVIEW_CLOCK_EXPLAIN'		=> 'Selected clock preview.',
+
+	// cloud_tags_block
+	'CLOUD_ANIMATION'			=> 'Animation enabled',
+	'CLOUD_ANIMATION_EXPLAIN'	=> 'If enabled, the words "tags" appear in an animated cloud tag, otherwise, they appear as fixed words in block.',
+	'CLOUD_MODE'				=> 'Words type',
+	'CLOUD_MODE_EXPLAIN'		=> 'Specifies that words will be shown in block.',
+	'CLOUD_WORDS'				=> 'Words number',
+	'CLOUD_WORDS_EXPLAIN'		=> 'Maximum number of words that appear in the block.',
+	'MODE_SEARCH'				=> 'Last searched words',
+	'MODE_USERS'				=> 'Users with most posts',
+	
+	// forums block
+	'FORUMS_FORUM'		=> 'Forum to show',
+	
+	// frame_block
+	'MIME_HTML'			=> 'Web page',
+	'MIME_PDF'			=> 'PDF file',
+	'MIME_PLAIN'		=> 'Plain Text file',
+
+	'FRAME_HEIGHT'				=> 'Frame height',
+	'FRAME_HEIGHT_EXPLAIN'		=> 'Frame height in pixels. Set to 0 to auto adjust.',
+	'FRAME_MIMETYPE'			=> 'Document type',
+	'FRAME_MIMETYPE_EXPLAIN'	=> 'The document type displayed in the frame.',
+	'FRAME_URL'					=> 'Document URL',
+	'FRAME_URL_EXPLAIN'			=> 'URL of the document or page displayed in the frame.',
+	'FRAME_WIDTH'				=> 'Frame width',
+	'FRAME_WIDTH_EXPLAIN'		=> 'Frame width in pixels. Set to 0 to auto adjust.',
+	
+	// gallery_block
+	'GALLERY_CUSTOM'				=> 'Custom images',
+	'GALLERY_CUSTOM_EXPLAIN'		=> 'Specify the list containing the images to be displayed.',
+	'GALLERY_DIRECTION'				=> 'Scroll direction',
+	'GALLERY_FORUMS'				=> 'Forums',
+	'GALLERY_FORUMS_EXPLAIN'		=> 'Defines the forums to read the attachments.',
+	'GALLERY_FPS'					=> 'Scroll speed',
+	'GALLERY_HEIGHT'				=> 'Gallery height',
+	'GALLERY_MANAGE'				=> 'Manage gallery',
+	'GALLERY_MARGIN'				=> 'Image margin',
+	'GALLERY_MAX_NUMBER'			=> 'Number of images',
+	'GALLERY_MAX_NUMBER_EXPLAIN'	=> 'Maximum attachments that will be read from the forums/topics/posts',
+	'GALLERY_POSTS'					=> 'Posts',
+	'GALLERY_POSTS_EXPLAIN'			=> 'Posts IDs to read the attachments, splitted with commas. (Ex: 1,2,3).',
+	'GALLERY_SOURCE'				=> 'Origin of the images',
+	'GALLERY_SOURCE_EXPLAIN'		=> 'Define what type of images will be loaded from the forums, topics or messages specified.',
+	'GALLERY_TOPICS'				=> 'Topics',
+	'GALLERY_TOPICS_EXPLAIN'		=> 'Topics IDs to read the attachments, splitted with commas. (Ex: 1,2,3).',
+	'GALLERY_ZOOM'					=> 'Zoom',
+	'GALLERY_ZOOM_EXPLAIN'			=> 'Size difference on image\'s mouse over (in pixels)',
+	
+	'GALLERY_SOURCE_ALL'			=> 'All',
+	'GALLERY_SOURCE_ATTACHMENTS'	=> 'Only attachments',
+	'GALLERY_SOURCE_IMAGES'			=> 'Only embedded images',
+	
+	'IMG_TITLE'			=> 'Image title',
+	'IMG_URL'			=> 'Image url',
+	'IMG_URL_EXPLAIN'	=> 'Url of an JPG, GIF or PNG image. Ej:http://mydomain.com/image.jpg',
+	
+	// google_translate_block
+	'GOOGLE_LANGS'		=> 'Languages to show in the block',
+	'GOOGLE_SHOW_NAMES'			=> 'Show names',
+	'GOOGLE_SHOW_NAMES_EXPLAIN'	=> 'If enabled, the language name will be displayed next to its flag.',
+	
+	// latest_bots_block
+	'BOTS_NUMBER'				=> 'Bots to show',
+	'BOTS_NUMBER_EXPLAIN'		=> 'Maximum number of last visit bots that will be shown in the block.',
+
+	// latest_members_block
+	'MEMBERS_NUMBER'			=> 'Users to show',
+	'MEMBERS_NUMBER_EXPLAIN'	=> 'Maximum number of users that will be shown in block.',
+	
+	// leaders_block
+	'LEADERS_ALL_GROUPS'			=> 'Show users in all their groups',
+	'LEADERS_ALL_GROUPS_EXPLAIN'	=> 'If enabled, users will be shown in all groups of which they are members.
+		Otherwise they will only be shown in their default group.',
+	'LEADERS_GROUPS'				=> 'Groups',
+	'LEADERS_GROUPS_EXPLAIN'		=> 'Groups that will be show in the block. If you don\'t select groups, the block will be show the Administrators and Moderators.',
+	'LEADERS_MODE'					=> 'Display mode',
+	'LEADERS_MODE_ACCORDION'		=> 'Accordion',
+	'LEADERS_MODE_SIMPLE'			=> 'Simple List',
+	'LEADERS_ONLY_ONLINE'			=> 'Online users only',
+	'LEADERS_ONLY_ONLINE_EXPLAIN'	=> 'If enabled, only users from selected groups who are logged in will be displayed.',
+
+	// link_us_block
+	'US_BANNER'					=> 'Mini banner link',
+	'US_BANNER_EXPLAIN'			=> 'Mini banner that will be the image that you have to click to access the forum from the link.',
+
+	// Login Block
+ 	'FULL_LOGIN'				=> 'Show Full login',
+ 	'FULL_LOGIN_EXPLAIN'		=> 'Enable/disable the advanced options in the user identification.',
+ 	'SHOW_REGISTER'				=> 'Show register',
+ 	'SHOW_REGISTER_EXPLAIN'		=> 'Display option for the user registration.',
+	
+	// map_block
+	'LATITUDE'					=> 'Latitude',
+	'LONGITUDE'					=> 'Longitude',
+	'LOCATION_ADD'				=> 'Add location',
+	'LOCATION_EDIT'				=> 'Edit location',
+	'LOCATION_IMAGE'			=> 'Image',
+	'LOCATION_IMAGE_EXPLAIN'	=> 'Image that will mark the point on the map.<br /><em>If you do not define any, the default mark will be used</em>.',
+	'LOCATION_INCORRECT'		=> 'he position entered is incorrect.',
+	'LOCATION_POSITION'			=> 'Position',
+	'LOCATION_POSITION_EXPLAIN'	=> 'Defines the latitude and longitude of the location.',
+	'LOCATION_TEXT'				=> 'Content',
+	'LOCATION_TEXT_EXPLAIN'		=> 'Text to be displayed on the map, by clicking on the location icon.<br /><em>BBcode is allowed.</em>',
+	'LOCATION_TITLE'			=> 'Title',
+	'MAP'						=> 'Map',
+	'MAP_CENTER'				=> 'Central point',
+	'MAP_CENTER_EXPLAIN'		=> 'Defines the latitude and longitude of the default center point.',
+	'MAP_LOCATIONS'				=> 'Locations',
+	'MAP_ZOOM'					=> 'Zoom',
+	'MAP_ZOOM_EXPLAIN'			=> 'Set the default zoom.',
+	'SEARCH_ADDRESS'			=> 'Search location',
+	'SELECT_LOCATION'			=> 'Select location',
+
+	// menu_block
+	'DISPLAY_MENU'				=> 'Menu to show',
+	'DISPLAY_MENU_EXPLAIN'		=> 'Menu to be displayed in the block. The menu must be previously created in the correct section to be reflected here.',
+ 	'ICON_WIDTH'				=> 'Icon width',
+ 	'ICON_WIDTH_EXPLAIN'		=> 'The width of the block icons, in pixels.',
+
+	// most_poster_block
+	'POSTER_LIMIT'				=> 'User Limit',
+	'POSTER_LIMIT_EXPLAIN'		=> 'The limit of users that are displayed on the block.',
+ 	'POST_RANGE'				=> 'Message range',
+ 	'POST_RANGE_EXPLAIN'		=> 'Time limit for the message count.',
+ 
+ 	'ALL_POSTS'			=> 'All messages',
+ 	'LAST_DAY'			=> 'Last day',
+ 	'LAST_WEEK'			=> 'Last week',
+ 	'LAST_MONTH'		=> 'Last month',
+ 	'LAST_YEAR'			=> 'Last year',
+
+	// news_block
+	'NEWS_DISPLAY'				=> 'Information to show',
+	'NEWS_DISPLAY_EXPLAIN'		=> '<em><strong>Basic content:</strong>Show title, author and date.<br />
+		<strong>Full content:</strong>Show all news information.</em>',
+	'NEWS_NUMBER'				=> 'News number',
+	'NEWS_NUMBER_EXPLAIN'		=> 'Maximum number of news items displayed in the block.',
+	'NEWS_SIZE'					=> 'News size',
+	'NEWS_SIZE_EXPLAIN'			=> 'Maximum size of characters allowed in the news. The text of the news will be cut if this value exceeds.',
+	'NEWS_ALL'					=> 'Show all topics',
+	'NEWS_ALL_EXPLAIN'			=> 'If enabled, you also read the items marked as "announcement" and "fixed", otherwise, only read the "normal" topics.',
+	'NEWS_COLLAPSE'				=> 'Collapse news',
+	'NEWS_COLLAPSE_EXPLAIN'		=> 'If enabled, the block only show one notice and collapse the rest. Otherwise, the news will appear all at once on the block.',
+	'NEWS_SHOW_FULL'			=> 'Complete content',
+	'NEWS_SHOW_SIMPLE'			=> 'Basic content',
+	
+	// paypal_block
+	'PAYPAL_ACCOUNT'			=> 'Paypal account',
+	'PAYPAL_ACCOUNT_EXPLAIN'	=> 'Enter the e-mail address of your Paypal account ex: xxx@xxx.com',
+	'PAYPAL_ITEM'				=> 'Payment description',
+	'PAYPAL_ITEM_EXPLAIN'		=> 'Enter the name (description) to which payments will be identified through the block.',
+	'PAYPAL_MSG'				=> 'Message',
+	'PAYPAL_MSG_EXPLAIN'		=> 'Customizable message that will appear in the block.<br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+	'PAYPAL_IMG'				=> 'Button Image',
+ 	'PAYPAL_IMG_EXPLAIN'		=> 'Image to be used for the "donate" button. Leave this field blank to use the default image.', 
+	'PAYPAL_AMOUNTS'			=> 'Amounts',
+	'PAYPAL_AMOUNTS_EXPLAIN'	=> 'Money amount in the select. Split the values with ";" (Ex: 5;10;15).',
+	'PAYPAL_CURRENCIES'			=> 'Currencies',
+	'PAYPAL_CURRENCIES_EXPLAIN'	=> 'Type of currency that will be show in the block. You can select more that one and select the default currency.',
+	
+	//player block
+	'PLAYER_AUTOPLAY'			=> 'Autoplay',
+	'PLAYER_AUTOPLAY_EXPLAIN'	=> 'Defines whether the player will automatically start playing the tracks when the page loads.<br /><br />
+		<em><strong>Note:</strong>Browsers limit this feature so playback will not begin until the user clicks anywhere on the page.</em>',
+	'PLAYER_PLAYLIST'			=> 'Show playlist',
+	'PLAYER_PLAYLIST_EXPLAIN'	=> 'Defines if the playlist is displayed in the player.',
+	'PLAYER_TRACKLIST'			=> 'Tracklist',
+	'PLAYER_TRACKLIST_EXPLAIN'	=> 'The player tracks or songs.',
+
+	'TRACK_TITLE'			=> 'Track title',
+	'TRACK_TITLE_EXPLAIN'	=> 'the name or title displayed in the player.',
+	'TRACK_URL'				=> 'Track URL',
+	'TRACK_URL_EXPLAIN'		=> 'A radio URL (Ex: http://127.0.0.1:8888), a mp3 or wav audio file (Ex: http://myserver.com/audio.mp3) or a valid playlist file (m3u, asx, pls).',
+
+	// poll_block
+	'DISPLAY_POLL'				=> 'Poll to show',
+	'DISPLAY_POLL_EXPLAIN'		=> 'Poll displayed in the block.',
+	'DISPLAY_RESULTS'			=> 'Show results',
+	'NO_POLLS'					=> 'No polls available',
+
+	// poll_random_block
+	'POLL_FORUM'				=> 'Poll forum',
+	'POLL_FORUM_EXPLAIN'		=> 'Forum containing the polls that show on the block.',
+	'POLL_NUM'					=> 'Poll number',
+	'POLL_NUM_EXPLAIN'			=> 'The number of polls that will be displayed at once within the block.',
+	'NO_FORUMS'					=> 'No forums avaliable',
+	
+	// post_view_block
+	'PV_ITEM_URL'			=> 'Referral URL',
+	'PV_ITEM_URL_EXPLAIN'	=> 'Specify here the URL of the forum, topic or message you want to display.<br />
+		<em><strong>Note:</strong> The url of a forum or topic will display it\'s last message.</em>',
+	
+	// quote_of_day_block
+	'QUOTE_AUTHOR'				=> 'Quote author',
+	'QUOTE_TEXT'				=> 'Quote Text',
+	'QUOTES_ALL_DAY'			=> 'Keep all day',
+	'QUOTES_ALL_DAY_EXPLAIN'	=> 'If enabled, you will see the same quote all day. Otherwise, every time the page loads you will see a different quote.',
+	'QUOTES_LIST'				=> 'Quote list',
+	'QUOTES_RAND'				=> 'Random order',
+	'QUOTES_RAND_EXPLAIN'		=> 'Defines if the quotes are displayed in random order or maintaining the order of the list.',
+	'QUOTES_SHOW_AUTHOR'		=> 'Show author',
+	'QUOTES_SHOW_AUTHOR_EXPLAIN'	=> 'Defines whether to display the author of the quote on the block.',
+	
+	// ranks_block
+	'ORPHAN_RANKS'				=> 'Show orphan ranks',
+	'ORPHAN_RANKS_EXPLAIN'		=> 'If enabled, will show the ranges are not assigned to any user.',
+	'ONLY_SPECIAL_RANKS'		=> 'Only special ranks',
+	
+	// recent_topics_block
+	'RECENT_FORUMS'					=> 'Topic forums',
+	'RECENT_FORUMS_EXPLAIN'			=> 'Forums containing items to be displayed. If you do not select any, it will use all the forums. You can select as many as you like using the <em>Ctrl</em> key on your keyboard.',
+	'RECENT_SECTIONS'				=> 'Sections',
+	'RECENT_SECTIONS_EXPLAIN'		=> 'Define the sections to be displayed in the block and their order.',
+	'RECENT_TOPIC_LIMIT'			=> 'Topic limit',
+	'RECENT_TOPIC_LIMIT_EXPLAIN'	=> 'Maximum number of items to be displayed in each tab.',
+
+	// Rss block
+	'1_HOUR'		=> 'One hour',
+	'2_HOURS'		=> 'Two hours',
+	'6_HOURS'		=> 'Siz hours',
+	
+	'RSS_COLLAPSABLE'			=> 'Collapsable',
+	'RSS_COLLAPSABLE_EXPLAIN'	=> 'Sets whether the items are displayed in an accordion or scrolling. If set to "Yes" will override the block scroll.',
+	'RSS_DIRECTION'				=> 'Scroll direction',
+	'RSS_DIRECTION_EXPLAIN'		=> 'Defining the direction of scrolling text. This option is canceled if the items are displayed in an accordion.',
+	'RSS_HEIGHT'				=> 'Block height',
+	'RSS_HEIGHT_EXPLAIN'		=> 'Sets the height of the block, in pixels. Only apply if items are not displayed in accordion format.',
+	'RSS_IGNORE_LANG'			=> 'Ignore feed lang',
+	'RSS_IGNORE_LANG_EXPLAIN'	=> 'If enabled, all URLs are read, regardless of their language, otherwise it will only display the contents written in the language of the user.',
+	'RSS_LIMIT'					=> 'Feed limit',
+	'RSS_LIMIT_EXPLAIN'			=> 'Maximum number of items to be read from each URL.',
+	'RSS_SOURCES'				=> 'Feed sources',
+	'RSS_TITLE'					=> 'Feed title',
+	'RSS_TTL'					=> 'Refresh time',
+	'RSS_TTL_EXPLAIN'			=> 'Time will remain cached items before attempting to read the source again.',
+	'RSS_URL'					=> 'File url',
+	'RSS_URL_EXPLAIN'			=> 'Ex: <em>http://midominio.com/rss.xml</em>',
+
+	// scroll_message_block
+	'MARQUEE_DIRECTION'				=> 'Scroll direction',
+	'MARQUEE_DIRECTION_EXPLAIN'		=> 'Scroll direction for the text. This attribute controls the direction of scrolling.',
+	'MARQUEE_SPEED'					=> 'Scroll amount',
+	'MARQUEE_SPEED_EXPLAIN'			=> 'This controls the amount of movement (in pixels) between the successive displays that give the impression of animation.',
+	'MARQUEE_SCROLLDELAY'			=> 'Scroll delay',
+	'MARQUEE_SCROLLDELAY_EXPLAIN'	=> 'This controls the delay (in milliseconds) between the successive displays that give the impression of animation.',
+	'MARQUEE_ALIGN'					=> 'Scroll align',
+	'MARQUEE_ALIGN_EXPLAIN'			=> 'This tag controls the positioning of the marquee display box relative to the current text in exactly the same manner as the img tag\'s align attribute.',
+	'MARQUEE_BGCOLOR'				=> 'Scroll bgcolor',
+	'MARQUEE_BGCOLOR_EXPLAIN'		=> 'This tag controls the background colour of the display box.',
+	'MARQUEE_HEIGHT'				=> 'Scroll height',
+	'MARQUEE_HEIGHT_EXPLAIN'		=> 'This controls the height of the display box.',
+	'MARQUEE_PADDING'				=> 'ScrollBox Padding',
+	'MARQUEE_PADDING_EXPLAIN'		=> 'Space around the scroll box. This attribute is equivalent to the attribute "padding" of CSS.',
+	'MARQUEE_TEXT'					=> 'Scroll message text',
+	'MARQUEE_TEXT_EXPLAIN'			=> 'Add/change a scrollable message here. Limit 2000 characters.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+
+	'BOTTOM'		=> 'Bottom',
+	'DOWN'			=> 'Down',
+	'LEFT'			=> 'Left',
+	'CENTER'		=> 'Center',
+	'UP'			=> 'Up',
+	'RIGHT'			=> 'Right',
+	'TOP'			=> 'Top',
+	
+	//share_block
+	'SHARE_SHOW_NAMES'			=> 'Show names',
+	'SHARE_SHOW_NAMES_EXPLAIN'	=> 'If enabled, the name of the social network will be displayed next to its icon.',
+	'SHARE_URL'					=> 'Reference URL',
+	'SHARE_URL_EXPLAIN'			=> 'Set a fixed reference url for the buttons. Leave this field blank to use the displayed page.',
+	'SHARE_BUTTONS'				=> 'Buttons to show',
+	
+	// stats_block
+	'STATS_INLINE'			=> 'Show data in line',
+ 	'USER_STATS'			=> 'Display user statistics',
+	
+	// top_topics_block
+	'TOPT_LIMIT'			=> 'Topic limit',
+	'TOPT_LIMIT_EXPLAIN'	=> 'Maximun number of topic to show.',
+	'TOPT_MODE'				=> 'Topic to show',
+	'TOPT_MODE_ACTIVE'		=> 'Latest topics more active',
+	'TOPT_MODE_UNREAD'		=> 'Latest unread topics',
+	'TOPT_MODE_VIEWED'		=> 'More viewed topics',
+
+	// topic_index_block
+	'TINDEX_CHAR_SELECT'			=> 'Show Index',
+	'TINDEX_CHAR_SELECT_EXPLAIN'	=> 'Only avaliable if the sort method is <em>Topic title</em>.',
+	'TINDEX_PER_PAGE'			=> 'Topics per page',
+	'TINDEX_PER_PAGE_EXPLAIN'	=> 'Number of topics that will be show at the same time. Set 0 to disable pagination.',
+	'TINDEX_SORT_MODE'			=> 'Order by',
+	'TINDEX_SORT_MODE_EXPLAIN'	=> 'Method that will be used to set the topic\'s order in the list.',
+  
+	'TOPIC_TIME'		=> 'Topic date',
+	'LAST_POST_TIME'	=> 'Last post date',
+
+	// welcome_block
+	'WELCOME_GUEST'				=> 'Guests message',
+	'WELCOME_GUEST_EXPLAIN'		=> 'Message to display to all guests. 2000 characters max.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+	'WELCOME_MEMBER'			=> 'Members message',
+	'WELCOME_MEMBER_EXPLAIN'	=> 'Message to display to all the forum registered users. 2000 characters max.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+
+	// whos_online_block
+	'WHOS_ADVANCED'				=> 'Advanced mode',
+	'WHOS_ADVANCED_EXPLAIN'		=> 'If enabled, will display all the information, otherwise it will appear only basic information (suitable for side blocks).',
+	'WHOS_USERNAMES'			=> 'Show user list',
+	'WHOS_USERNAMES_EXPLAIN'	=> 'If enabled, displays the list of users online (only in advanced mode).',
+
+	// youtube_block
+	'YT_AUTOPLAY'				=> 'AutoPlay enabled',
+	'YT_AUTOPLAY_EXPLAIN'		=> 'If enabled, the video will play automatically.<br />If you have multiple videos, only the first autoplay.',
+	'YT_DISPLAY_MODE'			=> 'Display Mode',
+	'YT_FULL_PREVIEW'			=> 'Show thumbnails, title and description',
+	'YT_LIST'					=> 'Show a list with titles',
+	'YT_RANDOM_DISPLAY'			=> 'Random Display',
+	'YT_RANDOM_DISPLAY_EXPLAIN'	=> 'If enabled, only one video will be appear randomly. Otherwise, all the videos and channels appear at once.',
+	'YT_RESULT_LIMIT'			=> 'Number of channel videos',
+	'YT_RESULT_LIMIT_EXPLAIN'	=> 'Maximun number of videos loaded in each channel.',
+	'YT_SIMPLE_PREVIEW'			=> 'Show thumbnails and titles',
+	'YT_TEXT_LIMIT'				=> 'Text limit',
+	'YT_TEXT_LIMIT_EXPLAIN'		=> 'Maximun number of characters in the video description.',
+	'YT_VIDEO_PREVIEW'			=> 'Show video preview',
+	'YT_VIDEO_SIZE'				=> 'Player size',
+	'YT_VIDEO_TITLE'			=> 'Video title',
+	'YT_VIDEO_URL'				=> 'Video url',
+	'YT_VIDEO_URL_EXPLAIN'		=> 'Ex: <em>https://www.youtube.com/watch?v=NHH_v0k7Gus</em>',
+));
diff --git "[FORUM_EXT]/canidev\\blockgets/language/pt/chat_addon.php" "[FORUM_EXT]/canidev\\blockgets/language/pt/chat_addon.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/language/pt/chat_addon.php"
@@ -0,0 +1,32 @@
+<?php
+/** 
+* chat_addon.php [English [En]]
+*
+* @package language cBB Blockgets
+* @version v2.0.1 04/05/2018
+*
+* @copyright (c) 2018 CaniDev
+* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+*/
+
+// @ignore
+if(!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if(empty($lang['blocks']))
+{
+	$lang['blocks'] = array();
+}
+
+$lang['blocks'] = array_merge($lang['blocks'], array(
+	'chat_title'	=> 'Chat',
+	'chat_explain'	=> 'Allows you to use cBB Chat as a block in the columns or show the users connected to the chat.',
+));
+
+$lang = array_merge($lang, array(
+	'CHAT_ADDON_MODE'		=> 'Display mode',
+	'CHAT_MODE_CHAT'		=> 'Chat room',
+	'CHAT_MODE_USERS'		=> 'Online Users',
+));
diff --git "[FORUM_EXT]/canidev\\blockgets/language/pt/email/contact_block.txt" "[FORUM_EXT]/canidev\\blockgets/language/pt/email/contact_block.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/language/pt/email/contact_block.txt"
@@ -0,0 +1,6 @@
+
+The following is an e-mail sent to you from "{SITENAME}" for {FROM_USERNAME} by the contact form:
+
+----------
+
+{MESSAGE}
diff --git "[FORUM_EXT]/canidev\\blockgets/language/pt/info_acp_blockgets.php" "[FORUM_EXT]/canidev\\blockgets/language/pt/info_acp_blockgets.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/language/pt/info_acp_blockgets.php"
@@ -0,0 +1,53 @@
+<?php
+/*
+* info_acp_blockgets.php [English [En]]
+* @package cBB Blockgets
+* @version v2.0.2 12/01/2021
+*
+* @copyright (c) 2021 CaniDev
+* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+*/
+
+// @ignore
+if(!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+/**
+ * @general tags and messages
+*/
+$lang = array_merge($lang, array(
+	'ACP_BLOCKGETS'				=> 'Blockgets',
+	'ACP_BLOCKGETS_GENERAL'		=> 'General',
+	
+	'ACP_BLG_CONFIG_MAIN'		=> 'General configuration',
+	'ACP_BLG_CONFIG_OPTIONAL'	=> 'Additional configuration',
+	'ACP_BLG_IMAGES'			=> 'Images',
+	'ACP_PAGES_AND_BLOCKS'		=> 'Pages and Blocks',
+	
+	// Logs
+	'LOG_BLG_CONFIG'		=> '<strong>cBB Blockgets:</strong> Changed main configuration',
+	'LOG_BLOCK_ADDED'		=> '<strong>cBB Blockgets:</strong> New block added<br />» %1$s in %2$s',
+	'LOG_BLOCK_COPY_PAGE'	=> '<strong>cBB Blockgets:</strong> Blocks copied<br />» de %1$s a %2$s',
+	'LOG_BLOCK_MOVED'		=> '<strong>cBB Blockgets:</strong> Changed blocks position<br />» %1$s',
+	'LOG_BLOCK_MOVED_PAGE'	=> '<strong>cBB Blockgets:</strong> Blocks moved<br />» from %1$s to %2$s',
+	'LOG_BLOCK_REMOVED'		=> '<strong>cBB Blockgets:</strong> Block(s) deleted<br />» en %1$s',
+	'LOG_BLOCK_UPDATED'		=> '<strong>cBB Blockgets:</strong> Block edited<br />» %1$s en %2$s',
+	'LOG_EVENT_REMOVED'		=> '<strong>cBB Blockgets:</strong> Event deleted<br />» %1$s',
+	'LOG_LIST_REMOVED'		=> '<strong>cBB Blockgets:</strong> List deleted<br />» %1$s',
+	'LOG_PAGE_ADDED'		=> '<strong>cBB Blockgets:</strong> New page added<br />» %1$s',
+	'LOG_PAGE_UPDATED'		=> '<strong>cBB Blockgets:</strong> Changed page<br />» %1$s',
+	'LOG_PAGE_REMOVED'		=> '<strong>cBB Blockgets:</strong> Page deleted<br />» %1$s',
+	
+	// Permissions
+	'ACL_A_BLOCKGETS_MANAGE'	=> 'Can manage cBB Blockgets',
+	'ACL_U_BLOCKGETS_BIRTHDAYS'	=> 'Can see birthdays in the Calendar',
+	'ACL_U_BLOCKGETS_CALENDAR'	=> 'Can view calendar',
+	'ACL_U_BLOCKGETS_EVENTS'	=> 'Can manage calendar events',
+));
diff --git "[FORUM_EXT]/canidev\\blockgets/language/pt/installer.php" "[FORUM_EXT]/canidev\\blockgets/language/pt/installer.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/language/pt/installer.php"
@@ -0,0 +1,43 @@
+<?php
+/*
+* installer.php [English [En]]
+* @package cBB Blockgets
+* @version v2.0.2 12/01/2021
+*
+* @copyright (c) 2021 CaniDev
+* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+*/
+
+// @ignore
+if(!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if(empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+// Local Variables
+$lang = array_merge($lang, array(
+	'PORTAL'			=> 'Portal',
+	'DOCK_MENU'			=> 'Dock menu',
+	'MAIN_MENU'			=> 'Main Menu',
+	'RECOMMENDED'		=> 'Recommended',
+
+	'P_ADMIN'			=> 'Administration',
+	'P_MAIN'			=> 'Main',
+	'P_MCP'				=> 'Moderation Panel',
+	'P_ACP'				=> 'Administration Panel',
+
+	'PHPBB_TITLE'		=> 'phpBB official website',
+	'XAMPP_TITLE'		=> 'Xampp',
+	'SOURCEFORGE_TITLE'	=> 'Open source applications',
+
+	'WELCOME_GUEST'		=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Forum equipped with cBB Blockgets</i><br /><br />Welcome to our forum!<br />Register to access all the content!.</strong></div>[/html]',
+	'WELCOME_MEMBER'	=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Forum equipped with cBB Blockgets</i><br /><br />Welcome back to our forum {S_USERNAME}</strong></div>[/html]',	
+
+	'CORE_INSTALL_ERROR'	=> 'You have not uploaded all the files from the installation package or you are trying to install an old package.<br />
+		Please make sure to upload all the files (including the <em>core</em> folder) and use a package downloaded from the official website.',
+));
diff --git "[FORUM_EXT]/canidev\\blockgets/language/pt/main.php" "[FORUM_EXT]/canidev\\blockgets/language/pt/main.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/language/pt/main.php"
@@ -0,0 +1,269 @@
+<?php
+/*
+* main.php [English [En]]
+* @package cBB Blockgets
+* @version v2.0.2 12/01/2021
+*
+* @copyright (c) 2021 CaniDev
+* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+*/
+
+// @ignore
+if(!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if(empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'PORTAL'			=> 'Portal',
+	'READ_FULL'			=> 'Read full topic',
+	'BLG_READ_MORE'		=> '%sLer mais%s',
+
+	'ADD_PAGE'					=> 'Criar página',
+	'BANNERS'					=> 'Banners',
+	'CALENDAR'					=> 'Calendário',
+	'CALENDAR_BIRTHDAY_TITLE'	=> '%1$s e <strong>mais %2$d</strong>.',
+	'CALENDAR_SELECT_DATE'		=> 'Seleccionar data',
+	'EDIT_CONFIGURATION'		=> 'Editar configuração',
+	'EDIT_THIS_PAGE'			=> 'Editar esta página',
+	'EDITOR'					=> 'Editor',
+	'EXPAND_CONTRACT'			=> 'Expandir/colapsar',
+	'INSERT_ON_ENTRY'			=> 'Inserir no texto',
+	'MANAGE_BLOCKS'				=> 'Gerir blocos',
+	'PRINT'						=> 'Imprimir',
+	'SELECT_COLOUR'				=> 'Seleccionar cor',
+	'SMILIES'					=> 'Emoticons',
+	'TODAY'						=> 'Hoje',
+
+	// Editor
+	'HTML_TITLE' 		=> 'Html:',
+	'INSERT_HTML' 		=> 'Inserir Código HTML',
+
+	// Login Block
+	'HIDE_ME_NOW'			=> 'Hide me in this session',
+	'MY_BOOKMARKS'			=> 'Favoritos',
+	'MY_SUBSCRIBED'			=> 'Subscrições',
+	'REMEMBER_ME'			=> 'Lembrar-me',
+
+	// Link Us Block
+	'LINK_US_TXT'			=> 'Please feel free to link to <strong>%s</strong>. Use the following HTML:',
+
+	// Stats Block and whos_online block
+	'GUEST_VISITS_TOTAL'		=> '%d Visitantes',
+	'GUEST_VISIT_TOTAL'			=> '%d Visitante',
+	'HIDDEN_VISITS_TOTAL'		=> '%d ocultos, ',
+	'HIDDEN_VISIT_TOTAL'		=> '%d oculto, ',
+	'LASTVISIT_VISITS_TOTAL'	=> 'In total there were <strong>%d</strong> users online in the last 24 hours :: ',
+	'LASTVISIT_VISIT_TOTAL'		=> 'In total there is <strong>%d</strong> user online in the last 24 hours  :: ',
+	'REG_VISITS_TOTAL'			=> '%d Registados, ',
+	'REG_VISIT_TOTAL'			=> '%d Registado, ',
+
+	'ST_ACTIVE_POSTERS'			=> 'Active posters',
+	'ST_ANNS'					=> 'Announcements',
+	'ST_ATTACHMENTS'			=> 'Anexos',
+	'ST_BOARD_STARTDATE'		=> 'Start date',
+	'ST_NEW'					=> 'Novo',
+	'ST_NEWEST_USER'			=> 'Último membro',
+	'ST_POSTS'					=> 'Mensagens',
+	'ST_POSTS_PER_DAY'			=> 'Mensagens por dia',
+	'ST_POSTS_PER_TOPIC'		=> 'Mensagens por tópico',
+	'ST_POSTS_PER_USER'			=> 'Mensagens por utilizador',
+	'ST_STICKYS'				=> 'Importantes',
+	'ST_TOP'					=> 'Total',
+	'ST_TOPICS'					=> 'Tópicos',
+	'ST_TOPICS_PER_DAY'			=> 'Tópicos por dia',
+	'ST_TOPICS_PER_USER'		=> 'Tópicos por utilizador',
+	'ST_TOTAL_USERS'			=> 'Total utilizadores',
+	'ST_USERS_PER_DAY'			=> 'Utilizadores por dia',
+	'ST_VISIT_IP'				=> 'O teu IP',
+
+	'WIO_ONLINE'			=> 'Utilizadores online',
+	'WIO_LASTDAY'			=> 'Utilizadores hoje',
+	'WIO_TOTAL'				=> 'Total',
+	'WIO_REGISTERED'		=> 'Registados',
+	'WIO_HIDDEN'			=> 'Ocultos',
+	'WIO_GUEST'				=> 'Visitantes',
+
+	// polls
+	'NO_POLL'			=> 'Votação indisponível',
+
+	// attachments_block
+	'ATTACH_DATE'			=> 'Publicado',
+	'ATTACH_SIZE'			=> 'Tamanho',
+	'ATTACH_DOWNLOAD'		=> 'Transferido',
+	'ATTACH_VIEW'			=> 'Visto',
+
+	'ATTACH_COUNT'				=> array(
+		0	=> 'Nunca',
+		1	=> '%d vez',
+		2	=> '%d vezes',
+	),
+
+	'VIEW_TOPIC'				=> 'Ver Tópico',
+	'DOWNLOAD'					=> 'Download',
+	'NO_ATTACHMENTS'			=> 'Sem anexos disponíveis',
+
+	// language_select_block
+	'LANGUAGE_CHANGE'		=> 'Alterar idioma',
+	'LANGUAGE_DEFAULT'		=> 'Idioma Original',
+	'LANGUAGE_SET_MINE'		=> 'Gravar como meu idioma',
+	'LANGUAGE_SELECT'		=> 'Selecionar Idioma',
+
+	// news_block
+	'POSTED_BY'			=> 'Criado por',
+	'LAST_REPLIED_BY'	=> 'Última resposta por',
+	'COMMENTS_PORTAL'	=> 'Comentários',
+	'POLL'				=> 'Votação',
+	'TOPIC_VIEWS'		=> 'Visto',
+	'NO_NEWS'			=> 'Sem notícias disponíveis',
+	'VIEW_COMMENTS'		=> 'Ver comentários',
+
+	// recent_topics_block
+	'BLG_RECENT_ACTIVITY'	=> 'Actividade Recente',
+	'BLG_RECENT_ANN'		=> 'Anúncios Recentes',
+	'BLG_RECENT_TOPICS'		=> 'Tópicos Recentes',
+
+	// paypal_block
+	'AMOUNT_MSG'		=> 'Amount to donate',
+	'CLICK_MSG'			=> 'Proceed to donation',
+	'CODE_MSG'			=> 'Currency',
+	
+	'currencies'	=> array(
+		'AUD'	=> 'Aussie',
+		'CAD' 	=> 'Canadian Dollar',
+		'CZK' 	=> 'Czech Koruna',
+		'DKK' 	=> 'Danish Kroner',
+		'HKD' 	=> 'Hong Kong Dollar',
+		'HUF' 	=> 'Hungarian Forint',
+		'NZD' 	=> 'New Zealand Dollar',
+		'NOK' 	=> 'Norwegian Kroner',
+		'PLN' 	=> 'Polish Zlotych',
+		'GBP' 	=> 'British Pounds',
+		'SGD' 	=> 'Singapore Dollar',
+		'SEK' 	=> 'Swedish Kronor',
+		'CHF' 	=> 'Swiss Francs',
+		'JPY' 	=> 'Japanese Yen',
+		'USD' 	=> 'Dollar',
+		'EUR' 	=> 'Euro',
+		'AUD' 	=> 'Mexican Peso',
+		'ILS' 	=> 'New Israeli Shekels'
+	),
+
+	// most_poster_block
+	'MEMBER_POSTS'		=> '%d (%.2f/dia)',
+	'USER'				=> 'Utilizador',
+	'NO_MOST_POSTER'	=> 'Sem utilizadores para exibir',
+
+	// contact block
+	'EMAIL_EMPTY'		=> 'You must set an email.',
+	'EMAIL_INVALID'		=> 'The entered email is invalid.',
+
+	// counter block
+	'COUNTER_LOCAL'		=> 'Visits to this page',
+	'COUNTER_TOTAL' 	=> 'Total visits',
+	'COUNTER_STARTDATE' => 'Counting from:<br />%s',
+	'HITS_PER_DAY'		=> 'Visits per day',
+	'HITS_PER_HOUR'		=> 'Visits per hour',
+	'HITS_PER_MONTH'	=> 'Visits per month',
+	'HITS_PER_USER'		=> 'Visits per user',
+	'HITS_PER_WEEK'		=> 'Visits per week',
+	'HITS_PER_YEAR'		=> 'Visits per year',
+
+	// style_select_block
+	'STYLE_CHANGE'		=> 'Change Style',
+	'STYLE_DEFAULT'		=> 'Original style',
+	'STYLE_SET_MINE'	=> 'Set as my style',
+	'STYLE_SELECT'		=> 'Select style',
+
+	// latest_bots_block
+	'NO_BOTS'			=> 'Nenhum bot visitou o fórum',
+
+	// latest_unread_block
+	'NO_UNREAD'			=> 'Sem tópicos',
+
+	// ranks_block
+	'MIN_POSTS'			=> 'Minimum Posts',
+	'SPECIAL_RANK'		=> 'Special Rank',
+
+	// online_friends_block
+	'FRIENDS_ONLINE'		=> 'Online friends',
+	'FRIENDS_OFFLINE'		=> 'Offline friends',
+	'NO_FRIENDS_ONLINE'		=> 'No friends online',
+	'NO_FRIENDS_OFFLINE'	=> 'No friends offline',
+	'NO_FRIENDS'			=> 'No friends found',
+
+	// age_ranges_block
+	'RANGE'				=> 'Rank',
+	'RANGE_USERS'		=> 'Utilizadores (%)',
+	'AGE_COUNTS'		=> 'Utilizadores contados',
+	'AGE_AV'			=> 'Idade média',
+	'AGE_AV_COUNT'		=> '%.2f anos',
+
+	// search_block
+	'SH_ENGINE'			=> 'Search Engines',
+
+	// announcements_block
+	'NO_ANNOUNCEMENTS'	=> 'Sem Anúncios',
+
+	//birthday_block
+	'TODAY_BIRTHDAYS'		=> 'Today Birthdays',
+	'TOMORROW_BIRTHDAYS'	=> 'Tomorrow Birthdays',
+	'BIRTHDAYS_FOR'			=> 'Birthdays for %1$s of %2$s',
+
+	// calendar
+	'ADD_EVENT'				=> 'Adicionar evento',
+	'DELETE_EVENT'			=> 'Remover Evento',
+	'EDIT_EVENT'			=> 'Editar Evento',
+	'EVENTS'				=> 'Eventos',
+
+	'EMPTY_EVENT_TITLE'	=> 'Tem de colocar um título para o evento.',
+	'EVENT_ADDED'		=> 'Evento adicionado com sucesso',
+	'EVENT_COLOR'		=> 'Cor',
+	'EVENT_EDITED'		=> 'Evento editado com sucesso',
+	'EVENT_GROUPS'		=> 'Grupos autorizados',
+	'EVENT_TITLE'		=> 'Título do Evento',
+	'EVENT_TIME'		=> 'Data do Evento',
+	'EVENT_DETAILS'		=> 'Detalhes',
+	'EVENT_REMOVED'		=> 'Evento removido com sucesso',
+	'NO_EVENTS'			=> 'Sem eventos',
+	
+	//player block
+	'MUTE'				=> 'Silenciar',
+	'WIN_CLOSE'			=> 'Fechar janela e regressar ao bloco',
+	'WIN_OPEN'			=> 'Abrir numa nova janela',
+	'WIN_OPEN_EXPLAIN'	=> 'Playing in Window',
+	'WIN_RETURN'		=> 'Forze player in the block',
+	'PLAY'				=> 'Play',
+	'PLAY_MSG'			=> 'Playing',
+	'PLAYER'			=> 'Player',
+	'STOP'				=> 'Parar',
+	'STOP_MSG'			=> 'Parou',
+	'VOLUME'			=> 'Volume',
+	'VOLUME_MSG'		=> 'Volume: %d%',
+	
+	// rss block
+	'NO_RSS'		=> 'Sem Rss/Feed para mostrar.',
+
+	// topic index block
+	'CHAR_ALL'		=> 'Todos',
+	
+	// youtube block
+	'YT_EMPTY'		=> 'Sem vídeos para mostrar',
+	'YT_VIEWS'		=> '%d vistos',
+));
+
+// General messages
+$lang = array_merge($lang, array(
+	'ACTION_ERROR'		=> 'No action taken',
+	'BLOCK_LOAD_ERROR'	=> 'Failed to load block',
+	'FORMAT_INVALID'	=> 'The format is not valid',
+	'EVENT_ERROR'		=> 'The selected event does not exist',
+	'NO_TRACKLIST'		=> 'No avaliable tracklist.',
+	'NO_PAGE'			=> 'This page no exists.',
+	'URL_INVALID'		=> 'The URL is not valid.',
+));
diff --git "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/acp.php" "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/acp.php"
@@ -0,0 +1,357 @@
+<?php
+/*
+* acp.php [English [En]]
+* @package cBB Blockgets
+* @version v2.0.2 12/01/2021
+*
+* @copyright (c) 2021 CaniDev
+* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+*/
+
+// @ignore
+if(!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+// @acp_blockgets
+$lang = array_merge($lang, array(
+	'BLG_CONFIG_TITLE'				=> 'General configuration',
+	'BLG_CONFIG_EXPLAIN'			=> 'Thank you for choosing cBB Blockgets as a complement for your forum!<br />From here you can set the main settings of the extension.<br />Lateral links allow you to access all the options to set comfortably the mod.',
+	'BLG_IMAGES_TITLE'				=> 'Available images',
+	'BLG_OPTIONAL_TITLE'			=> 'Additional configuration',
+	'BLG_OPTIONAL_EXPLAIN'			=> 'From here you can set additional settings for the site.',
+	
+	'BLG_ADMIN_BAR'					=> 'Show quick access bar',
+	'BLG_ADMIN_BAR_EXPLAIN'			=> 'If enabled, a bar will be displayed at the top of the forum that will allow you to quickly access the options of the page where you are.',
+	'BLG_BLOCK_AUTOFIT'				=> 'AutoFit blocks',
+	'BLG_BLOCK_AUTOFIT_EXPLAIN'		=> 'If enabled, the content and disposition of the blocks will be adjust to the column.',
+	'BLG_COLLAPSE'					=> 'Allow collapse blocks',
+	'BLG_COLLAPSE_EXPLAIN'			=> 'Enable/disable globally the possibility that each user can collapse/expand blocks individually. This option overwrite the individual block\'s configuration.',
+	'BLG_FULL_EDITOR'				=> 'Full editor',
+	'BLG_ON_BOARD'					=> 'Blocks within the forum',
+	'BLG_ON_BOARD_EXPLAIN'			=> 'Sets whether to display the blocks into the forum pages. This option overwrite the invidual page\'s configuration.<br /><br />
+		<em>
+			&nbsp;&nbsp;<strong>Not show:</strong> It does not show blocks on any page.<br />
+			&nbsp;&nbsp;<strong>Individual pages:</strong> It shows the blocks on the pages configured for it.<br />
+			&nbsp;&nbsp;<strong>Equal pages:</strong> The "General Index" blocks are shown on all pages.
+		</em>',
+	'BLG_REDIRECTIONS'				=> 'Redirections',
+	'BLG_REDIRECT_404'				=> 'Page not found',
+	'BLG_REDIRECT_404_EXPLAIN'		=> 'Sets the page to which the user will be taken when trying to access a location that does not exist.<br />
+		<em>Replace the message No route found for "GET" of phpBB.</em>',
+	'BLG_REDIRECT_LOGIN'			=> 'Login',
+	'BLG_REDIRECT_LOGIN_EXPLAIN'	=> 'Sets the page to which the user will be taken after login to the forum.',
+	'BLG_REDIRECT_LOGOUT'			=> 'Logout',
+	'BLG_REDIRECT_LOGOUT_EXPLAIN'	=> 'Sets the page to which the user will be taken when disconnecting.',
+
+	'DEFAULT'					=> 'By default',
+	'LINKS'						=> 'Links',
+	'OPEN_GALLERY'				=> 'Open gallery',
+	'SAVE_AND_ADD'				=> 'Save and add more',
+	'TYPE_DOMAIN_HOME'			=> 'Domain\'s main page',
+	'TYPE_FORUM_HOME'			=> 'Forum\'s main page',
+	'TYPE_FORUM_SECONDARY'		=> 'Forum\'s secondary page',
+
+	'BOARD_BLOCK_INDIVIDUAL'	=> 'Individual pages',
+	'BOARD_BLOCK_NONE'			=> 'Not show',
+	'BOARD_BLOCK_SAME'			=> 'Equal pages',
+
+	'AVATAR_RESIZE_WIDTH'			=> 'Size of avatars',
+	'AVATAR_RESIZE_WIDTH_EXPLAIN'	=> 'Maximum size allowed (in pixels) for avatars.<br />
+		<em>Set 0 to disable avatar resizing</em>.',
+	'CALENDAR'						=> 'Calendar',
+	'CALENDAR_ENABLED'				=> 'Calendar enabled',
+	'CALENDAR_ENABLED_EXPLAIN'		=> 'Defines whether the calendar will be available in both the<em>/calendar path</em> and blocks.',
+	'CALENDAR_BIRTHDAYS'			=> 'Show Birthdays',
+	'CALENDAR_BIRTHDAYS_EXPLAIN'	=> 'If enabled, user\'s birthdays will be marked and displayed on the calendar, as if they were events.',
+	'CALENDAR_LINK'					=> 'Link',
+	'CALENDAR_LINK_EXPLAIN'			=> 'Define in which part of the forum a link to the calendar will appear.',
+	'CALENDAR_FIRST_DAY'			=> 'First day of the week',
+	'CALENDAR_FIRST_DAY_EXPLAIN'	=> 'Define the first day of the week on the calendar.',
+	'COUNTER'						=> 'Hit Counter',
+	'COUNTER_RESET'					=> 'Reset hit counter',
+	'COUNTER_RESET_EXPLAIN'			=> 'Sets the visits to 0 and the counter start to the current date.',
+	'HOME_TYPE_DISPLAY'				=> 'Behavior of the home page',
+	'HOME_TYPE_DISPLAY_EXPLAIN'		=> 'Sets how the home page will work, if it is enabled.',
+	'IMAGE_RESIZE'					=> 'Resize images',
+	'IMAGE_RESIZE_POST'				=> 'Resize images in posts',
+	'IMAGE_RESIZE_POST_EXPLAIN'		=> 'Enable/Disable the resize in the images inside the forum posts.',
+	'IMAGE_RESIZE_WIDTH'			=> 'Images max size',
+	'IMAGE_RESIZE_WIDTH_EXPLAIN'	=> 'Maximum size (in pixels) for images. The default is 450.<br />
+		<em>Set 0 to disable image resizing</em>.',
+
+	'INDEX_FILE_ERROR'				=> 'Failed to complete setup',
+));
+
+// @acp_blockgets_lists
+$lang = array_merge($lang, array(
+	'ADD_ITEM'				=> 'Add item',
+	'CAT'					=> 'Category',
+
+	'LINK'						=> 'Link',
+	'LINK_DESCRIPTION'			=> 'Description',
+	'LINK_DESCRIPTION_EXPLAIN'	=> 'This text will be show in some blocks as aditional link information.',
+	'LINK_GROUP'				=> 'Groups',
+	'LINK_GROUP_EXPLAIN'		=> 'Select groups of users that can see this link in the menu.<br />You can select multiple groups using the <em>Ctrl</em> key on your keyboard.',
+	'LINK_IMG'					=> 'Image',
+	'LINK_TITLE'				=> 'Link title',
+	'LINK_TITLE_EXPLAIN'		=> 'Title that identifies the link. Limit 100 characters.',
+	'LINK_TYPE'					=> 'Link type',
+	'LINK_URL'					=> 'Link URL',
+	'LINK_URL_EXPLAIN'			=> 'The direction that opens when you click on the link. Limit 255 characters.',
+	'LINK_WINDOW'				=> 'Open in New Window',
+));
+
+// @acp_blockgets_pages
+$lang = array_merge($lang, array(
+	'ADD_BLOCK'					=> 'Add block',
+	'ADD_BLOCK_TIP'				=> 'Drag a block to the position you want to add it.',
+	'ADD_BLOCK_TITLE'			=> 'Add block :: %1$s',
+	'ADD_BLOCK_TITLE_EXPLAIN'	=> 'From here you can add a new block to your forum and set its configuration. You can also set additional settings, if the block you need.',
+	'ADD_GROUP'					=> 'Add group',
+	'ADD_GROUP_EXPLAIN'			=> 'Drag this button to the desired position to add a group',
+	'ADVANCED_OPTIONS'			=> 'Advanced options',
+
+	'BLOCK_SETTINGS'			=> 'General options for the block',
+	'BLOCK_SPACE'				=> 'Space between blocks',
+	'BLOCK_SPACE_EXPLAIN'		=> 'Value in pixels or percentage. The minimun value is 1.',
+	'BOTTOM_COLUMN'				=> 'Bottom column',
+	'CENTER_COLUMN'				=> 'Center column',
+	'CHG_GROUPS_BLOCK'			=> 'Change permissions',
+	'CHG_GROUP_EXPLAIN'			=> 'Choose groups who can see the selected blocks',
+	'COLUMN_SETTINGS'			=> 'Options for the columns',
+	'COPY_BLOCK'				=> 'Copy to other page',
+	'DELETE_BLOCK_CONFIRM'		=> 'Are you sure you want to delete the selected blocks?',
+	'DISABLE_BLOCK'				=> 'Disable',
+	'EDIT_BLOCK_TITLE'			=> 'Edit block :: %1$s',
+	'EDIT_BLOCK_TITLE_EXPLAIN'	=> 'Here you can edit the configuration of the block, as well as additional settings, if the block you need.',
+	'ENABLE_BLOCK'				=> 'Enable',
+	'EXT_ROUTES'				=> 'Extension\'s routes',
+	'FILTER_TYPE_GET'			=> 'Url (GET)',
+	'FILTER_TYPE_POST'			=> 'Form (POST)',
+	'FORUM_FILES'				=> 'Forum files',
+	'LEFT_COLUMN'				=> 'Left column',
+	'LEFT_COLUMN_EXPLAIN'		=> 'Width of the left column in pixels or percentage.<br />Set 0 to disable the column.',
+	'LINK_BOTTOM'				=> 'Bottom',
+	'LINK_QUICK'				=> 'Quick links',
+	'LINK_NONE'					=> 'No link',
+	'LINK_TOP'					=> 'Top',
+	'MANAGE_PAGE'				=> 'Manage page',
+	'MOVE_BLOCK'				=> 'Move to other page',
+	'NO_PAGES_CREATED'			=> 'No pages created.',
+	'NO_PAGE_FILTERS'			=> 'No filters',
+	
+	'PAGE'						=> 'Page',
+	'PAGE_ADD'					=> 'New page',
+	'PAGE_ALIAS'				=> 'Page alias',
+	'PAGE_ALIAS_EXPLAIN'		=> 'You can set an alias (letters, numbers and dashes) to create a separate page.<br />If you leave this field blank, it will create a separate page and will be used the ID as alias.',
+	'PAGE_ALIAS_ERROR'			=> 'The value inserted in "Alias page" field contains illegal characters or an invalid path.',
+	'PAGE_BACKGROUND'			=> 'Page background',
+	'PAGE_BACKGROUND_EXPLAIN'	=> 'You can set a color (ex. white, #FFFFFF) or an image (ex. http://mydomain.com/image.jpg). Leave this field blank to use the default background.',
+	'PAGE_CUSTOM'				=> 'Custom Pages',
+	'PAGE_CUSTOM_EXPLAIN'		=> 'These are pages created by you or another administrator of this site. You can add, edit and manage as many pages as you wish.',
+	'PAGE_CUSTOM_ONE'			=> 'Custom Page',
+	'PAGE_DESCRIPTION'			=> 'SEO Description',
+	'PAGE_DESCRIPTION_EXPLAIN'	=> 'Defines a description visible to search engines.<br /><em>Google, bing, etc...</em>',
+	'PAGE_ENABLED'				=> 'Page enabled',
+	'PAGE_ENABLED_EXPLAIN'		=> 'Enable or disable the page functions completely. This option overrides all others.',
+	'PAGE_FILTERS'				=> 'Filters',
+	'PAGE_FILTERS_EXPLAIN'		=> 'Define the required parameters (GET and POST) for the page is loaded.<br />Check <strong>Online Documentation</strong> for more information on how to set these filters.',
+	'PAGE_FILTER_PARAM'			=> 'Parameters',
+	'PAGE_FILTER_PARAM_EXPLAIN'	=> 'You can set as many as you want separated by ","<br />Ex: mode=mymode,style=1',
+	'PAGE_FILTER_TYPE'			=> 'Type',
+	'PAGE_FILTER_TYPE_EXPLAIN'	=> 'Select the type of location parameters.',
+	'PAGE_FORUM'				=> 'Pages inside the forum',
+	'PAGE_FORUM_EXPLAIN'		=> 'These are pages belonging to the forum to which you can add blocks. You can manage and edit their main parameters as in customized pages.',
+	'PAGE_GROUP'				=> 'Groups',
+	'PAGE_GROUP_EXPLAIN'		=> 'Choose groups who can see the blocks of this page.<br />You can select multiple groups using <em>Ctrl key</em> on your keyboard.',
+	'PAGE_HOME'					=> 'Home page',
+	'PAGE_HOME_EXPLAIN'			=> 'This is a page designed to be used as a site\'s home page as a "Portal".',
+	'PAGE_LINK'					=> 'Link',
+	'PAGE_LINK_ICON'			=> 'Link icon',
+	'PAGE_LINK_ICON_EXPLAIN'	=> 'Define the icon that will have the link to this page.',
+	'PAGE_LINK_POSITION'		=> 'Link position',
+	'PAGE_LINK_POSITION_EXPLAIN'	=> 'Define in which part of the forum a link to this page will appear.',
+	'PAGE_LOGO'					=> 'Logo',
+	'PAGE_LOGO_EXPLAIN'			=> 'Sets the url of the image to be used as logo.<br />Leave blank to use the default logo.',
+	'PAGE_STYLE'				=> 'Style',
+	'PAGE_STYLE_EXPLAIN'		=> 'Defines the style to be used on the page.<br /><em>This option will not be applied to the original pages of the forum.</em>',
+	'PAGE_STYLESHEET'			=> 'Custom theme',
+	'PAGE_STYLESHEET_EXPLAIN'	=> 'You can set the path to one or more files *.css (one per line) or directly set the variables of the theme that will be used.',
+	'PAGE_THEME'				=> 'Theme',
+	'PAGE_THEME_BACKGROUND'		=> 'Set background',
+	'PAGE_THEME_DEFAULT'		=> 'Use default configuration',
+	'PAGE_THEME_STYLE'			=> 'Set style',
+	'PAGE_THEME_STYLESHEET'		=> 'Use custom theme',
+	'PAGE_TITLE'				=> 'Page title',
+	'PAGE_TITLE_EXPLAIN'		=> 'Title will be displayed in the browser.',
+	'PAGE_URL'					=> 'Page url',
+	
+	'PAGES_ADD_TITLE'				=> 'Add new page',
+	'PAGES_ADD_TITLE_EXPLAIN'		=> 'From here you can add a new page and define custom configuration and appearance.',
+	'PAGES_BLOCKS_TITLE'			=> 'Manage blocks :: %s',
+	'PAGES_BLOCKS_TITLE_EXPLAIN'	=> 'From here you can create/edit/delete blocks to be shown on this page.<br />
+		The blocks can be divided into five columns (left, center, right, top and bottom). Drag the blocks to change their position.<br />
+		You can also add <strong>groups</strong> that will allow you to place blocks in up to 3 columns independently.',
+	'PAGES_EDIT_TITLE'				=> 'Edit page :: %s',
+	'PAGES_EDIT_TITLE_EXPLAIN'		=> 'From here you can edit the main configuration and look for the page.',
+	'PAGES_SELECT_TITLE_EXPLAIN'	=> 'Select the page to manage.',
+	'PAGES_TITLE'					=> 'Manage pages',
+	'PAGES_TITLE_EXPLAIN'			=> 'From here you can create/edit/delete additional pages for your forum. You can also edit the configuration and blocks on predefined pages.',
+	
+	'RIGHT_COLUMN'				=> 'Right column',
+	'RIGHT_COLUMN_EXPLAIN'		=> 'Width of the right column in pixels or percentage.<br />Set 0 to disable the column.',
+	'SHOW_FOOTER'				=> 'Show footer',
+	'SHOW_FOOTER_EXPLAIN'		=> 'This option lets you decide whether to display the forum footer on this page.',
+	'SHOW_HEADER'				=> 'Show header',
+	'SHOW_HEADER_EXPLAIN'		=> 'This option lets you decide whether to display the forum header on this page.',
+	'STYLE_DEFAULT'				=> 'Default style',
+	'STYLE_ALTERNATIVE'			=> 'Alternate style',
+	'STYLE_CONTENT_FULL'		=> 'Only content (with title)',
+	'STYLE_CONTENT_SIMPLE'		=> 'Only content (without title)',
+	'SUBMIT_CHANGES'			=> 'Apply changes',
+	'TARGET_PAGE_EXPLAIN'		=> 'Select the target page for the selected blocks.<br /><em>The blocks will be placed in it respective column</em>',
+	'TOP_COLUMN'				=> 'Top column',
+));
+
+// @general messages
+$lang = array_merge($lang, array(
+	'BLOCK_ADDED'					=> 'Block added successfully',
+	'BLOCK_COPIED'					=> 'Block(s) copied successfully',
+	'BLOCK_NEED_REQUIREMENTS'		=> 'The selected block will need some minimum requirements to be used.<br />See the documentation for more information.',
+	'BLOCK_MOVED'					=> 'Block(s) moved successfully',
+	'BLOCK_NOT_ADDED'				=> 'Error adding the block',
+	'BLOCK_NOT_EXISTS'				=> 'The selected block does not exist',
+	'BLOCK_NOT_UPDATED'				=> 'Error updating the block',
+	'BLOCK_POSITION_UPDATED'		=> 'Blocks position updated successfully',
+	'BLOCK_POSITION_NOT_UPDATED'	=> 'Error updating blocks position',
+	'BLOCK_REMOVED'					=> 'Block(s) removed successfully',
+	'BLOCK_UPDATED'					=> 'Block updated successfully',
+	'GROUPS_CHANGED'				=> 'Groups updated successfully',
+
+	'ITEM_REMOVED'				=> 'Element removed successfully',
+	'ITEM_UPDATED'				=> 'Element updated successfully',
+	'ITEM_ADDED'				=> 'Element added successfully',
+	'ITEM_NOT_ADDED'			=> 'Error adding the element',
+	'ITEM_NOT_UPDATED'			=> 'Error updating the element',
+
+	'PAGE_ADDED'				=> 'Page added successfully',
+
+	'PAGE_REMOVED'		=> array(
+		1	=> 'The page has been successfully removed',
+		2	=> '%d pages deleted successfully',
+	),
+
+	'PAGE_UPDATED'				=> 'Page configuration updated successfully',
+	'BLG_CONFIG_UPDATED'		=> 'Configuration updated successfully',
+
+	'CONFIRM_PAGE_DELETE'		=> 'Are you sure you wish to delete this page and all blocks in this?',
+));
+
+/**
+* Blocks names and explains from block_alias
+*/
+$lang = array_merge($lang, array(
+	'blocks'	=> array(
+		'announcements_title'		=> 'Announcements',
+		'announcements_explain'		=> 'Displays a set number of posts (announcements) of established forums.',
+		'attachments_title'			=> 'Attachments',
+		'attachments_explain'		=> 'Displays information and links to the specified attachments.',
+		'banners_title'				=> 'Banners',
+		'banners_explain'			=> 'Displays the specified list of banners. It\'s displayed in a fixed or scrolling form.',
+		'birthdays_title'			=> 'Birthdays',
+		'birthdays_explain'			=> 'Displays the list of birthdays for today and the next few days (optional).',
+		'empty_title'				=> 'Custom',
+		'empty_explain'				=> 'Totally blank block which can also include any text HTML, CSS, JavaScript, etc...',
+		'calendar_title'			=> 'Calendar',
+		'calendar_explain'			=> 'Calendar in which you can add custom events and show birthdays.',
+		'clock_title'				=> 'Clock',
+		'clock_explain'				=> 'Displays a clock in flash format (you can choose several models and add your own clock).',
+		'cloud_tag_title'			=> 'CloudTag',
+		'cloud_tag_explain'			=> 'Sample labels in a balloon in flash format. You can display the latest searched words or the users with more messages.',
+		'contact_title'				=> 'Contact',
+		'contact_explain'			=> 'Displays a standard contact form.',
+		'countdown_title'			=> 'CountDown',
+		'countdown_explain'			=> 'Show a countdown to the indicated date.',	
+		'counter_title'				=> 'Hit counter',
+		'counter_explain'			=> 'Displays a hit counter with statistics of visits, visits per day, visits per hour, weekly visits, visits per month and visits per year.',
+		'dockmenu_title'			=> 'Dock menu',
+		'dockmenu_explain'			=> 'Displays a menu with Mac Dock style with elements of the specified list.',
+		'forums_title'				=> 'Forums',
+		'forums_explain'			=> 'List with full or custom forums.',
+		'frame_title'				=> 'Frame',
+		'frame_explain'				=> 'Display a Web page, a PDF file, a Flash file or a text file within the block.', 
+		'gallery_title'				=> 'Photo gallery',
+		'gallery_explain'			=> 'Photo Gallery customizable with forum images (attachments) or external images. The images move and link the fate of each.',
+		'google_translate_title'	=> 'Google translator',
+		'google_translate_explain'	=> 'Block that allows you to translate the page on which it is installed, opening a new window and translating it through Google technology.',
+		'language_select_title'		=> 'Language select',
+		'language_select_explain'	=> 'It allows the user to view the forum with any language that is installed in the forum and set it as their default language.',
+		'latest_bots_title'			=> 'Bot\'s visits',
+		'latest_bots_explain'		=> 'Simple list of last bots who entered the forum and the date of their last visit.',
+		'latest_members_title'		=> 'Newest members',
+		'latest_members_explain'	=> 'List of latest sers registered on the forum and the date they were registered.',
+		'leaders_title'				=> 'Leaders',
+		'leaders_explain'			=> 'Displays a list of groups (customizable) with forum leaders.',
+		'link_us_title'				=> 'Link Us',
+		'link_us_explain'			=> 'Block that displays a user-selectable link to the page on which it is installed. You can set a mini banner attached to the link.',
+		'login_title'				=> 'Login',
+		'login_explain'				=> 'Allows a user to login directly from the block. Once identified, shows the user\'s primary information and links.',
+		'map_title'					=> 'Map',
+		'map_explain'				=> 'Displays a map that may contain marks with different locations.',
+		'menu_title'				=> 'Menu',
+		'menu_explain'				=> 'Menu in tree format that displays items from the selected list.',
+		'most_poster_title'			=> 'Most Posters',
+		'most_poster_explain'		=> 'Displays a dropdown with users who have posted more messages in the forum, and most relevant information.',
+		'news_title'				=> 'News',
+		'news_explain'				=> 'Dropdown menu showing the last posts of the specified forums as a news.',
+		'online_friends_title'		=> 'Friends online',
+		'online_friends_explain'	=> 'Simple list of friends and foes of the user, that are connected to the forum.',
+		'paypal_title'				=> 'Donations',
+		'paypal_explain'			=> 'Allows users to donate money through paypal.',
+		'player_title'				=> 'Music Player',
+		'player_explain'			=> 'Player to play songs in MP3 or WAV format. Allow to create a list of songs or use M3U, ASX or PLS playlists.',
+		'poll_title'				=> 'Poll',
+		'poll_explain'				=> 'Displays a single poll specified in its configuration.',
+		'poll_random_title'			=> 'Poll (random)',
+		'poll_random_explain'		=> 'Displays a selected number of polls that selected in random order, within the specified forum.',
+		'post_view_title'			=> 'Forum post',
+		'post_view_explain'			=> 'Displays the contents of a message. You can display the last message of a forum, the first or last post of a topic or a custom post.',
+		'quote_of_day_title'		=> 'Quote of day',
+		'quote_of_day_explain'		=> 'Shows a "quote" or phrase of the day or a different tip in each visit to the page.',
+		'random_member_title'		=> 'Random Member',
+		'random_member_explain'		=> 'Displays basic information and avatar of a random user.',
+		'ranks_title'				=> 'Ranks',
+		'ranks_explain'				=> 'Shows a list with the forum ranks.',
+		'recent_topics_title'		=> 'Recent Topics',
+		'recent_topics_explain'		=> 'Recent topics of the forum. Allow to select the forums from which to read the topics.',
+		'rss_title'					=> 'RSS Reader',
+		'rss_explain'				=> 'Show the latest articles from the specified RSS archives(feeds). Items will be displayed in scroll mode or accordion.', 
+		'share_title'				=> 'Share',
+		'share_explain'				=> 'Shows the buttons of most popular social networks in the desired format.',
+		'search_title'				=> 'Search',
+		'search_explain'			=> 'Allows users to do quickly searchs on the forum or in a search engine.',
+		'scroll_message_title'		=> 'Marquee',
+		'scroll_message_explain'	=> 'Text message that is rotating in the block. Allows use BBCode and HTML in the text.',
+		'stats_title'				=> 'Statistics',
+		'stats_explain'				=> 'Gets the most relevant information on the forum. This block shows the number of new messages and topics, the total number of posts and topics, message statistics and topics written per day, total number of attachments and the number of users that remaining active (posting messages).',
+		'style_select_title'		=> 'Style select',
+		'style_select_explain'		=> 'Allows the user to view the forum with any style that is installed on the forum and set it as their default style.',
+		'top_topics_title'			=> 'Top topics',
+		'top_topics_explain'		=> 'List of custom topics that can display the latest topics unread, the most active topics or the most viewed topics.',
+		'topic_index_title'			=> 'Topic Index',
+		'topic_index_explain'		=> 'Displays an orderly list with the topics of selected forums. The list can be order by topic title, topic date or topic last post date.',
+		'welcome_title'				=> 'Welcome',
+		'welcome_explain'			=> 'This block enables a different welcome message for guests and registered users. The block will decide which message display.',
+		'whos_online_title'			=> 'Who\'s online',
+		'whos_online_explain'		=> 'Displays the list of connected users (as is shown by default in the Index of the forum) and users who logged in last 24 hours.',
+		'youtube_title'				=> 'YouTube',
+		'youtube_explain'			=> 'Show videos or channels from youtube.',
+	)
+));
diff --git "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/acp_blocks.php" "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/acp_blocks.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/acp_blocks.php"
@@ -0,0 +1,478 @@
+<?php
+/*
+* acp_blocks.php [English [En]]
+*
+* @package cBB Blockgets
+* @version v2.0.2 12/01/2021
+*
+* @copyright (c) 2021 CaniDev
+* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+*/
+
+// @ignore
+if(!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if(empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+/**
+ * @acp_blockgets_pages
+*/
+$lang = array_merge($lang, array(
+	// Blocks global config
+	'BLOCK_COLLAPSE'			=> 'Allow collapse the block',
+	'BLOCK_COLLAPSE_EXPLAIN'	=> 'Enable or disable the ability for each user to collapse/expand this block and defines its initial state.',
+	'BLOCK_ENABLED'				=> 'Block enabled',
+	'BLOCK_ENABLED_EXPLAIN'		=> 'Defines whether this block display in the forum.',
+ 	'BLOCK_CURRENT_ICON'			=> 'Block icon',
+	'BLOCK_CURRENT_ICON_EXPLAIN'	=> 'Current icon set to the block.',
+	'BLOCK_GROUP'				=> 'Groups',
+	'BLOCK_GROUP_EXPLAIN'		=> 'Choose groups who may see this block in the forum.<br />You can select multiple groups using the <em>Ctrl</em> key on your keyboard.',
+	'BLOCK_NO_CONFIG'			=> 'This block does not require additional configuration',
+	'BLOCK_STYLE'				=> 'Look of the block',
+	'BLOCK_STYLE_EXPLAIN'		=> 'With this option you can choose the look of each block individually. Note that the way it is displayed depends on the style installed on the forum and its compatibility with the extension.',
+	'BLOCK_TITLE'				=> 'Block title',
+	'BLOCK_TITLE_EXPLAIN'		=> 'Unique name for your block.<br />This title will be shown in the block.<br />Limit: 100 characters.',
+
+	// Common tags
+	'ALL_FORUMS'				=> 'All forums',
+	'COLLAPSE_HIDDEN'			=> 'Allow (collapsed by default)',
+	'COLLAPSE_NONE'				=> 'Not Allow',
+	'COLLAPSE_VISIBLE'			=> 'Allow (displayed by default)',
+	'CONFIG'					=> 'Configuration',
+	'DESIGN_FULL'				=> 'Full',
+	'DESIGN_SIMPLE'				=> 'Simple',
+	'FORUMS'					=> 'Forums',
+	'FORUMS_EXPLAIN'			=> 'Forums that contain the topics to show. You can select as many as you like using the <em>Ctrl</em> key on your keyboard.',
+	'IGNORE_AUTH'				=> 'Ignore auth',
+	'IGNORE_AUTH_EXPLAIN'		=> 'If enabled, will be show all the content ignoring if the user have the permissions to view it.',
+	'NO_LISTS'					=> 'No avaliable lists',
+	'SHOW_PAGINATION'			=> 'Show pagination',
+	'SHOW_PAGINATION_EXPLAIN'	=> 'Show the pagination to allow user to view older posts.',
+	'TITLE_LIMIT'				=> 'Title limit',
+	'TITLE_LIMIT_EXPLAIN'		=> 'Maximum number of characters that will be displayed in the topic titles.<br />
+		<em>Set 0 to show the full title.</em>',
+	'TOPIC_DESIGN'				=> 'Block design',
+	'TOPIC_DESIGN_EXPLAIN'		=> 'Determine how the topics will be displayed in the block.<br />
+		<em><strong>Full:</strong> Show all information whenever possible.</em><br />
+		<em><strong>Simple:</strong> Show only basic information.</em>',
+	'TOPIC_PARENT_SHOW'			=> 'Show parent forum',
+	'TOPIC_PARENT_SHOW_EXPLAIN'	=> 'If enabled, a link to the forum for each topic will be displayed.',
+	
+	// age_ranges_block
+	'AGE_START'					=> 'Minimum age',
+	'AGE_END'					=> 'Maximum age',
+	'AGE_INTERVAL'				=> 'Interval',
+	
+	// announcements_block
+	'ANN_MAX_NUMBER'			=> 'Announcements number',
+	'ANN_MAX_NUMBER_EXPLAIN'	=> 'Maximum number of announcements that are displayed within the block.',
+	'ANN_MAX_SIZE'				=> 'Announcement size',
+	'ANN_MAX_SIZE_EXPLAIN'		=> 'Maximum size of characters allowed in announcements. The text is cut off if this value exceeds.',
+	'ANN_SHOW_GLOBALS'			=> 'Show global announcements',
+	'ANN_SHOW_GLOBALS_EXPLAIN'	=> 'If enabled, you also read the items marked as "global", otherwise only read simple announcements.',
+	'ANN_COLLAPSE'				=> 'Collapse announcements',
+	'ANN_COLLAPSE_EXPLAIN'		=> 'If enabled, the block only show one announcement and collapse the rest. Otherwise, the announcements will appear all at once on the block.',
+	
+	// attachments_block
+	'ATTACH_FORUM'				=> 'Forum attachments',
+	'ATTACH_FORUM_EXPLAIN'		=> 'If specified, only display attachments from this forum ignoring the rest.<br />The forum should be directly containing the topic where the attachment, the above categories or forums are ignored here.',
+	'ATTACH_EXTENSION'			=> 'Attachment extensions',
+	'ATTACH_EXTENSION_EXPLAIN'	=> 'If specified, all attachments which do not contain this extensions will be ignored.<br />Split the extensions with ",".<<br />Ex. valid extensions: jpg,png,gif...',
+	'ATTACH_NUM'				=> 'Attachment number',
+	'ATTACH_NUM_EXPLAIN'		=> 'Maximum number of attachments that are displayed simultaneously in the block.',
+	'ATTACH_SPECIFIC'			=> 'Specific attachment',
+	'ATTACH_SPECIFIC_EXPLAIN'	=> 'If specified, only attachment with the specified name will be show in the block. The field must contain the original filename of the attachment, Ex: myfile.jpg<br /><br /><strong>Note:</strong> this field overrides the other fields.',
+
+	// banners_block, banners_multiple_block
+	'BANNERS_TITLE'				=> 'Banner title',
+	'BANNERS_TITLE_EXPLAIN'		=> 'If enabled, the title will be appear below the banners in the block.',
+	'BANNERS_LS_TYPE'			=> 'List type',
+	'BANNERS_LS_TYPE_EXPLAIN'	=> 'Define how to display the banners.<br />Can be set a horizontal, vertical scroll or remain fixed.',
+	'BANNERS_NUMBER'			=> 'Banners to show',
+	'BANNERS_NUMBER_EXPLAIN'	=> 'Maximum number of banners to display on the block.<br />
+		<em>Set 0 to show all the list.</em>',
+	'BANNERS_RANDOM'			=> 'Random order',
+	'BANNERS_RANDOM_EXPLAIN'	=> 'Set if the elements will be show in the list order or in a random order.',
+	'LIST_NO_SCROLL'			=> 'No Scroll',
+	'LIST_SCROLL_H'				=> 'Horizontal scroll',
+	'LIST_SCROLL_V'				=> 'Vertical scroll',
+	'BANNERS_B_HEIGHT'			=> 'Block height',
+	'BANNERS_B_HEIGHT_EXPLAIN'	=> 'Enter the height of the block that will be used to scroll lists.',
+
+	// birthdays_block
+ 	'NEXT_BIRTHDAYS'			=> 'Upcoming Birthdays',
+ 	'NEXT_BIRTHDAYS_EXPLAIN'	=> 'Show birthdays that occur in the coming days.<br />
+ 		<em>Maximum 30 days. Set to 0 to disable it.</em>',
+
+	// calendar_block
+ 	'CALENDAR_BIRTHDAYS'			=> 'Show Birthdays',
+ 	'CALENDAR_BIRTHDAYS_EXPLAIN'	=> 'If enabled, the users birthdays are marked and displayed in the calendar, like events.',
+ 	'CALENDAR_EVENTS'				=> 'Show events',
+ 	'CALENDAR_EVENTS_EXPLAIN'		=> 'If enabled, events are marked and displayed in the calendar.',
+ 	'CALENDAR_MONTHS'				=> 'Months to show',
+ 	'CALENDAR_MONTHS_EXPLAIN'		=> 'Number of months to be displayed simultaneously on the block.',
+
+	// contact block
+	'CONTACT_CHECK_EMAIL'			=> 'Check email',
+	'CONTACT_CHECK_EMAIL_EXPLAIN'	=> 'If enabled, the domain of the user email will be checked and validated.',
+	'CONTACT_EMAIL'					=> 'Target email',
+	'CONTACT_HIDE_FIELDS'			=> 'Hide user data',
+	'CONTACT_HIDE_FIELDS_EXPLAIN'	=> 'If enabled, the "Name" and "Email" fields for the register users will be hidden and the block will be used their profile values.',
+ 
+	// countdown block
+	'COUNTDOWN_COMPLETE_MSG'			=> 'Text upon completion',
+	'COUNTDOWN_COMPLETE_MSG_EXPLAIN'	=> 'Text to be displayed when the counter reaches 0.',
+	'COUNTDOWN_TARGET'					=> 'Deadline',
+	'COUNTDOWN_TARGET_EXPLAIN'			=> 'Set the date and time the counter will reach 0.<br /><br />
+		<em><strong>Valid formats</strong>
+			<br />Year/Month/Day
+			<br />Year/Month/Day Hour:Minute:Second
+		</em>',
+	'COUNTDOWN_RUNNING_MSG'				=> 'Hold text',
+	'COUNTDOWN_RUNNING_MSG_EXPLAIN'		=> 'Text to be displayed while the counter is running.',
+
+	// counter block
+	'COUNTER_LOCAL'				=> 'Local counter',
+	'COUNTER_LOCAL_EXPLAIN'		=> 'If enabled, the counter only show the visits to it\'s page, otherwise, the counter show the total visits to the forum.',
+
+	// empty_block
+	'BLOCK_CONTENT'				=> 'Block content',
+	'BLOCK_CONTENT_EXPLAIN'		=> 'Content to display on the block.<br />Limit: 8000 characters.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+
+	// clock_block
+	'DISPLAY_CLOCK'				=> 'Clock to show',
+	'DISPLAY_CLOCK_EXPLAIN'		=> 'Clock displayed on the block.',
+	'PREVIEW_CLOCK'				=> 'Preview',
+	'PREVIEW_CLOCK_EXPLAIN'		=> 'Selected clock preview.',
+
+	// cloud_tags_block
+	'CLOUD_ANIMATION'			=> 'Animation enabled',
+	'CLOUD_ANIMATION_EXPLAIN'	=> 'If enabled, the words "tags" appear in an animated cloud tag, otherwise, they appear as fixed words in block.',
+	'CLOUD_MODE'				=> 'Words type',
+	'CLOUD_MODE_EXPLAIN'		=> 'Specifies that words will be shown in block.',
+	'CLOUD_WORDS'				=> 'Words number',
+	'CLOUD_WORDS_EXPLAIN'		=> 'Maximum number of words that appear in the block.',
+	'MODE_SEARCH'				=> 'Last searched words',
+	'MODE_USERS'				=> 'Users with most posts',
+	
+	// forums block
+	'FORUMS_FORUM'		=> 'Forum to show',
+	
+	// frame_block
+	'MIME_HTML'			=> 'Web page',
+	'MIME_PDF'			=> 'PDF file',
+	'MIME_PLAIN'		=> 'Plain Text file',
+
+	'FRAME_HEIGHT'				=> 'Frame height',
+	'FRAME_HEIGHT_EXPLAIN'		=> 'Frame height in pixels. Set to 0 to auto adjust.',
+	'FRAME_MIMETYPE'			=> 'Document type',
+	'FRAME_MIMETYPE_EXPLAIN'	=> 'The document type displayed in the frame.',
+	'FRAME_URL'					=> 'Document URL',
+	'FRAME_URL_EXPLAIN'			=> 'URL of the document or page displayed in the frame.',
+	'FRAME_WIDTH'				=> 'Frame width',
+	'FRAME_WIDTH_EXPLAIN'		=> 'Frame width in pixels. Set to 0 to auto adjust.',
+	
+	// gallery_block
+	'GALLERY_CUSTOM'				=> 'Custom images',
+	'GALLERY_CUSTOM_EXPLAIN'		=> 'Specify the list containing the images to be displayed.',
+	'GALLERY_DIRECTION'				=> 'Scroll direction',
+	'GALLERY_FORUMS'				=> 'Forums',
+	'GALLERY_FORUMS_EXPLAIN'		=> 'Defines the forums to read the attachments.',
+	'GALLERY_FPS'					=> 'Scroll speed',
+	'GALLERY_HEIGHT'				=> 'Gallery height',
+	'GALLERY_MANAGE'				=> 'Manage gallery',
+	'GALLERY_MARGIN'				=> 'Image margin',
+	'GALLERY_MAX_NUMBER'			=> 'Number of images',
+	'GALLERY_MAX_NUMBER_EXPLAIN'	=> 'Maximum attachments that will be read from the forums/topics/posts',
+	'GALLERY_POSTS'					=> 'Posts',
+	'GALLERY_POSTS_EXPLAIN'			=> 'Posts IDs to read the attachments, splitted with commas. (Ex: 1,2,3).',
+	'GALLERY_SOURCE'				=> 'Origin of the images',
+	'GALLERY_SOURCE_EXPLAIN'		=> 'Define what type of images will be loaded from the forums, topics or messages specified.',
+	'GALLERY_TOPICS'				=> 'Topics',
+	'GALLERY_TOPICS_EXPLAIN'		=> 'Topics IDs to read the attachments, splitted with commas. (Ex: 1,2,3).',
+	'GALLERY_ZOOM'					=> 'Zoom',
+	'GALLERY_ZOOM_EXPLAIN'			=> 'Size difference on image\'s mouse over (in pixels)',
+	
+	'GALLERY_SOURCE_ALL'			=> 'All',
+	'GALLERY_SOURCE_ATTACHMENTS'	=> 'Only attachments',
+	'GALLERY_SOURCE_IMAGES'			=> 'Only embedded images',
+	
+	'IMG_TITLE'			=> 'Image title',
+	'IMG_URL'			=> 'Image url',
+	'IMG_URL_EXPLAIN'	=> 'Url of an JPG, GIF or PNG image. Ej:http://mydomain.com/image.jpg',
+	
+	// google_translate_block
+	'GOOGLE_LANGS'		=> 'Languages to show in the block',
+	'GOOGLE_SHOW_NAMES'			=> 'Show names',
+	'GOOGLE_SHOW_NAMES_EXPLAIN'	=> 'If enabled, the language name will be displayed next to its flag.',
+	
+	// latest_bots_block
+	'BOTS_NUMBER'				=> 'Bots to show',
+	'BOTS_NUMBER_EXPLAIN'		=> 'Maximum number of last visit bots that will be shown in the block.',
+
+	// latest_members_block
+	'MEMBERS_NUMBER'			=> 'Users to show',
+	'MEMBERS_NUMBER_EXPLAIN'	=> 'Maximum number of users that will be shown in block.',
+	
+	// leaders_block
+	'LEADERS_ALL_GROUPS'			=> 'Show users in all their groups',
+	'LEADERS_ALL_GROUPS_EXPLAIN'	=> 'If enabled, users will be shown in all groups of which they are members.
+		Otherwise they will only be shown in their default group.',
+	'LEADERS_GROUPS'				=> 'Groups',
+	'LEADERS_GROUPS_EXPLAIN'		=> 'Groups that will be show in the block. If you don\'t select groups, the block will be show the Administrators and Moderators.',
+	'LEADERS_MODE'					=> 'Display mode',
+	'LEADERS_MODE_ACCORDION'		=> 'Accordion',
+	'LEADERS_MODE_SIMPLE'			=> 'Simple List',
+	'LEADERS_ONLY_ONLINE'			=> 'Online users only',
+	'LEADERS_ONLY_ONLINE_EXPLAIN'	=> 'If enabled, only users from selected groups who are logged in will be displayed.',
+
+	// link_us_block
+	'US_BANNER'					=> 'Mini banner link',
+	'US_BANNER_EXPLAIN'			=> 'Mini banner that will be the image that you have to click to access the forum from the link.',
+
+	// Login Block
+ 	'FULL_LOGIN'				=> 'Show Full login',
+ 	'FULL_LOGIN_EXPLAIN'		=> 'Enable/disable the advanced options in the user identification.',
+ 	'SHOW_REGISTER'				=> 'Show register',
+ 	'SHOW_REGISTER_EXPLAIN'		=> 'Display option for the user registration.',
+	
+	// map_block
+	'LATITUDE'					=> 'Latitude',
+	'LONGITUDE'					=> 'Longitude',
+	'LOCATION_ADD'				=> 'Add location',
+	'LOCATION_EDIT'				=> 'Edit location',
+	'LOCATION_IMAGE'			=> 'Image',
+	'LOCATION_IMAGE_EXPLAIN'	=> 'Image that will mark the point on the map.<br /><em>If you do not define any, the default mark will be used</em>.',
+	'LOCATION_INCORRECT'		=> 'he position entered is incorrect.',
+	'LOCATION_POSITION'			=> 'Position',
+	'LOCATION_POSITION_EXPLAIN'	=> 'Defines the latitude and longitude of the location.',
+	'LOCATION_TEXT'				=> 'Content',
+	'LOCATION_TEXT_EXPLAIN'		=> 'Text to be displayed on the map, by clicking on the location icon.<br /><em>BBcode is allowed.</em>',
+	'LOCATION_TITLE'			=> 'Title',
+	'MAP'						=> 'Map',
+	'MAP_CENTER'				=> 'Central point',
+	'MAP_CENTER_EXPLAIN'		=> 'Defines the latitude and longitude of the default center point.',
+	'MAP_LOCATIONS'				=> 'Locations',
+	'MAP_ZOOM'					=> 'Zoom',
+	'MAP_ZOOM_EXPLAIN'			=> 'Set the default zoom.',
+	'SEARCH_ADDRESS'			=> 'Search location',
+	'SELECT_LOCATION'			=> 'Select location',
+
+	// menu_block
+	'DISPLAY_MENU'				=> 'Menu to show',
+	'DISPLAY_MENU_EXPLAIN'		=> 'Menu to be displayed in the block. The menu must be previously created in the correct section to be reflected here.',
+ 	'ICON_WIDTH'				=> 'Icon width',
+ 	'ICON_WIDTH_EXPLAIN'		=> 'The width of the block icons, in pixels.',
+
+	// most_poster_block
+	'POSTER_LIMIT'				=> 'User Limit',
+	'POSTER_LIMIT_EXPLAIN'		=> 'The limit of users that are displayed on the block.',
+ 	'POST_RANGE'				=> 'Message range',
+ 	'POST_RANGE_EXPLAIN'		=> 'Time limit for the message count.',
+ 
+ 	'ALL_POSTS'			=> 'All messages',
+ 	'LAST_DAY'			=> 'Last day',
+ 	'LAST_WEEK'			=> 'Last week',
+ 	'LAST_MONTH'		=> 'Last month',
+ 	'LAST_YEAR'			=> 'Last year',
+
+	// news_block
+	'NEWS_DISPLAY'				=> 'Information to show',
+	'NEWS_DISPLAY_EXPLAIN'		=> '<em><strong>Basic content:</strong>Show title, author and date.<br />
+		<strong>Full content:</strong>Show all news information.</em>',
+	'NEWS_NUMBER'				=> 'News number',
+	'NEWS_NUMBER_EXPLAIN'		=> 'Maximum number of news items displayed in the block.',
+	'NEWS_SIZE'					=> 'News size',
+	'NEWS_SIZE_EXPLAIN'			=> 'Maximum size of characters allowed in the news. The text of the news will be cut if this value exceeds.',
+	'NEWS_ALL'					=> 'Show all topics',
+	'NEWS_ALL_EXPLAIN'			=> 'If enabled, you also read the items marked as "announcement" and "fixed", otherwise, only read the "normal" topics.',
+	'NEWS_COLLAPSE'				=> 'Collapse news',
+	'NEWS_COLLAPSE_EXPLAIN'		=> 'If enabled, the block only show one notice and collapse the rest. Otherwise, the news will appear all at once on the block.',
+	'NEWS_SHOW_FULL'			=> 'Complete content',
+	'NEWS_SHOW_SIMPLE'			=> 'Basic content',
+	
+	// paypal_block
+	'PAYPAL_ACCOUNT'			=> 'Paypal account',
+	'PAYPAL_ACCOUNT_EXPLAIN'	=> 'Enter the e-mail address of your Paypal account ex: xxx@xxx.com',
+	'PAYPAL_ITEM'				=> 'Payment description',
+	'PAYPAL_ITEM_EXPLAIN'		=> 'Enter the name (description) to which payments will be identified through the block.',
+	'PAYPAL_MSG'				=> 'Message',
+	'PAYPAL_MSG_EXPLAIN'		=> 'Customizable message that will appear in the block.<br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+	'PAYPAL_IMG'				=> 'Button Image',
+ 	'PAYPAL_IMG_EXPLAIN'		=> 'Image to be used for the "donate" button. Leave this field blank to use the default image.', 
+	'PAYPAL_AMOUNTS'			=> 'Amounts',
+	'PAYPAL_AMOUNTS_EXPLAIN'	=> 'Money amount in the select. Split the values with ";" (Ex: 5;10;15).',
+	'PAYPAL_CURRENCIES'			=> 'Currencies',
+	'PAYPAL_CURRENCIES_EXPLAIN'	=> 'Type of currency that will be show in the block. You can select more that one and select the default currency.',
+	
+	//player block
+	'PLAYER_AUTOPLAY'			=> 'Autoplay',
+	'PLAYER_AUTOPLAY_EXPLAIN'	=> 'Defines whether the player will automatically start playing the tracks when the page loads.<br /><br />
+		<em><strong>Note:</strong>Browsers limit this feature so playback will not begin until the user clicks anywhere on the page.</em>',
+	'PLAYER_PLAYLIST'			=> 'Show playlist',
+	'PLAYER_PLAYLIST_EXPLAIN'	=> 'Defines if the playlist is displayed in the player.',
+	'PLAYER_TRACKLIST'			=> 'Tracklist',
+	'PLAYER_TRACKLIST_EXPLAIN'	=> 'The player tracks or songs.',
+
+	'TRACK_TITLE'			=> 'Track title',
+	'TRACK_TITLE_EXPLAIN'	=> 'the name or title displayed in the player.',
+	'TRACK_URL'				=> 'Track URL',
+	'TRACK_URL_EXPLAIN'		=> 'A radio URL (Ex: http://127.0.0.1:8888), a mp3 or wav audio file (Ex: http://myserver.com/audio.mp3) or a valid playlist file (m3u, asx, pls).',
+
+	// poll_block
+	'DISPLAY_POLL'				=> 'Poll to show',
+	'DISPLAY_POLL_EXPLAIN'		=> 'Poll displayed in the block.',
+	'DISPLAY_RESULTS'			=> 'Show results',
+	'NO_POLLS'					=> 'No polls available',
+
+	// poll_random_block
+	'POLL_FORUM'				=> 'Poll forum',
+	'POLL_FORUM_EXPLAIN'		=> 'Forum containing the polls that show on the block.',
+	'POLL_NUM'					=> 'Poll number',
+	'POLL_NUM_EXPLAIN'			=> 'The number of polls that will be displayed at once within the block.',
+	'NO_FORUMS'					=> 'No forums avaliable',
+	
+	// post_view_block
+	'PV_ITEM_URL'			=> 'Referral URL',
+	'PV_ITEM_URL_EXPLAIN'	=> 'Specify here the URL of the forum, topic or message you want to display.<br />
+		<em><strong>Note:</strong> The url of a forum or topic will display it\'s last message.</em>',
+	
+	// quote_of_day_block
+	'QUOTE_AUTHOR'				=> 'Quote author',
+	'QUOTE_TEXT'				=> 'Quote Text',
+	'QUOTES_ALL_DAY'			=> 'Keep all day',
+	'QUOTES_ALL_DAY_EXPLAIN'	=> 'If enabled, you will see the same quote all day. Otherwise, every time the page loads you will see a different quote.',
+	'QUOTES_LIST'				=> 'Quote list',
+	'QUOTES_RAND'				=> 'Random order',
+	'QUOTES_RAND_EXPLAIN'		=> 'Defines if the quotes are displayed in random order or maintaining the order of the list.',
+	'QUOTES_SHOW_AUTHOR'		=> 'Show author',
+	'QUOTES_SHOW_AUTHOR_EXPLAIN'	=> 'Defines whether to display the author of the quote on the block.',
+	
+	// ranks_block
+	'ORPHAN_RANKS'				=> 'Show orphan ranks',
+	'ORPHAN_RANKS_EXPLAIN'		=> 'If enabled, will show the ranges are not assigned to any user.',
+	'ONLY_SPECIAL_RANKS'		=> 'Only special ranks',
+	
+	// recent_topics_block
+	'RECENT_FORUMS'					=> 'Topic forums',
+	'RECENT_FORUMS_EXPLAIN'			=> 'Forums containing items to be displayed. If you do not select any, it will use all the forums. You can select as many as you like using the <em>Ctrl</em> key on your keyboard.',
+	'RECENT_SECTIONS'				=> 'Sections',
+	'RECENT_SECTIONS_EXPLAIN'		=> 'Define the sections to be displayed in the block and their order.',
+	'RECENT_TOPIC_LIMIT'			=> 'Topic limit',
+	'RECENT_TOPIC_LIMIT_EXPLAIN'	=> 'Maximum number of items to be displayed in each tab.',
+
+	// Rss block
+	'1_HOUR'		=> 'One hour',
+	'2_HOURS'		=> 'Two hours',
+	'6_HOURS'		=> 'Siz hours',
+	
+	'RSS_COLLAPSABLE'			=> 'Collapsable',
+	'RSS_COLLAPSABLE_EXPLAIN'	=> 'Sets whether the items are displayed in an accordion or scrolling. If set to "Yes" will override the block scroll.',
+	'RSS_DIRECTION'				=> 'Scroll direction',
+	'RSS_DIRECTION_EXPLAIN'		=> 'Defining the direction of scrolling text. This option is canceled if the items are displayed in an accordion.',
+	'RSS_HEIGHT'				=> 'Block height',
+	'RSS_HEIGHT_EXPLAIN'		=> 'Sets the height of the block, in pixels. Only apply if items are not displayed in accordion format.',
+	'RSS_IGNORE_LANG'			=> 'Ignore feed lang',
+	'RSS_IGNORE_LANG_EXPLAIN'	=> 'If enabled, all URLs are read, regardless of their language, otherwise it will only display the contents written in the language of the user.',
+	'RSS_LIMIT'					=> 'Feed limit',
+	'RSS_LIMIT_EXPLAIN'			=> 'Maximum number of items to be read from each URL.',
+	'RSS_SOURCES'				=> 'Feed sources',
+	'RSS_TITLE'					=> 'Feed title',
+	'RSS_TTL'					=> 'Refresh time',
+	'RSS_TTL_EXPLAIN'			=> 'Time will remain cached items before attempting to read the source again.',
+	'RSS_URL'					=> 'File url',
+	'RSS_URL_EXPLAIN'			=> 'Ex: <em>http://midominio.com/rss.xml</em>',
+
+	// scroll_message_block
+	'MARQUEE_DIRECTION'				=> 'Scroll direction',
+	'MARQUEE_DIRECTION_EXPLAIN'		=> 'Scroll direction for the text. This attribute controls the direction of scrolling.',
+	'MARQUEE_SPEED'					=> 'Scroll amount',
+	'MARQUEE_SPEED_EXPLAIN'			=> 'This controls the amount of movement (in pixels) between the successive displays that give the impression of animation.',
+	'MARQUEE_SCROLLDELAY'			=> 'Scroll delay',
+	'MARQUEE_SCROLLDELAY_EXPLAIN'	=> 'This controls the delay (in milliseconds) between the successive displays that give the impression of animation.',
+	'MARQUEE_ALIGN'					=> 'Scroll align',
+	'MARQUEE_ALIGN_EXPLAIN'			=> 'This tag controls the positioning of the marquee display box relative to the current text in exactly the same manner as the img tag\'s align attribute.',
+	'MARQUEE_BGCOLOR'				=> 'Scroll bgcolor',
+	'MARQUEE_BGCOLOR_EXPLAIN'		=> 'This tag controls the background colour of the display box.',
+	'MARQUEE_HEIGHT'				=> 'Scroll height',
+	'MARQUEE_HEIGHT_EXPLAIN'		=> 'This controls the height of the display box.',
+	'MARQUEE_PADDING'				=> 'ScrollBox Padding',
+	'MARQUEE_PADDING_EXPLAIN'		=> 'Space around the scroll box. This attribute is equivalent to the attribute "padding" of CSS.',
+	'MARQUEE_TEXT'					=> 'Scroll message text',
+	'MARQUEE_TEXT_EXPLAIN'			=> 'Add/change a scrollable message here. Limit 2000 characters.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+
+	'BOTTOM'		=> 'Bottom',
+	'DOWN'			=> 'Down',
+	'LEFT'			=> 'Left',
+	'CENTER'		=> 'Center',
+	'UP'			=> 'Up',
+	'RIGHT'			=> 'Right',
+	'TOP'			=> 'Top',
+	
+	//share_block
+	'SHARE_SHOW_NAMES'			=> 'Show names',
+	'SHARE_SHOW_NAMES_EXPLAIN'	=> 'If enabled, the name of the social network will be displayed next to its icon.',
+	'SHARE_URL'					=> 'Reference URL',
+	'SHARE_URL_EXPLAIN'			=> 'Set a fixed reference url for the buttons. Leave this field blank to use the displayed page.',
+	'SHARE_BUTTONS'				=> 'Buttons to show',
+	
+	// stats_block
+	'STATS_INLINE'			=> 'Show data in line',
+ 	'USER_STATS'			=> 'Display user statistics',
+	
+	// top_topics_block
+	'TOPT_LIMIT'			=> 'Topic limit',
+	'TOPT_LIMIT_EXPLAIN'	=> 'Maximun number of topic to show.',
+	'TOPT_MODE'				=> 'Topic to show',
+	'TOPT_MODE_ACTIVE'		=> 'Latest topics more active',
+	'TOPT_MODE_UNREAD'		=> 'Latest unread topics',
+	'TOPT_MODE_VIEWED'		=> 'More viewed topics',
+
+	// topic_index_block
+	'TINDEX_CHAR_SELECT'			=> 'Show Index',
+	'TINDEX_CHAR_SELECT_EXPLAIN'	=> 'Only avaliable if the sort method is <em>Topic title</em>.',
+	'TINDEX_PER_PAGE'			=> 'Topics per page',
+	'TINDEX_PER_PAGE_EXPLAIN'	=> 'Number of topics that will be show at the same time. Set 0 to disable pagination.',
+	'TINDEX_SORT_MODE'			=> 'Order by',
+	'TINDEX_SORT_MODE_EXPLAIN'	=> 'Method that will be used to set the topic\'s order in the list.',
+  
+	'TOPIC_TIME'		=> 'Topic date',
+	'LAST_POST_TIME'	=> 'Last post date',
+
+	// welcome_block
+	'WELCOME_GUEST'				=> 'Guests message',
+	'WELCOME_GUEST_EXPLAIN'		=> 'Message to display to all guests. 2000 characters max.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+	'WELCOME_MEMBER'			=> 'Members message',
+	'WELCOME_MEMBER_EXPLAIN'	=> 'Message to display to all the forum registered users. 2000 characters max.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
+
+	// whos_online_block
+	'WHOS_ADVANCED'				=> 'Advanced mode',
+	'WHOS_ADVANCED_EXPLAIN'		=> 'If enabled, will display all the information, otherwise it will appear only basic information (suitable for side blocks).',
+	'WHOS_USERNAMES'			=> 'Show user list',
+	'WHOS_USERNAMES_EXPLAIN'	=> 'If enabled, displays the list of users online (only in advanced mode).',
+
+	// youtube_block
+	'YT_AUTOPLAY'				=> 'AutoPlay enabled',
+	'YT_AUTOPLAY_EXPLAIN'		=> 'If enabled, the video will play automatically.<br />If you have multiple videos, only the first autoplay.',
+	'YT_DISPLAY_MODE'			=> 'Display Mode',
+	'YT_FULL_PREVIEW'			=> 'Show thumbnails, title and description',
+	'YT_LIST'					=> 'Show a list with titles',
+	'YT_RANDOM_DISPLAY'			=> 'Random Display',
+	'YT_RANDOM_DISPLAY_EXPLAIN'	=> 'If enabled, only one video will be appear randomly. Otherwise, all the videos and channels appear at once.',
+	'YT_RESULT_LIMIT'			=> 'Number of channel videos',
+	'YT_RESULT_LIMIT_EXPLAIN'	=> 'Maximun number of videos loaded in each channel.',
+	'YT_SIMPLE_PREVIEW'			=> 'Show thumbnails and titles',
+	'YT_TEXT_LIMIT'				=> 'Text limit',
+	'YT_TEXT_LIMIT_EXPLAIN'		=> 'Maximun number of characters in the video description.',
+	'YT_VIDEO_PREVIEW'			=> 'Show video preview',
+	'YT_VIDEO_SIZE'				=> 'Player size',
+	'YT_VIDEO_TITLE'			=> 'Video title',
+	'YT_VIDEO_URL'				=> 'Video url',
+	'YT_VIDEO_URL_EXPLAIN'		=> 'Ex: <em>https://www.youtube.com/watch?v=NHH_v0k7Gus</em>',
+));
diff --git "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/chat_addon.php" "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/chat_addon.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/chat_addon.php"
@@ -0,0 +1,32 @@
+<?php
+/** 
+* chat_addon.php [English [En]]
+*
+* @package language cBB Blockgets
+* @version v2.0.1 04/05/2018
+*
+* @copyright (c) 2018 CaniDev
+* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+*/
+
+// @ignore
+if(!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if(empty($lang['blocks']))
+{
+	$lang['blocks'] = array();
+}
+
+$lang['blocks'] = array_merge($lang['blocks'], array(
+	'chat_title'	=> 'Chat',
+	'chat_explain'	=> 'Allows you to use cBB Chat as a block in the columns or show the users connected to the chat.',
+));
+
+$lang = array_merge($lang, array(
+	'CHAT_ADDON_MODE'		=> 'Display mode',
+	'CHAT_MODE_CHAT'		=> 'Chat room',
+	'CHAT_MODE_USERS'		=> 'Online Users',
+));
diff --git "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/email/contact_block.txt" "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/email/contact_block.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/email/contact_block.txt"
@@ -0,0 +1,6 @@
+
+The following is an e-mail sent to you from "{SITENAME}" for {FROM_USERNAME} by the contact form:
+
+----------
+
+{MESSAGE}
diff --git "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/info_acp_blockgets.php" "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/info_acp_blockgets.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/info_acp_blockgets.php"
@@ -0,0 +1,53 @@
+<?php
+/*
+* info_acp_blockgets.php [English [En]]
+* @package cBB Blockgets
+* @version v2.0.2 12/01/2021
+*
+* @copyright (c) 2021 CaniDev
+* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+*/
+
+// @ignore
+if(!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+/**
+ * @general tags and messages
+*/
+$lang = array_merge($lang, array(
+	'ACP_BLOCKGETS'				=> 'Blockgets',
+	'ACP_BLOCKGETS_GENERAL'		=> 'General',
+	
+	'ACP_BLG_CONFIG_MAIN'		=> 'General configuration',
+	'ACP_BLG_CONFIG_OPTIONAL'	=> 'Additional configuration',
+	'ACP_BLG_IMAGES'			=> 'Images',
+	'ACP_PAGES_AND_BLOCKS'		=> 'Pages and Blocks',
+	
+	// Logs
+	'LOG_BLG_CONFIG'		=> '<strong>cBB Blockgets:</strong> Changed main configuration',
+	'LOG_BLOCK_ADDED'		=> '<strong>cBB Blockgets:</strong> New block added<br />» %1$s in %2$s',
+	'LOG_BLOCK_COPY_PAGE'	=> '<strong>cBB Blockgets:</strong> Blocks copied<br />» de %1$s a %2$s',
+	'LOG_BLOCK_MOVED'		=> '<strong>cBB Blockgets:</strong> Changed blocks position<br />» %1$s',
+	'LOG_BLOCK_MOVED_PAGE'	=> '<strong>cBB Blockgets:</strong> Blocks moved<br />» from %1$s to %2$s',
+	'LOG_BLOCK_REMOVED'		=> '<strong>cBB Blockgets:</strong> Block(s) deleted<br />» en %1$s',
+	'LOG_BLOCK_UPDATED'		=> '<strong>cBB Blockgets:</strong> Block edited<br />» %1$s en %2$s',
+	'LOG_EVENT_REMOVED'		=> '<strong>cBB Blockgets:</strong> Event deleted<br />» %1$s',
+	'LOG_LIST_REMOVED'		=> '<strong>cBB Blockgets:</strong> List deleted<br />» %1$s',
+	'LOG_PAGE_ADDED'		=> '<strong>cBB Blockgets:</strong> New page added<br />» %1$s',
+	'LOG_PAGE_UPDATED'		=> '<strong>cBB Blockgets:</strong> Changed page<br />» %1$s',
+	'LOG_PAGE_REMOVED'		=> '<strong>cBB Blockgets:</strong> Page deleted<br />» %1$s',
+	
+	// Permissions
+	'ACL_A_BLOCKGETS_MANAGE'	=> 'Can manage cBB Blockgets',
+	'ACL_U_BLOCKGETS_BIRTHDAYS'	=> 'Can see birthdays in the Calendar',
+	'ACL_U_BLOCKGETS_CALENDAR'	=> 'Can view calendar',
+	'ACL_U_BLOCKGETS_EVENTS'	=> 'Can manage calendar events',
+));
diff --git "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/installer.php" "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/installer.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/installer.php"
@@ -0,0 +1,43 @@
+<?php
+/*
+* installer.php [English [En]]
+* @package cBB Blockgets
+* @version v2.0.2 12/01/2021
+*
+* @copyright (c) 2021 CaniDev
+* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+*/
+
+// @ignore
+if(!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if(empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+// Local Variables
+$lang = array_merge($lang, array(
+	'PORTAL'			=> 'Portal',
+	'DOCK_MENU'			=> 'Dock menu',
+	'MAIN_MENU'			=> 'Main Menu',
+	'RECOMMENDED'		=> 'Recommended',
+
+	'P_ADMIN'			=> 'Administration',
+	'P_MAIN'			=> 'Main',
+	'P_MCP'				=> 'Moderation Panel',
+	'P_ACP'				=> 'Administration Panel',
+
+	'PHPBB_TITLE'		=> 'phpBB official website',
+	'XAMPP_TITLE'		=> 'Xampp',
+	'SOURCEFORGE_TITLE'	=> 'Open source applications',
+
+	'WELCOME_GUEST'		=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Forum equipped with cBB Blockgets</i><br /><br />Welcome to our forum!<br />Register to access all the content!.</strong></div>[/html]',
+	'WELCOME_MEMBER'	=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Forum equipped with cBB Blockgets</i><br /><br />Welcome back to our forum {S_USERNAME}</strong></div>[/html]',	
+
+	'CORE_INSTALL_ERROR'	=> 'You have not uploaded all the files from the installation package or you are trying to install an old package.<br />
+		Please make sure to upload all the files (including the <em>core</em> folder) and use a package downloaded from the official website.',
+));
diff --git "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/main.php" "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/main.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\blockgets/language/pt_preao/main.php"
@@ -0,0 +1,269 @@
+<?php
+/*
+* main.php [English [En]]
+* @package cBB Blockgets
+* @version v2.0.2 12/01/2021
+*
+* @copyright (c) 2021 CaniDev
+* @license https://opensource.org/licenses/gpl-license.php GNU Public License
+*/
+
+// @ignore
+if(!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if(empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'PORTAL'			=> 'Portal',
+	'READ_FULL'			=> 'Read full topic',
+	'BLG_READ_MORE'		=> '%sLer mais%s',
+
+	'ADD_PAGE'					=> 'Criar página',
+	'BANNERS'					=> 'Banners',
+	'CALENDAR'					=> 'Calendário',
+	'CALENDAR_BIRTHDAY_TITLE'	=> '%1$s e <strong>mais %2$d</strong>.',
+	'CALENDAR_SELECT_DATE'		=> 'Seleccionar data',
+	'EDIT_CONFIGURATION'		=> 'Editar configuração',
+	'EDIT_THIS_PAGE'			=> 'Editar esta página',
+	'EDITOR'					=> 'Editor',
+	'EXPAND_CONTRACT'			=> 'Expandir/colapsar',
+	'INSERT_ON_ENTRY'			=> 'Inserir no texto',
+	'MANAGE_BLOCKS'				=> 'Gerir blocos',
+	'PRINT'						=> 'Imprimir',
+	'SELECT_COLOUR'				=> 'Seleccionar cor',
+	'SMILIES'					=> 'Emoticons',
+	'TODAY'						=> 'Hoje',
+
+	// Editor
+	'HTML_TITLE' 		=> 'Html:',
+	'INSERT_HTML' 		=> 'Inserir Código HTML',
+
+	// Login Block
+	'HIDE_ME_NOW'			=> 'Hide me in this session',
+	'MY_BOOKMARKS'			=> 'Favoritos',
+	'MY_SUBSCRIBED'			=> 'Subscrições',
+	'REMEMBER_ME'			=> 'Lembrar-me',
+
+	// Link Us Block
+	'LINK_US_TXT'			=> 'Please feel free to link to <strong>%s</strong>. Use the following HTML:',
+
+	// Stats Block and whos_online block
+	'GUEST_VISITS_TOTAL'		=> '%d Visitantes',
+	'GUEST_VISIT_TOTAL'			=> '%d Visitante',
+	'HIDDEN_VISITS_TOTAL'		=> '%d ocultos, ',
+	'HIDDEN_VISIT_TOTAL'		=> '%d oculto, ',
+	'LASTVISIT_VISITS_TOTAL'	=> 'In total there were <strong>%d</strong> users online in the last 24 hours :: ',
+	'LASTVISIT_VISIT_TOTAL'		=> 'In total there is <strong>%d</strong> user online in the last 24 hours  :: ',
+	'REG_VISITS_TOTAL'			=> '%d Registados, ',
+	'REG_VISIT_TOTAL'			=> '%d Registado, ',
+
+	'ST_ACTIVE_POSTERS'			=> 'Active posters',
+	'ST_ANNS'					=> 'Announcements',
+	'ST_ATTACHMENTS'			=> 'Anexos',
+	'ST_BOARD_STARTDATE'		=> 'Start date',
+	'ST_NEW'					=> 'Novo',
+	'ST_NEWEST_USER'			=> 'Último membro',
+	'ST_POSTS'					=> 'Mensagens',
+	'ST_POSTS_PER_DAY'			=> 'Mensagens por dia',
+	'ST_POSTS_PER_TOPIC'		=> 'Mensagens por tópico',
+	'ST_POSTS_PER_USER'			=> 'Mensagens por utilizador',
+	'ST_STICKYS'				=> 'Importantes',
+	'ST_TOP'					=> 'Total',
+	'ST_TOPICS'					=> 'Tópicos',
+	'ST_TOPICS_PER_DAY'			=> 'Tópicos por dia',
+	'ST_TOPICS_PER_USER'		=> 'Tópicos por utilizador',
+	'ST_TOTAL_USERS'			=> 'Total utilizadores',
+	'ST_USERS_PER_DAY'			=> 'Utilizadores por dia',
+	'ST_VISIT_IP'				=> 'O teu IP',
+
+	'WIO_ONLINE'			=> 'Utilizadores online',
+	'WIO_LASTDAY'			=> 'Utilizadores hoje',
+	'WIO_TOTAL'				=> 'Total',
+	'WIO_REGISTERED'		=> 'Registados',
+	'WIO_HIDDEN'			=> 'Ocultos',
+	'WIO_GUEST'				=> 'Visitantes',
+
+	// polls
+	'NO_POLL'			=> 'Votação indisponível',
+
+	// attachments_block
+	'ATTACH_DATE'			=> 'Publicado',
+	'ATTACH_SIZE'			=> 'Tamanho',
+	'ATTACH_DOWNLOAD'		=> 'Transferido',
+	'ATTACH_VIEW'			=> 'Visto',
+
+	'ATTACH_COUNT'				=> array(
+		0	=> 'Nunca',
+		1	=> '%d vez',
+		2	=> '%d vezes',
+	),
+
+	'VIEW_TOPIC'				=> 'Ver Tópico',
+	'DOWNLOAD'					=> 'Download',
+	'NO_ATTACHMENTS'			=> 'Sem anexos disponíveis',
+
+	// language_select_block
+	'LANGUAGE_CHANGE'		=> 'Alterar idioma',
+	'LANGUAGE_DEFAULT'		=> 'Idioma Original',
+	'LANGUAGE_SET_MINE'		=> 'Gravar como meu idioma',
+	'LANGUAGE_SELECT'		=> 'Selecionar Idioma',
+
+	// news_block
+	'POSTED_BY'			=> 'Criado por',
+	'LAST_REPLIED_BY'	=> 'Última resposta por',
+	'COMMENTS_PORTAL'	=> 'Comentários',
+	'POLL'				=> 'Votação',
+	'TOPIC_VIEWS'		=> 'Visto',
+	'NO_NEWS'			=> 'Sem notícias disponíveis',
+	'VIEW_COMMENTS'		=> 'Ver comentários',
+
+	// recent_topics_block
+	'BLG_RECENT_ACTIVITY'	=> 'Actividade Recente',
+	'BLG_RECENT_ANN'		=> 'Anúncios Recentes',
+	'BLG_RECENT_TOPICS'		=> 'Tópicos Recentes',
+
+	// paypal_block
+	'AMOUNT_MSG'		=> 'Amount to donate',
+	'CLICK_MSG'			=> 'Proceed to donation',
+	'CODE_MSG'			=> 'Currency',
+	
+	'currencies'	=> array(
+		'AUD'	=> 'Aussie',
+		'CAD' 	=> 'Canadian Dollar',
+		'CZK' 	=> 'Czech Koruna',
+		'DKK' 	=> 'Danish Kroner',
+		'HKD' 	=> 'Hong Kong Dollar',
+		'HUF' 	=> 'Hungarian Forint',
+		'NZD' 	=> 'New Zealand Dollar',
+		'NOK' 	=> 'Norwegian Kroner',
+		'PLN' 	=> 'Polish Zlotych',
+		'GBP' 	=> 'British Pounds',
+		'SGD' 	=> 'Singapore Dollar',
+		'SEK' 	=> 'Swedish Kronor',
+		'CHF' 	=> 'Swiss Francs',
+		'JPY' 	=> 'Japanese Yen',
+		'USD' 	=> 'Dollar',
+		'EUR' 	=> 'Euro',
+		'AUD' 	=> 'Mexican Peso',
+		'ILS' 	=> 'New Israeli Shekels'
+	),
+
+	// most_poster_block
+	'MEMBER_POSTS'		=> '%d (%.2f/dia)',
+	'USER'				=> 'Utilizador',
+	'NO_MOST_POSTER'	=> 'Sem utilizadores para exibir',
+
+	// contact block
+	'EMAIL_EMPTY'		=> 'You must set an email.',
+	'EMAIL_INVALID'		=> 'The entered email is invalid.',
+
+	// counter block
+	'COUNTER_LOCAL'		=> 'Visits to this page',
+	'COUNTER_TOTAL' 	=> 'Total visits',
+	'COUNTER_STARTDATE' => 'Counting from:<br />%s',
+	'HITS_PER_DAY'		=> 'Visits per day',
+	'HITS_PER_HOUR'		=> 'Visits per hour',
+	'HITS_PER_MONTH'	=> 'Visits per month',
+	'HITS_PER_USER'		=> 'Visits per user',
+	'HITS_PER_WEEK'		=> 'Visits per week',
+	'HITS_PER_YEAR'		=> 'Visits per year',
+
+	// style_select_block
+	'STYLE_CHANGE'		=> 'Change Style',
+	'STYLE_DEFAULT'		=> 'Original style',
+	'STYLE_SET_MINE'	=> 'Set as my style',
+	'STYLE_SELECT'		=> 'Select style',
+
+	// latest_bots_block
+	'NO_BOTS'			=> 'Nenhum bot visitou o fórum',
+
+	// latest_unread_block
+	'NO_UNREAD'			=> 'Sem tópicos',
+
+	// ranks_block
+	'MIN_POSTS'			=> 'Minimum Posts',
+	'SPECIAL_RANK'		=> 'Special Rank',
+
+	// online_friends_block
+	'FRIENDS_ONLINE'		=> 'Online friends',
+	'FRIENDS_OFFLINE'		=> 'Offline friends',
+	'NO_FRIENDS_ONLINE'		=> 'No friends online',
+	'NO_FRIENDS_OFFLINE'	=> 'No friends offline',
+	'NO_FRIENDS'			=> 'No friends found',
+
+	// age_ranges_block
+	'RANGE'				=> 'Rank',
+	'RANGE_USERS'		=> 'Utilizadores (%)',
+	'AGE_COUNTS'		=> 'Utilizadores contados',
+	'AGE_AV'			=> 'Idade média',
+	'AGE_AV_COUNT'		=> '%.2f anos',
+
+	// search_block
+	'SH_ENGINE'			=> 'Search Engines',
+
+	// announcements_block
+	'NO_ANNOUNCEMENTS'	=> 'Sem Anúncios',
+
+	//birthday_block
+	'TODAY_BIRTHDAYS'		=> 'Today Birthdays',
+	'TOMORROW_BIRTHDAYS'	=> 'Tomorrow Birthdays',
+	'BIRTHDAYS_FOR'			=> 'Birthdays for %1$s of %2$s',
+
+	// calendar
+	'ADD_EVENT'				=> 'Adicionar evento',
+	'DELETE_EVENT'			=> 'Remover Evento',
+	'EDIT_EVENT'			=> 'Editar Evento',
+	'EVENTS'				=> 'Eventos',
+
+	'EMPTY_EVENT_TITLE'	=> 'Tem de colocar um título para o evento.',
+	'EVENT_ADDED'		=> 'Evento adicionado com sucesso',
+	'EVENT_COLOR'		=> 'Cor',
+	'EVENT_EDITED'		=> 'Evento editado com sucesso',
+	'EVENT_GROUPS'		=> 'Grupos autorizados',
+	'EVENT_TITLE'		=> 'Título do Evento',
+	'EVENT_TIME'		=> 'Data do Evento',
+	'EVENT_DETAILS'		=> 'Detalhes',
+	'EVENT_REMOVED'		=> 'Evento removido com sucesso',
+	'NO_EVENTS'			=> 'Sem eventos',
+	
+	//player block
+	'MUTE'				=> 'Silenciar',
+	'WIN_CLOSE'			=> 'Fechar janela e regressar ao bloco',
+	'WIN_OPEN'			=> 'Abrir numa nova janela',
+	'WIN_OPEN_EXPLAIN'	=> 'Playing in Window',
+	'WIN_RETURN'		=> 'Forze player in the block',
+	'PLAY'				=> 'Play',
+	'PLAY_MSG'			=> 'Playing',
+	'PLAYER'			=> 'Player',
+	'STOP'				=> 'Parar',
+	'STOP_MSG'			=> 'Parou',
+	'VOLUME'			=> 'Volume',
+	'VOLUME_MSG'		=> 'Volume: %d%',
+	
+	// rss block
+	'NO_RSS'		=> 'Sem Rss/Feed para mostrar.',
+
+	// topic index block
+	'CHAR_ALL'		=> 'Todos',
+	
+	// youtube block
+	'YT_EMPTY'		=> 'Sem vídeos para mostrar',
+	'YT_VIEWS'		=> '%d vistos',
+));
+
+// General messages
+$lang = array_merge($lang, array(
+	'ACTION_ERROR'		=> 'No action taken',
+	'BLOCK_LOAD_ERROR'	=> 'Failed to load block',
+	'FORMAT_INVALID'	=> 'The format is not valid',
+	'EVENT_ERROR'		=> 'The selected event does not exist',
+	'NO_TRACKLIST'		=> 'No avaliable tracklist.',
+	'NO_PAGE'			=> 'This page no exists.',
+	'URL_INVALID'		=> 'The URL is not valid.',
+));
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/block_view.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/block_view.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/block_view.html"
+++ /dev/null
@@ -1,62 +0,0 @@
-	
-{% if block.IS_GROUP %}
-	<div id="block-{{ block.BLOCK_ID }}" class="blg-grid">
-	{% for sub in block.blocks %}
-		<div id="block-{{ sub.BLOCK_ID }}" class="blg-block {{ sub.BLOCK_CLASSES }}"{% if sub.DOM_STYLE %} style="{{ sub.DOM_STYLE}} "{% endif %}>
-		{% if sub.BLOCK_STYLE == 'content_simple' %}
-			<div class="block-content">
-				{{ sub.BLOCK_CONTENT }}
-			</div>
-		{% else %}
-			<table class="footable table table-striped table-bordered table-white table-primary default footable-loaded">
-			<thead>
-				<tr>
-					<th class="block-title">
-						{{ sub.BLOCK_ICON }}
-						<span class="cbb-helper-text cbb-inline">{{ sub.BLOCK_TITLE }}</span>
-					</th>
-				</tr>
-			</thead>
-			<tbody>
-			<tr>
-				<td>
-					<div class="block-content">
-						{{ sub.BLOCK_CONTENT }}
-					</div>
-				</td>
-			</tr>
-			</tbody>
-			</table>
-		{% endif %}
-		</div>
-	{% endfor %}
-	</div>
-{% else %}
-	<div id="block-{{ block.BLOCK_ID }}" class="blg-block {{ block.BLOCK_CLASSES }}">
-	{% if block.BLOCK_STYLE == 'content_simple' %}
-		<div class="block-content">
-			{{ block.BLOCK_CONTENT }}
-		</div>
-	{% else %}
-		<table class="footable table table-striped table-bordered table-white table-primary default footable-loaded">
-		<thead>
-			<tr>
-				<th class="block-title">
-					{{ block.BLOCK_ICON }}
-					<span class="cbb-helper-text cbb-inline">{{ block.BLOCK_TITLE }}</span>
-				</th>
-			</tr>
-		</thead>
-		<tbody>
-		<tr>
-			<td>
-				<div class="block-content">
-					{{ block.BLOCK_CONTENT }}
-				</div>
-			</td>
-		</tr>
-		</tbody>
-		</table>
-	{% endif %}
-    </div>
-{% endif %}
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/contact_block.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/contact_block.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/contact_block.html"
+++ /dev/null
@@ -1,59 +0,0 @@
-
-<script>
-// <![CDATA[
-	window._jPostponed = window._jPostponed || [];
-	window._jPostponed.push(function() {
-		$('#block-{{ BLOCK_ID }} form').cbbAjaxify({
-			onSuccess: function() {
-				this.element.find('[name=subject], [name=message]').val('');
-			}
-		});
-	});
-// ]]>
-</script>
-
-<form method="post" action="{{ U_BLG_ACTION }}">
-	<table class="blg-table contact-table {% if BLOCK_VIEW_SMALL %}short-view{% else %}full-table{% endif %}">
-{% if BLOCK_VIEW_SMALL %}
-	{% for fieldrow in loops.fieldrow %}
-	<tr>
-		<td>
-			<strong>{{ fieldrow.TITLE ~ lang('COLON') }}</strong><br />
-		{% if fieldrow.TYPE == 'text' %}
-			<input type="text" name="{{ fieldrow.KEY }}" id="{{ fieldrow.KEY }}" size="35" value="{{ fieldrow.VALUE }}" class="cbb-inputbox" />
-		{% elseif fieldrow.TYPE == 'textarea' %}
-			<textarea name="{{ fieldrow.KEY }}" id="{{ fieldrow.KEY }}" cols="30" rows="6" class="cbb-inputbox">{{ fieldrow.VALUE }}</textarea>
-		{% elseif fieldrow.TYPE == 'custom' %}
-			{{ fieldrow.TEMPLATE }}
-		{% endif %}
-		</td>
-	</tr>
-	{% endfor %}
-{% else %}
-		<col width="35%" /><col width="65%" />
-	{% for fieldrow in loops.fieldrow %}
-		<tr>
-			<td class="blg-align-right"{% if fieldrow.TYPE == 'textarea' %} valign="top"{% endif %}>
-				<label for="{{ fieldrow.KEY }}"><strong>{{ fieldrow.TITLE ~ lang('COLON') }}</strong></label>
-			</td>
-			<td>
-			{% if fieldrow.TYPE == 'text' %}
-				<input type="text" name="{{ fieldrow.KEY }}" id="{{ fieldrow.KEY }}" size="35" value="{{ fieldrow.VALUE }}" class="cbb-inputbox autowidth" />
-			{% elseif fieldrow.TYPE == 'textarea' %}
-				<textarea name="{{ fieldrow.KEY }}" id="{{ fieldrow.KEY }}" cols="30" rows="8" class="cbb-inputbox">{{ fieldrow.VALUE }}</textarea>
-			{% elseif fieldrow.TYPE == 'custom' %}
-				{{ fieldrow.TEMPLATE }}
-			{% endif %}
-			</td>
-		</tr>
-	{% endfor %}
-{% endif %}
-	</table>
-
-	<br />
-	<div class="blg-align-center">
-		<input type="submit" class="btn btn-default" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />
-		{{ BLOCK_HIDDEN_FIELDS }}
-		{{ S_FORM_TOKEN_BLG_CONTACT }}
-	</div>
-</form>
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/forums_block.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/forums_block.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/forums_block.html"
+++ /dev/null
@@ -1,110 +0,0 @@
-
-{% if BLOCK_VIEW_SMALL and not BLOCK_VIEW_MEDIUM %}
-<ul class="blg-linear-list">
-
-{% for forum_row in loops.forum_row %}
-	{% if forum_row.S_IS_CAT or forum_row.S_FIRST_ROW or forum_row.S_NO_CAT %}
-	<li class="menu-cat">
-		{% if forum_row.S_IS_CAT %}<a href="{{ forum_row.U_VIEWFORUM }}">{{ forum_row.FORUM_NAME }}</a>{% else %}{{ lang('FORUM') }}{% endif %}
-	</li>
-	{% endif %}
-
-	{% if not forum_row.S_IS_CAT %}
-	<li class="subchild double-space">
-		<i class="fa {{ forum_row.FORUM_ICON }} fa-lg"></i>
-		<a href="{{ forum_row.U_VIEWFORUM }}">{{ forum_row.FORUM_NAME }}</a>
-	</li>
-	{% endif %}
-
-{% else %}
-	<li><strong>{{ lang('NO_FORUMS') }}</strong></li>
-{% endfor %}
-
-</ul>
-
-{% else %}
-
-<div class="blg-forum-list{% if BLOCK_VIEW_MEDIUM %} title-only{% endif %}">
-
-{% for forum_row in loops.forum_row %}
-	{% if (forum_row.S_IS_CAT and not forum_row.S_FIRST_ROW) or forum_row.S_NO_CAT %}
-		</tbody>
-		</table>
-
-		{% if BLOCK_STYLE == 'content_simple' %}</div>{% endif %}
-	{% endif %}
-
-	{% if forum_row.S_IS_CAT or forum_row.S_FIRST_ROW or forum_row.S_NO_CAT %}
-		{% if BLOCK_STYLE == 'content_simple' %}
-		<div class="panel panel-default">
-		{% else %}
-		<div class="blg-widget-header">
-			{% if not BLOCK_VIEW_MEDIUM %}<div class="fb-lastpost-title">{{ lang('LAST_POST') }}</div>{% endif %}
-			{% if forum_row.S_IS_CAT %}<a href="{{ forum_row.U_VIEWFORUM }}">{{ forum_row.FORUM_NAME }}</a>{% else %}{{ lang('FORUM') }}{% endif %}
-		</div>
-		{% endif %}
-
-		<table class="footable table table-striped table-bordered table-white table-primary table-hover topics-table">
-		{% if BLOCK_STYLE == 'content_simple' %}
-		<thead>
-			<tr><th colspan="3">{{ BLOCK_TITLE }}</th></tr>
-		</thead>
-		{% endif %}
-
-		<tbody>
-	{% endif %}
-
-	{% if not forum_row.S_IS_CAT %}
-		<tr>
-			<td>
-				{% if forum_row.FORUM_IMAGE %}<span class="forum-image">{{ forum_row.FORUM_IMAGE }}</span>{% endif %}
-				<span class="icon-wrapper">
-					<i class="row-icon-font icon-moon-default{% if forum_row.S_IS_LINK %} icon-moon-link2{% endif %}{% if forum_row.S_UNREAD_FORUM %} forum-unread{% else %} forum-read{% endif %}"></i>
-				</span>
-				<span class="desc-wrapper">
-					<a href="{{ forum_row.U_VIEWFORUM }}" class="forumtitle">{{ forum_row.FORUM_NAME }}</a><br />
-					{{ forum_row.FORUM_DESC }}
-					{% if forum_row.MODERATORS %}
-						<span class="forum-mods"><strong>{{ forum_row.L_MODERATOR_STR ~ lang('COLON') }}</strong>&nbsp;{{ forum_row.MODERATORS }}</span>
-					{% endif %}
-					{% if forum_row.SUBFORUMS and forum_row.S_LIST_SUBFORUMS %}
-					<br />
-					<span class="subforums">
-				 		 <strong>{{ forum_row.L_SUBFORUM_STR }}</strong>
-				 		 {{ forum_row.SUBFORUMS }}
-				 	</span>
-					{% endif %}
-
-				</span>
-			</td>
-		{% if not BLOCK_VIEW_MEDIUM %}
-			{% if forum_row.CLICKS %}
-				<td colspan="2"><span class="stats-wrapper">{{ lang('REDIRECTS') ~ lang('COLON') }} {{ forum_row.CLICKS }}</td>
-			{% elseif not forum_row.S_IS_LINK %}
-				<td class="fb-stats blg-align-center">{{ forum_row.TOPICS }} {{ lang('TOPICS') }}<br />{{ forum_row.POSTS }} {{ lang('POSTS') }}</dd>
-				<td class="lastpost">
-				{% if forum_row.LAST_POST_TIME %}
-					<a class="cbb-helper-text" href="{{ forum_row.U_LAST_POST }}" title="{{ forum_row.LAST_POST_SUBJECT }}">{{ forum_row.LAST_POST_SUBJECT }}</a>
-					<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ forum_row.LAST_POSTER_FULL }}
-					<br /><span class="forum-time"><i class="fa fa-clock-o"></i>&nbsp;{{ forum_row.LAST_POST_TIME }}</span>
-				{% else %}
-					{{ lang('NO_POSTS') }}<br />&nbsp;
-				{% endif %}
-				</td>
-			{% endif %}
-		{% endif %}
-		</tr>
-	{% endif %}
-	
-	{% if forum_row.S_LAST_ROW %}
-	</tbody>
-	</table>
-
-		{% if BLOCK_STYLE == 'content_simple' %}</div>{% endif %}
-	{% endif %}
-{% else %}
-	<strong>{{ lang('NO_FORUMS') }}</strong>
-{% endfor %}
-
-</div>
-{% endif %}
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/language_select_block.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/language_select_block.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/language_select_block.html"
+++ /dev/null
@@ -1,21 +0,0 @@
-
-<script>
-// <![CDATA[
-	window._jPostponed = window._jPostponed || [];
-	window._jPostponed.push(function() {
-		$('#block-{{ BLOCK_ID }} form').cbbAjaxify();
-	});
-// ]]>
-</script>
-
-<form method="post" action="{{ U_BLG_ACTION }}">
-	<ul class="blg-linear-list blg-align-center">
-		<li class="double-space"><select name="lng" class="cbb-inputbox">{{ LANGUAGE_SELECT }}</select></li>
-		{% if CAN_SAVE_LANGUAGE %}<li class="doubl-space"><label><input type="checkbox" name="default" value="1" /> {{ lang('LANGUAGE_SET_MINE') }}</label></li>{% endif %}
-		<li class="double-space">
-			<input type="submit" name="submit" class="btn btn-default" value="{{ lang('LANGUAGE_CHANGE') }}" />
-			{{ S_BLOCK_HIDDEN_FIELDS }}
-		</li>
-		{% if U_LANGUAGE_DEFAULT %}<li class="double-space"><a href="{{ U_LANGUAGE_DEFAULT }}">{{ lang('LANGUAGE_DEFAULT') }}</a></li>{% endif %}
-	</ul>
-</form>
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/login_block.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/login_block.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/login_block.html"
+++ /dev/null
@@ -1,103 +0,0 @@
-
-{% if S_USER_LOGGED_IN %}
-<script>
-// <![CDATA[
-	window._jPostponed = window._jPostponed || [];
-	window._jPostponed.push(function() {
-		$('#block-{{ BLOCK_ID }} #blg-logout').cbbAjaxify();
-	});
-// ]]>
-</script>
-
-<ul class="blg-linear-list blg-align-center">
-	<li class="menu-cat">{{ USERNAME_FULL }}</li>
-	<li class="double-space">
-		<a href="{{ U_PROFILE }}">
-			<span class="cbb-circular-avatar">{% if USER_AVATAR %}{{ USER_AVATAR }} {% else %}<span class="cbb-no-avatar"></span>{% endif %}</span>
-		</a>
-	</li>
-
-	{% if USER_RANK_IMG %}<li>{{ USER_RANK_TITLE }}<br />{{ USER_RANK_IMG }}</li>{% endif %}
-	{% if S_LAST_VISIT %}<li class="double-space">{{ S_LAST_VISIT }}</li>{% endif %}
-	{% if S_CURRENT_TIME %}<li class="double-space">{{ S_CURRENT_TIME }}</li>{% endif %}
-	
-	{{ S_BLG_LOGIN_FIELDS }}
-</ul>
-
-<br />
-
-<ul class="blg-menu blg-linear-list">
-{% for link in userlink %}
-	<li>
-		<i class="icon fa {% if link.ICON %}{{ link.ICON }}{% else %}fa-chevron-right{% endif %} fa-fw" aria-hidden="true"></i>
-		<a href="{{ link.URL }}">{{ link.TITLE }}</a>
-	</li>
-{% endfor %}
-
-	<li class="blg-align-center double-space top-bordered"><a id="blg-logout" class="btn btn-default" href="{{ U_LOGOUT }}">{{ lang('LOGIN_LOGOUT') }}</a></li>
-</ul>
-
-{% else %}
-<script>
-// <![CDATA[
-	window._jPostponed = window._jPostponed || [];
-	window._jPostponed.push(function() {
-		$('#block-{{ BLOCK_ID }} form').cbbAjaxify();
-	});
-// ]]>
-</script>
-
-<form action="{{ U_BLG_ACTION }}" method="post">
-	<ul class="blg-linear-list blg-align-center">
-		<li class="double-space bottom-bordered"><strong>{{ lang('LOGIN') }}</strong></li>
-
-		<li class="blg-align-left"><strong>{{ lang('USERNAME') ~ lang('COLON') }}</strong></li>
-		<li><input class="cbb-inputbox full-width" type="text" name="username" value="{{ S_USERNAME }}" /></li>
-		
-		<li class="blg-align-left"><strong>{{ lang('PASSWORD') ~ lang('COLON') }}</strong></li>
-		<li><input class="cbb-inputbox full-width" type="password" name="password" value="" /></li>
-		{% if U_SEND_PASSWORD %}<li class="blg-align-left"><a href="{{ U_SEND_PASSWORD }}">{{ lang('FORGOT_PASS') }}</a></li>{% endif %}
-		{% if U_RESEND_ACTIVATION %}<li class="blg-align-left"><a href="{{ U_RESEND_ACTIVATION }}">{{ lang('RESEND_ACTIVATION') }}</a></li>{% endif %}
-	</ul>
-	
-	{% if S_DISPLAY_FULL_LOGIN %}
-	<br />
-	<ul class="blg-linear-list">
-		{% if S_AUTOLOGIN_ENABLED %}
-		<li>
-			<input id="autologin-{{ BLOCK_ID }}" type="checkbox" class="radio cbb-checkbox" name="autologin" />
-			<label for="autologin-{{ BLOCK_ID }}">{{ lang('REMEMBER_ME') }}</label>
-		</li>
-		{% endif %}
-		
-		<li>
-			<input id="viewonline-{{ BLOCK_ID }}" type="checkbox" class="radio cbb-checkbox" name="viewonline" />
-			<label for="viewonline-{{ BLOCK_ID }}">{{ lang('HIDE_ME_NOW') }}</label>
-		</li>
-	</ul>
-	{% endif %}
-
-	<div class="blg-align-center">
-		<br />
-		<input type="submit" name="login" class="btn btn-default" value="{{ lang('LOGIN') }}" />
-		{{ S_BLG_LOGIN_FIELDS }}
-		{{ S_FORM_TOKEN_BLG_LOGIN }}
-	</div>
-</form>
-
-	{% if PROVIDER_TEMPLATE_FILE %}
-		{% INCLUDE PROVIDER_TEMPLATE_FILE %}
-	{% endif %}
-
-	{% if S_REGISTER_ENABLED and S_DISPLAY_REGISTER %}
-	<br />
-	<ul class="blg-linear-list">
-		<li class="double-space bottom-bordered blg-align-center"><strong>{{ lang('REGISTER') }}</strong></li>
-		<li><i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i> <a href="{{ U_TERMS_USE }}">{{ lang('TERMS_USE') }}</a></li>
-		<li><i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i> <a href="{{ U_PRIVACY }}">{{ lang('PRIVACY') }}</a></li>
-	
-		<li class="double-space blg-align-center"><a href="{{ U_REGISTER }}"><input type="button" class="btn btn-default" value="{{ lang('REGISTER') }}" /></a></li>
-	</ul>
-	{% endif %}
-
-{% endif %}
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/news_block.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/news_block.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/news_block.html"
+++ /dev/null
@@ -1,143 +0,0 @@
-
-<div id="news-{{ BLOCK_ID }}"{% if S_NEWS_FULL_CONTENT || S_NEWS_COLLAPSE %} class="cbb-helper-hidden"{% endif %}>
-
-<script>
-// <![CDATA[
-	window._jPostponed = window._jPostponed || [];
-	window._jPostponed.push(function() {
-
-	{% if S_NEWS_FULL_CONTENT or S_NEWS_COLLAPSE %}
-		$('#news-{{ BLOCK_ID }}').blgAccordion({
-			collapsable: '{{ S_NEWS_COLLAPSE }}'
-		});
-	{% endif %}
-
-		$('#news-{{ BLOCK_ID }}').cbbLoader({
-			replace: true,
-			requestData: {
-				jblgm: '{{ BLOCK_ID }}',
-			}
-		});
-
-		this.call('@blockgets/resizeImages', '#news-{{ BLOCK_ID }} .news-content');
-	});
-// ]]>
-</script>
-
-{% if news_row|length %}
-
-{% if not S_NEWS_FULL_CONTENT and not S_NEWS_COLLAPSE %}
-
-	<ul class="blg-linear-list">
-	{% for topicrow in news_row %}
-		<li class="double-space">
-			<div>
-				<i class="fa fa-bullhorn fa-lg" aria-hidden="true"></i>
-				{% EVENT topiclist_row_prepend %}
-				<a href="{{ topicrow.U_VIEW_TOPIC }}"><strong>{{ topicrow.TOPIC_TITLE }}</strong></a>
-			</div>
-			<div>
-				{{ lang('POSTED_BY') ~ lang('COLON') }}
-				<strong>{{ topicrow.TOPIC_AUTHOR_FULL }}</strong>
-				{% if BLOCK_VIEW_SMALL %}<br />{% else %}&bull;{% endif %} {{ topicrow.FIRST_POST_TIME }}
-			</div>
-		</li>
-	{% endfor %}
-	</ul>
-
-{% else %}
-
-	{% for topicrow in news_row %}
-		<h5>
-			{% EVENT topiclist_row_prepend %}
-			<span>{{ topicrow.TOPIC_TITLE }}</span>
-		</h5>
-		<div>
-		{% if BLOCK_VIEW_SMALL %}
-			<div>{{ topicrow.FIRST_POST_TIME }}</div>
-			<div>{{ lang('POSTED_BY') ~ lang('COLON') }} <strong>{{ topicrow.TOPIC_AUTHOR_FULL }}</strong></div>
-			{% if topicrow.FORUM_NAME and S_NEWS_FULL_CONTENT %}<div>{{ lang('FORUM') ~ lang('COLON') }} <strong><a href="{{ topicrow.U_VIEW_FORUM }}">{{ topicrow.FORUM_NAME }}</a></strong></div>{% endif %}
-		
-			{% if S_NEWS_FULL_CONTENT %}
-			<div class="news-content">{{ topicrow.TEXT }}</div>
-			
-			<div>
-				<hr />
-				<a href="{{ topicrow.U_VIEW_COMMENTS }}" title="{{ lang('VIEW_COMMENTS') }}">{{ lang('COMMENTS') ~ lang('COLON') }} {{ topicrow.REPLIES }}</a> <br />
-				<a href="{{ topicrow.U_VIEW_TOPIC }}" title="{{ lang('READ_FULL') }}">{{ lang('TOPIC_VIEWS') ~ lang('COLON') }} {{ topicrow.VIEWS }}</a>
-			</div>
-			{% endif %}
-		
-		{% else %}
-			<table class="blg-table">
-			<tr>
-				<td class="blg-align-left">{% if topicrow.S_HAS_ATTACHMENTS %}<i class="fa fa-paperclip fa-lg" aria-hidden="true"></i> {% endif %}{% if topicrow.S_HAS_POLL %}<strong>{{ lang('POLL') ~ lang('COLON') }} </strong>{% endif %}<a href="{{ topicrow.U_VIEW_TOPIC }}"><strong>{{ topicrow.TOPIC_TITLE }}</strong></a></td>
-				<td class="blg-align-right">{{ topicrow.FIRST_POST_TIME }}</td>
-			</tr>
-		
-			<tr>
-				<td colspan="2">{{ lang('POSTED_BY') ~ lang('COLON') }} <strong>{{ topicrow.TOPIC_AUTHOR_FULL }}</strong></td>
-			</tr>
-		
-		{% if S_NEWS_FULL_CONTENT %}
-		
-			{% if topicrow.FORUM_NAME %}<tr><td colspan="2">{{ lang('FORUM') ~ lang('COLON') }} <strong><a href="{{ topicrow.U_VIEW_FORUM }}">{{ topicrow.FORUM_NAME }}</a></strong></td></tr>{% endif %}
-		
-			<tr>
-				<td colspan="2" class="blg-align-{{ S_CONTENT_FLOW_BEGIN }}">
-		
-					<div class="news-content">{{ topicrow.TEXT }}</div>
-					  
-				{% if topicrow.S_HAS_ATTACHMENTS %}
-					<dl class="attachbox">
-						<dt>{{ lang('ATTACHMENTS') }}</dt>
-						{% for attachment in topicrow.attachment %}
-							<dd>{{ attachment.DISPLAY_ATTACHMENT }}</dd>
-						{% endfor %}
-					</dl>
-				{% endif %}
-		
-				</td>
-			</tr>
-		
-			<tr>
-				<td colspan="2" class="blg-align-left">
-					<span>{{ lang('COMMENTS') ~ lang('COLON') }} {{ topicrow.REPLIES }}</span> &bull;
-					<a href="{{ topicrow.U_POST_REPLY }}" title="{{ lang('POST_REPLY') }}">{{ lang('POST_REPLY') }}</a> &bull;
-					<a href="{{ topicrow.U_VIEW_TOPIC }}" title="{{ lang('READ_FULL') }}">{{ lang('TOPIC_VIEWS') ~ lang('COLON') }} {{ topicrow.VIEWS }}</a>
-				</td>
-			</tr>
-		{% endif %}
-			</table>
-		{% endif %}
-		</div>
-	{% endfor %}
-
-{% endif %}
-
-{% if block_pagination|length %}
-	<div class="pull-right">	 
-		<ul class="pagination pagination-forum {% if BLOCK_VIEW_SMALL %}pagination-xs{% else %}pagination-sm{% endif %} hidden-xs">
-		{% for pagination in block_pagination %}
-			{% if pagination.S_IS_PREV %}
-			<li class="previous"><a href="{{ pagination.PAGE_URL }}" rel="prev" role="button">{{ lang('PREVIOUS') }}</a></li>
-			{% elseif pagination.S_IS_CURRENT %}
-			<li class="active"><span>{{ pagination.PAGE_NUMBER }}</span></li>
-			{% elseif pagination.S_IS_ELLIPSIS %}
-			<li class="ellipsis" role="separator"><span>{{ lang('ELLIPSIS') }}</span></li>
-			{% elseif pagination.S_IS_NEXT %}
-			<li class="next"><a href="{{ pagination.PAGE_URL }}" rel="next" role="button">{{ lang('NEXT') }}</a></li>
-			{% else %}
-			<li><a href="{{ pagination.PAGE_URL }}" role="button">{{ pagination.PAGE_NUMBER }}</a></li>
-			{% endif %}
-		{% endfor %}
-		</ul>
-	</div>
-	<div class="cbb-helper-clear"></div>
-{% endif %}
-
-{% else %}
-<div class="blg-align-center">{{ lang('NO_NEWS') }}</div>
-{% endif %}
-
-</div>
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/poll_block.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/poll_block.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/poll_block.html"
+++ /dev/null
@@ -1,59 +0,0 @@
-{% if poll|length %}
-	<script>
-	// <![CDATA[
-		window._jPostponed = window._jPostponed || [];
-		window._jPostponed.push(function() {
-			$('#poll-{{ BLOCK_ID }}').cbbAjaxify({
-				onSuccess: function(response) {
-					this.element.replaceWith(response.htmlContent);
-				}
-			});
-		});
-	// ]]>
-	</script>
-
-{% for poll in loops.poll %}
-{% if poll.S_CAN_VOTE %}<form id="poll-{{ BLOCK_ID }}" method="post" action="{{ U_BLG_ACTION }}">{% endif %}
-	<ul class="blg-linear-list blg-align-center">
-		<li class="double-space menu-cat">{{ poll.S_POLL_QUESTION }}</li>
-		{% if poll.S_POLL_LENGTH %}<li>{{ poll.S_POLL_LENGTH }}</li>{% endif %}
-		{% if poll.S_CAN_VOTE %}<li>{{ poll.S_MAX_VOTES }}</li>{% endif %}
-	</ul>
-
-	{% for poll_option in poll.poll_option %}
-	<div class="blg-poll-option">
-		<div class="poll-option-title">
-			{% if poll.S_CAN_VOTE %}<input type="{% if poll.S_IS_MULTI_CHOICE %}checkbox{% else %}radio{% endif %}" name="poll_vote_id[]" id="vote_{{ poll_option.POLL_OPTION_ID }}" value="{{ poll_option.POLL_OPTION_ID }}"{% if poll_option.POLL_OPTION_VOTED %} checked="checked"{% endif %} />{% endif %}
-			{{ poll_option.POLL_OPTION_CAPTION }}
-		</div>
-
-		{% if poll.S_DISPLAY_RESULTS %}
-		<div class="poll-option-results">
-			<div class="blg-progressbar" title="{{ poll_option.POLL_OPTION_PERCENT }}"><div style="width:{{ poll_option.POLL_OPTION_PERCENT }};"></div></div>
-			<div class="poll-option-text">
-				{% if poll_option.POLL_OPTION_VOTED %}<i class="fa fa-check-circle-o fa-lg" title="{{ lang('POLL_VOTED_OPTION') }}"></i>{% endif %}
-				{{ poll_option.POLL_OPTION_PERCENT }}
-			</div>
-		</div>
-		{% endif %}
-	</div>
-	{% endfor %}
-
-	<br />
-	
-	<ul class="blg-linear-list blg-align-center">
-		{% if poll.S_CAN_VOTE %}<li><input type="submit" name="update_vote" value="{{ lang('SUBMIT_VOTE') }}" class="btn btn-default" /></li>{% endif %}
-		{% if poll.S_DISPLAY_RESULTS %}<li>{{ lang('TOTAL_VOTES') ~ lang('COLON') }} {{ poll.S_TOTAL_VOTES }}</li>{% endif %}
-          
-		<li><a href="{{ poll.U_POLL_RESULTS }}">{{ lang('VIEW_TOPIC') }}</a></li>
-	</ul>
-
-{% if poll.S_CAN_VOTE %}
-	<div>{{ poll.S_HIDDEN_FIELDS }}</div>
-</form>
-{% endif %}
-{% endfor %}
-
-{% else %}
-<div class="blg-align-center">{{ lang('NO_POLL') }}</div>
-{% endif %}
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/recent_topics_block.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/recent_topics_block.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/recent_topics_block.html"
+++ /dev/null
@@ -1,137 +0,0 @@
-
-{% if SHOW_TABS %}
-<script>
-// <![CDATA[
-	window._jPostponed = window._jPostponed || [];
-	window._jPostponed.push(function() {
-		$('#recent-{{ BLOCK_ID }}'){% if BLOCK_VIEW_SMALL %}.blgAccordion();{% else %}.cbbTabs();{% endif %}
-	});
-// ]]>
-</script>
-{% endif %}
-
-<div id="recent-{{ BLOCK_ID }}"{% if SHOW_TABS %} class="cbb-helper-hidden"{% endif %}>
-
-{% if BLOCK_VIEW_SMALL %}
-	{% for tab in recent_tab %}
-		<h5><a href="#">{{ tab.TITLE }}</a></h5>
-		<div class="no-wrap">
-			{% if tab.IS_EMPTY %}{{ lang('NO_ITEMS') }}{% endif %}
-
-			<ul class="blg-linear-list">
-			{% for topicrow in tab.rows %}
-				<li>
-					{% EVENT topiclist_row_prepend %}
-					<a class="cbb-helper-text cbb-inline" href="{{ topicrow.U_VIEW_TOPIC }}">{{ topicrow.TOPIC_TITLE }}</a>
-					{% EVENT topiclist_row_append %}
-				</li>
-			{% endfor %}
-			</ul>
-		</div>
-	{% endfor %}
-
-{% else %}
-
-{% if SHOW_TABS %}
-    <ul>
-	{% for tab in recent_tab %}
-		<li><a href="#{{ tab.ID }}-{{ BLOCK_ID }}"><i class="fa {{ tab.ICON }} fa-lg"></i>{% if not BLOCK_VIEW_MEDIUM %} <span class="tab-title">{{ tab.TITLE }}</span>{% endif %}</a></li>
-	{% endfor %}
-    </ul>
-{% endif %}
-
-    {% if TOPIC_DESIGN == 'simple' %}
-		{% for tab in recent_tab %}
-			<div class="blg-align-center recent-content block-postbody" id="{{ tab.ID }}-{{ BLOCK_ID }}">
-
-				<div class="blg-table">
-				{% if tab.IS_EMPTY %}
-					<div class="blg-align-center"><span>{{ lang('NO_ITEMS') }}</span></div>
-				{% else %}
-					<div>
-						<div class="blg-column-topic-title blg-widget-header">{{ lang('TOPIC_TITLE') }}</div>
-						<div class="blg-column-posted-by blg-widget-header">{{ lang('POSTED_BY') }}</div>
-					{% if not BLOCK_VIEW_MEDIUM %}
-						<div class="blg-column-comments blg-widget-header">{{ lang('COMMENTS') }}</div>
-						<div class="blg-column-topic-views blg-widget-header">{{ lang('TOPIC_VIEWS') }}</div>
-					{% endif %}
-					</div>
-					
-					{% for topicrow in tab.rows %}
-						<div>
-							<div class="blg-column-topic-title blg-align-left">
-								{% EVENT topiclist_row_prepend %}
-								<a href="{{ topicrow.U_VIEW_TOPIC }}" class="cbb-helper-text cbb-inline" title="{{ topicrow.TOPIC_TITLE_RAW|e }}">{{ topicrow.TOPIC_TITLE }}</a>
-							</div>
-							<div class="blg-column-posted-by blg-align-center">{{ topicrow.TOPIC_AUTHOR_FULL }}</div>
-						{% if not BLOCK_VIEW_MEDIUM %}
-							<div class="blg-column-comments blg-align-center"><a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_COMMENTS') }}">{{ topicrow.REPLIES }}</a></div>
-							<div class="blg-column-topic-views blg-align-center">{{ topicrow.VIEWS }}</div>
-						{% endif %}
-						</div>
-					{% endfor %}
-				{% endif %}
-				</div>
-			</div>
-		{% endfor %}
-	{% else %}
-		{% for tab in recent_tab %}
-			<div id="{{ tab.ID }}-{{ BLOCK_ID }}" class="blg-forum-list{% if SHOW_TABS %} cbb-helper-hidden{% endif %}{% if BLOCK_VIEW_MEDIUM %} title-only{% endif %}">
-			{% if tab.IS_EMPTY %}
-				<div class="blg-message">{{ lang('NO_ITEMS') }}</div>
-			{% else %}
-				<div class="blg-widget-header">
-					{% if not BLOCK_VIEW_MEDIUM %}<div class="fb-lastpost-title">{{ lang('LAST_POST') }}</div>{% endif %}
-					<span>{{ lang('TOPIC') }}</span>
-				</div>
-				<table class="footable table table-striped table-bordered table-white table-primary table-hover topics-table">
-				</tbody>
-
-				{% for topicrow in tab.rows %}
-					{% EVENT viewforum_body_topicrow_row_before %}
-					<tr>
-						<td>
-							{% if topicrow.TOPIC_ICON_IMG %}
-							<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
-							{% endif %}
-
-							<span class="icon-wrapper">
-						    	<i class="row-icon-font icon-moon-default2{% if topicrow.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if topicrow.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if topicrow.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if topicrow.S_HAS_POLL %} icon-moon-poll{% endif %}{% if topicrow.S_TOPIC_MOVED %} icon-moon-moved{% endif %}{% if topicrow.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
-							</span>
-
-							<i class="row-icon-font-mini{% if topicrow.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
-							
-							<div class="desc-wrapper">
-					  			{% EVENT topiclist_row_prepend %}
-								{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}
-
-								<br />{{ lang('POST_BY_AUTHOR') }}&nbsp;{{ topicrow.TOPIC_AUTHOR_FULL }} 
-								<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
-					 		 	{% EVENT topiclist_row_append %}	
-							</div>
-						</td>
-
-					{% if not BLOCK_VIEW_MEDIUM %}
-						<td class="fb-stats blg-align-center">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
-						<td class="lastpost">
-							<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.LAST_POST_AUTHOR_FULL }}
-							{% if not S_IS_BOT %}
-								<a href="{{ topicrow.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">
-									<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
-								</a>
-							{% endif %}
-							<br /><i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
-						</td>
-					{% endif %}
-					</tr>
-					{% EVENT viewforum_body_topicrow_row_after %}
-				{% endfor %}
-
-				</tbody>
-				</table>
-			{% endif %}
-			</div>
-		{% endfor %}
-	{% endif %}
-{% endif %}
-</div>
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/search_block.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/search_block.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/search_block.html"
+++ /dev/null
@@ -1,71 +0,0 @@
-<script>
-// <![CDATA[
-	window._jPostponed = window._jPostponed || [];
-	window._jPostponed.push(function() {
-		$('#block-{{ BLOCK_ID }} form').submit(function() {
-			var searchUrls = {
-				google		: 'https://www.google.com/search?q=',
-				yahoo		: 'https://search.yahoo.com/search?p=',
-				bing		: 'https://www.bing.com/search?q='
-			};
-
-			var data = $(this).serializeObject();
-
-			if(!data.keywords || data.keywords == $(this).find('[name="keywords"]').attr('placeholder'))
-			{
-				return false;
-			}
-
-			switch(data.engine)
-			{
-				case 'author':
-					$(this).find('[name="keywords"]').attr('name', 'author');
-
-				case 'site':
-					return true;
-				break;
-	
-				case 'google':
-				case 'yahoo':
-				case 'bing':
-					var url = searchUrls[data.engine];
-
-					if(url)
-					{
-						window.open(url + encodeURIComponent(data.keywords), '_' + data.engine, '');
-					}
-				break;
-			}
-
-			return false;
-		});
-	});
-// ]]>
-</script>
-
-<form method="get" action="{{ U_SEARCH }}">
-	<ul class="blg-linear-list blg-align-center">
-		<li class="double-space"><input type="text" class="cbb-inputbox full-width" name="keywords" size="22" value="" placeholder="{{ lang('SEARCH_MINI') }}" /></li>
-		<li class="double-space">
-			<select name="engine" class="cbb-inputbox">
-			{% if S_DISPLAY_SEARCH %}
-				<optgroup label="{{ lang('FORUMS') }}">
-					<option value="site">{{ lang('MESSAGES') }}</option>
-					<option value="author">{{ lang('AUTHOR') }}</option>
-				</optgroup>
-			{% endif %}
-				<optgroup label="{{ lang('SH_ENGINE') }}">
-					<option value="google">Google</option>
-					<option value="yahoo">Yahoo</option>
-					<option value="bing">Bing</option>
-				</optgroup>
-			</select>
-		</li>
-
-		<li class="double-space"><input class="btn btn-default" type="submit" value="{{ lang('SEARCH') }}" /></li>
-
-		{% if S_DISPLAY_SEARCH %}<li class="double-space top-bordered"><a href="{{ U_SEARCH }}" title="{{ lang('SEARCH_ADV_EXPLAIN') }}">{{ lang('SEARCH_ADV') }}</a></li>{% endif %}
-	</ul>
-	
-	<div>{{ S_BLOCK_HIDDEN_FIELDS }}</div>
-</form>
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/style_select_block.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/style_select_block.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/style_select_block.html"
+++ /dev/null
@@ -1,21 +0,0 @@
-
-<script>
-// <![CDATA[
-	window._jPostponed = window._jPostponed || [];
-	window._jPostponed.push(function() {
-		$('#block-{{ BLOCK_ID }} form').cbbAjaxify();
-	});
-// ]]>
-</script>
-
-<form method="post" action="{{ U_BLG_ACTION }}">
-	<ul class="blg-linear-list blg-align-center">
-		<li class="double-space"><select name="style" class="cbb-inputbox">{{ STYLE_SELECT }}</select></li>
-		{% if CAN_SAVE_STYLE %}<li class="doubl-space"><label><input type="checkbox" name="default" value="1" /> {{ lang('STYLE_SET_MINE') }}</label></li>{% endif %}
-		<li class="double-space">
-			<input type="submit" name="submit" class="btn btn-default" value="{{ lang('STYLE_CHANGE') }}" />
-			{{ S_BLOCK_HIDDEN_FIELDS }}
-		</li>
-		{% if U_STYLE_DEFAULT %}<li class="double-space"><a href="{{ U_STYLE_DEFAULT }}">{{ lang('STYLE_DEFAULT') }}</a></li>{% endif %}
-	</ul>
-</form>
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/top_topics_block.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/top_topics_block.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/top_topics_block.html"
+++ /dev/null
@@ -1,87 +0,0 @@
-
-{% if BLOCK_VIEW_SMALL or TOPIC_DESIGN == 'simple' %}
-{% for topicrow in top_topic %}
-	{% if not topicrow.S_FIRST_ROW %}<hr />{% endif %}
-	<div class="lunread-row">
-		{% EVENT topiclist_row_prepend %}
-		<a class="cbb-helper-text cbb-inline half-size" href="{{ topicrow.U_VIEW_TOPIC }}"><strong>{{ topicrow.TOPIC_TITLE }}</strong></a>
-		{% if not BLOCK_VIEW_SMALL %}<span>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.TOPIC_AUTHOR_FULL }}</span>{% endif %}
-		<span> &raquo; <em>{{ topicrow.FIRST_POST_TIME }}</em></span>
-		{% EVENT topiclist_row_append %}
-	</div>
-{% else %}
-	<div class="blg-align-center">{{ lang('NO_UNREAD') }}</div>
-{% endfor %}
-
-{% else %}
-
-<div class="blg-forum-list{% if BLOCK_VIEW_MEDIUM %} title-only{% endif %}">
-
-	{% if BLOCK_STYLE == 'content_simple' %}
-	<div class="panel panel-default">
-	{% elseif top_topic|length %}
-		<div class="blg-widget-header">
-			{% if not BLOCK_VIEW_MEDIUM %}<div class="fb-lastpost-title">{{ lang('LAST_POST') }}</div>{% endif %}
-			<span>{{ lang('TOPIC') }}</span>
-		</div>
-	{% endif %}
-
-		<table class="footable table table-striped table-bordered table-white table-primary table-hover topics-table">
-	{% if BLOCK_STYLE == 'content_simple' %}
-		<thead>
-			<tr><th colspan="3">{{ BLOCK_TITLE }}</th></tr>
-		</thead>
-	{% endif %}
-		<tbody>
-
-		{% for topicrow in top_topic %}
-			{% EVENT viewforum_body_topicrow_row_before %}
-			<tr>
-				<td>
-					{% if topicrow.TOPIC_ICON_IMG %}
-					<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
-					{% endif %}
-
-					<span class="icon-wrapper">
-				    	<i class="row-icon-font icon-moon-default2{% if topicrow.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if topicrow.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if topicrow.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if topicrow.S_HAS_POLL %} icon-moon-poll{% endif %}{% if topicrow.S_TOPIC_MOVED %} icon-moon-moved{% endif %}{% if topicrow.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
-					</span>
-
-					<i class="row-icon-font-mini{% if topicrow.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
-					
-					<div class="desc-wrapper">
-			  			{% EVENT topiclist_row_prepend %}
-						{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}
-
-						<br />{{ lang('POST_BY_AUTHOR') }}&nbsp;{{ topicrow.TOPIC_AUTHOR_FULL }} 
-						<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
-			 		 	{% EVENT topiclist_row_append %}	
-					</div>
-				</td>
-
-			{% if not BLOCK_VIEW_MEDIUM %}
-				<td class="fb-stats blg-align-center">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
-				<td class="lastpost">
-					<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.LAST_POST_AUTHOR_FULL }}
-					{% if not S_IS_BOT %}
-						<a href="{{ topicrow.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">
-							<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
-						</a>
-					{% endif %}
-					<br /><i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
-				</td>
-			{% endif %}
-			</tr>
-			{% EVENT viewforum_body_topicrow_row_after %}
-		{% else %}
-			<tr><td colspan="3" class="blg-message">{{ lang('NO_UNREAD') }}</td></tr>
-		{% endfor %}
-		</tbody>
-		</table>
-
-	{% if BLOCK_STYLE == 'content_simple' %}
-	</div>
-	{% endif %}
-
-</div>
-
-{% endif %}
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/topic_index_block.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/topic_index_block.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/blocks/topic_index_block.html"
+++ /dev/null
@@ -1,152 +0,0 @@
-
-<div id="topic-index-{{ BLOCK_ID }}">
-
-<script>
-// <![CDATA[
-	window._jPostponed = window._jPostponed || [];
-	window._jPostponed.push(function() {
-		$('#topic-index-{{ BLOCK_ID }}').cbbLoader({
-			paginationSelector: '.pagination a, .char-select a',
-			replace: true,
-			requestData: {
-				jblgm: '{{ BLOCK_ID }}',
-				fchar: '{{ S_FIRST_CHAR }}'
-			}
-		});
-	});
-// ]]>
-</script>
-
-{% if S_CHAR_SELECT %}
-	<div class="char-select blg-align-center">
-	{% for char in first_char %}
-		{% if char.S_SELECTED %}<span>{{ char.DESC }}</span>{% else %}<a href="#?fchar={{ char.VALUE }}">{{ char.DESC }}</a>{% endif %}&nbsp; 
-	{% endfor %}
-	</div>
-{% endif %}
-
-{% if BLOCK_VIEW_SMALL or TOPIC_DESIGN == 'simple' %}
-	<div class="topic-index-content block-postbody blg-align-center blg-corner-all">
-
-	<div{% if not BLOCK_VIEW_SMALL and not BLOCK_VIEW_MEDIUM %} class="blg-table"{% endif %}>
-		<div>
-			<div class="blg-column-topic-title blg-widget-header">{{ lang('TOPIC_TITLE') }}</div>
-		{% if not BLOCK_VIEW_SMALL and not BLOCK_VIEW_MEDIUM %}
-			<div class="blg-column-posted-by blg-widget-header">{{ lang('POSTED_BY') }}</div>
-			<div class="blg-column-comments blg-widget-header">{{ lang('COMMENTS') }}</div>
-			<div class="blg-column-topic-views blg-widget-header">{{ lang('TOPIC_VIEWS') }}</div>
-		{% endif %}
-		</div>
-		
-	{% for topicrow in topic %}
-		<div>
-			<div class="blg-column-topic-title blg-align-left">
-				{% EVENT topiclist_row_prepend %}
-				<a href="{{ topicrow.U_VIEW_TOPIC }}" class="cbb-helper-text cbb-inline" title="{{ topicrow.TOPIC_TITLE_RAW|e }}">{{ topicrow.TOPIC_TITLE }}</a>
-			</div>
-		{% if not BLOCK_VIEW_SMALL and not BLOCK_VIEW_MEDIUM %}
-			<div class="blg-column-posted-by blg-align-center">{{ topicrow.TOPIC_AUTHOR_FULL }}</div>
-			<div class="blg-column-comments blg-align-center"><a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_COMMENTS') }}">{{ topicrow.REPLIES }}</a></div>
-			<div class="blg-column-topic-views blg-align-center">{{ topicrow.VIEWS }}</div>
-		{% endif %}
-		</div>
-	{% else %}
-		<div><div class="blg-align-center" colspan="4">{{ lang('NO_TOPICS') }}</div></div>
-	{% endfor %}
-
-	</div>
-	</div>
-
-{% else %}
-
-<div class="blg-forum-list{% if BLOCK_VIEW_MEDIUM %} title-only{% endif %}">
-
-	{% if BLOCK_STYLE == 'content_simple' %}
-	<div class="panel panel-default">
-	{% elseif topic|length %}
-		<div class="blg-widget-header">
-			{% if not BLOCK_VIEW_MEDIUM %}<div class="fb-lastpost-title">{{ lang('LAST_POST') }}</div>{% endif %}
-			<span>{{ lang('TOPIC') }}</span>
-		</div>
-	{% endif %}
-
-		<table class="footable table table-striped table-bordered table-white table-primary table-hover topics-table">
-	{% if BLOCK_STYLE == 'content_simple' %}
-		<thead>
-			<tr><th colspan="3">{{ BLOCK_TITLE }}</th></tr>
-		</thead>
-	{% endif %}
-		<tbody>
-
-		{% for topicrow in topic %}
-			{% EVENT viewforum_body_topicrow_row_before %}
-			<tr>
-				<td>
-					{% if topicrow.TOPIC_ICON_IMG %}
-					<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
-					{% endif %}
-
-					<span class="icon-wrapper">
-				    	<i class="row-icon-font icon-moon-default2{% if topicrow.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if topicrow.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if topicrow.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if topicrow.S_HAS_POLL %} icon-moon-poll{% endif %}{% if topicrow.S_TOPIC_MOVED %} icon-moon-moved{% endif %}{% if topicrow.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
-					</span>
-
-					<i class="row-icon-font-mini{% if topicrow.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
-					
-					<div class="desc-wrapper">
-			  			{% EVENT topiclist_row_prepend %}
-						{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}
-
-						<br />{{ lang('POST_BY_AUTHOR') }}&nbsp;{{ topicrow.TOPIC_AUTHOR_FULL }} 
-						<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
-			 		 	{% EVENT topiclist_row_append %}	
-					</div>
-				</td>
-
-			{% if not BLOCK_VIEW_MEDIUM %}
-				<td class="fb-stats blg-align-center">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
-				<td class="lastpost">
-					<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.LAST_POST_AUTHOR_FULL }}
-					{% if not S_IS_BOT %}
-						<a href="{{ topicrow.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">
-							<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
-						</a>
-					{% endif %}
-					<br /><i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
-				</td>
-			{% endif %}
-			</tr>
-			{% EVENT viewforum_body_topicrow_row_after %}
-		{% endfor %}
-		</tbody>
-		</table>
-
-	{% if BLOCK_STYLE == 'content_simple' %}
-	</div>
-	{% endif %}
-
-</div>
-
-{% endif %}
-
-{% if block_pagination|length %}
-	<div class="pull-right">	 
-		<ul class="pagination pagination-forum {% if BLOCK_VIEW_SMALL %}pagination-xs{% else %}pagination-sm{% endif %} hidden-xs">
-		{% for pagination in block_pagination %}
-			{% if pagination.S_IS_PREV %}
-			<li class="previous"><a href="{{ pagination.PAGE_URL }}" rel="prev" role="button">{{ lang('PREVIOUS') }}</a></li>
-			{% elseif pagination.S_IS_CURRENT %}
-			<li class="active"><span>{{ pagination.PAGE_NUMBER }}</span></li>
-			{% elseif pagination.S_IS_ELLIPSIS %}
-			<li class="ellipsis" role="separator"><span>{{ lang('ELLIPSIS') }}</span></li>
-			{% elseif pagination.S_IS_NEXT %}
-			<li class="next"><a href="{{ pagination.PAGE_URL }}" rel="next" role="button">{{ lang('NEXT') }}</a></li>
-			{% else %}
-			<li><a href="{{ pagination.PAGE_URL }}" role="button">{{ pagination.PAGE_NUMBER }}</a></li>
-			{% endif %}
-		{% endfor %}
-		</ul>
-	</div>
-	<div class="cbb-helper-clear"></div>
-{% endif %}
-
-</div>
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/calendar_body.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/calendar_body.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/calendar_body.html"
+++ /dev/null
@@ -1,116 +0,0 @@
-{% if IN_EVENT %}
-
-<div title="{{ S_EVENT_TITLE }}">
-	<form>
-	<div class="cbb-dialog-content">{{ S_EVENT_CONTENT }}</div>
-
-{% if CAN_MANAGE_EVENT %}
-	<div class="cbb-dialog-buttons">
-		<button class="btn btn-default" value="submit" data-action="edit">{{ lang('EDIT') }}</button>
-		<button class="btn btn-default" value="submit" data-action="delete">{{ lang('DELETE') }}</button>
-		
-		{{ S_HIDDEN_FIELDS }}
-	</div>
-{% endif %}
-	</form>
-</div>
-
-{% elseif IN_BIRTHDAY_LIST %}
-
-<div title="{{ lang('BIRTHDAYS') }}">
-	<div class="cbb-dialog-content">
-		<ul class="blg-linear-list blg-birthday-list">
-		{% for user in loops.user %}
-			<li class="double-space">
-				<div class="cbb-circular-avatar size-small">{% if user.AVATAR %}{{ user.AVATAR }}{% else %}<span class="cbb-no-avatar"></span>{% endif %}</div>
-				{{ user.USERNAME_FULL }}
-				<span>({{ user.AGE }})</span>
-			</li>
-		{% endfor %}
-		</ul>
-	</div>
-</div>
-
-{% else %}
-
-{% INCLUDE 'overall_header.html' %}
-<div class="side-segment">
-	<h3>{{ lang('CALENDAR') }}</h3>
-</div>
-
-{% for calendar in loops.calendar %}
-	<div class="blg-calendar-actionbar">
-		<div class="calendar-printer blg-align-right floated">
-			<a href="#" data-action="print" class="btn btn-default"><i class="fa fa-print" aria-hidden="true"></i> <span>{{ lang('PRINT') }}</span></a>
-		</div>
-
-		<a href="{{ U_TODAY }}" class="btn btn-default" data-rel="today">{{ lang('TODAY') }}</a>
-
-		<div class="btn-group">
-			<a href="{{ U_PREV }}" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
-			<a href="#" class="btn btn-default" data-action="month-select">{{ calendar.S_MONTH }}</a>
-			<a href="{{ U_NEXT }}" class="btn btn-default"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
-		</div>
-	</div>
-	<div class="panel panel-poll">
-		<div class="panel-body">
-			<table class="blg-calendar">
-			<tr>
-			{% for day in calendar.days %}
-
-				{% if day.NEW_LINE and not day.S_FIRST_ROW %}</tr><tr>{% endif %}
-
-				{% if day.IS_HEADER %}
-					<th><span class="short-day text-capitalize">{{ day.S_DAY_SHORT }}</span><span class="full-day text-capitalize">{{ day.S_DAY }}</span></th>
-				{% elseif day.S_DAY %}
-					<td id="day-{{ day.S_DATA }}" data-time="{{ day.S_DATA }}" class="blg-calendar-day{% if day.IS_TODAY %} today{% endif %}">
-						<div class="blg-day-title">
-							{% if S_CAN_CREATE_EVENT %}<a href="#" class="blg-event-add blg-align-right floated" title="{{ lang('ADD_EVENT') }}" data-time="{{ day.S_DATA }}"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>{% endif %}
-							<span>{{ day.S_DAY }}</span>
-						</div>
-					
-						<div class="blg-day-content">
-						{% for event in day.event %}
-							<div {{ event.S_ATTR }}>
-								{% if event.S_TYPE == 'birthday' %}<i class="fa fa-birthday-cake" aria-hidden="true"></i> {% endif %}
-								{{ event.S_TITLE }}
-							</div>
-						{% endfor %}
-						</div>
-					</td>
-				{% else %}
-					<td>&nbsp;</td>
-				{% endif %}
-			{% endfor %}
-			</tr>
-			</table>
-		</div>
-	</div>
-{% endfor %}
-
-<div id="month-selector" class="cbb-helper-hidden" title="{{ lang('CALENDAR_SELECT_DATE') }}">
-	<form>
-		<div class="cbb-dialog-content blg-align-center">
-			<div class="cbb-group">
-				<select class="cbb-inputbox" name="month">{{ S_MONTH_OPTIONS }}</select>
-				<input type="text" class="cbb-inputbox" name="year" value="" size="10" />
-			</div>
-		</div>
-		<div class="cbb-dialog-buttons">
-			<button class="btn btn-default" value="submit">{{ lang('GO') }}</button>
-		</div>
-	</form>
-</div>
-
-<script>
-// <![CDATA[
-	window._jPostponed = window._jPostponed || [];
-	window._jPostponed.push(function() {
-		$('.blg-calendar').blgCalendar();
-	});
-// ]]>
-</script>
-
-{% INCLUDE 'overall_footer.html' %}
-
-{% endif %}
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_body_after.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_body_after.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_body_after.html"
+++ /dev/null
@@ -1,30 +0,0 @@
-{% if BLG_ENABLED or BLG_ADMIN_BAR %}
-
-	{% if BLG_ADMIN_BAR %}
-		<div class="blg-admin-bar">
-			<ul class="blg-align-left floated">
-				<li><a href="{{ U_BLG_MANAGE_BLOCKS }}" class="cbb-btn"><i class="fa fa-th-large" aria-hidden="true"></i> <span class="btn-title">{{ lang('MANAGE_BLOCKS') }}</span></a></li>
-				<li><a href="{{ U_BLG_PAGE_EDIT }}" class="cbb-btn"><i class="fa fa-cog" aria-hidden="true"></i> <span class="btn-title">{{ lang('EDIT_CONFIGURATION') }}</span></a></li>
-			</ul>
-			
-			<ul class="blg-align-right floated">
-				<li><a href="{{ U_BLG_PAGE_ADD }}" class="cbb-btn"><i class="fa fa-plus-circle" aria-hidden="true"></i> <span class="btn-title">{{ lang('ADD_PAGE') }}</span></a></li>
-			</ul>
-
-			<a href="#" class="blg-admin-opener" title="{{ lang('EDIT_THIS_PAGE') }}"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a>
-		</div>
-	{% endif %}
-
-	<script>
-	// <![CDATA[
-	head.ready(['cbbcore.min.js', 'jblockgets.min.js'], function () {
-		cbbCore.initService('blockgets', $.extend({{ S_BLG_OPTIONS }}, {
-			blockHeader: '.block-title',
-			avatarContainer: '.avatar-frame',
-			postContainer: '.postbody'
-		}));
-	});
-	// ]]>
-	</script>
-	
-{% endif %}
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_teamlink_after.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_teamlink_after.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/overall_footer_teamlink_after.html"
+++ /dev/null
@@ -1,6 +0,0 @@
-
-{% for link in loops.blglink_bottom %}
-	<li>
-		<a href="{{ link.HREF }}">{{ link.ICON }} {{ link.TITLE }}</a>
-	</li>
-{% endfor %}
\ No newline at end of file
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/overall_header_head_append.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/overall_header_head_append.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/overall_header_head_append.html"
+++ /dev/null
@@ -1,14 +0,0 @@
-{% if (BLG_ENABLED or BLG_ADMIN_BAR) and CANIDEV_CORE_STARTED %}
-	{% include '@canidev_core/event/overall_header_head_append.html' %}
-	{% INCLUDECSS '@canidev_blockgets/bboots.css' %}
-	
-	{% if BLG_ENABLED %}
-		<style>
-		.blg-center-area 					{ grid-template-columns: {{ LEFT_COLUMN_WIDTH }} 1fr {{ RIGHT_COLUMN_WIDTH }}; }
-		.blg-block, .blg-area, .blg-grid 	{ margin-bottom: {{ BLG_BLOCK_SPACE }}; }
-		.blg-grid, .blg-center-area 		{ gap: {{ BLG_BLOCK_SPACE }}; }
-
-		{% if BLG_LOGO %}.site_logo, .imageset.site_logo { background-image: url('{{ BLG_LOGO }}'); }{% endif %}
-		</style>
-	{% endif %}
-{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/overall_header_navigation_append.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/overall_header_navigation_append.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/overall_header_navigation_append.html"
+++ /dev/null
@@ -1,8 +0,0 @@
-
-{% for link in loops.blglink_top %}
-	<li><a href="{{ link.HREF }}">{{ link.ICON }} {{ link.TITLE }}</a><span></span></li>
-{% endfor %}
-
-{% for link in loops.blglink_quick %}
-	<li><a href="{{ link.HREF }}">{{ link.ICON }} {{ link.TITLE }}</a><span></span></li>
-{% endfor %}
\ No newline at end of file
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/simple_footer_after.html" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/simple_footer_after.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/template/event/simple_footer_after.html"
+++ /dev/null
@@ -1,15 +0,0 @@
-{% if S_IN_PLAYER and CANIDEV_CORE_STARTED %}
-	{% include '@canidev_core/event/overall_footer_after.html' %}
-	
-	<script>
-	// <![CDATA[
-	head.ready(['cbbcore.min.js', 'jblockgets.min.js'], function() {
-		cbbCore.initService('blockgets', $.extend({{ S_BLG_OPTIONS }}, {
-			blockHeader: '.block-title',
-			avatarContainer: '.avatar-frame',
-			postContainer: '.postbody'
-		}));
-	});
-	// ]]>
-	</script>
-{% endif %}
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/theme/bboots.css" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/theme/bboots.css"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/theme/bboots.css"
+++ /dev/null
@@ -1,69 +0,0 @@
-/**
- * cBB Blockgets (BBOOTS stylesheet)
- * Copyright (c) 2023, CaniDev
- * license https://creativecommons.org/licenses/by-nc/4.0/
- */
-
- .blg-block.style-alternative .block-title,
-.blg-block.style-content_full table,
-.blg-block.style-content_full table tr,
-.blg-block.style-content_full table td {
-	background: none !important;
-	border: none !important;
-	box-shadow: none;
-}
-
-.blg-block.style-alternative .block-title {
-	padding: 8px !important;
-}
-
-.blg-block.style-content_full .block-title {
-	border-width: 0 0 1px 0;
-}
-
-.blg-block.style-alternative .block-title,
-.blg-block.style-alternative .block-title i,
-.blg-block.style-content_full .block-title,
-.blg-block.style-content_full .block-title i {
-	color: #808080 !important;
-}
-
-.blg-block.style-alternative .block-content {
-	border: none !important;
-	padding: 0 !important;
-}
-
-.fb-lastpost-title {
-	width: 150px !important;
-}
-
-.blg-menu,
-.blg-menu .fa,
-.blg-message {
-    font-size: 1em !important;
-}
-
-.blg-admin-bar,
-a.blg-admin-opener {
-	box-sizing: content-box;
-}
-
-/* Contact Block
--------------------------- */
-.contact-table {
-	border-spacing: 8px !important;
-}
-
-.contact-table.short-view .cbb-inputbox {
-	max-width: 155px;
-}
-
-/* Login Block
--------------------------- */
-.blg-block .oauth-content {
-	margin-top: 15px;
-}
-
-.blg-block .oauth-content h3 {
-	font-size: 18px;
-}
\ No newline at end of file
diff --git "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/theme/calendar_print.css" "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/theme/calendar_print.css"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\blockgets/styles/BBOOTS/theme/calendar_print.css"
+++ /dev/null
@@ -1,75 +0,0 @@
-/**
- * cBB Blockgets (Calendar Print stylesheet)
- * Copyright (c) 2022, CaniDev
- * license https://creativecommons.org/licenses/by-nc/4.0/
- */
- 
-html	{ height: 100%; }
-body	{ padding: 0; }
-
-header,
-.header,
-.flat-header,
-section.section-page,
-footer,
-.section-pre-footer,
-.mastbottom,
-.breadcrumb-line,
-.social-top,
-.subheader,
-.crumbs,
-.sub-breadcrumb,
-.copyright {
-	display: none !important;
-}
-
-#wrap {
-	border: none;
-	border-radius: 0;
-    max-width: none;
-    min-width: 0;
-	padding: 0 15px;
-}
-
-#page-body, .blg-area {
-    margin: 0;
-}
-
-.blg-calendar-actionbar {
-	float: right;
-	margin: 2em 0 0 0;
-}
-
-.blg-calendar-actionbar .btn-group,
-.blg-calendar-actionbar .btn {
-	display: none;
-}
-
-#blg-column-center h2 {
-	float: left;
-}
-
-.blg-calendar:before {
-    content: "";
-    display: block;
-    clear: both;
-    margin-bottom: 20px;
-}
-
-.blg-calendar td.today {
-	background: none;
-}
-
-.blg-calendar td.today .blg-calendar-day,
-.blg-calendar td.today .blg-calendar-content {
-    border: inherit;
-}
-
-.blg-calendar td.today .blg-calendar-day		{
-	border-bottom: none;
-	font-weight: normal;
-}
-
-.blg-calendar td.today .blg-calendar-content {
-	border-top: none;
-}
diff --git "[ORIGINAL]/canidev\\blockgets/styles/FLATBOOTS/template/blocks/login_block.html" "[FORUM_EXT]/canidev\\blockgets/styles/FLATBOOTS/template/blocks/login_block.html"
--- "[ORIGINAL]/canidev\\blockgets/styles/FLATBOOTS/template/blocks/login_block.html"
+++ "[FORUM_EXT]/canidev\\blockgets/styles/FLATBOOTS/template/blocks/login_block.html"
@@ -13,13 +13,13 @@
 	<li class="menu-cat">{{ USERNAME_FULL }}</li>
 	<li class="double-space">
 		<a href="{{ U_PROFILE }}">
-			<span class="cbb-circular-avatar">{% if USER_AVATAR %}{{ USER_AVATAR }} {% else %}<span class="cbb-no-avatar"></span>{% endif %}</span>
+			<span class="cbb-avatar">{% if USER_AVATAR %}{{ USER_AVATAR }} {% else %}<span class="cbb-no-avatar"></span>{% endif %}</span>
 		</a>
 	</li>
 
 	{% if USER_RANK_IMG %}<li>{{ USER_RANK_TITLE }}<br />{{ USER_RANK_IMG }}</li>{% endif %}
 	{% if S_LAST_VISIT %}<li class="double-space">{{ S_LAST_VISIT }}</li>{% endif %}
-	{% if S_CURRENT_TIME %}<li class="double-space">{{ S_CURRENT_TIME }}</li>{% endif %}
+	<!-- {% if S_CURRENT_TIME %}<li class="double-space">{{ S_CURRENT_TIME }}</li>{% endif %} -->
 	
 	{{ S_BLG_LOGIN_FIELDS }}
 </ul>
@@ -28,7 +28,7 @@
 
 <ul class="blg-menu blg-linear-list">
 {% for link in userlink %}
-	<li>
+	<li class="btn btn-default">
 		<i class="icon fa {% if link.ICON %}{{ link.ICON }}{% else %}fa-chevron-right{% endif %} fa-fw" aria-hidden="true"></i>
 		<a href="{{ link.URL }}">{{ link.TITLE }}</a>
 	</li>
diff --git "[ORIGINAL]/canidev\\blockgets/styles/FLATBOOTS/template/blocks/news_block.html" "[FORUM_EXT]/canidev\\blockgets/styles/FLATBOOTS/template/blocks/news_block.html"
--- "[ORIGINAL]/canidev\\blockgets/styles/FLATBOOTS/template/blocks/news_block.html"
+++ "[FORUM_EXT]/canidev\\blockgets/styles/FLATBOOTS/template/blocks/news_block.html"
@@ -27,20 +27,29 @@
 {% if news_row|length %}
 
 {% if not S_NEWS_FULL_CONTENT and not S_NEWS_COLLAPSE %}
-
-	<ul class="blg-linear-list">
+	<div class="blg-widget-header">
+		<span>{{ lang('TOPIC') }}</span>
+	</div>
+	<ul class="blg-linear-list news-block">
 	{% for topicrow in news_row %}
 		<li class="double-space">
+			<div class="desc-wrapper">
 				<div>
-				<i class="fa fa-bullhorn fa-lg" aria-hidden="true"></i>
 					{% EVENT topiclist_row_prepend %}
 					<a href="{{ topicrow.U_VIEW_TOPIC }}"><strong>{{ topicrow.TOPIC_TITLE }}</strong></a>
+					{% EVENT topiclist_row_append_portal %}
 				</div>
 				<div>
 					{{ lang('POSTED_BY') ~ lang('COLON') }}
 					<strong>{{ topicrow.TOPIC_AUTHOR_FULL }}</strong>
 					{% if BLOCK_VIEW_SMALL %}<br />{% else %}&bull;{% endif %} {{ topicrow.FIRST_POST_TIME }}
 				</div>
+				<div>
+						{L_LAST_REPLIED_BY}{L_COLON}
+						<strong>{{ topicrow.LAST_POST_AUTHOR_FULL }}</strong>
+						{% if BLOCK_VIEW_SMALL %}<br />{% else %}&bull;{% endif %} <span>{{ topicrow.LAST_POST_TIME }}</span>
+				</div>
+			</div>
 		</li>
 	{% endfor %}
 	</ul>
@@ -123,7 +132,7 @@
 
 {% if block_pagination|length %}
 	<div class="pull-right">	 
-		<ul class="pagination pagination-forum {% if BLOCK_VIEW_SMALL %}pagination-xs{% else %}pagination-sm{% endif %} hidden-xs">
+		<ul class="pagination pagination-forum {% if BLOCK_VIEW_SMALL %}pagination-xs{% else %}pagination-sm{% endif %}">
 		{% for pagination in block_pagination %}
 			{% if pagination.S_IS_PREV %}
 			<li class="previous"><a href="{{ pagination.PAGE_URL }}" rel="prev" role="button">{{ lang('PREVIOUS') }}</a></li>
diff --git "[ORIGINAL]/canidev\\blockgets/styles/FLATBOOTS/template/blocks/recent_topics_block.html" "[FORUM_EXT]/canidev\\blockgets/styles/FLATBOOTS/template/blocks/recent_topics_block.html"
--- "[ORIGINAL]/canidev\\blockgets/styles/FLATBOOTS/template/blocks/recent_topics_block.html"
+++ "[FORUM_EXT]/canidev\\blockgets/styles/FLATBOOTS/template/blocks/recent_topics_block.html"
@@ -91,17 +91,16 @@
 					{% EVENT viewforum_body_topicrow_row_before %}
 					<tr>
 						<td>
-							{% if topicrow.TOPIC_ICON_IMG %}
-							<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
-							{% endif %}
-
 							<span class="icon-wrapper">
 						    	<i class="row-icon-font icon-moon-default2{% if topicrow.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if topicrow.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if topicrow.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if topicrow.S_HAS_POLL %} icon-moon-poll{% endif %}{% if topicrow.S_TOPIC_MOVED %} icon-moon-moved{% endif %}{% if topicrow.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
 							</span>
 
 							<i class="row-icon-font-mini{% if topicrow.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
 
-							<div class="desc-wrapper">
+							<div class="desc-wrapper hidden-xs" style="padding:0">
+								{% if topicrow.TOPIC_ICON_IMG %}
+									<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+								{% endif %}
 					  		{% EVENT topiclist_row_prepend %}
 								{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}
 
@@ -109,11 +108,37 @@
 								<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
 					 		 	{% EVENT topiclist_row_append %}	
 							</div>
+							<div class="desc-wrapper visible-xs" style="padding:0">
+								{% if topicrow.TOPIC_ICON_IMG %}
+								<i class="topic-icon" style="margin:-8px;background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ topicrow.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ topicrow.TOPIC_FOLDER_IMG_ALT }}"></i>
+								{% endif %}
+					  			{% EVENT topiclist_row_prepend %}
+								<div>{% if topicrow.S_UNREAD_TOPIC %}<a href="{{ topicrow.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>&nbsp;{% endif %}{% if topicrow.U_VIEW_TOPIC %}<a href="{{ topicrow.U_VIEW_TOPIC }}" class="topictitle">{{ topicrow.TOPIC_TITLE }}</a>{% else %}{{ topicrow.TOPIC_TITLE }}{% endif %}</div>
+								{% if not S_IS_BOT %}
+									<a href="{{ topicrow.U_LAST_POST }}" title="{L_GOTO_LAST_POST}">
+										<i class="mobile-post fa fa-sign-out" aria-hidden="true"></i>
+									</a>
+								{% endif %}
+								{{ lang('POST_BY_AUTHOR') }}&nbsp;{{ topicrow.TOPIC_AUTHOR_FULL }} 
+								<small>&nbsp;&#45;&nbsp;{{ topicrow.FIRST_POST_TIME }}</small>
+							</div>
+							{% if not BLOCK_VIEW_MEDIUM %}
+								<div class="lastpost visible-xs">
+									<div class="nowrap-mobile">
+										<span>
+											<i class="fa fa-user"></i>&nbsp;<small>{{ topicrow.LAST_POST_AUTHOR_FULL }}</small>
+											<i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
+										</span>
+										
+									</div>
+								</div>
+							{% endif %}
 						</td>
 
 					{% if not BLOCK_VIEW_MEDIUM %}
-						<td class="fb-stats blg-align-center">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
-						<td class="lastpost">
+						<td class="fb-stats blg-align-center hidden-xs">{{ topicrow.VIEWS }} {{ lang('VIEWS') }}<br />{{ topicrow.REPLIES }} {{ lang('REPLIES') }}</td>
+						<td class="lastpost hidden-xs">
+							<span>
 								<i class="fa fa-user"></i>&nbsp;{{ lang('POST_BY_AUTHOR') }} {{ topicrow.LAST_POST_AUTHOR_FULL }}
 								{% if not S_IS_BOT %}
 									<a href="{{ topicrow.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">
@@ -121,6 +146,7 @@
 									</a>
 								{% endif %}
 								<br /><i class="fa fa-clock-o"></i>&nbsp;<small>{{ topicrow.LAST_POST_TIME }}</small>
+							</span>
 						</td>
 					{% endif %}
 					</tr>
diff --git "[ORIGINAL]/canidev\\blockgets/styles/FLATBOOTS/template/calendar_body.html" "[FORUM_EXT]/canidev\\blockgets/styles/FLATBOOTS/template/calendar_body.html"
--- "[ORIGINAL]/canidev\\blockgets/styles/FLATBOOTS/template/calendar_body.html"
+++ "[FORUM_EXT]/canidev\\blockgets/styles/FLATBOOTS/template/calendar_body.html"
@@ -48,7 +48,7 @@
 
 		<div class="btn-group">
 			<a href="{{ U_PREV }}" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
-			<a href="#" class="btn btn-default" data-action="month-select">{{ calendar.S_MONTH }}</a>
+			<a href="#" class="btn btn-default text-capitalize" data-action="month-select">{{ calendar.S_MONTH }}</a>
 			<a href="{{ U_NEXT }}" class="btn btn-default"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
 		</div>
 	</div>
diff --git "[ORIGINAL]/canidev\\blockgets/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html" "[FORUM_EXT]/canidev\\blockgets/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
--- "[ORIGINAL]/canidev\\blockgets/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
+++ "[FORUM_EXT]/canidev\\blockgets/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
@@ -1 +1 @@
-{% if U_SITE_HOME %}<li class="blg-breadcrumb-fix"></li>{% endif %}
\ No newline at end of file
+{% if U_SITE_HOME and SCRIPT_NAME == "portal" %}<li class="blg-breadcrumb-fix"></li>{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/canidev\\blockgets/styles/FLATBOOTS/theme/flatboots.css" "[FORUM_EXT]/canidev\\blockgets/styles/FLATBOOTS/theme/flatboots.css"
--- "[ORIGINAL]/canidev\\blockgets/styles/FLATBOOTS/theme/flatboots.css"
+++ "[FORUM_EXT]/canidev\\blockgets/styles/FLATBOOTS/theme/flatboots.css"
@@ -96,3 +96,17 @@ a.blg-admin-opener {
 	margin-bottom: 0;
 	margin-left: 0;
 }
+/* News Block
+-------------------------- */
+.blg-linear-list.news-block li.double-space {
+	display:flex;
+	margin:0!important;
+	border: 1px solid #e4e9eb;
+}
+.blg-linear-list.news-block li .desc-wrapper {
+	padding:10px 8px;
+	width: -webkit-fill-available;
+}
+.blg-linear-list.news-block li:first-child {
+	border-top: 4px solid #e4e9eb;
+}
diff --git "[ORIGINAL]/canidev\\blockgets/styles/all/template/blocks/calendar_block.html" "[FORUM_EXT]/canidev\\blockgets/styles/all/template/blocks/calendar_block.html"
--- "[ORIGINAL]/canidev\\blockgets/styles/all/template/blocks/calendar_block.html"
+++ "[FORUM_EXT]/canidev\\blockgets/styles/all/template/blocks/calendar_block.html"
@@ -44,7 +44,7 @@
 			<thead>
 			<tr>
 				<td class="blg-align-left">{% if calendar.S_FIRST_ROW %}<a href="#" data-calendar="{{ BLOCK_ID }}-{{ calendar.S_ROW_COUNT }}" data-action="prev"><i class="fa fa-arrow-circle-left fa-lg" aria-hidden="true"></i></a>{% else %}&nbsp;{% endif %}</td>
-				<td colspan="5" class="month-title blg-align-center"><a href="{{ calendar.U_ACTION }}">{{ calendar.S_MONTH }}</a></td>
+				<td colspan="5" class="month-title text-capitalize blg-align-center"><a href="{{ calendar.U_ACTION }}">{{ calendar.S_MONTH }}</a></td>
 				<td class="blg-align-right">{% if calendar.S_LAST_ROW %}<a href="#" data-calendar="{{ BLOCK_ID }}-{{ calendar.S_ROW_COUNT }}" data-action="next"><i class="fa fa-arrow-circle-right fa-lg" aria-hidden="true"></i></a>{% else %}&nbsp;{% endif %}</td>
 			</tr>
 			</thead>
diff --git "[ORIGINAL]/canidev\\blockgets/styles/all/template/blocks/gallery_block.html" "[FORUM_EXT]/canidev\\blockgets/styles/all/template/blocks/gallery_block.html"
--- "[ORIGINAL]/canidev\\blockgets/styles/all/template/blocks/gallery_block.html"
+++ "[FORUM_EXT]/canidev\\blockgets/styles/all/template/blocks/gallery_block.html"
@@ -51,7 +51,12 @@
 
 <div class="gallery">
 {% for image in loops.image %}
-	<a href="{{ image.ACTION }}" title="{{ image.TITLE }}" class="blank"><img src="{{ image.SRC }}" alt="{{ image.TITLE }}" /></a>
+	<a href="{{ image.ACTION }}" title="{% for prefix in image.prefix %}{{ prefix.NAME }}&nbsp;{% endfor %}{{ image.TITLE }}" class="blank ribbon-holder">
+		<img src="{{ image.SRC }}" alt="" />
+		<span class="ribbon ribbon-holder">
+			{% for prefix in image.prefix %}&nbsp;&nbsp;{{ prefix.NAME }}&nbsp;{% endfor %}
+		</span>
+	</a>
 {% endfor %}
 </div>
 {% endif %}
diff --git "[ORIGINAL]/canidev\\blockgets/styles/all/theme/common.css" "[FORUM_EXT]/canidev\\blockgets/styles/all/theme/common.css"
--- "[ORIGINAL]/canidev\\blockgets/styles/all/theme/common.css"
+++ "[FORUM_EXT]/canidev\\blockgets/styles/all/theme/common.css"
@@ -1767,10 +1767,10 @@ label.blg-share-button {
 	color: #7b95f2;
 }
 
-.medium-dark-theme .blg-block,
-.medium-dark-theme .blg-block a {
-	color: #000;
-}
+/* .medium-dark-theme .blg-block, */
+/* .medium-dark-theme .blg-block a { */
+	/* color: #000; */
+/* } */
 
 .medium-dark-theme .blg-block.style-alternative li.header dt,
 .medium-dark-theme .blg-block.style-alternative li.header a,
```
