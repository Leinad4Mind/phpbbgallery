<?php

namespace david63\dropboxupload\tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use david63\dropboxupload\core\dropbox_client;
use PHPUnit\Framework\TestCase;

class dropbox_client_test extends TestCase
{
	public function test_streams_file_through_upload_session()
	{
		$history = array();
		$client = $this->mock_client(array(
			new Response(200, array(), json_encode(array('session_id' => 'session'))),
			new Response(200),
			new Response(200, array(), json_encode(array('name' => 'backup.sql'))),
		), $history);
		$file = $this->temporary_file('backup');
		try
		{
			$result = (new dropbox_client($client))->upload($file, '/backup.sql', array('dropbox_access_token' => 'token'));
			$this->assertSame('backup.sql', $result['name']);
			$this->assertCount(3, $history);
			$this->assertSame('Bearer token', $history[1]['request']->getHeaderLine('Authorization'));
			$this->assertSame('backup', (string) $history[1]['request']->getBody());
			$arguments = json_decode($history[1]['request']->getHeaderLine('Dropbox-API-Arg'), true);
			$this->assertTrue($arguments['close']);
			$this->assertSame(0, $arguments['cursor']['offset']);
		}
		finally
		{
			unlink($file);
		}
	}

	public function test_refreshes_token_for_unattended_upload()
	{
		$history = array();
		$client = $this->mock_client(array(
			new Response(200, array(), json_encode(array('access_token' => 'fresh'))),
			new Response(200, array(), json_encode(array('session_id' => 'session'))),
			new Response(200),
			new Response(200, array(), json_encode(array('name' => 'backup.sql'))),
		), $history);
		$file = $this->temporary_file('backup');
		$credentials = array(
			'dropbox_app_key' => 'key',
			'dropbox_app_secret' => 'secret',
			'dropbox_refresh_token' => 'refresh',
		);
		try
		{
			(new dropbox_client($client))->upload($file, '/backup.sql', $credentials);
			$this->assertCount(4, $history);
			$this->assertSame('api.dropboxapi.com', $history[0]['request']->getUri()->getHost());
			$this->assertStringStartsWith('Basic ', $history[0]['request']->getHeaderLine('Authorization'));
			$this->assertSame('Bearer fresh', $history[1]['request']->getHeaderLine('Authorization'));
		}
		finally
		{
			unlink($file);
		}
	}

	public function test_redacts_token_from_api_error()
	{
		$history = array();
		$body = json_encode(array('error_summary' => 'invalid token-value'));
		$client = $this->mock_client(array(new Response(401, array(), $body)), $history);
		$file = $this->temporary_file('backup');
		try
		{
			(new dropbox_client($client))->upload($file, '/backup.sql', array('dropbox_access_token' => 'token-value'));
			$this->fail('Expected Dropbox API failure');
		}
		catch (\RuntimeException $exception)
		{
			$this->assertStringNotContainsString('token-value', $exception->getMessage());
			$this->assertStringContainsString('[redacted]', $exception->getMessage());
		}
		finally
		{
			unlink($file);
		}
	}

	protected function mock_client(array $responses, array &$history)
	{
		$stack = HandlerStack::create(new MockHandler($responses));
		$stack->push(Middleware::history($history));
		return new Client(array('handler' => $stack));
	}

	protected function temporary_file($contents)
	{
		$file = tempnam(sys_get_temp_dir(), 'dbx');
		if ($file === false)
		{
			$this->fail('Unable to create temporary file');
		}
		file_put_contents($file, $contents);
		return $file;
	}
}
