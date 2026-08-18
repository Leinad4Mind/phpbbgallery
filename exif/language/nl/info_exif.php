<?php
/**
 * phpBB Gallery - ACP Exif Extension [Dutch Translation]
 *
 * @package   phpbbgallery/exif
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
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
 * Language for Exif data
 */
$lang = array_merge($lang, [
	'EXIF_DATA'                  => 'EXIF-gegevens',
	'EXIF_APERTURE'              => 'F-getal',
	'EXIF_CAM_MODEL'             => 'Cameramodel',
	'EXIF_DATE'                  => 'Opnamedatum',
	'EXIF_RESOLUTION'            => 'Resolutiedichtheid',
	'EXIF_EXPOSURE'              => 'Sluitertijd',
	'EXIF_EXPOSURE_EXP'          => '%s sec.',
	'EXIF_EXPOSURE_BIAS'         => 'Belichtingscompensatie',
	'EXIF_EXPOSURE_BIAS_EXP'     => '%s EV',
	'EXIF_EXPOSURE_PROG'         => 'Belichtingsprogramma',
	'EXIF_EXPOSURE_PROG_0'       => 'Niet gedefinieerd',
	'EXIF_EXPOSURE_PROG_1'       => 'Handmatig',
	'EXIF_EXPOSURE_PROG_2'       => 'Normaal programma',
	'EXIF_EXPOSURE_PROG_3'       => 'Diafragmavoorkeuze',
	'EXIF_EXPOSURE_PROG_4'       => 'Sluitertijdvoorkeuze',
	'EXIF_EXPOSURE_PROG_5'       => 'Creatief programma (gericht op scherptediepte)',
	'EXIF_EXPOSURE_PROG_6'       => 'Actieprogramma (gericht op een korte sluitertijd)',
	'EXIF_EXPOSURE_PROG_7'       => 'Portretmodus (voor close-ups met een onscherpe achtergrond)',
	'EXIF_EXPOSURE_PROG_8'       => 'Landschapsmodus (voor landschappen met een scherpe achtergrond)',
	'EXIF_FLASH'                  => 'Flitser',
	'EXIF_FLASH_CASE_0'           => 'Flitser is niet afgegaan',
	'EXIF_FLASH_CASE_1'           => 'Flitser is afgegaan',
	'EXIF_FLASH_CASE_5'           => 'Geen retourlicht gedetecteerd',
	'EXIF_FLASH_CASE_7'           => 'Retourlicht gedetecteerd',
	'EXIF_FLASH_CASE_8'           => 'Aan, flitser is niet afgegaan',
	'EXIF_FLASH_CASE_9'           => 'Flitser is afgegaan in verplichte flitsmodus',
	'EXIF_FLASH_CASE_13'          => 'Flitser is afgegaan in verplichte flitsmodus; geen retourlicht gedetecteerd',
	'EXIF_FLASH_CASE_15'          => 'Flitser is afgegaan in verplichte flitsmodus; retourlicht gedetecteerd',
	'EXIF_FLASH_CASE_16'          => 'Flitser is niet afgegaan in verplichte flitsmodus',
	'EXIF_FLASH_CASE_20'          => 'Uit, flitser is niet afgegaan en geen retourlicht gedetecteerd',
	'EXIF_FLASH_CASE_24'          => 'Flitser is niet afgegaan in automatische modus',
	'EXIF_FLASH_CASE_25'          => 'Flitser is afgegaan in automatische modus',
	'EXIF_FLASH_CASE_29'          => 'Flitser is afgegaan in automatische modus; geen retourlicht gedetecteerd',
	'EXIF_FLASH_CASE_31'          => 'Flitser is afgegaan in automatische modus; retourlicht gedetecteerd',
	'EXIF_FLASH_CASE_32'          => 'Geen flitsfunctie',
	'EXIF_FLASH_CASE_48'          => 'Uit, geen flitsfunctie',
	'EXIF_FLASH_CASE_65'          => 'Flitser is afgegaan met rode-ogenreductie',
	'EXIF_FLASH_CASE_69'          => 'Flitser is afgegaan met rode-ogenreductie; geen retourlicht gedetecteerd',
	'EXIF_FLASH_CASE_71'          => 'Flitser is afgegaan met rode-ogenreductie; retourlicht gedetecteerd',
	'EXIF_FLASH_CASE_73'          => 'Flitser is afgegaan in verplichte flitsmodus met rode-ogenreductie',
	'EXIF_FLASH_CASE_77'          => 'Flitser is afgegaan in verplichte flitsmodus met rode-ogenreductie; geen retourlicht gedetecteerd',
	'EXIF_FLASH_CASE_79'          => 'Flitser is afgegaan in verplichte flitsmodus met rode-ogenreductie; retourlicht gedetecteerd',
	'EXIF_FLASH_CASE_80'          => 'Uit, rode-ogenreductie',
	'EXIF_FLASH_CASE_88'          => 'Automatisch, niet afgegaan, rode-ogenreductie',
	'EXIF_FLASH_CASE_89'          => 'Flitser is afgegaan in automatische modus met rode-ogenreductie',
	'EXIF_FLASH_CASE_93'          => 'Flitser is afgegaan in automatische modus met rode-ogenreductie; geen retourlicht gedetecteerd',
	'EXIF_FLASH_CASE_95'          => 'Flitser is afgegaan in automatische modus met rode-ogenreductie; retourlicht gedetecteerd',
	'EXIF_FOCAL'                  => 'Brandpuntsafstand',
	'EXIF_FOCAL_EXP'              => '%s mm',
	'EXIF_ISO'                    => 'ISO-waarde',
	'EXIF_METERING_MODE'          => 'Lichtmeetmethode',
	'EXIF_METERING_MODE_0'        => 'Onbekend',
	'EXIF_METERING_MODE_1'        => 'Gemiddeld',
	'EXIF_METERING_MODE_2'        => 'Centrumgericht gemiddelde',
	'EXIF_METERING_MODE_3'        => 'Spotmeting',
	'EXIF_METERING_MODE_4'        => 'Meervoudige spotmeting',
	'EXIF_METERING_MODE_5'        => 'Patroon',
	'EXIF_METERING_MODE_6'        => 'Gedeeltelijk',
	'EXIF_METERING_MODE_255'      => 'Overig',
	'EXIF_NOT_AVAILABLE'          => 'niet beschikbaar',
	'EXIF_WHITEB'                 => 'Witbalans',
	'EXIF_WHITEB_AUTO'            => 'Automatisch',
	'EXIF_WHITEB_MANU'            => 'Handmatig',

	'DISP_EXIF_DATA'              => 'EXIF-gegevens weergeven',
	'DISP_EXIF_DATA_EXP'          => 'Deze functie is niet beschikbaar omdat de PHP-installatie de functie “exif_read_data” niet bevat.',
	'DISP_EXIF_DATE'              => '“Foto genomen op” tonen',
	'DISP_EXIF_FOCAL'             => 'Brandpuntsafstand tonen',
	'DISP_EXIF_EXPOSURE'          => 'Sluitertijd tonen',
	'DISP_EXIF_APERTURE'          => 'Diafragma tonen',
	'DISP_EXIF_ISO'               => 'ISO-waarde tonen',
	'DISP_EXIF_WHITEB'            => 'Witbalans tonen',
	'DISP_EXIF_FLASH'             => 'Flits tonen',
	'DISP_EXIF_CAM_MODEL'         => 'Cameramodel tonen',
	'DISP_EXIF_RESOLUTION'        => 'Resolutiedichtheid tonen',
	'DISP_EXIF_EXPOSURE_PROG'     => 'Belichtingsprogramma tonen',
	'DISP_EXIF_EXPOSURE_BIAS'     => 'Belichtingscorrectie tonen',
	'DISP_EXIF_METERING_MODE'     => 'Meetmethode tonen',
	'SHOW_EXIF'                   => 'tonen/verbergen',
	'VIEWEXIFS_DEFAULT'           => 'EXIF-gegevens standaard weergeven',

	'GALLERY_CORE_NOT_FOUND'      => 'De phpBB Gallery Core-extensie moet eerst worden geïnstalleerd en ingeschakeld.',
	'EXTENSION_ENABLE_SUCCESS'    => 'De extensie is ingeschakeld.',
	'ACP_GALLERY_EXIF'           => 'EXIF-metadata',
	'ACP_GALLERY_EXIF_EXPLAIN'   => 'Beheert de geïndexeerde opnamedatums die voor het sorteren van de Galerij worden gebruikt.',
	'ACP_EXIF_CAPTURE_INDEX'     => 'Index van opnamedatums',
	'ACP_EXIF_INDEXED_IMAGES'    => 'Afbeeldingen met een geïndexeerde opnamedatum',
	'ACP_EXIF_SYNC_EXPLAIN'      => 'Bouwt de index opnieuw op uit opgeslagen EXIF-metadata en zo nodig uit de originele JPEG-bestanden. De bewerking gebruikt kleine hervatbare batches.',
	'ACP_EXIF_SYNC_CONFIRM'      => 'Weet je zeker dat je de EXIF-opnamedatumindex opnieuw wilt opbouwen?',
	'ACP_EXIF_SYNC_PROGRESS'     => 'EXIF-synchronisatie bezig: %1$d afbeeldingen gecontroleerd, %2$d datums geïndexeerd en %3$d bronbestanden tijdelijk niet beschikbaar.',
	'DISP_EXIF_DATA_EXPLAIN' => 'Schakelt de EXIF-weergave overal in. Wanneer dit is uitgeschakeld, worden EXIF-keuzes voor zowel de afzonderlijke afbeeldingspagina als miniatuurkaarten genegeerd.',
	'EXIF_IMAGE_PAGE_FIELD_EXPLAIN' => 'Bepaalt deze waarde alleen op de afzonderlijke afbeeldingspagina. Selecteer deze apart in de relevante kaartinformatie-instelling om haar onder miniaturen te tonen.',
	'ACP_EXIF_SYNC_COMPLETE'     => 'EXIF-synchronisatie voltooid: %1$d afbeeldingen gecontroleerd, %2$d datums geïndexeerd en %3$d bronbestanden niet beschikbaar.',
]);
