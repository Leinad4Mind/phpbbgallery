<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership\controller;

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
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\notification\manager $notification_manager, $root_path, $php_ext, $bbmembership_table, $bbmembership_helper)
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

		$mode = $this->request->variable('mode', 'index');
		$notify = false;
		switch($mode)
		{
			case 'pay':

				if ($this->user->data['user_id'] == ANONYMOUS)
				{
					login_box(append_sid($this->root_path . 'memberships.' . $this->php_ext));
				}

				if ($this->bbmembership_helper->bbpoints_enabled() && $this->request->variable('submitbtn', '') == $this->user->lang['BBMEMBERSHIP_POINTS'])
				{
					$notify = $this->bbmembership_helper->pay_with_points($this->request->variable('amount', 0));
				} else
				{
					// PayPal settings 
					$paypal_email	= $this->config['bbmembership_paypal_email']; 
					$return_url		= generate_board_url() . '/memberships.' . $this->php_ext . '?mode=verify'; 
					$cancel_url		= generate_board_url() . '/memberships.' . $this->php_ext. '?mode=verify'; 
					$notify_url		= generate_board_url() . '/memberships.' . $this->php_ext . '?mode=verify'; 
		
					$data = array(
						'item_name'		=> $this->user->lang('BBMEMBERSHIP') . ' - ' . $this->config['sitename'],
						'amount'		=> (intval($this->request->variable('amount', 0))) . '.00',
						'payer_email'	=> $this->user->data['user_email'],
						'mc_currency'	=> $this->config['bbmembership_currency'],
						'item_number'	=> time()
						);
	
					$querystring = '?';
					foreach($data as $key => $value)
					{
						$querystring .= $key . '=' . urlencode($value) . '&'; 
					}
	
					// Check if paypal request or response 
					if (!$this->request->is_set_post('txn_id') && !$this->request->is_set_post('txn_type'))
					{ 
						$querystring .= 'business=' . urlencode($paypal_email) . '&'; 
						$querystring .= 'currency_code=' . $this->config['bbmembership_currency'] . '&'; 
						$querystring .= 'cmd=_xclick&no_note=1&lc=UK&bn=PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest&rm=2&tax=0&no_shipping=1&';
						$querystring .= 'bn=' . urlencode('PP-DonationsBF') . '&'; 
		 
						// Append paypal return addresses 
						$querystring .= 'return=' . urlencode(stripslashes($return_url)) . '&'; 
						$querystring .= 'cancel_return=' . urlencode(stripslashes($cancel_url)) . '&'; 
						$querystring .= 'notify_url=' . urlencode($notify_url); 
	
						$data['payment_status'] = 'Not verified';
						$data['user_id'] = $this->user->data['user_id'];
						$data['payment_date'] = time();
						$data['session_ip'] = $this->user->ip;
						$data['mc_gross'] = $data['amount'];
						unset($data['amount']);
						$sql = 'INSERT INTO ' . $this->bbmembership_table . ' ' . $this->db->sql_build_array('INSERT', $data);
						$this->db->sql_query($sql);
	
						// Redirect to paypal IPN 
						header('location:https://www' . (($this->config['bbmembership_sandbox']) ? '.sandbox' : '') . '.paypal.com/cgi-bin/webscr' . $querystring); 
						exit(); 
					}
				}
			break;

			case 'verify':
 
				$req = 'cmd=_notify-validate';
				$data = array();
				$data['payment_status'] = 'Not verified';
				
				$names = $this->request->variable_names(\phpbb\request\request_interface::POST);
				$include_ary = array('item_name','item_number','payment_status','mc_gross','mc_currency','txn_id','payer_email','custom','payment_date','address_country_code');
				foreach ($names as $name)
				{
					$value = utf8_normalize_nfc($this->request->variable($name, '', true));
					(in_array($name, $include_ary)) ? $data[$name] = $value : null;
					$value = urlencode(stripslashes($value));
					$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
					$req .= '&'. $name . '=' . $value;
				}
				
				// assign posted variables to local variables
				$data['payment_date'] 		= (isset($data['payment_date'])) ? strtotime($data['payment_date']) : time();
				$data['sender']				= $this->request->variable('first_name', '') . ' ' . $this->request->variable('last_name', '');
				$data['address']			= $this->request->variable('address_street', '') . ' ' . $this->request->variable('address_city', '');
				
				// post back to PayPal system to validate
				$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
				$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
				$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
				$fp = file_get_contents('https://' . (($this->config['bbmembership_sandbox']) ? 'sandbox' : 'www') . '.paypal.com/cgi-bin/webscr?' . $req);

				// if payment verified
				if ($data['payment_status'] == 'Completed' && strcmp ($fp, "VERIFIED") == 0) 
				{
					// Validate payment (Check unique txnid & correct price)
					$valid_txnid = true; //$this->check_txnid($data['txn_id']);
					$valid_price = true; //$this->check_price($data['mc_gross'], $data['item_number']);

					if ($valid_txnid && $valid_price)
					{
						// If user exists assign BBpoints - TODO

						$sql = 'UPDATE ' . $this->bbmembership_table . '
								SET ' . $this->db->sql_build_array('UPDATE', $data) . '
								WHERE item_number = ' . (int) $data['item_number'];
						$this->db->sql_query($sql);
						$sql = 'SELECT id, user_id FROM ' . $this->bbmembership_table . '
								WHERE item_number = ' . (int) $data['item_number'];
						$result = $this->db->sql_query($sql);
						$row = $this->db->sql_fetchrow($result);

						$this->bbmembership_helper->add_group($row['user_id'], (int) $data['mc_gross'], $row['id']);
						
						$notify = 'MEMBERSHIP_SUCCESS';
					} else
					{
						$notify = 'MEMBERSHIP_FAILED_PP';	
					}
				} else
				{
					$notify = 'MEMBERSHIP_FAILED_PP';	
				}
	
		}
			
		if (!empty($this->config['bbmembership_groups'])) 
		{
			$group_amount = json_decode($this->config['bbmembership_groups'], true);

			$membership = $days_to_expiration = false;
			$mc_gross = 0;
			$sql = 'SELECT mc_gross, mc_currency, payment_status, payment_date FROM ' . $this->bbmembership_table . ' 
					WHERE user_id = ' . $this->user->data['user_id'] . ' AND payment_status = "Completed" ORDER BY payment_date DESC';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$mc_gross = ($row['mc_currency'] == 'BBPOINTS') ? (int) $row['mc_gross'] / 100 : (int) $row['mc_gross'];
				$membership = (isset($group_amount[$mc_gross]) && 
							  (($group_amount[$mc_gross]['expire'] == -1) ? 300 : ($group_amount[$mc_gross]['expire'] * 86400)) + $row['payment_date'] > time() ||
							  $group_amount[$mc_gross]['expire'] == 0) ? true: false;
				$days_to_expiration = (isset($group_amount[$mc_gross])) ? round(((($group_amount[$mc_gross]['expire'] == -1) ? 300 : 
									  ($group_amount[$mc_gross]['expire'] * 86400)) + $row['payment_date'] - time()) / (($group_amount[$mc_gross]['expire'] == -1) ? 1 : 86400), 0) : 0;			
				if ($membership) break;
			}

			$count = $package = 0;
			foreach ($group_amount as $key => $value)
			{
				$this->template->assign_block_vars('levels', array(
					'LEVEL'					=> ++$count,
					'DONATIONS_AMOUNT'		=> $key,
					'DONATIONS_EXPIRE'		=> ($group_amount[$key]['expire'] == 0) ? 
												$this->user->lang('MEMBERSHIP_UNLIMITED') : (($group_amount[$key]['expire'] == -1) ? '5 min' : $group_amount[$key]['expire']),
					'DONATIONS_DEFAULT'		=> $group_amount[$key]['default'],
					'PACKAGE'				=> ($membership && $mc_gross == $key) ? true : false,
					'DONATIONS_HIDE'		=> $group_amount[$key]['hide'],
					'DONATIONS_POINTS'		=> $key * 100
				));
				$package = ($mc_gross == $key) ? $count : $package;

				foreach($this->bbmembership_package as $key => $value)
				{
					$this->template->assign_block_vars('levels.packages', array(
						'PACKAGE'			=> $count,
						'DONATION_PACKAGE'	=> $value['package'],
					));
				}
			}

			$this->template->assign_vars(array(
				'U_DONATE'				=> append_sid($this->root_path . 'memberships.' . $this->php_ext, 'mode=pay'),
				'PAYPAL_ENABLED'		=> ($this->config['bbmembership_paypal_email']) ? true : false,
				'BBPOINTS_ENABLED'		=> $this->bbmembership_helper->bbpoints_enabled() && $this->config['bbmembership_bbpoints'],
				'CLUBMODE'				=> $this->config['bbmembership_clubmode'] && !$membership,
				'BBMEMBER_CURRENCY'		=> $this->bbmembership_helper->currency(0, $this->config['bbmembership_currency']),
				'BBMEMBER_PACKAGE'		=> $package,
				'DAYS_TO_EXPIRATION'	=> (isset($group_amount[$mc_gross]) && $group_amount[$mc_gross]['expire'] == 0 && $row['payment_status'] == 'Completed') ? 
											$this->user->lang('MEMBERSHIP_UNLIMITED') : (($days_to_expiration < 0) ? 0 : $days_to_expiration),
				'NOTIFY_STATUS'			=> ($notify) ? $this->user->lang[$notify] : false
			));
		}
		
		$this->template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'	=> append_sid($this->root_path . 'memberships.' . $this->php_ext),
			'FORUM_NAME'	=> $this->user->lang('BBMEMBERSHIP'),
		));

		return $this->helper->render('memberships.html', $this->user->lang('BBMEMBERSHIP'));
	}
}
