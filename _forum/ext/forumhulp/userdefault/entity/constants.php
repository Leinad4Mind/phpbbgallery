<?php
/**
*
* UserDefaults extension for the phpBB Forum Software package.
*
* @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\userdefault\entity;

use phpbb\user;
use phpbb\db\driver\driver_interface;

class constants
{
	public $user;
	public $db;
	public $sort_dir_text;
	public $limit_days;
	public $sort_by_topic_text;
	public $sort_by_post_text;
	
	public function __construct(user $user, driver_interface $db)
	{
		$this->user = $user;
		$this->db = $db;
		
		$sql = 'SELECT notification_type_id 
				FROM ' . NOTIFICATION_TYPES_TABLE . " 
				WHERE notification_type_name = 'notification.type.report_post' OR notification_type_name = 'notification.type.topic_in_queue'
				ORDER BY notification_type_name";
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);

		$this->notification_type_report = $rows[0]['notification_type_id'];
		$this->notification_type_needs_approval = $rows[1]['notification_type_id'];			
		$this->sort_dir_text = array('a' => $user->lang['ASCENDING'], 'd' => $user->lang['DESCENDING']);
		$this->limit_days = array(0 => $user->lang['ALL_TOPICS'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 
								90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);
		$this->sort_by_topic_text = array('a' => $user->lang['AUTHOR'], 't' => $user->lang['POST_TIME'], 's' => $user->lang['SUBJECT'], 'r' => $user->lang['REPLIES'],
								'v' => $user->lang['VIEWS']);
		$this->sort_by_post_text = $this->sort_by_topic_text; 
		array_splice($this->sort_by_post_text, 3, 4); 
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function get($array)
	{
		return $this->$array;	
	}

	/**
	 * {@inheritdoc}
	 */
	public function findkey($key, $index) 
	{
		$sort_ary  = (strpos($key, '_st') === false) ? ((strpos($key, '_sd') === false) ?  ((strpos($key, 'topic_') === false) ? 
					$this->sort_by_post_text : $this->sort_by_topic_text) : $this->sort_dir_text) : $this->limit_days;

		$i = 0;
		foreach($sort_ary as $key => $value)
		{
			if ($index == $key)
			{
				return $i;
			}
			$i++;
		}
		return 0;
	}

	/**
	 * {@inheritdoc}
	 */
	public function Index($index, $sort_ary) 
	{
		$Count = count($this->$sort_ary);
		if ($index <= $Count)
		{
			$Keys = array_keys($this->$sort_ary);
			return $Keys[$index];
		} else {
			return 0;
		}
	}
}
