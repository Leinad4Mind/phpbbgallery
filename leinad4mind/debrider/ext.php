<?php

/**
 * Debrider extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\debrider;

class ext extends \phpbb\extension\base
{
   /**
    * Check whether or not the extension can be enabled.
    * The current phpBB version should meet or exceed
    * the minimum version required by this extension:
    *
    * Requires phpBB 3.3.0 and PHP 7.1.0.
    *
    * @return bool
    * @access public
    */
   public function is_enableable()
   {
      if (!version_compare(PHP_VERSION, '7.1.0', '>=')) {
         $this->container->get('user')->add_lang_ext('leinad4mind/debrider', 'info_acp_main');
         return [$this->container->get('user')->lang('PHP_ERROR')];
      }

      if (!phpbb_version_compare(PHPBB_VERSION, '3.3.0', '>=')) {
         $this->container->get('user')->add_lang_ext('leinad4mind/debrider', 'info_acp_main');
         return [$this->container->get('user')->lang('PHPBB_ERROR')];
      }

      return true;
   }

   /**
    * @param mixed $old_state State returned by previous call of this method
    * @return mixed Returns false after last step, otherwise temporary state
    * @access public
    */
   function enable_step($old_state)
   {
      switch ($old_state) {
         case '': // Empty means nothing has run yet
            if (empty($old_state)) {
               $this->container->get('user')->add_lang_ext('leinad4mind/debrider', 'info_acp_main');
               $this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] .
                  (isset($this->container->get('user')->lang['INSTALL_NOTICE']) ? $this->container->get('user')->lang['INSTALL_NOTICE'] : ''));
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
