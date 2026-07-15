<?php
/*
* @package cBB Blockgets
* @version v2.0.3 26/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

class steam_block extends base
{
	static $icon = 'fa-steam';

	public $regexp = '#^https?:\/\/(?:www\.)?steamcommunity\.com/groups/([^/]+).*$#';

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

			$this->template->assign_vars(array(
				'S_STEAM_AVATAR'	=> (string)$xml->groupDetails->avatarFull,
				'S_STEAM_SUMMARY'	=> (string)$xml->groupDetails->summary,
				'S_STEAM_IN_GAME'	=> (int)$xml->groupDetails->membersInGame,
				'S_STEAM_MEMBERS'	=> (int)$xml->groupDetails->memberCount,
				'S_STEAM_NAME'		=> (string)$xml->groupDetails->groupName,
				'S_STEAM_ONLINE'	=> (int)$xml->groupDetails->membersOnline,

				'U_STEAM_URL'		=> $data['url'],
			));

			\libxml_clear_errors();
			\libxml_use_internal_errors($err_status);

			unset($data);
			return true;
		}

		return false;
	}

	public function get_config()
	{
		$this->display_vars = array(
			'url'	=> array('lang' => 'STEAM_GROUP_URL',		'validate' => 'regexp',		'regexp' => $this->regexp,	'type' => 'text:40:255',	'default' => ''),
		);
	
		return true;
	}
	
	/*private function get($mode, $params)
	{
		$params['key'] = base64_decode(BLG_GOOGLE_KEY);
		
		$data	= '';
		$url	= $this->api_url . $mode . '?' . http_build_query($params, '', '&');

		if(function_exists('curl_init'))
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			$data = json_decode(curl_exec($curl), true);
			curl_close($curl);
		}
		else if($content = @file_get_contents($url))
		{
			$data = json_decode($content, true);
			unset($content);
		}
		
		return (is_array($data) ? $data : array());
	}*/
}
