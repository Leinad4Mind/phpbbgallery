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
 * Add the provider-independent tag catalogue schema.
 */
class m7_global_catalog_schema extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritdoc}
	 */
	public static function depends_on()
	{
		return array(
			'\sitesplat\bbtags\migrations\v31x\m1_initial_schema',
			'\sitesplat\bbtags\migrations\v31x\m2_initial_config',
			'\sitesplat\bbtags\migrations\v32x\m6_add_cloud_limit',
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function update_schema()
	{
		return array(
			'change_columns' => array(
				$this->table_prefix . 'bbtags' => array(
					'tag' => array('VCHAR:64', ''),
					'route' => array('VCHAR:64', ''),
				),
			),
			'add_columns' => array(
				$this->table_prefix . 'bbtags' => array(
					'tag_clean' => array('VCHAR:64', ''),
					'is_predefined' => array('BOOL', 0),
					'created_by' => array('UINT', 0),
					'created_at' => array('TIMESTAMP', 0),
				),
			),
			'add_tables' => array(
				$this->table_prefix . 'bbtags_context' => array(
					'COLUMNS' => array(
						'tag_id' => array('UINT', 0),
						'provider' => array('VCHAR:32', ''),
						'usage_count' => array('UINT', 0),
						'is_enabled' => array('BOOL', 1),
					),
					'PRIMARY_KEY' => array('tag_id', 'provider'),
					'KEYS' => array(
						'provider' => array('INDEX', array('provider', 'is_enabled')),
						'provider_usage' => array('INDEX', array('provider', 'usage_count')),
					),
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
			'drop_tables' => array(
				$this->table_prefix . 'bbtags_context',
			),
			'drop_columns' => array(
				$this->table_prefix . 'bbtags' => array(
					'tag_clean',
					'is_predefined',
					'created_by',
					'created_at',
				),
			),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function update_data()
	{
		return array(
			array('config.add', array('bbtags_max_length', 64)),
		);
	}
}
