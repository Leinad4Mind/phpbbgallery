<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/**
 * Install a paginated album embed without reinterpreting the legacy [album] image alias.
 */
class gallery_album_bbcode extends migration
{
	private const ALBUM_TAG = 'album';
	private const FALLBACK_ALBUM_TAG = 'galleryalbum';

	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\relocate_personal_album_profile_field'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_album_bbcode_tag', self::ALBUM_TAG]],
			['custom', [[$this, 'ensure_album_bbcode']]],
			['config.add', ['phpbb_gallery_album_bbcode_ready', 1]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_album_bbcode_ready']],
			['custom', [[$this, 'remove_album_bbcode']]],
			['config.remove', ['phpbb_gallery_album_bbcode_tag']],
		];
	}

	public function ensure_album_bbcode(): void
	{
		$album_row = $this->get_bbcode(self::ALBUM_TAG);
		$tag = (!$album_row || $this->is_album_embed($album_row, self::ALBUM_TAG))
			? self::ALBUM_TAG
			: self::FALLBACK_ALBUM_TAG;
		$row = $tag === self::ALBUM_TAG ? $album_row : $this->get_bbcode(self::FALLBACK_ALBUM_TAG);

		if ($row && !$this->is_album_embed($row, $tag))
		{
			throw new \phpbb\db\migration\exception('GALLERY_BBCODE_CONFLICT', '[' . $tag . ']');
		}

		$bbcode_id = null;
		if (!$row)
		{
			$bbcode_id = $this->next_bbcode_id();
			if ($bbcode_id > BBCODE_LIMIT)
			{
				throw new \phpbb\db\migration\exception('GALLERY_BBCODE_LIMIT_REACHED', '[' . $tag . ']');
			}
		}

		$this->config->set('phpbb_gallery_album_bbcode_tag', $tag);
		$this->install_or_update($tag, $row, $bbcode_id);
	}

	public function remove_album_bbcode(): void
	{
		$tag = strtolower((string) ($this->config['phpbb_gallery_album_bbcode_tag'] ?? self::ALBUM_TAG));
		if (!in_array($tag, [self::ALBUM_TAG, self::FALLBACK_ALBUM_TAG], true))
		{
			return;
		}

		$bbcode_match = '[' . $tag . ']{NUMBER}[/' . $tag . ']';
		$sql = 'DELETE FROM ' . $this->table_prefix . "bbcodes
			WHERE LOWER(bbcode_tag) = '" . $this->db->sql_escape($tag) . "'
				AND bbcode_match = '" . $this->db->sql_escape($bbcode_match) . "'
				AND second_pass_replace LIKE '%phpbbgallery-album-embed%'";
		$this->db->sql_query($sql);
	}

	private function install_or_update(string $tag, array|false $row, ?int $bbcode_id): void
	{
		$template = $this->album_template();
		$replacement_reference = '$' . '{1}';
		$sql_ary = [
			'bbcode_helpline'     => $tag === self::ALBUM_TAG
				? 'GALLERY_HELPLINE_ALBUM_EMBED'
				: 'GALLERY_HELPLINE_GALLERYALBUM',
			'display_on_posting'  => 1,
			'bbcode_match'        => '[' . $tag . ']{NUMBER}[/' . $tag . ']',
			'bbcode_tpl'          => $template,
			'first_pass_match'    => '!\[' . $tag . '\]([0-9]+)\[/' . $tag . '\]!i',
			'first_pass_replace'  => '[' . $tag . ':$uid]' . $replacement_reference . '[/' . $tag . ':$uid]',
			'second_pass_match'   => '!\[' . $tag . ':$uid\]([0-9]+)\[/' . $tag . ':$uid\]!s',
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
			'bbcode_id' => (int) $bbcode_id,
		], $sql_ary);
		$sql = 'INSERT INTO ' . $this->table_prefix . 'bbcodes '
			. $this->db->sql_build_array('INSERT', $sql_ary);
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

	private function is_album_embed(array $row, string $tag): bool
	{
		return ($row['bbcode_match'] ?? '') === '[' . $tag . ']{NUMBER}[/' . $tag . ']'
			&& str_contains((string) ($row['second_pass_replace'] ?? ''), 'phpbbgallery-album-embed')
			&& str_contains((string) ($row['second_pass_replace'] ?? ''), '/gallery/album/');
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

	private function album_template(): string
	{
		$base_url = rtrim(generate_board_url(), '/')
			. (!empty($this->config['enable_mod_rewrite']) ? '/gallery/album/' : '/app.php/gallery/album/');
		$album_url = $base_url . '{NUMBER}';

		return '<div class="phpbbgallery-album-embed" data-endpoint="' . $album_url . '/embed">'
			. '<a class="phpbbgallery-album-embed-fallback" href="' . $album_url . '">Gallery album {NUMBER}</a>'
			. '</div>';
	}
}
