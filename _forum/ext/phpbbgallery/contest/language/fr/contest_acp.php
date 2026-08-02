<?php
/**
 * phpBB Gallery Contest ACP language.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'CONTEST_CREATION'                    => 'Autoriser les nouveaux concours',
	'CONTEST_CREATION_EXPLAIN'            => 'Permet aux administrateurs de créer de nouveaux albums de concours. Les concours existants restent actifs et modifiables lorsque cette option est désactivée.',
	'CONTEST_CREATION_DISABLED'           => 'La création de nouveaux albums de concours est désactivée dans la configuration de la Galerie.',
]);
