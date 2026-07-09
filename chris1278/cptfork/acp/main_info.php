<?php
/**
 *
 * CF Change Post Time
 *
 * @copyright (c) 2024 chris1278
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
 */

namespace chris1278\cptfork\acp;

class main_info
{
	public function module()
	{
		return [
			'filename'	=> '\chris1278\cptfork\acp\main_module',
			'title'		=> 'CF_CPT_TITLE',
			'modes'		=> [
				'settings'	=> [
					'title'	=> 'CF_CPT_SETTING',
					'auth'	=> 'ext_chris1278/cptfork',
					'cat'	=> ['CF_CPT_TITLE'],
				],
			],
		];
	}
}
