<?php

/**
 *
 * @package PM Welcome
 * @copyright (c) 2015 Anvar
 * @copyright (c) 2020 RMcGirr83
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\pmwelcome\acp;

class pmwelcome_info
{
   function module()
   {
      return array(
         'filename'   => '\leinad4mind\pmwelcome\acp\pmwelcome_module',
         'title'      => 'ACP_PMWELCOME',
         'version'   => '1.2.0',
         'modes'   => array(
            'settings'   => array('title' => 'ACP_PMWELCOME_SETTINGS', 'auth' => 'ext_leinad4mind/pmwelcome && acl_a_board', 'cat' => array('ACP_BOARD_CONFIGURATION')),
         ),
      );
   }
}