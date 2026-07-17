Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/sitesplat\\bbcodeorder/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bbcodeorder/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbcodeorder/diff_full.tmp"
@@ -0,0 +1,99 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcodeorder/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/language/en/common.php"
+index 0f573b12a..ee4808e07 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcodeorder/language/en/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/language/en/common.php"
+@@ -29,6 +29,7 @@ $lang = array_merge($lang, array(
+ 	'BBCODE_ICON_EXPLAIN'		=> '<a href="https://fontawesome.io/icons/">Font Awesome icon</a> without fa- prefix.',
+ 	'BBCODE_GROUP'				=> 'Manage groups that can use this BBCode',
+ 	'BBCODE_GROUP_EXPLAIN'		=> 'If no groups are selected, then all users can use this BBCode. Use CTRL+CLICK (or CMD+CLICK on Mac) to select/deselect more than one group.',
++	'BBCODEORDER_IMGUR_UPLOAD'	=> 'Click to upload to IMGUR',
+ 	'BBCODEORDER_GYAZO_UPLOAD'	=> 'Click to upload to GYAZO',
+ 	
+ 	'BBCODE_B'						=> 'Bold',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcodeorder/styles/BBOOTS/template/bbcodeorder_posting_buttons.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/styles/BBOOTS/template/bbcodeorder_posting_buttons.html"
+index c2d510f6b..191a5fb15 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcodeorder/styles/BBOOTS/template/bbcodeorder_posting_buttons.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/styles/BBOOTS/template/bbcodeorder_posting_buttons.html"
+@@ -117,7 +117,19 @@
+ 			<button type="button" class="btn btn-default" value="{L_PLUPLOAD_ADD_FILES}" id="add_files"><i class="fa fa-cloud-upload"></i>&nbsp;{L_PLUPLOAD_ADD_FILES}</button>
+ 		{% endif %}
+ 		
+-	   {% if IN_GYAZO and S_SNAPPY %}
++	   {% if IN_IMGUR and S_SNAPPY %}
++		<div class="fileinput fileinput-new" data-provides="fileinput">
++			<button type="submit" name="add_image" title="{{ lang('BBCODEORDER_IMGUR_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="document.getElementById('postform').action += '#imgurAnchor';"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-upload"></i></button>
++			<span class="btn btn-default btn-file">
++				<span class="fileinput-new"><i class="fa fa-imgur"></i></span>
++				<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
++				<input type="file" name="imgur" id="imgur" maxlength="{FILESIZE}" />
++			</span>
++			<i class="fa fa-picture-o fileinput-exists"></i> <span class="fileinput-filename"></span>
++			<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
++		</div>
++		{% endif %}
++		{% if IN_GYAZO and S_SNAPPY %}
+ 		<div class="fileinput fileinput-new" data-provides="fileinput">
+ 			<button type="submit" name="add_image" title="{{ lang('BBCODEORDER_GYAZO_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="document.getElementById('postform').action += '#gyazoAnchor';"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-upload"></i></button>
+ 			<span class="btn btn-default btn-file">
+@@ -128,7 +140,7 @@
+ 			<i class="fa fa-picture-o fileinput-exists"></i> <span class="fileinput-filename"></span>
+ 			<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
+ 		</div>
+-       {% endif %}
++		{% endif %}
+ 	
+ 	</div>
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcodeorder/styles/FLATBOOTS/template/bbcodeorder_posting_buttons.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/styles/FLATBOOTS/template/bbcodeorder_posting_buttons.html"
+index c2d510f6b..efeb11e24 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcodeorder/styles/FLATBOOTS/template/bbcodeorder_posting_buttons.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/styles/FLATBOOTS/template/bbcodeorder_posting_buttons.html"
+@@ -117,18 +117,34 @@
+ 			<button type="button" class="btn btn-default" value="{L_PLUPLOAD_ADD_FILES}" id="add_files"><i class="fa fa-cloud-upload"></i>&nbsp;{L_PLUPLOAD_ADD_FILES}</button>
+ 		{% endif %}
+ 		
+-	   {% if IN_GYAZO and S_SNAPPY %}
+-		<div class="fileinput fileinput-new" data-provides="fileinput">
+-			<button type="submit" name="add_image" title="{{ lang('BBCODEORDER_GYAZO_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="document.getElementById('postform').action += '#gyazoAnchor';"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-upload"></i></button>
+-			<span class="btn btn-default btn-file">
+-				<span class="fileinput-new"><i class="fa fa-gyazo"></i></span>
+-				<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
+-				<input type="file" name="gyazo" id="gyazo" maxlength="{FILESIZE}" />
+-			</span>
+-			<i class="fa fa-picture-o fileinput-exists"></i> <span class="fileinput-filename"></span>
+-			<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
++		{% if IN_IMGUR and S_SNAPPY %}
++		<div class="btn-group">
++			<div class="fileinput fileinput-new" data-provides="fileinput">
++				<button type="submit" name="add_image" title="{{ lang('BBCODEORDER_IMGUR_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="document.getElementById('postform').action += '#imgurAnchor';"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-upload"></i></button>
++				<span class="btn btn-default btn-file">
++					<span class="fileinput-new"><i class="fa fa-imgur"></i></span>
++					<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
++					<input type="file" name="imgur" id="imgur" maxlength="{FILESIZE}" style="cursor:pointer" />
++				</span>
++				<i class="fa fa-picture-o fileinput-exists"></i> <span class="fileinput-filename"></span>
++				<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
++			</div>
+ 		</div>
+-       {% endif %}
++		{% endif %}
++		{% if IN_GYAZO and S_SNAPPY %}
++		<div class="btn-group">
++			<div class="fileinput fileinput-new" data-provides="fileinput">
++				<button type="submit" name="add_image" title="{{ lang('BBCODEORDER_GYAZO_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="document.getElementById('postform').action += '#gyazoAnchor';"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-upload"></i></button>
++				<span class="btn btn-default btn-file">
++					<span class="fileinput-new"><i class="fa fa-gyazo"></i></span>
++					<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
++					<input type="file" name="gyazo" id="gyazo" maxlength="{FILESIZE}" style="cursor:pointer" />
++				</span>
++				<i class="fa fa-picture-o fileinput-exists"></i> <span class="fileinput-filename"></span>
++				<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
++			</div>
++		</div>
++		{% endif %}
+ 	
+ 	</div>
+ {% endif %}
diff --git "[FORUM_EXT]/sitesplat\\bbcodeorder/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bbcodeorder/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbcodeorder/diff_nospace.tmp"
@@ -0,0 +1,95 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/diff_full.tmp"
+new file mode 100644
+index 000000000..32fc732ef
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/diff_full.tmp"
+@@ -0,0 +1,99 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcodeorder/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/language/en/common.php"
++index 0f573b12a..ee4808e07 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcodeorder/language/en/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/language/en/common.php"
++@@ -29,6 +29,7 @@ $lang = array_merge($lang, array(
++ 	'BBCODE_ICON_EXPLAIN'		=> '<a href="https://fontawesome.io/icons/">Font Awesome icon</a> without fa- prefix.',
++ 	'BBCODE_GROUP'				=> 'Manage groups that can use this BBCode',
++ 	'BBCODE_GROUP_EXPLAIN'		=> 'If no groups are selected, then all users can use this BBCode. Use CTRL+CLICK (or CMD+CLICK on Mac) to select/deselect more than one group.',
+++	'BBCODEORDER_IMGUR_UPLOAD'	=> 'Click to upload to IMGUR',
++ 	'BBCODEORDER_GYAZO_UPLOAD'	=> 'Click to upload to GYAZO',
++ 	
++ 	'BBCODE_B'						=> 'Bold',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcodeorder/styles/BBOOTS/template/bbcodeorder_posting_buttons.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/styles/BBOOTS/template/bbcodeorder_posting_buttons.html"
++index c2d510f6b..191a5fb15 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcodeorder/styles/BBOOTS/template/bbcodeorder_posting_buttons.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/styles/BBOOTS/template/bbcodeorder_posting_buttons.html"
++@@ -117,7 +117,19 @@
++ 			<button type="button" class="btn btn-default" value="{L_PLUPLOAD_ADD_FILES}" id="add_files"><i class="fa fa-cloud-upload"></i>&nbsp;{L_PLUPLOAD_ADD_FILES}</button>
++ 		{% endif %}
++ 		
++-	   {% if IN_GYAZO and S_SNAPPY %}
+++	   {% if IN_IMGUR and S_SNAPPY %}
+++		<div class="fileinput fileinput-new" data-provides="fileinput">
+++			<button type="submit" name="add_image" title="{{ lang('BBCODEORDER_IMGUR_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="document.getElementById('postform').action += '#imgurAnchor';"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-upload"></i></button>
+++			<span class="btn btn-default btn-file">
+++				<span class="fileinput-new"><i class="fa fa-imgur"></i></span>
+++				<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
+++				<input type="file" name="imgur" id="imgur" maxlength="{FILESIZE}" />
+++			</span>
+++			<i class="fa fa-picture-o fileinput-exists"></i> <span class="fileinput-filename"></span>
+++			<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
+++		</div>
+++		{% endif %}
+++		{% if IN_GYAZO and S_SNAPPY %}
++ 		<div class="fileinput fileinput-new" data-provides="fileinput">
++ 			<button type="submit" name="add_image" title="{{ lang('BBCODEORDER_GYAZO_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="document.getElementById('postform').action += '#gyazoAnchor';"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-upload"></i></button>
++ 			<span class="btn btn-default btn-file">
++@@ -128,7 +140,7 @@
++ 			<i class="fa fa-picture-o fileinput-exists"></i> <span class="fileinput-filename"></span>
++ 			<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
++ 		</div>
++-       {% endif %}
+++		{% endif %}
++ 	
++ 	</div>
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcodeorder/styles/FLATBOOTS/template/bbcodeorder_posting_buttons.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/styles/FLATBOOTS/template/bbcodeorder_posting_buttons.html"
++index c2d510f6b..efeb11e24 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcodeorder/styles/FLATBOOTS/template/bbcodeorder_posting_buttons.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcodeorder/styles/FLATBOOTS/template/bbcodeorder_posting_buttons.html"
++@@ -117,18 +117,34 @@
++ 			<button type="button" class="btn btn-default" value="{L_PLUPLOAD_ADD_FILES}" id="add_files"><i class="fa fa-cloud-upload"></i>&nbsp;{L_PLUPLOAD_ADD_FILES}</button>
++ 		{% endif %}
++ 		
++-	   {% if IN_GYAZO and S_SNAPPY %}
++-		<div class="fileinput fileinput-new" data-provides="fileinput">
++-			<button type="submit" name="add_image" title="{{ lang('BBCODEORDER_GYAZO_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="document.getElementById('postform').action += '#gyazoAnchor';"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-upload"></i></button>
++-			<span class="btn btn-default btn-file">
++-				<span class="fileinput-new"><i class="fa fa-gyazo"></i></span>
++-				<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
++-				<input type="file" name="gyazo" id="gyazo" maxlength="{FILESIZE}" />
++-			</span>
++-			<i class="fa fa-picture-o fileinput-exists"></i> <span class="fileinput-filename"></span>
++-			<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
+++		{% if IN_IMGUR and S_SNAPPY %}
+++		<div class="btn-group">
+++			<div class="fileinput fileinput-new" data-provides="fileinput">
+++				<button type="submit" name="add_image" title="{{ lang('BBCODEORDER_IMGUR_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="document.getElementById('postform').action += '#imgurAnchor';"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-upload"></i></button>
+++				<span class="btn btn-default btn-file">
+++					<span class="fileinput-new"><i class="fa fa-imgur"></i></span>
+++					<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
+++					<input type="file" name="imgur" id="imgur" maxlength="{FILESIZE}" style="cursor:pointer" />
+++				</span>
+++				<i class="fa fa-picture-o fileinput-exists"></i> <span class="fileinput-filename"></span>
+++				<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
+++			</div>
++ 		</div>
++-       {% endif %}
+++		{% endif %}
+++		{% if IN_GYAZO and S_SNAPPY %}
+++		<div class="btn-group">
+++			<div class="fileinput fileinput-new" data-provides="fileinput">
+++				<button type="submit" name="add_image" title="{{ lang('BBCODEORDER_GYAZO_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="document.getElementById('postform').action += '#gyazoAnchor';"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-upload"></i></button>
+++				<span class="btn btn-default btn-file">
+++					<span class="fileinput-new"><i class="fa fa-gyazo"></i></span>
+++					<span class="fileinput-exists"><i class="
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bbcodeorder/language/en/common.php" "[FORUM_EXT]/sitesplat\\bbcodeorder/language/en/common.php"
--- "[ORIGINAL]/sitesplat\\bbcodeorder/language/en/common.php"
+++ "[FORUM_EXT]/sitesplat\\bbcodeorder/language/en/common.php"
@@ -29,6 +29,7 @@ $lang = array_merge($lang, array(
 	'BBCODE_ICON_EXPLAIN'		=> '<a href="https://fontawesome.io/icons/">Font Awesome icon</a> without fa- prefix.',
 	'BBCODE_GROUP'				=> 'Manage groups that can use this BBCode',
 	'BBCODE_GROUP_EXPLAIN'		=> 'If no groups are selected, then all users can use this BBCode. Use CTRL+CLICK (or CMD+CLICK on Mac) to select/deselect more than one group.',
+	'BBCODEORDER_IMGUR_UPLOAD'	=> 'Click to upload to IMGUR',
 	'BBCODEORDER_GYAZO_UPLOAD'	=> 'Click to upload to GYAZO',
 	
 	'BBCODE_B'						=> 'Bold',
diff --git "[ORIGINAL]/sitesplat\\bbcodeorder/styles/BBOOTS/template/bbcodeorder_posting_buttons.html" "[FORUM_EXT]/sitesplat\\bbcodeorder/styles/BBOOTS/template/bbcodeorder_posting_buttons.html"
--- "[ORIGINAL]/sitesplat\\bbcodeorder/styles/BBOOTS/template/bbcodeorder_posting_buttons.html"
+++ "[FORUM_EXT]/sitesplat\\bbcodeorder/styles/BBOOTS/template/bbcodeorder_posting_buttons.html"
@@ -117,6 +117,18 @@
 			<button type="button" class="btn btn-default" value="{L_PLUPLOAD_ADD_FILES}" id="add_files"><i class="fa fa-cloud-upload"></i>&nbsp;{L_PLUPLOAD_ADD_FILES}</button>
 		{% endif %}
 		
+	   {% if IN_IMGUR and S_SNAPPY %}
+		<div class="fileinput fileinput-new" data-provides="fileinput">
+			<button type="submit" name="add_image" title="{{ lang('BBCODEORDER_IMGUR_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="document.getElementById('postform').action += '#imgurAnchor';"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-upload"></i></button>
+			<span class="btn btn-default btn-file">
+				<span class="fileinput-new"><i class="fa fa-imgur"></i></span>
+				<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
+				<input type="file" name="imgur" id="imgur" maxlength="{FILESIZE}" />
+			</span>
+			<i class="fa fa-picture-o fileinput-exists"></i> <span class="fileinput-filename"></span>
+			<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
+		</div>
+		{% endif %}
 		{% if IN_GYAZO and S_SNAPPY %}
 		<div class="fileinput fileinput-new" data-provides="fileinput">
 			<button type="submit" name="add_image" title="{{ lang('BBCODEORDER_GYAZO_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="document.getElementById('postform').action += '#gyazoAnchor';"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-upload"></i></button>
diff --git "[ORIGINAL]/sitesplat\\bbcodeorder/styles/FLATBOOTS/template/bbcodeorder_posting_buttons.html" "[FORUM_EXT]/sitesplat\\bbcodeorder/styles/FLATBOOTS/template/bbcodeorder_posting_buttons.html"
--- "[ORIGINAL]/sitesplat\\bbcodeorder/styles/FLATBOOTS/template/bbcodeorder_posting_buttons.html"
+++ "[FORUM_EXT]/sitesplat\\bbcodeorder/styles/FLATBOOTS/template/bbcodeorder_posting_buttons.html"
@@ -117,17 +117,33 @@
 			<button type="button" class="btn btn-default" value="{L_PLUPLOAD_ADD_FILES}" id="add_files"><i class="fa fa-cloud-upload"></i>&nbsp;{L_PLUPLOAD_ADD_FILES}</button>
 		{% endif %}
 		
+		{% if IN_IMGUR and S_SNAPPY %}
+		<div class="btn-group">
+			<div class="fileinput fileinput-new" data-provides="fileinput">
+				<button type="submit" name="add_image" title="{{ lang('BBCODEORDER_IMGUR_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="document.getElementById('postform').action += '#imgurAnchor';"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-upload"></i></button>
+				<span class="btn btn-default btn-file">
+					<span class="fileinput-new"><i class="fa fa-imgur"></i></span>
+					<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
+					<input type="file" name="imgur" id="imgur" maxlength="{FILESIZE}" style="cursor:pointer" />
+				</span>
+				<i class="fa fa-picture-o fileinput-exists"></i> <span class="fileinput-filename"></span>
+				<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
+			</div>
+		</div>
+		{% endif %}
 		{% if IN_GYAZO and S_SNAPPY %}
+		<div class="btn-group">
 			<div class="fileinput fileinput-new" data-provides="fileinput">
 				<button type="submit" name="add_image" title="{{ lang('BBCODEORDER_GYAZO_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="document.getElementById('postform').action += '#gyazoAnchor';"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-upload"></i></button>
 				<span class="btn btn-default btn-file">
 					<span class="fileinput-new"><i class="fa fa-gyazo"></i></span>
 					<span class="fileinput-exists"><i class="fa fa-edit"></i></span>
-				<input type="file" name="gyazo" id="gyazo" maxlength="{FILESIZE}" />
+					<input type="file" name="gyazo" id="gyazo" maxlength="{FILESIZE}" style="cursor:pointer" />
 				</span>
 				<i class="fa fa-picture-o fileinput-exists"></i> <span class="fileinput-filename"></span>
 				<a href="#" class="close close-file-upload fileinput-exists" data-dismiss="fileinput" style="float:none"><i class="fa fa-times"></i></a>
 			</div>
+		</div>
 		{% endif %}
 	
 	</div>
```
