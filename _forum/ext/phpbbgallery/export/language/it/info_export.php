<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Italian [it]] (2026)
 */

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
* Language for the gallery export
*/
$lang = array_merge($lang, [
	'GALLERY_CORE_NOT_FOUND'		=> 'phpBB Gallery Core non è presente! Scaricalo e installalo prima di questa estensione.',
	'EXTENSION_ENABLE_SUCCESS'		=> 'L’estensione è stata attivata con successo.',

	'EXPORT_SELECTION'				=> 'Cosa esportare',
	'EXPORT_ALBUMS'					=> 'Album',
	'EXPORT_ALBUMS_EXPLAIN'			=> 'Scegli uno o più album. Tieni premuto Ctrl per selezionarne diversi.',
	'EXPORT_ALL_ALBUMS'				=> 'Esporta l’intera galleria, ignorando la selezione qui sopra',
	'EXPORT_DELIVERY'				=> 'Destinazione dell’archivio',
	'EXPORT_DELIVERY_EXPLAIN'		=> 'Un archivio lasciato sul server viene scritto in %s e non viene mai rimosso automaticamente, così puoi prelevarlo via FTP quando vuoi.',
	'EXPORT_DELIVERY_DOWNLOAD'		=> 'Offrilo come download',
	'EXPORT_DELIVERY_SERVER'		=> 'Lascialo sul server',
	'EXPORT_LIMITS'					=> 'Limiti',
	'EXPORT_LIMITS_EXPLAIN'			=> 'Al massimo %1$d immagini e %2$s per esportazione, scrivendo %3$d immagini alla volta.',
	'EXPORT_START'					=> 'Avvia esportazione',
	'EXPORT_CONTINUE'				=> 'Continua',
	'EXPORT_DOWNLOAD'				=> 'Scarica',

	'EXPORT_STARTED'				=> [
		1	=> 'È iniziata l’esportazione di %d immagine.',
		2	=> 'È iniziata l’esportazione di %d immagini.',
	],
	'EXPORT_PROGRESS'				=> 'Esportate %1$d di %2$d immagini…',
	'EXPORT_FINISHED'				=> [
		1	=> 'L’esportazione si è conclusa con %d immagine.',
		2	=> 'L’esportazione si è conclusa con %d immagini.',
	],

	'EXPORT_JOBS'					=> 'Esportazioni',
	'EXPORT_NO_JOBS'				=> 'Non c’è ancora nessuna esportazione.',
	'EXPORT_JOB_ARCHIVE'			=> 'Archivio',
	'EXPORT_JOB_CREATED'			=> 'Avviata',
	'EXPORT_JOB_PROGRESS'			=> 'Avanzamento',
	'EXPORT_JOB_SIZE'				=> 'Dimensione',
	'EXPORT_JOB_ACTION'				=> 'Azione',
	'EXPORT_JOB_ERRORS'				=> [
		1	=> 'Non è stato possibile aggiungere %d immagine.',
		2	=> 'Non è stato possibile aggiungere %d immagini.',
	],
	'EXPORT_JOB_DELETED'			=> 'L’esportazione è stata eliminata.',
	'EXPORT_JOB_NOT_FOUND'			=> 'Questa esportazione non esiste o non ti appartiene.',
	'EXPORT_STATUS_READY'			=> 'Pronta',
	'EXPORT_STATUS_RUNNING'			=> 'In corso',

	'EXPORT_UCP_EXPLAIN'			=> 'Qui puoi scaricare le immagini che hai caricato, con i nomi mostrati dalla galleria invece di quelli con cui sono salvate su disco. Fino a %d immagini per esportazione.',
	'EXPORT_UCP_DISABLED'			=> 'L’amministratore del forum ha disattivato l’esportazione delle proprie immagini.',

	'EXPORT_NO_IMAGES'				=> 'Non ci sono immagini da esportare.',
	'EXPORT_TOO_MANY_IMAGES'		=> 'Un’esportazione può comprendere al massimo %d immagini. Esporta meno album alla volta.',
	'EXPORT_SIZE_LIMIT_EXCEEDED'	=> 'Un’esportazione può occupare al massimo %s. Esporta meno album alla volta.',
	'EXPORT_NOT_ENOUGH_SPACE'		=> 'Non c’è abbastanza spazio libero sul server per questa esportazione.',
	'EXPORT_ARCHIVE_FAILED'			=> 'Non è stato possibile scrivere l’archivio.',
	'EXPORT_ARCHIVE_MISSING'		=> 'L’archivio di questa esportazione non è più sul server.',
	'EXPORT_STATE_FAILED'			=> 'Non è stato possibile salvare lo stato di questa esportazione. Verifica che la cartella di esportazione sia scrivibile.',
	'EXPORT_ERROR_MISSING_FILE'		=> 'Immagine %1$d saltata: il file “%2$s” non è sul server.',
	'EXPORT_ERROR_UNREADABLE_FILE'	=> 'Immagine %1$d saltata: non è stato possibile leggere il file “%2$s”.',
	'EXPORT_ERROR_ARCHIVE'			=> 'Non è stato possibile scrivere l’archivio “%s”.',
]);
