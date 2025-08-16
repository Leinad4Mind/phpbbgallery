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

class counter_block extends base
{
	static $icon = 'fa-line-chart';

	public function init()
	{
		$this->tpl_name = 'counter_block';
		
		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		if($data['local_count'])
		{
			$counter_visits		= (int)$data['visit_count'];
			$count_startdate	= $data['start_date'];
			
			// Set new visit
			if(!$this->helper->counter_session($this->data['block_id']))
			{
				$data['visit_count'] = $counter_visits = $counter_visits + 1;
			
				$sql = 'UPDATE ' . BLG_BLOCK_TABLE . "
					SET block_content = '" . serialize($data) . "'
					WHERE block_id = " . $this->data['block_id'];
				$this->db->sql_query($sql);
			}
		}
		else
		{
			$counter_visits		= (int)$this->config['blg_counter_visit_count'];
			$count_startdate	= $this->config['blg_counter_start_date'];
		}

		if(!$count_startdate)
		{
			return false;
		}

		// Counter Statistics
		$time_online = time() - $count_startdate;

		$counter_hours	= $time_online / 3600;
		$counter_days	= $time_online / 86400;
		$counter_weeks	= $time_online / 604800;
		$counter_months	= $time_online / 2592000;
		$counter_years	= $time_online / 31536000;
		
		$hits = array(
			'USER'		=> min(($counter_visits / $this->config['num_users']), $counter_visits),
			'HOUR'		=> min(($counter_visits / $counter_hours), $counter_visits),
			'DAY'		=> min(($counter_visits / $counter_days), $counter_visits),
			'WEEK'		=> min(($counter_visits / $counter_weeks), $counter_visits),
			'MONTH'		=> min(($counter_visits / $counter_months), $counter_visits),
			'YEAR'		=> min(($counter_visits / $counter_years), $counter_visits),
		);

		/*
		* @event block.counter_hits
		* @var array	hits	The output array
		* @var	array	data	Block Configuration
		* @since 2.0.0
		*/
		$vars = array('hits', 'data');
		extract($this->dispatcher->trigger_event('block.counter_hits', compact($vars)));

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('counter_hit');
		
		foreach($hits as $lang => $value)
		{
			$this->template->assign_block_vars('counter_hit', array(
				'S_TITLE'	=> $this->lang->lang('HITS_PER_' . $lang),
				'S_VALUE'	=> sprintf('%.2f', $value),
			));	
		}

		$this->template->assign_vars(array(
			'L_COUNTER'				=> ($data['local_count']) ? $this->lang->lang('COUNTER_LOCAL') : $this->lang->lang('COUNTER_TOTAL'),
			'S_COUNTER'				=> preg_replace('#([0-9])#', '<span class="digit-\\1"></span>', sprintf("%08d", $counter_visits)),
			'COUNTER_STARTDATE'		=> $this->lang->lang('COUNTER_STARTDATE', $this->user->format_date($count_startdate)),
		));

		unset($data);
		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		if($this->request->is_set_post('counter_reset'))
		{
			if($mode == 'validate')
			{
				$submit = true;
			}

			if($mode == 'submit')
			{
				$new['start_date']	= time();
				$new['visit_count']	= 0;
			}
		}

		return true;
	}

	public function get_config()
	{
		$this->display_vars = array(
			'local_count'		=> array('lang' => 'COUNTER_LOCAL',		'validate' => 'bool',		'type' => 'radio:yes_no'),
			'reset'				=> array('lang' => 'COUNTER_RESET',		'type' => 'custom', 		'method' => 'helper',	'params' => array('counter_rst')),
			'start_date'		=> false,
			'visit_count'		=> false,
		);

		return true;
	}
}
