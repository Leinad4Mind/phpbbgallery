<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'Les extensions requises suivantes sont indisponibles ou désactivées : %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'L’extension a été activée avec succès.',
	'ACP_BBTAGSBRIDGE_POLICIES' => 'Politiques des tags de la Galerie',
	'ACP_BBTAGSBRIDGE_POLICIES_EXPLAIN' => 'Configure les emplacements où les tags du catalogue BBTags partagé sont disponibles dans la Galerie. La modération des suggestions reste dans le panneau de modération.',
	'ACP_BBTAGSBRIDGE_TAG' => 'Catalogue des tags',
	'ACP_BBTAGSBRIDGE_TAG_SELECT' => 'Tag',
	'ACP_BBTAGSBRIDGE_NO_TAGS' => 'Le catalogue partagé ne contient aucun tag approuvé.',
	'ACP_BBTAGSBRIDGE_PROVIDER_POLICY' => 'Disponibilité dans la Galerie',
	'ACP_BBTAGSBRIDGE_ENABLED' => 'Disponible dans la Galerie',
	'ACP_BBTAGSBRIDGE_ENABLED_EXPLAIN' => 'Désactiver un tag le masque des champs et recherches de la Galerie sans le supprimer de BBTags ni du forum.',
	'ACP_BBTAGSBRIDGE_MODE' => 'Disponibilité par défaut',
	'ACP_BBTAGSBRIDGE_MODE_EXPLAIN' => 'La règle explicite de l’album le plus proche remplace cette valeur et les règles héritées.',
	'ACP_BBTAGSBRIDGE_MODE_GLOBAL' => 'Disponible sauf refus',
	'ACP_BBTAGSBRIDGE_MODE_RESTRICTED' => 'Indisponible sauf autorisation',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES' => 'Règles par album',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES_EXPLAIN' => 'Hériter utilise la règle du parent le plus proche, puis la disponibilité par défaut.',
	'ACP_BBTAGSBRIDGE_ALBUM' => 'Album',
	'ACP_BBTAGSBRIDGE_RULE' => 'Règle',
	'ACP_BBTAGSBRIDGE_RULE_INHERIT' => 'Hériter',
	'ACP_BBTAGSBRIDGE_RULE_ALLOW' => 'Autoriser',
	'ACP_BBTAGSBRIDGE_RULE_DENY' => 'Refuser',
	'ACP_BBTAGSBRIDGE_NO_ALBUMS' => 'Aucun album de la Galerie ne peut être configuré.',
	'ACP_BBTAGSBRIDGE_SAVE_FAILED' => 'La politique des tags de la Galerie n’a pas pu être enregistrée.',
	'ACP_BBTAGSBRIDGE_SAVED' => 'La politique des tags de la Galerie a été enregistrée.',
]);
