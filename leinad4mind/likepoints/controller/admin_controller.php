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

class admin_controller
{
  protected $config;
  protected $request;
  protected $db;

  public function __construct(
    \phpbb\config\config $config,
    \phpbb\request\request $request,
    \phpbb\db\driver\driver_interface $db,
    \phpbb\controller\helper $helper,
    \phpbb\log\log $log,
    \phpbb\user $user,
    $likes_table,
    $bbpoints_table,
    $config_table
  ) {
    $this->config = $config;
    $this->request = $request;
    $this->db = $db;
    $this->likes_table = $likes_table;
    $this->bbpoints_table = $bbpoints_table;
    $this->config_table = $config_table;
    $this->helper   = $helper;
    $this->log = $log;
    $this->user = $user;
  }

  function get_max_post_id()
  {
    $sql = 'SELECT MIN(p.post_id) AS min_post_id, MAX(p.post_id) AS max_post_id, COUNT(p.post_id) AS total FROM ' . POSTS_TABLE .
      ' p LEFT JOIN ' . $this->likes_table . ' l ON (l.post_id = p.post_id AND l.ld = 0) WHERE l.post_id IS NOT NULL';
    $result = $this->db->sql_query($sql);
    $row = $this->db->sql_fetchrow($result);
    $this->min_post_id = (int) $row['min_post_id'];
    $this->max_post_id = (int) $row['max_post_id'];
    $this->total_post_ids = (int) $row['total'];
    $this->db->sql_freeresult($result);
  }

  public function get_default_likepoint_amount()
  {
    $sql = "SELECT config_value FROM $this->config_table WHERE config_name = 'bbpoints_settings' LIMIT 1";
    $result = $this->db->sql_query($sql);
    $config = $this->db->sql_fetchfield('config_value', $result);
    $this->db->sql_freeresult($result);
    $config = json_decode($config, true);
    return (int) ($config['per_likes'] ?? 10);
  }

  public function sync_like_points()
  {
    $sql = 'SELECT forum_id, per_likes_amount FROM ' . FORUMS_TABLE . ' WHERE per_likes_enabled = 1 AND forum_type = 1';
    $result = $this->db->sql_query($sql);
    $forum_ary = array();
    $default_points = $this->get_default_likepoint_amount();
    while ($row = $this->db->sql_fetchrow($result)) {
      $forum_ary[$row['forum_id']] = array(
        'per_likes_amount'  => ($row['per_likes_amount']) ? $row['per_likes_amount'] : $default_points
      );
    }

    $this->get_max_post_id();
    $this->batch_size = 50;

    $starttime = explode(' ', microtime());
    $starttime = $starttime[1] + $starttime[0];
    $post_counter = $this->request->variable('skiprows', 0);

    // delete all existing points for the posts
    $del = 'DELETE FROM ' . $this->bbpoints_table . " WHERE reason like '[LikePoints] %'";
    $this->db->sql_query($del);

    while (still_on_time(20) && $post_counter <= $this->total_post_ids) {
      $sql = 'SELECT l.post_id, l.user_id, f.forum_id, p.poster_id, p.topic_id, f.contributors_enabled FROM ' . POSTS_TABLE .
        ' p LEFT JOIN ' . $this->likes_table . ' l ON (l.post_id = p.post_id AND l.ld = 0)' .
        ' LEFT JOIN ' . FORUMS_TABLE . ' f ON (f.forum_id = p.forum_id)' .
        ' WHERE l.post_id IS NOT NULL' .
        ' ORDER BY l.post_id ASC';
      $result = $this->db->sql_query_limit($sql, $this->batch_size, $post_counter);

      $this->db->sql_transaction('begin');

      while ($row = $this->db->sql_fetchrow($result)) {
        if (isset($row['post_id']) && !empty($row['post_id']) && isset($forum_ary[$row['forum_id']])) {
          $bbpoints = $forum_ary[$row['forum_id']]['per_likes_amount'];
          $contributors = [];
          if (isset($row['contributors_enabled']) ? $row['contributors_enabled'] : false) {
            $contributors = $this->get_contributors($row['post_id']);
          }
          if (in_array($row['user_id'], $contributors)) {
            // User who got contributors cannot add or subtract points by liking or unliking.
            $post_counter++;
            continue;
          }

          if (count($contributors) > 0) {
            $contributor_amount = floor($bbpoints / (count($contributors) + 1));
            if ($contributor_amount != 0 && $bbpoints % $contributor_amount !== 0) {
              $bbpoints = $contributor_amount + ($bbpoints % $contributor_amount);
            } else {
              $bbpoints = $contributor_amount;
            }
            // transfer for each additional user
            foreach ($contributors as $contributor_user_id) {
              $sql_ary = [
                'from_id' => (int) $row['user_id'],
                'to_id' => (int) $contributor_user_id,
                'bbpoints' => (int) $contributor_amount,
                'reason' => '[LikePoints] [Contributor] ' . 'Sync Like Points for Post ' . $row['post_id'],
                'timestamp' => time(),
                'topic_id' => (int) $row['topic_id'],
                'post_id' => (int) $row['post_id'],
              ];
              $sql = 'INSERT INTO ' . $this->bbpoints_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
              $this->db->sql_query($sql);
              $meta = [
                'reportee_id' => $sql_ary['from_id'],
                'post_id' => $sql_ary['post_id'],
                'to_id' => $sql_ary['to_id'],
                'bbpoints' => $contributor_amount,
              ];
              $this->log->add('user', $sql_ary['from_id'], $this->user->ip, $sql_ary['reason'] . ': ' . json_encode($meta), time(), [
                'reportee_id' => $meta['reportee_id'],
              ]);
            }
          }

          $sql_ary = [
            'from_id' => (int) $row['user_id'],
            'to_id' => (int) $row['poster_id'],
            'bbpoints' => (int) $bbpoints,
            'reason' => '[LikePoints] ' . 'Sync Like Points for Post ' . $row['post_id'],
            'timestamp' => time(),
            'topic_id' => (int) $row['topic_id'],
            'post_id' => (int) $row['post_id'],
          ];
          $sql = 'INSERT INTO ' . $this->bbpoints_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
          $this->db->sql_query($sql);
          $meta = [
            'reportee_id' => $sql_ary['from_id'],
            'post_id' => $sql_ary['post_id'],
            'to_id' => $sql_ary['to_id'],
            'bbpoints' => $bbpoints,
          ];
          $this->log->add('user', $sql_ary['from_id'], $this->user->ip, $sql_ary['reason'] . ': ' . json_encode($meta), time(), [
            'reportee_id' => $meta['reportee_id'],
          ]);
        }

        $post_counter++;
      }
      $this->db->sql_transaction('commit');
    }

    if ($this->total_post_ids > 0 && $post_counter <= $this->total_post_ids) {
      $return = array(
        'total_posts' => $this->total_post_ids,
        'postcounter'  => $post_counter,
        'total_post_ids' => $this->total_post_ids,
        'url'      => ($post_counter < $this->total_post_ids) ?
          html_entity_decode($this->helper->route('leinad4mind_likepoints_admin_controller', ['action' => 'progressbar', 'skiprows' => $post_counter, 'time' => time()])) : 0,
        'percent'    => round((($post_counter > $this->total_post_ids) ? $this->total_post_ids : $post_counter) / $this->total_post_ids, 3) * 100
      );
    } else {
      $return = array(
        'url'    => 0,
        'percent'  => 100
      );
    }
    echo json_encode($return);
    exit();
  }

  protected function get_contributors($post_id)
  {
    $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . (int) $post_id . ' LIMIT 1';
    $this->db->sql_query($sql);
    $contributors = $this->db->sql_fetchfield('contributors');
    if ($contributors === '') {
      return [];
    }
    $contributors = explode(',', $contributors);
    return $contributors;
  }

  public function execute()
  {
    if ($this->request->is_set_post('sync_points') || $this->request->variable('action', '') == 'progressbar') {
      if ($this->request->variable('skiprows', 0) == 0) {
        $this->config->set('leinad4mind_likepoints_search_indexing_state', 0, true);
        return $this->sync_like_points();
      }

      return $this->sync_like_points();
    }
  }
}
