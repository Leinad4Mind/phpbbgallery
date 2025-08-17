<?php

/**
 *
 * @package PM Welcome
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\pmwelcome\event;

use phpbb\db\driver\driver_interface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\user;
use phpbb\config\config;
use phpbb\config\db_text;

class listener implements EventSubscriberInterface
{
   /** @var \phpbb\user */
   protected $user;

   /** @var \phpbb\config\config */
   protected $config;

   /** @var \phpbb\config\db_text */
   protected $text;

   /** @var \phpbb\db\driver\driver_interface */
   protected $db;

   /** @var string root_path */
   protected $root_path;

   /** @var string phpEx */
   protected $php_ext;

   public function __construct(
      user $user,
      config $config,
      db_text $config_text,
      driver_interface $db,
      $root_path,
      $php_ext
   ) {
      $this->user            = $user;
      $this->config         = $config;
      $this->text            = $config_text;
      $this->db            = $db;
      $this->root_path      = $root_path;
      $this->php_ext         = $php_ext;
   }

   static public function getSubscribedEvents()
   {
      return array(
         'core.user_add_after'         => 'pm_welcome',
         'core.user_active_flip_before'   => 'pm_activate_welcome',
      );
   }

   public function pm_welcome($event)
   {
      $user_row = $event['user_row'];
      if ($user_row['user_type'] == USER_NORMAL) {
         $pwm_user = $this->config['pmwelcome_user'];
         $pwm_subject = $this->config['pmwelcome_subject'];
         $pwm_text = $this->text->get('pmwelcome_post_text');
         if ($pwm_user && $pwm_subject && $pwm_text) {
            $user_to = array(
               'user_id'         => $event['user_id'],
               'username'         => $user_row['username'],
               'user_email'      => $user_row['user_email'],
               'sitename'         => $this->config['sitename'],
               'site_desc'         => $this->config['site_desc'],
               'board_contact'      => $this->config['board_contact'],
               'board_email'      => $this->config['board_email'],
               'board_email_sig'   => $this->config['board_email_sig'],
            );

            $this->user_welcome($user_to, $pwm_user, $pwm_subject, $pwm_text);
         }
      }
   }

   public function pm_activate_welcome($event)
   {
      if ($this->config['require_activation'] != USER_ACTIVATION_ADMIN) {
         return;
      }

      $sql_ary = [
         'SELECT'   => 'u.user_id, u.user_type, u.user_lastvisit, u.username, u.user_email',
         'FROM'      => [USERS_TABLE => 'u'],
         'WHERE'      => $this->db->sql_in_set('u.user_id', $event['user_id_ary']),
      ];

      $sql = $this->db->sql_build_query('SELECT', $sql_ary);
      $result = $this->db->sql_query($sql);
      $user_rows = $this->db->sql_fetchrowset($result);
      $this->db->sql_freeresult($result);

      $pwm_user = $this->config['pmwelcome_user'];
      $pwm_subject = $this->config['pmwelcome_subject'];
      $pwm_text = $this->text->get('pmwelcome_post_text');

      foreach ($user_rows as $user_row) {
         if (!$user_row['user_lastvisit'] && $user_row['user_type'] == USER_INACTIVE && $pwm_user && $pwm_subject && $pwm_text) {
            $tokens = [
               '{USER_ID}'         => $user_row['user_id'],
               '{USERNAME}'      => $user_row['username'],
               '{USER_EMAIL}'      => $user_row['user_email'],
               '{SITE_NAME}'      => $this->config['sitename'],
               '{SITE_DESC}'      => $this->config['site_desc'],
               '{BOARD_CONTACT}'   => $this->config['board_contact'],
               '{BOARD_EMAIL}'      => $this->config['board_email'],
               '{BOARD_SIG}'      => $this->config['board_email_sig'],
            ];

            $this->user_welcome($tokens, $pwm_user, $pwm_subject, $pwm_text);
         }
      }
   }

   /** User PM Welcome Message */
   private function user_welcome($tokens, $user_id, $subject, $text)
   {
      $m_flags = 3; // 1 is bbcode, 2 is smiles, 4 is urls (add together to turn on more than one)
      $uid = $bitfield = '';
      $allow_bbcode = $allow_urls = $allow_smilies = true;

      $text = $this->replace_tokens($text, $tokens);
      generate_text_for_storage($text, $uid, $bitfield, $m_flags, $allow_bbcode, $allow_urls, $allow_smilies);

      $subject = $this->replace_tokens($subject, $tokens);

      if (!function_exists('submit_pm')) {
         include_once($this->root_path . 'includes/functions_privmsgs.' . $this->php_ext);
      }

      $pm_data = array(
         'address_list'      => array('u' => array($tokens['{USER_ID}'] => 'to')),
         'from_user_id'      => $user_id,
         'from_user_ip'      => $this->user->ip,
         'enable_sig'      => false,
         'enable_bbcode'      => $allow_bbcode,
         'enable_smilies'   => $allow_smilies,
         'enable_urls'      => $allow_urls,
         'icon_id'         => 0,
         'bbcode_bitfield'   => $bitfield,
         'bbcode_uid'      => $uid,
         'message'         => $text,
      );

      submit_pm('post', $subject, $pm_data, false);
   }

   function replace_tokens(string $str, array $tokens): string
   {
      foreach ($tokens as $token => $value) {
         $str = str_replace($token, $value, $str);
      }

      return $str;
   }
}
