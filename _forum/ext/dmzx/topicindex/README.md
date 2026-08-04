# Topic Index

Topic Index creates alphabetical topic indexes inside an official topic or on standalone pages. Version 2.0 adds scoped moderator controls, CSRF-protected mutations, visibility-aware batch queries, configurable display modes, and shared `styles/all` templates.

## Requirements

- phpBB 3.3
- PHP 7.4 or newer

## Installation and updates

Copy this directory to `ext/dmzx/topicindex`, then enable or update **Topic Index** in the ACP. Existing installations retain the `dmzx/topicindex` vendor and migration chain, so the extension can be updated in place.

Existing configured official indexes are migrated to the legacy **replace** display mode. New forum configurations default to showing the index after the original message.

## Optional integrations

Install `kasimi/topicindexbridge` to manage Forum Info, Quick Title Edition, BBPrefix, BBEmoji, Topic Image Preview, and User Topics integrations from the Topic Index ACP page. Legacy Kasimi integration extensions can remain installed during transition; the unified bridge suppresses overlapping modules while their legacy counterpart is enabled.

## License

[GNU General Public License v2](https://opensource.org/licenses/GPL-2.0)
