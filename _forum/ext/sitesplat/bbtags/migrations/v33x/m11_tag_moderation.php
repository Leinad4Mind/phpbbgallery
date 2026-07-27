<?php
/**
 * BBTags generic tag suggestion moderation.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\migrations\v33x;

class m11_tag_moderation extends \phpbb\db\migration\migration
{
	public static function depends_on(): array
	{
		return ['\sitesplat\bbtags\migrations\v33x\m10_hierarchical_scopes'];
	}

	public function update_schema(): array
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'bbtags_suggestions' => [
					'COLUMNS' => [
						'suggestion_id' => ['UINT', null, 'auto_increment'],
						'tag_id'        => ['UINT', 0],
						'tag'           => ['VCHAR:64', ''],
						'tag_clean'     => ['VCHAR:64', ''],
						'provider'      => ['VCHAR:32', ''],
						'scope_id'      => ['UINT', 0],
						'item_id'       => ['UINT', 0],
						'suggested_by'  => ['UINT', 0],
						'suggested_at'  => ['TIMESTAMP', 0],
						'status'        => ['VCHAR:12', 'pending'],
						'reviewed_by'   => ['UINT', 0],
						'reviewed_at'   => ['TIMESTAMP', 0],
						'dedupe_key'    => ['VCHAR:64', ''],
					],
					'PRIMARY_KEY' => 'suggestion_id',
					'KEYS' => [
						'dedupe_key'    => ['UNIQUE', ['dedupe_key']],
						'provider_item' => ['INDEX', ['provider', 'item_id', 'status']],
						'moderation'    => ['INDEX', ['status', 'suggested_at']],
					],
				],
			],
		];
	}

	public function update_data(): array
	{
		return [
			['permission.add', ['m_bbtags_moderate', true]],
			['permission.permission_set', ['ROLE_MOD_FULL', 'm_bbtags_moderate']],
			['permission.permission_set', ['ROLE_MOD_STANDARD', 'm_bbtags_moderate']],
			['module.add', [
				'mcp',
				'MCP_QUEUE',
				[
					'module_basename' => '\sitesplat\bbtags\mcp\bbtags_module',
					'modes' => ['queue'],
				],
			]],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'bbtags_suggestions',
			],
		];
	}
}
