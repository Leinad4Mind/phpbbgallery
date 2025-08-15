<?php
/**
*
* @package BBfront
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbfront\controller;

use Symfony\Component\DependencyInjection\Container;

class main
{
	protected $config;
	protected $db;
	protected $request;
	protected $helper;
	protected $template;
	protected $user;
	protected $phpbb_dispatcher;
	protected $phpbb_container;
	protected $phpbb_root_path;
	protected $php_ext;
	protected $config_text;

	/**
	* Constructor
	*
	*/
	public function __construct(\phpbb\config\config $config,  \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user, \phpbb\event\dispatcher $phpbb_dispatcher, Container $phpbb_container, $phpbb_root_path, $php_ext)
	{
		$this->config = $config;
		$this->db = $db;
		$this->request = $request;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->phpbb_dispatcher = $phpbb_dispatcher;
		$this->phpbb_container = $phpbb_container;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->config_text = $phpbb_container->get('config_text');
	}

	/**
	* @param string		$name
	*/
	public function handle($name)
	{
		$forum_ary = json_decode($this->config['bbfront_inc_forums'], true);
		$config_aray = json_decode($this->config['bbfront_settings'], true);

		if ($this->request->variable('action', '') == 'change-status')
		{
			$this->change_status($this->request->variable('id', 0));
			exit();
		}

		$bbtags_enabled = $this->phpbb_container->get('ext.manager')->is_enabled('sitesplat/bbtags');
		if ($bbtags_enabled)
		{
			$this->table_bbtags = $this->phpbb_container->getParameter('sitesplat.bbtags.tables.bbtags');
			$this->table_bbtags_topic = $this->phpbb_container->getParameter('sitesplat.bbtags.tables.bbtags_topic');
			$url = generate_board_url();
		}
		
		$likes_enabled = $this->phpbb_container->get('ext.manager')->is_enabled('sitesplat/likedd');
		if ($likes_enabled)
		{
			$this->phpbb_container->get('sitesplat.likedd.listener')->assign_buttons();
		}
		
		if (sizeof($forum_ary))
		{
			$start = $this->request->variable('fstart', 0);
			$sql = 'SELECT COUNT(bbfront) AS total FROM ' . POSTS_TABLE . ' WHERE bbfront = 1';
			$result = $this->db->sql_query($sql);	
			$total = $this->db->sql_fetchfield('total');
			
			$sql = 'SELECT p.post_id, p.forum_id, p.topic_id, p.post_time, p.post_subject, p.post_text, p.bbcode_uid, p.bbcode_bitfield, t.topic_posts_approved, t.topic_status, t.topic_type, 
					p.post_attachment, p.poster_id, u.username, u.user_colour, user_id, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height  
					FROM ' . POSTS_TABLE .' p
					LEFT JOIN ' . TOPICS_TABLE . ' t ON t.topic_id = p.topic_id
					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = p.poster_id
					WHERE p.forum_id IN (' . implode(',', $forum_ary) . ') AND p.bbfront = 1 ORDER BY p.post_time DESC';
			$result = $this->db->sql_query_limit($sql, $config_aray['per_page'], $start);
			while ($row = $this->db->sql_fetchrow($result)) 
			{				
				if ($likes_enabled)
				{
					$poster_id = $row['poster_id'];
					$topic_data['topic_status'] = $row['topic_status'];
					$topic_data['topic_type'] = $row['topic_type'];
					$post_row['POST_ID'] = $row['post_id'];
					$post_row['MESSAGE'] = $row['post_text'];
					
					/**
					* Event to apply extra data				*
					* @event core.bbfront_before_display
					* @var	int		poster_id						The poster id from this post
					* @var	array	topic_data						All the topicdata for likes
					* @var	array	post_row						All the postedata for likes
					* @since 3.1.2
					*/
					$vars = array(
						'poster_id',
						'topic_data',
						'post_row',
					);
					extract($this->phpbb_dispatcher->trigger_event('core.bbfront_before_display', compact($vars)));
				}
				
				$tag_ary = array();
				if ($bbtags_enabled)
				{
					$sql = 'SELECT tag.tag, tag.route FROM ' . $this->table_bbtags_topic . ' t 
							LEFT JOIN ' . $this->table_bbtags . ' tag ON tag.id = t.tag_id
							WHERE t.topic_id = ' . $row['topic_id'];
					$result1 = $this->db->sql_query($sql);
					while ($row1 = $this->db->sql_fetchrow($result1)) 
					{
						$tag_ary[] = $row1;
					}
				}
				
				$attach_id = 0;
				if ($row['post_attachment'])
				{
					$sql = 'SELECT attach_id, mimetype FROM ' . ATTACHMENTS_TABLE . ' WHERE post_msg_id = ' . $row['post_id'];
					$result1 = $this->db->sql_query($sql);
					while ($row1 = $this->db->sql_fetchrow($result1)) 
					{
						if (strpos($row1['mimetype'], 'image') !== false)
						{
							$attach_id = $row1['attach_id'];
							preg_match('/\[attachment(.*?)](.*?)\[\/attachment\]/msi', $row['post_text'], $attachment);
							$row['post_text'] = (isset($attachment[0])) ? str_replace($attachment[0], '', $row['post_text']) : $row['post_text'];
							preg_match('/\<ATTACHMENT(.*?)>(.*?)\<\/ATTACHMENT\>/msi', $row['post_text'], $attachment);
							$row['post_text'] = (isset($attachment[0])) ? str_replace($attachment[0], '', $row['post_text']) : $row['post_text'];
						}
					}
				}

				preg_match('/\[quote(.*?)](.*?)\[\/quote(.*?)\]/msi', $row['post_text'], $quote);
				$row['post_text'] = (isset($quote[2])) ? $quote[2] : $row['post_text'];
				$row['post_text'] = htmlspecialchars_decode($row['post_text']);

				$attributes = (!isset($quote[2])) ? $this->matchUrl($row['post_text']) : null;
				
				$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
				$this->template->assign_block_vars('masonry', array(
					'URL'		=> append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext . '?f=' . $row['forum_id'] . '&t=' . $row['topic_id'] . '#p' . $row['post_id']),
					'TITLE'		=> $row['post_subject'],
					'TEXT'		=> truncate_string(strip_tags(generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true)), $config_aray['chars'], $config_aray['chars'], true, " ..."),
					'QUOTE'		=> (isset($quote[2])) ? true: false,
					'PICTURE'	=> (!$attach_id) ? '' : generate_board_url() . '/download/file.php?id=' . $attach_id,
					'EMBED'		=> ($attributes['embed']) ? $attributes['embed'] : '',
					'VIDEO'		=> ($attributes['attributes']['id']) ? htmlspecialchars($attributes['attributes']['id'], 2) : '',
					'AUTHOR'	=> get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour']),
					'USER_QUOTE'=> get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour']),
					'AVATAR'	=> ($config_aray['use_avatar']) ? phpbb_get_user_avatar(array('avatar' => $row['user_avatar'],
										  'user_id'         => $row['user_id'],
										  'avatar_type'		=> $row['user_avatar_type'], 
										  'avatar_width'	=> $row['user_avatar_width'], 
										  'avatar_height'	=> $row['user_avatar_height'])) : '',
					'DATE'		=> $this->user->format_date($row['post_time'], 'Y-m-d\TH:i:s'),
					'DATE_OUT'	=> $this->user->format_date($row['post_time'], 'F j, Y, g:i a'),
					'REPLIES'	=> $this->user->lang('REPLIES_ARY', ($row['topic_posts_approved']) ? $row['topic_posts_approved'] -1 : 0),
				//	'POST_ID'	=> ($likes_enabled) ? $post_row['POST_ID'] : 0,				
				));
				
				
			}
			$this->template->assign_vars(array(
				'BBBFRONT_START' => (!$start) ? true : false, 
				'BBBFRONT_NEXT' => ($start + $config_aray['per_page'] >= $total) ? 0 : $start + $config_aray['per_page']));
		}

		return $this->helper->render('bbfront.html', $name);
	}

	protected function matchUrl($url)
	{
		if (!$this->phpbb_container->get('ext.manager')->is_enabled('sitesplat/bbembed'))
		{
			return false;	
		}
		
		$regexps = array(
			'twitter' => array(
				"@twitter\\.com/(?:#!/)?\\w+/status(?:es)?/(?<id>\\d+)@",
			),
			'vimeo' => array(
				'!vimeo\\.com/(?:channels/[^/]+/|video/)?(?<id>\\d+)!',
			),
		);

		foreach ($regexps as $embed => $siteRegexps)
		{
			$attributes = array();
			foreach ($siteRegexps as $regexp)
			{
				$attributes += $this->extractAttributes($url, $regexp);
			}
			if (!empty($attributes))
			{
				(isset($attributes['channel'])) ? $attributes['id'] = $attributes['channel'] : null;
				return array('embed' => $embed, 'attributes' => $attributes);
			}
		}

		return false;
	}


	protected function extractAttributes($url, $regexp)
	{
		$attributes = array();
		if (preg_match($regexp, $url, $m))
		{
			foreach ($m as $k => $v)
			{
				if (!is_numeric($k) && $v !== '')
				{
					$attributes[$k] = $v;
				}
			}
		}

		return $attributes;
	}

	/**
	 * {@inheritdoc}
	 */
}
