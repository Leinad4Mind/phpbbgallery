<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\profilefield_base_migration;

class release_3_2_1_0 extends profilefield_base_migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\split_ucp_module_settings'];
	}

	public function update_data(): array
	{
		return [
			['custom', [[&$this, 'install_config']]],
			['custom', [[$this, 'create_custom_field']]],
			['custom', [[&$this, 'add_base_url']]],
			['custom', [[&$this, 'fix_gallery_lang']]],
		];
	}

	public function install_config(): bool
	{
		global $config;

		foreach (self::$configs as $name => $value)
		{
			$config->set('phpbb_gallery_' . $name, $value);
		}

		return true;
	}

	public function add_base_url(): void
	{
		global $config;
		$base_uri = generate_board_url();
		$base_uri .= ($config['enable_mod_rewrite'] == 0 ? '/app.php' : '');
		$base_uri .= '/gallery/album/%s';
		$sql = 'UPDATE ' . PROFILE_FIELDS_TABLE . ' SET field_contact_url = \'' . $base_uri . '\' WHERE field_name = \'gallery_palbum\'';
		$this->db->sql_query($sql);
	}

	public function fix_gallery_lang(): void
	{
		$sql = 'UPDATE ' . PROFILE_LANG_TABLE . ' SET lang_name = \'GALLERY\' WHERE lang_name = \'GALLERY_PALBUM\'';
		$this->db->sql_query($sql);
	}

	public static array $configs = [
		'version'					=> '3.2.1',
		'disp_gallery_icon'			=> true,
	];

	/** @var string Must remain untyped to match phpBB's profilefield base class. */
	protected $profilefield_name = 'gallery_palbum';

	/** @var array Must remain untyped to match phpBB's profilefield base class. */
	protected $profilefield_database_type = ['VCHAR', ''];

	/** @var array Must remain untyped to match phpBB's profilefield base class. */
	protected $profilefield_data = [
		'field_name'	=> 'gallery_palbum',
		'field_type'	=> 'profilefields.type.string',
		'field_ident'	=> 'gallery_palbum',
		'field_length'	=> 8,
		'field_minlen'	=> 1,
		'field_maxlen'	=> 9,
		'field_novalue'	=> '',
		'field_default_value'	=> '',
		'field_validation'	=> '[0-9]+',
		'field_required'	=> 0,
		'field_show_novalue'	=> 0,
		'field_show_on_reg'	=> 0,
		'field_show_on_pm'	=> 1,
		'field_show_on_vt'	=> 1,
		'field_show_profile'	=> 1,
		'field_show_on_ml'	=> 0,
		'field_hide'	=> 0,
		'field_no_view'	=> 0,
		'field_active'	=> 1,
		'field_is_contact'	=> 1,
		'field_contact_desc'	=> 'USERS_PERSONAL_ALBUMS',
		'field_contact_url'	=> ''
	];
}
