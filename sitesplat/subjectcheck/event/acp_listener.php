<?php
/**
*
* @package subjectcheck
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\subjectcheck\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subject Check Event listener.
 */
class acp_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_manage_forums_request_data'		=> 'request',
			'core.acp_manage_forums_initialise_data'	=> 'init',
			'core.acp_manage_forums_display_form'		=> 'display',
		);
	}

	protected $request;
	public function __construct(\phpbb\request\request $request)
	{
		$this->request = $request;
	}

	public function request($event)
	{
		$forum_data = $event['forum_data'];

		$forum_data['forum_subject_check'] = $this->request->variable('forum_subject_check', true);

		$event['forum_data'] = $forum_data;
	}

	public function init($event)
	{
		$forum_data = $event['forum_data'];

		if (!empty($event['row']))
		{
			$forum_data['forum_subject_check'] = $event['row']['forum_subject_check'];
		}
		else
		{
			$forum_data['forum_subject_check'] = 1;
		}

		$event['forum_data'] = $forum_data;
	}

	public function display($event)
	{
		$template_data = $event['template_data'];

		$template_data['S_FORUM_SUBJECT_CHECK'] = $event['forum_data']['forum_subject_check'];

		$event['template_data'] = $template_data;
	}
}
