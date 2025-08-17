<?php
/**
*
* @package Registration Age Check
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\registrationage\controller;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\pagination;
use phpbb\language\language;
use david63\registrationage\core\functions;

/**
* Admin controller
*/
class data_controller implements data_interface
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

	/** @var \phpbb\language\language */
	protected $language;

	/** @var string */
	protected $ext_root_path;

	/** @var \david63\registrationage\core\functions */
	protected $functions;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor for data controller
	*
	* @param \phpbb\config\config						$config			Config object
	* @param \phpbb\db\driver\driver_interface			$db				Database object
	* @param \phpbb\request\request						$request		Request object
	* @param \phpbb\template\template					$template		Template object
	* @param \phpbb\pagination							$pagination		Pagination object
	* @param \phpbb\language\language					$language		Language object
	* @param string										$ext_root_path	Path to this extension's root
	* @param \david63\registrationage\core\functions	$functions		Functions for the extension
	*
	* @return \david63\registrationage\controller\data_controller
	* @access public
	*/
	public function __construct(config $config, driver_interface $db, request $request, template $template, pagination $pagination, language $language, $ext_root_path, functions $functions)
	{
		$this->config			= $config;
		$this->db  				= $db;
		$this->request			= $request;
		$this->template			= $template;
		$this->pagination		= $pagination;
		$this->language			= $language;
		$this->ext_root_path	= $ext_root_path;
		$this->functions		= $functions;
	}

	/**
	* Display the output for this extension
	*
	* @return null
	* @access public
	*/
	public function display_output()
	{
		// Add the language file
		$this->language->add_lang('acp_data_registrationage', $this->functions->get_ext_namespace());

		// Start initial var setup
		$action			= $this->request->variable('action', '');
		$clear_filters	= $this->request->variable('clear_filters', '');
		$fc				= $this->request->variable('fc', '');
		$sort_key		= $this->request->variable('sk', 'u');
		$sd = $sort_dir	= $this->request->variable('sd', 'a');
		$start			= $this->request->variable('start', 0);

		$back = false;

		if ($clear_filters)
		{
			$fc				= '';
			$sd = $sort_dir	= 'a';
			$sort_key		= 'u';
		}

		$sort_dir = ($sort_dir == 'd') ? ' DESC' : ' ASC';

		$order_ary = array(
			'p'	=> 'user_birthday' . $sort_dir. ', username_clean ASC',
			'r'	=> 'user_registration_birthdate' . $sort_dir. ', username_clean ASC',
			'u'	=> 'username_clean' . $sort_dir,
		);

		$filter_by = '';
		if ($fc == 'other')
		{
			for ($i = ord($this->language->lang('START_CHARACTER')); $i	<= ord($this->language->lang('END_CHARACTER')); $i++)
			{
				$filter_by .= ' AND username_clean ' . $this->db->sql_not_like_expression(utf8_clean_string(chr($i)) . $this->db->get_any_char());
			}
		}
		else if ($fc)
		{
			$filter_by .= ' AND username_clean ' . $this->db->sql_like_expression(utf8_clean_string(substr($fc, 0, 1)) . $this->db->get_any_char());
		}

		$order_by = ($sort_key == '') ? 'username_clean' : $order_ary[$sort_key];

		$sql = 'SELECT user_id, username, username_clean, user_birthday, user_colour, user_registration_birthdate
			FROM ' . USERS_TABLE . '
				WHERE user_type <> ' . USER_IGNORE . "
				$filter_by
			ORDER BY $order_by";

		$result = $this->db->sql_query_limit($sql, $this->config['topics_per_page'], $start);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$age 		= $this->get_age($row['user_birthday']);
			$reg_age	= $this->get_age($row['user_registration_birthdate']);
			$status 	= 'spacer';
			$title		= '';

			if (($row['user_birthday'] && !$row['user_registration_birthdate']) || (!$row['user_birthday'] && $row['user_registration_birthdate']))
			{
				$status = 'question';
				$title	= $this->language->lang('AGE_QUERY');
			}

			if ($row['user_birthday'] && $row['user_registration_birthdate'])
			{
				if ($age == $reg_age)
				{
					$status = 'check';
					$title	= $this->language->lang('AGE_AGREE');
				}
				else
				{
					$status = 'error';
					$title	= $this->language->lang('AGE_ERROR');
				}
			}

			$this->template->assign_block_vars('agelist', array(
				'AGE'		=> $age,
				'BIRTHDAY'	=> $row['user_birthday'],
				'REG_AGE'	=> $reg_age,
				'REG_BDAY'	=> $row['user_registration_birthdate'],
				'STATUS'	=> '<img src="' . htmlspecialchars($this->ext_root_path) . 'images/' . $status . '.png" align="middle" title="' . $title . '" />',
				'USERNAME'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
			));
		}

		$this->db->sql_freeresult($result);

		$sort_by_text	= array('u' => $this->language->lang('SORT_USERNAME'), 'p' => $this->language->lang('SORT_PROFILE'), 'r' => $this->language->lang('SORT_REGISTRATION'));
		$limit_days	= array();
		$s_sort_key	= $s_limit_days = $s_sort_dir = $u_sort_param = '';

		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sd, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

		// Get total user count for pagination
		$sql = 'SELECT COUNT(user_id) AS total_users
			FROM ' . USERS_TABLE . '
				WHERE user_type <> ' . USER_IGNORE . "
				$filter_by";

		$result		= $this->db->sql_query($sql);
		$user_count	= (int) $this->db->sql_fetchfield('total_users');

		$this->db->sql_freeresult($result);

		$action = "{$this->u_action}&amp;sk=$sort_key&amp;sd=$sd";

		$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $user_count);
		$this->pagination->generate_template_pagination($action . "&ampfc=$fc", 'pagination', 'start', $user_count, $this->config['topics_per_page'], $start);

		$first_characters	= array();
		$first_characters[]	= $this->language->lang('ALL');
		for ($i = ord($this->language->lang('START_CHARACTER')); $i	<= ord($this->language->lang('END_CHARACTER')); $i++)
		{
			$first_characters[chr($i)] = chr($i);
		}
		$first_characters['other'] = $this->language->lang('OTHER');

		foreach ($first_characters as $char => $desc)
		{
			$this->template->assign_block_vars('first_char', array(
				'DESC'		=> $desc,
				'U_SORT'	=> $action . '&amp;fc=' . $char,
			));
		}

		// Template vars for header panel
		$this->template->assign_vars(array(
			'HEAD_TITLE'		=> $this->language->lang('REGISTRATION_AGE'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('REGISTRATION_DATA_EXPLAIN'),

			'NAMESPACE'			=> $this->functions->get_ext_namespace('twig'),

			'S_BACK'			=> $back,
			'S_VERSION_CHECK'	=> $this->functions->version_check(),

			'VERSION_NUMBER'	=> $this->functions->get_this_version(),
		));

		$this->template->assign_vars(array(
			'S_FILTER_CHAR'				=> $this->character_select($fc),
			'S_SORT_DIR'				=> $s_sort_dir,
			'S_SORT_KEY'				=> $s_sort_key,

			'TOTAL_USERS'				=> $this->language->lang('TOTAL_USERS', (int) $user_count),

			'U_ACTION'					=> $action . "&ampfc=$fc",
		));
	}

	/**
	* Get a user's age
	*
	* @return $age
	* @access public
	*/
	public function get_age($birthdate)
	{
		$age = '';

		if ($birthdate)
		{
			list($bday_day, $bday_month, $bday_year) = array_map('intval', explode('-', $birthdate));

			if ($bday_year)
			{
				$now = new \DateTime();
				$now = phpbb_gmgetdate($now->getTimestamp() + $now->getOffset());

				$diff = $now['mon'] - $bday_month;
				if ($diff == 0)
				{
					$diff = ($now['mday'] - $bday_day < 0) ? 1 : 0;
				}
				else
				{
					$diff = ($diff < 0) ? 1 : 0;
				}

				$age = max(0, (int) ($now['year'] - $bday_year - $diff));
			}
		}

		return $age;
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
		$options	 = array();
		$options[''] = $this->language->lang('ALL');

		for ($i = ord($this->language->lang('START_CHARACTER')); $i	<= ord($this->language->lang('END_CHARACTER')); $i++)
		{
			$options[chr($i)] = chr($i);
		}

		$options['other'] 	= $this->language->lang('OTHER');
		$char_select 		= '<select name="fc" id="fc">';

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
		$this->u_action = $u_action;
	}
}
