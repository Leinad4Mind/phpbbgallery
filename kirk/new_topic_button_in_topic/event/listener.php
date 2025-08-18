<?php
/**
*
* @package phpBB Extension - New Topic Button in Topic
* @copyright (c) 2014 - 2025 Kirk https://kirk-phpbb.com
* @license GNU General Public License, version 2 (GPL-2.0-only)
*
*/

namespace kirk\ntbit\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $template;

	public function __construct(
		\phpbb\template\template $template
	)
	{
		$this->template		= $template;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.viewtopic_assign_template_vars_before'	=> 'display_ntbit'
		];
	}

	public function display_ntbit()
	{
		global $topic_data;
		$this->template->assign_vars([
			'S_FORUM_LOCKED'	=> ($topic_data['forum_status'] == ITEM_LOCKED) ? true : false
		]);
	}
}
