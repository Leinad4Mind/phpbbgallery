<?php
/**
*
* @package Dropbox Upload
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\dropboxupload\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use phpbb\config\config;
use david63\dropboxupload\controller\main_controller;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \david63\dropboxupload\controller\main_controller */
	protected $processuploadt;

	/**
	* Constructor for listener
	*
	* @param \phpbb\config\config								$config				phpBB config
	* @param \david63\dropboxupload\controller\main_controller	$main_controller	Main controller
	*
	* @access public
	*/
	public function __construct(config $config, main_controller $main_controller)
	{
		$this->config			= $config;
		$this->main_controller	= $main_controller;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'david63.autodbbackup.backup_file_export' => 'dropbox_upload',
		);
	}

	/**
	* Upload the backup file to a Dropbox account
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function dropbox_upload($event)
	{
		if ($this->config['dropbox_upload_enable'])
		{
			$this->main_controller->processupload($event);
		}
	}
}
