# Login Redirect extension for phpBB

Redirects a user to a chosen topic/announcement when they log in.

[![Build Status](https://travis-ci.com/david63/loginredirect.svg?branch=master)](https://travis-ci.com/david63/loginredirect)
[![License](https://poser.pugx.org/david63/loginredirect/license)](https://packagist.org/packages/david63/loginredirect)
[![Latest Stable Version](https://poser.pugx.org/david63/loginredirect/v/stable)](https://packagist.org/packages/david63/loginredirect)
[![Latest Unstable Version](https://poser.pugx.org/david63/loginredirect/v/unstable)](https://packagist.org/packages/david63/loginredirect)
[![Total Downloads](https://poser.pugx.org/david63/loginredirect/downloads)](https://packagist.org/packages/david63/loginredirect)

## Minimum Requirements
* phpBB 3.2.0
* PHP 5.4

## Install
1. [Download the latest release](https://github.com/david63/loginredirect/archive/3.2.zip) and unzip it.
2. Unzip the downloaded release and copy it to the `ext` directory of your phpBB board.
3. Navigate in the ACP to `Customise -> Manage extensions`.
4. Look for `Login redirect` under the Disabled Extensions list and click its `Enable` link.

## Usage
1. Navigate in the ACP to `Extensions -> Login redirect -> Manage redirects`.
2. Apply the settings that you require.

## Uninstall
1. Navigate in the ACP to `Customise -> Manage extensions`.
2. Click the `Disable` link for `Login redirect`.
3. To permanently uninstall, click `Delete Data`, then delete the loginredirect folder from `phpBB/ext/david63/`.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2019 - David Wood