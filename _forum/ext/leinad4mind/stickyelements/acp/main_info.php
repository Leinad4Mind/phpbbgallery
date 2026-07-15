<?php

/**
 *
 * Sticky Elements. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\stickyelements\acp;

class main_info
{
	/**
	 * @return array
	 */
	public function module()
	{
		return [
			'filename'	=> '\leinad4mind\stickyelements\acp\main_module',
			'title'		=> 'ACP_STICKYELEMENTS_TITLE',
			'modes'		=> [
				'settings' => [
					'title'		=> 'ACP_STICKYELEMENTS_TITLE',
					'auth'		=> 'ext_leinad4mind/stickyelements',
					'cat'		=> ['ACP_STICKYELEMENTS_TITLE'],
				],
			],
		];
	}
}
