head.ready(function(){
    var base_url = (window.location.href.indexOf('start=') === -1) ? window.location.href + '&start=0' : window.location.href;
    $('.pagination.pagination-sm.hidden-xs').each(function(){
        var self = this;

        function display_left_arrow() {
            $(self).find('.left-arrow a').attr('style', '');
        }
        function hide_left_arrow() {
            $(self).find('.left-arrow a').css({
                width: 0,
                borderLeft: 'none',
                borderRight: 'none',
                paddingLeft: '0',
                paddingRight: '0'
            });
        }

        function display_right_arrow() {
            $(self).find('.right-arrow a').attr('style', '');
        }
        function hide_right_arrow() {
            $(self).find('.right-arrow a').css({
                width: 0,
                borderLeft: 'none',
                borderRight: 'none',
                paddingLeft: '0',
                paddingRight: '0'
            });
        }

        function set_new_pagination_offset(current_pagination_start) {
            // current item offset
            var current_position = $(self).find('.pagination-inline a').eq(current_pagination_start).offset().left;
            // parent's offset (first parent is floating, so calculate second parent)
            var parent_position = $(self).find('.pagination-inline a').eq(current_pagination_start).parent().parent().offset().left;
            // animate new offset
            $(self).find('.pagination-inline').css('margin-left', -(current_position - parent_position));
        }

        function set_new_wrapper_width(current_pagination_start, direction) {
            var new_width = 0;
            var selector = $(self).find('.pagination-inline li')
            if (current_pagination_start == 0) {
                selector = selector.eq(current_pagination_start).nextAll(':lt(4)').addBack();
            } else {
                selector = selector.eq(current_pagination_start - 1).nextAll(':lt(5)');
            }
            selector.each(function(){
                new_width += parseInt($(this).find('a').outerWidth());
            });
            // magic 8 is substracted (maybe margins?)
            $(self).find('.wrapped').css('width', new_width - 8);
        }

        function check_pagination_limits(current_pagination_start) {
            if (current_pagination_start < 0) {
                return 0;
            }
            // if new pagination start exceeds total pages, align to last 5 items
            // note, that we need to add 2 items because first and last items are always displayed
            if (current_pagination_start > pages_total - 7) {
                return pages_total - 7;
            }

            return current_pagination_start;
        }

        function hide_arrows(current_pagination_start) {
            if (current_pagination_start == 0) {
                hide_left_arrow();
            }
            if (current_pagination_start == pages_total - 7) {
                hide_right_arrow();
            }
        }

        // direction: 1 - right, -1 - left
        function on_arrow_click(current_pagination_start, direction) {
            current_pagination_start = current_pagination_start + (5 * direction);
            current_pagination_start = check_pagination_limits(current_pagination_start);

            hide_arrows(current_pagination_start);
            (direction == 1) ? display_left_arrow() : display_right_arrow();
            
            set_new_pagination_offset(current_pagination_start);
            set_new_wrapper_width(current_pagination_start, direction);

            return current_pagination_start;
        }

        var per_page; // how many items per page?
        var current_page;
        var pages_total;
        
        var $ellipsis = $(this).find('.ellipsis');
        // no ellipsis? No extended pagination.
        if ($ellipsis.length < 1) {
            return;
        }
        var $active = $(this).find('.active');
        // second $active is correct one on viewtopic. So if only one is present, we stop
        if ($('.section-viewtopic').length && $active.length == 1) {
            return;
        }
        // number of posts is also marked as active, so select the correct one on viewtopic
        if ($active.length > 1) {
            $active = $active.eq(1);
        }

        

        // resolve per_page
        var $first;
        var $second;
        // 2 ellipsis means active is in the middle OR 1 ellipsis on the left
        if ($ellipsis.length > 1 || ($ellipsis.length == 1 && $ellipsis.nextAll('.active').length)) {
            $first = $active.prev();
            $second = $active.prev().prev();
        }
        // 1 ellipsis on the right
        else if ($ellipsis.length == 1) {
            $first = $active.next();
            $second = $active.next().next();
        }
        var next_start = parseInt($first.find('a').attr('href').split('=').pop());
        var next_next_start = parseInt($second.find('a').attr('href').split('=').pop());
        per_page = next_next_start - next_start;
        
        // resolve current_page
        current_page = parseInt($active.find('a').text());

        // resolve pages_total
        pages_total = parseInt($(self).find('a:not([rel="next"]):last').text());

        // all required variables resolved
        if (per_page && current_page && pages_total) {
            // replace ellipsis with actual pages
            $ellipsis.each(function(){
                var replacement = '';
                for (var i = parseInt($(this).prev().text()) + 1; i < parseInt($(this).next().text()); i++) {
                    replacement += '<li><a href="' + base_url.replace(/start=(\d+)/, 'start=' + ((i - 1) * per_page)) + '">' + i + '</a></li>'
                }
                $(this).replaceWith(replacement);
            });

            // wrap pages
            $first = $(self).find('*').filter(function(){
                return $(this).text() == '1';
            });
            $last = $(self).find('*').filter(function(){
                return $(this).text() == pages_total;
            });
            var pages = $first.nextUntil($last);
            pages.wrapAll('<li class="wrapped"><ul class="pagination pagination-inline"></ul></li>');

            // add arrows
            $(self).find('.wrapped').before('<li class="left-arrow"><a>←</a></li>');
            $(self).find('.wrapped').after('<li class="right-arrow"><a>→</a></li>');

            var current_pagination_start = parseInt($active.find('a').text()) - 2;
            // allign current pagination start into blocks of 5
            current_pagination_start = Math.floor(current_pagination_start / 5) * 5;
            current_pagination_start = check_pagination_limits(current_pagination_start);
            hide_arrows(current_pagination_start);
            set_new_pagination_offset(current_pagination_start);
            set_new_wrapper_width(current_pagination_start);

            // left arrow click
            $(this).find('.left-arrow').on('click', function(){
                current_pagination_start = on_arrow_click(current_pagination_start, -1);
            });

            // right arrow click
            $(this).find('.right-arrow').on('click', function(){
                current_pagination_start = on_arrow_click(current_pagination_start, 1);
            });
        }
    });
});