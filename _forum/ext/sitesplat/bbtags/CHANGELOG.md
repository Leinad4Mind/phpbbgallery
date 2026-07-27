# BBTags changelog

## Unreleased

### Security

- Protect ACP tag updates, deletion and configuration changes with phpBB form tokens.
- Use typed identifiers, driver-built update queries and transactional tag deletion.
- Escape legacy tag values before rendering them in the ACP, tag blocks or metadata.

### Fixed

- Declare runtime properties used by the ACP module and event listener for PHP 8.2 and later.
- Replace the MySQL-only ACP tag aggregation query with portable SQL.
- Validate numeric ACP settings and normalize the predefined tag list before saving it.
- Replace topic tags atomically, skip empty bulk inserts and clean stale tags and counts after topic deletion.
- Enforce forum search, password and topic visibility boundaries on public tag results.
- Handle unknown tags and non-AJAX suggestion requests without undefined runtime state.

### Added

- Add a provider-independent canonical tag catalogue while preserving topic relations and retaining the oldest identifier when equivalent legacy tags are merged.
- Track enabled state and usage totals per provider, beginning with `forum_topics`.
- Import the existing predefined tag list into the catalogue and enforce canonical tag, route and topic relation uniqueness.
- Use the database catalogue as the authoritative predefined-tag and autocomplete source while retaining the legacy JSON as a downgrade fallback.
- Synchronize forum topic usage with its provider context and use the configured 64-character tag limit in the posting UI.

### Tests

- Add isolated PHPUnit coverage for ACP security contracts and administrative tag operations.
- Verify the English and Portuguese ACP language catalogues remain in sync.
- Cover catalogue schema ordering, data preservation, deduplication and provider seeding.
