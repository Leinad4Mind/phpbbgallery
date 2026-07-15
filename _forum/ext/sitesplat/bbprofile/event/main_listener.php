<?php
/**
*
* BBbbprofile. An extension for the phpBB Forum Software package.
* @copyright (c) 2016, SiteSplat
* @license Proprietary
*
*/

namespace sitesplat\bbprofile\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.permissions'				=> 'set_permissions',
			'core.user_setup'				=> 'load_language_on_setup',
			'core.page_header'				=> 'add_page_header_link',
		);
	}

	protected $config;
	protected $user;
	protected $template;
	protected $auth;
	protected $bbprofile_manager;
	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\template\template $template, \phpbb\auth\auth $auth, \sitesplat\bbprofile\profile_parts\manager $bbprofile_manager)
	{
		$this->config = $config;
		$this->user = $user;
		$this->template = $template;
		$this->auth = $auth;
		$this->bbprofile_manager = $bbprofile_manager;
	}

	public function set_permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_bbprofile'] = array('lang' => 'ACL_U_BBPROFILE', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/bbprofile',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_page_header_link()
	{
		// only display BBprofile box to users who have permission to see it
		if ($this->auth->acl_get('u_bbprofile'))
		{
			$bbprofile_box_data = $this->bbprofile_manager->generate_bbprofile_box();
			if ($bbprofile_box_data)
			{
				$this->template->assign_vars(array(
					'S_BBPROFILE'				=> $this->config['bbprofile_position'] !== 'ucp' || substr($this->user->page['page'], 0, 3) == 'ucp',
					'COMPLETED_PERCENTAGE'		=> $bbprofile_box_data['percentage'],
					'L_COMPLETED_PERCENTAGE'	=> $this->user->lang('COMPLETED_PERCENTAGE', $bbprofile_box_data['percentage']),
					'APPEAL_TEXT'				=> $bbprofile_box_data['text'],
					'APPEAL_ICON'				=> $bbprofile_box_data['icon'],
					'APPEAL_BUTTON_LABEL'		=> $bbprofile_box_data['button']['label'],
					'APPEAL_BUTTON_URL'			=> $bbprofile_box_data['button']['url'],
				));
			}
		}
	}
}
