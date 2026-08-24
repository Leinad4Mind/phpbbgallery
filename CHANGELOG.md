# Changelog

All notable changes to the phpBB Gallery extension suite are documented in this file.

## [4.2.0] Unreleased

### Added

- Added private Microsoft OneDrive storage restricted to the application's `approot`, using delegated `Files.ReadWrite.AppFolder` access, refresh-token authentication, resumable Microsoft Graph upload sessions and verified private downloads.

## [4.1.0] - 2026-08-24

### Added

- Added provider selection per stored image variant, allowing source, medium and mini files to remain local or use the enabled Remote Storage provider independently, with resumable migrations preserving the previous global assignment by default.
- Added independent, parent-scoped pagination for root albums, each category, subalbums and the personal-album directory, with optional progressive navigation, History API support, scroll preservation and phpBB-native page-jump controls.
- Prefixed every EXIF entry in mixed card-information selectors with `EXIF:` so add-on metadata remains immediately distinguishable from Core image properties.
- Added independently selectable image type and cached EXIF values to the contextual card-information settings for album listings, searches, Gallery-index blocks, forum-index blocks and user profiles; individual image-page switches remain separate, and private metadata continues to follow the Core visibility policy.
- Added an independently configurable WebP encoding quality, defaulting to 80 and applied to existing WebP transformations and Core-generated WebP derivatives; WebP and AVIF quality controls remain available when new uploads of those formats are disabled.
- Added composable Image Fields validation rules for textual metadata: minimum/maximum or exact character counts, required beginnings/endings, common Unicode-aware formats and bounded custom PCRE expressions enforced consistently across upload, editing, import and MCP Mass Edit.
- Added an independently bounded forum-index block that aggregates recent images from every visible personal album, preserving Gallery permissions, friendship restrictions, moderation visibility and ignored-user exclusions without listing each personal album separately.
- Added an independent ACP switch for displaying the original image file type on individual image pages, enabled by default to preserve existing behaviour.
- Added a distinct Updated Core ACP provenance marker for Gallery 3.4.0 settings whose choices or behaviour were expanded by the modern Core, using a refresh badge and separate accent; provenance legends now group New Core and Updated Core first, followed by alphabetised free add-ons and then alphabetised premium add-ons.
- Added a permission-filtered Gallery statistics page linked from the index, with lifetime and tracked annual summaries plus an explicit pre-tracking historical period and rankings for most-viewed images, most-downloaded originals, users with the most images and users with the most downloads; bounded yearly aggregates avoid individual access logs, and BBPoints Images imports recoverable historical counters without inventing unavailable yearly attribution.
- Added per-parent Hide, Text and Icons presentation modes for eligible direct subalbums, applied consistently to Classic, Modern, Cards and Futuristic layouts without extra queries and retaining text links for subalbums without a configured icon.
- Added an optional ACP-controlled real image-ID badge to every Gallery card layout; selecting it copies the installation's canonical `[image]` or `[galleryimage]` BBCode with accessible visual confirmation and an HTTP-compatible clipboard fallback.
- Added a fourth Futuristic Gallery presentation with shared permission-safe album and image components, responsive glass-style grids, accessible focus and reduced-motion behaviour, and distinct restrained variants for PROSILVER, BBOOTS and FLATBOOTS while preserving Favorite, rating, moderation and add-on metadata events.
- Added large, responsive and keyboard-accessible Font Awesome previous/next controls when navigation thumbnails are disabled, while retaining the adjacent image names for tooltips and assistive technology.
- Added a persistent Off mode beside the Simple and Complete ACP provenance views, removing in-field badges, accent colours and setting markers while keeping every effective setting visible.
- Added a distinct New Core ACP provenance marker for every configuration introduced after Gallery 3.4.0 and for the new album-icon selector, using a star and Core accent while preserving puzzle identities for add-ons in both Simple and Complete views.
- Added permission-filtered, lazily loaded album BBCodes with in-post pagination: clean boards use `[album]`, while boards whose legacy or unrelated `[album]` definition must be preserved use `[galleryalbum]` and receive an explicit activation notice.
- Added the independently packaged premium Image Fields add-on with translated administrator-defined metadata, seven validated field types, inherited album scopes, public/author/moderator visibility, multi-value search, resumable upload and edit integration, MCP Mass Edit support, ACP Import defaults, Export manifests and permanent-deletion cleanup.
- Added a moderator-only batch image editor for the current MCP album page, with per-image title, subtitle and BBCode description fields, bounded {NUM} sequencing, CSRF protection, complete-post validation and atomic fail-closed persistence.
- Added a read-only **View Gallery permissions** page under the native ACP Permission Masks category, comparing one or more selected public albums or a personal-album scope in phpBB's native category layout; effective booleans use only Yes/Never, numeric limits retain their value, and per-permission tracing shows every contributing group and direct-user setting.
- Added a confirmed Gallery-index toggle to subscribe to or unsubscribe from every currently visible real album, including subalbums, with permission, personal-album and zebra filtering plus bounded writes for large galleries.
- Added canonical Open Graph and Twitter Card metadata to permission-checked image pages, using the public medium image and share-safe URLs without session or style context.
- Added a consolidated Gallery-index image-block selector with independent limits for recent, random, most-viewed and top-rated images, permission-safe ranked queries and neutral extension points for add-on modes.
- Added a selectable Gallery presentation shared by PROSILVER, BBOOTS and FLATBOOTS, applying the classic MOD-inspired layout, the responsive modern list or modern cards consistently to the Gallery index, nested subalbums and image grids such as recent, random and search results without changing album data or permissions.
- Added a visual second-step image transformation editor with live previews, composable left/right/180-degree rotation, horizontal/vertical flipping, batch application, automatic JPEG EXIF orientation correction and fail-closed protection for animated GIF and multipage TIFF sources.
- Added a conditional Imagick diagnostic to the Core ACP whenever the TIFF add-on package is present, validating the PHP extension, bounded resource APIs, TIFF decoding and WebP encoding without presenting Imagick as a Core requirement.
- Added accessible contextual-help dialogs to every Gallery ACP resynchronisation and cache operation, explaining what each repair changes, when it is appropriate and when routine Gallery behaviour already keeps the data current.
- Added a browser-persisted Simple/Complete ACP view switch for add-on-supplied settings: Simple keeps the compact top colour legend and a colour-only explanation while hiding repeated inline badges, while Complete also retains the inline puzzle badges and full explanatory text.
- Added shareable GET-based Gallery searches with explicit query summaries, in-result refinement, safe state-preserving sort forms and a complete Forum index -> Gallery -> Search breadcrumb.
- Added permission-checked, bounded username autocomplete to Gallery author search and moderator-only alternate-author uploads, while retaining the wildcard and phpBB member-search fallbacks.
- Added a permission-filtered total-image statistic to member profiles, hidden when no images are visible and linked to a search for all visible images by that member; FLATBOOTS presents it beside its post and topic timeline statistics.
- Added accessible ACP identities for settings supplied by installed add-ons: mixed Core forms now show a puzzle badge, a consistent per-add-on accent and a translated legend without relying on colour alone.
- Added selectable image resolution to thumbnail metadata, persisted source dimensions for new uploads and imports, and a confirmed 25-image ACP resynchronisation for legacy or remote files; a neutral album-card metadata extension point lets BBPoints Images expose optional original-download counters without coupling the Core to the add-on.
- Added a privacy-first browser toggle for privileged Gallery IP displays: every visible IP starts blurred, one click reveals or hides all IPs, and the preference is retained in local storage.
- Added permission-aware inline AJAX rating stars to album cards; own images, previously rated images and images outside the effective rating permission show no rating link or control.
- Added independent per-album permissions for original-file downloads and charge-free original access, initialised from existing image-view roles during the upgrade while keeping the charge bypass denied.
- Added accessible star-only AJAX rating controls to FLATBOOTS and prosilver, with CSRF-protected POST submission, permission revalidation and no page reload.
- Made Favorite controls update their icon, label and inverse action over AJAX in album listings, Gallery search results and image pages, including after progressive AJAX image navigation.
- Added responsive album information panels matching FLATBOOTS viewforum, with online users, effective album permissions and a neutral third-party rules area populated by BBPoints Images.
- Added permission-aware AJAX favorite hearts to every bounded image-card listing, including albums, search results, recent, random, featured, top-rated, most-downloaded and contest-winner blocks, loading each result set's favorite state in one query through a neutral Core extension event and allowing administrators to keep listing controls disabled.
- Added a Unicode-aware live character counter to Gallery comment forms in every bundled style, driven by the ACP comment limit and reinitialised after AJAX image navigation.
- Extended indexed EXIF DateTimeOriginal sorting to Gallery searches while retaining upload-date fallback, previous/next navigation and ACP defaults.
- Added an optional multi-image upload control that applies the first image's BBPoints contributors to the complete batch, with synchronized locked editors and server-side enforcement.

### Changed

- Reworked mixed category/album indexes so each parent owns its album limit and pagination, category conversions preserve existing Gallery permissions and premium album policies, and every bundled layout keeps totals and controls beside the group they describe.
- Unified Gallery pagination with phpBB's native pagination semantics and controls across Core, moderation, search, UCP Favorites and Contests while retaining non-JavaScript navigation as the baseline.
- Removed the unused legacy slideshow template and language contract; a future slideshow will be implemented as a permission-aware feature instead of reviving the dead `U_SLIDE_SHOW` placeholder.
- Corrected the ACP album-management introduction to describe real categories, albums and nested subalbums, including upload behaviour and the need to configure permissions for newly created albums.
- Renamed the Gallery-index image and comment selector from "Mode" to "Blocks" because multiple blocks can be enabled simultaneously.
- Expanded the automatic-resize help to explain proportional dimension reduction, enforcement of the stored-file size limit and the PHP upload and image-decoding limits that resizing cannot bypass.
- Renamed the multiple-upload setting to “Maximum images per upload” and clarified that it limits one upload operation rather than the total number of images in the album.
- Reworded the random-image performance notice to explain its possible page-loading impact on galleries with many images.
- Explained that linking a member image count affects topics and private messages, opens permission-filtered Gallery search results, and requires phpBB search permission.
- Clarified that the profile item count applies independently to every enabled profile image block.
- Renamed the profile image selector from “Mode” to “Profile image blocks” and scoped its random-query performance notice to members with exceptionally large galleries.
- Clarified that the optional total-image count is displayed in the forum-index statistics rather than an ambiguous `index.php` page.
- Renamed the forum-index image selector from "Mode" to "Blocks" because multiple blocks can be enabled simultaneously.
- Explained that the Gallery-index personal-album switch includes only permission-visible images in its enabled image and comment blocks.
- Renamed the forum-index Gallery image section so its host page is identified before the block content.
- Hidden the inactive rating-scale field whenever the global Gallery rating system is disabled, while preserving its stored value for later reactivation.
- Clarified the Gallery hotlink-protection switch and conditionally hides its allowed-domain list whenever unrestricted external embedding makes that list inactive.
- Clarified that disabling the global Gallery comment system hides comment posting, existing comments, counts, comment-based discovery and per-image controls without deleting stored comments.
- Clarified that the forum-index display selector applies to every card in all enabled Recent, Random and Personal-album Gallery blocks.
- Reorganized the Gallery-index ACP settings into adjacent album/layout and image/comment-block sections while keeping forum-index image blocks separate and preserving all existing configuration keys.
- Clarified that the shared items-per-page limit covers paginated Gallery lists and the recent-comment block on the Gallery index.
- Clarified that the profile display-options selector controls information beneath Recent/Random Gallery thumbnails in user profiles, without renaming the shared selectors used by other image blocks.
- Added distinct accessible help dialogs to the album-level and per-user/group permission-copy selectors, explaining their batch and individual scopes, one-time behaviour and precedence in every supported language.
- Made the album editor role-aware: the parent presentation mode is shown only for albums that contain subalbums, while the child eligibility switch is shown only when editing or creating a real subalbum; intermediate albums correctly expose both controls.
- Limited the selected ACP album-image preview to a proportional 256-pixel bounding box without changing the stored icon.
- Enlarged ACP album-icon choices to a real 48-pixel preview and added a keyboard-accessible three-times hover/focus zoom while preserving each icon's aspect ratio.
- Centred the Font Awesome glyph inside circular Futuristic section markers, including neutralising PROSILVER's inherited pseudo-element spacing.
- Kept recent-image thumbnails in the Futuristic album footer beside the last-image details instead of duplicating them as the album's main visual; explicitly configured transparent album icons now fill their dedicated frame.
- Refined the PROSILVER Futuristic palette with a restrained phpBB blue-to-cyan gradient instead of the previous blue-to-purple treatment.
- Rebuilt album quick search with each bundled style's native compact controls: a magnifying-glass button searches the current album, while a separate cog opens advanced Gallery search with that album preselected and descendant searching enabled.
- Closed the complete post-4.0 Core migration graph with a 4.1.0 terminal marker and aligned the package, version-check metadata and installed Gallery version for direct 4.0.0 upgrades.
- Made the personal-album index switch authoritative: disabling it now removes personal albums, their fallback link and their statistics from the Gallery index, while the remaining section is labelled simply as Albums.
- Reordered the BBOOTS and FLATBOOTS upload form so image selection precedes the optional author and comment controls, and rendered the comment checkbox as one responsive theme-native row.
- Kept the Favorite UCP bulk-action selector and submit button together in one responsive native Bootstrap control in BBOOTS and FLATBOOTS.
- Rendered album-moderation batch actions inside each style so FLATBOOTS and BBOOTS use their native Bootstrap select picker instead of an unstyled Core-generated dropdown.
- Clarified in every ACP language that image viewing covers album listings, individual pages and thumbnail/medium previews, while the download permissions govern original source files and require viewing access.
- Added breathing room around the camera divider, separated checkbox labels, pinned the online ribbon to the comment avatar's top-right corner, placed quick-comment actions at opposite edges and extended the Unicode-aware live counter to image descriptions.
- Reworked FLATBOOTS comments to use the theme's native viewtopic mini-profile, avatar, online-status, metadata and contact layout, with an equal-height desktop action toolbar, a mobile-only compact menu and a correctly labelled Whois icon.
- Moved the BBPoints original-download counter into the image metadata immediately below the view counter in prosilver, BBOOTS and FLATBOOTS.
- Matched the FLATBOOTS image action and Favorite buttons to the larger button size used by the theme's viewtopic toolbar.
- Hid the individual EXIF field switches in the Gallery ACP while EXIF display is disabled, preserving their saved values and restoring them immediately when it is enabled again.

### Fixed

- Made Gallery search return a normal empty result when the current user cannot see any albums instead of passing an empty set into the database abstraction layer.
- Fixed personal-album directory rendering, menu links, page jumps and page-size handling, including cookieless sessions and progressive navigation.
- Preserved album permissions and add-on policies when converting between categories and albums, and allowed ACP move-up/move-down actions to complete directly while retaining confirmation for destructive or resynchronisation actions.
- Corrected remaining card-grid, category-group, thumbnail sizing, long-title, approval-state, MCP navigation and pagination placement regressions across PROSILVER, BBOOTS and FLATBOOTS.
- Centred each album card's image count with its latest-image metadata across the bundled card layouts.
- Kept album pagination totals scoped to the directly listed images and moved the permission-filtered total including subalbums into a separately labelled album-heading summary.
- Corrected the inverted Gallery-index "Collapse comments" option so Yes now starts recent comments collapsed and No leaves them visible in every bundled style.
- Replaced the PROSILVER-only replay of phpBB viewtopic custom-field events on image pages with dedicated Gallery author and comment profile events shared by all bundled styles; optional integrations can now enrich the correct profile context without rendering empty viewtopic-only fragments.
- Restored the native horizontal ACP pagination for the resumable missing-source review in ACP Cleanup instead of rendering its page links as an unstyled vertical list.
- Reset binary image-reader metadata for every source, preview, medium and thumbnail response so persistent workers cannot reuse a previous image's MIME type.
- Centred every Gallery ACP contextual-help dialog in the viewport while retaining responsive size limits and fallback browser support.
- Kept approval and disapproval controls inside each Modern and Futuristic card's metadata area before the album details, preserving centred thumbnails, equal card heights and full-width unapproved cards.
- Prevented images owned by the anonymous Guest account from entering registered-user profile, private-message permission and online-session lookups, avoiding MySQL errors while preserving the stored guest identity.
- Prevented image pages from passing an empty user list to phpBB's permission SQL when an image author or comment author no longer has a matching users-table row, retaining the stored Gallery identity fallback instead of returning HTTP 500 on MySQL.
- Kept the ACP Cleanup missing-source review button readable inside the red storage warning by preserving its black button text across link states.
- Made ACP Import preserve EXIF metadata captured from the original source before resize or conversion instead of discarding it for unmodified imports and rebuilding it on first view.
- Prevented a first-view HTTP 500 after rebuilding legacy or unknown EXIF metadata by completing the nullable status-update return contract; valid cached EXIF metadata now also renders without materialising local or remote originals, while source access occurs only when metadata must be rebuilt.
- Made ACP Cleanup source diagnosis CSRF-protected and resumable in 25-record batches, with paginated provider, key, album, author, publication-state and derivative context plus an explicit restore-before-delete workflow.
- Split distributed-storage status into files ready to migrate, missing source files, already distributed files and invalid keys; migration now processes only actionable files, reports missing sources separately and links authorized administrators to ACP Cleanup without making it a Core dependency.
- Fixed automatic distributed-layout migration and image-dimension synchronization batches being rejected by phpBB when they resubmitted a newly created CSRF form token within the same second.
- Derived album and ancestor new-image indicators from the permission-filtered per-image read tracker, so they now clear automatically after every visible new image has been shown without prematurely marking unseen pagination pages as read.
- Restored Image Revisions activation by keeping its manual lifecycle reconciler aligned with the current revision service dependencies.
- Vertically centred folder icons with their labels in text-mode subalbum links across every Gallery presentation and bundled style.
- Displayed each configured album icon in a centred 48-pixel square in the ACP album tree's visual column, falling back to phpBB's folder icon only when no custom image is configured.
- Mirrored each parent's configured visible subalbum links or icons in the ACP album tree, using one bounded query for all displayed parent rows.
- Prevented the enlarged ACP album-icon preview from being clipped by phpBB's default hidden overflow on form rows.
- Replaced the conflicting global subalbum-icon switch and ambiguous legacy legend labels with an explicit per-parent presentation mode, preserving existing hidden parents and migrating visible parents to text or icons according to their previous global setting.
- Removed the Classic folder-circle background whenever an album has a custom icon and kept transparent SVG artwork transparent, so the configured icon fully replaces the default visual.
- Added an explicit “None” choice, live album-image path/preview updates, reordered controls and validated multi-file uploads to the ACP album icon picker.
- Displayed ACP-configured album icons in a consistent 30-pixel square with a non-disruptive three-times hover and keyboard-focus preview across every Gallery layout.
- Corrected uploaded album icons in every Gallery layout to resolve from the phpBB board root instead of being incorrectly prefixed with the active style or CDN image path.
- Prevented Futuristic and Modern responsive album lists from repeating the same latest-image thumbnail as both the album visual and Last image, while retaining a distinct latest thumbnail for manual covers and contest winners.
- Stacked the compact, padding-free optional copyable image ID at the upper left above each Gallery card title in Classic, Cards and Futuristic layouts; the Futuristic header now uses tighter spacing and left-aligned content, while disabling IDs reserves no space.
- Restored the non-interactive source legend beneath the ACP New Core and add-on explanation, deduplicating the origins present on each page without reintroducing per-source filtering.
- Allowed ACP permission masks to copy from any other selected album or user setting regardless of display order, disabling only the exact target and resolving reciprocal selections from an immutable snapshot.
- Locked the album-type selector when editing an existing contest and removed Contest when editing a regular album, so the ACP no longer offers unsupported conversions while preserving the immutable type and server-side validation.
- Centred thumbnail-free previous and next chevrons within their navigation columns and removed the circular border, background and shadow so only the accessible directional control remains visible.
- Kept the Favorite heart fully inside the Classic image header, reduced it to the compact scale of that presentation and reserved balanced title space so long image names remain centred and unobscured.
- Kept portrait and unusually tall thumbnails inside their configured Classic image cells by giving the flex viewport a definite border-box, clipping overflow and applying an explicit aspect-preserving height limit.
- Prevented contest creation and editing against an outdated Contests schema, replacing a late SQL failure and orphaned album with an actionable pre-save validation error.
- Moved image-sharing URLs and BBCodes to the end of the image details in every supported style, integrated BBPoints contributors into the primary metadata list before EXIF through deterministic extension slots, emphasized FLATBOOTS metadata labels, and restored the missing PROSILVER label for the URL BBCode.
- Made progressive-upload Cancel remove failed or queued entries and release their batch slot, while Reset now aborts the active queue, clears every dynamic field and securely discards the current album's unfinished server drafts.
- Restored the native UCP Favorites layout and pagination containers in PROSILVER, BBOOTS and FLATBOOTS, and stopped favourites from excluded personal albums leaking into the listing after relationship changes.
- Bounded ACP album-icon uploads to 512 KiB and 512 x 512 pixels for raster, BMP and SVG sources, and exposed those limits beside the upload control before an administrator selects a replacement.
- Reclassified the Gallery-managed personal-album profile field so it is no longer presented as contact data, and exposed visible personal albums as dedicated permission- and zebra-filtered profile links for image and comment authors.
- Enforced the strictest effective upload allowance across the configured batch size, remaining album capacity and selected author's quota in both progressive and fallback uploads, counting unapproved images and resumable drafts while displaying the real remaining allowance before selection.
- Matched phpBB's native ACP permission selectors by grouping system groups first and displaying them in bold in both managed and available Gallery group lists.
- Separated published rating-result visibility from permission to submit ratings, so completed contest scores remain visible to every image viewer while active contest results stay protected.
- Fixed EXIF images being treated as displayable while their filtered cache was empty: supported IFD0-only metadata is now rendered, resolution density is preserved, and stale caches are rebuilt from the original source on first view.
- Neutralized prosilver's global icon padding inside Gallery Favorite hearts so the glyph remains visually centred in album and search-result buttons.
- Made progressive image navigation replace only the Gallery image view instead of an invalid document-spanning container, added a smooth reduced-motion-aware transition and prevented post-swap enhancement errors from triggering a second full-page navigation.
- Preserved phpBB's URL-session context on embedded medium images and thumbnails so protected images remain visible in the Favorite UCP and other internal listings on cookieless boards, without adding session IDs to shareable URLs.
- Restored the Favorite UCP module after the Contest extraction by using the Core privacy-policy boundary, loading its navigation title in every supported language and rendering favorites inside the complete UCP layout.
- Kept the member image-export screen inside the complete phpBB UCP layout in prosilver, BBOOTS and FLATBOOTS instead of rendering the module body as a detached page fragment.
- Matched the FLATBOOTS member-profile image count to the theme's normal statistic weight instead of rendering the numeric value in bold.
- Rebased BBTags Images rules throughout an album branch whenever an ancestor policy is saved, immediately removing descendant overrides that became redundant while preserving every effective child selection and unrelated branch.
- Kept content above and below the Bootstrap camera divider clear of its icon with symmetric vertical spacing.
- Translated the original-image download tooltip in every supported language instead of exposing the raw DOWNLOAD_SOURCE key.
- Labelled the Gallery index image statistic explicitly as Images: count instead of displaying the ambiguous count images phrase before total views.
- Kept the Bootstrap comment-length guidance and live counter inline to the right of the submit button on both full and quick comment forms.
- Added the missing spacing between Bootstrap signature checkboxes and their labels in both Gallery comment forms.
- Preserved the native content-driven width and horizontal padding of FLATBOOTS BBCode toolbar buttons while retaining their corrected uniform height.
- Prevented the configured image-page click action from linking to an original file when the viewer lacks the original-download permission.
- Removed request-specific style overrides from copyable full-image and BBCode share URLs.

### Security

- Enforced declared Gallery Core and add-on version ranges before activation, failing closed with translated dependency errors instead of allowing incompatible service contracts to compile at runtime.

### Performance

- Limited album-index work to the visible page of each direct parent group while preserving complete permission filtering, descendant relationships and exact totals, preventing unrelated categories from consuming one shared album limit.
- Kept progressive list navigation bounded to the replaced Gallery section and reused phpBB pagination metadata without introducing an additional client framework.

### Tests

- Added real phpBB functional workflows for ACP Cleanup, ACP Import, EXIF, Favorite, Feed and TIFF on SQLite, MySQL and MariaDB CI jobs.
- Expanded language regression coverage across Core and every packaged add-on, including placeholder parity, forbidden fallbacks and dependency messages in every bundled locale.
- Added regression coverage for the complete 4.1.0 migration graph, per-variant storage routing, native page jumps, parent-scoped pagination, empty visible-album searches and add-on version validation.
- Kept the complete Core unit suite clean on PHP 8.1, 8.2, 8.4 and 8.5, including removal of test-only PHP 8.5 reflection deprecations.

## [4.0.0]

### Added

- Documented the credentials, security model, implementation and service limits of every Remote Storage provider, with a complete Koofr installation and controlled-migration guide.
- Added private 4shared storage using OAuth 1.0 HMAC-SHA1, exclusively owned folders, owner-only objects, recoverable publication and simple or chunked uploads through the documented API v1_2 endpoints.
- Added private Koofr storage over its official fixed HTTPS WebDAV endpoint using revocable application passwords, conditional writes, streamed transfers and strictly bounded metadata parsing.
- Added private pCloud storage for European and United States data regions using OAuth bearer authentication, owned unshared folders, public-link rejection, streaming uploads and validated server-side downloads.
- Added private MediaFire storage using the live Core API 1.5, serialized Session Token v2 signatures, private dedicated folders, SHA-256 Instant/resumable uploads and server-consumed validated direct-download links.
- Added private Box storage with dedicated folders, atomic persistence of single-use rotating refresh tokens, secure signed downloads and simple or chunked uploads.
- Added private Google Drive storage using the non-sensitive drive.file scope, dedicated app-managed folders, resumable chunk uploads and automatic OAuth token renewal.
- Added private Dropbox App Folder storage with short-lived OAuth tokens, protected refresh credentials, resumable large-file upload sessions and controlled provider migration.
- Added optional private SFTP storage with mandatory SSH host fingerprint pinning, atomic temporary uploads, resumable provider migrations and a real OpenSSH functional workflow.
- Added private Azure Blob Storage support with Shared Key signing, ACP-managed connections, resumable remote-to-remote migrations, public-container rejection and an Azurite functional workflow.
- Added a validated Remote Storage provider-factory catalogue so migrations and ACP connection tests can support additional backends without hard-coded resolver branches.
- Added indexed EXIF DateTimeOriginal sorting with upload-date fallback across album listings, previous/next navigation and ACP defaults, including OffsetTimeOriginal handling and a confirmed resumable rebuild for old images.
- Added opt-in BMP uploads through native GD with complete decode validation, preserved BMP originals and browser-safe WebP medium/thumbnail derivatives, including ZIP uploads, ACP Import, replacements and converted album icons.
- Added an optional, permission-filtered unread-image badge beside the Gallery link, backed by the existing global and per-album read markers and capped at 99+ without an unbounded count query.
- Added a fail-closed external image-processor contract and deterministic browser-safe derivative keys, allowing add-ons to retain non-native originals while serving, migrating and deleting their WebP medium/thumbnail variants.
- Added opt-in AVIF uploads when PHP 8.2 or later and GD provide safe AVIF inspection, decoding and encoding, including configurable output quality, browser filters, ZIP uploads, ACP Import, album icons, derived images, rotation, watermarks, cleanup and translations for every supported locale.
- Added the independently packaged TIFF add-on with opt-in TIF/TIFF uploads, bounded Imagick decoding, preserved originals, first-frame WebP derivatives, ZIP and ACP Import support, and translations for every supported locale.
- Added an optional distributed local filesystem layout, including a confirmed, resumable and collision-checked migration from existing flat storage.
- Added a fail-closed pluggable storage-provider contract with verified private workspaces, atomic publication/replacement, checksums, metadata and paginated object enumeration as the foundation for independently packaged remote storage providers.
- Added the independently packaged Remote Storage add-on with private S3 and S3-compatible object storage, AWS Signature Version 4 requests, path-style endpoint support and release-package, version-check and CI integration.
- Added verified Remote Storage ACP configuration in all supported languages, including environment-variable overrides, secret-safe forms and a complete write, checksum, read and delete connection test before settings are saved.
- Added confirmed, resumable and abortable Local-to-S3 and S3-to-Local storage migrations with bounded batches, mirrored writes during the transition, size and SHA-256 verification, crash-safe final activation and retained source copies for recovery.
- Added recoverable image-deletion requests for ordinary authors, with a dedicated moderation queue, exact status restoration, permanent moderator deletion, fail-closed visibility across Core and Gallery add-ons, and protection against bypassing review through personal-album deletion.
- Added an authenticated Contest end-to-end workflow to the functional CI, covering creation, uploads, privacy, disable/enable, voting and winners.
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

### Changed

- Grouped every concrete Remote Storage implementation under a dedicated `providers/` directory and namespace while keeping shared HTTP and migration infrastructure provider-neutral.
- Replaced the TIFF add-on's abbreviated license notice with the complete GPL-2.0 text and made package hygiene tests require the declared license in every release component.
- Fixed Image Revisions reactivation after the Core disables all add-ons by giving its reconciliation step the current storage workspace dependency.
- Separated neutral author outcomes from attributed internal moderation notices: only album-authorized moderators see who approved, rejected or removed an image, while ordinary authors never receive moderator or reporter identities.
- Added a real phpBB functional workflow for approval, rejection, removal and reporting that verifies persisted recipients, private payloads and the UCP presentation for ordinary authors and album moderators.
- Routed Gallery notifications through album-scoped moderation permissions: status teams now share approval outcomes and state changes, comment moderators receive new-comment notices, report recipients remain restricted to `m_report`, and duplicate/self notifications are suppressed. Moderated deletion notices include the author without exposing reporters, while image unlocking now restores counters and creates the missing moderator log/event.
- Enforced watermarking for externally processed BMP/TIFF originals by first creating a bounded temporary WebP, cleaned all provider response leases and watermark derivatives after delivery, and disabled MIME sniffing on every binary image response.
- Made BBOOTS and FLATBOOTS album pagination use the themes' native list structure so their standard page-jump control is displayed and initialized.
- Clarified that the existing time sort uses the image upload date and exposed neutral sort-option hooks so add-ons can keep album listings, previous/next navigation and ACP defaults in the same indexed order.
- Preserved the requested image after guest login, replaced relative permission redirects, added album return links to initial quota errors and restored administrator-only Whois actions without accepting IP addresses from URLs.
- Batched album-tree content deletion so images, counters, permissions, notifications, tracking rows and caches are processed once per deleted branch.
- Replaced residual English fallback text in the Bulgarian, German, Spanish, French, Italian, Dutch and Russian Core language catalogs.
- Added functional coverage for inline original-source delivery, mandatory watermarking without source mutation and BBPoints-protected downloads.
- Opened browser-compatible GIF, JPEG, PNG, WebP and AVIF originals inline when no add-on requires a download, while retaining attachment delivery for BMP, TIFF and unknown source formats.
- Made the phpBB permission-test identity authoritative for Gallery album, ownership and zebra checks, and hid the header link when that effective identity cannot view or moderate any album.
- Added a deterministic release builder that creates and validates all 13 component ZIPs from a committed Git ref, records their SHA-256 hashes and publishes the verified package set as a CI artifact.
- Made the functional CI install the generated ZIPs instead of source folders and added a clean-board lifecycle covering all 13 components, automatic add-on disablement, reactivation and ordered purge.
- Fixed BBTags Images purging so phpBB no longer recreates the provisional ACP module and block removal of the Gallery Core category.
- Made the Contest add-on remove its owned table and columns when its data is purged, avoiding orphaned storage.
- Made all 13 component manifests expose their version-check configuration in phpBB's supported `extra.version-check` location, added matching release metadata files and documented the Core and add-on catalogue.
- Replaced the archived Blueimp/jQuery quick-upload stack with a dependency-free browser client using FormData and XMLHttpRequest, retaining drag-and-drop, previews, bounded concurrent uploads, progress, cancellation and normal-form fallback across prosilver, BBOOTS and FLATBOOTS.
- Namespaced the Contests add-on's internal route identifiers and made its album-lifecycle SQL boundary explicit, allowing its release package to pass EPV while preserving the existing public URLs.
- Documented every ACP album event variable and exposed explicitly named visibility SQL builders while retaining the previous public aliases, allowing Gallery Core to pass EPV without compatibility regressions.
- Moved Image Revisions overrides into each album's ACP edit form and added a read-only hierarchy showing inherited and effective enablement and retention limits, while preserving global defaults.
- Moved BBPoints image overrides into each album's ACP edit form and replaced the bulk matrix with a read-only hierarchy showing direct and effective values, edit links and confirmed contributor-assignment bulk actions.
- Moved contest configuration, album/result storage and the contest album-type label from Gallery Core into the independent Contests add-on, while retaining the neutral fail-closed image marker and historical migration compatibility.
- Moved the remaining contest-specific frontend presentation and translations out of Gallery Core and into the independent Contests add-on.
- Routed uploads, image delivery, editing, deletion, approval hooks, EXIF, Image Revisions, BBPoints historical rewards, Export and ACP maintenance through the selected storage provider instead of assuming local source, medium and thumbnail paths.
- Made Export preserve the Gallery album/subalbum hierarchy and use stable IMAGEID_AUTHORID_IMAGENAME.ext filenames while reading source objects through the active provider.
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

- Fixed Contest winner pagination using an undefined legacy configuration key and made the shared search template reusable from add-on controllers through explicit Core template paths.
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

### Security

- Kept AVIF disabled on runtimes that cannot inspect dimensions before GD decoding, applied the existing pixel limit before decode and verified every encoded AVIF by size, MIME type and dimensions before publication.
- Prevented configured remote storage from silently falling back to local files, verified materialized and published objects by size and SHA-256 where supported, and rejected malformed provider listings and stalled cursors.
- Made every BBPoints Images identifier explicit at its SQL interpolation boundary, allowing the add-on release package to pass EPV without suppressions.
- Isolated inherited BBPoints policies by album owner so nested-set intervals from personal galleries can never be treated as ancestors of public albums.
- Made resumable-upload cancellation and scheduled orphan pruning delete drafts only while their database row still has orphan status, preventing a concurrent finalization from losing the completed image or its files.
- Made every dynamic numeric SQL boundary explicit with integer casts and routed the public Gallery title through phpBB's UTF-8 escaping helper, allowing the Core release package to pass EPV without suppressions.
- Made BBTags Images and Image Revisions SQL boundaries explicit at interpolation time and fixed the Gallery search relation to its trusted outer image alias, allowing both add-on release packages to pass EPV without suppressions.
- Disabled every packaged Gallery add-on before disabling the Core, preventing add-on services from breaking container compilation when their required Core parameters and services are unavailable.
- Centralized active-contest privacy so public image pages, album listings and reusable image blocks hide entrant identity, descriptions, ratings, comment history and private sort side channels while preserving explicit owner and moderator exceptions.
- Extended active-contest privacy to search terms and sorting, profile lists and counts, recent comments, top-rated results, album summaries and latest-image attribution.
- Protected feed descriptions, favorite attribution and UCP subscription comment history with the same active-contest identity and result policies.
- Routed EXIF and Feed privacy through extension-neutral Core decisions, removing their direct contest constants, helpers and storage-table dependencies while retaining fail-closed protection when an optional provider is unavailable.
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

- Kept functional fixtures portable under strict MySQL and MariaDB by explicitly supplying required text fields, synchronized the complete lifecycle role with modern source and statistics permissions, established the browser identity before authentication so inline-source checks preserve the phpBB session, and invalidated cached configuration before simulating the legacy-version cleanup migration.
- Expanded the complete phpBB functional lifecycle to SQLite, MySQL 8.4 LTS and MariaDB 11.4 LTS, including database-neutral purge assertions.
- Added an end-to-end Export workflow covering ACP limits and batching, nested album paths, readable image names, manifests, protected downloads and member-owned UCP exports.
- Added a functional MinIO workflow that validates ACP connection testing, resumable provider migration, remote source delivery with watermarking, temporary-file cleanup and migration back to local storage.
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
- Performed code inspection and improved DocBlocks
- Set revision to Big Buck Bunny

### Fixed
- Fixed a security issue
- Fixed an ACL issue where recent comments exposed images that should not be accessible
- Defined a missing array to prevent runtime errors
- Added missing variable
- This fixes topic 165786
- This fixes topic 166736
- This fixes topic 166176
- Fixed topic 166386 and closed #120
- Fixed sniffing issues
- This fixes topic 166526
- Fixed a path
- Fixed post 166976
- Fixed legacy variables
- Fixed the `\phpbbgallery\core\file\file` dependency
- Fixed a sniff error
- Fixed validation issues before `acp/config_module.php`, except for filesystem handling
- Fixed a URL error
- Fixed validation issues before `controller/comment.php`
- Addressed all review feedback
- Fixed styling issues
- Fixed a sniffing issue

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
- Load the Gallery button every time the BBCodes are displayed (Bug #912)
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
- Display image BBCodes when comments are disabled (Bug #860)
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
- Add recently reported and unapproved images to the MCP index (Feature #437, #658)
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
- Images remain reported when the report is closed (Report #393)
- Undefined index: comment_comment_username (Report #396)
- Not viewing rates on own images (Report #391)
- Animated and transparent GIFs unsupported on the image page
- Timestamp-Fix for 3.0.4
- Save files with correct name, when downloading
- Resync doesn't create an entry in the p_g_users table (Report #388)
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
- Failed to use gallery_root_path in the add-on

## [0.4.0] - 2008-11-20
### Added
- Medium thumbnails to display on image_page.php (Report #252)
- Require permissions for the ACP-modules (Report #309)
- Show newest comments and a random picture on index page (Report #144)
- Image URL on gallery_page_body.html (Report #266)
- disable watermark by permissions (Report #317)
- Show "Personal galleries" as a category on the index page (Report #142)
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
- Shorten long album names in recent/random listings and search
- Install-Script misses Constants like GALLERY_ROOT_PATH (Report #363)
- Moderator-link visible without permissions (Report #359)
- wrong headline for "manage subscription"
- .JPG-images from conversion are not visible (Report #358)
- Pagination in Manage subscriptions leads to Favorites (Report #361)
- Add Custom BBCode-Buttons (prosilver) (Report #356)
- installer not working on version compare for mysql (Report #360)
- SQL-Error when user is in no group => copy phpBB solution (Report #348)
- BBCode colorPalette needs images/spacer.gif (Report #351)
- install/install_*.php Undefined variable: exists (Report #355)
- U_GALLERY_MOD not using GALLERY_ROOT_PATH during installation (Report #352)
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
- ACP Import loses the image name across multiple pages (Report #332)
- Long filenames containing underscores cause template problems (Report #322)
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
- Redirect is too fast after uploading an image to an approval album (Report #283)
- Login on and redirect to gallery/index.php (Report #297)
- Module handle on installation

### Fixed
- Display of users online in the album
- highslide moved to template (Report #307)
- user_images not updated if it was empty (Report #306)
- Empty posting.php: no values specified for SQL IN comparison (Report #305)
- some bugs in subsilver2 only (Report #290)
- Blank image_page.php page (Report #289)
- [phpBB Debug] PHP Notice: in file /includes/acp/acp_gallery.php on line 296 (Report #304)
- view unapproved images to moderators
- Lang missing in search (Report #286)
- Missing information for new approval images (Report #302)
- Unknown column 'g.view_personal_albums' in viewonline.php (Report #288)
- Wrong permissions used when viewing the personal galleries link (Report #301)
- some language typos (Report #285)
- "NV Exif data" security risk (Report #i295)
- [album] uses the wrong URL for thumbnails (Report #300)
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
- Red image counter for moderators (unapproved images)
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
- Rewrote the whole MCP

### Fixed
- Repeat Bug 228: 0.2.3 to 0.3.0 upgrade won't update version (Report #258)
- Call to undefined function adm_back_link() (Report #260)
- viewonline broken (Report #259)
- bbcode is missing GALLERY_ROOT_PATH (Report #262)
- posting.php != S_IN_GALLERY (Report #264)
- Anonymous comments possible at private albums (Report #254)
- Icon bugged in RTL layouts (Report #265)
- don't create albums without names
- utf8 in file name on Import (Report #179)
- Wrong permissions when testing user permissions (Report #128)
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
- Session handling in 3.0.1 (Report #253)
- Old Link in Installer Footer (Report #242)
- Non-strict SQL (Report #243)
- Misspelled information after successful installation (Report #244)
- Image size during mass import when disabled (Report #248)
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
- Album category - don't show "no pictures" (Report #176)
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
- Personal albums - UCP - error moving subalbums (Report #210)
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
- Category - last image is not shown if disapproved (Report #177)
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
- Missing mass-upload module (Report #122)
- Better remove thumbs.db (Report #124)
- pers. album: default sort gives error messages (Report #125)
- missing {S_FORM_TOKEN} in subsilver2 (Report #127)
- missing "yes" in subsilver2 on delete-confirm (Report #130)
- UTF is absent (Report #131)
- Wrong permission for Anonymous users (Report #132)
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
- English typo: This file type is not allowed (Report #159)
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
- ModCP - old variable "cat_id" (Report #70)
- Lock/move links to ModCP do not use image_id (Report #71)
- ModCP: moving images is not possible (Report #72)
- Language variable error: MOVE_TO_CATEGORY does not exist (Report #73)
- lang var missing: LOGIN_EXPLAIN_UPLOAD (Report #74)
- Update: Column 'comment_edit_time' cannot be null (Report #75)
- PIC_TITLE not defined (Report #76)
- No recent images (Report #77)
- Column was set to data type implicit default (Report #78)
- Gäste Berechtigung wird nicht gespeichert (Report #79)
- value "array()" on bbcode-texts (Report #80)
- last edit username is not coloured (Report #81)
- Upload button is not displayed correctly in RC8 (Report #82)
- Remove personal gallery link when logged out (Report #83)
- There are no more categories to which you have permission to move images (Report #84)
- Error message when deleting an image (Report #85)
- Album Permissions 0.2.1 (Report #86)
- Undefined variable: tot_unapproved on album.php (Report #91)
- Incorrectly cutting symbols in album_personal_index.php (Report #94)
- $sort_new_comment_option = ''; missing (Report #96)
- Mass-upload in ACP (Report #99)
- subsilver2 (Report #101)
- album.php missing $ (Report #103)
- last_pic in personal_album on sort (Report #105)
- Error message when trying to approve pictures (Report #106)
- next and previous image (Report #107)
- thumbnails error if cache is deleted (Report #108)
- Links to Albums on Gallery Index are not shown (Report #109)
- image_page.php raises PHP notices (Report #110)
- Opening the latest picture in an album raises a PHP notice (Report #111)
- image_page.php : next/previous error with disapproved pics (Report #112)
- Undefined variable: auth_data (Report #113)
- Images are not counted on gallery index and sub-album index (Report #114)
- MCP - duplicate breadcrumbs and wrong usernames in personal galleries (Report #115)
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
- Installer forgot to activate the new "personal album permission" module (Report #59)
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
- Wrong redirect to album_cat when image approval is enabled (Report #18)
- ACP permissions.... (Report #19)
- Group names of special groups are "wrong" (Report #20)
- UTF8 support in acp_gallery and addslashes... (Report #21)
- Better Coding guidelines.... (Report #22)
- personal album not working if set permission to "privat" (Report #23)
- [Security] if (!defined('IN_PHPBB')) missing in languages (Report #24)
- Login Box on gallery index not working (Report #25)
- Logical error in album_personal.php (Report #26)
- ACP - gallery permission bug (Report #27)
- acp_gallery.php missing language vars (Report #28)
- It's the other way around with "L_" (Report #29)
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
- Reparse BBCodes when editing images (Report #43)
- Smilies in picture descriptions break the layout in gallery/album.php (Report #44)
- Same as Report #44, but for recent pictures and personal albums (Report #45)
- colour the usernames (Report #46)
- UTF-8 compatible? (Report #53)
