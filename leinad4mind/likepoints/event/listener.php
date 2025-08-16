<?php

/**
 *
 * LikePoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2022 Leinad4Mind All rights reserved
 * @license Proprietary
 *
 */

namespace leinad4mind\likepoints\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\language\language;
use phpbb\log\log;
use phpbb\user;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
   protected $bbpoints_table;
   protected $bblikes_table;
   protected $bbpoints_helper;
   protected $bbpoints_config;
   protected $db;
   protected $request;
   protected $template;
   /** @var language */
   protected $language;
   protected $log;
   /** @var user */
   protected $user;

   public function __construct(\phpbb\request\request $request, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, language $language, log $log, user $user)
   {
      $this->db = $db;
      $this->log = $log;
      $this->request = $request;
      $this->template = $template;
      $this->language = $language;
      $this->user = $user;
      $this->language->add_lang('common', 'leinad4mind/likepoints');
      //$this->user->add_lang_ext('leinad4mind/likepoints', 'common');
   }

   public static function getSubscribedEvents(): array
   {
      return array(
         'core.submit_likedd_end' => 'award_points',
         'core.submit_likedd_start' => 'check_points',
         'core.posting_modify_template_vars' => 'display_editor_contributors',
         'core.posting_modify_submit_post_after' => 'update_contributors',
         'core.viewtopic_modify_post_row'         => 'display_viewtopic_contributors',
      );
   }

   /**
    * Fired before post render
    *
    * @param \phpbb\event\data $event The event object
    */
   public function check_points($event): void
   {
      global $phpbb_container;
      $this->bbpoints_table = $phpbb_container->getParameter('sitesplat.bbpoints.table');
      $current_user_id = $event['user_id'];
      $amount = $this->get_amount($event['post_id']);
      $user_points = $this->get_user_points($current_user_id);

      if ($event['l'] && $user_points < $amount && empty($event['error']) && !$event['like_id']) {
         $event['error'] = array_merge($event['error'], array(
            $this->language->lang_array('NOT_ENOUGH_BALANCE_LIKE'),
         ));
      }
   }

   /**
    * Fired before post render
    *
    * @param \phpbb\event\data $event The event object
    */
   public function display_viewtopic_contributors($event): void
   {
      $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . $event['row']['forum_id'];
      $this->db->sql_query($sql);
      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled');
      $event['post_row'] = array_merge($event['post_row'], array(
         'S_ENABLE_CONTRIBUTORS' => true,
      ));
      if (!$contributors_enabled) {
         return;
      }

      $contributors = $this->get_contributors($event['row']['post_id']);
      if (!count($contributors)) {
         $event['post_row'] = array_merge($event['post_row'], array(
            'S_ENABLE_CONTRIBUTORS' => false,
         ));
      }

      $contrs = '';
      foreach ($contributors as $u) {
         $user_id = (int) $u;
         $sql = 'SELECT username FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id . ' LIMIT 1';
         $this->db->sql_query($sql);
         $username = $this->db->sql_fetchfield('username');
         $contrs .= '<a href="' . append_sid('memberlist.php?mode=viewprofile&u=' . $user_id) . '">' . $username . '</a>, ';
      }

      $event['post_row'] = array_merge($event['post_row'], array(
         'CONTRIBUTOR_USERS' => rtrim($contrs, ', '),
      ));
   }

   /**
    * Fired on pressing the Like button.
    *
    * @param \phpbb\event\data $event The event object
    */
   public function award_points($event): void
   {
      global $phpbb_container, $config;
      $extension_manager = $phpbb_container->get('ext.manager');
      if (
         !$extension_manager->is_enabled('sitesplat/bbpoints')
         || !$extension_manager->is_enabled('sitesplat/likedd')
      ) {
         return;
      }
      $this->bbpoints_config = json_decode($config['bbpoints_settings'], true);
      $this->bbpoints_helper = $phpbb_container->get('sitesplat.bbpoints.helper');
      $this->bbpoints_table = $phpbb_container->getParameter('sitesplat.bbpoints.table');
      $this->bblikes_table = $phpbb_container->getParameter('sitesplat.likedd.tables.likes');

      $current_user_id = $event['user_id'];
      $liked_post_id = $this->request->variable('l', 0);
      //$unliked_post_id = $this->request->variable('d', 0);
      $unliked_post_id = 0;
      $post_id = $liked_post_id;
      if ($post_id === 0) {
         $post_id = $unliked_post_id;
      }
      $user_id = $this->get_author($post_id);
      $amount = $this->get_amount($post_id);
      $user_points = $this->get_user_points($current_user_id);
      $topic_id = $this->get_topic_id($post_id);
      $is_unlike = ($this->is_unlike($post_id, $current_user_id));
      if ($is_unlike) {
         $unliked_post_id = $liked_post_id;
         $liked_post_id = 0;
      }
      $contributors = $this->get_contributors($post_id);
      if (in_array($current_user_id, $contributors)) {
         // User who got contributors cannot add or subtract points by liking or unliking.
         return;
      }

      if ($unliked_post_id > 0) {
         if (count($contributors) > 0) {
            $contributor_amount = floor($amount / (count($contributors) + 1));
            if ($amount % $contributor_amount !== 0) {
               $amount = $contributor_amount + ($amount % $contributor_amount);
            } else {
               $amount = $contributor_amount;
            }
            // transfer for each additional user
            foreach ($contributors as $contributor_user_id) {
               $reason = $this->language->lang_array('REASON_UNLIKE_CONTRIBUTOR', [$contributor_amount, $user_id]);
               $this->unlike((int) $current_user_id, (int) $contributor_user_id, $topic_id, $unliked_post_id, $contributor_amount, $reason);
            }
         }
         $reason = $this->language->lang_array('REASON_UNLIKE', [$amount, $current_user_id]);
         $this->unlike($current_user_id, $user_id, $topic_id, $unliked_post_id, $amount, $reason);
         return;
      }

      if ($liked_post_id > 0 && $user_points <= $amount) {
         $message = $this->language->lang_array('LOG_TRANSFER_POINTS_NOT_ENOUGH', [
            $amount, $user_id
         ]);
         // Current user does not have enough points for transfer. Skip.
         $this->log->add('user', $current_user_id, $this->user->ip, $message, time(), [
            'reportee_id' => $current_user_id,
         ]);

         return;
      }
      if (count($contributors) > 0) {
         $contributor_amount = floor($amount / (count($contributors) + 1));
         if ($contributor_amount != 0 && $amount % $contributor_amount !== 0) {
            $amount = $contributor_amount + ($amount % $contributor_amount);
         } else {
            $amount = $contributor_amount;
         }
         // transfer for each additional user
         foreach ($contributors as $contributor_user_id) {
            $reason = $this->language->lang_array('REASON_LIKE_CONTRIBUTOR', [$contributor_amount, $current_user_id]);
            $this->transfer_points($current_user_id, $contributor_user_id, $topic_id, $post_id, $contributor_amount, $reason);
         }
      }

      $reason = $this->language->lang_array('REASON_LIKE', [$amount, $current_user_id]);

      // transfer for the post author
      $this->transfer_points($current_user_id, $user_id, $topic_id, $post_id, $amount, $reason);
   }

   protected function get_user_points($user_id): int
   {
      // Get the current user's points, calculated only from public posts
      $sql = 'SELECT user_id, SUM(points) as total FROM (
      SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 AND poster_id = ' . $user_id . ' GROUP BY poster_id
      UNION ALL
      SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' WHERE topic_poster = ' . $user_id . ' GROUP BY topic_poster
      UNION ALL
      SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE to_id = ' . $user_id . ' GROUP BY to_id
      UNION ALL
      SELECT from_id AS user_id, SUM(- bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $user_id . ' GROUP BY from_id
            ) t1 GROUP BY user_id';
      $this->db->sql_query($sql);
      $user_points  = $this->db->sql_fetchfield('total');
      return (int) $user_points;
   }

   protected function transfer_points(int $from_id, int $to_id, int $topic_id, int $post_id, int $points = 0, string $reason = ''): void
   {
      if (empty($from_id) || empty($to_id) || empty($points)) {
         return;
      }
      if ($from_id === $to_id) {
         return;
      }
      $sql_ary = [
         'from_id' => (int) $from_id,
         'to_id' => (int) $to_id,
         'topic_id' => (int) $topic_id,
         'post_id' => (int) $post_id,
         'bbpoints' => (int) $points,
         'reason' => '[LikePoints] ' . $reason,
         'timestamp' => time(),
      ];
      $sql = 'INSERT INTO ' . $this->bbpoints_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
      $this->db->sql_query($sql);
      $message = $reason;
      if (empty($message)) {
         $message = $this->language->lang_array('LOG_TRANSFER_POINTS', [
            $points,
            $to_id,
         ]);
      }
      $this->log->add('user', $from_id, $this->user->ip, $message, time(), [
         'reportee_id' => $from_id,
      ]);
   }

   protected function unlike(int $from_id, int $to_id, int $topic_id, int $post_id, int $points = 0, string $reason = '')
   {
      if (empty($from_id) || empty($to_id) || empty($points)) {
         return;
      }
      $sql = 'SELECT bbpoints FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $from_id . ' AND to_id = ' . $to_id . ' AND topic_id = ' . $topic_id . ' LIMIT 1';
      $this->db->sql_query($sql);
      $likepoints = (int) $this->db->sql_fetchfield('bbpoints');
      if ($likepoints === $points) {
         // We can undo the operation instead of transferring the points back and forth.
         $sql = 'DELETE FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $from_id . ' AND to_id = ' . $to_id . ' AND topic_id = ' . $topic_id . ' AND bbpoints = ' . $points . ' LIMIT 1';
         $this->db->sql_query($sql);
         $message = $this->language->lang_array('LOG_LIKE_TRANSFER_ABORTED', [
            $points, $to_id, $from_id
         ]);
         $this->log->add('user', $from_id, $this->user->ip, $message, time(), [
            'reportee_id' => $from_id,
         ]);
         return;
      } else {
         $reason = $this->language->lang_array('REASON_UNLIKE', [$points, $from_id]);
         $this->transfer_points($to_id, $from_id, $topic_id, $post_id, $points, $reason);
         return;
      }
   }

   protected function get_author(int $post_id): int
   {
      if (!$post_id) {
         return 0;
      }
      $sql = 'SELECT poster_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
      $this->db->sql_query($sql);
      return (int) $this->db->sql_fetchfield('poster_id');
   }

   protected function get_amount(int $post_id): int
   {
      global $phpbb_container;
      if (!$post_id) {
         return 0;
      }
      $sql = 'SELECT per_likes_enabled, contributors_enabled, per_likes_amount FROM ' . FORUMS_TABLE . ' INNER JOIN ' . POSTS_TABLE . ' ON ' . POSTS_TABLE . '.forum_id = ' . FORUMS_TABLE . '.forum_id WHERE ' . POSTS_TABLE . '.post_id = ' . $post_id . ' LIMIT 1';
      $this->db->sql_query($sql);
      $row = $this->db->sql_fetchrow();
      $enabled = (int) $row['per_likes_enabled'];
      if ($enabled === 0) {
         return 0;
      }
      $retval = (int) $row['per_likes_amount'];
      if ($retval === 0) {
         $admin_manager = $phpbb_container->get('leinad4mind.likepoints.admin_listener');
         $retval = $admin_manager->get_default_likepoint_amount();
      }
      return $retval;
   }

   public function update_contributors($event)
   {
      $post_id = (int) $event['post_id'];
      if (!$post_id) {
         return;
      }
      if ($this->request->variable('preview', '') === 'Preview') {
         // this is only a preview
         return;
      }
      $contributors = $this->request->variable('contributors', '');
      $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = (
         SELECT forum_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ')';
      $this->db->sql_query($sql);
      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled');
      if (!$contributors_enabled) {
         return;
      }
      if (empty($contributors)) {
         $sql = 'UPDATE ' . POSTS_TABLE . ' SET contributors = \'\' WHERE post_id = ' . $post_id;
         $this->db->sql_query($sql);
         return;
      }
      $usernames = explode(',', $contributors);
      $usernames = array_unique(array_map('trim', $usernames));
      $value = [];
      foreach ($usernames as $username) {
         if ($username === $event['post_author_name']) {
            continue;
         }
         $sql = 'SELECT user_id FROM ' . USERS_TABLE . ' WHERE username_clean = \'' . $this->db->sql_escape(strtolower($username)) . '\' LIMIT 1';
         $this->db->sql_query($sql);
         $user_id = (int) $this->db->sql_fetchfield('user_id');
         if ($user_id > 0) {
            $value[] = $user_id;
         }
      }
      $contributors = implode(',', $value);
      if (!empty($contributors)) {
         $sql = 'UPDATE ' . POSTS_TABLE . ' SET contributors = \'' . $contributors . '\' WHERE post_id = ' . $post_id;
         $this->db->sql_query($sql);
      }
   }

   protected function get_contributors($post_id)
   {
      $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' INNER JOIN ' . POSTS_TABLE . ' ON ' . POSTS_TABLE . '.forum_id = ' . FORUMS_TABLE . '.forum_id WHERE ' . POSTS_TABLE . '.post_id = ' . $post_id . ' LIMIT 1';
      $this->db->sql_query($sql);
      $row = $this->db->sql_fetchrow();
      $enabled = isset($row['contributors_enabled']) ? $row['contributors_enabled'] : false;
      if (!$enabled) {
         return [];
      }

      $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
      $this->db->sql_query($sql);
      $contributors = $this->db->sql_fetchfield('contributors');
      if ($contributors === '') {
         return [];
      }
      $contributors = explode(',', $contributors);
      return $contributors;
   }

   // List the contributors for the editor screen
   public function display_editor_contributors($event)
   {
      if ($this->request->variable('contributors', '') !== '') {
         $this->template->assign_vars(array(
            'CONTRIBUTOR' => $this->request->variable('contributors', ''),
         ));
         return;
      }
      $post_id = (int) $event['post_id'];

      $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = (
         SELECT forum_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ')';
      $this->db->sql_query($sql);
      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled');
      $this->template->assign_vars(array(
         'S_ENABLE_CONTRIBUTORS' => $contributors_enabled ? true : false,
      ));

      if (!$contributors_enabled) {
         return;
      }

      $contributors = $this->get_contributors($post_id);
      $a = [];
      foreach ($contributors as $u) {
         $user_id = (int) $u;
         $sql = 'SELECT username FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id . ' LIMIT 1';
         $this->db->sql_query($sql);
         $username = $this->db->sql_fetchfield('username');
         $a[] = $username;
      }
      $this->template->assign_vars(array(
         'CONTRIBUTOR' => implode(', ', $a)
      ));
   }

   public function get_topic_id($post_id)
   {
      $sql = 'SELECT topic_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
      $this->db->sql_query($sql);
      return (int) $this->db->sql_fetchfield('topic_id');
   }

   public function is_unlike($post_id, $user_id)
   {
      $sql = 'SELECT COUNT(*) AS count FROM ' . $this->bblikes_table . ' WHERE post_id = ' . $post_id . ' AND user_id = ' . $user_id;
      $this->db->sql_query($sql);
      $count = (int) $this->db->sql_fetchfield('count');
      // As we're running this on 'core.submit_likedd_end' event, the existence of a like
      // means it was a new like and non-existence means the like was removed.
      return ($count === 0);
   }
}
