(function () {
	'use strict';

	var form = document.getElementById('userdefaults-sync');
	if (!form || !window.fetch || !window.FormData)
	{
		return;
	}

	var button = document.getElementById('sync_users');
	var cursor = document.getElementById('sync_cursor');
	var status = document.getElementById('sync_status');
	var progress = document.getElementById('sync_progress');

	function updateProgress(data)
	{
		var total = Number(data.total) || 0;
		var completed = Number(data.completed) || 0;
		var percent = total > 0 ? Math.min(100, Math.round((completed / total) * 100)) : 100;
		progress.hidden = false;
		progress.value = percent;
		progress.textContent = percent + '%';
		status.textContent = completed + ' / ' + total;
	}

	function runBatch(previousCursor)
	{
		cursor.value = previousCursor;
		var data = new FormData(form);
		data.set('sync_users', '1');

		return window.fetch(form.action, {
			method: 'POST',
			body: data,
			credentials: 'same-origin',
			headers: {'X-Requested-With': 'XMLHttpRequest'}
		}).then(function (response) {
			if (!response.ok)
			{
				throw new Error('HTTP ' + response.status);
			}
			return response.json();
		}).then(function (result) {
			if (result.error)
			{
				throw new Error(result.error);
			}
			updateProgress(result);
			if (!result.done)
			{
				var nextCursor = Number(result.next_cursor) || 0;
				if (nextCursor <= Number(previousCursor))
				{
					throw new Error('Synchronization cursor did not advance.');
				}
				return runBatch(nextCursor);
			}
			status.textContent += ' - ' + form.getAttribute('data-complete');
			return result;
		});
	}

	form.setAttribute('data-complete', form.getAttribute('data-complete') || 'Complete');
	form.addEventListener('submit', function (event) {
		event.preventDefault();
		if (!document.getElementById('sync_confirm').checked)
		{
			return;
		}
		button.disabled = true;
		status.textContent = form.getAttribute('data-running') || 'Synchronizing...';
		runBatch(Number(cursor.value) || 0).catch(function (error) {
			status.textContent = error.message;
			button.disabled = false;
		});
	});
}());
