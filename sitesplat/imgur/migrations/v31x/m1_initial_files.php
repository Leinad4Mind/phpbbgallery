<?php
/**
*
* Imgur - forum images uploader
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\imgur\migrations\v31x;

/**
* Migration stage 1: Initial data changes to the files
*/
class m1_initial_files extends \phpbb\db\migration\migration
{
	/**
	 * Assign migration file dependencies for this migration
	 *
	 * @return array Array of migration files
	 * @static
	 * @access public
	 */
	static public function depends_on()
	{
		return array('\sitesplat\BBCore\migrations\v31x\m1_initial_file');
	}

	/**
	 * Add or update files in the board
	 * @access public
	*/
	public function update_data()
	{
		$this->revert = false;
		return array(
			array('config.add', array('imgur_clientid', '')),
			array('custom', array(array($this, 'install_imgur'))),
		);
	}

	public function revert_data()
	{
		$this->revert = true;
		return array(
			array('custom', array(array($this, 'install_imgur'))),
		);
	}

	/**
	 * Edit files in the board
	 *
	 * @return null
	 * @access public
	 */
	public function install_imgur()
	{
		$this->replacements = $this->data();
		$files = $this->replacements['files'];
		$searches = ($this->revert) ? $this->replacements['replaces'] : $this->replacements['searches'];
		$replace = ($this->revert) ? $this->replacements['searches'] : $this->replacements['replaces'];
		$i = $j = 0;
		$files_changed = array();
		foreach($files as $key => $file)
		{
			if (is_writable($this->phpbb_root_path . $file))
			{
				$fp = @fopen($this->phpbb_root_path . $file , 'r' );
				if ($fp === false) continue;
				$content = fread( $fp, filesize($this->phpbb_root_path . $file) );
				(!$this->revert) ? copy($this->phpbb_root_path . $file, $this->phpbb_root_path . $file . '.bak') : null;
				fclose($fp); 
				foreach($searches[$key] as $key2 => $search)
				{
					if ($this->revert || strpos($content, $replace[$key][$key2]) === false)
					{
						$content = str_replace($search, $replace[$key][$key2], $content);
						($key2 == 0) ? $i++ : $i;
					}
				}
				if ($i != $j)
				{
					$new_file = $files[$key];
					$fp = @fopen($this->phpbb_root_path . $new_file , 'w' ); 	
					if ($fp === false) continue;
					$fwrite = fwrite($fp, $content);	
					fclose($fp);
					if ($fwrite !== false) 
					{
						$j = $i;
						$files_changed[] = $new_file;
					}
				}
			}
		}
		
		global $phpbb_log, $user;
		if (sizeof($files) == sizeof($files_changed))
		{
			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, (($this->revert) ? 'LOG_IMGUR_DEINSTALLED' : 'LOG_IMGUR_INSTALLED'), time(), array());
			
		} else
		{
			$not_updated = array_diff($files, $files_changed);
			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, (($this->revert) ? 'LOG_IMGUR_NOT_REPLACED' : 'LOG_IMGUR_NOT_UPDATED'), time(), array(implode('<br />', $not_updated)));
			
			$user->lang['EXTENSION_' . (($this->revert) ? 'DELETE_DATA' : 'ENABLE') . '_SUCCESS'] .= '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">' .
			(($this->revert) ? 'Not all files are replaced! Please replace by hand the file(s) mentioned in the admin-log' : 'Config setting of this extension are not nessecary.<br />However not all updates are done properly because of filepermissions or missing files. See admin log for a overview.<br /><br />Please update files by hand to enjoy all functions!') . '</p></div>';;
		}
	}


	public function data()
	{
		$replacements = array(
			'files' => array(
				0 => '/posting.' . $this->php_ext,
				1 => '/includes/acp/acp_attachments.' . $this->php_ext
				),
			'searches' => array(
				0 => array(
						0 => '$refresh	= (isset($_POST[\'add_file\'])',
						1 => '// Parse Attachments - before checksum is calculated',
					),
				1 => array(
						0 => 'global $db, $user, $auth, $template, $cache, $phpbb_container;',
						1 => '$this->new_config = $config;'
					),
				),
			'replaces' => array(
				0 => array(
					0 => '$refresh	= (isset($_POST[\'add_image\']) || isset($_POST[\'add_file\'])',
					1 => '$upload = $request->file(\'imgur\');
	if (!empty($upload) && $upload[\'name\'] != \'none\' && trim($upload[\'name\'])) 
	{
		$client_id = $config[\'imgur_clientid\'];
		$filename = $upload[\'tmp_name\'];
		$handle = fopen($filename, \'r\');
		$data = fread($handle, filesize($filename));
		$pvars = array(\'image\' => base64_encode($data));

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_URL => \'https://api.imgur.com/3/image.json\',
			CURLOPT_TIMEOUT => 30,
			CURLOPT_POST => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HTTPHEADER => array("Authorization: Client-ID $client_id"),
			CURLOPT_POSTFIELDS => $pvars
		));

		$json_returned = curl_exec($curl);
		curl_close ($curl); 

		$pms = json_decode($json_returned, true);
		if (!empty($pms[\'data\'][\'link\'])) 
		{
			$template->assign_vars(array(
				\'IMGUR_IMAGE\'		=>  "\n[img]{$pms[\'data\'][\'link\']}[/img]",
				\'IMGUR_DIRECT_IMG\'	=>  "\n[img]{$pms[\'data\'][\'link\']}[/img]",
				\'IMGUR_DIRECT_LINK\'	=>  "\n{$pms[\'data\'][\'link\']}",
				\'IMGUR_DELETEHASH\'	=>  $pms[\'data\'][\'deletehash\'],
			));
		} else 
		{
			$error[] = $pms[\'data\'][\'error\'];
		}
	}

	// Parse Attachments - before checksum is calculated',
		),
			1 => array(
				0 => 'global $db, $user, $auth, $template, $cache, $phpbb_container, $phpbb_dispatcher;',
				1 => '/**
				* Event to add and/or modify acp_attachement configurations
				*
				* @event core.acp_attachments_config_edit_add
				* @var	array	display_vars	Array of config values to display and process
				* @var	string	mode			Mode of the config page we are displaying
				* @var	boolean	submit			Do we display the form or process the submission
				* @since 3.1.6
				*/
				$vars = array(\'display_vars\', \'mode\', \'submit\');
				extract($phpbb_dispatcher->trigger_event(\'core.acp_attachments_config_edit_add\', compact($vars)));
				
				$this->new_config = $config;'
				),
			),
		);
		return $replacements;
	}
}
