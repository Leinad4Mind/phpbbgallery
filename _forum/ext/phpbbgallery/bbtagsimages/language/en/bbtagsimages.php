<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGS_PROVIDER_GALLERY_IMAGES' => 'Gallery images',
	'BBTAGSIMAGES_TAGS' => 'Tags',
	'BBTAGSIMAGES_TAGS_EXPLAIN' => 'Add up to %1$d comma-separated tags. Each tag must contain between %2$d and %3$d characters. New tags are sent to moderators for approval.',
	'BBTAGSIMAGES_TAG_TOO_SHORT' => 'Each tag must contain at least %2$d characters.',
	'BBTAGSIMAGES_TAG_TOO_LONG' => 'Each tag may contain no more than %3$d characters.',
	'BBTAGSIMAGES_TAG_LIMIT' => 'You may add no more than %1$d tags to an image.',
	'BBTAGSIMAGES_PENDING_NOTICE' => 'New tags remain hidden until a moderator approves them.',
	'BBTAGSIMAGES_SAVE_FAILED' => 'The image tags could not be saved.',
	'BBTAGSIMAGES_SEARCH_TAGS' => 'Search by tags',
	'BBTAGSIMAGES_SEARCH_TAGS_EXPLAIN' => 'Enter one or more comma-separated tags.',
	'BBTAGSIMAGES_MATCH_ALL_TAGS' => 'Match all tags (AND)',
	'BBTAGSIMAGES_MATCH_ANY_TAG' => 'Match any tag (OR)',
	'BBTAGSIMAGES_FILTER_MORE_TAGS' => 'Filter by more tags',
]);
