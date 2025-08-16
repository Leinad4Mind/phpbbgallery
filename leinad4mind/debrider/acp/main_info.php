<?php

/**
 * Debrider extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\debrider\acp;

class main_info
{
  public function module()
  {
    return [
      'filename'  => '\leinad4mind\debrider\acp\main_module',
      'title'     => 'ACP_MAIN_MODULE_TITLE',
      'modes'    => [
        'settings'  => [
          'title' => 'SETTINGS',
          'auth'  => 'acl_a_board',
        ],
      ],
    ];
  }
}
