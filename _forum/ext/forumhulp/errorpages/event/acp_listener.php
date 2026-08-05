<?php
/**
 *
 * @package Error Pages
 * @copyright (c) 2014 ForumHulp.com
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\errorpages\event;

use phpbb\language\language;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class acp_listener implements EventSubscriberInterface
{
	/** @var language */
	protected $language;

	public function __construct(language $language)
	{
		$this->language = $language;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.acp_board_config_edit_add' => 'load_config_on_setup',
		];
	}

	public function load_config_on_setup($event)
	{
		if ($event['mode'] !== 'features')
		{
			return;
		}

		$this->language->add_lang('info_acp_errorpages', 'forumhulp/errorpages');
		$display_vars = $event['display_vars'];
		$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], [
			'error_pages_explain' => [
				'lang' => 'ERRORPAGES_EXPLAIN',
				'validate' => 'bool',
				'type' => 'radio:yes_no',
				'explain' => true,
			],
			'error_pages_log' => [
				'lang' => 'ERRORPAGES_LOG',
				'validate' => 'bool',
				'type' => 'radio:yes_no',
				'explain' => true,
			],
		], ['before' => 'legend2']);

		$event['display_vars'] = $display_vars;
	}
}
