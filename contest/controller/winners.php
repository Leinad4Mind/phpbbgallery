<?php
/**
 * phpBB Gallery Contest winner controller.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\controller;

class winners
{
	private \phpbb\auth\auth $auth;
	private \phpbb\config\config $config;
	private \phpbb\template\template $template;
	private \phpbb\language\language $language;
	private \phpbb\controller\helper $helper;
	private \phpbbgallery\core\config $gallery_config;
	private \phpbbgallery\contest\winner_search $winner_search;

	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\language\language $language,
		\phpbb\controller\helper $helper,
		\phpbbgallery\core\config $gallery_config,
		\phpbbgallery\contest\winner_search $winner_search
	)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->template = $template;
		$this->language = $language;
		$this->helper = $helper;
		$this->gallery_config = $gallery_config;
		$this->winner_search = $winner_search;
	}

	public function base(int $page = 1): \Symfony\Component\HttpFoundation\Response
	{
		$page = max(1, $page);
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$this->language->add_lang('search');

		if (!$this->auth->acl_get('u_search') || empty($this->config['load_search']))
		{
			$this->template->assign_var('S_NO_SEARCH', true);
			trigger_error('NO_SEARCH');
		}

		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME' => $this->gallery_config->get_title($this->language),
			'U_VIEW_FORUM' => $this->helper->route('phpbbgallery_core_index'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME' => $this->language->lang('SEARCH'),
			'U_VIEW_FORUM' => $this->helper->route('phpbbgallery_core_search'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME' => $this->language->lang('SEARCH_CONTEST'),
			'U_VIEW_FORUM' => $this->helper->route('phpbbgallery_core_search_contests'),
		]);

		$limit = max(1, (int) $this->gallery_config->get('album_rows'));
		$this->winner_search->display($limit, ($page - 1) * $limit);

		return $this->helper->render(
			'gallery/search_results.html',
			$this->gallery_config->get_title($this->language)
		);
	}
}
