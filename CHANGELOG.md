# Changelog

All notable changes to the phpBB Gallery extension suite are documented in this file.

## [4.0.0] Unreleased

### Changed

- Documented every ACP album event variable and exposed explicitly named
  visibility SQL builders while retaining the previous public aliases, allowing
  Gallery Core to pass EPV without compatibility regressions.
- Moved Image Revisions overrides into each album's ACP edit form and added a
  read-only hierarchy showing inherited and effective enablement and retention
  limits, while preserving global defaults.
- Moved BBPoints image overrides into each album's ACP edit form and replaced
  the bulk matrix with a read-only hierarchy showing direct and effective
  values, edit links and confirmed contributor-assignment bulk actions.
- Moved contest configuration, album/result storage and the contest album-type
  label from Gallery Core into the independent Contests add-on, while retaining
  the neutral fail-closed image marker and historical migration compatibility.
- Moved the remaining contest-specific frontend presentation and translations
  out of Gallery Core and into the independent Contests add-on.

### Added

- Added an authenticated Contest end-to-end workflow to the functional CI,
  covering creation, uploads, privacy, disable/enable, voting and winners.
- Added an ACP switch and a dedicated Core contest policy boundary that can prevent creation of new contest albums while keeping every existing contest active, editable and privacy-protected.
- Added an optional plain-text image subtitle across resumable uploads and editing, with a permission-aware search link that removes display parentheses at request time without storing a duplicate cleaned column.
- Added a generic authorization and accounting event before serving original image sources, while keeping medium images and thumbnails unaffected.
- Added permanent BBPoints purchases for original image files, including confirmation, direct-link enforcement, atomic contributor shares and download counters.
- Added an ACP editor for global and inherited per-album BBPoints image policies plus a confirmed, resumable and idempotent historical reward synchronization.
- Added BBPoints image-reward lifecycle hooks for finalized uploads, ACP imports, moderation approvals and author changes without coupling Gallery Core to BBPoints.
- Added the independent BBPoints Images add-on foundation with inherited per-album upload rewards and source costs plus dedicated contributor, reward, purchase, source-hash and download-counter storage.
- Added a confirmed, resumable ACP Cleanup maintenance action that converts legacy [album] Gallery BBCodes into the active [image] or [galleryimage] tag across posts, private messages and signatures while preserving phpBB storage metadata.
- Added optional progressive previous/next image navigation that replaces the complete image view in place, preserves browser history and scroll position, supports keyboard arrows, and falls back to normal permission-checked links.
- Restored permission-safe Gallery locations in phpBB's “Who is online” page for the Gallery index, searches, albums, uploads and images, with target details hidden whenever the viewer cannot access them.
- Restored optional permission-filtered Gallery image counts and personal-album links in topic and private-message mini profiles, with batched loading and independent ACP controls.
- Restored the permission-filtered contest winner search, grouped by contest and ordered newest first, with provenance-checked podium positions, pagination and Gallery index access.
- Restored a responsive, accessible Gallery image selector in topic, reply, private-message and quick-reply editors, with album filtering, pagination and insertion at the active cursor.
- Restored an optional permission-filtered recent and random Gallery image block above the forum index, with independent ACP limits, metadata and personal-album controls for all supported styles.
- Added a migration-backed total image-view counter to the public and ACP statistics, including automatic updates and ACP resynchronization.
- Restored album-scoped search on album pages, including empty albums and responsive themes, while respecting phpBB search availability and user permission.
- Made ACP contest settings appear only while creating or editing an album in contest mode, without an initial visibility flash.
- Added a configurable public Gallery title with a translated fallback, applied consistently to menus, breadcrumbs, feeds and page titles.
- Fixed clipped descenders in polaroid album names with a shared title line box across all supported styles.
- Allowed bounded larger source images when resizing is enabled, enforcing the configured file-size limit on the actual stored result.
- Added moderator-only manual uploads on behalf of another registered user, with resumable drafts, target-author quotas, counters and notification attribution kept consistent.
- Added permission-checked batch moderation for changing the author or individual names of multiple images, including balanced user counters, transaction-safe updates and album metadata resynchronization.
- Added the optional Image Revisions add-on, disabled by default, for replacing an image file without changing its ID, metadata, comments, ratings or view count and for previewing or restoring a bounded history of earlier files.
- Added a dedicated `i_move` permission that lets registered image owners move their completed images into albums where they can upload, without granting moderator move access.
- Added narrow post-persistence and review-validation lifecycle events so optional add-ons can safely attach per-image data to uploads and edits without entering the Core schema.
- Added a per-image upload-review presentation event so add-ons can preserve validated metadata when the resumable second step must be shown again.
- Added a permission-preserving search extension contract and template event for optional add-ons to contribute image filters and retain them across pagination.

### Security

- Made every BBPoints Images identifier explicit at its SQL interpolation
  boundary, allowing the add-on release package to pass EPV without suppressions.
- Isolated inherited BBPoints policies by album owner so nested-set intervals
  from personal galleries can never be treated as ancestors of public albums.
- Made resumable-upload cancellation and scheduled orphan pruning delete drafts only while their database row still has orphan status, preventing a concurrent finalization from losing the completed image or its files.
- Made every dynamic numeric SQL boundary explicit with integer casts and routed the public Gallery title through phpBB's UTF-8 escaping helper, allowing the Core release package to pass EPV without suppressions.
- Made BBTags Images and Image Revisions SQL boundaries explicit at interpolation time and fixed the Gallery search relation to its trusted outer image alias, allowing both add-on release packages to pass EPV without suppressions.
- Disabled every packaged Gallery add-on before disabling the Core, preventing add-on services from breaking container compilation when their required Core parameters and services are unavailable.
- Centralized active-contest privacy so public image pages, album listings and reusable image blocks hide entrant identity, descriptions, ratings, comment history and private sort side channels while preserving explicit owner and moderator exceptions.
- Extended active-contest privacy to search terms and sorting, profile lists and counts, recent comments, top-rated results, album summaries and latest-image attribution.
- Protected feed descriptions, favorite attribution and UCP subscription comment history with the same active-contest identity and result policies.
- Routed EXIF and Feed privacy through extension-neutral Core decisions, removing
  their direct contest constants, helpers and storage-table dependencies while
  retaining fail-closed protection when an optional provider is unavailable.
- Made contest finalization idempotent and deterministic, ranking only approved or locked images and allowing only authorized album views to trigger it.
- Preserved completed-contest participant provenance so podium resynchronization cannot promote later images or alter an active contest.
- Recalculated completed contest podiums when moderation changes a participant between approved, unapproved and locked states.
- Restricted moves into active contests to the upload phase, cleared obsolete contest metadata on moved images and repaired affected source podiums.
- Resynchronized completed contest podiums after an administrator resets all ratings in the album.
- Enforced fail-closed contest phases at upload entry and finalization, comment submission, and rating display and persistence, with explicit boundary handling for the upload, voting, and completed phases.
- Made the Gallery BBCode migration fail before any database write when a tag belongs to another extension or the required IDs cannot be allocated, and restricted historical rollback to Gallery-owned definitions.
- Restricted the editor selector to the authenticated author's completed approved or locked images in albums that remain visible after Gallery ACL and zebra filtering, excluding orphaned and active-contest uploads and retaining protected image routes.
- Invalidated Gallery permission snapshots for every approved group member when ACP changes the phpBB group_skip_auth setting.
- Invalidated targeted Gallery permission snapshots immediately after phpBB group additions, removals, pending-member approvals and attribute changes, including any ACL state already loaded in the same request.
- Restricted random-image results to albums granting image-view or status-moderation access instead of accepting list-only permission.
- Replaced ZIP extraction during gallery uploads with a controlled per-entry extractor that rejects path traversal, absolute paths, symbolic-link entries, unsupported file types, duplicate destinations, and archive entries whose detected content does not match their extension.
- Added ZIP bomb protections for entry count, individual and cumulative uncompressed size, compression ratio, archive metadata inconsistencies, and extraction time, with guaranteed temporary-file cleanup.
- Replaced executable PHP state files in ACP Import with validated, size-limited JSON state tied to the administrator who created it and identified by a cryptographically random token.
- Restricted ACP Import to enumerated direct-child image files inside the import directory, rejecting path traversal, symbolic links, unsupported formats, disguised image types, duplicate names, and destination overwrites.
- Added migration and runtime cleanup for legacy ACP Import PHP state and error files.
- Preserved pending ACP Import files during purge by atomically moving the validated import tree to a timestamped backup.
- Restricted `i_edit` and `i_delete` to images owned by the current user while preserving the corresponding moderator overrides.
- Validated every image in batch moderation against its real source album and action-specific permission, including report closure and destination authorization for moves.
- Restricted individual moderator image moves to POST requests with a valid phpBB form token and independent `m_move` authorization for the real source and destination albums.
- Protected UCP personal-album creation, subalbum reordering, and subscription cancellation with POST-only submissions and valid phpBB form tokens.
- Kept the ACP Cleanup form token outside its optional pruning controls so every cleanup operation remains CSRF-protected when no public upload album exists.
- Bound orphan-upload finalization to the current user and album, required the complete server-generated filename token, and protected the upload-edit step with POST-only form-token validation.
- Made unfinished uploads resumable before accepting new files, added tokenized cancellation with server-side ownership checks, and isolated anonymous drafts with a one-way phpBB session fingerprint.
- Restricted aggregate subtree image counts to descendants that pass list, zebra, i_view, and per-album moderation checks, while reusing the album query already performed for the page.
- Replaced substring-based hotlink checks with fail-closed HTTP(S) hostname validation and exact domain/subdomain boundary matching.
- Enforced the Gallery search permission gate before executing submitted searches, intersected requested album filters with `i_view`, and excluded unapproved and orphaned images from public results.
- Revalidated personal-album ownership when selecting parents and deleting albums, preventing crafted UCP identifiers from reaching another album or the personal root.
- Restricted ACP Cleanup pruning to explicitly supported columns and normalized every filter value before constructing DBAL queries.
- Replaced predictable MD5-based ZIP extraction directory names with cryptographically random 128-bit tokens.
- Removed production PHP deserialization from album-parent and EXIF caches, storing derived data as JSON and rebuilding legacy or malformed values safely.
- Routed untrusted Gallery output through phpBB's UTF-8-aware escaping helper in Core, ACP Import, and EXIF.
- Hid EXIF metadata for active contest entries from non-moderators while preserving access for users with album status-moderation permission.
- Secured image replacement and rollback with the Core upload allowlist, explicit ZIP rejection, ownership checks for intermediate uploads, editor reauthorization, POST-only restoration, phpBB CSRF validation, storage-root path validation and optimistic concurrency protection.

### Changed

- Aligned the Core package and terminal migration with the 4.0.0 release line documented by this changelog.
- Removed the dead Highslide, Lytebox and Shadowbox frontend integrations and language remnants, normalizing saved legacy link modes to supported destinations while retaining normal links and optional progressive AJAX navigation.
- Labelled the public Gallery statistics independently from the forum statistics, placed the FLATBOOTS total-image counter in its responsive index statistics grid, and moved the AJAX image-navigation switch beside the related image navigation settings in the ACP.
- Clarified the Portuguese ACP labels for per-album image limits, thumbnail metadata and thumbnail settings.
- Moved Gallery statistics to the top of the ACP overview and clarified the JPG quality setting while constraining it to GD's supported 0–100 range.
- Made [image]ID[/image] the canonical Gallery BBCode while retaining [album]ID[/album] as a hidden migration-backed compatibility alias for posts imported from the legacy MOD.
- Raised the minimum runtime for all Gallery components to PHP 8.1 and phpBB 3.3, and moved the standalone test dependency from PHPUnit 7/9 to PHPUnit 10.5.
- Replaced legacy and dynamic ACP/UCP module state with declared typed properties, preventing PHP 8.2 dynamic-property deprecations.
- Added native property, parameter, and return types throughout the ACP Cleanup service API.
- Added native property, parameter, union-return, and module-entry types throughout the ACP Import API.
- Added native types throughout the EXIF model and event listener, including safe rejection and rebuilding of invalid or legacy metadata.
- Added native types to the core configuration, cache, URL, authorization-value, authorization-level, and constants services.
- Added native property, parameter, union-return, and operation types throughout the Core ACL service, with explicit public constants and fail-closed permission contracts.
- Added an explicit array-or-false normalization contract to the image-authorization helper.
- Added native module-entry and progress-rendering types to the ACP album manager.
- Added native module-entry types to the ACP Gallery log viewer.
- Added public array contracts to all Core ACP and UCP module metadata providers.
- Added native dependency, schema, data, callback, and static configuration types throughout the Core migration chain while preserving phpBB profile-field property compatibility.
- Added native dependency and data-step contracts to the ACP Cleanup migration.
- Converted all remaining production PHP arrays across Core, ACP Cleanup, and EXIF to short-array syntax, with token-aware regression coverage.
- Normalized every packaged text file to Unix LF endings with a final newline and added repository/test enforcement against regressions.
- Added native property, parameter, and return types throughout the Core album, album-display, album-loader, and album-management services, with initialized request state and JSON parent caches.
- Added native property, parameter, and return types throughout the Core image service, including stable no-op and missing-image results and instance-safe counter/filename calls.
- Added native property, parameter, and return types throughout the Core comment service, with explicit invalid-mutation results and instance-safe identifier normalization.
- Added native property, parameter, and return types throughout the Core moderation service, preserving the ACP Cleanup contract by normalizing a legacy false filename map before image deletion.
- Added native property, parameter, and return types throughout the Core user service, with initialized nullable state and safe state resets when switching or destroying users.
- Added native property, route-parameter, helper, and Symfony response types throughout the Gallery index controller.
- Added native state, dependency, route, helper, and binary-response types throughout the Gallery file controller.
- Added native dependency, route, pagination-helper, and Symfony response types throughout the Gallery search controller.
- Added native dependency, route, display-helper, and nullable confirmation-response types throughout the Gallery album controller.
- Added native dependency, route, filesystem-helper, and Symfony response types throughout the resumable upload controller.
- Added native dependency, route, batch-authorization, pagination-helper, and response types throughout the Gallery moderation controller.
- Added native dependency, route-identifier, and Symfony response types throughout the Gallery comment controller.
- Added native dependency, request-state, route, display-helper, and response types throughout the Gallery image controller.
- Added native dependency, event-payload, subscriber-map, and callback return types throughout the Core event listener.
- Added native dependency, identifier-list, watcher-query, and operation return types throughout the Core notification services.
- Added native service-property and presentation return types to all six Gallery notification event classes while preserving compatibility with phpBB's untyped notification interface.
- Added native property, parameter, union-return, and operation types throughout the Core contest service, with deterministic handling for unknown steps and invalid tabulation modes.
- Added native property, parameter, cached-value, and operation types throughout the Core rating service, with explicit submission results and request-local state reset whenever a new image is loaded.
- Added native property, parameter, identifier-list, and operation types throughout the Core report service, with initialized queue state, safe empty-image results, and clamped pagination offsets.
- Added native property, parameter, count-return, and rendering types throughout the Core search service, with initialized result state, safe missing-count handling, and deterministic fallback sorting.
- Added native property, parameter, image-read, cache-response, and upload-collection types throughout the Core file services, with safe GD handle state, validated watermark metadata, and deterministic empty multipart uploads.
- Normalized legacy PHPDoc annotations throughout Core, preserved informative service descriptions, removed stale parameter and function tags, and added regression coverage for unsupported formats.
- Removed the obsolete commented favorite-module and BBCode stubs from the initial Core migration; those responsibilities now remain with the favorite add-on and the dedicated BBCode migration.
- Converted the Gallery ACP, ACP Cleanup, ACP Import, and EXIF templates from deprecated phpBB comment tags to native Twig syntax.
- Converted the shared and prosilver Gallery templates from deprecated phpBB comment tags and template variables to native Twig syntax.
- Converted the BBOOTS Gallery templates from deprecated phpBB comment tags and template variables to native Twig syntax.
- Converted the FLATBOOTS Gallery templates from deprecated phpBB comment tags and template variables to native Twig syntax, completing the migration of all packaged Gallery templates.
- Reduced the packaged extension from approximately 8.2 MiB to 3.1 MiB by removing generated differences reports, backup files, source maps, unused upload plugins, and duplicate per-style JavaScript bundles.
- Consolidated shared JavaScript under the phpbbgallery_core template namespace and corrected the polaroid asset reference for prosilver, BBOOTS, and FLATBOOTS.
- Updated the required jQuery UI Widget Factory from 1.11.4 to 1.14.2 and documented SHA-256 pins for every retained third-party upload asset.
- Reduced the legacy Blueimp upload snapshot to the image-only runtime modules used by Gallery.
- Prefixed every Gallery-owned template event with `phpbbgallery_` and updated the EXIF listeners in all supported styles.
- Added the missing prosilver template counterparts, split its monolithic UCP template into reusable partials, and retained the independent BBOOTS and FLATBOOTS layouts.
- Moved Gallery theme assets into the shared `all` style, loaded them for every style, removed the unused `gallery-color.css`, and added native EXIF event coverage for BBOOTS.
- Completed the Portuguese AO90/pre-AO90 separation, rewrote the Brazilian Portuguese catalogs for Brazilian usage, and added Spanish and Dutch translations to ACP Cleanup, ACP Import, and EXIF.
- Reduced the legacy installation catalogs to the sole runtime uninstall message, removing obsolete `Gallery-MOD`, phpBB2 table-prefix, and converter-era text.
- Made album nested-set boundaries, contest ranking, image-navigation visibility, and search-result filters explicit at their DBAL interpolation points, eliminating false-positive SQL-injection findings from the official validator.
- Modernized all BBOOTS and FLATBOOTS Gallery and EXIF definition-list layouts with native Bootstrap tables, form controls, responsive grids, and accessible labels.
- Reused the canonical Gallery posting form for legacy image editing instead of maintaining divergent per-style copies.
- Redesigned the Bootstrap UCP subscription manager with media previews, responsive two-column metadata, inline last-comment content, and a single bulk action control.
- Modernized Bootstrap personal-subalbum management with full-width controls, responsive parsing options, and a dedicated empty state instead of an empty table header.
- Removed the obsolete EXIF configuration-set event listener whose event and target configuration class no longer exist.
- Added generic Core image-file edit extension points, per-operation ZIP exclusion and exact cleanup of files created by an add-on operation, keeping revision storage and policy outside the Core extension.

### Fixed

- Fixed Contest winner pagination using an undefined legacy configuration key
  and made the shared search template reusable from add-on controllers through
  explicit Core template paths.
- Reconciled stale Favorite, Image Revisions, BBTags Images and BBPoints Images data after an add-on is re-enabled, removing missing image/album relations and revision files while preserving permanent financial history.
- Removed per-user album read-tracking rows when public or personal albums are deleted, including the complete subtree of a deleted personal album.
- Corrected contest-winner headings and links across every language so the three-place podium is consistently described in the plural.
- Hid the message-editor Gallery selector when the current user has no completed, permission-accessible images to insert.
- Preserved unrelated custom [image] BBCodes during installation by selecting [galleryimage] for new Gallery content while retaining [album] only as a hidden compatibility alias for historical posts.
- Corrected the BBOOTS and FLATBOOTS rating selectors to use the translated DO_NOT_RATE_IMAGE label instead of displaying an undefined language key.
- Completed Gallery add-on release packages with their declared GPL license and excluded development-only PHPUnit files from EPV validation.
- Prevented member profiles from rendering an undefined Gallery image block when profile images are disabled.
- Generated Gallery BBCode targets through phpBB's router without session identifiers, refreshed both the canonical and legacy parsers from ACP, and invalidated the text-formatter cache immediately.
- Synchronized renamed users and default-group colours across Gallery images, comments, last-image metadata, personal albums and statistics; removed deleted user/group ACL rows and kept moderator listings on live phpBB identities.
- Injected the phpBB event dispatcher into the resumable upload and search controllers so add-on validation, presentation, filtering, and result events execute without fatal errors.
- Corrected image-cache hits that were assigned to the album variable, merged only missing image IDs into the shared cache, returned only requested rows, and reset request-local data during invalidation.
- Synchronized the Portuguese, Brazilian Portuguese, and pre-orthographic-agreement catalogs with the English source, translating 99 previously unavailable messages and removing obsolete keys.
- Corrected plural forms and printf placeholders in Portuguese catalog entries, plus the malformed Spanish plugin-class placeholder.
- Removed obsolete PHP-extension suffixes that were rendered inside Spanish and Italian ACP labels.
- Replaced the obsolete Gallery credit in every language with a 2014–2026 link to the official phpBB Gallery repository.
- Prevented the ACP personal-gallery resync from indexing a missing newest row, clearing the related statistics when no personal albums exist.
- Serialized the migration graph so Gallery tables are created before dependent schema changes and purge reverses in a deterministic order.
- Preserved Gallery files during purge by atomically moving the live tree to a timestamped backup, aborting on a symbolic-link source, an unexpected path, or backup failure.
- Kept all six notification types synchronized across enable, disable, and purge, corrected the image_not_approved identifier, and made legacy purge failures isolated per type.
- Prevented ACP Import from copying files after image validation had failed.
- Continued mixed ACP Import batches when selected files disappear, recording skipped files for the final report and stopping only when none remain valid.
- Reported the 10,000-image ACP Import state limit explicitly and warned administrators when files with unreadable names are ignored, in every packaged language.
- Synchronized Gallery user image counters and personal-album links after ACP Cleanup removes obsolete or unwanted personal galleries.
- Posted personal-album deletion confirmations to the canonical board-root UCP action instead of deriving a duplicated `ucp.php/ucp.php` path.
- Posted all Gallery ACP confirmations to their canonical module actions instead of deriving duplicated `adm/index.php/adm/index.php` paths.
- Applied the ACP-enabled upload extensions consistently to backend validation, native file selectors, and quick-upload JavaScript instead of exposing a hard-coded format list.
- Derived ACP Import image titles from the validated UTF-8 display filename, preserving accented names originating as either UTF-8 or Windows-1252.
- Restored the “Who is online” block in BBOOTS and FLATBOOTS by relying on phpBB’s `S_DISPLAY_ONLINE_LIST` contract instead of an unassigned Gallery template variable.
- Corrected the malformed comment-statistics reset query so both the count and last-comment identifier are cleared after deleting comments by image.
- Prevented Gallery settings from a previously loaded user being reused when switching to a user without a Gallery row.
- Made empty bulk-user filters match no rows instead of being converted to user ID 1, while keeping the explicit all operation unchanged.
- Released the database result after looking up a user's personal root album.
- Normalized an empty latest-image lookup without relying on PHP's deprecated automatic conversion of false to array.
- Normalized missing file-controller database rows and centralized complete error-image state, preventing stale or undefined authorization data.
- Prevented zero-valued default user and album filters from executing an unintended search, clamped invalid page numbers, corrected the result offset, and fixed the top-rated breadcrumb target.
- Prevented negative album offsets and rejected unsupported image sort keys before building the album query.
- Returned moderation redirects to Symfony instead of sending them inside the controller, clamped invalid pages, and guaranteed responses from individual lock and unapprove confirmations.
- Routed comment signature and cancellation input through phpBB's request service instead of reading the POST superglobal directly.
- Reset request-local image/user caches before rendering, rejected unsupported image sort keys, and removed a duplicated image-ID sort suffix while preserving page-owned view counting.
- Reset profile-event user and album state between emissions, preventing stale listener data in multi-profile requests.
- Normalized duplicate notification watch identifiers, skipped empty watch operations, returned integer watcher IDs, released their SQL results, and repaired album-watch insertion SQL.
- Normalized empty notification avatars and references to strings and guaranteed string fallback URLs for template rendering.
- Updated gallery and user image counters only for images imported successfully.
- Preserved ACP Import errors safely in JSON state between batches and corrected the final successful-image count.
- Fixed the fatal error when resetting album ratings in the ACP by using the registered `phpbbgallery.core.rating` service.
- Prevented ACL data and memoized decisions from leaking when the same service changes users, while safely ignoring malformed cached permission rows.
- Applied personal-album access levels during ACL construction and corrected moderator checks to pass album and owner identifiers in the correct order.
- Made ACL recipient resolution reject unsupported permissions and missing albums, handle empty roles and groups safely, and release foe-query results.
- Routed ACP album update detection through phpBB's request service instead of reading the POST superglobal directly.
- Routed ACP Cleanup pruning and cancellation flags through phpBB's request service, guarded failed upload-directory handles, initialized confirmation labels, and provided a deterministic filename-encoding fallback.
- Restored ACP Import selections, ACP Gallery log deletion, paginated UCP subscriptions, and the user-controlled EXIF details toggle after their PHP/Twig modernization regressions.
- Returned controlled not-found responses for missing image rows throughout image, comment, moderation, deletion, and notification paths.
- Preserved Unicode filenames during ACP Cleanup, guarded missing personal-gallery rows, and reset stale newest-gallery statistics without indexing `false` results.
- Removed double escaping from new Gallery log records while retaining an explicit compatibility decoder for previously stored descriptions, without `stripslashes()`, and preserving legitimate backslashes.
- Corrected rating album discovery to use `image_album_id` and surfaced invalid guest upload names through the active error collection.
- Rendered comments from deleted users without undefined offsets and removed the dead secondary user cache branch.
- Initialized ACP/UCP maintenance state, guarded failed album lookups, and prevented partial personal-album rows from being offered for deletion.
- Clamped album, index, report, and UCP page values before calculating offsets and made empty Gallery URL paths resolve safely.
- Recognized both `.jpg` and `.jpeg` files in EXIF processing and watermark cleanup.
- Normalized database-derived identifiers before DBAL interpolation and used `sql_build_array()` for the profile-field migration update.
- Built Gallery entrypoints from the configured phpBB root and PHP extension, and moved controller-visible fallback text into the language catalogs.
- Removed unreachable import, album, multipart upload, and profile-listener branches left by the legacy implementation.
- Resolved stored-image paths against the configured phpBB root so upload previews and generated image variants work consistently on Windows and Unix hosts.
- Removed phpBB session identifiers from copyable full-image and BBCode share URLs.
- Corrected Bootstrap moderation empty states, the approval-queue block name, accessible selection controls, and authorization-gated approve/disapprove actions.
- Restored Bootstrap comment authors, profile links, ranks, online state, edit information, signatures, and contact fields by aligning the templates with the image-controller contract.
- Corrected Bootstrap Gallery search field names and sort-direction controls to match the controller request parameters.
- Restored WebP labels and selection in Bootstrap upload controls and replaced the remote upload-preview placeholder with the packaged fallback image.
- Built Gallery UCP form actions from the board root, preventing personal-album and subalbum operations from posting to duplicated paths such as `/ucp.php/ucp.php`.
- Corrected album bulk-selection controls in the UCP subscription manager and rendered the actual last-comment body with its author and timestamp.
- Removed all redundant `imagedestroy()` calls from production and test fixtures, eliminating PHP 8.5 deprecation warnings while leaving GD objects to PHP's automatic lifecycle.

### Performance

- Added compound indexes for album image listings and report lookups by image, album, and status.
- Removed view-counter writes from direct binary image requests, keeping session-aware page visits as the single source of view metrics.
- Applied private Last-Modified revalidation to image responses while preventing browser storage for guests and error responses.
- Replaced per-album notification watch inserts with DBAL multi-inserts and grouped duplicate identifiers before writing.
- Batched comment and rating statistic changes by image, preloaded moderation album names, and inserted ACL role memberships in sets.
- Batched ACP filesystem-size repairs, cached last-image repairs, and image-count resynchronization instead of issuing updates per image or album.
- Recalculated contest winners for up to 100 albums per query set with deterministic tie-breaking and explicit stale-rank cleanup.
- Moved all descendants of a deleted album as one contiguous nested-set interval, preserving their hierarchy and rejecting invalid destinations before tree mutation.
- Removed the unused custom-profile-field query and its service dependencies from the profile event listener.

### Tests

- Extended the PHPUnit, EPV and manifest-validation matrices to every packaged Gallery component, and added functional installation/purge smoke coverage for Export and Feed.
- Added a real phpBB reactivation workflow covering disabled add-ons, deleted images/albums, automatic orphan reconciliation, preserved BBPoints history and successful container recompilation.
- Established GitHub Actions coverage for Core, ACP Cleanup, ACP Import and EXIF on PHP 8.1, 8.2, 8.4, and 8.5, plus manifest validation, PHP linting, production PHPCS checks, and official EPV package validation.
- Added permanent runtime-compatibility tests covering the PHP/phpBB/PHPUnit baselines, legacy `var` regression, and typed ACP/UCP module state.
- Added standalone ACP Cleanup tests covering typed service/module contracts, centralized form input, safe directory scanning, file cleanup, database-entry cleanup, and moderation delegation.
- Added standalone ACP Cleanup migration tests covering native contracts, dependency ordering, permission installation, and module registration.
- Added standalone EXIF tests covering typed model/listener contracts, JSON metadata handling, legacy-cache rebuilding, and event registration.
- Added permanent core-infrastructure tests covering native contracts, configuration mutations, bitfields, constants, path normalization, partial image-cache merges, cache hits, and request-local invalidation.
- Added permanent album-domain tests covering complete native contracts, loader state and ownership checks, manager/display defaults, and rebuilding of legacy serialized parent caches as JSON.
- Added permanent image-domain tests covering complete native contracts, stable empty-operation results, and image-display bitmask values.
- Added permanent comment-domain tests covering complete native contracts, invalid mutations, identifier normalization, and valid comment-statistics reset SQL.
- Added permanent moderation-domain tests covering complete native contracts, deletion delegation across related services, and legacy filename-map normalization.
- Added permanent user-domain tests covering complete native contracts, state isolation, missing rows, safe bulk filters, data normalization, personal-album lookup cleanup, and destruction.
- Added permanent index-controller tests covering complete native contracts, response and route types, recent-content mode flags, and empty latest-image normalization.
- Added permanent file-controller tests covering complete native contracts, binary routes, state reset, and missing database rows.
- Added permanent search-controller tests covering complete native contracts, route responses, page and filter normalization, result offsets, and breadcrumb targets.
- Added permanent album-controller tests covering complete native contracts, route defaults, nullable confirmation responses, sort-key normalization, and display flags.
- Added permanent upload-controller tests covering complete native contracts, route types, and required writable upload directories.
- Added permanent moderation-controller tests covering complete native contracts, route parameters, nullable authorization exits, page normalization, and returned redirects.
- Added permanent comment-controller tests covering complete native contracts, integer route identifiers, Symfony responses, and centralized form input.
- Added permanent image-controller tests covering complete native contracts, route defaults, nullable authorization exits, request-state reset, sort normalization, query ordering, and view-counter ownership.
- Added permanent Core event-listener tests covering complete native contracts, subscribed events, and profile-state isolation.
- Added permanent notification-service tests covering complete native contracts, identifier normalization, empty operations, and watcher-query cleanup.
- Added permanent notification-event tests covering phpBB inheritance compatibility, native contracts, identifiers, serialized payloads, and presentation values.
- Added permanent native-Twig tests covering deprecated-token removal and parsing with the packaged Twig version.
- Added permanent language-catalog tests covering PHP file and key parity, plural structures, printf placeholders, UTF-8 validity, and non-empty translations across all four Gallery components.
- Added permanent package-hygiene tests covering generated artefacts, duplicate bundles, namespaced asset resolution, polaroid loading, current widget version, missing source-map references, third-party checksums, and valid production PHPDoc annotations.
- Added permanent ACP personal-gallery resync tests covering populated and empty databases, normalized values, and regression against indexing a missing row.
- Added permanent performance and browser-cache tests covering index creation and rollback, index-name portability, conditional 304 responses, stale validators, no-store responses, file timestamps, and view-counter ownership.
- Added permanent migration and purge-safety tests covering native contracts, profile-field compatibility, dependency ordering, cycle detection, table prerequisites, add-on module ownership, atomic file backup, idempotency, and regression against recursive deletion.
- Added permanent ZIP extractor tests covering valid archives, traversal attempts, disguised files, duplicate paths, malformed metadata, resource limits, compression-ratio abuse, and cleanup behavior.
- Added permanent ACP Import tests covering native type contracts, state validation, non-executable persistence, legacy-state cleanup, path containment, symbolic links, MIME validation, safe copying, language completeness, and architectural regressions.
- Added permanent ACP Import purge tests covering callback safety, path validation, atomic backups, idempotency, and regression against recursive deletion.
- Added permanent authorization tests covering native helper contracts, image ownership, moderator overrides, route-album containment, per-image moderation permissions, destination permissions, and controller integration.
- Added permanent individual-move tests covering request methods, CSRF validation, source and destination authorization, form tokens, and mutation ordering.
- Added permanent ACP rating-reset tests covering service resolution, non-empty and empty albums, and regression against the removed legacy class name.
- Added permanent UCP CSRF tests covering personal-album creation, subalbum reordering, subscription cancellation, POST-only inputs, move-direction validation, form tokens, and mutation ordering.
- Added permanent orphan-upload and upload-edit tests covering user/album binding, exact tokens, malformed identifiers, POST-only fields, CSRF ordering, and tokens in all styles.
- Added permanent resumable-upload tests covering registered users, anonymous sessions, cancellation, CSRF, AJAX, quotas, migration schema, form controls, and seven-day retention.
- Added permanent access-boundary tests covering per-descendant ACL image counts, moderator visibility, hidden albums, orphan exclusion, strict referrer parsing, domain boundaries, empty referrers, and configured bypass behavior.
- Added permanent notification-lifecycle tests covering exact service identifiers, enable/disable symmetry, sub-extension disabling, complete purge, and continuation after a missing legacy type.
- Added permanent ACL-domain tests covering native contracts, cache isolation and deserialization, moderator argument order, personal-album restrictions, unsupported permissions, and missing albums.
- Added permanent ACP album-manager tests covering complete native contracts and centralized update input.
- Added permanent ACP Gallery-log tests covering complete native contracts and mutation request/CSRF ordering.
- Added permanent ACP/UCP module-metadata tests covering public contracts, expected modes, authorization guards, and categories.
- Validated the ZIP upload, ACP Import, authorization, individual-move security, ACP rating-reset, ACP personal-resync, UCP CSRF, orphan-upload, resumable-upload, subtree-count, hotlink, notification-lifecycle, migration-ordering, purge-safety, database-index, view-counter, browser-cache, package-hygiene, JavaScript-asset, and language-catalog phases with PHP 7.4, 8.1, 8.2, 8.4, and 8.5.
- Added a real phpBB 3.3.x and SQLite functional lifecycle suite covering Core and add-on installation, schema, configuration, storage, permissions, guest denial, ACP Import, resumable drafts and cancellation, a simulated 3.4-to-4.0 update, add-on purge, and Core purge.
- Added regression tests for restored workflows, search authorization, personal-album ownership, cleanup filters/state, missing images, log compatibility, guest uploads, deleted commenters, pagination, path handling, and JPEG EXIF files.
- Added permanent Bootstrap template regressions covering responsive layouts, Twig parsing, localization, labels, upload previews, moderation authorization, comment profiles, subscription controls, and UCP album actions.
- Added query-shape and behavior tests for notification, statistics, role, filesize, last-image, deletion, contest, nested-set batching, visibility, search filters, legacy logs, JSON caches, and random upload paths; the Core suite now contains 382 tests and 6968 assertions.
- Validated correctly packaged Core, ACP Cleanup, ACP Import, and EXIF components with the official Extension Pre-Validator: no errors, notices, or warnings remain.

## [3.4.0]

### Added

- Added version checkers for the Core, ACP Cleanup, ACP Import, and EXIF components.

### Changed

- Improved extension enable, disable, and purge handling across the Gallery suite.
- Improved Gallery image-page behavior and compatibility with other phpBB extensions.
- Updated extension metadata and Composer compatibility for the phpBB 3.3 line.
- Reworked cleanup, import, configuration, and uninstall handling to keep component state consistent.
- Removed deprecated SPDX license identifiers and aligned packaged metadata with current validation requirements.

### Security

- Fixed an insecure redirect in Gallery notifications.
- Hardened notification, configuration, cleanup, and uninstall paths against invalid or inconsistent state.

### Fixed

- Fixed WebP image handling.
- Fixed Symfony array compatibility problems and conflicts with some third-party extensions.
- Fixed missing configuration removal and permission cleanup during uninstall and purge.
- Fixed missing notification registration or cleanup during extension enable and purge operations.
- Fixed ACP Import failures during uninstall.
- Fixed ACP Cleanup regressions.
- Fixed Gallery configuration layout issues in the ACP.
- Fixed incorrect comment counts after deleting images.
- Fixed undefined indexes while deleting comments.
- Fixed image names in image reports.
- Fixed IP handling and other image-page regressions.
- Fixed MariaDB compatibility for the `image_exif_data` field.
- Fixed version-check configuration and Extension Pre-Validator issues.
- Fixed missing or inconsistent license files and assorted language, whitespace, and packaging issues.

## [3.3.0]

### Added

- Added support for image posters to view their own unapproved images.
- Added a Gallery navigation entry for guests and improved guest-facing index and album layouts.
- Added Spanish and Italian translations and improved existing language catalogs.

### Changed

- Updated the Gallery suite for phpBB 3.3 compatibility.
- Refactored `assign_block()` using bitwise operations.
- Restructured and modernized the Core, ACP Cleanup, ACP Import, and EXIF components.
- Refactored moderation switches, controller logic, and the ACP Gallery log module.
- Simplified alphabet navigation.
- Reorganized the repository and add-on boundaries for long-term maintenance.

### Security

- Reduced unsafe deserialization paths and hardened database-query construction.
- Addressed validator-reported SQL-injection risks.

### Fixed

- Fixed notification lifecycle and routing issues.
- Fixed “Who is online” and circular-reference problems.
- Fixed ACP and MCP pagination.
- Fixed meta-refresh behavior after image approval.
- Fixed subalbum movement while editing albums and updating images.
- Fixed EPV event dependencies.
- Fixed comment and language-file typographical errors.

## [3.2.2]
### Added
- Added comprehensive FRENCH translations and updated UI strings (by Galixte).

### Changed
- Adjusted spacing in navigation menus (`linklist`), album lists (`forabg`), and image titles.
- Enhanced YML notifications and cleaned routing files.

### Fixed
- Fixed missing language keys globally, consistently applying `{L_COLON}` where required.
- Fixed the "Change Author Bug".
- Fixed `sizeof()` warnings for PHP 7.2 compatibility.
- Prevented watermark (`_wm`) images from inappropriately appearing in the ACP image lists.
- Removed duplicated language strings and fixed comment edit styling issues.

## [3.2.1.1]
### Changed
- Improved test suites and continuous integration configurations.
- Allowed failure conditions for PHP 7.1 and 7.2 functional tests to reduce Travis test time.

## [3.2.1.0]
### Added
- **Contests Feature**: Added full support for contests including winner styling, ACP contest creation, contest-aware uploading, and displaying contest info directly in albums.
- **RRC_ZEBRA Integration**: Integrated zebra striping at the image level.
- **Notifications**: Added notifications for unapproved images.
- Added multiple new core events for extension developers.

### Changed
- Version numbering explicitly jumped to 3.2.x to reflect targeted compatibility with phpBB 3.2.
- Re-architected the upload method to utilize the core `\phpbb\files` class.
- Moved subscription logic to a button and added an associated icon.
- Started implementation of `\phpbb\language` core conventions.

### Fixed
- Fixed image rotation handling.
- Fixed wrong cache requests and logic issues affecting specific database engines (e.g., PostgreSQL).
- Fixed `auth->get_zebra_state` to properly return an integer.
- Fixed division by 0 errors in User Profile.
- Secured routers and updated notification logic to correspond to the new request methods.

## [1.2.2]
### Changed
- Incremental improvements for tests (PHPUnit/Coveralls) and filesystem handling.
- Minor refactoring around HTML templates.

## [1.2.1]
### Changed
- Refactored `ext.php` and `composer.json` requirements.
- Minor cleanup of legacy code in migrations to prepare for the 3.2.x migration.

## [1.2.0.11]
### Fixed
- Security: Fixed log vulnerability (Log security bug).
- Security: Resolved "Sniffing" vulnerabilities.
- Security: Enforced strict casting for albums and images to integers.
- Fixed URL issues and validation in controllers (e.g., `controller/comment.php`).
- Composer compatibility adjustments and `core\file\file` dependencies fixed.

## [1.2.0]
*Note: First extension release for phpBB 3.1. Versions up to 1.1.6 were released as MODs for phpBB 3.0.*

### Added
- Create info_acp_gallery_cleanup.php
- Create info_acp_gallery_acpimport.php
- Create newcomment_notify.txt
- Create exif.php
- Create permissions_gallery.php
- Create info_ucp_gallery.php
- Create gallery_notifications.php
- Create info_acp_gallery.php
- French translation files for satanasov phpbbgallery

### Changed
- Use SQL query cache
- Update info_acp_gallery_cleanup.php
- Update permissions_gallery.php
- Update gallery_notifications.php
- Update info_ucp_gallery.php
- Update info_acp_gallery.php
- Rename newcomment_notify to newcomment_notify.txt
- Rename newimage_notify to newimage_notify.txt
- Update gallery.php
- Some code inspection and DocBlock
- Set revision to Big Buck Bunny

### Fixed
- Fix security issue!
- Fix ACL issue wit recent comment showing images that should not be accessible
- Forgot to define array so the system wont spew error
- Added missing variable
- This fixes topic 165786
- This fixes topic 166736
- This fixes topic 166176
- This fixes topic 166386 and close #120
- Fix sniffing issues
- This fixes topic 166526
- Fix path
- Fix post 166976
- Fix old variables
- Fix \phpbbgallery\core\file\file dependancy
- Fix sniff error
- Validation issues before acp/config_module.php except for handling file system issues
- Fix URL error
- Fix validation issues before controller/comment.php
- Fix all revision critics
- Fix some styling issues
- Fix Sniffing issue

## [1.1.6] - 2012-04-13
### Fixed
- Fix "Undefined variable: poster_id" when viewing a pm (Bug #954)
- Correctly list personal albums of deleted users (Bug #957)
- Fix SQL error in ACP with PostgreSQL (Bug #955)
- Images with dots in the name are not extracted from zips (Bug #953)
- Do not append_sid to links in feed.php (Bug #952)
- Add a short explanation for the permission cases (Bug #951)
- Fix automated subscription when uploading images (Bug #925)
- Fix overwriting of core language keys and other language stuff (Bug #944)
- Fix "Undefined variable: umil" in TS convertor (Bug #948)
- Fix background of the image-size line on thumbnails (Bug #946)
- Can not select a member when creating personal gallery in ACP (Bug #950)

## [1.1.5] - 2012-02-28
### Changed
- Display the album in RRC, if the user manually set it (Bug #932)
- Change the sorting of the rate when the winner is chosen by sum (Bug #928)
- Add template variable for the unread status of an album (Bug #923)
- Increase maximum imagename length to 128 characters (Bug #903)
- Update manuals should have unique name (more usability in AutoMOD) (Bug #909)

### Fixed
- Fix problem with unsubscribe-link in notifications (Bug #926)
- Fix sorting options in MCP (Bug #939)
- Adding an array of albums to the block does not work correctly (Bug #931)
- Fix ampersands in notification-mails (Bug #924)
- Order personal gallery by username in the albumbox (Bug #922)
- Hide personal album module when user has no permissions (Bug #918)
- Undefined PERSONAL_GALLERY_PERMISSIONS in viewonline integration (Bug #917)
- Undefined offset: 0 while editing when rotating is disabled (Bug #920)
- Fix various xHTML issues (Bug #916)
- Fix version tag set to phpbb_gallery_dev (Bug #915)
- Load gallery button everytime the bbcodes are displayed (Bug #912)
- Gallery user info not visible in PM view (Bug #905)
- Model not displayed in EXIF data (Bug #913)
- Handle transparency on unresized images correctly (Bug #792)
- Unknown column 'report_id' in 'where clause' while closing reports (Bug #907)
- Fatal error: Call to undefined method read_exif_data() (Bug #906)
- Call to undefined method phpbb_gallery::redirect() (Bug #896)
- Logic-error contests #2: Hide contest images from users profile (Bug #897)
- Do not display usernames in contests (Bug #899)
- Do not loose selection of auth_access when editing an album (Bug #895)
- PHP Notice Undefined index album_user_id when editing album in UCP (Bug #893)

## [1.1.4]
### Fixed
- Ensure that no child album is selected as parent album (Bug #891)
- Add publish date to feed (Bug #890)
- Error in_array() expects parameter 2 to be array on block album option (Bug #889)
- Ensure that all config keys are set to a correct value (Bug #884)
- Completly fix the popup-smilies-issue from ticket/875 (Bug #885)
- Fix can not set comment length in ACP (Bug #883)
- Fix use of undefined constant GALLERY_ROOT_PATH in ACP logs (Bug #882)

## [1.1.3]
### Changed
- Add option to hide the update advice for a week (Bug #879)
- Rename submit button on first upload step to "continue" (Bug #878)
- Add option to open image-links in new tab (Bug #877)
- Fix inconsistent naming of a_count and a_unlimited permissions (Bug #865)
- Remove GALLERY_ROOT_PATH constant (Bug #863)
- Add album-feed to feed-list on image_page (Bug #873)
- Allow embeding two different blocks on the same page (Bug #874)

### Fixed
- "Instant Redirect" breaks album information update on upload (Bug #881)
- Fix two little bugs in html code of ACP (Bug #880)
- Hide name of uploader on feeds for contest albums (Bug #876)
- Fix inserting smilies from popup into image description (Bug #875)
- Fix invalid feed format (Bug #870, #871)
- Add links to feeds, when they are enabled (Bug #869)
- Fix rating not possible in subsilver2 (Bug #868)
- Fix Undefined variable: image_id_id_ary when removing favorites (Bug #864)
- Fix typo in language packages (Bug #867)
- Correctly link back when deleting the personal main album (Bug #866)
- Remove ../ parts from the url when gallery is besides the forum (Bug #862)

## [1.1.2]
### Changed
- Make phpbb_gallery_config easier to extend for plugins (Bug #852)
- Require phpBB 3.0.9 so we can clean the function_phpbb.php file a bit.
- Check phpBB and php version requirements during install/update
- Use a button instead of a text link for inserting the images from the popup
- Populate path and ext variables for MODs that added include() (Bug #845)

### Fixed
- Fix also display BBCodes for images, when comments are disabled (Bug #860)
- Fix various errors in the new upload process (Bug #859)
- Do not display "Add more upload fields" link for limit=1 (Bug #858)
- Add option for displaying the thumbnail for next/prev image links (Bug #857)
- Fix "Column 'image_desc' cannot be null" error with outdated style (Bug #856)
- Fix Undefined class constant 'REPORT_UNREPORT' (Bug #853)
- Fix quote option on (recent) comment search (Bug #851)
- Fix display of the input-boxes when the page is less than 1024 pixels wide
- Fix several usages of old constants in convertor scripts
- Fix pruging the "cache", the correct path is thumbnail
- Fix quick-moderation language in image_page, when comments are disabled
- Fix typo in table name: Use of undefined constant GALLERY_CONTEST_TABLE
- Error in block: Always reset the mode and display when the function is called
- Correctly install cleanup module in ACP
- Fix debug error messages in acp config when functions are disabled (Bug #850)
- Personal Gallery icon does not appear on viewtopic (Bug #847)
- Do not try to use plugins on upload, when none is installed (Bug #843)
- Breadcrumb link from moderation-overview leads to album_id=0 (Bug #842)
- Purge permissions cache when deleting permissions (Bug #841)
- Store exif data when we set the status to saved in database (Bug #840)
- image-page displayes wrong data for uploader (Bug #839)
- Fix error when deleting comments (Bug #838)
- Fix contests with undefined constant and undeclared property (Bug #837)
- {NUM}-explanation missing on ACP import (Bug #836)
- Fix typos in de-package and rephrase a string in en-package (Bug #834)
- Undefined class constant 'DB_SAVED' (mistyped DBSAVED) (Bug #833)
- Fix error while editing a contest-album (Bug #832)
- SQL Error when reseting rating of an empty album (Bug #831)
- Correctly state, which folder needs to have the CHMOD in install/ (Bug #830)
- Code for pruning is not working and the lang-string is missing (Bug #829)
- Fix code for hotlink prevention (Bug #828)

## [1.1.1]
### Fixed
- Fix copy operations in XML files (delete and add some directories) (Bug #827)
- PHP Warning: in file /includes/gallery/user.php on line 334: Invalid argument supplied for foreach() (Bug #826)
- Index name ... on table ... is too long. The maximum is 24 characters (Bug #825)

## [1.1.0]
### Added
- Add zip-upload feature (Feature #426)
- Add popup to phpBB/posting.php with own and recent images aswell as an upload option (Feature #421, #446)
- Add option to go to next image when clicking on image_page (Feature #798)
- Add friends and foes control to personal galleries (Feature #749)
- Use "Last-Modified"-header to cache images in browser (Bug #747)
- Add option to quote a comment (Feature #744)
- Add option to change contest winner tabulation (Feature #730)
- Add option to allow changing the "uploaded by"-information (Feature #729)
- Add option dis-/enable the signature on comments (Feature #719)
- Add option to create personal gallery for users in ACP (Feature #714)
- Add option for uploader to disable comment for images (Feature #704)
- Add option to prune albums manually in the ACP (Feature #680)
- Add recently reported and unapproved iamges to MCP-Index (Feature #437, #658)
- Add RSS/Atom Feed for new images (Feature #312)

### Changed
- Rewrote the upload part, so it's easier to name and describe the images (Bug #809)
- phpBB Gallery Integration throws errors while installing/updating the board (Feature #801)
- Change install to use UMIL for database changes (Feature #788)
- Make image description invisible until the end of contest (Feature #718)

### Fixed
- Jumpbox allows jumping to invalid albums (Bug #823)
- Restrict autoloader to gallery classes (Bug #821)
- User option for blocks not working correctly (Bug #820)
- Add missing quick moderation to subsilver2 (Bug #817)
- Error when testing user permissions (Bug #818)
- Gallery throws error when there are permissions for deleted albums (Bug #816)
- SQL Error on gallery block when user has no permissions (Bug #812)
- SQL-Error for MSSQL when trying to rate an image (Bug #791)
- Several typos, wordings and wrong quotation-marks (Bug #789, #799)
- Change error handling on upload-page to continue after corrupted files (Bug #781)
- Remove confusing message about number of upload-fields (Bug #767)
- Resync contest winners, if a winner get's deleted (Bug #751)
- Call garbage_collection() to free some memory before viewing images (Bug #696)

## [1.0.x] - 2009-2012
*Note: Releases 1.0.3, 1.0.4, 1.0.5, and 1.0.5.1 were minor maintenance updates without specific documented changelogs in the dump.*

## [0.4.1] - 2008-12-23
### Added
- Display the number of ratings received (Report #386)
- Prev- and Next-Button on album.php (Patch by Dr.Death) (Report #383)

### Changed
- ACP-Option for the link-to-click on image-page (Report #390)
- Collapse recent comments on recent-body (Report #371)

### Fixed
- "Duplicate entry '1'" on resync image counter (SVN) (Report #399)
- Unable to completely disable Rating and Comments - wrong variables (Report #397)
- Images stays reported, when report is closed (Report #393)
- Undefined index: comment_comment_username (Report #396)
- Not viewing rates on own images (Report #391)
- Animate and Transpate gif's unsopported on image_page
- Timestamp-Fix for 3.0.4
- Save files with correct name, when downloading
- resync doens't create entry for p_g_users-table (Report #388)
- invisible comments after editing comment (Report #382)
- double checks for same auth => made static (Report #381)
- deleted Mod-Group still shows up (Report #369)
- No Info on album-page when image is locked (Report #376)
- Images might have non-natural image-size (Report #375)
- status of missing files not reset on clean-up (Report #373)
- Reported topics show gallery-css (Report #374)
- Warning: readfile() has been disabled for security reasons (Report #380)
- Thumbnails on recent comments open with wrong adjustment (Report #379)
- Missing lang-string for EDIT_COMMENT (Report #377)
- Undefined variable: lastimage_uc_thumbnail (Report #384)
- installation and conversion missing "module_auth" (Report #385)
- Call to a member function bbcode_second_pass() on a non-object in gallery/image_page.php
- Missed to use gallery_root_path on add-on

## [0.4.0] - 2008-11-20
### Added
- Medium thumbnails to display on image_page.php (Report #252)
- Require permissions for the ACP-modules (Report #309)
- Show newest comments and a random picture on index page (Report #144)
- Image URL on gallery_page_body.html (Report #266)
- disable watermark by permissions (Report #317)
- Show "Personal galleries" as an category on index page (Report #142)
- Slide/Dia Show (Report #303)
- Automatically resize uploaded images (Report #95)
- New permission: "See album" (Report #320)
- Split moderation-permissions (Report #346)
- Remind users on editing the includes/constants.php (Report #357)
- Link configuration for thumbnails/image_names/lastimage-icon (Report #345)
- Add BBCode-Buttons and smilies (subsilver2) (Report #356)

### Changed
- gallery/upload/cache/ to gallery/images/cache/ and gallery/upload/ to gallery/images/upload/
- moved import/ to images/import/
- moved thumbnail creation to image.php (Report #252)
- Lytebox-Update from 3.20 to 3.22 (Report #349)
- Reorganize subsilver2 layout of image_page.php (Report #356)
- better convert-instructions (Report #350)
- better Search-Code for second session edit
- Searchcode for total-images changed (Report #354)

### Fixed
- Cut down long albumnames in recent/random and in search
- Install-Script misses Constants like GALLERY_ROOT_PATH (Report #363)
- Moderator-link visible without permissions (Report #359)
- wrong headline for "manage subscription"
- .JPG-images from conversion are not visible (Report #358)
- Pagination on manage subscription leeds to favorites (Report #361)
- Add Custom BBCode-Buttons (prosilver) (Report #356)
- installer not working on version compare for mysql (Report #360)
- SQL-Error when user is in no group => copy phpBB solution (Report #348)
- BBCode colorPalette needs images/spacer.gif (Report #351)
- install/install_*.php Undefined variable: exists (Report #355)
- U_GALLERY_MOD not usign GALLERY_ROOT_PATH on install (Report #352)
- Missing update of session, after unset($sql_ary['session_album_id']); (Report #353)
- STAGE_COPY_TABLE_EXPLAIN is german (Topic #883)

## [0.4.0-RC3] - 2008-11-08
### Added
- Upload-Link in the UCP (Report #343)
- Jumpbox to the image_page.php
- Display message after successful resync in the ACP

### Changed
- Problem with number of views (Report #339)
- Able to approve own images (Report #338)
- Remove file-type on image-name (Report #334)
- Move Images into personal albums (Report #299)

### Fixed
- Language-Vars for Permissions (Report #344)
- undefined function make_album_select (PM #524)
- Missing note "waiting for approval" (Report #342)
- inconsistent language packages (Topic #797)
- Exif-Data: "ExposureBiasValue", "Flash", "ExposureProgram" & "MeteringMode"
- PostgreSQL: sql_query using hard LIMIT (Report #341)
- SQL-Injection on sort-method (Report #i337)
- Meta-Refresh after rating is phpBB2-Style
- ACP Import multiple pages loose image-name (Report #332)
- Long file names with _ making out of templates problem (Report #322)
- Wrong labels for config values in ACP
- error in SQL syntax (Report #319)
- uploading multiple files cheats on quota (Report #326)
- mcp.php missing check for permissions (Report #i328)
- Slow loading page when creating albums-list (Report #323)
- wrong class for the MOVE-Button
- Unknown column 'username' in 'order clause' (phpBB.de-p1022203)
- Unable to Approve and Unapprove images (Report #311)
- Convert Smartor - Comments (Report #308)

## [0.4.0-RC2] - 2008-08-21
### Added
- Exif Data: Exposure bias, Exposure program & Metering mode

### Changed
- After upload an image into a approval album, the redirect is too fast (Report #283)
- Login on and redirect to gallery/index.php (Report #297)
- Module handle on installation

### Fixed
- Display of users online in the album
- highslide moved to template (Report #307)
- user_images not updated if it was empty (Report #306)
- Empty posintg.php No values specified for SQL IN comparison (Report #305)
- some bugs in subsilver2 only (Report #290)
- Blank image_page.php page (Report #289)
- [phpBB Debug] PHP Notice: in file /includes/acp/acp_gallery.php on line 296 (Report #304)
- view unapproved images to moderators
- Lang missing in search (Report #286)
- Missing information for new approval images (Report #302)
- Unknown column 'g.view_personal_albums' in viewonline.php (Report #288)
- wrong permissions used on viewing personal-gallerys link (Report #301)
- some language typos (Report #285)
- "NV Exif data" security risk (Report #i295)
- [album] wrong url for thumbnail (Report #300)
- Posting Comment/Image: No values specified for SQL IN (Report #296)
- array_merge(): Argument #2 is not an array (Report #284)
- Undefined index: album_approval (Report #282)

## [0.4.0-RC1] - 2008-08-09
### Added
- Installer/Updater for older versions (Report #261)
- Button/Redirect after installation (Report #245)
- Number of maximum images (Report #189)
- Limit total number of images by group (Report #267)
- Display thumbnail on album-list
- album image (Report #31)
- Meta refresh on Moderating (Report #185)
- Report Image (Report #241)
- Display Exif-Data if available (Report #280)
- Red-Image-Counter for MOderators (unapproved images)
- Cleanup-Page, idea on DB after delete of a user (Report #239)
- MOD supports "MOD Version Check" by handyman
- Filled the Statistic-Page in the ACP
- MOD supports "HighSlide Attachment & IMG" by stokerpiller

### Changed
- Hide "Your Personal Album" link (Report #246)
- MODx v1.2.0
- Permission-System
- Album-System (much faster now)
- Rewrote ACP-Import (Report #181, #165, #233)
- Moved some Variables to _albums and -images to increase SQL-Speed and reduce number of SQLs
- Reject album deletion leads to 'empty' UserCP page (Report #263)
- Rewrote the hole MCP

### Fixed
- Repeat Bug 228: 0.2.3 to 0.3.0 upgrade won't update version (Report #258)
- Call to undefined function adm_back_link() (Report #260)
- viewonline broken (Report #259)
- bbcode is missing GALLERY_ROOT_PATH (Report #262)
- posting.php != S_IN_GALLERY (Report #264)
- Anonymous comments possible at private albums (Report #254)
- icon buged on rtl (Report #265)
- don't create albums without names
- utf8 in file name on Import (Report #179)
- wrong permissions on testing user-premissions (Report #128)
- Comment Char limit (Report #191)
- bbcode [list] bugged in image_page.php
- Add option to disable watermark for small images

## [0.3.2-RC1 & 2] - 2008-06-05
### Fixed
- Installer/Updater for older versions (Report #261)
- Button/Redirect after installation (Report #245)
- Number of maximum images (Report #189)
- Limit total number of images by group (Report #267)
- Hide "Your Personal Album" link (Report #246)
- Repeat Bug 228: 0.2.3 to 0.3.0 upgrade won't update version (Report #258)
- Call to undefined function adm_back_link() (Report #260)
- viewonline broken (Report #259)
- bbcode is missing GALLERY_ROOT_PATH (Report #262)
- posting.php != S_IN_GALLERY (Report #264)
- Anonymous comments possible at private albums (Report #254)

## [0.3.1] - 2008-04-14
### Fixed
- mcp "select all" (Report #150)
- select multiple images for delete (Report #166)
- wrong prev and next images (Report #257)
- KiB not KB (Report #247)
- rel="lightbox" in subsilver2 (Report #235)
- Undefined variable: sort_new_comment_option (Report #251)
- Undefined index: cat_approval (Report #256)
- Sessionhandling of 3.0.1 (Report #253)
- Old Link in Installer Footer (Report #242)
- non strict sql (Report #243)
- Misspelled Information after successful Installation (Report #244)
- image size on massimport when disabled (Report #248)
- Potential exposure of real path when unlinking files (Report #250)
- When deleting album in subsilver2, language not shown (Report #240)
- When editing image 'Title' box isn't populated (Report #249)
- Option when create a module for UCP (Report #237)
- Undefined variable: album_config (Report #236)
- upload and move images to personal albums (Report #225)
- Undefined index: IMG_BUTTON_UPLOAD_IMAGE (Report #223)
- wrong permissions used on displaying moderating options (Report #226)
- Gallery link on breadcrumbs in viewonline.php (Report #227)
- viewing all albums in jumpbox (Report #230)
- 0.2.3 to 0.3.0 upgrade won't update version (Report #228)
- Can't edit or delete comment in subsilver2 (Report #229)

## [0.3.0] - 2008-03-06
### Fixed
- Missing Lang: IMAGE_BBCODE (Report #167)
- Resize image in image view page (Report #138)
- Undefined variable: sort_new_comment_option (Report #172)
- [ACP] missing radio and checkbox classes (Report #173)
- Move images are not working anymore (Report #175)
- Deutsche Sprache: Gallery/Galerie (Report #163)
- View the last MESSAGE? (Report #182)
- Album categorie - don't show "no pictures" (Report #176)
- Comment (Report #190)
- no personal images in recent images (Report #194)
- MCP link 2 times (Report #188)
- MCP - Delete images are not working anymore (Report #196)
- personal gallery of xxxx - PHP Notice error (Report #198)
- gallery/index.php - SQL Error (Report #199)
- Truecolor+alpha channel watermark (Report #200)
- install.xml - Description typo (Report #202)
- root/gallery/index.htm loaded instead of index.php (Report #203)
- No more albums to move (Report #186)
- {memberrow.ALBUM_FOLDER_IMG_SRC} (Report #169)
- Personal Albums - Next / Previous Links (Report #174)
- Reduce SQL phpbb_users left join (Report #195)
- Personal Gallery Index - User colour are not showing (Report #197)
- members should have the ability to create an album (Report #149)
- Also show new personal images on index page (Report #143)
- permissions for creating subalbums (Report #208)
- display nav-link when using recent_image addon (Report #207)
- personal albums - ucp - move subulbums error (Report #210)
- Multiple Upload (Report #212)
- imagecreatefromjpeg(./..//gallery/upload/.jpg) (Report #178)
- SQL Error on convert (guest comments) (Report #205)
- wrong album link (Report #201)
- Deutscher Sprachbutton (UPLOADIMAGE) (Report #164)
- Personal album permissions are messed up (Report #209)
- Small typo in german language (Report #206)
- personal gallery: empty gallery problem (Report #214)
- edit and delete comments (Report #15)
- Should not update session page on thumbnail view (Report #215)
- upload error lang (Report #192)
- Persönliche Galerie verlinken (Report #168)
- Album BBcode - mark in one click (Report #216)
- move pic from private subalbum not possible (Report #213)
- categorie - last image are not shown if disapproved (Report #177)
- Seitenauflistung in der "Wer ist online?"-Liste (Report #211)
- Optional black info line at bottom (Report #126)

## [0.2.3] - 2008-01-25
### Fixed
- Watermark: Call to undefined function: imagecreatefromjpeg() (Report #62)
- Add gd_info function check into the installer (Report #90)
- bbcode (Report #100)
- Browsing Gallery while [ Test out user’s permissions ] (Report #102)
- styles/prosilver/imageset/icon_topic_latest.gif (Report #120)
- missing upload-line in subsilver2 (Report #121)
- missing mass-upload modul (Report #122)
- Better remove thumbs.db (Report #124)
- pers. album: default sort gives error messages (Report #125)
- missing {S_FORM_TOKEN} in subsilver2 (Report #127)
- missing "yes" in subsilver2 on delete-confirm (Report #130)
- UTF is absent (Report #131)
- Wrong premission to Anonymus (Report #132)
- Unknown column 'username' in album_personal.php (Report #135)
- Gallery is open when board is disabled (Report #137)
- not valid (Report #139)
- double entry for gallery index in navlinks on upload page (Report #140)
- language attribute in <script> tags (Report #141)
- confusing default: category (Report #145)
- Unknown column 'rating' in 'order clause' [1054] (Report #148)
- Missing form around rating in subsilver2 (Report #153)
- Last image sorting not working (Report #157)
- colour username on personal gallery empty (Report #158)
- english typo: Thias file type is not allowed (Report #159)
- dead link on image comment (Report #160)
- empty error message on gallery/album.php (Report #161)

## [0.2.2] - 2008-01-08
### Fixed
- Column 'comment_edit_time' cannot be null (Report #63)
- Zip Upload (Report #65)
- Unknown column 'pic_time' in 'order clause' [1054] (Report #66)
- Album permissions not saved (Report #67)
- Subalbums not visible (Report #68)
- Images in subalbums not counted (Report #69)
- modcp - old var "cat_id" (Report #70)
- lock / move links to modcp are using not image_id (Report #71)
- modcp : moving images not possible (Report #72)
- lang var error : MOVE_TO_CATEGORY not exists (Report #73)
- lang var missing: LOGIN_EXPLAIN_UPLOAD (Report #74)
- Update: Column 'comment_edit_time' cannot be null (Report #75)
- PIC_TITLE not defined (Report #76)
- No recent images (Report #77)
- Column was set to data type implicit default (Report #78)
- Gäste Berechtigung wird nicht gespeichert (Report #79)
- value "array()" on bbcode-texts (Report #80)
- last edit username is not coloured (Report #81)
- Upload Button is not showing correct in RC8 (Report #82)
- Remove personal gallery link when logged out (Report #83)
- There is no more categories which you have permisson to move images to (Report #84)
- Error message when deleting a image (Report #85)
- Album Permissions 0.2.1 (Report #86)
- Undefined variable: tot_unapproved on album.php (Report #91)
- Incorrect cuting symbols in album_personal_index.php (Report #94)
- $sort_new_comment_option = ''; missing (Report #96)
- Mass-upload in ACP (Report #99)
- subsilver2 (Report #101)
- album.php missing $ (Report #103)
- last_pic in personal_album on sort (Report #105)
- Errormessage when trying to approve Pictures (Report #106)
- next and previous image (Report #107)
- thumbnails error if cache is deleted (Report #108)
- Links to Albums on Gallery Index are not shown (Report #109)
- Image_page.php throws out some php notices... (Report #110)
- Open the latest picture of a album: php notice error (Report #111)
- image_page.php : next/previous error with disapproved pics (Report #112)
- Undefined variable: auth_data (Report #113)
- Images are not counted on gallery index and sub-album index (Report #114)
- MCP - double breadcrumps, wrong usernames of pers. galleries (Report #115)
- Subalbums not included in recent pictures? (Report #116)
- Upload-Button shows no info text (Report #117)
- missing breadcrumbs on empty comment (Report #118)
- if ($auth->acl_get('f_list', $row['album_id'])) (Report #119)

## [0.2.1] - 2007-11-27
### Fixed
- wrong parse of bbcode on install.php (Report #64)

## [0.2.0] - 2007-11-27
### Fixed
- which word to use (Report #47)
- missing constants in acp (Report #48)
- Cannot use a scalar value as an array (Report #49)
- missing german button (Report #50)
- Sub-Albums (Report #51)
- IP false on smartor (Report #52)
- Error from deleting L_ - Helmut (Report #54)
- installer wrong column_name (Report #55)
- includes/acp/acp_gallery.php: Cannot use a scalar value as an array (Report #56)
- Deleting last album error (Report #57)
- Personal Album - Undefined index: pic_desc_bbcode_uid (Report #58)
- Installer forgot to activate the new modul "personal album permission" (Report #59)
- MySQL-Fehler wenn man im ACP Alben managen will (Report #60)
- [HARD] 'U_GALLERY' (Report #61)

## [0.1.3] - 2007-11-27
### Fixed
- [Security] $album_root_path (Report #1)
- [np] image_delete.php (Report #3)
- $phpbb_root_path = '../'; (Report #4)
- class="row1" is no more... long live bg (Report #5)
- gallery/upload.php store ip (Report #6)
- Wenn man im persönlichen Album ist und ein Bild sperren möchte (Report #7)
- xhtml strict album_personal.php (Report #8)
- Problems with UTF8 --> ae ue oe --> ?? ?? ?? (Report #9)
- xhtml strict styles\subsilver2\template\gallery_album_body.html (Report #10)
- gallery\includes\common.php (Report #11)
- BB-Codes für Kategorie-Beschreibung (Report #12)
- </from> in ACP (Report #13)
- edit the text on a photo (Report #14)
- $board_config is no more.... (Report #16)
- Image details on thumbnails (Report #17)
- wrong redirect to album_cat if image aproval enabled (Report #18)
- ACP permissions.... (Report #19)
- Groupname of Special Groups are "wrong" (Report #20)
- UTF8 support in acp_gallery and addslashes... (Report #21)
- Better Coding guidelines.... (Report #22)
- personal album not working if set permission to "privat" (Report #23)
- [Security] if (!defined('IN_PHPBB')) missing in languages (Report #24)
- Login Box on gallery index not working (Report #25)
- Logical error in album_personal.php (Report #26)
- ACP - gallery permission bug (Report #27)
- acp_gallery.php missing language vars (Report #28)
- its the otherway round with "L_" (Report #29)
- wrong links on "album_personal_index.php" (Report #30)
- watermark (Report #32)
- Manage Album - Error on submit (Report #33)
- Wrong navigation links in personal albums (Report #34)
- MCP - Missing lang vars if no cat was specified (Report #35)
- Missing navigation links in several files (Report #36)
- BB-Codes für den Rest (Report #37)
- the installer (Report #39)
- the updater (Report #40)
- Missing the Keys on the Installation (Report #41)
- Comments and Rating of Images are not possible! (Report #42)
- reparse bbcodes on image edit (Report #43)
- smiles in pic description brakes the style on gallery/album.php (Report #44)
- same as Report44 but on recent pics and personal album (Report #45)
- colour the usernames (Report #46)
- UTF-8 compatible? (Report #53)
