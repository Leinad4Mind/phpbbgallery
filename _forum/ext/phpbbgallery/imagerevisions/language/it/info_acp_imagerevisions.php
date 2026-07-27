<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}
$lang = array_merge($lang, [
	'ACP_GALLERY_IMAGE_REVISIONS'                => 'Revisioni delle immagini',
	'ACP_GALLERY_IMAGE_REVISIONS_EXPLAIN'        => 'Configura la cronologia opzionale per la sostituzione e il ripristino delle immagini.',
	'ACP_GALLERY_IMAGE_REVISIONS_SETTINGS'       => 'Impostazioni delle revisioni',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE'         => 'Abilita le revisioni delle immagini',
	'ACP_GALLERY_IMAGE_REVISIONS_ENABLE_EXPLAIN' => 'Consente agli editor di sostituire i file e ripristinare le versioni conservate. Ogni revisione utilizza spazio aggiuntivo.',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT'          => 'Revisioni conservate per immagine',
	'ACP_GALLERY_IMAGE_REVISIONS_LIMIT_EXPLAIN'  => 'Scegli da 1 a 50. I file più vecchi vengono eliminati automaticamente.',
	'ACP_GALLERY_IMAGE_REVISIONS_UPDATED'        => 'Le impostazioni delle revisioni sono state aggiornate.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Può gestire le impostazioni delle revisioni delle immagini',
]);
