# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.2] - 2026-07-18

### Security
- Fixed SQL injection vulnerability in UCP search by username (parameter escaped with `sql_escape()`)

### Fixed
- Fixed ACP "Allow search" toggle not enabling (copy-paste bug: tested wrong variable)
- Fixed `continue` statement in switch without enclosing loop (now `break`, eliminates PHP 7.3+ warning)
- Reverted incorrect `+1` pagination hack from 4 COUNT queries (verified against phpBB core as misdiagnosis, was inflating result counts and masking zero-result queries)
- Fixed malformed HTML in ACP template (unclosed `<p>` and incorrect form closing tag)

### Changed
- Migration now properly reverts schema (uncommented `revert_schema()` for clean uninstall)
- Extended PHP constraint from `>=5.4` to `>=5.4,<9.0` for explicit PHP 8.x support

### Removed
- Removed dead service definition (`anavaro.pmsearch.fulltext_native` pointing to non-existent class)

### Added
- Declared all dynamic properties in `helper.php` and `main_listener.php` (PHP 8.2+ compatibility)
- Added missing language key `SEARCH_USR_PLACEHOLDER` to all 7 language files (en, bg, fr, pt, pt_br, pt_preao, sv)
- Added Leinad4Mind as Contributor in metadata

## [1.0.1] - Unknown

### Added
- Added language keys `SEARCH_FOR_NICK`, `SEARCH_WITH_USER`, `SEARCH_WITH_USER_LANG`

## [1.0.0] - 2019-08-01

### Initial Release
- PM search functionality with fulltext indexing
- ACP interface for managing search settings
- UCP interface for searching private messages
- Support for phpBB 3.2+
