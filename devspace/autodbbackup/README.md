# Auto db Backup extension for phpBB

An extension for phpBB 3.2 that will automatically backup your database using the phpBB 3.2 Cron.

[![Build Status](https://travis-ci.com/david63/autodbbackup.svg?branch=master)](https://travis-ci.com/david63/autodbbackup)
[![License](https://poser.pugx.org/david63/autodbbackup/license)](https://packagist.org/packages/david63/autodbbackup)
[![Latest Stable Version](https://poser.pugx.org/david63/autodbbackup/v/stable)](https://packagist.org/packages/david63/autodbbackup)
[![Latest Unstable Version](https://poser.pugx.org/david63/autodbbackup/v/unstable)](https://packagist.org/packages/david63/autodbbackup)
[![Total Downloads](https://poser.pugx.org/david63/autodbbackup/downloads)](https://packagist.org/packages/david63/autodbbackup)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ca60af3fa41346e4bfa0cea42a016254)](https://www.codacy.com/manual/david63/autodbbackup?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=david63/autodbbackup&amp;utm_campaign=Badge_Grade)

 [![Compatible](https://img.shields.io/badge/compatible-phpBB:3.2.x-blue.svg)](https://shields.io/)
 [![Compatible](https://img.shields.io/badge/compatible-phpBB:3.3.x-blue.svg)](https://shields.io/)

## Minimum Requirements
* phpBB 3.2.0
* PHP 5.4

## Install
1. [Download the latest release](https://github.com/david63/autodbbackup/archive/3.2.zip) and unzip it.
2. Unzip the downloaded release and copy it to the `ext` directory of your phpBB board.
3. Navigate in the ACP to `Customise -> Manage extensions`.
4. Look for `Auto database backup` under the Disabled Extensions list and click its `Enable` link.

## Usage
1. Navigate in the ACP to `Maintenance -> Auto Database Backup -> Auto backup settings`.

## Uninstall
1. Navigate in the ACP to `Customise -> Manage extensions`.
2. Click the `Disable` link for `Auto database backup`.
3. To permanently uninstall, click `Delete Data`, then delete the autodbbackup folder from `phpBB/ext/david63/`.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2019 - David Wood