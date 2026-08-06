/**
 * Advanced Polls multi-question posting editor.
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */
/* global jQuery */
(function ($) {
	'use strict';

	var $editor = $('.ap-multi-question-editor');
	var $storage = $('#ap_multi_questions');
	var questions = [];
	if (!$editor.length || !$storage.length) {
		return;
	}

	try {
		questions = JSON.parse($storage.val() || '[]');
		questions = Array.isArray(questions) ? questions : [];
	} catch (error) {
		questions = [];
	}

	function escapeHtml(value) {
		return $('<div>').text(value || '').html();
	}

	function collect() {
		var updated = [];
		$editor.find('.ap-question-card').each(function (questionIndex) {
			var $card = $(this);
			var originalIds = {};
			$.each((questions[questionIndex] && questions[questionIndex].options) || [], function (_, option) {
				var text = typeof option === 'string' ? option : option.text;
				originalIds[text] = originalIds[text] || [];
				originalIds[text].push(typeof option === 'string' ? 0 : (parseInt(option.id, 10) || 0));
			});
			var options = [];
			$.each($card.find('.ap-question-options').val().split(/\r?\n/), function (index, text) {
				text = $.trim(text);
				if (text) {
					var matchingIds = originalIds[text] || [];
					options.push({id: matchingIds.length ? matchingIds.shift() : 0, text: text});
				}
			});
			updated.push({
				id: parseInt($card.attr('data-question-id'), 10) || 0,
				text: $.trim($card.find('.ap-question-text').val()),
				required: $card.find('.ap-question-required').prop('checked'),
				options: options
			});
		});
		questions = updated;
		$storage.val(JSON.stringify(questions));
	}

	function render() {
		var html = '';
		$.each(questions, function (index, question) {
			var texts = [];
			var ids = [];
			$.each(question.options || [], function (_, option) {
				texts.push(typeof option === 'string' ? option : option.text);
				ids.push(typeof option === 'string' ? 0 : (parseInt(option.id, 10) || 0));
			});
			html += '<fieldset class="ap-question-card panel" data-question-id="' + (parseInt(question.id, 10) || 0) + '" data-option-ids="' + ids.join(',') + '">';
			html += '<legend>' + escapeHtml($editor.data('question-label')) + ' ' + (index + 2) + '</legend>';
			html += '<input type="text" class="inputbox form-control ap-question-text" maxlength="255" value="' + escapeHtml(question.text || '') + '" />';
			html += '<label>' + escapeHtml($editor.data('options-label')) + '<textarea class="inputbox form-control ap-question-options" rows="5">' + escapeHtml(texts.join('\n')) + '</textarea></label>';
			html += '<label><input type="checkbox" class="ap-question-required"' + (question.required ? ' checked="checked"' : '') + ' /> ' + escapeHtml($editor.data('required-label')) + '</label> ';
			html += '<button type="button" class="button2 btn btn-default ap-remove-question">' + escapeHtml($editor.data('remove-label')) + '</button></fieldset>';
		});
		$editor.find('.ap-question-list').html(html);
		$editor.find('.ap-add-question').prop('disabled', questions.length >= (parseInt($editor.data('max-questions'), 10) || 20));
	}

	$editor.on('click', '.ap-add-question', function () {
		collect();
		if (questions.length >= (parseInt($editor.data('max-questions'), 10) || 20)) { return; }
		questions.push({id: 0, text: '', required: false, options: [{id: 0, text: ''}, {id: 0, text: ''}]});
		render();
	});
	$editor.on('click', '.ap-remove-question', function () {
		$(this).closest('.ap-question-card').remove();
		collect();
		render();
	});
	$editor.closest('form').on('submit', collect);
	render();
})(jQuery);
