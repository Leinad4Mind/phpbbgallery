# Security, Reliability, Bug, and Optimization Audit

**Target:** `_forum/ext/leinad4mind/dropboxupload`
**Original version:** `david63/dropboxupload` `2.1.0-RC4`
**Remediated version:** `leinad4mind/dropboxupload` `3.3.0`
**Local phpBB version:** `3.3.12`
**Audit date:** 2026-08-01

## Executive summary

The original package was not suitable for unattended backup export. It returned the Dropbox app secret and access token to the ACP browser on every page load, stored those values in phpBB global configuration, embedded an obsolete 2017 SDK dependency tree, accepted invalid server-side settings, trusted arbitrary event paths, and treated a failed upload as if its frequency slot had completed.

The extension has been transferred to `leinad4mind/dropboxupload` and remediated. The bundled SDK and its private `vendor/` tree were removed. A small Dropbox Content API client now uses the Guzzle runtime maintained by phpBB, TLS verification, disabled redirects, bounded 8 MiB chunks and upload-session offsets. Credentials are replace-only ACP fields stored in `config_text`; existing values are migrated and never rendered back into HTML.

Dropbox documents that background applications should use refresh tokens because access tokens are short-lived. The new implementation supports app-key, app-secret and refresh-token authorization while retaining a legacy access-token fallback: [Dropbox OAuth Guide](https://developers.dropbox.com/oauth-guide). Dropbox upload sessions explicitly support sequential or concurrent chunks and files above 150 MiB: [official Dropbox SDK route documentation](https://dropbox.github.io/dropbox-sdk-js/Dropbox.html).

## Findings and remediation

| ID | Severity | Finding | Status |
|---|---|---|---|
| DBX-001 | High | App secret and access token were reflected in ACP HTML and stored in globally cached config | Resolved |
| DBX-002 | High | Package embedded obsolete SDK/Guzzle dependencies with known security advisories | Resolved |
| DBX-003 | High | Event-controlled local path was concatenated and uploaded without canonical ownership validation | Resolved |
| DBX-004 | Medium | Folder mode and frequency relied only on HTML constraints | Resolved |
| DBX-005 | Medium | Failed uploads reset the frequency counter and delayed retry | Resolved |
| DBX-006 | Medium | Authentication depended on deprecated long-lived access tokens | Resolved |
| DBX-007 | Medium | ACP version preflight used HTTP, disabled TLS metadata and injected link HTML | Resolved |
| DBX-008 | Medium | Remote paths accepted traversal-like and control-character input | Resolved |
| DBX-009 | Low | Only one SDK exception type was caught, allowing other failures to escape cron handling | Resolved |
| DBX-010 | Low | Listener targeted the obsolete `david63.autodbbackup` event | Resolved |
| DBX-011 | Low | PHP 8 compatibility, undeclared properties and coding-standard defects | Resolved |
| DBX-012 | Low | No extension-owned regression or security tests | Resolved |

The removed Guzzle 6.3.0 lineage is affected by multiple high-severity redirect and cross-origin credential/cookie advisories documented by the maintainers: [Guzzle security advisories](https://github.com/guzzle/guzzle/security/advisories).

## Security changes

- Legacy `dropbox_key`, `dropbox_secret` and `dropbox_token` values are copied into non-cached `config_text` records and then removed from global configuration.
- Secret fields are always rendered empty. A blank submission preserves a value and an explicit checkbox removes it.
- Enabling upload requires either a standalone access token or the complete app-key, app-secret and refresh-token set. Partial refresh credentials are rejected.
- The local source must resolve to a readable regular file inside the canonical phpBB `store/` directory and match the strict `backup_<timestamp>_<id>.sql[.gz|.bz2]` format.
- Dropbox folders reject traversal components, backslashes, control characters, empty components and overlong input.
- Outbound requests use only fixed HTTPS Dropbox endpoints, TLS certificate verification and no redirects. Secrets are redacted from bounded error messages before logging.
- Upload sessions use 8 MiB chunks, a multiple of Dropbox's 4 MiB concurrent-session unit, keeping memory bounded for large database dumps.
- The remote commit uses add mode with `autorename`, preventing accidental overwrite of an existing recovery point.

## Reliability and bug changes

- Upload frequency is enforced server-side from 1 through 25 with an allow-list for folder modes.
- The counter is capped while an upload is due and resets only after Dropbox returns valid file metadata. A failure therefore retries on the next successful local backup.
- Every throwable upload failure is contained and logged without invalidating the already verified local backup.
- Date folders use an explicit IANA user timezone with UTC fallback.
- Folder `<option>` elements and download links are rendered and escaped by Twig rather than concatenated HTML.
- The listener now consumes `leinad4mind.autodbbackup.backup_file_export`, which is emitted only after verified atomic local publication.
- The extension enable check requires the transferred Auto Database Backup extension to be enabled.

## Package and ownership changes

- Vendor, Composer package name, PHP namespaces, services, ACP module authorization, migration namespace, form key and event subscription now use `leinad4mind/dropboxupload`.
- Leinad4Mind is recorded as the active developer and maintainer. David Wood is credited as the original developer, while Kunal Varma retains attribution for the original SDK integration.
- PayPal and donation templates, language entries and CSS were removed completely.
- Version state exists only in `composer.json`; no `dropboxupload_version` configuration or version-update migration was added.
- The obsolete `vendor/`, `composer.lock`, build file and SDK interfaces were removed from the extension package.

## Residual considerations

- `config_text` prevents credential values from entering phpBB's global configuration cache and ACP HTML, but values remain plaintext in the database. Host or database compromise therefore still exposes them. Application-level encryption with a key on the same host would not protect against a full host compromise.
- A live Dropbox call was not made during the audit because no production credential or account was placed in scope. The HTTP sequence, headers, chunks, OAuth refresh and redaction behavior are covered with mocked responses.
- Dropbox retention remains an account policy. This extension intentionally does not delete remote backups.
- phpBB 3.3.12 bundles an older `guzzlehttp/promises` release which emits upstream deprecation notices on PHP 8.4 and 8.5. The extension-owned code and tests remain clean; removing those runtime notices requires updating phpBB's core dependency set rather than bundling a conflicting private copy.

## Verification

- PHP syntax: all 32 PHP files passed on PHP 7.4, 8.1, 8.2, 8.4 and 8.5.
- PHPUnit 10.5.64: 15 tests and 42 assertions passed on PHP 8.1, 8.2, 8.4 and 8.5.
- phpBB coding standard: passed with no extension violations. The installed ruleset reports one deprecated sniff maintained by the ruleset itself.
- phpBB Extension Pre-Validator: passed with 0 fatal errors, 0 errors, 0 warnings and 0 notices using the packaged `leinad4mind/dropboxupload` structure.
- Composer metadata: valid. Composer only reports its generic recommendation to omit explicit versions for Packagist libraries; this phpBB extension intentionally keeps its sole version value in `composer.json`.
- Static package scans found no PayPal, donation, QR-code, old technical namespace/service/event, private runtime autoloader or migration-managed version state.
- `git diff --check` passed. Twig templates use namespaced extension includes and escaped values; EPV also found no HTML/package issue.
- No live Dropbox account test was performed because production credentials were outside the audit scope; HTTP behavior is covered by mocked client tests.
