<?php
/**
 *
 * @package Dropbox Upload
 * @copyright (c) 2016 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\dropboxupload\controller;

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;
use Kunnu\Dropbox\Exceptions\DropboxClientException;
use phpbb\config\config;
use phpbb\user;
use phpbb\log\log;
use phpbb\language\language;
use david63\dropboxupload\core\functions;

class main_controller
{
	/** @var config */
	protected $config;

	/** @var user */
	protected $user;

	/** @var log */
	protected $log;

	/** @var language */
	protected $language;

	/** @var functions */
	protected $functions;

	/**
	 * Constructor for main controller
	 *
	 * @param config         $config         phpBB config
	 * @param user           $user           User object
	 * @param log            $log            phpBB log
	 * @param language       $language       Language object
	 * @param functions      $functions      Functions for the extension
	 *
	 * @access public
	 */
	public function __construct(config $config, user $user, log $log, language $language, functions $functions)
	{
		$this->config    = $config;
		$this->user      = $user;
		$this->log       = $log;
		$this->language  = $language;
		$this->functions = $functions;
	}

	/**
	 * Controller for Dropbox process
	 *
	 * @param string     $name
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function processupload($event)
	{
		$extension = $event['extension'];
		$filename  = $event['filename'];
		$location  = $event['location'];

		$backup_file = $location . $filename . $extension;

		// Let's make sure that there is some data to process
		if (file_exists($backup_file))
		{
			// Update the frequency count for this run
			$this->config->set('dropbox_frequency_count', $this->config['dropbox_frequency_count'] + 1, false);

			if ($this->config['dropbox_frequency_count'] >= $this->config['dropbox_frequency_interval'])
			{
				// Reset the frequency count to zero
				$this->config->set('dropbox_frequency_count', 0, false);

				// Add the language file
				$this->language->add_lang('dropboxupload', $this->functions->get_ext_namespace());

				// Get the selected folder option
				switch ($this->config['dropbox_folder_opt'])
				{
					case 'DEFAULT':
						$dropbox_folder = $this->config['dropbox_folder'];
						break;

					case 'CURRENT_DAY':
						$dropbox_folder = date('Y-m-d');
						break;

					case 'DAY_OF_WEEK':
						$dropbox_folder = date('l');
						break;

					case 'WEEK_NO':
						$dropbox_folder = $this->language->lang('WEEK') . date('W');
						break;

					case 'MONTH':
						$dropbox_folder = date('F');
						break;

					case 'YEAR':
						$dropbox_folder = date('Y');
						break;

					case 'MONTH_YEAR':
						$dropbox_folder = date('F') . '-' . date('Y');
						break;
				}

				$dropbox_folder = '/' . $dropbox_folder . '/';

				if ($this->config['dropbox_folder'] && $this->config['dropbox_folder_opt'] != 'DEFAULT')
				{
					$dropbox_folder = '/' . $this->config['dropbox_folder'] . $dropbox_folder;
				}

				//Configure Dropbox Application
				$app = new DropboxApp($this->config['dropbox_key'], $this->config['dropbox_secret'], $this->config['dropbox_token']);

				//Configure Dropbox service
				$dropbox = new Dropbox($app);

				$dropboxFile = new DropboxFile($backup_file);

				$upload = true;
				try
				{
					$file = $dropbox->uploadChunked($dropboxFile, $dropbox_folder . $filename . $extension);
					$file->getName();
				}
				catch (DropboxClientException $e)
				{
					$upload = false;
					$this->log->add('critical', $this->user->data['user_id'], $this->user->ip, 'LOG_DROPBOX_ERROR', time(), [$e->getMessage()]);
				}

				if ($upload)
				{
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_DROPBOX_UPLOAD', time(), [$filename . $extension]);
				}
				else
				{
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_DROPBOX_UPLOAD_FAILED');
				}
			}
		}
		else
		{
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_DROPBOX_NO_FILE');
		}
	}
}
