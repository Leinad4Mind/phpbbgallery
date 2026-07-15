<?php
/**
* Force https extension for the phpBB Forum Software package.
* @copyright (c) 2017 sitesplat.com <http://sitesplat.com>
* @license Proprietary
*/
namespace sitesplat\forcehttps\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return [
			'core.ucp_profile_avatar_sql'          => 'onAvatarSave',
			'core.text_formatter_s9e_render_after' => 'onRender'
		];
	}

	public function onAvatarSave($event)
	{
		$result = $event['result'];
		if (isset($result['user_avatar'], $result['user_avatar_type'])
		 && $result['user_avatar_type'] === 'avatar.driver.remote')
		{
			$result['user_avatar'] = preg_replace('(^http:)i', 'https:', $result['user_avatar']);
			$event['result'] = $result;
		}
	}

	public function onRender($event)
	{
		$html = $event['html'];
		
		if (strpos($html, '://') === false)
		{
			return;
		}

		$html = preg_replace(
			'(<(?>a\\b[^>]*\\bhref|img\\b[^>]*\\bsrc)="http(?=://))Ui',
			'$0s',
			$html
		);

		$event['html'] = preg_replace(
			'((<(?>a\\b[^>]*\\bhref|img\\b[^>]*\\bsrc)="https(?=://)\\S+photobucket.com\\S+)")Ui',
			'$1~original"',
			$html
		);
	}
}