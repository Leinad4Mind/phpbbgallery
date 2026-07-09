<?php
/**
*
* BBlightbox
* @copyright (c) 2017 sitesplat.com All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bblightbox\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_post_rowset_data'				=> 'set_bblightbox',
			'core.posting_modify_template_vars'				=> [['set_bblightbox'], ['s_load_bblightbox']],
			'core.ucp_pm_view_messsage'						=> 'set_bblightbox',
			'core.viewtopic_modify_post_row'				=> 's_load_bblightbox_viewtopic',
			'core.modify_mcp_modules_display_option'		=> 's_load_bblightbox',
			'core.ucp_display_module_before'				=> 's_load_bblightbox_ucp',
			'core.text_formatter_s9e_configure_after' 		=> 'modify_img_template',
			'core.parse_attachments_modify_template_data'	=> 'set_bblightbox'
		);
	}

	protected $user;
	protected $template;
	protected $config;
	protected $ext_path;
	protected $phpEx;
	
	public function __construct(\phpbb\user $user,\phpbb\template\template $template, \phpbb\config\config $config, $ext_path, $phpEx)
	{
		$this->user = $user;
		$this->template = $template;
		$this->config = $config;
		$this->ext_path = $ext_path;
		$this->php_ex = $phpEx;
		
		$this->settings = json_decode(stripslashes($this->config['bblightbox']), true);
	}

	public function set_bblightbox()
	{
		$pagename = (str_replace('.' . $this->php_ex, '', $this->user->page['page_name']));

		$this->template->assign_vars(array(
	        'S_THUMB_ENABLED'		    => ($this->config['img_create_thumbnail']) ? true : false,
	    //  'FANCYBOX_JS'				=> $this->ext_path . 'styles/FLATBOOTS/template/fancybox/jquery.fancybox.min.js',
		//	'CHOCOLAT_JS'			    => $this->ext_path . 'styles/FLATBOOTS/template/Chocolat/js/jquery.chocolat.min.js',
			'FANCYBOX_JS'				=> generate_board_url() . '/' . $this->ext_path . 'styles/FLATBOOTS/template/fancybox/jquery.fancybox.min.js',
			'CHOCOLAT_JS'			    => generate_board_url() . '/' . $this->ext_path . 'styles/FLATBOOTS/template/Chocolat/js/jquery.chocolat.min.js',
		));

		if (!empty($this->settings)) {
			$this->template->assign_vars(array(
				'BBLIGHTBOX_PLUGIN'			=> ($this->match($pagename)) ? (($this->settings['plugin'] != '------') ? $this->settings['plugin'] : false) : false,
				'BBLIGHTBOX_BBCODE_ALLOW'	=> $this->settings['bbcode_allow'],
				'BBLIGHTBOX_CAPTIONS'		=> $this->settings['captions'],
				'BBLIGHTBOX_ANIMATION'		=> $this->settings['animationeffect'],
				'BBLIGHTBOX_SLIDE'			=> $this->settings['slide'],
				'FANCYBOX_PROTECT'			=> $this->settings['protect'],

				'CHOCOLAT_ENABLEZOOM'		=> $this->settings['enablezoom'],
				'QUOTED_IMAGES'				=> $this->settings['qimages'],
				'RESIZE_IMAGES'				=> $this->settings['resize'],
				
				'BBLIGHTBOX_COLUMN_LAYOUT'	=> $this->settings['collums'],
			));
		}
	}

	public function s_load_bblightbox_viewtopic($event)
	{
		if ($event['row']['post_attachment'] || preg_match('/<IMG/', $event['row']['post_text']))
		{
			$this->template->assign_var('S_LOAD_BBLIGHTBOX', true);
		}
	}
	public function s_load_bblightbox()
	{
		$this->template->assign_var('S_LOAD_BBLIGHTBOX', true);
	}
	public function s_load_bblightbox_ucp($event)
	{
		if (in_array($event['id'], array('ucp_pm', 'pm')))
		{
			$this->template->assign_var('S_LOAD_BBLIGHTBOX', true);
		}
	}

	/**
	* Modify image BBCode's template
	*
	* @param \phpbb\event\data $event The event object
	* @return void
	* @access public
	*/
	public function modify_img_template($event)
	{
		$tag   = $event['configurator']->tags['img'];
		$dom   = $tag->template->asDOM();
		$xpath = new \DOMXPath($dom);
		foreach ($xpath->query('//img[@src]') as $img)
		{
			$img->setAttribute('class', 'img-responsive img-post img-bbcodes');
		}
		$dom->saveChanges();
	}
	
	private function match($haystack, $needles = array('viewtopic', 'posting', 'mcp', 'ucp'))
	{
		foreach($needles as $needle)
		{
			if (strpos($haystack, $needle) !== false)
			{
				return true;
			}
		}
		return false;
	}
}
