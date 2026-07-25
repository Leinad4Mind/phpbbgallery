<?php
/**
*
* @package phpBB Extension - Basic Stats
* @copyright (c) 2025 Stoker
* @copyright (c) 2015 OXPUS
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

declare(strict_types=1);

namespace stoker\basicstats\event;

use phpbb\auth\auth;
use phpbb\controller\helper;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class main_listener implements EventSubscriberInterface
{
	protected string $php_ext;
	protected helper $helper;
	protected template $template;
	protected user $user;
	protected auth $auth;
	protected language $language;

	public function __construct(string $php_ext, helper $helper, template $template, user $user, auth $auth, language $language)
	{
		$this->php_ext = $php_ext;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->auth = $auth;
		$this->language = $language;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.user_setup'					=> 'load_language_on_setup',
			'core.page_header'					=> 'add_link_to_stats',
			'core.permissions'					=> 'add_permissions',
			'core.viewonline_overwrite_location'	=> 'add_basicstats_viewonline',
		];
	}

	public function load_language_on_setup(data $event): void
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name'	=> 'stoker/basicstats',
			'lang_set'	=> 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_link_to_stats(data $event): void
	{
		if ($this->auth->acl_get('u_basicstats_view'))
		{
			$this->template->assign_vars([
				'S_CAN_VIEW_BASICSTATS'	=> true,
				'U_BASIC_STATS'			=> $this->helper->route('stoker_basicstats'),
			]);
		}
	}

	public function add_permissions(data $event): void
	{
		$permissions = (array) ($event['permissions'] ?? []);
		$permissions['u_basicstats_view'] = [
			'lang'	=> 'ACL_U_BASICSTATS_VIEW',
			'cat'	=> 'misc',
		];
		$event['permissions'] = $permissions;
	}

	public function add_basicstats_viewonline(data $event): void
	{
		$page = (string) ($event['row']['session_page'] ?? '');

		$bsonline1 = 'app.' . $this->php_ext . '/board-stats';
		$bsonline2 = 'app.' . $this->php_ext . '/board-stats.php';

		if (strpos($page, $bsonline1) === 0 || strpos($page, $bsonline2) === 0)
		{
			$event['location'] = $this->language->lang('VIEWONLINE_BASICSTATS');
			$event['location_url'] = $this->helper->route('stoker_basicstats');
		}
	}
}