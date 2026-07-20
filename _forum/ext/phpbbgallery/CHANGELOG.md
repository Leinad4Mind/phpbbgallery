# Changelog

All notable changes to the phpBB Gallery extension suite are documented in this file.

## Unreleased

### Security

- Replaced ZIP extraction during gallery uploads with a controlled per-entry extractor that rejects path traversal, absolute paths, symbolic-link entries, unsupported file types, duplicate destinations, and archive entries whose detected content does not match their extension.
- Added ZIP bomb protections for entry count, individual and cumulative uncompressed size, compression ratio, archive metadata inconsistencies, and extraction time, with guaranteed temporary-file cleanup.
- Replaced executable PHP state files in ACP Import with validated, size-limited JSON state tied to the administrator who created it and identified by a cryptographically random token.
- Restricted ACP Import to enumerated direct-child image files inside the import directory, rejecting path traversal, symbolic links, unsupported formats, disguised image types, duplicate names, and destination overwrites.
- Added migration and runtime cleanup for legacy ACP Import PHP state and error files.

### Fixed

- Prevented ACP Import from copying files after image validation had failed.
- Updated gallery and user image counters only for images imported successfully.
- Preserved ACP Import errors safely in JSON state between batches and corrected the final successful-image count.

### Tests

- Added permanent ZIP extractor tests covering valid archives, traversal attempts, disguised files, duplicate paths, malformed metadata, resource limits, compression-ratio abuse, and cleanup behavior.
- Added permanent ACP Import tests covering state validation, non-executable persistence, legacy-state cleanup, path containment, symbolic links, MIME validation, safe copying, language completeness, and architectural regressions.
- Validated both security phases with PHP 7.4, 8.1, 8.2, 8.4, and 8.5.
