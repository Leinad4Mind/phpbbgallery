<?php
/**
 * BBTags MCP module definition.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\mcp;

class bbtags_info
{
	public function module(): array
	{
		return [
			'filename' => '\sitesplat\bbtags\mcp\bbtags_module',
			'title'    => 'MCP_BBTAGS_QUEUE',
			'modes'    => [
				'queue' => [
					'title' => 'MCP_BBTAGS_QUEUE',
					'auth'  => 'ext_sitesplat/bbtags && acl_m_bbtags_moderate',
					'cat'   => ['MCP_QUEUE'],
				],
			],
		];
	}
}
