<?php
/**
 * phpBB Gallery - ACP Core Extension [German Translation]
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translator franki <https://dieahnen.de/ahnenforum/>
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
	'GALLERY_BBCODE_CONFLICT' => 'Der BBCode %s kann nicht installiert werden, da dieses Tag zu einem inkompatiblen benutzerdefinierten BBCode gehört. Benennen Sie den benutzerdefinierten BBCode um oder entfernen Sie ihn und versuchen Sie es erneut.',
	'GALLERY_BBCODE_LIMIT_REACHED' => 'Der BBCode %s kann nicht installiert werden, da das BBCode-Limit erreicht wurde. Entfernen Sie einen BBCode und versuchen Sie es erneut.',
	'GALLERY_CORE_ENABLE_SUCCESS' => 'phpBB Gallery Core wurde aktiviert. Die optionalen Add-ons ACP Cleanup, ACP Import und EXIF sind ebenfalls verfügbar.',
	'GALLERY_CORE_ENABLE_BBCODE_FALLBACK' => 'phpBB Gallery Core wurde aktiviert. Der vorhandene [image]-BBCode wurde beibehalten, da er zu einer anderen Definition gehört; die Galerie verwendet [galleryimage] für neue Inhalte. [album] bleibt ausschließlich zur Darstellung älterer Beiträge verborgen und wird nie erzeugt.',
	'GALLERY_REQUIREMENTS_MISSING' => 'phpBB Gallery kann nicht aktiviert werden. Erforderliche Komponenten fehlen: %s.',
	'GALLERY_SUB_EXT_UNINSTALL' => [
		1 => 'Sie müssen die Erweiterung deinstallieren: <br /><strong>%s</strong><br /> bevor Sie die Kern-Erweiterung deinstallieren können.',
		2 => 'Sie müssen die Erweiterungen deinstallieren: <br /><strong>%s</strong><br /> bevor Sie die Kern-Erweiterung deinstallieren können.',
	],
]);
