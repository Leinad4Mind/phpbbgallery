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
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS' => 'Revisioni delle immagini per questo album',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_SETTINGS_EXPLAIN' => 'Ogni impostazione può ereditare il valore effettivo dall’album superiore più vicino o dal valore globale.',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERIT'        => 'Eredita',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_TOGGLE' => 'Impostazione effettiva: %1$s.',
	'ACP_GALLERY_IMAGE_REVISIONS_EFFECTIVE_VALUE' => 'Valore effettivo: %1$d.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW' => 'Revisioni per album',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM_OVERVIEW_EXPLAIN' => 'Questa panoramica di sola lettura segue la gerarchia degli album. Usa Modifica per cambiare un album o sottoalbum.',
	'ACP_GALLERY_IMAGE_REVISIONS_ALBUM'          => 'Album',
	'ACP_GALLERY_IMAGE_REVISIONS_INHERITED'      => 'Ereditato',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT'         => 'Impostazione diretta',
	'ACP_GALLERY_IMAGE_REVISIONS_DIRECT_VALUE'   => 'Impostato su %1$d',
	'ACP_GALLERY_IMAGE_REVISIONS_NO_ALBUMS'      => 'Non sono presenti album pubblici nella Galleria.',
	'ACL_A_GALLERY_IMAGEREVISIONS'               => 'Può gestire le impostazioni delle revisioni delle immagini',
]);
