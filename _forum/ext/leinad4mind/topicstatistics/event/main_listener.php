<?php

/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\topicstatistics\event;

use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
   /** @var user */
   protected $user;

   /** @var auth */
   protected $auth;

   /** @var language */
   protected $language;

   /** @var driver_interface */
   protected $db;

   /** @var template */
   protected $template;

   /** @var config */
   protected $config;

   /** @var request_interface */
   protected $request;

   /**
    * @param user				$user
    * @param auth				$auth
    * @param language			$language
    * @param driver_interface	$db
    * @param template			$template
    * @param config			$config
    * @param request_interface	$request
    */
   public function __construct(
      user $user,
      auth $auth,
      language $language,
      driver_interface $db,
      template $template,
      config $config,
      request_interface $request
   ) {
      $this->user      = $user;
      $this->auth      = $auth;
      $this->language   = $language;
      $this->db      = $db;
      $this->template   = $template;
      $this->config   = $config;
      $this->request   = $request;
   }

   /**
    * @return array
    */
   public static function getSubscribedEvents()
   {
      return [
         'core.viewforum_generate_page_after'   => 'viewforum_generate_page_after',
         'core.viewtopic_modify_page_title'      => 'viewtopic_modify_page_title',
         'core.acp_board_config_edit_add'      => 'acp_board_config_edit_add',
      ];
   }

   /**
    * @param data $event
    */
   public function viewforum_generate_page_after($event)
   {
      // get basic settings
      $config_statistics = $this->statistics_config();

      $forum_id = $event['forum_data']['forum_id'];

      // Do not continue if this option is disabled or we have no forum ID
      if (!$this->config['forums_display_statistics']) {
         return;
      }

      // Users who have visited the theme - Start
      if ($this->config['forums_display_visit']) {
         // Number of users who have visited the current topic
         $sql_visit = 'SELECT topic_views
				FROM ' . TOPICS_TABLE . '
				WHERE forum_id = ' . (int) $forum_id;
         $result_visit = $this->db->sql_query($sql_visit);
         while ($row_followers = $this->db->sql_fetchrow($result_visit)) {
            $config_statistics['forums_num_visit'] += (int) $row_followers['topic_views'];
         }
         $this->db->sql_freeresult($result_visit);
      }
      // Users who have visited the theme - End

      // Subscriptions for the current topic - Start
      if ($this->config['forums_display_followers']) {
         // Get users and the number of subscriptions for the current topic
         if ($this->config['forums_display_followers_users']) {
            $sql_followers_count = 'SELECT COUNT(u.user_id) AS num_topics
					FROM ' . FORUMS_WATCH_TABLE . ' w, ' . USERS_TABLE . ' u 
					WHERE w.forum_id = ' . (int) $forum_id . '
						AND w.user_id = u.user_id';
            $result_followers_count = $this->db->sql_query($sql_followers_count);
            $row_followers_count = $this->db->sql_fetchfield('num_topics', false, $result_followers_count);

            $sql_followers = 'SELECT w.user_id, u.username, u.user_id, u.user_type, u.user_colour, u.user_posts, u.user_avatar, u.user_avatar_type, u.user_avatar_width
					FROM ' . FORUMS_WATCH_TABLE . ' w, ' . USERS_TABLE . ' u 
					WHERE w.forum_id = ' . (int) $forum_id . '
						AND w.user_id = u.user_id';
            $result_followers = $this->db->sql_query_limit($sql_followers, $this->config['user_limit']);

            while ($row_followers = $this->db->sql_fetchrow($result_followers)) {
               $config_statistics['forums_num_followers']++;
               $avatar = '';

               if ($this->config['forums_display_followers_avatars']) {
                  $avatar = $this->get_avatar($row_followers);
               }

               $this->template->assign_block_vars('forum_followers', [
                  'USER' => $this->get_username_string($row_followers['user_colour'], $row_followers['user_id'], $row_followers['username'], $this->config['user_viewprofile']),
                  'AVATAR' => $avatar,
               ]);
            }
            $this->db->sql_freeresult($result_followers);
            $this->db->sql_freeresult($result_followers_count);
         }
         // Get the number of bookmarks for the current topic
         else {
            $sql_bookmark = 'SELECT COUNT(user_id) AS total_followers
					FROM ' . FORUMS_WATCH_TABLE . '
					WHERE forum_id = ' . (int) $forum_id;
            $result_bookmarks = $this->db->sql_query($sql_bookmark);
            $config_statistics['forums_num_followers'] = (int) $this->db->sql_fetchfield('total_followers');
            $this->db->sql_freeresult($result_bookmarks);
         }
      }
      // Subscriptions for the current topic - End

      // Send vars to template
      $this->template->assign_vars([
         'FORUM_STATISTICS'                   => $this->config['forums_display_statistics'],
         'FORUM_STATISTICS_VISITS'            => $this->config['forums_display_visit'],
         'FORUM_STATISTICS_VISITS_NUM'        => $config_statistics['forums_num_visit'],
         'FORUM_STATISTICS_FOLLOWERS'         => $this->config['forums_display_followers'],
         'FORUM_STATISTICS_FOLLOWERS_NUM'     => $config_statistics['forums_num_followers'],
         'FORUM_STATISTICS_FOLLOWERS_NUM_MAX' => (int) $this->config['user_limit'] < (int) $row_followers_count,
      ]);
   }

   /**
    * @param data $event
    */
   public function viewtopic_modify_page_title($event)
   {
      // Some basic settings
      $config_statistics = $this->statistics_config();

      $topic_id = $event['topic_data']['topic_id'];

      // Do not continue if this option is disabled or we have no topic ID
      if (!$this->config['topics_display_statistics']) {
         return;
      }

      // Users who have visited the theme - Start
      if ($this->config['topics_display_visit']) {
         // Number of users who have visited the current topic
         $sql_visit = 'SELECT topic_views AS topic_views 
				FROM ' . TOPICS_TABLE . '
				WHERE topic_id = ' . (int) $topic_id;
         $result_visit = $this->db->sql_query($sql_visit);
         $config_statistics['topics_num_visit'] = (int) $this->db->sql_fetchfield('topic_views');
         $this->db->sql_freeresult($result_visit);
      }
      // Users who have visited the theme - End

      // Favorites for the current topic - Start
      if ($this->config['topics_display_bookmarks']) {
         // Get users and the number of bookmarks for the current topic
         if ($this->config['topics_display_bookmarks_users']) {
            $sql_bookmarks_count = 'SELECT COUNT(u.user_id) AS num_topics
					FROM ' . BOOKMARKS_TABLE . ' b, ' . USERS_TABLE . ' u 
					WHERE b.topic_id = ' . (int) $topic_id . '
						AND b.user_id = u.user_id';
            $result_bookmarks_count = $this->db->sql_query($sql_bookmarks_count);
            $row_bookmarks_count = $this->db->sql_fetchfield('num_topics', false, $result_bookmarks_count);

            $sql_bookmarks = 'SELECT b.user_id, u.username, u.user_id, u.user_type, u.user_colour, u.user_posts, u.user_avatar, u.user_avatar_type, u.user_avatar_width
					FROM ' . BOOKMARKS_TABLE . ' b, ' . USERS_TABLE . ' u 
					WHERE b.topic_id = ' . (int) $topic_id . '
						AND b.user_id = u.user_id';
            $result_bookmarks = $this->db->sql_query_limit($sql_bookmarks, $this->config['user_limit']);

            while ($row_bookmarks = $this->db->sql_fetchrow($result_bookmarks)) {
               $config_statistics['topics_num_bookmarks']++;
               $avatar = '';

               if ($this->config['topics_display_bookmarks_avatars']) {
                  $avatar = $this->get_avatar($row_bookmarks);
               }

               $this->template->assign_block_vars('topic_bookmark', [
                  'USER' => $this->get_username_string($row_bookmarks['user_colour'], $row_bookmarks['user_id'], $row_bookmarks['username'], $this->config['user_viewprofile']),
                  'AVATAR' => $avatar,
               ]);
            }
            $this->db->sql_freeresult($result_bookmarks);
            $this->db->sql_freeresult($result_bookmarks_count);
         }
         // Get the number of bookmarks for the current topic
         else {
            $sql_bookmark = 'SELECT COUNT(user_id) AS total_bookmarks
					FROM ' . BOOKMARKS_TABLE . '
					WHERE topic_id = ' . (int) $topic_id;
            $result_bookmarks = $this->db->sql_query($sql_bookmark);
            $config_statistics['topics_num_bookmarks'] = (int) $this->db->sql_fetchfield('total_bookmarks');
            $this->db->sql_freeresult($result_bookmarks);
         }
      }
      // Favorites for the current topic - End

      // Subscriptions for the current topic - Start
      if ($this->config['topics_display_followers']) {
         // Get users and the number of subscriptions for the current topic
         if ($this->config['topics_display_followers_users']) {
            $sql_followers_count = 'SELECT COUNT(u.user_id) AS num_topics
					FROM ' . TOPICS_WATCH_TABLE . ' w, ' . USERS_TABLE . ' u 
					WHERE w.topic_id = ' . (int) $topic_id . '
						AND w.user_id = u.user_id';
            $result_followers_count = $this->db->sql_query($sql_followers_count);
            $row_followers_count = $this->db->sql_fetchfield('num_topics', false, $result_followers_count);

            $sql_followers = 'SELECT w.user_id, u.username, u.user_id, u.user_type, u.user_colour, u.user_posts, u.user_avatar, u.user_avatar_type, u.user_avatar_width
					FROM ' . TOPICS_WATCH_TABLE . ' w, ' . USERS_TABLE . ' u 
					WHERE w.topic_id = ' . (int) $topic_id . '
						AND w.user_id = u.user_id';
            $result_followers = $this->db->sql_query_limit($sql_followers, $this->config['user_limit']);

            while ($row_followers = $this->db->sql_fetchrow($result_followers)) {
               $config_statistics['topics_num_followers']++;
               $avatar = '';

               if ($this->config['topics_display_followers_avatars']) {
                  $avatar = $this->get_avatar($row_followers);
               }

               $this->template->assign_block_vars('topic_followers', [
                  'USER' => $this->get_username_string($row_followers['user_colour'], $row_followers['user_id'], $row_followers['username'], $this->config['user_viewprofile']),
                  'AVATAR' => $avatar,
               ]);
            }
            $this->db->sql_freeresult($result_followers);
            $this->db->sql_freeresult($result_followers_count);
         }
         // Get the number of bookmarks for the current topic
         else {
            $sql_bookmark = 'SELECT COUNT(user_id) AS total_followers
					FROM ' . TOPICS_WATCH_TABLE . '
					WHERE topic_id = ' . (int) $topic_id;
            $result_bookmarks = $this->db->sql_query($sql_bookmark);
            $config_statistics['topics_num_followers'] = (int) $this->db->sql_fetchfield('total_followers');
            $this->db->sql_freeresult($result_bookmarks);
         }
      }
      // Subscriptions for the current topic - End

      // Send vars to template
      $this->template->assign_vars([
         'TOPIC_STATISTICS'                  => $this->config['topics_display_statistics'],
         'TOPIC_STATISTICS_VISITS'           => $this->config['topics_display_visit'],
         'TOPIC_STATISTICS_VISITS_NUM'       => $config_statistics['topics_num_visit'],
         'TOPIC_STATISTICS_BOOKMARK'         => $this->config['topics_display_bookmarks'],
         'TOPIC_STATISTICS_BOOKMARK_NUM'     => $config_statistics['topics_num_bookmarks'],
         'TOPIC_STATISTICS_BOOKMARK_NUM_MAX' => (int) $this->config['user_limit'] < (int) $row_bookmarks_count,
         'TOPIC_STATISTICS_FOLLOWERS'        => $this->config['topics_display_followers'],
         'TOPIC_STATISTICS_FOLLOWERS_NUM'    => $config_statistics['topics_num_followers'],
         'TOPIC_STATISTICS_FOLLOWERS_NUM_MAX' => (int) $this->config['user_limit'] < (int) $row_followers_count,
      ]);
   }

   /**
    * @param string $colour
    * @param string $user_id
    * @param string $username
    * @param string $viewprofile
    * @return string
    */
   protected function get_username_string($colour, $user_id, $username, $viewprofile)
   {
      return get_username_string($viewprofile ? 'full' : 'no_profile', $user_id, $username, $colour);
   }

   /**
    * Return a user's avatar.
    * @param array $row
    * @param string $avatar_type
    * @param int $height
    * @param int $width
    * @return string
    **/
   protected function get_avatar($row)
   {
      $row['avatar'] = $row['user_avatar'] ?? '';
      $row['avatar_type'] = $row['user_avatar_type'] ?? '';
      $width = $row['user_avatar_width'] ?? 20;
      if ($width > 20) {
         $width = 20;
      }
      $row['avatar_width'] = $width;
      $row['avatar_height'] = '100%';

      $row = \phpbb\avatar\manager::clean_row($row);
      return phpbb_get_avatar($row, $row['username']);
   }

   /**
    * @return array
    */
   protected function statistics_config()
   {
      $this->language->add_lang('common', 'leinad4mind/topicstatistics');

      $config_statistics = [
         // Initial amount of users that have visited forums
         'forums_num_visit'               => 0,
         // Initial amount of users that are following forums
         'forums_num_followers'           => 0,
         // Initial amount of users that have visited topics
         'topics_num_visit'               => 0,
         // Initial amount of users that have bookmarked topics
         'topics_num_bookmarks'           => 0,
         // Initial amount of users that are following topics
         'topics_num_followers'           => 0,
      ];

      // Verify some permissions
      if (!empty($this->user->data['is_bot']) || !$this->auth->acl_get('u_viewprofile')) {
         $this->config['user_viewprofile'] = false;
      }

      return $config_statistics;
   }

   /**
    * @param data $event
    */
   public function acp_board_config_edit_add(data $event)
   {
      if ($event['mode'] == 'features') {
         $this->language->add_lang('acp', 'leinad4mind/topicstatistics');

         $config = [
            'user_limit'                       => ['lang' => 'TS_USER_LIMIT_MAX', 'validate' => 'int:0:9999', 'type' => 'number:0:9999', 'explain' => true],
            'user_viewprofile'                 => ['lang' => 'TS_USER_PROFILE_LINK', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
            'topics_display_statistics'        => ['lang' => 'TS_TOPICS_ENABLED', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
            'topics_display_visit'             => ['lang' => 'TS_TOPICS_VISIT', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
            'topics_display_bookmarks'         => ['lang' => 'TS_TOPICS_BOOKMARK', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
            'topics_display_bookmarks_users'   => ['lang' => 'TS_TOPICS_BOOKMARK_USERS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
            'topics_display_bookmarks_avatars' => ['lang' => 'TS_TOPICS_BOOKMARK_AVATARS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
            'topics_display_followers'         => ['lang' => 'TS_TOPICS_FOLLOWERS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
            'topics_display_followers_users'   => ['lang' => 'TS_TOPICS_FOLLOWERS_USERS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
            'topics_display_followers_avatars' => ['lang' => 'TS_TOPICS_FOLLOWERS_AVATARS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
            'forums_display_statistics'        => ['lang' => 'TS_FORUMS_ENABLED', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
            'forums_display_visit'             => ['lang' => 'TS_FORUMS_VISIT', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
            'forums_display_followers'         => ['lang' => 'TS_FORUMS_FOLLOWERS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
            'forums_display_followers_users'   => ['lang' => 'TS_FORUMS_FOLLOWERS_USERS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
            'forums_display_followers_avatars' => ['lang' => 'TS_FORUMS_FOLLOWERS_AVATARS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
         ];

         $display_vars = $event['display_vars'];
         $display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $config, ['after' => 'allow_birthdays']);
         $event['display_vars'] = $display_vars;
      }
   }
}
