<?php
/**
*
* @package BBinfinitepagination
* @copyright (c) 2019 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbinfinitepagination\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $config;
	protected $template;
	protected $language;
	public static function getSubscribedEvents()
	{
		return array(
			'core.acp_board_config_edit_add'	=> 'add_fx_setting',

			'core.page_header_after'	=> 'fx',
		);
	}

	public function __construct(\phpbb\template\template $template, \phpbb\config\config $config, \phpbb\language\language $language)
	{
		$this->template = $template;
		$this->config = $config;
		$this->language = $language;
	}

	public function add_fx_setting($event)
	{
		$this->language->add_lang('acp', 'sitesplat/bbinfinitepagination');

		$display_vars = $event['display_vars'];

		$vars = $display_vars['vars'];
		$before = array_slice($vars, 0, -1);
		$after = array_slice($vars, -1, 1);
		$display_vars['vars'] = array_merge($before, [
			'legend_bbinfinitepagination'		=> 'BBINFINITEPAGINATION',
			'sitesplat_bbinfinitepagination_fx'	=> [
				'lang'		=> 'BBINFINITEPAGINATION_FX',
				'validate'	=> 'string',
				'type'		=> 'select',
				'function'	=> [$this, 'fx_select'],
				'explain'	=> false,
			],
			'sitesplat_bbinfinitepagination_viewtopic'	=> [
				'lang' => 'BBINFINITEPAGINATION_VIEWTOPIC',
				'validate' => 'bool',
				'type' => 'radio:yes_no',
				'explain' => false,
			],
			'sitesplat_bbinfinitepagination_memberlist'	=> [
				'lang' => 'BBINFINITEPAGINATION_MEMBERLIST',
				'validate' => 'bool',
				'type' => 'radio:yes_no',
				'explain' => false,
			],
			'sitesplat_bbinfinitepagination_viewonline'	=> [
				'lang' => 'BBINFINITEPAGINATION_VIEWONLINE',
				'validate' => 'bool',
				'type' => 'radio:yes_no',
				'explain' => false,
			],
			'sitesplat_bbinfinitepagination_search'	=> [
				'lang' => 'BBINFINITEPAGINATION_SEARCH',
				'validate' => 'bool',
				'type' => 'radio:yes_no',
				'explain' => false,
			],
			'sitesplat_bbinfinitepagination_viewforum'	=> [
				'lang' => 'BBINFINITEPAGINATION_VIEWFORUM',
				'validate' => 'bool',
				'type' => 'radio:yes_no',
				'explain' => false,
			],
		], $after);

		$event['display_vars'] = $display_vars;
	}

	public function fx()
	{
		$this->template->assign_vars([
			'SITESPLAT_BBINFINITEPAGINATION_FX'			=> $this->config['sitesplat_bbinfinitepagination_fx'],
			'SITESPLAT_BBINFINITEPAGINATION_VIEWTOPIC'	=> $this->config['sitesplat_bbinfinitepagination_viewtopic'],
			'SITESPLAT_BBINFINITEPAGINATION_MEMBERLIST'	=> $this->config['sitesplat_bbinfinitepagination_memberlist'],
			'SITESPLAT_BBINFINITEPAGINATION_VIEWONLINE'	=> $this->config['sitesplat_bbinfinitepagination_viewonline'],
			'SITESPLAT_BBINFINITEPAGINATION_SEARCH'		=> $this->config['sitesplat_bbinfinitepagination_search'],
			'SITESPLAT_BBINFINITEPAGINATION_VIEWFORUM'	=> $this->config['sitesplat_bbinfinitepagination_viewforum'],
		]);
	}

	public function fx_select($default = '')
	{
		$options = '';
		foreach (['Hapi', 'Amun', 'Isis', 'Montu', 'Satet', 'Ra', 'Sobek', 'Ptah', 'Bes', 'Nut'] as $fx)
		{
			$options .= '<option value="' . $fx . '"' . (($fx == $default) ? ' selected' : '') . '>' . $fx . '</option>';
		}
		return $options;
	}
}
