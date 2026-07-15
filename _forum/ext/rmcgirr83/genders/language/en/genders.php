<?php
/**
*
* @package - Genders language
* @copyright (c) 2015 phpBBmodders.net
* @author bonelifer (William Jacoby) bonelifer@phpbbmodders.net
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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

$lang = array_merge($lang, [
	'GENDER'			=> 'Gender',
	'GENDER_NONE'	=> 'None Specified',
	'FA-MARS' 		=> 'Male',
	'FA-VENUS' 		=> 'Female',
	'FA-INTERSEX' 	=> 'Intersex',
	'FA-MARS-DOUBLE'	=> 'Mars Double',
	'FA-MARS-STROKE'	=> 'Mars Stroke',
	'FA-MARS-STROKE-H'	=> 'Mars Stroke H',
	'FA-MARS-STROKE-V'	=> 'Mars Stroke V',
	'FA-MERCURY' 	=> 'Mercury',
	'FA-NEUTER' 	=> 'Neuter',
	'FA-TRANSGENDER'	=> 'Transgender',
	'FA-TRANSGENDER-ALT'	=> 'Transgender Alt',
	'FA-VENUS-DOUBLE'	=> 'Venus Double',
	'FA-VENUS-MARS'	=> 'Venus Mars',
	'FA-GENDERLESS'	=> 'Genderless',
	'MUST_CHOOSE_GENDER'	=>	'You must choose an appropriate gender.',
	//Donation
	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
	'PAYPAL_ALT'                => 'Donate using PayPal',
	'BUY_ME_A_BEER_URL'         => 'https://paypal.me/RMcGirr83',
	'BUY_ME_A_BEER'				=> 'Buy me a beer for creating this extension',
	'BUY_ME_A_BEER_SHORT'		=> 'Make a donation for this extension',
	'BUY_ME_A_BEER_EXPLAIN'		=> 'This extension is completely free. It is a project that I spend my time on for the enjoyment and use of the phpBB community. If you enjoy using this extension, or if it has benefited your forum, please consider <a href="https://paypal.me/RMcGirr83" target="_blank" rel="noreferrer noopener">buying me a beer</a>. It would be greatly appreciated. <i class="fa fa-smile-o" style="color:green;font-size:1.5em;" aria-hidden="true"></i>',
]);
