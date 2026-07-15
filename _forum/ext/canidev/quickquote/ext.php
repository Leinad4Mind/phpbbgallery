<?php
/*
* @package cBB QuickQuote
* @version v1.0.1 10/02/2019
*
* @copyright (c) 2019 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickquote;

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		$config = $this->container->get('config');
		return phpbb_version_compare($config['version'], '3.2.0', '>=');
	}
}
