<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/**
 * Keep the old album BBCode readable while making image canonical.
 */
class gallery_bbcodes extends migration
{
	public static function depends_on(): array
	{
		return ['\\phpbbgallery\\core\\migrations\\forum_index_images'];
	}

	public function update_data(): array
	{
		return [
			['custom', [[$this, 'ensure_gallery_bbcodes']]],
			['config.add', ['phpbb_gallery_bbcode_ready', 1]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_bbcode_ready']],
			['custom', [[$this, 'remove_legacy_alias']]],
		];
	}

	public function ensure_gallery_bbcodes(): void
	{
		$template = $this->gallery_template();
		$definitions = [
			'image' => true,
			'album' => false,
		];
		$rows = [];
		foreach (array_keys($definitions) as $tag)
		{
			$rows[$tag] = $this->get_bbcode($tag);
			if ($rows[$tag] && !$this->is_gallery_bbcode($rows[$tag], $tag))
			{
				// Never overwrite an unrelated custom BBCode that happens to use this tag.
				throw new \phpbb\db\migration\exception('GALLERY_BBCODE_CONFLICT', '[' . $tag . ']');
			}
		}

		$next_id = null;
		$new_ids = [];
		foreach (array_keys($definitions) as $tag)
		{
			if ($rows[$tag])
			{
				continue;
			}

			$next_id ??= $this->next_bbcode_id();
			if ($next_id > BBCODE_LIMIT)
			{
				throw new \phpbb\db\migration\exception('GALLERY_BBCODE_LIMIT_REACHED', '[' . $tag . ']');
			}
			$new_ids[$tag] = $next_id++;
		}

		foreach ($definitions as $tag => $display_on_posting)
		{
			$this->install_or_update(
				$tag,
				$display_on_posting,
				$template,
				$rows[$tag],
				$new_ids[$tag] ?? null
			);
		}
	}

	public function remove_legacy_alias(): void
	{
		$sql = 'DELETE FROM ' . $this->table_prefix . "bbcodes
			WHERE LOWER(bbcode_tag) = 'album'
				AND bbcode_match = '[album]{NUMBER}[/album]'
				AND second_pass_replace LIKE '%/gallery/image/%'";
		$this->db->sql_query($sql);
	}

	private function install_or_update(string $tag, bool $display_on_posting, string $template,
		array|false $row, ?int $bbcode_id): void
	{
		$replacement_reference = '$' . '{1}';
		$sql_ary = [
			'bbcode_helpline'     => 'GALLERY_HELPLINE_ALBUM',
			'display_on_posting'  => $display_on_posting ? 1 : 0,
			'bbcode_match'        => '[' . $tag . ']{NUMBER}[/' . $tag . ']',
			'bbcode_tpl'          => $template,
			'first_pass_match'    => '!\\[' . $tag . '\\]([0-9]+)\\[/' . $tag . '\\]!i',
			'first_pass_replace'  => '[' . $tag . ':$uid]' . $replacement_reference . '[/' . $tag . ':$uid]',
			'second_pass_match'   => '!\\[' . $tag . ':$uid\\]([0-9]+)\\[/' . $tag . ':$uid\\]!s',
			'second_pass_replace' => str_replace('{NUMBER}', $replacement_reference, $template),
		];

		if ($row)
		{
			$sql = 'UPDATE ' . $this->table_prefix . 'bbcodes
				SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE bbcode_id = ' . (int) $row['bbcode_id'];
			$this->db->sql_query($sql);
			return;
		}

		$sql_ary = array_merge([
			'bbcode_tag' => $tag,
			'bbcode_id'  => (int) $bbcode_id,
		], $sql_ary);
		$sql = 'INSERT INTO ' . $this->table_prefix . 'bbcodes ' .
			$this->db->sql_build_array('INSERT', $sql_ary);
		$this->db->sql_query($sql);
	}

	private function get_bbcode(string $tag): array|false
	{
		$sql = 'SELECT *
			FROM ' . $this->table_prefix . "bbcodes
			WHERE LOWER(bbcode_tag) = '" . $this->db->sql_escape(strtolower($tag)) . "'";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return is_array($row) ? $row : false;
	}

	private function is_gallery_bbcode(array $row, string $tag): bool
	{
		return ($row['bbcode_match'] ?? '') === '[' . $tag . ']{NUMBER}[/' . $tag . ']'
			&& (($row['bbcode_helpline'] ?? '') === 'GALLERY_HELPLINE_ALBUM'
				|| str_contains((string) ($row['second_pass_replace'] ?? ''), '/gallery/image/'));
	}

	private function next_bbcode_id(): int
	{
		$sql = 'SELECT MAX(bbcode_id) AS max_bbcode_id
			FROM ' . $this->table_prefix . 'bbcodes';
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return max(NUM_CORE_BBCODES + 1, (int) ($row['max_bbcode_id'] ?? 0) + 1);
	}

	private function gallery_template(): string
	{
		$base_url = rtrim(generate_board_url(), '/') .
			(!empty($this->config['enable_mod_rewrite']) ? '/gallery/image/' : '/app.php/gallery/image/');
		$image = '<img src="' . $base_url . '{NUMBER}/mini" alt="{NUMBER}" />';
		$link_target = (string) ($this->config['phpbb_gallery_link_thumbnail'] ?? 'image_page');

		if ($link_target === 'image')
		{
			return '<a href="' . $base_url . '{NUMBER}/source">' . $image . '</a>';
		}
		if ($link_target === 'none')
		{
			return $image;
		}

		return '<a href="' . $base_url . '{NUMBER}">' . $image . '</a>';
	}
}
