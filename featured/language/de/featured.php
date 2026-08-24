<?php
/**
 * phpBB Gallery - Featured Images language.
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'FEATURED_IMAGES' => 'Hervorgehobene Bilder',
	'FEATURED_SETTINGS' => 'Hervorgehobene Bilder und Diashow',
	'FEATURE_IMAGE' => 'Bild hervorheben',
	'UNFEATURE_IMAGE' => 'Aus hervorgehobenen Bildern entfernen',
	'FEATURED_IMAGE_ADDED' => 'Das Bild wurde zur hervorgehobenen Auswahl hinzugefügt.',
	'FEATURED_IMAGE_REMOVED' => 'Das Bild wurde aus der hervorgehobenen Auswahl entfernt.',
	'FEATURED_NOT_AUTHORISED' => 'Du bist nicht berechtigt, hervorgehobene Bilder in diesem Album zu verwalten.',
	'FEATURED_APPROVED_ONLY' => 'Nur freigegebene Bilder können hervorgehoben werden.',
	'FEATURED_ENABLE' => 'Hervorgehobene Bilder anzeigen',
	'FEATURED_ENABLE_EXPLAIN' => 'Zeigt die von Moderatoren zusammengestellte Auswahl auf der Galerie-Startseite an.',
	'FEATURED_COUNT' => 'Anzahl hervorgehobener Bilder',
	'FEATURED_COUNT_EXPLAIN' => 'Anzahl der sichtbaren hervorgehobenen Bilder von 1 bis 20. Die Berechtigungen werden für jeden Betrachter separat geprüft.',
	'FEATURED_SLIDESHOW' => 'Als Diashow anzeigen',
	'FEATURED_SLIDESHOW_EXPLAIN' => 'Zeigt jeweils ein großes hervorgehobenes Bild mit barrierefreier Navigation an. Wenn deaktiviert, wird das konfigurierte Kartenlayout der Galerie verwendet.',
	'FEATURED_AUTOPLAY' => 'Diashow automatisch starten',
	'FEATURED_AUTOPLAY_EXPLAIN' => 'Die automatische Wiedergabe ist bei gewünschter reduzierter Bewegung deaktiviert und kann jederzeit angehalten werden.',
	'FEATURED_INTERVAL' => 'Diashow-Intervall',
	'FEATURED_INTERVAL_EXPLAIN' => 'Zeit zwischen automatischen Bildwechseln von 3 bis 30 Sekunden.',
	'FEATURED_INCLUDE_PERSONAL' => 'Bilder aus persönlichen Alben einbeziehen',
	'FEATURED_INCLUDE_PERSONAL_EXPLAIN' => 'Erlaubt ausgewählte Bilder aus persönlichen Alben, wenn der Betrachter sie sehen darf.',
	'FEATURED_SLIDESHOW_CONTROLS' => 'Steuerung der hervorgehobenen Bilder',
	'FEATURED_PREVIOUS' => 'Vorheriges hervorgehobenes Bild',
	'FEATURED_NEXT' => 'Nächstes hervorgehobenes Bild',
	'FEATURED_PLAY' => 'Diashow abspielen',
	'FEATURED_PAUSE' => 'Diashow anhalten',
	'FEATURED_GO_TO' => 'Hervorgehobenes Bild %d anzeigen',
	'GALLERY_CORE_NOT_FOUND' => 'Gallery Core 4.2.0 oder neuer muss installiert und aktiviert sein, bevor Hervorgehobene Bilder aktiviert werden kann.',
]);
