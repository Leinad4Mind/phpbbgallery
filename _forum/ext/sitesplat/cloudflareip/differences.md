Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/sitesplat\\cloudflareip/diff_full.tmp" "[FORUM_EXT]/sitesplat\\cloudflareip/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\cloudflareip/diff_full.tmp"
@@ -0,0 +1,28 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\cloudflareip/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\cloudflareip/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\cloudflareip/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\cloudflareip/event/listener.php"
+index 53579c40f..7579b3746 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\cloudflareip/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\cloudflareip/event/listener.php"
+@@ -79,9 +79,16 @@ class listener implements EventSubscriberInterface
+ 	 */
+ 	public function cloudflare_ip_support($event)
+ 	{
+-		if ($this->request->server('HTTP_CF_CONNECTING_IP') != '')
+-		{
+-			$event['ip'] = htmlspecialchars_decode($this->request->server('HTTP_CF_CONNECTING_IP'));
+-		}
++		$ip_check = $event['ip'];
++
++		/**
++		 * Normalizes user IPs when Cloudflare is running on the server.
++		 *
++		 * Ternary Operator improves performance.
++		 * I can't use the Null Coalescing Operator (PHP7) due to BC with phpBB 3.1.x
++		 */
++		$ip_check = ($this->request->server('HTTP_CF_CONNECTING_IP') != '') ? htmlspecialchars_decode($this->request->server('HTTP_CF_CONNECTING_IP')) : htmlspecialchars_decode($this->request->server('REMOTE_ADDR'));
++
++		$event['ip'] = (string) $ip_check;
+ 	}
+ }
diff --git "[FORUM_EXT]/sitesplat\\cloudflareip/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\cloudflareip/diff_nospace.tmp"
new file mode 100644
diff --git "[ORIGINAL]/sitesplat\\cloudflareip/event/listener.php" "[FORUM_EXT]/sitesplat\\cloudflareip/event/listener.php"
--- "[ORIGINAL]/sitesplat\\cloudflareip/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\cloudflareip/event/listener.php"
@@ -79,9 +79,16 @@ class listener implements EventSubscriberInterface
 	 */
 	public function cloudflare_ip_support($event)
 	{
-		if ($this->request->server('HTTP_CF_CONNECTING_IP') != '')
-		{
-			$event['ip'] = htmlspecialchars_decode($this->request->server('HTTP_CF_CONNECTING_IP'));
-		}
+		$ip_check = $event['ip'];
+
+		/**
+		 * Normalizes user IPs when Cloudflare is running on the server.
+		 *
+		 * Ternary Operator improves performance.
+		 * I can't use the Null Coalescing Operator (PHP7) due to BC with phpBB 3.1.x
+		 */
+		$ip_check = ($this->request->server('HTTP_CF_CONNECTING_IP') != '') ? htmlspecialchars_decode($this->request->server('HTTP_CF_CONNECTING_IP')) : htmlspecialchars_decode($this->request->server('REMOTE_ADDR'));
+
+		$event['ip'] = (string) $ip_check;
 	}
 }
```
