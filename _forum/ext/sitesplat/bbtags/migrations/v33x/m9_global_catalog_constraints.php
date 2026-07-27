<?php
/**
 *
 * BBTags
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbtags\migrations\v33x;

/**
 * Enforce catalogue uniqueness after the legacy data is normalized.
 */
class m9_global_catalog_constraints extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritdoc}
	 */
	public static function depends_on()
	{
		return array('\sitesplat\bbtags\migrations\v33x\m8_global_catalog_data');
	}

	/**
	 * {@inheritdoc}
	 */
	public function update_schema()
	{
		return array(
			'drop_keys' => array(
				$this->table_prefix . 'bbtags' => array('route'),
			),
			'add_unique_index' => array(
				$this->table_prefix . 'bbtags' => array(
					'tag_clean' => array('tag_clean'),
					'route' => array('route'),
				),
				$this->table_prefix . 'bbtags_topic' => array(
					'topic_tag' => array('topic_id', 'tag_id'),
				),
			),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function revert_schema()
	{
		return array(
			'drop_keys' => array(
				$this->table_prefix . 'bbtags' => array('tag_clean', 'route'),
				$this->table_prefix . 'bbtags_topic' => array('topic_tag'),
			),
			'add_index' => array(
				$this->table_prefix . 'bbtags' => array(
					'route' => array('route'),
				),
			),
		);
	}
}
