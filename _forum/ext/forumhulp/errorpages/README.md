# Error Pages

Error Pages displays safe, styled responses for exceptions raised by phpBB controller requests.

## Requirements

- phpBB 3.3.0 or later in the 3.x series
- PHP 7.2 or later

## Scope

This extension handles exceptions that reach phpBB's Symfony kernel. Errors generated directly by Apache, Nginx, PHP-FPM or another reverse proxy before phpBB starts require separate web-server `ErrorDocument` or equivalent configuration.

## Configuration

The options are available under **ACP > General > Board configuration > Board features**. Explanations may be disabled. Optional logging records only 5xx server errors to avoid filling the database with routine or automated 4xx requests.

## Credits

- Leinad4Mind — current extension developer
- John Peskens / ForumHulp.com — original developer

Licensed under the GNU General Public License, version 2 only.
