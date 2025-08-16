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
	'FORCINGPROFILEFIELDS_SKIP_METAREFRESH'			=> 'Omitir meta-refresh cuando se redirige al usuario para actualizar su perfil',
	'FORCINGPROFILEFIELDS_SKIP_METAREFRESH_EXPLAIN'	=> 'Si se establece en sí, el usuario se redirige a la página de edición del perfil de UCP sin que se muestre ningún mensaje.',
]);
