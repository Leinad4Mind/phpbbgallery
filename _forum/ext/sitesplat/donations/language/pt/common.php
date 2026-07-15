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
	'DONATION_DISABLED'				=> 'O Sistema de Donativos encontra-se desactivado',
	'DONATIONS_DONATE'  			=> 'Donativos',
    'DONATIONS_CONTACT_PAYPAL'		=> 'Por favor, aguarde...',
    'DONATIONS_AMOUNT'  			=> 'Montante',
    'DONATIONS_DATE'				=> 'Data',
	'DONATIONS_CUSTOM_MESSAGE'		=> 'Deixe um comentário',
    'DONATIONS_SUCCESS' 			=> 'Donativo efectuado com sucesso',
    'DONATIONS_CANCELLED' 			=> 'Donativo cancelado',
    'DONATIONS_ERROR' 				=> 'Houve um erro no processo do donativo',
	
	'DONATIONS_THANK_YOU'			=> 'Obrigado por apoiares a nossa comunidade!',
	'DONATIONS_PREMIUM'				=> 'Aqueles que doarem um montante igual ou acima de <strong>%s</strong> são adicionados ao grupo VIP que traz alguns benefícios.<br />Ainda por listar!',
	'DONATIONS_MESSAGE'				=> 'Participa no nosso sucesso e vamos todos nós, juntos,<br /> tornar esta comunidade ainda melhor',
	'DONATION_STEP_1'				=> '1',
	'DONATION_STEP_2'				=> '2',
    'DONATION_STEP_3'				=> '3',
	'DONATION_STEP_4'				=> '4',
	
	'DONATION_STEP_1_INNER'		    => 'Selecciona o montante a enviar',
	'DONATION_STEP_2_INNER'		    => 'Continua com segurança no PayPal',
    'DONATION_STEP_3_INNER'	        => 'Regressa ao fórum',
	'DONATION_STEP_4_INNER'		    => 'Diverte-te',
	
	'DONATION_DEPOSIT_DISCLAIMER'   => '**Doa em segurança com o PayPal e <a href="https://www.coinbase.com/join/54c7b129d41344b592000006" target="_blank">CoinBase</a>',
	'DONATION_MY_CREDITS'		    => 'Já doaste',
	
	'DONATIONS_NOGUESTS'		    => 'É necessário que estejas registado e com login efectuado para puderes fazer um donativo',
	'DONATIONS_TRANSACTION'		    => 'Transacções',
	'DONATIONS_TRAN'		        => 'Transacção ',
	'DONATIONS_SENDER'		        => 'Sender',
	'DONATIONS_DIGIT'		        => '.00',
	'DONATIONS_DONORS'		        => 'Últimos donativos',
	'DONATIONS_MSG_PLACEHOLDER'		=> 'Comentário opcional...',
	
	'CONTINUE_ON_PAYPAL'		    => 'PayPal',
	'CONTINUE_ON_BITCOINS'		    => 'Bitcoin',
	'CONNECTING_ON_PAYPAL'		    => 'A conectar com o PayPal',
	'BBDONATION_COPY'		        => 'Sistema de Donativos Desenvolvido Com',
	'SITESPLAT_EXT_COPY'	        => 'GoldTugAnime',
	
	'UCP_DONATION_TITLE'			=> 'Visão Geral dos Donativos',
	'UCP_DONATIONS_EXPLAIN'         => 'O registo das transacções dos teus donativos',
	'DONATION_ACTIVITY_UCP_EMPTY'   => 'Não tens transacções'
));
