var sitesplat_bbcore_updater_steps = [
	'<li><i class="fa-li fa fa-circle-o-notch fa-spin"></i> Backup style</li>',
	'<li><i id="t1_get_current_style_cfg" class="fa-li fa"></i> Get current style version config</li>',
	'<li><i id="t2_get_newest_style_cfg" class="fa-li fa"></i> Get newest style version config</li>',		
	'<li><i id="t3_check_problems" class="fa-li fa"></i> Check for problems</li>',
	'<li><i id="t4_download_newest_version" class="fa-li fa"></i> Download newest version</li>',
	'<li><i id="t5_unzip_new_version" class="fa-li fa"></i> Unzip newest version</li>',
	'<li><i id="t6_load_list_of_changes" class="fa-li fa"></i> Load list of changes</li>',
	'<li><i id="t7_merge_edits" class="fa-li fa"></i> Merge edits</li>',
//	'<li><i id="t8_check_additions" class="fa-li fa"></i> Check additions</li>',
	'<li><i id="t9_update_edits" class="fa-li fa"></i> Update edits</li>',
	'<li><i id="t10_update_added" class="fa-li fa"></i> Update additions</li>',
	'<li><i id="t11_update_deleted" class="fa-li fa"></i> Update deletions</li>',
	'<li><i id="t12_log_changes" class="fa-li fa"></i> Log changes</li>'
];
var alert_out = false;

$('.sitesplat-bbcore-autoupdate').on('click', function(e) {
	e.preventDefault();
	var self = this;

	$.get(self.href, function(res) {
		phpbb.confirm(res.MESSAGE_BODY, function(confirmed) {
			if (!confirmed) {
				return;
			}
			// this will prevent phpBB from closing the alert
			setTimeout(function() {
				phpbb.alert('Progress', '<ul class="fa-ul">' + sitesplat_bbcore_updater_steps.join('') + '</ul>');
				$.get($(self).attr('data-href'), function(res) {
					process_next_step(res);
				});
			}, phpbb.alertTime + 100);
		})
	});
});

function process_next_step(res) {
	if (typeof res.continue !== 'undefined' && res.continue) {
		if (res.last_step != $('.fa-circle-o-notch').attr('id')) {
			$currentStep = $('.fa-circle-o-notch');
			$currentStep.removeClass('fa-circle-o-notch fa-spin').addClass('fa-check');
			$currentStep.parent().next().children('i').addClass('fa-circle-o-notch fa-spin');
		}

		// next step
		$.get(res.href.split('&amp;').join('&'), function(res) {
			process_next_step(res);
		});
	} else {
		phpbb.alert(res.MESSAGE_TITLE, res.MESSAGE_TEXT);
	}
}
