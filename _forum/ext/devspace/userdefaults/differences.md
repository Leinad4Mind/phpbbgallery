Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/devspace\\userdefaults/adm/style/base.html" "[FORUM_EXT]/devspace\\userdefaults/adm/style/base.html"
--- "[ORIGINAL]/devspace\\userdefaults/adm/style/base.html"
+++ "[FORUM_EXT]/devspace\\userdefaults/adm/style/base.html"
@@ -60,28 +60,4 @@
 
 {% block content %}{% endblock %}
 
-<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
-	<fieldset>
-		<legend class="collapsible">{{ lang('CLICK_DONATE') }}</legend>
-
-		<div class="donate-content">
-			<dl>
-				<dt><label for="donate">{{ lang('DONATE_EXTENSIONS') }}{{ lang('COLON') }}</label><br><span>{{ lang('DONATE_EXTENSIONS_EXPLAIN') }}</span></dt>
-				<dd>
-					<div class="aligner">
-						<div class="aligner-item">
-							<input type="hidden" name="cmd" value="_s-xclick">
-							<input type="hidden" name="hosted_button_id" value="8QF58X7DVHKJ4">
-							<button class="paypal_btn" type="submit" name="submit" title="{{ lang('PAYPAL_TITLE') }}" alt="{{ lang('PAYPAL_BUTTON') }}">{{ lang('DONATE') }}</button>
-						</div>
-					</div>
-					<img class="qrimage" src="{{ EXT_IMAGE_PATH }}/qrcode.png">
-				</dd>
-			</dl>
-		</div>
-
-	</fieldset>
-</form>
-
-{% INCLUDEJS '@' ~ NAMESPACE ~ '/js/donate-collapse.js' %}
 {% include 'overall_footer.html' %}
diff --git "[FORUM_EXT]/devspace\\userdefaults/diff_full.tmp" "[FORUM_EXT]/devspace\\userdefaults/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/devspace\\userdefaults/diff_full.tmp"
@@ -0,0 +1,36 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\devspace\\userdefaults/adm/style/base.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\devspace\\userdefaults/adm/style/base.html"
+index b7a0947a6..22d1e597a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\devspace\\userdefaults/adm/style/base.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\devspace\\userdefaults/adm/style/base.html"
+@@ -60,28 +60,4 @@
+ 
+ {% block content %}{% endblock %}
+ 
+-<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
+-	<fieldset>
+-		<legend class="collapsible">{{ lang('CLICK_DONATE') }}</legend>
+-
+-		<div class="donate-content">
+-			<dl>
+-				<dt><label for="donate">{{ lang('DONATE_EXTENSIONS') }}{{ lang('COLON') }}</label><br><span>{{ lang('DONATE_EXTENSIONS_EXPLAIN') }}</span></dt>
+-				<dd>
+-					<div class="aligner">
+-						<div class="aligner-item">
+-							<input type="hidden" name="cmd" value="_s-xclick">
+-							<input type="hidden" name="hosted_button_id" value="8QF58X7DVHKJ4">
+-							<button class="paypal_btn" type="submit" name="submit" title="{{ lang('PAYPAL_TITLE') }}" alt="{{ lang('PAYPAL_BUTTON') }}">{{ lang('DONATE') }}</button>
+-						</div>
+-					</div>
+-					<img class="qrimage" src="{{ EXT_IMAGE_PATH }}/qrcode.png">
+-				</dd>
+-			</dl>
+-		</div>
+-
+-	</fieldset>
+-</form>
+-
+-{% INCLUDEJS '@' ~ NAMESPACE ~ '/js/donate-collapse.js' %}
+ {% include 'overall_footer.html' %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\devspace\\userdefaults/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\devspace\\userdefaults/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
diff --git "[FORUM_EXT]/devspace\\userdefaults/diff_nospace.tmp" "[FORUM_EXT]/devspace\\userdefaults/diff_nospace.tmp"
new file mode 100644
```
