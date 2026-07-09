<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

use canidev\blockgets\libraries\constants;

class banners_block extends base
{
	static $icon = 'fa-th';

	/**
	 * {@inheritDoc}
	 */
	public function init()
	{
		$this->tpl_name = 'banners_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		if(empty($data['list']))
		{
			return false;
		}

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('banners');
		
		$link_ary	= $data['list'];
		$link_limit	= ($data['banner_number']) ? min((int)$data['banner_number'], sizeof($link_ary)) : sizeof($link_ary);

		if($data['random_order'])
		{
			shuffle($link_ary);
		}
		
		for($i = 0; $i < $link_limit; $i++)
		{
			$row = $link_ary[$i];

			if(!$this->helper->group_auth($row['groups']))
			{
				continue;
			}

			// If is internal link, append root path and user sid
			if($row['url'] && !preg_match('#^(http|//)#', $row['url']))
			{
				$user_sid = (strpos($row['url'], 'adm/') !== false) ? $this->user->session_id : false;
				$row['url'] = append_sid($this->phpbb_root_path . $row['url'], false, true, $user_sid);
			}

			$banner_row = [	
				'S_IMG' 			=> '<img src="' . $this->helper->build_image_filename($row['image']) . '" title="' . $row['title'] . '" alt="banner">',
				'S_TITLE' 			=> $row['title'],
				'S_SHOW_TITLE'		=> $data['show_title'],
				'S_WINDOW'			=> $row['window'],
				'U_URL' 			=> $row['url'],		
			];

			/**
			 * @event block.banners_row
			 * @var array	banner_row		The output array
			 * @var array	row				The original data
			 * @var	array	data			Block Configuration
			 * @since 2.0.0
			 */
			$vars = ['banner_row', 'row', 'data'];
			extract($this->dispatcher->trigger_event('block.banners_row', compact($vars)));
			
			$this->template->assign_block_vars('banners', $banner_row);
		}

		$this->template->assign_vars([
			'S_BLOCK_HEIGHT'		=> (($data['list_type'] == constants::SCROLL_V) ? $data['block_height'] : 'auto'),
			'S_MARQUEE_DIRECTION'	=> (($data['list_type'] == constants::SCROLL_NONE || $data['list_type'] == constants::SCROLL_H) ? 'left' : 'up'),
			'S_MARQUEE_ALIGN'		=> (($data['list_type'] == constants::SCROLL_H) ? 'left' : 'center'),
			'S_MARQUEE_TYPE'		=> (($data['list_type'] == constants::SCROLL_NONE) ? 'static' : 'scroll'),
			'S_MARQUEE_SPEED'		=> $data['scroll_fps'],
		]);

		unset($data, $link_ary);
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$types = [
			constants::SCROLL_NONE 	=> 'LIST_NO_SCROLL',
			constants::SCROLL_H		=> 'LIST_SCROLL_H',
			constants::SCROLL_V		=> 'LIST_SCROLL_V',
		];

		$this->display_vars = [
			'show_title'	=> ['lang' => 'BANNERS_TITLE',		'validate' => 'bool',		'type' => 'radio:yes_no'],
			'random_order'	=> ['lang' => 'BANNERS_RANDOM',		'validate' => 'bool',		'type' => 'radio:yes_no'],
			'list_type'		=> ['lang' => 'BANNERS_LS_TYPE',	'validate' => 'int',		'type' => 'custom', 		'function' => ['tools', 'make_select'],	'params' => [$types, '{KEY}', '{CONFIG_VALUE}']],
			'banner_number'	=> ['lang' => 'BANNERS_NUMBER',		'validate' => 'int',		'type' => 'number',			'default' => 0],
			'block_height'	=> ['lang' => 'BANNERS_B_HEIGHT',	'validate' => 'int',		'type' => 'number',			'default' => 50],
			'scroll_fps'	=> ['lang' => 'MARQUEE_SPEED',		'validate' => 'int:1:10',	'type' => 'number:1:10',	'default' => 2],
		];
		
		$this->list = $this->container->get('canidev.blockgets.admin.links');
		
		$this->list
			->set_type(constants::LIST_TYPE_IMAGE)
			->set_events([
				'edit.before'	=> [$this, 'list_edit_before'],
			]);

		return true;
	}
	
	/**
	 * Event for list
	 * @param \phpbb\event\data $event
	 */
	public function list_edit_before($event)
	{
		$display_vars = $event['display_vars'];
		unset($display_vars['type'], $display_vars['description']);
		$event['display_vars'] = $display_vars;
	}
}
