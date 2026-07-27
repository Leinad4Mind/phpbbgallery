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

### Tests

- Add isolated PHPUnit coverage for ACP security contracts and administrative tag operations.
- Verify the English and Portuguese ACP language catalogues remain in sync.
