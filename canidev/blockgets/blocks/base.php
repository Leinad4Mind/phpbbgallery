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

abstract class base
{
	protected $auth;
	protected $config;
	protected $container;
	protected $db;
	protected $dispatcher;
	protected $helper;
	protected $language;
	protected $request;
	protected $template;
	protected $user;

	protected $phpbb_root_path;
	protected $php_ext;
	protected $tables;
	
	public $data			= [];
	public $list			= false;
	public $display_vars	= false;
	public $custom_config	= false;
	public $tpl_name		= '';
	public $manager;
	
	static $icon			= 'fa-file-o';

	const VIEW_FULL 	= 1;
	const VIEW_MEDIUM 	= 2;
	const VIEW_SMALL 	= 4;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config 					$config				Config Object
	 * @param ContainerInterface 					$container			Service container interface
	 * @param \phpbb\db\driver\driver_interface		$db					DB Object
	 * @param \phpbb\event\dispatcher_interface		$phpbb_dispatcher	Event dispatcher
	 * @param \canidev\blockgets\libraries\helper	$helper       		Blockgets helper object
	 * @param \canidev\blockgets\libraries\lang		$language			Blockgets language object
	 * @param \phpbb\request\request 				$request			Request object
	 * @param \phpbb\user							$user				User object
	 * @param array									$block_data			Data of block
	 *
	 * @access public
	 */
	public function __construct(
		\phpbb\config\config $config,
		\Symfony\Component\DependencyInjection\ContainerInterface $container,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $phpbb_dispatcher,
		\canidev\blockgets\libraries\helper $helper,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\user $user,
		$block_data = false)
	{
		$this->auth			= $container->get('auth');
		$this->config		= $config;
		$this->container	= $container;
		$this->db			= $db;
		$this->dispatcher	= $phpbb_dispatcher;
		$this->helper		= $helper;
		$this->language		= $language;
		$this->request		= $request;
		$this->template		= $container->get('canidev.core.template');
		$this->user			= $user;
		
		$this->phpbb_root_path	= $container->getParameter('core.root_path');
		$this->php_ext			= $container->getParameter('core.php_ext');
		$this->tables 			= $container->getParameter('tables.canidev.blockgets');
		
		if(!empty($block_data))
		{
			$block_position = \canidev\blockgets\libraries\blockgets::$block_position_names[$block_data['block_position']];

			$this->data = $block_data;

			$this->data['size_view'] = self::VIEW_FULL;

			if(!defined('IN_ADMIN') && $this->config['blg_block_autofit'])
			{
				if($block_data['parent_id'])
				{
					$this->data['size_view'] = ($block_data['sibling_count']) ? self::VIEW_SMALL : self::VIEW_MEDIUM;
				}
				else if(in_array($block_position, array('left', 'right')))
				{
					$this->data['size_view'] = self::VIEW_SMALL;
				}
			}
		}
	}

	/**
	 * Initialize the block
	 */
	abstract public function init();

	/**
	 * Configure the block in ACP
	 */
	public function configure($mode, $block_row, &$new, &$submit)
	{
	}

	/**
	 * Setup the block in ACP
	 */
	public function setup()
	{
	}

	/**
	 * Get block configuration
	 * @return array|false
	 */
	public function get_config()
	{
		return false;
	}

	/**
	 * Display the block
	 */
	public function display()
	{
		if(!$this->tpl_name)
		{
			return '';
		}

		$block_data	= $this->data;
		$tpl_name	= $this->tpl_name;

		/**
		 * @event block.display
		 * @var array	block_data		The block object data
		 * @var string	tpl_name		Template file to be loaded
		 * @since 2.0.0
		 */
		$vars = array('block_data', 'tpl_name');
		extract($this->dispatcher->trigger_event('block.display', compact($vars)));
		
		$this->data = $block_data;
		
		$this->template->assign_vars(array(
			'BLOCK_ID'			=> $this->data['block_id'],
			'BLOCK_STYLE'		=> $this->get_block_style(),
			'BLOCK_TITLE'		=> $this->language->lang($this->data['block_title']),
			'BLOCK_VIEW_MEDIUM'	=> $this->view_is_medium(),
			'BLOCK_VIEW_SMALL'	=> $this->view_is_small(),
		));
		
		$this->template->set_filenames(array(
			'blg_tpl' => '@canidev_blockgets/blocks/' . $tpl_name . '.html'
		));

		return $this->template->assign_display('blg_tpl');
	}
	
	/**
	 * Manage the block's bbcodes
	 *
	 * @param string	$mode 		(get|set|delete)
	 * @param string	$add 		Extra string to apply in the bbcode name
	 * @param string	$uid 		The bbcode_uid to set
	 * @param string 	$bitfield  	The bbcode_bitfield to set
	 * 
	 * @return bool|array  			Returns true on success, false on failure and array in "get" mode
	 */
	public function bbcode($mode, $uid = '', $bitfield = '')
	{
		switch($mode)
		{
			case 'get':
				return array(
					'uid'		=> (isset($this->data['bbcode_uid']) ? $this->data['bbcode_uid'] : ''),
					'bitfield'	=> (isset($this->data['bbcode_bitfield']) ? $this->data['bbcode_bitfield'] : ''),
				);
			break;

			case 'set':
			case 'delete':
				if(!$uid || !$bitfield || $mode == 'delete')
				{
					$uid = $bitfield = '';
				}

				$this->data['bbcode_uid'] = $uid;
				$this->data['bbcode_bitfield'] = $bitfield;
			break;

			default:
				return false;
			break;
		}

		return true;
	}
	
	/**
	 * Get the extra params and serialize it.
	 */
	public function serialize($new_config, $add_data = false)
	{
		$block_content = $keys = [];

		if(is_array($this->display_vars))
		{
			$keys = array_keys($this->display_vars);
		}
		
		if(!empty($this->list))
		{
			$keys[] = 'list';
		}

		foreach($keys as $key)
		{
			if(isset($new_config[$key]))
			{
				$block_content[$key] = $new_config[$key];
			}
		}
		
		if(is_array($add_data))
		{
			$block_content = array_merge($block_content, $add_data);
		}

		if(sizeof($block_content))
		{
			return @serialize($block_content);
		}

		return '';
	}
	
	/**
	 * Unserialize block content
	 * 
	 * @param string 		$content
	 * @param bool 			$allow_empty
	 * @param array|false 	$new
	 * 
	 * @return array
	 */
	public function unserialize($content = false, $allow_empty = false, $new = false)
	{
		$data = [];
		
		// Use block content if not specific content defined
		if($content === false)
		{
			$content = $this->data['block_content'];
		}

		// Convert the string into an array
		if($content)
		{
			$data = @unserialize($content);
		}

		if(!$allow_empty && empty($data))
		{
			return false;
		}

		if(!is_array($data))
		{
			$data = [];
		}

		if(is_array($new))
		{
			$data = array_merge($data, $new);
		}

		return $data;
	}
	
	/**
	 * Generate display for the text on the blocks using HTML, smilies, bbcode, template and language vars.
	 *
	 * @param string	$text 	The input text to proccess.
	 * @return string 			The result text.
	 */
	public function generate_text_display($text)
	{
		$bbcode = $this->bbcode('get');

		$text = censor_text($text);

		$parse_flags = ($bbcode['bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES | constants::FLAG_HTML;
		$text = generate_text_for_display($text, $bbcode['uid'], $bbcode['bitfield'], $parse_flags);
	
		// Parse language and template vars
		if(strpos($text, '{') !== false)
		{
			// If current user is a guest, Show "Guest" and not "Anonymous" as username
			if($this->user->data['user_id'] == ANONYMOUS)
			{
				$text = str_replace('{S_USERNAME}', '{L_GUEST}', $text);
			}
			
			$text = preg_replace_callback(
				'#\{L_([A-Z0-9_\-]+)\}#',
				function($matches) {
					return $this->language->is_set($matches[1]) ? $this->language->lang($matches[1]) : '';
				}, 
				$text
			);
					
			$text = preg_replace_callback(
				'#\{([A-Z0-9_-]+)\}#', 
				function($matches) {
					return $this->template->get_var($matches[1]);
				}, 
				$text
			);
		}

		return $text;
	}
	
	/**
	 * Get bloc kstyle
	 * 
	 * @return int
	 */
	public function get_block_style()
	{
		$styles = array(
			constants::BLOCK_STYLE_DEFAULT			=> 'default',
			constants::BLOCK_STYLE_ALTERNATIVE		=> 'alternative',
			constants::BLOCK_STYLE_CONTENT_FULL	=> 'content_full',
			constants::BLOCK_STYLE_CONTENT_SIMPLE	=> 'content_simple'
		);
		
		$style = $this->data['block_style'];
		
		return (isset($styles[$style]) ? $styles[$style] : $styles[constants::BLOCK_STYLE_DEFAULT]);
	}

	/**
	 * Get if block size is "medium"
	 * @return bool
	 */
	public function view_is_medium()
	{
		return isset($this->data['size_view']) && ($this->data['size_view'] & self::VIEW_MEDIUM);
	}

	/**
	 * Get if the block size is "small"
	 * @return bool
	 */
	public function view_is_small()
	{
		if($this->view_is_medium())
		{
			return false;
		}

		return isset($this->data['size_view']) && ($this->data['size_view'] & self::VIEW_SMALL);
	}
}
