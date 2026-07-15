<?php
/**
 *
 * BBajaxnews. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\bbajaxnews\controller;

class main
{
	protected $ajaxnews_manager;
	protected $user;
	public function __construct(\sitesplat\bbajaxnews\ajaxnews\manager $ajaxnews_manager, \phpbb\user $user)
	{
		$this->ajaxnews_manager = $ajaxnews_manager;
		$this->user = $user;
	}

	public function handle()
	{
		if (!$this->user->data['is_registered'])
		{
			throw new \phpbb\controller\exception();
		}

		return new \Symfony\Component\HttpFoundation\JsonResponse([
			'message'	=> $this->ajaxnews_manager->retrieve_casual_ajaxnews(),
		], 200);
	}
}
