# Security, Reliability, Bug, and Optimization Audit

**Target:** `_forum/ext/leinad4mind/autodbbackup`  
**Extension version:** `3.1.0-RC1` (metadata dated 2020-10-30)  
**Local phpBB version:** `3.3.12`  
**Audit date:** 2026-08-01  
**Method:** manual source review, data-flow review, comparison with the bundled phpBB extractor/cron behavior, PHP multi-version syntax checks, phpBB coding-standard scan, and dependency advisory review.

## Remediation status (2026-08-01)

The findings below describe the original `david63/autodbbackup` `3.1.0-RC1` baseline and are retained as the audit trail. The checked-out extension has now been remediated and transferred to `leinad4mind/autodbbackup` version `3.3.0`.

The vendor transfer updates the directory, Composer package, PHP/Twig namespaces, service IDs, ACP permission/module references, migrations, form key and extension event. Leinad4Mind was added to the authors as maintainer. All donation and PayPal functionality, translations, templates, scripts, styles and QR assets were removed.

| Finding | Status | Remediation |
|---|---|---|
| ADB-001 | Resolved | Added a `config_text` ownership manifest with canonical-path validation, completion timestamps, SHA-256 metadata, and deletion restricted to recorded files. |
| ADB-002 | Resolved | Added server-side and cron-side allow-list/range validation plus bounded catch-up arithmetic and a bounded retry schedule. |
| ADB-003 | Resolved | Backups now use an extension-owned temporary name, warning-to-exception handling, decompression-to-EOF and completion-marker verification, atomic rename, failure cleanup/logging, and schedule-on-success. |
| ADB-004 | Resolved | Removed the preflight request, enabled TLS, restored phpBB caching, restricted download links to HTTPS, and moved escaped link rendering into Twig. |
| ADB-005 | Mitigated/documented | The ACP now states clearly that this is a best-effort logical export and directs strict point-in-time recovery requirements to database-native snapshots. Cross-engine snapshot guarantees remain outside this extension's generic extractor. |
| ADB-006 | Resolved | The cron task exports only tables beginning with the configured phpBB table prefix. |
| ADB-007 | Resolved | ACP dates use `datetime-local` and exact `DateTimeImmutable` parsing/formatting in the user's IANA timezone, including DST-gap rejection. |
| ADB-008 | Resolved | Removed the misleading optimize control, dump mutations, service dependency, language entries, and configuration via a new migration. |
| ADB-009 | Resolved | Removed the bundled jQuery UI 1.12.1, timepicker and slider-access JavaScript/CSS; the ACP uses the native datetime control. |
| ADB-010 | Resolved | Declared properties, corrected all-constraint AND evaluation, and added compatibility regression tests. |
| ADB-011 | Resolved | Removed the custom formatter and use phpBB's checked file metadata plus `get_formatted_filesize()`. |
| ADB-012 | Resolved | Added PHPUnit coverage and brought the complete PHP package to a clean phpBB coding-standard result. |

### Post-remediation verification

- PHPUnit: 17 tests covering 47 assertions on PHP 8.1; the same suite also passes on PHP 8.2, 8.4 and 8.5.
- PHP syntax: clean on PHP 7.4, 8.1, 8.2, 8.4 and 8.5.
- phpBB PHP coding standard: clean; only the tool's own deprecated-sniff notice remains.
- phpBB Extension Pre-Validator: no errors; its legacy file detector emits one warning for the conventional `phpunit.xml.dist` filename and therefore labels the run failed.
- `git diff --check`: clean.
- No live production database backup or restore was performed; a disposable database restore test remains an operational release step.

## Executive summary

The extension should not be treated as a dependable unattended-backup system in its current form. The most urgent defect is destructive retention: it scans phpBB's shared `store/` directory and can delete unrelated SQL or compressed files. Configuration is constrained only in HTML, so a zero or negative interval can lock the cron runner or cause continuous backup attempts. Backup scheduling is advanced before a backup succeeds, while writes, integrity, and atomic publication are not verified.

The ACP surface has useful baseline controls: it requires `acl_a_backup`, checks a phpBB form token, uses typed request access, and exposes no public route. No direct SQL-injection, command-execution, unsafe-deserialization, or unauthenticated file-operation path was found. Those controls do not mitigate the data-loss and availability defects in the cron path.

### Risk totals

| Severity | Count | IDs |
|---|---:|---|
| High | 3 | ADB-001 through ADB-003 |
| Medium | 5 | ADB-004 through ADB-008 |
| Low | 4 | ADB-009 through ADB-012 |

## Findings

### ADB-001 — Retention can delete files not owned by this extension

**Severity:** High  
**Categories:** data loss, security boundary, correctness

**Evidence:** `cron/task/auto_db_backup.php:204-233`

The cleanup loop includes every regular file whose name ends in `.sql`, `.gz`, or `.bz2`. It does not require a phpBB backup filename, does not maintain an ownership manifest, and does not constrain the files to backups created by this extension. With retention enabled, an old manual export such as `manual.sql`, an archive such as `logs.gz`, or another extension's file can be silently removed. `@unlink()` suppresses deletion failures and there is no deletion audit log.

The sort key is `fileatime()`, not the creation timestamp embedded in phpBB backup filenames or even `filemtime()`. Reading or restoring an old backup can make it appear newer, causing a genuinely newer backup to be deleted instead. Access time is also disabled or approximate on many filesystems.

**Impact:** loss of manual backups, unrelated archives, or the newest usable recovery point during otherwise normal retention operation.

**Recommendation:** keep an explicit manifest/database table of filenames successfully created by this extension and delete only manifest members. Validate the canonical parent directory before deletion, use the recorded completion time rather than access time, log every deletion and failure, and never suppress `unlink()` errors. A dedicated directory is safer, but would require integration work because phpBB's core restore UI only recognizes its strict top-level backup naming convention.

### ADB-002 — Missing server-side validation permits cron lockup and runaway backups

**Severity:** High  
**Categories:** availability, validation, bug

**Evidence:** `controller/admin_controller.php:204-212`, `adm/style/auto_db_backup.html:39,60`, `cron/task/auto_db_backup.php:114-129`

The ACP's `min`/`max` attributes are only client-side hints. The controller writes submitted integers and the file type directly to config without range or allow-list validation. When "maintain frequency" is enabled, the scheduler uses:

```php
while ($next_cron_backup < $time)
{
    $next_cron_backup += $this->config['auto_db_backup_gc'] * 3600;
}
```

For an interval of `0`, the loop never progresses; for a negative interval, it moves in the wrong direction. The task runs under phpBB's global cron lock, so this can block unrelated cron work. With maintain-frequency disabled, a non-positive interval leaves the task immediately due and can generate a backup on each cron opportunity. An unsupported file type is also persisted and later causes the core extractor to throw after the next-run time was already advanced.

**Recommendation:** validate before saving and again defensively before running: interval `1..350`, copies `0..99`, booleans exactly `0|1`, and file type in the currently supported `text|gzip|bzip2` allow-list. Reject unavailable compression extensions. Replace the unbounded catch-up loop with bounded arithmetic after verifying that the interval is positive.

### ADB-003 — Backups are published and scheduled without proving success

**Severity:** High  
**Categories:** backup integrity, recovery, error handling

**Evidence:** `cron/task/auto_db_backup.php:114-150,181-183,236-239`; `_forum/phpbb/db/extractor/base_extractor.php:165-174,212-228`

The extension advances `auto_db_backup_next_gc` before it loads the extractor or writes any data. A format error, storage failure, DB error, timeout, or PHP fatal therefore postpones the next attempt by the full configured interval.

The extractor opens the final phpBB-recognized filename directly, not a temporary file. A crash can leave a partial file that the ACP restore list and this extension's retention code treat as a backup. The core extractor does not check `fwrite`/`gzwrite`/`bzwrite` return values, and the extension performs no checksum, size sanity check, compression test, row/table count check, or restore probe. It unconditionally writes a success log if control returns to the end of `run()`.

**Impact:** a site can appear to have fresh backups while its recovery points are incomplete, and a failed attempt may not retry until the next normal interval.

**Recommendation:** write to an extension-owned temporary name, check every write/close result, verify a nonzero readable artifact and compressed-stream integrity, then atomically rename and record it in the ownership manifest. Only after successful publication should retention run and the next normal time be committed. Catch `Throwable`, remove or quarantine partial output, log failure details, and schedule a bounded short retry.

### ADB-004 — Update checking uses unsigned HTTP data and blocks every ACP view

**Severity:** Medium  
**Categories:** supply-chain security, ACP performance, output safety

**Evidence:** `composer.json:31-35`, `core/functions.php:69-100`, `controller/admin_controller.php:154-176`

The version endpoint is configured with `"ssl": false`; the helper explicitly selects `http://` for non-phpbb.com hosts. It first performs an `fopen()` probe and then calls phpBB's version checker with `force_update=true`, causing two synchronous network operations and bypassing phpBB's 24-hour cached result on every ACP page load.

An on-path attacker can alter the version JSON and supply a syntactically valid malicious download URL for an administrator to click. The controller also constructs an unquoted anchor as a raw string instead of assigning a URL and rendering a quoted, escaped attribute in Twig. phpBB's URL validation reduces direct HTML-injection options, but it does not make an HTTP update advisory trustworthy.

**Recommendation:** remove the preflight request; use an HTTPS-only endpoint and phpBB's cache; fail closed to "update status unavailable"; require an `https` download URL; and construct the link in Twig with normal attribute escaping. If a maintained TLS endpoint is unavailable, remove the custom checker rather than downgrade transport security.

### ADB-005 — The dump is not a guaranteed point-in-time snapshot

**Severity:** Medium  
**Categories:** recovery consistency, architecture

**Evidence:** `cron/task/auto_db_backup.php:143-183`; `_forum/phpbb/db/extractor/*_extractor.php`

Tables are read sequentially while the live forum remains writable. The `BEGIN TRANSACTION` strings in some extractor implementations are written into the restore script; they do not establish a consistent read snapshot for the backup operation. Concurrent posts, topics, permissions, or extension writes can therefore produce a cross-table state that never existed at one instant.

**Recommendation:** document this artifact as a best-effort logical export, not a guaranteed disaster-recovery snapshot. For dependable recovery, integrate database-native snapshot tooling or run a consistent-snapshot transaction where the database engine and table types support it. At minimum, offer a maintenance-window mode and regularly test restoration in an isolated database.

### ADB-006 — Every table in the database is backed up

**Severity:** Medium  
**Categories:** data minimization, performance, storage

**Evidence:** `cron/task/auto_db_backup.php:143-155`

`sql_list_tables()` is used without filtering by phpBB's configured table prefix. Any unrelated application or staging tables sharing the database are exported automatically. This increases runtime, lock duration, storage consumption, recovery ambiguity, and the sensitive-data scope of every backup.

**Recommendation:** default to tables beginning with the exact phpBB table prefix. If operators need extra tables, expose an explicit server-validated allow-list and record the selected scope in backup metadata.

### ADB-007 — Scheduling is wrong across daylight-saving transitions

**Severity:** Medium  
**Categories:** time handling, correctness

**Evidence:** `controller/admin_controller.php:119-146,187`

The controller calculates the user's and server's offsets for "now" and manually applies those offsets to a future timestamp parsed in the server timezone. If the target date is on the other side of a DST transition, the target date's correct offset can differ by an hour. Rendering repeats the same current-offset arithmetic, so the displayed time can also shift as DST changes.

Example: while Lisbon is UTC+1 in August, scheduling `2026-12-01 10:00` (when Lisbon is UTC+0) stores `09:00 UTC`, one hour early.

**Recommendation:** parse the submitted date with `DateTimeImmutable::createFromFormat()` in the user's `DateTimeZone`, check `getLastErrors()`, compare the resulting instant with `now`, then convert the object to UTC. Render by converting the stored UTC instant into the user timezone. Do not manually add offsets.

### ADB-008 — “Optimize database” does not optimize the database

**Severity:** Medium  
**Categories:** functional bug, misleading control

**Evidence:** `language/en/acp_autobackup.php:50-51`, `cron/task/auto_db_backup.php:153-181`

When the option is enabled, the code writes `DELETE FROM` or `TRUNCATE TABLE` statements into the dump stream between the table definition and its data. It never executes `OPTIMIZE TABLE`, `VACUUM`, engine maintenance, or any live-database optimization. For full dumps the statements are generally redundant restore-time operations and can add engine-specific restore risk.

**Recommendation:** remove or relabel the option. If actual maintenance is desired, implement it as a separate engine-aware, permission-gated job with explicit warnings and tests; it should not be conflated with backup generation.

### ADB-009 — Bundled jQuery UI 1.12.1 has known XSS advisories

**Severity:** Low in the current call path; upstream advisories are Moderate  
**Categories:** dependency security, frontend maintenance

**Evidence:** `adm/style/js/jquery-ui.js:1-20`, `adm/style/auto_db_backup.html:96-110`

The extension bundles the full jQuery UI 1.12.1 build. Versions before 1.13.0 are affected by Datepicker and Position XSS issues: CVE-2021-41182, CVE-2021-41183, and CVE-2021-41184. The present extension supplies static language strings rather than direct request values to the relevant options, and the page is ACP-only, so no unauthenticated exploit path was demonstrated. Keeping known-vulnerable, mostly unused widgets in an administrator page is still avoidable exposure.

Upstream references:

- <https://github.com/jquery/jquery-ui/security/advisories/GHSA-9gj3-hwp5-pmwc>
- <https://github.com/jquery/jquery-ui/security/advisories/GHSA-j7qv-pgf6-hvh4>
- <https://github.com/jquery/jquery-ui/security/advisories/GHSA-gpqq-952q-5327>
- <https://jqueryui.com/upgrade-guide/1.13/>

**Recommendation:** use a supported jQuery UI release and include only the required modules, or replace the date/time widget with a maintained/native control. Keep all option values escaped for the correct JavaScript context.

### ADB-010 — Compatibility checks and dynamic properties are incorrect

**Severity:** Low  
**Categories:** PHP compatibility, upgrade safety

**Evidence:** `core/functions.php:20-34,145-160`, `ext.php:19-29,55-70`

`ext_requirements()` parses the two-part phpBB constraint but only evaluates the first part. The second branch repeats `$phpbb_vers[0]` and is reached only when the first condition failed. Consequently, the ACP can report phpBB 4 as valid even though metadata and `is_enableable()` declare `<4.0.0@dev`.

The class declares `$phpbb_extension_manager` but assigns undeclared `$ext_manager` and `$namespace`. PHP 8.2+ reports dynamic-property creation as deprecated. ACP module classes similarly rely on undeclared properties supplied by phpBB conventions.

**Recommendation:** compare every Composer constraint with AND semantics or rely on phpBB's metadata validator. Declare correctly named typed properties and remove the unused declaration. Add runtime tests with `E_ALL` on every supported PHP version.

### ADB-011 — File-size reporting can fail after a backup

**Severity:** Low  
**Categories:** edge-case bug, observability

**Evidence:** `cron/task/auto_db_backup.php:236-281`

`readable_filesize()` does not handle `filesize() === false` or zero bytes before calling `log()`. Its precision lookup contains only indexes `0..4`; sufficiently large files produce an out-of-range index. A reporting failure occurs after backup and retention work, making the operational result difficult to interpret.

**Recommendation:** validate `is_file`, `is_readable`, and a non-false size; handle zero explicitly; cap or extend units; and use phpBB's existing file-size formatter if available.

### ADB-012 — No automated tests; coding-standard failures remain

**Severity:** Low  
**Categories:** maintainability, regression risk

No extension tests or PHPUnit configuration were found. A PHP-only phpBB coding-standard scan reports 10 errors across 7 files: CRLF line endings, missing method visibility in both ACP module classes, and one spacing error. The complete directory scan initially exhausted the 128 MiB PHPCS limit while tokenizing the 539 KiB unminified jQuery UI bundle; limiting the scan to PHP completed normally.

**Recommendation:** add focused unit/integration coverage for interval validation, DST conversion, retention ownership, error cleanup, compression availability, and schedule-on-success. Add CI for PHP lint, phpBB coding standards, JavaScript dependency review, and a disposable-database backup/restore test.

## Optimization opportunities

1. **Eliminate ACP network latency.** A cached single HTTPS version check replaces two forced synchronous HTTP calls per view.
2. **Reduce frontend payload.** The ACP loads about 647 KiB of unminified extension JS/CSS, including a 539 KiB full jQuery UI build, for one date/time field.
3. **Back up only intended tables.** Prefix filtering reduces query load, artifact size, runtime, and the time phpBB's global cron lock is occupied.
4. **Avoid unbounded request execution.** `set_time_limit(1200)` is immediately followed by `set_time_limit(0)`. Long backups can monopolize the global cron runner. Prefer a dedicated system-cron/CLI process with explicit runtime and resource controls, or external database-native tooling.
5. **Read metadata once.** `get_meta()` creates a metadata manager and recursively walks the complete metadata array for each individual key. Load the metadata once per request and index it directly.
6. **Narrow dependency-injection configuration.** `config/alias.yml` registers many global aliases not used by this extension. Define only required services explicitly to reduce container conflicts and upgrade coupling.

## Recommended remediation order

### P0 — Before enabling unattended backups

1. Fix retention ownership and stop deleting by broad extension match.
2. Add server-side validation plus a defensive positive-interval guard.
3. Make backup publication atomic, verify writes, log failures, and advance the normal schedule only after success.

### P1 — Before calling the feature disaster-recovery capable

1. Define and implement a point-in-time consistency strategy or document the limitation prominently.
2. Restrict table scope to phpBB tables by default.
3. Replace manual timezone offset arithmetic.
4. Remove or correctly implement the misleading optimize option.
5. Change the update checker to cached HTTPS or remove it.

### P2 — Hardening and maintainability

1. Upgrade/replace jQuery UI and trim the ACP payload.
2. Correct compatibility parsing and dynamic properties.
3. Harden file-size and filesystem error handling.
4. Add automated restore, retention, DST, and failure-path tests; make coding-standard CI mandatory.

## Verification performed

- Manual review of all extension PHP, YAML, Twig, JavaScript entry points, metadata, and migration files.
- Traced ACP input through configuration, cron scheduling, database extraction, filesystem publication, cleanup, event dispatch, and logging.
- Compared retention filename handling with phpBB 3.3.12's strict backup matcher in `_forum/includes/acp/acp_database.php:345-398`.
- Compared write/error behavior with `_forum/phpbb/db/extractor/base_extractor.php`.
- Confirmed phpBB's web and CLI cron runners hold the global cron lock while tasks run.
- PHP syntax: all 23 PHP files passed on PHP 8.1, 8.2.32, 8.4.22, and 8.5.8.
- PHP-only phpBB coding standard: completed with 10 errors across 7 files.
- Reviewed jQuery UI's official security advisories and 1.13 upgrade guidance.

## Limitations

This was a source-level audit of the checked-out deployment copy. No live database backup, restore, retention deletion, remote update request, fuzzing campaign, or production configuration change was performed. Database-specific behavior should be integration-tested against every engine the project intends to support. A second review is required after remediation because fixes to deletion, scheduling, and backup publication are themselves high-risk.
