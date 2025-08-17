<?php

/**
 *
 * @package PM Welcome
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\pmwelcome\migrations;

class v_1_0_3 extends \phpbb\db\migration\migration
{
   static public function depends_on()
   {
      return array('\leinad4mind\pmwelcome\migrations\v_1_0_2');
   }

   public function effectively_installed()
   {
      return isset($this->config['pmwelcome_version']) && version_compare($this->config['pmwelcome_version'], '1.0.3', '>=');
   }

   public function update_data()
   {
      return array(
         // Update version
         array('config.update', array('pmwelcome_version', '1.0.3')),
      );
   }

   public function revert_data()
   {
      return array(
         // Remove version
         array('config.remove', array('pmwelcome_version')),
      );
   }
}
