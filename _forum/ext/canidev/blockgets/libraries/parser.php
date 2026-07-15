<?php
/**
 * @package cBB Blockgets
 * @version 2.0.6 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\libraries;

class parser
{
	private $bbcodes = [];

	/**
	 * Constructor
	 * @access public
	 */
	public function __construct()
	{
		$this->bbcodes = [
			'html' => [
				'match'		=> '#\[html\](.*?)\[/html\]#s',
				'replace'	=> function($matches) {
					return htmlspecialchars_decode(
						str_replace(['<br/>', '<br>', "\n"], '', $matches[1]),
						ENT_COMPAT
					);
				},
			],
		];
	}
	
	/**
	 * Parse bbcodes in text
	 * 
	 * @param string 	$message 	Original text
	 * @return string
	 */
	public function parse_bbcode($message)
	{
		foreach($this->bbcodes as $bbcode => $row)
		{
			if(strpos($message, "[$bbcode") === false)
			{
				continue;
			}

			if(isset($row[0]) || is_string($row))
			{
				$match		= ['[' . $bbcode . ']', '[/' . $bbcode . ']'];
				$replace	= isset($row[0]) ? [$row[0], $row[1]] : ['<' . $row . '>', '</' . $row . '>'];
				
				$message = str_replace($match, $replace, $message);
			}
			else if(isset($row['match']))
			{
				if($row['replace'] instanceof \Closure)
				{
					$message = preg_replace_callback($row['match'], $row['replace'], $message);
				}
				else
				{
					$message = preg_replace($row['match'], $row['replace'], $message);
				}
			}
		}
		
		return $message;
	}
}
