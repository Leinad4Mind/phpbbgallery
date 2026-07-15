<?php

namespace canidev\core\plugins\quickmod;

class bbemoji extends \canidev\core\plugins\base
{
	public $name = 'sitesplat/bbemoji';

	protected $db;

	public function __construct($container)
	{
		$this->container 	= $container;
		$this->db 			= $container->get('dbal.conn');
	}
	
	public function is_runnable()
	{
		return $this->container->get('ext.manager')->is_enabled($this->name);
	}
	
	public function core_events()
	{
		return array(
			'quickmod.after_ajax_action'	=> 'after_ajax_action',
		);
	}
	
	public function after_ajax_action($event)
	{
		if($event['action'] == 'rename')
		{
			$sql = 'SELECT f.enable_subject_emoji
				FROM ' . TOPICS_TABLE . ' t
				LEFT JOIN ' . FORUMS_TABLE . ' f ON(f.forum_id = t.forum_id)
				WHERE t.topic_id = ' . (int)$event['topic_ids'][0];
			$result = $this->db->sql_query($sql);
			$enable_emoji = (bool)$this->db->sql_fetchfield('enable_subject_emoji');
			$this->db->sql_freeresult($result);

			if($enable_emoji)
			{
				$bbemoji_listener = $this->container->get('sitesplat.bbemoji.listener');

				$event['new_data'] = $bbemoji_listener->render($bbemoji_listener->parse($event['new_data']));
			}
		}
	}
}