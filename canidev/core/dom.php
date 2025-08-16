<?php
/*
* @package Ext Common Core
* @version v1.0.8 12/01/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\core;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class dom
{
	static $selfclosing_tags = 'img|br|hr|input|iframe';

	public static function load_xml($string)
	{
		$dom 	= new \DOMDocument('1.0', 'utf-8');

		$string = preg_replace('#(<(?:' . self::$selfclosing_tags . ')[^>]*)(?<!/)>#i', '$1/>', $string);
		$string = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $string);
		$flags 	= \LIBXML_NOCDATA | \LIBXML_NOWARNING | \LIBXML_NOERROR;

		if(LIBXML_VERSION >= 20700)
		{
			$flags |= \LIBXML_PARSEHUGE;
		}
	
		if(!$dom->loadXML('<div>' . $string . '</div>', $flags))
		{
			return false;
		}

		return $dom;
	}
	
	public static function string_to_xpath($string)
	{
		if(($dom = self::load_xml($string)) === false)
		{
			return false;
		}

		return new \DomXPath($dom);
	}

	public static function xpath_to_string($xpath)
	{
		return preg_replace(
			array(
				'#(^<div>|</div>$)#',
				'#<((' . self::$selfclosing_tags . ').*?)></\\2>#',
			),
			array(
				'',
				'<$1 />',
			),
			$xpath->document->saveXML($xpath->document->documentElement, \LIBXML_NOEMPTYTAG)
		);
	}

	public static function node_closest($node, $node_name)
	{
		if(!is_array($node_name))
		{
			$node_name = array($node_name);
		}

		if(in_array($node->nodeName, $node_name))
		{
			return true;
		}
		
		if($node->parentNode !== null)
		{
			return self::node_closest($node->parentNode, $node_name);
		}
		
		return false;
	}

	public static function remove_attributes($node, $ignore = false)
	{
		$ignore 	= ($ignore !== false && !is_array($ignore)) ? array($ignore) : $ignore;
		$attributes = $node->attributes;
		$attr_ary 	= array();
		
		foreach($node->attributes as $name => $attrNode)
		{
			if($ignore === false || !in_array($name, $ignore))
			{
				$attr_ary[] = $name;
			}
		}

		foreach($attr_ary as $name)
		{
		    $node->removeAttribute($name);
		}

		return $node;
	}
}
