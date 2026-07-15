<?php
/**
*
* @package BBdonations
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\donations\controller;

class manager
{
	protected $config;
	protected $user;
	protected $auth;
	protected $db;
	protected $request;
	protected $phpbb_root_path;
	protected $phpEx;
	protected $donation_table;

	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, $phpbb_root_path, $phpEx, $donation_table)
	{
		$this->config			= $config;
		$this->user				= $user;
		$this->auth				= $auth;
		$this->db				= $db;
		$this->request			= $request;
		$this->phpbb_root_path	= $phpbb_root_path;
		$this->phpEx			= $phpEx;
		$this->donation_table	= $donation_table;
	}

	public function get_paypal_data()
	{
		$names = $this->request->variable_names(\phpbb\request\request_interface::POST);
		$data = array();
		$include_ary = array('item_name','item_number','payment_status','mc_gross','mc_currency','txn_id','payer_email','payment_date','address_country_code');
		foreach ($names as $name)
		{
			$value = utf8_normalize_nfc($this->request->variable($name, '', true));
			(in_array($name, $include_ary)) ? $data[$name] = $value : null;
		}

		$data['user_id'] 		= $this->user->data['user_id'];
		$data['payment_date'] 	= strtotime($data['payment_date']);
		$data['sender']			= $this->request->variable('first_name', '') . ' ' . $this->request->variable('last_name', '');
		$data['address']		= $this->request->variable('address_street', '') . ' ' . $this->request->variable('address_city', '');
		
		return $data;		
	}

	public function updatePayments($data)
	{
		$sql = 'SELECT id, user_id, txn_id, payment_status FROM ' . $this->donation_table . ' WHERE item_number = ' . (int) $data['item_number'];
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);

		if ($row['payment_status'] != 'Completed')
		{
			if ($row['user_id'] == ANONYMOUS)
			{
				$sql = 'SELECT user_id FROM ' . USERS_TABLE . ' WHERE user_email_hash = ' . phpbb_email_hash($data['payer_email']);
				$result = $this->db->sql_query($sql);
				$user_id = (int) $this->db->sql_fetchfield('user_id');
				$data['user_id'] = ($user_id <> 0) ? $user_id : $row['user_id'];
			} else
			{
				$data['user_id'] = $row['user_id'];
			}

			$sql = 'UPDATE ' . $this->donation_table . ' SET ' . $this->db->sql_build_array('UPDATE', $data) . ' WHERE item_number = ' . (int) $data['item_number'];
			$this->db->sql_query($sql);
			$payment_updated = $this->db->sql_affectedrows();
			
			if ($payment_updated && $data['user_id'] != ANONYMOUS && $data['payment_status'] == 'Completed')
			{
				$this->add_delete_groups($data['user_id']);
			}
		}
		
		return $data;
	}
	
	/**
	 * Prepare user ids for querying
	 *
	 * @param mixed $user_ids User id(s) expected as int or array
	 * @return array An array of user id(s)
	 * @access public
	 */
	public function prepare_users_for_query($user_ids)
	{
		if (is_array($user_ids))
		{
			$user_ids = array_map('intval', $user_ids);
		} else
		{
			$user_ids = array((int) $user_ids);
		}

		return $user_ids;
	}

	public function add_delete_groups($user_ids)
	{
		$user_ids = $this->prepare_users_for_query($user_ids);
		$group_amount = json_decode($this->config['donations_group_id'], true);
		$admin_mod_ary = array();

		foreach ($this->auth->acl_get_list(false, array('a_', 'm_'), false) as $temp => $admin_ary)
		{
			foreach ($admin_ary as $temp => $admin_ary)
			{
				foreach ($admin_ary as $admin_ary)
				{
					$admin_mod_ary[] = $admin_ary;
				}
			}
		}
		$admin_mod_ary = array_unique($admin_mod_ary);

		$sql = 'SELECT group_id FROM ' . GROUPS_TABLE . " WHERE group_name = 'NEWLY_REGISTERED'";
		$this->db->sql_query($sql);
		$newly_registered = $this->db->sql_fetchfield('group_id');

		include_once($this->phpbb_root_path . 'includes/functions_user.' . $this->phpEx );

		foreach($user_ids as $user_id)
		{
			if ($user_id != ANONYMOUS && !in_array($user_id, $admin_mod_ary))
			{
				$sql = 'SELECT user_id, SUM(mc_gross) AS amounttotal, MAX(payment_date) AS payment_date
						FROM ' . $this->donation_table . " 
						WHERE payment_status = 'Completed' AND user_id = $user_id";
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);
	
				if ($row['amounttotal'] >= $group_amount['amount'])
				{
					group_user_add($group_amount['group'], $user_id);
					($group_amount['default']) ? group_set_user_default($group_amount['group'], array($user_id)) : null;
				} else if ($row['amounttotal'] < $group_amount['amount'])
				{
					group_user_del($group_amount['group'], $user_id);
				} 
				if ($group_amount['time'] && $row['payment_date'] < (time() - ($group_amount['time'] * 86400)))
				{
					group_user_del($group_amount['group'], $user_id);
					group_user_add($this->config['donations_fallbackgroup'], $user_id);
					group_set_user_default($this->config['donations_fallbackgroup'], array($user_id));
				}
	
				group_user_del($newly_registered, array($user_id));
			}
		}
	}

	public function symbols()
	{
		$symbols['\f11c'] = 'Keybord';
		$symbols['\f141'] = 'Ellipsis';
		$symbols['\f11d'] = 'Flag';
		$symbols['\f102'] = 'Angle-double-up';
		$symbols['\f12b'] = 'Superscript';
		$symbols['\f121'] = 'Code';
		$symbols['\f124'] = 'Location';
		$symbols['\f127'] = 'Unlink';
		$symbols['\f12e'] = 'Puzzle';
		$symbols['\f132'] = 'Shield';
		$symbols['\f135'] = 'Rocket';
		$symbols['\f145'] = 'Ticket';
		$symbols['\f14b'] = 'Pencil';
		$symbols['\f15a'] = 'Bitcoin';
		$symbols['\f155'] = 'Dollar';
		$symbols['\f188'] = 'Bug';
		$symbols['\f080'] = 'Chart';
		$symbols['\f08a'] = 'Heart';
		$symbols['\f0eb'] = 'Light Bulb';
		$symbols['\f087'] = 'Thumb Up';
		
		return $symbols;
	}
	
	public function currency($select = '', $currency = '')
	{
		$currencies['ARS'] = array('&#8359;', 'Argentine peso');
		$currencies['AUD'] = array('&#36;', 'Australian dollar');
		$currencies['BSD'] = array('&#36;', 'Bahamian dollar');
		$currencies['BBD'] = array('&#36;', 'Barbados dollar');
		$currencies['BZD'] = array('&#36;', 'Belize dollar');
		$currencies['BMD'] = array('&#36;', 'Bermudian dollar');
		$currencies['BRL'] = array('&#36;', 'Brazilian real');
		$currencies['BND'] = array('&#36;', 'Brunei dollar');
		$currencies['BIF'] = array('&#8355;', 'Burundian franc');
		$currencies['XPF'] = array('&#8355;', 'CFP franc');
		$currencies['CAD'] = array('&#36;', 'Canadian dollar');
		$currencies['KYD'] = array('&#36;', 'Cayman Islands dollar');
		$currencies['CLP'] = array('&#8359;', 'Chilean peso');
		$currencies['COP'] = array('&#8359;', 'Colombian peso');
		$currencies['KMF'] = array('&#8355;', 'Comoro franc');
		$currencies['CDF'] = array('&#8355;', 'Congolese franc');
		$currencies['CUP'] = array('&#8359;', 'Cuban peso');
		$currencies['DJF'] = array('&#8355;', 'Djiboutian franc');
		$currencies['DOP'] = array('&#8359;', 'Dominican peso');
		$currencies['XCD'] = array('&#36;', 'East Caribbean dollar');
		$currencies['EGP'] = array('&#163;', 'Egyptian pound');
		$currencies['EUR'] = array('&#128;', 'Euro');
		$currencies['FKP'] = array('&#163;', 'Falkland Islands pound');
		$currencies['FJD'] = array('&#36;', 'Fiji dollar');
		$currencies['GHS'] = array('&#8373;', 'Ghanaian cedi');
		$currencies['GIP'] = array('&#163;', 'Gibraltar pound');
		$currencies['GNF'] = array('&#8355;', 'Guinean franc');
		$currencies['GYD'] = array('&#36;', 'Guyanese dollar');
		$currencies['HKD'] = array('&#36;', 'Hong Kong dollar');
		$currencies['INR'] = array('&#x20B9;', 'Indian rupee');
		$currencies['JMD'] = array('&#36;', 'Jamaican dollar');
		$currencies['JPY'] = array('&#165;', 'Japanese yen');
		$currencies['LAK'] = array('&#8365;', 'Lao kip');
		$currencies['LBP'] = array('&#163;', 'Lebanese pound');
		$currencies['LRD'] = array('&#36;', 'Liberian dollar');
		$currencies['MUR'] = array('&#x20B9;', 'Mauritian rupee');
		$currencies['MXN'] = array('&#8359;', 'Mexican peso');
		$currencies['MNT'] = array('&#8366;', 'Mongolian tugrik');
		$currencies['NAD'] = array('&#36;', 'Namibian dollar');
		$currencies['NPR'] = array('&#x20B9;', 'Nepalese rupee');
		$currencies['TWD'] = array('&#36;', 'New Taiwan dollar');
		$currencies['NZD'] = array('&#36;', 'New Zealand dollar');
		$currencies['NIO'] = array('&#36;', 'Nicaraguan cÃ³rdoba');
		$currencies['KPW'] = array('&#8361;', 'North Korean won');
		$currencies['PKR'] = array('&#x20B9;', 'Pakistani rupee');
		$currencies['PHP'] = array('&#8359;', 'Philippine peso');
		$currencies['GBP'] = array('&#163;', 'Pound sterling');
		$currencies['RWF'] = array('&#8355;', 'Rwandan franc');
		$currencies['SHP'] = array('&#163;', 'Saint Helena pound');
		$currencies['SCR'] = array('&#x20B9;', 'Seychelles rupee');
		$currencies['SGD'] = array('&#36;', 'Singapore dollar');
		$currencies['SBD'] = array('&#36;', 'Solomon Islands dollar');
		$currencies['KRW'] = array('&#8361;', 'South Korean won');
		$currencies['SSP'] = array('&#163;', 'South Sudanese pound');
		$currencies['LKR'] = array('&#x20B9;', 'Sri Lankan rupee');
		$currencies['SDG'] = array('&#163;', 'Sudanese pound');
		$currencies['SRD'] = array('&#36;', 'Surinamese dollar');
		$currencies['CHF'] = array('&#8355;', 'Swiss franc');
		$currencies['SYP'] = array('&#163;', 'Syrian pound');
		$currencies['TOP'] = array('&#36;', 'Tongan paÊ»anga');
		$currencies['TTD'] = array('&#36;', 'Trinidad and Tobago dollar');
		$currencies['TRY'] = array('&#8356;', 'Turkish lira');
		$currencies['UAH'] = array('&#8372;', 'Ukrainian hryvnia');
		$currencies['CLF'] = array('&#36;', 'Unidad de Fomento');
		$currencies['USD'] = array('&#36;', 'United States dollar');
		$currencies['UYU'] = array('&#8359;', 'Uruguayan peso');
		$currencies['VND'] = array('&#8363;', 'Vietnamese dong');
		$currencies['YER'] = array('&#8355;', 'Yemeni rial');

		if ($select == '')
		{
			$option = $currencies[$currency][0];
		} else
		{
			$option = '';
			foreach($currencies as $key => $currency)
			{
				$selected = ($key == $select) ? ' selected="selected"': '';
				$option .= '<option value="' . $key . '"' . $selected . '>  ' . $currency[0] . ' ' . $currency[1] . '</option>';	
			}
		}
		return $option;
	}

}
