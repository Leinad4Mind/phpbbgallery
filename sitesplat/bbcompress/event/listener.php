<?php
/**
*
* BBcompress
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbcompress\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.modify_uploaded_file'						=> 'modify_uploaded_file',
			//'core.avatar_driver_upload_move_file_before'	=> 'avatar_driver_upload_move_file_before',
			'core.get_logs_main_query_before'				=> 'get_logs_main_query_before',
		);
	}

	/* @var \phpbb\config\config */
	protected $config;

	/* @var \phpbb\log\log */
	protected $log;

	/* @var \phpbb\user */
	protected $user;

	/* @var \sitesplat\bbcompress\optimizers\service */
	protected $optimizer;

	/* @var string */
	protected $root_path;

	public function __construct(\phpbb\config\config $config, \phpbb\log\log $log, \phpbb\user $user, \sitesplat\bbcompress\optimizers\service $optimizer, $root_path)
	{
		$this->config = $config;
		$this->log = $log;
		$this->user = $user;
		$this->optimizer = $optimizer;
		$this->root_path = $root_path;
	}

	public function modify_uploaded_file($event)
	{
		if($this->config['bbcompress_allowed_posts'] && $event['is_image'])
		{
			$this->optimizer->optimize_image($this->root_path . $this->config['upload_path'] . '/' . $event['filedata']['physical_filename']);
		}
	}

/*
	public function avatar_driver_upload_move_file_before($event)
	{
		if($this->config['bbcompress_allowed_avatars'])
		{
			$this->optimizer->optimize_image($event['filedata']['filename']);
		}
	}
*/

	public function get_logs_main_query_before()
	{
		$this->user->add_lang_ext('sitesplat/bbcompress', 'logs');
	}
}
