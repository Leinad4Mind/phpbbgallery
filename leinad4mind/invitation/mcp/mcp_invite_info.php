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

class mcp_invite_info
{
	function module()
	{
		return array(
			'filename'	=> '\leinad4mind\invitation\mcp\mcp_invite_module',
			'title'		=> 'MCP_CAT_MEGHIVO',
			'modes'		=> array(
				'jovahagyas'	=> array('title' => 'MCP_MEGHIVO_JOVAHAGYAS', 'auth' => 'ext_leinad4mind/invitation && acl_m_meghivo_igeny', 'cat' => array('MCP_MEGHIVO')),
			),
		);
	}
}
