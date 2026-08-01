# Login Redirect for phpBB

Redirects users after a successful login to an authorized welcome, announcement, or group topic.

## Requirements

- phpBB 3.3.x
- PHP 7.2 or newer

## Installation and transfer

Copy the extension to `ext/leinad4mind/loginredirect` and enable it in the ACP. When transferring from `david63/loginredirect`, disable the old extension before enabling this package. The migration copies existing settings to extension-prefixed configuration keys and removes the legacy generic keys.

## Security behavior

- ACP logins and banned non-founder sessions are never intercepted.
- Only approved topics readable by the authenticated user can become redirect targets.
- Pending group memberships do not qualify for group redirects.
- Missing or deleted topics fall back to phpBB's normal login redirect instead of causing an error.
- The listener changes the official `core.login_box_redirect` value without terminating unrelated listeners.

## License

[GNU General Public License v2](https://opensource.org/licenses/GPL-2.0)
