<?php
/**
 *
 * Mass Notification. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\massnotification\acp;

/**
 * Mass Notification ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\senky\massnotification\acp\main_module',
			'title'		=> 'ACP_SENKY_MASSNOTIFICATION_TITLE',
			'modes'		=> array(
				'notification'	=> array(
					'title'	=> 'ACP_SENKY_MASSNOTIFICATION_TITLE',
					'auth'	=> 'ext_senky/massnotification && acl_a_board',
					'cat'	=> array('ACP_GENERAL_TASKS')
				),
			),
		);
	}
}
