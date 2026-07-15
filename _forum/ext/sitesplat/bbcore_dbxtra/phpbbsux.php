<?php
function get_usable_memory() {
	if (preg_match('`(\\d+)([mkg]?)`', strtolower(trim(@ini_get('memory_limit'))), $val)) {
		$memory_limit = (int) $val[1];
		switch ($val[2]) {
			case 'k':
				$memory_limit *= 1024;
			break;

			case 'm':
				$memory_limit *= 1048576;
			break;

			case 'g':
				$memory_limit *= 1073741824;
			break;
		}

		return ($memory_limit - 6*1048576) * 0.75;
	}
	else {
		return 4*1048576;
	}
}
