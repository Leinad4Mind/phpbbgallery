<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2018, Leinad4Mind, https://leinad4mind.top/forum
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
	'MEGHIVO_BIRTHDAY'						=> 'Születésnapod alkalmából kiutaltunk ajándékba %s darab meghívót.<br /><br />Boldog szülinapot kívánunk.',

	'MEGHIVO_GIFT_INVITED_USERS_FIRST'		=> 'Szia, ezt az üzenetet azért kaptad, mert meghívtál %s felhasználót, a “%s” weboldalra, amiért nagyon hálásak vagyunk. Szeretnénk, ha továbbra is igénybe vennéd a meghívó rendszert, ezért ajándékba kiutaltunk számodra %s meghívót.<br /><br />További kellemes időtöltést kívánunk.',
	'MEGHIVO_GIFT_INVITED_USERS_FURTHER'	=> 'Szia, ezt az üzenetet azért kaptad, mert meghívtál újabb %s felhasználót, a “%s” weboldalra, amiért nagyon hálásak vagyunk. Szeretnénk, ha továbbra is igénybe vennéd a meghívó rendszert, ezért ajándékba kiutaltunk számodra %s meghívót.<br /><br />További kellemes időtöltést kívánunk.',

	'MEGHIVO_PETITION_TITLE'				=> 'Meghívó kérelem',
	'MEGHIVO_PETITIONS_NO'					=> 'A kérelmedet elutasítottuk, így a meghívókat nem utaltuk ki számodra.',
	'MEGHIVO_PETITION_NO'					=> 'A kérelmedet elutasítottuk, így a meghívót nem utaltuk ki számodra.',
	'MEGHIVO_PETITION_YES'					=> 'A kérelmedet elfogadtuk, %s db meghívót jóváírtunk.',

	'MEGHIVO_PETITION_REQUEST'				=> 'The user %s is requesting %d invitations',

	'MEGHIVO_JOIN'							=> 'Thank you for inviting the user %s',
));
