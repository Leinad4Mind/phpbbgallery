<?php
if (!defined('BBEMOJI_DEFAULT_ICON_SQL')) {
	define('BBEMOJI_DEFAULT_ICON_SQL', "
	(1, ':fire:', 1, 1),
	(2, ':blush:', 2, 1),
	(3, ':grin:', 3, 1),
	(4, ':heartpulse:', 4, 1),
	(5, ':star:', 5, 1),
	(6, ':boom:', 6, 1),
	(7, ':pensive:', 7, 1),
	(8, ':grey_question:', 8, 1),
	(9, ':rocket:', 9, 1),
	(10, ':skull:', 10, 1)");

	// This is the same number as the max ID in the INSERT values above
	define('BBEMOJI_DEFAULT_ICON_MAX', 10);
}
