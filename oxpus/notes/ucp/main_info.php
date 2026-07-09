<?php

/**
*
* @package phpBB Extension - Personal notes
* @copyright (c) 2014 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace oxpus\notes\ucp;

class main_info
{
	function module()
	{
		global $config;

		return [
			'filename'	=> '\oxpus\notes\ucp\main_info',
			'title'		=> 'NOTES',
			'version'	=> $config['notes_version'],
			'modes'		=> [
				'main'	=> ['title' => 'UCP_NOTES_CONFIG', 'auth' => 'ext_oxpus/notes', 'cat' => ['NOTES']],
			],
		];
	}
}
