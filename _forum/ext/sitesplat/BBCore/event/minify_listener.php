<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\event;

class minify_listener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface 
{
	protected $config;
	protected $is_email_template = false;

	public function __construct(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.modify_notification_template'				=> 'email_template',
//			'core.twig_environment_render_template_after'	=> 'minify_html',
		);
	}

	public function email_template($event)
	{
		$this->is_email_template = true;
		return;
	}

	public function minify_html($event)
	{
		// just in case cache isn't purged...
		return;

		if (!$this->config['sitesplat_bbcore_minify_html'] || $this->is_email_template)
		{
			return;
		}

		$parser = \WyriHaximus\HtmlCompress\Factory::construct();
		$event['output'] = $parser->compress($event['output']);
	}
}
