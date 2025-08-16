<?php
/**
*
* Extension - Best Answer
*
* @copyright (c) 2015 kinerity <http://www.acsyste.com>
* @license GNU General Public License, version 2 (GPL-2.0)
* Estonian translation by phpBBeesti.net <http://www.phpbbeesti.net>
*
*/

/**
* DO NOT CHANGE
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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'ANSWERED'	=> 'VASTATUD',

	'BEST_ANSWER'	=> 'PARIM VASTUS',
	'BUTTON_MARK_ANSWER'	=> 'Märgi vastuseks',
	'BUTTON_UNMARK_ANSWER'	=> 'Tühista vastus',

	'ENABLE_BESTANSWER'			=> 'Luba "Parim vastus" funktsioon',
	'ENABLE_BESTANSWER_EXPLAIN'	=> 'Kui lubatud, siis teema algata (kui lubatud) ja moderaatorid (kui lubatud) saavad märkida teemas olevat postitust kui "parimaks vastuseks".',
	'EXTENSION_NOT_ENABLED'		=> 'Parim vastus laiendus ei ole lubatud selles foorumis.',

	'FULL_POST'	=> 'VAATA TÄIELIKKU POSTITUST',

	'INVALID_FILTER'	=> 'Filtri parameeter on vigane. Palun kontrolli, kas see muutuja on õige.',

	'LOG_MARK_ANSWER'	=> '<strong>Märgitud kui parimaks vastuseks</strong><br />» %1$s kasutaja %2$s poolt',
	'LOG_UNMARK_ANSWER'	=> '<strong>Parim vastus tühistatud</strong><br />» %1$s kasutaja %2$s poolt',

	'MARK_ANSWER'			=> 'Märgi postitus parimaks vastuseks',
	'MARK_ANSWER_CONFIRM'	=> 'Kas oled kindel, et soovid selle postituse märkida parimaks vastuseks?',

	'TOPIC_FIRST_POST'	=> 'Sa ei saa märkida parimaks vastuseks teema esimest postitust.',
	'TOPICS_ANSWERED'	=> 'Vastatud teemad',

	'UNMARK_ANSWER'			=> 'Tühista parim vastus',
	'UNMARK_ANSWER_CONFIRM'	=> 'Kas oled kindel, et soovid tühistada antud postituse parim vastus tiitlist?',
));
