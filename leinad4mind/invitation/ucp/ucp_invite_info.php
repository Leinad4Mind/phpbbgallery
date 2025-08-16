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

namespace leinad4mind\invitation\ucp;

class ucp_invite_info
{
	function module()
	{
		return array(
			'filename'	=> '\leinad4mind\invitation\ucp\ucp_invite_module',
			'title'		=> 'UCP_CAT_MEGHIVO',
			'modes'		=> array(
				'adat'			=> array('title' => 'UCP_MEGHIVO_ADAT'	, 'auth' => 'ext_leinad4mind/invitation && acl_u_meghivo_kuld', 						'cat' => array('UCP_MEGHIVO')),
				'kuldes'		=> array('title' => 'UCP_MEGHIVO_KULDES', 'auth' => 'ext_leinad4mind/invitation && acl_u_meghivo_kuld', 						'cat' => array('UCP_MEGHIVO')),
				'delete'		=> array('title' => 'UCP_MEGHIVO_DELETE', 'auth' => 'ext_leinad4mind/invitation && acl_u_meghivo_kuld && acl_u_meghivo_delet', 'cat' => array('UCP_MEGHIVO')),
				'keres'			=> array('title' => 'UCP_MEGHIVO_KERES'	, 'auth' => 'ext_leinad4mind/invitation && acl_u_meghivo_kuld && acl_u_meghivo_keres', 'cat' => array('UCP_MEGHIVO')),
				'user'			=> array('title' => 'UCP_MEGHIVO_USER'	, 'auth' => 'ext_leinad4mind/invitation && acl_u_meghivo_kuld',						'cat' => array('UCP_MEGHIVO')),
			),
		);
	}
}
