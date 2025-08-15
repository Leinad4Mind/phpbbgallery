<?php
/**
*
* BBAvatars
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\titlesandavatars\migrations\v31x;

/**
* Migration stage 2: Initial data changes to the files
*/
class m2_initial_file extends \phpbb\db\migration\migration
{
	/**
	* @return array Array of files
	* @access public
	*/
	public function update_data()
	{
		$this->revert = false;
		return array(
			array('custom', array(array($this, 'update_functions'))),
		);
	}

	public function revert_data()
	{
		$this->revert = true;
		return array(
			array('custom', array(array($this, 'update_functions'))),
		);
	}

	/**
	* Update files on server
	*
	* @return null
	* @access public
	*/
	public function update_functions()
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
	}
	
	public function data()
	{
		$replacements = array(
			'files' => array(
				0 => '/includes/functions_display.' . $this->php_ext,
				),
			'searches' => array(
				0 => array('			}
		}

		/**
		* Event to modify the forum rows data set
'),
				),
			'replaces' => array(
				0 => array('				$vars = array(\'forum_rows\', \'row\', \'parent_id\');
				extract($phpbb_dispatcher->trigger_event(\'core.display_forums_modify_first_last_avatar\', compact($vars)));
			}
		}

		/**
		* Event to modify the forum rows data set
'),
				)
			);
		return $replacements;
	}
}
