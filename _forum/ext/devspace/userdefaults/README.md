# User Defaults

User Defaults lets administrators choose validated preference and notification defaults for newly created phpBB users. Existing users are changed only when an administrator explicitly confirms the synchronization tool.

## Requirements

- phpBB 3.3.x
- PHP 7.2 or newer

## Installation and updates

Copy the package to `ext/devspace/userdefaults` and enable it in ACP Customise. Existing `devspace/userdefaults` installations remain the same package. Use phpBB's normal update cycle: disable the extension without deleting its data, replace the files, and enable it again. No vendor transfer or data purge is required. The migration chain retains the original vendor namespace and preserves the saved defaults used by the current extension.

The legacy `david63/userdefaults` package uses the same `ud_*` configuration keys. Do not enable both vendor packages at the same time.

`forumhulp/userdefault` also modifies the user-creation event. Do not enable it alongside this package because listener order would make the resulting defaults unpredictable.

## Security and behaviour

- The ACP page requires phpBB's user-administration permission.
- Every save requires a valid phpBB form key and is written to the administrator log.
- Boolean, date-format, notification-method, sorting, and display-option values are validated before storage.
- Available notification types and methods are discovered dynamically and stored by stable names rather than database IDs.
- Explicit notification choices supplied by another user-creation workflow are preserved.
- Automated ignored users, including bots, retain phpBB's own defaults.
- Existing-user synchronization is POST-only, form-key protected, logged, processed in resumable ID-based batches, and limited to normal users and founders.

The package version is maintained only in `composer.json`.
