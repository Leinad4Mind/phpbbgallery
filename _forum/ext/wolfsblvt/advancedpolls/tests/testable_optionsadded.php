<?php
/**
 *
 * Advanced Polls tests
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\tests;

use wolfsblvt\advancedpolls\notification\optionsadded;

class testable_optionsadded extends optionsadded
{
	public $captured_users = array();
	public $captured_forum_id;
	public $captured_sort;

	protected function get_authorised_recipients($users, $forum_id, $options, $sort = false)
	{
		$this->captured_users = $users;
		$this->captured_forum_id = $forum_id;
		$this->captured_sort = $sort;
		return array(2 => array('notification.method.board'));
	}
}
