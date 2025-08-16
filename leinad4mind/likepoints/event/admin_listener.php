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
use phpbb\request\request;
use phpbb\db\driver\driver_interface;
use phpbb\template\template;
use phpbb\language\language;

class admin_listener implements EventSubscriberInterface
{
   protected $db;
   protected $request;
   protected $template;
   protected $language;
   protected $config_table;

   /**
    * Constructor
    *
    * @access	public
    */
   public function __construct(request $request, driver_interface $db, template $template, language $language, $config_table)
   {
      $this->db = $db;
      $this->request = $request;
      $this->template = $template;
      $this->language = $language;
      $this->config_table = $config_table;
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
      );
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
         $event['forum_data'] = array_merge($event['forum_data'], array(
            'per_likes_enabled' => true,
            'per_likes_amount' => $this->get_default_likepoint_amount(),
         ));
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
      //$this->user->add_lang_ext('leinad4mind/likepoints', 'info_acp_likepoints');
      $this->language->add_lang('info_acp_likepoints', 'leinad4mind/likepoints');

      $this->template->assign_vars(array(
         'S_ENABLE_LIKES'   => ($event['forum_data']['per_likes_enabled']) ? true : false,
         'PERLIKES_AMOUNT'  => $event['forum_data']['per_likes_amount'],
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
      $amount = $this->request->variable('per_likes_amount', $this->get_default_likepoint_amount());
      $sql = 'UPDATE ' . FORUMS_TABLE . '
				SET per_likes_enabled = ' . $per_likes_enabled . ',
					per_likes_amount = ' . $amount . '
				WHERE forum_id = ' . $event['forum_data']['forum_id'];
      $this->db->sql_query($sql);
   }

   public function get_default_likepoint_amount()
   {
      $sql = "SELECT config_value FROM $this->config_table WHERE config_name = 'bbpoints_settings' LIMIT 1";
      $this->db->sql_query($sql);
      $config  = $this->db->sql_fetchfield('config_value');
      $config = json_decode($config, true);
      return (int) ($config['per_likes'] ?? 10);
   }
}