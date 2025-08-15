<?php

/**
* @package BBemoji
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*/
namespace sitesplat\bbemoji\event;

class bbfront_listener extends listener
{
	public static function getSubscribedEvents()
	{
		return array(
			'sitesplat.bbfront.card_sql_before'	=> 'bbfront_sql',
			'sitesplat.bbfront.card_tpl_before'	=> 'bbfront_tpl',
		);
	}

	public function bbfront_sql($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['SELECT'] .= ', f.enable_subject_emoji';
		$sql_ary['LEFT_JOIN'][] = array(
			'FROM'	=> array(FORUMS_TABLE => 'f'),
			'ON'	=> 'f.forum_id = p.forum_id',
		);
		$event['sql_ary'] = $sql_ary;
	}

	public function bbfront_tpl($event)
	{
		$tpl_ary = $event['tpl_ary'];
		if ($event['row']['enable_subject_emoji'])
		{
			$tpl_ary['TITLE'] = $this->render($this->parse($tpl_ary['TITLE']));
		}

		$post_text = generate_text_for_display($event['row']['post_text'], $event['row']['bbcode_uid'], $event['row']['bbcode_bitfield'], $event['parse_flags'], true);
		// temporarily mask emojis
		$post_text = preg_replace('/<img(.+)class="emoji"/U', '&lt;img${1}class="emoji"', $post_text);
		// now we can strip tags without loosing emojis
		$post_text = strip_tags($post_text);
		// convert emojis back to IMG
		$post_text = preg_replace('/&lt;img(.+)class="emoji"/U', '<img${1}class="emoji"', $post_text);
		// truncate string counting emojis as 1 character each
		$chars_count = 0;
		$emoji_chars = 0;
		$in_tag = false;
		$new_post_text = '';
		foreach (str_split($post_text) as $char)
		{
			if ($chars_count > $event['config_aray']['chars'])
			{
				break;
			}

			if ($char == '<')
			{
				$in_tag = true;
			}
			if ($char == '>')
			{
				$chars_count++;
				$emoji_chars++;
				$in_tag = false;
			}

			if ($in_tag)
			{
				$emoji_chars++;
			}
			else
			{
				$chars_count++;
			}

			$new_post_text .= $char;
		}
		$tpl_ary['TEXT'] = $new_post_text;
		$event['tpl_ary'] = $tpl_ary;
	}
}
