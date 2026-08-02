<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\loginredirect\event;

use david63\loginredirect\controller\main_controller;
use david63\loginredirect\core\functions;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $functions;
	protected $main_controller;

	public function __construct(functions $functions, main_controller $main_controller)
	{
		$this->functions = $functions;
		$this->main_controller = $main_controller;
	}

	public static function getSubscribedEvents()
	{
		return array(
			'core.user_setup' => 'load_language_on_setup',
			'core.login_box_redirect' => array('login_redirect', 5),
		);
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => $this->functions->get_ext_namespace(),
			'lang_set' => 'loginredirect_common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function login_redirect($event)
	{
		$this->main_controller->login_redirect($event);
	}
}
