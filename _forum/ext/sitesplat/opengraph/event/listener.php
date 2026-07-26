<?php
/**
*
* BBopengraph
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\opengraph\event;

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
	protected $translator;

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
		$this->board_url = generate_board_url();

		if ($container->has('sitesplat.bbseo.translator')) {
			$this->translator = $container->get('sitesplat.bbseo.translator');
		}
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
			'core.index_modify_page_title'		=> 'opengraph',
			'core.viewtopic_modify_post_data'	=> 'opengraph',
			'core.classifieds_detail'			=> 'opengraph',
			'core.acp_board_config_edit_add'	=> 'add_config',
			'core.validate_config_variable'		=> 'file_excist',
		);
	}

	/**
	 * Add opengraph to the template
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function opengraph($event, $eventName)
	{
		// this is incompatible with phpBB 3.3!!!
//		$event_number = array_search($event->getName(), array_keys($this->getSubscribedEvents()));

		// this is compatible...
		$event_number = array_search($eventName, array_keys($this->getSubscribedEvents()));
		
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
		$picture = ($event_number == 2) ? $event['detail_data']['picture'] : ($event['attachments'] ? $this->find_picture($event['attachments']) : null);
		if ($picture && is_file($picture)) {
			$imageinfo = getimagesize($picture);
		} else {
			$imageinfo = ['width' => 0, 'height' => 0, 'mime' => ''];
		}

		if (!$event_number) {
			$og_url = "{$this->board_url}/index.php";
		}
		else if ($event_number == 2) {
			$og_url = "{$this->board_url}{$event['detail_data']['back_url']}";
		}
		else if (!empty($this->translator)) {
			$og_url = $this->translator->seo_url("{$this->board_url}/viewtopic.php", "f={$event['forum_id']}&t={$event['topic_id']}#p{$event['topic_data']['topic_first_post_id']}", false, '');
		}
		else {
			$og_url = "{$this->board_url}/viewtopic.php?f={$event['forum_id']}&t={$event['topic_id']}#p{$event['topic_data']['topic_first_post_id']}";
		}

		$this->template->assign_vars(array(
			'OPENGRAPH_ID'			=> $this->config['opengraph_fb_id'],
			'OPENGRAPH_APPID'		=> $this->config['opengraph_fb_app_id'],
			'OPENGRAPH_TT_ID'		=> $this->config['opengraph_tw_id'],
			'URL_BBOPENGRAPH_INDEX'	=> $board_url = generate_board_url() . '/',	
			'URL_OPENGRAPH'			=> $og_url,
			'TITLE_OPENGRAPH'		=> ((!$event_number) ? $this->config['sitename'] : (($event_number == 2) ? $event['detail_data']['title'] : $event['topic_data']['topic_title'])),
			'DESC_OPENGRAPH'		=> ((!$event_number) ? $this->config['site_desc'] : (($event_number == 2) ? $this->clean_up($event['detail_data']['text']) : $this->find_text($event))),

			'IMG_OPENGRAPH'			=> $picture,
			'IMGTYPE_OPENGRAPH'		=> (isset($imageinfo['mime']) ? $imageinfo['mime'] : ''),
			'IMGWIDTH_OPENGRAPH'	=> (isset($imageinfo[0]) ? $imageinfo[0] : ''),
			'IMGHEIGHT_OPENGRAPH'	=> (isset($imageinfo[1]) ? $imageinfo[1] : ''),

			'PRICE_OPENGRAPH'		=> ($event_number == 2) ? $event['detail_data']['price'] : '',
			'CURRENCY_OPENGRAPH'	=> ($event_number == 2) ? $event['detail_data']['currency'] : '',
			
			'TIME_OPENGRAPH'		=> ($event_number) ? date( 'c', $event['topic_data']['topic_time']) : '',
			'SECT_OPENGRAPH'		=> ($event_number) ? $event['topic_data']['forum_name'] : '',
			'POST_OPENGRAPH'		=> ($event_number) ? $event['topic_data']['topic_first_poster_name'] : '',
			'BBTAG_OPENGRAPH'		=> ($this->manager) ? $this->manager->get_tags((int) (isset($event['topic_data']['topic_first_post_id']) ? 
										$event['topic_data']['topic_first_post_id'] : 0)) : '',
			'OPENGRAPH_CLASSIFIEDS'	=> ($event_number == 2) ? true : false
		));
		
		$this->user->add_lang_ext('sitesplat/opengraph', 'bbopengraph');
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
		return $this->clean_up($text);
	}
	
	public function clean_up($text)
	{
		$text = censor_text($text);
		strip_bbcode($text);
		$text = str_replace(array("&quot;", "/", "\n", "\t", "\r"), ' ', $text);
		$text = str_replace("'", '`', $text);
		$text = preg_replace(array("|http(.*)jpg|isU", "@(http(s)?://)?(([a-z0-9.-]+)?[a-z0-9-]+(!?\.[a-z]{2,4}))@"), ' ', $text);
		$text = preg_replace("/[^A-ZА-ЯЁ.,-–?]+/ui", " ", $text);
		$text = preg_replace("/\[(.*)?\](.*)?\[(.*)?\]/", ' ', $text);
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
		}
		else
		{
			$image=$this->find_images($event);
			if (preg_match('/(https?:\/\/[a-zA-Z0-9.\/_%]+png|%[0-9]+)/', $image)){
				$image=str_replace("%", "", $image);
				if(is_numeric($image)){
					return 'https://goldtuganime.com/forum/gallery/image/' . $image . '/source';
					
				}
				else {
					return $image;
				}
			}
			else {
				return $this->board_url . (($this->config['opengraph_imagepath']) ? '/' . $this->config['opengraph_imagepath'] : $image);
			}
			
		}

		$url = $this->board_url . (($this->config['opengraph_imagepath'] && !$attach_id) ? '/' . $this->config['opengraph_imagepath'] : 
				((!$attach_id) ? '' : '/download/file.php?id=' . $attach_id));
				
		return ($this->board_url == $url) ? '' : $url;
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
			$this->user->add_lang_ext('sitesplat/opengraph', 'info_acp_opengraph');
			$display_vars = $event['display_vars'];
			/* We add a new legend, but we need to search for the last legend instead of hard-coding */
			$submit_key = array_search('ACP_SUBMIT_CHANGES', $display_vars['vars']);
			$submit_legend_number = substr($submit_key, 6);
			$display_vars['vars']['legend'.$submit_legend_number] = 'OPENGRAPH_TITLE';
			$new_vars = array(
				'opengraph_fb_id'	=> array('lang' => 'OPENGRAPH_FB_ID', 'validate' => 'string', 'type' => 'text:0:200', 'explain' => true),
				'opengraph_fb_app_id'	=> array('lang' => 'OPENGRAPH_FB_APPID', 'validate' => 'string', 'type' => 'text:0:200', 'explain' => true),
				'opengraph_tw_id'	=> array('lang' => 'OPENGRAPH_TW_ID', 'validate' => 'string', 'type' => 'text:0:200', 'explain' => true),
				'opengraph_imagepath'	=> array('lang' => 'OPENGRAPH_IMAGE', 'validate' => 'file_excist', 'type' => 'text:0:200', 'explain' => true),
				'legend'.($submit_legend_number + 1) => 'ACP_SUBMIT_CHANGES',
			);
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $new_vars, array('after' => $submit_key));
			$event['display_vars'] = $display_vars;
		}
	}

	public function file_excist($event)
	{
		if (($event['config_definition']['validate'] ?? '') !== 'file_excist')
		{
			return;
		}

		$path = (string) ($event['cfg_array']['opengraph_imagepath'] ?? '');
		if ($path === '')
		{
			return;
		}

		$error = $event['error'] ?? [];
		$path = $this->root_path . $path;
		if (!file_exists($path))
		{
			$error[] = $this->user->lang('DIRECTORY_DOES_NOT_EXIST', $path);
		}
		$event['error'] = $error;
	}
}
