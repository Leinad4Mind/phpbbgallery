<?php
/**
*
* @package Dropbox Upload
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace leinad4mind\dropboxupload\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use phpbb\config\config;
use leinad4mind\dropboxupload\controller\main_controller;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var main_controller */
	protected $main_controller;
	/**
	* Constructor for listener
	*
	* @param \phpbb\config\config								$config				phpBB config
	* @param main_controller $main_controller Main controller
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
	public static function getSubscribedEvents()
	{
		return array(
			'leinad4mind.autodbbackup.backup_file_export' => 'dropbox_upload',
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
		if (!empty($this->config['dropbox_upload_enable']))
		{
			$this->main_controller->process_upload($event);
		}
	}
}
