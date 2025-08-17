# Dropbox Upload extension for phpBB

Extends autobackup to allow the copying of the backup file to your Dropbox account.

[![Build Status](https://travis-ci.com/david63/dropboxupload.svg?branch=master)](https://travis-ci.com/david63/dropboxupload)
[![License](https://poser.pugx.org/david63/dropboxupload/license)](https://packagist.org/packages/david63/dropboxupload)
[![Latest Stable Version](https://poser.pugx.org/david63/dropboxupload/v/stable)](https://packagist.org/packages/david63/dropboxupload)
[![Latest Unstable Version](https://poser.pugx.org/david63/dropboxupload/v/unstable)](https://packagist.org/packages/david63/dropboxupload)
[![Total Downloads](https://poser.pugx.org/david63/dropboxupload/downloads)](https://packagist.org/packages/david63/dropboxupload)

## Minimum Requirements
* phpBB 3.2.0
* PHP 5.4

## Install
1. [Download the latest release](https://github.com/david63/dropboxupload/archive/3.2.zip) and unzip it.
2. Unzip the downloaded release and copy it to the `ext` directory of your phpBB board.
3. Navigate in the ACP to `Customise -> Manage extensions`.
4. Look for `Dropbox upload for autobackup` under the Disabled Extensions list and click its `Enable` link.

## Usage
1. Navigate in the ACP to `Maintenance -> Auto Database Backup -> Dropbox settings`.

## Uninstall
1. Navigate in the ACP to `Customise -> Manage extensions`.
2. Click the `Disable` link for `Dropbox upload for autobackup`.
3. To permanently uninstall, click `Delete Data`, then delete the dropboxupload folder from `phpBB/ext/david63/`.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2019 - David Wood