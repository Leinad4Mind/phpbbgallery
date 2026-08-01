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
	'BBPOINTSIMAGES_DEPENDENCIES_MISSING' => 'De vereiste extensies zijn niet ingeschakeld: %s.',
	'ACP_BBPOINTSIMAGES_SETTINGS' => 'BBPoints voor afbeeldingen',
	'ACP_BBPOINTSIMAGES_SETTINGS_EXPLAIN' => 'Stel beloningen voor publicaties in de Galerij en kosten voor toegang tot originele bestanden in.',
	'ACP_BBPOINTSIMAGES_GLOBAL' => 'Algemene instellingen',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD' => 'Beloning per goedgekeurde afbeelding',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD_EXPLAIN' => 'Punten die eenmaal aan de uiteindelijke auteur worden toegekend bij goedkeuring. Stel 0 in om beloningen uit te schakelen.',
	'ACP_BBPOINTSIMAGES_SOURCE_COST' => 'Kosten van het originele bestand',
	'ACP_BBPOINTSIMAGES_SOURCE_COST_EXPLAIN' => 'Punten die nodig zijn om toegang tot het originele bestand te kopen. Stel 0 in voor gratis toegang.',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES' => 'Afwijkingen per album',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Elke waarde vervangt onafhankelijk de dichtstbijzijnde bovenliggende waarde. Gebruik -1 om te erven.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Album',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Gebruik -1 om de waarde van de dichtstbijzijnde ingestelde voorouder of de algemene instelling te erven.',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'Er zijn geen Galerij-albums beschikbaar.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'De instellingen voor BBPoints voor afbeeldingen zijn opgeslagen.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Beloningen voor bestaande afbeeldingen',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Controleer goedgekeurde bestaande afbeeldingen en ken de ingestelde beloning toe. Bestaande beloningen en exact gelijke bestanden worden overgeslagen.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Bestaande beloningen synchroniseren',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => 'Weet je zeker dat je alle geschikte bestaande afbeeldingen volgens de huidige albumregels wilt belonen?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'De synchronisatie gaat verder. Tot nu toe zijn %1$d afbeeldingen gecontroleerd en %2$d beloningen toegekend.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'De synchronisatie is voltooid. %1$d afbeeldingen zijn gecontroleerd en %2$d beloningen zijn toegekend.',
	'BBPOINTSIMAGES_SOURCE_LOGIN' => 'Je moet je aanmelden om dit originele afbeeldingsbestand te kopen.',
	'BBPOINTSIMAGES_SOURCE_PURCHASE_CONFIRM' => 'Het downloaden van dit originele afbeeldingsbestand kost %1$d punten. Wil je doorgaan?',
	'BBPOINTSIMAGES_INSUFFICIENT_FUNDS' => 'Je hebt %1$d punten, maar dit originele afbeeldingsbestand vereist %2$d punten.',
	'BBPOINTSIMAGES_SOURCE_UNAVAILABLE' => 'Het originele afbeeldingsbestand kan momenteel niet worden gekocht.',
	'BBPOINTSIMAGES_DOWNLOADS' => 'Downloads van het origineel',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS' => 'Toewijzing van bijdragers toestaan',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Laat auteurs en bewerkers van afbeeldingen bijdragers vermelden. Bestaande bijdragers behouden hun vermelding en aandeel in betaalde downloads wanneer dit wordt uitgeschakeld.',
	'BBPOINTSIMAGES_CONTRIBUTORS' => 'Bijdragers',
	'BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Voer één geregistreerde gebruikersnaam per regel in, maximaal %1$d. De auteur van de afbeelding wordt automatisch uitgesloten.',
	'BBPOINTSIMAGES_CONTRIBUTORS_UNKNOWN' => 'Deze bijdragers zijn niet gevonden of zijn inactief: %1$s.',
	'BBPOINTSIMAGES_CONTRIBUTORS_TOO_MANY' => 'Een afbeelding mag niet meer dan %1$d bijdragers hebben.',
]);
