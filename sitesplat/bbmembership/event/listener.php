<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\db\driver\driver_interface;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\config\config;
use phpbb\controller\helper;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	protected $db;
	protected $request;
	protected $template;
	protected $user;
	protected $config;
	protected $controller_helper;
	protected $bbmembership_table;

	/**
	 * Constructor
	 */
	public function __construct(driver_interface $db, request $request, template $template, user $user, config $config, helper $controller_helper, $bbmembership_table, $bbmembership_helper)
	{
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->controller_helper	= $controller_helper;
		$this->bbmembership_table = $bbmembership_table;
		$this->bbmembership_groups = json_decode($this->config['bbmembership_groups'], true);
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
			'core.page_header_after'		=> 'page_header_after',
			'core.user_setup'				=> 'user_setup',
		);
	}

	/**
	 * Set navigation link
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function page_header_after($event)
	{
		$this->template->assign_vars(array(
			'U_MEMBERSHIPS'	=> $this->controller_helper->route('sitesplat_bbmembership_main_controller', array('route' => 'index.html')),
		));
	}

	/**
	 * Check if user has a valid membership
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function user_setup($event)
	{
		$check_ary = array(
			$this->user->page['page_name'] == 'ucp.php' && $this->request->variable('mode', '') == 'login',
			$this->user->page['page_name'] == 'ucp.php' && $this->request->variable('mode', '') == 'logout',
			$this->user->page['page_name'] == 'ucp.php' && $this->request->variable('mode', '') == 'register',
			$this->user->page['page_name'] == 'app.php/memberships/index.html'
		);
		
		if ($this->config['bbmembership_clubmode'] && $event['user_data']['user_type'] != USER_FOUNDER && !array_sum($check_ary))
		{
			$membership = false;
			$sql = 'SELECT mc_gross, mc_currency, payment_date FROM ' . $this->bbmembership_table . ' 
					WHERE user_id = ' . $this->user->data['user_id'] . ' AND payment_status = "Completed" ORDER BY payment_date DESC';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$mc_gross = ($row['mc_currency'] >= 'BBPOINTS') ? $row['mc_gross'] / 100 : $row['mc_gross'];
				$membership = (($this->bbmembership_groups[(int) $mc_gross]['expire'] * 86400) + $row['payment_date'] > time()) ? true: false;
				if ($membership) break;
			}

			if(!$membership)
			{
				redirect($this->controller_helper->route('sitesplat_bbmembership_main_controller', array('route' => 'index.html')));
			}
		}

		$this->user->add_lang_ext('sitesplat/bbmembership', 'bbmembership_common');
	}
}
