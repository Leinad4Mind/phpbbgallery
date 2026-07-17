Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/mober\\discordnotifications/acp/discord_notifications_info.php" "[FORUM_EXT]/mober\\discordnotifications/acp/discord_notifications_info.php"
--- "[ORIGINAL]/mober\\discordnotifications/acp/discord_notifications_info.php"
+++ "[FORUM_EXT]/mober\\discordnotifications/acp/discord_notifications_info.php"
@@ -15,26 +15,16 @@ class discord_notifications_info
 {
 	public function module()
 	{
-		return [
+		return array(
 			'filename'	=> '\mober\discordnotifications\acp\discord_notifications_module',
 			'title'		=> 'ACP_DISCORD_NOTIFICATIONS',
-			'modes'		=> [
-				'settings'	=> [
-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_SETTINGS',
+			'modes'		=> array(
+				'settings'	=> array(
+					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_TITLE',
 					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
-				],
-				'webhooks'	=> [
-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS',
-					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
-				],
-				'mapping'	=> [
-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_MAPPING',
-					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
-				],
-			],
-		];
+					'cat'	=> array('ACP_DISCORD_NOTIFICATIONS')
+				),
+			),
+		);
 	}
 }
diff --git "[ORIGINAL]/mober\\discordnotifications/acp/discord_notifications_module.php" "[FORUM_EXT]/mober\\discordnotifications/acp/discord_notifications_module.php"
--- "[ORIGINAL]/mober\\discordnotifications/acp/discord_notifications_module.php"
+++ "[FORUM_EXT]/mober\\discordnotifications/acp/discord_notifications_module.php"
@@ -18,8 +18,9 @@ class discord_notifications_module
 	const MIN_POST_PREVIEW_LENGTH = 10;
 
 	// The maximum number of characters that the user can set for the post preview setting.
-	// See: https://discord.com/developers/docs/resources/channel#embed-object-embed-limits
-	const MAX_POST_PREVIEW_LENGTH = 1024;
+	// Note that this is slightly less than the actual allowed maximum by Discord (2048), but we reserve
+	// some space to prepend the preview text with something like "Preview: " or "Reason: "
+	const MAX_POST_PREVIEW_LENGTH = 2000;
 
 	// The name for the form used for this page
 	const PAGE_FORM_NAME = 'acp_mober_discord_notifications';
@@ -48,6 +49,9 @@ class discord_notifications_module
 	/** @var \phpbb\log\log */
 	protected $log;
 
+	/** @var \mober\discordnotifications\notification_service */
+	protected $notification_service;
+
 	/** @var \phpbb\request\request */
 	protected $request;
 
@@ -57,13 +61,9 @@ class discord_notifications_module
 	/** @var \phpbb\user */
 	protected $user;
 
-	/** @var bool */
-	private  $curl_available;
-
 	public function main($id, $mode)
 	{
 		global $phpbb_container;
-
 		$this->cache = $phpbb_container->get('cache.driver');
 		$this->config = $phpbb_container->get('config');
 		$this->db = $phpbb_container->get('dbal.conn');
@@ -72,18 +72,16 @@ class discord_notifications_module
 		$this->request = $phpbb_container->get('request');
 		$this->template = $phpbb_container->get('template');
 		$this->user = $phpbb_container->get('user');
-		$this->curl_available = extension_loaded('curl');
+		// Used for sending test messages to Discord
+		$this->notification_service = $phpbb_container->get('mober.discordnotifications.notification_service');
 
 		$this->language->add_lang('acp_discord_notifications', 'mober/discordnotifications');
-		$this->page_title = $this->language->lang('ACP_DISCORD_NOTIFICATIONS');
+		$this->tpl_name = 'acp_discord_notifications';
+		$this->page_title = $this->language->lang('ACP_DISCORD_NOTIFICATIONS_TITLE');
 
 		add_form_key(self::PAGE_FORM_NAME);
 
-		switch ($mode)
-		{
-			case 'webhooks':
-				$this->tpl_name = 'acp_discord_notifications_webhooks';
-
+		// Process submit actions
 		if ($this->request->is_set_post('action_send_test_message'))
 		{
 			$this->process_send_test_message();
@@ -94,40 +92,18 @@ class discord_notifications_module
 		}
 		else if ($this->request->is_set_post('submit'))
 		{
-					$this->process_webhooks_form_submit();
-				}
-
-				$this->generate_webhook_section();
-				break;
-
-			case 'mapping':
-				$this->tpl_name = 'acp_discord_notifications_mapping';
-
-				if ($this->request->is_set_post('submit'))
-				{
-					$this->process_mapping_form_submit();
+			$this->process_form_submit();
 		}
 
-				$this->generate_webhook_section();
+		// Generate the dynamic HTML content for enabling/disabling forum notifications
 		$this->generate_forum_section();
-				break;
-
-			case 'settings':
-			default:
-				$this->tpl_name = 'acp_discord_notifications_settings';
 
-				if ($this->request->is_set_post('submit'))
-				{
-					$this->process_settings_form_submit();
-				}
-				break;
-		}
+		$this->generate_webhook_section();
 
 		// Assign template values so that the page reflects the state of the extension settings
-		$this->template->assign_vars([
+		$this->template->assign_vars(array(
 			'DN_MASTER_ENABLE'			=> $this->config['discord_notifications_enabled'],
 			'DN_POST_PREVIEW_LENGTH'	=> $this->config['discord_notifications_post_preview_length'],
-			'DN_POST_PREVIEW_DESCRIPTION'	=> sprintf($this->language->lang('DN_POST_PREVIEW_DESCRIPTION'), self::MIN_POST_PREVIEW_LENGTH, self::MAX_POST_PREVIEW_LENGTH),
 			'DN_TEST_MESSAGE_TEXT'		=> $this->language->lang('DN_TEST_MESSAGE_TEXT'),
 			'DN_CONNECT_TIMEOUT'		=> $this->config['discord_notifications_connect_timeout'],
 			'DN_EXEC_TIMEOUT'			=> $this->config['discord_notifications_exec_timeout'],
@@ -151,9 +127,8 @@ class discord_notifications_module
 
 			'DN_DEFAULT_WEBHOOK'		=> $this->config['discord_notification_default_webhook'],
 
-			'DN_CURL_AVAILABLE'				=> $this->curl_available,
 			'U_ACTION'					=> $this->u_action,
-		]);
+		));
 	}
 
 	/**
@@ -184,12 +159,10 @@ class discord_notifications_module
 	 */
 	private function process_send_test_message()
 	{
-		global $table_prefix, $phpbb_container;
-
-		$this->validate_post_request();
+		global $table_prefix;
 
 		$webhook = $this->request->variable('dn_test_webhook', '', true);
-		$test_message = $this->request->variable('dn_test_message', '', true);
+		$test_message = $this->request->variable('dn_test_message', '');
 
 		// Check user inputs before attempting to send the message
 		if ($test_message == '')
@@ -206,8 +179,7 @@ class discord_notifications_module
 		$data = $this->db->sql_fetchrow($result);
 		$this->db->sql_freeresult($result);
 
-		$notification_service = $phpbb_container->get('mober.discordnotifications.notification_service');
-		$result = $notification_service->force_send_discord_notification($data['url'], $test_message);
+		$result = $this->notification_service->force_send_discord_notification($data['url'], $test_message);
 		if ($result)
 		{
 			trigger_error($this->language->lang('DN_TEST_SUCCESS') . adm_back_link($this->u_action));
@@ -222,7 +194,10 @@ class discord_notifications_module
 	{
 		global $table_prefix;
 
-		$this->validate_post_request();
+		if (!check_form_key(self::PAGE_FORM_NAME))
+		{
+			trigger_error('FORM_INVALID', E_USER_WARNING);
+		}
 
 		$delete_alias = $this->request->variable('action_delete_alias',  ['' => ''], true);
 		foreach ($delete_alias as $alias => $url)
@@ -236,9 +211,17 @@ class discord_notifications_module
 		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
 	}
 
-	private function process_settings_form_submit()
+	/**
+	 * Handles all error checking and database changes when the user hits the submit button on the ACP page.
+	 */
+	private function process_form_submit()
+	{
+		global $table_prefix;
+
+		if (!check_form_key(self::PAGE_FORM_NAME))
 		{
-		$this->validate_post_request();
+			trigger_error('FORM_INVALID', E_USER_WARNING);
+		}
 
 		// Get form values for the main settings
 		$master_enable = $this->request->variable('dn_master_enable', 0);
@@ -247,50 +230,14 @@ class discord_notifications_module
 		// Verify that the post preview length is a numeric string, convert to an int and check the valid range
 		if (!is_numeric($preview_length))
 		{
-			trigger_error(
-				sprintf(
-					$this->language->lang('DN_POST_PREVIEW_INVALID'),
-					self::MIN_POST_PREVIEW_LENGTH,
-					self::MAX_POST_PREVIEW_LENGTH
-				) . adm_back_link($this->u_action),
-				E_USER_WARNING
-			);
+			trigger_error($this->language->lang('DN_POST_PREVIEW_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
 		}
 		$preview_length = (int) $preview_length;
 		if ($preview_length != 0 && ($preview_length < self::MIN_POST_PREVIEW_LENGTH || $preview_length > self::MAX_POST_PREVIEW_LENGTH))
 		{
-			trigger_error(
-				sprintf(
-					$this->language->lang('DN_POST_PREVIEW_INVALID'),
-					self::MIN_POST_PREVIEW_LENGTH,
-					self::MAX_POST_PREVIEW_LENGTH
-				) . adm_back_link($this->u_action),
-				E_USER_WARNING
-			);
+			trigger_error($this->language->lang('DN_POST_PREVIEW_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
 		}
 
-		$connect_timeout = max(1, (int) $this->request->variable('dn_connect_to', 0));
-		$exec_timeout = max(1, (int) $this->request->variable('dn_exec_to', 0));
-
-		$this->config->set('discord_notifications_enabled', $master_enable);
-		$this->config->set('discord_notifications_post_preview_length', $preview_length);
-		$this->config->set('discord_notifications_connect_timeout', $connect_timeout);
-		$this->config->set('discord_notifications_exec_timeout', $exec_timeout);
-
-		// Log the settings change
-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE');
-		// Destroy any cached discord notification data
-		$this->cache->destroy('mober_discord_notifications');
-
-		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
-	}
-
-	private function process_webhooks_form_submit()
-	{
-		global $table_prefix;
-
-		$this->validate_post_request();
-
 		// Create new entry
 		$new_alias = $this->request->variable('dn_webhook_new_alias', '', true);
 		$new_url = $this->request->variable('dn_webhook_new_url', '');
@@ -320,26 +267,35 @@ class discord_notifications_module
 			$this->db->sql_query($sql);
 		}
 
-		// Log the settings change
-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE');
-		// Destroy any cached discord notification data
-		$this->cache->destroy('mober_discord_notifications');
-
-		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
-	}
-
-	private function process_mapping_form_submit()
-	{
-		$this->validate_post_request();
-
 		// Update configuration per forum
 		$forum_configuration = $this->request->variable('dn_forum', [0 => ''], true);
 		foreach ($forum_configuration as $id => $value)
+		{
+			// Don't update deleted entries
+			if ($value === '' || $webhook_configuration[$value] !== '')
 			{
 				$sql = "UPDATE " . FORUMS_TABLE . " SET discord_notifications = '" . $this->db->sql_escape($value) .
 					"' WHERE forum_id = " . (int) $id;
 				$this->db->sql_query($sql);
 			}
+		}
+
+		$connect_timeout = (int) $this->request->variable('dn_connect_to', 0);
+		if ($connect_timeout < 1)
+		{
+			$connect_timeout = 1;
+		}
+
+		$exec_timeout = (int) $this->request->variable('dn_exec_to', 0);
+		if ($exec_timeout < 1)
+		{
+			$exec_timeout = 1;
+		}
+
+		$this->config->set('discord_notifications_enabled', $master_enable);
+		$this->config->set('discord_notifications_post_preview_length', $preview_length);
+		$this->config->set('discord_notifications_connect_timeout', $connect_timeout);
+		$this->config->set('discord_notifications_exec_timeout', $exec_timeout);
 
 		$this->config->set('discord_notification_type_post_create', $this->request->variable('dn_post_create', 0));
 		$this->config->set('discord_notification_type_post_update', $this->request->variable('dn_post_update', 0));
@@ -377,10 +333,10 @@ class discord_notifications_module
 
 		while ($row = $this->db->sql_fetchrow($result))
 		{
-			$tpl_row = [
+			$tpl_row = array(
 				'ALIAS'	=> $row['alias'],
 				'URL'	=> $row['url'],
-			];
+			);
 			$this->template->assign_block_vars('webhookrow', $tpl_row);
 		}
 		$this->db->sql_freeresult($result);
@@ -400,7 +356,7 @@ class discord_notifications_module
 
 		$sql = "SELECT forum_id, forum_type, forum_name, left_id, right_id, parent_id, forum_parents, discord_notifications
 			FROM " . FORUMS_TABLE . "
-			ORDER BY left_id";
+			ORDER BY left_id ASC";
 		$result = $this->db->sql_query($sql);
 
 		while ($row = $this->db->sql_fetchrow($result))
@@ -408,23 +364,23 @@ class discord_notifications_module
 			// Category forums are displayed for organizational purposes, but have no configuration
 			if ($row['forum_type'] == FORUM_CAT)
 			{
-				$tpl_row = [
+				$tpl_row = array(
 					'S_IS_CAT'		=> true,
 					'FORUM_NAME'	=> $row['forum_name'],
 					'PARENTS'	=> '',
-				];
+				);
 				$this->template->assign_block_vars('forumrow', $tpl_row);
 			}
 			else if ($row['forum_type'] == FORUM_POST)
 			{
 				// The labels for all the inputs are constructed based on the forum IDs to make it easy to know which
-				$tpl_row = [
+				$tpl_row = array(
 							'S_IS_CAT'		=> false,
 							'FORUM_NAME'	=> $row['forum_name'],
 							'FORUM_ID'		=> $row['forum_id'],
 							'ALIAS'			=> $row['discord_notifications'],
 							'PARENTS'		=> '',
-				];
+						);
 				$parents = get_forum_parents($row);
 				if (is_array($parents))
 				{
@@ -439,12 +395,4 @@ class discord_notifications_module
 		}
 		$this->db->sql_freeresult($result);
 	}
-
-	private function validate_post_request()
-	{
-		if (!check_form_key(self::PAGE_FORM_NAME))
-		{
-			trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
-		}
-	}
 }
diff --git "[ORIGINAL]/mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html" "[FORUM_EXT]/mober\\discordnotifications/adm/style/acp_discord_notifications.html"
similarity index 63%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
--- "[ORIGINAL]/mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html"
+++ "[FORUM_EXT]/mober\\discordnotifications/adm/style/acp_discord_notifications.html"
@@ -1,40 +1,100 @@
-{% include 'overall_header.html' %}
+<!-- INCLUDE overall_header.html -->
 
 <h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
 
-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
-
-{% if not DN_CURL_AVAILABLE %}
-	<div class="errorbox">
-		<p>{{ lang('DN_MISSING_CURL') }}</p>
-	</div>
-{% endif %}
+<p>{{ DN_ACP_DESCRIPTION }}</p>
 
 <form id="acp_board" method="post" action="{{ U_ACTION }}">
 
 	<fieldset>
-		<legend>{{ lang('DN_WEBHOOK_DEFAULT') }}</legend>
+		<legend>{{ lang('DN_MAIN_SETTINGS') }}</legend>
 		<dl>
-			<dt><label>{{ lang('DN_USER_CREATE') }}{{ lang('COLON') }}</label></dt>
-			<dd><label><input type="radio" class="radio" name="dn_user_create" value="1" {% if DN_USER_CREATE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
-				<label><input type="radio" class="radio" name="dn_user_create" value="0" {% if not DN_USER_CREATE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+			<dt><label>{{ lang('DN_MASTER_ENABLE') }}{{ lang('COLON') }}</label></dt>
+			<dd><label><input type="radio" class="radio" name="dn_master_enable" value="1" {% if DN_MASTER_ENABLE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+				<label><input type="radio" class="radio" name="dn_master_enable" value="0" {% if not DN_MASTER_ENABLE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
 		</dl>
 		<dl>
-			<dt><label>{{ lang('DN_USER_DELETE') }}{{ lang('COLON') }}</label></dt>
-			<dd><label><input type="radio" class="radio" name="dn_user_delete" value="1" {% if DN_USER_DELETE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
-				<label><input type="radio" class="radio" name="dn_user_delete" value="0" {% if not DN_USER_DELETE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+			<dt><label for="dn_post_preview_length">{{ lang('DN_POST_PREVIEW_LENGTH') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_POST_PREVIEW_DESCRIPTION') }}</span></dt>
+			<dd>
+				<input id="dn_post_preview_length" name="dn_post_preview_length" type="text" value="{{ DN_POST_PREVIEW_LENGTH }}" size="4" maxlength="4" />
+			</dd>
 		</dl>
 		<dl>
-			<dt><label for="dn_webhook_default">{{ lang('DN_WEBHOOK_DEFAULT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_DEFAULT_DESCRIPTION') }}</span></dt>
+			<dt><label for="dn_connect_to">{{ lang('DN_CONNECT_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_CONNECT_TO_DESCRIPTION') }}</span></dt>
 			<dd>
-				<select id="dn_webhook_default" name="dn_webhook_default">
-					<option value="">({{ lang('DISABLED') }})</option>
+				<input id="dn_connect_to" name="dn_connect_to" type="text" value="{{ DN_CONNECT_TIMEOUT }}" size="4" maxlength="4" />
+			</dd>
+		</dl>
+		<dl>
+			<dt><label for="dn_exec_to">{{ lang('DN_EXEC_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_EXEC_TO_DESCRIPTION') }}</span></dt>
+			<dd>
+				<input id="dn_exec_to" name="dn_exec_to" type="text" value="{{ DN_EXEC_TIMEOUT }}" size="4" maxlength="4" />
+			</dd>
+		</dl>
+	</fieldset>
+
+	<fieldset>
+		<legend>{{ lang('DN_WEBHOOK_SETTINGS') }}</legend>
+		<p>{{ lang('DN_WEBHOOK_SETTINGS_DESCRIPTION') }}</p>
+		{% if loops.webhookrow %}
 			{% for webhook in loops.webhookrow %}
-						<option value="{{ webhook.ALIAS }}"{% if DN_DEFAULT_WEBHOOK == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
+				<dl>
+					<dt><label for="dn_webhook_{{ webhook.ALIAS }}">{{ webhook.ALIAS }}</label></dt>
+					<dd>
+						<input type="text" size="100" maxlength="255" id="dn_webhook_{{ webhook.ALIAS }}" name="dn_webhook[{{ webhook.ALIAS }}]" value="{{ webhook.URL }}" />
+						<input type="submit" name="action_delete_alias[{{ webhook.ALIAS }}]" value="{{ lang('DELETE') }}" class="button2" onclick="return confirm('{{ lang('CONFIRM_OPERATION') }}');">
+					</dd>
+				</dl>
+			{% endfor %}
+		{% else %}
+			<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
+		{% endif %}
+	</fieldset>
+
+	<fieldset>
+		<legend>{{ lang('DN_WEBHOOK_NEW') }}</legend>
+		<p>{{ lang('DN_WEBHOOK_NEW_DESCRIPTION') }}</p>
+		<dl>
+			<dt><label for="dn_webhook_new_alias">{{ lang('DN_WEBHOOK_NEW_ALIAS') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_ALIAS_DESCRIPTION') }}</span></dt>
+			<dd>
+				<input id="dn_webhook_new_alias" name="dn_webhook_new_alias" type="text" value="" size="100" maxlength="255" />
+			</dd>
+		</dl>
+		<dl>
+			<dt><label for="dn_webhook_new_url">{{ lang('DN_WEBHOOK_NEW_URL') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_URL_DESCRIPTION') }}</span></dt>
+			<dd>
+				<input id="dn_webhook_new_url" name="dn_webhook_new_url" type="text" value="" size="100" maxlength="255" />
+			</dd>
+		</dl>
+	</fieldset>
+
+	<fieldset>
+		<legend>{{ lang('DN_TEST_SETTINGS') }}</legend>
+		<dl>
+			<dt><label for="dn_test_message">{{ lang('DN_TEST_MESSAGE') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_TEST_DESCRIPTION') }}</span></dt>
+			<dd>
+				<input id="dn_test_message" name="dn_test_message" type="text" value="{{ DN_TEST_MESSAGE_TEXT }}" size="100" maxlength="255" />
+			</dd>
+		</dl>
+		{% if loops.webhookrow %}
+		<dl>
+			<dt><label for="dn_test_webhook">{{ lang('DN_WEBHOOK_SELECT') }}{{ lang('COLON') }}</label><br /></dt>
+			<dd>
+				<select id="dn_test_webhook" name="dn_test_webhook">
+					<option value="">{{ lang('DN_WEBHOOK_SELECT') }}</option>
+					{% for webhook in loops.webhookrow %}
+					<option value="{{ webhook.ALIAS }}"{% if forumrow.ALIAS == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
 					{% endfor %}
 				</select>
 			</dd>
 		</dl>
+		<dl>
+			<dt><label for="action_send_test_message">{{ lang('DN_SEND_TEST') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_SEND_TEST_DESCRIPTION') }}</span></dt>
+			<dd><input class="button2" type="submit" id="action_send_test_message" name="action_send_test_message" value="{{ lang('DN_SEND_TEST') }}" /></dd>
+		</dl>
+		{% else %}
+		<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
+		{% endif %}
 	</fieldset>
 
 	<fieldset>
@@ -100,6 +160,27 @@
 			<dd><label><input type="radio" class="radio" name="dn_topic_approve" value="1" {% if DN_TOPIC_APPROVE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
 				<label><input type="radio" class="radio" name="dn_topic_approve" value="0" {% if not DN_TOPIC_APPROVE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
 		</dl>
+		<dl>
+			<dt><label>{{ lang('DN_USER_CREATE') }}{{ lang('COLON') }}</label></dt>
+			<dd><label><input type="radio" class="radio" name="dn_user_create" value="1" {% if DN_USER_CREATE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+				<label><input type="radio" class="radio" name="dn_user_create" value="0" {% if not DN_USER_CREATE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+		</dl>
+		<dl>
+			<dt><label>{{ lang('DN_USER_DELETE') }}{{ lang('COLON') }}</label></dt>
+			<dd><label><input type="radio" class="radio" name="dn_user_delete" value="1" {% if DN_USER_DELETE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+				<label><input type="radio" class="radio" name="dn_user_delete" value="0" {% if not DN_USER_DELETE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+		</dl>
+		<dl>
+			<dt><label for="dn_webhook_default">{{ lang('DN_WEBHOOK_DEFAULT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_DEFAULT_DESCRIPTION') }}</span></dt>
+			<dd>
+				<select id="dn_webhook_default" name="dn_webhook_default">
+					<option value="">({{ lang('DISABLED') }})</option>
+					{% for webhook in loops.webhookrow %}
+					<option value="{{ webhook.ALIAS }}"{% if DN_DEFAULT_WEBHOOK == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
+					{% endfor %}
+				</select>
+			</dd>
+		</dl>
 	</fieldset>
 
 	<fieldset>
diff --git "[ORIGINAL]/mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html" "[ORIGINAL]/mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html"
deleted file mode 100644
--- "[ORIGINAL]/mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html"
+++ /dev/null
@@ -1,49 +0,0 @@
-{% include 'overall_header.html' %}
-
-<h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
-
-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
-
-{% if not DN_CURL_AVAILABLE %}
-	<div class="errorbox">
-		<p>{{ lang('DN_MISSING_CURL') }}</p>
-	</div>
-{% endif %}
-
-<form id="acp_board" method="post" action="{{ U_ACTION }}">
-
-	<fieldset>
-		<legend>{{ lang('DN_MAIN_SETTINGS') }}</legend>
-		<dl>
-			<dt><label>{{ lang('DN_MASTER_ENABLE') }}{{ lang('COLON') }}</label></dt>
-			<dd><label><input type="radio" class="radio" name="dn_master_enable" value="1" {% if DN_MASTER_ENABLE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
-				<label><input type="radio" class="radio" name="dn_master_enable" value="0" {% if not DN_MASTER_ENABLE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
-		</dl>
-		<dl>
-			<dt><label for="dn_post_preview_length">{{ lang('DN_POST_PREVIEW_LENGTH') }}{{ lang('COLON') }}</label><br /><span>{{ DN_POST_PREVIEW_DESCRIPTION }}</span></dt>
-			<dd>
-				<input id="dn_post_preview_length" name="dn_post_preview_length" type="text" value="{{ DN_POST_PREVIEW_LENGTH }}" size="4" maxlength="4" />
-			</dd>
-		</dl>
-		<dl>
-			<dt><label for="dn_connect_to">{{ lang('DN_CONNECT_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_CONNECT_TO_DESCRIPTION') }}</span></dt>
-			<dd>
-				<input id="dn_connect_to" name="dn_connect_to" type="text" value="{{ DN_CONNECT_TIMEOUT }}" size="4" maxlength="4" />
-			</dd>
-		</dl>
-		<dl>
-			<dt><label for="dn_exec_to">{{ lang('DN_EXEC_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_EXEC_TO_DESCRIPTION') }}</span></dt>
-			<dd>
-				<input id="dn_exec_to" name="dn_exec_to" type="text" value="{{ DN_EXEC_TIMEOUT }}" size="4" maxlength="4" />
-			</dd>
-		</dl>
-	</fieldset>
-
-	<fieldset class="submit-buttons">
-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
-		{{ S_FORM_TOKEN }}
-	</fieldset>
-
-</form>
-
-{% include 'overall_footer.html' %}
diff --git "[ORIGINAL]/mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html" "[ORIGINAL]/mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html"
deleted file mode 100644
--- "[ORIGINAL]/mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html"
+++ /dev/null
@@ -1,86 +0,0 @@
-{% include 'overall_header.html' %}
-
-<h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
-
-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
-
-{% if not DN_CURL_AVAILABLE %}
-	<div class="errorbox">
-		<p>{{ lang('DN_MISSING_CURL') }}</p>
-	</div>
-{% endif %}
-
-<form id="acp_board" method="post" action="{{ U_ACTION }}">
-
-	<fieldset>
-		<legend>{{ lang('DN_WEBHOOK_SETTINGS') }}</legend>
-		<p>{{ lang('DN_WEBHOOK_SETTINGS_DESCRIPTION') }}</p>
-		{% if loops.webhookrow %}
-			{% for webhook in loops.webhookrow %}
-				<dl>
-					<dt><label for="dn_webhook_{{ webhook.ALIAS }}">{{ webhook.ALIAS }}</label></dt>
-					<dd>
-						<input type="text" size="100" maxlength="255" id="dn_webhook_{{ webhook.ALIAS }}" name="dn_webhook[{{ webhook.ALIAS }}]" value="{{ webhook.URL }}" />
-						<input type="submit" name="action_delete_alias[{{ webhook.ALIAS }}]" value="{{ lang('DELETE') }}" class="button2" onclick="return confirm('{{ lang('CONFIRM_OPERATION') }}');">
-					</dd>
-				</dl>
-			{% endfor %}
-		{% else %}
-			<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
-		{% endif %}
-	</fieldset>
-
-	<fieldset>
-		<legend>{{ lang('DN_WEBHOOK_NEW') }}</legend>
-		<p>{{ lang('DN_WEBHOOK_NEW_DESCRIPTION') }}</p>
-		<dl>
-			<dt><label for="dn_webhook_new_alias">{{ lang('DN_WEBHOOK_NEW_ALIAS') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_ALIAS_DESCRIPTION') }}</span></dt>
-			<dd>
-				<input id="dn_webhook_new_alias" name="dn_webhook_new_alias" type="text" value="" size="100" maxlength="255" />
-			</dd>
-		</dl>
-		<dl>
-			<dt><label for="dn_webhook_new_url">{{ lang('DN_WEBHOOK_NEW_URL') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_URL_DESCRIPTION') }}</span></dt>
-			<dd>
-				<input id="dn_webhook_new_url" name="dn_webhook_new_url" type="text" value="" size="100" maxlength="255" />
-			</dd>
-		</dl>
-	</fieldset>
-
-	<fieldset>
-		<legend>{{ lang('DN_TEST_SETTINGS') }}</legend>
-		{% if loops.webhookrow %}
-		<dl>
-			<dt><label for="dn_test_message">{{ lang('DN_TEST_MESSAGE') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_TEST_DESCRIPTION') }}</span></dt>
-			<dd>
-				<input id="dn_test_message" name="dn_test_message" type="text" value="{{ DN_TEST_MESSAGE_TEXT }}" size="100" maxlength="255" />
-			</dd>
-		</dl>
-		<dl>
-			<dt><label for="dn_test_webhook">{{ lang('DN_WEBHOOK_SELECT') }}{{ lang('COLON') }}</label><br /></dt>
-			<dd>
-				<select id="dn_test_webhook" name="dn_test_webhook">
-					<option value="">{{ lang('DN_WEBHOOK_SELECT') }}</option>
-					{% for webhook in loops.webhookrow %}
-					<option value="{{ webhook.ALIAS }}"{% if forumrow.ALIAS == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
-					{% endfor %}
-				</select>
-			</dd>
-		</dl>
-		<dl>
-			<dt><label for="action_send_test_message">{{ lang('DN_SEND_TEST') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_SEND_TEST_DESCRIPTION') }}</span></dt>
-			<dd><input class="button2" type="submit" id="action_send_test_message" name="action_send_test_message" value="{{ lang('DN_SEND_TEST') }}" /></dd>
-		</dl>
-		{% else %}
-		<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
-		{% endif %}
-	</fieldset>
-
-	<fieldset class="submit-buttons">
-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
-		{{ S_FORM_TOKEN }}
-	</fieldset>
-
-</form>
-
-{% include 'overall_footer.html' %}
diff --git "[ORIGINAL]/mober\\discordnotifications/composer.json" "[FORUM_EXT]/mober\\discordnotifications/composer.json"
--- "[ORIGINAL]/mober\\discordnotifications/composer.json"
+++ "[FORUM_EXT]/mober\\discordnotifications/composer.json"
@@ -3,7 +3,7 @@
     "type": "phpbb-extension",
     "description": "Publishes forum event notifications to a Discord server channel",
     "homepage": "https://github.com/m-ober/phpbb-discord-notifications",
-    "version": "3.0.8",
+    "version": "3.0.7",
     "keywords": [
         "phpbb",
         "extension",
@@ -24,15 +24,15 @@
         }
     ],
     "require": {
-        "php": ">=7.2",
+        "php": ">=7.1",
         "ext-curl": "*",
         "composer/installers": "~1.0.0",
-        "phpbb/phpbb": ">=3.3.11"
+        "phpbb/phpbb": ">=3.3.0"
     },
     "extra": {
         "display-name": "Discord Notifications",
         "soft-require": {
-            "phpbb/phpbb": ">=3.3.11"
+            "phpbb/phpbb": ">=3.3.0"
         },
         "version-check": {
             "host": "www.phpbb.com",
diff --git "[FORUM_EXT]/mober\\discordnotifications/diff_full.tmp" "[FORUM_EXT]/mober\\discordnotifications/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/mober\\discordnotifications/diff_full.tmp"
@@ -0,0 +1,2441 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
+index 0283d968d..27cf0e844 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
+@@ -2,8 +2,8 @@
+ /**
+  * Discord Notifications extension for the phpBB Forum Software package.
+  *
+- * @copyright (c)	2018, Tyler Olsen, https://github.com/rootslinux
+- * @license			GNU General Public License, version 2 (GPL-2.0)
++ * @copyright (c) 2018, Tyler Olsen, https://github.com/rootslinux
++ * @license GNU General Public License, version 2 (GPL-2.0)
+  */
+ 
+ namespace mober\discordnotifications\acp;
+@@ -15,26 +15,16 @@ class discord_notifications_info
+ {
+ 	public function module()
+ 	{
+-		return [
++		return array(
+ 			'filename'	=> '\mober\discordnotifications\acp\discord_notifications_module',
+ 			'title'		=> 'ACP_DISCORD_NOTIFICATIONS',
+-			'modes'		=> [
+-				'settings'	=> [
+-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_SETTINGS',
++			'modes'		=> array(
++				'settings'	=> array(
++					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_TITLE',
+ 					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
+-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
+-				],
+-				'webhooks'	=> [
+-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS',
+-					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
+-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
+-				],
+-				'mapping'	=> [
+-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_MAPPING',
+-					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
+-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
+-				],
+-			],
+-		];
++					'cat'	=> array('ACP_DISCORD_NOTIFICATIONS')
++				),
++			),
++		);
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
+index bd7741639..fb82cbbad 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
+@@ -18,8 +18,9 @@ class discord_notifications_module
+ 	const MIN_POST_PREVIEW_LENGTH = 10;
+ 
+ 	// The maximum number of characters that the user can set for the post preview setting.
+-	// See: https://discord.com/developers/docs/resources/channel#embed-object-embed-limits
+-	const MAX_POST_PREVIEW_LENGTH = 1024;
++	// Note that this is slightly less than the actual allowed maximum by Discord (2048), but we reserve
++	// some space to prepend the preview text with something like "Preview: " or "Reason: "
++	const MAX_POST_PREVIEW_LENGTH = 2000;
+ 
+ 	// The name for the form used for this page
+ 	const PAGE_FORM_NAME = 'acp_mober_discord_notifications';
+@@ -48,6 +49,9 @@ class discord_notifications_module
+ 	/** @var \phpbb\log\log */
+ 	protected $log;
+ 
++	/** @var \mober\discordnotifications\notification_service */
++	protected $notification_service;
++
+ 	/** @var \phpbb\request\request */
+ 	protected $request;
+ 
+@@ -57,13 +61,9 @@ class discord_notifications_module
+ 	/** @var \phpbb\user */
+ 	protected $user;
+ 
+-	/** @var bool */
+-	private  $curl_available;
+-
+ 	public function main($id, $mode)
+ 	{
+ 		global $phpbb_container;
+-
+ 		$this->cache = $phpbb_container->get('cache.driver');
+ 		$this->config = $phpbb_container->get('config');
+ 		$this->db = $phpbb_container->get('dbal.conn');
+@@ -72,88 +72,63 @@ class discord_notifications_module
+ 		$this->request = $phpbb_container->get('request');
+ 		$this->template = $phpbb_container->get('template');
+ 		$this->user = $phpbb_container->get('user');
+-		$this->curl_available = extension_loaded('curl');
++		// Used for sending test messages to Discord
++		$this->notification_service = $phpbb_container->get('mober.discordnotifications.notification_service');
+ 
+ 		$this->language->add_lang('acp_discord_notifications', 'mober/discordnotifications');
+-		$this->page_title = $this->language->lang('ACP_DISCORD_NOTIFICATIONS');
++		$this->tpl_name = 'acp_discord_notifications';
++		$this->page_title = $this->language->lang('ACP_DISCORD_NOTIFICATIONS_TITLE');
+ 
+ 		add_form_key(self::PAGE_FORM_NAME);
+ 
+-		switch ($mode)
++		// Process submit actions
++		if ($this->request->is_set_post('action_send_test_message'))
+ 		{
+-			case 'webhooks':
+-				$this->tpl_name = 'acp_discord_notifications_webhooks';
+-
+-				if ($this->request->is_set_post('action_send_test_message'))
+-				{
+-					$this->process_send_test_message();
+-				}
+-				else if ($this->request->is_set_post('action_delete_alias'))
+-				{
+-					$this->process_delete_alias();
+-				}
+-				else if ($this->request->is_set_post('submit'))
+-				{
+-					$this->process_webhooks_form_submit();
+-				}
+-
+-				$this->generate_webhook_section();
+-				break;
+-
+-			case 'mapping':
+-				$this->tpl_name = 'acp_discord_notifications_mapping';
+-
+-				if ($this->request->is_set_post('submit'))
+-				{
+-					$this->process_mapping_form_submit();
+-				}
+-
+-				$this->generate_webhook_section();
+-				$this->generate_forum_section();
+-				break;
++			$this->process_send_test_message();
++		}
++		else if ($this->request->is_set_post('action_delete_alias'))
++		{
++			$this->process_delete_alias();
++		}
++		else if ($this->request->is_set_post('submit'))
++		{
++			$this->process_form_submit();
++		}
+ 
+-			case 'settings':
+-			default:
+-				$this->tpl_name = 'acp_discord_notifications_settings';
++		// Generate the dynamic HTML content for enabling/disabling forum notifications
++		$this->generate_forum_section();
+ 
+-				if ($this->request->is_set_post('submit'))
+-				{
+-					$this->process_settings_form_submit();
+-				}
+-				break;
+-		}
++		$this->generate_webhook_section();
+ 
+ 		// Assign template values so that the page reflects the state of the extension settings
+-		$this->template->assign_vars([
+-			'DN_MASTER_ENABLE'				=> $this->config['discord_notifications_enabled'],
+-			'DN_POST_PREVIEW_LENGTH'		=> $this->config['discord_notifications_post_preview_length'],
+-			'DN_POST_PREVIEW_DESCRIPTION'	=> sprintf($this->language->lang('DN_POST_PREVIEW_DESCRIPTION'), self::MIN_POST_PREVIEW_LENGTH, self::MAX_POST_PREVIEW_LENGTH),
+-			'DN_TEST_MESSAGE_TEXT'			=> $this->language->lang('DN_TEST_MESSAGE_TEXT'),
+-			'DN_CONNECT_TIMEOUT'			=> $this->config['discord_notifications_connect_timeout'],
+-			'DN_EXEC_TIMEOUT'				=> $this->config['discord_notifications_exec_timeout'],
+-
+-			'DN_POST_CREATE'				=> $this->config['discord_notification_type_post_create'],
+-			'DN_POST_UPDATE'				=> $this->config['discord_notification_type_post_update'],
+-			'DN_POST_DELETE'				=> $this->config['discord_notification_type_post_delete'],
+-			'DN_POST_LOCK'					=> $this->config['discord_notification_type_post_lock'],
+-			'DN_POST_UNLOCK'				=> $this->config['discord_notification_type_post_unlock'],
+-			'DN_POST_APPROVE'				=> $this->config['discord_notification_type_post_approve'],
+-
+-			'DN_TOPIC_CREATE'				=> $this->config['discord_notification_type_topic_create'],
+-			'DN_TOPIC_UPDATE'				=> $this->config['discord_notification_type_topic_update'],
+-			'DN_TOPIC_DELETE'				=> $this->config['discord_notification_type_topic_delete'],
+-			'DN_TOPIC_LOCK'					=> $this->config['discord_notification_type_topic_lock'],
+-			'DN_TOPIC_UNLOCK'				=> $this->config['discord_notification_type_topic_unlock'],
+-			'DN_TOPIC_APPROVE'				=> $this->config['discord_notification_type_topic_approve'],
+-
+-			'DN_USER_CREATE'				=> $this->config['discord_notification_type_user_create'],
+-			'DN_USER_DELETE'				=> $this->config['discord_notification_type_user_delete'],
+-
+-			'DN_DEFAULT_WEBHOOK'			=> $this->config['discord_notification_default_webhook'],
+-
+-			'DN_CURL_AVAILABLE'				=> $this->curl_available,
+-			'U_ACTION'						=> $this->u_action,
+-		]);
++		$this->template->assign_vars(array(
++			'DN_MASTER_ENABLE'			=> $this->config['discord_notifications_enabled'],
++			'DN_POST_PREVIEW_LENGTH'	=> $this->config['discord_notifications_post_preview_length'],
++			'DN_TEST_MESSAGE_TEXT'		=> $this->language->lang('DN_TEST_MESSAGE_TEXT'),
++			'DN_CONNECT_TIMEOUT'		=> $this->config['discord_notifications_connect_timeout'],
++			'DN_EXEC_TIMEOUT'			=> $this->config['discord_notifications_exec_timeout'],
++
++			'DN_POST_CREATE'			=> $this->config['discord_notification_type_post_create'],
++			'DN_POST_UPDATE'			=> $this->config['discord_notification_type_post_update'],
++			'DN_POST_DELETE'			=> $this->config['discord_notification_type_post_delete'],
++			'DN_POST_LOCK'				=> $this->config['discord_notification_type_post_lock'],
++			'DN_POST_UNLOCK'			=> $this->config['discord_notification_type_post_unlock'],
++			'DN_POST_APPROVE'			=> $this->config['discord_notification_type_post_approve'],
++
++			'DN_TOPIC_CREATE'			=> $this->config['discord_notification_type_topic_create'],
++			'DN_TOPIC_UPDATE'			=> $this->config['discord_notification_type_topic_update'],
++			'DN_TOPIC_DELETE'			=> $this->config['discord_notification_type_topic_delete'],
++			'DN_TOPIC_LOCK'				=> $this->config['discord_notification_type_topic_lock'],
++			'DN_TOPIC_UNLOCK'			=> $this->config['discord_notification_type_topic_unlock'],
++			'DN_TOPIC_APPROVE'			=> $this->config['discord_notification_type_topic_approve'],
++
++			'DN_USER_CREATE'			=> $this->config['discord_notification_type_user_create'],
++			'DN_USER_DELETE'			=> $this->config['discord_notification_type_user_delete'],
++
++			'DN_DEFAULT_WEBHOOK'		=> $this->config['discord_notification_default_webhook'],
++
++			'U_ACTION'					=> $this->u_action,
++		));
+ 	}
+ 
+ 	/**
+@@ -184,12 +159,10 @@ class discord_notifications_module
+ 	 */
+ 	private function process_send_test_message()
+ 	{
+-		global $table_prefix, $phpbb_container;
+-
+-		$this->validate_post_request();
++		global $table_prefix;
+ 
+ 		$webhook = $this->request->variable('dn_test_webhook', '', true);
+-		$test_message = $this->request->variable('dn_test_message', '', true);
++		$test_message = $this->request->variable('dn_test_message', '');
+ 
+ 		// Check user inputs before attempting to send the message
+ 		if ($test_message == '')
+@@ -206,8 +179,7 @@ class discord_notifications_module
+ 		$data = $this->db->sql_fetchrow($result);
+ 		$this->db->sql_freeresult($result);
+ 
+-		$notification_service = $phpbb_container->get('mober.discordnotifications.notification_service');
+-		$result = $notification_service->force_send_discord_notification($data['url'], $test_message);
++		$result = $this->notification_service->force_send_discord_notification($data['url'], $test_message);
+ 		if ($result)
+ 		{
+ 			trigger_error($this->language->lang('DN_TEST_SUCCESS') . adm_back_link($this->u_action));
+@@ -222,7 +194,10 @@ class discord_notifications_module
+ 	{
+ 		global $table_prefix;
+ 
+-		$this->validate_post_request();
++		if (!check_form_key(self::PAGE_FORM_NAME))
++		{
++			trigger_error('FORM_INVALID', E_USER_WARNING);
++		}
+ 
+ 		$delete_alias = $this->request->variable('action_delete_alias',  ['' => ''], true);
+ 		foreach ($delete_alias as $alias => $url)
+@@ -236,9 +211,17 @@ class discord_notifications_module
+ 		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
+ 	}
+ 
+-	private function process_settings_form_submit()
++	/**
++	 * Handles all error checking and database changes when the user hits the submit button on the ACP page.
++	 */
++	private function process_form_submit()
+ 	{
+-		$this->validate_post_request();
++		global $table_prefix;
++
++		if (!check_form_key(self::PAGE_FORM_NAME))
++		{
++			trigger_error('FORM_INVALID', E_USER_WARNING);
++		}
+ 
+ 		// Get form values for the main settings
+ 		$master_enable = $this->request->variable('dn_master_enable', 0);
+@@ -247,50 +230,14 @@ class discord_notifications_module
+ 		// Verify that the post preview length is a numeric string, convert to an int and check the valid range
+ 		if (!is_numeric($preview_length))
+ 		{
+-			trigger_error(
+-				sprintf(
+-					$this->language->lang('DN_POST_PREVIEW_INVALID'),
+-					self::MIN_POST_PREVIEW_LENGTH,
+-					self::MAX_POST_PREVIEW_LENGTH
+-				) . adm_back_link($this->u_action),
+-				E_USER_WARNING
+-			);
++			trigger_error($this->language->lang('DN_POST_PREVIEW_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
+ 		}
+ 		$preview_length = (int) $preview_length;
+ 		if ($preview_length != 0 && ($preview_length < self::MIN_POST_PREVIEW_LENGTH || $preview_length > self::MAX_POST_PREVIEW_LENGTH))
+ 		{
+-			trigger_error(
+-				sprintf(
+-					$this->language->lang('DN_POST_PREVIEW_INVALID'),
+-					self::MIN_POST_PREVIEW_LENGTH,
+-					self::MAX_POST_PREVIEW_LENGTH
+-				) . adm_back_link($this->u_action),
+-				E_USER_WARNING
+-			);
++			trigger_error($this->language->lang('DN_POST_PREVIEW_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
+ 		}
+ 
+-		$connect_timeout = max(1, (int) $this->request->variable('dn_connect_to', 0));
+-		$exec_timeout = max(1, (int) $this->request->variable('dn_exec_to', 0));
+-
+-		$this->config->set('discord_notifications_enabled', $master_enable);
+-		$this->config->set('discord_notifications_post_preview_length', $preview_length);
+-		$this->config->set('discord_notifications_connect_timeout', $connect_timeout);
+-		$this->config->set('discord_notifications_exec_timeout', $exec_timeout);
+-
+-		// Log the settings change
+-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE');
+-		// Destroy any cached discord notification data
+-		$this->cache->destroy('mober_discord_notifications');
+-
+-		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
+-	}
+-
+-	private function process_webhooks_form_submit()
+-	{
+-		global $table_prefix;
+-
+-		$this->validate_post_request();
+-
+ 		// Create new entry
+ 		$new_alias = $this->request->variable('dn_webhook_new_alias', '', true);
+ 		$new_url = $this->request->variable('dn_webhook_new_url', '');
+@@ -320,27 +267,36 @@ class discord_notifications_module
+ 			$this->db->sql_query($sql);
+ 		}
+ 
+-		// Log the settings change
+-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE');
+-		// Destroy any cached discord notification data
+-		$this->cache->destroy('mober_discord_notifications');
+-
+-		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
+-	}
+-
+-	private function process_mapping_form_submit()
+-	{
+-		$this->validate_post_request();
+-
+ 		// Update configuration per forum
+ 		$forum_configuration = $this->request->variable('dn_forum', [0 => ''], true);
+ 		foreach ($forum_configuration as $id => $value)
+ 		{
+-			$sql = "UPDATE " . FORUMS_TABLE . " SET discord_notifications = '" . $this->db->sql_escape($value) .
+-				"' WHERE forum_id = " . (int) $id;
+-			$this->db->sql_query($sql);
++			// Don't update deleted entries
++			if ($value === '' || $webhook_configuration[$value] !== '')
++			{
++				$sql = "UPDATE " . FORUMS_TABLE . " SET discord_notifications = '" . $this->db->sql_escape($value) .
++					"' WHERE forum_id = " . (int) $id;
++				$this->db->sql_query($sql);
++			}
++		}
++
++		$connect_timeout = (int) $this->request->variable('dn_connect_to', 0);
++		if ($connect_timeout < 1)
++		{
++			$connect_timeout = 1;
+ 		}
+ 
++		$exec_timeout = (int) $this->request->variable('dn_exec_to', 0);
++		if ($exec_timeout < 1)
++		{
++			$exec_timeout = 1;
++		}
++
++		$this->config->set('discord_notifications_enabled', $master_enable);
++		$this->config->set('discord_notifications_post_preview_length', $preview_length);
++		$this->config->set('discord_notifications_connect_timeout', $connect_timeout);
++		$this->config->set('discord_notifications_exec_timeout', $exec_timeout);
++
+ 		$this->config->set('discord_notification_type_post_create', $this->request->variable('dn_post_create', 0));
+ 		$this->config->set('discord_notification_type_post_update', $this->request->variable('dn_post_update', 0));
+ 		$this->config->set('discord_notification_type_post_delete', $this->request->variable('dn_post_delete', 0));
+@@ -377,10 +333,10 @@ class discord_notifications_module
+ 
+ 		while ($row = $this->db->sql_fetchrow($result))
+ 		{
+-			$tpl_row = [
++			$tpl_row = array(
+ 				'ALIAS'	=> $row['alias'],
+ 				'URL'	=> $row['url'],
+-			];
++			);
+ 			$this->template->assign_block_vars('webhookrow', $tpl_row);
+ 		}
+ 		$this->db->sql_freeresult($result);
+@@ -400,7 +356,7 @@ class discord_notifications_module
+ 
+ 		$sql = "SELECT forum_id, forum_type, forum_name, left_id, right_id, parent_id, forum_parents, discord_notifications
+ 			FROM " . FORUMS_TABLE . "
+-			ORDER BY left_id";
++			ORDER BY left_id ASC";
+ 		$result = $this->db->sql_query($sql);
+ 
+ 		while ($row = $this->db->sql_fetchrow($result))
+@@ -408,23 +364,23 @@ class discord_notifications_module
+ 			// Category forums are displayed for organizational purposes, but have no configuration
+ 			if ($row['forum_type'] == FORUM_CAT)
+ 			{
+-				$tpl_row = [
++				$tpl_row = array(
+ 					'S_IS_CAT'		=> true,
+ 					'FORUM_NAME'	=> $row['forum_name'],
+-					'PARENTS'		=> '',
+-				];
++					'PARENTS'	=> '',
++				);
+ 				$this->template->assign_block_vars('forumrow', $tpl_row);
+ 			}
+ 			else if ($row['forum_type'] == FORUM_POST)
+ 			{
+ 				// The labels for all the inputs are constructed based on the forum IDs to make it easy to know which
+-				$tpl_row = [
+-					'S_IS_CAT'		=> false,
+-					'FORUM_NAME'	=> $row['forum_name'],
+-					'FORUM_ID'		=> $row['forum_id'],
+-					'ALIAS'			=> $row['discord_notifications'],
+-					'PARENTS'		=> '',
+-				];
++				$tpl_row = array(
++							'S_IS_CAT'		=> false,
++							'FORUM_NAME'	=> $row['forum_name'],
++							'FORUM_ID'		=> $row['forum_id'],
++							'ALIAS'			=> $row['discord_notifications'],
++							'PARENTS'		=> '',
++						);
+ 				$parents = get_forum_parents($row);
+ 				if (is_array($parents))
+ 				{
+@@ -439,12 +395,4 @@ class discord_notifications_module
+ 		}
+ 		$this->db->sql_freeresult($result);
+ 	}
+-
+-	private function validate_post_request()
+-	{
+-		if (!check_form_key(self::PAGE_FORM_NAME))
+-		{
+-			trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
+-		}
+-	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
+similarity index 63%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
+index e059a8f75..27ee7d868 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
+@@ -1,40 +1,100 @@
+-{% include 'overall_header.html' %}
++<!-- INCLUDE overall_header.html -->
+ 
+ <h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
+ 
+-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
+-
+-{% if not DN_CURL_AVAILABLE %}
+-	<div class="errorbox">
+-		<p>{{ lang('DN_MISSING_CURL') }}</p>
+-	</div>
+-{% endif %}
++<p>{{ DN_ACP_DESCRIPTION }}</p>
+ 
+ <form id="acp_board" method="post" action="{{ U_ACTION }}">
+ 
+ 	<fieldset>
+-		<legend>{{ lang('DN_WEBHOOK_DEFAULT') }}</legend>
++		<legend>{{ lang('DN_MAIN_SETTINGS') }}</legend>
+ 		<dl>
+-			<dt><label>{{ lang('DN_USER_CREATE') }}{{ lang('COLON') }}</label></dt>
+-			<dd><label><input type="radio" class="radio" name="dn_user_create" value="1" {% if DN_USER_CREATE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="dn_user_create" value="0" {% if not DN_USER_CREATE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++			<dt><label>{{ lang('DN_MASTER_ENABLE') }}{{ lang('COLON') }}</label></dt>
++			<dd><label><input type="radio" class="radio" name="dn_master_enable" value="1" {% if DN_MASTER_ENABLE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="dn_master_enable" value="0" {% if not DN_MASTER_ENABLE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label>{{ lang('DN_USER_DELETE') }}{{ lang('COLON') }}</label></dt>
+-			<dd><label><input type="radio" class="radio" name="dn_user_delete" value="1" {% if DN_USER_DELETE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="dn_user_delete" value="0" {% if not DN_USER_DELETE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++			<dt><label for="dn_post_preview_length">{{ lang('DN_POST_PREVIEW_LENGTH') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_POST_PREVIEW_DESCRIPTION') }}</span></dt>
++			<dd>
++				<input id="dn_post_preview_length" name="dn_post_preview_length" type="text" value="{{ DN_POST_PREVIEW_LENGTH }}" size="4" maxlength="4" />
++			</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="dn_webhook_default">{{ lang('DN_WEBHOOK_DEFAULT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_DEFAULT_DESCRIPTION') }}</span></dt>
++			<dt><label for="dn_connect_to">{{ lang('DN_CONNECT_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_CONNECT_TO_DESCRIPTION') }}</span></dt>
+ 			<dd>
+-				<select id="dn_webhook_default" name="dn_webhook_default">
+-					<option value="">({{ lang('DISABLED') }})</option>
++				<input id="dn_connect_to" name="dn_connect_to" type="text" value="{{ DN_CONNECT_TIMEOUT }}" size="4" maxlength="4" />
++			</dd>
++		</dl>
++		<dl>
++			<dt><label for="dn_exec_to">{{ lang('DN_EXEC_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_EXEC_TO_DESCRIPTION') }}</span></dt>
++			<dd>
++				<input id="dn_exec_to" name="dn_exec_to" type="text" value="{{ DN_EXEC_TIMEOUT }}" size="4" maxlength="4" />
++			</dd>
++		</dl>
++	</fieldset>
++
++	<fieldset>
++		<legend>{{ lang('DN_WEBHOOK_SETTINGS') }}</legend>
++		<p>{{ lang('DN_WEBHOOK_SETTINGS_DESCRIPTION') }}</p>
++		{% if loops.webhookrow %}
++			{% for webhook in loops.webhookrow %}
++				<dl>
++					<dt><label for="dn_webhook_{{ webhook.ALIAS }}">{{ webhook.ALIAS }}</label></dt>
++					<dd>
++						<input type="text" size="100" maxlength="255" id="dn_webhook_{{ webhook.ALIAS }}" name="dn_webhook[{{ webhook.ALIAS }}]" value="{{ webhook.URL }}" />
++						<input type="submit" name="action_delete_alias[{{ webhook.ALIAS }}]" value="{{ lang('DELETE') }}" class="button2" onclick="return confirm('{{ lang('CONFIRM_OPERATION') }}');">
++					</dd>
++				</dl>
++			{% endfor %}
++		{% else %}
++			<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
++		{% endif %}
++	</fieldset>
++
++	<fieldset>
++		<legend>{{ lang('DN_WEBHOOK_NEW') }}</legend>
++		<p>{{ lang('DN_WEBHOOK_NEW_DESCRIPTION') }}</p>
++		<dl>
++			<dt><label for="dn_webhook_new_alias">{{ lang('DN_WEBHOOK_NEW_ALIAS') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_ALIAS_DESCRIPTION') }}</span></dt>
++			<dd>
++				<input id="dn_webhook_new_alias" name="dn_webhook_new_alias" type="text" value="" size="100" maxlength="255" />
++			</dd>
++		</dl>
++		<dl>
++			<dt><label for="dn_webhook_new_url">{{ lang('DN_WEBHOOK_NEW_URL') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_URL_DESCRIPTION') }}</span></dt>
++			<dd>
++				<input id="dn_webhook_new_url" name="dn_webhook_new_url" type="text" value="" size="100" maxlength="255" />
++			</dd>
++		</dl>
++	</fieldset>
++
++	<fieldset>
++		<legend>{{ lang('DN_TEST_SETTINGS') }}</legend>
++		<dl>
++			<dt><label for="dn_test_message">{{ lang('DN_TEST_MESSAGE') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_TEST_DESCRIPTION') }}</span></dt>
++			<dd>
++				<input id="dn_test_message" name="dn_test_message" type="text" value="{{ DN_TEST_MESSAGE_TEXT }}" size="100" maxlength="255" />
++			</dd>
++		</dl>
++		{% if loops.webhookrow %}
++		<dl>
++			<dt><label for="dn_test_webhook">{{ lang('DN_WEBHOOK_SELECT') }}{{ lang('COLON') }}</label><br /></dt>
++			<dd>
++				<select id="dn_test_webhook" name="dn_test_webhook">
++					<option value="">{{ lang('DN_WEBHOOK_SELECT') }}</option>
+ 					{% for webhook in loops.webhookrow %}
+-						<option value="{{ webhook.ALIAS }}"{% if DN_DEFAULT_WEBHOOK == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
++					<option value="{{ webhook.ALIAS }}"{% if forumrow.ALIAS == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
+ 					{% endfor %}
+ 				</select>
+ 			</dd>
+ 		</dl>
++		<dl>
++			<dt><label for="action_send_test_message">{{ lang('DN_SEND_TEST') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_SEND_TEST_DESCRIPTION') }}</span></dt>
++			<dd><input class="button2" type="submit" id="action_send_test_message" name="action_send_test_message" value="{{ lang('DN_SEND_TEST') }}" /></dd>
++		</dl>
++		{% else %}
++		<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
++		{% endif %}
+ 	</fieldset>
+ 
+ 	<fieldset>
+@@ -100,6 +160,27 @@
+ 			<dd><label><input type="radio" class="radio" name="dn_topic_approve" value="1" {% if DN_TOPIC_APPROVE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+ 				<label><input type="radio" class="radio" name="dn_topic_approve" value="0" {% if not DN_TOPIC_APPROVE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 		</dl>
++		<dl>
++			<dt><label>{{ lang('DN_USER_CREATE') }}{{ lang('COLON') }}</label></dt>
++			<dd><label><input type="radio" class="radio" name="dn_user_create" value="1" {% if DN_USER_CREATE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="dn_user_create" value="0" {% if not DN_USER_CREATE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++		</dl>
++		<dl>
++			<dt><label>{{ lang('DN_USER_DELETE') }}{{ lang('COLON') }}</label></dt>
++			<dd><label><input type="radio" class="radio" name="dn_user_delete" value="1" {% if DN_USER_DELETE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="dn_user_delete" value="0" {% if not DN_USER_DELETE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++		</dl>
++		<dl>
++			<dt><label for="dn_webhook_default">{{ lang('DN_WEBHOOK_DEFAULT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_DEFAULT_DESCRIPTION') }}</span></dt>
++			<dd>
++				<select id="dn_webhook_default" name="dn_webhook_default">
++					<option value="">({{ lang('DISABLED') }})</option>
++					{% for webhook in loops.webhookrow %}
++					<option value="{{ webhook.ALIAS }}"{% if DN_DEFAULT_WEBHOOK == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
++					{% endfor %}
++				</select>
++			</dd>
++		</dl>
+ 	</fieldset>
+ 
+ 	<fieldset>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html"
+deleted file mode 100644
+index 90eed3ee7..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html"
++++ /dev/null
+@@ -1,49 +0,0 @@
+-{% include 'overall_header.html' %}
+-
+-<h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
+-
+-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
+-
+-{% if not DN_CURL_AVAILABLE %}
+-	<div class="errorbox">
+-		<p>{{ lang('DN_MISSING_CURL') }}</p>
+-	</div>
+-{% endif %}
+-
+-<form id="acp_board" method="post" action="{{ U_ACTION }}">
+-
+-	<fieldset>
+-		<legend>{{ lang('DN_MAIN_SETTINGS') }}</legend>
+-		<dl>
+-			<dt><label>{{ lang('DN_MASTER_ENABLE') }}{{ lang('COLON') }}</label></dt>
+-			<dd><label><input type="radio" class="radio" name="dn_master_enable" value="1" {% if DN_MASTER_ENABLE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="dn_master_enable" value="0" {% if not DN_MASTER_ENABLE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+-		</dl>
+-		<dl>
+-			<dt><label for="dn_post_preview_length">{{ lang('DN_POST_PREVIEW_LENGTH') }}{{ lang('COLON') }}</label><br /><span>{{ DN_POST_PREVIEW_DESCRIPTION }}</span></dt>
+-			<dd>
+-				<input id="dn_post_preview_length" name="dn_post_preview_length" type="text" value="{{ DN_POST_PREVIEW_LENGTH }}" size="4" maxlength="4" />
+-			</dd>
+-		</dl>
+-		<dl>
+-			<dt><label for="dn_connect_to">{{ lang('DN_CONNECT_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_CONNECT_TO_DESCRIPTION') }}</span></dt>
+-			<dd>
+-				<input id="dn_connect_to" name="dn_connect_to" type="text" value="{{ DN_CONNECT_TIMEOUT }}" size="4" maxlength="4" />
+-			</dd>
+-		</dl>
+-		<dl>
+-			<dt><label for="dn_exec_to">{{ lang('DN_EXEC_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_EXEC_TO_DESCRIPTION') }}</span></dt>
+-			<dd>
+-				<input id="dn_exec_to" name="dn_exec_to" type="text" value="{{ DN_EXEC_TIMEOUT }}" size="4" maxlength="4" />
+-			</dd>
+-		</dl>
+-	</fieldset>
+-
+-	<fieldset class="submit-buttons">
+-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+-		{{ S_FORM_TOKEN }}
+-	</fieldset>
+-
+-</form>
+-
+-{% include 'overall_footer.html' %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html"
+deleted file mode 100644
+index a500594a6..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html"
++++ /dev/null
+@@ -1,86 +0,0 @@
+-{% include 'overall_header.html' %}
+-
+-<h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
+-
+-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
+-
+-{% if not DN_CURL_AVAILABLE %}
+-	<div class="errorbox">
+-		<p>{{ lang('DN_MISSING_CURL') }}</p>
+-	</div>
+-{% endif %}
+-
+-<form id="acp_board" method="post" action="{{ U_ACTION }}">
+-
+-	<fieldset>
+-		<legend>{{ lang('DN_WEBHOOK_SETTINGS') }}</legend>
+-		<p>{{ lang('DN_WEBHOOK_SETTINGS_DESCRIPTION') }}</p>
+-		{% if loops.webhookrow %}
+-			{% for webhook in loops.webhookrow %}
+-				<dl>
+-					<dt><label for="dn_webhook_{{ webhook.ALIAS }}">{{ webhook.ALIAS }}</label></dt>
+-					<dd>
+-						<input type="text" size="100" maxlength="255" id="dn_webhook_{{ webhook.ALIAS }}" name="dn_webhook[{{ webhook.ALIAS }}]" value="{{ webhook.URL }}" />
+-						<input type="submit" name="action_delete_alias[{{ webhook.ALIAS }}]" value="{{ lang('DELETE') }}" class="button2" onclick="return confirm('{{ lang('CONFIRM_OPERATION') }}');">
+-					</dd>
+-				</dl>
+-			{% endfor %}
+-		{% else %}
+-			<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
+-		{% endif %}
+-	</fieldset>
+-
+-	<fieldset>
+-		<legend>{{ lang('DN_WEBHOOK_NEW') }}</legend>
+-		<p>{{ lang('DN_WEBHOOK_NEW_DESCRIPTION') }}</p>
+-		<dl>
+-			<dt><label for="dn_webhook_new_alias">{{ lang('DN_WEBHOOK_NEW_ALIAS') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_ALIAS_DESCRIPTION') }}</span></dt>
+-			<dd>
+-				<input id="dn_webhook_new_alias" name="dn_webhook_new_alias" type="text" value="" size="100" maxlength="255" />
+-			</dd>
+-		</dl>
+-		<dl>
+-			<dt><label for="dn_webhook_new_url">{{ lang('DN_WEBHOOK_NEW_URL') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_URL_DESCRIPTION') }}</span></dt>
+-			<dd>
+-				<input id="dn_webhook_new_url" name="dn_webhook_new_url" type="text" value="" size="100" maxlength="255" />
+-			</dd>
+-		</dl>
+-	</fieldset>
+-
+-	<fieldset>
+-		<legend>{{ lang('DN_TEST_SETTINGS') }}</legend>
+-		{% if loops.webhookrow %}
+-		<dl>
+-			<dt><label for="dn_test_message">{{ lang('DN_TEST_MESSAGE') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_TEST_DESCRIPTION') }}</span></dt>
+-			<dd>
+-				<input id="dn_test_message" name="dn_test_message" type="text" value="{{ DN_TEST_MESSAGE_TEXT }}" size="100" maxlength="255" />
+-			</dd>
+-		</dl>
+-		<dl>
+-			<dt><label for="dn_test_webhook">{{ lang('DN_WEBHOOK_SELECT') }}{{ lang('COLON') }}</label><br /></dt>
+-			<dd>
+-				<select id="dn_test_webhook" name="dn_test_webhook">
+-					<option value="">{{ lang('DN_WEBHOOK_SELECT') }}</option>
+-					{% for webhook in loops.webhookrow %}
+-					<option value="{{ webhook.ALIAS }}"{% if forumrow.ALIAS == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
+-					{% endfor %}
+-				</select>
+-			</dd>
+-		</dl>
+-		<dl>
+-			<dt><label for="action_send_test_message">{{ lang('DN_SEND_TEST') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_SEND_TEST_DESCRIPTION') }}</span></dt>
+-			<dd><input class="button2" type="submit" id="action_send_test_message" name="action_send_test_message" value="{{ lang('DN_SEND_TEST') }}" /></dd>
+-		</dl>
+-		{% else %}
+-		<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
+-		{% endif %}
+-	</fieldset>
+-
+-	<fieldset class="submit-buttons">
+-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+-		{{ S_FORM_TOKEN }}
+-	</fieldset>
+-
+-</form>
+-
+-{% include 'overall_footer.html' %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/composer.json"
+index b9f060cfe..31a9c730b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/composer.json"
+@@ -3,7 +3,7 @@
+     "type": "phpbb-extension",
+     "description": "Publishes forum event notifications to a Discord server channel",
+     "homepage": "https://github.com/m-ober/phpbb-discord-notifications",
+-    "version": "3.0.8",
++    "version": "3.0.7",
+     "keywords": [
+         "phpbb",
+         "extension",
+@@ -24,15 +24,15 @@
+         }
+     ],
+     "require": {
+-        "php": ">=7.2",
++        "php": ">=7.1",
+         "ext-curl": "*",
+         "composer/installers": "~1.0.0",
+-        "phpbb/phpbb": ">=3.3.11"
++        "phpbb/phpbb": ">=3.3.0"
+     },
+     "extra": {
+         "display-name": "Discord Notifications",
+         "soft-require": {
+-            "phpbb/phpbb": ">=3.3.11"
++            "phpbb/phpbb": ">=3.3.0"
+         },
+         "version-check": {
+             "host": "www.phpbb.com",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/diff_full.tmp"
+new file mode 100644
+index 000000000..137227b18
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/diff_full.tmp"
+@@ -0,0 +1,733 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
++index 0283d968d..27cf0e844 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
++@@ -2,8 +2,8 @@
++ /**
++  * Discord Notifications extension for the phpBB Forum Software package.
++  *
++- * @copyright (c)	2018, Tyler Olsen, https://github.com/rootslinux
++- * @license			GNU General Public License, version 2 (GPL-2.0)
+++ * @copyright (c) 2018, Tyler Olsen, https://github.com/rootslinux
+++ * @license GNU General Public License, version 2 (GPL-2.0)
++  */
++ 
++ namespace mober\discordnotifications\acp;
++@@ -15,26 +15,16 @@ class discord_notifications_info
++ {
++ 	public function module()
++ 	{
++-		return [
+++		return array(
++ 			'filename'	=> '\mober\discordnotifications\acp\discord_notifications_module',
++ 			'title'		=> 'ACP_DISCORD_NOTIFICATIONS',
++-			'modes'		=> [
++-				'settings'	=> [
++-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_SETTINGS',
+++			'modes'		=> array(
+++				'settings'	=> array(
+++					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_TITLE',
++ 					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
++-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
++-				],
++-				'webhooks'	=> [
++-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS',
++-					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
++-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
++-				],
++-				'mapping'	=> [
++-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_MAPPING',
++-					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
++-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
++-				],
++-			],
++-		];
+++					'cat'	=> array('ACP_DISCORD_NOTIFICATIONS')
+++				),
+++			),
+++		);
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
++index bd7741639..fb82cbbad 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
++@@ -18,8 +18,9 @@ class discord_notifications_module
++ 	const MIN_POST_PREVIEW_LENGTH = 10;
++ 
++ 	// The maximum number of characters that the user can set for the post preview setting.
++-	// See: https://discord.com/developers/docs/resources/channel#embed-object-embed-limits
++-	const MAX_POST_PREVIEW_LENGTH = 1024;
+++	// Note that this is slightly less than the actual allowed maximum by Discord (2048), but we reserve
+++	// some space to prepend the preview text with something like "Preview: " or "Reason: "
+++	const MAX_POST_PREVIEW_LENGTH = 2000;
++ 
++ 	// The name for the form used for this page
++ 	const PAGE_FORM_NAME = 'acp_mober_discord_notifications';
++@@ -48,6 +49,9 @@ class discord_notifications_module
++ 	/** @var \phpbb\log\log */
++ 	protected $log;
++ 
+++	/** @var \mober\discordnotifications\notification_service */
+++	protected $notification_service;
+++
++ 	/** @var \phpbb\request\request */
++ 	protected $request;
++ 
++@@ -57,13 +61,9 @@ class discord_notifications_module
++ 	/** @var \phpbb\user */
++ 	protected $user;
++ 
++-	/** @var bool */
++-	private  $curl_available;
++-
++ 	public function main($id, $mode)
++ 	{
++ 		global $phpbb_container;
++-
++ 		$this->cache = $phpbb_container->get('cache.driver');
++ 		$this->config = $phpbb_container->get('config');
++ 		$this->db = $phpbb_container->get('dbal.conn');
++@@ -72,88 +72,63 @@ class discord_notifications_module
++ 		$this->request = $phpbb_container->get('request');
++ 		$this->template = $phpbb_container->get('template');
++ 		$this->user = $phpbb_container->get('user');
++-		$this->curl_available = extension_loaded('curl');
+++		// Used for sending test messages to Discord
+++		$this->notification_service = $phpbb_container->get('mober.discordnotifications.notification_service');
++ 
++ 		$this->language->add_lang('acp_discord_notifications', 'mober/discordnotifications');
++-		$this->page_title = $this->language->lang('ACP_DISCORD_NOTIFICATIONS');
+++		$this->tpl_name = 'acp_discord_notifications';
+++		$this->page_title = $this->language->lang('ACP_DISCORD_NOTIFICATIONS_TITLE');
++ 
++ 		add_form_key(self::PAGE_FORM_NAME);
++ 
++-		switch ($mode)
+++		// Process submit actions
+++		if ($this->request->is_set_post('action_send_test_message'))
++ 		{
++-			case 'webhooks':
++-				$this->tpl_name = 'acp_discord_notifications_webhooks';
++-
++-				if ($this->request->is_set_post('action_send_test_message'))
++-				{
++-					$this->process_send_test_message();
++-				}
++-				else if ($this->request->is_set_post('action_delete_alias'))
++-				{
++-					$this->process_delete_alias();
++-				}
++-				else if ($this->request->is_set_post('submit'))
++-				{
++-					$this->process_webhooks_form_submit();
++-				}
++-
++-				$this->generate_webhook_section();
++-				break;
++-
++-			case 'mapping':
++-				$this->tpl_name = 'acp_discord_notifications_mapping';
++-
++-				if ($this->request->is_set_post('submit'))
++-				{
++-					$this->process_mapping_form_submit();
++-				}
++-
++-				$this->generate_webhook_section();
++-				$this->generate_forum_section();
++-				break;
+++			$this->process_send_test_message();
+++		}
+++		else if ($this->request->is_set_post('action_delete_alias'))
+++		{
+++			$this->process_delete_alias();
+++		}
+++		else if ($this->request->is_set_post('submit'))
+++		{
+++			$this->process_form_submit();
+++		}
++ 
++-			case 'settings':
++-			default:
++-				$this->tpl_name = 'acp_discord_notifications_settings';
+++		// Generate the dynamic HTML content for enabling/disabling forum notifications
+++		$this->generate_forum_section();
++ 
++-				if ($this->request->is_set_post('submit'))
++-				{
++-					$this->process_settings_form_submit();
++-				}
++-				break;
++-		}
+++		$this->generate_webhook_section();
++ 
++ 		// Assign template values so that the page reflects the state of the extension settings
++-		$this->template->assign_vars([
++-			'DN_MASTER_ENABLE'				=> $this->config['discord_notifications_enabled'],
++-			'DN_POST_PREVIEW_LENGTH'		=> $this->config['discord_notifications_post_preview_length'],
++-			'DN_POST_PREVIEW_DESCRIPTION'	=> sprintf($this->language->lang('DN_POST_PREVIEW_DESCRIPTION'), self::MIN_POST_PREVIEW_LENGTH, self::MAX_POST_PREVIEW_LENGTH),
++-			'DN_TEST_MESSAGE_TEXT'			=> $this->language->lang('DN_TEST_MESSAGE_TEXT'),
++-			'DN_CONNECT_TIMEOUT'			=> $this->config['discord_notifications_connect_timeout'],
++-			'DN_EXEC_TIMEOUT'				=> $this->config['discord_notifications_exec_timeout'],
++-
++-			'DN_POST_CREATE'				=> $this->config['discord_notification_type_post_create'],
++-			'DN_POST_UPDATE'				=> $this->config['discord_notification_type_post_update'],
++-			'DN_POST_DELETE'				=> $this->config['discord_notification_type_post_delete'],
++-			'DN_POST_LOCK'					=> $this->config['discord_notification_type_post_lock'],
++-			'DN_POST_UNLOCK'				=> $this->config['discord_notification_type_post_unlock'],
++-			'DN_POST_APPROVE'				=> $this->config['discord_notification_type_post_approve'],
++-
++-			'DN_TOPIC_CREATE'				=> $this->config['discord_notification_type_topic_create'],
++-			'DN_TOPIC_UPDATE'				=> $this->config['discord_notification_type_topic_update'],
++-			'DN_TOPIC_DELETE'				=> $this->config['discord_notification_type_topic_delete'],
++-			'DN_TOPIC_LOCK'					=> $this->config['discord_notification_type_topic_lock'],
++-			'DN_TOPIC_UNLOCK'				=> $this->config['discord_notification_type_topic_unlock'],
++-			'DN_TOPIC_APPROVE'				=> $this->config['discord_notification_type_topic_approve'],
++-
++-			'DN_USER_CREATE'				=> $this->config['discord_notification_type_user_create'],
++-			'DN_USER_DELETE'				=> $this->config['discord_notification_type_user_delete'],
++-
++-			'DN_DEFAULT_WEBHOOK'			=> $this->config['discord_notification_default_webhook'],
++-
++-			'DN_CURL_AVAILABLE'				=> $this->curl_available,
++-			'U_ACTION'						=> $this->u_action,
++-		]);
+++		$this->template->assign_vars(array(
+++			'DN_MASTER_ENABLE'			=> $this->config['discord_notifications_enabled'],
+++			'DN_POST_PREVIEW_LENGTH'	=> $this->config['discord_notifications_post_preview_length'],
+++			'DN_TEST_MESSAGE_TEXT'		=> $this->language->lang('DN_TEST_MESSAGE_TEXT'),
+++			'DN_CONNECT_TIMEOUT'		=> $this->config['discord_notifications_connect_timeout'],
+++			'DN_EXEC_TIMEOUT'			=> $this->config['discord_notifications_exec_timeout'],
+++
+++			'DN_POST_CREATE'			=> $this->config['discord_notification_type_post_create'],
+++			'DN_POST_UPDATE'			=> $this->config['discord_notification_type_post_update'],
+++			'DN_POST_DELETE'			=> $this->config['discord_notification_type_post_delete'],
+++			'DN_POST_LOCK'				=> $this->config['discord_notification_type_post_lock'],
+++			'DN_POST_UNLOCK'			=> $this->config['discord_notification_type_post_unlock'],
+++			'DN_POST_APPROVE'			=> $this->config['discord_notification_type_post_approve'],
+++
+++			'DN_TOPIC_CREATE'			=> $this->config['discord_notification_type_topic_create'],
+++			'DN_TOPIC_UPDATE'			=> $this->config['discord_notification_type_topic_update'],
+++			'DN_TOPIC_DELETE'			=> $this->config['discord_notification_type_topic_delete'],
+++			'DN_TOPIC_LOCK'				=> $this->config['discord_notification_type_topic_lock'],
+++			'DN_TOPIC_UNLOCK'			=> $this->config['discord_notification_type_topic_unlock'],
+++			'DN_TOPIC_APPROVE'			=> $this->config['discord_notification_type_topic_approve'],
+++
+++			'DN_USER_CREATE'			=> $this->config['discord_notification_type_user_create'],
+++			'DN_USER_DELETE'			=> $this->config['discord_notification_type_user_delete'],
+++
+++			'DN_DEFAULT_WEBHOOK'		=> $this->config['discord_notification_default_webhook'],
+++
+++			'U_ACTION'					=> $this->u_action,
+++		));
++ 	}
++ 
++ 	/**
++@@ -184,12 +159,10 @@ class discord_notifications_module
++ 	 */
++ 	private function process_send_test_message()
++ 	{
++-		global $table_prefix, $phpbb_container;
++-
++-		$this->validate_post_request();
+++		global $table_prefix;
++ 
++ 		$webhook = $this->request->variable('dn_test_webhook', '', true);
++-		$test_message = $this->request->variable('dn_test_message', '', true);
+++		$test_message = $this->request->variable('dn_test_message', '');
++ 
++ 		// Check user inputs before attempting to send the message
++ 		if ($test_message == '')
++@@ -206,8 +179,7 @@ class discord_notifications_module
++ 		$data = $this->db->sql_fetchrow($result);
++ 		$this->db->sql_freeresult($result);
++ 
++-		$notification_service = $phpbb_container->get('mober.discordnotifications.notification_service');
++-		$result = $notification_service->force_send_discord_notification($data['url'], $test_message);
+++		$result = $this->notification_service->force_send_discord_notification($data['url'], $test_message);
++ 		if ($result)
++ 		{
++ 			trigger_error($this->language->lang('DN_TEST_SUCCESS') . adm_back_link($this->u_action));
++@@ -222,7 +194,10 @@ class discord_notifications_module
++ 	{
++ 		global $table_prefix;
++ 
++-		$this->validate_post_request();
+++		if (!check_form_key(self::PAGE_FORM_NAME))
+++		{
+++			trigger_error('FORM_INVALID', E_USER_WARNING);
+++		}
++ 
++ 		$delete_alias = $this->request->variable('action_delete_alias',  ['' => ''], true);
++ 		foreach ($delete_alias as $alias => $url)
++@@ -236,9 +211,17 @@ class discord_notifications_module
++ 		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
++ 	}
++ 
++-	private function process_settings_form_submit()
+++	/**
+++	 * Handles all error checking and database changes when the user hits the submit button on the ACP page.
+++	 */
+++	private function process_form_submit()
++ 	{
++-		$this->validate_post_request();
+++		global $table_prefix;
+++
+++		if (!check_form_key(self::PAGE_FORM_NAME))
+++		{
+++			trigger_error('FORM_INVALID', E_USER_WARNING);
+++		}
++ 
++ 		// Get form values for the main settings
++ 		$master_enable = $this->request->variable('dn_master_enable', 0);
++@@ -247,50 +230,14 @@ class discord_notifications_module
++ 		// Verify that the post preview length is a numeric string, convert to an int and check the valid range
++ 		if (!is_numeric($preview_length))
++ 		{
++-			trigger_error(
++-				sprintf(
++-					$this->language->lang('DN_POST_PREVIEW_INVALID'),
++-					self::MIN_POST_PREVIEW_LENGTH,
++-					self::MAX_POST_PREVIEW_LENGTH
++-				) . adm_back_link($this->u_action),
++-				E_USER_WARNING
++-			);
+++			trigger_error($this->language->lang('DN_POST_PREVIEW_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
++ 		}
++ 		$preview_length = (int) $preview_length;
++ 		if ($preview_length != 0 && ($preview_length < self::MIN_POST_PREVIEW_LENGTH || $preview_length > self::MAX_POST_PREVIEW_LENGTH))
++ 		{
++-			trigger_error(
++-				sprintf(
++-					$this->language->lang('DN_POST_PREVIEW_INVALID'),
++-					self::MIN_POST_PREVIEW_LENGTH,
++-					self::MAX_POST_PREVIEW_LENGTH
++-				) . adm_back_link($this->u_action),
++-				E_USER_WARNING
++-			);
+++			trigger_error($this->language->lang('DN_POST_PREVIEW_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
++ 		}
++ 
++-		$connect_timeout = max(1, (int) $this->request->variable('dn_connect_to', 0));
++-		$exec_timeout = max(1, (int) $this->request->variable('dn_exec_to', 0));
++-
++-		$this->config->set('discord_notifications_enabled', $master_enable);
++-		$this->config->set('discord_notifications_post_preview_length', $preview_length);
++-		$this->config->set('discord_notifications_connect_timeout', $connect_timeout);
++-		$this->config->set('discord_notifications_exec_timeout', $exec_timeout);
++-
++-		// Log the settings change
++-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE');
++-		// Destroy any cached discord notification data
++-		$this->cache->destroy('mober_discord_notifications');
++-
++-		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
++-	}
++-
++-	private function process_webhooks_form_submit()
++-	{
++-		global $table_prefix;
++-
++-		$this->validate_post_request();
++-
++ 		// Create new entry
++ 		$new_alias = $this->request->variable('dn_webhook_new_alias', '', true);
++ 		$new_url = $this->request->variable('dn_webhook_new_url', '');
++@@ -320,27 +267,36 @@ class discord_notifications_module
++ 			$this->db->sql_query($sql);
++ 		}
++ 
++-		// Log the settings change
++-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE');
++-		// Destroy any cached discord notification data
++-		$this->cache->destroy('mober_discord_notifications');
++-
++-		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
++-	}
++-
++-	private function process_mapping_form_submit()
++-	{
++-		$this->validate_post_request();
++-
++ 		// Update configuration per forum
++ 		$forum_configuration = $this->request->variable('dn_forum', [0 => ''], true);
++ 		foreach ($forum_configuration as $id => $value)
++ 		{
++-			$sql = "UPDATE " . FORUMS_TABLE . " SET discord_notifications = '" . $this->db->sql_escape($value) .
++-				"' WHERE forum_id = " . (int) $id;
++-			$this->db->sql_query($sql);
+++			// Don't update deleted entries
+++			if ($value === '' || $webhook_configuration[$value] !== '')
+++			{
+++				$sql = "UPDATE " . FORUMS_TABLE . " SET discord_notifications = '" . $this->db->sql_escape($value) .
+++					"' WHERE forum_id = " . (int) $id;
+++				$this->db->sql_query($sql);
+++			}
+++		}
+++
+++		$connect_timeout = (int) $this->request->variable('dn_connect_to', 0);
+++		if ($connect_timeout < 1)
+++		{
+++			$connect_timeout = 1;
++ 		}
++ 
+++		$exec_timeout = (int) $this->request->variable('dn_exec_to', 0);
+++		if ($exec_timeout < 1)
+++		{
+++			$exec_timeout = 1;
+++		}
+++
+++		$this->config->set('discord_notifications_enabled', $master_enable);
+++		$this->config->set('discord_notifications_post_preview_length', $preview_length);
+++		$this->config->set('discord_notifications_connect_timeout', $connect_timeout);
+++		$this->config->set('discord_notifications_exec_timeout', $exec_timeout);
+++
++ 		$this->config->set('discord_notification_type_post_create', $this->request->variable('dn_post_create', 0));
++ 		$this->config->set('discord_notification_type_post_update', $this->request->variable('dn_post_update', 0));
++ 		$this->config->set('discord_notification_type_post_delete', $this->request->variable('dn_post_delete', 0));
++@@ -377,10 +333,10 @@ class discord_notifications_module
++ 
++ 		while ($row = $this->db->sql_fetchrow($result))
++ 		{
++-			$tpl_row = [
+++			$tpl_row = array(
++ 				'ALIAS'	=> $row['alias'],
++ 				'URL'	=> $row['url'],
++-			];
+++			);
++ 			$this->template->assign_block_vars('webhookrow', $tpl_row);
++ 		}
++ 		$this->db->sql_freeresult($result);
++@@ -400,7 +356,7 @@ class discord_notifications_module
++ 
++ 		$sql = "SELECT forum_id, forum_type, forum_name, left_id, right_id, parent_id, forum_parents, discord_notifications
++ 			FROM " . FORUMS_TABLE . "
++-			ORDER BY left_id";
+++			ORDER BY left_id ASC";
++ 		$result = $this->db->sql_query($sql);
++ 
++ 		while ($row = $this->db->sql_fetchrow($result))
++@@ -408,23 +364,23 @@ class discord_notifications_module
++ 			// Category forums are displayed for organizational purposes, but have no configuration
++ 			if ($row['forum_type'] == FORUM_CAT)
++ 			{
++-				$tpl_row = [
+++				$tpl_row = array(
++ 					'S_IS_CAT'		=> true,
++ 					'FORUM_NAME'	=> $row['forum_name'],
++-					'PARENTS'		=> '',
++-				];
+++					'PARENTS'	=> '',
+++				);
++ 				$this->template->assign_block_vars('forumrow', $tpl_row);
++ 			}
++ 			else if ($row['forum_type'] == FORUM_POST)
++ 			{
++ 				// The labels for all the inputs are constructed based on the forum IDs to make it easy to know which
++-				$tpl_row = [
++-					'S_IS_CAT'		=> false,
++-					'FORUM_NAME'	=> $row['forum_name'],
++-					'FORUM_ID'		=> $row['forum_id'],
++-					'ALIAS'			=> $row['discord_notifications'],
++-					'PARENTS'		=> '',
++-				];
+++				$tpl_row = array(
+++							'S_IS_CAT'		=> false,
+++							'FORUM_NAME'	=> $row['forum_name'],
+++							'FORUM_ID'		=> $row['forum_id'],
+++							'ALIAS'			=> $row['discord_notifications'],
+++							'PARENTS'		=> '',
+++						);
++ 				$parents = get_forum_parents($row);
++ 				if (is_array($parents))
++ 				{
++@@ -439,12 +395,4 @@ class discord_notifications_module
++ 		}
++ 		$this->db->sql_freeresult($result);
++ 	}
++-
++-	private function validate_post_request()
++-	{
++-		if (!check_form_key(self::PAGE_FORM_NAME))
++-		{
++-			trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
++-		}
++-	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
++similarity index 63%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
++index e059a8f75..27ee7d868 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
++@@ -1,40 +1,100 @@
++-{% include 'overall_header.html' %}
+++<!-- INCLUDE overall_header.html -->
++ 
++ <h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
++ 
++-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
++-
++-{% if not DN_CURL_AVAILABLE %}
++-	<div class="errorbox">
++-		<p>{{ lang('DN_MISSING_CURL') }}</p>
++-	</div>
++-{% endif %}
+++<p>{{ DN_ACP_DESCRIPTION }}</p>
++ 
++ <form id="acp_board" method="post" action="{{ U_ACTION }}">
++ 
++ 	<fieldset>
++-		<legend>{{ lang('DN_WEBHOOK_DEFAULT') }}</legend>
+++		<legend>{{ lang('DN_MAIN_SETTINGS') }}</legend>
++ 		<dl>
++-			<dt><label>{{ lang('DN_USER_CREATE') }}{{ lang('COLON') }}</label></dt>
++-			<dd><label><input type="radio" class="radio" name="dn_user_create" value="1" {% if DN_USER_CREATE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="dn_user_create" value="0" {% if not DN_USER_CREATE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++			<dt><label>{{ lang('DN_MASTER_ENABLE') }}{{ lang('COLON') }}</label></dt>
+++			<dd><label><input type="radio" class="radio" name="dn_master_enable" value="1" {% if DN_MASTER_ENABLE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="dn_master_enable" value="0" {% if not DN_MASTER_ENABLE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label>{{ lang('DN_USER_DELETE') }}{{ lang('COLON') }}</label></dt>
++-			<dd><label><input type="radio" class="radio" name="dn_user_delete" value="1" {% if DN_USER_DELETE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="dn_user_delete" value="0" {% if not DN_USER_DELETE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++			<dt><label for="dn_post_preview_length">{{ lang('DN_POST_PREVIEW_LENGTH') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_POST_PREVIEW_DESCRIPTION') }}</span></dt>
+++			<dd>
+++				<input id="dn_post_preview_length" name="dn_post_preview_length" type="text" value="{{ DN_POST_PREVIEW_LENGTH }}" size="4" maxlength="4" />
+++			</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="dn_webhook_default">{{ lang('DN_WEBHOOK_DEFAULT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_DEFAULT_DESCRIPTION') }}</span></dt>
+++			<dt><label for="dn_connect_to">{{ lang('DN_CONNECT_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_CONNECT_TO_DESCRIPTION') }}</span></dt>
++ 			<dd>
++-				<select id="dn_webhook_default" name="dn_webhook_default">
++-					<option value="">({{ lang('DISABLED') }})</option>
+++				<input id="dn_connect_to" name="dn_connect_to" type="text" value="{{ DN_CONNECT_TIMEOUT }}" size="4" maxlength="4" />
+++			</dd>
+++		</dl>
+++		<dl>
+++			<dt><label for="dn_exec_to">{{ lang('DN_EXEC_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_EXEC_TO_DESCRIPTION') }}</span></dt>
+++			<dd>
+++				<input id="dn_exec_to" name="dn_exec_to" type="text" value="{{ DN_EXEC_TIMEOUT }}" size="4" maxlength="4" />
+++			</dd>
+++		</dl>
+++	</fieldset>
+++
+++	<fieldset>
+++		<legend>{{ lang('DN_WEBHOOK_SETTINGS') }}</legend>
+++		<p>{{ lang('DN_WEBHOOK_SETTINGS_DESCRIPTION') }}</p>
+++		{% if loops.webhookrow %}
+++			{% for webhook in loops.webhookrow %}
+++				<dl>
+++					<dt><label for="dn_webhook_{{ webhook.ALIAS }}">{{ webhook.ALIAS }}</label></dt>
+++					<dd>
+++						<input type="text" size="100" maxlength="255" id="dn_webhook_{{ webhook.ALIAS }}" name="dn_webhook[{{ webhook.ALIAS }}]" value="{{ webhook.URL }}" />
+++						<input type="submit" name="action_delete_alias[{{ webhook.ALIAS }}]" value="{{ lang('DELETE') }}" class="button2" onclick="return confirm('{{ lang('CONFIRM_OPERATION') }}');">
+++					</dd>
+++				</dl>
+++			{% endfor %}
+++		{% else %}
+++			<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
+++		{% endif %}
+++	</fieldset>
+++
+++	<fieldset>
+++		<legend>{{ lang('DN_WEBHOOK_NEW') }}</legend>
+++		<p>{{ lang('DN_WEBHOOK_NEW_DESCRIPTION') }}</p>
+++		<dl>
+++			<dt><label for="dn_webhook_new_alias">{{ lang('DN_WEBHOOK_NEW_ALIAS') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_ALIAS_DESCRIPTION') }}</span></dt>
+++			<dd>
+++				<input id="dn_webhook_new_alias" name="dn_webhook_new_alias" type="text" value="" size="100" maxlength="255" />
+++			</dd>
+++		</dl>
+++		<dl>
+++			<dt><label for="dn_webhook_new_url">{{ lang('DN_WEBHOOK_NEW_URL') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_URL_DESCRIPTION') }}</span></dt>
+++			<dd>
+++				<input id="dn_webhook_new_url" name="dn_webhook_new_url" type="text" value="" size="100" maxlength="255" />
+++			</dd>
+++		</dl>
+++	</fieldset>
+++
+++	<fieldset>
+++		<legend>{{ lang('DN_TEST_SETTINGS') }}</legend>
+++		<dl>
+++			<dt><label for="dn_test_message">{{ lang('DN_TEST_MESSAGE') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_TEST_DESCRIPTION') }}</span></dt>
+++			<dd>
+++				<input id="dn_test_message" name="dn_test_message" type="text" value="{{ DN_TEST_MESSAGE_TEXT }}" size="100" maxlength="255" />
+++			</dd>
+++		</dl>
+++		{% if loops.webhookrow %}
+++		<dl>
+++			<dt><label for="dn_test_webhook">{{ lang('DN_WEBHOOK_SELECT') }}{{ lang('COLON') }}</label><br /></dt>
+++			<dd>
+++				<select id="dn_test_webhook" name="dn_test_webhook">
+++					<option value="">{{ lang('DN_WEBHOOK_SELECT') }}</option>
++ 					{% for webhook in loops.webhookrow %}
++-						<option value="{{ webhook.ALIAS }}"{% if DN_DEFAULT_WEBHOOK == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
+++					<option value="{{ webhook.ALIAS }}"{% if forumrow.ALIAS == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
++ 					{% endfor %}
++ 				</select>
++ 			</dd>
++ 		</dl>
+++		<dl>
+++			<dt><label for="action_send_test_message">{{ lang('DN_SEND_TEST') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_SEND_TEST_DESCRIPTION') }}</span></dt>
+++			<dd><input class="button2" type="submit" id="action_send_test_message" name="action_send_test_message" value="{{ lang('DN_SEND_TEST') }}" /></dd>
+++		</dl>
+++		{% else %}
+++		<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
+++		{% endif %}
++ 	</fieldset>
++ 
++ 	<fieldset>
++@@ -100,6 +160,27 @@
++ 			<dd><label><input type="radio" class="radio" name="dn_topic_approve" value="1" {% if DN_TOPIC_APPROVE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++ 				<label><input type="radio" class="radio" name="dn_topic_approve" value="0" {% if not DN_TOPIC_APPROVE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 		</dl>
+++		<dl>
+++			<dt><label>{{ lang('DN_USER_CREATE') }}{{ lang('COLON') }}</label></dt>
+++			<dd><label><input type="radio" class="radio" name="dn_user_create" value="1" {% if DN_USER_CREATE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="dn_user_create" value="0" {% if not DN_USER_CREATE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++		</dl>
+++		<dl>
+++			<dt><label>{{ lang('DN_USER_DELETE') }}{{ lang('COLON') }}</label></dt>
+++			<dd><label><input type="radio" class="radio" name="dn_user_delete" value="1" {% if DN_USER_DELETE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="dn_user_delete" value="0" {% if not DN_USER_DELETE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++		</dl>
+++		<dl>
+++			<dt><label for="dn_webhook_default">{{ lang('DN_WEBHOOK_DEFAULT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_DEFAULT_DESCRIPTION') }}</span></dt>
+++			<dd>
+++				<select id="dn_webhook_default" name="dn_webhook_default">
+++					<option value="">({{ lang('DISABLED') }})</option>
+++					{% for webhook in loops.webhookrow %}
+++					<option value="{{ webhook.ALIAS }}"{% if DN_DEFAULT_WEBHOOK == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
+++					{% endfor %}
+++				</select>
+++			</dd>
+++		</dl>
++ 	</fieldset>
++ 
++ 	<fieldset>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html"
++deleted file mode 100644
++index 90eed3ee7..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html"
+++++ /dev/null
++@@ -1,49 +0,0 @@
++-{% include 'overall_header.html' %}
++-
++-<h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
++-
++-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
++-
++-{% if not DN_CURL_AVAILABLE %}
++-	<div class="errorbox">
++-		<p>{{ lang('DN_MISSING_CURL') }}</p>
++-	</div>
++-{% endif %}
++-
++-<form id="acp_board" method="post" action="{{ U_ACTION }}">
++-
++-	<fieldset>
++-		<legend>{{ lang('DN_MAIN_SETTINGS') }}</legend>
++-		<dl>
++-			<dt><label>{{ lang('DN_MASTER_ENABLE') }}{{ lang('COLON') }}</label></dt>
++-			<dd><label><input type="radio" class="radio" name="dn_master_enable" value="1" {% if DN_MASTER_ENABLE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="dn_master_enable" value="0" {% if not DN_MASTER_ENABLE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++-		</dl>
++-		<dl>
++-			<dt><label for="dn_post_preview_length">{{ lang('DN_POST_PREVIEW_LENGTH') }}{{ lang('COLON') }}</label><br /><span>{{ DN_POST_PREVIEW_DESCRIPTION }}</span></dt>
++-			<dd>
++-				<input id="dn_post_preview_length" name="dn_post_preview_length" type="text" value="{{ DN_POST_PREVIEW_LENGTH }}" size="4" maxlength="4" />
++-			</dd>
++-		</dl>
++-		<dl>
++-			<dt><label for="dn_connect_to">{{ lang('DN_CONNECT_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_CONNECT_TO_DESCRIPTION') }}</span></dt>
++-			<dd>
++-				<input id="dn_connect_to" name="dn_connect_to" type="text" value="{{ DN_CONNECT_TIMEOUT }}" size="4" maxlength="4" />
++-			</dd>
++-		</dl>
++-		<dl>
++-			<dt><label for="dn_exec_to">{{ lang('DN_EXEC_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_EXEC_TO_DESCRIPTION') }}</span></dt>
++-			<dd>
++-				<input id="dn_exec_to" name="dn_exec_to" type="text" value="{{ DN_EXEC_TIMEOUT }}" size="4" maxlength="4" />
++-			</dd>
++-		</dl>
++-	</fieldset>
++-
++-	<fieldset class="submit-buttons">
++-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++-		{{ S_FORM_TOKEN }}
++-	</fieldset>
++-
++-</form>
++-
++-{% include 'overall_footer.html' %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html"
++deleted file mode 100644
++index a500594a6..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html"
+++++ /dev/null
++@@ -1,86 +0,0 @@
++-{% include 'overall_header.html' %}
++-
++-<h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
++-
++-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
++-
++-{% if not DN_CURL_AVAILABLE %}
++-	<div class="errorbox">
++-		<p>{{ lang('DN_MISSING_CURL') }}</p>
++-	</div>
++-{% endif %}
++-
++-<form id="acp_board" method="post" action="{{ U_ACTION }}">
++-
++-	<fieldset>
++-		<legend>{{ lang('DN_WEBHOOK_SETTINGS') }}</legend>
++-		<p>{{ lang('DN_WEBHOOK_SETTINGS_DESCRIPTION') }}</p>
++-		{% if loops.webhookrow %}
++-			{% for webhook in loops.webhookrow %}
++-				<dl>
++-					<dt><label for="dn_webhook_{{ webhook.ALIAS }}">{{ webhook.ALIAS }}</label></dt>
++-					<dd>
++-						<input type="text" size="100" maxlength="255" id="dn_webhook_{{ webhook.ALIAS }}" name="dn_webhook[{{ webhook.ALIAS }}]" value="{{ webhook.URL }}" />
++-						<input type="submit" name="action_delete_alias[{{ webhook.ALIAS }}]" value="{{ lang('DELETE') }}" class="button2" onclick="return confirm('{{ lang('CONFIRM_OPERATION') }}');">
++-					</dd>
++-				</dl>
++-			{% endfor %}
++-		{% else %}
++-			<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
++-		{% endif %}
++-	</fieldset>
++-
++-	<fieldset>
++-		<legend>{{ lang('DN_WEBHOOK_NEW') }}</legend>
++-		<p>{{ lang('DN_WEBHOOK_NEW_DESCRIPTION') }}</p>
++-		<dl>
++-			<dt><label for="dn_webhook_new_alias">{{ lang('DN_WEBHOOK_NEW_ALIAS') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_ALIAS_DESCRIPTION') }}</span></dt>
++-			<dd>
++-				<input id="dn_webhook_new_alias" name="dn_webhook_new_alias" type="text" value="" size="100" maxlength="255" />
++-			</dd>
++-		</dl>
++-		<dl>
++-			<dt><label for="dn_webhook_new_url">{{ lang('DN_WEBHOOK_NEW_URL') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_URL_DESCRIPTION') }}</span></dt>
++-			<dd>
++-				<input id="dn_webhook_new_url" name="dn_webhook_new_url" type="text" value="" size="100" maxlength="255" />
++-			</dd>
++-		</dl>
++-	</fieldset>
++-
++-	<fieldset>
++-		<legend>{{ lang('DN_TEST_SETTINGS') }}</legend>
++-		{% if loops.webhookrow %}
++-		<dl>
++-			<dt><label for="dn_test_message">{{ lang('DN_TEST_MESSAGE') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_TEST_DESCRIPTION') }}</span></dt>
++-			<dd>
++-				<input id="dn_test_message" name="dn_test_message" type="text" value="{{ DN_TEST_MESSAGE_TEXT }}" size="100" maxlength="255" />
++-			</dd>
++-		</dl>
++-		<dl>
++-			<dt><label for="dn_test_webhook">{{ lang('DN_WEBHOOK_SELE
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/event/notification_event_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/event/notification_event_listener.php"
+index af5e9d60b..c9275956b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/event/notification_event_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/event/notification_event_listener.php"
+@@ -79,7 +79,7 @@ class notification_event_listener implements EventSubscriberInterface
+ 	 */
+ 	static public function getSubscribedEvents()
+ 	{
+-		return [
++		return array(
+ 			// This event is used for performing actions directly after a post or topic has been submitted.
+ 			'core.submit_post_end'				=> 'handle_post_submit_action',
+ 			// This event is used for performing actions directly after a post or topic has been deleted.
+@@ -100,7 +100,7 @@ class notification_event_listener implements EventSubscriberInterface
+ 			'core.approve_topics_after'			=> 'handle_topic_approval_action',
+ 			// Post approval
+ 			'core.approve_posts_after'			=> 'handle_post_approval_action',
+-		];
++		);
+ 	}
+ 
+ 	// ----------------------------------------------------------------------------
+@@ -179,7 +179,7 @@ class notification_event_listener implements EventSubscriberInterface
+ 		}
+ 
+ 		// Build an array of the event data that we may need to pass along to the function that will construct the notification message
+-		$post_data = [
++		$post_data = array(
+ 			'user_id'			=> $event['data']['poster_id'],
+ 			'user_name'			=> $event['username'],
+ 			'forum_id'			=> $event['data']['forum_id'],
+@@ -192,7 +192,7 @@ class notification_event_listener implements EventSubscriberInterface
+ 			'edit_user_name'	=> $this->language->lang('UNKNOWN_USER'),
+ 			'edit_reason'		=> $event['data']['post_edit_reason'],
+ 			'content'			=> $event['data']['message'],
+-		];
++		);
+ 
+ 		if ($post_data['edit_user_id'] == $post_data['user_id'])
+ 		{
+@@ -254,7 +254,7 @@ class notification_event_listener implements EventSubscriberInterface
+ 
+ 		// Build an array of the event data that we may need to pass along to the function that will construct the notification message.
+ 		// Note that unfortunately, the event data does not give us any information indicating which user deleted the post.
+-		$post_data = [
++		$post_data = array(
+ 			'user_id'		=> $event['data']['poster_id'],
+ 			'user_name'		=> $this->language->lang('UNKNOWN_USER'),
+ 			'forum_id'		=> $event['forum_id'],
+@@ -263,7 +263,7 @@ class notification_event_listener implements EventSubscriberInterface
+ 			'topic_title'	=> $this->language->lang('UNKNOWN_TOPIC'),
+ 			'post_id'		=> $event['post_id'],
+ 			'delete_reason'	=> $event['softdelete_reason'],
+-		];
++		);
+ 
+ 		// Fetch the forum name, topic title, and user name using the respective IDs.
+ 		$forum_name = $this->notification_service->query_forum_name($post_data['forum_id']);
+@@ -319,14 +319,13 @@ class notification_event_listener implements EventSubscriberInterface
+ 		}
+ 
+ 		// Copy over the data necessary to generate the notification into a new array
+-		$delete_data = [
+-			'forum_id'			=> $query_data['forum_id'],
+-			'forum_name'		=> $query_data['forum_name'],
+-			'topic_title'		=> $query_data['topic_title'],
+-			'topic_post_count'	=> $query_data['topic_posts_approved'],
+-			'user_id'			=> $query_data['topic_poster'],
+-			'user_name'			=> $query_data['topic_first_poster_name'],
+-		];
++		$delete_data = array();
++		$delete_data['forum_id'] = $query_data['forum_id'];
++		$delete_data['forum_name'] = $query_data['forum_name'];
++		$delete_data['topic_title'] = $query_data['topic_title'];
++		$delete_data['topic_post_count'] = $query_data['topic_posts_approved'];
++		$delete_data['user_id'] = $query_data['topic_poster'];
++		$delete_data['user_name'] = $query_data['topic_first_poster_name'];
+ 
+ 		$this->notify_topic_deleted($delete_data, $webhook_url);
+ 	}
+@@ -353,24 +352,22 @@ class notification_event_listener implements EventSubscriberInterface
+ 
+ 		// Get the ID needed to access $event['data'], then extract all relevant data from the event that we need to generate the notification
+ 		$id = array_slice($event['ids'], -1)[0];
+-		$event_data = $event['data'][$id];
+-
+-		$lock_data = [
+-			'forum_id'			=> $event_data['forum_id'],
+-			'forum_name'		=> $event_data['forum_name'],
+-			'topic_id'			=> $event_data['topic_id'],
+-			'topic_title'		=> $event_data['topic_title'],
+-			'topic_user_id'		=> $event_data['topic_poster'],
+-			'topic_user_name'	=> $event_data['topic_first_poster_name'],
+-			// only used for post_[un]lock events, not always set
+-			'post_id'			=> $event_data['post_id'] ?? '',
+-			'post_subject'		=> $event_data['post_subject'] ?? '',
+-			'post_user_id'		=> $event_data['poster_id'] ?? '',
+-			'post_user_name'	=> $event_data['username'] ?? '',
+-		];
++
++		$lock_data = array();
++		$lock_data['forum_id'] = $event['data'][$id]['forum_id'];
++		$lock_data['forum_name'] = $event['data'][$id]['forum_name'];
++		$lock_data['post_id'] = $event['data'][$id]['post_id'] ?? ''; // only used for post_[un]lock events
++		$lock_data['post_subject'] = $event['data'][$id]['post_subject'] ?? ''; // only used for post_[un]lock events
++		$lock_data['topic_id'] = $event['data'][$id]['topic_id'];
++		$lock_data['topic_title'] = $event['data'][$id]['topic_title'];
++		// Two sets of user data captured: one for the post (if applicable) and one for the user that started the topic
++		$lock_data['post_user_id'] = $event['data'][$id]['poster_id'] ?? ''; // only used for post_[un]lock events
++		$lock_data['post_user_name'] = $event['data'][$id]['username'] ?? ''; // only used for post_[un]lock events
++		$lock_data['topic_user_id'] = $event['data'][$id]['topic_poster'];
++		$lock_data['topic_user_name'] = $event['data'][$id]['topic_first_poster_name'];
+ 
+ 		// If the forum the post was made in does not have notifications enabled or the topic/poar is not visible, do nothing more.
+-		$topic_visibile = $event_data['topic_visibility'] == 1;
++		$topic_visibile = $event['data'][$id]['topic_visibility'] == 1;
+ 		$webhook_url = $this->notification_service->get_forum_notification_url($lock_data['forum_id']);
+ 		if (!$webhook_url || !$topic_visibile)
+ 		{
+@@ -432,7 +429,7 @@ class notification_event_listener implements EventSubscriberInterface
+ 	 */
+ 	public function handle_user_activate_action($event)
+ 	{
+-		$user_data = [];
++		$user_data = array();
+ 		if ($event['user_id'])
+ 		{
+ 			$user_data['user_id'] = $event['user_id'];
+@@ -461,7 +458,7 @@ class notification_event_listener implements EventSubscriberInterface
+ 	public function handle_user_delete_action($event)
+ 	{
+ 		// Extract the IDs and names of all deleted users to pass along in an array of (id => name)
+-		$user_data = [];
++		$user_data = array();
+ 		foreach ($event['user_ids'] as $id)
+ 		{
+ 			$user_data[$id] = $event['user_rows'][$id]['username'];
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/ext.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/ext.php"
+deleted file mode 100644
+index 63c8480a0..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/ext.php"
++++ /dev/null
+@@ -1,23 +0,0 @@
+-<?php
+-
+-namespace mober\discordnotifications;
+-
+-class ext extends \phpbb\extension\base
+-{
+-	/**
+-	 * {@inheritDoc}
+-	 */
+-	public function is_enableable()
+-	{
+-		$language = $this->container->get('language');
+-		$language->add_lang('acp_discord_notifications', 'mober/discordnotifications');
+-
+-		$curl_available = extension_loaded('curl');
+-		if (!$curl_available)
+-		{
+-			return $language->lang('DN_MISSING_CURL');
+-		}
+-
+-		return true;
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/de/acp_discord_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/de/acp_discord_notifications.php"
+index 6ed72f018..98030f4d8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/de/acp_discord_notifications.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/de/acp_discord_notifications.php"
+@@ -21,31 +21,32 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, array(
+ 	// ACP Extension Settings Page
+ 	'DN_ACP_DESCRIPTION'			=> 'Diese Einstellungen erlauben es, bei verschiedenen Ereignissen eine Benachrichtigung an einen Discord-Kanal zu schicken.',
+-	'DN_MISSING_CURL'				=> 'Damit diese Erweiterung funktioniert, musst du das <a href="https://www.php.net/manual/de/curl.installation.php">ext-curl Modul für PHP installieren.</a>',
+ 
+ 	'DN_MAIN_SETTINGS'				=> 'Konfiguration',
+ 	'DN_MASTER_ENABLE'				=> 'Discord Benachrichtigungen aktivieren',
++	'DN_WEBHOOK_URL'				=> 'Discord Webhook URL',
++	'DN_WEBHOOK_DESCRIPTION'		=> 'Webhook für einen Discord-Kanal. Weitere Informationen gibt es in <a href="https://support.discordapp.com/hc/en-us/articles/228383668-Intro-to-Webhooks">diesem Artikel</a>.',
+ 	'DN_POST_PREVIEW_LENGTH'		=> 'Länge der Vorschau',
+-	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Wie viele Zeichen eines Beitrags sollen in der Vorschau angezeigt werden? (%1$d-%2$d), 0 deaktiviert die Vorschau)',
++	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Wie viele Zeichen eines Posts sollen in der Vorschau angezeigt werden? (10-2000, 0 deaktiviert die Vorschau)',
+ 	'DN_TEST_MESSAGE'				=> 'Nachricht',
+ 	'DN_TEST_MESSAGE_TEXT'			=> 'Dies ist ein Test: Hallo, Discord!',
+ 	'DN_TEST_DESCRIPTION'			=> 'Nachricht, die beim Starten eines Tests geschickt wird.',
+ 	'DN_SEND_TEST'					=> 'Test starten',
+ 	'DN_SEND_TEST_DESCRIPTION'		=> 'Wenn alles korrekt konfiguriert ist, sollte die Test-Nachricht im entsprechenden Discord-Kanal auftauchen.',
+ 	'DN_CONNECT_TIMEOUT'			=> 'Timeout Verbindungsaufbau',
+-	'DN_CONNECT_TO_DESCRIPTION'		=> 'Zeit in Sekunden, die maximal auf einen Verbindungsaufbau gewartet wird.',
+-	'DN_EXEC_TIMEOUT'				=> 'Timeout Übertragung',
+-	'DN_EXEC_TO_DESCRIPTION'		=> 'Maximale Zeit in Sekunden, die die Datenübertragung dauern darf.',
++	'DN_CONNECT_TO_DESCRIPTION'     => 'Zeit in Sekunden, die maximal auf einen Verbindungsaufbau gewartet wird.',
++	'DN_EXEC_TIMEOUT'               => 'Timeout Übertragung',
++	'DN_EXEC_TO_DESCRIPTION'        => 'Maximale Zeit in Sekunden, die die Datenübertragung dauern darf.',
+ 	'DN_TEST_SETTINGS'				=> 'Test',
+ 
+ 	'DN_WEBHOOK_SETTINGS'			=> 'Einträge Bearbeiten',
+ 	'DN_WEBHOOK_SETTINGS_DESCRIPTION' => 'Hier können bestehende Einträge bearbeitet oder gelöscht werden.',
+ 	'DN_WEBHOOK_NEW'				=> 'Neuen Eintrag anlegen',
+-	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Hier kann ein neuer Eintrag angelegt werden. Die URL muss vollständig sein und mit "http" oder "https" beginnen.',
++	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Hier kann ein neuer Eintrag angelegt werden. Um die URL zu erhalten, auf einen Discord-Kanal rechtsklicken, "Kanal bearbeiten" wählen und dann unter "Integrationen" einen neuen Webhook anlegen.',
+ 	'DN_WEBHOOK_NEW_ALIAS'			=> 'Neuer Alias',
+ 	'DN_WEBHOOK_NEW_ALIAS_DESCRIPTION' => 'Frei wählbar, z.B. der Names des Channels, auf den der Webhook zeigt (wie "öffentlich" or "marktplatz").',
+-	'DN_WEBHOOK_NEW_URL'			=> 'Discord Webhook URL',
+-	'DN_WEBHOOK_NEW_URL_DESCRIPTION'=> 'Webhook für einen Discord-Kanal. Weitere Informationen gibt es in <a href="https://support.discord.com/hc/de/articles/228383668-Einleitung-in-Webhooks">diesem Artikel</a>.',
++	'DN_WEBHOOK_NEW_URL'			=> 'Neue URL',
++	'DN_WEBHOOK_NEW_URL_DESCRIPTION' => 'Webhook-URL, muss mit http/https beginnen, z.B. <samp>https://discord.com/api/webhooks/1063...</samp>',
+ 	'DN_WEBHOOK_SELECT'				=> 'Webhook auswählen',
+ 	'DN_WEBHOOK_DEFAULT'			=> 'Forenübergreifende Ereignisse',
+ 	'DN_WEBHOOK_DEFAULT_DESCRIPTION' => 'Webhook für Ereignisse, die nicht zu einem bestimmten Forum gehören (z.B. Benutzer erstellt/gelöscht)',
+@@ -53,18 +54,18 @@ $lang = array_merge($lang, array(
+ 
+ 	'DN_TYPE_SETTINGS'				=> 'Benachrichtigungstypen',
+ 	'DN_TYPE_DESCRIPTION'			=> 'Wähle aus, welche Ereignisse eine Benachrichtigung auslösen sollen.',
+-	'DN_POST_CREATE'				=> 'Beitrag erstellt',
+-	'DN_POST_UPDATE'				=> 'Beitrag aktualisiert',
+-	'DN_POST_DELETE'				=> 'Beitrag gelöscht',
+-	'DN_POST_LOCK'					=> 'Beitrag gesperrt',
+-	'DN_POST_UNLOCK'				=> 'Beitrag entsperrt',
+-	'DN_POST_APPROVE'				=> 'Beitrag freigegeben',
++	'DN_POST_CREATE'				=> 'Post erstellt',
++	'DN_POST_UPDATE'				=> 'Post aktualisiert',
++	'DN_POST_DELETE'				=> 'Post gelöscht',
++	'DN_POST_LOCK'					=> 'Post gesperrt',
++	'DN_POST_UNLOCK'				=> 'Post entsperrt',
++	'DN_POST_APPROVE'				=> 'Post freigeschaltet',
+ 	'DN_TOPIC_CREATE'				=> 'Thema erstellt',
+ 	'DN_TOPIC_UPDATE'				=> 'Thema aktualisiert',
+ 	'DN_TOPIC_DELETE'				=> 'Thema gelöscht',
+ 	'DN_TOPIC_LOCK'					=> 'Thema gesperrt',
+ 	'DN_TOPIC_UNLOCK'				=> 'Thema entsperrt',
+-	'DN_TOPIC_APPROVE'				=> 'Thema freigegeben',
++	'DN_TOPIC_APPROVE'				=> 'Thema freigeschaltet',
+ 	'DN_USER_CREATE'				=> 'Benutzer erstellt',
+ 	'DN_USER_DELETE'				=> 'Benutzer gelöscht',
+ 
+@@ -79,6 +80,7 @@ $lang = array_merge($lang, array(
+ 
+ 	// Success/Failure messages that can be generated once the user saves
+ 	'DN_SETTINGS_SAVED'				=> 'Einstellungen aktualisiert.',
++	'DN_MASTER_WEBHOOK_REQUIRED'	=> 'Benachrichtigungen können nur aktiviert werden, wenn eine gültige Webhook-URL hinterlegt ist.',
+ 	'DN_WEBHOOK_URL_INVALID'		=> 'Die Webhook-URL ist ungültig. Bitte überprüfe die Konfiguration.',
+-	'DN_POST_PREVIEW_INVALID'		=> 'Länge der Vorschau muss zwischen %1$d und %2$d Zeichen sein (oder 0 zum Deaktivieren der Vorschau).',
++	'DN_POST_PREVIEW_INVALID'		=> 'Länge der Vorschau muss zwischen 10 und 2000 Zeichen sein (oder 0 zum Deaktivieren der Vorschau).',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/de/info_acp_discord_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/de/info_acp_discord_notifications.php"
+index 906c6451b..450000295 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/de/info_acp_discord_notifications.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/de/info_acp_discord_notifications.php"
+@@ -19,9 +19,7 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, array(
+ 	// ACP Module
+ 	'ACP_DISCORD_NOTIFICATIONS'					=> 'Discord Benachrichtigungen',
+-	'ACP_DISCORD_NOTIFICATIONS_SETTINGS'		=> 'Einstellungen',
+-	'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS'		=> 'Webhooks',
+-	'ACP_DISCORD_NOTIFICATIONS_MAPPING'			=> 'Zuordnung',
++	'ACP_DISCORD_NOTIFICATIONS_TITLE'			=> 'Discord Konfiguration',
+ 
+ 	// ACP Logs
+ 	'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE'		=> 'Discord Benachrichtigungen: Einstellungen aktualisiert',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/en/acp_discord_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/en/acp_discord_notifications.php"
+index 5adf96d04..22ec10371 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/en/acp_discord_notifications.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/en/acp_discord_notifications.php"
+@@ -21,31 +21,32 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, array(
+ 	// ACP Extension Settings Page
+ 	'DN_ACP_DESCRIPTION'			=> 'These settings allow for various forum events to send notification messages to a Discord server.',
+-	'DN_MISSING_CURL'				=> 'Please install the <a href="https://www.php.net/manual/en/curl.installation.php">ext-curl module for PHP</a>, otherwise this extension will not work.',
+ 
+ 	'DN_MAIN_SETTINGS'				=> 'Main Settings',
+ 	'DN_MASTER_ENABLE'				=> 'Enable Discord Notifications',
++	'DN_WEBHOOK_URL'				=> 'Discord Webhook URL',
++	'DN_WEBHOOK_DESCRIPTION'		=> 'The URL of the webhook generated by the Discord server. See <a href="https://support.discordapp.com/hc/en-us/articles/228383668-Intro-to-Webhooks">this article</a> to learn how to create a new webhook.',
+ 	'DN_POST_PREVIEW_LENGTH'		=> 'Post Preview Length',
+-	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Specify the number of characters to display in a post preview (%1$d-%2$d). A zero value disables post preview.',
++	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Specify the number of characters to display in a post preview (10 - 2000). A zero value disables post preview.',
+ 	'DN_TEST_MESSAGE'				=> 'Message',
+ 	'DN_TEST_MESSAGE_TEXT'			=> 'This is a test: Hello Discord!',
+ 	'DN_TEST_DESCRIPTION'			=> 'A message to send to Discord to verify that the connection with phpBB is functioning.',
+ 	'DN_SEND_TEST'					=> 'Send Test Message',
+ 	'DN_SEND_TEST_DESCRIPTION'		=> 'Sends the contents of the test message to the Discord webhook. Use this to verify that your webhook is properly functioning.',
+ 	'DN_CONNECT_TIMEOUT'			=> 'Connect timeout',
+-	'DN_CONNECT_TO_DESCRIPTION'		=> 'Timeout in seconds to establish a connection to the Webhook endpoint.',
+-	'DN_EXEC_TIMEOUT'				=> 'Transfer timeout',
+-	'DN_EXEC_TO_DESCRIPTION'		=> 'Timeout in seconds for data transfer.',
++	'DN_CONNECT_TO_DESCRIPTION'     => 'Timeout in seconds to establish a connection to the Webhook endpoint.',
++	'DN_EXEC_TIMEOUT'               => 'Transfer timeout',
++	'DN_EXEC_TO_DESCRIPTION'        => 'Timeout in seconds for data transfer.',
+ 	'DN_TEST_SETTINGS'				=> 'Test Settings',
+ 
+ 	'DN_WEBHOOK_SETTINGS'			=> 'Edit entries',
+ 	'DN_WEBHOOK_SETTINGS_DESCRIPTION' => 'Edit or delete existing entries.',
+ 	'DN_WEBHOOK_NEW'				=> 'Create new entry',
+-	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Create a new entry. A full URL is required, starting with "http" or "https".',
++	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Create a new entry. To get the Webhook-URL, right click on a Discord channel, chose "Edit Channel", then go to "Integrations" to create a Webhook.',
+ 	'DN_WEBHOOK_NEW_ALIAS'			=> 'New Alias',
+ 	'DN_WEBHOOK_NEW_ALIAS_DESCRIPTION' => 'Can be freely chosen, for example something that describes the target channel of the webhook (like "public" or "marketplace").',
+-	'DN_WEBHOOK_NEW_URL'			=> 'Discord Webhook URL',
+-	'DN_WEBHOOK_NEW_URL_DESCRIPTION'=> 'The URL of the webhook generated by the Discord server. See <a href="https://support.discordapp.com/hc/en-us/articles/228383668-Intro-to-Webhooks">this article</a> to learn how to create a new webhook.',
++	'DN_WEBHOOK_NEW_URL'			=> 'New URL',
++	'DN_WEBHOOK_NEW_URL_DESCRIPTION' => 'Webhook-URL, must start with http/https, e.g. <samp>https://discord.com/api/webhooks/1063...</samp>',
+ 	'DN_WEBHOOK_SELECT'				=> 'Select Webhook',
+ 	'DN_WEBHOOK_DEFAULT'			=> 'Global Events',
+ 	'DN_WEBHOOK_DEFAULT_DESCRIPTION' => 'Webhook for global events not related to a specific forum, e.g. user creation/deletion',
+@@ -79,6 +80,7 @@ $lang = array_merge($lang, array(
+ 
+ 	// Success/Failure messages that can be generated once the user saves
+ 	'DN_SETTINGS_SAVED'				=> 'Discord Notification settings modified successfully.',
++	'DN_MASTER_WEBHOOK_REQUIRED'	=> 'A valid Discord webhook URL is required to enable notifications.',
+ 	'DN_WEBHOOK_URL_INVALID'		=> 'Discord webhook URL must be a full and valid URL.',
+-	'DN_POST_PREVIEW_INVALID'		=> 'Post preview length must be a number between %1$d and %2$d, or 0 to disable previews.',
++	'DN_POST_PREVIEW_INVALID'		=> 'Post preview length must be a number between 10 and 2000, or 0 to disable previews.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/en/info_acp_discord_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/en/info_acp_discord_notifications.php"
+index e92efb2b9..d7dee76f6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/en/info_acp_discord_notifications.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/en/info_acp_discord_notifications.php"
+@@ -19,9 +19,7 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, array(
+ 	// ACP Module
+ 	'ACP_DISCORD_NOTIFICATIONS'					=> 'Discord Notifications',
+-	'ACP_DISCORD_NOTIFICATIONS_SETTINGS'		=> 'Settings',
+-	'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS'		=> 'Webhooks',
+-	'ACP_DISCORD_NOTIFICATIONS_MAPPING'			=> 'Mapping',
++	'ACP_DISCORD_NOTIFICATIONS_TITLE'			=> 'Discord Notification Settings',
+ 
+ 	// ACP Logs
+ 	'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE'		=> 'Modified Discord notification settings',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/fr/acp_discord_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/fr/acp_discord_notifications.php"
+index 61348d65c..9f6ee59d8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/fr/acp_discord_notifications.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/fr/acp_discord_notifications.php"
+@@ -1,11 +1,11 @@
+ <?php
+ /**
+  *
+- * Discord Notifications extension for the phpBB Forum Software package.
++ * Discord Notifications. An extension for the phpBB Forum Software package.
++ * French translation by Galixte (http://www.galixte.com)
+  *
+- * @copyright (c) 2018, Tyler Olsen, https://github.com/rootslinux
+- * @copyright (c) 2022, French translation by Fred Rimbert https://forums.caforum.fr
+- * @license GNU General Public License, version 2 (GPL-2.0)
++ * @copyright (c) 2018 Tyler Olsen <https://github.com/rootslinux>
++ * @license GNU General Public License, version 2 (GPL-2.0-only)
+  *
+  * This file contains the language strings for the ACP settings page for this extension.
+  */
+@@ -42,35 +42,36 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, array(
+ 	// ACP Extension Settings Page
+ 	'DN_ACP_DESCRIPTION'			=> 'Depuis cette page il est possible de définir les paramètres permettant à différents évènements du forum d’être envoyés comme notification sur un serveur Discord.',
+-	'DN_MISSING_CURL'				=> 'Pour que cette extension fonctionne, tu dois installer le module <a href="https://www.php.net/manual/fr/curl.installation.php">ext-curl pour PHP</a>.',
+ 
+ 	'DN_MAIN_SETTINGS'				=> 'Paramètres généraux',
+ 	'DN_MASTER_ENABLE'				=> 'Activer les notifications Discord',
++	'DN_WEBHOOK_URL'				=> 'URL Webhook de Discord',
++	'DN_WEBHOOK_DESCRIPTION'		=> 'Permet de saisir l’adresse URL Webhook du serveur Discord généré par le serveur Discord. Voir <a href="https://support.discordapp.com/hc/fr/articles/228383668-Intro-to-Webhooks">cet article</a> pour apprendre comment créer un nouveau Webhook.',
+ 	'DN_POST_PREVIEW_LENGTH'		=> 'Longueur de l’aperçu des messages',
+-	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Permet de saisir le nombre de caractères à afficher dans l’aperçu des messages (%1$d-%2$d). Définir sur la valeur 0 pour désactiver l’aperçu des messages.',
++	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Permet de saisir le nombre de caractères à afficher dans l’aperçu des messages (10 - 2000). Définir sur la valeur 0 pour désactiver l’aperçu des messages.',
+ 	'DN_TEST_MESSAGE'				=> 'Message',
+ 	'DN_TEST_MESSAGE_TEXT'			=> 'Texte du message de test : Hello Discord!',
+ 	'DN_TEST_DESCRIPTION'			=> 'Permet d’envoyer un message sur le serveur Discord afin de vérifier que la connexion avec phpBB est fonctionnelle.',
+ 	'DN_SEND_TEST'					=> 'Envoyer un message de test',
+ 	'DN_SEND_TEST_DESCRIPTION'		=> 'Permet d’envoyer le contenu du message de test au Webhook du serveur Discord. À utiliser pour vérifier que le Webhook est fonctionnel.',
+-	'DN_CONNECT_TIMEOUT'			=> 'Délai de connexion',
+-	'DN_CONNECT_TO_DESCRIPTION'		=> 'Délai d‘attente en secondes pour établir une connexion au point de terminaison Webhook.',
+-	'DN_EXEC_TIMEOUT'				=> 'Délai de transfert',
+-	'DN_EXEC_TO_DESCRIPTION'		=> 'Délai d‘attente en secondes pour le transfert de données.',
+-	'DN_TEST_SETTINGS'				=> 'Paramètres d‘essai',
++	'DN_CONNECT_TIMEOUT'			=> 'Connect timeout',
++	'DN_CONNECT_TO_DESCRIPTION'		=> 'Timeout in seconds to establish a connection to the Webhook endpoint.',
++	'DN_EXEC_TIMEOUT'				=> 'Transfer timeout',
++	'DN_EXEC_TO_DESCRIPTION'		=> 'Timeout in seconds for data transfer.',
++	'DN_TEST_SETTINGS'				=> 'Test Settings',
+ 
+-	'DN_WEBHOOK_SETTINGS'			=> 'Modifier les entrées',
+-	'DN_WEBHOOK_SETTINGS_DESCRIPTION' => 'Modifier les entrées existantes. Une entrée est supprimée si le champ URL est vide.',
+-	'DN_WEBHOOK_NEW'				=> 'Créer une nouvelle entrée',
+-	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Créez une nouvelle entrée. Une URL complète est requise, commençant par "http" ou "https".',
+-	'DN_WEBHOOK_NEW_ALIAS'			=> 'Nouvel alias',
++	'DN_WEBHOOK_SETTINGS'			=> 'Edit entries',
++	'DN_WEBHOOK_SETTINGS_DESCRIPTION' => 'Edit or delete existing entries.',
++	'DN_WEBHOOK_NEW'				=> 'Create new entry',
++	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Create a new entry. To get the Webhook-URL, right click on a Discord channel, chose "Edit Channel", then go to "Integrations" to create a Webhook.',
++	'DN_WEBHOOK_NEW_ALIAS'			=> 'New Alias',
+ 	'DN_WEBHOOK_NEW_ALIAS_DESCRIPTION' => 'Can be freely chosen, for example something that describes the target channel of the webhook (like "public" or "marketplace").',
+-	'DN_WEBHOOK_NEW_URL'			=> 'URL Webhook de Discord',
+-	'DN_WEBHOOK_NEW_URL_DESCRIPTION'=> 'Permet de saisir l’adresse URL Webhook du serveur Discord généré par le serveur Discord. Voir <a href="https://support.discordapp.com/hc/fr/articles/228383668-Intro-to-Webhooks">cet article</a> pour apprendre comment créer un nouveau Webhook.',
+-	'DN_WEBHOOK_SELECT'				=> 'Sélectionnez Webhook',
+-	'DN_WEBHOOK_DEFAULT'			=> 'Événements mondiaux',
+-	'DN_WEBHOOK_DEFAULT_DESCRIPTION' => 'Webhook pour les événements mondiaux non liés à un forum spécifique, par ex. création/suppression d‘utilisateur',
+-	'DN_NO_WEBHOOKS'				=> 'Aucune entrée n‘existe.',
++	'DN_WEBHOOK_NEW_URL'			=> 'New URL',
++	'DN_WEBHOOK_NEW_URL_DESCRIPTION' => 'Webhook-URL, must start with http/https, e.g. <samp>https://discord.com/api/webhooks/1063...</samp>',
++	'DN_WEBHOOK_SELECT'				=> 'Select Webhook',
++	'DN_WEBHOOK_DEFAULT'			=> 'Global Events',
++	'DN_WEBHOOK_DEFAULT_DESCRIPTION' => 'Webhook for global events not related to a specific forum, e.g. user creation/deletion',
++	'DN_NO_WEBHOOKS'				=> 'No entries exist.',
+ 
+ 	'DN_TYPE_SETTINGS'				=> 'Types de notification',
+ 	'DN_TYPE_DESCRIPTION'			=> 'Permet de sélectionner quels types de notification devraient être générés sous forme de messages envoyés sur le serveur Discord.',
+@@ -100,6 +101,7 @@ $lang = array_merge($lang, array(
+ 
+ 	// Success/Failure messages that can be generated once the user saves
+ 	'DN_SETTINGS_SAVED'				=> 'Les paramètres de notification Discord ont été modifiés avec succès !',
++	'DN_MASTER_WEBHOOK_REQUIRED'	=> 'Une adresse URL Webhook du serveur Discord est requise pour activer les notifications.',
+ 	'DN_WEBHOOK_URL_INVALID'		=> 'L’adresse URL Webhook du serveur Discord doit être complète et correspondre à une adresse URL valide.',
+-	'DN_POST_PREVIEW_INVALID'		=> 'La longueur de l’aperçu des messages doit être comprise entre %1$d et %2$d ou définie sur 0 pour la désactivation de l’aperçu.',
++	'DN_POST_PREVIEW_INVALID'		=> 'La longueur de l’aperçu des messages doit être comprise entre 10 et 2000 ou définie sur 0 pour la désactivation de l’aperçu.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/fr/discord_notification_messages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/fr/discord_notification_messages.php"
+index 40dc67720..310127b80 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/fr/discord_notification_messages.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/fr/discord_notification_messages.php"
+@@ -1,11 +1,11 @@
+ <?php
+ /**
+  *
+- * Discord Notifications extension for the phpBB Forum Software package.
++ * Discord Notifications. An extension for the phpBB Forum Software package.
++ * French translation by Galixte (http://www.galixte.com)
+  *
+- * @copyright (c) 2018, Tyler Olsen, https://github.com/rootslinux
+- * @copyright (c) 2022, French translation by Fred Rimbert https://forums.caforum.fr
+- * @license GNU General Public License, version 2 (GPL-2.0)
++ * @copyright (c) 2018 Tyler Olsen <https://github.com/rootslinux>
++ * @license GNU General Public License, version 2 (GPL-2.0-only)
+  *
+  * This file contains the language strings for the ACP settings page for this extension.
+  */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/fr/info_acp_discord_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/fr/info_acp_discord_notifications.php"
+index 4dedb574e..df79b8efb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/fr/info_acp_discord_notifications.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/fr/info_acp_discord_notifications.php"
+@@ -1,11 +1,11 @@
+ <?php
+ /**
+  *
+- * Discord Notifications extension for the phpBB Forum Software package.
++ * Discord Notifications. An extension for the phpBB Forum Software package.
++ * French translation by Galixte (http://www.galixte.com)
+  *
+- * @copyright (c) 2018, Tyler Olsen, https://github.com/rootslinux
+- * @copyright (c) 2022, French translation by Fred Rimbert https://forums.caforum.fr
+- * @license GNU General Public License, version 2 (GPL-2.0)
++ * @copyright (c) 2018 Tyler Olsen <https://github.com/rootslinux>
++ * @license GNU General Public License, version 2 (GPL-2.0-only)
+  *
+  * This file contains the language strings for the ACP settings page for this extension.
+  */
+@@ -42,13 +42,11 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, array(
+ 	// ACP Module
+ 	'ACP_DISCORD_NOTIFICATIONS'					=> 'Notifications Discord',
+-	'ACP_DISCORD_NOTIFICATIONS_SETTINGS'		=> 'Paramètres',
+-	'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS'		=> 'Webhooks',
+-	'ACP_DISCORD_NOTIFICATIONS_MAPPING'			=> 'Mapping',
++	'ACP_DISCORD_NOTIFICATIONS_TITLE'			=> 'Paramètres',
+ 
+ 	// ACP Logs
+ 	'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE'		=> 'Paramètres des notifications Discord modifiées',
+-	'ACP_DISCORD_NOTIFICATIONS_WEBHOOK_ERROR'	=> 'Discord Webhook a renvoyé le code d‘état HTTP %d',
+-	'ACP_DISCORD_NOTIFICATIONS_CURL_ERROR'		=> 'Code d‘erreur Discord Webhook cURL %d',
+-	'ACP_DISCORD_NOTIFICATIONS_JSON_ERROR'		=> 'Erreur d‘encodage Discord JSON : %s',
++	'ACP_DISCORD_NOTIFICATIONS_WEBHOOK_ERROR'	=> 'Discord Webhook returned HTTP status code %d',
++	'ACP_DISCORD_NOTIFICATIONS_CURL_ERROR'		=> 'Discord Webhook cURL error code %d',
++	'ACP_DISCORD_NOTIFICATIONS_JSON_ERROR'		=> 'Discord JSON encode error: %s',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/create_tables.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/migrations/create_tables.php"
+index a9f97280c..3f145cd37 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/create_tables.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/migrations/create_tables.php"
+@@ -12,7 +12,7 @@ class create_tables extends \phpbb\db\migration\migration
+ {
+ 	static public function depends_on()
+ 	{
+-		return ['\mober\discordnotifications\migrations\extension_installation'];
++		return array('\mober\discordnotifications\migrations\extension_installation');
+ 	}
+ 
+ 	/**
+@@ -21,23 +21,23 @@ class create_tables extends \phpbb\db\migration\migration
+ 	*/
+ 	public function update_schema()
+ 	{
+-		return [
+-			'add_tables' => [
+-				$this->table_prefix . 'discord_webhooks' => [
+-					'COLUMNS' => [
+-						'alias'	=> [
++		return array(
++			'add_tables' => array (
++				$this->table_prefix . 'discord_webhooks' => array (
++					'COLUMNS' => array (
++						'alias' => array (
+ 							'VCHAR:255',
+-							'',
+-						],
+-						'url' => [
++							''
++						),
++						'url' => array (
+ 							'VCHAR:255',
+-							'',
+-						],
+-					],
++							''
++						),
++					),
+ 					'PRIMARY_KEY' => 'alias',
+-				],
+-			],
+-		];
++				),
++			),
++		);
+ 	}
+ 
+ 	/**
+@@ -46,10 +46,10 @@ class create_tables extends \phpbb\db\migration\migration
+ 	*/
+ 	public function revert_schema()
+ 	{
+-		return [
+-			'drop_tables' => [
++		return array (
++			'drop_tables' => array (
+ 				$this->table_prefix . 'discord_webhooks',
+-			],
+-		];
++			)
++		);
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/extension_installation.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/migrations/extension_installation.php"
+index 06c999134..676d97795 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/extension_installation.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/migrations/extension_installation.php"
+@@ -38,13 +38,13 @@ class extension_installation extends \phpbb\db\migration\migration
+ 	*/
+ 	public function update_schema()
+ 	{
+-		return [
+-			'add_columns' => [
+-				$this->table_prefix . 'forums' => [
+-					'discord_notifications' => ['VCHAR:255', ''],
+-				],
+-			],
+-		];
++		return array(
++			'add_columns'	=> array(
++				$this->table_prefix . 'forums'	=> array(
++					'discord_notifications' => array('VCHAR:255', ''),
++				),
++			),
++		);
+ 	}
+ 
+ 	/**
+@@ -55,13 +55,13 @@ class extension_installation extends \phpbb\db\migration\migration
+ 	*/
+ 	public function revert_schema()
+ 	{
+-		return [
+-			'drop_columns' => [
+-				$this->table_prefix . 'forums' => [
++		return array(
++			'drop_columns'	=> array(
++				$this->table_prefix . 'forums'	=> array(
+ 					'discord_notifications',
+-				],
+-			],
+-		];
++				),
++			),
++		);
+ 	}
+ 
+ 	/**
+@@ -74,55 +74,55 @@ class extension_installation extends \phpbb\db\migration\migration
+ 	*/
+ 	public function update_data()
+ 	{
+-		return [
++		return array(
+ 			// The "master switch" that enables notifications to be sent. This can only be set to true if the webhook URL is also valid
+-			['config.add', ['discord_notifications_enabled', 0]],
++			array('config.add', array('discord_notifications_enabled', 0)),
+ 			// The maximum number of characters permitted in a discord notification message
+-			['config.add', ['discord_notifications_post_preview_length', 200]],
++			array('config.add', array('discord_notifications_post_preview_length', 200)),
+ 			// Timeout values
+-			['config.add', ['discord_notifications_connect_timeout', 2]],
+-			['config.add', ['discord_notifications_exec_timeout', 2]],
++			array('config.add', array('discord_notifications_connect_timeout', 2)),
++			array('config.add', array('discord_notifications_exec_timeout', 2)),
+ 
+ 			// These configurations represent the various types of notifications that can be sent, which can be individually enabled or disabled.
+ 			// Upon installation, every notification type is enabled by default.
+ 
+ 			// Post notifications
+-			['config.add', ['discord_notification_type_post_create', 1]],
+-			['config.add', ['discord_notification_type_post_update', 1]],
+-			['config.add', ['discord_notification_type_post_delete', 1]],
+-			['config.add', ['discord_notification_type_post_lock', 1]],
+-			['config.add', ['discord_notification_type_post_unlock', 1]],
+-			['config.add', ['discord_notification_type_post_approve', 1]],
++			array('config.add', array('discord_notification_type_post_create', 1)),
++			array('config.add', array('discord_notification_type_post_update', 1)),
++			array('config.add', array('discord_notification_type_post_delete', 1)),
++			array('config.add', array('discord_notification_type_post_lock', 1)),
++			array('config.add', array('discord_notification_type_post_unlock', 1)),
++			array('config.add', array('discord_notification_type_post_approve', 1)),
+ 
+ 			// Topic notifications
+-			['config.add', ['discord_notification_type_topic_create', 1]],
+-			['config.add', ['discord_notification_type_topic_update', 1]],
+-			['config.add', ['discord_notification_type_topic_delete', 1]],
+-			['config.add', ['discord_notification_type_topic_lock', 1]],
+-			['config.add', ['discord_notification_type_topic_unlock', 1]],
+-			['config.add', ['discord_notification_type_topic_approve', 1]],
++			array('config.add', array('discord_notification_type_topic_create', 1)),
++			array('config.add', array('discord_notification_type_topic_update', 1)),
++			array('config.add', array('discord_notification_type_topic_delete', 1)),
++			array('config.add', array('discord_notification_type_topic_lock', 1)),
++			array('config.add', array('discord_notification_type_topic_unlock', 1)),
++			array('config.add', array('discord_notification_type_topic_approve', 1)),
+ 
+ 			// User notifications
+-			['config.add', ['discord_notification_type_user_create', 1]],
+-			['config.add', ['discord_notification_type_user_delete', 1]],
++			array('config.add', array('discord_notification_type_user_create', 1)),
++			array('config.add', array('discord_notification_type_user_delete', 1)),
+ 
+ 			// Default channel
+-			['config.add', ['discord_notification_default_webhook', '']],
++			array('config.add', array('discord_notification_default_webhook', '')),
+ 
+ 			// Standard ACP module data
+-			['module.add', [
++			array('module.add', array(
+ 				'acp',
+ 				'ACP_CAT_DOT_MODS',
+-				'ACP_DISCORD_NOTIFICATIONS',
+-			]],
+-			['module.add', [
++				'ACP_DISCORD_NOTIFICATIONS'
++			)),
++			array('module.add', array(
+ 				'acp',
+ 				'ACP_DISCORD_NOTIFICATIONS',
+-				[
+-					'module_basename' => '\mober\discordnotifications\acp\discord_notifications_module',
+-					'modes'           => ['settings'],
+-				],
+-			]],
+-		];
++				array(
++					'module_basename'	=> '\mober\discordnotifications\acp\discord_notifications_module',
++					'modes'				=> array('settings'),
++				),
++			)),
++		);
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/v308/add_modules.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/v308/add_modules.php"
+deleted file mode 100644
+index c52f41dd6..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/v308/add_modules.php"
++++ /dev/null
+@@ -1,39 +0,0 @@
+-<?php
+-
+-namespace mober\discordnotifications\migrations\v308;
+-
+-class add_modules extends \phpbb\db\migration\migration
+-{
+-	static public function depends_on()
+-	{
+-		return ['\mober\discordnotifications\migrations\extension_installation'];
+-	}
+-
+-	public function update_data()
+-	{
+-		return [
+-			['module.add', [
+-				'acp',
+-				'ACP_DISCORD_NOTIFICATIONS',
+-				[
+-					'module_basename'	=> '\mober\discordnotifications\acp\discord_notifications_module',
+-					'modes'				=> [
+-						'webhooks',
+-						'mapping',
+-					],
+-				],
+-			]],
+-			['custom', [
+-				[$this, 'rename_settings_module']
+-			]],
+-		];
+-	}
+-
+-	public function rename_settings_module()
+-	{
+-		$sql = 'UPDATE ' . MODULES_TABLE . "
+-			SET module_langname = 'ACP_DISCORD_NOTIFICATIONS_SETTINGS'
+-			WHERE module_langname = 'ACP_DISCORD_NOTIFICATIONS_TITLE'";
+-		$this->sql_query($sql);
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/v308/add_version.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/v308/add_version.php"
+deleted file mode 100644
+index 2b00710ef..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/v308/add_version.php"
++++ /dev/null
+@@ -1,24 +0,0 @@
+-<?php
+-
+-namespace mober\discordnotifications\migrations\v308;
+-
+-class add_version extends \phpbb\db\migration\migration
+-{
+-	static public function depends_on()
+-	{
+-		return ['\mober\discordnotifications\migrations\extension_installation'];
+-	}
+-
+-	public function effectively_installed()
+-	{
+-		return isset($this->config['discord_notification_version']) &&
+-			version_compare($this->config['discord_notification_version'], '3.0.8', '>=');
+-	}
+-
+-	public function update_data()
+-	{
+-		return [
+-			['config.add', ['discord_notification_version', '3.0.8']],
+-		];
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/notification_service.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/notification_service.php"
+index ece99c293..9c2c7d1e6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/notification_service.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/notification_service.php"
+@@ -70,7 +70,7 @@ class notification_service
+ 	{
+ 		global $table_prefix;
+ 
+-		if (!is_numeric($forum_id))
++		if (is_numeric($forum_id) == false)
+ 		{
+ 			return false;
+ 		}
+@@ -118,7 +118,7 @@ class notification_service
+ 	 */
+ 	public function query_forum_name($forum_id)
+ 	{
+-		if (!is_numeric($forum_id))
++		if (is_numeric($forum_id) == false)
+ 		{
+ 			return null;
+ 		}
+@@ -138,7 +138,7 @@ class notification_service
+ 	 */
+ 	public function query_post_subject($post_id)
+ 	{
+-		if (!is_numeric($post_id))
++		if (is_numeric($post_id) == false)
+ 		{
+ 			return null;
+ 		}
+@@ -159,7 +159,7 @@ class notification_service
+ 	 */
+ 	public function query_topic_title($topic_id)
+ 	{
+-		if (!is_numeric($topic_id))
++		if (is_numeric($topic_id) == false)
+ 		{
+ 			return null;
+ 		}
+@@ -180,9 +180,9 @@ class notification_service
+ 	 */
+ 	public function query_topic_details($topic_id)
+ 	{
+-		if (!is_numeric($topic_id))
++		if (is_numeric($topic_id) == false)
+ 		{
+-			return [];
++			return array();
+ 		}
+ 
+ 		$sql = "SELECT
+@@ -205,7 +205,7 @@ class notification_service
+ 	 */
+ 	public function query_user_name($user_id)
+ 	{
+-		if (!is_numeric($user_id))
++		if (is_numeric($user_id) == false)
+ 		{
+ 			return false;
+ 		}
+@@ -231,7 +231,7 @@ class notification_service
+ 	{
+ 		global $table_prefix;
+ 
+-		if ($this->config['discord_notifications_enabled'] == 0 || !isset($message))
++		if ($this->config['discord_notifications_enabled'] == 0 || isset($message) == false)
+ 		{
+ 			return;
+ 		}
+@@ -263,7 +263,7 @@ class notification_service
+ 	 */
+ 	public function force_send_discord_notification($discord_webhook_url, $message)
+ 	{
+-		if (!filter_var($discord_webhook_url, FILTER_VALIDATE_URL) || !is_string($message) || $message == '')
++		if (!filter_var($discord_webhook_url, FILTER_VALIDATE_URL) || is_string($message) == false || $message == '')
+ 		{
+ 			return false;
+ 		}
+@@ -290,20 +290,20 @@ class notification_service
+ 	 */
+ 	private function execute_discord_webhook($discord_webhook_url, $color, $message, $title = null, $preview = null, $footer = null)
+ 	{
+-		if (!isset($discord_webhook_url) || $discord_webhook_url === '')
++		if (isset($discord_webhook_url) == false || $discord_webhook_url === '')
+ 		{
+ 			return false;
+ 		}
+-		if (!is_integer($color) || $color < 0)
++		if (is_integer($color) == false || $color < 0)
+ 		{
+ 			// Use the default color if we did not receive a valid color value
+ 			$color = self::DEFAULT_COLOR;
+ 		}
+-		if (!is_string($message) || $message == '')
++		if (is_string($message) == false || $message == '')
+ 		{
+ 			return false;
+ 		}
+-		if (isset($footer) && (!is_string($footer) || $footer == ''))
++		if (isset($footer) == true && (is_string($footer) == false || $footer == ''))
+ 		{
+ 			return false;
+ 		}
+@@ -339,16 +339,14 @@ class notification_service
+ 		// Place the message inside the JSON structure that Discord expects to receive at the REST endpoint.
+ 
+ 		$embed = [
+-			'timestamp'		=> date('c', time()),
+-			'color'			=> $color,
+-			'description'	=> $message,
++			'timestamp'   => date('c', time()),
++			'color'       => $color,
++			'description' => $message
+ 		];
+ 
+ 		if (isset($footer))
+ 		{
+-			$embed['footer'] = [
+-				'text' => $footer,
+-			];
++			$embed["footer"] = ["text" => $footer];
+ 		}
+ 
+ 		if (isset($title) && isset($preview))
+@@ -359,16 +357,16 @@ class notification_service
+ 			{
+ 				$embed['fields'] = [
+ 					[
+-						'name'		=> $title,
+-						'value'		=> $preview,
+-						'inline'	=> false,
+-					],
++						'name'   => $title,
++						'value'  => $preview,
++						'inline' => false
++					]
+ 				];
+ 			}
+ 		}
+ 
+ 		$payload = [
+-			'embeds' => [$embed],
++			'embeds' => [$embed]
+ 		];
+ 
+ 		$json = \json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
+@@ -380,7 +378,7 @@ class notification_service
+ 
+ 		// Use the CURL library to transmit the message via a POST operation to the webhook URL.
+ 		$h = curl_init();
+-		curl_setopt($h, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
++		curl_setopt($h, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
+ 		curl_setopt($h, CURLOPT_URL, $discord_webhook_url);
+ 		curl_setopt($h, CURLOPT_POST, 1);
+ 		curl_setopt($h, CURLOPT_POSTFIELDS, $json);
+@@ -400,8 +398,7 @@ class notification_service
+ 				$this->log->add('admin', ANONYMOUS, '127.0.0.1', 'ACP_DISCORD_NOTIFICATIONS_WEBHOOK_ERROR', time(), [$status]);
+ 				return false;
+ 			}
+-		}
+-		else
++		} else
+ 		{
+ 			$this->log->add('admin', ANONYMOUS, '127.0.0.1', 'ACP_DISCORD_NOTIFICATIONS_CURL_ERROR', time(), [$error]);
+ 			return false;
diff --git "[FORUM_EXT]/mober\\discordnotifications/diff_nospace.tmp" "[FORUM_EXT]/mober\\discordnotifications/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/mober\\discordnotifications/diff_nospace.tmp"
@@ -0,0 +1,3087 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
+index 0283d968d..27cf0e844 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
+@@ -15,26 +15,16 @@ class discord_notifications_info
+ {
+ 	public function module()
+ 	{
+-		return [
++		return array(
+ 			'filename'	=> '\mober\discordnotifications\acp\discord_notifications_module',
+ 			'title'		=> 'ACP_DISCORD_NOTIFICATIONS',
+-			'modes'		=> [
+-				'settings'	=> [
+-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_SETTINGS',
++			'modes'		=> array(
++				'settings'	=> array(
++					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_TITLE',
+ 					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
+-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
+-				],
+-				'webhooks'	=> [
+-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS',
+-					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
+-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
+-				],
+-				'mapping'	=> [
+-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_MAPPING',
+-					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
+-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
+-				],
+-			],
+-		];
++					'cat'	=> array('ACP_DISCORD_NOTIFICATIONS')
++				),
++			),
++		);
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
+index bd7741639..fb82cbbad 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
+@@ -18,8 +18,9 @@ class discord_notifications_module
+ 	const MIN_POST_PREVIEW_LENGTH = 10;
+ 
+ 	// The maximum number of characters that the user can set for the post preview setting.
+-	// See: https://discord.com/developers/docs/resources/channel#embed-object-embed-limits
+-	const MAX_POST_PREVIEW_LENGTH = 1024;
++	// Note that this is slightly less than the actual allowed maximum by Discord (2048), but we reserve
++	// some space to prepend the preview text with something like "Preview: " or "Reason: "
++	const MAX_POST_PREVIEW_LENGTH = 2000;
+ 
+ 	// The name for the form used for this page
+ 	const PAGE_FORM_NAME = 'acp_mober_discord_notifications';
+@@ -48,6 +49,9 @@ class discord_notifications_module
+ 	/** @var \phpbb\log\log */
+ 	protected $log;
+ 
++	/** @var \mober\discordnotifications\notification_service */
++	protected $notification_service;
++
+ 	/** @var \phpbb\request\request */
+ 	protected $request;
+ 
+@@ -57,13 +61,9 @@ class discord_notifications_module
+ 	/** @var \phpbb\user */
+ 	protected $user;
+ 
+-	/** @var bool */
+-	private  $curl_available;
+-
+ 	public function main($id, $mode)
+ 	{
+ 		global $phpbb_container;
+-
+ 		$this->cache = $phpbb_container->get('cache.driver');
+ 		$this->config = $phpbb_container->get('config');
+ 		$this->db = $phpbb_container->get('dbal.conn');
+@@ -72,18 +72,16 @@ class discord_notifications_module
+ 		$this->request = $phpbb_container->get('request');
+ 		$this->template = $phpbb_container->get('template');
+ 		$this->user = $phpbb_container->get('user');
+-		$this->curl_available = extension_loaded('curl');
++		// Used for sending test messages to Discord
++		$this->notification_service = $phpbb_container->get('mober.discordnotifications.notification_service');
+ 
+ 		$this->language->add_lang('acp_discord_notifications', 'mober/discordnotifications');
+-		$this->page_title = $this->language->lang('ACP_DISCORD_NOTIFICATIONS');
++		$this->tpl_name = 'acp_discord_notifications';
++		$this->page_title = $this->language->lang('ACP_DISCORD_NOTIFICATIONS_TITLE');
+ 
+ 		add_form_key(self::PAGE_FORM_NAME);
+ 
+-		switch ($mode)
+-		{
+-			case 'webhooks':
+-				$this->tpl_name = 'acp_discord_notifications_webhooks';
+-
++		// Process submit actions
+ 		if ($this->request->is_set_post('action_send_test_message'))
+ 		{
+ 			$this->process_send_test_message();
+@@ -94,40 +92,18 @@ class discord_notifications_module
+ 		}
+ 		else if ($this->request->is_set_post('submit'))
+ 		{
+-					$this->process_webhooks_form_submit();
+-				}
+-
+-				$this->generate_webhook_section();
+-				break;
+-
+-			case 'mapping':
+-				$this->tpl_name = 'acp_discord_notifications_mapping';
+-
+-				if ($this->request->is_set_post('submit'))
+-				{
+-					$this->process_mapping_form_submit();
++			$this->process_form_submit();
+ 		}
+ 
+-				$this->generate_webhook_section();
++		// Generate the dynamic HTML content for enabling/disabling forum notifications
+ 		$this->generate_forum_section();
+-				break;
+-
+-			case 'settings':
+-			default:
+-				$this->tpl_name = 'acp_discord_notifications_settings';
+ 
+-				if ($this->request->is_set_post('submit'))
+-				{
+-					$this->process_settings_form_submit();
+-				}
+-				break;
+-		}
++		$this->generate_webhook_section();
+ 
+ 		// Assign template values so that the page reflects the state of the extension settings
+-		$this->template->assign_vars([
++		$this->template->assign_vars(array(
+ 			'DN_MASTER_ENABLE'			=> $this->config['discord_notifications_enabled'],
+ 			'DN_POST_PREVIEW_LENGTH'	=> $this->config['discord_notifications_post_preview_length'],
+-			'DN_POST_PREVIEW_DESCRIPTION'	=> sprintf($this->language->lang('DN_POST_PREVIEW_DESCRIPTION'), self::MIN_POST_PREVIEW_LENGTH, self::MAX_POST_PREVIEW_LENGTH),
+ 			'DN_TEST_MESSAGE_TEXT'		=> $this->language->lang('DN_TEST_MESSAGE_TEXT'),
+ 			'DN_CONNECT_TIMEOUT'		=> $this->config['discord_notifications_connect_timeout'],
+ 			'DN_EXEC_TIMEOUT'			=> $this->config['discord_notifications_exec_timeout'],
+@@ -151,9 +127,8 @@ class discord_notifications_module
+ 
+ 			'DN_DEFAULT_WEBHOOK'		=> $this->config['discord_notification_default_webhook'],
+ 
+-			'DN_CURL_AVAILABLE'				=> $this->curl_available,
+ 			'U_ACTION'					=> $this->u_action,
+-		]);
++		));
+ 	}
+ 
+ 	/**
+@@ -184,12 +159,10 @@ class discord_notifications_module
+ 	 */
+ 	private function process_send_test_message()
+ 	{
+-		global $table_prefix, $phpbb_container;
+-
+-		$this->validate_post_request();
++		global $table_prefix;
+ 
+ 		$webhook = $this->request->variable('dn_test_webhook', '', true);
+-		$test_message = $this->request->variable('dn_test_message', '', true);
++		$test_message = $this->request->variable('dn_test_message', '');
+ 
+ 		// Check user inputs before attempting to send the message
+ 		if ($test_message == '')
+@@ -206,8 +179,7 @@ class discord_notifications_module
+ 		$data = $this->db->sql_fetchrow($result);
+ 		$this->db->sql_freeresult($result);
+ 
+-		$notification_service = $phpbb_container->get('mober.discordnotifications.notification_service');
+-		$result = $notification_service->force_send_discord_notification($data['url'], $test_message);
++		$result = $this->notification_service->force_send_discord_notification($data['url'], $test_message);
+ 		if ($result)
+ 		{
+ 			trigger_error($this->language->lang('DN_TEST_SUCCESS') . adm_back_link($this->u_action));
+@@ -222,7 +194,10 @@ class discord_notifications_module
+ 	{
+ 		global $table_prefix;
+ 
+-		$this->validate_post_request();
++		if (!check_form_key(self::PAGE_FORM_NAME))
++		{
++			trigger_error('FORM_INVALID', E_USER_WARNING);
++		}
+ 
+ 		$delete_alias = $this->request->variable('action_delete_alias',  ['' => ''], true);
+ 		foreach ($delete_alias as $alias => $url)
+@@ -236,9 +211,17 @@ class discord_notifications_module
+ 		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
+ 	}
+ 
+-	private function process_settings_form_submit()
++	/**
++	 * Handles all error checking and database changes when the user hits the submit button on the ACP page.
++	 */
++	private function process_form_submit()
++	{
++		global $table_prefix;
++
++		if (!check_form_key(self::PAGE_FORM_NAME))
+ 		{
+-		$this->validate_post_request();
++			trigger_error('FORM_INVALID', E_USER_WARNING);
++		}
+ 
+ 		// Get form values for the main settings
+ 		$master_enable = $this->request->variable('dn_master_enable', 0);
+@@ -247,50 +230,14 @@ class discord_notifications_module
+ 		// Verify that the post preview length is a numeric string, convert to an int and check the valid range
+ 		if (!is_numeric($preview_length))
+ 		{
+-			trigger_error(
+-				sprintf(
+-					$this->language->lang('DN_POST_PREVIEW_INVALID'),
+-					self::MIN_POST_PREVIEW_LENGTH,
+-					self::MAX_POST_PREVIEW_LENGTH
+-				) . adm_back_link($this->u_action),
+-				E_USER_WARNING
+-			);
++			trigger_error($this->language->lang('DN_POST_PREVIEW_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
+ 		}
+ 		$preview_length = (int) $preview_length;
+ 		if ($preview_length != 0 && ($preview_length < self::MIN_POST_PREVIEW_LENGTH || $preview_length > self::MAX_POST_PREVIEW_LENGTH))
+ 		{
+-			trigger_error(
+-				sprintf(
+-					$this->language->lang('DN_POST_PREVIEW_INVALID'),
+-					self::MIN_POST_PREVIEW_LENGTH,
+-					self::MAX_POST_PREVIEW_LENGTH
+-				) . adm_back_link($this->u_action),
+-				E_USER_WARNING
+-			);
++			trigger_error($this->language->lang('DN_POST_PREVIEW_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
+ 		}
+ 
+-		$connect_timeout = max(1, (int) $this->request->variable('dn_connect_to', 0));
+-		$exec_timeout = max(1, (int) $this->request->variable('dn_exec_to', 0));
+-
+-		$this->config->set('discord_notifications_enabled', $master_enable);
+-		$this->config->set('discord_notifications_post_preview_length', $preview_length);
+-		$this->config->set('discord_notifications_connect_timeout', $connect_timeout);
+-		$this->config->set('discord_notifications_exec_timeout', $exec_timeout);
+-
+-		// Log the settings change
+-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE');
+-		// Destroy any cached discord notification data
+-		$this->cache->destroy('mober_discord_notifications');
+-
+-		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
+-	}
+-
+-	private function process_webhooks_form_submit()
+-	{
+-		global $table_prefix;
+-
+-		$this->validate_post_request();
+-
+ 		// Create new entry
+ 		$new_alias = $this->request->variable('dn_webhook_new_alias', '', true);
+ 		$new_url = $this->request->variable('dn_webhook_new_url', '');
+@@ -320,26 +267,35 @@ class discord_notifications_module
+ 			$this->db->sql_query($sql);
+ 		}
+ 
+-		// Log the settings change
+-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE');
+-		// Destroy any cached discord notification data
+-		$this->cache->destroy('mober_discord_notifications');
+-
+-		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
+-	}
+-
+-	private function process_mapping_form_submit()
+-	{
+-		$this->validate_post_request();
+-
+ 		// Update configuration per forum
+ 		$forum_configuration = $this->request->variable('dn_forum', [0 => ''], true);
+ 		foreach ($forum_configuration as $id => $value)
++		{
++			// Don't update deleted entries
++			if ($value === '' || $webhook_configuration[$value] !== '')
+ 			{
+ 				$sql = "UPDATE " . FORUMS_TABLE . " SET discord_notifications = '" . $this->db->sql_escape($value) .
+ 					"' WHERE forum_id = " . (int) $id;
+ 				$this->db->sql_query($sql);
+ 			}
++		}
++
++		$connect_timeout = (int) $this->request->variable('dn_connect_to', 0);
++		if ($connect_timeout < 1)
++		{
++			$connect_timeout = 1;
++		}
++
++		$exec_timeout = (int) $this->request->variable('dn_exec_to', 0);
++		if ($exec_timeout < 1)
++		{
++			$exec_timeout = 1;
++		}
++
++		$this->config->set('discord_notifications_enabled', $master_enable);
++		$this->config->set('discord_notifications_post_preview_length', $preview_length);
++		$this->config->set('discord_notifications_connect_timeout', $connect_timeout);
++		$this->config->set('discord_notifications_exec_timeout', $exec_timeout);
+ 
+ 		$this->config->set('discord_notification_type_post_create', $this->request->variable('dn_post_create', 0));
+ 		$this->config->set('discord_notification_type_post_update', $this->request->variable('dn_post_update', 0));
+@@ -377,10 +333,10 @@ class discord_notifications_module
+ 
+ 		while ($row = $this->db->sql_fetchrow($result))
+ 		{
+-			$tpl_row = [
++			$tpl_row = array(
+ 				'ALIAS'	=> $row['alias'],
+ 				'URL'	=> $row['url'],
+-			];
++			);
+ 			$this->template->assign_block_vars('webhookrow', $tpl_row);
+ 		}
+ 		$this->db->sql_freeresult($result);
+@@ -400,7 +356,7 @@ class discord_notifications_module
+ 
+ 		$sql = "SELECT forum_id, forum_type, forum_name, left_id, right_id, parent_id, forum_parents, discord_notifications
+ 			FROM " . FORUMS_TABLE . "
+-			ORDER BY left_id";
++			ORDER BY left_id ASC";
+ 		$result = $this->db->sql_query($sql);
+ 
+ 		while ($row = $this->db->sql_fetchrow($result))
+@@ -408,23 +364,23 @@ class discord_notifications_module
+ 			// Category forums are displayed for organizational purposes, but have no configuration
+ 			if ($row['forum_type'] == FORUM_CAT)
+ 			{
+-				$tpl_row = [
++				$tpl_row = array(
+ 					'S_IS_CAT'		=> true,
+ 					'FORUM_NAME'	=> $row['forum_name'],
+ 					'PARENTS'	=> '',
+-				];
++				);
+ 				$this->template->assign_block_vars('forumrow', $tpl_row);
+ 			}
+ 			else if ($row['forum_type'] == FORUM_POST)
+ 			{
+ 				// The labels for all the inputs are constructed based on the forum IDs to make it easy to know which
+-				$tpl_row = [
++				$tpl_row = array(
+ 							'S_IS_CAT'		=> false,
+ 							'FORUM_NAME'	=> $row['forum_name'],
+ 							'FORUM_ID'		=> $row['forum_id'],
+ 							'ALIAS'			=> $row['discord_notifications'],
+ 							'PARENTS'		=> '',
+-				];
++						);
+ 				$parents = get_forum_parents($row);
+ 				if (is_array($parents))
+ 				{
+@@ -439,12 +395,4 @@ class discord_notifications_module
+ 		}
+ 		$this->db->sql_freeresult($result);
+ 	}
+-
+-	private function validate_post_request()
+-	{
+-		if (!check_form_key(self::PAGE_FORM_NAME))
+-		{
+-			trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
+-		}
+-	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
+similarity index 63%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
+index e059a8f75..27ee7d868 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
+@@ -1,40 +1,100 @@
+-{% include 'overall_header.html' %}
++<!-- INCLUDE overall_header.html -->
+ 
+ <h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
+ 
+-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
+-
+-{% if not DN_CURL_AVAILABLE %}
+-	<div class="errorbox">
+-		<p>{{ lang('DN_MISSING_CURL') }}</p>
+-	</div>
+-{% endif %}
++<p>{{ DN_ACP_DESCRIPTION }}</p>
+ 
+ <form id="acp_board" method="post" action="{{ U_ACTION }}">
+ 
+ 	<fieldset>
+-		<legend>{{ lang('DN_WEBHOOK_DEFAULT') }}</legend>
++		<legend>{{ lang('DN_MAIN_SETTINGS') }}</legend>
+ 		<dl>
+-			<dt><label>{{ lang('DN_USER_CREATE') }}{{ lang('COLON') }}</label></dt>
+-			<dd><label><input type="radio" class="radio" name="dn_user_create" value="1" {% if DN_USER_CREATE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="dn_user_create" value="0" {% if not DN_USER_CREATE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++			<dt><label>{{ lang('DN_MASTER_ENABLE') }}{{ lang('COLON') }}</label></dt>
++			<dd><label><input type="radio" class="radio" name="dn_master_enable" value="1" {% if DN_MASTER_ENABLE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="dn_master_enable" value="0" {% if not DN_MASTER_ENABLE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label>{{ lang('DN_USER_DELETE') }}{{ lang('COLON') }}</label></dt>
+-			<dd><label><input type="radio" class="radio" name="dn_user_delete" value="1" {% if DN_USER_DELETE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="dn_user_delete" value="0" {% if not DN_USER_DELETE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++			<dt><label for="dn_post_preview_length">{{ lang('DN_POST_PREVIEW_LENGTH') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_POST_PREVIEW_DESCRIPTION') }}</span></dt>
++			<dd>
++				<input id="dn_post_preview_length" name="dn_post_preview_length" type="text" value="{{ DN_POST_PREVIEW_LENGTH }}" size="4" maxlength="4" />
++			</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="dn_webhook_default">{{ lang('DN_WEBHOOK_DEFAULT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_DEFAULT_DESCRIPTION') }}</span></dt>
++			<dt><label for="dn_connect_to">{{ lang('DN_CONNECT_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_CONNECT_TO_DESCRIPTION') }}</span></dt>
+ 			<dd>
+-				<select id="dn_webhook_default" name="dn_webhook_default">
+-					<option value="">({{ lang('DISABLED') }})</option>
++				<input id="dn_connect_to" name="dn_connect_to" type="text" value="{{ DN_CONNECT_TIMEOUT }}" size="4" maxlength="4" />
++			</dd>
++		</dl>
++		<dl>
++			<dt><label for="dn_exec_to">{{ lang('DN_EXEC_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_EXEC_TO_DESCRIPTION') }}</span></dt>
++			<dd>
++				<input id="dn_exec_to" name="dn_exec_to" type="text" value="{{ DN_EXEC_TIMEOUT }}" size="4" maxlength="4" />
++			</dd>
++		</dl>
++	</fieldset>
++
++	<fieldset>
++		<legend>{{ lang('DN_WEBHOOK_SETTINGS') }}</legend>
++		<p>{{ lang('DN_WEBHOOK_SETTINGS_DESCRIPTION') }}</p>
++		{% if loops.webhookrow %}
+ 			{% for webhook in loops.webhookrow %}
+-						<option value="{{ webhook.ALIAS }}"{% if DN_DEFAULT_WEBHOOK == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
++				<dl>
++					<dt><label for="dn_webhook_{{ webhook.ALIAS }}">{{ webhook.ALIAS }}</label></dt>
++					<dd>
++						<input type="text" size="100" maxlength="255" id="dn_webhook_{{ webhook.ALIAS }}" name="dn_webhook[{{ webhook.ALIAS }}]" value="{{ webhook.URL }}" />
++						<input type="submit" name="action_delete_alias[{{ webhook.ALIAS }}]" value="{{ lang('DELETE') }}" class="button2" onclick="return confirm('{{ lang('CONFIRM_OPERATION') }}');">
++					</dd>
++				</dl>
++			{% endfor %}
++		{% else %}
++			<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
++		{% endif %}
++	</fieldset>
++
++	<fieldset>
++		<legend>{{ lang('DN_WEBHOOK_NEW') }}</legend>
++		<p>{{ lang('DN_WEBHOOK_NEW_DESCRIPTION') }}</p>
++		<dl>
++			<dt><label for="dn_webhook_new_alias">{{ lang('DN_WEBHOOK_NEW_ALIAS') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_ALIAS_DESCRIPTION') }}</span></dt>
++			<dd>
++				<input id="dn_webhook_new_alias" name="dn_webhook_new_alias" type="text" value="" size="100" maxlength="255" />
++			</dd>
++		</dl>
++		<dl>
++			<dt><label for="dn_webhook_new_url">{{ lang('DN_WEBHOOK_NEW_URL') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_URL_DESCRIPTION') }}</span></dt>
++			<dd>
++				<input id="dn_webhook_new_url" name="dn_webhook_new_url" type="text" value="" size="100" maxlength="255" />
++			</dd>
++		</dl>
++	</fieldset>
++
++	<fieldset>
++		<legend>{{ lang('DN_TEST_SETTINGS') }}</legend>
++		<dl>
++			<dt><label for="dn_test_message">{{ lang('DN_TEST_MESSAGE') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_TEST_DESCRIPTION') }}</span></dt>
++			<dd>
++				<input id="dn_test_message" name="dn_test_message" type="text" value="{{ DN_TEST_MESSAGE_TEXT }}" size="100" maxlength="255" />
++			</dd>
++		</dl>
++		{% if loops.webhookrow %}
++		<dl>
++			<dt><label for="dn_test_webhook">{{ lang('DN_WEBHOOK_SELECT') }}{{ lang('COLON') }}</label><br /></dt>
++			<dd>
++				<select id="dn_test_webhook" name="dn_test_webhook">
++					<option value="">{{ lang('DN_WEBHOOK_SELECT') }}</option>
++					{% for webhook in loops.webhookrow %}
++					<option value="{{ webhook.ALIAS }}"{% if forumrow.ALIAS == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
+ 					{% endfor %}
+ 				</select>
+ 			</dd>
+ 		</dl>
++		<dl>
++			<dt><label for="action_send_test_message">{{ lang('DN_SEND_TEST') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_SEND_TEST_DESCRIPTION') }}</span></dt>
++			<dd><input class="button2" type="submit" id="action_send_test_message" name="action_send_test_message" value="{{ lang('DN_SEND_TEST') }}" /></dd>
++		</dl>
++		{% else %}
++		<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
++		{% endif %}
+ 	</fieldset>
+ 
+ 	<fieldset>
+@@ -100,6 +160,27 @@
+ 			<dd><label><input type="radio" class="radio" name="dn_topic_approve" value="1" {% if DN_TOPIC_APPROVE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+ 				<label><input type="radio" class="radio" name="dn_topic_approve" value="0" {% if not DN_TOPIC_APPROVE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 		</dl>
++		<dl>
++			<dt><label>{{ lang('DN_USER_CREATE') }}{{ lang('COLON') }}</label></dt>
++			<dd><label><input type="radio" class="radio" name="dn_user_create" value="1" {% if DN_USER_CREATE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="dn_user_create" value="0" {% if not DN_USER_CREATE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++		</dl>
++		<dl>
++			<dt><label>{{ lang('DN_USER_DELETE') }}{{ lang('COLON') }}</label></dt>
++			<dd><label><input type="radio" class="radio" name="dn_user_delete" value="1" {% if DN_USER_DELETE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="dn_user_delete" value="0" {% if not DN_USER_DELETE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++		</dl>
++		<dl>
++			<dt><label for="dn_webhook_default">{{ lang('DN_WEBHOOK_DEFAULT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_DEFAULT_DESCRIPTION') }}</span></dt>
++			<dd>
++				<select id="dn_webhook_default" name="dn_webhook_default">
++					<option value="">({{ lang('DISABLED') }})</option>
++					{% for webhook in loops.webhookrow %}
++					<option value="{{ webhook.ALIAS }}"{% if DN_DEFAULT_WEBHOOK == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
++					{% endfor %}
++				</select>
++			</dd>
++		</dl>
+ 	</fieldset>
+ 
+ 	<fieldset>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html"
+deleted file mode 100644
+index 90eed3ee7..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html"
++++ /dev/null
+@@ -1,49 +0,0 @@
+-{% include 'overall_header.html' %}
+-
+-<h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
+-
+-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
+-
+-{% if not DN_CURL_AVAILABLE %}
+-	<div class="errorbox">
+-		<p>{{ lang('DN_MISSING_CURL') }}</p>
+-	</div>
+-{% endif %}
+-
+-<form id="acp_board" method="post" action="{{ U_ACTION }}">
+-
+-	<fieldset>
+-		<legend>{{ lang('DN_MAIN_SETTINGS') }}</legend>
+-		<dl>
+-			<dt><label>{{ lang('DN_MASTER_ENABLE') }}{{ lang('COLON') }}</label></dt>
+-			<dd><label><input type="radio" class="radio" name="dn_master_enable" value="1" {% if DN_MASTER_ENABLE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="dn_master_enable" value="0" {% if not DN_MASTER_ENABLE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+-		</dl>
+-		<dl>
+-			<dt><label for="dn_post_preview_length">{{ lang('DN_POST_PREVIEW_LENGTH') }}{{ lang('COLON') }}</label><br /><span>{{ DN_POST_PREVIEW_DESCRIPTION }}</span></dt>
+-			<dd>
+-				<input id="dn_post_preview_length" name="dn_post_preview_length" type="text" value="{{ DN_POST_PREVIEW_LENGTH }}" size="4" maxlength="4" />
+-			</dd>
+-		</dl>
+-		<dl>
+-			<dt><label for="dn_connect_to">{{ lang('DN_CONNECT_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_CONNECT_TO_DESCRIPTION') }}</span></dt>
+-			<dd>
+-				<input id="dn_connect_to" name="dn_connect_to" type="text" value="{{ DN_CONNECT_TIMEOUT }}" size="4" maxlength="4" />
+-			</dd>
+-		</dl>
+-		<dl>
+-			<dt><label for="dn_exec_to">{{ lang('DN_EXEC_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_EXEC_TO_DESCRIPTION') }}</span></dt>
+-			<dd>
+-				<input id="dn_exec_to" name="dn_exec_to" type="text" value="{{ DN_EXEC_TIMEOUT }}" size="4" maxlength="4" />
+-			</dd>
+-		</dl>
+-	</fieldset>
+-
+-	<fieldset class="submit-buttons">
+-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+-		{{ S_FORM_TOKEN }}
+-	</fieldset>
+-
+-</form>
+-
+-{% include 'overall_footer.html' %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html"
+deleted file mode 100644
+index a500594a6..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html"
++++ /dev/null
+@@ -1,86 +0,0 @@
+-{% include 'overall_header.html' %}
+-
+-<h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
+-
+-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
+-
+-{% if not DN_CURL_AVAILABLE %}
+-	<div class="errorbox">
+-		<p>{{ lang('DN_MISSING_CURL') }}</p>
+-	</div>
+-{% endif %}
+-
+-<form id="acp_board" method="post" action="{{ U_ACTION }}">
+-
+-	<fieldset>
+-		<legend>{{ lang('DN_WEBHOOK_SETTINGS') }}</legend>
+-		<p>{{ lang('DN_WEBHOOK_SETTINGS_DESCRIPTION') }}</p>
+-		{% if loops.webhookrow %}
+-			{% for webhook in loops.webhookrow %}
+-				<dl>
+-					<dt><label for="dn_webhook_{{ webhook.ALIAS }}">{{ webhook.ALIAS }}</label></dt>
+-					<dd>
+-						<input type="text" size="100" maxlength="255" id="dn_webhook_{{ webhook.ALIAS }}" name="dn_webhook[{{ webhook.ALIAS }}]" value="{{ webhook.URL }}" />
+-						<input type="submit" name="action_delete_alias[{{ webhook.ALIAS }}]" value="{{ lang('DELETE') }}" class="button2" onclick="return confirm('{{ lang('CONFIRM_OPERATION') }}');">
+-					</dd>
+-				</dl>
+-			{% endfor %}
+-		{% else %}
+-			<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
+-		{% endif %}
+-	</fieldset>
+-
+-	<fieldset>
+-		<legend>{{ lang('DN_WEBHOOK_NEW') }}</legend>
+-		<p>{{ lang('DN_WEBHOOK_NEW_DESCRIPTION') }}</p>
+-		<dl>
+-			<dt><label for="dn_webhook_new_alias">{{ lang('DN_WEBHOOK_NEW_ALIAS') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_ALIAS_DESCRIPTION') }}</span></dt>
+-			<dd>
+-				<input id="dn_webhook_new_alias" name="dn_webhook_new_alias" type="text" value="" size="100" maxlength="255" />
+-			</dd>
+-		</dl>
+-		<dl>
+-			<dt><label for="dn_webhook_new_url">{{ lang('DN_WEBHOOK_NEW_URL') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_URL_DESCRIPTION') }}</span></dt>
+-			<dd>
+-				<input id="dn_webhook_new_url" name="dn_webhook_new_url" type="text" value="" size="100" maxlength="255" />
+-			</dd>
+-		</dl>
+-	</fieldset>
+-
+-	<fieldset>
+-		<legend>{{ lang('DN_TEST_SETTINGS') }}</legend>
+-		{% if loops.webhookrow %}
+-		<dl>
+-			<dt><label for="dn_test_message">{{ lang('DN_TEST_MESSAGE') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_TEST_DESCRIPTION') }}</span></dt>
+-			<dd>
+-				<input id="dn_test_message" name="dn_test_message" type="text" value="{{ DN_TEST_MESSAGE_TEXT }}" size="100" maxlength="255" />
+-			</dd>
+-		</dl>
+-		<dl>
+-			<dt><label for="dn_test_webhook">{{ lang('DN_WEBHOOK_SELECT') }}{{ lang('COLON') }}</label><br /></dt>
+-			<dd>
+-				<select id="dn_test_webhook" name="dn_test_webhook">
+-					<option value="">{{ lang('DN_WEBHOOK_SELECT') }}</option>
+-					{% for webhook in loops.webhookrow %}
+-					<option value="{{ webhook.ALIAS }}"{% if forumrow.ALIAS == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
+-					{% endfor %}
+-				</select>
+-			</dd>
+-		</dl>
+-		<dl>
+-			<dt><label for="action_send_test_message">{{ lang('DN_SEND_TEST') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_SEND_TEST_DESCRIPTION') }}</span></dt>
+-			<dd><input class="button2" type="submit" id="action_send_test_message" name="action_send_test_message" value="{{ lang('DN_SEND_TEST') }}" /></dd>
+-		</dl>
+-		{% else %}
+-		<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
+-		{% endif %}
+-	</fieldset>
+-
+-	<fieldset class="submit-buttons">
+-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+-		{{ S_FORM_TOKEN }}
+-	</fieldset>
+-
+-</form>
+-
+-{% include 'overall_footer.html' %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/composer.json"
+index b9f060cfe..31a9c730b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/composer.json"
+@@ -3,7 +3,7 @@
+     "type": "phpbb-extension",
+     "description": "Publishes forum event notifications to a Discord server channel",
+     "homepage": "https://github.com/m-ober/phpbb-discord-notifications",
+-    "version": "3.0.8",
++    "version": "3.0.7",
+     "keywords": [
+         "phpbb",
+         "extension",
+@@ -24,15 +24,15 @@
+         }
+     ],
+     "require": {
+-        "php": ">=7.2",
++        "php": ">=7.1",
+         "ext-curl": "*",
+         "composer/installers": "~1.0.0",
+-        "phpbb/phpbb": ">=3.3.11"
++        "phpbb/phpbb": ">=3.3.0"
+     },
+     "extra": {
+         "display-name": "Discord Notifications",
+         "soft-require": {
+-            "phpbb/phpbb": ">=3.3.11"
++            "phpbb/phpbb": ">=3.3.0"
+         },
+         "version-check": {
+             "host": "www.phpbb.com",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/diff_full.tmp"
+new file mode 100644
+index 000000000..f0125ec0b
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/diff_full.tmp"
+@@ -0,0 +1,2441 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
++index 0283d968d..27cf0e844 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
++@@ -2,8 +2,8 @@
++ /**
++  * Discord Notifications extension for the phpBB Forum Software package.
++  *
++- * @copyright (c)	2018, Tyler Olsen, https://github.com/rootslinux
++- * @license			GNU General Public License, version 2 (GPL-2.0)
+++ * @copyright (c) 2018, Tyler Olsen, https://github.com/rootslinux
+++ * @license GNU General Public License, version 2 (GPL-2.0)
++  */
++ 
++ namespace mober\discordnotifications\acp;
++@@ -15,26 +15,16 @@ class discord_notifications_info
++ {
++ 	public function module()
++ 	{
++-		return [
+++		return array(
++ 			'filename'	=> '\mober\discordnotifications\acp\discord_notifications_module',
++ 			'title'		=> 'ACP_DISCORD_NOTIFICATIONS',
++-			'modes'		=> [
++-				'settings'	=> [
++-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_SETTINGS',
+++			'modes'		=> array(
+++				'settings'	=> array(
+++					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_TITLE',
++ 					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
++-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
++-				],
++-				'webhooks'	=> [
++-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS',
++-					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
++-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
++-				],
++-				'mapping'	=> [
++-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_MAPPING',
++-					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
++-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
++-				],
++-			],
++-		];
+++					'cat'	=> array('ACP_DISCORD_NOTIFICATIONS')
+++				),
+++			),
+++		);
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
++index bd7741639..fb82cbbad 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
++@@ -18,8 +18,9 @@ class discord_notifications_module
++ 	const MIN_POST_PREVIEW_LENGTH = 10;
++ 
++ 	// The maximum number of characters that the user can set for the post preview setting.
++-	// See: https://discord.com/developers/docs/resources/channel#embed-object-embed-limits
++-	const MAX_POST_PREVIEW_LENGTH = 1024;
+++	// Note that this is slightly less than the actual allowed maximum by Discord (2048), but we reserve
+++	// some space to prepend the preview text with something like "Preview: " or "Reason: "
+++	const MAX_POST_PREVIEW_LENGTH = 2000;
++ 
++ 	// The name for the form used for this page
++ 	const PAGE_FORM_NAME = 'acp_mober_discord_notifications';
++@@ -48,6 +49,9 @@ class discord_notifications_module
++ 	/** @var \phpbb\log\log */
++ 	protected $log;
++ 
+++	/** @var \mober\discordnotifications\notification_service */
+++	protected $notification_service;
+++
++ 	/** @var \phpbb\request\request */
++ 	protected $request;
++ 
++@@ -57,13 +61,9 @@ class discord_notifications_module
++ 	/** @var \phpbb\user */
++ 	protected $user;
++ 
++-	/** @var bool */
++-	private  $curl_available;
++-
++ 	public function main($id, $mode)
++ 	{
++ 		global $phpbb_container;
++-
++ 		$this->cache = $phpbb_container->get('cache.driver');
++ 		$this->config = $phpbb_container->get('config');
++ 		$this->db = $phpbb_container->get('dbal.conn');
++@@ -72,88 +72,63 @@ class discord_notifications_module
++ 		$this->request = $phpbb_container->get('request');
++ 		$this->template = $phpbb_container->get('template');
++ 		$this->user = $phpbb_container->get('user');
++-		$this->curl_available = extension_loaded('curl');
+++		// Used for sending test messages to Discord
+++		$this->notification_service = $phpbb_container->get('mober.discordnotifications.notification_service');
++ 
++ 		$this->language->add_lang('acp_discord_notifications', 'mober/discordnotifications');
++-		$this->page_title = $this->language->lang('ACP_DISCORD_NOTIFICATIONS');
+++		$this->tpl_name = 'acp_discord_notifications';
+++		$this->page_title = $this->language->lang('ACP_DISCORD_NOTIFICATIONS_TITLE');
++ 
++ 		add_form_key(self::PAGE_FORM_NAME);
++ 
++-		switch ($mode)
+++		// Process submit actions
+++		if ($this->request->is_set_post('action_send_test_message'))
++ 		{
++-			case 'webhooks':
++-				$this->tpl_name = 'acp_discord_notifications_webhooks';
++-
++-				if ($this->request->is_set_post('action_send_test_message'))
++-				{
++-					$this->process_send_test_message();
++-				}
++-				else if ($this->request->is_set_post('action_delete_alias'))
++-				{
++-					$this->process_delete_alias();
++-				}
++-				else if ($this->request->is_set_post('submit'))
++-				{
++-					$this->process_webhooks_form_submit();
++-				}
++-
++-				$this->generate_webhook_section();
++-				break;
++-
++-			case 'mapping':
++-				$this->tpl_name = 'acp_discord_notifications_mapping';
++-
++-				if ($this->request->is_set_post('submit'))
++-				{
++-					$this->process_mapping_form_submit();
++-				}
++-
++-				$this->generate_webhook_section();
++-				$this->generate_forum_section();
++-				break;
+++			$this->process_send_test_message();
+++		}
+++		else if ($this->request->is_set_post('action_delete_alias'))
+++		{
+++			$this->process_delete_alias();
+++		}
+++		else if ($this->request->is_set_post('submit'))
+++		{
+++			$this->process_form_submit();
+++		}
++ 
++-			case 'settings':
++-			default:
++-				$this->tpl_name = 'acp_discord_notifications_settings';
+++		// Generate the dynamic HTML content for enabling/disabling forum notifications
+++		$this->generate_forum_section();
++ 
++-				if ($this->request->is_set_post('submit'))
++-				{
++-					$this->process_settings_form_submit();
++-				}
++-				break;
++-		}
+++		$this->generate_webhook_section();
++ 
++ 		// Assign template values so that the page reflects the state of the extension settings
++-		$this->template->assign_vars([
++-			'DN_MASTER_ENABLE'				=> $this->config['discord_notifications_enabled'],
++-			'DN_POST_PREVIEW_LENGTH'		=> $this->config['discord_notifications_post_preview_length'],
++-			'DN_POST_PREVIEW_DESCRIPTION'	=> sprintf($this->language->lang('DN_POST_PREVIEW_DESCRIPTION'), self::MIN_POST_PREVIEW_LENGTH, self::MAX_POST_PREVIEW_LENGTH),
++-			'DN_TEST_MESSAGE_TEXT'			=> $this->language->lang('DN_TEST_MESSAGE_TEXT'),
++-			'DN_CONNECT_TIMEOUT'			=> $this->config['discord_notifications_connect_timeout'],
++-			'DN_EXEC_TIMEOUT'				=> $this->config['discord_notifications_exec_timeout'],
++-
++-			'DN_POST_CREATE'				=> $this->config['discord_notification_type_post_create'],
++-			'DN_POST_UPDATE'				=> $this->config['discord_notification_type_post_update'],
++-			'DN_POST_DELETE'				=> $this->config['discord_notification_type_post_delete'],
++-			'DN_POST_LOCK'					=> $this->config['discord_notification_type_post_lock'],
++-			'DN_POST_UNLOCK'				=> $this->config['discord_notification_type_post_unlock'],
++-			'DN_POST_APPROVE'				=> $this->config['discord_notification_type_post_approve'],
++-
++-			'DN_TOPIC_CREATE'				=> $this->config['discord_notification_type_topic_create'],
++-			'DN_TOPIC_UPDATE'				=> $this->config['discord_notification_type_topic_update'],
++-			'DN_TOPIC_DELETE'				=> $this->config['discord_notification_type_topic_delete'],
++-			'DN_TOPIC_LOCK'					=> $this->config['discord_notification_type_topic_lock'],
++-			'DN_TOPIC_UNLOCK'				=> $this->config['discord_notification_type_topic_unlock'],
++-			'DN_TOPIC_APPROVE'				=> $this->config['discord_notification_type_topic_approve'],
++-
++-			'DN_USER_CREATE'				=> $this->config['discord_notification_type_user_create'],
++-			'DN_USER_DELETE'				=> $this->config['discord_notification_type_user_delete'],
++-
++-			'DN_DEFAULT_WEBHOOK'			=> $this->config['discord_notification_default_webhook'],
++-
++-			'DN_CURL_AVAILABLE'				=> $this->curl_available,
++-			'U_ACTION'						=> $this->u_action,
++-		]);
+++		$this->template->assign_vars(array(
+++			'DN_MASTER_ENABLE'			=> $this->config['discord_notifications_enabled'],
+++			'DN_POST_PREVIEW_LENGTH'	=> $this->config['discord_notifications_post_preview_length'],
+++			'DN_TEST_MESSAGE_TEXT'		=> $this->language->lang('DN_TEST_MESSAGE_TEXT'),
+++			'DN_CONNECT_TIMEOUT'		=> $this->config['discord_notifications_connect_timeout'],
+++			'DN_EXEC_TIMEOUT'			=> $this->config['discord_notifications_exec_timeout'],
+++
+++			'DN_POST_CREATE'			=> $this->config['discord_notification_type_post_create'],
+++			'DN_POST_UPDATE'			=> $this->config['discord_notification_type_post_update'],
+++			'DN_POST_DELETE'			=> $this->config['discord_notification_type_post_delete'],
+++			'DN_POST_LOCK'				=> $this->config['discord_notification_type_post_lock'],
+++			'DN_POST_UNLOCK'			=> $this->config['discord_notification_type_post_unlock'],
+++			'DN_POST_APPROVE'			=> $this->config['discord_notification_type_post_approve'],
+++
+++			'DN_TOPIC_CREATE'			=> $this->config['discord_notification_type_topic_create'],
+++			'DN_TOPIC_UPDATE'			=> $this->config['discord_notification_type_topic_update'],
+++			'DN_TOPIC_DELETE'			=> $this->config['discord_notification_type_topic_delete'],
+++			'DN_TOPIC_LOCK'				=> $this->config['discord_notification_type_topic_lock'],
+++			'DN_TOPIC_UNLOCK'			=> $this->config['discord_notification_type_topic_unlock'],
+++			'DN_TOPIC_APPROVE'			=> $this->config['discord_notification_type_topic_approve'],
+++
+++			'DN_USER_CREATE'			=> $this->config['discord_notification_type_user_create'],
+++			'DN_USER_DELETE'			=> $this->config['discord_notification_type_user_delete'],
+++
+++			'DN_DEFAULT_WEBHOOK'		=> $this->config['discord_notification_default_webhook'],
+++
+++			'U_ACTION'					=> $this->u_action,
+++		));
++ 	}
++ 
++ 	/**
++@@ -184,12 +159,10 @@ class discord_notifications_module
++ 	 */
++ 	private function process_send_test_message()
++ 	{
++-		global $table_prefix, $phpbb_container;
++-
++-		$this->validate_post_request();
+++		global $table_prefix;
++ 
++ 		$webhook = $this->request->variable('dn_test_webhook', '', true);
++-		$test_message = $this->request->variable('dn_test_message', '', true);
+++		$test_message = $this->request->variable('dn_test_message', '');
++ 
++ 		// Check user inputs before attempting to send the message
++ 		if ($test_message == '')
++@@ -206,8 +179,7 @@ class discord_notifications_module
++ 		$data = $this->db->sql_fetchrow($result);
++ 		$this->db->sql_freeresult($result);
++ 
++-		$notification_service = $phpbb_container->get('mober.discordnotifications.notification_service');
++-		$result = $notification_service->force_send_discord_notification($data['url'], $test_message);
+++		$result = $this->notification_service->force_send_discord_notification($data['url'], $test_message);
++ 		if ($result)
++ 		{
++ 			trigger_error($this->language->lang('DN_TEST_SUCCESS') . adm_back_link($this->u_action));
++@@ -222,7 +194,10 @@ class discord_notifications_module
++ 	{
++ 		global $table_prefix;
++ 
++-		$this->validate_post_request();
+++		if (!check_form_key(self::PAGE_FORM_NAME))
+++		{
+++			trigger_error('FORM_INVALID', E_USER_WARNING);
+++		}
++ 
++ 		$delete_alias = $this->request->variable('action_delete_alias',  ['' => ''], true);
++ 		foreach ($delete_alias as $alias => $url)
++@@ -236,9 +211,17 @@ class discord_notifications_module
++ 		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
++ 	}
++ 
++-	private function process_settings_form_submit()
+++	/**
+++	 * Handles all error checking and database changes when the user hits the submit button on the ACP page.
+++	 */
+++	private function process_form_submit()
++ 	{
++-		$this->validate_post_request();
+++		global $table_prefix;
+++
+++		if (!check_form_key(self::PAGE_FORM_NAME))
+++		{
+++			trigger_error('FORM_INVALID', E_USER_WARNING);
+++		}
++ 
++ 		// Get form values for the main settings
++ 		$master_enable = $this->request->variable('dn_master_enable', 0);
++@@ -247,50 +230,14 @@ class discord_notifications_module
++ 		// Verify that the post preview length is a numeric string, convert to an int and check the valid range
++ 		if (!is_numeric($preview_length))
++ 		{
++-			trigger_error(
++-				sprintf(
++-					$this->language->lang('DN_POST_PREVIEW_INVALID'),
++-					self::MIN_POST_PREVIEW_LENGTH,
++-					self::MAX_POST_PREVIEW_LENGTH
++-				) . adm_back_link($this->u_action),
++-				E_USER_WARNING
++-			);
+++			trigger_error($this->language->lang('DN_POST_PREVIEW_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
++ 		}
++ 		$preview_length = (int) $preview_length;
++ 		if ($preview_length != 0 && ($preview_length < self::MIN_POST_PREVIEW_LENGTH || $preview_length > self::MAX_POST_PREVIEW_LENGTH))
++ 		{
++-			trigger_error(
++-				sprintf(
++-					$this->language->lang('DN_POST_PREVIEW_INVALID'),
++-					self::MIN_POST_PREVIEW_LENGTH,
++-					self::MAX_POST_PREVIEW_LENGTH
++-				) . adm_back_link($this->u_action),
++-				E_USER_WARNING
++-			);
+++			trigger_error($this->language->lang('DN_POST_PREVIEW_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
++ 		}
++ 
++-		$connect_timeout = max(1, (int) $this->request->variable('dn_connect_to', 0));
++-		$exec_timeout = max(1, (int) $this->request->variable('dn_exec_to', 0));
++-
++-		$this->config->set('discord_notifications_enabled', $master_enable);
++-		$this->config->set('discord_notifications_post_preview_length', $preview_length);
++-		$this->config->set('discord_notifications_connect_timeout', $connect_timeout);
++-		$this->config->set('discord_notifications_exec_timeout', $exec_timeout);
++-
++-		// Log the settings change
++-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE');
++-		// Destroy any cached discord notification data
++-		$this->cache->destroy('mober_discord_notifications');
++-
++-		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
++-	}
++-
++-	private function process_webhooks_form_submit()
++-	{
++-		global $table_prefix;
++-
++-		$this->validate_post_request();
++-
++ 		// Create new entry
++ 		$new_alias = $this->request->variable('dn_webhook_new_alias', '', true);
++ 		$new_url = $this->request->variable('dn_webhook_new_url', '');
++@@ -320,27 +267,36 @@ class discord_notifications_module
++ 			$this->db->sql_query($sql);
++ 		}
++ 
++-		// Log the settings change
++-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE');
++-		// Destroy any cached discord notification data
++-		$this->cache->destroy('mober_discord_notifications');
++-
++-		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
++-	}
++-
++-	private function process_mapping_form_submit()
++-	{
++-		$this->validate_post_request();
++-
++ 		// Update configuration per forum
++ 		$forum_configuration = $this->request->variable('dn_forum', [0 => ''], true);
++ 		foreach ($forum_configuration as $id => $value)
++ 		{
++-			$sql = "UPDATE " . FORUMS_TABLE . " SET discord_notifications = '" . $this->db->sql_escape($value) .
++-				"' WHERE forum_id = " . (int) $id;
++-			$this->db->sql_query($sql);
+++			// Don't update deleted entries
+++			if ($value === '' || $webhook_configuration[$value] !== '')
+++			{
+++				$sql = "UPDATE " . FORUMS_TABLE . " SET discord_notifications = '" . $this->db->sql_escape($value) .
+++					"' WHERE forum_id = " . (int) $id;
+++				$this->db->sql_query($sql);
+++			}
+++		}
+++
+++		$connect_timeout = (int) $this->request->variable('dn_connect_to', 0);
+++		if ($connect_timeout < 1)
+++		{
+++			$connect_timeout = 1;
++ 		}
++ 
+++		$exec_timeout = (int) $this->request->variable('dn_exec_to', 0);
+++		if ($exec_timeout < 1)
+++		{
+++			$exec_timeout = 1;
+++		}
+++
+++		$this->config->set('discord_notifications_enabled', $master_enable);
+++		$this->config->set('discord_notifications_post_preview_length', $preview_length);
+++		$this->config->set('discord_notifications_connect_timeout', $connect_timeout);
+++		$this->config->set('discord_notifications_exec_timeout', $exec_timeout);
+++
++ 		$this->config->set('discord_notification_type_post_create', $this->request->variable('dn_post_create', 0));
++ 		$this->config->set('discord_notification_type_post_update', $this->request->variable('dn_post_update', 0));
++ 		$this->config->set('discord_notification_type_post_delete', $this->request->variable('dn_post_delete', 0));
++@@ -377,10 +333,10 @@ class discord_notifications_module
++ 
++ 		while ($row = $this->db->sql_fetchrow($result))
++ 		{
++-			$tpl_row = [
+++			$tpl_row = array(
++ 				'ALIAS'	=> $row['alias'],
++ 				'URL'	=> $row['url'],
++-			];
+++			);
++ 			$this->template->assign_block_vars('webhookrow', $tpl_row);
++ 		}
++ 		$this->db->sql_freeresult($result);
++@@ -400,7 +356,7 @@ class discord_notifications_module
++ 
++ 		$sql = "SELECT forum_id, forum_type, forum_name, left_id, right_id, parent_id, forum_parents, discord_notifications
++ 			FROM " . FORUMS_TABLE . "
++-			ORDER BY left_id";
+++			ORDER BY left_id ASC";
++ 		$result = $this->db->sql_query($sql);
++ 
++ 		while ($row = $this->db->sql_fetchrow($result))
++@@ -408,23 +364,23 @@ class discord_notifications_module
++ 			// Category forums are displayed for organizational purposes, but have no configuration
++ 			if ($row['forum_type'] == FORUM_CAT)
++ 			{
++-				$tpl_row = [
+++				$tpl_row = array(
++ 					'S_IS_CAT'		=> true,
++ 					'FORUM_NAME'	=> $row['forum_name'],
++-					'PARENTS'		=> '',
++-				];
+++					'PARENTS'	=> '',
+++				);
++ 				$this->template->assign_block_vars('forumrow', $tpl_row);
++ 			}
++ 			else if ($row['forum_type'] == FORUM_POST)
++ 			{
++ 				// The labels for all the inputs are constructed based on the forum IDs to make it easy to know which
++-				$tpl_row = [
++-					'S_IS_CAT'		=> false,
++-					'FORUM_NAME'	=> $row['forum_name'],
++-					'FORUM_ID'		=> $row['forum_id'],
++-					'ALIAS'			=> $row['discord_notifications'],
++-					'PARENTS'		=> '',
++-				];
+++				$tpl_row = array(
+++							'S_IS_CAT'		=> false,
+++							'FORUM_NAME'	=> $row['forum_name'],
+++							'FORUM_ID'		=> $row['forum_id'],
+++							'ALIAS'			=> $row['discord_notifications'],
+++							'PARENTS'		=> '',
+++						);
++ 				$parents = get_forum_parents($row);
++ 				if (is_array($parents))
++ 				{
++@@ -439,12 +395,4 @@ class discord_notifications_module
++ 		}
++ 		$this->db->sql_freeresult($result);
++ 	}
++-
++-	private function validate_post_request()
++-	{
++-		if (!check_form_key(self::PAGE_FORM_NAME))
++-		{
++-			trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
++-		}
++-	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
++similarity index 63%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
++index e059a8f75..27ee7d868 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
++@@ -1,40 +1,100 @@
++-{% include 'overall_header.html' %}
+++<!-- INCLUDE overall_header.html -->
++ 
++ <h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
++ 
++-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
++-
++-{% if not DN_CURL_AVAILABLE %}
++-	<div class="errorbox">
++-		<p>{{ lang('DN_MISSING_CURL') }}</p>
++-	</div>
++-{% endif %}
+++<p>{{ DN_ACP_DESCRIPTION }}</p>
++ 
++ <form id="acp_board" method="post" action="{{ U_ACTION }}">
++ 
++ 	<fieldset>
++-		<legend>{{ lang('DN_WEBHOOK_DEFAULT') }}</legend>
+++		<legend>{{ lang('DN_MAIN_SETTINGS') }}</legend>
++ 		<dl>
++-			<dt><label>{{ lang('DN_USER_CREATE') }}{{ lang('COLON') }}</label></dt>
++-			<dd><label><input type="radio" class="radio" name="dn_user_create" value="1" {% if DN_USER_CREATE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="dn_user_create" value="0" {% if not DN_USER_CREATE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++			<dt><label>{{ lang('DN_MASTER_ENABLE') }}{{ lang('COLON') }}</label></dt>
+++			<dd><label><input type="radio" class="radio" name="dn_master_enable" value="1" {% if DN_MASTER_ENABLE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="dn_master_enable" value="0" {% if not DN_MASTER_ENABLE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label>{{ lang('DN_USER_DELETE') }}{{ lang('COLON') }}</label></dt>
++-			<dd><label><input type="radio" class="radio" name="dn_user_delete" value="1" {% if DN_USER_DELETE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="dn_user_delete" value="0" {% if not DN_USER_DELETE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++			<dt><label for="dn_post_preview_length">{{ lang('DN_POST_PREVIEW_LENGTH') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_POST_PREVIEW_DESCRIPTION') }}</span></dt>
+++			<dd>
+++				<input id="dn_post_preview_length" name="dn_post_preview_length" type="text" value="{{ DN_POST_PREVIEW_LENGTH }}" size="4" maxlength="4" />
+++			</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="dn_webhook_default">{{ lang('DN_WEBHOOK_DEFAULT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_DEFAULT_DESCRIPTION') }}</span></dt>
+++			<dt><label for="dn_connect_to">{{ lang('DN_CONNECT_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_CONNECT_TO_DESCRIPTION') }}</span></dt>
++ 			<dd>
++-				<select id="dn_webhook_default" name="dn_webhook_default">
++-					<option value="">({{ lang('DISABLED') }})</option>
+++				<input id="dn_connect_to" name="dn_connect_to" type="text" value="{{ DN_CONNECT_TIMEOUT }}" size="4" maxlength="4" />
+++			</dd>
+++		</dl>
+++		<dl>
+++			<dt><label for="dn_exec_to">{{ lang('DN_EXEC_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_EXEC_TO_DESCRIPTION') }}</span></dt>
+++			<dd>
+++				<input id="dn_exec_to" name="dn_exec_to" type="text" value="{{ DN_EXEC_TIMEOUT }}" size="4" maxlength="4" />
+++			</dd>
+++		</dl>
+++	</fieldset>
+++
+++	<fieldset>
+++		<legend>{{ lang('DN_WEBHOOK_SETTINGS') }}</legend>
+++		<p>{{ lang('DN_WEBHOOK_SETTINGS_DESCRIPTION') }}</p>
+++		{% if loops.webhookrow %}
+++			{% for webhook in loops.webhookrow %}
+++				<dl>
+++					<dt><label for="dn_webhook_{{ webhook.ALIAS }}">{{ webhook.ALIAS }}</label></dt>
+++					<dd>
+++						<input type="text" size="100" maxlength="255" id="dn_webhook_{{ webhook.ALIAS }}" name="dn_webhook[{{ webhook.ALIAS }}]" value="{{ webhook.URL }}" />
+++						<input type="submit" name="action_delete_alias[{{ webhook.ALIAS }}]" value="{{ lang('DELETE') }}" class="button2" onclick="return confirm('{{ lang('CONFIRM_OPERATION') }}');">
+++					</dd>
+++				</dl>
+++			{% endfor %}
+++		{% else %}
+++			<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
+++		{% endif %}
+++	</fieldset>
+++
+++	<fieldset>
+++		<legend>{{ lang('DN_WEBHOOK_NEW') }}</legend>
+++		<p>{{ lang('DN_WEBHOOK_NEW_DESCRIPTION') }}</p>
+++		<dl>
+++			<dt><label for="dn_webhook_new_alias">{{ lang('DN_WEBHOOK_NEW_ALIAS') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_ALIAS_DESCRIPTION') }}</span></dt>
+++			<dd>
+++				<input id="dn_webhook_new_alias" name="dn_webhook_new_alias" type="text" value="" size="100" maxlength="255" />
+++			</dd>
+++		</dl>
+++		<dl>
+++			<dt><label for="dn_webhook_new_url">{{ lang('DN_WEBHOOK_NEW_URL') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_URL_DESCRIPTION') }}</span></dt>
+++			<dd>
+++				<input id="dn_webhook_new_url" name="dn_webhook_new_url" type="text" value="" size="100" maxlength="255" />
+++			</dd>
+++		</dl>
+++	</fieldset>
+++
+++	<fieldset>
+++		<legend>{{ lang('DN_TEST_SETTINGS') }}</legend>
+++		<dl>
+++			<dt><label for="dn_test_message">{{ lang('DN_TEST_MESSAGE') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_TEST_DESCRIPTION') }}</span></dt>
+++			<dd>
+++				<input id="dn_test_message" name="dn_test_message" type="text" value="{{ DN_TEST_MESSAGE_TEXT }}" size="100" maxlength="255" />
+++			</dd>
+++		</dl>
+++		{% if loops.webhookrow %}
+++		<dl>
+++			<dt><label for="dn_test_webhook">{{ lang('DN_WEBHOOK_SELECT') }}{{ lang('COLON') }}</label><br /></dt>
+++			<dd>
+++				<select id="dn_test_webhook" name="dn_test_webhook">
+++					<option value="">{{ lang('DN_WEBHOOK_SELECT') }}</option>
++ 					{% for webhook in loops.webhookrow %}
++-						<option value="{{ webhook.ALIAS }}"{% if DN_DEFAULT_WEBHOOK == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
+++					<option value="{{ webhook.ALIAS }}"{% if forumrow.ALIAS == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
++ 					{% endfor %}
++ 				</select>
++ 			</dd>
++ 		</dl>
+++		<dl>
+++			<dt><label for="action_send_test_message">{{ lang('DN_SEND_TEST') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_SEND_TEST_DESCRIPTION') }}</span></dt>
+++			<dd><input class="button2" type="submit" id="action_send_test_message" name="action_send_test_message" value="{{ lang('DN_SEND_TEST') }}" /></dd>
+++		</dl>
+++		{% else %}
+++		<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
+++		{% endif %}
++ 	</fieldset>
++ 
++ 	<fieldset>
++@@ -100,6 +160,27 @@
++ 			<dd><label><input type="radio" class="radio" name="dn_topic_approve" value="1" {% if DN_TOPIC_APPROVE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++ 				<label><input type="radio" class="radio" name="dn_topic_approve" value="0" {% if not DN_TOPIC_APPROVE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 		</dl>
+++		<dl>
+++			<dt><label>{{ lang('DN_USER_CREATE') }}{{ lang('COLON') }}</label></dt>
+++			<dd><label><input type="radio" class="radio" name="dn_user_create" value="1" {% if DN_USER_CREATE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="dn_user_create" value="0" {% if not DN_USER_CREATE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++		</dl>
+++		<dl>
+++			<dt><label>{{ lang('DN_USER_DELETE') }}{{ lang('COLON') }}</label></dt>
+++			<dd><label><input type="radio" class="radio" name="dn_user_delete" value="1" {% if DN_USER_DELETE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="dn_user_delete" value="0" {% if not DN_USER_DELETE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++		</dl>
+++		<dl>
+++			<dt><label for="dn_webhook_default">{{ lang('DN_WEBHOOK_DEFAULT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_DEFAULT_DESCRIPTION') }}</span></dt>
+++			<dd>
+++				<select id="dn_webhook_default" name="dn_webhook_default">
+++					<option value="">({{ lang('DISABLED') }})</option>
+++					{% for webhook in loops.webhookrow %}
+++					<option value="{{ webhook.ALIAS }}"{% if DN_DEFAULT_WEBHOOK == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
+++					{% endfor %}
+++				</select>
+++			</dd>
+++		</dl>
++ 	</fieldset>
++ 
++ 	<fieldset>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html"
++deleted file mode 100644
++index 90eed3ee7..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html"
+++++ /dev/null
++@@ -1,49 +0,0 @@
++-{% include 'overall_header.html' %}
++-
++-<h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
++-
++-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
++-
++-{% if not DN_CURL_AVAILABLE %}
++-	<div class="errorbox">
++-		<p>{{ lang('DN_MISSING_CURL') }}</p>
++-	</div>
++-{% endif %}
++-
++-<form id="acp_board" method="post" action="{{ U_ACTION }}">
++-
++-	<fieldset>
++-		<legend>{{ lang('DN_MAIN_SETTINGS') }}</legend>
++-		<dl>
++-			<dt><label>{{ lang('DN_MASTER_ENABLE') }}{{ lang('COLON') }}</label></dt>
++-			<dd><label><input type="radio" class="radio" name="dn_master_enable" value="1" {% if DN_MASTER_ENABLE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="dn_master_enable" value="0" {% if not DN_MASTER_ENABLE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++-		</dl>
++-		<dl>
++-			<dt><label for="dn_post_preview_length">{{ lang('DN_POST_PREVIEW_LENGTH') }}{{ lang('COLON') }}</label><br /><span>{{ DN_POST_PREVIEW_DESCRIPTION }}</span></dt>
++-			<dd>
++-				<input id="dn_post_preview_length" name="dn_post_preview_length" type="text" value="{{ DN_POST_PREVIEW_LENGTH }}" size="4" maxlength="4" />
++-			</dd>
++-		</dl>
++-		<dl>
++-			<dt><label for="dn_connect_to">{{ lang('DN_CONNECT_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_CONNECT_TO_DESCRIPTION') }}</span></dt>
++-			<dd>
++-				<input id="dn_connect_to" name="dn_connect_to" type="text" value="{{ DN_CONNECT_TIMEOUT }}" size="4" maxlength="4" />
++-			</dd>
++-		</dl>
++-		<dl>
++-			<dt><label for="dn_exec_to">{{ lang('DN_EXEC_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_EXEC_TO_DESCRIPTION') }}</span></dt>
++-			<dd>
++-				<input id="dn_exec_to" name="dn_exec_to" type="text" value="{{ DN_EXEC_TIMEOUT }}" size="4" maxlength="4" />
++-			</dd>
++-		</dl>
++-	</fieldset>
++-
++-	<fieldset class="submit-buttons">
++-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++-		{{ S_FORM_TOKEN }}
++-	</fieldset>
++-
++-</form>
++-
++-{% include 'overall_footer.html' %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html"
++deleted file mode 100644
++index a500594a6..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html"
+++++ /dev/null
++@@ -1,86 +0,0 @@
++-{% include 'overall_header.html' %}
++-
++-<h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
++-
++-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
++-
++-{% if not DN_CURL_AVAILABLE %}
++-	<div class="errorbox">
++-		<p>{{ lang('DN_MISSING_CURL') }}</p>
++-	</div>
++-{% endif %}
++-
++-<form id="acp_board" method="post" action="{{ U_ACTION }}">
++-
++-	<fieldset>
++-		<legend>{{ lang('DN_WEBHOOK_SETTINGS') }}</legend>
++-		<p>{{ lang('DN_WEBHOOK_SETTINGS_DESCRIPTION') }}</p>
++-		{% if loops.webhookrow %}
++-			{% for webhook in loops.webhookrow %}
++-				<dl>
++-					<dt><label for="dn_webhook_{{ webhook.ALIAS }}">{{ webhook.ALIAS }}</label></dt>
++-					<dd>
++-						<input type="text" size="100" maxlength="255" id="dn_webhook_{{ webhook.ALIAS }}" name="dn_webhook[{{ webhook.ALIAS }}]" value="{{ webhook.URL }}" />
++-						<input type="submit" name="action_delete_alias[{{ webhook.ALIAS }}]" value="{{ lang('DELETE') }}" class="button2" onclick="return confirm('{{ lang('CONFIRM_OPERATION') }}');">
++-					</dd>
++-				</dl>
++-			{% endfor %}
++-		{% else %}
++-			<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
++-		{% endif %}
++-	</fieldset>
++-
++-	<fieldset>
++-		<legend>{{ lang('DN_WEBHOOK_NEW') }}</legend>
++-		<p>{{ lang('DN_WEBHOOK_NEW_DESCRIPTION') }}</p>
++-		<dl>
++-			<dt><label for="dn_webhook_new_alias">{{ lang('DN_WEBHOOK_NEW_ALIAS') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_ALIAS_DESCRIPTION') }}</span></dt>
++-			<dd>
++-				<input id="dn_webhook_new_alias" name="dn_webhook_new_alias" type="text" value="" size="100" maxlength="255" />
++-			</dd>
++-		</dl>
++-		<dl>
++-			<dt><label for="dn_webhook_new_url">{{ lang('DN_WEBHOOK_NEW_URL') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_URL_DESCRIPTION') }}</span></dt>
++-			<dd>
++-				<input id="dn_webhook_new_url" name="dn_webhook_new_url" type="text" value="" size="100" maxlength="255" />
++-			</dd>
++-		</dl>
++-	</fieldset>
++-
++-	<fieldset>
++-		<legend>{{ lang('DN_TEST_SETTINGS') }}</legend>
++-		{% if loops.webhookrow %}
++-		<dl>
++-			<dt><label for="dn_test_message">{{ lang('DN_TEST_MESSAGE') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_TEST_DESCRIPTION') }}</span></dt>
++-			<dd>
++-				<input id="dn_test_message" name="dn_test_message" type="text" value="{{ DN_TEST_MESSAGE_TEXT }}" size="100" maxlength="255" />
++-			</dd>
++-		</dl>
++-		<dl>
++-			<dt><label for="dn_test_webhook">{{ lang('DN_WEBHOOK_SELECT') }}{{ lang('COLON') }}</label><br /></dt>
++-			<dd>
++-				<select id="dn_test_webhook" name="dn_test_webhook">
++-					<option value="">{{ lang('DN_WEBHOOK_SELECT') }}</option>
++-					{% for webhook in loops.webhookrow %}
++-					<option value="{{ webhook.ALIAS }}"{% if forumrow.ALIAS == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
++-					{% endfor %}
++-				</select>
++-			</dd>
++-		</dl>
++-		<dl>
++-			<dt><label for="action_send_test_message">{{ lang('DN_SEND_TEST') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_SEND_TEST_DESCRIPTION') }}</span></dt>
++-			<dd><input class="button2" type="submit" id="action_send_test_message" name="action_send_test_message" value="{{ lang('DN_SEND_TEST') }}" /></dd>
++-		</dl>
++-		{% else %}
++-		<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
++-		{% endif %}
++-	</fieldset>
++-
++-	<fieldset class="submit-buttons">
++-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++-		{{ S_FORM_TOKEN }}
++-	</fieldset>
++-
++-</form>
++-
++-{% include 'overall_footer.html' %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/composer.json"
++index b9f060cfe..31a9c730b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/composer.json"
++@@ -3,7 +3,7 @@
++     "type": "phpbb-extension",
++     "description": "Publishes forum event notifications to a Discord server channel",
++     "homepage": "https://github.com/m-ober/phpbb-discord-notifications",
++-    "version": "3.0.8",
+++    "version": "3.0.7",
++     "keywords": [
++         "phpbb",
++         "extension",
++@@ -24,15 +24,15 @@
++         }
++     ],
++     "require": {
++-        "php": ">=7.2",
+++        "php": ">=7.1",
++         "ext-curl": "*",
++         "composer/installers": "~1.0.0",
++-        "phpbb/phpbb": ">=3.3.11"
+++        "phpbb/phpbb": ">=3.3.0"
++     },
++     "extra": {
++         "display-name": "Discord Notifications",
++         "soft-require": {
++-            "phpbb/phpbb": ">=3.3.11"
+++            "phpbb/phpbb": ">=3.3.0"
++         },
++         "version-check": {
++             "host": "www.phpbb.com",
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/diff_full.tmp"
++new file mode 100644
++index 000000000..137227b18
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/diff_full.tmp"
++@@ -0,0 +1,733 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
+++index 0283d968d..27cf0e844 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_info.php"
+++@@ -2,8 +2,8 @@
+++ /**
+++  * Discord Notifications extension for the phpBB Forum Software package.
+++  *
+++- * @copyright (c)	2018, Tyler Olsen, https://github.com/rootslinux
+++- * @license			GNU General Public License, version 2 (GPL-2.0)
++++ * @copyright (c) 2018, Tyler Olsen, https://github.com/rootslinux
++++ * @license GNU General Public License, version 2 (GPL-2.0)
+++  */
+++ 
+++ namespace mober\discordnotifications\acp;
+++@@ -15,26 +15,16 @@ class discord_notifications_info
+++ {
+++ 	public function module()
+++ 	{
+++-		return [
++++		return array(
+++ 			'filename'	=> '\mober\discordnotifications\acp\discord_notifications_module',
+++ 			'title'		=> 'ACP_DISCORD_NOTIFICATIONS',
+++-			'modes'		=> [
+++-				'settings'	=> [
+++-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_SETTINGS',
++++			'modes'		=> array(
++++				'settings'	=> array(
++++					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_TITLE',
+++ 					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
+++-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
+++-				],
+++-				'webhooks'	=> [
+++-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS',
+++-					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
+++-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
+++-				],
+++-				'mapping'	=> [
+++-					'title'	=> 'ACP_DISCORD_NOTIFICATIONS_MAPPING',
+++-					'auth'	=> 'ext_mober/discordnotifications && acl_a_board',
+++-					'cat'	=> ['ACP_DISCORD_NOTIFICATIONS'],
+++-				],
+++-			],
+++-		];
++++					'cat'	=> array('ACP_DISCORD_NOTIFICATIONS')
++++				),
++++			),
++++		);
+++ 	}
+++ }
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
+++index bd7741639..fb82cbbad 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/acp/discord_notifications_module.php"
+++@@ -18,8 +18,9 @@ class discord_notifications_module
+++ 	const MIN_POST_PREVIEW_LENGTH = 10;
+++ 
+++ 	// The maximum number of characters that the user can set for the post preview setting.
+++-	// See: https://discord.com/developers/docs/resources/channel#embed-object-embed-limits
+++-	const MAX_POST_PREVIEW_LENGTH = 1024;
++++	// Note that this is slightly less than the actual allowed maximum by Discord (2048), but we reserve
++++	// some space to prepend the preview text with something like "Preview: " or "Reason: "
++++	const MAX_POST_PREVIEW_LENGTH = 2000;
+++ 
+++ 	// The name for the form used for this page
+++ 	const PAGE_FORM_NAME = 'acp_mober_discord_notifications';
+++@@ -48,6 +49,9 @@ class discord_notifications_module
+++ 	/** @var \phpbb\log\log */
+++ 	protected $log;
+++ 
++++	/** @var \mober\discordnotifications\notification_service */
++++	protected $notification_service;
++++
+++ 	/** @var \phpbb\request\request */
+++ 	protected $request;
+++ 
+++@@ -57,13 +61,9 @@ class discord_notifications_module
+++ 	/** @var \phpbb\user */
+++ 	protected $user;
+++ 
+++-	/** @var bool */
+++-	private  $curl_available;
+++-
+++ 	public function main($id, $mode)
+++ 	{
+++ 		global $phpbb_container;
+++-
+++ 		$this->cache = $phpbb_container->get('cache.driver');
+++ 		$this->config = $phpbb_container->get('config');
+++ 		$this->db = $phpbb_container->get('dbal.conn');
+++@@ -72,88 +72,63 @@ class discord_notifications_module
+++ 		$this->request = $phpbb_container->get('request');
+++ 		$this->template = $phpbb_container->get('template');
+++ 		$this->user = $phpbb_container->get('user');
+++-		$this->curl_available = extension_loaded('curl');
++++		// Used for sending test messages to Discord
++++		$this->notification_service = $phpbb_container->get('mober.discordnotifications.notification_service');
+++ 
+++ 		$this->language->add_lang('acp_discord_notifications', 'mober/discordnotifications');
+++-		$this->page_title = $this->language->lang('ACP_DISCORD_NOTIFICATIONS');
++++		$this->tpl_name = 'acp_discord_notifications';
++++		$this->page_title = $this->language->lang('ACP_DISCORD_NOTIFICATIONS_TITLE');
+++ 
+++ 		add_form_key(self::PAGE_FORM_NAME);
+++ 
+++-		switch ($mode)
++++		// Process submit actions
++++		if ($this->request->is_set_post('action_send_test_message'))
+++ 		{
+++-			case 'webhooks':
+++-				$this->tpl_name = 'acp_discord_notifications_webhooks';
+++-
+++-				if ($this->request->is_set_post('action_send_test_message'))
+++-				{
+++-					$this->process_send_test_message();
+++-				}
+++-				else if ($this->request->is_set_post('action_delete_alias'))
+++-				{
+++-					$this->process_delete_alias();
+++-				}
+++-				else if ($this->request->is_set_post('submit'))
+++-				{
+++-					$this->process_webhooks_form_submit();
+++-				}
+++-
+++-				$this->generate_webhook_section();
+++-				break;
+++-
+++-			case 'mapping':
+++-				$this->tpl_name = 'acp_discord_notifications_mapping';
+++-
+++-				if ($this->request->is_set_post('submit'))
+++-				{
+++-					$this->process_mapping_form_submit();
+++-				}
+++-
+++-				$this->generate_webhook_section();
+++-				$this->generate_forum_section();
+++-				break;
++++			$this->process_send_test_message();
++++		}
++++		else if ($this->request->is_set_post('action_delete_alias'))
++++		{
++++			$this->process_delete_alias();
++++		}
++++		else if ($this->request->is_set_post('submit'))
++++		{
++++			$this->process_form_submit();
++++		}
+++ 
+++-			case 'settings':
+++-			default:
+++-				$this->tpl_name = 'acp_discord_notifications_settings';
++++		// Generate the dynamic HTML content for enabling/disabling forum notifications
++++		$this->generate_forum_section();
+++ 
+++-				if ($this->request->is_set_post('submit'))
+++-				{
+++-					$this->process_settings_form_submit();
+++-				}
+++-				break;
+++-		}
++++		$this->generate_webhook_section();
+++ 
+++ 		// Assign template values so that the page reflects the state of the extension settings
+++-		$this->template->assign_vars([
+++-			'DN_MASTER_ENABLE'				=> $this->config['discord_notifications_enabled'],
+++-			'DN_POST_PREVIEW_LENGTH'		=> $this->config['discord_notifications_post_preview_length'],
+++-			'DN_POST_PREVIEW_DESCRIPTION'	=> sprintf($this->language->lang('DN_POST_PREVIEW_DESCRIPTION'), self::MIN_POST_PREVIEW_LENGTH, self::MAX_POST_PREVIEW_LENGTH),
+++-			'DN_TEST_MESSAGE_TEXT'			=> $this->language->lang('DN_TEST_MESSAGE_TEXT'),
+++-			'DN_CONNECT_TIMEOUT'			=> $this->config['discord_notifications_connect_timeout'],
+++-			'DN_EXEC_TIMEOUT'				=> $this->config['discord_notifications_exec_timeout'],
+++-
+++-			'DN_POST_CREATE'				=> $this->config['discord_notification_type_post_create'],
+++-			'DN_POST_UPDATE'				=> $this->config['discord_notification_type_post_update'],
+++-			'DN_POST_DELETE'				=> $this->config['discord_notification_type_post_delete'],
+++-			'DN_POST_LOCK'					=> $this->config['discord_notification_type_post_lock'],
+++-			'DN_POST_UNLOCK'				=> $this->config['discord_notification_type_post_unlock'],
+++-			'DN_POST_APPROVE'				=> $this->config['discord_notification_type_post_approve'],
+++-
+++-			'DN_TOPIC_CREATE'				=> $this->config['discord_notification_type_topic_create'],
+++-			'DN_TOPIC_UPDATE'				=> $this->config['discord_notification_type_topic_update'],
+++-			'DN_TOPIC_DELETE'				=> $this->config['discord_notification_type_topic_delete'],
+++-			'DN_TOPIC_LOCK'					=> $this->config['discord_notification_type_topic_lock'],
+++-			'DN_TOPIC_UNLOCK'				=> $this->config['discord_notification_type_topic_unlock'],
+++-			'DN_TOPIC_APPROVE'				=> $this->config['discord_notification_type_topic_approve'],
+++-
+++-			'DN_USER_CREATE'				=> $this->config['discord_notification_type_user_create'],
+++-			'DN_USER_DELETE'				=> $this->config['discord_notification_type_user_delete'],
+++-
+++-			'DN_DEFAULT_WEBHOOK'			=> $this->config['discord_notification_default_webhook'],
+++-
+++-			'DN_CURL_AVAILABLE'				=> $this->curl_available,
+++-			'U_ACTION'						=> $this->u_action,
+++-		]);
++++		$this->template->assign_vars(array(
++++			'DN_MASTER_ENABLE'			=> $this->config['discord_notifications_enabled'],
++++			'DN_POST_PREVIEW_LENGTH'	=> $this->config['discord_notifications_post_preview_length'],
++++			'DN_TEST_MESSAGE_TEXT'		=> $this->language->lang('DN_TEST_MESSAGE_TEXT'),
++++			'DN_CONNECT_TIMEOUT'		=> $this->config['discord_notifications_connect_timeout'],
++++			'DN_EXEC_TIMEOUT'			=> $this->config['discord_notifications_exec_timeout'],
++++
++++			'DN_POST_CREATE'			=> $this->config['discord_notification_type_post_create'],
++++			'DN_POST_UPDATE'			=> $this->config['discord_notification_type_post_update'],
++++			'DN_POST_DELETE'			=> $this->config['discord_notification_type_post_delete'],
++++			'DN_POST_LOCK'				=> $this->config['discord_notification_type_post_lock'],
++++			'DN_POST_UNLOCK'			=> $this->config['discord_notification_type_post_unlock'],
++++			'DN_POST_APPROVE'			=> $this->config['discord_notification_type_post_approve'],
++++
++++			'DN_TOPIC_CREATE'			=> $this->config['discord_notification_type_topic_create'],
++++			'DN_TOPIC_UPDATE'			=> $this->config['discord_notification_type_topic_update'],
++++			'DN_TOPIC_DELETE'			=> $this->config['discord_notification_type_topic_delete'],
++++			'DN_TOPIC_LOCK'				=> $this->config['discord_notification_type_topic_lock'],
++++			'DN_TOPIC_UNLOCK'			=> $this->config['discord_notification_type_topic_unlock'],
++++			'DN_TOPIC_APPROVE'			=> $this->config['discord_notification_type_topic_approve'],
++++
++++			'DN_USER_CREATE'			=> $this->config['discord_notification_type_user_create'],
++++			'DN_USER_DELETE'			=> $this->config['discord_notification_type_user_delete'],
++++
++++			'DN_DEFAULT_WEBHOOK'		=> $this->config['discord_notification_default_webhook'],
++++
++++			'U_ACTION'					=> $this->u_action,
++++		));
+++ 	}
+++ 
+++ 	/**
+++@@ -184,12 +159,10 @@ class discord_notifications_module
+++ 	 */
+++ 	private function process_send_test_message()
+++ 	{
+++-		global $table_prefix, $phpbb_container;
+++-
+++-		$this->validate_post_request();
++++		global $table_prefix;
+++ 
+++ 		$webhook = $this->request->variable('dn_test_webhook', '', true);
+++-		$test_message = $this->request->variable('dn_test_message', '', true);
++++		$test_message = $this->request->variable('dn_test_message', '');
+++ 
+++ 		// Check user inputs before attempting to send the message
+++ 		if ($test_message == '')
+++@@ -206,8 +179,7 @@ class discord_notifications_module
+++ 		$data = $this->db->sql_fetchrow($result);
+++ 		$this->db->sql_freeresult($result);
+++ 
+++-		$notification_service = $phpbb_container->get('mober.discordnotifications.notification_service');
+++-		$result = $notification_service->force_send_discord_notification($data['url'], $test_message);
++++		$result = $this->notification_service->force_send_discord_notification($data['url'], $test_message);
+++ 		if ($result)
+++ 		{
+++ 			trigger_error($this->language->lang('DN_TEST_SUCCESS') . adm_back_link($this->u_action));
+++@@ -222,7 +194,10 @@ class discord_notifications_module
+++ 	{
+++ 		global $table_prefix;
+++ 
+++-		$this->validate_post_request();
++++		if (!check_form_key(self::PAGE_FORM_NAME))
++++		{
++++			trigger_error('FORM_INVALID', E_USER_WARNING);
++++		}
+++ 
+++ 		$delete_alias = $this->request->variable('action_delete_alias',  ['' => ''], true);
+++ 		foreach ($delete_alias as $alias => $url)
+++@@ -236,9 +211,17 @@ class discord_notifications_module
+++ 		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
+++ 	}
+++ 
+++-	private function process_settings_form_submit()
++++	/**
++++	 * Handles all error checking and database changes when the user hits the submit button on the ACP page.
++++	 */
++++	private function process_form_submit()
+++ 	{
+++-		$this->validate_post_request();
++++		global $table_prefix;
++++
++++		if (!check_form_key(self::PAGE_FORM_NAME))
++++		{
++++			trigger_error('FORM_INVALID', E_USER_WARNING);
++++		}
+++ 
+++ 		// Get form values for the main settings
+++ 		$master_enable = $this->request->variable('dn_master_enable', 0);
+++@@ -247,50 +230,14 @@ class discord_notifications_module
+++ 		// Verify that the post preview length is a numeric string, convert to an int and check the valid range
+++ 		if (!is_numeric($preview_length))
+++ 		{
+++-			trigger_error(
+++-				sprintf(
+++-					$this->language->lang('DN_POST_PREVIEW_INVALID'),
+++-					self::MIN_POST_PREVIEW_LENGTH,
+++-					self::MAX_POST_PREVIEW_LENGTH
+++-				) . adm_back_link($this->u_action),
+++-				E_USER_WARNING
+++-			);
++++			trigger_error($this->language->lang('DN_POST_PREVIEW_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
+++ 		}
+++ 		$preview_length = (int) $preview_length;
+++ 		if ($preview_length != 0 && ($preview_length < self::MIN_POST_PREVIEW_LENGTH || $preview_length > self::MAX_POST_PREVIEW_LENGTH))
+++ 		{
+++-			trigger_error(
+++-				sprintf(
+++-					$this->language->lang('DN_POST_PREVIEW_INVALID'),
+++-					self::MIN_POST_PREVIEW_LENGTH,
+++-					self::MAX_POST_PREVIEW_LENGTH
+++-				) . adm_back_link($this->u_action),
+++-				E_USER_WARNING
+++-			);
++++			trigger_error($this->language->lang('DN_POST_PREVIEW_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
+++ 		}
+++ 
+++-		$connect_timeout = max(1, (int) $this->request->variable('dn_connect_to', 0));
+++-		$exec_timeout = max(1, (int) $this->request->variable('dn_exec_to', 0));
+++-
+++-		$this->config->set('discord_notifications_enabled', $master_enable);
+++-		$this->config->set('discord_notifications_post_preview_length', $preview_length);
+++-		$this->config->set('discord_notifications_connect_timeout', $connect_timeout);
+++-		$this->config->set('discord_notifications_exec_timeout', $exec_timeout);
+++-
+++-		// Log the settings change
+++-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE');
+++-		// Destroy any cached discord notification data
+++-		$this->cache->destroy('mober_discord_notifications');
+++-
+++-		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
+++-	}
+++-
+++-	private function process_webhooks_form_submit()
+++-	{
+++-		global $table_prefix;
+++-
+++-		$this->validate_post_request();
+++-
+++ 		// Create new entry
+++ 		$new_alias = $this->request->variable('dn_webhook_new_alias', '', true);
+++ 		$new_url = $this->request->variable('dn_webhook_new_url', '');
+++@@ -320,27 +267,36 @@ class discord_notifications_module
+++ 			$this->db->sql_query($sql);
+++ 		}
+++ 
+++-		// Log the settings change
+++-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE');
+++-		// Destroy any cached discord notification data
+++-		$this->cache->destroy('mober_discord_notifications');
+++-
+++-		trigger_error($this->language->lang('DN_SETTINGS_SAVED') . adm_back_link($this->u_action));
+++-	}
+++-
+++-	private function process_mapping_form_submit()
+++-	{
+++-		$this->validate_post_request();
+++-
+++ 		// Update configuration per forum
+++ 		$forum_configuration = $this->request->variable('dn_forum', [0 => ''], true);
+++ 		foreach ($forum_configuration as $id => $value)
+++ 		{
+++-			$sql = "UPDATE " . FORUMS_TABLE . " SET discord_notifications = '" . $this->db->sql_escape($value) .
+++-				"' WHERE forum_id = " . (int) $id;
+++-			$this->db->sql_query($sql);
++++			// Don't update deleted entries
++++			if ($value === '' || $webhook_configuration[$value] !== '')
++++			{
++++				$sql = "UPDATE " . FORUMS_TABLE . " SET discord_notifications = '" . $this->db->sql_escape($value) .
++++					"' WHERE forum_id = " . (int) $id;
++++				$this->db->sql_query($sql);
++++			}
++++		}
++++
++++		$connect_timeout = (int) $this->request->variable('dn_connect_to', 0);
++++		if ($connect_timeout < 1)
++++		{
++++			$connect_timeout = 1;
+++ 		}
+++ 
++++		$exec_timeout = (int) $this->request->variable('dn_exec_to', 0);
++++		if ($exec_timeout < 1)
++++		{
++++			$exec_timeout = 1;
++++		}
++++
++++		$this->config->set('discord_notifications_enabled', $master_enable);
++++		$this->config->set('discord_notifications_post_preview_length', $preview_length);
++++		$this->config->set('discord_notifications_connect_timeout', $connect_timeout);
++++		$this->config->set('discord_notifications_exec_timeout', $exec_timeout);
++++
+++ 		$this->config->set('discord_notification_type_post_create', $this->request->variable('dn_post_create', 0));
+++ 		$this->config->set('discord_notification_type_post_update', $this->request->variable('dn_post_update', 0));
+++ 		$this->config->set('discord_notification_type_post_delete', $this->request->variable('dn_post_delete', 0));
+++@@ -377,10 +333,10 @@ class discord_notifications_module
+++ 
+++ 		while ($row = $this->db->sql_fetchrow($result))
+++ 		{
+++-			$tpl_row = [
++++			$tpl_row = array(
+++ 				'ALIAS'	=> $row['alias'],
+++ 				'URL'	=> $row['url'],
+++-			];
++++			);
+++ 			$this->template->assign_block_vars('webhookrow', $tpl_row);
+++ 		}
+++ 		$this->db->sql_freeresult($result);
+++@@ -400,7 +356,7 @@ class discord_notifications_module
+++ 
+++ 		$sql = "SELECT forum_id, forum_type, forum_name, left_id, right_id, parent_id, forum_parents, discord_notifications
+++ 			FROM " . FORUMS_TABLE . "
+++-			ORDER BY left_id";
++++			ORDER BY left_id ASC";
+++ 		$result = $this->db->sql_query($sql);
+++ 
+++ 		while ($row = $this->db->sql_fetchrow($result))
+++@@ -408,23 +364,23 @@ class discord_notifications_module
+++ 			// Category forums are displayed for organizational purposes, but have no configuration
+++ 			if ($row['forum_type'] == FORUM_CAT)
+++ 			{
+++-				$tpl_row = [
++++				$tpl_row = array(
+++ 					'S_IS_CAT'		=> true,
+++ 					'FORUM_NAME'	=> $row['forum_name'],
+++-					'PARENTS'		=> '',
+++-				];
++++					'PARENTS'	=> '',
++++				);
+++ 				$this->template->assign_block_vars('forumrow', $tpl_row);
+++ 			}
+++ 			else if ($row['forum_type'] == FORUM_POST)
+++ 			{
+++ 				// The labels for all the inputs are constructed based on the forum IDs to make it easy to know which
+++-				$tpl_row = [
+++-					'S_IS_CAT'		=> false,
+++-					'FORUM_NAME'	=> $row['forum_name'],
+++-					'FORUM_ID'		=> $row['forum_id'],
+++-					'ALIAS'			=> $row['discord_notifications'],
+++-					'PARENTS'		=> '',
+++-				];
++++				$tpl_row = array(
++++							'S_IS_CAT'		=> false,
++++							'FORUM_NAME'	=> $row['forum_name'],
++++							'FORUM_ID'		=> $row['forum_id'],
++++							'ALIAS'			=> $row['discord_notifications'],
++++							'PARENTS'		=> '',
++++						);
+++ 				$parents = get_forum_parents($row);
+++ 				if (is_array($parents))
+++ 				{
+++@@ -439,12 +395,4 @@ class discord_notifications_module
+++ 		}
+++ 		$this->db->sql_freeresult($result);
+++ 	}
+++-
+++-	private function validate_post_request()
+++-	{
+++-		if (!check_form_key(self::PAGE_FORM_NAME))
+++-		{
+++-			trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
+++-		}
+++-	}
+++ }
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
+++similarity index 63%
+++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html"
+++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
+++index e059a8f75..27ee7d868 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_mapping.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/adm/style/acp_discord_notifications.html"
+++@@ -1,40 +1,100 @@
+++-{% include 'overall_header.html' %}
++++<!-- INCLUDE overall_header.html -->
+++ 
+++ <h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
+++ 
+++-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
+++-
+++-{% if not DN_CURL_AVAILABLE %}
+++-	<div class="errorbox">
+++-		<p>{{ lang('DN_MISSING_CURL') }}</p>
+++-	</div>
+++-{% endif %}
++++<p>{{ DN_ACP_DESCRIPTION }}</p>
+++ 
+++ <form id="acp_board" method="post" action="{{ U_ACTION }}">
+++ 
+++ 	<fieldset>
+++-		<legend>{{ lang('DN_WEBHOOK_DEFAULT') }}</legend>
++++		<legend>{{ lang('DN_MAIN_SETTINGS') }}</legend>
+++ 		<dl>
+++-			<dt><label>{{ lang('DN_USER_CREATE') }}{{ lang('COLON') }}</label></dt>
+++-			<dd><label><input type="radio" class="radio" name="dn_user_create" value="1" {% if DN_USER_CREATE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++-				<label><input type="radio" class="radio" name="dn_user_create" value="0" {% if not DN_USER_CREATE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++++			<dt><label>{{ lang('DN_MASTER_ENABLE') }}{{ lang('COLON') }}</label></dt>
++++			<dd><label><input type="radio" class="radio" name="dn_master_enable" value="1" {% if DN_MASTER_ENABLE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++++				<label><input type="radio" class="radio" name="dn_master_enable" value="0" {% if not DN_MASTER_ENABLE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label>{{ lang('DN_USER_DELETE') }}{{ lang('COLON') }}</label></dt>
+++-			<dd><label><input type="radio" class="radio" name="dn_user_delete" value="1" {% if DN_USER_DELETE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++-				<label><input type="radio" class="radio" name="dn_user_delete" value="0" {% if not DN_USER_DELETE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++++			<dt><label for="dn_post_preview_length">{{ lang('DN_POST_PREVIEW_LENGTH') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_POST_PREVIEW_DESCRIPTION') }}</span></dt>
++++			<dd>
++++				<input id="dn_post_preview_length" name="dn_post_preview_length" type="text" value="{{ DN_POST_PREVIEW_LENGTH }}" size="4" maxlength="4" />
++++			</dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label for="dn_webhook_default">{{ lang('DN_WEBHOOK_DEFAULT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_DEFAULT_DESCRIPTION') }}</span></dt>
++++			<dt><label for="dn_connect_to">{{ lang('DN_CONNECT_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_CONNECT_TO_DESCRIPTION') }}</span></dt>
+++ 			<dd>
+++-				<select id="dn_webhook_default" name="dn_webhook_default">
+++-					<option value="">({{ lang('DISABLED') }})</option>
++++				<input id="dn_connect_to" name="dn_connect_to" type="text" value="{{ DN_CONNECT_TIMEOUT }}" size="4" maxlength="4" />
++++			</dd>
++++		</dl>
++++		<dl>
++++			<dt><label for="dn_exec_to">{{ lang('DN_EXEC_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_EXEC_TO_DESCRIPTION') }}</span></dt>
++++			<dd>
++++				<input id="dn_exec_to" name="dn_exec_to" type="text" value="{{ DN_EXEC_TIMEOUT }}" size="4" maxlength="4" />
++++			</dd>
++++		</dl>
++++	</fieldset>
++++
++++	<fieldset>
++++		<legend>{{ lang('DN_WEBHOOK_SETTINGS') }}</legend>
++++		<p>{{ lang('DN_WEBHOOK_SETTINGS_DESCRIPTION') }}</p>
++++		{% if loops.webhookrow %}
++++			{% for webhook in loops.webhookrow %}
++++				<dl>
++++					<dt><label for="dn_webhook_{{ webhook.ALIAS }}">{{ webhook.ALIAS }}</label></dt>
++++					<dd>
++++						<input type="text" size="100" maxlength="255" id="dn_webhook_{{ webhook.ALIAS }}" name="dn_webhook[{{ webhook.ALIAS }}]" value="{{ webhook.URL }}" />
++++						<input type="submit" name="action_delete_alias[{{ webhook.ALIAS }}]" value="{{ lang('DELETE') }}" class="button2" onclick="return confirm('{{ lang('CONFIRM_OPERATION') }}');">
++++					</dd>
++++				</dl>
++++			{% endfor %}
++++		{% else %}
++++			<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
++++		{% endif %}
++++	</fieldset>
++++
++++	<fieldset>
++++		<legend>{{ lang('DN_WEBHOOK_NEW') }}</legend>
++++		<p>{{ lang('DN_WEBHOOK_NEW_DESCRIPTION') }}</p>
++++		<dl>
++++			<dt><label for="dn_webhook_new_alias">{{ lang('DN_WEBHOOK_NEW_ALIAS') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_ALIAS_DESCRIPTION') }}</span></dt>
++++			<dd>
++++				<input id="dn_webhook_new_alias" name="dn_webhook_new_alias" type="text" value="" size="100" maxlength="255" />
++++			</dd>
++++		</dl>
++++		<dl>
++++			<dt><label for="dn_webhook_new_url">{{ lang('DN_WEBHOOK_NEW_URL') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_URL_DESCRIPTION') }}</span></dt>
++++			<dd>
++++				<input id="dn_webhook_new_url" name="dn_webhook_new_url" type="text" value="" size="100" maxlength="255" />
++++			</dd>
++++		</dl>
++++	</fieldset>
++++
++++	<fieldset>
++++		<legend>{{ lang('DN_TEST_SETTINGS') }}</legend>
++++		<dl>
++++			<dt><label for="dn_test_message">{{ lang('DN_TEST_MESSAGE') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_TEST_DESCRIPTION') }}</span></dt>
++++			<dd>
++++				<input id="dn_test_message" name="dn_test_message" type="text" value="{{ DN_TEST_MESSAGE_TEXT }}" size="100" maxlength="255" />
++++			</dd>
++++		</dl>
++++		{% if loops.webhookrow %}
++++		<dl>
++++			<dt><label for="dn_test_webhook">{{ lang('DN_WEBHOOK_SELECT') }}{{ lang('COLON') }}</label><br /></dt>
++++			<dd>
++++				<select id="dn_test_webhook" name="dn_test_webhook">
++++					<option value="">{{ lang('DN_WEBHOOK_SELECT') }}</option>
+++ 					{% for webhook in loops.webhookrow %}
+++-						<option value="{{ webhook.ALIAS }}"{% if DN_DEFAULT_WEBHOOK == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
++++					<option value="{{ webhook.ALIAS }}"{% if forumrow.ALIAS == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
+++ 					{% endfor %}
+++ 				</select>
+++ 			</dd>
+++ 		</dl>
++++		<dl>
++++			<dt><label for="action_send_test_message">{{ lang('DN_SEND_TEST') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_SEND_TEST_DESCRIPTION') }}</span></dt>
++++			<dd><input class="button2" type="submit" id="action_send_test_message" name="action_send_test_message" value="{{ lang('DN_SEND_TEST') }}" /></dd>
++++		</dl>
++++		{% else %}
++++		<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
++++		{% endif %}
+++ 	</fieldset>
+++ 
+++ 	<fieldset>
+++@@ -100,6 +160,27 @@
+++ 			<dd><label><input type="radio" class="radio" name="dn_topic_approve" value="1" {% if DN_TOPIC_APPROVE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++ 				<label><input type="radio" class="radio" name="dn_topic_approve" value="0" {% if not DN_TOPIC_APPROVE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++ 		</dl>
++++		<dl>
++++			<dt><label>{{ lang('DN_USER_CREATE') }}{{ lang('COLON') }}</label></dt>
++++			<dd><label><input type="radio" class="radio" name="dn_user_create" value="1" {% if DN_USER_CREATE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++++				<label><input type="radio" class="radio" name="dn_user_create" value="0" {% if not DN_USER_CREATE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++++		</dl>
++++		<dl>
++++			<dt><label>{{ lang('DN_USER_DELETE') }}{{ lang('COLON') }}</label></dt>
++++			<dd><label><input type="radio" class="radio" name="dn_user_delete" value="1" {% if DN_USER_DELETE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
++++				<label><input type="radio" class="radio" name="dn_user_delete" value="0" {% if not DN_USER_DELETE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++++		</dl>
++++		<dl>
++++			<dt><label for="dn_webhook_default">{{ lang('DN_WEBHOOK_DEFAULT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_DEFAULT_DESCRIPTION') }}</span></dt>
++++			<dd>
++++				<select id="dn_webhook_default" name="dn_webhook_default">
++++					<option value="">({{ lang('DISABLED') }})</option>
++++					{% for webhook in loops.webhookrow %}
++++					<option value="{{ webhook.ALIAS }}"{% if DN_DEFAULT_WEBHOOK == webhook.ALIAS %} selected{% endif %}>{{ webhook.ALIAS }}</option>
++++					{% endfor %}
++++				</select>
++++			</dd>
++++		</dl>
+++ 	</fieldset>
+++ 
+++ 	<fieldset>
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html"
+++deleted file mode 100644
+++index 90eed3ee7..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_settings.html"
++++++ /dev/null
+++@@ -1,49 +0,0 @@
+++-{% include 'overall_header.html' %}
+++-
+++-<h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
+++-
+++-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
+++-
+++-{% if not DN_CURL_AVAILABLE %}
+++-	<div class="errorbox">
+++-		<p>{{ lang('DN_MISSING_CURL') }}</p>
+++-	</div>
+++-{% endif %}
+++-
+++-<form id="acp_board" method="post" action="{{ U_ACTION }}">
+++-
+++-	<fieldset>
+++-		<legend>{{ lang('DN_MAIN_SETTINGS') }}</legend>
+++-		<dl>
+++-			<dt><label>{{ lang('DN_MASTER_ENABLE') }}{{ lang('COLON') }}</label></dt>
+++-			<dd><label><input type="radio" class="radio" name="dn_master_enable" value="1" {% if DN_MASTER_ENABLE %}checked="checked"{% endif %}/> {{ lang('YES') }}</label>
+++-				<label><input type="radio" class="radio" name="dn_master_enable" value="0" {% if not DN_MASTER_ENABLE %}checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++-		</dl>
+++-		<dl>
+++-			<dt><label for="dn_post_preview_length">{{ lang('DN_POST_PREVIEW_LENGTH') }}{{ lang('COLON') }}</label><br /><span>{{ DN_POST_PREVIEW_DESCRIPTION }}</span></dt>
+++-			<dd>
+++-				<input id="dn_post_preview_length" name="dn_post_preview_length" type="text" value="{{ DN_POST_PREVIEW_LENGTH }}" size="4" maxlength="4" />
+++-			</dd>
+++-		</dl>
+++-		<dl>
+++-			<dt><label for="dn_connect_to">{{ lang('DN_CONNECT_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_CONNECT_TO_DESCRIPTION') }}</span></dt>
+++-			<dd>
+++-				<input id="dn_connect_to" name="dn_connect_to" type="text" value="{{ DN_CONNECT_TIMEOUT }}" size="4" maxlength="4" />
+++-			</dd>
+++-		</dl>
+++-		<dl>
+++-			<dt><label for="dn_exec_to">{{ lang('DN_EXEC_TIMEOUT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_EXEC_TO_DESCRIPTION') }}</span></dt>
+++-			<dd>
+++-				<input id="dn_exec_to" name="dn_exec_to" type="text" value="{{ DN_EXEC_TIMEOUT }}" size="4" maxlength="4" />
+++-			</dd>
+++-		</dl>
+++-	</fieldset>
+++-
+++-	<fieldset class="submit-buttons">
+++-		<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+++-		{{ S_FORM_TOKEN }}
+++-	</fieldset>
+++-
+++-</form>
+++-
+++-{% include 'overall_footer.html' %}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html"
+++deleted file mode 100644
+++index a500594a6..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/adm/style/acp_discord_notifications_webhooks.html"
++++++ /dev/null
+++@@ -1,86 +0,0 @@
+++-{% include 'overall_header.html' %}
+++-
+++-<h1>{{ lang('ACP_DISCORD_NOTIFICATIONS') }}</h1>
+++-
+++-<p>{{ lang('DN_ACP_DESCRIPTION') }}</p>
+++-
+++-{% if not DN_CURL_AVAILABLE %}
+++-	<div class="errorbox">
+++-		<p>{{ lang('DN_MISSING_CURL') }}</p>
+++-	</div>
+++-{% endif %}
+++-
+++-<form id="acp_board" method="post" action="{{ U_ACTION }}">
+++-
+++-	<fieldset>
+++-		<legend>{{ lang('DN_WEBHOOK_SETTINGS') }}</legend>
+++-		<p>{{ lang('DN_WEBHOOK_SETTINGS_DESCRIPTION') }}</p>
+++-		{% if loops.webhookrow %}
+++-			{% for webhook in loops.webhookrow %}
+++-				<dl>
+++-					<dt><label for="dn_webhook_{{ webhook.ALIAS }}">{{ webhook.ALIAS }}</label></dt>
+++-					<dd>
+++-						<input type="text" size="100" maxlength="255" id="dn_webhook_{{ webhook.ALIAS }}" name="dn_webhook[{{ webhook.ALIAS }}]" value="{{ webhook.URL }}" />
+++-						<input type="submit" name="action_delete_alias[{{ webhook.ALIAS }}]" value="{{ lang('DELETE') }}" class="button2" onclick="return confirm('{{ lang('CONFIRM_OPERATION') }}');">
+++-					</dd>
+++-				</dl>
+++-			{% endfor %}
+++-		{% else %}
+++-			<p><strong>{{ lang('DN_NO_WEBHOOKS') }}</strong></p>
+++-		{% endif %}
+++-	</fieldset>
+++-
+++-	<fieldset>
+++-		<legend>{{ lang('DN_WEBHOOK_NEW') }}</legend>
+++-		<p>{{ lang('DN_WEBHOOK_NEW_DESCRIPTION') }}</p>
+++-		<dl>
+++-			<dt><label for="dn_webhook_new_alias">{{ lang('DN_WEBHOOK_NEW_ALIAS') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_ALIAS_DESCRIPTION') }}</span></dt>
+++-			<dd>
+++-				<input id="dn_webhook_new_alias" name="dn_webhook_new_alias" type="text" value="" size="100" maxlength="255" />
+++-			</dd>
+++-		</dl>
+++-		<dl>
+++-			<dt><label for="dn_webhook_new_url">{{ lang('DN_WEBHOOK_NEW_URL') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_WEBHOOK_NEW_URL_DESCRIPTION') }}</span></dt>
+++-			<dd>
+++-				<input id="dn_webhook_new_url" name="dn_webhook_new_url" type="text" value="" size="100" maxlength="255" />
+++-			</dd>
+++-		</dl>
+++-	</fieldset>
+++-
+++-	<fieldset>
+++-		<legend>{{ lang('DN_TEST_SETTINGS') }}</legend>
+++-		{% if loops.webhookrow %}
+++-		<dl>
+++-			<dt><label for="dn_test_message">{{ lang('DN_TEST_MESSAGE') }}{{ lang('COLON') }}</label><br /><span>{{ lang('DN_TEST_DESCRIPTION') }}</span></dt>
+++-			<dd>
+++-				<input id="dn_test_message" name="dn_test_message" type="text" value="{{ DN_TEST_MESSAGE_TEXT }}" size="100" maxlength="255" />
+++-			</dd>
+++-		</dl>
+++-		<dl>
+++-			<dt><label for="dn_test_webhook">{{ lang('DN_WEBHOOK_SELE
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/event/notification_event_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/event/notification_event_listener.php"
++index af5e9d60b..c9275956b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/event/notification_event_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/event/notification_event_listener.php"
++@@ -79,7 +79,7 @@ class notification_event_listener implements EventSubscriberInterface
++ 	 */
++ 	static public function getSubscribedEvents()
++ 	{
++-		return [
+++		return array(
++ 			// This event is used for performing actions directly after a post or topic has been submitted.
++ 			'core.submit_post_end'				=> 'handle_post_submit_action',
++ 			// This event is used for performing actions directly after a post or topic has been deleted.
++@@ -100,7 +100,7 @@ class notification_event_listener implements EventSubscriberInterface
++ 			'core.approve_topics_after'			=> 'handle_topic_approval_action',
++ 			// Post approval
++ 			'core.approve_posts_after'			=> 'handle_post_approval_action',
++-		];
+++		);
++ 	}
++ 
++ 	// ----------------------------------------------------------------------------
++@@ -179,7 +179,7 @@ class notification_event_listener implements EventSubscriberInterface
++ 		}
++ 
++ 		// Build an array of the event data that we may need to pass along to the function that will construct the notification message
++-		$post_data = [
+++		$post_data = array(
++ 			'user_id'			=> $event['data']['poster_id'],
++ 			'user_name'			=> $event['username'],
++ 			'forum_id'			=> $event['data']['forum_id'],
++@@ -192,7 +192,7 @@ class notification_event_listener implements EventSubscriberInterface
++ 			'edit_user_name'	=> $this->language->lang('UNKNOWN_USER'),
++ 			'edit_reason'		=> $event['data']['post_edit_reason'],
++ 			'content'			=> $event['data']['message'],
++-		];
+++		);
++ 
++ 		if ($post_data['edit_user_id'] == $post_data['user_id'])
++ 		{
++@@ -254,7 +254,7 @@ class notification_event_listener implements EventSubscriberInterface
++ 
++ 		// Build an array of the event data that we may need to pass along to the function that will construct the notification message.
++ 		// Note that unfortunately, the event data does not give us any information indicating which user deleted the post.
++-		$post_data = [
+++		$post_data = array(
++ 			'user_id'		=> $event['data']['poster_id'],
++ 			'user_name'		=> $this->language->lang('UNKNOWN_USER'),
++ 			'forum_id'		=> $event['forum_id'],
++@@ -263,7 +263,7 @@ class notification_event_listener implements EventSubscriberInterface
++ 			'topic_title'	=> $this->language->lang('UNKNOWN_TOPIC'),
++ 			'post_id'		=> $event['post_id'],
++ 			'delete_reason'	=> $event['softdelete_reason'],
++-		];
+++		);
++ 
++ 		// Fetch the forum name, topic title, and user name using the respective IDs.
++ 		$forum_name = $this->notification_service->query_forum_name($post_data['forum_id']);
++@@ -319,14 +319,13 @@ class notification_event_listener implements EventSubscriberInterface
++ 		}
++ 
++ 		// Copy over the data necessary to generate the notification into a new array
++-		$delete_data = [
++-			'forum_id'			=> $query_data['forum_id'],
++-			'forum_name'		=> $query_data['forum_name'],
++-			'topic_title'		=> $query_data['topic_title'],
++-			'topic_post_count'	=> $query_data['topic_posts_approved'],
++-			'user_id'			=> $query_data['topic_poster'],
++-			'user_name'			=> $query_data['topic_first_poster_name'],
++-		];
+++		$delete_data = array();
+++		$delete_data['forum_id'] = $query_data['forum_id'];
+++		$delete_data['forum_name'] = $query_data['forum_name'];
+++		$delete_data['topic_title'] = $query_data['topic_title'];
+++		$delete_data['topic_post_count'] = $query_data['topic_posts_approved'];
+++		$delete_data['user_id'] = $query_data['topic_poster'];
+++		$delete_data['user_name'] = $query_data['topic_first_poster_name'];
++ 
++ 		$this->notify_topic_deleted($delete_data, $webhook_url);
++ 	}
++@@ -353,24 +352,22 @@ class notification_event_listener implements EventSubscriberInterface
++ 
++ 		// Get the ID needed to access $event['data'], then extract all relevant data from the event that we need to generate the notification
++ 		$id = array_slice($event['ids'], -1)[0];
++-		$event_data = $event['data'][$id];
++-
++-		$lock_data = [
++-			'forum_id'			=> $event_data['forum_id'],
++-			'forum_name'		=> $event_data['forum_name'],
++-			'topic_id'			=> $event_data['topic_id'],
++-			'topic_title'		=> $event_data['topic_title'],
++-			'topic_user_id'		=> $event_data['topic_poster'],
++-			'topic_user_name'	=> $event_data['topic_first_poster_name'],
++-			// only used for post_[un]lock events, not always set
++-			'post_id'			=> $event_data['post_id'] ?? '',
++-			'post_subject'		=> $event_data['post_subject'] ?? '',
++-			'post_user_id'		=> $event_data['poster_id'] ?? '',
++-			'post_user_name'	=> $event_data['username'] ?? '',
++-		];
+++
+++		$lock_data = array();
+++		$lock_data['forum_id'] = $event['data'][$id]['forum_id'];
+++		$lock_data['forum_name'] = $event['data'][$id]['forum_name'];
+++		$lock_data['post_id'] = $event['data'][$id]['post_id'] ?? ''; // only used for post_[un]lock events
+++		$lock_data['post_subject'] = $event['data'][$id]['post_subject'] ?? ''; // only used for post_[un]lock events
+++		$lock_data['topic_id'] = $event['data'][$id]['topic_id'];
+++		$lock_data['topic_title'] = $event['data'][$id]['topic_title'];
+++		// Two sets of user data captured: one for the post (if applicable) and one for the user that started the topic
+++		$lock_data['post_user_id'] = $event['data'][$id]['poster_id'] ?? ''; // only used for post_[un]lock events
+++		$lock_data['post_user_name'] = $event['data'][$id]['username'] ?? ''; // only used for post_[un]lock events
+++		$lock_data['topic_user_id'] = $event['data'][$id]['topic_poster'];
+++		$lock_data['topic_user_name'] = $event['data'][$id]['topic_first_poster_name'];
++ 
++ 		// If the forum the post was made in does not have notifications enabled or the topic/poar is not visible, do nothing more.
++-		$topic_visibile = $event_data['topic_visibility'] == 1;
+++		$topic_visibile = $event['data'][$id]['topic_visibility'] == 1;
++ 		$webhook_url = $this->notification_service->get_forum_notification_url($lock_data['forum_id']);
++ 		if (!$webhook_url || !$topic_visibile)
++ 		{
++@@ -432,7 +429,7 @@ class notification_event_listener implements EventSubscriberInterface
++ 	 */
++ 	public function handle_user_activate_action($event)
++ 	{
++-		$user_data = [];
+++		$user_data = array();
++ 		if ($event['user_id'])
++ 		{
++ 			$user_data['user_id'] = $event['user_id'];
++@@ -461,7 +458,7 @@ class notification_event_listener implements EventSubscriberInterface
++ 	public function handle_user_delete_action($event)
++ 	{
++ 		// Extract the IDs and names of all deleted users to pass along in an array of (id => name)
++-		$user_data = [];
+++		$user_data = array();
++ 		foreach ($event['user_ids'] as $id)
++ 		{
++ 			$user_data[$id] = $event['user_rows'][$id]['username'];
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/ext.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/ext.php"
++deleted file mode 100644
++index 63c8480a0..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/ext.php"
+++++ /dev/null
++@@ -1,23 +0,0 @@
++-<?php
++-
++-namespace mober\discordnotifications;
++-
++-class ext extends \phpbb\extension\base
++-{
++-	/**
++-	 * {@inheritDoc}
++-	 */
++-	public function is_enableable()
++-	{
++-		$language = $this->container->get('language');
++-		$language->add_lang('acp_discord_notifications', 'mober/discordnotifications');
++-
++-		$curl_available = extension_loaded('curl');
++-		if (!$curl_available)
++-		{
++-			return $language->lang('DN_MISSING_CURL');
++-		}
++-
++-		return true;
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/de/acp_discord_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/de/acp_discord_notifications.php"
++index 6ed72f018..98030f4d8 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/de/acp_discord_notifications.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/de/acp_discord_notifications.php"
++@@ -21,31 +21,32 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, array(
++ 	// ACP Extension Settings Page
++ 	'DN_ACP_DESCRIPTION'			=> 'Diese Einstellungen erlauben es, bei verschiedenen Ereignissen eine Benachrichtigung an einen Discord-Kanal zu schicken.',
++-	'DN_MISSING_CURL'				=> 'Damit diese Erweiterung funktioniert, musst du das <a href="https://www.php.net/manual/de/curl.installation.php">ext-curl Modul für PHP installieren.</a>',
++ 
++ 	'DN_MAIN_SETTINGS'				=> 'Konfiguration',
++ 	'DN_MASTER_ENABLE'				=> 'Discord Benachrichtigungen aktivieren',
+++	'DN_WEBHOOK_URL'				=> 'Discord Webhook URL',
+++	'DN_WEBHOOK_DESCRIPTION'		=> 'Webhook für einen Discord-Kanal. Weitere Informationen gibt es in <a href="https://support.discordapp.com/hc/en-us/articles/228383668-Intro-to-Webhooks">diesem Artikel</a>.',
++ 	'DN_POST_PREVIEW_LENGTH'		=> 'Länge der Vorschau',
++-	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Wie viele Zeichen eines Beitrags sollen in der Vorschau angezeigt werden? (%1$d-%2$d), 0 deaktiviert die Vorschau)',
+++	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Wie viele Zeichen eines Posts sollen in der Vorschau angezeigt werden? (10-2000, 0 deaktiviert die Vorschau)',
++ 	'DN_TEST_MESSAGE'				=> 'Nachricht',
++ 	'DN_TEST_MESSAGE_TEXT'			=> 'Dies ist ein Test: Hallo, Discord!',
++ 	'DN_TEST_DESCRIPTION'			=> 'Nachricht, die beim Starten eines Tests geschickt wird.',
++ 	'DN_SEND_TEST'					=> 'Test starten',
++ 	'DN_SEND_TEST_DESCRIPTION'		=> 'Wenn alles korrekt konfiguriert ist, sollte die Test-Nachricht im entsprechenden Discord-Kanal auftauchen.',
++ 	'DN_CONNECT_TIMEOUT'			=> 'Timeout Verbindungsaufbau',
++-	'DN_CONNECT_TO_DESCRIPTION'		=> 'Zeit in Sekunden, die maximal auf einen Verbindungsaufbau gewartet wird.',
++-	'DN_EXEC_TIMEOUT'				=> 'Timeout Übertragung',
++-	'DN_EXEC_TO_DESCRIPTION'		=> 'Maximale Zeit in Sekunden, die die Datenübertragung dauern darf.',
+++	'DN_CONNECT_TO_DESCRIPTION'     => 'Zeit in Sekunden, die maximal auf einen Verbindungsaufbau gewartet wird.',
+++	'DN_EXEC_TIMEOUT'               => 'Timeout Übertragung',
+++	'DN_EXEC_TO_DESCRIPTION'        => 'Maximale Zeit in Sekunden, die die Datenübertragung dauern darf.',
++ 	'DN_TEST_SETTINGS'				=> 'Test',
++ 
++ 	'DN_WEBHOOK_SETTINGS'			=> 'Einträge Bearbeiten',
++ 	'DN_WEBHOOK_SETTINGS_DESCRIPTION' => 'Hier können bestehende Einträge bearbeitet oder gelöscht werden.',
++ 	'DN_WEBHOOK_NEW'				=> 'Neuen Eintrag anlegen',
++-	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Hier kann ein neuer Eintrag angelegt werden. Die URL muss vollständig sein und mit "http" oder "https" beginnen.',
+++	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Hier kann ein neuer Eintrag angelegt werden. Um die URL zu erhalten, auf einen Discord-Kanal rechtsklicken, "Kanal bearbeiten" wählen und dann unter "Integrationen" einen neuen Webhook anlegen.',
++ 	'DN_WEBHOOK_NEW_ALIAS'			=> 'Neuer Alias',
++ 	'DN_WEBHOOK_NEW_ALIAS_DESCRIPTION' => 'Frei wählbar, z.B. der Names des Channels, auf den der Webhook zeigt (wie "öffentlich" or "marktplatz").',
++-	'DN_WEBHOOK_NEW_URL'			=> 'Discord Webhook URL',
++-	'DN_WEBHOOK_NEW_URL_DESCRIPTION'=> 'Webhook für einen Discord-Kanal. Weitere Informationen gibt es in <a href="https://support.discord.com/hc/de/articles/228383668-Einleitung-in-Webhooks">diesem Artikel</a>.',
+++	'DN_WEBHOOK_NEW_URL'			=> 'Neue URL',
+++	'DN_WEBHOOK_NEW_URL_DESCRIPTION' => 'Webhook-URL, muss mit http/https beginnen, z.B. <samp>https://discord.com/api/webhooks/1063...</samp>',
++ 	'DN_WEBHOOK_SELECT'				=> 'Webhook auswählen',
++ 	'DN_WEBHOOK_DEFAULT'			=> 'Forenübergreifende Ereignisse',
++ 	'DN_WEBHOOK_DEFAULT_DESCRIPTION' => 'Webhook für Ereignisse, die nicht zu einem bestimmten Forum gehören (z.B. Benutzer erstellt/gelöscht)',
++@@ -53,18 +54,18 @@ $lang = array_merge($lang, array(
++ 
++ 	'DN_TYPE_SETTINGS'				=> 'Benachrichtigungstypen',
++ 	'DN_TYPE_DESCRIPTION'			=> 'Wähle aus, welche Ereignisse eine Benachrichtigung auslösen sollen.',
++-	'DN_POST_CREATE'				=> 'Beitrag erstellt',
++-	'DN_POST_UPDATE'				=> 'Beitrag aktualisiert',
++-	'DN_POST_DELETE'				=> 'Beitrag gelöscht',
++-	'DN_POST_LOCK'					=> 'Beitrag gesperrt',
++-	'DN_POST_UNLOCK'				=> 'Beitrag entsperrt',
++-	'DN_POST_APPROVE'				=> 'Beitrag freigegeben',
+++	'DN_POST_CREATE'				=> 'Post erstellt',
+++	'DN_POST_UPDATE'				=> 'Post aktualisiert',
+++	'DN_POST_DELETE'				=> 'Post gelöscht',
+++	'DN_POST_LOCK'					=> 'Post gesperrt',
+++	'DN_POST_UNLOCK'				=> 'Post entsperrt',
+++	'DN_POST_APPROVE'				=> 'Post freigeschaltet',
++ 	'DN_TOPIC_CREATE'				=> 'Thema erstellt',
++ 	'DN_TOPIC_UPDATE'				=> 'Thema aktualisiert',
++ 	'DN_TOPIC_DELETE'				=> 'Thema gelöscht',
++ 	'DN_TOPIC_LOCK'					=> 'Thema gesperrt',
++ 	'DN_TOPIC_UNLOCK'				=> 'Thema entsperrt',
++-	'DN_TOPIC_APPROVE'				=> 'Thema freigegeben',
+++	'DN_TOPIC_APPROVE'				=> 'Thema freigeschaltet',
++ 	'DN_USER_CREATE'				=> 'Benutzer erstellt',
++ 	'DN_USER_DELETE'				=> 'Benutzer gelöscht',
++ 
++@@ -79,6 +80,7 @@ $lang = array_merge($lang, array(
++ 
++ 	// Success/Failure messages that can be generated once the user saves
++ 	'DN_SETTINGS_SAVED'				=> 'Einstellungen aktualisiert.',
+++	'DN_MASTER_WEBHOOK_REQUIRED'	=> 'Benachrichtigungen können nur aktiviert werden, wenn eine gültige Webhook-URL hinterlegt ist.',
++ 	'DN_WEBHOOK_URL_INVALID'		=> 'Die Webhook-URL ist ungültig. Bitte überprüfe die Konfiguration.',
++-	'DN_POST_PREVIEW_INVALID'		=> 'Länge der Vorschau muss zwischen %1$d und %2$d Zeichen sein (oder 0 zum Deaktivieren der Vorschau).',
+++	'DN_POST_PREVIEW_INVALID'		=> 'Länge der Vorschau muss zwischen 10 und 2000 Zeichen sein (oder 0 zum Deaktivieren der Vorschau).',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/de/info_acp_discord_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/de/info_acp_discord_notifications.php"
++index 906c6451b..450000295 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/de/info_acp_discord_notifications.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/de/info_acp_discord_notifications.php"
++@@ -19,9 +19,7 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, array(
++ 	// ACP Module
++ 	'ACP_DISCORD_NOTIFICATIONS'					=> 'Discord Benachrichtigungen',
++-	'ACP_DISCORD_NOTIFICATIONS_SETTINGS'		=> 'Einstellungen',
++-	'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS'		=> 'Webhooks',
++-	'ACP_DISCORD_NOTIFICATIONS_MAPPING'			=> 'Zuordnung',
+++	'ACP_DISCORD_NOTIFICATIONS_TITLE'			=> 'Discord Konfiguration',
++ 
++ 	// ACP Logs
++ 	'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE'		=> 'Discord Benachrichtigungen: Einstellungen aktualisiert',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/en/acp_discord_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/en/acp_discord_notifications.php"
++index 5adf96d04..22ec10371 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/en/acp_discord_notifications.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/en/acp_discord_notifications.php"
++@@ -21,31 +21,32 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, array(
++ 	// ACP Extension Settings Page
++ 	'DN_ACP_DESCRIPTION'			=> 'These settings allow for various forum events to send notification messages to a Discord server.',
++-	'DN_MISSING_CURL'				=> 'Please install the <a href="https://www.php.net/manual/en/curl.installation.php">ext-curl module for PHP</a>, otherwise this extension will not work.',
++ 
++ 	'DN_MAIN_SETTINGS'				=> 'Main Settings',
++ 	'DN_MASTER_ENABLE'				=> 'Enable Discord Notifications',
+++	'DN_WEBHOOK_URL'				=> 'Discord Webhook URL',
+++	'DN_WEBHOOK_DESCRIPTION'		=> 'The URL of the webhook generated by the Discord server. See <a href="https://support.discordapp.com/hc/en-us/articles/228383668-Intro-to-Webhooks">this article</a> to learn how to create a new webhook.',
++ 	'DN_POST_PREVIEW_LENGTH'		=> 'Post Preview Length',
++-	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Specify the number of characters to display in a post preview (%1$d-%2$d). A zero value disables post preview.',
+++	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Specify the number of characters to display in a post preview (10 - 2000). A zero value disables post preview.',
++ 	'DN_TEST_MESSAGE'				=> 'Message',
++ 	'DN_TEST_MESSAGE_TEXT'			=> 'This is a test: Hello Discord!',
++ 	'DN_TEST_DESCRIPTION'			=> 'A message to send to Discord to verify that the connection with phpBB is functioning.',
++ 	'DN_SEND_TEST'					=> 'Send Test Message',
++ 	'DN_SEND_TEST_DESCRIPTION'		=> 'Sends the contents of the test message to the Discord webhook. Use this to verify that your webhook is properly functioning.',
++ 	'DN_CONNECT_TIMEOUT'			=> 'Connect timeout',
++-	'DN_CONNECT_TO_DESCRIPTION'		=> 'Timeout in seconds to establish a connection to the Webhook endpoint.',
++-	'DN_EXEC_TIMEOUT'				=> 'Transfer timeout',
++-	'DN_EXEC_TO_DESCRIPTION'		=> 'Timeout in seconds for data transfer.',
+++	'DN_CONNECT_TO_DESCRIPTION'     => 'Timeout in seconds to establish a connection to the Webhook endpoint.',
+++	'DN_EXEC_TIMEOUT'               => 'Transfer timeout',
+++	'DN_EXEC_TO_DESCRIPTION'        => 'Timeout in seconds for data transfer.',
++ 	'DN_TEST_SETTINGS'				=> 'Test Settings',
++ 
++ 	'DN_WEBHOOK_SETTINGS'			=> 'Edit entries',
++ 	'DN_WEBHOOK_SETTINGS_DESCRIPTION' => 'Edit or delete existing entries.',
++ 	'DN_WEBHOOK_NEW'				=> 'Create new entry',
++-	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Create a new entry. A full URL is required, starting with "http" or "https".',
+++	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Create a new entry. To get the Webhook-URL, right click on a Discord channel, chose "Edit Channel", then go to "Integrations" to create a Webhook.',
++ 	'DN_WEBHOOK_NEW_ALIAS'			=> 'New Alias',
++ 	'DN_WEBHOOK_NEW_ALIAS_DESCRIPTION' => 'Can be freely chosen, for example something that describes the target channel of the webhook (like "public" or "marketplace").',
++-	'DN_WEBHOOK_NEW_URL'			=> 'Discord Webhook URL',
++-	'DN_WEBHOOK_NEW_URL_DESCRIPTION'=> 'The URL of the webhook generated by the Discord server. See <a href="https://support.discordapp.com/hc/en-us/articles/228383668-Intro-to-Webhooks">this article</a> to learn how to create a new webhook.',
+++	'DN_WEBHOOK_NEW_URL'			=> 'New URL',
+++	'DN_WEBHOOK_NEW_URL_DESCRIPTION' => 'Webhook-URL, must start with http/https, e.g. <samp>https://discord.com/api/webhooks/1063...</samp>',
++ 	'DN_WEBHOOK_SELECT'				=> 'Select Webhook',
++ 	'DN_WEBHOOK_DEFAULT'			=> 'Global Events',
++ 	'DN_WEBHOOK_DEFAULT_DESCRIPTION' => 'Webhook for global events not related to a specific forum, e.g. user creation/deletion',
++@@ -79,6 +80,7 @@ $lang = array_merge($lang, array(
++ 
++ 	// Success/Failure messages that can be generated once the user saves
++ 	'DN_SETTINGS_SAVED'				=> 'Discord Notification settings modified successfully.',
+++	'DN_MASTER_WEBHOOK_REQUIRED'	=> 'A valid Discord webhook URL is required to enable notifications.',
++ 	'DN_WEBHOOK_URL_INVALID'		=> 'Discord webhook URL must be a full and valid URL.',
++-	'DN_POST_PREVIEW_INVALID'		=> 'Post preview length must be a number between %1$d and %2$d, or 0 to disable previews.',
+++	'DN_POST_PREVIEW_INVALID'		=> 'Post preview length must be a number between 10 and 2000, or 0 to disable previews.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/en/info_acp_discord_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/en/info_acp_discord_notifications.php"
++index e92efb2b9..d7dee76f6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/en/info_acp_discord_notifications.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/en/info_acp_discord_notifications.php"
++@@ -19,9 +19,7 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, array(
++ 	// ACP Module
++ 	'ACP_DISCORD_NOTIFICATIONS'					=> 'Discord Notifications',
++-	'ACP_DISCORD_NOTIFICATIONS_SETTINGS'		=> 'Settings',
++-	'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS'		=> 'Webhooks',
++-	'ACP_DISCORD_NOTIFICATIONS_MAPPING'			=> 'Mapping',
+++	'ACP_DISCORD_NOTIFICATIONS_TITLE'			=> 'Discord Notification Settings',
++ 
++ 	// ACP Logs
++ 	'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE'		=> 'Modified Discord notification settings',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/fr/acp_discord_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/fr/acp_discord_notifications.php"
++index 61348d65c..9f6ee59d8 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/fr/acp_discord_notifications.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/fr/acp_discord_notifications.php"
++@@ -1,11 +1,11 @@
++ <?php
++ /**
++  *
++- * Discord Notifications extension for the phpBB Forum Software package.
+++ * Discord Notifications. An extension for the phpBB Forum Software package.
+++ * French translation by Galixte (http://www.galixte.com)
++  *
++- * @copyright (c) 2018, Tyler Olsen, https://github.com/rootslinux
++- * @copyright (c) 2022, French translation by Fred Rimbert https://forums.caforum.fr
++- * @license GNU General Public License, version 2 (GPL-2.0)
+++ * @copyright (c) 2018 Tyler Olsen <https://github.com/rootslinux>
+++ * @license GNU General Public License, version 2 (GPL-2.0-only)
++  *
++  * This file contains the language strings for the ACP settings page for this extension.
++  */
++@@ -42,35 +42,36 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, array(
++ 	// ACP Extension Settings Page
++ 	'DN_ACP_DESCRIPTION'			=> 'Depuis cette page il est possible de définir les paramètres permettant à différents évènements du forum d’être envoyés comme notification sur un serveur Discord.',
++-	'DN_MISSING_CURL'				=> 'Pour que cette extension fonctionne, tu dois installer le module <a href="https://www.php.net/manual/fr/curl.installation.php">ext-curl pour PHP</a>.',
++ 
++ 	'DN_MAIN_SETTINGS'				=> 'Paramètres généraux',
++ 	'DN_MASTER_ENABLE'				=> 'Activer les notifications Discord',
+++	'DN_WEBHOOK_URL'				=> 'URL Webhook de Discord',
+++	'DN_WEBHOOK_DESCRIPTION'		=> 'Permet de saisir l’adresse URL Webhook du serveur Discord généré par le serveur Discord. Voir <a href="https://support.discordapp.com/hc/fr/articles/228383668-Intro-to-Webhooks">cet article</a> pour apprendre comment créer un nouveau Webhook.',
++ 	'DN_POST_PREVIEW_LENGTH'		=> 'Longueur de l’aperçu des messages',
++-	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Permet de saisir le nombre de caractères à afficher dans l’aperçu des messages (%1$d-%2$d). Définir sur la valeur 0 pour désactiver l’aperçu des messages.',
+++	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Permet de saisir le nombre de caractères à afficher dans l’aperçu des messages (10 - 2000). Définir sur la valeur 0 pour désactiver l’aperçu des messages.',
++ 	'DN_TEST_MESSAGE'				=> 'Message',
++ 	'DN_TEST_MESSAGE_TEXT'			=> 'Texte du message de test : Hello Discord!',
++ 	'DN_TEST_DESCRIPTION'			=> 'Permet d’envoyer un message sur le serveur Discord afin de vérifier que la connexion avec phpBB est fonctionnelle.',
++ 	'DN_SEND_TEST'					=> 'Envoyer un message de test',
++ 	'DN_SEND_TEST_DESCRIPTION'		=> 'Permet d’envoyer le contenu du message de test au Webhook du serveur Discord. À utiliser pour vérifier que le Webhook est fonctionnel.',
++-	'DN_CONNECT_TIMEOUT'			=> 'Délai de connexion',
++-	'DN_CONNECT_TO_DESCRIPTION'		=> 'Délai d‘attente en secondes pour établir une connexion au point de terminaison Webhook.',
++-	'DN_EXEC_TIMEOUT'				=> 'Délai de transfert',
++-	'DN_EXEC_TO_DESCRIPTION'		=> 'Délai d‘attente en secondes pour le transfert de données.',
++-	'DN_TEST_SETTINGS'				=> 'Paramètres d‘essai',
+++	'DN_CONNECT_TIMEOUT'			=> 'Connect timeout',
+++	'DN_CONNECT_TO_DESCRIPTION'		=> 'Timeout in seconds to establish a connection to the Webhook endpoint.',
+++	'DN_EXEC_TIMEOUT'				=> 'Transfer timeout',
+++	'DN_EXEC_TO_DESCRIPTION'		=> 'Timeout in seconds for data transfer.',
+++	'DN_TEST_SETTINGS'				=> 'Test Settings',
++ 
++-	'DN_WEBHOOK_SETTINGS'			=> 'Modifier les entrées',
++-	'DN_WEBHOOK_SETTINGS_DESCRIPTION' => 'Modifier les entrées existantes. Une entrée est supprimée si le champ URL est vide.',
++-	'DN_WEBHOOK_NEW'				=> 'Créer une nouvelle entrée',
++-	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Créez une nouvelle entrée. Une URL complète est requise, commençant par "http" ou "https".',
++-	'DN_WEBHOOK_NEW_ALIAS'			=> 'Nouvel alias',
+++	'DN_WEBHOOK_SETTINGS'			=> 'Edit entries',
+++	'DN_WEBHOOK_SETTINGS_DESCRIPTION' => 'Edit or delete existing entries.',
+++	'DN_WEBHOOK_NEW'				=> 'Create new entry',
+++	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Create a new entry. To get the Webhook-URL, right click on a Discord channel, chose "Edit Channel", then go to "Integrations" to create a Webhook.',
+++	'DN_WEBHOOK_NEW_ALIAS'			=> 'New Alias',
++ 	'DN_WEBHOOK_NEW_ALIAS_DESCRIPTION' => 'Can be freely chosen, for example something that describes the target channel of the webhook (like "public" or "marketplace").',
++-	'DN_WEBHOOK_NEW_URL'			=> 'URL Webhook de Discord',
++-	'DN_WEBHOOK_NEW_URL_DESCRIPTION'=> 'Permet de saisir l’adresse URL Webhook du serveur Discord généré par le serveur Discord. Voir <a href="https://support.discordapp.com/hc/fr/articles/228383668-Intro-to-Webhooks">cet article</a> pour apprendre comment créer un nouveau Webhook.',
++-	'DN_WEBHOOK_SELECT'				=> 'Sélectionnez Webhook',
++-	'DN_WEBHOOK_DEFAULT'			=> 'Événements mondiaux',
++-	'DN_WEBHOOK_DEFAULT_DESCRIPTION' => 'Webhook pour les événements mondiaux non liés à un forum spécifique, par ex. création/suppression d‘utilisateur',
++-	'DN_NO_WEBHOOKS'				=> 'Aucune entrée n‘existe.',
+++	'DN_WEBHOOK_NEW_URL'			=> 'New URL',
+++	'DN_WEBHOOK_NEW_URL_DESCRIPTION' => 'Webhook-URL, must start with http/https, e.g. <samp>https://discord.com/api/webhooks/1063...</samp>',
+++	'DN_WEBHOOK_SELECT'				=> 'Select Webhook',
+++	'DN_WEBHOOK_DEFAULT'			=> 'Global Events',
+++	'DN_WEBHOOK_DEFAULT_DESCRIPTION' => 'Webhook for global events not related to a specific forum, e.g. user creation/deletion',
+++	'DN_NO_WEBHOOKS'				=> 'No entries exist.',
++ 
++ 	'DN_TYPE_SETTINGS'				=> 'Types de notification',
++ 	'DN_TYPE_DESCRIPTION'			=> 'Permet de sélectionner quels types de notification devraient être générés sous forme de messages envoyés sur le serveur Discord.',
++@@ -100,6 +101,7 @@ $lang = array_merge($lang, array(
++ 
++ 	// Success/Failure messages that can be generated once the user saves
++ 	'DN_SETTINGS_SAVED'				=> 'Les paramètres de notification Discord ont été modifiés avec succès !',
+++	'DN_MASTER_WEBHOOK_REQUIRED'	=> 'Une adresse URL Webhook du serveur Discord est requise pour activer les notifications.',
++ 	'DN_WEBHOOK_URL_INVALID'		=> 'L’adresse URL Webhook du serveur Discord doit être complète et correspondre à une adresse URL valide.',
++-	'DN_POST_PREVIEW_INVALID'		=> 'La longueur de l’aperçu des messages doit être comprise entre %1$d et %2$d ou définie sur 0 pour la désactivation de l’aperçu.',
+++	'DN_POST_PREVIEW_INVALID'		=> 'La longueur de l’aperçu des messages doit être comprise entre 10 et 2000 ou définie sur 0 pour la désactivation de l’aperçu.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/fr/discord_notification_messages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/fr/discord_notification_messages.php"
++index 40dc67720..310127b80 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/fr/discord_notification_messages.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/fr/discord_notification_messages.php"
++@@ -1,11 +1,11 @@
++ <?php
++ /**
++  *
++- * Discord Notifications extension for the phpBB Forum Software package.
+++ * Discord Notifications. An extension for the phpBB Forum Software package.
+++ * French translation by Galixte (http://www.galixte.com)
++  *
++- * @copyright (c) 2018, Tyler Olsen, https://github.com/rootslinux
++- * @copyright (c) 2022, French translation by Fred Rimbert https://forums.caforum.fr
++- * @license GNU General Public License, version 2 (GPL-2.0)
+++ * @copyright (c) 2018 Tyler Olsen <https://github.com/rootslinux>
+++ * @license GNU General Public License, version 2 (GPL-2.0-only)
++  *
++  * This file contains the language strings for the ACP settings page for this extension.
++  */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/fr/info_acp_discord_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/fr/info_acp_discord_notifications.php"
++index 4dedb574e..df79b8efb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/language/fr/info_acp_discord_notifications.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/language/fr/info_acp_discord_notifications.php"
++@@ -1,11 +1,11 @@
++ <?php
++ /**
++  *
++- * Discord Notifications extension for the phpBB Forum Software package.
+++ * Discord Notifications. An extension for the phpBB Forum Software package.
+++ * French translation by Galixte (http://www.galixte.com)
++  *
++- * @copyright (c) 2018, Tyler Olsen, https://github.com/rootslinux
++- * @copyright (c) 2022, French translation by Fred Rimbert https://forums.caforum.fr
++- * @license GNU General Public License, version 2 (GPL-2.0)
+++ * @copyright (c) 2018 Tyler Olsen <https://github.com/rootslinux>
+++ * @license GNU General Public License, version 2 (GPL-2.0-only)
++  *
++  * This file contains the language strings for the ACP settings page for this extension.
++  */
++@@ -42,13 +42,11 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, array(
++ 	// ACP Module
++ 	'ACP_DISCORD_NOTIFICATIONS'					=> 'Notifications Discord',
++-	'ACP_DISCORD_NOTIFICATIONS_SETTINGS'		=> 'Paramètres',
++-	'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS'		=> 'Webhooks',
++-	'ACP_DISCORD_NOTIFICATIONS_MAPPING'			=> 'Mapping',
+++	'ACP_DISCORD_NOTIFICATIONS_TITLE'			=> 'Paramètres',
++ 
++ 	// ACP Logs
++ 	'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE'		=> 'Paramètres des notifications Discord modifiées',
++-	'ACP_DISCORD_NOTIFICATIONS_WEBHOOK_ERROR'	=> 'Discord Webhook a renvoyé le code d‘état HTTP %d',
++-	'ACP_DISCORD_NOTIFICATIONS_CURL_ERROR'		=> 'Code d‘erreur Discord Webhook cURL %d',
++-	'ACP_DISCORD_NOTIFICATIONS_JSON_ERROR'		=> 'Erreur d‘encodage Discord JSON : %s',
+++	'ACP_DISCORD_NOTIFICATIONS_WEBHOOK_ERROR'	=> 'Discord Webhook returned HTTP status code %d',
+++	'ACP_DISCORD_NOTIFICATIONS_CURL_ERROR'		=> 'Discord Webhook cURL error code %d',
+++	'ACP_DISCORD_NOTIFICATIONS_JSON_ERROR'		=> 'Discord JSON encode error: %s',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/create_tables.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/migrations/create_tables.php"
++index a9f97280c..3f145cd37 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/create_tables.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/migrations/create_tables.php"
++@@ -12,7 +12,7 @@ class create_tables extends \phpbb\db\migration\migration
++ {
++ 	static public function depends_on()
++ 	{
++-		return ['\mober\discordnotifications\migrations\extension_installation'];
+++		return array('\mober\discordnotifications\migrations\extension_installation');
++ 	}
++ 
++ 	/**
++@@ -21,23 +21,23 @@ class create_tables extends \phpbb\db\migration\migration
++ 	*/
++ 	public function update_schema()
++ 	{
++-		return [
++-			'add_tables' => [
++-				$this->table_prefix . 'discord_webhooks' => [
++-					'COLUMNS' => [
++-						'alias'	=> [
+++		return array(
+++			'add_tables' => array (
+++				$this->table_prefix . 'discord_webhooks' => array (
+++					'COLUMNS' => array (
+++						'alias' => array (
++ 							'VCHAR:255',
++-							'',
++-						],
++-						'url' => [
+++							''
+++						),
+++						'url' => array (
++ 							'VCHAR:255',
++-							'',
++-						],
++-					],
+++							''
+++						),
+++					),
++ 					'PRIMARY_KEY' => 'alias',
++-				],
++-			],
++-		];
+++				),
+++			),
+++		);
++ 	}
++ 
++ 	/**
++@@ -46,10 +46,10 @@ class create_tables extends \phpbb\db\migration\migration
++ 	*/
++ 	public function revert_schema()
++ 	{
++-		return [
++-			'drop_tables' => [
+++		return array (
+++			'drop_tables' => array (
++ 				$this->table_prefix . 'discord_webhooks',
++-			],
++-		];
+++			)
+++		);
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/extension_installation.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/migrations/extension_installation.php"
++index 06c999134..676d97795 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/extension_installation.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/migrations/extension_installation.php"
++@@ -38,13 +38,13 @@ class extension_installation extends \phpbb\db\migration\migration
++ 	*/
++ 	public function update_schema()
++ 	{
++-		return [
++-			'add_columns' => [
++-				$this->table_prefix . 'forums' => [
++-					'discord_notifications' => ['VCHAR:255', ''],
++-				],
++-			],
++-		];
+++		return array(
+++			'add_columns'	=> array(
+++				$this->table_prefix . 'forums'	=> array(
+++					'discord_notifications' => array('VCHAR:255', ''),
+++				),
+++			),
+++		);
++ 	}
++ 
++ 	/**
++@@ -55,13 +55,13 @@ class extension_installation extends \phpbb\db\migration\migration
++ 	*/
++ 	public function revert_schema()
++ 	{
++-		return [
++-			'drop_columns' => [
++-				$this->table_prefix . 'forums' => [
+++		return array(
+++			'drop_columns'	=> array(
+++				$this->table_prefix . 'forums'	=> array(
++ 					'discord_notifications',
++-				],
++-			],
++-		];
+++				),
+++			),
+++		);
++ 	}
++ 
++ 	/**
++@@ -74,55 +74,55 @@ class extension_installation extends \phpbb\db\migration\migration
++ 	*/
++ 	public function update_data()
++ 	{
++-		return [
+++		return array(
++ 			// The "master switch" that enables notifications to be sent. This can only be set to true if the webhook URL is also valid
++-			['config.add', ['discord_notifications_enabled', 0]],
+++			array('config.add', array('discord_notifications_enabled', 0)),
++ 			// The maximum number of characters permitted in a discord notification message
++-			['config.add', ['discord_notifications_post_preview_length', 200]],
+++			array('config.add', array('discord_notifications_post_preview_length', 200)),
++ 			// Timeout values
++-			['config.add', ['discord_notifications_connect_timeout', 2]],
++-			['config.add', ['discord_notifications_exec_timeout', 2]],
+++			array('config.add', array('discord_notifications_connect_timeout', 2)),
+++			array('config.add', array('discord_notifications_exec_timeout', 2)),
++ 
++ 			// These configurations represent the various types of notifications that can be sent, which can be individually enabled or disabled.
++ 			// Upon installation, every notification type is enabled by default.
++ 
++ 			// Post notifications
++-			['config.add', ['discord_notification_type_post_create', 1]],
++-			['config.add', ['discord_notification_type_post_update', 1]],
++-			['config.add', ['discord_notification_type_post_delete', 1]],
++-			['config.add', ['discord_notification_type_post_lock', 1]],
++-			['config.add', ['discord_notification_type_post_unlock', 1]],
++-			['config.add', ['discord_notification_type_post_approve', 1]],
+++			array('config.add', array('discord_notification_type_post_create', 1)),
+++			array('config.add', array('discord_notification_type_post_update', 1)),
+++			array('config.add', array('discord_notification_type_post_delete', 1)),
+++			array('config.add', array('discord_notification_type_post_lock', 1)),
+++			array('config.add', array('discord_notification_type_post_unlock', 1)),
+++			array('config.add', array('discord_notification_type_post_approve', 1)),
++ 
++ 			// Topic notifications
++-			['config.add', ['discord_notification_type_topic_create', 1]],
++-			['config.add', ['discord_notification_type_topic_update', 1]],
++-			['config.add', ['discord_notification_type_topic_delete', 1]],
++-			['config.add', ['discord_notification_type_topic_lock', 1]],
++-			['config.add', ['discord_notification_type_topic_unlock', 1]],
++-			['config.add', ['discord_notification_type_topic_approve', 1]],
+++			array('config.add', array('discord_notification_type_topic_create', 1)),
+++			array('config.add', array('discord_notification_type_topic_update', 1)),
+++			array('config.add', array('discord_notification_type_topic_delete', 1)),
+++			array('config.add', array('discord_notification_type_topic_lock', 1)),
+++			array('config.add', array('discord_notification_type_topic_unlock', 1)),
+++			array('config.add', array('discord_notification_type_topic_approve', 1)),
++ 
++ 			// User notifications
++-			['config.add', ['discord_notification_type_user_create', 1]],
++-			['config.add', ['discord_notification_type_user_delete', 1]],
+++			array('config.add', array('discord_notification_type_user_create', 1)),
+++			array('config.add', array('discord_notification_type_user_delete', 1)),
++ 
++ 			// Default channel
++-			['config.add', ['discord_notification_default_webhook', '']],
+++			array('config.add', array('discord_notification_default_webhook', '')),
++ 
++ 			// Standard ACP module data
++-			['module.add', [
+++			array('module.add', array(
++ 				'acp',
++ 				'ACP_CAT_DOT_MODS',
++-				'ACP_DISCORD_NOTIFICATIONS',
++-			]],
++-			['module.add', [
+++				'ACP_DISCORD_NOTIFICATIONS'
+++			)),
+++			array('module.add', array(
++ 				'acp',
++ 				'ACP_DISCORD_NOTIFICATIONS',
++-				[
++-					'module_basename' => '\mober\discordnotifications\acp\discord_notifications_module',
++-					'modes'           => ['settings'],
++-				],
++-			]],
++-		];
+++				array(
+++					'module_basename'	=> '\mober\discordnotifications\acp\discord_notifications_module',
+++					'modes'				=> array('settings'),
+++				),
+++			)),
+++		);
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/v308/add_modules.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/v308/add_modules.php"
++deleted file mode 100644
++index c52f41dd6..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/v308/add_modules.php"
+++++ /dev/null
++@@ -1,39 +0,0 @@
++-<?php
++-
++-namespace mober\discordnotifications\migrations\v308;
++-
++-class add_modules extends \phpbb\db\migration\migration
++-{
++-	static public function depends_on()
++-	{
++-		return ['\mober\discordnotifications\migrations\extension_installation'];
++-	}
++-
++-	public function update_data()
++-	{
++-		return [
++-			['module.add', [
++-				'acp',
++-				'ACP_DISCORD_NOTIFICATIONS',
++-				[
++-					'module_basename'	=> '\mober\discordnotifications\acp\discord_notifications_module',
++-					'modes'				=> [
++-						'webhooks',
++-						'mapping',
++-					],
++-				],
++-			]],
++-			['custom', [
++-				[$this, 'rename_settings_module']
++-			]],
++-		];
++-	}
++-
++-	public function rename_settings_module()
++-	{
++-		$sql = 'UPDATE ' . MODULES_TABLE . "
++-			SET module_langname = 'ACP_DISCORD_NOTIFICATIONS_SETTINGS'
++-			WHERE module_langname = 'ACP_DISCORD_NOTIFICATIONS_TITLE'";
++-		$this->sql_query($sql);
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/v308/add_version.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/v308/add_version.php"
++deleted file mode 100644
++index 2b00710ef..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/migrations/v308/add_version.php"
+++++ /dev/null
++@@ -1,24 +0,0 @@
++-<?php
++-
++-namespace mober\discordnotifications\migrations\v308;
++-
++-class add_version extends \phpbb\db\migration\migration
++-{
++-	static public function depends_on()
++-	{
++-		return ['\mober\discordnotifications\migrations\extension_installation'];
++-	}
++-
++-	public function effectively_installed()
++-	{
++-		return isset($this->config['discord_notification_version']) &&
++-			version_compare($this->config['discord_notification_version'], '3.0.8', '>=');
++-	}
++-
++-	public function update_data()
++-	{
++-		return [
++-			['config.add', ['discord_notification_version', '3.0.8']],
++-		];
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/notification_service.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/notification_service.php"
++index ece99c293..9c2c7d1e6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\mober\\discordnotifications/notification_service.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\mober\\discordnotifications/notification_service.php"
++@@ -70,7 +70,7 @@ class notification_service
++ 	{
++ 		global $table_prefix;
++ 
++-		if (!is_numeric($forum_id))
+++		if (is_numeric($forum_id) == false)
++ 		{
++ 			return false;
++ 		}
++@@ -118,7 +118,7 @@ class notification_service
++ 	 */
++ 	public function query_forum_name($forum_id)
++ 	{
++-		if (!is_numeric($forum_id))
+++		if (is_numeric($forum_id) == false)
++ 		{
++ 			return null;
++ 		}
++@@ -138,7 +138,7 @@ class notification_service
++ 	 */
++ 	public function query_post_subject($post_id)
++ 	{
++-		if (!is_numeric($post_id))
+++		if (is_numeric($post_id) == false)
++ 		{
++ 			return null;
++ 		}
++@@ -159,7 +159,7 @@ class notification_service
++ 	 */
++ 	public function query_topic_title($topic_id)
++ 	{
++-		if (!is_numeric($topic_id))
+++		if (is_numeric($topic_id) == false)
++ 		{
++ 			return null;
++ 		}
++@@ -180,9 +180,9 @@ class notification_service
++ 	 */
++ 	public function query_topic_details($topic_id)
++ 	{
++-		if (!is_numeric($topic_id))
+++		if (is_numeric($topic_id) == false)
++ 		{
++-			return [];
+++			return array();
++ 		}
++ 
++ 		$sql = "SELECT
++@@ -205,7 +205,7 @@ class notification_service
++ 	 */
++ 	public function query_user_name($user_id)
++ 	{
++-		if (!is_numeric($user_id))
+++		if (is_numeric($user_id) == false)
++ 		{
++ 			return false;
++ 		}
++@@ -231,7 +231,7 @@ class notification_service
++ 	{
++ 		global $table_prefix;
++ 
++-		if ($this->config['discord_notifications_enabled'] == 0 || !isset($message))
+++		if ($this->config['discord_notifications_enabled'] == 0 || isset($message) == false)
++ 		{
++ 			return;
++ 		}
++@@ -263,7 +263,7 @@ class notification_service
++ 	 */
++ 	public function force_send_discord_notification($discord_webhook_url, $message)
++ 	{
++-		if (!filter_var($discord_webhook_url, FILTER_VALIDATE_URL) || !is_string($message) || $message == '')
+++		if (!filter_var($discord_webhook_url, FILTER_VALIDATE_URL) || is_string($message) == false || $message == '')
++ 		{
++ 			return false;
++ 		}
++@@ -290,20 +290,20 @@ class notification_service
++ 	 */
++ 	private function execute_discord_webhook($discord_webhook_url, $color, $message, $title = null, $preview = null, $footer = null)
++ 	{
++-		if (!isset($discord_webhook_url) || $discord_webhook_url === '')
+++		if (isset($discord_webhook_url) == false || $discord_webhook_url === '')
++ 		{
++ 			return false;
++ 		}
++-		if (!is_integer($color) || $color < 0)
+++		if (is_integer($color) == false || $color < 0)
++ 		{
++ 			// Use the default col
\ No newline at end of file
diff --git "[ORIGINAL]/mober\\discordnotifications/event/notification_event_listener.php" "[FORUM_EXT]/mober\\discordnotifications/event/notification_event_listener.php"
--- "[ORIGINAL]/mober\\discordnotifications/event/notification_event_listener.php"
+++ "[FORUM_EXT]/mober\\discordnotifications/event/notification_event_listener.php"
@@ -79,7 +79,7 @@ class notification_event_listener implements EventSubscriberInterface
 	 */
 	static public function getSubscribedEvents()
 	{
-		return [
+		return array(
 			// This event is used for performing actions directly after a post or topic has been submitted.
 			'core.submit_post_end'				=> 'handle_post_submit_action',
 			// This event is used for performing actions directly after a post or topic has been deleted.
@@ -100,7 +100,7 @@ class notification_event_listener implements EventSubscriberInterface
 			'core.approve_topics_after'			=> 'handle_topic_approval_action',
 			// Post approval
 			'core.approve_posts_after'			=> 'handle_post_approval_action',
-		];
+		);
 	}
 
 	// ----------------------------------------------------------------------------
@@ -179,7 +179,7 @@ class notification_event_listener implements EventSubscriberInterface
 		}
 
 		// Build an array of the event data that we may need to pass along to the function that will construct the notification message
-		$post_data = [
+		$post_data = array(
 			'user_id'			=> $event['data']['poster_id'],
 			'user_name'			=> $event['username'],
 			'forum_id'			=> $event['data']['forum_id'],
@@ -192,7 +192,7 @@ class notification_event_listener implements EventSubscriberInterface
 			'edit_user_name'	=> $this->language->lang('UNKNOWN_USER'),
 			'edit_reason'		=> $event['data']['post_edit_reason'],
 			'content'			=> $event['data']['message'],
-		];
+		);
 
 		if ($post_data['edit_user_id'] == $post_data['user_id'])
 		{
@@ -254,7 +254,7 @@ class notification_event_listener implements EventSubscriberInterface
 
 		// Build an array of the event data that we may need to pass along to the function that will construct the notification message.
 		// Note that unfortunately, the event data does not give us any information indicating which user deleted the post.
-		$post_data = [
+		$post_data = array(
 			'user_id'		=> $event['data']['poster_id'],
 			'user_name'		=> $this->language->lang('UNKNOWN_USER'),
 			'forum_id'		=> $event['forum_id'],
@@ -263,7 +263,7 @@ class notification_event_listener implements EventSubscriberInterface
 			'topic_title'	=> $this->language->lang('UNKNOWN_TOPIC'),
 			'post_id'		=> $event['post_id'],
 			'delete_reason'	=> $event['softdelete_reason'],
-		];
+		);
 
 		// Fetch the forum name, topic title, and user name using the respective IDs.
 		$forum_name = $this->notification_service->query_forum_name($post_data['forum_id']);
@@ -319,14 +319,13 @@ class notification_event_listener implements EventSubscriberInterface
 		}
 
 		// Copy over the data necessary to generate the notification into a new array
-		$delete_data = [
-			'forum_id'			=> $query_data['forum_id'],
-			'forum_name'		=> $query_data['forum_name'],
-			'topic_title'		=> $query_data['topic_title'],
-			'topic_post_count'	=> $query_data['topic_posts_approved'],
-			'user_id'			=> $query_data['topic_poster'],
-			'user_name'			=> $query_data['topic_first_poster_name'],
-		];
+		$delete_data = array();
+		$delete_data['forum_id'] = $query_data['forum_id'];
+		$delete_data['forum_name'] = $query_data['forum_name'];
+		$delete_data['topic_title'] = $query_data['topic_title'];
+		$delete_data['topic_post_count'] = $query_data['topic_posts_approved'];
+		$delete_data['user_id'] = $query_data['topic_poster'];
+		$delete_data['user_name'] = $query_data['topic_first_poster_name'];
 
 		$this->notify_topic_deleted($delete_data, $webhook_url);
 	}
@@ -353,24 +352,22 @@ class notification_event_listener implements EventSubscriberInterface
 
 		// Get the ID needed to access $event['data'], then extract all relevant data from the event that we need to generate the notification
 		$id = array_slice($event['ids'], -1)[0];
-		$event_data = $event['data'][$id];
-
-		$lock_data = [
-			'forum_id'			=> $event_data['forum_id'],
-			'forum_name'		=> $event_data['forum_name'],
-			'topic_id'			=> $event_data['topic_id'],
-			'topic_title'		=> $event_data['topic_title'],
-			'topic_user_id'		=> $event_data['topic_poster'],
-			'topic_user_name'	=> $event_data['topic_first_poster_name'],
-			// only used for post_[un]lock events, not always set
-			'post_id'			=> $event_data['post_id'] ?? '',
-			'post_subject'		=> $event_data['post_subject'] ?? '',
-			'post_user_id'		=> $event_data['poster_id'] ?? '',
-			'post_user_name'	=> $event_data['username'] ?? '',
-		];
+
+		$lock_data = array();
+		$lock_data['forum_id'] = $event['data'][$id]['forum_id'];
+		$lock_data['forum_name'] = $event['data'][$id]['forum_name'];
+		$lock_data['post_id'] = $event['data'][$id]['post_id'] ?? ''; // only used for post_[un]lock events
+		$lock_data['post_subject'] = $event['data'][$id]['post_subject'] ?? ''; // only used for post_[un]lock events
+		$lock_data['topic_id'] = $event['data'][$id]['topic_id'];
+		$lock_data['topic_title'] = $event['data'][$id]['topic_title'];
+		// Two sets of user data captured: one for the post (if applicable) and one for the user that started the topic
+		$lock_data['post_user_id'] = $event['data'][$id]['poster_id'] ?? ''; // only used for post_[un]lock events
+		$lock_data['post_user_name'] = $event['data'][$id]['username'] ?? ''; // only used for post_[un]lock events
+		$lock_data['topic_user_id'] = $event['data'][$id]['topic_poster'];
+		$lock_data['topic_user_name'] = $event['data'][$id]['topic_first_poster_name'];
 
 		// If the forum the post was made in does not have notifications enabled or the topic/poar is not visible, do nothing more.
-		$topic_visibile = $event_data['topic_visibility'] == 1;
+		$topic_visibile = $event['data'][$id]['topic_visibility'] == 1;
 		$webhook_url = $this->notification_service->get_forum_notification_url($lock_data['forum_id']);
 		if (!$webhook_url || !$topic_visibile)
 		{
@@ -432,7 +429,7 @@ class notification_event_listener implements EventSubscriberInterface
 	 */
 	public function handle_user_activate_action($event)
 	{
-		$user_data = [];
+		$user_data = array();
 		if ($event['user_id'])
 		{
 			$user_data['user_id'] = $event['user_id'];
@@ -461,7 +458,7 @@ class notification_event_listener implements EventSubscriberInterface
 	public function handle_user_delete_action($event)
 	{
 		// Extract the IDs and names of all deleted users to pass along in an array of (id => name)
-		$user_data = [];
+		$user_data = array();
 		foreach ($event['user_ids'] as $id)
 		{
 			$user_data[$id] = $event['user_rows'][$id]['username'];
diff --git "[ORIGINAL]/mober\\discordnotifications/ext.php" "[ORIGINAL]/mober\\discordnotifications/ext.php"
deleted file mode 100644
--- "[ORIGINAL]/mober\\discordnotifications/ext.php"
+++ /dev/null
@@ -1,23 +0,0 @@
-<?php
-
-namespace mober\discordnotifications;
-
-class ext extends \phpbb\extension\base
-{
-	/**
-	 * {@inheritDoc}
-	 */
-	public function is_enableable()
-	{
-		$language = $this->container->get('language');
-		$language->add_lang('acp_discord_notifications', 'mober/discordnotifications');
-
-		$curl_available = extension_loaded('curl');
-		if (!$curl_available)
-		{
-			return $language->lang('DN_MISSING_CURL');
-		}
-
-		return true;
-	}
-}
diff --git "[ORIGINAL]/mober\\discordnotifications/language/de/acp_discord_notifications.php" "[FORUM_EXT]/mober\\discordnotifications/language/de/acp_discord_notifications.php"
--- "[ORIGINAL]/mober\\discordnotifications/language/de/acp_discord_notifications.php"
+++ "[FORUM_EXT]/mober\\discordnotifications/language/de/acp_discord_notifications.php"
@@ -21,12 +21,13 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, array(
 	// ACP Extension Settings Page
 	'DN_ACP_DESCRIPTION'			=> 'Diese Einstellungen erlauben es, bei verschiedenen Ereignissen eine Benachrichtigung an einen Discord-Kanal zu schicken.',
-	'DN_MISSING_CURL'				=> 'Damit diese Erweiterung funktioniert, musst du das <a href="https://www.php.net/manual/de/curl.installation.php">ext-curl Modul für PHP installieren.</a>',
 
 	'DN_MAIN_SETTINGS'				=> 'Konfiguration',
 	'DN_MASTER_ENABLE'				=> 'Discord Benachrichtigungen aktivieren',
+	'DN_WEBHOOK_URL'				=> 'Discord Webhook URL',
+	'DN_WEBHOOK_DESCRIPTION'		=> 'Webhook für einen Discord-Kanal. Weitere Informationen gibt es in <a href="https://support.discordapp.com/hc/en-us/articles/228383668-Intro-to-Webhooks">diesem Artikel</a>.',
 	'DN_POST_PREVIEW_LENGTH'		=> 'Länge der Vorschau',
-	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Wie viele Zeichen eines Beitrags sollen in der Vorschau angezeigt werden? (%1$d-%2$d), 0 deaktiviert die Vorschau)',
+	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Wie viele Zeichen eines Posts sollen in der Vorschau angezeigt werden? (10-2000, 0 deaktiviert die Vorschau)',
 	'DN_TEST_MESSAGE'				=> 'Nachricht',
 	'DN_TEST_MESSAGE_TEXT'			=> 'Dies ist ein Test: Hallo, Discord!',
 	'DN_TEST_DESCRIPTION'			=> 'Nachricht, die beim Starten eines Tests geschickt wird.',
@@ -41,11 +42,11 @@ $lang = array_merge($lang, array(
 	'DN_WEBHOOK_SETTINGS'			=> 'Einträge Bearbeiten',
 	'DN_WEBHOOK_SETTINGS_DESCRIPTION' => 'Hier können bestehende Einträge bearbeitet oder gelöscht werden.',
 	'DN_WEBHOOK_NEW'				=> 'Neuen Eintrag anlegen',
-	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Hier kann ein neuer Eintrag angelegt werden. Die URL muss vollständig sein und mit "http" oder "https" beginnen.',
+	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Hier kann ein neuer Eintrag angelegt werden. Um die URL zu erhalten, auf einen Discord-Kanal rechtsklicken, "Kanal bearbeiten" wählen und dann unter "Integrationen" einen neuen Webhook anlegen.',
 	'DN_WEBHOOK_NEW_ALIAS'			=> 'Neuer Alias',
 	'DN_WEBHOOK_NEW_ALIAS_DESCRIPTION' => 'Frei wählbar, z.B. der Names des Channels, auf den der Webhook zeigt (wie "öffentlich" or "marktplatz").',
-	'DN_WEBHOOK_NEW_URL'			=> 'Discord Webhook URL',
-	'DN_WEBHOOK_NEW_URL_DESCRIPTION'=> 'Webhook für einen Discord-Kanal. Weitere Informationen gibt es in <a href="https://support.discord.com/hc/de/articles/228383668-Einleitung-in-Webhooks">diesem Artikel</a>.',
+	'DN_WEBHOOK_NEW_URL'			=> 'Neue URL',
+	'DN_WEBHOOK_NEW_URL_DESCRIPTION' => 'Webhook-URL, muss mit http/https beginnen, z.B. <samp>https://discord.com/api/webhooks/1063...</samp>',
 	'DN_WEBHOOK_SELECT'				=> 'Webhook auswählen',
 	'DN_WEBHOOK_DEFAULT'			=> 'Forenübergreifende Ereignisse',
 	'DN_WEBHOOK_DEFAULT_DESCRIPTION' => 'Webhook für Ereignisse, die nicht zu einem bestimmten Forum gehören (z.B. Benutzer erstellt/gelöscht)',
@@ -53,18 +54,18 @@ $lang = array_merge($lang, array(
 
 	'DN_TYPE_SETTINGS'				=> 'Benachrichtigungstypen',
 	'DN_TYPE_DESCRIPTION'			=> 'Wähle aus, welche Ereignisse eine Benachrichtigung auslösen sollen.',
-	'DN_POST_CREATE'				=> 'Beitrag erstellt',
-	'DN_POST_UPDATE'				=> 'Beitrag aktualisiert',
-	'DN_POST_DELETE'				=> 'Beitrag gelöscht',
-	'DN_POST_LOCK'					=> 'Beitrag gesperrt',
-	'DN_POST_UNLOCK'				=> 'Beitrag entsperrt',
-	'DN_POST_APPROVE'				=> 'Beitrag freigegeben',
+	'DN_POST_CREATE'				=> 'Post erstellt',
+	'DN_POST_UPDATE'				=> 'Post aktualisiert',
+	'DN_POST_DELETE'				=> 'Post gelöscht',
+	'DN_POST_LOCK'					=> 'Post gesperrt',
+	'DN_POST_UNLOCK'				=> 'Post entsperrt',
+	'DN_POST_APPROVE'				=> 'Post freigeschaltet',
 	'DN_TOPIC_CREATE'				=> 'Thema erstellt',
 	'DN_TOPIC_UPDATE'				=> 'Thema aktualisiert',
 	'DN_TOPIC_DELETE'				=> 'Thema gelöscht',
 	'DN_TOPIC_LOCK'					=> 'Thema gesperrt',
 	'DN_TOPIC_UNLOCK'				=> 'Thema entsperrt',
-	'DN_TOPIC_APPROVE'				=> 'Thema freigegeben',
+	'DN_TOPIC_APPROVE'				=> 'Thema freigeschaltet',
 	'DN_USER_CREATE'				=> 'Benutzer erstellt',
 	'DN_USER_DELETE'				=> 'Benutzer gelöscht',
 
@@ -79,6 +80,7 @@ $lang = array_merge($lang, array(
 
 	// Success/Failure messages that can be generated once the user saves
 	'DN_SETTINGS_SAVED'				=> 'Einstellungen aktualisiert.',
+	'DN_MASTER_WEBHOOK_REQUIRED'	=> 'Benachrichtigungen können nur aktiviert werden, wenn eine gültige Webhook-URL hinterlegt ist.',
 	'DN_WEBHOOK_URL_INVALID'		=> 'Die Webhook-URL ist ungültig. Bitte überprüfe die Konfiguration.',
-	'DN_POST_PREVIEW_INVALID'		=> 'Länge der Vorschau muss zwischen %1$d und %2$d Zeichen sein (oder 0 zum Deaktivieren der Vorschau).',
+	'DN_POST_PREVIEW_INVALID'		=> 'Länge der Vorschau muss zwischen 10 und 2000 Zeichen sein (oder 0 zum Deaktivieren der Vorschau).',
 ));
diff --git "[ORIGINAL]/mober\\discordnotifications/language/de/info_acp_discord_notifications.php" "[FORUM_EXT]/mober\\discordnotifications/language/de/info_acp_discord_notifications.php"
--- "[ORIGINAL]/mober\\discordnotifications/language/de/info_acp_discord_notifications.php"
+++ "[FORUM_EXT]/mober\\discordnotifications/language/de/info_acp_discord_notifications.php"
@@ -19,9 +19,7 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, array(
 	// ACP Module
 	'ACP_DISCORD_NOTIFICATIONS'					=> 'Discord Benachrichtigungen',
-	'ACP_DISCORD_NOTIFICATIONS_SETTINGS'		=> 'Einstellungen',
-	'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS'		=> 'Webhooks',
-	'ACP_DISCORD_NOTIFICATIONS_MAPPING'			=> 'Zuordnung',
+	'ACP_DISCORD_NOTIFICATIONS_TITLE'			=> 'Discord Konfiguration',
 
 	// ACP Logs
 	'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE'		=> 'Discord Benachrichtigungen: Einstellungen aktualisiert',
diff --git "[ORIGINAL]/mober\\discordnotifications/language/en/acp_discord_notifications.php" "[FORUM_EXT]/mober\\discordnotifications/language/en/acp_discord_notifications.php"
--- "[ORIGINAL]/mober\\discordnotifications/language/en/acp_discord_notifications.php"
+++ "[FORUM_EXT]/mober\\discordnotifications/language/en/acp_discord_notifications.php"
@@ -21,12 +21,13 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, array(
 	// ACP Extension Settings Page
 	'DN_ACP_DESCRIPTION'			=> 'These settings allow for various forum events to send notification messages to a Discord server.',
-	'DN_MISSING_CURL'				=> 'Please install the <a href="https://www.php.net/manual/en/curl.installation.php">ext-curl module for PHP</a>, otherwise this extension will not work.',
 
 	'DN_MAIN_SETTINGS'				=> 'Main Settings',
 	'DN_MASTER_ENABLE'				=> 'Enable Discord Notifications',
+	'DN_WEBHOOK_URL'				=> 'Discord Webhook URL',
+	'DN_WEBHOOK_DESCRIPTION'		=> 'The URL of the webhook generated by the Discord server. See <a href="https://support.discordapp.com/hc/en-us/articles/228383668-Intro-to-Webhooks">this article</a> to learn how to create a new webhook.',
 	'DN_POST_PREVIEW_LENGTH'		=> 'Post Preview Length',
-	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Specify the number of characters to display in a post preview (%1$d-%2$d). A zero value disables post preview.',
+	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Specify the number of characters to display in a post preview (10 - 2000). A zero value disables post preview.',
 	'DN_TEST_MESSAGE'				=> 'Message',
 	'DN_TEST_MESSAGE_TEXT'			=> 'This is a test: Hello Discord!',
 	'DN_TEST_DESCRIPTION'			=> 'A message to send to Discord to verify that the connection with phpBB is functioning.',
@@ -41,11 +42,11 @@ $lang = array_merge($lang, array(
 	'DN_WEBHOOK_SETTINGS'			=> 'Edit entries',
 	'DN_WEBHOOK_SETTINGS_DESCRIPTION' => 'Edit or delete existing entries.',
 	'DN_WEBHOOK_NEW'				=> 'Create new entry',
-	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Create a new entry. A full URL is required, starting with "http" or "https".',
+	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Create a new entry. To get the Webhook-URL, right click on a Discord channel, chose "Edit Channel", then go to "Integrations" to create a Webhook.',
 	'DN_WEBHOOK_NEW_ALIAS'			=> 'New Alias',
 	'DN_WEBHOOK_NEW_ALIAS_DESCRIPTION' => 'Can be freely chosen, for example something that describes the target channel of the webhook (like "public" or "marketplace").',
-	'DN_WEBHOOK_NEW_URL'			=> 'Discord Webhook URL',
-	'DN_WEBHOOK_NEW_URL_DESCRIPTION'=> 'The URL of the webhook generated by the Discord server. See <a href="https://support.discordapp.com/hc/en-us/articles/228383668-Intro-to-Webhooks">this article</a> to learn how to create a new webhook.',
+	'DN_WEBHOOK_NEW_URL'			=> 'New URL',
+	'DN_WEBHOOK_NEW_URL_DESCRIPTION' => 'Webhook-URL, must start with http/https, e.g. <samp>https://discord.com/api/webhooks/1063...</samp>',
 	'DN_WEBHOOK_SELECT'				=> 'Select Webhook',
 	'DN_WEBHOOK_DEFAULT'			=> 'Global Events',
 	'DN_WEBHOOK_DEFAULT_DESCRIPTION' => 'Webhook for global events not related to a specific forum, e.g. user creation/deletion',
@@ -79,6 +80,7 @@ $lang = array_merge($lang, array(
 
 	// Success/Failure messages that can be generated once the user saves
 	'DN_SETTINGS_SAVED'				=> 'Discord Notification settings modified successfully.',
+	'DN_MASTER_WEBHOOK_REQUIRED'	=> 'A valid Discord webhook URL is required to enable notifications.',
 	'DN_WEBHOOK_URL_INVALID'		=> 'Discord webhook URL must be a full and valid URL.',
-	'DN_POST_PREVIEW_INVALID'		=> 'Post preview length must be a number between %1$d and %2$d, or 0 to disable previews.',
+	'DN_POST_PREVIEW_INVALID'		=> 'Post preview length must be a number between 10 and 2000, or 0 to disable previews.',
 ));
diff --git "[ORIGINAL]/mober\\discordnotifications/language/en/info_acp_discord_notifications.php" "[FORUM_EXT]/mober\\discordnotifications/language/en/info_acp_discord_notifications.php"
--- "[ORIGINAL]/mober\\discordnotifications/language/en/info_acp_discord_notifications.php"
+++ "[FORUM_EXT]/mober\\discordnotifications/language/en/info_acp_discord_notifications.php"
@@ -19,9 +19,7 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, array(
 	// ACP Module
 	'ACP_DISCORD_NOTIFICATIONS'					=> 'Discord Notifications',
-	'ACP_DISCORD_NOTIFICATIONS_SETTINGS'		=> 'Settings',
-	'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS'		=> 'Webhooks',
-	'ACP_DISCORD_NOTIFICATIONS_MAPPING'			=> 'Mapping',
+	'ACP_DISCORD_NOTIFICATIONS_TITLE'			=> 'Discord Notification Settings',
 
 	// ACP Logs
 	'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE'		=> 'Modified Discord notification settings',
diff --git "[ORIGINAL]/mober\\discordnotifications/language/fr/acp_discord_notifications.php" "[FORUM_EXT]/mober\\discordnotifications/language/fr/acp_discord_notifications.php"
--- "[ORIGINAL]/mober\\discordnotifications/language/fr/acp_discord_notifications.php"
+++ "[FORUM_EXT]/mober\\discordnotifications/language/fr/acp_discord_notifications.php"
@@ -1,11 +1,11 @@
 <?php
 /**
  *
- * Discord Notifications extension for the phpBB Forum Software package.
+ * Discord Notifications. An extension for the phpBB Forum Software package.
+ * French translation by Galixte (http://www.galixte.com)
  *
- * @copyright (c) 2018, Tyler Olsen, https://github.com/rootslinux
- * @copyright (c) 2022, French translation by Fred Rimbert https://forums.caforum.fr
- * @license GNU General Public License, version 2 (GPL-2.0)
+ * @copyright (c) 2018 Tyler Olsen <https://github.com/rootslinux>
+ * @license GNU General Public License, version 2 (GPL-2.0-only)
  *
  * This file contains the language strings for the ACP settings page for this extension.
  */
@@ -42,35 +42,36 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, array(
 	// ACP Extension Settings Page
 	'DN_ACP_DESCRIPTION'			=> 'Depuis cette page il est possible de définir les paramètres permettant à différents évènements du forum d’être envoyés comme notification sur un serveur Discord.',
-	'DN_MISSING_CURL'				=> 'Pour que cette extension fonctionne, tu dois installer le module <a href="https://www.php.net/manual/fr/curl.installation.php">ext-curl pour PHP</a>.',
 
 	'DN_MAIN_SETTINGS'				=> 'Paramètres généraux',
 	'DN_MASTER_ENABLE'				=> 'Activer les notifications Discord',
+	'DN_WEBHOOK_URL'				=> 'URL Webhook de Discord',
+	'DN_WEBHOOK_DESCRIPTION'		=> 'Permet de saisir l’adresse URL Webhook du serveur Discord généré par le serveur Discord. Voir <a href="https://support.discordapp.com/hc/fr/articles/228383668-Intro-to-Webhooks">cet article</a> pour apprendre comment créer un nouveau Webhook.',
 	'DN_POST_PREVIEW_LENGTH'		=> 'Longueur de l’aperçu des messages',
-	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Permet de saisir le nombre de caractères à afficher dans l’aperçu des messages (%1$d-%2$d). Définir sur la valeur 0 pour désactiver l’aperçu des messages.',
+	'DN_POST_PREVIEW_DESCRIPTION'	=> 'Permet de saisir le nombre de caractères à afficher dans l’aperçu des messages (10 - 2000). Définir sur la valeur 0 pour désactiver l’aperçu des messages.',
 	'DN_TEST_MESSAGE'				=> 'Message',
 	'DN_TEST_MESSAGE_TEXT'			=> 'Texte du message de test : Hello Discord!',
 	'DN_TEST_DESCRIPTION'			=> 'Permet d’envoyer un message sur le serveur Discord afin de vérifier que la connexion avec phpBB est fonctionnelle.',
 	'DN_SEND_TEST'					=> 'Envoyer un message de test',
 	'DN_SEND_TEST_DESCRIPTION'		=> 'Permet d’envoyer le contenu du message de test au Webhook du serveur Discord. À utiliser pour vérifier que le Webhook est fonctionnel.',
-	'DN_CONNECT_TIMEOUT'			=> 'Délai de connexion',
-	'DN_CONNECT_TO_DESCRIPTION'		=> 'Délai d‘attente en secondes pour établir une connexion au point de terminaison Webhook.',
-	'DN_EXEC_TIMEOUT'				=> 'Délai de transfert',
-	'DN_EXEC_TO_DESCRIPTION'		=> 'Délai d‘attente en secondes pour le transfert de données.',
-	'DN_TEST_SETTINGS'				=> 'Paramètres d‘essai',
+	'DN_CONNECT_TIMEOUT'			=> 'Connect timeout',
+	'DN_CONNECT_TO_DESCRIPTION'		=> 'Timeout in seconds to establish a connection to the Webhook endpoint.',
+	'DN_EXEC_TIMEOUT'				=> 'Transfer timeout',
+	'DN_EXEC_TO_DESCRIPTION'		=> 'Timeout in seconds for data transfer.',
+	'DN_TEST_SETTINGS'				=> 'Test Settings',
 
-	'DN_WEBHOOK_SETTINGS'			=> 'Modifier les entrées',
-	'DN_WEBHOOK_SETTINGS_DESCRIPTION' => 'Modifier les entrées existantes. Une entrée est supprimée si le champ URL est vide.',
-	'DN_WEBHOOK_NEW'				=> 'Créer une nouvelle entrée',
-	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Créez une nouvelle entrée. Une URL complète est requise, commençant par "http" ou "https".',
-	'DN_WEBHOOK_NEW_ALIAS'			=> 'Nouvel alias',
+	'DN_WEBHOOK_SETTINGS'			=> 'Edit entries',
+	'DN_WEBHOOK_SETTINGS_DESCRIPTION' => 'Edit or delete existing entries.',
+	'DN_WEBHOOK_NEW'				=> 'Create new entry',
+	'DN_WEBHOOK_NEW_DESCRIPTION'	=> 'Create a new entry. To get the Webhook-URL, right click on a Discord channel, chose "Edit Channel", then go to "Integrations" to create a Webhook.',
+	'DN_WEBHOOK_NEW_ALIAS'			=> 'New Alias',
 	'DN_WEBHOOK_NEW_ALIAS_DESCRIPTION' => 'Can be freely chosen, for example something that describes the target channel of the webhook (like "public" or "marketplace").',
-	'DN_WEBHOOK_NEW_URL'			=> 'URL Webhook de Discord',
-	'DN_WEBHOOK_NEW_URL_DESCRIPTION'=> 'Permet de saisir l’adresse URL Webhook du serveur Discord généré par le serveur Discord. Voir <a href="https://support.discordapp.com/hc/fr/articles/228383668-Intro-to-Webhooks">cet article</a> pour apprendre comment créer un nouveau Webhook.',
-	'DN_WEBHOOK_SELECT'				=> 'Sélectionnez Webhook',
-	'DN_WEBHOOK_DEFAULT'			=> 'Événements mondiaux',
-	'DN_WEBHOOK_DEFAULT_DESCRIPTION' => 'Webhook pour les événements mondiaux non liés à un forum spécifique, par ex. création/suppression d‘utilisateur',
-	'DN_NO_WEBHOOKS'				=> 'Aucune entrée n‘existe.',
+	'DN_WEBHOOK_NEW_URL'			=> 'New URL',
+	'DN_WEBHOOK_NEW_URL_DESCRIPTION' => 'Webhook-URL, must start with http/https, e.g. <samp>https://discord.com/api/webhooks/1063...</samp>',
+	'DN_WEBHOOK_SELECT'				=> 'Select Webhook',
+	'DN_WEBHOOK_DEFAULT'			=> 'Global Events',
+	'DN_WEBHOOK_DEFAULT_DESCRIPTION' => 'Webhook for global events not related to a specific forum, e.g. user creation/deletion',
+	'DN_NO_WEBHOOKS'				=> 'No entries exist.',
 
 	'DN_TYPE_SETTINGS'				=> 'Types de notification',
 	'DN_TYPE_DESCRIPTION'			=> 'Permet de sélectionner quels types de notification devraient être générés sous forme de messages envoyés sur le serveur Discord.',
@@ -100,6 +101,7 @@ $lang = array_merge($lang, array(
 
 	// Success/Failure messages that can be generated once the user saves
 	'DN_SETTINGS_SAVED'				=> 'Les paramètres de notification Discord ont été modifiés avec succès !',
+	'DN_MASTER_WEBHOOK_REQUIRED'	=> 'Une adresse URL Webhook du serveur Discord est requise pour activer les notifications.',
 	'DN_WEBHOOK_URL_INVALID'		=> 'L’adresse URL Webhook du serveur Discord doit être complète et correspondre à une adresse URL valide.',
-	'DN_POST_PREVIEW_INVALID'		=> 'La longueur de l’aperçu des messages doit être comprise entre %1$d et %2$d ou définie sur 0 pour la désactivation de l’aperçu.',
+	'DN_POST_PREVIEW_INVALID'		=> 'La longueur de l’aperçu des messages doit être comprise entre 10 et 2000 ou définie sur 0 pour la désactivation de l’aperçu.',
 ));
diff --git "[ORIGINAL]/mober\\discordnotifications/language/fr/discord_notification_messages.php" "[FORUM_EXT]/mober\\discordnotifications/language/fr/discord_notification_messages.php"
--- "[ORIGINAL]/mober\\discordnotifications/language/fr/discord_notification_messages.php"
+++ "[FORUM_EXT]/mober\\discordnotifications/language/fr/discord_notification_messages.php"
@@ -1,11 +1,11 @@
 <?php
 /**
  *
- * Discord Notifications extension for the phpBB Forum Software package.
+ * Discord Notifications. An extension for the phpBB Forum Software package.
+ * French translation by Galixte (http://www.galixte.com)
  *
- * @copyright (c) 2018, Tyler Olsen, https://github.com/rootslinux
- * @copyright (c) 2022, French translation by Fred Rimbert https://forums.caforum.fr
- * @license GNU General Public License, version 2 (GPL-2.0)
+ * @copyright (c) 2018 Tyler Olsen <https://github.com/rootslinux>
+ * @license GNU General Public License, version 2 (GPL-2.0-only)
  *
  * This file contains the language strings for the ACP settings page for this extension.
  */
diff --git "[ORIGINAL]/mober\\discordnotifications/language/fr/info_acp_discord_notifications.php" "[FORUM_EXT]/mober\\discordnotifications/language/fr/info_acp_discord_notifications.php"
--- "[ORIGINAL]/mober\\discordnotifications/language/fr/info_acp_discord_notifications.php"
+++ "[FORUM_EXT]/mober\\discordnotifications/language/fr/info_acp_discord_notifications.php"
@@ -1,11 +1,11 @@
 <?php
 /**
  *
- * Discord Notifications extension for the phpBB Forum Software package.
+ * Discord Notifications. An extension for the phpBB Forum Software package.
+ * French translation by Galixte (http://www.galixte.com)
  *
- * @copyright (c) 2018, Tyler Olsen, https://github.com/rootslinux
- * @copyright (c) 2022, French translation by Fred Rimbert https://forums.caforum.fr
- * @license GNU General Public License, version 2 (GPL-2.0)
+ * @copyright (c) 2018 Tyler Olsen <https://github.com/rootslinux>
+ * @license GNU General Public License, version 2 (GPL-2.0-only)
  *
  * This file contains the language strings for the ACP settings page for this extension.
  */
@@ -42,13 +42,11 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, array(
 	// ACP Module
 	'ACP_DISCORD_NOTIFICATIONS'					=> 'Notifications Discord',
-	'ACP_DISCORD_NOTIFICATIONS_SETTINGS'		=> 'Paramètres',
-	'ACP_DISCORD_NOTIFICATIONS_WEBHOOKS'		=> 'Webhooks',
-	'ACP_DISCORD_NOTIFICATIONS_MAPPING'			=> 'Mapping',
+	'ACP_DISCORD_NOTIFICATIONS_TITLE'			=> 'Paramètres',
 
 	// ACP Logs
 	'ACP_DISCORD_NOTIFICATIONS_LOG_UPDATE'		=> 'Paramètres des notifications Discord modifiées',
-	'ACP_DISCORD_NOTIFICATIONS_WEBHOOK_ERROR'	=> 'Discord Webhook a renvoyé le code d‘état HTTP %d',
-	'ACP_DISCORD_NOTIFICATIONS_CURL_ERROR'		=> 'Code d‘erreur Discord Webhook cURL %d',
-	'ACP_DISCORD_NOTIFICATIONS_JSON_ERROR'		=> 'Erreur d‘encodage Discord JSON : %s',
+	'ACP_DISCORD_NOTIFICATIONS_WEBHOOK_ERROR'	=> 'Discord Webhook returned HTTP status code %d',
+	'ACP_DISCORD_NOTIFICATIONS_CURL_ERROR'		=> 'Discord Webhook cURL error code %d',
+	'ACP_DISCORD_NOTIFICATIONS_JSON_ERROR'		=> 'Discord JSON encode error: %s',
 ));
diff --git "[ORIGINAL]/mober\\discordnotifications/migrations/create_tables.php" "[FORUM_EXT]/mober\\discordnotifications/migrations/create_tables.php"
--- "[ORIGINAL]/mober\\discordnotifications/migrations/create_tables.php"
+++ "[FORUM_EXT]/mober\\discordnotifications/migrations/create_tables.php"
@@ -12,7 +12,7 @@ class create_tables extends \phpbb\db\migration\migration
 {
 	static public function depends_on()
 	{
-		return ['\mober\discordnotifications\migrations\extension_installation'];
+		return array('\mober\discordnotifications\migrations\extension_installation');
 	}
 
 	/**
@@ -21,23 +21,23 @@ class create_tables extends \phpbb\db\migration\migration
 	*/
 	public function update_schema()
 	{
-		return [
-			'add_tables' => [
-				$this->table_prefix . 'discord_webhooks' => [
-					'COLUMNS' => [
-						'alias'	=> [
+		return array(
+			'add_tables' => array (
+				$this->table_prefix . 'discord_webhooks' => array (
+					'COLUMNS' => array (
+						'alias' => array (
 							'VCHAR:255',
-							'',
-						],
-						'url' => [
+							''
+						),
+						'url' => array (
 							'VCHAR:255',
-							'',
-						],
-					],
+							''
+						),
+					),
 					'PRIMARY_KEY' => 'alias',
-				],
-			],
-		];
+				),
+			),
+		);
 	}
 
 	/**
@@ -46,10 +46,10 @@ class create_tables extends \phpbb\db\migration\migration
 	*/
 	public function revert_schema()
 	{
-		return [
-			'drop_tables' => [
+		return array (
+			'drop_tables' => array (
 				$this->table_prefix . 'discord_webhooks',
-			],
-		];
+			)
+		);
 	}
 }
diff --git "[ORIGINAL]/mober\\discordnotifications/migrations/extension_installation.php" "[FORUM_EXT]/mober\\discordnotifications/migrations/extension_installation.php"
--- "[ORIGINAL]/mober\\discordnotifications/migrations/extension_installation.php"
+++ "[FORUM_EXT]/mober\\discordnotifications/migrations/extension_installation.php"
@@ -38,13 +38,13 @@ class extension_installation extends \phpbb\db\migration\migration
 	*/
 	public function update_schema()
 	{
-		return [
-			'add_columns' => [
-				$this->table_prefix . 'forums' => [
-					'discord_notifications' => ['VCHAR:255', ''],
-				],
-			],
-		];
+		return array(
+			'add_columns'	=> array(
+				$this->table_prefix . 'forums'	=> array(
+					'discord_notifications' => array('VCHAR:255', ''),
+				),
+			),
+		);
 	}
 
 	/**
@@ -55,13 +55,13 @@ class extension_installation extends \phpbb\db\migration\migration
 	*/
 	public function revert_schema()
 	{
-		return [
-			'drop_columns' => [
-				$this->table_prefix . 'forums' => [
+		return array(
+			'drop_columns'	=> array(
+				$this->table_prefix . 'forums'	=> array(
 					'discord_notifications',
-				],
-			],
-		];
+				),
+			),
+		);
 	}
 
 	/**
@@ -74,55 +74,55 @@ class extension_installation extends \phpbb\db\migration\migration
 	*/
 	public function update_data()
 	{
-		return [
+		return array(
 			// The "master switch" that enables notifications to be sent. This can only be set to true if the webhook URL is also valid
-			['config.add', ['discord_notifications_enabled', 0]],
+			array('config.add', array('discord_notifications_enabled', 0)),
 			// The maximum number of characters permitted in a discord notification message
-			['config.add', ['discord_notifications_post_preview_length', 200]],
+			array('config.add', array('discord_notifications_post_preview_length', 200)),
 			// Timeout values
-			['config.add', ['discord_notifications_connect_timeout', 2]],
-			['config.add', ['discord_notifications_exec_timeout', 2]],
+			array('config.add', array('discord_notifications_connect_timeout', 2)),
+			array('config.add', array('discord_notifications_exec_timeout', 2)),
 
 			// These configurations represent the various types of notifications that can be sent, which can be individually enabled or disabled.
 			// Upon installation, every notification type is enabled by default.
 
 			// Post notifications
-			['config.add', ['discord_notification_type_post_create', 1]],
-			['config.add', ['discord_notification_type_post_update', 1]],
-			['config.add', ['discord_notification_type_post_delete', 1]],
-			['config.add', ['discord_notification_type_post_lock', 1]],
-			['config.add', ['discord_notification_type_post_unlock', 1]],
-			['config.add', ['discord_notification_type_post_approve', 1]],
+			array('config.add', array('discord_notification_type_post_create', 1)),
+			array('config.add', array('discord_notification_type_post_update', 1)),
+			array('config.add', array('discord_notification_type_post_delete', 1)),
+			array('config.add', array('discord_notification_type_post_lock', 1)),
+			array('config.add', array('discord_notification_type_post_unlock', 1)),
+			array('config.add', array('discord_notification_type_post_approve', 1)),
 
 			// Topic notifications
-			['config.add', ['discord_notification_type_topic_create', 1]],
-			['config.add', ['discord_notification_type_topic_update', 1]],
-			['config.add', ['discord_notification_type_topic_delete', 1]],
-			['config.add', ['discord_notification_type_topic_lock', 1]],
-			['config.add', ['discord_notification_type_topic_unlock', 1]],
-			['config.add', ['discord_notification_type_topic_approve', 1]],
+			array('config.add', array('discord_notification_type_topic_create', 1)),
+			array('config.add', array('discord_notification_type_topic_update', 1)),
+			array('config.add', array('discord_notification_type_topic_delete', 1)),
+			array('config.add', array('discord_notification_type_topic_lock', 1)),
+			array('config.add', array('discord_notification_type_topic_unlock', 1)),
+			array('config.add', array('discord_notification_type_topic_approve', 1)),
 
 			// User notifications
-			['config.add', ['discord_notification_type_user_create', 1]],
-			['config.add', ['discord_notification_type_user_delete', 1]],
+			array('config.add', array('discord_notification_type_user_create', 1)),
+			array('config.add', array('discord_notification_type_user_delete', 1)),
 
 			// Default channel
-			['config.add', ['discord_notification_default_webhook', '']],
+			array('config.add', array('discord_notification_default_webhook', '')),
 
 			// Standard ACP module data
-			['module.add', [
+			array('module.add', array(
 				'acp',
 				'ACP_CAT_DOT_MODS',
-				'ACP_DISCORD_NOTIFICATIONS',
-			]],
-			['module.add', [
+				'ACP_DISCORD_NOTIFICATIONS'
+			)),
+			array('module.add', array(
 				'acp',
 				'ACP_DISCORD_NOTIFICATIONS',
-				[
+				array(
 					'module_basename'	=> '\mober\discordnotifications\acp\discord_notifications_module',
-					'modes'           => ['settings'],
-				],
-			]],
-		];
+					'modes'				=> array('settings'),
+				),
+			)),
+		);
 	}
 }
diff --git "[ORIGINAL]/mober\\discordnotifications/migrations/v308/add_modules.php" "[ORIGINAL]/mober\\discordnotifications/migrations/v308/add_modules.php"
deleted file mode 100644
--- "[ORIGINAL]/mober\\discordnotifications/migrations/v308/add_modules.php"
+++ /dev/null
@@ -1,39 +0,0 @@
-<?php
-
-namespace mober\discordnotifications\migrations\v308;
-
-class add_modules extends \phpbb\db\migration\migration
-{
-	static public function depends_on()
-	{
-		return ['\mober\discordnotifications\migrations\extension_installation'];
-	}
-
-	public function update_data()
-	{
-		return [
-			['module.add', [
-				'acp',
-				'ACP_DISCORD_NOTIFICATIONS',
-				[
-					'module_basename'	=> '\mober\discordnotifications\acp\discord_notifications_module',
-					'modes'				=> [
-						'webhooks',
-						'mapping',
-					],
-				],
-			]],
-			['custom', [
-				[$this, 'rename_settings_module']
-			]],
-		];
-	}
-
-	public function rename_settings_module()
-	{
-		$sql = 'UPDATE ' . MODULES_TABLE . "
-			SET module_langname = 'ACP_DISCORD_NOTIFICATIONS_SETTINGS'
-			WHERE module_langname = 'ACP_DISCORD_NOTIFICATIONS_TITLE'";
-		$this->sql_query($sql);
-	}
-}
diff --git "[ORIGINAL]/mober\\discordnotifications/migrations/v308/add_version.php" "[ORIGINAL]/mober\\discordnotifications/migrations/v308/add_version.php"
deleted file mode 100644
--- "[ORIGINAL]/mober\\discordnotifications/migrations/v308/add_version.php"
+++ /dev/null
@@ -1,24 +0,0 @@
-<?php
-
-namespace mober\discordnotifications\migrations\v308;
-
-class add_version extends \phpbb\db\migration\migration
-{
-	static public function depends_on()
-	{
-		return ['\mober\discordnotifications\migrations\extension_installation'];
-	}
-
-	public function effectively_installed()
-	{
-		return isset($this->config['discord_notification_version']) &&
-			version_compare($this->config['discord_notification_version'], '3.0.8', '>=');
-	}
-
-	public function update_data()
-	{
-		return [
-			['config.add', ['discord_notification_version', '3.0.8']],
-		];
-	}
-}
diff --git "[ORIGINAL]/mober\\discordnotifications/notification_service.php" "[FORUM_EXT]/mober\\discordnotifications/notification_service.php"
--- "[ORIGINAL]/mober\\discordnotifications/notification_service.php"
+++ "[FORUM_EXT]/mober\\discordnotifications/notification_service.php"
@@ -70,7 +70,7 @@ class notification_service
 	{
 		global $table_prefix;
 
-		if (!is_numeric($forum_id))
+		if (is_numeric($forum_id) == false)
 		{
 			return false;
 		}
@@ -118,7 +118,7 @@ class notification_service
 	 */
 	public function query_forum_name($forum_id)
 	{
-		if (!is_numeric($forum_id))
+		if (is_numeric($forum_id) == false)
 		{
 			return null;
 		}
@@ -138,7 +138,7 @@ class notification_service
 	 */
 	public function query_post_subject($post_id)
 	{
-		if (!is_numeric($post_id))
+		if (is_numeric($post_id) == false)
 		{
 			return null;
 		}
@@ -159,7 +159,7 @@ class notification_service
 	 */
 	public function query_topic_title($topic_id)
 	{
-		if (!is_numeric($topic_id))
+		if (is_numeric($topic_id) == false)
 		{
 			return null;
 		}
@@ -180,9 +180,9 @@ class notification_service
 	 */
 	public function query_topic_details($topic_id)
 	{
-		if (!is_numeric($topic_id))
+		if (is_numeric($topic_id) == false)
 		{
-			return [];
+			return array();
 		}
 
 		$sql = "SELECT
@@ -205,7 +205,7 @@ class notification_service
 	 */
 	public function query_user_name($user_id)
 	{
-		if (!is_numeric($user_id))
+		if (is_numeric($user_id) == false)
 		{
 			return false;
 		}
@@ -231,7 +231,7 @@ class notification_service
 	{
 		global $table_prefix;
 
-		if ($this->config['discord_notifications_enabled'] == 0 || !isset($message))
+		if ($this->config['discord_notifications_enabled'] == 0 || isset($message) == false)
 		{
 			return;
 		}
@@ -263,7 +263,7 @@ class notification_service
 	 */
 	public function force_send_discord_notification($discord_webhook_url, $message)
 	{
-		if (!filter_var($discord_webhook_url, FILTER_VALIDATE_URL) || !is_string($message) || $message == '')
+		if (!filter_var($discord_webhook_url, FILTER_VALIDATE_URL) || is_string($message) == false || $message == '')
 		{
 			return false;
 		}
@@ -290,20 +290,20 @@ class notification_service
 	 */
 	private function execute_discord_webhook($discord_webhook_url, $color, $message, $title = null, $preview = null, $footer = null)
 	{
-		if (!isset($discord_webhook_url) || $discord_webhook_url === '')
+		if (isset($discord_webhook_url) == false || $discord_webhook_url === '')
 		{
 			return false;
 		}
-		if (!is_integer($color) || $color < 0)
+		if (is_integer($color) == false || $color < 0)
 		{
 			// Use the default color if we did not receive a valid color value
 			$color = self::DEFAULT_COLOR;
 		}
-		if (!is_string($message) || $message == '')
+		if (is_string($message) == false || $message == '')
 		{
 			return false;
 		}
-		if (isset($footer) && (!is_string($footer) || $footer == ''))
+		if (isset($footer) == true && (is_string($footer) == false || $footer == ''))
 		{
 			return false;
 		}
@@ -341,14 +341,12 @@ class notification_service
 		$embed = [
 			'timestamp'   => date('c', time()),
 			'color'       => $color,
-			'description'	=> $message,
+			'description' => $message
 		];
 
 		if (isset($footer))
 		{
-			$embed['footer'] = [
-				'text' => $footer,
-			];
+			$embed["footer"] = ["text" => $footer];
 		}
 
 		if (isset($title) && isset($preview))
@@ -361,14 +359,14 @@ class notification_service
 					[
 						'name'   => $title,
 						'value'  => $preview,
-						'inline'	=> false,
-					],
+						'inline' => false
+					]
 				];
 			}
 		}
 
 		$payload = [
-			'embeds' => [$embed],
+			'embeds' => [$embed]
 		];
 
 		$json = \json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
@@ -380,7 +378,7 @@ class notification_service
 
 		// Use the CURL library to transmit the message via a POST operation to the webhook URL.
 		$h = curl_init();
-		curl_setopt($h, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
+		curl_setopt($h, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
 		curl_setopt($h, CURLOPT_URL, $discord_webhook_url);
 		curl_setopt($h, CURLOPT_POST, 1);
 		curl_setopt($h, CURLOPT_POSTFIELDS, $json);
@@ -400,8 +398,7 @@ class notification_service
 				$this->log->add('admin', ANONYMOUS, '127.0.0.1', 'ACP_DISCORD_NOTIFICATIONS_WEBHOOK_ERROR', time(), [$status]);
 				return false;
 			}
-		}
-		else
+		} else
 		{
 			$this->log->add('admin', ANONYMOUS, '127.0.0.1', 'ACP_DISCORD_NOTIFICATIONS_CURL_ERROR', time(), [$error]);
 			return false;
```
