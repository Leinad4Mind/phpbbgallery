<?php
/**
 * BBTags cumulative-filter URL tests.
 *
 * @package sitesplat/bbtags
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\tests;

use PHPUnit\Framework\TestCase;
use sitesplat\bbtags\tags\filter_url;

class filter_url_test extends TestCase
{
	public function test_inactive_route_is_added_without_rebuilding_it_from_a_name(): void
	{
		$urls = $this->builder();

		$this->assertSame(
			'/bbtags/search?routes=caracas%2Ccaracas-a1b2c3d4&operator=and',
			$urls->toggle(['caracas'], 'caracas-a1b2c3d4', 'and')
		);
	}

	public function test_active_route_is_removed_and_operator_is_preserved(): void
	{
		$urls = $this->builder();

		$this->assertSame(
			'/bbtags/search?routes=caracas-a1b2c3d4&operator=or',
			$urls->toggle(['caracas', 'caracas-a1b2c3d4'], 'caracas', 'or')
		);
	}

	public function test_routes_are_deduplicated_bounded_and_unsafe_values_are_rejected(): void
	{
		$urls = $this->builder(2);

		$this->assertSame(
			['caracas', 'caracas-a1b2c3d4'],
			$urls->parse_routes('caracas,caracas,../admin,bad&operator=or,caracas-a1b2c3d4,ignored')
		);
	}

	private function builder(int $limit = 5): filter_url
	{
		$helper = new class {
			public function route($name, array $params = []): string
			{
				return '/bbtags/search' . (empty($params) ? '' : '?' . http_build_query($params));
			}
		};

		return new filter_url($helper, ['bbtags_max_tags' => $limit]);
	}
}
