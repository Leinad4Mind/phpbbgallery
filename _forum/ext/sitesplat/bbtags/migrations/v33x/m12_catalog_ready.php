<?php
/**
 * BBTags catalogue readiness marker.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\migrations\v33x;

/**
 * Mark the provider-independent catalogue as safe for runtime queries.
 */
class m12_catalog_ready extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritdoc}
	 */
	public static function depends_on()
	{
		return array('\sitesplat\bbtags\migrations\v33x\m11_tag_moderation');
	}

	/**
	 * {@inheritdoc}
	 */
	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'ensure_provider_usage_index'))),
			array('config.add', array('bbtags_catalog_version', 1)),
		);
	}

	/**
	 * Repair MariaDB installations left after the legacy reserved index name failed.
	 */
	public function ensure_provider_usage_index()
	{
		$table = $this->table_prefix . 'bbtags_context';
		if ($this->db_tools->sql_index_exists($table, 'usage')
			|| $this->db_tools->sql_index_exists($table, 'provider_usage'))
		{
			return;
		}

		$this->db_tools->sql_create_index(
			$table,
			'provider_usage',
			array('provider', 'usage_count')
		);
	}
}
