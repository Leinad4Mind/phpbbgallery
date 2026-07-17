Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\bbbreadcrumbs/composer.json" "[FORUM_EXT]/sitesplat\\bbbreadcrumbs/composer.json"
--- "[ORIGINAL]/sitesplat\\bbbreadcrumbs/composer.json"
+++ "[FORUM_EXT]/sitesplat\\bbbreadcrumbs/composer.json"
@@ -23,8 +23,9 @@
         },
 		"version-check": {
             "host": "sitesplat.com",
-            "directory": "/updatecheck/phpbb31/ext",
-            "filename": "breadcrumbs.json"
+            "directory": "/updatecheck/phpbb32/ext",
+            "filename": "breadcrumbs.json",
+			"ssl": true
 		}
     }
 }
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\bbbreadcrumbs/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bbbreadcrumbs/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbbreadcrumbs/diff_full.tmp"
@@ -0,0 +1,120 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbbreadcrumbs/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/composer.json"
+index 6c35e452a..3d2d2f210 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbbreadcrumbs/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/composer.json"
+@@ -23,8 +23,9 @@
+         },
+ 		"version-check": {
+             "host": "sitesplat.com",
+-            "directory": "/updatecheck/phpbb31/ext",
+-            "filename": "breadcrumbs.json"
++            "directory": "/updatecheck/phpbb32/ext",
++            "filename": "breadcrumbs.json",
++			"ssl": true
+ 		}
+     }
+ }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbbreadcrumbs/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/event/main_listener.php"
+index 1d6b181f1..a28456e2f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbbreadcrumbs/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/event/main_listener.php"
+@@ -56,7 +56,7 @@ class main_listener implements EventSubscriberInterface
+ 
+ 	public function add_breadcrumbs_to_module($event)
+ 	{
+-		// here we store breadrumbs in proper order
++		// here we store breadcrumbs in proper order
+ 		$breadcrumbs_data = array();
+ 		// list of all modules
+ 		$modules = $event['module']->module_ary;
+@@ -65,31 +65,31 @@ class main_listener implements EventSubscriberInterface
+ 
+ 		// standardize module ID
+ 		$id = $event['module']->p_id;
+-		if (!$id)
+-		{
+-			if (strcmp((int) $event['id'], $event['id'])) // module ID is string (ie. ucp_pm, mcp_queue, ...)
+-			{
+-				// hacks
+-				if ($event['id'] == 'pm')
+-				{
+-					$event['id'] = 'ucp_pm';
+-				}
+-
+-				// find proper module
+-				foreach ($modules as $module)
+-				{
+-					if ($module['name'] == $event['id'] && $module['mode'] == $event['mode'])
+-					{
+-						$id = $module['id'];
+-						break;
+-					}
+-				}
+-			}
+-			else
+-			{
+-				$id = $event['id'];
+-			}
+-		}
++		// if (!$id)
++		// {
++		// 	if (strcmp((int) $event['id'], $event['id'])) // module ID is string (ie. ucp_pm, mcp_queue, ...)
++		// 	{
++		// 		// hacks
++		// 		if ($event['id'] == 'pm')
++		// 		{
++		// 			$event['id'] = 'ucp_pm';
++		// 		}
++
++		// 		// find proper module
++		// 		foreach ($modules as $module)
++		// 		{
++		// 			if ($module['name'] == $event['id'] && $module['mode'] == $event['mode'] && $event['id'] != 'ucp_main')
++		// 			{
++		// 				$id = $module['id'];
++		// 				break;
++		// 			}
++		// 		}
++		// 	}
++		// 	else
++		// 	{
++		// 		$id = $event['id'];
++		// 	}
++		// }
+ 
+ 		while($id)
+ 		{
+@@ -103,10 +103,10 @@ class main_listener implements EventSubscriberInterface
+ 			$id = $module['parent'];
+ 		}
+ 
+-		$this->add_breadcrumb(
+-			$module_class == 'ucp' ? $this->user->lang('PROFILE') : $this->user->lang('MCP'),
+-			append_sid("{$this->root_path}{$module_class}.{$this->php_ext}")
+-		);
++		// $this->add_breadcrumb(
++		// 	$module_class == 'ucp' ? $this->user->lang('PROFILE') : $this->user->lang('MCP'),
++		// 	append_sid("{$this->root_path}{$module_class}.{$this->php_ext}")
++		// );
+ 
+ 		foreach ($breadcrumbs_data as $breadcrumb)
+ 		{
+@@ -155,10 +155,10 @@ class main_listener implements EventSubscriberInterface
+ 
+ 	public function add_breadcrumbs_to_search()
+ 	{
+-		$this->add_breadcrumb(
+-			$this->user->lang('SEARCH'),
+-			append_sid("{$this->root_path}search.{$this->php_ext}")
+-		);
++		// $this->add_breadcrumb(
++		// 	$this->user->lang('SEARCH'),
++		// 	append_sid("{$this->root_path}search.{$this->php_ext}")
++		// );
+ 	}
+ 
+ 	public function add_breadcrumbs_to_viewonline()
diff --git "[FORUM_EXT]/sitesplat\\bbbreadcrumbs/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bbbreadcrumbs/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbbreadcrumbs/diff_nospace.tmp"
@@ -0,0 +1,90 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbbreadcrumbs/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/composer.json"
+index 6c35e452a..3d2d2f210 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbbreadcrumbs/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/composer.json"
+@@ -23,8 +23,9 @@
+         },
+ 		"version-check": {
+             "host": "sitesplat.com",
+-            "directory": "/updatecheck/phpbb31/ext",
+-            "filename": "breadcrumbs.json"
++            "directory": "/updatecheck/phpbb32/ext",
++            "filename": "breadcrumbs.json",
++			"ssl": true
+ 		}
+     }
+ }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/diff_full.tmp"
+new file mode 100644
+index 000000000..50372e97b
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/diff_full.tmp"
+@@ -0,0 +1,120 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbbreadcrumbs/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/composer.json"
++index 6c35e452a..3d2d2f210 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbbreadcrumbs/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/composer.json"
++@@ -23,8 +23,9 @@
++         },
++ 		"version-check": {
++             "host": "sitesplat.com",
++-            "directory": "/updatecheck/phpbb31/ext",
++-            "filename": "breadcrumbs.json"
+++            "directory": "/updatecheck/phpbb32/ext",
+++            "filename": "breadcrumbs.json",
+++			"ssl": true
++ 		}
++     }
++ }
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbbreadcrumbs/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/event/main_listener.php"
++index 1d6b181f1..a28456e2f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbbreadcrumbs/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbbreadcrumbs/event/main_listener.php"
++@@ -56,7 +56,7 @@ class main_listener implements EventSubscriberInterface
++ 
++ 	public function add_breadcrumbs_to_module($event)
++ 	{
++-		// here we store breadrumbs in proper order
+++		// here we store breadcrumbs in proper order
++ 		$breadcrumbs_data = array();
++ 		// list of all modules
++ 		$modules = $event['module']->module_ary;
++@@ -65,31 +65,31 @@ class main_listener implements EventSubscriberInterface
++ 
++ 		// standardize module ID
++ 		$id = $event['module']->p_id;
++-		if (!$id)
++-		{
++-			if (strcmp((int) $event['id'], $event['id'])) // module ID is string (ie. ucp_pm, mcp_queue, ...)
++-			{
++-				// hacks
++-				if ($event['id'] == 'pm')
++-				{
++-					$event['id'] = 'ucp_pm';
++-				}
++-
++-				// find proper module
++-				foreach ($modules as $module)
++-				{
++-					if ($module['name'] == $event['id'] && $module['mode'] == $event['mode'])
++-					{
++-						$id = $module['id'];
++-						break;
++-					}
++-				}
++-			}
++-			else
++-			{
++-				$id = $event['id'];
++-			}
++-		}
+++		// if (!$id)
+++		// {
+++		// 	if (strcmp((int) $event['id'], $event['id'])) // module ID is string (ie. ucp_pm, mcp_queue, ...)
+++		// 	{
+++		// 		// h
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bbbreadcrumbs/event/main_listener.php" "[FORUM_EXT]/sitesplat\\bbbreadcrumbs/event/main_listener.php"
--- "[ORIGINAL]/sitesplat\\bbbreadcrumbs/event/main_listener.php"
+++ "[FORUM_EXT]/sitesplat\\bbbreadcrumbs/event/main_listener.php"
@@ -56,7 +56,7 @@ class main_listener implements EventSubscriberInterface
 
 	public function add_breadcrumbs_to_module($event)
 	{
-		// here we store breadrumbs in proper order
+		// here we store breadcrumbs in proper order
 		$breadcrumbs_data = array();
 		// list of all modules
 		$modules = $event['module']->module_ary;
@@ -65,31 +65,31 @@ class main_listener implements EventSubscriberInterface
 
 		// standardize module ID
 		$id = $event['module']->p_id;
-		if (!$id)
-		{
-			if (strcmp((int) $event['id'], $event['id'])) // module ID is string (ie. ucp_pm, mcp_queue, ...)
-			{
-				// hacks
-				if ($event['id'] == 'pm')
-				{
-					$event['id'] = 'ucp_pm';
-				}
-
-				// find proper module
-				foreach ($modules as $module)
-				{
-					if ($module['name'] == $event['id'] && $module['mode'] == $event['mode'])
-					{
-						$id = $module['id'];
-						break;
-					}
-				}
-			}
-			else
-			{
-				$id = $event['id'];
-			}
-		}
+		// if (!$id)
+		// {
+		// 	if (strcmp((int) $event['id'], $event['id'])) // module ID is string (ie. ucp_pm, mcp_queue, ...)
+		// 	{
+		// 		// hacks
+		// 		if ($event['id'] == 'pm')
+		// 		{
+		// 			$event['id'] = 'ucp_pm';
+		// 		}
+
+		// 		// find proper module
+		// 		foreach ($modules as $module)
+		// 		{
+		// 			if ($module['name'] == $event['id'] && $module['mode'] == $event['mode'] && $event['id'] != 'ucp_main')
+		// 			{
+		// 				$id = $module['id'];
+		// 				break;
+		// 			}
+		// 		}
+		// 	}
+		// 	else
+		// 	{
+		// 		$id = $event['id'];
+		// 	}
+		// }
 
 		while($id)
 		{
@@ -103,10 +103,10 @@ class main_listener implements EventSubscriberInterface
 			$id = $module['parent'];
 		}
 
-		$this->add_breadcrumb(
-			$module_class == 'ucp' ? $this->user->lang('PROFILE') : $this->user->lang('MCP'),
-			append_sid("{$this->root_path}{$module_class}.{$this->php_ext}")
-		);
+		// $this->add_breadcrumb(
+		// 	$module_class == 'ucp' ? $this->user->lang('PROFILE') : $this->user->lang('MCP'),
+		// 	append_sid("{$this->root_path}{$module_class}.{$this->php_ext}")
+		// );
 
 		foreach ($breadcrumbs_data as $breadcrumb)
 		{
@@ -155,10 +155,10 @@ class main_listener implements EventSubscriberInterface
 
 	public function add_breadcrumbs_to_search()
 	{
-		$this->add_breadcrumb(
-			$this->user->lang('SEARCH'),
-			append_sid("{$this->root_path}search.{$this->php_ext}")
-		);
+		// $this->add_breadcrumb(
+		// 	$this->user->lang('SEARCH'),
+		// 	append_sid("{$this->root_path}search.{$this->php_ext}")
+		// );
 	}
 
 	public function add_breadcrumbs_to_viewonline()
```
