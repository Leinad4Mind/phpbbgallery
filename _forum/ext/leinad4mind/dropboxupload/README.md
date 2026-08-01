# Dropbox Upload for phpBB

Uploads verified backups produced by `leinad4mind/autodbbackup` to Dropbox.

## Requirements

- phpBB 3.3.x
- PHP 7.2 or newer
- `leinad4mind/autodbbackup` enabled
- A Dropbox app with the `files.content.write` scope

For unattended operation, configure an app key, app secret and OAuth refresh token. A legacy access token remains supported as a fallback. Stored credentials are never rendered back into the ACP form.

## Installation

Copy the extension to `ext/leinad4mind/dropboxupload`, enable Auto Database Backup first, then enable this extension from the ACP.

When transferring from `david63/dropboxupload`, disable the old extension before enabling this package. The migration preserves existing settings and moves legacy credentials out of phpBB's globally cached configuration.

## Security behavior

- Only canonical files inside phpBB's `store/` directory with the expected backup filename format can be uploaded.
- Uploads use Dropbox sessions in bounded 8 MiB chunks with TLS verification and redirects disabled.
- Failed uploads remain due for retry on the next backup and do not reset the frequency counter.
- Dropbox credentials are replace-only fields and are stored in `config_text`, not the global configuration cache.

## License

[GNU General Public License v2](https://opensource.org/licenses/GPL-2.0)
