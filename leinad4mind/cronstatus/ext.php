<?php
/**
 *
 * @package       Cron Status
 * @copyright (c) 2014 - 2021 Igor Lavrov, John Peskens | (c) 2022-2026 Leinad4Mind
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\cronstatus;

class ext extends \phpbb\extension\base
{
	/**
	 * Check whether or not the extension can be enabled.
	 * Requires phpBB 3.3.0 and PHP 7.1.0.
	 *
	 * @return bool
	 */
	public function is_enableable()
	{
		return phpbb_version_compare(PHPBB_VERSION, '3.3.0', '>=') && version_compare(PHP_VERSION, '7.1.0', '>=');
	}

	/**
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 */
	public function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				if (empty($old_state))
				{
					$this->container->get('user')->add_lang_ext('leinad4mind/cronstatus', 'info_acp_cronstatus');
					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] .
						(isset($this->container->get('user')->lang['CRONSTAT_NOTICE']) ?
							sprintf($this->container->get('user')->lang['CRONSTAT_NOTICE'],
									$this->container->get('user')->lang['ACP_CAT_MAINTENANCE'],
									$this->container->get('user')->lang['ACP_FORUM_LOGS'],
									$this->container->get('user')->lang['ACP_CRON_STATUS_TITLE']) : ''));
				}

				// Run parent enable step method
				return parent::enable_step($old_state);

			break;

			default:

				// Run parent enable step method
				return parent::enable_step($old_state);

			break;
		}
	}
}
