Cron Status - Changelog
=======================
This file contains the list of changes between different versions of Cron Status extension.

# Version 3.3.1
## Changes since 3.3.0
### Security
* [CODE] Fixed reflected/persisted XSS via the `sk`/`sd` sort parameters (now whitelisted) and the `cron_type` parameter (now validated against real registered Cron tasks and escaped) in the ACP module.

### Bug fixes
* [CODE] Fixed a PHP 8 `Undefined array key` warning when `cronstatus_default_sort` is empty or malformed.
* [CODE] Fixed `strpos()` calls used as booleans without `!== false` in `cronstatus_helper.php`, which could silently misclassify third-party Cron tasks.
* [CODE] Fixed a missing `var` declaration creating an implicit global in `cronstatus.js`.

### Housekeeping
* [CODE] Removed dead `.travis.yml` (Travis CI was discontinued in 2021).
* [LANGUAGE] Added European Portuguese translations (`pt` and `pt_preao`, pre/post Orthographic Agreement).

# Version 3.3.0
## Changes since 3.1.3
### Bug fixes
* [CODE] phpBB 3.3 is now fully supported.

# Version 3.1.3
## Changes since 3.1.2
### Bug fixes
* [CODE] phpBB 3.2 is now fully supported.

# Version 3.1.2
## Changes since 3.1.1
### New features
* [CODE] New event variable `last_task_date` is now available for developers of Cron Tasks.
* [CODE] Showing that there is no "next time" scheduled for a Cron Task is allowed.
* [LANGUAGE] Spanish language package was added.
* [LANGUAGE] Turkish language package was added.
* [LANGUAGE] Croatian language package was added.
* [LANGUAGE] French language package was added.

### Bug fixes
* [STYLE] Font path was not fully correct. The font was not loaded if the board was installed not in the root of the site.
* [CODE] SQL query fix for PostgreSQL compatibility.

# Version 3.1.1
Initial stable release (changes can be found in the commits of our [repository on GitHub](https://github.com/BoardTools/cronstatus)).

© 2014 - 2018 Igor Lavrov and John Peskens
