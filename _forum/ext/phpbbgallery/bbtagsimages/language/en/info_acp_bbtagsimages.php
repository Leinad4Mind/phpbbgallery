<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSIMAGES_DEPENDENCIES_MISSING' => 'The following required extensions are unavailable or disabled: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'The extension has been enabled successfully.',
	'ACP_BBTAGSIMAGES_POLICIES' => 'Gallery tag policies',
	'ACP_BBTAGSIMAGES_POLICIES_EXPLAIN' => 'Configure where tags from the shared BBTags catalogue are available in the Gallery. Tag suggestion moderation remains in the Moderator Control Panel.',
	'ACP_BBTAGSIMAGES_TAG' => 'Tag catalogue',
	'ACP_BBTAGSIMAGES_TAG_SELECT' => 'Tag',
	'ACP_BBTAGSIMAGES_NO_TAGS' => 'The shared catalogue does not contain any approved tags.',
	'ACP_BBTAGSIMAGES_PROVIDER_POLICY' => 'Gallery availability',
	'ACP_BBTAGSIMAGES_ENABLED' => 'Available to the Gallery',
	'ACP_BBTAGSIMAGES_ENABLED_EXPLAIN' => 'Disabling a tag hides it from Gallery inputs and searches without removing it from BBTags or the forum.',
	'ACP_BBTAGSIMAGES_MODE' => 'Default availability',
	'ACP_BBTAGSIMAGES_MODE_EXPLAIN' => 'The nearest explicit album rule overrides this default and any rule inherited from a parent album.',
	'ACP_BBTAGSIMAGES_MODE_GLOBAL' => 'Available unless denied',
	'ACP_BBTAGSIMAGES_MODE_RESTRICTED' => 'Unavailable unless allowed',
	'ACP_BBTAGSIMAGES_ALBUM_RULES' => 'Album rules',
	'ACP_BBTAGSIMAGES_ALBUM_RULES_EXPLAIN' => 'Inherit uses the nearest parent rule and then the default availability.',
	'ACP_BBTAGSIMAGES_ALBUM' => 'Album',
	'ACP_BBTAGSIMAGES_RULE' => 'Rule',
	'ACP_BBTAGSIMAGES_RULE_INHERIT' => 'Inherit',
	'ACP_BBTAGSIMAGES_RULE_ALLOW' => 'Allow',
	'ACP_BBTAGSIMAGES_RULE_DENY' => 'Deny',
	'ACP_BBTAGSIMAGES_NO_ALBUMS' => 'There are no Gallery albums to configure.',
	'ACP_BBTAGSIMAGES_SAVE_FAILED' => 'The Gallery tag policy could not be saved.',
	'ACP_BBTAGSIMAGES_SAVED' => 'The Gallery tag policy was saved successfully.',
]);
