<?php
/*
* @name share_block.php
* @package cBB Blockgets
* @version $Id: share_block.php, v1.0.4 10/01/2014 $
*
* @copyright (c) 2014 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class share_block extends base
{
	static $icon = 'blg-icon-share-alt';

	private $buttons = array(
		'google'	=> array('id' => 1,	'small' => 'size="medium" annotation="none",60*25',	'big' => 'size="medium",65*25'),
		'twitter'	=> array('id' => 2,	'small' => 'none,65*25',		'big' => 'horizontal,95*21'),
		'facebook'	=> array('id' => 3,	'small' => 'button,76*25',	'big' => 'button_count,105*21'),
		'linkedin'	=> array('id' => 4,	'small' => ',0*0',		'big' => 'right,0*0'),
	);

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

		$share_url	= (!empty($data['share_url']) ? $data['share_url'] : $this->get_share_url());
		$share_size	= ($data['share_counter']) ? 'big' : 'small';

		foreach($this->buttons as $button_id => $params)
		{
			$tpl	= 'S_' . strtoupper($button_id);
			$show	= false;

			if(in_array($params['id'], $data['share_buttons']))
			{
				if(isset($params[$share_size]))
				{
					if(preg_match('#([a-z\-_\"=]+),([0-9]+)\*([0-9]+)#', $params[$share_size], $btn_size))
					{
						$this->template->assign_vars(array(
							$tpl . '_SIZE'		=> $btn_size[1],
							$tpl . '_STYLE'		=> 'width:' . $btn_size[2] . 'px;height:' . $btn_size[3] . 'px;',
						));
					}
				}

				$show = true;
			}

			$this->template->assign_var($tpl . '_SHOW', $show);
		}

		$this->template->assign_vars(array(
			'S_SHARE_LANG'			=> $this->user->lang_name,
			'S_SHARE_LOCALE'		=> $this->helper->locale_lang(),
			'U_SHARE_URL'			=> $share_url,
			'U_SHARE_URL_ENCODED'	=> urlencode($share_url),
		));

		unset($data);
		return true;
	}

	function configure($mode, $block_row, &$new, &$submit)
	{
		if($mode == 'submit')
		{
			$new['share_buttons'] = $this->request->variable('button', array(0));
		}
	}

	function get_config()
	{
		$this->display_vars = array(
			'share_counter'	=> array('lang' => 'SHARE_COUNTER',	'validate' => 'bool',			'type' => 'radio:yes_no',	'default' => 1),
			'share_url'		=> array('lang' => 'SHARE_URL',		'validate' => 'string:0:255',	'type' => 'text:40:255',	'default' => ''),
			'share_buttons'	=> array('lang' => 'SHARE_BUTTONS',	'type' => 'custom',				'function' => array($this, 'buttons_select'),	'params' => array('{CONFIG_VALUE}'),	'default' => array()),
		);

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
		$string = '';

		if(!is_array($select))
		{
			$select = array();
		}

		foreach($this->buttons as $name => $params)
		{
			$selected = (in_array($params['id'], $select) ? ' checked="checked"' : '');
			$string .= '<label><input type="checkbox" class="radio" name="button[]" value="' . $params['id'] . '"' . $selected . '> ' . ucfirst($name) . '</label>';
		}

		return $string;
	}
}
