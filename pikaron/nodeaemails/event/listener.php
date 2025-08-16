<?php
/**
 *
 * No DEA Emails. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Picaron, https://github.com/picaronin/
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

	/**
	 * Listener constructor.
	 *
	 * @param \pikaron\nodeaemails\core\functions_nodeaemails	 $functions_nodeaemails
	 * @param \phpbb\language\language							 $language
	 * @param \phpbb\config\config								 $config
	 * @param \phpbb\request\request							 $request
	 *
	 * @return void
	 */
	public function __construct
	(
		\pikaron\nodeaemails\core\functions_nodeaemails $functions_nodeaemails,
		\phpbb\language\language $language,
		\phpbb\config\config $config,
		\phpbb\request\request $request
	)
	{
		$this->functions_nodeaemails = $functions_nodeaemails;
		$this->language				 = $language;
		$this->config				 = $config;
		$this->request				 = $request;
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
			'core.ucp_register_data_after'			=> 'ucp_user_email_data',
			'core.ucp_profile_reg_details_validate'	=> 'ucp_user_email_data',
			'core.message_list_actions'				=> 'message_list_actions',
		);
	}

	/**
	 * Load language files.
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

			if (array_search($domain[1], $this->functions_nodeaemails->load_total_deas()) !== false)
			{
				$error[] = $this->language->lang('NO_DEA_EMAILS_FOUND', $email);
			}
		}

		// Update error event data
		$event['error'] = $error;
	}
}
