<?php
/**
 * phpBB Gallery - ACP Core Extension [Dutch Translation]
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translator Dutch Translators <https://github.com/dutch-translators>
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
	$lang = [];
}

$lang = array_merge($lang, [
	'GALLERY_BBCODE_CONFLICT' => 'De BBCode %s kan niet worden geïnstalleerd omdat deze tag bij een niet-compatibele aangepaste BBCode hoort. Hernoem of verwijder de aangepaste BBCode en probeer het opnieuw.',
	'GALLERY_BBCODE_LIMIT_REACHED' => 'De BBCode %s kan niet worden geïnstalleerd omdat de BBCode-limiet is bereikt. Verwijder een BBCode en probeer het opnieuw.',
	'GALLERY_CORE_ENABLE_SUCCESS' => 'phpBB Gallery Core is ingeschakeld. De optionele add-ons ACP Cleanup, ACP Import en EXIF zijn ook beschikbaar.',
	'GALLERY_CORE_ENABLE_BBCODE_FALLBACK' => 'phpBB Gallery Core is ingeschakeld. De bestaande BBCode [image] is behouden omdat deze bij een andere definitie hoort; de galerij gebruikt [galleryimage] voor nieuwe inhoud. [album] blijft alleen verborgen beschikbaar om oude berichten weer te geven en wordt nooit gegenereerd.',
	'GALLERY_REQUIREMENTS_MISSING' => 'phpBB Gallery kan niet worden ingeschakeld. Vereiste onderdelen ontbreken: %s.',
	'GALLERY_SUB_EXT_UNINSTALL' => [
		1 => 'U moet de extensie: <br /><strong>%s</strong><br /> verwijderen voordat u de kern-extensie verwijdert.',
		2 => 'U moet de extensies: <br /><strong>%s</strong><br /> verwijderen voordat u de kern-extensie verwijdert.',
	],
]);
