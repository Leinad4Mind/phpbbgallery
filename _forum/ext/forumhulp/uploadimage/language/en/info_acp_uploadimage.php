<?php

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_UPLOAD_IMAGE_TITLE' => 'Upload Images',
	'ACP_IMAGE_TITLE' => 'Upload Image',
	'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN' => 'Upload GIF, JPEG, and PNG files to the board’s images/%1$s directory. Copy an image path by selecting its copy button. Deleting an image does not check whether it is still referenced elsewhere.',
	'IMAGE_LIST' => 'Image folder',
	'IMAGE_PATH' => 'Image path',
	'IMAGE_NAME' => 'Image name',
	'FORMAT' => 'Dimensions',
	'SIZE' => 'Size',
	'FOLDER_SIZE' => 'Folder size',
	'IMG_FOLDER' => 'Upload folder',
	'ACP_IMAGE_COPY_PATH' => 'Copy image path',
	'IMAGE_DELETE' => 'Delete',
	'ACP_IMAGE_DELETE_CONFIRM' => 'Are you sure you want to delete this image?',
	'ACP_IMAGE_DELETE_SUCCESS' => 'Image deleted.',
	'ACP_IMAGE_DELETED_LOG' => '<strong>Image deleted</strong><br />» %1$s',
	'UPLOADIMAGE_NOTICE' => '<div class="phpinfo"><p class="entry">This extension is available under %1$s » %2$s » %3$s.</p></div>',
	'FH_HELPER_NOTICE' => 'Forumhulp Helper is required. Install and enable <a href="https://github.com/ForumHulp/helper" target="_blank" rel="noopener noreferrer">forumhulp/helper</a>.',
	'DESCRIPTION_PAGE' => 'Description',
	'DESCRIPTION_NOTICE' => 'Extension notes',
	'ext_details' => [
		'details' => [
			'DESCRIPTION_1' => 'Image previews',
			'DESCRIPTION_2' => 'Up to 10 queued uploads',
			'DESCRIPTION_3' => 'Image dimensions and file size',
			'DESCRIPTION_4' => 'One-click path copying',
		],
		'note' => [
			'NOTICE_1' => 'The effective upload size is limited by PHP and phpBB.',
			'NOTICE_2' => 'Compatible with phpBB 3.3 and PHP 8.1 or newer.',
		],
	],
]);
