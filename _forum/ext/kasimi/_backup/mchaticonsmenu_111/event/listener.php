<?php

/**
 *
 * @package phpBB Extension - mChat Icons Menu
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\mchaticonsmenu\event;

use dmzx\mchat\core\settings;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\Event;

class listener extends base
{
	/** @var template */
	protected $template;

	/**
	 * Constructor
	 *
	 * @param user		$user
	 * @param template	$template
	 * @param settings	$settings
	 */
	public function __construct(
		user $user,
		template $template,
		settings $settings = null
	)
	{
		parent::__construct($user, $settings);
		$this->template = $template;
	}

	/**
	 * @return array
	 */
	protected function get_listener_config()
	{
		return array(
			'lang' => array(
				'acp' => array('kasimi/mchaticonsmenu', array('mchaticonsmenu_ucp')),
				'ucp' => array('kasimi/mchaticonsmenu', array('mchaticonsmenu_ucp')),
			),
			'settings' => array(
				'ucp' => array(
					'mchat_iconsmenu_always' => array('default' => 1),
				),
			),
		);
	}

	/**
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return array_merge(parent::getSubscribedEvents(), array(
			'dmzx.mchat.global_modify_template_data' => 'assign_template_data',
		));
	}

	/**
	 * @param Event $event
	 */
	public function assign_template_data($event)
	{
		$this->template->assign_var('MCHAT_ICONSMENU_ALWAYS', $this->settings->cfg('mchat_iconsmenu_always'));
	}

}
