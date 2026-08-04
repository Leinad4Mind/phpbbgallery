# Changelog

All notable changes to the phpBB Gallery Image Revisions add-on are documented in this file.

## [1.0.0] Unreleased

### Added

- Added independent per-album and subalbum overrides for enabling revisions and
  selecting the retained revision limit, with nearest-parent and global
  inheritance.
- Added revision settings to Gallery album management and a read-only ACP
  hierarchy with direct, inherited and effective values plus edit links.
- Added automatic cleanup of album-policy rows after album deletion or add-on
  reactivation.
- Added unit and authenticated functional coverage for policy inheritance,
  creation, editing, overview rendering and lifecycle reconciliation.
