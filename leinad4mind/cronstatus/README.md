# Cron Status

Displays an overview of your board's Cron Jobs in **ACP » Maintenance » Forum Logs**.

Shows a notification on the ACP index page when cron is locked, lets you run any ready
task now, run all ready tasks at once, and lists tasks that have never started.

This extension merges and supersedes `boardtools/cronstatus` and `forumhulp/cronstatus`:
it keeps the self-contained, dependency-free base of `boardtools/cronstatus` (no core
file patching, no companion helper extension required) and adds the Run Now / Run All /
Never Started / unlock / run-always-for-bots features from `forumhulp/cronstatus`,
reimplemented as plain event listeners instead of core patches.

## Requirements

- phpBB 3.3.0 or higher
- PHP 7.1 or higher

## License

[GPL-2.0](license.txt)
