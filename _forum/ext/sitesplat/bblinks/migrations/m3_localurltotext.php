<?php
/**
*
* @package sitesplat BBlinks
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bblinks\migrations;

class m3_localurltotext extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\bblinks\migrations\m2_acp_module');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('bblinks_urltotext_forum', '{FORUM_NAME}')),
			array('config.add', array('bblinks_urltotext_topic', '{TOPIC_TITLE}')),
			array('config.add', array('bblinks_urltotext_post', '{USER_NAME} @ {TOPIC_TITLE}')),
			array('config.add', array('bblinks_urltotext_user', '{USER_NAME}')),
			array('config.add', array('bblinks_urltotext_page', '{PAGE_TITLE}')),
			array('config.add', array('bblinks_urltotext_cpf', 0)),
		);
	}
}
