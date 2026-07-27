<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\controller;

use Symfony\Component\HttpFoundation\RedirectResponse;

class moderate
{
	/** @var \phpbb\config\config */
	protected \phpbb\config\config $config;

	/** @var \phpbb\request\request_interface */
	protected \phpbb\request\request_interface $request;

	/** @var \phpbb\template\template */
	protected \phpbb\template\template $template;

	/** @var \phpbb\user */
	protected \phpbb\user $user;

	/** @var \phpbb\language\language  */
	protected \phpbb\language\language $language;

	/** @var \phpbb\controller\helper */
	protected \phpbb\controller\helper $helper;

	/** @var \phpbbgallery\core\album\display */
	protected \phpbbgallery\core\album\display $display;

	/** @var \phpbbgallery\core\moderate  */
	protected \phpbbgallery\core\moderate $moderate;

	/** @var \phpbbgallery\core\auth\auth  */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/** @var \phpbbgallery\core\config */
	protected \phpbbgallery\core\config $gallery_config;

	/** @var \phpbbgallery\core\auth\image_authorization */
	protected \phpbbgallery\core\auth\image_authorization $image_authorization;

	/** @var \phpbbgallery\core\misc  */
	protected \phpbbgallery\core\misc $misc;

	/** @var \phpbbgallery\core\album\album  */
	protected \phpbbgallery\core\album\album $album;

	/** @var \phpbbgallery\core\image\image  */
	protected \phpbbgallery\core\image\image $image;

	/** @var \phpbbgallery\core\notification\helper  */
	protected \phpbbgallery\core\notification\helper $notification_helper;

	/** @var \phpbbgallery\core\url  */
	protected \phpbbgallery\core\url $url;

	/** @var \phpbbgallery\core\log  */
	protected \phpbbgallery\core\log $gallery_log;

	/** @var \phpbbgallery\core\report  */
	protected \phpbbgallery\core\report $report;

	/** @var \phpbb\user_loader  */
	protected \phpbb\user_loader $user_loader;

	/** @var string */
	protected string $root_path;

	/** @var string */
	protected string $php_ext;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config                   $config    Config object
	 * @param \phpbb\request\request_interface       $request   Request object
	 * @param \phpbb\template\template               $template  Template object
	 * @param \phpbb\user                            $user      User object
	 * @param \phpbb\language\language               $language
	 * @param \phpbb\controller\helper               $helper    Controller helper object
	 * @param \phpbbgallery\core\album\display       $display   Albums display object
	 * @param \phpbbgallery\core\moderate            $moderate
	 * @param \phpbbgallery\core\auth\auth           $gallery_auth
	 * @param \phpbbgallery\core\config              $gallery_config
	 * @param \phpbbgallery\core\auth\image_authorization $image_authorization
	 * @param \phpbbgallery\core\misc                $misc
	 * @param \phpbbgallery\core\album\album         $album
	 * @param \phpbbgallery\core\image\image         $image
	 * @param \phpbbgallery\core\notification\helper $notification_helper
	 * @param \phpbbgallery\core\url                 $url
	 * @param \phpbbgallery\core\log                 $gallery_log
	 * @param \phpbbgallery\core\report              $report
	 * @param \phpbb\user_loader                     $user_loader
	 * @param string                                 $root_path Root path
	 * @param string                                 $php_ext   php file extension
	 */
	public function __construct(\phpbb\config\config $config, \phpbb\request\request_interface $request,
		\phpbb\template\template $template, \phpbb\user $user, \phpbb\language\language $language,
		\phpbb\controller\helper $helper, \phpbbgallery\core\album\display $display, \phpbbgallery\core\moderate $moderate,
		\phpbbgallery\core\auth\auth $gallery_auth, \phpbbgallery\core\config $gallery_config,
		\phpbbgallery\core\auth\image_authorization $image_authorization,
		\phpbbgallery\core\misc $misc, \phpbbgallery\core\album\album $album, \phpbbgallery\core\image\image $image,
		\phpbbgallery\core\notification\helper $notification_helper, \phpbbgallery\core\url $url, \phpbbgallery\core\log $gallery_log,
		\phpbbgallery\core\report $report, \phpbb\user_loader $user_loader,
		string $root_path, string $php_ext)
	{
		$this->config = $config;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->helper = $helper;
		$this->display = $display;
		$this->moderate = $moderate;
		$this->gallery_auth = $gallery_auth;
		$this->gallery_config = $gallery_config;
		$this->image_authorization = $image_authorization;
		$this->misc = $misc;
		$this->album = $album;
		$this->image = $image;
		$this->notification_helper = $notification_helper;
		$this->url = $url;
		$this->gallery_log = $gallery_log;
		$this->report = $report;
		$this->user_loader = $user_loader;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * Index Controller
	 *    Route: gallery/moderate
	 *
	 * @param int $album_id
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function base(int $album_id = 0): \Symfony\Component\HttpFoundation\Response
	{
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$album_backlink = $album_id === 0 ? $this->helper->route('phpbbgallery_core_moderate') : $this->helper->route('phpbbgallery_core_moderate_album', ['album_id'	=> $album_id]);
		$album_loginlink = append_sid($this->root_path . 'ucp.' . $this->php_ext . '?mode=login');
		if ($album_id === 0)
		{
			if (!$this->gallery_auth->acl_check_global('m_'))
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
			}
		}
		else
		{
			$album = $this->album->get_info($album_id);
			if (!$this->gallery_auth->acl_check('m_', $album['album_id'], $album['album_user_id']))
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
			}
		}
		$this->language->add_lang(['gallery_mcp', 'gallery'], 'phpbbgallery/core');
		$this->language->add_lang('mcp');
		$this->display->display_albums(false, $this->config['load_moderators']);
		// This is the overview page, so we will need to create some queries
		// We will use the special moderate helper

		$this->report->build_list($album_id, 1, 5);
		$this->moderate->build_list($album_id, 1, 5);
		$this->gallery_log->build_list('moderator', 5, 1, $album_id);
		$this->assign_navigation($album_id > 0 ? $album : null);

		$this->template->assign_vars([
			'U_GALLERY_MODERATE_OVERVIEW'	=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate'),
			'U_GALLERY_MODERATE_APPROVE'	=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_queue_approve_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_queue_approve'),
			'U_GALLERY_MODERATE_REPORT'		=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_reports_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_reports'),
			'U_ALBUM_OVERVIEW'				=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_view', ['album_id' => $album_id]) : false,
			'U_GALLERY_MCP_LOGS'			=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_action_log_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_action_log'),
			'U_ALBUM_NAME'					=> $album_id > 0 ? $album['album_name'] : false,
			'U_OVERVIEW'					=> true,
		]);

		return $this->helper->render('gallery/moderate_overview.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Index Controller
	 *    Route: gallery/moderate/approve
	 *
	 * @param int $page
	 * @param int $album_id
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function queue_approve(int $page, int $album_id): \Symfony\Component\HttpFoundation\Response|null
	{
		$page = $this->normalize_page($page);
		$approve_ary = $this->request->variable('approval', ['' => [0]]);
		$action_ary = $this->request->variable('action', ['' => 0]);
		$back_link = $this->request->variable('back_link', $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_queue_approve_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_queue_approve'));
		$action = '';
		foreach ($action_ary as $act => $garb)
		{
			$action = $act;
		}

		$this->language->add_lang(['gallery_mcp', 'gallery'], 'phpbbgallery/core');
		$this->language->add_lang('mcp');

		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$album_backlink = $album_id === 0 ? $this->helper->route('phpbbgallery_core_moderate') : $this->helper->route('phpbbgallery_core_moderate_album', ['album_id'	=> $album_id]);
		$album_loginlink = append_sid($this->root_path . 'ucp.' . $this->php_ext . '?mode=login');
		if ($album_id === 0)
		{
			if (!$this->gallery_auth->acl_check_global('m_status'))
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
				return null;
			}
		}
		else
		{
			$album = $this->album->get_info($album_id);
			if (!$this->gallery_auth->acl_check('m_status', $album['album_id'], $album['album_user_id']))
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
				return null;
			}
		}
		if (!empty($approve_ary))
		{
			if (count($action_ary) !== 1 || !in_array($action, ['approve', 'disapprove'], true))
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
				return null;
			}

			$selected_image_ids = [];
			foreach ($approve_ary as $submitted_image_ids)
			{
				if (!is_array($submitted_image_ids))
				{
					$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
					return null;
				}
				$selected_image_ids = array_merge($selected_image_ids, $submitted_image_ids);
			}
			$authorized_action = $this->authorize_action_images($selected_image_ids, 'm_status', (int) $album_id);
			if ($authorized_action === false)
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
				return null;
			}
			$approve_ary = $authorized_action['images_by_album'];

			if (confirm_box(true))
			{
				if ($action == 'approve')
				{
					$count = 0;
					foreach ($approve_ary as $target_album_id => $approve_array)
					{
						$this->image->approve_images($approve_array, $target_album_id);
						$this->album->update_info($target_album_id);
						$count = $count + count($approve_array);
					}

					$message = $this->language->lang('WAITING_APPROVED_IMAGE', $count);
					$this->url->meta_refresh(3, $back_link);
					trigger_error($message);
				}
				if ($action == 'disapprove')
				{
					$count = 0;
					foreach ($approve_ary as $target_album_id => $delete_array)
					{
						// Let's load info for images, so we can
						$filenames = $this->image->get_filenames($delete_array);
						// Let's log the action
						foreach ($filenames as $name)
						{
							$this->gallery_log->add_log('moderator', 'disapprove', $target_album_id, 0, ['LOG_GALLERY_DISAPPROVED', $name]);
						}
						$this->moderate->delete_images($delete_array);
						$count = $count + count($delete_array);
					}
					$message = $this->language->lang('WAITING_DISAPPROVED_IMAGE', $count);
					$this->url->meta_refresh(3, $back_link);
					trigger_error($message);
				}
			}
			else
			{
				$s_hidden_fields = '<input type="hidden" name="action['.$action.']" value="' . $action . '" />';
				$s_hidden_fields .= '<input type="hidden" name="back_link" value="' . $back_link . '" />';
				foreach ($approve_ary as $id => $var)
				{
					foreach ($var as $var1)
					{
						$s_hidden_fields .= '<input type="hidden" name="approval[' . $id . '][]" value="' . $var1 . '" />';
					}
				}
				confirm_box(false, $this->language->lang('QUEUES_A_' . strtoupper($action) . '2_CONFIRM'), $s_hidden_fields);
			}
		}

		$this->assign_navigation($album_id > 0 ? $album : null);
		$this->template->assign_vars([
			'U_GALLERY_MODERATE_OVERVIEW'	=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate'),
			'U_GALLERY_MODERATE_APPROVE'	=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_queue_approve_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_queue_approve'),
			'U_GALLERY_MODERATE_REPORT'		=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_reports_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_reports'),
			'U_ALBUM_OVERVIEW'				=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_view', ['album_id' => $album_id]) : false,
			'U_GALLERY_MCP_LOGS'			=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_action_log_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_action_log'),
			'U_ALBUM_NAME'					=> $album_id > 0 ? $album['album_name'] : false,
		]);
		$this->moderate->build_list($album_id, $page);
		return $this->helper->render('gallery/moderate_approve.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Index Controller
	 *    Route: gallery/moderate/actions
	 *
	 * @param int $page
	 * @param int $album_id
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function action_log(int $page, int $album_id): \Symfony\Component\HttpFoundation\Response
	{
		$page = $this->normalize_page($page);
		$this->language->add_lang(['gallery_mcp', 'gallery'], 'phpbbgallery/core');
		$this->language->add_lang('mcp');

		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$album_backlink = $album_id === 0 ? $this->helper->route('phpbbgallery_core_moderate') : $this->helper->route('phpbbgallery_core_moderate_album', ['album_id'	=> $album_id]);
		$album_loginlink = append_sid($this->root_path . 'ucp.' . $this->php_ext . '?mode=login');
		if ($album_id === 0)
		{
			if (!$this->gallery_auth->acl_check_global('m_'))
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
			}
		}
		else
		{
			$album = $this->album->get_info($album_id);
			if (!$this->gallery_auth->acl_check('m_', $album['album_id'], $album['album_user_id']))
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
			}
		}
		$this->assign_navigation($album_id > 0 ? $album : null);
		$this->template->assign_vars([
			'U_GALLERY_MODERATE_OVERVIEW'	=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate'),
			'U_GALLERY_MODERATE_APPROVE'	=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_queue_approve_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_queue_approve'),
			'U_GALLERY_MODERATE_REPORT'		=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_reports_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_reports'),
			'U_ALBUM_OVERVIEW'				=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_view', ['album_id' => $album_id]) : false,
			'U_GALLERY_MCP_LOGS'			=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_action_log_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_action_log'),
			'U_ALBUM_NAME'					=> $album_id > 0 ? $album['album_name'] : false,
		]);

		$this->gallery_log->build_list('moderator', 0, $page, $album_id);
		return $this->helper->render('gallery/moderate_actions.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Index Controller
	 *    Route: gallery/moderate/reports
	 *
	 * @param int $page
	 * @param int $album_id
	 * @param int $status
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function reports(int $page, int $album_id, int $status): \Symfony\Component\HttpFoundation\Response|null
	{
		$page = $this->normalize_page($page);
		$report_ary = $this->request->variable('report', [0]);
		$action_ary = $this->request->variable('action', ['' => 0]);
		$back_link = $this->request->variable('back_link', $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_reports_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_reports'));
		$action = '';
		foreach ($action_ary as $act => $garb)
		{
			$action = $act;
		}

		$this->language->add_lang(['gallery_mcp', 'gallery'], 'phpbbgallery/core');
		$this->language->add_lang('mcp');

		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$album_backlink = $album_id === 0 ? $this->helper->route('phpbbgallery_core_moderate') : $this->helper->route('phpbbgallery_core_moderate_album', ['album_id'	=> $album_id]);
		$album_loginlink = append_sid($this->root_path . 'ucp.' . $this->php_ext . '?mode=login');
		if ($album_id === 0)
		{
			if (!$this->gallery_auth->acl_check_global('m_report'))
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
				return null;
			}
		}
		else
		{
			$album = $this->album->get_info($album_id);
			if (!$this->gallery_auth->acl_check('m_report', $album['album_id'], $album['album_user_id']))
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
				return null;
			}
		}

		if (!empty($report_ary))
		{
			if (count($action_ary) !== 1 || $action !== 'close')
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
				return null;
			}
			$authorized_action = $this->authorize_action_images($report_ary, 'm_report', (int) $album_id);
			if ($authorized_action === false)
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
				return null;
			}
			$report_ary = $authorized_action['image_ids'];

			if (confirm_box(true))
			{
				$this->report->close_reports_by_image($report_ary);
				$message = $this->language->lang('WAITING_REPORTED_DONE', count($report_ary));
				$this->url->meta_refresh(3, $back_link);
				trigger_error($message);
			}
			else
			{
				$s_hidden_fields = '<input type="hidden" name="action['.$action.']" value="' . $action . '" />';
				$s_hidden_fields .= '<input type="hidden" name="back_link" value="' . $back_link . '" />';
				foreach ($report_ary as $var)
				{
					$s_hidden_fields .= '<input type="hidden" name="report[]" value="' . $var . '" />';
				}
				confirm_box(false, $this->language->lang('REPORTS_A_CLOSE2_CONFIRM'), $s_hidden_fields);
			}
		}

		$this->assign_navigation($album_id > 0 ? $album : null);
		$this->template->assign_vars([
			'U_GALLERY_MODERATE_OVERVIEW'	=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate'),
			'U_GALLERY_MODERATE_APPROVE'	=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_queue_approve_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_queue_approve'),
			'U_GALLERY_MODERATE_REPORT'		=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_reports_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_reports'),
			'U_ALBUM_OVERVIEW'				=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_view', ['album_id' => $album_id]) : false,
			'U_GALLERY_MODERATE_REPORT_CLOSED'		=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_reports_closed_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_reports_closed'),
			'U_GALLERY_MCP_LOGS'			=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_action_log_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_action_log'),
			'U_ALBUM_NAME'					=> $album_id > 0 ? $album['album_name'] : false,
			'U_STATUS'						=> $status == 1 ? true : false,
		]);

		$this->report->build_list($album_id, $page, $this->config['phpbb_gallery_items_per_page'], $status);
		return $this->helper->render('gallery/moderate_reports.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Moderate Controller
	 *    Route: gallery/moderate/{album_id}/list
	 *
	 * @param int $album_id
	 * @param int $page
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function album_overview(int $album_id, int $page): \Symfony\Component\HttpFoundation\Response|null
	{
		$page = $this->normalize_page($page);
		$this->language->add_lang(['gallery_mcp', 'gallery'], 'phpbbgallery/core');
		$this->language->add_lang('mcp');

		$actions_array = $this->request->variable('action', [0]);
		$action = $this->request->variable('select_action', '');
		$back_link = $this->request->variable('back_link', $this->helper->route('phpbbgallery_core_moderate_view', ['album_id' => $album_id]));
		$moving_target = $this->request->variable('moving_target', '');

		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$album_backlink = $album_id === 0 ? $this->helper->route('phpbbgallery_core_moderate') : $this->helper->route('phpbbgallery_core_moderate_album', ['album_id'	=> $album_id]);
		$album_loginlink = append_sid($this->root_path . 'ucp.' . $this->php_ext . '?mode=login');
		if ($album_id === 0)
		{
			if (!$this->gallery_auth->acl_check_global('m_'))
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
				return null;
			}
		}
		else
		{
			$album = $this->album->get_info($album_id);
			if (!$this->gallery_auth->acl_check('m_', $album['album_id'], $album['album_user_id']))
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
				return null;
			}
		}
		$this->assign_navigation($album_id > 0 ? $album : null);

		if (!empty($actions_array))
		{
			// Each moderator action requires its own specific permission bit,
			// the generic 'm_' checked above only gates access to this page.
			$action_permission = [
				'approve'	=> 'm_status',
				'unapprove'	=> 'm_status',
				'lock'		=> 'm_status',
				'delete'	=> 'm_delete',
				'move'		=> 'm_move',
				'report'	=> 'm_report',
			];
			if (!isset($action_permission[$action]))
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
				return null;
			}

			$authorized_action = $this->authorize_action_images($actions_array, $action_permission[$action], (int) $album_id);
			if ($authorized_action === false)
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
				return null;
			}
			$actions_array = $authorized_action['image_ids'];
			$actions_by_album = $authorized_action['images_by_album'];

			if ($action == 'move' && $moving_target)
			{
				$moving_target = (int) $moving_target;
				$target_album = $moving_target > 0 ? $this->album->get_info($moving_target) : [];
				$has_target_permission = $moving_target > 0 && $this->gallery_auth->acl_check('m_move', $moving_target, isset($target_album['album_user_id']) ? $target_album['album_user_id'] : -1);
				if (!$this->image_authorization->can_moderate_album($target_album, $moving_target, $has_target_permission))
				{
					$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
					return null;
				}
			}

			// The move flow has its own two-step UI (pick target album, then submit)
			// instead of phpBB's confirm_box, so it needs its own CSRF token check.
			if ($action == 'move' && $moving_target && !confirm_box(true))
			{
				if (!check_form_key('gallery'))
				{
					trigger_error('FORM_INVALID');
				}
			}

			if (confirm_box(true) || ($action == 'move' && $moving_target))
			{
				$message = '';
				switch ($action)
				{
					case 'approve':
						foreach ($actions_by_album as $source_album_id => $source_image_ids)
						{
							$this->image->approve_images($source_image_ids, $source_album_id);
							$this->album->update_info($source_album_id);
						}
						$message = $this->language->lang('WAITING_APPROVED_IMAGE', count($actions_array));
					break;

					case 'unapprove':
						foreach ($actions_by_album as $source_album_id => $source_image_ids)
						{
							$this->image->unapprove_images($source_image_ids, $source_album_id);
							$this->album->update_info($source_album_id);
						}
						$message = $this->language->lang('WAITING_UNAPPROVED_IMAGE', count($actions_array));
					break;

					case 'lock':
						foreach ($actions_by_album as $source_album_id => $source_image_ids)
						{
							$this->image->lock_images($source_image_ids, $source_album_id);
							$this->album->update_info($source_album_id);
						}
						$message = $this->language->lang('WAITING_LOCKED_IMAGE', count($actions_array));
					break;

					case 'delete':
						$this->moderate->delete_images($actions_array);
						foreach (array_keys($actions_by_album) as $source_album_id)
						{
							$this->album->update_info($source_album_id);
						}
						$message = $this->language->lang('DELETED_IMAGES', count($actions_array));
					break;

					case 'move':
						$this->image->move_image($actions_array, $moving_target);
						foreach (array_keys($actions_by_album) as $source_album_id)
						{
							$this->album->update_info($source_album_id);
						}
						$this->album->update_info($moving_target);
						$message = $this->language->lang('MOVED_IMAGES', count($actions_array));
					break;

					case 'report':
						$this->report->close_reports_by_image($actions_array);
						$message = $this->language->lang('WAITING_REPORTED_DONE', count($actions_array));
					break;
				}

				if (!empty($message))
				{
					$this->url->meta_refresh(3, $back_link);
					trigger_error($message);
				}
			}
			else
			{
				$s_hidden_fields = '<input type="hidden" name="select_action" value="' . $action . '" />';
				$s_hidden_fields .= '<input type="hidden" name="back_link" value="' . $back_link . '" />';
				foreach ($actions_array as $var)
				{
					$s_hidden_fields .= '<input type="hidden" name="action[]" value="' . $var . '" />';
				}
				if ($action == 'report')
				{
					confirm_box(false, $this->language->lang('REPORT_A_CLOSE2_CONFIRM'), $s_hidden_fields);
				}
				if ($action == 'move')
				{
					add_form_key('gallery');
					$category_select = $this->album->get_albumbox(false, 'moving_target', $album_id, 'm_move', $album_id);
					$this->template->assign_vars([
						'S_MOVING_IMAGES'	=> true,
						'S_ALBUM_SELECT'	=> $category_select,
						'S_HIDDEN_FIELDS'	=> $s_hidden_fields,
					]);
					return $this->helper->render('gallery/mcp_body.html', $this->gallery_config->get_title($this->language));
				}
				else
				{
					confirm_box(false, $this->language->lang('QUEUES_A_' . strtoupper($action) . '2_CONFIRM'), $s_hidden_fields);
				}
			}
		}
		$this->template->assign_vars([
			'U_GALLERY_MODERATE_OVERVIEW'	=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate'),
			'U_GALLERY_MODERATE_APPROVE'	=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_queue_approve_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_queue_approve'),
			'U_GALLERY_MODERATE_REPORT'		=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_reports_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_reports'),
			'U_ALBUM_OVERVIEW'				=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_view', ['album_id' => $album_id]) : false,
			'U_GALLERY_MCP_LOGS'			=> $album_id > 0 ? $this->helper->route('phpbbgallery_core_moderate_action_log_album', ['album_id' => $album_id]) : $this->helper->route('phpbbgallery_core_moderate_action_log'),
			'U_ALBUM_NAME'					=> $album_id > 0 ? $album['album_name'] : false,
		]);
		$this->moderate->album_overview($album_id, $page);
		return $this->helper->render('gallery/moderate_album_overview.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Validate every selected image against its real album and action permission.
	 *
	 * @return array|false
	 */
	private function authorize_action_images(array $image_ids, string $permission, int $route_album_id): array|false
	{
		$image_ids = $this->image_authorization->normalize_image_ids($image_ids);
		if ($image_ids === false)
		{
			return false;
		}

		$images_by_album = [];
		foreach ($image_ids as $image_id)
		{
			$image_data = $this->image->get_image_data($image_id);
			if (!is_array($image_data) || !isset($image_data['image_album_id']) || (int) $image_data['image_album_id'] < 1)
			{
				return false;
			}

			$image_album_id = (int) $image_data['image_album_id'];
			$album_data = $this->album->get_info($image_album_id);
			if (!is_array($album_data) || !isset($album_data['album_id'], $album_data['album_user_id']) || (int) $album_data['album_id'] !== $image_album_id)
			{
				return false;
			}
			$has_permission = $this->gallery_auth->acl_check($permission, $image_album_id, $album_data['album_user_id']);
			if (!$this->image_authorization->can_moderate_image($image_data, $album_data, $route_album_id, $has_permission))
			{
				return false;
			}

			$images_by_album[$image_album_id][] = $image_id;
		}

		return [
			'image_ids' => $image_ids,
			'images_by_album' => $images_by_album,
		];
	}

	/**
	 * Index Controller
	 *    Route: gallery/moderate/image/{image_id}
	 *
	 * @param int $image_id
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function image(int $image_id): \Symfony\Component\HttpFoundation\Response
	{
		$this->language->add_lang(['gallery_mcp', 'gallery'], 'phpbbgallery/core');
		$this->language->add_lang('mcp');
		$quick_action = $this->request->variable('action', '');

		// If we have quick mode (EDIT, DELETE) just send us to the page we need
		switch ($quick_action)
		{
			case 'images_move':
				$route = $this->helper->route('phpbbgallery_core_moderate_image_move', ['image_id'	=> $image_id]);
				return new RedirectResponse($route);
			case 'image_edit':
				$route = $this->helper->route('phpbbgallery_core_image_edit', ['image_id'	=> $image_id]);
				return new RedirectResponse($route);
			case 'images_unapprove':
				$route = $this->helper->route('phpbbgallery_core_moderate_image_unapprove', ['image_id'	=> $image_id]);
				return new RedirectResponse($route);
			case 'images_approve':
				$route = $this->helper->route('phpbbgallery_core_moderate_image_approve', ['image_id'	=> $image_id]);
				return new RedirectResponse($route);
			case 'images_lock':
				$route = $this->helper->route('phpbbgallery_core_moderate_image_lock', ['image_id'	=> $image_id]);
				return new RedirectResponse($route);
			case 'images_delete':
				$route = $this->helper->route('phpbbgallery_core_image_delete', ['image_id'	=> $image_id]);
				return new RedirectResponse($route);
			case 'reports_close':
				$reports_close_image_data = $this->image->get_image_data_or_fail($image_id);
				$reports_close_album_data = $this->album->get_info($reports_close_image_data['image_album_id']);
				$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
				if (!$this->gallery_auth->acl_check('m_report', $reports_close_album_data['album_id'], $reports_close_album_data['album_user_id']))
				{
					$album_backlink = $this->helper->route('phpbbgallery_core_moderate_image', ['image_id' => $image_id]);
					$album_loginlink = append_sid($this->root_path . 'ucp.' . $this->php_ext . '?mode=login');
					$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
				}
				if (confirm_box(true))
				{
					$back_link =  $this->helper->route('phpbbgallery_core_moderate_image', ['image_id' => $image_id]);
					$this->report->close_reports_by_image($image_id);
					$message = $this->language->lang('WAITING_REPORTED_DONE', 1);
					$this->url->meta_refresh(3, $back_link);
					trigger_error($message);
				}
				else
				{
					$s_hidden_fields = '<input type="hidden" name="action" value="reports_close" />';
					confirm_box(false, $this->language->lang('REPORT_A_CLOSE2_CONFIRM'), $s_hidden_fields);
				}
			break;
			case 'reports_open':
				$route = $this->helper->route('phpbbgallery_core_image_report', ['image_id'	=> $image_id]);
				return new RedirectResponse($route);
		}
		$image_data = $this->image->get_image_data_or_fail($image_id);
		$album_data = $this->album->get_info($image_data['image_album_id']);
		$users_array = $report_data = [];
		$open_report = false;
		$report_data = $this->report->get_data_by_image($image_id);
		foreach ($report_data as $var)
		{
			$users_array[$var['reporter_id']] = [''];
			$users_array[$var['report_manager']] = [''];
			if ($var['report_status'] == 1)
			{
				$open_report = true;
			}
		}
		$users_array[$image_data['image_user_id']] = [''];
		$this->user_loader->load_users(array_keys($users_array));
		// Now let's get some ACL
		$select_select = '<option value="" selected="selected">' . $this->language->lang('CHOOSE_ACTION') . '</option>';
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		if ($this->gallery_auth->acl_check('m_status', $album_data['album_id'], $album_data['album_user_id']))
		{
			if ($image_data['image_status'] == 0)
			{
				$select_select .= '<option value="images_approve">' . $this->language->lang('QUEUE_A_APPROVE') . '</option>';
				$select_select .= '<option value="images_lock">' . $this->language->lang('QUEUE_A_LOCK') . '</option>';
			}
			else if ($image_data['image_status'] == 1)
			{
				$select_select .= '<option value="images_unapprove">' . $this->language->lang('QUEUE_A_UNAPPROVE') . '</option>';
				$select_select .= '<option value="images_lock">' . $this->language->lang('QUEUE_A_LOCK') . '</option>';
			}
			else
			{
				$select_select .= '<option value="images_approve">' . $this->language->lang('QUEUE_A_APPROVE') . '</option>';
				$select_select .= '<option value="images_unapprove">' . $this->language->lang('QUEUE_A_UNAPPROVE') . '</option>';
			}
		}
		if ($this->gallery_auth->acl_check('m_delete', $album_data['album_id'], $album_data['album_user_id']))
		{
			$select_select .= '<option value="images_delete">' . $this->language->lang('QUEUE_A_DELETE') . '</option>';
		}
		if ($this->gallery_auth->acl_check('m_move', $album_data['album_id'], $album_data['album_user_id']))
		{
			$select_select .= '<option value="images_move">' . $this->language->lang('QUEUES_A_MOVE') . '</option>';
		}
		if ($this->gallery_auth->acl_check('m_report', $album_data['album_id'], $album_data['album_user_id']))
		{
			if ($open_report)
			{
				$select_select .= '<option value="reports_close">' . $this->language->lang('REPORT_A_CLOSE') . '</option>';
			}
			else
			{
				$select_select .= '<option value="reports_open">' . $this->language->lang('REPORT_A_OPEN') . '</option>';
			}
		}
		$this->assign_navigation($album_data);
		$this->template->assign_vars([
			'ALBUM_NAME'		=> $album_data['album_name'],
			'U_VIEW_ALBUM'		=> $this->helper->route('phpbbgallery_core_moderate_album', ['album_id' => $image_data['image_album_id']]),
			'U_EDIT_IMAGE'		=> $this->helper->route('phpbbgallery_core_image_edit', ['image_id'	=> $image_id]),
			'U_DELETE_IMAGE'	=> $this->helper->route('phpbbgallery_core_image_delete', ['image_id'	=> $image_id]),
			'IMAGE_NAME'		=> $image_data['image_name'],
			'IMAGE_TIME'		=> $this->user->format_date($image_data['image_time']),
			'UPLOADER'			=> $this->user_loader->get_username($image_data['image_user_id'], 'full'),
			'U_MOVE_IMAGE'		=> $this->helper->route('phpbbgallery_core_moderate_image_move', ['image_id'	=> $image_id]),
			'STATUS'			=> $this->language->lang('QUEUE_STATUS_' . $image_data['image_status']),
			'UC_IMAGE'			=> $this->image->generate_link('medium', $this->config['phpbb_gallery_link_thumbnail'], $image_data['image_id'], $image_data['image_name'], $image_data['image_album_id']),
			'IMAGE_DESC'		=> generate_text_for_display($image_data['image_desc'], $image_data['image_desc_uid'], $image_data['image_desc_bitfield'], 7),
			'U_SELECT'			=> $select_select,
			'S_MCP_ACTION'		=> $this->helper->route('phpbbgallery_core_moderate_image', ['image_id' => $image_id]),
		]);
		foreach ($report_data as $var)
		{
			$this->template->assign_block_vars('reports', [
				'REPORTER'		=> $this->user_loader->get_username($var['reporter_id'], 'full'),
				'REPORT_TIME'	=> $this->user->format_date($var['report_time']),
				'REPORT_NOTE'	=> $var['report_note'],
				'STATUS'		=> $var['report_status'],
				'MANAGER'		=> $var['report_manager'] != 0 ?  $this->user_loader->get_username($var['report_manager'], 'full') : false,
			]);
		}
		return $this->helper->render('gallery/moderate_image_overview.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Index Controller
	 *    Route: gallery/moderate/image/{image_id}/approve
	 *
	 * @param int $image_id
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function approve(int $image_id): \Symfony\Component\HttpFoundation\Response
	{
		$image_data = $this->image->get_image_data_or_fail($image_id);
		$album_data = $this->album->get_info($image_data['image_album_id']);

		$album_backlink = $this->helper->route('phpbbgallery_core_album', ['album_id' => $image_data['image_album_id']]);
		$image_backlink = $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]);
		$album_loginlink = append_sid($this->root_path . 'ucp.' . $this->php_ext . '?mode=login');
		$meta_refresh_time = 2;
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		if (!$this->gallery_auth->acl_check('m_status', $image_data['image_album_id'], $album_data['album_user_id']))
		{
			$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
		}
		$action_keys = array_keys($this->request->variable('action', ['approve' => 1]));
		$action = $action_keys[0] ?? 'approve';

		if ($action === 'disapprove')
		{
			return new RedirectResponse($this->helper->route('phpbbgallery_core_image_delete', ['image_id' => $image_id]));
		}
		$show_notify = true;
		$this->language->add_lang(['gallery_mcp', 'gallery'], 'phpbbgallery/core');
		$this->language->add_lang('mcp');
		if (confirm_box(true))
		{
			$np = $this->request->variable('notify_poster', '');
			$notify_poster = ($action == 'approve' && $np);
			$image_id_ary = [$image_id];
			$this->image->approve_images($image_id_ary, $album_data['album_id']);
			$this->album->update_info($album_data['album_id']);
			// So we need to see if there are still unapproved images in the album
			$this->notification_helper->read('approval', $album_data['album_id']);
			$message = $this->language->lang('WAITING_APPROVED_IMAGE', 1);
			meta_refresh($meta_refresh_time, $image_backlink);
			trigger_error($message);
		}
		else
		{
			$this->template->assign_vars([
				'S_NOTIFY_POSTER'			=> $show_notify,
				'S_' . strtoupper($action)	=> true,
				'S_CONFIRM_ACTION'	=> $this->helper->route('phpbbgallery_core_moderate_image_approve', ['image_id' => $image_id]),
			]);
			$action_msg = $this->language->lang('QUEUES_A_APPROVE2_CONFIRM');
			$s_hidden_fields = build_hidden_fields([
				'action'		=> 'approve',
			]);
			confirm_box(false, $action_msg, $s_hidden_fields, 'mcp_approve.html');
		}

		return $this->helper->render('gallery/moderate_overview.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Index Controller
	 *    Route: gallery/moderate/image/{image_id}/unapprove
	 *
	 * @param int $image_id
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function unapprove(int $image_id): \Symfony\Component\HttpFoundation\Response
	{
		$image_data = $this->image->get_image_data_or_fail($image_id);
		$album_data = $this->album->get_info($image_data['image_album_id']);

		$album_backlink = $this->helper->route('phpbbgallery_core_index');
		$image_backlink = $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]);
		$album_loginlink = append_sid($this->root_path . 'ucp.' . $this->php_ext . '?mode=login');
		$meta_refresh_time = 2;
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		if (!$this->gallery_auth->acl_check('m_status', $image_data['image_album_id'], $album_data['album_user_id']))
		{
			$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
		}

		$this->language->add_lang(['gallery_mcp', 'gallery'], 'phpbbgallery/core');
		$this->language->add_lang('mcp');
		if (confirm_box(true))
		{
			$image_id_ary = [$image_id];
			$this->image->unapprove_images($image_id_ary, $album_data['album_id']);
			// To DO - add notification
			$message = sprintf($this->language->lang('WAITING_UNAPPROVED_IMAGE', 1));
			meta_refresh($meta_refresh_time, $image_backlink);
			trigger_error($message);
		}
		else
		{
			$s_hidden_fields = '';
			confirm_box(false, 'QUEUE_A_UNAPPROVE2', $s_hidden_fields);
		}

		return $this->helper->render('gallery/moderate_overview.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Index Controller
	 *    Route: gallery/moderate/image/{image_id}/move
	 *
	 * @param int $image_id
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function move(int $image_id): \Symfony\Component\HttpFoundation\Response
	{
		$image_data = $this->image->get_image_data_or_fail($image_id);
		$image_backlink = $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]);
		$album_loginlink = append_sid($this->root_path . 'ucp.' . $this->php_ext . '?mode=login');
		$meta_refresh_time = 2;
		$this->language->add_lang(['gallery_mcp', 'gallery'], 'phpbbgallery/core');
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);

		if (!is_array($image_data) || !isset($image_data['image_album_id']) || (int) $image_data['image_album_id'] < 1)
		{
			$this->misc->not_authorised($image_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
			return $this->helper->render('gallery/mcp_body.html', $this->gallery_config->get_title($this->language));
		}

		$album_id = (int) $image_data['image_album_id'];
		$album_data = $this->album->get_info($album_id);
		$album_backlink = $this->helper->route('phpbbgallery_core_album', ['album_id' => $album_id]);
		$has_source_permission = is_array($album_data) && isset($album_data['album_user_id']) && $this->gallery_auth->acl_check('m_move', $album_id, $album_data['album_user_id']);
		if (!is_array($album_data) || !$this->image_authorization->can_moderate_image($image_data, $album_data, 0, $has_source_permission))
		{
			$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
			return $this->helper->render('gallery/mcp_body.html', $this->gallery_config->get_title($this->language));
		}

		add_form_key('gallery');
		$is_move_submitted = $this->request->is_set_post('moving_target');
		$moving_target = $this->request->variable('moving_target', 0, false, \phpbb\request\request_interface::POST);

		if ($is_move_submitted)
		{
			if (!check_form_key('gallery'))
			{
				trigger_error('FORM_INVALID');
			}

			$target_album = $moving_target > 0 ? $this->album->get_info($moving_target) : [];
			$has_target_permission = is_array($target_album) && isset($target_album['album_user_id']) && $this->gallery_auth->acl_check('m_move', $moving_target, $target_album['album_user_id']);
			if (!$this->image_authorization->can_moderate_album($target_album, $moving_target, $has_target_permission))
			{
				$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
				return $this->helper->render('gallery/mcp_body.html', $this->gallery_config->get_title($this->language));
			}

			$target = [$image_id];
			$this->image->move_image($target, $moving_target);
			$message = sprintf($this->language->lang('IMAGES_MOVED', 1));
			$this->album->update_info($album_id);
			$this->album->update_info($moving_target);
			meta_refresh($meta_refresh_time, $image_backlink);
			trigger_error($message);
		}
		else
		{
			$category_select = $this->album->get_albumbox(false, 'moving_target', $album_id, 'm_move', $album_id);
			$this->template->assign_vars([
				'S_MOVING_IMAGES'	=> true,
				'S_ALBUM_SELECT'	=> $category_select,
			]);
		}

		return $this->helper->render('gallery/mcp_body.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Index Controller
	 *    Route: gallery/moderate/image/{image_id}/lock
	 *
	 * @param int $image_id
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function lock(int $image_id): \Symfony\Component\HttpFoundation\Response
	{
		$image_data = $this->image->get_image_data_or_fail($image_id);
		$album_id = $image_data['image_album_id'];
		$album_data =  $this->album->get_info($album_id);
		$album_backlink = $this->helper->route('phpbbgallery_core_album', ['album_id' => $album_id]);
		$image_backlink = $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]);
		$album_loginlink = append_sid($this->root_path . 'ucp.' . $this->php_ext . '?mode=login');
		$meta_refresh_time = 2;
		$this->language->add_lang(['gallery_mcp', 'gallery'], 'phpbbgallery/core');
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		if (!$this->gallery_auth->acl_check('m_status', $image_data['image_album_id'], $album_data['album_user_id']))
		{
			$this->misc->not_authorised($album_backlink, $album_loginlink, 'LOGIN_EXPLAIN_UPLOAD');
		}
		if (confirm_box(true))
		{
			$image_id_ary = [$image_id];
			$this->image->lock_images($image_id_ary, $album_data['album_id']);
			// To DO - add notification
			$message = sprintf($this->language->lang('WAITING_LOCKED_IMAGE',1));
			meta_refresh($meta_refresh_time, $image_backlink);
			trigger_error($message);
		}
		else
		{
			$s_hidden_fields = '';
			confirm_box(false, 'QUEUE_A_LOCK2', $s_hidden_fields);
		}

		return $this->helper->render('gallery/moderate_overview.html', $this->gallery_config->get_title($this->language));
	}

	/**
	 * Keep routed page numbers inside the valid pagination range.
	 *
	 * @param int $page Requested page number
	 * @return int Normalized page number
	 */
	private function normalize_page(int $page): int
	{
		return max(1, $page);
	}

	/**
	 * Add the Gallery and album hierarchy to moderation breadcrumbs.
	 *
	 * @param array|null $album_data Current album data, or null for global moderation
	 * @return void
	 */
	private function assign_navigation(array|null $album_data): void
	{
		if ($album_data !== null)
		{
			$this->display->generate_navigation($album_data);
			return;
		}

		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME' => $this->gallery_config->get_title($this->language),
			'U_VIEW_FORUM' => $this->helper->route('phpbbgallery_core_index'),
		]);
	}
}
