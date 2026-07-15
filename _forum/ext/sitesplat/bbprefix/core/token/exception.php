<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\core\token;

/**
* Prefixed token exception
*
* @package prefixed
*/
class exception extends \Exception
{
	public function __toString()
	{
		return $this->getMessage();
	}
}
