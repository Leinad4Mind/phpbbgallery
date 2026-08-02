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
	'CONTEST_CREATION'                    => 'Consenti nuovi concorsi',
	'CONTEST_CREATION_EXPLAIN'            => 'Consente agli amministratori di creare nuovi album concorso. I concorsi esistenti rimangono attivi e modificabili quando questa opzione è disattivata.',
	'CONTEST_CREATION_DISABLED'           => 'La creazione di nuovi album concorso è disattivata nella configurazione della Galleria.',
	'ALBUM_NO_TYPE_CHANGE_TO_CONTEST'   => 'Un album non-concorso non può essere trasformato in un album concorso.',
	'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE' => 'Un album-concorso non può essere trasformato in un album-non-concorso.',
	'CONTEST_DATE_EXPLAIN'                => 'Aggiungi data nel formato YYYY-MM-DD HH:MM.',
	'CONTEST_END'                         => 'Fine concorso',
	'CONTEST_END_BEFORE_RATING'           => 'La fine della rassegna non può essere prima dell’inizio-concorso-voti.',
	'CONTEST_END_BEFORE_START'            => 'La fine della rassegna non può essere prima dell’inizio-concorso.',
	'CONTEST_END_EXPLAIN'                 => 'Dopo la fine della rassegna gli utenti non possono votare le immagini.',
	'CONTEST_END_INVALID'                 => 'Fine rassegna non valida (%s). Devi inserire una data nel formato YYYY-MM-DD HH:MM.',
	'CONTEST_RATING'                      => 'Inizio votazione',
	'CONTEST_RATING_BEFORE_START'         => 'L’inizio della rassegna-votazione non può essere precedente.',
	'CONTEST_RATING_EXPLAIN'              => 'Dopo l’“inizio votazione“ gli utenti non possono caricare immagini.',
	'CONTEST_RATING_INVALID'              => 'Inizio votazione-rassegna non valido (%s). Devi inserire una data nel formato YYYY-MM-DD HH:MM.',
	'CONTEST_SETTINGS'                    => 'Configurazione rassegna',
	'CONTEST_START'                       => 'Inizio rassegna',
	'CONTEST_START_EXPLAIN'               => 'All’inizio della rassegna gli utenti non possono caricare immagini.',
	'CONTEST_START_INVALID'               => 'Inizio rassegna non valido (%s). Devi inserire una data nel formato YYYY-MM-DD HH:MM.',
]);
