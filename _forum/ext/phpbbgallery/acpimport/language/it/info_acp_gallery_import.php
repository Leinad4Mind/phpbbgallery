<?php
/**
 * phpBB Gallery - ACP Import Extension [Italian Translation]
 *
 * @package   phpbbgallery/acpimport
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
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
	'ACP_IMPORT_ALBUMS'         => 'Importa Immagini',
	'ACP_IMPORT_ALBUMS_EXPLAIN' => 'Da qui puoi importare in massa immagini dal file system. Prima di importare le immagini assicurati di ridimensionarle manualmente.',

	'IMPORT_ARCHIVES'            => 'Archivi ZIP',
	'IMPORT_ARCHIVES_SELECT'     => 'Scegli gli archivi da scompattare. Le loro immagini finiscono nella cartella di importazione, dove poi puoi scegliere quali importare. Gli archivi scompattati vengono eliminati.',
	'IMPORT_EXTRACT'             => 'Estrai',
	'IMPORT_NO_ARCHIVES'         => 'Non ci sono archivi ZIP nella cartella di importazione.',
	'IMPORT_ZIP_ALL_EXTRACTED'   => 'Sono state estratte %1$d immagini da %2$d archivi. Scegli qui sotto quali importare.',
	'IMPORT_ZIP_EXTRACTED'       => 'Estratte %1$d immagini da “%2$s”.',
	'IMPORT_ZIP_FAILED'          => 'Non è stato possibile estrarre l’archivio “%s”.',
	'IMPORT_ZIP_MAX_IMAGES'      => 'Immagini per archivio',
	'IMPORT_ZIP_MAX_IMAGES_EXPLAIN' => 'Quante immagini può fornire un singolo archivio. Un archivio non viene mai letto oltre le 1000 voci, quindi quello è anche il valore utile massimo.',
	'IMPORT_ZIP_SETTINGS'        => 'Archivi ZIP',
	'IMPORT_ZIP_SETTINGS_SAVED'  => 'Le impostazioni degli archivi sono state salvate.',
	'IMPORT_ALBUM'               => 'Album in cui importare immagini:',
	'IMPORT_DEBUG_MES'           => '%1$s immagini importate. Rimangono ancora %2$s immagini.',
	'IMPORT_DIR_EMPTY'           => 'La cartella %s e\' vuota. Devi caricarci le immagini per importarle.',
	'IMPORT_FINISHED'            => 'Tutte le %1$s immagini importate con successo.',
	'IMPORT_FINISHED_ERRORS'     => '%1$s immagini sono state importate con successo, ma sono stati riscontrati i seguenti errori:<br /><br />',
	'IMPORT_MISSING_ALBUM'       => 'Seleziona un album in cui importare le immagini.',
	'IMPORT_SELECT'              => 'Scegli le immagini che vuoi importare. Le immagini importate con successo vengono cancellate. Tutte le altri immagini restano disponibili.',
	'IMPORT_SCHEMA_CREATED'      => 'Lo schema di importazione e\' stato creato con successo, attendi mentre le immagini vengono importate.',
	'IMPORT_INVALID_IMAGE'       => 'Il file selezionato “%s” non è un\'immagine consentita della cartella di importazione.',
	'IMPORT_SCHEMA_WRITE_FAILED' => 'Non è stato possibile salvare in modo sicuro lo stato dell’importazione.',
	'IMPORT_TOO_MANY_IMAGES'     => 'Puoi importare al massimo %d immagini alla volta.',
	'IMPORT_UNREADABLE_FILES'    => 'Sono stati ignorati %d file con nomi illeggibili.',
	'IMPORT_USER'                => 'Caricate da',
	'IMPORT_USER_EXP'            => 'Puoi aggiungere le immagini a un altro utente da qui.',
	'IMPORT_USERS_PEGA'          => 'Carica alla galleria personale dell\'utente.',

	'MISSING_IMPORT_SCHEMA' => 'Lo schema di importazione specificato (%s) non e\' stato trovato.',

	'NO_FILE_SELECTED' => 'Devi selezionare almeno un file.',

	'GALLERY_CORE_NOT_FOUND'   => 'L\'estensione phpBB Gallery Core deve essere prima installata e abilitata.',
	'EXTENSION_ENABLE_SUCCESS' => 'L\'estensione è stata abilitata con successo.',
]);
