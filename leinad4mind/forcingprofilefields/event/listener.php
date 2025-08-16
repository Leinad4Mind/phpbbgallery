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
use phpbb\language\language;
use phpbb\profilefields\manager;
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

	/** @var manager */
	protected $manager;

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
	 * @param manager				$manager
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
		manager $manager,
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
		$this->manager			= $manager;
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

			if (!$this->ignore_request() && $this->get_profilefield_errors())
			{
				$ucp_url = append_sid($this->root_path . 'ucp.' . $this->php_ext, ['i' => 'profile', 'mode' => 'profile_info', 'forceprofileupdate' => 1]);

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
		if ($this->request->is_set('forceprofileupdate') && $errors = $this->get_profilefield_errors())
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
			!$this->user->data['is_registered'] ||
			!$this->auth->acl_get('u_chgprofileinfo') ||
			$this->user->data['is_bot'] ||
			$this->request->is_ajax() ||
			$page == 'adm/index.' . $this->php_ext ||
			($page == 'ucp.' . $this->php_ext && in_array($this->request->variable('mode', ''), ['login', 'logout', 'profile_info']))
		;
	}

	/**
	 * @return array
	 */
	protected function get_profilefield_errors()
	{
		$errors = [];

		$profile_field_rows = $this->manager->grab_profile_fields_data($this->user->data['user_id']);

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
					}
				}
			}
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
}
