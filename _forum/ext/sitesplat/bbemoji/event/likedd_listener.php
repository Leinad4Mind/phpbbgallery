<?php

/**
 * @package BBEmoji
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbemoji\event;

class likedd_listener extends listener
{
	public static function getSubscribedEvents()
	{
		return array(
			// LikeBB
			'sitesplat.likedd.ucp_likes_sql'		=> 'likebb_alter_sql',
			'sitesplat.likedd.ucp_likes_template'	=> 'likebb_render_subject',
		);
	}

	public function likebb_alter_sql($event)
	{
		$sql_ary1 = $event['sql_ary1'];
		$sql_ary1['SELECT'] .= ', f.enable_subject_emoji';
		$sql_ary1['LEFT_JOIN'][] = [
			'FROM'	=> [FORUMS_TABLE => 'f'],
			'ON'	=> 'p.forum_id = f.forum_id',
		];
		$event['sql_ary1'] = $sql_ary1;

		$sql_ary2 = $event['sql_ary2'];
		$sql_ary2['SELECT'] .= ', f.enable_subject_emoji';
		$sql_ary2['LEFT_JOIN'][] = [
			'FROM'	=> [FORUMS_TABLE => 'f'],
			'ON'	=> 'p.forum_id = f.forum_id',
		];
		$event['sql_ary2'] = $sql_ary2;
	}

	public function likebb_render_subject($event)
	{
		if (!empty($event['row']['enable_subject_emoji'])) {
			$template_data = $event['template_data'];
			$template_data['SUBJECT'] = $this->render($this->parse($template_data['SUBJECT']));
			$event['template_data'] = $template_data;
		}
	}
}