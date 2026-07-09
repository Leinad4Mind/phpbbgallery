<?php
/**
*
* @package Two Factor Authentication
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\tfa\helper;

use sitesplat\u2f\Registration;

class registration_helper extends Registration
{
	private $id = 0;

	/**
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
}
