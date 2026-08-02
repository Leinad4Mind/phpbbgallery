# Changelog

## [Unreleased]

### Added

- Register Gallery images through the shared `sitesplat.bbtags.provider` contract.
- Store only normalized image-to-catalogue relations and provider-specific usage totals.
- Automatically enable the Gallery Core and BBTags dependencies when they are available.
- Remove image relations when their Gallery images are deleted.
- Add tags to the resumable upload review, image editor and image details in all supported styles.
- Inherit allow, deny and restricted tag policies through the Gallery album hierarchy.
- Send new user tags to the BBTags moderator queue while letting authorized moderators assign them directly.
- Add permission-aware multi-tag Gallery search with explicit AND/OR matching and pagination-safe filters.
- Link displayed image tags to search and expose additional tags from the complete visible result set as narrowing facets.
- Add an AJAX autocomplete endpoint restricted to tags available in albums the current user can view.
- Add a CSRF-protected ACP policy editor for enabling shared tags and defining inherited allow or deny rules per album.

### Changed

- Replace the standalone `imagetags` prototype and its duplicate tag catalogue with the `bbtagsimages` integration addon.
- Rename the provisional `phpbbgallery/bbtagsbridge` package to `phpbbgallery/bbtagsimages` throughout its namespace, routes, services, templates and language catalogues.
- Require the BBTags catalogue-readiness migration and adopt an existing image-tag relation table without deleting its data.
- Replace the legacy ACP module entry during the package-name transition.

### Fixed

- Render the Gallery album hierarchy marker as a valid Unicode em dash instead of corrupted text.
- Remove newly written tag relations if their image is deleted during the same request.
- Remove inherited tag-policy rules when their Gallery album is deleted.
- Reconcile orphan image relations, pending suggestions and album scopes after the addon is re-enabled.

### Tests

- Cover provider registration, dependency enforcement, input limits, album inheritance, administrative policy persistence, policy classification, AND/OR SQL, permission-aware facets, idempotent relations, usage totals, lifecycle integration, deletion cleanup, style contracts and locale parity.
- Exercise an authenticated phpBB workflow through the real upload review, MCP approval, Gallery search and image-deletion forms.
