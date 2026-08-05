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
	'ACP_GALLERY_REMOTE_STORAGE_EXPLAIN' => 'Configure and verify private remote storage for Gallery files. Saving provider settings does not move or expose existing files.',
	'ACL_A_GALLERY_REMOTE_STORAGE' => 'Can manage Gallery remote storage',
	'GALLERY_CORE_NOT_FOUND' => 'The phpBB Gallery Core extension is required.',
	'REMOTE_STORAGE_ACTIVE_PROVIDER' => 'Active Gallery storage provider: %s',
	'REMOTE_STORAGE_CONNECTION_FAILED' => 'The remote storage connection test failed: %s',
	'REMOTE_STORAGE_AZURE_ACCOUNT' => 'Storage account name',
	'REMOTE_STORAGE_AZURE_ACCOUNT_KEY' => 'Storage account key',
	'REMOTE_STORAGE_AZURE_CONTAINER' => 'Private blob container',
	'REMOTE_STORAGE_AZURE_ENDPOINT' => 'Blob service endpoint',
	'REMOTE_STORAGE_AZURE_ENDPOINT_EXPLAIN' => 'Normally https://account.blob.core.windows.net. Custom endpoints can be used for compatible local test services; redirects are never followed.',
	'REMOTE_STORAGE_AZURE_PREFIX' => 'Object prefix',
	'REMOTE_STORAGE_AZURE_PREFIX_EXPLAIN' => 'Private namespace used inside the container. It must not be shared with unrelated files.',
	'REMOTE_STORAGE_AZURE_SETTINGS' => 'Azure Blob Storage connection',
	'REMOTE_STORAGE_ENVIRONMENT_OVERRIDES' => 'The following process environment variables override their ACP values. Secrets supplied this way are never displayed or stored by phpBB:',
	'REMOTE_STORAGE_MIGRATION' => 'Provider migration',
	'REMOTE_STORAGE_MIGRATION_ABORT' => 'Abort migration',
	'REMOTE_STORAGE_MIGRATION_ABORT_CONFIRM' => 'Abort the active provider migration? Verified destination copies will be retained, but the current source provider will remain active.',
	'REMOTE_STORAGE_MIGRATION_ABORTED' => 'The provider migration was aborted. The source provider remains active.',
	'REMOTE_STORAGE_MIGRATION_COMPLETE' => 'Every enumerated object was copied and verified. The destination provider is now active; source copies were retained for rollback.',
	'REMOTE_STORAGE_MIGRATION_CONTINUE' => 'Continue migration',
	'REMOTE_STORAGE_MIGRATION_DIRECTION' => 'Direction: %1$s → %2$s',
	'REMOTE_STORAGE_MIGRATION_EXPLAIN' => 'Files are copied in resumable batches. Gallery writes are mirrored during the operation, every object is verified by size and SHA-256, and source copies are retained.',
	'REMOTE_STORAGE_MIGRATION_FAILED' => 'The provider migration could not be started or resumed: %s',
	'REMOTE_STORAGE_MIGRATION_PROGRESS' => 'Variant: %1$s. Copied: %2$d; already identical: %3$d; failed attempts: %4$d.',
	'REMOTE_STORAGE_MIGRATION_RETRY' => 'Retry failed batch',
	'REMOTE_STORAGE_MIGRATION_START' => 'Start provider migration',
	'REMOTE_STORAGE_MIGRATION_START_CONFIRM' => 'Start the provider migration? Gallery file changes will be mirrored to both providers until every object has been copied and verified.',
	'REMOTE_STORAGE_MIGRATION_TARGET' => 'Destination provider',
	'REMOTE_STORAGE_MIGRATION_TARGET_INVALID' => 'The selected destination provider is invalid or is already active.',
	'REMOTE_STORAGE_MIGRATION_TO' => 'Migrate to %s',
	'REMOTE_STORAGE_LOCAL' => 'Local server storage',
	'REMOTE_STORAGE_NOT_ACTIVE_UNTIL_MIGRATION' => 'A configured remote provider remains inactive until its controlled migration is completed. This prevents existing Gallery files from becoming unavailable.',
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
	'REMOTE_STORAGE_SECRET_REQUIRED' => 'A provider credential or its corresponding environment variable is required.',
	'REMOTE_STORAGE_SECRET_RETAINED' => 'Leave empty to retain the configured secret.',
	'REMOTE_STORAGE_SETTINGS_SAVED' => 'The remote storage connection was verified and its settings were saved. No Gallery files were moved.',
	'REMOTE_STORAGE_SETTINGS_LOCKED' => 'Remote provider settings cannot be changed while a migration is active.',
	'REMOTE_STORAGE_TEST_AND_SAVE' => 'Test connection and save',
]);
