<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'De volgende vereiste extensies zijn niet beschikbaar of uitgeschakeld: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'De extensie is succesvol ingeschakeld.',
	'ACP_BBTAGSBRIDGE_POLICIES' => 'Galerijtagbeleid',
	'ACP_BBTAGSBRIDGE_POLICIES_EXPLAIN' => 'Stel in waar tags uit de gedeelde BBTags-catalogus in de Galerij beschikbaar zijn. Moderatie van voorstellen blijft in het moderatorpaneel.',
	'ACP_BBTAGSBRIDGE_TAG' => 'Tagcatalogus',
	'ACP_BBTAGSBRIDGE_TAG_SELECT' => 'Tag',
	'ACP_BBTAGSBRIDGE_NO_TAGS' => 'De gedeelde catalogus bevat geen goedgekeurde tags.',
	'ACP_BBTAGSBRIDGE_PROVIDER_POLICY' => 'Beschikbaarheid in de Galerij',
	'ACP_BBTAGSBRIDGE_ENABLED' => 'Beschikbaar in de Galerij',
	'ACP_BBTAGSBRIDGE_ENABLED_EXPLAIN' => 'Een uitgeschakelde tag wordt verborgen in Galerijvelden en zoekopdrachten zonder hem uit BBTags of het forum te verwijderen.',
	'ACP_BBTAGSBRIDGE_MODE' => 'Standaardbeschikbaarheid',
	'ACP_BBTAGSBRIDGE_MODE_EXPLAIN' => 'De dichtstbijzijnde expliciete albumregel overschrijft deze standaard en geërfde regels.',
	'ACP_BBTAGSBRIDGE_MODE_GLOBAL' => 'Beschikbaar tenzij geweigerd',
	'ACP_BBTAGSBRIDGE_MODE_RESTRICTED' => 'Niet beschikbaar tenzij toegestaan',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES' => 'Albumregels',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES_EXPLAIN' => 'Overerven gebruikt de dichtstbijzijnde bovenliggende regel en daarna de standaardbeschikbaarheid.',
	'ACP_BBTAGSBRIDGE_ALBUM' => 'Album',
	'ACP_BBTAGSBRIDGE_RULE' => 'Regel',
	'ACP_BBTAGSBRIDGE_RULE_INHERIT' => 'Overerven',
	'ACP_BBTAGSBRIDGE_RULE_ALLOW' => 'Toestaan',
	'ACP_BBTAGSBRIDGE_RULE_DENY' => 'Weigeren',
	'ACP_BBTAGSBRIDGE_NO_ALBUMS' => 'Er zijn geen Galerijalbums om te configureren.',
	'ACP_BBTAGSBRIDGE_SAVE_FAILED' => 'Het Galerijtagbeleid kon niet worden opgeslagen.',
	'ACP_BBTAGSBRIDGE_SAVED' => 'Het Galerijtagbeleid is opgeslagen.',
]);
