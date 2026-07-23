<?php

/**
 * BBbbprofile. An extension for the phpBB Forum Software package.
 * @copyright (c) 2016, SiteSplat
 * @license Proprietary
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
	'ACP_BBPROFILE'           => 'BBprofile',
	'BBPROFILE_SETTING_SAVED' => 'As configurações do BBprofile foram salvas.',

	'SS_HELPER_NOTY'   => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBPROFILE_NOTICE' => '<div class="phpinfo"><p>As configurações para esta extensão estão na aba <strong>EXTENSÕES</strong>.</p><br /><p>Não se esqueça de verificar a Permissão de Grupo "Pode ver a caixa BBprofile" em: Permissões de Grupo &#187; Diversos.</p></div>',

	'BBPROFILE_LABEL'         => 'Quando devemos exibir o BBprofile?',
	'BBPROFILE_LABEL_EXPLAIN' => 'Escolha a localização da caixa de perfil',
	'UCP_ONLY'                => 'Apenas na UCP',
	'OVEARALL_HEADER'         => 'Cabeçalho geral',

	'BBPROFILE_ENABLED'         => 'Partes do BBprofile ativadas:',
	'BBPROFILE_ENABLED_EXPLAIN' => 'Escolha as partes do perfil que devem contar para os 100% de conclusão do perfil',

		'PREDEFINED' => 'Predefinido',
	'CPF'         => 'Campos de Perfil Personalizados',

	'BBPROFILE_HIDE_FOR_ADMINS'   => 'Ocultar a caixa BBprofile para administradores:',
	'HIDE_FOR_ADMINS'             => 'Ocultar para administradores',
	'BBPROFILE_HIDE_FOR_MODS'     => 'Ocultar a caixa BBprofile para moderadores globais',
	'HIDE_FOR_MODS'               => 'Ocultar para moderadores globais',
	'BBPROFILE_HIDDEN_FOR_ADMINS' => 'A caixa BBprofile foi ocultada para os administradores.',
	'BBPROFILE_HIDDEN_FOR_MODS'   => 'A caixa BBprofile foi ocultada para os moderadores globais.',
]);
