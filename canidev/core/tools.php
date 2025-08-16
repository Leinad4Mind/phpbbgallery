<?php
/**
* @package Ext Common Core
* @version 1.1.0 01/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\core;

use \Symfony\Component\DependencyInjection\ContainerInterface;

class tools
{
	const SELECT_PARSE_LANG		= 1;
	const SELECT_MULTIPLE		= 2;

	protected $db;
	protected $dispatcher;
	protected $language;
	protected $request;

	protected $phpbb_root_path;
	protected $php_ext;

	/**
	* Constructor
	*
	* @param ContainerInterface 	$container		Service container interface
	*
	* @access public
	*/
	public function __construct(ContainerInterface $container)
	{
		$this->db 			= $container->get('dbal.conn');
		$this->dispatcher 	= $container->get('dispatcher');
		$this->language 	= $container->get('language');
		$this->request 		= $container->get('request');

		$this->phpbb_root_path 	= $container->getParameter('core.root_path');
		$this->phpb_ext 		= $container->getParameter('core.php_ext');
	}

	/**
	 * Build select input
	 * 
	 * @param array 		$options 		Pair of (value => title) data
	 * @param string 		$key 			Id of the input
	 * @param mixed 		$select_ids 	Options to ve marked as selected for default
	 * @param int 			$flags 			SELECT_PARSE_LANG | SELECT_MULTIPLE
	 * @param string 		$classname 		Custom class name for the input
	 * 
	 * @return string
	*/
	public function make_select($options, $key, $select_ids = '', $flags = self::SELECT_PARSE_LANG, $classname = '')
	{
		$in_group		= false;
		$string 		= '';
		$flags 			= (int)$flags; // Make sure it is a number

		if(!is_array($select_ids) && !is_null($select_ids))
		{
			$select_ids = explode(',', $select_ids);
		}

		/**
		 * @event canidev.core.make_select
		 * @var array	options			Options to show in the select "value => title"
		 * @var string	key				Key (name) for the select
		 * @var array	select_ids		Selected values
		 * @var int 	flags 			Config for the select
		 * @var string 	classname 		Custom class name

		 * @return string
		 * @since 1.0.17
		 */
		$vars = array('options', 'key', 'select_ids', 'flags', 'classname');
		extract($this->dispatcher->trigger_event('canidev.core.make_select', compact($vars)));

		$classname = ($classname) ? ' class="' . $classname . '"' : '';
		
		if($flags & self::SELECT_MULTIPLE)
		{
			$string = '<select' . $classname . ' id="' . $key . '" name="' . $key . '[]" multiple="multiple" size="8">';
		}
		else if($key !== false)
		{
			$select_ids = array($select_ids[0]);
			$string = '<select' . $classname . ' id="' . $key . '" name="config[' . $key . ']">';
		}

		foreach($options as $value => $title)
		{
			$title	= ($flags & self::SELECT_PARSE_LANG) ? $this->language->lang($title) : $title;

			if(strpos($value, 'legend') !== false)
			{
				$string .= (($in_group) ? '</optgroup>' : '') . '<optgroup label="' . $title . '">';
				$in_group = true;
				
				continue;
			}

			$selected	= ($select_ids !== null && in_array($value, $select_ids) ? ' selected="selected"' : '');
			$string .= '<option value="' . $value . '"' . $selected . '>' . $title . '</option>';
		}
		
		if($in_group)
		{
			$string .= '</optgroup>';
		}
		
		if($key !== false || $flags & self::SELECT_MULTIPLE)
		{
			$string .= '</select>';
		}

		return $string;
	}

	/**
	 * Make select with the forum names
	 * 
	 * @param string 	$config_key 		Key for input
	 * @param mixed 	$select_ids 		Selected forum IDs
	 * @param bool 		$ignore_cats 		Set to true to don't show categories
	 * @param string 	$classname 			Optional class name for input
	 * 
	 * @return string
	 */
	public function forums_select($config_key = 'forums', $select_ids = false, $ignore_cats = false, $classname = '')
	{
		if(!function_exists('make_forum_select'))
		{
			include($this->phpbb_root_path . 'includes/functions_admin.' . $this->php_ext);
		}

		$output = '<select ' . (($classname) ? 'class="' . $classname . '" ' : '') . 'name="' . $config_key . '[]" id="' . $config_key . '" multiple="multiple" size="5">';
		$output .= (($ignore_cats) ? make_forum_select($select_ids, false, true, true, true, true) : make_forum_select($select_ids, false, true));
		$output .= '</select>';

		return $output;
	}

	/**
	 * Create a select with all groups
	 * 
	 * @param string 	$config_key 		Key for input
	 * @param mixed 	$select_groups 		Selected group IDs
	 * @param boll 		$include_all 		Define if "All" checkbox must be displayed
	 * 
	 * @return string
	 */
	public function groups_select($config_key, $select_groups, $include_all = true)
	{
		$output 	= '';
		$group_ary 	= array();

		if(!empty($select_groups))
		{
			$group_ary = is_array($select_groups) ? $select_groups : explode(',', $select_groups);
		}

		// Get all the groups
		$sql = 'SELECT DISTINCT group_type, group_name, group_id
			FROM ' . GROUPS_TABLE . '
			ORDER BY group_type DESC, group_name ASC';
		$result = $this->db->sql_query($sql);

		$output = '<div class="js-groups-select cbb-groups-selector">
			<select name="' . $config_key . '[]" id="' . $config_key . '" multiple="multiple" size="5">';

		while($row = $this->db->sql_fetchrow($result))
		{
			$s_selected = (in_array($row['group_id'], $group_ary)) ? ' selected="selected"' : '';
			$output .= '<option' . (($row['group_type'] == GROUP_SPECIAL) ? ' class="group-special"' : '') . ' value="' . $row['group_id'] . '"' . $s_selected . '>' . (($row['group_type'] == GROUP_SPECIAL) ? $this->language->lang('G_' . $row['group_name']) : $row['group_name']) . '</option>';
		}
		$this->db->sql_freeresult($result);

		$output .= '</select>';

		if($include_all)
		{
			$all_groups_key = 'all_groups_' . $config_key;
			$output .= '<input type="checkbox" class="radio" id="all-groups-' . $config_key . '" name="' . $all_groups_key . '" value="1"' . (($select_groups == 'all' || $this->request->is_set_post($all_groups_key)) ? ' checked="checked"' : '') . '/><label for="all-groups-' . $config_key . '">' . $this->language->lang('ALL_GROUPS') . '</label>';
		}
		
		$output .= '</div>';

		return $output;
	}

	/**
	 * Truncates string while retaining special characters if going over the max length
	 *
	 * @param string	$input			The text to truncate to the given length.
	 * @param int		$limit			Maximum length of string
	 * @param string	$append			String to be appended
	 * @param bool		$count_all		Defines if count all or only plain text
	 */
	public static function html_truncate($input = '', $limit = 0, $append = '', $count_all = false)
	{
		$check_len = ($count_all) ? utf8_strlen($input) : utf8_strlen(strip_tags($input));

		if(!$input || $limit <= 0 || $check_len <= $limit)
		{
			return $input;
		}

		$splits = preg_split('#(</?[^>]*/?>)#', $input, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

		$text		= '';
		$open_tag	= false;
		$open_tags 	= array();

		foreach($splits as $split)
		{
			// Open new tag
			if(preg_match('#^<([a-zA-Z]+).*>#', $split, $match))
			{
				if(utf8_substr($match[0], -2) !== '/>' && !in_array($match[1], array('img', 'br', 'hr', 'input')))
				{
					$open_tags[] = $match[1];
				}
			}
			
			// Close tag, if the current
			if(sizeof($open_tags) && $split === "</" . end($open_tags) . ">")
			{
				array_splice($open_tags, -1, 1);
			}

			// Adjust the string
			if(sizeof($open_tags) && $split[0] != '<')
			{ 
				$length = ($count_all) ? utf8_strlen($text) : utf8_strlen(strip_tags($text));

				if(($length + utf8_strlen($split)) > $limit)
				{
					$split = utf8_substr($split, 0, $limit - $length);
				}
			}
			
			$text .= $split;

			// If exceed the limit and no open tags finish here,
			// and it is looking backwards to remove the tag open.
			$check_len = ($count_all) ? utf8_strlen($text) : utf8_strlen(strip_tags($text));
			if($check_len >= $limit)
			{
				// Try to cut the text before close the open tags
				if($split[0] != '<' && $check_len > $limit)
				{
					$chars_to_remove = max(0, utf8_strlen($split) - $limit);
					
					if($chars_to_remove)
					{
						$text = utf8_substr($text, 0, utf8_strlen($text) - $chars_to_remove);
					}
				}

				$tags_count = sizeof($open_tags);

				for($i = $tags_count; $i > 0; $i--)
				{
					$text .= '</' . $open_tags[$i-1] . '>';
				}
		
				break;
			}
		}

		return $text . (($append) ? $append : '');
	}

	/**
	 * Set Full URL to smilies in text
	 * 
	 * @param string $text 		Original text
	 * @return string
	 */
	public static function fix_smilies_path($text)
	{
		if(defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH)
		{
			return $text;
		}

		$board_url	= generate_board_url();

		return preg_replace_callback('#class\="smilies" src\="(.*?)(/images/.*?)"#', function($matches) use ($board_url) {
			return 'class="smilies" src="' . $board_url . $matches[2] . '"';
		}, $text);
	}

	/**
	 * Convert array in string with html attributes
	 * 
	 * @param array 	$attributes
	 * @return string
	 */
	public static function array_to_attr($attributes)
	{
		return implode(
			' ',
			array_map(
				function($key) use ($attributes)
				{
					if($attributes[$key] === null)
					{
						return '';
					}

					if(is_bool($attributes[$key]))
					{
						return ($attributes[$key]) ? $key : '';
					}

					return $key . '="' . $attributes[$key] . '"';
				},
				array_keys($attributes)
			)
		);
	}

	
	/**
	 * Events can produce unprecise sql queries because of other extensions,
	 * this function is used to clear the queries before use it.
	 * 
	 * @param array 	$sql_ary 		Array with query elements
	 * @return array 					Filtered query elements
	 */
	public static function filter_db_query($sql_ary)
	{
		// Filter duplicate SELECT
		if(isset($sql_ary['SELECT']))
		{
			$select_keys = array_map('trim', explode(',', $sql_ary['SELECT']));
			$select_keys = array_unique($select_keys);

			$sql_ary['SELECT'] = implode(', ', $select_keys);
		}

		// Filter duplicate LEFT JOIN
		if(isset($sql_ary['LEFT_JOIN']))
		{
			$left_join_keys = array();

			foreach($sql_ary['LEFT_JOIN'] as $i => $join)
			{
				$forum_key 		= array_keys($join['FROM'])[0];
				$forum_alias 	= array_values($join['FROM'])[0];

				if(!isset($left_join_keys[$forum_key]))
				{
					$left_join_keys[$forum_key] = array();
				}

				if(!in_array($forum_alias, $left_join_keys[$forum_key]))
				{
					$left_join_keys[$forum_key][] = $forum_alias;
					continue;
				}

				unset($sql_ary['LEFT_JOIN'][$i]);
			}
		}

		return $sql_ary;
	}

	/**
	 * Create directory
	 * 
	 * @param string 	$path 			Directory path
	 * @param bool 		$public_access 	Defines if the folder will be accessible from the browser
	 * 
	 * @return bool
	 */
	public static function mkdir($path, $public_access = false)
	{
		$htaccess_str = '<IfModule mod_access_compat.c>
			<Files *>
				Order Allow,Deny
				%1$s from All
			</Files>
		</IfModule>
		<IfModule mod_authz_host.c>
			<Files *>
				Require all %2$s
			</Files>
		</IfModule>';

		if(substr($path, -1) != '/')
		{
			$path .= '/';
		}

		if(!file_exists($path))
		{
			@mkdir($path);
		}

		try {
			$htaccess_str = vsprintf($htaccess_str, ($public_access) ? array('Allow', 'granted') : array('Deny', 'denied'));
			$htaccess_str = str_replace("\n\t\t", "\n", $htaccess_str);

			file_put_contents($path . '.htaccess', $htaccess_str);
			file_put_contents($path . 'index.htm', '');
		}
		catch(\Exception $e) {
			return false;
		}

		return true;
	}
}
