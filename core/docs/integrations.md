# Gallery integration API

Gallery Core exposes a local-file import port for optional extensions. It is a
stable boundary for bridges; callers must not construct Gallery database rows,
storage keys or upload requests themselves.

## Discovery and versioning

The public service ID is `phpbbgallery.core.integration.image_importer` and its
contract is `phpbbgallery\core\integration\image_importer_interface`.
An optional extension must first confirm that Gallery Core is enabled and that
the container has this service. It must then inspect `get_capabilities()` and
reject a `contract_version` it does not support.

Gallery Core never depends on a bridge. Disabling or uninstalling a bridge must
leave normal Gallery operation unchanged.

## Import boundary

The importer accepts an `image_import_request` and returns an
`image_import_result` containing the finalized Gallery image ID and row. A
request identifies:

- the calling extension using its lowercase `vendor/extension` name;
- a readable private temporary file and its untrusted original filename;
- the destination album and image metadata;
- the phpBB user responsible for the operation;
- optional non-secret correlation context.

Only local files are accepted. A bridge that starts with a remote poster must
fetch it asynchronously and enforce its own URL, DNS/IP, redirect, response
size and timeout policy before calling Gallery. Gallery then applies its normal
extension allowlist, MIME/image validation, decompression-bomb protection,
dimension limits, resize rules and storage provider pipeline again.

Calling `import()` transfers ownership of a valid local temporary file to
Gallery. The caller must not reuse it; it may safely attempt to remove the old
temporary path in a `finally` block because Gallery normally moves it during
acceptance. Never put access tokens, credentials or remote signed URLs in the
transient context.

The importer enforces Gallery upload permission, album lock/type policy, batch,
album and per-user quotas, and the actor's approval permission. A background
worker may supply the original actor ID; delegated actors are deliberately
limited to public albums. A future Media Topics bridge should therefore use an
ACP-selected public asset album and either the initiating user or a dedicated
phpBB service account.

Programmatic imports synchronize image and album counters but do not emit the
interactive new-image notification flow. Upload lifecycle events contain an
`operation_origin` of `integration`, allowing add-ons to avoid interactive-only
effects such as upload rewards.

## Events

| Event | Timing and purpose |
|---|---|
| `phpbbgallery.core.integration.import_image_validate` | Before Gallery takes ownership of the local file. A listener may set `validation_error`. |
| `phpbbgallery.core.upload.prepare_file_before` | During the normal Gallery validation pipeline; now includes `operation_origin` and `operation_context`. |
| `phpbbgallery.core.upload.update_image_after` | After the image row is finalized; includes the same origin/context and remains available to existing Gallery add-ons. |
| `phpbbgallery.core.integration.image_imported` | After counters are synchronized. Includes typed request/result objects, image and album data, actor and context. |
| `phpbbgallery.core.image.state_changed` | Existing post-persistence lifecycle event for delete, move, approve, unapprove, lock and deletion-request transitions. |

Listeners must treat event context as transient. Durable bridge associations,
idempotency keys, provider attribution and reference counts belong to the bridge
database. The bridge should listen for `image.state_changed` with operation
`delete`, remove or repair its association, and run a periodic reconciliation
for missed events or periods when either extension was disabled.

## Minimal caller outline

```php
$importer = $container->get('phpbbgallery.core.integration.image_importer');
$request = new \phpbbgallery\core\integration\image_import_request(
	'leinad4mind/mediatopicsgallery',
	$private_temp_path,
	'poster.jpg',
	$gallery_album_id,
	$localized_title . ' poster',
	$attribution,
	'pt-PT',
	false,
	$actor_user_id,
	['operation_id' => $operation_id]
);
$result = $importer->import($request);
$gallery_image_id = $result->get_image_id();
```

The bridge must save its durable association immediately after a successful
return and make retries idempotent on its own operation key. If an
`image_import_exception` contains a non-null `get_import_result()`, the image was
already finalized before a listener or counter synchronization failed. The
bridge must save that returned image ID and queue reconciliation; it must not
upload the asset again.
