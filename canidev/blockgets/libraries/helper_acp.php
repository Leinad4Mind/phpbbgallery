<?php
/*
* @package cBB Blockgets
* @version v2.0.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\libraries;

class helper_acp extends \canidev\core\acp
{
	protected $container;
	protected $db;
	protected $helper;
	protected $lang;
	protected $request;
	protected $template;
	protected $user;

	/**
	* Constructor
	*
	* @param ContainerInterface 						$container			Service container interface
	* @param \phpbb\db\driver\driver_interface			$db					DB Object
	* @param \canidev\blockgets\libraries\helper		$helper				Blockgets helper Object
	* @param \phpbb\language\language					$language			Language Object
	* @param \phpbb\request\request 					$request			Request object
	* @param \phpbb\template\template					$template     		Template object
	* @param \phpbb\user								$user				User object
	*
	* @access public
	*/
	public function __construct(
		\Symfony\Component\DependencyInjection\ContainerInterface $container,
		\phpbb\db\driver\driver_interface $db,
		\canidev\blockgets\libraries\helper $helper,
		\phpbb\language\language $language, 
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\phpbb\user $user)
	{
		$this->container 	= $container;
		$this->db			= $db;
		$this->helper		= $helper;
		$this->lang			= $language;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
	}
	
	public function url_template($key, $row, $size = 0, $maxlength = 0, $check_key = '')
	{
		$name 		= 'config[' . $key . ']';
		$row[$key]	= (isset($row[$key]) ? $row[$key] : '');

		$result =  '<input type="text" id="' . $key . '" name="' . $name . '" value="' . $row[$key] . '"' .
			(($size) ? ' size="' . $size . '"' : '') .
			(($maxlength) ? ' maxlength="' . $maxlength . '"' : '') . ' />';
			
		if($check_key)
		{
			$name2		= 'config[' . $check_key . ']';
			$checked	= (!empty($row[$check_key]) ? ' checked = "checked"' : '');
			
			$result .= '<input type="checkbox" class="radio cbb-checkbox" id="' . $check_key . '" name="' . $name2 . '" value="1"' . $checked . ' />';
			$result .= '<label for="' . $check_key . '">' . $this->lang->lang('LINK_WINDOW') . '</label>';
		}
		
		return $result;
	}
	
	public function easy_input_template($key, $value = '', $gallery_btn = false, $color_btn = false)
	{
		$this->template->assign_vars(array(
			'HELPER_NAME'		=> 'easy_input',
			'HP_ID'				=> gen_rand_string(4),
			'HP_KEY'			=> $key,
			'HP_NAME'			=> defined('IN_ADMIN') ? "config[$key]" : $key,
			'HP_SIZE'			=> ($gallery_btn) ? 40 : 15,
			'HP_VALUE'			=> $value,
			
			'IS_COLOR'			=> ($color_btn && preg_match('/^#[A-Z0-9]{3,6}/', $value)) ? true : false,
			'COLOR_BTN'			=> $color_btn,
			'GALLERY_BTN'		=> $gallery_btn,
		));
		
		return $this->display();
	}

	/**
	 * build_editor
	 * Make a Textarea with "Full Editor" button
	*/
	public function build_editor($text, $key, $rows, $cols)
	{
		$editor = \canidev\core\editor::get_instance($this->container);

		$editor->add_plugin('/canidev/blockgets/libraries/editor_plugin_html', true);

		$editor->build(array(
			'name'		=> "config[$key]",
			'rows'		=> $rows,
			'type'		=> 'basic',
			'value'		=> $text,
			'toolbar'	=> array('b', 'i', 'u', 'quote', 'code', 'list', 'list=1', '*', 'img', 'url', 'color', 'size'),
		));

		$this->template->assign_vars(array(
			'HELPER_NAME'		=> 'editor',
		));
		
		return $this->display();
	}

	public function build_list_actions($action_ary, $separator = '|')
	{
		$output = array();
		
		foreach($action_ary as $langid => $action)
		{
			$s_label = $this->lang->lang($langid);
			
			if(strpos($langid, 'DELETE') !== false || strpos($langid, 'UNINSTALL') !== false)
			{
				$s_label = '<span class="critical-action">' . $s_label . '</span>';
			}
			
			$output[] = '<a href="' . $action . '">' . $s_label . '</a>';
		}
		
		return implode(' ' . $separator . ' ', $output);
	}
	
	public function pagelinks_select($value, $key)
	{
		$options = array(
			''			=> 'LINK_NONE',
			'top'		=> 'LINK_TOP',
			'bottom'	=> 'LINK_BOTTOM',
			'quick'		=> 'LINK_QUICK',
		);
		
		return $this->make_select($options, $key, $value);
	}
	
	public function size_formatter($key, $data, $submit = false)
	{
		if($submit)
		{
			if(is_array($key))
			{
				foreach($key as $skey)
				{
					$data = $this->size_formatter($skey, $data, true);
				}
				
				return $data;
			}

			$type = 'px';
			
			if(isset($data[$key . '_type']))
			{
				$type = $data[$key . '_type'];
				unset($data[$key . '_type']);
			}
			
			$data[$key] .= $type;
			
			return $data;
		}
		else
		{
			$options = array(
				'px'	=> 'px',
				'%'		=> '%',
			);
			
			$number	= $type	= '';
			
			if(preg_match('#([0-9]+)(px|\%)?#', $data, $match))
			{
				$number = $match[1];
				$type	= (isset($match[2]) ? $match[2] : '');
			}

			$this->template->assign_vars(array(
				'HELPER_NAME'	=> 'size_formatter',
				'HP_ID'			=> gen_rand_string(4),
				'HP_KEY'		=> $key,
				'HP_NAME'		=> defined('IN_ADMIN') ? "config[$key]" : $key,
				'HP_VALUE'		=> $number,
				'HP_OPTIONS'	=> $this->make_select($options, false, $type),
			));
			
			return $this->display();
		}
	}
	
	/**
	 * scroll_select
	 * Make selects with scroller options
	*/
	public function scroll_select($item = '', $list = '')
	{
		$lists = array(
			'direction'		=> array('left', 'right', 'up', 'down'),
			'direction_x'	=> array('left', 'right'),
			'align'			=> array('left', 'center', 'right'),
		);

		if(!isset($lists[$list]))
		{
			return '';
		}

		$options = array();
		foreach($lists[$list] as $id)
		{
			$options[$id] =  $this->lang->lang(strtoupper($id));
		}

		return $this->make_select($options, false, $item);
	}

	public function block_design_select($selected)
	{
		$options = array(
			'full' 		=> 'DESIGN_FULL',
			'simple' 	=> 'DESIGN_SIMPLE',
		);

		return $this->make_select($options, false, $selected);
	}
	
	/**
	 * counter_rst
	 * Make a button for global and local counter reset
	*/
	public function counter_rst()
	{
		return '<button class="cbb-btn" name="counter_reset" value="1" type="submit">' . $this->lang->lang('RUN') . '</button>';
	}
	
	private function display()
	{
		$this->template->set_filenames(array(
			'helper'	=> '@canidev_blockgets/helper_body.html'
		));
		
		return $this->template->assign_display('helper');
	}
}
