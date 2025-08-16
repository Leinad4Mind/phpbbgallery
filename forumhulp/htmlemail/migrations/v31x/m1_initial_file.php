<?php
/**
*
* HTML email.
*
* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace forumhulp\htmlemail\migrations\v31x;

/**
* Migration stage 1: Initial data changes to the files
*/
class m1_initial_file extends \phpbb\db\migration\migration
{
	/**
	* Add core change to the files.
	*
	* @return array Array of files
	* @access public
	*/
	public function update_data()
	{
		$this->revert = false;
		return array(
			array('custom', array(array($this, 'update_functions_messenger'))),
		);
	}

	public function revert_data()
	{
		$this->revert = true;
		return array(
			array('custom', array(array($this, 'update_functions_messenger'))),
		);
	}

	/**
	* Update files on server
	*
	* @return null
	* @access public
	*/
	public function update_functions_messenger()
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
			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, (($this->revert) ? 'LOG_CORE_DEINSTALLED' : 'LOG_CORE_INSTALLED'), time(), array());
			
		} else
		{
			$not_updated = array_diff($files, $files_changed);
			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, (($this->revert) ? 'LOG_CORE_NOT_REPLACED' : 'LOG_CORE_NOT_UPDATED'), time(), array(implode('<br />', $not_updated)));
			
			$user->lang['EXTENSION_' . (($this->revert) ? 'DELETE_DATA' : 'ENABLE') . '_SUCCESS'] .= '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">' .
			(($this->revert) ? 'Not all files are replaced! Please replace by hand the file(s) mentioned in the admin-log' : 'Config setting of this extension are not nessecary.<br />However not all updates are done properly because of filepermissions or missing files. See admin log for a overview.<br /><br />Please update files by hand to enjoy all functions!') . '</p></div>';;
		}
	}
	
	public function data()
	{
		$replacements = array(
			'files' => array(
				0 => '/includes/functions_messenger.' . $this->php_ext,
				),
			'searches' => array(
				0 => array(
					0 => '	var $use_queue = true;',
					1 => '		$this->subject = \'\';',
					2 => '		$this->mail_priority = $priority;',
					3 => '$headers[] = \'Content-Type: text/plain; charset=UTF-8\';',
					4 => '\'EMAIL_SIG\'	=> str_replace(\'<br />\', "\n", "-- \n" . htmlspecialchars_decode($config[\'board_email_sig\'])),',
					5 => '\'SITENAME\'	=> htmlspecialchars_decode($config[\'sitename\']),',					)
				),
			'replaces' => array(
				0 => array(
					0 => '	var $use_queue = true;
	var $use_html = false;',
					1 => '		$this->subject = \'\';
		$this->use_html = false;',
					2 => '		$this->mail_priority = $priority;
	}
	
	/**
	* Set the email html
	*/
	function set_mail_html($html = false)
	{
		$this->use_html = $html;',
					3 => '$headers[] = \'Content-Type: \' . (($this->use_html) ? \'text/html;\' : \'text/plain;\')  . \' charset=UTF-8\';',
					4 => '\'EMAIL_SIG\'	=> "-- \n" . $config[\'board_email_sig\'],',
					5 => '\'SITENAME\'	=> $config[\'sitename\'],',
					)
				)
			);
		return $replacements;
	}
}
