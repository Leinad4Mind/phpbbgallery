# User Defaults

User Defaults lets administrators choose validated preference and notification defaults for newly created phpBB users. Existing users are not changed.

## Requirements

- phpBB 3.3.x
- PHP 7.2 or newer

## Transfer from the original package

The vendor and migration namespace changed. Disable `david63/userdefaults`, delete its extension data, remove the old files, and then enable `leinad4mind/userdefaults`. Do not enable both packages at the same time.

This repository also contains a separate `devspace/userdefaults` package with the same purpose and shared `ud_*` configuration keys. Do not enable that package alongside this one.

Deleting the original extension data removes its saved defaults. Record any non-standard choices before the transfer and apply them again in the new ACP page.

## Security and behaviour

- The ACP page requires phpBB's user-administration permission.
- Every save requires a valid phpBB form key and is written to the administrator log.
- Boolean, date-format, sorting, and display-option values are validated before storage.
- Explicit notification choices supplied by another user-creation workflow are preserved.
- Automated ignored users, including bots, retain phpBB's own defaults.

The package version is maintained only in `composer.json`.
