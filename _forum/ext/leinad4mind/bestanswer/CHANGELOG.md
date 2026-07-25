# Changelog

All notable changes to the Best Answer Special Edition extension are documented in this file.

## Unreleased

### Planned

- Search topics a user has answered.

## [2.3.0] - 2026-07-25

### Fixed

- Fixed a bug where soft-deleting *any* post in a topic — not just the post marked as the answer — cleared the topic's Best Answer marker, caused by an accidental assignment (`=`) instead of a comparison (`==`).
- Fixed undefined variables and a non-existent log language key that fired on every batch post deletion in a topic with a best answer.
- Fixed `user_answers` counter underflow: decrements are now guarded so the counter can never go below 0, which previously caused a MySQL strict-mode error (1690) under phpBB 3.3.
- Fixed a `<div>` left unclosed on the MCP topic-review page (BBOOTS, FLATBOOTS, prosilver), caused by a template event that doesn't exist in phpBB core.
- Fixed the mark/unmark controller not returning a proper `Response` object, which fails under phpBB 3.3's Symfony HttpKernel.
- Fixed BBPoints SQL using double-quoted string literals, which PostgreSQL parses as identifiers rather than strings.
- Fixed a missing-topic check so an invalid post id now returns a clean 404 instead of PHP 8 warnings.
- Fixed a batch-delete query that could include users with no recorded answer.
- Fixed the answer count only decrementing by 1 for users who lost more than one best answer in the same deletion batch.
- Fixed dead/always-true logic in the forum list "answered" indicator.
- Fixed duplicate `jxtools.js` `<script>` inclusion on pages rendering many posts.
- Fixed a duplicate DOM id repeated on every row of search results.
- Fixed an "Answers: 0" display bug caused by a loose comparison instead of a truthy check.
- Fixed legacy (non-Twig) template syntax in the ACP forum settings page.
- Fixed email template paths in notification classes to use forward slashes.
- Normalized all line endings in the extension to LF, per phpBB's coding guidelines.

### Changed

- Made the BBPoints integration fully optional: the extension no longer hard-depends on `sitesplat/bbpoints`, so disabling that extension no longer breaks the whole forum. See "Optional BBPoints integration" in the README.
- Soft-deleting the post marked as the best answer now also reverts its BBPoints, matching the existing behavior on permanent deletion.
- Raised minimum requirements to phpBB 3.3.0 and PHP 7.1.3.

## [2.1.0] - 2025-08-16

### Added

- Added Portuguese (Brazil) language.
- Added Nightstalker dark-mode support to the prosilver style.

### Changed

- Improved error messages and language variables.
- Improved PHP 8 compatibility.
- Prevented SQL query issues when the answer table alias collided with the site's table prefix.

### Fixed

- Fixed the user IP recorded in mark/unmark answer log entries.

## [2.0.2] - 2021-01-30

### Added

- Added Arabic language.
- Added French language.
- Added Russian language.

### Changed

- Refactored code to stay up to date with the official [kinerity/bestanswer](https://www.phpbb.com/community/viewtopic.php?t=2368876) 1.0.2.
