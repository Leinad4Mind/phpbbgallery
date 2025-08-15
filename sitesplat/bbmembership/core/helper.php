<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/
namespace sitesplat\bbmembership\core;

use Symfony\Component\DependencyInjection\Container;
use phpbb\db\driver\driver_interface;
use phpbb\config\config;
use phpbb\user;
use phpbb\request\request;
use phpbb\notification\manager;

class helper
{
	protected $db;
	protected $config;
	protected $user;
	protected $request;
	protected $notification_manager;
	protected $phpbb_container;
	protected $root_path;
	protected $php_ext;
	protected $bbmembership_table;

	public function __construct(driver_interface $db, config $config, user $user, request $request, manager $notification_manager, Container $phpbb_container,  $root_path, $php_ext, $bbmembership_table)
	{
		$this->db = $db;
		$this->config = $config;
		$this->user = $user;
		$this->request = $request;
		$this->notification_manager = $notification_manager;
		$this->container = $phpbb_container;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->bbmembership_table = $bbmembership_table;
		$this->bbmembership_groups = json_decode($this->config['bbmembership_groups'], true);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_paypal_data()
	{
		$names = $this->request->variable_names(\phpbb\request\request_interface::POST);
		$data = array();
		$include_ary = array('item_number','payment_status','mc_gross','mc_currency','txn_id','payer_email','payment_date','address_country_code');
		foreach ($names as $name)
		{
			$value = utf8_normalize_nfc($this->request->variable($name, '', true));
			(in_array($name, $include_ary)) ? $data[$name] = $value : null;
		}
		$data['user_id'] 		= $this->user->data['user_id'];
		$data['payment_date'] 	= isset($data['payment_date']) ? strtotime($data['payment_date']) : time();
		$data['sender']			= $this->request->variable('first_name', '') . ' ' . $this->request->variable('last_name', '');
		$data['address']		= $this->request->variable('address_street', '') . ' ' . $this->request->variable('address_city', '');
		
		return $data;		
	}

	/**
	 * {@inheritdoc}
	 */
	public function updatePayments($data)
	{
		$sql = 'SELECT id, user_id, txn_id, payment_status, membership 
				FROM ' . $this->bbmembership_table . ' WHERE item_number = \'' . (isset($data['item_number']) ? $data['item_number'] : '') .'\'';
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);

		if ($row['payment_status'] != 'Completed')
		{
			unset($data['item_number'], $data['user_id']);
			$sql = 'UPDATE ' . $this->bbmembership_table . ' SET ' . $this->db->sql_build_array('UPDATE', $data) . ' WHERE id = ' . (int) $row['id'];
			$this->db->sql_query($sql);
			
			$this->add_group((int) $row['user_id'], (int) $data['mc_gross'], $row['id']);

			// send notification
			$this->notification_manager->add_notifications('sitesplat.bbmembership.notification.type.membership_bought', array(
				'txn_id'		=> $row['id'],
				'user_id'		=> $row['user_id'],
				'amount'		=> $row['membership'],
			));
		}
		
		return $data;
	}
	
	public function bbpoints_enabled()
	{
		$ext_manager = $this->container->get('ext.manager');	
		return $ext_manager->is_enabled('sitesplat/bbpoints');
	}

	public function pay_with_points($amount = 0)
	{
		$cookie = $this->request->variable($this->config['cookie_name'] . '_bbmemdb', '', true, \phpbb\request\request_interface::COOKIE);
		if (!$cookie)
		{
			$this->bbpoints_table = $this->container->getParameter('sitesplat.bbpoints.table');	
			$user_id = $this->user->data['user_id'];
			$sql = 'SELECT user_id, SUM(points) as total FROM (
					SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 AND poster_id = ' . $user_id . ' 
					UNION ALL
					SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' WHERE topic_poster = ' . $user_id . '
					UNION ALL
					SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE to_id = ' . $user_id . '
					UNION ALL
					SELECT to_id AS user_id, SUM(- bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $user_id . '
					) t1';
			$result = $this->db->sql_query($sql);
			$user_points  = $this->db->sql_fetchfield('total');
			
			if ($user_points >= ($amount * 100))
			{
				$data = array(
					'item_name'			=> $this->user->lang('BBMEMBERSHIP') . ' - ' . $this->config['sitename'],
					'payer_email'		=> $this->user->data['user_email'],
					'item_number'		=> $this->user->data['user_id'],
					'payment_status'	=> 'Completed',
					'user_id'			=> $this->user->data['user_id'],
					'payment_date'		=> time(),
					'session_ip'		=> $this->user->ip,
					'mc_gross'			=> $amount * 100 . '.00',
					'mc_currency'		=> 'BBPOINTS'
					);
	
				$sql = 'INSERT INTO ' . $this->bbmembership_table . ' ' . $this->db->sql_build_array('INSERT', $data);
				$this->db->sql_query($sql);
	
				$data = array(
					'from_id'		=> $this->user->data['user_id'],
					'to_id'			=> 0,
					'bbpoints'		=> $amount * 100,
					'reason'		=> 'Membership',
					'timestamp'		=> time(),
					);
	
				$sql = 'INSERT INTO ' . $this->bbpoints_table . ' ' . $this->db->sql_build_array('INSERT', $data);
				$this->db->sql_query($sql);
				$this->user->set_cookie('bbmemdb', 'bbmembership_bought', time() + 60);

				$this->add_group($this->user->data['user_id'], $amount, $this->db->sql_nextid());
				
				return 'MEMBERSHIP_SUCCESS';
			} else
			{
				return 'MEMBERSHIP_FAILED_POINTS';
			}
		} else
		{
			return 'MEMBERSHIP_DOUBLE';
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function add_group($user_id, $membership)
	{
		include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);
		
		$sql = 'SELECT group_id FROM ' . GROUPS_TABLE . ' WHERE group_name = "GLOBAL_MODERATORS" OR group_name = "ADMINISTRATORS"';
		$result = $this->db->sql_query($sql);
		$group_ids = $this->db->sql_fetchrowset($result);
		$group_ids = array_map(function($item) { return $item['group_id']; }, $group_ids);
		
		($membership) ? group_user_add($this->bbmembership_groups[$membership]['group'], $user_id) : null;

		if (!$this->bbmembership_groups[$membership]['new_user'])
		{
			remove_newly_registered($user_id);
		}

		if ($this->bbmembership_groups[$membership]['default'] && !group_memberships($group_ids, $user_id, true))
		{
			group_set_user_default($this->bbmembership_groups[$membership]['group'], array($user_id));
		}
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function dell_group($user_id, $membership)
	{
		include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);

		group_user_del($this->bbmembership_groups[$membership]['group'], $user_id);
	}

	/**
	 * {@inheritdoc}
	 */
	public function show_result($message)
	{
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'MESSAGE_TITLE'	=> $this->user->lang['INFORMATION'],
				'MESSAGE_TEXT'	=> $message,
				'REFRESH_DATA'	=> array(
					'time'	=> 3,
					'url'	=> $this->u_action
				)
			));
		} else
		{
			trigger_error($message/* . adm_back_link($this->u_action)*/, E_USER_NOTICE);
		}
	}
	/**
	 * {@inheritdoc}
	 */
	public function find_membership($array, $field, $value)
	{
	   foreach($array as $key => $product)
	   {
		  if ($product[$field] === $value)
			 return $key;
	   }
	   return false;
	}
	
	/**
	 * {@inheritdoc}
	 */
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
