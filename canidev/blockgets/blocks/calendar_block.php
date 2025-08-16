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

class calendar_block extends base
{
	static $icon = 'fa-calendar';

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

		$this->template->assign_var('S_SHOW_EVENTS', (int)$data['show_events']);

		$this->template->assign_json_var('S_OPTIONS', array(
			'url' 		=> $this->helper->route('canidev_blockgets_calendar_controller'),
			'module' 	=> $this->data['block_id'],
		));
		
		if($method == 'submit')
		{
			$action	= $this->request->variable('action', '');

			if($action == 'load_events')
			{
				$timestamp = $this->request->variable('timestamp', 0);
				$event_ary = $calendar->get_events($timestamp);
				
				$calendar->events_to_template('event', $event_ary);
				
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
			'months_number'		=> array('lang' => 'CALENDAR_MONTHS',		'validate' => 'int:1:12', 	'type' => 'number:1:12', 	'default' => 1),
		);

		return true;
	}
}
