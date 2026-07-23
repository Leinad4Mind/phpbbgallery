<?php

/**
 * BBmembership extension for the phpBB Forum Software package.
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'CONNECTING_ON_BBPOINTS'          => 'A validar os teus BBpoints',
	'CONTINUE_ON_PAYPAL'              => 'com o PayPal',
	'CONNECTING_ON_PAYPAL'            => 'A ligar/conectar com o PayPal',
	'PAYPAL_ALT'                      => 'Pagamentos através do PayPal',
	'BBMEMBERSHIP_DEPOSIT_DISCLAIMER' => '**Todas as transações e ou os pagamentos demoram normalmente um curto espaço de tempo desde segundos a um máximo de 24 horas até estarem totalmente validadas. Para todos os utilizadores que se pretendam tornar ou efectuar compras de nível superior a %s100, ou para quaisquer outros assuntos urgentes, queiram por favor entrar em contacto com a <a href="./memberlist.php?mode=contactadmin">Administração do Fórum</a>.',
	'BBMEMBERSHIP_STATUS'             => 'Qual é a tua Situação/Estatuto neste momento:',
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
	'MEMBERSHIP_SUCCESS'       => 'Gostaríamos de agradecer o teu apoio e também a tua subscrição! A mesma encontra-se num breve processo de verificação e a tua transação/pagamento serão validados em breve.',
	'MEMBERSHIP_FAILED_POINTS' => 'Lamentamos imenso mas de momento não possuis o número de pontos suficientes na tua conta que te permitam concluir a transação desta tua adesão!',
	'MEMBERSHIP_FAILED_PP'     => 'Lamentamos o incómodo mas o sistema obteve e acusou um erro interno na validação com a transação e ou pagamento. Por favor verifica de novo o processo e caso o problema persista reporta à Administração do Fórum.',
	'MEMBERSHIP_DOUBLE'        => 'O que estás a fazer!!? Reparamos que já possuis um "pack" idêntico adquirido no sistema. Como deves calcular, por questões óbvias, apenas as dádivas são acumuláveis.',
	'MEMBERSHIP_CANCELED'      => 'O processo encontrou-se de momento cancelado.',
	'PRIVATE_BOARD'            => 'ACESSO RESTRITO - FÓRUM PRIVADO',
	'MEMBERSHIP_NO_AUTH'       => 'Desculpe, não se encontra de momento devidamente autorizado a utilizar este hiperlink/url!',
	'BBMEMBERSHIP_CLUBMODE'    => 'Para conseguires aceder ao fórum terás de adquirir uma quota/registo que seja válida de momento. O fórum encontra-se configurado em modo privado e por esse mesmo motivo o teu acesso fica estritamente restrito a membros e ou a utilizadores aderentes.',
]);
