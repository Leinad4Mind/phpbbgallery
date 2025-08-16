<?php

/**
 *
 * @package phpBB Extension - Group Rules
 * @copyright (c) 2017-2018 Leinad4Mind - https://leinad4mind.top/forum
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\grouprules\acp;

class grouprules_module extends base
{
	/**
	 * @return string
	 */
	protected function get_controller_service_id()
	{
		return 'leinad4mind.grouprules.controller.acp';
	}
}
