<?php
/*
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\libraries;

class parser
{
	private $bbcodes = array();

	/**
	* Constructor
	* @access public
	*/
	public function __construct()
	{
		$this->bbcodes = array(
			'html' => array(
				'match'		=> '#\[html\](.*?)\[/html\]#s',
				'replace'	=> function($matches) {
					return htmlspecialchars_decode(
						str_replace(array('<br/>', '<br>', "\n"), '', $matches[1]),
						ENT_COMPAT
					);
				},
			),
		);
	}
	
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
				$match		= array('[' . $bbcode . ']', '[/' . $bbcode . ']');
				$replace	= (isset($row[0]) ? array($row[0], $row[1]) : array('<' . $row . '>', '</' . $row . '>'));
				
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
