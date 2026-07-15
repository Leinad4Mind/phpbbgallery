<?php
/*
* @name youtube_block.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class youtube_block extends base
{
	static $icon = 'blg-icon-youtube-play';

	private $api_url	= 'https://www.googleapis.com/youtube/v3/';
	
	public $regexp = array(
		'video'		=> '#^http[s]?:\/\/[a-z]+\.youtube.com\/watch\?[^v\=]?v\=([a-zA-Z0-9\-_]+).*$#',
		'channel'	=> '#^http[s]?:\/\/[a-z]+\.youtube.com\/(user|channel)\/([a-zA-Z0-9\-_]+).*$#',
	);

	public function init($method = '')
	{
		$this->tpl_name = 'youtube_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		if(empty($data['list']))
		{
			return false;
		}

		$this->data = array_merge($this->data, $data);
		
		if($method == 'load')
		{
			// Delete the array in the template if exists, prevent errors between blocks
			$this->template->destroy_block_vars('yt_video');

			list($v_width, $v_height) = explode('x', $data['video_size'], 2);

			$mode		= ($this->data['autofit'] && $data['display_mode'] == 'full') ? 'simple' : $data['display_mode'];
			$url_ary	= array();

			foreach($data['list'] as $row)
			{
				$url_ary[] = $row['url'];
			}
		
			$video_ary = $this->obtain_video_data($url_ary);
			
			if(!sizeof($video_ary))
			{
				return true;
			}

			if($data['random_display'])
			{
				$rand = mt_rand(0, (count($video_ary)-1));
				$video_ary = array($video_ary[$rand]);
			}
			
			foreach($video_ary as $i => $row)
			{
				$time = $date = '';
				
				if($row['contentDetails']['duration'])
				{
					$time	= new \DateInterval($row['contentDetails']['duration']);
					$format	= ($time->h) ? '%H:%I:%S' : '%I:%S';
					$time	= $time->format($format);
				}
				
				if($row['snippet']['publishedAt'])
				{
					$date	= new \DateTime($row['snippet']['publishedAt']);
					$date	= $this->helper->format_short_date($date->getTimestamp());
				}
				
				$yt_item = array(
					'S_DATE'			=> $date,
					'S_TITLE'			=> $row['snippet']['title'],
					'S_THUMBNAIL'		=> 'https://i.ytimg.com/vi/' . $row['id'] . '/default.jpg',
					'S_TIME'			=> $time,
					'S_VIEWS'			=> $this->lang->get('YT_VIEWS', $row['statistics']['viewCount']),
					'S_DESCRIPTION'		=> $this->helper->html_truncate($row['snippet']['description'], $data['text_limit'], '...'),
					'S_WIDTH'			=> $v_width,
					'S_HEIGHT'			=> $v_height,
					'S_HREF'			=> 'https://www.youtube.com/watch?v=' . $row['id'],
					'S_MOVIE'			=> 'https://www.youtube.com/embed/' . $row['id'] . (($i == 0 && $data['video_autoplay']) ? '?autoplay=1' : ''),
				);
				
				/**
				* @event block.youtube_row
				* @var array	yt_item		The output array
				* @var array	row			The original data
				* @since 2.0.0
				*/
				$vars = array('yt_item', 'row');
				extract($this->dispatcher->trigger_event('block.youtube_row', compact($vars)));
				
				$this->template->assign_block_vars('ytitem', $yt_item);
			}

			$this->template->assign_vars(array(
				'YT_MODE'	=> $mode,
			));
			
			return true;
		}
		
		$extra_params = array(
			'jblgm'		=> $this->data['block_id'],
			'm'			=> 'load'
		);

		$this->template->assign_vars(array(
			'S_EXTRA' => http_build_query($extra_params, '', '&'),
		));

		unset($data);
		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		if($mode == 'submit')
		{
			$this->container->get('cache.driver')->destroy('_blockgets_yt_' . $this->data['block_id']);
		}
	}

	public function get_config()
	{
		$display_modes = array(
			'full'		=> 'YT_FULL_PREVIEW',
			'simple'	=> 'YT_SIMPLE_PREVIEW',
			'video'		=> 'YT_VIDEO_PREVIEW',
			'list'		=> 'YT_LIST',
		);

		$sizes = array('230x129', '300x169', '425x239', '480x270', '560x315', '640x360', '720x405', '960x540');

		foreach($sizes as $id => $size)
		{
			$sizes[$size] = $size;
			unset($sizes[$id]);
		}

		$this->display_vars = array(
			'display_mode'		=> array('lang' => 'YT_DISPLAY_MODE',	'type' => 'select',		'method' => 'helper',	'params' => array('make_select', $display_modes, '{CONFIG_VALUE}'),	'default' => 'full'),
			'random_display'	=> array('lang' => 'YT_RANDOM_DISPLAY',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1),
			'video_autoplay'	=> array('lang' => 'YT_AUTOPLAY',		'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1),
			'result_limit'		=> array('lang' => 'YT_RESULT_LIMIT',	'validate' => 'int',	'type' => 'text:4:3',		'default' => 5),
			'text_limit'		=> array('lang' => 'YT_TEXT_LIMIT',		'type' => 'text:5:4',	'default' => 180),
			'video_size'		=> array('lang' => 'YT_VIDEO_SIZE',	 	'type' => 'select',		'method' => 'helper',	'params' => array('make_select', $sizes, '{CONFIG_VALUE}'),	'default' => '300x255'),
		);
		
		$this->list = $this->container->get('canidev.blockgets.admin.links');
		
		$this->list
			->set_type(LIST_TYPE_IMAGE)
			->set_events(array(
				'edit.before'	=> array($this, 'list_edit_before'),
				'edit.after'	=> array($this, 'list_edit_after'),
			));

		return true;
	}
	
	public function list_edit_before($event)
	{
		$event['display_vars'] = array(
			'title'			=> array('lang' => 'YT_VIDEO_TITLE',	'validate' => 'string:1:180',	'type' => 'text:40:180'),
			'url'			=> array('lang' => 'YT_VIDEO_URL',		'validate' => 'string:0:255',	'type' => 'text:40:255'),
		);
	}

	public function list_edit_after($event)
	{
		$row = $event['item_row'];
		
		// Set the correct image for the link
		if(preg_match($this->regexp['video'], $row['url'], $match))
		{
			$row['image'] = 'https://i.ytimg.com/vi/' . $match[1] . '/default.jpg';
		}
		else if(preg_match($this->regexp['channel'], $row['url'], $match))
		{
			$data = $this->get_channel_data($match[2], $match[1]);
			
			if(isset($data['snippet']['thumbnails']['default']))
			{
				$row['image'] = $data['snippet']['thumbnails']['default']['url'];
			}
		}
		else
		{
			$error = $event['error'];
			$error[] = $this->lang->get('URL_INVALID');
			$event['error'] = $error;
		}
		
		if(empty($row['image']))
		{
			$row['image'] = $this->helper->build_image_filename('./youtube-no-image.png');
		}
		
		$event['item_row'] = $row;
	}
	
	private function obtain_video_data($url_ary)
	{
		$cache		= $this->container->get('cache.driver');
		$cache_id	= '_blockgets_yt_' . $this->data['block_id'];

		if(($result = $cache->get($cache_id)) === false)
		{
			$result = array();
			
			foreach($url_ary as $url)
			{
				if(preg_match($this->regexp['video'], $url, $match)) // Is Simple video
				{
					$result[] = $match[1];
				}
				else if(preg_match($this->regexp['channel'], $url, $match)) // Is Channel
				{
					$channel_id = ($match[1] == 'user') ? $this->get_channel_by_user($match[2]) : $match[2];
					$result		= array_merge($result, $this->get_channel_videos($channel_id, 5));
				}
			}
			
			$result = $this->get_videos($result);
			
			$cache->put($cache_id, $result, 86400); // Cached the result 24 hours
		}

		return $result;
	}
	
	private function get_videos($video_ids)
	{
		$video_ids = (is_array($video_ids) ? $video_ids : array($video_ids));
		
		if(!sizeof($video_ids))
		{
			return array();
		}
		
		// For display only the video player we don't need to get the video data from youtube
		if($this->data['display_mode'] == 'video')
		{
			$result = array();
	
			foreach($video_ids as $video_id)
			{
				$result[] = array(
					'id'		=> $video_id,
					'snippet'	=> array(
						'publishedAt'	=> '',
						'title'			=> '',
						'description'	=> ''
					),
					'contentDetails'	=> array(
						'duration'		=> ''
					),
					'statistics'	=> array(
						'viewCount'	=> 0
					)
				);
			}

			return $result;
		}

		$params = array(
			'id'		=> implode(',', $video_ids),
			'part'		=> 'id,snippet,contentDetails,statistics',
			'fields'	=> 'items(id,snippet(publishedAt,title,description),contentDetails(duration),statistics(viewCount))',
		);
		
		$data = $this->get('videos', $params);

		return (isset($data['items']) ? $data['items'] : array());
	}
	
	private function get_channel_data($channel, $type)
	{
		$key = ($type == 'user') ? 'forUsername' : 'id';

		$params = array(
			$key			=> $channel,
			'part'			=> 'snippet',
			'maxResults'	=> 1
		);

		$data = $this->get('channels', $params);
		
		return (isset($data['items'][0]) ? $data['items'][0] : array());
	}
	
	private function get_channel_videos($channel_id, $limit)
	{
		if($channel_id === false)
		{
			return array();
		}

		$params = array(
			'channelId'		=> $channel_id,
			'part'			=> 'id',
			'order'			=> 'date',
			'maxResults'	=> $limit,
			'type'			=> 'video',
		);
		
		$data		= $this->get('search', $params);
		$video_ary	= array();
		
		foreach($data['items'] as $row)
		{
			$video_ary[] = $row['id']['videoId'];
		}

		return $video_ary;
	}
	
	private function get_channel_by_user($user)
	{
		$params = array(
			'forUsername'	=> $user,
			'part'			=> 'id',
			'fields'		=> 'items(id)'
		);
		
		$data = $this->get('channels', $params);

		return (isset($data['items'][0]) ? $data['items'][0]['id'] : false);
	}
	
	private function get($mode, $params)
	{
		$params['key'] = base64_decode(BLG_GOOGLE_KEY);
		
		$data	= '';
		$url	= $this->api_url . $mode . '?' . http_build_query($params, '', '&');

		if(function_exists('curl_init'))
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			$data = json_decode(curl_exec($curl), true);
			curl_close($curl);
		}
		else if($content = @file_get_contents($url))
		{
			$data = json_decode($content, true);
			unset($content);
		}
		
		return (is_array($data) ? $data : array());
	}
}
