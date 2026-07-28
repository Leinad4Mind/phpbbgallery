<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'Le seguenti estensioni obbligatorie non sono disponibili o sono disabilitate: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'L’estensione è stata attivata correttamente.',
	'ACP_BBTAGSBRIDGE_POLICIES' => 'Criteri dei tag della Galleria',
	'ACP_BBTAGSBRIDGE_POLICIES_EXPLAIN' => 'Configura dove sono disponibili nella Galleria i tag del catalogo BBTags condiviso. La moderazione dei suggerimenti rimane nel pannello di moderazione.',
	'ACP_BBTAGSBRIDGE_TAG' => 'Catalogo dei tag',
	'ACP_BBTAGSBRIDGE_TAG_SELECT' => 'Tag',
	'ACP_BBTAGSBRIDGE_NO_TAGS' => 'Il catalogo condiviso non contiene tag approvati.',
	'ACP_BBTAGSBRIDGE_PROVIDER_POLICY' => 'Disponibilità nella Galleria',
	'ACP_BBTAGSBRIDGE_ENABLED' => 'Disponibile nella Galleria',
	'ACP_BBTAGSBRIDGE_ENABLED_EXPLAIN' => 'Disabilitare un tag lo nasconde dai campi e dalle ricerche della Galleria senza rimuoverlo da BBTags o dal forum.',
	'ACP_BBTAGSBRIDGE_MODE' => 'Disponibilità predefinita',
	'ACP_BBTAGSBRIDGE_MODE_EXPLAIN' => 'La regola esplicita dell’album più vicino prevale su questo valore e sulle regole ereditate.',
	'ACP_BBTAGSBRIDGE_MODE_GLOBAL' => 'Disponibile salvo negazione',
	'ACP_BBTAGSBRIDGE_MODE_RESTRICTED' => 'Non disponibile salvo autorizzazione',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES' => 'Regole per album',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES_EXPLAIN' => 'Eredita usa la regola dell’album superiore più vicino e poi la disponibilità predefinita.',
	'ACP_BBTAGSBRIDGE_ALBUM' => 'Album',
	'ACP_BBTAGSBRIDGE_RULE' => 'Regola',
	'ACP_BBTAGSBRIDGE_RULE_INHERIT' => 'Eredita',
	'ACP_BBTAGSBRIDGE_RULE_ALLOW' => 'Consenti',
	'ACP_BBTAGSBRIDGE_RULE_DENY' => 'Nega',
	'ACP_BBTAGSBRIDGE_NO_ALBUMS' => 'Non ci sono album della Galleria da configurare.',
	'ACP_BBTAGSBRIDGE_SAVE_FAILED' => 'Impossibile salvare il criterio dei tag della Galleria.',
	'ACP_BBTAGSBRIDGE_SAVED' => 'Il criterio dei tag della Galleria è stato salvato.',
]);
