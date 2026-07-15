<?php

/**
* @package   BBemoji
* @copyright (c) 2015 SiteSplat All rights reserved
*/
namespace sitesplat\bbemoji\event;

class bbreaction_listener extends listener
{
	public static function getSubscribedEvents()
	{
		return array(
			// BBreaction
			'sitesplat.bbreaction.admin_controller_construct'		=> 'bbreaction_assign_emoji_tpl',
			'sitesplat.bbreaction.display_reward_types_tpl'			=> 'bbreaction_assign_classlist_contents',
			'sitesplat.bbreaction.save_reward_type_tpl'				=> 'bbreaction_save_reward_type_tpl',
			'sitesplat.bbreaction.submit_reward_type_data'			=> 'bbreaction_submit_reward_type_data',
			'sitesplat.bbreaction.main_controller_display'			=> 'bbreaction_main_controller_display',
			'sitesplat.bbreaction.listener_construct'				=> 'bbreaction_assign_emoji_tpl',
			'sitesplat.bbreaction.listener_viewtopic_handle_posts'	=> 'bbreaction_assign_classlist_contents',
			'sitesplat.bbreaction.listener_view_topic_topic'		=> 'bbreaction_assign_classlist_contents',
			'sitesplat.bbreaction.listener_modify_profile'			=> 'bbreaction_assign_classlist_contents',
			'sitesplat.bbreaction.ucp_before'						=> 'bbreaction_assign_emoji_tpl',
			'sitesplat.bbreaction.ucp_likestat'						=> 'bbreaction_assign_classlist_contents',
			'sitesplat.bbreaction.ucp_likes'						=> 'bbreaction_assign_classlist_contents',
		);
	}

	public function bbreaction_assign_emoji_tpl()
	{
		$this->template->assign_vars(array(
			'BBREACTION_EMOJI'	=> true,
		));
	}

	public function bbreaction_save_reward_type_tpl($event)
	{
		$tpl_ary = $event['tpl_ary'];
		$tpl_ary['EMOJI'] = $this->unparse($event['row']['emoji']);
		$event['tpl_ary'] = $tpl_ary;
	}

	public function bbreaction_submit_reward_type_data($event)
	{
		$data = $event['data'];
		$data['emoji'] = $this->parse($this->request->variable('emoji', '', true));
		$event['data'] = $data;
	}

	public function bbreaction_main_controller_display($event)
	{
		if (!empty($event['row']['emoji']))
		{
			$event['classlist'] = '';
			$event['contents'] = $this->render($event['row']['emoji']);
		}
	}

	public function bbreaction_assign_classlist_contents($event)
	{
		if (!empty($event['row']['emoji']))
		{
			$ary_tpl = $event['ary_tpl'];
			$ary_tpl['ICON'] = '';
			$ary_tpl['CLASSLIST'] = '';
			$ary_tpl['CONTENTS'] = $this->render($event['row']['emoji']);
			$event['ary_tpl'] = $ary_tpl;
		}
	}
}
