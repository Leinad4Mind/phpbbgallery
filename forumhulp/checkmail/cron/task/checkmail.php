<?php
/**
*
* @package Check mail
* @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\checkmail\cron\task;

use \forumhulp\checkmail\core\verifyEmail;

/**
*
* Ccron task.
*
*/
class checkmail extends \phpbb\cron\task\base
{
	protected $config;
	protected $db;
	protected $user;
	protected $checkmail_table;

	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, $checkmail_table)
	{
		$this->config = $config;
		$this->db = $db;
		$this->user = $user;
		$this->checkmail_table = $checkmail_table;
	}

	/**
	* Runs this cron task.
	*
	* @return null
	*/
	public function run()
	{
		$this->user->add_lang_ext('forumhulp/checkmail', 'info_acp_checkmail');
		$sql = 'SELECT GROUP_CONCAT(group_id SEPARATOR ",") AS ignore_group FROM ' . GROUPS_TABLE . " WHERE group_name = 'BOTS' OR group_name = 'GUESTS'";
		$result = $this->db->sql_query($sql);
		$ignore_group = $this->db->sql_fetchfield('ignore_group');

		$sql = 'SELECT u.user_id, u.user_email FROM ' . USERS_TABLE . ' u
				LEFT OUTER JOIN ' . $this->checkmail_table . ' c ON u.user_id = c.user_id
				WHERE u.group_id NOT IN (' . $ignore_group . ') AND c.user_id IS null
				LIMIT 2';
		$result = $this->db->sql_query($sql);
		$ids = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ids[ $row['user_id']] = $row['user_email'];
		}
		
		if (!sizeof($ids))
		{
			$sql = 'SELECT c.user_id, u.user_email FROM ' . $this->checkmail_table . ' c 
					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = c.user_id
					ORDER BY c.timestamp ASC LIMIT 2';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$ids[ $row['user_id']] = $row['user_email'];
			}
		}

		if (sizeof($ids))
		{
			$vmail = new verifyEmail();
			$vmail->setStreamTimeoutWait(5);
			$vmail->setPort(($this->config['smtp_delivery']) ? $this->config['smtp_port'] : 25);
			
			$vmail->setEmailFrom(($this->config['smtp_delivery']) ? $this->config['smtp_username'] : $this->config['board_email']);
	
			foreach($ids as $user_id => $user_email)
			{
					$status = 0;
					if ($vmail->check($user_email)) {
						$msg = $this->user->lang['EMAIL'] . $user_email . $this->user->lang['EXIST'];
						$status = 1;
					} elseif (verifyEmail::validate($user_email)) {
						$msg = $this->user->lang['EMAIL'] . $user_email . $this->user->lang['VALID'];
					} else {
						$msg = $this->user->lang['EMAIL'] . $user_email . $this->user->lang['NOT_VALID'];
					}
					$sql_ary = array(
						'email'		=> $msg,
						'status'	=> $status,
						'responce'	=> $vmail->getStreamResponce()
					);
					$sql = 'REPLACE INTO ' . $this->checkmail_table . ' 
							VALUES (' . $user_id . ', "' . $sql_ary['email'] . '", ' . $sql_ary['status'] . ', "' . $this->db->sql_escape($sql_ary['responce']) . '", ' . time() . ')';
					$this->db->sql_query($sql);
			}
		}
		$this->config->set('checkmail_last_gc', time());
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
		return $this->config['checkmail_last_gc'] < time() - $this->config['checkmail_gc'];
	}
}
