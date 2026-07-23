<?php

/**
 * @package BBdonations for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'DONATIONS'                => 'Doações',
	'DONATION'                 => 'Doação',
	'DONATIONS_INDEX'          => 'Doações',
	'DONATION_DISABLED'        => 'As doações estão desabilitadas',
	'DONATIONS_DONATE'         => 'Doar',
	'DONATIONS_CONTACT_PAYPAL' => 'Por favor, aguarde...',
	'DONATIONS_AMOUNT'         => 'Valor',
	'DONATIONS_DATE'           => 'Data',
	'DONATIONS_CUSTOM_MESSAGE' => 'Deixe uma mensagem',
	'DONATIONS_SUCCESS'        => 'A doação foi feita com sucesso',
	'DONATIONS_CANCELLED'      => 'A doação foi cancelada',
	'DONATIONS_ERROR'          => 'Ocorreu um erro com a doação',

	'DONATIONS_THANK_YOU' => 'Obrigado por pensar em apoiar a nossa comunidade!',
	'DONATIONS_PREMIUM'   => 'Os usuários que doarem um valor igual ou acima de <strong>%s</strong> são adicionados a um grupo especial com benefícios especiais no fórum.<br />Rank personalizado, cor e muito mais!',
	'DONATIONS_MESSAGE'   => 'Participe do nosso sucesso e vamos juntos tornar a nossa comunidade ainda melhor',
	'DONATION_STEP_1'     => '1',
	'DONATION_STEP_2'     => '2',
	'DONATION_STEP_3'     => '3',
	'DONATION_STEP_4'     => '4',

	'DONATION_STEP_1_INNER' => 'Selecione um valor de depósito',
	'DONATION_STEP_2_INNER' => 'Continue com segurança no PayPal',
	'DONATION_STEP_3_INNER' => 'Voltar ao fórum',
	'DONATION_STEP_4_INNER' => 'Aproveite',

	'DONATION_DEPOSIT_DISCLAIMER' => '**Pague com segurança com o PayPal e <a href="https://www.coinbase.com/join/54c7b129d41344b592000006" target="_blank">CoinBase</a>',
	'DONATION_MY_CREDITS'         => 'Já doado',

	'DONATIONS_NOGUESTS'        => 'O fórum exige que você faça login antes de prosseguir com uma doação',
	'DONATIONS_TRANSACTION'     => 'Transações',
	'DONATIONS_TRAN'            => 'Transação ',
	'DONATIONS_SENDER'          => 'Remetente',
	'DONATIONS_DIGIT'           => '.00',
	'DONATIONS_DONORS'          => 'Últimos doadores',
	'DONATIONS_MSG_PLACEHOLDER' => 'Mensagem curta opcional...',

	'CONTINUE_ON_PAYPAL'   => 'PayPal',
	'CONTINUE_ON_BITCOINS' => 'Bitcoin',
	'CONNECTING_ON_PAYPAL' => 'Conectando com o PayPal',
	'BBDONATION_COPY'      => 'Doação Construída Com',
	'SITESPLAT_EXT_COPY'   => 'Desenvolvimento Web Profissional e Temas Premium',

	'UCP_DONATION_TITLE'          => 'Visão geral das doações',
	'UCP_DONATIONS_EXPLAIN'       => 'Registro das suas transações de doação',
	'DONATION_ACTIVITY_UCP_EMPTY' => 'Você não tem transações'
]);
