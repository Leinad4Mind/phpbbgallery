<?php
/**
*
* BBtracking
*
* @copyright (c) 2018 Ken F. Innes IV <https://www.absoluteanime.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
* @copyright (c) 2017, Sitesplat
* @license private
*/

namespace sitesplat\bbtracking;

class tracking_types
{
	const TYPE = array(
        'TRACKING_TYPE_ACCOUNT_SETTINGS'	    => 1,
        'TRACKING_TYPE_VIEWFORUM'			    => 2,
        'TRACKING_TYPE_VIEWTOPIC'			    => 3,
        'TRACKING_TYPE_MEMBERLIST_VIEWPROFILE'  => 4,
        'TRACKING_TYPE_EDIT_POST'               => 5,
        'TRACKING_TYPE_LOGIN'                   => 6,
        'TRACKING_TYPE_LOGOUT'                  => 7,
        'TRACKING_TYPE_SEND_PM'                 => 8,
    );
}
