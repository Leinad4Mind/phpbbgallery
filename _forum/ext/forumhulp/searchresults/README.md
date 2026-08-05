# Search Results

Search Results logs and aggregates the words visitors search for. The ACP module shows the hit count and the first and most recent search time for every recorded word.

The retention limit is configured under **ACP > General > Board configuration > Board features**. A value of `0` disables pruning; any positive value keeps the most frequently and recently searched words up to that limit.

## Requirements

- phpBB 3.3.12 or newer in the 3.x series
- PHP 8.1 or newer
- The `forumhulp/helper` extension installed and enabled

## Installation

1. Copy this directory to `ext/forumhulp/searchresults/`.
2. In the ACP, open **Customise > Extension Management > Extensions**.
3. Enable **Search Results**.

## Uninstallation

Disable the extension under **Customise > Extension Management > Extensions**. To remove its database data permanently, choose **Delete data** before deleting the extension directory.

## License

[GNU General Public License v2](https://opensource.org/licenses/GPL-2.0)

Copyright 2014 John Peskens (ForumHulp.com)
