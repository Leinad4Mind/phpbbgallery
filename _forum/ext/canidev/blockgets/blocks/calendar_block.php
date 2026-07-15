<?php
/**
 * @package cBB Blockgets
 * @version 2.0.6 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class calendar_block extends base
{
	static $icon = 'fa-calendar';

	/**
	 * {@inheritDoc}
	 */
	public function init($method = false)
	{
		$this->tpl_name = 'calendar_block';

		if(($data = $this->unserialize()) === false || !$this->config['blg_calendar_enabled'] || !$this->auth->acl_get('u_blockgets_calendar'))
		{
			return false;
		}
		
		$calendar = $this->container->get('canidev.blockgets.controller.calendar');
		
		$calendar->set_options([
			'events'	=> (bool)$data['show_events'],
			'birthdays'	=> (bool)$data['show_birthdays'] && $this->auth->acl_get('u_blockgets_birthdays'),
			'months'	=> (int)$data['months_number'],
		]);

		$this->template->assign_var('S_SHOW_EVENTS', (int)$data['show_events']);

		$this->template->assign_json_var('S_OPTIONS', [
			'url' 		=> $this->helper->route('canidev_blockgets_calendar_controller'),
			'module' 	=> $this->data['block_id'],
		]);
		
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

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$this->display_vars = [
			'show_events'		=> ['lang' => 'CALENDAR_EVENTS',		'validate' => 'bool',		'type' => 'radio:yes_no',	'default' => 1],
			'show_birthdays'	=> ['lang' => 'CALENDAR_BIRTHDAYS',		'validate' => 'bool',		'type' => 'radio:yes_no',	'default' => 1],
			'months_number'		=> ['lang' => 'CALENDAR_MONTHS',		'validate' => 'int:1:12', 	'type' => 'number:1:12', 	'default' => 1],
		];

		return true;
	}
}
