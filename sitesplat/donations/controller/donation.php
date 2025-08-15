<?php
/**
*
* @package BBdonations
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\donations\controller;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;

use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;
use Coinbase\Wallet\Resource\Account;

use Coinbase\Wallet\Resource\Checkout;

class donation
{
	protected $config;
	protected $config_text;
	protected $manager;
	protected $helper;
	protected $template;
	protected $user;
	protected $auth;
	protected $db;
	protected $request;
	protected $phpbb_dispatcher;
	protected $phpbb_root_path;
	protected $phpEx;
	protected $donation_table;

	public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \sitesplat\donations\controller\manager $manager, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\event\dispatcher $phpbb_dispatcher, $phpbb_root_path, $phpEx, $donation_table)
	{
		$this->config			= $config;
		$this->config_text		= $config_text;
		$this->manager			= $manager;
		$this->helper			= $helper;
		$this->template			= $template;
		$this->user				= $user;
		$this->auth				= $auth;
		$this->db				= $db;
		$this->request			= $request;
		$this->phpbb_dispatcher = $phpbb_dispatcher;
		$this->phpbb_root_path	= $phpbb_root_path;
		$this->phpEx			= $phpEx;
		$this->donation_table	= $donation_table;
		$this->options			= json_decode($this->config['donations_options'], true);
		$this->notify = false;
	}

	public function handle()
	{
		$bitcoin = json_decode($this->config['donations_bitcoin'], true);
		if (isset($this->config['donations_paypal_email']) && $this->config['donations_paypal_email'] == '' && (empty($bitcoin['key']) && empty($bitcoin['secret'])))
		{
			trigger_error($this->user->lang['DONATION_DISABLED'], E_USER_NOTICE);
		}

		$mode = $this->request->variable('mode', '') . (($this->request->is_set_post('bitcoin')) ? '_bitcoin' : '');

		switch ($mode)
		{
			case 'request':
				// PayPal settings
				$paypal_email	= $this->config['donations_paypal_email'];
				$url = generate_board_url(true);
				$return_url	= $url . $this->helper->route('sitesplat_donations_controller', array('route' => 'index.html', 'mode' => 'verify'));
				$cancel_url	= $url . $this->helper->route('sitesplat_donations_controller', array('route' => 'index.html', 'mode' => 'cancel'));
				$notify_url	= $url . $this->helper->route('sitesplat_donations_controller', array('route' => 'index.html', 'mode' => 'notify'));

				$data = array(
					'item_name'		=> 'Donation',
					'amount'		=> (intval($this->request->variable('amount', 0))) . '.00',
					'payer_email'	=> urlencode($this->user->data['user_email']),
					'item_number'	=> time(),
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
					$querystring .= 'currency_code=' . $this->config['donations_currency'] . '&';
					$querystring .= 'cmd=_xclick&no_note=1&lc=UK&bn=PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest&';

					// Append paypal return addresses
					$querystring .= 'return=' . urlencode(stripslashes($return_url)) . '&';
					$querystring .= 'cancel_return=' . urlencode(stripslashes($cancel_url)) . '&';
					$querystring .= 'notify_url=' . urlencode($notify_url);

					$data['payment_status'] = 'Not verified';
					$data['user_id'] = $this->user->data['user_id'];
					$data['payment_date'] = time();
					$data['mc_currency'] = $this->config['donations_currency'];
					$data['session_ip'] = $this->user->ip;
					$data['mc_gross'] = $data['amount'];
					$data['custom'] = utf8_normalize_nfc($this->request->variable('custom', '', true));
					$data['payment_type'] = 1;
					unset($data['amount']);
					$sql = 'INSERT INTO ' . $this->donation_table . ' ' . $this->db->sql_build_array('INSERT', $data);
					$this->db->sql_query($sql);

					// Redirect to paypal IPN
					header('location:https://www.' . (($this->options['sandbox']) ? 'sandbox.' : '') . 'paypal.com/cgi-bin/webscr' . $querystring);
					exit();
				}
			break;

			case 'notify':
				$data = $this->manager->get_paypal_data();
				if (!empty($data)) {
					$data = ($this->manager->updatePayments($data));
				}
			break;

			case 'verify':
				$data = $this->manager->get_paypal_data();
				if (!empty($data)) {
					$data = ($this->manager->updatePayments($data));

					/**
					* This event is used for performing actions directly after a donation
					* has been submitted. When a new donation is posted, the user ID is
					* available in the $vars array.
					*
					* @event core.submit_donation_end
					* @var	int		user_id				Variable user_id
					*
					* @since 3.1.3
					*/

					$user_id = $data['user_id'];
					$vars = array('user_id');
					$this->phpbb_dispatcher->trigger_event('core.submit_donation_end', compact($vars));

					$this->notify = ($mode = 'verify') ? (($data['payment_status'] = 'Completed') ? $this->user->lang('DONATIONS_SUCCESS') : $this->user->lang('DONATIONS_ERROR')) : false;
				}

				$this->template->assign_vars(array('NOTIFY_STATUS' => ($this->notify) ? $this->notify : false));
			break;

			case 'cancel':
				$this->notify = $this->user->lang('DONATIONS_CANCELLED');
				$this->template->assign_vars(array('NOTIFY_STATUS' => ($this->notify) ? $this->notify : false));
			break;

			case 'request_bitcoin':

				$data = array(
					'item_name'			=> 'Donation',
					'payment_status'	=> 'Not verified',
					'user_id'			=> $this->user->data['user_id'],
					'payment_date'		=> time(),
					'mc_currency'		=> $this->config['donations_currency'],
					'session_ip'		=> $this->user->ip,
					'mc_gross'			=> intval($this->request->variable('amount', 0)) . '.00',
					'custom'			=> utf8_normalize_nfc($this->request->variable('custom', '', true)),
					'item_number'		=> time(),
					'payment_type'		=> 2
				);

				$sql = 'INSERT INTO ' . $this->donation_table . ' ' . $this->db->sql_build_array('INSERT', $data);
				$this->db->sql_query($sql);

				require_once($this->phpbb_root_path . '/ext/sitesplat/donations/vendor/vendor/autoload.php');
				$configuration = Configuration::apiKey($bitcoin['key'], $bitcoin['secret']);
				($this->options['sandbox']) ? $configuration->setApiUrl(Configuration::SANDBOX_API_URL) : $configuration->setApiUrl(Configuration::DEFAULT_API_URL);
				$client = Client::create($configuration);

				$PrimaryAccount = $client->getPrimaryAccount();

				$params = array(
					'name'		=> $data['item_name'],
					'amount'	=> new Money($data['mc_gross'], $data['mc_currency']),
					'metadata'	=> array('order_id' =>  $data['item_number'], 'user_id' => $data['user_id'])
				);

				$checkout = new Checkout($params);
				$client->createCheckout($checkout);
				$code = $checkout->getEmbedCode();
				$this->template->assign_vars(array(
					'DONATIONS_COINBASE_URL' => str_replace('api.', '', ($this->options['sandbox']) ? Configuration::SANDBOX_API_URL: Configuration::DEFAULT_API_URL),
					'DONATIONS_COINBASE_CODE' => $code));
			break;
			case 'notify_bitcoin':

				$notify = file_get_contents("php://input");
				$notify = json_decode($notify, true);

				require_once($this->phpbb_root_path . '/ext/sitesplat/donations/vendor/vendor/autoload.php');
				$configuration = Configuration::apiKey($bitcoin['key'], $bitcoin['secret']);
				($this->options['sandbox']) ? $configuration->setApiUrl(Configuration::SANDBOX_API_URL) : $configuration->setApiUrl(Configuration::DEFAULT_API_URL);
				$client = Client::create($configuration);
				$sender = $client->getUser($notify['user']['id']);
				$sender = $sender->getRawData();

				if (isset($notify['type']) && $notify['type'] == 'wallet:orders:paid')
				{
					$notify = $notify['data'];
					if ($notify['status'] == 'paid')
					{
						$data = array(
							'item_name'				=> $notify['name'],
							'item_number'			=> $notify['metadata']['order_id'],
							'payment_status'		=> 'Completed',
							'mc_gross'				=> $notify['amount']['amount'],
							'mc_currency'			=> $notify['amount']['currency'],
							'txn_id'				=> $notify['transaction']['id'],
							'payer_email'			=> '',
							'payment_date'			=> strtotime($notify['paid_at']),
							'address_country_code'	=> $notify['status'],
							'user_id'		 		=> $notify['metadata']['user_id'],
							'sender'				=> $sender['name'],
							'address'				=> $this->request->variable('address_street', '') . ' ' . $this->request->variable('address_city', '')
						);
					}
					$data = ($this->manager->updatePayments($data));
					send_status_line(200, 'OK');
				}
				exit();
			break;

			case 'succes_bitcoin':
			case 'cancel_bitcoin':
			break;
		}

		$this->user->add_lang_ext('sitesplat/donations', 'common');
		$currency_symbol = $this->manager->currency(0, $this->config['donations_currency']);
		$donationtxt = explode("\n", $this->config_text->get('donations_text'));

		$amounts = json_decode($this->config['donations_amounts'], true);
		foreach($amounts as $key => $amount)
		{
			$this->template->assign_block_vars('amounts', array(
				'KEY'		=> $key + 1,
				'AMOUNT'	=> $amount['amount'],
				'TXT'		=> (isset($donationtxt[$key])) ? sprintf($donationtxt[$key], '<span class="amt-donation">' . $currency_symbol . number_format($amount['amount'], 2) . '</span>'): '',
				'SYMBOL'	=> $amount['symbol']
			));
		}

		if ($this->options['list'])
		{
			$sql = 'SELECT u.user_id, u.username, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, d.custom, d.mc_gross
					FROM ' .$this->donation_table .' d
					LEFT JOIN ' . USERS_TABLE . " u ON u.user_id = d.user_id
					WHERE d.payment_status = 'Completed'
					ORDER bY payment_date DESC
					LIMIT 5";
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$this->template->assign_block_vars('donors', array(
					'NAME'		=> $row['username'],
					'AVATAR'	=> (($row['user_avatar']) ?
									 str_replace(array('<img', './../../'), array('<img class="avatar"', './'), phpbb_get_user_avatar(
										array('avatar'			=> $row['user_avatar'],
                                              'user_id'         => $row['user_id'],
											  'avatar_type'		=> $row['user_avatar_type'],
											  'avatar_width'	=> $row['user_avatar_width'],
											  'avatar_height'	=> $row['user_avatar_height']), $row['username'])) :
											  '<img class="avatar" title="' .  $row['username'] . '" src="' .
											  generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png">'),
					'TXT'		=> $row['custom'],
					'AMOUNT'	=> $row['mc_gross']
				));
			}
		}

		$sql = 'SELECT SUM(CASE WHEN payment_status = "Completed" OR payment_status = "Expired" THEN mc_gross ELSE 0 END) AS total,
				SUM(CASE WHEN payment_status = "Not verified" THEN mc_gross ELSE 0 END) AS not_verified
				FROM ' . $this->donation_table . ' WHERE user_id = ' . $this->user->data['user_id'];
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);

		$group = json_decode($this->config['donations_group_id'], true);
		$bitcoin = json_decode($this->config['donations_bitcoin'], true);

		 // Lets build a page ...
		$this->template->assign_vars(array(
			'U_DONATE'						=> $this->helper->route('sitesplat_donations_controller', array('route' => 'index.html', 'mode' => 'request')),
			'DONATIONS_CURRENCY_SYMBOL'		=> $currency_symbol,
			'USER_CREDITS'					=> $row['total'] . (($row['not_verified']) ? ' <span style="font-size:60%;" title="Not verified">( ' . $currency_symbol . ' ' . $row['not_verified'] . ' )</span>' : ''),
			'DONATIONS_PREMIUM'				=> ($group['amount']) ? $this->user->lang('DONATIONS_PREMIUM', $currency_symbol . ' ' .  number_format($group['amount'], 2)) : '',
			'STEPS'							=> sizeof($amounts) -1,
			'ENABLE_MESSAGE'				=> $this->options['message'],
			'PAYPAL_ENABLED'				=> (!empty($this->config['donations_paypal_email'])) ? true : false,
			'BITCOIN_ENABLED'				=> (!empty($bitcoin['key']) && !empty($bitcoin['secret'])) ? true : false,
		 ));

		 // Set up Navlinks
		$this->template->assign_block_vars('navlinks', array(
			'FORUM_NAME' 	=> $this->user->lang('DONATIONS'),
			'U_VIEW_FORUM'	=> $this->helper->route('sitesplat_donations_controller', array('route' => 'index.html')),
		));

		return $this->helper->render('donations.html', $this->user->lang('DONATIONS'));
	}
}
