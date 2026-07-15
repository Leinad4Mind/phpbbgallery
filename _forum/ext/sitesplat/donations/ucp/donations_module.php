<?php
/**
*
* @package BBdonations
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\donations\ucp;

class donations_module
{
	public $u_action;
	function main($id, $mode)
	{
		global $db, $config, $user, $template, $request, $phpbb_container;

		$this->page_title = $user->lang['DONATIONS'];
		$this->tpl_name = 'ucp_donations';
		$this->donations_table = $phpbb_container->getParameter('sitesplat.donation.tables.donations');
		$table_countries = $phpbb_container->getParameter('sitesplat.donation.tables.countries');
		$user->add_lang_ext('sitesplat/donations', 'common');
		
		$manager = $phpbb_container->get('sitesplat.donations.manager');
		$currency_symbol = $manager->currency(0, $config['donations_currency']);

		$sql = 'SELECT d.*, c.country FROM ' . $this->donations_table . ' d
				LEFT JOIN ' . $table_countries . ' c ON c.country_code = d.address_country_code
				WHERE d.user_id = ' . $user->data['user_id'] . ' ORDER BY d.payment_date DESC';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow())
		{
			$template->assign_block_vars('donations', array(
				'SENDER'			=> $row['sender'] . ' ' . $row['address'] . ' ' . $row['country'],
				'TXN_ID'			=> $user->lang['DONATIONS_TRAN'] . (($row['txn_id']) ? $row['txn_id'] : $row['payment_status']),
				'REFERENCE'			=> $currency_symbol . ' ' . $row['mc_gross'],
				'TIME'				=> $user->format_date($row['payment_date']),
				'STATUS'			=> ($row['payment_status'] != 'Completed') ? true: false,
				'PAYMENT_TYPE'		=> ($row['payment_type'] == 1) ? 'paypal-logo' : 'bitcoin-logo',
			));
		}

		
		
		
	}
}
