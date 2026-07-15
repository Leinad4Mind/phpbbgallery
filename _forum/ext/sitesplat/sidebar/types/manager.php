<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\types;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Sidebar service manager class
 */
class manager
{
	/** @var array Array with badge types */
	protected $sidebar_types;

	/** @var ContainerInterface */
	protected $phpbb_container;

	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	
	protected $template;
	
	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var string The database table the badge types are stored in */
	protected $sidebar_types_table;
	
	protected $bbemoji_icons_table;
	protected $bbemoji_parser;
	protected $bbemoji_enabled = false;

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
	public function __construct($sidebar_types, ContainerInterface $phpbb_container, \phpbb\cache\driver\driver_interface $cache, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\template\template $template, \phpbb\request\request $request, $sidebar_types_table, $bbemoji_icons_table)
	{
		$this->sidebar_types = $sidebar_types;
		$this->phpbb_container = $phpbb_container;
		$this->cache = $cache;
		$this->db = $db;
		$this->user = $user;
		$this->template = $template;
		$this->request = $request;
		$this->sidebar_types_table = $sidebar_types_table;
	}

	/**
	 * Add new type
	 *
	 * @param string $sidebar_type_name The name of the sidebar type
	 *
	 * @return int The identifier of the new type
	 * @access public
	 */
	public function add_sidebar_type($sidebar_type_name)
	{
		// Insert the type name into the database
		$sql = 'INSERT INTO ' . $this->sidebar_types_table . '
			' . $this->db->sql_build_array('INSERT', array('sidebar_type_name' => $this->db->sql_escape($sidebar_type_name)));
		$this->db->sql_query($sql);

		// Return the id of the newly inserted type
		return (int) $this->db->sql_nextid();
	}

	/**
	 * Get the sidebar type id from the name
	 *
	 * @param string $sidebar_type_name The name of the type
	 *
	 * @return int The sidebar_type_id
	 * @throws \RuntimeException
	 */
	public function get_sidebar_type_id($sidebar_type_name)
	{
		// Get cached ids if they exist
		$sidebar_type_ids = $this->cache->get('_sidebar_type_ids');

		// Get ids from the db if no cache data exists, cache result
		if ($sidebar_type_ids === false)
		{
			$sidebar_type_ids = array();

			$sql = 'SELECT sidebar_type_id, sidebar_type_name, sidebar_options FROM ' . $this->sidebar_types_table;
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$sidebar_type_ids[$row['sidebar_type_name']] = array('id' => (int) $row['sidebar_type_id'], 'options' => $row['sidebar_options']);
			}
			$this->db->sql_freeresult($result);

			$this->cache->put('_sidebar_type_ids', $sidebar_type_ids);
		}

		// Add sidebar type name to db if it exists as service but is not in db, cache result
		if (!isset($sidebar_type_ids[$sidebar_type_name]))
		{
			if (!isset($this->sidebar_types[$sidebar_type_name]))
			{
				throw new \RuntimeException($this->user->lang('SIDEBAR_TYPE_NOT_EXIST', $sidebar_type_name));
			}

			$newid = $this->add_sidebar_type($sidebar_type_name);
			$sidebar_type_ids[$sidebar_type_name] = array('id' => (int) $newid, 'options' => '00');
			$this->cache->put('_sidebar_type_ids', $sidebar_type_ids);
		}

		return $sidebar_type_ids[$sidebar_type_name];
	}

	/**
	 * Get sidebar type ids (as an array)
	 *
	 * @return array Array of sidebar type ids
	 * @access public
	 */
	public function get_sidebar_type_ids()
	{
		$sidebar_type_ids = array();

		$ext_manager = $this->phpbb_container->get('ext.manager');
		foreach ($this->sidebar_types as $type_name => $data)
		{
			$condition = $this->phpbb_container->get($type_name);
			$condition = $condition->get_sidebar_enable();
			if ($condition)
			{
				$sidebar_type_ids[$this->get_sidebar_lang($type_name)] = $this->get_sidebar_type_id($type_name);
			}
		}
		ksort($sidebar_type_ids);
		return $sidebar_type_ids;
	}

	public function is_enabled($sidebar_type_name)
	{
		try
		{
			$condition = $this->phpbb_container->get($sidebar_type_name);
		}
		catch (\InvalidArgumentException $e)
		{
			return false;
		}

		return $condition->get_sidebar_enable();
	}
	/**
	 * Get the sidebar type name
	 *
	 * @param int     $type_id      The id of the type
	 *
	 * @return string|bool The sidebar type name, false on error
	 * @access public
	 */
	public function get_sidebar_type_name($type_id = 0)
	{
		$sql_array = array(
			'SELECT'	=> 'sb.sidebar_type_name',
			'FROM'		=> array(
				$this->sidebar_types_table => 'sb',
			),
			'WHERE' => 'sb.sidebar_type_id = ' . (int) $type_id
		);

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql, 3000);
		$sidebar_type_name = $this->db->sql_fetchfield('sidebar_type_name');
		$this->db->sql_freeresult($result);

		return $sidebar_type_name;
	}

	/**
	 * Get the sidebar language var from the type class
	 *
	 * @param string     $sidebar_type_name      The name of the sidebar type
	 *
	 * @return string The sidebar type name
	 * @access public
	 */
	public function get_sidebar_lang($sidebar_type_name)
	{
		try
		{
			$condition = $this->phpbb_container->get($sidebar_type_name);
		}
		catch (\InvalidArgumentException $e)
		{
			return $this->user->lang('SIDEBAR_TYPE_NOT_EXIST', $sidebar_type_name);
		}

		return $condition->get_sidebar_type_name();
	}

	/**
	 * Check sidebar condition and execute it
	 *
	 * @param string $type_name Name of the sidebar
	 * @param array  $options   Array of optional data
	 *
	 * @return null
	 * @access public
	 */
	public function check_condition($type_name, $options = array())
	{
		// Get an instance of the type to check
		$condition = $this->phpbb_container->get($type_name);

		// Get the user id array of users to check
		$check_users = $condition->outputblock($options);
	}

	/**
	 * Check sidebar condition and execute it
	 *
	 * @param string $type_name Name of the sidebar
	 * @param array  $options   Array of optional data
	 *
	 * @return null
	 * @access public
	 */
	public function get_template($type_name)
	{
		// Get an instance of the type to check
		$condition = $this->phpbb_container->get($type_name);

		// Get the user id array of users to check
		return $condition->get_template_name();
	}
}
