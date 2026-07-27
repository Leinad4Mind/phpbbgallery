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
 * Add generic provider scopes with nearest-ancestor inheritance.
 */
class m10_hierarchical_scopes extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritdoc}
	 */
	public static function depends_on()
	{
		return array('\sitesplat\bbtags\migrations\v33x\m9_global_catalog_constraints');
	}

	/**
	 * {@inheritdoc}
	 */
	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'bbtags_context' => array(
					'scope_mode' => array('VCHAR:12', 'global'),
				),
			),
			'add_tables' => array(
				$this->table_prefix . 'bbtags_scope' => array(
					'COLUMNS' => array(
						'id' => array('UINT', null, 'auto_increment'),
						'tag_id' => array('UINT', 0),
						'provider' => array('VCHAR:32', ''),
						'scope_id' => array('UINT', 0),
						'scope_rule' => array('VCHAR:8', 'allow'),
					),
					'PRIMARY_KEY' => 'id',
					'KEYS' => array(
						'tag_scope' => array('UNIQUE', array('tag_id', 'provider', 'scope_id')),
						'provider_scope' => array('INDEX', array('provider', 'scope_id')),
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
				$this->table_prefix . 'bbtags_scope',
			),
			'drop_columns' => array(
				$this->table_prefix . 'bbtags_context' => array('scope_mode'),
			),
		);
	}
}
