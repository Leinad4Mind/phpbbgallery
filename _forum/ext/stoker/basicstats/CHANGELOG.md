# Changelog

All notable changes to **Board Statistics** (`stoker/basicstats`) are documented here,
plus a full reconstruction of the extension's lineage back to its 2015 origin as
**Basic Statistics** by OXPUS. Versions below `1.0.8` were never released under the
`stoker/basicstats` name — they're the predecessor history, kept here so the "why"
behind design decisions (timezone handling, permission model, translation set) isn't lost.

Sources used to reconstruct this file: five archived release zips (`Basic_Stats_EXT_1.0.1`,
`basicstats_v102`, `Basic_Stats_1.1.3`, `Board_Stats_v1.0.7`, `Board_Stats_v1.0.8`), this
repository's own commit history for `_forum/ext/stoker/basicstats` and `oxpus/basicstats`,
the [Galixte/Basis-Statistics-32](https://github.com/Galixte/Basis-Statistics-32) GitHub
mirror, and the official version-history table on the
[oxpus.net extension listing](https://phpbb3.oxpus.net/dlext/details?df_id=31). Where those
sources disagree, both readings are noted rather than silently picking one.

## [1.2.0] - 2026-07-25 (Leinad4Mind)

### Added
- Full hour-by-hour, day-of-month (all years combined), and month-of-year (all years
  combined) breakdown tables, in addition to the existing single "peak hour" tiles:
  - Day/Month views: a new "Hourly Breakdown" section with 24-row tables (Topics/Posts/
    Registrations), each row showing Average and Total.
  - Year view: two new sections, "Month of Year Breakdown" (Jan-Dec, aggregated across
    every year) and "Day of Month Breakdown" (day 1-31, aggregated across every month),
    so e.g. "day 1 of any month" or "every January" can be compared on equal footing
    regardless of how many times each has actually occurred since the board started.
- New shared controller helper `render_bucket_table()` so all 12 new tables (hour/
  month-of-year/day-of-month × topics/posts/registrations) share one averaging/bar-width/
  busiest-row implementation instead of duplicating it 12 times.
- `group_by_month_of_year()`; `group_by_day()` widened to accept optional bounds so it
  doubles as the day-of-month (all years) query.
- `day_of_month_occurrences()` / `month_of_year_occurrences()` — pure-PHP occurrence
  counters used as the average's divisor (day 31 occurs in fewer months than day 1-28,
  so a raw total would understate how busy it typically is).
- New language keys (`BS_AVERAGE`, `BS_PERIODIC_HOUR`, and three section headings)
  translated into all 8 existing locales (en, da, es, fr, nl, pt, pt_br, pt_preao).

### Fixed
- Tied maximum values (two or more rows sharing the same top average) now highlight
  *every* tied row, not just the first one reached during the scan.
- **Display labels were silently reintroducing the same class of timezone bug that
  1.0.9 fixed in the SQL bucketing** (caught in review by Stoker: "you still have use
  two different timezones, just in an other way than I did"). Every row/heading/option
  label built from `gmmktime()` was being formatted through `$this->user->format_date()`,
  which *always* shifts to the viewing user's configured timezone before formatting —
  so a row's UTC bucket boundary and its displayed label could disagree for any viewer
  not on UTC (e.g. a "day 15" bucket showing as "14" for a UTC-8 viewer). Added
  `format_date_utc()`, which reuses phpBB's locale-aware month/day-name translation
  (`\phpbb\datetime`) but keeps the timestamp pinned to UTC throughout. `AS_ON`
  ("Generated %s") is the one label that's genuinely "right now" rather than a data
  bucket, and correctly keeps using `$this->user->format_date()` in viewer-local time.

## [1.1.9] - 2026-07-25 (Leinad4Mind)

### Added
- Peak-hour-of-day statistic (UTC), shown as 3 extra tiles in the existing "Overall"
  metrics grid on all three views (Peak hour: topics / posts / registrations).
- `pt`, `pt_br`, and `pt_preao` translations, ported from `oxpus/basicstats`'s own
  pt-family and brought up to date with this extension's full key set. Each variant
  follows its own register (pt/pt_preao: EU tu-form, no gerunds; pt_preao additionally
  keeps pre-AO90 spelling; pt_br: você/seu, gerunds allowed).
- BBOOTS and FLATBOOTS styles, matching each style's real site design language (BBOOTS:
  stock Bootstrap 3 + official theme; FLATBOOTS: flat Bootstrap 3.4.1, site's actual gold
  brand color) rather than a generic invented look.
- Standardized PHPDoc file header (translator credit line right after `@license`,
  `@translation {credit} [{Language} [{locale}]] ({year})`) across all language files,
  all locales, both `phpbb/ads` and `phpbb/autogroups` as well.

### Fixed
- Tied-maximum highlighting bug introduced by the peak-hour refactor (see 1.2.0 above
  for the definitive fix — an earlier attempt in this version only highlighted the
  first tied row).

## [1.0.9] - 2026-07-25

### Fixed
- **Permission never granted on install.** The migration declared `u_basicstats_view`
  via `permission.add` but never called `permission.permission_set` for any group, so
  after a fresh install *nobody* — not even Administrators — could see the stats pages
  until a super-admin manually fixed the ACL. Added
  `['permission.permission_set', ['ADMINISTRATORS', 'u_basicstats_view', 'group']]`.
- **Timezone-dependent hour/day bucketing.** Any code path relying on `FROM_UNIXTIME()`/
  `DATE_FORMAT()`/`HOUR(FROM_UNIXTIME())` inherits the *MySQL session's* `time_zone`
  setting, which can silently disagree with the UTC math the rest of the controller
  uses. Fixed by bucketing via pure integer arithmetic on the raw UNIX timestamp column
  (`FLOOR(ts/86400)` for day, later extended to `FLOOR((ts%86400)/3600)` for hour) and
  resolving calendar labels in PHP via `gmdate()`/`gmmktime()` — never `date()`/`mktime()`
  (server-local) and never a MySQL `SET time_zone` session override.

## [1.0.8] - imported 2026-07-25 (upstream release 2025 or later)

Initial import of Stoker's full rewrite into this repository, replacing the abandoned
`oxpus/basicstats`. Rebrand highlights vs. the last oxpus release (see "Lineage" below
for the oxpus-side history this superseded):

### Changed
- Complete rewrite: `declare(strict_types=1)`, full constructor dependency injection
  (`auth`, `cache`, `config`, `helper`, `db\driver_interface`, `http_exception`, etc.)
  replacing oxpus's minimal `$db`/`$helper`/`$request`/`$template`/`$user`/`$config` set.
  Namespace changed `oxpus\basicstats` → `stoker\basicstats`.
- Minimum requirements raised to PHP ≥ 7.4 and phpBB ≥ 3.3.0 (from PHP ≥ 5.4, phpBB ≥ 3.2).
  Homepage moved from `oxpus.net` to `phpbb3bbcodes.com`.
- Templates renamed `d_view.html`/`m_view.html`/`y_view.html` →
  `basicstats_day.html`/`basicstats_month.html`/`basicstats_year.html`, rebuilt as
  table-free responsive markup (`.bs-rows`/`.bs-row`/`.cell`) instead of the old
  `<table class="fs_details_graphs">` layout, with server-side caching per period
  (short TTL for the still-changing current day/month/year, ~1 year for finished periods).
- Single consolidated `stoker_basicstats_migrations.php` (depending on phpBB 3.3's own
  `v330` migration) replacing oxpus's one-migration-class-per-release-file scheme.
- Authors: Stoker credited as Developer; Karsten Ude (oxpus) retained as Original Author.

Between the two 1.0.7/1.0.8 archive zips available for comparison, the only functional
difference found was a redundant `$this->template->destroy_block_vars('bs_year_options')`
call removed before the year-options loop, a form-markup simplification (dropped an
unnecessary outer `<form method="post">` wrapper the page never actually submitted, moved
the month-picker `<form>` inside `.bs-section`, swapped HTML-entity arrows for Font Awesome
icons with responsive-hide labels), and translation-completeness fixes: `es` had
`BS_AVG_USER_REGS_*` left untranslated in English, `fr` had a `Sujetss` → `Sujets` typo, and
`nl/permissions_basicstats.php`'s header comment still said `[ english ]`.

---

## Lineage before this fork

The chain below predates this repository and is reconstructed from archived zips, the
`oxpus/basicstats` commit history kept in this repo's `oxpus/basicstats` folder (imported
2025-08-15), and external sources (GitHub, oxpus.net). It is not the changelog of
`stoker/basicstats` itself, but the "why" behind several of its long-standing patterns
(timezone-agnostic bucketing, the permission-check-in-constructor pattern, the pt-family
translations) traces back through it.

### Basic Statistics (oxpus, `oxpus\basicstats`) — 2015-2020

- Per a `phpbb.de` community thread (undated in the fetched excerpt, but discussing phpBB
  3.3, so 2020 or later), a user looking for a 3.3-compatible build noted the extension's
  GitHub entry was gone and settled on an unrelated alternative (dmzx's Top Stats) instead —
  the gap this fork's 2025 rewrite (`stoker/basicstats` 1.0.7+, above) was built to fill.
- **1.1.3** (`Basic_Stats_1.1.3.zip`) — per GitHub, "Fix indentation" after Galixte's PR
  merge. **Note:** oxpus.net's own version-history table labels this same
  Aug-2017 event "1.1.2" and lists a *separate* "1.1.3" dated 2020-02-04 ("FIX Wrong using
  of parameter mode") that isn't in any of the five archived zips used for this
  reconstruction — the two channels' version numbers appear to be offset by one for this
  stretch. Flagged here rather than silently resolved.
- **1.1.2** — added French translation (credited to **Galixte**) and fixed a month-name
  formatting bug.
- **1.1.1** — "FIX EPV Issues" (extension validator warnings).
- **1.1.0** (2017-05-21 per oxpus.net's listing, "First public release"; the GitHub mirror
  instead dates a commit tagged "Final Release 1.1.0" to 2017-01-11 — the two sources'
  version numbers and dates don't fully agree, see note below) — migrated all
  `$user->lang['KEY']` array access to the newer `$this->language->lang('KEY')` service,
  added a private `_bs_date()` wrapper around `format_date()` (dates now respect the
  viewing user's locale instead of raw PHP `date()`), added mode-validation (invalid
  `?mode=` no longer silently blanks the page), and a new `COLON` language key for
  locale-correct label punctuation.
- **1.0.2** (`basicstats_v102.zip`, 2016-10-31) — a side-branch contributed by **dmzx**
  (dmzx-web.net), *not* inherited by the later 1.1.x line (its migration depends on 1.0.1
  directly, skipping 1.0.2). Modernized the auth check from
  `trigger_error($user->lang['NOT_AUTHORISED'])` to `throw new http_exception(403, ...)`,
  added an explicit `add_lang_ext()` call, capped compatibility at `phpBB <3.3.0@dev`, and
  added a Swedish (`sv`) translation.
- **1.0.1** (`Basic_Stats_EXT_1.0.1.zip`) — second release; no functional changes found
  versus 1.0.0 beyond the version-bump migration.
- **1.0.0** (2015-10-05, per `composer.json`) — first release by Karsten Ude (OXPUS). Per
  the extension's own README, "Based on advanced statistics mods module for periodical
  stats" — conceptually descended from the older **[ABD] Advanced Forum Statistics MOD**
  for phpBB 3.0.x (pre-Extension era), "created on an idea by classicmachinery.net" per the
  GitHub mirror's README. That MOD's own source wasn't available to verify directly and is
  not part of this comparison.

### Root-cause note

Several fixes made in this fork's own history (1.0.9's timezone bug, the permission-grant
bug) were regressions specific to `stoker/basicstats`'s 2025 rewrite, not inherited from
oxpus — the oxpus-era code used `getdate()`/`date()` consistently (server-local, but at
least *consistently* server-local) and never introduced a MySQL-session-timezone
dependency; that risk was introduced when the rewrite moved day/month/year grouping into
SQL `GROUP BY` queries for performance.
