# Remote Storage providers

This is the operational reference for phpBB Gallery Remote Storage 1.0.0. It records the credentials, security properties and effective limits of every provider supported by this release. Provider quotas and APIs can change; check the linked official documentation before a production migration.

## Shared behaviour

Remote Storage keeps the Gallery `source`, `medium` and `mini` objects private. Files are read by PHP after the normal Gallery permission checks; the add-on does not generate public provider URLs.

All HTTP providers use certificate verification, a 10-second connection timeout and a 60-second request timeout. Redirects are disabled. Provider responses are streamed and structured responses have explicit size and shape limits. Production endpoints must use HTTPS. Plain HTTP custom S3 or Azure endpoints are intended only for isolated local test services such as MinIO or Azurite.

`Test connection and save` must succeed before settings are persisted. The test creates a random private object, lists it, verifies its size and SHA-256, downloads and compares it, deletes it, and confirms that it no longer exists. Saving settings does not activate the provider or move Gallery files.

Provider changes use the ACP migration operation. It:

- accepts Local Storage and every registered remote provider as source or destination;
- copies objects in resumable batches of 25 by default and at most 100 per request;
- mirrors new writes to both providers while a migration is active;
- verifies every copy by size and SHA-256 before advancing;
- retries an object that changes while it is being copied;
- activates the destination only after all three variants are complete; and
- retains source copies for recovery instead of deleting them automatically.

Aborting leaves the source active and retains already copied destination objects. A migration between two remote providers may temporarily materialise one object under the phpBB cache directory, so the web server still needs enough local free space for the largest Gallery file.

## Provider summary

| Provider | Authentication | Upload used by the add-on | Main effective limitation |
| --- | --- | --- | --- |
| S3 / compatible | Access key, secret key, AWS SigV4 | One streamed `PUT` | No multipart upload; AWS S3 therefore limits one object to 5 GiB. Compatible services may differ. |
| Azure Blob | Storage account Shared Key | One streamed `Put Blob` | No block upload; API version 2023-11-03 limits one object to 5,000 MiB. |
| SFTP | Password plus pinned SSH host fingerprint | Temporary file followed by rename | Requires PHP `ext-ssh2`; password authentication only; checksums require downloading the object. |
| Dropbox | OAuth 2.0 refresh token | Simple upload below 150 MB, 8 MiB upload-session chunks otherwise | App Folder is recommended; quotas and maximum file size belong to the Dropbox account. |
| Google Drive | OAuth 2.0 refresh token with `drive.file` | Resumable upload in 8 MiB chunks | Only app-created or explicitly app-opened files are visible; Drive quota applies. |
| Box | OAuth 2.0 rotating refresh token | Simple upload up to 50 MiB, Box upload session above it | Refresh tokens are single-use and expire after 60 days if not refreshed. |
| MediaFire | Application ID/API key and account session | SHA-256 Instant Upload when possible, resumable upload otherwise | Requires the account password and sufficient direct-download bandwidth; account plan limits apply. |
| pCloud | Regional OAuth bearer token | One streamed `uploadfile` request | Upload is not resumable in this integration; the API host must match the account region. |
| Koofr | Email and application-specific password | Streamed HTTPS WebDAV `PUT` | WebDAV cannot reveal whether the dedicated folder was shared; the administrator must keep it private. |
| 4shared | OAuth 1.0 consumer and access-token pair | Simple upload below 150 MiB, 8 MiB chunks otherwise | Free accounts/files may be removed after 180 days without login; the integration rejects over 100,000 entries per variant. |

The Gallery upload-size, PHP request-size, provider quota and web-server timeout limits still apply. The lowest applicable limit wins.

## Configuration and secret overrides

The ACP shows every required field. Except where noted below, the corresponding process variable is `PHPBBGALLERY_<PROVIDER>_<FIELD>`, in uppercase. A process variable overrides the ACP value and is neither displayed nor stored by phpBB. Restart PHP/FPM or the local development service after changing its environment.

| Provider | ACP fields |
| --- | --- |
| S3 | `endpoint`, `bucket`, `access_key`, `secret_key`, `region`, `prefix` |
| Azure | `endpoint`, `account`, `container`, `account_key`, `prefix` |
| SFTP | `host`, `port`, `username`, `password`, `host_fingerprint`, `root` |
| Dropbox | `app_key`, `app_secret`, `refresh_token`, `root` |
| Google Drive | `client_id`, `client_secret`, `refresh_token`, `root_name` |
| Box | `client_id`, `client_secret`, `refresh_token`, `root_name` |
| MediaFire | `application_id`, `api_key`, `email`, `password`, `root_name` |
| pCloud | `api_host`, `access_token`, `root_name` |
| Koofr | `email`, `app_password`, `root_name` |
| 4shared | `consumer_key`, `consumer_secret`, `access_token`, `access_token_secret`, `root_name` |

For example, Koofr accepts `PHPBBGALLERY_KOOFR_EMAIL`, `PHPBBGALLERY_KOOFR_APP_PASSWORD` and `PHPBBGALLERY_KOOFR_ROOT_NAME`. Box is the exception: its rotating `refresh_token` must be stored by the ACP so the add-on can replace it atomically after use. Box environment overrides are limited to `client_id`, `client_secret` and `root_name`.

## S3 and S3-compatible storage

Use a dedicated private bucket or prefix and an IAM identity restricted to the required object operations. The provider uses path-style URLs and AWS Signature Version 4, conditional creation with `If-None-Match: *`, streamed reads and SHA-256 object metadata.

The add-on does not inspect bucket policies or ACLs, because their APIs vary between compatible products. It is the administrator's responsibility to block public access. It also does not implement multipart upload: AWS documents a [5 GiB limit for a single `PUT`](https://docs.aws.amazon.com/AmazonS3/latest/userguide/upload-objects.html), although S3 itself supports much larger objects through [multipart upload](https://docs.aws.amazon.com/AmazonS3/latest/userguide/qfacts.html). MinIO, QNAP and other S3-compatible services can impose different limits and signature/region requirements.

Defaults are region `us-east-1` and prefix `phpbbgallery`. Use the exact endpoint and region required by the service. Do not reuse the prefix for unrelated data.

## Azure Blob Storage

Use a dedicated private container. The add-on authenticates with Shared Key, creates the container if necessary, verifies that the service does not report public blob/container access, performs conditional writes and stores SHA-256 in blob metadata.

It uses REST API version 2023-11-03 and one `Put Blob` request rather than block uploads. Microsoft documents a [5,000 MiB single-write limit](https://learn.microsoft.com/en-us/rest/api/storageservices/put-blob) for service versions from 2019-12-12 onwards. Account quota, request timeout and the Gallery limit can be lower. The default prefix is `phpbbgallery`.

## SFTP

The SFTP provider requires the [PHP SSH2 extension](https://www.php.net/manual/en/book.ssh2.php). Configure a dedicated account and an absolute private root, such as `/srv/private/gallery`, which is not served by the remote web server.

The SHA-1 fingerprint of the SSH host key is mandatory and checked before password authentication. Obtain it through a trusted administrative channel; never copy an unverified fingerprint from the first failed connection. The current integration does not support SSH-agent or private-key authentication.

Uploads are written to a temporary name and renamed into place. The generic SFTP protocol exposes no portable server-side SHA-256 operation, so migration verification and checksum requests download the object. There is no resumable chunk session: an interrupted object upload restarts that object. Capacity, maximum file size and throttling are defined by the SFTP server.

## Dropbox

Create a Dropbox API application with **App Folder** content access where possible. Enable only `files.metadata.read`, `files.content.read` and `files.content.write`, then complete OAuth with `token_access_type=offline` to obtain a refresh token. Dropbox explains App Folder, scopes and offline tokens in its [OAuth guide](https://developers.dropbox.com/oauth-guide).

The provider fixes requests to Dropbox's API and content hosts. Files below 150 MB use the simple endpoint; larger files use 8 MiB upload-session chunks, as recommended by Dropbox's [performance guide](https://developers.dropbox.com/dbx-performance-guide). The account quota and Dropbox file-size limits still apply. Keep the configured root, `/phpbbgallery` by default, exclusive to the Gallery.

## Google Drive

Create a Google OAuth client and request offline access with only the non-sensitive `https://www.googleapis.com/auth/drive.file` scope. Google documents the scope's per-file access in [Choose Google Drive API scopes](https://developers.google.com/workspace/drive/api/guides/api-specific-auth) and refresh-token creation in its [OAuth web-server guide](https://developers.google.com/identity/protocols/oauth2/web-server).

The add-on creates a dedicated folder (`phpbbgallery` by default), uses fixed Google API hosts and always performs an 8 MiB [resumable upload](https://developers.google.com/workspace/drive/api/guides/manage-uploads). With `drive.file`, it cannot enumerate arbitrary pre-existing Drive content. Do not create duplicate same-name objects in the managed folder: ambiguous metadata fails closed. Storage quota and Google account limits apply.

## Box

Create a Box OAuth 2.0 application and obtain a refresh token for the storage account. The dedicated folder (`phpbbgallery` by default) must be owned by the account, private and not a shared/public folder.

Box refresh tokens are single-use: every refresh invalidates the old token and returns a replacement. The add-on serialises refreshes with a lock and persists the replacement atomically. Consequently the refresh token cannot be supplied through an environment variable. Box states that an unused refresh token [expires after 60 days](https://developer.box.com/guides/authentication/tokens/refresh), after which the application must be authorised again.

The simple upload endpoint is used up to 50 MiB. Larger files use Box upload sessions; Box recommends this for [files over 50 MB](https://developer.box.com/reference/post-files-content) and documents a seven-day session lifetime in its [chunked upload guide](https://developer.box.com/guides/uploads/chunked). The account's maximum file size and quota remain authoritative.

## MediaFire

Register an application, then configure its application ID, API key and a dedicated MediaFire account. The provider follows the official [Core API 1.5 getting-started guide](https://www.mediafire.com/developers/core_api/1.5/getting_started/) and fixes all authenticated API requests to MediaFire's HTTPS host.

MediaFire currently requires the account email and password to obtain a signed Session Token v2. Use a dedicated account and a unique password that is not used anywhere else. Session signing state is rotated and persisted under a local lock. The provider keeps folders private, tries SHA-256 Instant Upload first and uses resumable upload when the content is not already present. It rejects an API-supplied upload unit above 64 MiB or a plan requiring more than 100,000 units. Download links are consumed by the server, validated as HTTPS MediaFire hosts and never exposed to Gallery users.

MediaFire plan quota, retention, API throttling and direct-download bandwidth remain external service limits. The account must have enough download bandwidth for every Gallery view that reads a remote object.

## pCloud

Create a pCloud OAuth application and obtain an access token. pCloud has separate data regions: use `eapi.pcloud.com` for European accounts or `api.pcloud.com` for United States accounts. The host must be the one returned during authorisation; pCloud documents this requirement in its [API introduction](https://docs.pcloud.com/).

The token is sent only as a bearer header to the selected fixed regional host. The add-on requires an exclusively owned folder, rejects shared folders and public links, streams uploads and consumes validated private download links on the server. Uploads are not chunk-resumable in this integration, so a failed large upload restarts the object. Where the US API omits SHA-256, verification streams the object back and calculates it locally. Account quota and plan limits apply.

## Koofr

The provider uses only Koofr's official HTTPS WebDAV endpoint, `https://app.koofr.net/dav/Koofr`. Koofr documents the endpoint and required email identity in [How do I connect a service through WebDAV?](https://koofr.eu/help/koofr_with_webdav/how-do-i-connect-a-service-to-koofr-through-webdav/).

Authentication is exclusively by a revocable application-specific password. Never enter the main account password. Koofr explains how to create the correct credential in [How to generate an application-specific password](https://koofr.eu/help/koofr_with_webdav/which-password-to-use-when-connecting-via-webdav/).

The implementation uses conditional creation/replacement, streaming transfers, a fixed host without redirects and bounded, fail-closed WebDAV/XML validation in accordance with [RFC 4918](https://www.rfc-editor.org/info/rfc4918/). It rejects DTD/entity declarations, external or nested `href` values, duplicate or ambiguous properties and XML responses above 16 MiB.

WebDAV does not expose Koofr sharing state. The add-on therefore cannot prove that the folder is private: never share the dedicated Gallery folder. Storage quota, maximum file size and traffic policies depend on the Koofr plan.

## 4shared

Register an application in 4shared **My apps**, complete OAuth 1.0 authorisation, and configure the consumer key/secret and access token/secret. Use a verified, active storage account. The official API reference is the [4shared developer documentation](https://www.4shared.com/developer/docs/?locale=pt).

Requests use OAuth 1.0 HMAC-SHA1 and the fixed `api.4shared.com` and `upload.4shared.com` API v1_2 hosts. The provider creates private, exclusively owned folders and `ownerOnly` files, verifies size and MD5 returned by the service, and rejects content reported as infected. Since the API has no general conditional write, publication and replacement use locked, recoverable temporary/backup names.

Files below 150 MiB use simple upload and larger files use 8 MiB chunks, subject to the account's reported `uploadSizeLimit` and free space. The implementation rejects more than 100,000 files or folders in one variant to bound reconciliation work. According to 4shared's service policy reflected by its API guidance, free accounts and their files may be removed after 180 days without login; such an account is inappropriate for unattended durable storage.

## Installation example: Koofr

The same extension installation and migration flow applies to every provider; only credential preparation and ACP fields differ.

1. Back up the phpBB database and the complete local `files/phpbbgallery/core/` tree. Confirm that phpBB Gallery Core is present.
2. Copy the package so its files are under `ext/phpbbgallery/remotestorage/`. Do not nest an extra package directory.
3. In **ACP > Customise > Manage extensions**, enable **phpBB Gallery Add-on: Remote Storage**. The add-on enables Gallery Core automatically when Core is available; otherwise activation stops with a dependency error. Guzzle and SimpleXML from a supported phpBB/PHP installation are required.
4. In Koofr, open **Preferences > Password > App passwords**, generate a new password named for this phpBB board, and copy it once. Do not use the main Koofr password.
5. In **ACP > Extensions > phpBB Gallery > Remote Storage**, enter the Koofr account email, application password and a dedicated folder name such as `phpbbgallery`. Do not create a public/share link for this folder.
6. Select **Test connection and save**. A successful result means the complete create/list/checksum/read/delete cycle worked. It does not move existing files or make Koofr active.
7. Under **Provider migration**, select Koofr, choose **Start provider migration** and confirm. Continue the resumable batches until the ACP reports completion. Do not change credentials, disable Core/Remote Storage, or delete either copy during this process.
8. Verify several thumbnails, medium images, original downloads and watermarked originals while logged in with representative permissions. Keep the local source copy until normal backups and provider monitoring have been proven.

For a new empty Gallery, still use the migration operation: it performs the controlled activation even when there are no objects. To return to local storage or move to another provider later, configure and test the destination, then run another provider migration. Do not change the active provider directly in the database.

## Operational checklist

- Keep provider credentials out of source control and rotate them after any suspected disclosure.
- Grant only the scopes and paths described for the selected provider.
- Keep provider roots private and exclusive to one phpBB Gallery installation.
- Monitor quota, billing, retention, API rate limits and credential expiry.
- Retain independent backups; mirrored migration copies are not a backup schedule.
- Test restore/migration back to Local Storage before relying on a provider in production.
- After upgrades, run **Test connection and save** before starting a provider migration, then verify source, medium and mini delivery.
