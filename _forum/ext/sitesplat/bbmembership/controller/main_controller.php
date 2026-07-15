<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership\controller;

use phpbb\db\driver\driver_interface;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\notification\manager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
* Main controller
*/
class main_controller
{
	protected $db;
	protected $request;
	protected $template;
	protected $user;
	protected $config;
	protected $helper;
	protected $notification_manager;
	protected $root_path;
	protected $php_ext;
	protected $bbmembership_table;
	protected $bbmembership_helper;
	
	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct(driver_interface $db, request $request, template $template, user $user, config $config, helper $helper, manager $notification_manager, $root_path, $php_ext, $bbmembership_table, $bbmembership_helper)
	{
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->notification_manager = $notification_manager;
		$this->helper = $helper;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->bbmembership_table = $bbmembership_table;
		$this->bbmembership_helper = $bbmembership_helper;
		$this->bbmembership_package = json_decode($this->config['bbmembership_package'], true);
		$this->notify = false;
	}

	/**
	* Display the page
	*
	* @param string $route The route name for a page
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	* @access public
	*/
	public function display()
	{
		$this->user->add_lang_ext('sitesplat/bbmembership', 'bbmembership');
		$this->notify = false;
		$action = $this->request->variable('action', '') . (($this->request->variable('submitbtn', '') == $this->user->lang['BBMEMBERSHIP_POINTS']) ? '_bbpoints': '');
		
		switch ($action)
		{
			case 'request':
				if ($this->user->data['user_id'] == ANONYMOUS)
				{
					login_box(append_sid($this->helper->route('sitesplat_bbmembership_main_controller', array('route' => 'index.html'))));
				}	
						
				$url = $this->helper->route('sitesplat_bbmembership_main_controller', array('route' => 'index.html'), true, '', UrlGeneratorInterface::ABSOLUTE_URL);
				$data = array(
					'item_name'		=> $this->user->lang('BBMEMBERSHIP') . ' - ' . $this->config['sitename'],
					'amount'		=> (intval($this->request->variable('amount', 0))) . '.00',
					'payer_email'	=> $this->user->data['user_email'],
					'mc_currency'	=> $this->config['bbmembership_currency'],
					'item_number'	=> time(),
				);
				$querystring = '?';
				foreach($data as $key => $value)
				{
					$querystring .= $key . '=' . urlencode($value) . '&'; 
				}
				
				$querystring .= 'business=' . urlencode($this->config['bbmembership_paypal_email']) . '&'; 
				$querystring .= 'currency_code=' . $this->config['bbmembership_currency'] . '&'; 
				$querystring .= 'cmd=_xclick&no_note=1&lc=UK&bn=PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest&rm=2&';
 
				// Append paypal return addresses 
				$querystring .= 'return=' . urlencode($url . '?action=verify') . '&'; 
				$querystring .= 'cancel_return=' . urlencode(stripslashes($url . '?action=cancel')) . '&'; 
				$querystring .= 'notify_url=' . urlencode($url . '?action=notify'); 

				$data['payment_status'] = 'Not verified';
				$data['user_id'] = $this->user->data['user_id'];
				$data['payment_date'] = time();
				$data['session_ip'] = $this->user->ip;
				$data['mc_gross'] = $data['amount'];
				$data['membership'] = $this->bbmembership_package[(int) $data['amount']]['id'];
				unset($data['amount']);
				$sql = 'INSERT INTO ' . $this->bbmembership_table . ' ' . $this->db->sql_build_array('INSERT', $data);
				$this->db->sql_query($sql);
				
				// Redirect to paypal IPN 
				header('location:https://www.' . (($this->config['bbmembership_sandbox']) ? 'sandbox.' : '') . 'paypal.com/cgi-bin/webscr' . $querystring); 
				exit(); 
			break;

			case 'notify':
				if ($this->request->is_set_post('item_number'))
				{
					$data = $this->bbmembership_helper->get_paypal_data();
					$data = ($this->bbmembership_helper->updatePayments($data));
				} else 
				{
					$this->notify = 'MEMBERSHIP_NO_AUTH';
				}
				$this->template->assign_vars(array('NOTIFY_STATUS' => ($this->notify) ? $this->notify : false));
			break;
	
			case 'verify':
				if ($this->request->is_set_post('item_number'))
				{
					$data = $this->bbmembership_helper->get_paypal_data();
					$data = ($this->bbmembership_helper->updatePayments($data));
					
					$this->notify = ($action == 'verify') ? ((isset($data['payment_status']) && $data['payment_status'] == 'Completed') ? 
						'MEMBERSHIP_SUCCESS' : 'MEMBERSHIP_FAILED_PP') : false;
				} else 
				{
					$this->notify = 'MEMBERSHIP_NO_AUTH';
				}
				$this->template->assign_vars(array('NOTIFY_STATUS' => ($this->notify) ? $this->notify : false));
			break;
		
			case 'cancel':
				$this->notify = 'MEMBERSHIP_CANCELED';
				$this->template->assign_vars(array('NOTIFY_STATUS' => ($this->notify) ? $this->notify : false));
			break;
				
			case 'request_bbpoints':
				($this->bbmembership_helper->bbpoints_enabled()) ? $this->notify = $this->bbmembership_helper->pay_with_points($this->request->variable('amount', 0)) : null;
			break;
		}
			
		if (!empty($this->config['bbmembership_groups'])) 
		{
			$group_amount = json_decode($this->config['bbmembership_groups'], true);

			$membership = $days_to_expiration = $payment_date = false;
			$mc_gross = 0;
			$sql = 'SELECT membership, mc_gross, mc_currency, payment_status, payment_date FROM ' . $this->bbmembership_table . ' 
					WHERE user_id = ' . $this->user->data['user_id'] . ' AND payment_status = "Completed" ORDER BY payment_date ASC';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$mc_gross = $this->bbmembership_helper->find_membership($this->bbmembership_package, 'id', (int) $row['membership']);
				$membership[$mc_gross] = (isset($group_amount[$mc_gross]) && 
							  (($group_amount[$mc_gross]['expire'] == -1) ? 300 : ($group_amount[$mc_gross]['expire'] * 86400)) + $row['payment_date'] > time() ||
							  $group_amount[$mc_gross]['expire'] == 0) ? true: false;
				$days_to_expiration = (isset($group_amount[$mc_gross])) ? round(((($group_amount[$mc_gross]['expire'] == -1) ? 300 : 
									  ($group_amount[$mc_gross]['expire'] * 86400)) + $row['payment_date'] - time()) / (($group_amount[$mc_gross]['expire'] == -1) ? 1 : 86400), 0) : 0;			
				$payment_date = $row['payment_date'];
			}

			$count = $package = 0;
			foreach ($group_amount as $key => $value)
			{
				$this->template->assign_block_vars('levels', array(
					'LEVEL'					=> ++$count,
					'DONATIONS_AMOUNT'		=> $key,
					'DONATIONS_EXPIRE'		=> ($group_amount[$key]['expire'] == 0) ? $this->user->lang('MEMBERSHIP_UNLIMITED') : (($group_amount[$key]['expire'] == -1) ? '5 min' : 
												$this->user->lang('DAYS_TO_EXPIRATION', $group_amount[$key]['expire'])),
					'DONATIONS_DEFAULT'		=> $group_amount[$key]['default'],
					'PACKAGE'				=> (isset($membership[$key])) ? true : false,
					'DONATIONS_HIDE'		=> $group_amount[$key]['hide'],
					'DONATIONS_POINTS'		=> $key * 100
				));
				$package = ($mc_gross == $key) ? $count : $package;

				foreach($this->bbmembership_package as $key => $value)
				{
					if (!$group_amount[$key]['hide'])
					{
						$this->template->assign_block_vars('levels.packages', array(
							'PACKAGE'			=> $count,
							'DONATION_PACKAGE'	=> $value['package'],
						));
					}
				}
			}

			$this->template->assign_vars(array(
				'U_DONATE'				=> $this->helper->route('sitesplat_bbmembership_main_controller', array('route' => 'index.html', 'action' => 'request')),
				'PAYPAL_ENABLED'		=> ($this->config['bbmembership_paypal_email']) ? true : false,
				'BBPOINTS_ENABLED'		=> $this->bbmembership_helper->bbpoints_enabled() && $this->config['bbmembership_bbpoints'],
				'CLUBMODE'				=> $this->config['bbmembership_clubmode'] && !$membership,
				'BBMEMBER_CURRENCY'		=> $this->bbmembership_helper->currency(0, $this->config['bbmembership_currency']),
				'BBMEMBER_PACKAGE'		=> $package,
				'BBMEMBER_COUNDOWN'		=> $this->config['bbmembership_countdown'],
                                'MEMBERSHIP_END'		=> (isset($membership[$mc_gross])) ? date('Y-m-d H:m:s', $payment_date + ($group_amount[$mc_gross]['expire'] * 86400)) : '-1',
		        //	($group_amount[$mc_gross]['expire'] == 0) ? '-1' : date('Y-m-d H:m:s', $payment_date + ($group_amount[$mc_gross]['expire'] * 86400)),
			//	'MEMBERSHIP_END'		=> ($group_amount[$mc_gross]['expire'] == 0) ? '-1' : date('Y-m-d H:m:s', $payment_date + ($group_amount[$mc_gross]['expire'] * 86400)),
				'BBMEMBERSHIP_DEPOSIT'	=> $this->user->lang('BBMEMBERSHIP_DEPOSIT_DISCLAIMER', $this->bbmembership_helper->currency(0, $this->config['bbmembership_currency'])),
				'DAYS_TO_EXPIRATION'	=> (isset($membership[$mc_gross])) ? ($group_amount[$mc_gross]['expire'] == 0) ? 
												$this->user->lang('MEMBERSHIP_UNLIMITED') : (($group_amount[$mc_gross]['expire'] == -1) ? '5 min' : $this->user->lang('DAYS_TO_EXPIRATION', $group_amount[$mc_gross]['expire'])) : '',
				'NOTIFY_STATUS'			=> ($this->notify) ? $this->user->lang[$this->notify] : false
			));
		}
		
		$this->template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'	=> $this->helper->route('sitesplat_bbmembership_main_controller', array('route' => 'index.html')),
			'FORUM_NAME'	=> $this->user->lang('BBMEMBERSHIP'),
		));

		return $this->helper->render('memberships.html', $this->user->lang('BBMEMBERSHIP'));
	}
}
