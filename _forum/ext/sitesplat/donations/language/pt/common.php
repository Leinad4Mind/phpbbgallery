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
	'DONATION_DISABLED'				=> 'Os donativos encontram-se desativados',
	'DONATIONS_DONATE'  			=> 'Donativo',
    'DONATIONS_CONTACT_PAYPAL'		=> 'Por favor, aguarda...',
    'DONATIONS_AMOUNT'  			=> 'Montante',
    'DONATIONS_DATE'				=> 'Data',
	'DONATIONS_CUSTOM_MESSAGE'		=> 'Deixa uma mensagem',
    'DONATIONS_SUCCESS' 			=> 'O donativo foi efetuado com sucesso',
    'DONATIONS_CANCELLED' 			=> 'O donativo foi cancelado',
    'DONATIONS_ERROR' 				=> 'Ocorreu um erro com o donativo',
	
	'DONATIONS_THANK_YOU'			=> 'Obrigado por desejares contribuir para a nossa comunidade!',
	'DONATIONS_PREMIUM'				=> 'Os utilizadores que doem um montante igual ou acima de <strong>%s</strong>, são adicionados a um grupo especial que trará diversos benefícios!',
	'DONATIONS_MESSAGE'				=> 'Vamos juntos tornar esta comunidade ainda melhor',
	'DONATION_STEP_1'				=> '1',
	'DONATION_STEP_2'				=> '2',
	'DONATION_STEP_3'				=> '3',
	'DONATION_STEP_4'				=> '4',
	
	'DONATION_STEP_1_INNER'		    => 'Seleciona um montante',
	'DONATION_STEP_2_INNER'		    => 'Continuar para o PayPal',
    'DONATION_STEP_3_INNER'	        => 'Regressar ao fórum',
	'DONATION_STEP_4_INNER'		    => 'Obrigado',
	
	'DONATION_DEPOSIT_DISCLAIMER'   => '**Paga com segurança com o PayPal',
	'DONATION_MY_CREDITS'		    => 'Donativos efetuados',
	
	'DONATIONS_NOGUESTS'		    => 'O Fórum precisa que estejas com login efetuado para proceder com o donativo',
	'DONATIONS_TRANSACTION'		    => 'Transações',
	'DONATIONS_TRAN'		        => 'Transação ',
	'DONATIONS_SENDER'		        => 'Doador',
	'DONATIONS_DIGIT'		        => '.00',
	'DONATIONS_DONORS'		        => 'Últimos Donativos',
	'DONATIONS_MSG_PLACEHOLDER'		=> 'Mensagem curta opcional...',
	
	'CONTINUE_ON_PAYPAL'		    => 'PayPal',
	'CONTINUE_ON_BITCOINS'		    => 'Bitcoin',
	'CONNECTING_ON_PAYPAL'		    => 'A conectar com o PayPal',
	'BBDONATION_COPY'		        => 'Sistema de Donativos Feito com',
	'SITESPLAT_EXT_COPY'	        => '',
	
	'UCP_DONATION_TITLE'			=> 'Donativos - Geral',
	'UCP_DONATIONS_EXPLAIN'         => 'Log dos teus donativos',
	'DONATION_ACTIVITY_UCP_EMPTY'   => 'Não tem donativos efetuados'
));
