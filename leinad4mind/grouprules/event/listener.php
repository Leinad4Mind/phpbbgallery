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
use phpbb\request\request_interface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var db_text */
	protected $db_text;

	/** @var request_interface */
	protected $request;

	/** @var array */
	protected $group_rules;

	/** @var bool */
	protected $group_attribute_changed;

	/** @var bool */
	protected $stop;

	/**
	 * @param db_text			$db_text
	 * @param request_interface	$request
	 */
	public function __construct(
		db_text $db_text,
		request_interface $request
	)
	{
		$this->db_text	= $db_text;
		$this->request	= $request;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.group_add_user_after'			=> 'group_add',
			'core.group_delete_user_after'		=> 'group_del',
			'core.user_set_group_attributes'	=> 'attribute_change',
			'core.adm_page_footer'				=> 'adm_page_footer',
		];
	}

	/**
	 * @param data $event
	 */
	public function group_add(data $event)
	{
		$this->grouprules('add', $event['group_id'], $event['user_id_ary']);
	}

	/**
	 * @param data $event
	 */
	public function group_del(data $event)
	{
		$this->grouprules('del', $event['group_id'], $event['user_id_ary']);
	}

	/**
	 * @param data $event
	 */
	public function attribute_change(data $event)
	{
		$this->grouprules($event['action'], $event['group_id'], $event['user_id_ary']);
	}

	/**
	 * @param string $event_action one of add|del
	 * @param int $event_group
	 * @param array $event_user_ids
	 */
	public function grouprules($event_action, $event_group, array $event_user_ids)
	{
		if ($this->stop)
		{
			return;
		}

		if ($this->group_rules === null)
		{
			$group_rules = $this->db_text->get('grouprules_group_actions');
			$this->group_rules = @json_decode($group_rules, true);
		}

		if (!$this->group_rules)
		{
			return;
		}

		foreach ($this->group_rules as $rule)
		{
			if ($rule['when']['action'] == $event_action && $rule['when']['group'] == $event_group)
			{
				foreach ($rule['then'] as $action)
				{
					$this->stop = $action['stop'];

					switch ($action['action'])
					{
						case 'add':
						case 'del':

							call_user_func_array('group_user_' . $action['action'], [
								$action['group'],
								$event_user_ids,
							]);

						break;

						case 'default':
						case 'promote':
						case 'demote':

							group_user_attributes($action['action'], $action['group'], $event_user_ids);

							if (in_array($action['action'], ['default', 'promote', 'demote']))
							{
								$this->group_attribute_changed = true;
							}

						break;
					}
				}
			}
		}
	}

	/**
	 * Temporary fix: refresh page to show the updated group attributes when viewing groups for a specific user
	 */
	public function adm_page_footer()
	{
		if ($this->group_attribute_changed && $this->on_user_groups_page())
		{
			header('Refresh: 0');
		}
	}

	/**
	 * @return bool
	 */
	protected function on_user_groups_page()
	{
		return $this->request->variable('i', '') == 'acp_users' && $this->request->variable('mode', '') == 'groups';
	}
}
