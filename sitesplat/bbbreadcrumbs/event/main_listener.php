<?php
/**
*
* BBbreadcrumbs.
*
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbbreadcrumbs\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			// UCP, MCP
			'core.ucp_display_module_before'			=> 'add_breadcrumbs_to_module',
			'core.modify_mcp_modules_display_option'	=> 'add_breadcrumbs_to_module',

			// memberlist
			'core.memberlist_team_modify_query'			=> 'add_breadcrumbs_to_memberlist_team',
			// $mode == 'contact'
			'core.memberlist_view_profile'				=> 'add_breadcrumbs_to_memberlist_profile',
			// $mode == 'contactadmin'
			// $mode == 'group'
			// $mode -> default -- move before 'group'
			'core.memberlist_modify_sql_query_data'		=> 'add_breadcrumbs_to_memberlist',

			// faq
			// $mode == 'bbcode'
			'core.faq_mode_validation'	=> 'add_breadcrumbs_to_faq',

			// search
			'core.search_modify_submit_parameters'	=> 'add_breadcrumbs_to_search',

			// viewonline
			'core.viewonline_modify_forum_data_sql'	=> 'add_breadcrumbs_to_viewonline',
		);
	}

	protected $template;
	protected $user;
	protected $root_path;
	protected $php_ext;
	public function __construct(\phpbb\template\template $template, \phpbb\user $user, $root_path, $php_ext)
	{
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public function add_breadcrumbs_to_module($event)
	{
		// here we store breadrumbs in proper order
		$breadcrumbs_data = array();
		// list of all modules
		$modules = $event['module']->module_ary;
		// module class
		$module_class = $event['module']->p_class;

		// standardize module ID
		$id = $event['module']->p_id;
		if (!$id)
		{
			if (strcmp((int) $event['id'], $event['id'])) // module ID is string (ie. ucp_pm, mcp_queue, ...)
			{
				// hacks
				if ($event['id'] == 'pm')
				{
					$event['id'] = 'ucp_pm';
				}

				// find proper module
				foreach ($modules as $module)
				{
					if ($module['name'] == $event['id'] && $module['mode'] == $event['mode'])
					{
						$id = $module['id'];
						break;
					}
				}
			}
			else
			{
				$id = $event['id'];
			}
		}

		while($id)
		{
			// find module by ID
			$module_key = array_search($id, array_column($modules, 'id'));
			// get module data
			$module = $modules[$module_key];
			// prepend module to breadcrumbs
			array_unshift($breadcrumbs_data, $module);
			// do the same for parent
			$id = $module['parent'];
		}

		$this->add_breadcrumb(
			$module_class == 'ucp' ? $this->user->lang('PROFILE') : $this->user->lang('MCP'),
			append_sid("{$this->root_path}{$module_class}.{$this->php_ext}")
		);

		foreach ($breadcrumbs_data as $breadcrumb)
		{
			$this->add_breadcrumb(
				$breadcrumb['lang'],
				append_sid("{$this->root_path}{$module_class}.{$this->php_ext}", 'i=' . ($breadcrumb['name'] ?: $breadcrumb['id']) . (($breadcrumb['mode']) ? '&amp;mode=' . $breadcrumb['mode'] : ''))
			);
		}
	}

	public function add_breadcrumbs_to_memberlist_team()
	{
		$this->add_breadcrumb(
			$this->user->lang('THE_TEAM'),
			append_sid("{$this->root_path}memberlist.{$this->php_ext}", "mode=team")
		);
	}

	public function add_breadcrumbs_to_memberlist_profile($event)
	{
		$this->add_breadcrumb(
			$this->user->lang('MEMBERLIST'),
			append_sid("{$this->root_path}memberlist.{$this->php_ext}")
		);
		$this->add_breadcrumb(
			$event['member']['username'],
			append_sid("{$this->root_path}memberlist.{$this->php_ext}", 'mode=viewprofile&u=' . $event['member']['user_id'])
		);
	}

	public function add_breadcrumbs_to_memberlist($event)
	{
		$this->add_breadcrumb(
			$this->user->lang('MEMBERLIST'),
			append_sid("{$this->root_path}memberlist.{$this->php_ext}")
		);
	}

	public function add_breadcrumbs_to_faq($event)
	{
		$this->add_breadcrumb(
			$event['page_title'],
			append_sid("{$this->root_path}faq.{$this->php_ext}")
		);
	}

	public function add_breadcrumbs_to_search()
	{
		$this->add_breadcrumb(
			$this->user->lang('SEARCH'),
			append_sid("{$this->root_path}search.{$this->php_ext}")
		);
	}

	public function add_breadcrumbs_to_viewonline()
	{
		$this->add_breadcrumb(
			$this->user->lang('WHO_IS_ONLINE'),
			append_sid("{$this->root_path}viewonline.{$this->php_ext}")
		);
	}

	private function add_breadcrumb($forum_name, $u_view_forum)
	{
		$this->template->assign_block_vars('navlinks', array(
			'FORUM_NAME'	=> $forum_name,
			'U_VIEW_FORUM'	=> $u_view_forum,
		));
	}
}
