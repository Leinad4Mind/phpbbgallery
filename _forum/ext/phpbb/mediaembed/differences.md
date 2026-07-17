Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/phpbb\\mediaembed/CHANGELOG.md" "[FORUM_EXT]/phpbb\\mediaembed/CHANGELOG.md"
--- "[ORIGINAL]/phpbb\\mediaembed/CHANGELOG.md"
+++ "[FORUM_EXT]/phpbb\\mediaembed/CHANGELOG.md"
@@ -1,31 +1,5 @@
 # Changelog
 
-### 2.0.5 - 2026-03-21
-
-- Added and/or updated support for media sites:
-	- Facebook
-	- vk.com
-
-### 2.0.4 - 2025-12-16
-
-- Fixed problems with YouTube not playing videos due to YouTube's referrerer policy.
-- Ensure and future-proof compatibility with phpBB4.
-- Added language packs:
-	- Romanian
-
-### 2.0.3 - 2025-09-20
-
-- Added an amendment to the forum privacy policy regarding how embedded content may affect user privacy.
-- Updated YouTube to use their enhanced privacy feature (no cookies until you play a video).
-- Fixed an issue in the BBCode FAQ media embed example.
-- Fixed issues in the language files.
-- Removed the last traces of old XHTML code.
-- Added and/or updated support for media sites:
-  - Apple Podcasts
-  - Bluesky
-  - Pastebin
-  - x.com (aka Twitter)
-
 ### 2.0.2 - 2024-01-21
 
 - Small QoL improvement in the ACP, added sample placeholder data to the custom max-width field in the content-sizing settings.
@@ -50,9 +24,9 @@
 
 - Backwards incompatible changes require a new minimum phpBB version of 3.3.2.
 - New ACP options for custom content sizing:
-  - Added a new setting to enlarge most embedded content to fit 100% of the width of the post-area.
+  - Added a new setting to enlarge most embedded content to fit 100% of the width of the post area.
   - Added a new setting to define custom maximum widths in pixels or percent for individual sites.
-- Fixed issues for new installations that would fail if any of phpBB's default forum roles were missing.
+- Fixed issues for new installs that would fail if any of phpBB's default forum roles were missing.
 - Added language packs:
   - Portuguese
   - Chinese (traditional)
@@ -110,10 +84,10 @@ on adding and creating new site YAML files for MediaEmbed.
 ### 1.0.2 - 2018-06-25
 
 - Added a global setting to enable or disable the conversion of plain URLs into embedded content.
-- Added a forum-based permission, allowing control over who can post embedded content in specific forums.
-- Added a user-based private messages permission, allowing control over who can post embedded content in their private messages.
+- Added a forum based permission, allowing control over who can post embedded content in specific forums.
+- Added a user based private messages permission, allowing control over who can post embedded content in their private messages.
 - Fixed an issue where embedded content could still be posted by users who did not have permission to use BBCodes in a specific forum.
-- Fixed an issue where embedded content could still be posted even though the Disable BBCode option was checked in the post-editor.
+- Fixed an issue where embedded content could still be posted even though the Disable BBCode option was checked in the post editor.
 - When users disable the option to automatically parse URLs in their post, plain URLs will no longer be converted to embedded content either.
 
 ### 1.0.1 - 2017-08-04
diff --git "[ORIGINAL]/phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html" "[FORUM_EXT]/phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
--- "[ORIGINAL]/phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
+++ "[FORUM_EXT]/phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
@@ -22,7 +22,7 @@
 					<td style="width: 25%;">
 						{% if site %}
 							<label style="font-size: 1em;" title="{{ site.title }}">
-								<input type="checkbox" class="radio" name="mark[]" value="{{ site.id }}"{% if site.disabled %} disabled{% elseif site.enabled %} checked{% endif %}> {{ site.name }}
+								<input type="checkbox" class="radio" name="mark[]" value="{{ site.id }}"{% if site.disabled %} disabled{% elseif site.enabled %} checked{% endif %} /> {{ site.name }}
 							</label>
 						{% endif %}
 					</td>
@@ -38,8 +38,8 @@
 		<p class="small"><a href="#" data-marksites="true">{{ lang('MARK_ALL') }}</a> &bull; <a href="#" data-marksites="false">{{ lang('UNMARK_ALL') }}</a></p>
 	</fieldset>
 	<p id="buttons" class="submit-buttons">
-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
-		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
+		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
 	</p>
 	{{ S_FORM_TOKEN }}
 </form>
diff --git "[ORIGINAL]/phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html" "[FORUM_EXT]/phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
--- "[ORIGINAL]/phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
+++ "[FORUM_EXT]/phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
@@ -8,51 +8,51 @@
 	<fieldset>
 		<legend>{{ lang('ACP_MEDIA_BBCODE_LEGEND') }}</legend>
 		<dl>
-			<dt><label for="media_embed_bbcode">{{ lang('ACP_MEDIA_DISPLAY_BBCODE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN') }}</span></dt>
-			<dd><label><input type="radio" class="radio" name="media_embed_bbcode" id="media_embed_bbcode" value="1" {% if S_MEDIA_EMBED_BBCODE %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
-				<label><input type="radio" class="radio" name="media_embed_bbcode" value="0"{% if not S_MEDIA_EMBED_BBCODE %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+			<dt><label for="media_embed_bbcode">{{ lang('ACP_MEDIA_DISPLAY_BBCODE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN') }}</span></dt>
+			<dd><label><input type="radio" class="radio" name="media_embed_bbcode" id="media_embed_bbcode" value="1" {% if S_MEDIA_EMBED_BBCODE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+				<label><input type="radio" class="radio" name="media_embed_bbcode" value="0"{% if not S_MEDIA_EMBED_BBCODE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
 		</dl>
 	</fieldset>
 	<fieldset>
 		<legend>{{ lang('ACP_MEDIA_OPTIONS_LEGEND') }}</legend>
 		<dl>
-			<dt><label for="media_embed_allow_sig">{{ lang('ACP_MEDIA_ALLOW_SIG') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_ALLOW_SIG_EXPLAIN') }}</span></dt>
-			<dd><label><input type="radio" class="radio" name="media_embed_allow_sig" id="media_embed_allow_sig" value="1" {% if S_MEDIA_EMBED_ALLOW_SIG %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
-				<label><input type="radio" class="radio" name="media_embed_allow_sig" value="0"{% if not S_MEDIA_EMBED_ALLOW_SIG %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+			<dt><label for="media_embed_allow_sig">{{ lang('ACP_MEDIA_ALLOW_SIG') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_ALLOW_SIG_EXPLAIN') }}</span></dt>
+			<dd><label><input type="radio" class="radio" name="media_embed_allow_sig" id="media_embed_allow_sig" value="1" {% if S_MEDIA_EMBED_ALLOW_SIG %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+				<label><input type="radio" class="radio" name="media_embed_allow_sig" value="0"{% if not S_MEDIA_EMBED_ALLOW_SIG %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
 		</dl>
 		<dl>
-			<dt><label for="media_embed_parse_urls">{{ lang('ACP_MEDIA_PARSE_URLS') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_PARSE_URLS_EXPLAIN') }}</span></dt>
-			<dd><label><input type="radio" class="radio" name="media_embed_parse_urls" id="media_embed_parse_urls" value="1" {% if S_MEDIA_EMBED_PARSE_URLS %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
-				<label><input type="radio" class="radio" name="media_embed_parse_urls" value="0"{% if not S_MEDIA_EMBED_PARSE_URLS %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+			<dt><label for="media_embed_parse_urls">{{ lang('ACP_MEDIA_PARSE_URLS') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_PARSE_URLS_EXPLAIN') }}</span></dt>
+			<dd><label><input type="radio" class="radio" name="media_embed_parse_urls" id="media_embed_parse_urls" value="1" {% if S_MEDIA_EMBED_PARSE_URLS %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+				<label><input type="radio" class="radio" name="media_embed_parse_urls" value="0"{% if not S_MEDIA_EMBED_PARSE_URLS %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
 		</dl>
 	</fieldset>
 	<fieldset>
 		<legend>{{ lang('ACP_MEDIA_CACHE_LEGEND') }}</legend>
 		<dl>
-			<dt><label for="media_embed_enable_cache">{{ lang('ACP_MEDIA_ENABLE_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_ENABLE_CACHE_EXPLAIN') }}</span></dt>
-			<dd><label><input type="radio" class="radio" name="media_embed_enable_cache" id="media_embed_enable_cache" value="1" {% if S_MEDIA_EMBED_ENABLE_CACHE %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
-				<label><input type="radio" class="radio" name="media_embed_enable_cache" value="0"{% if not S_MEDIA_EMBED_ENABLE_CACHE %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+			<dt><label for="media_embed_enable_cache">{{ lang('ACP_MEDIA_ENABLE_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_ENABLE_CACHE_EXPLAIN') }}</span></dt>
+			<dd><label><input type="radio" class="radio" name="media_embed_enable_cache" id="media_embed_enable_cache" value="1" {% if S_MEDIA_EMBED_ENABLE_CACHE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+				<label><input type="radio" class="radio" name="media_embed_enable_cache" value="0"{% if not S_MEDIA_EMBED_ENABLE_CACHE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
 		</dl>
 		<dl>
-			<dt><label for="action_purge_cache">{{ lang('ACP_MEDIA_PURGE_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_PURGE_CACHE_EXPLAIN') }}</span></dt>
-			<dd><input class="button2" type="submit" id="action_purge_cache" name="action_purge_cache" value="{{ lang('PURGE_CACHE') }}"></dd>
+			<dt><label for="action_purge_cache">{{ lang('ACP_MEDIA_PURGE_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_PURGE_CACHE_EXPLAIN') }}</span></dt>
+			<dd><input class="button2" type="submit" id="action_purge_cache" name="action_purge_cache" value="{{ lang('PURGE_CACHE') }}" /></dd>
 		</dl>
 	</fieldset>
 	<fieldset>
 		<legend>{{ lang('ACP_MEDIA_WIDTH_LEGEND') }}</legend>
 		<dl>
-			<dt><label for="media_embed_full_width">{{ lang('ACP_MEDIA_FULL_WIDTH') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_FULL_WIDTH_EXPLAIN') }}</span></dt>
-			<dd><label><input type="radio" class="radio" name="media_embed_full_width" id="media_embed_full_width" value="1" {% if S_MEDIA_EMBED_FULL_WIDTH %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
-				<label><input type="radio" class="radio" name="media_embed_full_width" value="0"{% if not S_MEDIA_EMBED_FULL_WIDTH %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+			<dt><label for="media_embed_full_width">{{ lang('ACP_MEDIA_FULL_WIDTH') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_FULL_WIDTH_EXPLAIN') }}</span></dt>
+			<dd><label><input type="radio" class="radio" name="media_embed_full_width" id="media_embed_full_width" value="1" {% if S_MEDIA_EMBED_FULL_WIDTH %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+				<label><input type="radio" class="radio" name="media_embed_full_width" value="0"{% if not S_MEDIA_EMBED_FULL_WIDTH %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
 		</dl>
 		<dl>
-			<dt><label for="media_embed_max_width">{{ lang('ACP_MEDIA_MAX_WIDTH') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_MAX_WIDTH_EXPLAIN') }}</span></dt>
+			<dt><label for="media_embed_max_width">{{ lang('ACP_MEDIA_MAX_WIDTH') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_MAX_WIDTH_EXPLAIN') }}</span></dt>
 			<dd><textarea id="media_embed_max_width" name="media_embed_max_width" rows="8" cols="40" style="width: 50%;" placeholder="twitter:100%&#10;youtube:80%&#10;funnyordie:480px">{{ S_MEDIA_EMBED_MAX_WIDTHS }}</textarea></dd>
 		</dl>
 	</fieldset>
 	<fieldset class="submit-buttons">
-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
-		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
+		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
 		{{ S_FORM_TOKEN }}
 	</fieldset>
 </form>
diff --git "[ORIGINAL]/phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html" "[FORUM_EXT]/phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
--- "[ORIGINAL]/phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
+++ "[FORUM_EXT]/phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
@@ -1,3 +1,3 @@
 {% if S_BBCODE_MEDIA %}
-	<input type="button" class="button2" accesskey="m" name="addmedia" value="Media" style="width: 50px;" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}">
+	<input type="button" class="button2" accesskey="m" name="addmedia" value="Media" style="width: 50px;" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}" />
 {% endif %}
diff --git "[ORIGINAL]/phpbb\\mediaembed/collection/sites/applepodcasts.yml" "[ORIGINAL]/phpbb\\mediaembed/collection/sites/applepodcasts.yml"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/collection/sites/applepodcasts.yml"
+++ /dev/null
@@ -1,25 +0,0 @@
-name: "Apple Podcasts"
-homepage: "https://podcasts.apple.com/"
-host: podcasts.apple.com
-example:
-    - https://podcasts.apple.com/us/podcast/the-office-deep-dive-with-brian-baumgartner/id1550331348
-    - https://podcasts.apple.com/us/podcast/the-office-deep-dive-with-brian-baumgartner/id1550331348?i=1000514199106
-extract:
-    - "@podcasts.apple.com/(?'country'\\w+)/podcast/[-\\w%]*/id(?'podcast_id'\\d+)(?:\\?i=(?'episode_id'\\d+))?@"
-choose:
-    when:
-        test: '@episode_id'
-        iframe:
-            allow: "autoplay *;encrypted-media *"
-            width: "100%"
-            height: "175"
-            max-width: "900"
-            src: "https://embed.podcasts.apple.com/{@country}/podcast/episode/id{@podcast_id}?i={@episode_id}"
-    otherwise:
-        iframe:
-            allow: "autoplay *;encrypted-media *"
-            width: "100%"
-            height: "450"
-            max-width: "900"
-            src: "https://embed.podcasts.apple.com/{@country}/podcast/episode/id{@podcast_id}"
-tags: "podcasts"
diff --git "[ORIGINAL]/phpbb\\mediaembed/collection/sites/bluesky.yml" "[ORIGINAL]/phpbb\\mediaembed/collection/sites/bluesky.yml"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/collection/sites/bluesky.yml"
+++ /dev/null
@@ -1,25 +0,0 @@
-attributes:
-    embedder:
-        filterChain: []
-        required: true
-    url:
-        filterChain: "urldecode"
-        required: true
-example:
-    - "https://bsky.app/profile/bsky.app/post/3kkrqzuydho2v"
-    - "https://bsky.app/profile/bnewbold.net/post/3kxjq2auebs2f"
-extract: "#^https://(?'embedder'[.\\w]+)/oembed.*?url=(?'url'[\\w%.]+)#"
-homepage: "https://bsky.app/"
-host: "bsky.app"
-iframe:
-    data-s9e-livepreview-ignore-attrs: style
-    height: 600
-    onload: "let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])"
-    src: "https://s9e.github.io/iframe/2/bluesky.min.html#<xsl:value-of select=\"@url\"/>#<xsl:value-of select=\"@embedder\"/>"
-    width: 600
-name: "Bluesky"
-scrape:
-    extract: "#https://(?'embedder'[.\\w]+)/oembed.*?url=(?'url'[\\w%.]+)#"
-    match: "#/profile/[^/]+/post/.#"
-source: "https://embed.bsky.app/"
-tags: "social"
diff --git "[ORIGINAL]/phpbb\\mediaembed/collection/sites/facebook.yml" "[ORIGINAL]/phpbb\\mediaembed/collection/sites/facebook.yml"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/collection/sites/facebook.yml"
+++ /dev/null
@@ -1,50 +0,0 @@
-name: Facebook
-homepage: https://www.facebook.com/
-tags: social
-host:
-    - facebook.com
-    - fb.watch
-example:
-    - https://www.facebook.com/MetaforDevelopers/posts/451016937058647
-    - https://www.facebook.com/watch/?v=224353158889229
-    - https://fb.watch/3zYsXdnxjf/
-    - https://www.facebook.com/reel/873906321076441
-extract:
-    - "@facebook.com/.*?(?:fbid=|/permalink/|\\?v=)(?'id'\\d+)@"
-    - "@facebook.com/(?'user'[.\\w]+)/(?'type'[pv])(?:ost|ideo)s?/(?:[-%.\\w]+/)?(?'id'\\d+)\\b@"
-    - "@facebook.com/video/(?=post|video)(?'type'[pv])@"
-    - "@facebook.com/events/(?'id'\\d+)\\b(?!/permalink)@"
-    - "@facebook.com/watch/?(?'type'[pv])=@"
-    - "@facebook.com/groups/[^/]*/(?'type'p)osts/(?'id'\\d+)@"
-    - "@facebook.com/(?'user'[.\\w]+)/posts/pfbid(?'pfbid'\\w+)@"
-    - "@facebook.com/permalink.php?story_fbid=(?:(?'id'\\d+)|pfbid(?'pfbid'\\w+))&id=(?'page_id'\\d+)@"
-    - "@facebook.com/(?'type'r)eel/(?'id'\\d+)@"
-scrape:
-    - extract: "@facebook.com/(?'user'[.\\w]+)/(?'type'[pv])\\w+/(?'id'\\d+)(?!\\w)@"
-      header: "User-agent: PHP (not Mozilla)"
-      match: "@facebook.com/[.\\w]+/posts/pfbid@"
-      url: https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2F{@user}%2Fposts%2Fpfbid{@pfbid}
-    - extract: "@story_fbid=(?'id'\\d+)@"
-      header: "User-agent: PHP (not Mozilla)"
-      match: "@facebook.com/permalink.php?story_fbid=pfbid(?'pfbid'\\w+)&id=(?'page_id'\\d+)@"
-      url: https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fpermalink.php%3Fstory_fbid%3Dpfbid{@pfbid}%26id%3D{@page_id}
-    - extract:
-        - "@facebook.com/watch/?(?'type'v)=(?'id'\\d+)@"
-        - "@facebook.com/(?'user'[.\\w]+)/(?'type'v)ideos/(?'id'\\d+)@"
-      header: "User-agent: PHP (not Mozilla)"
-      match: "@fb.watch/.@"
-    - extract:
-        - "@facebook.com/\\w+/(?'user'[.\\w]+)/permalink/(?'id'\\d+)(?!\\w)@"
-        - "@og:url[^>]+facebook.com/(?'user'[.\\w]+)/(?'type'[pv])(?:ost|ideo)s?/(?:[-\\w%]+/)?(?'id'\\d+)\\b@"
-      header: "User-agent: PHP (not Mozilla)"
-      match: "@facebook.com/share/[pv]/\\w@"
-iframe:
-    data-s9e-livepreview-ignore-attrs: style
-    onload: let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])
-    src: https://s9e.github.io/iframe/2/facebook.min.html#<xsl:choose><xsl:when test="@user"><xsl:value-of select="@user"/>/<xsl:choose><xsl:when test="@type='r'or@type='v'">video</xsl:when><xsl:otherwise>post</xsl:otherwise></xsl:choose>s/<xsl:choose><xsl:when test="@id"><xsl:value-of select="@id"/></xsl:when><xsl:otherwise>pfbid<xsl:value-of select="@pfbid"/></xsl:otherwise></xsl:choose></xsl:when><xsl:when test="@id"><xsl:value-of select="@type"/><xsl:value-of select="@id"/></xsl:when><xsl:otherwise>pfbid<xsl:value-of select="@pfbid"/></xsl:otherwise></xsl:choose>
-amp:
-    custom-element: "amp-facebook"
-    src: "https://cdn.ampproject.org/v0/amp-facebook-0.1.js"
-    template: <amp-facebook layout="responsive" width="640" height="360"><xsl:if test="starts-with(@type,'v')"><xsl:attribute name="data-embed-as">video</xsl:attribute></xsl:if><xsl:attribute name="data-href">https://www.facebook.com/<xsl:choose><xsl:when test="@user"><xsl:value-of select="@user"/></xsl:when><xsl:otherwise>user</xsl:otherwise></xsl:choose>/<xsl:choose><xsl:when test="starts-with(@type,'v')">video</xsl:when><xsl:otherwise>post</xsl:otherwise></xsl:choose>s/<xsl:value-of select="@id"/></xsl:attribute></amp-facebook>
-attributes: []
-tracking_policy: https://www.facebook.com/help/1896641480634370
diff --git "[ORIGINAL]/phpbb\\mediaembed/collection/sites/pastebin.yml" "[ORIGINAL]/phpbb\\mediaembed/collection/sites/pastebin.yml"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/collection/sites/pastebin.yml"
+++ /dev/null
@@ -1,12 +0,0 @@
-name: Pastebin
-host: pastebin.com
-example:
-    - "https://pastebin.com/9jEf44nc"
-    - "https://pastebin.com/9jEf44nc?theme=dark"
-extract: "#pastebin\\.com/(?!u/)(?:\\w+(?:\\.php\\?i=|/))?(?'id'\\w+)(?'dark'\\?theme=dark)?#"
-iframe:
-    scrolling: "yes"
-    width: "100%"
-    height: "300"
-    style: ["border:none;resize:vertical;width:100%"]
-    src: //pastebin.com/embed_iframe/{@id}{@dark}
diff --git "[ORIGINAL]/phpbb\\mediaembed/collection/sites/twitter.yml" "[FORUM_EXT]/phpbb\\mediaembed/collection/sites/twitter.yml"
--- "[ORIGINAL]/phpbb\\mediaembed/collection/sites/twitter.yml"
+++ "[FORUM_EXT]/phpbb\\mediaembed/collection/sites/twitter.yml"
@@ -14,10 +14,6 @@ iframe:
     data-s9e-livepreview-ignore-attrs: "style"
     onload: "let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])"
     width: "550"
-    height: "350"
+    height: "273"
     allow: "autoplay *"
-    src: https://s9e.github.io/iframe/2/twitter.min.html#<xsl:value-of select="@id"/><xsl:if test="$MEDIAEMBED_THEME">#theme=<xsl:value-of select="$MEDIAEMBED_THEME"/></xsl:if>
-amp:
-    custom-element: amp-twitter
-    src: https://cdn.ampproject.org/v0/amp-twitter-0.1.js
-    template: '<amp-twitter layout="responsive" width="550" height="273" data-tweetid="{@id}"><blockquote placeholder=""><a href="https://twitter.com/user/status/{@id}">X</a></blockquote></amp-twitter>'
+    src: https://s9e.github.io/iframe/2/twitter.min.html#<xsl:value-of select="@id"/><xsl:if test="$MEDIAEMBED_THEME='dark'">#theme=dark</xsl:if>
diff --git "[ORIGINAL]/phpbb\\mediaembed/collection/sites/vk.yml" "[ORIGINAL]/phpbb\\mediaembed/collection/sites/vk.yml"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/collection/sites/vk.yml"
+++ /dev/null
@@ -1,30 +0,0 @@
-name: "VK"
-homepage: "https://vk.com/"
-tags: ".ru"
-host:
-    - "vk.com"
-    - "vkontakte.ru"
-    - "vkvideo.ru"
-example:
-    - "https://vk.com/video121599878_165723901?hash=e06b0878046e1d32"
-    - "https://vk.com/video_ext.php?oid=121599878&id=165723901&hash=e06b0878046e1d32"
-attributes:
-    oid:
-        required: true
-    vid:
-        required: true
-extract:
-    - "!video(?'oid'-?\\d+)_(?'vid'\\d+)!"
-    - "!video_ext\\.php\\?oid=(?'oid'-?\\d+)&id=(?'vid'\\d+)!"
-    - "!hash=(?'hash'[0-9a-f]+)!"
-    - "!hd=(?'hd'\\d)!"
-iframe:
-    src: "//vk.com/video_ext.php?oid={@oid}&id={@vid}&hash={@hash}&hd={@hd}"
-scrape:
-    extract:
-        - "#meta property=\"og:video\" content=\".*?oid=(?'oid'-?\\d+).*?id=(?'vid'\\d+)#"
-        - "#meta property=\"og:video\" content=\".*?hash=(?'hash'[0-9a-f]+)#"
-    match: "#^(?!.*?hash=)#"
-    header:
-        - "User-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36"
-        - "Cookie: _ignoreAutoLogin=1"
diff --git "[ORIGINAL]/phpbb\\mediaembed/composer.json" "[FORUM_EXT]/phpbb\\mediaembed/composer.json"
--- "[ORIGINAL]/phpbb\\mediaembed/composer.json"
+++ "[FORUM_EXT]/phpbb\\mediaembed/composer.json"
@@ -3,7 +3,7 @@
     "type": "phpbb-extension",
     "description": "An official phpBB extension that allows users to embed content from allowed sites using a [media] BBCode, or from simply posting a supported URL in plain text.",
     "homepage": "https://www.phpbb.com/customise/db/extension/mediaembed/",
-    "version": "2.0.5",
+    "version": "2.0.2",
     "license": "GPL-2.0-only",
     "authors": [
         {
@@ -31,11 +31,11 @@
     ],
     "require": {
         "php": ">=7.1.3",
-        "composer/installers": "^1.0 || ^2.0",
+        "composer/installers": "~1.0.0",
         "phpbb/phpbb": ">=3.3.2"
     },
     "require-dev": {
-        "phing/phing": "~2.4"
+        "phing/phing": "2.4.*"
     },
     "extra": {
         "display-name": "phpBB Media Embed PlugIn",
diff --git "[FORUM_EXT]/phpbb\\mediaembed/diff_full.tmp" "[FORUM_EXT]/phpbb\\mediaembed/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\mediaembed/diff_full.tmp"
@@ -0,0 +1,2772 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/CHANGELOG.md"
+index b54717eba..5e76d820a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/CHANGELOG.md"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/CHANGELOG.md"
+@@ -1,41 +1,15 @@
+ # Changelog
+ 
+-### 2.0.5 - 2026-03-21
+-
+-- Added and/or updated support for media sites:
+-	- Facebook
+-	- vk.com
+-
+-### 2.0.4 - 2025-12-16
+-
+-- Fixed problems with YouTube not playing videos due to YouTube's referrerer policy.
+-- Ensure and future-proof compatibility with phpBB4.
+-- Added language packs:
+-	- Romanian
+-
+-### 2.0.3 - 2025-09-20
+-
+-- Added an amendment to the forum privacy policy regarding how embedded content may affect user privacy.
+-- Updated YouTube to use their enhanced privacy feature (no cookies until you play a video).
+-- Fixed an issue in the BBCode FAQ media embed example.
+-- Fixed issues in the language files.
+-- Removed the last traces of old XHTML code.
+-- Added and/or updated support for media sites:
+-  - Apple Podcasts
+-  - Bluesky
+-  - Pastebin
+-  - x.com (aka Twitter)
+-
+ ### 2.0.2 - 2024-01-21
+ 
+ - Small QoL improvement in the ACP, added sample placeholder data to the custom max-width field in the content-sizing settings.
+ - Minor code updates.
+ - Added and/or updated support for media sites:
+-  - Apple Music
+-  - x.com (aka Twitter)
+-  - kick.com
+-  - Threads
+-  - Bunny Stream
++	- Apple Music
++	- x.com (aka Twitter)
++	- kick.com
++	- Threads
++    - Bunny Stream
+ 
+ ### 2.0.1 - 2023-04-15
+ 
+@@ -50,9 +24,9 @@
+ 
+ - Backwards incompatible changes require a new minimum phpBB version of 3.3.2.
+ - New ACP options for custom content sizing:
+-  - Added a new setting to enlarge most embedded content to fit 100% of the width of the post-area.
++  - Added a new setting to enlarge most embedded content to fit 100% of the width of the post area.
+   - Added a new setting to define custom maximum widths in pixels or percent for individual sites.
+-- Fixed issues for new installations that would fail if any of phpBB's default forum roles were missing.
++- Fixed issues for new installs that would fail if any of phpBB's default forum roles were missing.
+ - Added language packs:
+   - Portuguese
+   - Chinese (traditional)
+@@ -110,10 +84,10 @@ on adding and creating new site YAML files for MediaEmbed.
+ ### 1.0.2 - 2018-06-25
+ 
+ - Added a global setting to enable or disable the conversion of plain URLs into embedded content.
+-- Added a forum-based permission, allowing control over who can post embedded content in specific forums.
+-- Added a user-based private messages permission, allowing control over who can post embedded content in their private messages.
++- Added a forum based permission, allowing control over who can post embedded content in specific forums.
++- Added a user based private messages permission, allowing control over who can post embedded content in their private messages.
+ - Fixed an issue where embedded content could still be posted by users who did not have permission to use BBCodes in a specific forum.
+-- Fixed an issue where embedded content could still be posted even though the Disable BBCode option was checked in the post-editor.
++- Fixed an issue where embedded content could still be posted even though the Disable BBCode option was checked in the post editor.
+ - When users disable the option to automatically parse URLs in their post, plain URLs will no longer be converted to embedded content either.
+ 
+ ### 1.0.1 - 2017-08-04
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
+index f12acc45c..74e5ee47a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
+@@ -22,7 +22,7 @@
+ 					<td style="width: 25%;">
+ 						{% if site %}
+ 							<label style="font-size: 1em;" title="{{ site.title }}">
+-								<input type="checkbox" class="radio" name="mark[]" value="{{ site.id }}"{% if site.disabled %} disabled{% elseif site.enabled %} checked{% endif %}> {{ site.name }}
++								<input type="checkbox" class="radio" name="mark[]" value="{{ site.id }}"{% if site.disabled %} disabled{% elseif site.enabled %} checked{% endif %} /> {{ site.name }}
+ 							</label>
+ 						{% endif %}
+ 					</td>
+@@ -38,8 +38,8 @@
+ 		<p class="small"><a href="#" data-marksites="true">{{ lang('MARK_ALL') }}</a> &bull; <a href="#" data-marksites="false">{{ lang('UNMARK_ALL') }}</a></p>
+ 	</fieldset>
+ 	<p id="buttons" class="submit-buttons">
+-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
+-		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
++		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+ 	</p>
+ 	{{ S_FORM_TOKEN }}
+ </form>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
+index bd6a9db66..4823e920c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
+@@ -8,51 +8,51 @@
+ 	<fieldset>
+ 		<legend>{{ lang('ACP_MEDIA_BBCODE_LEGEND') }}</legend>
+ 		<dl>
+-			<dt><label for="media_embed_bbcode">{{ lang('ACP_MEDIA_DISPLAY_BBCODE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN') }}</span></dt>
+-			<dd><label><input type="radio" class="radio" name="media_embed_bbcode" id="media_embed_bbcode" value="1" {% if S_MEDIA_EMBED_BBCODE %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="media_embed_bbcode" value="0"{% if not S_MEDIA_EMBED_BBCODE %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++			<dt><label for="media_embed_bbcode">{{ lang('ACP_MEDIA_DISPLAY_BBCODE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN') }}</span></dt>
++			<dd><label><input type="radio" class="radio" name="media_embed_bbcode" id="media_embed_bbcode" value="1" {% if S_MEDIA_EMBED_BBCODE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="media_embed_bbcode" value="0"{% if not S_MEDIA_EMBED_BBCODE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 		</dl>
+ 	</fieldset>
+ 	<fieldset>
+ 		<legend>{{ lang('ACP_MEDIA_OPTIONS_LEGEND') }}</legend>
+ 		<dl>
+-			<dt><label for="media_embed_allow_sig">{{ lang('ACP_MEDIA_ALLOW_SIG') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_ALLOW_SIG_EXPLAIN') }}</span></dt>
+-			<dd><label><input type="radio" class="radio" name="media_embed_allow_sig" id="media_embed_allow_sig" value="1" {% if S_MEDIA_EMBED_ALLOW_SIG %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="media_embed_allow_sig" value="0"{% if not S_MEDIA_EMBED_ALLOW_SIG %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++			<dt><label for="media_embed_allow_sig">{{ lang('ACP_MEDIA_ALLOW_SIG') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_ALLOW_SIG_EXPLAIN') }}</span></dt>
++			<dd><label><input type="radio" class="radio" name="media_embed_allow_sig" id="media_embed_allow_sig" value="1" {% if S_MEDIA_EMBED_ALLOW_SIG %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="media_embed_allow_sig" value="0"{% if not S_MEDIA_EMBED_ALLOW_SIG %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="media_embed_parse_urls">{{ lang('ACP_MEDIA_PARSE_URLS') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_PARSE_URLS_EXPLAIN') }}</span></dt>
+-			<dd><label><input type="radio" class="radio" name="media_embed_parse_urls" id="media_embed_parse_urls" value="1" {% if S_MEDIA_EMBED_PARSE_URLS %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="media_embed_parse_urls" value="0"{% if not S_MEDIA_EMBED_PARSE_URLS %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++			<dt><label for="media_embed_parse_urls">{{ lang('ACP_MEDIA_PARSE_URLS') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_PARSE_URLS_EXPLAIN') }}</span></dt>
++			<dd><label><input type="radio" class="radio" name="media_embed_parse_urls" id="media_embed_parse_urls" value="1" {% if S_MEDIA_EMBED_PARSE_URLS %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="media_embed_parse_urls" value="0"{% if not S_MEDIA_EMBED_PARSE_URLS %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 		</dl>
+ 	</fieldset>
+ 	<fieldset>
+ 		<legend>{{ lang('ACP_MEDIA_CACHE_LEGEND') }}</legend>
+ 		<dl>
+-			<dt><label for="media_embed_enable_cache">{{ lang('ACP_MEDIA_ENABLE_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_ENABLE_CACHE_EXPLAIN') }}</span></dt>
+-			<dd><label><input type="radio" class="radio" name="media_embed_enable_cache" id="media_embed_enable_cache" value="1" {% if S_MEDIA_EMBED_ENABLE_CACHE %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="media_embed_enable_cache" value="0"{% if not S_MEDIA_EMBED_ENABLE_CACHE %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++			<dt><label for="media_embed_enable_cache">{{ lang('ACP_MEDIA_ENABLE_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_ENABLE_CACHE_EXPLAIN') }}</span></dt>
++			<dd><label><input type="radio" class="radio" name="media_embed_enable_cache" id="media_embed_enable_cache" value="1" {% if S_MEDIA_EMBED_ENABLE_CACHE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="media_embed_enable_cache" value="0"{% if not S_MEDIA_EMBED_ENABLE_CACHE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="action_purge_cache">{{ lang('ACP_MEDIA_PURGE_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_PURGE_CACHE_EXPLAIN') }}</span></dt>
+-			<dd><input class="button2" type="submit" id="action_purge_cache" name="action_purge_cache" value="{{ lang('PURGE_CACHE') }}"></dd>
++			<dt><label for="action_purge_cache">{{ lang('ACP_MEDIA_PURGE_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_PURGE_CACHE_EXPLAIN') }}</span></dt>
++			<dd><input class="button2" type="submit" id="action_purge_cache" name="action_purge_cache" value="{{ lang('PURGE_CACHE') }}" /></dd>
+ 		</dl>
+ 	</fieldset>
+ 	<fieldset>
+ 		<legend>{{ lang('ACP_MEDIA_WIDTH_LEGEND') }}</legend>
+ 		<dl>
+-			<dt><label for="media_embed_full_width">{{ lang('ACP_MEDIA_FULL_WIDTH') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_FULL_WIDTH_EXPLAIN') }}</span></dt>
+-			<dd><label><input type="radio" class="radio" name="media_embed_full_width" id="media_embed_full_width" value="1" {% if S_MEDIA_EMBED_FULL_WIDTH %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="media_embed_full_width" value="0"{% if not S_MEDIA_EMBED_FULL_WIDTH %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++			<dt><label for="media_embed_full_width">{{ lang('ACP_MEDIA_FULL_WIDTH') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_FULL_WIDTH_EXPLAIN') }}</span></dt>
++			<dd><label><input type="radio" class="radio" name="media_embed_full_width" id="media_embed_full_width" value="1" {% if S_MEDIA_EMBED_FULL_WIDTH %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="media_embed_full_width" value="0"{% if not S_MEDIA_EMBED_FULL_WIDTH %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="media_embed_max_width">{{ lang('ACP_MEDIA_MAX_WIDTH') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_MAX_WIDTH_EXPLAIN') }}</span></dt>
++			<dt><label for="media_embed_max_width">{{ lang('ACP_MEDIA_MAX_WIDTH') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_MAX_WIDTH_EXPLAIN') }}</span></dt>
+ 			<dd><textarea id="media_embed_max_width" name="media_embed_max_width" rows="8" cols="40" style="width: 50%;" placeholder="twitter:100%&#10;youtube:80%&#10;funnyordie:480px">{{ S_MEDIA_EMBED_MAX_WIDTHS }}</textarea></dd>
+ 		</dl>
+ 	</fieldset>
+ 	<fieldset class="submit-buttons">
+-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
+-		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
++		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+ 		{{ S_FORM_TOKEN }}
+ 	</fieldset>
+ </form>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
+index f44d8e8b1..fdf64305d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
+@@ -1,3 +1,3 @@
+ {% if S_BBCODE_MEDIA %}
+-	<input type="button" class="button2" accesskey="m" name="addmedia" value="Media" style="width: 50px;" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}">
++	<input type="button" class="button2" accesskey="m" name="addmedia" value="Media" style="width: 50px;" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}" />
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml"
+deleted file mode 100644
+index 15f925af3..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml"
++++ /dev/null
+@@ -1,25 +0,0 @@
+-name: "Apple Podcasts"
+-homepage: "https://podcasts.apple.com/"
+-host: podcasts.apple.com
+-example:
+-    - https://podcasts.apple.com/us/podcast/the-office-deep-dive-with-brian-baumgartner/id1550331348
+-    - https://podcasts.apple.com/us/podcast/the-office-deep-dive-with-brian-baumgartner/id1550331348?i=1000514199106
+-extract:
+-    - "@podcasts.apple.com/(?'country'\\w+)/podcast/[-\\w%]*/id(?'podcast_id'\\d+)(?:\\?i=(?'episode_id'\\d+))?@"
+-choose:
+-    when:
+-        test: '@episode_id'
+-        iframe:
+-            allow: "autoplay *;encrypted-media *"
+-            width: "100%"
+-            height: "175"
+-            max-width: "900"
+-            src: "https://embed.podcasts.apple.com/{@country}/podcast/episode/id{@podcast_id}?i={@episode_id}"
+-    otherwise:
+-        iframe:
+-            allow: "autoplay *;encrypted-media *"
+-            width: "100%"
+-            height: "450"
+-            max-width: "900"
+-            src: "https://embed.podcasts.apple.com/{@country}/podcast/episode/id{@podcast_id}"
+-tags: "podcasts"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml"
+deleted file mode 100644
+index 2fbed75d0..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml"
++++ /dev/null
+@@ -1,25 +0,0 @@
+-attributes:
+-    embedder:
+-        filterChain: []
+-        required: true
+-    url:
+-        filterChain: "urldecode"
+-        required: true
+-example:
+-    - "https://bsky.app/profile/bsky.app/post/3kkrqzuydho2v"
+-    - "https://bsky.app/profile/bnewbold.net/post/3kxjq2auebs2f"
+-extract: "#^https://(?'embedder'[.\\w]+)/oembed.*?url=(?'url'[\\w%.]+)#"
+-homepage: "https://bsky.app/"
+-host: "bsky.app"
+-iframe:
+-    data-s9e-livepreview-ignore-attrs: style
+-    height: 600
+-    onload: "let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])"
+-    src: "https://s9e.github.io/iframe/2/bluesky.min.html#<xsl:value-of select=\"@url\"/>#<xsl:value-of select=\"@embedder\"/>"
+-    width: 600
+-name: "Bluesky"
+-scrape:
+-    extract: "#https://(?'embedder'[.\\w]+)/oembed.*?url=(?'url'[\\w%.]+)#"
+-    match: "#/profile/[^/]+/post/.#"
+-source: "https://embed.bsky.app/"
+-tags: "social"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml"
+deleted file mode 100644
+index a1a297235..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml"
++++ /dev/null
+@@ -1,50 +0,0 @@
+-name: Facebook
+-homepage: https://www.facebook.com/
+-tags: social
+-host:
+-    - facebook.com
+-    - fb.watch
+-example:
+-    - https://www.facebook.com/MetaforDevelopers/posts/451016937058647
+-    - https://www.facebook.com/watch/?v=224353158889229
+-    - https://fb.watch/3zYsXdnxjf/
+-    - https://www.facebook.com/reel/873906321076441
+-extract:
+-    - "@facebook.com/.*?(?:fbid=|/permalink/|\\?v=)(?'id'\\d+)@"
+-    - "@facebook.com/(?'user'[.\\w]+)/(?'type'[pv])(?:ost|ideo)s?/(?:[-%.\\w]+/)?(?'id'\\d+)\\b@"
+-    - "@facebook.com/video/(?=post|video)(?'type'[pv])@"
+-    - "@facebook.com/events/(?'id'\\d+)\\b(?!/permalink)@"
+-    - "@facebook.com/watch/?(?'type'[pv])=@"
+-    - "@facebook.com/groups/[^/]*/(?'type'p)osts/(?'id'\\d+)@"
+-    - "@facebook.com/(?'user'[.\\w]+)/posts/pfbid(?'pfbid'\\w+)@"
+-    - "@facebook.com/permalink.php?story_fbid=(?:(?'id'\\d+)|pfbid(?'pfbid'\\w+))&id=(?'page_id'\\d+)@"
+-    - "@facebook.com/(?'type'r)eel/(?'id'\\d+)@"
+-scrape:
+-    - extract: "@facebook.com/(?'user'[.\\w]+)/(?'type'[pv])\\w+/(?'id'\\d+)(?!\\w)@"
+-      header: "User-agent: PHP (not Mozilla)"
+-      match: "@facebook.com/[.\\w]+/posts/pfbid@"
+-      url: https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2F{@user}%2Fposts%2Fpfbid{@pfbid}
+-    - extract: "@story_fbid=(?'id'\\d+)@"
+-      header: "User-agent: PHP (not Mozilla)"
+-      match: "@facebook.com/permalink.php?story_fbid=pfbid(?'pfbid'\\w+)&id=(?'page_id'\\d+)@"
+-      url: https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fpermalink.php%3Fstory_fbid%3Dpfbid{@pfbid}%26id%3D{@page_id}
+-    - extract:
+-        - "@facebook.com/watch/?(?'type'v)=(?'id'\\d+)@"
+-        - "@facebook.com/(?'user'[.\\w]+)/(?'type'v)ideos/(?'id'\\d+)@"
+-      header: "User-agent: PHP (not Mozilla)"
+-      match: "@fb.watch/.@"
+-    - extract:
+-        - "@facebook.com/\\w+/(?'user'[.\\w]+)/permalink/(?'id'\\d+)(?!\\w)@"
+-        - "@og:url[^>]+facebook.com/(?'user'[.\\w]+)/(?'type'[pv])(?:ost|ideo)s?/(?:[-\\w%]+/)?(?'id'\\d+)\\b@"
+-      header: "User-agent: PHP (not Mozilla)"
+-      match: "@facebook.com/share/[pv]/\\w@"
+-iframe:
+-    data-s9e-livepreview-ignore-attrs: style
+-    onload: let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])
+-    src: https://s9e.github.io/iframe/2/facebook.min.html#<xsl:choose><xsl:when test="@user"><xsl:value-of select="@user"/>/<xsl:choose><xsl:when test="@type='r'or@type='v'">video</xsl:when><xsl:otherwise>post</xsl:otherwise></xsl:choose>s/<xsl:choose><xsl:when test="@id"><xsl:value-of select="@id"/></xsl:when><xsl:otherwise>pfbid<xsl:value-of select="@pfbid"/></xsl:otherwise></xsl:choose></xsl:when><xsl:when test="@id"><xsl:value-of select="@type"/><xsl:value-of select="@id"/></xsl:when><xsl:otherwise>pfbid<xsl:value-of select="@pfbid"/></xsl:otherwise></xsl:choose>
+-amp:
+-    custom-element: "amp-facebook"
+-    src: "https://cdn.ampproject.org/v0/amp-facebook-0.1.js"
+-    template: <amp-facebook layout="responsive" width="640" height="360"><xsl:if test="starts-with(@type,'v')"><xsl:attribute name="data-embed-as">video</xsl:attribute></xsl:if><xsl:attribute name="data-href">https://www.facebook.com/<xsl:choose><xsl:when test="@user"><xsl:value-of select="@user"/></xsl:when><xsl:otherwise>user</xsl:otherwise></xsl:choose>/<xsl:choose><xsl:when test="starts-with(@type,'v')">video</xsl:when><xsl:otherwise>post</xsl:otherwise></xsl:choose>s/<xsl:value-of select="@id"/></xsl:attribute></amp-facebook>
+-attributes: []
+-tracking_policy: https://www.facebook.com/help/1896641480634370
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml"
+deleted file mode 100644
+index 1efb6f379..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml"
++++ /dev/null
+@@ -1,12 +0,0 @@
+-name: Pastebin
+-host: pastebin.com
+-example:
+-    - "https://pastebin.com/9jEf44nc"
+-    - "https://pastebin.com/9jEf44nc?theme=dark"
+-extract: "#pastebin\\.com/(?!u/)(?:\\w+(?:\\.php\\?i=|/))?(?'id'\\w+)(?'dark'\\?theme=dark)?#"
+-iframe:
+-    scrolling: "yes"
+-    width: "100%"
+-    height: "300"
+-    style: ["border:none;resize:vertical;width:100%"]
+-    src: //pastebin.com/embed_iframe/{@id}{@dark}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/twitter.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
+index b05309020..5ac8c93d5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
+@@ -14,10 +14,6 @@ iframe:
+     data-s9e-livepreview-ignore-attrs: "style"
+     onload: "let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])"
+     width: "550"
+-    height: "350"
++    height: "273"
+     allow: "autoplay *"
+-    src: https://s9e.github.io/iframe/2/twitter.min.html#<xsl:value-of select="@id"/><xsl:if test="$MEDIAEMBED_THEME">#theme=<xsl:value-of select="$MEDIAEMBED_THEME"/></xsl:if>
+-amp:
+-    custom-element: amp-twitter
+-    src: https://cdn.ampproject.org/v0/amp-twitter-0.1.js
+-    template: '<amp-twitter layout="responsive" width="550" height="273" data-tweetid="{@id}"><blockquote placeholder=""><a href="https://twitter.com/user/status/{@id}">X</a></blockquote></amp-twitter>'
++    src: https://s9e.github.io/iframe/2/twitter.min.html#<xsl:value-of select="@id"/><xsl:if test="$MEDIAEMBED_THEME='dark'">#theme=dark</xsl:if>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml"
+deleted file mode 100644
+index 17959bd01..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml"
++++ /dev/null
+@@ -1,30 +0,0 @@
+-name: "VK"
+-homepage: "https://vk.com/"
+-tags: ".ru"
+-host:
+-    - "vk.com"
+-    - "vkontakte.ru"
+-    - "vkvideo.ru"
+-example:
+-    - "https://vk.com/video121599878_165723901?hash=e06b0878046e1d32"
+-    - "https://vk.com/video_ext.php?oid=121599878&id=165723901&hash=e06b0878046e1d32"
+-attributes:
+-    oid:
+-        required: true
+-    vid:
+-        required: true
+-extract:
+-    - "!video(?'oid'-?\\d+)_(?'vid'\\d+)!"
+-    - "!video_ext\\.php\\?oid=(?'oid'-?\\d+)&id=(?'vid'\\d+)!"
+-    - "!hash=(?'hash'[0-9a-f]+)!"
+-    - "!hd=(?'hd'\\d)!"
+-iframe:
+-    src: "//vk.com/video_ext.php?oid={@oid}&id={@vid}&hash={@hash}&hd={@hd}"
+-scrape:
+-    extract:
+-        - "#meta property=\"og:video\" content=\".*?oid=(?'oid'-?\\d+).*?id=(?'vid'\\d+)#"
+-        - "#meta property=\"og:video\" content=\".*?hash=(?'hash'[0-9a-f]+)#"
+-    match: "#^(?!.*?hash=)#"
+-    header:
+-        - "User-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36"
+-        - "Cookie: _ignoreAutoLogin=1"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/composer.json"
+index a301fcfa0..3275bb192 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/composer.json"
+@@ -3,7 +3,7 @@
+     "type": "phpbb-extension",
+     "description": "An official phpBB extension that allows users to embed content from allowed sites using a [media] BBCode, or from simply posting a supported URL in plain text.",
+     "homepage": "https://www.phpbb.com/customise/db/extension/mediaembed/",
+-    "version": "2.0.5",
++    "version": "2.0.2",
+     "license": "GPL-2.0-only",
+     "authors": [
+         {
+@@ -31,11 +31,11 @@
+     ],
+     "require": {
+         "php": ">=7.1.3",
+-        "composer/installers": "^1.0 || ^2.0",
++        "composer/installers": "~1.0.0",
+         "phpbb/phpbb": ">=3.3.2"
+     },
+     "require-dev": {
+-        "phing/phing": "~2.4"
++        "phing/phing": "2.4.*"
+     },
+     "extra": {
+         "display-name": "phpBB Media Embed PlugIn",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/diff_full.tmp"
+new file mode 100644
+index 000000000..7413aad5b
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/diff_full.tmp"
+@@ -0,0 +1,354 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/CHANGELOG.md"
++index b54717eba..5e76d820a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/CHANGELOG.md"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/CHANGELOG.md"
++@@ -1,41 +1,15 @@
++ # Changelog
++ 
++-### 2.0.5 - 2026-03-21
++-
++-- Added and/or updated support for media sites:
++-	- Facebook
++-	- vk.com
++-
++-### 2.0.4 - 2025-12-16
++-
++-- Fixed problems with YouTube not playing videos due to YouTube's referrerer policy.
++-- Ensure and future-proof compatibility with phpBB4.
++-- Added language packs:
++-	- Romanian
++-
++-### 2.0.3 - 2025-09-20
++-
++-- Added an amendment to the forum privacy policy regarding how embedded content may affect user privacy.
++-- Updated YouTube to use their enhanced privacy feature (no cookies until you play a video).
++-- Fixed an issue in the BBCode FAQ media embed example.
++-- Fixed issues in the language files.
++-- Removed the last traces of old XHTML code.
++-- Added and/or updated support for media sites:
++-  - Apple Podcasts
++-  - Bluesky
++-  - Pastebin
++-  - x.com (aka Twitter)
++-
++ ### 2.0.2 - 2024-01-21
++ 
++ - Small QoL improvement in the ACP, added sample placeholder data to the custom max-width field in the content-sizing settings.
++ - Minor code updates.
++ - Added and/or updated support for media sites:
++-  - Apple Music
++-  - x.com (aka Twitter)
++-  - kick.com
++-  - Threads
++-  - Bunny Stream
+++	- Apple Music
+++	- x.com (aka Twitter)
+++	- kick.com
+++	- Threads
+++    - Bunny Stream
++ 
++ ### 2.0.1 - 2023-04-15
++ 
++@@ -50,9 +24,9 @@
++ 
++ - Backwards incompatible changes require a new minimum phpBB version of 3.3.2.
++ - New ACP options for custom content sizing:
++-  - Added a new setting to enlarge most embedded content to fit 100% of the width of the post-area.
+++  - Added a new setting to enlarge most embedded content to fit 100% of the width of the post area.
++   - Added a new setting to define custom maximum widths in pixels or percent for individual sites.
++-- Fixed issues for new installations that would fail if any of phpBB's default forum roles were missing.
+++- Fixed issues for new installs that would fail if any of phpBB's default forum roles were missing.
++ - Added language packs:
++   - Portuguese
++   - Chinese (traditional)
++@@ -110,10 +84,10 @@ on adding and creating new site YAML files for MediaEmbed.
++ ### 1.0.2 - 2018-06-25
++ 
++ - Added a global setting to enable or disable the conversion of plain URLs into embedded content.
++-- Added a forum-based permission, allowing control over who can post embedded content in specific forums.
++-- Added a user-based private messages permission, allowing control over who can post embedded content in their private messages.
+++- Added a forum based permission, allowing control over who can post embedded content in specific forums.
+++- Added a user based private messages permission, allowing control over who can post embedded content in their private messages.
++ - Fixed an issue where embedded content could still be posted by users who did not have permission to use BBCodes in a specific forum.
++-- Fixed an issue where embedded content could still be posted even though the Disable BBCode option was checked in the post-editor.
+++- Fixed an issue where embedded content could still be posted even though the Disable BBCode option was checked in the post editor.
++ - When users disable the option to automatically parse URLs in their post, plain URLs will no longer be converted to embedded content either.
++ 
++ ### 1.0.1 - 2017-08-04
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
++index f12acc45c..74e5ee47a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
++@@ -22,7 +22,7 @@
++ 					<td style="width: 25%;">
++ 						{% if site %}
++ 							<label style="font-size: 1em;" title="{{ site.title }}">
++-								<input type="checkbox" class="radio" name="mark[]" value="{{ site.id }}"{% if site.disabled %} disabled{% elseif site.enabled %} checked{% endif %}> {{ site.name }}
+++								<input type="checkbox" class="radio" name="mark[]" value="{{ site.id }}"{% if site.disabled %} disabled{% elseif site.enabled %} checked{% endif %} /> {{ site.name }}
++ 							</label>
++ 						{% endif %}
++ 					</td>
++@@ -38,8 +38,8 @@
++ 		<p class="small"><a href="#" data-marksites="true">{{ lang('MARK_ALL') }}</a> &bull; <a href="#" data-marksites="false">{{ lang('UNMARK_ALL') }}</a></p>
++ 	</fieldset>
++ 	<p id="buttons" class="submit-buttons">
++-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
++-		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
+++		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+++		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
++ 	</p>
++ 	{{ S_FORM_TOKEN }}
++ </form>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
++index bd6a9db66..4823e920c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
++@@ -8,51 +8,51 @@
++ 	<fieldset>
++ 		<legend>{{ lang('ACP_MEDIA_BBCODE_LEGEND') }}</legend>
++ 		<dl>
++-			<dt><label for="media_embed_bbcode">{{ lang('ACP_MEDIA_DISPLAY_BBCODE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN') }}</span></dt>
++-			<dd><label><input type="radio" class="radio" name="media_embed_bbcode" id="media_embed_bbcode" value="1" {% if S_MEDIA_EMBED_BBCODE %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="media_embed_bbcode" value="0"{% if not S_MEDIA_EMBED_BBCODE %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+++			<dt><label for="media_embed_bbcode">{{ lang('ACP_MEDIA_DISPLAY_BBCODE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN') }}</span></dt>
+++			<dd><label><input type="radio" class="radio" name="media_embed_bbcode" id="media_embed_bbcode" value="1" {% if S_MEDIA_EMBED_BBCODE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="media_embed_bbcode" value="0"{% if not S_MEDIA_EMBED_BBCODE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 		</dl>
++ 	</fieldset>
++ 	<fieldset>
++ 		<legend>{{ lang('ACP_MEDIA_OPTIONS_LEGEND') }}</legend>
++ 		<dl>
++-			<dt><label for="media_embed_allow_sig">{{ lang('ACP_MEDIA_ALLOW_SIG') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_ALLOW_SIG_EXPLAIN') }}</span></dt>
++-			<dd><label><input type="radio" class="radio" name="media_embed_allow_sig" id="media_embed_allow_sig" value="1" {% if S_MEDIA_EMBED_ALLOW_SIG %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="media_embed_allow_sig" value="0"{% if not S_MEDIA_EMBED_ALLOW_SIG %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+++			<dt><label for="media_embed_allow_sig">{{ lang('ACP_MEDIA_ALLOW_SIG') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_ALLOW_SIG_EXPLAIN') }}</span></dt>
+++			<dd><label><input type="radio" class="radio" name="media_embed_allow_sig" id="media_embed_allow_sig" value="1" {% if S_MEDIA_EMBED_ALLOW_SIG %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="media_embed_allow_sig" value="0"{% if not S_MEDIA_EMBED_ALLOW_SIG %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="media_embed_parse_urls">{{ lang('ACP_MEDIA_PARSE_URLS') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_PARSE_URLS_EXPLAIN') }}</span></dt>
++-			<dd><label><input type="radio" class="radio" name="media_embed_parse_urls" id="media_embed_parse_urls" value="1" {% if S_MEDIA_EMBED_PARSE_URLS %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="media_embed_parse_urls" value="0"{% if not S_MEDIA_EMBED_PARSE_URLS %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+++			<dt><label for="media_embed_parse_urls">{{ lang('ACP_MEDIA_PARSE_URLS') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_PARSE_URLS_EXPLAIN') }}</span></dt>
+++			<dd><label><input type="radio" class="radio" name="media_embed_parse_urls" id="media_embed_parse_urls" value="1" {% if S_MEDIA_EMBED_PARSE_URLS %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="media_embed_parse_urls" value="0"{% if not S_MEDIA_EMBED_PARSE_URLS %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 		</dl>
++ 	</fieldset>
++ 	<fieldset>
++ 		<legend>{{ lang('ACP_MEDIA_CACHE_LEGEND') }}</legend>
++ 		<dl>
++-			<dt><label for="media_embed_enable_cache">{{ lang('ACP_MEDIA_ENABLE_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_ENABLE_CACHE_EXPLAIN') }}</span></dt>
++-			<dd><label><input type="radio" class="radio" name="media_embed_enable_cache" id="media_embed_enable_cache" value="1" {% if S_MEDIA_EMBED_ENABLE_CACHE %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="media_embed_enable_cache" value="0"{% if not S_MEDIA_EMBED_ENABLE_CACHE %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+++			<dt><label for="media_embed_enable_cache">{{ lang('ACP_MEDIA_ENABLE_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_ENABLE_CACHE_EXPLAIN') }}</span></dt>
+++			<dd><label><input type="radio" class="radio" name="media_embed_enable_cache" id="media_embed_enable_cache" value="1" {% if S_MEDIA_EMBED_ENABLE_CACHE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="media_embed_enable_cache" value="0"{% if not S_MEDIA_EMBED_ENABLE_CACHE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="action_purge_cache">{{ lang('ACP_MEDIA_PURGE_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_PURGE_CACHE_EXPLAIN') }}</span></dt>
++-			<dd><input class="button2" type="submit" id="action_purge_cache" name="action_purge_cache" value="{{ lang('PURGE_CACHE') }}"></dd>
+++			<dt><label for="action_purge_cache">{{ lang('ACP_MEDIA_PURGE_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_PURGE_CACHE_EXPLAIN') }}</span></dt>
+++			<dd><input class="button2" type="submit" id="action_purge_cache" name="action_purge_cache" value="{{ lang('PURGE_CACHE') }}" /></dd>
++ 		</dl>
++ 	</fieldset>
++ 	<fieldset>
++ 		<legend>{{ lang('ACP_MEDIA_WIDTH_LEGEND') }}</legend>
++ 		<dl>
++-			<dt><label for="media_embed_full_width">{{ lang('ACP_MEDIA_FULL_WIDTH') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_FULL_WIDTH_EXPLAIN') }}</span></dt>
++-			<dd><label><input type="radio" class="radio" name="media_embed_full_width" id="media_embed_full_width" value="1" {% if S_MEDIA_EMBED_FULL_WIDTH %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="media_embed_full_width" value="0"{% if not S_MEDIA_EMBED_FULL_WIDTH %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+++			<dt><label for="media_embed_full_width">{{ lang('ACP_MEDIA_FULL_WIDTH') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_FULL_WIDTH_EXPLAIN') }}</span></dt>
+++			<dd><label><input type="radio" class="radio" name="media_embed_full_width" id="media_embed_full_width" value="1" {% if S_MEDIA_EMBED_FULL_WIDTH %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="media_embed_full_width" value="0"{% if not S_MEDIA_EMBED_FULL_WIDTH %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="media_embed_max_width">{{ lang('ACP_MEDIA_MAX_WIDTH') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_MAX_WIDTH_EXPLAIN') }}</span></dt>
+++			<dt><label for="media_embed_max_width">{{ lang('ACP_MEDIA_MAX_WIDTH') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_MAX_WIDTH_EXPLAIN') }}</span></dt>
++ 			<dd><textarea id="media_embed_max_width" name="media_embed_max_width" rows="8" cols="40" style="width: 50%;" placeholder="twitter:100%&#10;youtube:80%&#10;funnyordie:480px">{{ S_MEDIA_EMBED_MAX_WIDTHS }}</textarea></dd>
++ 		</dl>
++ 	</fieldset>
++ 	<fieldset class="submit-buttons">
++-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
++-		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
+++		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+++		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
++ 		{{ S_FORM_TOKEN }}
++ 	</fieldset>
++ </form>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
++index f44d8e8b1..fdf64305d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
++@@ -1,3 +1,3 @@
++ {% if S_BBCODE_MEDIA %}
++-	<input type="button" class="button2" accesskey="m" name="addmedia" value="Media" style="width: 50px;" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}">
+++	<input type="button" class="button2" accesskey="m" name="addmedia" value="Media" style="width: 50px;" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}" />
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml"
++deleted file mode 100644
++index 15f925af3..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml"
+++++ /dev/null
++@@ -1,25 +0,0 @@
++-name: "Apple Podcasts"
++-homepage: "https://podcasts.apple.com/"
++-host: podcasts.apple.com
++-example:
++-    - https://podcasts.apple.com/us/podcast/the-office-deep-dive-with-brian-baumgartner/id1550331348
++-    - https://podcasts.apple.com/us/podcast/the-office-deep-dive-with-brian-baumgartner/id1550331348?i=1000514199106
++-extract:
++-    - "@podcasts.apple.com/(?'country'\\w+)/podcast/[-\\w%]*/id(?'podcast_id'\\d+)(?:\\?i=(?'episode_id'\\d+))?@"
++-choose:
++-    when:
++-        test: '@episode_id'
++-        iframe:
++-            allow: "autoplay *;encrypted-media *"
++-            width: "100%"
++-            height: "175"
++-            max-width: "900"
++-            src: "https://embed.podcasts.apple.com/{@country}/podcast/episode/id{@podcast_id}?i={@episode_id}"
++-    otherwise:
++-        iframe:
++-            allow: "autoplay *;encrypted-media *"
++-            width: "100%"
++-            height: "450"
++-            max-width: "900"
++-            src: "https://embed.podcasts.apple.com/{@country}/podcast/episode/id{@podcast_id}"
++-tags: "podcasts"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml"
++deleted file mode 100644
++index 2fbed75d0..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml"
+++++ /dev/null
++@@ -1,25 +0,0 @@
++-attributes:
++-    embedder:
++-        filterChain: []
++-        required: true
++-    url:
++-        filterChain: "urldecode"
++-        required: true
++-example:
++-    - "https://bsky.app/profile/bsky.app/post/3kkrqzuydho2v"
++-    - "https://bsky.app/profile/bnewbold.net/post/3kxjq2auebs2f"
++-extract: "#^https://(?'embedder'[.\\w]+)/oembed.*?url=(?'url'[\\w%.]+)#"
++-homepage: "https://bsky.app/"
++-host: "bsky.app"
++-iframe:
++-    data-s9e-livepreview-ignore-attrs: style
++-    height: 600
++-    onload: "let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])"
++-    src: "https://s9e.github.io/iframe/2/bluesky.min.html#<xsl:value-of select=\"@url\"/>#<xsl:value-of select=\"@embedder\"/>"
++-    width: 600
++-name: "Bluesky"
++-scrape:
++-    extract: "#https://(?'embedder'[.\\w]+)/oembed.*?url=(?'url'[\\w%.]+)#"
++-    match: "#/profile/[^/]+/post/.#"
++-source: "https://embed.bsky.app/"
++-tags: "social"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml"
++deleted file mode 100644
++index a1a297235..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml"
+++++ /dev/null
++@@ -1,50 +0,0 @@
++-name: Facebook
++-homepage: https://www.facebook.com/
++-tags: social
++-host:
++-    - facebook.com
++-    - fb.watch
++-example:
++-    - https://www.facebook.com/MetaforDevelopers/posts/451016937058647
++-    - https://www.facebook.com/watch/?v=224353158889229
++-    - https://fb.watch/3zYsXdnxjf/
++-    - https://www.facebook.com/reel/873906321076441
++-extract:
++-    - "@facebook.com/.*?(?:fbid=|/permalink/|\\?v=)(?'id'\\d+)@"
++-    - "@facebook.com/(?'user'[.\\w]+)/(?'type'[pv])(?:ost|ideo)s?/(?:[-%.\\w]+/)?(?'id'\\d+)\\b@"
++-    - "@facebook.com/video/(?=post|video)(?'type'[pv])@"
++-    - "@facebook.com/events/(?'id'\\d+)\\b(?!/permalink)@"
++-    - "@facebook.com/watch/?(?'type'[pv])=@"
++-    - "@facebook.com/groups/[^/]*/(?'type'p)osts/(?'id'\\d+)@"
++-    - "@facebook.com/(?'user'[.\\w]+)/posts/pfbid(?'pfbid'\\w+)@"
++-    - "@facebook.com/permalink.php?story_fbid=(?:(?'id'\\d+)|pfbid(?'pfbid'\\w+))&id=(?'page_id'\\d+)@"
++-    - "@facebook.com/(?'type'r)eel/(?'id'\\d+)@"
++-scrape:
++-    - extract: "@facebook.com/(?'user'[.\\w]+)/(?'type'[pv])\\w+/(?'id'\\d+)(?!\\w)@"
++-      header: "User-agent: PHP (not Mozilla)"
++-      match: "@facebook.com/[.\\w]+/posts/pfbid@"
++-      url: https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2F{@user}%2Fposts%2Fpfbid{@pfbid}
++-    - extract: "@story_fbid=(?'id'\\d+)@"
++-      header: "User-agent: PHP (not Mozilla)"
++-      match: "@facebook.com/permalink.php?story_fbid=pfbid(?'pfbid'\\w+)&id=(?'page_id'\\d+)@"
++-      url: https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fpermalink.php%3Fstory_fbid%3Dpfbid{@pfbid}%26id%3D{@page_id}
++-    - extract:
++-        - "@facebook.com/watch/?(?'type'v)=(?'id'\\d+)@"
++-        - "@facebook.com/(?'user'[.\\w]+)/(?'type'v)ideos/(?'id'\\d+)@"
++-      header: "User-agent: PHP (not Mozilla)"
++-      match: "@fb.watch/.@"
++-    - extract:
++-        - "@facebook.com/\\w+/(?'user'[.\\w]+)/permalink/(?'id'\\d+)(?!\\w)@"
++-        - "@og:url[^>]+facebook.com/(?'user'[.\\w]+)/(?'type'[pv])(?:ost|ideo)s?/(?:[-\\w%]+/)?(?'id'\\d+)\\b@"
++-      header: "User-agent: PHP (not Mozilla)"
++-      match: "@facebook.com/share/[pv]/\\w@"
++-iframe:
++-    data-s9e-livepreview-ignore-attrs: style
++-    onload: let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])
++-    src: https://s9e.github.io/iframe/2/facebook.min.html#<xsl:choose><xsl:when test="@user"><xsl:value-of select="@user"/>/<xsl:choose><xsl:when test="@type='r'or@type='v'">video</xsl:when><xsl:otherwise>post</xsl:otherwise></xsl:choose>s/<xsl:choose><xsl:when test="@id"><xsl:value-of select="@id"/></xsl:when><xsl:otherwise>pfbid<xsl:value-of select="@pfbid"/></xsl:otherwise></xsl:choose></xsl:when><xsl:when test="@id"><xsl:value-of select="@type"/><xsl:value-of select="@id"/></xsl:when><xsl:otherwise>pfbid<xsl:value-of select="@pfbid"/></xsl:otherwise></xsl:choose>
++-amp:
++-    custom-element: "amp-facebook"
++-    src: "https://cdn.ampproject.org/v0/amp-facebook-0.1.js"
++-    template: <amp-facebook layout="responsive" width="640" height="360"><xsl:if test="starts-with(@type,'v')"><xsl:attribute name="data-embed-as">video</xsl:attribute></xsl:if><xsl:attribute name="data-href">https://www.facebook.com/<xsl:choose><xsl:when test="@user"><xsl:value-of select="@user"/></xsl:when><xsl:otherwise>user</xsl:otherwise></xsl:choose>/<xsl:choose><xsl:when test="starts-with(@type,'v')">video</xsl:when><xsl:otherwise>post</xsl:otherwise></xsl:choose>s/<xsl:value-of select="@id"/></xsl:attribute></amp-facebook>
++-attributes: []
++-tracking_policy: https://www.facebook.com/help/1896641480634370
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml"
++deleted file mode 100644
++index 1efb6f379..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml"
+++++ /dev/null
++@@ -1,12 +0,0 @@
++-name: Pastebin
++-host: pastebin.com
++-example:
++-    - "https://pastebin.com/9jEf44nc"
++-    - "https://pastebin.com/9jEf44nc?theme=dark"
++-extract: "#pastebin\\.com/(?!u/)(?:\\w+(?:\\.php\\?i=|/))?(?'id'\\w+)(?'dark'\\?theme=dark)?#"
++-iframe:
++-    scrolling: "yes"
++-    width: "100%"
++-    height: "300"
++-    style: ["border:none;resize:vertical;width:100%"]
++-    src: //pastebin.com/embed_iframe/{@id}{@dark}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/twitter.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
++index b05309020..5ac8c93d5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
++@@ -14,10 +14,6 @@ iframe:
++     data-s9e-livepreview-ignore-attrs: "style"
++     onload: "let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])"
++     width: "550"
++-    height: "350"
+++    height: "273"
++     allow: "autoplay *"
++-    src: https://s9e.github.io/iframe/2/twitter.min.html#<xsl:value-of select="@id"/><xsl:if test="$MEDIAEMBED_THEME">#theme=<xsl:value-of select="$MEDIAEMBED_THEME"/></xsl:if>
++-amp:
++-    custom-element: amp-twitter
++-    src: https://cdn.ampproject.org/v0/amp-twitter-0.1.js
++-    template: '<amp-twitter layout="responsive" width="550" height="273" data-tweetid="{@id}"><blockquote placeholder=""><a href="https://twitter.com/user/status/{@id}">X</a></blockquote></amp-twitter>'
+++    src: https://s9e.github.io/iframe/2/twitter.min.html#<xsl:value-of select="@id"/><xsl:if test="$MEDIAEMBED_THEME='dark'">#theme=dark</xsl:if>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml"
++deleted file mode 100644
++index 17959bd01..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml"
+++++ /dev/null
++@@ -1,30 +0,0 @@
++-name: "VK"
++-homepage: "https://vk.com/"
++-tags: ".ru"
++-host:
++-    - "vk.com"
++-    - "vkontakte.ru"
++-    - "vkvideo.ru"
++-example:
++- 
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/event/main_listener.php"
+index 5cc81e6fb..764fbbf48 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/event/main_listener.php"
+@@ -25,9 +25,6 @@ use Symfony\Component\Yaml\Yaml;
+  */
+ class main_listener implements EventSubscriberInterface
+ {
+-	/** @var string A link to a rich content media site for demo purposes */
+-	public const MEDIA_DEMO_URL = 'https://youtu.be/Ne18ZQ7LLI0';
+-
+ 	/** @var auth */
+ 	protected $auth;
+ 
+@@ -55,16 +52,13 @@ class main_listener implements EventSubscriberInterface
+ 	/** @var bool Disable the media tag (bbcode parsing) */
+ 	protected $disable_tag = false;
+ 
+-	/** @var bool|null Cached result of is_phpbb4() */
+-	protected $is_phpbb4;
+-
+ 	/**
+ 	 * {@inheritDoc}
+ 	 */
+ 	public static function getSubscribedEvents()
+ 	{
+ 		return [
+-			'core.text_formatter_s9e_configure_after'	=> [['add_custom_sites', 3], ['enable_media_sites', 2], ['configure_url_parsing', 1], ['modify_tag_templates', 0]],
++			'core.text_formatter_s9e_configure_after'	=> [['add_custom_sites', 3], ['enable_media_sites', 2], ['configure_url_parsing', 1]],
+ 			'core.display_custom_bbcodes'				=> 'setup_media_bbcode',
+ 			'core.permissions'							=> 'set_permissions',
+ 			'core.help_manager_add_block_before'		=> 'media_embed_help',
+@@ -73,20 +67,19 @@ class main_listener implements EventSubscriberInterface
+ 			'core.message_parser_check_message'			=> [['check_signature'], ['check_magic_urls'], ['check_bbcode_enabled']],
+ 			'core.text_formatter_s9e_parser_setup'		=> [['disable_media_embed'], ['setup_cache_dir']],
+ 			'core.page_header' 							=> 'setup_media_configs',
+-			'core.page_footer'							=> 'append_agreement',
+ 		];
+ 	}
+ 
+ 	/**
+ 	 * Constructor
+ 	 *
+-	 * @param auth					$auth
+-	 * @param config				$config
+-	 * @param db_text				$config_text
+-	 * @param language				$language
+-	 * @param template				$template
+-	 * @param customsitescollection	$custom_sites
+-	 * @param string				$cache_dir
++	 * @param auth                  $auth
++	 * @param config                $config
++	 * @param db_text               $config_text
++	 * @param language              $language
++	 * @param template              $template
++	 * @param customsitescollection $custom_sites
++	 * @param string                $cache_dir
+ 	 */
+ 	public function __construct(auth $auth, config $config, db_text $config_text, language $language, template $template, customsitescollection $custom_sites, $cache_dir)
+ 	{
+@@ -107,29 +100,12 @@ class main_listener implements EventSubscriberInterface
+ 	 */
+ 	public function add_custom_sites($event)
+ 	{
+-		$phpbb4_builtins = array_flip([
+-			'applepodcasts',
+-			'bluesky',
+-			'bunny',
+-			'facebook',
+-			'mastodon',
+-			'pastebin',
+-			'threads',
+-			'twitter',
+-			'vk',
+-		]);
+-
+ 		foreach ($this->custom_sites->get_collection() as $site)
+ 		{
+-			$name = basename($site, ext::YML);
+-
+-			// Skip built-in sites when running phpBB 4
+-			if (isset($phpbb4_builtins[$name]) && $this->is_phpbb4())
+-			{
+-				continue;
+-			}
+-
+-			$event['configurator']->MediaEmbed->defaultSites->add($name, Yaml::parseFile($site));
++			$event['configurator']->MediaEmbed->defaultSites->add(
++				basename($site, ext::YML),
++				Yaml::parse(file_get_contents($site))
++			);
+ 		}
+ 	}
+ 
+@@ -176,32 +152,6 @@ class main_listener implements EventSubscriberInterface
+ 		}
+ 	}
+ 
+-	/**
+-	 * Modify bbcode tag templates
+-	 *
+-	 * @param \phpbb\event\data $event The event object
+-	 * @return void
+-	 */
+-	public function modify_tag_templates($event)
+-	{
+-		try
+-		{
+-			// force YouTube to use the no cookies until the user starts video playback, and fix referrer policy issues
+-			$tag = $event['configurator']->tags['YOUTUBE'];
+-			$tag->template = str_replace('www.youtube.com', 'www.youtube-nocookie.com', $tag->template);
+-			if (!$this->is_phpbb4())
+-			{
+-				$tag->template = str_replace(' allowfullscreen', ' referrerpolicy="origin" allowfullscreen', $tag->template);
+-			}
+-
+-			$event['configurator']->finalize();
+-		}
+-		catch (\RuntimeException $e)
+-		{
+-			// do nothing
+-		}
+-	}
+-
+ 	/**
+ 	 * Set template switch for displaying the [media] BBCode button
+ 	 *
+@@ -243,14 +193,14 @@ class main_listener implements EventSubscriberInterface
+ 			]);
+ 
+ 			$uid = $bitfield = $flags = '';
+-			$demo_text = self::MEDIA_DEMO_URL;
++			$demo_text = $this->language->lang('HELP_EMBEDDING_MEDIA_DEMO');
+ 			generate_text_for_storage($demo_text, $uid, $bitfield, $flags, true, true);
+ 			$demo_display = generate_text_for_display($demo_text, $uid, $bitfield, $flags);
+ 			$list_sites = implode(', ', $this->get_siteIds());
+ 
+ 			$this->template->assign_block_vars('faq_block.faq_row', [
+ 				'FAQ_QUESTION'	=> $this->language->lang('HELP_EMBEDDING_MEDIA_QUESTION'),
+-				'FAQ_ANSWER'	=> $this->language->lang('HELP_EMBEDDING_MEDIA_ANSWER', self::MEDIA_DEMO_URL, $demo_display, $list_sites),
++				'FAQ_ANSWER'	=> $this->language->lang('HELP_EMBEDDING_MEDIA_ANSWER', $demo_text, $demo_display, $list_sites),
+ 			]);
+ 		}
+ 	}
+@@ -391,34 +341,4 @@ class main_listener implements EventSubscriberInterface
+ 
+ 		return $siteIds ? json_decode($siteIds, true) : [];
+ 	}
+-
+-	/**
+-	 * Appends additional language to the privacy policy agreement text.
+-	 *
+-	 * @return void
+-	 */
+-	public function append_agreement()
+-	{
+-		if (!$this->template->retrieve_var('S_AGREEMENT') || ($this->template->retrieve_var('AGREEMENT_TITLE') !== $this->language->lang('PRIVACY')))
+-		{
+-			return;
+-		}
+-
+-		$this->language->add_lang('ucp', 'phpbb/mediaembed');
+-
+-		$this->template->append_var('AGREEMENT_TEXT', $this->language->lang('MEDIA_EMBED_PRIVACY_POLICY', $this->config['sitename']));
+-	}
+-
+-	/**
+-	 * @return mixed
+-	 */
+-	private function is_phpbb4()
+-	{
+-		if ($this->is_phpbb4 === null)
+-		{
+-			$this->is_phpbb4 = phpbb_version_compare($this->config['version'], '4.0.0-a1', '>=');
+-		}
+-
+-		return $this->is_phpbb4;
+-	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ar/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ar/acp.php"
+index 2c37a66ca..d4e9e357e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ar/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ar/acp.php"
+@@ -24,8 +24,8 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'إعدادات إدراج مُحتوى الوسائط',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'من هنا تستطيع ضبط الإعدادات الخاصة بالإضافة “إدراج مُحتوى الوسائط”.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'ظهور زر BBCode للوسائط <samp>[media]</samp>',
+-	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'اختيارك “لا”, يعني منع ظهور زر BBCode الخاص بالوسائط <samp>[media]</samp> في محرر الكتابة, وبالرغم من ذلك يستطيع الأعضاء استخدام الوسم <samp>[media]</samp> في مُشاركاتهم.',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'ظهور زر BBCode للوسائط <samp>[MEDIA]</samp>',
++	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'اختيارك “لا”, يعني منع ظهور زر BBCode الخاص بالوسائط <samp>[MEDIA]</samp> في محرر الكتابة, وبالرغم من ذلك يستطيع الأعضاء استخدام الوسم <samp>[media]</samp> في مُشاركاتهم.',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'التوقيعات',
+ 	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'السماح للعضو بإستخدام وسم الوسائط في التوقيع.',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ar/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ar/help.php"
+index ac1968d27..9f28a985a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ar/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ar/help.php"
+@@ -43,13 +43,14 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'كيف أستطيع إدراج مُحتوى الوسائط من المواقع الأخرى في المُشاركات؟',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'يستطيع الأعضاء إدراج محتوى الوسائط مثل الفيديو والمقاطع الصوتية من المواقع المسموح بها بإستخدام
+ 										الوسم <strong>[media][/media]</strong>, أو ببساطة كتابة الرابط لأحد المواقع المدعومة
+-										كما هو بدون الوسوم. مثال:<br><br>
++										كما هو بدون الوسوم. مثال:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>كما تلاحظ في المثال أعلاه, تستطيع أيضاً استخدام الرابط بدون الوسم
++										<br /><br />كما تلاحظ في المثال أعلاه, تستطيع أيضاً استخدام الرابط بدون الوسم
+ 										<strong>[media]</strong>.
+-										<br><br>ستكون النتيجة للمثال المذكور أعلاه كالآتي:<br><br>%2$s
+-										<br><br>القائمة التالية تحتوي على المواقع المدعومة:<br><samp>%3$s.</samp>
+-										<br><br>للمزيد من المعلومات والأمثلة للمواقع المدعومة,
++										<br /><br />ستكون النتيجة للمثال المذكور أعلاه كالآتي:<br /><br />%2$s
++										<br /><br />القائمة التالية تحتوي على المواقع المدعومة:<br /><samp>%3$s.</samp>
++										<br /><br />للمزيد من المعلومات والأمثلة للمواقع المدعومة,
+ 										انقر على هذا الرابط <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										معلومات إدراج مُحتوى الوسائط</a>.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ar/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ar/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ar/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/cs/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/cs/acp.php"
+index 6e51eaa45..499d03170 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/cs/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/cs/acp.php"
+@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Media Embed nastavení',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Zde můžete konfigurovat nastaven í pro plugin Media Embed.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zobrazit <samp>[media]</samp> BBCode na stránce s příspěvkem.',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zobrazit <samp>[MEDIA]</samp> BBCode na stránce s příspěvkem.',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Pokud je zakázáno, BBCode tlačítko nebude zobrazeno, přesto mohou uživatelé ve svých příspěvcích využít <samp>[media]</samp>.',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Povolí v podpisech uživatelů',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/cs/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/cs/help.php"
+index 7252e04fc..505361d18 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/cs/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/cs/help.php"
+@@ -40,12 +40,13 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA'			=> 'Vkládání médií',
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Jak vkládat média z jiných stránek do příspěvků.',
+-	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Uživatelů mohou vkládat obsah jako jsou videa nebo zvukové stopy z povolených stránek používáním <strong>[media][/media]</strong> nebo jednoduše vložením povoleného URL do textu. Například:<br><br>
++	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Uživatelů mohou vkládat obsah jako jsou videa nebo zvukové stopy z povolených stránek používáním <strong>[media][/media]</strong> nebo jednoduše vložením povoleného URL do textu. Například:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Jak bylo výše zmíněno, odkaz může být také vložen pomocí
++										<br /><br />Jak bylo výše zmíněno, odkaz může být také vložen pomocí
+ 										<strong>[media]</strong> tagů.
+-										<br><br>Uvedený příklad bude vypadat následovně:<br><br>%2$s
+-										<br><br>Tyto stránky jsou podporovány:<br><samp>%3$s.</samp>
+-										<br><br>Pro kompletní dokumentaci podporovaných tránek a příklady URL navštivte <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++										<br /><br />Uvedený příklad bude vypadat následovně:<br /><br />%2$s
++										<br /><br />Tyto stránky jsou podporovány:<br /><samp>%3$s.</samp>
++										<br /><br />Pro kompletní dokumentaci podporovaných tránek a příklady URL navštivte <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										MediaEmbed Plugin dokumentace</a>.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/cs/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/cs/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/cs/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/da/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/da/acp.php"
+index 24809f988..5fe4c0858 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/da/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/da/acp.php"
+@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Indstillinger for medieindlejring',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Her kan du konfigurere indstillingerne til Media Embed PlugIn.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Vis <samp>[media]</samp>-BBkode på siden hvor indlæg skrives',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Vis <samp>[MEDIA]</samp>-BBkode på siden hvor indlæg skrives',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Hvis den er valgt fra vises BBkode-knappen ikke, men brugerne kan dog stadig bruge <samp>[media]</samp>-tagget i deres indlæg',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Tillad i brugersignaturer',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/da/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/da/help.php"
+index 51acd4c4d..e135c3f42 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/da/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/da/help.php"
+@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Sådan indlejres medie fra andre steder i indlæg',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Brugere kan indlejre indhold, såsom videoer og lyd fra tilladte stedet med
+ 										<strong>[media][/media]</strong>-tags, eller blot ved at skrive en understøttet
+-										URL i ren tekst. F.eks.:<br><br>
++										URL i ren tekst. F.eks.:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Som beskrevet ovenfor, kan linket også bruges uden
++										<br /><br />Som beskrevet ovenfor, kan linket også bruges uden
+ 										<strong>[media]</strong>-taggene.
+-										<br><br>Eksemplet som vises her genererer:<br><br>%2$s
+-										<br><br>Følgende steder understøttes:<br><samp>%3$s.</samp>
+-										<br><br>Besøg <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++										<br /><br />Eksemplet som vises her genererer:<br /><br />%2$s
++										<br /><br />Følgende steder understøttes:<br /><samp>%3$s.</samp>
++										<br /><br />Besøg <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										dokumentationen til MediaEmbed Plugin</a> for fuld dokumentation på understøttede steder og
+ 										URL\'er med eksempler.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/da/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/da/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/da/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/de/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/de/acp.php"
+index 8f3c22fbf..201c3b788 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/de/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/de/acp.php"
+@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Media Embed Einstellungen',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Hier kannst du die Einstellungen für das Media Embed PlugIn anpassen.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zeige <samp>[media]</samp> BBCode auf der Posting Seite',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zeige <samp>[MEDIA]</samp> BBCode auf der Posting Seite',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Wenn nicht erlaubt, wird der BBCode Button nicht angezeigt, dennoch können die User das <samp>[media]</samp> in ihren Posts verwenden.',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Erlaubt in den Benutzer Signaturen',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/de/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/de/help.php"
+index 48c2a13ea..9ff61bc48 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/de/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/de/help.php"
+@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Wie werden Medien von anderen Seiten in Posts eingebunden',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'User können Medien von anderen erlaubten Seiten wie Video und Audio einbinden indem
+ 										die <strong>[media][/media]</strong> Tags oder indem einfach die reine URL der erlaubten Seite
+-										in den Text kopiert wird. Als Beispiel:<br><br>
++										in den Text kopiert wird. Als Beispiel:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Wie oben beschrieben kann die URL auch ohne die
++										<br /><br />Wie oben beschrieben kann die URL auch ohne die
+ 										<strong>[media]</strong> Tags verwendet werden.
+-										<br><br>Das hier gezeigt Beispiel würde folgendes generieren:<br><br>%2$s
+-										<br><br>Die folgenden Seiten sind erlaubt:<br><samp>%3$s.</samp>
+-										<br><br>Für eine komplette Dokumentation der unterstützen Seiten und Beispiel URLs,
++										<br /><br />Das hier gezeigt Beispiel würde folgendes generieren:<br /><br />%2$s
++										<br /><br />Die folgenden Seiten sind erlaubt:<br /><samp>%3$s.</samp>
++										<br /><br />Für eine komplette Dokumentation der unterstützen Seiten und Beispiel URLs,
+ 										besuche die <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										MediaEmbed Plugin Documentation</a>.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/de/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/de/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/de/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/en/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/en/acp.php"
+index 48f9d5b73..30b60554c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/en/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/en/acp.php"
+@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Media Embed Settings',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Here you can configure the settings for the Media Embed PlugIn.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Display <samp>[media]</samp> BBCode on posting page',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Display <samp>[MEDIA]</samp> BBCode on posting page',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'If disallowed, the BBCode button will not be displayed, however users can still use the <samp>[media]</samp> tag in their posts.',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Allow in user signatures',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/en/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/en/help.php"
+index 2f07f1a77..b4697cacd 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/en/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/en/help.php"
+@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'How to embed media from other sites into posts',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Users can embed content such as videos and audio from allowed sites using
+ 										the <strong>[media][/media]</strong> tags, or from simply posting a supported
+-										URL in plain text. For example:<br><br>
++										URL in plain text. For example:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>As noted above, the link could also be used without the
++										<br /><br />As noted above, the link could also be used without the
+ 										<strong>[media]</strong> tags.
+-										<br><br>The example shown here would generate:<br><br>%2$s
+-										<br><br>The following sites are supported:<br><samp>%3$s.</samp>
+-										<br><br>For complete documentation on supported sites and example URLs,
++										<br /><br />The example shown here would generate:<br /><br />%2$s
++										<br /><br />The following sites are supported:<br /><samp>%3$s.</samp>
++										<br /><br />For complete documentation on supported sites and example URLs,
+ 										visit the <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										MediaEmbed Plugin Documentation</a>.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/en/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/en/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/en/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es/acp.php"
+index 467e324d2..e6668703f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es/acp.php"
+@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Ajustes de Media Embed',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aquí puede configurar los ajustes del PlugIn Media Embed.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[media]</samp> en la página de publicación',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[MEDIA]</samp> en la página de publicación',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Si se deshabilita, el botón BBCode no será mostrado, pero los usuarios aún podrán seguir usando la etiqueta <samp>[media]</samp> en sus mensajes',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opciones',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Permitir en firmas de usuario',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es/help.php"
+index c9940503d..128d5a5bb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es/help.php"
+@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Cómo insertar medios de otros sitios en los mensajes',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Los usuarios pueden incorporar contenido como videos y audio desde sitios permitidos usando
+ 										las etiquetas <strong>[media][/media]</strong>, o simplemente publicando una URL soportada
+-										en texto plano. Por ejemplo:<br><br>
++										en texto plano. Por ejemplo:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Como se indicó anteriormente, el enlace también podría utilizarse sin las
++										<br /><br />Como se indicó anteriormente, el enlace también podría utilizarse sin las
+ 										etiquetas <strong>[media]</strong>.
+-										<br><br>El ejemplo mostrado aquí generaría:<br><br>%2$s
+-										<br><br>Los siguientes sitios son compatibles:<br><samp>%3$s.</samp>
+-										<br><br>Para obtener una documentación completa sobre los sitios admitidos, y las URL de ejemplo,
++										<br /><br />El ejemplo mostrado aquí generaría:<br /><br />%2$s
++										<br /><br />Los siguientes sitios son compatibles:<br /><samp>%3$s.</samp>
++										<br /><br />Para obtener una documentación completa sobre los sitios admitidos, y las URL de ejemplo,
+ 										visite la <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										Documentación del PlugIn MediaEmbed</a>.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/info_acp_mediaembed.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es/info_acp_mediaembed.php"
+index b3c5569ce..7aab0593d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/info_acp_mediaembed.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es/info_acp_mediaembed.php"
+@@ -26,5 +26,5 @@ $lang = array_merge($lang, [
+ 	// Log keys
+ 	'LOG_PHPBB_MEDIA_EMBED_CACHE_PURGED'=> '<strong>Caché Media Embed cache limpiado</strong>',
+ 	'LOG_PHPBB_MEDIA_EMBED_MANAGE'		=> '<strong>Sitios de Media Embed actualizados</strong>',
+-	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Ajustes de Media Embed actualizados</strong>',
++	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Ajustes de Media Embed actualziados</strong>',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es_x_tu/acp.php"
+index 1debbb24b..3c4adb083 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es_x_tu/acp.php"
+@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Ajustes de Media Embed',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aquí puedes configurar los ajustes del PlugIn Media Embed.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[media]</samp> en la página de publicación',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[MEDIA]</samp> en la página de publicación',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Si se deshabilita, el botón BBCode no será mostrado, pero los usuarios aún podrán seguir usando la etiqueta <samp>[media]</samp> en sus mensajes',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opciones',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Permitir en firmas de usuario',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es_x_tu/help.php"
+index c9940503d..128d5a5bb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es_x_tu/help.php"
+@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Cómo insertar medios de otros sitios en los mensajes',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Los usuarios pueden incorporar contenido como videos y audio desde sitios permitidos usando
+ 										las etiquetas <strong>[media][/media]</strong>, o simplemente publicando una URL soportada
+-										en texto plano. Por ejemplo:<br><br>
++										en texto plano. Por ejemplo:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Como se indicó anteriormente, el enlace también podría utilizarse sin las
++										<br /><br />Como se indicó anteriormente, el enlace también podría utilizarse sin las
+ 										etiquetas <strong>[media]</strong>.
+-										<br><br>El ejemplo mostrado aquí generaría:<br><br>%2$s
+-										<br><br>Los siguientes sitios son compatibles:<br><samp>%3$s.</samp>
+-										<br><br>Para obtener una documentación completa sobre los sitios admitidos, y las URL de ejemplo,
++										<br /><br />El ejemplo mostrado aquí generaría:<br /><br />%2$s
++										<br /><br />Los siguientes sitios son compatibles:<br /><samp>%3$s.</samp>
++										<br /><br />Para obtener una documentación completa sobre los sitios admitidos, y las URL de ejemplo,
+ 										visite la <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										Documentación del PlugIn MediaEmbed</a>.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/info_acp_mediaembed.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es_x_tu/info_acp_mediaembed.php"
+index b3c5569ce..7aab0593d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/info_acp_mediaembed.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es_x_tu/info_acp_mediaembed.php"
+@@ -26,5 +26,5 @@ $lang = array_merge($lang, [
+ 	// Log keys
+ 	'LOG_PHPBB_MEDIA_EMBED_CACHE_PURGED'=> '<strong>Caché Media Embed cache limpiado</strong>',
+ 	'LOG_PHPBB_MEDIA_EMBED_MANAGE'		=> '<strong>Sitios de Media Embed actualizados</strong>',
+-	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Ajustes de Media Embed actualizados</strong>',
++	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Ajustes de Media Embed actualziados</strong>',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/et/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/et/acp.php"
+index 0f76ddaa2..8e5690ad6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/et/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/et/acp.php"
+@@ -24,7 +24,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Manustatud meedia seaded',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Sellel leheküljel on sul võimalik seadistada laienduse manustatud meedia seadeid.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Näita <samp>[media]</samp> BBkoodi positamise leheküljel',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Näita <samp>[MEDIA]</samp> BBkoodi positamise leheküljel',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Kui pole lubatud, siis BBkoodi nuppu ei näidata, kuid siiski on kasutajatel võimalik kasutada e <samp>[media]</samp> silti oma postitustes.',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Luba kasutaja signatuurides',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/et/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/et/help.php"
+index 73373fcc5..f22f41389 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/et/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/et/help.php"
+@@ -42,12 +42,13 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA'			=> 'Meedia manustamine',
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Kuidas manustada meediat teiselt veebileheküljelt postitusse',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Kasutajatel on võimalik manustada sisu nagu näiteks videosi ja helifaile lubatud veebilehekülgedelt kasutades
+-										<strong>[media][/media]</strong> silte või lihtsalt postitades toetatud veebiaadresse puhta tekstina. Näiteks:<br><br>
++										<strong>[media][/media]</strong> silte või lihtsalt postitades toetatud veebiaadresse puhta tekstina. Näiteks:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Nii nagu eespool öeldud, siis aadressi on võimalik kasutada ka ilma
++										<br /><br />Nii nagu eespool öeldud, siis aadressi on võimalik kasutada ka ilma
+ 										<strong>[media]</strong> siltideta.
+-										<br><br>Siin toodud näide tekitab aga tulemuseks sellise:<br><br>%2$s
+-										<br><br>Toetatud on järgmised veebilehed:<br><samp>%3$s.</samp>
+-										<br><br>Et näha täielikku dokumentatsiooni toeatatutest lehekülgedest, ning näidis aadressidest, palun külasta <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++										<br /><br />Siin toodud näide tekitab aga tulemuseks sellise:<br /><br />%2$s
++										<br /><br />Toetatud on järgmised veebilehed:<br /><samp>%3$s.</samp>
++										<br /><br />Et näha täielikku dokumentatsiooni toeatatutest lehekülgedest, ning näidis aadressidest, palun külasta <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										lehekülge</a>.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/et/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/et/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/et/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/fr/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/fr/acp.php"
+index 209a3d2b1..cd0b80be7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/fr/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/fr/acp.php"
+@@ -43,11 +43,11 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Paramètres des médias intégrés',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Depuis cette page il est possible de paramétrer les options de l’extension « phpBB Media Embed PlugIn ».',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Afficher le BBCode <samp>[media]</samp> sur la page de rédaction des messages',
+-	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Permet d’activer l’affichage du BBCode <samp>[media]</samp> sur la page de l’éditeur complet lors de la rédaction d’une réponse ou d’un nouveau sujet. Si l’affichage est désactivé, le bouton du BBCode ne sera pas affiché, mais les utilisateurs pourront saisir manuellement la balise <samp>[media]</samp> dans leurs messages sur les pages accessibles au moyen des boutons « Répondre », « Nouveau sujet » ou dans la réponse rapide.',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Afficher le BBCode <samp>[MEDIA]</samp> sur la page de rédaction des messages',
++	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Permet d’activer l’affichage du BBCode <samp>[MEDIA]</samp> sur la page de l’éditeur complet lors de la rédaction d’une réponse ou d’un nouveau sujet. Si l’affichage est désactivé, le bouton du BBCode ne sera pas affiché, mais les utilisateurs pourront saisir manuellement la balise <samp>[media]</samp> dans leurs messages sur les pages accessibles au moyen des boutons « Répondre », « Nouveau sujet » ou dans la réponse rapide.',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Autoriser dans la signature des membres',
+-	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'Permet d’utiliser le BBCode <samp>[media]</samp> dans le contenu de la signature des membres.',
++	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'Permet d’utiliser le BBCode <samp>[MEDIA]</samp> dans le contenu de la signature des membres.',
+ 	'ACP_MEDIA_CACHE_LEGEND'			=> 'Content caching',
+ 	'ACP_MEDIA_ENABLE_CACHE'			=> 'Activer le cache des médias intégrés',
+ 	'ACP_MEDIA_ENABLE_CACHE_EXPLAIN'	=> 'Permet d’améliorer les performances via la mise en cache des informations recueillies localement sur les sites. En effet, dans certains cas il est possible de remarquer des performances dégradées lors du chargement de médias à partir d’autres sites, en particulier lorsque le même contenu est chargé plusieurs fois (par exemple lors de la modification d’un message).',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/fr/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/fr/help.php"
+index 06dbbf89a..5a9a00a8a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/fr/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/fr/help.php"
+@@ -43,13 +43,14 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Intégrer un média dans les messages provenant d’un service d’un autre site Web',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Les utilisateurs peuvent intégrer du contenu multimédia (audio, vidéo) provenant de services fournis
+ 										par d’autres sites Web en utilisant les balises du BBCode <strong>[media][/media]</strong>,
+-										ou en publiant simplement l’adresse URL d’un lien pris en charge. Tel que, par exemple :<br><br>
++										ou en publiant simplement l’adresse URL d’un lien pris en charge. Tel que, par exemple :<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Comme indiqué précédemment, le lien peut aussi être utilisé sans
++										<br /><br />Comme indiqué précédemment, le lien peut aussi être utilisé sans
+ 										les balises du BBCode <strong>[media]</strong>.
+-										<br><br>Ainsi, l’exemple montré ci-dessus affichera :<br><br>%2$s
+-										<br><br>Le services des sites Web suivants sont supportés :<br><samp>%3$s.</samp>
+-										<br><br>Une documentation complète à propos des services et des exemples d’adresses URL pris en charge,
++										<br /><br />Ainsi, l’exemple montré ci-dessus affichera :<br /><br />%2$s
++										<br /><br />Le services des sites Web suivants sont supportés :<br /><samp>%3$s.</samp>
++										<br /><br />Une documentation complète à propos des services et des exemples d’adresses URL pris en charge,
+ 										est disponible depuis la page : <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										Sites pris en charges par le plugin MediaEmbed</a>.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/fr/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/fr/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/fr/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/it/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/it/acp.php"
+index dc83ff4da..839efff0e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/it/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/it/acp.php"
+@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Impostazioni PlugIn Media Embed',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Qui puoi configurare le impostazioni per il PlugIn Media Embed.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Visualizza BBCode <samp>[media]</samp> nella pagina di scrittura',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Visualizza BBCode <samp>[MEDIA]</samp> nella pagina di scrittura',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Se non consentito, il pulsante BBCode non verrà visualizzato, tuttavia gli utenti possono ancora utilizzare il tag <samp> [media] </samp> nei loro messaggi',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opzioni',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Consenti nelle firme utente',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/it/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/it/help.php"
+index 587143b4b..50676fbbd 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/it/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/it/help.php"
+@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Come incorporare i contenuti multimediali da altri siti nei messaggi',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Gli utenti possono incorporare contenuti come video e audio dai siti consentiti utilizzando
+ 										i tags <strong>[media][/media]</strong>, o semplicemente postando in testo normale un URL
+-                                        che lo supporta. Per esempio:<br><br>
++                                        che lo supporta. Per esempio:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Come notato sopra, il collegamento potrebbe anche essere utilizzato senza
++										<br /><br />Come notato sopra, il collegamento potrebbe anche essere utilizzato senza
+ 										<strong>[media]</strong> tags.
+-										<br><br>L’esempio mostrato qui genererebbe:<br><br>%2$s
+-										<br><br>Sono supportati i seguenti siti:<br><samp>%3$s.</samp>
+-										<br><br>Per la documentazione completa sui siti supportati e sugli URL di esempio,
++										<br /><br />L’esempio mostrato qui genererebbe:<br /><br />%2$s
++										<br /><br />Sono supportati i seguenti siti:<br /><samp>%3$s.</samp>
++										<br /><br />Per la documentazione completa sui siti supportati e sugli URL di esempio,
+ 										consulta la <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										Documentazione sul plug-in multimediale incorporato</a>.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/it/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/it/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/it/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/nl/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/nl/acp.php"
+index ba7bb9d1e..1e812bcd5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/nl/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/nl/acp.php"
+@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Media Embed Instellingen',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Hier kunt u instellingen voor de Media Embed PlugIn configureren.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Toon de <samp>[media]</samp> BBCode op de reactie pagina',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Toon de <samp>[MEDIA]</samp> BBCode op de reactie pagina',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Als dit is niet toegestaan zal de BBCode knop niet worden getoond maar gebruikers kunnen nog steeds de <samp>[media]</samp> tag in berichten gebruiken',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Toestaan in onderschriften',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/nl/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/nl/help.php"
+index 9a1751558..08c248ab2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/nl/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/nl/help.php"
+@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Hoe voeg je media van andere website in in je berichten',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Gebruikers kunnen inhoud zoals video\'s en audo invoegen van toegestane websites met gebruik van
+ 										de <strong>[media][/media]</strong> tags, of door heel simpel het plaatsen van een ondersteunde
+-										URL in platte tekst. Als voorbeeld:<br><br>
++										URL in platte tekst. Als voorbeeld:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Zoals we zien hierboven kan de link ook worden gebruikt zonder de
++										<br /><br />Zoals we zien hierboven kan de link ook worden gebruikt zonder de
+ 										<strong>[media]</strong> tags.
+-										<br><br>Bovenstaand voorbeeld geeft als resultaat:<br><br>%2$s
+-										<br><br>De volgende websites worden ondersteund:<br><samp>%3$s.</samp>
+-										<br><br>Voor de volledige documentatie op ondersteunde websites en voorbeeld URL\'s,
++										<br /><br />Bovenstaand voorbeeld geeft als resultaat:<br /><br />%2$s
++										<br /><br />De volgende websites worden ondersteund:<br /><samp>%3$s.</samp>
++										<br /><br />Voor de volledige documentatie op ondersteunde websites en voorbeeld URL\'s,
+ 										bezoekt u de <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										MediaEmbed Plugin Documentatie</a>.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/nl/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/nl/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/nl/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pl/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pl/acp.php"
+index b83503f6a..55fc24115 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pl/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pl/acp.php"
+@@ -24,21 +24,21 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Ustawienia osadzania multimediów',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Tutaj można dokonać konfiguracji rozszerzenia Media Embed.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Wyświetl znacznik BBcode <samp>[media]</samp> na forum',
+-	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Jeśli wybrano Nie, to znacznik <samp>[media]</samp> nie będzie wyświetlony, jednakże nadal można go używać na forum.',
+-	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opcje',
+-	'ACP_MEDIA_ALLOW_SIG'				=> 'Znacznik <samp>[media]</samp> w podpisach',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Wyświetl znacznik BBcode <samp>[MEDIA]</samp> na forum',
++	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Jeśli wybrano Nie, to znacznik <samp>[MEDIA]</samp> nie będzie wyświetlony, jednakże nadal można go używać na forum.',
++	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++	'ACP_MEDIA_ALLOW_SIG'				=> 'Znacznik <samp>[MEDIA]</samp> w podpisach',
+ 	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'Zezwól na używanie multimediów w sygnaturze.',
+-	'ACP_MEDIA_CACHE_LEGEND'			=> 'Buforowanie zawartości',
++	'ACP_MEDIA_CACHE_LEGEND'			=> 'Content caching',
+ 	'ACP_MEDIA_ENABLE_CACHE'			=> 'Pamięć podręczna osadzania multimediów',
+ 	'ACP_MEDIA_ENABLE_CACHE_EXPLAIN'	=> 'W niektórych przypadkach ładowanie multimediów może działać wolniej, np. podczas ponownego ładowania treści przy edycji posta. Włączenie pamięci podręcznej może poprawić wydajność osadzania multimediów.',
+ 	'ACP_MEDIA_PARSE_URLS'				=> 'Konwersja adresów URL',
+ 	'ACP_MEDIA_PARSE_URLS_EXPLAIN'		=> 'Jeśli wybrano Tak, to adresy URL zostaną przekonwertowane bez użycia znacznika BBCode <samp>[media]</samp> lub <samp>[url]</samp>. Ta opcja wpłynie tylko na nowo osadzone multimedia. Dotychczasowe adresy URL nie zostaną przetworzone.',
+-	'ACP_MEDIA_WIDTH_LEGEND'			=> 'Rozmiar zawartości',
+-	'ACP_MEDIA_FULL_WIDTH'				=> 'Tryb pełnoekranowy',
+-	'ACP_MEDIA_FULL_WIDTH_EXPLAIN'		=> 'Włącz tę opcję, aby rozszerzyć większość osadzonych multimediów do szerokości obszaru treści posta, zachowując jednocześnie jego natywne proporcje.',
+-	'ACP_MEDIA_MAX_WIDTH'				=> 'Niestandardowy tryb pełnoekranowy',
+-	'ACP_MEDIA_MAX_WIDTH_EXPLAIN'		=> 'Użyj tego pola, aby zdefiniować maksymalną szerokość multimediów dla poszczególnych witryn. Zastąpi to domyślną szerokość zdefiniowana w polu wyżej. Wprowadź każdą witrynę w nowym wierszu, używając formatu <samp class="error">siteId:szerokość</samp> przy pomocy <samp class="error">px</samp> lub <samp class="error">%</samp>. Na przykład:<br><br><samp class="error">youtube:80%</samp><br><samp class="error">funnyordie:480px</samp><br><br><i><strong class="error">Wskazówka:</strong> Najedź kursorem myszy na witrynę na stronie ”Zarządzaj stronami”, aby wyświetlić nazwę identyfikatora witryny do użycia w tym miejscu.</i>',
++	'ACP_MEDIA_WIDTH_LEGEND'			=> 'Content sizing',
++	'ACP_MEDIA_FULL_WIDTH'				=> 'Enable full width content',
++	'ACP_MEDIA_FULL_WIDTH_EXPLAIN'		=> 'Enable this to expand most Media Embed content to fill the full width of the post content area while maintaining its native aspect ratio.',
++	'ACP_MEDIA_MAX_WIDTH'				=> 'Custom max-width content',
++	'ACP_MEDIA_MAX_WIDTH_EXPLAIN'		=> 'Use this field to define custom max-width values for individual sites. This will override the default size and the full width option above. Enter each site on a new line, using the format <samp class="error">siteId:width</samp> with either <samp class="error">px</samp> or <samp class="error">%</samp>. For example:<br><br><samp class="error">youtube:80%</samp><br><samp class="error">funnyordie:480px</samp><br><br><i><strong class="error">Tip:</strong> Hover your mouse over a site on the Manage sites page to reveal the site id name to use here.</i>',
+ 	'ACP_MEDIA_PURGE_CACHE'				=> 'Wyczyść pamięć podręczną',
+ 	'ACP_MEDIA_PURGE_CACHE_EXPLAIN'		=> 'Pamięć podręczna osadzania multimediów jest codziennie, automatycznie czyszczona. Można ją usunąć teraz poprzez kliknięcie przycisku.',
+ 	'ACP_MEDIA_SITE_TITLE'				=> 'ID strony: %s',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pl/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pl/help.php"
+index 92f062072..4fafe153c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pl/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pl/help.php"
+@@ -43,11 +43,12 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Jak wyświetlić multimedia z innych stron na forum',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Użytkownicy mogą wyświetlić zawartość z innych stron jak wideo lub muzyka
+ 										poprzez znacznik <strong>[media][/media]</strong>. Należy wkleić adres URL pomiędzy znacznikami.
+-										<br><br>Na przykład:
++										<br /><br />Na przykład:
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Powyższy adres URL zostanie wyświetlony jak pokazano poniżej:<br><br>%2$s
+-										<br><br>Na forum wspierane są strony:<br><samp>%3$s.</samp>
+-										<br><br>Dokumentacja wraz z wszystkimi wspieranymi stronami i przykładami adresów URL
++										<br /><br />Powyższy adres URL zostanie wyświetlony jak pokazano poniżej:<br /><br />%2$s
++										<br /><br />Na forum wspierane są strony:<br /><samp>%3$s.</samp>
++										<br /><br />Dokumentacja wraz z wszystkimi wspieranymi stronami i przykładami adresów URL
+ 										znajduje się pod linkiem <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										MediaEmbed Plugin Documentation</a>.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pl/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pl/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pl/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt/acp.php"
+index 8e8c27b67..98f166a4c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt/acp.php"
+@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Configurações do Media Embed',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aqui você pode configurar as configurações para o Media Embed PlugIn.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[media]</samp> na página de postagem',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[MEDIA]</samp> na página de postagem',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Se não for permitido, o botão BBCode não será exibido, no entanto, os usuários ainda podem usar a tag <samp>[media]</samp> em suas postagens',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Permitir em assinaturas de usuários',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt/help.php"
+index e95331f34..106ec85be 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt/help.php"
+@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Como inserir mídia de outros sites em postagens',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Os usuários podem incorporar conteúdo como vídeos e áudio de sites permitidos usando
+ 										as tags <strong>[media][/media]</strong>, ou simplesmente postando uma
+-										URL suportada em texto simples. Por exemplo:<br><br>
++										URL suportada em texto simples. Por exemplo:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Conforme mencionado acima, o link também pode ser usado sem as tags
++										<br /><br />Conforme mencionado acima, o link também pode ser usado sem as tags
+ 										<strong>[media]</strong>.
+-										<br><br>O exemplo mostrado aqui geraria:<br><br>%2$s
+-										<br><br>Os seguintes sites são suportados:<br><samp>%3$s.</samp>
+-										<br><br>Para obter documentação completa sobre sites suportados e URLs de exemplo,
++										<br /><br />O exemplo mostrado aqui geraria:<br /><br />%2$s
++										<br /><br />Os seguintes sites são suportados:<br /><samp>%3$s.</samp>
++										<br /><br />Para obter documentação completa sobre sites suportados e URLs de exemplo,
+ 										visite a <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										MediaEmbed Plugin Documentation</a>.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt_br/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt_br/acp.php"
+index f65252d3f..621c54579 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt_br/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt_br/acp.php"
+@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Configurações do Media Embed',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aqui você pode configurar as configurações para o Media Embed PlugIn.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[media]</samp> na página de postagem',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[MEDIA]</samp> na página de postagem',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Se não for permitido, o botão BBCode não será exibido, no entanto, os usuários ainda podem usar a tag <samp>[media]</samp> em suas postagens',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Permitir em assinaturas de usuários',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt_br/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt_br/help.php"
+index e6f91ca2e..80f8e08e0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt_br/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt_br/help.php"
+@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Como inserir mídia de outros sites em postagens',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Os usuários podem incorporar conteúdo como vídeos e áudio de sites permitidos usando
+ 										as tags <strong>[media][/media]</strong>, ou simplesmente postando uma
+-										URL suportada em texto simples. Por exemplo:<br><br>
++										URL suportada em texto simples. Por exemplo:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Conforme mencionado acima, o link também pode ser usado sem as tags
++										<br /><br />Conforme mencionado acima, o link também pode ser usado sem as tags
+ 										<strong>[media]</strong>.
+-										<br><br>O exemplo mostrado aqui geraria:<br><br>%2$s
+-										<br><br>Os seguintes sites são suportados:<br><samp>%3$s.</samp>
+-										<br><br>Para obter documentação completa sobre sites suportados e URLs de exemplo,
++										<br /><br />O exemplo mostrado aqui geraria:<br /><br />%2$s
++										<br /><br />Os seguintes sites são suportados:<br /><samp>%3$s.</samp>
++										<br /><br />Para obter documentação completa sobre sites suportados e URLs de exemplo,
+ 										visite a <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										MediaEmbed Plugin Documentation</a>.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt_br/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt_br/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt_br/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/acp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/acp.php"
+deleted file mode 100644
+index d4864a65c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/acp.php"
++++ /dev/null
+@@ -1,54 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	// Settings
+-	'ACP_MEDIA_SETTINGS'				=> 'Setări de încorporare media',
+-	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aici puteți configura setările pentru Media Embed PlugIn.',
+-	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Afișați <samp>[MEDIA]</samp> BBCode pe pagina de postare',
+-	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Dacă nu este permis, butonul BBCode nu va fi afișat, totuși utilizatorii pot folosi în continuare eticheta <samp>[media]</samp> în postările lor.',
+-	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opțiuni',
+-	'ACP_MEDIA_ALLOW_SIG'				=> 'Permiteți în semnăturile utilizatorilor',
+-	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'Permiteți semnăturilor utilizatorilor să afișeze conținut media încorporat.',
+-	'ACP_MEDIA_CACHE_LEGEND'			=> 'Memorarea în cache a conținutului',
+-	'ACP_MEDIA_ENABLE_CACHE'			=> 'Activați cacheul Media Embed',
+-	'ACP_MEDIA_ENABLE_CACHE_EXPLAIN'	=> 'În unele cazuri, este posibil să observați o performanță mai lentă decât cea normală atunci când încărcați conținut media de pe alte site-uri, mai ales când încărcați același conținut de mai multe ori (de exemplu, când editați o postare). Activarea acestui lucru va stoca în cache informațiile pe care Media Embed le adună de pe site-uri la nivel local și ar trebui să îmbunătățească performanța.',
+-	'ACP_MEDIA_PARSE_URLS'				=> 'Convertiți adrese URL simple',
+-	'ACP_MEDIA_PARSE_URLS_EXPLAIN'		=> 'Activați această opțiune pentru a converti adresele URL simple (nu sunt incluse în etichete <samp>[media]</samp> sau <samp>[url]</samp>) în conținut media încorporat. Rețineți că modificarea acestei setări va afecta numai postările noi, deoarece postările existente au fost deja analizate.',
+-	'ACP_MEDIA_WIDTH_LEGEND'			=> 'Dimensiunea conținutului',
+-	'ACP_MEDIA_FULL_WIDTH'				=> 'Activați conținutul cu lățime completă',
+-	'ACP_MEDIA_FULL_WIDTH_EXPLAIN'		=> 'Activați această opțiune pentru a extinde majoritatea conținutului Media Embed pentru a umple întreaga lățime a zonei de conținut postare, păstrând în același timp raportul de aspect nativ.',
+-	'ACP_MEDIA_MAX_WIDTH'				=> 'Conținut personalizat cu lățime maximă',
+-	'ACP_MEDIA_MAX_WIDTH_EXPLAIN'		=> 'Utilizați acest câmp pentru a defini valori personalizate pentru lățimea maximă pentru site-uri individuale. Aceasta va suprascrie dimensiunea implicită și opțiunea de lățime completă de mai sus. Introduceți fiecare site pe o nouă linie, folosind formatul <samp class="error">siteId:width</samp> fie cu <samp class="error">px</samp>, fie cu <samp class="error">%</samp>. De exemplu:<br><br><samp class="error">youtube:80%</samp><br><samp class="error">funnyordie:480px</samp><br><br><i><strong class="error">Sfat:</strong> treceți mouse-ul peste un site din pagina Gestionați site-urile pentru a dezvălui numele de cod al site-ului de utilizat aici.</i>',
+-	'ACP_MEDIA_PURGE_CACHE'				=> 'Ștergeți memoria cache încorporată',
+-	'ACP_MEDIA_PURGE_CACHE_EXPLAIN'		=> 'Cacheul Media Embed este curățat automat o dată pe zi, totuși acest buton poate fi folosit pentru a-și curăța manual memoria cache acum.',
+-	'ACP_MEDIA_SITE_TITLE'				=> 'Id-ul site-ului: %s',
+-	'ACP_MEDIA_SITE_DISABLED'			=> 'Acest site intră în conflict cu un BBCode existent: [%s]',
+-	'ACP_MEDIA_ERROR_MSG'				=> 'Au fost întâlnite următoarele erori:<br><br>%s',
+-	'ACP_MEDIA_INVALID_SITE'			=> '%1$s:%2$s :: “%1$s” nu este un ID valid de site',
+-	'ACP_MEDIA_INVALID_WIDTH'			=> '%1$s:%2$s :: “%2$s” nu este o lățime validă în „px” sau “%%”',
+-
+-	// Manage sites
+-	'ACP_MEDIA_MANAGE'					=> 'Gestionați site-urile de încorporare media',
+-	'ACP_MEDIA_MANAGE_EXPLAIN'			=> 'Aici puteți gestiona site-urile din care doriți să permiteți pluginului Media Embed să afișeze conținut.',
+-	'ACP_MEDIA_SITES_ERROR'				=> 'Nu există site-uri media de afișat.',
+-	'ACP_MEDIA_SITES_MISSING'			=> 'Următoarele site-uri nu mai sunt acceptate sau nu mai funcționează. Vă rugăm să retrimiteți această pagină pentru a le elimina.',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/common.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/common.php"
+deleted file mode 100644
+index 9be890b72..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/common.php"
++++ /dev/null
+@@ -1,42 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-/**
+- * DO NOT CHANGE
+- */
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
+-
+-$lang = array_merge($lang, [
+-	'BBCODE_MEDIA_HELP'	=> 'Media Embed: [media]http://media_url[/media]',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/help.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/help.php"
+deleted file mode 100644
+index 89eb4e1f3..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/help.php"
++++ /dev/null
+@@ -1,54 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-/**
+- * DO NOT CHANGE
+- */
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
+-
+-$lang = array_merge($lang, [
+-	'HELP_EMBEDDING_MEDIA'			=> 'Încorporarea media',
+-	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Cum să încorporați media de pe alte site-uri în postări',
+-	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Utilizatorii pot încorpora conținut, cum ar fi videoclipuri și audio de pe site-uri permise folosind
+-                                        etichetele <strong>[media][/media]</strong> sau pur și simplu de la postarea unui mesaj acceptat
+-                                        URL în text simplu. De exemplu:<br /><br />
+-                                        <strong>[media]</strong>%1$s<strong>[/media]</strong>
+-                                        <br /><br />Așa cum sa menționat mai sus, linkul ar putea fi folosit și fără
+-                                        etichete <strong>[media]</strong>.
+-                                        <br /><br />Exemplul prezentat aici ar genera:<br /><br />%2$s
+-                                        <br /><br />Sunt acceptate următoarele site-uri:<br /><samp>%3$s.</samp>
+-                                        <br /><br />Pentru documentația completă despre site-urile acceptate și exemple de adrese URL,
+-                                        accesați <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+-                                        Documentația pluginului MediaEmbed</a>.',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/info_acp_mediaembed.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/info_acp_mediaembed.php"
+deleted file mode 100644
+index 31ab8cb4b..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/info_acp_mediaembed.php"
++++ /dev/null
+@@ -1,30 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'ACP_PHPBB_MEDIA_EMBED'				=> 'Media Embed',
+-	'ACP_PHPBB_MEDIA_EMBED_MANAGE'		=> 'Gestionați site-urile',
+-	'ACP_PHPBB_MEDIA_EMBED_SETTINGS'	=> 'Setări',
+-
+-	// Log keys
+-	'LOG_PHPBB_MEDIA_EMBED_CACHE_PURGED'=> '<strong>Memoria cache pentru Media Embed a fost eliminată</strong>',
+-	'LOG_PHPBB_MEDIA_EMBED_MANAGE'		=> '<strong>Site-urile Media Embed au fost actualizate</strong>',
+-	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Setările pentru Media Embed au fost actualizate</strong>',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/install.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/install.php"
+deleted file mode 100644
+index 0b9296a30..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/install.php"
++++ /dev/null
+@@ -1,43 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2019 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-/**
+- * DO NOT CHANGE
+- */
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
+-
+-$lang = array_merge($lang, [
+-	'PHPBB_VERSION_ERROR'	=> 'Forumul dvs. pare să folosească o versiune mai veche a phpBB. phpBB ' . \phpbb\mediaembed\ext::PHPBB_MINIMUM . ' sau mai nou este necesar pentru a utiliza această extensie.',
+-	'S9E_MEDIAEMBED_ERROR'	=> 'Am detectat extensia s9e/mediaembed. Pluginul Media Embed al phpBB nu poate fi instalat până când nu dezactivați, curățați și ștergeți toate fișierele legate de extensia s9e/mediaembed.',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/permissions_mediaembed.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/permissions_mediaembed.php"
+deleted file mode 100644
+index fe8235c2c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/permissions_mediaembed.php"
++++ /dev/null
+@@ -1,36 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-
+-$lang = array_merge($lang, [
+-	'ACL_F_MEDIAEMBED'		=> 'Poate folosi eticheta [media] BBCode',
+-	'ACL_U_PM_MEDIAEMBED'	=> 'Poate folosi eticheta [media] BBCode în mesajele private',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ru/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ru/acp.php"
+index cb5053dae..a90b82cb5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ru/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ru/acp.php"
+@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Настройки Media Embed',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Здесь вы можете настроить параметры для Media Embed.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Показывать <samp>[media]</samp> бб-код на странице размещения сообщений',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Показывать <samp>[MEDIA]</samp> бб-код на странице размещения сообщений',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Если это запрещено, кнопка бб-кода не отображается, но пользователи могут использовать <samp>[media]</samp> бб-код в своих сообщениях.',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Разрешить в подписях пользователей',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ru/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ru/help.php"
+index 939e837df..ca0ab1e74 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ru/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ru/help.php"
+@@ -41,11 +41,12 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA'			=> 'Встраивание мультимедиа',
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Как вставлять медиа с других сайтов в сообщения?',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Пользователи могут вставлять контент, например, видео и аудио с разрешенных сайтов, используя бб-код
+-										<strong>[media][/media]</strong>, или просто вставив поддерживаемую ссылку в текстовом формате. Например:<br><br>
++										<strong>[media][/media]</strong>, или просто вставив поддерживаемую ссылку в текстовом формате. Например:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Как говорилось выше, ссылка также может использоваться без бб-кода <strong>[media]</strong>.
+-										<br><br>Пример, показанный здесь, будет генерировать:<br><br>%2$s
+-										<br><br>Поддерживаются следующие сайты::<br><samp>%3$s.</samp>
+-										<br><br>Полную документацию о поддерживаемых сайтах и ​​URL-адресах смотрите на странице <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++										<br /><br />Как говорилось выше, ссылка также может использоваться без бб-кода <strong>[media]</strong>.
++										<br /><br />Пример, показанный здесь, будет генерировать:<br /><br />%2$s
++										<br /><br />Поддерживаются следующие сайты::<br /><samp>%3$s.</samp>
++										<br /><br />Полную документацию о поддерживаемых сайтах и ​​URL-адресах смотрите на странице <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										Документация MediaEmbed</a>.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ru/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ru/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ru/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/sk/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/sk/acp.php"
+index 7bca02eda..defec34f7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/sk/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/sk/acp.php"
+@@ -24,7 +24,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Nastavenia vkladania médií',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Tu môžete konfigurovať nastavenia pre plugin vkladania médií.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zobraziť <samp>[media]</samp> BB kód pri prispievaní',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zobraziť <samp>[MEDIA]</samp> BB kód pri prispievaní',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Ak je toto nezaškrtnuté, BB kód nebude zobrazený, no používatelia budú môcť používať <samp>[media]</samp> kód v ich príspevkoch',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Povoliť v podpisoch',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/sk/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/sk/help.php"
+index 4ad418a7c..f0c698455 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/sk/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/sk/help.php"
+@@ -43,13 +43,14 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Ako vložiť obsah z inej stránky do príspevku',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Používatelia môžu vložiť obsah (napríklad video alebo zvuk z povolených stránok použítím
+ 										<strong>[media][/media]</strong> kódu alebo jednoducho odoslať podporovanú
+-										URL v texte. Napríklad:<br><br>
++										URL v texte. Napríklad:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Ako je uvedené vyššie, odkaz môže byť použitý bez
++										<br /><br />Ako je uvedené vyššie, odkaz môže byť použitý bez
+ 										<strong>[media]</strong> kódu.
+-										<br><br>Príklad zobrazený tuto vygeneruje:<br><br>%2$s
+-										<br><br>Podporované sú tieto stránky:<br><samp>%3$s.</samp>
+-										<br><br>Pre kompletnú dokumentáciu ohľadom podporovaných stránok a príkladov adries
++										<br /><br />Príklad zobrazený tuto vygeneruje:<br /><br />%2$s
++										<br /><br />Podporované sú tieto stránky:<br /><samp>%3$s.</samp>
++										<br /><br />Pre kompletnú dokumentáciu ohľadom podporovaných stránok a príkladov adries
+ 										navštívte <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										dokumentáciu pluginu vkladania médií</a> (v Angličtine).',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/sk/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/sk/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/sk/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/tr/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/tr/acp.php"
+index efe3af701..9994a895b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/tr/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/tr/acp.php"
+@@ -24,7 +24,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> 'Medya (Ortam) Yerleştirme Ayarları',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Buradan Medya (Ortam) Yerleştirme Eklentisi için ayarları yapabilirsiniz.',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> '<samp>[media]</samp> BBCode butonunu mesaj gönderme sayfasında göster',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> '<samp>[MEDIA]</samp> BBCode butonunu mesaj gönderme sayfasında göster',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'İzin verilmediği takdirde, BBCode butonu gösterilmeyecektir, ancak kullanıcılar hala <samp>[media]</samp> etiketini kendi mesajlarında kullanabilir',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Kullanıcı imzalarında izin ver',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/tr/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/tr/help.php"
+index 3f330137e..2516cc4b1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/tr/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/tr/help.php"
+@@ -43,13 +43,14 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Diğer sitelerden alınan medya(ortam) içerikleri mesajların içerisine nasıl yerleştirilir',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Kullanıcılar izin verilen sitelerden aldığı video ve ses gibi içerikleri
+ 										<strong>[media][/media]</strong> etiketlerini kullanarak, ya da düz metin içerisine desteklenen URL adreslerini basit bir şekilde ekleyerek
+-										mesajlara yerleştirebilir. Örneğin:<br><br>
++										mesajlara yerleştirebilir. Örneğin:<br /><br />
+ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>Yukarıda belirtildiği gibi, <strong>[media]</strong> etiketleri olmadan
++										<br /><br />Yukarıda belirtildiği gibi, <strong>[media]</strong> etiketleri olmadan
+ 										sadece bağlantılar da kullanılabilir.
+-										<br><br>Burada gösterilen örnek şu şekilde oluşturulacaktır:<br><br>%2$s
+-										<br><br>Şu siteler desteklenmektedir:<br><samp>%3$s.</samp>
+-										<br><br>Desteklenen siteler ve örnek URL adresleri hakkında tüm belgeler için,
++										<br /><br />Burada gösterilen örnek şu şekilde oluşturulacaktır:<br /><br />%2$s
++										<br /><br />Şu siteler desteklenmektedir:<br /><samp>%3$s.</samp>
++										<br /><br />Desteklenen siteler ve örnek URL adresleri hakkında tüm belgeler için,
+ 										<a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										MediaEmbed Plugin Belgeleri</a> sayfasını ziyaret edin.',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/tr/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/tr/ucp.php"
+deleted file mode 100644
+index 810e49083..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/tr/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>Embedded Content from Other Websites</h3>
+-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
+-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
+-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hans/acp.php"
+index 6fa9f8fa3..a5eea8488 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hans/acp.php"
+@@ -21,10 +21,10 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, [
+ 	// Settings
+-	'ACP_MEDIA_SETTINGS'				=> 'Media Embed 设置',
++	'ACP_MEDIA_SETTINGS'				=> 'Media Embed Settings',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> '这里可设置 Media Embed PlugIn 的相关参数。',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> '在发帖页面显示 <samp>[media]</samp> BBCode',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> '在发帖页面显示 <samp>[MEDIA]</samp> BBCode',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> '若禁用， BBCode 按钮就不会显示，但用户还是可以在帖子中使用 <samp>[media]</samp> 标签。',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> '允许使用在用户签名',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hans/help.php"
+index 3fba339e4..3002815c8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hans/help.php"
+@@ -51,4 +51,5 @@ $lang = array_merge($lang, [
+ 										<br><br>下面这些网站可以使用：<br><samp>%3$s.</samp>
+ 										<br><br>访问 <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+ 										MediaEmbed Plugin Documentation</a> 可以查看完整的文档，包括支持的网站和网址列子。',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/permissions_mediaembed.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hans/permissions_mediaembed.php"
+index af76781bf..5450880c1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/permissions_mediaembed.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hans/permissions_mediaembed.php"
+@@ -1,8 +1,5 @@
+ <?php
+ /**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- * @简体中文语言　David Yin <https://www.phpbbchinese.com/>
+  *
+  * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+  *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/ucp.php"
+deleted file mode 100644
+index 7e4eca562..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/ucp.php"
++++ /dev/null
+@@ -1,32 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- * @简体中文语言　David Yin <https://www.phpbbchinese.com/>
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>来自其它网站的嵌入内容</h3>
+-		“%1$s” 的帖子或内容可能包含来自外部网站的嵌入内容，包括但不限于 YouTube，Facebook，Twitter，和其它类似的平台。来自这些外部网站的嵌入内容表现与你直接访问原始网站相同。
+-		<br><br>这些外部网站可能会收集有关你的数据，使用 cookie，嵌入第三方的跟踪功能，以及监察你同这些嵌入内容的互动，包括在你拥有账户并登入该网站的情况下的跟踪你的互动。
+-		<br><br>请注意，此类活动不受 “%1$s” 的控制，并受相应外部网站的隐私证词和服务条款的约束。我们建议你查看通过嵌入内容与之互动的任何第三方服务的隐私和 Cookie 政策。
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hant/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hant/acp.php"
+index e0848e4e3..f5bde5dbf 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hant/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hant/acp.php"
+@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
+ 	'ACP_MEDIA_SETTINGS'				=> '媒體嵌入設置',
+ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> '您可以在此處配置媒體嵌入外掛的設定。',
+ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
+-	'ACP_MEDIA_DISPLAY_BBCODE'			=> '顯示 <samp>[media]</samp> BBCode 在發文的頁面',
++	'ACP_MEDIA_DISPLAY_BBCODE'			=> '顯示 <samp>[MEDIA]</samp> BBCode 在發文的頁面',
+ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> '如果不允許，BBCode 按鈕將不會顯示，但會員仍然可以在他們的文章中使用 <samp>[media]</samp> 標籤。',
+ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+ 	'ACP_MEDIA_ALLOW_SIG'				=> '允許會員簽名',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hant/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hant/help.php"
+index 215a16faf..a206cb97e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hant/help.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hant/help.php"
+@@ -41,9 +41,10 @@ $lang = array_merge($lang, [
+ 	'HELP_EMBEDDING_MEDIA'			=> '嵌入媒體',
+ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> '如何將來自其他網站的媒體嵌入到文章中',
+ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> '會員可以使用 <strong>[media][/media]</strong> 標籤嵌入來自允許網站的視頻和音頻等內容，或者簡單地以純文本形式發表受支持的網址。例如：
+-										<br><br><strong>[media]</strong>%1$s<strong>[/media]</strong>
+-										<br><br>如上所述，連結也可以在沒有 <strong>[media]</strong> 標籤的情況下使用。
+-										<br><br>此處顯示的範例將生成：<br><br>%2$s
+-										<br><br>支持以下站點：<br><samp>%3$s</samp>。
+-										<br><br>有關受支持站點和範例網址的完整文件，參訪 <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">MediaEmbed Plugin Documentation</a>。',
++										<br /><br /><strong>[media]</strong>%1$s<strong>[/media]</strong>
++										<br /><br />如上所述，連結也可以在沒有 <strong>[media]</strong> 標籤的情況下使用。
++										<br /><br />此處顯示的範例將生成：<br /><br />%2$s
++										<br /><br />支持以下站點：<br /><samp>%3$s</samp>。
++										<br /><br />有關受支持站點和範例網址的完整文件，參訪 <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">MediaEmbed Plugin Documentation</a>。',
++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hant/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hant/ucp.php"
+deleted file mode 100644
+index 0d18e0919..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hant/ucp.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- * @正體中文化 竹貓星球 <http://phpbb-tw.net/phpbb/>
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'MEDIA_EMBED_PRIVACY_POLICY' => '
+-		<br><br>
+-		<h3>其他網站的嵌入內容</h3>
+-		「%1$s」可能包含嵌入外部網站（包括但不限於 YouTube、Facebook、Twitter 及類似平台）的貼文或內容。嵌入來自這些外部網站的內容的行為與您直接訪問原始網站的行為相同。
+-		<br><br>這些外部網站可能會收集您的資料、使用 Cookies、嵌入額外的第三方追蹤程式並監控您與嵌入內容的互動，包括在您擁有帳戶並登入網站的情況下追蹤您的互動。
+-		<br><br>請注意，此類活動不受「%1$s」的控制，並受相應外部網站的隱私權政策和服務條款約束。我們建議您查看透過嵌入內容與之互動的任何第三方服務的隱私權和 Cookies 政策。
+-	',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/event/overall_header_stylesheets_after.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/BBOOTS/template/event/posting_editor_buttons_custom_tags_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/BBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
+new file mode 100644
+index 000000000..5a461b493
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/BBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
+@@ -0,0 +1,5 @@
++{% if S_BBCODE_MEDIA %}
++<button type="button" class="btn btn-default bbcode-media" accesskey="m" name="addmedia" value="Media" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}">
++	<i class="fa fa-television fa-fw" aria-hidden="true"></i>
++</button>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+new file mode 100644
+index 000000000..30246b6a7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+@@ -0,0 +1,10 @@
++{% if S_MEDIA_EMBED_FULL_WIDTH or S_MEDIA_EMBED_MAX_WIDTHS %}
++<style>
++{% if S_MEDIA_EMBED_FULL_WIDTH %}
++	[data-s9e-mediaembed] { max-width: 100% !important; }
++{% endif %}
++{% for item in S_MEDIA_EMBED_MAX_WIDTHS %}
++	[data-s9e-mediaembed="{{ item.site }}"] { max-width: {{ item.width }} !important; }
++{% endfor %}
++</style>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/FLATBOOTS/template/event/posting_editor_buttons_custom_tags_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/FLATBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
+new file mode 100644
+index 000000000..5a461b493
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/FLATBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
+@@ -0,0 +1,5 @@
++{% if S_BBCODE_MEDIA %}
++<button type="button" class="btn btn-default bbcode-media" accesskey="m" name="addmedia" value="Media" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}">
++	<i class="fa fa-television fa-fw" aria-hidden="true"></i>
++</button>
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/media_embed_bbcode_icon.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/media_embed_bbcode_icon.html"
+deleted file mode 100644
+index bf5f0de9e..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/media_embed_bbcode_icon.html"
++++ /dev/null
+@@ -1,2 +0,0 @@
+-{# This template will be used in phpBB 4 #}
+-{{ Icon('font', 'tv', '', true, 'fas c-button-icon') }}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/prosilver/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/prosilver/template/event/overall_header_stylesheets_after.html"
+new file mode 100644
+index 000000000..30246b6a7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/prosilver/template/event/overall_header_stylesheets_after.html"
+@@ -0,0 +1,10 @@
++{% if S_MEDIA_EMBED_FULL_WIDTH or S_MEDIA_EMBED_MAX_WIDTHS %}
++<style>
++{% if S_MEDIA_EMBED_FULL_WIDTH %}
++	[data-s9e-mediaembed] { max-width: 100% !important; }
++{% endif %}
++{% for item in S_MEDIA_EMBED_MAX_WIDTHS %}
++	[data-s9e-mediaembed="{{ item.site }}"] { max-width: {{ item.width }} !important; }
++{% endfor %}
++</style>
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/event/posting_editor_buttons_custom_tags_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/prosilver/template/event/posting_editor_buttons_custom_tags_before.html"
+similarity index 54%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/event/posting_editor_buttons_custom_tags_before.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/prosilver/template/event/posting_editor_buttons_custom_tags_before.html"
+index 7f6dfd94e..16087f78c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/event/posting_editor_buttons_custom_tags_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/prosilver/template/event/posting_editor_buttons_custom_tags_before.html"
+@@ -1,9 +1,5 @@
+ {% if S_BBCODE_MEDIA %}
+ <button type="button" class="button button-icon-only bbcode-media" accesskey="m" name="addmedia" value="Media" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}">
+-	{% if constant('PHPBB_VERSION') starts with '4' %}
+-		{{ include('@phpbb_mediaembed/media_embed_bbcode_icon.html') }}
+-	{% else %}
+-		<i class="icon fa-television fa-fw" aria-hidden="true"></i>
+-	{% endif %}
++	<i class="icon fa-television fa-fw" aria-hidden="true"></i>
+ </button>
+ {% endif %}
diff --git "[FORUM_EXT]/phpbb\\mediaembed/diff_nospace.tmp" "[FORUM_EXT]/phpbb\\mediaembed/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\mediaembed/diff_nospace.tmp"
@@ -0,0 +1,3141 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/CHANGELOG.md"
+index b54717eba..5e76d820a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/CHANGELOG.md"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/CHANGELOG.md"
+@@ -1,31 +1,5 @@
+ # Changelog
+ 
+-### 2.0.5 - 2026-03-21
+-
+-- Added and/or updated support for media sites:
+-	- Facebook
+-	- vk.com
+-
+-### 2.0.4 - 2025-12-16
+-
+-- Fixed problems with YouTube not playing videos due to YouTube's referrerer policy.
+-- Ensure and future-proof compatibility with phpBB4.
+-- Added language packs:
+-	- Romanian
+-
+-### 2.0.3 - 2025-09-20
+-
+-- Added an amendment to the forum privacy policy regarding how embedded content may affect user privacy.
+-- Updated YouTube to use their enhanced privacy feature (no cookies until you play a video).
+-- Fixed an issue in the BBCode FAQ media embed example.
+-- Fixed issues in the language files.
+-- Removed the last traces of old XHTML code.
+-- Added and/or updated support for media sites:
+-  - Apple Podcasts
+-  - Bluesky
+-  - Pastebin
+-  - x.com (aka Twitter)
+-
+ ### 2.0.2 - 2024-01-21
+ 
+ - Small QoL improvement in the ACP, added sample placeholder data to the custom max-width field in the content-sizing settings.
+@@ -50,9 +24,9 @@
+ 
+ - Backwards incompatible changes require a new minimum phpBB version of 3.3.2.
+ - New ACP options for custom content sizing:
+-  - Added a new setting to enlarge most embedded content to fit 100% of the width of the post-area.
++  - Added a new setting to enlarge most embedded content to fit 100% of the width of the post area.
+   - Added a new setting to define custom maximum widths in pixels or percent for individual sites.
+-- Fixed issues for new installations that would fail if any of phpBB's default forum roles were missing.
++- Fixed issues for new installs that would fail if any of phpBB's default forum roles were missing.
+ - Added language packs:
+   - Portuguese
+   - Chinese (traditional)
+@@ -110,10 +84,10 @@ on adding and creating new site YAML files for MediaEmbed.
+ ### 1.0.2 - 2018-06-25
+ 
+ - Added a global setting to enable or disable the conversion of plain URLs into embedded content.
+-- Added a forum-based permission, allowing control over who can post embedded content in specific forums.
+-- Added a user-based private messages permission, allowing control over who can post embedded content in their private messages.
++- Added a forum based permission, allowing control over who can post embedded content in specific forums.
++- Added a user based private messages permission, allowing control over who can post embedded content in their private messages.
+ - Fixed an issue where embedded content could still be posted by users who did not have permission to use BBCodes in a specific forum.
+-- Fixed an issue where embedded content could still be posted even though the Disable BBCode option was checked in the post-editor.
++- Fixed an issue where embedded content could still be posted even though the Disable BBCode option was checked in the post editor.
+ - When users disable the option to automatically parse URLs in their post, plain URLs will no longer be converted to embedded content either.
+ 
+ ### 1.0.1 - 2017-08-04
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
+index f12acc45c..74e5ee47a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
+@@ -22,7 +22,7 @@
+ 					<td style="width: 25%;">
+ 						{% if site %}
+ 							<label style="font-size: 1em;" title="{{ site.title }}">
+-								<input type="checkbox" class="radio" name="mark[]" value="{{ site.id }}"{% if site.disabled %} disabled{% elseif site.enabled %} checked{% endif %}> {{ site.name }}
++								<input type="checkbox" class="radio" name="mark[]" value="{{ site.id }}"{% if site.disabled %} disabled{% elseif site.enabled %} checked{% endif %} /> {{ site.name }}
+ 							</label>
+ 						{% endif %}
+ 					</td>
+@@ -38,8 +38,8 @@
+ 		<p class="small"><a href="#" data-marksites="true">{{ lang('MARK_ALL') }}</a> &bull; <a href="#" data-marksites="false">{{ lang('UNMARK_ALL') }}</a></p>
+ 	</fieldset>
+ 	<p id="buttons" class="submit-buttons">
+-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
+-		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
++		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+ 	</p>
+ 	{{ S_FORM_TOKEN }}
+ </form>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
+index bd6a9db66..4823e920c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
+@@ -8,51 +8,51 @@
+ 	<fieldset>
+ 		<legend>{{ lang('ACP_MEDIA_BBCODE_LEGEND') }}</legend>
+ 		<dl>
+-			<dt><label for="media_embed_bbcode">{{ lang('ACP_MEDIA_DISPLAY_BBCODE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN') }}</span></dt>
+-			<dd><label><input type="radio" class="radio" name="media_embed_bbcode" id="media_embed_bbcode" value="1" {% if S_MEDIA_EMBED_BBCODE %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="media_embed_bbcode" value="0"{% if not S_MEDIA_EMBED_BBCODE %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++			<dt><label for="media_embed_bbcode">{{ lang('ACP_MEDIA_DISPLAY_BBCODE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN') }}</span></dt>
++			<dd><label><input type="radio" class="radio" name="media_embed_bbcode" id="media_embed_bbcode" value="1" {% if S_MEDIA_EMBED_BBCODE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="media_embed_bbcode" value="0"{% if not S_MEDIA_EMBED_BBCODE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 		</dl>
+ 	</fieldset>
+ 	<fieldset>
+ 		<legend>{{ lang('ACP_MEDIA_OPTIONS_LEGEND') }}</legend>
+ 		<dl>
+-			<dt><label for="media_embed_allow_sig">{{ lang('ACP_MEDIA_ALLOW_SIG') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_ALLOW_SIG_EXPLAIN') }}</span></dt>
+-			<dd><label><input type="radio" class="radio" name="media_embed_allow_sig" id="media_embed_allow_sig" value="1" {% if S_MEDIA_EMBED_ALLOW_SIG %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="media_embed_allow_sig" value="0"{% if not S_MEDIA_EMBED_ALLOW_SIG %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++			<dt><label for="media_embed_allow_sig">{{ lang('ACP_MEDIA_ALLOW_SIG') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_ALLOW_SIG_EXPLAIN') }}</span></dt>
++			<dd><label><input type="radio" class="radio" name="media_embed_allow_sig" id="media_embed_allow_sig" value="1" {% if S_MEDIA_EMBED_ALLOW_SIG %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="media_embed_allow_sig" value="0"{% if not S_MEDIA_EMBED_ALLOW_SIG %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="media_embed_parse_urls">{{ lang('ACP_MEDIA_PARSE_URLS') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_PARSE_URLS_EXPLAIN') }}</span></dt>
+-			<dd><label><input type="radio" class="radio" name="media_embed_parse_urls" id="media_embed_parse_urls" value="1" {% if S_MEDIA_EMBED_PARSE_URLS %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="media_embed_parse_urls" value="0"{% if not S_MEDIA_EMBED_PARSE_URLS %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++			<dt><label for="media_embed_parse_urls">{{ lang('ACP_MEDIA_PARSE_URLS') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_PARSE_URLS_EXPLAIN') }}</span></dt>
++			<dd><label><input type="radio" class="radio" name="media_embed_parse_urls" id="media_embed_parse_urls" value="1" {% if S_MEDIA_EMBED_PARSE_URLS %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="media_embed_parse_urls" value="0"{% if not S_MEDIA_EMBED_PARSE_URLS %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 		</dl>
+ 	</fieldset>
+ 	<fieldset>
+ 		<legend>{{ lang('ACP_MEDIA_CACHE_LEGEND') }}</legend>
+ 		<dl>
+-			<dt><label for="media_embed_enable_cache">{{ lang('ACP_MEDIA_ENABLE_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_ENABLE_CACHE_EXPLAIN') }}</span></dt>
+-			<dd><label><input type="radio" class="radio" name="media_embed_enable_cache" id="media_embed_enable_cache" value="1" {% if S_MEDIA_EMBED_ENABLE_CACHE %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="media_embed_enable_cache" value="0"{% if not S_MEDIA_EMBED_ENABLE_CACHE %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++			<dt><label for="media_embed_enable_cache">{{ lang('ACP_MEDIA_ENABLE_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_ENABLE_CACHE_EXPLAIN') }}</span></dt>
++			<dd><label><input type="radio" class="radio" name="media_embed_enable_cache" id="media_embed_enable_cache" value="1" {% if S_MEDIA_EMBED_ENABLE_CACHE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="media_embed_enable_cache" value="0"{% if not S_MEDIA_EMBED_ENABLE_CACHE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="action_purge_cache">{{ lang('ACP_MEDIA_PURGE_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_PURGE_CACHE_EXPLAIN') }}</span></dt>
+-			<dd><input class="button2" type="submit" id="action_purge_cache" name="action_purge_cache" value="{{ lang('PURGE_CACHE') }}"></dd>
++			<dt><label for="action_purge_cache">{{ lang('ACP_MEDIA_PURGE_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_PURGE_CACHE_EXPLAIN') }}</span></dt>
++			<dd><input class="button2" type="submit" id="action_purge_cache" name="action_purge_cache" value="{{ lang('PURGE_CACHE') }}" /></dd>
+ 		</dl>
+ 	</fieldset>
+ 	<fieldset>
+ 		<legend>{{ lang('ACP_MEDIA_WIDTH_LEGEND') }}</legend>
+ 		<dl>
+-			<dt><label for="media_embed_full_width">{{ lang('ACP_MEDIA_FULL_WIDTH') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_FULL_WIDTH_EXPLAIN') }}</span></dt>
+-			<dd><label><input type="radio" class="radio" name="media_embed_full_width" id="media_embed_full_width" value="1" {% if S_MEDIA_EMBED_FULL_WIDTH %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="media_embed_full_width" value="0"{% if not S_MEDIA_EMBED_FULL_WIDTH %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++			<dt><label for="media_embed_full_width">{{ lang('ACP_MEDIA_FULL_WIDTH') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_FULL_WIDTH_EXPLAIN') }}</span></dt>
++			<dd><label><input type="radio" class="radio" name="media_embed_full_width" id="media_embed_full_width" value="1" {% if S_MEDIA_EMBED_FULL_WIDTH %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="media_embed_full_width" value="0"{% if not S_MEDIA_EMBED_FULL_WIDTH %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="media_embed_max_width">{{ lang('ACP_MEDIA_MAX_WIDTH') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_MAX_WIDTH_EXPLAIN') }}</span></dt>
++			<dt><label for="media_embed_max_width">{{ lang('ACP_MEDIA_MAX_WIDTH') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_MAX_WIDTH_EXPLAIN') }}</span></dt>
+ 			<dd><textarea id="media_embed_max_width" name="media_embed_max_width" rows="8" cols="40" style="width: 50%;" placeholder="twitter:100%&#10;youtube:80%&#10;funnyordie:480px">{{ S_MEDIA_EMBED_MAX_WIDTHS }}</textarea></dd>
+ 		</dl>
+ 	</fieldset>
+ 	<fieldset class="submit-buttons">
+-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
+-		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
++		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+ 		{{ S_FORM_TOKEN }}
+ 	</fieldset>
+ </form>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
+index f44d8e8b1..fdf64305d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
+@@ -1,3 +1,3 @@
+ {% if S_BBCODE_MEDIA %}
+-	<input type="button" class="button2" accesskey="m" name="addmedia" value="Media" style="width: 50px;" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}">
++	<input type="button" class="button2" accesskey="m" name="addmedia" value="Media" style="width: 50px;" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}" />
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml"
+deleted file mode 100644
+index 15f925af3..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml"
++++ /dev/null
+@@ -1,25 +0,0 @@
+-name: "Apple Podcasts"
+-homepage: "https://podcasts.apple.com/"
+-host: podcasts.apple.com
+-example:
+-    - https://podcasts.apple.com/us/podcast/the-office-deep-dive-with-brian-baumgartner/id1550331348
+-    - https://podcasts.apple.com/us/podcast/the-office-deep-dive-with-brian-baumgartner/id1550331348?i=1000514199106
+-extract:
+-    - "@podcasts.apple.com/(?'country'\\w+)/podcast/[-\\w%]*/id(?'podcast_id'\\d+)(?:\\?i=(?'episode_id'\\d+))?@"
+-choose:
+-    when:
+-        test: '@episode_id'
+-        iframe:
+-            allow: "autoplay *;encrypted-media *"
+-            width: "100%"
+-            height: "175"
+-            max-width: "900"
+-            src: "https://embed.podcasts.apple.com/{@country}/podcast/episode/id{@podcast_id}?i={@episode_id}"
+-    otherwise:
+-        iframe:
+-            allow: "autoplay *;encrypted-media *"
+-            width: "100%"
+-            height: "450"
+-            max-width: "900"
+-            src: "https://embed.podcasts.apple.com/{@country}/podcast/episode/id{@podcast_id}"
+-tags: "podcasts"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml"
+deleted file mode 100644
+index 2fbed75d0..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml"
++++ /dev/null
+@@ -1,25 +0,0 @@
+-attributes:
+-    embedder:
+-        filterChain: []
+-        required: true
+-    url:
+-        filterChain: "urldecode"
+-        required: true
+-example:
+-    - "https://bsky.app/profile/bsky.app/post/3kkrqzuydho2v"
+-    - "https://bsky.app/profile/bnewbold.net/post/3kxjq2auebs2f"
+-extract: "#^https://(?'embedder'[.\\w]+)/oembed.*?url=(?'url'[\\w%.]+)#"
+-homepage: "https://bsky.app/"
+-host: "bsky.app"
+-iframe:
+-    data-s9e-livepreview-ignore-attrs: style
+-    height: 600
+-    onload: "let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])"
+-    src: "https://s9e.github.io/iframe/2/bluesky.min.html#<xsl:value-of select=\"@url\"/>#<xsl:value-of select=\"@embedder\"/>"
+-    width: 600
+-name: "Bluesky"
+-scrape:
+-    extract: "#https://(?'embedder'[.\\w]+)/oembed.*?url=(?'url'[\\w%.]+)#"
+-    match: "#/profile/[^/]+/post/.#"
+-source: "https://embed.bsky.app/"
+-tags: "social"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml"
+deleted file mode 100644
+index a1a297235..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml"
++++ /dev/null
+@@ -1,50 +0,0 @@
+-name: Facebook
+-homepage: https://www.facebook.com/
+-tags: social
+-host:
+-    - facebook.com
+-    - fb.watch
+-example:
+-    - https://www.facebook.com/MetaforDevelopers/posts/451016937058647
+-    - https://www.facebook.com/watch/?v=224353158889229
+-    - https://fb.watch/3zYsXdnxjf/
+-    - https://www.facebook.com/reel/873906321076441
+-extract:
+-    - "@facebook.com/.*?(?:fbid=|/permalink/|\\?v=)(?'id'\\d+)@"
+-    - "@facebook.com/(?'user'[.\\w]+)/(?'type'[pv])(?:ost|ideo)s?/(?:[-%.\\w]+/)?(?'id'\\d+)\\b@"
+-    - "@facebook.com/video/(?=post|video)(?'type'[pv])@"
+-    - "@facebook.com/events/(?'id'\\d+)\\b(?!/permalink)@"
+-    - "@facebook.com/watch/?(?'type'[pv])=@"
+-    - "@facebook.com/groups/[^/]*/(?'type'p)osts/(?'id'\\d+)@"
+-    - "@facebook.com/(?'user'[.\\w]+)/posts/pfbid(?'pfbid'\\w+)@"
+-    - "@facebook.com/permalink.php?story_fbid=(?:(?'id'\\d+)|pfbid(?'pfbid'\\w+))&id=(?'page_id'\\d+)@"
+-    - "@facebook.com/(?'type'r)eel/(?'id'\\d+)@"
+-scrape:
+-    - extract: "@facebook.com/(?'user'[.\\w]+)/(?'type'[pv])\\w+/(?'id'\\d+)(?!\\w)@"
+-      header: "User-agent: PHP (not Mozilla)"
+-      match: "@facebook.com/[.\\w]+/posts/pfbid@"
+-      url: https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2F{@user}%2Fposts%2Fpfbid{@pfbid}
+-    - extract: "@story_fbid=(?'id'\\d+)@"
+-      header: "User-agent: PHP (not Mozilla)"
+-      match: "@facebook.com/permalink.php?story_fbid=pfbid(?'pfbid'\\w+)&id=(?'page_id'\\d+)@"
+-      url: https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fpermalink.php%3Fstory_fbid%3Dpfbid{@pfbid}%26id%3D{@page_id}
+-    - extract:
+-        - "@facebook.com/watch/?(?'type'v)=(?'id'\\d+)@"
+-        - "@facebook.com/(?'user'[.\\w]+)/(?'type'v)ideos/(?'id'\\d+)@"
+-      header: "User-agent: PHP (not Mozilla)"
+-      match: "@fb.watch/.@"
+-    - extract:
+-        - "@facebook.com/\\w+/(?'user'[.\\w]+)/permalink/(?'id'\\d+)(?!\\w)@"
+-        - "@og:url[^>]+facebook.com/(?'user'[.\\w]+)/(?'type'[pv])(?:ost|ideo)s?/(?:[-\\w%]+/)?(?'id'\\d+)\\b@"
+-      header: "User-agent: PHP (not Mozilla)"
+-      match: "@facebook.com/share/[pv]/\\w@"
+-iframe:
+-    data-s9e-livepreview-ignore-attrs: style
+-    onload: let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])
+-    src: https://s9e.github.io/iframe/2/facebook.min.html#<xsl:choose><xsl:when test="@user"><xsl:value-of select="@user"/>/<xsl:choose><xsl:when test="@type='r'or@type='v'">video</xsl:when><xsl:otherwise>post</xsl:otherwise></xsl:choose>s/<xsl:choose><xsl:when test="@id"><xsl:value-of select="@id"/></xsl:when><xsl:otherwise>pfbid<xsl:value-of select="@pfbid"/></xsl:otherwise></xsl:choose></xsl:when><xsl:when test="@id"><xsl:value-of select="@type"/><xsl:value-of select="@id"/></xsl:when><xsl:otherwise>pfbid<xsl:value-of select="@pfbid"/></xsl:otherwise></xsl:choose>
+-amp:
+-    custom-element: "amp-facebook"
+-    src: "https://cdn.ampproject.org/v0/amp-facebook-0.1.js"
+-    template: <amp-facebook layout="responsive" width="640" height="360"><xsl:if test="starts-with(@type,'v')"><xsl:attribute name="data-embed-as">video</xsl:attribute></xsl:if><xsl:attribute name="data-href">https://www.facebook.com/<xsl:choose><xsl:when test="@user"><xsl:value-of select="@user"/></xsl:when><xsl:otherwise>user</xsl:otherwise></xsl:choose>/<xsl:choose><xsl:when test="starts-with(@type,'v')">video</xsl:when><xsl:otherwise>post</xsl:otherwise></xsl:choose>s/<xsl:value-of select="@id"/></xsl:attribute></amp-facebook>
+-attributes: []
+-tracking_policy: https://www.facebook.com/help/1896641480634370
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml"
+deleted file mode 100644
+index 1efb6f379..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml"
++++ /dev/null
+@@ -1,12 +0,0 @@
+-name: Pastebin
+-host: pastebin.com
+-example:
+-    - "https://pastebin.com/9jEf44nc"
+-    - "https://pastebin.com/9jEf44nc?theme=dark"
+-extract: "#pastebin\\.com/(?!u/)(?:\\w+(?:\\.php\\?i=|/))?(?'id'\\w+)(?'dark'\\?theme=dark)?#"
+-iframe:
+-    scrolling: "yes"
+-    width: "100%"
+-    height: "300"
+-    style: ["border:none;resize:vertical;width:100%"]
+-    src: //pastebin.com/embed_iframe/{@id}{@dark}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/twitter.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
+index b05309020..5ac8c93d5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
+@@ -14,10 +14,6 @@ iframe:
+     data-s9e-livepreview-ignore-attrs: "style"
+     onload: "let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])"
+     width: "550"
+-    height: "350"
++    height: "273"
+     allow: "autoplay *"
+-    src: https://s9e.github.io/iframe/2/twitter.min.html#<xsl:value-of select="@id"/><xsl:if test="$MEDIAEMBED_THEME">#theme=<xsl:value-of select="$MEDIAEMBED_THEME"/></xsl:if>
+-amp:
+-    custom-element: amp-twitter
+-    src: https://cdn.ampproject.org/v0/amp-twitter-0.1.js
+-    template: '<amp-twitter layout="responsive" width="550" height="273" data-tweetid="{@id}"><blockquote placeholder=""><a href="https://twitter.com/user/status/{@id}">X</a></blockquote></amp-twitter>'
++    src: https://s9e.github.io/iframe/2/twitter.min.html#<xsl:value-of select="@id"/><xsl:if test="$MEDIAEMBED_THEME='dark'">#theme=dark</xsl:if>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml"
+deleted file mode 100644
+index 17959bd01..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml"
++++ /dev/null
+@@ -1,30 +0,0 @@
+-name: "VK"
+-homepage: "https://vk.com/"
+-tags: ".ru"
+-host:
+-    - "vk.com"
+-    - "vkontakte.ru"
+-    - "vkvideo.ru"
+-example:
+-    - "https://vk.com/video121599878_165723901?hash=e06b0878046e1d32"
+-    - "https://vk.com/video_ext.php?oid=121599878&id=165723901&hash=e06b0878046e1d32"
+-attributes:
+-    oid:
+-        required: true
+-    vid:
+-        required: true
+-extract:
+-    - "!video(?'oid'-?\\d+)_(?'vid'\\d+)!"
+-    - "!video_ext\\.php\\?oid=(?'oid'-?\\d+)&id=(?'vid'\\d+)!"
+-    - "!hash=(?'hash'[0-9a-f]+)!"
+-    - "!hd=(?'hd'\\d)!"
+-iframe:
+-    src: "//vk.com/video_ext.php?oid={@oid}&id={@vid}&hash={@hash}&hd={@hd}"
+-scrape:
+-    extract:
+-        - "#meta property=\"og:video\" content=\".*?oid=(?'oid'-?\\d+).*?id=(?'vid'\\d+)#"
+-        - "#meta property=\"og:video\" content=\".*?hash=(?'hash'[0-9a-f]+)#"
+-    match: "#^(?!.*?hash=)#"
+-    header:
+-        - "User-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36"
+-        - "Cookie: _ignoreAutoLogin=1"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/composer.json"
+index a301fcfa0..3275bb192 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/composer.json"
+@@ -3,7 +3,7 @@
+     "type": "phpbb-extension",
+     "description": "An official phpBB extension that allows users to embed content from allowed sites using a [media] BBCode, or from simply posting a supported URL in plain text.",
+     "homepage": "https://www.phpbb.com/customise/db/extension/mediaembed/",
+-    "version": "2.0.5",
++    "version": "2.0.2",
+     "license": "GPL-2.0-only",
+     "authors": [
+         {
+@@ -31,11 +31,11 @@
+     ],
+     "require": {
+         "php": ">=7.1.3",
+-        "composer/installers": "^1.0 || ^2.0",
++        "composer/installers": "~1.0.0",
+         "phpbb/phpbb": ">=3.3.2"
+     },
+     "require-dev": {
+-        "phing/phing": "~2.4"
++        "phing/phing": "2.4.*"
+     },
+     "extra": {
+         "display-name": "phpBB Media Embed PlugIn",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/diff_full.tmp"
+new file mode 100644
+index 000000000..defb23406
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/diff_full.tmp"
+@@ -0,0 +1,2772 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/CHANGELOG.md"
++index b54717eba..5e76d820a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/CHANGELOG.md"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/CHANGELOG.md"
++@@ -1,41 +1,15 @@
++ # Changelog
++ 
++-### 2.0.5 - 2026-03-21
++-
++-- Added and/or updated support for media sites:
++-	- Facebook
++-	- vk.com
++-
++-### 2.0.4 - 2025-12-16
++-
++-- Fixed problems with YouTube not playing videos due to YouTube's referrerer policy.
++-- Ensure and future-proof compatibility with phpBB4.
++-- Added language packs:
++-	- Romanian
++-
++-### 2.0.3 - 2025-09-20
++-
++-- Added an amendment to the forum privacy policy regarding how embedded content may affect user privacy.
++-- Updated YouTube to use their enhanced privacy feature (no cookies until you play a video).
++-- Fixed an issue in the BBCode FAQ media embed example.
++-- Fixed issues in the language files.
++-- Removed the last traces of old XHTML code.
++-- Added and/or updated support for media sites:
++-  - Apple Podcasts
++-  - Bluesky
++-  - Pastebin
++-  - x.com (aka Twitter)
++-
++ ### 2.0.2 - 2024-01-21
++ 
++ - Small QoL improvement in the ACP, added sample placeholder data to the custom max-width field in the content-sizing settings.
++ - Minor code updates.
++ - Added and/or updated support for media sites:
++-  - Apple Music
++-  - x.com (aka Twitter)
++-  - kick.com
++-  - Threads
++-  - Bunny Stream
+++	- Apple Music
+++	- x.com (aka Twitter)
+++	- kick.com
+++	- Threads
+++    - Bunny Stream
++ 
++ ### 2.0.1 - 2023-04-15
++ 
++@@ -50,9 +24,9 @@
++ 
++ - Backwards incompatible changes require a new minimum phpBB version of 3.3.2.
++ - New ACP options for custom content sizing:
++-  - Added a new setting to enlarge most embedded content to fit 100% of the width of the post-area.
+++  - Added a new setting to enlarge most embedded content to fit 100% of the width of the post area.
++   - Added a new setting to define custom maximum widths in pixels or percent for individual sites.
++-- Fixed issues for new installations that would fail if any of phpBB's default forum roles were missing.
+++- Fixed issues for new installs that would fail if any of phpBB's default forum roles were missing.
++ - Added language packs:
++   - Portuguese
++   - Chinese (traditional)
++@@ -110,10 +84,10 @@ on adding and creating new site YAML files for MediaEmbed.
++ ### 1.0.2 - 2018-06-25
++ 
++ - Added a global setting to enable or disable the conversion of plain URLs into embedded content.
++-- Added a forum-based permission, allowing control over who can post embedded content in specific forums.
++-- Added a user-based private messages permission, allowing control over who can post embedded content in their private messages.
+++- Added a forum based permission, allowing control over who can post embedded content in specific forums.
+++- Added a user based private messages permission, allowing control over who can post embedded content in their private messages.
++ - Fixed an issue where embedded content could still be posted by users who did not have permission to use BBCodes in a specific forum.
++-- Fixed an issue where embedded content could still be posted even though the Disable BBCode option was checked in the post-editor.
+++- Fixed an issue where embedded content could still be posted even though the Disable BBCode option was checked in the post editor.
++ - When users disable the option to automatically parse URLs in their post, plain URLs will no longer be converted to embedded content either.
++ 
++ ### 1.0.1 - 2017-08-04
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
++index f12acc45c..74e5ee47a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
++@@ -22,7 +22,7 @@
++ 					<td style="width: 25%;">
++ 						{% if site %}
++ 							<label style="font-size: 1em;" title="{{ site.title }}">
++-								<input type="checkbox" class="radio" name="mark[]" value="{{ site.id }}"{% if site.disabled %} disabled{% elseif site.enabled %} checked{% endif %}> {{ site.name }}
+++								<input type="checkbox" class="radio" name="mark[]" value="{{ site.id }}"{% if site.disabled %} disabled{% elseif site.enabled %} checked{% endif %} /> {{ site.name }}
++ 							</label>
++ 						{% endif %}
++ 					</td>
++@@ -38,8 +38,8 @@
++ 		<p class="small"><a href="#" data-marksites="true">{{ lang('MARK_ALL') }}</a> &bull; <a href="#" data-marksites="false">{{ lang('UNMARK_ALL') }}</a></p>
++ 	</fieldset>
++ 	<p id="buttons" class="submit-buttons">
++-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
++-		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
+++		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+++		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
++ 	</p>
++ 	{{ S_FORM_TOKEN }}
++ </form>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
++index bd6a9db66..4823e920c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
++@@ -8,51 +8,51 @@
++ 	<fieldset>
++ 		<legend>{{ lang('ACP_MEDIA_BBCODE_LEGEND') }}</legend>
++ 		<dl>
++-			<dt><label for="media_embed_bbcode">{{ lang('ACP_MEDIA_DISPLAY_BBCODE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN') }}</span></dt>
++-			<dd><label><input type="radio" class="radio" name="media_embed_bbcode" id="media_embed_bbcode" value="1" {% if S_MEDIA_EMBED_BBCODE %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="media_embed_bbcode" value="0"{% if not S_MEDIA_EMBED_BBCODE %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+++			<dt><label for="media_embed_bbcode">{{ lang('ACP_MEDIA_DISPLAY_BBCODE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN') }}</span></dt>
+++			<dd><label><input type="radio" class="radio" name="media_embed_bbcode" id="media_embed_bbcode" value="1" {% if S_MEDIA_EMBED_BBCODE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="media_embed_bbcode" value="0"{% if not S_MEDIA_EMBED_BBCODE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 		</dl>
++ 	</fieldset>
++ 	<fieldset>
++ 		<legend>{{ lang('ACP_MEDIA_OPTIONS_LEGEND') }}</legend>
++ 		<dl>
++-			<dt><label for="media_embed_allow_sig">{{ lang('ACP_MEDIA_ALLOW_SIG') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_ALLOW_SIG_EXPLAIN') }}</span></dt>
++-			<dd><label><input type="radio" class="radio" name="media_embed_allow_sig" id="media_embed_allow_sig" value="1" {% if S_MEDIA_EMBED_ALLOW_SIG %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="media_embed_allow_sig" value="0"{% if not S_MEDIA_EMBED_ALLOW_SIG %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+++			<dt><label for="media_embed_allow_sig">{{ lang('ACP_MEDIA_ALLOW_SIG') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_ALLOW_SIG_EXPLAIN') }}</span></dt>
+++			<dd><label><input type="radio" class="radio" name="media_embed_allow_sig" id="media_embed_allow_sig" value="1" {% if S_MEDIA_EMBED_ALLOW_SIG %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="media_embed_allow_sig" value="0"{% if not S_MEDIA_EMBED_ALLOW_SIG %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="media_embed_parse_urls">{{ lang('ACP_MEDIA_PARSE_URLS') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_PARSE_URLS_EXPLAIN') }}</span></dt>
++-			<dd><label><input type="radio" class="radio" name="media_embed_parse_urls" id="media_embed_parse_urls" value="1" {% if S_MEDIA_EMBED_PARSE_URLS %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="media_embed_parse_urls" value="0"{% if not S_MEDIA_EMBED_PARSE_URLS %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+++			<dt><label for="media_embed_parse_urls">{{ lang('ACP_MEDIA_PARSE_URLS') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_PARSE_URLS_EXPLAIN') }}</span></dt>
+++			<dd><label><input type="radio" class="radio" name="media_embed_parse_urls" id="media_embed_parse_urls" value="1" {% if S_MEDIA_EMBED_PARSE_URLS %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="media_embed_parse_urls" value="0"{% if not S_MEDIA_EMBED_PARSE_URLS %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 		</dl>
++ 	</fieldset>
++ 	<fieldset>
++ 		<legend>{{ lang('ACP_MEDIA_CACHE_LEGEND') }}</legend>
++ 		<dl>
++-			<dt><label for="media_embed_enable_cache">{{ lang('ACP_MEDIA_ENABLE_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_ENABLE_CACHE_EXPLAIN') }}</span></dt>
++-			<dd><label><input type="radio" class="radio" name="media_embed_enable_cache" id="media_embed_enable_cache" value="1" {% if S_MEDIA_EMBED_ENABLE_CACHE %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="media_embed_enable_cache" value="0"{% if not S_MEDIA_EMBED_ENABLE_CACHE %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+++			<dt><label for="media_embed_enable_cache">{{ lang('ACP_MEDIA_ENABLE_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_ENABLE_CACHE_EXPLAIN') }}</span></dt>
+++			<dd><label><input type="radio" class="radio" name="media_embed_enable_cache" id="media_embed_enable_cache" value="1" {% if S_MEDIA_EMBED_ENABLE_CACHE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="media_embed_enable_cache" value="0"{% if not S_MEDIA_EMBED_ENABLE_CACHE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="action_purge_cache">{{ lang('ACP_MEDIA_PURGE_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_PURGE_CACHE_EXPLAIN') }}</span></dt>
++-			<dd><input class="button2" type="submit" id="action_purge_cache" name="action_purge_cache" value="{{ lang('PURGE_CACHE') }}"></dd>
+++			<dt><label for="action_purge_cache">{{ lang('ACP_MEDIA_PURGE_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_PURGE_CACHE_EXPLAIN') }}</span></dt>
+++			<dd><input class="button2" type="submit" id="action_purge_cache" name="action_purge_cache" value="{{ lang('PURGE_CACHE') }}" /></dd>
++ 		</dl>
++ 	</fieldset>
++ 	<fieldset>
++ 		<legend>{{ lang('ACP_MEDIA_WIDTH_LEGEND') }}</legend>
++ 		<dl>
++-			<dt><label for="media_embed_full_width">{{ lang('ACP_MEDIA_FULL_WIDTH') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_FULL_WIDTH_EXPLAIN') }}</span></dt>
++-			<dd><label><input type="radio" class="radio" name="media_embed_full_width" id="media_embed_full_width" value="1" {% if S_MEDIA_EMBED_FULL_WIDTH %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="media_embed_full_width" value="0"{% if not S_MEDIA_EMBED_FULL_WIDTH %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+++			<dt><label for="media_embed_full_width">{{ lang('ACP_MEDIA_FULL_WIDTH') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_FULL_WIDTH_EXPLAIN') }}</span></dt>
+++			<dd><label><input type="radio" class="radio" name="media_embed_full_width" id="media_embed_full_width" value="1" {% if S_MEDIA_EMBED_FULL_WIDTH %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="media_embed_full_width" value="0"{% if not S_MEDIA_EMBED_FULL_WIDTH %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="media_embed_max_width">{{ lang('ACP_MEDIA_MAX_WIDTH') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_MAX_WIDTH_EXPLAIN') }}</span></dt>
+++			<dt><label for="media_embed_max_width">{{ lang('ACP_MEDIA_MAX_WIDTH') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_MAX_WIDTH_EXPLAIN') }}</span></dt>
++ 			<dd><textarea id="media_embed_max_width" name="media_embed_max_width" rows="8" cols="40" style="width: 50%;" placeholder="twitter:100%&#10;youtube:80%&#10;funnyordie:480px">{{ S_MEDIA_EMBED_MAX_WIDTHS }}</textarea></dd>
++ 		</dl>
++ 	</fieldset>
++ 	<fieldset class="submit-buttons">
++-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
++-		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
+++		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+++		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
++ 		{{ S_FORM_TOKEN }}
++ 	</fieldset>
++ </form>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
++index f44d8e8b1..fdf64305d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
++@@ -1,3 +1,3 @@
++ {% if S_BBCODE_MEDIA %}
++-	<input type="button" class="button2" accesskey="m" name="addmedia" value="Media" style="width: 50px;" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}">
+++	<input type="button" class="button2" accesskey="m" name="addmedia" value="Media" style="width: 50px;" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}" />
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml"
++deleted file mode 100644
++index 15f925af3..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml"
+++++ /dev/null
++@@ -1,25 +0,0 @@
++-name: "Apple Podcasts"
++-homepage: "https://podcasts.apple.com/"
++-host: podcasts.apple.com
++-example:
++-    - https://podcasts.apple.com/us/podcast/the-office-deep-dive-with-brian-baumgartner/id1550331348
++-    - https://podcasts.apple.com/us/podcast/the-office-deep-dive-with-brian-baumgartner/id1550331348?i=1000514199106
++-extract:
++-    - "@podcasts.apple.com/(?'country'\\w+)/podcast/[-\\w%]*/id(?'podcast_id'\\d+)(?:\\?i=(?'episode_id'\\d+))?@"
++-choose:
++-    when:
++-        test: '@episode_id'
++-        iframe:
++-            allow: "autoplay *;encrypted-media *"
++-            width: "100%"
++-            height: "175"
++-            max-width: "900"
++-            src: "https://embed.podcasts.apple.com/{@country}/podcast/episode/id{@podcast_id}?i={@episode_id}"
++-    otherwise:
++-        iframe:
++-            allow: "autoplay *;encrypted-media *"
++-            width: "100%"
++-            height: "450"
++-            max-width: "900"
++-            src: "https://embed.podcasts.apple.com/{@country}/podcast/episode/id{@podcast_id}"
++-tags: "podcasts"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml"
++deleted file mode 100644
++index 2fbed75d0..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml"
+++++ /dev/null
++@@ -1,25 +0,0 @@
++-attributes:
++-    embedder:
++-        filterChain: []
++-        required: true
++-    url:
++-        filterChain: "urldecode"
++-        required: true
++-example:
++-    - "https://bsky.app/profile/bsky.app/post/3kkrqzuydho2v"
++-    - "https://bsky.app/profile/bnewbold.net/post/3kxjq2auebs2f"
++-extract: "#^https://(?'embedder'[.\\w]+)/oembed.*?url=(?'url'[\\w%.]+)#"
++-homepage: "https://bsky.app/"
++-host: "bsky.app"
++-iframe:
++-    data-s9e-livepreview-ignore-attrs: style
++-    height: 600
++-    onload: "let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])"
++-    src: "https://s9e.github.io/iframe/2/bluesky.min.html#<xsl:value-of select=\"@url\"/>#<xsl:value-of select=\"@embedder\"/>"
++-    width: 600
++-name: "Bluesky"
++-scrape:
++-    extract: "#https://(?'embedder'[.\\w]+)/oembed.*?url=(?'url'[\\w%.]+)#"
++-    match: "#/profile/[^/]+/post/.#"
++-source: "https://embed.bsky.app/"
++-tags: "social"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml"
++deleted file mode 100644
++index a1a297235..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml"
+++++ /dev/null
++@@ -1,50 +0,0 @@
++-name: Facebook
++-homepage: https://www.facebook.com/
++-tags: social
++-host:
++-    - facebook.com
++-    - fb.watch
++-example:
++-    - https://www.facebook.com/MetaforDevelopers/posts/451016937058647
++-    - https://www.facebook.com/watch/?v=224353158889229
++-    - https://fb.watch/3zYsXdnxjf/
++-    - https://www.facebook.com/reel/873906321076441
++-extract:
++-    - "@facebook.com/.*?(?:fbid=|/permalink/|\\?v=)(?'id'\\d+)@"
++-    - "@facebook.com/(?'user'[.\\w]+)/(?'type'[pv])(?:ost|ideo)s?/(?:[-%.\\w]+/)?(?'id'\\d+)\\b@"
++-    - "@facebook.com/video/(?=post|video)(?'type'[pv])@"
++-    - "@facebook.com/events/(?'id'\\d+)\\b(?!/permalink)@"
++-    - "@facebook.com/watch/?(?'type'[pv])=@"
++-    - "@facebook.com/groups/[^/]*/(?'type'p)osts/(?'id'\\d+)@"
++-    - "@facebook.com/(?'user'[.\\w]+)/posts/pfbid(?'pfbid'\\w+)@"
++-    - "@facebook.com/permalink.php?story_fbid=(?:(?'id'\\d+)|pfbid(?'pfbid'\\w+))&id=(?'page_id'\\d+)@"
++-    - "@facebook.com/(?'type'r)eel/(?'id'\\d+)@"
++-scrape:
++-    - extract: "@facebook.com/(?'user'[.\\w]+)/(?'type'[pv])\\w+/(?'id'\\d+)(?!\\w)@"
++-      header: "User-agent: PHP (not Mozilla)"
++-      match: "@facebook.com/[.\\w]+/posts/pfbid@"
++-      url: https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2F{@user}%2Fposts%2Fpfbid{@pfbid}
++-    - extract: "@story_fbid=(?'id'\\d+)@"
++-      header: "User-agent: PHP (not Mozilla)"
++-      match: "@facebook.com/permalink.php?story_fbid=pfbid(?'pfbid'\\w+)&id=(?'page_id'\\d+)@"
++-      url: https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fpermalink.php%3Fstory_fbid%3Dpfbid{@pfbid}%26id%3D{@page_id}
++-    - extract:
++-        - "@facebook.com/watch/?(?'type'v)=(?'id'\\d+)@"
++-        - "@facebook.com/(?'user'[.\\w]+)/(?'type'v)ideos/(?'id'\\d+)@"
++-      header: "User-agent: PHP (not Mozilla)"
++-      match: "@fb.watch/.@"
++-    - extract:
++-        - "@facebook.com/\\w+/(?'user'[.\\w]+)/permalink/(?'id'\\d+)(?!\\w)@"
++-        - "@og:url[^>]+facebook.com/(?'user'[.\\w]+)/(?'type'[pv])(?:ost|ideo)s?/(?:[-\\w%]+/)?(?'id'\\d+)\\b@"
++-      header: "User-agent: PHP (not Mozilla)"
++-      match: "@facebook.com/share/[pv]/\\w@"
++-iframe:
++-    data-s9e-livepreview-ignore-attrs: style
++-    onload: let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])
++-    src: https://s9e.github.io/iframe/2/facebook.min.html#<xsl:choose><xsl:when test="@user"><xsl:value-of select="@user"/>/<xsl:choose><xsl:when test="@type='r'or@type='v'">video</xsl:when><xsl:otherwise>post</xsl:otherwise></xsl:choose>s/<xsl:choose><xsl:when test="@id"><xsl:value-of select="@id"/></xsl:when><xsl:otherwise>pfbid<xsl:value-of select="@pfbid"/></xsl:otherwise></xsl:choose></xsl:when><xsl:when test="@id"><xsl:value-of select="@type"/><xsl:value-of select="@id"/></xsl:when><xsl:otherwise>pfbid<xsl:value-of select="@pfbid"/></xsl:otherwise></xsl:choose>
++-amp:
++-    custom-element: "amp-facebook"
++-    src: "https://cdn.ampproject.org/v0/amp-facebook-0.1.js"
++-    template: <amp-facebook layout="responsive" width="640" height="360"><xsl:if test="starts-with(@type,'v')"><xsl:attribute name="data-embed-as">video</xsl:attribute></xsl:if><xsl:attribute name="data-href">https://www.facebook.com/<xsl:choose><xsl:when test="@user"><xsl:value-of select="@user"/></xsl:when><xsl:otherwise>user</xsl:otherwise></xsl:choose>/<xsl:choose><xsl:when test="starts-with(@type,'v')">video</xsl:when><xsl:otherwise>post</xsl:otherwise></xsl:choose>s/<xsl:value-of select="@id"/></xsl:attribute></amp-facebook>
++-attributes: []
++-tracking_policy: https://www.facebook.com/help/1896641480634370
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml"
++deleted file mode 100644
++index 1efb6f379..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml"
+++++ /dev/null
++@@ -1,12 +0,0 @@
++-name: Pastebin
++-host: pastebin.com
++-example:
++-    - "https://pastebin.com/9jEf44nc"
++-    - "https://pastebin.com/9jEf44nc?theme=dark"
++-extract: "#pastebin\\.com/(?!u/)(?:\\w+(?:\\.php\\?i=|/))?(?'id'\\w+)(?'dark'\\?theme=dark)?#"
++-iframe:
++-    scrolling: "yes"
++-    width: "100%"
++-    height: "300"
++-    style: ["border:none;resize:vertical;width:100%"]
++-    src: //pastebin.com/embed_iframe/{@id}{@dark}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/twitter.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
++index b05309020..5ac8c93d5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
++@@ -14,10 +14,6 @@ iframe:
++     data-s9e-livepreview-ignore-attrs: "style"
++     onload: "let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])"
++     width: "550"
++-    height: "350"
+++    height: "273"
++     allow: "autoplay *"
++-    src: https://s9e.github.io/iframe/2/twitter.min.html#<xsl:value-of select="@id"/><xsl:if test="$MEDIAEMBED_THEME">#theme=<xsl:value-of select="$MEDIAEMBED_THEME"/></xsl:if>
++-amp:
++-    custom-element: amp-twitter
++-    src: https://cdn.ampproject.org/v0/amp-twitter-0.1.js
++-    template: '<amp-twitter layout="responsive" width="550" height="273" data-tweetid="{@id}"><blockquote placeholder=""><a href="https://twitter.com/user/status/{@id}">X</a></blockquote></amp-twitter>'
+++    src: https://s9e.github.io/iframe/2/twitter.min.html#<xsl:value-of select="@id"/><xsl:if test="$MEDIAEMBED_THEME='dark'">#theme=dark</xsl:if>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml"
++deleted file mode 100644
++index 17959bd01..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml"
+++++ /dev/null
++@@ -1,30 +0,0 @@
++-name: "VK"
++-homepage: "https://vk.com/"
++-tags: ".ru"
++-host:
++-    - "vk.com"
++-    - "vkontakte.ru"
++-    - "vkvideo.ru"
++-example:
++-    - "https://vk.com/video121599878_165723901?hash=e06b0878046e1d32"
++-    - "https://vk.com/video_ext.php?oid=121599878&id=165723901&hash=e06b0878046e1d32"
++-attributes:
++-    oid:
++-        required: true
++-    vid:
++-        required: true
++-extract:
++-    - "!video(?'oid'-?\\d+)_(?'vid'\\d+)!"
++-    - "!video_ext\\.php\\?oid=(?'oid'-?\\d+)&id=(?'vid'\\d+)!"
++-    - "!hash=(?'hash'[0-9a-f]+)!"
++-    - "!hd=(?'hd'\\d)!"
++-iframe:
++-    src: "//vk.com/video_ext.php?oid={@oid}&id={@vid}&hash={@hash}&hd={@hd}"
++-scrape:
++-    extract:
++-        - "#meta property=\"og:video\" content=\".*?oid=(?'oid'-?\\d+).*?id=(?'vid'\\d+)#"
++-        - "#meta property=\"og:video\" content=\".*?hash=(?'hash'[0-9a-f]+)#"
++-    match: "#^(?!.*?hash=)#"
++-    header:
++-        - "User-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36"
++-        - "Cookie: _ignoreAutoLogin=1"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/composer.json"
++index a301fcfa0..3275bb192 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/composer.json"
++@@ -3,7 +3,7 @@
++     "type": "phpbb-extension",
++     "description": "An official phpBB extension that allows users to embed content from allowed sites using a [media] BBCode, or from simply posting a supported URL in plain text.",
++     "homepage": "https://www.phpbb.com/customise/db/extension/mediaembed/",
++-    "version": "2.0.5",
+++    "version": "2.0.2",
++     "license": "GPL-2.0-only",
++     "authors": [
++         {
++@@ -31,11 +31,11 @@
++     ],
++     "require": {
++         "php": ">=7.1.3",
++-        "composer/installers": "^1.0 || ^2.0",
+++        "composer/installers": "~1.0.0",
++         "phpbb/phpbb": ">=3.3.2"
++     },
++     "require-dev": {
++-        "phing/phing": "~2.4"
+++        "phing/phing": "2.4.*"
++     },
++     "extra": {
++         "display-name": "phpBB Media Embed PlugIn",
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/diff_full.tmp"
++new file mode 100644
++index 000000000..7413aad5b
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/diff_full.tmp"
++@@ -0,0 +1,354 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/CHANGELOG.md"
+++index b54717eba..5e76d820a 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/CHANGELOG.md"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/CHANGELOG.md"
+++@@ -1,41 +1,15 @@
+++ # Changelog
+++ 
+++-### 2.0.5 - 2026-03-21
+++-
+++-- Added and/or updated support for media sites:
+++-	- Facebook
+++-	- vk.com
+++-
+++-### 2.0.4 - 2025-12-16
+++-
+++-- Fixed problems with YouTube not playing videos due to YouTube's referrerer policy.
+++-- Ensure and future-proof compatibility with phpBB4.
+++-- Added language packs:
+++-	- Romanian
+++-
+++-### 2.0.3 - 2025-09-20
+++-
+++-- Added an amendment to the forum privacy policy regarding how embedded content may affect user privacy.
+++-- Updated YouTube to use their enhanced privacy feature (no cookies until you play a video).
+++-- Fixed an issue in the BBCode FAQ media embed example.
+++-- Fixed issues in the language files.
+++-- Removed the last traces of old XHTML code.
+++-- Added and/or updated support for media sites:
+++-  - Apple Podcasts
+++-  - Bluesky
+++-  - Pastebin
+++-  - x.com (aka Twitter)
+++-
+++ ### 2.0.2 - 2024-01-21
+++ 
+++ - Small QoL improvement in the ACP, added sample placeholder data to the custom max-width field in the content-sizing settings.
+++ - Minor code updates.
+++ - Added and/or updated support for media sites:
+++-  - Apple Music
+++-  - x.com (aka Twitter)
+++-  - kick.com
+++-  - Threads
+++-  - Bunny Stream
++++	- Apple Music
++++	- x.com (aka Twitter)
++++	- kick.com
++++	- Threads
++++    - Bunny Stream
+++ 
+++ ### 2.0.1 - 2023-04-15
+++ 
+++@@ -50,9 +24,9 @@
+++ 
+++ - Backwards incompatible changes require a new minimum phpBB version of 3.3.2.
+++ - New ACP options for custom content sizing:
+++-  - Added a new setting to enlarge most embedded content to fit 100% of the width of the post-area.
++++  - Added a new setting to enlarge most embedded content to fit 100% of the width of the post area.
+++   - Added a new setting to define custom maximum widths in pixels or percent for individual sites.
+++-- Fixed issues for new installations that would fail if any of phpBB's default forum roles were missing.
++++- Fixed issues for new installs that would fail if any of phpBB's default forum roles were missing.
+++ - Added language packs:
+++   - Portuguese
+++   - Chinese (traditional)
+++@@ -110,10 +84,10 @@ on adding and creating new site YAML files for MediaEmbed.
+++ ### 1.0.2 - 2018-06-25
+++ 
+++ - Added a global setting to enable or disable the conversion of plain URLs into embedded content.
+++-- Added a forum-based permission, allowing control over who can post embedded content in specific forums.
+++-- Added a user-based private messages permission, allowing control over who can post embedded content in their private messages.
++++- Added a forum based permission, allowing control over who can post embedded content in specific forums.
++++- Added a user based private messages permission, allowing control over who can post embedded content in their private messages.
+++ - Fixed an issue where embedded content could still be posted by users who did not have permission to use BBCodes in a specific forum.
+++-- Fixed an issue where embedded content could still be posted even though the Disable BBCode option was checked in the post-editor.
++++- Fixed an issue where embedded content could still be posted even though the Disable BBCode option was checked in the post editor.
+++ - When users disable the option to automatically parse URLs in their post, plain URLs will no longer be converted to embedded content either.
+++ 
+++ ### 1.0.1 - 2017-08-04
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
+++index f12acc45c..74e5ee47a 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_manage.html"
+++@@ -22,7 +22,7 @@
+++ 					<td style="width: 25%;">
+++ 						{% if site %}
+++ 							<label style="font-size: 1em;" title="{{ site.title }}">
+++-								<input type="checkbox" class="radio" name="mark[]" value="{{ site.id }}"{% if site.disabled %} disabled{% elseif site.enabled %} checked{% endif %}> {{ site.name }}
++++								<input type="checkbox" class="radio" name="mark[]" value="{{ site.id }}"{% if site.disabled %} disabled{% elseif site.enabled %} checked{% endif %} /> {{ site.name }}
+++ 							</label>
+++ 						{% endif %}
+++ 					</td>
+++@@ -38,8 +38,8 @@
+++ 		<p class="small"><a href="#" data-marksites="true">{{ lang('MARK_ALL') }}</a> &bull; <a href="#" data-marksites="false">{{ lang('UNMARK_ALL') }}</a></p>
+++ 	</fieldset>
+++ 	<p id="buttons" class="submit-buttons">
+++-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
+++-		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
++++		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++++		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+++ 	</p>
+++ 	{{ S_FORM_TOKEN }}
+++ </form>
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
+++index bd6a9db66..4823e920c 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/acp_phpbb_mediaembed_settings.html"
+++@@ -8,51 +8,51 @@
+++ 	<fieldset>
+++ 		<legend>{{ lang('ACP_MEDIA_BBCODE_LEGEND') }}</legend>
+++ 		<dl>
+++-			<dt><label for="media_embed_bbcode">{{ lang('ACP_MEDIA_DISPLAY_BBCODE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN') }}</span></dt>
+++-			<dd><label><input type="radio" class="radio" name="media_embed_bbcode" id="media_embed_bbcode" value="1" {% if S_MEDIA_EMBED_BBCODE %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+++-				<label><input type="radio" class="radio" name="media_embed_bbcode" value="0"{% if not S_MEDIA_EMBED_BBCODE %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++++			<dt><label for="media_embed_bbcode">{{ lang('ACP_MEDIA_DISPLAY_BBCODE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN') }}</span></dt>
++++			<dd><label><input type="radio" class="radio" name="media_embed_bbcode" id="media_embed_bbcode" value="1" {% if S_MEDIA_EMBED_BBCODE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++++				<label><input type="radio" class="radio" name="media_embed_bbcode" value="0"{% if not S_MEDIA_EMBED_BBCODE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++ 		</dl>
+++ 	</fieldset>
+++ 	<fieldset>
+++ 		<legend>{{ lang('ACP_MEDIA_OPTIONS_LEGEND') }}</legend>
+++ 		<dl>
+++-			<dt><label for="media_embed_allow_sig">{{ lang('ACP_MEDIA_ALLOW_SIG') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_ALLOW_SIG_EXPLAIN') }}</span></dt>
+++-			<dd><label><input type="radio" class="radio" name="media_embed_allow_sig" id="media_embed_allow_sig" value="1" {% if S_MEDIA_EMBED_ALLOW_SIG %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+++-				<label><input type="radio" class="radio" name="media_embed_allow_sig" value="0"{% if not S_MEDIA_EMBED_ALLOW_SIG %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++++			<dt><label for="media_embed_allow_sig">{{ lang('ACP_MEDIA_ALLOW_SIG') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_ALLOW_SIG_EXPLAIN') }}</span></dt>
++++			<dd><label><input type="radio" class="radio" name="media_embed_allow_sig" id="media_embed_allow_sig" value="1" {% if S_MEDIA_EMBED_ALLOW_SIG %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++++				<label><input type="radio" class="radio" name="media_embed_allow_sig" value="0"{% if not S_MEDIA_EMBED_ALLOW_SIG %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label for="media_embed_parse_urls">{{ lang('ACP_MEDIA_PARSE_URLS') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_PARSE_URLS_EXPLAIN') }}</span></dt>
+++-			<dd><label><input type="radio" class="radio" name="media_embed_parse_urls" id="media_embed_parse_urls" value="1" {% if S_MEDIA_EMBED_PARSE_URLS %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+++-				<label><input type="radio" class="radio" name="media_embed_parse_urls" value="0"{% if not S_MEDIA_EMBED_PARSE_URLS %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++++			<dt><label for="media_embed_parse_urls">{{ lang('ACP_MEDIA_PARSE_URLS') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_PARSE_URLS_EXPLAIN') }}</span></dt>
++++			<dd><label><input type="radio" class="radio" name="media_embed_parse_urls" id="media_embed_parse_urls" value="1" {% if S_MEDIA_EMBED_PARSE_URLS %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++++				<label><input type="radio" class="radio" name="media_embed_parse_urls" value="0"{% if not S_MEDIA_EMBED_PARSE_URLS %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++ 		</dl>
+++ 	</fieldset>
+++ 	<fieldset>
+++ 		<legend>{{ lang('ACP_MEDIA_CACHE_LEGEND') }}</legend>
+++ 		<dl>
+++-			<dt><label for="media_embed_enable_cache">{{ lang('ACP_MEDIA_ENABLE_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_ENABLE_CACHE_EXPLAIN') }}</span></dt>
+++-			<dd><label><input type="radio" class="radio" name="media_embed_enable_cache" id="media_embed_enable_cache" value="1" {% if S_MEDIA_EMBED_ENABLE_CACHE %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+++-				<label><input type="radio" class="radio" name="media_embed_enable_cache" value="0"{% if not S_MEDIA_EMBED_ENABLE_CACHE %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++++			<dt><label for="media_embed_enable_cache">{{ lang('ACP_MEDIA_ENABLE_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_ENABLE_CACHE_EXPLAIN') }}</span></dt>
++++			<dd><label><input type="radio" class="radio" name="media_embed_enable_cache" id="media_embed_enable_cache" value="1" {% if S_MEDIA_EMBED_ENABLE_CACHE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++++				<label><input type="radio" class="radio" name="media_embed_enable_cache" value="0"{% if not S_MEDIA_EMBED_ENABLE_CACHE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label for="action_purge_cache">{{ lang('ACP_MEDIA_PURGE_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_PURGE_CACHE_EXPLAIN') }}</span></dt>
+++-			<dd><input class="button2" type="submit" id="action_purge_cache" name="action_purge_cache" value="{{ lang('PURGE_CACHE') }}"></dd>
++++			<dt><label for="action_purge_cache">{{ lang('ACP_MEDIA_PURGE_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_PURGE_CACHE_EXPLAIN') }}</span></dt>
++++			<dd><input class="button2" type="submit" id="action_purge_cache" name="action_purge_cache" value="{{ lang('PURGE_CACHE') }}" /></dd>
+++ 		</dl>
+++ 	</fieldset>
+++ 	<fieldset>
+++ 		<legend>{{ lang('ACP_MEDIA_WIDTH_LEGEND') }}</legend>
+++ 		<dl>
+++-			<dt><label for="media_embed_full_width">{{ lang('ACP_MEDIA_FULL_WIDTH') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_FULL_WIDTH_EXPLAIN') }}</span></dt>
+++-			<dd><label><input type="radio" class="radio" name="media_embed_full_width" id="media_embed_full_width" value="1" {% if S_MEDIA_EMBED_FULL_WIDTH %}checked="checked"{% endif %}> {{ lang('YES') }}</label>
+++-				<label><input type="radio" class="radio" name="media_embed_full_width" value="0"{% if not S_MEDIA_EMBED_FULL_WIDTH %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++++			<dt><label for="media_embed_full_width">{{ lang('ACP_MEDIA_FULL_WIDTH') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_FULL_WIDTH_EXPLAIN') }}</span></dt>
++++			<dd><label><input type="radio" class="radio" name="media_embed_full_width" id="media_embed_full_width" value="1" {% if S_MEDIA_EMBED_FULL_WIDTH %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++++				<label><input type="radio" class="radio" name="media_embed_full_width" value="0"{% if not S_MEDIA_EMBED_FULL_WIDTH %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label for="media_embed_max_width">{{ lang('ACP_MEDIA_MAX_WIDTH') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_MEDIA_MAX_WIDTH_EXPLAIN') }}</span></dt>
++++			<dt><label for="media_embed_max_width">{{ lang('ACP_MEDIA_MAX_WIDTH') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_MEDIA_MAX_WIDTH_EXPLAIN') }}</span></dt>
+++ 			<dd><textarea id="media_embed_max_width" name="media_embed_max_width" rows="8" cols="40" style="width: 50%;" placeholder="twitter:100%&#10;youtube:80%&#10;funnyordie:480px">{{ S_MEDIA_EMBED_MAX_WIDTHS }}</textarea></dd>
+++ 		</dl>
+++ 	</fieldset>
+++ 	<fieldset class="submit-buttons">
+++-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
+++-		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
++++		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++++		<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+++ 		{{ S_FORM_TOKEN }}
+++ 	</fieldset>
+++ </form>
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
+++index f44d8e8b1..fdf64305d 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/adm/style/event/acp_posting_buttons_custom_tags_before.html"
+++@@ -1,3 +1,3 @@
+++ {% if S_BBCODE_MEDIA %}
+++-	<input type="button" class="button2" accesskey="m" name="addmedia" value="Media" style="width: 50px;" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}">
++++	<input type="button" class="button2" accesskey="m" name="addmedia" value="Media" style="width: 50px;" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}" />
+++ {% endif %}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml"
+++deleted file mode 100644
+++index 15f925af3..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/applepodcasts.yml"
++++++ /dev/null
+++@@ -1,25 +0,0 @@
+++-name: "Apple Podcasts"
+++-homepage: "https://podcasts.apple.com/"
+++-host: podcasts.apple.com
+++-example:
+++-    - https://podcasts.apple.com/us/podcast/the-office-deep-dive-with-brian-baumgartner/id1550331348
+++-    - https://podcasts.apple.com/us/podcast/the-office-deep-dive-with-brian-baumgartner/id1550331348?i=1000514199106
+++-extract:
+++-    - "@podcasts.apple.com/(?'country'\\w+)/podcast/[-\\w%]*/id(?'podcast_id'\\d+)(?:\\?i=(?'episode_id'\\d+))?@"
+++-choose:
+++-    when:
+++-        test: '@episode_id'
+++-        iframe:
+++-            allow: "autoplay *;encrypted-media *"
+++-            width: "100%"
+++-            height: "175"
+++-            max-width: "900"
+++-            src: "https://embed.podcasts.apple.com/{@country}/podcast/episode/id{@podcast_id}?i={@episode_id}"
+++-    otherwise:
+++-        iframe:
+++-            allow: "autoplay *;encrypted-media *"
+++-            width: "100%"
+++-            height: "450"
+++-            max-width: "900"
+++-            src: "https://embed.podcasts.apple.com/{@country}/podcast/episode/id{@podcast_id}"
+++-tags: "podcasts"
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml"
+++deleted file mode 100644
+++index 2fbed75d0..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/bluesky.yml"
++++++ /dev/null
+++@@ -1,25 +0,0 @@
+++-attributes:
+++-    embedder:
+++-        filterChain: []
+++-        required: true
+++-    url:
+++-        filterChain: "urldecode"
+++-        required: true
+++-example:
+++-    - "https://bsky.app/profile/bsky.app/post/3kkrqzuydho2v"
+++-    - "https://bsky.app/profile/bnewbold.net/post/3kxjq2auebs2f"
+++-extract: "#^https://(?'embedder'[.\\w]+)/oembed.*?url=(?'url'[\\w%.]+)#"
+++-homepage: "https://bsky.app/"
+++-host: "bsky.app"
+++-iframe:
+++-    data-s9e-livepreview-ignore-attrs: style
+++-    height: 600
+++-    onload: "let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])"
+++-    src: "https://s9e.github.io/iframe/2/bluesky.min.html#<xsl:value-of select=\"@url\"/>#<xsl:value-of select=\"@embedder\"/>"
+++-    width: 600
+++-name: "Bluesky"
+++-scrape:
+++-    extract: "#https://(?'embedder'[.\\w]+)/oembed.*?url=(?'url'[\\w%.]+)#"
+++-    match: "#/profile/[^/]+/post/.#"
+++-source: "https://embed.bsky.app/"
+++-tags: "social"
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml"
+++deleted file mode 100644
+++index a1a297235..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/facebook.yml"
++++++ /dev/null
+++@@ -1,50 +0,0 @@
+++-name: Facebook
+++-homepage: https://www.facebook.com/
+++-tags: social
+++-host:
+++-    - facebook.com
+++-    - fb.watch
+++-example:
+++-    - https://www.facebook.com/MetaforDevelopers/posts/451016937058647
+++-    - https://www.facebook.com/watch/?v=224353158889229
+++-    - https://fb.watch/3zYsXdnxjf/
+++-    - https://www.facebook.com/reel/873906321076441
+++-extract:
+++-    - "@facebook.com/.*?(?:fbid=|/permalink/|\\?v=)(?'id'\\d+)@"
+++-    - "@facebook.com/(?'user'[.\\w]+)/(?'type'[pv])(?:ost|ideo)s?/(?:[-%.\\w]+/)?(?'id'\\d+)\\b@"
+++-    - "@facebook.com/video/(?=post|video)(?'type'[pv])@"
+++-    - "@facebook.com/events/(?'id'\\d+)\\b(?!/permalink)@"
+++-    - "@facebook.com/watch/?(?'type'[pv])=@"
+++-    - "@facebook.com/groups/[^/]*/(?'type'p)osts/(?'id'\\d+)@"
+++-    - "@facebook.com/(?'user'[.\\w]+)/posts/pfbid(?'pfbid'\\w+)@"
+++-    - "@facebook.com/permalink.php?story_fbid=(?:(?'id'\\d+)|pfbid(?'pfbid'\\w+))&id=(?'page_id'\\d+)@"
+++-    - "@facebook.com/(?'type'r)eel/(?'id'\\d+)@"
+++-scrape:
+++-    - extract: "@facebook.com/(?'user'[.\\w]+)/(?'type'[pv])\\w+/(?'id'\\d+)(?!\\w)@"
+++-      header: "User-agent: PHP (not Mozilla)"
+++-      match: "@facebook.com/[.\\w]+/posts/pfbid@"
+++-      url: https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2F{@user}%2Fposts%2Fpfbid{@pfbid}
+++-    - extract: "@story_fbid=(?'id'\\d+)@"
+++-      header: "User-agent: PHP (not Mozilla)"
+++-      match: "@facebook.com/permalink.php?story_fbid=pfbid(?'pfbid'\\w+)&id=(?'page_id'\\d+)@"
+++-      url: https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fpermalink.php%3Fstory_fbid%3Dpfbid{@pfbid}%26id%3D{@page_id}
+++-    - extract:
+++-        - "@facebook.com/watch/?(?'type'v)=(?'id'\\d+)@"
+++-        - "@facebook.com/(?'user'[.\\w]+)/(?'type'v)ideos/(?'id'\\d+)@"
+++-      header: "User-agent: PHP (not Mozilla)"
+++-      match: "@fb.watch/.@"
+++-    - extract:
+++-        - "@facebook.com/\\w+/(?'user'[.\\w]+)/permalink/(?'id'\\d+)(?!\\w)@"
+++-        - "@og:url[^>]+facebook.com/(?'user'[.\\w]+)/(?'type'[pv])(?:ost|ideo)s?/(?:[-\\w%]+/)?(?'id'\\d+)\\b@"
+++-      header: "User-agent: PHP (not Mozilla)"
+++-      match: "@facebook.com/share/[pv]/\\w@"
+++-iframe:
+++-    data-s9e-livepreview-ignore-attrs: style
+++-    onload: let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])
+++-    src: https://s9e.github.io/iframe/2/facebook.min.html#<xsl:choose><xsl:when test="@user"><xsl:value-of select="@user"/>/<xsl:choose><xsl:when test="@type='r'or@type='v'">video</xsl:when><xsl:otherwise>post</xsl:otherwise></xsl:choose>s/<xsl:choose><xsl:when test="@id"><xsl:value-of select="@id"/></xsl:when><xsl:otherwise>pfbid<xsl:value-of select="@pfbid"/></xsl:otherwise></xsl:choose></xsl:when><xsl:when test="@id"><xsl:value-of select="@type"/><xsl:value-of select="@id"/></xsl:when><xsl:otherwise>pfbid<xsl:value-of select="@pfbid"/></xsl:otherwise></xsl:choose>
+++-amp:
+++-    custom-element: "amp-facebook"
+++-    src: "https://cdn.ampproject.org/v0/amp-facebook-0.1.js"
+++-    template: <amp-facebook layout="responsive" width="640" height="360"><xsl:if test="starts-with(@type,'v')"><xsl:attribute name="data-embed-as">video</xsl:attribute></xsl:if><xsl:attribute name="data-href">https://www.facebook.com/<xsl:choose><xsl:when test="@user"><xsl:value-of select="@user"/></xsl:when><xsl:otherwise>user</xsl:otherwise></xsl:choose>/<xsl:choose><xsl:when test="starts-with(@type,'v')">video</xsl:when><xsl:otherwise>post</xsl:otherwise></xsl:choose>s/<xsl:value-of select="@id"/></xsl:attribute></amp-facebook>
+++-attributes: []
+++-tracking_policy: https://www.facebook.com/help/1896641480634370
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml"
+++deleted file mode 100644
+++index 1efb6f379..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/pastebin.yml"
++++++ /dev/null
+++@@ -1,12 +0,0 @@
+++-name: Pastebin
+++-host: pastebin.com
+++-example:
+++-    - "https://pastebin.com/9jEf44nc"
+++-    - "https://pastebin.com/9jEf44nc?theme=dark"
+++-extract: "#pastebin\\.com/(?!u/)(?:\\w+(?:\\.php\\?i=|/))?(?'id'\\w+)(?'dark'\\?theme=dark)?#"
+++-iframe:
+++-    scrolling: "yes"
+++-    width: "100%"
+++-    height: "300"
+++-    style: ["border:none;resize:vertical;width:100%"]
+++-    src: //pastebin.com/embed_iframe/{@id}{@dark}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/twitter.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
+++index b05309020..5ac8c93d5 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/collection/sites/twitter.yml"
+++@@ -14,10 +14,6 @@ iframe:
+++     data-s9e-livepreview-ignore-attrs: "style"
+++     onload: "let c=new MessageChannel;c.port1.onmessage=e=>this.style.height=e.data+'px';this.contentWindow.postMessage('s9e:init','*',[c.port2])"
+++     width: "550"
+++-    height: "350"
++++    height: "273"
+++     allow: "autoplay *"
+++-    src: https://s9e.github.io/iframe/2/twitter.min.html#<xsl:value-of select="@id"/><xsl:if test="$MEDIAEMBED_THEME">#theme=<xsl:value-of select="$MEDIAEMBED_THEME"/></xsl:if>
+++-amp:
+++-    custom-element: amp-twitter
+++-    src: https://cdn.ampproject.org/v0/amp-twitter-0.1.js
+++-    template: '<amp-twitter layout="responsive" width="550" height="273" data-tweetid="{@id}"><blockquote placeholder=""><a href="https://twitter.com/user/status/{@id}">X</a></blockquote></amp-twitter>'
++++    src: https://s9e.github.io/iframe/2/twitter.min.html#<xsl:value-of select="@id"/><xsl:if test="$MEDIAEMBED_THEME='dark'">#theme=dark</xsl:if>
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml"
+++deleted file mode 100644
+++index 17959bd01..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/collection/sites/vk.yml"
++++++ /dev/null
+++@@ -1,30 +0,0 @@
+++-name: "VK"
+++-homepage: "https://vk.com/"
+++-tags: ".ru"
+++-host:
+++-    - "vk.com"
+++-    - "vkontakte.ru"
+++-    - "vkvideo.ru"
+++-example:
+++- 
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/event/main_listener.php"
++index 5cc81e6fb..764fbbf48 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/event/main_listener.php"
++@@ -25,9 +25,6 @@ use Symfony\Component\Yaml\Yaml;
++  */
++ class main_listener implements EventSubscriberInterface
++ {
++-	/** @var string A link to a rich content media site for demo purposes */
++-	public const MEDIA_DEMO_URL = 'https://youtu.be/Ne18ZQ7LLI0';
++-
++ 	/** @var auth */
++ 	protected $auth;
++ 
++@@ -55,16 +52,13 @@ class main_listener implements EventSubscriberInterface
++ 	/** @var bool Disable the media tag (bbcode parsing) */
++ 	protected $disable_tag = false;
++ 
++-	/** @var bool|null Cached result of is_phpbb4() */
++-	protected $is_phpbb4;
++-
++ 	/**
++ 	 * {@inheritDoc}
++ 	 */
++ 	public static function getSubscribedEvents()
++ 	{
++ 		return [
++-			'core.text_formatter_s9e_configure_after'	=> [['add_custom_sites', 3], ['enable_media_sites', 2], ['configure_url_parsing', 1], ['modify_tag_templates', 0]],
+++			'core.text_formatter_s9e_configure_after'	=> [['add_custom_sites', 3], ['enable_media_sites', 2], ['configure_url_parsing', 1]],
++ 			'core.display_custom_bbcodes'				=> 'setup_media_bbcode',
++ 			'core.permissions'							=> 'set_permissions',
++ 			'core.help_manager_add_block_before'		=> 'media_embed_help',
++@@ -73,20 +67,19 @@ class main_listener implements EventSubscriberInterface
++ 			'core.message_parser_check_message'			=> [['check_signature'], ['check_magic_urls'], ['check_bbcode_enabled']],
++ 			'core.text_formatter_s9e_parser_setup'		=> [['disable_media_embed'], ['setup_cache_dir']],
++ 			'core.page_header' 							=> 'setup_media_configs',
++-			'core.page_footer'							=> 'append_agreement',
++ 		];
++ 	}
++ 
++ 	/**
++ 	 * Constructor
++ 	 *
++-	 * @param auth					$auth
++-	 * @param config				$config
++-	 * @param db_text				$config_text
++-	 * @param language				$language
++-	 * @param template				$template
++-	 * @param customsitescollection	$custom_sites
++-	 * @param string				$cache_dir
+++	 * @param auth                  $auth
+++	 * @param config                $config
+++	 * @param db_text               $config_text
+++	 * @param language              $language
+++	 * @param template              $template
+++	 * @param customsitescollection $custom_sites
+++	 * @param string                $cache_dir
++ 	 */
++ 	public function __construct(auth $auth, config $config, db_text $config_text, language $language, template $template, customsitescollection $custom_sites, $cache_dir)
++ 	{
++@@ -107,29 +100,12 @@ class main_listener implements EventSubscriberInterface
++ 	 */
++ 	public function add_custom_sites($event)
++ 	{
++-		$phpbb4_builtins = array_flip([
++-			'applepodcasts',
++-			'bluesky',
++-			'bunny',
++-			'facebook',
++-			'mastodon',
++-			'pastebin',
++-			'threads',
++-			'twitter',
++-			'vk',
++-		]);
++-
++ 		foreach ($this->custom_sites->get_collection() as $site)
++ 		{
++-			$name = basename($site, ext::YML);
++-
++-			// Skip built-in sites when running phpBB 4
++-			if (isset($phpbb4_builtins[$name]) && $this->is_phpbb4())
++-			{
++-				continue;
++-			}
++-
++-			$event['configurator']->MediaEmbed->defaultSites->add($name, Yaml::parseFile($site));
+++			$event['configurator']->MediaEmbed->defaultSites->add(
+++				basename($site, ext::YML),
+++				Yaml::parse(file_get_contents($site))
+++			);
++ 		}
++ 	}
++ 
++@@ -176,32 +152,6 @@ class main_listener implements EventSubscriberInterface
++ 		}
++ 	}
++ 
++-	/**
++-	 * Modify bbcode tag templates
++-	 *
++-	 * @param \phpbb\event\data $event The event object
++-	 * @return void
++-	 */
++-	public function modify_tag_templates($event)
++-	{
++-		try
++-		{
++-			// force YouTube to use the no cookies until the user starts video playback, and fix referrer policy issues
++-			$tag = $event['configurator']->tags['YOUTUBE'];
++-			$tag->template = str_replace('www.youtube.com', 'www.youtube-nocookie.com', $tag->template);
++-			if (!$this->is_phpbb4())
++-			{
++-				$tag->template = str_replace(' allowfullscreen', ' referrerpolicy="origin" allowfullscreen', $tag->template);
++-			}
++-
++-			$event['configurator']->finalize();
++-		}
++-		catch (\RuntimeException $e)
++-		{
++-			// do nothing
++-		}
++-	}
++-
++ 	/**
++ 	 * Set template switch for displaying the [media] BBCode button
++ 	 *
++@@ -243,14 +193,14 @@ class main_listener implements EventSubscriberInterface
++ 			]);
++ 
++ 			$uid = $bitfield = $flags = '';
++-			$demo_text = self::MEDIA_DEMO_URL;
+++			$demo_text = $this->language->lang('HELP_EMBEDDING_MEDIA_DEMO');
++ 			generate_text_for_storage($demo_text, $uid, $bitfield, $flags, true, true);
++ 			$demo_display = generate_text_for_display($demo_text, $uid, $bitfield, $flags);
++ 			$list_sites = implode(', ', $this->get_siteIds());
++ 
++ 			$this->template->assign_block_vars('faq_block.faq_row', [
++ 				'FAQ_QUESTION'	=> $this->language->lang('HELP_EMBEDDING_MEDIA_QUESTION'),
++-				'FAQ_ANSWER'	=> $this->language->lang('HELP_EMBEDDING_MEDIA_ANSWER', self::MEDIA_DEMO_URL, $demo_display, $list_sites),
+++				'FAQ_ANSWER'	=> $this->language->lang('HELP_EMBEDDING_MEDIA_ANSWER', $demo_text, $demo_display, $list_sites),
++ 			]);
++ 		}
++ 	}
++@@ -391,34 +341,4 @@ class main_listener implements EventSubscriberInterface
++ 
++ 		return $siteIds ? json_decode($siteIds, true) : [];
++ 	}
++-
++-	/**
++-	 * Appends additional language to the privacy policy agreement text.
++-	 *
++-	 * @return void
++-	 */
++-	public function append_agreement()
++-	{
++-		if (!$this->template->retrieve_var('S_AGREEMENT') || ($this->template->retrieve_var('AGREEMENT_TITLE') !== $this->language->lang('PRIVACY')))
++-		{
++-			return;
++-		}
++-
++-		$this->language->add_lang('ucp', 'phpbb/mediaembed');
++-
++-		$this->template->append_var('AGREEMENT_TEXT', $this->language->lang('MEDIA_EMBED_PRIVACY_POLICY', $this->config['sitename']));
++-	}
++-
++-	/**
++-	 * @return mixed
++-	 */
++-	private function is_phpbb4()
++-	{
++-		if ($this->is_phpbb4 === null)
++-		{
++-			$this->is_phpbb4 = phpbb_version_compare($this->config['version'], '4.0.0-a1', '>=');
++-		}
++-
++-		return $this->is_phpbb4;
++-	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ar/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ar/acp.php"
++index 2c37a66ca..d4e9e357e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ar/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ar/acp.php"
++@@ -24,8 +24,8 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'إعدادات إدراج مُحتوى الوسائط',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'من هنا تستطيع ضبط الإعدادات الخاصة بالإضافة “إدراج مُحتوى الوسائط”.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'ظهور زر BBCode للوسائط <samp>[media]</samp>',
++-	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'اختيارك “لا”, يعني منع ظهور زر BBCode الخاص بالوسائط <samp>[media]</samp> في محرر الكتابة, وبالرغم من ذلك يستطيع الأعضاء استخدام الوسم <samp>[media]</samp> في مُشاركاتهم.',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'ظهور زر BBCode للوسائط <samp>[MEDIA]</samp>',
+++	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'اختيارك “لا”, يعني منع ظهور زر BBCode الخاص بالوسائط <samp>[MEDIA]</samp> في محرر الكتابة, وبالرغم من ذلك يستطيع الأعضاء استخدام الوسم <samp>[media]</samp> في مُشاركاتهم.',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'التوقيعات',
++ 	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'السماح للعضو بإستخدام وسم الوسائط في التوقيع.',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ar/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ar/help.php"
++index ac1968d27..9f28a985a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ar/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ar/help.php"
++@@ -43,13 +43,14 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'كيف أستطيع إدراج مُحتوى الوسائط من المواقع الأخرى في المُشاركات؟',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'يستطيع الأعضاء إدراج محتوى الوسائط مثل الفيديو والمقاطع الصوتية من المواقع المسموح بها بإستخدام
++ 										الوسم <strong>[media][/media]</strong>, أو ببساطة كتابة الرابط لأحد المواقع المدعومة
++-										كما هو بدون الوسوم. مثال:<br><br>
+++										كما هو بدون الوسوم. مثال:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>كما تلاحظ في المثال أعلاه, تستطيع أيضاً استخدام الرابط بدون الوسم
+++										<br /><br />كما تلاحظ في المثال أعلاه, تستطيع أيضاً استخدام الرابط بدون الوسم
++ 										<strong>[media]</strong>.
++-										<br><br>ستكون النتيجة للمثال المذكور أعلاه كالآتي:<br><br>%2$s
++-										<br><br>القائمة التالية تحتوي على المواقع المدعومة:<br><samp>%3$s.</samp>
++-										<br><br>للمزيد من المعلومات والأمثلة للمواقع المدعومة,
+++										<br /><br />ستكون النتيجة للمثال المذكور أعلاه كالآتي:<br /><br />%2$s
+++										<br /><br />القائمة التالية تحتوي على المواقع المدعومة:<br /><samp>%3$s.</samp>
+++										<br /><br />للمزيد من المعلومات والأمثلة للمواقع المدعومة,
++ 										انقر على هذا الرابط <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										معلومات إدراج مُحتوى الوسائط</a>.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ar/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ar/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ar/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/cs/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/cs/acp.php"
++index 6e51eaa45..499d03170 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/cs/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/cs/acp.php"
++@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Media Embed nastavení',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Zde můžete konfigurovat nastaven í pro plugin Media Embed.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zobrazit <samp>[media]</samp> BBCode na stránce s příspěvkem.',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zobrazit <samp>[MEDIA]</samp> BBCode na stránce s příspěvkem.',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Pokud je zakázáno, BBCode tlačítko nebude zobrazeno, přesto mohou uživatelé ve svých příspěvcích využít <samp>[media]</samp>.',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Povolí v podpisech uživatelů',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/cs/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/cs/help.php"
++index 7252e04fc..505361d18 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/cs/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/cs/help.php"
++@@ -40,12 +40,13 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA'			=> 'Vkládání médií',
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Jak vkládat média z jiných stránek do příspěvků.',
++-	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Uživatelů mohou vkládat obsah jako jsou videa nebo zvukové stopy z povolených stránek používáním <strong>[media][/media]</strong> nebo jednoduše vložením povoleného URL do textu. Například:<br><br>
+++	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Uživatelů mohou vkládat obsah jako jsou videa nebo zvukové stopy z povolených stránek používáním <strong>[media][/media]</strong> nebo jednoduše vložením povoleného URL do textu. Například:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Jak bylo výše zmíněno, odkaz může být také vložen pomocí
+++										<br /><br />Jak bylo výše zmíněno, odkaz může být také vložen pomocí
++ 										<strong>[media]</strong> tagů.
++-										<br><br>Uvedený příklad bude vypadat následovně:<br><br>%2$s
++-										<br><br>Tyto stránky jsou podporovány:<br><samp>%3$s.</samp>
++-										<br><br>Pro kompletní dokumentaci podporovaných tránek a příklady URL navštivte <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+++										<br /><br />Uvedený příklad bude vypadat následovně:<br /><br />%2$s
+++										<br /><br />Tyto stránky jsou podporovány:<br /><samp>%3$s.</samp>
+++										<br /><br />Pro kompletní dokumentaci podporovaných tránek a příklady URL navštivte <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										MediaEmbed Plugin dokumentace</a>.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/cs/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/cs/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/cs/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/da/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/da/acp.php"
++index 24809f988..5fe4c0858 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/da/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/da/acp.php"
++@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Indstillinger for medieindlejring',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Her kan du konfigurere indstillingerne til Media Embed PlugIn.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Vis <samp>[media]</samp>-BBkode på siden hvor indlæg skrives',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Vis <samp>[MEDIA]</samp>-BBkode på siden hvor indlæg skrives',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Hvis den er valgt fra vises BBkode-knappen ikke, men brugerne kan dog stadig bruge <samp>[media]</samp>-tagget i deres indlæg',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Tillad i brugersignaturer',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/da/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/da/help.php"
++index 51acd4c4d..e135c3f42 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/da/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/da/help.php"
++@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Sådan indlejres medie fra andre steder i indlæg',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Brugere kan indlejre indhold, såsom videoer og lyd fra tilladte stedet med
++ 										<strong>[media][/media]</strong>-tags, eller blot ved at skrive en understøttet
++-										URL i ren tekst. F.eks.:<br><br>
+++										URL i ren tekst. F.eks.:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Som beskrevet ovenfor, kan linket også bruges uden
+++										<br /><br />Som beskrevet ovenfor, kan linket også bruges uden
++ 										<strong>[media]</strong>-taggene.
++-										<br><br>Eksemplet som vises her genererer:<br><br>%2$s
++-										<br><br>Følgende steder understøttes:<br><samp>%3$s.</samp>
++-										<br><br>Besøg <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+++										<br /><br />Eksemplet som vises her genererer:<br /><br />%2$s
+++										<br /><br />Følgende steder understøttes:<br /><samp>%3$s.</samp>
+++										<br /><br />Besøg <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										dokumentationen til MediaEmbed Plugin</a> for fuld dokumentation på understøttede steder og
++ 										URL\'er med eksempler.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/da/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/da/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/da/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/de/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/de/acp.php"
++index 8f3c22fbf..201c3b788 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/de/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/de/acp.php"
++@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Media Embed Einstellungen',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Hier kannst du die Einstellungen für das Media Embed PlugIn anpassen.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zeige <samp>[media]</samp> BBCode auf der Posting Seite',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zeige <samp>[MEDIA]</samp> BBCode auf der Posting Seite',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Wenn nicht erlaubt, wird der BBCode Button nicht angezeigt, dennoch können die User das <samp>[media]</samp> in ihren Posts verwenden.',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Erlaubt in den Benutzer Signaturen',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/de/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/de/help.php"
++index 48c2a13ea..9ff61bc48 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/de/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/de/help.php"
++@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Wie werden Medien von anderen Seiten in Posts eingebunden',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'User können Medien von anderen erlaubten Seiten wie Video und Audio einbinden indem
++ 										die <strong>[media][/media]</strong> Tags oder indem einfach die reine URL der erlaubten Seite
++-										in den Text kopiert wird. Als Beispiel:<br><br>
+++										in den Text kopiert wird. Als Beispiel:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Wie oben beschrieben kann die URL auch ohne die
+++										<br /><br />Wie oben beschrieben kann die URL auch ohne die
++ 										<strong>[media]</strong> Tags verwendet werden.
++-										<br><br>Das hier gezeigt Beispiel würde folgendes generieren:<br><br>%2$s
++-										<br><br>Die folgenden Seiten sind erlaubt:<br><samp>%3$s.</samp>
++-										<br><br>Für eine komplette Dokumentation der unterstützen Seiten und Beispiel URLs,
+++										<br /><br />Das hier gezeigt Beispiel würde folgendes generieren:<br /><br />%2$s
+++										<br /><br />Die folgenden Seiten sind erlaubt:<br /><samp>%3$s.</samp>
+++										<br /><br />Für eine komplette Dokumentation der unterstützen Seiten und Beispiel URLs,
++ 										besuche die <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										MediaEmbed Plugin Documentation</a>.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/de/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/de/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/de/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/en/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/en/acp.php"
++index 48f9d5b73..30b60554c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/en/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/en/acp.php"
++@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Media Embed Settings',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Here you can configure the settings for the Media Embed PlugIn.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Display <samp>[media]</samp> BBCode on posting page',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Display <samp>[MEDIA]</samp> BBCode on posting page',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'If disallowed, the BBCode button will not be displayed, however users can still use the <samp>[media]</samp> tag in their posts.',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Allow in user signatures',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/en/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/en/help.php"
++index 2f07f1a77..b4697cacd 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/en/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/en/help.php"
++@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'How to embed media from other sites into posts',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Users can embed content such as videos and audio from allowed sites using
++ 										the <strong>[media][/media]</strong> tags, or from simply posting a supported
++-										URL in plain text. For example:<br><br>
+++										URL in plain text. For example:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>As noted above, the link could also be used without the
+++										<br /><br />As noted above, the link could also be used without the
++ 										<strong>[media]</strong> tags.
++-										<br><br>The example shown here would generate:<br><br>%2$s
++-										<br><br>The following sites are supported:<br><samp>%3$s.</samp>
++-										<br><br>For complete documentation on supported sites and example URLs,
+++										<br /><br />The example shown here would generate:<br /><br />%2$s
+++										<br /><br />The following sites are supported:<br /><samp>%3$s.</samp>
+++										<br /><br />For complete documentation on supported sites and example URLs,
++ 										visit the <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										MediaEmbed Plugin Documentation</a>.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/en/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/en/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/en/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es/acp.php"
++index 467e324d2..e6668703f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es/acp.php"
++@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Ajustes de Media Embed',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aquí puede configurar los ajustes del PlugIn Media Embed.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[media]</samp> en la página de publicación',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[MEDIA]</samp> en la página de publicación',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Si se deshabilita, el botón BBCode no será mostrado, pero los usuarios aún podrán seguir usando la etiqueta <samp>[media]</samp> en sus mensajes',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opciones',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Permitir en firmas de usuario',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es/help.php"
++index c9940503d..128d5a5bb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es/help.php"
++@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Cómo insertar medios de otros sitios en los mensajes',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Los usuarios pueden incorporar contenido como videos y audio desde sitios permitidos usando
++ 										las etiquetas <strong>[media][/media]</strong>, o simplemente publicando una URL soportada
++-										en texto plano. Por ejemplo:<br><br>
+++										en texto plano. Por ejemplo:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Como se indicó anteriormente, el enlace también podría utilizarse sin las
+++										<br /><br />Como se indicó anteriormente, el enlace también podría utilizarse sin las
++ 										etiquetas <strong>[media]</strong>.
++-										<br><br>El ejemplo mostrado aquí generaría:<br><br>%2$s
++-										<br><br>Los siguientes sitios son compatibles:<br><samp>%3$s.</samp>
++-										<br><br>Para obtener una documentación completa sobre los sitios admitidos, y las URL de ejemplo,
+++										<br /><br />El ejemplo mostrado aquí generaría:<br /><br />%2$s
+++										<br /><br />Los siguientes sitios son compatibles:<br /><samp>%3$s.</samp>
+++										<br /><br />Para obtener una documentación completa sobre los sitios admitidos, y las URL de ejemplo,
++ 										visite la <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										Documentación del PlugIn MediaEmbed</a>.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/info_acp_mediaembed.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es/info_acp_mediaembed.php"
++index b3c5569ce..7aab0593d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/info_acp_mediaembed.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es/info_acp_mediaembed.php"
++@@ -26,5 +26,5 @@ $lang = array_merge($lang, [
++ 	// Log keys
++ 	'LOG_PHPBB_MEDIA_EMBED_CACHE_PURGED'=> '<strong>Caché Media Embed cache limpiado</strong>',
++ 	'LOG_PHPBB_MEDIA_EMBED_MANAGE'		=> '<strong>Sitios de Media Embed actualizados</strong>',
++-	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Ajustes de Media Embed actualizados</strong>',
+++	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Ajustes de Media Embed actualziados</strong>',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es_x_tu/acp.php"
++index 1debbb24b..3c4adb083 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es_x_tu/acp.php"
++@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Ajustes de Media Embed',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aquí puedes configurar los ajustes del PlugIn Media Embed.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[media]</samp> en la página de publicación',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[MEDIA]</samp> en la página de publicación',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Si se deshabilita, el botón BBCode no será mostrado, pero los usuarios aún podrán seguir usando la etiqueta <samp>[media]</samp> en sus mensajes',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opciones',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Permitir en firmas de usuario',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es_x_tu/help.php"
++index c9940503d..128d5a5bb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es_x_tu/help.php"
++@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Cómo insertar medios de otros sitios en los mensajes',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Los usuarios pueden incorporar contenido como videos y audio desde sitios permitidos usando
++ 										las etiquetas <strong>[media][/media]</strong>, o simplemente publicando una URL soportada
++-										en texto plano. Por ejemplo:<br><br>
+++										en texto plano. Por ejemplo:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Como se indicó anteriormente, el enlace también podría utilizarse sin las
+++										<br /><br />Como se indicó anteriormente, el enlace también podría utilizarse sin las
++ 										etiquetas <strong>[media]</strong>.
++-										<br><br>El ejemplo mostrado aquí generaría:<br><br>%2$s
++-										<br><br>Los siguientes sitios son compatibles:<br><samp>%3$s.</samp>
++-										<br><br>Para obtener una documentación completa sobre los sitios admitidos, y las URL de ejemplo,
+++										<br /><br />El ejemplo mostrado aquí generaría:<br /><br />%2$s
+++										<br /><br />Los siguientes sitios son compatibles:<br /><samp>%3$s.</samp>
+++										<br /><br />Para obtener una documentación completa sobre los sitios admitidos, y las URL de ejemplo,
++ 										visite la <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										Documentación del PlugIn MediaEmbed</a>.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/info_acp_mediaembed.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es_x_tu/info_acp_mediaembed.php"
++index b3c5569ce..7aab0593d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/info_acp_mediaembed.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/es_x_tu/info_acp_mediaembed.php"
++@@ -26,5 +26,5 @@ $lang = array_merge($lang, [
++ 	// Log keys
++ 	'LOG_PHPBB_MEDIA_EMBED_CACHE_PURGED'=> '<strong>Caché Media Embed cache limpiado</strong>',
++ 	'LOG_PHPBB_MEDIA_EMBED_MANAGE'		=> '<strong>Sitios de Media Embed actualizados</strong>',
++-	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Ajustes de Media Embed actualizados</strong>',
+++	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Ajustes de Media Embed actualziados</strong>',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/es_x_tu/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/et/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/et/acp.php"
++index 0f76ddaa2..8e5690ad6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/et/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/et/acp.php"
++@@ -24,7 +24,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Manustatud meedia seaded',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Sellel leheküljel on sul võimalik seadistada laienduse manustatud meedia seadeid.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Näita <samp>[media]</samp> BBkoodi positamise leheküljel',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Näita <samp>[MEDIA]</samp> BBkoodi positamise leheküljel',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Kui pole lubatud, siis BBkoodi nuppu ei näidata, kuid siiski on kasutajatel võimalik kasutada e <samp>[media]</samp> silti oma postitustes.',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Luba kasutaja signatuurides',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/et/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/et/help.php"
++index 73373fcc5..f22f41389 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/et/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/et/help.php"
++@@ -42,12 +42,13 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA'			=> 'Meedia manustamine',
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Kuidas manustada meediat teiselt veebileheküljelt postitusse',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Kasutajatel on võimalik manustada sisu nagu näiteks videosi ja helifaile lubatud veebilehekülgedelt kasutades
++-										<strong>[media][/media]</strong> silte või lihtsalt postitades toetatud veebiaadresse puhta tekstina. Näiteks:<br><br>
+++										<strong>[media][/media]</strong> silte või lihtsalt postitades toetatud veebiaadresse puhta tekstina. Näiteks:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Nii nagu eespool öeldud, siis aadressi on võimalik kasutada ka ilma
+++										<br /><br />Nii nagu eespool öeldud, siis aadressi on võimalik kasutada ka ilma
++ 										<strong>[media]</strong> siltideta.
++-										<br><br>Siin toodud näide tekitab aga tulemuseks sellise:<br><br>%2$s
++-										<br><br>Toetatud on järgmised veebilehed:<br><samp>%3$s.</samp>
++-										<br><br>Et näha täielikku dokumentatsiooni toeatatutest lehekülgedest, ning näidis aadressidest, palun külasta <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+++										<br /><br />Siin toodud näide tekitab aga tulemuseks sellise:<br /><br />%2$s
+++										<br /><br />Toetatud on järgmised veebilehed:<br /><samp>%3$s.</samp>
+++										<br /><br />Et näha täielikku dokumentatsiooni toeatatutest lehekülgedest, ning näidis aadressidest, palun külasta <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										lehekülge</a>.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/et/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/et/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/et/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/fr/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/fr/acp.php"
++index 209a3d2b1..cd0b80be7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/fr/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/fr/acp.php"
++@@ -43,11 +43,11 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Paramètres des médias intégrés',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Depuis cette page il est possible de paramétrer les options de l’extension « phpBB Media Embed PlugIn ».',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Afficher le BBCode <samp>[media]</samp> sur la page de rédaction des messages',
++-	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Permet d’activer l’affichage du BBCode <samp>[media]</samp> sur la page de l’éditeur complet lors de la rédaction d’une réponse ou d’un nouveau sujet. Si l’affichage est désactivé, le bouton du BBCode ne sera pas affiché, mais les utilisateurs pourront saisir manuellement la balise <samp>[media]</samp> dans leurs messages sur les pages accessibles au moyen des boutons « Répondre », « Nouveau sujet » ou dans la réponse rapide.',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Afficher le BBCode <samp>[MEDIA]</samp> sur la page de rédaction des messages',
+++	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Permet d’activer l’affichage du BBCode <samp>[MEDIA]</samp> sur la page de l’éditeur complet lors de la rédaction d’une réponse ou d’un nouveau sujet. Si l’affichage est désactivé, le bouton du BBCode ne sera pas affiché, mais les utilisateurs pourront saisir manuellement la balise <samp>[media]</samp> dans leurs messages sur les pages accessibles au moyen des boutons « Répondre », « Nouveau sujet » ou dans la réponse rapide.',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Autoriser dans la signature des membres',
++-	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'Permet d’utiliser le BBCode <samp>[media]</samp> dans le contenu de la signature des membres.',
+++	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'Permet d’utiliser le BBCode <samp>[MEDIA]</samp> dans le contenu de la signature des membres.',
++ 	'ACP_MEDIA_CACHE_LEGEND'			=> 'Content caching',
++ 	'ACP_MEDIA_ENABLE_CACHE'			=> 'Activer le cache des médias intégrés',
++ 	'ACP_MEDIA_ENABLE_CACHE_EXPLAIN'	=> 'Permet d’améliorer les performances via la mise en cache des informations recueillies localement sur les sites. En effet, dans certains cas il est possible de remarquer des performances dégradées lors du chargement de médias à partir d’autres sites, en particulier lorsque le même contenu est chargé plusieurs fois (par exemple lors de la modification d’un message).',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/fr/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/fr/help.php"
++index 06dbbf89a..5a9a00a8a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/fr/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/fr/help.php"
++@@ -43,13 +43,14 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Intégrer un média dans les messages provenant d’un service d’un autre site Web',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Les utilisateurs peuvent intégrer du contenu multimédia (audio, vidéo) provenant de services fournis
++ 										par d’autres sites Web en utilisant les balises du BBCode <strong>[media][/media]</strong>,
++-										ou en publiant simplement l’adresse URL d’un lien pris en charge. Tel que, par exemple :<br><br>
+++										ou en publiant simplement l’adresse URL d’un lien pris en charge. Tel que, par exemple :<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Comme indiqué précédemment, le lien peut aussi être utilisé sans
+++										<br /><br />Comme indiqué précédemment, le lien peut aussi être utilisé sans
++ 										les balises du BBCode <strong>[media]</strong>.
++-										<br><br>Ainsi, l’exemple montré ci-dessus affichera :<br><br>%2$s
++-										<br><br>Le services des sites Web suivants sont supportés :<br><samp>%3$s.</samp>
++-										<br><br>Une documentation complète à propos des services et des exemples d’adresses URL pris en charge,
+++										<br /><br />Ainsi, l’exemple montré ci-dessus affichera :<br /><br />%2$s
+++										<br /><br />Le services des sites Web suivants sont supportés :<br /><samp>%3$s.</samp>
+++										<br /><br />Une documentation complète à propos des services et des exemples d’adresses URL pris en charge,
++ 										est disponible depuis la page : <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										Sites pris en charges par le plugin MediaEmbed</a>.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/fr/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/fr/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/fr/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/it/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/it/acp.php"
++index dc83ff4da..839efff0e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/it/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/it/acp.php"
++@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Impostazioni PlugIn Media Embed',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Qui puoi configurare le impostazioni per il PlugIn Media Embed.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Visualizza BBCode <samp>[media]</samp> nella pagina di scrittura',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Visualizza BBCode <samp>[MEDIA]</samp> nella pagina di scrittura',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Se non consentito, il pulsante BBCode non verrà visualizzato, tuttavia gli utenti possono ancora utilizzare il tag <samp> [media] </samp> nei loro messaggi',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opzioni',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Consenti nelle firme utente',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/it/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/it/help.php"
++index 587143b4b..50676fbbd 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/it/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/it/help.php"
++@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Come incorporare i contenuti multimediali da altri siti nei messaggi',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Gli utenti possono incorporare contenuti come video e audio dai siti consentiti utilizzando
++ 										i tags <strong>[media][/media]</strong>, o semplicemente postando in testo normale un URL
++-                                        che lo supporta. Per esempio:<br><br>
+++                                        che lo supporta. Per esempio:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Come notato sopra, il collegamento potrebbe anche essere utilizzato senza
+++										<br /><br />Come notato sopra, il collegamento potrebbe anche essere utilizzato senza
++ 										<strong>[media]</strong> tags.
++-										<br><br>L’esempio mostrato qui genererebbe:<br><br>%2$s
++-										<br><br>Sono supportati i seguenti siti:<br><samp>%3$s.</samp>
++-										<br><br>Per la documentazione completa sui siti supportati e sugli URL di esempio,
+++										<br /><br />L’esempio mostrato qui genererebbe:<br /><br />%2$s
+++										<br /><br />Sono supportati i seguenti siti:<br /><samp>%3$s.</samp>
+++										<br /><br />Per la documentazione completa sui siti supportati e sugli URL di esempio,
++ 										consulta la <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										Documentazione sul plug-in multimediale incorporato</a>.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/it/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/it/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/it/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/nl/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/nl/acp.php"
++index ba7bb9d1e..1e812bcd5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/nl/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/nl/acp.php"
++@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Media Embed Instellingen',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Hier kunt u instellingen voor de Media Embed PlugIn configureren.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Toon de <samp>[media]</samp> BBCode op de reactie pagina',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Toon de <samp>[MEDIA]</samp> BBCode op de reactie pagina',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Als dit is niet toegestaan zal de BBCode knop niet worden getoond maar gebruikers kunnen nog steeds de <samp>[media]</samp> tag in berichten gebruiken',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Toestaan in onderschriften',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/nl/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/nl/help.php"
++index 9a1751558..08c248ab2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/nl/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/nl/help.php"
++@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Hoe voeg je media van andere website in in je berichten',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Gebruikers kunnen inhoud zoals video\'s en audo invoegen van toegestane websites met gebruik van
++ 										de <strong>[media][/media]</strong> tags, of door heel simpel het plaatsen van een ondersteunde
++-										URL in platte tekst. Als voorbeeld:<br><br>
+++										URL in platte tekst. Als voorbeeld:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Zoals we zien hierboven kan de link ook worden gebruikt zonder de
+++										<br /><br />Zoals we zien hierboven kan de link ook worden gebruikt zonder de
++ 										<strong>[media]</strong> tags.
++-										<br><br>Bovenstaand voorbeeld geeft als resultaat:<br><br>%2$s
++-										<br><br>De volgende websites worden ondersteund:<br><samp>%3$s.</samp>
++-										<br><br>Voor de volledige documentatie op ondersteunde websites en voorbeeld URL\'s,
+++										<br /><br />Bovenstaand voorbeeld geeft als resultaat:<br /><br />%2$s
+++										<br /><br />De volgende websites worden ondersteund:<br /><samp>%3$s.</samp>
+++										<br /><br />Voor de volledige documentatie op ondersteunde websites en voorbeeld URL\'s,
++ 										bezoekt u de <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										MediaEmbed Plugin Documentatie</a>.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/nl/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/nl/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/nl/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pl/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pl/acp.php"
++index b83503f6a..55fc24115 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pl/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pl/acp.php"
++@@ -24,21 +24,21 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Ustawienia osadzania multimediów',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Tutaj można dokonać konfiguracji rozszerzenia Media Embed.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Wyświetl znacznik BBcode <samp>[media]</samp> na forum',
++-	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Jeśli wybrano Nie, to znacznik <samp>[media]</samp> nie będzie wyświetlony, jednakże nadal można go używać na forum.',
++-	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opcje',
++-	'ACP_MEDIA_ALLOW_SIG'				=> 'Znacznik <samp>[media]</samp> w podpisach',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Wyświetl znacznik BBcode <samp>[MEDIA]</samp> na forum',
+++	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Jeśli wybrano Nie, to znacznik <samp>[MEDIA]</samp> nie będzie wyświetlony, jednakże nadal można go używać na forum.',
+++	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+++	'ACP_MEDIA_ALLOW_SIG'				=> 'Znacznik <samp>[MEDIA]</samp> w podpisach',
++ 	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'Zezwól na używanie multimediów w sygnaturze.',
++-	'ACP_MEDIA_CACHE_LEGEND'			=> 'Buforowanie zawartości',
+++	'ACP_MEDIA_CACHE_LEGEND'			=> 'Content caching',
++ 	'ACP_MEDIA_ENABLE_CACHE'			=> 'Pamięć podręczna osadzania multimediów',
++ 	'ACP_MEDIA_ENABLE_CACHE_EXPLAIN'	=> 'W niektórych przypadkach ładowanie multimediów może działać wolniej, np. podczas ponownego ładowania treści przy edycji posta. Włączenie pamięci podręcznej może poprawić wydajność osadzania multimediów.',
++ 	'ACP_MEDIA_PARSE_URLS'				=> 'Konwersja adresów URL',
++ 	'ACP_MEDIA_PARSE_URLS_EXPLAIN'		=> 'Jeśli wybrano Tak, to adresy URL zostaną przekonwertowane bez użycia znacznika BBCode <samp>[media]</samp> lub <samp>[url]</samp>. Ta opcja wpłynie tylko na nowo osadzone multimedia. Dotychczasowe adresy URL nie zostaną przetworzone.',
++-	'ACP_MEDIA_WIDTH_LEGEND'			=> 'Rozmiar zawartości',
++-	'ACP_MEDIA_FULL_WIDTH'				=> 'Tryb pełnoekranowy',
++-	'ACP_MEDIA_FULL_WIDTH_EXPLAIN'		=> 'Włącz tę opcję, aby rozszerzyć większość osadzonych multimediów do szerokości obszaru treści posta, zachowując jednocześnie jego natywne proporcje.',
++-	'ACP_MEDIA_MAX_WIDTH'				=> 'Niestandardowy tryb pełnoekranowy',
++-	'ACP_MEDIA_MAX_WIDTH_EXPLAIN'		=> 'Użyj tego pola, aby zdefiniować maksymalną szerokość multimediów dla poszczególnych witryn. Zastąpi to domyślną szerokość zdefiniowana w polu wyżej. Wprowadź każdą witrynę w nowym wierszu, używając formatu <samp class="error">siteId:szerokość</samp> przy pomocy <samp class="error">px</samp> lub <samp class="error">%</samp>. Na przykład:<br><br><samp class="error">youtube:80%</samp><br><samp class="error">funnyordie:480px</samp><br><br><i><strong class="error">Wskazówka:</strong> Najedź kursorem myszy na witrynę na stronie ”Zarządzaj stronami”, aby wyświetlić nazwę identyfikatora witryny do użycia w tym miejscu.</i>',
+++	'ACP_MEDIA_WIDTH_LEGEND'			=> 'Content sizing',
+++	'ACP_MEDIA_FULL_WIDTH'				=> 'Enable full width content',
+++	'ACP_MEDIA_FULL_WIDTH_EXPLAIN'		=> 'Enable this to expand most Media Embed content to fill the full width of the post content area while maintaining its native aspect ratio.',
+++	'ACP_MEDIA_MAX_WIDTH'				=> 'Custom max-width content',
+++	'ACP_MEDIA_MAX_WIDTH_EXPLAIN'		=> 'Use this field to define custom max-width values for individual sites. This will override the default size and the full width option above. Enter each site on a new line, using the format <samp class="error">siteId:width</samp> with either <samp class="error">px</samp> or <samp class="error">%</samp>. For example:<br><br><samp class="error">youtube:80%</samp><br><samp class="error">funnyordie:480px</samp><br><br><i><strong class="error">Tip:</strong> Hover your mouse over a site on the Manage sites page to reveal the site id name to use here.</i>',
++ 	'ACP_MEDIA_PURGE_CACHE'				=> 'Wyczyść pamięć podręczną',
++ 	'ACP_MEDIA_PURGE_CACHE_EXPLAIN'		=> 'Pamięć podręczna osadzania multimediów jest codziennie, automatycznie czyszczona. Można ją usunąć teraz poprzez kliknięcie przycisku.',
++ 	'ACP_MEDIA_SITE_TITLE'				=> 'ID strony: %s',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pl/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pl/help.php"
++index 92f062072..4fafe153c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pl/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pl/help.php"
++@@ -43,11 +43,12 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Jak wyświetlić multimedia z innych stron na forum',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Użytkownicy mogą wyświetlić zawartość z innych stron jak wideo lub muzyka
++ 										poprzez znacznik <strong>[media][/media]</strong>. Należy wkleić adres URL pomiędzy znacznikami.
++-										<br><br>Na przykład:
+++										<br /><br />Na przykład:
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Powyższy adres URL zostanie wyświetlony jak pokazano poniżej:<br><br>%2$s
++-										<br><br>Na forum wspierane są strony:<br><samp>%3$s.</samp>
++-										<br><br>Dokumentacja wraz z wszystkimi wspieranymi stronami i przykładami adresów URL
+++										<br /><br />Powyższy adres URL zostanie wyświetlony jak pokazano poniżej:<br /><br />%2$s
+++										<br /><br />Na forum wspierane są strony:<br /><samp>%3$s.</samp>
+++										<br /><br />Dokumentacja wraz z wszystkimi wspieranymi stronami i przykładami adresów URL
++ 										znajduje się pod linkiem <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										MediaEmbed Plugin Documentation</a>.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pl/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pl/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pl/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt/acp.php"
++index 8e8c27b67..98f166a4c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt/acp.php"
++@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Configurações do Media Embed',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aqui você pode configurar as configurações para o Media Embed PlugIn.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[media]</samp> na página de postagem',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[MEDIA]</samp> na página de postagem',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Se não for permitido, o botão BBCode não será exibido, no entanto, os usuários ainda podem usar a tag <samp>[media]</samp> em suas postagens',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Permitir em assinaturas de usuários',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt/help.php"
++index e95331f34..106ec85be 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt/help.php"
++@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Como inserir mídia de outros sites em postagens',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Os usuários podem incorporar conteúdo como vídeos e áudio de sites permitidos usando
++ 										as tags <strong>[media][/media]</strong>, ou simplesmente postando uma
++-										URL suportada em texto simples. Por exemplo:<br><br>
+++										URL suportada em texto simples. Por exemplo:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Conforme mencionado acima, o link também pode ser usado sem as tags
+++										<br /><br />Conforme mencionado acima, o link também pode ser usado sem as tags
++ 										<strong>[media]</strong>.
++-										<br><br>O exemplo mostrado aqui geraria:<br><br>%2$s
++-										<br><br>Os seguintes sites são suportados:<br><samp>%3$s.</samp>
++-										<br><br>Para obter documentação completa sobre sites suportados e URLs de exemplo,
+++										<br /><br />O exemplo mostrado aqui geraria:<br /><br />%2$s
+++										<br /><br />Os seguintes sites são suportados:<br /><samp>%3$s.</samp>
+++										<br /><br />Para obter documentação completa sobre sites suportados e URLs de exemplo,
++ 										visite a <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										MediaEmbed Plugin Documentation</a>.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt_br/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt_br/acp.php"
++index f65252d3f..621c54579 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt_br/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt_br/acp.php"
++@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Configurações do Media Embed',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aqui você pode configurar as configurações para o Media Embed PlugIn.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[media]</samp> na página de postagem',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[MEDIA]</samp> na página de postagem',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Se não for permitido, o botão BBCode não será exibido, no entanto, os usuários ainda podem usar a tag <samp>[media]</samp> em suas postagens',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Permitir em assinaturas de usuários',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt_br/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt_br/help.php"
++index e6f91ca2e..80f8e08e0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt_br/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/pt_br/help.php"
++@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Como inserir mídia de outros sites em postagens',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Os usuários podem incorporar conteúdo como vídeos e áudio de sites permitidos usando
++ 										as tags <strong>[media][/media]</strong>, ou simplesmente postando uma
++-										URL suportada em texto simples. Por exemplo:<br><br>
+++										URL suportada em texto simples. Por exemplo:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Conforme mencionado acima, o link também pode ser usado sem as tags
+++										<br /><br />Conforme mencionado acima, o link também pode ser usado sem as tags
++ 										<strong>[media]</strong>.
++-										<br><br>O exemplo mostrado aqui geraria:<br><br>%2$s
++-										<br><br>Os seguintes sites são suportados:<br><samp>%3$s.</samp>
++-										<br><br>Para obter documentação completa sobre sites suportados e URLs de exemplo,
+++										<br /><br />O exemplo mostrado aqui geraria:<br /><br />%2$s
+++										<br /><br />Os seguintes sites são suportados:<br /><samp>%3$s.</samp>
+++										<br /><br />Para obter documentação completa sobre sites suportados e URLs de exemplo,
++ 										visite a <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										MediaEmbed Plugin Documentation</a>.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt_br/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt_br/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/pt_br/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/acp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/acp.php"
++deleted file mode 100644
++index d4864a65c..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/acp.php"
+++++ /dev/null
++@@ -1,54 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	// Settings
++-	'ACP_MEDIA_SETTINGS'				=> 'Setări de încorporare media',
++-	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aici puteți configura setările pentru Media Embed PlugIn.',
++-	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Afișați <samp>[MEDIA]</samp> BBCode pe pagina de postare',
++-	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Dacă nu este permis, butonul BBCode nu va fi afișat, totuși utilizatorii pot folosi în continuare eticheta <samp>[media]</samp> în postările lor.',
++-	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opțiuni',
++-	'ACP_MEDIA_ALLOW_SIG'				=> 'Permiteți în semnăturile utilizatorilor',
++-	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'Permiteți semnăturilor utilizatorilor să afișeze conținut media încorporat.',
++-	'ACP_MEDIA_CACHE_LEGEND'			=> 'Memorarea în cache a conținutului',
++-	'ACP_MEDIA_ENABLE_CACHE'			=> 'Activați cacheul Media Embed',
++-	'ACP_MEDIA_ENABLE_CACHE_EXPLAIN'	=> 'În unele cazuri, este posibil să observați o performanță mai lentă decât cea normală atunci când încărcați conținut media de pe alte site-uri, mai ales când încărcați același conținut de mai multe ori (de exemplu, când editați o postare). Activarea acestui lucru va stoca în cache informațiile pe care Media Embed le adună de pe site-uri la nivel local și ar trebui să îmbunătățească performanța.',
++-	'ACP_MEDIA_PARSE_URLS'				=> 'Convertiți adrese URL simple',
++-	'ACP_MEDIA_PARSE_URLS_EXPLAIN'		=> 'Activați această opțiune pentru a converti adresele URL simple (nu sunt incluse în etichete <samp>[media]</samp> sau <samp>[url]</samp>) în conținut media încorporat. Rețineți că modificarea acestei setări va afecta numai postările noi, deoarece postările existente au fost deja analizate.',
++-	'ACP_MEDIA_WIDTH_LEGEND'			=> 'Dimensiunea conținutului',
++-	'ACP_MEDIA_FULL_WIDTH'				=> 'Activați conținutul cu lățime completă',
++-	'ACP_MEDIA_FULL_WIDTH_EXPLAIN'		=> 'Activați această opțiune pentru a extinde majoritatea conținutului Media Embed pentru a umple întreaga lățime a zonei de conținut postare, păstrând în același timp raportul de aspect nativ.',
++-	'ACP_MEDIA_MAX_WIDTH'				=> 'Conținut personalizat cu lățime maximă',
++-	'ACP_MEDIA_MAX_WIDTH_EXPLAIN'		=> 'Utilizați acest câmp pentru a defini valori personalizate pentru lățimea maximă pentru site-uri individuale. Aceasta va suprascrie dimensiunea implicită și opțiunea de lățime completă de mai sus. Introduceți fiecare site pe o nouă linie, folosind formatul <samp class="error">siteId:width</samp> fie cu <samp class="error">px</samp>, fie cu <samp class="error">%</samp>. De exemplu:<br><br><samp class="error">youtube:80%</samp><br><samp class="error">funnyordie:480px</samp><br><br><i><strong class="error">Sfat:</strong> treceți mouse-ul peste un site din pagina Gestionați site-urile pentru a dezvălui numele de cod al site-ului de utilizat aici.</i>',
++-	'ACP_MEDIA_PURGE_CACHE'				=> 'Ștergeți memoria cache încorporată',
++-	'ACP_MEDIA_PURGE_CACHE_EXPLAIN'		=> 'Cacheul Media Embed este curățat automat o dată pe zi, totuși acest buton poate fi folosit pentru a-și curăța manual memoria cache acum.',
++-	'ACP_MEDIA_SITE_TITLE'				=> 'Id-ul site-ului: %s',
++-	'ACP_MEDIA_SITE_DISABLED'			=> 'Acest site intră în conflict cu un BBCode existent: [%s]',
++-	'ACP_MEDIA_ERROR_MSG'				=> 'Au fost întâlnite următoarele erori:<br><br>%s',
++-	'ACP_MEDIA_INVALID_SITE'			=> '%1$s:%2$s :: “%1$s” nu este un ID valid de site',
++-	'ACP_MEDIA_INVALID_WIDTH'			=> '%1$s:%2$s :: “%2$s” nu este o lățime validă în „px” sau “%%”',
++-
++-	// Manage sites
++-	'ACP_MEDIA_MANAGE'					=> 'Gestionați site-urile de încorporare media',
++-	'ACP_MEDIA_MANAGE_EXPLAIN'			=> 'Aici puteți gestiona site-urile din care doriți să permiteți pluginului Media Embed să afișeze conținut.',
++-	'ACP_MEDIA_SITES_ERROR'				=> 'Nu există site-uri media de afișat.',
++-	'ACP_MEDIA_SITES_MISSING'			=> 'Următoarele site-uri nu mai sunt acceptate sau nu mai funcționează. Vă rugăm să retrimiteți această pagină pentru a le elimina.',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/common.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/common.php"
++deleted file mode 100644
++index 9be890b72..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/common.php"
+++++ /dev/null
++@@ -1,42 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-/**
++- * DO NOT CHANGE
++- */
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
++-
++-$lang = array_merge($lang, [
++-	'BBCODE_MEDIA_HELP'	=> 'Media Embed: [media]http://media_url[/media]',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/help.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/help.php"
++deleted file mode 100644
++index 89eb4e1f3..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/help.php"
+++++ /dev/null
++@@ -1,54 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-/**
++- * DO NOT CHANGE
++- */
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
++-
++-$lang = array_merge($lang, [
++-	'HELP_EMBEDDING_MEDIA'			=> 'Încorporarea media',
++-	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Cum să încorporați media de pe alte site-uri în postări',
++-	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Utilizatorii pot încorpora conținut, cum ar fi videoclipuri și audio de pe site-uri permise folosind
++-                                        etichetele <strong>[media][/media]</strong> sau pur și simplu de la postarea unui mesaj acceptat
++-                                        URL în text simplu. De exemplu:<br /><br />
++-                                        <strong>[media]</strong>%1$s<strong>[/media]</strong>
++-                                        <br /><br />Așa cum sa menționat mai sus, linkul ar putea fi folosit și fără
++-                                        etichete <strong>[media]</strong>.
++-                                        <br /><br />Exemplul prezentat aici ar genera:<br /><br />%2$s
++-                                        <br /><br />Sunt acceptate următoarele site-uri:<br /><samp>%3$s.</samp>
++-                                        <br /><br />Pentru documentația completă despre site-urile acceptate și exemple de adrese URL,
++-                                        accesați <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++-                                        Documentația pluginului MediaEmbed</a>.',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/info_acp_mediaembed.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/info_acp_mediaembed.php"
++deleted file mode 100644
++index 31ab8cb4b..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/info_acp_mediaembed.php"
+++++ /dev/null
++@@ -1,30 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'ACP_PHPBB_MEDIA_EMBED'				=> 'Media Embed',
++-	'ACP_PHPBB_MEDIA_EMBED_MANAGE'		=> 'Gestionați site-urile',
++-	'ACP_PHPBB_MEDIA_EMBED_SETTINGS'	=> 'Setări',
++-
++-	// Log keys
++-	'LOG_PHPBB_MEDIA_EMBED_CACHE_PURGED'=> '<strong>Memoria cache pentru Media Embed a fost eliminată</strong>',
++-	'LOG_PHPBB_MEDIA_EMBED_MANAGE'		=> '<strong>Site-urile Media Embed au fost actualizate</strong>',
++-	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Setările pentru Media Embed au fost actualizate</strong>',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/install.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/install.php"
++deleted file mode 100644
++index 0b9296a30..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/install.php"
+++++ /dev/null
++@@ -1,43 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2019 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-/**
++- * DO NOT CHANGE
++- */
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
++-
++-$lang = array_merge($lang, [
++-	'PHPBB_VERSION_ERROR'	=> 'Forumul dvs. pare să folosească o versiune mai veche a phpBB. phpBB ' . \phpbb\mediaembed\ext::PHPBB_MINIMUM . ' sau mai nou este necesar pentru a utiliza această extensie.',
++-	'S9E_MEDIAEMBED_ERROR'	=> 'Am detectat extensia s9e/mediaembed. Pluginul Media Embed al phpBB nu poate fi instalat până când nu dezactivați, curățați și ștergeți toate fișierele legate de extensia s9e/mediaembed.',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/permissions_mediaembed.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/permissions_mediaembed.php"
++deleted file mode 100644
++index fe8235c2c..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/permissions_mediaembed.php"
+++++ /dev/null
++@@ -1,36 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-
++-$lang = array_merge($lang, [
++-	'ACL_F_MEDIAEMBED'		=> 'Poate folosi eticheta [media] BBCode',
++-	'ACL_U_PM_MEDIAEMBED'	=> 'Poate folosi eticheta [media] BBCode în mesajele private',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ro/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ru/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ru/acp.php"
++index cb5053dae..a90b82cb5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ru/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ru/acp.php"
++@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Настройки Media Embed',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Здесь вы можете настроить параметры для Media Embed.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Показывать <samp>[media]</samp> бб-код на странице размещения сообщений',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Показывать <samp>[MEDIA]</samp> бб-код на странице размещения сообщений',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Если это запрещено, кнопка бб-кода не отображается, но пользователи могут использовать <samp>[media]</samp> бб-код в своих сообщениях.',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Разрешить в подписях пользователей',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ru/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ru/help.php"
++index 939e837df..ca0ab1e74 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ru/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/ru/help.php"
++@@ -41,11 +41,12 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA'			=> 'Встраивание мультимедиа',
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Как вставлять медиа с других сайтов в сообщения?',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Пользователи могут вставлять контент, например, видео и аудио с разрешенных сайтов, используя бб-код
++-										<strong>[media][/media]</strong>, или просто вставив поддерживаемую ссылку в текстовом формате. Например:<br><br>
+++										<strong>[media][/media]</strong>, или просто вставив поддерживаемую ссылку в текстовом формате. Например:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Как говорилось выше, ссылка также может использоваться без бб-кода <strong>[media]</strong>.
++-										<br><br>Пример, показанный здесь, будет генерировать:<br><br>%2$s
++-										<br><br>Поддерживаются следующие сайты::<br><samp>%3$s.</samp>
++-										<br><br>Полную документацию о поддерживаемых сайтах и ​​URL-адресах смотрите на странице <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+++										<br /><br />Как говорилось выше, ссылка также может использоваться без бб-кода <strong>[media]</strong>.
+++										<br /><br />Пример, показанный здесь, будет генерировать:<br /><br />%2$s
+++										<br /><br />Поддерживаются следующие сайты::<br /><samp>%3$s.</samp>
+++										<br /><br />Полную документацию о поддерживаемых сайтах и ​​URL-адресах смотрите на странице <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										Документация MediaEmbed</a>.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ru/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ru/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/ru/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/sk/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/sk/acp.php"
++index 7bca02eda..defec34f7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/sk/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/sk/acp.php"
++@@ -24,7 +24,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Nastavenia vkladania médií',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Tu môžete konfigurovať nastavenia pre plugin vkladania médií.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zobraziť <samp>[media]</samp> BB kód pri prispievaní',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zobraziť <samp>[MEDIA]</samp> BB kód pri prispievaní',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Ak je toto nezaškrtnuté, BB kód nebude zobrazený, no používatelia budú môcť používať <samp>[media]</samp> kód v ich príspevkoch',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Povoliť v podpisoch',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/sk/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/sk/help.php"
++index 4ad418a7c..f0c698455 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/sk/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/sk/help.php"
++@@ -43,13 +43,14 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Ako vložiť obsah z inej stránky do príspevku',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Používatelia môžu vložiť obsah (napríklad video alebo zvuk z povolených stránok použítím
++ 										<strong>[media][/media]</strong> kódu alebo jednoducho odoslať podporovanú
++-										URL v texte. Napríklad:<br><br>
+++										URL v texte. Napríklad:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Ako je uvedené vyššie, odkaz môže byť použitý bez
+++										<br /><br />Ako je uvedené vyššie, odkaz môže byť použitý bez
++ 										<strong>[media]</strong> kódu.
++-										<br><br>Príklad zobrazený tuto vygeneruje:<br><br>%2$s
++-										<br><br>Podporované sú tieto stránky:<br><samp>%3$s.</samp>
++-										<br><br>Pre kompletnú dokumentáciu ohľadom podporovaných stránok a príkladov adries
+++										<br /><br />Príklad zobrazený tuto vygeneruje:<br /><br />%2$s
+++										<br /><br />Podporované sú tieto stránky:<br /><samp>%3$s.</samp>
+++										<br /><br />Pre kompletnú dokumentáciu ohľadom podporovaných stránok a príkladov adries
++ 										navštívte <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										dokumentáciu pluginu vkladania médií</a> (v Angličtine).',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/sk/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/sk/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/sk/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/tr/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/tr/acp.php"
++index efe3af701..9994a895b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/tr/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/tr/acp.php"
++@@ -24,7 +24,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> 'Medya (Ortam) Yerleştirme Ayarları',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Buradan Medya (Ortam) Yerleştirme Eklentisi için ayarları yapabilirsiniz.',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> '<samp>[media]</samp> BBCode butonunu mesaj gönderme sayfasında göster',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> '<samp>[MEDIA]</samp> BBCode butonunu mesaj gönderme sayfasında göster',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'İzin verilmediği takdirde, BBCode butonu gösterilmeyecektir, ancak kullanıcılar hala <samp>[media]</samp> etiketini kendi mesajlarında kullanabilir',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> 'Kullanıcı imzalarında izin ver',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/tr/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/tr/help.php"
++index 3f330137e..2516cc4b1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/tr/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/tr/help.php"
++@@ -43,13 +43,14 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Diğer sitelerden alınan medya(ortam) içerikleri mesajların içerisine nasıl yerleştirilir',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Kullanıcılar izin verilen sitelerden aldığı video ve ses gibi içerikleri
++ 										<strong>[media][/media]</strong> etiketlerini kullanarak, ya da düz metin içerisine desteklenen URL adreslerini basit bir şekilde ekleyerek
++-										mesajlara yerleştirebilir. Örneğin:<br><br>
+++										mesajlara yerleştirebilir. Örneğin:<br /><br />
++ 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>Yukarıda belirtildiği gibi, <strong>[media]</strong> etiketleri olmadan
+++										<br /><br />Yukarıda belirtildiği gibi, <strong>[media]</strong> etiketleri olmadan
++ 										sadece bağlantılar da kullanılabilir.
++-										<br><br>Burada gösterilen örnek şu şekilde oluşturulacaktır:<br><br>%2$s
++-										<br><br>Şu siteler desteklenmektedir:<br><samp>%3$s.</samp>
++-										<br><br>Desteklenen siteler ve örnek URL adresleri hakkında tüm belgeler için,
+++										<br /><br />Burada gösterilen örnek şu şekilde oluşturulacaktır:<br /><br />%2$s
+++										<br /><br />Şu siteler desteklenmektedir:<br /><samp>%3$s.</samp>
+++										<br /><br />Desteklenen siteler ve örnek URL adresleri hakkında tüm belgeler için,
++ 										<a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										MediaEmbed Plugin Belgeleri</a> sayfasını ziyaret edin.',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/tr/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/tr/ucp.php"
++deleted file mode 100644
++index 810e49083..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/tr/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>Embedded Content from Other Websites</h3>
++-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
++-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
++-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hans/acp.php"
++index 6fa9f8fa3..a5eea8488 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hans/acp.php"
++@@ -21,10 +21,10 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge($lang, [
++ 	// Settings
++-	'ACP_MEDIA_SETTINGS'				=> 'Media Embed 设置',
+++	'ACP_MEDIA_SETTINGS'				=> 'Media Embed Settings',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> '这里可设置 Media Embed PlugIn 的相关参数。',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> '在发帖页面显示 <samp>[media]</samp> BBCode',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> '在发帖页面显示 <samp>[MEDIA]</samp> BBCode',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> '若禁用， BBCode 按钮就不会显示，但用户还是可以在帖子中使用 <samp>[media]</samp> 标签。',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> '允许使用在用户签名',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hans/help.php"
++index 3fba339e4..3002815c8 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hans/help.php"
++@@ -51,4 +51,5 @@ $lang = array_merge($lang, [
++ 										<br><br>下面这些网站可以使用：<br><samp>%3$s.</samp>
++ 										<br><br>访问 <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
++ 										MediaEmbed Plugin Documentation</a> 可以查看完整的文档，包括支持的网站和网址列子。',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/permissions_mediaembed.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hans/permissions_mediaembed.php"
++index af76781bf..5450880c1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/permissions_mediaembed.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hans/permissions_mediaembed.php"
++@@ -1,8 +1,5 @@
++ <?php
++ /**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- * @简体中文语言　David Yin <https://www.phpbbchinese.com/>
++  *
++  * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++  *
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/ucp.php"
++deleted file mode 100644
++index 7e4eca562..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hans/ucp.php"
+++++ /dev/null
++@@ -1,32 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- * @简体中文语言　David Yin <https://www.phpbbchinese.com/>
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>来自其它网站的嵌入内容</h3>
++-		“%1$s” 的帖子或内容可能包含来自外部网站的嵌入内容，包括但不限于 YouTube，Facebook，Twitter，和其它类似的平台。来自这些外部网站的嵌入内容表现与你直接访问原始网站相同。
++-		<br><br>这些外部网站可能会收集有关你的数据，使用 cookie，嵌入第三方的跟踪功能，以及监察你同这些嵌入内容的互动，包括在你拥有账户并登入该网站的情况下的跟踪你的互动。
++-		<br><br>请注意，此类活动不受 “%1$s” 的控制，并受相应外部网站的隐私证词和服务条款的约束。我们建议你查看通过嵌入内容与之互动的任何第三方服务的隐私和 Cookie 政策。
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hant/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hant/acp.php"
++index e0848e4e3..f5bde5dbf 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hant/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hant/acp.php"
++@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
++ 	'ACP_MEDIA_SETTINGS'				=> '媒體嵌入設置',
++ 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> '您可以在此處配置媒體嵌入外掛的設定。',
++ 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
++-	'ACP_MEDIA_DISPLAY_BBCODE'			=> '顯示 <samp>[media]</samp> BBCode 在發文的頁面',
+++	'ACP_MEDIA_DISPLAY_BBCODE'			=> '顯示 <samp>[MEDIA]</samp> BBCode 在發文的頁面',
++ 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> '如果不允許，BBCode 按鈕將不會顯示，但會員仍然可以在他們的文章中使用 <samp>[media]</samp> 標籤。',
++ 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
++ 	'ACP_MEDIA_ALLOW_SIG'				=> '允許會員簽名',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hant/help.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hant/help.php"
++index 215a16faf..a206cb97e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hant/help.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/language/zh_cmn_hant/help.php"
++@@ -41,9 +41,10 @@ $lang = array_merge($lang, [
++ 	'HELP_EMBEDDING_MEDIA'			=> '嵌入媒體',
++ 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> '如何將來自其他網站的媒體嵌入到文章中',
++ 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> '會員可以使用 <strong>[media][/media]</strong> 標籤嵌入來自允許網站的視頻和音頻等內容，或者簡單地以純文本形式發表受支持的網址。例如：
++-										<br><br><strong>[media]</strong>%1$s<strong>[/media]</strong>
++-										<br><br>如上所述，連結也可以在沒有 <strong>[media]</strong> 標籤的情況下使用。
++-										<br><br>此處顯示的範例將生成：<br><br>%2$s
++-										<br><br>支持以下站點：<br><samp>%3$s</samp>。
++-										<br><br>有關受支持站點和範例網址的完整文件，參訪 <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">MediaEmbed Plugin Documentation</a>。',
+++										<br /><br /><strong>[media]</strong>%1$s<strong>[/media]</strong>
+++										<br /><br />如上所述，連結也可以在沒有 <strong>[media]</strong> 標籤的情況下使用。
+++										<br /><br />此處顯示的範例將生成：<br /><br />%2$s
+++										<br /><br />支持以下站點：<br /><samp>%3$s</samp>。
+++										<br /><br />有關受支持站點和範例網址的完整文件，參訪 <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">MediaEmbed Plugin Documentation</a>。',
+++	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hant/ucp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hant/ucp.php"
++deleted file mode 100644
++index 0d18e0919..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/language/zh_cmn_hant/ucp.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- * @正體中文化 竹貓星球 <http://phpbb-tw.net/phpbb/>
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'MEDIA_EMBED_PRIVACY_POLICY' => '
++-		<br><br>
++-		<h3>其他網站的嵌入內容</h3>
++-		「%1$s」可能包含嵌入外部網站（包括但不限於 YouTube、Facebook、Twitter 及類似平台）的貼文或內容。嵌入來自這些外部網站的內容的行為與您直接訪問原始網站的行為相同。
++-		<br><br>這些外部網站可能會收集您的資料、使用 Cookies、嵌入額外的第三方追蹤程式並監控您與嵌入內容的互動，包括在您擁有帳戶並登入網站的情況下追蹤您的互動。
++-		<br><br>請注意，此類活動不受「%1$s」的控制，並受相應外部網站的隱私權政策和服務條款約束。我們建議您查看透過嵌入內容與之互動的任何第三方服務的隱私權和 Cookies 政策。
++-	',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/event/overall_header_stylesheets_after.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/BBOOTS/template/event/posting_editor_buttons_custom_tags_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/BBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
++new file mode 100644
++index 000000000..5a461b493
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/BBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
++@@ -0,0 +1,5 @@
+++{% if S_BBCODE_MEDIA %}
+++<button type="button" class="btn btn-default bbcode-media" accesskey="m" name="addmedia" value="Media" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}">
+++	<i class="fa fa-television fa-fw" aria-hidden="true"></i>
+++</button>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++new file mode 100644
++index 000000000..30246b6a7
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++@@ -0,0 +1,10 @@
+++{% if S_MEDIA_EMBED_FULL_WIDTH or S_MEDIA_EMBED_MAX_WIDTHS %}
+++<style>
+++{% if S_MEDIA_EMBED_FULL_WIDTH %}
+++	[data-s9e-mediaembed] { max-width: 100% !important; }
+++{% endif %}
+++{% for item in S_MEDIA_EMBED_MAX_WIDTHS %}
+++	[data-s9e-mediaembed="{{ item.site }}"] { max-width: {{ item.width }} !important; }
+++{% endfor %}
+++</style>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/FLATBOOTS/template/event/posting_editor_buttons_custom_tags_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/FLATBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
++new file mode 100644
++index 000000000..5a461b493
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/FLATBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
++@@ -0,0 +1,5 @@
+++{% if S_BBCODE_MEDIA %}
+++<button type="button" class="btn btn-default bbcode-media" accesskey="m" name="addmedia" value="Media" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}">
+++	<i class="fa fa-television fa-fw" aria-hidden="true"></i>
+++</button>
+++{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/media_embed_bbcode_icon.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/media_embed_bbcode_icon.html"
++deleted file mode 100644
++index bf5f0de9e..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/media_embed_bbcode_icon.html"
+++++ /dev/null
++@@ -1,2 +0,0 @@
++-{# This template will be used in phpBB 4 #}
++-{{ Icon('font', 'tv', '', true, 'fas c-button-icon') }}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/prosilver/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/prosilver/template/event/overall_header_stylesheets_after.html"
++new file mode 100644
++index 000000000..30246b6a7
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/prosilver/template/event/overall_header_stylesheets_after.html"
++@@ -0,0 +1,10 @@
+++{% if S_MEDIA_EMBED_FULL_WIDTH or S_MEDIA_EMBED_MAX_WIDTHS %}
+++<style>
+++{% if S_MEDIA_EMBED_FULL_WIDTH %}
+++	[data-s9e-mediaembed] { max-wi
\ No newline at end of file
diff --git "[ORIGINAL]/phpbb\\mediaembed/event/main_listener.php" "[FORUM_EXT]/phpbb\\mediaembed/event/main_listener.php"
--- "[ORIGINAL]/phpbb\\mediaembed/event/main_listener.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/event/main_listener.php"
@@ -25,9 +25,6 @@ use Symfony\Component\Yaml\Yaml;
  */
 class main_listener implements EventSubscriberInterface
 {
-	/** @var string A link to a rich content media site for demo purposes */
-	public const MEDIA_DEMO_URL = 'https://youtu.be/Ne18ZQ7LLI0';
-
 	/** @var auth */
 	protected $auth;
 
@@ -55,16 +52,13 @@ class main_listener implements EventSubscriberInterface
 	/** @var bool Disable the media tag (bbcode parsing) */
 	protected $disable_tag = false;
 
-	/** @var bool|null Cached result of is_phpbb4() */
-	protected $is_phpbb4;
-
 	/**
 	 * {@inheritDoc}
 	 */
 	public static function getSubscribedEvents()
 	{
 		return [
-			'core.text_formatter_s9e_configure_after'	=> [['add_custom_sites', 3], ['enable_media_sites', 2], ['configure_url_parsing', 1], ['modify_tag_templates', 0]],
+			'core.text_formatter_s9e_configure_after'	=> [['add_custom_sites', 3], ['enable_media_sites', 2], ['configure_url_parsing', 1]],
 			'core.display_custom_bbcodes'				=> 'setup_media_bbcode',
 			'core.permissions'							=> 'set_permissions',
 			'core.help_manager_add_block_before'		=> 'media_embed_help',
@@ -73,7 +67,6 @@ class main_listener implements EventSubscriberInterface
 			'core.message_parser_check_message'			=> [['check_signature'], ['check_magic_urls'], ['check_bbcode_enabled']],
 			'core.text_formatter_s9e_parser_setup'		=> [['disable_media_embed'], ['setup_cache_dir']],
 			'core.page_header' 							=> 'setup_media_configs',
-			'core.page_footer'							=> 'append_agreement',
 		];
 	}
 
@@ -107,29 +100,12 @@ class main_listener implements EventSubscriberInterface
 	 */
 	public function add_custom_sites($event)
 	{
-		$phpbb4_builtins = array_flip([
-			'applepodcasts',
-			'bluesky',
-			'bunny',
-			'facebook',
-			'mastodon',
-			'pastebin',
-			'threads',
-			'twitter',
-			'vk',
-		]);
-
 		foreach ($this->custom_sites->get_collection() as $site)
 		{
-			$name = basename($site, ext::YML);
-
-			// Skip built-in sites when running phpBB 4
-			if (isset($phpbb4_builtins[$name]) && $this->is_phpbb4())
-			{
-				continue;
-			}
-
-			$event['configurator']->MediaEmbed->defaultSites->add($name, Yaml::parseFile($site));
+			$event['configurator']->MediaEmbed->defaultSites->add(
+				basename($site, ext::YML),
+				Yaml::parse(file_get_contents($site))
+			);
 		}
 	}
 
@@ -176,32 +152,6 @@ class main_listener implements EventSubscriberInterface
 		}
 	}
 
-	/**
-	 * Modify bbcode tag templates
-	 *
-	 * @param \phpbb\event\data $event The event object
-	 * @return void
-	 */
-	public function modify_tag_templates($event)
-	{
-		try
-		{
-			// force YouTube to use the no cookies until the user starts video playback, and fix referrer policy issues
-			$tag = $event['configurator']->tags['YOUTUBE'];
-			$tag->template = str_replace('www.youtube.com', 'www.youtube-nocookie.com', $tag->template);
-			if (!$this->is_phpbb4())
-			{
-				$tag->template = str_replace(' allowfullscreen', ' referrerpolicy="origin" allowfullscreen', $tag->template);
-			}
-
-			$event['configurator']->finalize();
-		}
-		catch (\RuntimeException $e)
-		{
-			// do nothing
-		}
-	}
-
 	/**
 	 * Set template switch for displaying the [media] BBCode button
 	 *
@@ -243,14 +193,14 @@ class main_listener implements EventSubscriberInterface
 			]);
 
 			$uid = $bitfield = $flags = '';
-			$demo_text = self::MEDIA_DEMO_URL;
+			$demo_text = $this->language->lang('HELP_EMBEDDING_MEDIA_DEMO');
 			generate_text_for_storage($demo_text, $uid, $bitfield, $flags, true, true);
 			$demo_display = generate_text_for_display($demo_text, $uid, $bitfield, $flags);
 			$list_sites = implode(', ', $this->get_siteIds());
 
 			$this->template->assign_block_vars('faq_block.faq_row', [
 				'FAQ_QUESTION'	=> $this->language->lang('HELP_EMBEDDING_MEDIA_QUESTION'),
-				'FAQ_ANSWER'	=> $this->language->lang('HELP_EMBEDDING_MEDIA_ANSWER', self::MEDIA_DEMO_URL, $demo_display, $list_sites),
+				'FAQ_ANSWER'	=> $this->language->lang('HELP_EMBEDDING_MEDIA_ANSWER', $demo_text, $demo_display, $list_sites),
 			]);
 		}
 	}
@@ -391,34 +341,4 @@ class main_listener implements EventSubscriberInterface
 
 		return $siteIds ? json_decode($siteIds, true) : [];
 	}
-
-	/**
-	 * Appends additional language to the privacy policy agreement text.
-	 *
-	 * @return void
-	 */
-	public function append_agreement()
-	{
-		if (!$this->template->retrieve_var('S_AGREEMENT') || ($this->template->retrieve_var('AGREEMENT_TITLE') !== $this->language->lang('PRIVACY')))
-		{
-			return;
-		}
-
-		$this->language->add_lang('ucp', 'phpbb/mediaembed');
-
-		$this->template->append_var('AGREEMENT_TEXT', $this->language->lang('MEDIA_EMBED_PRIVACY_POLICY', $this->config['sitename']));
-	}
-
-	/**
-	 * @return mixed
-	 */
-	private function is_phpbb4()
-	{
-		if ($this->is_phpbb4 === null)
-		{
-			$this->is_phpbb4 = phpbb_version_compare($this->config['version'], '4.0.0-a1', '>=');
-		}
-
-		return $this->is_phpbb4;
-	}
 }
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/ar/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/ar/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/ar/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/ar/acp.php"
@@ -24,8 +24,8 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'إعدادات إدراج مُحتوى الوسائط',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'من هنا تستطيع ضبط الإعدادات الخاصة بالإضافة “إدراج مُحتوى الوسائط”.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'ظهور زر BBCode للوسائط <samp>[media]</samp>',
-	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'اختيارك “لا”, يعني منع ظهور زر BBCode الخاص بالوسائط <samp>[media]</samp> في محرر الكتابة, وبالرغم من ذلك يستطيع الأعضاء استخدام الوسم <samp>[media]</samp> في مُشاركاتهم.',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'ظهور زر BBCode للوسائط <samp>[MEDIA]</samp>',
+	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'اختيارك “لا”, يعني منع ظهور زر BBCode الخاص بالوسائط <samp>[MEDIA]</samp> في محرر الكتابة, وبالرغم من ذلك يستطيع الأعضاء استخدام الوسم <samp>[media]</samp> في مُشاركاتهم.',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'التوقيعات',
 	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'السماح للعضو بإستخدام وسم الوسائط في التوقيع.',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/ar/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/ar/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/ar/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/ar/help.php"
@@ -43,13 +43,14 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'كيف أستطيع إدراج مُحتوى الوسائط من المواقع الأخرى في المُشاركات؟',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'يستطيع الأعضاء إدراج محتوى الوسائط مثل الفيديو والمقاطع الصوتية من المواقع المسموح بها بإستخدام
 										الوسم <strong>[media][/media]</strong>, أو ببساطة كتابة الرابط لأحد المواقع المدعومة
-										كما هو بدون الوسوم. مثال:<br><br>
+										كما هو بدون الوسوم. مثال:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>كما تلاحظ في المثال أعلاه, تستطيع أيضاً استخدام الرابط بدون الوسم
+										<br /><br />كما تلاحظ في المثال أعلاه, تستطيع أيضاً استخدام الرابط بدون الوسم
 										<strong>[media]</strong>.
-										<br><br>ستكون النتيجة للمثال المذكور أعلاه كالآتي:<br><br>%2$s
-										<br><br>القائمة التالية تحتوي على المواقع المدعومة:<br><samp>%3$s.</samp>
-										<br><br>للمزيد من المعلومات والأمثلة للمواقع المدعومة,
+										<br /><br />ستكون النتيجة للمثال المذكور أعلاه كالآتي:<br /><br />%2$s
+										<br /><br />القائمة التالية تحتوي على المواقع المدعومة:<br /><samp>%3$s.</samp>
+										<br /><br />للمزيد من المعلومات والأمثلة للمواقع المدعومة,
 										انقر على هذا الرابط <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										معلومات إدراج مُحتوى الوسائط</a>.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/ar/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/ar/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/ar/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/cs/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/cs/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/cs/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/cs/acp.php"
@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Media Embed nastavení',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Zde můžete konfigurovat nastaven í pro plugin Media Embed.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zobrazit <samp>[media]</samp> BBCode na stránce s příspěvkem.',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zobrazit <samp>[MEDIA]</samp> BBCode na stránce s příspěvkem.',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Pokud je zakázáno, BBCode tlačítko nebude zobrazeno, přesto mohou uživatelé ve svých příspěvcích využít <samp>[media]</samp>.',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Povolí v podpisech uživatelů',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/cs/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/cs/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/cs/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/cs/help.php"
@@ -40,12 +40,13 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA'			=> 'Vkládání médií',
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Jak vkládat média z jiných stránek do příspěvků.',
-	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Uživatelů mohou vkládat obsah jako jsou videa nebo zvukové stopy z povolených stránek používáním <strong>[media][/media]</strong> nebo jednoduše vložením povoleného URL do textu. Například:<br><br>
+	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Uživatelů mohou vkládat obsah jako jsou videa nebo zvukové stopy z povolených stránek používáním <strong>[media][/media]</strong> nebo jednoduše vložením povoleného URL do textu. Například:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Jak bylo výše zmíněno, odkaz může být také vložen pomocí
+										<br /><br />Jak bylo výše zmíněno, odkaz může být také vložen pomocí
 										<strong>[media]</strong> tagů.
-										<br><br>Uvedený příklad bude vypadat následovně:<br><br>%2$s
-										<br><br>Tyto stránky jsou podporovány:<br><samp>%3$s.</samp>
-										<br><br>Pro kompletní dokumentaci podporovaných tránek a příklady URL navštivte <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+										<br /><br />Uvedený příklad bude vypadat následovně:<br /><br />%2$s
+										<br /><br />Tyto stránky jsou podporovány:<br /><samp>%3$s.</samp>
+										<br /><br />Pro kompletní dokumentaci podporovaných tránek a příklady URL navštivte <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										MediaEmbed Plugin dokumentace</a>.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/cs/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/cs/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/cs/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/da/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/da/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/da/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/da/acp.php"
@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Indstillinger for medieindlejring',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Her kan du konfigurere indstillingerne til Media Embed PlugIn.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Vis <samp>[media]</samp>-BBkode på siden hvor indlæg skrives',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Vis <samp>[MEDIA]</samp>-BBkode på siden hvor indlæg skrives',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Hvis den er valgt fra vises BBkode-knappen ikke, men brugerne kan dog stadig bruge <samp>[media]</samp>-tagget i deres indlæg',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Tillad i brugersignaturer',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/da/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/da/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/da/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/da/help.php"
@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Sådan indlejres medie fra andre steder i indlæg',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Brugere kan indlejre indhold, såsom videoer og lyd fra tilladte stedet med
 										<strong>[media][/media]</strong>-tags, eller blot ved at skrive en understøttet
-										URL i ren tekst. F.eks.:<br><br>
+										URL i ren tekst. F.eks.:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Som beskrevet ovenfor, kan linket også bruges uden
+										<br /><br />Som beskrevet ovenfor, kan linket også bruges uden
 										<strong>[media]</strong>-taggene.
-										<br><br>Eksemplet som vises her genererer:<br><br>%2$s
-										<br><br>Følgende steder understøttes:<br><samp>%3$s.</samp>
-										<br><br>Besøg <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+										<br /><br />Eksemplet som vises her genererer:<br /><br />%2$s
+										<br /><br />Følgende steder understøttes:<br /><samp>%3$s.</samp>
+										<br /><br />Besøg <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										dokumentationen til MediaEmbed Plugin</a> for fuld dokumentation på understøttede steder og
 										URL\'er med eksempler.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/da/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/da/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/da/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/de/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/de/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/de/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/de/acp.php"
@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Media Embed Einstellungen',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Hier kannst du die Einstellungen für das Media Embed PlugIn anpassen.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zeige <samp>[media]</samp> BBCode auf der Posting Seite',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zeige <samp>[MEDIA]</samp> BBCode auf der Posting Seite',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Wenn nicht erlaubt, wird der BBCode Button nicht angezeigt, dennoch können die User das <samp>[media]</samp> in ihren Posts verwenden.',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Erlaubt in den Benutzer Signaturen',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/de/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/de/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/de/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/de/help.php"
@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Wie werden Medien von anderen Seiten in Posts eingebunden',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'User können Medien von anderen erlaubten Seiten wie Video und Audio einbinden indem
 										die <strong>[media][/media]</strong> Tags oder indem einfach die reine URL der erlaubten Seite
-										in den Text kopiert wird. Als Beispiel:<br><br>
+										in den Text kopiert wird. Als Beispiel:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Wie oben beschrieben kann die URL auch ohne die
+										<br /><br />Wie oben beschrieben kann die URL auch ohne die
 										<strong>[media]</strong> Tags verwendet werden.
-										<br><br>Das hier gezeigt Beispiel würde folgendes generieren:<br><br>%2$s
-										<br><br>Die folgenden Seiten sind erlaubt:<br><samp>%3$s.</samp>
-										<br><br>Für eine komplette Dokumentation der unterstützen Seiten und Beispiel URLs,
+										<br /><br />Das hier gezeigt Beispiel würde folgendes generieren:<br /><br />%2$s
+										<br /><br />Die folgenden Seiten sind erlaubt:<br /><samp>%3$s.</samp>
+										<br /><br />Für eine komplette Dokumentation der unterstützen Seiten und Beispiel URLs,
 										besuche die <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										MediaEmbed Plugin Documentation</a>.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/de/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/de/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/de/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/en/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/en/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/en/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/en/acp.php"
@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Media Embed Settings',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Here you can configure the settings for the Media Embed PlugIn.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Display <samp>[media]</samp> BBCode on posting page',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Display <samp>[MEDIA]</samp> BBCode on posting page',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'If disallowed, the BBCode button will not be displayed, however users can still use the <samp>[media]</samp> tag in their posts.',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Allow in user signatures',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/en/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/en/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/en/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/en/help.php"
@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'How to embed media from other sites into posts',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Users can embed content such as videos and audio from allowed sites using
 										the <strong>[media][/media]</strong> tags, or from simply posting a supported
-										URL in plain text. For example:<br><br>
+										URL in plain text. For example:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>As noted above, the link could also be used without the
+										<br /><br />As noted above, the link could also be used without the
 										<strong>[media]</strong> tags.
-										<br><br>The example shown here would generate:<br><br>%2$s
-										<br><br>The following sites are supported:<br><samp>%3$s.</samp>
-										<br><br>For complete documentation on supported sites and example URLs,
+										<br /><br />The example shown here would generate:<br /><br />%2$s
+										<br /><br />The following sites are supported:<br /><samp>%3$s.</samp>
+										<br /><br />For complete documentation on supported sites and example URLs,
 										visit the <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										MediaEmbed Plugin Documentation</a>.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/en/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/en/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/en/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/es/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/es/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/es/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/es/acp.php"
@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Ajustes de Media Embed',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aquí puede configurar los ajustes del PlugIn Media Embed.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[media]</samp> en la página de publicación',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[MEDIA]</samp> en la página de publicación',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Si se deshabilita, el botón BBCode no será mostrado, pero los usuarios aún podrán seguir usando la etiqueta <samp>[media]</samp> en sus mensajes',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opciones',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Permitir en firmas de usuario',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/es/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/es/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/es/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/es/help.php"
@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Cómo insertar medios de otros sitios en los mensajes',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Los usuarios pueden incorporar contenido como videos y audio desde sitios permitidos usando
 										las etiquetas <strong>[media][/media]</strong>, o simplemente publicando una URL soportada
-										en texto plano. Por ejemplo:<br><br>
+										en texto plano. Por ejemplo:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Como se indicó anteriormente, el enlace también podría utilizarse sin las
+										<br /><br />Como se indicó anteriormente, el enlace también podría utilizarse sin las
 										etiquetas <strong>[media]</strong>.
-										<br><br>El ejemplo mostrado aquí generaría:<br><br>%2$s
-										<br><br>Los siguientes sitios son compatibles:<br><samp>%3$s.</samp>
-										<br><br>Para obtener una documentación completa sobre los sitios admitidos, y las URL de ejemplo,
+										<br /><br />El ejemplo mostrado aquí generaría:<br /><br />%2$s
+										<br /><br />Los siguientes sitios son compatibles:<br /><samp>%3$s.</samp>
+										<br /><br />Para obtener una documentación completa sobre los sitios admitidos, y las URL de ejemplo,
 										visite la <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										Documentación del PlugIn MediaEmbed</a>.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/es/info_acp_mediaembed.php" "[FORUM_EXT]/phpbb\\mediaembed/language/es/info_acp_mediaembed.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/es/info_acp_mediaembed.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/es/info_acp_mediaembed.php"
@@ -26,5 +26,5 @@ $lang = array_merge($lang, [
 	// Log keys
 	'LOG_PHPBB_MEDIA_EMBED_CACHE_PURGED'=> '<strong>Caché Media Embed cache limpiado</strong>',
 	'LOG_PHPBB_MEDIA_EMBED_MANAGE'		=> '<strong>Sitios de Media Embed actualizados</strong>',
-	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Ajustes de Media Embed actualizados</strong>',
+	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Ajustes de Media Embed actualziados</strong>',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/es/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/es/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/es/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/es_x_tu/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/es_x_tu/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/es_x_tu/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/es_x_tu/acp.php"
@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Ajustes de Media Embed',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aquí puedes configurar los ajustes del PlugIn Media Embed.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[media]</samp> en la página de publicación',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[MEDIA]</samp> en la página de publicación',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Si se deshabilita, el botón BBCode no será mostrado, pero los usuarios aún podrán seguir usando la etiqueta <samp>[media]</samp> en sus mensajes',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opciones',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Permitir en firmas de usuario',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/es_x_tu/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/es_x_tu/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/es_x_tu/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/es_x_tu/help.php"
@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Cómo insertar medios de otros sitios en los mensajes',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Los usuarios pueden incorporar contenido como videos y audio desde sitios permitidos usando
 										las etiquetas <strong>[media][/media]</strong>, o simplemente publicando una URL soportada
-										en texto plano. Por ejemplo:<br><br>
+										en texto plano. Por ejemplo:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Como se indicó anteriormente, el enlace también podría utilizarse sin las
+										<br /><br />Como se indicó anteriormente, el enlace también podría utilizarse sin las
 										etiquetas <strong>[media]</strong>.
-										<br><br>El ejemplo mostrado aquí generaría:<br><br>%2$s
-										<br><br>Los siguientes sitios son compatibles:<br><samp>%3$s.</samp>
-										<br><br>Para obtener una documentación completa sobre los sitios admitidos, y las URL de ejemplo,
+										<br /><br />El ejemplo mostrado aquí generaría:<br /><br />%2$s
+										<br /><br />Los siguientes sitios son compatibles:<br /><samp>%3$s.</samp>
+										<br /><br />Para obtener una documentación completa sobre los sitios admitidos, y las URL de ejemplo,
 										visite la <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										Documentación del PlugIn MediaEmbed</a>.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/es_x_tu/info_acp_mediaembed.php" "[FORUM_EXT]/phpbb\\mediaembed/language/es_x_tu/info_acp_mediaembed.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/es_x_tu/info_acp_mediaembed.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/es_x_tu/info_acp_mediaembed.php"
@@ -26,5 +26,5 @@ $lang = array_merge($lang, [
 	// Log keys
 	'LOG_PHPBB_MEDIA_EMBED_CACHE_PURGED'=> '<strong>Caché Media Embed cache limpiado</strong>',
 	'LOG_PHPBB_MEDIA_EMBED_MANAGE'		=> '<strong>Sitios de Media Embed actualizados</strong>',
-	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Ajustes de Media Embed actualizados</strong>',
+	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Ajustes de Media Embed actualziados</strong>',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/es_x_tu/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/es_x_tu/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/es_x_tu/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/et/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/et/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/et/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/et/acp.php"
@@ -24,7 +24,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Manustatud meedia seaded',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Sellel leheküljel on sul võimalik seadistada laienduse manustatud meedia seadeid.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Näita <samp>[media]</samp> BBkoodi positamise leheküljel',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Näita <samp>[MEDIA]</samp> BBkoodi positamise leheküljel',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Kui pole lubatud, siis BBkoodi nuppu ei näidata, kuid siiski on kasutajatel võimalik kasutada e <samp>[media]</samp> silti oma postitustes.',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Luba kasutaja signatuurides',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/et/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/et/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/et/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/et/help.php"
@@ -42,12 +42,13 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA'			=> 'Meedia manustamine',
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Kuidas manustada meediat teiselt veebileheküljelt postitusse',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Kasutajatel on võimalik manustada sisu nagu näiteks videosi ja helifaile lubatud veebilehekülgedelt kasutades
-										<strong>[media][/media]</strong> silte või lihtsalt postitades toetatud veebiaadresse puhta tekstina. Näiteks:<br><br>
+										<strong>[media][/media]</strong> silte või lihtsalt postitades toetatud veebiaadresse puhta tekstina. Näiteks:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Nii nagu eespool öeldud, siis aadressi on võimalik kasutada ka ilma
+										<br /><br />Nii nagu eespool öeldud, siis aadressi on võimalik kasutada ka ilma
 										<strong>[media]</strong> siltideta.
-										<br><br>Siin toodud näide tekitab aga tulemuseks sellise:<br><br>%2$s
-										<br><br>Toetatud on järgmised veebilehed:<br><samp>%3$s.</samp>
-										<br><br>Et näha täielikku dokumentatsiooni toeatatutest lehekülgedest, ning näidis aadressidest, palun külasta <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+										<br /><br />Siin toodud näide tekitab aga tulemuseks sellise:<br /><br />%2$s
+										<br /><br />Toetatud on järgmised veebilehed:<br /><samp>%3$s.</samp>
+										<br /><br />Et näha täielikku dokumentatsiooni toeatatutest lehekülgedest, ning näidis aadressidest, palun külasta <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										lehekülge</a>.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/et/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/et/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/et/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/fr/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/fr/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/fr/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/fr/acp.php"
@@ -43,11 +43,11 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Paramètres des médias intégrés',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Depuis cette page il est possible de paramétrer les options de l’extension « phpBB Media Embed PlugIn ».',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Afficher le BBCode <samp>[media]</samp> sur la page de rédaction des messages',
-	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Permet d’activer l’affichage du BBCode <samp>[media]</samp> sur la page de l’éditeur complet lors de la rédaction d’une réponse ou d’un nouveau sujet. Si l’affichage est désactivé, le bouton du BBCode ne sera pas affiché, mais les utilisateurs pourront saisir manuellement la balise <samp>[media]</samp> dans leurs messages sur les pages accessibles au moyen des boutons « Répondre », « Nouveau sujet » ou dans la réponse rapide.',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Afficher le BBCode <samp>[MEDIA]</samp> sur la page de rédaction des messages',
+	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Permet d’activer l’affichage du BBCode <samp>[MEDIA]</samp> sur la page de l’éditeur complet lors de la rédaction d’une réponse ou d’un nouveau sujet. Si l’affichage est désactivé, le bouton du BBCode ne sera pas affiché, mais les utilisateurs pourront saisir manuellement la balise <samp>[media]</samp> dans leurs messages sur les pages accessibles au moyen des boutons « Répondre », « Nouveau sujet » ou dans la réponse rapide.',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Autoriser dans la signature des membres',
-	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'Permet d’utiliser le BBCode <samp>[media]</samp> dans le contenu de la signature des membres.',
+	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'Permet d’utiliser le BBCode <samp>[MEDIA]</samp> dans le contenu de la signature des membres.',
 	'ACP_MEDIA_CACHE_LEGEND'			=> 'Content caching',
 	'ACP_MEDIA_ENABLE_CACHE'			=> 'Activer le cache des médias intégrés',
 	'ACP_MEDIA_ENABLE_CACHE_EXPLAIN'	=> 'Permet d’améliorer les performances via la mise en cache des informations recueillies localement sur les sites. En effet, dans certains cas il est possible de remarquer des performances dégradées lors du chargement de médias à partir d’autres sites, en particulier lorsque le même contenu est chargé plusieurs fois (par exemple lors de la modification d’un message).',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/fr/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/fr/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/fr/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/fr/help.php"
@@ -43,13 +43,14 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Intégrer un média dans les messages provenant d’un service d’un autre site Web',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Les utilisateurs peuvent intégrer du contenu multimédia (audio, vidéo) provenant de services fournis
 										par d’autres sites Web en utilisant les balises du BBCode <strong>[media][/media]</strong>,
-										ou en publiant simplement l’adresse URL d’un lien pris en charge. Tel que, par exemple :<br><br>
+										ou en publiant simplement l’adresse URL d’un lien pris en charge. Tel que, par exemple :<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Comme indiqué précédemment, le lien peut aussi être utilisé sans
+										<br /><br />Comme indiqué précédemment, le lien peut aussi être utilisé sans
 										les balises du BBCode <strong>[media]</strong>.
-										<br><br>Ainsi, l’exemple montré ci-dessus affichera :<br><br>%2$s
-										<br><br>Le services des sites Web suivants sont supportés :<br><samp>%3$s.</samp>
-										<br><br>Une documentation complète à propos des services et des exemples d’adresses URL pris en charge,
+										<br /><br />Ainsi, l’exemple montré ci-dessus affichera :<br /><br />%2$s
+										<br /><br />Le services des sites Web suivants sont supportés :<br /><samp>%3$s.</samp>
+										<br /><br />Une documentation complète à propos des services et des exemples d’adresses URL pris en charge,
 										est disponible depuis la page : <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										Sites pris en charges par le plugin MediaEmbed</a>.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/fr/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/fr/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/fr/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/it/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/it/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/it/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/it/acp.php"
@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Impostazioni PlugIn Media Embed',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Qui puoi configurare le impostazioni per il PlugIn Media Embed.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Visualizza BBCode <samp>[media]</samp> nella pagina di scrittura',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Visualizza BBCode <samp>[MEDIA]</samp> nella pagina di scrittura',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Se non consentito, il pulsante BBCode non verrà visualizzato, tuttavia gli utenti possono ancora utilizzare il tag <samp> [media] </samp> nei loro messaggi',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opzioni',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Consenti nelle firme utente',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/it/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/it/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/it/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/it/help.php"
@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Come incorporare i contenuti multimediali da altri siti nei messaggi',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Gli utenti possono incorporare contenuti come video e audio dai siti consentiti utilizzando
 										i tags <strong>[media][/media]</strong>, o semplicemente postando in testo normale un URL
-                                        che lo supporta. Per esempio:<br><br>
+                                        che lo supporta. Per esempio:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Come notato sopra, il collegamento potrebbe anche essere utilizzato senza
+										<br /><br />Come notato sopra, il collegamento potrebbe anche essere utilizzato senza
 										<strong>[media]</strong> tags.
-										<br><br>L’esempio mostrato qui genererebbe:<br><br>%2$s
-										<br><br>Sono supportati i seguenti siti:<br><samp>%3$s.</samp>
-										<br><br>Per la documentazione completa sui siti supportati e sugli URL di esempio,
+										<br /><br />L’esempio mostrato qui genererebbe:<br /><br />%2$s
+										<br /><br />Sono supportati i seguenti siti:<br /><samp>%3$s.</samp>
+										<br /><br />Per la documentazione completa sui siti supportati e sugli URL di esempio,
 										consulta la <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										Documentazione sul plug-in multimediale incorporato</a>.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/it/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/it/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/it/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/nl/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/nl/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/nl/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/nl/acp.php"
@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Media Embed Instellingen',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Hier kunt u instellingen voor de Media Embed PlugIn configureren.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Toon de <samp>[media]</samp> BBCode op de reactie pagina',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Toon de <samp>[MEDIA]</samp> BBCode op de reactie pagina',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Als dit is niet toegestaan zal de BBCode knop niet worden getoond maar gebruikers kunnen nog steeds de <samp>[media]</samp> tag in berichten gebruiken',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Toestaan in onderschriften',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/nl/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/nl/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/nl/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/nl/help.php"
@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Hoe voeg je media van andere website in in je berichten',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Gebruikers kunnen inhoud zoals video\'s en audo invoegen van toegestane websites met gebruik van
 										de <strong>[media][/media]</strong> tags, of door heel simpel het plaatsen van een ondersteunde
-										URL in platte tekst. Als voorbeeld:<br><br>
+										URL in platte tekst. Als voorbeeld:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Zoals we zien hierboven kan de link ook worden gebruikt zonder de
+										<br /><br />Zoals we zien hierboven kan de link ook worden gebruikt zonder de
 										<strong>[media]</strong> tags.
-										<br><br>Bovenstaand voorbeeld geeft als resultaat:<br><br>%2$s
-										<br><br>De volgende websites worden ondersteund:<br><samp>%3$s.</samp>
-										<br><br>Voor de volledige documentatie op ondersteunde websites en voorbeeld URL\'s,
+										<br /><br />Bovenstaand voorbeeld geeft als resultaat:<br /><br />%2$s
+										<br /><br />De volgende websites worden ondersteund:<br /><samp>%3$s.</samp>
+										<br /><br />Voor de volledige documentatie op ondersteunde websites en voorbeeld URL\'s,
 										bezoekt u de <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										MediaEmbed Plugin Documentatie</a>.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/nl/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/nl/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/nl/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/pl/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/pl/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/pl/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/pl/acp.php"
@@ -24,21 +24,21 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Ustawienia osadzania multimediów',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Tutaj można dokonać konfiguracji rozszerzenia Media Embed.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Wyświetl znacznik BBcode <samp>[media]</samp> na forum',
-	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Jeśli wybrano Nie, to znacznik <samp>[media]</samp> nie będzie wyświetlony, jednakże nadal można go używać na forum.',
-	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opcje',
-	'ACP_MEDIA_ALLOW_SIG'				=> 'Znacznik <samp>[media]</samp> w podpisach',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Wyświetl znacznik BBcode <samp>[MEDIA]</samp> na forum',
+	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Jeśli wybrano Nie, to znacznik <samp>[MEDIA]</samp> nie będzie wyświetlony, jednakże nadal można go używać na forum.',
+	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
+	'ACP_MEDIA_ALLOW_SIG'				=> 'Znacznik <samp>[MEDIA]</samp> w podpisach',
 	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'Zezwól na używanie multimediów w sygnaturze.',
-	'ACP_MEDIA_CACHE_LEGEND'			=> 'Buforowanie zawartości',
+	'ACP_MEDIA_CACHE_LEGEND'			=> 'Content caching',
 	'ACP_MEDIA_ENABLE_CACHE'			=> 'Pamięć podręczna osadzania multimediów',
 	'ACP_MEDIA_ENABLE_CACHE_EXPLAIN'	=> 'W niektórych przypadkach ładowanie multimediów może działać wolniej, np. podczas ponownego ładowania treści przy edycji posta. Włączenie pamięci podręcznej może poprawić wydajność osadzania multimediów.',
 	'ACP_MEDIA_PARSE_URLS'				=> 'Konwersja adresów URL',
 	'ACP_MEDIA_PARSE_URLS_EXPLAIN'		=> 'Jeśli wybrano Tak, to adresy URL zostaną przekonwertowane bez użycia znacznika BBCode <samp>[media]</samp> lub <samp>[url]</samp>. Ta opcja wpłynie tylko na nowo osadzone multimedia. Dotychczasowe adresy URL nie zostaną przetworzone.',
-	'ACP_MEDIA_WIDTH_LEGEND'			=> 'Rozmiar zawartości',
-	'ACP_MEDIA_FULL_WIDTH'				=> 'Tryb pełnoekranowy',
-	'ACP_MEDIA_FULL_WIDTH_EXPLAIN'		=> 'Włącz tę opcję, aby rozszerzyć większość osadzonych multimediów do szerokości obszaru treści posta, zachowując jednocześnie jego natywne proporcje.',
-	'ACP_MEDIA_MAX_WIDTH'				=> 'Niestandardowy tryb pełnoekranowy',
-	'ACP_MEDIA_MAX_WIDTH_EXPLAIN'		=> 'Użyj tego pola, aby zdefiniować maksymalną szerokość multimediów dla poszczególnych witryn. Zastąpi to domyślną szerokość zdefiniowana w polu wyżej. Wprowadź każdą witrynę w nowym wierszu, używając formatu <samp class="error">siteId:szerokość</samp> przy pomocy <samp class="error">px</samp> lub <samp class="error">%</samp>. Na przykład:<br><br><samp class="error">youtube:80%</samp><br><samp class="error">funnyordie:480px</samp><br><br><i><strong class="error">Wskazówka:</strong> Najedź kursorem myszy na witrynę na stronie ”Zarządzaj stronami”, aby wyświetlić nazwę identyfikatora witryny do użycia w tym miejscu.</i>',
+	'ACP_MEDIA_WIDTH_LEGEND'			=> 'Content sizing',
+	'ACP_MEDIA_FULL_WIDTH'				=> 'Enable full width content',
+	'ACP_MEDIA_FULL_WIDTH_EXPLAIN'		=> 'Enable this to expand most Media Embed content to fill the full width of the post content area while maintaining its native aspect ratio.',
+	'ACP_MEDIA_MAX_WIDTH'				=> 'Custom max-width content',
+	'ACP_MEDIA_MAX_WIDTH_EXPLAIN'		=> 'Use this field to define custom max-width values for individual sites. This will override the default size and the full width option above. Enter each site on a new line, using the format <samp class="error">siteId:width</samp> with either <samp class="error">px</samp> or <samp class="error">%</samp>. For example:<br><br><samp class="error">youtube:80%</samp><br><samp class="error">funnyordie:480px</samp><br><br><i><strong class="error">Tip:</strong> Hover your mouse over a site on the Manage sites page to reveal the site id name to use here.</i>',
 	'ACP_MEDIA_PURGE_CACHE'				=> 'Wyczyść pamięć podręczną',
 	'ACP_MEDIA_PURGE_CACHE_EXPLAIN'		=> 'Pamięć podręczna osadzania multimediów jest codziennie, automatycznie czyszczona. Można ją usunąć teraz poprzez kliknięcie przycisku.',
 	'ACP_MEDIA_SITE_TITLE'				=> 'ID strony: %s',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/pl/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/pl/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/pl/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/pl/help.php"
@@ -43,11 +43,12 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Jak wyświetlić multimedia z innych stron na forum',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Użytkownicy mogą wyświetlić zawartość z innych stron jak wideo lub muzyka
 										poprzez znacznik <strong>[media][/media]</strong>. Należy wkleić adres URL pomiędzy znacznikami.
-										<br><br>Na przykład:
+										<br /><br />Na przykład:
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Powyższy adres URL zostanie wyświetlony jak pokazano poniżej:<br><br>%2$s
-										<br><br>Na forum wspierane są strony:<br><samp>%3$s.</samp>
-										<br><br>Dokumentacja wraz z wszystkimi wspieranymi stronami i przykładami adresów URL
+										<br /><br />Powyższy adres URL zostanie wyświetlony jak pokazano poniżej:<br /><br />%2$s
+										<br /><br />Na forum wspierane są strony:<br /><samp>%3$s.</samp>
+										<br /><br />Dokumentacja wraz z wszystkimi wspieranymi stronami i przykładami adresów URL
 										znajduje się pod linkiem <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										MediaEmbed Plugin Documentation</a>.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/pl/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/pl/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/pl/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/pt/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/pt/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/pt/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/pt/acp.php"
@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Configurações do Media Embed',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aqui você pode configurar as configurações para o Media Embed PlugIn.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[media]</samp> na página de postagem',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[MEDIA]</samp> na página de postagem',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Se não for permitido, o botão BBCode não será exibido, no entanto, os usuários ainda podem usar a tag <samp>[media]</samp> em suas postagens',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Permitir em assinaturas de usuários',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/pt/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/pt/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/pt/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/pt/help.php"
@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Como inserir mídia de outros sites em postagens',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Os usuários podem incorporar conteúdo como vídeos e áudio de sites permitidos usando
 										as tags <strong>[media][/media]</strong>, ou simplesmente postando uma
-										URL suportada em texto simples. Por exemplo:<br><br>
+										URL suportada em texto simples. Por exemplo:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Conforme mencionado acima, o link também pode ser usado sem as tags
+										<br /><br />Conforme mencionado acima, o link também pode ser usado sem as tags
 										<strong>[media]</strong>.
-										<br><br>O exemplo mostrado aqui geraria:<br><br>%2$s
-										<br><br>Os seguintes sites são suportados:<br><samp>%3$s.</samp>
-										<br><br>Para obter documentação completa sobre sites suportados e URLs de exemplo,
+										<br /><br />O exemplo mostrado aqui geraria:<br /><br />%2$s
+										<br /><br />Os seguintes sites são suportados:<br /><samp>%3$s.</samp>
+										<br /><br />Para obter documentação completa sobre sites suportados e URLs de exemplo,
 										visite a <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										MediaEmbed Plugin Documentation</a>.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/pt/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/pt/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/pt/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/pt_br/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/pt_br/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/pt_br/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/pt_br/acp.php"
@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Configurações do Media Embed',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aqui você pode configurar as configurações para o Media Embed PlugIn.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[media]</samp> na página de postagem',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Mostrar BBCode <samp>[MEDIA]</samp> na página de postagem',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Se não for permitido, o botão BBCode não será exibido, no entanto, os usuários ainda podem usar a tag <samp>[media]</samp> em suas postagens',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Permitir em assinaturas de usuários',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/pt_br/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/pt_br/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/pt_br/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/pt_br/help.php"
@@ -42,13 +42,14 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Como inserir mídia de outros sites em postagens',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Os usuários podem incorporar conteúdo como vídeos e áudio de sites permitidos usando
 										as tags <strong>[media][/media]</strong>, ou simplesmente postando uma
-										URL suportada em texto simples. Por exemplo:<br><br>
+										URL suportada em texto simples. Por exemplo:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Conforme mencionado acima, o link também pode ser usado sem as tags
+										<br /><br />Conforme mencionado acima, o link também pode ser usado sem as tags
 										<strong>[media]</strong>.
-										<br><br>O exemplo mostrado aqui geraria:<br><br>%2$s
-										<br><br>Os seguintes sites são suportados:<br><samp>%3$s.</samp>
-										<br><br>Para obter documentação completa sobre sites suportados e URLs de exemplo,
+										<br /><br />O exemplo mostrado aqui geraria:<br /><br />%2$s
+										<br /><br />Os seguintes sites são suportados:<br /><samp>%3$s.</samp>
+										<br /><br />Para obter documentação completa sobre sites suportados e URLs de exemplo,
 										visite a <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										MediaEmbed Plugin Documentation</a>.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/pt_br/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/pt_br/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/pt_br/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/ro/acp.php" "[ORIGINAL]/phpbb\\mediaembed/language/ro/acp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/ro/acp.php"
+++ /dev/null
@@ -1,54 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	// Settings
-	'ACP_MEDIA_SETTINGS'				=> 'Setări de încorporare media',
-	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Aici puteți configura setările pentru Media Embed PlugIn.',
-	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Afișați <samp>[MEDIA]</samp> BBCode pe pagina de postare',
-	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Dacă nu este permis, butonul BBCode nu va fi afișat, totuși utilizatorii pot folosi în continuare eticheta <samp>[media]</samp> în postările lor.',
-	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Opțiuni',
-	'ACP_MEDIA_ALLOW_SIG'				=> 'Permiteți în semnăturile utilizatorilor',
-	'ACP_MEDIA_ALLOW_SIG_EXPLAIN'		=> 'Permiteți semnăturilor utilizatorilor să afișeze conținut media încorporat.',
-	'ACP_MEDIA_CACHE_LEGEND'			=> 'Memorarea în cache a conținutului',
-	'ACP_MEDIA_ENABLE_CACHE'			=> 'Activați cacheul Media Embed',
-	'ACP_MEDIA_ENABLE_CACHE_EXPLAIN'	=> 'În unele cazuri, este posibil să observați o performanță mai lentă decât cea normală atunci când încărcați conținut media de pe alte site-uri, mai ales când încărcați același conținut de mai multe ori (de exemplu, când editați o postare). Activarea acestui lucru va stoca în cache informațiile pe care Media Embed le adună de pe site-uri la nivel local și ar trebui să îmbunătățească performanța.',
-	'ACP_MEDIA_PARSE_URLS'				=> 'Convertiți adrese URL simple',
-	'ACP_MEDIA_PARSE_URLS_EXPLAIN'		=> 'Activați această opțiune pentru a converti adresele URL simple (nu sunt incluse în etichete <samp>[media]</samp> sau <samp>[url]</samp>) în conținut media încorporat. Rețineți că modificarea acestei setări va afecta numai postările noi, deoarece postările existente au fost deja analizate.',
-	'ACP_MEDIA_WIDTH_LEGEND'			=> 'Dimensiunea conținutului',
-	'ACP_MEDIA_FULL_WIDTH'				=> 'Activați conținutul cu lățime completă',
-	'ACP_MEDIA_FULL_WIDTH_EXPLAIN'		=> 'Activați această opțiune pentru a extinde majoritatea conținutului Media Embed pentru a umple întreaga lățime a zonei de conținut postare, păstrând în același timp raportul de aspect nativ.',
-	'ACP_MEDIA_MAX_WIDTH'				=> 'Conținut personalizat cu lățime maximă',
-	'ACP_MEDIA_MAX_WIDTH_EXPLAIN'		=> 'Utilizați acest câmp pentru a defini valori personalizate pentru lățimea maximă pentru site-uri individuale. Aceasta va suprascrie dimensiunea implicită și opțiunea de lățime completă de mai sus. Introduceți fiecare site pe o nouă linie, folosind formatul <samp class="error">siteId:width</samp> fie cu <samp class="error">px</samp>, fie cu <samp class="error">%</samp>. De exemplu:<br><br><samp class="error">youtube:80%</samp><br><samp class="error">funnyordie:480px</samp><br><br><i><strong class="error">Sfat:</strong> treceți mouse-ul peste un site din pagina Gestionați site-urile pentru a dezvălui numele de cod al site-ului de utilizat aici.</i>',
-	'ACP_MEDIA_PURGE_CACHE'				=> 'Ștergeți memoria cache încorporată',
-	'ACP_MEDIA_PURGE_CACHE_EXPLAIN'		=> 'Cacheul Media Embed este curățat automat o dată pe zi, totuși acest buton poate fi folosit pentru a-și curăța manual memoria cache acum.',
-	'ACP_MEDIA_SITE_TITLE'				=> 'Id-ul site-ului: %s',
-	'ACP_MEDIA_SITE_DISABLED'			=> 'Acest site intră în conflict cu un BBCode existent: [%s]',
-	'ACP_MEDIA_ERROR_MSG'				=> 'Au fost întâlnite următoarele erori:<br><br>%s',
-	'ACP_MEDIA_INVALID_SITE'			=> '%1$s:%2$s :: “%1$s” nu este un ID valid de site',
-	'ACP_MEDIA_INVALID_WIDTH'			=> '%1$s:%2$s :: “%2$s” nu este o lățime validă în „px” sau “%%”',
-
-	// Manage sites
-	'ACP_MEDIA_MANAGE'					=> 'Gestionați site-urile de încorporare media',
-	'ACP_MEDIA_MANAGE_EXPLAIN'			=> 'Aici puteți gestiona site-urile din care doriți să permiteți pluginului Media Embed să afișeze conținut.',
-	'ACP_MEDIA_SITES_ERROR'				=> 'Nu există site-uri media de afișat.',
-	'ACP_MEDIA_SITES_MISSING'			=> 'Următoarele site-uri nu mai sunt acceptate sau nu mai funcționează. Vă rugăm să retrimiteți această pagină pentru a le elimina.',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/ro/common.php" "[ORIGINAL]/phpbb\\mediaembed/language/ro/common.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/ro/common.php"
+++ /dev/null
@@ -1,42 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-/**
- * DO NOT CHANGE
- */
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
-
-$lang = array_merge($lang, [
-	'BBCODE_MEDIA_HELP'	=> 'Media Embed: [media]http://media_url[/media]',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/ro/help.php" "[ORIGINAL]/phpbb\\mediaembed/language/ro/help.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/ro/help.php"
+++ /dev/null
@@ -1,54 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-/**
- * DO NOT CHANGE
- */
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
-
-$lang = array_merge($lang, [
-	'HELP_EMBEDDING_MEDIA'			=> 'Încorporarea media',
-	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Cum să încorporați media de pe alte site-uri în postări',
-	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Utilizatorii pot încorpora conținut, cum ar fi videoclipuri și audio de pe site-uri permise folosind
-                                        etichetele <strong>[media][/media]</strong> sau pur și simplu de la postarea unui mesaj acceptat
-                                        URL în text simplu. De exemplu:<br /><br />
-                                        <strong>[media]</strong>%1$s<strong>[/media]</strong>
-                                        <br /><br />Așa cum sa menționat mai sus, linkul ar putea fi folosit și fără
-                                        etichete <strong>[media]</strong>.
-                                        <br /><br />Exemplul prezentat aici ar genera:<br /><br />%2$s
-                                        <br /><br />Sunt acceptate următoarele site-uri:<br /><samp>%3$s.</samp>
-                                        <br /><br />Pentru documentația completă despre site-urile acceptate și exemple de adrese URL,
-                                        accesați <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
-                                        Documentația pluginului MediaEmbed</a>.',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/ro/info_acp_mediaembed.php" "[ORIGINAL]/phpbb\\mediaembed/language/ro/info_acp_mediaembed.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/ro/info_acp_mediaembed.php"
+++ /dev/null
@@ -1,30 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'ACP_PHPBB_MEDIA_EMBED'				=> 'Media Embed',
-	'ACP_PHPBB_MEDIA_EMBED_MANAGE'		=> 'Gestionați site-urile',
-	'ACP_PHPBB_MEDIA_EMBED_SETTINGS'	=> 'Setări',
-
-	// Log keys
-	'LOG_PHPBB_MEDIA_EMBED_CACHE_PURGED'=> '<strong>Memoria cache pentru Media Embed a fost eliminată</strong>',
-	'LOG_PHPBB_MEDIA_EMBED_MANAGE'		=> '<strong>Site-urile Media Embed au fost actualizate</strong>',
-	'LOG_PHPBB_MEDIA_EMBED_SETTINGS'	=> '<strong>Setările pentru Media Embed au fost actualizate</strong>',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/ro/install.php" "[ORIGINAL]/phpbb\\mediaembed/language/ro/install.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/ro/install.php"
+++ /dev/null
@@ -1,43 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2019 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-/**
- * DO NOT CHANGE
- */
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
-
-$lang = array_merge($lang, [
-	'PHPBB_VERSION_ERROR'	=> 'Forumul dvs. pare să folosească o versiune mai veche a phpBB. phpBB ' . \phpbb\mediaembed\ext::PHPBB_MINIMUM . ' sau mai nou este necesar pentru a utiliza această extensie.',
-	'S9E_MEDIAEMBED_ERROR'	=> 'Am detectat extensia s9e/mediaembed. Pluginul Media Embed al phpBB nu poate fi instalat până când nu dezactivați, curățați și ștergeți toate fișierele legate de extensia s9e/mediaembed.',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/ro/permissions_mediaembed.php" "[ORIGINAL]/phpbb\\mediaembed/language/ro/permissions_mediaembed.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/ro/permissions_mediaembed.php"
+++ /dev/null
@@ -1,36 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2016 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-
-$lang = array_merge($lang, [
-	'ACL_F_MEDIAEMBED'		=> 'Poate folosi eticheta [media] BBCode',
-	'ACL_U_PM_MEDIAEMBED'	=> 'Poate folosi eticheta [media] BBCode în mesajele private',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/ro/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/ro/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/ro/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/ru/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/ru/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/ru/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/ru/acp.php"
@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Настройки Media Embed',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Здесь вы можете настроить параметры для Media Embed.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Показывать <samp>[media]</samp> бб-код на странице размещения сообщений',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Показывать <samp>[MEDIA]</samp> бб-код на странице размещения сообщений',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Если это запрещено, кнопка бб-кода не отображается, но пользователи могут использовать <samp>[media]</samp> бб-код в своих сообщениях.',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Разрешить в подписях пользователей',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/ru/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/ru/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/ru/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/ru/help.php"
@@ -41,11 +41,12 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA'			=> 'Встраивание мультимедиа',
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Как вставлять медиа с других сайтов в сообщения?',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Пользователи могут вставлять контент, например, видео и аудио с разрешенных сайтов, используя бб-код
-										<strong>[media][/media]</strong>, или просто вставив поддерживаемую ссылку в текстовом формате. Например:<br><br>
+										<strong>[media][/media]</strong>, или просто вставив поддерживаемую ссылку в текстовом формате. Например:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Как говорилось выше, ссылка также может использоваться без бб-кода <strong>[media]</strong>.
-										<br><br>Пример, показанный здесь, будет генерировать:<br><br>%2$s
-										<br><br>Поддерживаются следующие сайты::<br><samp>%3$s.</samp>
-										<br><br>Полную документацию о поддерживаемых сайтах и ​​URL-адресах смотрите на странице <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
+										<br /><br />Как говорилось выше, ссылка также может использоваться без бб-кода <strong>[media]</strong>.
+										<br /><br />Пример, показанный здесь, будет генерировать:<br /><br />%2$s
+										<br /><br />Поддерживаются следующие сайты::<br /><samp>%3$s.</samp>
+										<br /><br />Полную документацию о поддерживаемых сайтах и ​​URL-адресах смотрите на странице <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										Документация MediaEmbed</a>.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/ru/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/ru/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/ru/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/sk/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/sk/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/sk/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/sk/acp.php"
@@ -24,7 +24,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Nastavenia vkladania médií',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Tu môžete konfigurovať nastavenia pre plugin vkladania médií.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zobraziť <samp>[media]</samp> BB kód pri prispievaní',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> 'Zobraziť <samp>[MEDIA]</samp> BB kód pri prispievaní',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'Ak je toto nezaškrtnuté, BB kód nebude zobrazený, no používatelia budú môcť používať <samp>[media]</samp> kód v ich príspevkoch',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Povoliť v podpisoch',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/sk/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/sk/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/sk/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/sk/help.php"
@@ -43,13 +43,14 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Ako vložiť obsah z inej stránky do príspevku',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Používatelia môžu vložiť obsah (napríklad video alebo zvuk z povolených stránok použítím
 										<strong>[media][/media]</strong> kódu alebo jednoducho odoslať podporovanú
-										URL v texte. Napríklad:<br><br>
+										URL v texte. Napríklad:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Ako je uvedené vyššie, odkaz môže byť použitý bez
+										<br /><br />Ako je uvedené vyššie, odkaz môže byť použitý bez
 										<strong>[media]</strong> kódu.
-										<br><br>Príklad zobrazený tuto vygeneruje:<br><br>%2$s
-										<br><br>Podporované sú tieto stránky:<br><samp>%3$s.</samp>
-										<br><br>Pre kompletnú dokumentáciu ohľadom podporovaných stránok a príkladov adries
+										<br /><br />Príklad zobrazený tuto vygeneruje:<br /><br />%2$s
+										<br /><br />Podporované sú tieto stránky:<br /><samp>%3$s.</samp>
+										<br /><br />Pre kompletnú dokumentáciu ohľadom podporovaných stránok a príkladov adries
 										navštívte <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										dokumentáciu pluginu vkladania médií</a> (v Angličtine).',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/sk/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/sk/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/sk/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/tr/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/tr/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/tr/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/tr/acp.php"
@@ -24,7 +24,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> 'Medya (Ortam) Yerleştirme Ayarları',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> 'Buradan Medya (Ortam) Yerleştirme Eklentisi için ayarları yapabilirsiniz.',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> '<samp>[media]</samp> BBCode butonunu mesaj gönderme sayfasında göster',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> '<samp>[MEDIA]</samp> BBCode butonunu mesaj gönderme sayfasında göster',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> 'İzin verilmediği takdirde, BBCode butonu gösterilmeyecektir, ancak kullanıcılar hala <samp>[media]</samp> etiketini kendi mesajlarında kullanabilir',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> 'Kullanıcı imzalarında izin ver',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/tr/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/tr/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/tr/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/tr/help.php"
@@ -43,13 +43,14 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> 'Diğer sitelerden alınan medya(ortam) içerikleri mesajların içerisine nasıl yerleştirilir',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> 'Kullanıcılar izin verilen sitelerden aldığı video ve ses gibi içerikleri
 										<strong>[media][/media]</strong> etiketlerini kullanarak, ya da düz metin içerisine desteklenen URL adreslerini basit bir şekilde ekleyerek
-										mesajlara yerleştirebilir. Örneğin:<br><br>
+										mesajlara yerleştirebilir. Örneğin:<br /><br />
 										<strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>Yukarıda belirtildiği gibi, <strong>[media]</strong> etiketleri olmadan
+										<br /><br />Yukarıda belirtildiği gibi, <strong>[media]</strong> etiketleri olmadan
 										sadece bağlantılar da kullanılabilir.
-										<br><br>Burada gösterilen örnek şu şekilde oluşturulacaktır:<br><br>%2$s
-										<br><br>Şu siteler desteklenmektedir:<br><samp>%3$s.</samp>
-										<br><br>Desteklenen siteler ve örnek URL adresleri hakkında tüm belgeler için,
+										<br /><br />Burada gösterilen örnek şu şekilde oluşturulacaktır:<br /><br />%2$s
+										<br /><br />Şu siteler desteklenmektedir:<br /><samp>%3$s.</samp>
+										<br /><br />Desteklenen siteler ve örnek URL adresleri hakkında tüm belgeler için,
 										<a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										MediaEmbed Plugin Belgeleri</a> sayfasını ziyaret edin.',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/tr/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/tr/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/tr/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>Embedded Content from Other Websites</h3>
-		“%1$s” may include posts or content that contain embedded material from external websites, including but not limited to YouTube, Facebook, Twitter, and similar platforms. Embedded content from these external sites behaves in the same way as if you had visited the originating website directly.
-		<br><br>These external websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with the embedded content, including tracking your interaction if you have an account and are logged in to that website.
-		<br><br>Please note that such activity is beyond the control of “%1$s” and is governed by the privacy policies and terms of service of the respective external websites. We encourage you to review the privacy and cookie policies of any third-party services you interact with through embedded content.
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hans/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/zh_cmn_hans/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hans/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/zh_cmn_hans/acp.php"
@@ -21,10 +21,10 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, [
 	// Settings
-	'ACP_MEDIA_SETTINGS'				=> 'Media Embed 设置',
+	'ACP_MEDIA_SETTINGS'				=> 'Media Embed Settings',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> '这里可设置 Media Embed PlugIn 的相关参数。',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> '在发帖页面显示 <samp>[media]</samp> BBCode',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> '在发帖页面显示 <samp>[MEDIA]</samp> BBCode',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> '若禁用， BBCode 按钮就不会显示，但用户还是可以在帖子中使用 <samp>[media]</samp> 标签。',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> '允许使用在用户签名',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hans/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/zh_cmn_hans/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hans/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/zh_cmn_hans/help.php"
@@ -51,4 +51,5 @@ $lang = array_merge($lang, [
 										<br><br>下面这些网站可以使用：<br><samp>%3$s.</samp>
 										<br><br>访问 <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">
 										MediaEmbed Plugin Documentation</a> 可以查看完整的文档，包括支持的网站和网址列子。',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hans/permissions_mediaembed.php" "[FORUM_EXT]/phpbb\\mediaembed/language/zh_cmn_hans/permissions_mediaembed.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hans/permissions_mediaembed.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/zh_cmn_hans/permissions_mediaembed.php"
@@ -1,8 +1,5 @@
 <?php
 /**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- * @简体中文语言　David Yin <https://www.phpbbchinese.com/>
  *
  * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
  *
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hans/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hans/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hans/ucp.php"
+++ /dev/null
@@ -1,32 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- * @简体中文语言　David Yin <https://www.phpbbchinese.com/>
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>来自其它网站的嵌入内容</h3>
-		“%1$s” 的帖子或内容可能包含来自外部网站的嵌入内容，包括但不限于 YouTube，Facebook，Twitter，和其它类似的平台。来自这些外部网站的嵌入内容表现与你直接访问原始网站相同。
-		<br><br>这些外部网站可能会收集有关你的数据，使用 cookie，嵌入第三方的跟踪功能，以及监察你同这些嵌入内容的互动，包括在你拥有账户并登入该网站的情况下的跟踪你的互动。
-		<br><br>请注意，此类活动不受 “%1$s” 的控制，并受相应外部网站的隐私证词和服务条款的约束。我们建议你查看通过嵌入内容与之互动的任何第三方服务的隐私和 Cookie 政策。
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hant/acp.php" "[FORUM_EXT]/phpbb\\mediaembed/language/zh_cmn_hant/acp.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hant/acp.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/zh_cmn_hant/acp.php"
@@ -23,7 +23,7 @@ $lang = array_merge($lang, [
 	'ACP_MEDIA_SETTINGS'				=> '媒體嵌入設置',
 	'ACP_MEDIA_SETTINGS_EXPLAIN'		=> '您可以在此處配置媒體嵌入外掛的設定。',
 	'ACP_MEDIA_BBCODE_LEGEND'			=> 'BBCode',
-	'ACP_MEDIA_DISPLAY_BBCODE'			=> '顯示 <samp>[media]</samp> BBCode 在發文的頁面',
+	'ACP_MEDIA_DISPLAY_BBCODE'			=> '顯示 <samp>[MEDIA]</samp> BBCode 在發文的頁面',
 	'ACP_MEDIA_DISPLAY_BBCODE_EXPLAIN'	=> '如果不允許，BBCode 按鈕將不會顯示，但會員仍然可以在他們的文章中使用 <samp>[media]</samp> 標籤。',
 	'ACP_MEDIA_OPTIONS_LEGEND'			=> 'Options',
 	'ACP_MEDIA_ALLOW_SIG'				=> '允許會員簽名',
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hant/help.php" "[FORUM_EXT]/phpbb\\mediaembed/language/zh_cmn_hant/help.php"
--- "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hant/help.php"
+++ "[FORUM_EXT]/phpbb\\mediaembed/language/zh_cmn_hant/help.php"
@@ -41,9 +41,10 @@ $lang = array_merge($lang, [
 	'HELP_EMBEDDING_MEDIA'			=> '嵌入媒體',
 	'HELP_EMBEDDING_MEDIA_QUESTION'	=> '如何將來自其他網站的媒體嵌入到文章中',
 	'HELP_EMBEDDING_MEDIA_ANSWER'	=> '會員可以使用 <strong>[media][/media]</strong> 標籤嵌入來自允許網站的視頻和音頻等內容，或者簡單地以純文本形式發表受支持的網址。例如：
-										<br><br><strong>[media]</strong>%1$s<strong>[/media]</strong>
-										<br><br>如上所述，連結也可以在沒有 <strong>[media]</strong> 標籤的情況下使用。
-										<br><br>此處顯示的範例將生成：<br><br>%2$s
-										<br><br>支持以下站點：<br><samp>%3$s</samp>。
-										<br><br>有關受支持站點和範例網址的完整文件，參訪 <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">MediaEmbed Plugin Documentation</a>。',
+										<br /><br /><strong>[media]</strong>%1$s<strong>[/media]</strong>
+										<br /><br />如上所述，連結也可以在沒有 <strong>[media]</strong> 標籤的情況下使用。
+										<br /><br />此處顯示的範例將生成：<br /><br />%2$s
+										<br /><br />支持以下站點：<br /><samp>%3$s</samp>。
+										<br /><br />有關受支持站點和範例網址的完整文件，參訪 <a href="https://s9etextformatter.readthedocs.io/Plugins/MediaEmbed/Sites/">MediaEmbed Plugin Documentation</a>。',
+	'HELP_EMBEDDING_MEDIA_DEMO'		=>	'https://youtu.be/QH2-TGUlwu4',
 ]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hant/ucp.php" "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hant/ucp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/language/zh_cmn_hant/ucp.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
- *
- * phpBB Media Embed PlugIn extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- * @正體中文化 竹貓星球 <http://phpbb-tw.net/phpbb/>
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'MEDIA_EMBED_PRIVACY_POLICY' => '
-		<br><br>
-		<h3>其他網站的嵌入內容</h3>
-		「%1$s」可能包含嵌入外部網站（包括但不限於 YouTube、Facebook、Twitter 及類似平台）的貼文或內容。嵌入來自這些外部網站的內容的行為與您直接訪問原始網站的行為相同。
-		<br><br>這些外部網站可能會收集您的資料、使用 Cookies、嵌入額外的第三方追蹤程式並監控您與嵌入內容的互動，包括在您擁有帳戶並登入網站的情況下追蹤您的互動。
-		<br><br>請注意，此類活動不受「%1$s」的控制，並受相應外部網站的隱私權政策和服務條款約束。我們建議您查看透過嵌入內容與之互動的任何第三方服務的隱私權和 Cookies 政策。
-	',
-]);
diff --git "[ORIGINAL]/phpbb\\mediaembed/styles/all/template/event/overall_header_stylesheets_after.html" "[FORUM_EXT]/phpbb\\mediaembed/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/event/overall_header_stylesheets_after.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
diff --git "[FORUM_EXT]/phpbb\\mediaembed/styles/BBOOTS/template/event/posting_editor_buttons_custom_tags_before.html" "[FORUM_EXT]/phpbb\\mediaembed/styles/BBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\mediaembed/styles/BBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
@@ -0,0 +1,5 @@
+{% if S_BBCODE_MEDIA %}
+<button type="button" class="btn btn-default bbcode-media" accesskey="m" name="addmedia" value="Media" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}">
+	<i class="fa fa-television fa-fw" aria-hidden="true"></i>
+</button>
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\mediaembed/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "[FORUM_EXT]/phpbb\\mediaembed/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\mediaembed/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
@@ -0,0 +1,10 @@
+{% if S_MEDIA_EMBED_FULL_WIDTH or S_MEDIA_EMBED_MAX_WIDTHS %}
+<style>
+{% if S_MEDIA_EMBED_FULL_WIDTH %}
+	[data-s9e-mediaembed] { max-width: 100% !important; }
+{% endif %}
+{% for item in S_MEDIA_EMBED_MAX_WIDTHS %}
+	[data-s9e-mediaembed="{{ item.site }}"] { max-width: {{ item.width }} !important; }
+{% endfor %}
+</style>
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\mediaembed/styles/FLATBOOTS/template/event/posting_editor_buttons_custom_tags_before.html" "[FORUM_EXT]/phpbb\\mediaembed/styles/FLATBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\mediaembed/styles/FLATBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
@@ -0,0 +1,5 @@
+{% if S_BBCODE_MEDIA %}
+<button type="button" class="btn btn-default bbcode-media" accesskey="m" name="addmedia" value="Media" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}">
+	<i class="fa fa-television fa-fw" aria-hidden="true"></i>
+</button>
+{% endif %}
diff --git "[ORIGINAL]/phpbb\\mediaembed/styles/all/template/media_embed_bbcode_icon.html" "[ORIGINAL]/phpbb\\mediaembed/styles/all/template/media_embed_bbcode_icon.html"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\mediaembed/styles/all/template/media_embed_bbcode_icon.html"
+++ /dev/null
@@ -1,2 +0,0 @@
-{# This template will be used in phpBB 4 #}
-{{ Icon('font', 'tv', '', true, 'fas c-button-icon') }}
diff --git "[FORUM_EXT]/phpbb\\mediaembed/styles/prosilver/template/event/overall_header_stylesheets_after.html" "[FORUM_EXT]/phpbb\\mediaembed/styles/prosilver/template/event/overall_header_stylesheets_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\mediaembed/styles/prosilver/template/event/overall_header_stylesheets_after.html"
@@ -0,0 +1,10 @@
+{% if S_MEDIA_EMBED_FULL_WIDTH or S_MEDIA_EMBED_MAX_WIDTHS %}
+<style>
+{% if S_MEDIA_EMBED_FULL_WIDTH %}
+	[data-s9e-mediaembed] { max-width: 100% !important; }
+{% endif %}
+{% for item in S_MEDIA_EMBED_MAX_WIDTHS %}
+	[data-s9e-mediaembed="{{ item.site }}"] { max-width: {{ item.width }} !important; }
+{% endfor %}
+</style>
+{% endif %}
diff --git "[ORIGINAL]/phpbb\\mediaembed/styles/all/template/event/posting_editor_buttons_custom_tags_before.html" "[FORUM_EXT]/phpbb\\mediaembed/styles/prosilver/template/event/posting_editor_buttons_custom_tags_before.html"
similarity index 54%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\mediaembed/styles/all/template/event/posting_editor_buttons_custom_tags_before.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\mediaembed/styles/prosilver/template/event/posting_editor_buttons_custom_tags_before.html"
--- "[ORIGINAL]/phpbb\\mediaembed/styles/all/template/event/posting_editor_buttons_custom_tags_before.html"
+++ "[FORUM_EXT]/phpbb\\mediaembed/styles/prosilver/template/event/posting_editor_buttons_custom_tags_before.html"
@@ -1,9 +1,5 @@
 {% if S_BBCODE_MEDIA %}
 <button type="button" class="button button-icon-only bbcode-media" accesskey="m" name="addmedia" value="Media" onclick="bbfontstyle('[media]', '[/media]');" title="{{ lang('BBCODE_MEDIA_HELP') }}">
-	{% if constant('PHPBB_VERSION') starts with '4' %}
-		{{ include('@phpbb_mediaembed/media_embed_bbcode_icon.html') }}
-	{% else %}
 	<i class="icon fa-television fa-fw" aria-hidden="true"></i>
-	{% endif %}
 </button>
 {% endif %}
```
