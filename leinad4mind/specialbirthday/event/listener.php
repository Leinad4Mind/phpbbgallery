<?php

/**
*
* @package Special Birthday
* @copyright (c) 2019 Leinad4Mind
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace leinad4mind\specialbirthday\event;

/**
* @ignore
*/

use leinad4mind\specialbirthday\core\friends;
use phpbb\event\data;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\config\config;
use phpbb\user;
use phpbb\language\language;
use phpbb\template\template;
use phpbb\request\request;
use phpbb\auth\auth;
use phpbb\log\log;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var friends */
	protected $friends;

	/** @var array string custom constants */
	protected $constants;

	/** @var string */
	protected $reg_birthdate = '';

	/**
	* Constructor for listener
	*
	* @param \phpbb\config\config		$config		Config object
	* @param \phpbb\user				$user		User object
	* @param \phpbb\language\language	$language	Language object
	* @param \phpbb\template\template	$template	Template object
	* @param \phpbb\request\request		$request	Request object
	* @param \phpbb\auth\auth 			$auth		Auth object
	* @param \phpbb\log\log				$log		Log object
	* @param friends					$friends
	* @param array						$constants	Constants
	*
	* @return \leinad4mind\specialbirthday\event\listener
	* @access public
	*/
	public function __construct(config $config, user $user, language $language, template $template, request $request, auth $auth, log $log, friends $friends, $constants)
	{
		$this->config		= $config;
		$this->user			= $user;
		$this->language 	= $language;
		$this->template		= $template;
		$this->request		= $request;
		$this->auth			= $auth;
		$this->log	   		= $log;
		$this->friends		= $friends;
		$this->constants	= $constants;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return [
			'core.ucp_register_data_before' 			=> 'add_register',
			'core.ucp_register_data_after'				=> 'check_register',
			'core.user_add_modify_data'					=> 'update_sql',
			'core.memberlist_view_profile'				=> 'profile_view',
			'core.viewtopic_cache_user_data'			=> 'viewtopic_cache_user_data',
			'core.viewtopic_modify_post_row'			=> 'viewtopic_modify_post_row',
			'core.search_get_posts_data'				=> 'search_get_posts_data',
			'core.search_modify_tpl_ary'				=> 'search_modify_tpl_ary',
			'core.ucp_profile_modify_profile_info'		=> 'ucp_profile_modify_profile_info',
			'core.ucp_profile_info_modify_sql_ary'		=> 'ucp_profile_info_modify_sql_ary',
			'core.ucp_profile_validate_profile_info'	=> ['ucp_profile_validate_profile_info', -1000],
			'core.index_modify_birthdays_sql'			=> 'index_modify_birthdays_sql',
			'core.index_modify_birthdays_list'			=> ['index_modify_birthdays_list', 1000],
		];
	}

	/**
	* Add the fields to the input form
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function add_register($event)
	{
		// Add the language file
		$this->language->add_lang('ucp_specialbirthday', 'leinad4mind/specialbirthday');

		$today = new \DateTime;

		$this->template->assign_vars([
			'REGISTRATION_AGE_REQUIRED'		=> $this->config['registration_age_required'],
			'REGISTRATION_AGE_REG_DISPLAY'	=> $this->config['registration_age_reg_display'],
			'REGISTRATION_AGE_DAY'			=> $today->format('d'),
			'REGISTRATION_AGE_MONTH'		=> $today->format('m'),
			'REGISTRATION_AGE_YEAR'			=> $today->format('Y'),
			'YEAR_START' 					=> $today->format('Y') - $this->constants['century'],
			'YEAR_END' 						=> $today->format('Y'),
		]);

		$event['data'] = array_merge($event['data'], [
			'registration_age_day'		=> $this->request->variable('registration_age_day', ''),
			'registration_age_month'	=> $this->request->variable('registration_age_month', ''),
			'registration_age_year'		=> $this->request->variable('registration_age_year', ''),
		]);
	}

	/**
	* Validate the input data
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function check_register($event)
	{
		$data 	= $event['data'];
		$error	= $event['error'];

		// Return the birthdate variables to the form if there is an error.
		$this->template->assign_vars([
			'REGISTRATION_AGE_DAY'		=> $this->request->variable('registration_age_day', ''),
			'REGISTRATION_AGE_MONTH'	=> $this->request->variable('registration_age_month', ''),
			'REGISTRATION_AGE_YEAR'		=> $this->request->variable('registration_age_year', ''),
		]);

		if ($this->config['registration_age_reg_display'])
		{
			// Make sure that there is valid birthdate date entered in all fields before going any further
			if (!is_numeric($data['registration_age_day']) || !is_numeric($data['registration_age_month']) || !is_numeric($data['registration_age_year']))
			{
				if ($this->config['registration_age_required'])
				{
					$error[] = $this->language->lang('REGISTRATION_AGE_MISSING');
				}
			}
			else
			{
				// Calculate the age of the user
				$birthdate 				= new \DateTime($data['registration_age_year'] . '-' . $data['registration_age_month'] . '-' . $data['registration_age_day']);
				$this->reg_birthdate 	= $data['registration_age_day'] . '-' . $data['registration_age_month'] . '-' . $data['registration_age_year'];
				$interval 				= (new \DateTime)->diff($birthdate);
				$user_age 				= $interval->y;

				// Validate the user's age
				if ($user_age < $this->config['registration_age'])
				{
					// Return an error message to the registration form
					$error[] = $this->language->lang('REGISTRATION_AGE_ERROR', $user_age, $this->config['registration_age']);

					if ($this->config['registration_age_log'])
					{
						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'REGISTRATION_AGE_LOG_FAIL', time(), array($data['username'], $user_age));
					}

					if ($this->config['registration_age_ip'])
					{
						user_ban('ip', $this->user->ip, $this->config['registration_age_ban_length'], '', 0, $this->language->lang('BAN_REASON'), $this->config['registration_age_ban_reason']);
					}
				}
			}
		}

		$event->offsetSet('error', $error);
	}

	/**
	* Update the sql
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function update_sql(data $event)
	{
		$event->update_subarray('sql_ary', 'user_birthday', $this->reg_birthdate);
	}

	/**
	* Display the registration dob in the user's profile
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function profile_view(data $event)
	{
		if (!$this->can_see_age('memberlist', $event['member']['user_id'], $event['member']['user_registration_age_profile']))
		{
			$event->update_subarray('member', 'user_birthday', '');
		}
	}

	public function viewtopic_cache_user_data(data $event)
	{
		$event->update_subarray('user_cache_data', 'user_registration_age_profile', $event['row']['user_registration_age_profile']);
	}

	/**
	* Add the fields to the input form
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_modify_post_row(data $event)
	{
		if (!$this->can_see_age('viewtopic', $event['poster_id'], $event['user_poster_data']['user_registration_age_profile']))
		{
			$event->update_subarray('post_row', 'POSTER_AGE', '');
		}
	}

	public function search_get_posts_data($event)
	{
		if ($this->config['registration_age_search'])
		{
			$sql_array = $event['sql_array'];
			$sql_array['SELECT'] .= ', u.user_birthday, u.user_registration_age_profile';
			$event['sql_array'] = $sql_array;
		}
	}

	public function search_modify_tpl_ary($event)
	{
		if ($this->config['registration_age_search'] && $event['show_results'] == 'posts')
		{

			$age = $this->get_age('search', $event['row']['poster_id'], $event['row']['user_registration_age_profile'], $event['row']['user_birthday']);

			if ($age)
			{
				$event['tpl_ary'] = array_merge($event['tpl_ary'], [
					'POST_AUTHOR_FULL' => $event['tpl_ary']['POST_AUTHOR_FULL'] . ' (' . $this->language->lang('AGE') . $this->language->lang('COLON') . ' ' . $age . ')',
				]);
			}
		}
	}

	public function ucp_profile_modify_profile_info()
	{
		$this->language->add_lang('ucp_specialbirthday', 'leinad4mind/specialbirthday');

		$this->template->assign_vars([
			'S_REGISTRATION_AGE_PROFILE'	=> true,
			'REGISTRATION_AGE_PROFILE'		=> $this->user->data['user_registration_age_profile'],
		]);
	}

	public function ucp_profile_info_modify_sql_ary(data $event)
	{
		$event->update_subarray('sql_ary', 'user_registration_age_profile', $this->request->variable('user_registration_age_profile', 0));
	}

	public function ucp_profile_validate_profile_info(data $event)
	{
		if ($this->is_valid_birthday($this->user->data['user_birthday']))
		{
			if ($this->user->data['user_birthday'] != $event['data']['user_birthday'])
			{
				if ($this->config['registration_age_change'])
				{
					$new_age = $this->calc_age($event['data']['user_birthday']);

					if ($new_age < $this->config['registration_age'])
					{
						$event['error'] = array_merge($event['error'], [
							$this->language->lang('REGISTRATION_AGE_ERROR', $new_age, $this->config['registration_age'])
						]);

						if ($this->config['registration_age_log'])
						{
							$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'REGISTRATION_AGE_CHANGE_ATTEMPT', time(), [
								'reportee_id' => $this->user->data['user_id'],
								$event['data']['user_birthday'],
								$new_age,
							]);
						}
					}
					else
					{
						$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'REGISTRATION_AGE_CHANGED', time(), [
							'reportee_id' => $this->user->data['user_id'],
							$this->user->data['user_birthday'],
							$event['data']['user_birthday'],
						]);
					}
				}
				else
				{
					$event['error'] = array_merge($event['error'], [
						$this->language->lang('REGISTRATION_AGE_CANNOT_CHANGE'),
					]);
				}
			}
		}
		else if ($this->config['registration_age_required'] && !$this->is_valid_birthday($event['data']['user_birthday']))
		{
			$event['error'] = array_merge($event['error'], [
				$this->language->lang('REGISTRATION_AGE_REQUIRED'),
			]);
		}
	}

	public function index_modify_birthdays_sql(data $event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['SELECT'] .= ', u.user_registration_age_profile';
		$event['sql_ary'] = $sql_ary;
	}

	public function index_modify_birthdays_list(data $event)
	{
		$rows = $event['rows'];

		if ($rows)
		{
			$birthdays = $event['birthdays'];

			for ($i = 0; $i < count($rows); $i++)
			{
				if (!$this->can_see_age(true, $rows[$i]['user_id'], $rows[$i]['user_registration_age_profile']))
				{
					$rows[$i]['user_birthday'] = '';
					$birthdays[$i]['AGE'] = '';
				}
			}

			$event['birthdays'] = $birthdays;
			$event['rows'] = $rows;
		}
	}

	/**
	 * @param string $location
	 * @param int $subject_id
	 * @param int $subject_age_profile
	 * @param string $subject_birthday
	 * @return int|string
	 */
	protected function get_age($location, $subject_id, $subject_age_profile, $subject_birthday)
	{
		return $this->can_see_age($location, $subject_id, $subject_age_profile) ? $this->calc_age($subject_birthday) : '';
	}

	/**
	 * @param bool|string $location
	 * @param int $subject_id
	 * @param int $subject_age_profile
	 * @return bool
	 */
	protected function can_see_age($location, $subject_id, $subject_age_profile)
	{
		return
			(
				// ACP option to display the age in the current location is enabled
				$location === true || $this->config['registration_age_' . $location]
			)
			&&
			(
				// Current user has permission to see the age
				$this->config['registration_age_admin'] && $this->auth->acl_gets('a_', 'm_')
				// Subject set his UCP option for everyone to see his age
				|| $subject_age_profile == 1
				// Subject set his UCP option for friends only to see his age or is the same user
				|| $subject_age_profile == 2 && ($subject_id == $this->user->data['user_id'] || $this->friends->is_friend($subject_id, $this->user->data['user_id']))
			)
		;
	}

	/**
	 * @param string $birthday
	 * @return int
	 */
	protected function calc_age($birthday)
	{
		if ($birthday)
		{
			list($bday_day, $bday_month, $bday_year) = array_map('intval', explode('-', $birthday));

			if ($bday_year)
			{
				$now = $this->user->create_datetime();
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

				return $now['year'] - $bday_year - $diff;
			}
		}

		return 0;
	}

	/**
	 * @param string $birthday
	 * @return bool
	 */
	protected function is_valid_birthday($birthday)
	{
		if (!$birthday)
		{
			return true;
		}

		list($bday_day, $bday_month, $bday_year) = array_map('intval', explode('-', $birthday));

		return $bday_day && $bday_month && $bday_year;
	}
}
