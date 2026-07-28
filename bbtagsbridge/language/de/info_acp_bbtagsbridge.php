<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'Die folgenden erforderlichen Erweiterungen sind nicht verfügbar oder nicht aktiviert: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'Die Erweiterung wurde erfolgreich aktiviert.',
	'ACP_BBTAGSBRIDGE_POLICIES' => 'Galerie-Tag-Richtlinien',
	'ACP_BBTAGSBRIDGE_POLICIES_EXPLAIN' => 'Legt fest, wo Tags aus dem gemeinsamen BBTags-Katalog in der Galerie verfügbar sind. Die Moderation von Vorschlägen bleibt im Moderationsbereich.',
	'ACP_BBTAGSBRIDGE_TAG' => 'Tag-Katalog',
	'ACP_BBTAGSBRIDGE_TAG_SELECT' => 'Tag',
	'ACP_BBTAGSBRIDGE_NO_TAGS' => 'Der gemeinsame Katalog enthält keine freigegebenen Tags.',
	'ACP_BBTAGSBRIDGE_PROVIDER_POLICY' => 'Verfügbarkeit in der Galerie',
	'ACP_BBTAGSBRIDGE_ENABLED' => 'In der Galerie verfügbar',
	'ACP_BBTAGSBRIDGE_ENABLED_EXPLAIN' => 'Ein deaktivierter Tag wird in Galerie-Eingaben und Suchen ausgeblendet, ohne ihn aus BBTags oder dem Forum zu entfernen.',
	'ACP_BBTAGSBRIDGE_MODE' => 'Standardverfügbarkeit',
	'ACP_BBTAGSBRIDGE_MODE_EXPLAIN' => 'Die nächste ausdrückliche Albumregel überschreibt diesen Standard und geerbte Regeln.',
	'ACP_BBTAGSBRIDGE_MODE_GLOBAL' => 'Verfügbar, sofern nicht verweigert',
	'ACP_BBTAGSBRIDGE_MODE_RESTRICTED' => 'Nicht verfügbar, sofern nicht erlaubt',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES' => 'Albumregeln',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES_EXPLAIN' => 'Vererben verwendet die nächste übergeordnete Regel und danach die Standardverfügbarkeit.',
	'ACP_BBTAGSBRIDGE_ALBUM' => 'Album',
	'ACP_BBTAGSBRIDGE_RULE' => 'Regel',
	'ACP_BBTAGSBRIDGE_RULE_INHERIT' => 'Vererben',
	'ACP_BBTAGSBRIDGE_RULE_ALLOW' => 'Erlauben',
	'ACP_BBTAGSBRIDGE_RULE_DENY' => 'Verweigern',
	'ACP_BBTAGSBRIDGE_NO_ALBUMS' => 'Es sind keine Galeriealben zum Konfigurieren vorhanden.',
	'ACP_BBTAGSBRIDGE_SAVE_FAILED' => 'Die Galerie-Tag-Richtlinie konnte nicht gespeichert werden.',
	'ACP_BBTAGSBRIDGE_SAVED' => 'Die Galerie-Tag-Richtlinie wurde erfolgreich gespeichert.',
]);
