<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\libraries;

use Symfony\Component\DependencyInjection\ContainerInterface;

class editor
{
	private $params = [
		'action'	=> '',
	];

	protected $auth;
	protected $config;
	protected $container;
	protected $db;
	protected $helper;
	protected $helper_acp;
	protected $language;
	protected $media;
	protected $request;
	protected $template;
	protected $tools;
	protected $user;
	
	protected $phpbb_root_path;
	protected $php_ext;
	protected $tables;

	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth 							$auth				Authentication object
	 * @param \phpbb\config\config 						$config				Config Object
	 * @param ContainerInterface 						$container			Service container interface
	 * @param \phpbb\db\driver\driver_interface			$db					DB Object
	 * @param \canidev\blockgets\libraries\helper		$helper				Blockgets helper Object
	 * @param \canidev\blockgets\libraries\helper_acp	$helper_acp			Blockgets ACP helper Object
	 * @param \phpbb\language\language					$language			Language Object
	 * @param \phpbb\request\request 					$request			Request object
	 * @param \canidev\core\template					$template     		Core Template object
	 * @param \canidev\core\tools 						$tools 				Core Tools Object
	 * @param \phpbb\user								$user				User object
	 * @param string									$root_path			phpBB root path
	 * @param string									$php_ext			phpEx
	 * @param array 									$tables 			Blockgets DB Tables
	 *
	 * @access public
	 */
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\config\config $config,
		ContainerInterface $container,
		\phpbb\db\driver\driver_interface $db,
		\canidev\blockgets\libraries\helper $helper,
		\canidev\blockgets\libraries\helper_acp $helper_acp,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\canidev\core\template $template,
		\canidev\core\tools $tools,
		\phpbb\user $user,
		$root_path,
		$php_ext,
		$tables)
	{
		$this->auth			= $auth;
		$this->config		= $config;
		$this->container 	= $container;
		$this->db			= $db;
		$this->helper		= $helper;
		$this->helper_acp	= $helper_acp;
		$this->language		= $language;
		$this->request		= $request;
		$this->template		= $template;
		$this->tools 		= $tools;
		$this->user			= $user;

		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
		$this->tables 			= $tables;
	}

	/**
	 * Initialize the editor
	 */
	public function init()
	{
		$error 	= [];
		$post 	= $this->request->get_super_global(\phpbb\request\request_interface::POST);
		$editor = \canidev\core\editor::get_instance($this->container);
		
		if(isset($post['editor']))
		{
			$this->params = array_merge($this->params, $post['editor']);
		}

		$this->helper->json->add([
			'status'	=> \canidev\core\json_response::JSON_STATUS_SUCCESS,
			'action'	=> $this->params['action'],
		]);

		$editor->do_actions();

		$this->helper->get_media(true, true);
		
		switch($this->params['action'])
		{
			case 'create':
				$page_title = $this->language->lang('EDITOR');

				$editor->add_plugin('/canidev/blockgets/libraries/editor_plugin_html', true);

				$editor->build([
					'name'					=> 'content',
					'emoticonContainer'		=> '.smileys .box-content',
					'type'					=> 'advanced',
					'toolbarExclude'		=> 'maximize',
					'requestData'			=> [
						'jblgm' 	=> 'editor'
					]
				]);

				$editor->smilies_to_template();

				$this->template->assign_vars([
					'S_EDITOR_TYPE'		=> $this->params['type'],
					'BLG_RSZ_WIDTH'		=> (int)$this->config['blg_image_max_width'],
				]);
				
				// load the event content
				if($this->params['type'] == 'event')
				{
					$time 		= isset($this->params['time']) ? (int)$this->params['time'] : 0;
					$datetime	= $this->user->create_datetime();
					$now 		= phpbb_gmgetdate($datetime->getTimestamp() + $datetime->getOffset());
					
					if(!$this->auth->acl_get('u_blockgets_events'))
					{
						$error[] = $this->language->lang('NOT_AUTHORISED');
						break;
					}

					if($this->params['id'] != 'new')
					{
						$sql = 'SELECT *
							FROM ' . $this->tables['data'] . '
							WHERE data_id = ' . (int)$this->params['id'] . '
							AND data_type = ' . constants::DATA_EVENT;
						$result = $this->db->sql_query($sql);
						$post_row = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);
						
						if(!$post_row)
						{
							$error[] = $this->language->lang('EVENT_ERROR');
							break;
						}

						$post_row['data_settings'] = unserialize($post_row['data_settings']);

						list($eyear, $emonth, $eday) = explode('-', date('Y-m-d', $post_row['data_time']));

						decode_message($post_row['data_content'], $post_row['bbcode_uid']);

						$this->template->assign_vars([
							'S_TITLE'			=> $post_row['data_title'],
							'S_EDITOR_CONTENT'	=> $post_row['data_content'],
						]);
						
						$page_title = $this->language->lang('EDIT_EVENT');
					}
					else
					{
						// Default data for new events
						$post_row = [
							'data_settings'	=> [
								'groups' 	=> 'all',
								'color'		=> '',
							]
						];
						
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
						
						$page_title = $this->language->lang('ADD_EVENT');
					}
					
					// Generate date select
					$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
					
					$s_day_options = $s_month_options = $s_year_options = '';
					
					for($i = 1; $i < 32; $i++)
					{
						$selected = ($i == $eday) ? ' selected="selected"' : '';
						$s_day_options .= "<option value=\"$i\"$selected>$i</option>";
					}
					
					for($i = 1; $i < 13; $i++)
					{
						$selected = ($i == $emonth) ? ' selected="selected"' : '';
						$s_month_options .= "<option value=\"$i\"$selected>" . $this->language->lang(['datetime', $months[$i - 1]]) . '</option>';
					}

					for($i = min($eyear, $now['year']); $i <= $now['year'] + 20; $i++)
					{
						$selected = ($i == $eyear) ? ' selected="selected"' : '';
						$s_year_options .= "<option value=\"$i\"$selected>$i</option>";
					}

					$this->template->assign_vars([
						'S_DAY_OPTIONS'			=> $s_day_options,
						'S_COLOR_SELECT'		=> $this->helper_acp->easy_input_template('event_color', $post_row['data_settings']['color'], false, true),
						'S_GROUPS_SELECT'		=> $this->tools->groups_select('event_groups', $post_row['data_settings']['groups']),
						'S_MONTH_OPTIONS'		=> $s_month_options,
						'S_YEAR_OPTIONS'		=> $s_year_options,
					]);
				}
				
				$this->template->assign_vars([
					'S_EDITOR_TITLE'	=> $page_title,
				]);
			
				$this->display();
			break;
			
			case 'save':
				if($this->params['type'] != 'event')
				{
					$error[] = $this->language->lang('ACTION_ERROR');
					break;
				}

				$eday		= $this->request->variable('event_day', 0);
				$emonth		= $this->request->variable('event_month', 0);
				$eyear		= $this->request->variable('event_year', 0);
				$title		= $this->request->variable('event_title', '', true);
				$content	= $this->request->variable('event_content', '', true);
				$groups 	= ($this->request->is_set_post('all_groups_event_groups')) ? ['all'] : $this->request->variable('event_groups', [0]);
				$color 		= $this->request->variable('event_color', '');
				
				// Check title
				if(utf8_clean_string($title) === '')
				{
					$error[] = $this->language->lang('EMPTY_EVENT_TITLE');
				}
				
				if(!sizeof($error))
				{
					$uid = $bitfield = $options = '';

					$event_time = mktime(0, 0, 0, $emonth, $eday, $eyear);

					generate_text_for_storage($content, $uid, $bitfield, $options, true, false, true, true, false, true, true, 'blockgets');

					$sql_ary = [
						'data_title'		=> $title,
						'data_content'		=> $content,
						'data_settings'		=> serialize([
							'groups'	=> implode(',', $groups),
							'color'		=> $color,
						]),
						'data_time'			=> $event_time,
						'bbcode_uid'		=> $uid,
						'bbcode_bitfield'	=> $bitfield,
					];
					
					if($this->params['id'] == 'new')
					{
						// Create new item
						$sql_ary += [
							'data_type'		=> constants::DATA_EVENT,
							'user_id'		=> $this->user->data['user_id'],
						];
						
						$sql = 'INSERT INTO ' . $this->tables['data'] . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
						$this->db->sql_query($sql);
						
						$this->params['id'] = (int)$this->db->sql_nextid();
					}
					else
					{
						// Edit item
						$sql = 'UPDATE ' . $this->tables['data'] . '
							SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
							WHERE data_id = ' . (int)$this->params['id'] . '
							AND data_type = ' . constants::DATA_EVENT;
						$this->db->sql_query($sql);
					}

					// Check if are other events in the same day
					$sql = 'SELECT COUNT(data_id) AS event_num
						FROM ' . $this->tables['data'] . '
						WHERE data_type = ' . constants::DATA_EVENT . '
						AND data_time = ' . $event_time;
					$result = $this->db->sql_query($sql);
					$event_count = (int)$this->db->sql_fetchfield('event_num');
					$this->db->sql_freeresult($result);

					$formatted_event_text = generate_text_for_display($content, $uid, $bitfield, $options | constants::FLAG_HTML);
					$formatted_event_text = \canidev\core\tools::fix_smilies_path($formatted_event_text);
					
					$this->helper->json->add([
						'isUnique'		=> ($event_count == 1),
						'timestamp'		=> $event_time,
						'eventTitle'	=> $sql_ary['data_title'],
						'eventColor'	=> $color,
						'eventContent'	=> $formatted_event_text,
					]);
					
					$this->template->assign_vars([
						'S_EVENT_OUTPUT'	=> true,
						'S_EVENT_TITLE'		=> $title,
						'S_EVENT_ATTR'		=> \canidev\core\tools::array_to_attr([
							'class'			=> 'blg-calendar-event',
							'data-color'	=> $color,
							'data-event' 	=> $this->params['id'],
						]),
					]);
					
					$this->display();
				}
			break;
		}
		
		if(sizeof($error))
		{
			$this->helper->json->send([
				'status'	=> \canidev\core\json_response::JSON_STATUS_ERROR,
				'message'	=> implode('<br />', $error)
			]);
		}
	}

	/**
	 * Display the editor
	 * @access private
	 */
	private function display()
	{
		$this->template->set_filenames([
			'body'	=> '@canidev_blockgets/editor_body.html'
		]);
		
		$this->helper->json->send([
			'htmlContent'	=> $this->template->assign_display('body'),
		]);
	}
}
