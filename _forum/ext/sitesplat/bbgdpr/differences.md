Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/sitesplat\\bbgdpr/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bbgdpr/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbgdpr/diff_full.tmp"
@@ -0,0 +1,158 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/event/main_listener.php"
+index 0c6bba219..cbccf4192 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/event/main_listener.php"
+@@ -200,7 +200,7 @@ class main_listener implements EventSubscriberInterface
+ 		}
+ 
+ 		// privacy page itself
+-		if (strpos($url, "{$script_path}/privacy") === 0)
++		if (strrchr(rtrim(parse_url($url, PHP_URL_PATH), '/'), '/') === '/privacy')
+ 		{
+ 			return true;
+ 		}
+@@ -217,6 +217,12 @@ class main_listener implements EventSubscriberInterface
+ 			return true;
+ 		}
+ 
++		// Force change email extensions
++		if (strpos($this->user->page['query_string'], 'mode=reg_details') !== false)
++		{
++			return true;
++		}
++
+ 		// review personal data
+ 		if (strpos($url, 'ucp.') !== false && strpos($url, 'mode=review') !== false && strpos($url, 'i=-sitesplat-bbgdpr-ucp-main_module') !== false)
+ 		{
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ss_ucp_login_link_register_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ss_ucp_login_link_register_append.html"
+index e62b4d58d..252804bf4 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ss_ucp_login_link_register_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ss_ucp_login_link_register_append.html"
+@@ -3,14 +3,14 @@
+ 	    <div class="row">
+ 			<div class="col-md-6">
+ 				<div class="form-group">
+-					<label for="sitesplat_bbgdpr_bulk_emails" class="check-control">{{ lang('BULK_EMAILS_QUICK_AGREE') ~ lang('COLON') }}</label>
+-					<input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" />&nbsp;{{ lang('REG_UNDRSTD') }}
++					{{ lang('BULK_EMAILS_QUICK_AGREE') ~ lang('COLON') }}
++					<input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" />&nbsp;<label for="sitesplat_bbgdpr_bulk_emails" class="check-control">{{ lang('REG_UNDRSTD') }}</label>
+ 				</div>
+ 			</div>
+ 			<div class="col-md-6">
+ 				<div class="form-group">
+-					<label for="sitesplat_bbgdpr_privacy_policy" class="check-control">{{ lang('PRIVACY_POLICY_QUICK_AGREE') ~ lang('COLON') }}</label>
+-					<input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" />&nbsp;{{ lang('REG_UNDRSTD') }}
++					{{ lang('PRIVACY_POLICY_QUICK_AGREE') ~ lang('COLON') }}
++					<input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" />&nbsp;<label for="sitesplat_bbgdpr_privacy_policy" class="check-control">	{{ lang('REG_UNDRSTD') }}</label>
+ 				</div>
+ 			</div>
+ 		</div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ucp_register_buttons_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ucp_register_buttons_before.html"
+index 50e5de2b9..69e10291c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ucp_register_buttons_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ucp_register_buttons_before.html"
+@@ -4,17 +4,18 @@
+ 		<div class="row">
+ 			<div class="col-md-6">
+ 			<div class="form-group">
+-				<label for="sitesplat_bbgdpr_bulk_emails" class="check-control">{{ lang('BULK_EMAILS') ~ lang('COLON') }}</label><span class="help-block">{{ lang('BULK_EMAILS_EXPLAIN') }}</span>
+-				<input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_BULK_EMAILS %} checked{% endif %} /> {{ lang('REG_UNDRSTD') }}
+-				<div class="control-group"></div>
++				{{ lang('BULK_EMAILS') ~ lang('COLON') }}
++				<span class="help-block">{{ lang('BULK_EMAILS_EXPLAIN') }}</span>
++				<div class="d-flex"><input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_BULK_EMAILS %} checked{% endif %} /> <label for="sitesplat_bbgdpr_bulk_emails" class="check-control checkbox-inline">{{ lang('REG_UNDRSTD') }}</label></div>
++				<div class="hidden-md hidden-lg control-group"></div>
+ 			</div>
+ 			</div>
+ 			
+ 			<div class="col-md-6">
+ 				<div class="form-group">
+-					<label for="sitesplat_bbgdpr_privacy_policy" class="check-control">{{ lang('PRIVACY_POLICY') ~ lang('COLON') }}</label><span class="help-block">{{ lang('PRIVACY_POLICY_EXPLAIN') }}</span>
+-					<input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_PRIVACY_POLICY %} checked{% endif %} /> {{ lang('REG_UNDRSTD') }}
+-					<div class="control-group"></div>
++					{{ lang('PRIVACY_POLICY') ~ lang('COLON') }}
++					<span class="help-block">{{ lang('PRIVACY_POLICY_EXPLAIN') }}</span>
++					<div class="d-flex"><input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_PRIVACY_POLICY %} checked{% endif %} /> <label for="sitesplat_bbgdpr_privacy_policy" class="check-control checkbox-inline">{{ lang('REG_UNDRSTD') }}</label></div>
+ 				</div>
+ 				</div>
+ 		</div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/privacy.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/privacy.html"
+index b518085d7..6b8c42255 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/privacy.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/privacy.html"
+@@ -4,7 +4,7 @@
+    <div class="panel-body">
+ 	  {{ PRIVACY_POLICY }}
+ 	  <p><span class="label label label-slategray">{{ lang('BBGDPR_LAST_UPDATED', UPDATE_DATE) }}</span></p>
+-	  <a href="https://goo.gl/BNEDA3" target="_blank"><img class="gdpr-badge" src="https://i.imgur.com/qg7yJwr.png" alt="GDPR compliant extension for phpBB by SiteSplat"></a>
++	  <a href="https://goo.gl/" target="_blank"><img class="gdpr-badge" src="https://i.imgur.com/qg7yJwr.png" alt="GDPR compliant"></a>
+    </div>
+ </div>
+ <!-- IF S_USER_LOGGED_IN -->
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/prosilver/template/event/ss_ucp_login_link_register_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/prosilver/template/event/ss_ucp_login_link_register_append.html"
+new file mode 100644
+index 000000000..e62b4d58d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/prosilver/template/event/ss_ucp_login_link_register_append.html"
+@@ -0,0 +1,29 @@
++{% if S_QUICK_AGREE %}
++	<div class="space10"></div>
++	    <div class="row">
++			<div class="col-md-6">
++				<div class="form-group">
++					<label for="sitesplat_bbgdpr_bulk_emails" class="check-control">{{ lang('BULK_EMAILS_QUICK_AGREE') ~ lang('COLON') }}</label>
++					<input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" />&nbsp;{{ lang('REG_UNDRSTD') }}
++				</div>
++			</div>
++			<div class="col-md-6">
++				<div class="form-group">
++					<label for="sitesplat_bbgdpr_privacy_policy" class="check-control">{{ lang('PRIVACY_POLICY_QUICK_AGREE') ~ lang('COLON') }}</label>
++					<input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" />&nbsp;{{ lang('REG_UNDRSTD') }}
++				</div>
++			</div>
++		</div>
++	<script>
++		document.querySelector('input[name="register"]').disabled = true;
++
++		// uh, oh, opting for this solution because iCheck won't trigger "change" event :/
++		setInterval(function() {
++			if (document.querySelectorAll('#sitesplat_bbgdpr_bulk_emails:checked, #sitesplat_bbgdpr_privacy_policy:checked').length == 2) {
++				document.querySelector('input[name="register"]').disabled = false;
++			} else {
++				document.querySelector('input[name="register"]').disabled = true;
++			}
++		}, 300);
++	</script>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/prosilver/template/event/ucp_register_buttons_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/prosilver/template/event/ucp_register_buttons_before.html"
+new file mode 100644
+index 000000000..50e5de2b9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/prosilver/template/event/ucp_register_buttons_before.html"
+@@ -0,0 +1,22 @@
++<div class="side-segment"><h3>{{ lang('AGREEMENTS') }}</h3></div>
++<fieldset>
++	<div class="well panel-w-form">
++		<div class="row">
++			<div class="col-md-6">
++			<div class="form-group">
++				<label for="sitesplat_bbgdpr_bulk_emails" class="check-control">{{ lang('BULK_EMAILS') ~ lang('COLON') }}</label><span class="help-block">{{ lang('BULK_EMAILS_EXPLAIN') }}</span>
++				<input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_BULK_EMAILS %} checked{% endif %} /> {{ lang('REG_UNDRSTD') }}
++				<div class="control-group"></div>
++			</div>
++			</div>
++			
++			<div class="col-md-6">
++				<div class="form-group">
++					<label for="sitesplat_bbgdpr_privacy_policy" class="check-control">{{ lang('PRIVACY_POLICY') ~ lang('COLON') }}</label><span class="help-block">{{ lang('PRIVACY_POLICY_EXPLAIN') }}</span>
++					<input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_PRIVACY_POLICY %} checked{% endif %} /> {{ lang('REG_UNDRSTD') }}
++					<div class="control-group"></div>
++				</div>
++				</div>
++		</div>
++	</div>
++</fieldset>
+\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\bbgdpr/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bbgdpr/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbgdpr/diff_nospace.tmp"
@@ -0,0 +1,105 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/diff_full.tmp"
+new file mode 100644
+index 000000000..b7fc872ec
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/diff_full.tmp"
+@@ -0,0 +1,158 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/event/main_listener.php"
++index 0c6bba219..cbccf4192 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/event/main_listener.php"
++@@ -200,7 +200,7 @@ class main_listener implements EventSubscriberInterface
++ 		}
++ 
++ 		// privacy page itself
++-		if (strpos($url, "{$script_path}/privacy") === 0)
+++		if (strrchr(rtrim(parse_url($url, PHP_URL_PATH), '/'), '/') === '/privacy')
++ 		{
++ 			return true;
++ 		}
++@@ -217,6 +217,12 @@ class main_listener implements EventSubscriberInterface
++ 			return true;
++ 		}
++ 
+++		// Force change email extensions
+++		if (strpos($this->user->page['query_string'], 'mode=reg_details') !== false)
+++		{
+++			return true;
+++		}
+++
++ 		// review personal data
++ 		if (strpos($url, 'ucp.') !== false && strpos($url, 'mode=review') !== false && strpos($url, 'i=-sitesplat-bbgdpr-ucp-main_module') !== false)
++ 		{
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ss_ucp_login_link_register_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ss_ucp_login_link_register_append.html"
++index e62b4d58d..252804bf4 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ss_ucp_login_link_register_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ss_ucp_login_link_register_append.html"
++@@ -3,14 +3,14 @@
++ 	    <div class="row">
++ 			<div class="col-md-6">
++ 				<div class="form-group">
++-					<label for="sitesplat_bbgdpr_bulk_emails" class="check-control">{{ lang('BULK_EMAILS_QUICK_AGREE') ~ lang('COLON') }}</label>
++-					<input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" />&nbsp;{{ lang('REG_UNDRSTD') }}
+++					{{ lang('BULK_EMAILS_QUICK_AGREE') ~ lang('COLON') }}
+++					<input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" />&nbsp;<label for="sitesplat_bbgdpr_bulk_emails" class="check-control">{{ lang('REG_UNDRSTD') }}</label>
++ 				</div>
++ 			</div>
++ 			<div class="col-md-6">
++ 				<div class="form-group">
++-					<label for="sitesplat_bbgdpr_privacy_policy" class="check-control">{{ lang('PRIVACY_POLICY_QUICK_AGREE') ~ lang('COLON') }}</label>
++-					<input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" />&nbsp;{{ lang('REG_UNDRSTD') }}
+++					{{ lang('PRIVACY_POLICY_QUICK_AGREE') ~ lang('COLON') }}
+++					<input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" />&nbsp;<label for="sitesplat_bbgdpr_privacy_policy" class="check-control">	{{ lang('REG_UNDRSTD') }}</label>
++ 				</div>
++ 			</div>
++ 		</div>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ucp_register_buttons_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ucp_register_buttons_before.html"
++index 50e5de2b9..69e10291c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ucp_register_buttons_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ucp_register_buttons_before.html"
++@@ -4,17 +4,18 @@
++ 		<div class="row">
++ 			<div class="col-md-6">
++ 			<div class="form-group">
++-				<label for="sitesplat_bbgdpr_bulk_emails" class="check-control">{{ lang('BULK_EMAILS') ~ lang('COLON') }}</label><span class="help-block">{{ lang('BULK_EMAILS_EXPLAIN') }}</span>
++-				<input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_BULK_EMAILS %} checked{% endif %} /> {{ lang('REG_UNDRSTD') }}
++-				<div class="control-group"></div>
+++				{{ lang('BULK_EMAILS') ~ lang('COLON') }}
+++				<span class="help-block">{{ lang('BULK_EMAILS_EXPLAIN') }}</span>
+++				<div class="d-flex"><input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_BULK_EMAILS %} checked{% endif %} /> <label for="sitesplat_bbgdpr_bulk_emails" class="check-control checkbox-inline">{{ lang('REG_UNDRSTD') }}</label></div>
+++				<div class="hidden-md hidden-lg control-group"></div>
++ 			</div>
++ 			</div>
++ 			
++ 			<div class="col-md-6">
++ 				<div class="form-group">
++-					<label for="sitesplat_bbgdpr_privacy_policy" class="check-control">{{ lang('PRIVACY_POLICY') ~ lang('COLON') }}</label><span class="help-block">{{ lang('PRIVACY_POLICY_EXPLAIN') }}</span>
++-					<input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_PRIVACY_POLICY %} checked{% endif %} /> {{ lang('REG_UNDRSTD') }}
++-					<div class="control-group"></div>
+++					{{ lang('PRIVACY_POLICY') ~ lang('COLON') }}
+++					<span class="help-block">{{ lang('PRIVACY_POLICY_EXPLAIN') }}</span>
+++					<div class="d-flex"><input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_PRIVACY_POLICY %} checked{% endif %} /> <label for="sitesplat_bbgdpr_privacy_policy" class="check-control checkbox-inline">{{ lang('REG_UNDRSTD') }}</label></div>
++ 				</div>
++ 				</div>
++ 		</div>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/privacy.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/privacy.html"
++index b518085d7..6b8c42255 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/privacy.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/FLATBOOTS/template/privacy.html"
++@@ -4,7 +4,7 @@
++    <div class="panel-body">
++ 	  {{ PRIVACY_POLICY }}
++ 	  <p><span class="label label label-slategray">{{ lang('BBGDPR_LAST_UPDATED', UPDATE_DATE) }}</span></p>
++-	  <a href="https://goo.gl/BNEDA3" target="_blank"><img class="gdpr-badge" src="https://i.imgur.com/qg7yJwr.png" alt="GDPR compliant extension for phpBB by SiteSplat"></a>
+++	  <a href="https://goo.gl/" target="_blank"><img class="gdpr-badge" src="https://i.imgur.com/qg7yJwr.png" alt="GDPR compliant"></a>
++    </div>
++ </div>
++ <!-- IF S_USER_LOGGED_IN -->
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/prosilver/template/event/ss_ucp_login_link_register_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbgdpr/styles/prosilver/template/event/ss_ucp_login_link_register_append.html"
++new file mode 100644
++index 000000000..e62b4d58d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ex
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bbgdpr/event/main_listener.php" "[FORUM_EXT]/sitesplat\\bbgdpr/event/main_listener.php"
--- "[ORIGINAL]/sitesplat\\bbgdpr/event/main_listener.php"
+++ "[FORUM_EXT]/sitesplat\\bbgdpr/event/main_listener.php"
@@ -200,7 +200,7 @@ class main_listener implements EventSubscriberInterface
 		}
 
 		// privacy page itself
-		if (strpos($url, "{$script_path}/privacy") === 0)
+		if (strrchr(rtrim(parse_url($url, PHP_URL_PATH), '/'), '/') === '/privacy')
 		{
 			return true;
 		}
@@ -217,6 +217,12 @@ class main_listener implements EventSubscriberInterface
 			return true;
 		}
 
+		// Force change email extensions
+		if (strpos($this->user->page['query_string'], 'mode=reg_details') !== false)
+		{
+			return true;
+		}
+
 		// review personal data
 		if (strpos($url, 'ucp.') !== false && strpos($url, 'mode=review') !== false && strpos($url, 'i=-sitesplat-bbgdpr-ucp-main_module') !== false)
 		{
diff --git "[ORIGINAL]/sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ss_ucp_login_link_register_append.html" "[FORUM_EXT]/sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ss_ucp_login_link_register_append.html"
--- "[ORIGINAL]/sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ss_ucp_login_link_register_append.html"
+++ "[FORUM_EXT]/sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ss_ucp_login_link_register_append.html"
@@ -3,14 +3,14 @@
 	    <div class="row">
 			<div class="col-md-6">
 				<div class="form-group">
-					<label for="sitesplat_bbgdpr_bulk_emails" class="check-control">{{ lang('BULK_EMAILS_QUICK_AGREE') ~ lang('COLON') }}</label>
-					<input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" />&nbsp;{{ lang('REG_UNDRSTD') }}
+					{{ lang('BULK_EMAILS_QUICK_AGREE') ~ lang('COLON') }}
+					<input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" />&nbsp;<label for="sitesplat_bbgdpr_bulk_emails" class="check-control">{{ lang('REG_UNDRSTD') }}</label>
 				</div>
 			</div>
 			<div class="col-md-6">
 				<div class="form-group">
-					<label for="sitesplat_bbgdpr_privacy_policy" class="check-control">{{ lang('PRIVACY_POLICY_QUICK_AGREE') ~ lang('COLON') }}</label>
-					<input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" />&nbsp;{{ lang('REG_UNDRSTD') }}
+					{{ lang('PRIVACY_POLICY_QUICK_AGREE') ~ lang('COLON') }}
+					<input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" />&nbsp;<label for="sitesplat_bbgdpr_privacy_policy" class="check-control">	{{ lang('REG_UNDRSTD') }}</label>
 				</div>
 			</div>
 		</div>
diff --git "[ORIGINAL]/sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ucp_register_buttons_before.html" "[FORUM_EXT]/sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ucp_register_buttons_before.html"
--- "[ORIGINAL]/sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ucp_register_buttons_before.html"
+++ "[FORUM_EXT]/sitesplat\\bbgdpr/styles/FLATBOOTS/template/event/ucp_register_buttons_before.html"
@@ -4,17 +4,18 @@
 		<div class="row">
 			<div class="col-md-6">
 			<div class="form-group">
-				<label for="sitesplat_bbgdpr_bulk_emails" class="check-control">{{ lang('BULK_EMAILS') ~ lang('COLON') }}</label><span class="help-block">{{ lang('BULK_EMAILS_EXPLAIN') }}</span>
-				<input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_BULK_EMAILS %} checked{% endif %} /> {{ lang('REG_UNDRSTD') }}
-				<div class="control-group"></div>
+				{{ lang('BULK_EMAILS') ~ lang('COLON') }}
+				<span class="help-block">{{ lang('BULK_EMAILS_EXPLAIN') }}</span>
+				<div class="d-flex"><input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_BULK_EMAILS %} checked{% endif %} /> <label for="sitesplat_bbgdpr_bulk_emails" class="check-control checkbox-inline">{{ lang('REG_UNDRSTD') }}</label></div>
+				<div class="hidden-md hidden-lg control-group"></div>
 			</div>
 			</div>
 			
 			<div class="col-md-6">
 				<div class="form-group">
-					<label for="sitesplat_bbgdpr_privacy_policy" class="check-control">{{ lang('PRIVACY_POLICY') ~ lang('COLON') }}</label><span class="help-block">{{ lang('PRIVACY_POLICY_EXPLAIN') }}</span>
-					<input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_PRIVACY_POLICY %} checked{% endif %} /> {{ lang('REG_UNDRSTD') }}
-					<div class="control-group"></div>
+					{{ lang('PRIVACY_POLICY') ~ lang('COLON') }}
+					<span class="help-block">{{ lang('PRIVACY_POLICY_EXPLAIN') }}</span>
+					<div class="d-flex"><input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_PRIVACY_POLICY %} checked{% endif %} /> <label for="sitesplat_bbgdpr_privacy_policy" class="check-control checkbox-inline">{{ lang('REG_UNDRSTD') }}</label></div>
 				</div>
 				</div>
 		</div>
diff --git "[ORIGINAL]/sitesplat\\bbgdpr/styles/FLATBOOTS/template/privacy.html" "[FORUM_EXT]/sitesplat\\bbgdpr/styles/FLATBOOTS/template/privacy.html"
--- "[ORIGINAL]/sitesplat\\bbgdpr/styles/FLATBOOTS/template/privacy.html"
+++ "[FORUM_EXT]/sitesplat\\bbgdpr/styles/FLATBOOTS/template/privacy.html"
@@ -4,7 +4,7 @@
    <div class="panel-body">
 	  {{ PRIVACY_POLICY }}
 	  <p><span class="label label label-slategray">{{ lang('BBGDPR_LAST_UPDATED', UPDATE_DATE) }}</span></p>
-	  <a href="https://goo.gl/BNEDA3" target="_blank"><img class="gdpr-badge" src="https://i.imgur.com/qg7yJwr.png" alt="GDPR compliant extension for phpBB by SiteSplat"></a>
+	  <a href="https://goo.gl/" target="_blank"><img class="gdpr-badge" src="https://i.imgur.com/qg7yJwr.png" alt="GDPR compliant"></a>
    </div>
 </div>
 <!-- IF S_USER_LOGGED_IN -->
diff --git "[FORUM_EXT]/sitesplat\\bbgdpr/styles/prosilver/template/event/ss_ucp_login_link_register_append.html" "[FORUM_EXT]/sitesplat\\bbgdpr/styles/prosilver/template/event/ss_ucp_login_link_register_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbgdpr/styles/prosilver/template/event/ss_ucp_login_link_register_append.html"
@@ -0,0 +1,29 @@
+{% if S_QUICK_AGREE %}
+	<div class="space10"></div>
+	    <div class="row">
+			<div class="col-md-6">
+				<div class="form-group">
+					<label for="sitesplat_bbgdpr_bulk_emails" class="check-control">{{ lang('BULK_EMAILS_QUICK_AGREE') ~ lang('COLON') }}</label>
+					<input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" />&nbsp;{{ lang('REG_UNDRSTD') }}
+				</div>
+			</div>
+			<div class="col-md-6">
+				<div class="form-group">
+					<label for="sitesplat_bbgdpr_privacy_policy" class="check-control">{{ lang('PRIVACY_POLICY_QUICK_AGREE') ~ lang('COLON') }}</label>
+					<input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" />&nbsp;{{ lang('REG_UNDRSTD') }}
+				</div>
+			</div>
+		</div>
+	<script>
+		document.querySelector('input[name="register"]').disabled = true;
+
+		// uh, oh, opting for this solution because iCheck won't trigger "change" event :/
+		setInterval(function() {
+			if (document.querySelectorAll('#sitesplat_bbgdpr_bulk_emails:checked, #sitesplat_bbgdpr_privacy_policy:checked').length == 2) {
+				document.querySelector('input[name="register"]').disabled = false;
+			} else {
+				document.querySelector('input[name="register"]').disabled = true;
+			}
+		}, 300);
+	</script>
+{% endif %}
diff --git "[FORUM_EXT]/sitesplat\\bbgdpr/styles/prosilver/template/event/ucp_register_buttons_before.html" "[FORUM_EXT]/sitesplat\\bbgdpr/styles/prosilver/template/event/ucp_register_buttons_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbgdpr/styles/prosilver/template/event/ucp_register_buttons_before.html"
@@ -0,0 +1,22 @@
+<div class="side-segment"><h3>{{ lang('AGREEMENTS') }}</h3></div>
+<fieldset>
+	<div class="well panel-w-form">
+		<div class="row">
+			<div class="col-md-6">
+			<div class="form-group">
+				<label for="sitesplat_bbgdpr_bulk_emails" class="check-control">{{ lang('BULK_EMAILS') ~ lang('COLON') }}</label><span class="help-block">{{ lang('BULK_EMAILS_EXPLAIN') }}</span>
+				<input id="sitesplat_bbgdpr_bulk_emails" name="sitesplat_bbgdpr_bulk_emails" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_BULK_EMAILS %} checked{% endif %} /> {{ lang('REG_UNDRSTD') }}
+				<div class="control-group"></div>
+			</div>
+			</div>
+			
+			<div class="col-md-6">
+				<div class="form-group">
+					<label for="sitesplat_bbgdpr_privacy_policy" class="check-control">{{ lang('PRIVACY_POLICY') ~ lang('COLON') }}</label><span class="help-block">{{ lang('PRIVACY_POLICY_EXPLAIN') }}</span>
+					<input id="sitesplat_bbgdpr_privacy_policy" name="sitesplat_bbgdpr_privacy_policy" type="checkbox" value="1"{% if S_SITESPLAT_BBGDPR_PRIVACY_POLICY %} checked{% endif %} /> {{ lang('REG_UNDRSTD') }}
+					<div class="control-group"></div>
+				</div>
+				</div>
+		</div>
+	</div>
+</fieldset>
\ No newline at end of file
```
