<?php

/**
 *
 * Forcing Profile Fields. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, leinad4mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
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
	'FORCINGPROFILEFIELDS_SKIP_METAREFRESH'			=> 'Omitir mensagem meta-refresh quando se redirecciona o usuário para ele atualizar o seu perfil',
	'FORCINGPROFILEFIELDS_SKIP_METAREFRESH_EXPLAIN'	=> 'Caso coloque sim, o usuário será automáticamente redireccionado à página de edição de perfil do UCP sem mostrar nenhuma mensagem.',
]);
