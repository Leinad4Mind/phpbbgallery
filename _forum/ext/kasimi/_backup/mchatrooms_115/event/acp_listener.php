<?php

/**
 *
 * @package phpBB Extension - mChat Rooms Addon
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatrooms\event;

use kasimi\mchatrooms\core\constants;
use kasimi\mchatrooms\core\functions;
use phpbb\db\driver\driver_interface;
use phpbb\event\data;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class acp_listener implements EventSubscriberInterface
{
	/** @var user */
	protected $user;

	/** @var request_interface */
	protected $request;

	/** @var template */
	protected $template;

	/** @var driver_interface */
	protected $db;

	/** @var functions */
	protected $functions;

	/** @var constants */
	protected $constants;

	/**
 	 * Constructor
	 *
	 * @param user				$user
	 * @param request_interface	$request
	 * @param template			$template
	 * @param driver_interface	$db
	 * @param functions			$functions
	 * @param constants			$constants
	 */
	public function __construct(
		user $user,
		request_interface $request,
		template $template,
		driver_interface $db,
		functions $functions,
		constants $constants
	)
	{
		$this->user			= $user;
		$this->request		= $request;
		$this->template		= $template;
		$this->db			= $db;
		$this->functions	= $functions;
		$this->constants	= $constants;
	}

	/**
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.permissions'										=> 'permissions',
			'core.adm_page_header'									=> 'adm_page_header',
			'dmzx.mchat.global_settings_modify'						=> 'global_settings_modify',
			'dmzx.mchat.acp_globalsettings_modify_template_data'	=> array(array('add_lang', 10), array('acp_globalsettings_delete_rooms')),
		);
	}

	/**
	 * @param data $event
	 */
	public function permissions($event)
	{
		$permission_keys = array(
			'u_mchatrooms_view',
			'u_mchatrooms_create',
			'u_mchatrooms_create_private',
			'u_mchatrooms_invite',
			'u_mchatrooms_edit_own',
			'u_mchatrooms_edit_all',
			'u_mchatrooms_delete_own',
			'u_mchatrooms_delete_all',
			'u_mchatrooms_protected',
			'u_mchatrooms_masterkey',
		);

		$permissions = array();

		foreach ($permission_keys as $permission_key)
		{
			$permissions[$permission_key] = array(
				'lang'	=> 'ACL_' . strtoupper($permission_key),
				'cat'	=> 'mchatrooms',
			);
		}

		$event['permissions'] = array_merge($event['permissions'], $permissions);

		$event['categories'] = array_merge($event['categories'], array(
			'mchatrooms' => 'ACP_PERMISSIONS_CAT_MCHATROOMS',
		));
	}

	/**
	 * Display warnings
	 */
	public function adm_page_header()
	{
		if ($this->should_display_rooms_warning())
		{
			// Display warning when disabling Rooms while mChat is still enabled
			$this->add_lang();
			$this->template->assign_var('L_CONFIRM_MESSAGE', $this->user->lang('EXTENSION_DISABLE_CONFIRM', 'mChat Rooms Addon') . $this->user->lang('MCHATROOMS_DISABLE_WARNING'));
		}
		else if ($this->should_display_mchat_warning())
		{
			// Display warning when deleting mChat while Rooms is still enabled
			$this->add_lang();
			$this->template->assign_var('L_CONFIRM_MESSAGE', $this->user->lang('EXTENSION_DELETE_DATA_CONFIRM', 'mChat') . $this->user->lang('MCHATROOMS_DELETE_DATA_WARNING'));
		}
	}

	/**
	 * @return bool
	 */
	protected function should_display_rooms_warning()
	{
		$request_data = array(
			'ext_name'	=> 'kasimi/mchatrooms',
			'action'	=> 'disable_pre',
			'mode' 		=> 'main',
		);

		foreach ($request_data as $key => $value)
		{
			if ($this->request->variable($key, '') !== $value)
			{
				return false;
			}
		}

		return $this->constants->table_mchat_messages !== null && $this->db->get_row_count($this->constants->table_mchat_rooms) > 1;
	}

	/**
	 * @return bool
	 */
	protected function should_display_mchat_warning()
	{
		$request_data = array(
			'ext_name'	=> 'dmzx/mchat',
			'action'	=> 'delete_data_pre',
			'mode' 		=> 'main',
		);

		foreach ($request_data as $key => $value)
		{
			if ($this->request->variable($key, '') !== $value)
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * @param data $event
	 */
	public function global_settings_modify($event)
	{
		$event['global_settings'] = array_merge($event['global_settings'], array(
			'mchat_max_rooms'			=> array('default' => 10, 'validation' => array('num', false, 0, 99)),
			'mchat_max_private_rooms'	=> array('default' => 10, 'validation' => array('num', false, 0, 99)),
			'mchat_invite_expiration'	=> array('default' => 15, 'validation' => array('num', false, 0, 999)),
			'mchat_max_invites'			=> array('default' => 10, 'validation' => array('num', false, 0, 999)),
			'mchat_prune_skip_rooms'	=> array('default' => 0),
		));
	}

	/**
	 *
	 */
	public function add_lang()
	{
		$this->user->add_lang_ext('kasimi/mchatrooms', array('mchatrooms_acp'));
	}

	/**
	 * @param data $event
	 */
	public function acp_globalsettings_delete_rooms($event)
	{
		if (!$event['error'] && $this->user->data['user_type'] == USER_FOUNDER && $this->request->is_set_post('mchat_rooms_delete') && $this->request->variable('mchat_rooms_delete_confirm', false) && check_form_key('acp_mchat'))
		{
			$this->functions->delete_rooms();
			trigger_error($this->user->lang('MCHATROOMS_DELETED'));
		}
	}
}
