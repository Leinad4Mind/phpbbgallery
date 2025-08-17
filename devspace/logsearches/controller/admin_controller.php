<?php
/**
*
* @package Log Searches Extension
* @copyright (c) 2015 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\logsearches\controller;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\pagination;
use phpbb\user;
use phpbb\auth\auth;
use phpbb\language\language;
use phpbb\log\log;
use david63\logsearches\core\functions;

/**
* Admin controller
*/
class admin_controller implements admin_interface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\pagination */
	protected $pagination;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \david63\logsearches\core\functions */
	protected $functions;

	/**
	* The database table the search log is stored in
	*
	* @var string
	*/
	protected $search_log_table;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config					$config			Config object
	* @param \phpbb\db\driver\driver_interface		$db				The db connection
	* @param \phpbb\request\request					$request		Request object
	* @param \phpbb\template\template				$template		Template object
	* @param \phpbb\pagination						$pagination		Pagination object
	* @param \phpbb\user							$user			User object
	* @param \phpbb\auth\auth 						$auth			Auth object
	* @param \phpbb\language\language				$language		Language object
	* @param \phpbb\log\log							$log			Log object
	* @param \david63\logsearches\core\functions	functions		Functions for the extension
	*
	* @return \david63\logsearches\controller\admin_controller
	* @access public
	*/
	public function __construct(config $config, driver_interface $db, request $request, template $template, pagination $pagination, user $user, auth $auth, $search_log_table, language $language, log $log, functions $functions)
	{
		$this->config			= $config;
		$this->db  				= $db;
		$this->request			= $request;
		$this->template			= $template;
		$this->pagination		= $pagination;
		$this->user				= $user;
		$this->auth				= $auth;
		$this->search_log_table	= $search_log_table;
		$this->language			= $language;
		$this->log				= $log;
		$this->functions		= $functions;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		// Add the language files
		$this->language->add_lang('acp_logsearches', $this->functions->get_ext_namespace());

		// Create a form key for preventing CSRF attacks
		$form_key = 'searchlog';
		add_form_key($form_key);

		$back = false;

		// Is the form being submitted
		if ($this->request->is_set_post('submit'))
		{
			// Is the submitted form is valid
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// If no errors, process the form data
			// Set the options the user configured
			$this->set_options();

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'SEARCH_LOG_LOG');

			// Option settings have been updated and logged
			// Confirm this to the user and provide link back to previous page
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		// Template vars for header panel
		$this->template->assign_vars(array(
			'HEAD_TITLE'		=> $this->language->lang('SEARCH_LOG'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('SEARCH_LOG_EXPLAIN'),

			'NAMESPACE'			=> $this->functions->get_ext_namespace('twig'),

			'S_BACK'			=> $back,
			'S_VERSION_CHECK'	=> $this->functions->version_check(),

			'VERSION_NUMBER'	=> $this->functions->get_this_version(),
		));

		$this->template->assign_vars(array(
			'SEARCH_LOG_ALL'		=> isset($this->config['search_log_all']) ? $this->config['search_log_all'] : '',
			'SEARCH_LOG_PER_PAGE'	=> isset($this->config['search_log_per_page']) ? $this->config['search_log_per_page'] : '',
			'SEARCH_LOG_PRUNE_ALL'	=> isset($this->config['search_log_prune_all']) ? $this->config['search_log_prune_all'] : '',
			'SEARCH_LOG_PRUNE_DAYS'	=> isset($this->config['search_log_prune_days']) ? $this->config['search_log_prune_days'] : '',
			'U_ACTION'				=> $this->u_action,
		));
	}

	/**
	* Set the options a user can configure
	*
	* @return null
	* @access protected
	*/
	protected function set_options()
	{
		$this->config->set('search_log_all', $this->request->variable('search_log_all', ''));
		$this->config->set('search_log_per_page', $this->request->variable('search_log_per_page', ''));
		$this->config->set('search_log_prune_all', $this->request->variable('search_log_prune_all', 0));
		$this->config->set('search_log_prune_days', $this->request->variable('search_log_prune_days', 0));
	}

	/**
	* Display the output for this extension
	*
	* @return null
	* @access public
	*/
	public function display_output()
	{
		// Start initial var setup
		$action		= $this->request->variable('action', '');
		$deletemark = $this->request->variable('delmarked', false, false, \phpbb\request\request_interface::POST);
		$marked		= $this->request->variable('mark', array(0));
		$start		= $this->request->variable('start', 0);

		// Sort keys
		$sort_days	= $this->request->variable('st', 0);
		$sort_dir	= $this->request->variable('sd', 'd');
		$sort_key	= $this->request->variable('sk', 't');

		// Sorting
		$limit_days = array(0 => $this->language->lang('ALL_ENTRIES'), 1 => $this->language->lang('1_DAY'), 7 => $this->language->lang('7_DAYS'), 14 => $this->language->lang('2_WEEKS'), 30 => $this->language->lang('1_MONTH'), 90 => $this->language->lang('3_MONTHS'), 180 => $this->language->lang('6_MONTHS'), 365 => $this->language->lang('1_YEAR'));
		$sort_by_text = array('u' => $this->language->lang('SORT_USERNAME'), 't' => $this->language->lang('SORT_DATE'), 'i' => $this->language->lang('SORT_IP'), 'o' => $this->language->lang('SORT_KEYWORDS'));
		$sort_by_sql = array('u' => 'u.username_clean', 't' => 'l.log_time', 'i' => 'l.log_ip', 'o' => 'l.log_data');

		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

		// Define where and sort sql for use in displaying logs
		$sql_where	= ($sort_days) ? (time() - ($sort_days * 86400)) : 0;
		$sql_sort	= $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');

		$log_count = 0;

		// Get total log count for pagination
		$sql = 'SELECT COUNT(log_id) AS total_logs
			FROM ' . $this->search_log_table . '
				WHERE log_time >= ' . (int) $sql_where;
		$result		= $this->db->sql_query($sql);
		$log_count	= (int) $this->db->sql_fetchfield('total_logs');
		$this->db->sql_freeresult($result);

		$action		= $this->u_action . "&amp;$u_sort_param";
		$start		= $this->pagination->validate_start($start, $this->config['search_log_per_page'], $log_count);
		$this->pagination->generate_template_pagination($action, 'pagination', 'start', $log_count, $this->config['search_log_per_page'], $start);

		$sql = 'SELECT l.*, u.username, u.username_clean, u.user_colour
			FROM ' . $this->search_log_table . ' l, ' . USERS_TABLE . ' u
			WHERE u.user_id = l.user_id
			AND l.log_time >= ' . (int) $sql_where . "
			ORDER BY $sql_sort";
		$result = $this->db->sql_query_limit($sql, $this->config['search_log_per_page'], $start);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$search_data = json_decode($row['log_data'], true);

			$this->template->assign_block_vars('log', array(
				'AUTHOR'	=> (array_key_exists('a', $search_data)) ? $search_data['a'] : '',
				'DATA'		=> $this->get_lang_var('SEARCH_TYPE',$search_data['t']),
				'DATE'		=> $this->user->format_date($row['log_time']),
				'FORA'		=> $search_data['f'],
				'ID'		=> $row['log_id'],
				'IP'		=> $row['log_ip'],
				'KEYWORDS'	=> (array_key_exists('k', $search_data)) ? $search_data['k'] : '',
				'TITLE'		=> $row['log_title'],
				'TYPE'		=> ($row['log_search_type']) ? $this->language->lang('SEARCH_SUCCESS') : $this->language->lang('SEARCH_FAIL'),
				'USERNAME'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
			));
		}
		$this->db->sql_freeresult($result);

		// Template vars for header panel
		$this->template->assign_vars(array(
			'HEAD_TITLE'		=> $this->language->lang('SEARCH_LOG'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('SEARCH_LOG_EXPLAIN'),

			'NAMESPACE'			=> $this->functions->get_ext_namespace('twig'),

			'VERSION_NUMBER'	=> $this->functions->get_this_version(),
		));

		$this->template->assign_vars(array(
			'S_LIMIT_DAYS'	=> $s_limit_days,
			'S_SORT_DIR'	=> $s_sort_dir,
			'S_SORT_KEY'	=> $s_sort_key,

			'U_ACTION'		=> $this->u_action . "&amp;$u_sort_param&amp;start=$start",
		));
	}

	/**
	* Get a language variable from a language variable array
	*
	* @return $data
	* @access protected
	*/
	public function get_lang_var($lang_array, $lang_key)
	{
		foreach ($this->language->lang_raw($lang_array) as $key => $data)
		{
			if ($key == $lang_key)
			{
				return $data;
			}
		}
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
