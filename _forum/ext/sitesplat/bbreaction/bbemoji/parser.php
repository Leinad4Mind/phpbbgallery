<?php
/**
*
* BB reaction.
*
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\bbemoji;

class parser extends \sitesplat\bbemoji\event\listener
{
	public function __construct(array $generators, \phpbb\path_helper $pathHelper)
	{
        parent::__construct($generators, $pathHelper);
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
