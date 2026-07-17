Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\bbsort/composer.json" "[FORUM_EXT]/sitesplat\\bbsort/composer.json"
--- "[ORIGINAL]/sitesplat\\bbsort/composer.json"
+++ "[FORUM_EXT]/sitesplat\\bbsort/composer.json"
@@ -25,7 +25,8 @@
 		"version-check": {
 			"host": "sitesplat.com",
 			"directory": "/updatecheck/phpbb32/ext",
-            "filename": "bbsort.json"
+			"filename": "bbsort.json",
+			"ssl": true
 		}
 	}
 }
diff --git "[FORUM_EXT]/sitesplat\\bbsort/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bbsort/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbsort/diff_full.tmp"
@@ -0,0 +1,517 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/composer.json"
+index 10bac0935..9f2dc0b21 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/composer.json"
+@@ -1,11 +1,11 @@
+ {
+-    "name": "sitesplat/bbsort",
+-    "type": "phpbb-extension",
+-    "description": "Allows quick sorting for the viewforum  page, title, views last post etc. It also adds a new pagination system where the pages can be scrolled on click.",
+-    "homepage": "http://sitesplat.com",
+-    "version": "1.0.0",
+-    "time": "2017-01-19",
+-    "keywords": ["phpbb", "extension", "pagination", "search"],
++	"name": "sitesplat/bbsort",
++	"type": "phpbb-extension",
++	"description": "Allows quick sorting for the viewforum  page, title, views last post etc. It also adds a new pagination system where the pages can be scrolled on click.",
++	"homepage": "http://sitesplat.com",
++	"version": "1.0.0",
++	"time": "2017-01-19",
++	"keywords": ["phpbb", "extension", "pagination", "search"],
+ 	"license": "Proprietary/All rights reserved",
+ 	"authors": [
+ 		{
+@@ -14,18 +14,19 @@
+ 			"homepage": "http://sitesplat.com"
+ 		}
+ 	],
+-    "require": {
+-        "php": ">=5.4"
+-    },
+-    "extra": {
+-        "display-name": "BBsort",
+-        "soft-require": {
+-            "phpbb/phpbb": ">=3.1.0,<3.3.0@dev"
+-        },
++	"require": {
++		"php": ">=5.4"
++	},
++	"extra": {
++		"display-name": "BBsort",
++		"soft-require": {
++		"phpbb/phpbb": ">=3.1.0,<3.3.0@dev"
++		},
+ 		"version-check": {
+-            "host": "sitesplat.com",
+-            "directory": "/updatecheck/phpbb32/ext",
+-            "filename": "bbsort.json"
++			"host": "sitesplat.com",
++			"directory": "/updatecheck/phpbb32/ext",
++			"filename": "bbsort.json",
++			"ssl": true
+ 		}
+-    }
++	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/event/main_listener.php"
+index 50bda426d..4e671da34 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/event/main_listener.php"
+@@ -37,9 +37,9 @@ class main_listener implements EventSubscriberInterface
+ 	{
+ 		$default_url = "{$this->root_path}viewforum.{$this->php_ext}?f={$event['forum_id']}";
+ 		$this->template->assign_vars(array(
+-			'L_TITLE'	=> '<a href="' . append_sid($default_url . '&amp;sk=t&amp;sd=' . (($event['sort_dir'] == 'a') ? 'd' : 'a')) . '">' . $this->language->lang('TITLE') . '</a>',
+-			'L_TOPICS_POSTS_STATISTICS'	=> '<a href="' . append_sid($default_url . '&amp;sk=v&amp;sd=' . (($event['sort_dir'] == 'a') ? 'd' : 'a')) . '">' . $this->language->lang('TOPICS_POSTS_STATISTICS') . '</a>',
+-			'L_LAST_POST'	=> '<a href="' . append_sid($default_url . '&amp;sk=r&amp;sd=' . (($event['sort_dir'] == 'a') ? 'd' : 'a')) . '">' . $this->language->lang('LAST_POST') . '</a>',
++			'L_TITLE'	=> '<a href="' . append_sid($default_url . '&amp;sk=s&amp;sd=' . ($event['sort_dir'] == 'a' ? 'd' : 'a')) . '">' . $this->language->lang('TITLE') . ($event['sort_key'] == 's' ? '&nbsp;<i class="fa fa-sort-alpha-'.($event['sort_dir'] == 'a' ? 'desc' : 'asc').'" aria-hidden="true"></i></a>' : '</a>'),
++			'L_TOPICS_POSTS_STATISTICS'	=> '<a href="' . append_sid($default_url . '&amp;sk=v&amp;sd=' . ($event['sort_dir'] == 'a' ? 'd' : 'a')) . '">' . $this->language->lang('TOPICS_POSTS_STATISTICS') . ($event['sort_key'] == 'v' ? '&nbsp;<i class="fa fa-sort-numeric-'.($event['sort_dir'] == 'a' ? 'asc' : 'desc').'" aria-hidden="true"></i></a>' : '</a>'),
++			'L_LAST_POST'	=> '<a href="' . append_sid($default_url . '&amp;sk=t&amp;sd=' . ($event['sort_dir'] == 'a' ? 'd' : 'a')) . '">' . $this->language->lang('LAST_POST') . ($event['sort_key'] == 't' ? '&nbsp;<i class="fa fa-sort-alpha-'.($event['sort_dir'] == 'a' ? 'desc' : 'asc').'" aria-hidden="true"></i></a>' : '</a>'),
+ 		));
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.bak.js"
+new file mode 100644
+index 000000000..cab42b4a6
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.bak.js"
+@@ -0,0 +1,180 @@
++head.ready(function(){
++    var base_url = (window.location.href.indexOf('start=') === -1) ? window.location.href + '&start=0' : window.location.href;
++    $('.pagination.pagination-sm.hidden-xs').each(function(){
++        var self = this;
++
++        function display_left_arrow() {
++            $(self).find('.left-arrow a').attr('style', '');
++        }
++        function hide_left_arrow() {
++            $(self).find('.left-arrow a').css({
++                width: 0,
++                borderLeft: 'none',
++                borderRight: 'none',
++                paddingLeft: '0',
++                paddingRight: '0'
++            });
++        }
++
++        function display_right_arrow() {
++            $(self).find('.right-arrow a').attr('style', '');
++        }
++        function hide_right_arrow() {
++            $(self).find('.right-arrow a').css({
++                width: 0,
++                borderLeft: 'none',
++                borderRight: 'none',
++                paddingLeft: '0',
++                paddingRight: '0'
++            });
++        }
++
++        function set_new_pagination_offset(current_pagination_start) {
++            // current item offset
++            var current_position = $(self).find('.pagination-inline a').eq(current_pagination_start).offset().left;
++            // parent's offset (first parent is floating, so calculate second parent)
++            var parent_position = $(self).find('.pagination-inline a').eq(current_pagination_start).parent().parent().offset().left;
++            // animate new offset
++            $(self).find('.pagination-inline').css('margin-left', -(current_position - parent_position));
++        }
++
++        function set_new_wrapper_width(current_pagination_start, direction) {
++            var new_width = 0;
++            var selector = $(self).find('.pagination-inline li')
++            if (current_pagination_start == 0) {
++                selector = selector.eq(current_pagination_start).nextAll(':lt(4)').addBack();
++            } else {
++                selector = selector.eq(current_pagination_start - 1).nextAll(':lt(5)');
++            }
++            selector.each(function(){
++                new_width += parseInt($(this).find('a').outerWidth());
++            });
++            // magic 8 is substracted (maybe margins?)
++            $(self).find('.wrapped').css('width', new_width - 8);
++        }
++
++        function check_pagination_limits(current_pagination_start) {
++            if (current_pagination_start < 0) {
++                return 0;
++            }
++            // if new pagination start exceeds total pages, align to last 5 items
++            // note, that we need to add 2 items because first and last items are always displayed
++            if (current_pagination_start > pages_total - 7) {
++                return pages_total - 7;
++            }
++
++            return current_pagination_start;
++        }
++
++        function hide_arrows(current_pagination_start) {
++            if (current_pagination_start == 0) {
++                hide_left_arrow();
++            }
++            if (current_pagination_start == pages_total - 7) {
++                hide_right_arrow();
++            }
++        }
++
++        // direction: 1 - right, -1 - left
++        function on_arrow_click(current_pagination_start, direction) {
++            current_pagination_start = current_pagination_start + (5 * direction);
++            current_pagination_start = check_pagination_limits(current_pagination_start);
++
++            hide_arrows(current_pagination_start);
++            (direction == 1) ? display_left_arrow() : display_right_arrow();
++            
++            set_new_pagination_offset(current_pagination_start);
++            set_new_wrapper_width(current_pagination_start, direction);
++
++            return current_pagination_start;
++        }
++
++        var per_page; // how many items per page?
++        var current_page;
++        var pages_total;
++        
++        var $ellipsis = $(this).find('.ellipsis');
++        // no ellipsis? No extended pagination.
++        if ($ellipsis.length < 1) {
++            return;
++        }
++        var $active = $(this).find('.active');
++        // second $active is correct one on viewtopic. So if only one is present, we stop
++        if ($('.section-viewtopic').length && $active.length == 1) {
++            return;
++        }
++        // number of posts is also marked as active, so select the correct one on viewtopic
++        if ($active.length > 1) {
++            $active = $active.eq(1);
++        }
++
++        
++
++        // resolve per_page
++        var $first;
++        var $second;
++        // 2 ellipsis means active is in the middle OR 1 ellipsis on the left
++        if ($ellipsis.length > 1 || ($ellipsis.length == 1 && $ellipsis.nextAll('.active').length)) {
++            $first = $active.prev();
++            $second = $active.prev().prev();
++        }
++        // 1 ellipsis on the right
++        else if ($ellipsis.length == 1) {
++            $first = $active.next();
++            $second = $active.next().next();
++        }
++        var next_start = parseInt($first.find('a').attr('href').split('=').pop());
++        var next_next_start = parseInt($second.find('a').attr('href').split('=').pop());
++        per_page = next_next_start - next_start;
++        
++        // resolve current_page
++        current_page = parseInt($active.find('a').text());
++
++        // resolve pages_total
++        pages_total = parseInt($(self).find('a:not([rel="next"]):last').text());
++
++        // all required variables resolved
++        if (per_page && current_page && pages_total) {
++            // replace ellipsis with actual pages
++            $ellipsis.each(function(){
++                var replacement = '';
++                for (var i = parseInt($(this).prev().text()) + 1; i < parseInt($(this).next().text()); i++) {
++                    replacement += '<li><a href="' + base_url.replace(/start=(\d+)/, 'start=' + ((i - 1) * per_page)) + '">' + i + '</a></li>'
++                }
++                $(this).replaceWith(replacement);
++            });
++
++            // wrap pages
++            $first = $(self).find('*').filter(function(){
++                return $(this).text() == '1';
++            });
++            $last = $(self).find('*').filter(function(){
++                return $(this).text() == pages_total;
++            });
++            var pages = $first.nextUntil($last);
++            pages.wrapAll('<li class="wrapped"><ul class="pagination pagination-inline"></ul></li>');
++
++            // add arrows
++            $(self).find('.wrapped').before('<li class="left-arrow"><a>←</a></li>');
++            $(self).find('.wrapped').after('<li class="right-arrow"><a>→</a></li>');
++
++            var current_pagination_start = parseInt($active.find('a').text()) - 2;
++            // allign current pagination start into blocks of 5
++            current_pagination_start = Math.floor(current_pagination_start / 5) * 5;
++            current_pagination_start = check_pagination_limits(current_pagination_start);
++            hide_arrows(current_pagination_start);
++            set_new_pagination_offset(current_pagination_start);
++            set_new_wrapper_width(current_pagination_start);
++
++            // left arrow click
++            $(this).find('.left-arrow').on('click', function(){
++                current_pagination_start = on_arrow_click(current_pagination_start, -1);
++            });
++
++            // right arrow click
++            $(this).find('.right-arrow').on('click', function(){
++                current_pagination_start = on_arrow_click(current_pagination_start, 1);
++            });
++        }
++    });
++});
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.js"
+index cab42b4a6..8c44d207a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.js"
+@@ -1,180 +1 @@
+-head.ready(function(){
+-    var base_url = (window.location.href.indexOf('start=') === -1) ? window.location.href + '&start=0' : window.location.href;
+-    $('.pagination.pagination-sm.hidden-xs').each(function(){
+-        var self = this;
+-
+-        function display_left_arrow() {
+-            $(self).find('.left-arrow a').attr('style', '');
+-        }
+-        function hide_left_arrow() {
+-            $(self).find('.left-arrow a').css({
+-                width: 0,
+-                borderLeft: 'none',
+-                borderRight: 'none',
+-                paddingLeft: '0',
+-                paddingRight: '0'
+-            });
+-        }
+-
+-        function display_right_arrow() {
+-            $(self).find('.right-arrow a').attr('style', '');
+-        }
+-        function hide_right_arrow() {
+-            $(self).find('.right-arrow a').css({
+-                width: 0,
+-                borderLeft: 'none',
+-                borderRight: 'none',
+-                paddingLeft: '0',
+-                paddingRight: '0'
+-            });
+-        }
+-
+-        function set_new_pagination_offset(current_pagination_start) {
+-            // current item offset
+-            var current_position = $(self).find('.pagination-inline a').eq(current_pagination_start).offset().left;
+-            // parent's offset (first parent is floating, so calculate second parent)
+-            var parent_position = $(self).find('.pagination-inline a').eq(current_pagination_start).parent().parent().offset().left;
+-            // animate new offset
+-            $(self).find('.pagination-inline').css('margin-left', -(current_position - parent_position));
+-        }
+-
+-        function set_new_wrapper_width(current_pagination_start, direction) {
+-            var new_width = 0;
+-            var selector = $(self).find('.pagination-inline li')
+-            if (current_pagination_start == 0) {
+-                selector = selector.eq(current_pagination_start).nextAll(':lt(4)').addBack();
+-            } else {
+-                selector = selector.eq(current_pagination_start - 1).nextAll(':lt(5)');
+-            }
+-            selector.each(function(){
+-                new_width += parseInt($(this).find('a').outerWidth());
+-            });
+-            // magic 8 is substracted (maybe margins?)
+-            $(self).find('.wrapped').css('width', new_width - 8);
+-        }
+-
+-        function check_pagination_limits(current_pagination_start) {
+-            if (current_pagination_start < 0) {
+-                return 0;
+-            }
+-            // if new pagination start exceeds total pages, align to last 5 items
+-            // note, that we need to add 2 items because first and last items are always displayed
+-            if (current_pagination_start > pages_total - 7) {
+-                return pages_total - 7;
+-            }
+-
+-            return current_pagination_start;
+-        }
+-
+-        function hide_arrows(current_pagination_start) {
+-            if (current_pagination_start == 0) {
+-                hide_left_arrow();
+-            }
+-            if (current_pagination_start == pages_total - 7) {
+-                hide_right_arrow();
+-            }
+-        }
+-
+-        // direction: 1 - right, -1 - left
+-        function on_arrow_click(current_pagination_start, direction) {
+-            current_pagination_start = current_pagination_start + (5 * direction);
+-            current_pagination_start = check_pagination_limits(current_pagination_start);
+-
+-            hide_arrows(current_pagination_start);
+-            (direction == 1) ? display_left_arrow() : display_right_arrow();
+-            
+-            set_new_pagination_offset(current_pagination_start);
+-            set_new_wrapper_width(current_pagination_start, direction);
+-
+-            return current_pagination_start;
+-        }
+-
+-        var per_page; // how many items per page?
+-        var current_page;
+-        var pages_total;
+-        
+-        var $ellipsis = $(this).find('.ellipsis');
+-        // no ellipsis? No extended pagination.
+-        if ($ellipsis.length < 1) {
+-            return;
+-        }
+-        var $active = $(this).find('.active');
+-        // second $active is correct one on viewtopic. So if only one is present, we stop
+-        if ($('.section-viewtopic').length && $active.length == 1) {
+-            return;
+-        }
+-        // number of posts is also marked as active, so select the correct one on viewtopic
+-        if ($active.length > 1) {
+-            $active = $active.eq(1);
+-        }
+-
+-        
+-
+-        // resolve per_page
+-        var $first;
+-        var $second;
+-        // 2 ellipsis means active is in the middle OR 1 ellipsis on the left
+-        if ($ellipsis.length > 1 || ($ellipsis.length == 1 && $ellipsis.nextAll('.active').length)) {
+-            $first = $active.prev();
+-            $second = $active.prev().prev();
+-        }
+-        // 1 ellipsis on the right
+-        else if ($ellipsis.length == 1) {
+-            $first = $active.next();
+-            $second = $active.next().next();
+-        }
+-        var next_start = parseInt($first.find('a').attr('href').split('=').pop());
+-        var next_next_start = parseInt($second.find('a').attr('href').split('=').pop());
+-        per_page = next_next_start - next_start;
+-        
+-        // resolve current_page
+-        current_page = parseInt($active.find('a').text());
+-
+-        // resolve pages_total
+-        pages_total = parseInt($(self).find('a:not([rel="next"]):last').text());
+-
+-        // all required variables resolved
+-        if (per_page && current_page && pages_total) {
+-            // replace ellipsis with actual pages
+-            $ellipsis.each(function(){
+-                var replacement = '';
+-                for (var i = parseInt($(this).prev().text()) + 1; i < parseInt($(this).next().text()); i++) {
+-                    replacement += '<li><a href="' + base_url.replace(/start=(\d+)/, 'start=' + ((i - 1) * per_page)) + '">' + i + '</a></li>'
+-                }
+-                $(this).replaceWith(replacement);
+-            });
+-
+-            // wrap pages
+-            $first = $(self).find('*').filter(function(){
+-                return $(this).text() == '1';
+-            });
+-            $last = $(self).find('*').filter(function(){
+-                return $(this).text() == pages_total;
+-            });
+-            var pages = $first.nextUntil($last);
+-            pages.wrapAll('<li class="wrapped"><ul class="pagination pagination-inline"></ul></li>');
+-
+-            // add arrows
+-            $(self).find('.wrapped').before('<li class="left-arrow"><a>←</a></li>');
+-            $(self).find('.wrapped').after('<li class="right-arrow"><a>→</a></li>');
+-
+-            var current_pagination_start = parseInt($active.find('a').text()) - 2;
+-            // allign current pagination start into blocks of 5
+-            current_pagination_start = Math.floor(current_pagination_start / 5) * 5;
+-            current_pagination_start = check_pagination_limits(current_pagination_start);
+-            hide_arrows(current_pagination_start);
+-            set_new_pagination_offset(current_pagination_start);
+-            set_new_wrapper_width(current_pagination_start);
+-
+-            // left arrow click
+-            $(this).find('.left-arrow').on('click', function(){
+-                current_pagination_start = on_arrow_click(current_pagination_start, -1);
+-            });
+-
+-            // right arrow click
+-            $(this).find('.right-arrow').on('click', function(){
+-                current_pagination_start = on_arrow_click(current_pagination_start, 1);
+-            });
+-        }
+-    });
+-});
+\ No newline at end of file
++head.ready(function(){var t=-1===window.location.href.indexOf("start=")?window.location.href+"&start=0":window.location.href;$(".pagination.pagination-sm.hidden-xs").each(function(){var n,i,e,a=this;function r(t){var n=$(a).find(".pagination-inline a").eq(t).offset().left,i=$(a).find(".pagination-inline a").eq(t).parent().parent().offset().left;$(a).find(".pagination-inline").css("margin-left",-(n-i))}function f(t,n){var i=0,e=$(a).find(".pagination-inline li");(e=0==t?e.eq(t).nextAll(":lt(4)").addBack():e.eq(t-1).nextAll(":lt(5)")).each(function(){i+=parseInt($(this).find("a").outerWidth())}),$(a).find(".wrapped").css("width",i-8)}function l(t){return t<0?0:t>e-7?e-7:t}function o(t){0==t&&$(a).find(".left-arrow a").css({width:0,borderLeft:"none",borderRight:"none",paddingLeft:"0",paddingRight:"0"}),t==e-7&&$(a).find(".right-arrow a").css({width:0,borderLeft:"none",borderRight:"none",paddingLeft:"0",paddingRight:"0"})}function d(t,n){return o(t=l(t+=5*n)),1==n?$(a).find(".left-arrow a").attr("style",""):$(a).find(".right-arrow a").attr("style",""),r(t),f(t),t}var s=$(this).find(".ellipsis");if(!(s.length<1)){var p=$(this).find(".active");if(!$(".section-viewtopic").length||1!=p.length){var h,c;p.length>1&&(p=p.eq(1)),s.length>1||1==s.length&&s.nextAll(".active").length?(h=p.prev(),c=p.prev().prev()):1==s.length&&(h=p.next(),c=p.next().next());var g=parseInt(h.find("a").attr("href").split("=").pop()),w=parseInt(c.find("a").attr("href").split("=").pop());if(n=w-g,i=parseInt(p.find("a").text()),e=parseInt($(a).find('a:not([rel="next"]):last').text()),n&&i&&e){s.each(function(){for(var i="",e=parseInt($(this).prev().text())+1;e<parseInt($(this).next().text());e++)i+='<li><a href="'+t.replace(/start=(\d+)/,"start="+(e-1)*n)+'">'+e+"</a></li>";$(this).replaceWith(i)}),h=$(a).find("*").filter(function(){return"1"==$(this).text()}),$last=$(a).find("*").filter(function(){return $(this).text()==e}),h.nextUntil($last).wrapAll('<li class="wrapped"><ul class="pagination pagination-inline"></ul></li>'),$(a).find(".wrapped").before('<li class="left-arrow"><a>←</a></li>'),$(a).find(".wrapped").after('<li class="right-arrow"><a>→</a></li>');var u=parseInt(p.find("a").text())-2;o(u=l(u=5*Math.floor(u/5))),r(u),f(u),$(this).find(".left-arrow").on("click",function(){u=d(u,-1)}),$(this).find(".right-arrow").on("click",function(){u=d(u,1)})}}}})});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/theme/bbsort.bak.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/theme/bbsort.bak.css"
+new file mode 100644
+index 000000000..2a201ca6a
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/theme/bbsort.bak.css"
+@@ -0,0 +1,26 @@
++.wrapped {
++    float: left;
++    height: 32px;
++    overflow: hidden;
++    margin-left: -2px;
++
++    -webkit-transition: all 0.3s linear;
++
++    transition: all 0.3s linear;
++}
++.pagination-inline {
++    width: 9999999px;
++
++    -webkit-transition: all 0.3s linear;
++
++    transition: all 0.3s linear;
++}
++.pagination-inline a {
++    height: 32px;
++    font-size: 12px;
++}
++.left-arrow a,
++.right-arrow a {
++    -webkit-transition: all 0.3s linear;
++    transition: all 0.3s linear;
++}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/styles/FLATBOOTS/theme/bbsort.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/theme/bbsort.css"
+index 2a201ca6a..9fde3adce 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/styles/FLATBOOTS/theme/bbsort.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/theme/bbsort.css"
+@@ -1,26 +1 @@
+-.wrapped {
+-    float: left;
+-    height: 32px;
+-    overflow: hidden;
+-    margin-left: -2px;
+-
+-    -webkit-transition: all 0.3s linear;
+-
+-    transition: all 0.3s linear;
+-}
+-.pagination-inline {
+-    width: 9999999px;
+-
+-    -webkit-transition: all 0.3s linear;
+-
+-    transition: all 0.3s linear;
+-}
+-.pagination-inline a {
+-    height: 32px;
+-    font-size: 12px;
+-}
+-.left-arrow a,
+-.right-arrow a {
+-    -webkit-transition: all 0.3s linear;
+-    transition: all 0.3s linear;
+-}
+\ No newline at end of file
++.wrapped{float:left;height:32px;overflow:hidden;margin-left:-2px;-webkit-transition:all .3s linear;transition:all .3s linear}.pagination-inline{width:9999999px;-webkit-transition:all .3s linear;transition:all .3s linear}.pagination-inline a{height:32px;font-size:12px}.left-arrow a,.right-arrow a{-webkit-transition:all .3s linear;transition:all .3s linear}
+\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\bbsort/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bbsort/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbsort/diff_nospace.tmp"
@@ -0,0 +1,469 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/composer.json"
+index 10bac0935..9f2dc0b21 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/composer.json"
+@@ -25,7 +25,8 @@
+ 		"version-check": {
+ 			"host": "sitesplat.com",
+ 			"directory": "/updatecheck/phpbb32/ext",
+-            "filename": "bbsort.json"
++			"filename": "bbsort.json",
++			"ssl": true
+ 		}
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/diff_full.tmp"
+new file mode 100644
+index 000000000..a38a45afc
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/diff_full.tmp"
+@@ -0,0 +1,517 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/composer.json"
++index 10bac0935..9f2dc0b21 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/composer.json"
++@@ -1,11 +1,11 @@
++ {
++-    "name": "sitesplat/bbsort",
++-    "type": "phpbb-extension",
++-    "description": "Allows quick sorting for the viewforum  page, title, views last post etc. It also adds a new pagination system where the pages can be scrolled on click.",
++-    "homepage": "http://sitesplat.com",
++-    "version": "1.0.0",
++-    "time": "2017-01-19",
++-    "keywords": ["phpbb", "extension", "pagination", "search"],
+++	"name": "sitesplat/bbsort",
+++	"type": "phpbb-extension",
+++	"description": "Allows quick sorting for the viewforum  page, title, views last post etc. It also adds a new pagination system where the pages can be scrolled on click.",
+++	"homepage": "http://sitesplat.com",
+++	"version": "1.0.0",
+++	"time": "2017-01-19",
+++	"keywords": ["phpbb", "extension", "pagination", "search"],
++ 	"license": "Proprietary/All rights reserved",
++ 	"authors": [
++ 		{
++@@ -14,18 +14,19 @@
++ 			"homepage": "http://sitesplat.com"
++ 		}
++ 	],
++-    "require": {
++-        "php": ">=5.4"
++-    },
++-    "extra": {
++-        "display-name": "BBsort",
++-        "soft-require": {
++-            "phpbb/phpbb": ">=3.1.0,<3.3.0@dev"
++-        },
+++	"require": {
+++		"php": ">=5.4"
+++	},
+++	"extra": {
+++		"display-name": "BBsort",
+++		"soft-require": {
+++		"phpbb/phpbb": ">=3.1.0,<3.3.0@dev"
+++		},
++ 		"version-check": {
++-            "host": "sitesplat.com",
++-            "directory": "/updatecheck/phpbb32/ext",
++-            "filename": "bbsort.json"
+++			"host": "sitesplat.com",
+++			"directory": "/updatecheck/phpbb32/ext",
+++			"filename": "bbsort.json",
+++			"ssl": true
++ 		}
++-    }
+++	}
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/event/main_listener.php"
++index 50bda426d..4e671da34 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/event/main_listener.php"
++@@ -37,9 +37,9 @@ class main_listener implements EventSubscriberInterface
++ 	{
++ 		$default_url = "{$this->root_path}viewforum.{$this->php_ext}?f={$event['forum_id']}";
++ 		$this->template->assign_vars(array(
++-			'L_TITLE'	=> '<a href="' . append_sid($default_url . '&amp;sk=t&amp;sd=' . (($event['sort_dir'] == 'a') ? 'd' : 'a')) . '">' . $this->language->lang('TITLE') . '</a>',
++-			'L_TOPICS_POSTS_STATISTICS'	=> '<a href="' . append_sid($default_url . '&amp;sk=v&amp;sd=' . (($event['sort_dir'] == 'a') ? 'd' : 'a')) . '">' . $this->language->lang('TOPICS_POSTS_STATISTICS') . '</a>',
++-			'L_LAST_POST'	=> '<a href="' . append_sid($default_url . '&amp;sk=r&amp;sd=' . (($event['sort_dir'] == 'a') ? 'd' : 'a')) . '">' . $this->language->lang('LAST_POST') . '</a>',
+++			'L_TITLE'	=> '<a href="' . append_sid($default_url . '&amp;sk=s&amp;sd=' . ($event['sort_dir'] == 'a' ? 'd' : 'a')) . '">' . $this->language->lang('TITLE') . ($event['sort_key'] == 's' ? '&nbsp;<i class="fa fa-sort-alpha-'.($event['sort_dir'] == 'a' ? 'desc' : 'asc').'" aria-hidden="true"></i></a>' : '</a>'),
+++			'L_TOPICS_POSTS_STATISTICS'	=> '<a href="' . append_sid($default_url . '&amp;sk=v&amp;sd=' . ($event['sort_dir'] == 'a' ? 'd' : 'a')) . '">' . $this->language->lang('TOPICS_POSTS_STATISTICS') . ($event['sort_key'] == 'v' ? '&nbsp;<i class="fa fa-sort-numeric-'.($event['sort_dir'] == 'a' ? 'asc' : 'desc').'" aria-hidden="true"></i></a>' : '</a>'),
+++			'L_LAST_POST'	=> '<a href="' . append_sid($default_url . '&amp;sk=t&amp;sd=' . ($event['sort_dir'] == 'a' ? 'd' : 'a')) . '">' . $this->language->lang('LAST_POST') . ($event['sort_key'] == 't' ? '&nbsp;<i class="fa fa-sort-alpha-'.($event['sort_dir'] == 'a' ? 'desc' : 'asc').'" aria-hidden="true"></i></a>' : '</a>'),
++ 		));
++ 	}
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.bak.js"
++new file mode 100644
++index 000000000..cab42b4a6
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.bak.js"
++@@ -0,0 +1,180 @@
+++head.ready(function(){
+++    var base_url = (window.location.href.indexOf('start=') === -1) ? window.location.href + '&start=0' : window.location.href;
+++    $('.pagination.pagination-sm.hidden-xs').each(function(){
+++        var self = this;
+++
+++        function display_left_arrow() {
+++            $(self).find('.left-arrow a').attr('style', '');
+++        }
+++        function hide_left_arrow() {
+++            $(self).find('.left-arrow a').css({
+++                width: 0,
+++                borderLeft: 'none',
+++                borderRight: 'none',
+++                paddingLeft: '0',
+++                paddingRight: '0'
+++            });
+++        }
+++
+++        function display_right_arrow() {
+++            $(self).find('.right-arrow a').attr('style', '');
+++        }
+++        function hide_right_arrow() {
+++            $(self).find('.right-arrow a').css({
+++                width: 0,
+++                borderLeft: 'none',
+++                borderRight: 'none',
+++                paddingLeft: '0',
+++                paddingRight: '0'
+++            });
+++        }
+++
+++        function set_new_pagination_offset(current_pagination_start) {
+++            // current item offset
+++            var current_position = $(self).find('.pagination-inline a').eq(current_pagination_start).offset().left;
+++            // parent's offset (first parent is floating, so calculate second parent)
+++            var parent_position = $(self).find('.pagination-inline a').eq(current_pagination_start).parent().parent().offset().left;
+++            // animate new offset
+++            $(self).find('.pagination-inline').css('margin-left', -(current_position - parent_position));
+++        }
+++
+++        function set_new_wrapper_width(current_pagination_start, direction) {
+++            var new_width = 0;
+++            var selector = $(self).find('.pagination-inline li')
+++            if (current_pagination_start == 0) {
+++                selector = selector.eq(current_pagination_start).nextAll(':lt(4)').addBack();
+++            } else {
+++                selector = selector.eq(current_pagination_start - 1).nextAll(':lt(5)');
+++            }
+++            selector.each(function(){
+++                new_width += parseInt($(this).find('a').outerWidth());
+++            });
+++            // magic 8 is substracted (maybe margins?)
+++            $(self).find('.wrapped').css('width', new_width - 8);
+++        }
+++
+++        function check_pagination_limits(current_pagination_start) {
+++            if (current_pagination_start < 0) {
+++                return 0;
+++            }
+++            // if new pagination start exceeds total pages, align to last 5 items
+++            // note, that we need to add 2 items because first and last items are always displayed
+++            if (current_pagination_start > pages_total - 7) {
+++                return pages_total - 7;
+++            }
+++
+++            return current_pagination_start;
+++        }
+++
+++        function hide_arrows(current_pagination_start) {
+++            if (current_pagination_start == 0) {
+++                hide_left_arrow();
+++            }
+++            if (current_pagination_start == pages_total - 7) {
+++                hide_right_arrow();
+++            }
+++        }
+++
+++        // direction: 1 - right, -1 - left
+++        function on_arrow_click(current_pagination_start, direction) {
+++            current_pagination_start = current_pagination_start + (5 * direction);
+++            current_pagination_start = check_pagination_limits(current_pagination_start);
+++
+++            hide_arrows(current_pagination_start);
+++            (direction == 1) ? display_left_arrow() : display_right_arrow();
+++            
+++            set_new_pagination_offset(current_pagination_start);
+++            set_new_wrapper_width(current_pagination_start, direction);
+++
+++            return current_pagination_start;
+++        }
+++
+++        var per_page; // how many items per page?
+++        var current_page;
+++        var pages_total;
+++        
+++        var $ellipsis = $(this).find('.ellipsis');
+++        // no ellipsis? No extended pagination.
+++        if ($ellipsis.length < 1) {
+++            return;
+++        }
+++        var $active = $(this).find('.active');
+++        // second $active is correct one on viewtopic. So if only one is present, we stop
+++        if ($('.section-viewtopic').length && $active.length == 1) {
+++            return;
+++        }
+++        // number of posts is also marked as active, so select the correct one on viewtopic
+++        if ($active.length > 1) {
+++            $active = $active.eq(1);
+++        }
+++
+++        
+++
+++        // resolve per_page
+++        var $first;
+++        var $second;
+++        // 2 ellipsis means active is in the middle OR 1 ellipsis on the left
+++        if ($ellipsis.length > 1 || ($ellipsis.length == 1 && $ellipsis.nextAll('.active').length)) {
+++            $first = $active.prev();
+++            $second = $active.prev().prev();
+++        }
+++        // 1 ellipsis on the right
+++        else if ($ellipsis.length == 1) {
+++            $first = $active.next();
+++            $second = $active.next().next();
+++        }
+++        var next_start = parseInt($first.find('a').attr('href').split('=').pop());
+++        var next_next_start = parseInt($second.find('a').attr('href').split('=').pop());
+++        per_page = next_next_start - next_start;
+++        
+++        // resolve current_page
+++        current_page = parseInt($active.find('a').text());
+++
+++        // resolve pages_total
+++        pages_total = parseInt($(self).find('a:not([rel="next"]):last').text());
+++
+++        // all required variables resolved
+++        if (per_page && current_page && pages_total) {
+++            // replace ellipsis with actual pages
+++            $ellipsis.each(function(){
+++                var replacement = '';
+++                for (var i = parseInt($(this).prev().text()) + 1; i < parseInt($(this).next().text()); i++) {
+++                    replacement += '<li><a href="' + base_url.replace(/start=(\d+)/, 'start=' + ((i - 1) * per_page)) + '">' + i + '</a></li>'
+++                }
+++                $(this).replaceWith(replacement);
+++            });
+++
+++            // wrap pages
+++            $first = $(self).find('*').filter(function(){
+++                return $(this).text() == '1';
+++            });
+++            $last = $(self).find('*').filter(function(){
+++                return $(this).text() == pages_total;
+++            });
+++            var pages = $first.nextUntil($last);
+++            pages.wrapAll('<li class="wrapped"><ul class="pagination pagination-inline"></ul></li>');
+++
+++            // add arrows
+++            $(self).find('.wrapped').before('<li class="left-arrow"><a>←</a></li>');
+++            $(self).find('.wrapped').after('<li class="right-arrow"><a>→</a></li>');
+++
+++            var current_pagination_start = parseInt($active.find('a').text()) - 2;
+++            // allign current pagination start into blocks of 5
+++            current_pagination_start = Math.floor(current_pagination_start / 5) * 5;
+++            current_pagination_start = check_pagination_limits(current_pagination_start);
+++            hide_arrows(current_pagination_start);
+++            set_new_pagination_offset(current_pagination_start);
+++            set_new_wrapper_width(current_pagination_start);
+++
+++            // left arrow click
+++            $(this).find('.left-arrow').on('click', function(){
+++                current_pagination_start = on_arrow_click(current_pagination_start, -1);
+++            });
+++
+++            // right arrow click
+++            $(this).find('.right-arrow').on('click', function(){
+++                current_pagination_start = on_arrow_click(current_pagination_start, 1);
+++            });
+++        }
+++    });
+++});
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.js"
++index cab42b4a6..8c44d207a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.js"
++@@ -1,180 +1 @@
++-head.ready(function(){
++-    var base_url = (window.location.href.indexOf('start=') === -1) ? window.location.href + '&start=0' : window.location.href;
++-    $('.pagination.pagination-sm.hidden-xs').each(function(){
++-        var self = this;
++-
++-        function display_left_arrow() {
++-            $(self).find('.left-arrow a').attr('style', '');
++-        }
++-        function hide_left_arrow() {
++-            $(self).find('.left-arrow a').css({
++-                width: 0,
++-                borderLeft: 'none',
++-                borderRight: 'none',
++-                paddingLeft: '0',
++-                paddingRight: '0'
++-            });
++-        }
++-
++-        function display_right_arrow() {
++-            $(self).find('.right-arrow a').attr('style', '');
++-        }
++-        function hide_right_arrow() {
++-            $(self).find('.right-arrow a').css({
++-                width: 0,
++-                borderLeft: 'none',
++-                borderRight: 'none',
++-                paddingLeft: '0',
++-                paddingRight: '0'
++-            });
++-        }
++-
++-        function set_new_pagination_offset(current_pagination_start) {
++-            // current item offset
++-            var current_position = $(self).find('.pagination-inline a').eq(current_pagination_start).offset().left;
++-            // parent's offset (first parent is floating, so calculate second parent)
++-            var parent_position = $(self).find('.pagination-inline a').eq(current_pagination_start).parent().parent().offset().left;
++-            // animate new offset
++-            $(self).find('.pagination-inline').css('margin-left', -(current_position - parent_position));
++-        }
++-
++-        function set_new_wrapper_width(current_pagination_start, direction) {
++-            var new_width = 0;
++-            var selector = $(self).find('.pagination-inline li')
++-            if (current_pagination_start == 0) {
++-                selector = selector.eq(current_pagination_start).nextAll(':lt(4)').addBack();
++-            } else {
++-                selector = selector.eq(current_pagination_start - 1).nextAll(':lt(5)');
++-            }
++-            selector.each(function(){
++-                new_width += parseInt($(this).find('a').outerWidth());
++-            });
++-            // magic 8 is substracted (maybe margins?)
++-            $(self).find('.wrapped').css('width', new_width - 8);
++-        }
++-
++-        function check_pagination_limits(current_pagination_start) {
++-            if (current_pagination_start < 0) {
++-                return 0;
++-            }
++-            // if new pagination start exceeds total pages, align to last 5 items
++-            // note, that we need to add 2 items because first and last items are always displayed
++-            if (current_pagination_start > pages_total - 7) {
++-                return pages_total - 7;
++-            }
++-
++-            return current_pagination_start;
++-        }
++-
++-        function hide_arrows(current_pagination_start) {
++-            if (current_pagination_start == 0) {
++-                hide_left_arrow();
++-            }
++-            if (current_pagination_start == pages_total - 7) {
++-                hide_right_arrow();
++-            }
++-        }
++-
++-        // direction: 1 - right, -1 - left
++-        function on_arrow_click(current_pagination_start, direction) {
++-            current_pagination_start = current_pagination_start + (5 * direction);
++-            current_pagination_start = check_pagination_limits(current_pagination_start);
++-
++-            hide_arrows(current_pagination_start);
++-            (direction == 1) ? display_left_arrow() : display_right_arrow();
++-            
++-            set_new_pagination_offset(current_pagination_start);
++-            set_new_wrapper_width(current_pagination_start, direction);
++-
++-            return current_pagination_start;
++-        }
++-
++-        var per_page; // how many items per page?
++-        var current_page;
++-        var pages_total;
++-        
++-        var $ellipsis = $(this).find('.ellipsis');
++-        // no ellipsis? No extended pagination.
++-        if ($ellipsis.length < 1) {
++-            return;
++-        }
++-        var $active = $(this).find('.active');
++-        // second $active is correct one on viewtopic. So if only one is present, we stop
++-        if ($('.section-viewtopic').length && $active.length == 1) {
++-            return;
++-        }
++-        // number of posts is also marked as active, so select the correct one on viewtopic
++-        if ($active.length > 1) {
++-            $active = $active.eq(1);
++-        }
++-
++-        
++-
++-        // resolve per_page
++-        var $first;
++-        var $second;
++-        // 2 ellipsis means active is in the middle OR 1 ellipsis on the left
++-        if ($ellipsis.length > 1 || ($ellipsis.length == 1 && $ellipsis.nextAll('.active').length)) {
++-            $first = $active.prev();
++-            $second = $active.prev().prev();
++-        }
++-        // 1 ellipsis on the right
++-        else if ($ellipsis.length == 1) {
++-            $first = $active.next();
++-            $second = $active.next().next();
++-        }
++-        var next_start = parseInt($first.find('a').attr('href').split('=').pop());
++-        var next_next_start = parseInt($second.find('a').attr('href').split('=').pop());
++-        per_page = next_next_start - next_start;
++-        
++-        // resolve current_page
++-        current_page = parseInt($active.find('a').text());
++-
++-        // resolve pages_total
++-        pages_total = parseInt($(self).find('a:not([rel="next"]):last').text());
++-
++-        // all required variables resolved
++-        if (per_page && current_page && pages_total) {
++-            // replace ellipsis with actual pages
++-            $ellipsis.each(function(){
++-                var replacement = '';
++-                for (var i = parseInt($(this).prev().text()) + 1; i < parseInt($(this).next().text()); i++) {
++-                    replacement += '<li><a href="' + base_url.replace(/start=(\d+)/, 'start=' + ((i - 1) * per_page)) + '">' + i + '</a></li>'
++-                }
++-                $(this).replaceWith(replacement);
++-            });
++-
++-            // wrap pages
++-            $first = $(self).find('*').filter(function(){
++-                return $(this).text() == '1';
++-            });
++-            $last = $(self).find('*').filter(function(){
++-                return $(this).text() == pages_total;
++-            });
++-            var pages = $first.nextUntil($last);
++-            pages.wrapAll('<li class="wrapped"><ul class="pagination pagination-inline"></ul></li>');
++-
++-            // add arrows
++-            $(self).find('.wrapped').before('<li class="left-arrow"><a>←</a></li>');
++-            $(self).find('.wrapped').after('<li class="right-arrow"><a>→</a></li>');
++-
++-            var current_pagination_start = parseInt($active.find('a').text()) - 2;
++-            // allign current pagination start into blocks of 5
++-            current_pagination_start = Math.floor(current_pagination_start / 5) * 5;
++-            current_pagination_start = check_pagination_limits(current_pagination_start);
++-            hide_arrows(current_pagination_start);
++-            set_new_pagination_offset(current_pagination_start);
++-            set_new_wrapper_width(current_pagination_start);
++-
++-            // left arrow click
++-            $(this).find('.left-arrow').on('click', function(){
++-                current_pagination_start = on_arrow_click(current_pagination_start, -1);
++-            });
++-
++-            // right arrow click
++-            $(this).find('.right-arrow').on('click', function(){
++-                current_pagination_start = on_arrow_click(current_pagination_start, 1);
++-            });
++-        }
++-    });
++-});
++\ No newline at end of file
+++head.ready(function(){var t=-1===window.location.href.indexOf("start=")?window.location.href+"&start=0":window.location.href;$(".pagination.pagination-sm.hidden-xs").each(function(){var n,i,e,a=this;function r(t){var n=$(a).find(".pagination-inline a").eq(t).offset().left,i=$(a).find(".pagination-inline a").eq(t).parent().parent().offset().left;$(a).find(".pagination-inline").css("margin-left",-(n-i))}function f(t,n){var i=0,e=$(a).find(".pagination-inline li");(e=0==t?e.eq(t).nextAll(":lt(4)").addBack():e.eq(t-1).nextAll(":lt(5)")).each(function(){i+=parseInt($(this).find("a").outerWidth())}),$(a).find(".wrapped").css("width",i-8)}function l(t){return t<0?0:t>e-7?e-7:t}function o(t){0==t&&$(a).find(".left-arrow a").css({width:0,borderLeft:"none",borderRight:"none",paddingLeft:"0",paddingRight:"0"}),t==e-7&&$(a).find(".right-arrow a").css({width:0,borderLeft:"none",borderRight:"none",paddingLeft:"0",paddingRight:"0"})}function d(t,n){return o(t=l(t+=5*n)),1==n?$(a).find(".left-arrow a").attr("style",""):$(a).find(".right-arrow a").attr("style",""),r(t),f(t),t}var s=$(this).find(".ellipsis");if(!(s.length<1)){var p=$(this).find(".active");if(!$(".section-viewtopic").length||1!=p.length){var h,c;p.length>1&&(p=p.eq(1)),s.length>1||1==s.length&&s.nextAll(".active").length?(h=p.prev(),c=p.prev().prev()):1==s.length&&(h=p.next(),c=p.next().next());var g=parseInt(h.find("a").attr("href").split("=").pop()),w=parseInt(c.find("a").attr("href").split("=").pop());if(n=w-g,i=parseInt(p.find("a").text()),e=parseInt($(a).find('a:not([rel="next"]):last').text()),n&&i&&e){s.each(function(){for(var i="",e=parseInt($(this).prev().text())+1;e<parseInt($(this).next().text());e++)i+='<li><a href="'+t.replace(/start=(\d+)/,"start="+(e-1)*n)+'">'+e+"</a></li>";$(this).replaceWith(i)}),h=$(a).find("*").filter(function(){return"1"==$(this).text()}),$last=$(a).find("*").filter(function(){return $(this).text()==e}),h.nextUntil($last).wrapAll('<li class="wrapped"><ul class="pagination pagination-inline"></u
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bbsort/event/main_listener.php" "[FORUM_EXT]/sitesplat\\bbsort/event/main_listener.php"
--- "[ORIGINAL]/sitesplat\\bbsort/event/main_listener.php"
+++ "[FORUM_EXT]/sitesplat\\bbsort/event/main_listener.php"
@@ -37,9 +37,9 @@ class main_listener implements EventSubscriberInterface
 	{
 		$default_url = "{$this->root_path}viewforum.{$this->php_ext}?f={$event['forum_id']}";
 		$this->template->assign_vars(array(
-			'L_TITLE'	=> '<a href="' . append_sid($default_url . '&amp;sk=t&amp;sd=' . (($event['sort_dir'] == 'a') ? 'd' : 'a')) . '">' . $this->language->lang('TITLE') . '</a>',
-			'L_TOPICS_POSTS_STATISTICS'	=> '<a href="' . append_sid($default_url . '&amp;sk=v&amp;sd=' . (($event['sort_dir'] == 'a') ? 'd' : 'a')) . '">' . $this->language->lang('TOPICS_POSTS_STATISTICS') . '</a>',
-			'L_LAST_POST'	=> '<a href="' . append_sid($default_url . '&amp;sk=r&amp;sd=' . (($event['sort_dir'] == 'a') ? 'd' : 'a')) . '">' . $this->language->lang('LAST_POST') . '</a>',
+			'L_TITLE'	=> '<a href="' . append_sid($default_url . '&amp;sk=s&amp;sd=' . ($event['sort_dir'] == 'a' ? 'd' : 'a')) . '">' . $this->language->lang('TITLE') . ($event['sort_key'] == 's' ? '&nbsp;<i class="fa fa-sort-alpha-'.($event['sort_dir'] == 'a' ? 'desc' : 'asc').'" aria-hidden="true"></i></a>' : '</a>'),
+			'L_TOPICS_POSTS_STATISTICS'	=> '<a href="' . append_sid($default_url . '&amp;sk=v&amp;sd=' . ($event['sort_dir'] == 'a' ? 'd' : 'a')) . '">' . $this->language->lang('TOPICS_POSTS_STATISTICS') . ($event['sort_key'] == 'v' ? '&nbsp;<i class="fa fa-sort-numeric-'.($event['sort_dir'] == 'a' ? 'asc' : 'desc').'" aria-hidden="true"></i></a>' : '</a>'),
+			'L_LAST_POST'	=> '<a href="' . append_sid($default_url . '&amp;sk=t&amp;sd=' . ($event['sort_dir'] == 'a' ? 'd' : 'a')) . '">' . $this->language->lang('LAST_POST') . ($event['sort_key'] == 't' ? '&nbsp;<i class="fa fa-sort-alpha-'.($event['sort_dir'] == 'a' ? 'desc' : 'asc').'" aria-hidden="true"></i></a>' : '</a>'),
 		));
 	}
 }
diff --git "[FORUM_EXT]/sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.bak.js" "[FORUM_EXT]/sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.bak.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.bak.js"
@@ -0,0 +1,180 @@
+head.ready(function(){
+    var base_url = (window.location.href.indexOf('start=') === -1) ? window.location.href + '&start=0' : window.location.href;
+    $('.pagination.pagination-sm.hidden-xs').each(function(){
+        var self = this;
+
+        function display_left_arrow() {
+            $(self).find('.left-arrow a').attr('style', '');
+        }
+        function hide_left_arrow() {
+            $(self).find('.left-arrow a').css({
+                width: 0,
+                borderLeft: 'none',
+                borderRight: 'none',
+                paddingLeft: '0',
+                paddingRight: '0'
+            });
+        }
+
+        function display_right_arrow() {
+            $(self).find('.right-arrow a').attr('style', '');
+        }
+        function hide_right_arrow() {
+            $(self).find('.right-arrow a').css({
+                width: 0,
+                borderLeft: 'none',
+                borderRight: 'none',
+                paddingLeft: '0',
+                paddingRight: '0'
+            });
+        }
+
+        function set_new_pagination_offset(current_pagination_start) {
+            // current item offset
+            var current_position = $(self).find('.pagination-inline a').eq(current_pagination_start).offset().left;
+            // parent's offset (first parent is floating, so calculate second parent)
+            var parent_position = $(self).find('.pagination-inline a').eq(current_pagination_start).parent().parent().offset().left;
+            // animate new offset
+            $(self).find('.pagination-inline').css('margin-left', -(current_position - parent_position));
+        }
+
+        function set_new_wrapper_width(current_pagination_start, direction) {
+            var new_width = 0;
+            var selector = $(self).find('.pagination-inline li')
+            if (current_pagination_start == 0) {
+                selector = selector.eq(current_pagination_start).nextAll(':lt(4)').addBack();
+            } else {
+                selector = selector.eq(current_pagination_start - 1).nextAll(':lt(5)');
+            }
+            selector.each(function(){
+                new_width += parseInt($(this).find('a').outerWidth());
+            });
+            // magic 8 is substracted (maybe margins?)
+            $(self).find('.wrapped').css('width', new_width - 8);
+        }
+
+        function check_pagination_limits(current_pagination_start) {
+            if (current_pagination_start < 0) {
+                return 0;
+            }
+            // if new pagination start exceeds total pages, align to last 5 items
+            // note, that we need to add 2 items because first and last items are always displayed
+            if (current_pagination_start > pages_total - 7) {
+                return pages_total - 7;
+            }
+
+            return current_pagination_start;
+        }
+
+        function hide_arrows(current_pagination_start) {
+            if (current_pagination_start == 0) {
+                hide_left_arrow();
+            }
+            if (current_pagination_start == pages_total - 7) {
+                hide_right_arrow();
+            }
+        }
+
+        // direction: 1 - right, -1 - left
+        function on_arrow_click(current_pagination_start, direction) {
+            current_pagination_start = current_pagination_start + (5 * direction);
+            current_pagination_start = check_pagination_limits(current_pagination_start);
+
+            hide_arrows(current_pagination_start);
+            (direction == 1) ? display_left_arrow() : display_right_arrow();
+            
+            set_new_pagination_offset(current_pagination_start);
+            set_new_wrapper_width(current_pagination_start, direction);
+
+            return current_pagination_start;
+        }
+
+        var per_page; // how many items per page?
+        var current_page;
+        var pages_total;
+        
+        var $ellipsis = $(this).find('.ellipsis');
+        // no ellipsis? No extended pagination.
+        if ($ellipsis.length < 1) {
+            return;
+        }
+        var $active = $(this).find('.active');
+        // second $active is correct one on viewtopic. So if only one is present, we stop
+        if ($('.section-viewtopic').length && $active.length == 1) {
+            return;
+        }
+        // number of posts is also marked as active, so select the correct one on viewtopic
+        if ($active.length > 1) {
+            $active = $active.eq(1);
+        }
+
+        
+
+        // resolve per_page
+        var $first;
+        var $second;
+        // 2 ellipsis means active is in the middle OR 1 ellipsis on the left
+        if ($ellipsis.length > 1 || ($ellipsis.length == 1 && $ellipsis.nextAll('.active').length)) {
+            $first = $active.prev();
+            $second = $active.prev().prev();
+        }
+        // 1 ellipsis on the right
+        else if ($ellipsis.length == 1) {
+            $first = $active.next();
+            $second = $active.next().next();
+        }
+        var next_start = parseInt($first.find('a').attr('href').split('=').pop());
+        var next_next_start = parseInt($second.find('a').attr('href').split('=').pop());
+        per_page = next_next_start - next_start;
+        
+        // resolve current_page
+        current_page = parseInt($active.find('a').text());
+
+        // resolve pages_total
+        pages_total = parseInt($(self).find('a:not([rel="next"]):last').text());
+
+        // all required variables resolved
+        if (per_page && current_page && pages_total) {
+            // replace ellipsis with actual pages
+            $ellipsis.each(function(){
+                var replacement = '';
+                for (var i = parseInt($(this).prev().text()) + 1; i < parseInt($(this).next().text()); i++) {
+                    replacement += '<li><a href="' + base_url.replace(/start=(\d+)/, 'start=' + ((i - 1) * per_page)) + '">' + i + '</a></li>'
+                }
+                $(this).replaceWith(replacement);
+            });
+
+            // wrap pages
+            $first = $(self).find('*').filter(function(){
+                return $(this).text() == '1';
+            });
+            $last = $(self).find('*').filter(function(){
+                return $(this).text() == pages_total;
+            });
+            var pages = $first.nextUntil($last);
+            pages.wrapAll('<li class="wrapped"><ul class="pagination pagination-inline"></ul></li>');
+
+            // add arrows
+            $(self).find('.wrapped').before('<li class="left-arrow"><a>←</a></li>');
+            $(self).find('.wrapped').after('<li class="right-arrow"><a>→</a></li>');
+
+            var current_pagination_start = parseInt($active.find('a').text()) - 2;
+            // allign current pagination start into blocks of 5
+            current_pagination_start = Math.floor(current_pagination_start / 5) * 5;
+            current_pagination_start = check_pagination_limits(current_pagination_start);
+            hide_arrows(current_pagination_start);
+            set_new_pagination_offset(current_pagination_start);
+            set_new_wrapper_width(current_pagination_start);
+
+            // left arrow click
+            $(this).find('.left-arrow').on('click', function(){
+                current_pagination_start = on_arrow_click(current_pagination_start, -1);
+            });
+
+            // right arrow click
+            $(this).find('.right-arrow').on('click', function(){
+                current_pagination_start = on_arrow_click(current_pagination_start, 1);
+            });
+        }
+    });
+});
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.js" "[FORUM_EXT]/sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.js"
--- "[ORIGINAL]/sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.js"
+++ "[FORUM_EXT]/sitesplat\\bbsort/styles/FLATBOOTS/template/js/bbsort.js"
@@ -1,180 +1 @@
-head.ready(function(){
-    var base_url = (window.location.href.indexOf('start=') === -1) ? window.location.href + '&start=0' : window.location.href;
-    $('.pagination.pagination-sm.hidden-xs').each(function(){
-        var self = this;
-
-        function display_left_arrow() {
-            $(self).find('.left-arrow a').attr('style', '');
-        }
-        function hide_left_arrow() {
-            $(self).find('.left-arrow a').css({
-                width: 0,
-                borderLeft: 'none',
-                borderRight: 'none',
-                paddingLeft: '0',
-                paddingRight: '0'
-            });
-        }
-
-        function display_right_arrow() {
-            $(self).find('.right-arrow a').attr('style', '');
-        }
-        function hide_right_arrow() {
-            $(self).find('.right-arrow a').css({
-                width: 0,
-                borderLeft: 'none',
-                borderRight: 'none',
-                paddingLeft: '0',
-                paddingRight: '0'
-            });
-        }
-
-        function set_new_pagination_offset(current_pagination_start) {
-            // current item offset
-            var current_position = $(self).find('.pagination-inline a').eq(current_pagination_start).offset().left;
-            // parent's offset (first parent is floating, so calculate second parent)
-            var parent_position = $(self).find('.pagination-inline a').eq(current_pagination_start).parent().parent().offset().left;
-            // animate new offset
-            $(self).find('.pagination-inline').css('margin-left', -(current_position - parent_position));
-        }
-
-        function set_new_wrapper_width(current_pagination_start, direction) {
-            var new_width = 0;
-            var selector = $(self).find('.pagination-inline li')
-            if (current_pagination_start == 0) {
-                selector = selector.eq(current_pagination_start).nextAll(':lt(4)').addBack();
-            } else {
-                selector = selector.eq(current_pagination_start - 1).nextAll(':lt(5)');
-            }
-            selector.each(function(){
-                new_width += parseInt($(this).find('a').outerWidth());
-            });
-            // magic 8 is substracted (maybe margins?)
-            $(self).find('.wrapped').css('width', new_width - 8);
-        }
-
-        function check_pagination_limits(current_pagination_start) {
-            if (current_pagination_start < 0) {
-                return 0;
-            }
-            // if new pagination start exceeds total pages, align to last 5 items
-            // note, that we need to add 2 items because first and last items are always displayed
-            if (current_pagination_start > pages_total - 7) {
-                return pages_total - 7;
-            }
-
-            return current_pagination_start;
-        }
-
-        function hide_arrows(current_pagination_start) {
-            if (current_pagination_start == 0) {
-                hide_left_arrow();
-            }
-            if (current_pagination_start == pages_total - 7) {
-                hide_right_arrow();
-            }
-        }
-
-        // direction: 1 - right, -1 - left
-        function on_arrow_click(current_pagination_start, direction) {
-            current_pagination_start = current_pagination_start + (5 * direction);
-            current_pagination_start = check_pagination_limits(current_pagination_start);
-
-            hide_arrows(current_pagination_start);
-            (direction == 1) ? display_left_arrow() : display_right_arrow();
-            
-            set_new_pagination_offset(current_pagination_start);
-            set_new_wrapper_width(current_pagination_start, direction);
-
-            return current_pagination_start;
-        }
-
-        var per_page; // how many items per page?
-        var current_page;
-        var pages_total;
-        
-        var $ellipsis = $(this).find('.ellipsis');
-        // no ellipsis? No extended pagination.
-        if ($ellipsis.length < 1) {
-            return;
-        }
-        var $active = $(this).find('.active');
-        // second $active is correct one on viewtopic. So if only one is present, we stop
-        if ($('.section-viewtopic').length && $active.length == 1) {
-            return;
-        }
-        // number of posts is also marked as active, so select the correct one on viewtopic
-        if ($active.length > 1) {
-            $active = $active.eq(1);
-        }
-
-        
-
-        // resolve per_page
-        var $first;
-        var $second;
-        // 2 ellipsis means active is in the middle OR 1 ellipsis on the left
-        if ($ellipsis.length > 1 || ($ellipsis.length == 1 && $ellipsis.nextAll('.active').length)) {
-            $first = $active.prev();
-            $second = $active.prev().prev();
-        }
-        // 1 ellipsis on the right
-        else if ($ellipsis.length == 1) {
-            $first = $active.next();
-            $second = $active.next().next();
-        }
-        var next_start = parseInt($first.find('a').attr('href').split('=').pop());
-        var next_next_start = parseInt($second.find('a').attr('href').split('=').pop());
-        per_page = next_next_start - next_start;
-        
-        // resolve current_page
-        current_page = parseInt($active.find('a').text());
-
-        // resolve pages_total
-        pages_total = parseInt($(self).find('a:not([rel="next"]):last').text());
-
-        // all required variables resolved
-        if (per_page && current_page && pages_total) {
-            // replace ellipsis with actual pages
-            $ellipsis.each(function(){
-                var replacement = '';
-                for (var i = parseInt($(this).prev().text()) + 1; i < parseInt($(this).next().text()); i++) {
-                    replacement += '<li><a href="' + base_url.replace(/start=(\d+)/, 'start=' + ((i - 1) * per_page)) + '">' + i + '</a></li>'
-                }
-                $(this).replaceWith(replacement);
-            });
-
-            // wrap pages
-            $first = $(self).find('*').filter(function(){
-                return $(this).text() == '1';
-            });
-            $last = $(self).find('*').filter(function(){
-                return $(this).text() == pages_total;
-            });
-            var pages = $first.nextUntil($last);
-            pages.wrapAll('<li class="wrapped"><ul class="pagination pagination-inline"></ul></li>');
-
-            // add arrows
-            $(self).find('.wrapped').before('<li class="left-arrow"><a>←</a></li>');
-            $(self).find('.wrapped').after('<li class="right-arrow"><a>→</a></li>');
-
-            var current_pagination_start = parseInt($active.find('a').text()) - 2;
-            // allign current pagination start into blocks of 5
-            current_pagination_start = Math.floor(current_pagination_start / 5) * 5;
-            current_pagination_start = check_pagination_limits(current_pagination_start);
-            hide_arrows(current_pagination_start);
-            set_new_pagination_offset(current_pagination_start);
-            set_new_wrapper_width(current_pagination_start);
-
-            // left arrow click
-            $(this).find('.left-arrow').on('click', function(){
-                current_pagination_start = on_arrow_click(current_pagination_start, -1);
-            });
-
-            // right arrow click
-            $(this).find('.right-arrow').on('click', function(){
-                current_pagination_start = on_arrow_click(current_pagination_start, 1);
-            });
-        }
-    });
-});
\ No newline at end of file
+head.ready(function(){var t=-1===window.location.href.indexOf("start=")?window.location.href+"&start=0":window.location.href;$(".pagination.pagination-sm.hidden-xs").each(function(){var n,i,e,a=this;function r(t){var n=$(a).find(".pagination-inline a").eq(t).offset().left,i=$(a).find(".pagination-inline a").eq(t).parent().parent().offset().left;$(a).find(".pagination-inline").css("margin-left",-(n-i))}function f(t,n){var i=0,e=$(a).find(".pagination-inline li");(e=0==t?e.eq(t).nextAll(":lt(4)").addBack():e.eq(t-1).nextAll(":lt(5)")).each(function(){i+=parseInt($(this).find("a").outerWidth())}),$(a).find(".wrapped").css("width",i-8)}function l(t){return t<0?0:t>e-7?e-7:t}function o(t){0==t&&$(a).find(".left-arrow a").css({width:0,borderLeft:"none",borderRight:"none",paddingLeft:"0",paddingRight:"0"}),t==e-7&&$(a).find(".right-arrow a").css({width:0,borderLeft:"none",borderRight:"none",paddingLeft:"0",paddingRight:"0"})}function d(t,n){return o(t=l(t+=5*n)),1==n?$(a).find(".left-arrow a").attr("style",""):$(a).find(".right-arrow a").attr("style",""),r(t),f(t),t}var s=$(this).find(".ellipsis");if(!(s.length<1)){var p=$(this).find(".active");if(!$(".section-viewtopic").length||1!=p.length){var h,c;p.length>1&&(p=p.eq(1)),s.length>1||1==s.length&&s.nextAll(".active").length?(h=p.prev(),c=p.prev().prev()):1==s.length&&(h=p.next(),c=p.next().next());var g=parseInt(h.find("a").attr("href").split("=").pop()),w=parseInt(c.find("a").attr("href").split("=").pop());if(n=w-g,i=parseInt(p.find("a").text()),e=parseInt($(a).find('a:not([rel="next"]):last').text()),n&&i&&e){s.each(function(){for(var i="",e=parseInt($(this).prev().text())+1;e<parseInt($(this).next().text());e++)i+='<li><a href="'+t.replace(/start=(\d+)/,"start="+(e-1)*n)+'">'+e+"</a></li>";$(this).replaceWith(i)}),h=$(a).find("*").filter(function(){return"1"==$(this).text()}),$last=$(a).find("*").filter(function(){return $(this).text()==e}),h.nextUntil($last).wrapAll('<li class="wrapped"><ul class="pagination pagination-inline"></ul></li>'),$(a).find(".wrapped").before('<li class="left-arrow"><a>←</a></li>'),$(a).find(".wrapped").after('<li class="right-arrow"><a>→</a></li>');var u=parseInt(p.find("a").text())-2;o(u=l(u=5*Math.floor(u/5))),r(u),f(u),$(this).find(".left-arrow").on("click",function(){u=d(u,-1)}),$(this).find(".right-arrow").on("click",function(){u=d(u,1)})}}}})});
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\bbsort/styles/FLATBOOTS/theme/bbsort.bak.css" "[FORUM_EXT]/sitesplat\\bbsort/styles/FLATBOOTS/theme/bbsort.bak.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbsort/styles/FLATBOOTS/theme/bbsort.bak.css"
@@ -0,0 +1,26 @@
+.wrapped {
+    float: left;
+    height: 32px;
+    overflow: hidden;
+    margin-left: -2px;
+
+    -webkit-transition: all 0.3s linear;
+
+    transition: all 0.3s linear;
+}
+.pagination-inline {
+    width: 9999999px;
+
+    -webkit-transition: all 0.3s linear;
+
+    transition: all 0.3s linear;
+}
+.pagination-inline a {
+    height: 32px;
+    font-size: 12px;
+}
+.left-arrow a,
+.right-arrow a {
+    -webkit-transition: all 0.3s linear;
+    transition: all 0.3s linear;
+}
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bbsort/styles/FLATBOOTS/theme/bbsort.css" "[FORUM_EXT]/sitesplat\\bbsort/styles/FLATBOOTS/theme/bbsort.css"
--- "[ORIGINAL]/sitesplat\\bbsort/styles/FLATBOOTS/theme/bbsort.css"
+++ "[FORUM_EXT]/sitesplat\\bbsort/styles/FLATBOOTS/theme/bbsort.css"
@@ -1,26 +1 @@
-.wrapped {
-    float: left;
-    height: 32px;
-    overflow: hidden;
-    margin-left: -2px;
-
-    -webkit-transition: all 0.3s linear;
-
-    transition: all 0.3s linear;
-}
-.pagination-inline {
-    width: 9999999px;
-
-    -webkit-transition: all 0.3s linear;
-
-    transition: all 0.3s linear;
-}
-.pagination-inline a {
-    height: 32px;
-    font-size: 12px;
-}
-.left-arrow a,
-.right-arrow a {
-    -webkit-transition: all 0.3s linear;
-    transition: all 0.3s linear;
-}
\ No newline at end of file
+.wrapped{float:left;height:32px;overflow:hidden;margin-left:-2px;-webkit-transition:all .3s linear;transition:all .3s linear}.pagination-inline{width:9999999px;-webkit-transition:all .3s linear;transition:all .3s linear}.pagination-inline a{height:32px;font-size:12px}.left-arrow a,.right-arrow a{-webkit-transition:all .3s linear;transition:all .3s linear}
\ No newline at end of file
```
