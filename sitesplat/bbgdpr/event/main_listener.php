<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\event;

use \sitesplat\bbgdpr\ext;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * BBgdpr Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.permissions'	=> 'add_permission',

			'core.acp_users_overview_before'	=> 'add_accept_dates',

			'core.mcp_global_f_read_auth_after'	=> 'check_gdpr_review',

			'core.user_setup'									=> 'load_language_on_setup',
			'core.page_header_after'							=> 'template_vars',
			'core.ucp_register_agreement_modify_template_data'	=> 'load_modified_agreement',
			'core.ucp_register_requests_after'					=> 'load_reg_lang',
			'core.ucp_register_data_before'						=> 'assign_reg_data',
			'core.ucp_register_data_after'						=> 'check_reg_data',
			'core.ucp_register_user_row_after'					=> 'add_acceptance_date',
			'core.ucp_register_modify_template_data'			=> 'template_reg_data',
			'core.login_box_redirect'							=> array(
				'privacy_redirect',
				999, // Needed to allow this to run before any other extension.
			),
		);
	}

	protected $helper;
	protected $template;
	protected $config_text;
	protected $user;
	protected $language;
	protected $config;
	protected $request;
	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\config\db_text $config_text, \phpbb\user $user, \phpbb\language\language $language, \phpbb\config\config $config, \phpbb\request\request $request)
	{
		$this->helper = $helper;
		$this->template = $template;
		$this->config_text = $config_text;
		$this->user = $user;
		$this->language = $language;
		$this->config = $config;
		$this->request = $request;
	}

	public function add_permission($event)
	{
		$event->update_subarray('permissions', 'u_delete_my_account_posts', array('lang' => 'ACL_U_DELETE_MY_ACCOUNT_POSTS', 'cat' => 'profile'));
	}

	public function add_accept_dates($event)
	{
		$this->template->assign_vars(array(
			'PRIVACY_ACCEPT_DATE'	=> $event['user_row']['user_privacy_accept_date'] > 0 ? $this->user->format_date($event['user_row']['user_privacy_accept_date'], false, true) : $this->language->lang('NOT_ACCEPTED'),
			'MCP_ACCEPT_DATE'		=> $event['user_row']['user_mcp_accept_date'] > 0 ? $this->user->format_date($event['user_row']['user_mcp_accept_date'], false, true) : $this->language->lang('NOT_ACCEPTED'),
		));
	}

	public function check_gdpr_review()
	{
		if ($this->user->data['user_mcp_accept_date'] == 0)
		{
			redirect($this->helper->route('sitesplat_bbgdpr_mcp'));
		}
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/bbgdpr',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function template_vars()
	{
		$this->template->assign_vars(array(
			'U_GDPR'					=> $this->helper->route('sitesplat_bbgdpr_privacy'),
			'GDPR_JS'					=> $this->tracking_codes_allowed() ? $this->config_text->get('sitesplat_bbgdpr_js') : false,
			'S_COOKIE_NOTICE'			=> false, // Disable phpBB Cookie Notice
			'S_DISPLAY_COOKIE_BANNER'	=> $this->display_cookie_notice(),
			'U_COOKIE_REJECT'			=> $this->helper->route('sitesplat_bbgdpr_cookie', ['mode' => 'reject']),
			'U_COOKIE_ACCEPT'			=> $this->helper->route('sitesplat_bbgdpr_cookie', ['mode' => 'accept']),
		));
	}

	public function load_modified_agreement($event)
	{
		$event->update_subarray('template_vars', 'L_TERMS_OF_USE', $this->language->lang('TERMS_OF_USE_CONTENT', $this->config['sitename'], generate_board_url()) . '<hr>' . htmlspecialchars_decode($this->config_text->get('sitesplat_bbgdpr_privacy_policy')));
	}

	public function load_reg_lang()
	{
		$this->language->add_lang('registration', 'sitesplat/bbgdpr');
	}

	public function assign_reg_data($event)
	{
		$data = $event['data'];
		$data['sitesplat_bbgdpr_bulk_emails'] = $this->request->variable('sitesplat_bbgdpr_bulk_emails', false);
		$data['sitesplat_bbgdpr_privacy_policy'] = $this->request->variable('sitesplat_bbgdpr_privacy_policy', false);
		$event['data'] = $data;
	}

	public function check_reg_data($event)
	{
		if (!$event['data']['sitesplat_bbgdpr_bulk_emails'] || !$event['data']['sitesplat_bbgdpr_privacy_policy'])
		{
			$error = $event['error'];
			$error[] = $this->language->lang('AGREEMENTS_REQUIRED');
			$event['error'] = $error;
		}
	}

	public function add_acceptance_date($event)
	{
		$event->update_subarray('user_row', 'user_privacy_accept_date', $event['user_row']['user_regdate']);
	}

	public function template_reg_data($event)
	{
		$template_vars = $event['template_vars'];
		$template_vars['S_SITESPLAT_BBGDPR_BULK_EMAILS'] = $event['data']['sitesplat_bbgdpr_bulk_emails'];
		$template_vars['S_SITESPLAT_BBGDPR_PRIVACY_POLICY'] = $event['data']['sitesplat_bbgdpr_privacy_policy'];
		$event['template_vars'] = $template_vars;
	}

	public function privacy_redirect()
	{
		if ($this->user->data['user_privacy_accept_date'] == 0)
		{
			redirect($this->helper->route('sitesplat_bbgdpr_privacy'));
		}
	}

	protected function display_cookie_notice()
	{
		if ($this->user->data['user_id'] != ANONYMOUS)
		{
			if ($this->user->data['user_cookie_accept'] == ext::COOKIE_NOT_YET)
			{
				return true;
			}
		}
		else
		{
			if (!$this->request->is_set($this->config['cookie_name'] . '_sitesplat_bbgdpr_cookie', \phpbb\request\request_interface::COOKIE))
			{
				return true;
			}
		}

		return false;
	}

	protected function tracking_codes_allowed()
	{
		if ($this->user->data['user_id'] != ANONYMOUS)
		{
			if ($this->user->data['user_cookie_accept'] == ext::COOKIE_ACCEPTED)
			{
				return true;
			}
		}
		else
		{
			if ($this->request->variable($this->config['cookie_name'] . '_sitesplat_bbgdpr_cookie', ext::COOKIE_NOT_YET, false, \phpbb\request\request_interface::COOKIE) == ext::COOKIE_ACCEPTED)
			{
				return true;
			}
		}

		return false;
	}
}
