<?php

/**
 *
 * BBReaction
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbreaction\migrations\v12x;

use \phpbb\db\migration\migration;

/**
 * Migration stage 5: New extra config
 */
class m5_add_extra_config extends migration
{
    /**
     * Assign migration file dependencies for this migration
     *
     * @return array Array of migration files
     * @static
     * @access public
     */
    static public function depends_on()
    {
        return ['\sitesplat\bbreaction\migrations\v11x\m4_add_permission_ucp'];
    }

    /**
     * Add or update data in the database
     *
     * @return array Array of table data
     * @access public
     */
    public function update_data()
    {
        return [
            ['config.add', ['rewards_button_position', 0]],
            ['config.add', ['rewards_display_top_show', 1]],
        ];
    }
}