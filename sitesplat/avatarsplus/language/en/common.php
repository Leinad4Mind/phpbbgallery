<?php
/**
 *
 * Avatars+. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ALLOW_MATERIAL'					=> 'Enable Material avatars',
	'AVATAR_DRIVER_MATERIAL_TITLE'		=> 'Material avatar',
	'AVATAR_DRIVER_MATERIAL_EXPLAIN'	=> 'Creates an GMail-like avatar by your username.',
	'MATERIAL_SHAPE'					=> 'Avatar shape',
	'MATERIAL_RANDOM'					=> 'Random',
	'MATERIAL_CIRCLE'					=> 'Circle',
	'MATERIAL_COLUMN'					=> 'Column',
	'MATERIAL_DIAMOND'					=> 'Diamond',
	'MATERIAL_RECTANGLE'				=> 'Rectangle',
	'MATERIAL_RHOMB'					=> 'Rhomb',

	'ALLOW_GENERATOR'					=> 'Enable Generator avatars',
	'AVATAR_DRIVER_GENERATOR_TITLE'		=> 'Generator avatar',
	'AVATAR_DRIVER_GENERATOR_EXPLAIN'	=> 'Create your own avatar.',
));
