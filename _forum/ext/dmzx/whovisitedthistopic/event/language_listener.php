<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2016 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic\event;

use phpbb\language\language;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class language_listener implements EventSubscriberInterface
{
	/** @var language */
	protected $language;

	public function __construct(language $language)
	{
		$this->language = $language;
	}

	static public function getSubscribedEvents()
	{
		return ['core.user_setup' => 'load_language'];
	}

	public function load_language()
	{
		$this->language->add_lang(['common', 'audit'], 'dmzx/whovisitedthistopic');
	}
}
