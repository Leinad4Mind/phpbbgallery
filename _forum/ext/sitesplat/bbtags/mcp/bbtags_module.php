<?php
/**
 * BBTags MCP tag suggestion queue.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\mcp;

use phpbb\db\driver\driver_interface;

class bbtags_module
{
	private const FORM_KEY = 'sitesplat/bbtags_moderation';

	public string $u_action = '';
	public string $tpl_name = 'mcp_bbtags';
	public string $page_title = 'MCP_BBTAGS_QUEUE';

	public function main(string $id, string $mode): void
	{
		global $auth, $db, $phpbb_container, $phpbb_root_path, $request, $template, $user;

		$user->add_lang_ext('sitesplat/bbtags', ['bbtags', 'info_mcp_bbtags']);
		if (!$auth->acl_get('m_bbtags_moderate'))
		{
			trigger_error('NO_AUTH_OPERATION', E_USER_WARNING);
		}
		$moderation = $phpbb_container->get('sitesplat.bbtags.moderation');
		$php_ext = $phpbb_container->getParameter('core.php_ext');
		$action = $request->variable('action', '');
		$suggestion_id = $request->variable('suggestion_id', 0);
		add_form_key(self::FORM_KEY);
		if (in_array($action, ['approve', 'reject'], true))
		{
			if (!$request->is_set_post('action') || !check_form_key(self::FORM_KEY))
			{
				trigger_error($user->lang('FORM_INVALID'), E_USER_WARNING);
			}
			$resolved = ($action === 'approve')
				? $moderation->approve($suggestion_id, (int) $user->data['user_id'])
				: $moderation->reject($suggestion_id, (int) $user->data['user_id']);
			if (!$resolved)
			{
				trigger_error($user->lang('BBTAGS_SUGGESTION_RESOLVE_FAILED'), E_USER_WARNING);
			}
			meta_refresh(2, $this->u_action);
			$message = ($action === 'approve') ? 'BBTAGS_SUGGESTION_APPROVED' : 'BBTAGS_SUGGESTION_REJECTED';
			trigger_error($user->lang($message));
		}

		$start = max(0, $request->variable('start', 0));
		$per_page = 25;
		$total = $moderation->count_pending_suggestions();
		$rows = $moderation->get_pending_suggestions($start, $per_page);
		$usernames = $this->get_usernames($db, $rows);
		foreach ($rows as $row)
		{
			$user_id = (int) $row['suggested_by'];
			$user_row = $usernames[$user_id] ?? ['username' => '', 'user_colour' => ''];
			$provider = (string) $row['provider'];
			$item_id = (int) $row['item_id'];
			$template->assign_block_vars('suggestions', [
				'ID'           => (int) $row['suggestion_id'],
				'TAG'          => htmlspecialchars((string) $row['tag'], ENT_QUOTES, 'UTF-8'),
				'PROVIDER'     => $provider === 'forum_topics' ? $user->lang('BBTAGS_PROVIDER_FORUM_TOPICS') : htmlspecialchars($provider, ENT_QUOTES, 'UTF-8'),
				'SCOPE_ID'     => (int) $row['scope_id'],
				'ITEM_ID'      => $item_id,
				'SUGGESTED_BY' => get_username_string('full', $user_id, $user_row['username'], $user_row['user_colour']),
				'SUGGESTED_AT' => $user->format_date((int) $row['suggested_at']),
				'U_ITEM'       => $provider === 'forum_topics' ? append_sid($phpbb_root_path . 'viewtopic.' . $php_ext, 't=' . $item_id) : '',
			]);
		}

		$phpbb_container->get('pagination')->generate_template_pagination(
			$this->u_action,
			'pagination',
			'start',
			$total,
			$per_page,
			$start
		);
		$template->assign_vars([
			'U_ACTION'          => $this->u_action,
			'PENDING_TOTAL'     => $total,
			'PENDING_PAGE_SIZE' => count($rows),
		]);
	}

	private function get_usernames(driver_interface $db, array $rows): array
	{
		$user_ids = array_values(array_unique(array_filter(array_map(static function (array $row): int
		{
			return (int) $row['suggested_by'];
		}, $rows))));
		if (empty($user_ids))
		{
			return [];
		}

		$sql = 'SELECT user_id, username, user_colour
			FROM ' . USERS_TABLE . '
			WHERE ' . $db->sql_in_set('user_id', $user_ids);
		$result = $db->sql_query($sql);
		$users = [];
		while ($row = $db->sql_fetchrow($result))
		{
			$users[(int) $row['user_id']] = $row;
		}
		$db->sql_freeresult($result);

		return $users;
	}
}
