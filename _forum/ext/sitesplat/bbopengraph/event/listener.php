<?php
/**
*
* BBopengraph
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbopengraph\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	protected $db;
	protected $request;
	protected $template;
	protected $user;
	protected $config;
	protected $container;
	protected $root_path;
	protected $php_ext;

	/**
	 * Constructor
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\config\config $config, Container $container, $root_path, $php_ext)
	{
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->container = $container;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->manager = false;
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
			'core.user_setup'				    => 'add_lang',
			'core.index_modify_page_title'		=> 'bbopengraph',
			'core.viewtopic_modify_post_data'	=> 'bbopengraph',
			'core.acp_board_config_edit_add'	=> 'add_config',
			'core.validate_config_variable'		=> 'file_excist',
		);
	}

	/**
	 * Add bbopengraph to the template
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function bbopengraph($event)
	{
		$event_number = array_search($event->getName(), array_keys($this->getSubscribedEvents()));
		
		$ext_manager = $this->container->get('ext.manager');
		if ($ext_manager->is_enabled('sitesplat/bbtags'))
		{
			$this->manager = new \sitesplat\bbtags\tags\manager(
					$this->db,
					$this->config,
					$this->container->get('auth'),
					$this->container->getParameter('sitesplat.bbtags.tables.bbtags'),
					$this->container->getParameter('sitesplat.bbtags.tables.bbtags_topic')
				);
		}
		
		$this->template->assign_vars(array(
			'BBOPENGRAPH_ID'		=> $this->config['bbopengraph_fb_id'],
			'BBOPENGRAPH_APPID'		=> $this->config['bbopengraph_fb_app_id'],
			'BBOPENGRAPH_TT_ID'		=> $this->config['bbopengraph_tw_id'],
			'URL_BBOPENGRAPH_INDEX'	=> $board_url = generate_board_url() . '/',
			'URL_BBOPENGRAPH'		=> generate_board_url() . ((!$event_number) ? '/index.' . $this->php_ext : '/viewtopic.' . $this->php_ext . '?f=' . $event['forum_id'] . '&t=' . $event['topic_id'] . '#p' . $event['topic_data']['topic_first_post_id']),
			'TITLE_BBOPENGRAPH'		=> (!$event_number) ? $this->config['sitename'] : $event['topic_data']['topic_title'],
			'DESC_BBOPENGRAPH'		=> (!$event_number) ? $this->config['site_desc'] : $this->find_text($event),
			'IMG_BBOPENGRAPH'		=> $this->find_picture($event),
			
			'TIME_BBOPENGRAPH'		=> ($event_number) ? date( 'c', $event['topic_data']['topic_time']) : '',
			'SECT_BBOPENGRAPH'		=> ($event_number) ? $event['topic_data']['forum_name'] : '',
			'POST_BBOPENGRAPH'		=> ($event_number) ? $event['topic_data']['topic_first_poster_name'] : '',
			'BBTAG_BBOPENGRAPH'		=> ($this->manager) ? $this->manager->get_tags((int) (isset($event['topic_data']['topic_first_post_id']) ? $event['topic_data']['topic_first_post_id'] : 0)) : ''
		));
		
	}

	public function find_text($event)
	{
		if ($event['start'] > 0 )
		{
			$sql = 'SELECT post_text FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $event['topic_data']['topic_first_post_id'];
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$text = $row['post_text'];
		} else
		{
			$text = $event['rowset'][$event['topic_data']['topic_first_post_id']]['post_text'];
		}
		$text = censor_text($text);
		strip_bbcode($text);
		$text = str_replace(array("\n", "\t", "\r"), ' ', $text);
		$text = str_replace(array("&quot;"), '', $text);
		//$text = preg_replace(array("|http(.*)jpg|isU", "@(http(s?):)?(([a-z0-9.-]+)?([a-zA-Z0-9-])+(!?\.[a-z]{2,4}))@"), '', $text);
		$text = preg_replace("/\[(.*)?\](.*)?\[(.*)?\]/", '', $text);
		$text = preg_replace("/[^A-ZА-ЯЁ.,-–?]+/ui", ' ', $text);
		$text = preg_replace("/(\s?https?:\/\/[a-zA-Z0-9.\/_ ]+png\s?|\s?[0-9]+\s?(sinopse)?\s?)([\s\S]+)/ui", '$3', $text);
		
		if (strlen($text) > 200)
		{
			$text_ar = explode("\n", wordwrap($text, 200));
			$text = $text_ar[0] . '...';
		}
		
		return $text;
	}
	
	public function find_picture($event)
	{
		$attachments = $event['attachments'];
		$attach_id = 0;
		if (!empty($attachments))
		{
			foreach ($attachments as $key => $value)
			{
				foreach ($value as $key2 => $value2)
				{
					if (strpos($value2['mimetype'], 'image') === false)
					{
						unset($attachments[$key][$key2]);
					}
				}
				if (count($attachments[$key]) < 1)
				{
					unset($attachments[$key]);
				}
			}
	
			if (sizeof($attachments))
			{
				$min_post = min(array_keys($attachments));
				$min_image = min(array_keys($attachments[$min_post]));
				$attach_id = $attachments[$min_post][$min_image]['attach_id'];
			}
			
			return generate_board_url() . (($this->config['bbopengraph_imagepath'] && !$attach_id) ? '/' . $this->config['bbopengraph_imagepath'] : '/download/file.php?id=' . $attach_id);
		}
		else {
			$image=$this->find_images($event);
			if (preg_match('/(https?:\/\/[a-zA-Z0-9.\/_%]+png|%[0-9]+)/', $image)){
				if(is_numeric($image)){
					return '//goldtuganime.com/forum/gallery/image/' . $image . '/source';
					
				}
				else {
					return $image;
				}
			}
			else {
				return generate_board_url() . (($this->config['bbopengraph_imagepath']) ? '/' . $this->config['bbopengraph_imagepath'] : $image);
			}
			
		}
		
	}
	
	public function find_images($event)
	{
		if ($event['start'] > 0 )
		{
			$sql = 'SELECT post_text FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $event['topic_data']['topic_first_post_id'];
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$image = $row['post_text'];
		} else
		{
			$image = $event['rowset'][$event['topic_data']['topic_first_post_id']]['post_text'];
		}
		$image = censor_text($image);
		strip_bbcode($image);
		$image = str_replace(array("\n", "\t", "\r"), ' ', $image);
		$image = str_replace(array("&quot;"), '', $image);
		$image = preg_replace("/\[(.*)?\](.*)?\[(.*)?\]/", '', $image);
		$image = preg_replace("/[^A-ZА-ЯЁ.,-–?]+/ui", ' ', $image);
		
		
		if (strlen($image) > 200)
		{
			$image_ar = explode("\n", wordwrap($image, 200));
			$image = $image_ar[0] . '...';
		}
		$image = str_replace(array(' '), '%', $image);
		$image = preg_replace("/%?(https?:\/\/[a-zA-Z0-9.\/_%]+png|%[0-9]+)[\s\S]+/", '$1', $image);

		return $image;
	}
	
	public function add_config($event)
	{
		if($event['mode'] == 'settings')
		{
			$this->user->add_lang_ext('sitesplat/bbopengraph', 'info_acp_bbopengraph');
			$display_vars = $event['display_vars'];
			/* We add a new legend, but we need to search for the last legend instead of hard-coding */
			$submit_key = array_search('ACP_SUBMIT_CHANGES', $display_vars['vars']);
			$submit_legend_number = substr($submit_key, 6);
			$display_vars['vars']['legend'.$submit_legend_number] = 'BBOPENGRAPH_TITLE';
			$new_vars = array(
				'bbopengraph_fb_id'	=> array('lang' => 'BBOPENGRAPH_FB_ID', 'validate' => 'string', 'type' => 'text:0:200', 'explain' => true),
				'bbopengraph_fb_app_id'	=> array('lang' => 'BBOPENGRAPH_FB_APPID', 'validate' => 'string', 'type' => 'text:0:200', 'explain' => true),
				'bbopengraph_tw_id'	=> array('lang' => 'BBOPENGRAPH_TW_ID', 'validate' => 'string', 'type' => 'text:0:200', 'explain' => true),
				'bbopengraph_imagepath'	=> array('lang' => 'BBOPENGRAPH_IMAGE', 'validate' => 'file_excist', 'type' => 'text:0:200', 'explain' => true),
				'legend'.($submit_legend_number + 1) => 'ACP_SUBMIT_CHANGES',
			);
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $new_vars, array('after' => $submit_key));
			$event['display_vars'] = $display_vars;
		}
	}

	public function file_excist($event) 
 	{ 
		$path = $event['cfg_array']['bbopengraph_imagepath'];
		if (($event['config_definition']['validate'] == 'file_excist') && ($path !== '')) 
		{ 
			$error = $event['error']; 
			$path = $this->root_path . $path;
			if (!file_exists($path))
			{ 
				$error[] = $this->user->lang('DIRECTORY_DOES_NOT_EXIST', $path); 
			} 
			$event['error'] = $error; 
		}
 	}
    public function add_lang($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/bbopengraph',
			'lang_set' => 'bbopengraph',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
}
