<?php

/**
 *
 * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\limitperforum\event;

use leinad4mind\limitperforum\manager\forum_groups_manager;
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

	/** @var forum_groups_manager */
	protected $manager;

	/**
	 * @param language				$lang
	 * @param request_interface		$request
	 * @param template				$template
	 * @param forum_groups_manager	$manager
	 */
	public function __construct(
		language $lang,
		request_interface $request,
		template $template,
		forum_groups_manager $manager
	)
	{
		$this->lang 	= $lang;
		$this->request	= $request;
		$this->template	= $template;
		$this->manager	= $manager;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.permissions'							=> 'add_permission',
			'core.acp_manage_forums_display_form'		=> 'acp_manage_forums_display_form',
			'core.acp_manage_forums_validate_data'		=> 'acp_manage_forums_validate_data',
			'core.acp_manage_forums_update_data_after'	=> 'acp_manage_forums_update_data_after',
		];
	}

	/**
	 * @param data $event
	 */
	public function add_permission($event)
	{
		$event['permissions'] = array_merge($event['permissions'], [
			'f_topic_limit'	=> ['lang' => 'ACL_F_TOPIC_LIMIT', 'cat' => 'misc'],
			'f_post_limit'	=> ['lang' => 'ACL_F_POST_LIMIT', 'cat' => 'misc'],
		]);
	}

	/**
	 * @param data $event
	 */
	public function acp_manage_forums_display_form(data $event)
	{
		$this->lang->add_lang('acp', 'leinad4mind/limitperforum');

		$forum_data = $event['forum_data'];

		$this->template->assign_vars([
			'FORUM_TOPIC_LIMIT'			=> isset($forum_data['forum_topic_limit']) ? $forum_data['forum_topic_limit'] : 0,
			'FORUM_TOPIC_TIME_LIMIT'	=> isset($forum_data['forum_topic_time_limit']) ? $forum_data['forum_topic_time_limit'] : 0,
			'FORUM_POST_LIMIT'			=> isset($forum_data['forum_post_limit']) ? $forum_data['forum_post_limit'] : 0,
			'FORUM_POST_TIME_LIMIT'		=> isset($forum_data['forum_post_time_limit']) ? $forum_data['forum_post_time_limit'] : 0,
		]);

		$limits = $this->manager->get_limits($event['action'] == 'edit' ? $event['forum_id'] : 0);
		$this->template->assign_block_vars_array('topics_posts_limits', $limits);
	}

	/**
	 * @param data $event
	 */
	public function acp_manage_forums_validate_data(data $event)
	{
		$event['forum_data'] = array_merge($event['forum_data'], [
			'forum_topic_limit'			=> $this->normalize_limit($this->request->variable('forum_topic_limit', 0)),
			'forum_topic_time_limit'	=> $this->normalize_limit($this->request->variable('forum_topic_time_limit', 0)),
			'forum_post_limit'			=> $this->normalize_limit($this->request->variable('forum_post_limit', 0)),
			'forum_post_time_limit'		=> $this->normalize_limit($this->request->variable('forum_post_time_limit', 0)),
		]);

		if (!empty($forum_data['forum_post_limit']) && $event['forum_data']['forum_topic_limit'] > $event['forum_data']['forum_post_limit'])
		{
			$event['errors'] = array_merge($event['errors'], [
				$this->lang->lang('FORUM_MAX_TOPICS_ERROR')
			]);
		}
	}

	/**
	 * @param data $event
	 */
	public function acp_manage_forums_update_data_after(data $event)
	{
		$topics = $this->normalize_limits($this->request->variable('lfgt', [0 => 0]));
		$topics_time_limit = $this->normalize_limits($this->request->variable('lfgtt', [0 => 0]));
		$posts = $this->normalize_limits($this->request->variable('lfgp', [0 => 0]));
		$posts_time_limit = $this->normalize_limits($this->request->variable('lfgpt', [0 => 0]));
		$this->manager->set_limits($event['forum_data']['forum_id'], $topics, $topics_time_limit, $posts, $posts_time_limit);
	}

	protected function normalize_limit($limit)
	{
		return max(0, $limit);
	}

	protected function normalize_limits($limits)
	{
		$new_limits = [];

		foreach ($limits as $key => $limit)
		{
			$new_limits[$key] = $this->normalize_limit($limit);
		}

		return $new_limits;
	}
}
