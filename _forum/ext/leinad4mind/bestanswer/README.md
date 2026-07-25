# Best Answer

An extension for phpBB 3.3.x that allows users to mark a post as the "Best Answer", which is then quoted in the first post with a link to it — similar to IPB's feature. This is the "Special Edition" fork of [kinerity/bestanswer](https://www.phpbb.com/community/viewtopic.php?t=2368876).

## Features

- Allow users to mark a post as the "Best Answer"
- Answer is quoted in the first post with a link to the post
- Per-forum configuration
- Permissions based
- Answer post highlighted for distinction
- Number of topics answered shown in the viewtopic mini profile

### Special Edition features

- BBOOTS theme
- FLATBOOTS theme
- Optional BBPoints integration (see below)
- Nightstalker compatible
- Notification when someone gives a best answer
- Notification when someone removes a best answer
- Email when someone gives a best answer
- Email when someone removes a best answer
- Logging

## Installation

Copy the extension to phpBB/ext/leinad4mind/bestanswer

Go to "ACP" > "Customise" > "Extensions" and enable the "Best Answer Special Edition" extension.

## Optional BBPoints integration

If the `sitesplat/bbpoints` extension is installed and enabled, Best Answer can credit/remove BBPoints when a post is marked/unmarked as the best answer (configurable per-forum in the ACP). This integration is entirely optional: Best Answer works standalone and degrades gracefully (skipping the BBPoints step) if `sitesplat/bbpoints` is not installed or is disabled.

## Changelog

See [CHANGELOG.md](CHANGELOG.md).

## License

[GPLv2](license.txt)
