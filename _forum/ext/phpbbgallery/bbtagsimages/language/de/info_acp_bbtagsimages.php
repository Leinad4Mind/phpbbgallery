<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSIMAGES_DEPENDENCIES_MISSING' => 'Die folgenden erforderlichen Erweiterungen sind nicht verfügbar oder nicht aktiviert: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'Die Erweiterung wurde erfolgreich aktiviert.',
	'ACP_BBTAGSIMAGES_POLICIES' => 'Galerie-Tag-Richtlinien',
	'ACP_BBTAGSIMAGES_POLICIES_EXPLAIN' => 'Legt fest, wo Tags aus dem gemeinsamen BBTags-Katalog in der Galerie verfügbar sind. Die Moderation von Vorschlägen bleibt im Moderationsbereich.',
	'ACP_BBTAGSIMAGES_TAG' => 'Tag-Katalog',
	'ACP_BBTAGSIMAGES_TAG_SELECT' => 'Tag',
	'ACP_BBTAGSIMAGES_NO_TAGS' => 'Der gemeinsame Katalog enthält keine freigegebenen Tags.',
	'ACP_BBTAGSIMAGES_PROVIDER_POLICY' => 'Verfügbarkeit in der Galerie',
	'ACP_BBTAGSIMAGES_ENABLED' => 'In der Galerie verfügbar',
	'ACP_BBTAGSIMAGES_ENABLED_EXPLAIN' => 'Ein deaktivierter Tag wird in Galerie-Eingaben und Suchen ausgeblendet, ohne ihn aus BBTags oder dem Forum zu entfernen.',
	'ACP_BBTAGSIMAGES_MODE' => 'Standardverfügbarkeit',
	'ACP_BBTAGSIMAGES_MODE_EXPLAIN' => 'Die nächste ausdrückliche Albumregel überschreibt diesen Standard und geerbte Regeln.',
	'ACP_BBTAGSIMAGES_MODE_GLOBAL' => 'Verfügbar, sofern nicht verweigert',
	'ACP_BBTAGSIMAGES_MODE_RESTRICTED' => 'Nicht verfügbar, sofern nicht erlaubt',
	'ACP_BBTAGSIMAGES_ALBUM_RULES' => 'Albumregeln',
	'ACP_BBTAGSIMAGES_ALBUM_RULES_EXPLAIN' => 'Vererben verwendet die nächste übergeordnete Regel und danach die Standardverfügbarkeit.',
	'ACP_BBTAGSIMAGES_ALBUM' => 'Album',
	'ACP_BBTAGSIMAGES_RULE' => 'Regel',
	'ACP_BBTAGSIMAGES_RULE_INHERIT' => 'Vererben',
	'ACP_BBTAGSIMAGES_RULE_ALLOW' => 'Erlauben',
	'ACP_BBTAGSIMAGES_RULE_DENY' => 'Verweigern',
	'ACP_BBTAGSIMAGES_NO_ALBUMS' => 'Es sind keine Galeriealben zum Konfigurieren vorhanden.',
	'ACP_BBTAGSIMAGES_SAVE_FAILED' => 'Die Galerie-Tag-Richtlinie konnte nicht gespeichert werden.',
	'ACP_BBTAGSIMAGES_SAVED' => 'Die Galerie-Tag-Richtlinie wurde erfolgreich gespeichert.',
]);
