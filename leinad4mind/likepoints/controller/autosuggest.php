<?php

/**
 *
 * LikePoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2022 Leinad4Mind All rights reserved
 * @license Proprietary
 *
 */

namespace leinad4mind\likepoints\controller;

use phpbb\db\driver\driver_interface;
use phpbb\request\request;
use phpbb\user;

/**
 * @ignore
 */

use phpbb\json_response;

class autosuggest
{
   protected $db;
   protected $request;
   protected $user;
   protected $users_table;

   /**
    * Constructor
    */
   public function __construct(driver_interface $db, request $request, user $user, $users_table)
   {
      $this->db = $db;
      $this->request = $request;
      $this->user = $user;
      $this->users_table = $users_table;
   }

   public function auto_complete()
   {
      if ($this->request->is_ajax()) {
         $json_response = new json_response();
         $term = $this->request->variable('username', '');
         $term = trim($term);
         if (empty($term)) {
            $json_response->send([]);
            return;
         }
         $sql = "SELECT username FROM $this->users_table WHERE user_ip != '' LIMIT 10";
         $this->db->sql_query($sql);
         $rows  = $this->db->sql_fetchrowset();
         $usernames = [];
         foreach ($rows as $row) {
            $usernames[] = $row->username;
         }
         $json_response->send($usernames);
      }
   }
}