<?php
/**
*
* FLATBOOTS Mini CMS extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
* @license SiteSplat 2015 all rights reserved
*
*/

namespace sitesplat\flatbootsminicms\acp;

class flatboots_style_info
{
    public function module()
    {
        return array(
            'filename'  => '\sitesplat\flatbootsminicms\acp\flatboots_style_module',
            'title'     => 'FLATBOOTS_STYLE_TITLE',
            'modes'     => array(
                'config'        => array('title' => 'FLATBOOTS_STYLE_CONFIG', 'auth' => 'ext_sitesplat/flatbootsminicms', 'cat' => array('ACP_CAT_DOT_MODS')),
                'menu'          => array('title' => 'FLATBOOTS_STYLE_BUTTONS', 'auth' => 'ext_sitesplat/flatbootsminicms', 'cat' => array('ACP_CAT_DOT_MODS')),
                'upload'        => array('title' => 'FLATBOOTS_STYLE_UPLOAD', 'auth' => 'ext_sitesplat/flatbootsminicms', 'cat' => array('ACP_CAT_DOT_MODS')),
                'links'         => array('title' => 'FLATBOOTS_STYLE_LINKS', 'auth' => 'ext_sitesplat/flatbootsminicms', 'cat' => array('ACP_CAT_DOT_MODS')),
                'social'        => array('title' => 'FLATBOOTS_STYLE_SOCIAL', 'auth' => 'ext_sitesplat/flatbootsminicms', 'cat' => array('ACP_CAT_DOT_MODS')),
                'css'           => array('title' => 'FLATBOOTS_STYLE_CSS', 'auth' => 'ext_sitesplat/flatbootsminicms', 'cat' => array('ACP_CAT_DOT_MODS')),
            ),
        );
    }
}
