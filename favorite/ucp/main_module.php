<?php
/**
 * phpBB Gallery - Favorite Extension
 *
 * @package   phpbbgallery/favorite
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite\ucp;

class main_module
{
	/** @var string Template file to render */
	public string $tpl_name = '';

	/** @var string Page title */
	public string $page_title = '';

	/** @var string URL of this module */
	public string $u_action = '';

	/**
	 * Render the member's favourites.
	 *
	 * @param string $id   Module identifier
	 * @param string $mode Module mode
	 * @return void
	 */
	public function main(string $id, string $mode): void
	{
		global $db, $request, $template, $user, $phpbb_container;

		$language = $phpbb_container->get('language');
		$language->add_lang(['gallery'], 'phpbbgallery/core');
		$language->add_lang(['info_ucp_gallery_favorite'], 'phpbbgallery/favorite');

		$favorite = $phpbb_container->get('phpbbgallery.favorite');
		$gallery_auth = $phpbb_container->get('phpbbgallery.core.auth');
		$gallery_config = $phpbb_container->get('phpbbgallery.core.config');
		$gallery_image = $phpbb_container->get('phpbbgallery.core.image');
		$image_visibility = $phpbb_container->get('phpbbgallery.core.policy.image_visibility');
		$gallery_url = $phpbb_container->get('phpbbgallery.core.url');
		$pagination = $phpbb_container->get('pagination');

		$favorites_table = $phpbb_container->getParameter('phpbbgallery.tables.gallery_favorites');
		$images_table = $phpbb_container->getParameter('phpbbgallery.tables.gallery_images');
		$albums_table = $phpbb_container->getParameter('phpbbgallery.tables.gallery_albums');

		$this->tpl_name = 'gallery/ucp_gallery_favorite';
		$this->page_title = $language->lang('UCP_GALLERY_FAVORITES');
		add_form_key('ucp_gallery');

		$user_id = (int) $user->data['user_id'];
		$gallery_auth->load_user_permissions($user_id);

		$this->handle_removal($favorite, $request, $language, $user_id);

		$start = $request->variable('start', 0);
		$per_page = max(1, (int) $gallery_config->get('album_rows') * (int) $gallery_config->get('album_columns'));

		// Favourites may point at albums the member has since lost access to,
		// so the listing is bounded by what they can still view.
		$visible_albums = array_values(array_diff(
			$gallery_auth->acl_album_ids('i_view'),
			$gallery_auth->get_exclude_zebra()
		));

		$total_images = 0;
		$rowset = [];

		if (!empty($visible_albums))
		{
			$where = 'f.user_id = ' . $user_id . '
				AND ' . $db->sql_in_set('i.image_album_id', $visible_albums) . '
				AND i.image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED . '
				AND i.image_status <> ' . (int) \phpbbgallery\core\block::STATUS_ORPHAN . '
				AND i.image_status <> ' . (int) \phpbbgallery\core\block::STATUS_DELETE_REQUESTED;

			$sql_array = [
				'SELECT'	=> 'COUNT(f.favorite_id) AS favorites',
				'FROM'		=> [$favorites_table => 'f'],
				'LEFT_JOIN'	=> [
					[
						'FROM'	=> [$images_table => 'i'],
						'ON'	=> 'f.image_id = i.image_id',
					],
				],
				'WHERE'		=> $where,
			];
			$result = $db->sql_query($db->sql_build_query('SELECT', $sql_array));
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			$total_images = (int) ($row['favorites'] ?? 0);

			$sql_array['SELECT'] = 'f.favorite_id, i.*, a.album_name, a.album_id, a.album_user_id';
			$sql_array['LEFT_JOIN'][] = [
				'FROM'	=> [$albums_table => 'a'],
				'ON'	=> 'a.album_id = i.image_album_id',
			];
			// Newest favourite first, so paging stays stable between requests.
			$sql_array['ORDER_BY'] = 'f.favorite_id DESC';

			$result = $db->sql_query_limit($db->sql_build_query('SELECT', $sql_array), $per_page, $start);
			while ($row = $db->sql_fetchrow($result))
			{
				$rowset[] = $row;
			}
			$db->sql_freeresult($result);
		}

		foreach ($rowset as $row)
		{
			$can_moderate = $gallery_auth->acl_check(
				'm_status',
				(int) $row['image_album_id'],
				(int) $row['album_user_id']
			);
			$hide_private_data = $image_visibility->hides_private_data(
				$row,
				(int) $user->data['user_id'],
				$can_moderate
			);
			$uploader = $hide_private_data
				? $image_visibility->private_data_label(
					$row,
					(int) $user->data['user_id'],
					$can_moderate,
					$language->lang('GALLERY_PRIVATE_USER')
				)
				: get_username_string('full', $row['image_user_id'], $row['image_username'], $row['image_user_colour']);

			$template->assign_block_vars('image_row', [
				'IMAGE_ID'			=> (int) $row['image_id'],
				'ALBUM_NAME'		=> $row['album_name'],
				'IMAGE_TIME'		=> $user->format_date($row['image_time']),
				'UPLOADER'			=> $uploader,
				'UC_IMAGE_NAME'		=> $gallery_image->generate_link('image_name', $gallery_config->get('link_image_name'), $row['image_id'], $row['image_name'], $row['album_id']),
				'UC_FAKE_THUMBNAIL'	=> $gallery_image->generate_link('fake_thumbnail', $gallery_config->get('link_thumbnail'), $row['image_id'], $row['image_name'], $row['album_id']),
				'U_VIEW_ALBUM'		=> $gallery_url->show_album((int) $row['image_album_id']),
				'U_IMAGE'			=> $gallery_url->show_image((int) $row['image_id']),
			]);
		}

		$pagination->generate_template_pagination(
			$this->u_action,
			'pagination',
			'start',
			$total_images,
			$per_page,
			$start
		);

		$template->assign_vars([
			'S_MANAGE_FAVORITES'	=> true,
			'S_UCP_ACTION'			=> $this->u_action,

			'L_TITLE'				=> $language->lang('UCP_GALLERY_FAVORITES'),
			'L_TITLE_EXPLAIN'		=> $language->lang('YOUR_FAVORITE_IMAGES'),

			'TOTAL_IMAGES'			=> $language->lang('TOTAL_FAVORITES', $total_images),
			'FAKE_THUMB_SIZE'		=> $gallery_config->get('mini_thumbnail_size'),
		]);
	}

	/**
	 * Remove the marked favourites, if that is what was submitted.
	 *
	 * @param \phpbbgallery\favorite\favorite $favorite Gallery favorite object
	 * @param \phpbb\request\request          $request  Request object
	 * @param \phpbb\language\language        $language Language object
	 * @param int                             $user_id  Member the favourites belong to
	 * @return void
	 */
	protected function handle_removal(\phpbbgallery\favorite\favorite $favorite, \phpbb\request\request $request,
		\phpbb\language\language $language, int $user_id): void
	{
		$action = $request->variable('action', '', true, \phpbb\request\request_interface::POST);
		$image_id_ary = $request->variable('image_id_ary', [0], false, \phpbb\request\request_interface::POST);

		if ($action !== 'remove_favorite' || empty($image_id_ary))
		{
			return;
		}

		if (!check_form_key('ucp_gallery'))
		{
			trigger_error('FORM_INVALID');
		}

		$favorite->remove($image_id_ary, $user_id);

		meta_refresh(3, $this->u_action);
		trigger_error($language->lang('UNFAVORITED_IMAGES') . '<br /><br />'
			. $language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>'));
	}
}
