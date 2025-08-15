<?php
/**
*
* Board Rules extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace sitesplat\avatarsplus\controller;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
* Main controller
*/
class main_controller
{
	protected $request;
	protected $user;
	protected $ext_root_path;
	public function __construct(\phpbb\request\request $request, \phpbb\user $user, $ext_root_path)
	{
		$this->request = $request;
		$this->user = $user;
		$this->ext_root_path = $ext_root_path;
	}

	public function json_data($gender)
	{
		return new BinaryFileResponse($this->ext_root_path . 'json/' . $gender . '.json');
	}
}
