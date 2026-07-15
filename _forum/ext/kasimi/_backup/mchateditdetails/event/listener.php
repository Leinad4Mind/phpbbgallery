<?php

/**
 *
 * @package phpBB Extension - mChat Edit Details
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchateditdetails\event;

use dmzx\mchat\core\log;
use dmzx\mchat\core\settings;
use phpbb\auth\auth;
use phpbb\controller\helper;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var user */
	protected $user;

	/** @var language */
	protected $lang;

	/** @var auth */
	protected $auth;

	/** @var db_interface */
	protected $db;

	/** @var helper */
	protected $helper;

	/** @var settings */
	protected $mchat_settings;

	/** @var log */
	protected $mchat_log;

	/** @var bool */
	private $user_has_u_mchat_ip = false;

	/**
	 * Constructor
	 *
	 * @param user			$user
	 * @param language		$lang
	 * @param auth			$auth
	 * @param db_interface	$db
	 * @param helper		$helper
	 * @param settings		$mchat_settings
	 * @param log			$mchat_log
	 */
	public function __construct(
		user $user,
		language $lang,
		auth $auth,
		db_interface $db,
		helper $helper,
		settings $mchat_settings = null,
		log $mchat_log = null
	)
	{
		$this->user				= $user;
		$this->lang				= $lang;
		$this->auth				= $auth;
		$this->db				= $db;
		$this->helper			= $helper;
		$this->mchat_settings	= $mchat_settings;
		$this->mchat_log		= $mchat_log;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'dmzx.mchat.ucp_settings_modify'			=> 'add_language',
			'dmzx.mchat.get_messages_modify_sql'		=> 'fetch_edit_time',
			'dmzx.mchat.message_modify_template_data'	=> 'inject_edit_time',
		];
	}

	/**
	 *
	 */
	public function add_language()
	{
		$this->lang->add_lang('common', 'kasimi/mchateditdetails');
		$this->user_has_u_mchat_ip = $this->auth->acl_get('u_mchat_ip');
	}

	/**
	 * @param data $event
	 */
	public function fetch_edit_time($event)
	{
		$sql_latest_edit = $this->db->sql_build_query('SELECT', [
			'SELECT'	=> 'MAX(l3.log_id) AS log_id',
			'FROM'		=> [$this->mchat_settings->get_table_mchat_log() => 'l3'],
			'WHERE'		=> 'l2.message_id = l3.message_id',
		]);

		$sql_edit_log = [
			'SELECT'	=> 'l2.message_id, l2.user_id as edit_user_id, l2.log_time AS edit_time',
			'FROM'		=> [$this->mchat_settings->get_table_mchat_log() => 'l2'],
			'WHERE'		=> 'l2.log_type = ' . (int) $this->mchat_log->get_type_id('edit') . ' AND l2.log_id = (' . $sql_latest_edit . ')',
		];

		$sql_array = $event['sql_array'];
		$sql_array['SELECT'] .= ', l.edit_user_id, l.edit_time, u2.username AS edit_username, u2.user_colour AS edit_user_colour';

		if ($this->user_has_u_mchat_ip)
		{
			$sql_edit_log['SELECT'] .= ', l2.log_ip AS edit_ip';
			$sql_array['SELECT'] .= ', l.edit_ip';
		}

		$sql_array['LEFT_JOIN'] = array_merge($sql_array['LEFT_JOIN'], [
			[
				'FROM'	=> ['(' . $this->db->sql_build_query('SELECT', $sql_edit_log) . ') AS' => 'l'],
				'ON'	=> 'l.message_id = m.message_id',
			],
			[
				'FROM'	=> [USERS_TABLE => 'u2'],
				'ON'	=> 'l.edit_user_id = u2.user_id',
			],
		]);

		$event['sql_array'] = $sql_array;
	}

	/**
	 * @param data $event
	 */
	public function inject_edit_time($event)
	{
		$row = $event['row'];

		if (!empty($row['edit_time']))
		{
			if (!isset($row['edit_username']))
			{
				$row['edit_user_id'] = ANONYMOUS;
			}

			$edit_details_template_data = [
				'MCHAT_EDIT_DETAILS'	=> true,
				'MCHAT_EDIT_USER'		=> get_username_string('full', $row['edit_user_id'], $row['edit_username'], $row['edit_user_colour'], $this->user->lang('GUEST')),
				'MCHAT_EDIT_TIME'		=> $this->user->format_date($row['edit_time'], $this->mchat_settings->cfg('mchat_date'), false),
				'MCHAT_EDIT_TIME_TITLE'	=> $this->user->format_date($row['edit_time'], $this->mchat_settings->cfg('mchat_date'), true),
			];

			if ($this->user_has_u_mchat_ip)
			{
				$edit_details_template_data = array_merge($edit_details_template_data, [
					'MCHAT_EDIT_IP'			=> $row['edit_ip'],
					'MCHAT_EDIT_WHOIS_USER'	=> $this->user->lang('MCHAT_WHOIS_USER', $row['edit_ip']),
					'MCHAT_U_EDIT_IP'		=> $this->helper->route('dmzx_mchat_page_whois_controller', ['ip' => $row['edit_ip']]),
				]);
			}

			$event['template_data'] = array_merge($event['template_data'], $edit_details_template_data);
		}
	}
}
