<?php

/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\topicstatistics\migrations;

use phpbb\db\migration\migration;

class m2_new_data extends migration
{
   /**
    * @return array
    */
   public static function depends_on()
   {
      return ['\leinad4mind\topicstatistics\migrations\m1_initial_data'];
   }

   /**
    * @return array
    */
   public function update_data()
   {
      return [
         ['config.add', ['user_limit', 1000]],
         ['config.add', ['user_viewprofile', 1]],
         ['config.add', ['topics_display_bookmarks_avatars', 1]],
         ['config.add', ['topics_display_followers_avatars', 1]],
         ['config.add', ['forums_display_statistics', 1]],
         ['config.add', ['forums_display_visit', 1]],
         ['config.add', ['forums_display_followers', 1]],
         ['config.add', ['forums_display_followers_users', 1]],
         ['config.add', ['forums_display_followers_avatars', 1]],
      ];
   }
}