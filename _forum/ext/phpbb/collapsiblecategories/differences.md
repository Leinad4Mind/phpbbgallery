Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/phpbb\\collapsiblecategories/diff_full.tmp" "[FORUM_EXT]/phpbb\\collapsiblecategories/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\collapsiblecategories/diff_full.tmp"
@@ -0,0 +1,245 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/collapsible_categories_button.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/collapsible_categories_button.html"
+new file mode 100644
+index 000000000..c72cf9d54
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/collapsible_categories_button.html"
+@@ -0,0 +1 @@
++<a href="{{ U_CC_COLLAPSE_URL }}" class="collapse-btn" data-hidden="{{ S_CC_FORUM_HIDDEN }}" data-ajax="phpbb_collapse" data-overlay="true"><i class="fa {% if S_CC_FORUM_HIDDEN %}fa-plus{% else %}fa-minus{% endif %}"></i></a>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_before.html"
+new file mode 100644
+index 000000000..8fa479547
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_before.html"
+@@ -0,0 +1,8 @@
++{% if forumrow.S_IS_CAT or forumrow.S_FIRST_ROW or forumrow.S_NO_CAT %}
++	<a class="category{% if forumrow.S_FORUM_HIDDEN %} hidden-category{% endif %}" id="category{{ forumrow.FORUM_ID }}" style="display: none; height: 0"></a>
++{% if not S_IS_BOT %}
++	{% set S_CC_FORUM_HIDDEN = forumrow.S_FORUM_HIDDEN %}
++	{% set U_CC_COLLAPSE_URL = forumrow.U_COLLAPSE_URL %}
++	{% include '@phpbb_collapsiblecategories/collapsible_categories_button.html' %}
++{% endif %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_row_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_row_append.html"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/overall_header_head_append.html"
+new file mode 100644
+index 000000000..f9c24ff43
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/overall_header_head_append.html"
+@@ -0,0 +1,2 @@
++{% INCLUDECSS '@phpbb_collapsiblecategories/collapsiblecategories.css' %}
++{% INCLUDEJS '@phpbb_collapsiblecategories/js/collapsiblecategories.js' %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/js/collapsiblecategories.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/js/collapsiblecategories.js"
+new file mode 100644
+index 000000000..1ca53b1ed
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/js/collapsiblecategories.js"
+@@ -0,0 +1,54 @@
++head.ready(function() {
++	(function($) { // Avoid conflicts with other libraries
++
++		'use strict';
++
++		// Get the collapsible element (has class .topiclist.forums OR .collapsible)
++		$.fn.getCollapsible = function(opt) {
++			if(opt)
++				return this.next('.panel').find('table tbody');
++			else
++				return this.closest('.panel').find('table tbody');
++		};
++
++		$('a.collapse-btn').each(function() {
++			var $this = $(this),
++				hidden = $this.attr('data-hidden'),
++				$content = $this.getCollapsible(true),
++				category = $this.next('.panel').find('table thead th:last-child'),
++				position = 'append';
++
++			// Return if no collapsible content could be found
++			if (!$content.length) {
++				return;
++			}
++
++			// Unhide the collapse buttons (makes them JS dependent)
++			$this.show();
++
++			// Hide hidden forums on load
++			if (hidden) {
++				$content.hide();
++			}
++
++			category[position].apply(category, [$this]);
++		});
++
++		phpbb.addAjaxCallback('phpbb_collapse', function(res) {
++			if (res.success) {
++				var oldTitle = $(this).attr('title'),
++					newTitle = $(this).attr('data-title-alt');
++				$(this)
++					.attr({'title': newTitle, 'data-title-alt': oldTitle})
++					.find('i')
++					.toggleClass('fa-plus fa-minus')
++					.end()
++					.getCollapsible(false)
++					.stop(true, true)
++					.slideToggle('fast')
++				;
++			}
++		});
++
++	})(jQuery); // Avoid conflicts with other libraries
++});
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/theme/collapsiblecategories.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/theme/collapsiblecategories.css"
+new file mode 100644
+index 000000000..1556a9cd0
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/theme/collapsiblecategories.css"
+@@ -0,0 +1,17 @@
++/* Hide the forums of a hidden category */
++.hidden-category,
++.hidden-category + .panel .collapsible,
++.hidden-category + .panel tbody {
++	display: none;
++}
++
++/* Collapse button */
++.collapse-btn {
++	position: relative;
++	float: right;
++	margin: 0 10px;
++}
++
++.rtl .collapse-btn {
++	float: left;
++}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/collapsible_categories_button.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/collapsible_categories_button.html"
+new file mode 100644
+index 000000000..b07877cde
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/collapsible_categories_button.html"
+@@ -0,0 +1,9 @@
++<a href="{{ U_CC_COLLAPSE_URL }}" 
++   class="collapse-btn" 
++   data-hidden="{{ S_CC_FORUM_HIDDEN }}" 
++   data-ajax="phpbb_collapse" 
++   data-overlay="true"
++   data-title-alt="{{ lang(L_CC_BUTTON_TITLE, not S_CC_FORUM_HIDDEN ? 1 : 0) }}"
++   title="{{ lang(L_CC_BUTTON_TITLE, S_CC_FORUM_HIDDEN ? 1 : 0) }}">
++	<i class="fa {% if S_CC_FORUM_HIDDEN %}fa-plus{% else %}fa-minus{% endif %}"></i>
++</a>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_before.html"
+new file mode 100644
+index 000000000..211cb21f1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_before.html"
+@@ -0,0 +1,9 @@
++{% if forumrow.S_IS_CAT or forumrow.S_FIRST_ROW or forumrow.S_NO_CAT %}
++	<a class="category{% if forumrow.S_FORUM_HIDDEN %} hidden-category{% endif %}" id="category{{ forumrow.FORUM_ID }}" style="display: none; height: 0"></a>
++	{% if not S_IS_BOT %}
++		{% set S_CC_FORUM_HIDDEN = forumrow.S_FORUM_HIDDEN %}
++		{% set U_CC_COLLAPSE_URL = forumrow.U_COLLAPSE_URL %}
++		{% set L_CC_BUTTON_TITLE = 'COLLAPSIBLE_CATEGORIES_TITLE' %}
++		{% include '@phpbb_collapsiblecategories/collapsible_categories_button.html' %}
++	{% endif %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_row_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_row_append.html"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+new file mode 100644
+index 000000000..f9c24ff43
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+@@ -0,0 +1,2 @@
++{% INCLUDECSS '@phpbb_collapsiblecategories/collapsiblecategories.css' %}
++{% INCLUDEJS '@phpbb_collapsiblecategories/js/collapsiblecategories.js' %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/js/collapsiblecategories.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/js/collapsiblecategories.js"
+new file mode 100644
+index 000000000..d2dd0c00f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/js/collapsiblecategories.js"
+@@ -0,0 +1,57 @@
++head.ready(function() {
++	(function($) { // Avoid conflicts with other libraries
++
++		'use strict';
++
++		// Get the collapsible element (has class .topiclist.forums OR .collapsible)
++		$.fn.getCollapsible = function(opt) {
++			if(opt)
++				return this.next('.panel').find('.panel-inner').eq(0);
++			else
++				return this.closest('.panel').find('.panel-inner').eq(0);
++		};
++
++		$('a.collapse-btn').each(function() {
++			var $this = $(this),
++				hidden = $this.attr('data-hidden'),
++				$content = $this.getCollapsible(true),
++				category = $this.next('.panel').find('.panel-heading'),
++				position = 'append';
++
++			// Return if no collapsible content could be found
++			if (!$content.length) {
++				return;
++			}
++
++			// Unhide the collapse buttons (makes them JS dependent)
++			$this.show();
++
++			// Hide hidden forums on load
++			if (hidden) {
++				$content.hide();
++			}
++
++			category[position].apply(category, [$this]);
++		});
++
++		phpbb.addAjaxCallback('phpbb_collapse', function(res) {
++			if (res.success) {
++				var oldTitle = $(this).attr('title'),
++					newTitle = $(this).attr('data-title-alt');
++				$(this)
++					.attr({
++						'title': newTitle,
++						'data-title-alt': oldTitle
++					})
++					.find('i')
++					.toggleClass('fa-plus fa-minus')
++					.end()
++					.getCollapsible(false)
++					.stop(true, true)
++					.slideToggle('fast')
++				;
++			}
++		});
++
++	})(jQuery); // Avoid conflicts with other libraries
++});
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/theme/collapsiblecategories.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/theme/collapsiblecategories.css"
+new file mode 100644
+index 000000000..22df4fc62
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/theme/collapsiblecategories.css"
+@@ -0,0 +1,17 @@
++/* Hide the forums of a hidden category */
++.hidden-category,
++.hidden-category + .panel .collapsible,
++.hidden-category + .panel .panel-inner {
++	display: none;
++}
++
++/* Collapse button */
++.collapse-btn {
++	position: relative;
++	float: right;
++	margin: 0 10px;
++}
++
++.rtl .collapse-btn {
++	float: left;
++}
diff --git "[FORUM_EXT]/phpbb\\collapsiblecategories/diff_nospace.tmp" "[FORUM_EXT]/phpbb\\collapsiblecategories/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\collapsiblecategories/diff_nospace.tmp"
@@ -0,0 +1,229 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/diff_full.tmp"
+new file mode 100644
+index 000000000..ae24f93b4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/diff_full.tmp"
+@@ -0,0 +1,245 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/collapsible_categories_button.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/collapsible_categories_button.html"
++new file mode 100644
++index 000000000..c72cf9d54
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/collapsible_categories_button.html"
++@@ -0,0 +1 @@
+++<a href="{{ U_CC_COLLAPSE_URL }}" class="collapse-btn" data-hidden="{{ S_CC_FORUM_HIDDEN }}" data-ajax="phpbb_collapse" data-overlay="true"><i class="fa {% if S_CC_FORUM_HIDDEN %}fa-plus{% else %}fa-minus{% endif %}"></i></a>
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_before.html"
++new file mode 100644
++index 000000000..8fa479547
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_before.html"
++@@ -0,0 +1,8 @@
+++{% if forumrow.S_IS_CAT or forumrow.S_FIRST_ROW or forumrow.S_NO_CAT %}
+++	<a class="category{% if forumrow.S_FORUM_HIDDEN %} hidden-category{% endif %}" id="category{{ forumrow.FORUM_ID }}" style="display: none; height: 0"></a>
+++{% if not S_IS_BOT %}
+++	{% set S_CC_FORUM_HIDDEN = forumrow.S_FORUM_HIDDEN %}
+++	{% set U_CC_COLLAPSE_URL = forumrow.U_COLLAPSE_URL %}
+++	{% include '@phpbb_collapsiblecategories/collapsible_categories_button.html' %}
+++{% endif %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_row_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_row_append.html"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/overall_header_head_append.html"
++new file mode 100644
++index 000000000..f9c24ff43
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/event/overall_header_head_append.html"
++@@ -0,0 +1,2 @@
+++{% INCLUDECSS '@phpbb_collapsiblecategories/collapsiblecategories.css' %}
+++{% INCLUDEJS '@phpbb_collapsiblecategories/js/collapsiblecategories.js' %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/js/collapsiblecategories.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/js/collapsiblecategories.js"
++new file mode 100644
++index 000000000..1ca53b1ed
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/template/js/collapsiblecategories.js"
++@@ -0,0 +1,54 @@
+++head.ready(function() {
+++	(function($) { // Avoid conflicts with other libraries
+++
+++		'use strict';
+++
+++		// Get the collapsible element (has class .topiclist.forums OR .collapsible)
+++		$.fn.getCollapsible = function(opt) {
+++			if(opt)
+++				return this.next('.panel').find('table tbody');
+++			else
+++				return this.closest('.panel').find('table tbody');
+++		};
+++
+++		$('a.collapse-btn').each(function() {
+++			var $this = $(this),
+++				hidden = $this.attr('data-hidden'),
+++				$content = $this.getCollapsible(true),
+++				category = $this.next('.panel').find('table thead th:last-child'),
+++				position = 'append';
+++
+++			// Return if no collapsible content could be found
+++			if (!$content.length) {
+++				return;
+++			}
+++
+++			// Unhide the collapse buttons (makes them JS dependent)
+++			$this.show();
+++
+++			// Hide hidden forums on load
+++			if (hidden) {
+++				$content.hide();
+++			}
+++
+++			category[position].apply(category, [$this]);
+++		});
+++
+++		phpbb.addAjaxCallback('phpbb_collapse', function(res) {
+++			if (res.success) {
+++				var oldTitle = $(this).attr('title'),
+++					newTitle = $(this).attr('data-title-alt');
+++				$(this)
+++					.attr({'title': newTitle, 'data-title-alt': oldTitle})
+++					.find('i')
+++					.toggleClass('fa-plus fa-minus')
+++					.end()
+++					.getCollapsible(false)
+++					.stop(true, true)
+++					.slideToggle('fast')
+++				;
+++			}
+++		});
+++
+++	})(jQuery); // Avoid conflicts with other libraries
+++});
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/theme/collapsiblecategories.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/theme/collapsiblecategories.css"
++new file mode 100644
++index 000000000..1556a9cd0
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/BBOOTS/theme/collapsiblecategories.css"
++@@ -0,0 +1,17 @@
+++/* Hide the forums of a hidden category */
+++.hidden-category,
+++.hidden-category + .panel .collapsible,
+++.hidden-category + .panel tbody {
+++	display: none;
+++}
+++
+++/* Collapse button */
+++.collapse-btn {
+++	position: relative;
+++	float: right;
+++	margin: 0 10px;
+++}
+++
+++.rtl .collapse-btn {
+++	float: left;
+++}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/collapsible_categories_button.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/collapsible_categories_button.html"
++new file mode 100644
++index 000000000..b07877cde
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/collapsible_categories_button.html"
++@@ -0,0 +1,9 @@
+++<a href="{{ U_CC_COLLAPSE_URL }}" 
+++   class="collapse-btn" 
+++   data-hidden="{{ S_CC_FORUM_HIDDEN }}" 
+++   data-ajax="phpbb_collapse" 
+++   data-overlay="true"
+++   data-title-alt="{{ lang(L_CC_BUTTON_TITLE, not S_CC_FORUM_HIDDEN ? 1 : 0) }}"
+++   title="{{ lang(L_CC_BUTTON_TITLE, S_CC_FORUM_HIDDEN ? 1 : 0) }}">
+++	<i class="fa {% if S_CC_FORUM_HIDDEN %}fa-plus{% else %}fa-minus{% endif %}"></i>
+++</a>
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_before.html"
++new file mode 100644
++index 000000000..211cb21f1
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_before.html"
++@@ -0,0 +1,9 @@
+++{% if forumrow.S_IS_CAT or forumrow.S_FIRST_ROW or forumrow.S_NO_CAT %}
+++	<a class="category{% if forumrow.S_FORUM_HIDDEN %} hidden-category{% endif %}" id="category{{ forumrow.FORUM_ID }}" style="display: none; height: 0"></a>
+++	{% if not S_IS_BOT %}
+++		{% set S_CC_FORUM_HIDDEN = forumrow.S_FORUM_HIDDEN %}
+++		{% set U_CC_COLLAPSE_URL = forumrow.U_COLLAPSE_URL %}
+++		{% set L_CC_BUTTON_TITLE = 'COLLAPSIBLE_CATEGORIES_TITLE' %}
+++		{% include '@phpbb_collapsiblecategories/collapsible_categories_button.html' %}
+++	{% endif %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_row_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_row_append.html"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++new file mode 100644
++index 000000000..f9c24ff43
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++@@ -0,0 +1,2 @@
+++{% INCLUDECSS '@phpbb_collapsiblecategories/collapsiblecategories.css' %}
+++{% INCLUDEJS '@phpbb_collapsiblecategories/js/collapsiblecategories.js' %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/js/collapsiblecategories.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/js/collapsiblecategories.js"
++new file mode 100644
++index 000000000..d2dd0c00f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\collapsiblecategories/styles/FLATBOOTS/template/js/collapsiblecategories.js"
++@@ -0,0 +1,57 @@
+++head.ready(function() {
+++	(function($) { // Avoid conflicts with other libraries
+++
+++		'use strict';
+++
+++		// Get the collapsible element (has class .topiclist.forums OR .collapsible)
+++		$.fn.getCollapsible = function(opt) {
+++			if(opt)
+++				return this.next('.panel').find('.panel-inner').eq(0);
+++			else
+++				return this.closest('.panel').find('.panel-inner').eq(0);
+++		};
+++
+++		$('a.collapse-btn').each(function() {
+++			var $this = $(this),
+++				hidden = $this.attr('data-hidden'),
+++				$content = $this.getCollapsible(true),
+++				category = $this.next('.panel').find('.panel-heading'),
+++				position = 'append';
+++
+++			// Return if no collapsible content could be found
+++			if (!$content.length) {
+++				return;
+++			}
+++
+++			// Unhide the collapse buttons (makes them JS dependent)
+++			$this.show();
+++
+++			// Hide hidden forums on load
+++			if (hidden) {
+++				$content.hide();
+++			}
+++
+++			category[position].apply(category, [$this]);
+++		});
+++
+++		phpbb.addAjaxCallback('phpbb_collapse', function(res) {
+++			if (res.success) {
+++				var oldTitle = $(this).attr('title'),
+++					newTitle = $(this).attr('data-title-alt');
+++				$(this)
+++					.attr({
+++						'title': newTitle,
+++						'data-title-alt': oldTitle
+++					})
+++					.find('i')
+++					.toggleClass('fa-plus fa-minus')
+++					.end()
+++					.getCollapsible(false)
+++					.stop(true, true)
+++					.slideToggle('fast')
+++				;
+++			}
+++		});
+++
+++	})(jQuery); // Avoid conflicts with other libraries
+++});
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-php
\ No newline at end of file
diff --git "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/template/collapsible_categories_button.html" "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/template/collapsible_categories_button.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/template/collapsible_categories_button.html"
@@ -0,0 +1 @@
+<a href="{{ U_CC_COLLAPSE_URL }}" class="collapse-btn" data-hidden="{{ S_CC_FORUM_HIDDEN }}" data-ajax="phpbb_collapse" data-overlay="true"><i class="fa {% if S_CC_FORUM_HIDDEN %}fa-plus{% else %}fa-minus{% endif %}"></i></a>
diff --git "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_before.html" "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_before.html"
@@ -0,0 +1,8 @@
+{% if forumrow.S_IS_CAT or forumrow.S_FIRST_ROW or forumrow.S_NO_CAT %}
+	<a class="category{% if forumrow.S_FORUM_HIDDEN %} hidden-category{% endif %}" id="category{{ forumrow.FORUM_ID }}" style="display: none; height: 0"></a>
+{% if not S_IS_BOT %}
+	{% set S_CC_FORUM_HIDDEN = forumrow.S_FORUM_HIDDEN %}
+	{% set U_CC_COLLAPSE_URL = forumrow.U_COLLAPSE_URL %}
+	{% include '@phpbb_collapsiblecategories/collapsible_categories_button.html' %}
+{% endif %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_row_append.html" "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/template/event/forumlist_body_category_header_row_append.html"
new file mode 100644
diff --git "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/template/event/overall_header_head_append.html" "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/template/event/overall_header_head_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/template/event/overall_header_head_append.html"
@@ -0,0 +1,2 @@
+{% INCLUDECSS '@phpbb_collapsiblecategories/collapsiblecategories.css' %}
+{% INCLUDEJS '@phpbb_collapsiblecategories/js/collapsiblecategories.js' %}
diff --git "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/template/js/collapsiblecategories.js" "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/template/js/collapsiblecategories.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/template/js/collapsiblecategories.js"
@@ -0,0 +1,54 @@
+head.ready(function() {
+	(function($) { // Avoid conflicts with other libraries
+
+		'use strict';
+
+		// Get the collapsible element (has class .topiclist.forums OR .collapsible)
+		$.fn.getCollapsible = function(opt) {
+			if(opt)
+				return this.next('.panel').find('table tbody');
+			else
+				return this.closest('.panel').find('table tbody');
+		};
+
+		$('a.collapse-btn').each(function() {
+			var $this = $(this),
+				hidden = $this.attr('data-hidden'),
+				$content = $this.getCollapsible(true),
+				category = $this.next('.panel').find('table thead th:last-child'),
+				position = 'append';
+
+			// Return if no collapsible content could be found
+			if (!$content.length) {
+				return;
+			}
+
+			// Unhide the collapse buttons (makes them JS dependent)
+			$this.show();
+
+			// Hide hidden forums on load
+			if (hidden) {
+				$content.hide();
+			}
+
+			category[position].apply(category, [$this]);
+		});
+
+		phpbb.addAjaxCallback('phpbb_collapse', function(res) {
+			if (res.success) {
+				var oldTitle = $(this).attr('title'),
+					newTitle = $(this).attr('data-title-alt');
+				$(this)
+					.attr({'title': newTitle, 'data-title-alt': oldTitle})
+					.find('i')
+					.toggleClass('fa-plus fa-minus')
+					.end()
+					.getCollapsible(false)
+					.stop(true, true)
+					.slideToggle('fast')
+				;
+			}
+		});
+
+	})(jQuery); // Avoid conflicts with other libraries
+});
diff --git "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/theme/collapsiblecategories.css" "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/theme/collapsiblecategories.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/BBOOTS/theme/collapsiblecategories.css"
@@ -0,0 +1,17 @@
+/* Hide the forums of a hidden category */
+.hidden-category,
+.hidden-category + .panel .collapsible,
+.hidden-category + .panel tbody {
+	display: none;
+}
+
+/* Collapse button */
+.collapse-btn {
+	position: relative;
+	float: right;
+	margin: 0 10px;
+}
+
+.rtl .collapse-btn {
+	float: left;
+}
diff --git "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/template/collapsible_categories_button.html" "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/template/collapsible_categories_button.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/template/collapsible_categories_button.html"
@@ -0,0 +1,9 @@
+<a href="{{ U_CC_COLLAPSE_URL }}" 
+   class="collapse-btn" 
+   data-hidden="{{ S_CC_FORUM_HIDDEN }}" 
+   data-ajax="phpbb_collapse" 
+   data-overlay="true"
+   data-title-alt="{{ lang(L_CC_BUTTON_TITLE, not S_CC_FORUM_HIDDEN ? 1 : 0) }}"
+   title="{{ lang(L_CC_BUTTON_TITLE, S_CC_FORUM_HIDDEN ? 1 : 0) }}">
+	<i class="fa {% if S_CC_FORUM_HIDDEN %}fa-plus{% else %}fa-minus{% endif %}"></i>
+</a>
diff --git "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_before.html" "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_before.html"
@@ -0,0 +1,9 @@
+{% if forumrow.S_IS_CAT or forumrow.S_FIRST_ROW or forumrow.S_NO_CAT %}
+	<a class="category{% if forumrow.S_FORUM_HIDDEN %} hidden-category{% endif %}" id="category{{ forumrow.FORUM_ID }}" style="display: none; height: 0"></a>
+	{% if not S_IS_BOT %}
+		{% set S_CC_FORUM_HIDDEN = forumrow.S_FORUM_HIDDEN %}
+		{% set U_CC_COLLAPSE_URL = forumrow.U_COLLAPSE_URL %}
+		{% set L_CC_BUTTON_TITLE = 'COLLAPSIBLE_CATEGORIES_TITLE' %}
+		{% include '@phpbb_collapsiblecategories/collapsible_categories_button.html' %}
+	{% endif %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_row_append.html" "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/forumlist_body_category_header_row_append.html"
new file mode 100644
diff --git "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/overall_header_head_append.html" "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/overall_header_head_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/template/event/overall_header_head_append.html"
@@ -0,0 +1,2 @@
+{% INCLUDECSS '@phpbb_collapsiblecategories/collapsiblecategories.css' %}
+{% INCLUDEJS '@phpbb_collapsiblecategories/js/collapsiblecategories.js' %}
diff --git "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/template/js/collapsiblecategories.js" "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/template/js/collapsiblecategories.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/template/js/collapsiblecategories.js"
@@ -0,0 +1,57 @@
+head.ready(function() {
+	(function($) { // Avoid conflicts with other libraries
+
+		'use strict';
+
+		// Get the collapsible element (has class .topiclist.forums OR .collapsible)
+		$.fn.getCollapsible = function(opt) {
+			if(opt)
+				return this.next('.panel').find('.panel-inner').eq(0);
+			else
+				return this.closest('.panel').find('.panel-inner').eq(0);
+		};
+
+		$('a.collapse-btn').each(function() {
+			var $this = $(this),
+				hidden = $this.attr('data-hidden'),
+				$content = $this.getCollapsible(true),
+				category = $this.next('.panel').find('.panel-heading'),
+				position = 'append';
+
+			// Return if no collapsible content could be found
+			if (!$content.length) {
+				return;
+			}
+
+			// Unhide the collapse buttons (makes them JS dependent)
+			$this.show();
+
+			// Hide hidden forums on load
+			if (hidden) {
+				$content.hide();
+			}
+
+			category[position].apply(category, [$this]);
+		});
+
+		phpbb.addAjaxCallback('phpbb_collapse', function(res) {
+			if (res.success) {
+				var oldTitle = $(this).attr('title'),
+					newTitle = $(this).attr('data-title-alt');
+				$(this)
+					.attr({
+						'title': newTitle,
+						'data-title-alt': oldTitle
+					})
+					.find('i')
+					.toggleClass('fa-plus fa-minus')
+					.end()
+					.getCollapsible(false)
+					.stop(true, true)
+					.slideToggle('fast')
+				;
+			}
+		});
+
+	})(jQuery); // Avoid conflicts with other libraries
+});
diff --git "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/theme/collapsiblecategories.css" "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/theme/collapsiblecategories.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\collapsiblecategories/styles/FLATBOOTS/theme/collapsiblecategories.css"
@@ -0,0 +1,17 @@
+/* Hide the forums of a hidden category */
+.hidden-category,
+.hidden-category + .panel .collapsible,
+.hidden-category + .panel .panel-inner {
+	display: none;
+}
+
+/* Collapse button */
+.collapse-btn {
+	position: relative;
+	float: right;
+	margin: 0 10px;
+}
+
+.rtl .collapse-btn {
+	float: left;
+}
```
