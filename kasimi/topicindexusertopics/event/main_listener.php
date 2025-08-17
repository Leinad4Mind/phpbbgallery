<?php

/**
 *
 * Topic Index - User Topics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kasimi\topicindexusertopics\event;

use dmzx\topicindex\controller\main;
use phpbb\controller\helper;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use phpbb\user_loader;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	/** @var user */
	protected $user;
	/** @var request_interface */
	protected $request;

	/** @var template */
	protected $template;

	/** @var language */
	protected $language;

	/** @var user_loader */
	protected $user_loader;

	/** @var helper */
	protected $controller_helper;

	/** @var main */
	protected $topicindex_controller;

	/**
	 * @param user				$user
	 * @param request_interface	$request
	 * @param template			$template
	 * @param language			$language
	 * @param user_loader		$user_loader
	 * @param helper			$controller_helper
	 * @param main				$topicindex_controller
	 */
	public function __construct(
		user $user,
		request_interface $request,
		template $template,
		language $language,
		user_loader $user_loader,
		helper $controller_helper,
		main $topicindex_controller = null
	)
	{
		$this->user						= $user;
		$this->request					= $request;
		$this->template					= $template;
		$this->language					= $language;
		$this->user_loader				= $user_loader;
		$this->controller_helper		= $controller_helper;
		$this->topicindex_controller	= $topicindex_controller;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'dmzx.topicindex.sql_fetch_topics_before'	=> 'topicindex_sql_fetch_topics_before',
			'core.memberlist_view_profile'				=> 'memberlist_view_profile',
			'core.append_sid'							=> 'append_sid',
			'core.page_header'							=> 'page_header',
		];
	}

	/**
	 * @param data $event
	 */
	public function topicindex_sql_fetch_topics_before(data $event)
	{
		$user_id = $this->request->variable('user', 0);

		if ($user_id)
		{
			$sql_array = $event['sql_array'];
			$sql_array['WHERE'] .= ' AND t.topic_poster = ' . (int) $user_id;
			$event['sql_array'] = $sql_array;

			$this->language->add_lang('common', 'kasimi/topicindexusertopics');

			$this->user_loader->load_users([$user_id]);

			$this->template->assign_vars([
				'U_TOPIC_INDEX_USER_TOPICS_NO_FILTER'		=> $this->get_route_without_user(),
				'TOPIC_INDEX_USER_TOPICS_FILTERING_NAME'	=> $this->user_loader->get_username($user_id, 'full'),
			]);
		}
	}

	/**
	 * @param data $event
	 */
	public function memberlist_view_profile(data $event)
	{
		if ($this->topicindex_controller)
		{
			$this->language->add_lang('common', 'kasimi/topicindexusertopics');

			$this->template->assign_vars([
				'S_TOPIC_INDEX_IS_USER_SEARCH'	=> $this->request->variable('user', 0),
				'U_TOPIC_INDEX_USER_TOPICS'		=> $this->controller_helper->route('dmzx_topicindex_controller', [
					'user' => $event['member']['user_id'],
					'list' => 1,
				]),
			]);
		}
	}

	/**
	 * @param data $event
	 */
	public function append_sid(data $event)
	{
		if ($this->topicindex_controller && strpos($event['url'], '/topicindex') !== false)
		{
			$params = $event['params'];

			if (!is_array($params) || !isset($params['user']))
			{
				$user_id = $this->request->variable('user', 0);

				if ($user_id)
				{
					if ($params === false)
					{
						$params = ['user' => $user_id];
					}
					else if (is_string($params))
					{
						$params .= '&amp;user=' . $user_id;
					}
					else
					{
						$params['user'] = $user_id;
					}

					$event['params'] = $params;
				}
			}
		}
	}

	/**
	 *
	 */
	public function page_header()
	{
		if ($this->topicindex_controller)
		{
			$this->template->assign_vars([
				'U_TOPIC_INDEX_USER_TOPICS_SELF' => $this->controller_helper->route('dmzx_topicindex_controller', [
					'user' => $this->user->data['user_id'],
					'list' => 1,
				]),
			]);
		}
	}

	/**
	 * @return string
	 */
	protected function get_route_without_user()
	{
		$controller = $this->topicindex_controller;
		$this->topicindex_controller = null;

		$list = $this->request->variable('list', 0);
		$args = $list ? ['list' => $list] : [];
		$url = $this->controller_helper->route('dmzx_topicindex_controller', $args);

		$this->topicindex_controller = $controller;

		return $url;
	}
}
