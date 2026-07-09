<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\event;

class template_conditions_listener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface 
{
	protected $helper;
	public function __construct(\phpbb\template\template $template)
	{
		$this->template = $template;
	}
	
	static public function getSubscribedEvents()
	{
		return array(
			'core.index_modify_page_title'				=> 'in_index',
			'core.modify_mcp_modules_display_option'	=> 'in_mcp',
			'core.memberlist_prepare_profile_data'		=> 'in_memberlist',
			'core.memberlist_view_profile'			    => 'in_member_profile',
			'core.posting_modify_template_vars'			=> 'in_posting',
			'core.search_modify_forum_select_list'		=> 'in_search',
			'core.ucp_display_module_before'			=> 'in_ucp',
			'core.viewforum_modify_page_title'		    => 'in_viewforum',
			'core.viewonline_modify_sql'				=> 'in_viewonline',
			'core.viewtopic_modify_page_title'			=> 'in_viewtopic',
		);
	}

// you can also do things like:	
/**
*
* {% if not BB_LOAD_IN_INDEX %}
* {% if not BB_LOAD_IN_MCP and not BB_LOAD_IN_UCP %}
* {% if S_USER_LOGGED_IN and (BB_LOAD_IN_VIEWTOPIC or BB_LOAD_IN_POSTING) and S_BBPROSPECTIVE_ENABLED %}
* 
* Statements inside parentheses are evaluated before those outside the
* parentheses. So, if you had this:
*
* ----------------------------------
* <!-- IF (A and B) or (C and D) -->...<!-- ENDIF -->
* ----------------------------------
* ----------------------------------
* {% if (A and B) or (C and D) %}...{% endif %}
* ----------------------------------
*
* The two "and" conditions in the parentheses will be evaluated before the "or" condition. 
* 	
*
*/

// <!-- IF BB_LOAD_IN_INDEX -->
	public function in_index()
	{
		$this->template->assign_var('BB_LOAD_IN_INDEX', true);
	}

// <!-- IF BB_LOAD_IN_MCP -->
	public function in_mcp()
	{
		$this->template->assign_var('BB_LOAD_IN_MCP', true);
	}
// <!-- IF BB_LOAD_IN_MEMBERLIST -->
	public function in_memberlist()
	{
		static $has_been_called;

		if (empty($has_been_called)) {
			$this->template->assign_var('BB_LOAD_IN_MEMBERLIST', true);
			$has_been_called = true;
		}
	}
// <!-- IF BB_LOAD_IN_MEMBER_PROFILE -->
	public function in_member_profile()
	{
		$this->template->assign_var('BB_LOAD_IN_MEMBER_PROFILE', true);
	}	
// <!-- IF BB_LOAD_IN_POSTING -->
	public function in_posting()
	{
		$this->template->assign_var('BB_LOAD_IN_POSTING', true);
	}
// <!-- IF BB_LOAD_IN_SEARCH -->
	public function in_search()
	{
		$this->template->assign_var('BB_LOAD_IN_SEARCH', true);
	}
// <!-- IF BB_LOAD_IN_UCP -->
	public function in_ucp()
	{
		$this->template->assign_var('BB_LOAD_IN_UCP', true);
	}
// <!-- IF BB_LOAD_IN_VIEWFORUM -->
	public function in_viewforum()
	{
		$this->template->assign_var('BB_LOAD_IN_VIEWFORUM', true);
	}
// <!-- IF BB_LOAD_IN_VIEWONLINE -->
	public function in_viewonline()
	{
		$this->template->assign_var('BB_LOAD_IN_VIEWONLINE', true);
	}
// <!-- IF BB_LOAD_IN_VIEWTOPIC -->
	public function in_viewtopic()
	{
		$this->template->assign_var('BB_LOAD_IN_VIEWTOPIC', true);
	}
}