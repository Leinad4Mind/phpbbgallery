<?php
/**
*
* @package phpBB Gallery
* @version $Id$
* @copyright (c) 2007 nickvergessen nickvergessen@gmx.de http://www.flying-bits.org
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
 * This should be called Constants file
 * I'm going to use it for storing all constants and functions that return them
 * Naming convention (for functions should be classname_constant_name
 */

namespace phpbbgallery\core;

class block
{
	/**
	 * \phpbbgallery\core\album\album
	 *
	 * Constants defining some album properties
	 */
	public const PUBLIC_ALBUM = 0;

	public const TYPE_CAT = 0;
	public const TYPE_UPLOAD = 1;

	/**
	 * @deprecated 4.2.0 Contest album types are owned by phpbbgallery/contest.
	 * Retained as a persisted-value compatibility alias for third-party add-ons.
	 */
	public const TYPE_CONTEST = 2;

	public const ALBUM_OPEN = 0;
	public const ALBUM_LOCKED = 1;

	/**
	 * Get locked
	 */
	public function get_album_status_locked(): int
	{
		return self::ALBUM_LOCKED;
	}

	public static function get_album_public(): int
	{
		return self::PUBLIC_ALBUM;
	}

	public static function get_album_type_upload(): int
	{
		return self::TYPE_UPLOAD;
	}

	/**
	 * \phpbbgallery\core\image\image
	 *
	 * Constants defining some image properties
	 */
	/**
	 * Only visible for moderators.
	 */
	public const STATUS_UNAPPROVED = 0;

	/**
	 * Visible for everyone with the i_view-permissions
	 */
	public const STATUS_APPROVED = 1;

	/**
	 * Visible for everyone with the i_view-permissions, but only moderators can comment.
	 */
	public const STATUS_LOCKED = 2;

	/**
	 * Orphan files are only visible for their author, because they're not yet ready uploaded.
	 */
	public const STATUS_ORPHAN = 3;

	/**
	 * Hidden while a moderator reviews the author's deletion request.
	 */
	public const STATUS_DELETE_REQUESTED = 4;

	/**
	 * @deprecated 4.2.0 Contest states are owned by phpbbgallery/contest.
	 * Retained as a persisted-value compatibility alias for third-party add-ons.
	 */
	public const NO_CONTEST = 0;

	/**
	 * @deprecated 4.2.0 Contest states are owned by phpbbgallery/contest.
	 * Retained as a persisted-value compatibility alias for third-party add-ons.
	 */
	public const IN_CONTEST = 1;

	/**
	 * Functions for \phpbbgallery\core\image
	 */

	public function get_image_status_unapproved(): int
	{
		return self::STATUS_UNAPPROVED;
	}

	public function get_image_status_approved(): int
	{
		return self::STATUS_APPROVED;
	}

	public function get_image_status_locked(): int
	{
		return self::STATUS_LOCKED;
	}

	/**
	 * Return the orphan image status.
	 *
	 * @return int
	 */
	public function get_image_status_orphan(): int
	{
		return self::STATUS_ORPHAN;
	}

	public function get_image_status_delete_requested(): int
	{
		return self::STATUS_DELETE_REQUESTED;
	}

	/**
	 * Unspecified (to specify them)
	 */


	/**
	 * Modes that you want to display on the block.
	 */

	public const MODE_NONE = 0;
	public const MODE_RECENT = 1;
	public const MODE_RANDOM = 2;
	public const MODE_COMMENT = 4;

	/**
	 * Options which details of the images you want to view on the block.
	 */
	public const DISPLAY_NONE = 0;
	public const DISPLAY_ALBUMNAME = 1;
	public const DISPLAY_COMMENTS = 2;
	public const DISPLAY_IMAGENAME = 4;
	public const DISPLAY_IMAGETIME = 8;
	public const DISPLAY_IMAGEVIEWS = 16;
	public const DISPLAY_USERNAME = 32;
	public const DISPLAY_RATINGS = 64;
	public const DISPLAY_IP = 128;
}
