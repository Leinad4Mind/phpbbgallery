<?php
/**
*
* @package BBdonations
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\donations\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	protected $config;
	protected $manager;
	protected $controller_helper;
	protected $template;
	protected $user;

	public function __construct(\phpbb\config\config $config, \sitesplat\donations\controller\manager $manager, \phpbb\controller\helper $controller_helper, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->config				= $config;
		$this->manager				= $manager;
		$this->controller_helper	= $controller_helper;
		$this->template				= $template;
		$this->user					= $user;
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
			'core.user_setup' => 'add_page_header_link',
		);
	}

	/**
	 * Add page header link during user setup
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function add_page_header_link($event)
	{
		//$this->user->add_lang_ext('sitesplat/donations', 'common');
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/donations',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
		
		$this->template->assign_vars(array(
			'U_DONATE_PAGE'		=> $this->controller_helper->route('sitesplat_donations_controller', array('route' => 'index.html')),
			'DONATE_CURRENCY'	=> $this->manager->currency(0, $this->config['donations_currency'])
		));

	}
}
