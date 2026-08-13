<?php
/**
 * phpBB Gallery SQL portability regression tests.
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class sql_portability_test extends TestCase
{
	public function test_result_queries_do_not_group_unaggregated_full_rows(): void
	{
		$core = dirname(__DIR__);
		$controller = (string) file_get_contents($core . '/controller/search.php');
		$search = (string) file_get_contents($core . '/search.php');
		$log = (string) file_get_contents($core . '/log.php');

		$this->assertSame(0, substr_count($controller, 'GROUP_BY'));
		$this->assertSame(0, substr_count($search, 'GROUP_BY'));
		$this->assertSame(0, substr_count($log, 'GROUP_BY'));
		$this->assertStringContainsString('i.*, a.album_name, a.album_status, a.album_user_id, a.album_id', $controller);
		$this->assertStringContainsString('i.*, c.*', $search);
		$this->assertStringContainsString('l.log_id, l.log_type, l.log_action, l.log_time, l.log_user, l.log_ip, l.album, l.image, l.description', $log);
	}
}
