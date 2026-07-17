Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\fltl/composer.json" "[FORUM_EXT]/sitesplat\\fltl/composer.json"
--- "[ORIGINAL]/sitesplat\\fltl/composer.json"
+++ "[FORUM_EXT]/sitesplat\\fltl/composer.json"
@@ -17,7 +17,7 @@
 		"composer/installers": "~1.0"
 	},
 	"extra": {
-		"display-name": "Fancy Lazy Topics Loader",
+		"display-name": "Fancy Lazy Topics Loader (Best Answer Edition)",
 		"soft-require": {
 			"phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
 		},
diff --git "[ORIGINAL]/sitesplat\\fltl/config/services.yml" "[FORUM_EXT]/sitesplat\\fltl/config/services.yml"
--- "[ORIGINAL]/sitesplat\\fltl/config/services.yml"
+++ "[FORUM_EXT]/sitesplat\\fltl/config/services.yml"
@@ -23,6 +23,7 @@ services:
             - '@user'
             - '@request'
             - '@dispatcher'
+            - '@ext.manager'
             - '%core.root_path%'
             - '%core.php_ext%'
 
diff --git "[ORIGINAL]/sitesplat\\fltl/controller/main.php" "[FORUM_EXT]/sitesplat\\fltl/controller/main.php"
--- "[ORIGINAL]/sitesplat\\fltl/controller/main.php"
+++ "[FORUM_EXT]/sitesplat\\fltl/controller/main.php"
@@ -20,10 +20,11 @@ class main
 	protected $user;
 	protected $request;
 	protected $dispatcher;
+	protected $ext_manager;
 	protected $phpbb_root_path;
 	protected $php_ext;
 
-	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher, $phpbb_root_path, $php_ext)
+	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\extension\manager $ext_manager, $phpbb_root_path, $php_ext)
 	{
 		$this->db = $db;
 		$this->auth = $auth;
@@ -31,6 +32,7 @@ class main
 		$this->user = $user;
 		$this->request = $request;
 		$this->dispatcher = $dispatcher;
+		$this->ext_manager = $ext_manager;
 		$this->root_path = $phpbb_root_path;
 		$this->php_ext = $php_ext;
 	}
@@ -63,10 +65,12 @@ class main
 		$total = $this->db->sql_fetchfield('total');
 		$this->db->sql_freeresult($result);	
 
+		if ($this->ext_manager->is_enabled('kinerity/bestanswer'))
+		{
 			$sql_ary = array(
 			'SELECT'	=> 'u.username, u.user_id, u.user_rank, u.user_posts, u.user_sig, u.user_avatar, u.user_avatar_type, u.user_avatar_width,
 							u.user_avatar_height, p.post_id, p.post_text, t.topic_id, t.forum_id, t.topic_title, t.topic_last_post_time,
-							t.topic_first_poster_colour, t.topic_last_post_id, t.topic_last_poster_name, t.topic_last_poster_colour, t.topic_posts_approved',
+							t.topic_first_poster_colour, t.topic_last_post_id, t.topic_last_poster_name, t.topic_last_poster_colour, t.topic_posts_approved, t.answer_post_id',
 			'FROM'		=> array(
 				TOPICS_TABLE	=> 't',
 				POSTS_TABLE		=> 'p',
@@ -79,6 +83,25 @@ class main
                 AND u.user_id = ' . $pid,
 			'ORDER_BY'	=> 't.topic_last_post_time DESC',
 		);
+		}
+		else 
+		{
+			$sql_ary = array(
+			'SELECT'	=> 'u.username, u.user_id, u.user_rank, u.user_posts, u.user_sig, u.user_avatar, u.user_avatar_type, u.user_avatar_width,
+							u.user_avatar_height, p.post_id, p.post_text, t.topic_id, t.forum_id, t.topic_title, t.topic_last_post_time,
+							t.topic_first_poster_colour, t.topic_last_post_id, t.topic_last_poster_name, t.topic_last_poster_colour, t.topic_posts_approved',
+			'FROM'		=> array(
+				TOPICS_TABLE	=> 't',
+				POSTS_TABLE		=> 'p',
+				USERS_TABLE		=> 'u',
+			),
+			'WHERE'		=> $forums_where . $recent_topics_where . '
+                AND p.post_visibility = 1
+				AND p.post_id = t.topic_' . $this->config['fltl_type'] . '_post_id
+                AND u.user_id = ' . $pid,
+			'ORDER_BY'	=> 't.topic_last_post_time DESC',
+		);
+		}
 
 		/**
 		* Event to modify SQL query before it is fired
@@ -119,6 +142,12 @@ class main
 			$url = generate_board_url() . '/';
 			foreach($rows as $row)
 			{
+				$bestanswer = '';
+				if (($this->ext_manager->is_enabled('kinerity/bestanswer')) && $row['answer_post_id'] ? true : false)
+				{
+					$bestanswer = '<span class="answered-icon-color" title="{L_ANSWERED}"><i class="fa fa-check"></i></span> ';
+				}
+				
 			    strip_bbcode($row['post_text']);
 				// switch for 3.2 and the new parser (not needed anymore)
 				// $row['post_text'] = (version_compare($this->config['version'], '3.2.*', '<')) ? censor_text($row['post_text']) : htmlentities(censor_text($row['post_text']));
@@ -147,7 +176,7 @@ class main
 						</div>
 						<div class="title">
 						 <header class="entry-header">
-						  <h6 class="inverse-font"><a title="" href="' . append_sid($url . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']) . '">' . censor_text($row['topic_title']) . '</a></h6>
+						  <h6 class="inverse-font"><a title="" href="' . append_sid($url . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']) . '">' . $bestanswer . censor_text($row['topic_title']) . '</a></h6>
 							<div class="entry-meta">
 							<span class="jp-views">' . (($row['user_avatar']) ? 
 								   str_replace(array('class="avatar"', 'alt=', './../../'), array('class="avatar_ftl" loading="lazy"', 'alt=', $url),
diff --git "[FORUM_EXT]/sitesplat\\fltl/diff_full.tmp" "[FORUM_EXT]/sitesplat\\fltl/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\fltl/diff_full.tmp"
@@ -0,0 +1,319 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/composer.json"
+index a3d6b5a3b..715d4a9e9 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/composer.json"
+@@ -17,7 +17,7 @@
+ 		"composer/installers": "~1.0"
+ 	},
+ 	"extra": {
+-		"display-name": "Fancy Lazy Topics Loader",
++		"display-name": "Fancy Lazy Topics Loader (Best Answer Edition)",
+ 		"soft-require": {
+ 			"phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
+ 		},
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/config/services.yml"
+index 8abff89ed..feb6b3a1d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/config/services.yml"
+@@ -23,6 +23,7 @@ services:
+             - '@user'
+             - '@request'
+             - '@dispatcher'
++            - '@ext.manager'
+             - '%core.root_path%'
+             - '%core.php_ext%'
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/controller/main.php"
+index 4dc549d0b..ed26d7d5c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/controller/main.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/controller/main.php"
+@@ -20,10 +20,11 @@ class main
+ 	protected $user;
+ 	protected $request;
+ 	protected $dispatcher;
++	protected $ext_manager;
+ 	protected $phpbb_root_path;
+ 	protected $php_ext;
+ 
+-	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher, $phpbb_root_path, $php_ext)
++	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\extension\manager $ext_manager, $phpbb_root_path, $php_ext)
+ 	{
+ 		$this->db = $db;
+ 		$this->auth = $auth;
+@@ -31,6 +32,7 @@ class main
+ 		$this->user = $user;
+ 		$this->request = $request;
+ 		$this->dispatcher = $dispatcher;
++		$this->ext_manager = $ext_manager;
+ 		$this->root_path = $phpbb_root_path;
+ 		$this->php_ext = $php_ext;
+ 	}
+@@ -55,15 +57,36 @@ class main
+ 
+ 		$sql = 'SELECT COUNT(p.post_id) AS total
+                 FROM ' . TOPICS_TABLE . ' t, ' . POSTS_TABLE . ' p
+-				WHERE ' . $forums_where . $recent_topics_where . '
+-				AND p.forum_id = t.forum_id
++                WHERE ' . $forums_where . $recent_topics_where . '
++                AND p.forum_id = t.forum_id
+                 AND p.post_visibility = 1
+-				AND p.post_id = t.topic_' . $this->config['fltl_type'] . '_post_id';
++                AND p.post_id = t.topic_' . $this->config['fltl_type'] . '_post_id';
+ 		$result = $this->db->sql_query($sql);
+ 		$total = $this->db->sql_fetchfield('total');
+ 		$this->db->sql_freeresult($result);	
+ 
+-		$sql_ary = array(
++		if ($this->ext_manager->is_enabled('kinerity/bestanswer'))
++		{
++			$sql_ary = array(
++			'SELECT'	=> 'u.username, u.user_id, u.user_rank, u.user_posts, u.user_sig, u.user_avatar, u.user_avatar_type, u.user_avatar_width,
++							u.user_avatar_height, p.post_id, p.post_text, t.topic_id, t.forum_id, t.topic_title, t.topic_last_post_time,
++							t.topic_first_poster_colour, t.topic_last_post_id, t.topic_last_poster_name, t.topic_last_poster_colour, t.topic_posts_approved, t.answer_post_id',
++			'FROM'		=> array(
++				TOPICS_TABLE	=> 't',
++				POSTS_TABLE		=> 'p',
++				USERS_TABLE		=> 'u',
++			),
++			'WHERE'		=> $forums_where . $recent_topics_where . '
++                AND p.post_visibility = 1
++                AND p.forum_id = t.forum_id
++                AND p.post_id = t.topic_' . $this->config['fltl_type'] . '_post_id
++                AND u.user_id = ' . $pid,
++			'ORDER_BY'	=> 't.topic_last_post_time DESC',
++		);
++		}
++		else 
++		{
++			$sql_ary = array(
+ 			'SELECT'	=> 'u.username, u.user_id, u.user_rank, u.user_posts, u.user_sig, u.user_avatar, u.user_avatar_type, u.user_avatar_width,
+ 							u.user_avatar_height, p.post_id, p.post_text, t.topic_id, t.forum_id, t.topic_title, t.topic_last_post_time,
+ 							t.topic_first_poster_colour, t.topic_last_post_id, t.topic_last_poster_name, t.topic_last_poster_colour, t.topic_posts_approved',
+@@ -74,11 +97,11 @@ class main
+ 			),
+ 			'WHERE'		=> $forums_where . $recent_topics_where . '
+                 AND p.post_visibility = 1
+-				AND p.forum_id = t.forum_id
+ 				AND p.post_id = t.topic_' . $this->config['fltl_type'] . '_post_id
+                 AND u.user_id = ' . $pid,
+ 			'ORDER_BY'	=> 't.topic_last_post_time DESC',
+ 		);
++		}
+ 
+ 		/**
+ 		* Event to modify SQL query before it is fired
+@@ -119,9 +142,15 @@ class main
+ 			$url = generate_board_url() . '/';
+ 			foreach($rows as $row)
+ 			{
++				$bestanswer = '';
++				if (($this->ext_manager->is_enabled('kinerity/bestanswer')) && $row['answer_post_id'] ? true : false)
++				{
++					$bestanswer = '<span class="answered-icon-color" title="{L_ANSWERED}"><i class="fa fa-check"></i></span> ';
++				}
++				
+ 			    strip_bbcode($row['post_text']);
+ 				// switch for 3.2 and the new parser (not needed anymore)
+-	//			$row['post_text'] = (version_compare($this->config['version'], '3.2.*', '<')) ? censor_text($row['post_text']) : htmlentities(censor_text($row['post_text']));
++				// $row['post_text'] = (version_compare($this->config['version'], '3.2.*', '<')) ? censor_text($row['post_text']) : htmlentities(censor_text($row['post_text']));
+ 				$row['post_text'] = censor_text($row['post_text']);
+ 				$row['post_text'] = (utf8_strlen($row['post_text']) > 50) ? utf8_substr($row['post_text'], 0, 50) . '&#91;&hellip;&#93;' : $row['post_text'];
+ 
+@@ -147,7 +176,7 @@ class main
+ 						</div>
+ 						<div class="title">
+ 						 <header class="entry-header">
+-						  <h6 class="inverse-font"><a title="" href="' . append_sid($url . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']) . '">' . censor_text($row['topic_title']) . '</a></h6>
++						  <h6 class="inverse-font"><a title="" href="' . append_sid($url . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']) . '">' . $bestanswer . censor_text($row['topic_title']) . '</a></h6>
+ 							<div class="entry-meta">
+ 							<span class="jp-views">' . (($row['user_avatar']) ? 
+ 								   str_replace(array('class="avatar"', 'alt=', './../../'), array('class="avatar_ftl" loading="lazy"', 'alt=', $url),
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/diff_full.tmp"
+new file mode 100644
+index 000000000..e1b4ace86
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/diff_full.tmp"
+@@ -0,0 +1,74 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/composer.json"
++index a3d6b5a3b..715d4a9e9 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/composer.json"
++@@ -17,7 +17,7 @@
++ 		"composer/installers": "~1.0"
++ 	},
++ 	"extra": {
++-		"display-name": "Fancy Lazy Topics Loader",
+++		"display-name": "Fancy Lazy Topics Loader (Best Answer Edition)",
++ 		"soft-require": {
++ 			"phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
++ 		},
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/config/services.yml"
++index 8abff89ed..feb6b3a1d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/config/services.yml"
++@@ -23,6 +23,7 @@ services:
++             - '@user'
++             - '@request'
++             - '@dispatcher'
+++            - '@ext.manager'
++             - '%core.root_path%'
++             - '%core.php_ext%'
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/controller/main.php"
++index 4dc549d0b..ed26d7d5c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/controller/main.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/controller/main.php"
++@@ -20,10 +20,11 @@ class main
++ 	protected $user;
++ 	protected $request;
++ 	protected $dispatcher;
+++	protected $ext_manager;
++ 	protected $phpbb_root_path;
++ 	protected $php_ext;
++ 
++-	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher, $phpbb_root_path, $php_ext)
+++	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\extension\manager $ext_manager, $phpbb_root_path, $php_ext)
++ 	{
++ 		$this->db = $db;
++ 		$this->auth = $auth;
++@@ -31,6 +32,7 @@ class main
++ 		$this->user = $user;
++ 		$this->request = $request;
++ 		$this->dispatcher = $dispatcher;
+++		$this->ext_manager = $ext_manager;
++ 		$this->root_path = $phpbb_root_path;
++ 		$this->php_ext = $php_ext;
++ 	}
++@@ -55,15 +57,36 @@ class main
++ 
++ 		$sql = 'SELECT COUNT(p.post_id) AS total
++                 FROM ' . TOPICS_TABLE . ' t, ' . POSTS_TABLE . ' p
++-				WHERE ' . $forums_where . $recent_topics_where . '
++-				AND p.forum_id = t.forum_id
+++                WHERE ' . $forums_where . $recent_topics_where . '
+++                AND p.forum_id = t.forum_id
++                 AND p.post_visibility = 1
++-				AND p.post_id = t.topic_' . $this->config['fltl_type'] . '_post_id';
+++                AND p.post_id = t.topic_' . $this->config['fltl_type'] . '_post_id';
++ 		$result = $this->db->sql_query($sql);
++ 		$total = $this->db->sql_fetchfield('total');
++ 		$this->db->sql_freeresult($result);	
++ 
++-		$sql_ary = array(
+++		if ($this->ext_manager->is_enabled('kinerity/bestanswer'))
+++		{
+++			$sql_ary = array(
+++			'SELECT'	=> 'u.username, u.user_id, u.user_rank, u.user_posts, u.user_sig, u.user_avatar, u.user_avatar_type, u.user_avatar_width,
+++							u.user_avatar_height, p.post_id, p.post_text, t.topic_id, t.forum_id, t.topic_title, t.topic_last_post_time,
+++							t.topic_first_poster_colour, t.topic_last_post_id, t.topic_last_poster_name, t.topic_last_poster_colour, t.topic_posts_approved, t.answer_post_id',
+++			'FROM'		=> array(
+++				TOPICS_TABLE	=> 't
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/event/admin_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/event/admin_listener.php"
+index d9ec06692..bba4886ed 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/event/admin_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/event/admin_listener.php"
+@@ -97,17 +97,8 @@ class admin_listener implements EventSubscriberInterface
+ 	{
+ 		global $config, $db;
+ 		$forum_excluded_aray = json_decode($config['fltl_excluded_forums'], true);
+-		$forum_options = '';
+-		
+-		$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE . ' WHERE forum_type = 1 ORDER BY forum_name';
+-		$result = $db->sql_query($sql);
+-		while ($row = $db->sql_fetchrow($result)) 
+-		{
+-			$forum_options .= '<option value="' . $row['forum_id'] . '"' . 
+-								((in_array($row['forum_id'], $forum_excluded_aray)) ? ' selected="selected"' : '') . '>' . $row['forum_name'] . '</option>';
+-		}
+-		return '<select multiple style="width:140px;" size="10" name="fltl_excluded_forums[]" id="fltl_excluded_forums" title="Exclude forums">' . $forum_options . '</select>';
+-
++		$forum_list = make_forum_select($forum_excluded_aray, false, true, true);
++		return '<select multiple style="width:140px;" size="10" name="fltl_excluded_forums[]" id="fltl_excluded_forums" title="Exclude forums">' . $forum_list . '</select>';
+ 	}
+ 
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/event/listener.php"
+index a64e00ab9..eb708a453 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/event/listener.php"
+@@ -66,13 +66,14 @@ class listener implements EventSubscriberInterface
+ 		}
+ 
+ 		$display = $this->phpbb_container->get('sitesplat.fltl.main');
++		$manager = $this->phpbb_container->get('ext.manager');
+ 		$rows = $display->handle('index.html');
+ 
+ 		foreach($rows['rows'] as $row)
+ 		{
+ 			strip_bbcode($row['post_text']);
+ 			// switch for 3.2 and the new parser (not needed anymore)
+-//			$row['post_text'] = (version_compare($this->config['version'], '3.2.*', '<')) ? censor_text($row['post_text']) : htmlentities(censor_text($row['post_text']));
++			// $row['post_text'] = (version_compare($this->config['version'], '3.2.*', '<')) ? censor_text($row['post_text']) : htmlentities(censor_text($row['post_text']));
+ 			$row['post_text'] = censor_text($row['post_text']);
+ 			$row['post_text'] = (utf8_strlen($row['post_text']) > 50) ? utf8_substr($row['post_text'], 0, 50) . '&#91;&hellip;&#93;' : $row['post_text'];
+ 	
+@@ -105,6 +106,7 @@ class listener implements EventSubscriberInterface
+ 				'TOPIC_YEAR_DIGIT'  => $this->user->format_date($row['topic_last_post_time'], 'Y', true),
+ 				'TOPIC_MONTH_DIGIT' => $this->user->format_date($row['topic_last_post_time'], 'm', true),
+ 				'TOPIC_DAY_DIGIT'   => $this->user->format_date($row['topic_last_post_time'], 'd', true),
++				'TOPIC_ANSWERED'	=> ($manager->is_enabled('kinerity/bestanswer')) && $row['answer_post_id'] ? true : false,
+ 				'TOPIC_TITLE'		=> censor_text($row['topic_title']),
+ 				'TOPIC_REPLIES'		=> $row['topic_posts_approved'],
+ 				'FP_EXCERPT'		=> $row['post_text'],
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/language/en/info_acp_fltl.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/language/en/info_acp_fltl.php"
+index 2d51709d5..0ef4ccef0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/language/en/info_acp_fltl.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/language/en/info_acp_fltl.php"
+@@ -1,22 +1,21 @@
+ <?php
++
+ /**
+-*
+-* Fancy Lazy Topics Loader
+-* @copyright (c) 2015 SiteSplat All rights reserved
+-* @license Proprietary
+-*
+-*/
++ *
++ * Fancy Lazy Topics Loader
++ * @copyright (c) 2015 SiteSplat All rights reserved
++ * @license Proprietary
++ *
++ */
+ 
+ /**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB'))
+-{
++ * DO NOT CHANGE
++ */
++if (!defined('IN_PHPBB')) {
+ 	exit;
+ }
+ 
+-if ( empty($lang) || !is_array($lang) )
+-{
++if (empty($lang) || !is_array($lang)) {
+ 	$lang = array();
+ }
+ 
+@@ -25,4 +24,3 @@ $lang = array_merge($lang, array(
+ 	'FLTL_NOTICE'				    => '<div class="phpinfo"><p>The settings for this extensions are in <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
+ 	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+ ));
+-
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/styles/FLATBOOTS/template/event/fltl.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/styles/FLATBOOTS/template/event/fltl.html"
+index 418419df6..f1e319aab 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/styles/FLATBOOTS/template/event/fltl.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/styles/FLATBOOTS/template/event/fltl.html"
+@@ -11,7 +11,7 @@
+ 				</div>
+ 				<div class="title">
+ 				 <header class="entry-header">
+-				  <h6 class="inverse-font"><a title="" href="{fltl.U_TOPIC}">{fltl.TOPIC_TITLE}</a></h6>
++				  <h6 class="inverse-font"><a title="" href="{fltl.U_TOPIC}"><!-- IF fltl.TOPIC_ANSWERED --><span class="answered-icon-color" title="{L_ANSWERED}"><i class="fa fa-check"></i></span> <!-- ENDIF -->{fltl.TOPIC_TITLE}</a></h6>
+ 					<div class="entry-meta">
+ 					 <span class="jp-views"><!-- IF fltl.AVATAR -->{fltl.AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/user4.png" alt="No avatar" loading="lazy" width="25" height="25"><!-- ENDIF -->{L_FLTL_BY}{fltl.TOPIC_AUTHOR}</span>
+ 					</div>
diff --git "[FORUM_EXT]/sitesplat\\fltl/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\fltl/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\fltl/diff_nospace.tmp"
@@ -0,0 +1,436 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/composer.json"
+index a3d6b5a3b..715d4a9e9 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/composer.json"
+@@ -17,7 +17,7 @@
+ 		"composer/installers": "~1.0"
+ 	},
+ 	"extra": {
+-		"display-name": "Fancy Lazy Topics Loader",
++		"display-name": "Fancy Lazy Topics Loader (Best Answer Edition)",
+ 		"soft-require": {
+ 			"phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
+ 		},
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/config/services.yml"
+index 8abff89ed..feb6b3a1d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/config/services.yml"
+@@ -23,6 +23,7 @@ services:
+             - '@user'
+             - '@request'
+             - '@dispatcher'
++            - '@ext.manager'
+             - '%core.root_path%'
+             - '%core.php_ext%'
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/controller/main.php"
+index 4dc549d0b..ed26d7d5c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/controller/main.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/controller/main.php"
+@@ -20,10 +20,11 @@ class main
+ 	protected $user;
+ 	protected $request;
+ 	protected $dispatcher;
++	protected $ext_manager;
+ 	protected $phpbb_root_path;
+ 	protected $php_ext;
+ 
+-	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher, $phpbb_root_path, $php_ext)
++	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\extension\manager $ext_manager, $phpbb_root_path, $php_ext)
+ 	{
+ 		$this->db = $db;
+ 		$this->auth = $auth;
+@@ -31,6 +32,7 @@ class main
+ 		$this->user = $user;
+ 		$this->request = $request;
+ 		$this->dispatcher = $dispatcher;
++		$this->ext_manager = $ext_manager;
+ 		$this->root_path = $phpbb_root_path;
+ 		$this->php_ext = $php_ext;
+ 	}
+@@ -63,10 +65,12 @@ class main
+ 		$total = $this->db->sql_fetchfield('total');
+ 		$this->db->sql_freeresult($result);	
+ 
++		if ($this->ext_manager->is_enabled('kinerity/bestanswer'))
++		{
+ 			$sql_ary = array(
+ 			'SELECT'	=> 'u.username, u.user_id, u.user_rank, u.user_posts, u.user_sig, u.user_avatar, u.user_avatar_type, u.user_avatar_width,
+ 							u.user_avatar_height, p.post_id, p.post_text, t.topic_id, t.forum_id, t.topic_title, t.topic_last_post_time,
+-							t.topic_first_poster_colour, t.topic_last_post_id, t.topic_last_poster_name, t.topic_last_poster_colour, t.topic_posts_approved',
++							t.topic_first_poster_colour, t.topic_last_post_id, t.topic_last_poster_name, t.topic_last_poster_colour, t.topic_posts_approved, t.answer_post_id',
+ 			'FROM'		=> array(
+ 				TOPICS_TABLE	=> 't',
+ 				POSTS_TABLE		=> 'p',
+@@ -79,6 +83,25 @@ class main
+                 AND u.user_id = ' . $pid,
+ 			'ORDER_BY'	=> 't.topic_last_post_time DESC',
+ 		);
++		}
++		else 
++		{
++			$sql_ary = array(
++			'SELECT'	=> 'u.username, u.user_id, u.user_rank, u.user_posts, u.user_sig, u.user_avatar, u.user_avatar_type, u.user_avatar_width,
++							u.user_avatar_height, p.post_id, p.post_text, t.topic_id, t.forum_id, t.topic_title, t.topic_last_post_time,
++							t.topic_first_poster_colour, t.topic_last_post_id, t.topic_last_poster_name, t.topic_last_poster_colour, t.topic_posts_approved',
++			'FROM'		=> array(
++				TOPICS_TABLE	=> 't',
++				POSTS_TABLE		=> 'p',
++				USERS_TABLE		=> 'u',
++			),
++			'WHERE'		=> $forums_where . $recent_topics_where . '
++                AND p.post_visibility = 1
++				AND p.post_id = t.topic_' . $this->config['fltl_type'] . '_post_id
++                AND u.user_id = ' . $pid,
++			'ORDER_BY'	=> 't.topic_last_post_time DESC',
++		);
++		}
+ 
+ 		/**
+ 		* Event to modify SQL query before it is fired
+@@ -119,6 +142,12 @@ class main
+ 			$url = generate_board_url() . '/';
+ 			foreach($rows as $row)
+ 			{
++				$bestanswer = '';
++				if (($this->ext_manager->is_enabled('kinerity/bestanswer')) && $row['answer_post_id'] ? true : false)
++				{
++					$bestanswer = '<span class="answered-icon-color" title="{L_ANSWERED}"><i class="fa fa-check"></i></span> ';
++				}
++				
+ 			    strip_bbcode($row['post_text']);
+ 				// switch for 3.2 and the new parser (not needed anymore)
+ 				// $row['post_text'] = (version_compare($this->config['version'], '3.2.*', '<')) ? censor_text($row['post_text']) : htmlentities(censor_text($row['post_text']));
+@@ -147,7 +176,7 @@ class main
+ 						</div>
+ 						<div class="title">
+ 						 <header class="entry-header">
+-						  <h6 class="inverse-font"><a title="" href="' . append_sid($url . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']) . '">' . censor_text($row['topic_title']) . '</a></h6>
++						  <h6 class="inverse-font"><a title="" href="' . append_sid($url . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']) . '">' . $bestanswer . censor_text($row['topic_title']) . '</a></h6>
+ 							<div class="entry-meta">
+ 							<span class="jp-views">' . (($row['user_avatar']) ? 
+ 								   str_replace(array('class="avatar"', 'alt=', './../../'), array('class="avatar_ftl" loading="lazy"', 'alt=', $url),
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/diff_full.tmp"
+new file mode 100644
+index 000000000..e44d54a81
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/diff_full.tmp"
+@@ -0,0 +1,319 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/composer.json"
++index a3d6b5a3b..715d4a9e9 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/composer.json"
++@@ -17,7 +17,7 @@
++ 		"composer/installers": "~1.0"
++ 	},
++ 	"extra": {
++-		"display-name": "Fancy Lazy Topics Loader",
+++		"display-name": "Fancy Lazy Topics Loader (Best Answer Edition)",
++ 		"soft-require": {
++ 			"phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
++ 		},
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/config/services.yml"
++index 8abff89ed..feb6b3a1d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/config/services.yml"
++@@ -23,6 +23,7 @@ services:
++             - '@user'
++             - '@request'
++             - '@dispatcher'
+++            - '@ext.manager'
++             - '%core.root_path%'
++             - '%core.php_ext%'
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/controller/main.php"
++index 4dc549d0b..ed26d7d5c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/controller/main.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/controller/main.php"
++@@ -20,10 +20,11 @@ class main
++ 	protected $user;
++ 	protected $request;
++ 	protected $dispatcher;
+++	protected $ext_manager;
++ 	protected $phpbb_root_path;
++ 	protected $php_ext;
++ 
++-	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher, $phpbb_root_path, $php_ext)
+++	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\extension\manager $ext_manager, $phpbb_root_path, $php_ext)
++ 	{
++ 		$this->db = $db;
++ 		$this->auth = $auth;
++@@ -31,6 +32,7 @@ class main
++ 		$this->user = $user;
++ 		$this->request = $request;
++ 		$this->dispatcher = $dispatcher;
+++		$this->ext_manager = $ext_manager;
++ 		$this->root_path = $phpbb_root_path;
++ 		$this->php_ext = $php_ext;
++ 	}
++@@ -55,15 +57,36 @@ class main
++ 
++ 		$sql = 'SELECT COUNT(p.post_id) AS total
++                 FROM ' . TOPICS_TABLE . ' t, ' . POSTS_TABLE . ' p
++-				WHERE ' . $forums_where . $recent_topics_where . '
++-				AND p.forum_id = t.forum_id
+++                WHERE ' . $forums_where . $recent_topics_where . '
+++                AND p.forum_id = t.forum_id
++                 AND p.post_visibility = 1
++-				AND p.post_id = t.topic_' . $this->config['fltl_type'] . '_post_id';
+++                AND p.post_id = t.topic_' . $this->config['fltl_type'] . '_post_id';
++ 		$result = $this->db->sql_query($sql);
++ 		$total = $this->db->sql_fetchfield('total');
++ 		$this->db->sql_freeresult($result);	
++ 
++-		$sql_ary = array(
+++		if ($this->ext_manager->is_enabled('kinerity/bestanswer'))
+++		{
+++			$sql_ary = array(
+++			'SELECT'	=> 'u.username, u.user_id, u.user_rank, u.user_posts, u.user_sig, u.user_avatar, u.user_avatar_type, u.user_avatar_width,
+++							u.user_avatar_height, p.post_id, p.post_text, t.topic_id, t.forum_id, t.topic_title, t.topic_last_post_time,
+++							t.topic_first_poster_colour, t.topic_last_post_id, t.topic_last_poster_name, t.topic_last_poster_colour, t.topic_posts_approved, t.answer_post_id',
+++			'FROM'		=> array(
+++				TOPICS_TABLE	=> 't',
+++				POSTS_TABLE		=> 'p',
+++				USERS_TABLE		=> 'u',
+++			),
+++			'WHERE'		=> $forums_where . $recent_topics_where . '
+++                AND p.post_visibility = 1
+++                AND p.forum_id = t.forum_id
+++                AND p.post_id = t.topic_' . $this->config['fltl_type'] . '_post_id
+++                AND u.user_id = ' . $pid,
+++			'ORDER_BY'	=> 't.topic_last_post_time DESC',
+++		);
+++		}
+++		else 
+++		{
+++			$sql_ary = array(
++ 			'SELECT'	=> 'u.username, u.user_id, u.user_rank, u.user_posts, u.user_sig, u.user_avatar, u.user_avatar_type, u.user_avatar_width,
++ 							u.user_avatar_height, p.post_id, p.post_text, t.topic_id, t.forum_id, t.topic_title, t.topic_last_post_time,
++ 							t.topic_first_poster_colour, t.topic_last_post_id, t.topic_last_poster_name, t.topic_last_poster_colour, t.topic_posts_approved',
++@@ -74,11 +97,11 @@ class main
++ 			),
++ 			'WHERE'		=> $forums_where . $recent_topics_where . '
++                 AND p.post_visibility = 1
++-				AND p.forum_id = t.forum_id
++ 				AND p.post_id = t.topic_' . $this->config['fltl_type'] . '_post_id
++                 AND u.user_id = ' . $pid,
++ 			'ORDER_BY'	=> 't.topic_last_post_time DESC',
++ 		);
+++		}
++ 
++ 		/**
++ 		* Event to modify SQL query before it is fired
++@@ -119,9 +142,15 @@ class main
++ 			$url = generate_board_url() . '/';
++ 			foreach($rows as $row)
++ 			{
+++				$bestanswer = '';
+++				if (($this->ext_manager->is_enabled('kinerity/bestanswer')) && $row['answer_post_id'] ? true : false)
+++				{
+++					$bestanswer = '<span class="answered-icon-color" title="{L_ANSWERED}"><i class="fa fa-check"></i></span> ';
+++				}
+++				
++ 			    strip_bbcode($row['post_text']);
++ 				// switch for 3.2 and the new parser (not needed anymore)
++-	//			$row['post_text'] = (version_compare($this->config['version'], '3.2.*', '<')) ? censor_text($row['post_text']) : htmlentities(censor_text($row['post_text']));
+++				// $row['post_text'] = (version_compare($this->config['version'], '3.2.*', '<')) ? censor_text($row['post_text']) : htmlentities(censor_text($row['post_text']));
++ 				$row['post_text'] = censor_text($row['post_text']);
++ 				$row['post_text'] = (utf8_strlen($row['post_text']) > 50) ? utf8_substr($row['post_text'], 0, 50) . '&#91;&hellip;&#93;' : $row['post_text'];
++ 
++@@ -147,7 +176,7 @@ class main
++ 						</div>
++ 						<div class="title">
++ 						 <header class="entry-header">
++-						  <h6 class="inverse-font"><a title="" href="' . append_sid($url . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']) . '">' . censor_text($row['topic_title']) . '</a></h6>
+++						  <h6 class="inverse-font"><a title="" href="' . append_sid($url . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']) . '">' . $bestanswer . censor_text($row['topic_title']) . '</a></h6>
++ 							<div class="entry-meta">
++ 							<span class="jp-views">' . (($row['user_avatar']) ? 
++ 								   str_replace(array('class="avatar"', 'alt=', './../../'), array('class="avatar_ftl" loading="lazy"', 'alt=', $url),
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/diff_full.tmp"
++new file mode 100644
++index 000000000..e1b4ace86
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/diff_full.tmp"
++@@ -0,0 +1,74 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/composer.json"
+++index a3d6b5a3b..715d4a9e9 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/composer.json"
+++@@ -17,7 +17,7 @@
+++ 		"composer/installers": "~1.0"
+++ 	},
+++ 	"extra": {
+++-		"display-name": "Fancy Lazy Topics Loader",
++++		"display-name": "Fancy Lazy Topics Loader (Best Answer Edition)",
+++ 		"soft-require": {
+++ 			"phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
+++ 		},
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/config/services.yml"
+++index 8abff89ed..feb6b3a1d 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/config/services.yml"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/config/services.yml"
+++@@ -23,6 +23,7 @@ services:
+++             - '@user'
+++             - '@request'
+++             - '@dispatcher'
++++            - '@ext.manager'
+++             - '%core.root_path%'
+++             - '%core.php_ext%'
+++ 
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/controller/main.php"
+++index 4dc549d0b..ed26d7d5c 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/controller/main.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/controller/main.php"
+++@@ -20,10 +20,11 @@ class main
+++ 	protected $user;
+++ 	protected $request;
+++ 	protected $dispatcher;
++++	protected $ext_manager;
+++ 	protected $phpbb_root_path;
+++ 	protected $php_ext;
+++ 
+++-	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher, $phpbb_root_path, $php_ext)
++++	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\extension\manager $ext_manager, $phpbb_root_path, $php_ext)
+++ 	{
+++ 		$this->db = $db;
+++ 		$this->auth = $auth;
+++@@ -31,6 +32,7 @@ class main
+++ 		$this->user = $user;
+++ 		$this->request = $request;
+++ 		$this->dispatcher = $dispatcher;
++++		$this->ext_manager = $ext_manager;
+++ 		$this->root_path = $phpbb_root_path;
+++ 		$this->php_ext = $php_ext;
+++ 	}
+++@@ -55,15 +57,36 @@ class main
+++ 
+++ 		$sql = 'SELECT COUNT(p.post_id) AS total
+++                 FROM ' . TOPICS_TABLE . ' t, ' . POSTS_TABLE . ' p
+++-				WHERE ' . $forums_where . $recent_topics_where . '
+++-				AND p.forum_id = t.forum_id
++++                WHERE ' . $forums_where . $recent_topics_where . '
++++                AND p.forum_id = t.forum_id
+++                 AND p.post_visibility = 1
+++-				AND p.post_id = t.topic_' . $this->config['fltl_type'] . '_post_id';
++++                AND p.post_id = t.topic_' . $this->config['fltl_type'] . '_post_id';
+++ 		$result = $this->db->sql_query($sql);
+++ 		$total = $this->db->sql_fetchfield('total');
+++ 		$this->db->sql_freeresult($result);	
+++ 
+++-		$sql_ary = array(
++++		if ($this->ext_manager->is_enabled('kinerity/bestanswer'))
++++		{
++++			$sql_ary = array(
++++			'SELECT'	=> 'u.username, u.user_id, u.user_rank, u.user_posts, u.user_sig, u.user_avatar, u.user_avatar_type, u.user_avatar_width,
++++							u.user_avatar_height, p.post_id, p.post_text, t.topic_id, t.forum_id, t.topic_title, t.topic_last_post_time,
++++							t.topic_first_poster_colour, t.topic_last_post_id, t.topic_last_poster_name, t.topic_last_poster_colour, t.topic_posts_approved, t.answer_post_id',
++++			'FROM'		=> array(
++++				TOPICS_TABLE	=> 't
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/event/admin_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/event/admin_listener.php"
++index d9ec06692..bba4886ed 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/event/admin_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/event/admin_listener.php"
++@@ -97,17 +97,8 @@ class admin_listener implements EventSubscriberInterface
++ 	{
++ 		global $config, $db;
++ 		$forum_excluded_aray = json_decode($config['fltl_excluded_forums'], true);
++-		$forum_options = '';
++-		
++-		$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE . ' WHERE forum_type = 1 ORDER BY forum_name';
++-		$result = $db->sql_query($sql);
++-		while ($row = $db->sql_fetchrow($result)) 
++-		{
++-			$forum_options .= '<option value="' . $row['forum_id'] . '"' . 
++-								((in_array($row['forum_id'], $forum_excluded_aray)) ? ' selected="selected"' : '') . '>' . $row['forum_name'] . '</option>';
++-		}
++-		return '<select multiple style="width:140px;" size="10" name="fltl_excluded_forums[]" id="fltl_excluded_forums" title="Exclude forums">' . $forum_options . '</select>';
++-
+++		$forum_list = make_forum_select($forum_excluded_aray, false, true, true);
+++		return '<select multiple style="width:140px;" size="10" name="fltl_excluded_forums[]" id="fltl_excluded_forums" title="Exclude forums">' . $forum_list . '</select>';
++ 	}
++ 
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/event/listener.php"
++index a64e00ab9..eb708a453 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/event/listener.php"
++@@ -66,13 +66,14 @@ class listener implements EventSubscriberInterface
++ 		}
++ 
++ 		$display = $this->phpbb_container->get('sitesplat.fltl.main');
+++		$manager = $this->phpbb_container->get('ext.manager');
++ 		$rows = $display->handle('index.html');
++ 
++ 		foreach($rows['rows'] as $row)
++ 		{
++ 			strip_bbcode($row['post_text']);
++ 			// switch for 3.2 and the new parser (not needed anymore)
++-//			$row['post_text'] = (version_compare($this->config['version'], '3.2.*', '<')) ? censor_text($row['post_text']) : htmlentities(censor_text($row['post_text']));
+++			// $row['post_text'] = (version_compare($this->config['version'], '3.2.*', '<')) ? censor_text($row['post_text']) : htmlentities(censor_text($row['post_text']));
++ 			$row['post_text'] = censor_text($row['post_text']);
++ 			$row['post_text'] = (utf8_strlen($row['post_text']) > 50) ? utf8_substr($row['post_text'], 0, 50) . '&#91;&hellip;&#93;' : $row['post_text'];
++ 	
++@@ -105,6 +106,7 @@ class listener implements EventSubscriberInterface
++ 				'TOPIC_YEAR_DIGIT'  => $this->user->format_date($row['topic_last_post_time'], 'Y', true),
++ 				'TOPIC_MONTH_DIGIT' => $this->user->format_date($row['topic_last_post_time'], 'm', true),
++ 				'TOPIC_DAY_DIGIT'   => $this->user->format_date($row['topic_last_post_time'], 'd', true),
+++				'TOPIC_ANSWERED'	=> ($manager->is_enabled('kinerity/bestanswer')) && $row['answer_post_id'] ? true : false,
++ 				'TOPIC_TITLE'		=> censor_text($row['topic_title']),
++ 				'TOPIC_REPLIES'		=> $row['topic_posts_approved'],
++ 				'FP_EXCERPT'		=> $row['post_text'],
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/language/en/info_acp_fltl.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/language/en/info_acp_fltl.php"
++index 2d51709d5..0ef4ccef0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/language/en/info_acp_fltl.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/language/en/info_acp_fltl.php"
++@@ -1,22 +1,21 @@
++ <?php
+++
++ /**
++-*
++-* Fancy Lazy Topics Loader
++-* @copyright (c) 2015 SiteSplat All rights reserved
++-* @license Proprietary
++-*
++-*/
+++ *
+++ * Fancy Lazy Topics Loader
+++ * @copyright (c) 2015 SiteSplat All rights reserved
+++ * @license Proprietary
+++ *
+++ */
++ 
++ /**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB'))
++-{
+++ * DO NOT CHANGE
+++ */
+++if (!defined('IN_PHPBB')) {
++ 	exit;
++ }
++ 
++-if ( empty($lang) || !is_array($lang) )
++-{
+++if (empty($lang) || !is_array($lang)) {
++ 	$lang = array();
++ }
++ 
++@@ -25,4 +24,3 @@ $lang = array_merge($lang, array(
++ 	'FLTL_NOTICE'				    => '<div class="phpinfo"><p>The settings for this extensions are in <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
++ 	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++ ));
++-
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/styles/FLATBOOTS/template/event/fltl.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/styles/FLATBOOTS/template/event/fltl.html"
++index 418419df6..f1e319aab 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\fltl/styles/FLATBOOTS/template/event/fltl.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\fltl/styles/FLATBOOTS/template/event/fltl.html"
++@@ -11,7 +11,7 @@
++ 				</div>
++ 				<div class="title">
++ 				 <header class="entry-header">
++-				  <h6 class="inverse-font"><a title="" href="{fltl.U_TOPIC}">{fltl.TOPIC_TITLE}</a></h6>
+++				  <h6 class="inverse-font"><a title="" href="{fltl.U_TOPIC}"><!-- IF fltl.TOPIC_ANSWERED --><span class="answered-icon-color" title="{L_ANSWERED}"><i class="fa fa-check"></i></span> <!-- ENDIF -->{fltl.TOPIC_TITLE}</a></h6>
++ 					<div class="entry-meta">
++ 					 <span class="jp-views"><!-- IF fltl.AVATAR -
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\fltl/event/admin_listener.php" "[FORUM_EXT]/sitesplat\\fltl/event/admin_listener.php"
--- "[ORIGINAL]/sitesplat\\fltl/event/admin_listener.php"
+++ "[FORUM_EXT]/sitesplat\\fltl/event/admin_listener.php"
@@ -97,17 +97,8 @@ class admin_listener implements EventSubscriberInterface
 	{
 		global $config, $db;
 		$forum_excluded_aray = json_decode($config['fltl_excluded_forums'], true);
-		$forum_options = '';
-		
-		$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE . ' WHERE forum_type = 1 ORDER BY forum_name';
-		$result = $db->sql_query($sql);
-		while ($row = $db->sql_fetchrow($result)) 
-		{
-			$forum_options .= '<option value="' . $row['forum_id'] . '"' . 
-								((in_array($row['forum_id'], $forum_excluded_aray)) ? ' selected="selected"' : '') . '>' . $row['forum_name'] . '</option>';
-		}
-		return '<select multiple style="width:140px;" size="10" name="fltl_excluded_forums[]" id="fltl_excluded_forums" title="Exclude forums">' . $forum_options . '</select>';
-
+		$forum_list = make_forum_select($forum_excluded_aray, false, true, true);
+		return '<select multiple style="width:140px;" size="10" name="fltl_excluded_forums[]" id="fltl_excluded_forums" title="Exclude forums">' . $forum_list . '</select>';
 	}
 
 }
diff --git "[ORIGINAL]/sitesplat\\fltl/event/listener.php" "[FORUM_EXT]/sitesplat\\fltl/event/listener.php"
--- "[ORIGINAL]/sitesplat\\fltl/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\fltl/event/listener.php"
@@ -66,6 +66,7 @@ class listener implements EventSubscriberInterface
 		}
 
 		$display = $this->phpbb_container->get('sitesplat.fltl.main');
+		$manager = $this->phpbb_container->get('ext.manager');
 		$rows = $display->handle('index.html');
 
 		foreach($rows['rows'] as $row)
@@ -105,6 +106,7 @@ class listener implements EventSubscriberInterface
 				'TOPIC_YEAR_DIGIT'  => $this->user->format_date($row['topic_last_post_time'], 'Y', true),
 				'TOPIC_MONTH_DIGIT' => $this->user->format_date($row['topic_last_post_time'], 'm', true),
 				'TOPIC_DAY_DIGIT'   => $this->user->format_date($row['topic_last_post_time'], 'd', true),
+				'TOPIC_ANSWERED'	=> ($manager->is_enabled('kinerity/bestanswer')) && $row['answer_post_id'] ? true : false,
 				'TOPIC_TITLE'		=> censor_text($row['topic_title']),
 				'TOPIC_REPLIES'		=> $row['topic_posts_approved'],
 				'FP_EXCERPT'		=> $row['post_text'],
diff --git "[ORIGINAL]/sitesplat\\fltl/language/en/info_acp_fltl.php" "[FORUM_EXT]/sitesplat\\fltl/language/en/info_acp_fltl.php"
--- "[ORIGINAL]/sitesplat\\fltl/language/en/info_acp_fltl.php"
+++ "[FORUM_EXT]/sitesplat\\fltl/language/en/info_acp_fltl.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
  *
  * Fancy Lazy Topics Loader
@@ -10,13 +11,11 @@
 /**
  * DO NOT CHANGE
  */
-if (!defined('IN_PHPBB'))
-{
+if (!defined('IN_PHPBB')) {
 	exit;
 }
 
-if ( empty($lang) || !is_array($lang) )
-{
+if (empty($lang) || !is_array($lang)) {
 	$lang = array();
 }
 
@@ -25,4 +24,3 @@ $lang = array_merge($lang, array(
 	'FLTL_NOTICE'				    => '<div class="phpinfo"><p>The settings for this extensions are in <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
 	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
 ));
-
diff --git "[ORIGINAL]/sitesplat\\fltl/styles/FLATBOOTS/template/event/fltl.html" "[FORUM_EXT]/sitesplat\\fltl/styles/FLATBOOTS/template/event/fltl.html"
--- "[ORIGINAL]/sitesplat\\fltl/styles/FLATBOOTS/template/event/fltl.html"
+++ "[FORUM_EXT]/sitesplat\\fltl/styles/FLATBOOTS/template/event/fltl.html"
@@ -11,7 +11,7 @@
 				</div>
 				<div class="title">
 				 <header class="entry-header">
-				  <h6 class="inverse-font"><a title="" href="{fltl.U_TOPIC}">{fltl.TOPIC_TITLE}</a></h6>
+				  <h6 class="inverse-font"><a title="" href="{fltl.U_TOPIC}"><!-- IF fltl.TOPIC_ANSWERED --><span class="answered-icon-color" title="{L_ANSWERED}"><i class="fa fa-check"></i></span> <!-- ENDIF -->{fltl.TOPIC_TITLE}</a></h6>
 					<div class="entry-meta">
 					 <span class="jp-views"><!-- IF fltl.AVATAR -->{fltl.AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/user4.png" alt="No avatar" loading="lazy" width="25" height="25"><!-- ENDIF -->{L_FLTL_BY}{fltl.TOPIC_AUTHOR}</span>
 					</div>
```
