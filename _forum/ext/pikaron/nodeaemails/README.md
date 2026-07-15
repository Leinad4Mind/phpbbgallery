[![phpBB](https://www.phpbb-es.com/foro/styles/flat-style/theme/images/logo_new_small.png)](https://www.phpbb-es.com/foro/viewtopic.php?f=147&t=43035&p=243137#p243137)
# [3.x.x][Ext][3.3.0] No DEA Emails
This extension prevents the registration of a user in the phpBB forum when using a disposable or temporary email account (DEA).

Such as:
   - Mailinator
   - Spamgourmet
   - TrashMail
   - Burnr
   - HMail
   - Temp Mail

#### No DEA Emails Extension is based in https://github.com/wesbos/burner-email-providers

## Requirements
* phpBB >= 3.2.4
* PHP >= 5.6.0
* Extension cURL of PHP loaded.

## Install
1. Download the latest release.
2. In the `ext` directory of your phpBB board, copy the `pikaron/nodeaemails` folder. It must be so: `/ext/pikaron/nodeaemails`
4. Navigate in the ACP to `Customise -> Manage extensions`.
5. Look for `No DEA Emails` under the Disabled Extensions list, and click its `Enable` link.

## Uninstall
1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Look for `No DEA Emails` under the Enabled Extensions list, and click its `Disable` link.
3. To permanently uninstall, click `Delete Data` and then delete the `/ext/pikaron/nodeaemails` folder.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
