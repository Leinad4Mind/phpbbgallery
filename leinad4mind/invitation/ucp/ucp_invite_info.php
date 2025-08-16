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
			'title'		=> 'UCP_CAT_INVITE',
			'modes'		=> array(
				'data'			=> array('title' => 'UCP_INVITE_DATA',		 'auth' => 'ext_leinad4mind/invitation && acl_u_invite_sending', 						 'cat' => array('UCP_INVITE')),
				'send'			=> array('title' => 'UCP_INVITE_SEND',		 'auth' => 'ext_leinad4mind/invitation && acl_u_invite_sending', 						 'cat' => array('UCP_INVITE')),
				'delete'		=> array('title' => 'UCP_INVITE_DELETE',	 'auth' => 'ext_leinad4mind/invitation && acl_u_invite_sending && acl_u_invite_delete',	 'cat' => array('UCP_INVITE')),
				'request'		=> array('title' => 'UCP_INVITE_REQUEST',	 'auth' => 'ext_leinad4mind/invitation && acl_u_invite_sending && acl_u_invite_request', 'cat' => array('UCP_INVITE')),
				'user'			=> array('title' => 'UCP_INVITE_USER',		 'auth' => 'ext_leinad4mind/invitation && acl_u_invite_sending',						 'cat' => array('UCP_INVITE')),
			),
		);
	}
}
