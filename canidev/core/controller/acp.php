<?php
/**
* @package Ext Common Core
* @version 1.1.0 01/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\core\controller;

use \Symfony\Component\DependencyInjection\ContainerInterface;

class acp
{
	protected $cache;
	protected $config;
	protected $language;
	protected $template;

	protected $page_title;
	protected $tpl_name;

	protected $form_action = '';

	public $tools;

	/**
	* Set basic services for this class
	*
	* @param ContainerInterface  $container 	Service container
	*/
	public function set_basic_services(ContainerInterface $container)
	{
		$this->cache 		= $container->get('cache.driver');
		$this->config 		= $container->get('config');
		$this->language 	= $container->get('language');
		$this->template 	= $container->get('canidev.core.template');
		$this->tools 		= $container->get('canidev.core.tools');
	}

	/**
	 * Do basic actions on acp controller
	 * 
	 * @param string 	$canidev_id 		CaniDev ID for the extension
	 * @param string 	$current_version 	Extension's version
	 */
	public function page_header($canidev_id, $current_version)
	{
		$this->template->assign_vars(array(
			'U_ACTION'			=> $this->form_action,
			'U_HELP'			=> 'https://www.canidev.com/store/' . $canidev_id . '?rq=documentation&v=' . $current_version,
		));
		
		// Delete the cache in the first call after the installation (prevent error to load extension template events without clear the cache manually)
		if($this->config['cbb_asset_check'] != $this->config['assets_version'])
		{
			$this->config->set('cbb_asset_check', $this->config['assets_version']);
			$this->cache->purge();
		}
	}

	/**
	 * Parse display_vars to template
	 * 
	 * @param array 	$display_vars 		Variables to show
	 * @param string 	$tpl_key 			Key for template loop
	 */
	protected function display_vars($display_vars, $tpl_key = 'options')
	{
		foreach($display_vars as $config_key => $vars)
		{
			if(!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if(strpos($config_key, 'legend') !== false)
			{
				$this->template->assign_block_vars($tpl_key, array(
					'S_LEGEND'		=> true,
					'LEGEND'		=> $this->language->lang($vars)
				));
				continue;
			}
			
			if(!isset($this->new_config[$config_key]) && isset($vars['default']))
			{
				$this->new_config[$config_key] = $vars['default'];
			}

			$type = explode(':', $vars['type']);

			$content = build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);
			if(empty($content))
			{
				continue;
			}

			$this->template->assign_block_vars($tpl_key, array(
				'KEY'			=> $config_key,
				'TITLE'			=> $this->language->lang($vars['lang']),
				'S_EXPLAIN'		=> ($this->language->is_set($vars['lang'] . '_EXPLAIN') ? $this->language->lang($vars['lang'] . '_EXPLAIN') : ''),
				'CONTENT'		=> $content,
				'DISPLAY'		=> (isset($vars['display']) && !$vars['display']) ? false : true,
			));

			unset($display_vars[$config_key]);
		}
	}

	/**
	 * Obtain controller action
	 * @return string
	 */
	public function get_form_action()
	{
		return $this->form_action;
	}

	/**
	 * Obtain controller template
	 * @return string
	 */
	public function get_template()
	{
		return $this->tpl_name;
	}
	
	/**
	 * Obtain controller title
	 * 
	 * @param string 	$prefix 	Prefix to be added to title
	 * @return string
	 */
	public function get_title($prefix = '')
	{
		if($prefix)
		{
			return $this->language->lang($prefix) . ' &bull; ' . $this->language->lang($this->page_title);
		}

		return $this->page_title;
	}

	/**
	 * Set controller action
	 * 
	 * @param string 	$u_action 		Form action to be set
	 * @return acp
	 */
	public function set_form_action($u_action)
	{
		$this->form_action = $u_action;
		return $this;
	}
}
