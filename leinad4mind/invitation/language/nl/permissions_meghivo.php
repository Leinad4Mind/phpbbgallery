<?php

/**
 *
 * Invitation. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2021, Leinad4Mind, https://leinad4mind.top/forum
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
// Some characters you may want to copy&paste: ’ « » „ “ ” …

$lang = array_merge($lang, array(
	'ACL_A_MEGHIVO'			=> 'Gebruiker kan data synchroniseren',
	'ACL_A_MEGHIVO_CONFIG'	=> 'Gebuiker kan uitnodigings instellingen veranderen.',
	'ACL_A_MEGHIVO_DELETE'	=> 'Gebruiker kan uitnodigingen verwijderen',
	'ACL_A_MEGHIVO_IGENY'	=> 'Gebruiker kan uitnodigingen beheren',
	'ACL_A_MEGHIVO_KULDES'	=> 'Gebruiker kan uitnodigingen toewijzen aan leden',
	'ACL_A_MEGHIVO_PEND'	=> 'Gebruiker kan wachtende uitnodigingen beheren',
	'ACL_A_MEGHIVO_USERS'	=> 'Gebruiker kan een lijst van uitgenodigde leden zien',
	'ACL_M_MEGHIVO_IGENY'	=> 'Gebruiker kan een aanvraag van een uitnodiging accepteren.',
	'ACL_U_MEGHIVO_DELET'	=> 'Gebruiker kan een uitnodiging intrekken<br /><em>Gebruiker kan een uitnodiging die hij heeft gestuurd annuleren.</em>',
	'ACL_U_MEGHIVO_KERES'	=> 'Gebruiker kan een uitnodiging aanvragen',
	'ACL_U_MEGHIVO_KULD'	=> 'Gebruiker kan leden uitnodigen naar de site',
	'ACL_U_MEGHIVO_MAX'		=> 'Gebruiker heeft ongelimiteerd uitnodigingen',
	'ACL_U_MEGHIVO_USERS'	=> 'Gebruiker kan de lijst met uitnodigingen door andere bekijken.',
));
