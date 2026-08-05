# Topic Index Bridge

Topic Index Bridge provides optional integrations for `leinad4mind/officialtopicindex` in one extension:

- forum names, images, and topic icons;
- Quick Title Edition attributes;
- BBPrefix prefixes;
- BBEmoji topic titles;
- Topic Image Preview gallery thumbnails;
- topic indexes filtered by user.

Each module is controlled from the Official Topic Index ACP page and only runs when its dependency is enabled. If a matching legacy Kasimi bridge is active, the unified module is suspended to avoid duplicate output during migration.

Install this extension at `ext/kasimi/topicindexbridge` after enabling `leinad4mind/officialtopicindex` 2.0.0 or newer. The former `dmzx/topicindex` 2.0 event and route names remain supported during transition.

## License

[GNU General Public License v2](https://opensource.org/licenses/GPL-2.0)
