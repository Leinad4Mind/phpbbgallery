<?php
/**
*
* gallery [English]
*
* @package phpBB Gallery
* @version $Id$
* @copyright (c) 2007 nickvergessen nickvergessen@gmx.de http://www.flying-bits.org
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
**/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ADD_UPLOAD_FIELD'				=> 'Add more upload fields',
	'ALBUM'							=> 'Album',
	'ALBUM_IS_CATEGORY'				=> 'The album you cheated to, is a category-album.<br />You can’t upload to categories.',
	'ALBUM_LOCKED'					=> 'Locked',
	'ALBUM_NAME'					=> 'Album name',
	'ALBUM_NOT_EXIST'				=> 'This album does not exist',
	'ALBUM_PERMISSIONS'				=> 'Album Permissions',
	'ALBUM_REACHED_QUOTA'			=> 'This album has reached the quota of images. You cannot upload images anymore.<br />Please contact the administrator for more information.',
	'ALBUM_UPLOAD_NEED_APPROVAL'		=> 'Your images have been uploaded successfully.<br /><br />But your image must be approved by a administrator or a moderator before they are public visible.',
	'ALBUM_UPLOAD_NEED_APPROVAL_ERROR'	=> 'Some of your images have been uploaded successfully.<br /><br />But your images must be approved by a administrator or a moderator before they are public visible.<br /><br /><p class="error">%s</p>',
	'ALBUM_UPLOAD_SUCCESSFUL'		=> 'Your images have been uploaded successfully.',
	'ALBUM_UPLOAD_SUCCESSFUL_ERROR'	=> 'Some of your images have been uploaded successfully.<br /><br /><span class="error">%s</span>',
	'ALBUMS_MARKED'					=> 'All albums have been marked read.',
	'ALL'							=> 'All',
	'ALL_IMAGES'					=> 'All image',
	'ALLOW_COMMENTS'				=> 'Allow comments for this image.',
	'ALLOW_COMMENTS_ARY'			=> array(
		0	=> 'Allow comments for this image.',
		2	=> 'Allow comments for these images.',
	),
	'ALLOWED_FILETYPES'				=> 'Allowed filetypes',
	'APPROVE'						=> 'Approve',
	'APPROVE_IMAGE'					=> 'Approve image',

	//@todo
	'ALBUM_COMMENT_CAN'			=> 'You <strong>can</strong> post comments to images in this album',
	'ALBUM_COMMENT_CANNOT'		=> 'You <strong>cannot</strong> post comments to images in this album',
	'ALBUM_DELETE_CAN'			=> 'You <strong>can</strong> delete your images in this album',
	'ALBUM_DELETE_CANNOT'		=> 'You <strong>cannot</strong> delete your images in this album',
	'ALBUM_EDIT_CAN'			=> 'You <strong>can</strong> edit your images in this album',
	'ALBUM_EDIT_CANNOT'			=> 'You <strong>cannot</strong> edit your images in this album',
	'ALBUM_RATE_CAN'			=> 'You <strong>can</strong> rate images in this album',
	'ALBUM_RATE_CANNOT'			=> 'You <strong>cannot</strong> rate images in this album',
	'ALBUM_UPLOAD_CAN'			=> 'You <strong>can</strong> upload new images in this album',
	'ALBUM_UPLOAD_CANNOT'		=> 'You <strong>cannot</strong> upload new images in this album',
	'ALBUM_VIEW_CAN'			=> 'You <strong>can</strong> view images in this album',
	'ALBUM_VIEW_CANNOT'			=> 'You <strong>cannot</strong> view images in this album',

	'BAD_UPLOAD_FILE_SIZE'			=> 'Your uploaded file is too large',
	'BBCODES'						=> 'BBCodes',
	'BROWSING_ALBUM'				=> 'Users browsing this album: %1$s',
	'BROWSING_ALBUM_GUEST'			=> 'Users browsing this album: %1$s and %2$d guest',
	'BROWSING_ALBUM_GUESTS'			=> 'Users browsing this album: %1$s and %2$d guests',

	'CHANGE_AUTHOR'					=> 'Change author',
	'CHANGE_IMAGE_STATUS'			=> 'Change image-status',
	'CHARACTERS'					=> 'characters',
	'CLICK_RETURN_ALBUM'			=> 'Click %shere%s to return to the album',
	'CLICK_RETURN_IMAGE'			=> 'Click %shere%s to return to the image',
	'CLICK_RETURN_INDEX'			=> 'Click %shere%s to return to the index',
	'COMMENT'						=> 'Comment',
	'COMMENT_IMAGE'					=> 'Posting a comment on an image in album %s',
	'COMMENT_LENGTH'				=> 'Enter your comment here, it may contain no more than <strong>%d</strong> characters.',
	'COMMENT_ON'					=> 'Comment on',
	'COMMENT_STORED'				=> 'Your comment has been saved successfully.',
	'COMMENT_TOO_LONG'				=> 'Your comment is too long.',
	'COMMENTS'						=> 'Comments',
	'CONTEST_COMMENTS_STARTS'		=> 'Comments on images in this contest are allowed from %s on.',
	'CONTEST_ENDED'					=> 'This contest ended on %s.',
	'CONTEST_ENDS'					=> 'This contest ends on %s.',
	'CONTEST_RATING_STARTED'		=> 'The rating for this contest started on %s.',
	'CONTEST_RATING_STARTS'			=> 'The rating for this contest starts on %s.',
	'CONTEST_RATING_ENDED'			=> 'The rating for this contest ended on %s.',
	'CONTEST_RATING_HIDDEN'			=> 'hidden',
	'CONTEST_RESULT'				=> 'Contest',
	'CONTEST_RESULT_1'				=> 'Winner',
	'CONTEST_RESULT_2'				=> 'Second',
	'CONTEST_RESULT_3'				=> 'Third',
	'CONTEST_RESULT_HIDDEN'			=> 'The rating for this images is hidden, until the end of the contest on %s.',
	'CONTEST_STARTED'				=> 'The contest started on %s.',
	'CONTEST_STARTS'				=> 'The contest starts on %s.',
	'CONTEST_USERNAME'				=> '<strong>Contest</strong>',
	'CONTEST_USERNAME_LONG'			=> '<strong>Contest</strong> » The username is hidden, until the end of the contest on %s.',
	'CONTEST_IMAGE_DESC'			=> '<strong>Contest</strong> » The image-description is hidden, until the end of the contest on %s.',
	'CONTEST_WINNERS_OF'			=> 'Contest winner of “%s“',
	'CONTINUE'						=> 'Continue',

	'DATABASE_NOT_UPTODATE'			=> 'Your database is not the same version as your files. Please update your database.',
	'DELETE_COMMENT'				=> 'Delete comment',
	'DELETE_COMMENT2'				=> 'Delete comment?',
	'DELETE_COMMENT2_CONFIRM'		=> 'Are you sure you want to delete the comment?',
	'DELETE_IMAGE'					=> 'Delete',
	'DELETE_IMAGE2'					=> 'Delete image?',
	'DELETE_IMAGE2_CONFIRM'			=> 'Are you sure you want to delete the image?',
	'DELETED_COMMENT'				=> 'Comment deleted',
	'DELETED_COMMENT_NOT'			=> 'Comment not deleted',
	'DELETED_IMAGE'					=> 'Image deleted',
	'DELETED_IMAGE_NOT'				=> 'Image not deleted',
	'DESC_TOO_LONG'					=> 'Your description is too long',
	'DESCRIPTION_LENGTH'			=> 'Enter your descriptions here, it may contain no more than <strong>%d</strong> characters.',
	'DETAILS'						=> 'Details',
	'DONT_RATE_IMAGE'				=> 'Don’t rate image',

	'EDIT_COMMENT'					=> 'Edit comment',
	'EDIT_IMAGE'					=> 'Edit',
	'EDITED_TIME_TOTAL'				=> 'Last edited by %s on %s; edited %d time in total',
	'EDITED_TIMES_TOTAL'			=> 'Last edited by %s on %s; edited %d times in total',

	'FILE'							=> 'File',
	'FILE_SIZE'						=> 'File size',
	'FILETYPE_MIMETYPE_MISMATCH'	=> 'The file-type of “<strong>%1$s</strong>“ does not match the mime-type (%2$s).',
	'FILETYPES_GIF'					=> 'gif',
	'FILETYPES_JPG'					=> 'jpg',
	'FILETYPES_PNG'					=> 'png',
	'FILETYPES_ZIP'					=> 'zip',

	'GALLERY_IMAGE'					=> 'Image',
	'GALLERY_IMAGES'					=> 'Images',
	'GALLERY_VIEWS'					=> 'Views',

	'IGNORE_NOTUPTODATE_MESSAGE'		=> 'Remind me in 7 days',
	'IMAGE_ALREADY_REPORTED'			=> 'The image was already reported.',
	'IMAGE_BBCODE'						=> 'Image BBCode',
	'IMAGE_COMMENTS_DISABLED'			=> 'Comments are disabled for this image.',
	'IMAGE_DAY'							=> '%.2f images per day',
	'IMAGE_DESC'						=> 'Image Description',
	'IMAGE_HEIGHT'						=> 'Image height',
	'IMAGE_INSERTED'					=> 'Image inserted',
	'IMAGE_LOCKED'						=> 'Sorry, this image is locked. You cannot post comments for this image anymore.',
	'IMAGE_NAME'						=> 'Imagename',
	'IMAGE_NOT_EXIST'					=> 'This image does not exist.',
	'IMAGE_PCT'							=> '%.2f%% of all images',
	'IMAGE_STATUS'						=> 'Status',
	'IMAGE_URL'							=> 'Image-URL',
	'IMAGE_WIDTH'						=> 'Image width',
	'IMAGES_REPORTED_SUCCESSFULLY'		=> 'The image was successful reported',
	'IMAGES_UPDATED_SUCCESSFULLY'		=> 'Your image information has been updated successfully',
	'INSERT_IMAGE_POST'					=> 'Insert image into post',
	'INVALID_USERNAME'					=> 'Your Username is invalid',

	'LAST_COMMENT'					=> 'Last Comment',
	'LAST_IMAGE'					=> 'Last Image',
	'LOGIN_EXPLAIN_UPLOAD'			=> 'You must registered and logged in to upload images into this gallery.',

	'MARK_ALBUMS_READ'				=> 'Mark albums read',
	'MAX_DIMENSIONS'				=> 'Maximum dimensions',
	'MAX_FILE_SIZE'					=> 'Maximum file size',
	'MAX_HEIGHT'					=> 'Maximum image height',
	'MAX_WIDTH'						=> 'Maximum image width',
	'MISSING_COMMENT'				=> 'No Message entered',
	'MISSING_IMAGE_NAME'			=> 'You must specify a name when editing an image.',
	'MISSING_MODE'					=> 'No mode selected',
	'MISSING_REPORT_REASON'			=> 'You need to mention a reason, to report an image.',
	'MISSING_SLIDESHOW_PLUGIN'		=> 'No slideshow-plugin found. Contact the board-administration.',
	'MISSING_SUBMODE'				=> 'No submode selected',
	'MISSING_USERNAME'				=> 'No Username entered',
	'MOVE_TO_ALBUM'					=> 'Move to album',
	'MOVE_TO_PERSONAL'				=> 'Move to personal album',
	'MOVE_TO_PERSONAL_MOD'			=> 'When you select this option, the image is moved into the personal album of the user. If the user does not have one yet, it is created automatically.',
	'MOVE_TO_PERSONAL_EXPLAIN'		=> 'When you select this option, the image is moved into your personal album. If you do not have one yet, it is created automatically.',

	'NEW_COMMENT'					=> 'New Comment',
	'NEW_IMAGES'					=> 'New images',
	'NEWEST_PGALLERY'				=> 'Our newest personal gallery %s',
	'NO_ALBUMS'						=> 'There are no albums in this gallery.',
	'NO_COMMENTS'					=> 'No comments yet',
	'NO_IMAGES'						=> 'No images',
	'NO_IMAGES_FOUND'				=> 'No images found.',
	'NO_NEW_IMAGES'					=> 'No new images',
	'NO_IMAGES_LONG'				=> 'There are no images in this album.',
	'NOT_ALLOWED_FILE_TYPE'			=> 'This file type is not allowed',
	'NOT_RATED'						=> 'not rated',

	'ORDER'							=> 'Order',
	'ORIG_FILENAME'					=> 'Take filename as imagename (the insert-field has no function)',
	'OUT_OF_RANGE_VALUE'			=> 'Value is out of range',
	'OWN_IMAGES'					=> 'Your Images',

	'PERCENT'						=> '%',
	'PERSONAL_ALBUMS'				=> 'Personal albums',
	'PIXELS'						=> 'pixels',
	'PLUGIN_CLASS_MISSING'			=> 'Gallery Plugin Error: Class “%s“ could not be found!',
	'POST_COMMENT'					=> 'Post a comment',
	'POST_COMMENT_RATE_IMAGE'		=> 'Post a comment and rate the image',
	'POSTER'						=> 'Poster',

	'QUOTA_REACHED'					=> 'The number of images you are allowed to upload has been reached.',
	'QUOTE_COMMENT'					=> 'Quote comment',

	'RANDOM_IMAGES'					=> 'Random images',
	'RATE_IMAGE'					=> 'Rate the image',
	'RATES_COUNT'					=> 'Number of ratings',
	'RATING'						=> 'Rating',
	'RATING_STRINGS'				=> array(
		0	=> 'not rated',
		1	=> '%2$s (1 rating)',
		2	=> '%2$s (%1$s ratings)',
	),
	'RATING_STRINGS_USER'			=> array(
		1	=> '%2$s (1 rating, your rating: %3$s)',
		2	=> '%2$s (%1$s ratings, your rating: %3$s)',
	),
	'RATING_SUCCESSFUL'				=> 'The image has been rated successfully.',
	'READ_REPORT'					=> 'Read report',
	'RECENT_COMMENTS'				=> 'Recent comments',
	'RECENT_IMAGES'					=> 'Recent Images',
	'REPORT_IMAGE'					=> 'Report image',
	'RETURN_ALBUM'					=> '%sReturn to the album last visited%s',
	'ROTATE_IMAGE'					=> 'Rotate image',
	'ROTATE_LEFT'					=> '90° left',
	'ROTATE_NONE'					=> 'none',
	'ROTATE_RIGHT'					=> '90° right',
	'ROTATE_UPSIDEDOWN'				=> '180° upside-down',

	'SEARCH_ALBUM'					=> 'Search this album…',
	'SEARCH_ALBUMS'					=> 'Search in albums',
	'SEARCH_ALBUMS_EXPLAIN'			=> 'Select the album or albums you wish to search in. Subalbums are searched automatically if you do not disable “search subalbums“ below.',
	'SEARCH_COMMENTS'				=> 'Comments only',
	'SEARCH_CONTEST'				=> 'Contest winners',
	'SEARCH_IMAGE_COMMENTS'			=> 'Imagenames, descriptions and comments',
	'SEARCH_IMAGE_VALUES'			=> 'Imagenames and descriptions only',
	'SEARCH_IMAGENAME'				=> 'Imagenames only',
	'SEARCH_RANDOM'					=> 'Random images',
	'SEARCH_RECENT'					=> 'Recent images',
	'SEARCH_RECENT_COMMENTS'		=> 'Recent comments',
	'SEARCH_SUBALBUMS'				=> 'Search subalbums',
	'SEARCH_TOPRATED'				=> 'Top rated images',
	'SEARCH_USER_IMAGES'			=> 'Search user’s images',
	'SEARCH_USER_IMAGES_OF'			=> 'Images of %s',
	'SELECT_ALBUM'					=> 'Select an album',
	'SHOW_PERSONAL_ALBUM_OF'		=> 'Show personal album of %s',
	'SLIDE_SHOW'					=> 'Slideshow',
	'SLIDE_SHOW_HIGHSLIDE'			=> 'To start the slideshow, click on one of the image-names and than click on the “play“-icon:',
	'SLIDE_SHOW_LYTEBOX'			=> 'To start the slideshow, click on one of the image-names:',
	'SLIDE_SHOW_SHADOWBOX'			=> 'To start the slideshow, click on one of the image-names:',
	'SORT_ASCENDING'				=> 'Ascending',
	'SORT_DEFAULT'					=> 'Default',
	'SORT_DESCENDING'				=> 'Descending',
	'STATUS'						=> 'Status',
	'SUBALBUMS'						=> 'Subalbums',
	'SUBALBUM'						=> 'Subalbum',

	'THUMBNAIL_SIZE'				=> 'Thumbnail size (pixels)',
	'TOTAL_COMMENTS_SPRINTF'		=> array(
		0	=> 'Total comments <strong>0</strong>',
		1	=> 'Total comments <strong>%d</strong>',
		2	=> 'Total comments <strong>%d</strong>',
	),
	'TOTAL_IMAGES'					=> 'Total images',
	'TOTAL_PEGAS_SHORT_SPRINTF'		=> array(
		0	=> '0 personal galleries',
		1	=> '%d personal gallery',
		2	=> '%d personal galleries',
	),
	'TOTAL_PEGAS_SPRINTF'		=> array(
		0	=> 'Total personal galleries <strong>0</strong>',
		1	=> 'Total personal galleries <strong>%d</strong>',
		2	=> 'Total personal galleries <strong>%d</strong>',
	),

	'UNLOCK_IMAGE'					=> 'Unlock image',
	'UNWATCH_ALBUM'					=> 'Unsubscribe album',
	'UNWATCH_IMAGE'					=> 'Unsubscribe image',
	'UNWATCH_PEGAS'					=> 'Do not subscribe to new personal galleries',
	'UNWATCHED_ALBUM'				=> 'You are no longer informed about new images in this album.',
	'UNWATCHED_ALBUMS'				=> 'You are no longer informed about new images in these albums.',
	'UNWATCHED_IMAGE'				=> 'You are no longer informed about new comments on this image.',
	'UNWATCHED_IMAGES'				=> 'You are no longer informed about new comments on these images.',
	'UNWATCHED_PEGAS'				=> 'You are no longer automatically subscribed to new personal galleries.',
	'UPLOAD_ERROR'					=> 'While uploading “%1$s“ the following error occurred:<br />&raquo; %2$s',
	'UPLOAD_IMAGE'					=> 'Upload Image',
	'UPLOAD_IMAGE_SIZE_TOO_BIG'		=> 'Your image dimension size is too large',
	'UPLOAD_NO_FILE'				=> 'You must enter your path and filename',
	'UPLOADED_BY_USER'				=> 'Uploaded by',
	'UPLOADED_ON_DATE'				=> 'Uploaded',
	'USE_SAME_NAME'					=> 'Use the same image name and description for all images.',
	'USE_NUM'						=> 'Add {NUM} for numbers. Start counting at:',
	'USER_REACHED_QUOTA'			=> array(
		0	=> 'You are not allowed to upload <strong>any</strong> images.<br />Please contact the administrator for more information.',
		1	=> 'You are not allowed to upload more than <strong>1</strong> image.<br />Please contact the administrator for more information.',
		2	=> 'You are not allowed to upload more than <strong>%s</strong> images.<br />Please contact the administrator for more information.',
	),
	'USER_REACHED_QUOTA_SHORT'		=> array(
		0	=> 'You are not allowed to upload <strong>any</strong> images.',
		1	=> 'You are not allowed to upload more than <strong>1</strong> image.',
		2	=> 'You are not allowed to upload more than <strong>%s</strong> images.',
	),
	'USERNAME_BEGINS_WITH'			=> 'Username begins with',
	'USERS_PERSONAL_ALBUMS'			=> 'Users Personal Albums',

	'VIEW_ALBUM'					=> 'View album',
	'VIEW_ALBUM_IMAGES'				=> array(
		1	=> '1 image',
		2	=> '%s images',
	),
	'VIEW_IMAGE'					=> 'View image',
	'VIEW_IMAGE_COMMENTS'			=> array(
		1	=> '1 comment',
		2	=> '%s comments',
	),
	'VIEW_LATEST_IMAGE'				=> 'View the latest image',
	'VIEW_SEARCH_RECENT'			=> 'View recent images',
	'VIEW_SEARCH_RANDOM'			=> 'View random images',
	'VIEW_SEARCH_COMMENTED'			=> 'View recent comments',
	'VIEW_SEARCH_CONTESTS'			=> 'View contest winners',
	'VIEW_SEARCH_TOPRATED'			=> 'View top rated images',
	'VIEW_SEARCH_SELF'				=> 'View your images',
	'VIEWING_ALBUM'					=> 'Viewing album %s',
	'VIEWING_IMAGE'					=> 'Viewing image in album %s',

	'WATCH_ALBUM'					=> 'Subscribe album',
	'WATCH_IMAGE'					=> 'Subscribe image',
	'WATCH_PEGAS'					=> 'Subscribe to new personal galleries',
	'WATCHING_ALBUM'				=> 'You are now informed about new images in this album.',
	'WATCHING_IMAGE'				=> 'You are now informed about new comments on this image.',
	'WATCHING_PEGAS'				=> 'You are now automatically subscribed to new personal galleries.',

	'YOUR_COMMENT'					=> 'Your comment',
	'YOUR_PERSONAL_ALBUM'			=> 'Your Personal Album',
	'YOUR_RATING'					=> 'Your rating',

	'IMAGES_MOVED'					=> array(
		1	=>	'Image moved',
		2	=> 	'%s images moved',
	),
));
