<?php
/**
*
* BBreaction
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\bbemoji;

class parser extends \sitesplat\bbemoji\event\listener
{
	public function __construct(array $generators, \phpbb\path_helper $pathHelper, \phpbb\template\template $template, \phpbb\request\request $request, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, $bbemoji_icons_table)
	{
        parent::__construct($generators, $pathHelper, $template, $request, $user, $db, $bbemoji_icons_table);
	}

	public function emoji_render($text)
	{
		return $this->render($text);
	}

	public function emoji_parse($text)
	{
		return $this->parse($text);
	}

	public function emoji_unparse($text)
	{
		return preg_replace(
			'(<!-- sitesplat:bbemoji:([-0-9a-f]+) -->(.*?)<!-- /sitesplat:bbemoji -->)',
			'\2',
			$text
		);
	}
}
