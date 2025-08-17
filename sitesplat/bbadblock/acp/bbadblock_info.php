<?php
/**
*
* BBadblock extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbadblock\acp;

class bbadblock_info
{
    public function module()
    {
        return array(
            'filename'  => '\sitesplat\bbadblock\acp\bbadblock_module',
            'title'     => 'ACP_BBADBLOCK_INDEX_TITLE',
            'modes'     => array(
                'settings'    => array(
                    'title' => 'ACP_BBADBLOCK_INDEX_TITLE',
					'auth'	=> 'ext_sitesplat/bbadblock && acl_a_board',
                    'cat'   => array('ACP_QUICK_ACCESS')),
            ),
        );
    }
}
