<?php
/*
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

class player_block extends base
{
	static $icon = 'fa-music';

	public function init()
	{
		$this->tpl_name = 'player_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$player = $this->container->get('canidev.blockgets.controller.player');
		$player->create($data, $this->data['block_id']);

		unset($data);
		return true;
	}

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
				'type'	=> LIST_TYPE_NONE,
			))
			->set_events(array(
				'edit.before'	=> array($this, 'list_edit_before'),
			));

		return true;
	}
	
	public function list_edit_before($event)
	{
		$event['display_vars'] = array(
			'title'		=> array('lang' => 'TRACK_TITLE',	'validate' => 'string:1:255',	'type' => 'text:40:255'),
			'url'		=> array('lang' => 'TRACK_URL',		'validate' => 'regexp',			'type' => 'text:40:255',	'regexp' => array('/^http[s]?:\/\/[^:]+:([0-9]{4,})$/', '/^http[s]?:\/\/(.*)\.(asx|m3u|mp3|pls|wav)$/')),
		);
	}
}
