<?php

/**
 *
 * LikePoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
 * @license Proprietary
 *
 */

namespace leinad4mind\likepoints\controller;

use phpbb\db\driver\driver_interface;
use phpbb\request\request;
use phpbb\user;
use phpbb\user_loader;

/**
 * @ignore
 */

use phpbb\json_response;

class main
{
   protected $db;
   protected $request;
   protected $user;
   protected $users_table;
   protected $posts_table;
   /** @var \phpbb\user_loader */
   protected $user_loader;

   /**
    * Constructor
    */
   public function __construct(driver_interface $db, request $request, user $user, user_loader $user_loader, $users_table, $posts_table)
   {
      $this->db = $db;
      $this->request = $request;
      $this->user = $user;
      $this->users_table = $users_table;
      $this->posts_table = $posts_table;
      $this->user_loader = $user_loader;
   }

   public function auto_complete()
   {
      if ($this->request->is_ajax()) {
         $json_response = new json_response();
         $term = $this->request->variable('term', '');
         $term = strtolower(trim($term));
         if (empty($term)) {
            $json_response->send([]);
            return;
         }
         $mode = $this->request->variable('mode', 'post');
         $post_id = (int) $this->request->variable('p', '');
         $topic_id = (int) $this->request->variable('topic_id', '');

         $predicate = ' AND u.username_clean ' . $this->db->sql_like_expression($term . $this->db->get_any_char());
         if (($mode == 'edit' || $mode == 'reply') && empty($topic_id)) {
            $sql = 'SELECT topic_id FROM ' . $this->posts_table . ' WHERE post_id = ' . $post_id;
            $result = $this->db->sql_query($sql);
            $row = $this->db->sql_fetchrow($result);
            $topic_id = $row['topic_id'] ?? 0;
         }
         if (!empty($topic_id)) {
            $sql = 'SELECT poster_id FROM ' . $this->posts_table . ' WHERE topic_id = ' . $topic_id;
            $result = $this->db->sql_query($sql);
            $poster_ids = [];
            while ($row = $this->db->sql_fetchrow($result)) {
               $poster_ids[] = $row['poster_id'];
            }
            if (!empty($poster_ids)) {
               $predicate .= ' AND u.user_id NOT IN(' . implode(',', array_map('intval', $poster_ids)) . ')';
            }
         }

         $sql = 'SELECT DISTINCT(u.username), u.user_id, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height
				FROM ' . $this->users_table . ' u
				WHERE u.user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')' . $predicate . '
				ORDER BY u.user_posts DESC';
         $result = $this->db->sql_query_limit($sql, 10);
         $usernames = [];
         $style_path = $this->user->style['style_path'] ?? 'prosilver';
         while ($row = $this->db->sql_fetchrow($result)) {
            $usernames[] = [
               $row['username'],
               $row['user_avatar'] ? '<div class="nemtion">' . phpbb_get_user_avatar(
                  array(
                     'avatar'         => $row['user_avatar'],
                     'user_id'           => $row['user_id'],
                     'avatar_type'      => $row['user_avatar_type'],
                     'avatar_width'      => $row['user_avatar_width'],
                     'avatar_height'      => $row['user_avatar_height']
                  )
               ) . ' ' . $row['username'] . '</div>' :
                  '<div class="nemtion"><img src="' .
                  generate_board_url() . '/styles/' . $style_path . '/theme/images/no-avatar.png'
                  . '"> ' . $row['username'] . '</div>',
            ];
         }
         $this->db->sql_freeresult($result);
         $json_response->send($usernames);
      }
   }
}
