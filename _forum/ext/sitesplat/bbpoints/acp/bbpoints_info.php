<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015-2022 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbpoints\acp;

class bbpoints_info
{
    public function module()
    {
        return [
            'filename'  => '\sitesplat\bbpoints\acp\bbpoints_module',
            'title'     => 'ACP_POINTS_INDEX_TITLE',
            'modes'     => [
                'settings'    => [
                    'title' => 'ACP_POINTS_INDEX_TITLE',
					'auth'	=> 'ext_sitesplat/bbpoints && acl_a_board',
                    'cat'   => ['ACP_CAT_FORUMS']
                ],
            ],
        ];
    }
}
