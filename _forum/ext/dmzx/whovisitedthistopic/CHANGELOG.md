## Who Visited This Topic Changelog

### 1.1.0 - 2026-08-05

- Enforced forum read/list permissions, topic visibility, forum-password access and hidden-user privacy in profile history.
- Replaced the MySQL-only visit query with portable DBAL operations.
- Added duplicate/orphan cleanup, a unique user/topic constraint and lookup indexes.
- Added configurable visit-data retention with a daily pruning task.
- Applied count permissions consistently and excluded hidden/excluded visitors from totals.
- Added server-side ACP limits, multibyte username handling and explicit unknown-user errors.
- Removed remote version/badge requests and the active database version setting.
- Modernised Twig templates, shared assets and BBOOTS support.
- Added unit, package, template and disposable SQLite migration tests.

### 1.0.9 - 2023-02-24

- Added exclude option in ACP for profile view.

### 1.0.8 - 2021-07-29

- Delete loader image in ACP.
- Short syntax code.
- Code update.
- Added exclude option in ACP.

### 1.0.7 - 2019-10-09

- Drop support 3.1.x
- Twig update.
- Code update memberlist.
