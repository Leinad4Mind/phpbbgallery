# Changelog

All notable changes to the phpBB Gallery Contest add-on are documented in this file.

## [1.0.0] - Unreleased

### Added

- Created the independent Contest add-on package and its safe dependency lifecycle.
- Adopted the historical Gallery contest storage without copying or deleting existing data.
- Added the contest domain manager and the Gallery Core policy provider, including
  fail-closed privacy when the add-on is unavailable.
- Moved the switch for creating new contests from the Core configuration model
  to the Contest add-on's ACP integration.
