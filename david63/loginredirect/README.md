# Login Redirect for phpBB

Redirects users after a successful login to an authorized welcome, announcement, or group topic.

## Requirements

- phpBB 3.3.x
- PHP 7.2 or newer

## Installation and updates

Copy the extension to `ext/david63/loginredirect` and enable it in the ACP. Existing `david63/loginredirect` installations remain the same package. Use phpBB's normal update cycle: disable the extension without deleting its data, replace the files, and enable it again. No vendor transfer or data purge is required. On re-enable, the 3.3 migration copies legacy settings to extension-prefixed configuration keys and removes the old generic keys.

## Security behavior

- ACP logins and banned non-founder sessions are never intercepted.
- Only approved topics readable by the authenticated user can become redirect targets.
- Pending group memberships do not qualify for group redirects.
- Missing or deleted topics fall back to phpBB's normal login redirect instead of causing an error.
- The listener changes the official `core.login_box_redirect` value without terminating unrelated listeners.

## License

[GNU General Public License v2](https://opensource.org/licenses/GPL-2.0)
