<?php
/**
 *
 * Advanced Polls [Italian]
 *
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 * @author Translation by Mauron (https://github.com/Mauron)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'AP_TITLE_ACP'					=> 'Sondaggi avanzati',
	'AP_SETTINGS_ACP'				=> 'Impostazioni',

	'AP_TITLE'						=> 'Sondaggi avanzati',
	'AP_TITLE_EXPLAIN'				=> 'Estende la funzione base dei sondaggi phpBB con nuove impostazioni come nascondere i voti fino al termine di un sondaggio, mostrare i votanti, limitare il voto e molto altro.',

	'AP_SETTINGS'					=> 'Impostazioni sondaggi avanzati',
	'AP_GLOBAL_SETTINGS'			=> 'Impostazioni globali sondaggi avanzati (per tutti i sondaggi)',
	'AP_PER_POLL_SETTINGS'			=> 'Impostazioni sondaggi avanzati per singolo sondaggio (valori predefiniti, modificabili per ogni sondaggio)',
	'AP_DEFAULT_POLL_VISIBILITY' => 'Visibilità predefinita dei risultati',
	'AP_DEFAULT_POLL_VISIBILITY_EXPLAIN' => 'Modalità di visibilità selezionata inizialmente alla creazione di un sondaggio.',
	'AP_DEFAULT_POLL_VOTE_MODE' => 'Modalità predefinita di modifica del voto',
	'AP_DEFAULT_POLL_VOTE_MODE_EXPLAIN' => 'Modalità di modifica del voto selezionata inizialmente alla creazione di un sondaggio.',
	'AP_VISIBILITY_PUBLIC' => 'Pubblico — mostra sempre i risultati',
	'AP_VISIBILITY_DEFAULT' => 'Dopo il primo voto',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'Dopo aver utilizzato tutti i voti disponibili',
	'AP_VISIBILITY_PRIVATE' => 'Privato — solo al termine del sondaggio',
	'AP_VOTE_MODE_NO_CHANGE' => 'Nessuna modifica',
	'AP_VOTE_MODE_INCREMENTAL' => 'Votazione progressiva',
	'AP_VOTE_MODE_CHANGE' => 'Consenti modifiche',

	'AP_ACT_VOTES_HIDE'				=> 'Attiva voti nascosti',
	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Attiva l’opzione per nascondere il numero di voti fino al termine del sondaggio.',
	'AP_ACT_VOTERS_SHOW'			=> 'Attiva votanti visibili',
	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Attiva l’opzione per mostrare i votanti per ogni risposta del sondaggio.',
	'AP_ACT_VOTERS_LIMIT'			=> 'Attiva limite per votanti',
	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Attiva l’opzione per limitare il voto a chi abbia prima risposto al topic.',
	'AP_ACT_POLL_NO_VOTE'			=> 'Attiva astensione',
	'AP_ACT_POLL_NO_VOTE_EXPLAIN'	=> 'Cambia il link standard “Mostra risultati” con “Mi astengo, mostra risultati” che non permetterà di votare dopo aver visto i risultati (a meno che non sia attiva l’opzione di cambio voto).',
	'AP_ACT_SHOW_ABSTAINERS' => 'Mostra il numero delle astensioni',
	'AP_ACT_SHOW_ABSTAINERS_EXPLAIN' => 'Mostra quanti utenti registrati hanno scelto esplicitamente di non votare. I nomi vengono mostrati solo quando l’elenco dei votanti è attivo e l’utente dispone del permesso.',
	'AP_ACT_VOTE_DELETE' => 'Consenti l’eliminazione del voto',
	'AP_ACT_VOTE_DELETE_EXPLAIN' => 'Consente agli utenti registrati di eliminare il proprio voto mentre il sondaggio è aperto e permette le modifiche.',
	'AP_ACT_SHOW_ORDERED'			=> 'Attiva mostra ordinate',
	'AP_ACT_SHOW_ORDERED_EXPLAIN'	=> 'Attiva l’opzione per la scelta di visualizzazione dei risultati in ordine decrescente per voti ricevuti (la più votata per prima).',
	'AP_ACT_POLL_SCORING'			=> 'Attiva punteggi sondaggio',
	'AP_ACT_POLL_SCORING_EXPLAIN'	=> 'Attiva l’opzione per assegnare punteggi differenti alle opzioni di voto.',
	'AP_ACT_INCREMENTAL_VOTES'		=> 'Attiva voto incrementale',
	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> 'Attiva l’opzione per votare in maniera incrementale, fintanto che non sia estinta la propria possibilità di voto.',
	'AP_ACT_CLOSED_VOTING'			=> 'Attiva voto chiuso',
	'AP_ACT_CLOSED_VOTING_EXPLAIN'	=> 'Attiva l’opzione per permettere il voto in sondaggi aperti in topic chiusi.',
	'AP_ACT_POLL_END'				=> 'Attiva termine voto',
	'AP_ACT_POLL_END_EXPLAIN'		=> 'Attiva l’opzione per specificate la data e/o l’ora di fine sondaggio, invece di specificarne la durata a partire dall’inizio del sondaggio.',
	'AP_ACT_POLL_NOTIFICATIONS'				=> 'Attiva notifiche sondaggio',
	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'		=> 'Attiva l’invio di notifiche ai votanti alla scadenza di una votazione con voti nascosti per cui sono visibili i risultati.',

	'AP_DEFAULT_VOTES_CHANGE'		=> 'Impostazione predefinita per cambio voto',
	'AP_DEFAULT_VOTES_HIDE'			=> 'Impostazione predefinita per voti nascosti',
	'AP_DEFAULT_VOTERS_SHOW'		=> 'Impostazione predefinita per votanti visibili',
	'AP_DEFAULT_VOTERS_LIMIT'		=> 'Impostazione predefinita per limite per votanti',
	'AP_DEFAULT_SHOW_ORDERED'		=> 'Impostazione predefinita per mostra ordinate',

	'AP_ENABLE_NOTICE' => '<br /><br /><div class="phpinfo"><p><strong>Passaggi successivi</strong></p><ol><li>Controlla le impostazioni dell’estensione in <strong>%1$s » %2$s » %3$s</strong> e configura le funzioni e i valori predefiniti necessari per il forum.</li><li>Controlla i permessi <strong>%8$s</strong> e <strong>%9$s</strong> in <strong>%4$s » %5$s » %6$s</strong> (utenti) e <strong>%4$s » %5$s » %7$s</strong> (moderatori). Concedili solo ai ruoli o gruppi autorizzati a vedere l’identità dei votanti.</li></ol><p>Le altre funzioni dei sondaggi non richiedono configurazione aggiuntiva.</p></div>',
]);
