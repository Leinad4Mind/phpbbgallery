<?php

/**
 *
 * LikePoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
 * @license Proprietary
 *
 */

namespace leinad4mind\likepoints\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\request\request;
use phpbb\db\driver\driver_interface;
use phpbb\template\template;
use phpbb\language\language;
use phpbb\log\log;
use phpbb\user;
use phpbb\controller\helper;
use phpbb\config\config;

class admin_listener implements EventSubscriberInterface
{
   protected $db;
   protected $request;
   protected $template;
   protected $language;
   protected $config_table;
   protected $log;
   protected $user;
   protected $config;

   /**
    * Constructor
    *
    * @access	public
    */
   public function __construct(
      request $request,
      driver_interface $db,
      template $template,
      language $language,
      log $log,
      user $user,
      helper $helper,
      config $config,
      $config_table
   ) {
      $this->db = $db;
      $this->request = $request;
      $this->template = $template;
      $this->language = $language;
      $this->log = $log;
      $this->user = $user;
      $this->helper   = $helper;
      $this->config = $config;
      $this->config_table = $config_table;
      $this->bbpoints_config = !empty($this->config['bbpoints_settings']) ? json_decode($this->config['bbpoints_settings'], true) : [];
   }

   /**
    * Assign functions defined in this class to event listeners in the core
    *
    * @return array
    * @static
    * @access public
    */
   static public function getSubscribedEvents()
   {
      return array(
         'core.acp_manage_forums_initialise_data'   => 'acp_manage_forums_initialise_data',
         'core.acp_manage_forums_display_form'      => 'acp_manage_forums_display_form',
         'core.acp_manage_forums_update_data_after'   => 'acp_manage_forums_update_data_after',
         'sitesplat.bbpoints.before_admin_controller_display' => 'acp_before_admin_controller_display',
         'sitesplat.bbpoints.after_admin_controller_submit_config' => 'acp_after_admin_controller_submit_config',
      );
   }

   public function acp_before_admin_controller_display($event)
   {
      if (!isset($event['bbpoints_config']['per_likes'])) {
         $this->template->assign_vars(array(
            'PER_LIKES'   => 10,
         ));
      }

      $this->template->assign_vars(array(
         'SYNC_POINTS_URL'   => html_entity_decode($this->helper->route('leinad4mind_likepoints_admin_controller')),
      ));
   }

   public function acp_after_admin_controller_submit_config($event)
   {
      $merged = $this->bbpoints_config;
      $merged['per_likes'] = $this->request->variable('per_likes', 10);
      $this->config->set('bbpoints_settings', json_encode($merged));
   }

   /**
    * Initialize forum options.
    *
    * @param object $event The event object
    * @return null
    * @access public
    */
   public function acp_manage_forums_initialise_data($event)
   {
      if ($event['action'] === 'add') {
         $event['forum_data']['per_likes_enabled'] = true;
         $event['forum_data']['contributors_enabled'] = true;
         $event['forum_data']['per_likes_amount'] = 0;
      }
   }

   /**
    * Add template data before form display
    *
    * @param object $event The event object
    * @return null
    * @access public
    */
   public function acp_manage_forums_display_form($event)
   {
      $this->language->add_lang('info_acp_likepoints', 'leinad4mind/likepoints');
      $row = null;
      if ($event['action'] !== 'add') {
         $sql = 'SELECT per_likes_amount FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . (int) $event['forum_data']['forum_id'] . ' and per_likes_enabled = 1';
         $result = $this->db->sql_query($sql);
         $row = $this->db->sql_fetchrow($result);
         $this->db->sql_freeresult($result);
      }

      $this->template->assign_vars(array(
         'S_ENABLE_LIKES'   => $this->request->variable('per_likes_enabled', (isset($event['forum_data']['per_likes_enabled']) && $event['forum_data']['per_likes_enabled']) ? true : false),
         'S_ENABLE_CONTRIBUTORS' => $this->request->variable('contributors_enabled', (isset($event['forum_data']['contributors_enabled']) && $event['forum_data']['contributors_enabled']) ? true : false),
         'PERLIKES_AMOUNT'  => $this->request->variable('per_likes_amount', isset($row) && is_array($row) ? $row['per_likes_amount'] : 0),
      ));
   }

   /**
    * Update additional fields after forum add/edit
    *
    * @param object $event The event object
    * @return null
    * @access public
    */
   public function acp_manage_forums_update_data_after($event)
   {
      $per_likes_enabled = $this->request->variable('per_likes_enabled', 1);
      $contributors_enabled = $this->request->variable('contributors_enabled', 0);
      $amount = $this->request->variable('per_likes_amount', $this->get_default_likepoint_amount());
      $sql = 'UPDATE ' . FORUMS_TABLE . '
            SET per_likes_enabled = ' . (int) $per_likes_enabled . ',
                contributors_enabled = ' . (int) $contributors_enabled . ',
                per_likes_amount = ' . (int) $amount . '
            WHERE forum_id = ' . (int) $event['forum_data']['forum_id'];
      $this->db->sql_query($sql);
   }

   public function get_default_likepoint_amount()
   {
      $sql = "SELECT config_value FROM $this->config_table WHERE config_name = 'bbpoints_settings' LIMIT 1";
      $result = $this->db->sql_query($sql);
      $config = $this->db->sql_fetchfield('config_value', false, $result);
      $this->db->sql_freeresult($result);
      $config = json_decode($config, true);
      return isset($config['per_likes']) ? (int) $config['per_likes'] : 10;
   }
}
