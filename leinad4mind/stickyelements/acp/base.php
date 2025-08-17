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

use leinad4mind\stickyelements\controller\base as controller_base;

abstract class base
{
	/** @var string */
	var $u_action;

	/** @var string */
	var $tpl_name;

	/** @var string */
	var $page_title;

	/** @var controller_base */
	protected $controller;

	/**
	 * @return string
	 */
	protected abstract function get_controller_service_id();

	/**
	 * @param string $id
	 * @param string $mode
	 * @throws \Exception
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;

		$controller_service  = $this->get_controller_service_id();
		$this->controller = $phpbb_container->get($controller_service);
		$this->controller->main($id, $mode, $this->u_action);

		$this->tpl_name = $this->controller->get_tpl_name();
		$this->page_title = $this->controller->get_page_title();
	}
}
