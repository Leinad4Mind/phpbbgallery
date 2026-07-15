<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbajaxnews\ajaxnews\driver;

interface driver_interface
{
	public function publish($type, $data);

	public function assign_template_vars();
}
