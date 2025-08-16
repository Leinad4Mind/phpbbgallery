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

class share_block extends base
{
	static $icon = 'fa-share-alt';

	function init()
	{
		$this->tpl_name = 'share_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		if(empty($data['share_buttons']))
		{
			return false;
		}
		
		$this->template->assign_json_var('S_SHARE_PARAMS', array(
			'buttons'			=> $data['share_buttons'],
			'inlineButtons'		=> ($this->view_is_small() && $data['show_names']) ? false : true,
			'iconPath'			=> $this->helper->get_ext_path(true) . 'images/social/',
			'showNames'			=> $data['show_names'],
			'url'				=> !empty($data['share_url']) ? $data['share_url'] : $this->get_share_url(),
		));

		unset($data);
		return true;
	}

	function configure($mode, $block_row, &$new, &$submit)
	{
		if($mode == 'submit')
		{
			$new['share_buttons'] = $this->request->variable('button', array(0 => ''));
		}
	}

	function get_config()
	{
		$this->display_vars = array(
			'show_names'	=> array('lang' => 'SHARE_SHOW_NAMES',	'validate' => 'bool',			'type' => 'radio:yes_no',	'default' => 1),
			'share_url'		=> array('lang' => 'SHARE_URL',			'validate' => 'string:0:255',	'type' => 'text:40:255',	'default' => ''),
			'share_buttons'	=> array('lang' => 'SHARE_BUTTONS',		'type' => 'custom',				'function' => array($this, 'buttons_select'),	'params' => array('{CONFIG_VALUE}'),	'default' => array()),
		);

		$this->tpl_name = 'acp_share_block';

		return true;
	}

	function get_share_url()
	{
		$share_url = $this->helper->current_url();

		/*
		* Tags to delete from url and conditionals to delete
		* param => conditionals (Delete param if conditional1 or conditional2 or .... if present in the url)
		*/
		$strip_tags = array(
			'sid'	=> 1,
			'style'	=> 1,
			'start'	=> 1,
			'f'		=> array('t', 'p'),
			'p'		=> 't',
		);

		// Delete the anchor if its present
		if(($anchor_pos = strpos($share_url, '#')) !== false)
		{
			$share_url = substr($share_url, 0, $anchor_pos);
		}

		if (strpos($share_url, '?') !== false)
		{
			// Separe args and url
			$delim_pos = strpos($share_url, '?');

			$args = substr($share_url, $delim_pos + 1);
			$args = ($args) ? explode('&', str_replace('&amp;', '&', $args)) : array();
			$share_url = substr($share_url, 0, $delim_pos);

			// Create array with args
			$query = array();
			foreach ($args as $argument)
			{
				if($argument)
				{
					$arguments = explode('=', $argument, 2);
					$query[$arguments[0]] = $argument;
				}
			}
			unset($args);

			foreach($strip_tags as $delete_tag => $conditions)
			{
				if(!isset($query[$delete_tag]))
				{
					continue;
				}

				if(!is_array($conditions))
				{
					$conditions = array($conditions);
				}

				foreach($conditions as $condition)
				{
					if($condition == 1 || isset($query[$condition]))
					{
						unset($query[$delete_tag]);
						break;
					}
				}
			}

			// Compose the url
			if(!empty($query))
			{
				$share_url .= '?' . implode('&amp;', $query);
			}
		}

		return $share_url;
	}

	/**
	 * build_share_select
	 * Make select for a share block
	*/
	public function buttons_select($select)
	{
		if(!is_array($select))
		{
			$select = array();
		}

		$this->template->assign_json_var('S_SHARE_PARAMS', array(
			'mode'		=> 'admin',
			'buttons'	=> $select,
			'iconPath'	=> $this->helper->get_ext_path(true) . 'images/social/',
		));

		return '<div class="blg-option-selector"></div>';
	}
}
