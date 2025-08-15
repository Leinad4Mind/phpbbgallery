<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\conditions;

use phpbb\db\driver\driver_interface;
use phpbb\user;
use phpbb\request\request;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Badge Award service manager class
 */
class manager
{
	/** @var array Array with badge types */
	protected $badge_types;

	/** @var ContainerInterface */
	protected $phpbb_container;

	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var string The database table the badge rules are stored in */
	protected $badge_rules_table;

	/** @var string The database table the badge types are stored in */
	protected $badge_types_table;

	/** @var string The database table the badge events are stored in */
	protected $badge_events_table;

	/**
	 * Constructor
	 *
	 * @param array                                $badge_types       Array with badge types
	 * @param ContainerInterface                   $phpbb_container        Service container interface
	 * @param \phpbb\cache\driver\driver_interface $cache                  Cache driver interface
	 * @param \phpbb\db\driver\driver_interface    $db                     Database object
	 * @param \phpbb\user                          $user                   User object
	 * @param string                               $badge_rules_table Name of the table used to store badge rules data
	 * @param string                               $badge_types_table Name of the table used to store badge types data
	 *
	 * @access public
	 */
	public function __construct($badge_types, ContainerInterface $phpbb_container, \phpbb\cache\driver\driver_interface $cache, driver_interface $db, user $user, request $request, $badge_rules_table, $badge_types_table, $badge_events_table)
	{
		$this->badge_types = $badge_types;
		$this->phpbb_container = $phpbb_container;
		$this->cache = $cache;
		$this->db = $db;
		$this->user = $user;
		$this->request = $request;
		$this->badge_rules_table = $badge_rules_table;
		$this->badge_types_table = $badge_types_table;
		$this->badge_events_table = $badge_events_table;
	}

	/**
	 * Check badge rule conditions and execute them
	 *
	 * @return null
	 * @access public
	 */
	public function check_conditions()
	{
		foreach ($this->badge_types as $badge_type => $data)
		{
			$rowset = array();
			$sql = 'SELECT r.rule_id, r.options FROM ' . $this->badge_rules_table . ' r
					LEFT JOIN ' . $this->badge_types_table . ' t ON t.rule_type_id = r.rule_type_id
					WHERE t.rule_type_name = "' . $badge_type . '" AND t.rule_type_name <> "sitesplat.badge.type.custom"';

			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$rowset[] = $row;
			}
			$this->db->sql_freeresult($result);

			if (!empty($rowset))
			{
				foreach ($rowset as $row)
				{
					$this->check_condition($badge_type, $row['rule_id'], array('option' => $row['options']));
				}
			}
		}
	}

	/**
	 * Check badge rule condition and execute it
	 *
	 * @param string $type_name Name of the condition
	 * @param array  $options   Array of optional data
	 *
	 * @return null
	 * @access public
	 */
	public function check_condition($type_name, $rule_id, $options = array())
	{
		// Get an instance of the condition type to check
		$condition = $this->phpbb_container->get($type_name);

		// Get the user id array of users to check
		$check_users = $condition->get_users_for_condition($options);

		// Check the users and award them
		$condition->check($check_users, $rule_id, $options);
	}

	/**
	 * Add new condition type
	 *
	 * @param string $rule_type_name The name of the badge rule type
	 *
	 * @return int The identifier of the new condition type
	 * @access public
	 */
	public function add_badge_type($rule_type_name)
	{
		// Insert the type name into the database
		$sql = 'INSERT INTO ' . $this->badge_types_table . '
			' . $this->db->sql_build_array('INSERT', array('rule_type_name' => $this->db->sql_escape($rule_type_name)));
		$this->db->sql_query($sql);

		// Return the id of the newly inserted condition type
		return (int) $this->db->sql_nextid();
	}

	/**
	 * Purge all badges related to a certain rule_id
	 *
	 * @param int $rule_id Rule identifier
	 * @return null
	 * @access public
	 */
	public function purge_badge_events($rule_id)
	{
		// Delete badge events associated with the rule id
		$sql = 'DELETE FROM ' . $this->badge_events_table . '
			WHERE rule_id = ' . (int) $rule_id;
		$this->db->sql_query($sql);
	}

	/**
	 * Get the condition type id from the name
	 *
	 * @param string $rule_type_name The name of the badge type
	 *
	 * @return int The condition_type_id
	 * @throws \RuntimeException
	 */
	public function get_rule_type_id($rule_type_name)
	{
		// Get cached badge rule ids if they exist
		$rule_type_ids = $this->cache->get('_rule_type_ids');

		// Get rule ids from the db if no cache data exists, cache result
		if ($rule_type_ids === false)
		{
			$rule_type_ids = array();

			$sql = 'SELECT rule_type_id, rule_type_name
				FROM ' . $this->badge_types_table;
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$rule_type_ids[$row['rule_type_name']] = (int) $row['rule_type_id'];
			}
			$this->db->sql_freeresult($result);

			$this->cache->put('_rule_type_ids', $rule_type_ids);
		}

		// Add badge type name to db if it exists as service but is not in db, cache result
		if (!isset($rule_type_ids[$rule_type_name]))
		{
			if (!isset($this->badge_types[$rule_type_name]))
			{
				throw new \RuntimeException($this->user->lang('BADGE_TYPE_NOT_EXIST', $rule_type_name));
			}

			$rule_type_ids[$rule_type_name] = $this->add_badge_type($rule_type_name);

			$this->cache->put('_rule_type_ids', $rule_type_ids);
		}

		return $rule_type_ids[$rule_type_name];
	}

	/**
	 * Get condition type ids (as an array)
	 *
	 * @return array Array of condition type ids
	 * @access public
	 */
	public function get_rule_type_ids()
	{
		$rule_type_ids = array();

		$ext_manager = $this->phpbb_container->get('ext.manager');
		foreach ($this->badge_types as $type_name => $data)
		{
			if ($type_name == 'sitesplat.badge.type.donations' && !$ext_manager->is_enabled('sitesplat/donations'))
			{
				continue;
			} else if ($type_name == 'sitesplat.badge.type.likedd' && !$ext_manager->is_enabled('sitesplat/likedd'))
			{
				continue;
			} else if ($type_name == 'sitesplat.badge.type.profilewall' && !$ext_manager->is_enabled('sitesplat/profilewall'))
			{
				continue;
			} else
			{
				$rule_type_ids[$this->get_condition_lang($type_name)] = array('id' => $this->get_rule_type_id($type_name), 'type' => $type_name);
			}
		}
		ksort($rule_type_ids);
		return $rule_type_ids;
	}

	/**
	 * Get the condition type name from the condition or rule id
	 *
	 * @param int     $type_id      The id of the rule type
	 * @param int     $rule_id      The id of the rule
	 *
	 * @return string|bool The condition type name, false on error
	 * @access public
	 */
	public function get_rule_type_name($type_id = 0, $rule_id = 0)
	{
		$sql_array = array(
			'SELECT'	=> 'agt.rule_type_name',
			'FROM'		=> array(
				$this->badge_types_table => 'agt',
			),
		);

		if ($type_id)
		{
			$sql_array['WHERE'] = 'agt.rule_type_id = ' . (int) $type_id;
		}
		else if ($rule_id)
		{
			$sql_array['LEFT_JOIN'] = array(
				array(
					'FROM'	=>	array($this->badge_rules_table	=> 'agr'),
					'ON'	=> 'agt.rule_type_id = agr.rule_type_id',
				),
			);
			$sql_array['WHERE'] = 'agr.rule_id = ' . (int) $rule_id;
		}
		else
		{
			return false;
		}

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$rule_type_name = $this->db->sql_fetchfield('rule_type_name');
		$this->db->sql_freeresult($result);

		return $rule_type_name;
	}

	/**
	 * Get the option condition boolean var from the condition type class
	 *
	 * @param string     $rule_type_name      The name of the badge type
	 *
	 * @return bool The option of the class type name
	 * @access public
	 */
	public function get_option_condition($rule_type_name)
	{
		try
		{
			$option = $this->phpbb_container->get($rule_type_name);
		}
		catch (\InvalidArgumentException $e)
		{
			return false;
		}

		return $option->get_option();
	}

	/**
	 * Get the condition boolean var from the condition type class
	 *
	 * @param string     $rule_type_name      The name of the badge type
	 *
	 * @return bool The condition type name
	 * @access public
	 */
	public function get_condition_bool($rule_type_name)
	{
		try
		{
			$condition = $this->phpbb_container->get($rule_type_name);
		}
		catch (\InvalidArgumentException $e)
		{
			return false;
		}

		return $condition->get_condition_boolean();
	}

	/**
	 * Get the condition language var from the condition type class
	 *
	 * @param string     $rule_type_name      The name of the badge type
	 *
	 * @return string The condition type name
	 * @access public
	 */
	public function get_condition_lang($rule_type_name)
	{
		try
		{
			$condition = $this->phpbb_container->get($rule_type_name);
		}
		catch (\InvalidArgumentException $e)
		{
			return $this->user->lang('BADGE_TYPE_NOT_EXIST', $rule_type_name);
		}

		return $condition->get_condition_type_name();
	}

	/**
	 * Get the condition language type var from the condition type class
	 *
	 * @param string     $min_value      	  Minimun value
	 * @param string     $max_value    		  Maximum value
	 * @param string     $rule_type_name      The name of the badge type
	 *
	 * @return string The condition type name
	 * @access public
	 */
	public function get_condition_type_lang($min_value, $max_value, $rule_type_name)
	{
		$return = '';

		if ($this->get_condition_bool($rule_type_name))
		{
			$return = ' ' . $this->user->lang['BADGE_USED'];
		} else
		{
			if ($max_value > $min_value)
			{
				$return = ' ' . $this->user->lang['BADGE_BETWEEN'] . ' ' . $min_value . ' ' . $this->user->lang['BADGE_AND'] . ' ' . $max_value;
			} else if ($max_value == 0)
			{
				$return = ' ' . $this->user->lang['BADGE_MORE'] . ' ' . $min_value;
			}
		}
		return $return;
	}
	
	/**
	 * Run badge rule check against users for a given condition/type
	 * Called in the ACP when adding/editing or via the Resync button
	 *
	 * @param int     $rule_id      The id of the badge rule
	 *
	 * @return null
	 * @access public
	 */
	public function sync_badge($rule_id, $options = 'fout')
	{
		// Purge cached rules table queries
		$this->cache->destroy('sql', $this->badge_rules_table);

		// Get the badge type name used by the specified badge rule
		$rule_type_name = $this->get_rule_type_name(0, $rule_id);

		// If badge type exists, run it
		if ($rule_type_name !== false)
		{
			$option_aray = array(
				'action'	=> 'sync',
				'option'	=> ($options === 'fout') ? null : $options 
			);

			if ($rule_type_name == 'sitesplat.badge.type.custom')
			{
				$option_aray = array(
					'users'		=> $this->request->variable('userlist', array('')),
				);
			}
			
			$this->check_condition($rule_type_name, $rule_id, $option_aray);
		}
	}
}
