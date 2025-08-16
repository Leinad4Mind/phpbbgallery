<?php
/**
 *
 * No DEA Emails. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, Picaron, https://github.com/picaronin/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace pikaron\nodeaemails;

/**
* Extension class No DEA Emails for custom enable/disable/purge actions
*/
class ext extends \phpbb\extension\base
{
	/**
	* Check whether or not the extension can be enabled.
	* The current phpBB version should meet or exceed
	* the minimum version required by this extension:
	*
	* Requires phpBB 3.2.4 due to usage of http_exception.
	*
	* @return bool
	* @access public
	*/
	public function is_enableable()
	{
		$config = $this->container->get('config');
		$lang = $this->container->get('language');
		$lang->add_lang('nodeaemails', 'pikaron/nodeaemails');

		/**
		 * Check phpBB requirements
		 *
		 * Requires phpBB 3.2.4 or greater
		 *
		 * @return bool
		 */
		// Display a custom warning message if requirement fails.
		if (!phpbb_version_compare($config['version'], '3.2.4', '>='))
		{
			// Suppress the error in case of CLI usage
			@trigger_error($lang->lang('NO_DEA_EMAILS_INSTALL_ERROR'), E_USER_WARNING);
		}

		/**
		 * Check PHP requirements
		 *
		 * Requires PHP 5.6.0 or greater
		 *
		 * @return bool
		 */
		// Display a custom warning message if requirement fails.
		if (!phpbb_version_compare(PHP_VERSION, '5.6.0', '>='))
		{
			// Suppress the error in case of CLI usage
			@trigger_error($lang->lang('NO_DEA_EMAILS_PHP_ERROR'), E_USER_WARNING);
		}

		/**
		 * Check PHP curl requirements
		 *
		 * Requires PHP curl extension
		 *
		 * @return bool
		 */
		// Display a custom warning message if not extension 'curl' loaded.
		if (!extension_loaded('curl'))
		{
			// Suppress the error in case of CLI usage
			@trigger_error($lang->lang('NO_DEA_EMAILS_NO_CURL'), E_USER_WARNING);
		}

		return true;
	}
}
