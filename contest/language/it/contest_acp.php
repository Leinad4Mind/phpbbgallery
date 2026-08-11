<?php
/**
 * phpBB Gallery Contest ACP language.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'ALBUM_TYPE_CONTEST'                  => 'Concorso',
	'CONTEST_CREATION'                    => 'Consenti nuovi concorsi',
	'CONTEST_CREATION_EXPLAIN'            => 'Consente agli amministratori di creare nuovi album concorso. I concorsi esistenti rimangono attivi e modificabili quando questa opzione è disattivata.',
	'CONTEST_CREATION_DISABLED'           => 'La creazione di nuovi album concorso è disattivata nella configurazione della Galleria.',
	'CONTEST_SCHEMA_OUTDATED'             => 'Lo schema del database del componente Concorsi non è aggiornato. Esegui le migrazioni di phpBB oppure disattiva e riattiva il componente prima di creare o modificare un concorso.',
	'ALBUM_NO_TYPE_CHANGE_TO_CONTEST'   => 'Un album non-concorso non può essere trasformato in un album concorso.',
	'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE' => 'Un album-concorso non può essere trasformato in un album-non-concorso.',
	'CONTEST_DATE_EXPLAIN'                => 'Seleziona la data e l’ora. Viene utilizzato il fuso orario configurato nel tuo profilo phpBB.',
	'CONTEST_END'                         => 'Fine concorso',
	'CONTEST_END_BEFORE_RATING'           => 'La fine della rassegna non può essere prima dell’inizio-concorso-voti.',
	'CONTEST_END_BEFORE_START'            => 'La fine della rassegna non può essere prima dell’inizio-concorso.',
	'CONTEST_END_EXPLAIN'                 => 'Dopo la fine della rassegna gli utenti non possono votare le immagini.',
	'CONTEST_END_INVALID'                 => 'Fine concorso non valida (%s). Seleziona una data e un’ora valide.',
	'CONTEST_RATING'                      => 'Inizio votazione',
	'CONTEST_RATING_BEFORE_START'         => 'L’inizio della rassegna-votazione non può essere precedente.',
	'CONTEST_RATING_EXPLAIN'              => 'Dopo l’“inizio votazione“ gli utenti non possono caricare immagini.',
	'CONTEST_RATING_INVALID'              => 'Inizio votazione non valido (%s). Seleziona una data e un’ora valide.',
	'CONTEST_SETTINGS'                    => 'Configurazione rassegna',
	'CONTEST_WINNER_THUMBNAIL'            => 'Usa le miniature dei vincitori',
	'CONTEST_WINNER_THUMBNAIL_EXPLAIN'    => 'Dopo la fine di un concorso usa per impostazione predefinita come miniatura dell’album l’immagine valida al primo posto. Ogni concorso può ereditare o sostituire questa impostazione. Un’immagine album configurata manualmente ha sempre la precedenza.',
	'CONTEST_THUMBNAIL_POLICY'            => 'Miniatura album dopo il concorso',
	'CONTEST_THUMBNAIL_POLICY_EXPLAIN'    => 'Controlla solo la miniatura nell’elenco degli album. Data, autore e stato di lettura dell’ultima immagine restano invariati.',
	'CONTEST_THUMBNAIL_INHERIT'           => 'Eredita impostazione globale',
	'CONTEST_THUMBNAIL_LAST'              => 'Usa ultima immagine',
	'CONTEST_THUMBNAIL_WINNER'            => 'Usa immagine vincitrice dopo la fine del concorso',
	'CONTEST_START'                       => 'Inizio rassegna',
	'CONTEST_START_EXPLAIN'               => 'All’inizio della rassegna gli utenti non possono caricare immagini.',
	'CONTEST_START_INVALID'               => 'Inizio concorso non valido (%s). Seleziona una data e un’ora valide.',
]);
