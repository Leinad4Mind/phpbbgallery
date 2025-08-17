<?php
/**
*
* @package Registration Age Check
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\registrationage\event;

/**
* @ignore
*/
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

	/** @var string custom constants */
	protected $rpconstants;

	/** @var string */
	protected $reg_birthdate;

	/** @var string */
	protected $today;

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
	* @param array						$constants	Constants
	*
	* @return \david63\registrationage\event\listener
	* @access public
	*/
	public function __construct(config $config, user $user, language $language, template $template, request $request, auth $auth, log $log, $rpconstants)
	{
		$this->config		= $config;
		$this->user			= $user;
		$this->language 	= $language;
		$this->template		= $template;
		$this->request		= $request;
		$this->auth			= $auth;
		$this->log	   		= $log;
		$this->constants	= $rpconstants;

		$this->today = new \DateTime;
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
		return array(
			'core.ucp_register_data_before' => 'add_register',
			'core.ucp_register_data_after'	=> 'check_register',
			'core.user_add_modify_data'		=> 'update_sql',
			'core.memberlist_view_profile'	=> 'profile_view',
			'core.viewtopic_post_row_after'	=> 'set_template_vars',
		);
	}

	/**
	* Add the fields to the input form
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function set_template_vars($event)
	{
		$this->template->assign_vars(array(
			'U_SHOW_AGE_ON_PROFILE'	=> $this->config['registration_age_display'],
			'U_IS_ADMIN'			=> ($this->config['registration_age_admin'] && $this->auth->acl_gets('a_', 'm_')) ? true : false,
		));
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
		$this->language->add_lang('ucp_registrationage', 'david63/registrationage');

		$data = $event['data'];

		$this->template->assign_vars(array(
			'REGISTRATION_AGE_DAY'		=> $this->today->format('d'),
			'REGISTRATION_AGE_MONTH'	=> $this->today->format('m'),
			'REGISTRATION_AGE_YEAR'		=> $this->today->format('Y'),
			'YEAR_START' 				=> $this->today->format('Y') - $this->constants['century'],
			'YEAR_END' 					=> $this->today->format('Y'),
		));

		$data['registration_age_day'] 	= $this->request->variable('registration_age_day', '');
		$data['registration_age_month'] = $this->request->variable('registration_age_month', '');
		$data['registration_age_year']	= $this->request->variable('registration_age_year', '');

		$event->offsetSet('data', $data);
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
		$this->template->assign_vars(array(
			'REGISTRATION_AGE_DAY'		=> $this->request->variable('registration_age_day', ''),
			'REGISTRATION_AGE_MONTH'	=> $this->request->variable('registration_age_month', ''),
			'REGISTRATION_AGE_YEAR'		=> $this->request->variable('registration_age_year', ''),
		));

		// Make sure that there is valid birthdate date entered in all fields before going any further
		if (!is_numeric($data['registration_age_day']) || !is_numeric($data['registration_age_month']) || !is_numeric($data['registration_age_year']))
		{
			$error[] = $this->language->lang('REGISTRATION_AGE_MISSING');
		}
		else
		{
			// Calculate the age of the user
			$birthdate 				= new \DateTime($data['registration_age_year'] . '-' . $data['registration_age_month'] . '-' . $data['registration_age_day']);
			$this->reg_birthdate 	= $data['registration_age_day'] . '-' . $data['registration_age_month'] . '-' . $data['registration_age_year'];
			$interval 				= $this->today->diff($birthdate);
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

		$event->offsetSet('error', $error);
	}

	/**
	* Update the sql
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function update_sql($event)
	{
		$sql_ary = $event['sql_ary'];

		if ($this->config['registration_age_store'])
		{
			$sql_ary['user_registration_birthdate'] = $this->reg_birthdate;
		}

		if ($this->config['registration_age_copy'])
		{
			$sql_ary['user_birthday'] = $this->reg_birthdate;
		}

		$event->offsetSet('sql_ary', $sql_ary);
	}

	/**
	* Display the registration dob in the user's profile
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function profile_view($event)
	{
		$member = $event['member'];

		$this->template->assign_vars(array(
			'REGISTRATION_AGE' => ($member['user_registration_birthdate']) ? $member['user_registration_birthdate'] : $this->language->lang('BIRTHDATE_NOT_ENTERED'),

			// Only show the registration dob to Admins and Mods
			'S_REGISTRATION_AGE' => ($this->auth->acl_gets('a_', 'm_')) ? true : false,
		));
	}
}
