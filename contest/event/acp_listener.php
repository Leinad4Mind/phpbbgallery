<?php
/**
 * phpBB Gallery Contest ACP integration.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Adds contest-owned settings to the Gallery Core configuration form.
 */
class acp_listener implements EventSubscriberInterface
{
	private \phpbb\language\language $language;

	public function __construct(\phpbb\language\language $language)
	{
		$this->language = $language;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.acp.config.get_display_vars' => 'add_config',
		];
	}

	public function add_config(\phpbb\event\data $event): void
	{
		if ((string) $event['mode'] !== 'main')
		{
			return;
		}

		$this->language->add_lang('contest_acp', 'phpbbgallery/contest');
		$return_ary = (array) $event['return_ary'];
		$settings = (array) ($return_ary['vars']['GALLERY_CONFIG'] ?? []);
		$contest = [
			'allow_contests' => [
				'lang' => 'CONTEST_CREATION',
				'validate' => 'bool',
				'type' => 'radio:yes_no',
				'explain' => true,
			],
		];

		$position = array_search('items_per_page', array_keys($settings), true);
		if ($position === false)
		{
			$settings += $contest;
		}
		else
		{
			$position++;
			$settings = array_slice($settings, 0, $position, true)
				+ $contest
				+ array_slice($settings, $position, null, true);
		}

		$return_ary['vars']['GALLERY_CONFIG'] = $settings;
		$event['return_ary'] = $return_ary;
	}
}
