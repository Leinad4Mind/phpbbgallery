<?php
/**
 * @package cBB QuickMod Plugin
 * @version 1.0.4 20/10/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\core\plugins\quickmod;

use Symfony\Component\DependencyInjection\ContainerInterface;

class bbemoji extends \canidev\core\plugins\base
{
	public $name = 'sitesplat/bbemoji';

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	public function __construct(ContainerInterface $container)
	{
		$this->db = $container->get('dbal.conn');

		parent::__construct($container);
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function is_runnable()
	{
		return $this->container->get('ext.manager')->is_enabled($this->name);
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function core_events()
	{
		return [
			'canidev.core.modal_dialog'		=> 'on_modal_dialog',
			'quickmod.after_ajax_action'	=> 'after_ajax_action',
		];
	}

	/**
	 * canidev.core.modal_dialog
	 * @param \phpbb\event\data 	$event
	 */
	public function on_modal_dialog($event)
	{
		if($event['title'] == 'CHANGE_ICON')
		{
			/** @var \sitesplat\bbemoji\event\listener */
			$bbemoji_listener = $this->container->get('sitesplat.bbemoji.listener');

			$bbemoji_listener->replaceTopicIcons(array(
				'post_data' 	=> ['icon_id' => 0]
			));
		}
	}
	
	/**
	 * quickmod.after_ajax_action
	 * @param \phpbb\event\data 	$event
	 */
	public function after_ajax_action($event)
	{
		if($event['action'] == 'rename')
		{
			/** @var \sitesplat\bbemoji\event\listener */
			$bbemoji_listener = $this->container->get('sitesplat.bbemoji.listener');

			$sql = 'SELECT f.enable_subject_emoji
				FROM ' . TOPICS_TABLE . ' t
				LEFT JOIN ' . FORUMS_TABLE . ' f ON(f.forum_id = t.forum_id)
				WHERE t.topic_id = ' . (int)$event['topic_ids'][0];
			$result = $this->db->sql_query($sql);
			$enable_emoji = (bool)$this->db->sql_fetchfield('enable_subject_emoji');
			$this->db->sql_freeresult($result);

			if($enable_emoji)
			{
				$event['response']->add('message', $bbemoji_listener->render($bbemoji_listener->parse($event['response']->get('message'))));
			}
		}
	}
}
