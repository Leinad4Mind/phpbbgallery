<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\types\type;

/**
 * Poll class
 */
class poll extends \sitesplat\sidebar\types\type\base
{
	/**
	 * Get sidebar block enable
	 *
	 * @return sidebar block enabled
	 * @access public
	 */
	public function get_sidebar_enable()
	{
		return true;
	}

	/**
	 * Get sidebar type
	 *
	 * @return string sidebar type
	 * @access public
	 */
	public function get_sidebar_type()
	{
		return 'sitesplat.sidebar.type.poll';
	}

	/**
	 * Get sidebar type name
	 *
	 * @return string sidebar type name
	 * @access public
	 */
	public function get_sidebar_type_name()
	{
		return $this->user->lang('SIDEBAR_TYPE_POLL');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_template_name()
	{
		return '@sitesplat_sidebar/poll.html';
	}

	/**
	* {@inheritdoc}
	*/
	public function outputblock()
	{
		$sql = 'SELECT forum_id,topic_id, poll_title, poll_start, poll_length, poll_max_options, poll_last_vote, poll_vote_change 
				FROM ' . TOPICS_TABLE . ' 
				ORDER BY poll_start DESC LIMIT 1';
		$result = $this->db->sql_query($sql);
		if ($result)
		{
			$row = $this->db->sql_fetchrow($result);
			
			$poll_sql = 'SELECT poll_option_id, poll_option_text, poll_option_total FROM ' . POLL_OPTIONS_TABLE . '
						WHERE topic_id = ' . $row['topic_id'] . ' ORDER BY poll_option_id';
			$poll_result = $this->db->sql_query($poll_sql);
			$poll_total_votes = 0;
			$poll_data = $data = array();

			if ($poll_result)
			{
				while($polls_data = $this->db->sql_fetchrow($poll_result))
				{
					$poll_data[] = $polls_data;
					$poll_total_votes += ($polls_data['poll_option_total'] > 0) ? $polls_data['poll_option_total'] : 1;
				}
			}
			$this->db->sql_freeresult($poll_result);

			foreach($poll_data as $pd)
			{
				$option_pct = (($pd['poll_option_total'] > 0) ? $pd['poll_option_total'] : 1) / $poll_total_votes;
				$data[] = array('name'	=> $pd['poll_option_text'], 'y' => round($option_pct * 100), 'f' => $row['forum_id'], 't' => $row['topic_id'],
							'v'		=> $pd['poll_option_id']);	
			}
			
			$this->template->assign_vars(array(
				'TITLE'		=> $row['poll_title'],
				'URL'		=> append_sid('viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&t=' . $row['topic_id']),
				'POLSTATS'	=> str_replace(array('"name"', '"y"', '"f"' , '"t"', '"v"'), array('name', 'y', 'f', 't', 'v'), json_encode($data, JSON_NUMERIC_CHECK))
			));
		}
	}
}
