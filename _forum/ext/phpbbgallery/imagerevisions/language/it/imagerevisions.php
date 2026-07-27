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
	'REPLACE_IMAGE'                => 'Sostituisci il file immagine',
	'REPLACE_IMAGE_EXPLAIN'        => 'Seleziona un nuovo file. ID, descrizione, commenti, valutazioni e numero di visualizzazioni vengono conservati.',
	'IMAGE_REVISIONS'              => 'File immagine precedenti',
	'IMAGE_REVISIONS_EXPLAIN'      => 'I file conservati possono essere visualizzati e ripristinati. Il ripristino conserva il file corrente nella cronologia.',
	'RESTORE_REVISION'             => 'Ripristina questa versione',
	'IMAGE_REPLACE_FAILED'         => 'Non è stato possibile applicare in modo sicuro il file sostitutivo.',
	'IMAGE_REVISION_NOT_AVAILABLE' => 'Questa revisione dell’immagine non è più disponibile.',
	'IMAGE_REVISION_RESTORED'      => 'La revisione dell’immagine è stata ripristinata correttamente.',
]);
