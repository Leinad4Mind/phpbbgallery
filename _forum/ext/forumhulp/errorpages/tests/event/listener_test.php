<?php
/**
 *
 * @package Error Pages
 * @copyright (c) 2014 ForumHulp.com
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\errorpages\tests\event;

use forumhulp\errorpages\event\listener;
use phpbb\config\config;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\template\template;
use phpbb\user;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class listener_test extends TestCase
{

	public function test_not_found_response_is_safe_and_not_logged()
	{
		$assigned = [];
		$log = $this->createMock(log_interface::class);
		$log->expects(self::never())->method('add');
		$listener = $this->create_listener(['error_pages_explain' => 1, 'error_pages_log' => 1], $log, $assigned);
		$event = $this->create_event(new NotFoundHttpException(), Request::create('/missing'));

		$listener->on_kernel_exception($event);

		self::assertTrue($event->hasResponse());
		self::assertSame(404, $event->getResponse()->getStatusCode());
		self::assertStringContainsString('no-store', $event->getResponse()->headers->get('Cache-Control'));
		self::assertSame('ERRORPAGES_NOT_FOUND', $assigned['ERRORPAGES_TITLE']);
		self::assertSame('ERRORPAGES_NOT_FOUND_EXPLAIN', $assigned['ERRORPAGES_EXPLANATION']);
		self::assertSame([false, false, false], \forumhulp\errorpages\event\page_state::$footer);
	}

	public function test_server_error_is_logged_and_preserves_headers()
	{
		$assigned = [];
		$log = $this->createMock(log_interface::class);
		$log->expects(self::once())
			->method('add')
			->with('critical', 7, '127.0.0.1', 'LOG_GENERAL_ERROR', false, [
				'503: ERRORPAGES_SERVICE_UNAVAILABLE',
				'/failure',
			]);
		$listener = $this->create_listener(['error_pages_explain' => 1, 'error_pages_log' => 1], $log, $assigned);
		$event = $this->create_event(new ServiceUnavailableHttpException(120), Request::create('/failure'));

		$listener->on_kernel_exception($event);

		self::assertSame(503, $event->getResponse()->getStatusCode());
		self::assertSame('120', $event->getResponse()->headers->get('Retry-After'));
		self::assertSame('nosniff', $event->getResponse()->headers->get('X-Content-Type-Options'));
	}

	public function test_ajax_request_is_left_to_phpbb()
	{
		$assigned = [];
		$log = $this->createMock(log_interface::class);
		$listener = $this->create_listener(['error_pages_explain' => 1, 'error_pages_log' => 1], $log, $assigned, false, false);
		$request = Request::create('/ajax');
		$request->headers->set('X-Requested-With', 'XMLHttpRequest');
		$event = $this->create_event(new NotFoundHttpException(), $request);

		$listener->on_kernel_exception($event);

		self::assertFalse($event->hasResponse());
		self::assertSame([], $assigned);
	}

	public function test_debug_runtime_exception_is_left_to_phpbb()
	{
		$assigned = [];
		$log = $this->createMock(log_interface::class);
		$listener = $this->create_listener(['error_pages_explain' => 1, 'error_pages_log' => 1], $log, $assigned, true, false);
		$event = $this->create_event(new \RuntimeException('private details'), Request::create('/failure'));

		$listener->on_kernel_exception($event);

		self::assertFalse($event->hasResponse());
		self::assertSame([], $assigned);
	}

	public function test_invalid_http_status_is_safely_normalized()
	{
		$assigned = [];
		$log = $this->createMock(log_interface::class);
		$listener = $this->create_listener(['error_pages_explain' => 1, 'error_pages_log' => 0], $log, $assigned);
		$event = $this->create_event(new HttpException(999), Request::create('/invalid'));

		$listener->on_kernel_exception($event);

		self::assertSame(500, $event->getResponse()->getStatusCode());
		self::assertSame('ERRORPAGES_INTERNAL_SERVER_ERROR', $assigned['ERRORPAGES_TITLE']);
	}
	public function test_production_runtime_exception_uses_generic_500()
	{
		$assigned = [];
		$log = $this->createMock(log_interface::class);
		$log->expects(self::once())->method('add');
		$listener = $this->create_listener(['error_pages_explain' => 0, 'error_pages_log' => 1], $log, $assigned);
		$event = $this->create_event(new \RuntimeException('private details'), Request::create('/failure'));

		$listener->on_kernel_exception($event);

		self::assertSame(500, $event->getResponse()->getStatusCode());
		self::assertSame('ERRORPAGES_INTERNAL_SERVER_ERROR', $assigned['ERRORPAGES_TITLE']);
		self::assertFalse($assigned['S_ERRORPAGES_EXPLAIN']);
		self::assertStringNotContainsString('private details', $event->getResponse()->getContent());
	}

	private function create_listener(array $settings, log_interface $log, array &$assigned, $debug = false, $handles = true)
	{
		$language = $this->createMock(language::class);
		$language->expects($handles ? self::once() : self::never())->method('add_lang')->with('common', 'forumhulp/errorpages');
		$language->method('lang')->willReturnCallback(function ($key) {
			return $key;
		});

		$template = $this->createMock(template::class);
		$template->method('assign_vars')->willReturnCallback(function ($vars) use (&$assigned) {
			$assigned = $vars;
		});
		$template->expects($handles ? self::once() : self::never())->method('set_filenames')->with([
			'body' => '@forumhulp_errorpages/error_page.html',
		]);
		$template->method('assign_display')->with('body')->willReturn('<html>safe error</html>');

		$user = $this->getMockBuilder(user::class)->disableOriginalConstructor()->getMock();
		$user->data = [
			'user_id' => 7,
			'session_ip' => '127.0.0.1',
		];

		return new listener(new config($settings), $language, $template, $log, $user, $debug);
	}

	private function create_event(\Exception $exception, Request $request)
	{
		return new GetResponseForExceptionEvent(
			$this->createMock(HttpKernelInterface::class),
			$request,
			HttpKernelInterface::MASTER_REQUEST,
			$exception
		);
	}
}
