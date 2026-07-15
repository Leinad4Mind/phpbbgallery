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
use phpbb\language\language;
use phpbb\template\template;

class listener extends base
{
	/** @var template */
	protected $template;

	/**
	 * @param language	$lang
	 * @param template	$template
	 * @param settings	$settings
	 */
	public function __construct(
		language $lang,
		template $template,
		settings $settings = null
	)
	{
		parent::__construct($lang, $settings);
		$this->template = $template;
	}

	/**
	 * @return array
	 */
	protected function get_listener_config()
	{
		return [
			'lang' => [
				'acp' => ['mchaticonsmenu_ucp', 'kasimi/mchaticonsmenu'],
				'ucp' => ['mchaticonsmenu_ucp', 'kasimi/mchaticonsmenu'],
			],
			'settings' => [
				'ucp' => [
					'mchat_iconsmenu_always' => ['default' => 1],
				],
			],
		];
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return array_merge(parent::getSubscribedEvents(), [
			'dmzx.mchat.global_modify_template_data' => 'assign_template_data',
		]);
	}

	/**
	 *
	 */
	public function assign_template_data()
	{
		$this->template->assign_var('MCHAT_ICONSMENU_ALWAYS', $this->settings->cfg('mchat_iconsmenu_always'));
	}

}
