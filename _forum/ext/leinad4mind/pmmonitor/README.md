# PM Monitor for phpBB

Provides an audited ACP view of private-message recipient copies and an optional, separately authorized deletion action.

## Requirements

- phpBB 3.3.x
- PHP 7.2 or newer

## Installation and transfer

When transferring from `david63/pmmonitor`, disable it and delete its extension data before enabling `leinad4mind/pmmonitor`. The old and new packages use different ACP module namespaces and permissions, and must not be installed concurrently.

Copy the package to `ext/leinad4mind/pmmonitor` and enable it in ACP Customise. Full administrators receive the view and delete permissions by default; the permissions can then be assigned independently.

## Privacy and security

- Every ACP view and deletion is recorded in the administrator log.
- Viewing and deleting use separate administrator permissions.
- Destructive requests require phpBB form-key and confirmation validation.
- Posted message identifiers are strictly parsed and revalidated against the database.
- Deletion updates only the exact recipient copies, folder counters, user counters, notifications, and orphaned message data affected by the request.

## License

[GNU General Public License v2](https://opensource.org/licenses/GPL-2.0)
