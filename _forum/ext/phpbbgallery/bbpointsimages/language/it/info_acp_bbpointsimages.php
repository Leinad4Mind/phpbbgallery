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
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Questa panoramica di sola lettura segue la gerarchia della Galleria. Modifica un album per cambiarne i valori diretti; i valori in grassetto sono quelli attualmente effettivi.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Album',
	'ACP_BBPOINTSIMAGES_ALBUM_SETTINGS' => 'BBPoints Images',
	'ACP_BBPOINTSIMAGES_ALBUM_SETTINGS_EXPLAIN' => 'Usa -1 affinché ogni valore numerico erediti in modo indipendente dall’antenato configurato più vicino o dall’impostazione globale.',
	'ACP_BBPOINTSIMAGES_INHERIT' => 'Eredita',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Usa -1 per ereditare il valore dall’antenato configurato più vicino o dall’impostazione globale.',
	'ACP_BBPOINTSIMAGES_EFFECTIVE_VALUE' => 'Valore effettivo: %1$d.',
	'ACP_BBPOINTSIMAGES_EFFECTIVE_TOGGLE' => 'Impostazione effettiva: %1$s.',
	'ACP_BBPOINTSIMAGES_INHERITED' => 'Ereditato',
	'ACP_BBPOINTSIMAGES_DIRECT_VALUE' => 'Valore diretto: %1$d',
	'ACP_BBPOINTSIMAGES_DIRECT_SETTING' => 'Impostazione diretta',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'Non sono disponibili album della Galleria.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'Le impostazioni BBPoints per le immagini sono state salvate.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Ricompense per immagini esistenti',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Analizza le immagini esistenti approvate e assegna la ricompensa configurata. Le ricompense esistenti e i file esattamente duplicati vengono ignorati.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Sincronizza le ricompense esistenti',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => 'Vuoi davvero ricompensare tutte le immagini esistenti idonee usando le regole attuali degli album?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'La sincronizzazione continua. Finora sono state analizzate %1$d immagini e assegnate %2$d ricompense.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'La sincronizzazione è terminata. Sono state analizzate %1$d immagini e assegnate %2$d ricompense.',
	'BBPOINTSIMAGES_SOURCE_LOGIN' => 'Devi accedere per acquistare questo file immagine originale.',
	'BBPOINTSIMAGES_SOURCE_PURCHASE_CONFIRM' => 'Scaricare questo file immagine originale costa %1$d punti. Vuoi continuare?',
	'BBPOINTSIMAGES_INSUFFICIENT_FUNDS' => 'Hai %1$d punti, ma questo file immagine originale richiede %2$d punti.',
	'BBPOINTSIMAGES_SOURCE_UNAVAILABLE' => 'Il file immagine originale non può essere acquistato in questo momento.',
	'BBPOINTSIMAGES_DOWNLOADS' => 'Download dell’originale',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS' => 'Consenti l’assegnazione dei collaboratori',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Consente agli autori e agli editor delle immagini di indicare i collaboratori. I collaboratori esistenti mantengono l’attribuzione e la loro quota dei download a pagamento quando questa opzione è disattivata.',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK' => 'Collaboratori in tutti gli album',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_EXPLAIN' => 'Imposta una scelta esplicita per tutti gli album pubblici oppure li reimposta affinché ereditino l’impostazione globale. Le eccezioni per ricompensa e costo vengono mantenute.',
	'ACP_BBPOINTSIMAGES_INHERIT_GLOBAL' => 'Fai ereditare tutti gli album',
	'ACP_BBPOINTSIMAGES_ENABLE_ALL' => 'Attiva in tutti gli album',
	'ACP_BBPOINTSIMAGES_DISABLE_ALL' => 'Disattiva in tutti gli album',
	'ACP_BBPOINTSIMAGES_APPLY_ALL' => 'Applica a tutti gli album',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_CONFIRM' => 'Vuoi davvero cambiare l’assegnazione dei collaboratori in tutti gli album pubblici della Galleria?',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_SAVED' => 'L’assegnazione dei collaboratori è stata aggiornata in tutti gli album pubblici della Galleria.',
	'BBPOINTSIMAGES_CONTRIBUTORS' => 'Collaboratori',
	'BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Inserisci un nome utente registrato per riga, fino a %1$d. L’autore dell’immagine viene escluso automaticamente.',
	'BBPOINTSIMAGES_CONTRIBUTORS_UNKNOWN' => 'Questi collaboratori non sono stati trovati o sono inattivi: %1$s.',
	'BBPOINTSIMAGES_CONTRIBUTORS_TOO_MANY' => 'Un’immagine non può avere più di %1$d collaboratori.',
	'NOTIFICATION_TYPE_BBPOINTSIMAGES_REWARD' => 'Ricompense per immagini della Galleria',
	'NOTIFICATION_BBPOINTSIMAGES_REWARD' => 'Hai ricevuto %1$d punti per aver pubblicato l’immagine <strong>%2$s</strong>.',
	'NOTIFICATION_TYPE_BBPOINTSIMAGES_SOURCE_PURCHASE' => 'Vendite degli originali della Galleria',
	'NOTIFICATION_BBPOINTSIMAGES_SOURCE_PURCHASE' => '%1$s ha acquistato il file originale di <strong>%3$s</strong>; hai ricevuto %2$d punti.',
]);
