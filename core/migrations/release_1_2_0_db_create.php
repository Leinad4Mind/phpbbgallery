<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2013 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

class release_1_2_0_db_create extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\release_1_2_0'];
	}

	public function update_schema(): array
	{
		return [
			'add_tables'		=> [
				$this->table_prefix . 'gallery_albums'	=> [
					'COLUMNS'		=> [
						'album_id'					=> ['UINT', null, 'auto_increment'],
						'parent_id'					=> ['UINT', 0],
						'left_id'					=> ['UINT', 1],
						'right_id'					=> ['UINT', 2],
						'album_parents'				=> ['MTEXT_UNI', ''],
						'album_type'				=> ['UINT:3', 1],
						'album_status'				=> ['UINT:1', 1],
						'album_name'				=> ['VCHAR:255', ''],
						'album_desc'				=> ['MTEXT_UNI', ''],
						'album_desc_options'		=> ['UINT:3', 7],
						'album_desc_uid'			=> ['VCHAR:8', ''],
						'album_desc_bitfield'		=> ['VCHAR:255', ''],
						'album_user_id'				=> ['UINT', 0],
						'album_images'				=> ['UINT', 0],
						'album_images_real'			=> ['UINT', 0],
						'album_last_image_id'		=> ['UINT', 0],
						'album_image'				=> ['VCHAR', ''],
						'album_last_image_time'		=> ['INT:11', 0],
						'album_last_image_name'		=> ['VCHAR', ''],
						'album_last_username'		=> ['VCHAR', ''],
						'album_last_user_colour'	=> ['VCHAR:6', ''],
						'album_last_user_id'		=> ['UINT', 0],
						'album_watermark'			=> ['UINT:1', 1],
						'album_sort_key'			=> ['VCHAR:8', ''],
						'album_sort_dir'			=> ['VCHAR:8', ''],
						'display_in_rrc'			=> ['UINT:1', 1],
						'display_on_index'			=> ['UINT:1', 1],
						'display_subalbum_list'		=> ['UINT:1', 1],
						'album_feed'				=> ['BOOL', 1],
						'album_auth_access'			=> ['TINT:1', 0],
					],
					'PRIMARY_KEY'	=> 'album_id',
				],
				$this->table_prefix . 'gallery_albums_track'	=> [
					'COLUMNS'		=> [
						'user_id'				=> ['UINT', 0],
						'album_id'				=> ['UINT', 0],
						'mark_time'				=> ['TIMESTAMP', 0],
					],
					'PRIMARY_KEY'	=> ['user_id', 'album_id'],
				],
				$this->table_prefix . 'gallery_comments'	=> [
					'COLUMNS'		=> [
						'comment_id'			=> ['UINT', null, 'auto_increment'],
						'comment_image_id'		=> ['UINT', 0],
						'comment_user_id'		=> ['UINT', 0],
						'comment_username'		=> ['VCHAR', ''],
						'comment_user_colour'	=> ['VCHAR:6', ''],
						'comment_user_ip'		=> ['VCHAR:40', ''],
						'comment_signature'		=> ['BOOL', 0],
						'comment_time'			=> ['UINT:11', 0],
						'comment'				=> ['MTEXT_UNI', ''],
						'comment_uid'			=> ['VCHAR:8', ''],
						'comment_bitfield'		=> ['VCHAR:255', ''],
						'comment_edit_time'		=> ['UINT:11', 0],
						'comment_edit_count'	=> ['USINT', 0],
						'comment_edit_user_id'	=> ['UINT', 0],
					],
					'PRIMARY_KEY'	=> 'comment_id',
					'KEYS'		=> [
						'id'			=> ['INDEX', 'comment_image_id'],
						'uid'			=> ['INDEX', 'comment_user_id'],
						'ip'			=> ['INDEX', 'comment_user_ip'],
						'time'			=> ['INDEX', 'comment_time'],
					],
				],
				$this->table_prefix . 'gallery_favorites'	=> [
					'COLUMNS'		=> [
						'favorite_id'			=> ['UINT', null, 'auto_increment'],
						'user_id'				=> ['UINT', 0],
						'image_id'				=> ['UINT', 0],
					],
					'PRIMARY_KEY'	=> 'favorite_id',
					'KEYS'		=> [
						'uid'		=> ['INDEX', 'user_id'],
						'id'		=> ['INDEX', 'image_id'],
					],
				],
				$this->table_prefix . 'gallery_images'	=> [
					'COLUMNS'		=> [
						'image_id'				=> ['UINT', null, 'auto_increment'],
						'image_filename'		=> ['VCHAR:255', ''],
						'image_name'			=> ['VCHAR:255', ''],
						'image_name_clean'		=> ['VCHAR:255', ''],
						'image_desc'			=> ['MTEXT_UNI', ''],
						'image_desc_uid'		=> ['VCHAR:8', ''],
						'image_desc_bitfield'	=> ['VCHAR:255', ''],
						'image_user_id'			=> ['UINT', 0],
						'image_username'		=> ['VCHAR:255', ''],
						'image_username_clean'	=> ['VCHAR:255', ''],
						'image_user_colour'		=> ['VCHAR:6', ''],
						'image_user_ip'			=> ['VCHAR:40', ''],
						'image_time'			=> ['UINT:11', 0],
						'image_album_id'		=> ['UINT', 0],
						'image_view_count'		=> ['UINT:11', 0],
						'image_status'			=> ['UINT:3', 0],
						'image_contest'			=> ['UINT:1', 0],
						'image_filemissing'		=> ['UINT:3', 0],
						'image_rates'			=> ['UINT', 0],
						'image_rate_points'		=> ['UINT', 0],
						'image_rate_avg'		=> ['UINT', 0],
						'image_comments'		=> ['UINT', 0],
						'image_last_comment'	=> ['UINT', 0],
						'image_allow_comments'	=> ['TINT:1', 1],
						'image_favorited'		=> ['UINT', 0],
						'image_reported'		=> ['UINT', 0],
						'filesize_upload'		=> ['UINT:20', 0],
						'filesize_medium'		=> ['UINT:20', 0],
						'filesize_cache'		=> ['UINT:20', 0],
					],
					'PRIMARY_KEY'				=> 'image_id',
					'KEYS'		=> [
						'aid'			=> ['INDEX', 'image_album_id'],
						'uid'			=> ['INDEX', 'image_user_id'],
						'time'			=> ['INDEX', 'image_time'],
					],
				],
				$this->table_prefix . 'gallery_modscache'	=> [
					'COLUMNS'		=> [
						'album_id'				=> ['UINT', 0],
						'user_id'				=> ['UINT', 0],
						'username'				=> ['VCHAR', ''],
						'group_id'				=> ['UINT', 0],
						'group_name'			=> ['VCHAR', ''],
						'display_on_index'		=> ['TINT:1', 1],
					],
					'KEYS'		=> [
						'doi'		=> ['INDEX', 'display_on_index'],
						'aid'		=> ['INDEX', 'album_id'],
					],
				],
				$this->table_prefix . 'gallery_permissions'	=> [
					'COLUMNS'		=> [
						'perm_id'			=> ['UINT', null, 'auto_increment'],
						'perm_role_id'		=> ['UINT', 0],
						'perm_album_id'		=> ['UINT', 0],
						'perm_user_id'		=> ['UINT', 0],
						'perm_group_id'		=> ['UINT', 0],
						'perm_system'		=> ['INT:3', 0],
					],
					'PRIMARY_KEY'			=> 'perm_id',
				],
				$this->table_prefix . 'gallery_rates'	=> [
					'COLUMNS'		=> [
						'rate_image_id'		=> ['UINT', 0],
						'rate_user_id'		=> ['UINT', 0],
						'rate_user_ip'		=> ['VCHAR:40', ''],
						'rate_point'		=> ['UINT:3', 0],
					],
					'PRIMARY_KEY'	=> ['rate_image_id', 'rate_user_id'],
				],
				$this->table_prefix . 'gallery_reports'	=> [
					'COLUMNS'		=> [
						'report_id'				=> ['UINT', null, 'auto_increment'],
						'report_album_id'		=> ['UINT', 0],
						'report_image_id'		=> ['UINT', 0],
						'reporter_id'			=> ['UINT', 0],
						'report_manager'		=> ['UINT', 0],
						'report_note'			=> ['MTEXT_UNI', ''],
						'report_time'			=> ['UINT:11', 0],
						'report_status'			=> ['UINT:3', 0],
					],
					'PRIMARY_KEY'	=> 'report_id',
				],
				$this->table_prefix . 'gallery_roles'	=> [
					'COLUMNS'		=> [
						'role_id'			=> ['UINT', null, 'auto_increment'],
						'a_list'			=> ['UINT:3', 0],
						'i_view'			=> ['UINT:3', 0],
						'i_watermark'		=> ['UINT:3', 0],
						'i_upload'			=> ['UINT:3', 0],
						'i_edit'			=> ['UINT:3', 0],
						'i_delete'			=> ['UINT:3', 0],
						'i_rate'			=> ['UINT:3', 0],
						'i_approve'			=> ['UINT:3', 0],
						'i_lock'			=> ['UINT:3', 0],
						'i_report'			=> ['UINT:3', 0],
						'i_count'			=> ['UINT', 0],
						'i_unlimited'		=> ['UINT:3', 0],
						'c_read'			=> ['UINT:3', 0],
						'c_post'			=> ['UINT:3', 0],
						'c_edit'			=> ['UINT:3', 0],
						'c_delete'			=> ['UINT:3', 0],
						'm_comments'		=> ['UINT:3', 0],
						'm_delete'			=> ['UINT:3', 0],
						'm_edit'			=> ['UINT:3', 0],
						'm_move'			=> ['UINT:3', 0],
						'm_report'			=> ['UINT:3', 0],
						'm_status'			=> ['UINT:3', 0],
						'a_count'			=> ['UINT', 0],
						'a_unlimited'		=> ['UINT:3', 0],
						'a_restrict'		=> ['UINT:3', 0],
					],
					'PRIMARY_KEY'		=> 'role_id',
				],
				$this->table_prefix . 'gallery_users'	=> [
					'COLUMNS'		=> [
						'user_id'			=> ['UINT', 0],
						'watch_own'			=> ['UINT:3', 0],
						'watch_favo'		=> ['UINT:3', 0],
						'watch_com'			=> ['UINT:3', 0],
						'user_images'		=> ['UINT', 0],
						'personal_album_id'	=> ['UINT', 0],
						'user_lastmark'		=> ['TIMESTAMP', 0],
						'user_last_update'	=> ['TIMESTAMP', 0],
						'user_permissions'	=> ['MTEXT_UNI', ''],
						'user_permissions_changed'	=> ['TIMESTAMP', 0],
						'user_allow_comments'		=> ['TINT:1', 1],
						'subscribe_pegas'			=> ['TINT:1', 0],
					],
					'PRIMARY_KEY'		=> 'user_id',
					'KEYS'		=> [
						'pega'			=> ['INDEX', ['personal_album_id']],
					],
				],
				$this->table_prefix . 'gallery_watch'	=> [
					'COLUMNS'		=> [
						'watch_id'		=> ['UINT', null, 'auto_increment'],
						'album_id'		=> ['UINT', 0],
						'image_id'		=> ['UINT', 0],
						'user_id'		=> ['UINT', 0],
					],
					'PRIMARY_KEY'		=> 'watch_id',
					'KEYS'		=> [
						'uid'			=> ['INDEX', 'user_id'],
						'id'			=> ['INDEX', 'image_id'],
						'aid'			=> ['INDEX', 'album_id'],
					],
				],
				// Let us add LOG
				$this->table_prefix . 'gallery_log'	=> [
					'COLUMNS'	=> [
						'log_id'	=> ['UINT', null, 'auto_increment'],
						'log_time'	=> ['UINT:11', 0],
						'log_type'	=> ['VCHAR:16', ''],
						'log_action'	=> ['VCHAR:32', ''],
						'log_user'		=> ['UINT', 0],
						'log_ip'	=> ['VCHAR:40', ''],
						'album'		=> ['UINT', 0],
						'image'		=> ['UINT', 0],
						'description'	=> ['MTEXT_UNI', ''],
						'deleted'	=> ['UINT:1', 0],
					],
					'PRIMARY_KEY'	=> 'log_id',
				],
			]
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_tables'		=> [
				$this->table_prefix . 'gallery_albums',
				$this->table_prefix . 'gallery_albums_track',
				$this->table_prefix . 'gallery_comments',
				$this->table_prefix . 'gallery_favorites',
				$this->table_prefix . 'gallery_images',
				$this->table_prefix . 'gallery_modscache',
				$this->table_prefix . 'gallery_permissions',
				$this->table_prefix . 'gallery_rates',
				$this->table_prefix . 'gallery_reports',
				$this->table_prefix . 'gallery_roles',
				$this->table_prefix . 'gallery_users',
				$this->table_prefix . 'gallery_watch',
				$this->table_prefix . 'gallery_log',
			],
		];
	}

}
