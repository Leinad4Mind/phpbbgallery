# Dropbox Upload for phpBB

Uploads verified backups produced by `david63/autodbbackup` to Dropbox.

## Requirements

- phpBB 3.3.x
- PHP 7.2 or newer
- `david63/autodbbackup` enabled
- A Dropbox app with the `files.content.write` scope

For unattended operation, configure an app key, app secret and OAuth refresh token. A legacy access token remains supported as a fallback. Stored credentials are never rendered back into the ACP form.

## Installation

Copy the extension to `ext/david63/dropboxupload`, enable Auto Database Backup first, then enable this extension from the ACP.

Existing `david63/dropboxupload` installations remain the same package. Use phpBB's normal update cycle: disable the extension without deleting its data, replace the files, and enable it again. No vendor transfer or data purge is required. On re-enable, the 3.3 migration preserves existing settings and moves legacy credentials out of phpBB's globally cached configuration.

## Security behavior

- Only canonical files inside phpBB's `store/` directory with the expected backup filename format can be uploaded.
- Uploads use Dropbox sessions in bounded 8 MiB chunks with TLS verification and redirects disabled.
- Failed uploads remain due for retry on the next backup and do not reset the frequency counter.
- Dropbox credentials are replace-only fields and are stored in `config_text`, not the global configuration cache.

## License

[GNU General Public License v2](https://opensource.org/licenses/GPL-2.0)
