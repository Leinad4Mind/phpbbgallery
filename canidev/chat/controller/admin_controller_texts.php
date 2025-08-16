<?php
/*
* @package cBB Chat
* @version v1.2.2 29/03/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\controller;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class admin_controller_texts extends admin_controller_base
{
	protected $chat;

	/**
	* Constructor
	*
	* @param \phpbb\cache\driver\driver_interface 		$cache 				Cache instance
	* @param \canidev\chat\libraries\chat 				$chat				Chat Object
	* @param \phpbb\config\config 						$config				Config Object
	* @param ContainerInterface 						$container			Service container interface
	* @param \phpbb\db\driver\driver_interface			$db					DB Object
	* @param \phpbb\event\dispatcher_interface			$phpbb_dispatcher	Event dispatcher
	* @param \phpbb\language\language					$language			Language Object
	* @param \phpbb\log\log                       		$log				Log Object
	* @param \phpbb\request\request 					$request			Request object
	* @param \phpbb\user								$user				User object
	* @param string										$root_path			phpBB root path
	* @param string										$php_ext			phpEx
	*
	* @access public
	*/
	public function __construct(
		\phpbb\cache\driver\driver_interface $cache,
		\canidev\chat\libraries\chat $chat,
		\phpbb\config\config $config,
		\Symfony\Component\DependencyInjection\ContainerInterface $container,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $phpbb_dispatcher,
		\phpbb\language\language $language,
		\phpbb\log\log $log,
		\phpbb\request\request $request,
		\phpbb\user $user,
		$root_path,
		$php_ext)
	{
		$this->cache		= $cache;
		$this->chat 		= $chat;
		$this->config		= $config;
		$this->db			= $db;
		$this->dispatcher	= $phpbb_dispatcher;
		$this->json			= \canidev\core\json_response::get_instance();
		$this->lang			= $language;
		$this->log			= $log;
		$this->request		= $request;
		$this->template 	= \canidev\core\template::get_instance($container);
		$this->user			= $user;
		
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
	}

	public function _display($mode)
	{
		$this->tpl_name		= 'acp_chat_texts';
		$this->page_title	= 'ACP_CHAT_TEXTS';

		$text_id 	= $this->request->variable('id', 0);
		$text_type	= $this->request->variable('type', 0);
		$error		= array();
		
		$text_ary = array(
			CHAT_TEXT_NOTICE	=> array('title' => 'CHAT_NOTICES',	'rows' => array()),
			CHAT_TEXT_TIP		=> array('title' => 'CHAT_TIPS',	'rows' => array()),
			CHAT_TEXT_RULE		=> array('title' => 'CHAT_RULES',	'rows' => array()),
		);
		
		switch($this->action)
		{
			case 'edit':
				$sql = 'SELECT text_content, bbcode_uid
					FROM ' . CHAT_TEXTS_TABLE . "
					WHERE text_id = $text_id
					AND text_type = $text_type";
				$result = $this->db->sql_query($sql);
				$text_row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
				
				if(!$text_row)
				{
					$this->action = '';
					break;
				}
				
				decode_message($text_row['text_content'], $text_row['bbcode_uid']);
				
				$this->new_config['text_content'] = $text_row['text_content'];
				unset($text_row);
				
			// no break

			case 'add':
				add_form_key(self::FORM_KEY);

				if(!isset($text_ary[$text_type]['title']))
				{
					trigger_error('NO_TEXTS', E_USER_WARNING);
				}

				$display_vars = array(
					'legend1'		=> 'CONTENT',
					'text_content'	=> array('lang' => $text_ary[$text_type]['title'] . '_ITEM',	'validate'	=> 'string:1',	'type' => 'textarea:5:40'),
				);
				
				if($this->action == 'add')
				{
					$this->new_config['text_content'] = '';
				}
				
				/*
				* @event chat.acp_texts_vars
				* @var	array	display_vars	Array of config values to display and process
				* @var	boolean	submit			Do we display the form or process the submission
				* @since 1.2.0
				*/
				$submit = &$this->submit;
				$vars = array('display_vars', 'submit');
				extract($this->dispatcher->trigger_event('chat.acp_texts_vars', compact($vars)));
				
				if($this->submit)
				{
					$this->new_config = utf8_normalize_nfc($this->request->variable('config', array('' => ''), true));
					
					if(!check_form_key(self::FORM_KEY))
					{
						$error[] = $this->lang->lang('FORM_INVALID');
					}
					
					// We validate the complete config if whished
					validate_config_vars($display_vars, $this->new_config, $error);
					
					// Do not write values if there is an error
					if(!sizeof($error))
					{
						$message = $this->new_config['text_content'];

						$this->new_config['bbcode_uid'] = $this->new_config['bbcode_bitfield'] = $options = '';
						generate_text_for_storage($this->new_config['text_content'], $this->new_config['bbcode_uid'], $this->new_config['bbcode_bitfield'], $options, $this->config['allow_bbcode'], $this->config['allow_post_links'], $this->config['allow_smilies'], $this->config['allow_bbcode'], $this->config['allow_bbcode'], $this->config['allow_bbcode'], $this->config['allow_post_links'], 'chat');
						
						if($this->action == 'add')
						{
							// Get last text position
							$sql = 'SELECT MAX(text_order) AS last_position
								FROM ' . CHAT_TEXTS_TABLE;
							$result = $this->db->sql_query($sql);
							$this->new_config['text_order'] = (int)$this->db->sql_fetchfield('last_position') + 1;
							$this->db->sql_freeresult($result);
							
							$this->new_config['text_type'] = $text_type;

							$sql = 'INSERT INTO ' . CHAT_TEXTS_TABLE . ' ' . $this->db->sql_build_array('INSERT', $this->new_config);
						}
						else
						{
							$sql = 'UPDATE ' . CHAT_TEXTS_TABLE . '
								SET ' . $this->db->sql_build_array('UPDATE', $this->new_config) . "
								WHERE text_id = $text_id
								AND text_type = $text_type";
						}
						$this->db->sql_query($sql);
	
						$this->cache->destroy('_chat_options');
						
						trigger_error($this->lang->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
					}
				}
				
				$this->display_vars($display_vars);
				
				$this->page_title = $text_ary[$text_type]['title'] . '_' . strtoupper($this->action);
				
				$this->template->assign_vars(array(
					'S_EDIT'	=> true,
					'U_BACK'	=> $this->u_action,
					
					'S_HIDDEN_FIELDS'	=> build_hidden_fields(array(
						'action'	=> $this->action,
						'type'		=> $text_type,
						'id'		=> $text_id,
					)),
				));
			break;
			
			case 'delete':
				$sql = 'DELETE FROM ' . CHAT_TEXTS_TABLE . "
					WHERE text_id = $text_id
					AND text_type = $text_type";
				$this->db->sql_query($sql);

				$this->cache->destroy('_chat_options');

				$this->json->send(array(
					'action'	=> 'deleteRow',
					'rowId'		=> $text_id,
				));
			break;
			
			case 'sort':
				$rows = $this->request->variable('row', array(0 => 0));
				
				foreach($rows as $position => $text_id)
				{
					$sql = 'UPDATE ' . CHAT_TEXTS_TABLE . '
						SET text_order = ' . ((int)$position + 1) . "
						WHERE text_id = $text_id";
					$this->db->sql_query($sql);
				}
				
				$this->cache->destroy('_chat_options');
				$this->json->send();
			break;
			
			default:
				$sql = 'SELECT *
					FROM ' . CHAT_TEXTS_TABLE . '
					ORDER BY text_order';
				$result = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result))
				{
					$row_type = (int)$row['text_type'];

					if(!isset($text_ary[$row_type]))
					{
						continue;
					}
					
					$text_ary[$row_type]['rows'][] = $row;
				}
				$this->db->sql_freeresult($result);
				
				foreach($text_ary as $text_type => $data_ary)
				{
					$s_title = $data_ary['title'];
		
					$this->template->assign_block_vars('textrow', array(
						'S_LEGEND'			=> $this->lang->lang($s_title),
						'S_EXPLAIN'			=> ($this->lang->is_set($s_title . '_EXPLAIN') ? $this->lang->lang($s_title . '_EXPLAIN') : ''),
						'S_IS_EMPTY'		=> (sizeof($data_ary['rows']) ? false : true),
						'S_BUTTON_TITLE'	=> $this->lang->lang($s_title . '_ADD'),
						'U_ADD'				=> $this->u_action . '&amp;action=add&amp;type=' . $text_type,
					));
					
					foreach($data_ary['rows'] as $row)
					{
						/*
						 * bbcode_bitfield is empty in some cases in phpBB 3.2 so, check if the text have some [/ to detect the presence of bbcode.
						 * If no bbcode, we decode the text to allow HTML tags.
						*/
						if(strpos($row['text_content'], '[/') !== false)
						{
							$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
							$row['text_content'] = generate_text_for_display($row['text_content'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);
						}
						else
						{
							$row['text_content'] = htmlspecialchars_decode($row['text_content']);
							$row['text_content'] = smiley_text($row['text_content']);
						}

						$this->chat->parse_lang_variables($row['text_content']);

						$this->template->assign_block_vars('textrow.item', array(
							'S_CONTENT'		=> $row['text_content'],
							'S_ID'			=> $row['text_id'],
							
							'U_DELETE'		=> $this->u_action . '&amp;action=delete&amp;type=' . $text_type . '&amp;id=' . $row['text_id'],
							'U_EDIT'		=> $this->u_action . '&amp;action=edit&amp;type=' . $text_type . '&amp;id=' . $row['text_id'],
						));
					}
				}
				
				$this->template->assign_vars(array(
					'S_HIDDEN_FIELDS'	=> build_hidden_fields(array(
						'action'	=> 'sort'
					))
				));
			break;
		}

		$this->template->assign_vars(array(
			'S_ERROR'		=> (sizeof($error)) ? true : false,
			'ERROR_MSG'		=> implode('<br />', $error),
		));
	}
}
