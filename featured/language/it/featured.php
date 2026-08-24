<?php
/**
 * phpBB Gallery - Featured Images language.
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'FEATURED_IMAGES' => 'Immagini in evidenza',
	'FEATURED_SETTINGS' => 'Immagini in evidenza e presentazione',
	'FEATURE_IMAGE' => 'Metti in evidenza',
	'UNFEATURE_IMAGE' => 'Rimuovi dalle immagini in evidenza',
	'FEATURED_IMAGE_ADDED' => 'L’immagine è stata aggiunta alla selezione in evidenza.',
	'FEATURED_IMAGE_REMOVED' => 'L’immagine è stata rimossa dalla selezione in evidenza.',
	'FEATURED_NOT_AUTHORISED' => 'Non sei autorizzato a gestire le immagini in evidenza in questo album.',
	'FEATURED_APPROVED_ONLY' => 'Solo le immagini approvate possono essere messe in evidenza.',
	'FEATURED_ENABLE' => 'Mostra immagini in evidenza',
	'FEATURED_ENABLE_EXPLAIN' => 'Mostra nell’indice della Galleria la selezione curata dai moderatori.',
	'FEATURED_COUNT' => 'Numero di immagini in evidenza',
	'FEATURED_COUNT_EXPLAIN' => 'Numero di immagini in evidenza visibili da mostrare, da 1 a 20. I permessi vengono filtrati separatamente per ogni visitatore.',
	'FEATURED_SLIDESHOW' => 'Usa la presentazione',
	'FEATURED_SLIDESHOW_EXPLAIN' => 'Mostra una grande immagine in evidenza alla volta con navigazione accessibile. Se disattivata, usa il layout a schede configurato nella Galleria.',
	'FEATURED_AUTOPLAY' => 'Avvia automaticamente la presentazione',
	'FEATURED_AUTOPLAY_EXPLAIN' => 'La riproduzione automatica è disattivata per chi richiede movimento ridotto e può sempre essere messa in pausa.',
	'FEATURED_INTERVAL' => 'Intervallo della presentazione',
	'FEATURED_INTERVAL_EXPLAIN' => 'Tempo tra i cambi automatici, da 3 a 30 secondi.',
	'FEATURED_INCLUDE_PERSONAL' => 'Includi immagini degli album personali',
	'FEATURED_INCLUDE_PERSONAL_EXPLAIN' => 'Consente di mostrare immagini selezionate dagli album personali quando il visitatore ha il permesso di vederle.',
	'FEATURED_SLIDESHOW_CONTROLS' => 'Controlli delle immagini in evidenza',
	'FEATURED_PREVIOUS' => 'Immagine in evidenza precedente',
	'FEATURED_NEXT' => 'Immagine in evidenza successiva',
	'FEATURED_PLAY' => 'Riproduci presentazione',
	'FEATURED_PAUSE' => 'Metti in pausa la presentazione',
	'FEATURED_GO_TO' => 'Mostra immagine in evidenza %d',
	'GALLERY_CORE_NOT_FOUND' => 'Gallery Core 4.2.0 o successivo deve essere installato e attivato prima di attivare Immagini in evidenza.',
]);
