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

/**
 * Badge Award conditions type helper class
 */
class helper
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\notification\manager */
	protected $notification_manager;

	/** @var string */
	protected $phpbb_root_path;

	/** @var string */
	protected $php_ext;

	/** @var string The database table the badge events are stored in */
	protected $badge_events_table;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface $db                     Database object
	 * @param \phpbb\notification\manager       $notification_manager   Notification manager
	 * @param string                            $phpbb_root_path        phpBB root path
	 * @param string                            $php_ext                phpEx
	 *
	 * @access public
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\notification\manager $notification_manager, $phpbb_root_path, $php_ext, $badge_events_table)
	{
		$this->db = $db;
		$this->notification_manager = $notification_manager;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->badge_events_table = $badge_events_table;
	}

	/**
	 * Get an array of users and badges
	 *
	 * @param array $user_id_ary An array of user ids to check
	 * @return array An array of rule ids each user belongs to
	 * @access public
	 */
	public function get_users_rules($user_id_ary)
	{
		$rule_id_ary = array_flip($user_id_ary);
		foreach ($user_id_ary as $key => $value) { 
		  $rule_id_ary[$value] = array();
		}

		$sql = 'SELECT user_id, rule_id
			FROM ' . $this->badge_events_table . '
			WHERE ' . $this->db->sql_in_set('user_id', $user_id_ary, false, true);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rule_id_ary[$row['user_id']][] = $row['rule_id'];
		}
		$this->db->sql_freeresult($result);
		return $rule_id_ary;
	}

	/**
	 * Prepare user ids for querying
	 *
	 * @param mixed $user_ids User id(s) expected as int or array
	 * @return array An array of user id(s)
	 * @access public
	 */
	public function prepare_users_for_query($user_ids)
	{
		if (is_array($user_ids))
		{
			// Cast each array value to integer
			$user_ids = array_map('intval', $user_ids);
		}
		else
		{
			// Cast user id to integer and put it inside an array
			$user_ids = array((int) $user_ids);
		}

		return $user_ids;
	}

	/**
	 * Send notifications
	 *
	 * @param string $type       Type of notification to send (award added, removed)
	 * @param array $user_id_ary Array of user(s) to notify
	 * @param int $group_id      The usergroup identifier
	 * @return null
	 * @access public
	 */
	public function send_notifications($type, $user_id_ary, $rule_data)
	{
		$this->notification_manager->add_notifications("sitesplat.badge.notification.type.$type", array(
			'user_ids'		=> $user_id_ary,
			'rule_id'		=> $rule_data['rule_id'],
			'rule_name'		=> strtoupper(str_replace(array('sitesplat.', '.'), array('', '_') , $rule_data['rule_type_name'])),
		));
	}
}
