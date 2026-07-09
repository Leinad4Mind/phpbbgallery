<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class steam_block extends base
{
	static $icon = 'fa-steam';

	public $regexp = '#^https?:\/\/(?:www\.)?steamcommunity\.com/groups/([^/]+).*$#';

	/**
	 * {@inheritDoc}
	 */
	public function init($method = '')
	{
		$this->tpl_name = 'steam_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		if(preg_match($this->regexp, $data['url'], $match))
		{
			$err_status = \libxml_use_internal_errors(true);

			$xml = \simplexml_load_file('https://steamcommunity.com/groups/' . $match[1] . '/memberslistxml/');

			$this->template->assign_vars([
				'S_STEAM_AVATAR'	=> (string)$xml->groupDetails->avatarFull,
				'S_STEAM_SUMMARY'	=> (string)$xml->groupDetails->summary,
				'S_STEAM_IN_GAME'	=> $this->format_number((int)$xml->groupDetails->membersInGame),
				'S_STEAM_MEMBERS'	=> $this->format_number((int)$xml->groupDetails->memberCount),
				'S_STEAM_NAME'		=> (string)$xml->groupDetails->groupName,
				'S_STEAM_ONLINE'	=> $this->format_number( (int)$xml->groupDetails->membersOnline),

				'U_STEAM_URL'		=> $data['url'],
			]);

			\libxml_clear_errors();
			\libxml_use_internal_errors($err_status);

			unset($data);
			return true;
		}

		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$this->display_vars = [
			'url'	=> ['lang' => 'STEAM_GROUP_URL',		'validate' => 'regexp',		'regexp' => $this->regexp,	'type' => 'text:40:255',	'default' => ''],
		];
	
		return true;
	}

	/**
	 * Format with short value and unit label
	 * 
	 * @param int 		$num
	 * @return string
	 */
	protected function format_number($num)
	{
		$units = ['', 'K', 'M', 'B', 'T'];
		
		for($i = 0; $num >= 1000; $i++)
		{
			$num /= 1000;
		}
		
		return round($num, 1) . $units[$i];
	}
}
