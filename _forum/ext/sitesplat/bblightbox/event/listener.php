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
			'core.viewtopic_post_rowset_data'	=> 'set_bblightbox',
			'core.posting_modify_template_vars'	=> 'set_bblightbox',
			'core.ucp_pm_view_messsage'			=> 'set_bblightbox',
			'core.parse_attachments_modify_template_data'			=> 'set_bblightbox'
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
		
		$this->settings = json_decode($this->config['bblightbox'], true);
	}

	public function set_bblightbox()
	{
		$pagename = (str_replace('.' . $this->php_ex, '', $this->user->page['page_name']));
		$this->template->assign_vars(array(
			'BBLIGHTBOX_PLUGIN'			=> ($this->match($pagename)) ? (($this->settings['plugin'] != '------') ? $this->settings['plugin'] : false) : false,
			'BBLIGHTBOX_BBCODE_ALLOW'	=> $this->settings['bbcode_allow'],
			'BBLIGHTBOX_CAPTIONS'		=> $this->settings['captions'],
			'BBLIGHTBOX_ANIMATION'		=> $this->settings['animationeffect'],
			'BBLIGHTBOX_SLIDE'			=> $this->settings['slide'],
	
	        'FANCYBOX_JS'				=> $this->ext_path . 'styles/FLATBOOTS/template/fancybox/jquery.fancybox.min.js',
			'CHOCOLAT_JS'			    => $this->ext_path . 'styles/FLATBOOTS/template/Chocolat/js/jquery.chocolat.min.js',
			'FANCYBOX_PROTECT'			=> $this->settings['protect'],

			'CHOCOLAT_ENABLEZOOM'		=> $this->settings['enablezoom'],
			'QUOTED_IMAGES'				=> $this->settings['qimages'],
			'RESIZE_IMAGES'				=> $this->settings['resize'],
			
			'BBLIGHTBOX_COLUMN_LAYOUT'	=> $this->settings['collums'],
		));
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
