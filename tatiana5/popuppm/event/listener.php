<?php
/**
*
* @package phpBB Extension - Popup PM
* @copyright (c) 2016 Татьяна5
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace tatiana5\popuppm\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var string */
	protected $phpbb_root_path;

	/** @var string */
	protected $php_ext;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config               $config
	 * @param \phpbb\template\template           $template
	 * @param \phpbb\user                        $user
	 * @param \phpbb\db\driver\driver_interface  $db
	 * @param string                             $phpbb_root_path Root path
	 * @param string                             $php_ext
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, $phpbb_root_path, $php_ext)
	{
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
		$this->db = $db;
		$this->request = $request;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	public static function getSubscribedEvents()
	{
		return array(
			'core.user_setup'					=> 'load_language_on_setup',
			'core.page_header'					=> 'popup_pm',
			'core.ucp_prefs_view_data'          => 'ucp_prefs_get_data',
			'core.ucp_prefs_view_update_data'   => 'ucp_prefs_set_data',
		);
	}

	/**
	 * Load language file
	 *
	 * @param object $event The event object
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'tatiana5/popuppm',
			'lang_set' => 'popuppm',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * 
	 *
	 * @param object $event The event object
	 */
	public function popup_pm($event)
	{
		if (
				!empty($this->user->data['is_registered']) 
				&& ($this->user->data['user_new_privmsg'] == 1)
				&& (
						!$this->user->data['user_last_privmsg'] 
						|| $this->user->data['user_last_privmsg'] > $this->user->data['session_last_visit']
					)
			)
		{
			$pm_user_id           = 'u_' . $this->user->data['user_id'];
			$pm_user_last_privmsg = $this->user->data['user_last_privmsg'];	
				
			$sql = "SELECT p.msg_id, p.author_id, p.message_subject, p.message_time, u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, pt.folder_id
				FROM " . PRIVMSGS_TABLE . " AS p
				
				LEFT JOIN " . USERS_TABLE . " AS u
				ON u.user_id = p.author_id
				
				LEFT JOIN " . PRIVMSGS_TO_TABLE . " AS pt
				ON pt.msg_id = p.msg_id
					AND pt.user_id = " . $this->user->data['user_id'] . "
				
				WHERE p.message_time = $pm_user_last_privmsg
					AND p.to_address = '$pm_user_id'";

			$result = $this->db->sql_query($sql);

			$row = $this->db->sql_fetchrow($result);
			if ($row['msg_id'] != '')
			{
				if ($row['user_avatar'])
				{
					$this->config['popuppm_avatar_dimentions'] = 50;
					$row['user_avatar_width'] = ($row['user_avatar_width'] > $row['user_avatar_height']) ? $this->config['popuppm_avatar_dimentions'] : ($this->config['popuppm_avatar_dimentions'] / $row['user_avatar_height']) * $row['user_avatar_width'];
					$row['user_avatar_height'] = ($row['user_avatar_height'] > $row['user_avatar_width']) ? $this->config['popuppm_avatar_dimentions'] : ($this->config['popuppm_avatar_dimentions'] / $row['user_avatar_width']) * $row['user_avatar_height'];
				}

				if ($row['folder_id'] == PRIVMSGS_NO_BOX)
				{
					$row['folder_id'] = PRIVMSGS_INBOX;
				}
				
				// Assign specific vars
				$this->template->assign_vars(array(
					'POPUPPM_INFO'			=> true,
					'POPUPPM_SENDER'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
					'POPUPPM_SUBJECT'		=> $row['message_subject'],
					'POPUPPM_SUBJECT_URL'	=> append_sid("{$this->phpbb_root_path}ucp.$this->php_ext", "i=pm&amp;mode=view&amp;f=" . $row['folder_id'] . "&amp;p=" . $row['msg_id']),
					'POPUPPM_DATE'			=> $this->user->format_date($row['message_time'], $format = 'd.m.Y, H:i'),
					'POPUPPM_AVATAR'		=> ($row['user_avatar']) ? phpbb_get_user_avatar($row) : '',
					)
				);
			}
			$this->db->sql_freeresult($result);
		}

		$this->template->assign_vars(array(
			'POPUPPM_ENABLE_POPUP'		=> ($this->config['popuppm_enable_popup'] && $this->user->data['popuppm_user_popup']) ? true : false,
			'POPUPPM_YOU_NEW_PM'		=> $this->user->lang('POPUPPM_YOU_NEW_PM', (int) $this->user->data['user_new_privmsg']),

			'POPUPPM_ENABLE_BLINK'		=> ($this->config['popuppm_enable_blink'] && $this->user->data['popuppm_user_blink']) ? true : false,
			'POPUPPM_YOU_NEW_PM_BLINK'	=> $this->user->lang('POPUPPM_YOU_NEW_PM_BLINK', (int) $this->user->data['user_unread_privmsg']),
		));
	}

	/**
	 * Get user's options and display them in UCP Prefs View page
	 *
	 * @param object $event The event object
	 */
	public function ucp_prefs_get_data($event)
	{
		$data = $event['data'];

		// Request the user option vars and add them to the data array
		$data = array_merge($data, array(
			'popuppm_user_popup'    => $this->request->variable('popuppm_user_popup', (int) $this->user->data['popuppm_user_popup']),
			'popuppm_user_blink'    => $this->request->variable('popuppm_user_blink', (int) $this->user->data['popuppm_user_blink']),
		));

		// Output the data vars to the template
		$this->user->add_lang_ext('tatiana5/popuppm', 'info_acp_popuppm');
		$this->template->assign_vars(array(
			'POPUPPM_ENABLE_POPUP'		=> ($this->config['popuppm_enable_popup']) ? true : false,
			'S_PM_ENABLE_POPUP'         => $data['popuppm_user_popup'],
			
			'POPUPPM_ENABLE_BLINK'		=> ($this->config['popuppm_enable_blink']) ? true : false,
			'S_PM_ENABLE_BLINK'         => $data['popuppm_user_blink'],
		));

		$event['data'] = $data;
	}

	/**
	 * Add user options' state into the sql_array
	 *
	 * @param object $event The event object
	 */
	public function ucp_prefs_set_data($event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], array(
			'popuppm_user_popup'     => $event['data']['popuppm_user_popup'],
			'popuppm_user_blink'     => $event['data']['popuppm_user_blink'],
		));
	}
}
