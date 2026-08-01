# Security, Reliability, Bug, and Optimization Audit

**Target:** `_forum/ext/leinad4mind/loginredirect`
**Original version:** `david63/loginredirect` `3.1.0-RC1`
**Remediated version:** `leinad4mind/loginredirect` `3.3.0`
**Local phpBB version:** `3.3.12`
**Audit date:** 2026-08-01

## Executive summary

The original login listener terminated phpBB's login flow with a direct redirect, including when the extension was disabled or no valid target existed. That prevented later listeners from running and bypassed phpBB's normal redirect completion. ACP logins could be intercepted, the selected-announcement option was ignored, deleted topics caused invalid row access, pending group memberships qualified, and redirect targets were not checked against topic visibility or the authenticated user's forum permissions.

The extension has been transferred to `leinad4mind/loginredirect` and remediated. It now modifies the redirect value supplied by phpBB's official `core.login_box_redirect` event, leaves the normal redirect untouched when no authorized target exists, and never intercepts ACP login. phpBB documents that this event exposes the `admin`, `redirect`, and `result` values specifically so extensions can modify login redirection: [phpBB 3.3 event reference](https://area51.phpbb.com/docs/dev/3.3.x/extensions/events_list.html).

## Findings and remediation

| ID | Severity | Finding | Status |
|---|---|---|---|
| LRD-001 | High | The listener called `redirect()` directly for every login and terminated the remaining event flow | Resolved |
| LRD-002 | High | ACP logins and ban-check sessions could be redirected away from phpBB's intended flow | Resolved |
| LRD-003 | High | Targets were not restricted to approved topics readable by the authenticated user | Resolved |
| LRD-004 | Medium | Missing or deleted topic rows were accessed as arrays and could generate warnings or failures | Resolved |
| LRD-005 | Medium | The configured selected-announcement mode existed in ACP but was ignored at runtime | Resolved |
| LRD-006 | Medium | Latest-announcement priority had no valid fallback when its preferred target was unavailable | Resolved |
| LRD-007 | Medium | Pending group memberships qualified for group redirects | Resolved |
| LRD-008 | Medium | Generic `redirect_*` configuration names could collide with unrelated extensions | Resolved |
| LRD-009 | Medium | ACP validation did not enforce required topics, announcement type, approved visibility, or group existence | Resolved |
| LRD-010 | Medium | Version metadata disabled TLS and the ACP trusted a remote download value for link output | Resolved |
| LRD-011 | Low | A broad alias file redefined core service aliases and unnecessarily exposed services | Resolved |
| LRD-012 | Low | PayPal, donation, QR-code, language, template, and CSS elements were bundled | Resolved |
| LRD-013 | Low | Extension version state was duplicated in phpBB configuration migrations | Resolved |
| LRD-014 | Low | Obsolete interfaces, undeclared properties, and PHP 8/coding-standard defects remained | Resolved |
| LRD-015 | Low | No extension-owned regression or security tests existed | Resolved |

## Security and reliability changes

- Redirect targets are limited to approved topics for which the authenticated user has both `f_list` and `f_read` access.
- ACP login is excluded, as are banned non-founder checks. An absent, deleted, unreadable, unapproved, or stale target now preserves phpBB's normal redirect.
- The listener updates `$event['redirect']` instead of exiting. The optional intermediate message still validates the internal URL through phpBB before rendering its link.
- Selected and latest announcements are both implemented, with deterministic priority and fallback. Only announcements newer than the user's previous visit qualify.
- Group redirects exclude `user_pending = 1` memberships. ACP input validates the group and all conditionally required topics server-side.
- Configuration is namespaced as `loginredirect_*`. A migration copies legacy values before removing the old generic keys.
- Remote version checking uses phpBB's extension manager over TLS. Only a valid HTTPS download URL can be assigned to the template.
- Services are explicit and private except for the ACP controller that phpBB resolves directly.

## Package and ownership changes

- Vendor, Composer package name, PHP namespace, service IDs, ACP authorization, migration namespace, form key, templates, and language loading now use `leinad4mind/loginredirect`.
- Leinad4Mind is listed first as `Developer and Maintainer`. David Wood is retained as `Original Extension Converter`, and Mark Barnes as `Original Developer`.
- All PayPal and donation-related templates, strings, CSS, QR-code references, and assets were removed.
- Version state exists only in `composer.json`. Migrations no longer add or update a version configuration value; the old `version_loginredirect` key is removed during transfer.
- Dynamic Twig extension includes and obsolete controller interfaces were removed.
- The source and deployed package contain the same 47 files with matching SHA-256 hashes.

## Residual considerations

- Because the vendor changed, administrators must disable `david63/loginredirect` before enabling `leinad4mind/loginredirect`. Existing configuration is transferred only while the legacy values still exist.
- The external version endpoint was not contacted during this audit. phpBB owns the network request and failure handling; the extension only consumes the returned metadata.
- No live browser login was performed. Redirect precedence, permissions, deleted targets, group membership, ACP exclusion, disabled state, and package invariants are covered by automated tests against the local phpBB classes.
- phpBB 3.3.12's own class loader and bundled Guzzle promises package emit upstream deprecation notices on PHP 8.4 and 8.5. The extension-owned files are clean.

## Verification

- PHP syntax: all 39 PHP files passed on PHP 7.4, 8.0, 8.1, 8.2, 8.3, 8.4, and 8.5.
- PHPUnit 10.5.64: 15 tests and 153 assertions passed on PHP 8.1, 8.2, 8.3, 8.4, and 8.5. The synchronized deployed copy also passed on PHP 8.1.
- phpBB coding standard: passed with no extension errors or warnings. The installed ruleset reports one deprecated sniff maintained by the ruleset itself.
- phpBB Extension Pre-Validator: passed with 0 fatal errors, 0 errors, 0 warnings, and 0 notices.
- Composer metadata: valid. Strict validation reports only Composer's generic recommendation to omit explicit versions for Packagist packages; this extension intentionally keeps its sole version in `composer.json`.
- Static scans found no PayPal/donation/QR-code content, insecure HTTP/TLS metadata, old technical namespace or service IDs, dynamic extension includes, or migration version updates.
- `git diff --check` passed.
