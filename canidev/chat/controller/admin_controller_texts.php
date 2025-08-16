<?php
/**
 * @package cBB Chat
 * @version 1.2.5 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\chat\controller;

use canidev\chat\libraries\constants;
use canidev\core\TextParser;

class admin_controller_texts extends admin_controller_base
{
	protected $chat;
	protected $text_parser;

	/**
	 * Constructor
	 *
	 * @param \canidev\chat\libraries\chat 					$chat				Chat Object
	 * @param \phpbb\db\driver\driver_interface				$db					DB Object
	 * @param \phpbb\event\dispatcher_interface				$dispatcher			Event dispatcher
	 * @param \phpbb\log\log                       			$log				Log Object
	 * @param \canidev\core\TextParser 						$text_parser 		Core Text Parser Object
	 * @param \phpbb\user									$user				User object
	 * @param string										$root_path			phpBB root path
	 * @param string										$php_ext			phpEx
	 * @param array 										$tables 			Chat DB Tables
	 *
	 * @access public
	 */
	public function __construct(
		\canidev\chat\libraries\chat $chat,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $dispatcher,
		\phpbb\log\log $log,
		\canidev\core\TextParser $text_parser,
		\phpbb\user $user,
		$root_path,
		$php_ext,
		$tables)
	{
		$this->chat 		= $chat;
		$this->text_parser 	= $text_parser;

		parent::__construct(
			$db,
			$dispatcher,
			$log,
			$user,
			$root_path,
			$php_ext,
			$tables
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function _display($mode)
	{
		$this->tpl_name		= 'acp_chat_texts';
		$this->page_title	= 'ACP_CHAT_TEXTS';

		$text_id 	= $this->request->variable('id', 0);
		$text_type	= $this->request->variable('type', 0);
		$error		= [];
		
		$text_ary = [
			constants::TEXT_NOTICE	=> ['title' => 'CHAT_NOTICES',	'rows' => []],
			constants::TEXT_TIP		=> ['title' => 'CHAT_TIPS',		'rows' => []],
			constants::TEXT_RULE	=> ['title' => 'CHAT_RULES',	'rows' => []],
		];
		
		switch($this->action)
		{
			case 'edit':
				$sql = 'SELECT text_content, bbcode_uid
					FROM ' . $this->tables['texts'] . "
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

				$display_vars = [
					'legend1'		=> 'CONTENT',
					'text_content'	=> ['lang' => $text_ary[$text_type]['title'] . '_ITEM',	'validate'	=> 'string:1',	'type' => 'textarea:5:40'],
				];
				
				if($this->action == 'add')
				{
					$this->new_config['text_content'] = '';
				}
				
				/**
				 * @event chat.acp_texts_vars
				 * @var	array		display_vars	Array of config values to display and process
				 * @var	boolean		submit			Do we display the form or process the submission
				 * @since 1.2.0
				 */
				$submit = &$this->submit;
				$vars = ['display_vars', 'submit'];
				extract($this->dispatcher->trigger_event('chat.acp_texts_vars', compact($vars)));
				
				if($this->submit)
				{
					$this->new_config = $this->request->variable('config', ['' => ''], true);
					
					if(!check_form_key(self::FORM_KEY))
					{
						$error[] = $this->language->lang('FORM_INVALID');
					}
					
					// We validate the complete config if whished
					validate_config_vars($display_vars, $this->new_config, $error);
					
					// Do not write values if there is an error
					if(!sizeof($error))
					{
						$this->new_config['bbcode_uid'] = $this->new_config['bbcode_bitfield'] = $options = '';
						generate_text_for_storage($this->new_config['text_content'], $this->new_config['bbcode_uid'], $this->new_config['bbcode_bitfield'], $options, $this->config['allow_bbcode'], $this->config['allow_post_links'], $this->config['allow_smilies'], $this->config['allow_bbcode'], $this->config['allow_bbcode'], $this->config['allow_bbcode'], $this->config['allow_post_links'], 'chat');
						
						if($this->action == 'add')
						{
							// Get last text position
							$sql = 'SELECT MAX(text_order) AS last_position
								FROM ' . $this->tables['texts'];
							$result = $this->db->sql_query($sql);
							$this->new_config['text_order'] = (int)$this->db->sql_fetchfield('last_position') + 1;
							$this->db->sql_freeresult($result);
							
							$this->new_config['text_type'] = $text_type;

							$sql = 'INSERT INTO ' . $this->tables['texts'] . ' ' . $this->db->sql_build_array('INSERT', $this->new_config);
						}
						else
						{
							$sql = 'UPDATE ' . $this->tables['texts'] . '
								SET ' . $this->db->sql_build_array('UPDATE', $this->new_config) . "
								WHERE text_id = $text_id
								AND text_type = $text_type";
						}
						$this->db->sql_query($sql);
	
						$this->cache->destroy('_chat_options');
						
						trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->form_action));
					}
				}
				
				$this->display_vars($display_vars);
				
				$this->page_title = $text_ary[$text_type]['title'] . '_' . strtoupper($this->action);
				
				$this->template->assign_vars([
					'S_EDIT'	=> true,
					'U_BACK'	=> $this->form_action,
					
					'S_HIDDEN_FIELDS'	=> build_hidden_fields([
						'action'	=> $this->action,
						'type'		=> $text_type,
						'id'		=> $text_id,
					]),
				]);
			break;
			
			case 'delete':
				$sql = 'DELETE FROM ' . $this->tables['texts'] . "
					WHERE text_id = $text_id
					AND text_type = $text_type";
				$this->db->sql_query($sql);

				$this->cache->destroy('_chat_options');

				$this->json->send([
					'action'	=> 'deleteRow',
					'rowId'		=> $text_id,
				]);
			break;
			
			case 'sort':
				$rows = $this->request->variable('row', [0 => 0]);
				
				foreach($rows as $position => $text_id)
				{
					$sql = 'UPDATE ' . $this->tables['texts'] . '
						SET text_order = ' . ((int)$position + 1) . "
						WHERE text_id = $text_id";
					$this->db->sql_query($sql);
				}
				
				$this->cache->destroy('_chat_options');
				$this->json->send();
			break;
			
			default:
				$sql = 'SELECT *
					FROM ' . $this->tables['texts'] . '
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
		
					$this->template->assign_block_vars('textrow', [
						'S_LEGEND'			=> $this->language->lang($s_title),
						'S_EXPLAIN'			=> ($this->language->is_set($s_title . '_EXPLAIN') ? $this->language->lang($s_title . '_EXPLAIN') : ''),
						'S_IS_EMPTY'		=> !sizeof($data_ary['rows']),
						'S_BUTTON_TITLE'	=> $this->language->lang($s_title . '_ADD'),
						'U_ADD'				=> $this->form_action . '&amp;action=add&amp;type=' . $text_type,
					]);
					
					foreach($data_ary['rows'] as $row)
					{
						$row['text_content'] = $this->text_parser->generateForDisplay(
							$row['text_content'],
							TextParser::FLAG_ALLOW_HTML | TextParser::FLAG_PARSE_LANGUAGE,
							$row['bbcode_uid'],
							$row['bbcode_bitfield']
						);

						$this->template->assign_block_vars('textrow.item', [
							'S_CONTENT'		=> $row['text_content'],
							'S_ID'			=> $row['text_id'],
							
							'U_DELETE'		=> $this->form_action . '&amp;action=delete&amp;type=' . $text_type . '&amp;id=' . $row['text_id'],
							'U_EDIT'		=> $this->form_action . '&amp;action=edit&amp;type=' . $text_type . '&amp;id=' . $row['text_id'],
						]);
					}
				}
				
				$this->template->assign_vars([
					'S_HIDDEN_FIELDS'	=> build_hidden_fields([
						'action'	=> 'sort'
					])
				]);
			break;
		}

		$this->template->assign_vars([
			'S_ERROR'		=> (sizeof($error)) ? true : false,
			'ERROR_MSG'		=> implode('<br />', $error),
		]);
	}
}
