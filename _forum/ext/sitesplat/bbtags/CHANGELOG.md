# BBTags changelog

## Unreleased

### Security

- Protect ACP tag updates, deletion and configuration changes with phpBB form tokens.
- Use typed identifiers, driver-built update queries and transactional tag deletion.
- Escape legacy tag values before rendering them in the ACP, tag blocks or metadata.

### Fixed

- Allow content providers to remove explicit scope rules when their underlying scopes are deleted.
- Declare runtime properties used by the ACP module and event listener for PHP 8.2 and later.
- Replace the MySQL-only ACP tag aggregation query with portable SQL.
- Validate numeric ACP settings and normalize the predefined tag list before saving it.
- Replace topic tags atomically, skip empty bulk inserts and clean stale tags and counts after topic deletion.
- Enforce forum search, password and topic visibility boundaries on public tag results.
- Handle unknown tags and non-AJAX suggestion requests without undefined runtime state.
- Make the 1.2.0 catalogue upgrade discoverable, avoid the reserved MariaDB index name “usage” and repair interrupted upgrades before runtime queries resume.
- Let OpenGraph resolve the public BBTags service without depending on its constructor signature.

### Added

- Add provider-independent tag suggestions with pending, approved, rejected and cancelled audit states.
- Route unknown user-submitted topic tags to a resumable moderation queue instead of publishing them immediately.
- Add a CSRF-protected MCP queue governed by the global `m_bbtags_moderate` permission; keep moderation out of the ACP.
- Apply approved suggestions atomically to their originating provider item and restrict new tags to the approved scope.
- Expose a tagged provider interface and registry so integrations can join validation, moderation, linking and approval without coupling BBTags to their content model.
- Add a provider-independent canonical tag catalogue while preserving topic relations and retaining the oldest identifier when equivalent legacy tags are merged.
- Track enabled state and usage totals per provider, beginning with `forum_topics`.
- Import the existing predefined tag list into the catalogue and enforce canonical tag, route and topic relation uniqueness.
- Use the database catalogue as the authoritative predefined-tag and autocomplete source while retaining the legacy JSON as a downgrade fallback.
- Synchronize forum topic usage with its provider context and use the configured 64-character tag limit in the posting UI.
- Add reusable global/restricted provider scopes with nearest-ancestor allow, deny and inherit rules.
- Restrict forum autocomplete and saved topic tags to the effective rule of the current forum hierarchy.
- Add multi-tag topic search with explicit AND/OR matching and per-tag forum scope enforcement.
- Classify submitted provider tags as available, suggestible or blocked so explicit denials cannot be bypassed through moderation.
- Expose generic provider tag discovery and effective-scope resolution for content integrations.
- Expose atomic provider-policy administration over the shared catalogue and inherited scope rules.
- Edit forum_topics availability in the ACP with global or restricted defaults and inherited allow or deny rules across the forum tree.

### Tests

- Cover suggestion deduplication, provider validation, approval rollback, rejection audit history, MCP placement and permissions across PHP 8.1 through 8.5.
- Add isolated PHPUnit coverage for ACP security contracts and administrative tag operations.
- Verify the English and Portuguese ACP language catalogues remain in sync.
- Cover catalogue schema ordering, data preservation, deduplication and provider seeding.
- Cover interrupted catalogue upgrades and runtime behavior while migrations are pending.
- Exercise Gallery-provider suggestions through the authenticated MCP approval form in the phpBB functional environment.
