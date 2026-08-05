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
		$sql = 'SELECT group_id FROM ' . GROUPS_TABLE . ' WHERE ' . $this->db->sql_in_set('group_name', array('BOTS', 'GUESTS'));
		$result = $this->db->sql_query($sql);
		$ignore_group = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ignore_group[] = (int) $row['group_id'];
		}
		$this->db->sql_freeresult($result);

		$sql = 'SELECT u.user_id, u.user_email FROM ' . USERS_TABLE . ' u
				LEFT OUTER JOIN ' . $this->checkmail_table . ' c ON u.user_id = c.user_id
				WHERE ' . $this->db->sql_in_set('u.group_id', $ignore_group, true) . ' AND c.user_id IS null';
		$result = $this->db->sql_query_limit($sql, 2);
		$ids = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ids[ $row['user_id']] = $row['user_email'];
		}
		$this->db->sql_freeresult($result);

		if (!sizeof($ids))
		{
			$sql = 'SELECT c.user_id, u.user_email FROM ' . $this->checkmail_table . ' c
					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = c.user_id
					ORDER BY c.timestamp ASC';
			$result = $this->db->sql_query_limit($sql, 2);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$ids[ $row['user_id']] = $row['user_email'];
			}
			$this->db->sql_freeresult($result);
		}

		if (sizeof($ids))
		{
			$vmail = new verifyEmail();
			$vmail->setStreamTimeoutWait(5);
			$vmail->setPort(($this->config['smtp_delivery']) ? $this->config['smtp_port'] : 25);

			$vmail->setEmailFrom(($this->config['smtp_delivery']) ? $this->config['smtp_username'] : $this->config['board_email']);

			foreach($ids as $user_id => $user_email)
			{
					if ($vmail->check($user_email))
					{
						$status = 1;
					}
					else if (verifyEmail::validate($user_email))
					{
						$status = 2;
					}
					else
					{
						$status = 0;
					}

					$sql_ary = array(
						'user_id'	=> (int) $user_id,
						'email'		=> $user_email,
						'status'	=> $status,
						'responce'	=> $vmail->getStreamResponce(),
						'timestamp'	=> time(),
					);

					$this->db->sql_query('DELETE FROM ' . $this->checkmail_table . ' WHERE user_id = ' . (int) $user_id);
					$this->db->sql_query('INSERT INTO ' . $this->checkmail_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary));
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
