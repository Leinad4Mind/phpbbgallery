<?php
/*
* @name dockmenu_block.php
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

class dockmenu_block extends base
{
	static $icon = 'blg-icon-th-large';

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

		/**
		* @event block.dockmenu_query
		* @var array	sql_ary		The SQL data
		* @since 2.0.0
		*/
		$vars = array('sql_ary');
		extract($this->dispatcher->trigger_event('block.dockmenu_query', compact($vars)));
	
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

			$row['title'] = $this->lang->get($row['title']);

			$menu_row = array(
				'S_TITLE'		=> $row['title'],
				'S_ICON'		=> '<img src="' . $this->helper->build_image_filename($row['image']) . '" title="' . $row['title'] . '" alt="" />',
				'S_WINDOW'		=> $row['window'],
				'U_LINK'		=> $row['url'],
			);

			/**
			* @event block.dockmenu_row
			* @var array	menu_row		The output array
			* @var array	row				The original data
			* @since 2.0.0
			*/
			$vars = array('menu_row', 'row');
			extract($this->dispatcher->trigger_event('block.dockmenu_row', compact($vars)));
			
			$this->template->assign_block_vars('menu_row', $menu_row);
			
			$icon_count++;
		}
		
		if(!$icon_count)
		{
			return false;
		}

		$this->template->assign_vars(array(
			'DOCK_HEIGHT'			=> ($data['item_width'] + 5) * (($this->data['autofit']) ? $icon_count : 1),
			'DOCK_ITEM_WIDTH'		=> $data['item_width'],
			'DOCK_ITEM_MAXWIDTH'	=> round($data['item_width'] + (($data['item_width'] * 60) / 100)),
		));

		unset($data);
		return true;
	}

	public function get_config()
	{
		$this->list = $this->container->get('canidev.blockgets.admin.links');

		$this->list
			->set_type(LIST_TYPE_IMAGE)
			->set_events(array(
				'edit.before'	=> array($this, 'list_edit_before'),
			));

		$this->display_vars = array(
			'item_width'	=> array('lang' => 'ICON_WIDTH',	'validate' => 'int:16:250',	'type' => 'text:4:3',	'default' => 40),
		);

		return true;
	}
	
	public function list_edit_before($event)
	{
		$display_vars = $event['display_vars'];
		unset($display_vars['type'], $display_vars['description']);
		$event['display_vars'] = $display_vars;
	}
}
