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
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_board_config_edit_add'				=> 'minify_option',
			'core.twig_environment_render_template_after'	=> 'minify_html',
		);
	}

	protected $config;
	public function __construct(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	public function minify_option($event)
	{
		if ($event['mode'] != 'server')
		{
			return;
		}

		$display_vars = $event['display_vars'];
		$display_vars['vars'] = array_merge(
			array_slice($display_vars['vars'], 0, 2),
			[
				'sitesplat_bbcore_minify_html'	=> [
					'lang'		=> 'SITESPLAT_BBCORE_MINIFY_HTML',
					'validate'	=> 'bool',
					'type'		=> 'radio:yes_no',
					'explain'	=> true,
				],
			],
			array_slice($display_vars['vars'], 2)
		);
		$event['display_vars'] = $display_vars;
	}

	public function minify_html($event)
	{
		if (!$this->config['sitesplat_bbcore_minify_html'])
		{
			return;
		}

		$parser = \WyriHaximus\HtmlCompress\Factory::construct();
		$event['output'] = $parser->compress($event['output']);
	}
}
