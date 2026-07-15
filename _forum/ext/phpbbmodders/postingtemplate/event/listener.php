<?php
/**
 *
 * @package Posting Template extension
 * @author RMcGirr83 (Rich McGirr)
 * @copyright (c) 2014 phpbbmodders.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbmodders\postingtemplate\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\user */
	protected $user;

	/**
	* @param request $request
	* @param user $user
	*/
	public function __construct(\phpbb\request\request $request, \phpbb\user $user)
	{
		$this->request = $request;
		$this->user = $user;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_manage_forums_request_data'		=> 'acp_manage_forums_request_data',
			'core.acp_manage_forums_initialise_data'	=> 'acp_manage_forums_initialise_data',
			'core.acp_manage_forums_display_form'		=> 'acp_manage_forums_display_form',
			'core.posting_modify_template_vars'			=> 'posting_modify_template_vars',
		);
	}

	// Submit form (add/update)
	public function acp_manage_forums_request_data($event)
	{
		$array = $event['forum_data'];
		$array['forum_post_tpl'] = $this->request->variable('forum_post_tpl', '', true);
		$event['forum_data'] = $array;
	}

	// Default settings for new forums
	public function acp_manage_forums_initialise_data($event)
	{
		$array = $event['forum_data'];
		if (!$event['update'] && $event['action'] != 'edit')
		{
			$array['forum_post_tpl'] = '';
		}
		$event['forum_data'] = $array;
	}

	// ACP forums template output
	public function acp_manage_forums_display_form($event)
	{
		$array = $event['template_data'];
		$array['FORUM_POST_TPL'] = $event['forum_data']['forum_post_tpl'];
		$event['template_data'] = $array;
	}

	// modify posting and add our template stuff to the text area for posting
	public function posting_modify_template_vars($event)
	{
		$page_data = $event['page_data'];

		if ($event['mode'] == 'post' && !$event['submit'] && !$event['preview'] && !$event['load'] && !$event['save'] && !$event['refresh'] && empty($event['post_data']['post_subject']) && empty($event['post_data']['post_text']))
		{
			$page_data['MESSAGE'] = $event['post_data']['forum_post_tpl'];
		}
		$event['page_data'] = $page_data;
	}
}
