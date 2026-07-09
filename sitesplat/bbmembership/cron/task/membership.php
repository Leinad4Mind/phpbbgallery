<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership\cron\task;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\notification\manager;

/**
*
* Cron task.
*
*/
class membership extends \phpbb\cron\task\base
{
	protected $config;
	protected $db;
	protected $notification_manager;
	protected $bbmembership_table;
	protected $root_path;
	protected $php_ext;
	protected $bbmembership_helper;

	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct(config $config, driver_interface $db, manager $notification_manager, $bbmembership_table, $root_path, $php_ext, $bbmembership_helper)
	{
		$this->config = $config;
		$this->db = $db;
		$this->notification_manager = $notification_manager;
		$this->bbmembership_table = $bbmembership_table;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->bbmembership_groups = json_decode($this->config['bbmembership_groups'], true);
		$this->bbmembership_helper = $bbmembership_helper;
		$this->bbmembership_package = json_decode($this->config['bbmembership_package'], true);
	}

	/**
	* Runs this cron task.
	*
	* @return null
	*/
	public function run()
	{
		$sql = 'SELECT t1.*
				FROM ' . $this->bbmembership_table . ' t1 LEFT JOIN ' . $this->bbmembership_table . ' t2
					ON (t1.user_id = t2.user_id AND t1.id < t2.id)
				WHERE t2.id IS NULL';
		$result = $this->db->sql_query($sql);
		$ids = $expired_ids = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$mc_gross = $this->bbmembership_helper->find_membership($this->bbmembership_package, 'id', (int) $row['membership']);	
	//		$mc_gross = ($row['mc_currency'] == 'BBPOINTS') ? (int) $rowmc_gross / 100 : (int) $rowmc_gross;
			$membership = (isset($this->bbmembership_groups[$mc_gross]) && 
						  (($this->bbmembership_groups[$mc_gross]['expire'] == -1) ? 300 : 
						  ($this->bbmembership_groups[$mc_gross]['expire'] * 86400)) + $row['payment_date'] > time() ||
						  $this->bbmembership_groups[$mc_gross]['expire'] == 0) ? true: false;
			
			$days_to_expiration = floor((isset($this->bbmembership_groups[$mc_gross])) ?
						((($this->bbmembership_groups[$mc_gross]['expire'] == 0) ? time() :
						(($this->bbmembership_groups[$mc_gross]['expire'] == -1) ? 300 :
						$this->bbmembership_groups[$mc_gross]['expire'] * 86400)) + $row['payment_date'] - time()) / 86400 : 1);
        // echo $days_to_expiration;
			if ($membership && !(max(0, $days_to_expiration -1)) && $row['payment_status'] == 'Completed')
			{
				$ids[$row['user_id']] = $row['id'];
			}
			
			if (!$membership && $row['payment_status'] == 'Completed')
			{
				$expired_ids[$row['user_id']] = array('id' => $row['id'], 'mc_gross' => $mc_gross);
			}	
		}
	
		if (sizeof($ids) > 0)
		{
			foreach($ids as $user_id => $value)
			{
				// send notification
				$this->notification_manager->add_notifications('sitesplat.bbmembership.notification.type.membership_expiring', array(
					'txn_id'		=> $value,
					'user_id'		=> $user_id,
				));
			}
		}

		if (sizeof($expired_ids) > 0)
		{			
			$ids = array_map(function($item) { return $item['id']; }, $expired_ids);
			$sql = 'UPDATE ' . $this->bbmembership_table . ' SET payment_status = "Expired" WHERE id IN (' . implode(',', $ids) . ')';
			$this->db->sql_query($sql);
			
			include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);
			$group_ids = array_map(function($item) { return $item['mc_gross']; }, $expired_ids);
			foreach($ids as $key => $value)
			{
				group_user_del($this->bbmembership_groups[$group_ids[$key]]['group'], $key);
			}
		}
		
		$this->config->set('bbmembership_last_gc', time());
	}

	/**
	 * Returns whether this cron task can run.
	 *
	 * @return bool
	 */
	public function is_runnable()
	{
		return true;
	}

	/**
	* Returns whether this cron task should run now, because enough time
	* has passed since it was last run.
	*
	* @return bool
	*/
	public function should_run()
	{
		return $this->config['bbmembership_last_gc'] < time() - $this->config['bbmembership_gc'];
	}
}
