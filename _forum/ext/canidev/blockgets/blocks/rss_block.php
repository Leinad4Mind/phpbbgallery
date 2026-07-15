<?php
/**
 * @package cBB Blockgets
 * @version 2.0.6 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

use canidev\blockgets\libraries\constants;

class rss_block extends base
{
	static $icon = 'fa-rss';

	private $default_rss_data = [
		'encoding'	=> 'UTF-8',
		'language'	=> '',
		'type'		=> '',
	];

	private $cache;

	private $rss_data;
	private $rss_type;
	private $rss_ttl 	= 86400;
	private $plain_text	= '';
	
	private $tags = [
		'rss'	=> ['name'	=> 'channel', 	'tags'	=> 'item|image'],
		'feed'	=> ['name'	=> 'feed', 		'tags'	=> 'entry'],
	];

	/**
	 * {@inheritDoc}
	 */
	public function init($method = '')
	{
		$this->tpl_name = 'rss_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		if(empty($data['list']))
		{
			return false;
		}
		
		if($method == 'load')
		{
			$limit			= $data['limit'];
			$ignore_lang 	= $data['ignore_lang'];
			
			// Force vertical direction
			if($data['collapsable'])
			{
				$data['direction'] = constants::SCROLL_V;
			}
			
			$this->template->assign_vars([
				'S_RSS_COLLAPSE'	=> (int)$data['collapsable'],
				'S_BLOCK_HEIGHT'	=> $data['height'],
				'S_SCROLL_V'		=> ($data['direction'] == constants::SCROLL_V),
				'S_SCROLL_H'		=> ($data['direction'] == constants::SCROLL_H),
			]);

			// Delete the array in the template if exists, prevent errors between blocks
			$this->template->destroy_block_vars('rss');
			
			$this->rss_ttl	= (int)$data['ttl'];
			$this->cache	= $this->container->get('cache.driver');

			foreach($data['list'] as $source)
			{
				$this->read($source['url']);

				switch($this->rss_type)
				{
					case 'rss':
						if(!$ignore_lang && $this->user->lang_name != $this->get(false, 'language'))
						{
							break;
						}
				
						$this->template->assign_block_vars('rss', [
							'S_TITLE'	=> $this->get(false, 'title'),
						]);
				
						$entries	= $this->get('item');
						$limit		= min($limit, count($entries));
						
						for($i = 0; $i < $limit; $i++)
						{
							$this->template->assign_block_vars('rss.item', [
								'S_TITLE'		=> $this->get($i, 'title', $entries),
								'S_DESCRIPTION'	=> $this->_clear($this->get($i, 'description', $entries), $data),
								'U_LINK'		=> $this->get($i, 'link', $entries),
							]);
						}
					break;
					
					case 'feed':
						if(!$ignore_lang && $this->user->lang_name != $this->rss_data['language'])
						{
							break;
						}
				
						$this->template->assign_block_vars('rss', [
							'S_TITLE'	=> $this->get(false, 'title'),
						]);
				
						$entries	= $this->get('entry');
						$limit		= min($limit, count($entries));
						
						for($i = 0; $i < $limit; $i++)
						{
							$this->template->assign_block_vars('rss.item', [
								'S_TITLE'		=> $this->get($i, 'title', $entries),
								'S_DESCRIPTION'	=> $this->_clear($this->get($i, 'content', $entries), $data),
								'U_LINK'		=> $this->get($i, 'id', $entries),
							]);
						}
					break;	
				}
			}
		}

		$this->template->assign_json_var('S_OPTIONS', [
			'loadOnInit' 	=> true,
			'requestData' 	=> [
				'jblgm' => $this->data['block_id'],
				'm' 	=> 'load'
			]
		]);

		unset($data);
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$dir_options = [
			constants::SCROLL_H		=> 'LIST_SCROLL_H',
			constants::SCROLL_V		=> 'LIST_SCROLL_V',
		];

		$ttl_options = [
			3600	=> '1_HOUR',
			7200	=> '2_HOURS',
			21600	=> '6_HOURS',
			86400	=> '1_DAY',
			604800	=> '7_DAYS',
		];
		
		$this->display_vars = [
			'limit'			=> ['lang' => 'RSS_LIMIT',			'validate' => 'int',	'type' => 'number:1:999',		'default' => 5],
			'ignore_lang'	=> ['lang' => 'RSS_IGNORE_LANG',	'validate' => 'bool',	'type' => 'radio:yes_no',		'default' => 1],
			'direction'		=> ['lang' => 'RSS_DIRECTION',		'validate' => 'int', 	'type' => 'select',				'method' => 'helper',	'params' => ['make_select', $dir_options, false, '{CONFIG_VALUE}'],	'default' => constants::SCROLL_V],
			'collapsable'	=> ['lang' => 'RSS_COLLAPSABLE',	'validate' => 'bool',	'type' => 'radio:yes_no',		'default' => 1],
			'height'  		=> ['lang' => 'RSS_HEIGHT',			'validate' => 'int', 	'type' => 'number:0:999',		'default' => 150],
			'ttl'  			=> ['lang' => 'RSS_TTL',			'validate' => 'int', 	'type' => 'select',				'method' => 'helper',	'params' => ['make_select', $ttl_options, false, '{CONFIG_VALUE}'],	'default' => 86400],
		];
		
		$this->list = $this->container->get('canidev.blockgets.admin.links');
		
		$this->list
			->set_options([
				'title'	=> 'RSS_SOURCES',
				'type'	=> constants::LIST_TYPE_NONE,
			])
			->set_events([
				'edit.before'	=> [$this, 'list_edit_before'],
			]);

		return true;
	}
	
	/**
	 * Event for list
	 * @param \phpbb\event\data 	$event
	 */
	public function list_edit_before($event)
	{
		$event['display_vars'] = [
			'title'		=> ['lang' => 'RSS_TITLE',		'validate' => 'string:1:255',	'type' => 'text:40:255'],
			'url'		=> ['lang' => 'RSS_URL',		'validate' => 'url',			'type' => 'text:40:255'],
		];
	}
	
	/**
	 * Clear text
	 * 
	 * @param string 	$text 	Original text
	 * @param array 	$data 	Block data
	 * 
	 * @return string
	 * @access private
	 */
	private function _clear($text, $data)
	{
		if(($xpath = \canidev\core\dom::string_to_xpath($text)) === false)
		{
			return $text;
		}

		// Remove scripts
		foreach($xpath->query("//script") as $node)
		{
			$node->parentNode->removeChild($node);
		}

		// Remove unnecessary attributes
		foreach($xpath->query("//div|//a") as $node)
		{
			if($node->nodeName == 'a' && $node->getAttribute('href') == '#')
			{
				$node->parentNode->removeChild($node);
				continue;
			}

			$node = \canidev\core\dom::remove_attributes($node, ['class', 'href']);
		}

		// Convert objects and iframes to links
		foreach($xpath->query("//object|//iframe") as $node)
		{
			$attr 		= $node->getAttribute((($node->nodeName == 'object') ? 'data' : 'src'));
			$new_node 	= $xpath->document->createElement('a');
			
			$new_node->setAttribute('href', $attr);
			$new_node->nodeValue = $attr;
			
			$node->parentNode->replaceChild($new_node, $node);
		}

		// Delete line breaks and images and put all containers "inline"
		if($data['direction'] == constants::SCROLL_H)
		{
			foreach($xpath->query("//p|//div|//blockquote|//code|//pre") as $node)
			{
				$node->setAttribute('style', 'display:inline;');
			}

			foreach($xpath->query("//img") as $node)
			{
				$node->setAttribute('style', 'max-width:100px;');
			}

			foreach($xpath->query("//br|//hr") as $node)
			{
				$new_node = $xpath->document->createTextNode(' ');
				$node->parentNode->replaceChild($new_node, $node);
			}
		}

		return \canidev\core\dom::xpath_to_string($xpath);
	}
	
	/**
	 * Read Rss from url
	 * 
	 * @param string 	$url
	 * 
	 * @return bool
	 * @access private
	 */
	private function read($url)
	{
		if(!$url)
		{
			return false;
		}
		
		// Reset the values
		$this->rss_type = '';

		$file_id = '_rss_' . md5($url);
		
		if(($this->rss_data = $this->cache->get($file_id)) === false)
		{
			$this->rss_data = $this->default_rss_data;

			if(!$this->_read($url))
			{
				return false;
			}

			// Get RSS Encoding
			if(preg_match('#encoding=[\'\"]+([\w\d\-\_]+)[\'\"]+#', $this->plain_text, $out))
			{
				$this->rss_data['encoding'] = $out[1];
			}
			
			// Determine the rss type and language
			if(!preg_match('#<(rss|feed)+.*?(?:xml:lang\=\"([a-z\-]+)\")?[^>]*>#', $this->plain_text, $out))
			{
				return false;
			}
			
			switch($out[1])
			{
				case 'rss':
				case 'feed':
					$this->rss_type = $this->rss_data['type'] = $out[1];
					
					if(!empty($out[2]))
					{
						$this->rss_data['language'] = $out[2];
					}

					$this->_get();
				break;
				
				default:
					return false;
				break;	
			}
			
			$this->plain_text = '';
	
			$this->cache->put($file_id, $this->rss_data, $this->rss_ttl);
		}
		
		$this->rss_type = $this->rss_data['type'];
		
		return true;
	}
	
	/**
	 * Helper for read method
	 * 
	 * @param string 	$url
	 * 
	 * @return bool
	 * @access private
	 */
	private function _read($url)
	{
		$url = str_replace('&amp;', '&', $url);
		$user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0';
		
		$this->plain_text = '';

		if(function_exists('curl_init'))
		{
			$ch = curl_init($url);

			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

			$this->plain_text = curl_exec($ch);

			curl_close($ch);
		}
		else 
		{
			$context  = stream_context_create([
				'http' => ['user_agent' => $user_agent]
			]);
			
			if(($this->plain_text = @file_get_contents($url, false, $context)) === false)
			{
				if($f = @fopen($url, 'r'))
				{
					while(!feof($f))
					{
						$this->plain_text .= fgets($f, 4096);
					}
					fclose($f);
				}
			}
		}
		
		return (!$this->plain_text) ? false : true;
	}
	
	/**
	 * Get item from the rss part
	 * 
	 * @param mixed 		$id
	 * @param string 		$name
	 * @param array|false 	$ary
	 * 
	 * @return mixed
	 * @access private
	 */
	private function get($id, $name = '', $ary = false)
	{
		if($name)
		{
			if($id === false)
			{
				if(isset($this->rss_data[$this->tags[$this->rss_type]['name']]))
				{
					$ary = $this->rss_data[$this->tags[$this->rss_type]['name']];
					return (isset($ary[$name]) ? $ary[$name] : '');
				}
			}
			else if(is_array($ary) && isset($ary[$id][$name]))
			{
				return $ary[$id][$name];
			}

			return '';
		}

		if(isset($this->rss_data[$id]))
		{
			return $this->rss_data[$id];
		}
		
		return [];
	}
	
	/**
	 * Obtain RSS data
	 * @access private
	 */
	private function _get()
	{
		$channel_name	= $this->tags[$this->rss_type]['name'];

		if(!preg_match('#<(' . $channel_name . ').*?>(.*?)<\/\\1>#si', $this->plain_text, $out_channel))
		{
			return false;
		}
		
		$file_text = $out_channel[2];
		unset($out_channel);
		
		// The block don't use this tag and in some cases delete it take away a lot of work!
		$file_text = preg_replace('#<category.*?\/?>#', '', $file_text);

		// Get the item, textinput and image variables
		while(preg_match('#<(' . $this->tags[$this->rss_type]['tags'] . ').*?>(.*?)<\/\\1>#si', $file_text, $out))
		{
			if(!isset($this->rss_data[$out[1]]))
			{
				$this->rss_data[$out[1]] = [];
			}
			
			$this->rss_data[$out[1]][] = $this->_compose($out[2]);

			$file_text = str_replace($out[0], '', $file_text);
		}
		
		// And finally, get the channel variables
		$this->rss_data[$channel_name] = $this->_compose($file_text);
		
		unset($file_text);
	}

	/**
	 * Normalize text
	 * 
	 * @param string 	$text
	 * @return string
	 */
	private function adjust($text)
	{
		$text = str_replace(['<![CDATA[', ']]>'], '', $text);
		$text = trim(htmlspecialchars_decode($text));
		
		$text = preg_replace('#<img[^>]*src="([^"]*)"[^>]*/?>#', '<img src="\\1" alt="" />', $text);
		
		if($text && $this->rss_data['encoding'] != $this->default_rss_data['encoding'])
		{
			$text = mb_convert_encoding($text, $this->rss_data['encoding'], $this->default_rss_data['encoding']);
		}

		return $text;	
	}

	/**
	 * Compose and normalize text
	 * 
	 * @param string $text
	 * @return array
	 */
	private function _compose($text)
	{
		$ary = [];
		
		preg_match_all('#<([\w\:]+)[^>]*>(.*?)<\/\\1>#si', $text, $out, PREG_SET_ORDER);

		foreach($out as $r)
		{
			$ary[$r[1]] = $this->adjust($r[2]);
		}
		
		return $ary;
	}
}
