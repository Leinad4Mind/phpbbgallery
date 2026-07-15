<?php
/**
*
* BBOOTS Mini CMS extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
* @license SiteSplat 2015 all rights reserved
*
*/

namespace sitesplat\bbootsminicms\acp;

class bboots_style_info
{
    public function module()
    {
        return array(
            'filename'  => '\sitesplat\bbootsminicms\acp\bboots_style_module',
            'title'     => 'BBOOTS_STYLE_TITLE',
            'modes'     => array(
                'config'        => array('title' => 'BBOOTS_STYLE_CONFIG', 'auth' => 'ext_sitesplat/bbootsminicms', 'cat' => array('ACP_CAT_DOT_MODS')),
                'menu'          => array('title' => 'BBOOTS_STYLE_BUTTONS', 'auth' => 'ext_sitesplat/bbootsminicms', 'cat' => array('ACP_CAT_DOT_MODS')),
                'upload'        => array('title' => 'BBOOTS_STYLE_UPLOAD', 'auth' => 'ext_sitesplat/bbootsminicms', 'cat' => array('ACP_CAT_DOT_MODS')),
                'links'         => array('title' => 'BBOOTS_STYLE_LINKS', 'auth' => 'ext_sitesplat/bbootsminicms', 'cat' => array('ACP_CAT_DOT_MODS')),
                'social'        => array('title' => 'BBOOTS_STYLE_SOCIAL', 'auth' => 'ext_sitesplat/bbootsminicms', 'cat' => array('ACP_CAT_DOT_MODS')),
                'css'           => array('title' => 'BBOOTS_STYLE_CSS', 'auth' => 'ext_sitesplat/bbootsminicms', 'cat' => array('ACP_CAT_DOT_MODS')),
            ),
        );
    }
}
