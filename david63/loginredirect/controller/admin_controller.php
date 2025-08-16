<?php
/**
*
* @package User Login Redirect
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\loginredirect\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
* Admin controller
*/
class admin_controller implements admin_interface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var ContainerInterface */
	protected $container;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config				$config		Config object
	* @param \phpbb\request\request				$request	Request object
	* @param \phpbb\db\driver\driver_interface	$db
	* @param \phpbb\template\template			$template	Template object
	* @param \phpbb\user						$user		User object
	* @param ContainerInterface					$container	Service container interface
	*
	* @return \phpbb\boardrules\controller\admin_controller
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\request\request $request, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\user $user, ContainerInterface $container)
	{
		$this->config		= $config;
		$this->request		= $request;
		$this->db			= $db;
		$this->template		= $template;
		$this->user			= $user;
		$this->container	= $container;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		// Create a form key for preventing CSRF attacks
		$form_key = 'login_redirect';
		add_form_key($form_key);

		// Is the form being submitted
		if ($this->request->is_set_post('submit'))
		{
			// Is the submitted form is valid
			if (!check_form_key($form_key))
			{
				trigger_error($this->user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// Check that the entered topics are valid
			$this->topic_valid($this->request->variable('redirect_announce_topic_id', ''), $this->user->lang('INVALID_ANNOUNCEMENT_TOPIC'));
			$this->topic_valid($this->request->variable('redirect_welcome_topic_id', ''), $this->user->lang('INVALID_WELCOME_TOPIC'));
			$this->topic_valid($this->request->variable('redirect_group_topic_id', ''), $this->user->lang('INVALID_GROUP_TOPIC'));

			// If no errors, process the form data
			// Set the options the user configured
			$this->set_options();

			// Add option settings change action to the admin log
			$phpbb_log = $this->container->get('log');
			$phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_LOGIN_REDIRECT');

			// Option settings have been updated and logged
			// Confirm this to the user and provide link back to previous page
			trigger_error($this->user->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		// Set output vars for display in the template
		$this->template->assign_vars(array(
			'REDIRECT_ANNOUNCE'				=> isset($this->config['redirect_announce']) ? $this->config['redirect_announce'] : '',
			'REDIRECT_ANNOUNCE_PRIORITY'	=> isset($this->config['redirect_announce_priority']) ? $this->config['redirect_announce_priority'] : '',
			'REDIRECT_ANNOUNCE_REFRESH'		=> isset($this->config['redirect_announce_refresh']) ? $this->config['redirect_announce_refresh'] : '',
			'REDIRECT_ANNOUNCE_TOPIC_ID'	=> isset($this->config['redirect_announce_topic_id']) ? $this->config['redirect_announce_topic_id'] : '',
			'REDIRECT_ANY_ANNOUNCE'			=> isset($this->config['redirect_any_announce']) ? $this->config['redirect_any_announce'] : '',
			'REDIRECT_ENABLED'				=> isset($this->config['redirect_enabled']) ? $this->config['redirect_enabled'] : '',
			'REDIRECT_GROUP'				=> isset($this->config['redirect_group']) ? $this->config['redirect_group'] : '',
			'REDIRECT_GROUP_ALL'			=> isset($this->config['redirect_group_all']) ? $this->config['redirect_group_all'] : '',
			'REDIRECT_GROUP_REFRESH'		=> isset($this->config['redirect_group_refresh']) ? $this->config['redirect_group_refresh'] : '',
			'REDIRECT_GROUP_TOPIC_ID'		=> isset($this->config['redirect_group_topic_id']) ? $this->config['redirect_group_topic_id'] : '',
			'REDIRECT_WELCOME'				=> isset($this->config['redirect_welcome']) ? $this->config['redirect_welcome'] : '',
			'REDIRECT_WELCOME_REFRESH'		=> isset($this->config['redirect_welcome_refresh']) ? $this->config['redirect_welcome_refresh'] : '',
			'REDIRECT_WELCOME_TOPIC_ID'		=> isset($this->config['redirect_welcome_topic_id']) ? $this->config['redirect_welcome_topic_id'] : '',

			'S_REDIRECT_GROUP_OPTIONS'		=> group_select_options($this->config['redirect_group_id'], false, false),

			'U_ACTION' => $this->u_action,
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
		$this->config->set('redirect_announce', $this->request->variable('redirect_announce', 0));
		$this->config->set('redirect_announce_priority', $this->request->variable('redirect_announce_priority', 0));
		$this->config->set('redirect_announce_refresh', $this->request->variable('redirect_announce_refresh', 0));
		$this->config->set('redirect_announce_topic_id', $this->request->variable('redirect_announce_topic_id', ''));
		$this->config->set('redirect_any_announce', $this->request->variable('redirect_any_announce', 0));
		$this->config->set('redirect_enabled', $this->request->variable('redirect_enabled', 0));
		$this->config->set('redirect_group', $this->request->variable('redirect_group', 0));
		$this->config->set('redirect_group_all', $this->request->variable('redirect_group_all', 0));
		$this->config->set('redirect_group_id', $this->request->variable('redirect_group_id', 0));
		$this->config->set('redirect_group_refresh', $this->request->variable('redirect_group_refresh', 0));
		$this->config->set('redirect_group_topic_id', $this->request->variable('redirect_group_topic_id', ''));
		$this->config->set('redirect_welcome', $this->request->variable('redirect_welcome', 0));
		$this->config->set('redirect_welcome_refresh', $this->request->variable('redirect_welcome_refresh', 0));
		$this->config->set('redirect_welcome_topic_id', $this->request->variable('redirect_welcome_topic_id', ''));
	}

	protected function topic_valid($topic_id, $error_message)
	{
		if ($topic_id <> '')
		{
			$sql = 'SELECT topic_id
				FROM ' . TOPICS_TABLE . '
					WHERE topic_id = ' . (int)$topic_id;

			$result	= $this->db->sql_query($sql);
			$row	= $this->db->sql_fetchrow($result);

			$this->db->sql_freeresult($result);

			if (!$row)
			{
				trigger_error($error_message . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}
	}
}
