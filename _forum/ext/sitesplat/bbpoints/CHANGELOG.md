# Changelog

All notable changes to BBPoints are documented in this file.

## [1.3.0] Unreleased

### Added

- Added a public ledger service for balance queries, system credits, system debits and user transfers.
- Added an atomic, retry-safe multi-recipient distribution API for integrations that split one payment between several users.
- Added retry-safe operation keys, typed operation results and dedicated validation, conflict and insufficient-funds exceptions.
- Added a post-operation event so integrations can send their own notifications without coupling them to the BBPoints ledger.
- Updated the ACP reset to clear API operation references together with the legacy movement ledger.

### Security

- Serialized concurrent debits against the payer account so simultaneous requests cannot spend the same balance twice.
- Kept existing and third-party legacy movements untouched by storing API idempotency references in a separate portable table.
