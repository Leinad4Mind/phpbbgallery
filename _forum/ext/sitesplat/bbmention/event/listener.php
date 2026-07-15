<?php

/**
* @package   BB@mention
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*/
namespace sitesplat\bbmention\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\controller\helper;
use phpbb\db\driver\driver_interface as db;
use phpbb\notification\manager;
use phpbb\template\twig\twig as template;

class listener implements EventSubscriberInterface
{
	protected $helper;
	protected $manager;
	protected $template;

	public function __construct(helper $helper, manager $manager, template $template)
	{
		$this->helper   = $helper;
		$this->manager  = $manager;
		$this->template = $template;
	}

	public static function getSubscribedEvents()
	{
		return array(
			'core.delete_posts_before'                    => 'onDeletePost',
			'core.posting_modify_template_vars'           => 'onPostingTemplate',
			'core.notification_manager_add_notifications' => 'onNotification',
			'core.user_add_after'                         => 'onUserAdd',
			'core.user_setup'                             => 'onUserSetup',
			'core.viewtopic_assign_template_vars_before'  => 'onQuickReplyTemplate'
		);
	}

	public function onDeletePost($event)
	{
		$types = $event['delete_notifications_types'];
		$types[] = 'sitesplat.bbmention.notification';
		$event['delete_notifications_types'] = $types;
	}

	public function onNotification($event)
	{
		if ($event['notification_type_name'] === 'notification.type.post')
		{
			$this->manager->add_notifications('sitesplat.bbmention.notification', $event['data']);
		}
	}

	public function onPostingTemplate($event)
	{
		$vars = $event['page_data'];
		$vars['U_S9E_NEMTIONS'] = $this->helper->route('sitesplat.bbmention.controller', array('t' => $event['topic_id']));
		$event['page_data'] = $vars;
	}

	public function onQuickReplyTemplate($event)
	{
		$url = $this->helper->route('sitesplat.bbmention.controller', array('t' => $event['topic_id']));
		$this->template->assign_var('U_S9E_NEMTIONS', $url);
	}

	public function onUserAdd($event)
	{
		global $db;

		$sql = 'INSERT INTO ' . USER_NOTIFICATIONS_TABLE . " (item_type, item_id, user_id, method, notify) VALUES ('sitesplat.bbmention.notification', 0, " . $event['user_id'] . ", '', 0)";
		$db->sql_query($sql);
	}

	public function onUserSetup($event)
	{
		$set = $event['lang_set_ext'];
		$set[] = array(
			'ext_name' => 'sitesplat/bbmention',
			'lang_set' => 'bbmention',
		);
		$event['lang_set_ext'] = $set;
	}
}