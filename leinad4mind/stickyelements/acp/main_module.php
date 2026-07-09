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

class main_module extends base
{
	/**
	 * @return string
	 */
	protected function get_controller_service_id()
	{
		return 'leinad4mind.stickyelements.controller.acp';
	}
}
