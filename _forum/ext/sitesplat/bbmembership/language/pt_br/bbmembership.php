<?php

/**
 * BBmembership extension for the phpBB Forum Software package.
 * @copyright (c) 2015 SiteSplat All rights reserved
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
	'BBMEMBERSHIP' => 'Membros (Memberships)',

	'BBMEMBERSHIP_POINTS'             => 'Pontos (Points)',
	'CONTINUE_ON_BBPOINTS'            => 'com os BBpoints',
	'CONNECTING_ON_BBPOINTS'          => 'A validar os seus BBpoints',
	'CONTINUE_ON_PAYPAL'              => 'com o PayPal',
	'CONNECTING_ON_PAYPAL'            => 'A ligar/conectar com o PayPal',
	'PAYPAL_ALT'                      => 'Pagamentos através do PayPal',
	'BBMEMBERSHIP_DEPOSIT_DISCLAIMER' => '**Todas as transações e ou os pagamentos demoram normalmente um curto espaço de tempo desde segundos a um máximo de 24 horas até estarem totalmente validadas. Para todos os usuários que se pretendam tornar ou efetuar compras de nível superior a %s100, ou para quaisquer outros assuntos urgentes, queiram por favor entrar em contacto com a <a href="./memberlist.php?mode=contactadmin">Administração do Fórum</a>.',
	'BBMEMBERSHIP_STATUS'             => 'Qual é a sua Situação/Estatuto neste momento:',
	'BBMEMBERSHIP_EXPIRED_INFO'       => 'N/A',
	'DAYS_TO_EXPIRATION'              => [
		0 => '%1$s dias',
		1 => '%1$s dia',
		2 => '%1$s dias'
	],

	'BBMEMBERSHIP_PURCHASED'    => 'Adquirido com sucesso',
	'BBMEMBERSHIP_PENDING'      => 'A aguardar confirmação / Pendente',
	'BBMEMBERSHIP_TAX_TEXT'     => 'Poderá incluir e/ou acrescer as habituais taxas/impostos',
	'BB_CURRENCY_ZERO_ZERO'     => '00',
	'BB_CURRENCY_ZERO_ZERO_DEC' => '.00',

	'MEMBERSHIP_LEVEL'         => 'Nível e ou Escalão',
	'MEMBERSHIP_ENDS_IN'       => 'Termina dentro de:',
	'MEMBERSHIP_LIMITED'       => 'Atenção, Limitado de momento!',
	'MEMBERSHIP_TIME'          => 'Vitalício e ou durabilidade (exibido em dias)',
	'MEMBERSHIP_UNLIMITED'     => 'Ilimitado',
	'MEMBERSHIP_SUCCESS'       => 'Gostaríamos de agradecer o seu apoio e também a sua subscrição! A mesma encontra-se num breve processo de verificação e a sua transação/pagamento serão validados em breve.',
	'MEMBERSHIP_FAILED_POINTS' => 'Lamentamos imenso mas de momento não possuí o número de pontos suficientes na sua conta que lhe permitam concluir a transação desta sua adesão!',
	'MEMBERSHIP_FAILED_PP'     => 'Lamentamos o incómodo mas o sistema obteve e acusou um erro interno na validação com a transação e ou pagamento. Por favor verifique de novo o processo e caso o problema persista reporte à Administração do Fórum.',
	'MEMBERSHIP_DOUBLE'        => 'O que está a fazer!!? Reparamos que já possuí um "pack" idêntico adquirido no sistema. Como deve de calcular e por questões óbvias apenas as dádivas são acumuláveis.',
	'MEMBERSHIP_CANCELED'      => 'O processo encontrou-se de momento cancelado.',
	'PRIVATE_BOARD'            => 'ACESSO RESTRITO - FÓRUM PRIVADO',
	'MEMBERSHIP_NO_AUTH'       => 'Desculpe, não se encontra de momento devidamente autorizado a utilizar este hiperlink/url!',
	'BBMEMBERSHIP_CLUBMODE'    => 'Para conseguir aceder ao fórum terá de adquirir uma quota/registro que seja válida de momento. O fórum encontra-se configurado em modo privado e por esse mesmo motivo o seu acesso fica estritamente restrito a membros e ou a usuários aderentes.',
]);
