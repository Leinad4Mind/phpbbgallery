<?php

/**
* @package BBemoji
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*/
namespace sitesplat\bbemoji\event;

class bbgreetings_listener extends listener
{
	public static function getSubscribedEvents()
	{
		return array(
			'sitesplat.bbgreetings.listener_display_greeting_tpl_before'	=> 'bbgreetings_front',
			'sitesplat.bbgreetings.acp_submit'								=> 'bbgreetings_acp_submit',
			'sitesplat.bbgreetings.acp_display'								=> 'bbgreetings_acp_display',
			'sitesplat.bbgreetings.acp_edit'								=> 'bbgreetings_acp_edit',
		);
	}

	public function bbgreetings_front($event)
	{
		$tpl_ary = $event['tpl_ary'];
		$tpl_ary['GREETING_TEXT'] = $this->render($tpl_ary['GREETING_TEXT']);
		$tpl_ary['GREETING_EXPLAIN'] = $this->render($tpl_ary['GREETING_EXPLAIN']);
		$event['tpl_ary'] = $tpl_ary;
	}

	public function bbgreetings_acp_submit($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['greeting_text'] = $this->parse($sql_ary['greeting_text']);
		$sql_ary['greeting_explain'] = $this->parse($sql_ary['greeting_explain']);
		$event['sql_ary'] = $sql_ary;
	}

	public function bbgreetings_acp_display($event)
	{
		$tpl_ary = $event['tpl_ary'];
		$tpl_ary['TEXT'] = $this->render($tpl_ary['TEXT']);
		$tpl_ary['EXPLAIN'] = $this->render($tpl_ary['EXPLAIN']);
		$event['tpl_ary'] = $tpl_ary;
	}

	public function bbgreetings_acp_edit($event)
	{
		$tpl_ary = $event['tpl_ary'];
		$tpl_ary['GREETING_TEXT'] = $this->unparse($tpl_ary['GREETING_TEXT']);
		$tpl_ary['GREETING_EXPLAIN'] = $this->unparse($tpl_ary['GREETING_EXPLAIN']);
		$event['tpl_ary'] = $tpl_ary;
	}
}
