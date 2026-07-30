<?php
/**
 * phpBB Gallery - ACP Core Extension [Italian Translation]
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translator
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
	'GALLERY_BBCODE_CONFLICT' => 'Il BBCode %s non può essere installato perché il tag appartiene a un BBCode personalizzato incompatibile. Rinominare o rimuovere il BBCode personalizzato, quindi riprovare.',
	'GALLERY_BBCODE_LIMIT_REACHED' => 'Il BBCode %s non può essere installato perché è stato raggiunto il limite dei BBCode. Rimuovere un BBCode, quindi riprovare.',
	'GALLERY_CORE_ENABLE_SUCCESS' => 'phpBB Gallery Core è stata abilitata. Sono disponibili anche i componenti aggiuntivi facoltativi ACP Cleanup, ACP Import ed EXIF.',
	'GALLERY_CORE_ENABLE_BBCODE_FALLBACK' => 'phpBB Gallery Core è stata abilitata. Il BBCode [image] esistente è stato mantenuto perché appartiene a un’altra definizione; la galleria userà [galleryimage] per i nuovi contenuti. [album] resta nascosto solo per visualizzare i messaggi storici e non viene mai generato.',
	'GALLERY_REQUIREMENTS_MISSING' => 'phpBB Gallery non può essere abilitata. Mancano componenti obbligatori: %s.',
	'GALLERY_SUB_EXT_UNINSTALL' => [
		1 => 'È necessario disinstallare l’estensione: <br /><strong>%s</strong><br /> prima di disinstallare l’estensione principale.',
		2 => 'È necessario disinstallare le estensioni: <br /><strong>%s</strong><br /> prima di disinstallare l’estensione principale.',
	],
]);
