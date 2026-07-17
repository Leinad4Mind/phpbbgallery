Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\bbfront/acp/bbfront_module.php" "[FORUM_EXT]/sitesplat\\bbfront/acp/bbfront_module.php"
--- "[ORIGINAL]/sitesplat\\bbfront/acp/bbfront_module.php"
+++ "[FORUM_EXT]/sitesplat\\bbfront/acp/bbfront_module.php"
@@ -52,7 +52,7 @@ class bbfront_module
 	
 				$this->config->set('bbfront_inc_forums', json_encode($this->request->variable('bbfront_inc_forums', array(0))));
 				$this->config->set('bbfront_inc_groups', json_encode($this->request->variable('bbfront_inc_groups', array(0))));
-				$this->config->set('bbfront_settings', json_encode($this->request->variable('bbfront_settings', array('' => ''))));
+				$this->config->set('bbfront_settings', json_encode($this->request->variable('bbfront_settings', array('' => ''), true)));
 				$this->config->set('sitesplat_bbfront_grid_layout', $this->request->variable('bbfront_grid_layout', '4-l'));
 				$this->config->set('sitesplat_bbfront_grid_fx_first', $this->request->variable('bbfront_grid_fx_first', 'Hapi'));
 				$this->config->set('sitesplat_bbfront_grid_fx_load', $this->request->variable('bbfront_grid_fx_load', 'Hapi'));
diff --git "[ORIGINAL]/sitesplat\\bbfront/controller/main.php" "[FORUM_EXT]/sitesplat\\bbfront/controller/main.php"
--- "[ORIGINAL]/sitesplat\\bbfront/controller/main.php"
+++ "[FORUM_EXT]/sitesplat\\bbfront/controller/main.php"
@@ -201,8 +201,23 @@ class main
 					$this->db->sql_freeresult($result1);
 				}
 
-				preg_match('/\[quote(.*?)](.*?)\[\/quote(.*?)\]/msi', $row['post_text'], $quote);
+				$topicimage = '';
+
+				if(!$attach_id) {
+					preg_match('#\[img\](http.*?\.[jpgn]{3})\[\/img\]#', $row['post_text'], $topicimage);
+					$row['post_text'] = (isset($topicimage[0])) ? str_replace($topicimage[0], '', $row['post_text']) : $row['post_text'];
+					preg_match('/\<IMG(.*?)\>(.*?)\<\/IMG\>/msi', $row['post_text'], $topicimage);
+					$row['post_text'] = (isset($topicimage[0])) ? str_replace($topicimage[0], '', $row['post_text']) : $row['post_text'];
+				}
+
+				$row['post_text'] = preg_replace('#\[((?!quoting)[^]])*\]#', '', $row['post_text']);
+				preg_match('/\[quoting=?(.*?)](.*?)\[\/quoting(.*?)\]/msi', $row['post_text'], $quote);
 				$row['post_text'] = (isset($quote[2])) ? $quote[2] : $row['post_text'];
+				$row['post_text'] = htmlspecialchars_decode($row['post_text']);
+				$row['post_text'] = str_replace("&", "&amp;", $row['post_text']);
+
+				// $attributes = (!isset($quote[2])) ? $this->matchUrl($row['post_text']) : null;
+
 				$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
 
 				// support for phpbb-mediaembed 2.0+ - comment out if using BBembed
@@ -211,23 +226,32 @@ class main
 				if (preg_match('`<span data\-s9e\-mediaembed\="(.*?)"(.*?)</span>`', $rendered_post, $media)) {
 					$medium = $media[1];
 					$video = "<span data-s9e-mediaembed=\"$medium\"{$media[2]}</span></span>";
-				}
-				else if (preg_match('`<([a-z]+) data\-s9e\-mediaembed\="(.*?)"(.*?)</\\1>`', $rendered_post, $media)) {
+				} else if (preg_match('`<([a-z]+) data\-s9e\-mediaembed\="(.*?)"(.*?)</\\1>`', $rendered_post, $media)) {
 					$medium = $media[2];
 					$video = "<{$media[1]} data-s9e-mediaembed=\"$medium\"{$media[3]}</{$media[1]}>";
 				}
 
+				$res = 0;
+				if(!empty($quote[1])) {
+					$res = strpos($quote[1], ' ', strpos($quote[1], ' ', 0) + 1);
+				}
+				$user_quote = !empty($quote) ? rtrim(trim( substr( $quote[1], $res ) ), '"') : "";
+				$text_truncated = truncate_string(strip_tags($rendered_post), $config_aray['chars'], $config_aray['chars'], true, " ...");
+				$topicimage = preg_replace('/\s+src=\"(.+)\"/', '$1', $topicimage[1]);
+
 				$tpl_ary = array(
 					'URL'		=> append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'] . '#p' . $row['post_id']),
 					'TITLE'		=> $row['post_subject'],
+					'TEXT'		=> $text_truncated,
 					'QUOTE'		=> (isset($quote[2])) ? true: false,
-					'PICTURE'	=> (!$attach_id) ? '' : generate_board_url() . '/download/file.php?id=' . $attach_id,
-					'TEXT'		=> truncate_string(strip_tags($rendered_post), $config_aray['chars'], $config_aray['chars'], true, " ..."),
+					'PICTURE'	=> (!$attach_id) ? $topicimage : generate_board_url() . '/download/file.php?id=' . $attach_id,
+					// 'EMBED' => !empty($attributes['embed']) ? $attributes['embed'] : '',
 					'VIDEO'		=> $video,
 					'MEDIUM'	=> $medium,
-
 					'AUTHOR'	=> get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour']),
-					'USER_QUOTE'=> get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour']),
+					'AUTHOR_CLEAN' => strtolower(get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour'])),
+					'USER_QUOTE' => $user_quote,
+					'USER_CLEAN' => strtolower($user_quote),
 					'AVATAR'	=> ($config_aray['use_avatar']) ? phpbb_get_user_avatar(array('avatar' => $row['user_avatar'],
 										  'user_id'         => $row['user_id'],
 										  'avatar_type'		=> $row['user_avatar_type'],
@@ -290,78 +314,78 @@ class main
 	}
 
 // comment out the next two functions when enabling phpbb-mediaembed!!!
-	protected function matchUrl($url)
-	{
-		if (!$this->phpbb_container->get('ext.manager')->is_enabled('sitesplat/bbembed'))
-		{
-			return false;
-		}
+// 	protected function matchUrl($url)
+// 	{
+// 		if (!$this->phpbb_container->get('ext.manager')->is_enabled('sitesplat/bbembed'))
+// 		{
+// 			return false;	
+// 		}
 		
-		$regexps = array(
-		    'facebook' => array(
-				"@/(?!(?:apps|developers|graph)\\.)[-\\w.]*facebook\\.com/(?:[/\\w]+/permalink|(?!pages/|groups/).*?)(?:/|fbid=|\\?v=)(?<id>\\d+)(?![^/?&#])@",
-				"#/(?<type>video)s?/#"
-			),
-//			'googleplus' => array(
-//				'!//plus\\.google\\.com/(?:u/\\d+/)?(?:\\+(?<name>[^/]+)|(?<oid>\\d+))/posts/(?<pid>\\w+)!'
+// 		$regexps = array(
+// 		    'facebook' => array(
+// 				"@/(?!(?:apps|developers|graph)\\.)[-\\w.]*facebook\\.com/(?:[/\\w]+/permalink|(?!pages/|groups/).*?)(?:/|fbid=|\\?v=)(?<id>\\d+)(?![^/?&#])@",
+// 				"#/(?<type>video)s?/#"
 // 			),
-			'soundcloud' => array(
-				'@api\\.soundcloud\\.com/playlists/(?<playlist_id>\\d+)@',
-				'@api\\.soundcloud\\.com/tracks/(?<track_id>\\d+)(?:\\?secret_token=(?<secret_token>[-\\w]+))?@',
-				'@soundcloud\\.com/(?!playlists|tracks)[-\\w]+/[-\\w]+/(?=s-)(?<secret_token>[-\\w]+)@'
-			),
-			'medium' => array(
-				"!medium\\.com/[^/]*/(?:[-\\w]+-)?(?'id'[\\da-f]+)!"
-			),
-			'twitch' => array(
-				"#twitch\\.tv/(?<channel>(?!m/)\\w+)(?:/b/(?<archive_id>\\d+)|/c/(?<chapter_id>\\d+)|/v/(?<video_id>\\d+))?#"
-			),
-			'twitter' => array(
-				"@twitter\\.com/(?:#!/)?\\w+/status(?:es)?/(?<id>\\d+)@",
-			),
-			'vimeo' => array(
-				'!vimeo\\.com/(?:channels/[^/]+/|video/)?(?<id>\\d+)!',
-			),
-			'youtube' => array(
-				"!youtube\\.com/(?:watch.*?v=|v/)(?<id>[-\\w]+)!",
-				"!youtu\\.be/(?<id>[-\\w]+)!"
-			)
-		);
+// //			'googleplus' => array(
+// //				'!//plus\\.google\\.com/(?:u/\\d+/)?(?:\\+(?<name>[^/]+)|(?<oid>\\d+))/posts/(?<pid>\\w+)!'
+// //			),
+// 			'soundcloud' => array(
+// 				'@api\\.soundcloud\\.com/playlists/(?<playlist_id>\\d+)@',
+// 				'@api\\.soundcloud\\.com/tracks/(?<track_id>\\d+)(?:\\?secret_token=(?<secret_token>[-\\w]+))?@',
+// 				'@soundcloud\\.com/(?!playlists|tracks)[-\\w]+/[-\\w]+/(?=s-)(?<secret_token>[-\\w]+)@'
+// 			),
+// 			'medium' => array(
+// 				"!medium\\.com/[^/]*/(?:[-\\w]+-)?(?'id'[\\da-f]+)!"
+// 			),
+// 			'twitch' => array(
+// 				"#twitch\\.tv/(?<channel>(?!m/)\\w+)(?:/b/(?<archive_id>\\d+)|/c/(?<chapter_id>\\d+)|/v/(?<video_id>\\d+))?#"
+// 			),
+// 			'twitter' => array(
+// 				"@twitter\\.com/(?:#!/)?\\w+/status(?:es)?/(?<id>\\d+)@",
+// 			),
+// 			'vimeo' => array(
+// 				'!vimeo\\.com/(?:channels/[^/]+/|video/)?(?<id>\\d+)!',
+// 			),
+// 			'youtube' => array(
+// 				"!youtube\\.com/(?:watch.*?v=|v/)(?<id>[-\\w]+)!",
+// 				"!youtu\\.be/(?<id>[-\\w]+)!"
+// 			)
+// 		);
 
-		foreach ($regexps as $embed => $siteRegexps)
-		{
-			$attributes = array();
-			foreach ($siteRegexps as $regexp)
-			{
-				$attributes += $this->extractAttributes($url, $regexp);
-			}
-			if (!empty($attributes))
-			{
-				(isset($attributes['channel'])) ? $attributes['id'] = $attributes['channel'] : null;
-				return array('embed' => $embed, 'attributes' => $attributes);
-			}
-		}
+// 		foreach ($regexps as $embed => $siteRegexps)
+// 		{
+// 			$attributes = array();
+// 			foreach ($siteRegexps as $regexp)
+// 			{
+// 				$attributes += $this->extractAttributes($url, $regexp);
+// 			}
+// 			if (!empty($attributes))
+// 			{
+// 				(isset($attributes['channel'])) ? $attributes['id'] = $attributes['channel'] : null;
+// 				return array('embed' => $embed, 'attributes' => $attributes);
+// 			}
+// 		}
 
-		return false;
-	}
+// 		return false;
+// 	}
 
 
-	protected function extractAttributes($url, $regexp)
-	{
-		$attributes = array();
-		if (preg_match($regexp, $url, $m))
-		{
-			foreach ($m as $k => $v)
-			{
-				if (!is_numeric($k) && $v !== '')
-				{
-					$attributes[$k] = $v;
-				}
-			}
-		}
+// 	protected function extractAttributes($url, $regexp)
+// 	{
+// 		$attributes = array();
+// 		if (preg_match($regexp, $url, $m))
+// 		{
+// 			foreach ($m as $k => $v)
+// 			{
+// 				if (!is_numeric($k) && $v !== '')
+// 				{
+// 					$attributes[$k] = $v;
+// 				}
+// 			}
+// 		}
 
-		return $attributes;
-	}
+// 		return $attributes;
+// 	}
 
 	/**
 	 * {@inheritdoc}
diff --git "[FORUM_EXT]/sitesplat\\bbfront/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bbfront/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbfront/diff_full.tmp"
@@ -0,0 +1,430 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/acp/bbfront_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/acp/bbfront_module.php"
+index 96a60d75d..816277b15 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/acp/bbfront_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/acp/bbfront_module.php"
+@@ -52,7 +52,7 @@ class bbfront_module
+ 	
+ 				$this->config->set('bbfront_inc_forums', json_encode($this->request->variable('bbfront_inc_forums', array(0))));
+ 				$this->config->set('bbfront_inc_groups', json_encode($this->request->variable('bbfront_inc_groups', array(0))));
+-				$this->config->set('bbfront_settings', json_encode($this->request->variable('bbfront_settings', array('' => ''))));
++				$this->config->set('bbfront_settings', json_encode($this->request->variable('bbfront_settings', array('' => ''), true)));
+ 				$this->config->set('sitesplat_bbfront_grid_layout', $this->request->variable('bbfront_grid_layout', '4-l'));
+ 				$this->config->set('sitesplat_bbfront_grid_fx_first', $this->request->variable('bbfront_grid_fx_first', 'Hapi'));
+ 				$this->config->set('sitesplat_bbfront_grid_fx_load', $this->request->variable('bbfront_grid_fx_load', 'Hapi'));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/controller/main.php"
+index c8aeb7d94..9f739625e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/controller/main.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/controller/main.php"
+@@ -201,8 +201,23 @@ class main
+ 					$this->db->sql_freeresult($result1);
+ 				}
+ 
+-				preg_match('/\[quote(.*?)](.*?)\[\/quote(.*?)\]/msi', $row['post_text'], $quote);
++				$topicimage = '';
++
++				if(!$attach_id) {
++					preg_match('#\[img\](http.*?\.[jpgn]{3})\[\/img\]#', $row['post_text'], $topicimage);
++					$row['post_text'] = (isset($topicimage[0])) ? str_replace($topicimage[0], '', $row['post_text']) : $row['post_text'];
++					preg_match('/\<IMG(.*?)\>(.*?)\<\/IMG\>/msi', $row['post_text'], $topicimage);
++					$row['post_text'] = (isset($topicimage[0])) ? str_replace($topicimage[0], '', $row['post_text']) : $row['post_text'];
++				}
++
++				$row['post_text'] = preg_replace('#\[((?!quoting)[^]])*\]#', '', $row['post_text']);
++				preg_match('/\[quoting=?(.*?)](.*?)\[\/quoting(.*?)\]/msi', $row['post_text'], $quote);
+ 				$row['post_text'] = (isset($quote[2])) ? $quote[2] : $row['post_text'];
++				$row['post_text'] = htmlspecialchars_decode($row['post_text']);
++				$row['post_text'] = str_replace("&", "&amp;", $row['post_text']);
++
++				// $attributes = (!isset($quote[2])) ? $this->matchUrl($row['post_text']) : null;
++
+ 				$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
+ 
+ 				// support for phpbb-mediaembed 2.0+ - comment out if using BBembed
+@@ -211,23 +226,32 @@ class main
+ 				if (preg_match('`<span data\-s9e\-mediaembed\="(.*?)"(.*?)</span>`', $rendered_post, $media)) {
+ 					$medium = $media[1];
+ 					$video = "<span data-s9e-mediaembed=\"$medium\"{$media[2]}</span></span>";
+-				}
+-				else if (preg_match('`<([a-z]+) data\-s9e\-mediaembed\="(.*?)"(.*?)</\\1>`', $rendered_post, $media)) {
++				} else if (preg_match('`<([a-z]+) data\-s9e\-mediaembed\="(.*?)"(.*?)</\\1>`', $rendered_post, $media)) {
+ 					$medium = $media[2];
+ 					$video = "<{$media[1]} data-s9e-mediaembed=\"$medium\"{$media[3]}</{$media[1]}>";
+ 				}
+ 
++				$res = 0;
++				if(!empty($quote[1])) {
++					$res = strpos($quote[1], ' ', strpos($quote[1], ' ', 0) + 1);
++				}
++				$user_quote = !empty($quote) ? rtrim(trim( substr( $quote[1], $res ) ), '"') : "";
++				$text_truncated = truncate_string(strip_tags($rendered_post), $config_aray['chars'], $config_aray['chars'], true, " ...");
++				$topicimage = preg_replace('/\s+src=\"(.+)\"/', '$1', $topicimage[1]);
++
+ 				$tpl_ary = array(
+ 					'URL'		=> append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'] . '#p' . $row['post_id']),
+ 					'TITLE'		=> $row['post_subject'],
++					'TEXT'		=> $text_truncated,
+ 					'QUOTE'		=> (isset($quote[2])) ? true: false,
+-					'PICTURE'	=> (!$attach_id) ? '' : generate_board_url() . '/download/file.php?id=' . $attach_id,
+-					'TEXT'		=> truncate_string(strip_tags($rendered_post), $config_aray['chars'], $config_aray['chars'], true, " ..."),
++					'PICTURE'	=> (!$attach_id) ? $topicimage : generate_board_url() . '/download/file.php?id=' . $attach_id,
++					// 'EMBED' => !empty($attributes['embed']) ? $attributes['embed'] : '',
+ 					'VIDEO'		=> $video,
+ 					'MEDIUM'	=> $medium,
+-
+ 					'AUTHOR'	=> get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour']),
+-					'USER_QUOTE'=> get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour']),
++					'AUTHOR_CLEAN' => strtolower(get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour'])),
++					'USER_QUOTE' => $user_quote,
++					'USER_CLEAN' => strtolower($user_quote),
+ 					'AVATAR'	=> ($config_aray['use_avatar']) ? phpbb_get_user_avatar(array('avatar' => $row['user_avatar'],
+ 										  'user_id'         => $row['user_id'],
+ 										  'avatar_type'		=> $row['user_avatar_type'],
+@@ -275,7 +299,7 @@ class main
+ 
+ 			$bbfront_url = $this->helper->route('sitesplat_bbfront_controller', array('name' => $config_aray['name']));
+ 			$this->template->assign_vars(array(
+-				'BBBFRONT_START' => (!$start) ? true : false,
++				'BBBFRONT_START' => (!$start) ? true : false, 
+ 				'BBFRONT_END'	=> $start + $per_page >= $total,
+ 				'U_BBBFRONT_NEXT' => strpos($bbfront_url, '?') === false ? $bbfront_url . '?fstart=' . ($start + $per_page) : $bbfront_url . '&fstart=' . ($start + $per_page),
+ 				'BBFRONT_GRID_LAYOUT'	=> $this->config['sitesplat_bbfront_grid_layout'],
+@@ -290,78 +314,78 @@ class main
+ 	}
+ 
+ // comment out the next two functions when enabling phpbb-mediaembed!!!
+-	protected function matchUrl($url)
+-	{
+-		if (!$this->phpbb_container->get('ext.manager')->is_enabled('sitesplat/bbembed'))
+-		{
+-			return false;
+-		}
+-
+-		$regexps = array(
+-		    'facebook' => array(
+-				"@/(?!(?:apps|developers|graph)\\.)[-\\w.]*facebook\\.com/(?:[/\\w]+/permalink|(?!pages/|groups/).*?)(?:/|fbid=|\\?v=)(?<id>\\d+)(?![^/?&#])@",
+-				"#/(?<type>video)s?/#"
+-			),
+-//			'googleplus' => array(
+-//				'!//plus\\.google\\.com/(?:u/\\d+/)?(?:\\+(?<name>[^/]+)|(?<oid>\\d+))/posts/(?<pid>\\w+)!'
+-//			),
+-			'soundcloud' => array(
+-				'@api\\.soundcloud\\.com/playlists/(?<playlist_id>\\d+)@',
+-				'@api\\.soundcloud\\.com/tracks/(?<track_id>\\d+)(?:\\?secret_token=(?<secret_token>[-\\w]+))?@',
+-				'@soundcloud\\.com/(?!playlists|tracks)[-\\w]+/[-\\w]+/(?=s-)(?<secret_token>[-\\w]+)@'
+-			),
+-			'medium' => array(
+-				"!medium\\.com/[^/]*/(?:[-\\w]+-)?(?'id'[\\da-f]+)!"
+-			),
+-			'twitch' => array(
+-				"#twitch\\.tv/(?<channel>(?!m/)\\w+)(?:/b/(?<archive_id>\\d+)|/c/(?<chapter_id>\\d+)|/v/(?<video_id>\\d+))?#"
+-			),
+-			'twitter' => array(
+-				"@twitter\\.com/(?:#!/)?\\w+/status(?:es)?/(?<id>\\d+)@",
+-			),
+-			'vimeo' => array(
+-				'!vimeo\\.com/(?:channels/[^/]+/|video/)?(?<id>\\d+)!',
+-			),
+-			'youtube' => array(
+-				"!youtube\\.com/(?:watch.*?v=|v/)(?<id>[-\\w]+)!",
+-				"!youtu\\.be/(?<id>[-\\w]+)!"
+-			)
+-		);
+-
+-		foreach ($regexps as $embed => $siteRegexps)
+-		{
+-			$attributes = array();
+-			foreach ($siteRegexps as $regexp)
+-			{
+-				$attributes += $this->extractAttributes($url, $regexp);
+-			}
+-			if (!empty($attributes))
+-			{
+-				(isset($attributes['channel'])) ? $attributes['id'] = $attributes['channel'] : null;
+-				return array('embed' => $embed, 'attributes' => $attributes);
+-			}
+-		}
+-
+-		return false;
+-	}
+-
+-
+-	protected function extractAttributes($url, $regexp)
+-	{
+-		$attributes = array();
+-		if (preg_match($regexp, $url, $m))
+-		{
+-			foreach ($m as $k => $v)
+-			{
+-				if (!is_numeric($k) && $v !== '')
+-				{
+-					$attributes[$k] = $v;
+-				}
+-			}
+-		}
+-
+-		return $attributes;
+-	}
++// 	protected function matchUrl($url)
++// 	{
++// 		if (!$this->phpbb_container->get('ext.manager')->is_enabled('sitesplat/bbembed'))
++// 		{
++// 			return false;	
++// 		}
++		
++// 		$regexps = array(
++// 		    'facebook' => array(
++// 				"@/(?!(?:apps|developers|graph)\\.)[-\\w.]*facebook\\.com/(?:[/\\w]+/permalink|(?!pages/|groups/).*?)(?:/|fbid=|\\?v=)(?<id>\\d+)(?![^/?&#])@",
++// 				"#/(?<type>video)s?/#"
++// 			),
++// //			'googleplus' => array(
++// //				'!//plus\\.google\\.com/(?:u/\\d+/)?(?:\\+(?<name>[^/]+)|(?<oid>\\d+))/posts/(?<pid>\\w+)!'
++// //			),
++// 			'soundcloud' => array(
++// 				'@api\\.soundcloud\\.com/playlists/(?<playlist_id>\\d+)@',
++// 				'@api\\.soundcloud\\.com/tracks/(?<track_id>\\d+)(?:\\?secret_token=(?<secret_token>[-\\w]+))?@',
++// 				'@soundcloud\\.com/(?!playlists|tracks)[-\\w]+/[-\\w]+/(?=s-)(?<secret_token>[-\\w]+)@'
++// 			),
++// 			'medium' => array(
++// 				"!medium\\.com/[^/]*/(?:[-\\w]+-)?(?'id'[\\da-f]+)!"
++// 			),
++// 			'twitch' => array(
++// 				"#twitch\\.tv/(?<channel>(?!m/)\\w+)(?:/b/(?<archive_id>\\d+)|/c/(?<chapter_id>\\d+)|/v/(?<video_id>\\d+))?#"
++// 			),
++// 			'twitter' => array(
++// 				"@twitter\\.com/(?:#!/)?\\w+/status(?:es)?/(?<id>\\d+)@",
++// 			),
++// 			'vimeo' => array(
++// 				'!vimeo\\.com/(?:channels/[^/]+/|video/)?(?<id>\\d+)!',
++// 			),
++// 			'youtube' => array(
++// 				"!youtube\\.com/(?:watch.*?v=|v/)(?<id>[-\\w]+)!",
++// 				"!youtu\\.be/(?<id>[-\\w]+)!"
++// 			)
++// 		);
++
++// 		foreach ($regexps as $embed => $siteRegexps)
++// 		{
++// 			$attributes = array();
++// 			foreach ($siteRegexps as $regexp)
++// 			{
++// 				$attributes += $this->extractAttributes($url, $regexp);
++// 			}
++// 			if (!empty($attributes))
++// 			{
++// 				(isset($attributes['channel'])) ? $attributes['id'] = $attributes['channel'] : null;
++// 				return array('embed' => $embed, 'attributes' => $attributes);
++// 			}
++// 		}
++
++// 		return false;
++// 	}
++
++
++// 	protected function extractAttributes($url, $regexp)
++// 	{
++// 		$attributes = array();
++// 		if (preg_match($regexp, $url, $m))
++// 		{
++// 			foreach ($m as $k => $v)
++// 			{
++// 				if (!is_numeric($k) && $v !== '')
++// 				{
++// 					$attributes[$k] = $v;
++// 				}
++// 			}
++// 		}
++
++// 		return $attributes;
++// 	}
+ 
+ 	/**
+ 	 * {@inheritdoc}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/diff_full.tmp"
+new file mode 100644
+index 000000000..a9a4d07ab
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/diff_full.tmp"
+@@ -0,0 +1,154 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/acp/bbfront_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/acp/bbfront_module.php"
++index 96a60d75d..816277b15 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/acp/bbfront_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/acp/bbfront_module.php"
++@@ -52,7 +52,7 @@ class bbfront_module
++ 	
++ 				$this->config->set('bbfront_inc_forums', json_encode($this->request->variable('bbfront_inc_forums', array(0))));
++ 				$this->config->set('bbfront_inc_groups', json_encode($this->request->variable('bbfront_inc_groups', array(0))));
++-				$this->config->set('bbfront_settings', json_encode($this->request->variable('bbfront_settings', array('' => ''))));
+++				$this->config->set('bbfront_settings', json_encode($this->request->variable('bbfront_settings', array('' => ''), true)));
++ 				$this->config->set('sitesplat_bbfront_grid_layout', $this->request->variable('bbfront_grid_layout', '4-l'));
++ 				$this->config->set('sitesplat_bbfront_grid_fx_first', $this->request->variable('bbfront_grid_fx_first', 'Hapi'));
++ 				$this->config->set('sitesplat_bbfront_grid_fx_load', $this->request->variable('bbfront_grid_fx_load', 'Hapi'));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/controller/main.php"
++index c8aeb7d94..9f739625e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/controller/main.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/controller/main.php"
++@@ -201,8 +201,23 @@ class main
++ 					$this->db->sql_freeresult($result1);
++ 				}
++ 
++-				preg_match('/\[quote(.*?)](.*?)\[\/quote(.*?)\]/msi', $row['post_text'], $quote);
+++				$topicimage = '';
+++
+++				if(!$attach_id) {
+++					preg_match('#\[img\](http.*?\.[jpgn]{3})\[\/img\]#', $row['post_text'], $topicimage);
+++					$row['post_text'] = (isset($topicimage[0])) ? str_replace($topicimage[0], '', $row['post_text']) : $row['post_text'];
+++					preg_match('/\<IMG(.*?)\>(.*?)\<\/IMG\>/msi', $row['post_text'], $topicimage);
+++					$row['post_text'] = (isset($topicimage[0])) ? str_replace($topicimage[0], '', $row['post_text']) : $row['post_text'];
+++				}
+++
+++				$row['post_text'] = preg_replace('#\[((?!quoting)[^]])*\]#', '', $row['post_text']);
+++				preg_match('/\[quoting=?(.*?)](.*?)\[\/quoting(.*?)\]/msi', $row['post_text'], $quote);
++ 				$row['post_text'] = (isset($quote[2])) ? $quote[2] : $row['post_text'];
+++				$row['post_text'] = htmlspecialchars_decode($row['post_text']);
+++				$row['post_text'] = str_replace("&", "&amp;", $row['post_text']);
+++
+++				// $attributes = (!isset($quote[2])) ? $this->matchUrl($row['post_text']) : null;
+++
++ 				$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
++ 
++ 				// support for phpbb-mediaembed 2.0+ - comment out if using BBembed
++@@ -211,23 +226,32 @@ class main
++ 				if (preg_match('`<span data\-s9e\-mediaembed\="(.*?)"(.*?)</span>`', $rendered_post, $media)) {
++ 					$medium = $media[1];
++ 					$video = "<span data-s9e-mediaembed=\"$medium\"{$media[2]}</span></span>";
++-				}
++-				else if (preg_match('`<([a-z]+) data\-s9e\-mediaembed\="(.*?)"(.*?)</\\1>`', $rendered_post, $media)) {
+++				} else if (preg_match('`<([a-z]+) data\-s9e\-mediaembed\="(.*?)"(.*?)</\\1>`', $rendered_post, $media)) {
++ 					$medium = $media[2];
++ 					$video = "<{$media[1]} data-s9e-mediaembed=\"$medium\"{$media[3]}</{$media[1]}>";
++ 				}
++ 
+++				$res = 0;
+++				if(!empty($quote[1])) {
+++					$res = strpos($quote[1], ' ', strpos($quote[1], ' ', 0) + 1);
+++				}
+++				$user_quote = !empty($quote) ? rtrim(trim( substr( $quote[1], $res ) ), '"') : "";
+++				$text_truncated = truncate_string(strip_tags($rendered_post), $config_aray['chars'], $config_aray['chars'], true, " ...");
+++				$topicimage = preg_replace('/\s+src=\"(.+)\"/', '$1', $topicimage[1]);
+++
++ 				$tpl_ary = array(
++ 					'URL'		=> append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'] . '#p' . $row['post_id']),
++ 					'TITLE'		=> $row['post_subject'],
+++					'TEXT'		=> $text_truncated,
++ 					'QUOTE'		=> (isset($quote[2])) ? true: false,
++-					'PICTURE'	=> (!$attach_id) ? '' : generate_board_url() . '/download/file.php?id=' . $attach_id,
++-					'TEXT'		=> truncate_string(strip_tags($rendered_post), $config_aray['chars'], $config_aray['chars'], true, " ..."),
+++					'PICTURE'	=> (!$attach_id) ? $topicimage : generate_board_url() . '/download/file.php?id=' . $attach_id,
+++					// 'EMBED' => !empty($attributes['embed']) ? $attributes['embed'] : '',
++ 					'VIDEO'		=> $video,
++ 					'MEDIUM'	=> $medium,
++-
++ 					'AUTHOR'	=> get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour']),
++-					'USER_QUOTE'=> get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour']),
+++					'AUTHOR_CLEAN' => strtolower(get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour'])),
+++					'USER_QUOTE' => $user_quote,
+++					'USER_CLEAN' => strtolower($user_quote),
++ 					'AVATAR'	=> ($config_aray['use_avatar']) ? phpbb_get_user_avatar(array('avatar' => $row['user_avatar'],
++ 										  'user_id'         => $row['user_id'],
++ 										  'avatar_type'		=> $row['user_avatar_type'],
++@@ -275,7 +299,7 @@ class main
++ 
++ 			$bbfront_url = $this->helper->route('sitesplat_bbfront_controller', array('name' => $config_aray['name']));
++ 			$this->template->assign_vars(array(
++-				'BBBFRONT_START' => (!$start) ? true : false,
+++				'BBBFRONT_START' => (!$start) ? true : false, 
++ 				'BBFRONT_END'	=> $start + $per_page >= $total,
++ 				'U_BBBFRONT_NEXT' => strpos($bbfront_url, '?') === false ? $bbfront_url . '?fstart=' . ($start + $per_page) : $bbfront_url . '&fstart=' . ($start + $per_page),
++ 				'BBFRONT_GRID_LAYOUT'	=> $this->config['sitesplat_bbfront_grid_layout'],
++@@ -290,78 +314,78 @@ class main
++ 	}
++ 
++ // comment out the next two functions when enabling phpbb-mediaembed!!!
++-	protected function matchUrl($url)
++-	{
++-		if (!$this->phpbb_container->get('ext.manager')->is_enabled('sitesplat/bbembed'))
++-		{
++-			return false;
++-		}
++-
++-		$regexps = array(
++-		    'facebook' => array(
++-				"@/(?!(?:apps|developers|graph)\\.)[-\\w.]*facebook\\.com/(?:[/\\w]+/permalink|(?!pages/|groups/).*?)(?:/|fbid=|\\?v=)(?<id>\\d+)(?![^/?&#])@",
++-				"#/(?<type>video)s?/#"
++-			),
++-//			'googleplus' => array(
++-//				'!//plus\\.google\\.com/(?:u/\\d+/)?(?:\\+(?<name>[^/]+)|(?<oid>\\d+))/posts/(?<pid>\\w+)!'
++-//			),
++-			'soundcloud' => array(
++-				'@api\\.soundcloud\\.com/playlists/(?<playlist_id>\\d+)@',
++-				'@api\\.soundcloud\\.com/tracks/(?<track_id>\\d+)(?:\\?secret_token=(?<secret_token>[-\\w]+))?@',
++-				'@soundcloud\\.com/(?!playlists|tracks)[-\\w]+/[-\\w]+/(?=s-)(?<secret_token>[-\\w]+)@'
++-			),
++-			'medium' => array(
++-				"!medium\\.com/[^/]*/(?:[-\\w]+-)?(?'id'[\\da-f]+)!"
++-			),
++-			'twitch' => array(
++-				"#twitch\\.tv/(?<channel>(?!m/)\\w+)(?:/b/(?<archive_id>\\d+)|/c/(?<chapter_id>\\d+)|/v/(?<video_id>\\d+))?#"
++-			),
++-			'twitter' => array(
++-				"@twitter\\.com/(?:#!/)?\\w+/status(?:es)?/(?<id>\\d+)@",
++-			),
++-			'vimeo' => array(
++-				'!vimeo\\.com/(?:channels/[^/]+/|video/)?(?<id>\\d+)!',
++-			),
++-			'youtube' => array(
++-				"!youtube\\.com/(?:watch.*?v=|v/)(?<id>[-\\w]+)!",
++-				"!youtu\\.be/(?<id>[-\\w]+)!"
++-			)
++-		);
++-
++-		foreach ($regexps as $embed => $siteRegexps)
++-		{
++-			$attributes = array();
++-			foreach ($siteRegexps as $regexp)
++-			{
++-				$attributes += $this->extractAttributes($url, $regexp);
++-			}
++-			if (!empty($attributes))
++-			{
++-				(isset($attributes['channel'])) ? $attributes['id'] = $attributes['channel'] : null;
++-				return array('embed' => $embed, 'attributes' => $attributes);
++-			}
++-		}
++-
++-		return false;
++-	}
++-
++-
++-	protected function extractAttributes($url, $regexp)
++-	{
++-		$attributes = array();
++-		if (preg_match($r
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/bbfront.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/bbfront.html"
+index 7216e7f87..519a60e3a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/bbfront.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/bbfront.html"
+@@ -16,10 +16,13 @@
+ 		<div class="blog-item{% if item.QUOTE %} blog-quote{% endif %}" style="opacity: 0;">
+ 			{% if item.PICTURE %}
+ 				<div class="blog-img"><img src="{{ item.PICTURE }}" class="img-responsive" alt="" /></div>
++				{% if item.QUOTE %}
++					<div class="quote quote-primary"><a href="{{ item.URL }}">{{ item.TEXT }}{% if item.USER_CLEAN neq item.AUTHOR_CLEAN and item.USER_QUOTE %}<small class="quote-author">&#45;&nbsp;{{ item.USER_QUOTE }}</small>{% endif %}</a></div>
++				{% endif %}
+ 			{% elseif item.VIDEO %}
+ 				<div class="blog-video {{ item.MEDIUM }}-front">{{ item.VIDEO }}</div>
+ 			{% elseif item.QUOTE %}
+-				<div class="quote quote-primary"><a href="{{ item.URL }}">{{ item.TEXT }}<small class="quote-author">&#45;&nbsp;{{ item.USER_QUOTE }}</small></a></div>
++				<div class="quote quote-primary"><a href="{{ item.URL }}">{{ item.TEXT }}{% if item.USER_CLEAN neq item.AUTHOR_CLEAN %}<small class="quote-author">&#45;&nbsp;{{ item.USER_QUOTE }}</small>{% endif %}</a></div>
+ 			{% endif %}
+ 
+ 			<div class="blog-details content">
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
+index 4dd548d9b..866b52ce3 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
+@@ -1 +1 @@
+-<li {$MICRODATA}><a class="bbfront-link" href="{U_BBFRONT_PAGE}" itemtype="https://schema.org/Thing" itemprop="item"><span itemprop="name">{BBFRONT_PAGE}</span></a><meta itemprop="position" content="0" /></li>
+\ No newline at end of file
++<li {{ MICRODATA }}><a class="bbfront-link text-capitalize" href="{{ U_BBFRONT_PAGE }}" itemtype="https://schema.org/Thing" itemprop="item"><span itemprop="name">{{ BBFRONT_PAGE }}</span></a><meta itemprop="position" content="0" /></li>
+\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\bbfront/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bbfront/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbfront/diff_nospace.tmp"
@@ -0,0 +1,658 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/acp/bbfront_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/acp/bbfront_module.php"
+index 96a60d75d..816277b15 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/acp/bbfront_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/acp/bbfront_module.php"
+@@ -52,7 +52,7 @@ class bbfront_module
+ 	
+ 				$this->config->set('bbfront_inc_forums', json_encode($this->request->variable('bbfront_inc_forums', array(0))));
+ 				$this->config->set('bbfront_inc_groups', json_encode($this->request->variable('bbfront_inc_groups', array(0))));
+-				$this->config->set('bbfront_settings', json_encode($this->request->variable('bbfront_settings', array('' => ''))));
++				$this->config->set('bbfront_settings', json_encode($this->request->variable('bbfront_settings', array('' => ''), true)));
+ 				$this->config->set('sitesplat_bbfront_grid_layout', $this->request->variable('bbfront_grid_layout', '4-l'));
+ 				$this->config->set('sitesplat_bbfront_grid_fx_first', $this->request->variable('bbfront_grid_fx_first', 'Hapi'));
+ 				$this->config->set('sitesplat_bbfront_grid_fx_load', $this->request->variable('bbfront_grid_fx_load', 'Hapi'));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/controller/main.php"
+index c8aeb7d94..9f739625e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/controller/main.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/controller/main.php"
+@@ -201,8 +201,23 @@ class main
+ 					$this->db->sql_freeresult($result1);
+ 				}
+ 
+-				preg_match('/\[quote(.*?)](.*?)\[\/quote(.*?)\]/msi', $row['post_text'], $quote);
++				$topicimage = '';
++
++				if(!$attach_id) {
++					preg_match('#\[img\](http.*?\.[jpgn]{3})\[\/img\]#', $row['post_text'], $topicimage);
++					$row['post_text'] = (isset($topicimage[0])) ? str_replace($topicimage[0], '', $row['post_text']) : $row['post_text'];
++					preg_match('/\<IMG(.*?)\>(.*?)\<\/IMG\>/msi', $row['post_text'], $topicimage);
++					$row['post_text'] = (isset($topicimage[0])) ? str_replace($topicimage[0], '', $row['post_text']) : $row['post_text'];
++				}
++
++				$row['post_text'] = preg_replace('#\[((?!quoting)[^]])*\]#', '', $row['post_text']);
++				preg_match('/\[quoting=?(.*?)](.*?)\[\/quoting(.*?)\]/msi', $row['post_text'], $quote);
+ 				$row['post_text'] = (isset($quote[2])) ? $quote[2] : $row['post_text'];
++				$row['post_text'] = htmlspecialchars_decode($row['post_text']);
++				$row['post_text'] = str_replace("&", "&amp;", $row['post_text']);
++
++				// $attributes = (!isset($quote[2])) ? $this->matchUrl($row['post_text']) : null;
++
+ 				$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
+ 
+ 				// support for phpbb-mediaembed 2.0+ - comment out if using BBembed
+@@ -211,23 +226,32 @@ class main
+ 				if (preg_match('`<span data\-s9e\-mediaembed\="(.*?)"(.*?)</span>`', $rendered_post, $media)) {
+ 					$medium = $media[1];
+ 					$video = "<span data-s9e-mediaembed=\"$medium\"{$media[2]}</span></span>";
+-				}
+-				else if (preg_match('`<([a-z]+) data\-s9e\-mediaembed\="(.*?)"(.*?)</\\1>`', $rendered_post, $media)) {
++				} else if (preg_match('`<([a-z]+) data\-s9e\-mediaembed\="(.*?)"(.*?)</\\1>`', $rendered_post, $media)) {
+ 					$medium = $media[2];
+ 					$video = "<{$media[1]} data-s9e-mediaembed=\"$medium\"{$media[3]}</{$media[1]}>";
+ 				}
+ 
++				$res = 0;
++				if(!empty($quote[1])) {
++					$res = strpos($quote[1], ' ', strpos($quote[1], ' ', 0) + 1);
++				}
++				$user_quote = !empty($quote) ? rtrim(trim( substr( $quote[1], $res ) ), '"') : "";
++				$text_truncated = truncate_string(strip_tags($rendered_post), $config_aray['chars'], $config_aray['chars'], true, " ...");
++				$topicimage = preg_replace('/\s+src=\"(.+)\"/', '$1', $topicimage[1]);
++
+ 				$tpl_ary = array(
+ 					'URL'		=> append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'] . '#p' . $row['post_id']),
+ 					'TITLE'		=> $row['post_subject'],
++					'TEXT'		=> $text_truncated,
+ 					'QUOTE'		=> (isset($quote[2])) ? true: false,
+-					'PICTURE'	=> (!$attach_id) ? '' : generate_board_url() . '/download/file.php?id=' . $attach_id,
+-					'TEXT'		=> truncate_string(strip_tags($rendered_post), $config_aray['chars'], $config_aray['chars'], true, " ..."),
++					'PICTURE'	=> (!$attach_id) ? $topicimage : generate_board_url() . '/download/file.php?id=' . $attach_id,
++					// 'EMBED' => !empty($attributes['embed']) ? $attributes['embed'] : '',
+ 					'VIDEO'		=> $video,
+ 					'MEDIUM'	=> $medium,
+-
+ 					'AUTHOR'	=> get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour']),
+-					'USER_QUOTE'=> get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour']),
++					'AUTHOR_CLEAN' => strtolower(get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour'])),
++					'USER_QUOTE' => $user_quote,
++					'USER_CLEAN' => strtolower($user_quote),
+ 					'AVATAR'	=> ($config_aray['use_avatar']) ? phpbb_get_user_avatar(array('avatar' => $row['user_avatar'],
+ 										  'user_id'         => $row['user_id'],
+ 										  'avatar_type'		=> $row['user_avatar_type'],
+@@ -290,78 +314,78 @@ class main
+ 	}
+ 
+ // comment out the next two functions when enabling phpbb-mediaembed!!!
+-	protected function matchUrl($url)
+-	{
+-		if (!$this->phpbb_container->get('ext.manager')->is_enabled('sitesplat/bbembed'))
+-		{
+-			return false;
+-		}
++// 	protected function matchUrl($url)
++// 	{
++// 		if (!$this->phpbb_container->get('ext.manager')->is_enabled('sitesplat/bbembed'))
++// 		{
++// 			return false;	
++// 		}
+ 		
+-		$regexps = array(
+-		    'facebook' => array(
+-				"@/(?!(?:apps|developers|graph)\\.)[-\\w.]*facebook\\.com/(?:[/\\w]+/permalink|(?!pages/|groups/).*?)(?:/|fbid=|\\?v=)(?<id>\\d+)(?![^/?&#])@",
+-				"#/(?<type>video)s?/#"
+-			),
+-//			'googleplus' => array(
+-//				'!//plus\\.google\\.com/(?:u/\\d+/)?(?:\\+(?<name>[^/]+)|(?<oid>\\d+))/posts/(?<pid>\\w+)!'
++// 		$regexps = array(
++// 		    'facebook' => array(
++// 				"@/(?!(?:apps|developers|graph)\\.)[-\\w.]*facebook\\.com/(?:[/\\w]+/permalink|(?!pages/|groups/).*?)(?:/|fbid=|\\?v=)(?<id>\\d+)(?![^/?&#])@",
++// 				"#/(?<type>video)s?/#"
+ // 			),
+-			'soundcloud' => array(
+-				'@api\\.soundcloud\\.com/playlists/(?<playlist_id>\\d+)@',
+-				'@api\\.soundcloud\\.com/tracks/(?<track_id>\\d+)(?:\\?secret_token=(?<secret_token>[-\\w]+))?@',
+-				'@soundcloud\\.com/(?!playlists|tracks)[-\\w]+/[-\\w]+/(?=s-)(?<secret_token>[-\\w]+)@'
+-			),
+-			'medium' => array(
+-				"!medium\\.com/[^/]*/(?:[-\\w]+-)?(?'id'[\\da-f]+)!"
+-			),
+-			'twitch' => array(
+-				"#twitch\\.tv/(?<channel>(?!m/)\\w+)(?:/b/(?<archive_id>\\d+)|/c/(?<chapter_id>\\d+)|/v/(?<video_id>\\d+))?#"
+-			),
+-			'twitter' => array(
+-				"@twitter\\.com/(?:#!/)?\\w+/status(?:es)?/(?<id>\\d+)@",
+-			),
+-			'vimeo' => array(
+-				'!vimeo\\.com/(?:channels/[^/]+/|video/)?(?<id>\\d+)!',
+-			),
+-			'youtube' => array(
+-				"!youtube\\.com/(?:watch.*?v=|v/)(?<id>[-\\w]+)!",
+-				"!youtu\\.be/(?<id>[-\\w]+)!"
+-			)
+-		);
++// //			'googleplus' => array(
++// //				'!//plus\\.google\\.com/(?:u/\\d+/)?(?:\\+(?<name>[^/]+)|(?<oid>\\d+))/posts/(?<pid>\\w+)!'
++// //			),
++// 			'soundcloud' => array(
++// 				'@api\\.soundcloud\\.com/playlists/(?<playlist_id>\\d+)@',
++// 				'@api\\.soundcloud\\.com/tracks/(?<track_id>\\d+)(?:\\?secret_token=(?<secret_token>[-\\w]+))?@',
++// 				'@soundcloud\\.com/(?!playlists|tracks)[-\\w]+/[-\\w]+/(?=s-)(?<secret_token>[-\\w]+)@'
++// 			),
++// 			'medium' => array(
++// 				"!medium\\.com/[^/]*/(?:[-\\w]+-)?(?'id'[\\da-f]+)!"
++// 			),
++// 			'twitch' => array(
++// 				"#twitch\\.tv/(?<channel>(?!m/)\\w+)(?:/b/(?<archive_id>\\d+)|/c/(?<chapter_id>\\d+)|/v/(?<video_id>\\d+))?#"
++// 			),
++// 			'twitter' => array(
++// 				"@twitter\\.com/(?:#!/)?\\w+/status(?:es)?/(?<id>\\d+)@",
++// 			),
++// 			'vimeo' => array(
++// 				'!vimeo\\.com/(?:channels/[^/]+/|video/)?(?<id>\\d+)!',
++// 			),
++// 			'youtube' => array(
++// 				"!youtube\\.com/(?:watch.*?v=|v/)(?<id>[-\\w]+)!",
++// 				"!youtu\\.be/(?<id>[-\\w]+)!"
++// 			)
++// 		);
+ 
+-		foreach ($regexps as $embed => $siteRegexps)
+-		{
+-			$attributes = array();
+-			foreach ($siteRegexps as $regexp)
+-			{
+-				$attributes += $this->extractAttributes($url, $regexp);
+-			}
+-			if (!empty($attributes))
+-			{
+-				(isset($attributes['channel'])) ? $attributes['id'] = $attributes['channel'] : null;
+-				return array('embed' => $embed, 'attributes' => $attributes);
+-			}
+-		}
++// 		foreach ($regexps as $embed => $siteRegexps)
++// 		{
++// 			$attributes = array();
++// 			foreach ($siteRegexps as $regexp)
++// 			{
++// 				$attributes += $this->extractAttributes($url, $regexp);
++// 			}
++// 			if (!empty($attributes))
++// 			{
++// 				(isset($attributes['channel'])) ? $attributes['id'] = $attributes['channel'] : null;
++// 				return array('embed' => $embed, 'attributes' => $attributes);
++// 			}
++// 		}
+ 
+-		return false;
+-	}
++// 		return false;
++// 	}
+ 
+ 
+-	protected function extractAttributes($url, $regexp)
+-	{
+-		$attributes = array();
+-		if (preg_match($regexp, $url, $m))
+-		{
+-			foreach ($m as $k => $v)
+-			{
+-				if (!is_numeric($k) && $v !== '')
+-				{
+-					$attributes[$k] = $v;
+-				}
+-			}
+-		}
++// 	protected function extractAttributes($url, $regexp)
++// 	{
++// 		$attributes = array();
++// 		if (preg_match($regexp, $url, $m))
++// 		{
++// 			foreach ($m as $k => $v)
++// 			{
++// 				if (!is_numeric($k) && $v !== '')
++// 				{
++// 					$attributes[$k] = $v;
++// 				}
++// 			}
++// 		}
+ 
+-		return $attributes;
+-	}
++// 		return $attributes;
++// 	}
+ 
+ 	/**
+ 	 * {@inheritdoc}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/diff_full.tmp"
+new file mode 100644
+index 000000000..c02834eda
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/diff_full.tmp"
+@@ -0,0 +1,430 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/acp/bbfront_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/acp/bbfront_module.php"
++index 96a60d75d..816277b15 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/acp/bbfront_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/acp/bbfront_module.php"
++@@ -52,7 +52,7 @@ class bbfront_module
++ 	
++ 				$this->config->set('bbfront_inc_forums', json_encode($this->request->variable('bbfront_inc_forums', array(0))));
++ 				$this->config->set('bbfront_inc_groups', json_encode($this->request->variable('bbfront_inc_groups', array(0))));
++-				$this->config->set('bbfront_settings', json_encode($this->request->variable('bbfront_settings', array('' => ''))));
+++				$this->config->set('bbfront_settings', json_encode($this->request->variable('bbfront_settings', array('' => ''), true)));
++ 				$this->config->set('sitesplat_bbfront_grid_layout', $this->request->variable('bbfront_grid_layout', '4-l'));
++ 				$this->config->set('sitesplat_bbfront_grid_fx_first', $this->request->variable('bbfront_grid_fx_first', 'Hapi'));
++ 				$this->config->set('sitesplat_bbfront_grid_fx_load', $this->request->variable('bbfront_grid_fx_load', 'Hapi'));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/controller/main.php"
++index c8aeb7d94..9f739625e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/controller/main.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/controller/main.php"
++@@ -201,8 +201,23 @@ class main
++ 					$this->db->sql_freeresult($result1);
++ 				}
++ 
++-				preg_match('/\[quote(.*?)](.*?)\[\/quote(.*?)\]/msi', $row['post_text'], $quote);
+++				$topicimage = '';
+++
+++				if(!$attach_id) {
+++					preg_match('#\[img\](http.*?\.[jpgn]{3})\[\/img\]#', $row['post_text'], $topicimage);
+++					$row['post_text'] = (isset($topicimage[0])) ? str_replace($topicimage[0], '', $row['post_text']) : $row['post_text'];
+++					preg_match('/\<IMG(.*?)\>(.*?)\<\/IMG\>/msi', $row['post_text'], $topicimage);
+++					$row['post_text'] = (isset($topicimage[0])) ? str_replace($topicimage[0], '', $row['post_text']) : $row['post_text'];
+++				}
+++
+++				$row['post_text'] = preg_replace('#\[((?!quoting)[^]])*\]#', '', $row['post_text']);
+++				preg_match('/\[quoting=?(.*?)](.*?)\[\/quoting(.*?)\]/msi', $row['post_text'], $quote);
++ 				$row['post_text'] = (isset($quote[2])) ? $quote[2] : $row['post_text'];
+++				$row['post_text'] = htmlspecialchars_decode($row['post_text']);
+++				$row['post_text'] = str_replace("&", "&amp;", $row['post_text']);
+++
+++				// $attributes = (!isset($quote[2])) ? $this->matchUrl($row['post_text']) : null;
+++
++ 				$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
++ 
++ 				// support for phpbb-mediaembed 2.0+ - comment out if using BBembed
++@@ -211,23 +226,32 @@ class main
++ 				if (preg_match('`<span data\-s9e\-mediaembed\="(.*?)"(.*?)</span>`', $rendered_post, $media)) {
++ 					$medium = $media[1];
++ 					$video = "<span data-s9e-mediaembed=\"$medium\"{$media[2]}</span></span>";
++-				}
++-				else if (preg_match('`<([a-z]+) data\-s9e\-mediaembed\="(.*?)"(.*?)</\\1>`', $rendered_post, $media)) {
+++				} else if (preg_match('`<([a-z]+) data\-s9e\-mediaembed\="(.*?)"(.*?)</\\1>`', $rendered_post, $media)) {
++ 					$medium = $media[2];
++ 					$video = "<{$media[1]} data-s9e-mediaembed=\"$medium\"{$media[3]}</{$media[1]}>";
++ 				}
++ 
+++				$res = 0;
+++				if(!empty($quote[1])) {
+++					$res = strpos($quote[1], ' ', strpos($quote[1], ' ', 0) + 1);
+++				}
+++				$user_quote = !empty($quote) ? rtrim(trim( substr( $quote[1], $res ) ), '"') : "";
+++				$text_truncated = truncate_string(strip_tags($rendered_post), $config_aray['chars'], $config_aray['chars'], true, " ...");
+++				$topicimage = preg_replace('/\s+src=\"(.+)\"/', '$1', $topicimage[1]);
+++
++ 				$tpl_ary = array(
++ 					'URL'		=> append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'] . '#p' . $row['post_id']),
++ 					'TITLE'		=> $row['post_subject'],
+++					'TEXT'		=> $text_truncated,
++ 					'QUOTE'		=> (isset($quote[2])) ? true: false,
++-					'PICTURE'	=> (!$attach_id) ? '' : generate_board_url() . '/download/file.php?id=' . $attach_id,
++-					'TEXT'		=> truncate_string(strip_tags($rendered_post), $config_aray['chars'], $config_aray['chars'], true, " ..."),
+++					'PICTURE'	=> (!$attach_id) ? $topicimage : generate_board_url() . '/download/file.php?id=' . $attach_id,
+++					// 'EMBED' => !empty($attributes['embed']) ? $attributes['embed'] : '',
++ 					'VIDEO'		=> $video,
++ 					'MEDIUM'	=> $medium,
++-
++ 					'AUTHOR'	=> get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour']),
++-					'USER_QUOTE'=> get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour']),
+++					'AUTHOR_CLEAN' => strtolower(get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour'])),
+++					'USER_QUOTE' => $user_quote,
+++					'USER_CLEAN' => strtolower($user_quote),
++ 					'AVATAR'	=> ($config_aray['use_avatar']) ? phpbb_get_user_avatar(array('avatar' => $row['user_avatar'],
++ 										  'user_id'         => $row['user_id'],
++ 										  'avatar_type'		=> $row['user_avatar_type'],
++@@ -275,7 +299,7 @@ class main
++ 
++ 			$bbfront_url = $this->helper->route('sitesplat_bbfront_controller', array('name' => $config_aray['name']));
++ 			$this->template->assign_vars(array(
++-				'BBBFRONT_START' => (!$start) ? true : false,
+++				'BBBFRONT_START' => (!$start) ? true : false, 
++ 				'BBFRONT_END'	=> $start + $per_page >= $total,
++ 				'U_BBBFRONT_NEXT' => strpos($bbfront_url, '?') === false ? $bbfront_url . '?fstart=' . ($start + $per_page) : $bbfront_url . '&fstart=' . ($start + $per_page),
++ 				'BBFRONT_GRID_LAYOUT'	=> $this->config['sitesplat_bbfront_grid_layout'],
++@@ -290,78 +314,78 @@ class main
++ 	}
++ 
++ // comment out the next two functions when enabling phpbb-mediaembed!!!
++-	protected function matchUrl($url)
++-	{
++-		if (!$this->phpbb_container->get('ext.manager')->is_enabled('sitesplat/bbembed'))
++-		{
++-			return false;
++-		}
++-
++-		$regexps = array(
++-		    'facebook' => array(
++-				"@/(?!(?:apps|developers|graph)\\.)[-\\w.]*facebook\\.com/(?:[/\\w]+/permalink|(?!pages/|groups/).*?)(?:/|fbid=|\\?v=)(?<id>\\d+)(?![^/?&#])@",
++-				"#/(?<type>video)s?/#"
++-			),
++-//			'googleplus' => array(
++-//				'!//plus\\.google\\.com/(?:u/\\d+/)?(?:\\+(?<name>[^/]+)|(?<oid>\\d+))/posts/(?<pid>\\w+)!'
++-//			),
++-			'soundcloud' => array(
++-				'@api\\.soundcloud\\.com/playlists/(?<playlist_id>\\d+)@',
++-				'@api\\.soundcloud\\.com/tracks/(?<track_id>\\d+)(?:\\?secret_token=(?<secret_token>[-\\w]+))?@',
++-				'@soundcloud\\.com/(?!playlists|tracks)[-\\w]+/[-\\w]+/(?=s-)(?<secret_token>[-\\w]+)@'
++-			),
++-			'medium' => array(
++-				"!medium\\.com/[^/]*/(?:[-\\w]+-)?(?'id'[\\da-f]+)!"
++-			),
++-			'twitch' => array(
++-				"#twitch\\.tv/(?<channel>(?!m/)\\w+)(?:/b/(?<archive_id>\\d+)|/c/(?<chapter_id>\\d+)|/v/(?<video_id>\\d+))?#"
++-			),
++-			'twitter' => array(
++-				"@twitter\\.com/(?:#!/)?\\w+/status(?:es)?/(?<id>\\d+)@",
++-			),
++-			'vimeo' => array(
++-				'!vimeo\\.com/(?:channels/[^/]+/|video/)?(?<id>\\d+)!',
++-			),
++-			'youtube' => array(
++-				"!youtube\\.com/(?:watch.*?v=|v/)(?<id>[-\\w]+)!",
++-				"!youtu\\.be/(?<id>[-\\w]+)!"
++-			)
++-		);
++-
++-		foreach ($regexps as $embed => $siteRegexps)
++-		{
++-			$attributes = array();
++-			foreach ($siteRegexps as $regexp)
++-			{
++-				$attributes += $this->extractAttributes($url, $regexp);
++-			}
++-			if (!empty($attributes))
++-			{
++-				(isset($attributes['channel'])) ? $attributes['id'] = $attributes['channel'] : null;
++-				return array('embed' => $embed, 'attributes' => $attributes);
++-			}
++-		}
++-
++-		return false;
++-	}
++-
++-
++-	protected function extractAttributes($url, $regexp)
++-	{
++-		$attributes = array();
++-		if (preg_match($regexp, $url, $m))
++-		{
++-			foreach ($m as $k => $v)
++-			{
++-				if (!is_numeric($k) && $v !== '')
++-				{
++-					$attributes[$k] = $v;
++-				}
++-			}
++-		}
++-
++-		return $attributes;
++-	}
+++// 	protected function matchUrl($url)
+++// 	{
+++// 		if (!$this->phpbb_container->get('ext.manager')->is_enabled('sitesplat/bbembed'))
+++// 		{
+++// 			return false;	
+++// 		}
+++		
+++// 		$regexps = array(
+++// 		    'facebook' => array(
+++// 				"@/(?!(?:apps|developers|graph)\\.)[-\\w.]*facebook\\.com/(?:[/\\w]+/permalink|(?!pages/|groups/).*?)(?:/|fbid=|\\?v=)(?<id>\\d+)(?![^/?&#])@",
+++// 				"#/(?<type>video)s?/#"
+++// 			),
+++// //			'googleplus' => array(
+++// //				'!//plus\\.google\\.com/(?:u/\\d+/)?(?:\\+(?<name>[^/]+)|(?<oid>\\d+))/posts/(?<pid>\\w+)!'
+++// //			),
+++// 			'soundcloud' => array(
+++// 				'@api\\.soundcloud\\.com/playlists/(?<playlist_id>\\d+)@',
+++// 				'@api\\.soundcloud\\.com/tracks/(?<track_id>\\d+)(?:\\?secret_token=(?<secret_token>[-\\w]+))?@',
+++// 				'@soundcloud\\.com/(?!playlists|tracks)[-\\w]+/[-\\w]+/(?=s-)(?<secret_token>[-\\w]+)@'
+++// 			),
+++// 			'medium' => array(
+++// 				"!medium\\.com/[^/]*/(?:[-\\w]+-)?(?'id'[\\da-f]+)!"
+++// 			),
+++// 			'twitch' => array(
+++// 				"#twitch\\.tv/(?<channel>(?!m/)\\w+)(?:/b/(?<archive_id>\\d+)|/c/(?<chapter_id>\\d+)|/v/(?<video_id>\\d+))?#"
+++// 			),
+++// 			'twitter' => array(
+++// 				"@twitter\\.com/(?:#!/)?\\w+/status(?:es)?/(?<id>\\d+)@",
+++// 			),
+++// 			'vimeo' => array(
+++// 				'!vimeo\\.com/(?:channels/[^/]+/|video/)?(?<id>\\d+)!',
+++// 			),
+++// 			'youtube' => array(
+++// 				"!youtube\\.com/(?:watch.*?v=|v/)(?<id>[-\\w]+)!",
+++// 				"!youtu\\.be/(?<id>[-\\w]+)!"
+++// 			)
+++// 		);
+++
+++// 		foreach ($regexps as $embed => $siteRegexps)
+++// 		{
+++// 			$attributes = array();
+++// 			foreach ($siteRegexps as $regexp)
+++// 			{
+++// 				$attributes += $this->extractAttributes($url, $regexp);
+++// 			}
+++// 			if (!empty($attributes))
+++// 			{
+++// 				(isset($attributes['channel'])) ? $attributes['id'] = $attributes['channel'] : null;
+++// 				return array('embed' => $embed, 'attributes' => $attributes);
+++// 			}
+++// 		}
+++
+++// 		return false;
+++// 	}
+++
+++
+++// 	protected function extractAttributes($url, $regexp)
+++// 	{
+++// 		$attributes = array();
+++// 		if (preg_match($regexp, $url, $m))
+++// 		{
+++// 			foreach ($m as $k => $v)
+++// 			{
+++// 				if (!is_numeric($k) && $v !== '')
+++// 				{
+++// 					$attributes[$k] = $v;
+++// 				}
+++// 			}
+++// 		}
+++
+++// 		return $attributes;
+++// 	}
++ 
++ 	/**
++ 	 * {@inheritdoc}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/diff_full.tmp"
++new file mode 100644
++index 000000000..a9a4d07ab
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/diff_full.tmp"
++@@ -0,0 +1,154 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/acp/bbfront_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/acp/bbfront_module.php"
+++index 96a60d75d..816277b15 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/acp/bbfront_module.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/acp/bbfront_module.php"
+++@@ -52,7 +52,7 @@ class bbfront_module
+++ 	
+++ 				$this->config->set('bbfront_inc_forums', json_encode($this->request->variable('bbfront_inc_forums', array(0))));
+++ 				$this->config->set('bbfront_inc_groups', json_encode($this->request->variable('bbfront_inc_groups', array(0))));
+++-				$this->config->set('bbfront_settings', json_encode($this->request->variable('bbfront_settings', array('' => ''))));
++++				$this->config->set('bbfront_settings', json_encode($this->request->variable('bbfront_settings', array('' => ''), true)));
+++ 				$this->config->set('sitesplat_bbfront_grid_layout', $this->request->variable('bbfront_grid_layout', '4-l'));
+++ 				$this->config->set('sitesplat_bbfront_grid_fx_first', $this->request->variable('bbfront_grid_fx_first', 'Hapi'));
+++ 				$this->config->set('sitesplat_bbfront_grid_fx_load', $this->request->variable('bbfront_grid_fx_load', 'Hapi'));
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/controller/main.php"
+++index c8aeb7d94..9f739625e 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/controller/main.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/controller/main.php"
+++@@ -201,8 +201,23 @@ class main
+++ 					$this->db->sql_freeresult($result1);
+++ 				}
+++ 
+++-				preg_match('/\[quote(.*?)](.*?)\[\/quote(.*?)\]/msi', $row['post_text'], $quote);
++++				$topicimage = '';
++++
++++				if(!$attach_id) {
++++					preg_match('#\[img\](http.*?\.[jpgn]{3})\[\/img\]#', $row['post_text'], $topicimage);
++++					$row['post_text'] = (isset($topicimage[0])) ? str_replace($topicimage[0], '', $row['post_text']) : $row['post_text'];
++++					preg_match('/\<IMG(.*?)\>(.*?)\<\/IMG\>/msi', $row['post_text'], $topicimage);
++++					$row['post_text'] = (isset($topicimage[0])) ? str_replace($topicimage[0], '', $row['post_text']) : $row['post_text'];
++++				}
++++
++++				$row['post_text'] = preg_replace('#\[((?!quoting)[^]])*\]#', '', $row['post_text']);
++++				preg_match('/\[quoting=?(.*?)](.*?)\[\/quoting(.*?)\]/msi', $row['post_text'], $quote);
+++ 				$row['post_text'] = (isset($quote[2])) ? $quote[2] : $row['post_text'];
++++				$row['post_text'] = htmlspecialchars_decode($row['post_text']);
++++				$row['post_text'] = str_replace("&", "&amp;", $row['post_text']);
++++
++++				// $attributes = (!isset($quote[2])) ? $this->matchUrl($row['post_text']) : null;
++++
+++ 				$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
+++ 
+++ 				// support for phpbb-mediaembed 2.0+ - comment out if using BBembed
+++@@ -211,23 +226,32 @@ class main
+++ 				if (preg_match('`<span data\-s9e\-mediaembed\="(.*?)"(.*?)</span>`', $rendered_post, $media)) {
+++ 					$medium = $media[1];
+++ 					$video = "<span data-s9e-mediaembed=\"$medium\"{$media[2]}</span></span>";
+++-				}
+++-				else if (preg_match('`<([a-z]+) data\-s9e\-mediaembed\="(.*?)"(.*?)</\\1>`', $rendered_post, $media)) {
++++				} else if (preg_match('`<([a-z]+) data\-s9e\-mediaembed\="(.*?)"(.*?)</\\1>`', $rendered_post, $media)) {
+++ 					$medium = $media[2];
+++ 					$video = "<{$media[1]} data-s9e-mediaembed=\"$medium\"{$media[3]}</{$media[1]}>";
+++ 				}
+++ 
++++				$res = 0;
++++				if(!empty($quote[1])) {
++++					$res = strpos($quote[1], ' ', strpos($quote[1], ' ', 0) + 1);
++++				}
++++				$user_quote = !empty($quote) ? rtrim(trim( substr( $quote[1], $res ) ), '"') : "";
++++				$text_truncated = truncate_string(strip_tags($rendered_post), $config_aray['chars'], $config_aray['chars'], true, " ...");
++++				$topicimage = preg_replace('/\s+src=\"(.+)\"/', '$1', $topicimage[1]);
++++
+++ 				$tpl_ary = array(
+++ 					'URL'		=> append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'] . '#p' . $row['post_id']),
+++ 					'TITLE'		=> $row['post_subject'],
++++					'TEXT'		=> $text_truncated,
+++ 					'QUOTE'		=> (isset($quote[2])) ? true: false,
+++-					'PICTURE'	=> (!$attach_id) ? '' : generate_board_url() . '/download/file.php?id=' . $attach_id,
+++-					'TEXT'		=> truncate_string(strip_tags($rendered_post), $config_aray['chars'], $config_aray['chars'], true, " ..."),
++++					'PICTURE'	=> (!$attach_id) ? $topicimage : generate_board_url() . '/download/file.php?id=' . $attach_id,
++++					// 'EMBED' => !empty($attributes['embed']) ? $attributes['embed'] : '',
+++ 					'VIDEO'		=> $video,
+++ 					'MEDIUM'	=> $medium,
+++-
+++ 					'AUTHOR'	=> get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour']),
+++-					'USER_QUOTE'=> get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour']),
++++					'AUTHOR_CLEAN' => strtolower(get_username_string('username', $row['poster_id'], $row['username'], $row['user_colour'])),
++++					'USER_QUOTE' => $user_quote,
++++					'USER_CLEAN' => strtolower($user_quote),
+++ 					'AVATAR'	=> ($config_aray['use_avatar']) ? phpbb_get_user_avatar(array('avatar' => $row['user_avatar'],
+++ 										  'user_id'         => $row['user_id'],
+++ 										  'avatar_type'		=> $row['user_avatar_type'],
+++@@ -275,7 +299,7 @@ class main
+++ 
+++ 			$bbfront_url = $this->helper->route('sitesplat_bbfront_controller', array('name' => $config_aray['name']));
+++ 			$this->template->assign_vars(array(
+++-				'BBBFRONT_START' => (!$start) ? true : false,
++++				'BBBFRONT_START' => (!$start) ? true : false, 
+++ 				'BBFRONT_END'	=> $start + $per_page >= $total,
+++ 				'U_BBBFRONT_NEXT' => strpos($bbfront_url, '?') === false ? $bbfront_url . '?fstart=' . ($start + $per_page) : $bbfront_url . '&fstart=' . ($start + $per_page),
+++ 				'BBFRONT_GRID_LAYOUT'	=> $this->config['sitesplat_bbfront_grid_layout'],
+++@@ -290,78 +314,78 @@ class main
+++ 	}
+++ 
+++ // comment out the next two functions when enabling phpbb-mediaembed!!!
+++-	protected function matchUrl($url)
+++-	{
+++-		if (!$this->phpbb_container->get('ext.manager')->is_enabled('sitesplat/bbembed'))
+++-		{
+++-			return false;
+++-		}
+++-
+++-		$regexps = array(
+++-		    'facebook' => array(
+++-				"@/(?!(?:apps|developers|graph)\\.)[-\\w.]*facebook\\.com/(?:[/\\w]+/permalink|(?!pages/|groups/).*?)(?:/|fbid=|\\?v=)(?<id>\\d+)(?![^/?&#])@",
+++-				"#/(?<type>video)s?/#"
+++-			),
+++-//			'googleplus' => array(
+++-//				'!//plus\\.google\\.com/(?:u/\\d+/)?(?:\\+(?<name>[^/]+)|(?<oid>\\d+))/posts/(?<pid>\\w+)!'
+++-//			),
+++-			'soundcloud' => array(
+++-				'@api\\.soundcloud\\.com/playlists/(?<playlist_id>\\d+)@',
+++-				'@api\\.soundcloud\\.com/tracks/(?<track_id>\\d+)(?:\\?secret_token=(?<secret_token>[-\\w]+))?@',
+++-				'@soundcloud\\.com/(?!playlists|tracks)[-\\w]+/[-\\w]+/(?=s-)(?<secret_token>[-\\w]+)@'
+++-			),
+++-			'medium' => array(
+++-				"!medium\\.com/[^/]*/(?:[-\\w]+-)?(?'id'[\\da-f]+)!"
+++-			),
+++-			'twitch' => array(
+++-				"#twitch\\.tv/(?<channel>(?!m/)\\w+)(?:/b/(?<archive_id>\\d+)|/c/(?<chapter_id>\\d+)|/v/(?<video_id>\\d+))?#"
+++-			),
+++-			'twitter' => array(
+++-				"@twitter\\.com/(?:#!/)?\\w+/status(?:es)?/(?<id>\\d+)@",
+++-			),
+++-			'vimeo' => array(
+++-				'!vimeo\\.com/(?:channels/[^/]+/|video/)?(?<id>\\d+)!',
+++-			),
+++-			'youtube' => array(
+++-				"!youtube\\.com/(?:watch.*?v=|v/)(?<id>[-\\w]+)!",
+++-				"!youtu\\.be/(?<id>[-\\w]+)!"
+++-			)
+++-		);
+++-
+++-		foreach ($regexps as $embed => $siteRegexps)
+++-		{
+++-			$attributes = array();
+++-			foreach ($siteRegexps as $regexp)
+++-			{
+++-				$attributes += $this->extractAttributes($url, $regexp);
+++-			}
+++-			if (!empty($attributes))
+++-			{
+++-				(isset($attributes['channel'])) ? $attributes['id'] = $attributes['channel'] : null;
+++-				return array('embed' => $embed, 'attributes' => $attributes);
+++-			}
+++-		}
+++-
+++-		return false;
+++-	}
+++-
+++-
+++-	protected function extractAttributes($url, $regexp)
+++-	{
+++-		$attributes = array();
+++-		if (preg_match($r
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/bbfront.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/bbfront.html"
++index 7216e7f87..519a60e3a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/bbfront.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/bbfront.html"
++@@ -16,10 +16,13 @@
++ 		<div class="blog-item{% if item.QUOTE %} blog-quote{% endif %}" style="opacity: 0;">
++ 			{% if item.PICTURE %}
++ 				<div class="blog-img"><img src="{{ item.PICTURE }}" class="img-responsive" alt="" /></div>
+++				{% if item.QUOTE %}
+++					<div class="quote quote-primary"><a href="{{ item.URL }}">{{ item.TEXT }}{% if item.USER_CLEAN neq item.AUTHOR_CLEAN and item.USER_QUOTE %}<small class="quote-author">&#45;&nbsp;{{ item.USER_QUOTE }}</small>{% endif %}</a></div>
+++				{% endif %}
++ 			{% elseif item.VIDEO %}
++ 				<div class="blog-video {{ item.MEDIUM }}-front">{{ item.VIDEO }}</div>
++ 			{% elseif item.QUOTE %}
++-				<div class="quote quote-primary"><a href="{{ item.URL }}">{{ item.TEXT }}<small class="quote-author">&#45;&nbsp;{{ item.USER_QUOTE }}</small></a></div>
+++				<div class="quote quote-primary"><a href="{{ item.URL }}">{{ item.TEXT }}{% if item.USER_CLEAN neq item.AUTHOR_CLEAN %}<small class="quote-author">&#45;&nbsp;{{ item.USER_QUOTE }}</small>{% endif %}</a></div>
++ 			{% endif %}
++ 
++ 			<div class="blog-details content">
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
++index 4dd548d9b..866b52ce3 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbfront/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
++@@ -1 +1 @@
++-<li {$MICRODATA}><a class="bbfront-link" href="{U_BBFRON
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bbfront/styles/FLATBOOTS/template/bbfront.html" "[FORUM_EXT]/sitesplat\\bbfront/styles/FLATBOOTS/template/bbfront.html"
--- "[ORIGINAL]/sitesplat\\bbfront/styles/FLATBOOTS/template/bbfront.html"
+++ "[FORUM_EXT]/sitesplat\\bbfront/styles/FLATBOOTS/template/bbfront.html"
@@ -16,10 +16,13 @@
 		<div class="blog-item{% if item.QUOTE %} blog-quote{% endif %}" style="opacity: 0;">
 			{% if item.PICTURE %}
 				<div class="blog-img"><img src="{{ item.PICTURE }}" class="img-responsive" alt="" /></div>
+				{% if item.QUOTE %}
+					<div class="quote quote-primary"><a href="{{ item.URL }}">{{ item.TEXT }}{% if item.USER_CLEAN neq item.AUTHOR_CLEAN and item.USER_QUOTE %}<small class="quote-author">&#45;&nbsp;{{ item.USER_QUOTE }}</small>{% endif %}</a></div>
+				{% endif %}
 			{% elseif item.VIDEO %}
 				<div class="blog-video {{ item.MEDIUM }}-front">{{ item.VIDEO }}</div>
 			{% elseif item.QUOTE %}
-				<div class="quote quote-primary"><a href="{{ item.URL }}">{{ item.TEXT }}<small class="quote-author">&#45;&nbsp;{{ item.USER_QUOTE }}</small></a></div>
+				<div class="quote quote-primary"><a href="{{ item.URL }}">{{ item.TEXT }}{% if item.USER_CLEAN neq item.AUTHOR_CLEAN %}<small class="quote-author">&#45;&nbsp;{{ item.USER_QUOTE }}</small>{% endif %}</a></div>
 			{% endif %}
 
 			<div class="blog-details content">
diff --git "[ORIGINAL]/sitesplat\\bbfront/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html" "[FORUM_EXT]/sitesplat\\bbfront/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
--- "[ORIGINAL]/sitesplat\\bbfront/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
+++ "[FORUM_EXT]/sitesplat\\bbfront/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
@@ -1 +1 @@
-<li {$MICRODATA}><a class="bbfront-link" href="{U_BBFRONT_PAGE}" itemtype="https://schema.org/Thing" itemprop="item"><span itemprop="name">{BBFRONT_PAGE}</span></a><meta itemprop="position" content="0" /></li>
\ No newline at end of file
+<li {{ MICRODATA }}><a class="bbfront-link text-capitalize" href="{{ U_BBFRONT_PAGE }}" itemtype="https://schema.org/Thing" itemprop="item"><span itemprop="name">{{ BBFRONT_PAGE }}</span></a><meta itemprop="position" content="0" /></li>
\ No newline at end of file
```
