<?php

/**
 *
 * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\limitperforum\event;

use phpbb\event\data;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class acp_listener implements EventSubscriberInterface
{
	/** @var language */
	protected $lang;

	/** @var request_interface */
	protected $request;

	/** @var template */
	protected $template;

	/**
	 * @param language			$lang
	 * @param request_interface	$request
	 * @param template			$template
	 */
	public function __construct(
		language $lang,
		request_interface $request,
		template $template
	)
	{
		$this->lang 	= $lang;
		$this->request	= $request;
		$this->template	= $template;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.acp_manage_forums_display_form'	=> 'acp_manage_forums_display_form',
			'core.acp_manage_forums_validate_data'	=> 'acp_manage_forums_validate_data',
		];
	}

	/**
	 * @param data $event
	 */
	public function acp_manage_forums_display_form(data $event)
	{
		$this->lang->add_lang('acp', 'leinad4mind/limitperforum');

		$this->template->assign_vars([
			'FORUM_TOPIC_LIMIT'	=> $event['forum_data']['forum_topic_limit'],
			'FORUM_POST_LIMIT'	=> $event['forum_data']['forum_post_limit'],
		]);
	}

	/**
	 * @param data $event
	 */
	public function acp_manage_forums_validate_data(data $event)
	{
		$event['forum_data'] = array_merge($event['forum_data'], [
			'forum_topic_limit'	=> $this->request->variable('forum_topic_limit', 0),
			'forum_post_limit'	=> $this->request->variable('forum_post_limit', 0),
		]);

		if (!empty($forum_data['forum_post_limit']) && $event['forum_data']['forum_topic_limit'] > $event['forum_data']['forum_post_limit'])
		{
			$event['errors'] = array_merge($event['errors'], [
				$this->lang->lang('FORUM_MAX_TOPICS_ERROR')
			]);
		}
	}
}
