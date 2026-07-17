Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\donations/acp/donations_module.php" "[FORUM_EXT]/sitesplat\\donations/acp/donations_module.php"
--- "[ORIGINAL]/sitesplat\\donations/acp/donations_module.php"
+++ "[FORUM_EXT]/sitesplat\\donations/acp/donations_module.php"
@@ -241,7 +241,7 @@ class donations_module
 							'PP_TRANSACTION'	=> $row['txn_id'],
 							'AMOUNT'        	=> number_format($row['mc_gross'], 2),
 							'STATUS'			=> $row['payment_status'],
-							'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&amp;user_id=' . $row['user_id'] . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
+							'U_PAYMENT_STATUS'	=> $this->u_action . '&amp;user_id=' . $row['user_id'] . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
 							'TIME'           	=> $user->format_date($row['payment_date']),
 						));
 						$total_amount += ($row['payment_status'] == 'Completed' || $row['payment_status'] == 'Expired') ? $row['mc_gross'] : 0;
@@ -294,7 +294,7 @@ class donations_module
 							'PP_TRANSACTION'	=> $row['txn_id'],
 							'AMOUNT'        	=> number_format($row['mc_gross'], 2),
 							'STATUS'			=> $row['payment_status'],
-							'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
+							'U_PAYMENT_STATUS'	=> $this->u_action . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
 							'TIME'           	=> $user->format_date($row['payment_date']),
 						));
 					}
diff --git "[ORIGINAL]/sitesplat\\donations/adm/style/acp_donations.html" "[FORUM_EXT]/sitesplat\\donations/adm/style/acp_donations.html"
--- "[ORIGINAL]/sitesplat\\donations/adm/style/acp_donations.html"
+++ "[FORUM_EXT]/sitesplat\\donations/adm/style/acp_donations.html"
@@ -126,7 +126,7 @@
 			<td><a href="mailto:{donations.EMAIL}?SUBJECT=Donation">{donations.EMAIL}</a></td>
 			<td>{donations.PP_TRANSACTION}</td>
 			<td>{DONATIONS_CURRENCY} {donations.AMOUNT}</td>
-			<td style="text-align:center;"><a href="#p{donations.ID}" id="status{donations.ID}" class="change_status" data-options="url={donations.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{donations.STATUS}</a></td>
+			<td style="text-align:center;"><a href="#p{donations.ID}" id="status{donations.ID}" class="change_status" data-options="{donations.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{donations.STATUS}</a></td>
 			<td>{donations.TIME}</td>
 		</tr>
 	<!-- END donations -->
@@ -169,7 +169,7 @@
 			<td style="text-align:center;"><i class="fa {transactions.PAYMENT_TYPE}" aria-hidden="true"></i></td>
 			<td>{transactions.PP_TRANSACTION}</td>
 			<td>{DONATIONS_CURRENCY} {transactions.AMOUNT}</td>
-			<td style="text-align:center;"><a href="#p{transactions.ID}" id="status{transactions.ID}" class="change_status" data-options="url={transactions.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{transactions.STATUS}</a></td>
+			<td style="text-align:center;"><a href="#p{transactions.ID}" id="status{transactions.ID}" class="change_status" data-options="{transactions.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{transactions.STATUS}</a></td>
 			<td>{transactions.TIME}</td>
 		</tr>
 		<!-- END transactions -->
diff --git "[ORIGINAL]/sitesplat\\donations/controller/donation.php" "[FORUM_EXT]/sitesplat\\donations/controller/donation.php"
--- "[ORIGINAL]/sitesplat\\donations/controller/donation.php"
+++ "[FORUM_EXT]/sitesplat\\donations/controller/donation.php"
@@ -236,7 +236,7 @@ class donation
 		}
 
 		$this->user->add_lang_ext('sitesplat/donations', 'common');
-		$currency_symbol = $this->manager->currency(0, $this->config['donations_currency']);
+		$currency_symbol = $this->manager->currency('', $this->config['donations_currency']);
 		$donationtxt = explode("\n", $this->config_text->get('donations_text'));
 
 		$amounts = json_decode($this->config['donations_amounts'], true);
@@ -252,12 +252,13 @@ class donation
 
 		if ($this->options['list'])
 		{
-			$sql = 'SELECT u.user_id, u.username, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, d.custom, d.mc_gross
+			$sql = 'SELECT u.user_id, u.username, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, d.custom, d.mc_gross, d.payment_date
 					FROM ' .$this->donation_table .' d
 					LEFT JOIN ' . USERS_TABLE . " u ON u.user_id = d.user_id
 					WHERE d.payment_status = 'Completed'
-					ORDER bY payment_date DESC
-					LIMIT 5";
+					AND d.payment_date >= UNIX_TIMESTAMP(DATE_SUB( CURDATE(), INTERVAL 3 MONTH)) 
+					ORDER BY d.payment_date DESC
+					LIMIT 20";
 			$result = $this->db->sql_query($sql);
 			while ($row = $this->db->sql_fetchrow($result))
 			{
diff --git "[ORIGINAL]/sitesplat\\donations/controller/manager.php" "[FORUM_EXT]/sitesplat\\donations/controller/manager.php"
--- "[ORIGINAL]/sitesplat\\donations/controller/manager.php"
+++ "[FORUM_EXT]/sitesplat\\donations/controller/manager.php"
@@ -260,7 +260,7 @@ class manager
 		$currencies['VND'] = array('&#8363;', 'Vietnamese dong');
 		$currencies['YER'] = array('&#8355;', 'Yemeni rial');
 
-		if ($select == '')
+		if (!$select)
 		{
 			$option = $currencies[$currency][0];
 		} else
diff --git "[FORUM_EXT]/sitesplat\\donations/diff_full.tmp" "[FORUM_EXT]/sitesplat\\donations/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\donations/diff_full.tmp"
@@ -0,0 +1,717 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/acp/donations_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/acp/donations_module.php"
+index 605d63ed6..1da699119 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/acp/donations_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/acp/donations_module.php"
+@@ -241,7 +241,7 @@ class donations_module
+ 							'PP_TRANSACTION'	=> $row['txn_id'],
+ 							'AMOUNT'        	=> number_format($row['mc_gross'], 2),
+ 							'STATUS'			=> $row['payment_status'],
+-							'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&amp;user_id=' . $row['user_id'] . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
++							'U_PAYMENT_STATUS'	=> $this->u_action . '&amp;user_id=' . $row['user_id'] . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
+ 							'TIME'           	=> $user->format_date($row['payment_date']),
+ 						));
+ 						$total_amount += ($row['payment_status'] == 'Completed' || $row['payment_status'] == 'Expired') ? $row['mc_gross'] : 0;
+@@ -294,7 +294,7 @@ class donations_module
+ 							'PP_TRANSACTION'	=> $row['txn_id'],
+ 							'AMOUNT'        	=> number_format($row['mc_gross'], 2),
+ 							'STATUS'			=> $row['payment_status'],
+-							'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
++							'U_PAYMENT_STATUS'	=> $this->u_action . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
+ 							'TIME'           	=> $user->format_date($row['payment_date']),
+ 						));
+ 					}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/adm/style/acp_donations.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/adm/style/acp_donations.html"
+index 7b1a83a73..4cb7dc91e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/adm/style/acp_donations.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/adm/style/acp_donations.html"
+@@ -126,7 +126,7 @@
+ 			<td><a href="mailto:{donations.EMAIL}?SUBJECT=Donation">{donations.EMAIL}</a></td>
+ 			<td>{donations.PP_TRANSACTION}</td>
+ 			<td>{DONATIONS_CURRENCY} {donations.AMOUNT}</td>
+-			<td style="text-align:center;"><a href="#p{donations.ID}" id="status{donations.ID}" class="change_status" data-options="url={donations.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{donations.STATUS}</a></td>
++			<td style="text-align:center;"><a href="#p{donations.ID}" id="status{donations.ID}" class="change_status" data-options="{donations.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{donations.STATUS}</a></td>
+ 			<td>{donations.TIME}</td>
+ 		</tr>
+ 	<!-- END donations -->
+@@ -169,7 +169,7 @@
+ 			<td style="text-align:center;"><i class="fa {transactions.PAYMENT_TYPE}" aria-hidden="true"></i></td>
+ 			<td>{transactions.PP_TRANSACTION}</td>
+ 			<td>{DONATIONS_CURRENCY} {transactions.AMOUNT}</td>
+-			<td style="text-align:center;"><a href="#p{transactions.ID}" id="status{transactions.ID}" class="change_status" data-options="url={transactions.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{transactions.STATUS}</a></td>
++			<td style="text-align:center;"><a href="#p{transactions.ID}" id="status{transactions.ID}" class="change_status" data-options="{transactions.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{transactions.STATUS}</a></td>
+ 			<td>{transactions.TIME}</td>
+ 		</tr>
+ 		<!-- END transactions -->
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/controller/donation.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/controller/donation.php"
+index 8ab18e449..59fde58c7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/controller/donation.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/controller/donation.php"
+@@ -236,7 +236,7 @@ class donation
+ 		}
+ 
+ 		$this->user->add_lang_ext('sitesplat/donations', 'common');
+-		$currency_symbol = $this->manager->currency(0, $this->config['donations_currency']);
++		$currency_symbol = $this->manager->currency('', $this->config['donations_currency']);
+ 		$donationtxt = explode("\n", $this->config_text->get('donations_text'));
+ 
+ 		$amounts = json_decode($this->config['donations_amounts'], true);
+@@ -252,12 +252,13 @@ class donation
+ 
+ 		if ($this->options['list'])
+ 		{
+-			$sql = 'SELECT u.user_id, u.username, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, d.custom, d.mc_gross
++			$sql = 'SELECT u.user_id, u.username, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, d.custom, d.mc_gross, d.payment_date
+ 					FROM ' .$this->donation_table .' d
+ 					LEFT JOIN ' . USERS_TABLE . " u ON u.user_id = d.user_id
+ 					WHERE d.payment_status = 'Completed'
+-					ORDER bY payment_date DESC
+-					LIMIT 5";
++					AND d.payment_date >= UNIX_TIMESTAMP(DATE_SUB( CURDATE(), INTERVAL 3 MONTH)) 
++					ORDER BY d.payment_date DESC
++					LIMIT 20";
+ 			$result = $this->db->sql_query($sql);
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
+@@ -266,7 +267,7 @@ class donation
+ 					'AVATAR'	=> (($row['user_avatar']) ?
+ 									 str_replace(array('<img', './../../'), array('<img class="avatar"', './'), phpbb_get_user_avatar(
+ 										array('avatar'			=> $row['user_avatar'],
+-                                              'user_id'         => $row['user_id'],
++											  'user_id'         => $row['user_id'],
+ 											  'avatar_type'		=> $row['user_avatar_type'],
+ 											  'avatar_width'	=> $row['user_avatar_width'],
+ 											  'avatar_height'	=> $row['user_avatar_height']), $row['username'])) :
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/controller/manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/controller/manager.php"
+index 0a21e564a..aee87fe56 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/controller/manager.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/controller/manager.php"
+@@ -260,7 +260,7 @@ class manager
+ 		$currencies['VND'] = array('&#8363;', 'Vietnamese dong');
+ 		$currencies['YER'] = array('&#8355;', 'Yemeni rial');
+ 
+-		if ($select == '')
++		if (!$select)
+ 		{
+ 			$option = $currencies[$currency][0];
+ 		} else
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/diff_full.tmp"
+new file mode 100644
+index 000000000..f079dee8d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/diff_full.tmp"
+@@ -0,0 +1,47 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/acp/donations_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/acp/donations_module.php"
++index 605d63ed6..1da699119 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/acp/donations_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/acp/donations_module.php"
++@@ -241,7 +241,7 @@ class donations_module
++ 							'PP_TRANSACTION'	=> $row['txn_id'],
++ 							'AMOUNT'        	=> number_format($row['mc_gross'], 2),
++ 							'STATUS'			=> $row['payment_status'],
++-							'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&amp;user_id=' . $row['user_id'] . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
+++							'U_PAYMENT_STATUS'	=> $this->u_action . '&amp;user_id=' . $row['user_id'] . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
++ 							'TIME'           	=> $user->format_date($row['payment_date']),
++ 						));
++ 						$total_amount += ($row['payment_status'] == 'Completed' || $row['payment_status'] == 'Expired') ? $row['mc_gross'] : 0;
++@@ -294,7 +294,7 @@ class donations_module
++ 							'PP_TRANSACTION'	=> $row['txn_id'],
++ 							'AMOUNT'        	=> number_format($row['mc_gross'], 2),
++ 							'STATUS'			=> $row['payment_status'],
++-							'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
+++							'U_PAYMENT_STATUS'	=> $this->u_action . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
++ 							'TIME'           	=> $user->format_date($row['payment_date']),
++ 						));
++ 					}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/adm/style/acp_donations.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/adm/style/acp_donations.html"
++index 7b1a83a73..4cb7dc91e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/adm/style/acp_donations.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/adm/style/acp_donations.html"
++@@ -126,7 +126,7 @@
++ 			<td><a href="mailto:{donations.EMAIL}?SUBJECT=Donation">{donations.EMAIL}</a></td>
++ 			<td>{donations.PP_TRANSACTION}</td>
++ 			<td>{DONATIONS_CURRENCY} {donations.AMOUNT}</td>
++-			<td style="text-align:center;"><a href="#p{donations.ID}" id="status{donations.ID}" class="change_status" data-options="url={donations.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{donations.STATUS}</a></td>
+++			<td style="text-align:center;"><a href="#p{donations.ID}" id="status{donations.ID}" class="change_status" data-options="{donations.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{donations.STATUS}</a></td>
++ 			<td>{donations.TIME}</td>
++ 		</tr>
++ 	<!-- END donations -->
++@@ -169,7 +169,7 @@
++ 			<td style="text-align:center;"><i class="fa {transactions.PAYMENT_TYPE}" aria-hidden="true"></i></td>
++ 			<td>{transactions.PP_TRANSACTION}</td>
++ 			<td>{DONATIONS_CURRENCY} {transactions.AMOUNT}</td>
++-			<td style="text-align:center;"><a href="#p{transactions.ID}" id="status{transactions.ID}" class="change_status" data-options="url={transactions.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{transactions.STATUS}</a></td>
+++			<td style="text-align:center;"><a href="#p{transactions.ID}" id="status{transactions.ID}" class="change_status" data-options="{transactions.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{transactions.STATUS}</a></td>
++ 			<td>{transactions.TIME}</td>
++ 		</tr>
++ 		<!-- END transactions -->
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/controller/donation.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/controller/donation.php"
++index 8ab18e449..59fde58c7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/en/common.php"
+index caaa57a43..7376c41ec 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/language/en/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/en/common.php"
+@@ -31,10 +31,10 @@ $lang = array_merge($lang, array(
+     'DONATIONS_DATE'				=> 'Date',
+ 	'DONATIONS_CUSTOM_MESSAGE'		=> 'Leave a message',
+     'DONATIONS_SUCCESS' 			=> 'Donation was successful',
+-    'DONATIONS_CANCELLED' 			=> 'Donation was cancelled',
++    'DONATIONS_CANCELLED' 			=> 'Donation was canceled',
+     'DONATIONS_ERROR' 				=> 'There was an error in the donation',
+ 	
+-	'DONATIONS_THANK_YOU'			=> 'Thank-you for supporting our community!',
++	'DONATIONS_THANK_YOU'			=> 'Thank-you for thinking on supporting our community!',
+ 	'DONATIONS_PREMIUM'				=> 'The donors with an amount of <strong>%s</strong> or more are added to a special group with special forum benefits.<br />Custom rank, color and much more!',
+ 	'DONATIONS_MESSAGE'				=> 'Participate in our success and together let\'s make our community even better',
+ 	'DONATION_STEP_1'				=> '1',
+@@ -61,7 +61,7 @@ $lang = array_merge($lang, array(
+ 	'CONTINUE_ON_PAYPAL'		    => 'PayPal',
+ 	'CONTINUE_ON_BITCOINS'		    => 'Bitcoin',
+ 	'CONNECTING_ON_PAYPAL'		    => 'Connecting with PayPal',
+-	'BBDONATION_COPY'		        => 'BBdonation Built With',
++	'BBDONATION_COPY'		        => 'Donation Built With',
+ 	'SITESPLAT_EXT_COPY'	        => 'Professional Web Development and Premium Themes',
+ 	
+ 	'UCP_DONATION_TITLE'			=> 'Donation overview',
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/pt/common.php"
+new file mode 100644
+index 000000000..6f7a3318f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/pt/common.php"
+@@ -0,0 +1,70 @@
++<?php
++/**
++*
++* @package BBdonations
++* @copyright (c) 2016 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if ( empty($lang) || !is_array($lang) )
++{
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'DONATIONS'						=> 'Donativos',
++	'DONATION'						=> 'Donativo',
++    'DONATIONS_INDEX'				=> 'Donativos',
++	'DONATION_DISABLED'				=> 'Os donativos encontram-se desativados',
++	'DONATIONS_DONATE'  			=> 'Donativo',
++    'DONATIONS_CONTACT_PAYPAL'		=> 'Por favor, aguarda...',
++    'DONATIONS_AMOUNT'  			=> 'Montante',
++    'DONATIONS_DATE'				=> 'Data',
++	'DONATIONS_CUSTOM_MESSAGE'		=> 'Deixa uma mensagem',
++    'DONATIONS_SUCCESS' 			=> 'O donativo foi efetuado com sucesso',
++    'DONATIONS_CANCELLED' 			=> 'O donativo foi cancelado',
++    'DONATIONS_ERROR' 				=> 'Ocorreu um erro com o donativo',
++	
++	'DONATIONS_THANK_YOU'			=> 'Obrigado por desejares contribuir para a nossa comunidade!',
++	'DONATIONS_PREMIUM'				=> 'Os utilizadores que doem um montante igual ou acima de <strong>%s</strong>, são adicionados a um grupo especial que trará diversos benefícios!',
++	'DONATIONS_MESSAGE'				=> 'Vamos juntos tornar esta comunidade ainda melhor',
++	'DONATION_STEP_1'				=> '1',
++	'DONATION_STEP_2'				=> '2',
++	'DONATION_STEP_3'				=> '3',
++	'DONATION_STEP_4'				=> '4',
++	
++	'DONATION_STEP_1_INNER'		    => 'Seleciona um montante',
++	'DONATION_STEP_2_INNER'		    => 'Continuar para o PayPal',
++    'DONATION_STEP_3_INNER'	        => 'Regressar ao fórum',
++	'DONATION_STEP_4_INNER'		    => 'Obrigado',
++	
++	'DONATION_DEPOSIT_DISCLAIMER'   => '**Paga com segurança com o PayPal',
++	'DONATION_MY_CREDITS'		    => 'Donativos efetuados',
++	
++	'DONATIONS_NOGUESTS'		    => 'O Fórum precisa que estejas com login efetuado para proceder com o donativo',
++	'DONATIONS_TRANSACTION'		    => 'Transações',
++	'DONATIONS_TRAN'		        => 'Transação ',
++	'DONATIONS_SENDER'		        => 'Doador',
++	'DONATIONS_DIGIT'		        => '.00',
++	'DONATIONS_DONORS'		        => 'Últimos Donativos',
++	'DONATIONS_MSG_PLACEHOLDER'		=> 'Mensagem curta opcional...',
++	
++	'CONTINUE_ON_PAYPAL'		    => 'PayPal',
++	'CONTINUE_ON_BITCOINS'		    => 'Bitcoin',
++	'CONNECTING_ON_PAYPAL'		    => 'A conectar com o PayPal',
++	'BBDONATION_COPY'		        => 'Sistema de Donativos Feito com',
++	'SITESPLAT_EXT_COPY'	        => '',
++	
++	'UCP_DONATION_TITLE'			=> 'Donativos - Geral',
++	'UCP_DONATIONS_EXPLAIN'         => 'Log dos teus donativos',
++	'DONATION_ACTIVITY_UCP_EMPTY'   => 'Não tem donativos efetuados'
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/pt/info_acp_donations.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/pt/info_acp_donations.php"
+new file mode 100644
+index 000000000..eeaf4336a
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/pt/info_acp_donations.php"
+@@ -0,0 +1,106 @@
++<?php
++/**
++*
++* @package BBdonations
++* @copyright (c) 2016 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if ( empty($lang) || !is_array($lang) )
++{
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'ACP_DONATIONS'  				=> 'BBDonations',
++	'ACP_DONATIONS_EXPLAIN'			=> 'Donations settings for your website. Configure the desired settings, fill in the PayPal info and the Bitcoin info to maximize your donation results.',
++	'ACP_DONATIONS_INDEX_TITLE'		=> 'Config',
++	'ACP_DONATIONS_PAYPAL_EMAIL'	=> 'Paypal email',
++	'ACP_DONATIONS_PAYPAL_EXPLAIN'	=> 'Enter your PayPal email here. (leave empty to disable donation method) You might need to use PayPal business account as the IPN system might requires it to work correctly.<br /> For more information visit: <a href="https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNSetup/#id089EG030E5Z">PayPal IPN setup</a>',
++	'ACP_DONATIONS_OPTIONS'			=> 'Donation options',
++	'ACP_DONATIONS_OPTIONS_EXPLAIN'	=> 'The following options are available: <br /> <strong>Sandbox Mode:</strong> Allows the sandbox mode (For both Bitcoin and PayPal) which is useful to test the donations. Please beware that Coinbase sandbox is not reliable and therefore a real account should be used to run tests. The easiest way to test it is to use a smartphone app and donate back and forth between your forum and the app. Use the following app for android phones: <a href="https://airbitz.co/af/DJM" target="blank">AirBitz</a> <br /> <strong>Enable message:</strong> This enables the user to leave a short message with the donation <br /> <strong>Show donors:</strong> Enables the last recent donors',
++	'ACP_DONATIONS_SANDBOX'			=> 'Sandbox mode',
++	'ACP_DONATIONS_MESSAGE'			=> 'Enable message',
++	'ACP_DONATIONS_LIST'			=> 'Show donors',
++	'ACP_DONATIONS_BITCOIN'			=> 'Bitcoin',
++	'ACP_DONATIONS_BITCOIN_EXPLAIN' => 'Enter Your coinbase API Key and API Secret here (leave empty to disable donation method). <br /> Follow <strong>EXACTLY</strong> (links open on a new tab) these steps to successfully enable Bitcoin donation: <br /><strong>STEP1:</strong> <a href="https://www.coinbase.com/join/54c7b129d41344b592000006" target="_blank">Register a Coinbase account</a> <br /><strong>STEP2:</strong> <a href="https://www.coinbase.com/merchant_profiles" target="_blank">Setup the merchant page profile</a> <br /><strong>STEP3:</strong> <a href="https://www.coinbase.com/merchant_settings" target="_blank">Setup the merchant settings</a> <br /><strong>STEP4:</strong> In the notification URL option under Merchant settings (STEP3), enter your board URL like this:<br /> <code>http://www.my_board_url.com/app.php/donation/index.html?mode=notify_bitcoin</code> (Where "my_board_url.com" is your real board URL) <br /><strong>STEP5:</strong> Register the the Oauth application here: <a href="https://www.coinbase.com/settings/api" target="_blank">Oauth App</a>. Click on the button "+ New API key" then under "Accounts" checkmark "My Wallet (Primary)", under "Permissions" Click on select all and finally under "Notifications" enter the same URL as described on STEP4. Now click "Create" Button and get your API Key and API Secret to be enter here on your right. <br /><strong>STEP6:</strong> Congrats! Good luck with your donation campaign!',
++	'ACP_DONATIONS_BITCOIN_KEY'		=> 'API Key',
++	'ACP_DONATIONS_BITCOIN_SECRET'	=> 'API Secret',
++	'ACP_DONATIONS_AMOUNTS'			=> 'Amounts',
++	'ACP_DONATIONS_TEXT'			=> 'Text',
++	'ACP_DONATIONS_SYMBOL'			=> 'Symbol',
++	'ACP_DONATIONS_ADD_ROW'			=> 'Add another row',
++	'ACP_DONATIONS_DELL_ROW'		=> 'Delete last row',
++	'ACP_DONATIONS_AMOUNTS_EXPLAIN'	=> 'The following options are available: (Use "%s" as a placeholder to fill in automatically the amount and currency in your text field.) <br /><strong>Amount:</strong> Set the donation amount <br /><strong>Text:</strong> Enter your custom text for the donation amount goal <br /><strong>Symbol:</strong> Select a font awesome symbol for each goal eantered.', 
++	'ACP_DONATIONS_STATUS'			=> 'Status',
++	'ACP_DONATIONS_GROUP'			=> 'Auto Group',
++	'ACP_DONATIONS_GROUP_EXPLAIN'	=> 'The following options are available for the AutoGroup settings: <br /><strong>Days:</strong> time expressed in days for the user to stay on X group. (No time disables fallback for this group) <br /> <strong>Amount:</strong> min currency (donation) value for the AutoGroup to be triggered. (0 disables AutoGroup) <br /><strong>Group:</strong> Group for the user to be moved into when the min. amount is triggered <br /><strong>Group Default:</strong> Set the group to default for the user (Checkmark to set as default)',
++	'ACP_DONATIONS_GROUP_DEF'		=> 'Group default',
++	'ACP_DONATIONS_GROUPS'		    => 'Group',
++	'ACP_DONATIONS_STATS'  			=> 'Statistics',
++	'ACP_DONATIONS_TIME'			=> 'Date',
++	'ACP_DONATIONS_TOTAL'			=> 'Sum of all donations',
++	'ACP_DONATIONS_ADDRESS'			=> 'Donator\'s address',
++	'ACP_DONATIONS_COUNTRY'			=> 'Donator\'s country',
++	'ACP_DONATIONS_TRANSACTIONS'  	=> 'Transactions',
++	'ACP_DONATIONS_FALLBACK'  		=> 'Fallback Group',
++	'ACP_DONATIONS_FALLBACK_EXPLAIN'=> 'A Group fallback for the user to go back to if the time (in Days) is exceeded.<br />No group disables this function.',
++	'ACP_DONATIONS_AMOUNT'			=> 'Amount',
++	
++	'ACP_DONATIONS_DAY_STAY'		=> 'Day to stay in this group',
++	'ACP_DONATIONS_CHANGE_STATUS'	=> 'Change status',
++	'ACP_DONATIONS_MAX_AMO'			=> 'Max amount for this group',
++	
++	'ACP_DONATIONS_DAYS'			=> 'Days',
++	'ACP_DONATIONS_TRANSACTION'		=> 'Transaction id',
++	'ACP_DONATIONS_CURRENCY'		=> 'Currency code',
++	'ACP_DONATIONS_CURRENCY_EXPLAIN'=> 'Currency code follows the allowed <a href="https://developer.paypal.com/docs/classic/api/currency_codes/" target="_blank">Paypal Multiple Currencies</a> standards. <br /> Make sure the currency you are going to use is enabled on your PayPal account. <br />If the currency is not supported on your PayPal acccount the transactions will be returned as "Not verified" or "Pending".',
++	'ACP_DONATIONS_USERNAME'		=> 'Username',
++	'DONATIONS_NOTICE'				=> '<div class="phpinfo"><p>The settings for this extensions are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
++	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++	
++	
++	'SITESPLAT_COM'		        => 'https://sitesplat.com',
++	'SITESPLAT_COPY'		    => '&#169; SiteSplat',
++	'LICENSE_INFO'		        => 'Proprietary - SiteSplat All rights reserved',
++	'EXTENSION_DEVELOPER'	    => 'Developer',
++	'ACP_NOTICE_CLOSE'			=> 'Close',
++	'ACP_DONATIONS_VERSION'     => '1.0.10',
++	'ACP_LOADING'		        => 'Loading... Hold on',
++	
++	'EXT_BBD_DESCRIPTION_PAGE'	=> 'A kick-ass donation extension for the phpBB board running sitesplat themes. Many modern and useful options included PayPal IPN and Bitcoin API.',
++	'EXT_BBD_TASKS_1'			=> 'AutoGroup',
++	'EXT_BBD_TASKS_2'			=> 'Fully editable donation scopes',
++	'EXT_BBD_TASKS_3'			=> 'PayPal IPN',
++	'EXT_BBD_TASKS_4'			=> 'Bitcoins support',
++	'EXT_BBD_TASKS_5'			=> 'phpBB 3.2 ready',
++	'EXT_BBD_TASKS_6'			=> 'Checkout the other premium compatible addons on <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
++	
++));
++
++// Description of Donations extension
++$lang = array_merge($lang, array(
++	'DESCRIPTION_PAGE'		=> 'Description',
++	'DESCRIPTION_NOTICE'	=> 'Extension note',
++	'ext_details' => array(
++		'details' => array(
++			'DESCRIPTION_1'	=> 'Overview of donations',
++			'DESCRIPTION_2'	=> 'Paypal / Bitcoins API',
++			'DESCRIPTION_3'	=> 'Autogroups',
++			'DESCRIPTION_4'	=> 'Set back to standard group after x amount of time',
++			'DESCRIPTION_5'	=> 'Guest can also donate',
++		),
++		'note' => array(
++			'NOTICE_1'		=> 'phpBB 3.2 ready'
++		)
++	)
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/styles/FLATBOOTS/template/donations.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/styles/FLATBOOTS/template/donations.html"
+index 688704ea7..8958a684f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/styles/FLATBOOTS/template/donations.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/styles/FLATBOOTS/template/donations.html"
+@@ -1,104 +1,130 @@
+ <!-- INCLUDE overall_header.html -->
+-<div class="side-segment"><h3>{L_DONATIONS}</h3></div>
+-<div class="clearfix">
+- <div class="donation-actions">
+-<script>
+-    var vals = [<!-- BEGIN amounts -->{amounts.AMOUNT}<!-- IF not amounts.S_LAST_ROW -->,<!-- ENDIF --><!-- END amounts -->];
++<div class="side-segment">
++	<h3>{L_DONATIONS}</h3>
++</div>
++<!-- IF S_USER_LOGGED_IN -->
++<script async
++  src="https://js.stripe.com/v3/buy-button.js">
+ </script>
+- 	<form action="<!-- IF SUCCESS or ERROR -->{U_INDEX}<!-- ELSE -->{U_DONATE}<!-- ENDIF -->" method="post">
+-        <h2>{L_DONATIONS_THANK_YOU}</h2>
+-        <!-- IF DONATIONS_PREMIUM --><p class="donation-premium">{DONATIONS_PREMIUM}</p><!-- ENDIF -->
+-        <div id="donationmessage">
+-            <h3>{L_DONATIONS_MESSAGE}</h3>
+-        </div>
+-        <div id="donationicons">
+-        <!-- BEGIN amounts -->
+-            <span<!-- IF amounts.S_ROW_COUNT == 1 --> class="selected"<!-- ENDIF --> title="{DONATIONS_CURRENCY_SYMBOL}&nbsp;{amounts.AMOUNT}{L_DONATIONS_DIGIT}">{DONATIONS_CURRENCY_SYMBOL}&nbsp;{amounts.AMOUNT}{L_DONATIONS_DIGIT}</span>
+-            <!-- IF amounts.TXT --><p class="hidden-xs">{amounts.TXT}</p><!-- ENDIF -->
+-        <!-- END amounts -->
+-        </div>	
+-        <input type="range" min="0" max="{STEPS}" step="1" value="1" id="donationvalue">
+ 
+-	<!-- IF S_USER_LOGGED_IN -->  
+-        <div id="submission">
+-			<div class="input-group">
+-			  <span class="input-group-addon">
+-				<output for="donationvalue">
+-					 <span>{DONATIONS_CURRENCY_SYMBOL}</span>
+-					 <span id="donationoutput"><script>document.write(vals[1])</script>{L_DONATIONS_DIGIT}</span>
+-				</output>
+-			  </span>
+-			  <!-- IF ENABLE_MESSAGE -->
+-			    <input id="custom_message" type="text" value="" name="custom" class="form-control dcount" placeholder="{L_DONATIONS_MSG_PLACEHOLDER}" autocomplete="off">
+-			  <!-- ENDIF -->	
+-			  <span class="input-group-btn">
+-			    <input type="hidden" name="amount" id="amount" value="">
+-				<!-- IF BITCOIN_ENABLED --><button class="btn btn-bbdonation" name="bitcoin" type="submit" value="" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><span class="bitcoin-logo"></span>&nbsp;{L_CONTINUE_ON_BITCOINS}</button><!-- ENDIF -->
+-				<!-- IF PAYPAL_ENABLED --><button class="btn btn-bbdonation" type="submit" value="" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><span class="paypal-logo"></span>&nbsp;{L_CONTINUE_ON_PAYPAL}</button><!-- ENDIF -->
+-			  </span>
+-			</div>	
+-        </div>
+-        <script>
+-            document.getElementById('amount').value=vals[1];
+-        </script>
+-	<!-- ELSE -->
+-      	<p>{L_DONATIONS_NOGUESTS}</p>
+-	<!-- ENDIF -->	
++	<div class="clearfix">
++		<div class="donation-actions">
++			<script>
++				var vals = [<!-- BEGIN amounts -->{amounts.AMOUNT}<!-- IF not amounts.S_LAST_ROW -->,<!-- ENDIF --><!-- END amounts -->];
++			</script>
++			<form action="<!-- IF SUCCESS or ERROR -->{U_INDEX}<!-- ELSE -->{U_DONATE}<!-- ENDIF -->" method="post">
++				<h2>{L_DONATIONS_THANK_YOU}</h2>
++				<!-- IF DONATIONS_PREMIUM -->
++				<p class="donation-premium">{DONATIONS_PREMIUM}</p><!-- ENDIF -->
++				<div id="donationmessage">
++					<h3>{L_DONATIONS_MESSAGE}</h3>
++				</div>
++				<div id="donationicons">
++					<!-- BEGIN amounts -->
++					<span<!-- IF amounts.S_ROW_COUNT==1 --> class="selected"<!-- ENDIF --> title="{DONATIONS_CURRENCY_SYMBOL}&nbsp;{amounts.AMOUNT}{L_DONATIONS_DIGIT}">{DONATIONS_CURRENCY_SYMBOL}&nbsp;{amounts.AMOUNT}{L_DONATIONS_DIGIT}</span>
++					<!-- IF amounts.TXT -->
++						<p>
++							<b class="hidden-xs">{amounts.TXT}</b>
++							<small class="visible-xs">{amounts.TXT}</small>
++						</p>
++					<!-- ENDIF -->
++						<!-- END amounts -->
++				</div>
++				<input type="range" min="0" max="{STEPS}" step="1" value="1" id="donationvalue">
++
++				
++				<div id="submission">
++					<div class="input-group">
++						<span class="input-group-addon">
++							<output for="donationvalue">
++								<span>{DONATIONS_CURRENCY_SYMBOL}</span>
++								<span id="donationoutput">
++									<script>document.write(vals[1])</script>{L_DONATIONS_DIGIT}
++								</span>
++							</output>
++						</span>
++						<!-- IF ENABLE_MESSAGE -->
++						<input id="custom_message" type="text" value="" name="custom" class="form-control dcount" placeholder="{L_DONATIONS_MSG_PLACEHOLDER}" autocomplete="off">
++						<!-- ENDIF -->
++						<span class="input-group-btn">
++							<input type="hidden" name="amount" id="amount" value="">
++							<!-- IF BITCOIN_ENABLED --><button class="btn btn-bbdonation" name="bitcoin" type="submit" value="" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><span class="bitcoin-logo"></span>&nbsp;{L_CONTINUE_ON_BITCOINS}</button><!-- ENDIF -->
++							<!-- IF PAYPAL_ENABLED --><button class="btn btn-bbdonation" type="submit" value="" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><span class="paypal-logo"></span>&nbsp;{L_CONTINUE_ON_PAYPAL}</button><!-- ENDIF -->
++						</span>
++					</div>
++				</div>
++				<script>
++					document.getElementById('amount').value = vals[1];
++				</script>
++			</form>
++			<div class="space10"></div>
++			<p class="text-muted">{L_DONATION_DEPOSIT_DISCLAIMER}</p>
++		</div>
++		<div class="text-right"><small>{L_BBDONATION_COPY}</small>&nbsp;<i class="fa fa-heart text-flatboots-red heart-ss pulse-ss"></i></div>
++	</div>
++
++
++	<div class="space10"></div>
++	<div class="space10"></div>
+ 	
+- 	</form>
+-	<div class="space10"></div><p class="text-muted">{L_DONATION_DEPOSIT_DISCLAIMER}</p>
+- </div>
+- <div class="text-right"><small>{L_BBDONATION_COPY}</small>&nbsp;<i class="fa fa-heart text-flatboots-red heart-ss pulse-ss"></i>&nbsp;<small>{L_BY}<a href="https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat" title="{L_SITESPLAT_EXT_COPY}" target="_blank">&nbsp;{L_SITESPLAT}</a></small></div>
+-</div> 
++	<div class="clearfix" id="donativo-alternativo">
++		<div class="donation-actions">
++		<p class="donation-premium">Donativo com Formas de Pagamento Alternativas</p>
++			<stripe-buy-button
++			  buy-button-id="buy_btn_1SywVYDyIaKunyHURBFSg3Fd"
++			  publishable-key="pk_live_51LWW6mDyIaKunyHU6XX0UewVkgUUzgkxRdIEHwfXFotxwROFdGpJvgRvB3WmLNftiUNOHsHheI7yfVEODlkAcoIY00PjLHM3Hd"
++			>
++			</stripe-buy-button>
++		</div>
++	</div>
+ 
+- 
+-<!-- IF .donors -->
++	<!-- IF .donors -->
+ 	<div class="space10"></div>
+-	  <div class="space10"></div>
+-    <div class="side-segment"><h3>{L_DONATIONS_DONORS}</h3></div>
++	<div class="space10"></div>
++	<div class="side-segment">
++		<h3>{L_DONATIONS_DONORS}</h3>
++	</div>
+ 	<div class="row">
+-	<div class="panel panel-default">
+-	 <div class="panel-body">
+-        <!-- BEGIN donors -->
+-		<div class="col-md-3 col-sm-4 col-xs-4">
+-        <figure class="member-info">{donors.AVATAR}
+-			<figcaption>
+-                  <h3>{donors.NAME}</h3>
+-				  <span>&nbsp;{donors.TXT}</span>
+-                  <a>{DONATIONS_CURRENCY_SYMBOL}&nbsp;{donors.AMOUNT}</a>
+-            </figcaption>
+-        </figure>
++		<div class="panel panel-default">
++			<div class="panel-body" style="display:flex;flex-wrap:wrap;">
++				<!-- BEGIN donors -->
++				<div class="col-md-3 col-sm-4 col-xs-4">
++					<figure class="member-info">{donors.AVATAR}
++						<figcaption>
++							<h3>{donors.NAME}</h3>
++							<span>&nbsp;{donors.TXT}</span>
++							<a>{DONATIONS_CURRENCY_SYMBOL}&nbsp;{donors.AMOUNT}</a>
++						</figcaption>
++					</figure>
++				</div>
++				<!-- END donors -->
++			</div>
+ 		</div>
+-        <!-- END donors -->
+-	 </div>	
+-    </div>
+ 	</div>
+-<!-- ENDIF -->  
++	<!-- ENDIF -->
+ 
+ 
+-<!-- IF DONATIONS_COINBASE_CODE -->
+-<div class="bitcoin_box">
+-      <iframe
+-		  id="{DONATIONS_COINBASE_CODE}"
+-		  src="{DONATIONS_COINBASE_URL}/checkouts/{DONATIONS_COINBASE_CODE}/inline"
+-		  style="width: 460px; height: 350px; box-shadow: 0 1px 3px rgba(0,0,0,0.25);"
+-		  allowtransparency="true"
+-		  frameborder="0">
+-      </iframe>
+-</div>  
+-<div class="darken_bitcoin"></div>
+-<!-- ENDIF -->
++	<!-- IF DONATIONS_COINBASE_CODE -->
++	<div class="bitcoin_box">
++		<iframe id="{DONATIONS_COINBASE_CODE}" src="{DONATIONS_COINBASE_URL}/checkouts/{DONATIONS_COINBASE_CODE}/inline" style="width: 460px; height: 350px; box-shadow: 0 1px 3px rgba(0,0,0,0.25);" allowtransparency="true" frameborder="0">
++		</iframe>
++	</div>
++	<div class="darken_bitcoin"></div>
++	<!-- ENDIF -->
+ 
+-<!-- IF NOTIFY_STATUS -->
+-<script>
+-    var info = '{L_INFORMATION}';
+-    var notify = '{NOTIFY_STATUS}';
+-</script>
+-<!-- INCLUDEJS @sitesplat_donations/js/notify_status.js -->
++	<!-- IF NOTIFY_STATUS -->
++	<script>
++		var info = '{L_INFORMATION}';
++		var notify = '{NOTIFY_STATUS}';
++	</script>
++	<!-- INCLUDEJS @sitesplat_donations/js/notify_status.js -->
++	<!-- ENDIF -->
++	<!-- IF ENABLE_MESSAGE -->
++	<!-- INCLUDEJS @sitesplat_donations/js/jquery.charactercounter.js -->
++	<!-- INCLUDEJS @sitesplat_donations/js/char.init.js -->
++	<!-- ENDIF -->
++	<!-- INCLUDEJS @sitesplat_donations/js/donations.js -->
++<!-- ELSE -->
++<p>{L_DONATIONS_NOGUESTS}</p>
+ <!-- ENDIF -->
+-<!-- IF ENABLE_MESSAGE -->
+-<!-- INCLUDEJS @sitesplat_donations/js/jquery.charactercounter.js -->
+-<!-- INCLUDEJS @sitesplat_donations/js/char.init.js -->
+-<!-- ENDIF -->	
+-<!-- INCLUDEJS @sitesplat_donations/js/donations.js -->
+ <!-- INCLUDE overall_footer.html -->
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+index c8239e3ca..29508e395 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+@@ -1,3 +1,4 @@
++
+ <!-- IF SCRIPT_NAME == "app/donation/index.html" -->
+ 	{% INCLUDECSS '@sitesplat_donations/donation.css' %}
+ <style>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/styles/FLATBOOTS/template/js/char.init.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/styles/FLATBOOTS/template/js/char.init.js"
+index 44a9a3c89..f911738af 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/styles/FLATBOOTS/template/js/char.init.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/styles/FLATBOOTS/template/js/char.init.js"
+@@ -1,30 +1,30 @@
+ head.ready(function () {
+-(function($) { // Avoid conflicts with other libraries
+-	'use strict';
+-	
+-	// some quick and simple tricks
+-	$("#custom_message").focusin(function() {
+-        $(".counter-pos").css("display","inline-block");
+-	});
+-	$("#custom_message").focusout(function() {
+-		$(".counter-pos").css("display","none");
+-	});
+-	
+-	// Fix the counter bug once exeeeded functions below is triggered and page reloaded keeping the btn disabled
+-	$( ".btn-bbdonation" ).prop( "disabled", false );
+-	
+-	$(".dcount").characterCounter({
+-        counterFormat: '%1/50',
+-		limit: 50,
+-		counterCssClass: 'counter-pos',
+-		counterExceededCssClass: 'exceeded',
+-		onExceed: function(count){
+-		   $('.btn-bbdonation').prop('disabled', true);
+-		},
+-		onDeceed: function(count){
+-		   $('.btn-bbdonation').prop('disabled', false);
+-		},
+-    });
+-	
+-})(jQuery); // Avoid conflicts with other libraries
+-});
+\ No newline at end of file
++	(function ($) {
++		// Avoid conflicts with other libraries
++		'use strict';
++
++		// some quick and simple tricks
++		$('#custom_message').focusin(function () {
++			$('.counter-pos').css('display', 'inline-block');
++		});
++		$('#custom_message').focusout(function () {
++			$('.counter-pos').css('display', 'none');
++		});
++
++		// Fix the counter bug once exeeeded functions below is triggered and page reloaded keeping the btn disabled
++		$('.btn-bbdonation').prop('disabled', false);
++
++		$('.dcount').characterCounter({
++			counterFormat: '%1/80',
++			limit: 80,
++			counterCssClass: 'counter-pos',
++			counterExceededCssClass: 'exceeded',
++			onExceed: function (count) {
++				$('.btn-bbdonation').prop('disabled', true);
++			},
++			onDeceed: function (count) {
++				$('.btn-bbdonation').prop('disabled', false);
++			},
++		});
++	})(jQuery); // Avoid conflicts with other libraries
++});
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/styles/FLATBOOTS/theme/donation.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/styles/FLATBOOTS/theme/donation.css"
+index 45966706f..7a230c930 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/styles/FLATBOOTS/theme/donation.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/styles/FLATBOOTS/theme/donation.css"
+@@ -389,9 +389,21 @@ input[type=range]::-ms-thumb:hover, input[type=range]::-ms-thumb:active {
+    
+    #donationmessage {
+     height: 100%; 
+-    min-height: 76px;
++    min-height: 110px;
++	margin-bottom: 24px;
+     }
+-	
++
++	#donationicons > span + p {
++		width: 100%;
++		position: relative;
++		margin-top: -64px;
++	}
++
++	#donationicons {
++	width: auto;
++	flex-wrap: wrap;
++	}
++
+ 	.member-info .avatar {
+     height: 40px;
+     max-width: 40px;
+@@ -404,7 +416,7 @@ input[type=range]::-ms-thumb:hover, input[type=range]::-ms-thumb:active {
+ }
+ 
+ @media (max-width: 468px) {
+-	
++
+ 	#submission .input-group {
+ 		display: block;
+ 	}
+@@ -424,7 +436,7 @@ input[type=range]::-ms-thumb:hover, input[type=range]::-ms-thumb:active {
+ 	#submission .form-control {
+        text-align: center;
+     }
+-	
++
+ }
+ 
+ .heart-ss {
+@@ -508,4 +520,4 @@ input[type=range]::-ms-thumb:hover, input[type=range]::-ms-thumb:active {
+  100% {
+    -ms-transform: scale(1);
+    transform: scale(1);
+- }
+\ No newline at end of file
++ }
diff --git "[FORUM_EXT]/sitesplat\\donations/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\donations/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\donations/diff_nospace.tmp"
@@ -0,0 +1,742 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/acp/donations_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/acp/donations_module.php"
+index 605d63ed6..1da699119 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/acp/donations_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/acp/donations_module.php"
+@@ -241,7 +241,7 @@ class donations_module
+ 							'PP_TRANSACTION'	=> $row['txn_id'],
+ 							'AMOUNT'        	=> number_format($row['mc_gross'], 2),
+ 							'STATUS'			=> $row['payment_status'],
+-							'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&amp;user_id=' . $row['user_id'] . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
++							'U_PAYMENT_STATUS'	=> $this->u_action . '&amp;user_id=' . $row['user_id'] . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
+ 							'TIME'           	=> $user->format_date($row['payment_date']),
+ 						));
+ 						$total_amount += ($row['payment_status'] == 'Completed' || $row['payment_status'] == 'Expired') ? $row['mc_gross'] : 0;
+@@ -294,7 +294,7 @@ class donations_module
+ 							'PP_TRANSACTION'	=> $row['txn_id'],
+ 							'AMOUNT'        	=> number_format($row['mc_gross'], 2),
+ 							'STATUS'			=> $row['payment_status'],
+-							'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
++							'U_PAYMENT_STATUS'	=> $this->u_action . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
+ 							'TIME'           	=> $user->format_date($row['payment_date']),
+ 						));
+ 					}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/adm/style/acp_donations.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/adm/style/acp_donations.html"
+index 7b1a83a73..4cb7dc91e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/adm/style/acp_donations.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/adm/style/acp_donations.html"
+@@ -126,7 +126,7 @@
+ 			<td><a href="mailto:{donations.EMAIL}?SUBJECT=Donation">{donations.EMAIL}</a></td>
+ 			<td>{donations.PP_TRANSACTION}</td>
+ 			<td>{DONATIONS_CURRENCY} {donations.AMOUNT}</td>
+-			<td style="text-align:center;"><a href="#p{donations.ID}" id="status{donations.ID}" class="change_status" data-options="url={donations.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{donations.STATUS}</a></td>
++			<td style="text-align:center;"><a href="#p{donations.ID}" id="status{donations.ID}" class="change_status" data-options="{donations.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{donations.STATUS}</a></td>
+ 			<td>{donations.TIME}</td>
+ 		</tr>
+ 	<!-- END donations -->
+@@ -169,7 +169,7 @@
+ 			<td style="text-align:center;"><i class="fa {transactions.PAYMENT_TYPE}" aria-hidden="true"></i></td>
+ 			<td>{transactions.PP_TRANSACTION}</td>
+ 			<td>{DONATIONS_CURRENCY} {transactions.AMOUNT}</td>
+-			<td style="text-align:center;"><a href="#p{transactions.ID}" id="status{transactions.ID}" class="change_status" data-options="url={transactions.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{transactions.STATUS}</a></td>
++			<td style="text-align:center;"><a href="#p{transactions.ID}" id="status{transactions.ID}" class="change_status" data-options="{transactions.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{transactions.STATUS}</a></td>
+ 			<td>{transactions.TIME}</td>
+ 		</tr>
+ 		<!-- END transactions -->
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/controller/donation.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/controller/donation.php"
+index 8ab18e449..59fde58c7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/controller/donation.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/controller/donation.php"
+@@ -236,7 +236,7 @@ class donation
+ 		}
+ 
+ 		$this->user->add_lang_ext('sitesplat/donations', 'common');
+-		$currency_symbol = $this->manager->currency(0, $this->config['donations_currency']);
++		$currency_symbol = $this->manager->currency('', $this->config['donations_currency']);
+ 		$donationtxt = explode("\n", $this->config_text->get('donations_text'));
+ 
+ 		$amounts = json_decode($this->config['donations_amounts'], true);
+@@ -252,12 +252,13 @@ class donation
+ 
+ 		if ($this->options['list'])
+ 		{
+-			$sql = 'SELECT u.user_id, u.username, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, d.custom, d.mc_gross
++			$sql = 'SELECT u.user_id, u.username, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, d.custom, d.mc_gross, d.payment_date
+ 					FROM ' .$this->donation_table .' d
+ 					LEFT JOIN ' . USERS_TABLE . " u ON u.user_id = d.user_id
+ 					WHERE d.payment_status = 'Completed'
+-					ORDER bY payment_date DESC
+-					LIMIT 5";
++					AND d.payment_date >= UNIX_TIMESTAMP(DATE_SUB( CURDATE(), INTERVAL 3 MONTH)) 
++					ORDER BY d.payment_date DESC
++					LIMIT 20";
+ 			$result = $this->db->sql_query($sql);
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/controller/manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/controller/manager.php"
+index 0a21e564a..aee87fe56 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/controller/manager.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/controller/manager.php"
+@@ -260,7 +260,7 @@ class manager
+ 		$currencies['VND'] = array('&#8363;', 'Vietnamese dong');
+ 		$currencies['YER'] = array('&#8355;', 'Yemeni rial');
+ 
+-		if ($select == '')
++		if (!$select)
+ 		{
+ 			$option = $currencies[$currency][0];
+ 		} else
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/diff_full.tmp"
+new file mode 100644
+index 000000000..5bc813d8c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/diff_full.tmp"
+@@ -0,0 +1,717 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/acp/donations_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/acp/donations_module.php"
++index 605d63ed6..1da699119 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/acp/donations_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/acp/donations_module.php"
++@@ -241,7 +241,7 @@ class donations_module
++ 							'PP_TRANSACTION'	=> $row['txn_id'],
++ 							'AMOUNT'        	=> number_format($row['mc_gross'], 2),
++ 							'STATUS'			=> $row['payment_status'],
++-							'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&amp;user_id=' . $row['user_id'] . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
+++							'U_PAYMENT_STATUS'	=> $this->u_action . '&amp;user_id=' . $row['user_id'] . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
++ 							'TIME'           	=> $user->format_date($row['payment_date']),
++ 						));
++ 						$total_amount += ($row['payment_status'] == 'Completed' || $row['payment_status'] == 'Expired') ? $row['mc_gross'] : 0;
++@@ -294,7 +294,7 @@ class donations_module
++ 							'PP_TRANSACTION'	=> $row['txn_id'],
++ 							'AMOUNT'        	=> number_format($row['mc_gross'], 2),
++ 							'STATUS'			=> $row['payment_status'],
++-							'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
+++							'U_PAYMENT_STATUS'	=> $this->u_action . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
++ 							'TIME'           	=> $user->format_date($row['payment_date']),
++ 						));
++ 					}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/adm/style/acp_donations.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/adm/style/acp_donations.html"
++index 7b1a83a73..4cb7dc91e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/adm/style/acp_donations.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/adm/style/acp_donations.html"
++@@ -126,7 +126,7 @@
++ 			<td><a href="mailto:{donations.EMAIL}?SUBJECT=Donation">{donations.EMAIL}</a></td>
++ 			<td>{donations.PP_TRANSACTION}</td>
++ 			<td>{DONATIONS_CURRENCY} {donations.AMOUNT}</td>
++-			<td style="text-align:center;"><a href="#p{donations.ID}" id="status{donations.ID}" class="change_status" data-options="url={donations.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{donations.STATUS}</a></td>
+++			<td style="text-align:center;"><a href="#p{donations.ID}" id="status{donations.ID}" class="change_status" data-options="{donations.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{donations.STATUS}</a></td>
++ 			<td>{donations.TIME}</td>
++ 		</tr>
++ 	<!-- END donations -->
++@@ -169,7 +169,7 @@
++ 			<td style="text-align:center;"><i class="fa {transactions.PAYMENT_TYPE}" aria-hidden="true"></i></td>
++ 			<td>{transactions.PP_TRANSACTION}</td>
++ 			<td>{DONATIONS_CURRENCY} {transactions.AMOUNT}</td>
++-			<td style="text-align:center;"><a href="#p{transactions.ID}" id="status{transactions.ID}" class="change_status" data-options="url={transactions.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{transactions.STATUS}</a></td>
+++			<td style="text-align:center;"><a href="#p{transactions.ID}" id="status{transactions.ID}" class="change_status" data-options="{transactions.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{transactions.STATUS}</a></td>
++ 			<td>{transactions.TIME}</td>
++ 		</tr>
++ 		<!-- END transactions -->
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/controller/donation.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/controller/donation.php"
++index 8ab18e449..59fde58c7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/controller/donation.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/controller/donation.php"
++@@ -236,7 +236,7 @@ class donation
++ 		}
++ 
++ 		$this->user->add_lang_ext('sitesplat/donations', 'common');
++-		$currency_symbol = $this->manager->currency(0, $this->config['donations_currency']);
+++		$currency_symbol = $this->manager->currency('', $this->config['donations_currency']);
++ 		$donationtxt = explode("\n", $this->config_text->get('donations_text'));
++ 
++ 		$amounts = json_decode($this->config['donations_amounts'], true);
++@@ -252,12 +252,13 @@ class donation
++ 
++ 		if ($this->options['list'])
++ 		{
++-			$sql = 'SELECT u.user_id, u.username, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, d.custom, d.mc_gross
+++			$sql = 'SELECT u.user_id, u.username, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, d.custom, d.mc_gross, d.payment_date
++ 					FROM ' .$this->donation_table .' d
++ 					LEFT JOIN ' . USERS_TABLE . " u ON u.user_id = d.user_id
++ 					WHERE d.payment_status = 'Completed'
++-					ORDER bY payment_date DESC
++-					LIMIT 5";
+++					AND d.payment_date >= UNIX_TIMESTAMP(DATE_SUB( CURDATE(), INTERVAL 3 MONTH)) 
+++					ORDER BY d.payment_date DESC
+++					LIMIT 20";
++ 			$result = $this->db->sql_query($sql);
++ 			while ($row = $this->db->sql_fetchrow($result))
++ 			{
++@@ -266,7 +267,7 @@ class donation
++ 					'AVATAR'	=> (($row['user_avatar']) ?
++ 									 str_replace(array('<img', './../../'), array('<img class="avatar"', './'), phpbb_get_user_avatar(
++ 										array('avatar'			=> $row['user_avatar'],
++-                                              'user_id'         => $row['user_id'],
+++											  'user_id'         => $row['user_id'],
++ 											  'avatar_type'		=> $row['user_avatar_type'],
++ 											  'avatar_width'	=> $row['user_avatar_width'],
++ 											  'avatar_height'	=> $row['user_avatar_height']), $row['username'])) :
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/controller/manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/controller/manager.php"
++index 0a21e564a..aee87fe56 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/controller/manager.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/controller/manager.php"
++@@ -260,7 +260,7 @@ class manager
++ 		$currencies['VND'] = array('&#8363;', 'Vietnamese dong');
++ 		$currencies['YER'] = array('&#8355;', 'Yemeni rial');
++ 
++-		if ($select == '')
+++		if (!$select)
++ 		{
++ 			$option = $currencies[$currency][0];
++ 		} else
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/diff_full.tmp"
++new file mode 100644
++index 000000000..f079dee8d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/diff_full.tmp"
++@@ -0,0 +1,47 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/acp/donations_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/acp/donations_module.php"
+++index 605d63ed6..1da699119 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/acp/donations_module.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/acp/donations_module.php"
+++@@ -241,7 +241,7 @@ class donations_module
+++ 							'PP_TRANSACTION'	=> $row['txn_id'],
+++ 							'AMOUNT'        	=> number_format($row['mc_gross'], 2),
+++ 							'STATUS'			=> $row['payment_status'],
+++-							'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&amp;user_id=' . $row['user_id'] . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
++++							'U_PAYMENT_STATUS'	=> $this->u_action . '&amp;user_id=' . $row['user_id'] . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
+++ 							'TIME'           	=> $user->format_date($row['payment_date']),
+++ 						));
+++ 						$total_amount += ($row['payment_status'] == 'Completed' || $row['payment_status'] == 'Expired') ? $row['mc_gross'] : 0;
+++@@ -294,7 +294,7 @@ class donations_module
+++ 							'PP_TRANSACTION'	=> $row['txn_id'],
+++ 							'AMOUNT'        	=> number_format($row['mc_gross'], 2),
+++ 							'STATUS'			=> $row['payment_status'],
+++-							'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
++++							'U_PAYMENT_STATUS'	=> $this->u_action . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
+++ 							'TIME'           	=> $user->format_date($row['payment_date']),
+++ 						));
+++ 					}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/adm/style/acp_donations.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/adm/style/acp_donations.html"
+++index 7b1a83a73..4cb7dc91e 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/adm/style/acp_donations.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/adm/style/acp_donations.html"
+++@@ -126,7 +126,7 @@
+++ 			<td><a href="mailto:{donations.EMAIL}?SUBJECT=Donation">{donations.EMAIL}</a></td>
+++ 			<td>{donations.PP_TRANSACTION}</td>
+++ 			<td>{DONATIONS_CURRENCY} {donations.AMOUNT}</td>
+++-			<td style="text-align:center;"><a href="#p{donations.ID}" id="status{donations.ID}" class="change_status" data-options="url={donations.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{donations.STATUS}</a></td>
++++			<td style="text-align:center;"><a href="#p{donations.ID}" id="status{donations.ID}" class="change_status" data-options="{donations.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{donations.STATUS}</a></td>
+++ 			<td>{donations.TIME}</td>
+++ 		</tr>
+++ 	<!-- END donations -->
+++@@ -169,7 +169,7 @@
+++ 			<td style="text-align:center;"><i class="fa {transactions.PAYMENT_TYPE}" aria-hidden="true"></i></td>
+++ 			<td>{transactions.PP_TRANSACTION}</td>
+++ 			<td>{DONATIONS_CURRENCY} {transactions.AMOUNT}</td>
+++-			<td style="text-align:center;"><a href="#p{transactions.ID}" id="status{transactions.ID}" class="change_status" data-options="url={transactions.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{transactions.STATUS}</a></td>
++++			<td style="text-align:center;"><a href="#p{transactions.ID}" id="status{transactions.ID}" class="change_status" data-options="{transactions.U_PAYMENT_STATUS}" data-ajax="true" title="{L_ACP_DONATIONS_CHANGE_STATUS}">{transactions.STATUS}</a></td>
+++ 			<td>{transactions.TIME}</td>
+++ 		</tr>
+++ 		<!-- END transactions -->
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/controller/donation.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/controller/donation.php"
+++index 8ab18e449..59fde58c7 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/en/common.php"
++index caaa57a43..7376c41ec 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/language/en/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/en/common.php"
++@@ -31,10 +31,10 @@ $lang = array_merge($lang, array(
++     'DONATIONS_DATE'				=> 'Date',
++ 	'DONATIONS_CUSTOM_MESSAGE'		=> 'Leave a message',
++     'DONATIONS_SUCCESS' 			=> 'Donation was successful',
++-    'DONATIONS_CANCELLED' 			=> 'Donation was cancelled',
+++    'DONATIONS_CANCELLED' 			=> 'Donation was canceled',
++     'DONATIONS_ERROR' 				=> 'There was an error in the donation',
++ 	
++-	'DONATIONS_THANK_YOU'			=> 'Thank-you for supporting our community!',
+++	'DONATIONS_THANK_YOU'			=> 'Thank-you for thinking on supporting our community!',
++ 	'DONATIONS_PREMIUM'				=> 'The donors with an amount of <strong>%s</strong> or more are added to a special group with special forum benefits.<br />Custom rank, color and much more!',
++ 	'DONATIONS_MESSAGE'				=> 'Participate in our success and together let\'s make our community even better',
++ 	'DONATION_STEP_1'				=> '1',
++@@ -61,7 +61,7 @@ $lang = array_merge($lang, array(
++ 	'CONTINUE_ON_PAYPAL'		    => 'PayPal',
++ 	'CONTINUE_ON_BITCOINS'		    => 'Bitcoin',
++ 	'CONNECTING_ON_PAYPAL'		    => 'Connecting with PayPal',
++-	'BBDONATION_COPY'		        => 'BBdonation Built With',
+++	'BBDONATION_COPY'		        => 'Donation Built With',
++ 	'SITESPLAT_EXT_COPY'	        => 'Professional Web Development and Premium Themes',
++ 	
++ 	'UCP_DONATION_TITLE'			=> 'Donation overview',
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/pt/common.php"
++new file mode 100644
++index 000000000..6f7a3318f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/pt/common.php"
++@@ -0,0 +1,70 @@
+++<?php
+++/**
+++*
+++* @package BBdonations
+++* @copyright (c) 2016 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if ( empty($lang) || !is_array($lang) )
+++{
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'DONATIONS'						=> 'Donativos',
+++	'DONATION'						=> 'Donativo',
+++    'DONATIONS_INDEX'				=> 'Donativos',
+++	'DONATION_DISABLED'				=> 'Os donativos encontram-se desativados',
+++	'DONATIONS_DONATE'  			=> 'Donativo',
+++    'DONATIONS_CONTACT_PAYPAL'		=> 'Por favor, aguarda...',
+++    'DONATIONS_AMOUNT'  			=> 'Montante',
+++    'DONATIONS_DATE'				=> 'Data',
+++	'DONATIONS_CUSTOM_MESSAGE'		=> 'Deixa uma mensagem',
+++    'DONATIONS_SUCCESS' 			=> 'O donativo foi efetuado com sucesso',
+++    'DONATIONS_CANCELLED' 			=> 'O donativo foi cancelado',
+++    'DONATIONS_ERROR' 				=> 'Ocorreu um erro com o donativo',
+++	
+++	'DONATIONS_THANK_YOU'			=> 'Obrigado por desejares contribuir para a nossa comunidade!',
+++	'DONATIONS_PREMIUM'				=> 'Os utilizadores que doem um montante igual ou acima de <strong>%s</strong>, são adicionados a um grupo especial que trará diversos benefícios!',
+++	'DONATIONS_MESSAGE'				=> 'Vamos juntos tornar esta comunidade ainda melhor',
+++	'DONATION_STEP_1'				=> '1',
+++	'DONATION_STEP_2'				=> '2',
+++	'DONATION_STEP_3'				=> '3',
+++	'DONATION_STEP_4'				=> '4',
+++	
+++	'DONATION_STEP_1_INNER'		    => 'Seleciona um montante',
+++	'DONATION_STEP_2_INNER'		    => 'Continuar para o PayPal',
+++    'DONATION_STEP_3_INNER'	        => 'Regressar ao fórum',
+++	'DONATION_STEP_4_INNER'		    => 'Obrigado',
+++	
+++	'DONATION_DEPOSIT_DISCLAIMER'   => '**Paga com segurança com o PayPal',
+++	'DONATION_MY_CREDITS'		    => 'Donativos efetuados',
+++	
+++	'DONATIONS_NOGUESTS'		    => 'O Fórum precisa que estejas com login efetuado para proceder com o donativo',
+++	'DONATIONS_TRANSACTION'		    => 'Transações',
+++	'DONATIONS_TRAN'		        => 'Transação ',
+++	'DONATIONS_SENDER'		        => 'Doador',
+++	'DONATIONS_DIGIT'		        => '.00',
+++	'DONATIONS_DONORS'		        => 'Últimos Donativos',
+++	'DONATIONS_MSG_PLACEHOLDER'		=> 'Mensagem curta opcional...',
+++	
+++	'CONTINUE_ON_PAYPAL'		    => 'PayPal',
+++	'CONTINUE_ON_BITCOINS'		    => 'Bitcoin',
+++	'CONNECTING_ON_PAYPAL'		    => 'A conectar com o PayPal',
+++	'BBDONATION_COPY'		        => 'Sistema de Donativos Feito com',
+++	'SITESPLAT_EXT_COPY'	        => '',
+++	
+++	'UCP_DONATION_TITLE'			=> 'Donativos - Geral',
+++	'UCP_DONATIONS_EXPLAIN'         => 'Log dos teus donativos',
+++	'DONATION_ACTIVITY_UCP_EMPTY'   => 'Não tem donativos efetuados'
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/pt/info_acp_donations.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/pt/info_acp_donations.php"
++new file mode 100644
++index 000000000..eeaf4336a
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/language/pt/info_acp_donations.php"
++@@ -0,0 +1,106 @@
+++<?php
+++/**
+++*
+++* @package BBdonations
+++* @copyright (c) 2016 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if ( empty($lang) || !is_array($lang) )
+++{
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'ACP_DONATIONS'  				=> 'BBDonations',
+++	'ACP_DONATIONS_EXPLAIN'			=> 'Donations settings for your website. Configure the desired settings, fill in the PayPal info and the Bitcoin info to maximize your donation results.',
+++	'ACP_DONATIONS_INDEX_TITLE'		=> 'Config',
+++	'ACP_DONATIONS_PAYPAL_EMAIL'	=> 'Paypal email',
+++	'ACP_DONATIONS_PAYPAL_EXPLAIN'	=> 'Enter your PayPal email here. (leave empty to disable donation method) You might need to use PayPal business account as the IPN system might requires it to work correctly.<br /> For more information visit: <a href="https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNSetup/#id089EG030E5Z">PayPal IPN setup</a>',
+++	'ACP_DONATIONS_OPTIONS'			=> 'Donation options',
+++	'ACP_DONATIONS_OPTIONS_EXPLAIN'	=> 'The following options are available: <br /> <strong>Sandbox Mode:</strong> Allows the sandbox mode (For both Bitcoin and PayPal) which is useful to test the donations. Please beware that Coinbase sandbox is not reliable and therefore a real account should be used to run tests. The easiest way to test it is to use a smartphone app and donate back and forth between your forum and the app. Use the following app for android phones: <a href="https://airbitz.co/af/DJM" target="blank">AirBitz</a> <br /> <strong>Enable message:</strong> This enables the user to leave a short message with the donation <br /> <strong>Show donors:</strong> Enables the last recent donors',
+++	'ACP_DONATIONS_SANDBOX'			=> 'Sandbox mode',
+++	'ACP_DONATIONS_MESSAGE'			=> 'Enable message',
+++	'ACP_DONATIONS_LIST'			=> 'Show donors',
+++	'ACP_DONATIONS_BITCOIN'			=> 'Bitcoin',
+++	'ACP_DONATIONS_BITCOIN_EXPLAIN' => 'Enter Your coinbase API Key and API Secret here (leave empty to disable donation method). <br /> Follow <strong>EXACTLY</strong> (links open on a new tab) these steps to successfully enable Bitcoin donation: <br /><strong>STEP1:</strong> <a href="https://www.coinbase.com/join/54c7b129d41344b592000006" target="_blank">Register a Coinbase account</a> <br /><strong>STEP2:</strong> <a href="https://www.coinbase.com/merchant_profiles" target="_blank">Setup the merchant page profile</a> <br /><strong>STEP3:</strong> <a href="https://www.coinbase.com/merchant_settings" target="_blank">Setup the merchant settings</a> <br /><strong>STEP4:</strong> In the notification URL option under Merchant settings (STEP3), enter your board URL like this:<br /> <code>http://www.my_board_url.com/app.php/donation/index.html?mode=notify_bitcoin</code> (Where "my_board_url.com" is your real board URL) <br /><strong>STEP5:</strong> Register the the Oauth application here: <a href="https://www.coinbase.com/settings/api" target="_blank">Oauth App</a>. Click on the button "+ New API key" then under "Accounts" checkmark "My Wallet (Primary)", under "Permissions" Click on select all and finally under "Notifications" enter the same URL as described on STEP4. Now click "Create" Button and get your API Key and API Secret to be enter here on your right. <br /><strong>STEP6:</strong> Congrats! Good luck with your donation campaign!',
+++	'ACP_DONATIONS_BITCOIN_KEY'		=> 'API Key',
+++	'ACP_DONATIONS_BITCOIN_SECRET'	=> 'API Secret',
+++	'ACP_DONATIONS_AMOUNTS'			=> 'Amounts',
+++	'ACP_DONATIONS_TEXT'			=> 'Text',
+++	'ACP_DONATIONS_SYMBOL'			=> 'Symbol',
+++	'ACP_DONATIONS_ADD_ROW'			=> 'Add another row',
+++	'ACP_DONATIONS_DELL_ROW'		=> 'Delete last row',
+++	'ACP_DONATIONS_AMOUNTS_EXPLAIN'	=> 'The following options are available: (Use "%s" as a placeholder to fill in automatically the amount and currency in your text field.) <br /><strong>Amount:</strong> Set the donation amount <br /><strong>Text:</strong> Enter your custom text for the donation amount goal <br /><strong>Symbol:</strong> Select a font awesome symbol for each goal eantered.', 
+++	'ACP_DONATIONS_STATUS'			=> 'Status',
+++	'ACP_DONATIONS_GROUP'			=> 'Auto Group',
+++	'ACP_DONATIONS_GROUP_EXPLAIN'	=> 'The following options are available for the AutoGroup settings: <br /><strong>Days:</strong> time expressed in days for the user to stay on X group. (No time disables fallback for this group) <br /> <strong>Amount:</strong> min currency (donation) value for the AutoGroup to be triggered. (0 disables AutoGroup) <br /><strong>Group:</strong> Group for the user to be moved into when the min. amount is triggered <br /><strong>Group Default:</strong> Set the group to default for the user (Checkmark to set as default)',
+++	'ACP_DONATIONS_GROUP_DEF'		=> 'Group default',
+++	'ACP_DONATIONS_GROUPS'		    => 'Group',
+++	'ACP_DONATIONS_STATS'  			=> 'Statistics',
+++	'ACP_DONATIONS_TIME'			=> 'Date',
+++	'ACP_DONATIONS_TOTAL'			=> 'Sum of all donations',
+++	'ACP_DONATIONS_ADDRESS'			=> 'Donator\'s address',
+++	'ACP_DONATIONS_COUNTRY'			=> 'Donator\'s country',
+++	'ACP_DONATIONS_TRANSACTIONS'  	=> 'Transactions',
+++	'ACP_DONATIONS_FALLBACK'  		=> 'Fallback Group',
+++	'ACP_DONATIONS_FALLBACK_EXPLAIN'=> 'A Group fallback for the user to go back to if the time (in Days) is exceeded.<br />No group disables this function.',
+++	'ACP_DONATIONS_AMOUNT'			=> 'Amount',
+++	
+++	'ACP_DONATIONS_DAY_STAY'		=> 'Day to stay in this group',
+++	'ACP_DONATIONS_CHANGE_STATUS'	=> 'Change status',
+++	'ACP_DONATIONS_MAX_AMO'			=> 'Max amount for this group',
+++	
+++	'ACP_DONATIONS_DAYS'			=> 'Days',
+++	'ACP_DONATIONS_TRANSACTION'		=> 'Transaction id',
+++	'ACP_DONATIONS_CURRENCY'		=> 'Currency code',
+++	'ACP_DONATIONS_CURRENCY_EXPLAIN'=> 'Currency code follows the allowed <a href="https://developer.paypal.com/docs/classic/api/currency_codes/" target="_blank">Paypal Multiple Currencies</a> standards. <br /> Make sure the currency you are going to use is enabled on your PayPal account. <br />If the currency is not supported on your PayPal acccount the transactions will be returned as "Not verified" or "Pending".',
+++	'ACP_DONATIONS_USERNAME'		=> 'Username',
+++	'DONATIONS_NOTICE'				=> '<div class="phpinfo"><p>The settings for this extensions are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
+++	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+++	
+++	
+++	'SITESPLAT_COM'		        => 'https://sitesplat.com',
+++	'SITESPLAT_COPY'		    => '&#169; SiteSplat',
+++	'LICENSE_INFO'		        => 'Proprietary - SiteSplat All rights reserved',
+++	'EXTENSION_DEVELOPER'	    => 'Developer',
+++	'ACP_NOTICE_CLOSE'			=> 'Close',
+++	'ACP_DONATIONS_VERSION'     => '1.0.10',
+++	'ACP_LOADING'		        => 'Loading... Hold on',
+++	
+++	'EXT_BBD_DESCRIPTION_PAGE'	=> 'A kick-ass donation extension for the phpBB board running sitesplat themes. Many modern and useful options included PayPal IPN and Bitcoin API.',
+++	'EXT_BBD_TASKS_1'			=> 'AutoGroup',
+++	'EXT_BBD_TASKS_2'			=> 'Fully editable donation scopes',
+++	'EXT_BBD_TASKS_3'			=> 'PayPal IPN',
+++	'EXT_BBD_TASKS_4'			=> 'Bitcoins support',
+++	'EXT_BBD_TASKS_5'			=> 'phpBB 3.2 ready',
+++	'EXT_BBD_TASKS_6'			=> 'Checkout the other premium compatible addons on <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
+++	
+++));
+++
+++// Description of Donations extension
+++$lang = array_merge($lang, array(
+++	'DESCRIPTION_PAGE'		=> 'Description',
+++	'DESCRIPTION_NOTICE'	=> 'Extension note',
+++	'ext_details' => array(
+++		'details' => array(
+++			'DESCRIPTION_1'	=> 'Overview of donations',
+++			'DESCRIPTION_2'	=> 'Paypal / Bitcoins API',
+++			'DESCRIPTION_3'	=> 'Autogroups',
+++			'DESCRIPTION_4'	=> 'Set back to standard group after x amount of time',
+++			'DESCRIPTION_5'	=> 'Guest can also donate',
+++		),
+++		'note' => array(
+++			'NOTICE_1'		=> 'phpBB 3.2 ready'
+++		)
+++	)
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/styles/FLATBOOTS/template/donations.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/styles/FLATBOOTS/template/donations.html"
++index 688704ea7..8958a684f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/styles/FLATBOOTS/template/donations.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/styles/FLATBOOTS/template/donations.html"
++@@ -1,104 +1,130 @@
++ <!-- INCLUDE overall_header.html -->
++-<div class="side-segment"><h3>{L_DONATIONS}</h3></div>
++-<div class="clearfix">
++- <div class="donation-actions">
++-<script>
++-    var vals = [<!-- BEGIN amounts -->{amounts.AMOUNT}<!-- IF not amounts.S_LAST_ROW -->,<!-- ENDIF --><!-- END amounts -->];
+++<div class="side-segment">
+++	<h3>{L_DONATIONS}</h3>
+++</div>
+++<!-- IF S_USER_LOGGED_IN -->
+++<script async
+++  src="https://js.stripe.com/v3/buy-button.js">
++ </script>
++- 	<form action="<!-- IF SUCCESS or ERROR -->{U_INDEX}<!-- ELSE -->{U_DONATE}<!-- ENDIF -->" method="post">
++-        <h2>{L_DONATIONS_THANK_YOU}</h2>
++-        <!-- IF DONATIONS_PREMIUM --><p class="donation-premium">{DONATIONS_PREMIUM}</p><!-- ENDIF -->
++-        <div id="donationmessage">
++-            <h3>{L_DONATIONS_MESSAGE}</h3>
++-        </div>
++-        <div id="donationicons">
++-        <!-- BEGIN amounts -->
++-            <span<!-- IF amounts.S_ROW_COUNT == 1 --> class="selected"<!-- ENDIF --> title="{DONATIONS_CURRENCY_SYMBOL}&nbsp;{amounts.AMOUNT}{L_DONATIONS_DIGIT}">{DONATIONS_CURRENCY_SYMBOL}&nbsp;{amounts.AMOUNT}{L_DONATIONS_DIGIT}</span>
++-            <!-- IF amounts.TXT --><p class="hidden-xs">{amounts.TXT}</p><!-- ENDIF -->
++-        <!-- END amounts -->
++-        </div>	
++-        <input type="range" min="0" max="{STEPS}" step="1" value="1" id="donationvalue">
++ 
++-	<!-- IF S_USER_LOGGED_IN -->  
++-        <div id="submission">
++-			<div class="input-group">
++-			  <span class="input-group-addon">
++-				<output for="donationvalue">
++-					 <span>{DONATIONS_CURRENCY_SYMBOL}</span>
++-					 <span id="donationoutput"><script>document.write(vals[1])</script>{L_DONATIONS_DIGIT}</span>
++-				</output>
++-			  </span>
++-			  <!-- IF ENABLE_MESSAGE -->
++-			    <input id="custom_message" type="text" value="" name="custom" class="form-control dcount" placeholder="{L_DONATIONS_MSG_PLACEHOLDER}" autocomplete="off">
++-			  <!-- ENDIF -->	
++-			  <span class="input-group-btn">
++-			    <input type="hidden" name="amount" id="amount" value="">
++-				<!-- IF BITCOIN_ENABLED --><button class="btn btn-bbdonation" name="bitcoin" type="submit" value="" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><span class="bitcoin-logo"></span>&nbsp;{L_CONTINUE_ON_BITCOINS}</button><!-- ENDIF -->
++-				<!-- IF PAYPAL_ENABLED --><button class="btn btn-bbdonation" type="submit" value="" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><span class="paypal-logo"></span>&nbsp;{L_CONTINUE_ON_PAYPAL}</button><!-- ENDIF -->
++-			  </span>
++-			</div>	
++-        </div>
++-        <script>
++-            document.getElementById('amount').value=vals[1];
++-        </script>
++-	<!-- ELSE -->
++-      	<p>{L_DONATIONS_NOGUESTS}</p>
++-	<!-- ENDIF -->	
+++	<div class="clearfix">
+++		<div class="donation-actions">
+++			<script>
+++				var vals = [<!-- BEGIN amounts -->{amounts.AMOUNT}<!-- IF not amounts.S_LAST_ROW -->,<!-- ENDIF --><!-- END amounts -->];
+++			</script>
+++			<form action="<!-- IF SUCCESS or ERROR -->{U_INDEX}<!-- ELSE -->{U_DONATE}<!-- ENDIF -->" method="post">
+++				<h2>{L_DONATIONS_THANK_YOU}</h2>
+++				<!-- IF DONATIONS_PREMIUM -->
+++				<p class="donation-premium">{DONATIONS_PREMIUM}</p><!-- ENDIF -->
+++				<div id="donationmessage">
+++					<h3>{L_DONATIONS_MESSAGE}</h3>
+++				</div>
+++				<div id="donationicons">
+++					<!-- BEGIN amounts -->
+++					<span<!-- IF amounts.S_ROW_COUNT==1 --> class="selected"<!-- ENDIF --> title="{DONATIONS_CURRENCY_SYMBOL}&nbsp;{amounts.AMOUNT}{L_DONATIONS_DIGIT}">{DONATIONS_CURRENCY_SYMBOL}&nbsp;{amounts.AMOUNT}{L_DONATIONS_DIGIT}</span>
+++					<!-- IF amounts.TXT -->
+++						<p>
+++							<b class="hidden-xs">{amounts.TXT}</b>
+++							<small class="visible-xs">{amounts.TXT}</small>
+++						</p>
+++					<!-- ENDIF -->
+++						<!-- END amounts -->
+++				</div>
+++				<input type="range" min="0" max="{STEPS}" step="1" value="1" id="donationvalue">
+++
+++				
+++				<div id="submission">
+++					<div class="input-group">
+++						<span class="input-group-addon">
+++							<output for="donationvalue">
+++								<span>{DONATIONS_CURRENCY_SYMBOL}</span>
+++								<span id="donationoutput">
+++									<script>document.write(vals[1])</script>{L_DONATIONS_DIGIT}
+++								</span>
+++							</output>
+++						</span>
+++						<!-- IF ENABLE_MESSAGE -->
+++						<input id="custom_message" type="text" value="" name="custom" class="form-control dcount" placeholder="{L_DONATIONS_MSG_PLACEHOLDER}" autocomplete="off">
+++						<!-- ENDIF -->
+++						<span class="input-group-btn">
+++							<input type="hidden" name="amount" id="amount" value="">
+++							<!-- IF BITCOIN_ENABLED --><button class="btn btn-bbdonation" name="bitcoin" type="submit" value="" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><span class="bitcoin-logo"></span>&nbsp;{L_CONTINUE_ON_BITCOINS}</button><!-- ENDIF -->
+++							<!-- IF PAYPAL_ENABLED --><button class="btn btn-bbdonation" type="submit" value="" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><span class="paypal-logo"></span>&nbsp;{L_CONTINUE_ON_PAYPAL}</button><!-- ENDIF -->
+++						</span>
+++					</div>
+++				</div>
+++				<script>
+++					document.getElementById('amount').value = vals[1];
+++				</script>
+++			</form>
+++			<div class="space10"></div>
+++			<p class="text-muted">{L_DONATION_DEPOSIT_DISCLAIMER}</p>
+++		</div>
+++		<div class="text-right"><small>{L_BBDONATION_COPY}</small>&nbsp;<i class="fa fa-heart text-flatboots-red heart-ss pulse-ss"></i></div>
+++	</div>
+++
+++
+++	<div class="space10"></div>
+++	<div class="space10"></div>
++ 	
++- 	</form>
++-	<div class="space10"></div><p class="text-muted">{L_DONATION_DEPOSIT_DISCLAIMER}</p>
++- </div>
++- <div class="text-right"><small>{L_BBDONATION_COPY}</small>&nbsp;<i class="fa fa-heart text-flatboots-red heart-ss pulse-ss"></i>&nbsp;<small>{L_BY}<a href="https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat" title="{L_SITESPLAT_EXT_COPY}" target="_blank">&nbsp;{L_SITESPLAT}</a></small></div>
++-</div> 
+++	<div class="clearfix" id="donativo-alternativo">
+++		<div class="donation-actions">
+++		<p class="donation-premium">Donativo com Formas de Pagamento Alternativas</p>
+++			<stripe-buy-button
+++			  buy-button-id="buy_btn_1SywVYDyIaKunyHURBFSg3Fd"
+++			  publishable-key="pk_live_51LWW6mDyIaKunyHU6XX0UewVkgUUzgkxRdIEHwfXFotxwROFdGpJvgRvB3WmLNftiUNOHsHheI7yfVEODlkAcoIY00PjLHM3Hd"
+++			>
+++			</stripe-buy-button>
+++		</div>
+++	</div>
++ 
++- 
++-<!-- IF .donors -->
+++	<!-- IF .donors -->
++ 	<div class="space10"></div>
++-	  <div class="space10"></div>
++-    <div class="side-segment"><h3>{L_DONATIONS_DONORS}</h3></div>
+++	<div class="space10"></div>
+++	<div class="side-segment">
+++		<h3>{L_DONATIONS_DONORS}</h3>
+++	</div>
++ 	<div class="row">
++-	<div class="panel panel-default">
++-	 <div class="panel-body">
++-        <!-- BEGIN donors -->
++-		<div class="col-md-3 col-sm-4 col-xs-4">
++-        <figure class="member-info">{donors.AVATAR}
++-			<figcaption>
++-                  <h3>{donors.NAME}</h3>
++-				  <span>&nbsp;{donors.TXT}</span>
++-                  <a>{DONATIONS_CURRENCY_SYMBOL}&nbsp;{donors.AMOUNT}</a>
++-            </figcaption>
++-        </figure>
+++		<div class="panel panel-default">
+++			<div class="panel-body" style="display:flex;flex-wrap:wrap;">
+++				<!-- BEGIN donors -->
+++				<div class="col-md-3 col-sm-4 col-xs-4">
+++					<figure class="member-info">{donors.AVATAR}
+++						<figcaption>
+++							<h3>{donors.NAME}</h3>
+++							<span>&nbsp;{donors.TXT}</span>
+++							<a>{DONATIONS_CURRENCY_SYMBOL}&nbsp;{donors.AMOUNT}</a>
+++						</figcaption>
+++					</figure>
+++				</div>
+++				<!-- END donors -->
+++			</div>
++ 		</div>
++-        <!-- END donors -->
++-	 </div>	
++-    </div>
++ 	</div>
++-<!-- ENDIF -->  
+++	<!-- ENDIF -->
++ 
++ 
++-<!-- IF DONATIONS_COINBASE_CODE -->
++-<div class="bitcoin_box">
++-      <iframe
++-		  id="{DONATIONS_COINBASE_CODE}"
++-		  src="{DONATIONS_COINBASE_URL}/checkouts/{DONATIONS_COINBASE_CODE}/inline"
++-		  style="width: 460px; height: 350px; box-shadow: 0 1px 3px rgba(0,0,0,0.25);"
++-		  allowtransparency="true"
++-		  frameborder="0">
++-      </iframe>
++-</div>  
++-<div class="darken_bitcoin"></div>
++-<!-- ENDIF -->
+++	<!-- IF DONATIONS_COINBASE_CODE -->
+++	<div class="bitcoin_box">
+++		<iframe id="{DONATIONS_COINBASE_CODE}" src="{DONATIONS_COINBASE_URL}/checkouts/{DONATIONS_COINBASE_CODE}/inline" style="width: 460px; height: 350px; box-shadow: 0 1px 3px rgba(0,0,0,0.25);" allowtransparency="true" frameborder="0">
+++		</iframe>
+++	</div>
+++	<div class="darken_bitcoin"></div>
+++	<!-- ENDIF -->
++ 
++-<!-- IF NOTIFY_STATUS -->
++-<script>
++-    var info = '{L_INFORMATION}';
++-    var notify = '{NOTIFY_STATUS}';
++-</script>
++-<!-- INCLUDEJS @sitesplat_donations/js/notify_status.js -->
+++	<!-- IF NOTIFY_STATUS -->
+++	<script>
+++		var info = '{L_INFORMATION}';
+++		var notify = '{NOTIFY_STATUS}';
+++	</script>
+++	<!-- INCLUDEJS @sitesplat_donations/js/notify_status.js -->
+++	<!-- ENDIF -->
+++	<!-- IF ENABLE_MESSAGE -->
+++	<!-- INCLUDEJS @sitesplat_donations/js/jquery.charactercounter.js -->
+++	<!-- INCLUDEJS @sitesplat_donations/js/char.init.js -->
+++	<!-- ENDIF -->
+++	<!-- INCLUDEJS @sitesplat_donations/js/donations.js -->
+++<!-- ELSE -->
+++<p>{L_DONATIONS_NOGUESTS}</p>
++ <!-- ENDIF -->
++-<!-- IF ENABLE_MESSAGE -->
++-<!-- INCLUDEJS @sitesplat_donations/js/jquery.charactercounter.js -->
++-<!-- INCLUDEJS @sitesplat_donations/js/char.init.js -->
++-<!-- ENDIF -->	
++-<!-- INCLUDEJS @sitesplat_donations/js/donations.js -->
++ <!-- INCLUDE overall_footer.html -->
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++index c8239e3ca..29508e395 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++@@ -1,3 +1,4 @@
+++
++ <!-- IF SCRIPT_NAME == "app/donation/index.html" -->
++ 	{% INCLUDECSS '@sitesplat_donations/donation.css' %}
++ <style>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/styles/FLATBOOTS/template/js/char.init.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/styles/FLATBOOTS/template/js/char.init.js"
++index 44a9a3c89..f911738af 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\donations/styles/FLATBOOTS/template/js/char.init.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\donations/styles/FLATBOOTS/template/js/char.init.js"
++@@ -1,30 +1,30 @@
++ head.ready(function () {
++-(function($) { // Avoid conflicts with other libraries
++-	'use strict';
++-	
++-	// some quick and simple tricks
++-	$("#custom_message").focusin(function() {
++-        $(".counter-pos").css("display","inline-block");
++-	});
++-	$("#custom_message").focusout(function() {
++-		$(".counter-pos").css("display","none");
++-	});
++-	
++-	// Fix the counter bug once exeeeded functions below is triggered and page reloaded keeping the btn disabled
++-	$( ".btn-bbdonation" ).prop( "disabled", false );
++-	
++-	$(".dcount").characterCounter({
++-        counterFormat: '%1/50',
++-		limit: 50,
++-		counterCssClass: 'counter-pos',
++-		counterExceededCssClass: 'exceeded',
++-		onExceed: function(count){
++-		   $('.btn-bbdonation').prop('disabled', true);
++-		},
++-		onDeceed: function(count){
++-		   $('.btn-bbdonation').prop('disabled', false);
++-		},
++-    });
++-	
++-})(jQuery); // Avoid conflicts with other libraries
++-});
++\ No newline at end of file
+++	(function ($) {
+++		// Avoid conflicts with other libraries
+++		'use strict';
+++
+++		// some quick and simple tricks
+++		$('#custom_message').focusin(function () {
+++			$('.counter-pos').css('display', 'inline-block');
+++		});
+++		$('#custom_message').focusout(function () {
+++			$('.counter-pos').css('display', 'none');
+++		});
+++
+++		// Fix the counter bug once exeeeded functions below is triggered and page reloaded keeping the btn disabled
+++		$('.btn-bbdonation').prop('
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\donations/language/en/common.php" "[FORUM_EXT]/sitesplat\\donations/language/en/common.php"
--- "[ORIGINAL]/sitesplat\\donations/language/en/common.php"
+++ "[FORUM_EXT]/sitesplat\\donations/language/en/common.php"
@@ -31,10 +31,10 @@ $lang = array_merge($lang, array(
     'DONATIONS_DATE'				=> 'Date',
 	'DONATIONS_CUSTOM_MESSAGE'		=> 'Leave a message',
     'DONATIONS_SUCCESS' 			=> 'Donation was successful',
-    'DONATIONS_CANCELLED' 			=> 'Donation was cancelled',
+    'DONATIONS_CANCELLED' 			=> 'Donation was canceled',
     'DONATIONS_ERROR' 				=> 'There was an error in the donation',
 	
-	'DONATIONS_THANK_YOU'			=> 'Thank-you for supporting our community!',
+	'DONATIONS_THANK_YOU'			=> 'Thank-you for thinking on supporting our community!',
 	'DONATIONS_PREMIUM'				=> 'The donors with an amount of <strong>%s</strong> or more are added to a special group with special forum benefits.<br />Custom rank, color and much more!',
 	'DONATIONS_MESSAGE'				=> 'Participate in our success and together let\'s make our community even better',
 	'DONATION_STEP_1'				=> '1',
@@ -61,7 +61,7 @@ $lang = array_merge($lang, array(
 	'CONTINUE_ON_PAYPAL'		    => 'PayPal',
 	'CONTINUE_ON_BITCOINS'		    => 'Bitcoin',
 	'CONNECTING_ON_PAYPAL'		    => 'Connecting with PayPal',
-	'BBDONATION_COPY'		        => 'BBdonation Built With',
+	'BBDONATION_COPY'		        => 'Donation Built With',
 	'SITESPLAT_EXT_COPY'	        => 'Professional Web Development and Premium Themes',
 	
 	'UCP_DONATION_TITLE'			=> 'Donation overview',
diff --git "[FORUM_EXT]/sitesplat\\donations/language/pt/common.php" "[FORUM_EXT]/sitesplat\\donations/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\donations/language/pt/common.php"
@@ -0,0 +1,70 @@
+<?php
+/**
+*
+* @package BBdonations
+* @copyright (c) 2016 SiteSplat All rights reserved
+* @license Proprietary
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if ( empty($lang) || !is_array($lang) )
+{
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'DONATIONS'						=> 'Donativos',
+	'DONATION'						=> 'Donativo',
+    'DONATIONS_INDEX'				=> 'Donativos',
+	'DONATION_DISABLED'				=> 'Os donativos encontram-se desativados',
+	'DONATIONS_DONATE'  			=> 'Donativo',
+    'DONATIONS_CONTACT_PAYPAL'		=> 'Por favor, aguarda...',
+    'DONATIONS_AMOUNT'  			=> 'Montante',
+    'DONATIONS_DATE'				=> 'Data',
+	'DONATIONS_CUSTOM_MESSAGE'		=> 'Deixa uma mensagem',
+    'DONATIONS_SUCCESS' 			=> 'O donativo foi efetuado com sucesso',
+    'DONATIONS_CANCELLED' 			=> 'O donativo foi cancelado',
+    'DONATIONS_ERROR' 				=> 'Ocorreu um erro com o donativo',
+	
+	'DONATIONS_THANK_YOU'			=> 'Obrigado por desejares contribuir para a nossa comunidade!',
+	'DONATIONS_PREMIUM'				=> 'Os utilizadores que doem um montante igual ou acima de <strong>%s</strong>, são adicionados a um grupo especial que trará diversos benefícios!',
+	'DONATIONS_MESSAGE'				=> 'Vamos juntos tornar esta comunidade ainda melhor',
+	'DONATION_STEP_1'				=> '1',
+	'DONATION_STEP_2'				=> '2',
+	'DONATION_STEP_3'				=> '3',
+	'DONATION_STEP_4'				=> '4',
+	
+	'DONATION_STEP_1_INNER'		    => 'Seleciona um montante',
+	'DONATION_STEP_2_INNER'		    => 'Continuar para o PayPal',
+    'DONATION_STEP_3_INNER'	        => 'Regressar ao fórum',
+	'DONATION_STEP_4_INNER'		    => 'Obrigado',
+	
+	'DONATION_DEPOSIT_DISCLAIMER'   => '**Paga com segurança com o PayPal',
+	'DONATION_MY_CREDITS'		    => 'Donativos efetuados',
+	
+	'DONATIONS_NOGUESTS'		    => 'O Fórum precisa que estejas com login efetuado para proceder com o donativo',
+	'DONATIONS_TRANSACTION'		    => 'Transações',
+	'DONATIONS_TRAN'		        => 'Transação ',
+	'DONATIONS_SENDER'		        => 'Doador',
+	'DONATIONS_DIGIT'		        => '.00',
+	'DONATIONS_DONORS'		        => 'Últimos Donativos',
+	'DONATIONS_MSG_PLACEHOLDER'		=> 'Mensagem curta opcional...',
+	
+	'CONTINUE_ON_PAYPAL'		    => 'PayPal',
+	'CONTINUE_ON_BITCOINS'		    => 'Bitcoin',
+	'CONNECTING_ON_PAYPAL'		    => 'A conectar com o PayPal',
+	'BBDONATION_COPY'		        => 'Sistema de Donativos Feito com',
+	'SITESPLAT_EXT_COPY'	        => '',
+	
+	'UCP_DONATION_TITLE'			=> 'Donativos - Geral',
+	'UCP_DONATIONS_EXPLAIN'         => 'Log dos teus donativos',
+	'DONATION_ACTIVITY_UCP_EMPTY'   => 'Não tem donativos efetuados'
+));
diff --git "[FORUM_EXT]/sitesplat\\donations/language/pt/info_acp_donations.php" "[FORUM_EXT]/sitesplat\\donations/language/pt/info_acp_donations.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\donations/language/pt/info_acp_donations.php"
@@ -0,0 +1,106 @@
+<?php
+/**
+*
+* @package BBdonations
+* @copyright (c) 2016 SiteSplat All rights reserved
+* @license Proprietary
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if ( empty($lang) || !is_array($lang) )
+{
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'ACP_DONATIONS'  				=> 'BBDonations',
+	'ACP_DONATIONS_EXPLAIN'			=> 'Donations settings for your website. Configure the desired settings, fill in the PayPal info and the Bitcoin info to maximize your donation results.',
+	'ACP_DONATIONS_INDEX_TITLE'		=> 'Config',
+	'ACP_DONATIONS_PAYPAL_EMAIL'	=> 'Paypal email',
+	'ACP_DONATIONS_PAYPAL_EXPLAIN'	=> 'Enter your PayPal email here. (leave empty to disable donation method) You might need to use PayPal business account as the IPN system might requires it to work correctly.<br /> For more information visit: <a href="https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNSetup/#id089EG030E5Z">PayPal IPN setup</a>',
+	'ACP_DONATIONS_OPTIONS'			=> 'Donation options',
+	'ACP_DONATIONS_OPTIONS_EXPLAIN'	=> 'The following options are available: <br /> <strong>Sandbox Mode:</strong> Allows the sandbox mode (For both Bitcoin and PayPal) which is useful to test the donations. Please beware that Coinbase sandbox is not reliable and therefore a real account should be used to run tests. The easiest way to test it is to use a smartphone app and donate back and forth between your forum and the app. Use the following app for android phones: <a href="https://airbitz.co/af/DJM" target="blank">AirBitz</a> <br /> <strong>Enable message:</strong> This enables the user to leave a short message with the donation <br /> <strong>Show donors:</strong> Enables the last recent donors',
+	'ACP_DONATIONS_SANDBOX'			=> 'Sandbox mode',
+	'ACP_DONATIONS_MESSAGE'			=> 'Enable message',
+	'ACP_DONATIONS_LIST'			=> 'Show donors',
+	'ACP_DONATIONS_BITCOIN'			=> 'Bitcoin',
+	'ACP_DONATIONS_BITCOIN_EXPLAIN' => 'Enter Your coinbase API Key and API Secret here (leave empty to disable donation method). <br /> Follow <strong>EXACTLY</strong> (links open on a new tab) these steps to successfully enable Bitcoin donation: <br /><strong>STEP1:</strong> <a href="https://www.coinbase.com/join/54c7b129d41344b592000006" target="_blank">Register a Coinbase account</a> <br /><strong>STEP2:</strong> <a href="https://www.coinbase.com/merchant_profiles" target="_blank">Setup the merchant page profile</a> <br /><strong>STEP3:</strong> <a href="https://www.coinbase.com/merchant_settings" target="_blank">Setup the merchant settings</a> <br /><strong>STEP4:</strong> In the notification URL option under Merchant settings (STEP3), enter your board URL like this:<br /> <code>http://www.my_board_url.com/app.php/donation/index.html?mode=notify_bitcoin</code> (Where "my_board_url.com" is your real board URL) <br /><strong>STEP5:</strong> Register the the Oauth application here: <a href="https://www.coinbase.com/settings/api" target="_blank">Oauth App</a>. Click on the button "+ New API key" then under "Accounts" checkmark "My Wallet (Primary)", under "Permissions" Click on select all and finally under "Notifications" enter the same URL as described on STEP4. Now click "Create" Button and get your API Key and API Secret to be enter here on your right. <br /><strong>STEP6:</strong> Congrats! Good luck with your donation campaign!',
+	'ACP_DONATIONS_BITCOIN_KEY'		=> 'API Key',
+	'ACP_DONATIONS_BITCOIN_SECRET'	=> 'API Secret',
+	'ACP_DONATIONS_AMOUNTS'			=> 'Amounts',
+	'ACP_DONATIONS_TEXT'			=> 'Text',
+	'ACP_DONATIONS_SYMBOL'			=> 'Symbol',
+	'ACP_DONATIONS_ADD_ROW'			=> 'Add another row',
+	'ACP_DONATIONS_DELL_ROW'		=> 'Delete last row',
+	'ACP_DONATIONS_AMOUNTS_EXPLAIN'	=> 'The following options are available: (Use "%s" as a placeholder to fill in automatically the amount and currency in your text field.) <br /><strong>Amount:</strong> Set the donation amount <br /><strong>Text:</strong> Enter your custom text for the donation amount goal <br /><strong>Symbol:</strong> Select a font awesome symbol for each goal eantered.', 
+	'ACP_DONATIONS_STATUS'			=> 'Status',
+	'ACP_DONATIONS_GROUP'			=> 'Auto Group',
+	'ACP_DONATIONS_GROUP_EXPLAIN'	=> 'The following options are available for the AutoGroup settings: <br /><strong>Days:</strong> time expressed in days for the user to stay on X group. (No time disables fallback for this group) <br /> <strong>Amount:</strong> min currency (donation) value for the AutoGroup to be triggered. (0 disables AutoGroup) <br /><strong>Group:</strong> Group for the user to be moved into when the min. amount is triggered <br /><strong>Group Default:</strong> Set the group to default for the user (Checkmark to set as default)',
+	'ACP_DONATIONS_GROUP_DEF'		=> 'Group default',
+	'ACP_DONATIONS_GROUPS'		    => 'Group',
+	'ACP_DONATIONS_STATS'  			=> 'Statistics',
+	'ACP_DONATIONS_TIME'			=> 'Date',
+	'ACP_DONATIONS_TOTAL'			=> 'Sum of all donations',
+	'ACP_DONATIONS_ADDRESS'			=> 'Donator\'s address',
+	'ACP_DONATIONS_COUNTRY'			=> 'Donator\'s country',
+	'ACP_DONATIONS_TRANSACTIONS'  	=> 'Transactions',
+	'ACP_DONATIONS_FALLBACK'  		=> 'Fallback Group',
+	'ACP_DONATIONS_FALLBACK_EXPLAIN'=> 'A Group fallback for the user to go back to if the time (in Days) is exceeded.<br />No group disables this function.',
+	'ACP_DONATIONS_AMOUNT'			=> 'Amount',
+	
+	'ACP_DONATIONS_DAY_STAY'		=> 'Day to stay in this group',
+	'ACP_DONATIONS_CHANGE_STATUS'	=> 'Change status',
+	'ACP_DONATIONS_MAX_AMO'			=> 'Max amount for this group',
+	
+	'ACP_DONATIONS_DAYS'			=> 'Days',
+	'ACP_DONATIONS_TRANSACTION'		=> 'Transaction id',
+	'ACP_DONATIONS_CURRENCY'		=> 'Currency code',
+	'ACP_DONATIONS_CURRENCY_EXPLAIN'=> 'Currency code follows the allowed <a href="https://developer.paypal.com/docs/classic/api/currency_codes/" target="_blank">Paypal Multiple Currencies</a> standards. <br /> Make sure the currency you are going to use is enabled on your PayPal account. <br />If the currency is not supported on your PayPal acccount the transactions will be returned as "Not verified" or "Pending".',
+	'ACP_DONATIONS_USERNAME'		=> 'Username',
+	'DONATIONS_NOTICE'				=> '<div class="phpinfo"><p>The settings for this extensions are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
+	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+	
+	
+	'SITESPLAT_COM'		        => 'https://sitesplat.com',
+	'SITESPLAT_COPY'		    => '&#169; SiteSplat',
+	'LICENSE_INFO'		        => 'Proprietary - SiteSplat All rights reserved',
+	'EXTENSION_DEVELOPER'	    => 'Developer',
+	'ACP_NOTICE_CLOSE'			=> 'Close',
+	'ACP_DONATIONS_VERSION'     => '1.0.10',
+	'ACP_LOADING'		        => 'Loading... Hold on',
+	
+	'EXT_BBD_DESCRIPTION_PAGE'	=> 'A kick-ass donation extension for the phpBB board running sitesplat themes. Many modern and useful options included PayPal IPN and Bitcoin API.',
+	'EXT_BBD_TASKS_1'			=> 'AutoGroup',
+	'EXT_BBD_TASKS_2'			=> 'Fully editable donation scopes',
+	'EXT_BBD_TASKS_3'			=> 'PayPal IPN',
+	'EXT_BBD_TASKS_4'			=> 'Bitcoins support',
+	'EXT_BBD_TASKS_5'			=> 'phpBB 3.2 ready',
+	'EXT_BBD_TASKS_6'			=> 'Checkout the other premium compatible addons on <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
+	
+));
+
+// Description of Donations extension
+$lang = array_merge($lang, array(
+	'DESCRIPTION_PAGE'		=> 'Description',
+	'DESCRIPTION_NOTICE'	=> 'Extension note',
+	'ext_details' => array(
+		'details' => array(
+			'DESCRIPTION_1'	=> 'Overview of donations',
+			'DESCRIPTION_2'	=> 'Paypal / Bitcoins API',
+			'DESCRIPTION_3'	=> 'Autogroups',
+			'DESCRIPTION_4'	=> 'Set back to standard group after x amount of time',
+			'DESCRIPTION_5'	=> 'Guest can also donate',
+		),
+		'note' => array(
+			'NOTICE_1'		=> 'phpBB 3.2 ready'
+		)
+	)
+));
diff --git "[ORIGINAL]/sitesplat\\donations/styles/FLATBOOTS/template/donations.html" "[FORUM_EXT]/sitesplat\\donations/styles/FLATBOOTS/template/donations.html"
--- "[ORIGINAL]/sitesplat\\donations/styles/FLATBOOTS/template/donations.html"
+++ "[FORUM_EXT]/sitesplat\\donations/styles/FLATBOOTS/template/donations.html"
@@ -1,5 +1,12 @@
 <!-- INCLUDE overall_header.html -->
-<div class="side-segment"><h3>{L_DONATIONS}</h3></div>
+<div class="side-segment">
+	<h3>{L_DONATIONS}</h3>
+</div>
+<!-- IF S_USER_LOGGED_IN -->
+<script async
+  src="https://js.stripe.com/v3/buy-button.js">
+</script>
+
 	<div class="clearfix">
 		<div class="donation-actions">
 			<script>
@@ -7,25 +14,33 @@
 			</script>
 			<form action="<!-- IF SUCCESS or ERROR -->{U_INDEX}<!-- ELSE -->{U_DONATE}<!-- ENDIF -->" method="post">
 				<h2>{L_DONATIONS_THANK_YOU}</h2>
-        <!-- IF DONATIONS_PREMIUM --><p class="donation-premium">{DONATIONS_PREMIUM}</p><!-- ENDIF -->
+				<!-- IF DONATIONS_PREMIUM -->
+				<p class="donation-premium">{DONATIONS_PREMIUM}</p><!-- ENDIF -->
 				<div id="donationmessage">
 					<h3>{L_DONATIONS_MESSAGE}</h3>
 				</div>
 				<div id="donationicons">
 					<!-- BEGIN amounts -->
 					<span<!-- IF amounts.S_ROW_COUNT==1 --> class="selected"<!-- ENDIF --> title="{DONATIONS_CURRENCY_SYMBOL}&nbsp;{amounts.AMOUNT}{L_DONATIONS_DIGIT}">{DONATIONS_CURRENCY_SYMBOL}&nbsp;{amounts.AMOUNT}{L_DONATIONS_DIGIT}</span>
-            <!-- IF amounts.TXT --><p class="hidden-xs">{amounts.TXT}</p><!-- ENDIF -->
+					<!-- IF amounts.TXT -->
+						<p>
+							<b class="hidden-xs">{amounts.TXT}</b>
+							<small class="visible-xs">{amounts.TXT}</small>
+						</p>
+					<!-- ENDIF -->
 						<!-- END amounts -->
 				</div>
 				<input type="range" min="0" max="{STEPS}" step="1" value="1" id="donationvalue">
 
-	<!-- IF S_USER_LOGGED_IN -->  
+				
 				<div id="submission">
 					<div class="input-group">
 						<span class="input-group-addon">
 							<output for="donationvalue">
 								<span>{DONATIONS_CURRENCY_SYMBOL}</span>
-					 <span id="donationoutput"><script>document.write(vals[1])</script>{L_DONATIONS_DIGIT}</span>
+								<span id="donationoutput">
+									<script>document.write(vals[1])</script>{L_DONATIONS_DIGIT}
+								</span>
 							</output>
 						</span>
 						<!-- IF ENABLE_MESSAGE -->
@@ -41,24 +56,37 @@
 				<script>
 					document.getElementById('amount').value = vals[1];
 				</script>
-	<!-- ELSE -->
-      	<p>{L_DONATIONS_NOGUESTS}</p>
-	<!-- ENDIF -->	
-	
 			</form>
-	<div class="space10"></div><p class="text-muted">{L_DONATION_DEPOSIT_DISCLAIMER}</p>
+			<div class="space10"></div>
+			<p class="text-muted">{L_DONATION_DEPOSIT_DISCLAIMER}</p>
 		</div>
- <div class="text-right"><small>{L_BBDONATION_COPY}</small>&nbsp;<i class="fa fa-heart text-flatboots-red heart-ss pulse-ss"></i>&nbsp;<small>{L_BY}<a href="https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat" title="{L_SITESPLAT_EXT_COPY}" target="_blank">&nbsp;{L_SITESPLAT}</a></small></div>
+		<div class="text-right"><small>{L_BBDONATION_COPY}</small>&nbsp;<i class="fa fa-heart text-flatboots-red heart-ss pulse-ss"></i></div>
 	</div>
 
 
+	<div class="space10"></div>
+	<div class="space10"></div>
+	
+	<div class="clearfix" id="donativo-alternativo">
+		<div class="donation-actions">
+		<p class="donation-premium">Donativo com Formas de Pagamento Alternativas</p>
+			<stripe-buy-button
+			  buy-button-id="buy_btn_1SywVYDyIaKunyHURBFSg3Fd"
+			  publishable-key="pk_live_51LWW6mDyIaKunyHU6XX0UewVkgUUzgkxRdIEHwfXFotxwROFdGpJvgRvB3WmLNftiUNOHsHheI7yfVEODlkAcoIY00PjLHM3Hd"
+			>
+			</stripe-buy-button>
+		</div>
+	</div>
+
 	<!-- IF .donors -->
 	<div class="space10"></div>
 	<div class="space10"></div>
-    <div class="side-segment"><h3>{L_DONATIONS_DONORS}</h3></div>
+	<div class="side-segment">
+		<h3>{L_DONATIONS_DONORS}</h3>
+	</div>
 	<div class="row">
 		<div class="panel panel-default">
-	 <div class="panel-body">
+			<div class="panel-body" style="display:flex;flex-wrap:wrap;">
 				<!-- BEGIN donors -->
 				<div class="col-md-3 col-sm-4 col-xs-4">
 					<figure class="member-info">{donors.AVATAR}
@@ -78,12 +106,7 @@
 
 	<!-- IF DONATIONS_COINBASE_CODE -->
 	<div class="bitcoin_box">
-      <iframe
-		  id="{DONATIONS_COINBASE_CODE}"
-		  src="{DONATIONS_COINBASE_URL}/checkouts/{DONATIONS_COINBASE_CODE}/inline"
-		  style="width: 460px; height: 350px; box-shadow: 0 1px 3px rgba(0,0,0,0.25);"
-		  allowtransparency="true"
-		  frameborder="0">
+		<iframe id="{DONATIONS_COINBASE_CODE}" src="{DONATIONS_COINBASE_URL}/checkouts/{DONATIONS_COINBASE_CODE}/inline" style="width: 460px; height: 350px; box-shadow: 0 1px 3px rgba(0,0,0,0.25);" allowtransparency="true" frameborder="0">
 		</iframe>
 	</div>
 	<div class="darken_bitcoin"></div>
@@ -101,4 +124,7 @@
 	<!-- INCLUDEJS @sitesplat_donations/js/char.init.js -->
 	<!-- ENDIF -->
 	<!-- INCLUDEJS @sitesplat_donations/js/donations.js -->
+<!-- ELSE -->
+<p>{L_DONATIONS_NOGUESTS}</p>
+<!-- ENDIF -->
 <!-- INCLUDE overall_footer.html -->
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\donations/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "[FORUM_EXT]/sitesplat\\donations/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
--- "[ORIGINAL]/sitesplat\\donations/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+++ "[FORUM_EXT]/sitesplat\\donations/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
@@ -1,3 +1,4 @@
+
 <!-- IF SCRIPT_NAME == "app/donation/index.html" -->
 	{% INCLUDECSS '@sitesplat_donations/donation.css' %}
 <style>
diff --git "[ORIGINAL]/sitesplat\\donations/styles/FLATBOOTS/template/js/char.init.js" "[FORUM_EXT]/sitesplat\\donations/styles/FLATBOOTS/template/js/char.init.js"
--- "[ORIGINAL]/sitesplat\\donations/styles/FLATBOOTS/template/js/char.init.js"
+++ "[FORUM_EXT]/sitesplat\\donations/styles/FLATBOOTS/template/js/char.init.js"
@@ -1,21 +1,22 @@
 head.ready(function () {
-(function($) { // Avoid conflicts with other libraries
+	(function ($) {
+		// Avoid conflicts with other libraries
 		'use strict';
 
 		// some quick and simple tricks
-	$("#custom_message").focusin(function() {
-        $(".counter-pos").css("display","inline-block");
+		$('#custom_message').focusin(function () {
+			$('.counter-pos').css('display', 'inline-block');
 		});
-	$("#custom_message").focusout(function() {
-		$(".counter-pos").css("display","none");
+		$('#custom_message').focusout(function () {
+			$('.counter-pos').css('display', 'none');
 		});
 
 		// Fix the counter bug once exeeeded functions below is triggered and page reloaded keeping the btn disabled
-	$( ".btn-bbdonation" ).prop( "disabled", false );
+		$('.btn-bbdonation').prop('disabled', false);
 
-	$(".dcount").characterCounter({
-        counterFormat: '%1/50',
-		limit: 50,
+		$('.dcount').characterCounter({
+			counterFormat: '%1/80',
+			limit: 80,
 			counterCssClass: 'counter-pos',
 			counterExceededCssClass: 'exceeded',
 			onExceed: function (count) {
@@ -25,6 +26,5 @@ head.ready(function () {
 				$('.btn-bbdonation').prop('disabled', false);
 			},
 		});
-	
 	})(jQuery); // Avoid conflicts with other libraries
 });
diff --git "[ORIGINAL]/sitesplat\\donations/styles/FLATBOOTS/theme/donation.css" "[FORUM_EXT]/sitesplat\\donations/styles/FLATBOOTS/theme/donation.css"
--- "[ORIGINAL]/sitesplat\\donations/styles/FLATBOOTS/theme/donation.css"
+++ "[FORUM_EXT]/sitesplat\\donations/styles/FLATBOOTS/theme/donation.css"
@@ -389,7 +389,19 @@ input[type=range]::-ms-thumb:hover, input[type=range]::-ms-thumb:active {
    
    #donationmessage {
     height: 100%; 
-    min-height: 76px;
+    min-height: 110px;
+	margin-bottom: 24px;
+    }
+
+	#donationicons > span + p {
+		width: 100%;
+		position: relative;
+		margin-top: -64px;
+	}
+
+	#donationicons {
+	width: auto;
+	flex-wrap: wrap;
 	}
 
 	.member-info .avatar {
```
