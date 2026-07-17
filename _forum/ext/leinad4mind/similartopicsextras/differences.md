Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/leinad4mind\\similartopicsextras/composer.json" "[FORUM_EXT]/leinad4mind\\similartopicsextras/composer.json"
--- "[ORIGINAL]/leinad4mind\\similartopicsextras/composer.json"
+++ "[FORUM_EXT]/leinad4mind\\similartopicsextras/composer.json"
@@ -3,7 +3,7 @@
     "type": "phpbb-extension",
     "description": "Makes the Precise Similar Topic extension compatible with BBEmoji, BBPrefix and Best Answer Special Edition",
     "version": "1.0.0",
-    "time": "2022-05-21",
+    "time": "2022-05-20",
     "license": "Proprietary",
     "authors": [
         {
diff --git "[FORUM_EXT]/leinad4mind\\similartopicsextras/diff_full.tmp" "[FORUM_EXT]/leinad4mind\\similartopicsextras/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\similartopicsextras/diff_full.tmp"
@@ -0,0 +1,273 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/composer.json"
+index 60a3e9fe4..69479d286 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/composer.json"
+@@ -3,7 +3,7 @@
+     "type": "phpbb-extension",
+     "description": "Makes the Precise Similar Topic extension compatible with BBEmoji, BBPrefix and Best Answer Special Edition",
+     "version": "1.0.0",
+-    "time": "2022-05-21",
++    "time": "2022-05-20",
+     "license": "Proprietary",
+     "authors": [
+         {
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/event/listener.php"
+index af73e084f..890bc67ae 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/event/listener.php"
+@@ -40,28 +40,42 @@ class listener implements EventSubscriberInterface
+                \censor_text($event['row']['topic_title'])
+             )
+          );
+-         if (!empty($bbemoji->icons[$event['row']['icon_id']])) {
+-            $icon = $bbemoji->icons[$event['row']['icon_id']];
+-            $topic_row['TOPIC_ICON_IMG'] = $icon;
+-            $topic_row['TOPIC_ICON_IMG_WIDTH'] = 20;
+-            $topic_row['TOPIC_ICON_IMG_HEIGHT'] = 20;
+-         }
++
++        if (!empty($bbemoji->icons[$event['row']['icon_id']])) {
++          $icon = $bbemoji->icons[$event['row']['icon_id']];
++          $topic_row['TOPIC_ICON_IMG'] = $icon;
++          $topic_row['TOPIC_ICON_IMG_WIDTH'] = 20;
++          $topic_row['TOPIC_ICON_IMG_HEIGHT'] = 20;
++        }
+       }
+ 
+       if ($extension_manager->is_enabled('sitesplat/bbprefix')) {
+          $bbprefix = $phpbb_container->get('bbprefix.manager');
+          // BBPrefix is installed and working.
+-         $prefix_id = $bbprefix->get_instance($instance_id)['prefix'];
+-         $url = $topic_row['U_VIEW_FORUM'] . '&prefix=' . $prefix_id;
+-         $prefixes[] = $bbprefix->get_instance($instance_id)->parse('', ['URL' => $url], true);
++         $similar_topic_id = $event['row']['topic_id'];
++         $bbprefix->load_prefix_instances();
++         $instance_ids = $bbprefix->load_instance_ids_topic($similar_topic_id);
++         $instances_ordered = [];
++         foreach ($instance_ids as $instance_id) {
++            $instances_ordered[$instance_id] = $bbprefix->get_instance($instance_id)->getOrdered();
++         }
++         asort($instances_ordered);
++         $prefixes = [];
++         foreach (array_keys($instances_ordered) as $instance_id) {
++             $prefix_id = $bbprefix->get_instance($instance_id)['prefix'];
++
++             $url = $topic_row['U_VIEW_FORUM'].'&prefix='.$prefix_id;
++             $prefixes[] = $bbprefix->get_instance($instance_id)->parse('', ['URL' => $url], true);
++         }
++
++         $topic_row['TOPIC_PREFIXES'] = $prefixes;
+       }
+ 
+-      // TODO
+-      // if ($extension_manager->is_enabled('kinerity/bestanswer') || $extension_manager->is_enabled('leinad4mind/bestanswer')) {
+-      // Best Answer is installed and working.
+-      // $topic_row['TOPIC_ANSWERED'] = $event['row']['answer_post_id'] ? true : false;
+-      // }
++      if ($extension_manager->is_enabled('kinerity/bestanswer') || $extension_manager->is_enabled('leinad4mind/bestanswer')) {
++         // Best Answer is installed and working.
++         $topic_row['TOPIC_ANSWERED'] = $event['row']['answer_post_id'] ? true : false;
++      }
+ 
+       $event['topic_row'] = $topic_row;
+    }
+-}
+\ No newline at end of file
++}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/styles/all/template/event/topiclist_row_topic_title_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/styles/all/template/event/topiclist_row_topic_title_before.html"
+index cd869ff04..118cc148c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/styles/all/template/event/topiclist_row_topic_title_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/styles/all/template/event/topiclist_row_topic_title_before.html"
+@@ -1 +1 @@
+-{% for prefix in similar.TOPIC_PREFIXES %}<span>{{ prefix }}</span>{% endfor %}
+\ No newline at end of file
++{% for prefix in similar.TOPIC_PREFIXES %}{{ prefix }} {% endfor %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+deleted file mode 100644
+index c9b59a2a3..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
++++ /dev/null
+@@ -1,9 +0,0 @@
+-{% if S_SIMILAR_TOPICS %}
+-<div class="control-group">
+-	<label class="control-label" for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label>
+-	<div class="controls controls-row">
+-	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics1">{{ lang('YES') }}</label></div>
+-	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics0">{{ lang('NO') }}</label></div>
+-    </div>
+-</div>
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/viewtopic_body_footer_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/viewtopic_body_footer_before.html"
+deleted file mode 100644
+index f4e9cad5c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/viewtopic_body_footer_before.html"
++++ /dev/null
+@@ -1,69 +0,0 @@
+-{% if loops.similar|length %}
+-<div class="panel panel-default">
+-	<table class="footable table table-striped table-bordered table-white table-primary table-hover">
+-	<thead>
+-		<tr>
+-			<th data-class="expand">{{ lang('SIMILAR_TOPICS') }}</th>
+-			<th class="large110" data-hide="phone">{{ lang('TOPICS_POSTS_STATISTICS') }}</th>
+-			<th class="large21" data-hide="phone">{{ lang('LAST_POST') }}</th>
+-		</tr>
+-	</thead>
+-	 <tbody>
+-	{% for similar in loops.similar %}
+-		{% EVENT search_results_topic_before %}
+-		<tr>
+-			<td>
+-				{% if similar.TOPIC_ICON_IMG %}
+-				 <i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ similar.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+-				{% endif %}
+-				<span class="icon-wrapper">
+-			     <i class="row-icon-font icon-moon-default2{% if similar.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if similar.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if similar.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if similar.S_HAS_POLL %} icon-moon-poll{% endif %}{% if similar.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+-				</span>
+-				<i class="row-icon-font-mini{% if similar.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+-				<span class="desc-wrapper">
+-				{% EVENT topiclist_row_prepend %}
+-				{% if similar.S_UNREAD_TOPIC and not S_IS_BOT %}<a href="{{ similar.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="fa fa-asterisk"></i></a>{% endif %}{% EVENT topiclist_row_topic_title_before %}<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a>
+-				{% if similar.ATTACH_ICON_IMG %}<i class="fa fa-paperclip fa-flip-horizontal" title="{{ lang('ATTACH_FORUM') }}"></i>{% endif %}
+-			    {% if similar.S_TOPIC_UNAPPROVED or similar.S_POSTS_UNAPPROVED %}<a href="{{ similar.U_MCP_QUEUE }}">{{ similar.UNAPPROVED_IMG }}</a> {% endif %}
+-			    {% if similar.S_TOPIC_REPORTED %}<a href="{{ similar.U_MCP_REPORT }}">{{ REPORTED_IMG }}</a>{% endif %}<br />
+-				{% EVENT topiclist_row_topic_title_after %}
+-			    {% if similar.pagination|length %}
+-				    <ul class="pagination pagination-forum pagination-xs pull-right hidden-sm hidden-xs">
+-						{% for pagination in similar.pagination %}
+-						 {% if pagination.S_IS_PREV %}
+-						 {% elseif pagination.S_IS_CURRENT %}<li class="active">{{ pagination.PAGE_NUMBER }}</li>
+-						 {% elseif pagination.S_IS_ELLIPSIS %}<li class="ellipsis"><a>{{ lang('ELLIPSIS') }}</a></li>
+-						 {% elseif pagination.S_IS_NEXT %}
+-						{% else %}
+-						 <li><a href="{similar.pagination.PAGE_URL}">{{ pagination.PAGE_NUMBER }}</a></li>
+-						{% endif %}
+-						{% endfor %}
+-					</ul>		
+-			    {% endif %}
+-				{% EVENT topiclist_row_topic_by_author_before %}
+-				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_topic_author_username_prepend %}{{ similar.TOPIC_AUTHOR_FULL }}{% EVENT search_results_topic_author_username_append %}&nbsp;
+-				<small>&#45;&nbsp;<time datetime="{{ similar.FIRST_POST_TIME_RFC3339 }}">{{ similar.FIRST_POST_TIME }}</time></small>
+-				{{ lang('IN') ~ lang('COLON') }}&nbsp;<a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a>
+-				{% EVENT topiclist_row_topic_by_author_after %}
+-				{% EVENT topiclist_row_append %}
+-				</span>
+-			</td>
+-			<td class="stats-col">
+-			 <span class="stats-wrapper">
+-			 {{ similar.TOPIC_REPLIES }}&nbsp;{{ lang('REPLIES') }}<br />{{ similar.TOPIC_VIEWS }}&nbsp;{{ lang('VIEWS') }}
+-			 </span>
+-			</td>
+-			<td class="center">
+-			 <span class="last-wrapper">
+-				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_last_post_author_username_prepend %}{{ similar.LAST_POST_AUTHOR_FULL }}{% EVENT search_results_last_post_author_username_append %}
+-				{% if not S_IS_BOT %}<a title="{{ lang('FORUMLIST_LASTPOST') }}" href="{{ similar.U_LAST_POST }}"><i class="mobile-post fa fa-sign-out"></i></a>{% endif %}
+-				<br /><small><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time></small>
+-			 </span>
+-			</td>
+-	    </tr>
+-		{% EVENT search_results_topic_after %}
+-	  {% endfor %}
+-	 </tbody>
+-	</table>
+-</div>
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+deleted file mode 100644
+index c9b59a2a3..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
++++ /dev/null
+@@ -1,9 +0,0 @@
+-{% if S_SIMILAR_TOPICS %}
+-<div class="control-group">
+-	<label class="control-label" for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label>
+-	<div class="controls controls-row">
+-	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics1">{{ lang('YES') }}</label></div>
+-	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics0">{{ lang('NO') }}</label></div>
+-    </div>
+-</div>
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
+deleted file mode 100644
+index 428bf3329..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
++++ /dev/null
+@@ -1,75 +0,0 @@
+-	{% if loops.similar|length %}
+-	<div class="panel panel-forum">
+-	<div class="panel-heading">
+-	 {{ lang('SIMILAR_TOPICS') }}
+-	</div>
+-	<div class="panel-inner">
+-	<table class="footable table table-striped table-primary table-hover">
+-	<thead>
+-		<tr>
+-			<th data-class="expand">{{ lang('TOPICS') }}</th>
+-			<th class="large110" data-hide="phone">{{ lang('TOPICS_POSTS_STATISTICS') }}</th>
+-			<th class="large21" data-hide="phone">{{ lang('LAST_POST') }}</th>
+-		</tr>
+-	</thead>
+-	<tbody>
+-		{% for similar in loops.similar %}
+-		{% EVENT search_results_topic_before %}
+-		<tr>
+-			<td>
+-				{% if similar.TOPIC_ICON_IMG %}
+-				<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ similar.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+-				{% endif %}
+-				<span class="icon-wrapper">
+-			    <i class="row-icon-font icon-moon-default2{% if similar.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if similar.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if similar.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if similar.S_HAS_POLL %} icon-moon-poll{% endif %}{% if similar.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+-				</span>
+-				<i class="row-icon-font-mini{% if similar.S_TOPIC_LOCKED %} icon-moon-lock forumview-lock{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+-				<div class="desc-wrapper">
+-				{% EVENT topiclist_row_prepend %}
+-				{% for bb_prefix in similar.BB_PREFIXES %} <span>{{ bb_prefix }}</span>{% endfor %}
+-				{% if similar.S_UNREAD_TOPIC and not S_IS_BOT %}<a href="{{ similar.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>{% endif %}{% EVENT topiclist_row_topic_title_before %}<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a>
+-				{% if similar.S_TOPIC_UNAPPROVED or similar.S_POSTS_UNAPPROVED %}<a href="{{ similar.U_MCP_QUEUE }}" title="{{ lang('TOPICS_ROW_NOT_APPROVED') }}">&nbsp;<i class="fa fa-question-circle"></i></a>{% endif %}
+-				{% if similar.S_TOPIC_REPORTED %}<a href="{{ similar.U_MCP_REPORT }}" title="{{ lang('TOPICS_ROW_REPORTED') }}">&nbsp;<i class="fa fa-exclamation-circle text-danger"></i></a>{% endif %}
+-				{% if similar.pagination|length %}
+-					<ul class="pagination pagination-forum pagination-xs pull-right hidden-sm hidden-xs">
+-						{% for pagination in similar.pagination %}
+-						 {% if pagination.S_IS_PREV %}
+-						 {% elseif pagination.S_IS_CURRENT %}<li class="active">{{ pagination.PAGE_NUMBER }}</li>
+-						 {% elseif pagination.S_IS_ELLIPSIS %}<li class="ellipsis"><a>{{ lang('ELLIPSIS') }}</a></li>
+-						 {% elseif pagination.S_IS_NEXT %}
+-						 {% else %}
+-						 <li><a href="{{ pagination.PAGE_URL }}">{{ pagination.PAGE_NUMBER }}</a></li>
+-						 {% endif %}
+-						{% endfor %}
+-					</ul>		
+-				{% endif %}
+-				{% EVENT topiclist_row_topic_title_after %}
+-				<br />
+-				{% if similar.ATTACH_ICON_IMG %}<i class="fa fa-paperclip fa-flip-horizontal" title="{{ lang('ATTACH_FORUM') }}"></i>{% endif %}
+-				{% EVENT topiclist_row_topic_by_author_before %}
+-				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_topic_author_username_prepend %}{{ similar.TOPIC_AUTHOR_FULL }}{% EVENT search_results_topic_author_username_append %}&nbsp;
+-				<small>&#45;&nbsp;<time datetime="{{ similar.FIRST_POST_TIME_RFC3339 }}">{{ similar.FIRST_POST_TIME }}</time>&nbsp;&nbsp;&#45;&nbsp;{{ lang('IN') ~ lang('COLON') }}&nbsp;<a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a></small>
+-				{% EVENT topiclist_row_topic_by_author_after %}
+-				{% EVENT topiclist_row_append %}
+-				</div>
+-			</td>
+-			<td class="stats-col">
+-			 <span class="stats-wrapper">
+-			 {{ similar.TOPIC_REPLIES }}&nbsp;{{ lang('REPLIES') }}&nbsp;<br />{{ similar.TOPIC_VIEWS }}&nbsp;{{ lang('VIEWS') }}
+-			 </span>
+-			</td>
+-			<td> 
+-			 <span class="last-wrapper text-overflow">
+-				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_last_post_author_username_prepend %}{{ similar.LAST_POST_AUTHOR_FULL }}{% EVENT search_results_last_post_author_username_append %}
+-				{% if not S_IS_BOT %}<a title="{{ lang('FORUMLIST_LASTPOST') }}" href="{{ similar.U_LAST_POST }}"><i class="mobile-post fa fa-sign-out"></i></a>{% endif %}
+-				<br /><small><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time></small>
+-			 </span>
+-			</td>
+-		</tr>
+-		{% EVENT search_results_topic_after %}
+-	{% endfor %}
+-	</tbody>
+-	</table>
+-	</div>
+-	</div>
+-	{% endif %}
diff --git "[FORUM_EXT]/leinad4mind\\similartopicsextras/diff_nospace.tmp" "[FORUM_EXT]/leinad4mind\\similartopicsextras/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\similartopicsextras/diff_nospace.tmp"
@@ -0,0 +1,243 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/composer.json"
+index 60a3e9fe4..69479d286 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/composer.json"
+@@ -3,7 +3,7 @@
+     "type": "phpbb-extension",
+     "description": "Makes the Precise Similar Topic extension compatible with BBEmoji, BBPrefix and Best Answer Special Edition",
+     "version": "1.0.0",
+-    "time": "2022-05-21",
++    "time": "2022-05-20",
+     "license": "Proprietary",
+     "authors": [
+         {
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/diff_full.tmp"
+new file mode 100644
+index 000000000..1f11b7a25
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/diff_full.tmp"
+@@ -0,0 +1,273 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/composer.json"
++index 60a3e9fe4..69479d286 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/composer.json"
++@@ -3,7 +3,7 @@
++     "type": "phpbb-extension",
++     "description": "Makes the Precise Similar Topic extension compatible with BBEmoji, BBPrefix and Best Answer Special Edition",
++     "version": "1.0.0",
++-    "time": "2022-05-21",
+++    "time": "2022-05-20",
++     "license": "Proprietary",
++     "authors": [
++         {
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/event/listener.php"
++index af73e084f..890bc67ae 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/event/listener.php"
++@@ -40,28 +40,42 @@ class listener implements EventSubscriberInterface
++                \censor_text($event['row']['topic_title'])
++             )
++          );
++-         if (!empty($bbemoji->icons[$event['row']['icon_id']])) {
++-            $icon = $bbemoji->icons[$event['row']['icon_id']];
++-            $topic_row['TOPIC_ICON_IMG'] = $icon;
++-            $topic_row['TOPIC_ICON_IMG_WIDTH'] = 20;
++-            $topic_row['TOPIC_ICON_IMG_HEIGHT'] = 20;
++-         }
+++
+++        if (!empty($bbemoji->icons[$event['row']['icon_id']])) {
+++          $icon = $bbemoji->icons[$event['row']['icon_id']];
+++          $topic_row['TOPIC_ICON_IMG'] = $icon;
+++          $topic_row['TOPIC_ICON_IMG_WIDTH'] = 20;
+++          $topic_row['TOPIC_ICON_IMG_HEIGHT'] = 20;
+++        }
++       }
++ 
++       if ($extension_manager->is_enabled('sitesplat/bbprefix')) {
++          $bbprefix = $phpbb_container->get('bbprefix.manager');
++          // BBPrefix is installed and working.
++-         $prefix_id = $bbprefix->get_instance($instance_id)['prefix'];
++-         $url = $topic_row['U_VIEW_FORUM'] . '&prefix=' . $prefix_id;
++-         $prefixes[] = $bbprefix->get_instance($instance_id)->parse('', ['URL' => $url], true);
+++         $similar_topic_id = $event['row']['topic_id'];
+++         $bbprefix->load_prefix_instances();
+++         $instance_ids = $bbprefix->load_instance_ids_topic($similar_topic_id);
+++         $instances_ordered = [];
+++         foreach ($instance_ids as $instance_id) {
+++            $instances_ordered[$instance_id] = $bbprefix->get_instance($instance_id)->getOrdered();
+++         }
+++         asort($instances_ordered);
+++         $prefixes = [];
+++         foreach (array_keys($instances_ordered) as $instance_id) {
+++             $prefix_id = $bbprefix->get_instance($instance_id)['prefix'];
+++
+++             $url = $topic_row['U_VIEW_FORUM'].'&prefix='.$prefix_id;
+++             $prefixes[] = $bbprefix->get_instance($instance_id)->parse('', ['URL' => $url], true);
+++         }
+++
+++         $topic_row['TOPIC_PREFIXES'] = $prefixes;
++       }
++ 
++-      // TODO
++-      // if ($extension_manager->is_enabled('kinerity/bestanswer') || $extension_manager->is_enabled('leinad4mind/bestanswer')) {
++-      // Best Answer is installed and working.
++-      // $topic_row['TOPIC_ANSWERED'] = $event['row']['answer_post_id'] ? true : false;
++-      // }
+++      if ($extension_manager->is_enabled('kinerity/bestanswer') || $extension_manager->is_enabled('leinad4mind/bestanswer')) {
+++         // Best Answer is installed and working.
+++         $topic_row['TOPIC_ANSWERED'] = $event['row']['answer_post_id'] ? true : false;
+++      }
++ 
++       $event['topic_row'] = $topic_row;
++    }
++-}
++\ No newline at end of file
+++}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/styles/all/template/event/topiclist_row_topic_title_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/styles/all/template/event/topiclist_row_topic_title_before.html"
++index cd869ff04..118cc148c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/styles/all/template/event/topiclist_row_topic_title_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\similartopicsextras/styles/all/template/event/topiclist_row_topic_title_before.html"
++@@ -1 +1 @@
++-{% for prefix in similar.TOPIC_PREFIXES %}<span>{{ prefix }}</span>{% endfor %}
++\ No newline at end of file
+++{% for prefix in similar.TOPIC_PREFIXES %}{{ prefix }} {% endfor %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
++deleted file mode 100644
++index c9b59a2a3..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+++++ /dev/null
++@@ -1,9 +0,0 @@
++-{% if S_SIMILAR_TOPICS %}
++-<div class="control-group">
++-	<label class="control-label" for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label>
++-	<div class="controls controls-row">
++-	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics1">{{ lang('YES') }}</label></div>
++-	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics0">{{ lang('NO') }}</label></div>
++-    </div>
++-</div>
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/viewtopic_body_footer_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/viewtopic_body_footer_before.html"
++deleted file mode 100644
++index f4e9cad5c..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/viewtopic_body_footer_before.html"
+++++ /dev/null
++@@ -1,69 +0,0 @@
++-{% if loops.similar|length %}
++-<div class="panel panel-default">
++-	<table class="footable table table-striped table-bordered table-white table-primary table-hover">
++-	<thead>
++-		<tr>
++-			<th data-class="expand">{{ lang('SIMILAR_TOPICS') }}</th>
++-			<th class="large110" data-hide="phone">{{ lang('TOPICS_POSTS_STATISTICS') }}</th>
++-			<th class="large21" data-hide="phone">{{ lang('LAST_POST') }}</th>
++-		</tr>
++-	</thead>
++-	 <tbody>
++-	{% for similar in loops.similar %}
++-		{% EVENT search_results_topic_before %}
++-		<tr>
++-			<td>
++-				{% if similar.TOPIC_ICON_IMG %}
++-				 <i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ similar.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
++-				{% endif %}
++-				<span class="icon-wrapper">
++-			     <i class="row-icon-font icon-moon-default2{% if similar.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if similar.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if similar.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if similar.S_HAS_POLL %} icon-moon-poll{% endif %}{% if similar.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
++-				</span>
++-				<i class="row-icon-font-mini{% if similar.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
++-				<span class="desc-wrapper">
++-				{% EVENT topiclist_row_prepend %}
++-				{% if similar.S_UNREAD_TOPIC and not S_IS_BOT %}<a href="{{ similar.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="fa fa-asterisk"></i></a>{% endif %}{% EVENT topiclist_row_topic_title_before %}<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a>
++-				{% if similar.ATTACH_ICON_IMG %}<i class="fa fa-paperclip fa-flip-horizontal" title="{{ lang('ATTACH_FORUM') }}"></i>{% endif %}
++-			    {% if similar.S_TOPIC_UNAPPROVED or similar.S_POSTS_UNAPPROVED %}<a href="{{ similar.U_MCP_QUEUE }}">{{ similar.UNAPPROVED_IMG }}</a> {% endif %}
++-			    {% if similar.S_TOPIC_REPORTED %}<a href="{{ similar.U_MCP_REPORT }}">{{ REPORTED_IMG }}</a>{% endif %}<br />
++-				{% EVENT topiclist_row_topic_title_after %}
++-			    {% if similar.pagination|length %}
++-				    <ul class="pagination pagination-forum pagination-xs pull-right hidden-sm hidden-xs">
++-						{% for pagination in similar.pagination %}
++-						 {% if pagination.S_IS_PREV %}
++-						 {% elseif pagination.S_IS_CURRENT %}<li class="active">{{ pagination.PAGE_NUMBER }}</li>
++-						 {% elseif pagination.S_IS_ELLIPSIS %}<li class="ellipsis"><a>{{ lang('ELLIPSIS') }}</a></li>
++-						 {% elseif pagination.S_IS_NEXT %}
++-						{% else %}
++-						 <li><a href="{similar.pagination.PAGE_URL}">{{ pagination.PAGE_NUMBER }}</a></li>
++-						{% endif %}
++-						{% endfor %}
++-					</ul>		
++-			    {% endif %}
++-				{% EVENT topiclist_row_topic_by_author_before %}
++-				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_topic_author_username_prepend %}{{ similar.TOPIC_AUTHOR_FULL }}{% EVENT search_results_topic_author_username_append %}&nbsp;
++-				<small>&#45;&nbsp;<time datetime="{{ similar.FIRST_POST_TIME_RFC3339 }}">{{ similar.FIRST_POST_TIME }}</time></small>
++-				{{ lang('IN') ~ lang('COLON') }}&nbsp;<a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a>
++-				{% EVENT topiclist_row_topic_by_author_after %}
++-				{% EVENT topiclist_row_append %}
++-				</span>
++-			</td>
++-			<td class="stats-col">
++-			 <span class="stats-wrapper">
++-			 {{ similar.TOPIC_REPLIES }}&nbsp;{{ lang('REPLIES') }}<br />{{ similar.TOPIC_VIEWS }}&nbsp;{{ lang('VIEWS') }}
++-			 </span>
++-			</td>
++-			<td class="center">
++-			 <span class="last-wrapper">
++-				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_last_post_author_username_prepend %}{{ similar.LAST_POST_AUTHOR_FULL }}{% EVENT search_results_last_post_author_username_append %}
++-				{% if not S_IS_BOT %}<a title="{{ lang('FORUMLIST_LASTPOST') }}" href="{{ similar.U_LAST_POST }}"><i class="mobile-post fa fa-sign-out"></i></a>{% endif %}
++-				<br /><small><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time></small>
++-			 </span>
++-			</td>
++-	    </tr>
++-		{% EVENT search_results_topic_after %}
++-	  {% endfor %}
++-	 </tbody>
++-	</table>
++-</div>
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
++deleted file mode 100644
++index c9b59a2a3..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+++++ /dev/null
++@@ -1,9 +0,0 @@
++-{% if S_SIMILAR_TOPICS %}
++-<div class="control-group">
++-	<label class="control-label" for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label>
++-	<div class="controls controls-row">
++-	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics1">{{ lang('YES') }}</label></div>
++-	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics0">{{ lang('NO') }}</label></div>
++-    </div>
++-</div>
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
++deleted file mode 100644
++index 428bf3329..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
+++++ /dev/null
++@@ -1,75 +0,0 @@
++-	{% if loops.similar|length %}
++-	<div class="panel panel-forum">
++-	<div class="panel-heading">
++-	 {{ lang('SIMILAR_TOPICS') }}
++-	</div>
++-	<div class="panel-inner">
++-	<table class="footable table table-striped table-primary table-hover">
++-	<thead>
++-		<tr>
++-			<th data-class="expand">{{ lang('TOPICS') }}</th>
++-			<th class="large110" data-hide="phone">{{ lang('TOPICS_POSTS_STATISTICS') }}</th>
++-			<th class="large21" data-hide="phone">{{ lang('LAST_POST') }}</th>
++-		</tr>
++-	</thead>
++-	<tbody>
++-		{% for similar in loops.similar %}
++-		{% EVENT search_results_topic_before %}
++-		<tr>
++-			<td>
++-				{% if similar.TOPIC_ICON_IMG %}
++-				<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ similar.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
++-				{% endif %}
++-				<span class="icon-wrapper">
++-			    <i class="row-icon-font icon-moon-default2{% if similar.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if similar.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if similar.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if similar.S_HAS_POLL %} icon-moon-poll{% endif %}{% if similar.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
++-				</span>
++-				<i class="row-icon-font-mini{% if similar.S_TOPIC_LOCKED %} icon-moon-lock forumview-lock{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_AL
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\similartopicsextras/event/listener.php" "[FORUM_EXT]/leinad4mind\\similartopicsextras/event/listener.php"
--- "[ORIGINAL]/leinad4mind\\similartopicsextras/event/listener.php"
+++ "[FORUM_EXT]/leinad4mind\\similartopicsextras/event/listener.php"
@@ -40,6 +40,7 @@ class listener implements EventSubscriberInterface
                \censor_text($event['row']['topic_title'])
             )
          );
+
         if (!empty($bbemoji->icons[$event['row']['icon_id']])) {
           $icon = $bbemoji->icons[$event['row']['icon_id']];
           $topic_row['TOPIC_ICON_IMG'] = $icon;
@@ -51,16 +52,29 @@ class listener implements EventSubscriberInterface
       if ($extension_manager->is_enabled('sitesplat/bbprefix')) {
          $bbprefix = $phpbb_container->get('bbprefix.manager');
          // BBPrefix is installed and working.
+         $similar_topic_id = $event['row']['topic_id'];
+         $bbprefix->load_prefix_instances();
+         $instance_ids = $bbprefix->load_instance_ids_topic($similar_topic_id);
+         $instances_ordered = [];
+         foreach ($instance_ids as $instance_id) {
+            $instances_ordered[$instance_id] = $bbprefix->get_instance($instance_id)->getOrdered();
+         }
+         asort($instances_ordered);
+         $prefixes = [];
+         foreach (array_keys($instances_ordered) as $instance_id) {
              $prefix_id = $bbprefix->get_instance($instance_id)['prefix'];
+
              $url = $topic_row['U_VIEW_FORUM'].'&prefix='.$prefix_id;
              $prefixes[] = $bbprefix->get_instance($instance_id)->parse('', ['URL' => $url], true);
          }
 
-      // TODO
-      // if ($extension_manager->is_enabled('kinerity/bestanswer') || $extension_manager->is_enabled('leinad4mind/bestanswer')) {
+         $topic_row['TOPIC_PREFIXES'] = $prefixes;
+      }
+
+      if ($extension_manager->is_enabled('kinerity/bestanswer') || $extension_manager->is_enabled('leinad4mind/bestanswer')) {
          // Best Answer is installed and working.
-      // $topic_row['TOPIC_ANSWERED'] = $event['row']['answer_post_id'] ? true : false;
-      // }
+         $topic_row['TOPIC_ANSWERED'] = $event['row']['answer_post_id'] ? true : false;
+      }
 
       $event['topic_row'] = $topic_row;
    }
diff --git "[ORIGINAL]/leinad4mind\\similartopicsextras/styles/all/template/event/topiclist_row_topic_title_before.html" "[FORUM_EXT]/leinad4mind\\similartopicsextras/styles/all/template/event/topiclist_row_topic_title_before.html"
--- "[ORIGINAL]/leinad4mind\\similartopicsextras/styles/all/template/event/topiclist_row_topic_title_before.html"
+++ "[FORUM_EXT]/leinad4mind\\similartopicsextras/styles/all/template/event/topiclist_row_topic_title_before.html"
@@ -1 +1 @@
-{% for prefix in similar.TOPIC_PREFIXES %}<span>{{ prefix }}</span>{% endfor %}
\ No newline at end of file
+{% for prefix in similar.TOPIC_PREFIXES %}{{ prefix }} {% endfor %}
diff --git "[ORIGINAL]/leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "[ORIGINAL]/leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+++ /dev/null
@@ -1,9 +0,0 @@
-{% if S_SIMILAR_TOPICS %}
-<div class="control-group">
-	<label class="control-label" for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label>
-	<div class="controls controls-row">
-	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics1">{{ lang('YES') }}</label></div>
-	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics0">{{ lang('NO') }}</label></div>
-    </div>
-</div>
-{% endif %}
diff --git "[ORIGINAL]/leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/viewtopic_body_footer_before.html" "[ORIGINAL]/leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/viewtopic_body_footer_before.html"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\similartopicsextras/vse_styles/BBOOTS/template/event/viewtopic_body_footer_before.html"
+++ /dev/null
@@ -1,69 +0,0 @@
-{% if loops.similar|length %}
-<div class="panel panel-default">
-	<table class="footable table table-striped table-bordered table-white table-primary table-hover">
-	<thead>
-		<tr>
-			<th data-class="expand">{{ lang('SIMILAR_TOPICS') }}</th>
-			<th class="large110" data-hide="phone">{{ lang('TOPICS_POSTS_STATISTICS') }}</th>
-			<th class="large21" data-hide="phone">{{ lang('LAST_POST') }}</th>
-		</tr>
-	</thead>
-	 <tbody>
-	{% for similar in loops.similar %}
-		{% EVENT search_results_topic_before %}
-		<tr>
-			<td>
-				{% if similar.TOPIC_ICON_IMG %}
-				 <i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ similar.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
-				{% endif %}
-				<span class="icon-wrapper">
-			     <i class="row-icon-font icon-moon-default2{% if similar.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if similar.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if similar.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if similar.S_HAS_POLL %} icon-moon-poll{% endif %}{% if similar.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
-				</span>
-				<i class="row-icon-font-mini{% if similar.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
-				<span class="desc-wrapper">
-				{% EVENT topiclist_row_prepend %}
-				{% if similar.S_UNREAD_TOPIC and not S_IS_BOT %}<a href="{{ similar.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="fa fa-asterisk"></i></a>{% endif %}{% EVENT topiclist_row_topic_title_before %}<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a>
-				{% if similar.ATTACH_ICON_IMG %}<i class="fa fa-paperclip fa-flip-horizontal" title="{{ lang('ATTACH_FORUM') }}"></i>{% endif %}
-			    {% if similar.S_TOPIC_UNAPPROVED or similar.S_POSTS_UNAPPROVED %}<a href="{{ similar.U_MCP_QUEUE }}">{{ similar.UNAPPROVED_IMG }}</a> {% endif %}
-			    {% if similar.S_TOPIC_REPORTED %}<a href="{{ similar.U_MCP_REPORT }}">{{ REPORTED_IMG }}</a>{% endif %}<br />
-				{% EVENT topiclist_row_topic_title_after %}
-			    {% if similar.pagination|length %}
-				    <ul class="pagination pagination-forum pagination-xs pull-right hidden-sm hidden-xs">
-						{% for pagination in similar.pagination %}
-						 {% if pagination.S_IS_PREV %}
-						 {% elseif pagination.S_IS_CURRENT %}<li class="active">{{ pagination.PAGE_NUMBER }}</li>
-						 {% elseif pagination.S_IS_ELLIPSIS %}<li class="ellipsis"><a>{{ lang('ELLIPSIS') }}</a></li>
-						 {% elseif pagination.S_IS_NEXT %}
-						{% else %}
-						 <li><a href="{similar.pagination.PAGE_URL}">{{ pagination.PAGE_NUMBER }}</a></li>
-						{% endif %}
-						{% endfor %}
-					</ul>		
-			    {% endif %}
-				{% EVENT topiclist_row_topic_by_author_before %}
-				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_topic_author_username_prepend %}{{ similar.TOPIC_AUTHOR_FULL }}{% EVENT search_results_topic_author_username_append %}&nbsp;
-				<small>&#45;&nbsp;<time datetime="{{ similar.FIRST_POST_TIME_RFC3339 }}">{{ similar.FIRST_POST_TIME }}</time></small>
-				{{ lang('IN') ~ lang('COLON') }}&nbsp;<a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a>
-				{% EVENT topiclist_row_topic_by_author_after %}
-				{% EVENT topiclist_row_append %}
-				</span>
-			</td>
-			<td class="stats-col">
-			 <span class="stats-wrapper">
-			 {{ similar.TOPIC_REPLIES }}&nbsp;{{ lang('REPLIES') }}<br />{{ similar.TOPIC_VIEWS }}&nbsp;{{ lang('VIEWS') }}
-			 </span>
-			</td>
-			<td class="center">
-			 <span class="last-wrapper">
-				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_last_post_author_username_prepend %}{{ similar.LAST_POST_AUTHOR_FULL }}{% EVENT search_results_last_post_author_username_append %}
-				{% if not S_IS_BOT %}<a title="{{ lang('FORUMLIST_LASTPOST') }}" href="{{ similar.U_LAST_POST }}"><i class="mobile-post fa fa-sign-out"></i></a>{% endif %}
-				<br /><small><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time></small>
-			 </span>
-			</td>
-	    </tr>
-		{% EVENT search_results_topic_after %}
-	  {% endfor %}
-	 </tbody>
-	</table>
-</div>
-{% endif %}
diff --git "[ORIGINAL]/leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "[ORIGINAL]/leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+++ /dev/null
@@ -1,9 +0,0 @@
-{% if S_SIMILAR_TOPICS %}
-<div class="control-group">
-	<label class="control-label" for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label>
-	<div class="controls controls-row">
-	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics1">{{ lang('YES') }}</label></div>
-	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics0">{{ lang('NO') }}</label></div>
-    </div>
-</div>
-{% endif %}
diff --git "[ORIGINAL]/leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html" "[ORIGINAL]/leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\similartopicsextras/vse_styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
+++ /dev/null
@@ -1,75 +0,0 @@
-	{% if loops.similar|length %}
-	<div class="panel panel-forum">
-	<div class="panel-heading">
-	 {{ lang('SIMILAR_TOPICS') }}
-	</div>
-	<div class="panel-inner">
-	<table class="footable table table-striped table-primary table-hover">
-	<thead>
-		<tr>
-			<th data-class="expand">{{ lang('TOPICS') }}</th>
-			<th class="large110" data-hide="phone">{{ lang('TOPICS_POSTS_STATISTICS') }}</th>
-			<th class="large21" data-hide="phone">{{ lang('LAST_POST') }}</th>
-		</tr>
-	</thead>
-	<tbody>
-		{% for similar in loops.similar %}
-		{% EVENT search_results_topic_before %}
-		<tr>
-			<td>
-				{% if similar.TOPIC_ICON_IMG %}
-				<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ similar.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
-				{% endif %}
-				<span class="icon-wrapper">
-			    <i class="row-icon-font icon-moon-default2{% if similar.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if similar.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if similar.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if similar.S_HAS_POLL %} icon-moon-poll{% endif %}{% if similar.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
-				</span>
-				<i class="row-icon-font-mini{% if similar.S_TOPIC_LOCKED %} icon-moon-lock forumview-lock{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
-				<div class="desc-wrapper">
-				{% EVENT topiclist_row_prepend %}
-				{% for bb_prefix in similar.BB_PREFIXES %} <span>{{ bb_prefix }}</span>{% endfor %}
-				{% if similar.S_UNREAD_TOPIC and not S_IS_BOT %}<a href="{{ similar.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>{% endif %}{% EVENT topiclist_row_topic_title_before %}<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a>
-				{% if similar.S_TOPIC_UNAPPROVED or similar.S_POSTS_UNAPPROVED %}<a href="{{ similar.U_MCP_QUEUE }}" title="{{ lang('TOPICS_ROW_NOT_APPROVED') }}">&nbsp;<i class="fa fa-question-circle"></i></a>{% endif %}
-				{% if similar.S_TOPIC_REPORTED %}<a href="{{ similar.U_MCP_REPORT }}" title="{{ lang('TOPICS_ROW_REPORTED') }}">&nbsp;<i class="fa fa-exclamation-circle text-danger"></i></a>{% endif %}
-				{% if similar.pagination|length %}
-					<ul class="pagination pagination-forum pagination-xs pull-right hidden-sm hidden-xs">
-						{% for pagination in similar.pagination %}
-						 {% if pagination.S_IS_PREV %}
-						 {% elseif pagination.S_IS_CURRENT %}<li class="active">{{ pagination.PAGE_NUMBER }}</li>
-						 {% elseif pagination.S_IS_ELLIPSIS %}<li class="ellipsis"><a>{{ lang('ELLIPSIS') }}</a></li>
-						 {% elseif pagination.S_IS_NEXT %}
-						 {% else %}
-						 <li><a href="{{ pagination.PAGE_URL }}">{{ pagination.PAGE_NUMBER }}</a></li>
-						 {% endif %}
-						{% endfor %}
-					</ul>		
-				{% endif %}
-				{% EVENT topiclist_row_topic_title_after %}
-				<br />
-				{% if similar.ATTACH_ICON_IMG %}<i class="fa fa-paperclip fa-flip-horizontal" title="{{ lang('ATTACH_FORUM') }}"></i>{% endif %}
-				{% EVENT topiclist_row_topic_by_author_before %}
-				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_topic_author_username_prepend %}{{ similar.TOPIC_AUTHOR_FULL }}{% EVENT search_results_topic_author_username_append %}&nbsp;
-				<small>&#45;&nbsp;<time datetime="{{ similar.FIRST_POST_TIME_RFC3339 }}">{{ similar.FIRST_POST_TIME }}</time>&nbsp;&nbsp;&#45;&nbsp;{{ lang('IN') ~ lang('COLON') }}&nbsp;<a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a></small>
-				{% EVENT topiclist_row_topic_by_author_after %}
-				{% EVENT topiclist_row_append %}
-				</div>
-			</td>
-			<td class="stats-col">
-			 <span class="stats-wrapper">
-			 {{ similar.TOPIC_REPLIES }}&nbsp;{{ lang('REPLIES') }}&nbsp;<br />{{ similar.TOPIC_VIEWS }}&nbsp;{{ lang('VIEWS') }}
-			 </span>
-			</td>
-			<td> 
-			 <span class="last-wrapper text-overflow">
-				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_last_post_author_username_prepend %}{{ similar.LAST_POST_AUTHOR_FULL }}{% EVENT search_results_last_post_author_username_append %}
-				{% if not S_IS_BOT %}<a title="{{ lang('FORUMLIST_LASTPOST') }}" href="{{ similar.U_LAST_POST }}"><i class="mobile-post fa fa-sign-out"></i></a>{% endif %}
-				<br /><small><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time></small>
-			 </span>
-			</td>
-		</tr>
-		{% EVENT search_results_topic_after %}
-	{% endfor %}
-	</tbody>
-	</table>
-	</div>
-	</div>
-	{% endif %}
```
