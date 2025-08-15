<?php
/**
*
* @package BBlazy
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bblazy\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_modify_post_row'	=> 'modify_posts',

			'core.posting_modify_template_vars'	=> 'modify_preview',
			
			'core.ucp_pm_view_message'	=> 'modify_pms',

			'core.memberlist_view_profile'			=> 'modify_member_profile_signature',
			'core.memberlist_prepare_profile_data'	=> 'modify_member_profile_avatar',
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

	protected function lazify_img($html)
	{
		$internal_errors = libxml_use_internal_errors(true);

		$doc = new \DOMDocument();
		$doc->loadHTML($html, LIBXML_HTML_NODEFDTD);
		$xpath = new \DOMXPath($doc);
		foreach ($xpath->query('//img[@src]') as $img)
		{
			// Create a <noscript> element that contains a copy of the original <img>
		//	$noscript = $doc->createElement('noscript');
		//	$noscript->appendChild($img->cloneNode(true));

			// Replace the src attribute with a data-original attribute
			$img->setAttribute('data-src', $img->getAttribute('src'));
			$img->setAttribute('src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');

			// Add b-lazy class
			$class = $img->getAttribute('class');
			$img->removeAttribute('class');
			$img->setAttribute('class', $class . ' b-lazy');

			// Replace <img> with <noscript> then reinsert <img> before <noscript>
		//	$img->parentNode->replaceChild($noscript, $img);
		//	$noscript->parentNode->insertBefore($img, $noscript);
		}

		libxml_use_internal_errors($internal_errors);

		return str_replace(['<html><body>', '</body></html>'], '', $doc->saveHTML());
	}
}
