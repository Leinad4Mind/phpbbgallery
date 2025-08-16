<?php
/**
*
* @package Categorize CAS
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\cas\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewforum_get_announcement_topic_ids_data'	=> 'viewforum_get_announcement_topic_ids_data',
			'core.viewforum_modify_topicrow'					=> 'viewforum_modify_topicrow',
		);
	}

	protected $user;
	protected $template;
	private $previous_type;
	public function __construct(\phpbb\user $user, \phpbb\template\template $template)
	{
		$this->user = $user;
		$this->template = $template;

		$this->previous_type = 4;
	}

	public function viewforum_get_announcement_topic_ids_data($event)
	{
		$this->user->add_lang_ext('sitesplat/cas', 'common');

		$sql_ary = $event['sql_ary'];
		$sql_ary['ORDER_BY'] = 't.topic_type DESC, t.topic_last_post_time DESC';
		$event['sql_ary'] = $sql_ary;
	}

	public function viewforum_modify_topicrow($event)
	{
		$topic_row = $event['topic_row'];
		$topic_row['S_TOPIC_TYPE_SWITCH'] = ($this->previous_type == $event['row']['topic_type']) ? true : false;
		$event['topic_row'] = $topic_row;

		$this->previous_type = $event['row']['topic_type'];
	}
}
