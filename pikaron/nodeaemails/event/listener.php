<?php
/**
 *
 * No DEA Emails. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, Picaron, https://github.com/picaronin/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace pikaron\nodeaemails\event;

/**
 * Event listener
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	// /** @var functions */
	protected $functions_nodeaemails;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var string */
	protected $phpbb_root_path;

	/** @var string */
	protected $phpEx;

	/**
	 * Listener constructor.
	 *
	 * @param \pikaron\nodeaemails\core\functions_nodeaemails	 $functions_nodeaemails
	 * @param \phpbb\language\language							 $language
	 * @param \phpbb\config\config								 $config
	 * @param \phpbb\request\request							 $request
	 * @param \phpbb\user										 $user
	 * @param \phpbb\auth\auth									 $auth
	 * @param \phpbb\template\template							 $template
	 * @param string											 $phpbb_root_path
	 * @param string											 $phpEx
	 *
	 * @return void
	 */
	public function __construct
	(
		\pikaron\nodeaemails\core\functions_nodeaemails $functions_nodeaemails,
		\phpbb\language\language $language,
		\phpbb\config\config $config,
		\phpbb\request\request $request,
		\phpbb\user $user,
		\phpbb\auth\auth $auth,
		\phpbb\template\template $template,
		$phpbb_root_path,
		$phpEx
	)
	{
		$this->functions_nodeaemails = $functions_nodeaemails;
		$this->language				 = $language;
		$this->config				 = $config;
		$this->request				 = $request;
		$this->user					 = $user;
		$this->auth					 = $auth;
		$this->template				 = $template;
		$this->phpbb_root_path		 = $phpbb_root_path;
		$this->phpEx				 = $phpEx;
	}

	/**
	* Validate No DEA Emails
	*
	* @param \phpbb\event\data $event The event object
	* @return void
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'user_setup',
			'core.ucp_profile_reg_details_data'		=> 'ucp_profile_reg_details_data',
			'core.ucp_profile_reg_details_sql_ary'	=> 'ucp_profile_reg_details_sql_ary',
			'core.ucp_register_data_after'			=> 'ucp_user_email_data',
			'core.ucp_profile_reg_details_validate'	=> 'ucp_user_email_data',
			'core.message_list_actions'				=> 'message_list_actions',
		);
	}

	/**
	 * Setup User
	 *
	 * @param object $event
	 *
	 * @return void
	 */
	public function user_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name'	=> 'pikaron/nodeaemails',
			'lang_set'	=> 'nodeaemails'
		];
		$event['lang_set_ext'] = $lang_set_ext;

		// Force load DEA Emails
		if ($this->config['nodeaemails_counter'] == 0)
		{
			$this->functions_nodeaemails->update_deas();
		}

		// Force redirect to change Email -- Not for admins or moderators
		$isadmin = (isset($this->user->data['session_admin']) && $this->user->data['session_admin']) || $this->auth->acl_get('m_lock') ? true : false;
		if (!$isadmin && $this->user->data['user_chg_email_force'] && !empty($this->user->data['is_registered']))
		{
			if (strpos($this->user->page['query_string'], 'mode=reg_details') === false)
			{
				redirect(append_sid("{$this->phpbb_root_path}ucp.$this->phpEx", 'i=ucp_profile&amp;mode=reg_details'));
			}
		}
	}

	/**
	 * Deactivate the email change condition
	 *
	 * @param object $event
	 *
	 * @return void
	 */
	public function ucp_profile_reg_details_sql_ary($event)
	{
		$sql = $event['sql_ary'];

		// If email is changed, the condition is deactivated.
		if ($this->user->data['user_email'] != $sql['user_email'])
		{
			$sql['user_chg_email_force'] = 0;
			$event['sql_ary'] = $sql;
		}
	}

	/**
	 * Show message in form.
	 *
	 * @return template
	 */
	public function ucp_profile_reg_details_data($event)
	{
		if ($this->user->data['user_chg_email_force'])
		{
			if ($this->auth->acl_get('u_chgemail'))
			{
				$show = true;
				$noshow = false;
			}
			else
			{
				$show = false;
				$noshow = true;
			}
		}
		else
		{
			$show = false;
			$noshow = false;
		}

		$this->template->assign_vars(array(
			'NO_DEA_EMAILS_FORCE_CHANGE_EMAIL' => $show,
			'NO_DEA_EMAILS_NOT_FORCE_CHANGE_EMAIL' => $noshow
		));
	}

	/**
	 * Send PM to selected Users.
	 *
	 * @param object $event
	 *
	 * @return void
	 */
	public function message_list_actions($event)
	{
		$users = $this->request->variable('users_nodeaemail', '');

		if ($users != '')
		{
			$row = explode('_', $users);
			$sendpm = array();
			foreach ($row as $key => $id)
			{
				$sendpm['u'][$id] ='bcc';
			}
			$event['address_list'] = $sendpm;
		}
	}

	/**
	 * Load data event.
	 *
	 * @param object $event
	 *
	 * @return void
	 */
	public function ucp_user_email_data($event)
	{
		// Store the error and input event data
		$error = $event['error'];
		$alldata = $event['data'];
		$email = strtolower($alldata['email']);

		// make sure we've got a valid email
		if (filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			// split on @ and return last value of array in $domain[1]
			$domain = explode('@', $email);
            $MiArray = array_flip($this->functions_nodeaemails->load_total_deas());

            if (isset($MiArray[$domain[1]]))
			{
				$error[] = $this->language->lang('NO_DEA_EMAILS_FOUND', $email);
			}
		}

		// Update error event data
		$event['error'] = $error;
	}
}
