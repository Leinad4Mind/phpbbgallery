<?php

/**
 *
 * @package PM Welcome
 * @copyright (c) 2020 RMcGirr83
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\pmwelcome\core;

use phpbb\db\driver\driver_interface as db;
use phpbb\language\language;
use phpbb\request\request;
use Symfony\Component\HttpFoundation\JsonResponse;

class pmwelcome
{
   /** @var db */
   protected $db;

   /** @var language */
   protected $language;

   /** @var request */
   protected $request;

   /** @var string root path */
   protected $root_path;

   /** @var string phpEx */
   protected $php_ext;

   public function __construct(
      db $db,
      language $language,
      request $request,
      string $root_path,
      string $php_ext
   ) {
      $this->db = $db;
      $this->language = $language;
      $this->request = $request;
      $this->root_path = $root_path;
      $this->php_ext = $php_ext;
   }

   /**
    * sender_info					used in the ACP when choosing the "sender"
    *
    * @param user_id				user id
    * @return array					array of user info or error if not found, json response if via ajax call
    * @access public
    */
   public function sender_info($user_id)
   {
      $sender_info = [];

      $sql = 'SELECT user_id, username, user_colour
			FROM ' . USERS_TABLE . "
			WHERE user_id = " . (int) $user_id;
      $result = $this->db->sql_query($sql);
      $sender_info = $this->db->sql_fetchrow($result);
      $this->db->sql_freeresult($result);

      if (!isset($sender_info['username'])) {
         $sender_info['error'] = $this->language->lang('ACP_PMWELCOME_NO_USER');
      }

      if ($this->request->is_ajax()) {
         if (!isset($sender_info['username'])) {
            $json = new JsonResponse(array(
               'error'     => true,
            ));
         } else {
            $json = new JsonResponse(array(
               'sender_link'     => get_username_string('full', $sender_info['user_id'] ?? ANONYMOUS, $sender_info['username'] ?? $this->language->lang('GUEST'), $sender_info['user_colour'] ?? ''),
            ));
         }
         return $json;
      }

      return $sender_info;
   }
}