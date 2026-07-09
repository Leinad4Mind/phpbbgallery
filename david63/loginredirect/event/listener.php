<?php
/**
*
* @package User Login Redirect
* @copyright (c) 2014 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\loginredirect\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use david63\loginredirect\core\functions;
use david63\loginredirect\controller\main_controller;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \david63\loginredirect\core\functions */
	protected $functions;

	/** @var \david63\loginredirect\controller\main_controller */
	protected $indexoutput;

	/**
	* Constructor for listener
	*
	* @param \david63\loginredirect\core\functions				functions			Functions for the extension
	* @param \david63\loginredirect\controller\main_controller	$main_controller	Main controller
	*
	* @access public
	*/
	public function __construct(functions $functions, main_controller $main_controller)
	{
		$this->functions		= $functions;
		$this->main_controller	= $main_controller;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'			=> 'load_language_on_setup',
			'core.login_box_redirect'	=> array(
				'login_redirect',
				5, // Needed to allow Profile redirect extension to run first.
			),
		);
	}

	/**
	* Load common login redirect language files during user setup
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function load_language_on_setup($event)
	{
		$lang_set_ext	= $event['lang_set_ext'];
		$lang_set_ext[]	= array(
			'ext_name' => $this->functions->get_ext_namespace(),
			'lang_set' => 'loginredirect_common',
		);

		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	* Redirect the user after successful login
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function login_redirect($event)
	{
		$this->main_controller->loginredirect($event);
	}
}
