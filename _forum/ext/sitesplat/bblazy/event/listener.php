<?php
/**
*
* @package BBlazy
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bblazy\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_modify_post_row'		=> 'modify_posts',
			'core.posting_modify_template_vars'		=> 'modify_preview',
			'core.ucp_pm_view_message'				=> 'modify_pms',

			'core.memberlist_view_profile'			=> 'modify_member_profile_signature',
			'core.memberlist_prepare_profile_data'	=> 'modify_member_profile_avatar',
			'core.get_gravatar_url_after'			=> 'add_gravatar_class',
		);
	}

	protected $template;
	public function __construct(\phpbb\template\template $template)
	{
		$this->template = $template;
	}

	public function modify_posts($event)
	{

		// parse poster signature
		if (!empty($event['post_row']['SIGNATURE']))
		{
			$event->update_subarray('post_row', 'SIGNATURE', $this->lazify_img($event['post_row']['SIGNATURE']));
		}
		// parse message
		$event->update_subarray('post_row', 'MESSAGE', $this->lazify_img($event['post_row']['MESSAGE']));

		// parse poster avatar
		if (!empty($event['post_row']['POSTER_AVATAR']))
		{
			$event->update_subarray('post_row', 'POSTER_AVATAR', $this->lazify_img($event['post_row']['POSTER_AVATAR']));
		}

		// now process attachments
		$attachments = $event['attachments'];
		foreach ($attachments as $post_id => $post_attachments)
		{
			foreach ($post_attachments as $key => $attachment)
			{
				$attachments[$post_id][$key] = $this->lazify_img($attachment);
			}
		}
		$event['attachments'] = $attachments;
	}

	public function modify_preview($event)
	{
		$preview_message = $this->template->retrieve_var('PREVIEW_MESSAGE');

		if (!empty($preview_message))
		{
			// preview message is easy...
			$event->update_subarray('page_data', 'PREVIEW_MESSAGE', $this->lazify_img($preview_message));

			// ...attachments are hardcore!
			$prev_attachment = '';
			$i = 0;
			while (true)
			{
				$attachment = $this->template->retrieve_block_vars("attachment[$i]", ['DISPLAY_ATTACHMENT']);
				if (empty($attachment))
				{
					break;
				}

				if ($attachment['DISPLAY_ATTACHMENT'] == $prev_attachment)
				{
					break;
				}

				$lazyfied = $this->lazify_img($attachment['DISPLAY_ATTACHMENT']);
				$this->template->alter_block_array("attachment", [
					'DISPLAY_ATTACHMENT'	=> $lazyfied,
				], $i, 'change');

				$prev_attachment = $lazyfied;
				$i++;
			}
		}
	}

	public function modify_pms($event)
	{
		// parse message
		$event->update_subarray('msg_data', 'MESSAGE', $this->lazify_img($event['msg_data']['MESSAGE']));

		// parse poster avatar
		if (!empty($event['msg_data']['AUTHOR_AVATAR']))
		{
			$event->update_subarray('msg_data', 'AUTHOR_AVATAR', $this->lazify_img($event['msg_data']['AUTHOR_AVATAR']));
		}

		// parse poster signature
		if (!empty($event['msg_data']['SIGNATURE']))
		{
			$event->update_subarray('msg_data', 'SIGNATURE', $this->lazify_img($event['msg_data']['SIGNATURE']));
		}

		// now process attachments
		if (!empty($event['attachments']))
		{
			$attachments = $event['attachments'];
			foreach ($attachments as $key => $attachment)
			{
				$attachments[$key] = $this->lazify_img($attachment);
			}
			$event['attachments'] = $attachments;
		}
	}

	public function modify_member_profile_signature($event)
	{
		if (!empty($event['member']['user_sig']))
		{
			$event->update_subarray('member', 'user_sig', $this->lazify_img($event['member']['user_sig']));
		}
	}

	public function modify_member_profile_avatar($event)
	{
		if (!empty($event['template_data']['AVATAR_IMG']))
		{
			$event->update_subarray('template_data', 'AVATAR_IMG', $this->lazify_img($event['template_data']['AVATAR_IMG']));
		}
	}

	public function add_gravatar_class($event)
	{
		$event->offsetSet('url', $event['url'] .= '" class="avatar');
	}

	protected function lazify_img($html)
	{
		if (is_array($html)) {
			return $html;
		}

		// Dion - preg_replace_callback() method is almost twice as fast as using DOM/XML. ( PHP7 also has optimizations for regular expressions.) 
		// no need for <noscript> junk from old code because javascript is required for all sitesplat themes
		return preg_replace_callback('`<img (.*?)src\="(.*?)"(.*?)>`uis', function($matches) {
			$part1 = $matches[1];
			$part3 = $matches[3];
			if ($part1 && strpos($part1, 'class="') !== false) {
				$part1 = preg_replace('`class\="(.*?)"`uis', 'class="$1 b-lazy"', $part1);
			}
			else if ($part3 && strpos($part3, 'class="') !== false) {
				$part3 = preg_replace('`class\="(.*?)"`uis', 'class="$1 b-lazy"', $part3);
			}

			// For retina images to work correctly
			// <img> tags must have either a width or height attribute specified.
			// CSS background images must have a background-size property.
			if ($part1 && strpos($part1, 'data-lqip="') !== false) {
				$part1 = preg_replace_callback('`data-lqip\="(.*?)"`uis', function($matches) {
					$size = explode(',', $matches[1]);
					return 'width="' . $size[0] . '" height="' . $size[1] . '" src="' . $size[2] . '"';
				}, $part1);
				return '<img ' . $part1 . 'data-src="' . $matches[2] . '"' . $part3 . '>';
			}

			else if ($part3 && strpos($part3, 'data-lqip="') !== false && strpos($part3, 'data-lqip=""') === false) {

				$part3 = preg_replace_callback('`data-lqip\="(.*?)"`uis', function($matches) {
					$size = explode(',', $matches[1]);
					return 'width="' . $size[0] . '" height="' . $size[1] . '" src="' . $size[2] . '"';
				}, $part3);
				return '<img ' . $part1 . 'data-src="' . $matches[2] . '"' . $part3 . '>';
			}

			// Gravatars
//			else if (strpos($matches[2], 'gravatar')) {
//				return '<img ' . $part1 . 'class="b-lazy" data-src="' . $matches[2] . '"' . $part3 . '>';
//			}

			// default image
			return '<img ' . $part1 . 'src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="' . $matches[2] . '"' . $part3 . '>';
		//	return '<img ' . $part1 . 'src="" data-src="' . $matches[2] . '"' . $part3 . '>';
		}, $html);
	}
}
