<?php

/**
 * @copyright (c) 2024
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACP_VIGLINK_SETTINGS'         => 'Configurações do VigLink',
	'ACP_VIGLINK_SETTINGS_EXPLAIN' => 'O VigLink é um serviço externo que rentabiliza discretamente links colocados pelos utilizadores no seu fórum sem alterar a experiência de utilizador. Quando clicam em links para produtos e compram algo, os comerciantes pagam uma comissão ao VigLink. Apoiando a monetização ajuda projetos.',
	'ACP_VIGLINK_SETTINGS_CHANGE'  => 'Pode alterar estas configurações em qualquer altura no painel de "Configurações do VigLink".',
	'ACP_VIGLINK_SUPPORT_EXPLAIN'  => 'Já não será redirecionado para esta página ao submeter as opções.',
	'ACP_VIGLINK_ENABLE'           => 'Ativar VigLink',
	'ACP_VIGLINK_ENABLE_EXPLAIN'   => 'Ativa o uso de serviços VigLink.',
	'ACP_VIGLINK_EARNINGS'         => 'Reclamar os seus lucros (opcional)',
	'ACP_VIGLINK_EARNINGS_EXPLAIN' => 'Pode reclamar os seus lucros criando uma conta VigLink.',
	'ACP_VIGLINK_DISABLED_PHPBB'   => 'Serviços VigLink foram desativados pelo phpBB.',
	'ACP_VIGLINK_CLAIM'            => 'Reclamar lucros',
	'ACP_VIGLINK_CLAIM_EXPLAIN'    => 'Pode reclamar os lucros do seu fórum. Assine para criar conta.',
	'ACP_VIGLINK_CONVERT_ACCOUNT'  => 'Converter conta',
	'ACP_VIGLINK_NO_CONVERT_LINK'  => 'Não foi possível obter o link de conversão do VigLink.',
]);
