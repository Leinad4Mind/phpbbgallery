<?php

/**
 *
 * @package phpBB Extension - mChat Infinite Scroll Addon
 * @copyright (c) 2017 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatinfinitescroll\controller;

use dmzx\mchat\core\functions;
use dmzx\mchat\core\mchat;
use dmzx\mchat\core\settings;
use kasimi\mchatrooms\core\rooms;
use phpbb\auth\auth;
use phpbb\event\dispatcher;
use phpbb\exception\http_exception;
use phpbb\extension\manager;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\HttpFoundation\JsonResponse;

class main
{
	/** @var user */
	protected $user;

	/** @var auth */
	protected $auth;

	/** @var request_interface */
	protected $request;

	/** @var template */
	protected $template;

	/** @var dispatcher */
	protected $dispatcher;

	/** @var manager */
	protected $ext_manager;

	/** @var mchat */
	protected $mchat;

	/** @var functions */
	protected $functions;

	/** @var settings */
	protected $settings;

	/** @var rooms */
	protected $rooms;

	/** @var bool */
	protected $can_run;

	/** @var int */
	protected $oldest_message_id;

	/**
	 * Constructor
	 *
	 * @param user					$user
	 * @param auth					$auth
	 * @param request_interface		$request
	 * @param template				$template
	 * @param dispatcher			$dispatcher
	 * @param manager				$ext_manager
	 * @param mchat					$mchat
	 * @param functions				$functions
	 * @param settings				$settings
	 * @param rooms					$rooms
	 */
	public function __construct(
		user $user,
		auth $auth,
		request_interface $request,
		template $template,
		dispatcher $dispatcher,
		manager $ext_manager,
		mchat $mchat = null,
		functions $functions = null,
		settings $settings = null,
		rooms $rooms = null
	)
	{
		$this->user			= $user;
		$this->auth			= $auth;
		$this->request		= $request;
		$this->template		= $template;
		$this->dispatcher	= $dispatcher;
		$this->ext_manager	= $ext_manager;
		$this->mchat		= $mchat;
		$this->functions	= $functions;
		$this->settings		= $settings;
		$this->rooms		= $rooms;

		$this->can_run = $this->ext_require_version('kasimi/mchatrooms', '1.0.0');
	}

	/**
	 * @return bool
	 */
	public function can_run()
	{
		return $this->can_run;
	}

	/**
	 * @param string $ext_name
	 * @param string $required_version
	 * @return bool
	 */
	protected function ext_require_version($ext_name, $required_version)
	{
		if (!$this->ext_manager->is_enabled($ext_name))
		{
			// The extension is not installed which means there is no version to require
			return true;
		}

		$metadata = $this->ext_manager->create_extension_metadata_manager($ext_name, $this->template)->get_metadata();
		return phpbb_version_compare($metadata['version'], $required_version, '>=');
	}

	/**
	 * @return int
	 */
	public function get_oldest_message_id()
	{
		return $this->oldest_message_id;
	}

	/**
	 * @param string $page
	 * @return int
	 */
	public function get_limit($page)
	{
		return (int) $this->settings->cfg('mchat_message_num_' . $page) ?: 10;
	}

	/**
	 * @param string $page
	 * @param boolean $return_raw
	 * @return JsonResponse|array
	 */
	public function load($page, $return_raw = false)
	{
		if ($this->mchat === null || $this->functions === null || $this->settings === null || !$this->can_run())
		{
			throw new http_exception(404, 'EXTENSION_DISABLED', array('mChat'));
		}

		if (!$this->request->is_ajax() || !$this->auth->acl_get('u_mchat_view'))
		{
			throw new http_exception(403, 'NO_AUTH_OPERATION');
		}

		$this->oldest_message_id = $this->request->variable('infinite', 0);

		// Fix avatars & smilies
		if (!defined('PHPBB_USE_BOARD_URL_PATH'))
		{
			define('PHPBB_USE_BOARD_URL_PATH', true);
		}

		$this->user->add_lang_ext('dmzx/mchat', 'mchat');

		$response = array('infinite' => true);

		if ($this->oldest_message_id > 1)
		{
			// Make the Rooms extension aware that we don't check for new
			// messages but rather that we're rendering for a single page.
			if ($this->rooms !== null)
			{
				$this->rooms->set_page($page);
			}

			$limit = $this->get_limit($page);
			$rows = $this->functions->mchat_get_messages(array(), 0, $limit);
			$response['end'] = sizeof($rows) < $limit;

			if ($rows)
			{
				$this->mchat->assign_global_template_data();
				$this->mchat->assign_messages($rows, $page);
				$response['add'] = $this->mchat->render_template('mchat_messages.html');

				/**
				 * Event to modify the data that is sent to the user after checking for new mChat message
				 *
				 * @event dmzx.mchat.action_refresh_after
				 * @var array	rows		The rows that where fetched from the database
				 * @var array	response	The data that is sent back to the user
				 * @var boolean	return_raw	Whether to return a raw array or a JsonResponse object
				 * @since 2.0.0-RC6
				 */
				$vars = array(
					'rows',
					'response',
					'return_raw',
				);
				extract($this->dispatcher->trigger_event('dmzx.mchat.action_refresh_after', compact($vars)));
			}
		}
		else
		{
			$response['end'] = true;
		}

		return $return_raw ? $response : new JsonResponse($response);
	}
}
