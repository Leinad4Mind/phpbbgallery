<?php
/**
 * phpBB Gallery - BBPoints Images
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'BBPOINTSIMAGES_DEPENDENCIES_MISSING' => 'Le estensioni richieste non sono abilitate: %s.',
	'ACP_BBPOINTSIMAGES_SETTINGS' => 'BBPoints per le immagini',
	'ACP_BBPOINTSIMAGES_SETTINGS_EXPLAIN' => 'Configura le ricompense per la pubblicazione nella Galleria e il costo di accesso ai file originali.',
	'ACP_BBPOINTSIMAGES_GLOBAL' => 'Impostazioni globali',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD' => 'Ricompensa per immagine approvata',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD_EXPLAIN' => 'Punti assegnati una sola volta all’autore finale quando l’immagine viene approvata. Imposta 0 per disattivare le ricompense.',
	'ACP_BBPOINTSIMAGES_SOURCE_COST' => 'Costo del file originale',
	'ACP_BBPOINTSIMAGES_SOURCE_COST_EXPLAIN' => 'Punti necessari per acquistare l’accesso al file originale. Imposta 0 per l’accesso gratuito.',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES' => 'Eccezioni per album',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Ogni valore sostituisce in modo indipendente quello dell’antenato più vicino. Usa -1 per ereditare.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Album',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Usa -1 per ereditare il valore dall’antenato configurato più vicino o dall’impostazione globale.',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'Non sono disponibili album della Galleria.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'Le impostazioni BBPoints per le immagini sono state salvate.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Ricompense per immagini esistenti',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Analizza le immagini esistenti approvate e assegna la ricompensa configurata. Le ricompense esistenti e i file esattamente duplicati vengono ignorati.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Sincronizza le ricompense esistenti',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => 'Vuoi davvero ricompensare tutte le immagini esistenti idonee usando le regole attuali degli album?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'La sincronizzazione continua. Finora sono state analizzate %1$d immagini e assegnate %2$d ricompense.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'La sincronizzazione è terminata. Sono state analizzate %1$d immagini e assegnate %2$d ricompense.',
]);
