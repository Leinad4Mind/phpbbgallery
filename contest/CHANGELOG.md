# Changelog

All notable changes to the phpBB Gallery Contest add-on are documented in this file.

## [1.0.0] - Unreleased

### Added

- Created the independent Contest add-on package and its safe dependency lifecycle.
- Adopted the historical Gallery contest storage without copying or deleting existing data.
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
- Routed album thumbnail identity, rating and comment privacy through the
  neutral Core image-visibility policy.
- Routed last-image identity privacy in album listings through the neutral Core
  image-visibility policy.
- Routed album and image subscription privacy in the UCP through the neutral
  Core image-visibility policy.
- Routed the Gallery index's latest-image identity through the neutral Core
  image-visibility policy.
