# phpBB Forum Icons Extension

Adds a safe, accessible image selector to the forum add/edit form in the ACP.

## Requirements

- phpBB 3.3 or later
- PHP 7.2 or later

## Install

1. Download the latest release and Unzip the downloaded release.
2. Copy the `dmzx/forumicons` folder to `/ext/` (if done correctly, you'll have the main extension class at (your forum root)/ext/dmzx/forumicons/composer.json).
3. Navigate in the ACP to `Customise -> Manage extensions`.
4. Look for `Forum Icons` under the Disabled Extensions list, and click its `Enable` link.

The extension creates `/images/forumicons` during installation. Copy PNG or GIF
images into that directory and select them while adding or editing a forum.

## Uninstall

1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Look for `Forum Icons` under the Enabled Extensions list, and click its `Disable` link.
3. To permanently uninstall, click `Delete Data` and then delete the `/ext/dmzx/forumicons` folder.

## License
[GNU General Public License v2](https://opensource.org/license/gpl-2-0)
