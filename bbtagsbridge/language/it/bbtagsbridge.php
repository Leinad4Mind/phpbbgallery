<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Immagini della galleria',
	'BBTAGSBRIDGE_TAGS' => 'Tag',
	'BBTAGSBRIDGE_TAGS_EXPLAIN' => 'Aggiungi fino a %1$d tag separati da virgole. Ogni tag deve contenere da %2$d a %3$d caratteri. I nuovi tag vengono inviati ai moderatori per l’approvazione.',
	'BBTAGSBRIDGE_TAG_TOO_SHORT' => 'Ogni tag deve contenere almeno %2$d caratteri.',
	'BBTAGSBRIDGE_TAG_TOO_LONG' => 'Ogni tag può contenere al massimo %3$d caratteri.',
	'BBTAGSBRIDGE_TAG_LIMIT' => 'Non puoi aggiungere più di %1$d tag a un’immagine.',
	'BBTAGSBRIDGE_PENDING_NOTICE' => 'I nuovi tag restano nascosti finché un moderatore non li approva.',
	'BBTAGSBRIDGE_SAVE_FAILED' => 'Non è stato possibile salvare i tag dell’immagine.',
]);
