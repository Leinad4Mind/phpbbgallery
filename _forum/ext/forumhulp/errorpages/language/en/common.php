<?php
/**
 *
 * @package Error Pages
 * @copyright (c) 2014 ForumHulp.com
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ERRORPAGES_RETURN_INDEX' => 'Return to the index page',
	'ERRORPAGES_BAD_REQUEST' => 'Bad Request',
	'ERRORPAGES_BAD_REQUEST_EXPLAIN' => 'The request could not be understood because it contains invalid syntax.',
	'ERRORPAGES_AUTH_REQUIRED' => 'Authorization Required',
	'ERRORPAGES_AUTH_REQUIRED_EXPLAIN' => 'You must authenticate before accessing this resource.',
	'ERRORPAGES_FORBIDDEN' => 'Forbidden',
	'ERRORPAGES_FORBIDDEN_EXPLAIN' => 'You do not have permission to access this resource.',
	'ERRORPAGES_NOT_FOUND' => 'Page Not Found',
	'ERRORPAGES_NOT_FOUND_EXPLAIN' => 'The requested page may be unavailable, may have moved, or may no longer exist.',
	'ERRORPAGES_METHOD_NOT_ALLOWED' => 'Method Not Allowed',
	'ERRORPAGES_METHOD_NOT_ALLOWED_EXPLAIN' => 'The request method is not supported by this resource.',
	'ERRORPAGES_NOT_ACCEPTABLE' => 'Not Acceptable',
	'ERRORPAGES_NOT_ACCEPTABLE_EXPLAIN' => 'The requested resource cannot provide a response acceptable to the client.',
	'ERRORPAGES_PROXY_AUTHENTICATION_REQUIRED' => 'Proxy Authentication Required',
	'ERRORPAGES_PROXY_AUTHENTICATION_REQUIRED_EXPLAIN' => 'The client must first authenticate with the proxy.',
	'ERRORPAGES_REQUEST_TIMED_OUT' => 'Request Timeout',
	'ERRORPAGES_REQUEST_TIMED_OUT_EXPLAIN' => 'The server timed out while waiting for the request.',
	'ERRORPAGES_CONFLICTING_REQUEST' => 'Conflict',
	'ERRORPAGES_CONFLICTING_REQUEST_EXPLAIN' => 'The request could not be completed because it conflicts with the current state of the resource.',
	'ERRORPAGES_GONE' => 'Gone',
	'ERRORPAGES_GONE_EXPLAIN' => 'The requested resource is no longer available and is not expected to become available again.',
	'ERRORPAGES_CONTENT_LENGTH_REQUIRED' => 'Content Length Required',
	'ERRORPAGES_CONTENT_LENGTH_REQUIRED_EXPLAIN' => 'The request did not specify the required content length.',
	'ERRORPAGES_PRECONDITION_FAILED' => 'Precondition Failed',
	'ERRORPAGES_PRECONDITION_FAILED_EXPLAIN' => 'A condition supplied with the request could not be satisfied.',
	'ERRORPAGES_REQUEST_ENTITY_TOO_LONG' => 'Content Too Large',
	'ERRORPAGES_REQUEST_ENTITY_TOO_LONG_EXPLAIN' => 'The request is larger than the server is willing or able to process.',
	'ERRORPAGES_REQUEST_URI_TOO_LONG' => 'URI Too Long',
	'ERRORPAGES_REQUEST_URI_TOO_LONG_EXPLAIN' => 'The supplied request URI is too long for the server to process.',
	'ERRORPAGES_UNSUPPORTED_MEDIA_TYPE' => 'Unsupported Media Type',
	'ERRORPAGES_UNSUPPORTED_MEDIA_TYPE_EXPLAIN' => 'The server does not support the media type used by the request.',
	'ERRORPAGES_TEAPOT' => "I'm a teapot",
	'ERRORPAGES_TEAPOT_EXPLAIN' => 'The server refuses to brew coffee because it is, permanently, a teapot.',
	'ERRORPAGES_INTERNAL_SERVER_ERROR' => 'Internal Server Error',
	'ERRORPAGES_INTERNAL_SERVER_ERROR_EXPLAIN' => 'The server encountered an unexpected condition and could not complete the request.',
	'ERRORPAGES_NOT_IMPLEMENTED' => 'Not Implemented',
	'ERRORPAGES_NOT_IMPLEMENTED_EXPLAIN' => 'The server does not support the functionality required to fulfil the request.',
	'ERRORPAGES_BAD_GATEWAY' => 'Bad Gateway',
	'ERRORPAGES_BAD_GATEWAY_EXPLAIN' => 'The server received an invalid response from an upstream server.',
	'ERRORPAGES_SERVICE_UNAVAILABLE' => 'Service Unavailable',
	'ERRORPAGES_SERVICE_UNAVAILABLE_EXPLAIN' => 'The server is temporarily unable to handle the request. Please try again later.',
	'ERRORPAGES_GATEWAY_TIMEOUT' => 'Gateway Timeout',
	'ERRORPAGES_GATEWAY_TIMEOUT_EXPLAIN' => 'The server did not receive a timely response from an upstream server.',
	'ERRORPAGES_HTTP_VERSION_NOT_SUPPORTED' => 'HTTP Version Not Supported',
	'ERRORPAGES_HTTP_VERSION_NOT_SUPPORTED_EXPLAIN' => 'The server does not support the HTTP protocol version used by the request.',
	'ERRORPAGES_UNKNOWN' => 'Unknown Request Error',
	'ERRORPAGES_UNKNOWN_EXPLAIN' => 'The request could not be completed.',
]);
