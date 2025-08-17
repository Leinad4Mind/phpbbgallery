<?php
/**
*
* @package Dropbox Upload
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\dropboxupload\controller;

/**
* Interface for our main controller
*
* This describes all of the methods we'll use for the front-end of this extension
*/
interface main_interface
{
	/**
	* Process the Dropbox upload
	*
	* @param $name
	*
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	* @access public
	*/
	public function processupload($event);
}
