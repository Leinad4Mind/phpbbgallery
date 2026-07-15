<?php

/**
*
* @package phpBB Extension - Personal notes
* @copyright (c) 2014 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace oxpus\notes\acp;

class main_info
{
	function module()
	{
		global $config;

		return [
			'filename'	=> '\oxpus\notes\acp\main_info',
			'title'		=> 'ACP_NOTES',
			'version'	=> $config['notes_version'],
			'modes'		=> [
				'main'		=> ['title' => 'ACP_NOTES', 'auth' => 'ext_oxpus/notes && acl_a_notes', 'cat' => ['NOTES']],
			],
		];
	}
}
