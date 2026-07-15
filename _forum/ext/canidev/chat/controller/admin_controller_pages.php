<?php
/*
* @package cBB Chat
* @version v1.2.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\controller;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class admin_controller_pages extends admin_controller_base
{
	protected $exclude_files = array('app', 'chat', 'common', 'config', 'cron', 'feed', 'report');

	public function _display($mode)
	{
		$this->tpl_name		= 'acp_chat_pages';
		$this->page_title	= 'ACP_CHAT_PAGES';

		$page_id	= $this->request->variable('id', 0);
		$error		= array();
		
		switch($this->action)
		{
			case 'edit':
				$sql = 'SELECT *
					FROM ' . CHAT_PAGES_TABLE . "
					WHERE page_id = $page_id";
				$result = $this->db->sql_query($sql);
				$page_data = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
				
				if(!$page_data)
				{
					trigger_error('NO_PAGES', E_USER_WARNING);
				}

				$page_data['page_data'] = ($page_data['page_data']) ? @unserialize($page_data['page_data']) : array();
				
			// no break

			case 'add':
				add_form_key(self::FORM_KEY);
		
				$position_options = array(
					'top'		=> 'CHAT_POSITION_TOP',
					'bottom'	=> 'CHAT_POSITION_BOTTOM',
				);

				$display_vars = array(
					'legend1'		=> 'CHAT_PAGE_CONFIG',
					'page_file'			=> array('lang' => 'CHAT_PAGE_FILE',	'type' => 'custom',			'function' => array($this, 'make_select'),	'params' => array($this->page_file_options(), '{KEY}', '{CONFIG_VALUE}')),
					'custom_file'		=> array('lang' => 'CHAT_PAGE_CUSTOM',	'validate' => 'string',		'type' => 'text:40:255',	'display' => false),
					'page_alias'		=> array('lang' => 'CHAT_PAGE_ALIAS',	'validate' => 'string',		'type' => 'text:40:50',		'display' => false),
					'chat_position'		=> array('lang' => 'CHAT_POSITION',		'type' => 'custom',			'function' => array($this, 'make_select'),	'params' => array($position_options, '{KEY}', '{CONFIG_VALUE}')),
					'chat_height'		=> array('lang' => 'CHAT_HEIGHT_PAGE',	'validate' => 'int:0:800',	'type' => 'text:4:3'),
					'forum_ids'			=> array('lang' => 'CHAT_PAGE_FORUMS',	'type' => 'custom',			'function' => array($this, 'make_select'),	'params' => array($this->forum_ids_options(), '{KEY}', '{CONFIG_VALUE}', self::SELECT_MULTIPLE),	'display' => false),
				);
				
				if($this->action == 'add')
				{
					$page_data = array(
						'page_alias'	=> '',
						'page_filename'	=> '',
						'page_path'		=> '',
						'page_data'		=> array(),
					);
				}
				
				$page_data['forum_ids'] = (!empty($page_data['page_data']['forum_ids']) ? $page_data['page_data']['forum_ids'] : array());
				
				/*
				* @event chat.acp_pages_vars
				* @var	array	display_vars	Array of config values to display and process
				* @var	array	page_data		Original data of page
				* @var	boolean	submit			Do we display the form or process the submission
				* @since 1.2.0
				*/
				$vars = array('display_vars', 'page_data', 'submit');
				extract($this->dispatcher->trigger_event('chat.acp_pages_vars', compact($vars)));

				if($this->submit)
				{
					$this->new_config = utf8_normalize_nfc($this->request->variable('config', array('' => ''), true));
					
					if(!check_form_key(self::FORM_KEY))
					{
						$error[] = $this->lang->lang('FORM_INVALID');
					}
					
					if($this->new_config['page_file'] == '-')
					{
						if(!preg_match('#^(?:\.\/|\/)?(.*\/)?([\w\d\-\_]+)(\.' . $this->php_ext . ')?$#', $this->new_config['custom_file'], $matches))
						{
							$error[] = $this->lang->lang('INVALID_FILE');
						}
						
						if(!sizeof($error))
						{
							$filename = $this->phpbb_root_path . $matches[1] . $matches[2] . $matches[3];
							
							if(!$matches[1] && in_array($matches[2], $this->exclude_files))
							{
								$error[] = $this->lang->lang('INVALID_FILE');
							}
							
							if(!$this->new_config['page_alias'])
							{
								$error[] = $this->lang->lang('NO_ALIAS');
							}
							
							$this->new_config['page_filename']	= $matches[2] . $matches[3];
							$this->new_config['page_path']		= $matches[1];
						}
					}
					else
					{
						$this->new_config['page_alias']		= $this->new_config['page_file'];
						$this->new_config['page_filename']	= $this->new_config['page_file'] . '.' . $this->php_ext;
						$this->new_config['page_path']		= '';
					}
					
					if(in_array($this->new_config['page_alias'], array('viewforum', 'viewtopic')))
					{
						$this->new_config['forum_ids'] = $this->request->variable('forum_ids', array(0));
						
						$this->new_config['page_data'] = array(
							'forum_ids'		=> $this->new_config['forum_ids'],
						);
					}
					
					// Check if page already exists
					if(!sizeof($error))
					{
						$sql = 'SELECT page_id
							FROM ' . CHAT_PAGES_TABLE . "
							WHERE page_filename = '" . $this->db->sql_escape($this->new_config['page_filename']) . "'
							AND page_path = '" . $this->db->sql_escape($this->new_config['page_path']) . "'
							AND page_id <> $page_id";
						$result = $this->db->sql_query($sql);
						$already_page_id = (int)$this->db->sql_fetchfield('page_id');
						$this->db->sql_freeresult($result);
						
						if($already_page_id)
						{
							$error[] = $this->lang->lang('PAGE_ALREADY_EXISTS');
						}
					}
					
					if(!sizeof($error))
					{
						$sql_ary = array(
							'page_alias'	=> str_replace(' ', '_', $this->new_config['page_alias']),
							'page_filename'	=> $this->new_config['page_filename'],
							'page_path'		=> $this->new_config['page_path'],
							'page_data'		=> (!empty($this->new_config['page_data']) ? @serialize($this->new_config['page_data']) : ''),
							'chat_position'	=> $this->new_config['chat_position'],
							'chat_height'	=> (int)$this->new_config['chat_height'],
						);
						
						if($this->action == 'add')
						{
							$sql = 'INSERT INTO ' . CHAT_PAGES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
						}
						else
						{
							$sql = 'UPDATE ' . CHAT_PAGES_TABLE . '
								SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . "
								WHERE page_id = $page_id";
						}
						
						$this->db->sql_query($sql);
						
						$this->cache->destroy('_chat_options');
						
						trigger_error($this->lang->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
					}
				}
				else
				{
					$this->new_config = $page_data;
					
					if($page_data['page_path'])
					{
						$this->new_config = array_merge($this->new_config, array(
							'page_file'		=> '-',
							'custom_file'	=> $page_data['page_path'] . $page_data['page_filename'],
						));
					}
					else
					{
						$this->new_config['page_file']	= $page_data['page_alias'];
						$this->new_config['page_alias']	= '';
					}
				}
				
				if(in_array($this->new_config['page_file'], array('viewforum', 'viewtopic')))
				{
					$display_vars['forum_ids']['display'] = true;
				}
				
				$this->display_vars($display_vars);
				
				$this->template->assign_vars(array(
					'S_EDIT'	=> true,
					'U_BACK'	=> $this->u_action,
					
					'S_HIDDEN_FIELDS'	=> build_hidden_fields(array(
						'action'	=> $this->action,
						'id'		=> $page_id
					)),
				));
			break;
			
			case 'delete':
				$sql = 'DELETE FROM ' . CHAT_PAGES_TABLE . "
					WHERE page_id = $page_id";
				$this->db->sql_query($sql);
				
				$this->cache->destroy('_chat_options');

				$this->json->send(array(
					'action'	=> 'deleteRow',
					'rowId'		=> $page_id,
				));
			break;
			
			default:
				$sql = 'SELECT *
					FROM ' . CHAT_PAGES_TABLE . '
					ORDER BY page_alias';
				$result = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result))
				{
					$title = ($row['page_alias']) ? $row['page_alias'] : str_replace('.' . $this->php_ext, '', $row['page_filename']);
					$title = ($this->lang->is_set(strtoupper($title)) ? $this->lang->lang(strtoupper($title)) : ucfirst($title));
			
					$this->template->assign_block_vars('pagerow', array(
						'S_ID'		=> $row['page_id'],
						'S_TITLE'	=> $title,
						'S_URL'		=> generate_board_url() . '/' . $row['page_path'] . $row['page_filename'],
						
						'U_DELETE'	=> $this->u_action . '&amp;action=delete&amp;id=' . $row['page_id'],
						'U_EDIT'	=> $this->u_action . '&amp;action=edit&amp;id=' . $row['page_id'],
					));
				}
				$this->db->sql_freeresult($result);
				
				$this->template->assign_var('U_PAGE_ADD', $this->u_action . '&amp;action=add');
			break;
		}
		
		$this->template->assign_vars(array(
			'S_ERROR'		=> (sizeof($error)) ? true : false,
			'ERROR_MSG'		=> implode('<br />', $error),
		));
	}
	
	protected function page_file_options()
	{
		$ary = array(''	=> 'SELECT_PAGE');
		
		if($this->action == 'add')
		{
			// Exclude files already in use
			$sql = 'SELECT page_alias
				FROM ' . CHAT_PAGES_TABLE . "
				WHERE page_path = ''";
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$this->exclude_files[] = $row['page_alias'];
			}
			$this->db->sql_freeresult($result);
		}
		
		// Read all the avaliable files in phpbb root path
		if($dir = @opendir($this->phpbb_root_path))
		{
			$file_ary = array();

			while(($file = @readdir($dir)) !== false)
			{
				if(($pos = strpos($file, '.' . $this->php_ext)) !== false)
				{
					$filename = substr($file, 0, $pos);
				
					if($filename && !in_array($filename, $this->exclude_files))
					{
						$file_ary[$filename] = $file;
					}
				}
			}
			closedir($dir);
			
			if(sizeof($file_ary))
			{
				asort($file_ary);
				$ary = array_merge($ary, array('legend1' => 'FORUM_FILES'), $file_ary);
			}
		}
		
		$ary = array_merge($ary, array(
			'legend2'	=> 'CUSTOM_FILES',
			'-'			=> 'CUSTOM_FILE',
		));
		
		return $ary;
	}
	
	protected function forum_ids_options()
	{
		$forum_ary = make_forum_select(false, false, true, false, true, false, true);
		$ary = array();

		$legend_id = 1;
		
		foreach($forum_ary as $forum_id => $row)
		{
			if(!$row['padding'])
			{
				$ary['legend' . $legend_id] = $row['forum_name'];
				$legend_id++;
			}
			else
			{
				$ary[$forum_id] = $row['padding'] . $row['forum_name'];
			}
		}
		
		return $ary;
	}
}
