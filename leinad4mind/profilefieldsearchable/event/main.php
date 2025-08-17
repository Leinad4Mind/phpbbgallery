<?php

/**
 *
 * Profile Field Searchable. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\profilefieldsearchable\event;

use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\event\data;
use phpbb\event\dispatcher;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main implements EventSubscriberInterface
{
	/** @var user */
	protected $user;

	/** @var language */
	protected $lang;

	/** @var auth */
	protected $auth;

	/** @var request_interface */
	protected $request;

	/** @var config */
	protected $config;

	/** @var db_interface */
	protected $db;

	/** @var log_interface */
	protected $log;

	/** @var template */
	protected $template;

	/** @var dispatcher */
	protected $dispatcher;

	/** @var string */
	protected $u_action;

	/**
	 * @param user				$user
	 * @param language			$lang
	 * @param auth				$auth
	 * @param request_interface	$request
	 * @param config			$config
	 * @param db_interface		$db
	 * @param log_interface		$log
	 * @param template			$template
	 * @param dispatcher		$dispatcher
	 */
	public function __construct(
		user $user,
		language $lang,
		auth $auth,
		request_interface $request,
		config $config,
		db_interface $db,
		log_interface $log,
		template $template,
		dispatcher $dispatcher
	)
	{
		$this->user = $user;
		$this->lang = $lang;
		$this->auth = $auth;
		$this->request = $request;
		$this->config = $config;
		$this->db = $db;
		$this->log = $log;
		$this->template = $template;
		$this->dispatcher = $dispatcher;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.memberlist_modify_sql_query_data'	=> 'memberlist_modify_sql_query_data',
			'core.acp_profile_action'				=> 'acp_profile_action',
			'core.acp_profile_modify_profile_row'	=> 'acp_profile_modify_profile_row',
		];
	}

	/**
	 * @param data $event
	 */
	public function memberlist_modify_sql_query_data(data $event)
	{
		$search_params = ['username', 'email', 'jabber', 'search_group_id', 'joined_select', 'active_select', 'count_select', 'joined', 'active', 'count', 'ip'];

		$sql = 'SELECT field_name, lang_name
			FROM ' . PROFILE_FIELDS_TABLE . ' f, ' . PROFILE_LANG_TABLE . ' a, ' . LANG_TABLE . ' l
			WHERE field_active = 1
				AND field_searchable = 1
				AND field_show_profile = 1
				AND ' . $this->db->sql_in_set('f.field_type', [$this->cpf_type(FIELD_BOOL), $this->cpf_type(FIELD_DROPDOWN)], true) . "
				AND f.field_id = a.field_id
				AND a.lang_id = l.lang_id 
				AND l.lang_iso = '" . $this->db->sql_escape($this->config['default_lang']) . "'
			ORDER BY field_order";

		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$row_field_nom = [];
		$text_fields = [];

		foreach ($rows as $row)
		{
			$row_field_nom[] = $row['field_name'];
			$text_fields[] = [
				'CPF_LANG_NAME' => $row['lang_name'],
				'CPF_NAME'      => $row['field_name']
			];
		}

		$sql = 'SET SESSION group_concat_max_len = 4096';
		$this->db->sql_query($sql);

		$sql = 'SELECT field_name, field_ident, GROUP_CONCAT(lang_value) as lang_value, lang_name, GROUP_CONCAT(option_id) as option_id
				FROM ' . PROFILE_FIELDS_TABLE . ' ft, ' . PROFILE_FIELDS_LANG_TABLE . ' f, ' . PROFILE_LANG_TABLE . ' a, ' . LANG_TABLE . ' l 
				WHERE ft.field_active = 1
					AND field_searchable = 1
					AND field_show_profile = 1
					AND ' . $this->db->sql_in_set('f.field_type', [$this->cpf_type(FIELD_INT), $this->cpf_type(FIELD_STRING), $this->cpf_type(FIELD_TEXT), $this->cpf_type(FIELD_DATE)], true) . "
					AND f.field_id = a.field_id
					AND ft.field_id = a.field_id
					AND f.lang_id = l.lang_id
					AND l.lang_id = a.lang_id
					AND l.lang_iso = '" . $this->db->sql_escape($this->config['default_lang']) . "'	
					GROUP BY lang_name
				ORDER BY field_order, option_id DESC";

		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$row_field_nom2 = [];
		$option_fields = [];
		$lang_values = [];

		foreach ($rows as $row)
		{
			$option_fields[] = [
				'FIELD_ID'		=> $row['field_ident'],
				'LANG_NAME'		=> $row['lang_name'],
				'lang_values'	=> [],
			];

			end($option_fields);
			$option_field_key = key($option_fields);

			$row_option_id  = explode(',', $row['option_id']);
			$row_lang_value = explode(',', $row['lang_value']);

			for ($i = 0; $i < count($row_option_id); $i++)
			{
				$lang_values[$option_field_key][] = [
					'OPTION_ID'		=> $row_option_id[$i] + 1,
					'LANG_VALUE'	=> $row_lang_value[$i],
				];
			}

			$row_field_nom2[] = $row['field_name'];
		}

		foreach($row_field_nom as $extend_params)
		{
			$search_params[] = $extend_params;
		}

		foreach ($row_field_nom2 as $extend_params2)
		{
			$search_params[] = $extend_params2;
		}

		$mode = $this->request->variable('mode', '');

		if (($row_field_nom || $row_field_nom2) && (($mode == '' || $mode == 'searchuser') || array_intersect($this->request->variable_names(request_interface::GET), $search_params)) && ($this->config['load_search'] || $this->auth->acl_get('a_')))
		{
			$sql_where = $event['sql_where'];

			foreach ($row_field_nom as $row_field)
			{
				$$row_field = $this->request->variable($row_field, '', true);
				$sql_where .= $$row_field ? " AND fd.pf_$row_field " . $this->db->sql_like_expression(str_replace('*', $this->db->get_any_char(), $$row_field)) . ' ' : '';
			}

			foreach ($row_field_nom2 as $row_field2)
			{
				$$row_field2 = $this->request->variable($row_field2, 0);
				$sql_where .= $$row_field2 && $$row_field2 !== 'x' ? " AND fd.pf_$row_field2 " . $this->db->sql_like_expression(str_replace('*', $this->db->get_any_char(), $$row_field2)) . ' ' : '';
			}

			$event['sql_where'] = $sql_where;

			$event['sql_from'] = $event['sql_from'] . ' LEFT JOIN ' . PROFILE_FIELDS_DATA_TABLE . ' fd ON (u.user_id = fd.user_id)';
		}

		$vars = [
			'text_fields',
			'option_fields',
			'lang_values',
		];

		extract($this->dispatcher->trigger_event('leinad4mind.profilefieldsearchable.profile_fields_assign_template_before', compact($vars)));

		$this->template->assign_block_vars_array('text_fields', $text_fields);

		foreach ($option_fields as $option_field_key => $option_field)
		{
			$this->template->assign_block_vars('option_fields', $option_field);
			$this->template->assign_block_vars_array('option_fields.lang_values', $lang_values[$option_field_key]);
		}
	}

	/**
	 * @param data $event
	 */
	public function acp_profile_action(data $event)
	{
		$this->u_action = $event['u_action'];

		switch ($event['action'])
		{
			case 'searchable':

				$field_id = $this->request->variable('field_id', 0);

				if (!$field_id)
				{
					trigger_error($this->lang->lang('NO_FIELD_ID') . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$sql = 'UPDATE ' . PROFILE_FIELDS_TABLE . '
					SET field_searchable = 1
					WHERE field_id = ' . (int) $field_id;
				$this->db->sql_query($sql);

				$sql = 'SELECT field_ident
					FROM ' . PROFILE_FIELDS_TABLE . '
					WHERE field_id = ' . (int) $field_id;
				$result = $this->db->sql_query($sql);
				$field_ident = (string) $this->db->sql_fetchfield('field_ident');
				$this->db->sql_freeresult($result);

				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PROFILE_FIELD_SEARCHABLE', false, [$field_ident]);
				trigger_error($this->lang->lang('PROFILE_FIELD_SEARCHABLE') . adm_back_link($this->u_action));

			break;

			case 'unsearchable':

				$field_id = $this->request->variable('field_id', 0);

				if (!$field_id)
				{
					trigger_error($this->lang->lang('NO_FIELD_ID') . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$sql = 'UPDATE ' . PROFILE_FIELDS_TABLE . '
					SET field_searchable = 0
					WHERE field_id = ' . (int) $field_id;
				$this->db->sql_query($sql);

				$sql = 'SELECT field_ident
					FROM ' . PROFILE_FIELDS_TABLE . '
					WHERE field_id = ' . (int) $field_id;
				$result = $this->db->sql_query($sql);
				$field_ident = (string) $this->db->sql_fetchfield('field_ident');
				$this->db->sql_freeresult($result);

				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PROFILE_FIELD_UNSEARCHABLE', false, [$field_ident]);
				trigger_error($this->lang->lang('PROFILE_FIELD_UNSEARCHABLE') . adm_back_link($this->u_action));

			break;
		}
	}

	/**
	 * @param data $event
	 */
	public function acp_profile_modify_profile_row(data $event)
	{
		$event['field_block'] = array_merge($event['field_block'], [
			'L_SEARCHABLE_UNSEARCHABLE'	=> $this->lang->lang($event['row']['field_searchable'] ? 'UNSEARCHABLE' : 'SEARCHABLE'),
			'U_SEARCHABLE_UNSEARCHABLE'	=> $this->u_action . '&amp;action=' . ($event['row']['field_searchable'] ? 'unsearchable' : 'searchable') . '&amp;field_id=' . $event['row']['field_id'],
		]);
	}

	/**
	 * Method taken from \phpbb\db\migration\data\v310\profilefield_types
	 *
	 * @param $field_type
	 * @return string
	 */
	protected function cpf_type($field_type)
	{
		switch ($field_type)
		{
			case FIELD_INT:
				return 'profilefields.type.int';
			case FIELD_STRING:
				return 'profilefields.type.string';
			case FIELD_TEXT:
				return 'profilefields.type.text';
			case FIELD_BOOL:
				return 'profilefields.type.bool';
			case FIELD_DROPDOWN:
				return 'profilefields.type.dropdown';
			case FIELD_DATE:
				return 'profilefields.type.date';
			default:
				return $field_type;
		}
	}
}
