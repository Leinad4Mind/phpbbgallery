/**
 *
 * @package phpBB Extension - Favicon Notifications
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

jQuery(function($) {

	'use strict';

	// Initialize favicon
	let favicon = new Favico({
		bgColor		: '#d00',
		textColor	: '#fff',
		fontFamily	: 'sans-serif',
		fontStyle	: 'bold',
		type		: 'circle',
		position	: 'up',
		animation	: 'popFade',
	});

	let setUnreadNotificationsCount = function(count) {
		favicon.badge(count);
	};

	// Set initial notifications count
	let unreadCount = parseInt($('strong', '#notification_list_button').html());
	setUnreadNotificationsCount(unreadCount);

	// Update notifications count when marking notifications read
	let phpbbMarkNotifications = phpbb.markNotifications;
	phpbb.markNotifications = function($popup, unreadCount) {
		setUnreadNotificationsCount(unreadCount);
		return phpbbMarkNotifications($popup, unreadCount);
	};

	// Listen to notifications count updates from extensions
	$(phpbb).on('kasimi_faviconnotifications_update', function(event, notificationsCount) {
		setUnreadNotificationsCount(notificationsCount);
	});
});
