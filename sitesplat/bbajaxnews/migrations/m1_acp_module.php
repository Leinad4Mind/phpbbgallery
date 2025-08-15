<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbajaxnews\migrations;

class m1_acp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['sitesplat_bbajaxnews_interval']);
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('sitesplat_bbajaxnews_pubnub_pub', '')),
			array('config.add', array('sitesplat_bbajaxnews_pubnub_sub', '')),
			array('config.add', array('sitesplat_bbajaxnews_interval', 3)),
			array('config.add', array('sitesplat_bbajaxnews_noty_visibility_control', 0)),
			array('config.add', array('sitesplat_bbajaxnews_noty_timeout', 9000)),
			array('config.add', array('sitesplat_bbajaxnews_noty_progress_bar', 1)),
			array('config.add', array('sitesplat_bbajaxnews_noty_layout', 'topRight')),
			array('config.add', array('sitesplat_bbajaxnews_noty_mo', 0)),
			array('config.add', array('sitesplat_bbajaxnews_bbdonation', 0)),
			array('config.add', array('sitesplat_bbajaxnews_bbmembership', 0)),
			array('config.add', array('sitesplat_bbajaxnews_bbvote', 0)),
			array('config.add', array('sitesplat_bbajaxnews_friend_logged_in', 1)),
			array('config.add', array('sitesplat_bbajaxnews_new_announcement', 1)),
			array('config.add', array('sitesplat_bbajaxnews_new_posts_today', 1)),
			array('config.add', array('sitesplat_bbajaxnews_new_sticky', 1)),
			array('config.add', array('sitesplat_bbajaxnews_new_topic', 1)),
			array('config.add', array('sitesplat_bbajaxnews_random_poll', 1)),
			array('config.add', array('sitesplat_bbajaxnews_user_joined_board', 1)),
			array('config.add', array('sitesplat_bbajaxnews_user_joined_group', 1)),
			array('config.add', array('sitesplat_bbajaxnews_users_online_24h', 1)),
			array('config.add', array('sitesplat_bbajaxnews_users_online', 1)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_BBAJAXNEWS_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_BBAJAXNEWS_TITLE',
				array(
					'module_basename'	=> '\sitesplat\bbajaxnews\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}