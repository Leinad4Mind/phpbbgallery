/**
 * Advanced Polls multi-page ballot navigation and AJAX submission.
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */
/* global jQuery */
(function ($) {
	'use strict';

	var $container = $('#ap-multi-poll');
	var $native = $('form.topic_poll').first();
	if (!$container.length || !$native.length) {
		return;
	}

	var type = parseInt($container.data('type'), 10) || 0;
	var maxOptions = parseInt($container.data('max-options'), 10) || 1;
	var totalValue = parseInt($container.data('total-value'), 10) || 1;
	var rankPoints = String($container.data('rank-points') || '').split(',').filter(Boolean).map(Number);
	var $pages = $native.add($container.find('.ap-extra-page'));
	var pageIndex = 0;
	var submitting = false;

	$native.removeAttr('data-ajax').off('submit').attr('data-question-id', 'primary').attr('data-required', $container.data('primary-required'));
	$native.find('.poll_vote').hide();

	function extraRankOrder($page) {
		var order = [];
		$page.find('.ap-multi-rank:checked').each(function () {
			order.push({
				id: parseInt($(this).data('option-id'), 10),
				value: parseInt($(this).attr('data-current-value'), 10) || 0
			});
		});
		order.sort(function (a, b) {
			return rankPoints.indexOf(a.value) - rankPoints.indexOf(b.value);
		});
		return order.map(function (item) { return item.id; });
	}

	$container.find('.ap-extra-page').each(function () {
		var $page = $(this);
		$page.data('rank-order', extraRankOrder($page));
	});

	$container.on('change', '.ap-multi-rank', function () {
		var $choice = $(this);
		var $page = $choice.closest('.ap-extra-page');
		var order = $page.data('rank-order') || [];
		var optionId = parseInt($choice.data('option-id'), 10);
		order = order.filter(function (id) { return id !== optionId; });
		if ($choice.prop('checked')) {
			if (order.length >= maxOptions) {
				$choice.prop('checked', false);
				showMessage($container.data('ranking-error'), true);
			} else {
				order.push(optionId);
			}
		}
		$page.data('rank-order', order);
		$page.find('.ap-multi-rank').each(function () {
			var rank = order.indexOf(parseInt($(this).data('option-id'), 10));
			$(this).closest('.ap-ranking-choice').find('.ap-rank-badge').text(rank < 0 ? '' : rank + 1);
		});
	});

	function pageAnswer($page) {
		var answer = {};
		if ($page.is($native)) {
			if (type === 1) {
				$page.find('select[name^="vote_id["]').each(function () {
					var value = parseInt($(this).val(), 10) || 0;
					var match = this.name.match(/\[(\d+)\]/);
					if (value && match) { answer[match[1]] = value; }
				});
			} else if (type === 2) {
				$page.find('input.ap-rank-value').each(function () {
					var match = this.name.match(/\[(\d+)\]/);
					if (match) { answer[match[1]] = parseInt(this.value, 10) || 0; }
				});
			} else {
				$page.find('input[name="vote_id[]"]:checked').each(function () {
					var id = parseInt(this.value, 10);
					if (id > 0) { answer[id] = 1; }
				});
			}
		} else if (type === 1) {
			$page.find('.ap-multi-score').each(function () {
				var value = parseInt($(this).val(), 10) || 0;
				if (value) { answer[parseInt($(this).data('option-id'), 10)] = value; }
			});
		} else if (type === 2) {
			var order = $page.data('rank-order') || [];
			$.each(order, function (index, id) { answer[id] = rankPoints[index]; });
		} else {
			$page.find('.ap-multi-choice:checked').each(function () {
				answer[parseInt($(this).data('option-id'), 10)] = 1;
			});
		}
		return answer;
	}

	function validatePage($page) {
		var answer = pageAnswer($page);
		var values = Object.keys(answer).map(function (id) { return answer[id]; });
		var required = String($page.attr('data-required')) === '1';
		if (!values.length) {
			if (required) {
				showMessage($container.data('required-error'), true);
				return false;
			}
			return true;
		}
		if (type === 2 && values.length !== maxOptions) {
			showMessage($container.data('ranking-error'), true);
			return false;
		}
		if (type === 1 && values.reduce(function (sum, value) { return sum + value; }, 0) > totalValue) {
			showMessage($container.data('total-error'), true);
			return false;
		}
		if (type === 1 && values.length > maxOptions) {
			showMessage($container.data('too-many-error'), true);
			return false;
		}
		if (type === 0 && values.length > maxOptions) {
			showMessage($container.data('too-many-error'), true);
			return false;
		}
		showMessage('', false);
		return true;
	}

	function showPage(index) {
		pageIndex = Math.max(0, Math.min(index, $pages.length - 1));
		$pages.each(function (position) {
			$(this).prop('hidden', position !== pageIndex).toggle(position === pageIndex);
		});
		$container.find('.ap-poll-previous').toggle(pageIndex > 0);
		$container.find('.ap-poll-next').toggle(pageIndex < $pages.length - 1);
		$container.find('.ap-poll-submit').toggle(pageIndex === $pages.length - 1);
		$container.find('.ap-poll-progress').text((pageIndex + 1) + ' / ' + $pages.length);
	}

	function showMessage(message, error) {
		$container.find('.ap-poll-message').text(message || '').toggleClass('error', !!error);
	}

	function collectBallot() {
		var answers = {};
		$pages.each(function () {
			answers[String($(this).attr('data-question-id'))] = pageAnswer($(this));
		});
		return answers;
	}

	function updateResults(results) {
		$native.find('.poll_view_results').hide();
		$.each(results || {}, function (questionId, totals) {
			var $page = questionId === 'primary' ? $native : $container.find('[data-question-id="' + questionId + '"]');
			var sum = 0;
			$.each(totals, function (_, total) { sum += parseInt(total, 10) || 0; });
			$.each(totals, function (optionId, total) {
				var percent = sum ? Math.round(100 * total / sum) : 0;
				var $option = $page.find('[data-poll-option-id="' + optionId + '"]');
				$option.find('.resultbar').removeClass('hidden');
				$option.find('.poll_option_percent').removeClass('hidden').text(percent + '%');
				$option.find('.resultbar > div').css('width', percent + '%').text(total);
				$option.find('.badge').text(total);
			});
			$page.find('.poll_total_votes').removeClass('hidden').find('.poll_total_vote_cnt').text(sum);
		});
	}

	function updateBreakdowns(breakdowns) {
		$.each(breakdowns || {}, function (questionId, options) {
			var $page = questionId === 'primary' ? $native : $container.find('[data-question-id="' + questionId + '"]');
			$.each(options, function (optionId, breakdown) {
				var $option = $page.find('[data-poll-option-id="' + optionId + '"]');
				var $widget = $option.find('.ap-score-breakdown-widget').first();
				if (!$widget.length) {
					$widget = $('<dd class="ap-score-breakdown-widget"><button type="button" class="ap-score-breakdown-trigger" aria-expanded="false"></button><span class="ap-score-breakdown-popup" role="tooltip"><strong></strong><span class="ap-score-breakdown-list"></span></span></dd>');
					$option.append($widget);
				}
				$widget.find('.ap-score-breakdown-trigger').text(breakdown.total).attr('aria-label', breakdown.total + '. ' + breakdown.label);
				$widget.find('strong').text(breakdown.label);
				$widget.find('.ap-score-breakdown-list').html(breakdown.detail);
			});
		});
	}

	function updateVoters(voters) {
		$.each(voters || {}, function (questionId, options) {
			var $page = questionId === 'primary' ? $native : $container.find('[data-question-id="' + questionId + '"]');
			$.each(options, function (optionId, names) {
				var $option = $page.find('[data-poll-option-id="' + optionId + '"]');
				var $box = $option.find('.poll_voters_box').first();
				if (!$box.length) { $box = $option.next('.poll_voters_box').first(); }
				if (!$box.length) {
					$box = $('<dd class="poll_voters_box"></dd>').append(document.createTextNode($container.data('voters-label') + ' ')).append('<span class="poll_voters"></span>');
					$option.append($box);
				}
				var $voterList = $box.removeClass('hidden').find('.poll_voters').empty();
				if (names) { $voterList.html(names); } else { $voterList.append($('<span>').attr('name', 'none').text($container.data('none-label'))); }
			});
		});
	}

	function submitBallot() {
		for (var index = 0; index < $pages.length; index++) {
			if (!validatePage($pages.eq(index))) {
				showPage(index);
				return;
			}
		}
		if (submitting) { return; }
		submitting = true;
		var tokenData = {};
		$.each($native.serializeArray(), function (_, field) {
			if (field.name === 'form_token' || field.name === 'creation_time') {
				tokenData[field.name] = field.value;
			}
		});
		tokenData.answers = JSON.stringify(collectBallot());
		$.ajax({
			url: $container.data('vote-url'),
			method: 'POST',
			dataType: 'json',
			data: tokenData
		}).done(function (response) {
			showMessage(response.message, false);
			if (!response.results_hidden) {
				updateResults(response.results);
				updateBreakdowns(response.breakdowns);
				updateVoters(response.voters);
			}
			if (!response.can_vote) {
				$pages.find(':input').prop('disabled', true);
				$container.find('.ap-poll-submit').hide();
				$native.find('.poll_view_results').hide();
			}
		}).fail(function (xhr) {
			var response = xhr.responseJSON || {};
			showMessage(response.error || 'Error', true);
		}).always(function () {
			submitting = false;
		});
	}

	$container.on('click', '.ap-poll-previous', function () { showPage(pageIndex - 1); });
	$container.on('click', '.ap-poll-next', function () {
		if (validatePage($pages.eq(pageIndex))) { showPage(pageIndex + 1); }
	});
	$container.on('click', '.ap-poll-submit', submitBallot);
	$native.on('click.apMultiQuestion', '.poll_view_results a', function (event) {
		if (String($container.data('no-vote')) !== '1') {
			return;
		}
		event.preventDefault();
		var tokenData = {no_vote: 1};
		$.each($native.serializeArray(), function (_, field) {
			if (field.name === 'form_token' || field.name === 'creation_time') {
				tokenData[field.name] = field.value;
			}
		});
		$.ajax({
			url: $container.data('vote-url'),
			method: 'POST',
			dataType: 'json',
			data: tokenData
		}).done(function (response) {
			if (!response.results_hidden) {
				updateResults(response.results);
				updateBreakdowns(response.breakdowns);
				updateVoters(response.voters);
			}
			if (!response.can_vote) {
				$pages.find(':input').prop('disabled', true);
				$container.find('.ap-poll-submit').hide();
				$native.find('.poll_view_results').hide();
			}
			showMessage(response.message, false);
		}).fail(function (xhr) {
			var response = xhr.responseJSON || {};
			showMessage(response.error || 'Error', true);
		});
	});
	$('.ap-delete-vote').on('click.apMultiQuestion', function (event) {
		event.preventDefault();
		var tokenData = {delete_vote: 1};
		$.each($native.serializeArray(), function (_, field) {
			if (field.name === 'form_token' || field.name === 'creation_time') {
				tokenData[field.name] = field.value;
			}
		});
		$.ajax({
			url: $container.data('vote-url'),
			method: 'POST',
			dataType: 'json',
			data: tokenData
		}).done(function (response) {
			$pages.find('input:checkbox, input:radio').prop('checked', false);
			$pages.find('select').val('0');
			$pages.find('.ap-rank-badge').empty();
			$container.find('.ap-extra-page').data('rank-order', []);
			if (!response.results_hidden) {
				updateResults(response.results);
				updateBreakdowns(response.breakdowns);
				updateVoters(response.voters);
			}
			$pages.find(':input').prop('disabled', false);
			if (String($container.data('no-vote')) === '1') { $native.find('.poll_view_results').show(); }
			showPage(pageIndex);
			showMessage(response.message, false);
		}).fail(function (xhr) {
			var response = xhr.responseJSON || {};
			showMessage(response.error || 'Error', true);
		});
	});
	$native.on('submit.apMultiQuestion', function (event) {
		event.preventDefault();
		if (pageIndex < $pages.length - 1) {
			if (validatePage($pages.eq(pageIndex))) { showPage(pageIndex + 1); }
		} else {
			submitBallot();
		}
	});
	showPage(0);
})(jQuery);
