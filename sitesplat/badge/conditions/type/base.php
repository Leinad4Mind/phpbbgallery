<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\conditions\type;

use phpbb\db\driver\driver_interface;
use phpbb\user;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Badge Award base class
 */
abstract class base implements type_interface
{
	/** @var ContainerInterface */
	protected $container;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \sitesplat\badge\conditions\type\helper */
	protected $helper;

	/** @var \phpbb\user */
	protected $user;

	/** @var string The database table the badge rules are stored in */
	protected $badge_rules_table;

	/** @var string The database table the badge types are stored in */
	protected $badge_types_table;

	/** @var string The database table the badge events are stored in */
	protected $badge_events_table;

	/** @var string */
	protected $phpbb_root_path;

	/** @var string */
	protected $php_ext;

	public function __construct(ContainerInterface $container, driver_interface $db, user $user, $badge_rules_table, $badge_types_table,  $badge_events_table, $phpbb_root_path, $php_ext)
	{
		$this->container = $container;
		$this->db = $db;
		$this->user = $user;

		$this->badge_rules_table = $badge_rules_table;
		$this->badge_types_table = $badge_types_table;
		$this->badge_events_table = $badge_events_table;

		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;

		// Load the helper from the container instead of dependency injection to
		// help anyone extending Badge Awards avoid setting optional dependencies.
		$this->helper = $this->container->get('sitesplat.badge.helper');
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_rules($rule_id = 0)
	{
		$sql_array = array(
			'SELECT'	=> 'agr.*, agt.rule_type_name',
			'FROM'		=> array(
				$this->badge_rules_table => 'agr',
				$this->badge_types_table => 'agt',
			),
			'WHERE'		=> 'agr.rule_type_id = agt.rule_type_id' .
				(($rule_id) ? ' AND agr.rule_id = ' . $this->db->sql_escape($rule_id) : ''),
		);
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		return $rows;
	}

	public function user_badge_add($rule_id, $user_id_ary)
	{
		$this->db->sql_transaction('begin');

		$sql_ary = array();
		foreach($user_id_ary as $userid)
		{
			$sql = 'SELECT user_id FROM ' . $this->badge_events_table . ' WHERE user_id = ' . $userid . ' AND rule_id = ' . $rule_id;
			$result = $this->db->sql_query($sql);
			$user_id = $this->db->sql_fetchfield('user_id');
			$this->db->sql_freeresult($result);		
			if (!$user_id)
			{
				$sql_ary[] = array(
					'user_id'	=> (int) $userid,
					'rule_id'	=> (int) $rule_id,
					'date'		=> time()
				);
			}
		}
		$this->db->sql_multi_insert($this->badge_events_table, $sql_ary);
		$this->db->sql_transaction('commit');
	}

	public function user_badge_dell($rule_id, $user_id_ary)
	{
		$sql = 'DELETE FROM ' . $this->badge_events_table . ' WHERE rule_id = ' . $rule_id . ' AND user_id IN (' . implode(',', $user_id_ary) . ')';
		$this->db->sql_query($sql);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function add_badge_to_user($user_id_ary, $rule_data)
	{
		// Set this variable for readability in the code below
		$rule_id = $rule_data['rule_id'];

		// Add badge to the user
		$this->user_badge_add($rule_data['rule_id'], $user_id_ary);

		// Send notification
		if ($rule_data['rule_notify'])
		{
			$this->helper->send_notifications('award_added', $user_id_ary, $rule_data);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function remove_badge_from_user($user_id_ary, $rule_data)
	{
		// Return if the user_id_array is empty
		if (!sizeof($user_id_ary))
		{
			return;
		}

		// Set this variable for readability in the code below
		$rule_id = $rule_data['rule_id'];

		// Delete badge from the user
		$this->user_badge_dell($rule_data['rule_id'], $user_id_ary);

		// Send notification
		if ($rule_data['rule_notify'])
		{
			$this->helper->send_notifications('award_removed', $user_id_ary, $rule_data);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function check($user_row, $rule_id = 0, $options = array())
	{
		// Get all badge data sets
		$rules = $this->get_rules($rule_id);

		// Get an array of users and badges
		$users = $this->helper->get_users_rules(array_keys($user_row));

		foreach ($rules as $rule)
		{
			// Only check badge rules set for this condition type
			if ($rule['rule_type_name'] == $this->get_condition_type())
			{
				// Initialize some arrays
				$add_users_to_rule = $remove_users_from_rule = array();

				foreach ($user_row as $user_id => $user_data)
				{
					// Check if a user's data is within the min/max range
					if ($this->check_user_data($user_data[$this->get_condition_field()], $rule))
					{
						// Check if badge already is set
						if (!in_array($rule['rule_id'], $users[$user_id]))
						{
							// Add badge
							$add_users_to_rule[] = $user_id;
						}
					}
					else if (in_array($rule['rule_id'], $users[$user_id]))
					{
						// Remove badge
						$remove_users_from_rule[] = $user_id;
					}
				}

				if (sizeof($add_users_to_rule))
				{
					// Add badge to user
					$this->add_badge_to_user($add_users_to_rule, $rule);
				}

				if (sizeof($remove_users_from_rule))
				{
					// Filter users that should not be removed
					$remove_users_from_rule = $this->filter_users($remove_users_from_rule, $rule, $rules);

					// Remove badge from user
					$this->remove_badge_from_user($remove_users_from_rule, $rule);
				}
			}
		}
	}

	/**
	 * Helper function checks if a user's data is within
	 * an badge rule condition's min/max range.
	 *
	 * @param int   $value      The value of the user's data field to check
	 * @param array $rule Data array for an badge rule
	 * @return bool True if the user meets the condition, false otherwise
	 * @access protected
	 */
	protected function check_user_data($value, $rule)
	{
		return ($value >= $rule['rule_min_value']) &&
			(empty($rule['rule_max_value']) || ($value <= $rule['rule_max_value'])
		);
	}

	/**
	 * Helper function prevents un-wanted removal of users from
	 * the current group in cases where users do not satisfy the
	 * conditions of the current rule, but may satisfy conditions
	 * for another rule that applies to the current group.
	 *
	 * @param array $user_id_ary  Array of users marked for removal
	 * @param array $current_rule Data array for an rule
	 * @param array $group_rules  Data array for all badge group rules
	 * @return array Array of users to be removed
	 * @access protected
	 */
	protected function filter_users($user_id_ary, $current_rule, $rules)
	{
		// Iterate through every rule
		foreach ($rules as $rule)
		{
			// Only look at other badge rules that apply to this rule
			if ($rule['badge_id'] == $current_rule['badge_id'] &&
				$rule['rule_type_id'] != $current_rule['rule_type_id'] &&
				sizeof($user_id_ary)
			)
			{
				// Load other rule's condition type and get new data for our user(s)
				$condition = $this->container->get($rule['rule_type_name']);
				$condition_user_data = $condition->get_users_for_condition(array(
					'users' => $user_id_ary,
				));
				// Filter users out users that satisfy other conditions for this rule
				$user_id_ary = array_filter($user_id_ary, function ($user_id) use ($condition, $condition_user_data, $rule) {
					return !$condition->check_user_data($condition_user_data[$user_id][$condition->get_condition_field()], $rule);
				});
			}
		}

		return $user_id_ary;
	}
}
