/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

$(document).ready(function () {
	var $type = $('#wolfsblvt_poll_type');
	var $positions = $('#wolfsblvt_poll_max_options');
	var $points = $('#ap-rank-point-inputs');

	function positionLabel(position) {
		return ($points.attr('data-position-label') || 'Position %d').replace('%d', position);
	}

	function syncPointInputs() {
		var count = Math.max(1, Math.min(50, parseInt($positions.val(), 10) || 1));
		$positions.val(count);
		var values = [];
		$points.find('input').each(function () {
			values.push(parseInt(this.value, 10) || 0);
		});
		var preserveValues = values.length === count;
		$points.empty();
		for (var index = 0; index < count; index++) {
			var suggested = Math.max(1, count - index);
			var value = preserveValues && values[index] ? values[index] : suggested;
			var $label = $('<label class="ap-rank-point"></label>');
			$('<span></span>').text(positionLabel(index + 1)).appendTo($label);
			$('<input type="number" min="1" max="999" name="wolfsblvt_poll_rank_points[]" class="inputbox autowidth" />')
				.val(value)
				.appendTo($label);
			$label.appendTo($points);
		}
	}

	function toggleSettings() {
		var type = parseInt($type.val(), 10);
		$('#ap-scoring-settings').toggle(type === 1);
		$('#ap-ranking-settings').toggle(type === 2);
		if (type === 2) {
			syncPointInputs();
		}
	}

	$type.on('change', toggleSettings);
	$positions.on('change input', function () {
		if (parseInt($type.val(), 10) === 2) {
			syncPointInputs();
		}
	});
	toggleSettings();
});
