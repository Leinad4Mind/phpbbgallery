<?php
/*
* @package cBB Blockgets
* @version v2.0.3 26/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

class stats_block extends base
{
	static $icon = 'fa-bar-chart';

	public function init()
	{
		$this->tpl_name = 'stats_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		// Set some stats, get posts count from forums data if we... hum... retrieve all forums data
		$total_posts	= $this->config['num_posts'];
		$total_topics	= $this->config['num_topics'];
		$total_users	= $this->config['num_users'];
		$board_days		= ceil((time() - $this->config['board_startdate']) / 86400);

		$stats 		= array();
		$stat_data	= $this->get_stats();

		if($this->user->data['user_id'] != ANONYMOUS)
		{
			$stats[] = array(
				'legend'	=> 'ST_NEW',
				'sep'		=> false,

				'POSTS'		=> $stat_data['newposttotal'],
				'TOPICS'	=> $stat_data['newtopictotal'],
				'ANNS'		=> $stat_data['newannouncmenttotal'],
				'STICKYS'	=> $stat_data['newstickytotal'],
			);
		}

		$stats[] = array(
			'legend'	=> 'ST_TOP',
			'sep'		=> false,

			'POSTS'		=> $total_posts,
			'TOPICS'	=> $total_topics,
			'ANNS'		=> $stat_data['announcmenttotal'],
			'STICKYS'	=> $stat_data['stickytotal'],
		);

		$stats[] = array(
			'sep'		=> true,

			'TOPICS_PER_DAY'	=> (!$board_days) ? 0 : min(round($total_topics / $board_days, 0), $total_topics),	
			'POSTS_PER_DAY'		=> (!$board_days) ? 0 : min(round($total_posts  / $board_days, 0), $total_posts),	
			'USERS_PER_DAY'		=> (!$board_days) ? 0 : min(round($total_users  / $board_days, 0), $total_users),	
			'TOPICS_PER_USER'	=> (!$total_users) ? 0 : min(round($total_topics / $total_users, 0), $total_topics),	
			'POSTS_PER_USER'	=> (!$total_users) ? 0 : min(round($total_posts  / $total_users, 0), $total_posts),	
			'POSTS_PER_TOPIC'	=> (!$total_topics) ? 0 : min(round($total_posts  / $total_topics, 0), $total_posts),
		);

		$stats[] = array(
			'sep'		=> true,

			'ATTACHMENTS'		=> sprintf('%d (%s)', $stat_data['attachmentcount'], get_formatted_filesize($stat_data['attachmentsize'])),
			'ACTIVE_POSTERS'	=> $stat_data['activeuserpostcount'],
			'BOARD_STARTDATE'	=> $this->helper->format_short_date($this->config['board_startdate']),
			'VISIT_IP'			=> $this->user->ip,

			'TOTAL_USERS'		=> $total_users,
		);

		/*
		* @event block.stats_rows
		* @var array	stats	The output data
		* @var	array	data	Block Configuration
		* @since 2.0.0
		*/
		$vars = array('stats', 'data');
		extract($this->dispatcher->trigger_event('block.stats_rows', compact($vars)));

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('stat');

		// Build stats
		foreach($stats as $stat)
		{
			$this->template->assign_block_vars('stat', array(
				'IS_CAT'	=> true,
				'S_SEP'		=> $stat['sep'],
				'S_LEGEND'	=> (isset($stat['legend']) ? $this->lang->lang($stat['legend']) : ''),
			));

			foreach($stat as $lang => $value)
			{
				if($lang == 'legend' || $lang == 'sep')
				{
					continue;
				}

				$this->template->assign_block_vars('stat', array(
					'IS_CAT'	=> false,

					'S_NAME'	=> $this->lang->lang("ST_$lang"),
					'S_VALUE'	=> $value,
				));
			}
		}

		if($data['user_stats'])
		{
			// Grab an array with all the today users info
			$today_users = $this->helper->obtain_today_visits();

			$this->template->assign_vars(array(
				'SHOW_USER_STATS'			=> true,
				'S_TOTAL_USERS_LASTVISIT'	=> $today_users['lastvisit_users'],
				'S_LASTVISIT_USER_LIST' 	=> $today_users['userlist'],
				'S_NEWEST_USER'				=> get_username_string('full', $this->config['newest_user_id'], $this->config['newest_username'], $this->config['newest_user_colour']),
			));
		}

		$this->template->assign_var('S_INLINE', (int)$data['stats_inline']);

		unset($data);
		return true;
	}

	public function get_config()
	{
		$this->display_vars = array(
			'stats_inline'	=> array('lang' => 'STATS_INLINE',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 0),
			'user_stats'	=> array('lang' => 'USER_STATS',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1),
		);

		return true;
	}
	
	private function get_stats()
	{
		$cache		= $this->container->get('cache.driver');
		$cache_id	= '_blockgets_stats';
		
		if(($result = $cache->get($cache_id)) === false)
		{
			$modes = array(
				'newposttotal'	=> 'SELECT COUNT(post_id) AS count_total
					FROM ' . POSTS_TABLE . '
					WHERE post_time > ' . $this->user->data['session_last_visit'],

				'newtopictotal'	=> 'SELECT COUNT(topic_id) AS count_total
					FROM ' . TOPICS_TABLE . '
					WHERE topic_time > ' . $this->user->data['session_last_visit'],
				
				'newannouncmenttotal'	=> 'SELECT COUNT(topic_id) AS count_total
					FROM ' . TOPICS_TABLE . '
					WHERE topic_type = ' . POST_ANNOUNCE . '
					AND topic_time > ' . $this->user->data['session_last_visit'],

				'newstickytotal'	=> 'SELECT COUNT(topic_id) AS count_total
					FROM ' . TOPICS_TABLE . '
					WHERE topic_type = ' . POST_STICKY . '
					AND topic_time > ' . $this->user->data['session_last_visit'],	

				'announcmenttotal'	=> 'SELECT COUNT(topic_id) AS count_total
					FROM ' . TOPICS_TABLE . '
					WHERE ' . $this->db->sql_in_set('topic_type', array(POST_ANNOUNCE, POST_GLOBAL)),

				'stickytotal'	=> 'SELECT COUNT(topic_id) AS count_total
					FROM ' . TOPICS_TABLE . '
					WHERE topic_type = ' . POST_STICKY,

				'attachmentcount'	=> 'SELECT COUNT(attach_id) as count_total
					FROM ' . ATTACHMENTS_TABLE . '
					WHERE is_orphan = 0',

				'attachmentsize'	=> 'SELECT SUM(filesize) as count_total
					FROM ' . ATTACHMENTS_TABLE . '
					WHERE is_orphan = 0',

				'activeuserpostcount'	=> 'SELECT COUNT(user_id) AS count_total
					FROM ' . USERS_TABLE . '
					WHERE user_posts > 0',
			);
			
			$result = array();
			
			foreach($modes as $mode => $sql)
			{
				$rst = $this->db->sql_query($sql);
				$result[$mode] = (int) $this->db->sql_fetchfield('count_total');
				$this->db->sql_freeresult($rst);
			}
			
			$cache->put($cache_id, $result, 3600); // Cached the result 1 hour
		}

		return $result;
	}
}
