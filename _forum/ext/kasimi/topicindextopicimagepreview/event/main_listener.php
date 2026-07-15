<?php

/**
 *
 * Topic Index - Topic Image Preview. An extension for the phpBB Forum Software package.
 *
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kasimi\topicindextopicimagepreview\event;

use phpbb\event\data;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use vse\topicimagepreview\event\preview as tip_helper;

class main_listener implements EventSubscriberInterface
{
   /** @var tip_helper */
   protected $tip_helper;

   /**
    * @param tip_helper $tip_helper
    */
   public function __construct(
      tip_helper $tip_helper = null
   ) {
      $this->tip_helper = $tip_helper;
   }

   /**
    * @return array
    */
   public static function getSubscribedEvents()
   {
      return [
         'dmzx.topicindex.sql_fetch_topics_after'      => 'update_row_data',
         'dmzx.topicindex.modify_block_topic_index_ary'   => 'update_tpl_data',
      ];
   }

   /**
    * @param data $event
    */
   public function update_row_data(data $event)
   {

      if ($this->tip_helper) {
         $topic_id = $event['array']['id'];

         $tip_event = new data([
            'topic_list'   => [$topic_id],
            'rowset'      => [],
         ]);

         $this->tip_helper->viewforum_row($tip_event);

         $post_text = isset($tip_event['rowset'][$topic_id]['post_text']) ? $tip_event['rowset'][$topic_id]['post_text'] : '';

         $event->update_subarray('array', 'topic_preview', $post_text);
      }
   }

   /**
    * @param data $event
    */
   public function update_tpl_data(data $event)
   {
      if ($this->tip_helper && isset($event['indexdata']['topic_preview'])) {
         $tip_event = new data([
            'row'       => [
               'post_text'   => $event['indexdata']['topic_preview'],
            ],
            'topic_row'   => [],
         ]);

         $this->tip_helper->viewforum_tpl($tip_event);

         $topic_images = isset($tip_event['topic_row']['TOPIC_IMAGES']) ? $tip_event['topic_row']['TOPIC_IMAGES'] : '';

         $event->update_subarray('template_vars', 'TOPIC_IMAGES', $topic_images);
      }
   }
}