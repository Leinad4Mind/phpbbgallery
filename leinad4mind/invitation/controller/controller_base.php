<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation\controller;

abstract class controller_base
{
	/** @var string */
	protected $tpl_name;

	/** @var string */
	protected $page_title;

	/**
	 * @param string $id
	 * @param string $mode
	 * @param string $u_action
	 */
	abstract public function main($id, $mode, $u_action);

	/**
	 * @return string
	 */
	public function get_tpl_name()
	{
		return $this->tpl_name;
	}

	/**
	 * @return string
	 */
	public function get_page_title()
	{
		return $this->page_title;
	}
}
