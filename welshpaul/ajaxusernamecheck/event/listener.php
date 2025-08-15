<?php

/**
 * AJAX Username Check
 * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
 * @license Proprietary
 */

namespace welshpaul\ajaxusernamecheck\event;

use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var config $config Configuration object */
	protected $config;

	/** @var helper $helper Controller helper object */
	protected $helper;

	/** @var template $template Template object */
	protected $template;

	/** @var user $user User object */
	protected $user;

	/**
	 * Listener constructor
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @param config   $config   Configuration object
	 * @param helper   $helper   Controller helper object
	 * @param template $template Template object
	 * @param user     $user     User object
	 */
	public function __construct(config $config, helper $helper, template $template, user $user)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
	}

	/**
	 * Function that returns the subscribed events
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return array Array with the subscribed events
	 */
	static public function getSubscribedEvents()
	{
		return ['core.ucp_register_data_before' => 'assign_register_data',];
	}

	/**
	 * Function to assign all needed data to the registration form
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function assign_register_data()
	{
		// Load language data
		$this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']);
		$username_rule = $this->config['allow_name_chars'];
		switch ($username_rule) {
			case 'USERNAME_CHARS_ANY':
				$username_rule = "^.+$";
				break;
			case 'USERNAME_ALPHA_ONLY':
				$username_rule = "^[a-zA-Z0-9]+$";
				break;
			case 'USERNAME_ALPHA_SPACERS':
				$username_rule = "^[a-zA-Z0-9 \\-\\+_\\[\\\]]+$";
				break;
			case 'USERNAME_LETTER_NUM':
				$username_rule = "^[a-zA-Z0-9äöüÄÖÜ]+$";
				break;
			case 'USERNAME_LETTER_NUM_SPACERS':
				$username_rule = "^[a-zA-Z0-9äöüÄÖÜ \\-\\+_\\[\\\]]+$";
				break;
			case 'USERNAME_ASCII':
				$username_rule = "^[a-zA-Z0-9 !\\\"#\\$%&'\\(\\)\\*\\+,\\-\\.\\/:;<=>\\?@\\[\\\]\\^_`\\{\\|\\}~]+$";
				break;
		}
		$this->template->assign_vars([
			'WELSHPAUL_AJAXUSERNAMECHECK' => true,
			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_MIN' => $this->config['min_name_chars'],
			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_MAX' => $this->config['max_name_chars'],
			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_RULE' => $username_rule,
			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_INVALID_BOUNDARIES' => $this->user->lang($this->config['allow_name_chars'] . '_EXPLAIN', $this->config['min_name_chars'], $this->config['max_name_chars']),
			'WELSHPAUL_AJAXUSERNAMECHECK_CHECK_USERNAME_LINK' => $this->helper->route('welshpaul_ajaxusernamecheck_controller', ['type' => 'username']),
		]);
	}
}
