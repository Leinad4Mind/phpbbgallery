<?php
/**
*
* BBtracking
*
* @copyright (c) 2018 Ken F. Innes IV <https://www.absoluteanime.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
* @copyright (c) 2017, Sitesplat
* @license private
*/

namespace sitesplat\bbtracking\migrations;

class m3_post_revisions extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['primepostrev_cron_last_run']);
	}

	static public function depends_on()
	{
		return array('\sitesplat\bbtracking\migrations\m2_initial_modules');
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				FORUMS_TABLE => array(
					'primepostrev_enable'		=> array('BOOL', 1),
					'primepostrev_autoprune'	=> array('UINT:8', 0),
				),
				POSTS_TABLE	=> array(
					'primepost_edit_time'		=> array('TIMESTAMP', 0),
					'primepost_edit_user'		=> array('UINT:10', 0),
					'primepost_edit_count'		=> array('UINT:4', 0),
				),
			),
			'add_tables'	=> array(
				$this->table_prefix . 'primepostrev' => array(
					'COLUMNS' => array(
						'revision_id'			=> array('UINT:10', null, 'auto_increment'),
						'revision_time'			=> array('TIMESTAMP', 0),
						'post_id'				=> array('UINT:10', 0),
						'post_subject'			=> array('STEXT_UNI', ''),
						'post_text'				=> array('MTEXT_UNI', ''),
						'bbcode_uid'			=> array('VCHAR:8', ''),
						'bbcode_bitfield'		=> array('VCHAR:255', ''),
						'post_edit_time'		=> array('TIMESTAMP', 0),
						'post_edit_reason'		=> array('STEXT_UNI', ''),
						'post_edit_user'		=> array('UINT:10', 0),
						'post_edit_count'		=> array('UINT:4', 0),
						'primepost_edit_time'	=> array('TIMESTAMP', 0),
						'primepost_edit_user'	=> array('UINT:10', 0),
						'primepost_edit_count'	=> array('UINT:4', 0),
					),
					'PRIMARY_KEY' => 'revision_id',
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				FORUMS_TABLE => array(
					'primepostrev_enable',
					'primepostrev_autoprune',
				),
				POSTS_TABLE	=> array(
					'primepost_edit_time',
					'primepost_edit_user',
					'primepost_edit_count',
				),
			),
			'drop_tables'	=> array(
				$this->table_prefix . 'primepostrev',
			),
		);
	}

	public function update_data()
	{
		return array(
			array('config.add', array('primepostrev_cron_last_run', 0)),

			// Moderator can view post revisions
			array('permission.add', array('m_primepostrev_view', true)),				// Global
			array('permission.add', array('m_primepostrev_view', false, 'm_info')),		// Local
			array('permission.permission_set', array('ROLE_MOD_FULL', 'm_primepostrev_view')),
			array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_primepostrev_view')),

			// Moderator can delete post revisions
			array('permission.add', array('m_primepostrev_delete', true)),				// Global
			array('permission.add', array('m_primepostrev_delete', false, 'm_delete')),	// Local
			array('permission.permission_set', array('ROLE_MOD_FULL', 'm_primepostrev_delete')),
			array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_primepostrev_delete')),

			// Moderator can restore post revisions
			array('permission.add', array('m_primepostrev_restore', true)),				// Global
			array('permission.add', array('m_primepostrev_restore', false, 'm_edit')),	// Local
			array('permission.permission_set', array('ROLE_MOD_FULL', 'm_primepostrev_restore')),
			array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_primepostrev_restore')),

			// Poster can view revisions for their posts
			array('permission.add', array('f_primepostrev_view', false, 'f_edit')),		// Local
			array('permission.permission_set', array('ROLE_FORUM_FULL', 'f_primepostrev_view')),
			array('permission.permission_set', array('ROLE_FORUM_STANDARD', 'f_primepostrev_view')),
			array('permission.permission_set', array('ROLE_FORUM_POLLS', 'f_primepostrev_view')),

			// Poster can delete revisions for their posts
			array('permission.add', array('f_primepostrev_delete', false, 'f_delete')),	// Local

			// Poster can restore revisions for their posts
			array('permission.add', array('f_primepostrev_restore', false, 'f_edit')),	// Local
		);
	}
}
