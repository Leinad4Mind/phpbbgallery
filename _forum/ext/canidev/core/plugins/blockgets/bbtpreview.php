<?php

namespace canidev\core\plugins\blockgets;

class bbtpreview extends \canidev\core\plugins\base
{
	public $name = 'sitesplat/bbtpreview';

	protected $template;
	protected $loaded = false;

	public function __construct($container)
	{
		$this->container 	= $container;
		$this->template 	= $container->get('template');
	}
	
	public function is_runnable()
	{
		return $this->container->get('ext.manager')->is_enabled($this->name);
	}
	
	public function core_events()
	{
		return array(
			'core.viewforum_modify_topicrow'	=> 'viewforum_modify_topicrow',
		);
	}

	public function viewforum_modify_topicrow($event)
	{
		if(!isset($event['topic_row']['TOPIC_ID']) && isset($event['row']['topic_id']))
		{
			$topic_row = $event['topic_row'];
			$topic_row['TOPIC_ID'] = $event['row']['topic_id'];
			$event['topic_row'] = $topic_row;
		}

		if(!$this->loaded)
		{
			$this->template->assign_var('BB_LOAD_IN_POSTING', true);
			$this->loaded = true;
		}
	}
}
