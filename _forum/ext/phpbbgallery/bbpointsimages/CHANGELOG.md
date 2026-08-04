# Changelog

All notable changes to the phpBB Gallery BBPoints Images add-on are documented in this file.

## [1.0.0] Unreleased

### Fixed

- Kept policy inheritance inside the same Gallery owner tree and excluded
  personal album trees from the public ACP hierarchy.
- Prevent contributor relations from surviving when an image is deleted while its contributor list is being saved.
- Remove per-album points rules when their Gallery album is deleted.
- Reconcile orphan contributor and album-rule rows after reactivation while preserving financial reward and purchase history.

### Added

- Added inherited contributor-assignment policies per album, editable together
  with reward and source-cost overrides in Gallery's album manager.
- Added a read-only public-album policy overview with direct/effective values,
  edit links and confirmed actions to enable, disable or globally inherit
  contributor assignment across every public album.
- Added an independent Gallery add-on requiring phpBB Gallery Core and SiteSplat BBPoints.
- Added inherited per-album upload-reward and source-cost policies with global fallbacks.
- Added dedicated storage for contributors, publication rewards, paid source access, source hashes and download counters.
- Added retry-safe rewards for uploaded, imported and approved images, exact-file duplicate protection and reward migration when authorship changes.
- Added an ACP policy editor with independent inherited upload rewards and source costs per album.
- Added an explicitly confirmed, paginated and resumable synchronization that rewards eligible historical images without duplicate credits.
- Added permanent, confirmation-protected original-source purchases with atomic author/contributor distributions and retry-safe access.
- Added per-image and per-purchase original download counters while keeping medium images and thumbnails free.
- Added optional contributor assignment during resumable uploads and image editing, using phpBB's multi-user finder and strict server-side validation.
- Added contributor attribution on image pages, cleanup on image deletion or author changes, and contest-privacy protection.
- Added independent UCP notification preferences for publication rewards and paid original-source income, emitted only for newly created BBPoints operations.
- Added an installed-phpBB functional workflow covering alternate authors, approval, ACP import, contributors, paid source access, notifications, historical synchronization and extension reactivation.
