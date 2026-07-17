Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/kasimi\\topicindextopicimagepreview/composer.json" "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/composer.json"
--- "[ORIGINAL]/kasimi\\topicindextopicimagepreview/composer.json"
+++ "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/composer.json"
@@ -8,8 +8,6 @@
     "authors": [
         {
             "name": "kasimi",
-            "email": "mail@kasimi.net",
-            "homepage": "https://kasimi.net",
             "role": "Developer"
         }
     ],
diff --git "[ORIGINAL]/kasimi\\topicindextopicimagepreview/config/services.yml" "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/config/services.yml"
--- "[ORIGINAL]/kasimi\\topicindextopicimagepreview/config/services.yml"
+++ "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/config/services.yml"
@@ -2,6 +2,7 @@ services:
     kasimi.topicindextopicimagepreview.listener:
         class: kasimi\topicindextopicimagepreview\event\main_listener
         arguments:
-            - '@?vse.TopicImagePreview.listener'
+            - '@?vse.topicimagepreview.preview'
+            - '@?vse.topicimagepreview.settings'
         tags:
             - { name: event.listener }
diff --git "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/diff_full.tmp" "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/diff_full.tmp"
@@ -0,0 +1,231 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/composer.json"
+index 01941c3ff..1f4f63a8c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/composer.json"
+@@ -8,8 +8,6 @@
+     "authors": [
+         {
+             "name": "kasimi",
+-            "email": "mail@kasimi.net",
+-            "homepage": "https://kasimi.net",
+             "role": "Developer"
+         }
+     ],
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/config/services.yml"
+index 749e38337..17bc58182 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/config/services.yml"
+@@ -2,6 +2,7 @@ services:
+     kasimi.topicindextopicimagepreview.listener:
+         class: kasimi\topicindextopicimagepreview\event\main_listener
+         arguments:
+-            - '@?vse.TopicImagePreview.listener'
++            - '@?vse.topicimagepreview.preview'
++            - '@?vse.topicimagepreview.settings'
+         tags:
+             - { name: event.listener }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/event/main_listener.php"
+index 4c9d11846..2c1c3941d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/event/main_listener.php"
+@@ -4,7 +4,6 @@
+  *
+  * Topic Index - Topic Image Preview. An extension for the phpBB Forum Software package.
+  *
+- * @copyright (c) 2018 kasimi - https://kasimi.net
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+@@ -13,75 +12,73 @@ namespace kasimi\topicindextopicimagepreview\event;
+ 
+ use phpbb\event\data;
+ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+-use vse\TopicImagePreview\event\listener as tip_listener;
++use vse\topicimagepreview\event\preview as tip_helper;
+ 
+ class main_listener implements EventSubscriberInterface
+ {
+-	/** @var tip_listener */
+-	protected $tip_listener;
+-
+-	/**
+-	 * @param tip_listener $tip_listener
+-	 */
+-	public function __construct(
+-		tip_listener $tip_listener = null
+-	)
+-	{
+-		$this->tip_listener = $tip_listener;
+-	}
+-
+-	/**
+-	 * @return array
+-	 */
+-	public static function getSubscribedEvents()
+-	{
+-		return [
+-			'dmzx.topicindex.sql_fetch_topics_after'		=> 'update_row_data',
+-			'dmzx.topicindex.modify_block_topic_index_ary'	=> 'update_tpl_data',
+-		];
+-	}
+-
+-	/**
+-	 * @param data $event
+-	 */
+-	public function update_row_data(data $event)
+-	{
+-		if ($this->tip_listener)
+-		{
+-			$topic_id = $event['array']['id'];
+-
+-			$tip_event = new data([
+-				'topic_list'	=> [$topic_id],
+-				'rowset'		=> [],
+-			]);
+-
+-			$this->tip_listener->update_row_data($tip_event);
+-
+-			$post_text = isset($tip_event['rowset'][$topic_id]['post_text']) ? $tip_event['rowset'][$topic_id]['post_text'] : '';
+-
+-			$event->update_subarray('array', 'topic_preview', $post_text);
+-		}
+-	}
+-
+-	/**
+-	 * @param data $event
+-	 */
+-	public function update_tpl_data(data $event)
+-	{
+-		if ($this->tip_listener && isset($event['indexdata']['topic_preview']))
+-		{
+-			$tip_event = new data([
+-				'row' 		=> [
+-					'post_text'	=> $event['indexdata']['topic_preview'],
+-				],
+-				'topic_row'	=> [],
+-			]);
+-
+-			$this->tip_listener->update_tpl_data($tip_event);
+-
+-			$topic_images = isset($tip_event['topic_row']['TOPIC_IMAGES']) ? $tip_event['topic_row']['TOPIC_IMAGES'] : '';
+-
+-			$event->update_subarray('template_vars', 'TOPIC_IMAGES', $topic_images);
+-		}
+-	}
+-}
++   /** @var tip_helper */
++   protected $tip_helper;
++
++   /**
++    * @param tip_helper $tip_helper
++    */
++   public function __construct(
++      tip_helper $tip_helper = null
++   ) {
++      $this->tip_helper = $tip_helper;
++   }
++
++   /**
++    * @return array
++    */
++   public static function getSubscribedEvents()
++   {
++      return [
++         'dmzx.topicindex.sql_fetch_topics_after'      => 'update_row_data',
++         'dmzx.topicindex.modify_block_topic_index_ary'   => 'update_tpl_data',
++      ];
++   }
++
++   /**
++    * @param data $event
++    */
++   public function update_row_data(data $event)
++   {
++
++      if ($this->tip_helper) {
++         $topic_id = $event['array']['id'];
++
++         $tip_event = new data([
++            'topic_list'   => [$topic_id],
++            'rowset'      => [],
++         ]);
++
++         $this->tip_helper->viewforum_row($tip_event);
++
++         $post_text = isset($tip_event['rowset'][$topic_id]['post_text']) ? $tip_event['rowset'][$topic_id]['post_text'] : '';
++
++         $event->update_subarray('array', 'topic_preview', $post_text);
++      }
++   }
++
++   /**
++    * @param data $event
++    */
++   public function update_tpl_data(data $event)
++   {
++      if ($this->tip_helper && isset($event['indexdata']['topic_preview'])) {
++         $tip_event = new data([
++            'row'       => [
++               'post_text'   => $event['indexdata']['topic_preview'],
++            ],
++            'topic_row'   => [],
++         ]);
++
++         $this->tip_helper->viewforum_tpl($tip_event);
++
++         $topic_images = isset($tip_event['topic_row']['TOPIC_IMAGES']) ? $tip_event['topic_row']['TOPIC_IMAGES'] : '';
++
++         $event->update_subarray('template_vars', 'TOPIC_IMAGES', $topic_images);
++      }
++   }
++}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_after.html"
+index 04f5b8449..348fbb2ff 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_after.html"
+@@ -1 +1 @@
+-</div>
++<!-- </span> -->
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html"
+index d3112180d..23dae6582 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html"
+@@ -1 +1,32 @@
+-<div{% if block_topic_index.TOPIC_IMAGES %} data-ot="{{ block_topic_index.TOPIC_IMAGES }}" data-ot-group="topics" data-ot-background="transparent" data-ot-border-width="0" data-ot-border-radius="0"{% endif %}>
++
++	<style>
++		.opentip-container {
++			max-width: 1000px;
++			white-space: nowrap;
++		}
++		.ot-content > img {
++			max-width: {{ TOPIC_IMAGE_PREVIEW_DIM_MAX }}px;
++			max-height: {{ TOPIC_IMAGE_PREVIEW_DIM_MAX }}px;
++			vertical-align: top;
++		}
++	</style>
++
++
++
++	<script>
++		head.ready(function () {
++			$(function() {
++				$("[data-ot]").closest("dt").removeAttr("title");
++			});
++		});
++	</script>
++
++
++<span{% if preview.TOPIC_IMAGES %}
++	data-ot="{% for image in preview.TOPIC_IMAGES %}<img src='/forum/app.php/gallery/image/{{ image }}/source' alt='{{ lang('IMAGE') }}' style='max-width:{preview.TOPIC_IMAGES_SIZE_MAX}px; max-height:{preview.TOPIC_IMAGES_SIZE_MAX}px;'>&nbsp;{% endfor %}"
++	data-ot-group="topics"
++	data-ot-background="transparent"
++	data-ot-border-width="0"
++	data-ot-border-radius="0"{% endif %}>
++{% if preview.TOPIC_IMAGES %}<div style="float:left;padding-right:10px;">{% for image in preview.TOPIC_IMAGES %}<img src="/forum/app.php/gallery/image/{{ image }}/mini" alt="{{ lang('IMAGE') }}" style="max-width:{preview.TOPIC_IMAGES_SIZE_MIN}px; max-height:{preview.TOPIC_IMAGES_SIZE_MIN}px;">&nbsp;{% endfor %}</div>{% endif %}
++</span>
+\ No newline at end of file
diff --git "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/diff_nospace.tmp" "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/diff_nospace.tmp"
@@ -0,0 +1,199 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/composer.json"
+index 01941c3ff..1f4f63a8c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/composer.json"
+@@ -8,8 +8,6 @@
+     "authors": [
+         {
+             "name": "kasimi",
+-            "email": "mail@kasimi.net",
+-            "homepage": "https://kasimi.net",
+             "role": "Developer"
+         }
+     ],
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/config/services.yml"
+index 749e38337..17bc58182 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/config/services.yml"
+@@ -2,6 +2,7 @@ services:
+     kasimi.topicindextopicimagepreview.listener:
+         class: kasimi\topicindextopicimagepreview\event\main_listener
+         arguments:
+-            - '@?vse.TopicImagePreview.listener'
++            - '@?vse.topicimagepreview.preview'
++            - '@?vse.topicimagepreview.settings'
+         tags:
+             - { name: event.listener }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/diff_full.tmp"
+new file mode 100644
+index 000000000..19bead068
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/diff_full.tmp"
+@@ -0,0 +1,231 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/composer.json"
++index 01941c3ff..1f4f63a8c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/composer.json"
++@@ -8,8 +8,6 @@
++     "authors": [
++         {
++             "name": "kasimi",
++-            "email": "mail@kasimi.net",
++-            "homepage": "https://kasimi.net",
++             "role": "Developer"
++         }
++     ],
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/config/services.yml"
++index 749e38337..17bc58182 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/config/services.yml"
++@@ -2,6 +2,7 @@ services:
++     kasimi.topicindextopicimagepreview.listener:
++         class: kasimi\topicindextopicimagepreview\event\main_listener
++         arguments:
++-            - '@?vse.TopicImagePreview.listener'
+++            - '@?vse.topicimagepreview.preview'
+++            - '@?vse.topicimagepreview.settings'
++         tags:
++             - { name: event.listener }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/event/main_listener.php"
++index 4c9d11846..2c1c3941d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindextopicimagepreview/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindextopicimagepreview/event/main_listener.php"
++@@ -4,7 +4,6 @@
++  *
++  * Topic Index - Topic Image Preview. An extension for the phpBB Forum Software package.
++  *
++- * @copyright (c) 2018 kasimi - https://kasimi.net
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++@@ -13,75 +12,73 @@ namespace kasimi\topicindextopicimagepreview\event;
++ 
++ use phpbb\event\data;
++ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
++-use vse\TopicImagePreview\event\listener as tip_listener;
+++use vse\topicimagepreview\event\preview as tip_helper;
++ 
++ class main_listener implements EventSubscriberInterface
++ {
++-	/** @var tip_listener */
++-	protected $tip_listener;
++-
++-	/**
++-	 * @param tip_listener $tip_listener
++-	 */
++-	public function __construct(
++-		tip_listener $tip_listener = null
++-	)
++-	{
++-		$this->tip_listener = $tip_listener;
++-	}
++-
++-	/**
++-	 * @return array
++-	 */
++-	public static function getSubscribedEvents()
++-	{
++-		return [
++-			'dmzx.topicindex.sql_fetch_topics_after'		=> 'update_row_data',
++-			'dmzx.topicindex.modify_block_topic_index_ary'	=> 'update_tpl_data',
++-		];
++-	}
++-
++-	/**
++-	 * @param data $event
++-	 */
++-	public function update_row_data(data $event)
++-	{
++-		if ($this->tip_listener)
++-		{
++-			$topic_id = $event['array']['id'];
++-
++-			$tip_event = new data([
++-				'topic_list'	=> [$topic_id],
++-				'rowset'		=> [],
++-			]);
++-
++-			$this->tip_listener->update_row_data($tip_event);
++-
++-			$post_text = isset($tip_event['rowset'][$topic_id]['post_text']) ? $tip_event['rowset'][$topic_id]['post_text'] : '';
++-
++-			$event->update_subarray('array', 'topic_preview', $post_text);
++-		}
++-	}
++-
++-	/**
++-	 * @param data $event
++-	 */
++-	public function update_tpl_data(data $event)
++-	{
++-		if ($this->tip_listener && isset($event['indexdata']['topic_preview']))
++-		{
++-			$tip_event = new data([
++-				'row' 		=> [
++-					'post_text'	=> $event['indexdata']['topic_preview'],
++-				],
++-				'topic_row'	=> [],
++-			]);
++-
++-			$this->tip_listener->update_tpl_data($tip_event);
++-
++-			$topic_images = isset($tip_event['topic_row']['TOPIC_IMAGES']) ? $tip_event['topic_row']['TOPIC_IMAGES'] : '';
++-
++-			$event->update_subarray('template_vars', 'TOPIC_IMAGES', $topic_images);
++-		}
++-	}
++-}
+++   /** @var tip_helper */
+++   protected $tip_helper;
+++
+++   /**
+++    * @param tip_helper $tip_helper
+++    */
+++   public function __construct(
+++      tip_helper $tip_helper = null
+++   ) {
+++      $this->tip_helper = $tip_helper;
+++   }
+++
+++   /**
+++    * @return array
+++    */
+++   public static function getSubscribedEvents()
+++   {
+++      return [
+++         'dmzx.topicindex.sql_fetch_topics_after'      => 'update_row_data',
+++         'dmzx.topicindex.modify_block_topic_index_ary'   => 'update_tpl_data',
+++      ];
+++   }
+++
+++   /**
+++    * @param data $event
+++    */
+++   public function update_row_data(data $event)
+++   {
+++
+++      if ($this->tip_helper) {
+++         $topic_id = $event['array']['id'];
+++
+++         $tip_event = new data([
+++            'topic_list'   => [$topic_id],
+++            'rowset'      => [],
+++         ]);
+++
+++         $this->tip_helper->viewforum_row($tip_event);
+++
+++         $post_text = isset($tip_event['rowset'][$topic_id]['post_text']) ? $tip_event['rowset'][$topic_id]['post_text'] : '';
+++
+++         $event->update_subarray('array', 'topic_preview', $post_text);
+++      }
+++   }
+++
+++   /**
+++    * @param data $event
+++    */
+++   public function update_tpl_data(da
\ No newline at end of file
diff --git "[ORIGINAL]/kasimi\\topicindextopicimagepreview/event/main_listener.php" "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/event/main_listener.php"
--- "[ORIGINAL]/kasimi\\topicindextopicimagepreview/event/main_listener.php"
+++ "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/event/main_listener.php"
@@ -4,7 +4,6 @@
  *
  * Topic Index - Topic Image Preview. An extension for the phpBB Forum Software package.
  *
- * @copyright (c) 2018 kasimi - https://kasimi.net
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
@@ -13,21 +12,20 @@ namespace kasimi\topicindextopicimagepreview\event;
 
 use phpbb\event\data;
 use Symfony\Component\EventDispatcher\EventSubscriberInterface;
-use vse\TopicImagePreview\event\listener as tip_listener;
+use vse\topicimagepreview\event\preview as tip_helper;
 
 class main_listener implements EventSubscriberInterface
 {
-	/** @var tip_listener */
-	protected $tip_listener;
+   /** @var tip_helper */
+   protected $tip_helper;
 
    /**
-	 * @param tip_listener $tip_listener
+    * @param tip_helper $tip_helper
     */
    public function __construct(
-		tip_listener $tip_listener = null
-	)
-	{
-		$this->tip_listener = $tip_listener;
+      tip_helper $tip_helper = null
+   ) {
+      $this->tip_helper = $tip_helper;
    }
 
    /**
@@ -46,8 +44,8 @@ class main_listener implements EventSubscriberInterface
     */
    public function update_row_data(data $event)
    {
-		if ($this->tip_listener)
-		{
+
+      if ($this->tip_helper) {
          $topic_id = $event['array']['id'];
 
          $tip_event = new data([
@@ -55,7 +53,7 @@ class main_listener implements EventSubscriberInterface
             'rowset'      => [],
          ]);
 
-			$this->tip_listener->update_row_data($tip_event);
+         $this->tip_helper->viewforum_row($tip_event);
 
          $post_text = isset($tip_event['rowset'][$topic_id]['post_text']) ? $tip_event['rowset'][$topic_id]['post_text'] : '';
 
@@ -68,8 +66,7 @@ class main_listener implements EventSubscriberInterface
     */
    public function update_tpl_data(data $event)
    {
-		if ($this->tip_listener && isset($event['indexdata']['topic_preview']))
-		{
+      if ($this->tip_helper && isset($event['indexdata']['topic_preview'])) {
          $tip_event = new data([
             'row'       => [
                'post_text'   => $event['indexdata']['topic_preview'],
@@ -77,7 +74,7 @@ class main_listener implements EventSubscriberInterface
             'topic_row'   => [],
          ]);
 
-			$this->tip_listener->update_tpl_data($tip_event);
+         $this->tip_helper->viewforum_tpl($tip_event);
 
          $topic_images = isset($tip_event['topic_row']['TOPIC_IMAGES']) ? $tip_event['topic_row']['TOPIC_IMAGES'] : '';
 
diff --git "[ORIGINAL]/kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_after.html" "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_after.html"
--- "[ORIGINAL]/kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_after.html"
+++ "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_after.html"
@@ -1 +1 @@
-</div>
+<!-- </span> -->
diff --git "[ORIGINAL]/kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html" "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html"
--- "[ORIGINAL]/kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html"
+++ "[FORUM_EXT]/kasimi\\topicindextopicimagepreview/styles/all/template/event/dmzx_topic_index_topic_title_container_before.html"
@@ -1 +1,32 @@
-<div{% if block_topic_index.TOPIC_IMAGES %} data-ot="{{ block_topic_index.TOPIC_IMAGES }}" data-ot-group="topics" data-ot-background="transparent" data-ot-border-width="0" data-ot-border-radius="0"{% endif %}>
+
+	<style>
+		.opentip-container {
+			max-width: 1000px;
+			white-space: nowrap;
+		}
+		.ot-content > img {
+			max-width: {{ TOPIC_IMAGE_PREVIEW_DIM_MAX }}px;
+			max-height: {{ TOPIC_IMAGE_PREVIEW_DIM_MAX }}px;
+			vertical-align: top;
+		}
+	</style>
+
+
+
+	<script>
+		head.ready(function () {
+			$(function() {
+				$("[data-ot]").closest("dt").removeAttr("title");
+			});
+		});
+	</script>
+
+
+<span{% if preview.TOPIC_IMAGES %}
+	data-ot="{% for image in preview.TOPIC_IMAGES %}<img src='/forum/app.php/gallery/image/{{ image }}/source' alt='{{ lang('IMAGE') }}' style='max-width:{preview.TOPIC_IMAGES_SIZE_MAX}px; max-height:{preview.TOPIC_IMAGES_SIZE_MAX}px;'>&nbsp;{% endfor %}"
+	data-ot-group="topics"
+	data-ot-background="transparent"
+	data-ot-border-width="0"
+	data-ot-border-radius="0"{% endif %}>
+{% if preview.TOPIC_IMAGES %}<div style="float:left;padding-right:10px;">{% for image in preview.TOPIC_IMAGES %}<img src="/forum/app.php/gallery/image/{{ image }}/mini" alt="{{ lang('IMAGE') }}" style="max-width:{preview.TOPIC_IMAGES_SIZE_MIN}px; max-height:{preview.TOPIC_IMAGES_SIZE_MIN}px;">&nbsp;{% endfor %}</div>{% endif %}
+</span>
\ No newline at end of file
```
