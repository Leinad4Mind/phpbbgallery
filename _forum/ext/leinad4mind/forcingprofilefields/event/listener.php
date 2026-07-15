<?php

/**
 *
 * Forcing Profile Fields. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, leinad4mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\forcingprofilefields\event;

use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\di\service_collection;
use phpbb\event\data;
use phpbb\extension\manager as ext_manager;
use phpbb\language\language;
use phpbb\profilefields\manager as pf_manager;
use phpbb\profilefields\type\type_base;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/* @var user */
	protected $user;

	/** @var language */
	protected $lang;

	/** @var auth */
	protected $auth;

	/* @var config */
	protected $config;

	/** @var request_interface */
	protected $request;

	/** @var template */
	protected $template;

	/** @var pf_manager */
	protected $pf_manager;

	/** @var ext_manager */
	protected $ext_manager;

	/** @var service_collection */
	protected $type_collection;

	/** @var string */
	protected $root_path;

	/* @var string */
	protected $php_ext;

	/* @var boolean */
	protected $is_first_user_setup = true;

	/**
	 * @param user					$user
	 * @param language				$lang
	 * @param auth					$auth
	 * @param config				$config
	 * @param request_interface		$request
	 * @param template				$template
	 * @param pf_manager			$pf_manager
	 * @param ext_manager			$ext_manager
	 * @param service_collection	$type_collection
	 * @param string				$root_path
	 * @param string				$php_ext
	 */
	public function __construct(
		user $user,
		language $lang,
		auth $auth,
		config $config,
		request_interface $request,
		template $template,
		pf_manager $pf_manager,
		ext_manager $ext_manager,
		service_collection $type_collection,
		$root_path,
		$php_ext
	)
	{
		$this->user				= $user;
		$this->lang				= $lang;
		$this->auth				= $auth;
		$this->config			= $config;
		$this->request			= $request;
		$this->template			= $template;
		$this->pf_manager		= $pf_manager;
		$this->ext_manager		= $ext_manager;
		$this->type_collection	= $type_collection;
		$this->root_path		= $root_path;
		$this->php_ext			= $php_ext;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup'					=> 'user_setup',
			'core.acp_board_config_edit_add'	=> 'acp_board_config_edit_add',
			'core.page_footer'					=> 'page_footer',
		];
	}

	/**
	 *
	 */
	public function user_setup()
	{
		if ($this->is_first_user_setup)
		{
			$this->is_first_user_setup = false;

			if (!$this->ignore_request() && $this->get_profilefield_errors(true))
			{
				$ucp_url = append_sid($this->root_path . 'ucp.' . $this->php_ext, ['i' => 'profile', 'mode' => 'profile_info', 'forcingprofilefields' => 1]);

				if ($this->config['forcingprofilefields_skip_metarefresh'])
				{
					redirect($ucp_url);
				}
				else
				{
					$this->lang->add_lang('ucp');
					$this->lang->add_lang('common', 'leinad4mind/forcingprofilefields');

					meta_refresh(5, $ucp_url);
					trigger_error($this->lang->lang('UCP_PROFILE_UPDATE') . '<br><br>' . $this->lang->lang('RETURN_UCP', '<a href="' . $ucp_url . '">', '</a>'), E_USER_WARNING);
				}
			}
		}
	}

	/**
	 *
	 */
	public function page_footer()
	{
		if ($this->request->is_set('forcingprofilefields') && $errors = $this->get_profilefield_errors(false))
		{
			if ($error = $this->template->retrieve_var('ERROR'))
			{
				array_unshift($errors, $error);
			}

			$this->template->assign_var('ERROR',  implode('<br>', $errors));
		}
	}

	/**
	 * @return bool
	 */
	protected function ignore_request()
	{
		$page = $this->user->page['page'];

		$query_string_len = utf8_strlen($this->user->page['query_string']);
		if ($query_string_len)
		{
			$page = utf8_substr($page, 0, -($query_string_len + 1));
		}

		return
			empty($this->user->data['is_registered']) ||
			!$this->auth->acl_get('u_chgprofileinfo') ||
			!empty($this->user->data['is_bot']) ||
			$this->request->is_ajax() ||
			$page == 'adm/index.' . $this->php_ext ||
			($page == 'ucp.' . $this->php_ext && in_array($this->request->variable('mode', ''), ['login', 'logout', 'profile_info']))
		;
	}

	/**
	 * @param bool $lazy
	 * @return array
	 */
	protected function get_profilefield_errors($lazy = false)
	{
		$errors = [];

		$profile_field_rows = $this->pf_manager->grab_profile_fields_data($this->user->data['user_id']);

		if (!empty($profile_field_rows)) {
			foreach ($profile_field_rows[$this->user->data['user_id']] as $row)
			{
				/** @var type_base $profile_field */
				$profile_field = $this->type_collection[$row['data']['field_type']];

				$is_default_value = $row['value'] === null && ($row['data']['field_default_value'] || $row['data']['lang_default_value']);

				if (!$is_default_value)
				{
					if ($error = $profile_field->validate_profile_field($row['value'], $row['data']))
					{
						$errors[] = $error;

						if ($lazy)
						{
							break;
						}
					}
				}
			}
		}

		// Compatibility with the National Flags extension by RMcGirr83
		if ((!$lazy || !$errors) && $this->ext_manager->is_enabled('rmcgirr83/nationalflags') && $this->config['flags_required'] && !$this->user->data['user_flag'])
		{
			$this->lang->add_lang('common', 'rmcgirr83/nationalflags');
			$errors[] = $this->lang->lang('MUST_CHOOSE_FLAG');
		}

		// Compatibility with the Genders extension by RMcGirr83
		if ((!$lazy || !$errors) && $this->ext_manager->is_enabled('rmcgirr83/genders') && $this->config['gender_required'] && !$this->user->data['user_gender'])
		{
			$this->lang->add_lang('genders', 'rmcgirr83/genders');
			$errors[] = $this->lang->lang('MUST_CHOOSE_GENDER');
		}
		
		// Compatibility with the Registration Age extension by david63 if and only if "registration_age_required" field is added to it and "REGISTRATION_AGE_REQUIRED" language variable added to the "ucp_registrationage" lang file.
		if ((!$lazy || !$errors) && $this->ext_manager->is_enabled('david63/registrationage') && $this->config['registration_age_required'] && !$this->is_valid_birthday($this->user->data['user_birthday']))
		{
			$this->lang->add_lang('ucp_registrationage', 'david63/registrationage');
			$errors[] = $this->lang->lang('REGISTRATION_AGE_REQUIRED');
		}

		// Compatibility with the Special Birthday extension by leinad4mind
		if ((!$lazy || !$errors) && $this->ext_manager->is_enabled('leinad4mind/specialbirthday') && $this->config['registration_age_required'] && !$this->is_valid_birthday($this->user->data['user_birthday']))
		{
			$this->lang->add_lang('ucp_specialbirthday', 'leinad4mind/specialbirthday');
			$errors[] = $this->lang->lang('REGISTRATION_AGE_REQUIRED');
		}

		return $errors;
	}

	/**
	 * @param data $event
	 */
	public function acp_board_config_edit_add(data $event)
	{
		if ($event['mode'] == 'features')
		{
			$config = [
				'forcingprofilefields_skip_metarefresh' => [
					'lang'		=> 'FORCINGPROFILEFIELDS_SKIP_METAREFRESH',
					'validate'	=> 'bool',
					'type'		=> 'radio:yes_no',
					'explain'	=> true,
				],
			];

			$display_vars = $event['display_vars'];
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $config, ['after' => 'display_last_subject']);
			$event['display_vars'] = $display_vars;
		}
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
