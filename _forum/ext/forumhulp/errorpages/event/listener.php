<?php
/**
 *
 * @package Error Pages
 * @copyright (c) 2014 ForumHulp.com
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\errorpages\event;

use phpbb\config\config;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class listener
{
	const STATUS_LANGUAGE_KEYS = [
		400 => 'ERRORPAGES_BAD_REQUEST',
		401 => 'ERRORPAGES_AUTH_REQUIRED',
		403 => 'ERRORPAGES_FORBIDDEN',
		404 => 'ERRORPAGES_NOT_FOUND',
		405 => 'ERRORPAGES_METHOD_NOT_ALLOWED',
		406 => 'ERRORPAGES_NOT_ACCEPTABLE',
		407 => 'ERRORPAGES_PROXY_AUTHENTICATION_REQUIRED',
		408 => 'ERRORPAGES_REQUEST_TIMED_OUT',
		409 => 'ERRORPAGES_CONFLICTING_REQUEST',
		410 => 'ERRORPAGES_GONE',
		411 => 'ERRORPAGES_CONTENT_LENGTH_REQUIRED',
		412 => 'ERRORPAGES_PRECONDITION_FAILED',
		413 => 'ERRORPAGES_REQUEST_ENTITY_TOO_LONG',
		414 => 'ERRORPAGES_REQUEST_URI_TOO_LONG',
		415 => 'ERRORPAGES_UNSUPPORTED_MEDIA_TYPE',
		418 => 'ERRORPAGES_TEAPOT',
		500 => 'ERRORPAGES_INTERNAL_SERVER_ERROR',
		501 => 'ERRORPAGES_NOT_IMPLEMENTED',
		502 => 'ERRORPAGES_BAD_GATEWAY',
		503 => 'ERRORPAGES_SERVICE_UNAVAILABLE',
		504 => 'ERRORPAGES_GATEWAY_TIMEOUT',
		505 => 'ERRORPAGES_HTTP_VERSION_NOT_SUPPORTED',
	];

	/** @var config */
	protected $config;

	/** @var language */
	protected $language;

	/** @var template */
	protected $template;

	/** @var log_interface */
	protected $log;

	/** @var user */
	protected $user;

	/** @var bool */
	protected $debug;

	public function __construct(config $config, language $language, template $template, log_interface $log, user $user, $debug = false)
	{
		$this->config = $config;
		$this->language = $language;
		$this->template = $template;
		$this->log = $log;
		$this->user = $user;
		$this->debug = (bool) $debug;
	}

	public function on_kernel_exception(GetResponseForExceptionEvent $event)
	{
		$request = $event->getRequest();
		$exception = $event->getException();

		// Let phpBB preserve its JSON response contract for AJAX requests.
		if ($request->isXmlHttpRequest())
		{
			return;
		}

		// Keep phpBB's detailed diagnostics for unexpected development errors.
		if ($this->debug && !($exception instanceof HttpExceptionInterface))
		{
			return;
		}

		$status_code = $exception instanceof HttpExceptionInterface ? (int) $exception->getStatusCode() : 500;
		if ($status_code < 400 || $status_code > 599)
		{
			$status_code = 500;
		}
		$language_key = $this->get_language_key($status_code);

		$this->language->add_lang('common', 'forumhulp/errorpages');
		$title = $this->language->lang($language_key);
		$explanation = !empty($this->config['error_pages_explain'])
			? $this->language->lang($language_key . '_EXPLAIN')
			: '';

		if (!empty($this->config['error_pages_log']) && $status_code >= 500)
		{
			$this->log_server_error($status_code, $title, $request->getPathInfo());
		}

		page_header($title, false, 0, 'forum', false);
		$this->template->assign_vars([
			'ERRORPAGES_TITLE' => $title,
			'ERRORPAGES_EXPLANATION' => $explanation,
			'S_ERRORPAGES_EXPLAIN' => $explanation !== '',
		]);
		$this->template->set_filenames([
			'body' => '@forumhulp_errorpages/error_page.html',
		]);
		page_footer(false, false, false);

		$response = new Response($this->template->assign_display('body'), $status_code, [
			'Content-Type' => 'text/html; charset=UTF-8',
			'Cache-Control' => 'private, no-store, no-cache, must-revalidate',
			'Pragma' => 'no-cache',
			'Expires' => '0',
			'Referrer-Policy' => 'strict-origin-when-cross-origin',
			'X-Content-Type-Options' => 'nosniff',
		]);

		if ($exception instanceof HttpExceptionInterface)
		{
			$response->headers->add($exception->getHeaders());
		}

		$event->setResponse($response);
	}

	protected function get_language_key($status_code)
	{
		if (isset(self::STATUS_LANGUAGE_KEYS[$status_code]))
		{
			return self::STATUS_LANGUAGE_KEYS[$status_code];
		}

		return $status_code >= 500 ? 'ERRORPAGES_INTERNAL_SERVER_ERROR' : 'ERRORPAGES_UNKNOWN';
	}

	protected function log_server_error($status_code, $title, $path)
	{
		$user_id = isset($this->user->data['user_id']) ? (int) $this->user->data['user_id'] : 0;
		$user_ip = isset($this->user->data['session_ip']) ? (string) $this->user->data['session_ip'] : '';
		$path = preg_replace('#[^\x20-\x7E]#', '?', (string) $path);
		$path = substr($path, 0, 255);

		try
		{
			$this->log->add('critical', $user_id, $user_ip, 'LOG_GENERAL_ERROR', false, [
				$status_code . ': ' . $title,
				$path,
			]);
		}
		catch (\Throwable $exception)
		{
			// A logging failure must not replace the original error response.
		}
	}
}
