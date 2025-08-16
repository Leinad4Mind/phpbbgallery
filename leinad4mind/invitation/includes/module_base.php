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

namespace leinad4mind\invitation\includes;

use leinad4mind\invitation\controller\controller_base;

abstract class module_base
{
	var $u_action;
	var $tpl_name;
	var $page_title;

	/** @var controller_base */
	protected $controller;

	/**
	 * @return string
	 */
	abstract protected function get_controller_service_id();

	/**
	 * @param string $id
	 * @param string $mode
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;

		$this->controller = $phpbb_container->get($this->get_controller_service_id());
		$this->controller->main($id, $mode, $this->u_action);
		$this->tpl_name = $this->controller->get_tpl_name();
		$this->page_title = $this->controller->get_page_title();
	}

	/**
	 * @param string $method
	 * @param array $args
	 * @return mixed
	 */
	public function __call($method, $args)
	{
        return call_user_func_array(array($this->controller, $method), $args);
    }
}
