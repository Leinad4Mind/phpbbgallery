Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\bblinks/config/services.yml" "[FORUM_EXT]/sitesplat\\bblinks/config/services.yml"
--- "[ORIGINAL]/sitesplat\\bblinks/config/services.yml"
+++ "[FORUM_EXT]/sitesplat\\bblinks/config/services.yml"
@@ -8,6 +8,7 @@ services:
             - '@auth'
             - '@dbal.conn'
             - '%core.php_ext%'
+            - '@service_container'
 
     sitesplat.bblinks.listener:
         class: sitesplat\bblinks\event\main_listener
@@ -15,6 +16,7 @@ services:
             - '@sitesplat.bblinks.bblinks'
             - '@config'
             - '@template'
+            - '@dispatcher'
             - '@dbal.conn'
         tags:
             - { name: event.listener }
diff --git "[ORIGINAL]/sitesplat\\bblinks/core/bblinks.php" "[FORUM_EXT]/sitesplat\\bblinks/core/bblinks.php"
--- "[ORIGINAL]/sitesplat\\bblinks/core/bblinks.php"
+++ "[FORUM_EXT]/sitesplat\\bblinks/core/bblinks.php"
@@ -20,7 +20,10 @@ class bblinks
     protected $link_type_classes;
     protected $ids_to_fetch;
     protected $infos;
-    public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $php_ext)
+    protected $manager;
+    protected $container;
+
+    public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $php_ext, \Symfony\Component\DependencyInjection\Container $container)
     {
         $this->config = $config;
         $this->config_text = $config_text;
@@ -28,6 +31,7 @@ class bblinks
         $this->auth = $auth;
         $this->db = $db;
         $this->php_ext = $php_ext;
+		$this->container = $container;
         $this->link_type_classes = array(
             'pdf'	                => 'pdf-link',
             'gif|jpg|jpeg|png|bmp'	=> 'img-link',
@@ -46,6 +50,26 @@ class bblinks
 		define('LOCALURLTOTEXT_TYPE_USER', 4);
     }
 
+	/**
+	 * Lazy load the BbPrefix Manager
+	 * @return mixed The manager service or null if not found
+	 */
+	protected function getBbPrefixManager()
+	{
+		// If we already loaded it, return it immediately
+		if ($this->manager !== null) {
+			return $this->manager;
+		}
+
+		// Otherwise, try to load it from the container
+		if ($this->container && $this->container->has('bbprefix.manager')) {
+			$this->manager = $this->container->get('bbprefix.manager');
+			return $this->manager;
+		}
+
+		return null;
+	}
+
     public function modify_links($message = '')
 	{
         // A quick check before we start using regular expressions
@@ -54,6 +78,7 @@ class bblinks
             return $message;
         }
 
+        $forbidden_domains = $this->config_text->get('bblinks_forbidden_domains');
         preg_match_all('#(<a\s[^>]+?>)(.*?</a>)#i', $message, $matches, PREG_SET_ORDER);
         foreach ($matches as $links)
         {
@@ -84,7 +109,7 @@ class bblinks
             $is_local = ($this->config['bblinks_external_link_types'] && preg_match('/\.(?:' . $this->config['bblinks_external_link_types'] . ')(?:[#?]|$)/', $href)) ? false : $is_local;
             if ($is_local === null)
             {
-                if ($this->config_text->get('bblinks_forbidden_domains') && $this->match_domain($href, $this->config_text->get('bblinks_forbidden_domains')))
+                if ($forbidden_domains && $this->match_domain($href, $forbidden_domains))
                 {
                     $searches[] = $link;
                     $replacements[] = $this->insert_attribute('href', $this->config['bblinks_forbidden_new_url'], $new_link, true);
@@ -313,7 +338,7 @@ class bblinks
 			if (sizeof($this->ids_to_fetch['post']))
 			{
 				$sql_ary = array(
-					'SELECT'		=> 'p.post_id, p.post_subject, t.topic_id, t.topic_title, f.forum_id, f.forum_name, u.user_id, u.username, u.user_colour',
+					'SELECT'		=> 'p.post_id, p.post_subject, t.topic_id, t.topic_title, t.bbpoints_payed, f.forum_id, f.forum_name, u.user_id, u.username, u.user_colour',
 					'FROM'			=> array(POSTS_TABLE => 'p'),
 					'LEFT_JOIN'		=> array(
 						array(
@@ -339,7 +364,7 @@ class bblinks
 			if ($this->ids_to_fetch['topic'])
 			{
 				$sql_ary = array(
-					'SELECT'		=> 't.topic_id, t.topic_title, f.forum_id, f.forum_name',
+					'SELECT'		=> 't.topic_id, t.topic_title, f.forum_id, f.forum_name, t.bbpoints_payed',
 					'FROM'			=> array(TOPICS_TABLE => 't'),
 					'LEFT_JOIN'		=> array(
 						array(
@@ -432,6 +457,45 @@ class bblinks
 					case LOCALURLTOTEXT_TYPE_TOPIC:
 						if (isset($this->infos['topic'][$match['id']]))
 						{
+							$paid = (int) ($this->infos['topic'][$match['id']]['paid'] ?? 0);
+
+							$paid_html = '';
+							if ($paid > 0)
+							{
+								$paid_html = '<span class="label label-success"><i class="fa fa-eye-slash"></i>&nbsp;' 
+										   . $paid . '&nbsp;' . $this->user->lang('BBPOINTS') . '</span>&nbsp;';
+							}
+
+							$manager = $this->getBbPrefixManager();
+							if ($manager && method_exists($manager, 'load_prefixes_topic'))
+							{
+								$manager->load_prefix_instances(true);
+								$prefix = $manager->load_prefixes_topic($match['id'], '', true);
+
+								$current_forum_id = 0;
+								if (isset($GLOBALS['forum_data']['forum_id']))
+								{
+									$current_forum_id = (int) $GLOBALS['forum_data']['forum_id'];
+								}
+								else if (isset($GLOBALS['topic_data']['forum_id']))
+								{
+									$current_forum_id = (int) $GLOBALS['topic_data']['forum_id'];
+								}
+								
+								if ($current_forum_id === 77 || $current_forum_id === 99)
+								{
+									// 4: $this->infos['topic'][$match['id']]['title'] =  '<div style="display:flex;justify-content:space-between;align-items:center;padding-left:5px;"><div>' . $this->infos['topic'][$match['id']]['title'] . '</div><div><div style="display:flex;justify-content:flex-end;">'  . $prefix . '</div><div style="display:flex;justify-content:end;align-items:center;">' . $paid_html . '</div></div></div>';
+									$this->infos['topic'][$match['id']]['title'] =  '<div style="display:flex;justify-content:space-between;padding-left:5px;"><div style="display:inline-flex;align-items:center;">' . $this->infos['topic'][$match['id']]['title'] . '&nbsp;' . $paid_html . '</div><div>' . $prefix . '</div></div>';
+								}
+								else
+								{
+									$this->infos['topic'][$match['id']]['title'] =  $paid_html . $prefix . $this->infos['topic'][$match['id']]['title'];
+								}
+							}
+							
+
+							$topic_title_full = $this->infos['topic'][$match['id']]['title'];
+
 							$text = str_replace(
 								$match[0],
 								$match['anchor'] . str_replace(
@@ -440,7 +504,7 @@ class bblinks
 										'{FORUM_NAME}',
 									),
 									array(
-										$this->infos['topic'][$match['id']]['title'],
+										$topic_title_full,
 										$this->infos['forum'][$this->infos['topic'][$match['id']]['forum_id']]['name'],
 									),
 									htmlspecialchars_decode($this->config['bblinks_urltotext_topic'])
@@ -515,6 +579,7 @@ class bblinks
 				{
 					$this->infos['topic'][$row['topic_id']] = array(
 						'title'		=> $row['topic_title'],
+						'paid'		=> $row['bbpoints_payed'],
 						'forum_id'	=> $row['forum_id'],
 					);
 				}
diff --git "[FORUM_EXT]/sitesplat\\bblinks/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bblinks/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bblinks/diff_full.tmp"
@@ -0,0 +1,322 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/config/services.yml"
+index 1fe7e40b8..a1cec908d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/config/services.yml"
+@@ -8,6 +8,7 @@ services:
+             - '@auth'
+             - '@dbal.conn'
+             - '%core.php_ext%'
++            - '@service_container'
+ 
+     sitesplat.bblinks.listener:
+         class: sitesplat\bblinks\event\main_listener
+@@ -15,6 +16,7 @@ services:
+             - '@sitesplat.bblinks.bblinks'
+             - '@config'
+             - '@template'
++            - '@dispatcher'
+             - '@dbal.conn'
+         tags:
+             - { name: event.listener }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/core/bblinks.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/core/bblinks.php"
+index e32f9f1bd..a34f02473 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/core/bblinks.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/core/bblinks.php"
+@@ -20,7 +20,10 @@ class bblinks
+     protected $link_type_classes;
+     protected $ids_to_fetch;
+     protected $infos;
+-    public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $php_ext)
++    protected $manager;
++    protected $container;
++
++    public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $php_ext, \Symfony\Component\DependencyInjection\Container $container)
+     {
+         $this->config = $config;
+         $this->config_text = $config_text;
+@@ -28,6 +31,7 @@ class bblinks
+         $this->auth = $auth;
+         $this->db = $db;
+         $this->php_ext = $php_ext;
++		$this->container = $container;
+         $this->link_type_classes = array(
+             'pdf'	                => 'pdf-link',
+             'gif|jpg|jpeg|png|bmp'	=> 'img-link',
+@@ -39,13 +43,33 @@ class bblinks
+ 			$this->ids_to_fetch[$resource]	= array();
+ 			$this->infos[$resource]			= array();
+         }
+-        
++
+         define('LOCALURLTOTEXT_TYPE_FORUM', 1);
+ 		define('LOCALURLTOTEXT_TYPE_TOPIC', 2);
+ 		define('LOCALURLTOTEXT_TYPE_POST', 3);
+ 		define('LOCALURLTOTEXT_TYPE_USER', 4);
+     }
+ 
++	/**
++	 * Lazy load the BbPrefix Manager
++	 * @return mixed The manager service or null if not found
++	 */
++	protected function getBbPrefixManager()
++	{
++		// If we already loaded it, return it immediately
++		if ($this->manager !== null) {
++			return $this->manager;
++		}
++
++		// Otherwise, try to load it from the container
++		if ($this->container && $this->container->has('bbprefix.manager')) {
++			$this->manager = $this->container->get('bbprefix.manager');
++			return $this->manager;
++		}
++
++		return null;
++	}
++
+     public function modify_links($message = '')
+ 	{
+         // A quick check before we start using regular expressions
+@@ -54,6 +78,7 @@ class bblinks
+             return $message;
+         }
+ 
++        $forbidden_domains = $this->config_text->get('bblinks_forbidden_domains');
+         preg_match_all('#(<a\s[^>]+?>)(.*?</a>)#i', $message, $matches, PREG_SET_ORDER);
+         foreach ($matches as $links)
+         {
+@@ -84,7 +109,7 @@ class bblinks
+             $is_local = ($this->config['bblinks_external_link_types'] && preg_match('/\.(?:' . $this->config['bblinks_external_link_types'] . ')(?:[#?]|$)/', $href)) ? false : $is_local;
+             if ($is_local === null)
+             {
+-                if ($this->config_text->get('bblinks_forbidden_domains') && $this->match_domain($href, $this->config_text->get('bblinks_forbidden_domains')))
++                if ($forbidden_domains && $this->match_domain($href, $forbidden_domains))
+                 {
+                     $searches[] = $link;
+                     $replacements[] = $this->insert_attribute('href', $this->config['bblinks_forbidden_new_url'], $new_link, true);
+@@ -313,7 +338,7 @@ class bblinks
+ 			if (sizeof($this->ids_to_fetch['post']))
+ 			{
+ 				$sql_ary = array(
+-					'SELECT'		=> 'p.post_id, p.post_subject, t.topic_id, t.topic_title, f.forum_id, f.forum_name, u.user_id, u.username, u.user_colour',
++					'SELECT'		=> 'p.post_id, p.post_subject, t.topic_id, t.topic_title, t.bbpoints_payed, f.forum_id, f.forum_name, u.user_id, u.username, u.user_colour',
+ 					'FROM'			=> array(POSTS_TABLE => 'p'),
+ 					'LEFT_JOIN'		=> array(
+ 						array(
+@@ -339,7 +364,7 @@ class bblinks
+ 			if ($this->ids_to_fetch['topic'])
+ 			{
+ 				$sql_ary = array(
+-					'SELECT'		=> 't.topic_id, t.topic_title, f.forum_id, f.forum_name',
++					'SELECT'		=> 't.topic_id, t.topic_title, f.forum_id, f.forum_name, t.bbpoints_payed',
+ 					'FROM'			=> array(TOPICS_TABLE => 't'),
+ 					'LEFT_JOIN'		=> array(
+ 						array(
+@@ -432,6 +457,45 @@ class bblinks
+ 					case LOCALURLTOTEXT_TYPE_TOPIC:
+ 						if (isset($this->infos['topic'][$match['id']]))
+ 						{
++							$paid = (int) ($this->infos['topic'][$match['id']]['paid'] ?? 0);
++
++							$paid_html = '';
++							if ($paid > 0)
++							{
++								$paid_html = '<span class="label label-success"><i class="fa fa-eye-slash"></i>&nbsp;' 
++										   . $paid . '&nbsp;' . $this->user->lang('BBPOINTS') . '</span>&nbsp;';
++							}
++
++							$manager = $this->getBbPrefixManager();
++							if ($manager && method_exists($manager, 'load_prefixes_topic'))
++							{
++								$manager->load_prefix_instances(true);
++								$prefix = $manager->load_prefixes_topic($match['id'], '', true);
++
++								$current_forum_id = 0;
++								if (isset($GLOBALS['forum_data']['forum_id']))
++								{
++									$current_forum_id = (int) $GLOBALS['forum_data']['forum_id'];
++								}
++								else if (isset($GLOBALS['topic_data']['forum_id']))
++								{
++									$current_forum_id = (int) $GLOBALS['topic_data']['forum_id'];
++								}
++								
++								if ($current_forum_id === 77 || $current_forum_id === 99)
++								{
++									// 4: $this->infos['topic'][$match['id']]['title'] =  '<div style="display:flex;justify-content:space-between;align-items:center;padding-left:5px;"><div>' . $this->infos['topic'][$match['id']]['title'] . '</div><div><div style="display:flex;justify-content:flex-end;">'  . $prefix . '</div><div style="display:flex;justify-content:end;align-items:center;">' . $paid_html . '</div></div></div>';
++									$this->infos['topic'][$match['id']]['title'] =  '<div style="display:flex;justify-content:space-between;padding-left:5px;"><div style="display:inline-flex;align-items:center;">' . $this->infos['topic'][$match['id']]['title'] . '&nbsp;' . $paid_html . '</div><div>' . $prefix . '</div></div>';
++								}
++								else
++								{
++									$this->infos['topic'][$match['id']]['title'] =  $paid_html . $prefix . $this->infos['topic'][$match['id']]['title'];
++								}
++							}
++							
++
++							$topic_title_full = $this->infos['topic'][$match['id']]['title'];
++
+ 							$text = str_replace(
+ 								$match[0],
+ 								$match['anchor'] . str_replace(
+@@ -440,7 +504,7 @@ class bblinks
+ 										'{FORUM_NAME}',
+ 									),
+ 									array(
+-										$this->infos['topic'][$match['id']]['title'],
++										$topic_title_full,
+ 										$this->infos['forum'][$this->infos['topic'][$match['id']]['forum_id']]['name'],
+ 									),
+ 									htmlspecialchars_decode($this->config['bblinks_urltotext_topic'])
+@@ -515,6 +579,7 @@ class bblinks
+ 				{
+ 					$this->infos['topic'][$row['topic_id']] = array(
+ 						'title'		=> $row['topic_title'],
++						'paid'		=> $row['bbpoints_payed'],
+ 						'forum_id'	=> $row['forum_id'],
+ 					);
+ 				}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/diff_full.tmp"
+new file mode 100644
+index 000000000..6b9b06219
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/diff_full.tmp"
+@@ -0,0 +1,92 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/config/services.yml"
++index 1fe7e40b8..a1cec908d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/config/services.yml"
++@@ -8,6 +8,7 @@ services:
++             - '@auth'
++             - '@dbal.conn'
++             - '%core.php_ext%'
+++            - '@service_container'
++ 
++     sitesplat.bblinks.listener:
++         class: sitesplat\bblinks\event\main_listener
++@@ -15,6 +16,7 @@ services:
++             - '@sitesplat.bblinks.bblinks'
++             - '@config'
++             - '@template'
+++            - '@dispatcher'
++             - '@dbal.conn'
++         tags:
++             - { name: event.listener }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/core/bblinks.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/core/bblinks.php"
++index e32f9f1bd..a34f02473 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/core/bblinks.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/core/bblinks.php"
++@@ -20,7 +20,10 @@ class bblinks
++     protected $link_type_classes;
++     protected $ids_to_fetch;
++     protected $infos;
++-    public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $php_ext)
+++    protected $manager;
+++    protected $container;
+++
+++    public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $php_ext, \Symfony\Component\DependencyInjection\Container $container)
++     {
++         $this->config = $config;
++         $this->config_text = $config_text;
++@@ -28,6 +31,7 @@ class bblinks
++         $this->auth = $auth;
++         $this->db = $db;
++         $this->php_ext = $php_ext;
+++		$this->container = $container;
++         $this->link_type_classes = array(
++             'pdf'	                => 'pdf-link',
++             'gif|jpg|jpeg|png|bmp'	=> 'img-link',
++@@ -39,13 +43,33 @@ class bblinks
++ 			$this->ids_to_fetch[$resource]	= array();
++ 			$this->infos[$resource]			= array();
++         }
++-        
+++
++         define('LOCALURLTOTEXT_TYPE_FORUM', 1);
++ 		define('LOCALURLTOTEXT_TYPE_TOPIC', 2);
++ 		define('LOCALURLTOTEXT_TYPE_POST', 3);
++ 		define('LOCALURLTOTEXT_TYPE_USER', 4);
++     }
++ 
+++	/**
+++	 * Lazy load the BbPrefix Manager
+++	 * @return mixed The manager service or null if not found
+++	 */
+++	protected function getBbPrefixManager()
+++	{
+++		// If we already loaded it, return it immediately
+++		if ($this->manager !== null) {
+++			return $this->manager;
+++		}
+++
+++		// Otherwise, try to load it from the container
+++		if ($this->container && $this->container->has('bbprefix.manager')) {
+++			$this->manager = $this->container->get('bbprefix.manager');
+++			return $this->manager;
+++		}
+++
+++		return null;
+++	}
+++
++     public function modify_links($message = '')
++ 	{
++         // A quick check before we start using regular expressions
++@@ -54,6 +78,7 @@ class bblinks
++             return $message;
++         }
++ 
+++        $forbidden_domains = $this->config_text->get('bblinks_forbidden_domains');
++         preg_match_all('#(<a\s[^>]+?>)(.*?</a>)#i', $message, $matches, PREG_SET_ORDER);
++         foreach ($matches as $links)
++         {
++@@ -84,7 +109,7 @@ class bblinks
++             $is_local = ($this->config['bblinks_external_link_types'] && preg_match('/\.(?:' . $this->config['bblinks_external_link_types'] . ')(?:[#?]|$)/', $href)) ? false : $is_local;
++             if ($is_local === null)
++             {
++-                if ($this->config_text->get('bblinks_forbidden_domains') && $this->match_domain($href, $this->config_te
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/event/main_listener.php"
+index a467f775e..cca84a9b1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/event/main_listener.php"
+@@ -34,14 +34,17 @@ class main_listener implements EventSubscriberInterface
+ 	protected $bblinks;
+ 	protected $config;
+ 	protected $template;
++	protected $dispatcher;
+ 	protected $db;
+ 	protected $is_rt = false;
+ 	protected $next_is_signature = false;
+-	public function __construct(\sitesplat\bblinks\core\bblinks $bblinks, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\db\driver\driver_interface $db)
++	
++	public function __construct(\sitesplat\bblinks\core\bblinks $bblinks, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\event\dispatcher $dispatcher, \phpbb\db\driver\driver_interface $db)
+ 	{
+ 		$this->bblinks = $bblinks;
+ 		$this->config = $config;
+ 		$this->template = $template;
++		$this->dispatcher = $dispatcher;
+ 		$this->db = $db;
+ 	}
+ 
+@@ -89,6 +92,22 @@ class main_listener implements EventSubscriberInterface
+ 			{
+ 				$event['text'] = $this->bblinks->local_url_to_text($event['text']);
+ 				$event['text'] = $this->bblinks->modify_links($event['text']);
++
++				$topic_title = $event['text'];
++
++				/**
++				 * This event enables you to edit topic title before it is
++				 * displayed in viewtopic.
++				 *
++				 * @event sitesplat.bblinks.display
++				 * @var	string	topic_title	Topic title
++				 */
++				$vars = array(
++					'topic_title',
++				);
++				extract($this->dispatcher->trigger_event('sitesplat.bblinks.display', compact($vars)));
++
++				$event['text'] = $topic_title;
+ 				$this->is_rt = false;
+ 			}
+ 		}
diff --git "[FORUM_EXT]/sitesplat\\bblinks/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bblinks/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bblinks/diff_nospace.tmp"
@@ -0,0 +1,437 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/config/services.yml"
+index 1fe7e40b8..a1cec908d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/config/services.yml"
+@@ -8,6 +8,7 @@ services:
+             - '@auth'
+             - '@dbal.conn'
+             - '%core.php_ext%'
++            - '@service_container'
+ 
+     sitesplat.bblinks.listener:
+         class: sitesplat\bblinks\event\main_listener
+@@ -15,6 +16,7 @@ services:
+             - '@sitesplat.bblinks.bblinks'
+             - '@config'
+             - '@template'
++            - '@dispatcher'
+             - '@dbal.conn'
+         tags:
+             - { name: event.listener }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/core/bblinks.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/core/bblinks.php"
+index e32f9f1bd..a34f02473 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/core/bblinks.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/core/bblinks.php"
+@@ -20,7 +20,10 @@ class bblinks
+     protected $link_type_classes;
+     protected $ids_to_fetch;
+     protected $infos;
+-    public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $php_ext)
++    protected $manager;
++    protected $container;
++
++    public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $php_ext, \Symfony\Component\DependencyInjection\Container $container)
+     {
+         $this->config = $config;
+         $this->config_text = $config_text;
+@@ -28,6 +31,7 @@ class bblinks
+         $this->auth = $auth;
+         $this->db = $db;
+         $this->php_ext = $php_ext;
++		$this->container = $container;
+         $this->link_type_classes = array(
+             'pdf'	                => 'pdf-link',
+             'gif|jpg|jpeg|png|bmp'	=> 'img-link',
+@@ -46,6 +50,26 @@ class bblinks
+ 		define('LOCALURLTOTEXT_TYPE_USER', 4);
+     }
+ 
++	/**
++	 * Lazy load the BbPrefix Manager
++	 * @return mixed The manager service or null if not found
++	 */
++	protected function getBbPrefixManager()
++	{
++		// If we already loaded it, return it immediately
++		if ($this->manager !== null) {
++			return $this->manager;
++		}
++
++		// Otherwise, try to load it from the container
++		if ($this->container && $this->container->has('bbprefix.manager')) {
++			$this->manager = $this->container->get('bbprefix.manager');
++			return $this->manager;
++		}
++
++		return null;
++	}
++
+     public function modify_links($message = '')
+ 	{
+         // A quick check before we start using regular expressions
+@@ -54,6 +78,7 @@ class bblinks
+             return $message;
+         }
+ 
++        $forbidden_domains = $this->config_text->get('bblinks_forbidden_domains');
+         preg_match_all('#(<a\s[^>]+?>)(.*?</a>)#i', $message, $matches, PREG_SET_ORDER);
+         foreach ($matches as $links)
+         {
+@@ -84,7 +109,7 @@ class bblinks
+             $is_local = ($this->config['bblinks_external_link_types'] && preg_match('/\.(?:' . $this->config['bblinks_external_link_types'] . ')(?:[#?]|$)/', $href)) ? false : $is_local;
+             if ($is_local === null)
+             {
+-                if ($this->config_text->get('bblinks_forbidden_domains') && $this->match_domain($href, $this->config_text->get('bblinks_forbidden_domains')))
++                if ($forbidden_domains && $this->match_domain($href, $forbidden_domains))
+                 {
+                     $searches[] = $link;
+                     $replacements[] = $this->insert_attribute('href', $this->config['bblinks_forbidden_new_url'], $new_link, true);
+@@ -313,7 +338,7 @@ class bblinks
+ 			if (sizeof($this->ids_to_fetch['post']))
+ 			{
+ 				$sql_ary = array(
+-					'SELECT'		=> 'p.post_id, p.post_subject, t.topic_id, t.topic_title, f.forum_id, f.forum_name, u.user_id, u.username, u.user_colour',
++					'SELECT'		=> 'p.post_id, p.post_subject, t.topic_id, t.topic_title, t.bbpoints_payed, f.forum_id, f.forum_name, u.user_id, u.username, u.user_colour',
+ 					'FROM'			=> array(POSTS_TABLE => 'p'),
+ 					'LEFT_JOIN'		=> array(
+ 						array(
+@@ -339,7 +364,7 @@ class bblinks
+ 			if ($this->ids_to_fetch['topic'])
+ 			{
+ 				$sql_ary = array(
+-					'SELECT'		=> 't.topic_id, t.topic_title, f.forum_id, f.forum_name',
++					'SELECT'		=> 't.topic_id, t.topic_title, f.forum_id, f.forum_name, t.bbpoints_payed',
+ 					'FROM'			=> array(TOPICS_TABLE => 't'),
+ 					'LEFT_JOIN'		=> array(
+ 						array(
+@@ -432,6 +457,45 @@ class bblinks
+ 					case LOCALURLTOTEXT_TYPE_TOPIC:
+ 						if (isset($this->infos['topic'][$match['id']]))
+ 						{
++							$paid = (int) ($this->infos['topic'][$match['id']]['paid'] ?? 0);
++
++							$paid_html = '';
++							if ($paid > 0)
++							{
++								$paid_html = '<span class="label label-success"><i class="fa fa-eye-slash"></i>&nbsp;' 
++										   . $paid . '&nbsp;' . $this->user->lang('BBPOINTS') . '</span>&nbsp;';
++							}
++
++							$manager = $this->getBbPrefixManager();
++							if ($manager && method_exists($manager, 'load_prefixes_topic'))
++							{
++								$manager->load_prefix_instances(true);
++								$prefix = $manager->load_prefixes_topic($match['id'], '', true);
++
++								$current_forum_id = 0;
++								if (isset($GLOBALS['forum_data']['forum_id']))
++								{
++									$current_forum_id = (int) $GLOBALS['forum_data']['forum_id'];
++								}
++								else if (isset($GLOBALS['topic_data']['forum_id']))
++								{
++									$current_forum_id = (int) $GLOBALS['topic_data']['forum_id'];
++								}
++								
++								if ($current_forum_id === 77 || $current_forum_id === 99)
++								{
++									// 4: $this->infos['topic'][$match['id']]['title'] =  '<div style="display:flex;justify-content:space-between;align-items:center;padding-left:5px;"><div>' . $this->infos['topic'][$match['id']]['title'] . '</div><div><div style="display:flex;justify-content:flex-end;">'  . $prefix . '</div><div style="display:flex;justify-content:end;align-items:center;">' . $paid_html . '</div></div></div>';
++									$this->infos['topic'][$match['id']]['title'] =  '<div style="display:flex;justify-content:space-between;padding-left:5px;"><div style="display:inline-flex;align-items:center;">' . $this->infos['topic'][$match['id']]['title'] . '&nbsp;' . $paid_html . '</div><div>' . $prefix . '</div></div>';
++								}
++								else
++								{
++									$this->infos['topic'][$match['id']]['title'] =  $paid_html . $prefix . $this->infos['topic'][$match['id']]['title'];
++								}
++							}
++							
++
++							$topic_title_full = $this->infos['topic'][$match['id']]['title'];
++
+ 							$text = str_replace(
+ 								$match[0],
+ 								$match['anchor'] . str_replace(
+@@ -440,7 +504,7 @@ class bblinks
+ 										'{FORUM_NAME}',
+ 									),
+ 									array(
+-										$this->infos['topic'][$match['id']]['title'],
++										$topic_title_full,
+ 										$this->infos['forum'][$this->infos['topic'][$match['id']]['forum_id']]['name'],
+ 									),
+ 									htmlspecialchars_decode($this->config['bblinks_urltotext_topic'])
+@@ -515,6 +579,7 @@ class bblinks
+ 				{
+ 					$this->infos['topic'][$row['topic_id']] = array(
+ 						'title'		=> $row['topic_title'],
++						'paid'		=> $row['bbpoints_payed'],
+ 						'forum_id'	=> $row['forum_id'],
+ 					);
+ 				}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/diff_full.tmp"
+new file mode 100644
+index 000000000..ddb5cbee1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/diff_full.tmp"
+@@ -0,0 +1,322 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/config/services.yml"
++index 1fe7e40b8..a1cec908d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/config/services.yml"
++@@ -8,6 +8,7 @@ services:
++             - '@auth'
++             - '@dbal.conn'
++             - '%core.php_ext%'
+++            - '@service_container'
++ 
++     sitesplat.bblinks.listener:
++         class: sitesplat\bblinks\event\main_listener
++@@ -15,6 +16,7 @@ services:
++             - '@sitesplat.bblinks.bblinks'
++             - '@config'
++             - '@template'
+++            - '@dispatcher'
++             - '@dbal.conn'
++         tags:
++             - { name: event.listener }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/core/bblinks.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/core/bblinks.php"
++index e32f9f1bd..a34f02473 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/core/bblinks.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/core/bblinks.php"
++@@ -20,7 +20,10 @@ class bblinks
++     protected $link_type_classes;
++     protected $ids_to_fetch;
++     protected $infos;
++-    public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $php_ext)
+++    protected $manager;
+++    protected $container;
+++
+++    public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $php_ext, \Symfony\Component\DependencyInjection\Container $container)
++     {
++         $this->config = $config;
++         $this->config_text = $config_text;
++@@ -28,6 +31,7 @@ class bblinks
++         $this->auth = $auth;
++         $this->db = $db;
++         $this->php_ext = $php_ext;
+++		$this->container = $container;
++         $this->link_type_classes = array(
++             'pdf'	                => 'pdf-link',
++             'gif|jpg|jpeg|png|bmp'	=> 'img-link',
++@@ -39,13 +43,33 @@ class bblinks
++ 			$this->ids_to_fetch[$resource]	= array();
++ 			$this->infos[$resource]			= array();
++         }
++-        
+++
++         define('LOCALURLTOTEXT_TYPE_FORUM', 1);
++ 		define('LOCALURLTOTEXT_TYPE_TOPIC', 2);
++ 		define('LOCALURLTOTEXT_TYPE_POST', 3);
++ 		define('LOCALURLTOTEXT_TYPE_USER', 4);
++     }
++ 
+++	/**
+++	 * Lazy load the BbPrefix Manager
+++	 * @return mixed The manager service or null if not found
+++	 */
+++	protected function getBbPrefixManager()
+++	{
+++		// If we already loaded it, return it immediately
+++		if ($this->manager !== null) {
+++			return $this->manager;
+++		}
+++
+++		// Otherwise, try to load it from the container
+++		if ($this->container && $this->container->has('bbprefix.manager')) {
+++			$this->manager = $this->container->get('bbprefix.manager');
+++			return $this->manager;
+++		}
+++
+++		return null;
+++	}
+++
++     public function modify_links($message = '')
++ 	{
++         // A quick check before we start using regular expressions
++@@ -54,6 +78,7 @@ class bblinks
++             return $message;
++         }
++ 
+++        $forbidden_domains = $this->config_text->get('bblinks_forbidden_domains');
++         preg_match_all('#(<a\s[^>]+?>)(.*?</a>)#i', $message, $matches, PREG_SET_ORDER);
++         foreach ($matches as $links)
++         {
++@@ -84,7 +109,7 @@ class bblinks
++             $is_local = ($this->config['bblinks_external_link_types'] && preg_match('/\.(?:' . $this->config['bblinks_external_link_types'] . ')(?:[#?]|$)/', $href)) ? false : $is_local;
++             if ($is_local === null)
++             {
++-                if ($this->config_text->get('bblinks_forbidden_domains') && $this->match_domain($href, $this->config_text->get('bblinks_forbidden_domains')))
+++                if ($forbidden_domains && $this->match_domain($href, $forbidden_domains))
++                 {
++                     $searches[] = $link;
++                     $replacements[] = $this->insert_attribute('href', $this->config['bblinks_forbidden_new_url'], $new_link, true);
++@@ -313,7 +338,7 @@ class bblinks
++ 			if (sizeof($this->ids_to_fetch['post']))
++ 			{
++ 				$sql_ary = array(
++-					'SELECT'		=> 'p.post_id, p.post_subject, t.topic_id, t.topic_title, f.forum_id, f.forum_name, u.user_id, u.username, u.user_colour',
+++					'SELECT'		=> 'p.post_id, p.post_subject, t.topic_id, t.topic_title, t.bbpoints_payed, f.forum_id, f.forum_name, u.user_id, u.username, u.user_colour',
++ 					'FROM'			=> array(POSTS_TABLE => 'p'),
++ 					'LEFT_JOIN'		=> array(
++ 						array(
++@@ -339,7 +364,7 @@ class bblinks
++ 			if ($this->ids_to_fetch['topic'])
++ 			{
++ 				$sql_ary = array(
++-					'SELECT'		=> 't.topic_id, t.topic_title, f.forum_id, f.forum_name',
+++					'SELECT'		=> 't.topic_id, t.topic_title, f.forum_id, f.forum_name, t.bbpoints_payed',
++ 					'FROM'			=> array(TOPICS_TABLE => 't'),
++ 					'LEFT_JOIN'		=> array(
++ 						array(
++@@ -432,6 +457,45 @@ class bblinks
++ 					case LOCALURLTOTEXT_TYPE_TOPIC:
++ 						if (isset($this->infos['topic'][$match['id']]))
++ 						{
+++							$paid = (int) ($this->infos['topic'][$match['id']]['paid'] ?? 0);
+++
+++							$paid_html = '';
+++							if ($paid > 0)
+++							{
+++								$paid_html = '<span class="label label-success"><i class="fa fa-eye-slash"></i>&nbsp;' 
+++										   . $paid . '&nbsp;' . $this->user->lang('BBPOINTS') . '</span>&nbsp;';
+++							}
+++
+++							$manager = $this->getBbPrefixManager();
+++							if ($manager && method_exists($manager, 'load_prefixes_topic'))
+++							{
+++								$manager->load_prefix_instances(true);
+++								$prefix = $manager->load_prefixes_topic($match['id'], '', true);
+++
+++								$current_forum_id = 0;
+++								if (isset($GLOBALS['forum_data']['forum_id']))
+++								{
+++									$current_forum_id = (int) $GLOBALS['forum_data']['forum_id'];
+++								}
+++								else if (isset($GLOBALS['topic_data']['forum_id']))
+++								{
+++									$current_forum_id = (int) $GLOBALS['topic_data']['forum_id'];
+++								}
+++								
+++								if ($current_forum_id === 77 || $current_forum_id === 99)
+++								{
+++									// 4: $this->infos['topic'][$match['id']]['title'] =  '<div style="display:flex;justify-content:space-between;align-items:center;padding-left:5px;"><div>' . $this->infos['topic'][$match['id']]['title'] . '</div><div><div style="display:flex;justify-content:flex-end;">'  . $prefix . '</div><div style="display:flex;justify-content:end;align-items:center;">' . $paid_html . '</div></div></div>';
+++									$this->infos['topic'][$match['id']]['title'] =  '<div style="display:flex;justify-content:space-between;padding-left:5px;"><div style="display:inline-flex;align-items:center;">' . $this->infos['topic'][$match['id']]['title'] . '&nbsp;' . $paid_html . '</div><div>' . $prefix . '</div></div>';
+++								}
+++								else
+++								{
+++									$this->infos['topic'][$match['id']]['title'] =  $paid_html . $prefix . $this->infos['topic'][$match['id']]['title'];
+++								}
+++							}
+++							
+++
+++							$topic_title_full = $this->infos['topic'][$match['id']]['title'];
+++
++ 							$text = str_replace(
++ 								$match[0],
++ 								$match['anchor'] . str_replace(
++@@ -440,7 +504,7 @@ class bblinks
++ 										'{FORUM_NAME}',
++ 									),
++ 									array(
++-										$this->infos['topic'][$match['id']]['title'],
+++										$topic_title_full,
++ 										$this->infos['forum'][$this->infos['topic'][$match['id']]['forum_id']]['name'],
++ 									),
++ 									htmlspecialchars_decode($this->config['bblinks_urltotext_topic'])
++@@ -515,6 +579,7 @@ class bblinks
++ 				{
++ 					$this->infos['topic'][$row['topic_id']] = array(
++ 						'title'		=> $row['topic_title'],
+++						'paid'		=> $row['bbpoints_payed'],
++ 						'forum_id'	=> $row['forum_id'],
++ 					);
++ 				}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/diff_full.tmp"
++new file mode 100644
++index 000000000..6b9b06219
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/diff_full.tmp"
++@@ -0,0 +1,92 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/config/services.yml"
+++index 1fe7e40b8..a1cec908d 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/config/services.yml"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/config/services.yml"
+++@@ -8,6 +8,7 @@ services:
+++             - '@auth'
+++             - '@dbal.conn'
+++             - '%core.php_ext%'
++++            - '@service_container'
+++ 
+++     sitesplat.bblinks.listener:
+++         class: sitesplat\bblinks\event\main_listener
+++@@ -15,6 +16,7 @@ services:
+++             - '@sitesplat.bblinks.bblinks'
+++             - '@config'
+++             - '@template'
++++            - '@dispatcher'
+++             - '@dbal.conn'
+++         tags:
+++             - { name: event.listener }
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/core/bblinks.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/core/bblinks.php"
+++index e32f9f1bd..a34f02473 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bblinks/core/bblinks.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bblinks/core/bblinks.php"
+++@@ -20,7 +20,10 @@ class bblinks
+++     protected $link_type_classes;
+++     protected $ids_to_fetch;
+++     protected $infos;
+++-    public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $php_ext)
++++    protected $manager;
++++    protected $container;
++++
++++    public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $php_ext, \Symfony\Component\DependencyInjection\Container $container)
+++     {
+++         $this->config = $config;
+++         $this->config_text = $config_text;
+++@@ -28,6 +31,7 @@ class bblinks
+++         $this->auth = $auth;
+++         $this->db = $db;
+++         $this->php_ext = $php_ext;
++++		$this->container = $container;
+++         $this->link_type_classes = array(
+++             'pdf'	                => 'pdf-link',
+++             'gif|jpg|jpeg|png|bmp'	=> 'img-link',
+++@@ -39,13 +43,33 @@ class bblinks
+++ 			$this->ids_to_fetch[$resource]	= array();
+++ 			$this->infos[$resource]			= array();
+++         }
+++-        
++++
+++         define('LOCALURLTOTEXT_TYPE_FORUM', 1);
+++ 		define('LOCALURLTOTEXT_TYPE_TOPIC', 2);
+++ 		define('LOCALURLTOTEXT_TYPE_POST', 3);
+++ 		define('LOCALURLTOTEXT_TYPE_USER', 4);
+++     }
+++ 
++++	/**
++++	 * Lazy load the BbPrefix Manager
++++	 * @return mixed The manager service or null if not found
++++	 */
++++	protected function getBbPrefixManager()
++++	{
++++		// If we already loaded it, return it immediately
++++		if ($this->manager !== null) {
++++			return $this->manager;
++++		}
++++
++++		// Otherwise, try to load it from the container
++++		if ($this->container && $this->container->has('bbprefix.manager')) {
++++			$this->manager = $this->container->get('bbprefix.manager');
++++			return $this->manager;
++++		}
++++
++++		return null;
++++	}
++++
+++     public function modify_links($message = '')
+++ 	{
+++         // A quick check before we start using regular expres
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bblinks/event/main_listener.php" "[FORUM_EXT]/sitesplat\\bblinks/event/main_listener.php"
--- "[ORIGINAL]/sitesplat\\bblinks/event/main_listener.php"
+++ "[FORUM_EXT]/sitesplat\\bblinks/event/main_listener.php"
@@ -34,14 +34,17 @@ class main_listener implements EventSubscriberInterface
 	protected $bblinks;
 	protected $config;
 	protected $template;
+	protected $dispatcher;
 	protected $db;
 	protected $is_rt = false;
 	protected $next_is_signature = false;
-	public function __construct(\sitesplat\bblinks\core\bblinks $bblinks, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\db\driver\driver_interface $db)
+	
+	public function __construct(\sitesplat\bblinks\core\bblinks $bblinks, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\event\dispatcher $dispatcher, \phpbb\db\driver\driver_interface $db)
 	{
 		$this->bblinks = $bblinks;
 		$this->config = $config;
 		$this->template = $template;
+		$this->dispatcher = $dispatcher;
 		$this->db = $db;
 	}
 
@@ -89,6 +92,22 @@ class main_listener implements EventSubscriberInterface
 			{
 				$event['text'] = $this->bblinks->local_url_to_text($event['text']);
 				$event['text'] = $this->bblinks->modify_links($event['text']);
+
+				$topic_title = $event['text'];
+
+				/**
+				 * This event enables you to edit topic title before it is
+				 * displayed in viewtopic.
+				 *
+				 * @event sitesplat.bblinks.display
+				 * @var	string	topic_title	Topic title
+				 */
+				$vars = array(
+					'topic_title',
+				);
+				extract($this->dispatcher->trigger_event('sitesplat.bblinks.display', compact($vars)));
+
+				$event['text'] = $topic_title;
 				$this->is_rt = false;
 			}
 		}
```
