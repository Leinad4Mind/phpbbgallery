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
	protected $db;
	protected $config;
	protected $manager;
	protected $controller_helper;
	protected $template;
	protected $user;
	protected $donation_table;

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, \sitesplat\donations\controller\manager $manager, \phpbb\controller\helper $controller_helper, \phpbb\template\template $template, \phpbb\user $user, $donation_table)
	{
		$this->db					= $db;
		$this->config				= $config;
		$this->manager				= $manager;
		$this->controller_helper	= $controller_helper;
		$this->template				= $template;
		$this->user					= $user;
		$this->donation_table		= $donation_table;
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
			'core.user_setup'			=> 'add_page_header_link',
			'core.delete_user_after'	=> 'delete_users',
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
		$this->user->add_lang_ext('sitesplat/donations', 'common');
		$this->template->assign_vars(array(
			'U_DONATE_PAGE'		=> $this->controller_helper->route('sitesplat_donations_controller', array('route' => 'index.html')),
			'DONATE_CURRENCY'	=> $this->manager->currency(0, $this->config['donations_currency'])
		));

	}

	public function delete_users($event)
	{
		if (!empty($event['user_ids'])) {
			$user_id_in = is_array($event['user_ids']) ? 'IN (' . implode(',', $event['user_ids']) . ')' : "= {$event['user_ids']}";

			$this->db->sql_query("DELETE FROM {$this->donation_table} WHERE user_id $user_id_in	AND payment_status = 'Not verified'");
			$this->db->sql_query("UPDATE {$this->donation_table} SET user_id = 0 WHERE user_id $user_id_in");
		}
	}
}
