<?php
/**
 * phpBB Gallery - ACP Core Extension [French Translation]
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translator pokyto (aka le.poke) <https://www.lestontonsfraggers.com>, inspired by darky <https://www.foruminfopc.fr/> and the phpBB-fr.com Team
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
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'GALLERY_CORE_ENABLE_IMAGE_BBCODE_FALLBACK' => 'phpBB Gallery Core a été activée. Le BBCode [image] existant a été conservé, car il appartient à une autre définition ; la galerie utilisera [galleryimage] pour les nouvelles images.',
	'GALLERY_CORE_ENABLE_ALBUM_BBCODE_FALLBACK' => 'phpBB Gallery Core a été activée. Le BBCode [album] existant a été conservé, car il appartient à une autre définition ou à l’alias historique ; la galerie utilisera [galleryalbum] pour les albums intégrés.',
	'GALLERY_CORE_ENABLE_BBCODE_FALLBACK_BOTH' => 'phpBB Gallery Core a été activée. Les BBCodes [image] et [album] existants ont été conservés ; la galerie utilisera [galleryimage] pour les images et [galleryalbum] pour les albums intégrés.',
	'GALLERY_BBCODE_CONFLICT' => 'Le BBCode %s ne peut pas être installé, car cette balise appartient à un BBCode personnalisé incompatible. Renommez ou supprimez le BBCode personnalisé, puis réessayez.',
	'GALLERY_BBCODE_LIMIT_REACHED' => 'Le BBCode %s ne peut pas être installé, car la limite de BBCodes a été atteinte. Supprimez un BBCode, puis réessayez.',
	'GALLERY_CORE_ENABLE_SUCCESS' => 'phpBB Gallery Core a été activée. Les modules facultatifs ACP Cleanup, ACP Import et EXIF sont également disponibles.',
	'GALLERY_CORE_ENABLE_BBCODE_FALLBACK' => 'phpBB Gallery Core a été activée. Le BBCode [image] existant a été conservé, car il appartient à une autre définition ; la galerie utilisera [galleryimage] pour les nouveaux contenus. [album] reste masqué uniquement pour afficher les anciens messages et n’est jamais généré.',
	'GALLERY_REQUIREMENTS_MISSING' => 'phpBB Gallery ne peut pas être activée. Des composants obligatoires sont absents : %s.',
	'GALLERY_SUB_EXT_UNINSTALL' => [
		1 => 'Vous devez désinstaller l’extension: <br /><strong>%s</strong><br /> avant de désinstaller l’extension principale.',
		2 => 'Vous devez désinstaller les extensions: <br /><strong>%s</strong><br /> avant de désinstaller l’extension principale.',
	],
]);
