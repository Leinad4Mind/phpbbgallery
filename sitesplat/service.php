<?php
/**
*
* BBCore.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat;

class service
{
	/** @var \phpbb\user */
	protected $user;

	public function __construct(\phpbb\user $user)
	{
		$this->user = $user;
	}

    public function BBCore_installed()
    {
        return 'test';
    }
}
