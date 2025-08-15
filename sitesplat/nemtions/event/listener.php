<?php

/**
* @package   BB@mention_user
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*/
namespace sitesplat\nemtions\event;

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
			'core.delete_posts_before'                   => 'onDeletePost',
			'core.posting_modify_template_vars'          => 'onPostingTemplate',
			'core.submit_post_end'                       => 'onSubmit',
			'core.user_setup'                            => 'onUserSetup',
			'core.viewtopic_assign_template_vars_before' => 'onQuickReplyTemplate'
		);
	}

	public function onDeletePost($event)
	{
		$types = $event['delete_notifications_types'];
		$types[] = 'sitesplat.nemtions.notification';
		$event['delete_notifications_types'] = $types;
	}

	public function onPostingTemplate($event)
	{
		$vars = $event['page_data'];
		$vars['U_S9E_NEMTIONS'] = $this->helper->route('sitesplat.nemtions.controller', array('t' => $event['topic_id']));
		$event['page_data'] = $vars;
	}

	public function onQuickReplyTemplate($event)
	{
		$url = $this->helper->route('sitesplat.nemtions.controller', array('t' => $event['topic_id']));
		$this->template->assign_var('U_S9E_NEMTIONS', $url);
	}

	public function onUserSetup($event)
	{
		$set = $event['lang_set_ext'];
		$set[] = array(
			'ext_name' => 'sitesplat/nemtions',
			'lang_set' => 'nemtions',
		);
		$event['lang_set_ext'] = $set;
	}

	public function onSubmit($event)
	{
		$data = $event['data'] + array(
			'post_subject'  => 'POST_SUBJECT',
			'post_time'     => time(),
			'post_username' => ''
		);

		$this->manager->add_notifications('sitesplat.nemtions.notification', $data);
	}
}