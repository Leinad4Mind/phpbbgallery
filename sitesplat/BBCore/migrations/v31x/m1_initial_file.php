<?php
/**
*
* BBCore.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\migrations\v31x;

/**
* Migration stage 1: Initial data changes to the files
*/
class m1_initial_file extends \phpbb\db\migration\migration
{
	/**
	* Add sitesplat data to the files.
	*
	* @return array Array of files
	* @access public
	*/
	public function update_data()
	{
		$this->revert = false;
		return array(
			array('custom', array(array($this, 'update_acp_pages'))),
		);
	}

	public function revert_data()
	{
		$this->revert = true;
		return array(
			array('custom', array(array($this, 'update_acp_pages'))),
		);
	}

	/**
	* Update files on server
	*
	* @return null
	* @access public
	*/
	public function update_acp_pages()
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
			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, (($this->revert) ? 'LOG_BBCORE_UNINSTALLED' : 'LOG_BBCORE_INSTALLED'), time(), array());
			
		} else
		{
			
			$not_updated = array_diff($files, $files_changed);
			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, (($this->revert) ? 'LOG_BBCORE_NOT_REPLACED' : 'LOG_BBCORE_NOT_UPDATED'), time(), array(implode('<br />', $not_updated)));
			
			$user->lang['EXTENSION_' . (($this->revert) ? 'DELETE_DATA' : 'ENABLE') . '_SUCCESS'] .= '<div style="background:#fafafa;width: 50%;margin:20px auto;padding: 10px;font-size: 14px;"><p style="color: #000;">' .
			(($this->revert) ? '<strong>IMPORTANT!!!</strong><br /><br />NOT all files were updated! Please replace manually the file(s) mentioned in the admin-log under the MAINTENANCE tab.' : '<strong>IMPORTANT!!!</strong><br /><br />Not all updates were implemented properly due to the server file permissions or missing files. <br />See admin log for more details.<br /><br />Please update the files manually to enjoy all functions.') . '</p></div>';
		}
	}

	public function data()
	{
		$replacements = array(
			'files' => array(
				2 => '/includes/functions_content.' . $this->php_ext,
				3 => '/includes/ucp/ucp_prefs.' . $this->php_ext,
				),
			'searches' => array(
				2 => array('$sort_ary[\'output\'] = \'<select name="\' . $name . \'" id="\' . $name . \'">\';'),
				3 => array(
						0 => '${\'s_limit_\' . $sort_option . \'_days\'} = \'<select name="\' . $sort_option . \'_st">\';',
						1 => '${\'s_sort_\' . $sort_option . \'_key\'} = \'<select name="\' . $sort_option . \'_sk">\';',
						2 => '${\'s_sort_\' . $sort_option . \'_dir\'} = \'<select name="\' . $sort_option . \'_sd">\';'
					),
				),
			'replaces' => array(
				2 => array('$sort_ary[\'output\'] = \'<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body" name="\' . $name . \'" id="\' . $name . \'">\';'),
				3 => array(
					0 => '${\'s_limit_\' . $sort_option . \'_days\'} = \'<select class="selectpicker" data-container="body" name="\' . $sort_option . \'_st">\';',
					1 => '${\'s_sort_\' . $sort_option . \'_key\'} = \'<select class="selectpicker" data-container="body" name="\' . $sort_option . \'_sk">\';',
					2 => '${\'s_sort_\' . $sort_option . \'_dir\'} = \'<select class="selectpicker" data-container="body" name="\' . $sort_option . \'_sd">\';'),
				)
			);
		return $replacements;
	}
}
