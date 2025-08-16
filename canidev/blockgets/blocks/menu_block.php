<?php
/*
* @package cBB Blockgets
* @version v2.0.2 12/01/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class menu_block extends base
{
	static $icon = 'fa-th-list';

	public function init()
	{
		$this->tpl_name = 'menu_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('menu_row');

		if(empty($data['list']))
		{
			return false;
		}

		$media = $this->helper->get_media(false);
		
		// Get de menu links
		foreach($data['list'] as $row)
		{
			if(!$this->helper->group_auth($row['groups']))
			{
				continue;
			}

			// If is internal link, append root path and user sid
			if($row['url'] && strpos($row['url'], 'http') !== 0)
			{
				$user_sid = (strpos($row['url'], 'adm/') !== false) ? $this->user->session_id : false;
				$row['url'] = append_sid($this->phpbb_root_path . $row['url'], false, true, $user_sid);
			}

			$menu_row = array(
				'IS_CAT'		=> ($row['type'] == LIST_CAT) ? true : false,
				'S_ICON'		=> $media->build_icon_html($row['image']),
				'S_TEXT'		=> $this->lang->lang($row['title']),
				'S_TITLE'		=> str_replace(array('"', '&quot;'), "'", $this->lang->lang($row['description'])),
				'S_WINDOW'		=> $row['window'],
				'U_LINK'		=> $row['url'],
			);

			/*
			* @event block.menu_row
			* @var array	menu_row	The output array
			* @var array	row			The original data
			* @var	array	data		Block Configuration
			* @since 2.0.0
			*/
			$vars = array('menu_row', 'row', 'data');
			extract($this->dispatcher->trigger_event('block.menu_row', compact($vars)));
			
			$this->template->assign_block_vars('menu_row', $menu_row);
		}

		unset($data);
		return true;
	}

	public function get_config()
	{
		$this->list = $this->container->get('canidev.blockgets.admin.links');
		$this->list->set_type(LIST_TYPE_ICON);
		
		return false;
	}
}
