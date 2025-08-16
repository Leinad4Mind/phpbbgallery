<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

use canidev\blockgets\libraries\constants;

class player_block extends base
{
	static $icon = 'fa-music';

	/**
	 * {@inheritDoc}
	 */
	public function init()
	{
		$this->tpl_name = 'player_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		/** @var \canidev\blockgets\controller\player_controller */
		$player = $this->container->get('canidev.blockgets.controller.player');
		
		$player->create($data, $this->data['block_id']);

		unset($data);
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$this->display_vars = array(
			'autoplay'		=> array('lang' => 'PLAYER_AUTOPLAY',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 0),
			'playlist'		=> array('lang' => 'PLAYER_PLAYLIST',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1),
		);
		
		$this->list = $this->container->get('canidev.blockgets.admin.links');
		
		$this->list
			->set_options(array(
				'title'	=> 'PLAYER_TRACKLIST',
				'type'	=> constants::LIST_TYPE_NONE,
			))
			->set_events(array(
				'edit.before'	=> array($this, 'list_edit_before'),
			));

		return true;
	}
	
	/**
	 * Event for list
	 * @param \phpbb\event\data 	$event
	 */
	public function list_edit_before($event)
	{
		$event['display_vars'] = array(
			'title'		=> array('lang' => 'TRACK_TITLE',	'validate' => 'string:1:255',	'type' => 'text:40:255'),
			'url'		=> array('lang' => 'TRACK_URL',		'validate' => 'regexp',			'type' => 'text:40:255',	'regexp' => array('/^http[s]?:\/\/[^:]+:([0-9]{4,})$/', '/^http[s]?:\/\/(.*)\.(asx|m3u|mp3|pls|wav)$/')),
		);
	}
}
