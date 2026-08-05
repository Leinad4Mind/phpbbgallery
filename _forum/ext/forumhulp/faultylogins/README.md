# Faulty Logins

Faulty Logins records failed phpBB authentication attempts in a dedicated ACP page. Attempted passwords are encrypted immediately with a public key and can only be revealed by supplying the administrator passphrase.

## Security model

- PHP Sodium sealed boxes encrypt new attempts without keeping a decryption key online.
- The private key is protected with Argon2id and XChaCha20-Poly1305.
- The passphrase and decrypted private key are never stored in the database, cache, cookie or phpBB session.
- Changing the passphrase preserves access to existing records because the same private key is rewrapped.
- An offline recovery key can restore access if the passphrase is lost.
- Passwords are masked by default and unlocking applies only to the current ACP response.
- Repeated writes are throttled per IP and old records are automatically removed.

## Requirements

- phpBB 3.3 or later
- PHP 7.2 or later
- PHP Sodium extension

After enabling the extension, open **ACP > Extensions > Faulty Logins > Security and retention** and configure the initial passphrase. Store the displayed recovery key offline.

## Upgrading from 3.1.x

Legacy `LOG_FAULTY_LOGINS` entries may contain plaintext passwords. During initial setup, valid legacy records are encrypted into the dedicated table and every unsafe legacy entry is removed from the phpBB admin log.

## License

GNU General Public License v2.0 only.
