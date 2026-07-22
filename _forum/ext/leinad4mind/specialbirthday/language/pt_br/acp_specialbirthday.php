<?php

/**
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'NEW_VERSION'                         => 'Nova Versão',
	'NEW_VERSION_EXPLAIN'                 => 'Existe uma versão mais recente desta extensão disponível.',
	'REGISTRATION_AGE_ADMIN'              => 'Permitir a admins/mods ver a idade',
	'REGISTRATION_AGE_BAN_LENGTH'         => 'Duração do banimento',
	'REGISTRATION_AGE_BAN_LENGTH_EXPLAIN' => 'O tempo que o endereço IP do usuário estará banido.',
	'REGISTRATION_AGE_BAN_REASON'         => 'Razão apresentada ao banido',
	'REGISTRATION_AGE_BAN_REASON_EXPLAIN' => 'Esta é a razão do banimento que será apresentada ao usuário.',
	'REGISTRATION_AGE_MEMBERLIST'         => 'Mostrar idade na lista de membros (ver perfil)',
	'REGISTRATION_AGE_VIEWTOPIC'          => 'Mostrar idade no viewtopic',
	'REGISTRATION_AGE_SEARCH'             => 'Mostrar idade nos resultados de pesquisa (vista de mensagens)',
	'REGISTRATION_AGE_CHANGE'             => 'Permitir aos usuários mudarem os seus aniversários',
	'REGISTRATION_AGE_EXPLAIN'            => 'Selecione a idade na qual deseja limitar o acesso.',
	'REGISTRATION_AGE_REQUIRED'           => 'Os usuários são obrigados a inserir a data de nascimento',
	'REGISTRATION_AGE_REG_DISPLAY'        => 'Mostrar campo de aniversário no registro',
	'REGISTRATION_AGE_IP'                 => 'Bloquear IP',
	'REGISTRATION_AGE_IP_EXPLAIN'         => 'Banir o endereço IP do usuário que tentar se registrar sendo menor de idade.',
	'REGISTRATION_AGE_LOG'                => 'Registrar tentativas falhadas',
	'REGISTRATION_AGE_LOG_EXPLAIN'        => 'Criar uma entrada de registro para tentativas de registro falhadas devido à idade.',
	'REGISTRATION_AGE_OPTIONS'            => 'Opções de Aniversário Especial',
	'BAN_END_TEXT'                        => [
		'0'     => 'Permanente',
		'30'    => '30 minutos',
		'60'    => '1 hora',
		'360'   => '6 horas',
		'1440'  => '1 dia',
		'10080' => '7 dias',
		'20160' => '2 semanas',
		'40320' => '1 mês',
	],
]);
