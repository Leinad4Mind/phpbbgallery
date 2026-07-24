<?php
/**
 *
 * @package       Cron Status
 * @copyright (c) 2014 - 2021 Igor Lavrov, John Peskens | (c) 2022-2026 Leinad4Mind
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\cronstatus\acp;

class cronstatus_module
{
	public $u_action;
	public $page_title;
	public $tpl_name;

	/** @var cronstatus_helper */
	protected $helper;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/** @var \phpbb\event\dispatcher_interface */
	protected $phpbb_dispatcher;

	public function main($id, $mode)
	{
		/** @var \phpbb\config\config $config */
		/** @var \phpbb\request\request_interface $request */
		/** @var \phpbb\extension\manager $phpbb_extension_manager */
		global $config, $user, $template, $request, $phpbb_root_path, $phpEx, $phpbb_extension_manager, $phpbb_container, $phpbb_dispatcher;

		$this->helper = new cronstatus_helper();
		$this->config = $config;
		$this->user = $user;
		$this->template = $template;
		$this->request = $request;
		$this->phpbb_dispatcher = $phpbb_dispatcher;

		$this->page_title = $user->lang['ACP_CRON_STATUS_TITLE'];
		$this->tpl_name = 'acp_cronstatus';
		$user->add_lang_ext('leinad4mind/cronstatus', 'cronstatus');

		// Whitelists for sk/sd: these are reflected unescaped into HTML links and meta refresh URLs
		// (see acp_cronstatus.html and the CRON_TASK_RUN link below), so only known-safe values are allowed through.
		$valid_sort_keys = array('display_name', 'task_date', 'new_date');
		$valid_sort_dirs = array('a', 'd');

		list($sk_config, $sd_config) = array_pad(explode("|", $config['cronstatus_default_sort']), 2, '');
		$sk_config = in_array($sk_config, $valid_sort_keys, true) ? $sk_config : 'display_name';
		$sd_config = in_array($sd_config, $valid_sort_dirs, true) ? $sd_config : 'a';

		$sk = $request->variable('sk', $sk_config);
		$sd = $request->variable('sd', $sd_config);
		$sk = in_array($sk, $valid_sort_keys, true) ? $sk : $sk_config;
		$sd = in_array($sd, $valid_sort_dirs, true) ? $sd : $sd_config;

		if ($sk != $sk_config || $sd != $sd_config)
		{
			$config->set("cronstatus_default_sort", $sk . "|" . $sd);
		}

		$action = $request->variable('action', '');
		switch ($action)
		{
			case 'details':
				$this->show_details($phpbb_extension_manager);

				if ($request->is_ajax())
				{
					$template->assign_vars(array(
						'IS_AJAX' => true,
					));
				}
				else
				{
					$template->assign_vars(array(
						'U_BACK' => $this->u_action,
					));
				}

				$this->tpl_name = 'acp_ext_details';
			break;

			case 'runnow':
				// AJAX-only action fired by the "Run Now" / "Run All" JS for a task that has never
				// run yet (so there is no phpBB-native cron_type beacon that would make it "ready").
				// Only a real, currently-registered task name is accepted.
				$cron_type = $request->variable('cron_type', '');
				$valid_task_names = $this->get_valid_task_names($phpbb_container);

				if (in_array($cron_type, $valid_task_names, true))
				{
					$config_key = $this->helper->get_task_last_run_key($cron_type);

					// Stamp an old-but-nonzero timestamp so is_ready() reports true and the task is
					// picked up as "ready" on the next refresh, without pretending it just ran.
					$config->set($config_key, 1);
				}

				exit;

			case 'reset':
				if (confirm_box(true))
				{
					$config->set('cron_lock', 0);
					trigger_error($user->lang('CRONSTAT_UNLOCKED') . adm_back_link($this->u_action));
				}
				else
				{
					confirm_box(false, 'CONFIRM_OPERATION', build_hidden_fields(array('action' => 'reset')));
				}
			break;

			default:
				$view_table = $request->variable('table', false);
				$cron_type = $request->variable('cron_type', '');

				// cron_type ends up in an <img src="..."> attribute, so only a real, known task name is accepted.
				$valid_task_names = $this->get_valid_task_names($phpbb_container);
				if ($cron_type && !in_array($cron_type, $valid_task_names, true))
				{
					$cron_type = '';
				}

				if (!($request->is_ajax()) && $cron_type)
				{
					$url = append_sid($phpbb_root_path . 'cron.' . $phpEx, 'cron_type=' . $cron_type);
					$template->assign_var('RUN_CRON_TASK', '<img src="' . htmlspecialchars($url) . '" width="1" height="1" alt="" />');
					meta_refresh(60, $this->u_action . '&amp;sk=' . $sk . '&amp;sd=' . $sd);
				}

				$this->show_tasks($phpbb_container, $sk, $sd, $cron_type);
				$cron_url = append_sid($phpbb_root_path . 'cron.' . $phpEx, false, false); // This is used in JavaScript (no &amp;).

				$template->assign_vars(array(
					'U_ACTION'   => $this->u_action,
					'U_UNLOCK'   => $this->u_action,
					'U_NAME'     => $sk,
					'U_SORT'     => $sd,
					// Blank while cron is locked, so the front-end JS doesn't queue up another run beacon on top of one already in progress.
					'CRON_URL'   => (!$config['cron_lock']) ? addslashes($cron_url) : '',
					'VIEW_TABLE' => $view_table,
				));
		}
	}

	/**
	 * Returns the names of all currently-registered Cron tasks.
	 * Used to whitelist any task name coming in from a request.
	 *
	 * @param object $phpbb_container phpBB container object
	 * @return array
	 */
	protected function get_valid_task_names($phpbb_container)
	{
		$valid_task_names = array();
		foreach ($phpbb_container->get('cron.manager')->get_tasks() as $task)
		{
			$valid_task_names[] = $task->get_name();
		}
		return $valid_task_names;
	}

	/**
	 * Assigns template parameters for details page
	 *
	 * @param \phpbb\extension\manager $phpbb_extension_manager Extension manager object
	 */
	public function show_details(\phpbb\extension\manager $phpbb_extension_manager)
	{
		$this->user->add_lang(array('install', 'acp/extensions', 'migrator'));
		$ext_name = 'leinad4mind/cronstatus';

		/** @var \phpbb\extension\metadata_manager $md_manager */
		$md_manager = $phpbb_extension_manager->create_extension_metadata_manager($ext_name);
		$metadata = $md_manager->get_metadata('all');
		$this->helper->output_metadata_to_template($metadata, $this->template);

		try
		{
			$updates_available = $phpbb_extension_manager->version_check($md_manager, $this->request->variable('versioncheck_force', false), false, $this->config['extension_force_unstable'] ? 'unstable' : null);

			$this->template->assign_vars(array(
				'S_UP_TO_DATE'   => empty($updates_available),
				'S_VERSIONCHECK' => true,
				'UP_TO_DATE_MSG' => $this->user->lang(empty($updates_available) ? 'UP_TO_DATE' : 'NOT_UP_TO_DATE', $md_manager->get_metadata('display-name')),
			));

			foreach ($updates_available as $branch => $version_data)
			{
				$this->template->assign_block_vars('updates_available', $version_data);
			}
		}
		catch (\RuntimeException $e)
		{
			$this->template->assign_vars(array(
				'S_VERSIONCHECK_STATUS'    => $e->getCode(),
				'VERSIONCHECK_FAIL_REASON' => ($e->getMessage() !== $this->user->lang('VERSIONCHECK_FAIL')) ? $e->getMessage() : '',
			));
		}
	}

	/**
	 * Assigns template parameters for available Cron tasks
	 *
	 * @param object $phpbb_container phpBB container object
	 * @param string $sk              Sort key
	 * @param string $sd              Sort direction
	 * @param string $cron_type       Name of Cron task for execution
	 */
	public function show_tasks($phpbb_container, $sk, $sd, $cron_type)
	{
		$task_array = array();
		$tasks = $phpbb_container->get('cron.manager')->get_tasks();

		$cronlock = '';
		$rows = $phpbb_container->get('leinad4mind.cronstatus.listener')->get_cron_tasks($cronlock);

		if ($this->config['cronstatus_latest_task'])
		{
			$cronlock = $this->config['cronstatus_latest_task'];
		}

		if (!sizeof($tasks) || !is_array($rows))
		{
			return;
		}

		/** @var \phpbb\cron\task\task $task */
		foreach ($tasks as $task)
		{
			$this->handle_task($rows, $task, $cronlock, $task_array);
		}
		unset($tasks, $rows);

		$task_array = $this->helper->array_sort($task_array, $sk, (($sd == 'a') ? SORT_ASC : SORT_DESC));

		foreach ($task_array as $row)
		{
			$this->template->assign_block_vars($row['task_sort'], array(
				'DISPLAY_NAME'  => $row['display_name'],
				'TASK_DATE'     => $row['task_date_print'],
				'NEW_DATE'      => $row['new_date_print'],
				'TASK_OK'       => $row['task_ok'],
				'LOCKED'        => $row['locked'],
				'CRON_TASK_RUN' => ($this->request->is_ajax()) ? '' : (($row['display_name'] != $cron_type) ? '<a href="' . $this->u_action . '&amp;cron_type=' . $row['display_name'] . '&amp;sk=' . $sk . '&amp;sd=' . $sd . '" class="cron_run_link">' . $this->user->lang['CRON_TASK_RUN'] . '</a>' : '<span class="cron_running_update">' . $this->user->lang['CRON_TASK_RUNNING'] . '</span>'),
			));
		}
	}

	/**
	 * Calculates parameters for a single Cron task
	 * and adds them to the resulting $task_array
	 *
	 * @param array                  $rows       Array with fetched parameters for Cron tasks
	 * @param \phpbb\cron\task\task  $task       Current Cron task object
	 * @param string                 $cronlock   Name of the Cron task locking the Cron
	 * @param array                 &$task_array Array of already collected Cron tasks
	 */
	public function handle_task(array $rows, $task, $cronlock, array &$task_array)
	{
		$task_name = $task->get_name();
		if (empty($task_name))
		{
			return;
		}

		$name = $task_name;
		$this->helper->get_task_params($rows, $name, $task_date);
		$new_task_date = $this->helper->get_new_task_date($rows, $task_date, $name);

		/**
		 * Event to modify task variables before displaying cron information
		 *
		 * @event leinad4mind.cronstatus.modify_cron_task
		 * @var object task          Task object
		 * @var object task_name     Task name ($task->get_name())
		 * @var object name          Task name for new task date
		 * @var object task_date     Last task date
		 * @var object new_task_date Next task date
		 * @since 3.4.0
		 */
		$vars = array('task', 'task_name', 'name', 'task_date', 'new_task_date');
		extract($this->phpbb_dispatcher->trigger_event('leinad4mind.cronstatus.modify_cron_task', compact($vars)));

		// Ready tasks always sort as 'ready'; among the rest, a task that has genuinely
		// never run (task_date === 0) gets its own 'never_started' bucket, while a task
		// with an unrecognized/"Auto" last-run time (task_date === -1) is just 'not_ready'.
		$task_array[] = array(
			'task_sort'       => ($task->is_ready()) ? 'ready' : (($task_date) ? 'not_ready' : 'never_started'),
			'display_name'    => $task_name,
			'task_date'       => $task_date,
			'task_date_print' => ($task_date == -1) ? $this->user->lang['CRON_TASK_AUTO'] : (($task_date) ? $this->user->format_date($task_date, $this->config['cronstatus_dateformat']) : $this->user->lang['CRON_TASK_NEVER_STARTED']),
			'new_date'        => $new_task_date,
			'new_date_print'  => ($new_task_date > 0) ? $this->user->format_date($new_task_date, $this->config['cronstatus_dateformat']) : '-',
			'task_ok'         => ($task_date > 0 && ($new_task_date > time())) ? false : true,
			'locked'          => ($this->config['cron_lock'] && $cronlock == $name) ? true : false,
		);
	}
}
