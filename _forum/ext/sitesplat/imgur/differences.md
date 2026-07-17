Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\imgur/composer.json" "[FORUM_EXT]/sitesplat\\imgur/composer.json"
--- "[ORIGINAL]/sitesplat\\imgur/composer.json"
+++ "[FORUM_EXT]/sitesplat\\imgur/composer.json"
@@ -32,6 +32,5 @@
 			"filename": "imgur.json",
 			"ssl": true
 		}
-
 	}
 }
diff --git "[FORUM_EXT]/sitesplat\\imgur/diff_full.tmp" "[FORUM_EXT]/sitesplat\\imgur/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\imgur/diff_full.tmp"
@@ -0,0 +1,100 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/composer.json"
+index 0f227c035..a7360e6d2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/composer.json"
+@@ -27,11 +27,10 @@
+ 			"phpbb/phpbb": ">=3.1.11,<3.3.*@dev"
+ 		},
+ 		"version-check": {
+-            "host": "sitesplat.com",
+-            "directory": "/updatecheck/phpbb32/ext",
+-            "filename": "imgur.json",
++			"host": "sitesplat.com",
++			"directory": "/updatecheck/phpbb32/ext",
++			"filename": "imgur.json",
+ 			"ssl": true
+ 		}
+-
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/posting_editor_imgur_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/posting_editor_imgur_before.html"
+index c8a3d296f..243648f33 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/posting_editor_imgur_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/posting_editor_imgur_before.html"
+@@ -3,7 +3,7 @@
+ <fieldset>
+ 
+ 	<div class="fileinput fileinput-new" data-provides="fileinput">
+-		<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="document.getElementById('postform').action += '#imgurAnchor';"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_IMGUR_UPLOAD}</button>
++		<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="if (document.getElementById('postform') != null) { document.getElementById('postform').action += '#imgurAnchor' } else if (document.getElementById('qr_postform') != null) { document.getElementById('qr_postform').action += '#imgurAnchor' };"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_IMGUR_UPLOAD}</button>
+ 		<span class="btn btn-default btn-file">
+ 			<span class="fileinput-new">{L_IMGUR_SELECT}</span>
+ 			<span class="fileinput-exists">{L_FILE_CHANGE}</span>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/ucp_profile_signature_options_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/ucp_profile_signature_options_before.html"
+index 526c68bfe..77350f679 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/ucp_profile_signature_options_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/ucp_profile_signature_options_before.html"
+@@ -3,9 +3,8 @@
+ 
+ <fieldset class="framed-ucp">
+ <legend>{{ lang('IMGUR_UPLOAD_TITLE') }}</legend>
+-
+ 	<div class="fileinput fileinput-new" data-provides="fileinput">
+-		<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="document.getElementById('postform').action += '#imgurAnchor';"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{{ lang('IMGUR_UPLOAD') }}</button>
++		<button type="submit" name="add_image" value="{{ lang('IMGUR_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="if (document.getElementById('postform') != null) { document.getElementById('postform').action += '#imgurAnchor' } else if (document.getElementById('qr_postform') != null) { document.getElementById('qr_postform').action += '#imgurAnchor' };"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{{ lang('IMGUR_UPLOAD') }}</button>
+ 		<span class="btn btn-default btn-file">
+ 			<span class="fileinput-new">{{ lang('IMGUR_SELECT') }}</span>
+ 			<span class="fileinput-exists">{{ lang('FILE_CHANGE') }}</span>
+@@ -27,7 +26,7 @@
+ 	    </div> 
+     </div>
+ 
+-	<div class="control-group"> 
++	<div class="control-group">
+ 		<label class="control-label" for="box-imgur-img">{{ lang('IMGUR_OUTPUT_IMAGE') }}{{ lang('COLON') }}</label>
+ 		<div class="controls controls-row"> 
+ 			<div class="input-group col-md-6">
+@@ -43,7 +42,7 @@
+ 		<label class="control-label" for="box-imgur-del">{{ lang('IMGUR_OUTPUT_IMAGE_DELETE') }}{{ lang('COLON') }}</label>
+ 		<div class="controls controls-row"> 
+ 			<div class="input-group col-md-6">
+-				<input type="text" class="form-control" id="box-imgur-del" <!-- IF IMGUR_DELETEHASH -->value="http://imgur.com/delete/{{ IMGUR_DELETEHASH }}"<!-- ENDIF --> placeholder="{{ lang('IMGUR_OUTPUT_PLACEHOLDER') }}">
++				<input type="text" class="form-control" id="box-imgur-del" {% if IMGUR_DELETEHASH %}value="http://imgur.com/delete/{{ IMGUR_DELETEHASH }}"{% endif %} placeholder="{{ lang('IMGUR_OUTPUT_PLACEHOLDER') }}">
+ 				<span class="input-group-btn">
+ 					<a class="btn btn-default btn-imgur-copy" id="copy-button-del" data-clipboard-snippet="" title=""><i class="fa fa-clipboard"></i>&nbsp;{{ lang('IMGUR_COPY') }}</a>
+ 				</span>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/styles/FLATBOOTS/template/ucp_avatar_options_imgur.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/styles/FLATBOOTS/template/ucp_avatar_options_imgur.html"
+index 1969bcb56..d89b08891 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/styles/FLATBOOTS/template/ucp_avatar_options_imgur.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/styles/FLATBOOTS/template/ucp_avatar_options_imgur.html"
+@@ -1,19 +1,19 @@
+ <div class="control-group"> 
+ 	<div class="controls controls-row"> 
+ 	  <div style="max-width: 200px;" class="fileinput fileinput-new" data-provides="fileinput">
+-	   <label for="avatar_upload_file" class="control-label fileinput-exists">{L_PREVIEW}{L_COLON}</label>
++	   <label for="avatar_upload_file" class="control-label fileinput-exists">{{ lang('PREVIEW') }}{{ lang('COLON') }}</label>
+ 		  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
+ 		   <div>
+ 			<span class="btn btn-default btn-file">
+-			<span class="fileinput-new"><i class="fa fa-picture-o"></i>&nbsp;{L_SELECT_IMAGE}</span>
+-			<span class="fileinput-exists">{L_CHANGE}</span>
+-			 <input type="hidden" name="MAX_FILE_SIZE" value="{AVATAR_UPLOAD_SIZE}" />
++			<span class="fileinput-new"><i class="fa fa-picture-o"></i>&nbsp;{{ lang('SELECT_IMAGE') }}</span>
++			<span class="fileinput-exists">{{ lang('CHANGE') }}</span>
++			 <input type="hidden" name="MAX_FILE_SIZE" value="{{ AVATAR_UPLOAD_SIZE }}" />
+ 			  <input type="file" name="imgur" id="imgur" class="default" accept="image/*">
+ 			</span>
+-			<a href="#" title="{L_DELETE_AVATAR}" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
++			<a href="#" title="{{ lang('DELETE_AVATAR') }}" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
+ 		   </div>
+-		<div class="space10 fileinput-exists"></div>	
+-	   <div class="help-block fileinput-exists"><span class="label label-info">{L_NOTE}</span>&nbsp;{L_UCP_SUBMIT_TO_UPLOAD}</div>
++		<div class="space10 fileinput-exists"></div>
++	   <div class="help-block fileinput-exists"><span class="label label-info">{{ lang('NOTE') }}</span>&nbsp;{{ lang('UCP_SUBMIT_TO_UPLOAD') }}</div>
+ 	  </div>
+ 	</div>
+ </div>
+\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\imgur/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\imgur/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\imgur/diff_nospace.tmp"
@@ -0,0 +1,99 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/composer.json"
+index 0f227c035..a7360e6d2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/composer.json"
+@@ -32,6 +32,5 @@
+ 			"filename": "imgur.json",
+ 			"ssl": true
+ 		}
+-
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/diff_full.tmp"
+new file mode 100644
+index 000000000..9e8118708
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/diff_full.tmp"
+@@ -0,0 +1,100 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/composer.json"
++index 0f227c035..a7360e6d2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/composer.json"
++@@ -27,11 +27,10 @@
++ 			"phpbb/phpbb": ">=3.1.11,<3.3.*@dev"
++ 		},
++ 		"version-check": {
++-            "host": "sitesplat.com",
++-            "directory": "/updatecheck/phpbb32/ext",
++-            "filename": "imgur.json",
+++			"host": "sitesplat.com",
+++			"directory": "/updatecheck/phpbb32/ext",
+++			"filename": "imgur.json",
++ 			"ssl": true
++ 		}
++-
++ 	}
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/posting_editor_imgur_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/posting_editor_imgur_before.html"
++index c8a3d296f..243648f33 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/posting_editor_imgur_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/posting_editor_imgur_before.html"
++@@ -3,7 +3,7 @@
++ <fieldset>
++ 
++ 	<div class="fileinput fileinput-new" data-provides="fileinput">
++-		<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="document.getElementById('postform').action += '#imgurAnchor';"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_IMGUR_UPLOAD}</button>
+++		<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="if (document.getElementById('postform') != null) { document.getElementById('postform').action += '#imgurAnchor' } else if (document.getElementById('qr_postform') != null) { document.getElementById('qr_postform').action += '#imgurAnchor' };"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_IMGUR_UPLOAD}</button>
++ 		<span class="btn btn-default btn-file">
++ 			<span class="fileinput-new">{L_IMGUR_SELECT}</span>
++ 			<span class="fileinput-exists">{L_FILE_CHANGE}</span>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/ucp_profile_signature_options_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/ucp_profile_signature_options_before.html"
++index 526c68bfe..77350f679 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/ucp_profile_signature_options_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/styles/FLATBOOTS/template/event/ucp_profile_signature_options_before.html"
++@@ -3,9 +3,8 @@
++ 
++ <fieldset class="framed-ucp">
++ <legend>{{ lang('IMGUR_UPLOAD_TITLE') }}</legend>
++-
++ 	<div class="fileinput fileinput-new" data-provides="fileinput">
++-		<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="document.getElementById('postform').action += '#imgurAnchor';"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{{ lang('IMGUR_UPLOAD') }}</button>
+++		<button type="submit" name="add_image" value="{{ lang('IMGUR_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="if (document.getElementById('postform') != null) { document.getElementById('postform').action += '#imgurAnchor' } else if (document.getElementById('qr_postform') != null) { document.getElementById('qr_postform').action += '#imgurAnchor' };"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{{ lang('IMGUR_UPLOAD') }}</button>
++ 		<span class="btn btn-default btn-file">
++ 			<span class="fileinput-new">{{ lang('IMGUR_SELECT') }}</span>
++ 			<span class="fileinput-exists">{{ lang('FILE_CHANGE') }}</span>
++@@ -27,7 +26,7 @@
++ 	    </div> 
++     </div>
++ 
++-	<div class="control-group"> 
+++	<div class="control-group">
++ 		<label class="control-label" for="box-imgur-img">{{ lang('IMGUR_OUTPUT_IMAGE') }}{{ lang('COLON') }}</label>
++ 		<div class="controls controls-row"> 
++ 			<div class="input-group col-md-6">
++@@ -43,7 +42,7 @@
++ 		<label class="control-label" for="box-imgur-del">{{ lang('IMGUR_OUTPUT_IMAGE_DELETE') }}{{ lang('COLON') }}</label>
++ 		<div class="controls controls-row"> 
++ 			<div class="input-group col-md-6">
++-				<input type="text" class="form-control" id="box-imgur-del" <!-- IF IMGUR_DELETEHASH -->value="http://imgur.com/delete/{{ IMGUR_DELETEHASH }}"<!-- ENDIF --> placeholder="{{ lang('IMGUR_OUTPUT_PLACEHOLDER') }}">
+++				<input type="text" class="form-control" id="box-imgur-del" {% if IMGUR_DELETEHASH %}value="http://imgur.com/delete/{{ IMGUR_DELETEHASH }}"{% endif %} placeholder="{{ lang('IMGUR_OUTPUT_PLACEHOLDER') }}">
++ 				<span class="input-group-btn">
++ 					<a class="btn btn-default btn-imgur-copy" id="copy-button-del" data-clipboard-snippet="" title=""><i class="fa fa-clipboard"></i>&nbsp;{{ lang('IMGUR_COPY') }}</a>
++ 				</span>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/styles/FLATBOOTS/template/ucp_avatar_options_imgur.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/styles/FLATBOOTS/template/ucp_avatar_options_imgur.html"
++index 1969bcb56..d89b08891 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\imgur/styles/FLATBOOTS/template/ucp_avatar_options_imgur.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\imgur/styles/FLATBOOTS/template/ucp_avatar_options_imgur.html"
++@@ -1,19 +1,19 @@
++ <div class="control-group"> 
++ 	<div class="controls controls-row"> 
++ 	  <div style="max-width: 200px;" class="fileinput fileinput-new" data-provides="fileinput">
++-	   <label for="avatar_upload_file" class="control-label fileinput-exists">{L_PREVIEW}{L_COLON}</label>
+++	   <label for="avatar_upload_file" class="control-label fileinput-exists">{{ lang('PREVIEW') }}{{ lang('COLON') }}</label>
++ 		  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
++ 		   <div>
++ 			<span class="btn btn-default btn-file">
++-			<span class="fileinput-new"><i class=
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\imgur/styles/FLATBOOTS/template/event/posting_editor_imgur_before.html" "[FORUM_EXT]/sitesplat\\imgur/styles/FLATBOOTS/template/event/posting_editor_imgur_before.html"
--- "[ORIGINAL]/sitesplat\\imgur/styles/FLATBOOTS/template/event/posting_editor_imgur_before.html"
+++ "[FORUM_EXT]/sitesplat\\imgur/styles/FLATBOOTS/template/event/posting_editor_imgur_before.html"
@@ -3,7 +3,7 @@
 <fieldset>
 
 	<div class="fileinput fileinput-new" data-provides="fileinput">
-		<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="document.getElementById('postform').action += '#imgurAnchor';"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_IMGUR_UPLOAD}</button>
+		<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="if (document.getElementById('postform') != null) { document.getElementById('postform').action += '#imgurAnchor' } else if (document.getElementById('qr_postform') != null) { document.getElementById('qr_postform').action += '#imgurAnchor' };"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{L_IMGUR_UPLOAD}</button>
 		<span class="btn btn-default btn-file">
 			<span class="fileinput-new">{L_IMGUR_SELECT}</span>
 			<span class="fileinput-exists">{L_FILE_CHANGE}</span>
diff --git "[ORIGINAL]/sitesplat\\imgur/styles/FLATBOOTS/template/event/ucp_profile_signature_options_before.html" "[FORUM_EXT]/sitesplat\\imgur/styles/FLATBOOTS/template/event/ucp_profile_signature_options_before.html"
--- "[ORIGINAL]/sitesplat\\imgur/styles/FLATBOOTS/template/event/ucp_profile_signature_options_before.html"
+++ "[FORUM_EXT]/sitesplat\\imgur/styles/FLATBOOTS/template/event/ucp_profile_signature_options_before.html"
@@ -3,9 +3,8 @@
 
 <fieldset class="framed-ucp">
 <legend>{{ lang('IMGUR_UPLOAD_TITLE') }}</legend>
-
 	<div class="fileinput fileinput-new" data-provides="fileinput">
-		<button type="submit" name="add_image" value="Upload Image" class="btn btn-success fileinput-exists" <!-- IF not S_PRIVMSGS -->onclick="document.getElementById('postform').action += '#imgurAnchor';"<!-- ENDIF --> data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{{ lang('IMGUR_UPLOAD') }}</button>
+		<button type="submit" name="add_image" value="{{ lang('IMGUR_UPLOAD') }}" class="btn btn-success fileinput-exists" {% if not S_PRIVMSGS %}onclick="if (document.getElementById('postform') != null) { document.getElementById('postform').action += '#imgurAnchor' } else if (document.getElementById('qr_postform') != null) { document.getElementById('qr_postform').action += '#imgurAnchor' };"{% endif %} data-loading-text="{L_FILE_UPLOADING}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">{{ lang('IMGUR_UPLOAD') }}</button>
 		<span class="btn btn-default btn-file">
 			<span class="fileinput-new">{{ lang('IMGUR_SELECT') }}</span>
 			<span class="fileinput-exists">{{ lang('FILE_CHANGE') }}</span>
@@ -43,7 +42,7 @@
 		<label class="control-label" for="box-imgur-del">{{ lang('IMGUR_OUTPUT_IMAGE_DELETE') }}{{ lang('COLON') }}</label>
 		<div class="controls controls-row"> 
 			<div class="input-group col-md-6">
-				<input type="text" class="form-control" id="box-imgur-del" <!-- IF IMGUR_DELETEHASH -->value="http://imgur.com/delete/{{ IMGUR_DELETEHASH }}"<!-- ENDIF --> placeholder="{{ lang('IMGUR_OUTPUT_PLACEHOLDER') }}">
+				<input type="text" class="form-control" id="box-imgur-del" {% if IMGUR_DELETEHASH %}value="http://imgur.com/delete/{{ IMGUR_DELETEHASH }}"{% endif %} placeholder="{{ lang('IMGUR_OUTPUT_PLACEHOLDER') }}">
 				<span class="input-group-btn">
 					<a class="btn btn-default btn-imgur-copy" id="copy-button-del" data-clipboard-snippet="" title=""><i class="fa fa-clipboard"></i>&nbsp;{{ lang('IMGUR_COPY') }}</a>
 				</span>
diff --git "[ORIGINAL]/sitesplat\\imgur/styles/FLATBOOTS/template/ucp_avatar_options_imgur.html" "[FORUM_EXT]/sitesplat\\imgur/styles/FLATBOOTS/template/ucp_avatar_options_imgur.html"
--- "[ORIGINAL]/sitesplat\\imgur/styles/FLATBOOTS/template/ucp_avatar_options_imgur.html"
+++ "[FORUM_EXT]/sitesplat\\imgur/styles/FLATBOOTS/template/ucp_avatar_options_imgur.html"
@@ -1,19 +1,19 @@
 <div class="control-group"> 
 	<div class="controls controls-row"> 
 	  <div style="max-width: 200px;" class="fileinput fileinput-new" data-provides="fileinput">
-	   <label for="avatar_upload_file" class="control-label fileinput-exists">{L_PREVIEW}{L_COLON}</label>
+	   <label for="avatar_upload_file" class="control-label fileinput-exists">{{ lang('PREVIEW') }}{{ lang('COLON') }}</label>
 		  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
 		   <div>
 			<span class="btn btn-default btn-file">
-			<span class="fileinput-new"><i class="fa fa-picture-o"></i>&nbsp;{L_SELECT_IMAGE}</span>
-			<span class="fileinput-exists">{L_CHANGE}</span>
-			 <input type="hidden" name="MAX_FILE_SIZE" value="{AVATAR_UPLOAD_SIZE}" />
+			<span class="fileinput-new"><i class="fa fa-picture-o"></i>&nbsp;{{ lang('SELECT_IMAGE') }}</span>
+			<span class="fileinput-exists">{{ lang('CHANGE') }}</span>
+			 <input type="hidden" name="MAX_FILE_SIZE" value="{{ AVATAR_UPLOAD_SIZE }}" />
 			  <input type="file" name="imgur" id="imgur" class="default" accept="image/*">
 			</span>
-			<a href="#" title="{L_DELETE_AVATAR}" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
+			<a href="#" title="{{ lang('DELETE_AVATAR') }}" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
 		   </div>
 		<div class="space10 fileinput-exists"></div>
-	   <div class="help-block fileinput-exists"><span class="label label-info">{L_NOTE}</span>&nbsp;{L_UCP_SUBMIT_TO_UPLOAD}</div>
+	   <div class="help-block fileinput-exists"><span class="label label-info">{{ lang('NOTE') }}</span>&nbsp;{{ lang('UCP_SUBMIT_TO_UPLOAD') }}</div>
 	  </div>
 	</div>
 </div>
\ No newline at end of file
```
