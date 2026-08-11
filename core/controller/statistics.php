<?php
/**
 * phpBB Gallery public statistics page.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\controller;

/** Render permission-filtered lifetime and annual Gallery rankings. */
final class statistics
{
	public function __construct(
		private \phpbb\request\request_interface $request,
		private \phpbb\template\template $template,
		private \phpbb\user $user,
		private \phpbb\language\language $language,
		private \phpbb\controller\helper $helper,
		private \phpbbgallery\core\auth\auth $gallery_auth,
		private \phpbbgallery\core\statistics $statistics,
		private \phpbb\config\config $config,
		private \phpbbgallery\core\config $gallery_config
	)
	{
	}

	public function page(): \Symfony\Component\HttpFoundation\Response
	{
		$this->language->add_lang('gallery', 'phpbbgallery/core');
		$this->gallery_auth->load_user_permissions((int) $this->user->data['user_id']);
		$album_ids = array_values(array_diff(
			array_intersect(
				(array) $this->gallery_auth->acl_album_ids('i_view'),
				(array) $this->gallery_auth->acl_album_ids('i_statistics')
			),
			(array) $this->gallery_auth->get_exclude_zebra()
		));
		if (!$album_ids)
		{
			if (empty($this->user->data['is_registered']))
			{
				login_box($this->helper->route('phpbbgallery_core_statistics'));
			}
			throw new \phpbb\exception\http_exception(403, 'NOT_AUTHORISED');
		}

		$year = $this->request->variable('year', 0);
		$data = $this->statistics->dashboard($album_ids, $year);
		$year = (int) $data['year'];
		$summary = (array) $data['summary'];
		$tracking_start = (int) ($this->config['phpbb_gallery_statistics_tracking_start'] ?? 0);
		$statistics_action = $this->helper->route('phpbbgallery_core_statistics');

		$this->template->assign_vars([
			'S_STATISTICS_YEAR' => $year,
			'S_STATISTICS_ALL_TIME' => $year === 0,
			'S_STATISTICS_ACTION' => $statistics_action,
			'S_STATISTICS_HIDDEN_FIELDS' => build_hidden_fields($this->get_query_fields($statistics_action)),
			'U_STATISTICS_ALL_TIME' => $this->helper->route('phpbbgallery_core_statistics'),
			'SUMMARY_IMAGES' => (int) ($summary['image_count'] ?? 0),
			'SUMMARY_VIEWS' => (int) ($summary['view_count'] ?? 0),
			'SUMMARY_DOWNLOADS' => (int) ($summary['download_count'] ?? 0),
			'SUMMARY_UPLOADERS' => (int) ($summary['uploader_count'] ?? 0),
			'S_STATISTICS_TRACKING_START' => $tracking_start > 0,
			'STATISTICS_TRACKING_START' => $tracking_start > 0 ? $this->user->format_date($tracking_start, 'Y-m-d') : '',
		]);

		foreach ((array) $data['years'] as $available_year)
		{
			$available_year = (int) $available_year;
			$this->template->assign_block_vars('statistics_years', [
				'YEAR' => $available_year,
				'S_SELECTED' => $available_year === $year,
				'U_YEAR' => $this->helper->route('phpbbgallery_core_statistics', ['year' => $available_year]),
			]);
		}

		$this->assign_image_rows('statistics_top_viewed', (array) $data['top_viewed']);
		$this->assign_image_rows('statistics_top_downloaded', (array) $data['top_downloaded']);
		$this->assign_user_rows('statistics_top_uploaders', (array) $data['top_uploaders']);
		$this->assign_user_rows('statistics_top_downloaders', (array) $data['top_downloaders']);

		$gallery_title = $this->gallery_config->get_title($this->language);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME' => $gallery_title,
			'U_VIEW_FORUM' => $this->helper->route('phpbbgallery_core_index'),
		]);
		$this->template->assign_block_vars('navlinks', [
			'FORUM_NAME' => $this->language->lang('GALLERY_STATISTICS'),
			'U_VIEW_FORUM' => $this->helper->route('phpbbgallery_core_statistics', $year > 0 ? ['year' => $year] : []),
		]);

		return $this->helper->render(
			'gallery/statistics_body.html',
			$this->language->lang('GALLERY_STATISTICS')
		);
	}

	/**
	 * Preserve phpBB's cookie fallback and style parameters in the GET filter.
	 *
	 * Browsers replace the action query string when submitting GET forms, so
	 * parameters appended by phpBB must also be represented as form fields.
	 *
	 * @return array<string, mixed>
	 */
	private function get_query_fields(string $url): array
	{
		$query = (string) parse_url(
			html_entity_decode($url, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
			PHP_URL_QUERY
		);
		if ($query === '')
		{
			return [];
		}

		parse_str($query, $fields);
		unset($fields['year']);

		return $fields;
	}

	/** @param array<int, array<string, mixed>> $rows */
	private function assign_image_rows(string $block, array $rows): void
	{
		foreach ($rows as $row)
		{
			$image_id = (int) $row['image_id'];
			$this->template->assign_block_vars($block, [
				'IMAGE_ID' => $image_id,
				'IMAGE_NAME' => (string) $row['image_name'],
				'METRIC' => (int) $row['metric'],
				'AUTHOR_FULL' => get_username_string(
					'full',
					(int) $row['image_user_id'],
					(string) $row['image_username'],
					(string) $row['image_user_colour']
				),
				'U_IMAGE' => $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]),
				'U_THUMBNAIL' => $this->helper->route('phpbbgallery_core_image_file_mini', ['image_id' => $image_id]),
			]);
		}
	}

	/** @param array<int, array<string, mixed>> $rows */
	private function assign_user_rows(string $block, array $rows): void
	{
		foreach ($rows as $row)
		{
			$this->template->assign_block_vars($block, [
				'METRIC' => (int) $row['metric'],
				'USERNAME_FULL' => get_username_string(
					'full',
					(int) $row['user_id'],
					(string) $row['username'],
					(string) $row['user_colour']
				),
			]);
		}
	}
}
