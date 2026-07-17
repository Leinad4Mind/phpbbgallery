Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/rmcgirr83\\contactadmin/diff_full.tmp" "[FORUM_EXT]/rmcgirr83\\contactadmin/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\contactadmin/diff_full.tmp"
@@ -0,0 +1,177 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/contactadmin_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/contactadmin_body.html"
+new file mode 100644
+index 000000000..4bd7eeed8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/contactadmin_body.html"
+@@ -0,0 +1,149 @@
++{% INCLUDE 'overall_header.html' %}
++
++{% if S_ERROR %}
++<div class="alert alert-info fade in">
++	<i class="fa fa-warning"></i> <strong>{{ lang('INFO_BOX') }}</strong> <br />{{ S_ERROR }}
++</div>
++{% endif %}
++
++<form method="post" id="postform" name="postform" action="{{ S_CONTACT_ACTION }}" {S_FORM_ENCTYPE}>
++	<div class="side-segment">
++		<h3>{{ lang('ACP_CAT_CONTACTADMIN') }}</h3>
++	</div>
++
++	<div class="row">
++		{% if CONTACT_INFO %}
++		<div class="col-md-12">
++			<div class="well">
++				<span class="help-block">{CONTACT_INFO}</span>
++			</div>
++		</div>
++		{% endif %}
++
++		<div class="col-md-12">
++			<div class="well">
++				<div class="row">
++					{% if not S_USER_LOGGED_IN %}
++					<div class="col-xs-12 col-lg-12">
++						<div class="control-group">
++							<label class="control-label" for="contact_name">{{ lang('CONTACT_YOUR_NAME') }}{{ lang('COLON') }}</label>
++							<div class="controls">
++								<div class="input-icon left">
++									<i class="fa fa-user"></i>
++									<input type="text" class="form-control input-sm" name="username" id="username" value="{{ USERNAME }}" size="30" tabindex="1" placeholder="{{ lang('USERNAME') }}" />
++								</div>
++							</div>
++						</div>
++					</div>
++					<div class="col-xs-12 col-lg-12">
++						<div class="control-group">
++							<label class="control-label" for="email">{{ lang('CONTACT_YOUR_EMAIL') }}{{ lang('COLON') }}</label>
++							<div class="controls">
++								<div class="input-icon left">
++									<i class="fa fa-mail-forward"></i>
++									<input type="text" class="form-control input-sm" name="email" id="email" value="{{ EMAIL }}" size="30" tabindex="2" placeholder="{{ lang('EMAIL') }}" />
++								</div>
++							</div>
++						</div>
++					</div>
++					<div class="col-xs-12 col-lg-12">
++						<div class="control-group">
++							<label class="control-label" for="email_confirm">{{ lang('CONTACT_YOUR_EMAIL_CONFIRM') }}{{ lang('COLON') }}</label>
++							<div class="controls">
++								<div class="input-icon left">
++									<i class="fa fa-mail-forward"></i>
++									<input type="text" class="form-control input-sm" name="email_confirm" id="email_confirm" value="{{ EMAIL_CONFIRM }}" size="30" tabindex="2" placeholder="{{ lang('EMAIL') }}" />
++								</div>
++							</div>
++						</div>
++					</div>
++					{% endif %}
++
++					{% if CONTACT_REASONS %}
++					<div class="col-xs-12 col-lg-12">
++						<div class="control-group">
++							<label class="control-label" for="contact_reason">{{ lang('CONTACT_REASON') }}{{ lang('COLON') }}</label>
++							<select class="selectpicker" data-container="body" data-width="100%" name="contact_reason" id="contact_reason" tabindex="4">
++								{CONTACT_REASONS}
++							</select>
++						</div>
++					</div>
++					{% endif %}
++
++					{% if not CONTACT_REASONS %}
++					<div class="<!-- IF CONTACT_REASONS -->col-xs-12 col-lg-6<!-- ELSE -->col-xs-12 col-lg-12<!-- ENDIF -->">
++						<div class="control-group">
++							<label class="control-label" for="contact_subject">{{ lang('SUBJECT') }}{{ lang('COLON') }}</label>
++							<div class="controls">
++								<div class="input-icon left">
++									<i class="fa fa-user"></i>
++									<input type="text" class="form-control input-sm" size="45" maxlength="64" name="contact_subject" id="contact_subject" value="{CONTACT_SUBJECT}" tabindex="5" placeholder="{{ lang('SUBJECT') }}" />
++								</div>
++							</div>
++						</div>
++					</div>
++					{% endif %}
++
++				</div>
++				<div class="space10"></div>
++
++				<label for="message" class="control-label">{{ lang('MESSAGE_BODY') }}{{ lang('COLON') }}</label>
++				<div class="controls">
++					<textarea class="form-control" name="message" id="message" rows="4" cols="76" tabindex="6" placeholder="{{ lang('MESSAGE_BODY') }}">{CONTACT_MESSAGE}</textarea>
++				</div>
++				<div class="space10"></div>
++
++				{% if S_CONTACT_GDPR %}
++				<div>
++					<label class="control-label" for="gdpr">{{ lang('CONTACT_PRIVACYPOLICY') }}{{ lang('COLON') }}</label>
++					<div class="controls">
++						<div class="input-icon left">
++							<input type="checkbox" class="form-control input-sm" name="gdpr" id="gdpr" size="30" tabindex="1" />&nbsp;&nbsp;{{ lang('CONTACT_PRIVACYPOLICY_EXPLAIN', PRIVACY_POLICY_URL) }}
++						</div>
++					</div>
++				</div>
++				{% endif %}
++			</div>
++		</div>
++	</div>
++
++
++
++	{% if CONTACT_ADMIN_CAPTCHA_TEMPLATE %}
++	<div class="well">
++		<div class="inner">{% DEFINE CAPTCHA_TAB_INDEX = 8 %} {% INCLUDE ''~ CONTACT_ADMIN_CAPTCHA_TEMPLATE ~'' %}</div>
++	</div>
++	{% endif %}
++
++	{% if S_ATTACH_BOX %}
++	<div class="well">
++		<p>{{ lang('ADD_ATTACHMENT_EXPLAIN') }}</p>
++
++		<fieldset>
++			<div class="control-group">
++				<label class="control-label" for="fileupload">{{ lang('FILENAME') }}{{ lang('COLON') }}</label>
++				<div class="controls controls-row">
++					<input type="file" name="fileupload" id="fileupload" class="inputbox autowidth" />
++				</div>
++			</div>
++
++			<div class="control-group">
++				<label class="control-label" for="filecomment">{{ lang('FILE_COMMENT') }}{{ lang('COLON') }}</label>
++				<div class="controls controls-row">
++					<textarea placeholder="{{ lang('FILE_COMMENT_PLACEHOLDER') }}" rows="1" name="filecomment" id="filecomment" class="form-control">{FILE_COMMENT}</textarea>
++				</div>
++			</div>
++		</fieldset>
++	</div>
++	{% endif %}
++
++	<fieldset class="form-actions">
++		{{ S_HIDDEN_FIELDS }}
++		<button type="submit" name="submit" id="submit" value="{{ lang('SUBMIT') }}" class="btn btn-default" tabindex="9" autocomplete="off" data-loading-text="{{ lang('SENDING') }}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">
++			{{ lang('SUBMIT') }}
++		</button>
++		{{ S_FORM_TOKEN }}
++	</fieldset>
++</form>
++
++{% INCLUDE 'overall_footer.html' %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html"
+new file mode 100644
+index 000000000..a13cd3749
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html"
+@@ -0,0 +1,3 @@
++{% if U_CONTACTADMIN %}
++	<li data-last-responsive="true"><a href="{{ U_CONTACTADMIN }}" role="menuitem">{{ lang('CONTACT_US') }}</a></li>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
+new file mode 100644
+index 000000000..1c2c8f150
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
+@@ -0,0 +1,3 @@
++{% if U_CONTACTADMIN %}
++	<li data-last-responsive="true"><a href="{{ U_CONTACTADMIN }}" role="menuitem"><i class="fa fa-envelope"></i>{{ lang('CONTACT_US') }}</a></li>
++{% endif %}
diff --git "[FORUM_EXT]/rmcgirr83\\contactadmin/diff_nospace.tmp" "[FORUM_EXT]/rmcgirr83\\contactadmin/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\contactadmin/diff_nospace.tmp"
@@ -0,0 +1,175 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/diff_full.tmp"
+new file mode 100644
+index 000000000..18be69b6e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/diff_full.tmp"
+@@ -0,0 +1,177 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/contactadmin_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/contactadmin_body.html"
++new file mode 100644
++index 000000000..4bd7eeed8
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/contactadmin_body.html"
++@@ -0,0 +1,149 @@
+++{% INCLUDE 'overall_header.html' %}
+++
+++{% if S_ERROR %}
+++<div class="alert alert-info fade in">
+++	<i class="fa fa-warning"></i> <strong>{{ lang('INFO_BOX') }}</strong> <br />{{ S_ERROR }}
+++</div>
+++{% endif %}
+++
+++<form method="post" id="postform" name="postform" action="{{ S_CONTACT_ACTION }}" {S_FORM_ENCTYPE}>
+++	<div class="side-segment">
+++		<h3>{{ lang('ACP_CAT_CONTACTADMIN') }}</h3>
+++	</div>
+++
+++	<div class="row">
+++		{% if CONTACT_INFO %}
+++		<div class="col-md-12">
+++			<div class="well">
+++				<span class="help-block">{CONTACT_INFO}</span>
+++			</div>
+++		</div>
+++		{% endif %}
+++
+++		<div class="col-md-12">
+++			<div class="well">
+++				<div class="row">
+++					{% if not S_USER_LOGGED_IN %}
+++					<div class="col-xs-12 col-lg-12">
+++						<div class="control-group">
+++							<label class="control-label" for="contact_name">{{ lang('CONTACT_YOUR_NAME') }}{{ lang('COLON') }}</label>
+++							<div class="controls">
+++								<div class="input-icon left">
+++									<i class="fa fa-user"></i>
+++									<input type="text" class="form-control input-sm" name="username" id="username" value="{{ USERNAME }}" size="30" tabindex="1" placeholder="{{ lang('USERNAME') }}" />
+++								</div>
+++							</div>
+++						</div>
+++					</div>
+++					<div class="col-xs-12 col-lg-12">
+++						<div class="control-group">
+++							<label class="control-label" for="email">{{ lang('CONTACT_YOUR_EMAIL') }}{{ lang('COLON') }}</label>
+++							<div class="controls">
+++								<div class="input-icon left">
+++									<i class="fa fa-mail-forward"></i>
+++									<input type="text" class="form-control input-sm" name="email" id="email" value="{{ EMAIL }}" size="30" tabindex="2" placeholder="{{ lang('EMAIL') }}" />
+++								</div>
+++							</div>
+++						</div>
+++					</div>
+++					<div class="col-xs-12 col-lg-12">
+++						<div class="control-group">
+++							<label class="control-label" for="email_confirm">{{ lang('CONTACT_YOUR_EMAIL_CONFIRM') }}{{ lang('COLON') }}</label>
+++							<div class="controls">
+++								<div class="input-icon left">
+++									<i class="fa fa-mail-forward"></i>
+++									<input type="text" class="form-control input-sm" name="email_confirm" id="email_confirm" value="{{ EMAIL_CONFIRM }}" size="30" tabindex="2" placeholder="{{ lang('EMAIL') }}" />
+++								</div>
+++							</div>
+++						</div>
+++					</div>
+++					{% endif %}
+++
+++					{% if CONTACT_REASONS %}
+++					<div class="col-xs-12 col-lg-12">
+++						<div class="control-group">
+++							<label class="control-label" for="contact_reason">{{ lang('CONTACT_REASON') }}{{ lang('COLON') }}</label>
+++							<select class="selectpicker" data-container="body" data-width="100%" name="contact_reason" id="contact_reason" tabindex="4">
+++								{CONTACT_REASONS}
+++							</select>
+++						</div>
+++					</div>
+++					{% endif %}
+++
+++					{% if not CONTACT_REASONS %}
+++					<div class="<!-- IF CONTACT_REASONS -->col-xs-12 col-lg-6<!-- ELSE -->col-xs-12 col-lg-12<!-- ENDIF -->">
+++						<div class="control-group">
+++							<label class="control-label" for="contact_subject">{{ lang('SUBJECT') }}{{ lang('COLON') }}</label>
+++							<div class="controls">
+++								<div class="input-icon left">
+++									<i class="fa fa-user"></i>
+++									<input type="text" class="form-control input-sm" size="45" maxlength="64" name="contact_subject" id="contact_subject" value="{CONTACT_SUBJECT}" tabindex="5" placeholder="{{ lang('SUBJECT') }}" />
+++								</div>
+++							</div>
+++						</div>
+++					</div>
+++					{% endif %}
+++
+++				</div>
+++				<div class="space10"></div>
+++
+++				<label for="message" class="control-label">{{ lang('MESSAGE_BODY') }}{{ lang('COLON') }}</label>
+++				<div class="controls">
+++					<textarea class="form-control" name="message" id="message" rows="4" cols="76" tabindex="6" placeholder="{{ lang('MESSAGE_BODY') }}">{CONTACT_MESSAGE}</textarea>
+++				</div>
+++				<div class="space10"></div>
+++
+++				{% if S_CONTACT_GDPR %}
+++				<div>
+++					<label class="control-label" for="gdpr">{{ lang('CONTACT_PRIVACYPOLICY') }}{{ lang('COLON') }}</label>
+++					<div class="controls">
+++						<div class="input-icon left">
+++							<input type="checkbox" class="form-control input-sm" name="gdpr" id="gdpr" size="30" tabindex="1" />&nbsp;&nbsp;{{ lang('CONTACT_PRIVACYPOLICY_EXPLAIN', PRIVACY_POLICY_URL) }}
+++						</div>
+++					</div>
+++				</div>
+++				{% endif %}
+++			</div>
+++		</div>
+++	</div>
+++
+++
+++
+++	{% if CONTACT_ADMIN_CAPTCHA_TEMPLATE %}
+++	<div class="well">
+++		<div class="inner">{% DEFINE CAPTCHA_TAB_INDEX = 8 %} {% INCLUDE ''~ CONTACT_ADMIN_CAPTCHA_TEMPLATE ~'' %}</div>
+++	</div>
+++	{% endif %}
+++
+++	{% if S_ATTACH_BOX %}
+++	<div class="well">
+++		<p>{{ lang('ADD_ATTACHMENT_EXPLAIN') }}</p>
+++
+++		<fieldset>
+++			<div class="control-group">
+++				<label class="control-label" for="fileupload">{{ lang('FILENAME') }}{{ lang('COLON') }}</label>
+++				<div class="controls controls-row">
+++					<input type="file" name="fileupload" id="fileupload" class="inputbox autowidth" />
+++				</div>
+++			</div>
+++
+++			<div class="control-group">
+++				<label class="control-label" for="filecomment">{{ lang('FILE_COMMENT') }}{{ lang('COLON') }}</label>
+++				<div class="controls controls-row">
+++					<textarea placeholder="{{ lang('FILE_COMMENT_PLACEHOLDER') }}" rows="1" name="filecomment" id="filecomment" class="form-control">{FILE_COMMENT}</textarea>
+++				</div>
+++			</div>
+++		</fieldset>
+++	</div>
+++	{% endif %}
+++
+++	<fieldset class="form-actions">
+++		{{ S_HIDDEN_FIELDS }}
+++		<button type="submit" name="submit" id="submit" value="{{ lang('SUBMIT') }}" class="btn btn-default" tabindex="9" autocomplete="off" data-loading-text="{{ lang('SENDING') }}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">
+++			{{ lang('SUBMIT') }}
+++		</button>
+++		{{ S_FORM_TOKEN }}
+++	</fieldset>
+++</form>
+++
+++{% INCLUDE 'overall_footer.html' %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html"
++new file mode 100644
++index 000000000..a13cd3749
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html"
++@@ -0,0 +1,3 @@
+++{% if U_CONTACTADMIN %}
+++	<li data-last-responsive="true"><a href="{{ U_CONTACTADMIN }}" role="menuitem">{{ lang('CONTACT_US') }}</a></li>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-p
\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\contactadmin/styles/FLATBOOTS/template/contactadmin_body.html" "[FORUM_EXT]/rmcgirr83\\contactadmin/styles/FLATBOOTS/template/contactadmin_body.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\contactadmin/styles/FLATBOOTS/template/contactadmin_body.html"
@@ -0,0 +1,149 @@
+{% INCLUDE 'overall_header.html' %}
+
+{% if S_ERROR %}
+<div class="alert alert-info fade in">
+	<i class="fa fa-warning"></i> <strong>{{ lang('INFO_BOX') }}</strong> <br />{{ S_ERROR }}
+</div>
+{% endif %}
+
+<form method="post" id="postform" name="postform" action="{{ S_CONTACT_ACTION }}" {S_FORM_ENCTYPE}>
+	<div class="side-segment">
+		<h3>{{ lang('ACP_CAT_CONTACTADMIN') }}</h3>
+	</div>
+
+	<div class="row">
+		{% if CONTACT_INFO %}
+		<div class="col-md-12">
+			<div class="well">
+				<span class="help-block">{CONTACT_INFO}</span>
+			</div>
+		</div>
+		{% endif %}
+
+		<div class="col-md-12">
+			<div class="well">
+				<div class="row">
+					{% if not S_USER_LOGGED_IN %}
+					<div class="col-xs-12 col-lg-12">
+						<div class="control-group">
+							<label class="control-label" for="contact_name">{{ lang('CONTACT_YOUR_NAME') }}{{ lang('COLON') }}</label>
+							<div class="controls">
+								<div class="input-icon left">
+									<i class="fa fa-user"></i>
+									<input type="text" class="form-control input-sm" name="username" id="username" value="{{ USERNAME }}" size="30" tabindex="1" placeholder="{{ lang('USERNAME') }}" />
+								</div>
+							</div>
+						</div>
+					</div>
+					<div class="col-xs-12 col-lg-12">
+						<div class="control-group">
+							<label class="control-label" for="email">{{ lang('CONTACT_YOUR_EMAIL') }}{{ lang('COLON') }}</label>
+							<div class="controls">
+								<div class="input-icon left">
+									<i class="fa fa-mail-forward"></i>
+									<input type="text" class="form-control input-sm" name="email" id="email" value="{{ EMAIL }}" size="30" tabindex="2" placeholder="{{ lang('EMAIL') }}" />
+								</div>
+							</div>
+						</div>
+					</div>
+					<div class="col-xs-12 col-lg-12">
+						<div class="control-group">
+							<label class="control-label" for="email_confirm">{{ lang('CONTACT_YOUR_EMAIL_CONFIRM') }}{{ lang('COLON') }}</label>
+							<div class="controls">
+								<div class="input-icon left">
+									<i class="fa fa-mail-forward"></i>
+									<input type="text" class="form-control input-sm" name="email_confirm" id="email_confirm" value="{{ EMAIL_CONFIRM }}" size="30" tabindex="2" placeholder="{{ lang('EMAIL') }}" />
+								</div>
+							</div>
+						</div>
+					</div>
+					{% endif %}
+
+					{% if CONTACT_REASONS %}
+					<div class="col-xs-12 col-lg-12">
+						<div class="control-group">
+							<label class="control-label" for="contact_reason">{{ lang('CONTACT_REASON') }}{{ lang('COLON') }}</label>
+							<select class="selectpicker" data-container="body" data-width="100%" name="contact_reason" id="contact_reason" tabindex="4">
+								{CONTACT_REASONS}
+							</select>
+						</div>
+					</div>
+					{% endif %}
+
+					{% if not CONTACT_REASONS %}
+					<div class="<!-- IF CONTACT_REASONS -->col-xs-12 col-lg-6<!-- ELSE -->col-xs-12 col-lg-12<!-- ENDIF -->">
+						<div class="control-group">
+							<label class="control-label" for="contact_subject">{{ lang('SUBJECT') }}{{ lang('COLON') }}</label>
+							<div class="controls">
+								<div class="input-icon left">
+									<i class="fa fa-user"></i>
+									<input type="text" class="form-control input-sm" size="45" maxlength="64" name="contact_subject" id="contact_subject" value="{CONTACT_SUBJECT}" tabindex="5" placeholder="{{ lang('SUBJECT') }}" />
+								</div>
+							</div>
+						</div>
+					</div>
+					{% endif %}
+
+				</div>
+				<div class="space10"></div>
+
+				<label for="message" class="control-label">{{ lang('MESSAGE_BODY') }}{{ lang('COLON') }}</label>
+				<div class="controls">
+					<textarea class="form-control" name="message" id="message" rows="4" cols="76" tabindex="6" placeholder="{{ lang('MESSAGE_BODY') }}">{CONTACT_MESSAGE}</textarea>
+				</div>
+				<div class="space10"></div>
+
+				{% if S_CONTACT_GDPR %}
+				<div>
+					<label class="control-label" for="gdpr">{{ lang('CONTACT_PRIVACYPOLICY') }}{{ lang('COLON') }}</label>
+					<div class="controls">
+						<div class="input-icon left">
+							<input type="checkbox" class="form-control input-sm" name="gdpr" id="gdpr" size="30" tabindex="1" />&nbsp;&nbsp;{{ lang('CONTACT_PRIVACYPOLICY_EXPLAIN', PRIVACY_POLICY_URL) }}
+						</div>
+					</div>
+				</div>
+				{% endif %}
+			</div>
+		</div>
+	</div>
+
+
+
+	{% if CONTACT_ADMIN_CAPTCHA_TEMPLATE %}
+	<div class="well">
+		<div class="inner">{% DEFINE CAPTCHA_TAB_INDEX = 8 %} {% INCLUDE ''~ CONTACT_ADMIN_CAPTCHA_TEMPLATE ~'' %}</div>
+	</div>
+	{% endif %}
+
+	{% if S_ATTACH_BOX %}
+	<div class="well">
+		<p>{{ lang('ADD_ATTACHMENT_EXPLAIN') }}</p>
+
+		<fieldset>
+			<div class="control-group">
+				<label class="control-label" for="fileupload">{{ lang('FILENAME') }}{{ lang('COLON') }}</label>
+				<div class="controls controls-row">
+					<input type="file" name="fileupload" id="fileupload" class="inputbox autowidth" />
+				</div>
+			</div>
+
+			<div class="control-group">
+				<label class="control-label" for="filecomment">{{ lang('FILE_COMMENT') }}{{ lang('COLON') }}</label>
+				<div class="controls controls-row">
+					<textarea placeholder="{{ lang('FILE_COMMENT_PLACEHOLDER') }}" rows="1" name="filecomment" id="filecomment" class="form-control">{FILE_COMMENT}</textarea>
+				</div>
+			</div>
+		</fieldset>
+	</div>
+	{% endif %}
+
+	<fieldset class="form-actions">
+		{{ S_HIDDEN_FIELDS }}
+		<button type="submit" name="submit" id="submit" value="{{ lang('SUBMIT') }}" class="btn btn-default" tabindex="9" autocomplete="off" data-loading-text="{{ lang('SENDING') }}<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>">
+			{{ lang('SUBMIT') }}
+		</button>
+		{{ S_FORM_TOKEN }}
+	</fieldset>
+</form>
+
+{% INCLUDE 'overall_footer.html' %}
\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html" "[FORUM_EXT]/rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html"
@@ -0,0 +1,3 @@
+{% if U_CONTACTADMIN %}
+	<li data-last-responsive="true"><a href="{{ U_CONTACTADMIN }}" role="menuitem">{{ lang('CONTACT_US') }}</a></li>
+{% endif %}
diff --git "[FORUM_EXT]/rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "[FORUM_EXT]/rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\contactadmin/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
@@ -0,0 +1,3 @@
+{% if U_CONTACTADMIN %}
+	<li data-last-responsive="true"><a href="{{ U_CONTACTADMIN }}" role="menuitem"><i class="fa fa-envelope"></i>{{ lang('CONTACT_US') }}</a></li>
+{% endif %}
```
