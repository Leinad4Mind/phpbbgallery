# PM Monitor for phpBB

Provides an audited ACP view of private-message recipient copies and an optional, separately authorized deletion action.

## Requirements

- phpBB 3.3.x
- PHP 7.2 or newer

## Installation and updates

Copy the package to `ext/david63/pmmonitor` and enable it in ACP Customise. Existing `david63/pmmonitor` installations remain the same package. Use phpBB's normal update cycle: disable the extension without deleting its data, replace the files, and enable it again. No vendor transfer or data purge is required. On re-enable, the 3.3 migration continues the original migration chain and grants the new independent view and delete permissions to Full Administrators.

## Privacy and security

- Every ACP view and deletion is recorded in the administrator log.
- Viewing and deleting use separate administrator permissions.
- Destructive requests require phpBB form-key and confirmation validation.
- Posted message identifiers are strictly parsed and revalidated against the database.
- Deletion updates only the exact recipient copies, folder counters, user counters, notifications, and orphaned message data affected by the request.

## License

[GNU General Public License v2](https://opensource.org/licenses/GPL-2.0)
