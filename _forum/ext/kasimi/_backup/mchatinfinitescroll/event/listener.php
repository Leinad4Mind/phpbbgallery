<?php

/**
 *
 * @package phpBB Extension - mChat Infinite Scroll Addon
 * @copyright (c) 2017 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatinfinitescroll\event;

use kasimi\mchatinfinitescroll\controller\main;
use phpbb\controller\helper;
use phpbb\event\data;
use phpbb\event\dispatcher_interface;
use phpbb\template\template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var template */
	protected $template;

	/** @var helper */
	protected $helper;

	/** @var dispatcher_interface */
	protected $dispatcher;

	/** @var main */
	protected $main;

	/** @var int */
	protected $message_count = 0;

	/**
	 * Constructor
	 *
	 * @param template				$template
	 * @param helper				$helper
	 * @param dispatcher_interface	$dispatcher
	 * @param main					$main
	 */
	public function __construct(
		template $template,
		helper $helper,
		dispatcher_interface $dispatcher,
		main $main
	)
	{
		$this->template		= $template;
		$this->helper		= $helper;
		$this->dispatcher	= $dispatcher;
		$this->main			= $main;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'dmzx.mchat.render_page_after'				=> 'render_page_after',
			'dmzx.mchat.get_messages_modify_sql'		=> 'get_messages_modify_sql',
			'dmzx.mchat.message_modify_template_data'	=> 'message_modify_template_data',
		];
	}

	/**
	 * @param data $event
	 */
	public function get_messages_modify_sql($event)
	{
		$oldest_message_id = $this->main->get_oldest_message_id();

		if ($oldest_message_id && $this->main->can_run())
		{
			$sql_array = $event['sql_array'];
			$sql_where = '(m.message_id < ' . (int) $oldest_message_id . ')';

			if (!empty($sql_array['WHERE']))
			{
				$sql_where .= ' AND (' . $sql_array['WHERE'] . ')';
			}

			$sql_array['WHERE'] = $sql_where;
			$event['sql_array'] = $sql_array;
		}
	}

	/**
	 *
	 */
	public function message_modify_template_data()
	{
		$this->message_count++;
	}

	/**
	 * @param data $event
	 */
	public function render_page_after($event)
	{
		$page = $event['page'];

		if ($page === 'archive' || !$this->main->can_run())
		{
			return;
		}

		$url = $this->helper->route('kasimi_mchatinfinitescroll_load', ['page' => $page], false);
		$limit = $this->main->get_limit($page);
		$message_count = $this->message_count;

		$template_data = [
			'U_MCHAT_INFINITESCROLL'			=> $url,
			'S_MCHAT_INFINITESCROLL_INCLUDE'	=> $message_count >= $limit,
		];

		/**
		 * Event to modify data before it is assigned to the template
		 *
		 * @event kasimi.mchatinfinitescroll.render_page_after
		 * @var string	page			The page we are currently on, most likely one of index|custom|archive
		 * @var string	url				The URL that is used to load older messages
		 * @var int		limit			The max number of messages initially displayed on the current page
		 * @var int		message_count	The actual number of messages initially displayed on the current page
		 * @var array	template_data	The data about to be assigned to the template
		 * @since 1.0.0
		 */
		$vars = [
			'page',
			'url',
			'limit',
			'message_count',
			'template_data',
		];
		extract($this->dispatcher->trigger_event('kasimi.mchatinfinitescroll.render_page_after', compact($vars)));

		$this->template->assign_vars($template_data);
	}
}
