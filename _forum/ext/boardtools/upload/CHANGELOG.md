Upload Extensions - Changelog
=============================
This file contains the list of changes between different versions of Upload Extensions.

# Version 3.2.1
## Changes since 3.2.0
### Security
* [CODE] Fixed arbitrary file read via the `file` request parameter in the ACP file tree viewer (now restricted to paths inside `ext/`).
* [CODE] Fixed reflected XSS in the file tree viewer's filename output.
* [CODE] Fixed path traversal via the `local_upload` parameter (zip extraction source).
* [CODE] Fixed a bypassable `str_replace('../', '')` filter on the `download` action's `zip_name` parameter (replaced with `basename()`).
* [CODE] Fixed path traversal via the `archive` parameter in the language restore flow.
* [CODE] Fixed missing sanitization of `ext_name`/`lang_name` in the language upload flow (now matches the sanitization already used by the delete-language flow).
* [CODE] Hardened HTTP header construction in the file download helper against CRLF/path injection.

All of the above require the `acl_a_extensions` ACP permission to reach, same as installing an
extension outright - these are defense-in-depth fixes, not remotely exploitable vulnerabilities.

### Bug fixes
* [CODE] Removed an `add_form_key()` call whose token was rendered in the template but never verified by any `check_form_key()` call (dead/misleading CSRF token; the actual protection for that action is `confirm_box()`).
* [CODE] Removed unused `$host`/`$port` variables in the remote upload code path.

### Housekeeping
* [CODE] Raised the minimum PHP requirement to 7.4 (from 5.3.3).
* [CODE] Updated the vendored `michelf/php-markdown` library from 1.9.1 to 2.0.0 (requires PHP >=7.4), including its test suite.
* [CODE] Added a GitHub Actions CI workflow (PHP 7.4-8.3 matrix), replacing the lack of CI for the extension itself.

# Version 3.2.0
## Changes since 3.1.2
### Bug fixes
* Add support for phpBB 3.2.
* Fix update tooltip for mobile devices.
* Fix updating extensions with removed `ext.php`.
* Fix code selection functionality in file trees.
* Fix version check functionality.

# Version 3.1.2
## Changes since 3.1.2-RC2
### Bug fixes
* Add support for the new types of download links from the CDB on phpbb.com.
* JavaScript fixes and improvements.

## Changes since 3.1.2-RC1
### Bug fixes
* JavaScript fixes and improvements.

## Changes since 3.1.2-beta2
### New features
* [FEATURE] Extension's description and requirements can be shown for suggested extensions.
* [FEATURE] Full downloadable list of uploaded extensions.
* [FEATURE] Integration with browser's history.

### Improvements
* [LIST] List of suggested extensions is now taken directly from phpbb.com.
* [CODE] Errors are now shown in the special modal box.
* [DESIGN] Small design improvements: status icons and current file in file tree.

### Bug fixes
* JavaScript fixes and improvements.

## Changes since 3.1.2-beta
### New features
* [FEATURE] Language packages management page for each extension.
* [FEATURE] Uploads of language packages for extensions.
* [FEATURE] Integration with Upload Extensions Updater.

### Improvements
* [SECURITY] Checksums are now checked for uploaded zip packages.
* [ZIP] File dates and file sizes are now displayed on ZIP files management page.
* [INTERFACE] A link to reload pages by JavaScript.

### Bug fixes
* The received data for valid extensions is now sanitized.
* The list of suggested extensions from phpbb.com is now obtained from extension's repository.
* JavaScript fixes and improvements.

## Changes since 3.1.1
### New features
* [FEATURE] Full Ajax support.
* [FEATURE] Full noscript support.
* [FEATURE] Built-in Extensions Manager.
* [FEATURE] Loading status in JavaScript.
* [FEATURE] Navigation and menu bars.
* [FEATURE] Downloads of properly packaged extensions.
* [FEATURE] Built-in FAQ for Upload Extensions.
* [FEATURE] User-friendly status messages.

### Improvements
* [DETAILS] Now details page is a **separate section** that is not displayed in a small popup window.
* [DETAILS] Now **file tree** is showed on the details page and can be used even when JavaScript is disabled.
* [DETAILS] Now `Changelog.md` and `Readme.md` files can be viewed on details page.
* [ZIP] Now it is possible to delete **2 or more** zip packages at once.
* [CLEANER] Now it is possible to delete **2 or more** extensions at once.
* [CODE] The extension's code was restructured.
* [CODE] Proper error handling.

### Bug fixes
Already included in 3.1.1.

# Version 3.1.1

Initial stable release (changes can be found in the commits of our [repository on GitHub](https://github.com/BoardTools/upload)).

© 2014 - 2019 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)