<?php
/*
* @package cBB Blockgets
* @version v2.0.3 26/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\controller;

use Symfony\Component\HttpFoundation\Response;

/**
* Main controller
*/
class player_controller implements main_interface
{
	protected $container;
	protected $db;
	protected $helper;
	protected $lang;
	protected $request;
	protected $template;

	/**
	* Constructor
	*
	* @param ContainerInterface 					$container		Service container interface
	* @param \phpbb\db\driver\driver_interface		$db				DB Object
	* @param \canidev\blockgets\libraries\helper	$helper			Blockgets helper Object
	* @param \phpbb\language\language				$language		Language Object
	* @param \phpbb\request\request 				$request		Request object
	*
	* @access public
	*/
	public function __construct(
		\Symfony\Component\DependencyInjection\ContainerInterface $container,
		\phpbb\db\driver\driver_interface $db,
		\canidev\blockgets\libraries\helper $helper,
		\phpbb\language\language $language,
		\phpbb\request\request $request)
	{
		$this->container 	= $container;
		$this->db			= $db;
		$this->helper 		= $helper;
		$this->lang			= $language;
		$this->request		= $request;
		$this->template		= \canidev\core\template::get_instance($container);
	}

	/**
	* Display
	* @access public
	*/
	public function display()
	{
		$block_id = $this->request->variable('id', 0);

		$sql = 'SELECT block_content
			FROM ' . BLG_BLOCK_TABLE . "
			WHERE block_id = $block_id";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		
		if(!$row ||($data = unserialize($row['block_content'])) === false)
		{
			trigger_error('NO_TRACKLIST');
		}
		
		$data['autoplay'] = $this->request->variable('autoplay', $data['autoplay']);
		
		$this->create($data, $block_id, true);
		
		$this->template->assign_var('S_IN_PLAYER', true);
		
		page_header($this->lang->lang('PLAYER'));

		$this->template->set_filenames(array(
			'body'	=> '@canidev_blockgets/blocks/player_block.html',
		));

		page_footer(true, false, false);

		$headers = !empty($this->user->data['is_bot']) ? array('X-PHPBB-IS-BOT' => 'yes') : array();

		return new Response($this->template->assign_display('body'), 200, $headers);
	}
	
	public function create($data, $block_id, $in_window = false)
	{
		$this->template->assign_var('S_IN_WINDOW', $in_window);

		$this->template->assign_json_var('PLAYER_OPTIONS', array(
			'autoplay'		=> ($data['autoplay']) ? true : false,
			'playlist'		=> $data['playlist'],
			'in_window'		=> $in_window,
			'player_url'	=> (!$in_window) ? $this->helper->route('canidev_blockgets_player_controller', array('id' => $block_id), false) : '',
		));
		
		if($in_window)
		{
			$this->template->assign_var('BLOCK_ID', $block_id);
		}
		
		$this->template->destroy_block_vars('track');

		if(!empty($data['list']))
		{
			$this->filter = array('mp3', 'wav');
			
			$track_ary = array();

			foreach($data['list'] as $track)
			{
				// if is a playlists, load the tracks
				if(($tracklist = $this->load_playlist($track['url'])) !== false)
				{
					$track_ary = array_merge($track_ary, $tracklist);
				}
				else 
				{
					$track_ary[] = $this->_parse_track($track['url'], $track['title']);
				}
			}
			
			foreach($track_ary as $track)
			{
				if($this->is_valid($track))
				{
					$this->template->assign_block_vars('track', array(
						'S_TITLE'	=> $track['title'],
						'S_URL'		=> $track['url'],
					));
				}
			}
		}

		\canidev\core\lib::get_instance($this->container)->set_js_lang(array(
			'PLAY_MSG',
			'STOP_MSG',
			'VOLUME_MSG',
		));
	}
	
	private function load_playlist($filename)
	{
		$content	= '';
		$ext		= '';

		if(preg_match('#.*\.([a-zA-Z0-9]+)$#', $filename, $match))
		{
			$ext = $match[1];
		}

		if(!method_exists($this, "_read_$ext"))
		{
			return false;
		}

		if(!($content = @file_get_contents($filename)))
		{
			return false;
		}

		// Remove BOM from file
		$bom = pack('CCC', 0xEF, 0xBB, 0xBF);

		if(substr($content, 0, 3) === $bom)
		{
			$content = substr($content, 3);
		}
		
		if(!mb_detect_encoding($content, 'UTF-8', true))
		{
			$content = utf8_encode($content);
		}

		// Build Track List
		$tracklist	= $this->{"_read_$ext"}($content);
		$base_url	= substr($filename, 0, strrpos($filename, '/') + 1);

		foreach($tracklist as $id => $track)
		{
			if(strpos($track['url'], 'http') === false && substr($track['url'], 0, 2) != '//')
			{
				$tracklist[$id]['url'] = $base_url . $track['url'];
			}
		}
		
		return $tracklist;
	}
	
	private function is_valid($track)
	{
		if($this->filter !== false)
		{
			if(!is_array($this->filter))
			{
				$this->filter = array($this->filter);
			}

			if($track['ext'] && !in_array($track['ext'], $this->filter))
			{
				return false;
			}
		}
		
		return true;
	}
	
	private function _read_asx($content)
	{
		$track_ary = array();

		preg_match_all('#<entry><ref href\s?=\s?"(.*?)"\s?/></entry>#i', $content, $matches);
		
		foreach($matches[0] as $id => $null)
		{
			if(($track = $this->_parse_track($matches[1][$id])) !== false)
			{
				$track_ary[] = $track;
			}
		}
		
		return $track_ary;
	}
	
	private function _read_m3u($content)
	{
		$regexp = "/(.*)[\r\n]*/i";
		$has_ext = false;
		
		$track_ary = array();

		if(strpos($content, '#EXTM3U') !== false)
		{
			$content = trim(str_replace('#EXTM3U', '', $content));
			$regexp = "/#EXTINF:[\-0-9]+,([^\r\n]+)[\r\n]*(.*)[\r\n]*/i";
			$has_ext = true;
		}
		
		preg_match_all($regexp, $content, $matches);

		foreach($matches[0] as $id => $null)
		{
			$title = $url = '';
	
			if($has_ext)
			{
				$title	= $matches[1][$id];
				$url	= $matches[2][$id];
			}
			else
			{
				$url = $matches[1][$id];
			}
			
			if(($track = $this->_parse_track($url, $title)) !== false)
			{
				$track_ary[] = $track;
			}
		}
		
		return $track_ary;
	}
	
	private function _read_pls($content)
	{
		$track_ary = $ary = array();
		
		// Get all lines
		preg_match_all('#(file|title)+([0-9]+)=(.*)#i', $content, $matches);
		
		foreach($matches[0] as $id => $null)
		{
			$i		= (int)$matches[2][$id];
			$type	= strtolower($matches[1][$id]);

			if(!is_array($ary[$i]))
			{
				$ary[$i] = array();
			}

			$ary[$i][$type] = $matches[3][$id];
		}
		
		// Parse content to tracklist
		foreach($ary as $i => $data)
		{
			if(empty($data['file']))
			{
				continue;
			}
			
			$title = (isset($data['title']) ? $data['title'] : '');

			if(($track = $this->_parse_track($data['file'], $title)) !== false)
			{
				$track_ary[] = $track;
			}
		}
		
		return $track_ary;
	}
	
	private function _parse_track($url, $title = '')
	{
		$ext = '';
		$url = trim(str_replace('\\', '/', $url));

		if(preg_match('#(.*?)\.([a-z0-9]+)$#i', $url, $match))
		{
			if(!$title)
			{
				$title = $match[1];
			}

			$ext = $match[2];
		}
		
		if($title && $url)
		{
			// Streaming URLs need final /; to run correctly
			if(preg_match('/^http[s]?:\/\/[^:]+:([0-9]{4,})$/', $url))
			{
				$url .= '/;';
			}

			return array(
				'title'		=> $title,
				'url'		=> $url,
				'ext'		=> $ext,
			);
		}
		
		return false;
	}
}
