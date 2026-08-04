<?php
/**
 * phpBB Gallery - ACP Core Extension [Italian Translation]
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
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
	'CHOOSE_ACTION' => 'Seleziona l\'azione desiderata',
	'RENAME_IMAGES' => 'Rinomina le immagini selezionate',

	'GALLERY_MCP_MAIN'           => 'Principale',
	'GALLERY_MCP_OVERVIEW'       => 'Panoramica',
	'GALLERY_MCP_QUEUE'          => 'Coda',
	'GALLERY_MCP_QUEUE_DETAIL'   => 'Dettagli immagine',
	'GALLERY_MCP_REPORTED'       => 'Immagini segnalate',
	'GALLERY_MCP_REPO_DONE'      => 'Segnalazioni chiuse',
	'GALLERY_MCP_REPO_OPEN'      => 'Apri segnalazioni',
	'GALLERY_MCP_REPO_DETAIL'    => 'Dettaglio segnalazioni',
	'GALLERY_MCP_UNAPPROVED'     => 'Immagini in attesa di approvazione',
	'GALLERY_MCP_APPROVED'       => 'Immagini approvate',
	'GALLERY_MCP_LOCKED'         => 'Immagini bloccate',
	'GALLERY_MCP_VIEWALBUM'      => 'Visualizza album',
	'GALLERY_MCP_ALBUM_OVERVIEW' => 'Modera album',

	'IMAGE_REPORTED'   => 'Questa immagine è stata segnalata.',
	'IMAGE_UNAPPROVED' => 'Questa immagine è in attesa di approvazione.',

	'MODERATE_ALBUM' => 'Modera album',

	'LATEST_IMAGES_REPORTED'   => 'Ultime 5 segnalazioni',
	'LATEST_IMAGES_UNAPPROVED' => 'Ultime 5 immagini in attesa di approvazione',

	'QUEUE_A_APPROVE'            => 'Approva immagine',
	'QUEUE_A_APPROVE2'           => 'Approva immagine?',
	'QUEUE_A_APPROVE2_CONFIRM'   => 'Sei sicuro di voler approvare questa immagine?',
	'QUEUE_A_DELETE'             => 'Cancella immagine',
	'QUEUE_A_DELETE2'            => 'Cancella immagine?',
	'QUEUE_A_DELETE2_CONFIRM'    => 'Sei sicuro di voler cancellare questa immagine?',
	'QUEUE_A_LOCK'               => 'Blocca commenti immagine',
	'QUEUE_A_LOCK2'              => 'Approvare e bloccare i commenti sull\'immagine?',
	'QUEUE_A_LOCK2_CONFIRM'      => 'Sei sicuro di voler approvare e bloccare i commenti su questa immagine?',
	'QUEUE_A_MOVE'               => 'Sposta immagine',
	'QUEUE_A_UNAPPROVE'          => 'Disapprova immagine',
	'QUEUE_A_UNAPPROVE2'         => 'Disapprova immagine?',
	'QUEUE_A_UNAPPROVE2_CONFIRM' => 'Sei sicuro di voler disapprovare questa immagine?',

	'QUEUE_STATUS_0' => 'Questa immagine è in attesa di approvazione.',
	'QUEUE_STATUS_1' => 'Questa immagine è stata approvata.',
	'QUEUE_STATUS_2' => 'Questa immagine è bloccata.',

	'QUEUES_A_APPROVE'             => 'Approva immagini',
	'QUEUES_A_APPROVE2'            => 'Approva immagini?',
	'QUEUES_A_APPROVE2_CONFIRM'    => 'Sei sicuro di voler approvare queste immagini?',
	'QUEUES_A_DELETE'              => 'Cancella immagini',
	'QUEUES_A_DELETE2'             => 'Cancella immagini?',
	'QUEUES_A_DELETE2_CONFIRM'     => 'Sei sicuro di voler cancellare queste immagini?',
	'QUEUES_A_LOCK'                => 'Blocca immagini',
	'QUEUES_A_LOCK2'               => 'Blocca immagini?',
	'QUEUES_A_LOCK2_CONFIRM'       => 'Sei sicuro di voler bloccare queste immagini?',
	'QUEUES_A_MOVE'                => 'Sposta immagini',
	'QUEUES_A_UNAPPROVE'           => 'Disapprova immagini',
	'QUEUES_A_UNAPPROVE2'          => 'Disapprova immagini?',
	'QUEUES_A_UNAPPROVE2_CONFIRM'  => 'Sei sicuro di voler disapprovare queste immagini?',
	'QUEUES_A_DISAPPROVE2_CONFIRM' => 'Sei sicuro di voler disapprovare queste immagini?',

	'REPORT_A_CLOSE'           => 'Chiudi segnalazione',
	'REPORT_A_CLOSE2'          => 'Chiudi segnalazione?',
	'REPORT_A_CLOSE2_CONFIRM'  => 'Sei sicuro di voler chiudere questa segnalazione?',
	'REPORT_A_DELETE'          => 'Cancella segnalzione',
	'REPORT_A_DELETE2'         => 'Cancella segnalzione?',
	'REPORT_A_DELETE2_CONFIRM' => 'Sei sicuro di voler cancellare questa segnalazione?',
	'REPORT_A_OPEN'            => 'Apri segnalazione',
	'REPORT_A_OPEN2'           => 'Apri segnalazione?',
	'REPORT_A_OPEN2_CONFIRM'   => 'Sei sicuro di voler aprire questa segnalazione?',

	'REPORT_NOT_FOUND' => 'Impossibile trovare la segnalazione.',
	'REPORT_STATUS_1'  => 'Questa segnalazione necessita di controllo.',
	'REPORT_STATUS_2'  => 'Questa segnalazione è chiusa.',

	'REPORTS_A_CLOSE'           => 'Chiudi segnalazioni',
	'REPORTS_A_CLOSE2'          => 'Chiudi segnalazioni?',
	'REPORTS_A_CLOSE2_CONFIRM'  => 'Sei sicuro di voler chiudere queste segnalazioni?',
	'REPORTS_A_DELETE'          => 'Cancella segnalazioni',
	'REPORTS_A_DELETE2'         => 'Cancella segnalazioni?',
	'REPORTS_A_DELETE2_CONFIRM' => 'Sei sicuro di voler cancellare queste segnalazioni?',
	'REPORTS_A_OPEN'            => 'Apri segnalazioni',
	'REPORTS_A_OPEN2'           => 'Apri segnalazioni?',
	'REPORTS_A_OPEN2_CONFIRM'   => 'Sei sicuro di voler aprire queste segnalazioni?',

	'REPORT_MOD'         => 'Modificato da',
	'REPORT_CLOSED_BY'   => 'Report closed by',
	'REPORTED_IMAGES'    => 'Immagini segnalate',
	'REPORTER'           => 'Segnalazione utente',
	'REPORTER_AND_ALBUM' => 'Segnalazione & Album',

	'WAITING_APPROVED_IMAGE' => [
		0 => 'Non ci sono immagini approvate.',
		1 => 'In totale c’è <span style="font-weight: bold;">1</span> immagine approvata.',
		2 => 'In totale ci sono <span style="font-weight: bold;">%s</span> imamagini approvate.',
	],
	'WAITING_DISAPPROVED_IMAGE' => [
		0 => 'Nessuna immagine disapprovata.',
		1 => 'In totale c’è <span style="font-weight: bold;">1</span> immagine disapprovata.',
		2 => 'In totale ci sono <span style="font-weight: bold;">%s</span> immagini disapprovate.',
	],
	'WAITING_LOCKED_IMAGE' => [
		0 => 'Nessuna immagine bloccata.',
		1 => 'In totale c’è <span style="font-weight: bold;">1</span> immagine chiusa.',
		2 => 'In totale ci sono <span style="font-weight: bold;">%s</span> immagini chiuse.',
	],
	'WAITING_REPORTED_DONE' => [
		0 => 'Nessuna segnalazione ricevuta.',
		1 => 'In totale c’è <span style="font-weight: bold;">1</span> segnalazione controllate.',
		2 => 'In totale ci sono <span style="font-weight: bold;">%s</span> segnalazioni controllate.',
	],
	'WAITING_REPORTED_IMAGE' => [
		0 => 'Nessuna segnalazione ricevuta.',
		1 => 'In totale c’è <span style="font-weight: bold;">1</span> segnalazione da controllare.',
		2 => 'In totale ci sono <span style="font-weight: bold;">%s</span> segnalazioni da controllare.',
	],
	'WAITING_UNAPPROVED_IMAGE' => [
		0 => 'Non risultano immagini in attesa di approvazione.',
		1 => 'In totale c’è <span style="font-weight: bold;">1</span> imaggine in attesa di approvazione.',
		2 => 'In totale ci sono <span style="font-weight: bold;">%s</span> immagini in attesa di approvazione.',
	],
	'DELETED_IMAGES' => [
		0 => 'Nessuna immagine cancellata.',
		1 => 'In totale c’è stata <span style="font-weight: bold;">1</span> immagine  cancellata.',
		2 => 'In totale ci sono state <span style="font-weight: bold;">%s</span> immagini cancellate.',
	],
	'MOVED_IMAGES' => [
		0 => 'Nessuna immagini è stata spostata.',
		1 => 'In totale c’è stata <span style="font-weight: bold;">1</span> imamagine spostata.',
		2 => 'In totale ci sono state <span style="font-weight: bold;">%s</span> immagini spostate.',
	],
	'NO_WAITING_UNAPPROVED_IMAGE' => 'Non ci sono immagini in attesa di approvazione.',
	'GALLERY_MCP_DELETE_REQUESTS' => 'Richieste di eliminazione immagini',
	'LATEST_IMAGE_DELETE_REQUESTS' => 'Richieste recenti di eliminazione immagini',
	'DELETE_REQUEST_RESTORE_CONFIRM' => 'Vuoi davvero ripristinare le immagini selezionate?',
	'QUEUE_STATUS_4' => 'Eliminazione richiesta',
	'WAITING_DELETE_REQUESTS' => [
		0 => 'Nessuna richiesta di eliminazione immagini in attesa.',
		1 => 'È in attesa <span style="font-weight: bold;">1</span> richiesta di eliminazione immagine.',
		2 => 'Sono in attesa <span style="font-weight: bold;">%s</span> richieste di eliminazione immagini.',
	],
	'RESTORED_IMAGES' => [
		0 => 'Nessuna immagine ripristinata.',
		1 => 'È stata ripristinata <span style="font-weight: bold;">1</span> immagine.',
		2 => 'Sono state ripristinate <span style="font-weight: bold;">%s</span> immagini.',
	],
	'NO_WAITING_DELETE_REQUESTS' => 'Nessuna richiesta di eliminazione immagini in attesa.',
]);
