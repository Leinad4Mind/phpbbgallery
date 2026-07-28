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

### Changed

- Replace the standalone `imagetags` prototype and its duplicate tag catalogue with the `bbtagsbridge` integration addon.

### Tests

- Cover provider registration, dependency enforcement, input limits, album inheritance, policy classification, AND/OR SQL, permission-aware facets, idempotent relations, usage totals, lifecycle integration, deletion cleanup, style contracts and locale parity.
