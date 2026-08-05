# Official Topic Index

Official Topic Index creates alphabetical topic indexes inside an official topic or on standalone pages.

Version 2.0 keeps the official `leinad4mind/officialtopicindex` identity while incorporating and improving the DMZX line:

- scoped moderator controls with CSRF-protected POST actions;
- permission and content-visibility-aware, batched topic queries;
- validated forums and lists with a configurable topic limit;
- display the index after, before, or instead of the official topic's first post;
- configurable destination forum for the “new topic” action;
- safer ACP list management, logging, extension events, and shared `styles/all` templates.

## Requirements

- phpBB 3.3
- PHP 7.4 or newer

## Update from Official Topic Index 1.0.6

Replace the files in `ext/leinad4mind/officialtopicindex` and run the normal phpBB extension update. Existing indexes keep the original **replace** behaviour; new configurations default to showing the index after the original message.

## Move from DMZX Topic Index 2.0

Both lines use the same database table and topic/forum columns. To keep all data:

1. Disable `dmzx/topicindex` without selecting **Delete data**.
2. Remove its old files and copy this extension to `ext/leinad4mind/officialtopicindex`.
3. Enable **Official Topic Index** and purge the phpBB cache.

The migration detects the shared schema and imports the DMZX configuration. Never use **Delete data** on the old DMZX extension: its rollback also targets this shared schema. Disable it, remove its files, and let Official Topic Index own the preserved data.

## Optional integrations

Install `kasimi/topicindexbridge` to manage Forum Info, Quick Title Edition, BBPrefix, BBEmoji, Topic Image Preview, and User Topics integrations from the ACP page.

## License

[GNU General Public License v2](https://opensource.org/licenses/GPL-2.0)
