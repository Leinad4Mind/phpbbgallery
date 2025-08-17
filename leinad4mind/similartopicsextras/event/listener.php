<?php

/**
 *
 * @package phpBB Extension - Precise Similar Topics: Extras Extension
 * @copyright (c) 2022 Leinad4Mind - https://leinad4mind.top/forum
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\similartopicsextras\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
   public static function getSubscribedEvents()
   {
      return array(
         'vse.similartopics.modify_topicrow' => 'modify_row',
      );
   }

   /**
    * @param \phpbb\event\data $event The event object
    */
   public static function modify_row($event)
   {
      global $phpbb_container, $extension_manager;
      $topic_row = $event['topic_row'];
      $extension_manager = $phpbb_container->get('ext.manager');
      if ($extension_manager->is_enabled('sitesplat/bbemoji')) {
         $bbemoji = $phpbb_container->get('sitesplat.bbemoji.listener');
         // BBEmoji is installed and working.
         $topic_row['TOPIC_TITLE'] = $bbemoji->render(
            $bbemoji->parse(
               \censor_text($event['row']['topic_title'])
            )
         );
         if (!empty($bbemoji->icons[$event['row']['icon_id']])) {
            $icon = $bbemoji->icons[$event['row']['icon_id']];
            $topic_row['TOPIC_ICON_IMG'] = $icon;
            $topic_row['TOPIC_ICON_IMG_WIDTH'] = 20;
            $topic_row['TOPIC_ICON_IMG_HEIGHT'] = 20;
         }
      }

      if ($extension_manager->is_enabled('sitesplat/bbprefix')) {
         $bbprefix = $phpbb_container->get('bbprefix.manager');
         // BBPrefix is installed and working.
         $prefix_id = $bbprefix->get_instance($instance_id)['prefix'];
         $url = $topic_row['U_VIEW_FORUM'] . '&prefix=' . $prefix_id;
         $prefixes[] = $bbprefix->get_instance($instance_id)->parse('', ['URL' => $url], true);
      }

      // TODO
      // if ($extension_manager->is_enabled('kinerity/bestanswer') || $extension_manager->is_enabled('leinad4mind/bestanswer')) {
      // Best Answer is installed and working.
      // $topic_row['TOPIC_ANSWERED'] = $event['row']['answer_post_id'] ? true : false;
      // }

      $event['topic_row'] = $topic_row;
   }
}