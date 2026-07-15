<?php
/**
*
* @package BBdonations
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\donations\cron\task\core;

/**
 * Badge Award cron task.
 */
class donations extends \phpbb\cron\task\base
{
	protected $config;
	protected $db;
	protected $auth;
	protected $phpbb_root_path;
	protected $phpEx;
	protected $donation_table;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config                 $config  Config object
	 * @param \sitesplat\badge\conditions\manager $manager Badge Award condition manager object
	 * @access public
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, $phpbb_root_path, $phpEx, $donation_table)
	{
		$this->config			= $config;
		$this->db				= $db;
		$this->auth				= $auth;
		$this->root_path		= $phpbb_root_path;
		$this->phpEx			= $phpEx;
		$this->donation_table	= $donation_table;
	}

	/**
	 * Runs this cron task.
	 *
	 * @return null
	 */
	public function run()
	{
		$group_amount = json_decode($this->config['donations_group_id'], true);
		if ($this->config['donations_fallbackgroup'] && $group_amount['time'])
		{
			$ids = $admin_mod_ary = array();
			if ($group_amount['time'])
			{
				$sql = 'SELECT d.user_id FROM ' . $this->donation_table . ' d
						INNER JOIN ' . USER_GROUP_TABLE . ' g ON g.user_id = d.user_id
						WHERE d.payment_date < ' .  (time() - ($group_amount['time'] * 86400)) . ' 
						AND group_id = ' . $group_amount['group'] . '
						GROUP BY d.user_id, d.payment_date ORDER BY d.payment_date DESC';
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$ids[] = $row['user_id'];
				}
			}
			$ids = (array_unique($ids));
	
			foreach ($this->auth->acl_get_list(false, array('a_', 'm_'), false) as $temp => $admin_ary)
			{
				foreach ($admin_ary as $temp => $admin_ary)
				{
					foreach ($admin_ary as $admin_ary)
					{
						$admin_mod_ary[] = $admin_ary;
					}
				}
			}
			$admin_mod_ary = array_unique($admin_mod_ary);
			if (sizeof($ids))
			{
				include_once($this->root_path . 'includes/functions_user.' . $this->phpEx);
				foreach($ids as $userid)
				{
					if (!in_array($userid, $admin_mod_ary))
					{
						group_user_del($group_amount['group'], array($userid));
						group_user_add($this->config['donations_fallbackgroup'], $userid);
						$sql = 'UPDATE ' . $this->donation_table . " SET payment_status = 'Expired' WHERE user_id = $userid";
					}
				}
			}
		}
		$this->config->set('donations_last_gc', time());
	}

	/**
	 * Returns whether this cron task can run, given current board configuration.
	 *
	 * If warnings are set to never expire, this cron task will not run.
	 *
	 * @return bool
	 */
	public function is_runnable()
	{
		return $this->config['donations_fallbackgroup'] != 0;
	}

	/**
	 * Returns whether this cron task should run now, because enough time
	 * has passed since it was last run (24 hours).
	 *
	 * @return bool
	 */
	public function should_run()
	{
		return $this->config['donations_last_gc'] < time() - $this->config['donations_gc'];
	}
}
