# Upload Image

Upload Image lets authorised administrators upload, list, search, copy paths for, and delete GIF, JPEG, and PNG files in a dedicated directory under the board's `images/` folder.

## Requirements

- phpBB 3.3.12 or newer (before phpBB 4.0)
- PHP 8.1 or newer
- `forumhulp/helper` installed and enabled

## Installation

1. Copy the extension to `ext/forumhulp/uploadimage/`.
2. In the ACP, open **Customise → Manage extensions**.
3. Enable **Upload Image**.
4. Open **Customise → Upload Image**.

The default upload directory is `images/ui/`; it is created when the management page is first opened. Folder names may contain ASCII letters, numbers, underscores, and hyphens. Existing files are never overwritten.

## Security behaviour

- Upload, queued-file deletion, and folder rename requests require a valid phpBB form token.
- Only GIF, JPEG, and PNG filenames are accepted, and file contents must match the extension.
- File deletion is restricted to regular, non-symlink files directly inside the configured upload directory.
- The upload limit is the lowest active limit from PHP and the phpBB attachment configuration.

Deleting an image does not check whether posts or templates still reference it, so review usage before confirming deletion.

## Updating and removal

Disable the extension before replacing its files, then enable it again. To remove it permanently, disable it, choose **Delete data**, and then remove `ext/forumhulp/uploadimage/`.

## License

[GNU General Public License v2](https://opensource.org/license/gpl-2-0)
