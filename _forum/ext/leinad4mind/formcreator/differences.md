Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/leinad4mind\\formcreator/adm/style/acp_form_creator.html" "[FORUM_EXT]/leinad4mind\\formcreator/adm/style/acp_form_creator.html"
--- "[ORIGINAL]/leinad4mind\\formcreator/adm/style/acp_form_creator.html"
+++ "[FORUM_EXT]/leinad4mind\\formcreator/adm/style/acp_form_creator.html"
@@ -91,32 +91,36 @@
 					</select>
 				</td>
 				<td class="td_20" title="{{ lang('MANDATORY') }}">
-					<input style="cursor:pointer{% if definition.template_type_selected == 'checkbox' %};display:none{% endif %}" type="checkbox" name="q_mandatory[{{ form_template.ID }}]" value="1"{{ form_template.MANDATORY ? ' checked'}}>
+					<input style="cursor:pointer{% if definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' %};display:none{% endif %}" type="checkbox" name="q_mandatory[{{ form_template.ID }}]" value="1"{{ form_template.MANDATORY ? ' checked'}}>
 				</td>
 				<td class="td_20" title="{{ lang('FORM_ELEMENT_NAME_VISIBLE') }}">
-					<input style="cursor:pointer" type="checkbox" name="q_name_visible[{{ form_template.ID }}]" value="1"{{ form_template.NAME_VISIBLE ? ' checked'}}>
+					<input style="cursor:pointer{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" type="checkbox" name="q_name_visible[{{ form_template.ID }}]" value="1"{{ form_template.NAME_VISIBLE ? ' checked'}}>
 				</td>
 				<td class="td_02">
-					<textarea style="width:97%" name="q_name_before[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_BEFORE }}</textarea><br>
-					<textarea style="width:97%" name="q_name_after[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_AFTER }}</textarea>
+					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_name_before[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_BEFORE }}</textarea><br>
+					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_name_after[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_AFTER }}</textarea>
 				</td>
 				<td class="td_02">
-					<input style="width:97%" type="text" name="q_name[{{ form_template.ID }}]" value="{{ form_template.NAME }}" placeholder="{{ lang('FORM_ELEMENT_NAME') }}">
-					<textarea style="width:97%" name="q_explain[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_EXPLAIN') }}">{{ form_template.EXPLAIN }}</textarea>
+					<input style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" type="text" name="q_name[{{ form_template.ID }}]" value="{{ form_template.NAME }}" placeholder="{{ lang('FORM_ELEMENT_NAME') }}">
+					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_explain[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_EXPLAIN') }}">{{ form_template.EXPLAIN }}</textarea>
+					{% if definition.template_type_selected == 'textbox' %}
+						<textarea style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" name="q_hint[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">{{ form_template.HINT }}</textarea>
+					{% else %}
 						<input style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" type="text" name="q_hint[{{ form_template.ID }}]" value="{{ form_template.HINT }}" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">
+					{% endif %}
 				</td>
 				<td class="td_02">
 					<textarea style="width:97%{% if !(definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'selectbox') %};display:none{% endif %}" name="q_options[{{ form_template.ID }}]" rows="3">{{ form_template.OPTIONS }}</textarea>
-					<input style="width:97%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="text" name="q_options_separator[{{ form_template.ID }}]" value="{{ form_template.OPTIONS_SEPARATOR }}" placeholder="{{ lang('FORM_ELEMENT_OPTIONS_SEPARATOR') }}">
+					<input style="width:97%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="text" name="q_options_separator[{{ form_template.ID }}]" value="{{ form_template.OPTIONS_SEPARATOR }}" placeholder="{{ lang('FORM_ELEMENT_OPTIONS_SEPARATOR') }}">
 				</td>
 				<td class="td_02">
-					<input style="width:90%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="number" min="0" name="q_mins[{{ form_template.ID }}]" value="{{ form_template.MIN }}" placeholder="{{ lang('FORM_ELEMENT_MIN') }}">
-					<input style="width:90%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="number" min="0" name="q_maxs[{{ form_template.ID }}]" value="{{ form_template.MAX}}" placeholder="{{ lang('FORM_ELEMENT_MAX') }}">
+					<input style="width:90%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="number" min="0" name="q_mins[{{ form_template.ID }}]" value="{{ form_template.MIN }}" placeholder="{{ lang('FORM_ELEMENT_MIN') }}">
+					<input style="width:90%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="number" min="0" name="q_maxs[{{ form_template.ID }}]" value="{{ form_template.MAX}}" placeholder="{{ lang('FORM_ELEMENT_MAX') }}">
 				</td>
 				
 				<td class="td_02">
-					<textarea style="width:97%" name="q_value_before[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_BEFORE }}</textarea><br>
-					<textarea style="width:97%" name="q_value_after[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_AFTER }}</textarea>
+						<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_value_before[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_BEFORE }}</textarea><br>
+						<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_value_after[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_AFTER }}</textarea>
 				</td>
 			</tr>
 			{% endfor %}
diff --git "[ORIGINAL]/leinad4mind\\formcreator/composer.json" "[FORUM_EXT]/leinad4mind\\formcreator/composer.json"
--- "[ORIGINAL]/leinad4mind\\formcreator/composer.json"
+++ "[FORUM_EXT]/leinad4mind\\formcreator/composer.json"
@@ -3,8 +3,8 @@
 	"type": "phpbb-extension",
 	"description": "Create forms to collect data from you members in any forum (one form per forum)",
 	"homepage": "https://www.leinad4mind.top/forum",
-	"version": "2.2.4",
-	"time": "2019-07-05",
+	"version": "2.2.5",
+	"time": "2019-08-07",
 	"keywords": ["phpbb", "extension", "formcreator"],
 	"license": "GPL-2.0",
 	"authors": [
diff --git "[ORIGINAL]/leinad4mind\\formcreator/controller/admin_controller.php" "[FORUM_EXT]/leinad4mind\\formcreator/controller/admin_controller.php"
--- "[ORIGINAL]/leinad4mind\\formcreator/controller/admin_controller.php"
+++ "[FORUM_EXT]/leinad4mind\\formcreator/controller/admin_controller.php"
@@ -460,7 +460,7 @@ class admin_controller
 				case 'selectbox':
 					$type = '<select style="border-radius: 5px;" class="inputbox" name="templatefield_' . $row['id'] . '" tabindex="' . $row['ndx_order'] . '">';
 					$type .= '<option value="">----------------</option>';
-					$select_option = ext::explode([',', "\n"], $row['options']);
+					$select_option = ext::explode($row['options']);
 					foreach ($select_option as $value)
 					{
 						$type .='<option value="'. $value .'">' . $value . '</option>';
@@ -468,7 +468,7 @@ class admin_controller
 					$type .= '</select>';
 				break;
 				case 'radiobuttons':
-					$radio_option = ext::explode([',', "\n"], $row['options']);
+					$radio_option = ext::explode($row['options']);
 
 					$type = '';
 					foreach ($radio_option as $value)
@@ -477,7 +477,7 @@ class admin_controller
 					}
 				break;
 				case 'checkbox':
-					$check_option = ext::explode([',', "\n"], $row['options']);
+					$check_option = ext::explode($row['options']);
 
 					$type = '';
 					foreach ($check_option as $value)
diff --git "[FORUM_EXT]/leinad4mind\\formcreator/diff_full.tmp" "[FORUM_EXT]/leinad4mind\\formcreator/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\formcreator/diff_full.tmp"
@@ -0,0 +1,1409 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
+index 4aa330281..4d81e91be 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
+@@ -91,32 +91,36 @@
+ 					</select>
+ 				</td>
+ 				<td class="td_20" title="{{ lang('MANDATORY') }}">
+-					<input style="cursor:pointer{% if definition.template_type_selected == 'checkbox' %};display:none{% endif %}" type="checkbox" name="q_mandatory[{{ form_template.ID }}]" value="1"{{ form_template.MANDATORY ? ' checked'}}>
++					<input style="cursor:pointer{% if definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' %};display:none{% endif %}" type="checkbox" name="q_mandatory[{{ form_template.ID }}]" value="1"{{ form_template.MANDATORY ? ' checked'}}>
+ 				</td>
+ 				<td class="td_20" title="{{ lang('FORM_ELEMENT_NAME_VISIBLE') }}">
+-					<input style="cursor:pointer" type="checkbox" name="q_name_visible[{{ form_template.ID }}]" value="1"{{ form_template.NAME_VISIBLE ? ' checked'}}>
++					<input style="cursor:pointer{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" type="checkbox" name="q_name_visible[{{ form_template.ID }}]" value="1"{{ form_template.NAME_VISIBLE ? ' checked'}}>
+ 				</td>
+ 				<td class="td_02">
+-					<textarea style="width:97%" name="q_name_before[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_BEFORE }}</textarea><br>
+-					<textarea style="width:97%" name="q_name_after[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_AFTER }}</textarea>
++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_name_before[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_BEFORE }}</textarea><br>
++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_name_after[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_AFTER }}</textarea>
+ 				</td>
+ 				<td class="td_02">
+-					<input style="width:97%" type="text" name="q_name[{{ form_template.ID }}]" value="{{ form_template.NAME }}" placeholder="{{ lang('FORM_ELEMENT_NAME') }}">
+-					<textarea style="width:97%" name="q_explain[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_EXPLAIN') }}">{{ form_template.EXPLAIN }}</textarea>
+-					<input style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" type="text" name="q_hint[{{ form_template.ID }}]" value="{{ form_template.HINT }}" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">
++					<input style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" type="text" name="q_name[{{ form_template.ID }}]" value="{{ form_template.NAME }}" placeholder="{{ lang('FORM_ELEMENT_NAME') }}">
++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_explain[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_EXPLAIN') }}">{{ form_template.EXPLAIN }}</textarea>
++					{% if definition.template_type_selected == 'textbox' %}
++						<textarea style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" name="q_hint[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">{{ form_template.HINT }}</textarea>
++					{% else %}
++						<input style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" type="text" name="q_hint[{{ form_template.ID }}]" value="{{ form_template.HINT }}" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">
++					{% endif %}
+ 				</td>
+ 				<td class="td_02">
+ 					<textarea style="width:97%{% if !(definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'selectbox') %};display:none{% endif %}" name="q_options[{{ form_template.ID }}]" rows="3">{{ form_template.OPTIONS }}</textarea>
+-					<input style="width:97%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="text" name="q_options_separator[{{ form_template.ID }}]" value="{{ form_template.OPTIONS_SEPARATOR }}" placeholder="{{ lang('FORM_ELEMENT_OPTIONS_SEPARATOR') }}">
++					<input style="width:97%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="text" name="q_options_separator[{{ form_template.ID }}]" value="{{ form_template.OPTIONS_SEPARATOR }}" placeholder="{{ lang('FORM_ELEMENT_OPTIONS_SEPARATOR') }}">
+ 				</td>
+ 				<td class="td_02">
+-					<input style="width:90%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="number" min="0" name="q_mins[{{ form_template.ID }}]" value="{{ form_template.MIN }}" placeholder="{{ lang('FORM_ELEMENT_MIN') }}">
+-					<input style="width:90%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="number" min="0" name="q_maxs[{{ form_template.ID }}]" value="{{ form_template.MAX}}" placeholder="{{ lang('FORM_ELEMENT_MAX') }}">
++					<input style="width:90%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="number" min="0" name="q_mins[{{ form_template.ID }}]" value="{{ form_template.MIN }}" placeholder="{{ lang('FORM_ELEMENT_MIN') }}">
++					<input style="width:90%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="number" min="0" name="q_maxs[{{ form_template.ID }}]" value="{{ form_template.MAX}}" placeholder="{{ lang('FORM_ELEMENT_MAX') }}">
+ 				</td>
+ 				
+ 				<td class="td_02">
+-					<textarea style="width:97%" name="q_value_before[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_BEFORE }}</textarea><br>
+-					<textarea style="width:97%" name="q_value_after[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_AFTER }}</textarea>
++						<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_value_before[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_BEFORE }}</textarea><br>
++						<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_value_after[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_AFTER }}</textarea>
+ 				</td>
+ 			</tr>
+ 			{% endfor %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/composer.json"
+index 10c273904..c5b1cf34c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/composer.json"
+@@ -3,8 +3,8 @@
+ 	"type": "phpbb-extension",
+ 	"description": "Create forms to collect data from you members in any forum (one form per forum)",
+ 	"homepage": "https://www.leinad4mind.top/forum",
+-	"version": "2.2.4",
+-	"time": "2019-07-05",
++	"version": "2.2.5",
++	"time": "2019-08-07",
+ 	"keywords": ["phpbb", "extension", "formcreator"],
+ 	"license": "GPL-2.0",
+ 	"authors": [
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/controller/admin_controller.php"
+index 603741919..780efa27b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/controller/admin_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/controller/admin_controller.php"
+@@ -460,7 +460,7 @@ class admin_controller
+ 				case 'selectbox':
+ 					$type = '<select style="border-radius: 5px;" class="inputbox" name="templatefield_' . $row['id'] . '" tabindex="' . $row['ndx_order'] . '">';
+ 					$type .= '<option value="">----------------</option>';
+-					$select_option = ext::explode([',', "\n"], $row['options']);
++					$select_option = ext::explode($row['options']);
+ 					foreach ($select_option as $value)
+ 					{
+ 						$type .='<option value="'. $value .'">' . $value . '</option>';
+@@ -468,7 +468,7 @@ class admin_controller
+ 					$type .= '</select>';
+ 				break;
+ 				case 'radiobuttons':
+-					$radio_option = ext::explode([',', "\n"], $row['options']);
++					$radio_option = ext::explode($row['options']);
+ 
+ 					$type = '';
+ 					foreach ($radio_option as $value)
+@@ -477,7 +477,7 @@ class admin_controller
+ 					}
+ 				break;
+ 				case 'checkbox':
+-					$check_option = ext::explode([',', "\n"], $row['options']);
++					$check_option = ext::explode($row['options']);
+ 
+ 					$type = '';
+ 					foreach ($check_option as $value)
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/diff_full.tmp"
+new file mode 100644
+index 000000000..2b77412f9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/diff_full.tmp"
+@@ -0,0 +1,56 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
++index 4aa330281..4d81e91be 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
++@@ -91,32 +91,36 @@
++ 					</select>
++ 				</td>
++ 				<td class="td_20" title="{{ lang('MANDATORY') }}">
++-					<input style="cursor:pointer{% if definition.template_type_selected == 'checkbox' %};display:none{% endif %}" type="checkbox" name="q_mandatory[{{ form_template.ID }}]" value="1"{{ form_template.MANDATORY ? ' checked'}}>
+++					<input style="cursor:pointer{% if definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' %};display:none{% endif %}" type="checkbox" name="q_mandatory[{{ form_template.ID }}]" value="1"{{ form_template.MANDATORY ? ' checked'}}>
++ 				</td>
++ 				<td class="td_20" title="{{ lang('FORM_ELEMENT_NAME_VISIBLE') }}">
++-					<input style="cursor:pointer" type="checkbox" name="q_name_visible[{{ form_template.ID }}]" value="1"{{ form_template.NAME_VISIBLE ? ' checked'}}>
+++					<input style="cursor:pointer{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" type="checkbox" name="q_name_visible[{{ form_template.ID }}]" value="1"{{ form_template.NAME_VISIBLE ? ' checked'}}>
++ 				</td>
++ 				<td class="td_02">
++-					<textarea style="width:97%" name="q_name_before[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_BEFORE }}</textarea><br>
++-					<textarea style="width:97%" name="q_name_after[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_AFTER }}</textarea>
+++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_name_before[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_BEFORE }}</textarea><br>
+++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_name_after[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_AFTER }}</textarea>
++ 				</td>
++ 				<td class="td_02">
++-					<input style="width:97%" type="text" name="q_name[{{ form_template.ID }}]" value="{{ form_template.NAME }}" placeholder="{{ lang('FORM_ELEMENT_NAME') }}">
++-					<textarea style="width:97%" name="q_explain[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_EXPLAIN') }}">{{ form_template.EXPLAIN }}</textarea>
++-					<input style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" type="text" name="q_hint[{{ form_template.ID }}]" value="{{ form_template.HINT }}" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">
+++					<input style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" type="text" name="q_name[{{ form_template.ID }}]" value="{{ form_template.NAME }}" placeholder="{{ lang('FORM_ELEMENT_NAME') }}">
+++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_explain[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_EXPLAIN') }}">{{ form_template.EXPLAIN }}</textarea>
+++					{% if definition.template_type_selected == 'textbox' %}
+++						<textarea style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" name="q_hint[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">{{ form_template.HINT }}</textarea>
+++					{% else %}
+++						<input style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" type="text" name="q_hint[{{ form_template.ID }}]" value="{{ form_template.HINT }}" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">
+++					{% endif %}
++ 				</td>
++ 				<td class="td_02">
++ 					<textarea style="width:97%{% if !(definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'selectbox') %};display:none{% endif %}" name="q_options[{{ form_template.ID }}]" rows="3">{{ form_template.OPTIONS }}</textarea>
++-					<input style="width:97%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="text" name="q_options_separator[{{ form_template.ID }}]" value="{{ form_template.OPTIONS_SEPARATOR }}" placeholder="{{ lang('FORM_ELEMENT_OPTIONS_SEPARATOR') }}">
+++					<input style="width:97%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="text" name="q_options_separator[{{ form_template.ID }}]" value="{{ form_template.OPTIONS_SEPARATOR }}" placeholder="{{ lang('FORM_ELEMENT_OPTIONS_SEPARATOR') }}">
++ 				</td>
++ 				<td class="td_02">
++-					<input style="width:90%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="number" min="0" name="q_mins[{{ form_template.ID }}]" value="{{ form_template.MIN }}" placeholder="{{ lang('FORM_ELEMENT_MIN') }}">
++-					<input style="width:90%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="number" min="0" name="q_maxs[{{ form_template.ID }}]" value="{{ form_template.MAX}}" placeholder="{{ lang('FORM_ELEMENT_MAX') }}">
+++					<input style="width:90%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="number" min="0" name="q_mins[{{ form_template.ID }}]" value="{{ form_template.MIN }}" placeholder="{{ lang('FORM_ELEMENT_MIN') }}">
+++					<input style="width:90%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="number" min="0" name="q_maxs[{{ form_template.ID }}]" value="{{ form_template.MAX}}" placeholder="{{ lang('FORM_ELEMENT_MAX') }}">
++ 				</td>
++ 				
++ 				<td class="td_02">
++-					<textarea style="width:97%" name="q_value_before[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_BEFORE }}</textarea><br>
++-					<textarea style="width:97%" name="q_value_after[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_AFTER }}</textarea>
+++						<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_value_before[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_BEFORE }}</textarea><br>
+++						<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_value_after[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_AFTER }}</textarea>
++ 				</td>
++ 			</tr>
++ 			{% endfor %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/composer.json"
++index 10c273904..c5b1cf34c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcre
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/event/listener.php"
+index f82c9d2a0..3f906088b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/event/listener.php"
+@@ -1,12 +1,13 @@
+ <?php
++
+ /**
+-*
+-* @package phpBB Extension - Form Creator
+-* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+-* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
++ *
++ * @package phpBB Extension - Form Creator
++ * @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
++ * @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
+ 
+ namespace leinad4mind\formcreator\event;
+ 
+@@ -55,22 +56,22 @@ class listener implements EventSubscriberInterface
+ 	protected $files_factory;
+ 
+ 	/**
+-	* Constructor
+-	*
+-	* @param \phpbb\user						$user
+-	* @param \phpbb\template\template			$template
+-	* @param \phpbb\db\driver\driver_interface	$db
+-	* @param \phpbb\config\config				$config
+-	* @param \phpbb\auth\auth					$auth
+-	* @param \phpbb\controller\helper			$helper
+-	* @param \phpbb\cache\service		 		$cache
+-	* @param \phpbb\request\request		 		$request
+-	* @param string								$root_path
+-	* @param string								$php_ext
+-	* @param string								$table_formcreator
+-	* @param \phpbb\files\factory				$files_factory
+-	*
+-	*/
++	 * Constructor
++	 *
++	 * @param \phpbb\user						$user
++	 * @param \phpbb\template\template			$template
++	 * @param \phpbb\db\driver\driver_interface	$db
++	 * @param \phpbb\config\config				$config
++	 * @param \phpbb\auth\auth					$auth
++	 * @param \phpbb\controller\helper			$helper
++	 * @param \phpbb\cache\service		 		$cache
++	 * @param \phpbb\request\request		 		$request
++	 * @param string								$root_path
++	 * @param string								$php_ext
++	 * @param string								$table_formcreator
++	 * @param \phpbb\files\factory				$files_factory
++	 *
++	 */
+ 	public function __construct(
+ 		\phpbb\user $user,
+ 		\phpbb\template\template $template,
+@@ -84,8 +85,7 @@ class listener implements EventSubscriberInterface
+ 		$php_ext,
+ 		$table_formcreator,
+ 		\phpbb\files\factory $files_factory
+-	)
+-	{
++	) {
+ 		$this->user					= $user;
+ 		$this->template				= $template;
+ 		$this->db					= $db;
+@@ -135,12 +135,10 @@ class listener implements EventSubscriberInterface
+ 
+ 	public function modify_message_text($event)
+ 	{
+-		if ($this->can_use_form($event))
+-		{
++		if ($this->can_use_form($event)) {
+ 			$message = $this->request->variable('message', '', true);
+ 
+-			if ($message === '' || $this->request->is_set_post('form_creator_preview'))
+-			{
++			if ($message === '' || $this->request->is_set_post('form_creator_preview')) {
+ 				$mode 			= $event['mode'];
+ 				$forum_id 		= $event['forum_id'];
+ 				$submit 		= $event['submit'];
+@@ -149,19 +147,15 @@ class listener implements EventSubscriberInterface
+ 				$message_parser = $event['message_parser'];
+ 				$files 			= $this->request->get_super_global(\phpbb\request\request::FILES);
+ 
+-				try
+-				{
++				try {
+ 					$message = $this->grab_form_data($forum_id);
+ 
+-					foreach ($files as $key => $name)
+-					{
++					foreach ($files as $key => $name) {
+ 						$message_parser->parse_attachments($key, $mode, $forum_id, $submit, $preview, $refresh);
+ 					}
+ 
+ 					$message_parser->message = $message;
+-				}
+-				catch (exception $e)
+-				{
++				} catch (exception $e) {
+ 					$event['error'] = array_merge($event['error'], $e->get_parameters());
+ 				}
+ 			}
+@@ -170,8 +164,7 @@ class listener implements EventSubscriberInterface
+ 
+ 	public function posting_modify_template_vars($event)
+ 	{
+-		if ($this->can_use_form($event))
+-		{
++		if ($this->can_use_form($event)) {
+ 			$this->build_form($event['forum_id'], $event['mode']);
+ 		}
+ 	}
+@@ -185,8 +178,7 @@ class listener implements EventSubscriberInterface
+ 			ORDER BY ndx_order ASC';
+ 		$result = $this->db->sql_query($sql);
+ 
+-		while ($row = $this->db->sql_fetchrow($result))
+-		{
++		while ($row = $this->db->sql_fetchrow($result)) {
+ 			$entry 			= '';
+ 			$clean_name 	= 'templatefield_' . $row['id'];
+ 
+@@ -203,8 +195,7 @@ class listener implements EventSubscriberInterface
+ 			$cols			= ' rows="3"';
+ 			$rows			= ' cols="76"';
+ 
+-			switch (strtolower($row['type']))
+-			{
++			switch (strtolower($row['type'])) {
+ 				case 'email':
+ 				case 'password':
+ 				case 'url':
+@@ -214,70 +205,70 @@ class listener implements EventSubscriberInterface
+ 				case 'time':
+ 					$value = $this->request->variable($clean_name, '', true);
+ 					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><input' . $type . $name . $id . $placeholder . $mandatory . $size . $maxlength . $tabindex . $class . ' value="' . $value . '"></div></div>';
+-				break;
++					break;
+ 
+ 				case 'number':
+ 					$value = $this->request->variable($clean_name, 0);
+ 					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><input' . $type . $name . $id . $placeholder . $mandatory . $size . $tabindex . $class . ' value="' . $value . '"></div></div>';
+-				break;
++					break;
+ 
+ 				case 'textbox':
+ 					$value = $this->request->variable($clean_name, '', true);
+ 					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><textarea' . $type . $name . $id . $rows . $cols . $tabindex . $placeholder . $mandatory . $class . '" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">' . $value . '</textarea></div></div>';
+-				break;
++					break;
+ 
+ 				case 'selectbox':
+-					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><select'. $type . $name . $id . $tabindex . $mandatory . $class . '>';
+-					if(empty($row['hint'])) {
++					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><select' . $type . $name . $id . $tabindex . $mandatory . $class . '>';
++					if (empty($row['hint'])) {
+ 						$entry .= '<option value="">----------------</option>';
++					} else {
++						$entry .= '<option value="">' . $row['hint'] . '</option>';
+ 					}
+-					else {
+-						$entry .= '<option value="">' . $row['hint'] . '</option>' ;
+-					}
+-					$select_option = ext::explode([',', "\n"], $row['options']);
++					$select_option = ext::explode($row['options']);
+ 					$select_option = array_map('trim', $select_option);
+-					$selected = $this->request->variable($clean_name, '');
+-					foreach ($select_option as $value)
+-					{
++					$selected = $this->request->variable($clean_name, '', true);
++					foreach ($select_option as $value) {
+ 						list($form_value, $output_value) = ext::split($value);
+ 						$form_value = $this->translate($form_value);
+ 						$output_value = $this->translate($output_value);
+-					 	$entry .= '<option value="' . $output_value . '"' . ($output_value == $selected ? ' selected' : '') . '>' . $form_value . '</option>';
++						//$entry .= '<option value="' . $output_value . '"' . ($output_value == $selected ? ' selected' : '') . '>' . $form_value . '</option>';
++						$entry .= '<option value="' . $output_value . '"' . (trim($output_value) == $selected ? ' selected' : '') . '>' . $form_value . '</option>';
+ 					}
+ 					$entry .= '</select></div></div>';
+-				break;
++					break;
+ 
+ 				case 'radiobuttons':
+-					$radio_option = ext::explode([',', "\n"], $row['options']);
++					$radio_option = ext::explode($row['options']);
+ 					$radio_option = array_map('trim', $radio_option);
+-					$checked = $this->request->variable($clean_name, '');
+-					foreach ($radio_option as $value)
+-					{
++					$checked = $this->request->variable($clean_name, '', true);
++					foreach ($radio_option as $value) {
+ 						list($form_value, $output_value) = ext::split($value);
+-						$form_value = $this->translate($form_value);
++						//$form_value = $this->translate($form_value);
++						$form_value = $this->render($this->translate($form_value));
+ 						$output_value = $this->translate($output_value);
+-						$entry .= '<label><input type="radio"' . $tabindex . $mandatory . $name . $id . ' value="' . $output_value . '"' . ($output_value == $checked ? ' checked' : '') . '>&nbsp;' . $form_value . '&nbsp;&nbsp;</label>';
++						$entry .= '<label><input type="radio"' . $tabindex . $mandatory . $name . $id . ' value="' . $output_value . '"' . (trim($output_value) == $checked ? ' checked' : '') . '>&nbsp;' . $form_value . '&nbsp;&nbsp;</label>';
+ 					}
+-				break;
++					break;
+ 
+ 				case 'checkbox':
+-					$check_option = ext::explode([',', "\n"], $row['options']);
++					$check_option = ext::explode($row['options']);
+ 					$check_option = array_map('trim', $check_option);
+-					$checked = $this->request->variable($clean_name, [0 => '']);
+-					foreach ($check_option as $value)
+-					{
++					$checked = $this->request->variable($clean_name, [0 => ''], true);
++					foreach ($check_option as $value) {
+ 						list($form_value, $output_value) = ext::split($value);
+-						$entry .= '<label><input' . $type . $tabindex . $name_array . $id . ' value="' . $output_value . '"' . (in_array($output_value, $checked) ? ' checked' : '') . '>&nbsp;' . $form_value . '&nbsp;&nbsp;</label>';
++						$form_value = $this->render($this->translate($form_value));
++						$output_value = $this->translate($output_value);
++						$entry .= '<label><input' . $type . $tabindex . $name_array . $id . ' value="' . $output_value . '"' . (in_array(trim($output_value), $checked) ? ' checked' : '') . '>&nbsp;' . $form_value . '&nbsp;&nbsp;</label>';
+ 					}
+ 					$row['mandatory'] = (bool) $row['min_value'];
+-				break;
++					break;
+ 
+ 				case 'separator':
+ 					$entry = $this->render($this->translate($row['options']));
+-				break;
++					break;
+ 
+ 				default:
+-				break;
++					break;
+ 			}
+ 
+ 			$this->template->assign_block_vars('form_creator_template', [
+@@ -314,12 +305,10 @@ class listener implements EventSubscriberInterface
+ 			ORDER BY ndx_order ASC';
+ 		$result = $this->db->sql_query($sql);
+ 
+-		while ($row = $this->db->sql_fetchrow($result))
+-		{
++		while ($row = $this->db->sql_fetchrow($result)) {
+ 			$form_data[] = $row;
+ 
+-			if ($row['type'] == 'file')
+-			{
++			if ($row['type'] == 'file') {
+ 				$files[] = $row['name'];
+ 			}
+ 		}
+@@ -327,24 +316,19 @@ class listener implements EventSubscriberInterface
+ 
+ 		$fileupload = $this->files_factory->get('upload');
+ 
+-		foreach ($files as $name)
+-		{
++		foreach ($files as $name) {
+ 			$temp = $fileupload->handle_upload('files.types.form', 'upload');
+ 
+-			if ($temp->get('realname'))
+-			{
++			if ($temp->get('realname')) {
+ 				$names[] = $temp->get('realname');
+ 			}
+ 		}
+ 
+-		foreach ($form_data as $row)
+-		{
++		foreach ($form_data as $row) {
+ 			$name = 'templatefield_' . $row['id'];
+ 
+-			if (isset($row['type']))
+-			{
+-				switch ($row['type'])
+-				{
++			if (isset($row['type'])) {
++				switch ($row['type']) {
+ 					case 'email':
+ 					case 'password':
+ 					case 'url':
+@@ -354,46 +338,48 @@ class listener implements EventSubscriberInterface
+ 					case 'time':
+ 						$value = $this->request->variable($name, '', true);
+ 						$appform_post .= $this->create_form_element($row, $value, $value);
+-					break;
++						break;
+ 
+ 					case 'selectbox':
+ 					case 'radiobuttons':
+ 						$value = $this->request->variable($name, '', true);
+-						if ($value === '')
+-						{
++						if ($row['mandatory'] && $value === '') {
+ 							$errors[] = $this->user->lang('ERROR_MANDATORY', $this->get_clean_name($row['name']));
+ 						}
+ 						$appform_post .= $this->create_form_element($row, $value, $value);
+-					break;
++						break;
+ 
+ 					case 'checkbox':
+-						$value = $this->request->variable($name, [0 => ''] , true);
+-						if ($row['max_value'] && $row['min_value'] <= $row['max_value'] && (sizeof($value) < $row['min_value'] || sizeof($value) > $row['max_value']))
+-						{
++						$value = $this->request->variable($name, [0 => ''], true);
++						if ($row['min_value'] && $row['max_value'] && (count($value) < $row['min_value'] || count($value) > $row['max_value'])) {
+ 							$errors[] = $this->user->lang('ERROR_MIN_MAX_CHECKBOX', $row['min_value'], $row['max_value'], $this->get_clean_name($row['name']));
++						} else if ($row['min_value'] && count($value) < $row['min_value']) {
++							$errors[] = $this->user->lang('ERROR_MIN_CHECKBOX', $row['min_value'], $this->get_clean_name($row['name']));
++						} else if ($row['max_value'] && count($value) > $row['max_value']) {
++							$errors[] = $this->user->lang('ERROR_MAX_CHECKBOX', $row['max_value'], $this->get_clean_name($row['name']));
+ 						}
+-						$appform_post .= $this->create_form_element($row, $value, implode($value, $row['options_separator']));
+-					break;
++
++						$appform_post .= $this->create_form_element($row, $value, implode($row['options_separator'], $value));
++						break;
+ 
+ 					case 'number':
+ 						$value = $this->request->variable($name, 0);
+ 						$appform_post .= $this->create_form_element($row, $value, $value);
+-					break;
++						break;
+ 
+ 					case 'file':
+ 						$value = $this->request->variable($name, '', true);
+ 						$appform_post .= $this->create_form_element($row, $value, '[attachment=' . $file_count . ']' . $names[$file_count] . '[/attachment]' . $value, 'att');
+ 						$file_count++;
+-					break;
++						break;
+ 
+ 					default:
+-					break;
++						break;
+ 				}
+ 			}
+ 		}
+ 
+-		if ($errors)
+-		{
++		if ($errors) {
+ 			throw new exception('', $errors);
+ 		}
+ 
+@@ -404,11 +390,9 @@ class listener implements EventSubscriberInterface
+ 	{
+ 		$content = '';
+ 
+-		if ($value)
+-		{
+-			if ($element['name_visible'])
+-			{
+-				if(!empty($element['name']))
++		if ($value) {
++			if ($element['name_visible']) {
++				if (!empty($element['name']))
+ 					$content .= (ext::trim_once($element['name_before']) ?: '[form][b]') . $this->translate($this->get_clean_name($element['name'])) . (ext::trim_once($element['name_after']) ?: ':[/b][/form]');
+ 				else
+ 					$content .= (ext::trim_once($element['name_before']) ?: '[form][b]') . $this->translate($this->get_clean_name($element['name'])) . (ext::trim_once($element['name_after']) ?: '[/b][/form]');
+@@ -442,8 +426,9 @@ class listener implements EventSubscriberInterface
+ 
+ 		/** @var parser_interface $parser */
+ 		$parser = $phpbb_container->get('text_formatter.parser');
++		$parser->disable_magic_url();
++		$rendered = $renderer->render($parser->parse($text));
+ 
+-		return $renderer->render($parser->parse($text));
++		return htmlspecialchars_decode($rendered);
+ 	}
+-
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/ext.php"
+index 3c5f001b9..2c49f2bb4 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/ext.php"
+@@ -27,11 +27,22 @@ class ext extends \phpbb\extension\base
+ 		return version_compare($config['version'], '3.2.0-a1', '>=');
+ 	}
+ 
+-	public static function explode(array $delimiters, $string)
++	public static function explode($string)
+ 	{
+-		return preg_split('/[' . preg_quote(implode($delimiters)) . ']/', $string);
++		$separators = ["\n\n", "\n"];
++
++		foreach ($separators as $separator)
++		{
++			if (strpos($string, $separator) !== false)
++			{
++				return explode($separator, $string);
++			}
++		}
++
++		return explode(',', $string);
+ 	}
+ 
++
+ 	public static function trim_once($str)
+ 	{
+ 		if (utf8_strlen($str) < 2)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/en/common.php"
+index de8f463e9..8260e9b79 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/language/en/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/en/common.php"
+@@ -44,10 +44,19 @@ $lang = array_merge($lang, [
+ 	'FORM_MOD_PREVIEW'		 	=> 'Switch to preview keeping the current form data...',
+ 	'FORM_MOD_SUBMIT'			=> 'Add the form data to message and post...',
+ 	'OPEN_FORM_EXPLAIN'			=> 'Switch to Form Mode...',
++	'OPEN_POST_EXPLAIN'			=> 'Switch to Post Mode...',
+ 	'REFRESHING_FORM'			=> 'The current selected Forum is',
+ 	'REQUIRED'				 	=> 'You have not entered all the required elements!',
+ 	'MANDATORY'					=> 'Items marked with the asterisk are mandatory.',
+ 
+ 	'ERROR_MANDATORY'			=> 'The field %s is mandatory.',
+ 	'ERROR_MIN_MAX_CHECKBOX'	=> 'You need to select between %d and %d items for %s.',
++	'ERROR_MIN_CHECKBOX'		=> [
++		1 => 'You need to select at least %d item for %s.',
++		2 => 'You need to select at least %d items for %s.',
++	],
++	'ERROR_MAX_CHECKBOX'		=> [
++		1 => 'You can select at most %d item for %s.',
++		2 => 'You can select at most %d items for %s.',
++	],
+ ]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/common.php"
+new file mode 100644
+index 000000000..9627e9ed6
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/common.php"
+@@ -0,0 +1,62 @@
++<?php
++/**
++*
++* @package phpBB Extension - Form Creator
++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
++}
++
++// DEVELOPERS PLEASE NOTE
++//
++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++//
++// Placeholders can now contain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// translators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++// equally where a string contains only two placeholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++//
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++//
++
++$lang = array_merge($lang, [
++	'CLOSE_FORM'				=> 'Cancelar',
++	'OPEN_FORM'					=> 'Modo Gerador Automático',
++	'OPEN_POST'					=> 'Modo BBCode Manual',
++	'FORM_MOD_PREVIEW'		 	=> 'Alternar para pré-visualizar e manter os dados do formulário actual...',
++	'FORM_MOD_SUBMIT'			=> 'Converte e adiciona os dados do formulário à mensagem...',
++	'OPEN_FORM_EXPLAIN'			=> 'Alterar para Gerador Automático...',
++	'OPEN_POST_EXPLAIN'			=> 'Alterar para BBCode Manual...',
++	'REFRESHING_FORM'			=> 'O fórum selecionado actualmente é',
++	'REQUIRED'				 	=> 'Não preencheste todos os campos obrigatórios!',
++	'MANDATORY'					=> 'Campos marcados com asterisco são de preenchimento obrigatório.',
++
++	'ERROR_MANDATORY'			=> 'O campo %s é obrigatório.',
++	'ERROR_MIN_MAX_CHECKBOX'	=> 'Precisas de escolher pelo menos %d item e menos de %d itens para o campo %s.',
++	'ERROR_MIN_CHECKBOX'		=> [
++		1 => 'Precisas de escolher pelo menos %d item para o campo %s.',
++		2 => 'Precisas de escolher pelo menos %d itens para o campo %s.',
++	],
++	'ERROR_MAX_CHECKBOX'		=> [
++		1 => 'Podes escolher no máximo %d item para o campo %s.',
++		2 => 'Podes escolher no máximo %d itens para o campo %s.',
++	],
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/formcreator_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/formcreator_acp.php"
+new file mode 100644
+index 000000000..c807bc4c6
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/formcreator_acp.php"
+@@ -0,0 +1,185 @@
++<?php
++/**
++*
++* @package phpBB Extension - Form Creator
++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
++}
++
++// DEVELOPERS PLEASE NOTE
++//
++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++//
++// Placeholders can now contain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// translators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++// equally where a string contains only two placeholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++//
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++//
++
++$lang = array_merge($lang, [
++	'MODE'						=> 'Mode',
++	'ELEMENTS'					=> 'Elements',
++	'FORM_NAME'					=> 'Forum Name',
++	'FORUM_ID'					=> 'Forum ID',
++	'ACP_FORM_CURRENT'		 	=> 'Update Current Form',
++	'ACP_FORM_CREATOR'			=> 'Form Creator',
++	'ACP_FORM_CREATOR_EXPLAIN'	=> 'With this tool you can create and manage forms for your forum.',
++	'ACP_FORM_EXT_NOTE'			=> '<br><strong>Note:</strong> All actions are performed on the currently selected/displayed form, no confirm is implemented...',
++
++	'ACP_FORM_CREATOR_FAQ' => '<strong>How to begin?</strong><br>
++									&nbsp; &bull; You just need to first select the forum where you will want to create the form.<br>
++									<br>
++									<strong>How can I do that?</strong><br>
++									&nbsp; &bull; Just select a new forum from the <strong><i>Current Forum</i></strong> dropdown box...<br>
++									<br>
++									<strong>And now what?</strong><br>
++									&nbsp; &bull; Next step would be to add new form elements<br>
++									<br>
++									<strong>How do I add a new form element?</strong><br> 
++									&nbsp; &bull; Use <strong><i>Add a new form element</i></strong> at the bottom.<br>
++									<br>
++									<strong>After adding all the form elements I want, does it save automatically?</strong><br>
++									&nbsp; &bull; Yes, when you add the form element it saves automatically on the current form, but if you make changes on the form elements on the <strong><i>Update Current Form</i></strong> then you\'ll need to click update so it can save the changes!<br>
++									<br>
++									<strong>Some fields don\'t make sense to my element type, will something bad happen if I fill those fields?</strong><br>
++									&nbsp; &bull; Nothing bad will happen. You\'ll just put trash on the database. All that info will be discarded. That\'s why it\'s recommended to add an empty new form element and just then update it.<br>
++									<br>
++									<strong>How do I delete a form?</strong><br>
++									&nbsp; &bull; Simply delete all form elements...<br>
++									<br>
++									<br>
++									<strong>What is Name Before/After?</strong><br>
++									&nbsp; &bull; Those fields accept BBCode, and whatever you write there will appear before and after the Entry Name on the final post, so you can customize the Entry Name.<br>
++									<br>
++									<strong>Can I see an example for Name Before/After fields?</strong><br>
++									&nbsp; &bull; Sure. You can add <i>[b]</i> on the Before field and <i>[/b]</i> on the After field and if the Entry Name is <i>Title</i> then the post will be parsed into: <i>[b]Title[/b]</i><br>
++									<br>
++									<strong>What is Entry Name?</strong><br>
++									&nbsp; &bull; Really? This is the question on the form field, the text before the input field, and that text may or may not be imported to the final post.<br>
++									<br>
++									<strong>What is Entry Explain?</strong><br>
++									&nbsp; &bull; This is an optional field, if you fill it, it will appear below the Entry Name on the form, so you can insert a little explanation text. It supports BBCode and line break too.<br>
++									<br>
++									<strong>What is Hint?</strong><br>
++									&nbsp; &bull; Hint is optional and is what appears inside the input fields, so you can provide an idea of what should be filled on the input box. Its good idea to use in some cases to avoid abusing the Entry Explain. For selectbox the hint will be the default first element.<br>
++									<br>
++									<strong>What is Options?</strong><br>
++									&nbsp; &bull; It only works on some element types: selectbox, radiobuttons, checkbox and separator. With that said, it\'s a field where you\'ll insert the options for those element types.<br>
++									<br>
++									<strong>Can I see an example for Options fields? I am still confuse.</strong><br>
++									&nbsp; &bull; Sure. You can add for example genres as: <i>Action, Adventure, Horror, Romance, Sci-Fi</i>, and the user will be able to just select the options, instead of writing.<br>
++									<br>
++									<strong>That makes sense for selectbox, radiobuttons and checkbox, but separator? What is it? </strong><br>
++									&nbsp; &bull; Yes, that one is an exception. That field is only for form layout customization. A way to customize how the form itself will look like.<br>
++									<br>
++									<strong>Great! And do I always need to use a Comma to separate the words?</strong><br>
++									&nbsp; &bull; You can use a comma or a line break and there is a hidden feature too. If you use "Administrator => Adm, Moderator => Mod, User => U", where the former one will appear on the form and the latter one on the post.<br>
++									<br>
++									<strong>What is Min/Max?</strong><br>
++									&nbsp; &bull; This only works on Checkboxes since it\'s the only element type where you can select multiple items and with those fields you can require the user to choose between a min and max values. If you put Min: 1 and Max: 3, the user will need to choose at least one and less than 3 options.<br>
++									<br>
++									<strong>What is Value Before/After?</strong><br>
++									&nbsp; &bull; It\'s similar to the <i>Name Before/After</i>. It accepts BBCode as well and will appear before and after the value that the user inserted.<br>
++									<br>
++									<strong>Can I still see an example for Value Before/After fields?</strong><br>
++									&nbsp; &bull; Why not? You can add <i>[color=#ff0000]</i> on the Before field and <i>[/color]</i> on the After field and lets say the Entry Name is <i>Movie Title</i>. Then the user inserts on the form something as <i>Titanic</i> and when he submits, the post will be parsed into: <i>[color=#ff0000]Titanic[/color]</i><br>
++									<br>
++									<strong>Is there anything else that I should know?</strong><br>
++									&nbsp; &bull; I\'m glad you asked! Some fields as Entry Name, Explain, Hint and Options are translatable. This means you can insert language variables {L_LANGUAGE_VARIABLE} so the form will be multilingual.<br>
++									<br>
++									<strong>WOW! Awesome! But where can I add the Language Variables?</strong><br>
++									&nbsp; &bull; Just edit the root/ext/leinad4mind/formcreator/language/COUNTRY/common.php file and add new variables, so you can use at ACP afterwards.<br>
++									<br>
++									<strong>&#8730;</strong> The checkmark character indicates the item is mandatory and cannot be empty, so it will force the user to fill it.<br>
++									<strong><i class="fa fa-eye" aria-hidden="true"></i></strong> The eye character indicates the entry name of that item will not be imported to the post submitted.<br>',
++
++	'CURRENT_FORUM'			 	=> 'Current Forum',
++	'FORM_ADD_ITEM'				=> 'Add a new form element',
++	'FORM_CHECKBOX'				=> 'Check Box',
++	'FORM_DETAILS'			 	=> 'All forms use a generic template file: styles/YOUR_STYLE/template/forms/form_creator.html',
++	'FORM_ELEMENT_TYPE'					=> 'Element type',
++	'FORM_ELEMENT_HINT'					=> 'Hint',
++	'FORM_ELEMENT_OPTIONS_SEPARATOR'	=> 'Options separator',
++	'FORM_ELEMENT_NAME_VISIBLE'			=> 'Display/hide the element name on the final form.',
++	'FORM_ELEMENT_NAME'					=> 'Entry Name',
++	'FORM_ELEMENT_EXPLAIN'				=> 'Entry Explain',
++	'FORM_ELEMENT_NAME_EXPLAIN'			=> 'Entry Name/Explain',
++	'FORM_ELEMENT_OPTIONS'				=> 'Options',
++	'FORM_ELEMENT_MIN_MAX'				=> 'Min/Max',
++	'FORM_ELEMENT_MIN'					=> 'Min',
++	'FORM_ELEMENT_MAX'					=> 'Max',
++	'FORM_ELEMENT_NAME_BEFORE_AFTER'	=> 'Name before/after',
++	'FORM_ELEMENT_VALUE_BEFORE_AFTER'	=> 'Value before/after',
++	'FORM_EMAILBOX'				=> 'Email',
++	'FORM_INPUTBOX'				=> 'Text',
++	'FORM_CREATOR_ACP_RETURN'	=> 'Back to manage forms',
++	'FORM_MANAGE'				=> 'Manage this form',
++	'FORM_MANAGE_EXPLAIN'		=> 'Here you can modify all of the current form elements, simply edit fields and press the <strong>Update</strong> button...',
++
++	'FORM_NEW_ITEM_EXPLAIN'		=> '<pre style="font-size:11px; line-height: 100%;"><strong><u>Form Elements Supported</u></strong><br>
++									<strong>Inputbox:</strong>		Up to 255 characters<br>
++									<strong>Textbox:</strong>	 	Multiple lines of text arranged as 3 rows by 76 columns.<br>
++									<strong>Checkbox:</strong>		One or more options can be selected.<br>
++									<strong>Radiobutton:</strong> 		Only one option can be selected.<br>
++									<strong>Selectbox:</strong>		One option from a dropdown list.<br>
++									<strong>Email:</strong>			Valid email address.<br>
++									<strong>Password:</strong>		For test purposes only...<br>
++									<strong>URL:</strong>			A valid URL must be entered.<br>
++									<strong>Attachment:</strong>		Add a file to the attachment system.<br>
++									<strong>Number:</strong>			Only numbers 0-9 are allowed.<br>
++									<strong>Date:</strong>			Opens a date picker.<br>
++									<strong>Time:</strong>			Opens a time picker.<br>
++									<strong>Separator:</strong>			Only for form layout customization.<br>
++									<br></pre>',
++
++	'FORM_NO_FORM'			 	=> 'There are no forms assigned to: <strong>%s</strong>...<br>To add a new form to this forum, simply add a form element below...',
++	'FORM_RADIOBOX'				=> 'Radio Buttons',
++	'FORM_PASSWORDBOX'			=> 'Password',
++	'FORM_SELECTBOX'			=> 'Select Box',
++	'FORM_TXTBOX'				=> 'Text Box',
++	'FORM_URLBOX'				=> 'URL',
++	'FORM_ATTACH'				=> 'Attachment',
++	'FORM_NUMBER'				=> 'Number',
++	'FORM_DATE'					=> 'Date',
++	'FORM_TIME'					=> 'Time',
++	'FORM_SEPARATOR'			=> 'Separator',
++	'HIDE_FORM_INFO'			=> 'Hide info',
++	'HIDE_PREVIEW'			 	=> 'Hide Preview',
++	'HIDE_COPY'				 	=> 'Hide copy form',
++	'HOW_TO'					=> '<strong>Additional Help...</strong>',
++	'HOW_TO_MORE'				=> 'More info...',
++	'HOW_TO_HIDE'				=> '<strong>Hide</strong>',
++	'NDX'						=> 'NDX',
++	'NDX_ORDER'					=> 'Index order (the order in which items appear on the form)',
++	'FORMS_MOD_SAMPLE'		 	=> 'Rendering the current form to assist visualization only... not a working form.',
++	'SHOW_FORM_INFO'			=> 'More info on Element types',
++	'SHOW_PREVIEW'			 	=> 'Preview the form',
++	'SHOW_COPY'					=> 'Copy form',
++	'COPY_FORM'					=> 'Copy form to selected forums',
++	'COPY_FORM_EXPLAIN'			=> 'This will delete all existing form elements in the selected destination forums!',
++	'COPY_FORM_SUCCESS'			=> 'The form elements have been copied to all selected forums.',
++
++	'SHOW_FORM_DEFAULT'			=> 'Show form by default',
++	'FORCE_FORM'				=> 'Force form',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/info_acp_formcreator.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/info_acp_formcreator.php"
+new file mode 100644
+index 000000000..bd37f0bb1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/info_acp_formcreator.php"
+@@ -0,0 +1,43 @@
++<?php
++/**
++*
++* @package phpBB Extension - Form Creator
++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
++}
++
++// DEVELOPERS PLEASE NOTE
++//
++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++//
++// Placeholders can now contain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// translators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++// equally where a string contains only two placeholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++//
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++//
++
++$lang = array_merge($lang, [
++	'ACP_FORM_CREATOR'				=> 'Form Creator',
++	'ACP_FORM_CREATOR_CONFIG'	 	=> 'Configuration',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/permissions_formcreator.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/permissions_formcreator.php"
+new file mode 100644
+index 000000000..e1d24693c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/permissions_formcreator.php"
+@@ -0,0 +1,42 @@
++<?php
++/**
++*
++* @package phpBB Extension - Form Creator
++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
++}
++
++// DEVELOPERS PLEASE NOTE
++//
++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++//
++// Placeholders can now contain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// translators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++// equally where a string contains only two placeholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++//
++// Some characters for use
++// ’ » “ ” …
++
++$lang = array_merge($lang, [
++	'ACL_A_FORM_CREATOR'		=> 'Can manage Form Creator',
++	'ACL_F_FORM_CREATOR'		=> 'Can use Form Creator',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/common.php"
+new file mode 100644
+index 000000000..9627e9ed6
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/common.php"
+@@ -0,0 +1,62 @@
++<?php
++/**
++*
++* @package phpBB Extension - Form Creator
++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
++}
++
++// DEVELOPERS PLEASE NOTE
++//
++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++//
++// Placeholders can now contain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// translators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++// equally where a string contains only two placeholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++//
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++//
++
++$lang = array_merge($lang, [
++	'CLOSE_FORM'				=> 'Cancelar',
++	'OPEN_FORM'					=> 'Modo Gerador Automático',
++	'OPEN_POST'					=> 'Modo BBCode Manual',
++	'FORM_MOD_PREVIEW'		 	=> 'Alternar para pré-visualizar e manter os dados do formulário actual...',
++	'FORM_MOD_SUBMIT'			=> 'Converte e adiciona os dados do formulário à mensagem...',
++	'OPEN_FORM_EXPLAIN'			=> 'Alterar para Gerador Automático...',
++	'OPEN_POST_EXPLAIN'			=> 'Alterar para BBCode Manual...',
++	'REFRESHING_FORM'			=> 'O fórum selecionado actualmente é',
++	'REQUIRED'				 	=> 'Não preencheste todos os campos obrigatórios!',
++	'MANDATORY'					=> 'Campos marcados com asterisco são de preenchimento obrigatório.',
++
++	'ERROR_MANDATORY'			=> 'O campo %s é obrigatório.',
++	'ERROR_MIN_MAX_CHECKBOX'	=> 'Precisas de escolher pelo menos %d item e menos de %d itens para o campo %s.',
++	'ERROR_MIN_CHECKBOX'		=> [
++		1 => 'Precisas de escolher pelo menos %d item para o campo %s.',
++		2 => 'Precisas de escolher pelo menos %d itens para o campo %s.',
++	],
++	'ERROR_MAX_CHECKBOX'		=> [
++		1 => 'Podes escolher no máximo %d item para o campo %s.',
++		2 => 'Podes escolher no máximo %d itens para o campo %s.',
++	],
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/formcreator_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/formcreator_acp.php"
+new file mode 100644
+index 000000000..c807bc4c6
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/formcreator_acp.php"
+@@ -0,0 +1,185 @@
++<?php
++/**
++*
++* @package phpBB Extension - Form Creator
++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
++}
++
++// DEVELOPERS PLEASE NOTE
++//
++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++//
++// Placeholders can now contain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// translators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++// equally where a string contains only two placeholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++//
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++//
++
++$lang = array_merge($lang, [
++	'MODE'						=> 'Mode',
++	'ELEMENTS'					=> 'Elements',
++	'FORM_NAME'					=> 'Forum Name',
++	'FORUM_ID'					=> 'Forum ID',
++	'ACP_FORM_CURRENT'		 	=> 'Update Current Form',
++	'ACP_FORM_CREATOR'			=> 'Form Creator',
++	'ACP_FORM_CREATOR_EXPLAIN'	=> 'With this tool you can create and manage forms for your forum.',
++	'ACP_FORM_EXT_NOTE'			=> '<br><strong>Note:</strong> All actions are performed on the currently selected/displayed form, no confirm is implemented...',
++
++	'ACP_FORM_CREATOR_FAQ' => '<strong>How to begin?</strong><br>
++									&nbsp; &bull; You just need to first select the forum where you will want to create the form.<br>
++									<br>
++									<strong>How can I do that?</strong><br>
++									&nbsp; &bull; Just select a new forum from the <strong><i>Current Forum</i></strong> dropdown box...<br>
++									<br>
++									<strong>And now what?</strong><br>
++									&nbsp; &bull; Next step would be to add new form elements<br>
++									<br>
++									<strong>How do I add a new form element?</strong><br> 
++									&nbsp; &bull; Use <strong><i>Add a new form element</i></strong> at the bottom.<br>
++									<br>
++									<strong>After adding all the form elements I want, does it save automatically?</strong><br>
++									&nbsp; &bull; Yes, when you add the form element it saves automatically on the current form, but if you make changes on the form elements on the <strong><i>Update Current Form</i></strong> then you\'ll need to click update so it can save the changes!<br>
++									<br>
++									<strong>Some fields don\'t make sense to my element type, will something bad happen if I fill those fields?</strong><br>
++									&nbsp; &bull; Nothing bad will happen. You\'ll just put trash on the database. All that info will be discarded. That\'s why it\'s recommended to add an empty new form element and just then update it.<br>
++									<br>
++									<strong>How do I delete a form?</strong><br>
++									&nbsp; &bull; Simply delete all form elements...<br>
++									<br>
++									<br>
++									<strong>What is Name Before/After?</strong><br>
++									&nbsp; &bull; Those fields accept BBCode, and whatever you write there will appear before and after the Entry Name on the final post, so you can customize the Entry Name.<br>
++									<br>
++									<strong>Can I see an example for Name Before/After fields?</strong><br>
++									&nbsp; &bull; Sure. You can add <i>[b]</i> on the Before field and <i>[/b]</i> on the After field and if the Entry Name is <i>Title</i> then the post will be parsed into: <i>[b]Title[/b]</i><br>
++									<br>
++									<strong>What is Entry Name?</strong><br>
++									&nbsp; &bull; Really? This is the question on the form field, the text before the input field, and that text may or may not be imported to the final post.<br>
++									<br>
++									<strong>What is Entry Explain?</strong><br>
++									&nbsp; &bull; This is an optional field, if you fill it, it will appear below the Entry Name on the form, so you can insert a little explanation text. It supports BBCode and line break too.<br>
++									<br>
++									<strong>What is Hint?</strong><br>
++									&nbsp; &bull; Hint is optional and is what appears inside the input fields, so you can provide an idea of what should be filled on the input box. Its good idea to use in some cases to avoid abusing the Entry Explain. For selectbox the hint will be the default first element.<br>
++									<br>
++									<strong>What is Options?</strong><br>
++									&nbsp; &bull; It only works on some element types: selectbox, radiobuttons, checkbox and separator. With that said, it\'s a field where you\'ll insert the options for those element types.<br>
++									<br>
++									<strong>Can I see an example for Options fields? I am still confuse.</strong><br>
++									&nbsp; &bull; Sure. You can add for example genres as: <i>Action, Adventure, Horror, Romance, Sci-Fi</i>, and the user will be able to just select the options, instead of writing.<br>
++									<br>
++									<strong>That makes sense for selectbox, radiobuttons and checkbox, but separator? What is it? </strong><br>
++									&nbsp; &bull; Yes, that one is an exception. That field is only for form layout customization. A way to customize how the form itself will look like.<br>
++									<br>
++									<strong>Great! And do I always need to use a Comma to separate the words?</strong><br>
++									&nbsp; &bull; You can use a comma or a line break and there is a hidden feature too. If you use "Administrator => Adm, Moderator => Mod, User => U", where the former one will appear on the form and the latter one on the post.<br>
++									<br>
++									<strong>What is Min/Max?</strong><br>
++									&nbsp; &bull; This only works on Checkboxes since it\'s the only element type where you can select multiple items and with those fields you can require the user to choose between a min and max values. If you put Min: 1 and Max: 3, the user will need to choose at least one and less than 3 options.<br>
++									<br>
++									<strong>What is Value Before/After?</strong><br>
++									&nbsp; &bull; It\'s similar to the <i>Name Before/After</i>. It accepts BBCode as well and will appear before and after the value that the user inserted.<br>
++									<br>
++									<strong>Can I still see an example for Value Before/After fields?</strong><br>
++									&nbsp; &bull; Why not? You can add <i>[color=#ff0000]</i> on the Before field and <i>[/color]</i> on the After field and lets say the Entry Name is <i>Movie Title</i>. Then the user inserts on the form something as <i>Titanic</i> and when he submits, the post will be parsed into: <i>[color=#ff0000]Titanic[/color]</i><br>
++									<br>
++									<strong>Is there anything else that I should know?</strong><br>
++									&nbsp; &bull; I\'m glad you asked! Some fields as Entry Name, Explain, Hint and Options are translatable. This means you can insert language variables {L_LANGUAGE_VARIABLE} so the form will be multilingual.<br>
++									<br>
++									<strong>WOW! Awesome! But where can I add the Language Variables?</strong><br>
++									&nbsp; &bull; Just edit the root/ext/leinad4mind/formcreator/language/COUNTRY/common.php file and add new variables, so you can use at ACP afterwards.<br>
++									<br>
++									<strong>&#8730;</strong> The checkmark character indicates the item is mandatory and cannot be empty, so it will force the user to fill it.<br>
++									<strong><i class="fa fa-eye" aria-hidden="true"></i></strong> The eye character indicates the entry name of that item will not be imported to the post submitted.<br>',
++
++	'CURRENT_FORUM'			 	=> 'Current Forum',
++	'FORM_ADD_ITEM'				=> 'Add a new form element',
++	'FORM_CHECKBOX'				=> 'Check Box',
++	'FORM_DETAILS'			 	=> 'All forms use a generic template file: styles/YOUR_STYLE/template/forms/form_creator.html',
++	'FORM_ELEMENT_TYPE'					=> 'Element type',
++	'FORM_ELEMENT_HINT'					=> 'Hint',
++	'FORM_ELEMENT_OPTIONS_SEPARATOR'	=> 'Options separator',
++	'FORM_ELEMENT_NAME_VISIBLE'			=> 'Display/hide the element name on the final form.',
++	'FORM_ELEMENT_NAME'					=> 'Entry Name',
++	'FORM_ELEMENT_EXPLAIN'				=> 'Entry Explain',
++	'FORM_ELEMENT_NAME_EXPLAIN'			=> 'Entry Name/Explain',
++	'FORM_ELEMENT_OPTIONS'				=> 'Options',
++	'FORM_ELEMENT_MIN_MAX'				=> 'Min/Max',
++	'FORM_ELEMENT_MIN'					=> 'Min',
++	'FORM_ELEMENT_MAX'					=> 'Max',
++	'FORM_ELEMENT_NAME_BEFORE_AFTER'	=> 'Name before/after',
++	'FORM_ELEMENT_VALUE_BEFORE_AFTER'	=> 'Value before/after',
++	'FORM_EMAILBOX'				=> 'Email',
++	'FORM_INPUTBOX'				=> 'Text',
++	'FORM_CREATOR_ACP_RETURN'	=> 'Back to manage forms',
++	'FORM_MANAGE'				=> 'Manage this form',
++	'FORM_MANAGE_EXPLAIN'		=> 'Here you can modify all of the current form elements, simply edit fields and press the <strong>Update</strong> button...',
++
++	'FORM_NEW_ITEM_EXPLAIN'		=> '<pre style="font-size:11px; line-height: 100%;"><strong><u>Form Elements Supported</u></strong><br>
++									<strong>Inputbox:</strong>		Up to 255 characters<br>
++									<strong>Textbox:</strong>	 	Multiple lines of text arranged as 3 rows by 76 columns.<br>
++									<strong>Checkbox:</strong>		One or more options can be selected.<br>
++									<strong>Radiobutton:</strong> 		Only one option can be selected.<br>
++									<strong>Selectbox:</strong>		One option from a dropdown list.<br>
++									<strong>Email:</strong>			Valid email address.<br>
++									<strong>Password:</strong>		For test purposes only...<br>
++									<strong>URL:</strong>			A valid URL must be entered.<br>
++									<strong>Attachment:</strong>		Add a file to the attachment system.<br>
++									<strong>Number:</strong>			Only numbers 0-9 are allowed.<br>
++									<strong>Date:</strong>			Opens a date picker.<br>
++									<strong>Time:</strong>			Opens a time picker.<br>
++									<strong>Separator:</strong>			Only for form layout customization.<br>
++									<br></pre>',
++
++	'FORM_NO_FORM'			 	=> 'There are no forms assigned to: <strong>%s</strong>...<br>To add a new form to this forum, simply add a form element below...',
++	'FORM_RADIOBOX'				=> 'Radio Buttons',
++	'FORM_PASSWORDBOX'			=> 'Password',
++	'FORM_SELECTBOX'			=> 'Select Box',
++	'FORM_TXTBOX'				=> 'Text Box',
++	'FORM_URLBOX'				=> 'URL',
++	'FORM_ATTACH'				=> 'Attachment',
++	'FORM_NUMBER'				=> 'Number',
++	'FORM_DATE'					=> 'Date',
++	'FORM_TIME'					=> 'Time',
++	'FORM_SEPARATOR'			=> 'Separator',
++	'HIDE_FORM_INFO'			=> 'Hide info',
++	'HIDE_PREVIEW'			 	=> 'Hide Preview',
++	'HIDE_COPY'				 	=> 'Hide copy form',
++	'HOW_TO'					=> '<strong>Additional Help...</strong>',
++	'HOW_TO_MORE'				=> 'More info...',
++	'HOW_TO_HIDE'				=> '<strong>Hide</strong>',
++	'NDX'						=> 'NDX',
++	'NDX_ORDER'					=> 'Index order (the order in which items appear on the form)',
++	'FORMS_MOD_SAMPLE'		 	=> 'Rendering the current form to assist visualization only... not a working form.',
++	'SHOW_FORM_INFO'			=> 'More info on Element types',
++	'SHOW_PREVIEW'			 	=> 'Preview the form',
++	'SHOW_COPY'					=> 'Copy form',
++	'COPY_FORM'					=> 'Copy form to selected forums',
++	'COPY_FORM_EXPLAIN'			=> 'This will delete all existing form elements in the selected destination forums!',
++	'COPY_FORM_SUCCESS'			=> 'The form elements have been copied to all selected forums.',
++
++	'SHOW_FORM_DEFAULT'			=> 'Show form by default',
++	'FORCE_FORM'				=> 'Force form',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/info_acp_formcreator.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/info_acp_formcreator.php"
+new file mode 100644
+index 000000000..bd37f0bb1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/info_acp_formcreator.php"
+@@ -0,0 +1,43 @@
++<?php
++/**
++*
++* @package phpBB Extension - Form Creator
++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
++}
++
++// DEVELOPERS PLEASE NOTE
++//
++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++//
++// Placeholders can now contain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// translators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++// equally where a string contains only two placeholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++//
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++//
++
++$lang = array_merge($lang, [
++	'ACP_FORM_CREATOR'				=> 'Form Creator',
++	'ACP_FORM_CREATOR_CONFIG'	 	=> 'Configuration',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/permissions_formcreator.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/permissions_formcreator.php"
+new file mode 100644
+index 000000000..e1d24693c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/permissions_formcreator.php"
+@@ -0,0 +1,42 @@
++<?php
++/**
++*
++* @package phpBB Extension - Form Creator
++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
++}
++
++// DEVELOPERS PLEASE NOTE
++//
++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++//
++// Placeholders can now contain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// translators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++// equally where a string contains only two placeholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++//
++// Some characters for use
++// ’ » “ ” …
++
++$lang = array_merge($lang, [
++	'ACL_A_FORM_CREATOR'		=> 'Can manage Form Creator',
++	'ACL_F_FORM_CREATOR'		=> 'Can use Form Creator',
++]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/BBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/BBOOTS/template/event/overall_header_head_append.html"
+index edc55a40c..028dacf2e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/BBOOTS/template/event/overall_header_head_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/BBOOTS/template/event/overall_header_head_append.html"
+@@ -1,3 +1,3 @@
+-{% if SCRIPT_NAME eq 'viewtopic' or SCRIPT_NAME eq 'search' %}
++{% if SCRIPT_NAME in ['viewtopic', 'search'] %}
+ 	{% INCLUDECSS '@leinad4mind_formcreator/formcreator.css' %}
+ {% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+index edc55a40c..028dacf2e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+@@ -1,3 +1,3 @@
+-{% if SCRIPT_NAME eq 'viewtopic' or SCRIPT_NAME eq 'search' %}
++{% if SCRIPT_NAME in ['viewtopic', 'search'] %}
+ 	{% INCLUDECSS '@leinad4mind_formcreator/formcreator.css' %}
+ {% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_message_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_message_append.html"
+index 6e26a78b4..0d1275234 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_message_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_message_append.html"
+@@ -3,13 +3,13 @@
+ 	<div class="inner">
+ 		<div class="space10"></div>
+ 		<fieldset class="submit-buttons form-buttons">
+-			{{ S_HIDDEN_ADDRESS_FIELD }}
+-			{{ S_HIDDEN_FIELDS }}
++			{S_HIDDEN_ADDRESS_FIELD}
++			{S_HIDDEN_FIELDS}
+ 			{% EVENT posting_editor_submit_buttons %}
+-			{% if S_HAS_DRAFTS %}<input type="submit" accesskey="d" tabindex="8" name="load" value="{{ lang('LOAD_DRAFT') }}" class="btn btn-default" onclick="load_draft = true;">&nbsp; {% endif %}
+-			{% if S_SAVE_ALLOWED %}<input type="submit" accesskey="k" tabindex="7" name="save" value="{{ lang('SAVE_DRAFT') }}" class="btn btn-default">&nbsp; {% endif %}
+-			<input type="submit" tabindex="5" name="preview" value="{{ lang('PREVIEW') }}" class="btn btn-default"{% if not S_PRIVMSGS %} onclick="document.getElementById('postform').action += '#preview';"{% endif %}>&nbsp;
+-			<input type="submit" accesskey="s" tabindex="6" name="post" value="{{ lang('SUBMIT') }}" class="btn btn-default default-submit-action">&nbsp;
++			{% if S_HAS_DRAFTS %}<button type="submit" class="btn btn-default" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>" accesskey="d" tabindex="8" name="load" value="{{ lang('LOAD_DRAFT') }}" onclick="load_draft = true;"><span class="hidden-xs">{{ lang('LOAD_DRAFT') }}</span><i class="visible-xs fa fa-upload fa-btn-fx"></i></button>{% endif %}
++			{% if S_SAVE_ALLOWED %}<button type="submit" class="btn btn-default" data-loading-text="{{ lang('SAVING') }}&nbsp;<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>" accesskey="k" tabindex="7" name="save" value="{{ lang('SAVE_DRAFT') }}"><span class="hidden-xs">{{ lang('SAVE_DRAFT') }}</span><i class="visible-xs fa fa-floppy-o fa-btn-fx"></i></button>{% endif %}
++			<button type="submit" class="btn btn-default" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>" tabindex="5" name="preview" value="{{ lang('PREVIEW') }}"{% if not S_PRIVMSGS %} onclick="enable_form_preview(); document.getElementById('postform').action += '#preview';"{% endif %} >{{ lang('PREVIEW') }}</button>
++			<button type="submit" class="btn btn-default" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>" accesskey="s" tabindex="6" name="post" value="{{ lang('SUBMIT') }}">{{ lang('SUBMIT') }}</button>
+ 		</fieldset>
+ 		<div class="space10"></div>
+ 	</div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_subject_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
+index 250ebc23c..574801062 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
+@@ -8,7 +8,7 @@
+ {% if not S_FORCE_FORM %}
+ 	{% if MODE == 'post' %}
+ 		<div class="space10"></div>
+-		<button type="button" class="btn btn-default" accesskey="f" name="useform" onclick="toggle_validation(); switch_mode(this);" title="{{ lang('OPEN_FORM_EXPLAIN') }}">{{ lang(S_SHOW_FORM or S_FORCE_FORM ? 'OPEN_POST' : 'OPEN_FORM') }}</button>
++		<button type="button" class="btn btn-default" accesskey="f" name="useform" onclick="toggle_validation(); switch_mode(this);" title="{{ lang(S_SHOW_FORM ? 'OPEN_FORM_EXPLAIN' : 'OPEN_POST_EXPLAIN') }}">{{ lang(S_SHOW_FORM ? 'OPEN_POST' : 'OPEN_FORM') }}</button>
+ 	{% endif %}
+ {% endif %}
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_creator.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_creator.html"
+index 49ed2e63d..4cfedd757 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_creator.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_creator.html"
+@@ -22,7 +22,7 @@
+ 				{% else %}
+ 					<dl>
+ 						<dt>
+-							{% if form_creator_template.NAME_RICH %}<label for="{{ form_creator_template.CLEAN_NAME }}">{{ form_creator_template.NAME_RICH ~ lang('COLON') }}</label>{% endif %}{{ form_creator_template.MANDATORY }}
++							{% if form_creator_template.NAME_RICH %}<label for="{{ form_creator_template.CLEAN_NAME }}">{{ form_creator_template.NAME_RICH }}</label>{% endif %}{{ form_creator_template.MANDATORY }}
+ 							{% if form_creator_template.EXPLAIN %}
+ 								<br><span class="small">{{ form_creator_template.EXPLAIN }}</span>
+ 							{% endif %}
+@@ -36,7 +36,7 @@
+ 	<div class="panels">
+ 		<div class="inner">
+ 			<fieldset class="submit-buttons form-buttons">
+-				{{ S_FORM_TOKEN }}
++				{S_FORM_TOKEN}
+ 				<input type="reset" name="reset" value="{{ lang('RESET') }}" class="btn btn-default">&nbsp;
+ 				<input type="submit" tabindex="5" name="preview" value="{{ lang('PREVIEW') }}" class="btn btn-default" onclick="enable_form_preview(); document.getElementById('postform').action += '#preview';">&nbsp;
+ 				<input type="submit" accesskey="s" tabindex="6" name="post" value="{{ lang('SUBMIT') }}" class="btn btn-default default-submit-action" onclick="enable_form_preview();">
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_mod.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_mod.js"
+index 83d793167..53258fd55 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_mod.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_mod.js"
+@@ -31,6 +31,11 @@ function is_hidden(id)
+ function toggle_validation()
+ {
+ 	document.forms.postform.noValidate = !is_hidden('thisform');
++	if(!document.forms.postform.noValidate) {
++		$('#postform').attr('novalidate', true);
++		return;
++	}
++	$('#postform').removeAttr('novalidate');
+ }
+ 
+ function enable_form_preview()
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/prosilver/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/prosilver/template/event/overall_header_head_append.html"
+index edc55a40c..028dacf2e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/prosilver/template/event/overall_header_head_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/prosilver/template/event/overall_header_head_append.html"
+@@ -1,3 +1,3 @@
+-{% if SCRIPT_NAME eq 'viewtopic' or SCRIPT_NAME eq 'search' %}
++{% if SCRIPT_NAME in ['viewtopic', 'search'] %}
+ 	{% INCLUDECSS '@leinad4mind_formcreator/formcreator.css' %}
+ {% endif %}
+\ No newline at end of file
diff --git "[FORUM_EXT]/leinad4mind\\formcreator/diff_nospace.tmp" "[FORUM_EXT]/leinad4mind\\formcreator/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\formcreator/diff_nospace.tmp"
@@ -0,0 +1,1504 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
+index 4aa330281..4d81e91be 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
+@@ -91,32 +91,36 @@
+ 					</select>
+ 				</td>
+ 				<td class="td_20" title="{{ lang('MANDATORY') }}">
+-					<input style="cursor:pointer{% if definition.template_type_selected == 'checkbox' %};display:none{% endif %}" type="checkbox" name="q_mandatory[{{ form_template.ID }}]" value="1"{{ form_template.MANDATORY ? ' checked'}}>
++					<input style="cursor:pointer{% if definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' %};display:none{% endif %}" type="checkbox" name="q_mandatory[{{ form_template.ID }}]" value="1"{{ form_template.MANDATORY ? ' checked'}}>
+ 				</td>
+ 				<td class="td_20" title="{{ lang('FORM_ELEMENT_NAME_VISIBLE') }}">
+-					<input style="cursor:pointer" type="checkbox" name="q_name_visible[{{ form_template.ID }}]" value="1"{{ form_template.NAME_VISIBLE ? ' checked'}}>
++					<input style="cursor:pointer{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" type="checkbox" name="q_name_visible[{{ form_template.ID }}]" value="1"{{ form_template.NAME_VISIBLE ? ' checked'}}>
+ 				</td>
+ 				<td class="td_02">
+-					<textarea style="width:97%" name="q_name_before[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_BEFORE }}</textarea><br>
+-					<textarea style="width:97%" name="q_name_after[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_AFTER }}</textarea>
++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_name_before[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_BEFORE }}</textarea><br>
++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_name_after[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_AFTER }}</textarea>
+ 				</td>
+ 				<td class="td_02">
+-					<input style="width:97%" type="text" name="q_name[{{ form_template.ID }}]" value="{{ form_template.NAME }}" placeholder="{{ lang('FORM_ELEMENT_NAME') }}">
+-					<textarea style="width:97%" name="q_explain[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_EXPLAIN') }}">{{ form_template.EXPLAIN }}</textarea>
++					<input style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" type="text" name="q_name[{{ form_template.ID }}]" value="{{ form_template.NAME }}" placeholder="{{ lang('FORM_ELEMENT_NAME') }}">
++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_explain[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_EXPLAIN') }}">{{ form_template.EXPLAIN }}</textarea>
++					{% if definition.template_type_selected == 'textbox' %}
++						<textarea style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" name="q_hint[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">{{ form_template.HINT }}</textarea>
++					{% else %}
+ 						<input style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" type="text" name="q_hint[{{ form_template.ID }}]" value="{{ form_template.HINT }}" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">
++					{% endif %}
+ 				</td>
+ 				<td class="td_02">
+ 					<textarea style="width:97%{% if !(definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'selectbox') %};display:none{% endif %}" name="q_options[{{ form_template.ID }}]" rows="3">{{ form_template.OPTIONS }}</textarea>
+-					<input style="width:97%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="text" name="q_options_separator[{{ form_template.ID }}]" value="{{ form_template.OPTIONS_SEPARATOR }}" placeholder="{{ lang('FORM_ELEMENT_OPTIONS_SEPARATOR') }}">
++					<input style="width:97%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="text" name="q_options_separator[{{ form_template.ID }}]" value="{{ form_template.OPTIONS_SEPARATOR }}" placeholder="{{ lang('FORM_ELEMENT_OPTIONS_SEPARATOR') }}">
+ 				</td>
+ 				<td class="td_02">
+-					<input style="width:90%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="number" min="0" name="q_mins[{{ form_template.ID }}]" value="{{ form_template.MIN }}" placeholder="{{ lang('FORM_ELEMENT_MIN') }}">
+-					<input style="width:90%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="number" min="0" name="q_maxs[{{ form_template.ID }}]" value="{{ form_template.MAX}}" placeholder="{{ lang('FORM_ELEMENT_MAX') }}">
++					<input style="width:90%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="number" min="0" name="q_mins[{{ form_template.ID }}]" value="{{ form_template.MIN }}" placeholder="{{ lang('FORM_ELEMENT_MIN') }}">
++					<input style="width:90%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="number" min="0" name="q_maxs[{{ form_template.ID }}]" value="{{ form_template.MAX}}" placeholder="{{ lang('FORM_ELEMENT_MAX') }}">
+ 				</td>
+ 				
+ 				<td class="td_02">
+-					<textarea style="width:97%" name="q_value_before[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_BEFORE }}</textarea><br>
+-					<textarea style="width:97%" name="q_value_after[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_AFTER }}</textarea>
++						<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_value_before[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_BEFORE }}</textarea><br>
++						<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_value_after[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_AFTER }}</textarea>
+ 				</td>
+ 			</tr>
+ 			{% endfor %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/composer.json"
+index 10c273904..c5b1cf34c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/composer.json"
+@@ -3,8 +3,8 @@
+ 	"type": "phpbb-extension",
+ 	"description": "Create forms to collect data from you members in any forum (one form per forum)",
+ 	"homepage": "https://www.leinad4mind.top/forum",
+-	"version": "2.2.4",
+-	"time": "2019-07-05",
++	"version": "2.2.5",
++	"time": "2019-08-07",
+ 	"keywords": ["phpbb", "extension", "formcreator"],
+ 	"license": "GPL-2.0",
+ 	"authors": [
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/controller/admin_controller.php"
+index 603741919..780efa27b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/controller/admin_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/controller/admin_controller.php"
+@@ -460,7 +460,7 @@ class admin_controller
+ 				case 'selectbox':
+ 					$type = '<select style="border-radius: 5px;" class="inputbox" name="templatefield_' . $row['id'] . '" tabindex="' . $row['ndx_order'] . '">';
+ 					$type .= '<option value="">----------------</option>';
+-					$select_option = ext::explode([',', "\n"], $row['options']);
++					$select_option = ext::explode($row['options']);
+ 					foreach ($select_option as $value)
+ 					{
+ 						$type .='<option value="'. $value .'">' . $value . '</option>';
+@@ -468,7 +468,7 @@ class admin_controller
+ 					$type .= '</select>';
+ 				break;
+ 				case 'radiobuttons':
+-					$radio_option = ext::explode([',', "\n"], $row['options']);
++					$radio_option = ext::explode($row['options']);
+ 
+ 					$type = '';
+ 					foreach ($radio_option as $value)
+@@ -477,7 +477,7 @@ class admin_controller
+ 					}
+ 				break;
+ 				case 'checkbox':
+-					$check_option = ext::explode([',', "\n"], $row['options']);
++					$check_option = ext::explode($row['options']);
+ 
+ 					$type = '';
+ 					foreach ($check_option as $value)
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/diff_full.tmp"
+new file mode 100644
+index 000000000..77b24f681
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/diff_full.tmp"
+@@ -0,0 +1,1409 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
++index 4aa330281..4d81e91be 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
++@@ -91,32 +91,36 @@
++ 					</select>
++ 				</td>
++ 				<td class="td_20" title="{{ lang('MANDATORY') }}">
++-					<input style="cursor:pointer{% if definition.template_type_selected == 'checkbox' %};display:none{% endif %}" type="checkbox" name="q_mandatory[{{ form_template.ID }}]" value="1"{{ form_template.MANDATORY ? ' checked'}}>
+++					<input style="cursor:pointer{% if definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' %};display:none{% endif %}" type="checkbox" name="q_mandatory[{{ form_template.ID }}]" value="1"{{ form_template.MANDATORY ? ' checked'}}>
++ 				</td>
++ 				<td class="td_20" title="{{ lang('FORM_ELEMENT_NAME_VISIBLE') }}">
++-					<input style="cursor:pointer" type="checkbox" name="q_name_visible[{{ form_template.ID }}]" value="1"{{ form_template.NAME_VISIBLE ? ' checked'}}>
+++					<input style="cursor:pointer{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" type="checkbox" name="q_name_visible[{{ form_template.ID }}]" value="1"{{ form_template.NAME_VISIBLE ? ' checked'}}>
++ 				</td>
++ 				<td class="td_02">
++-					<textarea style="width:97%" name="q_name_before[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_BEFORE }}</textarea><br>
++-					<textarea style="width:97%" name="q_name_after[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_AFTER }}</textarea>
+++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_name_before[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_BEFORE }}</textarea><br>
+++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_name_after[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_AFTER }}</textarea>
++ 				</td>
++ 				<td class="td_02">
++-					<input style="width:97%" type="text" name="q_name[{{ form_template.ID }}]" value="{{ form_template.NAME }}" placeholder="{{ lang('FORM_ELEMENT_NAME') }}">
++-					<textarea style="width:97%" name="q_explain[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_EXPLAIN') }}">{{ form_template.EXPLAIN }}</textarea>
++-					<input style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" type="text" name="q_hint[{{ form_template.ID }}]" value="{{ form_template.HINT }}" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">
+++					<input style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" type="text" name="q_name[{{ form_template.ID }}]" value="{{ form_template.NAME }}" placeholder="{{ lang('FORM_ELEMENT_NAME') }}">
+++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_explain[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_EXPLAIN') }}">{{ form_template.EXPLAIN }}</textarea>
+++					{% if definition.template_type_selected == 'textbox' %}
+++						<textarea style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" name="q_hint[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">{{ form_template.HINT }}</textarea>
+++					{% else %}
+++						<input style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" type="text" name="q_hint[{{ form_template.ID }}]" value="{{ form_template.HINT }}" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">
+++					{% endif %}
++ 				</td>
++ 				<td class="td_02">
++ 					<textarea style="width:97%{% if !(definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'selectbox') %};display:none{% endif %}" name="q_options[{{ form_template.ID }}]" rows="3">{{ form_template.OPTIONS }}</textarea>
++-					<input style="width:97%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="text" name="q_options_separator[{{ form_template.ID }}]" value="{{ form_template.OPTIONS_SEPARATOR }}" placeholder="{{ lang('FORM_ELEMENT_OPTIONS_SEPARATOR') }}">
+++					<input style="width:97%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="text" name="q_options_separator[{{ form_template.ID }}]" value="{{ form_template.OPTIONS_SEPARATOR }}" placeholder="{{ lang('FORM_ELEMENT_OPTIONS_SEPARATOR') }}">
++ 				</td>
++ 				<td class="td_02">
++-					<input style="width:90%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="number" min="0" name="q_mins[{{ form_template.ID }}]" value="{{ form_template.MIN }}" placeholder="{{ lang('FORM_ELEMENT_MIN') }}">
++-					<input style="width:90%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="number" min="0" name="q_maxs[{{ form_template.ID }}]" value="{{ form_template.MAX}}" placeholder="{{ lang('FORM_ELEMENT_MAX') }}">
+++					<input style="width:90%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="number" min="0" name="q_mins[{{ form_template.ID }}]" value="{{ form_template.MIN }}" placeholder="{{ lang('FORM_ELEMENT_MIN') }}">
+++					<input style="width:90%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="number" min="0" name="q_maxs[{{ form_template.ID }}]" value="{{ form_template.MAX}}" placeholder="{{ lang('FORM_ELEMENT_MAX') }}">
++ 				</td>
++ 				
++ 				<td class="td_02">
++-					<textarea style="width:97%" name="q_value_before[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_BEFORE }}</textarea><br>
++-					<textarea style="width:97%" name="q_value_after[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_AFTER }}</textarea>
+++						<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_value_before[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_BEFORE }}</textarea><br>
+++						<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_value_after[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_AFTER }}</textarea>
++ 				</td>
++ 			</tr>
++ 			{% endfor %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/composer.json"
++index 10c273904..c5b1cf34c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/composer.json"
++@@ -3,8 +3,8 @@
++ 	"type": "phpbb-extension",
++ 	"description": "Create forms to collect data from you members in any forum (one form per forum)",
++ 	"homepage": "https://www.leinad4mind.top/forum",
++-	"version": "2.2.4",
++-	"time": "2019-07-05",
+++	"version": "2.2.5",
+++	"time": "2019-08-07",
++ 	"keywords": ["phpbb", "extension", "formcreator"],
++ 	"license": "GPL-2.0",
++ 	"authors": [
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/controller/admin_controller.php"
++index 603741919..780efa27b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/controller/admin_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/controller/admin_controller.php"
++@@ -460,7 +460,7 @@ class admin_controller
++ 				case 'selectbox':
++ 					$type = '<select style="border-radius: 5px;" class="inputbox" name="templatefield_' . $row['id'] . '" tabindex="' . $row['ndx_order'] . '">';
++ 					$type .= '<option value="">----------------</option>';
++-					$select_option = ext::explode([',', "\n"], $row['options']);
+++					$select_option = ext::explode($row['options']);
++ 					foreach ($select_option as $value)
++ 					{
++ 						$type .='<option value="'. $value .'">' . $value . '</option>';
++@@ -468,7 +468,7 @@ class admin_controller
++ 					$type .= '</select>';
++ 				break;
++ 				case 'radiobuttons':
++-					$radio_option = ext::explode([',', "\n"], $row['options']);
+++					$radio_option = ext::explode($row['options']);
++ 
++ 					$type = '';
++ 					foreach ($radio_option as $value)
++@@ -477,7 +477,7 @@ class admin_controller
++ 					}
++ 				break;
++ 				case 'checkbox':
++-					$check_option = ext::explode([',', "\n"], $row['options']);
+++					$check_option = ext::explode($row['options']);
++ 
++ 					$type = '';
++ 					foreach ($check_option as $value)
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/diff_full.tmp"
++new file mode 100644
++index 000000000..2b77412f9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/diff_full.tmp"
++@@ -0,0 +1,56 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
+++index 4aa330281..4d81e91be 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/adm/style/acp_form_creator.html"
+++@@ -91,32 +91,36 @@
+++ 					</select>
+++ 				</td>
+++ 				<td class="td_20" title="{{ lang('MANDATORY') }}">
+++-					<input style="cursor:pointer{% if definition.template_type_selected == 'checkbox' %};display:none{% endif %}" type="checkbox" name="q_mandatory[{{ form_template.ID }}]" value="1"{{ form_template.MANDATORY ? ' checked'}}>
++++					<input style="cursor:pointer{% if definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' %};display:none{% endif %}" type="checkbox" name="q_mandatory[{{ form_template.ID }}]" value="1"{{ form_template.MANDATORY ? ' checked'}}>
+++ 				</td>
+++ 				<td class="td_20" title="{{ lang('FORM_ELEMENT_NAME_VISIBLE') }}">
+++-					<input style="cursor:pointer" type="checkbox" name="q_name_visible[{{ form_template.ID }}]" value="1"{{ form_template.NAME_VISIBLE ? ' checked'}}>
++++					<input style="cursor:pointer{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" type="checkbox" name="q_name_visible[{{ form_template.ID }}]" value="1"{{ form_template.NAME_VISIBLE ? ' checked'}}>
+++ 				</td>
+++ 				<td class="td_02">
+++-					<textarea style="width:97%" name="q_name_before[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_BEFORE }}</textarea><br>
+++-					<textarea style="width:97%" name="q_name_after[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_AFTER }}</textarea>
++++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_name_before[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_BEFORE }}</textarea><br>
++++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_name_after[{{ form_template.ID }}]" rows="3">{{ form_template.NAME_AFTER }}</textarea>
+++ 				</td>
+++ 				<td class="td_02">
+++-					<input style="width:97%" type="text" name="q_name[{{ form_template.ID }}]" value="{{ form_template.NAME }}" placeholder="{{ lang('FORM_ELEMENT_NAME') }}">
+++-					<textarea style="width:97%" name="q_explain[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_EXPLAIN') }}">{{ form_template.EXPLAIN }}</textarea>
+++-					<input style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" type="text" name="q_hint[{{ form_template.ID }}]" value="{{ form_template.HINT }}" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">
++++					<input style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" type="text" name="q_name[{{ form_template.ID }}]" value="{{ form_template.NAME }}" placeholder="{{ lang('FORM_ELEMENT_NAME') }}">
++++					<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_explain[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_EXPLAIN') }}">{{ form_template.EXPLAIN }}</textarea>
++++					{% if definition.template_type_selected == 'textbox' %}
++++						<textarea style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" name="q_hint[{{ form_template.ID }}]" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">{{ form_template.HINT }}</textarea>
++++					{% else %}
++++						<input style="width:97%{% if (definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'file' or definition.template_type_selected == 'number' or definition.template_type_selected == 'date' or definition.template_type_selected == 'time') %};display:none{% endif %}" type="text" name="q_hint[{{ form_template.ID }}]" value="{{ form_template.HINT }}" placeholder="{{ lang('FORM_ELEMENT_HINT') }}">
++++					{% endif %}
+++ 				</td>
+++ 				<td class="td_02">
+++ 					<textarea style="width:97%{% if !(definition.template_type_selected == 'checkbox' or definition.template_type_selected == 'separator' or definition.template_type_selected == 'radiobuttons' or definition.template_type_selected == 'selectbox') %};display:none{% endif %}" name="q_options[{{ form_template.ID }}]" rows="3">{{ form_template.OPTIONS }}</textarea>
+++-					<input style="width:97%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="text" name="q_options_separator[{{ form_template.ID }}]" value="{{ form_template.OPTIONS_SEPARATOR }}" placeholder="{{ lang('FORM_ELEMENT_OPTIONS_SEPARATOR') }}">
++++					<input style="width:97%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="text" name="q_options_separator[{{ form_template.ID }}]" value="{{ form_template.OPTIONS_SEPARATOR }}" placeholder="{{ lang('FORM_ELEMENT_OPTIONS_SEPARATOR') }}">
+++ 				</td>
+++ 				<td class="td_02">
+++-					<input style="width:90%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="number" min="0" name="q_mins[{{ form_template.ID }}]" value="{{ form_template.MIN }}" placeholder="{{ lang('FORM_ELEMENT_MIN') }}">
+++-					<input style="width:90%{% if definition.template_type_selected != 'checkbox' or definition.template_type_selected != 'separator' %};display:none{% endif %}" type="number" min="0" name="q_maxs[{{ form_template.ID }}]" value="{{ form_template.MAX}}" placeholder="{{ lang('FORM_ELEMENT_MAX') }}">
++++					<input style="width:90%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="number" min="0" name="q_mins[{{ form_template.ID }}]" value="{{ form_template.MIN }}" placeholder="{{ lang('FORM_ELEMENT_MIN') }}">
++++					<input style="width:90%{% if definition.template_type_selected != 'checkbox' %};display:none{% endif %}" type="number" min="0" name="q_maxs[{{ form_template.ID }}]" value="{{ form_template.MAX}}" placeholder="{{ lang('FORM_ELEMENT_MAX') }}">
+++ 				</td>
+++ 				
+++ 				<td class="td_02">
+++-					<textarea style="width:97%" name="q_value_before[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_BEFORE }}</textarea><br>
+++-					<textarea style="width:97%" name="q_value_after[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_AFTER }}</textarea>
++++						<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_value_before[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_BEFORE }}</textarea><br>
++++						<textarea style="width:97%{% if definition.template_type_selected == 'separator' %};display:none{% endif %}" name="q_value_after[{{ form_template.ID }}]" rows="3">{{ form_template.VALUE_AFTER }}</textarea>
+++ 				</td>
+++ 			</tr>
+++ 			{% endfor %}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/composer.json"
+++index 10c273904..c5b1cf34c 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcre
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/event/listener.php"
++index f82c9d2a0..3f906088b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/event/listener.php"
++@@ -1,12 +1,13 @@
++ <?php
+++
++ /**
++-*
++-* @package phpBB Extension - Form Creator
++-* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
++-* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
+++ *
+++ * @package phpBB Extension - Form Creator
+++ * @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+++ * @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
++ 
++ namespace leinad4mind\formcreator\event;
++ 
++@@ -55,22 +56,22 @@ class listener implements EventSubscriberInterface
++ 	protected $files_factory;
++ 
++ 	/**
++-	* Constructor
++-	*
++-	* @param \phpbb\user						$user
++-	* @param \phpbb\template\template			$template
++-	* @param \phpbb\db\driver\driver_interface	$db
++-	* @param \phpbb\config\config				$config
++-	* @param \phpbb\auth\auth					$auth
++-	* @param \phpbb\controller\helper			$helper
++-	* @param \phpbb\cache\service		 		$cache
++-	* @param \phpbb\request\request		 		$request
++-	* @param string								$root_path
++-	* @param string								$php_ext
++-	* @param string								$table_formcreator
++-	* @param \phpbb\files\factory				$files_factory
++-	*
++-	*/
+++	 * Constructor
+++	 *
+++	 * @param \phpbb\user						$user
+++	 * @param \phpbb\template\template			$template
+++	 * @param \phpbb\db\driver\driver_interface	$db
+++	 * @param \phpbb\config\config				$config
+++	 * @param \phpbb\auth\auth					$auth
+++	 * @param \phpbb\controller\helper			$helper
+++	 * @param \phpbb\cache\service		 		$cache
+++	 * @param \phpbb\request\request		 		$request
+++	 * @param string								$root_path
+++	 * @param string								$php_ext
+++	 * @param string								$table_formcreator
+++	 * @param \phpbb\files\factory				$files_factory
+++	 *
+++	 */
++ 	public function __construct(
++ 		\phpbb\user $user,
++ 		\phpbb\template\template $template,
++@@ -84,8 +85,7 @@ class listener implements EventSubscriberInterface
++ 		$php_ext,
++ 		$table_formcreator,
++ 		\phpbb\files\factory $files_factory
++-	)
++-	{
+++	) {
++ 		$this->user					= $user;
++ 		$this->template				= $template;
++ 		$this->db					= $db;
++@@ -135,12 +135,10 @@ class listener implements EventSubscriberInterface
++ 
++ 	public function modify_message_text($event)
++ 	{
++-		if ($this->can_use_form($event))
++-		{
+++		if ($this->can_use_form($event)) {
++ 			$message = $this->request->variable('message', '', true);
++ 
++-			if ($message === '' || $this->request->is_set_post('form_creator_preview'))
++-			{
+++			if ($message === '' || $this->request->is_set_post('form_creator_preview')) {
++ 				$mode 			= $event['mode'];
++ 				$forum_id 		= $event['forum_id'];
++ 				$submit 		= $event['submit'];
++@@ -149,19 +147,15 @@ class listener implements EventSubscriberInterface
++ 				$message_parser = $event['message_parser'];
++ 				$files 			= $this->request->get_super_global(\phpbb\request\request::FILES);
++ 
++-				try
++-				{
+++				try {
++ 					$message = $this->grab_form_data($forum_id);
++ 
++-					foreach ($files as $key => $name)
++-					{
+++					foreach ($files as $key => $name) {
++ 						$message_parser->parse_attachments($key, $mode, $forum_id, $submit, $preview, $refresh);
++ 					}
++ 
++ 					$message_parser->message = $message;
++-				}
++-				catch (exception $e)
++-				{
+++				} catch (exception $e) {
++ 					$event['error'] = array_merge($event['error'], $e->get_parameters());
++ 				}
++ 			}
++@@ -170,8 +164,7 @@ class listener implements EventSubscriberInterface
++ 
++ 	public function posting_modify_template_vars($event)
++ 	{
++-		if ($this->can_use_form($event))
++-		{
+++		if ($this->can_use_form($event)) {
++ 			$this->build_form($event['forum_id'], $event['mode']);
++ 		}
++ 	}
++@@ -185,8 +178,7 @@ class listener implements EventSubscriberInterface
++ 			ORDER BY ndx_order ASC';
++ 		$result = $this->db->sql_query($sql);
++ 
++-		while ($row = $this->db->sql_fetchrow($result))
++-		{
+++		while ($row = $this->db->sql_fetchrow($result)) {
++ 			$entry 			= '';
++ 			$clean_name 	= 'templatefield_' . $row['id'];
++ 
++@@ -203,8 +195,7 @@ class listener implements EventSubscriberInterface
++ 			$cols			= ' rows="3"';
++ 			$rows			= ' cols="76"';
++ 
++-			switch (strtolower($row['type']))
++-			{
+++			switch (strtolower($row['type'])) {
++ 				case 'email':
++ 				case 'password':
++ 				case 'url':
++@@ -214,70 +205,70 @@ class listener implements EventSubscriberInterface
++ 				case 'time':
++ 					$value = $this->request->variable($clean_name, '', true);
++ 					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><input' . $type . $name . $id . $placeholder . $mandatory . $size . $maxlength . $tabindex . $class . ' value="' . $value . '"></div></div>';
++-				break;
+++					break;
++ 
++ 				case 'number':
++ 					$value = $this->request->variable($clean_name, 0);
++ 					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><input' . $type . $name . $id . $placeholder . $mandatory . $size . $tabindex . $class . ' value="' . $value . '"></div></div>';
++-				break;
+++					break;
++ 
++ 				case 'textbox':
++ 					$value = $this->request->variable($clean_name, '', true);
++ 					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><textarea' . $type . $name . $id . $rows . $cols . $tabindex . $placeholder . $mandatory . $class . '" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">' . $value . '</textarea></div></div>';
++-				break;
+++					break;
++ 
++ 				case 'selectbox':
++-					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><select'. $type . $name . $id . $tabindex . $mandatory . $class . '>';
++-					if(empty($row['hint'])) {
+++					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><select' . $type . $name . $id . $tabindex . $mandatory . $class . '>';
+++					if (empty($row['hint'])) {
++ 						$entry .= '<option value="">----------------</option>';
+++					} else {
+++						$entry .= '<option value="">' . $row['hint'] . '</option>';
++ 					}
++-					else {
++-						$entry .= '<option value="">' . $row['hint'] . '</option>' ;
++-					}
++-					$select_option = ext::explode([',', "\n"], $row['options']);
+++					$select_option = ext::explode($row['options']);
++ 					$select_option = array_map('trim', $select_option);
++-					$selected = $this->request->variable($clean_name, '');
++-					foreach ($select_option as $value)
++-					{
+++					$selected = $this->request->variable($clean_name, '', true);
+++					foreach ($select_option as $value) {
++ 						list($form_value, $output_value) = ext::split($value);
++ 						$form_value = $this->translate($form_value);
++ 						$output_value = $this->translate($output_value);
++-					 	$entry .= '<option value="' . $output_value . '"' . ($output_value == $selected ? ' selected' : '') . '>' . $form_value . '</option>';
+++						//$entry .= '<option value="' . $output_value . '"' . ($output_value == $selected ? ' selected' : '') . '>' . $form_value . '</option>';
+++						$entry .= '<option value="' . $output_value . '"' . (trim($output_value) == $selected ? ' selected' : '') . '>' . $form_value . '</option>';
++ 					}
++ 					$entry .= '</select></div></div>';
++-				break;
+++					break;
++ 
++ 				case 'radiobuttons':
++-					$radio_option = ext::explode([',', "\n"], $row['options']);
+++					$radio_option = ext::explode($row['options']);
++ 					$radio_option = array_map('trim', $radio_option);
++-					$checked = $this->request->variable($clean_name, '');
++-					foreach ($radio_option as $value)
++-					{
+++					$checked = $this->request->variable($clean_name, '', true);
+++					foreach ($radio_option as $value) {
++ 						list($form_value, $output_value) = ext::split($value);
++-						$form_value = $this->translate($form_value);
+++						//$form_value = $this->translate($form_value);
+++						$form_value = $this->render($this->translate($form_value));
++ 						$output_value = $this->translate($output_value);
++-						$entry .= '<label><input type="radio"' . $tabindex . $mandatory . $name . $id . ' value="' . $output_value . '"' . ($output_value == $checked ? ' checked' : '') . '>&nbsp;' . $form_value . '&nbsp;&nbsp;</label>';
+++						$entry .= '<label><input type="radio"' . $tabindex . $mandatory . $name . $id . ' value="' . $output_value . '"' . (trim($output_value) == $checked ? ' checked' : '') . '>&nbsp;' . $form_value . '&nbsp;&nbsp;</label>';
++ 					}
++-				break;
+++					break;
++ 
++ 				case 'checkbox':
++-					$check_option = ext::explode([',', "\n"], $row['options']);
+++					$check_option = ext::explode($row['options']);
++ 					$check_option = array_map('trim', $check_option);
++-					$checked = $this->request->variable($clean_name, [0 => '']);
++-					foreach ($check_option as $value)
++-					{
+++					$checked = $this->request->variable($clean_name, [0 => ''], true);
+++					foreach ($check_option as $value) {
++ 						list($form_value, $output_value) = ext::split($value);
++-						$entry .= '<label><input' . $type . $tabindex . $name_array . $id . ' value="' . $output_value . '"' . (in_array($output_value, $checked) ? ' checked' : '') . '>&nbsp;' . $form_value . '&nbsp;&nbsp;</label>';
+++						$form_value = $this->render($this->translate($form_value));
+++						$output_value = $this->translate($output_value);
+++						$entry .= '<label><input' . $type . $tabindex . $name_array . $id . ' value="' . $output_value . '"' . (in_array(trim($output_value), $checked) ? ' checked' : '') . '>&nbsp;' . $form_value . '&nbsp;&nbsp;</label>';
++ 					}
++ 					$row['mandatory'] = (bool) $row['min_value'];
++-				break;
+++					break;
++ 
++ 				case 'separator':
++ 					$entry = $this->render($this->translate($row['options']));
++-				break;
+++					break;
++ 
++ 				default:
++-				break;
+++					break;
++ 			}
++ 
++ 			$this->template->assign_block_vars('form_creator_template', [
++@@ -314,12 +305,10 @@ class listener implements EventSubscriberInterface
++ 			ORDER BY ndx_order ASC';
++ 		$result = $this->db->sql_query($sql);
++ 
++-		while ($row = $this->db->sql_fetchrow($result))
++-		{
+++		while ($row = $this->db->sql_fetchrow($result)) {
++ 			$form_data[] = $row;
++ 
++-			if ($row['type'] == 'file')
++-			{
+++			if ($row['type'] == 'file') {
++ 				$files[] = $row['name'];
++ 			}
++ 		}
++@@ -327,24 +316,19 @@ class listener implements EventSubscriberInterface
++ 
++ 		$fileupload = $this->files_factory->get('upload');
++ 
++-		foreach ($files as $name)
++-		{
+++		foreach ($files as $name) {
++ 			$temp = $fileupload->handle_upload('files.types.form', 'upload');
++ 
++-			if ($temp->get('realname'))
++-			{
+++			if ($temp->get('realname')) {
++ 				$names[] = $temp->get('realname');
++ 			}
++ 		}
++ 
++-		foreach ($form_data as $row)
++-		{
+++		foreach ($form_data as $row) {
++ 			$name = 'templatefield_' . $row['id'];
++ 
++-			if (isset($row['type']))
++-			{
++-				switch ($row['type'])
++-				{
+++			if (isset($row['type'])) {
+++				switch ($row['type']) {
++ 					case 'email':
++ 					case 'password':
++ 					case 'url':
++@@ -354,46 +338,48 @@ class listener implements EventSubscriberInterface
++ 					case 'time':
++ 						$value = $this->request->variable($name, '', true);
++ 						$appform_post .= $this->create_form_element($row, $value, $value);
++-					break;
+++						break;
++ 
++ 					case 'selectbox':
++ 					case 'radiobuttons':
++ 						$value = $this->request->variable($name, '', true);
++-						if ($value === '')
++-						{
+++						if ($row['mandatory'] && $value === '') {
++ 							$errors[] = $this->user->lang('ERROR_MANDATORY', $this->get_clean_name($row['name']));
++ 						}
++ 						$appform_post .= $this->create_form_element($row, $value, $value);
++-					break;
+++						break;
++ 
++ 					case 'checkbox':
++-						$value = $this->request->variable($name, [0 => ''] , true);
++-						if ($row['max_value'] && $row['min_value'] <= $row['max_value'] && (sizeof($value) < $row['min_value'] || sizeof($value) > $row['max_value']))
++-						{
+++						$value = $this->request->variable($name, [0 => ''], true);
+++						if ($row['min_value'] && $row['max_value'] && (count($value) < $row['min_value'] || count($value) > $row['max_value'])) {
++ 							$errors[] = $this->user->lang('ERROR_MIN_MAX_CHECKBOX', $row['min_value'], $row['max_value'], $this->get_clean_name($row['name']));
+++						} else if ($row['min_value'] && count($value) < $row['min_value']) {
+++							$errors[] = $this->user->lang('ERROR_MIN_CHECKBOX', $row['min_value'], $this->get_clean_name($row['name']));
+++						} else if ($row['max_value'] && count($value) > $row['max_value']) {
+++							$errors[] = $this->user->lang('ERROR_MAX_CHECKBOX', $row['max_value'], $this->get_clean_name($row['name']));
++ 						}
++-						$appform_post .= $this->create_form_element($row, $value, implode($value, $row['options_separator']));
++-					break;
+++
+++						$appform_post .= $this->create_form_element($row, $value, implode($row['options_separator'], $value));
+++						break;
++ 
++ 					case 'number':
++ 						$value = $this->request->variable($name, 0);
++ 						$appform_post .= $this->create_form_element($row, $value, $value);
++-					break;
+++						break;
++ 
++ 					case 'file':
++ 						$value = $this->request->variable($name, '', true);
++ 						$appform_post .= $this->create_form_element($row, $value, '[attachment=' . $file_count . ']' . $names[$file_count] . '[/attachment]' . $value, 'att');
++ 						$file_count++;
++-					break;
+++						break;
++ 
++ 					default:
++-					break;
+++						break;
++ 				}
++ 			}
++ 		}
++ 
++-		if ($errors)
++-		{
+++		if ($errors) {
++ 			throw new exception('', $errors);
++ 		}
++ 
++@@ -404,11 +390,9 @@ class listener implements EventSubscriberInterface
++ 	{
++ 		$content = '';
++ 
++-		if ($value)
++-		{
++-			if ($element['name_visible'])
++-			{
++-				if(!empty($element['name']))
+++		if ($value) {
+++			if ($element['name_visible']) {
+++				if (!empty($element['name']))
++ 					$content .= (ext::trim_once($element['name_before']) ?: '[form][b]') . $this->translate($this->get_clean_name($element['name'])) . (ext::trim_once($element['name_after']) ?: ':[/b][/form]');
++ 				else
++ 					$content .= (ext::trim_once($element['name_before']) ?: '[form][b]') . $this->translate($this->get_clean_name($element['name'])) . (ext::trim_once($element['name_after']) ?: '[/b][/form]');
++@@ -442,8 +426,9 @@ class listener implements EventSubscriberInterface
++ 
++ 		/** @var parser_interface $parser */
++ 		$parser = $phpbb_container->get('text_formatter.parser');
+++		$parser->disable_magic_url();
+++		$rendered = $renderer->render($parser->parse($text));
++ 
++-		return $renderer->render($parser->parse($text));
+++		return htmlspecialchars_decode($rendered);
++ 	}
++-
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/ext.php"
++index 3c5f001b9..2c49f2bb4 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/ext.php"
++@@ -27,11 +27,22 @@ class ext extends \phpbb\extension\base
++ 		return version_compare($config['version'], '3.2.0-a1', '>=');
++ 	}
++ 
++-	public static function explode(array $delimiters, $string)
+++	public static function explode($string)
++ 	{
++-		return preg_split('/[' . preg_quote(implode($delimiters)) . ']/', $string);
+++		$separators = ["\n\n", "\n"];
+++
+++		foreach ($separators as $separator)
+++		{
+++			if (strpos($string, $separator) !== false)
+++			{
+++				return explode($separator, $string);
+++			}
+++		}
+++
+++		return explode(',', $string);
++ 	}
++ 
+++
++ 	public static function trim_once($str)
++ 	{
++ 		if (utf8_strlen($str) < 2)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/en/common.php"
++index de8f463e9..8260e9b79 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/language/en/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/en/common.php"
++@@ -44,10 +44,19 @@ $lang = array_merge($lang, [
++ 	'FORM_MOD_PREVIEW'		 	=> 'Switch to preview keeping the current form data...',
++ 	'FORM_MOD_SUBMIT'			=> 'Add the form data to message and post...',
++ 	'OPEN_FORM_EXPLAIN'			=> 'Switch to Form Mode...',
+++	'OPEN_POST_EXPLAIN'			=> 'Switch to Post Mode...',
++ 	'REFRESHING_FORM'			=> 'The current selected Forum is',
++ 	'REQUIRED'				 	=> 'You have not entered all the required elements!',
++ 	'MANDATORY'					=> 'Items marked with the asterisk are mandatory.',
++ 
++ 	'ERROR_MANDATORY'			=> 'The field %s is mandatory.',
++ 	'ERROR_MIN_MAX_CHECKBOX'	=> 'You need to select between %d and %d items for %s.',
+++	'ERROR_MIN_CHECKBOX'		=> [
+++		1 => 'You need to select at least %d item for %s.',
+++		2 => 'You need to select at least %d items for %s.',
+++	],
+++	'ERROR_MAX_CHECKBOX'		=> [
+++		1 => 'You can select at most %d item for %s.',
+++		2 => 'You can select at most %d items for %s.',
+++	],
++ ]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/common.php"
++new file mode 100644
++index 000000000..9627e9ed6
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/common.php"
++@@ -0,0 +1,62 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Form Creator
+++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
+++}
+++
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+++//
+++// Placeholders can now contain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// translators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+++// equally where a string contains only two placeholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++//
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++//
+++
+++$lang = array_merge($lang, [
+++	'CLOSE_FORM'				=> 'Cancelar',
+++	'OPEN_FORM'					=> 'Modo Gerador Automático',
+++	'OPEN_POST'					=> 'Modo BBCode Manual',
+++	'FORM_MOD_PREVIEW'		 	=> 'Alternar para pré-visualizar e manter os dados do formulário actual...',
+++	'FORM_MOD_SUBMIT'			=> 'Converte e adiciona os dados do formulário à mensagem...',
+++	'OPEN_FORM_EXPLAIN'			=> 'Alterar para Gerador Automático...',
+++	'OPEN_POST_EXPLAIN'			=> 'Alterar para BBCode Manual...',
+++	'REFRESHING_FORM'			=> 'O fórum selecionado actualmente é',
+++	'REQUIRED'				 	=> 'Não preencheste todos os campos obrigatórios!',
+++	'MANDATORY'					=> 'Campos marcados com asterisco são de preenchimento obrigatório.',
+++
+++	'ERROR_MANDATORY'			=> 'O campo %s é obrigatório.',
+++	'ERROR_MIN_MAX_CHECKBOX'	=> 'Precisas de escolher pelo menos %d item e menos de %d itens para o campo %s.',
+++	'ERROR_MIN_CHECKBOX'		=> [
+++		1 => 'Precisas de escolher pelo menos %d item para o campo %s.',
+++		2 => 'Precisas de escolher pelo menos %d itens para o campo %s.',
+++	],
+++	'ERROR_MAX_CHECKBOX'		=> [
+++		1 => 'Podes escolher no máximo %d item para o campo %s.',
+++		2 => 'Podes escolher no máximo %d itens para o campo %s.',
+++	],
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/formcreator_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/formcreator_acp.php"
++new file mode 100644
++index 000000000..c807bc4c6
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/formcreator_acp.php"
++@@ -0,0 +1,185 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Form Creator
+++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
+++}
+++
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+++//
+++// Placeholders can now contain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// translators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+++// equally where a string contains only two placeholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++//
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++//
+++
+++$lang = array_merge($lang, [
+++	'MODE'						=> 'Mode',
+++	'ELEMENTS'					=> 'Elements',
+++	'FORM_NAME'					=> 'Forum Name',
+++	'FORUM_ID'					=> 'Forum ID',
+++	'ACP_FORM_CURRENT'		 	=> 'Update Current Form',
+++	'ACP_FORM_CREATOR'			=> 'Form Creator',
+++	'ACP_FORM_CREATOR_EXPLAIN'	=> 'With this tool you can create and manage forms for your forum.',
+++	'ACP_FORM_EXT_NOTE'			=> '<br><strong>Note:</strong> All actions are performed on the currently selected/displayed form, no confirm is implemented...',
+++
+++	'ACP_FORM_CREATOR_FAQ' => '<strong>How to begin?</strong><br>
+++									&nbsp; &bull; You just need to first select the forum where you will want to create the form.<br>
+++									<br>
+++									<strong>How can I do that?</strong><br>
+++									&nbsp; &bull; Just select a new forum from the <strong><i>Current Forum</i></strong> dropdown box...<br>
+++									<br>
+++									<strong>And now what?</strong><br>
+++									&nbsp; &bull; Next step would be to add new form elements<br>
+++									<br>
+++									<strong>How do I add a new form element?</strong><br> 
+++									&nbsp; &bull; Use <strong><i>Add a new form element</i></strong> at the bottom.<br>
+++									<br>
+++									<strong>After adding all the form elements I want, does it save automatically?</strong><br>
+++									&nbsp; &bull; Yes, when you add the form element it saves automatically on the current form, but if you make changes on the form elements on the <strong><i>Update Current Form</i></strong> then you\'ll need to click update so it can save the changes!<br>
+++									<br>
+++									<strong>Some fields don\'t make sense to my element type, will something bad happen if I fill those fields?</strong><br>
+++									&nbsp; &bull; Nothing bad will happen. You\'ll just put trash on the database. All that info will be discarded. That\'s why it\'s recommended to add an empty new form element and just then update it.<br>
+++									<br>
+++									<strong>How do I delete a form?</strong><br>
+++									&nbsp; &bull; Simply delete all form elements...<br>
+++									<br>
+++									<br>
+++									<strong>What is Name Before/After?</strong><br>
+++									&nbsp; &bull; Those fields accept BBCode, and whatever you write there will appear before and after the Entry Name on the final post, so you can customize the Entry Name.<br>
+++									<br>
+++									<strong>Can I see an example for Name Before/After fields?</strong><br>
+++									&nbsp; &bull; Sure. You can add <i>[b]</i> on the Before field and <i>[/b]</i> on the After field and if the Entry Name is <i>Title</i> then the post will be parsed into: <i>[b]Title[/b]</i><br>
+++									<br>
+++									<strong>What is Entry Name?</strong><br>
+++									&nbsp; &bull; Really? This is the question on the form field, the text before the input field, and that text may or may not be imported to the final post.<br>
+++									<br>
+++									<strong>What is Entry Explain?</strong><br>
+++									&nbsp; &bull; This is an optional field, if you fill it, it will appear below the Entry Name on the form, so you can insert a little explanation text. It supports BBCode and line break too.<br>
+++									<br>
+++									<strong>What is Hint?</strong><br>
+++									&nbsp; &bull; Hint is optional and is what appears inside the input fields, so you can provide an idea of what should be filled on the input box. Its good idea to use in some cases to avoid abusing the Entry Explain. For selectbox the hint will be the default first element.<br>
+++									<br>
+++									<strong>What is Options?</strong><br>
+++									&nbsp; &bull; It only works on some element types: selectbox, radiobuttons, checkbox and separator. With that said, it\'s a field where you\'ll insert the options for those element types.<br>
+++									<br>
+++									<strong>Can I see an example for Options fields? I am still confuse.</strong><br>
+++									&nbsp; &bull; Sure. You can add for example genres as: <i>Action, Adventure, Horror, Romance, Sci-Fi</i>, and the user will be able to just select the options, instead of writing.<br>
+++									<br>
+++									<strong>That makes sense for selectbox, radiobuttons and checkbox, but separator? What is it? </strong><br>
+++									&nbsp; &bull; Yes, that one is an exception. That field is only for form layout customization. A way to customize how the form itself will look like.<br>
+++									<br>
+++									<strong>Great! And do I always need to use a Comma to separate the words?</strong><br>
+++									&nbsp; &bull; You can use a comma or a line break and there is a hidden feature too. If you use "Administrator => Adm, Moderator => Mod, User => U", where the former one will appear on the form and the latter one on the post.<br>
+++									<br>
+++									<strong>What is Min/Max?</strong><br>
+++									&nbsp; &bull; This only works on Checkboxes since it\'s the only element type where you can select multiple items and with those fields you can require the user to choose between a min and max values. If you put Min: 1 and Max: 3, the user will need to choose at least one and less than 3 options.<br>
+++									<br>
+++									<strong>What is Value Before/After?</strong><br>
+++									&nbsp; &bull; It\'s similar to the <i>Name Before/After</i>. It accepts BBCode as well and will appear before and after the value that the user inserted.<br>
+++									<br>
+++									<strong>Can I still see an example for Value Before/After fields?</strong><br>
+++									&nbsp; &bull; Why not? You can add <i>[color=#ff0000]</i> on the Before field and <i>[/color]</i> on the After field and lets say the Entry Name is <i>Movie Title</i>. Then the user inserts on the form something as <i>Titanic</i> and when he submits, the post will be parsed into: <i>[color=#ff0000]Titanic[/color]</i><br>
+++									<br>
+++									<strong>Is there anything else that I should know?</strong><br>
+++									&nbsp; &bull; I\'m glad you asked! Some fields as Entry Name, Explain, Hint and Options are translatable. This means you can insert language variables {L_LANGUAGE_VARIABLE} so the form will be multilingual.<br>
+++									<br>
+++									<strong>WOW! Awesome! But where can I add the Language Variables?</strong><br>
+++									&nbsp; &bull; Just edit the root/ext/leinad4mind/formcreator/language/COUNTRY/common.php file and add new variables, so you can use at ACP afterwards.<br>
+++									<br>
+++									<strong>&#8730;</strong> The checkmark character indicates the item is mandatory and cannot be empty, so it will force the user to fill it.<br>
+++									<strong><i class="fa fa-eye" aria-hidden="true"></i></strong> The eye character indicates the entry name of that item will not be imported to the post submitted.<br>',
+++
+++	'CURRENT_FORUM'			 	=> 'Current Forum',
+++	'FORM_ADD_ITEM'				=> 'Add a new form element',
+++	'FORM_CHECKBOX'				=> 'Check Box',
+++	'FORM_DETAILS'			 	=> 'All forms use a generic template file: styles/YOUR_STYLE/template/forms/form_creator.html',
+++	'FORM_ELEMENT_TYPE'					=> 'Element type',
+++	'FORM_ELEMENT_HINT'					=> 'Hint',
+++	'FORM_ELEMENT_OPTIONS_SEPARATOR'	=> 'Options separator',
+++	'FORM_ELEMENT_NAME_VISIBLE'			=> 'Display/hide the element name on the final form.',
+++	'FORM_ELEMENT_NAME'					=> 'Entry Name',
+++	'FORM_ELEMENT_EXPLAIN'				=> 'Entry Explain',
+++	'FORM_ELEMENT_NAME_EXPLAIN'			=> 'Entry Name/Explain',
+++	'FORM_ELEMENT_OPTIONS'				=> 'Options',
+++	'FORM_ELEMENT_MIN_MAX'				=> 'Min/Max',
+++	'FORM_ELEMENT_MIN'					=> 'Min',
+++	'FORM_ELEMENT_MAX'					=> 'Max',
+++	'FORM_ELEMENT_NAME_BEFORE_AFTER'	=> 'Name before/after',
+++	'FORM_ELEMENT_VALUE_BEFORE_AFTER'	=> 'Value before/after',
+++	'FORM_EMAILBOX'				=> 'Email',
+++	'FORM_INPUTBOX'				=> 'Text',
+++	'FORM_CREATOR_ACP_RETURN'	=> 'Back to manage forms',
+++	'FORM_MANAGE'				=> 'Manage this form',
+++	'FORM_MANAGE_EXPLAIN'		=> 'Here you can modify all of the current form elements, simply edit fields and press the <strong>Update</strong> button...',
+++
+++	'FORM_NEW_ITEM_EXPLAIN'		=> '<pre style="font-size:11px; line-height: 100%;"><strong><u>Form Elements Supported</u></strong><br>
+++									<strong>Inputbox:</strong>		Up to 255 characters<br>
+++									<strong>Textbox:</strong>	 	Multiple lines of text arranged as 3 rows by 76 columns.<br>
+++									<strong>Checkbox:</strong>		One or more options can be selected.<br>
+++									<strong>Radiobutton:</strong> 		Only one option can be selected.<br>
+++									<strong>Selectbox:</strong>		One option from a dropdown list.<br>
+++									<strong>Email:</strong>			Valid email address.<br>
+++									<strong>Password:</strong>		For test purposes only...<br>
+++									<strong>URL:</strong>			A valid URL must be entered.<br>
+++									<strong>Attachment:</strong>		Add a file to the attachment system.<br>
+++									<strong>Number:</strong>			Only numbers 0-9 are allowed.<br>
+++									<strong>Date:</strong>			Opens a date picker.<br>
+++									<strong>Time:</strong>			Opens a time picker.<br>
+++									<strong>Separator:</strong>			Only for form layout customization.<br>
+++									<br></pre>',
+++
+++	'FORM_NO_FORM'			 	=> 'There are no forms assigned to: <strong>%s</strong>...<br>To add a new form to this forum, simply add a form element below...',
+++	'FORM_RADIOBOX'				=> 'Radio Buttons',
+++	'FORM_PASSWORDBOX'			=> 'Password',
+++	'FORM_SELECTBOX'			=> 'Select Box',
+++	'FORM_TXTBOX'				=> 'Text Box',
+++	'FORM_URLBOX'				=> 'URL',
+++	'FORM_ATTACH'				=> 'Attachment',
+++	'FORM_NUMBER'				=> 'Number',
+++	'FORM_DATE'					=> 'Date',
+++	'FORM_TIME'					=> 'Time',
+++	'FORM_SEPARATOR'			=> 'Separator',
+++	'HIDE_FORM_INFO'			=> 'Hide info',
+++	'HIDE_PREVIEW'			 	=> 'Hide Preview',
+++	'HIDE_COPY'				 	=> 'Hide copy form',
+++	'HOW_TO'					=> '<strong>Additional Help...</strong>',
+++	'HOW_TO_MORE'				=> 'More info...',
+++	'HOW_TO_HIDE'				=> '<strong>Hide</strong>',
+++	'NDX'						=> 'NDX',
+++	'NDX_ORDER'					=> 'Index order (the order in which items appear on the form)',
+++	'FORMS_MOD_SAMPLE'		 	=> 'Rendering the current form to assist visualization only... not a working form.',
+++	'SHOW_FORM_INFO'			=> 'More info on Element types',
+++	'SHOW_PREVIEW'			 	=> 'Preview the form',
+++	'SHOW_COPY'					=> 'Copy form',
+++	'COPY_FORM'					=> 'Copy form to selected forums',
+++	'COPY_FORM_EXPLAIN'			=> 'This will delete all existing form elements in the selected destination forums!',
+++	'COPY_FORM_SUCCESS'			=> 'The form elements have been copied to all selected forums.',
+++
+++	'SHOW_FORM_DEFAULT'			=> 'Show form by default',
+++	'FORCE_FORM'				=> 'Force form',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/info_acp_formcreator.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/info_acp_formcreator.php"
++new file mode 100644
++index 000000000..bd37f0bb1
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/info_acp_formcreator.php"
++@@ -0,0 +1,43 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Form Creator
+++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
+++}
+++
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+++//
+++// Placeholders can now contain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// translators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+++// equally where a string contains only two placeholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++//
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++//
+++
+++$lang = array_merge($lang, [
+++	'ACP_FORM_CREATOR'				=> 'Form Creator',
+++	'ACP_FORM_CREATOR_CONFIG'	 	=> 'Configuration',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/permissions_formcreator.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/permissions_formcreator.php"
++new file mode 100644
++index 000000000..e1d24693c
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt/permissions_formcreator.php"
++@@ -0,0 +1,42 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Form Creator
+++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
+++}
+++
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+++//
+++// Placeholders can now contain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// translators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+++// equally where a string contains only two placeholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++//
+++// Some characters for use
+++// ’ » “ ” …
+++
+++$lang = array_merge($lang, [
+++	'ACL_A_FORM_CREATOR'		=> 'Can manage Form Creator',
+++	'ACL_F_FORM_CREATOR'		=> 'Can use Form Creator',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/common.php"
++new file mode 100644
++index 000000000..9627e9ed6
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/common.php"
++@@ -0,0 +1,62 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Form Creator
+++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
+++}
+++
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+++//
+++// Placeholders can now contain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// translators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+++// equally where a string contains only two placeholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++//
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++//
+++
+++$lang = array_merge($lang, [
+++	'CLOSE_FORM'				=> 'Cancelar',
+++	'OPEN_FORM'					=> 'Modo Gerador Automático',
+++	'OPEN_POST'					=> 'Modo BBCode Manual',
+++	'FORM_MOD_PREVIEW'		 	=> 'Alternar para pré-visualizar e manter os dados do formulário actual...',
+++	'FORM_MOD_SUBMIT'			=> 'Converte e adiciona os dados do formulário à mensagem...',
+++	'OPEN_FORM_EXPLAIN'			=> 'Alterar para Gerador Automático...',
+++	'OPEN_POST_EXPLAIN'			=> 'Alterar para BBCode Manual...',
+++	'REFRESHING_FORM'			=> 'O fórum selecionado actualmente é',
+++	'REQUIRED'				 	=> 'Não preencheste todos os campos obrigatórios!',
+++	'MANDATORY'					=> 'Campos marcados com asterisco são de preenchimento obrigatório.',
+++
+++	'ERROR_MANDATORY'			=> 'O campo %s é obrigatório.',
+++	'ERROR_MIN_MAX_CHECKBOX'	=> 'Precisas de escolher pelo menos %d item e menos de %d itens para o campo %s.',
+++	'ERROR_MIN_CHECKBOX'		=> [
+++		1 => 'Precisas de escolher pelo menos %d item para o campo %s.',
+++		2 => 'Precisas de escolher pelo menos %d itens para o campo %s.',
+++	],
+++	'ERROR_MAX_CHECKBOX'		=> [
+++		1 => 'Podes escolher no máximo %d item para o campo %s.',
+++		2 => 'Podes escolher no máximo %d itens para o campo %s.',
+++	],
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/formcreator_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/formcreator_acp.php"
++new file mode 100644
++index 000000000..c807bc4c6
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/formcreator_acp.php"
++@@ -0,0 +1,185 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Form Creator
+++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
+++}
+++
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+++//
+++// Placeholders can now contain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// translators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+++// equally where a string contains only two placeholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++//
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++//
+++
+++$lang = array_merge($lang, [
+++	'MODE'						=> 'Mode',
+++	'ELEMENTS'					=> 'Elements',
+++	'FORM_NAME'					=> 'Forum Name',
+++	'FORUM_ID'					=> 'Forum ID',
+++	'ACP_FORM_CURRENT'		 	=> 'Update Current Form',
+++	'ACP_FORM_CREATOR'			=> 'Form Creator',
+++	'ACP_FORM_CREATOR_EXPLAIN'	=> 'With this tool you can create and manage forms for your forum.',
+++	'ACP_FORM_EXT_NOTE'			=> '<br><strong>Note:</strong> All actions are performed on the currently selected/displayed form, no confirm is implemented...',
+++
+++	'ACP_FORM_CREATOR_FAQ' => '<strong>How to begin?</strong><br>
+++									&nbsp; &bull; You just need to first select the forum where you will want to create the form.<br>
+++									<br>
+++									<strong>How can I do that?</strong><br>
+++									&nbsp; &bull; Just select a new forum from the <strong><i>Current Forum</i></strong> dropdown box...<br>
+++									<br>
+++									<strong>And now what?</strong><br>
+++									&nbsp; &bull; Next step would be to add new form elements<br>
+++									<br>
+++									<strong>How do I add a new form element?</strong><br> 
+++									&nbsp; &bull; Use <strong><i>Add a new form element</i></strong> at the bottom.<br>
+++									<br>
+++									<strong>After adding all the form elements I want, does it save automatically?</strong><br>
+++									&nbsp; &bull; Yes, when you add the form element it saves automatically on the current form, but if you make changes on the form elements on the <strong><i>Update Current Form</i></strong> then you\'ll need to click update so it can save the changes!<br>
+++									<br>
+++									<strong>Some fields don\'t make sense to my element type, will something bad happen if I fill those fields?</strong><br>
+++									&nbsp; &bull; Nothing bad will happen. You\'ll just put trash on the database. All that info will be discarded. That\'s why it\'s recommended to add an empty new form element and just then update it.<br>
+++									<br>
+++									<strong>How do I delete a form?</strong><br>
+++									&nbsp; &bull; Simply delete all form elements...<br>
+++									<br>
+++									<br>
+++									<strong>What is Name Before/After?</strong><br>
+++									&nbsp; &bull; Those fields accept BBCode, and whatever you write there will appear before and after the Entry Name on the final post, so you can customize the Entry Name.<br>
+++									<br>
+++									<strong>Can I see an example for Name Before/After fields?</strong><br>
+++									&nbsp; &bull; Sure. You can add <i>[b]</i> on the Before field and <i>[/b]</i> on the After field and if the Entry Name is <i>Title</i> then the post will be parsed into: <i>[b]Title[/b]</i><br>
+++									<br>
+++									<strong>What is Entry Name?</strong><br>
+++									&nbsp; &bull; Really? This is the question on the form field, the text before the input field, and that text may or may not be imported to the final post.<br>
+++									<br>
+++									<strong>What is Entry Explain?</strong><br>
+++									&nbsp; &bull; This is an optional field, if you fill it, it will appear below the Entry Name on the form, so you can insert a little explanation text. It supports BBCode and line break too.<br>
+++									<br>
+++									<strong>What is Hint?</strong><br>
+++									&nbsp; &bull; Hint is optional and is what appears inside the input fields, so you can provide an idea of what should be filled on the input box. Its good idea to use in some cases to avoid abusing the Entry Explain. For selectbox the hint will be the default first element.<br>
+++									<br>
+++									<strong>What is Options?</strong><br>
+++									&nbsp; &bull; It only works on some element types: selectbox, radiobuttons, checkbox and separator. With that said, it\'s a field where you\'ll insert the options for those element types.<br>
+++									<br>
+++									<strong>Can I see an example for Options fields? I am still confuse.</strong><br>
+++									&nbsp; &bull; Sure. You can add for example genres as: <i>Action, Adventure, Horror, Romance, Sci-Fi</i>, and the user will be able to just select the options, instead of writing.<br>
+++									<br>
+++									<strong>That makes sense for selectbox, radiobuttons and checkbox, but separator? What is it? </strong><br>
+++									&nbsp; &bull; Yes, that one is an exception. That field is only for form layout customization. A way to customize how the form itself will look like.<br>
+++									<br>
+++									<strong>Great! And do I always need to use a Comma to separate the words?</strong><br>
+++									&nbsp; &bull; You can use a comma or a line break and there is a hidden feature too. If you use "Administrator => Adm, Moderator => Mod, User => U", where the former one will appear on the form and the latter one on the post.<br>
+++									<br>
+++									<strong>What is Min/Max?</strong><br>
+++									&nbsp; &bull; This only works on Checkboxes since it\'s the only element type where you can select multiple items and with those fields you can require the user to choose between a min and max values. If you put Min: 1 and Max: 3, the user will need to choose at least one and less than 3 options.<br>
+++									<br>
+++									<strong>What is Value Before/After?</strong><br>
+++									&nbsp; &bull; It\'s similar to the <i>Name Before/After</i>. It accepts BBCode as well and will appear before and after the value that the user inserted.<br>
+++									<br>
+++									<strong>Can I still see an example for Value Before/After fields?</strong><br>
+++									&nbsp; &bull; Why not? You can add <i>[color=#ff0000]</i> on the Before field and <i>[/color]</i> on the After field and lets say the Entry Name is <i>Movie Title</i>. Then the user inserts on the form something as <i>Titanic</i> and when he submits, the post will be parsed into: <i>[color=#ff0000]Titanic[/color]</i><br>
+++									<br>
+++									<strong>Is there anything else that I should know?</strong><br>
+++									&nbsp; &bull; I\'m glad you asked! Some fields as Entry Name, Explain, Hint and Options are translatable. This means you can insert language variables {L_LANGUAGE_VARIABLE} so the form will be multilingual.<br>
+++									<br>
+++									<strong>WOW! Awesome! But where can I add the Language Variables?</strong><br>
+++									&nbsp; &bull; Just edit the root/ext/leinad4mind/formcreator/language/COUNTRY/common.php file and add new variables, so you can use at ACP afterwards.<br>
+++									<br>
+++									<strong>&#8730;</strong> The checkmark character indicates the item is mandatory and cannot be empty, so it will force the user to fill it.<br>
+++									<strong><i class="fa fa-eye" aria-hidden="true"></i></strong> The eye character indicates the entry name of that item will not be imported to the post submitted.<br>',
+++
+++	'CURRENT_FORUM'			 	=> 'Current Forum',
+++	'FORM_ADD_ITEM'				=> 'Add a new form element',
+++	'FORM_CHECKBOX'				=> 'Check Box',
+++	'FORM_DETAILS'			 	=> 'All forms use a generic template file: styles/YOUR_STYLE/template/forms/form_creator.html',
+++	'FORM_ELEMENT_TYPE'					=> 'Element type',
+++	'FORM_ELEMENT_HINT'					=> 'Hint',
+++	'FORM_ELEMENT_OPTIONS_SEPARATOR'	=> 'Options separator',
+++	'FORM_ELEMENT_NAME_VISIBLE'			=> 'Display/hide the element name on the final form.',
+++	'FORM_ELEMENT_NAME'					=> 'Entry Name',
+++	'FORM_ELEMENT_EXPLAIN'				=> 'Entry Explain',
+++	'FORM_ELEMENT_NAME_EXPLAIN'			=> 'Entry Name/Explain',
+++	'FORM_ELEMENT_OPTIONS'				=> 'Options',
+++	'FORM_ELEMENT_MIN_MAX'				=> 'Min/Max',
+++	'FORM_ELEMENT_MIN'					=> 'Min',
+++	'FORM_ELEMENT_MAX'					=> 'Max',
+++	'FORM_ELEMENT_NAME_BEFORE_AFTER'	=> 'Name before/after',
+++	'FORM_ELEMENT_VALUE_BEFORE_AFTER'	=> 'Value before/after',
+++	'FORM_EMAILBOX'				=> 'Email',
+++	'FORM_INPUTBOX'				=> 'Text',
+++	'FORM_CREATOR_ACP_RETURN'	=> 'Back to manage forms',
+++	'FORM_MANAGE'				=> 'Manage this form',
+++	'FORM_MANAGE_EXPLAIN'		=> 'Here you can modify all of the current form elements, simply edit fields and press the <strong>Update</strong> button...',
+++
+++	'FORM_NEW_ITEM_EXPLAIN'		=> '<pre style="font-size:11px; line-height: 100%;"><strong><u>Form Elements Supported</u></strong><br>
+++									<strong>Inputbox:</strong>		Up to 255 characters<br>
+++									<strong>Textbox:</strong>	 	Multiple lines of text arranged as 3 rows by 76 columns.<br>
+++									<strong>Checkbox:</strong>		One or more options can be selected.<br>
+++									<strong>Radiobutton:</strong> 		Only one option can be selected.<br>
+++									<strong>Selectbox:</strong>		One option from a dropdown list.<br>
+++									<strong>Email:</strong>			Valid email address.<br>
+++									<strong>Password:</strong>		For test purposes only...<br>
+++									<strong>URL:</strong>			A valid URL must be entered.<br>
+++									<strong>Attachment:</strong>		Add a file to the attachment system.<br>
+++									<strong>Number:</strong>			Only numbers 0-9 are allowed.<br>
+++									<strong>Date:</strong>			Opens a date picker.<br>
+++									<strong>Time:</strong>			Opens a time picker.<br>
+++									<strong>Separator:</strong>			Only for form layout customization.<br>
+++									<br></pre>',
+++
+++	'FORM_NO_FORM'			 	=> 'There are no forms assigned to: <strong>%s</strong>...<br>To add a new form to this forum, simply add a form element below...',
+++	'FORM_RADIOBOX'				=> 'Radio Buttons',
+++	'FORM_PASSWORDBOX'			=> 'Password',
+++	'FORM_SELECTBOX'			=> 'Select Box',
+++	'FORM_TXTBOX'				=> 'Text Box',
+++	'FORM_URLBOX'				=> 'URL',
+++	'FORM_ATTACH'				=> 'Attachment',
+++	'FORM_NUMBER'				=> 'Number',
+++	'FORM_DATE'					=> 'Date',
+++	'FORM_TIME'					=> 'Time',
+++	'FORM_SEPARATOR'			=> 'Separator',
+++	'HIDE_FORM_INFO'			=> 'Hide info',
+++	'HIDE_PREVIEW'			 	=> 'Hide Preview',
+++	'HIDE_COPY'				 	=> 'Hide copy form',
+++	'HOW_TO'					=> '<strong>Additional Help...</strong>',
+++	'HOW_TO_MORE'				=> 'More info...',
+++	'HOW_TO_HIDE'				=> '<strong>Hide</strong>',
+++	'NDX'						=> 'NDX',
+++	'NDX_ORDER'					=> 'Index order (the order in which items appear on the form)',
+++	'FORMS_MOD_SAMPLE'		 	=> 'Rendering the current form to assist visualization only... not a working form.',
+++	'SHOW_FORM_INFO'			=> 'More info on Element types',
+++	'SHOW_PREVIEW'			 	=> 'Preview the form',
+++	'SHOW_COPY'					=> 'Copy form',
+++	'COPY_FORM'					=> 'Copy form to selected forums',
+++	'COPY_FORM_EXPLAIN'			=> 'This will delete all existing form elements in the selected destination forums!',
+++	'COPY_FORM_SUCCESS'			=> 'The form elements have been copied to all selected forums.',
+++
+++	'SHOW_FORM_DEFAULT'			=> 'Show form by default',
+++	'FORCE_FORM'				=> 'Force form',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/info_acp_formcreator.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/info_acp_formcreator.php"
++new file mode 100644
++index 000000000..bd37f0bb1
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/info_acp_formcreator.php"
++@@ -0,0 +1,43 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Form Creator
+++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
+++}
+++
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+++//
+++// Placeholders can now contain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// translators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+++// equally where a string contains only two placeholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++//
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++//
+++
+++$lang = array_merge($lang, [
+++	'ACP_FORM_CREATOR'				=> 'Form Creator',
+++	'ACP_FORM_CREATOR_CONFIG'	 	=> 'Configuration',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/permissions_formcreator.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/permissions_formcreator.php"
++new file mode 100644
++index 000000000..e1d24693c
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/language/pt_preao/permissions_formcreator.php"
++@@ -0,0 +1,42 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Form Creator
+++* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+++* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
+++}
+++
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+++//
+++// Placeholders can now contain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// translators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+++// equally where a string contains only two placeholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++//
+++// Some characters for use
+++// ’ » “ ” …
+++
+++$lang = array_merge($lang, [
+++	'ACL_A_FORM_CREATOR'		=> 'Can manage Form Creator',
+++	'ACL_F_FORM_CREATOR'		=> 'Can use Form Creator',
+++]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/BBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/BBOOTS/template/event/overall_header_head_append.html"
++index edc55a40c..028dacf2e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/BBOOTS/template/event/overall_header_head_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/BBOOTS/template/event/overall_header_head_append.html"
++@@ -1,3 +1,3 @@
++-{% if SCRIPT_NAME eq 'viewtopic' or SCRIPT_NAME eq 'search' %}
+++{% if SCRIPT_NAME in ['viewtopic', 'search'] %}
++ 	{% INCLUDECSS '@leinad4mind_formcreator/formcreator.css' %}
++ {% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++index edc55a40c..028dacf2e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++@@ -1,3 +1,3 @@
++-{% if SCRIPT_NAME eq 'viewtopic' or SCRIPT_NAME eq 'search' %}
+++{% if SCRIPT_NAME in ['viewtopic', 'search'] %}
++ 	{% INCLUDECSS '@leinad4mind_formcreator/formcreator.css' %}
++ {% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_message_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_message_append.html"
++index 6e26a78b4..0d1275234 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_message_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_message_append.html"
++@@ -3,13 +3,13 @@
++ 	<div class="inner">
++ 		<div class="space10"></div>
++ 		<fieldset class="submit-buttons form-buttons">
++-			{{ S_HIDDEN_ADDRESS_FIELD }}
++-			{{ S_HIDDEN_FIELDS }}
+++			{S_HIDDEN_ADDRESS_FIELD}
+++			{S_HIDDEN_FIELDS}
++ 			{% EVENT posting_editor_submit_buttons %}
++-			{% if S_HAS_DRAFTS %}<input type="submit" accesskey="d" tabindex="8" name="load" value="{{ lang('LOAD_DRAFT') }}" class="btn btn-default" onclick="load_draft = true;">&nbsp; {% endif %}
++-			{% if S_SAVE_ALLOWED %}<input type="submit" accesskey="k" tabindex="7" name="save" value="{{ lang('SAVE_DRAFT') }}" class="btn btn-default">&nbsp; {% endif %}
++-			<input type="submit" tabindex="5" name="preview" value="{{ lang('PREVIEW') }}" class="btn btn-default"{% if not S_PRIVMSGS %} onclick="document.getElementById('postform').action += '#preview';"{% endif %}>&nbsp;
++-			<input type="submit" accesskey="s" tabindex="6" name="post" value="{{ lang('SUBMIT') }}" class="btn btn-default default-submit-action">&nbsp;
+++			{% if S_HAS_DRAFTS %}<button type="submit" class="btn btn-default" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>" accesskey="d" tabindex="8" name="load" value="{{ lang('LOAD_DRAFT') }}" onclick="load_draft = true;"><span class="hidden-xs">{{ lang('LOAD_DRAFT') }}</span><i class="visible-xs fa fa-upload fa-btn-fx"></i></button>{% endif %}
+++			{% if S_SAVE_ALLOWED %}<button type="submit" class="btn btn-default" data-loading-text="{{ lang('SAVING') }}&nbsp;<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>" accesskey="k" tabindex="7" name="save" value="{{ lang('SAVE_DRAFT') }}"><span class="hidden-xs">{{ lang('SAVE_DRAFT') }}</span><i class="visible-xs fa fa-floppy-o fa-btn-fx"></i></button>{% endif %}
+++			<button type="submit" class="btn btn-default" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>" tabindex="5" name="preview" value="{{ lang('PREVIEW') }}"{% if not S_PRIVMSGS %} onclick="enable_form_preview(); document.getElementById('postform').action += '#preview';"{% endif %} >{{ lang('PREVIEW') }}</button>
+++			<button type="submit" class="btn btn-default" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>" accesskey="s" tabindex="6" name="post" value="{{ lang('SUBMIT') }}">{{ lang('SUBMIT') }}</button>
++ 		</fieldset>
++ 		<div class="space10"></div>
++ 	</div>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_subject_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
++index 250ebc23c..574801062 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
++@@ -8,7 +8,7 @@
++ {% if not S_FORCE_FORM %}
++ 	{% if MODE == 'post' %}
++ 		<div class="space10"></div>
++-		<button type="button" class="btn btn-default" accesskey="f" name="useform" onclick="toggle_validation(); switch_mode(this);" title="{{ lang('OPEN_FORM_EXPLAIN') }}">{{ lang(S_SHOW_FORM or S_FORCE_FORM ? 'OPEN_POST' : 'OPEN_FORM') }}</button>
+++		<button type="button" class="btn btn-default" accesskey="f" name="useform" onclick="toggle_validation(); switch_mode(this);" title="{{ lang(S_SHOW_FORM ? 'OPEN_FORM_EXPLAIN' : 'OPEN_POST_EXPLAIN') }}">{{ lang(S_SHOW_FORM ? 'OPEN_POST' : 'OPEN_FORM') }}</button>
++ 	{% endif %}
++ {% endif %}
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_creator.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_creator.html"
++index 49ed2e63d..4cfedd757 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_creator.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_creator.html"
++@@ -22,7 +22,7 @@
++ 				{% else %}
++ 					<dl>
++ 						<dt>
++-							{% if form_creator_template.NAME_RICH %}<label for="{{ form_creator_template.CLEAN_NAME }}">{{ form_creator_template.NAME_RICH ~ lang('COLON') }}</label>{% endif %}{{ form_creator_template.MANDATORY }}
+++							{% if form_creator_template.NAME_RICH %}<label for="{{ form_creator_template.CLEAN_NAME }}">{{ form_creator_template.NAME_RICH }}</label>{% endif %}{{ form_creator_template.MANDATORY }}
++ 							{% if form_creator_template.EXPLAIN %}
++ 								<br><span class="small">{{ form_creator_template.EXPLAIN }}</span>
++ 							{% endif %}
++@@ -36,7 +36,7 @@
++ 	<div class="panels">
++ 		<div class="inner">
++ 			<fieldset class="submit-buttons form-buttons">
++-				{{ S_FORM_TOKEN }}
+++				{S_FORM_TOKEN}
++ 				<input type="reset" name="reset" value="{{ lang('RESET') }}" class="btn btn-default">&nbsp;
++ 				<input type="submit" tabindex="5" name="preview" value="{{ lang('PREVIEW') }}" class="btn btn-default" onclick="enable_form_preview(); document.getElementById('postform').action += '#preview';">&nbsp;
++ 				<input type="submit" accesskey="s" tabindex="6" name="post" value="{{ lang('SUBMIT') }}" class="btn btn-default default-submit-action" onclick="enable_form_preview();">
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_mod.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_mod.js"
++index 83d793167..53258fd55 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_mod.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_mod.js"
++@@ -31,6 +31,11 @@ function is_hidden(id)
++ function toggle_validation()
++ {
++ 	document.forms.postform.noValidate = !is_hidden('thisform');
+++	if(!document.forms.postform.noValidate) {
+++		$('#postform').attr('novalidate', true);
+++		return;
+++	}
+++	$('#postform').removeAttr('novalidate');
++ }
++ 
++ function enable_form_preview()
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\formcreator/styles/prosilver/template/eve
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\formcreator/event/listener.php" "[FORUM_EXT]/leinad4mind\\formcreator/event/listener.php"
--- "[ORIGINAL]/leinad4mind\\formcreator/event/listener.php"
+++ "[FORUM_EXT]/leinad4mind\\formcreator/event/listener.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
  *
  * @package phpBB Extension - Form Creator
@@ -84,8 +85,7 @@ class listener implements EventSubscriberInterface
 		$php_ext,
 		$table_formcreator,
 		\phpbb\files\factory $files_factory
-	)
-	{
+	) {
 		$this->user					= $user;
 		$this->template				= $template;
 		$this->db					= $db;
@@ -135,12 +135,10 @@ class listener implements EventSubscriberInterface
 
 	public function modify_message_text($event)
 	{
-		if ($this->can_use_form($event))
-		{
+		if ($this->can_use_form($event)) {
 			$message = $this->request->variable('message', '', true);
 
-			if ($message === '' || $this->request->is_set_post('form_creator_preview'))
-			{
+			if ($message === '' || $this->request->is_set_post('form_creator_preview')) {
 				$mode 			= $event['mode'];
 				$forum_id 		= $event['forum_id'];
 				$submit 		= $event['submit'];
@@ -149,19 +147,15 @@ class listener implements EventSubscriberInterface
 				$message_parser = $event['message_parser'];
 				$files 			= $this->request->get_super_global(\phpbb\request\request::FILES);
 
-				try
-				{
+				try {
 					$message = $this->grab_form_data($forum_id);
 
-					foreach ($files as $key => $name)
-					{
+					foreach ($files as $key => $name) {
 						$message_parser->parse_attachments($key, $mode, $forum_id, $submit, $preview, $refresh);
 					}
 
 					$message_parser->message = $message;
-				}
-				catch (exception $e)
-				{
+				} catch (exception $e) {
 					$event['error'] = array_merge($event['error'], $e->get_parameters());
 				}
 			}
@@ -170,8 +164,7 @@ class listener implements EventSubscriberInterface
 
 	public function posting_modify_template_vars($event)
 	{
-		if ($this->can_use_form($event))
-		{
+		if ($this->can_use_form($event)) {
 			$this->build_form($event['forum_id'], $event['mode']);
 		}
 	}
@@ -185,8 +178,7 @@ class listener implements EventSubscriberInterface
 			ORDER BY ndx_order ASC';
 		$result = $this->db->sql_query($sql);
 
-		while ($row = $this->db->sql_fetchrow($result))
-		{
+		while ($row = $this->db->sql_fetchrow($result)) {
 			$entry 			= '';
 			$clean_name 	= 'templatefield_' . $row['id'];
 
@@ -203,8 +195,7 @@ class listener implements EventSubscriberInterface
 			$cols			= ' rows="3"';
 			$rows			= ' cols="76"';
 
-			switch (strtolower($row['type']))
-			{
+			switch (strtolower($row['type'])) {
 				case 'email':
 				case 'password':
 				case 'url':
@@ -230,44 +221,44 @@ class listener implements EventSubscriberInterface
 					$entry = '<div class="row"><div class="col-xs-12 col-lg-8"><select' . $type . $name . $id . $tabindex . $mandatory . $class . '>';
 					if (empty($row['hint'])) {
 						$entry .= '<option value="">----------------</option>';
-					}
-					else {
+					} else {
 						$entry .= '<option value="">' . $row['hint'] . '</option>';
 					}
-					$select_option = ext::explode([',', "\n"], $row['options']);
+					$select_option = ext::explode($row['options']);
 					$select_option = array_map('trim', $select_option);
-					$selected = $this->request->variable($clean_name, '');
-					foreach ($select_option as $value)
-					{
+					$selected = $this->request->variable($clean_name, '', true);
+					foreach ($select_option as $value) {
 						list($form_value, $output_value) = ext::split($value);
 						$form_value = $this->translate($form_value);
 						$output_value = $this->translate($output_value);
-					 	$entry .= '<option value="' . $output_value . '"' . ($output_value == $selected ? ' selected' : '') . '>' . $form_value . '</option>';
+						//$entry .= '<option value="' . $output_value . '"' . ($output_value == $selected ? ' selected' : '') . '>' . $form_value . '</option>';
+						$entry .= '<option value="' . $output_value . '"' . (trim($output_value) == $selected ? ' selected' : '') . '>' . $form_value . '</option>';
 					}
 					$entry .= '</select></div></div>';
 					break;
 
 				case 'radiobuttons':
-					$radio_option = ext::explode([',', "\n"], $row['options']);
+					$radio_option = ext::explode($row['options']);
 					$radio_option = array_map('trim', $radio_option);
-					$checked = $this->request->variable($clean_name, '');
-					foreach ($radio_option as $value)
-					{
+					$checked = $this->request->variable($clean_name, '', true);
+					foreach ($radio_option as $value) {
 						list($form_value, $output_value) = ext::split($value);
-						$form_value = $this->translate($form_value);
+						//$form_value = $this->translate($form_value);
+						$form_value = $this->render($this->translate($form_value));
 						$output_value = $this->translate($output_value);
-						$entry .= '<label><input type="radio"' . $tabindex . $mandatory . $name . $id . ' value="' . $output_value . '"' . ($output_value == $checked ? ' checked' : '') . '>&nbsp;' . $form_value . '&nbsp;&nbsp;</label>';
+						$entry .= '<label><input type="radio"' . $tabindex . $mandatory . $name . $id . ' value="' . $output_value . '"' . (trim($output_value) == $checked ? ' checked' : '') . '>&nbsp;' . $form_value . '&nbsp;&nbsp;</label>';
 					}
 					break;
 
 				case 'checkbox':
-					$check_option = ext::explode([',', "\n"], $row['options']);
+					$check_option = ext::explode($row['options']);
 					$check_option = array_map('trim', $check_option);
-					$checked = $this->request->variable($clean_name, [0 => '']);
-					foreach ($check_option as $value)
-					{
+					$checked = $this->request->variable($clean_name, [0 => ''], true);
+					foreach ($check_option as $value) {
 						list($form_value, $output_value) = ext::split($value);
-						$entry .= '<label><input' . $type . $tabindex . $name_array . $id . ' value="' . $output_value . '"' . (in_array($output_value, $checked) ? ' checked' : '') . '>&nbsp;' . $form_value . '&nbsp;&nbsp;</label>';
+						$form_value = $this->render($this->translate($form_value));
+						$output_value = $this->translate($output_value);
+						$entry .= '<label><input' . $type . $tabindex . $name_array . $id . ' value="' . $output_value . '"' . (in_array(trim($output_value), $checked) ? ' checked' : '') . '>&nbsp;' . $form_value . '&nbsp;&nbsp;</label>';
 					}
 					$row['mandatory'] = (bool) $row['min_value'];
 					break;
@@ -314,12 +305,10 @@ class listener implements EventSubscriberInterface
 			ORDER BY ndx_order ASC';
 		$result = $this->db->sql_query($sql);
 
-		while ($row = $this->db->sql_fetchrow($result))
-		{
+		while ($row = $this->db->sql_fetchrow($result)) {
 			$form_data[] = $row;
 
-			if ($row['type'] == 'file')
-			{
+			if ($row['type'] == 'file') {
 				$files[] = $row['name'];
 			}
 		}
@@ -327,24 +316,19 @@ class listener implements EventSubscriberInterface
 
 		$fileupload = $this->files_factory->get('upload');
 
-		foreach ($files as $name)
-		{
+		foreach ($files as $name) {
 			$temp = $fileupload->handle_upload('files.types.form', 'upload');
 
-			if ($temp->get('realname'))
-			{
+			if ($temp->get('realname')) {
 				$names[] = $temp->get('realname');
 			}
 		}
 
-		foreach ($form_data as $row)
-		{
+		foreach ($form_data as $row) {
 			$name = 'templatefield_' . $row['id'];
 
-			if (isset($row['type']))
-			{
-				switch ($row['type'])
-				{
+			if (isset($row['type'])) {
+				switch ($row['type']) {
 					case 'email':
 					case 'password':
 					case 'url':
@@ -359,8 +343,7 @@ class listener implements EventSubscriberInterface
 					case 'selectbox':
 					case 'radiobuttons':
 						$value = $this->request->variable($name, '', true);
-						if ($value === '')
-						{
+						if ($row['mandatory'] && $value === '') {
 							$errors[] = $this->user->lang('ERROR_MANDATORY', $this->get_clean_name($row['name']));
 						}
 						$appform_post .= $this->create_form_element($row, $value, $value);
@@ -368,11 +351,15 @@ class listener implements EventSubscriberInterface
 
 					case 'checkbox':
 						$value = $this->request->variable($name, [0 => ''], true);
-						if ($row['max_value'] && $row['min_value'] <= $row['max_value'] && (sizeof($value) < $row['min_value'] || sizeof($value) > $row['max_value']))
-						{
+						if ($row['min_value'] && $row['max_value'] && (count($value) < $row['min_value'] || count($value) > $row['max_value'])) {
 							$errors[] = $this->user->lang('ERROR_MIN_MAX_CHECKBOX', $row['min_value'], $row['max_value'], $this->get_clean_name($row['name']));
+						} else if ($row['min_value'] && count($value) < $row['min_value']) {
+							$errors[] = $this->user->lang('ERROR_MIN_CHECKBOX', $row['min_value'], $this->get_clean_name($row['name']));
+						} else if ($row['max_value'] && count($value) > $row['max_value']) {
+							$errors[] = $this->user->lang('ERROR_MAX_CHECKBOX', $row['max_value'], $this->get_clean_name($row['name']));
 						}
-						$appform_post .= $this->create_form_element($row, $value, implode($value, $row['options_separator']));
+
+						$appform_post .= $this->create_form_element($row, $value, implode($row['options_separator'], $value));
 						break;
 
 					case 'number':
@@ -392,8 +379,7 @@ class listener implements EventSubscriberInterface
 			}
 		}
 
-		if ($errors)
-		{
+		if ($errors) {
 			throw new exception('', $errors);
 		}
 
@@ -404,10 +390,8 @@ class listener implements EventSubscriberInterface
 	{
 		$content = '';
 
-		if ($value)
-		{
-			if ($element['name_visible'])
-			{
+		if ($value) {
+			if ($element['name_visible']) {
 				if (!empty($element['name']))
 					$content .= (ext::trim_once($element['name_before']) ?: '[form][b]') . $this->translate($this->get_clean_name($element['name'])) . (ext::trim_once($element['name_after']) ?: ':[/b][/form]');
 				else
@@ -442,8 +426,9 @@ class listener implements EventSubscriberInterface
 
 		/** @var parser_interface $parser */
 		$parser = $phpbb_container->get('text_formatter.parser');
+		$parser->disable_magic_url();
+		$rendered = $renderer->render($parser->parse($text));
 
-		return $renderer->render($parser->parse($text));
+		return htmlspecialchars_decode($rendered);
 	}
-
 }
diff --git "[ORIGINAL]/leinad4mind\\formcreator/ext.php" "[FORUM_EXT]/leinad4mind\\formcreator/ext.php"
--- "[ORIGINAL]/leinad4mind\\formcreator/ext.php"
+++ "[FORUM_EXT]/leinad4mind\\formcreator/ext.php"
@@ -27,11 +27,22 @@ class ext extends \phpbb\extension\base
 		return version_compare($config['version'], '3.2.0-a1', '>=');
 	}
 
-	public static function explode(array $delimiters, $string)
+	public static function explode($string)
 	{
-		return preg_split('/[' . preg_quote(implode($delimiters)) . ']/', $string);
+		$separators = ["\n\n", "\n"];
+
+		foreach ($separators as $separator)
+		{
+			if (strpos($string, $separator) !== false)
+			{
+				return explode($separator, $string);
+			}
 		}
 
+		return explode(',', $string);
+	}
+
+
 	public static function trim_once($str)
 	{
 		if (utf8_strlen($str) < 2)
diff --git "[ORIGINAL]/leinad4mind\\formcreator/language/en/common.php" "[FORUM_EXT]/leinad4mind\\formcreator/language/en/common.php"
--- "[ORIGINAL]/leinad4mind\\formcreator/language/en/common.php"
+++ "[FORUM_EXT]/leinad4mind\\formcreator/language/en/common.php"
@@ -44,10 +44,19 @@ $lang = array_merge($lang, [
 	'FORM_MOD_PREVIEW'		 	=> 'Switch to preview keeping the current form data...',
 	'FORM_MOD_SUBMIT'			=> 'Add the form data to message and post...',
 	'OPEN_FORM_EXPLAIN'			=> 'Switch to Form Mode...',
+	'OPEN_POST_EXPLAIN'			=> 'Switch to Post Mode...',
 	'REFRESHING_FORM'			=> 'The current selected Forum is',
 	'REQUIRED'				 	=> 'You have not entered all the required elements!',
 	'MANDATORY'					=> 'Items marked with the asterisk are mandatory.',
 
 	'ERROR_MANDATORY'			=> 'The field %s is mandatory.',
 	'ERROR_MIN_MAX_CHECKBOX'	=> 'You need to select between %d and %d items for %s.',
+	'ERROR_MIN_CHECKBOX'		=> [
+		1 => 'You need to select at least %d item for %s.',
+		2 => 'You need to select at least %d items for %s.',
+	],
+	'ERROR_MAX_CHECKBOX'		=> [
+		1 => 'You can select at most %d item for %s.',
+		2 => 'You can select at most %d items for %s.',
+	],
 ]);
diff --git "[FORUM_EXT]/leinad4mind\\formcreator/language/pt/common.php" "[FORUM_EXT]/leinad4mind\\formcreator/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\formcreator/language/pt/common.php"
@@ -0,0 +1,62 @@
+<?php
+/**
+*
+* @package phpBB Extension - Form Creator
+* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
+}
+
+// DEVELOPERS PLEASE NOTE
+//
+// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+//
+// Placeholders can now contain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// translators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+// equally where a string contains only two placeholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+//
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+//
+
+$lang = array_merge($lang, [
+	'CLOSE_FORM'				=> 'Cancelar',
+	'OPEN_FORM'					=> 'Modo Gerador Automático',
+	'OPEN_POST'					=> 'Modo BBCode Manual',
+	'FORM_MOD_PREVIEW'		 	=> 'Alternar para pré-visualizar e manter os dados do formulário actual...',
+	'FORM_MOD_SUBMIT'			=> 'Converte e adiciona os dados do formulário à mensagem...',
+	'OPEN_FORM_EXPLAIN'			=> 'Alterar para Gerador Automático...',
+	'OPEN_POST_EXPLAIN'			=> 'Alterar para BBCode Manual...',
+	'REFRESHING_FORM'			=> 'O fórum selecionado actualmente é',
+	'REQUIRED'				 	=> 'Não preencheste todos os campos obrigatórios!',
+	'MANDATORY'					=> 'Campos marcados com asterisco são de preenchimento obrigatório.',
+
+	'ERROR_MANDATORY'			=> 'O campo %s é obrigatório.',
+	'ERROR_MIN_MAX_CHECKBOX'	=> 'Precisas de escolher pelo menos %d item e menos de %d itens para o campo %s.',
+	'ERROR_MIN_CHECKBOX'		=> [
+		1 => 'Precisas de escolher pelo menos %d item para o campo %s.',
+		2 => 'Precisas de escolher pelo menos %d itens para o campo %s.',
+	],
+	'ERROR_MAX_CHECKBOX'		=> [
+		1 => 'Podes escolher no máximo %d item para o campo %s.',
+		2 => 'Podes escolher no máximo %d itens para o campo %s.',
+	],
+]);
diff --git "[FORUM_EXT]/leinad4mind\\formcreator/language/pt/formcreator_acp.php" "[FORUM_EXT]/leinad4mind\\formcreator/language/pt/formcreator_acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\formcreator/language/pt/formcreator_acp.php"
@@ -0,0 +1,185 @@
+<?php
+/**
+*
+* @package phpBB Extension - Form Creator
+* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
+}
+
+// DEVELOPERS PLEASE NOTE
+//
+// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+//
+// Placeholders can now contain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// translators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+// equally where a string contains only two placeholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+//
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+//
+
+$lang = array_merge($lang, [
+	'MODE'						=> 'Mode',
+	'ELEMENTS'					=> 'Elements',
+	'FORM_NAME'					=> 'Forum Name',
+	'FORUM_ID'					=> 'Forum ID',
+	'ACP_FORM_CURRENT'		 	=> 'Update Current Form',
+	'ACP_FORM_CREATOR'			=> 'Form Creator',
+	'ACP_FORM_CREATOR_EXPLAIN'	=> 'With this tool you can create and manage forms for your forum.',
+	'ACP_FORM_EXT_NOTE'			=> '<br><strong>Note:</strong> All actions are performed on the currently selected/displayed form, no confirm is implemented...',
+
+	'ACP_FORM_CREATOR_FAQ' => '<strong>How to begin?</strong><br>
+									&nbsp; &bull; You just need to first select the forum where you will want to create the form.<br>
+									<br>
+									<strong>How can I do that?</strong><br>
+									&nbsp; &bull; Just select a new forum from the <strong><i>Current Forum</i></strong> dropdown box...<br>
+									<br>
+									<strong>And now what?</strong><br>
+									&nbsp; &bull; Next step would be to add new form elements<br>
+									<br>
+									<strong>How do I add a new form element?</strong><br> 
+									&nbsp; &bull; Use <strong><i>Add a new form element</i></strong> at the bottom.<br>
+									<br>
+									<strong>After adding all the form elements I want, does it save automatically?</strong><br>
+									&nbsp; &bull; Yes, when you add the form element it saves automatically on the current form, but if you make changes on the form elements on the <strong><i>Update Current Form</i></strong> then you\'ll need to click update so it can save the changes!<br>
+									<br>
+									<strong>Some fields don\'t make sense to my element type, will something bad happen if I fill those fields?</strong><br>
+									&nbsp; &bull; Nothing bad will happen. You\'ll just put trash on the database. All that info will be discarded. That\'s why it\'s recommended to add an empty new form element and just then update it.<br>
+									<br>
+									<strong>How do I delete a form?</strong><br>
+									&nbsp; &bull; Simply delete all form elements...<br>
+									<br>
+									<br>
+									<strong>What is Name Before/After?</strong><br>
+									&nbsp; &bull; Those fields accept BBCode, and whatever you write there will appear before and after the Entry Name on the final post, so you can customize the Entry Name.<br>
+									<br>
+									<strong>Can I see an example for Name Before/After fields?</strong><br>
+									&nbsp; &bull; Sure. You can add <i>[b]</i> on the Before field and <i>[/b]</i> on the After field and if the Entry Name is <i>Title</i> then the post will be parsed into: <i>[b]Title[/b]</i><br>
+									<br>
+									<strong>What is Entry Name?</strong><br>
+									&nbsp; &bull; Really? This is the question on the form field, the text before the input field, and that text may or may not be imported to the final post.<br>
+									<br>
+									<strong>What is Entry Explain?</strong><br>
+									&nbsp; &bull; This is an optional field, if you fill it, it will appear below the Entry Name on the form, so you can insert a little explanation text. It supports BBCode and line break too.<br>
+									<br>
+									<strong>What is Hint?</strong><br>
+									&nbsp; &bull; Hint is optional and is what appears inside the input fields, so you can provide an idea of what should be filled on the input box. Its good idea to use in some cases to avoid abusing the Entry Explain. For selectbox the hint will be the default first element.<br>
+									<br>
+									<strong>What is Options?</strong><br>
+									&nbsp; &bull; It only works on some element types: selectbox, radiobuttons, checkbox and separator. With that said, it\'s a field where you\'ll insert the options for those element types.<br>
+									<br>
+									<strong>Can I see an example for Options fields? I am still confuse.</strong><br>
+									&nbsp; &bull; Sure. You can add for example genres as: <i>Action, Adventure, Horror, Romance, Sci-Fi</i>, and the user will be able to just select the options, instead of writing.<br>
+									<br>
+									<strong>That makes sense for selectbox, radiobuttons and checkbox, but separator? What is it? </strong><br>
+									&nbsp; &bull; Yes, that one is an exception. That field is only for form layout customization. A way to customize how the form itself will look like.<br>
+									<br>
+									<strong>Great! And do I always need to use a Comma to separate the words?</strong><br>
+									&nbsp; &bull; You can use a comma or a line break and there is a hidden feature too. If you use "Administrator => Adm, Moderator => Mod, User => U", where the former one will appear on the form and the latter one on the post.<br>
+									<br>
+									<strong>What is Min/Max?</strong><br>
+									&nbsp; &bull; This only works on Checkboxes since it\'s the only element type where you can select multiple items and with those fields you can require the user to choose between a min and max values. If you put Min: 1 and Max: 3, the user will need to choose at least one and less than 3 options.<br>
+									<br>
+									<strong>What is Value Before/After?</strong><br>
+									&nbsp; &bull; It\'s similar to the <i>Name Before/After</i>. It accepts BBCode as well and will appear before and after the value that the user inserted.<br>
+									<br>
+									<strong>Can I still see an example for Value Before/After fields?</strong><br>
+									&nbsp; &bull; Why not? You can add <i>[color=#ff0000]</i> on the Before field and <i>[/color]</i> on the After field and lets say the Entry Name is <i>Movie Title</i>. Then the user inserts on the form something as <i>Titanic</i> and when he submits, the post will be parsed into: <i>[color=#ff0000]Titanic[/color]</i><br>
+									<br>
+									<strong>Is there anything else that I should know?</strong><br>
+									&nbsp; &bull; I\'m glad you asked! Some fields as Entry Name, Explain, Hint and Options are translatable. This means you can insert language variables {L_LANGUAGE_VARIABLE} so the form will be multilingual.<br>
+									<br>
+									<strong>WOW! Awesome! But where can I add the Language Variables?</strong><br>
+									&nbsp; &bull; Just edit the root/ext/leinad4mind/formcreator/language/COUNTRY/common.php file and add new variables, so you can use at ACP afterwards.<br>
+									<br>
+									<strong>&#8730;</strong> The checkmark character indicates the item is mandatory and cannot be empty, so it will force the user to fill it.<br>
+									<strong><i class="fa fa-eye" aria-hidden="true"></i></strong> The eye character indicates the entry name of that item will not be imported to the post submitted.<br>',
+
+	'CURRENT_FORUM'			 	=> 'Current Forum',
+	'FORM_ADD_ITEM'				=> 'Add a new form element',
+	'FORM_CHECKBOX'				=> 'Check Box',
+	'FORM_DETAILS'			 	=> 'All forms use a generic template file: styles/YOUR_STYLE/template/forms/form_creator.html',
+	'FORM_ELEMENT_TYPE'					=> 'Element type',
+	'FORM_ELEMENT_HINT'					=> 'Hint',
+	'FORM_ELEMENT_OPTIONS_SEPARATOR'	=> 'Options separator',
+	'FORM_ELEMENT_NAME_VISIBLE'			=> 'Display/hide the element name on the final form.',
+	'FORM_ELEMENT_NAME'					=> 'Entry Name',
+	'FORM_ELEMENT_EXPLAIN'				=> 'Entry Explain',
+	'FORM_ELEMENT_NAME_EXPLAIN'			=> 'Entry Name/Explain',
+	'FORM_ELEMENT_OPTIONS'				=> 'Options',
+	'FORM_ELEMENT_MIN_MAX'				=> 'Min/Max',
+	'FORM_ELEMENT_MIN'					=> 'Min',
+	'FORM_ELEMENT_MAX'					=> 'Max',
+	'FORM_ELEMENT_NAME_BEFORE_AFTER'	=> 'Name before/after',
+	'FORM_ELEMENT_VALUE_BEFORE_AFTER'	=> 'Value before/after',
+	'FORM_EMAILBOX'				=> 'Email',
+	'FORM_INPUTBOX'				=> 'Text',
+	'FORM_CREATOR_ACP_RETURN'	=> 'Back to manage forms',
+	'FORM_MANAGE'				=> 'Manage this form',
+	'FORM_MANAGE_EXPLAIN'		=> 'Here you can modify all of the current form elements, simply edit fields and press the <strong>Update</strong> button...',
+
+	'FORM_NEW_ITEM_EXPLAIN'		=> '<pre style="font-size:11px; line-height: 100%;"><strong><u>Form Elements Supported</u></strong><br>
+									<strong>Inputbox:</strong>		Up to 255 characters<br>
+									<strong>Textbox:</strong>	 	Multiple lines of text arranged as 3 rows by 76 columns.<br>
+									<strong>Checkbox:</strong>		One or more options can be selected.<br>
+									<strong>Radiobutton:</strong> 		Only one option can be selected.<br>
+									<strong>Selectbox:</strong>		One option from a dropdown list.<br>
+									<strong>Email:</strong>			Valid email address.<br>
+									<strong>Password:</strong>		For test purposes only...<br>
+									<strong>URL:</strong>			A valid URL must be entered.<br>
+									<strong>Attachment:</strong>		Add a file to the attachment system.<br>
+									<strong>Number:</strong>			Only numbers 0-9 are allowed.<br>
+									<strong>Date:</strong>			Opens a date picker.<br>
+									<strong>Time:</strong>			Opens a time picker.<br>
+									<strong>Separator:</strong>			Only for form layout customization.<br>
+									<br></pre>',
+
+	'FORM_NO_FORM'			 	=> 'There are no forms assigned to: <strong>%s</strong>...<br>To add a new form to this forum, simply add a form element below...',
+	'FORM_RADIOBOX'				=> 'Radio Buttons',
+	'FORM_PASSWORDBOX'			=> 'Password',
+	'FORM_SELECTBOX'			=> 'Select Box',
+	'FORM_TXTBOX'				=> 'Text Box',
+	'FORM_URLBOX'				=> 'URL',
+	'FORM_ATTACH'				=> 'Attachment',
+	'FORM_NUMBER'				=> 'Number',
+	'FORM_DATE'					=> 'Date',
+	'FORM_TIME'					=> 'Time',
+	'FORM_SEPARATOR'			=> 'Separator',
+	'HIDE_FORM_INFO'			=> 'Hide info',
+	'HIDE_PREVIEW'			 	=> 'Hide Preview',
+	'HIDE_COPY'				 	=> 'Hide copy form',
+	'HOW_TO'					=> '<strong>Additional Help...</strong>',
+	'HOW_TO_MORE'				=> 'More info...',
+	'HOW_TO_HIDE'				=> '<strong>Hide</strong>',
+	'NDX'						=> 'NDX',
+	'NDX_ORDER'					=> 'Index order (the order in which items appear on the form)',
+	'FORMS_MOD_SAMPLE'		 	=> 'Rendering the current form to assist visualization only... not a working form.',
+	'SHOW_FORM_INFO'			=> 'More info on Element types',
+	'SHOW_PREVIEW'			 	=> 'Preview the form',
+	'SHOW_COPY'					=> 'Copy form',
+	'COPY_FORM'					=> 'Copy form to selected forums',
+	'COPY_FORM_EXPLAIN'			=> 'This will delete all existing form elements in the selected destination forums!',
+	'COPY_FORM_SUCCESS'			=> 'The form elements have been copied to all selected forums.',
+
+	'SHOW_FORM_DEFAULT'			=> 'Show form by default',
+	'FORCE_FORM'				=> 'Force form',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\formcreator/language/pt/info_acp_formcreator.php" "[FORUM_EXT]/leinad4mind\\formcreator/language/pt/info_acp_formcreator.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\formcreator/language/pt/info_acp_formcreator.php"
@@ -0,0 +1,43 @@
+<?php
+/**
+*
+* @package phpBB Extension - Form Creator
+* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
+}
+
+// DEVELOPERS PLEASE NOTE
+//
+// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+//
+// Placeholders can now contain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// translators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+// equally where a string contains only two placeholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+//
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+//
+
+$lang = array_merge($lang, [
+	'ACP_FORM_CREATOR'				=> 'Form Creator',
+	'ACP_FORM_CREATOR_CONFIG'	 	=> 'Configuration',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\formcreator/language/pt/permissions_formcreator.php" "[FORUM_EXT]/leinad4mind\\formcreator/language/pt/permissions_formcreator.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\formcreator/language/pt/permissions_formcreator.php"
@@ -0,0 +1,42 @@
+<?php
+/**
+*
+* @package phpBB Extension - Form Creator
+* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
+}
+
+// DEVELOPERS PLEASE NOTE
+//
+// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+//
+// Placeholders can now contain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// translators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+// equally where a string contains only two placeholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+//
+// Some characters for use
+// ’ » “ ” …
+
+$lang = array_merge($lang, [
+	'ACL_A_FORM_CREATOR'		=> 'Can manage Form Creator',
+	'ACL_F_FORM_CREATOR'		=> 'Can use Form Creator',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\formcreator/language/pt_preao/common.php" "[FORUM_EXT]/leinad4mind\\formcreator/language/pt_preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\formcreator/language/pt_preao/common.php"
@@ -0,0 +1,62 @@
+<?php
+/**
+*
+* @package phpBB Extension - Form Creator
+* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
+}
+
+// DEVELOPERS PLEASE NOTE
+//
+// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+//
+// Placeholders can now contain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// translators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+// equally where a string contains only two placeholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+//
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+//
+
+$lang = array_merge($lang, [
+	'CLOSE_FORM'				=> 'Cancelar',
+	'OPEN_FORM'					=> 'Modo Gerador Automático',
+	'OPEN_POST'					=> 'Modo BBCode Manual',
+	'FORM_MOD_PREVIEW'		 	=> 'Alternar para pré-visualizar e manter os dados do formulário actual...',
+	'FORM_MOD_SUBMIT'			=> 'Converte e adiciona os dados do formulário à mensagem...',
+	'OPEN_FORM_EXPLAIN'			=> 'Alterar para Gerador Automático...',
+	'OPEN_POST_EXPLAIN'			=> 'Alterar para BBCode Manual...',
+	'REFRESHING_FORM'			=> 'O fórum selecionado actualmente é',
+	'REQUIRED'				 	=> 'Não preencheste todos os campos obrigatórios!',
+	'MANDATORY'					=> 'Campos marcados com asterisco são de preenchimento obrigatório.',
+
+	'ERROR_MANDATORY'			=> 'O campo %s é obrigatório.',
+	'ERROR_MIN_MAX_CHECKBOX'	=> 'Precisas de escolher pelo menos %d item e menos de %d itens para o campo %s.',
+	'ERROR_MIN_CHECKBOX'		=> [
+		1 => 'Precisas de escolher pelo menos %d item para o campo %s.',
+		2 => 'Precisas de escolher pelo menos %d itens para o campo %s.',
+	],
+	'ERROR_MAX_CHECKBOX'		=> [
+		1 => 'Podes escolher no máximo %d item para o campo %s.',
+		2 => 'Podes escolher no máximo %d itens para o campo %s.',
+	],
+]);
diff --git "[FORUM_EXT]/leinad4mind\\formcreator/language/pt_preao/formcreator_acp.php" "[FORUM_EXT]/leinad4mind\\formcreator/language/pt_preao/formcreator_acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\formcreator/language/pt_preao/formcreator_acp.php"
@@ -0,0 +1,185 @@
+<?php
+/**
+*
+* @package phpBB Extension - Form Creator
+* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
+}
+
+// DEVELOPERS PLEASE NOTE
+//
+// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+//
+// Placeholders can now contain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// translators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+// equally where a string contains only two placeholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+//
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+//
+
+$lang = array_merge($lang, [
+	'MODE'						=> 'Mode',
+	'ELEMENTS'					=> 'Elements',
+	'FORM_NAME'					=> 'Forum Name',
+	'FORUM_ID'					=> 'Forum ID',
+	'ACP_FORM_CURRENT'		 	=> 'Update Current Form',
+	'ACP_FORM_CREATOR'			=> 'Form Creator',
+	'ACP_FORM_CREATOR_EXPLAIN'	=> 'With this tool you can create and manage forms for your forum.',
+	'ACP_FORM_EXT_NOTE'			=> '<br><strong>Note:</strong> All actions are performed on the currently selected/displayed form, no confirm is implemented...',
+
+	'ACP_FORM_CREATOR_FAQ' => '<strong>How to begin?</strong><br>
+									&nbsp; &bull; You just need to first select the forum where you will want to create the form.<br>
+									<br>
+									<strong>How can I do that?</strong><br>
+									&nbsp; &bull; Just select a new forum from the <strong><i>Current Forum</i></strong> dropdown box...<br>
+									<br>
+									<strong>And now what?</strong><br>
+									&nbsp; &bull; Next step would be to add new form elements<br>
+									<br>
+									<strong>How do I add a new form element?</strong><br> 
+									&nbsp; &bull; Use <strong><i>Add a new form element</i></strong> at the bottom.<br>
+									<br>
+									<strong>After adding all the form elements I want, does it save automatically?</strong><br>
+									&nbsp; &bull; Yes, when you add the form element it saves automatically on the current form, but if you make changes on the form elements on the <strong><i>Update Current Form</i></strong> then you\'ll need to click update so it can save the changes!<br>
+									<br>
+									<strong>Some fields don\'t make sense to my element type, will something bad happen if I fill those fields?</strong><br>
+									&nbsp; &bull; Nothing bad will happen. You\'ll just put trash on the database. All that info will be discarded. That\'s why it\'s recommended to add an empty new form element and just then update it.<br>
+									<br>
+									<strong>How do I delete a form?</strong><br>
+									&nbsp; &bull; Simply delete all form elements...<br>
+									<br>
+									<br>
+									<strong>What is Name Before/After?</strong><br>
+									&nbsp; &bull; Those fields accept BBCode, and whatever you write there will appear before and after the Entry Name on the final post, so you can customize the Entry Name.<br>
+									<br>
+									<strong>Can I see an example for Name Before/After fields?</strong><br>
+									&nbsp; &bull; Sure. You can add <i>[b]</i> on the Before field and <i>[/b]</i> on the After field and if the Entry Name is <i>Title</i> then the post will be parsed into: <i>[b]Title[/b]</i><br>
+									<br>
+									<strong>What is Entry Name?</strong><br>
+									&nbsp; &bull; Really? This is the question on the form field, the text before the input field, and that text may or may not be imported to the final post.<br>
+									<br>
+									<strong>What is Entry Explain?</strong><br>
+									&nbsp; &bull; This is an optional field, if you fill it, it will appear below the Entry Name on the form, so you can insert a little explanation text. It supports BBCode and line break too.<br>
+									<br>
+									<strong>What is Hint?</strong><br>
+									&nbsp; &bull; Hint is optional and is what appears inside the input fields, so you can provide an idea of what should be filled on the input box. Its good idea to use in some cases to avoid abusing the Entry Explain. For selectbox the hint will be the default first element.<br>
+									<br>
+									<strong>What is Options?</strong><br>
+									&nbsp; &bull; It only works on some element types: selectbox, radiobuttons, checkbox and separator. With that said, it\'s a field where you\'ll insert the options for those element types.<br>
+									<br>
+									<strong>Can I see an example for Options fields? I am still confuse.</strong><br>
+									&nbsp; &bull; Sure. You can add for example genres as: <i>Action, Adventure, Horror, Romance, Sci-Fi</i>, and the user will be able to just select the options, instead of writing.<br>
+									<br>
+									<strong>That makes sense for selectbox, radiobuttons and checkbox, but separator? What is it? </strong><br>
+									&nbsp; &bull; Yes, that one is an exception. That field is only for form layout customization. A way to customize how the form itself will look like.<br>
+									<br>
+									<strong>Great! And do I always need to use a Comma to separate the words?</strong><br>
+									&nbsp; &bull; You can use a comma or a line break and there is a hidden feature too. If you use "Administrator => Adm, Moderator => Mod, User => U", where the former one will appear on the form and the latter one on the post.<br>
+									<br>
+									<strong>What is Min/Max?</strong><br>
+									&nbsp; &bull; This only works on Checkboxes since it\'s the only element type where you can select multiple items and with those fields you can require the user to choose between a min and max values. If you put Min: 1 and Max: 3, the user will need to choose at least one and less than 3 options.<br>
+									<br>
+									<strong>What is Value Before/After?</strong><br>
+									&nbsp; &bull; It\'s similar to the <i>Name Before/After</i>. It accepts BBCode as well and will appear before and after the value that the user inserted.<br>
+									<br>
+									<strong>Can I still see an example for Value Before/After fields?</strong><br>
+									&nbsp; &bull; Why not? You can add <i>[color=#ff0000]</i> on the Before field and <i>[/color]</i> on the After field and lets say the Entry Name is <i>Movie Title</i>. Then the user inserts on the form something as <i>Titanic</i> and when he submits, the post will be parsed into: <i>[color=#ff0000]Titanic[/color]</i><br>
+									<br>
+									<strong>Is there anything else that I should know?</strong><br>
+									&nbsp; &bull; I\'m glad you asked! Some fields as Entry Name, Explain, Hint and Options are translatable. This means you can insert language variables {L_LANGUAGE_VARIABLE} so the form will be multilingual.<br>
+									<br>
+									<strong>WOW! Awesome! But where can I add the Language Variables?</strong><br>
+									&nbsp; &bull; Just edit the root/ext/leinad4mind/formcreator/language/COUNTRY/common.php file and add new variables, so you can use at ACP afterwards.<br>
+									<br>
+									<strong>&#8730;</strong> The checkmark character indicates the item is mandatory and cannot be empty, so it will force the user to fill it.<br>
+									<strong><i class="fa fa-eye" aria-hidden="true"></i></strong> The eye character indicates the entry name of that item will not be imported to the post submitted.<br>',
+
+	'CURRENT_FORUM'			 	=> 'Current Forum',
+	'FORM_ADD_ITEM'				=> 'Add a new form element',
+	'FORM_CHECKBOX'				=> 'Check Box',
+	'FORM_DETAILS'			 	=> 'All forms use a generic template file: styles/YOUR_STYLE/template/forms/form_creator.html',
+	'FORM_ELEMENT_TYPE'					=> 'Element type',
+	'FORM_ELEMENT_HINT'					=> 'Hint',
+	'FORM_ELEMENT_OPTIONS_SEPARATOR'	=> 'Options separator',
+	'FORM_ELEMENT_NAME_VISIBLE'			=> 'Display/hide the element name on the final form.',
+	'FORM_ELEMENT_NAME'					=> 'Entry Name',
+	'FORM_ELEMENT_EXPLAIN'				=> 'Entry Explain',
+	'FORM_ELEMENT_NAME_EXPLAIN'			=> 'Entry Name/Explain',
+	'FORM_ELEMENT_OPTIONS'				=> 'Options',
+	'FORM_ELEMENT_MIN_MAX'				=> 'Min/Max',
+	'FORM_ELEMENT_MIN'					=> 'Min',
+	'FORM_ELEMENT_MAX'					=> 'Max',
+	'FORM_ELEMENT_NAME_BEFORE_AFTER'	=> 'Name before/after',
+	'FORM_ELEMENT_VALUE_BEFORE_AFTER'	=> 'Value before/after',
+	'FORM_EMAILBOX'				=> 'Email',
+	'FORM_INPUTBOX'				=> 'Text',
+	'FORM_CREATOR_ACP_RETURN'	=> 'Back to manage forms',
+	'FORM_MANAGE'				=> 'Manage this form',
+	'FORM_MANAGE_EXPLAIN'		=> 'Here you can modify all of the current form elements, simply edit fields and press the <strong>Update</strong> button...',
+
+	'FORM_NEW_ITEM_EXPLAIN'		=> '<pre style="font-size:11px; line-height: 100%;"><strong><u>Form Elements Supported</u></strong><br>
+									<strong>Inputbox:</strong>		Up to 255 characters<br>
+									<strong>Textbox:</strong>	 	Multiple lines of text arranged as 3 rows by 76 columns.<br>
+									<strong>Checkbox:</strong>		One or more options can be selected.<br>
+									<strong>Radiobutton:</strong> 		Only one option can be selected.<br>
+									<strong>Selectbox:</strong>		One option from a dropdown list.<br>
+									<strong>Email:</strong>			Valid email address.<br>
+									<strong>Password:</strong>		For test purposes only...<br>
+									<strong>URL:</strong>			A valid URL must be entered.<br>
+									<strong>Attachment:</strong>		Add a file to the attachment system.<br>
+									<strong>Number:</strong>			Only numbers 0-9 are allowed.<br>
+									<strong>Date:</strong>			Opens a date picker.<br>
+									<strong>Time:</strong>			Opens a time picker.<br>
+									<strong>Separator:</strong>			Only for form layout customization.<br>
+									<br></pre>',
+
+	'FORM_NO_FORM'			 	=> 'There are no forms assigned to: <strong>%s</strong>...<br>To add a new form to this forum, simply add a form element below...',
+	'FORM_RADIOBOX'				=> 'Radio Buttons',
+	'FORM_PASSWORDBOX'			=> 'Password',
+	'FORM_SELECTBOX'			=> 'Select Box',
+	'FORM_TXTBOX'				=> 'Text Box',
+	'FORM_URLBOX'				=> 'URL',
+	'FORM_ATTACH'				=> 'Attachment',
+	'FORM_NUMBER'				=> 'Number',
+	'FORM_DATE'					=> 'Date',
+	'FORM_TIME'					=> 'Time',
+	'FORM_SEPARATOR'			=> 'Separator',
+	'HIDE_FORM_INFO'			=> 'Hide info',
+	'HIDE_PREVIEW'			 	=> 'Hide Preview',
+	'HIDE_COPY'				 	=> 'Hide copy form',
+	'HOW_TO'					=> '<strong>Additional Help...</strong>',
+	'HOW_TO_MORE'				=> 'More info...',
+	'HOW_TO_HIDE'				=> '<strong>Hide</strong>',
+	'NDX'						=> 'NDX',
+	'NDX_ORDER'					=> 'Index order (the order in which items appear on the form)',
+	'FORMS_MOD_SAMPLE'		 	=> 'Rendering the current form to assist visualization only... not a working form.',
+	'SHOW_FORM_INFO'			=> 'More info on Element types',
+	'SHOW_PREVIEW'			 	=> 'Preview the form',
+	'SHOW_COPY'					=> 'Copy form',
+	'COPY_FORM'					=> 'Copy form to selected forums',
+	'COPY_FORM_EXPLAIN'			=> 'This will delete all existing form elements in the selected destination forums!',
+	'COPY_FORM_SUCCESS'			=> 'The form elements have been copied to all selected forums.',
+
+	'SHOW_FORM_DEFAULT'			=> 'Show form by default',
+	'FORCE_FORM'				=> 'Force form',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\formcreator/language/pt_preao/info_acp_formcreator.php" "[FORUM_EXT]/leinad4mind\\formcreator/language/pt_preao/info_acp_formcreator.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\formcreator/language/pt_preao/info_acp_formcreator.php"
@@ -0,0 +1,43 @@
+<?php
+/**
+*
+* @package phpBB Extension - Form Creator
+* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
+}
+
+// DEVELOPERS PLEASE NOTE
+//
+// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+//
+// Placeholders can now contain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// translators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+// equally where a string contains only two placeholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+//
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+//
+
+$lang = array_merge($lang, [
+	'ACP_FORM_CREATOR'				=> 'Form Creator',
+	'ACP_FORM_CREATOR_CONFIG'	 	=> 'Configuration',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\formcreator/language/pt_preao/permissions_formcreator.php" "[FORUM_EXT]/leinad4mind\\formcreator/language/pt_preao/permissions_formcreator.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\formcreator/language/pt_preao/permissions_formcreator.php"
@@ -0,0 +1,42 @@
+<?php
+/**
+*
+* @package phpBB Extension - Form Creator
+* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
+* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
+}
+
+// DEVELOPERS PLEASE NOTE
+//
+// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+//
+// Placeholders can now contain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// translators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+// equally where a string contains only two placeholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+//
+// Some characters for use
+// ’ » “ ” …
+
+$lang = array_merge($lang, [
+	'ACL_A_FORM_CREATOR'		=> 'Can manage Form Creator',
+	'ACL_F_FORM_CREATOR'		=> 'Can use Form Creator',
+]);
diff --git "[ORIGINAL]/leinad4mind\\formcreator/styles/BBOOTS/template/event/overall_header_head_append.html" "[FORUM_EXT]/leinad4mind\\formcreator/styles/BBOOTS/template/event/overall_header_head_append.html"
--- "[ORIGINAL]/leinad4mind\\formcreator/styles/BBOOTS/template/event/overall_header_head_append.html"
+++ "[FORUM_EXT]/leinad4mind\\formcreator/styles/BBOOTS/template/event/overall_header_head_append.html"
@@ -1,3 +1,3 @@
-{% if SCRIPT_NAME eq 'viewtopic' or SCRIPT_NAME eq 'search' %}
+{% if SCRIPT_NAME in ['viewtopic', 'search'] %}
 	{% INCLUDECSS '@leinad4mind_formcreator/formcreator.css' %}
 {% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\formcreator/styles/FLATBOOTS/template/event/overall_header_head_append.html" "[FORUM_EXT]/leinad4mind\\formcreator/styles/FLATBOOTS/template/event/overall_header_head_append.html"
--- "[ORIGINAL]/leinad4mind\\formcreator/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+++ "[FORUM_EXT]/leinad4mind\\formcreator/styles/FLATBOOTS/template/event/overall_header_head_append.html"
@@ -1,3 +1,3 @@
-{% if SCRIPT_NAME eq 'viewtopic' or SCRIPT_NAME eq 'search' %}
+{% if SCRIPT_NAME in ['viewtopic', 'search'] %}
 	{% INCLUDECSS '@leinad4mind_formcreator/formcreator.css' %}
 {% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_message_append.html" "[FORUM_EXT]/leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_message_append.html"
--- "[ORIGINAL]/leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_message_append.html"
+++ "[FORUM_EXT]/leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_message_append.html"
@@ -3,13 +3,13 @@
 	<div class="inner">
 		<div class="space10"></div>
 		<fieldset class="submit-buttons form-buttons">
-			{{ S_HIDDEN_ADDRESS_FIELD }}
-			{{ S_HIDDEN_FIELDS }}
+			{S_HIDDEN_ADDRESS_FIELD}
+			{S_HIDDEN_FIELDS}
 			{% EVENT posting_editor_submit_buttons %}
-			{% if S_HAS_DRAFTS %}<input type="submit" accesskey="d" tabindex="8" name="load" value="{{ lang('LOAD_DRAFT') }}" class="btn btn-default" onclick="load_draft = true;">&nbsp; {% endif %}
-			{% if S_SAVE_ALLOWED %}<input type="submit" accesskey="k" tabindex="7" name="save" value="{{ lang('SAVE_DRAFT') }}" class="btn btn-default">&nbsp; {% endif %}
-			<input type="submit" tabindex="5" name="preview" value="{{ lang('PREVIEW') }}" class="btn btn-default"{% if not S_PRIVMSGS %} onclick="document.getElementById('postform').action += '#preview';"{% endif %}>&nbsp;
-			<input type="submit" accesskey="s" tabindex="6" name="post" value="{{ lang('SUBMIT') }}" class="btn btn-default default-submit-action">&nbsp;
+			{% if S_HAS_DRAFTS %}<button type="submit" class="btn btn-default" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>" accesskey="d" tabindex="8" name="load" value="{{ lang('LOAD_DRAFT') }}" onclick="load_draft = true;"><span class="hidden-xs">{{ lang('LOAD_DRAFT') }}</span><i class="visible-xs fa fa-upload fa-btn-fx"></i></button>{% endif %}
+			{% if S_SAVE_ALLOWED %}<button type="submit" class="btn btn-default" data-loading-text="{{ lang('SAVING') }}&nbsp;<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>" accesskey="k" tabindex="7" name="save" value="{{ lang('SAVE_DRAFT') }}"><span class="hidden-xs">{{ lang('SAVE_DRAFT') }}</span><i class="visible-xs fa fa-floppy-o fa-btn-fx"></i></button>{% endif %}
+			<button type="submit" class="btn btn-default" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>" tabindex="5" name="preview" value="{{ lang('PREVIEW') }}"{% if not S_PRIVMSGS %} onclick="enable_form_preview(); document.getElementById('postform').action += '#preview';"{% endif %} >{{ lang('PREVIEW') }}</button>
+			<button type="submit" class="btn btn-default" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>" accesskey="s" tabindex="6" name="post" value="{{ lang('SUBMIT') }}">{{ lang('SUBMIT') }}</button>
 		</fieldset>
 		<div class="space10"></div>
 	</div>
diff --git "[ORIGINAL]/leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_subject_after.html" "[FORUM_EXT]/leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
--- "[ORIGINAL]/leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
+++ "[FORUM_EXT]/leinad4mind\\formcreator/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
@@ -8,7 +8,7 @@
 {% if not S_FORCE_FORM %}
 	{% if MODE == 'post' %}
 		<div class="space10"></div>
-		<button type="button" class="btn btn-default" accesskey="f" name="useform" onclick="toggle_validation(); switch_mode(this);" title="{{ lang('OPEN_FORM_EXPLAIN') }}">{{ lang(S_SHOW_FORM or S_FORCE_FORM ? 'OPEN_POST' : 'OPEN_FORM') }}</button>
+		<button type="button" class="btn btn-default" accesskey="f" name="useform" onclick="toggle_validation(); switch_mode(this);" title="{{ lang(S_SHOW_FORM ? 'OPEN_FORM_EXPLAIN' : 'OPEN_POST_EXPLAIN') }}">{{ lang(S_SHOW_FORM ? 'OPEN_POST' : 'OPEN_FORM') }}</button>
 	{% endif %}
 {% endif %}
 
diff --git "[ORIGINAL]/leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_creator.html" "[FORUM_EXT]/leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_creator.html"
--- "[ORIGINAL]/leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_creator.html"
+++ "[FORUM_EXT]/leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_creator.html"
@@ -22,7 +22,7 @@
 				{% else %}
 					<dl>
 						<dt>
-							{% if form_creator_template.NAME_RICH %}<label for="{{ form_creator_template.CLEAN_NAME }}">{{ form_creator_template.NAME_RICH ~ lang('COLON') }}</label>{% endif %}{{ form_creator_template.MANDATORY }}
+							{% if form_creator_template.NAME_RICH %}<label for="{{ form_creator_template.CLEAN_NAME }}">{{ form_creator_template.NAME_RICH }}</label>{% endif %}{{ form_creator_template.MANDATORY }}
 							{% if form_creator_template.EXPLAIN %}
 								<br><span class="small">{{ form_creator_template.EXPLAIN }}</span>
 							{% endif %}
@@ -36,7 +36,7 @@
 	<div class="panels">
 		<div class="inner">
 			<fieldset class="submit-buttons form-buttons">
-				{{ S_FORM_TOKEN }}
+				{S_FORM_TOKEN}
 				<input type="reset" name="reset" value="{{ lang('RESET') }}" class="btn btn-default">&nbsp;
 				<input type="submit" tabindex="5" name="preview" value="{{ lang('PREVIEW') }}" class="btn btn-default" onclick="enable_form_preview(); document.getElementById('postform').action += '#preview';">&nbsp;
 				<input type="submit" accesskey="s" tabindex="6" name="post" value="{{ lang('SUBMIT') }}" class="btn btn-default default-submit-action" onclick="enable_form_preview();">
diff --git "[ORIGINAL]/leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_mod.js" "[FORUM_EXT]/leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_mod.js"
--- "[ORIGINAL]/leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_mod.js"
+++ "[FORUM_EXT]/leinad4mind\\formcreator/styles/FLATBOOTS/template/forms/form_mod.js"
@@ -31,6 +31,11 @@ function is_hidden(id)
 function toggle_validation()
 {
 	document.forms.postform.noValidate = !is_hidden('thisform');
+	if(!document.forms.postform.noValidate) {
+		$('#postform').attr('novalidate', true);
+		return;
+	}
+	$('#postform').removeAttr('novalidate');
 }
 
 function enable_form_preview()
diff --git "[ORIGINAL]/leinad4mind\\formcreator/styles/prosilver/template/event/overall_header_head_append.html" "[FORUM_EXT]/leinad4mind\\formcreator/styles/prosilver/template/event/overall_header_head_append.html"
--- "[ORIGINAL]/leinad4mind\\formcreator/styles/prosilver/template/event/overall_header_head_append.html"
+++ "[FORUM_EXT]/leinad4mind\\formcreator/styles/prosilver/template/event/overall_header_head_append.html"
@@ -1,3 +1,3 @@
-{% if SCRIPT_NAME eq 'viewtopic' or SCRIPT_NAME eq 'search' %}
+{% if SCRIPT_NAME in ['viewtopic', 'search'] %}
 	{% INCLUDECSS '@leinad4mind_formcreator/formcreator.css' %}
 {% endif %}
\ No newline at end of file
```
