Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/rmcgirr83\\genders/config/gender_constants.yml" "[FORUM_EXT]/rmcgirr83\\genders/config/gender_constants.yml"
--- "[ORIGINAL]/rmcgirr83\\genders/config/gender_constants.yml"
+++ "[FORUM_EXT]/rmcgirr83\\genders/config/gender_constants.yml"
@@ -3,15 +3,3 @@ parameters:
         gender_none: 0
         fa-mars: 1
         fa-venus: 2
\ No newline at end of file
-        fa-intersex: 3
-        fa-mars-double: 4
-        fa-mars-stroke: 5
-        fa-mars-stroke-h: 6
-        fa-mars-stroke-v: 7
-        fa-mercury: 8
-        fa-neuter: 9
-        fa-transgender: 10
-        fa-transgender-alt: 11
-        fa-venus-double: 12
-        fa-venus-mars: 13
-        fa-genderless: 14
\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\genders/diff_full.tmp" "[FORUM_EXT]/rmcgirr83\\genders/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\genders/diff_full.tmp"
@@ -0,0 +1,179 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\genders/config/gender_constants.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/config/gender_constants.yml"
+index 67b6685c7..8e2d0c570 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\genders/config/gender_constants.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/config/gender_constants.yml"
+@@ -2,16 +2,4 @@ parameters:
+     gender_constants:
+         gender_none: 0
+         fa-mars: 1
+-        fa-venus: 2
+-        fa-intersex: 3
+-        fa-mars-double: 4
+-        fa-mars-stroke: 5
+-        fa-mars-stroke-h: 6
+-        fa-mars-stroke-v: 7
+-        fa-mercury: 8
+-        fa-neuter: 9
+-        fa-transgender: 10
+-        fa-transgender-alt: 11
+-        fa-venus-double: 12
+-        fa-venus-mars: 13
+-        fa-genderless: 14
+\ No newline at end of file
++        fa-venus: 2
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/memberlist_view_user_statistics_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/memberlist_view_user_statistics_after.html"
+new file mode 100644
+index 000000000..2cebc2b14
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/memberlist_view_user_statistics_after.html"
+@@ -0,0 +1,3 @@
++{% if USER_GENDER %}
++<li>{{ lang('GENDER') }}{{ lang('COLON') }}&nbsp;{{ USER_GENDER }}</li>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/search_results_postprofile_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/search_results_postprofile_after.html"
+new file mode 100644
+index 000000000..034842826
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/search_results_postprofile_after.html"
+@@ -0,0 +1,3 @@
++{% if searchresults.USER_GENDER %}
++&#166;<span class="text-muted">&nbsp;{{ lang('GENDER') }}{{ lang('COLON') }}&nbsp;{{ searchresults.USER_GENDER }}</span>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_profile_profile_info_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_profile_profile_info_before.html"
+new file mode 100644
+index 000000000..ceff15b75
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_profile_profile_info_before.html"
+@@ -0,0 +1 @@
++{% INCLUDE '@rmcgirr83_genders/ucp_user_gender.html' %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_register_profile_fields_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_register_profile_fields_after.html"
+new file mode 100644
+index 000000000..ceff15b75
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_register_profile_fields_after.html"
+@@ -0,0 +1 @@
++{% INCLUDE '@rmcgirr83_genders/ucp_user_gender.html' %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html"
+new file mode 100644
+index 000000000..b35a7a28d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html"
+@@ -0,0 +1,8 @@
++{% if postrow.USER_GENDER %}
++<div class="user-profile-row">
++	<div class="user-profile-tag">{{ lang('GENDER') }}</div>
++		<div class="user-profile-output">
++			{{ postrow.USER_GENDER }}
++		</div>
++</div>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/ucp_user_gender.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/ucp_user_gender.html"
+new file mode 100644
+index 000000000..13262cd4f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/ucp_user_gender.html"
+@@ -0,0 +1,11 @@
++{% if AJAX_GENDER %}
++	<script>
++		var AJAX_GENDER = "{{ AJAX_GENDER|escape('js') }}";
++	</script>
++	<div class="control-group"> 
++		<label class="control-label" for="user_gender">{{ lang('GENDER') }}{{ lang('COLON') }}</label>
++		<div class="controls controls-row"> 
++			<select name="user_gender" id="user_gender">{{ S_GENDER_OPTIONS }}</select>&nbsp;<span id="gender_image" {% if not USER_GENDER %}style="display:none;"{% endif %}><i class="fa {{ USER_GENDER }}" style="font-size:18px"></i></span>
++		</div> 
++	</div> 
++{% endif %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html"
+new file mode 100644
+index 000000000..618f579d3
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html"
+@@ -0,0 +1,7 @@
++{% if USER_GENDER %}
++<li>
++	<span class="icon glyphicon icon-moon-man-woman" style="color:goldenrod"></span>
++	<label>{{ lang('GENDER') }}</label>
++	{{ USER_GENDER }}
++</li>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/search_results_postprofile_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/search_results_postprofile_after.html"
+new file mode 100644
+index 000000000..4038f26a4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/search_results_postprofile_after.html"
+@@ -0,0 +1,3 @@
++{% if searchresults.USER_GENDER %}
++&#166;<span class="text-muted">&nbsp;<i class="icon-moon-man-woman"></i>&nbsp;{{ lang('GENDER') }}{{ lang('COLON') }}&nbsp;{{ searchresults.USER_GENDER }}</span>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html"
+new file mode 100644
+index 000000000..ceff15b75
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html"
+@@ -0,0 +1 @@
++{% INCLUDE '@rmcgirr83_genders/ucp_user_gender.html' %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html"
+new file mode 100644
+index 000000000..ceff15b75
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html"
+@@ -0,0 +1 @@
++{% INCLUDE '@rmcgirr83_genders/ucp_user_gender.html' %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html"
+new file mode 100644
+index 000000000..f9ef783a4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html"
+@@ -0,0 +1,5 @@
++{% if postrow.USER_GENDER %}
++<li>
++	<i class="icon-moon-man-woman" style="color:goldenrod"></i>&nbsp;<strong>{{ lang('GENDER') }}{{ lang('COLON') }}</strong>&nbsp;{{ postrow.USER_GENDER }}
++</li>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/ucp_user_gender.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/ucp_user_gender.html"
+new file mode 100644
+index 000000000..8ed16c2fc
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/ucp_user_gender.html"
+@@ -0,0 +1,11 @@
++{% if AJAX_GENDER %}
++	<script>
++		var AJAX_GENDER = "{{ AJAX_GENDER|escape('js') }}";
++	</script>
++	<div class="control-group"> 
++		<label class="control-label" for="user_gender">{{ lang('GENDER') }}{{ lang('COLON') }}</label>
++		<div class="controls controls-row"> 
++			<select class="selectpicker" data-container="body" name="user_gender" id="user_gender" size="3" title="{L_GENDER}">{{ S_GENDER_OPTIONS }}</select>&nbsp;<span id="gender_image" {% if not USER_GENDER %}style="display:none;"{% endif %}><i class="fa {{ USER_GENDER }}" style="font-size:18px"></i></span>
++		</div>
++	</div>
++{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\genders/styles/all/template/js/genders.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/all/template/js/genders.js"
+index b06d45a88..6ab345ffc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\genders/styles/all/template/js/genders.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/all/template/js/genders.js"
+@@ -5,7 +5,7 @@
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+-
++head.ready(function () { 
+ (function($) { // Avoid conflicts with other libraries
+ 	'use strict';
+ 
+@@ -21,3 +21,4 @@
+ 		});
+ 	});
+ })(jQuery); // Avoid conflicts with other libraries
++});
+\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\genders/diff_nospace.tmp" "[FORUM_EXT]/rmcgirr83\\genders/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\genders/diff_nospace.tmp"
@@ -0,0 +1,184 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\genders/config/gender_constants.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/config/gender_constants.yml"
+index 67b6685c7..8e2d0c570 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\genders/config/gender_constants.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/config/gender_constants.yml"
+@@ -3,15 +3,3 @@ parameters:
+         gender_none: 0
+         fa-mars: 1
+         fa-venus: 2
+\ No newline at end of file
+-        fa-intersex: 3
+-        fa-mars-double: 4
+-        fa-mars-stroke: 5
+-        fa-mars-stroke-h: 6
+-        fa-mars-stroke-v: 7
+-        fa-mercury: 8
+-        fa-neuter: 9
+-        fa-transgender: 10
+-        fa-transgender-alt: 11
+-        fa-venus-double: 12
+-        fa-venus-mars: 13
+-        fa-genderless: 14
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/diff_full.tmp"
+new file mode 100644
+index 000000000..5e82e275b
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/diff_full.tmp"
+@@ -0,0 +1,179 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\genders/config/gender_constants.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/config/gender_constants.yml"
++index 67b6685c7..8e2d0c570 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\genders/config/gender_constants.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/config/gender_constants.yml"
++@@ -2,16 +2,4 @@ parameters:
++     gender_constants:
++         gender_none: 0
++         fa-mars: 1
++-        fa-venus: 2
++-        fa-intersex: 3
++-        fa-mars-double: 4
++-        fa-mars-stroke: 5
++-        fa-mars-stroke-h: 6
++-        fa-mars-stroke-v: 7
++-        fa-mercury: 8
++-        fa-neuter: 9
++-        fa-transgender: 10
++-        fa-transgender-alt: 11
++-        fa-venus-double: 12
++-        fa-venus-mars: 13
++-        fa-genderless: 14
++\ No newline at end of file
+++        fa-venus: 2
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/memberlist_view_user_statistics_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/memberlist_view_user_statistics_after.html"
++new file mode 100644
++index 000000000..2cebc2b14
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/memberlist_view_user_statistics_after.html"
++@@ -0,0 +1,3 @@
+++{% if USER_GENDER %}
+++<li>{{ lang('GENDER') }}{{ lang('COLON') }}&nbsp;{{ USER_GENDER }}</li>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/search_results_postprofile_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/search_results_postprofile_after.html"
++new file mode 100644
++index 000000000..034842826
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/search_results_postprofile_after.html"
++@@ -0,0 +1,3 @@
+++{% if searchresults.USER_GENDER %}
+++&#166;<span class="text-muted">&nbsp;{{ lang('GENDER') }}{{ lang('COLON') }}&nbsp;{{ searchresults.USER_GENDER }}</span>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_profile_profile_info_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_profile_profile_info_before.html"
++new file mode 100644
++index 000000000..ceff15b75
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_profile_profile_info_before.html"
++@@ -0,0 +1 @@
+++{% INCLUDE '@rmcgirr83_genders/ucp_user_gender.html' %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_register_profile_fields_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_register_profile_fields_after.html"
++new file mode 100644
++index 000000000..ceff15b75
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_register_profile_fields_after.html"
++@@ -0,0 +1 @@
+++{% INCLUDE '@rmcgirr83_genders/ucp_user_gender.html' %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html"
++new file mode 100644
++index 000000000..b35a7a28d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html"
++@@ -0,0 +1,8 @@
+++{% if postrow.USER_GENDER %}
+++<div class="user-profile-row">
+++	<div class="user-profile-tag">{{ lang('GENDER') }}</div>
+++		<div class="user-profile-output">
+++			{{ postrow.USER_GENDER }}
+++		</div>
+++</div>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/ucp_user_gender.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/ucp_user_gender.html"
++new file mode 100644
++index 000000000..13262cd4f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/BBOOTS/template/ucp_user_gender.html"
++@@ -0,0 +1,11 @@
+++{% if AJAX_GENDER %}
+++	<script>
+++		var AJAX_GENDER = "{{ AJAX_GENDER|escape('js') }}";
+++	</script>
+++	<div class="control-group"> 
+++		<label class="control-label" for="user_gender">{{ lang('GENDER') }}{{ lang('COLON') }}</label>
+++		<div class="controls controls-row"> 
+++			<select name="user_gender" id="user_gender">{{ S_GENDER_OPTIONS }}</select>&nbsp;<span id="gender_image" {% if not USER_GENDER %}style="display:none;"{% endif %}><i class="fa {{ USER_GENDER }}" style="font-size:18px"></i></span>
+++		</div> 
+++	</div> 
+++{% endif %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html"
++new file mode 100644
++index 000000000..618f579d3
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html"
++@@ -0,0 +1,7 @@
+++{% if USER_GENDER %}
+++<li>
+++	<span class="icon glyphicon icon-moon-man-woman" style="color:goldenrod"></span>
+++	<label>{{ lang('GENDER') }}</label>
+++	{{ USER_GENDER }}
+++</li>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/search_results_postprofile_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/search_results_postprofile_after.html"
++new file mode 100644
++index 000000000..4038f26a4
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/search_results_postprofile_after.html"
++@@ -0,0 +1,3 @@
+++{% if searchresults.USER_GENDER %}
+++&#166;<span class="text-muted">&nbsp;<i class="icon-moon-man-woman"></i>&nbsp;{{ lang('GENDER') }}{{ lang('COLON') }}&nbsp;{{ searchresults.USER_GENDER }}</span>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html"
++new file mode 100644
++index 000000000..ceff15b75
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html"
++@@ -0,0 +1 @@
+++{% INCLUDE '@rmcgirr83_genders/ucp_user_gender.html' %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html"
++new file mode 100644
++index 000000000..ceff15b75
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html"
++@@ -0,0 +1 @@
+++{% INCLUDE '@rmcgirr83_genders/ucp_user_gender.html' %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html"
++new file mode 100644
++index 000000000..f9ef783a4
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html"
++@@ -0,0 +1,5 @@
+++{% if postrow.USER_GENDER %}
+++<li>
+++	<i class="icon-moon-man-woman" style="color:goldenrod"></i>&nbsp;<strong>{{ lang('GENDER') }}{{ lang('COLON') }}</strong>&nbsp;{{ postrow.USER_GENDER }}
+++</li>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/ucp_user_gender.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/ucp_user_gender.html"
++new file mode 100644
++index 000000000..8ed16c2fc
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\genders/styles/FLATBOOTS/template/ucp_user_gender.html"
++@@ -0,0 +1,11 @@
+++{% if AJAX_GENDER %}
+++	<script>
+++		var AJAX_GENDER = "{{ AJAX_GENDER|escape('js') }}";
+++	</script>
+++	<div class="control-group"> 
+++		<label class="control-label" for="user_gender">{{ lang('GENDER') }}{{ lang('COLON') }}</label>
+++		<div class="controls controls-row"> 
+++			<select class="selectpicker" data-container="body" name="user_gender" id="user_gender" size="3" title="{L_GENDER}">{{ S_GENDER_OPTIONS }}</select>&nbsp;<span id="gender
\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/memberlist_view_user_statistics_after.html" "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/memberlist_view_user_statistics_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/memberlist_view_user_statistics_after.html"
@@ -0,0 +1,3 @@
+{% if USER_GENDER %}
+<li>{{ lang('GENDER') }}{{ lang('COLON') }}&nbsp;{{ USER_GENDER }}</li>
+{% endif %}
diff --git "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/search_results_postprofile_after.html" "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/search_results_postprofile_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/search_results_postprofile_after.html"
@@ -0,0 +1,3 @@
+{% if searchresults.USER_GENDER %}
+&#166;<span class="text-muted">&nbsp;{{ lang('GENDER') }}{{ lang('COLON') }}&nbsp;{{ searchresults.USER_GENDER }}</span>
+{% endif %}
diff --git "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_profile_profile_info_before.html" "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_profile_profile_info_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_profile_profile_info_before.html"
@@ -0,0 +1 @@
+{% INCLUDE '@rmcgirr83_genders/ucp_user_gender.html' %}
\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_register_profile_fields_after.html" "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_register_profile_fields_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/ucp_register_profile_fields_after.html"
@@ -0,0 +1 @@
+{% INCLUDE '@rmcgirr83_genders/ucp_user_gender.html' %}
\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html" "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html"
@@ -0,0 +1,8 @@
+{% if postrow.USER_GENDER %}
+<div class="user-profile-row">
+	<div class="user-profile-tag">{{ lang('GENDER') }}</div>
+		<div class="user-profile-output">
+			{{ postrow.USER_GENDER }}
+		</div>
+</div>
+{% endif %}
diff --git "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/ucp_user_gender.html" "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/ucp_user_gender.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\genders/styles/BBOOTS/template/ucp_user_gender.html"
@@ -0,0 +1,11 @@
+{% if AJAX_GENDER %}
+	<script>
+		var AJAX_GENDER = "{{ AJAX_GENDER|escape('js') }}";
+	</script>
+	<div class="control-group"> 
+		<label class="control-label" for="user_gender">{{ lang('GENDER') }}{{ lang('COLON') }}</label>
+		<div class="controls controls-row"> 
+			<select name="user_gender" id="user_gender">{{ S_GENDER_OPTIONS }}</select>&nbsp;<span id="gender_image" {% if not USER_GENDER %}style="display:none;"{% endif %}><i class="fa {{ USER_GENDER }}" style="font-size:18px"></i></span>
+		</div> 
+	</div> 
+{% endif %}
\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html" "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html"
@@ -0,0 +1,7 @@
+{% if USER_GENDER %}
+<li>
+	<span class="icon glyphicon icon-moon-man-woman" style="color:goldenrod"></span>
+	<label>{{ lang('GENDER') }}</label>
+	{{ USER_GENDER }}
+</li>
+{% endif %}
diff --git "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/search_results_postprofile_after.html" "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/search_results_postprofile_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/search_results_postprofile_after.html"
@@ -0,0 +1,3 @@
+{% if searchresults.USER_GENDER %}
+&#166;<span class="text-muted">&nbsp;<i class="icon-moon-man-woman"></i>&nbsp;{{ lang('GENDER') }}{{ lang('COLON') }}&nbsp;{{ searchresults.USER_GENDER }}</span>
+{% endif %}
diff --git "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html" "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html"
@@ -0,0 +1 @@
+{% INCLUDE '@rmcgirr83_genders/ucp_user_gender.html' %}
\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html" "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html"
@@ -0,0 +1 @@
+{% INCLUDE '@rmcgirr83_genders/ucp_user_gender.html' %}
\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html" "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html"
@@ -0,0 +1,5 @@
+{% if postrow.USER_GENDER %}
+<li>
+	<i class="icon-moon-man-woman" style="color:goldenrod"></i>&nbsp;<strong>{{ lang('GENDER') }}{{ lang('COLON') }}</strong>&nbsp;{{ postrow.USER_GENDER }}
+</li>
+{% endif %}
diff --git "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/ucp_user_gender.html" "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/ucp_user_gender.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\genders/styles/FLATBOOTS/template/ucp_user_gender.html"
@@ -0,0 +1,11 @@
+{% if AJAX_GENDER %}
+	<script>
+		var AJAX_GENDER = "{{ AJAX_GENDER|escape('js') }}";
+	</script>
+	<div class="control-group"> 
+		<label class="control-label" for="user_gender">{{ lang('GENDER') }}{{ lang('COLON') }}</label>
+		<div class="controls controls-row"> 
+			<select class="selectpicker" data-container="body" name="user_gender" id="user_gender" size="3" title="{L_GENDER}">{{ S_GENDER_OPTIONS }}</select>&nbsp;<span id="gender_image" {% if not USER_GENDER %}style="display:none;"{% endif %}><i class="fa {{ USER_GENDER }}" style="font-size:18px"></i></span>
+		</div>
+	</div>
+{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/rmcgirr83\\genders/styles/all/template/js/genders.js" "[FORUM_EXT]/rmcgirr83\\genders/styles/all/template/js/genders.js"
--- "[ORIGINAL]/rmcgirr83\\genders/styles/all/template/js/genders.js"
+++ "[FORUM_EXT]/rmcgirr83\\genders/styles/all/template/js/genders.js"
@@ -5,7 +5,7 @@
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */
-
+head.ready(function () { 
 (function($) { // Avoid conflicts with other libraries
 	'use strict';
 
@@ -21,3 +21,4 @@
 		});
 	});
 })(jQuery); // Avoid conflicts with other libraries
+});
\ No newline at end of file
```
