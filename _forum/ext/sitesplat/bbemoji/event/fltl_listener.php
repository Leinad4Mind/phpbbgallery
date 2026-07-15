<?php

/**
* @package BBemoji
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*/
namespace sitesplat\bbemoji\event;

class fltl_listener extends listener
{
	public static function getSubscribedEvents()
	{
		return array(
			'sitesplat.fltl.controller_sql'			=> 'select_enable_subject_emoji',
			'sitesplat.fltl.controller_sql_after'	=> 'emojify_fltl_sql_after',
			'sitesplat.fltl.controller_echo_before'	=> 'emojify_fltl_echo_before',
			'sitesplat.fltl.listener_echo_before'	=> 'emojify_fltl_echo_before',
		);
	}

	public function select_enable_subject_emoji($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['SELECT'] .= ', sbf.enable_subject_emoji';
		if (!isset($sql_ary['LEFT_JOIN']))
		{
			$sql_ary['LEFT_JOIN'] = array();
		}
		$sql_ary['LEFT_JOIN'][] = array(
			'FROM'	=> array(FORUMS_TABLE => 'sbf'),
			'ON'	=> 'sbf.forum_id = t.forum_id',
		);
		$event['sql_ary'] = $sql_ary;
	}

	public function emojify_fltl_sql_after($event)
	{
		$rows = $event['rows'];
		foreach ($rows as &$row)
		{
			$row['post_text'] = $this->unparse($row['post_text']);
			if ($row['enable_subject_emoji'])
			{
				$row['topic_title'] = $this->render($this->parse($row['topic_title']));
			}
		}
		$event['rows'] = $rows;
	}

	public function emojify_fltl_echo_before($event)
	{
		$row = $event['row'];
		$row['post_text'] = $this->render($this->parse($row['post_text']));
		$event['row'] = $row;
	}
}
