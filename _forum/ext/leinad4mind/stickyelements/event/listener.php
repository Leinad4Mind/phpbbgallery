<?php

/**
 *
 * Sticky Elements. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\stickyelements\event;

use leinad4mind\stickyelements\includes\helper;
use phpbb\path_helper;
use phpbb\template\template;
use phpbb\textformatter\renderer_interface;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var user */
	protected $user;

	/** @var template  */
	protected $template;

	/** @var renderer_interface */
	protected $renderer;

	/** @var path_helper */
	protected $path_helper;

	/** @var helper */
	protected $helper;

	/**
	 * @param user					$user
	 * @param template				$template
	 * @param renderer_interface	$renderer
	 * @param path_helper			$path_helper
	 * @param helper				$helper
	 */
	public function __construct(
		user $user,
		template $template,
		renderer_interface $renderer,
		path_helper $path_helper,
		helper $helper
	)
	{
		$this->user			= $user;
		$this->template		= $template;
		$this->renderer		= $renderer;
		$this->path_helper	= $path_helper;
		$this->helper		= $helper;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.page_footer' => 'page_footer',
		];
	}

	/**
	 *
	 */
	public function page_footer()
	{
		$stickyelements = [];

		foreach ($this->helper->get_stickyelements() as $stickyelement)
		{
			if (!$stickyelement['only_index'] || ($this->user->page['page_dir'] . $this->user->page['page_name'] == 'index.' . $this->path_helper->get_php_ext()))
			{
				$stickyelement['text'] = $this->renderer->render($stickyelement['text']);
				$stickyelements[] = $stickyelement;
			}
		}

		$this->template->assign_vars([
			'STICKYELEMENTS' => $stickyelements,
		]);
	}
}
