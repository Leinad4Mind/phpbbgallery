<?php

/**
 *
 * Invitation. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2021, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation\mcp;

use leinad4mind\invitation\includes\module_base;

class mcp_invite_module extends module_base
{
	protected function get_controller_service_id()
	{
		return 'leinad4mind.invitation.controller.mcp';
	}
}
