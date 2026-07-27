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

### Changed

- Replace the standalone `imagetags` prototype and its duplicate tag catalogue with the `bbtagsbridge` integration addon.

### Tests

- Cover provider registration, dependency enforcement, input limits, album inheritance, policy classification, idempotent relations, usage totals, lifecycle integration, deletion cleanup, style contracts and locale parity.
