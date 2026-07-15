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

class dockmenu_block extends base
{
	static $icon = 'fa-th-large';

	/**
	 * {@inheritDoc}
	 */
	public function init()
	{
		$this->tpl_name = 'dockmenu_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$icon_count = 0;

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('menu_row');
		
		if(empty($data['list']))
		{
			return false;
		}
	
		// Get de menu links
		foreach($data['list'] as $row)
		{
			if(!$this->helper->group_auth($row['groups']) || !$row['image'])
			{
				continue;
			}

			// If is internal link, append root path and user sid
			if($row['url'] && strpos($row['url'], 'http') !== 0)
			{
				$user_sid = (strpos($row['url'], 'adm/') !== false) ? $this->user->session_id : false;
				$row['url'] = append_sid($this->phpbb_root_path . $row['url'], false, true, $user_sid);
			}

			$row['title'] = $this->language->lang($row['title']);

			$menu_row = [
				'S_TITLE'		=> $row['title'],
				'S_ICON'		=> '<img src="' . $this->helper->build_image_filename($row['image']) . '" title="' . $row['title'] . '" alt="icon" />',
				'S_WINDOW'		=> $row['window'],
				'U_LINK'		=> $row['url'],
			];

			/**
			 * @event block.dockmenu_row
			 * @var array	menu_row		The output array
			 * @var array	row				The original data
			 * @var	array	data			Block Configuration
			 * @since 2.0.0
			 */
			$vars = ['menu_row', 'row', 'data'];
			extract($this->dispatcher->trigger_event('block.dockmenu_row', compact($vars)));
			
			$this->template->assign_block_vars('menu_row', $menu_row);
			
			$icon_count++;
		}
		
		if(!$icon_count)
		{
			return false;
		}

		$this->template->assign_json_var('S_DOCK_PARAMS', [
			'maxWidth' 		=> round($data['item_width'] + (($data['item_width'] * 70) / 100)),
			'orientation'	=> $this->view_is_small() ? 'v' : 'h',
			'itemWidth' 	=> $data['item_width'],
		]);

		unset($data);
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$this->list = $this->container->get('canidev.blockgets.admin.links');

		$this->list
			->set_type(constants::LIST_TYPE_IMAGE)
			->set_events([
				'edit.before'	=> [$this, 'list_edit_before'],
			]);

		$this->display_vars = [
			'item_width'	=> ['lang' => 'ICON_WIDTH',	'validate' => 'int:16:250',	'type' => 'number:16:250',	'default' => 40],
		];

		return true;
	}
	
	/**
	 * Event for list
	 * @param \phpbb\event\data 	$event
	 */
	public function list_edit_before($event)
	{
		$display_vars = $event['display_vars'];
		unset($display_vars['type'], $display_vars['description']);
		$event['display_vars'] = $display_vars;
	}
}
