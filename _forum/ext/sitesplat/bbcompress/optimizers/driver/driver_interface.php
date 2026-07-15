<?php
/**
*
* BBcompress
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbcompress\optimizers\driver;

/**
* An interface that all image optimizer drivers must implement
*/
interface driver_interface
{
	/**
	* Optimize image
	*
	* @param string $img_src	Image location
	* @return null
	*/
	public function optimize_image($img_src);
}
