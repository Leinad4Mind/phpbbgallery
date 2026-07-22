<?php

/**
 * @package - Genders language for phpBB.
 * @copyright (c) 2015 phpBBmodders.net
 * @author bonelifer (William Jacoby) bonelifer@phpbbmodders.net
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'GENDER'             => 'Género',
	'GENDER_NONE'        => 'Não Especificado',
	'FA-MARS'            => 'Masculino',
	'FA-VENUS'           => 'Feminino',
	'FA-INTERSEX'        => 'Intersexo',
	'FA-MARS-DOUBLE'     => 'Duplo Masculino',
	'FA-MARS-STROKE'     => 'Androginia',
	'FA-MARS-STROKE-H'   => 'Andrógino H',
	'FA-MARS-STROKE-V'   => 'Andrógino V',
	'FA-MERCURY'         => 'Mercúrio',
	'FA-NEUTER'          => 'Neutro',
	'FA-TRANSGENDER'     => 'Transgénero',
	'FA-TRANSGENDER-ALT' => 'Transgénero Alt',
	'FA-VENUS-DOUBLE'    => 'Duplo Feminino',
	'FA-VENUS-MARS'      => 'Masculino e Feminino',
	'FA-GENDERLESS'      => 'Sem género',
	'MUST_CHOOSE_GENDER' => 'Deves escolher um género apropriado.',
	//Donation
	'PAYPAL_IMAGE_URL'      => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
	'PAYPAL_ALT'            => 'Doar através de PayPal',
	'BUY_ME_A_BEER_URL'     => 'https://paypal.me/RMcGirr83',
	'BUY_ME_A_BEER'         => 'Oferece-me uma cerveja por criar esta extensão',
	'BUY_ME_A_BEER_SHORT'   => 'Faz um donativo para esta extensão',
	'BUY_ME_A_BEER_EXPLAIN' => 'Esta extensão é completamente gratuita. É um projecto ao qual dedico o meu tempo, pelo gosto e para o uso da comunidade phpBB. Se gostas de usar esta extensão, ou se ela beneficiou o teu fórum, por favor considera <a href="https://paypal.me/RMcGirr83" target="_blank" rel="noreferrer noopener">oferecer-me uma cerveja</a>. Seria muito apreciado. <i class="fa fa-smile-o" style="color:green;font-size:1.5em;" aria-hidden="true"></i>',
]);
