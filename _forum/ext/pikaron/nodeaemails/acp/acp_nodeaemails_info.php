<?php
/**
 *
 * No DEA Emails. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Picaron, https://github.com/picaronin/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace pikaron\nodeaemails\acp;

class acp_nodeaemails_info
{
	public function module()
	{
		return array(
			'filename'		=> '\pikaron\nodeaemails\acp\acp_nodeaemails_module',
			'title'			=> 'LOG_NO_DEA_EMAILS',
			'modes'			=> array(
				'configuration'	=> array(
					'title' => 'LOG_NO_DEA_EMAILS_SETTINGS',
					'auth'	=> 'ext_pikaron/nodeaemails && acl_a_board',
					'cat'	=> array('ACP_CAT_DOT_MODS'),
				),
				'locals'	=> array(
					'title' => 'LOG_NO_DEA_EMAILS_LOCALS',
					'auth'	=> 'ext_pikaron/nodeaemails && acl_a_board',
					'cat'	=> array('ACP_CAT_DOT_MODS'),
				),
				'users'		=> array(
					'title' => 'LOG_NO_DEA_EMAILS_USERS',
					'auth'	=> 'ext_pikaron/nodeaemails && acl_a_board',
					'cat'	=> array('ACP_CAT_DOT_MODS'),
				),
			),
		);
	}
}
