<?php
/*
* @package Ext Common Core
* @version v1.0.15 28/03/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\core;

class tools
{
	/**
	 * html_truncate
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

	// Set Full URL to smilies
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
