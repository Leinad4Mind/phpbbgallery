<?php
/**
*
* @package Dropbox Upload
* @copyright (c) 2016 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\dropboxupload\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;
use Kunnu\Dropbox\Exceptions\DropboxClientException;
use \phpbb\config\config;
use \phpbb\user;
use \phpbb\log\log;
use \phpbb\language\language;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var phpbb\language\language */
	protected $language;

	/**
	* Constructor for listener
	*
	* @param \phpbb\config\config		$config		phpBB config
	* @param \phpbb\user				$user		User object
	* @param \phpbb\log\log				$log		phpBB log
	* @param phpbb\language\language	$language	Language object
	*
	* @access public
	*/
	public function __construct(config $config, user $user, log $log, language $language)
	{
		$this->config	= $config;
		$this->user		= $user;
		$this->log		= $log;
		$this->language	= $language;
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
			$filename	= $event['filename'];
			$extension	= $event['extension'];
			$location 	= $event['location'];

			$backup_file = $location . $filename . $extension;

			// Let's make sure that there is some data to process
			if (file_exists($backup_file))
			{
				// Update the frequency count for this run
				$this->config->set('dropbox_frequency_count', $this->config['dropbox_frequency_count'] + 1);

				if ($this->config['dropbox_frequency_count'] >= $this->config['dropbox_frequency_interval'])
				{
					// Reset the frequency count to zero
					$this->config->set('dropbox_frequency_count', 0);

					// Add the language file
					$this->language->add_lang('dropboxupload', 'david63/dropboxupload');

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
						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_DROPBOX_ERROR', time(), array($e->getMessage()));
					}

					if ($upload)
					{
						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_DROPBOX_UPLOAD', time(), array($filename . $extension));
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
}
