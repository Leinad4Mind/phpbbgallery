# phpBB Gallery

phpBB Gallery provides image albums for phpBB 3.3. The current release line
requires PHP 8.1 or later. Install the Core in `ext/phpbbgallery/core`; optional
add-ons use sibling directories under `ext/phpbbgallery/`.

## Core

| Component | Version | Description |
| --- | --- | --- |
| phpBB Gallery | 4.2.0 | Albums, images, comments, ratings, moderation, search, personal galleries and curated featured images. |

## Free add-ons

| Add-on | Version | Description |
| --- | --- | --- |
| ACP Cleanup | 1.4.0 | Finds and safely repairs or removes inconsistent image files and records. |
| ACP Import | 1.4.0 | Imports controlled batches of server-side images into an album. |
| Contests | 1.0.0 | Adds contest phases, anonymous entries, voting and winner publication. |
| Exif | 1.4.0 | Displays photographic metadata stored in uploaded images. |
| Favorite | 1.0.0 | Lets members bookmark images and manage them in the UCP. |
| Feed | 1.0.0 | Publishes recent Gallery images as an ATOM feed. |
| TIFF | 1.0.0 | Accepts verified TIFF originals through Imagick and creates browser-safe WebP variants. |

## Premium add-ons

| Add-on | Version | Description |
| --- | --- | --- |
| BBPoints Images | 1.0.0 | Adds upload rewards and paid original-file downloads through BBPoints. |
| BBTags Images | 1.0.0 | Adds shared tags, moderation, autocomplete and multi-tag image search. |
| Export | 1.0.0 | Exports Gallery images to controlled ZIP archives using their display names. |
| Image Fields | 1.1.0 | Adds administrator-defined, translated and album-aware metadata fields to images. |
| Image Revisions | 1.0.0 | Retains bounded histories of replaced image files for preview and rollback. |
| Remote Storage | 1.1.0 | Stores private Gallery objects in S3-compatible, Azure Blob, SFTP, Dropbox, Google Drive, OneDrive, Box, MediaFire, pCloud, generic WebDAV, Koofr or 4shared storage with verified provider migrations. |

See the Remote Storage [provider requirements, limitations and installation
guide](remotestorage/PROVIDERS.md) before configuring or migrating production
files.

The Free and Premium labels describe distribution tiers, not different source
licences. Every packaged component declares its own licence in `composer.json`.

## Update metadata

Each component has an independent phpBB version check. The corresponding
`gallery-*.json` files in this directory must be published at the root of the
`satanasov/phpbbgallery` default branch whenever a release version changes.

## Building release packages

The release builder archives a committed Git ref, applies the suite-level
`export-ignore` rules and creates one package per component with the required
`phpbbgallery/<component>/` directory structure:

```console
php _forum/ext/phpbbgallery/build_release_packages.php --output=build/phpbbgallery --ref=HEAD
```

When this directory is the repository root, use `php build_release_packages.php`
instead. Uncommitted changes are intentionally excluded. The output contains 15
versioned ZIP files, `SHA256SUMS` and a deterministic `release-manifest.json`.
