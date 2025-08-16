<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2018, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation\event;

use leinad4mind\invitation\ext;
use leinad4mind\invitation\includes\config as ext_config;
use leinad4mind\invitation\includes\functions;
use phpbb\config\config as phpbb_config;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var user */
	protected $user;

	/** @var language */
	protected $language;

	/** @var request_interface */
	protected $request;

	/** @var template */
	protected $template;

	/** @var phpbb_config */
	protected $config;

	/** @var ext_config */
	protected $ext_config;

	/** @var functions */
	protected $functions;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $adm_relative_path;

	/** @var string */
	protected $php_ext;

	/** @var array */
	protected $meghivo_user;

	/**
	 * listener constructor.
	 *
	 * @param \phpbb\user                                $user
	 * @param \phpbb\language\language                   $language
	 * @param \phpbb\request\request_interface           $request
	 * @param \phpbb\template\template                   $template
	 * @param \phpbb\config\config                       $config
	 * @param \leinad4mind\invitation\includes\config    $ext_config
	 * @param \leinad4mind\invitation\includes\functions $functions
	 * @param string                                     $root_path
	 * @param string                                     $adm_relative_path
	 * @param string                                     $php_ext
	 */
	public function __construct(user $user, language $language, request_interface $request, template $template, phpbb_config $config, ext_config $ext_config, functions $functions, $root_path, $adm_relative_path, $php_ext)
	{
		$this->user = $user;
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
		$this->config = $config;
		$this->ext_config = $ext_config;
		$this->functions = $functions;
		$this->root_path = $root_path;
		$this->adm_relative_path = $adm_relative_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'									=> 'user_setup',
			'core.page_header_after'							=> 'page_header_after',
			'core.update_username'								=> 'update_username',
			'core.user_add_modify_data'							=> 'user_add_modify_data',
			'core.delete_user_before'							=> 'delete_user_before',
			'core.user_set_default_group'						=> 'user_set_default_group',
			'core.permissions'									=> 'permissions',
			'core.acp_board_config_edit_add'					=> 'acp_board_config_edit_add',
			'core.ucp_register_requests_after'					=> 'ucp_register_requests_after',
			'core.user_add_after'								=> 'user_add_after',
			'core.ucp_register_agreement_modify_template_data'	=> 'ucp_register_agreement_modify_template_data',
			'core.ucp_register_modify_template_data'			=> 'ucp_register_modify_template_data',
			'core.memberlist_modify_sql_query_data'				=> 'memberlist_modify_sql_query_data',
			'core.memberlist_view_profile'						=> 'memberlist_view_profile',
		);
	}

	/**
	 * @param data $event
	 */
	public function user_setup(data $event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'leinad4mind/invitation',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 *
	 */
	public function page_header_after()
	{
		$this->functions->ini();
	}

	/**
	 * @param data $event
	 */
	public function update_username(data $event)
	{
		$this->functions->update_username($event['old_name'], $event['new_name']);
	}

	/**
	 * @param data $event
	 */
	public function user_add_modify_data(data $event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], $this->functions->invite_add_rows());
	}

	/**
	 * @param data $event
	 */
	public function delete_user_before(data $event)
	{
		foreach ($event['user_ids'] as $user_id)
		{
			$this->functions->delete_user($user_id);
		}
	}

	/**
	 * @param data $event
	 */
	public function user_set_default_group(data $event)
	{
		$sql_ary = $event['sql_ary'];

		if (isset($sql_ary['user_colour']))
		{
			$this->functions->update_default_group($event['user_id_ary'], $sql_ary['user_colour']);
		}
	}

	/**
	 * @param data $event
	 */
	public function permissions(data $event)
	{
		$permissions = $event['permissions'];

		$ext_permissions = array(
			'u_meghivo_kuld',
			'u_meghivo_keres',
			'u_meghivo_delet',
			'u_meghivo_max',
			'u_meghivo_users',
			'm_meghivo_igeny',
			'a_meghivo',
			'a_meghivo_config',
			'a_meghivo_kuldes',
			'a_meghivo_delete',
			'a_meghivo_igeny',
			'a_meghivo_users',
			'a_meghivo_pend',
		);

		foreach ($ext_permissions as $permission)
		{
			$permissions[$permission] = array(
				'lang'	=> 'ACL_' . strtoupper($permission),
				'cat'	=> 'meghivo',
			);
		}

		$event['permissions'] = $permissions;

		$event['categories'] = array_merge($event['categories'], array(
			'meghivo' => 'MEGHIVO',
		));
	}

	/**
	 * @param data $event
	 */
	public function acp_board_config_edit_add(data $event)
	{
		if ($event['mode'] === 'registration')
		{
			if ($event['submit'] && !$this->config['email_enable'] && $this->config['require_ac_invite'] != ext::ACC_INVITE_DISABLE && $this->ext_config['meghivo_enable'])
			{
				trigger_error($this->language->lang('ACP_MEGHIVO_EMAIL_BOARD_DISABLED', '<a href="' . append_sid($this->root_path . $this->adm_relative_path . 'index.' . $this->php_ext, "i=board&amp;mode=email") . '">', '</a>'));
			}

			$display_vars = $event['display_vars'];
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $this->functions->select_acc_invite($this->config['require_ac_invite']), array('after' => 'require_activation'));
			$event['display_vars'] = $display_vars;
		}
	}

	/**
	 *
	 */
	public function ucp_register_requests_after()
	{
		$this->language->add_lang('meghivo', 'leinad4mind/invitation');

		$this->meghivo_user = $this->functions->verify();

		if (!$this->meghivo_user && $this->config['require_activation'] == USER_ACTIVATION_DISABLE)
		{
			trigger_error('UCP_REGISTER_DISABLE');
		}

		$email_address			= $this->meghivo_user ? $this->meghivo_user['mmail'] : '';
		$email_address_change	= !$this->meghivo_user || $this->ext_config['email_address_change'];
		$e_mail					= $email_address_change ? $this->request->variable('email', $email_address) : $email_address;

		$this->request->overwrite('email', $e_mail);
	}

	/**
	 * @param data $event
	 */
	public function user_add_after(data $event)
	{
		$this->functions->delet($event['user_id'], $event['user_row']);
		$this->functions->default_group($event['user_id'], $event['user_row']['user_new']);
	}

	/**
	 * @param data $event
	 */
	public function ucp_register_agreement_modify_template_data($event)
	{
		if ($this->meghivo_user)
		{
			$event['s_hidden_fields'] = array_merge($event['s_hidden_fields'], $this->meghivo_user);

			$coppa = $this->request->is_set('coppa') ? $this->request->variable('coppa', false) : false;
			if (!$coppa && $this->config['coppa_enable'])
			{
				$invite_params = '&amp;muid=' . $this->meghivo_user['muid'] . '&amp;mkey=' . $this->meghivo_user['mkey'];

				$event['template_vars'] = array_merge($event['template_vars'], array(
					'U_COPPA_NO'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'mode=register&amp;coppa=0' . $invite_params),
					'U_COPPA_YES'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'mode=register&amp;coppa=1' . $invite_params),
				));
			}
		}
	}

	/**
	 * @param data $event
	 */
	public function ucp_register_modify_template_data(data $event)
	{
		if ($this->meghivo_user)
		{
			$event['s_hidden_fields'] = array_merge($event['s_hidden_fields'], $this->meghivo_user);
		}
	}

	/**
	 * @param data $event
	 */
	public function memberlist_modify_sql_query_data(data $event)
	{
		if ($this->request->variable('meghivo', '') === 'users_list')
		{
			$this->language->add_lang('info_ucp_meghivo', 'leinad4mind/invitation');

			$this->functions->members_list('member', $this->request->variable('u', 0));

			page_header($this->language->lang('UCP_MEGHIVO_USER'));

			$this->template->set_filenames(array(
				'body' => '@leinad4mind_invitation/memberlist_meghivo.html',
			));

			make_jumpbox(append_sid("{$this->root_path}viewforum.$this->php_ext"));

			page_footer();
		}
	}

	/**
	 * @param data $event
	 */
	public function memberlist_view_profile(data $event)
	{
		$this->functions->ac_user($event['member']['user_id'], $event['member']['user_meghivo_member']);
	}
}
