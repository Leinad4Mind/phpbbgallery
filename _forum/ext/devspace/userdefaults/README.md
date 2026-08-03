# User Defaults

User Defaults lets administrators choose validated preference and notification defaults for newly created phpBB users. Existing users are not changed.

## Requirements

- phpBB 3.3.x
- PHP 7.2 or newer

## Installation and updates

Copy the package to `ext/devspace/userdefaults` and enable it in ACP Customise. Existing `devspace/userdefaults` installations remain the same package. Use phpBB's normal update cycle: disable the extension without deleting its data, replace the files, and enable it again. No vendor transfer or data purge is required. The migration chain retains the original vendor namespace and preserves the saved defaults used by the current extension.

The legacy `david63/userdefaults` package uses the same `ud_*` configuration keys. Do not enable both vendor packages at the same time.

## Security and behaviour

- The ACP page requires phpBB's user-administration permission.
- Every save requires a valid phpBB form key and is written to the administrator log.
- Boolean, date-format, sorting, and display-option values are validated before storage.
- Explicit notification choices supplied by another user-creation workflow are preserved.
- Automated ignored users, including bots, retain phpBB's own defaults.

The package version is maintained only in `composer.json`.
