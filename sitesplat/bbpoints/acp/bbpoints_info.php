<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbpoints\acp;

class bbpoints_info
{
    public function module()
    {
        return array(
            'filename'  => '\sitesplat\bbpoints\acp\bbpoints_module',
            'title'     => 'ACP_POINTS_INDEX_TITLE',
            'modes'     => array(
                'settings'    => array(
                    'title' => 'ACP_POINTS_INDEX_TITLE',
					'auth'	=> 'ext_sitesplat/bbpoints && acl_a_board',
                    'cat'   => array('ACP_CAT_FORUMS')),
            ),
        );
    }
}
