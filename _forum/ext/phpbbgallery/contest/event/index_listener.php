<?php
/**
 * phpBB Gallery Contest index integration.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class index_listener implements EventSubscriberInterface
{
	private \phpbb\auth\auth $auth;
	private \phpbb\config\config $config;
	private \phpbb\controller\helper $helper;
	private \phpbb\language\language $language;
	private \phpbbgallery\contest\winner_search $winner_search;

	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\config\config $config,
		\phpbb\controller\helper $helper,
		\phpbb\language\language $language,
		\phpbbgallery\contest\winner_search $winner_search
	)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->helper = $helper;
		$this->language = $language;
		$this->winner_search = $winner_search;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.index.dropdown_links' => 'add_winner_search_link',
		];
	}

	public function add_winner_search_link(\phpbb\event\data $event): void
	{
		if (empty($this->config['load_search'])
			|| !$this->auth->acl_get('u_search')
			|| !$this->winner_search->has_visible_winners())
		{
			return;
		}

		$dropdown_links = (array) $event['dropdown_links'];
		$this->language->add_lang('contest', 'phpbbgallery/contest');
		$dropdown_links['U_G_SEARCH_CONTESTS'] = $this->helper->route('phpbbgallery_contest_search');
		$event['dropdown_links'] = $dropdown_links;
	}
}
