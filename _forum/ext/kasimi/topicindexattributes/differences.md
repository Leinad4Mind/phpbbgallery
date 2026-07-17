Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/kasimi\\topicindexattributes/config/services.yml" "[FORUM_EXT]/kasimi\\topicindexattributes/config/services.yml"
--- "[ORIGINAL]/kasimi\\topicindexattributes/config/services.yml"
+++ "[FORUM_EXT]/kasimi\\topicindexattributes/config/services.yml"
@@ -2,6 +2,6 @@ services:
     kasimi.topicindexattributes.listener:
         class: kasimi\topicindexattributes\event\main_listener
         arguments:
-            - '@?ernadoo.qte'
+            - '@text_formatter.renderer'
         tags:
             - { name: event.listener }
diff --git "[FORUM_EXT]/kasimi\\topicindexattributes/diff_full.tmp" "[FORUM_EXT]/kasimi\\topicindexattributes/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\topicindexattributes/diff_full.tmp"
@@ -0,0 +1,167 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/config/services.yml"
+index 41380bc6f..d9b6172bf 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/config/services.yml"
+@@ -2,6 +2,6 @@ services:
+     kasimi.topicindexattributes.listener:
+         class: kasimi\topicindexattributes\event\main_listener
+         arguments:
+-            - '@?ernadoo.qte'
++            - '@text_formatter.renderer'
+         tags:
+             - { name: event.listener }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/event/main_listener.php"
+index 8d40319c9..565fded40 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/event/main_listener.php"
+@@ -2,7 +2,7 @@
+ 
+ /**
+  *
+- * Recent Topics - Attributes. An extension for the phpBB Forum Software package.
++ * Topic Index - Attributes. An extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018 kasimi - https://kasimi.net
+  * @license GNU General Public License, version 2 (GPL-2.0)
+@@ -11,25 +11,29 @@
+ 
+ namespace kasimi\topicindexattributes\event;
+ 
+-use ernadoo\qte\qte;
++use phpbb\textformatter\s9e\renderer;
+ use phpbb\event\data;
+ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+ 
+ class main_listener implements EventSubscriberInterface
+ {
+-	/** @var qte */
+-	protected $qte;
++	/** @var renderer */
++	protected $renderer;
+ 
+ 	/**
+-	 * @param qte $qte
++	 * @param renderer	$renderer
+ 	 */
+ 	public function __construct(
+-		qte $qte = null
++		renderer $renderer
+ 	)
+ 	{
+-		$this->qte = $qte;
+-	}
++		global $phpbb_container;
+ 
++		$this->renderer = $renderer;
++		$this->container = $phpbb_container;
++		$this->manager = $this->container->get('bbprefix.manager');
++	}
++	
+ 	/**
+ 	 * @return array
+ 	 */
+@@ -41,18 +45,36 @@ class main_listener implements EventSubscriberInterface
+ 			'dmzx.topicindex.modify_block_topic_index_ary'	=> 'topicindex_modify_block_topic_index_ary',
+ 		];
+ 	}
++	
++	
+ 
+ 	/**
+ 	 * @param data $event
+ 	 */
+ 	public function topicindex_sql_fetch_topics_before(data $event)
+ 	{
+-		if ($this->qte)
+-		{
+-			$sql_array = $event['sql_array'];
+-			$sql_array['SELECT'] .= ', topic_attr_id, topic_attr_user, topic_attr_time';
+-			$event['sql_array'] = $sql_array;
++		$sql_array = $event['sql_array'];
++
++		// Ensure FROM clause contains all tables in comma-separated format
++		$sql_array['FROM'] += [BBPREFIX_INSTANCES_TABLE => 'pri', BBPREFIX_TABLE => 'pr'];
++
++		// Combine join conditions into WHERE clause
++		if (empty($sql_array['WHERE'])) {
++			$sql_array['WHERE'] = 'pri.topic = t.topic_id AND pr.id = pri.prefix';
++		} else {
++			$sql_array['WHERE'] .= ' AND pri.topic = t.topic_id AND pr.id = pri.prefix';
+ 		}
++
++		// Ensure GROUP BY is set correctly
++		$sql_array['GROUP_BY'] = 't.topic_id';
++
++		// Add additional SELECT fields and GROUP_CONCAT
++		$sql_array['SELECT'] .= ', pr.id, GROUP_CONCAT(pr.prefix) as prefix';
++
++		// Set ORDER BY clause
++		$sql_array['ORDER_BY'] = 't.topic_title ASC';
++
++		$event['sql_array'] = $sql_array;
+ 	}
+ 
+ 	/**
+@@ -60,14 +82,9 @@ class main_listener implements EventSubscriberInterface
+ 	 */
+ 	public function topicindex_sql_fetch_topics_after(data $event)
+ 	{
+-		if ($this->qte)
+-		{
+-			$array = $event['array'];
+-			$array['topic_attr_id'] = $event['row']['topic_attr_id'];
+-			$array['topic_attr_user'] = $event['row']['topic_attr_user'];
+-			$array['topic_attr_time'] = $event['row']['topic_attr_time'];
+-			$event['array'] = $array;
+-		}
++		$event['array'] = array_merge($event['array'], [
++			'prefix'		=> $event['row']['prefix'],
++		]);
+ 	}
+ 
+ 	/**
+@@ -75,11 +92,18 @@ class main_listener implements EventSubscriberInterface
+ 	 */
+ 	public function topicindex_modify_block_topic_index_ary(data $event)
+ 	{
+-		if ($this->qte)
+-		{
+-			$template_vars = $event['template_vars'];
+-			$template_vars['TOPIC_ATTRIBUTE'] = $this->qte->attr_display($event['indexdata']['topic_attr_id'], $event['indexdata']['topic_attr_user'], $event['indexdata']['topic_attr_time']);
+-			$event['template_vars'] = $template_vars;
++		$bbemoji_listener = $this->container->get('sitesplat.bbemoji.listener');
++		$topic_title = $bbemoji_listener->render($bbemoji_listener->parse($event['template_vars']['ITOPIC_TITLE']));
++		$result = '';
++		if(!empty($event['indexdata']['prefix'])) {
++			$result = preg_replace('/[ ,]+/', ' ', $this->renderer->render($event['indexdata']['prefix']));
+ 		}
++		
++		$event['template_vars'] = array_merge($event['template_vars'], [
++			'TOPIC_PREFIX'		=> $result
++		]);
++
++		$event->update_subarray('template_vars', 'ITOPIC_TITLE', $topic_title);
+ 	}
++
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_before.html"
+deleted file mode 100644
+index 3fb56caa0..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_before.html"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-{% if block_topic_index.TOPIC_ATTRIBUTE %}
+-	<br>{{ block_topic_index.TOPIC_ATTRIBUTE }}
+-{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html"
+new file mode 100644
+index 000000000..0327a71b1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html"
+@@ -0,0 +1,3 @@
++{% if block_topic_index.TOPIC_PREFIX %}
++	{{ block_topic_index.TOPIC_PREFIX }}
++{% endif %}
diff --git "[FORUM_EXT]/kasimi\\topicindexattributes/diff_nospace.tmp" "[FORUM_EXT]/kasimi\\topicindexattributes/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\topicindexattributes/diff_nospace.tmp"
@@ -0,0 +1,181 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/config/services.yml"
+index 41380bc6f..d9b6172bf 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/config/services.yml"
+@@ -2,6 +2,6 @@ services:
+     kasimi.topicindexattributes.listener:
+         class: kasimi\topicindexattributes\event\main_listener
+         arguments:
+-            - '@?ernadoo.qte'
++            - '@text_formatter.renderer'
+         tags:
+             - { name: event.listener }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/diff_full.tmp"
+new file mode 100644
+index 000000000..7a8d2738c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/diff_full.tmp"
+@@ -0,0 +1,167 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/config/services.yml"
++index 41380bc6f..d9b6172bf 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/config/services.yml"
++@@ -2,6 +2,6 @@ services:
++     kasimi.topicindexattributes.listener:
++         class: kasimi\topicindexattributes\event\main_listener
++         arguments:
++-            - '@?ernadoo.qte'
+++            - '@text_formatter.renderer'
++         tags:
++             - { name: event.listener }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/event/main_listener.php"
++index 8d40319c9..565fded40 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/event/main_listener.php"
++@@ -2,7 +2,7 @@
++ 
++ /**
++  *
++- * Recent Topics - Attributes. An extension for the phpBB Forum Software package.
+++ * Topic Index - Attributes. An extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018 kasimi - https://kasimi.net
++  * @license GNU General Public License, version 2 (GPL-2.0)
++@@ -11,25 +11,29 @@
++ 
++ namespace kasimi\topicindexattributes\event;
++ 
++-use ernadoo\qte\qte;
+++use phpbb\textformatter\s9e\renderer;
++ use phpbb\event\data;
++ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
++ 
++ class main_listener implements EventSubscriberInterface
++ {
++-	/** @var qte */
++-	protected $qte;
+++	/** @var renderer */
+++	protected $renderer;
++ 
++ 	/**
++-	 * @param qte $qte
+++	 * @param renderer	$renderer
++ 	 */
++ 	public function __construct(
++-		qte $qte = null
+++		renderer $renderer
++ 	)
++ 	{
++-		$this->qte = $qte;
++-	}
+++		global $phpbb_container;
++ 
+++		$this->renderer = $renderer;
+++		$this->container = $phpbb_container;
+++		$this->manager = $this->container->get('bbprefix.manager');
+++	}
+++	
++ 	/**
++ 	 * @return array
++ 	 */
++@@ -41,18 +45,36 @@ class main_listener implements EventSubscriberInterface
++ 			'dmzx.topicindex.modify_block_topic_index_ary'	=> 'topicindex_modify_block_topic_index_ary',
++ 		];
++ 	}
+++	
+++	
++ 
++ 	/**
++ 	 * @param data $event
++ 	 */
++ 	public function topicindex_sql_fetch_topics_before(data $event)
++ 	{
++-		if ($this->qte)
++-		{
++-			$sql_array = $event['sql_array'];
++-			$sql_array['SELECT'] .= ', topic_attr_id, topic_attr_user, topic_attr_time';
++-			$event['sql_array'] = $sql_array;
+++		$sql_array = $event['sql_array'];
+++
+++		// Ensure FROM clause contains all tables in comma-separated format
+++		$sql_array['FROM'] += [BBPREFIX_INSTANCES_TABLE => 'pri', BBPREFIX_TABLE => 'pr'];
+++
+++		// Combine join conditions into WHERE clause
+++		if (empty($sql_array['WHERE'])) {
+++			$sql_array['WHERE'] = 'pri.topic = t.topic_id AND pr.id = pri.prefix';
+++		} else {
+++			$sql_array['WHERE'] .= ' AND pri.topic = t.topic_id AND pr.id = pri.prefix';
++ 		}
+++
+++		// Ensure GROUP BY is set correctly
+++		$sql_array['GROUP_BY'] = 't.topic_id';
+++
+++		// Add additional SELECT fields and GROUP_CONCAT
+++		$sql_array['SELECT'] .= ', pr.id, GROUP_CONCAT(pr.prefix) as prefix';
+++
+++		// Set ORDER BY clause
+++		$sql_array['ORDER_BY'] = 't.topic_title ASC';
+++
+++		$event['sql_array'] = $sql_array;
++ 	}
++ 
++ 	/**
++@@ -60,14 +82,9 @@ class main_listener implements EventSubscriberInterface
++ 	 */
++ 	public function topicindex_sql_fetch_topics_after(data $event)
++ 	{
++-		if ($this->qte)
++-		{
++-			$array = $event['array'];
++-			$array['topic_attr_id'] = $event['row']['topic_attr_id'];
++-			$array['topic_attr_user'] = $event['row']['topic_attr_user'];
++-			$array['topic_attr_time'] = $event['row']['topic_attr_time'];
++-			$event['array'] = $array;
++-		}
+++		$event['array'] = array_merge($event['array'], [
+++			'prefix'		=> $event['row']['prefix'],
+++		]);
++ 	}
++ 
++ 	/**
++@@ -75,11 +92,18 @@ class main_listener implements EventSubscriberInterface
++ 	 */
++ 	public function topicindex_modify_block_topic_index_ary(data $event)
++ 	{
++-		if ($this->qte)
++-		{
++-			$template_vars = $event['template_vars'];
++-			$template_vars['TOPIC_ATTRIBUTE'] = $this->qte->attr_display($event['indexdata']['topic_attr_id'], $event['indexdata']['topic_attr_user'], $event['indexdata']['topic_attr_time']);
++-			$event['template_vars'] = $template_vars;
+++		$bbemoji_listener = $this->container->get('sitesplat.bbemoji.listener');
+++		$topic_title = $bbemoji_listener->render($bbemoji_listener->parse($event['template_vars']['ITOPIC_TITLE']));
+++		$result = '';
+++		if(!empty($event['indexdata']['prefix'])) {
+++			$result = preg_replace('/[ ,]+/', ' ', $this->renderer->render($event['indexdata']['prefix']));
++ 		}
+++		
+++		$event['template_vars'] = array_merge($event['template_vars'], [
+++			'TOPIC_PREFIX'		=> $result
+++		]);
+++
+++		$event->update_subarray('template_vars', 'ITOPIC_TITLE', $topic_title);
++ 	}
+++
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_before.html"
++deleted file mode 100644
++index 3fb56caa0..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_before.html"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-{% if block_topic_index.TOPIC_ATTRIBUTE %}
++-	<br>{{ block_topic_index.TOPIC_ATTRIBUTE }}
++-{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html"
++new file mode 100644
++index 000000000..0327a71b1
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_
\ No newline at end of file
diff --git "[ORIGINAL]/kasimi\\topicindexattributes/event/main_listener.php" "[FORUM_EXT]/kasimi\\topicindexattributes/event/main_listener.php"
--- "[ORIGINAL]/kasimi\\topicindexattributes/event/main_listener.php"
+++ "[FORUM_EXT]/kasimi\\topicindexattributes/event/main_listener.php"
@@ -2,7 +2,7 @@
 
 /**
  *
- * Recent Topics - Attributes. An extension for the phpBB Forum Software package.
+ * Topic Index - Attributes. An extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018 kasimi - https://kasimi.net
  * @license GNU General Public License, version 2 (GPL-2.0)
@@ -11,23 +11,27 @@
 
 namespace kasimi\topicindexattributes\event;
 
-use ernadoo\qte\qte;
+use phpbb\textformatter\s9e\renderer;
 use phpbb\event\data;
 use Symfony\Component\EventDispatcher\EventSubscriberInterface;
 
 class main_listener implements EventSubscriberInterface
 {
-	/** @var qte */
-	protected $qte;
+	/** @var renderer */
+	protected $renderer;
 
 	/**
-	 * @param qte $qte
+	 * @param renderer	$renderer
 	 */
 	public function __construct(
-		qte $qte = null
+		renderer $renderer
 	)
 	{
-		$this->qte = $qte;
+		global $phpbb_container;
+
+		$this->renderer = $renderer;
+		$this->container = $phpbb_container;
+		$this->manager = $this->container->get('bbprefix.manager');
 	}
 	
 	/**
@@ -42,17 +46,35 @@ class main_listener implements EventSubscriberInterface
 		];
 	}
 	
+	
+
 	/**
 	 * @param data $event
 	 */
 	public function topicindex_sql_fetch_topics_before(data $event)
-	{
-		if ($this->qte)
 	{
 		$sql_array = $event['sql_array'];
-			$sql_array['SELECT'] .= ', topic_attr_id, topic_attr_user, topic_attr_time';
-			$event['sql_array'] = $sql_array;
+
+		// Ensure FROM clause contains all tables in comma-separated format
+		$sql_array['FROM'] += [BBPREFIX_INSTANCES_TABLE => 'pri', BBPREFIX_TABLE => 'pr'];
+
+		// Combine join conditions into WHERE clause
+		if (empty($sql_array['WHERE'])) {
+			$sql_array['WHERE'] = 'pri.topic = t.topic_id AND pr.id = pri.prefix';
+		} else {
+			$sql_array['WHERE'] .= ' AND pri.topic = t.topic_id AND pr.id = pri.prefix';
 		}
+
+		// Ensure GROUP BY is set correctly
+		$sql_array['GROUP_BY'] = 't.topic_id';
+
+		// Add additional SELECT fields and GROUP_CONCAT
+		$sql_array['SELECT'] .= ', pr.id, GROUP_CONCAT(pr.prefix) as prefix';
+
+		// Set ORDER BY clause
+		$sql_array['ORDER_BY'] = 't.topic_title ASC';
+
+		$event['sql_array'] = $sql_array;
 	}
 
 	/**
@@ -60,14 +82,9 @@ class main_listener implements EventSubscriberInterface
 	 */
 	public function topicindex_sql_fetch_topics_after(data $event)
 	{
-		if ($this->qte)
-		{
-			$array = $event['array'];
-			$array['topic_attr_id'] = $event['row']['topic_attr_id'];
-			$array['topic_attr_user'] = $event['row']['topic_attr_user'];
-			$array['topic_attr_time'] = $event['row']['topic_attr_time'];
-			$event['array'] = $array;
-		}
+		$event['array'] = array_merge($event['array'], [
+			'prefix'		=> $event['row']['prefix'],
+		]);
 	}
 
 	/**
@@ -75,11 +92,18 @@ class main_listener implements EventSubscriberInterface
 	 */
 	public function topicindex_modify_block_topic_index_ary(data $event)
 	{
-		if ($this->qte)
-		{
-			$template_vars = $event['template_vars'];
-			$template_vars['TOPIC_ATTRIBUTE'] = $this->qte->attr_display($event['indexdata']['topic_attr_id'], $event['indexdata']['topic_attr_user'], $event['indexdata']['topic_attr_time']);
-			$event['template_vars'] = $template_vars;
+		$bbemoji_listener = $this->container->get('sitesplat.bbemoji.listener');
+		$topic_title = $bbemoji_listener->render($bbemoji_listener->parse($event['template_vars']['ITOPIC_TITLE']));
+		$result = '';
+		if(!empty($event['indexdata']['prefix'])) {
+			$result = preg_replace('/[ ,]+/', ' ', $this->renderer->render($event['indexdata']['prefix']));
 		}
+		
+		$event['template_vars'] = array_merge($event['template_vars'], [
+			'TOPIC_PREFIX'		=> $result
+		]);
+
+		$event->update_subarray('template_vars', 'ITOPIC_TITLE', $topic_title);
 	}
+
 }
diff --git "[ORIGINAL]/kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_before.html" "[ORIGINAL]/kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_before.html"
deleted file mode 100644
--- "[ORIGINAL]/kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_before.html"
+++ /dev/null
@@ -1,3 +0,0 @@
-{% if block_topic_index.TOPIC_ATTRIBUTE %}
-	<br>{{ block_topic_index.TOPIC_ATTRIBUTE }}
-{% endif %}
diff --git "[FORUM_EXT]/kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html" "[FORUM_EXT]/kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\topicindexattributes/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html"
@@ -0,0 +1,3 @@
+{% if block_topic_index.TOPIC_PREFIX %}
+	{{ block_topic_index.TOPIC_PREFIX }}
+{% endif %}
```
