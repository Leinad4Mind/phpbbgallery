Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/dmzx\\topicindex/CHANGELOG.md" "[FORUM_EXT]/dmzx\\topicindex/CHANGELOG.md"
--- "[ORIGINAL]/dmzx\\topicindex/CHANGELOG.md"
+++ "[FORUM_EXT]/dmzx\\topicindex/CHANGELOG.md"
@@ -1,9 +1,4 @@
-## Topic IndexChangelog
-
-### 1.0.5 - 2020-01-15
-- Drop support for 3.1.
-- Twig update.
-- Code update tables.yml
+## Changelog
 
 ### 1.0.4 - 2017-04-13
 
diff --git "[ORIGINAL]/dmzx\\topicindex/config/services.yml" "[FORUM_EXT]/dmzx\\topicindex/config/services.yml"
--- "[ORIGINAL]/dmzx\\topicindex/config/services.yml"
+++ "[FORUM_EXT]/dmzx\\topicindex/config/services.yml"
@@ -37,6 +37,7 @@ services:
             - '@request'
             - '@controller.helper'
             - '@config'
+            - '@dispatcher'
             - '%core.root_path%'
             - '%core.php_ext%'
             - '%dmzx.topicindex.table.topicindex%'
@@ -47,4 +48,5 @@ services:
             - '@template'
             - '@config'
             - '@auth'
+            - '@dispatcher'
             - '@ext.manager'
diff --git "[ORIGINAL]/dmzx\\topicindex/controller/main.php" "[FORUM_EXT]/dmzx\\topicindex/controller/main.php"
--- "[ORIGINAL]/dmzx\\topicindex/controller/main.php"
+++ "[FORUM_EXT]/dmzx\\topicindex/controller/main.php"
@@ -10,6 +10,7 @@
 namespace dmzx\topicindex\controller;
 
 use dmzx\topicindex\core\functions_topicindex;
+use phpbb\event\dispatcher_interface;
 use phpbb\template\template;
 use phpbb\user;
 use phpbb\auth\auth;
@@ -45,6 +46,9 @@ class main
 	/** @var config */
 	protected $config;
 
+	/** @var dispatcher_interface */
+	protected $dispatcher;
+
 	/** @var string */
 	protected $root_path;
 
@@ -69,6 +73,7 @@ class main
 	* @param request_interface		$request
 	* @param helper		 			$helper
 	* @param config					$config
+	* @param dispatcher_interface	$dispatcher
 	* @param string 				$root_path
 	* @param string 				$php_ext
 	* @param string 				$forum_lists_table
@@ -82,6 +87,7 @@ class main
 		request_interface $request,
 		helper $helper,
 		config $config,
+		dispatcher_interface $dispatcher,
 		$root_path,
 		$php_ext,
 		$forum_lists_table
@@ -95,6 +101,7 @@ class main
 		$this->request 				= $request;
 		$this->helper 				= $helper;
 		$this->config				= $config;
+		$this->dispatcher			= $dispatcher;
 		$this->root_path 			= $root_path;
 		$this->php_ext 				= $php_ext;
 		$this->forum_lists_table 	= $forum_lists_table;
@@ -127,11 +134,7 @@ class main
 			redirect($zurl, false, true);
 		}
 
-		// Navigation
-		$this->template->assign_block_vars('navlinks', array(
-			'FORUM_NAME'	=> $this->user->lang['OIINDEX_HEADER'],
-			'U_VIEW_FORUM'	=> $zurl
-		));
+		$selected_category = '';
 
 		if (empty($list))
 		{
@@ -167,6 +170,11 @@ class main
 			$result	= $this->db->sql_query($sql);
 			while ($row = $this->db->sql_fetchrow($result))
 			{
+				if ($list == $row['list_id'])
+				{
+					$selected_category = $row['list_name'];
+				}
+
 				$s_list_options .= '<option value="' . $row['list_id'] . '"' . (($list == $row['list_id']) ? ' selected="selected"' : '') . '>' . $row['list_name'] . '</option>';
 			}
 			$this->db->sql_freeresult($result);
@@ -186,7 +194,8 @@ class main
 			$row1		= $this->db->sql_fetchrow($result1);
 			$this->db->sql_freeresult($result1);
 
-			$forumsari 	= json_decode($row1['list_forum']);
+			$forumsari 	= @json_decode($row1['list_forum']);
+			$forumsari	= is_array($forumsari) ? $forumsari : [];
 			$filtrini	= range('a', 'z');
 			$indexlist	= array();
 
@@ -236,14 +245,26 @@ class main
 				{
 					if ($realfilter == $indexdata['key'])
 					{
-						$this->template->assign_block_vars('block_list.block_topic_index', array(
-							'ITOPIC_URL'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$indexdata['id']}"),
+						$template_vars = array(
+							'ITOPIC_URL'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$indexdata['forum_id']}&amp;t={$indexdata['id']}"),
 							'ITOPIC_TITLE'	=> $indexdata['title'],
 							'ITOPIC_POSTER'	=> get_username_string('full', $indexdata['posterid'], $indexdata['poster'], $indexdata['postercol']),
 							'ITOPIC_TOTREP'	=> $indexdata['posts'],
 							'U_REMOVE_FROM'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'iremove' => $indexdata['id'])),
 							'ITOPIC_CLASS'	=> ($nums % 2) ? 'row bg1' : 'row bg2'
-						));
+						);
+
+						/**
+						 * Modify the topic index data before it is assigned to the template
+						 *
+						 * @event dmzx.topicindex.modify_block_topic_index_ary
+						 * @var		array	template_vars	Template block array with topic data
+						 * @since 1.0.5
+						 */
+						$vars = array('indexdata', 'template_vars');
+						extract($this->dispatcher->trigger_event('dmzx.topicindex.modify_block_topic_index_ary', compact($vars)));
+
+						$this->template->assign_block_vars('block_list.block_topic_index', $template_vars);
 						$nums++;
 					}
 				}
@@ -252,18 +273,29 @@ class main
 			// Others data for menu
 			$this->template->assign_block_vars('block_nofiltrino', array(
 				'U_TUTTI'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list)),
-				'U_09'		=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit=09')),
-				'U_SYMB'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit=_')),
+				'U_09'		=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit' => '09')),
+				'U_SYMB'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit' => '_')),
 				'S_09'		=> (in_array('09', $fixa)) ? true : false,
 				'S_SYMB'	=> (in_array('_', $fixa)) ? true : false
 			));
 		}
 
+		$title = implode(' - ', array_filter([$this->user->lang['OIINDEX_HEADER'], $selected_category]));
+
+		// Navigation
+		$this->template->assign_block_vars('navlinks', array(
+			'FORUM_NAME'	=> $title,
+			'U_VIEW_FORUM'	=> $zurl
+		));
+
 		$this->functions_topicindex->assign_authors();
 
-		$this->template->assign_var('TOPICINDEX_FOOTER_VIEW', true);
+		$this->template->assign_vars([
+			'TOPICINDEX_FOOTER_VIEW'	=> true,
+			'L_OIINDEX_HEADER'			=> $title,
+		]);
 
 		// Send all data to the template file
-		return $this->helper->render('topiclist.html', $this->user->lang['OIINDEX_HEADER']);
+		return $this->helper->render('topiclist.html', $title);
 	}
 }
diff --git "[ORIGINAL]/dmzx\\topicindex/core/functions_topicindex.php" "[FORUM_EXT]/dmzx\\topicindex/core/functions_topicindex.php"
--- "[ORIGINAL]/dmzx\\topicindex/core/functions_topicindex.php"
+++ "[FORUM_EXT]/dmzx\\topicindex/core/functions_topicindex.php"
@@ -10,6 +10,7 @@
 namespace dmzx\topicindex\core;
 
 use phpbb\db\driver\driver_interface as db_interface;
+use phpbb\event\dispatcher_interface;
 use phpbb\template\template;
 use phpbb\config\config;
 use phpbb\auth\auth;
@@ -29,6 +30,9 @@ class functions_topicindex
 	/** @var auth */
 	protected $auth;
 
+	/** @var dispatcher_interface */
+	protected $dispatcher;
+
 	/** @var manager */
 	protected $extension_manager;
 
@@ -39,6 +43,7 @@ class functions_topicindex
 	* @param template		$template
 	* @param config			$config
 	* @param auth			auth
+	* @param dispatcher_interface $dispatcher
 	* @param manager 		$extension_manager
 	*/
 	public function __construct(
@@ -46,6 +51,7 @@ class functions_topicindex
 		template $template,
 		config $config,
 		auth $auth,
+		dispatcher_interface $dispatcher,
 		manager $extension_manager
 	)
 	{
@@ -53,6 +59,7 @@ class functions_topicindex
 		$this->template 			= $template;
 		$this->config				= $config;
 		$this->auth					= $auth;
+		$this->dispatcher			= $dispatcher;
 		$this->extension_manager	= $extension_manager;
 	}
 
@@ -62,13 +69,24 @@ class functions_topicindex
 	*/
 	function get_topic_index($the_forum, $the_topic, $inlistvalue = 0, $tagfilter = 0)
 	{
-		$sql = "SELECT topic_id, topic_title, topic_poster, topic_first_poster_name, topic_first_poster_colour, forum_id, topic_posts_approved, topic_title, inindex_topic, outindex_topic
-			FROM " . TOPICS_TABLE . "
-			WHERE forum_id = " . (int) $the_forum . "
-				AND topic_posts_approved >= 1
-				AND inindex_topic >= " . (int) $inlistvalue . "
-				AND outindex_topic = 0
-			ORDER BY topic_title ASC";
+		$sql_array = [
+			'SELECT'	=> 't.topic_id, t.topic_title, t.topic_poster, t.topic_first_poster_name, t.topic_first_poster_colour, t.forum_id, t.topic_posts_approved, t.inindex_topic, t.outindex_topic',
+			'FROM'		=> [TOPICS_TABLE => 't'],
+			'WHERE'		=> 't.forum_id = ' . (int) $the_forum . ' AND t.topic_posts_approved >= 1 AND t.inindex_topic >= ' . (int) $inlistvalue . ' AND t.outindex_topic = 0',
+			'ORDER_BY'	=> 't.topic_title ASC',
+		];
+
+		/**
+		 * Event to modify the SQL query that fetches topics
+		 *
+		 * @event dmzx.topicindex.sql_fetch_topics_before
+		 * @var array	sql_array	Array with SQL query data to fetch the current active sessions
+		 * @since 1.0.5
+		 */
+		$vars = ['sql_array'];
+		extract($this->dispatcher->trigger_event('dmzx.topicindex.sql_fetch_topics_before', compact($vars)));
+
+		$sql = $this->db->sql_build_query('SELECT', $sql_array);
 		$result	= $this->db->sql_query($sql);
 
 		$topiclist	= array();
@@ -77,71 +95,70 @@ class functions_topicindex
 		{
 			if ($tagfilter == 1)
 			{
-				switch (substr(trim($row['topic_title']),0,1))
+				switch (mb_substr(trim($row['topic_title']),0,1))
 				{
 					case '(':
-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], ')') + 1);
+						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], ')') + 1);
 						$newstring	= trim($newstring);
 
-						if (substr($newstring,0,1) == '(')
+						if (mb_substr($newstring,0,1) == '(')
 						{
-							$newstring	= substr($newstring, strpos($row['topic_title'], ')') + 1);
+							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], ')') + 1);
 							$newstring	= trim($newstring);
-							$keytag		= strtolower(substr($newstring,0,1));
-							$keyBig		= strtolower(substr($newstring,0,4));
+							$keytag		= strtolower(mb_substr($newstring,0,1));
+							$keyBig		= strtolower(mb_substr($newstring,0,30));
 						}
 						else
 						{
-							$keytag		= strtolower(substr($newstring,0,1));
-							$keyBig		= strtolower(substr($newstring,0,4));
+							$keytag		= strtolower(mb_substr($newstring,0,1));
+							$keyBig		= strtolower(mb_substr($newstring,0,30));
 						}
 					break;
 					case '[':
-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], ']') + 1);
+						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], ']') + 1);
 						$newstring	= trim($newstring);
 
-						if (substr($newstring,0,1) == '[')
+						if (mb_substr($newstring,0,1) == '[')
 						{
-							$newstring	= substr($newstring, strpos($row['topic_title'], ']') + 1);
+							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], ']') + 1);
 							$newstring	= trim($newstring);
-							$keytag		= strtolower(substr($newstring,0,1));
-							$keyBig		= strtolower(substr($newstring,0,4));
+							$keytag		= strtolower(mb_substr($newstring,0,1));
+							$keyBig		= strtolower(mb_substr($newstring,0,30));
 						}
 						else
 						{
-							$keytag		= strtolower(substr($newstring,0,1));
-							$keyBig		= strtolower(substr($newstring,0,4));
+							$keytag		= strtolower(mb_substr($newstring,0,1));
+							$keyBig		= strtolower(mb_substr($newstring,0,30));
 						}
 					break;
 					case '{':
-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], '}') + 1);
+						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], '}') + 1);
 						$newstring	= trim($newstring);
 
-						if (substr($newstring,0,1) == '{')
+						if (mb_substr($newstring,0,1) == '{')
 						{
-							$newstring	= substr($newstring, strpos($row['topic_title'], '}') + 1);
+							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], '}') + 1);
 							$newstring	= trim($newstring);
-							$keytag		= strtolower(substr($newstring,0,1));
-							$keyBig		= strtolower(substr($newstring,0,4));
+							$keytag		= strtolower(mb_substr($newstring,0,1));
+							$keyBig		= strtolower(mb_substr($newstring,0,30));
 						}
 						else
 						{
-							$keytag		= strtolower(substr($newstring,0,1));
-							$keyBig		= strtolower(substr($newstring,0,4));
+							$keytag		= strtolower(mb_substr($newstring,0,1));
+							$keyBig		= strtolower(mb_substr($newstring,0,30));
 						}
 					break;
 					default:
-						$keytag	= strtolower(substr($row['topic_title'],0,1));
-						$keyBig	= strtolower(substr($row['topic_title'],0,4));
+						$keytag	= strtolower(mb_substr($row['topic_title'],0,1));
+						$keyBig	= strtolower(mb_substr($row['topic_title'],0,30));
 					break;
 				}
 			}
 			else
 			{
-				$keytag	= strtolower(substr($row['topic_title'],0,1));
-				$keyBig	= strtolower(substr($row['topic_title'],0,30));
+				$keytag	= strtolower(mb_substr($row['topic_title'],0,1));
+				$keyBig	= strtolower(mb_substr($row['topic_title'],0,30));
 			}
-
 			if (preg_match('#^[a-z]#u', $keytag))
 			{
 				$keytag;
@@ -158,6 +175,7 @@ class functions_topicindex
 			if ($row['topic_id'] != $the_topic)
 			{
 				$array['id']		= $row['topic_id'];
+				$array['forum_id']	= $row['forum_id'];
 				$array['key']		= $keytag;
 				$array['keybig']	= $keyBig;
 				$array['title']		= $row['topic_title'];
@@ -165,6 +183,19 @@ class functions_topicindex
 				$array['posterid']	= $row['topic_poster'];
 				$array['poster']	= $row['topic_first_poster_name'];
 				$array['postercol']	= $row['topic_first_poster_colour'];
+
+				/**
+				 * Event to modify the SQL query that fetches topics
+				 *
+				 * @event dmzx.topicindex.sql_fetch_topics_after
+				 * @var array	topiclist	Array with all topics returned
+				 * @var array	array		Array with data returned for the current topic
+				 * @var array	row			Array with SQL fields from the current topic
+				 * @since 1.0.5
+				 */
+				$vars = ['topiclist', 'array', 'row'];
+				extract($this->dispatcher->trigger_event('dmzx.topicindex.sql_fetch_topics_after', compact($vars)));
+
 				$topiclist[] 		= $array;
 			}
 		}
@@ -298,8 +329,8 @@ class functions_topicindex
 		$this->db->sql_freeresult($result2);
 
 		$output = array();
-		$output['inindex']	= $forum_data['default_inindex'];
-		$output['filter']	= $forum_data['tag_filter'];
+		$output['inindex'] = isset($forum_data['default_inindex']) ? $forum_data['default_inindex'] : 0;
+		$output['filter'] = isset($forum_data['tag_filter']) ? $forum_data['tag_filter'] : 0;
 
 		return $output;
 	}
diff --git "[FORUM_EXT]/dmzx\\topicindex/diff_full.tmp" "[FORUM_EXT]/dmzx\\topicindex/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\topicindex/diff_full.tmp"
@@ -0,0 +1,1699 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/CHANGELOG.md"
+index 5f44376ef..5e310d3e1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/CHANGELOG.md"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/CHANGELOG.md"
+@@ -1,9 +1,4 @@
+-## Topic IndexChangelog
+-
+-### 1.0.5 - 2020-01-15
+-- Drop support for 3.1.
+-- Twig update.
+-- Code update tables.yml
++## Changelog
+ 
+ ### 1.0.4 - 2017-04-13
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/config/services.yml"
+index 8555bf62c..13bc16f91 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/config/services.yml"
+@@ -37,6 +37,7 @@ services:
+             - '@request'
+             - '@controller.helper'
+             - '@config'
++            - '@dispatcher'
+             - '%core.root_path%'
+             - '%core.php_ext%'
+             - '%dmzx.topicindex.table.topicindex%'
+@@ -47,4 +48,5 @@ services:
+             - '@template'
+             - '@config'
+             - '@auth'
+-            - '@ext.manager'
+\ No newline at end of file
++            - '@dispatcher'
++            - '@ext.manager'
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/controller/main.php"
+index c90d4ff8c..77ca764db 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/controller/main.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/controller/main.php"
+@@ -10,6 +10,7 @@
+ namespace dmzx\topicindex\controller;
+ 
+ use dmzx\topicindex\core\functions_topicindex;
++use phpbb\event\dispatcher_interface;
+ use phpbb\template\template;
+ use phpbb\user;
+ use phpbb\auth\auth;
+@@ -45,6 +46,9 @@ class main
+ 	/** @var config */
+ 	protected $config;
+ 
++	/** @var dispatcher_interface */
++	protected $dispatcher;
++
+ 	/** @var string */
+ 	protected $root_path;
+ 
+@@ -69,6 +73,7 @@ class main
+ 	* @param request_interface		$request
+ 	* @param helper		 			$helper
+ 	* @param config					$config
++	* @param dispatcher_interface	$dispatcher
+ 	* @param string 				$root_path
+ 	* @param string 				$php_ext
+ 	* @param string 				$forum_lists_table
+@@ -82,6 +87,7 @@ class main
+ 		request_interface $request,
+ 		helper $helper,
+ 		config $config,
++		dispatcher_interface $dispatcher,
+ 		$root_path,
+ 		$php_ext,
+ 		$forum_lists_table
+@@ -95,6 +101,7 @@ class main
+ 		$this->request 				= $request;
+ 		$this->helper 				= $helper;
+ 		$this->config				= $config;
++		$this->dispatcher			= $dispatcher;
+ 		$this->root_path 			= $root_path;
+ 		$this->php_ext 				= $php_ext;
+ 		$this->forum_lists_table 	= $forum_lists_table;
+@@ -127,11 +134,7 @@ class main
+ 			redirect($zurl, false, true);
+ 		}
+ 
+-		// Navigation
+-		$this->template->assign_block_vars('navlinks', array(
+-			'FORUM_NAME'	=> $this->user->lang['OIINDEX_HEADER'],
+-			'U_VIEW_FORUM'	=> $zurl
+-		));
++		$selected_category = '';
+ 
+ 		if (empty($list))
+ 		{
+@@ -167,6 +170,11 @@ class main
+ 			$result	= $this->db->sql_query($sql);
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
++				if ($list == $row['list_id'])
++				{
++					$selected_category = $row['list_name'];
++				}
++
+ 				$s_list_options .= '<option value="' . $row['list_id'] . '"' . (($list == $row['list_id']) ? ' selected="selected"' : '') . '>' . $row['list_name'] . '</option>';
+ 			}
+ 			$this->db->sql_freeresult($result);
+@@ -186,7 +194,8 @@ class main
+ 			$row1		= $this->db->sql_fetchrow($result1);
+ 			$this->db->sql_freeresult($result1);
+ 
+-			$forumsari 	= json_decode($row1['list_forum']);
++			$forumsari 	= @json_decode($row1['list_forum']);
++			$forumsari	= is_array($forumsari) ? $forumsari : [];
+ 			$filtrini	= range('a', 'z');
+ 			$indexlist	= array();
+ 
+@@ -236,14 +245,26 @@ class main
+ 				{
+ 					if ($realfilter == $indexdata['key'])
+ 					{
+-						$this->template->assign_block_vars('block_list.block_topic_index', array(
+-							'ITOPIC_URL'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$indexdata['id']}"),
++						$template_vars = array(
++							'ITOPIC_URL'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$indexdata['forum_id']}&amp;t={$indexdata['id']}"),
+ 							'ITOPIC_TITLE'	=> $indexdata['title'],
+ 							'ITOPIC_POSTER'	=> get_username_string('full', $indexdata['posterid'], $indexdata['poster'], $indexdata['postercol']),
+ 							'ITOPIC_TOTREP'	=> $indexdata['posts'],
+ 							'U_REMOVE_FROM'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'iremove' => $indexdata['id'])),
+ 							'ITOPIC_CLASS'	=> ($nums % 2) ? 'row bg1' : 'row bg2'
+-						));
++						);
++
++						/**
++						 * Modify the topic index data before it is assigned to the template
++						 *
++						 * @event dmzx.topicindex.modify_block_topic_index_ary
++						 * @var		array	template_vars	Template block array with topic data
++						 * @since 1.0.5
++						 */
++						$vars = array('indexdata', 'template_vars');
++						extract($this->dispatcher->trigger_event('dmzx.topicindex.modify_block_topic_index_ary', compact($vars)));
++
++						$this->template->assign_block_vars('block_list.block_topic_index', $template_vars);
+ 						$nums++;
+ 					}
+ 				}
+@@ -252,18 +273,29 @@ class main
+ 			// Others data for menu
+ 			$this->template->assign_block_vars('block_nofiltrino', array(
+ 				'U_TUTTI'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list)),
+-				'U_09'		=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit=09')),
+-				'U_SYMB'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit=_')),
++				'U_09'		=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit' => '09')),
++				'U_SYMB'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit' => '_')),
+ 				'S_09'		=> (in_array('09', $fixa)) ? true : false,
+ 				'S_SYMB'	=> (in_array('_', $fixa)) ? true : false
+ 			));
+ 		}
+ 
++		$title = implode(' - ', array_filter([$this->user->lang['OIINDEX_HEADER'], $selected_category]));
++
++		// Navigation
++		$this->template->assign_block_vars('navlinks', array(
++			'FORUM_NAME'	=> $title,
++			'U_VIEW_FORUM'	=> $zurl
++		));
++
+ 		$this->functions_topicindex->assign_authors();
+ 
+-		$this->template->assign_var('TOPICINDEX_FOOTER_VIEW', true);
++		$this->template->assign_vars([
++			'TOPICINDEX_FOOTER_VIEW'	=> true,
++			'L_OIINDEX_HEADER'			=> $title,
++		]);
+ 
+ 		// Send all data to the template file
+-		return $this->helper->render('topiclist.html', $this->user->lang['OIINDEX_HEADER']);
++		return $this->helper->render('topiclist.html', $title);
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/core/functions_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/core/functions_topicindex.php"
+index ae23129db..4e118b351 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/core/functions_topicindex.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/core/functions_topicindex.php"
+@@ -10,6 +10,7 @@
+ namespace dmzx\topicindex\core;
+ 
+ use phpbb\db\driver\driver_interface as db_interface;
++use phpbb\event\dispatcher_interface;
+ use phpbb\template\template;
+ use phpbb\config\config;
+ use phpbb\auth\auth;
+@@ -29,6 +30,9 @@ class functions_topicindex
+ 	/** @var auth */
+ 	protected $auth;
+ 
++	/** @var dispatcher_interface */
++	protected $dispatcher;
++
+ 	/** @var manager */
+ 	protected $extension_manager;
+ 
+@@ -39,6 +43,7 @@ class functions_topicindex
+ 	* @param template		$template
+ 	* @param config			$config
+ 	* @param auth			auth
++	* @param dispatcher_interface $dispatcher
+ 	* @param manager 		$extension_manager
+ 	*/
+ 	public function __construct(
+@@ -46,6 +51,7 @@ class functions_topicindex
+ 		template $template,
+ 		config $config,
+ 		auth $auth,
++		dispatcher_interface $dispatcher,
+ 		manager $extension_manager
+ 	)
+ 	{
+@@ -53,6 +59,7 @@ class functions_topicindex
+ 		$this->template 			= $template;
+ 		$this->config				= $config;
+ 		$this->auth					= $auth;
++		$this->dispatcher			= $dispatcher;
+ 		$this->extension_manager	= $extension_manager;
+ 	}
+ 
+@@ -62,13 +69,24 @@ class functions_topicindex
+ 	*/
+ 	function get_topic_index($the_forum, $the_topic, $inlistvalue = 0, $tagfilter = 0)
+ 	{
+-		$sql = "SELECT topic_id, topic_title, topic_poster, topic_first_poster_name, topic_first_poster_colour, forum_id, topic_posts_approved, topic_title, inindex_topic, outindex_topic
+-			FROM " . TOPICS_TABLE . "
+-			WHERE forum_id = " . (int) $the_forum . "
+-				AND topic_posts_approved >= 1
+-				AND inindex_topic >= " . (int) $inlistvalue . "
+-				AND outindex_topic = 0
+-			ORDER BY topic_title ASC";
++		$sql_array = [
++			'SELECT'	=> 't.topic_id, t.topic_title, t.topic_poster, t.topic_first_poster_name, t.topic_first_poster_colour, t.forum_id, t.topic_posts_approved, t.inindex_topic, t.outindex_topic',
++			'FROM'		=> [TOPICS_TABLE => 't'],
++			'WHERE'		=> 't.forum_id = ' . (int) $the_forum . ' AND t.topic_posts_approved >= 1 AND t.inindex_topic >= ' . (int) $inlistvalue . ' AND t.outindex_topic = 0',
++			'ORDER_BY'	=> 't.topic_title ASC',
++		];
++
++		/**
++		 * Event to modify the SQL query that fetches topics
++		 *
++		 * @event dmzx.topicindex.sql_fetch_topics_before
++		 * @var array	sql_array	Array with SQL query data to fetch the current active sessions
++		 * @since 1.0.5
++		 */
++		$vars = ['sql_array'];
++		extract($this->dispatcher->trigger_event('dmzx.topicindex.sql_fetch_topics_before', compact($vars)));
++
++		$sql = $this->db->sql_build_query('SELECT', $sql_array);
+ 		$result	= $this->db->sql_query($sql);
+ 
+ 		$topiclist	= array();
+@@ -77,71 +95,70 @@ class functions_topicindex
+ 		{
+ 			if ($tagfilter == 1)
+ 			{
+-				switch (substr(trim($row['topic_title']),0,1))
++				switch (mb_substr(trim($row['topic_title']),0,1))
+ 				{
+ 					case '(':
+-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], ')') + 1);
++						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], ')') + 1);
+ 						$newstring	= trim($newstring);
+ 
+-						if (substr($newstring,0,1) == '(')
++						if (mb_substr($newstring,0,1) == '(')
+ 						{
+-							$newstring	= substr($newstring, strpos($row['topic_title'], ')') + 1);
++							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], ')') + 1);
+ 							$newstring	= trim($newstring);
+-							$keytag		= strtolower(substr($newstring,0,1));
+-							$keyBig		= strtolower(substr($newstring,0,4));
++							$keytag		= strtolower(mb_substr($newstring,0,1));
++							$keyBig		= strtolower(mb_substr($newstring,0,30));
+ 						}
+ 						else
+ 						{
+-							$keytag		= strtolower(substr($newstring,0,1));
+-							$keyBig		= strtolower(substr($newstring,0,4));
++							$keytag		= strtolower(mb_substr($newstring,0,1));
++							$keyBig		= strtolower(mb_substr($newstring,0,30));
+ 						}
+ 					break;
+ 					case '[':
+-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], ']') + 1);
++						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], ']') + 1);
+ 						$newstring	= trim($newstring);
+ 
+-						if (substr($newstring,0,1) == '[')
++						if (mb_substr($newstring,0,1) == '[')
+ 						{
+-							$newstring	= substr($newstring, strpos($row['topic_title'], ']') + 1);
++							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], ']') + 1);
+ 							$newstring	= trim($newstring);
+-							$keytag		= strtolower(substr($newstring,0,1));
+-							$keyBig		= strtolower(substr($newstring,0,4));
++							$keytag		= strtolower(mb_substr($newstring,0,1));
++							$keyBig		= strtolower(mb_substr($newstring,0,30));
+ 						}
+ 						else
+ 						{
+-							$keytag		= strtolower(substr($newstring,0,1));
+-							$keyBig		= strtolower(substr($newstring,0,4));
++							$keytag		= strtolower(mb_substr($newstring,0,1));
++							$keyBig		= strtolower(mb_substr($newstring,0,30));
+ 						}
+ 					break;
+ 					case '{':
+-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], '}') + 1);
++						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], '}') + 1);
+ 						$newstring	= trim($newstring);
+ 
+-						if (substr($newstring,0,1) == '{')
++						if (mb_substr($newstring,0,1) == '{')
+ 						{
+-							$newstring	= substr($newstring, strpos($row['topic_title'], '}') + 1);
++							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], '}') + 1);
+ 							$newstring	= trim($newstring);
+-							$keytag		= strtolower(substr($newstring,0,1));
+-							$keyBig		= strtolower(substr($newstring,0,4));
++							$keytag		= strtolower(mb_substr($newstring,0,1));
++							$keyBig		= strtolower(mb_substr($newstring,0,30));
+ 						}
+ 						else
+ 						{
+-							$keytag		= strtolower(substr($newstring,0,1));
+-							$keyBig		= strtolower(substr($newstring,0,4));
++							$keytag		= strtolower(mb_substr($newstring,0,1));
++							$keyBig		= strtolower(mb_substr($newstring,0,30));
+ 						}
+ 					break;
+ 					default:
+-						$keytag	= strtolower(substr($row['topic_title'],0,1));
+-						$keyBig	= strtolower(substr($row['topic_title'],0,4));
++						$keytag	= strtolower(mb_substr($row['topic_title'],0,1));
++						$keyBig	= strtolower(mb_substr($row['topic_title'],0,30));
+ 					break;
+ 				}
+ 			}
+ 			else
+ 			{
+-				$keytag	= strtolower(substr($row['topic_title'],0,1));
+-				$keyBig	= strtolower(substr($row['topic_title'],0,30));
++				$keytag	= strtolower(mb_substr($row['topic_title'],0,1));
++				$keyBig	= strtolower(mb_substr($row['topic_title'],0,30));
+ 			}
+-
+ 			if (preg_match('#^[a-z]#u', $keytag))
+ 			{
+ 				$keytag;
+@@ -158,6 +175,7 @@ class functions_topicindex
+ 			if ($row['topic_id'] != $the_topic)
+ 			{
+ 				$array['id']		= $row['topic_id'];
++				$array['forum_id']	= $row['forum_id'];
+ 				$array['key']		= $keytag;
+ 				$array['keybig']	= $keyBig;
+ 				$array['title']		= $row['topic_title'];
+@@ -165,11 +183,24 @@ class functions_topicindex
+ 				$array['posterid']	= $row['topic_poster'];
+ 				$array['poster']	= $row['topic_first_poster_name'];
+ 				$array['postercol']	= $row['topic_first_poster_colour'];
++
++				/**
++				 * Event to modify the SQL query that fetches topics
++				 *
++				 * @event dmzx.topicindex.sql_fetch_topics_after
++				 * @var array	topiclist	Array with all topics returned
++				 * @var array	array		Array with data returned for the current topic
++				 * @var array	row			Array with SQL fields from the current topic
++				 * @since 1.0.5
++				 */
++				$vars = ['topiclist', 'array', 'row'];
++				extract($this->dispatcher->trigger_event('dmzx.topicindex.sql_fetch_topics_after', compact($vars)));
++
+ 				$topiclist[] 		= $array;
+ 			}
+ 		}
+ 		$this->db->sql_freeresult($result);
+-
++		
+ 		/* order array */
+ 		if (count($topiclist) > 0)
+ 		{
+@@ -177,7 +208,7 @@ class functions_topicindex
+ 			{
+ 				$order_in_category[$key] = $row['keybig'];
+ 			}
+-			array_multisort ($order_in_category, SORT_ASC, $topiclist);
++			array_multisort($order_in_category, SORT_ASC, $topiclist);
+ 		}
+ 
+ 		return	$topiclist;
+@@ -298,8 +329,8 @@ class functions_topicindex
+ 		$this->db->sql_freeresult($result2);
+ 
+ 		$output = array();
+-		$output['inindex']	= $forum_data['default_inindex'];
+-		$output['filter']	= $forum_data['tag_filter'];
++		$output['inindex'] = isset($forum_data['default_inindex']) ? $forum_data['default_inindex'] : 0;
++		$output['filter'] = isset($forum_data['tag_filter']) ? $forum_data['tag_filter'] : 0;
+ 
+ 		return $output;
+ 	}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/diff_full.tmp"
+new file mode 100644
+index 000000000..cd24dd8a3
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/diff_full.tmp"
+@@ -0,0 +1,304 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/CHANGELOG.md"
++index 5f44376ef..5e310d3e1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/CHANGELOG.md"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/CHANGELOG.md"
++@@ -1,9 +1,4 @@
++-## Topic IndexChangelog
++-
++-### 1.0.5 - 2020-01-15
++-- Drop support for 3.1.
++-- Twig update.
++-- Code update tables.yml
+++## Changelog
++ 
++ ### 1.0.4 - 2017-04-13
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/config/services.yml"
++index 8555bf62c..13bc16f91 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/config/services.yml"
++@@ -37,6 +37,7 @@ services:
++             - '@request'
++             - '@controller.helper'
++             - '@config'
+++            - '@dispatcher'
++             - '%core.root_path%'
++             - '%core.php_ext%'
++             - '%dmzx.topicindex.table.topicindex%'
++@@ -47,4 +48,5 @@ services:
++             - '@template'
++             - '@config'
++             - '@auth'
++-            - '@ext.manager'
++\ No newline at end of file
+++            - '@dispatcher'
+++            - '@ext.manager'
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/controller/main.php"
++index c90d4ff8c..77ca764db 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/controller/main.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/controller/main.php"
++@@ -10,6 +10,7 @@
++ namespace dmzx\topicindex\controller;
++ 
++ use dmzx\topicindex\core\functions_topicindex;
+++use phpbb\event\dispatcher_interface;
++ use phpbb\template\template;
++ use phpbb\user;
++ use phpbb\auth\auth;
++@@ -45,6 +46,9 @@ class main
++ 	/** @var config */
++ 	protected $config;
++ 
+++	/** @var dispatcher_interface */
+++	protected $dispatcher;
+++
++ 	/** @var string */
++ 	protected $root_path;
++ 
++@@ -69,6 +73,7 @@ class main
++ 	* @param request_interface		$request
++ 	* @param helper		 			$helper
++ 	* @param config					$config
+++	* @param dispatcher_interface	$dispatcher
++ 	* @param string 				$root_path
++ 	* @param string 				$php_ext
++ 	* @param string 				$forum_lists_table
++@@ -82,6 +87,7 @@ class main
++ 		request_interface $request,
++ 		helper $helper,
++ 		config $config,
+++		dispatcher_interface $dispatcher,
++ 		$root_path,
++ 		$php_ext,
++ 		$forum_lists_table
++@@ -95,6 +101,7 @@ class main
++ 		$this->request 				= $request;
++ 		$this->helper 				= $helper;
++ 		$this->config				= $config;
+++		$this->dispatcher			= $dispatcher;
++ 		$this->root_path 			= $root_path;
++ 		$this->php_ext 				= $php_ext;
++ 		$this->forum_lists_table 	= $forum_lists_table;
++@@ -127,11 +134,7 @@ class main
++ 			redirect($zurl, false, true);
++ 		}
++ 
++-		// Navigation
++-		$this->template->assign_block_vars('navlinks', array(
++-			'FORUM_NAME'	=> $this->user->lang['OIINDEX_HEADER'],
++-			'U_VIEW_FORUM'	=> $zurl
++-		));
+++		$selected_category = '';
++ 
++ 		if (empty($list))
++ 		{
++@@ -167,6 +170,11 @@ class main
++ 			$result	= $this->db->sql_query($sql);
++ 			while ($row = $this->db->sql_fetchrow($result))
++ 			{
+++				if ($list == $row['list_id'])
+++				{
+++					$selected_category = $row['list_name'];
+++				}
+++
++ 				$s_list_options .= '<option value="' . $row['list_id'] . '"' . (($list == $row['list_id']) ? ' selected="selected"' : '') . '>' . $row['list_name'] . '</option>';
++ 			}
++ 			$this->db->sql_freeresult($result);
++@@ -186,7 +194,8 @@ class main
++ 			$row1		= $this->db->sql_fetchrow($result1);
++ 			$this->db->sql_freeresult($result1);
++ 
++-			$forumsari 	= json_decode($row1['list_forum']);
+++			$forumsari 	= @json_decode($row1['list_forum']);
+++			$forumsari	= is_array($forumsari) ? $forumsari : [];
++ 			$filtrini	= range('a', 'z');
++ 			$indexlist	= array();
++ 
++@@ -236,14 +245,26 @@ class main
++ 				{
++ 					if ($realfilter == $indexdata['key'])
++ 					{
++-						$this->template->assign_block_vars('block_list.block_topic_index', array(
++-							'ITOPIC_URL'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$indexdata['id']}"),
+++						$template_vars = array(
+++							'ITOPIC_URL'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$indexdata['forum_id']}&amp;t={$indexdata['id']}"),
++ 							'ITOPIC_TITLE'	=> $indexdata['title'],
++ 							'ITOPIC_POSTER'	=> get_username_string('full', $indexdata['posterid'], $indexdata['poster'], $indexdata['postercol']),
++ 							'ITOPIC_TOTREP'	=> $indexdata['posts'],
++ 							'U_REMOVE_FROM'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'iremove' => $indexdata['id'])),
++ 							'ITOPIC_CLASS'	=> ($nums % 2) ? 'row bg1' : 'row bg2'
++-						));
+++						);
+++
+++						/**
+++						 * Modify the topic index data before it is assigned to the template
+++						 *
+++						 * @event dmzx.topicindex.modify_block_topic_index_ary
+++						 * @var		array	template_vars	Template block array with topic data
+++						 * @since 1.0.5
+++						 */
+++						$vars = array('indexdata', 'template_vars');
+++						extract($this->dispatcher->trigger_event('dmzx.topicindex.modify_block_topic_index_ary', compact($vars)));
+++
+++						$this->template->assign_block_vars('block_list.block_topic_index', $template_vars);
++ 						$nums++;
++ 					}
++ 				}
++@@ -252,18 +273,29 @@ class main
++ 			// Others data for menu
++ 			$this->template->assign_block_vars('block_nofiltrino', array(
++ 				'U_TUTTI'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list)),
++-				'U_09'		=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit=09')),
++-				'U_SYMB'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit=_')),
+++				'U_09'		=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit' => '09')),
+++				'U_SYMB'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit' => '_')),
++ 				'S_09'		=> (in_array('09', $fixa)) ? true : false,
++ 				'S_SYMB'	=> (in_array('_', $fixa)) ? true : false
++ 			));
++ 		}
++ 
+++		$title = implode(' - ', array_filter([$this->user->lang['OIINDEX_HEADER'], $selected_category]));
+++
+++		// Navigation
+++		$this->template->assign_block_vars('navlinks', array(
+++			'FORUM_NAME'	=> $title,
+++			'U_VIEW_FORUM'	=> $zurl
+++		));
+++
++ 		$this->functions_topicindex->assign_authors();
++ 
++-		$this->template->assign_var('TOPICINDEX_FOOTER_VIEW', true);
+++		$this->template->assign_vars([
+++			'TOPICINDEX_FOOTER_VIEW'	=> true,
+++			'L_OIINDEX_HEADER'			=> $title,
+++		]);
++ 
++ 		// Send all data to the template file
++-		return $this->helper->render('topiclist.html', $this->user->lang['OIINDEX_HEADER']);
+++		return $this->helper->render('topiclist.html', $title);
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/core/functions_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/core/functions_topicindex.php"
++index ae23129db..4e118b351 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/core/functions_topicindex.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/core/functions_topicindex.php"
++@@ -10,6 +10,7 @@
++ namespace dmzx\topicindex\core;
++ 
++ use phpbb\db\driver\driver_interface as db_interface;
+++use phpbb\event\dispatcher_interface;
++ use phpbb\template\template;
++ use phpbb\config\config;
++ use phpbb\auth\auth;
++@@ -29,6 +30,9 @@ class functions_topicindex
++ 	/** @var auth */
++ 	protected $auth;
++ 
+++	/** @var dispatcher_interface */
+++	protected $dispatcher;
+++
++ 	/** @var manager */
++ 	protected $extension_manager;
++ 
++@@ -39,6 +43,7 @@ class functions_topicindex
++ 	* @param template		$template
++ 	* @param config			$config
++ 	* @param auth			auth
+++	* @param dispatcher_interface $dispatcher
++ 	* @param manager 		$extension_manager
++ 	*/
++ 	public function __construct(
++@@ -46,6 +51,7 @@ class functions_topicindex
++ 		template $template,
++ 		config $config,
++ 		auth $auth,
+++		dispatcher_interface $dispatcher,
++ 		manager $extension_manager
++ 	)
++ 	{
++@@ -53,6 +59,7 @@ class functions_topicindex
++ 		$this->template 			= $template;
++ 		$this->config				= $config;
++ 		$this->auth					= $auth;
+++		$this->dispatcher			= $dispatcher;
++ 		$this->extension_manager	= $extension_manager;
++ 	}
++ 
++@@ -62,13 +69,24 @@ class functions_topicindex
++ 	*/
++ 	function get_topic_index($the_forum, $the_topic, $inlistvalue = 0, $tagfilter = 0)
++ 	{
++-		$sql = "SELECT topic_id, topic_title, topic_poster, topic_first_poster_name, topic_first_poster_colour, forum_id, topic_posts_approved, topic_title, inindex_topic, outindex_topic
++-			FROM " . TOPICS_TABLE . "
++-			WHERE forum_id = " . (int) $the_forum . "
++-				AND topic_posts_approved >= 1
++-				AND inindex_topic >= " . (int) $inlistvalue . "
++-				AND outindex_topic = 0
++-			ORDER BY topic_title ASC";
+++		$sql_array = [
+++			'SELECT'	=> 't.topic_id, t.topic_title, t.topic_poster, t.topic_first_poster_name, t.topic_first_poster_colour, t.forum_id, t.topic_posts_approved, t.inindex_topic, t.outindex_topic',
+++			'FROM'		=> [TOPICS_TABLE => 't'],
+++			'WHERE'		=> 't.forum_id = ' . (int) $the_forum . ' AND t.topic_posts_approved >= 1 AND t.inindex_topic >= ' . (int) $inlistvalue . ' AND t.outindex_topic = 0',
+++			'ORDER_BY'	=> 't.topic_title ASC',
+++		];
+++
+++		/**
+++		 * Event to modify the SQL query that fetches topics
+++		 *
+++		 * @event dmzx.topicindex.sql_fetch_topics_before
+++		 * @var array	sql_array	Array with SQL query data to fetch the current active sessions
+++		 * @since 1.0.5
+++		 */
+++		$vars = ['sql_array'];
+++		extract($this->dispatcher->trigger_event('dmzx.topicindex.sql_fetch_topics_before', compact($vars)));
+++
+++		$sql = $this->db->sql_build_query('SELECT', $sql_array);
++ 		$result	= $this->db->sql_query($sql);
++ 
++ 		$topiclist	= array();
++@@ -77,71 +95,70 @@ class functions_topicindex
++ 		{
++ 			if ($tagfilter == 1)
++ 			{
++-				switch (substr(trim($row['topic_title']),0,1))
+++				switch (mb_substr(trim($row['topic_title']),0,1))
++ 				{
++ 					case '(':
++-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], ')') + 1);
+++						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], ')') + 1);
++ 						$newstring	= trim($newstring);
++ 
++-						if (substr($newstring,0,1) == '(')
+++						if (mb_substr($newstring,0,1) == '(')
++ 						{
++-							$newstring	= substr($newstring, strpos($row['topic_title'], ')') + 1);
+++							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], ')') + 1);
++ 							$newstring	= trim($newstring);
++-							$keytag		= strtolower(substr($newstring,0,1));
++-							$keyBig		= strtolower(substr($newstring,0,4));
+++							$keytag		= strtolower(mb_substr($newstring,0,1));
+++							$keyBig		= strtolower(mb_substr($newstring,0,30));
++ 						}
++ 						else
++ 						{
++-							$keytag		= strtolower(substr($newstring,0,1));
++-							$keyBig		= strtolower(substr($newstring,0,4));
+++							$keytag		= strtolower(mb_substr($newstring,0,1));
+++							$keyBig		= strtolower(mb_substr($newstring,0,30));
++ 						}
++ 					break;
++ 					case '[':
++-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], ']') + 1);
+++						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], ']') + 1);
++ 						$newstring	= trim($newstring);
++ 
++-						if (substr($newstring,0,1) == '[')
+++						if (mb_substr($newstring,0,1) == '[')
++ 						{
++-							$newstring	= substr($newstring, strpos($row['topic_title'], ']') + 1);
+++							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], ']') + 1);
++ 							$newstring	= trim($newstring);
++-							$keytag		= strtolower(substr($newstring,0,1));
++-							$keyBig		= strtolower(substr($newstring,0,4));
+++							$keytag		= strtolower(mb_substr($newstring,0,1));
+++							$keyBig		= strtolower(mb_subs
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/ext.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/ext.php"
+deleted file mode 100644
+index ca95024cf..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/ext.php"
++++ /dev/null
+@@ -1,19 +0,0 @@
+-<?php
+-/**
+-*
+-* @package phpBB Extension - Topic Index
+-* @copyright (c) 2020 dmzx - https://www.dmzx-web.net
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-namespace dmzx\topicindex;
+-
+-class ext extends \phpbb\extension\base
+-{
+-	public function is_enableable()
+-	{
+-		$config = $this->container->get('config');
+-		return version_compare($config['version'], '3.2.0', '>=');
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/acp_topicindex.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/acp_topicindex.php"
+deleted file mode 100644
+index d52046fe7..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/acp_topicindex.php"
++++ /dev/null
+@@ -1,62 +0,0 @@
+-<?php
+-/**
+-*
+-* @version $Id: acp_topicindex.php 50 2017-01-22 01:57:07Z Scanialady $
+-* @package phpBB Extension - Topic Index [Deutsch]
+-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-/**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ‚ ‘ ’ « » „ “ ” …
+-//
+-
+-// Merge the following language entries into the lang array
+-$lang = array_merge($lang, array(
+-	'OFFICIAL_TOPIC_INDEX'			=> 'Verwalte Official Topic Index Extension',
+-	'ADD_NEW_TOPICS_LIST'			=> 'Neue Liste hinzufügen',
+-	'LIST_NAME'						=> 'Listenname',
+-	'OINDEX_CFG_SETUP'				=> 'Konfiguriere Official Topic Index',
+-	'OVERFLOW_IN_TOPIC'				=> 'Erlaube Laufleiste auf der internen Themenliste',
+-	'NAME_FORUM_LIST_EMPTY'			=> 'Der Listenname darf nicht leer sein.',
+-	'SELECT_FORUM_LIST_EMPTY'		=> 'Mindestens ein Forum muss ausgewählt werden.',
+-	'OINDEX_ADDED_LIST'				=> 'Liste erfolgreich gespeichert.',
+-	'OINDEX_DELETED_LIST'			=> 'Liste erfolgreich gelöscht.',
+-	'OINDEX_EDIT_CFG'				=> 'Konfiguration von Official Topic Index erfolgreich geändert.',
+-	'OINDEX_FORUMS'					=> 'Foren',
+-	'OINDEX_SELECT_FORUM'			=> 'Wähle ein Forum',
+-	'OTINDEX_LIST_ALONE_DSC'		=> 'Erstelle eine externe Liste von allen Themen eines einzelnen Forums, oder aus einer Auswahl mehrerer Foren zusammen. Im Gegensatz zu einer Liste in einem Thema, muss die externe nicht direkt in dem Forum aktiviert werden. Aber in dem Fall werden alle Themen aufgelistet, ohne eine Auswahlmöglichkeit.',
+-	'OTINDEX_LIST_INTOPIC_DSC'		=> 'Erstelle eine organisierte Themenliste, welche innerhalb eines ausgewählten Themas erscheinen wird. Sobald du diese Funktion aktiviert hast, erscheinen in jedem ersten Beitrag jedes Themas neue Icons zum Einfügen oder Entfernen des Themas aus der Liste.',
+-	'ACTIVE_TOPIC_INDEX'			=> 'Aktiviere, und wähle das Thema für die Liste',
+-	'TOPIC_INDEX_DEFAULT'			=> 'Wähle aus, welche Themen standardmäßig hinzuzufügen sind.',
+-	'ACTIVE_TOPIC_INDEX_EXPLAIN'	=> 'Wähle ein Thema aus den <strong>Wichtigen Themen oder Ankündigungsthemen</strong>, dieses Thema wird die Themenliste werden. Du musst deshalb mindestens ein Thema in diesem Forum haben.',
+-	'TOPIC_INDEX_DEFAULT_EXPLAIN'	=> 'Wähle das System, nach welchem die Themen in der Liste eingebunden werden sollen',
+-	'ACTIVE_INDEX_FILTER'			=> 'Aktiviere Tag-Filter',
+-	'ACTIVE_INDEX_FILTER_EXPLAIN'	=> 'Du musst dies aktivieren, wenn du Themen mit gemeinsamem TAG im Titel hasts. Wir unterstützen Tags mit diesem Format, einzeln oder doppelt: <strong>[]</strong>,<strong>{}</strong>,<strong>()</strong>.',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/common.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/common.php"
+deleted file mode 100644
+index 3eec423ff..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/common.php"
++++ /dev/null
+@@ -1,58 +0,0 @@
+-<?php
+-/**
+-*
+-* @version $Id: common.php 50 2017-01-22 01:57:07Z Scanialady $
+-* @package phpBB Extension - Topic Index [Deutsch]
+-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-/**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-//	‚ ‘ ’ « » „ “ ” …
+-//
+-
+-$lang = array_merge($lang, array(
+-	'ADD_INILIST'					=> '+Liste',
+-	'REMOVE_INILIST'				=> '-Liste',
+-	'OTINDEX_LINK_TITLE'			=> 'Themenliste',
+-	'NUM'							=> 'Nr.',
+-	'POSTER'						=> 'Verfasst von',
+-	'INDEX_POST_PRES'				=> 'Bevor du ein neues Thema eröffnest, prüfe bitte, ob es nicht bereits in dieser Liste ist. Wenn bereits vorhanden, benutze dieses Thema, um deine Beiträge zu schreiben.<br />Danke.',
+-	'NON_ACTIVE'					=> 'Inaktiv',
+-	'DEF_ALL_TOPICS_IN'				=> 'Alle neuen Themen automatisch',
+-	'DEF_ALL_TOPICS_OFF'			=> 'Füge Themen manuell zur Liste hinzu',
+-	'REMOVE_FROM_LIST'				=> 'entfernen',
+-	'TOPICINDEX_VERSION'			=> 'Version',
+-	'ALL'							=> 'Alle',
+-	'09'							=> '0-9',
+-	'SYMB'							=> '#&%',
+-	'ANY_TOPIC_IN_LIST'				=> 'Alle Themen in der Liste',
+-	'SELECT_A_LIST'					=> 'Wähle eine Liste',
+-	'OIINDEX_HEADER'				=> 'Official Topic Index - Themenliste',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/info_acp_topicindex.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/info_acp_topicindex.php"
+deleted file mode 100644
+index 9e4417d71..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/info_acp_topicindex.php"
++++ /dev/null
+@@ -1,48 +0,0 @@
+-<?php
+-/**
+-*
+-* @version $Id: info_acp_topicindex.php 50 2017-01-22 01:57:07Z Scanialady $
+-* @package phpBB Extension - Topic Index [Deutsch]
+-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-/**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ‚ ‘ ’ « » „ “ ” …
+-//
+-
+-// Merge the following language entries into the lang array
+-$lang = array_merge($lang, array(
+-	'ACP_CAT_OINDEX'				=> 'Official Topic Index',
+-	'ACP_OINDEX_CFG'				=> 'Konfiguration',
+-	//Log
+-	'LOG_OINDEX_ADDLIST'			=> '<strong>Neue Themenliste hinzugefügt.</strong><br />%s',
+-	'LOG_OINDEX_DELETELIST'			=> '<strong>Themenliste entfernt.</strong><br />%s',
+-	'LOG_OINDEX_EDITCFG'			=> '<strong>Konfiguration von Official Topic Index bearbeitet.</strong><br />%s',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/en/common.php"
+index 245589076..91e3f19fa 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/en/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/en/common.php"
+@@ -53,5 +53,5 @@ $lang = array_merge($lang, array(
+ 	'SYMB'							=> '#&%',
+ 	'ANY_TOPIC_IN_LIST'				=> 'Any topics',
+ 	'SELECT_A_LIST'					=> 'Select a list',
+-	'OIINDEX_HEADER'				=> 'Official Topic Index - Topics List',
++	'OIINDEX_HEADER'				=> 'Topics List',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/acp_topicindex.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/acp_topicindex.php"
+deleted file mode 100644
+index 91b3b3416..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/acp_topicindex.php"
++++ /dev/null
+@@ -1,62 +0,0 @@
+-<?php
+-/**
+-*
+-* @package phpBB Extension - Topic Index
+-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
+-* Nederlandse vertaling @ Solidjeuh <http://www.froddelpower.be>
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-/**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
+-
+-// Merge the following language entries into the lang array
+-$lang = array_merge($lang, array(
+-	'OFFICIAL_TOPIC_INDEX'			=> 'Beheer Officiële Topic Index Extensie',
+-	'ADD_NEW_TOPICS_LIST'			=> 'Voeg nieuwe lijst toe',
+-	'LIST_NAME'						=> 'Lijst naam',
+-	'OINDEX_CFG_SETUP'				=> 'Configureer Officiële Topic Index',
+-	'OVERFLOW_IN_TOPIC'				=> 'Sta scroll bar toe in de binnenste topic lijst',
+-	'NAME_FORUM_LIST_EMPTY'			=> 'De lijst naam kan niet leeg zijn.',
+-	'SELECT_FORUM_LIST_EMPTY'		=> 'Er moet op zijn minst een forum geselecteerd zijn.',
+-	'OINDEX_ADDED_LIST'				=> 'Lijst succesvol opgeslagen.',
+-	'OINDEX_DELETED_LIST'			=> 'Lijst succesvol verwijderd.',
+-	'OINDEX_EDIT_CFG'				=> 'Configuratie van Officiële Topic Index succesvol bewerkt.',
+-	'OINDEX_FORUMS'					=> 'Forums',
+-	'OINDEX_SELECT_FORUM'			=> 'Selecteer een forum',
+-	'OTINDEX_LIST_ALONE_DSC'		=> 'Maak een externe lijst van alle topics in een bepaald forum of meerdere forums samen. De externe lijst hoeft niet geactiveerd te zijn in het forum. Maar zal in dat geval alle topics opnemen.',
+-	'OTINDEX_LIST_INTOPIC_DSC'		=> 'Maak een georganiseerde topic lijst die zal verschijnen in een gekozen onderwerp. Zodra je deze functie activeert zullen bij elke eerste post van een topic nieuwe iconen verschijnen om de topic toe te voegen of te verwijderen van de lijst.',
+-	'ACTIVE_TOPIC_INDEX'			=> 'Activeer en selecteer de topic voor de lijst',
+-	'TOPIC_INDEX_DEFAULT'			=> 'Kies welke topics er standaard worden toegevoegd.',
+-	'ACTIVE_TOPIC_INDEX_EXPLAIN'	=> 'Kies de topic van een sticky of een mededeling. Topics zullen een lijst worden. Je moet dus op zijn minst 1 topic in het forum hebben.',
+-	'TOPIC_INDEX_DEFAULT_EXPLAIN'	=> 'Kies het systeem waarmee de onderwerpen opgenomen worden in de lijst',
+-	'ACTIVE_INDEX_FILTER'			=> 'Actieve tag filter',
+-	'ACTIVE_INDEX_FILTER_EXPLAIN'	=> 'Je moet dit activeren als je topics hebt met gemeenschappelijke TAGS hebt in de titel. We ondersteunen tags met dit formaat, enkel of dubbel: <strong>[]</strong>,<strong>{}</strong>,<strong>()</strong>.',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/info_acp_topicindex.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/info_acp_topicindex.php"
+deleted file mode 100644
+index 71bb32ab8..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/info_acp_topicindex.php"
++++ /dev/null
+@@ -1,48 +0,0 @@
+-<?php
+-/**
+-*
+-* @package phpBB Extension - Topic Index
+-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
+-* Nederlandse vertaling @ Solidjeuh <http://www.froddelpower.be>
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-/**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
+-
+-// Merge the following language entries into the lang array
+-$lang = array_merge($lang, array(
+-	'ACP_CAT_OINDEX'				=> 'Officiële Topic Index',
+-	'ACP_OINDEX_CFG'				=> 'Configuratie',
+-	//Log
+-	'LOG_OINDEX_ADDLIST'			=> '<strong>Nieuwe topic lijst toegevoegd.</strong><br />%s',
+-	'LOG_OINDEX_DELETELIST'			=> '<strong>Topic lijst verwijderd.</strong><br />%s',
+-	'LOG_OINDEX_EDITCFG'			=> '<strong>Bewerkte de configuratie van Offici&euml;le topic index</strong><br />%s',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/acp_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/acp_topicindex.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/acp_topicindex.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/acp_topicindex.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/common.php"
+similarity index 70%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/common.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/common.php"
+index cceede427..384068c2d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/common.php"
+@@ -39,11 +39,11 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, array(
+ 	'ADD_INILIST'					=> '+Lista',
+ 	'REMOVE_INILIST'				=> '-Lista',
+-	'OTINDEX_LINK_TITLE'			=> 'Lista de tópicos',
++	'OTINDEX_LINK_TITLE'			=> 'Lista de Tópicos',
+ 	'NUM'							=> 'N°',
+-	'POSTER'						=> 'Postada por',
+-	'INDEX_POST_PRES'				=> 'Antes de abrir um novo tópico, por favor verifique se ele já existe na lista. Se existir, use aquele tópico para escrever suas mensagens.<br />Obrigado',
+-	'NON_ACTIVE'					=> 'Inativo',
++	'POSTER'						=> 'Enviado por',
++	'INDEX_POST_PRES'				=> 'Antes de abrir um novo tópico, por favor verifica se já existe na lista. Se existir, usa esse tópico para escrever uma mensagem.<br />Obrigado',
++	'NON_ACTIVE'					=> 'Inactivo',
+ 	'DEF_ALL_TOPICS_IN'				=> 'Todos os novos tópicos automaticamente',
+ 	'DEF_ALL_TOPICS_OFF'			=> 'Adiciona tópicos manualmente à lista',
+ 	'REMOVE_FROM_LIST'				=> 'remover',
+@@ -51,7 +51,13 @@ $lang = array_merge($lang, array(
+ 	'ALL'							=> 'Todos',
+ 	'09'							=> '0-9',
+ 	'SYMB'							=> '#&%',
+-	'ANY_TOPIC_IN_LIST'				=> 'Qualquer tópico',
+-	'SELECT_A_LIST'					=> 'Selecione uma lista',
+-	'OIINDEX_HEADER'				=> 'Official Topic Index - Topics List',
++	'ANY_TOPIC_IN_LIST'				=> 'Nenhum tópico enviado!',
++	'SELECT_A_LIST'					=> 'Seleccione uma lista',
++	'OIINDEX_HEADER'				=> 'Lista de tópicos',
++	'LANGUAGE'				        => 'Idioma',
++	'CATEGORY'				        => 'Categoria',
++	'COMMENTS'				        => 'Comentários',
++	'BUTTON_UPLOAD'				    => 'Partilhar Projecto',
++	'BUTTON_UPLOAD_EXPLAIN'		    => 'Sim! Começa a partilhar projectos na nossa comunidade!',
++	
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/info_acp_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/info_acp_topicindex.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/info_acp_topicindex.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/info_acp_topicindex.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/permissions_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/permissions_topicindex.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/permissions_topicindex.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/permissions_topicindex.php"
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/acp_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/acp_topicindex.php"
+new file mode 100644
+index 000000000..8a9dd1333
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/acp_topicindex.php"
+@@ -0,0 +1,61 @@
++<?php
++/**
++*
++* @package phpBB Extension - Topic Index
++* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++// DEVELOPERS PLEASE NOTE
++//
++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++//
++// Placeholders can now contain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// translators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++// equally where a string contains only two placeholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++//
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++//
++
++// Merge the following language entries into the lang array
++$lang = array_merge($lang, array(
++	'OFFICIAL_TOPIC_INDEX'			=> 'Gerencia a extensão Official Topic Index',
++	'ADD_NEW_TOPICS_LIST'			=> 'Adiciona uma nova lista',
++	'LIST_NAME'						=> 'Nome da lista',
++	'OINDEX_CFG_SETUP'				=> 'Configura a Official Topic Index',
++	'OVERFLOW_IN_TOPIC'				=> 'Permite barra de rolagem na lista de tópicos',
++	'NAME_FORUM_LIST_EMPTY'			=> 'O nome da lista não pode estar vazio.',
++	'SELECT_FORUM_LIST_EMPTY'		=> 'Pelo menos um fórum deve ser selecionado.',
++	'OINDEX_ADDED_LIST'				=> 'Lista salva com sucesso.',
++	'OINDEX_DELETED_LIST'			=> 'Lista deletada com sucesso.',
++	'OINDEX_EDIT_CFG'				=> 'Configuração da Official Topic Index editada com sucesso.',
++	'OINDEX_FORUMS'					=> 'Fóruns',
++	'OINDEX_SELECT_FORUM'			=> 'Selecione um fórum',
++	'OTINDEX_LIST_ALONE_DSC'		=> 'Cria uma lista externa de todos os tópicos de um único fórum ou um conjunto de fóruns. Ao invés de uma lista no tópico, as externas não necessitam ser ativadas diretamente no fórum mas neste caso serão listados todos os tópicos sem nenhuma escolha.',
++	'OTINDEX_LIST_INTOPIC_DSC'		=> 'Cria uma lista de tópicos organizada que irá aparecer dentro de um tópico escolhido. Uma vez que você ative esta função, aparecerão novos ícones para inserir ou remover tópicos da lista em todos as primeiras mensagens de cada tópico.',
++	'ACTIVE_TOPIC_INDEX'			=> 'Ativa e seleciona o tópico para a lista',
++	'TOPIC_INDEX_DEFAULT'			=> 'Escolha quais tópicos adicionar por padrão.',
++	'ACTIVE_TOPIC_INDEX_EXPLAIN'	=> 'Escolha o tópico nos tópicos <strong>fixos ou anúncios</strong> que se converterão na lista. Para isso, você deve ter ao menos um tópico no fórum.',
++	'TOPIC_INDEX_DEFAULT_EXPLAIN'	=> 'Escolha o sistema pelo qual os tópicos serão incluídos à lista',
++	'ACTIVE_INDEX_FILTER'			=> 'Ativa filtro de tag',
++	'ACTIVE_INDEX_FILTER_EXPLAIN'	=> 'Você deve ativar isso se você tem tópicos com uma TAG comum no título. Nós suportamos tags com formato simples ou duplo: <strong>[]</strong>,<strong>{}</strong>,<strong>()</strong>.',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/common.php"
+similarity index 52%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/common.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/common.php"
+index b8cc92cb9..384068c2d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/common.php"
+@@ -3,7 +3,6 @@
+ *
+ * @package phpBB Extension - Topic Index
+ * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
+-* Nederlandse vertaling @ Solidjeuh <http://www.froddelpower.be>
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+@@ -38,21 +37,27 @@ if (empty($lang) || !is_array($lang))
+ //
+ 
+ $lang = array_merge($lang, array(
+-	'ADD_INILIST'					=> '+Lijst',
+-	'REMOVE_INILIST'				=> '-Lijst',
+-	'OTINDEX_LINK_TITLE'			=> 'Topics lijst',
++	'ADD_INILIST'					=> '+Lista',
++	'REMOVE_INILIST'				=> '-Lista',
++	'OTINDEX_LINK_TITLE'			=> 'Lista de Tópicos',
+ 	'NUM'							=> 'N°',
+-	'POSTER'						=> 'Gepost door',
+-	'INDEX_POST_PRES'				=> 'Kijk eerst eens in deze lijst dat de topic niet reeds bestaat alvorens een nieuwe topic te openen.<br />Bedankt.',
+-	'NON_ACTIVE'					=> 'Inactief',
+-	'DEF_ALL_TOPICS_IN'				=> 'Alle nieuwe topics automatisch',
+-	'DEF_ALL_TOPICS_OFF'			=> 'Voeg manueel topics toe in de lijst.',
+-	'REMOVE_FROM_LIST'				=> 'verwijder',
+-	'TOPICINDEX_VERSION'			=> 'Versie',
+-	'ALL'							=> 'Alle',
++	'POSTER'						=> 'Enviado por',
++	'INDEX_POST_PRES'				=> 'Antes de abrir um novo tópico, por favor verifica se já existe na lista. Se existir, usa esse tópico para escrever uma mensagem.<br />Obrigado',
++	'NON_ACTIVE'					=> 'Inactivo',
++	'DEF_ALL_TOPICS_IN'				=> 'Todos os novos tópicos automaticamente',
++	'DEF_ALL_TOPICS_OFF'			=> 'Adiciona tópicos manualmente à lista',
++	'REMOVE_FROM_LIST'				=> 'remover',
++	'TOPICINDEX_VERSION'			=> 'Versão',
++	'ALL'							=> 'Todos',
+ 	'09'							=> '0-9',
+ 	'SYMB'							=> '#&%',
+-	'ANY_TOPIC_IN_LIST'				=> 'Alle topics',
+-	'SELECT_A_LIST'					=> 'Selecteer een lijst',
+-	'OIINDEX_HEADER'				=> 'Officiële Topic Index - Topics Lijst',
++	'ANY_TOPIC_IN_LIST'				=> 'Nenhum tópico enviado!',
++	'SELECT_A_LIST'					=> 'Seleccione uma lista',
++	'OIINDEX_HEADER'				=> 'Lista de tópicos',
++	'LANGUAGE'				        => 'Idioma',
++	'CATEGORY'				        => 'Categoria',
++	'COMMENTS'				        => 'Comentários',
++	'BUTTON_UPLOAD'				    => 'Partilhar Projecto',
++	'BUTTON_UPLOAD_EXPLAIN'		    => 'Sim! Começa a partilhar projectos na nossa comunidade!',
++	
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/permissions_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/info_acp_topicindex.php"
+similarity index 72%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/permissions_topicindex.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/info_acp_topicindex.php"
+index d0a84318c..d1cedf477 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/permissions_topicindex.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/info_acp_topicindex.php"
+@@ -1,7 +1,6 @@
+ <?php
+ /**
+ *
+-* @version $Id: permissions_topicindex.php 51 2017-01-22 14:05:52Z Scanialady $
+ * @package phpBB Extension - Topic Index
+ * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+@@ -34,10 +33,15 @@ if (empty($lang) || !is_array($lang))
+ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+ //
+ // Some characters you may want to copy&paste:
+-// ‚ ‘ ’ « » „ “ ” …
++// ’ » “ ” …
+ //
+ 
+ // Merge the following language entries into the lang array
+ $lang = array_merge($lang, array(
+-	'ACL_U_TOPICINDEX'		=> 'Kann „Official Topic Index“-Themenliste sehen',
++	'ACP_CAT_OINDEX'				=> 'Official Topic Index',
++	'ACP_OINDEX_CFG'				=> 'Configuração',
++	//Log
++	'LOG_OINDEX_ADDLIST'			=> '<strong>Adicionada nova lista de tópicos.</strong><br />%s',
++	'LOG_OINDEX_DELETELIST'			=> '<strong>Excluída lista de tópicos.</strong><br />%s',
++	'LOG_OINDEX_EDITCFG'			=> '<strong>Editada a configuração da Official Topic Index.</strong><br />%s',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/permissions_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/permissions_topicindex.php"
+similarity index 88%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/permissions_topicindex.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/permissions_topicindex.php"
+index 64b674fcd..238626333 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/permissions_topicindex.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/permissions_topicindex.php"
+@@ -3,7 +3,6 @@
+ *
+ * @package phpBB Extension - Topic Index
+ * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
+-* Nederlandse vertaling @ Solidjeuh <http://www.froddelpower.be>
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+@@ -39,5 +38,5 @@ if (empty($lang) || !is_array($lang))
+ 
+ // Merge the following language entries into the lang array
+ $lang = array_merge($lang, array(
+-	'ACL_U_TOPICINDEX'		=> 'Kan de Officiële Topic Index - Topics lijst bekijken',
++	'ACL_U_TOPICINDEX'		=> 'Pode ver a Official Topic Index - Topics List',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_footer_copyright_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_footer_copyright_append.html"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_footer_copyright_append.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_footer_copyright_append.html"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_header_head_append.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
+similarity index 61%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_header_navigation_append.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
+index 0fdd2f70d..fa2318741 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_header_navigation_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
+@@ -1,7 +1,7 @@
+ {% if TOPICINDEXLIST_VIEW %}
+ <li data-last-responsive="true">
+ 	<a href="{{ U_OTINDEX }}" title="{{ lang('OTINDEX_LINK_TITLE') }}" role="menuitem">
+-		<i class="icon fa-envelope fa-fw" aria-hidden="true"></i><span>{{ lang('OTINDEX_LINK_TITLE') }}</span>
++		<i class="icon fa fa-envelope fa-fw" aria-hidden="true"></i><span>{{ lang('OTINDEX_LINK_TITLE') }}</span>
+ 	</a>
+ </li>
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/viewtopic_body_post_buttons_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_after.html"
+similarity index 56%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/viewtopic_body_post_buttons_after.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_after.html"
+index eda22677b..3c096b49f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/viewtopic_body_post_buttons_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_after.html"
+@@ -1,8 +1,8 @@
+-{% if U_MCP && postrow.U_ININDEXLIST %}
+-<li>
+-	<a href="{{ postrow.U_ININDEXLIST }}" title="{{ postrow.IINEDX_LANG }}" class="button button-icon-only">
++{% if U_ACP && postrow.U_ININDEXLIST %}
++<div class="btn-group btn-group-sm" role="group">
++	<a href="{{ postrow.U_ININDEXLIST }}" title="{{ postrow.IINEDX_LANG }}" class="btn btn-default btn-sm">
+ 		<i class="icon {{ postrow.IINDEX_ICON }}" aria-hidden="true"></i>
+ 		<span class="sr-only">{{ postrow.IINEDX_LANG }}</span>
+ 	</a>
+-</li>
+-{% endif %}
+\ No newline at end of file
++</div>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/official_topic_index.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/official_topic_index.html"
+new file mode 100644
+index 000000000..2d85a8ee9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/official_topic_index.html"
+@@ -0,0 +1,58 @@
++<div id="{{ S_ISTYLE }}">
++	<strong>{{ lang('INDEX_POST_PRES') }}</strong>
++	<fieldset>
++		{% EVENT dmzx_topic_index_topic_filter_container_before %}
++		<p class="filtrino icenter">
++			{% for block_nofiltrino in loops.block_nofiltrino %}
++				<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_TUTTI }}">{{ lang('ALL') }}</a></span>
++				{% if block_nofiltrino.S_09 %}<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_09 }}">{{ lang('09') }}</a></span>{% else %}<span class="btn-basic btn-xs">{{ lang('09') }}</span>{% endif %}
++				{% if block_nofiltrino.S_SYMB %}<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_SYMB }}">{{ lang('SYMB') }}</a></span>{% else %}<span class="btn-basic btn-xs">{{ lang('SYMB') }}</span>{% endif %}
++			{% endfor %}
++			{% for block_filtrino in loops.block_filtrino %}
++				{% EVENT dmzx_topic_index_topic_filter_before %}
++				{% if block_filtrino.S_ISWITH %}
++					<span class="btn btn-default btn-xs"><a href="{{ block_filtrino.U_FILTER }}">{{ block_filtrino.FILTRINO }}</a></span>
++				{% else %}
++					<span class="btn-basic btn-xs">{{ block_filtrino.FILTRINO }}</span>
++				{% endif %}
++				{% EVENT dmzx_topic_index_topic_filter_after %}
++			{% endfor %}
++		</p>
++		{% EVENT dmzx_topic_index_topic_filter_container_after %}
++	</fieldset>
++    <div class="filtrino icenter">
++		<a href="{ROOT_PATH}posting.php?mode=post" role="button" title="{L_BUTTON_UPLOAD_EXPLAIN}"class="btn btn-default btn-load" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-plus"></i>&nbsp;{L_BUTTON_UPLOAD}</a>
++	</div>
++	{% if loops.block_list|length %}
++	{% for block_list in loops.block_list %}
++	{% if block_list.S_ISWITH2 %}
++	<br/><br/>
++	<h3>{{ block_list.FILTRINO }}</h3>
++	<table class="table table-bordered">
++		<thead> 
++			<tr> 
++				<th class="list-inner">{{ lang('TITLE') }}</th>
++				<th class="topics">{{ lang('AUTHOR') }}</th>
++				<th class="posts">{{ lang('COMMENTS') }}</th>
++				{% if U_ACP %}<th class="lastpost"><span>{{ lang('REMOVE_FROM_LIST') }}</span></th>{% endif %}
++			</tr>
++		</thead>
++		{% for block_topic_index in block_list.block_topic_index %}
++		<tbody>
++			<tr>
++				<td class="topicindex">{% EVENT dmzx_topic_index_topic_before %}<a href="{{ block_topic_index.ITOPIC_URL }}" class="topictitle">{% EVENT dmzx_topic_index_topic_title_container_before %}<strong>{% EVENT dmzx_topic_index_topic_title_before %} {{ block_topic_index.ITOPIC_TITLE }}</strong>{% EVENT dmzx_topic_index_topic_title_after %}</a>{% EVENT dmzx_topic_index_topic_title_container_after %}</td>
++				<td class="topics">{{ block_topic_index.ITOPIC_POSTER }}</td>
++				<td class="posts">{{ block_topic_index.ITOPIC_TOTREP }}</td>
++				{% if U_ACP %}<td class="lastpost"><span class="topicindexremove"><a href="{{ block_topic_index.U_REMOVE_FROM }}" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true" title="{{ lang('REMOVE_FROM_LIST') }}"></i></a></span></td>{% endif %}
++			</tr>
++		</tbody>
++		{% endfor %}
++	</table>
++	{% endif %}
++	{% endfor %}
++	{% else %}
++	<fieldset>
++		<p class="ianytopuc">{{ lang('ANY_TOPIC_IN_LIST') }}</p>
++	</fieldset>
++	{% endif %}
++</div>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/topiclist.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/topiclist.html"
+new file mode 100644
+index 000000000..4fb6782bd
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/topiclist.html"
+@@ -0,0 +1,83 @@
++{% INCLUDE 'overall_header.html' %}
++
++<fieldset class="framed-ucp topic-list">
++	<legend>{{ lang('OIINDEX_HEADER') }} {% if TOPIC_INDEX_USER_TOPICS_FILTERING_NAME %}{{ lang('TOPIC_INDEX_USER_TOPICS_FILTERING', TOPIC_INDEX_USER_TOPICS_FILTERING_NAME) }}{% endif %}</legend>
++
++<form action="{{ U_ACTION }}" method="post">
++	<div class="panel-content">
++		<div class="panel-body">
++			<fieldset>
++				<div class="controls controls-row"> 
++					<select class="selectpicker" data-container="body" name="list" id="listslc" onchange="this.form.submit();" data-togglable-settings="true">
++						<option value="0" selected="selected">{{ lang('SELECT_A_LIST') }}</option>{{ S_LIST_OPTIONS }}
++					</select>
++				</div>
++			</fieldset>
++		</div>
++	</div>
++{{ S_FORM_TOKEN }}
++</form>
++
++{% if S_SHOWLIST %}
++<div class="panel bg1">
++	<div class="inner">
++	{% EVENT dmzx_topic_index_topic_filter_container_before %}
++		<p class="filtrino icenter">
++			{% for block_nofiltrino in loops.block_nofiltrino %}
++				<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_TUTTI }}">{{ lang('ALL') }}</a></span>
++				{% if block_nofiltrino.S_09 %}<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_09 }}">{{ lang('09') }}</a></span>{% else %}<span  class="btn-basic btn-xs">{{ lang('09') }}</span>{% endif %}
++				{% if block_nofiltrino.S_SYMB %}<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_SYMB }}">{{ lang('SYMB') }}</a></span>{% else %}<span  class="btn-basic btn-xs">{{ lang('SYMB') }}</span>{% endif %}
++			{% endfor %}
++			{% for block_filtrino in loops.block_filtrino %}
++				{% EVENT dmzx_topic_index_topic_filter_before %}
++				{% if block_filtrino.S_ISWITH %}
++					<span class="btn btn-default btn-xs"><a href="{{ block_filtrino.U_FILTER }}">{{ block_filtrino.FILTRINO }}</a></span>
++				{% else %}
++					<span class="btn-basic btn-xs">{{ block_filtrino.FILTRINO }}</span>
++				{% endif %}
++				{% EVENT dmzx_topic_index_topic_filter_after %}
++			{% endfor %}
++		</p>
++		{% EVENT dmzx_topic_index_topic_filter_container_after %}
++	</div>
++</div>
++<div class="filtrino icenter">
++	<a href="{ROOT_PATH}viewforum.php?f=124" role="button" title="{L_BUTTON_UPLOAD_EXPLAIN}"class="btn btn-default btn-load" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-plus"></i>&nbsp;{L_BUTTON_UPLOAD}</a>
++</div>
++{% if loops.block_list|length %}
++{% for block_list in loops.block_list %}
++{% if block_list.S_ISWITH2 %}
++<br/><br/>
++<h3>{{ block_list.FILTRINO }}</h3>
++
++	<table class="table table-bordered">
++		<thead> 
++			<tr> 
++				<th class="list-inner">{{ lang('TITLE') }}</th>
++				<th class="topics">{{ lang('AUTHOR') }}</th>
++				<th class="posts">{{ lang('COMMENTS') }}</th>
++				{% if U_ACP %}<th class="lastpost"><span>{{ lang('REMOVE_FROM_LIST') }}</span></th>{% endif %}
++			</tr>
++		</thead>
++		{% for block_topic_index in block_list.block_topic_index %}
++		<tbody>
++			<tr>
++				<td class="topicindex">{% EVENT dmzx_topic_index_topic_before %}<a href="{{ block_topic_index.ITOPIC_URL }}">{% EVENT dmzx_topic_index_topic_title_container_before %}<strong>{% EVENT dmzx_topic_index_topic_title_before %} {{ block_topic_index.ITOPIC_TITLE }}</strong>{% EVENT dmzx_topic_index_topic_title_after %}</a>{% EVENT dmzx_topic_index_topic_title_container_after %}</td>
++				<td class="topics">{{ block_topic_index.ITOPIC_POSTER }}</td>
++				<td class="posts">{{ block_topic_index.ITOPIC_TOTREP }}</td>
++				{% if U_ACP %}<td class="lastpost"><span class="topicindexremove"><a href="{{ block_topic_index.U_REMOVE_FROM }}" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true" title="{{ lang('REMOVE_FROM_LIST') }}"></i></a></span></td>{% endif %}
++			</tr>
++		</tbody>
++		{% endfor %}
++	</table>
++{% endif %}
++{% endfor %}
++{% else %}
++<fieldset>
++	<p class="ianytopuc">{{ lang('ANY_TOPIC_IN_LIST') }}</p>
++</fieldset>
++{% endif %}
++
++{% endif %}
++</fieldset>
++{% INCLUDE 'overall_footer.html' %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/images/icon_post_inilist.gif" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_post_inilist.gif"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/images/icon_post_inilist.gif"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_post_inilist.gif"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/images/icon_post_iremovelist.gif" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_post_iremovelist.gif"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/images/icon_post_iremovelist.gif"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_post_iremovelist.gif"
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_topiclist.gif" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_topiclist.gif"
+new file mode 100644
+index 000000000..54c1b79a5
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_topiclist.gif" differ
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/topicindex.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.bak.css"
+similarity index 99%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/topicindex.css"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.bak.css"
+index 28552599f..08e7fe005 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/topicindex.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.bak.css"
+@@ -48,7 +48,7 @@
+ }
+ 
+ .topicindex {
+-	font-size: 1.2em;
++	font-size: 1.0em;
+ 	line-height: 2.2em;
+ 	padding: 4px 0;
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.css"
+new file mode 100644
+index 000000000..f2a0a198f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.css"
+@@ -0,0 +1 @@
++#content_index{overflow:hidden!important}.content ul,.content ol{margin:0!important}.icenter{text-align:center}.itopic_num{text-align:center;width:30px}.itopic_titles{text-align:left!important;float:left}.itopic_rep{text-align:center;width:80px}.itopic_poster{text-align:center;width:250px}.index_table{margin:0;padding:0}.tlisthead{color:#000!important}.topicindex{font-size:1em;line-height:2.2em;padding:4px 0}.topicindexremove{margin-top:5px;font-size:1.2em}.filtrino{text-align:center;margin:5px;text-transform:uppercase;font-size:12px!important;font-weight:700}.i_abcdz{margin:0 0 0 2px;padding:0 4px;background:#CADCEB}.i_abcdz:hover{margin:0 0 0 2px;padding:0 4px;background:#9badb9;text-decoration:none!important}.i_nourl{margin:0 0 0 2px;padding:0 4px;background:#FFF!important;text-transform:uppercase;color:#c2c2c2!important}.i_all{margin:0 0 0 2px;padding:0 4px;background:#CADCEB}.i_all:hover{margin:0 0 0 2px;padding:0 4px;background:#9badb9;text-decoration:none!important}.ianytopuc{text-align:center;font-size:14px}@media (max-width: 850px){li.header dt{text-align:center;text-transform:none;line-height:1em;font-size:1.2em;padding-bottom:4px}ul.topiclist li.header dt,ul.topiclist li.header dt .list-inner{margin-right:0!important;padding-right:0}ul.topiclist dt,ul.topiclist dt .list-inner{margin-right:0}ul.topiclist dd{display:none}}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex_icon.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex_icon.css"
+new file mode 100644
+index 000000000..efb85eb43
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex_icon.css"
+@@ -0,0 +1 @@
++.icon-topiclist{background-image:url(./images/icon_topiclist.gif)}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/official_topic_index.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/official_topic_index.html"
+deleted file mode 100644
+index 800520bcc..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/official_topic_index.html"
++++ /dev/null
+@@ -1,62 +0,0 @@
+-<div id="{{ S_ISTYLE }}">
+-	<strong>{{ lang('INDEX_POST_PRES') }}</strong>
+-	<fieldset>
+-		<p class="filtrino icenter">
+-			{% for block_nofiltrino in loops.block_nofiltrino %}
+-				<span><a href="{{ block_nofiltrino.U_TUTTI }}" class="i_all">{{ lang('ALL') }}</a></span>
+-				{% if block_nofiltrino.S_09 %}<span><a href="{{ block_nofiltrino.U_09 }}" class="i_all">{{ lang('09') }}</a></span>{% else %}<span class="i_nourl">{{ lang('09') }}</span>{% endif %}
+-				{% if block_nofiltrino.S_SYMB %}<span><a href="{{ block_nofiltrino.U_SYMB }}" class="i_all">{{ lang('SYMB') }}</a></span>{% else %}<span class="i_nourl">{{ lang('SYMB') }}</span>{% endif %}
+-			{% endfor %}
+-			{% for block_filtrino in loops.block_filtrino %}
+-				{% if block_filtrino.S_ISWITH %}
+-					<span><a href="{{ block_filtrino.U_FILTER }}" class="i_abcdz">{{ block_filtrino.FILTRINO }}</a></span>
+-				{% else %}
+-					<span class="i_nourl">{{ block_filtrino.FILTRINO }}</span>
+-				{% endif %}
+-			{% endfor %}
+-		</p>
+-	</fieldset>
+-	{% if loops.block_list|length %}
+-	{% for block_list in loops.block_list %}
+-	{% if block_list.S_ISWITH2 %}
+-	<h3>{{ block_list.FILTRINO }}</h3>
+-	<div class="panel bg3">
+-		<div class="inner">
+-			<ul class="topiclist">
+-				<li class="header">
+-					<dl class="row-item">
+-						<dt>
+-							<div class="list-inner" style="color:#000000;">{{ lang('TOPIC_TITLE') }}</div>
+-						</dt>
+-						<dd class="topics" style="color:#000000;">{{ lang('POSTER') }}</dd>
+-						<dd class="posts" style="color:#000000;">{{ lang('REPLIES') }}</dd>
+-						{% if U_MCP %}<dd class="lastpost" style="color:#000000;"><span>{{ lang('REMOVE_FROM_LIST') }}</span></dd>{% endif %}
+-					</dl>
+-				</li>
+-			</ul>
+-			<ul class="topiclist forums">
+-			{% for block_topic_index in block_list.block_topic_index %}
+-				<li class="row {% if block_topic_index.S_ROW_COUNT is even %}bg1{% else %}bg2{% endif %}">
+-					<dl>
+-						<dt class="topicindex">
+-							<div class="list-inner">
+-								<a href="{{ block_topic_index.ITOPIC_URL }}"><strong>{{ block_topic_index.ITOPIC_TITLE }}</strong></a>
+-							</div>
+-						</dt>
+-						<dd class="topics">{{ block_topic_index.ITOPIC_POSTER }}</dd>
+-						<dd class="posts">{{ block_topic_index.ITOPIC_TOTREP }}</dd>
+-						{% if U_MCP %}<dd class="lastpost"><span class="topicindexremove">[<a href="{{ block_topic_index.U_REMOVE_FROM }}">{{ lang('REMOVE_FROM_LIST') }}</a>]</span></dd>{% endif %}
+-					</dl>
+-				</li>
+-			{% endfor %}
+-			</ul>
+-		</div>
+-	</div>
+-	{% endif %}
+-	{% endfor %}
+-	{% else %}
+-	<fieldset>
+-		<p class="ianytopuc">{{ lang('ANY_TOPIC_IN_LIST') }}</p>
+-	</fieldset>
+-	{% endif %}
+-</div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/topiclist.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/topiclist.html"
+deleted file mode 100644
+index 7f5d2d27b..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/topiclist.html"
++++ /dev/null
+@@ -1,80 +0,0 @@
+-{% INCLUDE 'overall_header.html' %}
+-
+-<h2>{{ lang('OIINDEX_HEADER') }}</h2>
+-
+-<form action="{{ U_ACTION }}" method="post">
+-	<div class="panel bg3">
+-		<div class="inner">
+-			<fieldset>
+-				<p>{{ lang('SELECT_A_LIST') }}{{ lang('COLON') }} <select id="listslc" name="list" onchange="this.form.submit();"><option value="0" selected="selected">-------</option>{{ S_LIST_OPTIONS }}</select></p>
+-			</fieldset>
+-		</div>
+-	</div>
+-{{ S_FORM_TOKEN }}
+-</form>
+-
+-{% if S_SHOWLIST %}
+-<div class="panel bg1">
+-	<div class="inner">
+-		<p class="filtrino icenter">
+-			{% for block_nofiltrino in loops.block_nofiltrino %}
+-				<span><a href="{{ block_nofiltrino.U_TUTTI }}" class="i_all">{{ lang('ALL') }}</a></span>
+-				{% if block_nofiltrino.S_09 %}<span><a href="{{ block_nofiltrino.U_09 }}" class="i_all">{{ lang('09') }}</a></span>{% else %}<span class="i_nourl">{{ lang('09') }}</span>{% endif %}
+-				{% if block_nofiltrino.S_SYMB %}<span><a href="{{ block_nofiltrino.U_SYMB }}" class="i_all">{{ lang('SYMB') }}</a></span>{% else %}<span class="i_nourl">{{ lang('SYMB') }}</span>{% endif %}
+-			{% endfor %}
+-			{% for block_filtrino in loops.block_filtrino %}
+-				{% if block_filtrino.S_ISWITH %}
+-					<span><a href="{{ block_filtrino.U_FILTER }}" class="i_abcdz">{{ block_filtrino.FILTRINO }}</a></span>
+-				{% else %}
+-					<span class="i_nourl">{{ block_filtrino.FILTRINO }}</span>
+-				{% endif %}
+-			{% endfor %}
+-		</p>
+-	</div>
+-</div>
+-{% if loops.block_list|length %}
+-{% for block_list in loops.block_list %}
+-{% if block_list.S_ISWITH2 %}
+-<h3>{{ block_list.FILTRINO }}</h3>
+-<div class="forabg">
+-	<div class="inner">
+-		<ul class="topiclist">
+-			<li class="header">
+-				<dl class="row-item">
+-					<dt>
+-						<div class="list-inner">{{ lang('TOPIC_TITLE') }}</div>
+-					</dt>
+-					<dd class="topics">{{ lang('POSTER') }}</dd>
+-					<dd class="posts">{{ lang('REPLIES') }}</dd>
+-					{% if U_MCP %}<dd class="lastpost"><span>{{ lang('REMOVE_FROM_LIST') }}</span></dd>{% endif %}
+-				</dl>
+-			</li>
+-		</ul>
+-		<ul class="topiclist forums">
+-		{% for block_topic_index in block_list.block_topic_index %}
+-			<li class="row {% if block_topic_index.S_ROW_COUNT is even %}bg1{% else %}bg2{% endif %}">
+-				<dl>
+-					<dt class="topicindex">
+-						<div class="list-inner">
+-							<a href="{{ block_topic_index.ITOPIC_URL }}"><strong>{{ block_topic_index.ITOPIC_TITLE }}</strong></a>
+-						</div>
+-					</dt>
+-					<dd class="topics">{{ block_topic_index.ITOPIC_POSTER }}</dd>
+-					<dd class="posts">{{ block_topic_index.ITOPIC_TOTREP }}</dd>
+-					{% if U_MCP %}<dd class="lastpost"><span class="topicindexremove">[<a href="{{ block_topic_index.U_REMOVE_FROM }}">{{ lang('REMOVE_FROM_LIST') }}</a>]</span></dd>{% endif %}
+-				</dl>
+-			</li>
+-		{% endfor %}
+-		</ul>
+-	</div>
+-</div>
+-{% endif %}
+-{% endfor %}
+-{% else %}
+-<fieldset>
+-	<p class="ianytopuc">{{ lang('ANY_TOPIC_IN_LIST') }}</p>
+-</fieldset>
+-{% endif %}
+-{% endif %}
+-
+-{% INCLUDE 'overall_footer.html' %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/images/Thumbs.db" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/images/Thumbs.db"
+deleted file mode 100644
+index b2858ee7f..000000000
+Binary files "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/images/Thumbs.db" and /dev/null differ
diff --git "[FORUM_EXT]/dmzx\\topicindex/diff_nospace.tmp" "[FORUM_EXT]/dmzx\\topicindex/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\topicindex/diff_nospace.tmp"
@@ -0,0 +1,2023 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/CHANGELOG.md"
+index 5f44376ef..5e310d3e1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/CHANGELOG.md"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/CHANGELOG.md"
+@@ -1,9 +1,4 @@
+-## Topic IndexChangelog
+-
+-### 1.0.5 - 2020-01-15
+-- Drop support for 3.1.
+-- Twig update.
+-- Code update tables.yml
++## Changelog
+ 
+ ### 1.0.4 - 2017-04-13
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/config/services.yml"
+index 8555bf62c..13bc16f91 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/config/services.yml"
+@@ -37,6 +37,7 @@ services:
+             - '@request'
+             - '@controller.helper'
+             - '@config'
++            - '@dispatcher'
+             - '%core.root_path%'
+             - '%core.php_ext%'
+             - '%dmzx.topicindex.table.topicindex%'
+@@ -47,4 +48,5 @@ services:
+             - '@template'
+             - '@config'
+             - '@auth'
++            - '@dispatcher'
+             - '@ext.manager'
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/controller/main.php"
+index c90d4ff8c..77ca764db 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/controller/main.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/controller/main.php"
+@@ -10,6 +10,7 @@
+ namespace dmzx\topicindex\controller;
+ 
+ use dmzx\topicindex\core\functions_topicindex;
++use phpbb\event\dispatcher_interface;
+ use phpbb\template\template;
+ use phpbb\user;
+ use phpbb\auth\auth;
+@@ -45,6 +46,9 @@ class main
+ 	/** @var config */
+ 	protected $config;
+ 
++	/** @var dispatcher_interface */
++	protected $dispatcher;
++
+ 	/** @var string */
+ 	protected $root_path;
+ 
+@@ -69,6 +73,7 @@ class main
+ 	* @param request_interface		$request
+ 	* @param helper		 			$helper
+ 	* @param config					$config
++	* @param dispatcher_interface	$dispatcher
+ 	* @param string 				$root_path
+ 	* @param string 				$php_ext
+ 	* @param string 				$forum_lists_table
+@@ -82,6 +87,7 @@ class main
+ 		request_interface $request,
+ 		helper $helper,
+ 		config $config,
++		dispatcher_interface $dispatcher,
+ 		$root_path,
+ 		$php_ext,
+ 		$forum_lists_table
+@@ -95,6 +101,7 @@ class main
+ 		$this->request 				= $request;
+ 		$this->helper 				= $helper;
+ 		$this->config				= $config;
++		$this->dispatcher			= $dispatcher;
+ 		$this->root_path 			= $root_path;
+ 		$this->php_ext 				= $php_ext;
+ 		$this->forum_lists_table 	= $forum_lists_table;
+@@ -127,11 +134,7 @@ class main
+ 			redirect($zurl, false, true);
+ 		}
+ 
+-		// Navigation
+-		$this->template->assign_block_vars('navlinks', array(
+-			'FORUM_NAME'	=> $this->user->lang['OIINDEX_HEADER'],
+-			'U_VIEW_FORUM'	=> $zurl
+-		));
++		$selected_category = '';
+ 
+ 		if (empty($list))
+ 		{
+@@ -167,6 +170,11 @@ class main
+ 			$result	= $this->db->sql_query($sql);
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
++				if ($list == $row['list_id'])
++				{
++					$selected_category = $row['list_name'];
++				}
++
+ 				$s_list_options .= '<option value="' . $row['list_id'] . '"' . (($list == $row['list_id']) ? ' selected="selected"' : '') . '>' . $row['list_name'] . '</option>';
+ 			}
+ 			$this->db->sql_freeresult($result);
+@@ -186,7 +194,8 @@ class main
+ 			$row1		= $this->db->sql_fetchrow($result1);
+ 			$this->db->sql_freeresult($result1);
+ 
+-			$forumsari 	= json_decode($row1['list_forum']);
++			$forumsari 	= @json_decode($row1['list_forum']);
++			$forumsari	= is_array($forumsari) ? $forumsari : [];
+ 			$filtrini	= range('a', 'z');
+ 			$indexlist	= array();
+ 
+@@ -236,14 +245,26 @@ class main
+ 				{
+ 					if ($realfilter == $indexdata['key'])
+ 					{
+-						$this->template->assign_block_vars('block_list.block_topic_index', array(
+-							'ITOPIC_URL'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$indexdata['id']}"),
++						$template_vars = array(
++							'ITOPIC_URL'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$indexdata['forum_id']}&amp;t={$indexdata['id']}"),
+ 							'ITOPIC_TITLE'	=> $indexdata['title'],
+ 							'ITOPIC_POSTER'	=> get_username_string('full', $indexdata['posterid'], $indexdata['poster'], $indexdata['postercol']),
+ 							'ITOPIC_TOTREP'	=> $indexdata['posts'],
+ 							'U_REMOVE_FROM'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'iremove' => $indexdata['id'])),
+ 							'ITOPIC_CLASS'	=> ($nums % 2) ? 'row bg1' : 'row bg2'
+-						));
++						);
++
++						/**
++						 * Modify the topic index data before it is assigned to the template
++						 *
++						 * @event dmzx.topicindex.modify_block_topic_index_ary
++						 * @var		array	template_vars	Template block array with topic data
++						 * @since 1.0.5
++						 */
++						$vars = array('indexdata', 'template_vars');
++						extract($this->dispatcher->trigger_event('dmzx.topicindex.modify_block_topic_index_ary', compact($vars)));
++
++						$this->template->assign_block_vars('block_list.block_topic_index', $template_vars);
+ 						$nums++;
+ 					}
+ 				}
+@@ -252,18 +273,29 @@ class main
+ 			// Others data for menu
+ 			$this->template->assign_block_vars('block_nofiltrino', array(
+ 				'U_TUTTI'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list)),
+-				'U_09'		=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit=09')),
+-				'U_SYMB'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit=_')),
++				'U_09'		=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit' => '09')),
++				'U_SYMB'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit' => '_')),
+ 				'S_09'		=> (in_array('09', $fixa)) ? true : false,
+ 				'S_SYMB'	=> (in_array('_', $fixa)) ? true : false
+ 			));
+ 		}
+ 
++		$title = implode(' - ', array_filter([$this->user->lang['OIINDEX_HEADER'], $selected_category]));
++
++		// Navigation
++		$this->template->assign_block_vars('navlinks', array(
++			'FORUM_NAME'	=> $title,
++			'U_VIEW_FORUM'	=> $zurl
++		));
++
+ 		$this->functions_topicindex->assign_authors();
+ 
+-		$this->template->assign_var('TOPICINDEX_FOOTER_VIEW', true);
++		$this->template->assign_vars([
++			'TOPICINDEX_FOOTER_VIEW'	=> true,
++			'L_OIINDEX_HEADER'			=> $title,
++		]);
+ 
+ 		// Send all data to the template file
+-		return $this->helper->render('topiclist.html', $this->user->lang['OIINDEX_HEADER']);
++		return $this->helper->render('topiclist.html', $title);
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/core/functions_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/core/functions_topicindex.php"
+index ae23129db..4e118b351 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/core/functions_topicindex.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/core/functions_topicindex.php"
+@@ -10,6 +10,7 @@
+ namespace dmzx\topicindex\core;
+ 
+ use phpbb\db\driver\driver_interface as db_interface;
++use phpbb\event\dispatcher_interface;
+ use phpbb\template\template;
+ use phpbb\config\config;
+ use phpbb\auth\auth;
+@@ -29,6 +30,9 @@ class functions_topicindex
+ 	/** @var auth */
+ 	protected $auth;
+ 
++	/** @var dispatcher_interface */
++	protected $dispatcher;
++
+ 	/** @var manager */
+ 	protected $extension_manager;
+ 
+@@ -39,6 +43,7 @@ class functions_topicindex
+ 	* @param template		$template
+ 	* @param config			$config
+ 	* @param auth			auth
++	* @param dispatcher_interface $dispatcher
+ 	* @param manager 		$extension_manager
+ 	*/
+ 	public function __construct(
+@@ -46,6 +51,7 @@ class functions_topicindex
+ 		template $template,
+ 		config $config,
+ 		auth $auth,
++		dispatcher_interface $dispatcher,
+ 		manager $extension_manager
+ 	)
+ 	{
+@@ -53,6 +59,7 @@ class functions_topicindex
+ 		$this->template 			= $template;
+ 		$this->config				= $config;
+ 		$this->auth					= $auth;
++		$this->dispatcher			= $dispatcher;
+ 		$this->extension_manager	= $extension_manager;
+ 	}
+ 
+@@ -62,13 +69,24 @@ class functions_topicindex
+ 	*/
+ 	function get_topic_index($the_forum, $the_topic, $inlistvalue = 0, $tagfilter = 0)
+ 	{
+-		$sql = "SELECT topic_id, topic_title, topic_poster, topic_first_poster_name, topic_first_poster_colour, forum_id, topic_posts_approved, topic_title, inindex_topic, outindex_topic
+-			FROM " . TOPICS_TABLE . "
+-			WHERE forum_id = " . (int) $the_forum . "
+-				AND topic_posts_approved >= 1
+-				AND inindex_topic >= " . (int) $inlistvalue . "
+-				AND outindex_topic = 0
+-			ORDER BY topic_title ASC";
++		$sql_array = [
++			'SELECT'	=> 't.topic_id, t.topic_title, t.topic_poster, t.topic_first_poster_name, t.topic_first_poster_colour, t.forum_id, t.topic_posts_approved, t.inindex_topic, t.outindex_topic',
++			'FROM'		=> [TOPICS_TABLE => 't'],
++			'WHERE'		=> 't.forum_id = ' . (int) $the_forum . ' AND t.topic_posts_approved >= 1 AND t.inindex_topic >= ' . (int) $inlistvalue . ' AND t.outindex_topic = 0',
++			'ORDER_BY'	=> 't.topic_title ASC',
++		];
++
++		/**
++		 * Event to modify the SQL query that fetches topics
++		 *
++		 * @event dmzx.topicindex.sql_fetch_topics_before
++		 * @var array	sql_array	Array with SQL query data to fetch the current active sessions
++		 * @since 1.0.5
++		 */
++		$vars = ['sql_array'];
++		extract($this->dispatcher->trigger_event('dmzx.topicindex.sql_fetch_topics_before', compact($vars)));
++
++		$sql = $this->db->sql_build_query('SELECT', $sql_array);
+ 		$result	= $this->db->sql_query($sql);
+ 
+ 		$topiclist	= array();
+@@ -77,71 +95,70 @@ class functions_topicindex
+ 		{
+ 			if ($tagfilter == 1)
+ 			{
+-				switch (substr(trim($row['topic_title']),0,1))
++				switch (mb_substr(trim($row['topic_title']),0,1))
+ 				{
+ 					case '(':
+-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], ')') + 1);
++						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], ')') + 1);
+ 						$newstring	= trim($newstring);
+ 
+-						if (substr($newstring,0,1) == '(')
++						if (mb_substr($newstring,0,1) == '(')
+ 						{
+-							$newstring	= substr($newstring, strpos($row['topic_title'], ')') + 1);
++							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], ')') + 1);
+ 							$newstring	= trim($newstring);
+-							$keytag		= strtolower(substr($newstring,0,1));
+-							$keyBig		= strtolower(substr($newstring,0,4));
++							$keytag		= strtolower(mb_substr($newstring,0,1));
++							$keyBig		= strtolower(mb_substr($newstring,0,30));
+ 						}
+ 						else
+ 						{
+-							$keytag		= strtolower(substr($newstring,0,1));
+-							$keyBig		= strtolower(substr($newstring,0,4));
++							$keytag		= strtolower(mb_substr($newstring,0,1));
++							$keyBig		= strtolower(mb_substr($newstring,0,30));
+ 						}
+ 					break;
+ 					case '[':
+-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], ']') + 1);
++						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], ']') + 1);
+ 						$newstring	= trim($newstring);
+ 
+-						if (substr($newstring,0,1) == '[')
++						if (mb_substr($newstring,0,1) == '[')
+ 						{
+-							$newstring	= substr($newstring, strpos($row['topic_title'], ']') + 1);
++							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], ']') + 1);
+ 							$newstring	= trim($newstring);
+-							$keytag		= strtolower(substr($newstring,0,1));
+-							$keyBig		= strtolower(substr($newstring,0,4));
++							$keytag		= strtolower(mb_substr($newstring,0,1));
++							$keyBig		= strtolower(mb_substr($newstring,0,30));
+ 						}
+ 						else
+ 						{
+-							$keytag		= strtolower(substr($newstring,0,1));
+-							$keyBig		= strtolower(substr($newstring,0,4));
++							$keytag		= strtolower(mb_substr($newstring,0,1));
++							$keyBig		= strtolower(mb_substr($newstring,0,30));
+ 						}
+ 					break;
+ 					case '{':
+-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], '}') + 1);
++						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], '}') + 1);
+ 						$newstring	= trim($newstring);
+ 
+-						if (substr($newstring,0,1) == '{')
++						if (mb_substr($newstring,0,1) == '{')
+ 						{
+-							$newstring	= substr($newstring, strpos($row['topic_title'], '}') + 1);
++							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], '}') + 1);
+ 							$newstring	= trim($newstring);
+-							$keytag		= strtolower(substr($newstring,0,1));
+-							$keyBig		= strtolower(substr($newstring,0,4));
++							$keytag		= strtolower(mb_substr($newstring,0,1));
++							$keyBig		= strtolower(mb_substr($newstring,0,30));
+ 						}
+ 						else
+ 						{
+-							$keytag		= strtolower(substr($newstring,0,1));
+-							$keyBig		= strtolower(substr($newstring,0,4));
++							$keytag		= strtolower(mb_substr($newstring,0,1));
++							$keyBig		= strtolower(mb_substr($newstring,0,30));
+ 						}
+ 					break;
+ 					default:
+-						$keytag	= strtolower(substr($row['topic_title'],0,1));
+-						$keyBig	= strtolower(substr($row['topic_title'],0,4));
++						$keytag	= strtolower(mb_substr($row['topic_title'],0,1));
++						$keyBig	= strtolower(mb_substr($row['topic_title'],0,30));
+ 					break;
+ 				}
+ 			}
+ 			else
+ 			{
+-				$keytag	= strtolower(substr($row['topic_title'],0,1));
+-				$keyBig	= strtolower(substr($row['topic_title'],0,30));
++				$keytag	= strtolower(mb_substr($row['topic_title'],0,1));
++				$keyBig	= strtolower(mb_substr($row['topic_title'],0,30));
+ 			}
+-
+ 			if (preg_match('#^[a-z]#u', $keytag))
+ 			{
+ 				$keytag;
+@@ -158,6 +175,7 @@ class functions_topicindex
+ 			if ($row['topic_id'] != $the_topic)
+ 			{
+ 				$array['id']		= $row['topic_id'];
++				$array['forum_id']	= $row['forum_id'];
+ 				$array['key']		= $keytag;
+ 				$array['keybig']	= $keyBig;
+ 				$array['title']		= $row['topic_title'];
+@@ -165,6 +183,19 @@ class functions_topicindex
+ 				$array['posterid']	= $row['topic_poster'];
+ 				$array['poster']	= $row['topic_first_poster_name'];
+ 				$array['postercol']	= $row['topic_first_poster_colour'];
++
++				/**
++				 * Event to modify the SQL query that fetches topics
++				 *
++				 * @event dmzx.topicindex.sql_fetch_topics_after
++				 * @var array	topiclist	Array with all topics returned
++				 * @var array	array		Array with data returned for the current topic
++				 * @var array	row			Array with SQL fields from the current topic
++				 * @since 1.0.5
++				 */
++				$vars = ['topiclist', 'array', 'row'];
++				extract($this->dispatcher->trigger_event('dmzx.topicindex.sql_fetch_topics_after', compact($vars)));
++
+ 				$topiclist[] 		= $array;
+ 			}
+ 		}
+@@ -298,8 +329,8 @@ class functions_topicindex
+ 		$this->db->sql_freeresult($result2);
+ 
+ 		$output = array();
+-		$output['inindex']	= $forum_data['default_inindex'];
+-		$output['filter']	= $forum_data['tag_filter'];
++		$output['inindex'] = isset($forum_data['default_inindex']) ? $forum_data['default_inindex'] : 0;
++		$output['filter'] = isset($forum_data['tag_filter']) ? $forum_data['tag_filter'] : 0;
+ 
+ 		return $output;
+ 	}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/diff_full.tmp"
+new file mode 100644
+index 000000000..7530e1ada
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/diff_full.tmp"
+@@ -0,0 +1,1699 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/CHANGELOG.md"
++index 5f44376ef..5e310d3e1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/CHANGELOG.md"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/CHANGELOG.md"
++@@ -1,9 +1,4 @@
++-## Topic IndexChangelog
++-
++-### 1.0.5 - 2020-01-15
++-- Drop support for 3.1.
++-- Twig update.
++-- Code update tables.yml
+++## Changelog
++ 
++ ### 1.0.4 - 2017-04-13
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/config/services.yml"
++index 8555bf62c..13bc16f91 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/config/services.yml"
++@@ -37,6 +37,7 @@ services:
++             - '@request'
++             - '@controller.helper'
++             - '@config'
+++            - '@dispatcher'
++             - '%core.root_path%'
++             - '%core.php_ext%'
++             - '%dmzx.topicindex.table.topicindex%'
++@@ -47,4 +48,5 @@ services:
++             - '@template'
++             - '@config'
++             - '@auth'
++-            - '@ext.manager'
++\ No newline at end of file
+++            - '@dispatcher'
+++            - '@ext.manager'
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/controller/main.php"
++index c90d4ff8c..77ca764db 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/controller/main.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/controller/main.php"
++@@ -10,6 +10,7 @@
++ namespace dmzx\topicindex\controller;
++ 
++ use dmzx\topicindex\core\functions_topicindex;
+++use phpbb\event\dispatcher_interface;
++ use phpbb\template\template;
++ use phpbb\user;
++ use phpbb\auth\auth;
++@@ -45,6 +46,9 @@ class main
++ 	/** @var config */
++ 	protected $config;
++ 
+++	/** @var dispatcher_interface */
+++	protected $dispatcher;
+++
++ 	/** @var string */
++ 	protected $root_path;
++ 
++@@ -69,6 +73,7 @@ class main
++ 	* @param request_interface		$request
++ 	* @param helper		 			$helper
++ 	* @param config					$config
+++	* @param dispatcher_interface	$dispatcher
++ 	* @param string 				$root_path
++ 	* @param string 				$php_ext
++ 	* @param string 				$forum_lists_table
++@@ -82,6 +87,7 @@ class main
++ 		request_interface $request,
++ 		helper $helper,
++ 		config $config,
+++		dispatcher_interface $dispatcher,
++ 		$root_path,
++ 		$php_ext,
++ 		$forum_lists_table
++@@ -95,6 +101,7 @@ class main
++ 		$this->request 				= $request;
++ 		$this->helper 				= $helper;
++ 		$this->config				= $config;
+++		$this->dispatcher			= $dispatcher;
++ 		$this->root_path 			= $root_path;
++ 		$this->php_ext 				= $php_ext;
++ 		$this->forum_lists_table 	= $forum_lists_table;
++@@ -127,11 +134,7 @@ class main
++ 			redirect($zurl, false, true);
++ 		}
++ 
++-		// Navigation
++-		$this->template->assign_block_vars('navlinks', array(
++-			'FORUM_NAME'	=> $this->user->lang['OIINDEX_HEADER'],
++-			'U_VIEW_FORUM'	=> $zurl
++-		));
+++		$selected_category = '';
++ 
++ 		if (empty($list))
++ 		{
++@@ -167,6 +170,11 @@ class main
++ 			$result	= $this->db->sql_query($sql);
++ 			while ($row = $this->db->sql_fetchrow($result))
++ 			{
+++				if ($list == $row['list_id'])
+++				{
+++					$selected_category = $row['list_name'];
+++				}
+++
++ 				$s_list_options .= '<option value="' . $row['list_id'] . '"' . (($list == $row['list_id']) ? ' selected="selected"' : '') . '>' . $row['list_name'] . '</option>';
++ 			}
++ 			$this->db->sql_freeresult($result);
++@@ -186,7 +194,8 @@ class main
++ 			$row1		= $this->db->sql_fetchrow($result1);
++ 			$this->db->sql_freeresult($result1);
++ 
++-			$forumsari 	= json_decode($row1['list_forum']);
+++			$forumsari 	= @json_decode($row1['list_forum']);
+++			$forumsari	= is_array($forumsari) ? $forumsari : [];
++ 			$filtrini	= range('a', 'z');
++ 			$indexlist	= array();
++ 
++@@ -236,14 +245,26 @@ class main
++ 				{
++ 					if ($realfilter == $indexdata['key'])
++ 					{
++-						$this->template->assign_block_vars('block_list.block_topic_index', array(
++-							'ITOPIC_URL'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$indexdata['id']}"),
+++						$template_vars = array(
+++							'ITOPIC_URL'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$indexdata['forum_id']}&amp;t={$indexdata['id']}"),
++ 							'ITOPIC_TITLE'	=> $indexdata['title'],
++ 							'ITOPIC_POSTER'	=> get_username_string('full', $indexdata['posterid'], $indexdata['poster'], $indexdata['postercol']),
++ 							'ITOPIC_TOTREP'	=> $indexdata['posts'],
++ 							'U_REMOVE_FROM'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'iremove' => $indexdata['id'])),
++ 							'ITOPIC_CLASS'	=> ($nums % 2) ? 'row bg1' : 'row bg2'
++-						));
+++						);
+++
+++						/**
+++						 * Modify the topic index data before it is assigned to the template
+++						 *
+++						 * @event dmzx.topicindex.modify_block_topic_index_ary
+++						 * @var		array	template_vars	Template block array with topic data
+++						 * @since 1.0.5
+++						 */
+++						$vars = array('indexdata', 'template_vars');
+++						extract($this->dispatcher->trigger_event('dmzx.topicindex.modify_block_topic_index_ary', compact($vars)));
+++
+++						$this->template->assign_block_vars('block_list.block_topic_index', $template_vars);
++ 						$nums++;
++ 					}
++ 				}
++@@ -252,18 +273,29 @@ class main
++ 			// Others data for menu
++ 			$this->template->assign_block_vars('block_nofiltrino', array(
++ 				'U_TUTTI'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list)),
++-				'U_09'		=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit=09')),
++-				'U_SYMB'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit=_')),
+++				'U_09'		=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit' => '09')),
+++				'U_SYMB'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit' => '_')),
++ 				'S_09'		=> (in_array('09', $fixa)) ? true : false,
++ 				'S_SYMB'	=> (in_array('_', $fixa)) ? true : false
++ 			));
++ 		}
++ 
+++		$title = implode(' - ', array_filter([$this->user->lang['OIINDEX_HEADER'], $selected_category]));
+++
+++		// Navigation
+++		$this->template->assign_block_vars('navlinks', array(
+++			'FORUM_NAME'	=> $title,
+++			'U_VIEW_FORUM'	=> $zurl
+++		));
+++
++ 		$this->functions_topicindex->assign_authors();
++ 
++-		$this->template->assign_var('TOPICINDEX_FOOTER_VIEW', true);
+++		$this->template->assign_vars([
+++			'TOPICINDEX_FOOTER_VIEW'	=> true,
+++			'L_OIINDEX_HEADER'			=> $title,
+++		]);
++ 
++ 		// Send all data to the template file
++-		return $this->helper->render('topiclist.html', $this->user->lang['OIINDEX_HEADER']);
+++		return $this->helper->render('topiclist.html', $title);
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/core/functions_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/core/functions_topicindex.php"
++index ae23129db..4e118b351 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/core/functions_topicindex.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/core/functions_topicindex.php"
++@@ -10,6 +10,7 @@
++ namespace dmzx\topicindex\core;
++ 
++ use phpbb\db\driver\driver_interface as db_interface;
+++use phpbb\event\dispatcher_interface;
++ use phpbb\template\template;
++ use phpbb\config\config;
++ use phpbb\auth\auth;
++@@ -29,6 +30,9 @@ class functions_topicindex
++ 	/** @var auth */
++ 	protected $auth;
++ 
+++	/** @var dispatcher_interface */
+++	protected $dispatcher;
+++
++ 	/** @var manager */
++ 	protected $extension_manager;
++ 
++@@ -39,6 +43,7 @@ class functions_topicindex
++ 	* @param template		$template
++ 	* @param config			$config
++ 	* @param auth			auth
+++	* @param dispatcher_interface $dispatcher
++ 	* @param manager 		$extension_manager
++ 	*/
++ 	public function __construct(
++@@ -46,6 +51,7 @@ class functions_topicindex
++ 		template $template,
++ 		config $config,
++ 		auth $auth,
+++		dispatcher_interface $dispatcher,
++ 		manager $extension_manager
++ 	)
++ 	{
++@@ -53,6 +59,7 @@ class functions_topicindex
++ 		$this->template 			= $template;
++ 		$this->config				= $config;
++ 		$this->auth					= $auth;
+++		$this->dispatcher			= $dispatcher;
++ 		$this->extension_manager	= $extension_manager;
++ 	}
++ 
++@@ -62,13 +69,24 @@ class functions_topicindex
++ 	*/
++ 	function get_topic_index($the_forum, $the_topic, $inlistvalue = 0, $tagfilter = 0)
++ 	{
++-		$sql = "SELECT topic_id, topic_title, topic_poster, topic_first_poster_name, topic_first_poster_colour, forum_id, topic_posts_approved, topic_title, inindex_topic, outindex_topic
++-			FROM " . TOPICS_TABLE . "
++-			WHERE forum_id = " . (int) $the_forum . "
++-				AND topic_posts_approved >= 1
++-				AND inindex_topic >= " . (int) $inlistvalue . "
++-				AND outindex_topic = 0
++-			ORDER BY topic_title ASC";
+++		$sql_array = [
+++			'SELECT'	=> 't.topic_id, t.topic_title, t.topic_poster, t.topic_first_poster_name, t.topic_first_poster_colour, t.forum_id, t.topic_posts_approved, t.inindex_topic, t.outindex_topic',
+++			'FROM'		=> [TOPICS_TABLE => 't'],
+++			'WHERE'		=> 't.forum_id = ' . (int) $the_forum . ' AND t.topic_posts_approved >= 1 AND t.inindex_topic >= ' . (int) $inlistvalue . ' AND t.outindex_topic = 0',
+++			'ORDER_BY'	=> 't.topic_title ASC',
+++		];
+++
+++		/**
+++		 * Event to modify the SQL query that fetches topics
+++		 *
+++		 * @event dmzx.topicindex.sql_fetch_topics_before
+++		 * @var array	sql_array	Array with SQL query data to fetch the current active sessions
+++		 * @since 1.0.5
+++		 */
+++		$vars = ['sql_array'];
+++		extract($this->dispatcher->trigger_event('dmzx.topicindex.sql_fetch_topics_before', compact($vars)));
+++
+++		$sql = $this->db->sql_build_query('SELECT', $sql_array);
++ 		$result	= $this->db->sql_query($sql);
++ 
++ 		$topiclist	= array();
++@@ -77,71 +95,70 @@ class functions_topicindex
++ 		{
++ 			if ($tagfilter == 1)
++ 			{
++-				switch (substr(trim($row['topic_title']),0,1))
+++				switch (mb_substr(trim($row['topic_title']),0,1))
++ 				{
++ 					case '(':
++-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], ')') + 1);
+++						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], ')') + 1);
++ 						$newstring	= trim($newstring);
++ 
++-						if (substr($newstring,0,1) == '(')
+++						if (mb_substr($newstring,0,1) == '(')
++ 						{
++-							$newstring	= substr($newstring, strpos($row['topic_title'], ')') + 1);
+++							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], ')') + 1);
++ 							$newstring	= trim($newstring);
++-							$keytag		= strtolower(substr($newstring,0,1));
++-							$keyBig		= strtolower(substr($newstring,0,4));
+++							$keytag		= strtolower(mb_substr($newstring,0,1));
+++							$keyBig		= strtolower(mb_substr($newstring,0,30));
++ 						}
++ 						else
++ 						{
++-							$keytag		= strtolower(substr($newstring,0,1));
++-							$keyBig		= strtolower(substr($newstring,0,4));
+++							$keytag		= strtolower(mb_substr($newstring,0,1));
+++							$keyBig		= strtolower(mb_substr($newstring,0,30));
++ 						}
++ 					break;
++ 					case '[':
++-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], ']') + 1);
+++						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], ']') + 1);
++ 						$newstring	= trim($newstring);
++ 
++-						if (substr($newstring,0,1) == '[')
+++						if (mb_substr($newstring,0,1) == '[')
++ 						{
++-							$newstring	= substr($newstring, strpos($row['topic_title'], ']') + 1);
+++							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], ']') + 1);
++ 							$newstring	= trim($newstring);
++-							$keytag		= strtolower(substr($newstring,0,1));
++-							$keyBig		= strtolower(substr($newstring,0,4));
+++							$keytag		= strtolower(mb_substr($newstring,0,1));
+++							$keyBig		= strtolower(mb_substr($newstring,0,30));
++ 						}
++ 						else
++ 						{
++-							$keytag		= strtolower(substr($newstring,0,1));
++-							$keyBig		= strtolower(substr($newstring,0,4));
+++							$keytag		= strtolower(mb_substr($newstring,0,1));
+++							$keyBig		= strtolower(mb_substr($newstring,0,30));
++ 						}
++ 					break;
++ 					case '{':
++-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], '}') + 1);
+++						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], '}') + 1);
++ 						$newstring	= trim($newstring);
++ 
++-						if (substr($newstring,0,1) == '{')
+++						if (mb_substr($newstring,0,1) == '{')
++ 						{
++-							$newstring	= substr($newstring, strpos($row['topic_title'], '}') + 1);
+++							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], '}') + 1);
++ 							$newstring	= trim($newstring);
++-							$keytag		= strtolower(substr($newstring,0,1));
++-							$keyBig		= strtolower(substr($newstring,0,4));
+++							$keytag		= strtolower(mb_substr($newstring,0,1));
+++							$keyBig		= strtolower(mb_substr($newstring,0,30));
++ 						}
++ 						else
++ 						{
++-							$keytag		= strtolower(substr($newstring,0,1));
++-							$keyBig		= strtolower(substr($newstring,0,4));
+++							$keytag		= strtolower(mb_substr($newstring,0,1));
+++							$keyBig		= strtolower(mb_substr($newstring,0,30));
++ 						}
++ 					break;
++ 					default:
++-						$keytag	= strtolower(substr($row['topic_title'],0,1));
++-						$keyBig	= strtolower(substr($row['topic_title'],0,4));
+++						$keytag	= strtolower(mb_substr($row['topic_title'],0,1));
+++						$keyBig	= strtolower(mb_substr($row['topic_title'],0,30));
++ 					break;
++ 				}
++ 			}
++ 			else
++ 			{
++-				$keytag	= strtolower(substr($row['topic_title'],0,1));
++-				$keyBig	= strtolower(substr($row['topic_title'],0,30));
+++				$keytag	= strtolower(mb_substr($row['topic_title'],0,1));
+++				$keyBig	= strtolower(mb_substr($row['topic_title'],0,30));
++ 			}
++-
++ 			if (preg_match('#^[a-z]#u', $keytag))
++ 			{
++ 				$keytag;
++@@ -158,6 +175,7 @@ class functions_topicindex
++ 			if ($row['topic_id'] != $the_topic)
++ 			{
++ 				$array['id']		= $row['topic_id'];
+++				$array['forum_id']	= $row['forum_id'];
++ 				$array['key']		= $keytag;
++ 				$array['keybig']	= $keyBig;
++ 				$array['title']		= $row['topic_title'];
++@@ -165,11 +183,24 @@ class functions_topicindex
++ 				$array['posterid']	= $row['topic_poster'];
++ 				$array['poster']	= $row['topic_first_poster_name'];
++ 				$array['postercol']	= $row['topic_first_poster_colour'];
+++
+++				/**
+++				 * Event to modify the SQL query that fetches topics
+++				 *
+++				 * @event dmzx.topicindex.sql_fetch_topics_after
+++				 * @var array	topiclist	Array with all topics returned
+++				 * @var array	array		Array with data returned for the current topic
+++				 * @var array	row			Array with SQL fields from the current topic
+++				 * @since 1.0.5
+++				 */
+++				$vars = ['topiclist', 'array', 'row'];
+++				extract($this->dispatcher->trigger_event('dmzx.topicindex.sql_fetch_topics_after', compact($vars)));
+++
++ 				$topiclist[] 		= $array;
++ 			}
++ 		}
++ 		$this->db->sql_freeresult($result);
++-
+++		
++ 		/* order array */
++ 		if (count($topiclist) > 0)
++ 		{
++@@ -177,7 +208,7 @@ class functions_topicindex
++ 			{
++ 				$order_in_category[$key] = $row['keybig'];
++ 			}
++-			array_multisort ($order_in_category, SORT_ASC, $topiclist);
+++			array_multisort($order_in_category, SORT_ASC, $topiclist);
++ 		}
++ 
++ 		return	$topiclist;
++@@ -298,8 +329,8 @@ class functions_topicindex
++ 		$this->db->sql_freeresult($result2);
++ 
++ 		$output = array();
++-		$output['inindex']	= $forum_data['default_inindex'];
++-		$output['filter']	= $forum_data['tag_filter'];
+++		$output['inindex'] = isset($forum_data['default_inindex']) ? $forum_data['default_inindex'] : 0;
+++		$output['filter'] = isset($forum_data['tag_filter']) ? $forum_data['tag_filter'] : 0;
++ 
++ 		return $output;
++ 	}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/diff_full.tmp"
++new file mode 100644
++index 000000000..cd24dd8a3
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/diff_full.tmp"
++@@ -0,0 +1,304 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/CHANGELOG.md"
+++index 5f44376ef..5e310d3e1 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/CHANGELOG.md"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/CHANGELOG.md"
+++@@ -1,9 +1,4 @@
+++-## Topic IndexChangelog
+++-
+++-### 1.0.5 - 2020-01-15
+++-- Drop support for 3.1.
+++-- Twig update.
+++-- Code update tables.yml
++++## Changelog
+++ 
+++ ### 1.0.4 - 2017-04-13
+++ 
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/config/services.yml"
+++index 8555bf62c..13bc16f91 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/config/services.yml"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/config/services.yml"
+++@@ -37,6 +37,7 @@ services:
+++             - '@request'
+++             - '@controller.helper'
+++             - '@config'
++++            - '@dispatcher'
+++             - '%core.root_path%'
+++             - '%core.php_ext%'
+++             - '%dmzx.topicindex.table.topicindex%'
+++@@ -47,4 +48,5 @@ services:
+++             - '@template'
+++             - '@config'
+++             - '@auth'
+++-            - '@ext.manager'
+++\ No newline at end of file
++++            - '@dispatcher'
++++            - '@ext.manager'
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/controller/main.php"
+++index c90d4ff8c..77ca764db 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/controller/main.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/controller/main.php"
+++@@ -10,6 +10,7 @@
+++ namespace dmzx\topicindex\controller;
+++ 
+++ use dmzx\topicindex\core\functions_topicindex;
++++use phpbb\event\dispatcher_interface;
+++ use phpbb\template\template;
+++ use phpbb\user;
+++ use phpbb\auth\auth;
+++@@ -45,6 +46,9 @@ class main
+++ 	/** @var config */
+++ 	protected $config;
+++ 
++++	/** @var dispatcher_interface */
++++	protected $dispatcher;
++++
+++ 	/** @var string */
+++ 	protected $root_path;
+++ 
+++@@ -69,6 +73,7 @@ class main
+++ 	* @param request_interface		$request
+++ 	* @param helper		 			$helper
+++ 	* @param config					$config
++++	* @param dispatcher_interface	$dispatcher
+++ 	* @param string 				$root_path
+++ 	* @param string 				$php_ext
+++ 	* @param string 				$forum_lists_table
+++@@ -82,6 +87,7 @@ class main
+++ 		request_interface $request,
+++ 		helper $helper,
+++ 		config $config,
++++		dispatcher_interface $dispatcher,
+++ 		$root_path,
+++ 		$php_ext,
+++ 		$forum_lists_table
+++@@ -95,6 +101,7 @@ class main
+++ 		$this->request 				= $request;
+++ 		$this->helper 				= $helper;
+++ 		$this->config				= $config;
++++		$this->dispatcher			= $dispatcher;
+++ 		$this->root_path 			= $root_path;
+++ 		$this->php_ext 				= $php_ext;
+++ 		$this->forum_lists_table 	= $forum_lists_table;
+++@@ -127,11 +134,7 @@ class main
+++ 			redirect($zurl, false, true);
+++ 		}
+++ 
+++-		// Navigation
+++-		$this->template->assign_block_vars('navlinks', array(
+++-			'FORUM_NAME'	=> $this->user->lang['OIINDEX_HEADER'],
+++-			'U_VIEW_FORUM'	=> $zurl
+++-		));
++++		$selected_category = '';
+++ 
+++ 		if (empty($list))
+++ 		{
+++@@ -167,6 +170,11 @@ class main
+++ 			$result	= $this->db->sql_query($sql);
+++ 			while ($row = $this->db->sql_fetchrow($result))
+++ 			{
++++				if ($list == $row['list_id'])
++++				{
++++					$selected_category = $row['list_name'];
++++				}
++++
+++ 				$s_list_options .= '<option value="' . $row['list_id'] . '"' . (($list == $row['list_id']) ? ' selected="selected"' : '') . '>' . $row['list_name'] . '</option>';
+++ 			}
+++ 			$this->db->sql_freeresult($result);
+++@@ -186,7 +194,8 @@ class main
+++ 			$row1		= $this->db->sql_fetchrow($result1);
+++ 			$this->db->sql_freeresult($result1);
+++ 
+++-			$forumsari 	= json_decode($row1['list_forum']);
++++			$forumsari 	= @json_decode($row1['list_forum']);
++++			$forumsari	= is_array($forumsari) ? $forumsari : [];
+++ 			$filtrini	= range('a', 'z');
+++ 			$indexlist	= array();
+++ 
+++@@ -236,14 +245,26 @@ class main
+++ 				{
+++ 					if ($realfilter == $indexdata['key'])
+++ 					{
+++-						$this->template->assign_block_vars('block_list.block_topic_index', array(
+++-							'ITOPIC_URL'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$forum_id}&amp;t={$indexdata['id']}"),
++++						$template_vars = array(
++++							'ITOPIC_URL'	=> append_sid("{$this->root_path}viewtopic.$this->php_ext", "f={$indexdata['forum_id']}&amp;t={$indexdata['id']}"),
+++ 							'ITOPIC_TITLE'	=> $indexdata['title'],
+++ 							'ITOPIC_POSTER'	=> get_username_string('full', $indexdata['posterid'], $indexdata['poster'], $indexdata['postercol']),
+++ 							'ITOPIC_TOTREP'	=> $indexdata['posts'],
+++ 							'U_REMOVE_FROM'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'iremove' => $indexdata['id'])),
+++ 							'ITOPIC_CLASS'	=> ($nums % 2) ? 'row bg1' : 'row bg2'
+++-						));
++++						);
++++
++++						/**
++++						 * Modify the topic index data before it is assigned to the template
++++						 *
++++						 * @event dmzx.topicindex.modify_block_topic_index_ary
++++						 * @var		array	template_vars	Template block array with topic data
++++						 * @since 1.0.5
++++						 */
++++						$vars = array('indexdata', 'template_vars');
++++						extract($this->dispatcher->trigger_event('dmzx.topicindex.modify_block_topic_index_ary', compact($vars)));
++++
++++						$this->template->assign_block_vars('block_list.block_topic_index', $template_vars);
+++ 						$nums++;
+++ 					}
+++ 				}
+++@@ -252,18 +273,29 @@ class main
+++ 			// Others data for menu
+++ 			$this->template->assign_block_vars('block_nofiltrino', array(
+++ 				'U_TUTTI'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list)),
+++-				'U_09'		=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit=09')),
+++-				'U_SYMB'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit=_')),
++++				'U_09'		=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit' => '09')),
++++				'U_SYMB'	=> $this->helper->route('dmzx_topicindex_controller', array('list' => $list, 'ilimit' => '_')),
+++ 				'S_09'		=> (in_array('09', $fixa)) ? true : false,
+++ 				'S_SYMB'	=> (in_array('_', $fixa)) ? true : false
+++ 			));
+++ 		}
+++ 
++++		$title = implode(' - ', array_filter([$this->user->lang['OIINDEX_HEADER'], $selected_category]));
++++
++++		// Navigation
++++		$this->template->assign_block_vars('navlinks', array(
++++			'FORUM_NAME'	=> $title,
++++			'U_VIEW_FORUM'	=> $zurl
++++		));
++++
+++ 		$this->functions_topicindex->assign_authors();
+++ 
+++-		$this->template->assign_var('TOPICINDEX_FOOTER_VIEW', true);
++++		$this->template->assign_vars([
++++			'TOPICINDEX_FOOTER_VIEW'	=> true,
++++			'L_OIINDEX_HEADER'			=> $title,
++++		]);
+++ 
+++ 		// Send all data to the template file
+++-		return $this->helper->render('topiclist.html', $this->user->lang['OIINDEX_HEADER']);
++++		return $this->helper->render('topiclist.html', $title);
+++ 	}
+++ }
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/core/functions_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/core/functions_topicindex.php"
+++index ae23129db..4e118b351 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/core/functions_topicindex.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/core/functions_topicindex.php"
+++@@ -10,6 +10,7 @@
+++ namespace dmzx\topicindex\core;
+++ 
+++ use phpbb\db\driver\driver_interface as db_interface;
++++use phpbb\event\dispatcher_interface;
+++ use phpbb\template\template;
+++ use phpbb\config\config;
+++ use phpbb\auth\auth;
+++@@ -29,6 +30,9 @@ class functions_topicindex
+++ 	/** @var auth */
+++ 	protected $auth;
+++ 
++++	/** @var dispatcher_interface */
++++	protected $dispatcher;
++++
+++ 	/** @var manager */
+++ 	protected $extension_manager;
+++ 
+++@@ -39,6 +43,7 @@ class functions_topicindex
+++ 	* @param template		$template
+++ 	* @param config			$config
+++ 	* @param auth			auth
++++	* @param dispatcher_interface $dispatcher
+++ 	* @param manager 		$extension_manager
+++ 	*/
+++ 	public function __construct(
+++@@ -46,6 +51,7 @@ class functions_topicindex
+++ 		template $template,
+++ 		config $config,
+++ 		auth $auth,
++++		dispatcher_interface $dispatcher,
+++ 		manager $extension_manager
+++ 	)
+++ 	{
+++@@ -53,6 +59,7 @@ class functions_topicindex
+++ 		$this->template 			= $template;
+++ 		$this->config				= $config;
+++ 		$this->auth					= $auth;
++++		$this->dispatcher			= $dispatcher;
+++ 		$this->extension_manager	= $extension_manager;
+++ 	}
+++ 
+++@@ -62,13 +69,24 @@ class functions_topicindex
+++ 	*/
+++ 	function get_topic_index($the_forum, $the_topic, $inlistvalue = 0, $tagfilter = 0)
+++ 	{
+++-		$sql = "SELECT topic_id, topic_title, topic_poster, topic_first_poster_name, topic_first_poster_colour, forum_id, topic_posts_approved, topic_title, inindex_topic, outindex_topic
+++-			FROM " . TOPICS_TABLE . "
+++-			WHERE forum_id = " . (int) $the_forum . "
+++-				AND topic_posts_approved >= 1
+++-				AND inindex_topic >= " . (int) $inlistvalue . "
+++-				AND outindex_topic = 0
+++-			ORDER BY topic_title ASC";
++++		$sql_array = [
++++			'SELECT'	=> 't.topic_id, t.topic_title, t.topic_poster, t.topic_first_poster_name, t.topic_first_poster_colour, t.forum_id, t.topic_posts_approved, t.inindex_topic, t.outindex_topic',
++++			'FROM'		=> [TOPICS_TABLE => 't'],
++++			'WHERE'		=> 't.forum_id = ' . (int) $the_forum . ' AND t.topic_posts_approved >= 1 AND t.inindex_topic >= ' . (int) $inlistvalue . ' AND t.outindex_topic = 0',
++++			'ORDER_BY'	=> 't.topic_title ASC',
++++		];
++++
++++		/**
++++		 * Event to modify the SQL query that fetches topics
++++		 *
++++		 * @event dmzx.topicindex.sql_fetch_topics_before
++++		 * @var array	sql_array	Array with SQL query data to fetch the current active sessions
++++		 * @since 1.0.5
++++		 */
++++		$vars = ['sql_array'];
++++		extract($this->dispatcher->trigger_event('dmzx.topicindex.sql_fetch_topics_before', compact($vars)));
++++
++++		$sql = $this->db->sql_build_query('SELECT', $sql_array);
+++ 		$result	= $this->db->sql_query($sql);
+++ 
+++ 		$topiclist	= array();
+++@@ -77,71 +95,70 @@ class functions_topicindex
+++ 		{
+++ 			if ($tagfilter == 1)
+++ 			{
+++-				switch (substr(trim($row['topic_title']),0,1))
++++				switch (mb_substr(trim($row['topic_title']),0,1))
+++ 				{
+++ 					case '(':
+++-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], ')') + 1);
++++						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], ')') + 1);
+++ 						$newstring	= trim($newstring);
+++ 
+++-						if (substr($newstring,0,1) == '(')
++++						if (mb_substr($newstring,0,1) == '(')
+++ 						{
+++-							$newstring	= substr($newstring, strpos($row['topic_title'], ')') + 1);
++++							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], ')') + 1);
+++ 							$newstring	= trim($newstring);
+++-							$keytag		= strtolower(substr($newstring,0,1));
+++-							$keyBig		= strtolower(substr($newstring,0,4));
++++							$keytag		= strtolower(mb_substr($newstring,0,1));
++++							$keyBig		= strtolower(mb_substr($newstring,0,30));
+++ 						}
+++ 						else
+++ 						{
+++-							$keytag		= strtolower(substr($newstring,0,1));
+++-							$keyBig		= strtolower(substr($newstring,0,4));
++++							$keytag		= strtolower(mb_substr($newstring,0,1));
++++							$keyBig		= strtolower(mb_substr($newstring,0,30));
+++ 						}
+++ 					break;
+++ 					case '[':
+++-						$newstring	= substr($row['topic_title'], strpos($row['topic_title'], ']') + 1);
++++						$newstring	= mb_substr($row['topic_title'], mb_strpos($row['topic_title'], ']') + 1);
+++ 						$newstring	= trim($newstring);
+++ 
+++-						if (substr($newstring,0,1) == '[')
++++						if (mb_substr($newstring,0,1) == '[')
+++ 						{
+++-							$newstring	= substr($newstring, strpos($row['topic_title'], ']') + 1);
++++							$newstring	= mb_substr($newstring, mb_strpos($row['topic_title'], ']') + 1);
+++ 							$newstring	= trim($newstring);
+++-							$keytag		= strtolower(substr($newstring,0,1));
+++-							$keyBig		= strtolower(substr($newstring,0,4));
++++							$keytag		= strtolower(mb_substr($newstring,0,1));
++++							$keyBig		= strtolower(mb_subs
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/ext.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/ext.php"
++deleted file mode 100644
++index ca95024cf..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/ext.php"
+++++ /dev/null
++@@ -1,19 +0,0 @@
++-<?php
++-/**
++-*
++-* @package phpBB Extension - Topic Index
++-* @copyright (c) 2020 dmzx - https://www.dmzx-web.net
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-namespace dmzx\topicindex;
++-
++-class ext extends \phpbb\extension\base
++-{
++-	public function is_enableable()
++-	{
++-		$config = $this->container->get('config');
++-		return version_compare($config['version'], '3.2.0', '>=');
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/acp_topicindex.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/acp_topicindex.php"
++deleted file mode 100644
++index d52046fe7..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/acp_topicindex.php"
+++++ /dev/null
++@@ -1,62 +0,0 @@
++-<?php
++-/**
++-*
++-* @version $Id: acp_topicindex.php 50 2017-01-22 01:57:07Z Scanialady $
++-* @package phpBB Extension - Topic Index [Deutsch]
++-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-/**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ‚ ‘ ’ « » „ “ ” …
++-//
++-
++-// Merge the following language entries into the lang array
++-$lang = array_merge($lang, array(
++-	'OFFICIAL_TOPIC_INDEX'			=> 'Verwalte Official Topic Index Extension',
++-	'ADD_NEW_TOPICS_LIST'			=> 'Neue Liste hinzufügen',
++-	'LIST_NAME'						=> 'Listenname',
++-	'OINDEX_CFG_SETUP'				=> 'Konfiguriere Official Topic Index',
++-	'OVERFLOW_IN_TOPIC'				=> 'Erlaube Laufleiste auf der internen Themenliste',
++-	'NAME_FORUM_LIST_EMPTY'			=> 'Der Listenname darf nicht leer sein.',
++-	'SELECT_FORUM_LIST_EMPTY'		=> 'Mindestens ein Forum muss ausgewählt werden.',
++-	'OINDEX_ADDED_LIST'				=> 'Liste erfolgreich gespeichert.',
++-	'OINDEX_DELETED_LIST'			=> 'Liste erfolgreich gelöscht.',
++-	'OINDEX_EDIT_CFG'				=> 'Konfiguration von Official Topic Index erfolgreich geändert.',
++-	'OINDEX_FORUMS'					=> 'Foren',
++-	'OINDEX_SELECT_FORUM'			=> 'Wähle ein Forum',
++-	'OTINDEX_LIST_ALONE_DSC'		=> 'Erstelle eine externe Liste von allen Themen eines einzelnen Forums, oder aus einer Auswahl mehrerer Foren zusammen. Im Gegensatz zu einer Liste in einem Thema, muss die externe nicht direkt in dem Forum aktiviert werden. Aber in dem Fall werden alle Themen aufgelistet, ohne eine Auswahlmöglichkeit.',
++-	'OTINDEX_LIST_INTOPIC_DSC'		=> 'Erstelle eine organisierte Themenliste, welche innerhalb eines ausgewählten Themas erscheinen wird. Sobald du diese Funktion aktiviert hast, erscheinen in jedem ersten Beitrag jedes Themas neue Icons zum Einfügen oder Entfernen des Themas aus der Liste.',
++-	'ACTIVE_TOPIC_INDEX'			=> 'Aktiviere, und wähle das Thema für die Liste',
++-	'TOPIC_INDEX_DEFAULT'			=> 'Wähle aus, welche Themen standardmäßig hinzuzufügen sind.',
++-	'ACTIVE_TOPIC_INDEX_EXPLAIN'	=> 'Wähle ein Thema aus den <strong>Wichtigen Themen oder Ankündigungsthemen</strong>, dieses Thema wird die Themenliste werden. Du musst deshalb mindestens ein Thema in diesem Forum haben.',
++-	'TOPIC_INDEX_DEFAULT_EXPLAIN'	=> 'Wähle das System, nach welchem die Themen in der Liste eingebunden werden sollen',
++-	'ACTIVE_INDEX_FILTER'			=> 'Aktiviere Tag-Filter',
++-	'ACTIVE_INDEX_FILTER_EXPLAIN'	=> 'Du musst dies aktivieren, wenn du Themen mit gemeinsamem TAG im Titel hasts. Wir unterstützen Tags mit diesem Format, einzeln oder doppelt: <strong>[]</strong>,<strong>{}</strong>,<strong>()</strong>.',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/common.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/common.php"
++deleted file mode 100644
++index 3eec423ff..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/common.php"
+++++ /dev/null
++@@ -1,58 +0,0 @@
++-<?php
++-/**
++-*
++-* @version $Id: common.php 50 2017-01-22 01:57:07Z Scanialady $
++-* @package phpBB Extension - Topic Index [Deutsch]
++-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-/**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-//	‚ ‘ ’ « » „ “ ” …
++-//
++-
++-$lang = array_merge($lang, array(
++-	'ADD_INILIST'					=> '+Liste',
++-	'REMOVE_INILIST'				=> '-Liste',
++-	'OTINDEX_LINK_TITLE'			=> 'Themenliste',
++-	'NUM'							=> 'Nr.',
++-	'POSTER'						=> 'Verfasst von',
++-	'INDEX_POST_PRES'				=> 'Bevor du ein neues Thema eröffnest, prüfe bitte, ob es nicht bereits in dieser Liste ist. Wenn bereits vorhanden, benutze dieses Thema, um deine Beiträge zu schreiben.<br />Danke.',
++-	'NON_ACTIVE'					=> 'Inaktiv',
++-	'DEF_ALL_TOPICS_IN'				=> 'Alle neuen Themen automatisch',
++-	'DEF_ALL_TOPICS_OFF'			=> 'Füge Themen manuell zur Liste hinzu',
++-	'REMOVE_FROM_LIST'				=> 'entfernen',
++-	'TOPICINDEX_VERSION'			=> 'Version',
++-	'ALL'							=> 'Alle',
++-	'09'							=> '0-9',
++-	'SYMB'							=> '#&%',
++-	'ANY_TOPIC_IN_LIST'				=> 'Alle Themen in der Liste',
++-	'SELECT_A_LIST'					=> 'Wähle eine Liste',
++-	'OIINDEX_HEADER'				=> 'Official Topic Index - Themenliste',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/info_acp_topicindex.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/info_acp_topicindex.php"
++deleted file mode 100644
++index 9e4417d71..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/info_acp_topicindex.php"
+++++ /dev/null
++@@ -1,48 +0,0 @@
++-<?php
++-/**
++-*
++-* @version $Id: info_acp_topicindex.php 50 2017-01-22 01:57:07Z Scanialady $
++-* @package phpBB Extension - Topic Index [Deutsch]
++-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-/**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ‚ ‘ ’ « » „ “ ” …
++-//
++-
++-// Merge the following language entries into the lang array
++-$lang = array_merge($lang, array(
++-	'ACP_CAT_OINDEX'				=> 'Official Topic Index',
++-	'ACP_OINDEX_CFG'				=> 'Konfiguration',
++-	//Log
++-	'LOG_OINDEX_ADDLIST'			=> '<strong>Neue Themenliste hinzugefügt.</strong><br />%s',
++-	'LOG_OINDEX_DELETELIST'			=> '<strong>Themenliste entfernt.</strong><br />%s',
++-	'LOG_OINDEX_EDITCFG'			=> '<strong>Konfiguration von Official Topic Index bearbeitet.</strong><br />%s',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/en/common.php"
++index 245589076..91e3f19fa 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/en/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/en/common.php"
++@@ -53,5 +53,5 @@ $lang = array_merge($lang, array(
++ 	'SYMB'							=> '#&%',
++ 	'ANY_TOPIC_IN_LIST'				=> 'Any topics',
++ 	'SELECT_A_LIST'					=> 'Select a list',
++-	'OIINDEX_HEADER'				=> 'Official Topic Index - Topics List',
+++	'OIINDEX_HEADER'				=> 'Topics List',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/acp_topicindex.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/acp_topicindex.php"
++deleted file mode 100644
++index 91b3b3416..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/acp_topicindex.php"
+++++ /dev/null
++@@ -1,62 +0,0 @@
++-<?php
++-/**
++-*
++-* @package phpBB Extension - Topic Index
++-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
++-* Nederlandse vertaling @ Solidjeuh <http://www.froddelpower.be>
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-/**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
++-
++-// Merge the following language entries into the lang array
++-$lang = array_merge($lang, array(
++-	'OFFICIAL_TOPIC_INDEX'			=> 'Beheer Officiële Topic Index Extensie',
++-	'ADD_NEW_TOPICS_LIST'			=> 'Voeg nieuwe lijst toe',
++-	'LIST_NAME'						=> 'Lijst naam',
++-	'OINDEX_CFG_SETUP'				=> 'Configureer Officiële Topic Index',
++-	'OVERFLOW_IN_TOPIC'				=> 'Sta scroll bar toe in de binnenste topic lijst',
++-	'NAME_FORUM_LIST_EMPTY'			=> 'De lijst naam kan niet leeg zijn.',
++-	'SELECT_FORUM_LIST_EMPTY'		=> 'Er moet op zijn minst een forum geselecteerd zijn.',
++-	'OINDEX_ADDED_LIST'				=> 'Lijst succesvol opgeslagen.',
++-	'OINDEX_DELETED_LIST'			=> 'Lijst succesvol verwijderd.',
++-	'OINDEX_EDIT_CFG'				=> 'Configuratie van Officiële Topic Index succesvol bewerkt.',
++-	'OINDEX_FORUMS'					=> 'Forums',
++-	'OINDEX_SELECT_FORUM'			=> 'Selecteer een forum',
++-	'OTINDEX_LIST_ALONE_DSC'		=> 'Maak een externe lijst van alle topics in een bepaald forum of meerdere forums samen. De externe lijst hoeft niet geactiveerd te zijn in het forum. Maar zal in dat geval alle topics opnemen.',
++-	'OTINDEX_LIST_INTOPIC_DSC'		=> 'Maak een georganiseerde topic lijst die zal verschijnen in een gekozen onderwerp. Zodra je deze functie activeert zullen bij elke eerste post van een topic nieuwe iconen verschijnen om de topic toe te voegen of te verwijderen van de lijst.',
++-	'ACTIVE_TOPIC_INDEX'			=> 'Activeer en selecteer de topic voor de lijst',
++-	'TOPIC_INDEX_DEFAULT'			=> 'Kies welke topics er standaard worden toegevoegd.',
++-	'ACTIVE_TOPIC_INDEX_EXPLAIN'	=> 'Kies de topic van een sticky of een mededeling. Topics zullen een lijst worden. Je moet dus op zijn minst 1 topic in het forum hebben.',
++-	'TOPIC_INDEX_DEFAULT_EXPLAIN'	=> 'Kies het systeem waarmee de onderwerpen opgenomen worden in de lijst',
++-	'ACTIVE_INDEX_FILTER'			=> 'Actieve tag filter',
++-	'ACTIVE_INDEX_FILTER_EXPLAIN'	=> 'Je moet dit activeren als je topics hebt met gemeenschappelijke TAGS hebt in de titel. We ondersteunen tags met dit formaat, enkel of dubbel: <strong>[]</strong>,<strong>{}</strong>,<strong>()</strong>.',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/info_acp_topicindex.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/info_acp_topicindex.php"
++deleted file mode 100644
++index 71bb32ab8..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/info_acp_topicindex.php"
+++++ /dev/null
++@@ -1,48 +0,0 @@
++-<?php
++-/**
++-*
++-* @package phpBB Extension - Topic Index
++-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
++-* Nederlandse vertaling @ Solidjeuh <http://www.froddelpower.be>
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-/**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
++-
++-// Merge the following language entries into the lang array
++-$lang = array_merge($lang, array(
++-	'ACP_CAT_OINDEX'				=> 'Officiële Topic Index',
++-	'ACP_OINDEX_CFG'				=> 'Configuratie',
++-	//Log
++-	'LOG_OINDEX_ADDLIST'			=> '<strong>Nieuwe topic lijst toegevoegd.</strong><br />%s',
++-	'LOG_OINDEX_DELETELIST'			=> '<strong>Topic lijst verwijderd.</strong><br />%s',
++-	'LOG_OINDEX_EDITCFG'			=> '<strong>Bewerkte de configuratie van Offici&euml;le topic index</strong><br />%s',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/acp_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/acp_topicindex.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/acp_topicindex.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/acp_topicindex.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/common.php"
++similarity index 70%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/common.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/common.php"
++index cceede427..384068c2d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/common.php"
++@@ -39,11 +39,11 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, array(
++ 	'ADD_INILIST'					=> '+Lista',
++ 	'REMOVE_INILIST'				=> '-Lista',
++-	'OTINDEX_LINK_TITLE'			=> 'Lista de tópicos',
+++	'OTINDEX_LINK_TITLE'			=> 'Lista de Tópicos',
++ 	'NUM'							=> 'N°',
++-	'POSTER'						=> 'Postada por',
++-	'INDEX_POST_PRES'				=> 'Antes de abrir um novo tópico, por favor verifique se ele já existe na lista. Se existir, use aquele tópico para escrever suas mensagens.<br />Obrigado',
++-	'NON_ACTIVE'					=> 'Inativo',
+++	'POSTER'						=> 'Enviado por',
+++	'INDEX_POST_PRES'				=> 'Antes de abrir um novo tópico, por favor verifica se já existe na lista. Se existir, usa esse tópico para escrever uma mensagem.<br />Obrigado',
+++	'NON_ACTIVE'					=> 'Inactivo',
++ 	'DEF_ALL_TOPICS_IN'				=> 'Todos os novos tópicos automaticamente',
++ 	'DEF_ALL_TOPICS_OFF'			=> 'Adiciona tópicos manualmente à lista',
++ 	'REMOVE_FROM_LIST'				=> 'remover',
++@@ -51,7 +51,13 @@ $lang = array_merge($lang, array(
++ 	'ALL'							=> 'Todos',
++ 	'09'							=> '0-9',
++ 	'SYMB'							=> '#&%',
++-	'ANY_TOPIC_IN_LIST'				=> 'Qualquer tópico',
++-	'SELECT_A_LIST'					=> 'Selecione uma lista',
++-	'OIINDEX_HEADER'				=> 'Official Topic Index - Topics List',
+++	'ANY_TOPIC_IN_LIST'				=> 'Nenhum tópico enviado!',
+++	'SELECT_A_LIST'					=> 'Seleccione uma lista',
+++	'OIINDEX_HEADER'				=> 'Lista de tópicos',
+++	'LANGUAGE'				        => 'Idioma',
+++	'CATEGORY'				        => 'Categoria',
+++	'COMMENTS'				        => 'Comentários',
+++	'BUTTON_UPLOAD'				    => 'Partilhar Projecto',
+++	'BUTTON_UPLOAD_EXPLAIN'		    => 'Sim! Começa a partilhar projectos na nossa comunidade!',
+++	
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/info_acp_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/info_acp_topicindex.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/info_acp_topicindex.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/info_acp_topicindex.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/permissions_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/permissions_topicindex.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/permissions_topicindex.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/permissions_topicindex.php"
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/acp_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/acp_topicindex.php"
++new file mode 100644
++index 000000000..8a9dd1333
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/acp_topicindex.php"
++@@ -0,0 +1,61 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Topic Index
+++* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+++//
+++// Placeholders can now contain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// translators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+++// equally where a string contains only two placeholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++//
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++//
+++
+++// Merge the following language entries into the lang array
+++$lang = array_merge($lang, array(
+++	'OFFICIAL_TOPIC_INDEX'			=> 'Gerencia a extensão Official Topic Index',
+++	'ADD_NEW_TOPICS_LIST'			=> 'Adiciona uma nova lista',
+++	'LIST_NAME'						=> 'Nome da lista',
+++	'OINDEX_CFG_SETUP'				=> 'Configura a Official Topic Index',
+++	'OVERFLOW_IN_TOPIC'				=> 'Permite barra de rolagem na lista de tópicos',
+++	'NAME_FORUM_LIST_EMPTY'			=> 'O nome da lista não pode estar vazio.',
+++	'SELECT_FORUM_LIST_EMPTY'		=> 'Pelo menos um fórum deve ser selecionado.',
+++	'OINDEX_ADDED_LIST'				=> 'Lista salva com sucesso.',
+++	'OINDEX_DELETED_LIST'			=> 'Lista deletada com sucesso.',
+++	'OINDEX_EDIT_CFG'				=> 'Configuração da Official Topic Index editada com sucesso.',
+++	'OINDEX_FORUMS'					=> 'Fóruns',
+++	'OINDEX_SELECT_FORUM'			=> 'Selecione um fórum',
+++	'OTINDEX_LIST_ALONE_DSC'		=> 'Cria uma lista externa de todos os tópicos de um único fórum ou um conjunto de fóruns. Ao invés de uma lista no tópico, as externas não necessitam ser ativadas diretamente no fórum mas neste caso serão listados todos os tópicos sem nenhuma escolha.',
+++	'OTINDEX_LIST_INTOPIC_DSC'		=> 'Cria uma lista de tópicos organizada que irá aparecer dentro de um tópico escolhido. Uma vez que você ative esta função, aparecerão novos ícones para inserir ou remover tópicos da lista em todos as primeiras mensagens de cada tópico.',
+++	'ACTIVE_TOPIC_INDEX'			=> 'Ativa e seleciona o tópico para a lista',
+++	'TOPIC_INDEX_DEFAULT'			=> 'Escolha quais tópicos adicionar por padrão.',
+++	'ACTIVE_TOPIC_INDEX_EXPLAIN'	=> 'Escolha o tópico nos tópicos <strong>fixos ou anúncios</strong> que se converterão na lista. Para isso, você deve ter ao menos um tópico no fórum.',
+++	'TOPIC_INDEX_DEFAULT_EXPLAIN'	=> 'Escolha o sistema pelo qual os tópicos serão incluídos à lista',
+++	'ACTIVE_INDEX_FILTER'			=> 'Ativa filtro de tag',
+++	'ACTIVE_INDEX_FILTER_EXPLAIN'	=> 'Você deve ativar isso se você tem tópicos com uma TAG comum no título. Nós suportamos tags com formato simples ou duplo: <strong>[]</strong>,<strong>{}</strong>,<strong>()</strong>.',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/common.php"
++similarity index 52%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/common.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/common.php"
++index b8cc92cb9..384068c2d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/common.php"
++@@ -3,7 +3,6 @@
++ *
++ * @package phpBB Extension - Topic Index
++ * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
++-* Nederlandse vertaling @ Solidjeuh <http://www.froddelpower.be>
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++@@ -38,21 +37,27 @@ if (empty($lang) || !is_array($lang))
++ //
++ 
++ $lang = array_merge($lang, array(
++-	'ADD_INILIST'					=> '+Lijst',
++-	'REMOVE_INILIST'				=> '-Lijst',
++-	'OTINDEX_LINK_TITLE'			=> 'Topics lijst',
+++	'ADD_INILIST'					=> '+Lista',
+++	'REMOVE_INILIST'				=> '-Lista',
+++	'OTINDEX_LINK_TITLE'			=> 'Lista de Tópicos',
++ 	'NUM'							=> 'N°',
++-	'POSTER'						=> 'Gepost door',
++-	'INDEX_POST_PRES'				=> 'Kijk eerst eens in deze lijst dat de topic niet reeds bestaat alvorens een nieuwe topic te openen.<br />Bedankt.',
++-	'NON_ACTIVE'					=> 'Inactief',
++-	'DEF_ALL_TOPICS_IN'				=> 'Alle nieuwe topics automatisch',
++-	'DEF_ALL_TOPICS_OFF'			=> 'Voeg manueel topics toe in de lijst.',
++-	'REMOVE_FROM_LIST'				=> 'verwijder',
++-	'TOPICINDEX_VERSION'			=> 'Versie',
++-	'ALL'							=> 'Alle',
+++	'POSTER'						=> 'Enviado por',
+++	'INDEX_POST_PRES'				=> 'Antes de abrir um novo tópico, por favor verifica se já existe na lista. Se existir, usa esse tópico para escrever uma mensagem.<br />Obrigado',
+++	'NON_ACTIVE'					=> 'Inactivo',
+++	'DEF_ALL_TOPICS_IN'				=> 'Todos os novos tópicos automaticamente',
+++	'DEF_ALL_TOPICS_OFF'			=> 'Adiciona tópicos manualmente à lista',
+++	'REMOVE_FROM_LIST'				=> 'remover',
+++	'TOPICINDEX_VERSION'			=> 'Versão',
+++	'ALL'							=> 'Todos',
++ 	'09'							=> '0-9',
++ 	'SYMB'							=> '#&%',
++-	'ANY_TOPIC_IN_LIST'				=> 'Alle topics',
++-	'SELECT_A_LIST'					=> 'Selecteer een lijst',
++-	'OIINDEX_HEADER'				=> 'Officiële Topic Index - Topics Lijst',
+++	'ANY_TOPIC_IN_LIST'				=> 'Nenhum tópico enviado!',
+++	'SELECT_A_LIST'					=> 'Seleccione uma lista',
+++	'OIINDEX_HEADER'				=> 'Lista de tópicos',
+++	'LANGUAGE'				        => 'Idioma',
+++	'CATEGORY'				        => 'Categoria',
+++	'COMMENTS'				        => 'Comentários',
+++	'BUTTON_UPLOAD'				    => 'Partilhar Projecto',
+++	'BUTTON_UPLOAD_EXPLAIN'		    => 'Sim! Começa a partilhar projectos na nossa comunidade!',
+++	
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/permissions_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/info_acp_topicindex.php"
++similarity index 72%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/permissions_topicindex.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/info_acp_topicindex.php"
++index d0a84318c..d1cedf477 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/permissions_topicindex.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/info_acp_topicindex.php"
++@@ -1,7 +1,6 @@
++ <?php
++ /**
++ *
++-* @version $Id: permissions_topicindex.php 51 2017-01-22 14:05:52Z Scanialady $
++ * @package phpBB Extension - Topic Index
++ * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++@@ -34,10 +33,15 @@ if (empty($lang) || !is_array($lang))
++ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++ //
++ // Some characters you may want to copy&paste:
++-// ‚ ‘ ’ « » „ “ ” …
+++// ’ » “ ” …
++ //
++ 
++ // Merge the following language entries into the lang array
++ $lang = array_merge($lang, array(
++-	'ACL_U_TOPICINDEX'		=> 'Kann „Official Topic Index“-Themenliste sehen',
+++	'ACP_CAT_OINDEX'				=> 'Official Topic Index',
+++	'ACP_OINDEX_CFG'				=> 'Configuração',
+++	//Log
+++	'LOG_OINDEX_ADDLIST'			=> '<strong>Adicionada nova lista de tópicos.</strong><br />%s',
+++	'LOG_OINDEX_DELETELIST'			=> '<strong>Excluída lista de tópicos.</strong><br />%s',
+++	'LOG_OINDEX_EDITCFG'			=> '<strong>Editada a configuração da Official Topic Index.</strong><br />%s',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/permissions_topicindex.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/permissions_topicindex.php"
++similarity index 88%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/permissions_topicindex.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/permissions_topicindex.php"
++index 64b674fcd..238626333 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/permissions_topicindex.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/permissions_topicindex.php"
++@@ -3,7 +3,6 @@
++ *
++ * @package phpBB Extension - Topic Index
++ * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
++-* Nederlandse vertaling @ Solidjeuh <http://www.froddelpower.be>
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++@@ -39,5 +38,5 @@ if (empty($lang) || !is_array($lang))
++ 
++ // Merge the following language entries into the lang array
++ $lang = array_merge($lang, array(
++-	'ACL_U_TOPICINDEX'		=> 'Kan de Officiële Topic Index - Topics lijst bekijken',
+++	'ACL_U_TOPICINDEX'		=> 'Pode ver a Official Topic Index - Topics List',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_footer_copyright_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_footer_copyright_append.html"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_footer_copyright_append.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_footer_copyright_append.html"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_header_head_append.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
++similarity index 61%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_header_navigation_append.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
++index 0fdd2f70d..fa2318741 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_header_navigation_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
++@@ -1,7 +1,7 @@
++ {% if TOPICINDEXLIST_VIEW %}
++ <li data-last-responsive="true">
++ 	<a href="{{ U_OTINDEX }}" title="{{ lang('OTINDEX_LINK_TITLE') }}" role="menuitem">
++-		<i class="icon fa-envelope fa-fw" aria-hidden="true"></i><span>{{ lang('OTINDEX_LINK_TITLE') }}</span>
+++		<i class="icon fa fa-envelope fa-fw" aria-hidden="true"></i><span>{{ lang('OTINDEX_LINK_TITLE') }}</span>
++ 	</a>
++ </li>
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/viewtopic_body_post_buttons_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_after.html"
++similarity index 56%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/viewtopic_body_post_buttons_after.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_after.html"
++index eda22677b..3c096b49f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/viewtopic_body_post_buttons_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_after.html"
++@@ -1,8 +1,8 @@
++-{% if U_MCP && postrow.U_ININDEXLIST %}
++-<li>
++-	<a href="{{ postrow.U_ININDEXLIST }}" title="{{ postrow.IINEDX_LANG }}" class="button button-icon-only">
+++{% if U_ACP && postrow.U_ININDEXLIST %}
+++<div class="btn-group btn-group-sm" role="group">
+++	<a href="{{ postrow.U_ININDEXLIST }}" title="{{ postrow.IINEDX_LANG }}" class="btn btn-default btn-sm">
++ 		<i class="icon {{ postrow.IINDEX_ICON }}" aria-hidden="true"></i>
++ 		<span class="sr-only">{{ postrow.IINEDX_LANG }}</span>
++ 	</a>
++-</li>
++-{% endif %}
++\ No newline at end of file
+++</div>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/official_topic_index.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/official_topic_index.html"
++new file mode 100644
++index 000000000..2d85a8ee9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/official_topic_index.html"
++@@ -0,0 +1,58 @@
+++<div id="{{ S_ISTYLE }}">
+++	<strong>{{ lang('INDEX_POST_PRES') }}</strong>
+++	<fieldset>
+++		{% EVENT dmzx_topic_index_topic_filter_container_before %}
+++		<p class="filtrino icenter">
+++			{% for block_nofiltrino in loops.block_nofiltrino %}
+++				<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_TUTTI }}">{{ lang('ALL') }}</a></span>
+++				{% if block_nofiltrino.S_09 %}<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_09 }}">{{ lang('09') }}</a></span>{% else %}<span class="btn-basic btn-xs">{{ lang('09') }}</span>{% endif %}
+++				{% if block_nofiltrino.S_SYMB %}<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_SYMB }}">{{ lang('SYMB') }}</a></span>{% else %}<span class="btn-basic btn-xs">{{ lang('SYMB') }}</span>{% endif %}
+++			{% endfor %}
+++			{% for block_filtrino in loops.block_filtrino %}
+++				{% EVENT dmzx_topic_index_topic_filter_before %}
+++				{% if block_filtrino.S_ISWITH %}
+++					<span class="btn btn-default btn-xs"><a href="{{ block_filtrino.U_FILTER }}">{{ block_filtrino.FILTRINO }}</a></span>
+++				{% else %}
+++					<span class="btn-basic btn-xs">{{ block_filtrino.FILTRINO }}</span>
+++				{% endif %}
+++				{% EVENT dmzx_topic_index_topic_filter_after %}
+++			{% endfor %}
+++		</p>
+++		{% EVENT dmzx_topic_index_topic_filter_container_after %}
+++	</fieldset>
+++    <div class="filtrino icenter">
+++		<a href="{ROOT_PATH}posting.php?mode=post" role="button" title="{L_BUTTON_UPLOAD_EXPLAIN}"class="btn btn-default btn-load" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-plus"></i>&nbsp;{L_BUTTON_UPLOAD}</a>
+++	</div>
+++	{% if loops.block_list|length %}
+++	{% for block_list in loops.block_list %}
+++	{% if block_list.S_ISWITH2 %}
+++	<br/><br/>
+++	<h3>{{ block_list.FILTRINO }}</h3>
+++	<table class="table table-bordered">
+++		<thead> 
+++			<tr> 
+++				<th class="list-inner">{{ lang('TITLE') }}</th>
+++				<th class="topics">{{ lang('AUTHOR') }}</th>
+++				<th class="posts">{{ lang('COMMENTS') }}</th>
+++				{% if U_ACP %}<th class="lastpost"><span>{{ lang('REMOVE_FROM_LIST') }}</span></th>{% endif %}
+++			</tr>
+++		</thead>
+++		{% for block_topic_index in block_list.block_topic_index %}
+++		<tbody>
+++			<tr>
+++				<td class="topicindex">{% EVENT dmzx_topic_index_topic_before %}<a href="{{ block_topic_index.ITOPIC_URL }}" class="topictitle">{% EVENT dmzx_topic_index_topic_title_container_before %}<strong>{% EVENT dmzx_topic_index_topic_title_before %} {{ block_topic_index.ITOPIC_TITLE }}</strong>{% EVENT dmzx_topic_index_topic_title_after %}</a>{% EVENT dmzx_topic_index_topic_title_container_after %}</td>
+++				<td class="topics">{{ block_topic_index.ITOPIC_POSTER }}</td>
+++				<td class="posts">{{ block_topic_index.ITOPIC_TOTREP }}</td>
+++				{% if U_ACP %}<td class="lastpost"><span class="topicindexremove"><a href="{{ block_topic_index.U_REMOVE_FROM }}" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true" title="{{ lang('REMOVE_FROM_LIST') }}"></i></a></span></td>{% endif %}
+++			</tr>
+++		</tbody>
+++		{% endfor %}
+++	</table>
+++	{% endif %}
+++	{% endfor %}
+++	{% else %}
+++	<fieldset>
+++		<p class="ianytopuc">{{ lang('ANY_TOPIC_IN_LIST') }}</p>
+++	</fieldset>
+++	{% endif %}
+++</div>
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/topiclist.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/topiclist.html"
++new file mode 100644
++index 000000000..4fb6782bd
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/topiclist.html"
++@@ -0,0 +1,83 @@
+++{% INCLUDE 'overall_header.html' %}
+++
+++<fieldset class="framed-ucp topic-list">
+++	<legend>{{ lang('OIINDEX_HEADER') }} {% if TOPIC_INDEX_USER_TOPICS_FILTERING_NAME %}{{ lang('TOPIC_INDEX_USER_TOPICS_FILTERING', TOPIC_INDEX_USER_TOPICS_FILTERING_NAME) }}{% endif %}</legend>
+++
+++<form action="{{ U_ACTION }}" method="post">
+++	<div class="panel-content">
+++		<div class="panel-body">
+++			<fieldset>
+++				<div class="controls controls-row"> 
+++					<select class="selectpicker" data-container="body" name="list" id="listslc" onchange="this.form.submit();" data-togglable-settings="true">
+++						<option value="0" selected="selected">{{ lang('SELECT_A_LIST') }}</option>{{ S_LIST_OPTIONS }}
+++					</select>
+++				</div>
+++			</fieldset>
+++		</div>
+++	</div>
+++{{ S_FORM_TOKEN }}
+++</form>
+++
+++{% if S_SHOWLIST %}
+++<div class="panel bg1">
+++	<div class="inner">
+++	{% EVENT dmzx_topic_index_topic_filter_container_before %}
+++		<p class="filtrino icenter">
+++			{% for block_nofiltrino in loops.block_nofiltrino %}
+++				<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_TUTTI }}">{{ lang('ALL') }}</a></span>
+++				{% if block_nofiltrino.S_09 %}<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_09 }}">{{ lang('09') }}</a></span>{% else %}<span  class="btn-basic btn-xs">{{ lang('09') }}</span>{% endif %}
+++				{% if block_nofiltrino.S_SYMB %}<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_SYMB }}">{{ lang('SYMB') }}</a></span>{% else %}<span  class="btn-basic btn-xs">{{ lang('SYMB') }}</span>{% endif %}
+++			{% endfor %}
+++			{% for block_filtrino in loops.block_filtrino %}
+++				{% EVENT dmzx_topic_index_topic_filter_before %}
+++				{% if block_filtrino.S_ISWITH %}
+++					<span class="btn btn-default btn-xs"><a href="{{ block_filtrino.U_FILTER }}">{{ block_filtrino.FILTRINO }}</a></span>
+++				{% else %}
+++					<span class="btn-basic btn-xs">{{ block_filtrino.FILTRINO }}</span>
+++				{% endif %}
+++				{% EVENT dmzx_topic_index_topic_filter_after %}
+++			{% endfor %}
+++		</p>
+++		{% EVENT dmzx_topic_index_topic_filter_container_after %}
+++	</div>
+++</div>
+++<div class="filtrino icenter">
+++	<a href="{ROOT_PATH}viewforum.php?f=124" role="button" title="{L_BUTTON_UPLOAD_EXPLAIN}"class="btn btn-default btn-load" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-plus"></i>&nbsp;{L_BUTTON_UPLOAD}</a>
+++</div>
+++{% if loops.block_list|length %}
+++{% for block_list in loops.block_list %}
+++{% if block_list.S_ISWITH2 %}
+++<br/><br/>
+++<h3>{{ block_list.FILTRINO }}</h3>
+++
+++	<table class="table table-bordered">
+++		<thead> 
+++			<tr> 
+++				<th class="list-inner">{{ lang('TITLE') }}</th>
+++				<th class="topics">{{ lang('AUTHOR') }}</th>
+++				<th class="posts">{{ lang('COMMENTS') }}</th>
+++				{% if U_ACP %}<th class="lastpost"><span>{{ lang('REMOVE_FROM_LIST') }}</span></th>{% endif %}
+++			</tr>
+++		</thead>
+++		{% for block_topic_index in block_list.block_topic_index %}
+++		<tbody>
+++			<tr>
+++				<td class="topicindex">{% EVENT dmzx_topic_index_topic_before %}<a href="{{ block_topic_index.ITOPIC_URL }}">{% EVENT dmzx_topic_index_topic_title_container_before %}<strong>{% EVENT dmzx_topic_index_topic_title_before %} {{ block_topic_index.ITOPIC_TITLE }}</strong>{% EVENT dmzx_topic_index_topic_title_after %}</a>{% EVENT dmzx_topic_index_topic_title_container_after %}</td>
+++				<td class="topics">{{ block_topic_index.ITOPIC_POSTER }}</td>
+++				<td class="posts">{{ block_topic_index.ITOPIC_TOTREP }}</td>
+++				{% if U_ACP %}<td class="lastpost"><span class="topicindexremove"><a href="{{ block_topic_index.U_REMOVE_FROM }}" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true" title="{{ lang('REMOVE_FROM_LIST') }}"></i></a></span></td>{% endif %}
+++			</tr>
+++		</tbody>
+++		{% endfor %}
+++	</table>
+++{% endif %}
+++{% endfor %}
+++{% else %}
+++<fieldset>
+++	<p class="ianytopuc">{{ lang('ANY_TOPIC_IN_LIST') }}</p>
+++</fieldset>
+++{% endif %}
+++
+++{% endif %}
+++</fieldset>
+++{% INCLUDE 'overall_footer.html' %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/images/icon_post_inilist.gif" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_post_inilist.gif"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/images/icon_post_inilist.gif"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_post_inilist.gif"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/images/icon_post_iremovelist.gif" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_post_iremovelist.gif"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/images/icon_post_iremovelist.gif"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_post_iremovelist.gif"
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_topiclist.gif" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_topiclist.gif"
++new file mode 100644
++index 000000000..54c1b79a5
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_topiclist.gif" differ
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/topicindex.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.bak.css"
++similarity index 99%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/topicindex.css"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.bak.css"
++index 28552599f..08e7fe005 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/topicindex.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.bak.css"
++@@ -48,7 +48,7 @@
++ }
++ 
++ .topicindex {
++-	font-size: 1.2em;
+++	font-size: 1.0em;
++ 	line-height: 2.2em;
++ 	padding: 4px 0;
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.css"
++new file mode 100644
++index 000000000..f2a0a198f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.css"
++@@ -0,0 +1 @@
+++#content_index{overflow:hidden!important}.content ul,.content ol{margin:0!important}.icenter{text-align:center}.itopic_num{text-align:center;width:30px}.itopic_titles{text-align:left!important;float:left}.itopic_rep{text-align:center;width:80px}.itopic_poster{text-align:center;width:250px}.index_table{margin:0;padding:0}.tlisthead{color:#000!important}.topicindex{font-size:1em;line-height:2.2em;padding:4px 0}.topicindexremove{margin-top:5px;font-size:1.2em}.filtrino{text-align:center;margin:5px;text-transform:uppercase;font-size:12px!important;font-weight:700}.i_abcdz{margin:0 0 0 2px;padding:0 4px;background:#CADCEB}.i_abcdz:hover{margin:0 0 0 2px;padding:0 4px;background:#9badb9;text-decoration:none!important}.i_nourl{margin:0 0 0 2px;padding:0 4px;background:#FFF!important;text-transform:uppercase;color:#c2c2c2!important}.i_all{margin:0 0 0 2px;padding:0 4px;background:#CADCEB}.i_all:hover{margin:0 0 0 2px;padding:0 4px;background:#9badb9;text-decoration:none!important}.ianytopuc{text-align:center;font-size:14px}@media (max-width: 850px){li.header dt{text-align:center;text-transform:none;line-height:1em;font-size:1.2em;padding-bottom:4px}ul.topiclist li.header dt,ul.topiclist li.header dt .list-inner{margin-right:0!important;padding-right:0}ul.topiclist dt,ul.topiclist dt .list-inner{margin-right:0}ul.topiclist dd{display:none}}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex_icon.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex_icon.css"
++new file mode 100644
++index 000000000..efb85eb43
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex_icon.css"
++@@ -0,0 +1 @@
+++.icon-topiclist{background-image:url(./images/icon_topiclist.gif)}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/official_topic_index.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/official_topic_index.html"
++deleted file mode 100644
++index 800520bcc..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/official_topic_index.html"
+++++ /dev/null
++@@ -1,62 +0,0 @@
++-<div id="{{ S_ISTYLE }}">
++-	<strong>{{ lang('INDEX_POST_PRES') }}</strong>
++-	<fieldset>
++-		<p class="filtrino icenter">
++-			{% for block_nofiltrino in loops.block_nofiltrino %}
++-				<span><a href="{{ block_nofiltrino.U_TUTTI }}" class="i_all">{{ lang('ALL') }}</a></span>
++-				{% if block_nofiltrino.S_09 %}<span><a href="{{ block_nofiltrino.U_09 }}" class="i_all">{{ lang('09') }}</a></span>{% else %}<span class="i_nourl">{{ lang('09') }}</span>{% endif %}
++-				{% if block_nofiltrino.S_SYMB %}<span><a href="{{ block_nofiltrino.U_SYMB }}" class="i_all">{{ lang('SYMB') }}</a></span>{% else %}<span class="i_nourl">{{ lang('SYMB') }}</span>{% endif %}
++-			{% endfor %}
++-			{% for block_filtrino in loops.block_filtrino %}
++-				{% if block_filtrino.S_ISWITH %}
++-					<span><a href="{{ block_filtrino.U_FILTER }}" class="i_abcdz">{{ block_filtrino.FILTRINO }}</a></span>
++-				{% else %}
++-					<span class="i_nourl">{{ block_filtrino.FILTRINO }}</span>
++-				{% endif %}
++-			{% endfor %}
++-		</p>
++-	</fieldset>
++-	{% if loops.block_list|length %}
++-	{% for block_list in loops.block_list %}
++-	{% if block_list.S_ISWITH2 %}
++-	<h3>{{ block_list.FILTRINO }}</h3>
++-	<div class="panel bg3">
++-		<div class="inner">
++-			<ul class="topiclist">
++-				<li class="header">
++-					<dl class="row-item">
++-						<dt>
++-							<div class="list-inner" style="color:#000000;">{{ lang('TOPIC_TITLE') }}</div>
++-						</dt>
++-						<dd class="topics" style="color:#000000;">{{ lang('POSTER') }}</dd>
++-						<dd class="posts" style="color:#000000;">{{ lang('REPLIES') }}</dd>
++-						{% if U_MCP %}<dd class="lastpost" style="color:#000000;"><span>{{ lang('REMOVE_FROM_LIST') }}</span></dd>{% endif %}
++-					</dl>
++-				</li>
++-			</ul>
++-			<ul class="topiclist forums">
++-			{% for block_topic_index in block_list.block_topic_index %}
++-				<li class="row {% if block_topic_index.S_ROW_COUNT is even %}bg1{% else %}bg2{% endif %}">
++-					<dl>
++-						<dt class="topicindex">
++-							<div class="list-inner">
++-								<a href="{{ block_topic_index.ITOPIC_URL }}"><strong>{{ block_topic_index.ITOPIC_TITLE }}</strong></a>
++-							</div>
++-						</dt>
++-						<dd class="topics">{{ block_topic_index.ITOPIC_POSTER }}</dd>
++-						<dd class="posts">{{ block_topic_index.ITOPIC_TOTREP }}</dd>
++-						{% if U_MCP %}<dd class="lastpost"><span class="topicindexremove">[<a href="{{ block_topic_index.U_REMOVE_FROM }}">{{ lang('REMOVE_FROM_LIST') }}</a>]</span></dd>{% endif %}
++-					</dl>
++-				</li>
++-			{% endfor %}
++-			</ul>
++-		</div>
++-	</div>
++-	{% endif %}
++-	{% endfor %}
++-	{% else %}
++-	<fieldset>
++-		<p class="ianytopuc">{{ lang('ANY_TOPIC_IN_LIST') }}</p>
++-	</fieldset>
++-	{% endif %}
++-</div>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/topiclist.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/topiclist.html"
++deleted file mode 100644
++index 7f5d2d27b..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/topiclist.html"
+++++ /dev/null
++@@ -1,80 +0,0 @@
++-{% INCLUDE 'overall_header.html' %}
++-
++-<h2>{{ lang('OIINDEX_HEADER') }}</h2>
++-
++-<form action="{{ U_ACTION }}" method="post">
++-	<div class="panel bg3">
++-		<div class="inner">
++-			<fieldset>
++-				<p>{{ lang('SELECT_A_LIST') }}{{ lang('COLON') }} <select id="listslc" name="list" onchange="this.form.submit();"><option value="0" selected="selected">-------</option>{{ S_LIST_OPTIONS }}</select></p>
++-			</
\ No newline at end of file
diff --git "[ORIGINAL]/dmzx\\topicindex/ext.php" "[ORIGINAL]/dmzx\\topicindex/ext.php"
deleted file mode 100644
--- "[ORIGINAL]/dmzx\\topicindex/ext.php"
+++ /dev/null
@@ -1,19 +0,0 @@
-<?php
-/**
-*
-* @package phpBB Extension - Topic Index
-* @copyright (c) 2020 dmzx - https://www.dmzx-web.net
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-namespace dmzx\topicindex;
-
-class ext extends \phpbb\extension\base
-{
-	public function is_enableable()
-	{
-		$config = $this->container->get('config');
-		return version_compare($config['version'], '3.2.0', '>=');
-	}
-}
diff --git "[ORIGINAL]/dmzx\\topicindex/language/de/acp_topicindex.php" "[ORIGINAL]/dmzx\\topicindex/language/de/acp_topicindex.php"
deleted file mode 100644
--- "[ORIGINAL]/dmzx\\topicindex/language/de/acp_topicindex.php"
+++ /dev/null
@@ -1,62 +0,0 @@
-<?php
-/**
-*
-* @version $Id: acp_topicindex.php 50 2017-01-22 01:57:07Z Scanialady $
-* @package phpBB Extension - Topic Index [Deutsch]
-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-/**
-* DO NOT CHANGE
-*/
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ‚ ‘ ’ « » „ “ ” …
-//
-
-// Merge the following language entries into the lang array
-$lang = array_merge($lang, array(
-	'OFFICIAL_TOPIC_INDEX'			=> 'Verwalte Official Topic Index Extension',
-	'ADD_NEW_TOPICS_LIST'			=> 'Neue Liste hinzufügen',
-	'LIST_NAME'						=> 'Listenname',
-	'OINDEX_CFG_SETUP'				=> 'Konfiguriere Official Topic Index',
-	'OVERFLOW_IN_TOPIC'				=> 'Erlaube Laufleiste auf der internen Themenliste',
-	'NAME_FORUM_LIST_EMPTY'			=> 'Der Listenname darf nicht leer sein.',
-	'SELECT_FORUM_LIST_EMPTY'		=> 'Mindestens ein Forum muss ausgewählt werden.',
-	'OINDEX_ADDED_LIST'				=> 'Liste erfolgreich gespeichert.',
-	'OINDEX_DELETED_LIST'			=> 'Liste erfolgreich gelöscht.',
-	'OINDEX_EDIT_CFG'				=> 'Konfiguration von Official Topic Index erfolgreich geändert.',
-	'OINDEX_FORUMS'					=> 'Foren',
-	'OINDEX_SELECT_FORUM'			=> 'Wähle ein Forum',
-	'OTINDEX_LIST_ALONE_DSC'		=> 'Erstelle eine externe Liste von allen Themen eines einzelnen Forums, oder aus einer Auswahl mehrerer Foren zusammen. Im Gegensatz zu einer Liste in einem Thema, muss die externe nicht direkt in dem Forum aktiviert werden. Aber in dem Fall werden alle Themen aufgelistet, ohne eine Auswahlmöglichkeit.',
-	'OTINDEX_LIST_INTOPIC_DSC'		=> 'Erstelle eine organisierte Themenliste, welche innerhalb eines ausgewählten Themas erscheinen wird. Sobald du diese Funktion aktiviert hast, erscheinen in jedem ersten Beitrag jedes Themas neue Icons zum Einfügen oder Entfernen des Themas aus der Liste.',
-	'ACTIVE_TOPIC_INDEX'			=> 'Aktiviere, und wähle das Thema für die Liste',
-	'TOPIC_INDEX_DEFAULT'			=> 'Wähle aus, welche Themen standardmäßig hinzuzufügen sind.',
-	'ACTIVE_TOPIC_INDEX_EXPLAIN'	=> 'Wähle ein Thema aus den <strong>Wichtigen Themen oder Ankündigungsthemen</strong>, dieses Thema wird die Themenliste werden. Du musst deshalb mindestens ein Thema in diesem Forum haben.',
-	'TOPIC_INDEX_DEFAULT_EXPLAIN'	=> 'Wähle das System, nach welchem die Themen in der Liste eingebunden werden sollen',
-	'ACTIVE_INDEX_FILTER'			=> 'Aktiviere Tag-Filter',
-	'ACTIVE_INDEX_FILTER_EXPLAIN'	=> 'Du musst dies aktivieren, wenn du Themen mit gemeinsamem TAG im Titel hasts. Wir unterstützen Tags mit diesem Format, einzeln oder doppelt: <strong>[]</strong>,<strong>{}</strong>,<strong>()</strong>.',
-));
diff --git "[ORIGINAL]/dmzx\\topicindex/language/de/common.php" "[ORIGINAL]/dmzx\\topicindex/language/de/common.php"
deleted file mode 100644
--- "[ORIGINAL]/dmzx\\topicindex/language/de/common.php"
+++ /dev/null
@@ -1,58 +0,0 @@
-<?php
-/**
-*
-* @version $Id: common.php 50 2017-01-22 01:57:07Z Scanialady $
-* @package phpBB Extension - Topic Index [Deutsch]
-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-/**
-* DO NOT CHANGE
-*/
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-//	‚ ‘ ’ « » „ “ ” …
-//
-
-$lang = array_merge($lang, array(
-	'ADD_INILIST'					=> '+Liste',
-	'REMOVE_INILIST'				=> '-Liste',
-	'OTINDEX_LINK_TITLE'			=> 'Themenliste',
-	'NUM'							=> 'Nr.',
-	'POSTER'						=> 'Verfasst von',
-	'INDEX_POST_PRES'				=> 'Bevor du ein neues Thema eröffnest, prüfe bitte, ob es nicht bereits in dieser Liste ist. Wenn bereits vorhanden, benutze dieses Thema, um deine Beiträge zu schreiben.<br />Danke.',
-	'NON_ACTIVE'					=> 'Inaktiv',
-	'DEF_ALL_TOPICS_IN'				=> 'Alle neuen Themen automatisch',
-	'DEF_ALL_TOPICS_OFF'			=> 'Füge Themen manuell zur Liste hinzu',
-	'REMOVE_FROM_LIST'				=> 'entfernen',
-	'TOPICINDEX_VERSION'			=> 'Version',
-	'ALL'							=> 'Alle',
-	'09'							=> '0-9',
-	'SYMB'							=> '#&%',
-	'ANY_TOPIC_IN_LIST'				=> 'Alle Themen in der Liste',
-	'SELECT_A_LIST'					=> 'Wähle eine Liste',
-	'OIINDEX_HEADER'				=> 'Official Topic Index - Themenliste',
-));
diff --git "[ORIGINAL]/dmzx\\topicindex/language/de/info_acp_topicindex.php" "[ORIGINAL]/dmzx\\topicindex/language/de/info_acp_topicindex.php"
deleted file mode 100644
--- "[ORIGINAL]/dmzx\\topicindex/language/de/info_acp_topicindex.php"
+++ /dev/null
@@ -1,48 +0,0 @@
-<?php
-/**
-*
-* @version $Id: info_acp_topicindex.php 50 2017-01-22 01:57:07Z Scanialady $
-* @package phpBB Extension - Topic Index [Deutsch]
-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-/**
-* DO NOT CHANGE
-*/
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ‚ ‘ ’ « » „ “ ” …
-//
-
-// Merge the following language entries into the lang array
-$lang = array_merge($lang, array(
-	'ACP_CAT_OINDEX'				=> 'Official Topic Index',
-	'ACP_OINDEX_CFG'				=> 'Konfiguration',
-	//Log
-	'LOG_OINDEX_ADDLIST'			=> '<strong>Neue Themenliste hinzugefügt.</strong><br />%s',
-	'LOG_OINDEX_DELETELIST'			=> '<strong>Themenliste entfernt.</strong><br />%s',
-	'LOG_OINDEX_EDITCFG'			=> '<strong>Konfiguration von Official Topic Index bearbeitet.</strong><br />%s',
-));
diff --git "[ORIGINAL]/dmzx\\topicindex/language/en/common.php" "[FORUM_EXT]/dmzx\\topicindex/language/en/common.php"
--- "[ORIGINAL]/dmzx\\topicindex/language/en/common.php"
+++ "[FORUM_EXT]/dmzx\\topicindex/language/en/common.php"
@@ -53,5 +53,5 @@ $lang = array_merge($lang, array(
 	'SYMB'							=> '#&%',
 	'ANY_TOPIC_IN_LIST'				=> 'Any topics',
 	'SELECT_A_LIST'					=> 'Select a list',
-	'OIINDEX_HEADER'				=> 'Official Topic Index - Topics List',
+	'OIINDEX_HEADER'				=> 'Topics List',
 ));
diff --git "[ORIGINAL]/dmzx\\topicindex/language/nl/acp_topicindex.php" "[ORIGINAL]/dmzx\\topicindex/language/nl/acp_topicindex.php"
deleted file mode 100644
--- "[ORIGINAL]/dmzx\\topicindex/language/nl/acp_topicindex.php"
+++ /dev/null
@@ -1,62 +0,0 @@
-<?php
-/**
-*
-* @package phpBB Extension - Topic Index
-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
-* Nederlandse vertaling @ Solidjeuh <http://www.froddelpower.be>
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-/**
-* DO NOT CHANGE
-*/
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
-
-// Merge the following language entries into the lang array
-$lang = array_merge($lang, array(
-	'OFFICIAL_TOPIC_INDEX'			=> 'Beheer Officiële Topic Index Extensie',
-	'ADD_NEW_TOPICS_LIST'			=> 'Voeg nieuwe lijst toe',
-	'LIST_NAME'						=> 'Lijst naam',
-	'OINDEX_CFG_SETUP'				=> 'Configureer Officiële Topic Index',
-	'OVERFLOW_IN_TOPIC'				=> 'Sta scroll bar toe in de binnenste topic lijst',
-	'NAME_FORUM_LIST_EMPTY'			=> 'De lijst naam kan niet leeg zijn.',
-	'SELECT_FORUM_LIST_EMPTY'		=> 'Er moet op zijn minst een forum geselecteerd zijn.',
-	'OINDEX_ADDED_LIST'				=> 'Lijst succesvol opgeslagen.',
-	'OINDEX_DELETED_LIST'			=> 'Lijst succesvol verwijderd.',
-	'OINDEX_EDIT_CFG'				=> 'Configuratie van Officiële Topic Index succesvol bewerkt.',
-	'OINDEX_FORUMS'					=> 'Forums',
-	'OINDEX_SELECT_FORUM'			=> 'Selecteer een forum',
-	'OTINDEX_LIST_ALONE_DSC'		=> 'Maak een externe lijst van alle topics in een bepaald forum of meerdere forums samen. De externe lijst hoeft niet geactiveerd te zijn in het forum. Maar zal in dat geval alle topics opnemen.',
-	'OTINDEX_LIST_INTOPIC_DSC'		=> 'Maak een georganiseerde topic lijst die zal verschijnen in een gekozen onderwerp. Zodra je deze functie activeert zullen bij elke eerste post van een topic nieuwe iconen verschijnen om de topic toe te voegen of te verwijderen van de lijst.',
-	'ACTIVE_TOPIC_INDEX'			=> 'Activeer en selecteer de topic voor de lijst',
-	'TOPIC_INDEX_DEFAULT'			=> 'Kies welke topics er standaard worden toegevoegd.',
-	'ACTIVE_TOPIC_INDEX_EXPLAIN'	=> 'Kies de topic van een sticky of een mededeling. Topics zullen een lijst worden. Je moet dus op zijn minst 1 topic in het forum hebben.',
-	'TOPIC_INDEX_DEFAULT_EXPLAIN'	=> 'Kies het systeem waarmee de onderwerpen opgenomen worden in de lijst',
-	'ACTIVE_INDEX_FILTER'			=> 'Actieve tag filter',
-	'ACTIVE_INDEX_FILTER_EXPLAIN'	=> 'Je moet dit activeren als je topics hebt met gemeenschappelijke TAGS hebt in de titel. We ondersteunen tags met dit formaat, enkel of dubbel: <strong>[]</strong>,<strong>{}</strong>,<strong>()</strong>.',
-));
diff --git "[ORIGINAL]/dmzx\\topicindex/language/nl/info_acp_topicindex.php" "[ORIGINAL]/dmzx\\topicindex/language/nl/info_acp_topicindex.php"
deleted file mode 100644
--- "[ORIGINAL]/dmzx\\topicindex/language/nl/info_acp_topicindex.php"
+++ /dev/null
@@ -1,48 +0,0 @@
-<?php
-/**
-*
-* @package phpBB Extension - Topic Index
-* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
-* Nederlandse vertaling @ Solidjeuh <http://www.froddelpower.be>
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-/**
-* DO NOT CHANGE
-*/
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
-
-// Merge the following language entries into the lang array
-$lang = array_merge($lang, array(
-	'ACP_CAT_OINDEX'				=> 'Officiële Topic Index',
-	'ACP_OINDEX_CFG'				=> 'Configuratie',
-	//Log
-	'LOG_OINDEX_ADDLIST'			=> '<strong>Nieuwe topic lijst toegevoegd.</strong><br />%s',
-	'LOG_OINDEX_DELETELIST'			=> '<strong>Topic lijst verwijderd.</strong><br />%s',
-	'LOG_OINDEX_EDITCFG'			=> '<strong>Bewerkte de configuratie van Offici&euml;le topic index</strong><br />%s',
-));
diff --git "[ORIGINAL]/dmzx\\topicindex/language/pt_br/acp_topicindex.php" "[FORUM_EXT]/dmzx\\topicindex/language/pt/acp_topicindex.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/acp_topicindex.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/acp_topicindex.php"
diff --git "[ORIGINAL]/dmzx\\topicindex/language/pt_br/common.php" "[FORUM_EXT]/dmzx\\topicindex/language/pt/common.php"
similarity index 70%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/common.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/common.php"
--- "[ORIGINAL]/dmzx\\topicindex/language/pt_br/common.php"
+++ "[FORUM_EXT]/dmzx\\topicindex/language/pt/common.php"
@@ -39,11 +39,11 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, array(
 	'ADD_INILIST'					=> '+Lista',
 	'REMOVE_INILIST'				=> '-Lista',
-	'OTINDEX_LINK_TITLE'			=> 'Lista de tópicos',
+	'OTINDEX_LINK_TITLE'			=> 'Lista de Tópicos',
 	'NUM'							=> 'N°',
-	'POSTER'						=> 'Postada por',
-	'INDEX_POST_PRES'				=> 'Antes de abrir um novo tópico, por favor verifique se ele já existe na lista. Se existir, use aquele tópico para escrever suas mensagens.<br />Obrigado',
-	'NON_ACTIVE'					=> 'Inativo',
+	'POSTER'						=> 'Enviado por',
+	'INDEX_POST_PRES'				=> 'Antes de abrir um novo tópico, por favor verifica se já existe na lista. Se existir, usa esse tópico para escrever uma mensagem.<br />Obrigado',
+	'NON_ACTIVE'					=> 'Inactivo',
 	'DEF_ALL_TOPICS_IN'				=> 'Todos os novos tópicos automaticamente',
 	'DEF_ALL_TOPICS_OFF'			=> 'Adiciona tópicos manualmente à lista',
 	'REMOVE_FROM_LIST'				=> 'remover',
@@ -51,7 +51,13 @@ $lang = array_merge($lang, array(
 	'ALL'							=> 'Todos',
 	'09'							=> '0-9',
 	'SYMB'							=> '#&%',
-	'ANY_TOPIC_IN_LIST'				=> 'Qualquer tópico',
-	'SELECT_A_LIST'					=> 'Selecione uma lista',
-	'OIINDEX_HEADER'				=> 'Official Topic Index - Topics List',
+	'ANY_TOPIC_IN_LIST'				=> 'Nenhum tópico enviado!',
+	'SELECT_A_LIST'					=> 'Seleccione uma lista',
+	'OIINDEX_HEADER'				=> 'Lista de tópicos',
+	'LANGUAGE'				        => 'Idioma',
+	'CATEGORY'				        => 'Categoria',
+	'COMMENTS'				        => 'Comentários',
+	'BUTTON_UPLOAD'				    => 'Partilhar Projecto',
+	'BUTTON_UPLOAD_EXPLAIN'		    => 'Sim! Começa a partilhar projectos na nossa comunidade!',
+	
 ));
diff --git "[ORIGINAL]/dmzx\\topicindex/language/pt_br/info_acp_topicindex.php" "[FORUM_EXT]/dmzx\\topicindex/language/pt/info_acp_topicindex.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/info_acp_topicindex.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/info_acp_topicindex.php"
diff --git "[ORIGINAL]/dmzx\\topicindex/language/pt_br/permissions_topicindex.php" "[FORUM_EXT]/dmzx\\topicindex/language/pt/permissions_topicindex.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/pt_br/permissions_topicindex.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt/permissions_topicindex.php"
diff --git "[FORUM_EXT]/dmzx\\topicindex/language/pt_preao/acp_topicindex.php" "[FORUM_EXT]/dmzx\\topicindex/language/pt_preao/acp_topicindex.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\topicindex/language/pt_preao/acp_topicindex.php"
@@ -0,0 +1,61 @@
+<?php
+/**
+*
+* @package phpBB Extension - Topic Index
+* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+// DEVELOPERS PLEASE NOTE
+//
+// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+//
+// Placeholders can now contain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// translators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+// equally where a string contains only two placeholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+//
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+//
+
+// Merge the following language entries into the lang array
+$lang = array_merge($lang, array(
+	'OFFICIAL_TOPIC_INDEX'			=> 'Gerencia a extensão Official Topic Index',
+	'ADD_NEW_TOPICS_LIST'			=> 'Adiciona uma nova lista',
+	'LIST_NAME'						=> 'Nome da lista',
+	'OINDEX_CFG_SETUP'				=> 'Configura a Official Topic Index',
+	'OVERFLOW_IN_TOPIC'				=> 'Permite barra de rolagem na lista de tópicos',
+	'NAME_FORUM_LIST_EMPTY'			=> 'O nome da lista não pode estar vazio.',
+	'SELECT_FORUM_LIST_EMPTY'		=> 'Pelo menos um fórum deve ser selecionado.',
+	'OINDEX_ADDED_LIST'				=> 'Lista salva com sucesso.',
+	'OINDEX_DELETED_LIST'			=> 'Lista deletada com sucesso.',
+	'OINDEX_EDIT_CFG'				=> 'Configuração da Official Topic Index editada com sucesso.',
+	'OINDEX_FORUMS'					=> 'Fóruns',
+	'OINDEX_SELECT_FORUM'			=> 'Selecione um fórum',
+	'OTINDEX_LIST_ALONE_DSC'		=> 'Cria uma lista externa de todos os tópicos de um único fórum ou um conjunto de fóruns. Ao invés de uma lista no tópico, as externas não necessitam ser ativadas diretamente no fórum mas neste caso serão listados todos os tópicos sem nenhuma escolha.',
+	'OTINDEX_LIST_INTOPIC_DSC'		=> 'Cria uma lista de tópicos organizada que irá aparecer dentro de um tópico escolhido. Uma vez que você ative esta função, aparecerão novos ícones para inserir ou remover tópicos da lista em todos as primeiras mensagens de cada tópico.',
+	'ACTIVE_TOPIC_INDEX'			=> 'Ativa e seleciona o tópico para a lista',
+	'TOPIC_INDEX_DEFAULT'			=> 'Escolha quais tópicos adicionar por padrão.',
+	'ACTIVE_TOPIC_INDEX_EXPLAIN'	=> 'Escolha o tópico nos tópicos <strong>fixos ou anúncios</strong> que se converterão na lista. Para isso, você deve ter ao menos um tópico no fórum.',
+	'TOPIC_INDEX_DEFAULT_EXPLAIN'	=> 'Escolha o sistema pelo qual os tópicos serão incluídos à lista',
+	'ACTIVE_INDEX_FILTER'			=> 'Ativa filtro de tag',
+	'ACTIVE_INDEX_FILTER_EXPLAIN'	=> 'Você deve ativar isso se você tem tópicos com uma TAG comum no título. Nós suportamos tags com formato simples ou duplo: <strong>[]</strong>,<strong>{}</strong>,<strong>()</strong>.',
+));
diff --git "[ORIGINAL]/dmzx\\topicindex/language/nl/common.php" "[FORUM_EXT]/dmzx\\topicindex/language/pt_preao/common.php"
similarity index 52%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/common.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/common.php"
--- "[ORIGINAL]/dmzx\\topicindex/language/nl/common.php"
+++ "[FORUM_EXT]/dmzx\\topicindex/language/pt_preao/common.php"
@@ -3,7 +3,6 @@
 *
 * @package phpBB Extension - Topic Index
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
-* Nederlandse vertaling @ Solidjeuh <http://www.froddelpower.be>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */
@@ -38,21 +37,27 @@ if (empty($lang) || !is_array($lang))
 //
 
 $lang = array_merge($lang, array(
-	'ADD_INILIST'					=> '+Lijst',
-	'REMOVE_INILIST'				=> '-Lijst',
-	'OTINDEX_LINK_TITLE'			=> 'Topics lijst',
+	'ADD_INILIST'					=> '+Lista',
+	'REMOVE_INILIST'				=> '-Lista',
+	'OTINDEX_LINK_TITLE'			=> 'Lista de Tópicos',
 	'NUM'							=> 'N°',
-	'POSTER'						=> 'Gepost door',
-	'INDEX_POST_PRES'				=> 'Kijk eerst eens in deze lijst dat de topic niet reeds bestaat alvorens een nieuwe topic te openen.<br />Bedankt.',
-	'NON_ACTIVE'					=> 'Inactief',
-	'DEF_ALL_TOPICS_IN'				=> 'Alle nieuwe topics automatisch',
-	'DEF_ALL_TOPICS_OFF'			=> 'Voeg manueel topics toe in de lijst.',
-	'REMOVE_FROM_LIST'				=> 'verwijder',
-	'TOPICINDEX_VERSION'			=> 'Versie',
-	'ALL'							=> 'Alle',
+	'POSTER'						=> 'Enviado por',
+	'INDEX_POST_PRES'				=> 'Antes de abrir um novo tópico, por favor verifica se já existe na lista. Se existir, usa esse tópico para escrever uma mensagem.<br />Obrigado',
+	'NON_ACTIVE'					=> 'Inactivo',
+	'DEF_ALL_TOPICS_IN'				=> 'Todos os novos tópicos automaticamente',
+	'DEF_ALL_TOPICS_OFF'			=> 'Adiciona tópicos manualmente à lista',
+	'REMOVE_FROM_LIST'				=> 'remover',
+	'TOPICINDEX_VERSION'			=> 'Versão',
+	'ALL'							=> 'Todos',
 	'09'							=> '0-9',
 	'SYMB'							=> '#&%',
-	'ANY_TOPIC_IN_LIST'				=> 'Alle topics',
-	'SELECT_A_LIST'					=> 'Selecteer een lijst',
-	'OIINDEX_HEADER'				=> 'Officiële Topic Index - Topics Lijst',
+	'ANY_TOPIC_IN_LIST'				=> 'Nenhum tópico enviado!',
+	'SELECT_A_LIST'					=> 'Seleccione uma lista',
+	'OIINDEX_HEADER'				=> 'Lista de tópicos',
+	'LANGUAGE'				        => 'Idioma',
+	'CATEGORY'				        => 'Categoria',
+	'COMMENTS'				        => 'Comentários',
+	'BUTTON_UPLOAD'				    => 'Partilhar Projecto',
+	'BUTTON_UPLOAD_EXPLAIN'		    => 'Sim! Começa a partilhar projectos na nossa comunidade!',
+	
 ));
diff --git "[ORIGINAL]/dmzx\\topicindex/language/de/permissions_topicindex.php" "[FORUM_EXT]/dmzx\\topicindex/language/pt_preao/info_acp_topicindex.php"
similarity index 72%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/de/permissions_topicindex.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/info_acp_topicindex.php"
--- "[ORIGINAL]/dmzx\\topicindex/language/de/permissions_topicindex.php"
+++ "[FORUM_EXT]/dmzx\\topicindex/language/pt_preao/info_acp_topicindex.php"
@@ -1,7 +1,6 @@
 <?php
 /**
 *
-* @version $Id: permissions_topicindex.php 51 2017-01-22 14:05:52Z Scanialady $
 * @package phpBB Extension - Topic Index
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
@@ -34,10 +33,15 @@ if (empty($lang) || !is_array($lang))
 // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 //
 // Some characters you may want to copy&paste:
-// ‚ ‘ ’ « » „ “ ” …
+// ’ » “ ” …
 //
 
 // Merge the following language entries into the lang array
 $lang = array_merge($lang, array(
-	'ACL_U_TOPICINDEX'		=> 'Kann „Official Topic Index“-Themenliste sehen',
+	'ACP_CAT_OINDEX'				=> 'Official Topic Index',
+	'ACP_OINDEX_CFG'				=> 'Configuração',
+	//Log
+	'LOG_OINDEX_ADDLIST'			=> '<strong>Adicionada nova lista de tópicos.</strong><br />%s',
+	'LOG_OINDEX_DELETELIST'			=> '<strong>Excluída lista de tópicos.</strong><br />%s',
+	'LOG_OINDEX_EDITCFG'			=> '<strong>Editada a configuração da Official Topic Index.</strong><br />%s',
 ));
diff --git "[ORIGINAL]/dmzx\\topicindex/language/nl/permissions_topicindex.php" "[FORUM_EXT]/dmzx\\topicindex/language/pt_preao/permissions_topicindex.php"
similarity index 88%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/language/nl/permissions_topicindex.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/language/pt_preao/permissions_topicindex.php"
--- "[ORIGINAL]/dmzx\\topicindex/language/nl/permissions_topicindex.php"
+++ "[FORUM_EXT]/dmzx\\topicindex/language/pt_preao/permissions_topicindex.php"
@@ -3,7 +3,6 @@
 *
 * @package phpBB Extension - Topic Index
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
-* Nederlandse vertaling @ Solidjeuh <http://www.froddelpower.be>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */
@@ -39,5 +38,5 @@ if (empty($lang) || !is_array($lang))
 
 // Merge the following language entries into the lang array
 $lang = array_merge($lang, array(
-	'ACL_U_TOPICINDEX'		=> 'Kan de Officiële Topic Index - Topics lijst bekijken',
+	'ACL_U_TOPICINDEX'		=> 'Pode ver a Official Topic Index - Topics List',
 ));
diff --git "[ORIGINAL]/dmzx\\topicindex/styles/all/template/event/overall_footer_copyright_append.html" "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_footer_copyright_append.html"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_footer_copyright_append.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_footer_copyright_append.html"
diff --git "[ORIGINAL]/dmzx\\topicindex/styles/all/template/event/overall_header_head_append.html" "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_head_append.html"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_header_head_append.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_head_append.html"
diff --git "[ORIGINAL]/dmzx\\topicindex/styles/all/template/event/overall_header_navigation_append.html" "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
similarity index 61%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/overall_header_navigation_append.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
--- "[ORIGINAL]/dmzx\\topicindex/styles/all/template/event/overall_header_navigation_append.html"
+++ "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
@@ -1,7 +1,7 @@
 {% if TOPICINDEXLIST_VIEW %}
 <li data-last-responsive="true">
 	<a href="{{ U_OTINDEX }}" title="{{ lang('OTINDEX_LINK_TITLE') }}" role="menuitem">
-		<i class="icon fa-envelope fa-fw" aria-hidden="true"></i><span>{{ lang('OTINDEX_LINK_TITLE') }}</span>
+		<i class="icon fa fa-envelope fa-fw" aria-hidden="true"></i><span>{{ lang('OTINDEX_LINK_TITLE') }}</span>
 	</a>
 </li>
 {% endif %}
diff --git "[ORIGINAL]/dmzx\\topicindex/styles/all/template/event/viewtopic_body_post_buttons_after.html" "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_after.html"
similarity index 56%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/template/event/viewtopic_body_post_buttons_after.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_after.html"
--- "[ORIGINAL]/dmzx\\topicindex/styles/all/template/event/viewtopic_body_post_buttons_after.html"
+++ "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_after.html"
@@ -1,8 +1,8 @@
-{% if U_MCP && postrow.U_ININDEXLIST %}
-<li>
-	<a href="{{ postrow.U_ININDEXLIST }}" title="{{ postrow.IINEDX_LANG }}" class="button button-icon-only">
+{% if U_ACP && postrow.U_ININDEXLIST %}
+<div class="btn-group btn-group-sm" role="group">
+	<a href="{{ postrow.U_ININDEXLIST }}" title="{{ postrow.IINEDX_LANG }}" class="btn btn-default btn-sm">
 		<i class="icon {{ postrow.IINDEX_ICON }}" aria-hidden="true"></i>
 		<span class="sr-only">{{ postrow.IINEDX_LANG }}</span>
 	</a>
-</li>
+</div>
 {% endif %}
diff --git "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/template/official_topic_index.html" "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/template/official_topic_index.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/template/official_topic_index.html"
@@ -0,0 +1,58 @@
+<div id="{{ S_ISTYLE }}">
+	<strong>{{ lang('INDEX_POST_PRES') }}</strong>
+	<fieldset>
+		{% EVENT dmzx_topic_index_topic_filter_container_before %}
+		<p class="filtrino icenter">
+			{% for block_nofiltrino in loops.block_nofiltrino %}
+				<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_TUTTI }}">{{ lang('ALL') }}</a></span>
+				{% if block_nofiltrino.S_09 %}<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_09 }}">{{ lang('09') }}</a></span>{% else %}<span class="btn-basic btn-xs">{{ lang('09') }}</span>{% endif %}
+				{% if block_nofiltrino.S_SYMB %}<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_SYMB }}">{{ lang('SYMB') }}</a></span>{% else %}<span class="btn-basic btn-xs">{{ lang('SYMB') }}</span>{% endif %}
+			{% endfor %}
+			{% for block_filtrino in loops.block_filtrino %}
+				{% EVENT dmzx_topic_index_topic_filter_before %}
+				{% if block_filtrino.S_ISWITH %}
+					<span class="btn btn-default btn-xs"><a href="{{ block_filtrino.U_FILTER }}">{{ block_filtrino.FILTRINO }}</a></span>
+				{% else %}
+					<span class="btn-basic btn-xs">{{ block_filtrino.FILTRINO }}</span>
+				{% endif %}
+				{% EVENT dmzx_topic_index_topic_filter_after %}
+			{% endfor %}
+		</p>
+		{% EVENT dmzx_topic_index_topic_filter_container_after %}
+	</fieldset>
+    <div class="filtrino icenter">
+		<a href="{ROOT_PATH}posting.php?mode=post" role="button" title="{L_BUTTON_UPLOAD_EXPLAIN}"class="btn btn-default btn-load" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-plus"></i>&nbsp;{L_BUTTON_UPLOAD}</a>
+	</div>
+	{% if loops.block_list|length %}
+	{% for block_list in loops.block_list %}
+	{% if block_list.S_ISWITH2 %}
+	<br/><br/>
+	<h3>{{ block_list.FILTRINO }}</h3>
+	<table class="table table-bordered">
+		<thead> 
+			<tr> 
+				<th class="list-inner">{{ lang('TITLE') }}</th>
+				<th class="topics">{{ lang('AUTHOR') }}</th>
+				<th class="posts">{{ lang('COMMENTS') }}</th>
+				{% if U_ACP %}<th class="lastpost"><span>{{ lang('REMOVE_FROM_LIST') }}</span></th>{% endif %}
+			</tr>
+		</thead>
+		{% for block_topic_index in block_list.block_topic_index %}
+		<tbody>
+			<tr>
+				<td class="topicindex">{% EVENT dmzx_topic_index_topic_before %}<a href="{{ block_topic_index.ITOPIC_URL }}" class="topictitle">{% EVENT dmzx_topic_index_topic_title_container_before %}<strong>{% EVENT dmzx_topic_index_topic_title_before %} {{ block_topic_index.ITOPIC_TITLE }}</strong>{% EVENT dmzx_topic_index_topic_title_after %}</a>{% EVENT dmzx_topic_index_topic_title_container_after %}</td>
+				<td class="topics">{{ block_topic_index.ITOPIC_POSTER }}</td>
+				<td class="posts">{{ block_topic_index.ITOPIC_TOTREP }}</td>
+				{% if U_ACP %}<td class="lastpost"><span class="topicindexremove"><a href="{{ block_topic_index.U_REMOVE_FROM }}" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true" title="{{ lang('REMOVE_FROM_LIST') }}"></i></a></span></td>{% endif %}
+			</tr>
+		</tbody>
+		{% endfor %}
+	</table>
+	{% endif %}
+	{% endfor %}
+	{% else %}
+	<fieldset>
+		<p class="ianytopuc">{{ lang('ANY_TOPIC_IN_LIST') }}</p>
+	</fieldset>
+	{% endif %}
+</div>
diff --git "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/template/topiclist.html" "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/template/topiclist.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/template/topiclist.html"
@@ -0,0 +1,83 @@
+{% INCLUDE 'overall_header.html' %}
+
+<fieldset class="framed-ucp topic-list">
+	<legend>{{ lang('OIINDEX_HEADER') }} {% if TOPIC_INDEX_USER_TOPICS_FILTERING_NAME %}{{ lang('TOPIC_INDEX_USER_TOPICS_FILTERING', TOPIC_INDEX_USER_TOPICS_FILTERING_NAME) }}{% endif %}</legend>
+
+<form action="{{ U_ACTION }}" method="post">
+	<div class="panel-content">
+		<div class="panel-body">
+			<fieldset>
+				<div class="controls controls-row"> 
+					<select class="selectpicker" data-container="body" name="list" id="listslc" onchange="this.form.submit();" data-togglable-settings="true">
+						<option value="0" selected="selected">{{ lang('SELECT_A_LIST') }}</option>{{ S_LIST_OPTIONS }}
+					</select>
+				</div>
+			</fieldset>
+		</div>
+	</div>
+{{ S_FORM_TOKEN }}
+</form>
+
+{% if S_SHOWLIST %}
+<div class="panel bg1">
+	<div class="inner">
+	{% EVENT dmzx_topic_index_topic_filter_container_before %}
+		<p class="filtrino icenter">
+			{% for block_nofiltrino in loops.block_nofiltrino %}
+				<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_TUTTI }}">{{ lang('ALL') }}</a></span>
+				{% if block_nofiltrino.S_09 %}<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_09 }}">{{ lang('09') }}</a></span>{% else %}<span  class="btn-basic btn-xs">{{ lang('09') }}</span>{% endif %}
+				{% if block_nofiltrino.S_SYMB %}<span class="btn btn-default btn-xs"><a href="{{ block_nofiltrino.U_SYMB }}">{{ lang('SYMB') }}</a></span>{% else %}<span  class="btn-basic btn-xs">{{ lang('SYMB') }}</span>{% endif %}
+			{% endfor %}
+			{% for block_filtrino in loops.block_filtrino %}
+				{% EVENT dmzx_topic_index_topic_filter_before %}
+				{% if block_filtrino.S_ISWITH %}
+					<span class="btn btn-default btn-xs"><a href="{{ block_filtrino.U_FILTER }}">{{ block_filtrino.FILTRINO }}</a></span>
+				{% else %}
+					<span class="btn-basic btn-xs">{{ block_filtrino.FILTRINO }}</span>
+				{% endif %}
+				{% EVENT dmzx_topic_index_topic_filter_after %}
+			{% endfor %}
+		</p>
+		{% EVENT dmzx_topic_index_topic_filter_container_after %}
+	</div>
+</div>
+<div class="filtrino icenter">
+	<a href="{ROOT_PATH}viewforum.php?f=124" role="button" title="{L_BUTTON_UPLOAD_EXPLAIN}"class="btn btn-default btn-load" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-plus"></i>&nbsp;{L_BUTTON_UPLOAD}</a>
+</div>
+{% if loops.block_list|length %}
+{% for block_list in loops.block_list %}
+{% if block_list.S_ISWITH2 %}
+<br/><br/>
+<h3>{{ block_list.FILTRINO }}</h3>
+
+	<table class="table table-bordered">
+		<thead> 
+			<tr> 
+				<th class="list-inner">{{ lang('TITLE') }}</th>
+				<th class="topics">{{ lang('AUTHOR') }}</th>
+				<th class="posts">{{ lang('COMMENTS') }}</th>
+				{% if U_ACP %}<th class="lastpost"><span>{{ lang('REMOVE_FROM_LIST') }}</span></th>{% endif %}
+			</tr>
+		</thead>
+		{% for block_topic_index in block_list.block_topic_index %}
+		<tbody>
+			<tr>
+				<td class="topicindex">{% EVENT dmzx_topic_index_topic_before %}<a href="{{ block_topic_index.ITOPIC_URL }}">{% EVENT dmzx_topic_index_topic_title_container_before %}<strong>{% EVENT dmzx_topic_index_topic_title_before %} {{ block_topic_index.ITOPIC_TITLE }}</strong>{% EVENT dmzx_topic_index_topic_title_after %}</a>{% EVENT dmzx_topic_index_topic_title_container_after %}</td>
+				<td class="topics">{{ block_topic_index.ITOPIC_POSTER }}</td>
+				<td class="posts">{{ block_topic_index.ITOPIC_TOTREP }}</td>
+				{% if U_ACP %}<td class="lastpost"><span class="topicindexremove"><a href="{{ block_topic_index.U_REMOVE_FROM }}" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true" title="{{ lang('REMOVE_FROM_LIST') }}"></i></a></span></td>{% endif %}
+			</tr>
+		</tbody>
+		{% endfor %}
+	</table>
+{% endif %}
+{% endfor %}
+{% else %}
+<fieldset>
+	<p class="ianytopuc">{{ lang('ANY_TOPIC_IN_LIST') }}</p>
+</fieldset>
+{% endif %}
+
+{% endif %}
+</fieldset>
+{% INCLUDE 'overall_footer.html' %}
\ No newline at end of file
diff --git "[ORIGINAL]/dmzx\\topicindex/styles/all/theme/images/icon_post_inilist.gif" "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_post_inilist.gif"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/images/icon_post_inilist.gif"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_post_inilist.gif"
diff --git "[ORIGINAL]/dmzx\\topicindex/styles/all/theme/images/icon_post_iremovelist.gif" "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_post_iremovelist.gif"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/images/icon_post_iremovelist.gif"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_post_iremovelist.gif"
diff --git "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_topiclist.gif" "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_topiclist.gif"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/images/icon_topiclist.gif" differ
diff --git "[ORIGINAL]/dmzx\\topicindex/styles/all/theme/topicindex.css" "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.bak.css"
similarity index 99%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/topicindex.css"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.bak.css"
--- "[ORIGINAL]/dmzx\\topicindex/styles/all/theme/topicindex.css"
+++ "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.bak.css"
@@ -48,7 +48,7 @@
 }
 
 .topicindex {
-	font-size: 1.2em;
+	font-size: 1.0em;
 	line-height: 2.2em;
 	padding: 4px 0;
 }
diff --git "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.css" "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex.css"
@@ -0,0 +1 @@
+#content_index{overflow:hidden!important}.content ul,.content ol{margin:0!important}.icenter{text-align:center}.itopic_num{text-align:center;width:30px}.itopic_titles{text-align:left!important;float:left}.itopic_rep{text-align:center;width:80px}.itopic_poster{text-align:center;width:250px}.index_table{margin:0;padding:0}.tlisthead{color:#000!important}.topicindex{font-size:1em;line-height:2.2em;padding:4px 0}.topicindexremove{margin-top:5px;font-size:1.2em}.filtrino{text-align:center;margin:5px;text-transform:uppercase;font-size:12px!important;font-weight:700}.i_abcdz{margin:0 0 0 2px;padding:0 4px;background:#CADCEB}.i_abcdz:hover{margin:0 0 0 2px;padding:0 4px;background:#9badb9;text-decoration:none!important}.i_nourl{margin:0 0 0 2px;padding:0 4px;background:#FFF!important;text-transform:uppercase;color:#c2c2c2!important}.i_all{margin:0 0 0 2px;padding:0 4px;background:#CADCEB}.i_all:hover{margin:0 0 0 2px;padding:0 4px;background:#9badb9;text-decoration:none!important}.ianytopuc{text-align:center;font-size:14px}@media (max-width: 850px){li.header dt{text-align:center;text-transform:none;line-height:1em;font-size:1.2em;padding-bottom:4px}ul.topiclist li.header dt,ul.topiclist li.header dt .list-inner{margin-right:0!important;padding-right:0}ul.topiclist dt,ul.topiclist dt .list-inner{margin-right:0}ul.topiclist dd{display:none}}
\ No newline at end of file
diff --git "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex_icon.css" "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex_icon.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\topicindex/styles/FLATBOOTS/theme/topicindex_icon.css"
@@ -0,0 +1 @@
+.icon-topiclist{background-image:url(./images/icon_topiclist.gif)}
\ No newline at end of file
diff --git "[ORIGINAL]/dmzx\\topicindex/styles/all/template/official_topic_index.html" "[ORIGINAL]/dmzx\\topicindex/styles/all/template/official_topic_index.html"
deleted file mode 100644
--- "[ORIGINAL]/dmzx\\topicindex/styles/all/template/official_topic_index.html"
+++ /dev/null
@@ -1,62 +0,0 @@
-<div id="{{ S_ISTYLE }}">
-	<strong>{{ lang('INDEX_POST_PRES') }}</strong>
-	<fieldset>
-		<p class="filtrino icenter">
-			{% for block_nofiltrino in loops.block_nofiltrino %}
-				<span><a href="{{ block_nofiltrino.U_TUTTI }}" class="i_all">{{ lang('ALL') }}</a></span>
-				{% if block_nofiltrino.S_09 %}<span><a href="{{ block_nofiltrino.U_09 }}" class="i_all">{{ lang('09') }}</a></span>{% else %}<span class="i_nourl">{{ lang('09') }}</span>{% endif %}
-				{% if block_nofiltrino.S_SYMB %}<span><a href="{{ block_nofiltrino.U_SYMB }}" class="i_all">{{ lang('SYMB') }}</a></span>{% else %}<span class="i_nourl">{{ lang('SYMB') }}</span>{% endif %}
-			{% endfor %}
-			{% for block_filtrino in loops.block_filtrino %}
-				{% if block_filtrino.S_ISWITH %}
-					<span><a href="{{ block_filtrino.U_FILTER }}" class="i_abcdz">{{ block_filtrino.FILTRINO }}</a></span>
-				{% else %}
-					<span class="i_nourl">{{ block_filtrino.FILTRINO }}</span>
-				{% endif %}
-			{% endfor %}
-		</p>
-	</fieldset>
-	{% if loops.block_list|length %}
-	{% for block_list in loops.block_list %}
-	{% if block_list.S_ISWITH2 %}
-	<h3>{{ block_list.FILTRINO }}</h3>
-	<div class="panel bg3">
-		<div class="inner">
-			<ul class="topiclist">
-				<li class="header">
-					<dl class="row-item">
-						<dt>
-							<div class="list-inner" style="color:#000000;">{{ lang('TOPIC_TITLE') }}</div>
-						</dt>
-						<dd class="topics" style="color:#000000;">{{ lang('POSTER') }}</dd>
-						<dd class="posts" style="color:#000000;">{{ lang('REPLIES') }}</dd>
-						{% if U_MCP %}<dd class="lastpost" style="color:#000000;"><span>{{ lang('REMOVE_FROM_LIST') }}</span></dd>{% endif %}
-					</dl>
-				</li>
-			</ul>
-			<ul class="topiclist forums">
-			{% for block_topic_index in block_list.block_topic_index %}
-				<li class="row {% if block_topic_index.S_ROW_COUNT is even %}bg1{% else %}bg2{% endif %}">
-					<dl>
-						<dt class="topicindex">
-							<div class="list-inner">
-								<a href="{{ block_topic_index.ITOPIC_URL }}"><strong>{{ block_topic_index.ITOPIC_TITLE }}</strong></a>
-							</div>
-						</dt>
-						<dd class="topics">{{ block_topic_index.ITOPIC_POSTER }}</dd>
-						<dd class="posts">{{ block_topic_index.ITOPIC_TOTREP }}</dd>
-						{% if U_MCP %}<dd class="lastpost"><span class="topicindexremove">[<a href="{{ block_topic_index.U_REMOVE_FROM }}">{{ lang('REMOVE_FROM_LIST') }}</a>]</span></dd>{% endif %}
-					</dl>
-				</li>
-			{% endfor %}
-			</ul>
-		</div>
-	</div>
-	{% endif %}
-	{% endfor %}
-	{% else %}
-	<fieldset>
-		<p class="ianytopuc">{{ lang('ANY_TOPIC_IN_LIST') }}</p>
-	</fieldset>
-	{% endif %}
-</div>
diff --git "[ORIGINAL]/dmzx\\topicindex/styles/all/template/topiclist.html" "[ORIGINAL]/dmzx\\topicindex/styles/all/template/topiclist.html"
deleted file mode 100644
--- "[ORIGINAL]/dmzx\\topicindex/styles/all/template/topiclist.html"
+++ /dev/null
@@ -1,80 +0,0 @@
-{% INCLUDE 'overall_header.html' %}
-
-<h2>{{ lang('OIINDEX_HEADER') }}</h2>
-
-<form action="{{ U_ACTION }}" method="post">
-	<div class="panel bg3">
-		<div class="inner">
-			<fieldset>
-				<p>{{ lang('SELECT_A_LIST') }}{{ lang('COLON') }} <select id="listslc" name="list" onchange="this.form.submit();"><option value="0" selected="selected">-------</option>{{ S_LIST_OPTIONS }}</select></p>
-			</fieldset>
-		</div>
-	</div>
-{{ S_FORM_TOKEN }}
-</form>
-
-{% if S_SHOWLIST %}
-<div class="panel bg1">
-	<div class="inner">
-		<p class="filtrino icenter">
-			{% for block_nofiltrino in loops.block_nofiltrino %}
-				<span><a href="{{ block_nofiltrino.U_TUTTI }}" class="i_all">{{ lang('ALL') }}</a></span>
-				{% if block_nofiltrino.S_09 %}<span><a href="{{ block_nofiltrino.U_09 }}" class="i_all">{{ lang('09') }}</a></span>{% else %}<span class="i_nourl">{{ lang('09') }}</span>{% endif %}
-				{% if block_nofiltrino.S_SYMB %}<span><a href="{{ block_nofiltrino.U_SYMB }}" class="i_all">{{ lang('SYMB') }}</a></span>{% else %}<span class="i_nourl">{{ lang('SYMB') }}</span>{% endif %}
-			{% endfor %}
-			{% for block_filtrino in loops.block_filtrino %}
-				{% if block_filtrino.S_ISWITH %}
-					<span><a href="{{ block_filtrino.U_FILTER }}" class="i_abcdz">{{ block_filtrino.FILTRINO }}</a></span>
-				{% else %}
-					<span class="i_nourl">{{ block_filtrino.FILTRINO }}</span>
-				{% endif %}
-			{% endfor %}
-		</p>
-	</div>
-</div>
-{% if loops.block_list|length %}
-{% for block_list in loops.block_list %}
-{% if block_list.S_ISWITH2 %}
-<h3>{{ block_list.FILTRINO }}</h3>
-<div class="forabg">
-	<div class="inner">
-		<ul class="topiclist">
-			<li class="header">
-				<dl class="row-item">
-					<dt>
-						<div class="list-inner">{{ lang('TOPIC_TITLE') }}</div>
-					</dt>
-					<dd class="topics">{{ lang('POSTER') }}</dd>
-					<dd class="posts">{{ lang('REPLIES') }}</dd>
-					{% if U_MCP %}<dd class="lastpost"><span>{{ lang('REMOVE_FROM_LIST') }}</span></dd>{% endif %}
-				</dl>
-			</li>
-		</ul>
-		<ul class="topiclist forums">
-		{% for block_topic_index in block_list.block_topic_index %}
-			<li class="row {% if block_topic_index.S_ROW_COUNT is even %}bg1{% else %}bg2{% endif %}">
-				<dl>
-					<dt class="topicindex">
-						<div class="list-inner">
-							<a href="{{ block_topic_index.ITOPIC_URL }}"><strong>{{ block_topic_index.ITOPIC_TITLE }}</strong></a>
-						</div>
-					</dt>
-					<dd class="topics">{{ block_topic_index.ITOPIC_POSTER }}</dd>
-					<dd class="posts">{{ block_topic_index.ITOPIC_TOTREP }}</dd>
-					{% if U_MCP %}<dd class="lastpost"><span class="topicindexremove">[<a href="{{ block_topic_index.U_REMOVE_FROM }}">{{ lang('REMOVE_FROM_LIST') }}</a>]</span></dd>{% endif %}
-				</dl>
-			</li>
-		{% endfor %}
-		</ul>
-	</div>
-</div>
-{% endif %}
-{% endfor %}
-{% else %}
-<fieldset>
-	<p class="ianytopuc">{{ lang('ANY_TOPIC_IN_LIST') }}</p>
-</fieldset>
-{% endif %}
-{% endif %}
-
-{% INCLUDE 'overall_footer.html' %}
\ No newline at end of file
diff --git "[ORIGINAL]/dmzx\\topicindex/styles/all/theme/images/Thumbs.db" "[ORIGINAL]/dmzx\\topicindex/styles/all/theme/images/Thumbs.db"
deleted file mode 100644
Binary files "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\topicindex/styles/all/theme/images/Thumbs.db" and /dev/null differ
```
