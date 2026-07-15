<?php
/*
* @name calendar_block.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class calendar_block extends base
{
	static $icon = 'blg-icon-calendar';

	public function init($method = false)
	{
		$this->tpl_name = 'calendar_block';

		if(($data = $this->unserialize()) === false || !$this->config['blg_calendar_enabled'] || !$this->auth->acl_get('u_blockgets_calendar'))
		{
			return false;
		}
		
		$calendar = $this->container->get('canidev.blockgets.controller.calendar');
		
		$calendar->set_options(array(
			'events'	=> (bool)$data['show_events'],
			'birthdays'	=> (bool)$data['show_birthdays'],
			'months'	=> (int)$data['months_number'],
		));
		
		$extra_params = array(
			'jblgm'		=> $this->data['block_id'],
		);

		$this->template->assign_vars(array(
			'U_CALENDAR'			=> $this->helper->route('canidev_blockgets_calendar_controller'),
			'S_EXTRA'				=> http_build_query($extra_params, '', '&'),
			'S_SHOW_EVENTS'			=> (int)$data['show_events'],
		));
		
		if($this->request->is_ajax() && $method)
		{
			$action	= $this->request->variable('action', '');

			if($action == 'load_events')
			{
				$timestamp = $this->request->variable('timestamp', 0);
				$event_ary = $calendar->get_events($timestamp);
				
				foreach($event_ary as $event)
				{
					$this->template->assign_block_vars('event', array(
						'S_ID'		=> (isset($event['id']) ? $event['id'] : 0),
						'S_TITLE'	=> $event['title'],
						'S_TYPE'	=> $event['type'],
						'S_CONTENT'	=> $event['content'],
					));
				}
				
				$this->template->assign_var('IN_EVENTLIST', true);
				
				return true;
			}

			if($action == 'prev' || $action == 'next')
			{
				$month_data = $calendar->get_month($action);
				$calendar->set_month($month_data['month'], $month_data['year']);
			}
	
			$this->template->assign_var('IN_CALENDAR', true);
		}
		else
		{
			$calendar->reset();
		}
		
		$calendar
			->get_events()
			->create_calendar();

		unset($data);
		return true;
	}

	public function get_config()
	{
		$this->display_vars = array(
			'show_events'		=> array('lang' => 'CALENDAR_EVENTS',		'validate' => 'bool',		'type' => 'radio:yes_no',	'default' => 1),
			'show_birthdays'	=> array('lang' => 'CALENDAR_BIRTHDAYS',	'validate' => 'bool',		'type' => 'radio:yes_no',	'default' => 1),
			'months_number'		=> array('lang' => 'CALENDAR_MONTHS',		'validate' => 'int:1:12', 	'type' => 'text:5:3', 		'default' => 1),
		);

		return true;
	}
}
