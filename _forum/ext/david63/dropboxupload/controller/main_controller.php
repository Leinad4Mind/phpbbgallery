<?php
/**
 * @package Dropbox Upload
 * @copyright (c) 2016 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\dropboxupload\controller;

use david63\dropboxupload\core\dropbox_client;
use david63\dropboxupload\core\upload_policy;
use phpbb\config\config;
use phpbb\config\db_text;
use phpbb\log\log;
use phpbb\user;

class main_controller
{
	protected $config;
	protected $config_text;
	protected $user;
	protected $log;
	protected $dropbox;
	protected $root_path;

	public function __construct(config $config, db_text $config_text, user $user, log $log, dropbox_client $dropbox, $root_path)
	{
		$this->config = $config;
		$this->config_text = $config_text;
		$this->user = $user;
		$this->log = $log;
		$this->dropbox = $dropbox;
		$this->root_path = $root_path;
	}

	public function process_upload($event)
	{
		try
		{
			return $this->process($event);
		}
		catch (\Throwable $exception)
		{
			$this->log_failure($exception);
			return false;
		}
	}
	protected function process($event)
	{
		$frequency = (int) $this->config['dropbox_frequency_interval'];
		$folder_option = (string) $this->config['dropbox_folder_opt'];
		upload_policy::validate_options($folder_option, $frequency);
		$count = max(0, (int) $this->config['dropbox_frequency_count']) + 1;
		$this->config->set('dropbox_frequency_count', min($count, $frequency), false);
		if ($count < $frequency)
		{
			return false;
		}

		$filename = (string) $event['filename'];
		$extension = (string) $event['extension'];
		$local_path = upload_policy::resolve_backup_path($this->root_path, (string) $event['location'], $filename, $extension);
		$credentials = $this->get_credentials();
		upload_policy::validate_credentials($credentials, true);
		$timezone = $this->user->timezone instanceof \DateTimeZone ? $this->user->timezone->getName() : 'UTC';
		$remote_path = upload_policy::build_remote_path(
			(string) $this->config['dropbox_folder'],
			$folder_option,
			$filename . $extension,
			time(),
			$timezone
		);
		$metadata = $this->dropbox->upload($local_path, $remote_path, $credentials);
		if (empty($metadata['name']))
		{
			throw new \RuntimeException('DROPBOX_RESPONSE_INVALID');
		}

		$this->config->set('dropbox_frequency_count', 0, false);
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_DROPBOX_UPLOAD', time(), array($filename . $extension));
		return true;
	}
	protected function get_credentials()
	{
		$keys = array('dropbox_app_key', 'dropbox_app_secret', 'dropbox_refresh_token', 'dropbox_access_token');
		return array_replace(array_fill_keys($keys, ''), $this->config_text->get_array($keys));
	}
	protected function log_failure(\Throwable $exception)
	{
		$message = substr(preg_replace('#[\x00-\x1F\x7F]+#', ' ', $exception->getMessage()), 0, 500);
		$this->log->add('critical', $this->user->data['user_id'], $this->user->ip, 'LOG_DROPBOX_ERROR', time(), array($message));
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_DROPBOX_UPLOAD_FAILED');
	}
}
