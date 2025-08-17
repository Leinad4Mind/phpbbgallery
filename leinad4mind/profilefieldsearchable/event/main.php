<?php

/**
 *
 * Profile Field Searchable. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2019, Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\profilefieldsearchable\event;

use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\event\data;
use phpbb\event\dispatcher;
use phpbb\request\request_interface;
use phpbb\template\template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main implements EventSubscriberInterface
{
	/** @var auth */
	protected $auth;

	/** @var request_interface */
	protected $request;

	/** @var config */
	protected $config;

	/** @var db_interface */
	protected $db;

	/** @var template */
	protected $template;

	/** @var dispatcher */
	protected $dispatcher;

	/** @var array */
	protected $cpf_search_queries = [];

	/**
	 * @param auth				$auth
	 * @param request_interface	$request
	 * @param config			$config
	 * @param db_interface		$db
	 * @param template			$template
	 * @param dispatcher		$dispatcher
	 */
	public function __construct(
		auth $auth,
		request_interface $request,
		config $config,
		db_interface $db,
		template $template,
		dispatcher $dispatcher
	)
	{
		$this->auth = $auth;
		$this->request = $request;
		$this->config = $config;
		$this->db = $db;
		$this->template = $template;
		$this->dispatcher = $dispatcher;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.memberlist_modify_sql_query_data'			=> 'memberlist_modify_sql_query_data',
			'core.memberlist_modify_sort_pagination_params'	=> 'memberlist_modify_sort_pagination_params',
			'core.acp_profile_create_edit_init'				=> 'acp_profile_create_edit_init',
			'core.acp_profile_create_edit_save_before'		=> 'acp_profile_create_edit_save_before',
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

		$field_names = [];
		$text_fields = [];

		foreach ($rows as $row)
		{
			$field_names[] = $row['field_name'];
			$text_fields[] = [
				'FIELD_ID'	=> $row['field_name'],
				'LANG_NAME'	=> $row['lang_name'],
				'VALUE'		=> $this->request->variable($row['field_name'], '', true),
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
				GROUP BY lang_name, field_name, field_ident, field_order
				ORDER BY field_order, option_id DESC";

		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$field_names2 = [];
		$option_fields = [];
		$lang_values = [];

		for ($i = 0; $i < count($rows); $i++)
		{
			$option_fields[$i] = [
				'FIELD_ID'	=> $rows[$i]['field_ident'],
				'LANG_NAME'	=> $rows[$i]['lang_name'],
				'SELECTED'	=> $this->request->variable($rows[$i]['field_ident'], -1),
			];

			$row_option_ids = explode(',', $rows[$i]['option_id']);
			$row_lang_values = explode(',', $rows[$i]['lang_value']);

			for ($j = 0; $j < count($row_option_ids); $j++)
			{
				$row_option_id = $row_option_ids[$j];
				$row_lang_value = $row_lang_values[$j];

				$lang_values[$i][$row_option_id] = [
					'OPTION_ID'		=> $row_option_id,
					'LANG_VALUE'	=> $row_lang_value,
				];
			}

			ksort($lang_values[$i]);

			$field_names2[] = $rows[$i]['field_name'];
		}

		foreach ($field_names as $extend_params)
		{
			$search_params[] = $extend_params;
		}

		foreach ($field_names2 as $extend_params2)
		{
			$search_params[] = $extend_params2;
		}

		$mode = $this->request->variable('mode', '');

		if (($field_names || $field_names2) && (($mode == '' || $mode == 'searchuser') || array_intersect($this->request->variable_names(request_interface::GET), $search_params)) && ($this->config['load_search'] || $this->auth->acl_get('a_')))
		{
			$sql_where = $event['sql_where'];

			$any = $this->db->get_any_char();

			foreach ($field_names as $row_field)
			{
				$value = $this->request->variable($row_field, '', true);
				$sql_where .= $value ? " AND LOWER(fd.pf_$row_field) " . $this->db->sql_like_expression($any . str_replace('*', $any, strtolower($value)) . $any) . ' ' : '';
				$this->cpf_search_queries[] = urlencode($row_field) . '=' . urlencode($value);
			}

			foreach ($field_names2 as $row_field)
			{
				$value = $this->request->variable($row_field, -1);
				$sql_where .= $value !== -1 ? " AND LOWER(fd.pf_$row_field) = " . ($value + 1) . ' ' : '';
				$this->cpf_search_queries[] = urlencode($row_field) . '=' . (int) $value;
			}

			$event['sql_where'] = $sql_where;

			$sql_from = str_replace(', ' . USER_GROUP_TABLE . ' ug ', '', $event['sql_from'], $count);

			if ($count)
			{
				$sql_from .= ' JOIN ' . USER_GROUP_TABLE . ' ug ON (u.user_id = ug.user_id) ';
			}

			$event['sql_from'] = $sql_from . ' LEFT JOIN ' . PROFILE_FIELDS_DATA_TABLE . ' fd ON (u.user_id = fd.user_id)';
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
	public function memberlist_modify_sort_pagination_params(data $event)
	{
		$event['params'] = array_merge($event['params'], $this->cpf_search_queries);
		$event['sort_params'] = array_merge($event['sort_params'], $this->cpf_search_queries);
	}

	/**
	 * @param data $event
	 */
	public function acp_profile_create_edit_init(data $event)
	{
		$is_searchable = isset($event['field_row']['field_searchable']) ? $event['field_row']['field_searchable'] : false;

		$this->template->assign_var('S_FIELD_SEARCHABLE', $is_searchable);

		$event->update_subarray('field_row', 'field_searchable', $is_searchable);

		$visibility_ary = $event['visibility_ary'];
		$visibility_ary[] = 'field_searchable';
		$event['visibility_ary'] = $visibility_ary;

		$exclude = $event['exclude'];
		$exclude[1][] = 'field_searchable';
		$event['exclude'] = $exclude;
	}

	/**
	 * @param data $event
	 */
	public function acp_profile_create_edit_save_before(data $event)
	{
		$is_searchable = $is_searchable = $this->request->variable('field_searchable', false);

		$event->update_subarray('profile_fields', 'field_searchable', $is_searchable);
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
