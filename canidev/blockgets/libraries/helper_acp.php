<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\libraries;

use Symfony\Component\DependencyInjection\ContainerInterface;

class helper_acp
{
	protected $container;
	protected $db;
	protected $helper;
	protected $language;
	protected $request;
	protected $template;
	protected $tools;
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
	 * @param \canidev\core\tools						$tools 				Core Tools Object
	 * @param \phpbb\user								$user				User object
	 *
	 * @access public
	 */
	public function __construct(
		ContainerInterface $container,
		\phpbb\db\driver\driver_interface $db,
		\canidev\blockgets\libraries\helper $helper,
		\phpbb\language\language $language, 
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\canidev\core\tools $tools,
		\phpbb\user $user)
	{
		$this->container 	= $container;
		$this->db			= $db;
		$this->helper		= $helper;
		$this->language		= $language;
		$this->request		= $request;
		$this->template		= $template;
		$this->tools 		= $tools;
		$this->user			= $user;
	}
	
	/**
	 * Make URL input
	 * 
	 * @param string 	$key
	 * @param array 	$row
	 * @param int 		$size
	 * @param int 		$maxlength
	 * @param string 	$check_key
	 * 
	 * @return string
	 */
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
			$result .= '<label for="' . $check_key . '">' . $this->language->lang('LINK_WINDOW') . '</label>';
		}
		
		return $result;
	}
	
	/**
	 * Make color/gallery input
	 * 
	 * @param string 	$key			Input key/id
	 * @param mixed 	$value			Input value
	 * @param bool 		$gallery_btn 	Set if gallery button must be available
	 * @param bool 		$color_btn		Set if color button must be available
	 * 
	 * @return string
	 */
	public function easy_input_template($key, $value = '', $gallery_btn = false, $color_btn = false)
	{
		$this->template->assign_vars([
			'HELPER_NAME'		=> 'easy_input',
			'HP_ID'				=> gen_rand_string(4),
			'HP_KEY'			=> $key,
			'HP_NAME'			=> defined('IN_ADMIN') ? "config[$key]" : $key,
			'HP_SIZE'			=> ($gallery_btn) ? 40 : 15,
			'HP_VALUE'			=> $value,
			
			'IS_COLOR'			=> ($color_btn && preg_match('/^#[A-Z0-9]{3,6}/', $value)) ? true : false,
			'COLOR_BTN'			=> $color_btn,
			'GALLERY_BTN'		=> $gallery_btn,
		]);
		
		return $this->display();
	}

	/**
	 * Make a Textarea with "Full Editor" button
	 * 
	 * @param string 	$text 		Textarea value
	 * @param string 	$key		Textarea key/id
	 * @param int 		$rows		Textarea rows number
	 * 
	 * @return string
	 */
	public function build_editor($text, $key, $rows)
	{
		$editor = \canidev\core\editor::get_instance($this->container);

		$editor->add_plugin('/canidev/blockgets/libraries/editor_plugin_html', true);

		$editor->build([
			'name'		=> "config[$key]",
			'rows'		=> $rows,
			'type'		=> 'basic',
			'value'		=> $text,
			'toolbar'	=> ['b', 'i', 'u', 'quote', 'code', 'list', 'list=1', '*', 'img', 'url', 'color', 'size'],
		]);

		$this->template->assign_vars([
			'HELPER_NAME'		=> 'editor',
		]);
		
		return $this->display();
	}

	/**
	 * Build list actions for pages
	 * 
	 * @param array 	$action_ary 		List of actions
	 * @param string 	$separator 			Action separator
	 * 
	 * @return string
	 */
	public function build_list_actions($action_ary, $separator = '|')
	{
		$output = [];
		
		foreach($action_ary as $langid => $action)
		{
			$s_label = $this->language->lang($langid);
			
			if(strpos($langid, 'DELETE') !== false || strpos($langid, 'UNINSTALL') !== false)
			{
				$s_label = '<span class="critical-action">' . $s_label . '</span>';
			}
			
			$output[] = '<a href="' . $action . '">' . $s_label . '</a>';
		}
		
		return implode(' ' . $separator . ' ', $output);
	}
	
	/**
	 * Build select for link's position
	 * 
	 * @param string 	$value
	 * @param string 	$key
	 * 
	 * @return string
	 */
	public function pagelinks_select($value, $key)
	{
		$options = [
			''			=> 'LINK_NONE',
			'top'		=> 'LINK_TOP',
			'bottom'	=> 'LINK_BOTTOM',
			'quick'		=> 'LINK_QUICK',
		];
		
		return $this->tools->make_select($options, $key, $value);
	}
	
	/**
	 * Format sizes
	 * 
	 * @param string|array 		$key
	 * @param array|string 		$data
	 * @param bool 				$submit
	 * 
	 * @return array|string
	 */
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
			$options = [
				'px'	=> 'px',
				'%'		=> '%',
			];
			
			$number	= $type	= '';
			
			if(preg_match('#([0-9]+)(px|\%)?#', $data, $match))
			{
				$number = $match[1];
				$type	= (isset($match[2]) ? $match[2] : '');
			}

			$this->template->assign_vars([
				'HELPER_NAME'	=> 'size_formatter',
				'HP_ID'			=> gen_rand_string(4),
				'HP_KEY'		=> $key,
				'HP_NAME'		=> defined('IN_ADMIN') ? "config[$key]" : $key,
				'HP_VALUE'		=> $number,
				'HP_OPTIONS'	=> $this->tools->make_select($options, false, $type),
			]);
			
			return $this->display();
		}
	}
	
	/**
	 * Make selects with scroller options
	 * 
	 * @param string		$item
	 * @param string 		$list
	 * 
	 * @return string
	 */
	public function scroll_select($item = '', $list = '')
	{
		$lists = [
			'direction'		=> ['left', 'right', 'up', 'down'],
			'direction_x'	=> ['left', 'right'],
			'align'			=> ['left', 'center', 'right'],
		];

		if(!isset($lists[$list]))
		{
			return '';
		}

		$options = [];
		foreach($lists[$list] as $id)
		{
			$options[$id] =  $this->language->lang(strtoupper($id));
		}

		return $this->tools->make_select($options, false, $item);
	}

	/**
	 * Build select for block desing
	 * 
	 * @param string 	$selected 		Selected design
	 * @return string
	 */
	public function block_design_select($selected)
	{
		$options = [
			'full' 		=> 'DESIGN_FULL',
			'simple' 	=> 'DESIGN_SIMPLE',
		];

		return $this->tools->make_select($options, false, $selected);
	}
	
	/**
	 * Make a button for global and local counter reset
	 * @return string
	 */
	public function counter_rst()
	{
		return '<button class="cbb-btn" name="counter_reset" value="1" type="submit">' . $this->language->lang('RUN') . '</button>';
	}
	
	/**
	 * Display helper template
	 * 
	 * @return string
	 * @access private
	 */
	private function display()
	{
		$this->template->set_filenames([
			'helper'	=> '@canidev_blockgets/helper_body.html'
		]);
		
		return $this->template->assign_display('helper');
	}
}
