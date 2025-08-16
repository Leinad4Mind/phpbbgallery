<?php
/*
* @name json_response.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\libraries;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class editor
{
	private $params = array(
		'action'	=> '',
	);

	protected $auth;
	protected $config;
	protected $db;
	protected $helper;
	protected $helper_acp;
	protected $lang;
	protected $json;
	protected $parser;
	protected $request;
	protected $template;
	protected $user;
	
	protected $phpbb_root_path;
	protected $php_ext;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth 							$auth				Authentication object
	* @param \phpbb\config\config 						$config				Config Object
	* @param \phpbb\db\driver\driver_interface			$db					DB Object
	* @param \canidev\blockgets\libraries\helper		$helper				Blockgets helper Object
	* @param \canidev\blockgets\libraries\helper_acp	$helper_acp			Blockgets ACP helper Object
	* @param \canidev\blockgets\libraries\json_response	$json_response		Blockgets Json Object
	* @param \canidev\blockgets\libraries\language		$language			Blockgets language Object
	* @param \canidev\blockgets\libraries\parser		$parser				Blockgets TextParser Object
	* @param \phpbb\request\request 					$request			Request object
	* @param \canidev\blockgets\libraries\template		$template     		Template object
	* @param \phpbb\user								$user				User object
	* @param string										$root_path			phpBB root path
	* @param string										$php_ext			phpEx
	*
	* @access public
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \canidev\blockgets\libraries\helper $helper, \canidev\blockgets\libraries\helper_acp $helper_acp, \canidev\blockgets\libraries\json_response $json_response, \canidev\blockgets\libraries\language $language, \canidev\blockgets\libraries\parser $parser, \phpbb\request\request $request, \canidev\blockgets\libraries\template $template, \phpbb\user $user, $root_path, $php_ext)
	{
		$this->auth			= $auth;
		$this->config		= $config;
		$this->db			= $db;
		$this->helper		= $helper;
		$this->helper_acp	= $helper_acp;
		$this->json			= $json_response;
		$this->lang			= $language;
		$this->parser		= $parser;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;

		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
	}

	public function init()
	{
		$error 	= array();
		$post 	= $this->request->get_super_global(\phpbb\request\request_interface::POST);
		
		if(isset($post['editor']))
		{
			$this->params = array_merge($this->params, $post['editor']);
		}

		$this->json->add(array(
			'status'	=> BLG_JSON_SUCCESS,
			'action'	=> $this->params['action'],
		));
		
		switch($this->params['action'])
		{
			case 'create':
				$this->lang->add('editor', true);

				$corrected_path	= $this->helper->get_web_root_path();
				$web_path		= (defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? generate_board_url() . '/' : $corrected_path;
				$page_title 	= $this->lang->get('EDITOR');

				$this->template->assign_vars(array(
					'S_EDITOR_TYPE'			=> $this->params['type'],
					'T_STYLESHEET_LINK'		=> "{$web_path}styles/" . rawurlencode($this->user->style['style_path']) . '/theme/stylesheet.css?assets_version=' . $this->config['assets_version'],
				
					'BLG_RSZ_GO'		=> (int)$this->config['blg_resize_enabled'],
					'BLG_RSZ_WIDTH'		=> (int)$this->config['blg_image_max_width'],
				));

				$this->json->add(array(
					'SCEditorFilename'	=> $this->template->append_asset('js', '@canidev_blockgets/js/jquery.sceditor.min.js', 'common', true),
					'editor'	=> array(
						'locale'	=> ($this->lang->is_set('sceditor') ? $this->lang->get_raw('sceditor') : false),
						'emoticons'	=> $this->generate_smilies(true),
						'style'		=> $this->template->append_asset('css', '@canidev_blockgets/../theme/square.css', 'common', true),
					)
				));
				
				// load the event content
				if($this->params['type'] == 'event')
				{
					$time 		= (isset($this->params['time']) ? (int)$this->params['time'] : 0);
					$datetime	= $this->user->create_datetime();
					$now 		= phpbb_gmgetdate($datetime->getTimestamp() + $datetime->getOffset());
					
					if(!$this->auth->acl_get('u_blockgets_events'))
					{
						$error[] = $this->lang->get('NOT_AUTHORISED');
						break;
					}

					if($this->params['id'] != 'new')
					{
						$sql = 'SELECT *
							FROM ' . BLG_DATA_TABLE . '
							WHERE data_id = ' . (int)$this->params['id'] . '
							AND data_type = ' . BLG_DATA_EVENT;
						$result = $this->db->sql_query($sql);
						$post_row = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);
						
						if(!$post_row)
						{
							$error[] = $this->lang->get('EVENT_ERROR');
							break;
						}

						list($eyear, $emonth, $eday) = explode('-', date('Y-m-d', $post_row['data_time']));

						$this->parser->decode_message($post_row['data_content'], $post_row['bbcode_uid']);
						
						$this->template->assign_vars(array(
							'S_TITLE'	=> $post_row['data_title'],
							'S_CONTENT'	=> $post_row['data_content'],
						));
						
						$page_title = $this->lang->get('EDIT_EVENT');
					}
					else
					{
						// Default data for new events
						$post_row = array(
							'data_settings'	=> 'all'
						);
						
						if($time)
						{
							list($eyear, $emonth, $eday) = explode('-', date('Y-m-d', $time));
						}
						else
						{
							$eyear	= $now['year'];
							$emonth	= $now['mon'];
							$eday	= $now['mday'];
						}
						
						$page_title = $this->lang->get('ADD_EVENT');
					}
					
					// Generate date select
					$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
					
					$s_day_options = $s_month_options = $s_year_options = '';
					
					for($i = 1; $i < 32; $i++)
					{
						$selected = ($i == $eday) ? ' selected="selected"' : '';
						$s_day_options .= "<option value=\"$i\"$selected>$i</option>";
					}
					
					for($i = 1; $i < 13; $i++)
					{
						$selected = ($i == $emonth) ? ' selected="selected"' : '';
						$s_month_options .= "<option value=\"$i\"$selected>" . $this->lang->get(array('datetime', $months[$i - 1])) . '</option>';
					}

					for($i = min($eyear, $now['year']); $i <= $now['year'] + 20; $i++)
					{
						$selected = ($i == $eyear) ? ' selected="selected"' : '';
						$s_year_options .= "<option value=\"$i\"$selected>$i</option>";
					}

					$this->template->assign_vars(array(
						'S_DAY_OPTIONS'			=> $s_day_options,
						'S_GROUPS_SELECT'		=> $this->helper_acp->groups_select('event_groups', $post_row['data_settings']),
						'S_MONTH_OPTIONS'		=> $s_month_options,
						'S_YEAR_OPTIONS'		=> $s_year_options,
					));

				}
				
				$this->template->assign_vars(array(
					'S_EDITOR_TITLE'	=> $page_title,
				));
			
				$this->display();
			break;
			
			case 'save':
				if($this->params['type'] != 'event')
				{
					$error[] = $this->lang->get('ACTION_ERROR');
					break;
				}

				$eday		= $this->request->variable('event_day', 0);
				$emonth		= $this->request->variable('event_month', 0);
				$eyear		= $this->request->variable('event_year', 0);
				$title		= utf8_normalize_nfc($this->request->variable('event_title', '', true));
				$content	= utf8_normalize_nfc($this->request->variable('event_content', '', true));
				$groups		= ($this->request->is_set_post('all_groups')) ? array('all') : $this->request->variable('event_groups', array(0));
				
				// Check title
				if(utf8_clean_string($title) === '')
				{
					$error[] = $this->lang->get('EMPTY_EVENT_TITLE');
				}
				
				if(!sizeof($error))
				{
					$uid = $bitfield = $options = '';
					$this->parser->generate_text_for_storage($content, $uid, $bitfield, $options, true, true, true);

					$sql_ary = array(
						'data_title'		=> $title,
						'data_content'		=> $content,
						'data_settings'		=> implode(',', $groups),
						'data_time'			=> mktime(0, 0, 0, $emonth, $eday, $eyear),
						'bbcode_uid'		=> $uid,
						'bbcode_bitfield'	=> $bitfield,
					);
					
					if($this->params['id'] == 'new')
					{
						// Create new item
						$sql_ary += array(
							'data_type'		=> BLG_DATA_EVENT,
							'user_id'		=> $this->user->data['user_id'],
						);
						
						$sql = 'INSERT INTO ' . BLG_DATA_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
						$this->db->sql_query($sql);
						
						$this->params['id'] = (int)$this->db->sql_nextid();
					}
					else
					{
						// Edit item
						$sql = 'UPDATE ' . BLG_DATA_TABLE . '
							SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
							WHERE data_id = ' . (int)$this->params['id'] . '
							AND data_type = ' . BLG_DATA_EVENT;
						$this->db->sql_query($sql);
					}
					
					$this->json->add(array(
						'timestamp'		=> $sql_ary['data_time'],
						'eventTitle'	=> $sql_ary['data_title'],
						'eventContent'	=> $this->parser->generate_text_for_display($content, $uid, $bitfield, $options),
					));
					
					$this->template->assign_vars(array(
						'S_EVENT_ID'		=> $this->params['id'],
						'S_EVENT_OUTPUT'	=> true,
						'S_EVENT_TITLE'		=> $title,
					));
					
					$this->display();
				}
			break;
		}
		
		if(sizeof($error))
		{
			$this->json->send(array(
				'status'	=> BLG_JSON_ERROR,
				'message'	=> implode('<br />', $error)
			));
		}
	}

	private function generate_smilies($to_template = false)
	{
		$smilies 	= array();
		$root_path	= (defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? generate_board_url() . '/' : $this->helper->get_web_root_path();

		$sql = 'SELECT *
			FROM ' . SMILIES_TABLE . '
			ORDER BY smiley_order';
		$result = $this->db->sql_query($sql, 3600);
		while($row = $this->db->sql_fetchrow($result))
		{
			if(empty($smilies[$row['smiley_url']]))
			{
				$row['smiley_full_url'] = $root_path . $this->config['smilies_path'] . '/' . $row['smiley_url'];
				$smilies[$row['smiley_url']] = $row;
			}
		}
		$this->db->sql_freeresult($result);

		// Put the smilies in the template if neccessary
		if(sizeof($smilies) && $to_template)
		{
			foreach($smilies as $row)
			{
				$this->template->assign_block_vars('smiley', array(
					'SMILEY_CODE'	=> $row['code'],
					'A_SMILEY_CODE'	=> addslashes($row['code']),
					'SMILEY_IMG'	=> $row['smiley_full_url'],
					'SMILEY_WIDTH'	=> $row['smiley_width'],
					'SMILEY_HEIGHT'	=> $row['smiley_height'],
					'SMILEY_DESC'	=> $row['emotion']
				));
			}
		}
		
		// Build the object to parse to the editor
		$result = array();
		foreach($smilies as $row)
		{
			$result[$row['code']] = $row['smiley_full_url'];
		}
		
		return array('hidden' => $result);
	}

	private function display()
	{
		$this->template->set_filenames(array(
			'body'	=> 'editor_body.html'
		));
		
		$this->json->send(array(
			'htmlContent'	=> $this->template->assign_display('body'),
		));
	}
}
