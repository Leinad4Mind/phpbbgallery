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
				0 => '/adm/style/acp_styles.html',
				1 => '/includes/acp/acp_styles.' . $this->php_ext,
				2 => '/includes/functions_content.' . $this->php_ext,
				3 => '/includes/ucp/ucp_prefs.' . $this->php_ext,
				4 => '/phpbb/avatar/driver/gravatar.' . $this->php_ext,
				5 => '/includes/functions.' . $this->php_ext,
				6 => '/viewtopic.' . $this->php_ext,
				7 => '/memberlist.' . $this->php_ext
				),
			'searches' => array(
				0 => array('<!-- IF .styles_list -->'),
				1 => array('		$this->mode = $mode;'),
				2 => array('$sort_ary[\'output\'] = \'<select name="\' . $name . \'" id="\' . $name . \'">\';'),
				3 => array(
						0 => '${\'s_limit_\' . $sort_option . \'_days\'} = \'<select name="\' . $sort_option . \'_st">\';',
						1 => '${\'s_sort_\' . $sort_option . \'_key\'} = \'<select name="\' . $sort_option . \'_sk">\';',
						2 => '${\'s_sort_\' . $sort_option . \'_dir\'} = \'<select name="\' . $sort_option . \'_sd">\';'
					),
				4 => array('$url .= \'?s=\' . max($row[\'avatar_width\'], $row[\'avatar_height\']);'),
				5 => array('SITE_LOGO_IMG\'			=> $user->img(\'site_logo\'),'),
				6 => array('U_VIEW_TOPIC\' 			=> $viewtopic_url,'),
				7 => array('$cp->generate_profile_fields_template_data($profile_fields_cache[$user_id], false)')
				),
			'replaces' => array(
				0 => array('<!-- IF .styles_list -->
<!-- EVENT acp_styles_before_table -->'),
				1 => array('		$this->mode = $mode;
		global $phpbb_dispatcher;
		/**
		* Use this event to add info to style form
		*
		* @event core.acp_style_before_table
		* @since 3.1.3
		*/
		$vars = array();
		$phpbb_dispatcher->trigger_event(\'core.acp_style_before_table\', compact($vars));'),
				2 => array('$sort_ary[\'output\'] = \'<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body" name="\' . $name . \'" id="\' . $name . \'">\';'),
				3 => array(
					0 => '${\'s_limit_\' . $sort_option . \'_days\'} = \'<select class="selectpicker" data-container="body" name="\' . $sort_option . \'_st">\';',
					1 => '${\'s_sort_\' . $sort_option . \'_key\'} = \'<select class="selectpicker" data-container="body" name="\' . $sort_option . \'_sk">\';',
					2 => '${\'s_sort_\' . $sort_option . \'_dir\'} = \'<select class="selectpicker" data-container="body" name="\' . $sort_option . \'_sd">\';'),
				4 => array('$url .= \'?d=identicon&amp;s=\' . max($row[\'avatar_width\'], $row[\'avatar_height\']);'),
				5 => array('SITE_LOGO_IMG\'			=> $user->img(\'site_logo\'),' . "\n" . 
						 '		\'USER_EMAIL_MENU\'		=> $user->data[\'user_email\'],'. "\n" . 
						 '		\'BOARD_EMAIL\'			=>  $config[\'board_contact\'],'. "\n" . 
						 '		\'SITESPLAT_SEARCH_WEEK\'			=> append_sid("{$phpbb_root_path}search.$phpEx", \'search_id=active_topics&amp;tp=7&amp;st=7\'),' . "\n" .
						 '		\'SITESPLAT_SEARCH_LAST_DAY\'		=> append_sid("{$phpbb_root_path}search.$phpEx", \'search_id=active_topics&amp;tp=1&amp;st=1\'),' . "\n" . 
						 '		\'U_UCP_PREFERENCE\'				=> append_sid("{$phpbb_root_path}ucp.$phpEx", \'i=prefs\'),' . "\n" . 
						 '		\'U_UCP_PREFERENCE_SETTINGS\'		=> append_sid("{$phpbb_root_path}ucp.$phpEx", \'i=prefs&amp;mode=personal\'),'. "\n" . 
						 '		\'U_UCP_PROFILE_SETTINGS\'			=> append_sid("{$phpbb_root_path}ucp.$phpEx", \'i=profile&amp;mode=reg_details\'),'. "\n" .
						 '		\'U_UCP_PROFILE_AVATAR\'			=> append_sid("{$phpbb_root_path}ucp.$phpEx", \'i=profile&amp;mode=avatar\'),'. "\n" . 
						 '		\'U_UCP_ZEBRA_FRIENDS\'			    => append_sid("{$phpbb_root_path}ucp.$phpEx", \'i=zebra&amp;mode=friends\'),'. "\n" . 
						 '		\'U_UCP_PM_INBOX\'				    => append_sid("{$phpbb_root_path}ucp.$phpEx", \'i=pm&amp;folder=inbox\'),'. "\n" . 
						 '		\'U_UCP_PM_OUTBOX\'				    => append_sid("{$phpbb_root_path}ucp.$phpEx", \'i=pm&amp;folder=outbox\'),'. "\n" . 
						 '		\'U_UCP_PM_SENTBOX\'				=> append_sid("{$phpbb_root_path}ucp.$phpEx", \'i=pm&amp;folder=sentbox\'),'						 
					 ),
				6 => array('U_VIEW_TOPIC\' 			=> $viewtopic_url,' . "\n" . '	\'BOOKMARK_CLASS\'		=> ($user->data[\'is_registered\'] && $config[\'allow_bookmarks\'] && $topic_data[\'bookmarked\']) ? \'fa fa-star\' : \'fa fa-star-o\','),
				7 => array('$cp->generate_profile_fields_template_data($profile_fields_cache[$user_id], true)')
				)
			);
		return $replacements;
	}
}
