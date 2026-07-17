Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/sitesplat\\opengraph/diff_full.tmp" "[FORUM_EXT]/sitesplat\\opengraph/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\opengraph/diff_full.tmp"
@@ -0,0 +1,164 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/event/listener.php"
+index 1f88cfab8..30465e8d9 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/event/listener.php"
+@@ -93,9 +93,12 @@ class listener implements EventSubscriberInterface
+ 					$this->container->getParameter('sitesplat.bbtags.tables.bbtags_topic')
+ 				);
+ 		}
+-
+-		$picture = ($event_number == 2) ? $event['detail_data']['picture'] : $this->find_picture($event['attachments']);
+-		$imageinfo = getimagesize($picture);
++		$picture = ($event_number == 2) ? $event['detail_data']['picture'] : ($event['attachments'] ? $this->find_picture($event['attachments']) : null);
++		if ($picture && is_file($picture)) {
++			$imageinfo = getimagesize($picture);
++		} else {
++			$imageinfo = ['width' => 0, 'height' => 0, 'mime' => ''];
++		}
+ 
+ 		if (!$event_number) {
+ 			$og_url = "{$this->board_url}/index.php";
+@@ -171,8 +174,9 @@ class listener implements EventSubscriberInterface
+ 		return $text;
+ 	}
+ 
+-	public function find_picture($attachments)
++	public function find_picture($event)
+ 	{
++		$attachments = $event['attachments'];
+ 		$attach_id = 0;
+ 		if (!empty($attachments))
+ 		{
+@@ -198,13 +202,63 @@ class listener implements EventSubscriberInterface
+ 				$attach_id = $attachments[$min_post][$min_image]['attach_id'];
+ 			}
+ 		}
++		else
++		{
++			$image=$this->find_images($event);
++			if (preg_match('/(https?:\/\/[a-zA-Z0-9.\/_%]+png|%[0-9]+)/', $image)){
++				$image=str_replace("%", "", $image);
++				if(is_numeric($image)){
++					return 'https://goldtuganime.com/forum/gallery/image/' . $image . '/source';
++					
++				}
++				else {
++					return $image;
++				}
++			}
++			else {
++				return $this->board_url . (($this->config['opengraph_imagepath']) ? '/' . $this->config['opengraph_imagepath'] : $image);
++			}
++			
++		}
+ 
+ 		$url = $this->board_url . (($this->config['opengraph_imagepath'] && !$attach_id) ? '/' . $this->config['opengraph_imagepath'] : 
+ 				((!$attach_id) ? '' : '/download/file.php?id=' . $attach_id));
+ 				
+ 		return ($this->board_url == $url) ? '' : $url;
+ 	}
+-	
++
++	public function find_images($event)
++	{
++		if ($event['start'] > 0 )
++		{
++			$sql = 'SELECT post_text FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $event['topic_data']['topic_first_post_id'];
++			$result = $this->db->sql_query($sql);
++			$row = $this->db->sql_fetchrow($result);
++			$image = $row['post_text'];
++		} else
++		{
++			$image = $event['rowset'][$event['topic_data']['topic_first_post_id']]['post_text'];
++		}
++		$image = censor_text($image);
++
++		strip_bbcode($image);
++		$image = str_replace(array("\n", "\t", "\r"), ' ', $image);
++		$image = str_replace(array("&quot;"), '', $image);
++		$image = preg_replace("/\[(.*)?\](.*)?\[(.*)?\]/", '', $image);
++		$image = preg_replace("/[^A-ZА-ЯЁ.,-–?]+/ui", ' ', $image);
++
++		if (strlen($image) > 200)
++		{
++			$image_ar = explode("\n", wordwrap($image, 200));
++			$image = $image_ar[0] . '...';
++		}
++		
++		$image = str_replace(array(' '), '%', $image);
++		$image = preg_replace("/%?(https?:\/\/[a-zA-Z0-9.\/_%]+png|%[0-9]+)[\s\S]+/", '$1', $image);
++
++		return $image;
++	}
++
+ 	public function add_config($event)
+ 	{
+ 		if($event['mode'] == 'settings')
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_after.html"
+index bad4f7901..9a287d35d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_after.html"
+@@ -1,4 +1,4 @@
+-{% if BB_LOAD_IN_VIEWTOPIC %}
++{% if BB_LOAD_IN_INDEX or BB_LOAD_IN_VIEWTOPIC %}
+ 	<!-- INCLUDEJS @sitesplat_opengraph/js/sharer.min.js -->
+ 	<!-- INCLUDEJS @sitesplat_opengraph/js/bbopengraph.js -->
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_body_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_body_after.html"
+index 33112fbac..b4b512546 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_body_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_body_after.html"
+@@ -1,4 +1,4 @@
+-{% if BB_LOAD_IN_VIEWTOPIC %}
++{% if BB_LOAD_IN_INDEX or BB_LOAD_IN_VIEWTOPIC %}
+ <div class="popup-wrap">
+     <div class="popup-box">
+         <ul class="list-unstyled sharer-mobile">
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_meta.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_meta.html"
+index a601700b9..ab2b53c01 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_meta.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_meta.html"
+@@ -10,10 +10,7 @@
+ 	<meta property="og:description" content="{SITE_DESCRIPTION}">
+ 	<meta property="og:url" content="{URL_BBOPENGRAPH_INDEX}"> 
+ 	<meta property="og:type" content="website">
+-	<!-- IF IMG_OPENGRAPH --><meta property="og:image" content="{IMG_OPENGRAPH}"><!-- ENDIF -->
+-	<!-- IF IMGTYPE_OPENGRAPH --><meta property="og:image:type" content="{IMGTYPE_OPENGRAPH}"><!-- ENDIF -->
+-	<!-- IF IMGWIDTH_OPENGRAPH --><meta property="og:image:width" content="{IMGWIDTH_OPENGRAPH}"><!-- ENDIF -->
+-	<!-- IF IMGHEIGHT_OPENGRAPH --><meta property="og:image:height" content="{IMGHEIGHT_OPENGRAPH}"><!-- ENDIF -->
++	<meta property="og:image" content="{IMG_OPENGRAPH}">
+ {% endif %}
+ 
+ {% if BB_LOAD_IN_VIEWTOPIC %}
+@@ -22,9 +19,6 @@
+ 	<meta property="og:title" content="{TITLE_OPENGRAPH}">
+ 	<meta property="og:description" content="{DESC_OPENGRAPH}">
+ 	<!-- IF IMG_OPENGRAPH --><meta property="og:image" content="{IMG_OPENGRAPH}"><!-- ENDIF -->
+-	<!-- IF IMGTYPE_OPENGRAPH --><meta property="og:image:type" content="{IMGTYPE_OPENGRAPH}"><!-- ENDIF -->
+-	<!-- IF IMGWIDTH_OPENGRAPH --><meta property="og:image:width" content="{IMGWIDTH_OPENGRAPH}"><!-- ENDIF -->
+-	<!-- IF IMGHEIGHT_OPENGRAPH --><meta property="og:image:height" content="{IMGHEIGHT_OPENGRAPH}"><!-- ENDIF -->
+ 	<!-- IF BBTAG_OPENGRAPH --><meta property="article:tag" content="{BBTAG_OPENGRAPH}"><!-- ENDIF -->
+ {% endif %}
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
+index 8a3ae53fa..79dd6602c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
+@@ -1,3 +1,3 @@
+-{% if BB_LOAD_IN_VIEWTOPIC %}
++{% if BB_LOAD_IN_INDEX or BB_LOAD_IN_VIEWTOPIC %}
+ 	<!-- INCLUDECSS @sitesplat_opengraph/bbopengraph.css -->
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/viewtopic_topic_tools_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/viewtopic_topic_tools_before.html"
+index da2c3369f..7e9675dff 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/viewtopic_topic_tools_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/viewtopic_topic_tools_before.html"
+@@ -1,4 +1,4 @@
+-{% if BB_LOAD_IN_VIEWTOPIC %}
++{% if BB_LOAD_IN_INDEX or BB_LOAD_IN_VIEWTOPIC %}
+ <div class="btn-group hidden-xs"> 
+ <div class="share-button">
+ 	<a class="shareit-txt" href="javascript:void(0)">{L_SHARE_THIS}</a>
diff --git "[FORUM_EXT]/sitesplat\\opengraph/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\opengraph/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\opengraph/diff_nospace.tmp"
@@ -0,0 +1,152 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/diff_full.tmp"
+new file mode 100644
+index 000000000..b63e70048
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/diff_full.tmp"
+@@ -0,0 +1,164 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/event/listener.php"
++index 1f88cfab8..30465e8d9 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/event/listener.php"
++@@ -93,9 +93,12 @@ class listener implements EventSubscriberInterface
++ 					$this->container->getParameter('sitesplat.bbtags.tables.bbtags_topic')
++ 				);
++ 		}
++-
++-		$picture = ($event_number == 2) ? $event['detail_data']['picture'] : $this->find_picture($event['attachments']);
++-		$imageinfo = getimagesize($picture);
+++		$picture = ($event_number == 2) ? $event['detail_data']['picture'] : ($event['attachments'] ? $this->find_picture($event['attachments']) : null);
+++		if ($picture && is_file($picture)) {
+++			$imageinfo = getimagesize($picture);
+++		} else {
+++			$imageinfo = ['width' => 0, 'height' => 0, 'mime' => ''];
+++		}
++ 
++ 		if (!$event_number) {
++ 			$og_url = "{$this->board_url}/index.php";
++@@ -171,8 +174,9 @@ class listener implements EventSubscriberInterface
++ 		return $text;
++ 	}
++ 
++-	public function find_picture($attachments)
+++	public function find_picture($event)
++ 	{
+++		$attachments = $event['attachments'];
++ 		$attach_id = 0;
++ 		if (!empty($attachments))
++ 		{
++@@ -198,13 +202,63 @@ class listener implements EventSubscriberInterface
++ 				$attach_id = $attachments[$min_post][$min_image]['attach_id'];
++ 			}
++ 		}
+++		else
+++		{
+++			$image=$this->find_images($event);
+++			if (preg_match('/(https?:\/\/[a-zA-Z0-9.\/_%]+png|%[0-9]+)/', $image)){
+++				$image=str_replace("%", "", $image);
+++				if(is_numeric($image)){
+++					return 'https://goldtuganime.com/forum/gallery/image/' . $image . '/source';
+++					
+++				}
+++				else {
+++					return $image;
+++				}
+++			}
+++			else {
+++				return $this->board_url . (($this->config['opengraph_imagepath']) ? '/' . $this->config['opengraph_imagepath'] : $image);
+++			}
+++			
+++		}
++ 
++ 		$url = $this->board_url . (($this->config['opengraph_imagepath'] && !$attach_id) ? '/' . $this->config['opengraph_imagepath'] : 
++ 				((!$attach_id) ? '' : '/download/file.php?id=' . $attach_id));
++ 				
++ 		return ($this->board_url == $url) ? '' : $url;
++ 	}
++-	
+++
+++	public function find_images($event)
+++	{
+++		if ($event['start'] > 0 )
+++		{
+++			$sql = 'SELECT post_text FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $event['topic_data']['topic_first_post_id'];
+++			$result = $this->db->sql_query($sql);
+++			$row = $this->db->sql_fetchrow($result);
+++			$image = $row['post_text'];
+++		} else
+++		{
+++			$image = $event['rowset'][$event['topic_data']['topic_first_post_id']]['post_text'];
+++		}
+++		$image = censor_text($image);
+++
+++		strip_bbcode($image);
+++		$image = str_replace(array("\n", "\t", "\r"), ' ', $image);
+++		$image = str_replace(array("&quot;"), '', $image);
+++		$image = preg_replace("/\[(.*)?\](.*)?\[(.*)?\]/", '', $image);
+++		$image = preg_replace("/[^A-ZА-ЯЁ.,-–?]+/ui", ' ', $image);
+++
+++		if (strlen($image) > 200)
+++		{
+++			$image_ar = explode("\n", wordwrap($image, 200));
+++			$image = $image_ar[0] . '...';
+++		}
+++		
+++		$image = str_replace(array(' '), '%', $image);
+++		$image = preg_replace("/%?(https?:\/\/[a-zA-Z0-9.\/_%]+png|%[0-9]+)[\s\S]+/", '$1', $image);
+++
+++		return $image;
+++	}
+++
++ 	public function add_config($event)
++ 	{
++ 		if($event['mode'] == 'settings')
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_after.html"
++index bad4f7901..9a287d35d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_after.html"
++@@ -1,4 +1,4 @@
++-{% if BB_LOAD_IN_VIEWTOPIC %}
+++{% if BB_LOAD_IN_INDEX or BB_LOAD_IN_VIEWTOPIC %}
++ 	<!-- INCLUDEJS @sitesplat_opengraph/js/sharer.min.js -->
++ 	<!-- INCLUDEJS @sitesplat_opengraph/js/bbopengraph.js -->
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_body_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_body_after.html"
++index 33112fbac..b4b512546 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_body_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_body_after.html"
++@@ -1,4 +1,4 @@
++-{% if BB_LOAD_IN_VIEWTOPIC %}
+++{% if BB_LOAD_IN_INDEX or BB_LOAD_IN_VIEWTOPIC %}
++ <div class="popup-wrap">
++     <div class="popup-box">
++         <ul class="list-unstyled sharer-mobile">
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_meta.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_meta.html"
++index a601700b9..ab2b53c01 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_meta.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_meta.html"
++@@ -10,10 +10,7 @@
++ 	<meta property="og:description" content="{SITE_DESCRIPTION}">
++ 	<meta property="og:url" content="{URL_BBOPENGRAPH_INDEX}"> 
++ 	<meta property="og:type" content="website">
++-	<!-- IF IMG_OPENGRAPH --><meta property="og:image" content="{IMG_OPENGRAPH}"><!-- ENDIF -->
++-	<!-- IF IMGTYPE_OPENGRAPH --><meta property="og:image:type" content="{IMGTYPE_OPENGRAPH}"><!-- ENDIF -->
++-	<!-- IF IMGWIDTH_OPENGRAPH --><meta property="og:image:width" content="{IMGWIDTH_OPENGRAPH}"><!-- ENDIF -->
++-	<!-- IF IMGHEIGHT_OPENGRAPH --><meta property="og:image:height" content="{IMGHEIGHT_OPENGRAPH}"><!-- ENDIF -->
+++	<meta property="og:image" content="{IMG_OPENGRAPH}">
++ {% endif %}
++ 
++ {% if BB_LOAD_IN_VIEWTOPIC %}
++@@ -22,9 +19,6 @@
++ 	<meta property="og:title" content="{TITLE_OPENGRAPH}">
++ 	<meta property="og:description" content="{DESC_OPENGRAPH}">
++ 	<!-- IF IMG_OPENGRAPH --><meta property="og:image" content="{IMG_OPENGRAPH}"><!-- ENDIF -->
++-	<!-- IF IMGTYPE_OPENGRAPH --><meta property="og:image:type" content="{IMGTYPE_OPENGRAPH}"><!-- ENDIF -->
++-	<!-- IF IMGWIDTH_OPENGRAPH --><meta property="og:image:width" content="{IMGWIDTH_OPENGRAPH}"><!-- ENDIF -->
++-	<!-- IF IMGHEIGHT_OPENGRAPH --><meta property="og:image:height" content="{IMGHEIGHT_OPENGRAPH}"><!-- ENDIF -->
++ 	<!-- IF BBTAG_OPENGRAPH --><meta property="article:tag" content="{BBTAG_OPENGRAPH}"><!-- ENDIF -->
++ {% endif %}
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\opengr
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\opengraph/event/listener.php" "[FORUM_EXT]/sitesplat\\opengraph/event/listener.php"
--- "[ORIGINAL]/sitesplat\\opengraph/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\opengraph/event/listener.php"
@@ -93,9 +93,12 @@ class listener implements EventSubscriberInterface
 					$this->container->getParameter('sitesplat.bbtags.tables.bbtags_topic')
 				);
 		}
-
-		$picture = ($event_number == 2) ? $event['detail_data']['picture'] : $this->find_picture($event['attachments']);
+		$picture = ($event_number == 2) ? $event['detail_data']['picture'] : ($event['attachments'] ? $this->find_picture($event['attachments']) : null);
+		if ($picture && is_file($picture)) {
 			$imageinfo = getimagesize($picture);
+		} else {
+			$imageinfo = ['width' => 0, 'height' => 0, 'mime' => ''];
+		}
 
 		if (!$event_number) {
 			$og_url = "{$this->board_url}/index.php";
@@ -171,8 +174,9 @@ class listener implements EventSubscriberInterface
 		return $text;
 	}
 
-	public function find_picture($attachments)
+	public function find_picture($event)
 	{
+		$attachments = $event['attachments'];
 		$attach_id = 0;
 		if (!empty($attachments))
 		{
@@ -198,6 +202,24 @@ class listener implements EventSubscriberInterface
 				$attach_id = $attachments[$min_post][$min_image]['attach_id'];
 			}
 		}
+		else
+		{
+			$image=$this->find_images($event);
+			if (preg_match('/(https?:\/\/[a-zA-Z0-9.\/_%]+png|%[0-9]+)/', $image)){
+				$image=str_replace("%", "", $image);
+				if(is_numeric($image)){
+					return 'https://goldtuganime.com/forum/gallery/image/' . $image . '/source';
+					
+				}
+				else {
+					return $image;
+				}
+			}
+			else {
+				return $this->board_url . (($this->config['opengraph_imagepath']) ? '/' . $this->config['opengraph_imagepath'] : $image);
+			}
+			
+		}
 
 		$url = $this->board_url . (($this->config['opengraph_imagepath'] && !$attach_id) ? '/' . $this->config['opengraph_imagepath'] : 
 				((!$attach_id) ? '' : '/download/file.php?id=' . $attach_id));
@@ -205,6 +227,38 @@ class listener implements EventSubscriberInterface
 		return ($this->board_url == $url) ? '' : $url;
 	}
 
+	public function find_images($event)
+	{
+		if ($event['start'] > 0 )
+		{
+			$sql = 'SELECT post_text FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $event['topic_data']['topic_first_post_id'];
+			$result = $this->db->sql_query($sql);
+			$row = $this->db->sql_fetchrow($result);
+			$image = $row['post_text'];
+		} else
+		{
+			$image = $event['rowset'][$event['topic_data']['topic_first_post_id']]['post_text'];
+		}
+		$image = censor_text($image);
+
+		strip_bbcode($image);
+		$image = str_replace(array("\n", "\t", "\r"), ' ', $image);
+		$image = str_replace(array("&quot;"), '', $image);
+		$image = preg_replace("/\[(.*)?\](.*)?\[(.*)?\]/", '', $image);
+		$image = preg_replace("/[^A-ZА-ЯЁ.,-–?]+/ui", ' ', $image);
+
+		if (strlen($image) > 200)
+		{
+			$image_ar = explode("\n", wordwrap($image, 200));
+			$image = $image_ar[0] . '...';
+		}
+		
+		$image = str_replace(array(' '), '%', $image);
+		$image = preg_replace("/%?(https?:\/\/[a-zA-Z0-9.\/_%]+png|%[0-9]+)[\s\S]+/", '$1', $image);
+
+		return $image;
+	}
+
 	public function add_config($event)
 	{
 		if($event['mode'] == 'settings')
diff --git "[ORIGINAL]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_after.html" "[FORUM_EXT]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_after.html"
--- "[ORIGINAL]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_after.html"
+++ "[FORUM_EXT]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_after.html"
@@ -1,4 +1,4 @@
-{% if BB_LOAD_IN_VIEWTOPIC %}
+{% if BB_LOAD_IN_INDEX or BB_LOAD_IN_VIEWTOPIC %}
 	<!-- INCLUDEJS @sitesplat_opengraph/js/sharer.min.js -->
 	<!-- INCLUDEJS @sitesplat_opengraph/js/bbopengraph.js -->
 {% endif %}
diff --git "[ORIGINAL]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_body_after.html" "[FORUM_EXT]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_body_after.html"
--- "[ORIGINAL]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_body_after.html"
+++ "[FORUM_EXT]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_footer_body_after.html"
@@ -1,4 +1,4 @@
-{% if BB_LOAD_IN_VIEWTOPIC %}
+{% if BB_LOAD_IN_INDEX or BB_LOAD_IN_VIEWTOPIC %}
 <div class="popup-wrap">
     <div class="popup-box">
         <ul class="list-unstyled sharer-mobile">
diff --git "[ORIGINAL]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_meta.html" "[FORUM_EXT]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_meta.html"
--- "[ORIGINAL]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_meta.html"
+++ "[FORUM_EXT]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_meta.html"
@@ -10,10 +10,7 @@
 	<meta property="og:description" content="{SITE_DESCRIPTION}">
 	<meta property="og:url" content="{URL_BBOPENGRAPH_INDEX}"> 
 	<meta property="og:type" content="website">
-	<!-- IF IMG_OPENGRAPH --><meta property="og:image" content="{IMG_OPENGRAPH}"><!-- ENDIF -->
-	<!-- IF IMGTYPE_OPENGRAPH --><meta property="og:image:type" content="{IMGTYPE_OPENGRAPH}"><!-- ENDIF -->
-	<!-- IF IMGWIDTH_OPENGRAPH --><meta property="og:image:width" content="{IMGWIDTH_OPENGRAPH}"><!-- ENDIF -->
-	<!-- IF IMGHEIGHT_OPENGRAPH --><meta property="og:image:height" content="{IMGHEIGHT_OPENGRAPH}"><!-- ENDIF -->
+	<meta property="og:image" content="{IMG_OPENGRAPH}">
 {% endif %}
 
 {% if BB_LOAD_IN_VIEWTOPIC %}
@@ -22,9 +19,6 @@
 	<meta property="og:title" content="{TITLE_OPENGRAPH}">
 	<meta property="og:description" content="{DESC_OPENGRAPH}">
 	<!-- IF IMG_OPENGRAPH --><meta property="og:image" content="{IMG_OPENGRAPH}"><!-- ENDIF -->
-	<!-- IF IMGTYPE_OPENGRAPH --><meta property="og:image:type" content="{IMGTYPE_OPENGRAPH}"><!-- ENDIF -->
-	<!-- IF IMGWIDTH_OPENGRAPH --><meta property="og:image:width" content="{IMGWIDTH_OPENGRAPH}"><!-- ENDIF -->
-	<!-- IF IMGHEIGHT_OPENGRAPH --><meta property="og:image:height" content="{IMGHEIGHT_OPENGRAPH}"><!-- ENDIF -->
 	<!-- IF BBTAG_OPENGRAPH --><meta property="article:tag" content="{BBTAG_OPENGRAPH}"><!-- ENDIF -->
 {% endif %}
 
diff --git "[ORIGINAL]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_stylesheets_after.html" "[FORUM_EXT]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
--- "[ORIGINAL]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
+++ "[FORUM_EXT]/sitesplat\\opengraph/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
@@ -1,3 +1,3 @@
-{% if BB_LOAD_IN_VIEWTOPIC %}
+{% if BB_LOAD_IN_INDEX or BB_LOAD_IN_VIEWTOPIC %}
 	<!-- INCLUDECSS @sitesplat_opengraph/bbopengraph.css -->
 {% endif %}
diff --git "[ORIGINAL]/sitesplat\\opengraph/styles/BBOOTS/template/event/viewtopic_topic_tools_before.html" "[FORUM_EXT]/sitesplat\\opengraph/styles/BBOOTS/template/event/viewtopic_topic_tools_before.html"
--- "[ORIGINAL]/sitesplat\\opengraph/styles/BBOOTS/template/event/viewtopic_topic_tools_before.html"
+++ "[FORUM_EXT]/sitesplat\\opengraph/styles/BBOOTS/template/event/viewtopic_topic_tools_before.html"
@@ -1,4 +1,4 @@
-{% if BB_LOAD_IN_VIEWTOPIC %}
+{% if BB_LOAD_IN_INDEX or BB_LOAD_IN_VIEWTOPIC %}
 <div class="btn-group hidden-xs"> 
 <div class="share-button">
 	<a class="shareit-txt" href="javascript:void(0)">{L_SHARE_THIS}</a>
```
