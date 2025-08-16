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
	'MEGHIVO_BIRTHDAY'						=> 'Gefeliciteerd! Je onvangt %s uitnodiging(en) voor je verjaardag.<br /><br />Wij wensen jou een fijne verjaardag!',

	'MEGHIVO_GIFT_INVITED_USERS_FIRST'		=> 'Hoi, dit is  een bericht dat je krijgt van ons voor het uitnodigen van %s gebruiker op de “%s” site, wij zijn heel dankbaar hiervoor. Wij willen het uitnodigins systeem blijven gebruiken, daarom krijg je extra %s uitnodigingen.<br /><br />Wij wensen u een aangename tijd.',
	'MEGHIVO_GIFT_INVITED_USERS_FURTHER'	=> 'Hoi, dit is  een bericht dat je krijgt van ons voor het uitnodigen van %s gebruikers op de “%s” site, wij zijn heel dankbaar hiervoor. Wij willen het uitnodigins systeem blijven gebruiken, daarom krijg je extra %s uitnodigingen.<br /><br />Wij wensen u een aangename tijd.',

	'MEGHIVO_PETITION_TITLE'				=> 'Uitnodiging verzoek',
	'MEGHIVO_PETITIONS_NO'					=> 'Je verzoek is niet ingewilligd, dus de uitnodigingen worden niet aan jouw toegewezen!',
	'MEGHIVO_PETITION_NO'					=> 'Je verzoek is niet ingewilligd, dus de uitnodiging wordt niet aan jouw toegewezen!',
	'MEGHIVO_PETITION_YES'					=> 'Je verzoek wordt ingewilligd, %s uitnodiging(s) gecrediteerd!',

	'MEGHIVO_PETITION_REQUEST'				=> 'The user %s is requesting %d invitations',

	'MEGHIVO_JOIN'							=> 'Thank you for inviting the user %s',
));
