<?php
/**
*
* Imgur - forum images uploader
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\imgur\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/* @var */
	protected $config;
	protected $user;
	protected $template;

	/**
	* Constructor
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\template\template $template)
	{
		$this->config	= $config;
		$this->user		= $user;
		$this->template	= $template;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.posting_modify_template_vars'		=> 'load_language_on_posting',
			'core.acp_attachments_config_edit_add'	=> 'load_config_on_setup',
		);
	}

	public function load_language_on_posting($event)
	{
		$this->user->add_lang_ext('sitesplat/imgur', 'imgur');
		$this->template->assign_vars(array('IN_IMGUR' => ($this->config['imgur_clientid']) ? true : false));
	}

	public function load_config_on_setup($event)
	{
		if ($event['mode'] == 'attach')
		{
			$this->user->add_lang_ext('sitesplat/imgur', 'imgur');
			$display_vars = $event['display_vars'];

			$add_config_var = array(
				'imgur_clientid' =>
					array(
						'lang'		=> 'IMGUR_CLIENT_ID',
						'validate'	=> 'string',
						'type'		=> 'text:25:100',
						'explain'	=> true),
			);

			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $add_config_var, array('after' =>'upload_path'));
			$event['display_vars'] = array('title' => $display_vars['title'], 'vars' => $display_vars['vars']);
		}
	}
}
