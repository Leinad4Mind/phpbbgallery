<?php
/**
 * @package Dropbox Upload
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\dropboxupload\core;

use GuzzleHttp\ClientInterface;

class dropbox_client
{
	const CHUNK_SIZE = 8388608;
	const OAUTH_URL = 'https://api.dropboxapi.com/oauth2/token';
	const CONTENT_URL = 'https://content.dropboxapi.com/2/files/';

	protected $http_client;

	public function __construct(ClientInterface $http_client)
	{
		$this->http_client = $http_client;
	}

	public function upload($local_path, $remote_path, array $credentials)
	{
		$file_size = is_file($local_path) ? filesize($local_path) : false;
		if ($file_size === false || $file_size <= 0 || !is_readable($local_path))
		{
			throw new dropbox_exception('DROPBOX_BACKUP_FILE_INVALID');
		}
		$token = $this->get_access_token($credentials);
		$handle = fopen($local_path, 'rb');
		if ($handle === false)
		{
			throw new dropbox_exception('DROPBOX_BACKUP_FILE_INVALID');
		}

		try
		{
			return $this->upload_handle($handle, $file_size, $remote_path, $token);
		}
		finally
		{
			fclose($handle);
		}
	}
	protected function upload_handle($handle, $file_size, $remote_path, $token)
	{
		$start = $this->content_request('upload_session/start', array(
			'close' => false,
			'session_type' => array('.tag' => 'concurrent'),
		), '', $token);
		if (!isset($start['session_id']) || !is_string($start['session_id']) || $start['session_id'] === '')
		{
			throw new dropbox_exception('DROPBOX_SESSION_INVALID');
		}

		$offset = 0;
		while ($offset < $file_size)
		{
			$length = min(self::CHUNK_SIZE, $file_size - $offset);
			$chunk = $this->read_chunk($handle, $length);
			$is_last = ($offset + strlen($chunk)) === $file_size;
			$this->content_request('upload_session/append_v2', array(
				'cursor' => array('session_id' => $start['session_id'], 'offset' => $offset),
				'close' => $is_last,
			), $chunk, $token);
			$offset += strlen($chunk);
		}

		return $this->finish($start['session_id'], $offset, $remote_path, $token);
	}
	protected function finish($session_id, $offset, $remote_path, $token)
	{
		return $this->content_request('upload_session/finish', array(
			'cursor' => array('session_id' => $session_id, 'offset' => $offset),
			'commit' => array(
				'path' => $remote_path,
				'mode' => 'add',
				'autorename' => true,
				'mute' => false,
				'strict_conflict' => false,
			),
		), '', $token);
	}
	protected function get_access_token(array $credentials)
	{
		$key = trim(isset($credentials['dropbox_app_key']) ? $credentials['dropbox_app_key'] : '');
		$secret = trim(isset($credentials['dropbox_app_secret']) ? $credentials['dropbox_app_secret'] : '');
		$refresh = trim(isset($credentials['dropbox_refresh_token']) ? $credentials['dropbox_refresh_token'] : '');
		if ($key !== '' && $secret !== '' && $refresh !== '')
		{
			$data = $this->request(self::OAUTH_URL, array(
				'auth' => array($key, $secret),
				'form_params' => array('grant_type' => 'refresh_token', 'refresh_token' => $refresh),
				'headers' => array('Accept' => 'application/json'),
			), $credentials);
			if (empty($data['access_token']) || !is_string($data['access_token']))
			{
				throw new dropbox_exception('DROPBOX_TOKEN_RESPONSE_INVALID');
			}
			return $data['access_token'];
		}
		$token = trim(isset($credentials['dropbox_access_token']) ? $credentials['dropbox_access_token'] : '');
		if ($token === '')
		{
			throw new dropbox_exception('DROPBOX_CREDENTIALS_REQUIRED');
		}
		return $token;
	}
	protected function content_request($route, array $arguments, $body, $token)
	{
		$json = json_encode($arguments);
		if ($json === false)
		{
			throw new dropbox_exception('DROPBOX_REQUEST_INVALID');
		}
		return $this->request(self::CONTENT_URL . $route, array(
			'body' => $body,
			'headers' => array(
				'Authorization' => 'Bearer ' . $token,
				'Content-Type' => 'application/octet-stream',
				'Dropbox-API-Arg' => $json,
			),
		), array($token));
	}
	protected function request($url, array $options, array $secrets)
	{
		$options['http_errors'] = false;
		$options['allow_redirects'] = false;
		$options['verify'] = true;
		$options['connect_timeout'] = 15;
		$options['timeout'] = 180;
		try
		{
			$response = $this->http_client->request('POST', $url, $options);
		}
		catch (\Throwable $exception)
		{
			$message = $this->redact('Dropbox network error: ' . $exception->getMessage(), $secrets);
			throw new dropbox_exception($message, 0, $exception);
		}
		return $this->decode_response($response, $secrets);
	}
	protected function decode_response($response, array $secrets)
	{
		$status = (int) $response->getStatusCode();
		$body = $response->getBody()->read(65536);
		$data = json_decode($body, true);
		if ($status < 200 || $status >= 300)
		{
			$summary = is_array($data) && isset($data['error_summary']) ? $data['error_summary'] : 'request_failed';
			$summary = substr(preg_replace('#[\x00-\x1F\x7F]+#', ' ', (string) $summary), 0, 500);
			throw new dropbox_exception($this->redact('Dropbox API HTTP ' . $status . ': ' . $summary, $secrets));
		}
		if ($body === '')
		{
			return array();
		}
		if (!is_array($data))
		{
			throw new dropbox_exception('DROPBOX_RESPONSE_INVALID');
		}
		return $data;
	}
	protected function read_chunk($handle, $length)
	{
		$chunk = '';
		while (strlen($chunk) < $length && !feof($handle))
		{
			$data = fread($handle, $length - strlen($chunk));
			if ($data === false)
			{
				throw new dropbox_exception('DROPBOX_BACKUP_READ_FAILED');
			}
			$chunk .= $data;
		}
		if (strlen($chunk) !== $length)
		{
			throw new dropbox_exception('DROPBOX_BACKUP_READ_FAILED');
		}
		return $chunk;
	}
	protected function redact($message, array $secrets)
	{
		foreach ($secrets as $secret)
		{
			if (is_string($secret) && $secret !== '')
			{
				$message = str_replace($secret, '[redacted]', $message);
			}
		}
		return $message;
	}
}
