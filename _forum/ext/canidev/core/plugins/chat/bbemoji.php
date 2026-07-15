<?php
/*
* @package cBB Chat Plugin
* @version v1.0.0 22/04/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\core\plugins\chat;

class bbemoji extends \canidev\core\plugins\base
{
	public $name = 'sitesplat/bbemoji';

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
		return array(
			'chat.topics_query'			=> 'topics_query',
			'chat.modify_message_row'	=> 'modify_message_row',
		);
	}

	/**
	 * Modify topics query in the chat
	 *
	 * @param \phpbb\event\data 	$event
	 */
	public function topics_query($event)
	{
		$sql_array = $event['sql_array'];

		if(!isset($sql_array['LEFT_JOIN']))
		{
			$sql_array['LEFT_JOIN'] = array();
		}

		$sql_array['SELECT'] .= ', f.enable_subject_emoji';

		$sql_array['LEFT_JOIN'][] = array(
			'FROM'	=> array(FORUMS_TABLE => 'f'),
			'ON'	=> 'f.forum_id = t.forum_id',
		);

		$event['sql_array'] = $sql_array;
	}

	/**
	 * Modify chat message
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function modify_message_row($event)
	{
		if(!empty($event['row']['enable_subject_emoji']))
		{
			$bbemoji_listener 	= $this->container->get('sitesplat.bbemoji.listener');
			$ary 				= $event['ary'];

			$ary['TOPIC_TITLE'] = $bbemoji_listener->render($bbemoji_listener->parse($ary['TOPIC_TITLE']));

			$event['ary'] = $ary;
		}
	}
}