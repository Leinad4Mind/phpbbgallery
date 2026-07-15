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
	'DONATIONS'						=> 'Donativos',
	'DONATION'						=> 'Donativo',
    'DONATIONS_INDEX'				=> 'Donativos',
	'DONATION_DISABLED'				=> 'Donativos desactivados',
	'DONATIONS_DONATE'  			=> 'Donativos',
    'DONATIONS_CONTACT_PAYPAL'		=> 'Por favor, aguarde…',
    'DONATIONS_AMOUNT'  			=> 'Montante',
    'DONATIONS_DATE'				=> 'Data',
	'DONATIONS_CUSTOM_MESSAGE'		=> 'Deixe uma mensagem',
    'DONATIONS_SUCCESS' 			=> 'Donativo efectuado com sucesso',
    'DONATIONS_CANCELLED' 			=> 'Donativo cancelado',
    'DONATIONS_ERROR' 				=> 'Ocorreu um erro com o donativo',
	
	'DONATIONS_THANK_YOU'			=> 'Obrigado por ajudares a suportar a nossa comunidade!',
	'DONATIONS_PREMIUM'				=> 'Os que doarem acima de <strong>%s</strong> serão movidos automaticamente para o Grupo VIP na qual terão benefícios.',
	'DONATIONS_MESSAGE'				=> 'Participa no nosso projecto e juntos iremos tornar a nossa comunidade ainda melhor',
	'DONATION_STEP_1'				=> '1',
	'DONATION_STEP_2'				=> '2',
    'DONATION_STEP_3'				=> '3',
	'DONATION_STEP_4'				=> '4',
	
	'DONATION_STEP_1_INNER'		    => 'Seleciona um montante',
	'DONATION_STEP_2_INNER'		    => 'Continuar para o PayPal de forma segura',
    'DONATION_STEP_3_INNER'	        => 'Regressar ao fórum',
	'DONATION_STEP_4_INNER'		    => 'Diverte-te!',
	
	'DONATION_DEPOSIT_DISCLAIMER'   => '**Envie pelo PayPal com segurança e pelo <a href="https://www.coinbase.com/join/58ac81283f614d466fe94fa3" target="_blank">CoinBase</a>',
	'DONATION_MY_CREDITS'		    => 'Já doou',
	
	'DONATIONS_NOGUESTS'		    => 'O fórum requer que estejas com sessão iniciada antes de proceder com o donativo',
	'DONATIONS_TRANSACTION'		    => 'Transacções',
	'DONATIONS_TRAN'		        => 'Transacção ',
	'DONATIONS_SENDER'		        => 'Enviado',
	'DONATIONS_DIGIT'		        => '.00',
	'DONATIONS_DONORS'		        => 'Últimos doadores',
	'DONATIONS_MSG_PLACEHOLDER'		=> 'Mensagem curta opcional...',
	
	'CONTINUE_ON_PAYPAL'		    => 'PayPal',
	'CONTINUE_ON_BITCOINS'		    => 'Bitcoin',
	'CONNECTING_ON_PAYPAL'		    => 'A conectar-se ao PayPal',
	'BBDONATION_COPY'		        => 'Criado com',
	'SITESPLAT_EXT_COPY'	        => 'Professional Web Development',
	
	'UCP_DONATION_TITLE'			=> 'Informação dos Donativos',
	'UCP_DONATIONS_EXPLAIN'         => 'Os teus logs de transacções de donativos',
	'DONATION_ACTIVITY_UCP_EMPTY'   => 'Não tem nenhuma transacção efectuada'
));
