<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSIMAGES_DEPENDENCIES_MISSING' => 'De volgende vereiste extensies zijn niet beschikbaar of uitgeschakeld: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'De extensie is succesvol ingeschakeld.',
	'ACP_BBTAGSIMAGES_POLICIES' => 'Galerijtagbeleid',
	'ACP_BBTAGSIMAGES_POLICIES_EXPLAIN' => 'Stel in waar tags uit de gedeelde BBTags-catalogus in de Galerij beschikbaar zijn. Moderatie van voorstellen blijft in het moderatorpaneel.',
	'ACP_BBTAGSIMAGES_TAG' => 'Tagcatalogus',
	'ACP_BBTAGSIMAGES_TAG_SELECT' => 'Tag',
	'ACP_BBTAGSIMAGES_NO_TAGS' => 'De gedeelde catalogus bevat geen goedgekeurde tags.',
	'ACP_BBTAGSIMAGES_PROVIDER_POLICY' => 'Beschikbaarheid in de Galerij',
	'ACP_BBTAGSIMAGES_ENABLED' => 'Beschikbaar in de Galerij',
	'ACP_BBTAGSIMAGES_ENABLED_EXPLAIN' => 'Een uitgeschakelde tag wordt verborgen in Galerijvelden en zoekopdrachten zonder hem uit BBTags of het forum te verwijderen.',
	'ACP_BBTAGSIMAGES_MODE' => 'Standaardbeschikbaarheid',
	'ACP_BBTAGSIMAGES_MODE_EXPLAIN' => 'De dichtstbijzijnde expliciete albumregel overschrijft deze standaard en geërfde regels.',
	'ACP_BBTAGSIMAGES_MODE_GLOBAL' => 'Beschikbaar tenzij geweigerd',
	'ACP_BBTAGSIMAGES_MODE_RESTRICTED' => 'Niet beschikbaar tenzij toegestaan',
	'ACP_BBTAGSIMAGES_ALBUM_RULES' => 'Albumregels',
	'ACP_BBTAGSIMAGES_ALBUM_RULES_EXPLAIN' => 'Overerven gebruikt de dichtstbijzijnde bovenliggende regel en daarna de standaardbeschikbaarheid.',
	'ACP_BBTAGSIMAGES_ALBUM' => 'Album',
	'ACP_BBTAGSIMAGES_RULE' => 'Regel',
	'ACP_BBTAGSIMAGES_RULE_INHERIT' => 'Overerven',
	'ACP_BBTAGSIMAGES_RULE_ALLOW' => 'Toestaan',
	'ACP_BBTAGSIMAGES_RULE_DENY' => 'Weigeren',
	'ACP_BBTAGSIMAGES_NO_ALBUMS' => 'Er zijn geen Galerijalbums om te configureren.',
	'ACP_BBTAGSIMAGES_SAVE_FAILED' => 'Het Galerijtagbeleid kon niet worden opgeslagen.',
	'ACP_BBTAGSIMAGES_SAVED' => 'Het Galerijtagbeleid is opgeslagen.',
]);
