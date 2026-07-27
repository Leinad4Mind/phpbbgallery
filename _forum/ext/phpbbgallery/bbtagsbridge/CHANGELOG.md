# Changelog

## [Unreleased]

### Added

- Register Gallery images through the shared `sitesplat.bbtags.provider` contract.
- Store only normalized image-to-catalogue relations and provider-specific usage totals.
- Automatically enable the Gallery Core and BBTags dependencies when they are available.
- Remove image relations when their Gallery images are deleted.

### Changed

- Replace the standalone `imagetags` prototype and its duplicate tag catalogue with the `bbtagsbridge` integration addon.

### Tests

- Cover provider registration, dependency enforcement, idempotent relations, usage totals, deletion cleanup and locale parity.
