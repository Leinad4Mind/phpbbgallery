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
	'GALLERY_HELPLINE_ALBUM_EMBED' => 'Album della Galleria: [album]id_album[/album], incorpora nel messaggio un album paginato e filtrato in base ai permessi.',
	'GALLERY_HELPLINE_GALLERYALBUM' => 'Album della Galleria: [galleryalbum]id_album[/galleryalbum], usato perché [album] appartiene a un altro BBCode o all’alias precedente.',
]);

$lang = array_merge($lang, [
	'ACP_GALLERY_ALBUM_MANAGEMENT'       => 'Gestione Album',
	'ACP_GALLERY_ALBUM_PERMISSIONS'      => 'Permessi',
	'ACP_GALLERY_ALBUM_PERMISSIONS_COPY' => 'Copia permessi',
	'ACP_GALLERY_CONFIGURE_GALLERY'      => 'Configura galleria',
	'ACP_GALLERY_LOGS'                   => 'Log Galleria',
	'ACP_GALLERY_LOGS_EXPLAIN'           => 'Lista di tutte le azioni di moderazione della galleria, come approvazioni, disapprovazioni, chiusure, riaperture, chiusura delle segnalazioni e cancellazione immagini.',
	'ACP_GALLERY_MANAGE_ALBUMS'          => 'Gestisci gli album',
	'ACP_GALLERY_OVERVIEW'               => 'Panoramica',

	'GALLERY'                => 'Galleria',
	'GALLERY_EXPLAIN'        => 'Galleria Immagini',
	'GALLERY_HELPLINE_IMAGE' => 'Immagine di Galleria: [image]id_immagine[/image], con questo BBCode puoi aggiungere un’immagine dalla galleria nel tuo post.',
	'GALLERY_HELPLINE_GALLERYIMAGE' => 'Immagine della galleria: [galleryimage]id_immagine[/galleryimage], usato perché [image] appartiene a un altro BBCode personalizzato.',
	'GALLERY_HELPLINE_IMAGE_LEGACY' => 'Immagine della galleria: [album]id_immagine[/album], con questo BBCode precedente puoi aggiungere un’immagine dalla galleria al tuo messaggio.',
	'GALLERY_POPUP'          => 'Galleria',
	'GALLERY_POPUP_HELPLINE' => 'Apri un popup in cui selezionare le tue immagini recenti e caricarne di nuove.',

	// Please do not change the copyright.
	'GALLERY_COPYRIGHT' => 'Powered by <a href="https://github.com/satanasov/phpbbgallery">phpBB Gallery</a> &copy; 2014–2026',
	// A little line where you can give yourself some credits on the translation.
	'GALLERY_TRANSLATION_INFO' => 'Traduzione in italiano della Galleria phpBB di Fabio "Lord Phobos" Bolzoni',

	'IMAGES'                  => 'Immagini',
	'IMG_BUTTON_UPLOAD_IMAGE' => 'Carica immagine',

	'PERSONAL_ALBUM' => 'Album personale',
	'PHPBB_GALLERY'  => 'Galleria phpBB',

	'TOTAL_IMAGES_SPRINTF' => [
		0 => 'Totale immagini <strong>0</strong>',
		1 => 'Totale immagini <strong>%d</strong>',
	],
]);
