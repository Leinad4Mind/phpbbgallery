Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/phpbbstudio\\tlink/diff_full.tmp" "[FORUM_EXT]/phpbbstudio\\tlink/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbbstudio\\tlink/diff_full.tmp"
@@ -0,0 +1,39 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbstudio\\tlink/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbstudio\\tlink/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbstudio\\tlink/event/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbstudio\\tlink/event/main.php"
+index 79019defd..3f7bd179d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbstudio\\tlink/event/main.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbstudio\\tlink/event/main.php"
+@@ -255,11 +255,11 @@ class main implements EventSubscriberInterface
+ 		$sql_array = $event['sql_ary'];
+ 
+ 		$sql_array['LEFT_JOIN'][] = [
+-			'FROM' => [TOPICS_TABLE => 't'],
+-			'ON' => 'f.forum_last_post_id = t.topic_last_post_id'
++			'FROM' => [TOPICS_TABLE => 'tl'],
++			'ON' => 'tl.tlink IS NOT NULL AND tl.tlink <> \'\' AND f.forum_last_post_id = tl.topic_last_post_id'
+ 		];
+ 
+-		$sql_array['SELECT'] .= ', t.tlink';
++		$sql_array['SELECT'] .= ', tl.tlink';
+ 
+ 		$event['sql_ary'] = $sql_array;
+ 	}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbstudio\\tlink/styles/FLATBOOTS/template/event/posting_editor_options_prepend.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbstudio\\tlink/styles/FLATBOOTS/template/event/posting_editor_options_prepend.html"
+new file mode 100644
+index 000000000..55b244838
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbstudio\\tlink/styles/FLATBOOTS/template/event/posting_editor_options_prepend.html"
+@@ -0,0 +1,11 @@
++{% if S_TOPIC_LINK %}
++<div class="control-group">
++	<label class="control-label" for="tlink">{{ lang('TOPIC_LINK') ~ lang('COLON') }}</label>
++	<div class="row">
++		<div class="col-xs-12 col-lg-8">
++			<input type="text" class="form-control input-sm" name="tlink" id="tlink" size="100" maxlength="250" value="{{ TOPIC_LINK }}">
++		</div>
++	</div>
++</div>
++<hr class="dashed">
++{% endif %}
diff --git "[FORUM_EXT]/phpbbstudio\\tlink/diff_nospace.tmp" "[FORUM_EXT]/phpbbstudio\\tlink/diff_nospace.tmp"
new file mode 100644
diff --git "[ORIGINAL]/phpbbstudio\\tlink/event/main.php" "[FORUM_EXT]/phpbbstudio\\tlink/event/main.php"
--- "[ORIGINAL]/phpbbstudio\\tlink/event/main.php"
+++ "[FORUM_EXT]/phpbbstudio\\tlink/event/main.php"
@@ -255,11 +255,11 @@ class main implements EventSubscriberInterface
 		$sql_array = $event['sql_ary'];
 
 		$sql_array['LEFT_JOIN'][] = [
-			'FROM' => [TOPICS_TABLE => 't'],
-			'ON' => 'f.forum_last_post_id = t.topic_last_post_id'
+			'FROM' => [TOPICS_TABLE => 'tl'],
+			'ON' => 'tl.tlink IS NOT NULL AND tl.tlink <> \'\' AND f.forum_last_post_id = tl.topic_last_post_id'
 		];
 
-		$sql_array['SELECT'] .= ', t.tlink';
+		$sql_array['SELECT'] .= ', tl.tlink';
 
 		$event['sql_ary'] = $sql_array;
 	}
diff --git "[FORUM_EXT]/phpbbstudio\\tlink/styles/FLATBOOTS/template/event/posting_editor_options_prepend.html" "[FORUM_EXT]/phpbbstudio\\tlink/styles/FLATBOOTS/template/event/posting_editor_options_prepend.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbbstudio\\tlink/styles/FLATBOOTS/template/event/posting_editor_options_prepend.html"
@@ -0,0 +1,11 @@
+{% if S_TOPIC_LINK %}
+<div class="control-group">
+	<label class="control-label" for="tlink">{{ lang('TOPIC_LINK') ~ lang('COLON') }}</label>
+	<div class="row">
+		<div class="col-xs-12 col-lg-8">
+			<input type="text" class="form-control input-sm" name="tlink" id="tlink" size="100" maxlength="250" value="{{ TOPIC_LINK }}">
+		</div>
+	</div>
+</div>
+<hr class="dashed">
+{% endif %}
```
