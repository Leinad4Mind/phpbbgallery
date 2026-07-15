<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\event;

use kasimi\mchatrooms\core\constants;
use kasimi\mchatrooms\core\functions;
use kasimi\mchatrooms\core\rooms;
use phpbb\event\data;
use phpbb\exception\http_exception;
use phpbb\request\request_interface;
use phpbb\template\template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener extends base_listener implements EventSubscriberInterface
{
	/** @var rooms */
	protected $rooms;

	/** @var functions */
	protected $functions;

	/** @var request_interface */
	protected $request;

	/** @var template */
	protected $template;

	/**
	 * @param rooms $rooms
	 */
	public function set_rooms(rooms $rooms)
	{
		$this->rooms = $rooms;
	}

	/**
	 * @param functions $functions
	 */
	public function set_functions(functions $functions)
	{
		$this->functions = $functions;
	}

	/**
	 * @param request_interface $request
	 */
	public function set_request(request_interface $request)
	{
		$this->request = $request;
	}

	/**
	 * @param template $template
	 */
	public function set_template(template $template)
	{
		$this->template = $template;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return array_merge(parent::getSubscribedEvents(), [
			'core.user_setup'							=> 'core_user_setup',
			'dmzx.mchat.global_modify_template_data'	=> 'mchat_global_modify_template_data',
			'dmzx.mchat.render_page_before'				=> 'mchat_render_page_before',
			'dmzx.mchat.render_page_pagination_before'	=> 'mchat_render_page_pagination_before',
			'dmzx.mchat.get_messages_modify_sql'		=> ['mchat_get_messages_modify_sql', 100],
			'dmzx.mchat.total_message_count_modify_sql'	=> 'mchat_total_message_count_modify_sql',
			'dmzx.mchat.message_modify_template_data'	=> 'mchat_message_modify_template_data',
			'dmzx.mchat.action_before'					=> 'mchat_action_before',
			'dmzx.mchat.insert_posting_before'			=> ['mchat_insert_posting_before', -100],
			'dmzx.mchat.prune_sql_before'				=> 'mchat_prune_sql_before',
			'dmzx.mchat.prune_before'					=> 'mchat_prune_before',
			'core.delete_user_after'					=> 'core_delete_user_after',
			'core.session_gc_after'						=> 'core_gc_room_sessions',
		]);
	}

	/**
	 * @return array
	 */
	protected function get_listener_config()
	{
		return [
			'lang' => [
				'acp' => ['mchatrooms_acp', 'kasimi/mchatrooms'],
				'ucp' => ['mchatrooms_acp', 'kasimi/mchatrooms'],
			],
			'settings' => [
				'ucp' => [
					'mchat_rooms_enabled'	=> ['default' => 1],
					'mchat_rooms_enter_all'	=> ['default' => 0],
				],
			],
		];
	}

	/**
	 * @param data $event
	 */
	public function core_user_setup(data $event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'kasimi/mchatrooms',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 *
	 */
	public function mchat_global_modify_template_data()
	{
		$this->rooms->assign_global_template_data();
	}

	/**
	 * @param data $event
	 */
	public function mchat_render_page_before(data $event)
	{
		$this->rooms->assign_rooms($event['page']);
	}

	/**
	 * @param data $event
	 */
	public function mchat_render_page_pagination_before(data $event)
	{
		$event['archive_url'] = $this->rooms->get_archive_url($this->rooms->get_room_id());
	}

	/**
	 * @param data $event
	 */
	public function mchat_get_messages_modify_sql(data $event)
	{
		$this->rooms->mchat_get_messages_modify_sql($event);
	}

	/**
	 * @param data $event
	 */
	public function mchat_total_message_count_modify_sql(data $event)
	{
		$sql_array = $event['sql_array'];
		$sql_where = array_filter([$sql_array['WHERE'], 'm.room_id = ' . (int) $this->rooms->get_room_id()]);
		$sql_array['WHERE'] = '(' . implode(') AND (', $sql_where) . ')';
		$event['sql_array'] = $sql_array;
	}

	/**
	 * @param data $event
	 */
	public function mchat_message_modify_template_data(data $event)
	{
		$room_id = $event['row']['room_id'];
		$event['template_data'] = array_merge($event['template_data'], [
			'ROOM_ID' => $room_id,
		]);
	}

	/**
	 * @param data $event
	 */
	public function mchat_action_before(data $event)
	{
		$room_id = $this->request->variable('room', constants::LOBBY_ID);

		if ($room_id != constants::LOBBY_ID)
		{
			$room = $this->functions->get_rooms($room_id, [constants::ROOMS_REQUIRE_PROTECTED_SESSION]);

			if (empty($room[$room_id]) || !$this->rooms->can_view_rooms())
			{
				throw new http_exception(403, 'NO_AUTH_OPERATION');
			}
		}

		if ($event['action'] == 'add')
		{
			$event['sql_ary'] = array_merge($event['sql_ary'], [
				'room_id' => $room_id,
			]);
		}
	}

	/**
	 * @param data $event
	 */
	public function mchat_insert_posting_before(data $event)
	{
		if ($event['is_mode_enabled'] && in_array($event['mode'], ['post', 'quote', 'edit', 'reply', 'login']))
		{
			$sql_array = $event['sql_array'];
			$sql_array['room_id'] = $this->settings->cfg('mchat_rooms_' . $event['mode'] . '_notifications');
			$event['sql_array'] = $sql_array;
		}
	}

	/**
	 * @param data $event
	 */
	public function mchat_prune_sql_before(data $event)
	{
		if (!$event['user_ids'])
		{
			$event['sql_array'] = $this->functions->inject_prune_sql_where($event['sql_array']);
		}
	}

	/**
	 * @param data $event
	 */
	public function mchat_prune_before(data $event)
	{
		if (!$event['user_ids'])
		{
			$event['prune_ids'] = $this->functions->prune_messages($event['prune_ids']);
		}
	}

	/**
	 * @param data $event
	 */
	public function core_delete_user_after(data $event)
	{
		$this->functions->delete_invite_notifications('user', $event['user_ids']);
		$this->functions->delete_room_sessions(false, $event['user_ids']);
	}

	/**
	 *
	 */
	public function core_gc_room_sessions()
	{
		$this->rooms->gc_room_sessions();
	}
}
