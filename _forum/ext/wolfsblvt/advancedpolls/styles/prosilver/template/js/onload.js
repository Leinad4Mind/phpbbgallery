/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

$(document).ready(function () {
	function installRanking() {
		if (!$.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_ranking) {
			return;
		}

		var $poll = $('.topic_poll').first();
		var $form = $poll.closest('form');
		var $choices = $poll.find('.ap-rank-choice');
		var points = $.map($.wolfsblvt.advancedpoll_json_data.rank_points || [], function (point) {
			return parseInt(point, 10);
		});
		var limit = parseInt($.wolfsblvt.advancedpoll_json_data.rank_limit, 10) || points.length;
		var ordered = [];

		$choices.filter(':checked').each(function () {
			var position = $.inArray(parseInt($(this).attr('data-current-value'), 10), points);
			if (position >= 0) {
				ordered[position] = this;
			}
		});
		ordered = $.grep(ordered, function (choice) { return !!choice; });

		function syncRanking() {
			$form.find('input.ap-rank-value').remove();
			$choices.prop('checked', false).closest('.ap-ranking-choice').find('.ap-rank-badge').empty();
			$.each(ordered, function (index, choice) {
				var $choice = $(choice);
				var optionId = parseInt($choice.val(), 10);
				$choice.prop('checked', true).closest('.ap-ranking-choice').find('.ap-rank-badge').text(index + 1);
				$('<input type="hidden" class="ap-rank-value" />')
					.attr('name', 'vote_id[' + optionId + ']')
					.val(points[index])
					.appendTo($form);
			});
		}

		$choices.on('change', function () {
			var choice = this;
			if (choice.checked) {
				if (ordered.length >= limit) {
					choice.checked = false;
					window.alert($.wolfsblvt.advancedpoll_json_data.l_rank_limit);
					return;
				}
				ordered.push(choice);
			} else {
				ordered = $.grep(ordered, function (item) { return item !== choice; });
			}
			syncRanking();
		});

		syncRanking();
	}

	installRanking();

	function installScoreBreakdowns() {
		$('.ap-score-breakdown-source').each(function () {
			var $source = $(this);
			var optionId = $source.attr('data-score-option-id');
			var $option = $('.topic_poll [data-poll-option-id="' + optionId + '"]').first();
			var $target;

			if (!$option.length) {
				return;
			}

			if ($option.is('div')) {
				var $percentage = $option.find('.poll_option_percent').first();
				$target = $percentage.find('.badge').first();
				if (!$target.length) {
					$target = $('<span class="badge"></span>').appendTo($percentage.empty());
				}
			} else {
				$target = $option.find('dd.resultbar > div').first();
			}

			if ($target.length) {
				$target.addClass('ap-score-breakdown-host').empty()
					.append($source.find('.ap-score-breakdown-widget').first().clone());
			}
		});
	}

	function updateScoreBreakdowns(breakdowns) {
		$.each(breakdowns, function (optionId, breakdown) {
			var $source = $('.ap-score-breakdown-source[data-score-option-id="' + optionId + '"]');
			var title = $source.find('.ap-score-breakdown-popup strong').first().text();
			$source.find('.ap-score-total').text(breakdown.total);
			$source.find('.ap-score-breakdown-list').html(breakdown.detail);
			$source.find('.ap-score-breakdown-trigger').attr('aria-label', breakdown.total + '. ' + title);
		});
		installScoreBreakdowns();
	}

	installScoreBreakdowns();

	$(document).on('click', '.ap-score-breakdown-trigger', function (event) {
		event.stopPropagation();
		var $widget = $(this).closest('.ap-score-breakdown-widget');
		var opening = !$widget.hasClass('is-open');
		$('.ap-score-breakdown-widget').removeClass('is-open')
			.find('.ap-score-breakdown-trigger').attr('aria-expanded', 'false');
		$widget.toggleClass('is-open', opening);
		$(this).attr('aria-expanded', opening ? 'true' : 'false');
		if (!opening) {
			$(this).blur();
		}
	});

	$(document).on('click', function () {
		$('.ap-score-breakdown-widget').removeClass('is-open')
			.find('.ap-score-breakdown-trigger').attr('aria-expanded', 'false').blur();
	});

	$(document).on('keydown', function (event) {
		if (event.key === 'Escape' || event.keyCode === 27) {
			$('.ap-score-breakdown-widget').removeClass('is-open')
				.find('.ap-score-breakdown-trigger').attr('aria-expanded', 'false').blur();
		}
	});

	$(document).on('click', '.ap-infopoll-button', function (event) {
		var $button = $(this);
		var endpoint = $button.attr('data-infopoll-url');
		if (!endpoint) {
			return;
		}

		event.preventDefault();
		if ($button.attr('aria-busy') === 'true') {
			return;
		}
		$button.attr('aria-busy', 'true').addClass('disabled');

		$.ajax({
			url: endpoint,
			type: 'GET',
			dataType: 'json',
			cache: false,
		}).done(function (data) {
			var $content = $('<div class="ap-infopoll"></div>');
			$('<div class="ap-infopoll-question"></div>').html(data.question).appendTo($content);
			$.each(data.options, function (index, option) {
				var $option = $('<div class="ap-infopoll-option"></div>').appendTo($content);
				$('<span class="ap-infopoll-option-title"></span>').html(option.caption).appendTo($option);
				$('<span class="ap-infopoll-option-total"></span>').text(option.total).appendTo($option);
				var $voters = $('<span class="ap-infopoll-voters"></span>').appendTo($option);
				$('<strong></strong>').text(data.voters_label + ': ').appendTo($voters);
				$('<span></span>').html(option.voters).appendTo($voters);
			});
			var $allVoters = $('<span class="ap-infopoll-all-voters"></span>').appendTo($content);
			$('<strong></strong>').text(data.voters_label + ': ').appendTo($allVoters);
			$('<span></span>').html(data.all_voters).appendTo($allVoters);
			phpbb.alert(data.title, $('<div></div>').append($content).html());
		}).fail(function (xhr) {
			var error = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : $button.attr('title');
			phpbb.alert($button.attr('title'), error);
		}).always(function () {
			$button.removeAttr('aria-busy').removeClass('disabled');
		});
	});

	// replace the ajax callback for poll votes if votes are hidden
	if ($.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_votes_hide_topic) {
		var visibleResultsCallback = phpbb.ajaxCallbacks['vote_poll'];
		phpbb.addAjaxCallback('vote_poll', function (res) {
			if (res.results_hidden) {
				$.wolfsblvt.override_callback_advancedpolls_vote_poll_hidden.call(this, res);
			} else {
				visibleResultsCallback.call(this, res);
			}
		});
	}

	// extend the ajax callback for poll votes if voters should be shown
	if ($.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_voters_show_topic && !$.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_votes_hide_topic) {
		var old_function = phpbb.ajaxCallbacks['vote_poll'];
		//phpbb.addAjaxCallback('vote_poll', function (res) { old_function(res); $.wolfsblvt.extend_callback_advancedpolls_vote_poll_show_voters(res); });
		phpbb.addAjaxCallback('vote_poll', function (res) { old_function.call(this, res); $.wolfsblvt.extend_callback_advancedpolls_vote_poll_show_voters(res); });
	}

	if ($.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_scoring) {
		var scoreResultsCallback = phpbb.ajaxCallbacks['vote_poll'];
		phpbb.addAjaxCallback('vote_poll', function (res) {
			scoreResultsCallback.call(this, res);
			if (!res.results_hidden && res.score_breakdowns) {
				setTimeout(function () {
					updateScoreBreakdowns(res.score_breakdowns);
				}, res.can_vote ? 800 : 1800);
			}
		});
	}

	// Modify the "view results" link to set the "don't want to vote"
	if ($.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_no_vote) {
		$('.poll_view_results a').click(function (event) {
			if ($('#ap-multi-poll').length) {
				return;
			}
			var $poll = $(this).parents('.topic_poll');
			var target = this.href;
			event.preventDefault();

			if (!$.wolfsblvt.advancedpoll_json_data.can_change_vote) {
				// Remove vote possibilitys
				$poll.find('.poll_max_votes, .poll_vote, .poll_option_select').hide(500);
			}

			// Set it in the database
			$.ajax({
				url:	location.href,
				type:	'POST',
				data: {
					no_vote:	true,
					form_token:	$poll.find('input[name="form_token"]').val(),
					creation_time:	$poll.find('input[name="creation_time"]').val(),
				},
			}).done(function (response) {
				if (response.success) {
					window.location.href = target;
				} else {
					window.alert(response.error || 'Unable to save your choice.');
				}
			});
		});
	}

	$('.ap-delete-vote').click(function () {
		if ($('#ap-multi-poll').length) {
			return;
		}
		var $button = $(this);
		var $poll = $button.parents('.topic_poll');
		$button.prop('disabled', true);
		$.ajax({
			url: location.href,
			type: 'POST',
			data: {
				delete_vote: true,
				form_token: $poll.find('input[name="form_token"]').val(),
				creation_time: $poll.find('input[name="creation_time"]').val(),
			},
		}).done(function (response) {
			if (response.success) {
				window.location.reload();
			} else {
				window.alert(response.error || 'Unable to delete your vote.');
				$button.prop('disabled', false);
			}
		}).fail(function () {
			$button.prop('disabled', false);
		});
	});
});
