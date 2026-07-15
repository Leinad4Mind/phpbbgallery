<?php
/**
*
* UserDefaults extension for the phpBB Forum Software package.
*
* @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\userdefault\acp;

class userdefault_module
{
	protected $config;
	protected $log;
	protected $request;
	protected $template;
	protected $user;
	protected $noti_manager;
	protected $db;
	protected $phpbb_container;
	public $u_action;

	public function main($id, $mode)
	{
		global $config, $request, $template, $user, $db, $phpbb_container;

		$this->config = $config;
		$this->log = $phpbb_container->get('log');
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->noti_manager = $phpbb_container->get('notification_manager');
		$this->db = $db;
		$this->entity = $phpbb_container->get('forumhulp.userdefault.entity.constants');
		
		// Load a template from adm/style for our ACP page
		$this->tpl_name = 'userdefault';

		// Set the page title for our ACP page
		$this->page_title = 'ACP_USERDEFAULT';

		// Define the name of the form for use as a form key
		$form_name = 'acp_userdefault';
		add_form_key($form_name);

		// Set an empty error string
		$error = '';

		$action	= ($this->request->is_set('add')) ? 'add' : (($this->request->is_set('edit')) ? 'edit' : $this->request->variable('action', 'default'));

		switch ($action)
		{
			case 'details':
				$this->user->add_lang_ext('forumhulp/userdefault', 'info_acp_userdefault');
				$phpbb_container->get('forumhulp.helper')->detail('forumhulp/userdefault');
				$this->tpl_name = 'acp_ext_details';
			break;

			case 'sync_users':
				$this->sync_users();
			break;
		
			default:
				$this->user->add_lang(array('acp/board', 'ucp'));

				if ($this->request->is_set_post('submit'))
				{
					$noti_types	= $this->request->variable('noti_types', array('' => false));
					foreach($noti_types as $key => $value)
					{
						$ids = explode('~', $key);
						$default_types[$ids[1]][$ids[0]] = $value;
					}

					$table_types = array();
					$sql = 'SELECT * FROM ' . NOTIFICATION_TYPES_TABLE . ' ORDER BY notification_type_name';
					$result = $this->db->sql_query($sql);
					while ($row = $this->db->sql_fetchrow($result))
					{
						if (in_array($row['notification_type_name'], array('notification.type.post_in_queue', 'notification.type.topic_in_queue', 'notification.type.approve_post', 'notification.type.approve_topic')))
						{
							$row['notification_type_id'] = $this->entity->get('notification_type_needs_approval');
							$row['notification_type_name'] = 'notification.type.needs_approval';
						}
					
						if (in_array($row['notification_type_name'], array('notification.type.report_post_closed', 'notification.type.report_post')))
						{
							$row['notification_type_id'] = $this->entity->get('notification_type_report');
							$row['notification_type_name'] = 'notification.type.report';
						}
	
						(isset($default_types['board'][$row['notification_type_name']])) ? $table_types['board'][] = $row['notification_type_id']: null;
						(isset($default_types['email'][$row['notification_type_name']])) ? $table_types['email'][] = $row['notification_type_id']: null;
					}
					$noti_setup = json_encode($table_types);

					$options	= $this->request->variable('options', array('' => false));
					$option_ary = array(
						'viewimg'		=> (isset($options['viewimg']) && $options['viewimg'] == 1) ? 1 : 0,
						'viewflash'		=> (isset($options['viewflash']) && $options['viewflash'] == 1) ? 1 : 0,
						'viewsmilies'	=> (isset($options['viewsmilies']) && $options['viewsmilies'] == 1) ? 1 : 0,
						'viewsigs'		=> (isset($options['viewsigs']) && $options['viewsigs'] == 1) ? 1 : 0,
						'viewavatars'	=> (isset($options['viewavatars']) && $options['viewavatars'] == 1) ? 1 : 0,
						'viewcensors'	=> (isset($options['viewcensors']) && $options['viewcensors'] == 1) ? 1 : 0,
						'attachsig'		=> (isset($options['attachsig']) && $options['attachsig'] == 1) ? 1 : 0,
						'dummy7'		=> 0,
						'bbcode'		=> (isset($options['bbcode']) && $options['bbcode'] == 1) ? 1 : 0,
						'smilies'		=> (isset($options['smilies']) && $options['smilies'] == 1) ? 1 : 0,
						'popuppm'		=> (isset($options['popuppm']) && $options['popuppm'] == 1) ? 1 : 0,
						'dummy11'		=> 0,
						'dummy12'		=> 0,
						'dummy13'		=> 0,
						'dummy14'		=> 0,
						'sig_bbcode'	=> (isset($options['sig_bbcode']) && $options['sig_bbcode'] == 1) ? 1 : 0,
						'sig_smilies'	=> (isset($options['sig_smilies']) && $options['sig_smilies'] == 1) ? 1 : 0,
						'sig_links'		=> (isset($options['sig_links']) && $options['sig_links'] == 1) ? 1 : 0,
					);
					
					$postsettings = $this->request->variable('postsettings', array('' => ''));
					$postsettings = implode('', array_map(array($this->entity, 'findkey'), array_keys($postsettings), $postsettings)); 

					$generalsettings = $this->request->variable('general', array('' => false));
					$generalsettings['user_notify_type'] = $this->request->variable('user_notify_type', 0);
					$gs_ary = array('viewemail', 'massemail', 'allowpm', 'notify', 'notifypm' , 'hideonline', 'user_notify_type');
					foreach ($gs_ary as $key)
					{
						$gs_setting[] = (isset($generalsettings[$key])) ? (($key == 'user_notify_type') ? $generalsettings['user_notify_type'] : 1) : 0;
					}
					$gs_setting = implode('', $gs_setting);
				
					$this->config->set('default_dateformat', $this->request->variable('date_format', 'D M d, Y g:i a'));
					$this->config->set('user_default_options',   bindec(strrev(implode('', $option_ary))) . '~' . $postsettings . '~' . $gs_setting . '~' . $noti_setup);
					$this->log->add('admin', $this->user->data['user_id'], $this->user->data['session_ip'], 'ACP_USERDEFAULT_SAVED', false);
					$this->show_result($this->user->lang['ACP_USERDEFAULT_SAVED']);
				}
		
				list($options, $postsettings, $generalsettings, $noti_setup) = explode('~', $this->config['user_default_options']);
				$postsettings  = str_split($postsettings);
				$generalsettings  = str_split($generalsettings);
				$noti_setup = json_decode($noti_setup, true);
	
				$data = array(
					'topic_st'	=> $this->entity->Index($postsettings[0], 'limit_days'),
					'post_st'	=> $this->entity->Index($postsettings[1], 'limit_days'),
					'topic_sk'	=> $this->entity->Index($postsettings[2], 'sort_by_topic_text'),
					'post_sk'	=> $this->entity->Index($postsettings[3], 'sort_by_post_text'),
					'topic_sd'	=> $this->entity->Index($postsettings[4], 'sort_dir_text'),
					'post_sd'	=> $this->entity->Index($postsettings[5], 'sort_dir_text'),

					'user_allow_viewemail'	=> $generalsettings[0],
					'user_allow_massemail'	=> $generalsettings[1],
					'user_allow_pm'			=> $generalsettings[2],
					'user_notify'			=> $generalsettings[3],
					'user_notify_pm'		=> $generalsettings[4],
					'hideonline'			=> $generalsettings[5],
					'user_notify_type'		=> $generalsettings[6],
				);

				$dateformat_options = '';
				foreach ($this->user->lang['dateformats'] as $format => $null)
				{
					$dateformat_options .= '<option value="' . $format . '"' . (($format == $this->config['default_dateformat']) ? ' selected="selected"' : '') . '>';
					$dateformat_options .= $this->user->format_date(time(), $format, false) . ((strpos($format, '|') !== false) ? $this->user->lang['VARIANT_DATE_SEPARATOR'] . $this->user->format_date(time(), $format, true) : '');
					$dateformat_options .= '</option>';
				}
				
				$_options = array('topic', 'post');
				foreach ($_options as $sort_option)
				{
					${'s_limit_' . $sort_option . '_days'} = '<select name="postsettings[' . $sort_option . '_st]">';
					foreach ($this->entity->get('limit_days') as $day => $text)
					{
						$selected = ($data[$sort_option . '_st'] == $day) ? ' selected="selected"' : '';
						${'s_limit_' . $sort_option . '_days'} .= '<option value="' . $day . '"' . $selected . '>' . ((!$day) ? $user->lang['ALL_' . strtoupper($sort_option) . 'S'] : $text) . '</option>';
					}
					${'s_limit_' . $sort_option . '_days'} .= '</select>';

					${'s_sort_' . $sort_option . '_key'} = '<select name="postsettings[' . $sort_option . '_sk]">';
					foreach ($this->entity->get('sort_by_' . $sort_option . '_text') as $key => $text)
					{
						$selected = ($data[$sort_option . '_sk'] == $key) ? ' selected="selected"' : '';
						${'s_sort_' . $sort_option . '_key'} .= '<option value="' . $key . '"' . $selected . '>' . $text . '</option>';
					}
					${'s_sort_' . $sort_option . '_key'} .= '</select>';

					${'s_sort_' . $sort_option . '_dir'} = '<select name="postsettings[' . $sort_option . '_sd]">';
					foreach ($this->entity->get('sort_dir_text') as $key => $value)
					{
						$selected = ($data[$sort_option . '_sd'] == $key) ? ' selected="selected"' : '';
						${'s_sort_' . $sort_option . '_dir'} .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
					}
					${'s_sort_' . $sort_option . '_dir'} .= '</select>';
				}

				// Output data to the template
				$this->template->assign_vars(array(
					'ERRORS'		=> $error,
					
					'VIEW_EMAIL'	=> $data['user_allow_viewemail'],
					'MASS_EMAIL'	=> $data['user_allow_massemail'],
					'ALLOW_PM'		=> $data['user_allow_pm'],
					'NOTIFY'		=> $data['user_notify'],
					'NOTIFY_PM'		=> $data['user_notify_pm'],
					'NOTIFY_EMAIL'	=> ($data['user_notify_type'] == NOTIFY_EMAIL) ? true : false,
					'NOTIFY_IM'		=> ($data['user_notify_type'] == NOTIFY_IM) ? true : false,
					'NOTIFY_BOTH'	=> ($data['user_notify_type'] == NOTIFY_BOTH) ? true : false,
					'HIDE_ONLINE'	=> $data['hideonline'],

					'VIEWIMG'		=>	phpbb_optionget(0, $options),
					'VIEWFLASH'		=>	phpbb_optionget(1, $options),
					'VIEWSMILIES'	=>	phpbb_optionget(2, $options),
					'VIEWSIGS'		=>	phpbb_optionget(3, $options),
					'VIEWAVATAR'	=>	phpbb_optionget(4, $options),
					'VIEWCENSORS'	=>	phpbb_optionget(5, $options),
					'ATTACHSIG'		=>	phpbb_optionget(6, $options),
					'BBCODE'		=>	phpbb_optionget(8, $options),
					'SMILIES'		=>	phpbb_optionget(9, $options),
					'POPUPPM'		=>	phpbb_optionget(10, $options),
					'SIG_BBCODE'	=>	phpbb_optionget(15, $options),
					'SIG_SMILIES'	=>	phpbb_optionget(16, $options),
					'SIG_LINKS'		=>	phpbb_optionget(17, $options),
					
					'USER_DATE_FORMAT'	=> $dateformat_options,
					'S_TOPIC_SORT_DAYS'	=> $s_limit_topic_days,
					'S_TOPIC_SORT_KEY'	=> $s_sort_topic_key,
					'S_TOPIC_SORT_DIR'	=> $s_sort_topic_dir,
					'S_POST_SORT_DAYS'	=> $s_limit_post_days,
					'S_POST_SORT_KEY'	=> $s_sort_post_key,
					'S_POST_SORT_DIR'	=> $s_sort_post_dir,
					
					'UA_PROGRESS_BAR'	=> html_entity_decode($this->u_action . '&amp;action=sync_users&time=' . time()),					
					'U_ACTION'		=> $this->u_action
				));

				$this->output_notification_types($this->noti_manager->get_global_subscriptions(false), $noti_setup);
				break;
		}
	}


	/**
	* Output all the notification types to the template
	*
	* @param array $subscriptions Array containing global subscriptions
	* @param string $block
	*/
	public function output_notification_types($subscriptions, $noti_setup, $block = 'notification_types')
	{global $phpbb_container;
		$default_types = array();
		if (isset($noti_setup['board']) && sizeof($noti_setup['board']))
		{
			$sql = 'SELECT * FROM ' . NOTIFICATION_TYPES_TABLE . ' 
					WHERE notification_type_name LIKE "%notification.type.%" AND notification_type_id IN (' . implode(',', $noti_setup['board']) . ')';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				(in_array($row['notification_type_name'], array('notification.type.post_in_queue', 'notification.type.topic_in_queue', 'notification.type.approve_post', 'notification.type.approve_topic'))) ? 
				$row['notification_type_name'] = 'notification.type.needs_approval' : null;

				(in_array($row['notification_type_name'], array('notification.type.report_pm', 'notification.type.report_post'))) ? 
				$row['notification_type_name'] = 'notification.type.report' : null;
								
				$default_types[$row['notification_type_name']][0] = 'notification.method.board';
			}
		}
		
		if (isset($noti_setup['email']) && sizeof($noti_setup['email']))
		{
			$sql = 'SELECT * FROM ' . NOTIFICATION_TYPES_TABLE . ' 
					WHERE notification_type_name LIKE "%notification.type.%" AND notification_type_id IN (' . implode(',', $noti_setup['email']) . ')';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				(in_array($row['notification_type_name'], array('notification.type.post_in_queue', 'notification.type.topic_in_queue', 'notification.type.approve_post', 'notification.type.approve_topic'))) ? 
				$row['notification_type_name'] = 'notification.type.needs_approval' : null;

				(in_array($row['notification_type_name'], array('notification.type.report_pm', 'notification.type.report_post'))) ? 
				$row['notification_type_name'] = 'notification.type.report' : null;

				$default_types[$row['notification_type_name']][1] = 'notification.method.email';
			}
		}

		$subscriptions = (sizeof($noti_setup)) ? $default_types : $subscriptions;
		$notification_methods = $this->noti_manager->get_subscription_methods();
		foreach ($notification_methods as $method => $method_data)
		{
			$methods[] = array('NAME' => $this->user->lang($method_data['lang']));
		}

		foreach ($this->noti_manager->get_subscription_types() as $group => $subscription_types)
		{
			$this->template->assign_block_vars($block, array(
				'GROUP_NAME'	=> $this->user->lang($group),
				'methods'			=> $methods
			));

			foreach ($subscription_types as $type => $data)
			{
				$this->template->assign_block_vars($block, array(
					'TYPE'				=> $type,
					'NAME'				=> $this->user->lang($data['lang']),
				));

				foreach ($notification_methods as $method => $method_data)
				{
					$this->template->assign_block_vars($block . '.notification_methods', array(
						'METHOD'			=> str_replace('notification.method.', '', $method_data['id']),
						'NAME'				=> $this->user->lang($method_data['lang']),
						'SUBSCRIBED'		=> (isset($subscriptions[$type]) && in_array($method_data['id'], $subscriptions[$type])) ? true : false,
					));
				}
			}
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function show_result($message)
	{
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'MESSAGE_TITLE'	=> $this->user->lang['INFORMATION'],
				'MESSAGE_TEXT'	=> $message,
				'REFRESH_DATA'	=> array(
					'time'	=> 3,
					'url'	=> $this->u_action
				)
			));
		} else
		{
			trigger_error($message . adm_back_link($this->u_action), E_USER_NOTICE);
		}
	}

	public function sync_users()
	{
		$this->batch_size = 50;

		$starttime = explode(' ', microtime());
		$starttime = $starttime[1] + $starttime[0];
		$user_counter = $this->request->variable('skiprows', 0);

		list($options, $postsettings, $generalsettings, $noti_setup) = explode('~', $this->config['user_default_options']);
		$postsettings  = str_split($postsettings);
		$generalsettings  = str_split($generalsettings);
		$noti_setup = json_decode($noti_setup, true);

		$sql_ary = array(
			'user_options' 				=> $options,
			'user_allow_viewemail'		=> $generalsettings[0],
			'user_allow_massemail'		=> $generalsettings[1],
			'user_allow_pm'				=> $generalsettings[2],
			'user_notify'				=> $generalsettings[3],
			'user_notify_type'			=> $generalsettings[4],
			'user_notify_pm'			=> $generalsettings[5],
			'user_allow_viewonline'		=> $generalsettings[6],
			'user_topic_show_days'		=> $this->entity->Index($postsettings[0], 'limit_days'),
			'user_post_show_days'		=> $this->entity->Index($postsettings[1], 'limit_days'),
			'user_topic_sortby_type'	=> $this->entity->Index($postsettings[2], 'sort_by_topic_text'),
			'user_post_sortby_type'		=> $this->entity->Index($postsettings[3], 'sort_by_post_text'),
			'user_topic_sortby_dir'		=> $this->entity->Index($postsettings[4], 'sort_dir_text'),
			'user_post_sortby_dir'		=> $this->entity->Index($postsettings[5], 'sort_dir_text')
		);

		$noti_default = (sizeof($noti_setup)) ? $noti_setup : $this->noti_manager->get_global_subscriptions(false);

		$default_types = array();
		$sql = 'SELECT * FROM ' . NOTIFICATION_TYPES_TABLE . ' WHERE notification_type_name LIKE "%notification.type.%"';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			(in_array($row['notification_type_name'], array('notification.type.post_in_queue', 'notification.type.topic_in_queue', 'notification.type.approve_post', 'notification.type.approve_topic', 'notification.type.disapprove_post', 'notification.type.disapprove_topic'))) ? 
			$row['notification_type_id'] = $this->entity->get('notification_type_needs_approval') : null;
			
			(in_array($row['notification_type_name'], array('notification.type.report_pm', 'notification.type.report_post'))) ? 
			$row['notification_type_id'] = $this->entity->get('notification_type_report') : null;
			
			if (sizeof($noti_setup))
			{				
				$default_types[$row['notification_type_name']]['notification.method.board'] = (isset($noti_default['board']) && in_array($row['notification_type_id'], $noti_default['board'])) ? 1 : 0;
				$default_types[$row['notification_type_name']]['notification.method.email'] = (isset($noti_default['email']) && in_array($row['notification_type_id'], $noti_default['email'])) ? 1 : 0;
			} else
			{
				$default_types[$row['notification_type_name']]['notification.method.board'] = (isset($noti_default[$row['notification_type_name']][0])) ? 1 : 0;
				$default_types[$row['notification_type_name']]['notification.method.email'] = (isset($noti_default[$row['notification_type_name']][1])) ? 1 : 0;
			}
		}
		
		while (still_on_time(20) && $user_counter <= $this->config['num_users'])
		{
			$sql = 'SELECT user_id FROM ' . USERS_TABLE . ' WHERE user_type IN (' . USER_NORMAL . ',' . USER_FOUNDER . ') ORDER BY user_id ASC';
			$result = $this->db->sql_query_limit($sql, $this->batch_size, $user_counter);

			while ($row = $this->db->sql_fetchrow($result))
			{
				foreach ($default_types as $item_type => $methods)
				{
					foreach($methods as $method => $value)
					{
						if ($value == 1)
						{
							$this->noti_manager->add_subscription($item_type, 0, $method, $row['user_id']);
						} else
						{
							$this->noti_manager->delete_subscription($item_type, 0, $method, $row['user_id']);
						}
					}
				}
				
				$sql1 = 'UPDATE ' . USERS_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . ' WHERE user_id = ' . $row['user_id'];
				$this->db->sql_query($sql1);
				$user_counter++;
			}
		}

		if ($user_counter <= $this->config['num_users'])
		{
			$return = array(
				'usercounter'	=> $user_counter,
				'url'			=> ($user_counter < $this->config['num_users']) ? 
									html_entity_decode($this->u_action . '&action=sync_users&skiprows=' . $user_counter . '&time=' . time()) : 0,
				'percent'		=> round((($user_counter > $this->config['num_users']) ? $this->config['num_users'] : $user_counter) / $this->config['num_users'], 3) * 100
			);
		} else
		{
			$return = array(
				'url'		=> 0,
				'percent'	=> 100
			);
		}
		echo json_encode($return);
		exit();
	}
}
