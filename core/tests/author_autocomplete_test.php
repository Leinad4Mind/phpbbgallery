<?php
/**
 * phpBB Gallery - author autocomplete tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbb\auth\auth as phpbb_auth;
use phpbb\config\config as phpbb_config;
use phpbb\db\driver\driver_interface;
use phpbb\request\request_interface;
use phpbb\user;
use phpbbgallery\core\auth\auth as gallery_auth;
use phpbbgallery\core\controller\author_autocomplete;
use PHPUnit\Framework\TestCase;

final class author_autocomplete_test extends TestCase
{
	public function test_dynamic_search_predicate_is_escaped_at_the_sql_boundary(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/author_autocomplete.php');

		$this->assertStringNotContainsString('$like =', $source);
		$this->assertStringContainsString(
			"'WHERE'    => \$this->get_sql_where(\$term)",
			$source
		);
		$this->assertStringContainsString('private function get_sql_where(string $term): string', $source);
		$this->assertStringContainsString(
			'$this->db->sql_escape($term) . $this->db->get_any_char()',
			$source
		);
	}

	public function test_visitor_cannot_enumerate_upload_authors(): void
	{
		$db = $this->database();
		$db->expects($this->never())->method('sql_query');
		$user = new user();
		$user->data = ['user_id' => ANONYMOUS, 'is_registered' => false];

		$response = $this->controller($db, $user)->search(44);

		$this->assertSame(403, $response->getStatusCode());
		$this->assertSame([], $this->decode($response));
		$this->assert_security_headers($response);
	}

	public function test_album_member_search_requires_fresh_moderator_permission(): void
	{
		$db = $this->database();
		$db->method('sql_build_query')->willReturn('album_query');
		$db->expects($this->once())->method('sql_query')->with('album_query')->willReturn('album_result');
		$db->method('sql_fetchfield')->willReturn(2);
		$db->expects($this->never())->method('sql_query_limit');
		$user = new user();
		$user->data = ['user_id' => 7, 'is_registered' => true];
		$gallery_auth = $this->createMock(gallery_auth::class);
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(7);
		$gallery_auth->expects($this->once())->method('acl_check')->with('m_edit', 44, 2)->willReturn(false);

		$response = $this->controller($db, $user, null, $gallery_auth)->search(44);

		$this->assertSame(403, $response->getStatusCode());
	}

	public function test_album_moderator_receives_bounded_prefix_matches(): void
	{
		$db = $this->database();
		$db->method('sql_build_query')->willReturnOnConsecutiveCalls('album_query', 'users_query');
		$db->expects($this->once())->method('sql_query')->with('album_query')->willReturn('album_result');
		$db->method('sql_fetchfield')->willReturn(2);
		$db->method('sql_escape')->with('lei')->willReturn('lei');
		$db->method('get_any_char')->willReturn('%');
		$db->method('sql_like_expression')->with('lei%')->willReturn('LIKE lei%');
		$db->method('sql_in_set')->willReturn('u.user_type IN (0, 3)');
		$db->expects($this->once())->method('sql_query_limit')->with('users_query', 10)->willReturn('users_result');
		$db->method('sql_fetchrow')->willReturnOnConsecutiveCalls(['username' => 'Leinad4Mind'], false);
		$request = $this->request(['term' => 'Lei']);
		$user = new user();
		$user->data = ['user_id' => 7, 'is_registered' => true];
		$gallery_auth = $this->createMock(gallery_auth::class);
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(7);
		$gallery_auth->expects($this->once())->method('acl_check')->with('m_edit', 44, 2)->willReturn(true);

		$response = $this->controller($db, $user, $request, $gallery_auth)->search(44);

		$this->assertSame([['label' => 'Leinad4Mind', 'value' => 'Leinad4Mind']], $this->decode($response));
	}

	public function test_gallery_search_suggestions_follow_phpbb_search_permission(): void
	{
		$db = $this->database();
		$db->expects($this->never())->method('sql_query_limit');
		$user = new user();
		$user->data = ['user_id' => ANONYMOUS, 'is_registered' => false];
		$phpbb_auth = $this->createMock(phpbb_auth::class);
		$phpbb_auth->expects($this->once())->method('acl_get')->with('u_search')->willReturn(false);

		$response = $this->controller($db, $user, null, null, $phpbb_auth)->global_search();

		$this->assertSame(403, $response->getStatusCode());
	}

	private function controller(
		driver_interface $db,
		user $user,
		?request_interface $request = null,
		?gallery_auth $gallery_auth = null,
		?phpbb_auth $phpbb_auth = null
	): author_autocomplete
	{
		return new author_autocomplete(
			$db,
			$request ?? $this->request(),
			$user,
			$gallery_auth ?? $this->createStub(gallery_auth::class),
			$phpbb_auth ?? $this->createStub(phpbb_auth::class),
			new phpbb_config(['load_search' => true]),
			'users',
			'albums'
		);
	}

	private function database(): driver_interface
	{
		return $this->createMock(driver_interface::class);
	}

	private function request(array $values = []): request_interface
	{
		$request = $this->createMock(request_interface::class);
		$request->method('variable')->willReturnCallback(
			static fn (string $name, mixed $default): mixed => $values[$name] ?? $default
		);
		return $request;
	}

	private function decode(\Symfony\Component\HttpFoundation\JsonResponse $response): array
	{
		$data = json_decode((string) $response->getContent(), true);
		$this->assertIsArray($data);
		return $data;
	}

	private function assert_security_headers(\Symfony\Component\HttpFoundation\JsonResponse $response): void
	{
		$this->assertStringContainsString('private', (string) $response->headers->get('Cache-Control'));
		$this->assertStringContainsString('no-store', (string) $response->headers->get('Cache-Control'));
		$this->assertSame('nosniff', $response->headers->get('X-Content-Type-Options'));
		$this->assertSame('noindex', $response->headers->get('X-Robots-Tag'));
	}
}
