<?php

/**
 * Debrider extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\debrider\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\language\language */
	protected $lang;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpEx */
	protected $php_ext;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\db\driver\driver_interface $db */
	protected $db;

	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth            $auth            Authentication object
	 * @param \phpbb\controller\helper    $helper          Controller helper object
	 * @param \phpbb\language\language    $lang            Language object
	 * @param \phpbb\template\template    $template        Template object
	 * @param \phpbb\user                 $user            User object
	 * @param string                      $php_ext         phpEx
	 * @access public
	 */
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\controller\helper $helper,
		\phpbb\language\language $lang,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\config\config $config,
		\phpbb\request\request $request,
		\phpbb\db\driver\driver_interface $db,
		$php_ext
	) {
		$this->auth = $auth;
		$this->helper = $helper;
		$this->lang = $lang;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->request = $request;
		$this->db = $db;
		$this->php_ext = $php_ext;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.permissions' => 'add_permission',
			'core.posting_modify_default_variables' => 'posting_modify_default_variables',
			'core.acp_manage_forums_display_form' => 'acp_manage_forums_display_form',
			'core.acp_manage_forums_update_data_before' => 'acp_manage_forums_update_data_before',
			'core.posting_modify_post_data' => 'posting_modify_post_data',
			'core.text_formatter_s9e_render_before' => 'text_formatter_s9e_render_before',
			'core.text_formatter_s9e_configure_after' => 'text_formatter_s9e_configure_after',
			'core.viewtopic_post_row_after' => 'viewtopic_post_row_after',
			'core.posting_modify_submit_post_after' => 'posting_modify_submit_post_after',
		];
	}

	/**
	 * Post save
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return void
	 * @access public
	 */
	public function posting_modify_submit_post_after($event)
	{
		$enable_debrider = $this->request->variable('enable_debrider', -1);

		// Caso não venha valor explícito (null) — buscar o valor atual da BD para preservar
		if ($enable_debrider === -1 && isset($event['topic_id'])) {
			error_log('enable_debrider ENTROU: ' . var_export($enable_debrider, true));
			$sql = 'SELECT debrider_enabled FROM ' . TOPICS_TABLE . ' WHERE topic_id = ' . (int) $event['topic_id'];
			$result = $this->db->sql_query($sql);
			$enable_debrider = (int) $this->db->sql_fetchfield('debrider_enabled');
			$this->db->sql_freeresult($result);
		}

		$data = [
			'debrider_enabled' => $enable_debrider,
		];

		$sql = 'UPDATE ' . TOPICS_TABLE . '
		  SET ' . $this->db->sql_build_array('UPDATE', $data) . '
		  WHERE topic_id = ' . (int) $event['topic_id'];
		$this->db->sql_query($sql);
	}

	/**
	 * Adds viewtopic template vars
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return void
	 * @access public
	 */
	public function viewtopic_post_row_after($event)
	{
		if ($this->config['debrider_enabled'] && $this->auth->acl_get('u_debrider_can_generate_url')) {
			$this->lang->add_lang('debrider_common', 'leinad4mind/debrider');

			$this->template->assign_vars([
				'CAN_GENERATE_DEBRID' => $event['topic_data']['can_debrider_enabled'] != 0 &&
					$event['topic_data']['debrider_enabled'] != 0,
			]);
		}
	}

	/**
	 * Add administrative permissions to manage Pages
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return void
	 * @access public
	 */
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['m_debrider_can_enable'] = ['lang' => 'ACL_M_DEBRIDERCANENABLE', 'cat' => 'post'];
		$permissions['u_debrider_can_generate_url'] = ['lang' => 'ACL_U_DEBRIDERCANGENERATEURL', 'cat' => 'post'];
		$event['permissions'] = $permissions;
	}

	/**
	 * Adds lang
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return void
	 * @access public
	 */
	public function posting_modify_default_variables($event)
	{
		if ($this->config['debrider_enabled']) {
			$this->lang->add_lang('debrider_common', 'leinad4mind/debrider');

			$debrider_enabled = true;
			if (isset($event['post_data']['topic_id'])) {
				$sql = 'SELECT debrider_enabled FROM ' . TOPICS_TABLE . '
					WHERE topic_id = ' . (int) $event['post_data']['topic_id'];
				$this->db->sql_query($sql);
				$debrider_enabled = (int) $this->db->sql_fetchfield('debrider_enabled');
			}

			$sql = 'SELECT can_debrider_enabled FROM ' . FORUMS_TABLE . '
        WHERE forum_id = ' . (int) $event['post_data']['forum_id'];
			$this->db->sql_query($sql);
			$can_debrider_enabled = (int) $this->db->sql_fetchfield('can_debrider_enabled');

			$this->template->assign_vars([
				'CAN_GENERATE_DEBRID' => $this->auth->acl_get('u_debrider_can_generate_url') &&
					$can_debrider_enabled != 0 && ($this->request->variable(
						'enable_debrider',
						($this->mode == 'post' || ($this->mode == 'edit' &&
							$event['post_data']['topic_first_post_id'] == $this->request->variable('p', 0) &&
							$debrider_enabled == 1)) ? 1 : 0
					)
					),
				'CAN_ENABLE_DEBRID' =>
				$can_debrider_enabled != 0 &&
					$this->auth->acl_get('m_debrider_can_enable') &&
					($this->mode == 'post' || ($this->mode == 'edit' &&
						$event['post_data']['topic_first_post_id'] == $this->request->variable('p', 0))),
				'CHECKED_ENABLE_DEBRID' => ($this->mode == 'post' && $can_debrider_enabled == 2) ||
					$this->request->variable('enable_debrider', 0) != 0 || ($this->mode == 'edit' &&
						$debrider_enabled == 1),
			]);
		}
	}

	/**
	 * More posting form settings
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return void
	 * @access public
	 */
	public function posting_modify_post_data($event)
	{
		$this->mode = $event['mode'];
	}

	/**
	 * ACP forum settings
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return void
	 * @access public
	 */
	public function acp_manage_forums_display_form($event)
	{
		$this->template->assign_var('CAN_ENABLE_DEBRID', $event['row']['can_debrider_enabled']);
	}

	/**
	 * ACP forum settings save
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return void
	 * @access public
	 */
	public function acp_manage_forums_update_data_before($event)
	{
		$data = [
			'can_debrider_enabled'      => $this->request->variable('can_enable_debrid', 1),
		];

		$sql = 'UPDATE ' . FORUMS_TABLE . '
      SET ' . $this->db->sql_build_array('UPDATE', $data) . '
      WHERE forum_id = ' . (int) $event['forum_data']['forum_id'];
		$this->db->sql_query($sql);
	}

	/**
	 * BBcode config
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return void
	 * @access public
	 */
	public function text_formatter_s9e_render_before($event)
	{
		$this->lang->add_lang('debrider_common', 'leinad4mind/debrider');
		$event['renderer']->get_renderer()->setParameter('L_DEBRIDER_GENERATE', $this->lang->lang('DEBRIDER_GENERATE'));
	}

	/**
	 * BBcode config
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return void
	 * @access public
	 */
	public function text_formatter_s9e_configure_after($event)
	{
		$this->lang->add_lang('debrider_common', 'leinad4mind/debrider');
		$event['configurator']->tags['code']->template = '<div class="codebox"><p><xsl:value-of select="$L_CODE"/><xsl:value-of select="$L_COLON"/><xsl:text> </xsl:text><a href="#" onclick="selectCode(this); return false;"><xsl:value-of select="$L_SELECT_ALL_CODE"/></a>  <a href="#" class="button btn btn-default" style="float: right; display: none;" onclick="debrider_url(this); return false;"><span><xsl:value-of select="$L_DEBRIDER_GENERATE"/></span></a> </p><pre><code><xsl:apply-templates/></code></pre></div>';
	}
}
