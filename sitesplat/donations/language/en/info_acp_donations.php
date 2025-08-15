<?php
/**
*
* @package BBdonations
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if ( empty($lang) || !is_array($lang) )
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_DONATIONS'  				=> 'BBDonations',
	'ACP_DONATIONS_EXPLAIN'			=> 'Donations settings for your website. Configure the desired settings, fill in the PayPal info and the Bitcoin info to maximize your donation results.',
	'ACP_DONATIONS_INDEX_TITLE'		=> 'Config',
	'ACP_DONATIONS_PAYPAL_EMAIL'	=> 'Paypal email',
	'ACP_DONATIONS_PAYPAL_EXPLAIN'	=> 'Enter your PayPal email here. (leave empty to disable donation method) You might need to use PayPal business account as the IPN system might requires it to work correctly.<br /> For more information visit: <a href="https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNSetup/#id089EG030E5Z">PayPal IPN setup</a>',
	'ACP_DONATIONS_OPTIONS'			=> 'Donation options',
	'ACP_DONATIONS_OPTIONS_EXPLAIN'	=> 'The following options are available: <br /> <strong>Sandbox Mode:</strong> Allows the sandbox mode (For both Bitcoin and PayPal) which is useful to test the donations. Please beware that Coinbase sandbox is not reliable and therefore a real account should be used to run tests. The easiest way to test it is to use a smartphone app and donate back and forth between your forum and the app. Use the following app for android phones: <a href="https://airbitz.co/af/DJM" target="blank">AirBitz</a> <br /> <strong>Enable message:</strong> This enables the user to leave a short message with the donation <br /> <strong>Show donors:</strong> Enables the last recent donors',
	'ACP_DONATIONS_SANDBOX'			=> 'Sandbox mode',
	'ACP_DONATIONS_MESSAGE'			=> 'Enable message',
	'ACP_DONATIONS_LIST'			=> 'Show donors',
	'ACP_DONATIONS_BITCOIN'			=> 'Bitcoin',
	'ACP_DONATIONS_BITCOIN_EXPLAIN' => 'Enter Your coinbase API Key and API Secret here (leave empty to disable donation method). <br /> Follow <strong>EXACTLY</strong> (links open on a new tab) these steps to successfully enable Bitcoin donation: <br /><strong>STEP1:</strong> <a href="https://www.coinbase.com/join/54c7b129d41344b592000006" target="_blank">Register a Coinbase account</a> <br /><strong>STEP2:</strong> <a href="https://www.coinbase.com/merchant_profiles" target="_blank">Setup the merchant page profile</a> <br /><strong>STEP3:</strong> <a href="https://www.coinbase.com/merchant_settings" target="_blank">Setup the merchant settings</a> <br /><strong>STEP4:</strong> In the notification URL option under Merchant settings (STEP3), enter your board URL like this:<br /> <code>http://www.my_board_url.com/app.php/donation/index.html?mode=notify_bitcoin</code> (Where "my_board_url.com" is your real board URL) <br /><strong>STEP5:</strong> Register the the Oauth application here: <a href="https://www.coinbase.com/settings/api" target="_blank">Oauth App</a>. Click on the button "+ New API key" then under "Accounts" checkmark "My Wallet (Primary)", under "Permissions" Click on select all and finally under "Notifications" enter the same URL as described on STEP4. Now click "Create" Button and get your API Key and API Secret to be enter here on your right. <br /><strong>STEP6:</strong> Congrats! Good luck with your donation campaign!',
	'ACP_DONATIONS_BITCOIN_KEY'		=> 'API Key',
	'ACP_DONATIONS_BITCOIN_SECRET'	=> 'API Secret',
	'ACP_DONATIONS_AMOUNTS'			=> 'Amounts',
	'ACP_DONATIONS_TEXT'			=> 'Text',
	'ACP_DONATIONS_SYMBOL'			=> 'Symbol',
	'ACP_DONATIONS_ADD_ROW'			=> 'Add another row',
	'ACP_DONATIONS_DELL_ROW'		=> 'Delete last row',
	'ACP_DONATIONS_AMOUNTS_EXPLAIN'	=> 'The following options are available: (Use "%s" as a placeholder to fill in automatically the amount and currency in your text field.) <br /><strong>Amount:</strong> Set the donation amount <br /><strong>Text:</strong> Enter your custom text for the donation amount goal <br /><strong>Symbol:</strong> Select a font awesome symbol for each goal eantered.', 
	'ACP_DONATIONS_STATUS'			=> 'Status',
	'ACP_DONATIONS_GROUP'			=> 'Auto Group',
	'ACP_DONATIONS_GROUP_EXPLAIN'	=> 'The following options are available for the AutoGroup settings: <br /><strong>Days:</strong> time expressed in days for the user to stay on X group. (No time disables fallback for this group) <br /> <strong>Amount:</strong> min currency (donation) value for the AutoGroup to be triggered. (0 disables AutoGroup) <br /><strong>Group:</strong> Group for the user to be moved into when the min. amount is triggered <br /><strong>Group Default:</strong> Set the group to default for the user (Checkmark to set as default)',
	'ACP_DONATIONS_GROUP_DEF'		=> 'Group default',
	'ACP_DONATIONS_GROUPS'		    => 'Group',
	'ACP_DONATIONS_STATS'  			=> 'Statistics',
	'ACP_DONATIONS_TIME'			=> 'Date',
	'ACP_DONATIONS_TOTAL'			=> 'Sum of all donations',
	'ACP_DONATIONS_ADDRESS'			=> 'Donator\'s address',
	'ACP_DONATIONS_COUNTRY'			=> 'Donator\'s country',
	'ACP_DONATIONS_TRANSACTIONS'  	=> 'Transactions',
	'ACP_DONATIONS_FALLBACK'  		=> 'Fallback Group',
	'ACP_DONATIONS_FALLBACK_EXPLAIN'=> 'A Group fallback for the user to go back to if the time (in Days) is exceeded.<br />No group disables this function.',
	'ACP_DONATIONS_AMOUNT'			=> 'Amount',
	
	'ACP_DONATIONS_DAY_STAY'		=> 'Day to stay in this group',
	'ACP_DONATIONS_CHANGE_STATUS'	=> 'Change status',
	'ACP_DONATIONS_MAX_AMO'			=> 'Max amount for this group',
	
	'ACP_DONATIONS_DAYS'			=> 'Days',
	'ACP_DONATIONS_TRANSACTION'		=> 'Transaction id',
	'ACP_DONATIONS_CURRENCY'		=> 'Currency code',
	'ACP_DONATIONS_CURRENCY_EXPLAIN'=> 'Currency code follows the allowed <a href="https://developer.paypal.com/docs/classic/api/currency_codes/" target="_blank">Paypal Multiple Currencies</a> standards. <br /> Make sure the currency you are going to use is enabled on your PayPal account. <br />If the currency is not supported on your PayPal acccount the transactions will be returned as "Not verified" or "Pending".',
	'ACP_DONATIONS_USERNAME'		=> 'Username',
	'DONATIONS_NOTICE'				=> '<div class="phpinfo"><p>The settings for this extensions are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	
	
	'SITESPLAT_COM'		        => 'https://sitesplat.com',
	'SITESPLAT_COPY'		    => '&#169; SiteSplat',
	'LICENSE_INFO'		        => 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'	    => 'Developer',
	'ACP_NOTICE_CLOSE'			=> 'Close',
	'ACP_DONATIONS_VERSION'     => '1.0.9',
	'ACP_LOADING'		        => 'Loading... Hold on',
	
	'EXT_BBD_DESCRIPTION_PAGE'	=> 'A kick-ass donation extension for the phpBB board running sitesplat themes. Many modern and useful options included PayPal IPN and Bitcoin API.',
	'EXT_BBD_TASKS_1'			=> 'AutoGroup',
	'EXT_BBD_TASKS_2'			=> 'Fully editable donation scopes',
	'EXT_BBD_TASKS_3'			=> 'PayPal IPN',
	'EXT_BBD_TASKS_4'			=> 'Bitcoins support',
	'EXT_BBD_TASKS_5'			=> 'phpBB 3.2 ready',
	'EXT_BBD_TASKS_6'			=> 'Checkout the other premium compatible addons on <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	
));

// Description of Donations extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Description',
	'DESCRIPTION_NOTICE'	=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'	=> 'Overview of donations',
			'DESCRIPTION_2'	=> 'Paypal / Bitcoins API',
			'DESCRIPTION_3'	=> 'Autogroups',
			'DESCRIPTION_4'	=> 'Set back to standard group after x amount of time',
			'DESCRIPTION_5'	=> 'Guest can also donate',
		),
		'note' => array(
			'NOTICE_1'		=> 'phpBB 3.2 ready'
		)
	)
));
