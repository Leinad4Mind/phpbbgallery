<?php
/**
*
* Subject readonly Extension for the phpBB Forum Software package.
* @copyright (c) 2020 - 2025 Kirk https://kirk-phpbb.com
* @license GNU General Public License, version 2 (GPL-2.0-only)
*
*/

namespace kirk\subjectreadonly\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $auth;
	protected $template;

	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\template\template $template,
	)
	{
		$this->auth			= $auth;
		$this->template 	= $template;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.viewtopic_add_quickmod_option_before'		=> 'add_readonly',
			'core.posting_modify_template_vars'				=> 'add_readonly'
		];
	}

	public function add_readonly()
	{
		$readonly = !$this->auth->acl_gets('m_', 'a_');
			$this->template->assign_vars([
				'S_READONLY'	=> $readonly
			]);
	}
}
