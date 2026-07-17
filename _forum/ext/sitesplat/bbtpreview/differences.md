Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/sitesplat\\bbtpreview/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bbtpreview/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbtpreview/diff_full.tmp"
@@ -0,0 +1,123 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/event/listener.php"
+index 72e9f8ced..14f094ae6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/event/listener.php"
+@@ -55,8 +55,8 @@ class listener implements EventSubscriberInterface
+ 	{
+ 		$this->user->add_lang_ext('sitesplat/bbtpreview', 'bbtpreview');
+ 
+-		$bbtpreview = false;
+-		if (isset($event['row']['bbpoints_payed']) && $event['row']['bbpoints_payed'])
++		$bbtpreview = true;
++		/*if (isset($event['row']['bbpoints_payed']) && $event['row']['bbpoints_payed'])
+ 		{
+ 			$manager = $this->container->get('ext.manager');
+ 			if ($manager->is_enabled('sitesplat/bbpoints'))
+@@ -78,7 +78,7 @@ class listener implements EventSubscriberInterface
+ 		} else
+ 		{
+ 			$bbtpreview = true;	
+-		}
++		}*/
+ 		
+ 		$template_data = $event['topic_row'];
+ 		$template_data['BBTPREVIEW'] = $bbtpreview;
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/language/en/info_acp_bbtpreview.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/language/en/info_acp_bbtpreview.php"
+index 526e789c4..dab3b04a6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/language/en/info_acp_bbtpreview.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/language/en/info_acp_bbtpreview.php"
+@@ -19,5 +19,5 @@ if (empty($lang) || !is_array($lang))
+ }
+ 
+ $lang = array_merge($lang, array(
+-	'BBTPREVIEW_NOTICE'	=> '<div style="auto;margin:20px auto;"><p>There are no specific settings for this extension. Mouse hover the topic list to discover the magnify glass button for the topic preview. Enjoy!</p></div>',
++	'BBTPREVIEW_NOTICE'	=> '<div style="width:auto;margin:20px auto;"><p>There are no specific settings for this extension. Mouse hover the topic list to discover the magnify glass button for the topic preview. Enjoy!</p></div>',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/BBOOTS/template/js/bbtpreview.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/BBOOTS/template/js/bbtpreview.js"
+index 4c9451b3c..ac7e47356 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/BBOOTS/template/js/bbtpreview.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/BBOOTS/template/js/bbtpreview.js"
+@@ -14,7 +14,6 @@ $(document).on("click", ".open-bbtpreview", function (event) {
+ 		url: sitesplat_board_url + 'app.php/bbtpreview/topic.html?t=' + topicid + in_bbtag + '&time=' + String(hack.getTime()),
+ 		context: document.getElementById("BBTPreviewProfile"),
+ 		error: function (e, text, ee) {
+-	//		console.log('error');
+ 		},
+ 		success: function (s, x) {
+ 			$(".modal-header #modal-title").html( s.subject );
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/css/bbtpreview.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/css/bbtpreview.css"
+index 461e9ed61..a193dcc54 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/css/bbtpreview.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/css/bbtpreview.css"
+@@ -16,7 +16,8 @@
+ .topic-preview.touch {
+     opacity: 1;
+ }
+-.table-hover > tbody > tr:hover > td .topic-preview {
++.table-hover > tbody > tr:hover > td .topic-preview,
++li.double-space > div.desc-wrapper:hover .topic-preview {
+     opacity: 1;
+ 	transition: all 0.3s linear 0s;
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
+index 417fd6540..84608b216 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
+@@ -1,4 +1,4 @@
+-{% if topicrow or searchresults or BB_LOAD_IN_POSTING %}
++{% if topicrow or searchresults or BB_LOAD_IN_POSTING or SCRIPT_NAME eq 'app/portal' %}
+ 	<!-- INCLUDEJS @sitesplat_bbtpreview/js/bbtpreview.js -->
+ 	<div class="modal fade" id="BBTPreviewDialog" tabindex="-1" role="dialog" aria-hidden="true">
+ 		<div class="modal-dialog modal-bbpreview">
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+index c0b728901..93fb2c3ee 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+@@ -1,3 +1,3 @@
+-{% if topicrow or searchresults or BB_LOAD_IN_POSTING %}
++{% if topicrow or searchresults or BB_LOAD_IN_POSTING or SCRIPT_NAME eq 'app/portal' %}
+ 	<!-- INCLUDECSS @sitesplat_bbtpreview/css/bbtpreview.css -->
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append.html"
+index a4624208c..ea88bb9ee 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append.html"
+@@ -1,6 +1,6 @@
+-<!-- IF topicrow.BBTPREVIEW or searchresults -->
++{% if topicrow.BBTPREVIEW or searchresults or BB_LOAD_IN_POSTING or SCRIPT_NAME eq 'portal' %}
+ <a data-toggle="modal" data-id="{topicrow.TOPIC_ID}{searchresults.TOPIC_ID}" href="#BBTPreviewDialog" class="btn btn-xs open-bbtpreview topic-preview hidden-xs" title=""><i class="fa fa-search-plus"></i></a>
+ <span class="visible-xs">
+ 	<a data-toggle="modal" data-id="{topicrow.TOPIC_ID}{searchresults.TOPIC_ID}" href="#BBTPreviewDialog" class="btn-xs open-bbtpreview" title="">{L_PREVIEW}</a>
+ </span>
+-<!-- ENDIF -->
+\ No newline at end of file
++{% endif %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append_portal.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append_portal.html"
+new file mode 100644
+index 000000000..7fa514786
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append_portal.html"
+@@ -0,0 +1,6 @@
++{% if topicrow.BBTPREVIEW or searchresults or BB_LOAD_IN_POSTING %}
++<a data-toggle="modal" data-id="{topicrow.TOPIC_ID}{searchresults.TOPIC_ID}" href="#BBTPreviewDialog" class="btn btn-xs open-bbtpreview topic-preview hidden-xs" title=""><i class="fa fa-search-plus"></i></a>
++<span class="visible-xs">
++	<a data-toggle="modal" data-id="{topicrow.TOPIC_ID}{searchresults.TOPIC_ID}" href="#BBTPreviewDialog" class="btn-xs open-bbtpreview" title="">{L_PREVIEW}</a>
++</span>
++{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/js/bbtpreview.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/js/bbtpreview.js"
+index 4c9451b3c..ac7e47356 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/js/bbtpreview.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/js/bbtpreview.js"
+@@ -14,7 +14,6 @@ $(document).on("click", ".open-bbtpreview", function (event) {
+ 		url: sitesplat_board_url + 'app.php/bbtpreview/topic.html?t=' + topicid + in_bbtag + '&time=' + String(hack.getTime()),
+ 		context: document.getElementById("BBTPreviewProfile"),
+ 		error: function (e, text, ee) {
+-	//		console.log('error');
+ 		},
+ 		success: function (s, x) {
+ 			$(".modal-header #modal-title").html( s.subject );
diff --git "[FORUM_EXT]/sitesplat\\bbtpreview/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bbtpreview/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbtpreview/diff_nospace.tmp"
@@ -0,0 +1,102 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/diff_full.tmp"
+new file mode 100644
+index 000000000..804b20900
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/diff_full.tmp"
+@@ -0,0 +1,123 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/event/listener.php"
++index 72e9f8ced..14f094ae6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/event/listener.php"
++@@ -55,8 +55,8 @@ class listener implements EventSubscriberInterface
++ 	{
++ 		$this->user->add_lang_ext('sitesplat/bbtpreview', 'bbtpreview');
++ 
++-		$bbtpreview = false;
++-		if (isset($event['row']['bbpoints_payed']) && $event['row']['bbpoints_payed'])
+++		$bbtpreview = true;
+++		/*if (isset($event['row']['bbpoints_payed']) && $event['row']['bbpoints_payed'])
++ 		{
++ 			$manager = $this->container->get('ext.manager');
++ 			if ($manager->is_enabled('sitesplat/bbpoints'))
++@@ -78,7 +78,7 @@ class listener implements EventSubscriberInterface
++ 		} else
++ 		{
++ 			$bbtpreview = true;	
++-		}
+++		}*/
++ 		
++ 		$template_data = $event['topic_row'];
++ 		$template_data['BBTPREVIEW'] = $bbtpreview;
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/language/en/info_acp_bbtpreview.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/language/en/info_acp_bbtpreview.php"
++index 526e789c4..dab3b04a6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/language/en/info_acp_bbtpreview.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/language/en/info_acp_bbtpreview.php"
++@@ -19,5 +19,5 @@ if (empty($lang) || !is_array($lang))
++ }
++ 
++ $lang = array_merge($lang, array(
++-	'BBTPREVIEW_NOTICE'	=> '<div style="auto;margin:20px auto;"><p>There are no specific settings for this extension. Mouse hover the topic list to discover the magnify glass button for the topic preview. Enjoy!</p></div>',
+++	'BBTPREVIEW_NOTICE'	=> '<div style="width:auto;margin:20px auto;"><p>There are no specific settings for this extension. Mouse hover the topic list to discover the magnify glass button for the topic preview. Enjoy!</p></div>',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/BBOOTS/template/js/bbtpreview.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/BBOOTS/template/js/bbtpreview.js"
++index 4c9451b3c..ac7e47356 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/BBOOTS/template/js/bbtpreview.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/BBOOTS/template/js/bbtpreview.js"
++@@ -14,7 +14,6 @@ $(document).on("click", ".open-bbtpreview", function (event) {
++ 		url: sitesplat_board_url + 'app.php/bbtpreview/topic.html?t=' + topicid + in_bbtag + '&time=' + String(hack.getTime()),
++ 		context: document.getElementById("BBTPreviewProfile"),
++ 		error: function (e, text, ee) {
++-	//		console.log('error');
++ 		},
++ 		success: function (s, x) {
++ 			$(".modal-header #modal-title").html( s.subject );
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/css/bbtpreview.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/css/bbtpreview.css"
++index 461e9ed61..a193dcc54 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/css/bbtpreview.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/css/bbtpreview.css"
++@@ -16,7 +16,8 @@
++ .topic-preview.touch {
++     opacity: 1;
++ }
++-.table-hover > tbody > tr:hover > td .topic-preview {
+++.table-hover > tbody > tr:hover > td .topic-preview,
+++li.double-space > div.desc-wrapper:hover .topic-preview {
++     opacity: 1;
++ 	transition: all 0.3s linear 0s;
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
++index 417fd6540..84608b216 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
++@@ -1,4 +1,4 @@
++-{% if topicrow or searchresults or BB_LOAD_IN_POSTING %}
+++{% if topicrow or searchresults or BB_LOAD_IN_POSTING or SCRIPT_NAME eq 'app/portal' %}
++ 	<!-- INCLUDEJS @sitesplat_bbtpreview/js/bbtpreview.js -->
++ 	<div class="modal fade" id="BBTPreviewDialog" tabindex="-1" role="dialog" aria-hidden="true">
++ 		<div class="modal-dialog modal-bbpreview">
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++index c0b728901..93fb2c3ee 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++@@ -1,3 +1,3 @@
++-{% if topicrow or searchresults or BB_LOAD_IN_POSTING %}
+++{% if topicrow or searchresults or BB_LOAD_IN_POSTING or SCRIPT_NAME eq 'app/portal' %}
++ 	<!-- INCLUDECSS @sitesplat_bbtpreview/css/bbtpreview.css -->
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append.html"
++index a4624208c..ea88bb9ee 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append.html"
++@@ -1,6 +1,6 @@
++-<!-- IF topicrow.BBTPREVIEW or searchresults -->
+++{% if topicrow.BBTPREVIEW or searchresults or BB_LOAD_IN_POSTING or SCRIPT_NAME eq 'portal' %}
++ <a data-toggle="modal" data-id="{topicrow.TOPIC_ID}{searchresults.TOPIC_ID}" href="#BBTPreviewDialog" class="btn btn-xs open-bbtpreview topic-preview hidden-xs" title=""><i class="fa fa-search-plus"></i></a>
++ <span class="visible-xs">
++ 	<a data-toggle="modal" data-id="{topicrow.TOPIC_ID}{searchresults.TOPIC_ID}" href="#BBTPreviewDialog" class="btn-xs open-bbtpreview" title="">{L_PREVIEW}</a>
++ </span>
++-<!-- ENDIF -->
++\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bbtpreview/event/listener.php" "[FORUM_EXT]/sitesplat\\bbtpreview/event/listener.php"
--- "[ORIGINAL]/sitesplat\\bbtpreview/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\bbtpreview/event/listener.php"
@@ -55,8 +55,8 @@ class listener implements EventSubscriberInterface
 	{
 		$this->user->add_lang_ext('sitesplat/bbtpreview', 'bbtpreview');
 
-		$bbtpreview = false;
-		if (isset($event['row']['bbpoints_payed']) && $event['row']['bbpoints_payed'])
+		$bbtpreview = true;
+		/*if (isset($event['row']['bbpoints_payed']) && $event['row']['bbpoints_payed'])
 		{
 			$manager = $this->container->get('ext.manager');
 			if ($manager->is_enabled('sitesplat/bbpoints'))
@@ -78,7 +78,7 @@ class listener implements EventSubscriberInterface
 		} else
 		{
 			$bbtpreview = true;	
-		}
+		}*/
 		
 		$template_data = $event['topic_row'];
 		$template_data['BBTPREVIEW'] = $bbtpreview;
diff --git "[ORIGINAL]/sitesplat\\bbtpreview/language/en/info_acp_bbtpreview.php" "[FORUM_EXT]/sitesplat\\bbtpreview/language/en/info_acp_bbtpreview.php"
--- "[ORIGINAL]/sitesplat\\bbtpreview/language/en/info_acp_bbtpreview.php"
+++ "[FORUM_EXT]/sitesplat\\bbtpreview/language/en/info_acp_bbtpreview.php"
@@ -19,5 +19,5 @@ if (empty($lang) || !is_array($lang))
 }
 
 $lang = array_merge($lang, array(
-	'BBTPREVIEW_NOTICE'	=> '<div style="auto;margin:20px auto;"><p>There are no specific settings for this extension. Mouse hover the topic list to discover the magnify glass button for the topic preview. Enjoy!</p></div>',
+	'BBTPREVIEW_NOTICE'	=> '<div style="width:auto;margin:20px auto;"><p>There are no specific settings for this extension. Mouse hover the topic list to discover the magnify glass button for the topic preview. Enjoy!</p></div>',
 ));
diff --git "[ORIGINAL]/sitesplat\\bbtpreview/styles/BBOOTS/template/js/bbtpreview.js" "[FORUM_EXT]/sitesplat\\bbtpreview/styles/BBOOTS/template/js/bbtpreview.js"
--- "[ORIGINAL]/sitesplat\\bbtpreview/styles/BBOOTS/template/js/bbtpreview.js"
+++ "[FORUM_EXT]/sitesplat\\bbtpreview/styles/BBOOTS/template/js/bbtpreview.js"
@@ -14,7 +14,6 @@ $(document).on("click", ".open-bbtpreview", function (event) {
 		url: sitesplat_board_url + 'app.php/bbtpreview/topic.html?t=' + topicid + in_bbtag + '&time=' + String(hack.getTime()),
 		context: document.getElementById("BBTPreviewProfile"),
 		error: function (e, text, ee) {
-	//		console.log('error');
 		},
 		success: function (s, x) {
 			$(".modal-header #modal-title").html( s.subject );
diff --git "[ORIGINAL]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/css/bbtpreview.css" "[FORUM_EXT]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/css/bbtpreview.css"
--- "[ORIGINAL]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/css/bbtpreview.css"
+++ "[FORUM_EXT]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/css/bbtpreview.css"
@@ -16,7 +16,8 @@
 .topic-preview.touch {
     opacity: 1;
 }
-.table-hover > tbody > tr:hover > td .topic-preview {
+.table-hover > tbody > tr:hover > td .topic-preview,
+li.double-space > div.desc-wrapper:hover .topic-preview {
     opacity: 1;
 	transition: all 0.3s linear 0s;
 }
diff --git "[ORIGINAL]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_footer_after.html" "[FORUM_EXT]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
--- "[ORIGINAL]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
+++ "[FORUM_EXT]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
@@ -1,4 +1,4 @@
-{% if topicrow or searchresults or BB_LOAD_IN_POSTING %}
+{% if topicrow or searchresults or BB_LOAD_IN_POSTING or SCRIPT_NAME eq 'app/portal' %}
 	<!-- INCLUDEJS @sitesplat_bbtpreview/js/bbtpreview.js -->
 	<div class="modal fade" id="BBTPreviewDialog" tabindex="-1" role="dialog" aria-hidden="true">
 		<div class="modal-dialog modal-bbpreview">
diff --git "[ORIGINAL]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "[FORUM_EXT]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
--- "[ORIGINAL]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+++ "[FORUM_EXT]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
@@ -1,3 +1,3 @@
-{% if topicrow or searchresults or BB_LOAD_IN_POSTING %}
+{% if topicrow or searchresults or BB_LOAD_IN_POSTING or SCRIPT_NAME eq 'app/portal' %}
 	<!-- INCLUDECSS @sitesplat_bbtpreview/css/bbtpreview.css -->
 {% endif %}
diff --git "[ORIGINAL]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append.html" "[FORUM_EXT]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append.html"
--- "[ORIGINAL]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append.html"
+++ "[FORUM_EXT]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append.html"
@@ -1,6 +1,6 @@
-<!-- IF topicrow.BBTPREVIEW or searchresults -->
+{% if topicrow.BBTPREVIEW or searchresults or BB_LOAD_IN_POSTING or SCRIPT_NAME eq 'portal' %}
 <a data-toggle="modal" data-id="{topicrow.TOPIC_ID}{searchresults.TOPIC_ID}" href="#BBTPreviewDialog" class="btn btn-xs open-bbtpreview topic-preview hidden-xs" title=""><i class="fa fa-search-plus"></i></a>
 <span class="visible-xs">
 	<a data-toggle="modal" data-id="{topicrow.TOPIC_ID}{searchresults.TOPIC_ID}" href="#BBTPreviewDialog" class="btn-xs open-bbtpreview" title="">{L_PREVIEW}</a>
 </span>
-<!-- ENDIF -->
\ No newline at end of file
+{% endif %}
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append_portal.html" "[FORUM_EXT]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append_portal.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/event/topiclist_row_append_portal.html"
@@ -0,0 +1,6 @@
+{% if topicrow.BBTPREVIEW or searchresults or BB_LOAD_IN_POSTING %}
+<a data-toggle="modal" data-id="{topicrow.TOPIC_ID}{searchresults.TOPIC_ID}" href="#BBTPreviewDialog" class="btn btn-xs open-bbtpreview topic-preview hidden-xs" title=""><i class="fa fa-search-plus"></i></a>
+<span class="visible-xs">
+	<a data-toggle="modal" data-id="{topicrow.TOPIC_ID}{searchresults.TOPIC_ID}" href="#BBTPreviewDialog" class="btn-xs open-bbtpreview" title="">{L_PREVIEW}</a>
+</span>
+{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/js/bbtpreview.js" "[FORUM_EXT]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/js/bbtpreview.js"
--- "[ORIGINAL]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/js/bbtpreview.js"
+++ "[FORUM_EXT]/sitesplat\\bbtpreview/styles/FLATBOOTS/template/js/bbtpreview.js"
@@ -14,7 +14,6 @@ $(document).on("click", ".open-bbtpreview", function (event) {
 		url: sitesplat_board_url + 'app.php/bbtpreview/topic.html?t=' + topicid + in_bbtag + '&time=' + String(hack.getTime()),
 		context: document.getElementById("BBTPreviewProfile"),
 		error: function (e, text, ee) {
-	//		console.log('error');
 		},
 		success: function (s, x) {
 			$(".modal-header #modal-title").html( s.subject );
```
