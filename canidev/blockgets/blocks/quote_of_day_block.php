<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

use canidev\blockgets\libraries\constants;

class quote_of_day_block extends base
{
	static $icon = 'fa-quote-right';

	/**
	 * {@inheritDoc}
	 */
	public function init()
	{
		$this->tpl_name = 'quote_of_day_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		if(empty($data['list']))
		{
			return false;
		}
		
		$last_id = $new_id = (isset($data['last_id']) ? $data['last_id'] : -1);
		
		if($data['all_day'])
		{
			if(!isset($data['last_time']))
			{
				$data['last_time'] = time();
				$new_id = 0;
			}
			else
			{
				$time	= $this->user->create_datetime();
				$now	= phpbb_gmgetdate($time->getTimestamp() + $time->getOffset());
				$date	= phpbb_gmgetdate($data['last_time'] + $time->getOffset());

				if($date['mday'] != $now['mday'] || $date['mon'] != $now['mon'] || $date['year'] != $now['year'])
				{
					$data['last_time'] = time();
					$new_id++;
				}
			}
			
			$quote = $this->find_quote($data, $new_id);
		}
		else
		{
			$data['last_time'] = time();
			$new_id++;

			$quote = $this->find_quote($data, $new_id);
		}
		
		// Update the last id and last time if neccessary
		if($new_id != $last_id)
		{
			$data['last_id'] = $new_id;
			
			$this->display_vars = $data;

			$sql = 'UPDATE ' . $this->tables['blocks'] . "
				SET block_content = '" . $this->db->sql_escape($this->serialize($data)) . "'
				WHERE block_id = " . $this->data['block_id'];
			$this->db->sql_query($sql);
		}
	
		$this->template->assign_vars(array(
			'S_QUOTE_TEXT'		=> $quote['text'],
			'S_QUOTE_AUTHOR'	=> ($data['show_author']) ? $quote['author'] : '',
		));

		unset($data);
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$this->display_vars = array(
			'all_day'			=> array('lang' => 'QUOTES_ALL_DAY',		'validate' => 'bool',	'type' => 'radio:yes_no', 'default' => 1),
			'rand'				=> array('lang' => 'QUOTES_RAND',			'validate' => 'bool',	'type' => 'radio:yes_no', 'default' => 0),
			'show_author'		=> array('lang' => 'QUOTES_SHOW_AUTHOR',	'validate' => 'bool',	'type' => 'radio:yes_no', 'default' => 1),
			'last_time'			=> false,
			'last_id'			=> false,
		);
		
		$this->list = $this->container->get('canidev.blockgets.admin.links');
		
		$this->list
			->set_options(array(
				'title'	=> 'QUOTES_LIST',
				'type'	=> constants::LIST_TYPE_NONE,
				'mask'	=> array('title' => 'text',	'subtitle' => 'author')
			))
			->set_events(array(
				'edit.before'	=> array($this, 'list_edit_before'),
			));

		return true;
	}
	
	/**
	 * Event for list
	 * @param \phpbb\event\data 	$event
	 */
	public function list_edit_before($event)
	{
		$event['display_vars'] = array(
			'text'			=> array('lang' => 'QUOTE_TEXT',		'validate' => 'string:1:255',	'type' => 'text:40:255'),
			'author'		=> array('lang' => 'QUOTE_AUTHOR',		'validate' => 'string:1:255',	'type' => 'text:40:255'),
		);
	}
	
	/**
	 * Find quote to show
	 * 
	 * @param array 	$data
	 * @param int 		$new_id
	 * 
	 * @return int
	 * @access private
	 */
	private function find_quote($data, &$new_id)
	{
		if($data['rand'] && sizeof($data['list']) > 1)
		{
			$new_id = mt_rand(0, (count($data['list'])-1));
		}
		
		if(!isset($data['list'][$new_id]))
		{
			$new_id = 0;
		}
		
		return $data['list'][$new_id];
	}
}
