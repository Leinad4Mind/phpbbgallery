<?php

/**
 * UserDefaults extension for the phpBB Forum Software package.
 * @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
 * @license Proprietary
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
	'ACP_USERDEFAULT'         => 'Predefinições de Utilizador',
	'ACP_USERDEFAULT_EXPLAIN' => 'Configurar as Predefinições de Utilizador, uma vez alteradas não afetarão os utilizadores antigos, mas serão as definições predefinidas para os novos utilizadores registados. Se quiser a configuração para todos os utilizadores, terá de executar "Sincronizar todos os utilizadores", isso irá alterar todas as definições para todos os utilizadores registados para a predefinição mostrada.',
	'ACP_USERDEFAUL_SETTINGS' => 'Configurar Predefinições de Utilizador',
	'POPUP_PM'                => 'Janela pop-up para novas mensagens privadas',
	'VIEW_POSTS_TOPICS'       => 'Configuração de Mensagens e Tópicos',
	'SORT_DAYS'               => 'Ordenar tempo',
	'SORT_DIRECTION'          => 'Direção da ordenação',
	'VARIANT_DATE_SEPARATOR'  => ' | ',
	'ACP_USERDEFAULT_SAVED'   => 'Predefinições de Utilizador guardadas',
	'SYNC_USERS'              => 'Sincronizar todos os utilizadores',
	'SYNC_USERS_EXPLAIN'      => 'Definir predefinições para todos os utilizadores, tenha cuidado pois não é reversível!',
	'USERDEFAULT_NOTICE'      => '<div class="phpinfo"><p class="entry">As definições de configuração deste módulo estão em %1$s » %2$s » %3$s.</p></div>',
	'FH_HELPER_NOTICE'        => 'A aplicação ajudante forumhulp não existe!<br />Transfere <a href="https://github.com/ForumHulp/helper">forumhulp/helper</a> e copia a pasta helper para a pasta da tua extensão forumhulp.',
]);
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Opções',
			'DESCRIPTION_2' => 'Opções gerais',
			'DESCRIPTION_3' => 'Configurações de Mensagens e Tópicos',
			'DESCRIPTION_4' => 'Configurações de notificação',
			'DESCRIPTION_5' => 'Configuração predefinida para todos os utilizadores',
		],
		'note' => [
			'NOTICE_1' => 'Pronto para 3.2.1.',
		]
	]
]);
