<?php

/**
 *
 * Sticky Elements. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\stickyelements\controller;

abstract class base
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
	public abstract function main($id, $mode, $u_action);

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
