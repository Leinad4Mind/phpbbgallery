<?php
/**
 *
 * @package Active Sessions Extension
 * @copyright (c) 2015 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\activesessions\controller;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\pagination;
use phpbb\user;
use phpbb\language\language;
use david63\activesessions\core\functions;

/**
 * Admin controller
 */
class admin_controller
{
	/** @var config */
	protected $config;

	/** @var driver_interface */
	protected $db;

	/** @var request */
	protected $request;

	/** @var template */
	protected $template;

	/** @var pagination */
	protected $pagination;

	/** @var user */
	protected $user;

	/** @var language */
	protected $language;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpBB extension */
	protected $php_ext;

	/** @var functions */
	protected $functions;

	/** @var array phpBB tables */
	protected $tables;

	/** @var string */
	protected $ext_images_path;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor for admin controller
	 *
	 * @param config			$config             Config object
	 * @param driver_interface	$db                 Database object
	 * @param request			$request            Request object
	 * @param template			$template           Template object
	 * @param pagination		$pagination         Pagination object
	 * @param user				$user               User object
	 * @param language			$language           Language object
	 * @param string			$root_path          phpBB root path
	 * @param string			$php_ext            PHP extension
	 * @param functions     	$functions          Functions for the extension
	 * @param array				$tables             phpBB db tables
	 * @param string			$ext_images_path    Path to this extension's images
	 *
	 * @return \david63\activesessions\controller\admin_controller
	 * @access public
	 */
	public function __construct(config $config, driver_interface $db, request $request, template $template, pagination $pagination, user $user, language $language, string $root_path, string $php_ext, functions $functions, array $tables, string $ext_images_path)
	{
		$this->config          = $config;
		$this->db              = $db;
		$this->request         = $request;
		$this->template        = $template;
		$this->pagination      = $pagination;
		$this->user            = $user;
		$this->language        = $language;
		$this->root_path       = $root_path;
		$this->php_ext         = $php_ext;
		$this->functions       = $functions;
		$this->tables          = $tables;
		$this->ext_images_path = $ext_images_path;
	}

	/**
	 * Display the output for this extension
	 *
	 * @return null
	 * @access public
	 */
	public function display_output()
	{
		// Add the language files
		$this->language->add_lang(['acp_activesessions', 'acp_common'], $this->functions->get_ext_namespace());

		$back = false;

		// Start initial var setup
		$action        = $this->request->variable('action', '');
		$clear_filters = $this->request->variable('clear_filters', '');
		$start         = $this->request->variable('start', 0);
		$fc            = $this->request->variable('fc', '');
		$sort_key      = $this->request->variable('sk', 's');
		$sd            = $sort_dir = $this->request->variable('sd', 'd');

		if ($clear_filters)
		{
			$fc       = '';
			$sd       = $sort_dir       = 'a';
			$sort_key = 'u';
		}

		$sort_dir = ($sort_dir == 'd') ? ' DESC' : ' ASC';

		$order_ary = [
			'i' => 's.session_ip' . $sort_dir . ', u.username_clean ASC',
			's' => 's.session_start' . $sort_dir . ', u.username_clean ASC',
			'u' => 'u.username_clean' . $sort_dir,
		];

		$filter_by = '';
		if ($fc == 'other')
		{
			for ($i = ord($this->language->lang('START_CHARACTER')); $i <= ord($this->language->lang('END_CHARACTER')); $i++)
			{
				$filter_by .= ' AND u.username_clean ' . $this->db->sql_not_like_expression(utf8_clean_string(chr($i)) . $this->db->get_any_char());
			}
		}
		else if ($fc)
		{
			$filter_by .= ' AND u.username_clean ' . $this->db->sql_like_expression(utf8_clean_string(substr($fc, 0, 1)) . $this->db->get_any_char());
		}

		$sql = $this->db->sql_build_query('SELECT', [
			'SELECT' => 'u.user_id, u.username, u.username_clean, u.user_colour, u.user_ip, s.*, f.forum_id, f.forum_name',
			'FROM' => [
				$this->tables['users'] => 'u',
				$this->tables['sessions'] => 's',
			],
			'LEFT_JOIN' => [
				[
					'FROM' => [$this->tables['forums'] => 'f'],
					'ON' => 's.session_forum_id = f.forum_id',
				],
			],
			'WHERE' => 'u.user_id = s.session_user_id
                AND s.session_time >= ' . (time() - ($this->config['session_length'] * 60)) . $filter_by,
			'ORDER_BY' => ($sort_key == '') ? 'u.username_clean' : $order_ary[$sort_key],
		]);

		$result = $this->db->sql_query_limit($sql, $this->config['topics_per_page'], $start);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('active_sessions', [
				'ADMIN' 			=> ($row['session_admin']) ? $this->language->lang('YES') : $this->language->lang('NO'),
				'AUTO_LOGIN' 		=> ($row['session_autologin']) ? $this->language->lang('YES') : $this->language->lang('NO'),

				'BROWSER' 			=> $row['session_browser'],

				'FORUM' 			=> ($row['forum_id'] > 0) ? $row['forum_name'] : '',

				'LAST_VISIT' 		=> $this->user->format_date($row['session_last_visit']),

				'SESSION_FORWARD'	=> $row['session_forwarded_for'],
				'SESSION_ID' 		=> $row['session_id'],
				'SESSION_IP' 		=> $row['session_ip'],
				'SESSION_KEY' 		=> $row['session_id'] . $row['user_id'], // Create a unique key for the js script
				'SESSION_ONLINE' 	=> ($row['session_viewonline']) ? $this->language->lang('YES') : $this->language->lang('NO'),
				'SESSION_PAGE' 		=> $row['session_page'],
				'SESSION_START' 	=> $this->user->format_date($row['session_start']),
				'SESSION_TIME' 		=> $this->user->format_date($row['session_time']),

				'USERNAME' => get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),

				'U_WHOIS' => append_sid("{$this->root_path}adm/index.$this->php_ext", "i=acp_users&amp;action=whois&amp;user_ip={$row['session_ip']}"),
			]);
		}
		$this->db->sql_freeresult($result);

		$sort_by_text = ['u' => $this->language->lang('SORT_USERNAME'), 'i' => $this->language->lang('SESSION_IP'), 's' => $this->language->lang('SESSION_START')];
		$limit_days   = [];
		$s_sort_key   = $s_limit_days   = $s_sort_dir   = $u_sort_param   = '';

		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sd, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

		// Get total session count for output
		$sql = $this->db->sql_build_query('SELECT', [
			'SELECT' => 'COUNT(s.session_id) AS total_sessions',
			'FROM' => [
				$this->tables['users'] => 'u',
				$this->tables['sessions'] => 's',
			],
			'WHERE' => 'u.user_id = s.session_user_id
                AND s.session_time >= ' . (time() - ($this->config['session_length'] * 60)) . $filter_by,
		]);

		$result        = $this->db->sql_query($sql);
		$session_count = (int) $this->db->sql_fetchfield('total_sessions');

		$this->db->sql_freeresult($result);

		$action = "{$this->u_action}&amp;sk=$sort_key&amp;sd=$sd";
		$link   = ($session_count) ? adm_back_link($action . '&amp;start=' . $start) : '';

		if ($session_count == 0)
		{
			trigger_error($this->language->lang('NO_SESSION_DATA') . $link);
		}

		$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $session_count);
		$this->pagination->generate_template_pagination($action, 'pagination', 'start', $session_count, $this->config['topics_per_page'], $start);

		$first_characters     = [];
		$first_characters[''] = $this->language->lang('ALL');
		for ($i = ord($this->language->lang('START_CHARACTER')); $i <= ord($this->language->lang('END_CHARACTER')); $i++)
		{
			$first_characters[chr($i)] = chr($i);
		}
		$first_characters['other'] = $this->language->lang('OTHER');

		foreach ($first_characters as $char => $desc)
		{
			$this->template->assign_block_vars('first_char', [
				'DESC' => $desc,
				'U_SORT' => $action . '&amp;fc=' . $char,
			]);
		}

		// Template vars for header panel
		$version_data = $this->functions->version_check();

		// Are the PHP and phpBB versions valid for this extension?
		$valid = $this->functions->ext_requirements();

		$this->template->assign_vars([
			'DOWNLOAD' 			=> (array_key_exists('download', $version_data)) ? '<a class="download" href =' . $version_data['download'] . '>' . $this->language->lang('NEW_VERSION_LINK') . '</a>' : '',

			'EXT_IMAGE_PATH'	=> $this->ext_images_path,

			'HEAD_TITLE' 		=> $this->language->lang('ACTIVE_SESSIONS'),
			'HEAD_DESCRIPTION' 	=> $this->language->lang('ACTIVE_SESSIONS_EXPLAIN'),

			'NAMESPACE' 		=> $this->functions->get_ext_namespace('twig'),

			'PHP_VALID' 		=> $valid[0],
			'PHPBB_VALID' 		=> $valid[1],

			'S_BACK' 			=> $back,
			'S_VERSION_CHECK' 	=> (array_key_exists('current', $version_data)) ? $version_data['current'] : false,

			'VERSION_NUMBER' 	=> $this->functions->get_meta('version'),
		]);

		$this->template->assign_vars([
			'S_FILTER_CHAR' => $this->character_select($fc),
			'S_SORT_DIR' 	=> $s_sort_dir,
			'S_SORT_KEY' 	=> $s_sort_key,

			'TOTAL_USERS'	=> $this->language->lang('TOTAL_SESSIONS', (int) $session_count),

			'U_ACTION' 		=> $action,
		]);
	}

	/**
	 * Create the character select
	 *
	 * @param $default
	 *
	 * @return string $char_select
	 * @access protected
	 */
	protected function character_select($default)
	{
		$options     = [];
		$options[''] = $this->language->lang('ALL');

		for ($i = ord($this->language->lang('START_CHARACTER')); $i <= ord($this->language->lang('END_CHARACTER')); $i++)
		{
			$options[chr($i)] = chr($i);
		}

		$options['other'] = $this->language->lang('OTHER');
		$char_select      = '<select name="fc" id="fc">';

		foreach ($options as $value => $char)
		{
			$char_select .= '<option value="' . $value . '"';

			if (isset($default) && $default == $char)
			{
				$char_select .= ' selected';
			}

			$char_select .= '>' . $char . '</option>';
		}

		$char_select .= '</select>';

		return $char_select;
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
		return $this->u_action = $u_action;
	}
}
