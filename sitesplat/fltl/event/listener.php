<?php
/**
*
* Fancy Lazy Topics Loader
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\fltl\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	protected $db;
	protected $auth;
	protected $config;
	protected $user;
	protected $template;
	protected $phpbb_container;
	protected $phpbb_root_path;
	protected $php_ext;

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\user $user, \phpbb\template\template $template, Container $phpbb_container, $phpbb_root_path, $php_ext)
	{
		$this->db = $db;
		$this->auth = $auth;
		$this->config = $config;
		$this->user = $user;
		$this->template = $template;
		$this->phpbb_container = $phpbb_container;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'	=> 'load_language_on_setup',
			'core.page_header' 	=> 'fltl',
		);
	}

	public function fltl($event)
	{
		$display = $this->phpbb_container->get('sitesplat.fltl.main');
		$rows = $display->handle('index.html');

		foreach($rows['rows'] as $row)
		{
			strip_bbcode($row['post_text']);
			$row['post_text'] = censor_text($row['post_text']);
			$row['post_text'] = (utf8_strlen($row['post_text']) > 50) ? utf8_substr($row['post_text'], 0, 50) . '&#91;&hellip;&#93;' : $row['post_text'];
	
			$this->template->assign_block_vars('fltl', array(
				'U_TOPIC'			=> append_sid($this->root_path . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']),
				'U_LAST_POST'		=> append_sid($this->root_path . 'viewtopic.' . $this->php_ext, 'p=' . $row['topic_last_post_id']) . '#p' . $row['topic_last_post_id'],
				'TOPIC_AUTHOR'		=> ($row['topic_' . $this->config['fltl_type'] . '_poster_colour']) ? 
										('<strong style="color:#' . $row['topic_' . $this->config['fltl_type'] . '_poster_colour'] . '">' . $row['username'] . '</strong>') :
										$row['username'],
				'AVATAR'			=> ($row['user_avatar']) ? phpbb_get_user_avatar(
											array('avatar' => $row['user_avatar'], 
												  'avatar_type' => $row['user_avatar_type'],
												  'avatar_width' => $row['user_avatar_width'], 
												  'avatar_height' => $row['user_avatar_height'])): '',
				'TOPIC_MONTH'       => $this->user->format_date($row['topic_last_post_time'], 'M'),
				'TOPIC_DAY'         => $this->user->format_date($row['topic_last_post_time'], 'd'),
				'TOPIC_YEAR_DIGIT'  => $this->user->format_date($row['topic_last_post_time'], 'Y'),
				'TOPIC_MONTH_DIGIT' => $this->user->format_date($row['topic_last_post_time'], 'm'),
				'TOPIC_DAY_DIGIT'   => $this->user->format_date($row['topic_last_post_time'], 'd'),
				'TOPIC_TITLE'		=> censor_text($row['topic_title']),
				'FP_EXCERPT'		=> $row['post_text'],
			));
		}
		$this->template->assign_vars(array(
			'START'		=> $rows['start'],
		));
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext 		= $event['lang_set_ext'];
		$lang_set_ext[] 	= array(
			'ext_name' 		=> 'sitesplat/fltl',
			'lang_set' 		=> 'fltl_common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
}
