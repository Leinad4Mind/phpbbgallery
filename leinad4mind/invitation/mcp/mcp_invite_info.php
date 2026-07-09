<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation\mcp;

class mcp_invite_info
{
	function module()
	{
		return array(
			'filename'	=> '\leinad4mind\invitation\mcp\mcp_invite_module',
			'title'		=> 'MCP_CAT_INVITE',
			'modes'		=> array(
				'confirmation'	=> array('title' => 'MCP_INVITE_CONFIRMATION', 'auth' => 'ext_leinad4mind/invitation && acl_m_invite_claiming', 'cat' => array('MCP_INVITE')),
			),
		);
	}
}
