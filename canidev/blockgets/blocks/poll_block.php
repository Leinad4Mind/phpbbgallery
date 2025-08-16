<?php
/*
* @package cBB Blockgets
* @version v2.0.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class poll_block extends base
{
	static $icon = 'fa-pie-chart';

	public function init($method = '')
	{
		$this->tpl_name = 'poll_block';

		$this->lang->add_lang('viewtopic');

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		// Initial var setup
		$topic_id	= (int)$data['topic_id'];
		$voted_id	= $this->request->variable('poll_vote_id', array('' => 0));
		$view		= $this->request->variable('view', '');
		$update		= ($method == 'submit' && $this->request->variable('update_vote', false)) ? true : false;

		// Do we have a topic id?
		if(!$topic_id)
		{
			return false;
		}
		
		$sql_ary = array(
			'SELECT'	=> 't.*, f.forum_password, f.forum_status',
			'FROM'		=> array(TOPICS_TABLE => 't'),
			
			'LEFT_JOIN'	=> array(
				array('FROM' => array(FORUMS_TABLE => 'f'),	'ON' => 'f.forum_id = t.forum_id'),
			),
			
			'WHERE'	=> "t.topic_id = $topic_id
				AND t.topic_visibility = " . ITEM_APPROVED . '
				AND t.poll_start > 0'
		);

		/*
		* @event block.poll_topic_query
		* @var array	sql_ary		The SQL data
		* @var	array	data		Block Configuration
		* @since 2.0.0
		*/
		$vars = array('sql_ary', 'data');
		extract($this->dispatcher->trigger_event('block.poll_topic_query', compact($vars)));
		
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$topic_data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if(!$topic_data)
		{
			return true;
		}

		$forum_id 	= (int)$topic_data['forum_id'];
		$poll_info	= $cur_voted_id = array();
		
		$poll_total		= 0;
		$poll_bbcode	= false;

		// Start auth and password check
		if(!$this->auth->acl_get('f_read', $forum_id) || $topic_data['forum_password'])
		{
			return true;
		}
		
		if($this->user->data['is_registered'])
		{
			$sql = 'SELECT poll_option_id
				FROM ' . POLL_VOTES_TABLE . '
				WHERE topic_id = ' . $topic_id . '
					AND vote_user_id = ' . $this->user->data['user_id'];
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$cur_voted_id[] = $row['poll_option_id'];
			}
			$this->db->sql_freeresult($result);
		}
		else
		{
			// Cookie based guest tracking ... I don't like this but hum ho
			// it's oft requested. This relies on "nice" users who don't feel
			// the need to delete cookies to mess with results.
			if($this->request->is_set($this->config['cookie_name'] . '_poll_' . $topic_id, \phpbb\request\request_interface::COOKIE))
			{
				$cur_voted_id = explode(',', $this->request->variable($this->config['cookie_name'] . '_poll_' . $topic_id, '', true, \phpbb\request\request_interface::COOKIE));
				$cur_voted_id = array_map('intval', $cur_voted_id);
			}
		}
		
		$s_can_vote = ($this->auth->acl_get('f_vote', $forum_id) &&
			(($topic_data['poll_length'] != 0 && $topic_data['poll_start'] + $topic_data['poll_length'] > time()) || $topic_data['poll_length'] == 0) &&
			$topic_data['topic_status'] != ITEM_LOCKED &&
			$topic_data['forum_status'] != ITEM_LOCKED &&
			(!sizeof($cur_voted_id) ||
			($this->auth->acl_get('f_votechg', $forum_id) && $topic_data['poll_vote_change']))) ? true : false;

		if($update && $s_can_vote)
		{
			if(!sizeof($voted_id) || sizeof($voted_id) > $topic_data['poll_max_options'])
			{
				$this->helper->json->send(array(
					'message'	=> $this->lang->lang((!sizeof($voted_id)) ? 'NO_VOTE_OPTION' : 'TOO_MANY_VOTE_OPTIONS'),
					'status'	=> \canidev\core\json_response::JSON_STATUS_ERROR
				));
			}

			foreach($voted_id as $option)
			{
				if(in_array($option, $cur_voted_id))
				{
					continue;
				}
				
				$option = (int)$option;

				$sql = 'UPDATE ' . POLL_OPTIONS_TABLE . '
					SET poll_option_total = poll_option_total + 1
					WHERE poll_option_id = ' . $option . '
						AND topic_id = ' . $topic_id;
				$this->db->sql_query($sql);

				if($this->user->data['is_registered'])
				{
					$sql_ary = array(
						'topic_id'			=> $topic_id,
						'poll_option_id'	=> $option,
						'vote_user_id'		=> (int) $this->user->data['user_id'],
						'vote_user_ip'		=> (string) $this->user->ip,
					);

					$sql = 'INSERT INTO  ' . POLL_VOTES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
					$this->db->sql_query($sql);
				}
				
				$cur_voted_id[] = (int)$option;
			}

			foreach($cur_voted_id as $option)
			{
				if(!in_array($option, $voted_id))
				{
					$option = (int)$option;

					$sql = 'UPDATE ' . POLL_OPTIONS_TABLE . '
						SET poll_option_total = poll_option_total - 1
						WHERE poll_option_id = ' . $option . '
							AND topic_id = ' . $topic_id;
					$this->db->sql_query($sql);

					if($this->user->data['is_registered'])
					{
						$sql = 'DELETE FROM ' . POLL_VOTES_TABLE . '
							WHERE topic_id = ' . $topic_id . '
								AND poll_option_id = ' . $option . '
								AND vote_user_id = ' . (int) $this->user->data['user_id'];
						$this->db->sql_query($sql);
					}
					
					unset($cur_voted_id[array_search($option, $cur_voted_id, true)]);
				}
			}

			if($this->user->data['user_id'] == ANONYMOUS && !$this->user->data['is_bot'])
			{
				$this->user->set_cookie('poll_' . $topic_id, implode(',', $voted_id), time() + 31536000);
			}

			$sql = 'UPDATE ' . TOPICS_TABLE . '
				SET poll_last_vote = ' . time() . "
				WHERE topic_id = $topic_id";
			$this->db->sql_query($sql);

			$this->helper->json->add(array(
				'message'	=> $this->lang->lang('VOTE_SUBMITTED'),
			));
		}
		
		$sql_ary = array(
			'SELECT'	=> 'o.*, p.bbcode_bitfield, p.bbcode_uid',
			'FROM'		=> array(
				POLL_OPTIONS_TABLE	=> 'o',
				POSTS_TABLE			=> 'p'
			),
			'WHERE'		=> "o.topic_id = $topic_id
				AND p.post_id = {$topic_data['topic_first_post_id']}
				AND p.topic_id = o.topic_id",
			'ORDER_BY'	=> 'o.poll_option_id'
		);

		/*
		* @event block.poll_options_query
		* @var array	sql_ary		The SQL data
		* @var	array	data		Block Configuration
		* @since 2.0.0
		*/
		$vars = array('sql_ary', 'data');
		extract($this->dispatcher->trigger_event('block.poll_options_query', compact($vars)));
		
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$poll_info[] = $row;
			$poll_total += $row['poll_option_total'];
		}
		$this->db->sql_freeresult($result);
		
		$s_display_results	= (!$s_can_vote || ($s_can_vote && sizeof($cur_voted_id)) || $view == 'viewpoll') ? true : false;
		$parse_flags 		= ($poll_info[0]['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;

		for($i = 0, $size = sizeof($poll_info); $i < $size; $i++)
		{
			$poll_info[$i]['poll_option_text'] = generate_text_for_display($poll_info[$i]['poll_option_text'], $poll_info[$i]['bbcode_uid'], $poll_info[$i]['bbcode_bitfield'], $parse_flags, true);
		}
		
		$topic_data['poll_title'] = generate_text_for_display($topic_data['poll_title'], $poll_info[0]['bbcode_uid'], $poll_info[0]['bbcode_bitfield'], $parse_flags, true);
		$poll_end = $topic_data['poll_length'] + $topic_data['poll_start'];

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('poll');
		
		$poll_row = array(
			'S_POLL_QUESTION'		=> $topic_data['poll_title'],
			'S_TOTAL_VOTES' 		=> $poll_total,
			'S_MAX_VOTES'			=> $this->lang->lang('MAX_OPTIONS_SELECT', (int)$topic_data['poll_max_options']),
			'S_POLL_LENGTH'			=> ($topic_data['poll_length']) ? $this->lang->lang(($poll_end > time()) ? 'POLL_RUN_TILL' : 'POLL_ENDED_AT', $this->user->format_date($poll_end)) : '',
			'S_CAN_VOTE'			=> $s_can_vote,
			'S_DISPLAY_RESULTS'		=> ($data['display_results'] && $s_display_results) ? true : false,
			'S_IS_MULTI_CHOICE'		=> ($topic_data['poll_max_options'] > 1) ? true : false,
			'U_POLL_RESULTS'		=> $this->helper->url('viewtopic', "f=$forum_id&amp;t=$topic_id"),

			'S_HIDDEN_FIELDS'	=> build_hidden_fields(array(
				'jblgm'	=> $this->data['block_id']
			)),
		);

		/*
		* @event block.poll_topic_row
		* @var array	poll_row		The output array
		* @var array	topic_data		The original data
		* @var	array	data			Block Configuration
		* @since 2.0.0
		*/
		$vars = array('poll_row', 'topic_data', 'data');
		extract($this->dispatcher->trigger_event('block.poll_topic_row', compact($vars)));

		$this->template->assign_block_vars('poll', $poll_row);

		foreach($poll_info as $poll_option)
		{
			$option_pct = ($poll_total > 0) ? $poll_option['poll_option_total'] / $poll_total : 0;
			$option_pct_txt = sprintf("%.1d%%", ($option_pct * 100));

			$row = array(
				'POLL_OPTION_ID' 		=> $poll_option['poll_option_id'],
				'POLL_OPTION_CAPTION' 	=> $poll_option['poll_option_text'],
				'POLL_OPTION_RESULT' 	=> $poll_option['poll_option_total'],
				'POLL_OPTION_PERCENT' 	=> $option_pct_txt,
				'POLL_OPTION_PCT'		=> round($option_pct * 100),
				'POLL_OPTION_VOTED'		=> (in_array($poll_option['poll_option_id'], $cur_voted_id)) ? true : false
			);

			/*
			* @event block.poll_options_row
			* @var array	row				The output array
			* @var array	poll_option		The original data
			* @since 2.0.0
			*/
			$vars = array('row', 'poll_option');
			extract($this->dispatcher->trigger_event('block.poll_options_row', compact($vars)));
			
			$this->template->assign_block_vars('poll.poll_option', $row);
		}

		unset($poll_end, $poll_info, $voted_id);
		unset($data, $topic_data);
		return true;
	}

	public function get_config()
	{
		$options = array();

		$sql = 'SELECT topic_id, topic_title
			FROM ' . TOPICS_TABLE . '
			WHERE topic_visibility = ' . ITEM_APPROVED . '
			AND poll_start > 0
			AND (poll_length = 0
				OR (poll_length > 0
				AND (poll_start + poll_length) > ' . time() . ')
			)
			ORDER BY topic_time DESC, topic_title ASC';
		$result = $this->db->sql_query_limit($sql, 100);
		while($row = $this->db->sql_fetchrow($result))
		{
			$options[$row['topic_id']] = \canidev\core\tools::html_truncate($row['topic_title'], 80, '...');
		}
		$this->db->sql_freeresult($result);

		if(!sizeof($options))
		{
			$options[''] = $this->lang->lang('NO_POLLS');
		}
	
		$this->display_vars = array(
			'topic_id'			=> array('lang' => 'DISPLAY_POLL',		'validate' => 'int',	'type' => 'select',			'method' => 'helper',	'params' => array('make_select', $options, false, '{CONFIG_VALUE}', ''),	'default' => 0),
			'display_results'	=> array('lang' => 'DISPLAY_RESULTS',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1),
		);

		return true;
	}
}
