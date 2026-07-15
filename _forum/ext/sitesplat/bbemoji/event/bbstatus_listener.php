<?php

/**
 * @package BBEmoji
 * @copyright (c) 2016-2022 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbemoji\event;

class bbstatus_listener extends listener
{
	public static function getSubscribedEvents()
	{
		return array(
			'sitesplat.bbstatus.listener_general_before'							=> 'bbstatus_listener_general',
			'sitesplat.bbstatus.listener_general_status_templates_tpl'				=> 'bbstatus_listener_general_tpl',
			'sitesplat.bbstatus.listener_edit_user_status_publish_sql_before'		=> 'listener_edit_user_status_publish_sql_before',
			'sitesplat.bbstatus.listener_edit_user_status_save_template_sql_before'	=> 'listener_edit_user_status_save_template_sql_before',
			'sitesplat.bbstatus.listener_edit_user_status_save_trigger_error_ary'	=> 'listener_edit_user_status_save_trigger_error_ary',
			'sitesplat.bbstatus.listener_edit_user_status_after'					=> 'listener_edit_user_status_after',
			'sitesplat.bbstatus.listener_save_user_status_sql_before'				=> 'listener_save_user_status_sql_before',
			'sitesplat.bbstatus.listener_display_user_status'						=> 'listener_display_user_status',
			'sitesplat.bbstatus.listener_viewtopic_user_status'						=> 'listener_viewtopic_user_status',
		);
	}

	public function bbstatus_listener_general()
	{
		$this->template->assign_var('SITESPLAT_BBEMOJI_ENABLED', true);
	}

	public function bbstatus_listener_general_tpl($event)
	{
		$status_templates_tpl = $event['status_templates_tpl'];
		$status_templates_tpl['STATUS'] = $this->render($status_templates_tpl['STATUS']);
		$status_templates_tpl['STATUS_UNPARSED'] = $this->unparse($status_templates_tpl['STATUS_UNPARSED']);
		$status_templates_tpl['U_PUBLISH'] = generate_board_url() . '/ucp.php?i=ucp_profile&mode=profile_info&publish_status=true&color=' . urlencode($event['row']['template_color']) . '&status=' . urlencode($this->unparse($event['row']['template_text']));
		$event['status_templates_tpl'] = $status_templates_tpl;
	}

	public function listener_edit_user_status_publish_sql_before($event)
	{
		$event['status'] = $this->parse($event['status']);
	}

	public function listener_edit_user_status_save_template_sql_before($event)
	{
		$event['status'] = $this->parse($event['status']);
	}

	public function listener_edit_user_status_save_trigger_error_ary($event)
	{
		$error_ary = $event['error_ary'];
		$error_ary['STATUS'] = $this->parse($this->render($error_ary['STATUS']));
		$error_ary['STATUS_UNPARSED'] = $this->unparse($error_ary['STATUS_UNPARSED']);
		$event['error_ary'] = $error_ary;
	}

	public function listener_edit_user_status_after($event)
	{
		$event['status'] = $this->unparse($event['status']);
	}

	public function listener_save_user_status_sql_before($event)
	{
		$event['status'] = $this->parse($event['status']);
	}

	public function listener_display_user_status($event)
	{
		$tpl_ary = $event['tpl_ary'];
		$tpl_ary['MEMBER_STATUS'] = $this->render($tpl_ary['MEMBER_STATUS']);
		$event['tpl_ary'] = $tpl_ary;
	}

	public function listener_viewtopic_user_status($event)
	{
		$post_row = $event['post_row'];
		$post_row['STATUS'] = $this->render($post_row['STATUS']);
		$event['post_row'] = $post_row;
	}
}
