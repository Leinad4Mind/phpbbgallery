<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'The following required extensions are unavailable or disabled: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'The extension has been enabled successfully.',
	'ACP_BBTAGSBRIDGE_POLICIES' => 'Gallery tag policies',
	'ACP_BBTAGSBRIDGE_POLICIES_EXPLAIN' => 'Configure where tags from the shared BBTags catalogue are available in the Gallery. Tag suggestion moderation remains in the Moderator Control Panel.',
	'ACP_BBTAGSBRIDGE_TAG' => 'Tag catalogue',
	'ACP_BBTAGSBRIDGE_TAG_SELECT' => 'Tag',
	'ACP_BBTAGSBRIDGE_NO_TAGS' => 'The shared catalogue does not contain any approved tags.',
	'ACP_BBTAGSBRIDGE_PROVIDER_POLICY' => 'Gallery availability',
	'ACP_BBTAGSBRIDGE_ENABLED' => 'Available to the Gallery',
	'ACP_BBTAGSBRIDGE_ENABLED_EXPLAIN' => 'Disabling a tag hides it from Gallery inputs and searches without removing it from BBTags or the forum.',
	'ACP_BBTAGSBRIDGE_MODE' => 'Default availability',
	'ACP_BBTAGSBRIDGE_MODE_EXPLAIN' => 'The nearest explicit album rule overrides this default and any rule inherited from a parent album.',
	'ACP_BBTAGSBRIDGE_MODE_GLOBAL' => 'Available unless denied',
	'ACP_BBTAGSBRIDGE_MODE_RESTRICTED' => 'Unavailable unless allowed',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES' => 'Album rules',
	'ACP_BBTAGSBRIDGE_ALBUM_RULES_EXPLAIN' => 'Inherit uses the nearest parent rule and then the default availability.',
	'ACP_BBTAGSBRIDGE_ALBUM' => 'Album',
	'ACP_BBTAGSBRIDGE_RULE' => 'Rule',
	'ACP_BBTAGSBRIDGE_RULE_INHERIT' => 'Inherit',
	'ACP_BBTAGSBRIDGE_RULE_ALLOW' => 'Allow',
	'ACP_BBTAGSBRIDGE_RULE_DENY' => 'Deny',
	'ACP_BBTAGSBRIDGE_NO_ALBUMS' => 'There are no Gallery albums to configure.',
	'ACP_BBTAGSBRIDGE_SAVE_FAILED' => 'The Gallery tag policy could not be saved.',
	'ACP_BBTAGSBRIDGE_SAVED' => 'The Gallery tag policy was saved successfully.',
]);
