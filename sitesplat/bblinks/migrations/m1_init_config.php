<?php
/**
*
* @package sitesplat BBlinks
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bblinks\migrations;

class m1_init_config extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

    public function update_data()
    {
        return array(
            array('config.add', array('bblinks_enable', false)),
            array('config.add', array('bblinks_enable_modal', true)),
            array('config.add', array('bblinks_skip_link_types', '')),
            array('config.add', array('bblinks_internal_link_types', '')),
            array('config.add', array('bblinks_external_link_types', '')),
            array('config_text.add', array('bblinks_forbidden_domains', '')),
            array('config.add', array('bblinks_forbidden_new_url', '#')),
            array('config.add', array('bblinks_internal_link_class', 'postlink-local')),
            array('config.add', array('bblinks_external_link_class', 'postlink_bblink')),
            array('config.add', array('bblinks_internal_link_target', '')),
            array('config.add', array('bblinks_external_link_target', '_blank')),
            array('config.add', array('bblinks_internal_link_rel', '')),
            array('config.add', array('bblinks_external_link_rel', 'nofollow')),
            array('config.add', array('bblinks_hide_links_from_guests', false)),
            array('config_text.add', array('bblinks_hide_links_from_guests_text', '')),
            array('config.add', array('bblinks_external_prefix', '')),
            array('config.add', array('bblinks_skip_prefix_types', '')),
            array('config_text.add', array('bblinks_internal_link_domains', '')),
        );
    }
}
