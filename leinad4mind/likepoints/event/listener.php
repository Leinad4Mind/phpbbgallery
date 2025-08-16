<?php
namespace oreolek\likepoints\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\language\language;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
  protected $bbpoints_table;
  protected $bbpoints_helper;
  protected $bbpoints_config;
	protected $db;
	protected $request;
	protected $template;
	/** @var language */
	protected $language;

	public function __construct(\phpbb\request\request $request, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, language $language)
  {
		$this->db = $db;
		$this->request = $request;
    $this->template = $template;
    $this->language = $language;
		$this->language->add_lang('common', 'oreolek/likepoints');
	}

  public static function getSubscribedEvents(): array
  {
    return array(
      'core.submit_likedd_end' => 'award_points',
      'core.posting_modify_template_vars' => 'display_editor_kudos',
      'core.posting_modify_submit_post_after' => 'update_kudos'
    );
  }

  /**
   * Fired on pressing the Like button.
   *
   * @param \phpbb\event\data $event The event object
   */
  public function award_points($event): void {
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

    $current_user_id = $event['user_id'];
    $liked_post_id = $this->request->variable('l', 0);
    $disliked_post_id = $this->request->variable('d', 0);
    if ($disliked_post_id > 0) {
      // We don't transfer points for dislikes.
      return;
    }
    $user_id = $this->get_author($liked_post_id);
    $amount = $this->get_amount($liked_post_id);
    $user_points = $this->get_user_points($current_user_id);

    if ($user_points <= $amount) {
      // Current user does not have enough points for transfer. Skip.
      return;
    }
    $kudos = $this->get_kudos($liked_post_id);
    $kudo_amount = floor($amount / count($kudos));
    if ($amount % $kudo_amount !== 0) {
      $amount = $kudo_amount + ($amount % $kudo_amount);
    }

    if (!empty($kudos)) {
      foreach($kudos as $kudo_user_id) {
        $this->transfer_points($current_user_id, $kudo_user_id, $kudo_amount, 'Awarded for getting a like from '.$current_user_id.' as kudos from the poster.');
      }
    }

    $this->transfer_points($current_user_id, $user_id, $amount, 'Awarded for getting a like from '.$current_user_id.'.');
  }

  protected function get_user_points($user_id): int {
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

  protected function transfer_points($from_id, $to_id, $points = 0, $reason = ''): void {
    if (empty($from_id) || empty($to_id)) {
      return;
    }
    $sql = 'INSERT INTO ' . $this->bbpoints_table . ' (from_id, to_id, bbpoints, reason, timestamp) 
      VALUES(' . $from_id . ', ' . $to_id . ', ' . $points . ', \'' . $reason . '\', ' . time() . ')';
    $this->db->sql_query($sql);
  }

  protected function get_author(int $post_id): int {
    if (!$post_id) {
      return 0;
    }
    $sql = 'SELECT poster_id FROM ' . POSTS_TABLE . ' WHERE post_id = '.$post_id.' LIMIT 1';
    $this->db->sql_query($sql);
    return (int) $this->db->sql_fetchfield('poster_id');
  }

  protected function get_amount(int $post_id): int {
    if (!$post_id) {
      return 0;
    }
    $sql = 'SELECT likepoints_enabled, likepoints_amount FROM ' . FORUMS_TABLE.' INNER JOIN '. POSTS_TABLE . ' ON '.POSTS_TABLE.'.forum_id = '.FORUMS_TABLE.'.forum_id WHERE '.POSTS_TABLE.'.post_id = '.$post_id.' LIMIT 1';
    $this->db->sql_query($sql);
    $row = $this->db->sql_fetchrow();
    $enabled = (int) $row['likepoints_enabled'];
    if ($enabled === 0) {
      return 0;
    }
    return (int) $row['likepoints_amount'];
  }

  public function update_kudos($event) {
    $post_id = (int) $event['post_id'];
    if (!$post_id) {
      return;
    }
    if ($this->request->variable('preview', '') === 'Preview') {
      // this is only a preview
      return;
    }
    $kudos = $this->request->variable('kudos', '');
    if (empty($kudos)) {
      return;
    }
    $usernames = explode(',', $kudos);
    $value = [];
    foreach($usernames as $username) {
      $username = trim($username);
      if ($username === $event['post_author_name']) {
        continue;
      }
      $sql = 'SELECT user_id FROM ' . USERS_TABLE . ' WHERE username = \''.$this->db->sql_escape($username).'\' LIMIT 1';
      $this->db->sql_query($sql);
      $user_id = (int) $this->db->sql_fetchfield('user_id');
      if ($user_id > 0) {
        $value[] = $user_id;
      }
    }
    $kudos = implode(',', $value);
    if (!empty($kudos)) {
      $sql = 'UPDATE ' . POSTS_TABLE . ' SET kudos = \'' . $kudos .'\' WHERE post_id = '.$post_id;
      $this->db->sql_query($sql);
    }
  }

  protected function get_kudos($post_id) {
    $sql = 'SELECT kudos FROM ' . POSTS_TABLE . ' WHERE post_id = '.$post_id.' LIMIT 1';
    $this->db->sql_query($sql);
    $kudos = $this->db->sql_fetchfield('kudos');
    if ($kudos === '') {
      return [];
    }
    $kudos = explode(',', $kudos);
    return $kudos;
  }

  // List the kudos for the editor screen
  public function display_editor_kudos($event) {
    if ($this->request->variable('kudos', '') !== '') {
      return $this->request->variable('kudos', '');
    }
    $post_id = (int) $event['post_id'];
    $kudos = $this->get_kudos($post_id);
    $a = [];
    foreach($kudos as $u) {
      $user_id = (int) $u;
      $sql = 'SELECT username FROM ' . USERS_TABLE . ' WHERE user_id = '.$user_id.' LIMIT 1';
      $this->db->sql_query($sql);
      $username = $this->db->sql_fetchfield('username');
      $a[] = $username;
    }
    $this->template->assign_vars(array(
      'KUDOS' => implode(', ', $a)
		));
  }
}
