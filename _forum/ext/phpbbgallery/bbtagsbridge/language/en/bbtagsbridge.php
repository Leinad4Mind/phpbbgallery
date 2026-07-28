<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Gallery images',
	'BBTAGSBRIDGE_TAGS' => 'Tags',
	'BBTAGSBRIDGE_TAGS_EXPLAIN' => 'Add up to %1$d comma-separated tags. Each tag must contain between %2$d and %3$d characters. New tags are sent to moderators for approval.',
	'BBTAGSBRIDGE_TAG_TOO_SHORT' => 'Each tag must contain at least %2$d characters.',
	'BBTAGSBRIDGE_TAG_TOO_LONG' => 'Each tag may contain no more than %3$d characters.',
	'BBTAGSBRIDGE_TAG_LIMIT' => 'You may add no more than %1$d tags to an image.',
	'BBTAGSBRIDGE_PENDING_NOTICE' => 'New tags remain hidden until a moderator approves them.',
	'BBTAGSBRIDGE_SAVE_FAILED' => 'The image tags could not be saved.',
	'BBTAGSBRIDGE_SEARCH_TAGS' => 'Search by tags',
	'BBTAGSBRIDGE_SEARCH_TAGS_EXPLAIN' => 'Enter one or more comma-separated tags.',
	'BBTAGSBRIDGE_MATCH_ALL_TAGS' => 'Match all tags (AND)',
	'BBTAGSBRIDGE_MATCH_ANY_TAG' => 'Match any tag (OR)',
	'BBTAGSBRIDGE_FILTER_MORE_TAGS' => 'Filter by more tags',
]);
