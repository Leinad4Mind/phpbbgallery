# Security, Privacy, Reliability, Bug, and Optimization Audit

**Target:** `_forum/ext/david63/pmmonitor`
**Original version:** `david63/pmmonitor` `2.1.0`
**Remediated version:** `david63/pmmonitor` `3.3.0`
**Local phpBB version:** `3.3.12`
**Audit date:** 2026-08-02

## Executive summary

PM Monitor exposes the board's most sensitive user communications and therefore needs stronger controls than an ordinary ACP list. The original package used one broad permission for both reading and deleting, did not log message views, accepted client-created JSON deletion coordinates, and called phpBB's user-context `delete_pm()` routine while an administrator was the active session user. That could update the administrator's in-memory counters and the wrong notification context while deleting another user's recipient copy. The JSON was also decoded as an object and then accessed as an array, so deletion failed on supported PHP versions.

The extension retains the technical identity `david63/pmmonitor`, while active development and maintainership have transferred to Leinad4Mind. It was rebuilt around explicit recipient-copy operations. Viewing and deleting now use independent administrator permissions, every access is logged, destructive requests require phpBB form-key and confirmation validation, posted tuples are strictly parsed and revalidated, and the database changes are scoped to the exact message, recipient, and folder. phpBB's official permission documentation recommends creating permissions in migrations, defining matching language keys, wiring them through the permissions event, and checking them through the Auth API: [phpBB 3.3 Permissions tutorial](https://area51.phpbb.com/docs/dev/3.3.x/extensions/tutorial_permissions.html).

## Findings and remediation

| ID | Severity | Finding | Status |
|---|---|---|---|
| PMM-001 | High | Deletion decoded JSON objects but accessed them as arrays, causing a fatal error | Resolved |
| PMM-002 | High | The ACP called a UCP deletion routine under the administrator's active user and notification context | Resolved |
| PMM-003 | High | Client-controlled message, user, and folder coordinates were not strictly parsed and revalidated as one database tuple | Resolved |
| PMM-004 | High | Reading all private messages and deleting them shared one broad permission | Resolved |
| PMM-005 | High | Viewing sensitive communications produced no administrator audit-log entry | Resolved |
| PMM-006 | Medium | The destructive form had no extension form key or rendered form token | Resolved |
| PMM-007 | Medium | Each displayed row triggered repeated user and session queries, creating a severe N+1 pattern | Resolved |
| PMM-008 | Medium | Invalid sort keys left SQL variables undefined and could break the ACP page | Resolved |
| PMM-009 | Medium | Folder and user counters could be changed outside the exact selected owner/folder scope | Resolved |
| PMM-010 | Medium | Count and listing queries could disagree when user records were unavailable | Resolved |
| PMM-011 | Medium | Missing rows, unknown folders, empty boards, and uninitialized variables caused warnings or unusable pages | Resolved |
| PMM-012 | Medium | Legacy template variables, inline JavaScript, inaccessible toggles, and malformed HTML remained | Resolved |
| PMM-013 | Low | A PHP upper bound below 7.1, obsolete enable checks, and a duplicate PHP version constant made the package incompatible | Resolved |
| PMM-014 | Low | An obsolete controller interface and unnecessarily exposed service remained | Resolved |
| PMM-015 | Low | No extension-owned security, language, architecture, or regression tests existed | Resolved |

## Security, privacy, and deletion changes

- `a_pmmonitor_view` controls access to the message list; `a_pmmonitor_delete` independently controls checkboxes and deletion. Both are initially granted only to the Full Administrator role and can be reassigned separately.
- Every list view records the administrator, IP, and page offset. Every deletion records the administrator, IP, and number of removed recipient copies.
- The ACP includes an explicit privacy notice explaining that message access and deletion are logged.
- Destructive requests require `add_form_key()`, `check_form_key()`, phpBB's confirmation box, a strict maximum of 100 selections, and the exact `msg_id:user_id:folder_id` grammar.
- All posted tuples are fetched again from `privmsgs_to`; if any tuple is absent or altered, the whole operation is rejected before a transaction starts.
- Recipient copies are grouped by owner and folder. Deletes, unread/new counters, custom-folder counters, and per-user notifications are updated only for those owners.
- Outbox deletion preserves phpBB's cancellation semantics by clearing message content, marking outstanding recipient copies deleted, and removing the related notifications.
- Attachments and base message rows are removed only after the last recipient copy disappears.
- Database exceptions roll back the transaction instead of leaving partial counter or message changes.
- Integer casts and phpBB DBAL `sql_in_set()` are used for all identifier collections, following the official abstraction-layer guidance: [phpBB 3.3 DBAL documentation](https://area51.phpbb.com/docs/dev/3.3.x/db/dbal.html).

## Reliability and optimization changes

- The paginated listing loads only metadata through one joined query for messages, authors, and recipients, followed by one grouped session query for all users on the page. One message body is fetched only when its subject is opened.
- User names and last-visit values are rendered from the joined/batched data; the former per-row helper queries and leaked results were removed.
- Sort keys and direction use fixed allow-lists with deterministic tie-breakers. Raw request values never become SQL fragments.
- Pagination counts only recipient copies that still have a base private-message row, matching the listing query.
- Empty boards render a normal ACP notice. Deleted users, unknown folders, and missing visit timestamps have explicit fallbacks.
- Message subjects pass through phpBB censorship, and rendered BBCode uses phpBB's display parser.
- The legacy inline click handler and dropdown script were removed. Subjects now open one revalidated message in an accessible server-rendered detail panel, so other private-message bodies are never placed in the page HTML.

## Package and ownership changes

- Vendor, Composer package, PHP namespace, service IDs, ACP authorization, migration namespace, form key, permissions, and template asset namespace remain `david63/pmmonitor` for in-place update compatibility.
- Leinad4Mind is listed first as `Developer and Maintainer`; David Wood is retained as `Original Developer`.
- Version state exists only in `composer.json`. No PHP constant, phpBB config value, or version-update migration remains.
- The original package contained no PayPal, donation, or QR-code material. Static tests now enforce that this remains true.
- The obsolete controller interface, copied phpBB ACP stylesheet rules, legacy browser branches, and deployed `differences.md` file were removed.
- Source and deployed packages contain the same 39 files with matching SHA-256 hashes.

## Residual considerations

- This extension intentionally gives selected administrators access to all board private messages. Access may be restricted by privacy law, organizational policy, or user expectations; grant `a_pmmonitor_view` to the smallest possible set of trusted administrators.
- A live destructive test against the forum database was not performed because that would alter real private messages. Transaction construction, tuple revalidation, scoped counters, notification ownership, outbox cancellation, permissions, templates, and package invariants are covered with mocks and static validation.
- Existing `david63/pmmonitor` installations can update in place without deleting extension data or changing vendor. The 3.3 migration continues the original chain and installs the independent view/delete permissions for Full Administrators.
- phpBB 3.3.12's class loader and bundled Guzzle promises dependency emit upstream deprecation messages on PHP 8.4 and 8.5. Extension-owned files and tests remain clean.

## Verification

- PHP syntax: all 32 PHP files passed on PHP 7.4; the earlier audited package also passed on PHP 8.0, 8.1, 8.2, 8.3, 8.4, and 8.5.
- PHPUnit 10.5.64: 18 tests and 206 assertions passed on PHP 8.1; the earlier audited suite also passed on PHP 8.2, 8.3, 8.4, and 8.5. The synchronized deployed copy matches byte-for-byte.
- phpBB coding standard: passed with no extension errors or warnings. The installed ruleset reports one deprecated sniff maintained by the ruleset itself.
- phpBB Extension Pre-Validator: passed with 0 fatal errors, 0 errors, 0 warnings, and 0 notices.
- Composer metadata: valid. Strict validation reports only Composer's generic recommendation to omit explicit versions for Packagist packages; this extension intentionally keeps its sole version in `composer.json`.
- Four language catalogs across English, Portuguese, Brazilian Portuguese, and pre-orthographic Portuguese have matching keys and valid UTF-8.
- Static scans found no PayPal/donation/QR-code content, old technical namespace or services, legacy template variables, inline handlers, direct `delete_pm()` use, or duplicated version state.
- `git diff --check` passed.
