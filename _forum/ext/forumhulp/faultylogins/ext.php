<?php
/**
 *
 * @package phpBB Extension - Faulty Logins
 * @copyright (c) 2014 John Peskens (http://ForumHulp.com)
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\faultylogins;

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		return function_exists('sodium_crypto_box_seal')
			&& function_exists('sodium_crypto_pwhash')
			&& function_exists('sodium_crypto_aead_xchacha20poly1305_ietf_encrypt');
	}
}
