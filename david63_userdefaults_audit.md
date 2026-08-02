# Security, Reliability, Bug, and Optimization Audit

**Target:** `_forum/ext/david63/userdefaults`
**Original package:** `david63/userdefaults` `3.2.0-RC1`
**Remediated package:** `david63/userdefaults` `3.3.0`
**Local phpBB version:** `3.3.12`
**Audit date:** 2026-08-02

## Executive summary

User Defaults changes the database values and email-notification subscriptions assigned to every newly created user. The original package protected the ACP form with a phpBB form key, but accepted arbitrary date and sorting values, overwrote notification choices supplied by other user-creation workflows, also changed ignored users such as bots, and performed an unencrypted remote version probe whenever its ACP page opened. Its ACP module did not pass the page URL to the controller, its schema-default query was specific to MySQL, and its service configuration made every autowired service public while defining broad core aliases.

The package retains the technical identity `david63/userdefaults`, while active development and maintainership have transferred to Leinad4Mind. It was rebuilt around an extension-owned validation policy. The listener now consumes defensively normalized configuration, preserves explicit notification data, skips ignored users, and uses the documented `core.user_add_modify_data` event arguments. phpBB lists `user_row`, `sql_ary`, and `notifications_data` as supported arguments for this event: [phpBB 3.3 events list](https://area51.phpbb.com/docs/dev/3.3.x/extensions/events_list.html).

## Findings and remediation

| ID | Severity | Finding | Status |
|---|---|---|---|
| UDF-001 | Medium | Date format, sorting direction, sorting key, and day limits were stored without allow-list validation | Resolved |
| UDF-002 | Medium | The listener replaced notification data explicitly supplied by another user-creation workflow | Resolved |
| UDF-003 | Medium | Defaults were also applied to ignored users such as bots | Resolved |
| UDF-004 | Medium | Opening the ACP performed a suppressed unencrypted HTTP request to a third-party version server | Resolved |
| UDF-005 | Medium | The ACP module never passed its action URL to the controller, leaving form and return URLs empty | Resolved |
| UDF-006 | Medium | `SELECT DEFAULT(column)` made the ACP page dependent on MySQL-specific SQL | Resolved |
| UDF-007 | Medium | A migration filename contained a space before `.php`, and migration state was split across obsolete namespaces | Resolved |
| UDF-008 | Medium | Blanket public autowiring and aliases for many phpBB core classes increased collision and exposure risk | Resolved |
| UDF-009 | Low | Every save rewrote every configuration row, including unchanged values | Resolved |
| UDF-010 | Low | Version metadata was recursively scanned and rendered separately from Composer metadata | Resolved |
| UDF-011 | Low | Two unused configuration keys and dead timezone/version helper code remained | Resolved |
| UDF-012 | Low | Select controls were generated as controller-owned HTML rather than structured template data | Resolved |
| UDF-013 | Low | Numerous labels targeted nonexistent control IDs, and the PM notification field had the wrong label | Resolved |
| UDF-014 | Low | A large copied ACP stylesheet, malformed funding form, JavaScript toggle, and QR image remained | Resolved |
| UDF-015 | Low | No extension-owned regression, language, listener, or package tests existed | Resolved |

## Security and correctness changes

- All boolean values are normalized to `0` or `1`.
- Date formats must exactly match phpBB's language-provided format list before storage.
- Topic/post sort direction, keys, and day limits use fixed allow-lists. Stored values are normalized again before user creation to tolerate damaged or manually edited configuration.
- Existing unmanaged `user_options` bits are preserved while the nine managed display/posting bits are updated.
- Explicit non-null `notifications_data` is never overwritten. Defaults are generated only when the caller left the value unset.
- Ignored users retain phpBB's original values, preventing bot/service accounts from receiving human preference defaults.
- The ACP retains phpBB form-key validation and administrator logging, and the controller now receives the exact ACP action URL.
- The remote probe, suppressed `fopen()`, insecure version endpoint, external download markup, metadata walker, and duplicate version presentation were removed.
- Service definitions are explicit, extension-prefixed, minimally public, and quote every `@` reference. This follows phpBB's dependency-injection guidance for unique service IDs and quoted service arguments: [phpBB 3.3 key concepts](https://area51.phpbb.com/docs/dev/3.3.x/extensions/tutorial_key_concepts.html).

## Reliability and optimization changes

- One centralized policy owns defaults, option-bit positions, valid sort values, and notification-type mappings.
- The listener has fallbacks for every configuration value, so a partial migration does not emit undefined-index warnings or insert arbitrary sort values.
- Configuration writes occur only when the submitted normalized value differs from the current value.
- The non-portable schema-default query was removed; date previews use phpBB's user formatter and structured Twig option arrays.
- Dynamic variable names and controller-generated `<select>` markup were replaced by deterministic arrays and Twig loops.
- Every label is tested against an existing form-control ID. Native ACP buttons and a small extension-only stylesheet replace hundreds of copied generic CSS rules.
- The migration chain uses the original `david63` namespace with valid filenames. Versions 2.1 and 3.2 preserve installed migration history, while 3.3 removes only the two obsolete configuration keys.

## Package and ownership changes

- Composer package, PHP namespace, service IDs, ACP module, migration namespace, language loading, form key, and Twig asset namespace remain `david63/userdefaults` for in-place update compatibility.
- Leinad4Mind is `Developer and Maintainer`; David Wood is retained as `Original Developer`.
- Version state is not written to phpBB configuration. The package version remains in `composer.json` only.
- All PayPal, donation, QR-code, and funding UI material was removed, including translations, CSS, JavaScript, image, and form markup.
- PHP now requires `>=7.2.0`, matching phpBB 3.3's documented minimum: [phpBB 3.3 compatibility notes](https://area51.phpbb.com/docs/dev/3.3.x/extensions/new_in_proteus.html).
- Source and deployed packages contain the same 33 files with matching SHA-256 hashes.

## Residual considerations

- Defaults affect only users created after a save; existing users are intentionally unchanged.
- A live database test that creates a real user was not performed. Listener event mutation, notification preservation, bot exclusion, validation, language catalogs, templates, and package invariants are covered by automated tests.
- Existing `david63/userdefaults` installations can update in place without deleting extension data or changing vendor. Saved defaults remain available to the current package.
- The repository also contains `devspace/userdefaults`, which uses the same `ud_*` keys and event. It must not be enabled alongside `david63/userdefaults`.
- PHP 8.4 and 8.5 expose upstream deprecations from phpBB 3.3.12's bundled class loader and Guzzle promises package; extension-owned code and tests remain clean.

## Verification

- PHP syntax: all 26 PHP files passed on PHP 7.4; the earlier audited package also passed on PHP 8.0, 8.1, 8.2, 8.3, 8.4, and 8.5.
- PHPUnit 10.5.64: 16 tests and 217 assertions passed on PHP 8.1; the earlier audited suite also passed on PHP 8.2, 8.3, 8.4, and 8.5. The synchronized deployed copy matches byte-for-byte.
- phpBB coding standard: passed with no extension errors or warnings. The installed ruleset reports one deprecated sniff owned by that ruleset.
- phpBB Extension Pre-Validator: passed with 0 fatal errors, 0 errors, 0 warnings, and 0 notices.
- Composer metadata: valid. The installed Composer reports only its generic recommendation to omit explicit package versions and its own PHP deprecations; the explicit version is intentionally retained as the sole package version source.
- Three catalog types across English, Portuguese, Brazilian Portuguese, and pre-orthographic Portuguese have matching keys and valid UTF-8.
- Static scans found no funding material, old technical namespace/services, remote update request, legacy template variables, or duplicated config-version update.
- Scoped whitespace and `git diff --check` validation passed.
