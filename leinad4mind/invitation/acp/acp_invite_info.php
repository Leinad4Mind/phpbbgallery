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

namespace leinad4mind\invitation\acp;

class acp_invite_info
{
	function module()
	{
		return array(
			'filename'	=> '\leinad4mind\invitation\acp\acp_invite_module',
			'title'		=> 'ACP_CAT_INVITE',
			'modes'		=> array(
				'main'			=> array('title' => 'ACP_INVITE_MAIN'		, 'auth' => 'ext_leinad4mind/invitation && acl_a_'										, 'cat' => array('ACP_INVITE')),
				'config'		=> array('title' => 'ACP_INVITE_CONFIG'		, 'auth' => 'ext_leinad4mind/invitation && acl_a_invite_config'							, 'cat' => array('ACP_INVITE')),
				'handling'		=> array('title' => 'ACP_INVITE_HANDLING'	, 'auth' => 'ext_leinad4mind/invitation && (acl_a_invite_send || acl_a_invite_delete)'	, 'cat' => array('ACP_INVITE')),
				'claiming'		=> array('title' => 'ACP_INVITE_CLAIMING'	, 'auth' => 'ext_leinad4mind/invitation && (acl_a_invite_claiming)'						, 'cat' => array('ACP_INVITE')),
				'users'			=> array('title' => 'ACP_INVITE_USERS'		, 'auth' => 'ext_leinad4mind/invitation && acl_a_invite_users'							, 'cat' => array('ACP_INVITE')),
				'pend'			=> array('title' => 'ACP_INVITE_PENDING'	, 'auth' => 'ext_leinad4mind/invitation && acl_a_invite_pend'							, 'cat' => array('ACP_INVITE')),
			),
		);
	}
}
