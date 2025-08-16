<?php

/**
 *
 * @package phpBB Extension - Group Rules
 * @copyright (c) 2017-2018 Leinad4Mind - https://leinad4mind.top/forum
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\grouprules\event;

use phpbb\config\db_text;
use phpbb\event\data;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var db_text */
	protected $db_text;

	/**
	 * @param db_text $db_text
	 */
	public function __construct(
		db_text $db_text
	)
	{
		$this->db_text = $db_text;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.group_add_user_after'		=> 'group_add',
			'core.group_delete_user_after'	=> 'group_del',
		];
	}

	/**
	 * @param data $event
	 */
	public function group_add(data $event)
	{
		$this->group_action('add', $event['group_id'], $event['user_id_ary']);
	}

	/**
	 * @param data $event
	 */
	public function group_del(data $event)
	{
		$this->group_action('del', $event['group_id'], $event['user_id_ary']);
	}

	/**
	 * @param string $event_action one of add|del
	 * @param int $event_group
	 * @param array $event_user_ids
	 */
	public function group_action($event_action, $event_group, $event_user_ids)
	{
		$group_actions = $this->db_text->get('grouprules_group_actions');

		$group_actions = @json_decode($group_actions, true);

		if (!$group_actions)
		{
			return;
		}

		foreach ($group_actions as $action)
		{
			if ($action['when'] == ['action' => $event_action, 'group' => $event_group])
			{
				$args = [
					$action['then']['group'],
					$event_user_ids,
				];

				if ($action['then']['action'] == 'add')
				{
					// Add argument for default group
					$args = array_merge($args, [
						false,
						false,
						$action['then']['default'],
					]);
				}

				call_user_func_array('group_user_' . $action['then']['action'], $args);
			}
		}
	}
}
