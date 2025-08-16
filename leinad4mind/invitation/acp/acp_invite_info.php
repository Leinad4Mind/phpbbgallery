<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2018, Leinad4Mind, https://leinad4mind.top/forum
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
			'title'		=> 'ACP_CAT_MEGHIVO',
			'modes'		=> array(
				'main'			=> array('title' => 'ACP_MEGHIVO_MAIN'		, 'auth' => 'ext_leinad4mind/invitation && acl_a_'											, 'cat' => array('ACP_MEGHIVO')),
				'config'		=> array('title' => 'ACP_MEGHIVO_CONFIG'	, 'auth' => 'ext_leinad4mind/invitation && acl_a_meghivo_config'							, 'cat' => array('ACP_MEGHIVO')),
				'kezeles'		=> array('title' => 'ACP_MEGHIVO_KEZELES'	, 'auth' => 'ext_leinad4mind/invitation && (acl_a_meghivo_kuldes || acl_a_meghivo_delete)'	, 'cat' => array('ACP_MEGHIVO')),
				'igeny'			=> array('title' => 'ACP_MEGHIVO_IGENY'		, 'auth' => 'ext_leinad4mind/invitation && (acl_a_meghivo_igeny)'							, 'cat' => array('ACP_MEGHIVO')),
				'users'			=> array('title' => 'ACP_MEGHIVO_USERS'		, 'auth' => 'ext_leinad4mind/invitation && acl_a_meghivo_users'							, 'cat' => array('ACP_MEGHIVO')),
				'pend'			=> array('title' => 'ACP_MEGHIVO_PENDING'	, 'auth' => 'ext_leinad4mind/invitation && acl_a_meghivo_pend'								, 'cat' => array('ACP_MEGHIVO')),
			),
		);
	}
}
