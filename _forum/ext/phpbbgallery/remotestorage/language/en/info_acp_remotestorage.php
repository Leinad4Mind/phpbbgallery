<?php
/**
 * phpBB Gallery - Remote Storage language
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'ACP_GALLERY_REMOTE_STORAGE' => 'Remote Storage',
	'ACP_GALLERY_REMOTE_STORAGE_EXPLAIN' => 'Configure and verify private object storage for Gallery files. Saving these settings does not move files or activate S3.',
	'ACL_A_GALLERY_REMOTE_STORAGE' => 'Can manage Gallery remote storage',
	'GALLERY_CORE_NOT_FOUND' => 'The phpBB Gallery Core extension is required.',
	'REMOTE_STORAGE_ACTIVE_PROVIDER' => 'Active Gallery storage provider: %s',
	'REMOTE_STORAGE_CONNECTION_FAILED' => 'The S3 connection test failed: %s',
	'REMOTE_STORAGE_ENVIRONMENT_OVERRIDES' => 'The following process environment variables override their ACP values. Secrets supplied this way are never displayed or stored by phpBB:',
	'REMOTE_STORAGE_NOT_ACTIVE_UNTIL_MIGRATION' => 'S3 will remain inactive until the controlled migration is completed. This prevents existing Gallery files from becoming unavailable.',
	'REMOTE_STORAGE_REQUIREMENTS_MISSING' => 'Remote Storage requires the HTTP client and SimpleXML components supplied with a supported phpBB installation.',
	'REMOTE_STORAGE_S3_ACCESS_KEY' => 'Access key',
	'REMOTE_STORAGE_S3_BUCKET' => 'Bucket',
	'REMOTE_STORAGE_S3_ENDPOINT' => 'S3 endpoint',
	'REMOTE_STORAGE_S3_ENDPOINT_EXPLAIN' => 'For example, https://s3.eu-west-1.amazonaws.com or the private endpoint of MinIO/QNAP. Redirects are never followed.',
	'REMOTE_STORAGE_S3_PREFIX' => 'Object prefix',
	'REMOTE_STORAGE_S3_PREFIX_EXPLAIN' => 'Private namespace used inside the bucket. It must not be shared with unrelated files.',
	'REMOTE_STORAGE_S3_REGION' => 'Region',
	'REMOTE_STORAGE_S3_REGION_EXPLAIN' => 'Use the region required by the service. Many compatible providers use us-east-1.',
	'REMOTE_STORAGE_S3_SECRET_KEY' => 'Secret key',
	'REMOTE_STORAGE_S3_SETTINGS' => 'S3/S3-compatible connection',
	'REMOTE_STORAGE_SECRET_REQUIRED' => 'A secret key or PHPBBGALLERY_S3_SECRET_KEY environment variable is required.',
	'REMOTE_STORAGE_SECRET_RETAINED' => 'Leave empty to retain the configured secret.',
	'REMOTE_STORAGE_SETTINGS_SAVED' => 'The S3 connection was verified and the settings were saved. No Gallery files were moved.',
	'REMOTE_STORAGE_TEST_AND_SAVE' => 'Test connection and save',
]);
