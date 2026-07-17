Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/sitesplat\\snappy/diff_full.tmp" "[FORUM_EXT]/sitesplat\\snappy/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\snappy/diff_full.tmp"
@@ -0,0 +1,376 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/event/listener.php"
+index 235c15d3f..2b0da698b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/event/listener.php"
+@@ -149,6 +149,14 @@ class listener implements EventSubscriberInterface
+ 			'S_SNAPPY'				=> true,
+ 			));
+ 		
++		if ($this->ext_manager->is_enabled('sitesplat/imgur'))
++		{
++			$this->user->add_lang_ext('sitesplat/imgur', 'imgur');
++			$this->template->assign_vars(array(
++				'IN_IMGUR'	=> ($this->config['imgur_clientid'] && $this->config['imgur_quickreply']) ? true : false,
++			));
++		}
++
+ 		if ($this->ext_manager->is_enabled('sitesplat/gyazo'))
+ 		{
+ 			$this->user->add_lang_ext('sitesplat/gyazo', 'gyazo');
+@@ -168,6 +176,24 @@ class listener implements EventSubscriberInterface
+ 
+ 	public function load_config_on_setup($event)
+ 	{
++		if ($event['mode'] == 'attach' && $this->ext_manager->is_enabled('sitesplat/imgur'))
++		{
++			$this->user->add_lang_ext('sitesplat/imgur', 'imgur');
++			$display_vars = $event['display_vars'];
++
++			$add_imgur_var = array(
++				'imgur_quickreply' =>
++					array(
++						'lang'		=> 'IMGUR_QUICKREPLY',
++						'validate'	=> 'bool',
++						'type' 		=> 'radio:yes_no',
++						'explain' => false),
++			);
++
++			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $add_imgur_var, array('before' =>'display_order'));
++			$event['display_vars'] = array('title' => $display_vars['title'], 'vars' => $display_vars['vars']);
++		}
++
+ 		if ($event['mode'] == 'attach' && $this->ext_manager->is_enabled('sitesplat/gyazo'))
+ 		{
+ 			$this->user->add_lang_ext('sitesplat/gyazo', 'gyazo');
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/language/en/info_acp_snappy.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/language/en/info_acp_snappy.php"
+index a29220991..253dac6ee 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/language/en/info_acp_snappy.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/language/en/info_acp_snappy.php"
+@@ -20,7 +20,7 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, array(
+ 	
+ 	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+-	'SNAPPY_NOTICE'				    => '<div style="width:auto;margin:20px auto;"><p>There are no specific settings for this extension. Remember to enable the phpBB quick reply option in: <strong>%1$s &#187; %2$s &#187; %3$s "Allow quick reply".</strong><br />Please note, if you have the <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=62" target="_blank">GYAZO</a> extension installed you can also enable or disable the GYAZO option in quick reply.<br />The option is in: <strong>ACP &#187; General &#187; Board configuration &#187; Attachment settings "Allow GYAZO in Smart Snappy Reply"</strong></p></div>',
++	'SNAPPY_NOTICE'				    => '<div style="width:auto;margin:20px auto;"><p>There are no specific settings for this extension. Remember to enable the phpBB quick reply option in: <strong>%1$s &#187; %2$s &#187; %3$s "Allow quick reply".</strong><br />Please note, if you have the <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=23" target="_blank">IMGUR</a> extensions installed you can also enable or disable the IMGUR option in quick reply and if you have the <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=62" target="_blank">GYAZO</a> extension installed you can also enable or disable the GYAZO option in quick reply.<br />The option is in: <strong>ACP &#187; General &#187; Board configuration &#187; Attachment settings "Allow IMGUR/GYAZO in Smart Snappy Reply"</strong></p></div>',
+ 	
+ ));
+ 
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/migrations/v31x/m1_add_imgur_quickreply.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/migrations/v31x/m1_add_imgur_quickreply.php"
+new file mode 100644
+index 000000000..2fcab622d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/migrations/v31x/m1_add_imgur_quickreply.php"
+@@ -0,0 +1,36 @@
++<?php
++/**
++*
++* Snappy Smart Reply
++*
++* @copyright (c) 2015 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
++
++namespace sitesplat\snappy\migrations\v31x;
++
++/**
++* Migration stage 1: Initial data changes to the files
++*/
++class m1_add_imgur_quickreply extends \phpbb\db\migration\migration
++{
++	/**
++	 * Assign migration file dependencies for this migration
++	 *
++	 * @return array Array of migration files
++	 * @static
++	 * @access public
++	 */
++	static public function depends_on()
++	{
++		return array('\sitesplat\snappy\migrations\v31x\m1_initial_config');
++	}
++
++	public function update_data()
++	{
++		return array(
++			array('config.add', array('imgur_quickreply', true)),
++		);
++	}
++}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/BBOOTS/template/snappy_reply_buttons.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/BBOOTS/template/snappy_reply_buttons.html"
+index 930037ee2..c4ef0febe 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/BBOOTS/template/snappy_reply_buttons.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/BBOOTS/template/snappy_reply_buttons.html"
+@@ -96,13 +96,13 @@
+ 	<!-- IF S_SHOW_ATTACH_BTN --> 
+ 	<button type="button" class="btn btn-default" value="{L_PLUPLOAD_ADD_FILES}" id="add_files"><i class="fa fa-cloud-upload"></i>&nbsp;{L_PLUPLOAD_ADD_FILES}</button>
+     <!-- ENDIF -->
+-	<!-- IF IN_GYAZO -->
++	<!-- IF IN_IMGUR -->
+ 		<div class="fileinput fileinput-new" data-provides="fileinput">
+-			<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="document.getElementById('postform').action += '#gyazoAnchor';"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_GYAZO_UPLOAD}</button>
++			<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="document.getElementById('postform').action += '#imgurAnchor';"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_IMGUR_UPLOAD}</button>
+ 			<span class="btn btn-default btn-file">
+-				<span class="fileinput-new"><i class="fa fa-gyazo"></i></span>
++				<span class="fileinput-new"><i class="fa fa-imgur"></i></span>
+ 				<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
+-				<input type="file" name="gyazo" id="gyazo" />
++				<input type="file" name="imgur" id="imgur" />
+ 			</span>
+ 			<i class="fa fa-picture-o fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
+ 			<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float: none"><i class="fa fa-times"></i></a>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/css/snappy.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/css/snappy.css"
+index 8a911becd..446655e7b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/css/snappy.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/css/snappy.css"
+@@ -49,7 +49,7 @@ article:hover .btn-snappy {
+     position: absolute;
+     right: -15px;
+     top: 0;
+-    width: 270px;
++    width: 375px;
+     z-index: 1;
+ }
+ 
+@@ -65,6 +65,17 @@ article:hover .btn-snappy {
+ }
+ 
+ 
++.fa-imgur::before {
++    background: #85bf25;
++    border-radius: 50%;
++    color: #85bf25;
++    content: "";
++    display: inline-block;
++    height: 16px;
++    vertical-align: top;
++    width: 16px;
++}
++
+ .fa-gyazo::before {
+   background: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDI0IiBoZWlnaHQ9IjEwMjQiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIG1lZXQiIHhtbG5zOnY9Imh0dHBzOi8vdmVjdGEuaW8vbmFubyI+PHBhdGggZD0iTTExNy40IDI0NC43TDMyLjIgNzYuMmMtLjctLjItMS4yLjMtMS4yIDEuMnMtLjQgMS42LTEgMS42Yy0uNSAwLTEgLjctMSAxLjVzLS40IDEuNS0xIDEuNWMtLjUgMC0xIC43LTEgMS41IDAgLjktMSAxLjUtMi42IDEuNS0zLjMgMC0zLS44IDQuNS0xMS44IDIyLjktMzMuNCA1NS44LTU2LjggOTQuNS02Ny4zQzE0NC42LjIgMTA4LjIuNiA1ODUuNS40bDQzOC0uMy00MDkuMyAyMDQuNy00MDguOCAyMDYuNWMuMyAxLjItLjIgMS43LTEuNyAxLjYtMS45LS4xLTE0LjUtMjQuOC04Ni4zLTE2OC4yek0xNi4xIDk1LjNjMS40LTMuOCA0LjItOC4zIDUuMS04LjMgMS4yIDAgMSA1LjYtLjQgOC41LS43IDEuNi0xLjkgMi41LTMuNCAyLjUtMi4xIDAtMi4zLS4zLTEuMy0yLjd6IiBmaWxsPSIjODRiOGZlIi8+PHBhdGggZD0iTTE2LjMgOTI5LjNDOCA5MTEuNSAzLjIgODk0LjcgMSA4NzVjLS44LTYuNy0xLTExNi4zLS44LTM2OS41bC4zLTM2MCAyLjctMTIuMUM4IDExMiAxNi41IDkyIDI3LjkgNzUuMWw1LTcuNCAyIDMuNGM2LjIgOS45IDM0NS4yIDY5MC40IDM0NC45IDY5Mi4yLS4yIDEuNy0zMi40IDE4LTE3Ni4zIDg5LjNMMjQuNCA5MzkuOWMtMyAuMS0zLjMtLjMtOC4xLTEwLjZ6IiBmaWxsPSIjNTk5MmZmIi8+PHBhdGggZD0iTTE0NC41IDEwMjIuOWMtMTYuNC0yLjEtMzYuNi04LjUtNTMuNS0xNi45LTkuNS00LjctMjMuNS0xMy43LTI2LjQtMTYuOS0xLjctMS45LTEuNy0yLjEtLjItMi4xLjkgMCA2MC42LTI5LjMgMTMyLjYtNjUuMmwxMzEtNjYuN2MwLTEuMSAxMi03LjYgMzguNS0yMC45IDM1LjktMTcuOSA0MS41LTIwLjQgNDEuNS0xOC40LjEgMy45IDUuMyAxLjUgMTcxLjUtODEuM2wxNzAtODQuMyA5MC44IDE3NC45IDkwLjcgMTc4LjFjMCAzLjMtLjMgMy42LTYuOCA2LjctMTQuOCA2LjgtMzEuNiAxMS4yLTUwLjEgMTMtMTIuOCAxLjQtNzE5LjEgMS4zLTcyOS42IDB6IiBmaWxsPSIjMWQ1Y2ZlIi8+PHBhdGggZD0iTTk4Ni45IDk1OC43Qzk4NSA5NTcuMiA4MTYgNjIwLjggODE2IDYxOC40YzAtLjkuNy0yLjIgMS42LTIuOCAxLjQtMS4xLTMuNi0xMS42LTQwLjUtODUuNEw3MzUgNDQ2aDE0NC41SDEwMjR2MjEwLjlsLTEuNSAyMjIuNGMtMy40IDI2LjEtMTEuNiA0OC0yNi4zIDcwLjMtMy4zIDUuMS02LjQgOS40LTYuOSA5LjctLjQuMy0xLjUgMC0yLjQtLjZ6IiBmaWxsPSIjMDAyYWI1Ii8+PHBhdGggZD0iTTE0NC41IDEwMjIuOWMtMTYuNS0yLjEtMzYuOC04LjUtNTMuNS0xNi45LTEyLjctNi4zLTI3LTE2LjEtMjctMTguMyAwLTEuNSAzNDIuMi0xNzEuOCAzNDMuOS0xNzEuMiAxLjEuNS0xMS42IDcuMy0zNy42IDIwLjMtMjEuNiAxMC44LTM5LjMgMjAtMzkuMyAyMC40IDAgLjcgOTQuMy00NS44IDE4My45LTkwLjZsNDkuNy0yNC4zYy4yLjItMTExIDU1LjktMjQ3LjEgMTIzLjhMNzAgOTkwLjNjMCAxLjIgMTEuNyA4LjMgMjIuNSAxMy42IDEwLjUgNS4yIDE2LjEgNy41IDIzLjMgOS41IDIuNC43IDQuNyAxLjcgNSAyLjIuNC41IDEuNiAxIDIuNyAxIDIuNy4yIDExLjkgMS43IDE5IDMuMSAxLjcuMyAxNjMuNC44IDM1OS41IDFsMzg3LTMuM2MxNi42LTMuNSAzOS42LTEyLjQgMzguNi0xNS4xLS4zLS43LTQxLjItNzkuNi05MC45LTE3NS4ybC05MC4zLTE3My45LTMxLjUgMTUuMi01NC42IDI2LjktMjQgMTEuNmMtLjUgMCA0MC4zLTIwLjYgOTAuNi00NS44bDkxLjMtNDUuNyAzNC40IDY4LjggMzUuNSA2OC44Yy41IDAgLjcuNC40IDEtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMS0uMSAxIC41IDEgLjguNC41IDEtLjEgMSAuNSAxIC44LjQuNSAxLS4xIDEgLjUgMSAuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNC41IDEtLjEgMSAuNSAxIC44LjUuNSAxLS4xIDEgLjUgMSAuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMS0uMSAxIC41IDEgLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxLS4xIDEgLjUgMSAuOC40LjUgMS0uMSAxIC41IDEgLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxLS4xIDEgLjUgMSAuOC40LjUgMS0uMSAxIC41IDEgLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDEtLjEgMSAuNSAxIC44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxLS4xIDEgLjUgMSAuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC42IDFzLjkuMy42LjdjLS40LjMuMSAxLjIgMSAxLjggMS41IDEuMiAxLjEgMi00LjIgOC41LTEzLjUgMTYuNS0zMy4xIDMyLTUzIDQxLjktMTQuNSA3LjMtMjUuOCAxMS4yLTQxLjkgMTQuOWwtMTIuMSAyLjctMzYzLjUuMWMtMjA2IC4xLTM2Ni41LS4yLTM3MC41LS43eiIgZmlsbD0iIzE3NTFmNSIvPjxwYXRoIGQ9Ik01Ny44IDk4My42Yy0yNS43LTIxLjktNDQuNi01Mi45LTUzLjMtODcuMi0uOC0zLjQtMS41LTctMS41LTggLjEtMS4xIDEuMiAyLjIgMi41IDcuMSAyLjYgMTAuMSA2LjggMjIgOS43IDI4IDIuMSA0LjEgNy45IDEzLjUgOC40IDEzLjUuMyAwIDMxOS41LTE1OCAzNDEuMS0xNjguOGwxMi4xLTYuMS0zLjItNy44Yy0xLjgtNC4zLTYuMS0xMy40LTkuNS0yMC4yLTUuNS0xMC45LTctMTUuNC00LjEtMTIuNS41LjUgMTEuNyAyMi4zIDI0LjkgNDguNGwyNCA0Ny42TDM3MCA4MzdjLTIxLjUgMTAuNy0zOSAxOS44LTM5IDIwLjJDMzMxIDg1OCA2Ny43IDk5MCA2Ni4yIDk5MGMtLjUgMC00LjMtMi45LTguNC02LjR6TTEuMyA4NzZjMC0yLjUuMi0zLjUuNC0yLjJhMTYuOTUgMTYuOTUgMCAwIDEgMCA0LjVjLS4yIDEuMi0uNC4yLS40LTIuM3ptLTEtMTIuNWMwLTQuNC4yLTYuMS40LTMuNy4yIDIuMy4yIDUuOSAwIDgtLjIgMi0uNC4xLS40LTQuM3ptMTg5LjYtNDc3LjZjLTE5LjgtMzkuNy0zMi40LTY1LjktMzEuNC02NS41LjkuMyAxLjkuNiAyLjEuNi4zIDAgLjIuNS0uMSAxLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjkuNC42LjljLS40LjUtLjMgMS4xLjEgMS4zLjcuMyAyMi4zIDQzLjIgMjIuMyA0NC4zIDAgMy42LTcuMS05LjYtMzUuMS02NS42ek01Ny41IDEyMS4yQzQwLjMgODcuMSAzMi4xIDcxLjYgMzEuMSA3MS44Yy0xLjIuMy0xLjIgMC0uMS0xLjIuNy0uOSAxLjYtMS42IDIuMS0xLjZzMTIuNCAyMyAyNi40IDUxYzE0IDI4LjEgMjQuOSA1MSAyNC4zIDUxLS43IDAtMTIuNS0yMi40LTI2LjMtNDkuOHpNLjMgMTYxLjVjMC0zLjguMi01LjMuNC0zLjIuMiAyIC4yIDUuMiAwIDctLjIgMS43LS40LjEtLjQtMy44eiIgZmlsbD0iIzUyODhmNiIvPjwvc3ZnPg==");
+     background-position-x: 0%;
+@@ -79,6 +90,7 @@ article:hover .btn-snappy {
+   background-size: contain;
+ }
+ 
++
+ .fileinput-exists .fa-picture-o {
+     vertical-align: text-bottom;
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_before_absolute.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_before_absolute.html"
+index b06baa6ea..cebaa9672 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_before_absolute.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_before_absolute.html"
+@@ -1,7 +1,7 @@
+ <!-- IF not S_IS_BOT and S_REGISTERED_USER -->
+ <!-- IF postrow.U_QUOTE -->
+ <div class="btn-group btn-group-sm btn-snappy hidden-xs" role="group">
+- <a class="btn btn-sm btn-default" href="javascript:void(0);" onclick="addquote({postrow.POST_ID}, '{postrow.POST_AUTHOR}', '{LA_WROTE}');" title="{L_QUOTE} {postrow.POST_AUTHOR}"><i class="fa fa-comment"></i></a>
++ <a class="btn btn-sm btn-default" href="javascript:void(0);" onclick="addquote({postrow.POST_ID}, '{postrow.POST_AUTHOR}', '{postrow.POSTER_ID}', '{LA_WROTE}');" title="{L_QUOTE} {postrow.POST_AUTHOR}"><i class="fa fa-comment"></i></a>
+  <a class="btn btn-sm btn-default" href="javascript:void(0);" onclick="insert_text('[b]&#64;{postrow.POST_AUTHOR}[/b], ', false);" title="&#64;{postrow.POST_AUTHOR}"><i class="icon-moon-email icon-moon-fx"></i></a>
+ </div>
+ <!-- ENDIF -->
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/js/script.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/js/script.js"
+index 03e68a1ae..491a090b0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/js/script.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/js/script.js"
+@@ -4,11 +4,12 @@ head.ready(function () {
+ "use strict";
+ 
+ 	$(".ccount").characterCounter({
+-        counterFormat: '%1 characters remaining',
++        counterFormat: '%1 caracteres restantes',
+ 		limit: max_post_chars,
+     });
+ 	
+ 	var button = document.getElementById('show_button')
++	if(!button) return;
+     button.addEventListener('click',hideshow,false);
+ 
+     function hideshow() {
+@@ -44,14 +45,14 @@ head.ready(function () {
+ 	});
+ 	
+ 	$('#qr_postform').submit(function() {
+-        localStorage.clear();
++        localStorage.removeItem("TextEditorData");
+     });
+ 	
+ 	//lets clear empty local storage and textarea if needed
+ 	$(".btn-clr").click(function(e) {
+         e.preventDefault();
+         $(".ccount").val('');
+-		localStorage.clear();
++		localStorage.removeItem("TextEditorData");
+     });
+ 	
+ //	$('.panel-qr > .qr-textarea > textarea').on('keyup', function(event) {
+@@ -63,13 +64,13 @@ head.ready(function () {
+ //        }
+ //   });
+    
+-   setInterval(function () {
+-	  if($("#message").val().length >= 1) {
+-		$(".load").removeAttr("disabled");
+-	  } else {
+-		$(".load").attr("disabled", "disabled");
+-	  }
+-	}, 400); //Runs every 0.4s
++	// setInterval(function () {
++	  // if($("#message").val().length >= 1) {
++		// $(".load").removeAttr("disabled");
++	  // } else {
++		// $(".load").attr("disabled", "disabled");
++	  // }
++	// }, 400); //Runs every 0.4s
+    
+    //	$('.toggleModal').on('click', function () {
+    //      $('#col1').toggleClass('col-md-12 col-md-9');
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_quickreply_editor.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_quickreply_editor.html"
+index b77807128..11ebf6f36 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_quickreply_editor.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_quickreply_editor.html"
+@@ -1,7 +1,7 @@
+ <div class="clearfix">
+ 	<form name="qr_postform" id="qr_postform" method="post" action="{U_QR_ACTION}"{S_FORM_ENCTYPE}>
+      <fieldset> 
+-		<div class="row">			
++		<div class="row">
+ 			<div class="col-md-12">
+ 				<div class="text-center">
+ 				  <!-- EVENT quickreply_editor_panel_before -->
+@@ -31,8 +31,8 @@
+ 		              {QR_HIDDEN_FIELDS}
+ 		              <button onclick="document.getElementById('show_button').style.display = 'inline-block';" class="btn btn-default" type="button" data-target=".quick-reply" data-toggle="collapse"><i class="fa fa-times"></i></button>
+                       <a role="button" class="btn btn-default togglesnappy"><i class="fa fa-cog"></i></a>
+-					  <button type="submit" class="btn btn-default load" disabled="disabled" tabindex="7" name="post" value="{L_SUBMIT}" data-loading-text="{L_LOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_SUBMIT}</button>
+-		              <button type="submit" class="btn btn-default load" disabled="disabled" tabindex="6" name="preview" value="{L_FULL_EDITOR}" id="qr_full_editor" data-loading-text="{L_LOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><span class="hidden-xs">{L_FULL_EDITOR}</span><i class="fa fa-search visible-xs"></i></button>		   
++					  <button type="submit" class="btn btn-default load" tabindex="7" name="post" value="{L_SUBMIT}" data-loading-text="{L_LOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_SUBMIT}</button>
++		              <button type="submit" class="btn btn-default load" tabindex="6" name="preview" value="{L_FULL_EDITOR}" id="qr_full_editor" data-loading-text="{L_LOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><span class="hidden-xs">{L_FULL_EDITOR}</span><i class="fa fa-search visible-xs"></i></button>		   
+ 				   </div>
+ 			    </div>
+             </div>
+@@ -45,7 +45,9 @@
+ 				<!-- IF S_NOTIFY_ALLOWED --><div><input type="checkbox" name="notify" id="notify"{S_NOTIFY_CHECKED}><label class="icheck-control" for="notify">{L_NOTIFY_REPLY}</label></div><!-- ENDIF -->
+ 				<!-- IF S_LOCK_TOPIC_ALLOWED --><div><input type="checkbox" name="lock_topic" id="lock_topic"{S_LOCK_TOPIC_CHECKED}><label class="icheck-control" for="lock_topic">{L_LOCK_TOPIC}</label></div><!-- ENDIF -->
+ 				<!-- IF S_LOCK_POST_ALLOWED --><div><input type="checkbox" name="lock_post" id="lock_post"><label class="icheck-control" for="lock_post">{L_LOCK_POST}[{L_LOCK_POST_EXPLAIN}]</label></div><!-- ENDIF -->
+-	     	    <!-- EVENT quickreply_editor_message_after -->
++				<!-- IF FORUM_ID eq 55 -->
++					<!-- EVENT quickreply_editor_message_after -->
++				<!-- ENDIF -->
+ 			    <a role="button" class="btn-link visible-xs pull-right togglesnappy"><i class="fa fa-times"></i></a>
+ 			   </div>
+ 			</div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_reply_buttons.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_reply_buttons.html"
+index 2ce52e33a..6c9bab300 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_reply_buttons.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_reply_buttons.html"
+@@ -29,6 +29,7 @@
+ 		,cb_{custom_tags.BBCODE_ID}: '{custom_tags.A_BBCODE_HELPLINE}'
+ 		<!-- END custom_tags -->
+ 	}
++	<!-- IF S_BBCODEORDER -->
+ 	function change_palette()
+ 	{
+ 		phpbb.toggleDisplay('colour_palette');
+@@ -43,9 +44,17 @@
+ 			document.getElementById('bbpalette').value = '{LA_FONT_COLOR}';
+ 		}
+ 	}
++	<!-- ENDIF -->
+ </script>
+ <script src="{T_THEME_PATH}/vendors/editor.js"></script>
+ 
++<!-- IF S_BBCODE_ALLOWED and S_BBCODEORDER -->
++<div id="colour_palette" style="display: none;">
++	<label class="control-label">{L_FONT_COLOR}{L_COLON}</label>
++	<div id="color_palette_placeholder" data-orientation="h" data-height="12" data-width="15" data-bbcode="true"></div>
++</div>
++<!-- ENDIF -->
++
+ <!-- IF S_BBCODE_ALLOWED -->
+ <div class="space10"></div>
+ <!-- IF not S_BBCODEORDER -->
+@@ -89,30 +98,50 @@
+ 	<!-- END custom_tags -->
+    </div>
+ 
+-	<select class="selectpicker hidden-xs" data-style="btn-default" data-width="auto" name="addbbcode20" onchange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]');this.form.addbbcode20.selectedIndex = 2;" title="{L_BBCODE_F_HELP}">
+-		<option value="50">{L_FONT_TINY}</option>
+-		<option value="85">{L_FONT_SMALL}</option>
+-		<option data-icon="fa fa-font" value="100" selected="selected">{L_FONT_NORMAL}</option>
+-		<!-- IF not MAX_FONT_SIZE or MAX_FONT_SIZE >= 150 -->
+-			<option value="150">{L_FONT_LARGE}</option>
+-			<!-- IF not MAX_FONT_SIZE or MAX_FONT_SIZE >= 200 -->
+-				<option value="200">{L_FONT_HUGE}</option>
++	<div class="btn-group hidden-xs">
++		<select class="selectpicker" data-style="btn-default" data-width="auto" name="addbbcode20" onchange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]');this.form.addbbcode20.selectedIndex = 2;" title="{L_BBCODE_F_HELP}">
++			<option value="50">{L_FONT_TINY}</option>
++			<option value="85">{L_FONT_SMALL}</option>
++			<option data-icon="fa fa-font" value="100" selected="selected">{L_FONT_NORMAL}</option>
++			<!-- IF not MAX_FONT_SIZE or MAX_FONT_SIZE >= 150 -->
++				<option value="150">{L_FONT_LARGE}</option>
++				<!-- IF not MAX_FONT_SIZE or MAX_FONT_SIZE >= 200 -->
++					<option value="200">{L_FONT_HUGE}</option>
++				<!-- ENDIF -->
+ 			<!-- ENDIF -->
++		</select>
++		
++		<select class="selectpicker" data-style="btn-default" data-width="auto" name="addbbcode_custom" onchange="bbstyle(this.form.addbbcode_custom.options[this.form.addbbcode_custom.selectedIndex].value*1);this.form.addbbcode_custom.selectedIndex = 0;">
++			<option data-icon="fa fa-cog" value="100" selected="selected">{L_BBCODES}</option>
++			<!-- BEGIN custom_tags -->
++				<option value="{custom_tags.BBCODE_ID}" title="{custom_tags.BBCODE_HELPLINE}">{custom_tags.BBCODE_TAG}</option>
++			<!-- END custom_tags -->   
++		</select>
++		<!-- IF S_SHOW_ATTACH_BTN --> 
++		<button type="button" class="btn btn-default" value="{L_PLUPLOAD_ADD_FILES}" id="add_files">
++			<i class="fa fa-cloud-upload"></i>&nbsp;{L_PLUPLOAD_ADD_FILES}
++		</button>
+ 		<!-- ENDIF -->
+-	</select>
+-	
+-	<select class="selectpicker hidden-xs" data-style="btn-default" data-width="auto" name="addbbcode_custom" onchange="bbstyle(this.form.addbbcode_custom.options[this.form.addbbcode_custom.selectedIndex].value*1);this.form.addbbcode_custom.selectedIndex = 0;">
+-	  <option data-icon="fa fa-cog" value="100" selected="selected">{L_BBCODES}</option>
+-      <!-- BEGIN custom_tags -->
+-      <option value="{custom_tags.BBCODE_ID}" title="{custom_tags.BBCODE_HELPLINE}">{custom_tags.BBCODE_TAG}</option>
+-      <!-- END custom_tags -->   
+-    </select>
+-    <!-- IF S_SHOW_ATTACH_BTN --> 
+-	<button type="button" class="btn btn-default" value="{L_PLUPLOAD_ADD_FILES}" id="add_files"><i class="fa fa-cloud-upload"></i>&nbsp;{L_PLUPLOAD_ADD_FILES}</button>
+-    <!-- ENDIF -->	
++	</div>
++    
++	<!-- IF IN_IMGUR -->
++	<div class="btn-group">
++		<div class="fileinput fileinput-new" data-provides="fileinput">
++			<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="if (document.getElementById('postform') != null) { document.getElementById('postform').action += '#imgurAnchor' } else if (document.getElementById('qr_postform') != null) { document.getElementById('qr_postform').action += '#imgurAnchor' };"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_IMGUR_UPLOAD}</button>
++			<span class="btn btn-default btn-file">
++				<span class="fileinput-new"><i class="fa fa-imgur"></i></span>
++				<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
++				<input type="file" name="imgur" id="imgur" />
++			</span>
++			<i class="fa fa-picture-o fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
++			<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
++		</div>
++	</div>
++    <!-- ENDIF -->
+ 	<!-- IF IN_GYAZO -->
++	<div class="btn-group">
+ 		<div class="fileinput fileinput-new" data-provides="fileinput">
+-			<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="document.getElementById('postform').action += '#gyazoAnchor';"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_GYAZO_UPLOAD}</button>
++			<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="if (document.getElementById('postform') != null) { document.getElementById('postform').action += '#gyazoAnchor' } else if (document.getElementById('qr_postform') != null) { document.getElementById('qr_postform').action += '#gyazoAnchor' };"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_GYAZO_UPLOAD}</button>
+ 			<span class="btn btn-default btn-file">
+ 				<span class="fileinput-new"><i class="fa fa-gyazo"></i></span>
+ 				<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
+@@ -121,6 +150,7 @@
+ 			<i class="fa fa-picture-o fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
+ 			<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
+ 		</div>
++	</div>
+     <!-- ENDIF -->	
+ </div>
+ <!-- ENDIF -->
diff --git "[FORUM_EXT]/sitesplat\\snappy/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\snappy/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\snappy/diff_nospace.tmp"
@@ -0,0 +1,329 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/diff_full.tmp"
+new file mode 100644
+index 000000000..8b708cffd
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/diff_full.tmp"
+@@ -0,0 +1,376 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/event/listener.php"
++index 235c15d3f..2b0da698b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/event/listener.php"
++@@ -149,6 +149,14 @@ class listener implements EventSubscriberInterface
++ 			'S_SNAPPY'				=> true,
++ 			));
++ 		
+++		if ($this->ext_manager->is_enabled('sitesplat/imgur'))
+++		{
+++			$this->user->add_lang_ext('sitesplat/imgur', 'imgur');
+++			$this->template->assign_vars(array(
+++				'IN_IMGUR'	=> ($this->config['imgur_clientid'] && $this->config['imgur_quickreply']) ? true : false,
+++			));
+++		}
+++
++ 		if ($this->ext_manager->is_enabled('sitesplat/gyazo'))
++ 		{
++ 			$this->user->add_lang_ext('sitesplat/gyazo', 'gyazo');
++@@ -168,6 +176,24 @@ class listener implements EventSubscriberInterface
++ 
++ 	public function load_config_on_setup($event)
++ 	{
+++		if ($event['mode'] == 'attach' && $this->ext_manager->is_enabled('sitesplat/imgur'))
+++		{
+++			$this->user->add_lang_ext('sitesplat/imgur', 'imgur');
+++			$display_vars = $event['display_vars'];
+++
+++			$add_imgur_var = array(
+++				'imgur_quickreply' =>
+++					array(
+++						'lang'		=> 'IMGUR_QUICKREPLY',
+++						'validate'	=> 'bool',
+++						'type' 		=> 'radio:yes_no',
+++						'explain' => false),
+++			);
+++
+++			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $add_imgur_var, array('before' =>'display_order'));
+++			$event['display_vars'] = array('title' => $display_vars['title'], 'vars' => $display_vars['vars']);
+++		}
+++
++ 		if ($event['mode'] == 'attach' && $this->ext_manager->is_enabled('sitesplat/gyazo'))
++ 		{
++ 			$this->user->add_lang_ext('sitesplat/gyazo', 'gyazo');
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/language/en/info_acp_snappy.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/language/en/info_acp_snappy.php"
++index a29220991..253dac6ee 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/language/en/info_acp_snappy.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/language/en/info_acp_snappy.php"
++@@ -20,7 +20,7 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, array(
++ 	
++ 	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++-	'SNAPPY_NOTICE'				    => '<div style="width:auto;margin:20px auto;"><p>There are no specific settings for this extension. Remember to enable the phpBB quick reply option in: <strong>%1$s &#187; %2$s &#187; %3$s "Allow quick reply".</strong><br />Please note, if you have the <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=62" target="_blank">GYAZO</a> extension installed you can also enable or disable the GYAZO option in quick reply.<br />The option is in: <strong>ACP &#187; General &#187; Board configuration &#187; Attachment settings "Allow GYAZO in Smart Snappy Reply"</strong></p></div>',
+++	'SNAPPY_NOTICE'				    => '<div style="width:auto;margin:20px auto;"><p>There are no specific settings for this extension. Remember to enable the phpBB quick reply option in: <strong>%1$s &#187; %2$s &#187; %3$s "Allow quick reply".</strong><br />Please note, if you have the <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=23" target="_blank">IMGUR</a> extensions installed you can also enable or disable the IMGUR option in quick reply and if you have the <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=62" target="_blank">GYAZO</a> extension installed you can also enable or disable the GYAZO option in quick reply.<br />The option is in: <strong>ACP &#187; General &#187; Board configuration &#187; Attachment settings "Allow IMGUR/GYAZO in Smart Snappy Reply"</strong></p></div>',
++ 	
++ ));
++ 
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/migrations/v31x/m1_add_imgur_quickreply.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/migrations/v31x/m1_add_imgur_quickreply.php"
++new file mode 100644
++index 000000000..2fcab622d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/migrations/v31x/m1_add_imgur_quickreply.php"
++@@ -0,0 +1,36 @@
+++<?php
+++/**
+++*
+++* Snappy Smart Reply
+++*
+++* @copyright (c) 2015 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
+++
+++namespace sitesplat\snappy\migrations\v31x;
+++
+++/**
+++* Migration stage 1: Initial data changes to the files
+++*/
+++class m1_add_imgur_quickreply extends \phpbb\db\migration\migration
+++{
+++	/**
+++	 * Assign migration file dependencies for this migration
+++	 *
+++	 * @return array Array of migration files
+++	 * @static
+++	 * @access public
+++	 */
+++	static public function depends_on()
+++	{
+++		return array('\sitesplat\snappy\migrations\v31x\m1_initial_config');
+++	}
+++
+++	public function update_data()
+++	{
+++		return array(
+++			array('config.add', array('imgur_quickreply', true)),
+++		);
+++	}
+++}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/BBOOTS/template/snappy_reply_buttons.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/BBOOTS/template/snappy_reply_buttons.html"
++index 930037ee2..c4ef0febe 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/BBOOTS/template/snappy_reply_buttons.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/BBOOTS/template/snappy_reply_buttons.html"
++@@ -96,13 +96,13 @@
++ 	<!-- IF S_SHOW_ATTACH_BTN --> 
++ 	<button type="button" class="btn btn-default" value="{L_PLUPLOAD_ADD_FILES}" id="add_files"><i class="fa fa-cloud-upload"></i>&nbsp;{L_PLUPLOAD_ADD_FILES}</button>
++     <!-- ENDIF -->
++-	<!-- IF IN_GYAZO -->
+++	<!-- IF IN_IMGUR -->
++ 		<div class="fileinput fileinput-new" data-provides="fileinput">
++-			<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="document.getElementById('postform').action += '#gyazoAnchor';"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_GYAZO_UPLOAD}</button>
+++			<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="document.getElementById('postform').action += '#imgurAnchor';"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_IMGUR_UPLOAD}</button>
++ 			<span class="btn btn-default btn-file">
++-				<span class="fileinput-new"><i class="fa fa-gyazo"></i></span>
+++				<span class="fileinput-new"><i class="fa fa-imgur"></i></span>
++ 				<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
++-				<input type="file" name="gyazo" id="gyazo" />
+++				<input type="file" name="imgur" id="imgur" />
++ 			</span>
++ 			<i class="fa fa-picture-o fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
++ 			<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float: none"><i class="fa fa-times"></i></a>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/css/snappy.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/css/snappy.css"
++index 8a911becd..446655e7b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/css/snappy.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/css/snappy.css"
++@@ -49,7 +49,7 @@ article:hover .btn-snappy {
++     position: absolute;
++     right: -15px;
++     top: 0;
++-    width: 270px;
+++    width: 375px;
++     z-index: 1;
++ }
++ 
++@@ -65,6 +65,17 @@ article:hover .btn-snappy {
++ }
++ 
++ 
+++.fa-imgur::before {
+++    background: #85bf25;
+++    border-radius: 50%;
+++    color: #85bf25;
+++    content: "";
+++    display: inline-block;
+++    height: 16px;
+++    vertical-align: top;
+++    width: 16px;
+++}
+++
++ .fa-gyazo::before {
++   background: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDI0IiBoZWlnaHQ9IjEwMjQiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIG1lZXQiIHhtbG5zOnY9Imh0dHBzOi8vdmVjdGEuaW8vbmFubyI+PHBhdGggZD0iTTExNy40IDI0NC43TDMyLjIgNzYuMmMtLjctLjItMS4yLjMtMS4yIDEuMnMtLjQgMS42LTEgMS42Yy0uNSAwLTEgLjctMSAxLjVzLS40IDEuNS0xIDEuNWMtLjUgMC0xIC43LTEgMS41IDAgLjktMSAxLjUtMi42IDEuNS0zLjMgMC0zLS44IDQuNS0xMS44IDIyLjktMzMuNCA1NS44LTU2LjggOTQuNS02Ny4zQzE0NC42LjIgMTA4LjIuNiA1ODUuNS40bDQzOC0uMy00MDkuMyAyMDQuNy00MDguOCAyMDYuNWMuMyAxLjItLjIgMS43LTEuNyAxLjYtMS45LS4xLTE0LjUtMjQuOC04Ni4zLTE2OC4yek0xNi4xIDk1LjNjMS40LTMuOCA0LjItOC4zIDUuMS04LjMgMS4yIDAgMSA1LjYtLjQgOC41LS43IDEuNi0xLjkgMi41LTMuNCAyLjUtMi4xIDAtMi4zLS4zLTEuMy0yLjd6IiBmaWxsPSIjODRiOGZlIi8+PHBhdGggZD0iTTE2LjMgOTI5LjNDOCA5MTEuNSAzLjIgODk0LjcgMSA4NzVjLS44LTYuNy0xLTExNi4zLS44LTM2OS41bC4zLTM2MCAyLjctMTIuMUM4IDExMiAxNi41IDkyIDI3LjkgNzUuMWw1LTcuNCAyIDMuNGM2LjIgOS45IDM0NS4yIDY5MC40IDM0NC45IDY5Mi4yLS4yIDEuNy0zMi40IDE4LTE3Ni4zIDg5LjNMMjQuNCA5MzkuOWMtMyAuMS0zLjMtLjMtOC4xLTEwLjZ6IiBmaWxsPSIjNTk5MmZmIi8+PHBhdGggZD0iTTE0NC41IDEwMjIuOWMtMTYuNC0yLjEtMzYuNi04LjUtNTMuNS0xNi45LTkuNS00LjctMjMuNS0xMy43LTI2LjQtMTYuOS0xLjctMS45LTEuNy0yLjEtLjItMi4xLjkgMCA2MC42LTI5LjMgMTMyLjYtNjUuMmwxMzEtNjYuN2MwLTEuMSAxMi03LjYgMzguNS0yMC45IDM1LjktMTcuOSA0MS41LTIwLjQgNDEuNS0xOC40LjEgMy45IDUuMyAxLjUgMTcxLjUtODEuM2wxNzAtODQuMyA5MC44IDE3NC45IDkwLjcgMTc4LjFjMCAzLjMtLjMgMy42LTYuOCA2LjctMTQuOCA2LjgtMzEuNiAxMS4yLTUwLjEgMTMtMTIuOCAxLjQtNzE5LjEgMS4zLTcyOS42IDB6IiBmaWxsPSIjMWQ1Y2ZlIi8+PHBhdGggZD0iTTk4Ni45IDk1OC43Qzk4NSA5NTcuMiA4MTYgNjIwLjggODE2IDYxOC40YzAtLjkuNy0yLjIgMS42LTIuOCAxLjQtMS4xLTMuNi0xMS42LTQwLjUtODUuNEw3MzUgNDQ2aDE0NC41SDEwMjR2MjEwLjlsLTEuNSAyMjIuNGMtMy40IDI2LjEtMTEuNiA0OC0yNi4zIDcwLjMtMy4zIDUuMS02LjQgOS40LTYuOSA5LjctLjQuMy0xLjUgMC0yLjQtLjZ6IiBmaWxsPSIjMDAyYWI1Ii8+PHBhdGggZD0iTTE0NC41IDEwMjIuOWMtMTYuNS0yLjEtMzYuOC04LjUtNTMuNS0xNi45LTEyLjctNi4zLTI3LTE2LjEtMjctMTguMyAwLTEuNSAzNDIuMi0xNzEuOCAzNDMuOS0xNzEuMiAxLjEuNS0xMS42IDcuMy0zNy42IDIwLjMtMjEuNiAxMC44LTM5LjMgMjAtMzkuMyAyMC40IDAgLjcgOTQuMy00NS44IDE4My45LTkwLjZsNDkuNy0yNC4zYy4yLjItMTExIDU1LjktMjQ3LjEgMTIzLjhMNzAgOTkwLjNjMCAxLjIgMTEuNyA4LjMgMjIuNSAxMy42IDEwLjUgNS4yIDE2LjEgNy41IDIzLjMgOS41IDIuNC43IDQuNyAxLjcgNSAyLjIuNC41IDEuNiAxIDIuNyAxIDIuNy4yIDExLjkgMS43IDE5IDMuMSAxLjcuMyAxNjMuNC44IDM1OS41IDFsMzg3LTMuM2MxNi42LTMuNSAzOS42LTEyLjQgMzguNi0xNS4xLS4zLS43LTQxLjItNzkuNi05MC45LTE3NS4ybC05MC4zLTE3My45LTMxLjUgMTUuMi01NC42IDI2LjktMjQgMTEuNmMtLjUgMCA0MC4zLTIwLjYgOTAuNi00NS44bDkxLjMtNDUuNyAzNC40IDY4LjggMzUuNSA2OC44Yy41IDAgLjcuNC40IDEtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMS0uMSAxIC41IDEgLjguNC41IDEtLjEgMSAuNSAxIC44LjQuNSAxLS4xIDEgLjUgMSAuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNC41IDEtLjEgMSAuNSAxIC44LjUuNSAxLS4xIDEgLjUgMSAuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMS0uMSAxIC41IDEgLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxLS4xIDEgLjUgMSAuOC40LjUgMS0uMSAxIC41IDEgLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxLS4xIDEgLjUgMSAuOC40LjUgMS0uMSAxIC41IDEgLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDEtLjEgMSAuNSAxIC44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxLS4xIDEgLjUgMSAuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC42IDFzLjkuMy42LjdjLS40LjMuMSAxLjIgMSAxLjggMS41IDEuMiAxLjEgMi00LjIgOC41LTEzLjUgMTYuNS0zMy4xIDMyLTUzIDQxLjktMTQuNSA3LjMtMjUuOCAxMS4yLTQxLjkgMTQuOWwtMTIuMSAyLjctMzYzLjUuMWMtMjA2IC4xLTM2Ni41LS4yLTM3MC41LS43eiIgZmlsbD0iIzE3NTFmNSIvPjxwYXRoIGQ9Ik01Ny44IDk4My42Yy0yNS43LTIxLjktNDQuNi01Mi45LTUzLjMtODcuMi0uOC0zLjQtMS41LTctMS41LTggLjEtMS4xIDEuMiAyLjIgMi41IDcuMSAyLjYgMTAuMSA2LjggMjIgOS43IDI4IDIuMSA0LjEgNy45IDEzLjUgOC40IDEzLjUuMyAwIDMxOS41LTE1OCAzNDEuMS0xNjguOGwxMi4xLTYuMS0zLjItNy44Yy0xLjgtNC4zLTYuMS0xMy40LTkuNS0yMC4yLTUuNS0xMC45LTctMTUuNC00LjEtMTIuNS41LjUgMTEuNyAyMi4zIDI0LjkgNDguNGwyNCA0Ny42TDM3MCA4MzdjLTIxLjUgMTAuNy0zOSAxOS44LTM5IDIwLjJDMzMxIDg1OCA2Ny43IDk5MCA2Ni4yIDk5MGMtLjUgMC00LjMtMi45LTguNC02LjR6TTEuMyA4NzZjMC0yLjUuMi0zLjUuNC0yLjJhMTYuOTUgMTYuOTUgMCAwIDEgMCA0LjVjLS4yIDEuMi0uNC4yLS40LTIuM3ptLTEtMTIuNWMwLTQuNC4yLTYuMS40LTMuNy4yIDIuMy4yIDUuOSAwIDgtLjIgMi0uNC4xLS40LTQuM3ptMTg5LjYtNDc3LjZjLTE5LjgtMzkuNy0zMi40LTY1LjktMzEuNC02NS41LjkuMyAxLjkuNiAyLjEuNi4zIDAgLjIuNS0uMSAxLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjkuNC42LjljLS40LjUtLjMgMS4xLjEgMS4zLjcuMyAyMi4zIDQzLjIgMjIuMyA0NC4zIDAgMy42LTcuMS05LjYtMzUuMS02NS42ek01Ny41IDEyMS4yQzQwLjMgODcuMSAzMi4xIDcxLjYgMzEuMSA3MS44Yy0xLjIuMy0xLjIgMC0uMS0xLjIuNy0uOSAxLjYtMS42IDIuMS0xLjZzMTIuNCAyMyAyNi40IDUxYzE0IDI4LjEgMjQuOSA1MSAyNC4zIDUxLS43IDAtMTIuNS0yMi40LTI2LjMtNDkuOHpNLjMgMTYxLjVjMC0zLjguMi01LjMuNC0zLjIuMiAyIC4yIDUuMiAwIDctLjIgMS43LS40LjEtLjQtMy44eiIgZmlsbD0iIzUyODhmNiIvPjwvc3ZnPg==");
++     background-position-x: 0%;
++@@ -79,6 +90,7 @@ article:hover .btn-snappy {
++   background-size: contain;
++ }
++ 
+++
++ .fileinput-exists .fa-picture-o {
++     vertical-align: text-bottom;
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_before_absolute.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_before_absolute.html"
++index b06baa6ea..cebaa9672 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_before_absolute.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_before_absolute.html"
++@@ -1,7 +1,7 @@
++ <!-- IF not S_IS_BOT and S_REGISTERED_USER -->
++ <!-- IF postrow.U_QUOTE -->
++ <div class="btn-group btn-group-sm btn-snappy hidden-xs" role="group">
++- <a class="btn btn-sm btn-default" href="javascript:void(0);" onclick="addquote({postrow.POST_ID}, '{postrow.POST_AUTHOR}', '{LA_WROTE}');" title="{L_QUOTE} {postrow.POST_AUTHOR}"><i class="fa fa-comment"></i></a>
+++ <a class="btn btn-sm btn-default" href="javascript:void(0);" onclick="addquote({postrow.POST_ID}, '{postrow.POST_AUTHOR}', '{postrow.POSTER_ID}', '{LA_WROTE}');" title="{L_QUOTE} {postrow.POST_AUTHOR}"><i class="fa fa-comment"></i></a>
++  <a class="btn btn-sm btn-default" href="javascript:void(0);" onclick="insert_text('[b]&#64;{postrow.POST_AUTHOR}[/b], ', false);" title="&#64;{postrow.POST_AUTHOR}"><i class="icon-moon-email icon-moon-fx"></i></a>
++ </div>
++ <!-- ENDIF -->
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/js/script.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/js/script.js"
++index 03e68a1ae..491a090b0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/js/script.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/js/script.js"
++@@ -4,11 +4,12 @@ head.ready(function () {
++ "use strict";
++ 
++ 	$(".ccount").characterCounter({
++-        counterFormat: '%1 characters remaining',
+++        counterFormat: '%1 caracteres restantes',
++ 		limit: max_post_chars,
++     });
++ 	
++ 	var button = document.getElementById('show_button')
+++	if(!button) return;
++     button.addEventListener('click',hideshow,false);
++ 
++     function hideshow() {
++@@ -44,14 +45,14 @@ head.ready(function () {
++ 	});
++ 	
++ 	$('#qr_postform').submit(function() {
++-        localStorage.clear();
+++        localStorage.removeItem("TextEditorData");
++     });
++ 	
++ 	//lets clear empty local storage and textarea if needed
++ 	$(".btn-clr").click(function(e) {
++         e.preventDefault();
++         $(".ccount").val('');
++-		localStorage.clear();
+++		localStorage.removeItem("TextEditorData");
++     });
++ 	
++ //	$('.panel-qr > .qr-textarea > textarea').on('keyup', function(event) {
++@@ -63,13 +64,13 @@ head.ready(function () {
++ //        }
++ //   });
++    
++-   setInterval(function () {
++-	  if($("#message").val().length >= 1) {
++-		$(".load").removeAttr("disabled");
++-	  } else {
++-		$(".load").attr("disabled", "disabled");
++-	  }
++-	}, 400); //Runs every 0.4s
+++	// setInterval(function () {
+++	  // if($("#message").val().length >= 1) {
+++		// $(".load").removeAttr("disabled");
+++	  // } else {
+++		// $(".load").attr("disabled", "disabled");
+++	  // }
+++	// }, 400); //Runs every 0.4s
++    
++    //	$('.toggleModal').on('click', function () {
++    //      $('#col1').toggleClass('col-md-12 col-md-9');
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_quickreply_editor.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_quickreply_editor.html"
++index b77807128..11ebf6f36 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_quickreply_editor.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_quickreply_editor.html"
++@@ -1,7 +1,7 @@
++ <div class="clearfix">
++ 	<form name="qr_postform" id="qr_postform" method="post" action="{U_QR_ACTION}"{S_FORM_ENCTYPE}>
++      <fieldset> 
++-		<div class="row">			
+++		<div class="row">
++ 			<div class="col-md-12">
++ 				<div class="text-center">
++ 				  <!-- EVENT quickreply_editor_panel_before -->
++@@ -31,8 +31,8 @@
++ 		              {QR_HIDDEN_FIELDS}
++ 		              <button onclick="document.getElementById('show_button').style.display = 'inline-block';" class="btn btn-default" type="button" data-target=".quick-reply" data-toggle="collapse"><i class="fa fa-times"></i></button>
++                       <a role="button" class="btn btn-default togglesnappy"><i class="fa fa-cog"></i></a>
++-					  <button type="submit" class="btn btn-default load" disabled="disabled" tabindex="7" name="post" value="{L_SUBMIT}" data-loading-text="{L_LOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_SUBMIT}</button>
++-		              <button type="submit" class="btn btn-default load" disabled="disabled" tabindex="6" name="preview" value="{L_FULL_EDITOR}" id="qr_full_editor" data-loading-text="{L_LOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><span class="hidden-xs">{L_FULL_EDITOR}</span><i class="fa fa-search visible-xs"></i></button>		   
+++					  <button type="submit" class="btn btn-default load" tabindex="7" name="post" value="{L_SUBMIT}" data-loading-text="{L_LOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_SUBMIT}</button>
+++		              <button type="submit" class="btn btn-default load" tabindex="6" name="preview" value="{L_FULL_EDITOR}" id="qr_full_editor" data-loading-text="{L_LOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><span class="hidden-xs">{L_FULL_EDITOR}</span><i class="fa fa-search visible-xs"></i></button>		   
++ 				   </div>
++ 			    </div>
++             </div>
++@@ -45,7 +45,9 @@
++ 				<!-- IF S_NOTIFY_ALLOWED --><div><input type="checkbox" name="notify" id="notify"{S_NOTIFY_CHECKED}><label class="icheck-control" for="notify">{L_NOTIFY_REPLY}</label></div><!-- ENDIF -->
++ 				<!-- IF S_LOCK_TOPIC_ALLOWED --><div><input type="checkbox" name="lock_topic" id="lock_topic"{S_LOCK_TOPIC_CHECKED}><label class="icheck-control" for="lock_topic">{L_LOCK_TOPIC}</label></div><!-- ENDIF -->
++ 				<!-- IF S_LOCK_POST_ALLOWED --><div><input type="checkbox" name="lock_post" id="lock_post"><label class="icheck-control" for="lock_post">{L_LOCK_POST}[{L_LOCK_POST_EXPLAIN}]</label></div><!-- ENDIF -->
++-	     	    <!-- EVENT quickreply_editor_message_after -->
+++				<!-- IF FORUM_ID eq 55 -->
+++					<!-- EVENT quickreply_editor_message_after -->
+++				<!-- ENDIF -->
++ 			    <a role="button" class="btn-link visible-xs pull-right togglesnappy"><i class="fa fa-times"></i></a>
++ 			   </div>
++ 			</div>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_reply_buttons.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_reply_buttons.html"
++index 2ce52e33a..6c9bab300 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_reply_buttons.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\snappy/styles/FLATBOOTS/template/snappy_reply_buttons.html"
++@@ -29,6 +29,7 @@
++ 		,cb_{custom_tags.BBCODE_ID}: '{custom_tags.A_BBCODE_HELPLINE}'
++ 		<!-- END custom_tags -->
++ 	}
+++	<!-- IF S_BBCODEORDER -->
++ 	function change_palette()
++ 	{
++ 		phpbb.toggleDisplay('colour_palette');
++@@ -43,9 +44,17 @@
++ 			document.getElementById('bbpalette').value = '{LA_FONT_COLOR}';
++ 		}
++ 	}
+++	<!-- ENDIF -->
++ </script>
++ <script src="{T_THEME_PATH}/vendors/editor.js"></script>
++ 
+++<!-- IF S_BBCODE_ALLOWED and S_BBCODEORDER -->
+++<div id="colour_palette" style="display: none;">
+++	<label class="control-label">{L_FONT_COLOR}{L_COLON}</label>
+++	<div id="color_palette_placeholder" data-orientation="h" data-height="12" data-width="15" data-bbcode="true"></div>
+++</div>
+++<!-- ENDIF -->
+++
++ <!-- IF S_BBCODE_ALLOWED -->
++ <div class="space10"></div>
++ <!-- IF not S_BBCODEORDER -->
++@@ -89,30 +98,50 @@
++ 	<!-- END custom_tags -->
++    </div>
++ 
++-	<select class="selectpicker hidden-xs" data-style="btn-default" data-width="auto" name="addbbcode20" onchange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]');this.form.addbbcode20.selectedIndex = 2;" title="{L_BBCODE_F_HELP}">
++-		<option value="50">{L_FONT_TINY}</option>
++-		<option value="85">{L_FONT_SMALL}</option>
++-		<option data-icon="fa fa-font" value="100" selected="selected">{L_FONT_NORMAL}</option>
++-		<!-- IF not MAX_FONT_SIZE or MAX_FONT_SIZE >= 150 -->
++-			<option value="150">{L_FONT_LARGE}</option>
++-			<!-- IF not MAX_FONT_SIZE or MAX_FONT_SIZE >= 200 -->
++-				<option value="200">{L_FONT_HUGE}</option>
+++	<div class="btn-group hidden-xs">
+++		<select class="selectpicker" data-style="btn-default" data-width="auto" name="addbbcode20" onchange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]');this.form.addbbcode20.selectedIndex = 2;" title="{L_BBCODE_F_HELP}">
+++			<option value="50">{L_FONT_TINY}</option>
+++			<option value="85">{L_FONT_SMALL}</option>
+++			<option data-icon="fa fa-font" value="100" selected="selected">{L_FONT_NORMAL}</option>
+++			<!-- IF not MAX_FONT_SIZE or MAX_FONT_SIZE >= 150 -->
+++				<option value="150">{L_FONT_LARGE}</option>
+++				<!-- IF not MAX_FONT_SIZE or MAX_FONT_SIZE >= 200 -->
+++					<option value="200">{L_FONT_HUGE}</option>
+++				<!-- ENDIF -->
++ 			<!-- ENDIF -->
+++		</select>
+++		
+++		<select class="selectpicker" data-style="btn-default" data-width="auto" name="addbbcode_custom" onchange="bbstyle(this.form.addbbcode_custom.options[this.form.addbbcode_custom.selectedIndex].value*1);this.form.addbbcode_custom.selectedIndex = 0;
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\snappy/event/listener.php" "[FORUM_EXT]/sitesplat\\snappy/event/listener.php"
--- "[ORIGINAL]/sitesplat\\snappy/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\snappy/event/listener.php"
@@ -149,6 +149,14 @@ class listener implements EventSubscriberInterface
 			'S_SNAPPY'				=> true,
 			));
 		
+		if ($this->ext_manager->is_enabled('sitesplat/imgur'))
+		{
+			$this->user->add_lang_ext('sitesplat/imgur', 'imgur');
+			$this->template->assign_vars(array(
+				'IN_IMGUR'	=> ($this->config['imgur_clientid'] && $this->config['imgur_quickreply']) ? true : false,
+			));
+		}
+
 		if ($this->ext_manager->is_enabled('sitesplat/gyazo'))
 		{
 			$this->user->add_lang_ext('sitesplat/gyazo', 'gyazo');
@@ -168,6 +176,24 @@ class listener implements EventSubscriberInterface
 
 	public function load_config_on_setup($event)
 	{
+		if ($event['mode'] == 'attach' && $this->ext_manager->is_enabled('sitesplat/imgur'))
+		{
+			$this->user->add_lang_ext('sitesplat/imgur', 'imgur');
+			$display_vars = $event['display_vars'];
+
+			$add_imgur_var = array(
+				'imgur_quickreply' =>
+					array(
+						'lang'		=> 'IMGUR_QUICKREPLY',
+						'validate'	=> 'bool',
+						'type' 		=> 'radio:yes_no',
+						'explain' => false),
+			);
+
+			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $add_imgur_var, array('before' =>'display_order'));
+			$event['display_vars'] = array('title' => $display_vars['title'], 'vars' => $display_vars['vars']);
+		}
+
 		if ($event['mode'] == 'attach' && $this->ext_manager->is_enabled('sitesplat/gyazo'))
 		{
 			$this->user->add_lang_ext('sitesplat/gyazo', 'gyazo');
diff --git "[ORIGINAL]/sitesplat\\snappy/language/en/info_acp_snappy.php" "[FORUM_EXT]/sitesplat\\snappy/language/en/info_acp_snappy.php"
--- "[ORIGINAL]/sitesplat\\snappy/language/en/info_acp_snappy.php"
+++ "[FORUM_EXT]/sitesplat\\snappy/language/en/info_acp_snappy.php"
@@ -20,7 +20,7 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, array(
 	
 	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
-	'SNAPPY_NOTICE'				    => '<div style="width:auto;margin:20px auto;"><p>There are no specific settings for this extension. Remember to enable the phpBB quick reply option in: <strong>%1$s &#187; %2$s &#187; %3$s "Allow quick reply".</strong><br />Please note, if you have the <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=62" target="_blank">GYAZO</a> extension installed you can also enable or disable the GYAZO option in quick reply.<br />The option is in: <strong>ACP &#187; General &#187; Board configuration &#187; Attachment settings "Allow GYAZO in Smart Snappy Reply"</strong></p></div>',
+	'SNAPPY_NOTICE'				    => '<div style="width:auto;margin:20px auto;"><p>There are no specific settings for this extension. Remember to enable the phpBB quick reply option in: <strong>%1$s &#187; %2$s &#187; %3$s "Allow quick reply".</strong><br />Please note, if you have the <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=23" target="_blank">IMGUR</a> extensions installed you can also enable or disable the IMGUR option in quick reply and if you have the <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=62" target="_blank">GYAZO</a> extension installed you can also enable or disable the GYAZO option in quick reply.<br />The option is in: <strong>ACP &#187; General &#187; Board configuration &#187; Attachment settings "Allow IMGUR/GYAZO in Smart Snappy Reply"</strong></p></div>',
 	
 ));
 
diff --git "[FORUM_EXT]/sitesplat\\snappy/migrations/v31x/m1_add_imgur_quickreply.php" "[FORUM_EXT]/sitesplat\\snappy/migrations/v31x/m1_add_imgur_quickreply.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\snappy/migrations/v31x/m1_add_imgur_quickreply.php"
@@ -0,0 +1,36 @@
+<?php
+/**
+*
+* Snappy Smart Reply
+*
+* @copyright (c) 2015 SiteSplat All rights reserved
+* @license Proprietary
+*
+*/
+
+namespace sitesplat\snappy\migrations\v31x;
+
+/**
+* Migration stage 1: Initial data changes to the files
+*/
+class m1_add_imgur_quickreply extends \phpbb\db\migration\migration
+{
+	/**
+	 * Assign migration file dependencies for this migration
+	 *
+	 * @return array Array of migration files
+	 * @static
+	 * @access public
+	 */
+	static public function depends_on()
+	{
+		return array('\sitesplat\snappy\migrations\v31x\m1_initial_config');
+	}
+
+	public function update_data()
+	{
+		return array(
+			array('config.add', array('imgur_quickreply', true)),
+		);
+	}
+}
diff --git "[ORIGINAL]/sitesplat\\snappy/styles/BBOOTS/template/snappy_reply_buttons.html" "[FORUM_EXT]/sitesplat\\snappy/styles/BBOOTS/template/snappy_reply_buttons.html"
--- "[ORIGINAL]/sitesplat\\snappy/styles/BBOOTS/template/snappy_reply_buttons.html"
+++ "[FORUM_EXT]/sitesplat\\snappy/styles/BBOOTS/template/snappy_reply_buttons.html"
@@ -96,13 +96,13 @@
 	<!-- IF S_SHOW_ATTACH_BTN --> 
 	<button type="button" class="btn btn-default" value="{L_PLUPLOAD_ADD_FILES}" id="add_files"><i class="fa fa-cloud-upload"></i>&nbsp;{L_PLUPLOAD_ADD_FILES}</button>
     <!-- ENDIF -->
-	<!-- IF IN_GYAZO -->
+	<!-- IF IN_IMGUR -->
 		<div class="fileinput fileinput-new" data-provides="fileinput">
-			<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="document.getElementById('postform').action += '#gyazoAnchor';"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_GYAZO_UPLOAD}</button>
+			<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="document.getElementById('postform').action += '#imgurAnchor';"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_IMGUR_UPLOAD}</button>
 			<span class="btn btn-default btn-file">
-				<span class="fileinput-new"><i class="fa fa-gyazo"></i></span>
+				<span class="fileinput-new"><i class="fa fa-imgur"></i></span>
 				<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
-				<input type="file" name="gyazo" id="gyazo" />
+				<input type="file" name="imgur" id="imgur" />
 			</span>
 			<i class="fa fa-picture-o fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
 			<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float: none"><i class="fa fa-times"></i></a>
diff --git "[ORIGINAL]/sitesplat\\snappy/styles/FLATBOOTS/template/css/snappy.css" "[FORUM_EXT]/sitesplat\\snappy/styles/FLATBOOTS/template/css/snappy.css"
--- "[ORIGINAL]/sitesplat\\snappy/styles/FLATBOOTS/template/css/snappy.css"
+++ "[FORUM_EXT]/sitesplat\\snappy/styles/FLATBOOTS/template/css/snappy.css"
@@ -49,7 +49,7 @@ article:hover .btn-snappy {
     position: absolute;
     right: -15px;
     top: 0;
-    width: 270px;
+    width: 375px;
     z-index: 1;
 }
 
@@ -65,6 +65,17 @@ article:hover .btn-snappy {
 }
 
 
+.fa-imgur::before {
+    background: #85bf25;
+    border-radius: 50%;
+    color: #85bf25;
+    content: "";
+    display: inline-block;
+    height: 16px;
+    vertical-align: top;
+    width: 16px;
+}
+
 .fa-gyazo::before {
   background: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDI0IiBoZWlnaHQ9IjEwMjQiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIG1lZXQiIHhtbG5zOnY9Imh0dHBzOi8vdmVjdGEuaW8vbmFubyI+PHBhdGggZD0iTTExNy40IDI0NC43TDMyLjIgNzYuMmMtLjctLjItMS4yLjMtMS4yIDEuMnMtLjQgMS42LTEgMS42Yy0uNSAwLTEgLjctMSAxLjVzLS40IDEuNS0xIDEuNWMtLjUgMC0xIC43LTEgMS41IDAgLjktMSAxLjUtMi42IDEuNS0zLjMgMC0zLS44IDQuNS0xMS44IDIyLjktMzMuNCA1NS44LTU2LjggOTQuNS02Ny4zQzE0NC42LjIgMTA4LjIuNiA1ODUuNS40bDQzOC0uMy00MDkuMyAyMDQuNy00MDguOCAyMDYuNWMuMyAxLjItLjIgMS43LTEuNyAxLjYtMS45LS4xLTE0LjUtMjQuOC04Ni4zLTE2OC4yek0xNi4xIDk1LjNjMS40LTMuOCA0LjItOC4zIDUuMS04LjMgMS4yIDAgMSA1LjYtLjQgOC41LS43IDEuNi0xLjkgMi41LTMuNCAyLjUtMi4xIDAtMi4zLS4zLTEuMy0yLjd6IiBmaWxsPSIjODRiOGZlIi8+PHBhdGggZD0iTTE2LjMgOTI5LjNDOCA5MTEuNSAzLjIgODk0LjcgMSA4NzVjLS44LTYuNy0xLTExNi4zLS44LTM2OS41bC4zLTM2MCAyLjctMTIuMUM4IDExMiAxNi41IDkyIDI3LjkgNzUuMWw1LTcuNCAyIDMuNGM2LjIgOS45IDM0NS4yIDY5MC40IDM0NC45IDY5Mi4yLS4yIDEuNy0zMi40IDE4LTE3Ni4zIDg5LjNMMjQuNCA5MzkuOWMtMyAuMS0zLjMtLjMtOC4xLTEwLjZ6IiBmaWxsPSIjNTk5MmZmIi8+PHBhdGggZD0iTTE0NC41IDEwMjIuOWMtMTYuNC0yLjEtMzYuNi04LjUtNTMuNS0xNi45LTkuNS00LjctMjMuNS0xMy43LTI2LjQtMTYuOS0xLjctMS45LTEuNy0yLjEtLjItMi4xLjkgMCA2MC42LTI5LjMgMTMyLjYtNjUuMmwxMzEtNjYuN2MwLTEuMSAxMi03LjYgMzguNS0yMC45IDM1LjktMTcuOSA0MS41LTIwLjQgNDEuNS0xOC40LjEgMy45IDUuMyAxLjUgMTcxLjUtODEuM2wxNzAtODQuMyA5MC44IDE3NC45IDkwLjcgMTc4LjFjMCAzLjMtLjMgMy42LTYuOCA2LjctMTQuOCA2LjgtMzEuNiAxMS4yLTUwLjEgMTMtMTIuOCAxLjQtNzE5LjEgMS4zLTcyOS42IDB6IiBmaWxsPSIjMWQ1Y2ZlIi8+PHBhdGggZD0iTTk4Ni45IDk1OC43Qzk4NSA5NTcuMiA4MTYgNjIwLjggODE2IDYxOC40YzAtLjkuNy0yLjIgMS42LTIuOCAxLjQtMS4xLTMuNi0xMS42LTQwLjUtODUuNEw3MzUgNDQ2aDE0NC41SDEwMjR2MjEwLjlsLTEuNSAyMjIuNGMtMy40IDI2LjEtMTEuNiA0OC0yNi4zIDcwLjMtMy4zIDUuMS02LjQgOS40LTYuOSA5LjctLjQuMy0xLjUgMC0yLjQtLjZ6IiBmaWxsPSIjMDAyYWI1Ii8+PHBhdGggZD0iTTE0NC41IDEwMjIuOWMtMTYuNS0yLjEtMzYuOC04LjUtNTMuNS0xNi45LTEyLjctNi4zLTI3LTE2LjEtMjctMTguMyAwLTEuNSAzNDIuMi0xNzEuOCAzNDMuOS0xNzEuMiAxLjEuNS0xMS42IDcuMy0zNy42IDIwLjMtMjEuNiAxMC44LTM5LjMgMjAtMzkuMyAyMC40IDAgLjcgOTQuMy00NS44IDE4My45LTkwLjZsNDkuNy0yNC4zYy4yLjItMTExIDU1LjktMjQ3LjEgMTIzLjhMNzAgOTkwLjNjMCAxLjIgMTEuNyA4LjMgMjIuNSAxMy42IDEwLjUgNS4yIDE2LjEgNy41IDIzLjMgOS41IDIuNC43IDQuNyAxLjcgNSAyLjIuNC41IDEuNiAxIDIuNyAxIDIuNy4yIDExLjkgMS43IDE5IDMuMSAxLjcuMyAxNjMuNC44IDM1OS41IDFsMzg3LTMuM2MxNi42LTMuNSAzOS42LTEyLjQgMzguNi0xNS4xLS4zLS43LTQxLjItNzkuNi05MC45LTE3NS4ybC05MC4zLTE3My45LTMxLjUgMTUuMi01NC42IDI2LjktMjQgMTEuNmMtLjUgMCA0MC4zLTIwLjYgOTAuNi00NS44bDkxLjMtNDUuNyAzNC40IDY4LjggMzUuNSA2OC44Yy41IDAgLjcuNC40IDEtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMS0uMSAxIC41IDEgLjguNC41IDEtLjEgMSAuNSAxIC44LjQuNSAxLS4xIDEgLjUgMSAuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNC41IDEtLjEgMSAuNSAxIC44LjUuNSAxLS4xIDEgLjUgMSAuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMS0uMSAxIC41IDEgLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxLS4xIDEgLjUgMSAuOC40LjUgMS0uMSAxIC41IDEgLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxLS4xIDEgLjUgMSAuOC40LjUgMS0uMSAxIC41IDEgLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDEtLjEgMSAuNSAxIC44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxLS4xIDEgLjUgMSAuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC41IDFzLjguNC41IDFjLS4zLjUtLjEgMSAuNSAxcy44LjQuNSAxYy0uMy41LS4xIDEgLjUgMXMuOC40LjUgMWMtLjMuNS0uMSAxIC42IDFzLjkuMy42LjdjLS40LjMuMSAxLjIgMSAxLjggMS41IDEuMiAxLjEgMi00LjIgOC41LTEzLjUgMTYuNS0zMy4xIDMyLTUzIDQxLjktMTQuNSA3LjMtMjUuOCAxMS4yLTQxLjkgMTQuOWwtMTIuMSAyLjctMzYzLjUuMWMtMjA2IC4xLTM2Ni41LS4yLTM3MC41LS43eiIgZmlsbD0iIzE3NTFmNSIvPjxwYXRoIGQ9Ik01Ny44IDk4My42Yy0yNS43LTIxLjktNDQuNi01Mi45LTUzLjMtODcuMi0uOC0zLjQtMS41LTctMS41LTggLjEtMS4xIDEuMiAyLjIgMi41IDcuMSAyLjYgMTAuMSA2LjggMjIgOS43IDI4IDIuMSA0LjEgNy45IDEzLjUgOC40IDEzLjUuMyAwIDMxOS41LTE1OCAzNDEuMS0xNjguOGwxMi4xLTYuMS0zLjItNy44Yy0xLjgtNC4zLTYuMS0xMy40LTkuNS0yMC4yLTUuNS0xMC45LTctMTUuNC00LjEtMTIuNS41LjUgMTEuNyAyMi4zIDI0LjkgNDguNGwyNCA0Ny42TDM3MCA4MzdjLTIxLjUgMTAuNy0zOSAxOS44LTM5IDIwLjJDMzMxIDg1OCA2Ny43IDk5MCA2Ni4yIDk5MGMtLjUgMC00LjMtMi45LTguNC02LjR6TTEuMyA4NzZjMC0yLjUuMi0zLjUuNC0yLjJhMTYuOTUgMTYuOTUgMCAwIDEgMCA0LjVjLS4yIDEuMi0uNC4yLS40LTIuM3ptLTEtMTIuNWMwLTQuNC4yLTYuMS40LTMuNy4yIDIuMy4yIDUuOSAwIDgtLjIgMi0uNC4xLS40LTQuM3ptMTg5LjYtNDc3LjZjLTE5LjgtMzkuNy0zMi40LTY1LjktMzEuNC02NS41LjkuMyAxLjkuNiAyLjEuNi4zIDAgLjIuNS0uMSAxLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjguNS41IDFjLS4zLjYtLjEgMSAuNSAxcy44LjUuNSAxYy0uMy42LS4xIDEgLjUgMXMuOC41LjUgMWMtLjMuNi0uMSAxIC41IDFzLjkuNC42LjljLS40LjUtLjMgMS4xLjEgMS4zLjcuMyAyMi4zIDQzLjIgMjIuMyA0NC4zIDAgMy42LTcuMS05LjYtMzUuMS02NS42ek01Ny41IDEyMS4yQzQwLjMgODcuMSAzMi4xIDcxLjYgMzEuMSA3MS44Yy0xLjIuMy0xLjIgMC0uMS0xLjIuNy0uOSAxLjYtMS42IDIuMS0xLjZzMTIuNCAyMyAyNi40IDUxYzE0IDI4LjEgMjQuOSA1MSAyNC4zIDUxLS43IDAtMTIuNS0yMi40LTI2LjMtNDkuOHpNLjMgMTYxLjVjMC0zLjguMi01LjMuNC0zLjIuMiAyIC4yIDUuMiAwIDctLjIgMS43LS40LjEtLjQtMy44eiIgZmlsbD0iIzUyODhmNiIvPjwvc3ZnPg==");
     background-position-x: 0%;
@@ -79,6 +90,7 @@ article:hover .btn-snappy {
   background-size: contain;
 }
 
+
 .fileinput-exists .fa-picture-o {
     vertical-align: text-bottom;
 }
diff --git "[ORIGINAL]/sitesplat\\snappy/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_before_absolute.html" "[FORUM_EXT]/sitesplat\\snappy/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_before_absolute.html"
--- "[ORIGINAL]/sitesplat\\snappy/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_before_absolute.html"
+++ "[FORUM_EXT]/sitesplat\\snappy/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_before_absolute.html"
@@ -1,7 +1,7 @@
 <!-- IF not S_IS_BOT and S_REGISTERED_USER -->
 <!-- IF postrow.U_QUOTE -->
 <div class="btn-group btn-group-sm btn-snappy hidden-xs" role="group">
- <a class="btn btn-sm btn-default" href="javascript:void(0);" onclick="addquote({postrow.POST_ID}, '{postrow.POST_AUTHOR}', '{LA_WROTE}');" title="{L_QUOTE} {postrow.POST_AUTHOR}"><i class="fa fa-comment"></i></a>
+ <a class="btn btn-sm btn-default" href="javascript:void(0);" onclick="addquote({postrow.POST_ID}, '{postrow.POST_AUTHOR}', '{postrow.POSTER_ID}', '{LA_WROTE}');" title="{L_QUOTE} {postrow.POST_AUTHOR}"><i class="fa fa-comment"></i></a>
  <a class="btn btn-sm btn-default" href="javascript:void(0);" onclick="insert_text('[b]&#64;{postrow.POST_AUTHOR}[/b], ', false);" title="&#64;{postrow.POST_AUTHOR}"><i class="icon-moon-email icon-moon-fx"></i></a>
 </div>
 <!-- ENDIF -->
diff --git "[ORIGINAL]/sitesplat\\snappy/styles/FLATBOOTS/template/js/script.js" "[FORUM_EXT]/sitesplat\\snappy/styles/FLATBOOTS/template/js/script.js"
--- "[ORIGINAL]/sitesplat\\snappy/styles/FLATBOOTS/template/js/script.js"
+++ "[FORUM_EXT]/sitesplat\\snappy/styles/FLATBOOTS/template/js/script.js"
@@ -4,11 +4,12 @@ head.ready(function () {
 "use strict";
 
 	$(".ccount").characterCounter({
-        counterFormat: '%1 characters remaining',
+        counterFormat: '%1 caracteres restantes',
 		limit: max_post_chars,
     });
 	
 	var button = document.getElementById('show_button')
+	if(!button) return;
     button.addEventListener('click',hideshow,false);
 
     function hideshow() {
@@ -44,14 +45,14 @@ head.ready(function () {
 	});
 	
 	$('#qr_postform').submit(function() {
-        localStorage.clear();
+        localStorage.removeItem("TextEditorData");
     });
 	
 	//lets clear empty local storage and textarea if needed
 	$(".btn-clr").click(function(e) {
         e.preventDefault();
         $(".ccount").val('');
-		localStorage.clear();
+		localStorage.removeItem("TextEditorData");
     });
 	
 //	$('.panel-qr > .qr-textarea > textarea').on('keyup', function(event) {
@@ -63,13 +64,13 @@ head.ready(function () {
 //        }
 //   });
    
-   setInterval(function () {
-	  if($("#message").val().length >= 1) {
-		$(".load").removeAttr("disabled");
-	  } else {
-		$(".load").attr("disabled", "disabled");
-	  }
-	}, 400); //Runs every 0.4s
+	// setInterval(function () {
+	  // if($("#message").val().length >= 1) {
+		// $(".load").removeAttr("disabled");
+	  // } else {
+		// $(".load").attr("disabled", "disabled");
+	  // }
+	// }, 400); //Runs every 0.4s
    
    //	$('.toggleModal').on('click', function () {
    //      $('#col1').toggleClass('col-md-12 col-md-9');
diff --git "[ORIGINAL]/sitesplat\\snappy/styles/FLATBOOTS/template/snappy_quickreply_editor.html" "[FORUM_EXT]/sitesplat\\snappy/styles/FLATBOOTS/template/snappy_quickreply_editor.html"
--- "[ORIGINAL]/sitesplat\\snappy/styles/FLATBOOTS/template/snappy_quickreply_editor.html"
+++ "[FORUM_EXT]/sitesplat\\snappy/styles/FLATBOOTS/template/snappy_quickreply_editor.html"
@@ -31,8 +31,8 @@
 		              {QR_HIDDEN_FIELDS}
 		              <button onclick="document.getElementById('show_button').style.display = 'inline-block';" class="btn btn-default" type="button" data-target=".quick-reply" data-toggle="collapse"><i class="fa fa-times"></i></button>
                       <a role="button" class="btn btn-default togglesnappy"><i class="fa fa-cog"></i></a>
-					  <button type="submit" class="btn btn-default load" disabled="disabled" tabindex="7" name="post" value="{L_SUBMIT}" data-loading-text="{L_LOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_SUBMIT}</button>
-		              <button type="submit" class="btn btn-default load" disabled="disabled" tabindex="6" name="preview" value="{L_FULL_EDITOR}" id="qr_full_editor" data-loading-text="{L_LOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><span class="hidden-xs">{L_FULL_EDITOR}</span><i class="fa fa-search visible-xs"></i></button>		   
+					  <button type="submit" class="btn btn-default load" tabindex="7" name="post" value="{L_SUBMIT}" data-loading-text="{L_LOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_SUBMIT}</button>
+		              <button type="submit" class="btn btn-default load" tabindex="6" name="preview" value="{L_FULL_EDITOR}" id="qr_full_editor" data-loading-text="{L_LOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><span class="hidden-xs">{L_FULL_EDITOR}</span><i class="fa fa-search visible-xs"></i></button>		   
 				   </div>
 			    </div>
             </div>
@@ -45,7 +45,9 @@
 				<!-- IF S_NOTIFY_ALLOWED --><div><input type="checkbox" name="notify" id="notify"{S_NOTIFY_CHECKED}><label class="icheck-control" for="notify">{L_NOTIFY_REPLY}</label></div><!-- ENDIF -->
 				<!-- IF S_LOCK_TOPIC_ALLOWED --><div><input type="checkbox" name="lock_topic" id="lock_topic"{S_LOCK_TOPIC_CHECKED}><label class="icheck-control" for="lock_topic">{L_LOCK_TOPIC}</label></div><!-- ENDIF -->
 				<!-- IF S_LOCK_POST_ALLOWED --><div><input type="checkbox" name="lock_post" id="lock_post"><label class="icheck-control" for="lock_post">{L_LOCK_POST}[{L_LOCK_POST_EXPLAIN}]</label></div><!-- ENDIF -->
+				<!-- IF FORUM_ID eq 55 -->
 					<!-- EVENT quickreply_editor_message_after -->
+				<!-- ENDIF -->
 			    <a role="button" class="btn-link visible-xs pull-right togglesnappy"><i class="fa fa-times"></i></a>
 			   </div>
 			</div>
diff --git "[ORIGINAL]/sitesplat\\snappy/styles/FLATBOOTS/template/snappy_reply_buttons.html" "[FORUM_EXT]/sitesplat\\snappy/styles/FLATBOOTS/template/snappy_reply_buttons.html"
--- "[ORIGINAL]/sitesplat\\snappy/styles/FLATBOOTS/template/snappy_reply_buttons.html"
+++ "[FORUM_EXT]/sitesplat\\snappy/styles/FLATBOOTS/template/snappy_reply_buttons.html"
@@ -29,6 +29,7 @@
 		,cb_{custom_tags.BBCODE_ID}: '{custom_tags.A_BBCODE_HELPLINE}'
 		<!-- END custom_tags -->
 	}
+	<!-- IF S_BBCODEORDER -->
 	function change_palette()
 	{
 		phpbb.toggleDisplay('colour_palette');
@@ -43,9 +44,17 @@
 			document.getElementById('bbpalette').value = '{LA_FONT_COLOR}';
 		}
 	}
+	<!-- ENDIF -->
 </script>
 <script src="{T_THEME_PATH}/vendors/editor.js"></script>
 
+<!-- IF S_BBCODE_ALLOWED and S_BBCODEORDER -->
+<div id="colour_palette" style="display: none;">
+	<label class="control-label">{L_FONT_COLOR}{L_COLON}</label>
+	<div id="color_palette_placeholder" data-orientation="h" data-height="12" data-width="15" data-bbcode="true"></div>
+</div>
+<!-- ENDIF -->
+
 <!-- IF S_BBCODE_ALLOWED -->
 <div class="space10"></div>
 <!-- IF not S_BBCODEORDER -->
@@ -89,7 +98,8 @@
 	<!-- END custom_tags -->
    </div>
 
-	<select class="selectpicker hidden-xs" data-style="btn-default" data-width="auto" name="addbbcode20" onchange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]');this.form.addbbcode20.selectedIndex = 2;" title="{L_BBCODE_F_HELP}">
+	<div class="btn-group hidden-xs">
+		<select class="selectpicker" data-style="btn-default" data-width="auto" name="addbbcode20" onchange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]');this.form.addbbcode20.selectedIndex = 2;" title="{L_BBCODE_F_HELP}">
 			<option value="50">{L_FONT_TINY}</option>
 			<option value="85">{L_FONT_SMALL}</option>
 			<option data-icon="fa fa-font" value="100" selected="selected">{L_FONT_NORMAL}</option>
@@ -101,18 +111,37 @@
 			<!-- ENDIF -->
 		</select>
 		
-	<select class="selectpicker hidden-xs" data-style="btn-default" data-width="auto" name="addbbcode_custom" onchange="bbstyle(this.form.addbbcode_custom.options[this.form.addbbcode_custom.selectedIndex].value*1);this.form.addbbcode_custom.selectedIndex = 0;">
+		<select class="selectpicker" data-style="btn-default" data-width="auto" name="addbbcode_custom" onchange="bbstyle(this.form.addbbcode_custom.options[this.form.addbbcode_custom.selectedIndex].value*1);this.form.addbbcode_custom.selectedIndex = 0;">
 			<option data-icon="fa fa-cog" value="100" selected="selected">{L_BBCODES}</option>
 			<!-- BEGIN custom_tags -->
 				<option value="{custom_tags.BBCODE_ID}" title="{custom_tags.BBCODE_HELPLINE}">{custom_tags.BBCODE_TAG}</option>
 			<!-- END custom_tags -->   
 		</select>
 		<!-- IF S_SHOW_ATTACH_BTN --> 
-	<button type="button" class="btn btn-default" value="{L_PLUPLOAD_ADD_FILES}" id="add_files"><i class="fa fa-cloud-upload"></i>&nbsp;{L_PLUPLOAD_ADD_FILES}</button>
+		<button type="button" class="btn btn-default" value="{L_PLUPLOAD_ADD_FILES}" id="add_files">
+			<i class="fa fa-cloud-upload"></i>&nbsp;{L_PLUPLOAD_ADD_FILES}
+		</button>
+		<!-- ENDIF -->
+	</div>
+    
+	<!-- IF IN_IMGUR -->
+	<div class="btn-group">
+		<div class="fileinput fileinput-new" data-provides="fileinput">
+			<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="if (document.getElementById('postform') != null) { document.getElementById('postform').action += '#imgurAnchor' } else if (document.getElementById('qr_postform') != null) { document.getElementById('qr_postform').action += '#imgurAnchor' };"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_IMGUR_UPLOAD}</button>
+			<span class="btn btn-default btn-file">
+				<span class="fileinput-new"><i class="fa fa-imgur"></i></span>
+				<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
+				<input type="file" name="imgur" id="imgur" />
+			</span>
+			<i class="fa fa-picture-o fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
+			<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
+		</div>
+	</div>
     <!-- ENDIF -->
 	<!-- IF IN_GYAZO -->
+	<div class="btn-group">
 		<div class="fileinput fileinput-new" data-provides="fileinput">
-			<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="document.getElementById('postform').action += '#gyazoAnchor';"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_GYAZO_UPLOAD}</button>
+			<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="if (document.getElementById('postform') != null) { document.getElementById('postform').action += '#gyazoAnchor' } else if (document.getElementById('qr_postform') != null) { document.getElementById('qr_postform').action += '#gyazoAnchor' };"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_GYAZO_UPLOAD}</button>
 			<span class="btn btn-default btn-file">
 				<span class="fileinput-new"><i class="fa fa-gyazo"></i></span>
 				<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
@@ -121,6 +150,7 @@
 			<i class="fa fa-picture-o fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
 			<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
 		</div>
+	</div>
     <!-- ENDIF -->	
 </div>
 <!-- ENDIF -->
```
