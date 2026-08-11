# Changelog

All notable changes to the phpBB Gallery Contest add-on are documented in this file.

## [1.0.0] - Unreleased

### Added

- Added native date-and-time pickers to contest creation and editing while preserving the administrator's phpBB timezone, accepting legacy text-form submissions and preventing new or changed schedule dates from being in the past.
- Added a responsive album timeline that explains the scheduled, submission, voting and completed contest phases using the viewer's phpBB timezone.
- Added an optional global and per-contest presentation policy that replaces an
  ended contest album's list thumbnail with its validated first-place image,
  while preserving manual album images and latest-image chronology.
- Created the independent Contest add-on package and its safe dependency lifecycle.
- Added add-on-owned migrations for contest configuration, album state, result
  columns and the contest table, adopting historical Core storage in place
  without copying or deleting existing data.
- Moved the contest album-type label into the add-on for every supported Gallery
  language and loaded it before Core builds the extensible album-type selector.
- Added the contest domain manager and the Gallery Core policy provider, including
  fail-closed privacy when the add-on is unavailable.
- Moved the switch for creating new contests from the Core configuration model
  to the Contest add-on's ACP integration.
- Moved contest album form request, default, loading and template data into the
  add-on through generic Core album-type events.
- Moved the contest date fields into an add-on ACP template-event fragment.
- Moved server-side date validation, contest creation, editing and reopening
  persistence out of the Core album manager and into the add-on lifecycle.
- Moved contest image reset and historical-row cleanup during album moves and
  deletion into the add-on while preserving one atomic image-update query.
- Moved contest-specific ACP visibility and type-change warnings into add-on
  template-event fragments, leaving neutral album-type hooks in Core.
- Added syntax coverage for every Contest ACP template-event fragment.
- Moved all contest ACP field, validation and type-change messages into the
  add-on for every supported Gallery language.
- Routed Core search and search-controller privacy/result filtering through the
  extension-neutral image-visibility policy.
- Routed upload availability and contest image marking through extension-neutral
  Core policies, preserving checks at entry and immediately before finalization.
- Routed comment and rating availability, plus rating-result privacy, through
  the same extension-neutral Core policies.
- Routed direct image-page identity and result privacy through the neutral Core
  image-visibility policy, including the post-event privacy recheck.
- Moved hidden-rating presentation and its frontend translations out of the Core
  and into the add-on through a neutral hidden-results message event.
- Moved all active contest frontend messages, album schedule presentation and
  winner-search links into add-on-owned language and style event fragments.
- Replaced the remaining contest-named Core layout placeholder with a generic
  image-award placeholder and removed unused contest configuration remnants.
- Removed the Core dependency on contest result columns during image state
  changes; the add-on now decides whether affected albums require resyncing.
- Routed the message-editor image selector through the neutral results policy so
  optional providers control which restricted images may be inserted.
- Routed album thumbnail identity, rating and comment privacy through the
  neutral Core image-visibility policy.
- Routed last-image identity privacy in album listings through the neutral Core
  image-visibility policy.
- Routed album and image subscription privacy in the UCP through the neutral
  Core image-visibility policy without exposing the legacy contest marker in
  album or UCP result rows.
- Made the Contest add-on the owner of its persisted album type and state
  values; Gallery Core retains documented deprecated aliases for compatibility
  with existing add-ons and stored data.
- Routed the Gallery index's latest-image identity through the neutral Core
  image-visibility policy.
- Routed reusable image blocks through the neutral Core image-visibility
  policy for identity, rating and comment privacy.
- Routed moves into albums through the neutral operation policy while
  preserving the legacy distinction between active and completed contests.
- Added an authenticated phpBB functional workflow covering ACP contest
  creation, resumable uploads, entrant privacy, fail-closed disable/enable,
  real ratings, deterministic finalization and the published winners page.

### Fixed

- Locked the album-type selector when editing an existing contest, removed Contest from the selector when editing a regular album, preserved the submitted immutable type through a hidden field and removed permanent transition warnings while retaining server-side tamper protection.
- Kept completed contest ratings visible to image viewers who cannot vote, while preserving hidden results before finalization and phase-based voting restrictions.
- Used the configured Gallery items-per-page limit for winner pagination.
- Rendered the shared Core search results through its explicit template
  namespace so the winners page remains available from the add-on controller.
