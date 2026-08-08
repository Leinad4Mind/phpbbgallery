<?php
/**
 * phpBB Gallery - ACP Exif Extension
 *
 * @package   phpbbgallery/exif
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif\event;

/**
* Event listener
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class exif_listener implements EventSubscriberInterface
{
	protected \phpbb\user $user;
	protected \phpbbgallery\core\config $gallery_config;
	protected \phpbbgallery\core\user $gallery_user;
	protected \phpbbgallery\core\storage\workspace $storage_workspace;
	protected \phpbbgallery\exif\capture_index $capture_index;
	protected \phpbbgallery\exif\capture_sync $capture_sync;
	protected string $capture_table;

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.acp.config.get_display_vars'		=> 'acp_config_get_display_vars',
			'phpbbgallery.acpimport.update_image_before'	=> 'massimport_update_image_before',
			'phpbbgallery.acpimport.update_image'			=> 'massimport_update_image',
			'phpbbgallery.acpimport.insert_image_after'		=> 'capture_after_import',
			'phpbbgallery.core.posting.edit_before_rotate'		=> 'posting_edit_before_rotate',
			'phpbbgallery.core.image.delete_images'			=> 'capture_deleted_images',
			'phpbbgallery.core.image.sort_labels'			=> 'sort_labels',
			'phpbbgallery.core.image.sort_options'			=> 'sort_options',
			'phpbbgallery.core.search.sort_options'			=> 'search_sort_options',
			'phpbbgallery.core.image_edit_after'				=> 'capture_after_edit',
			'phpbbgallery.core.ucp.set_settings_submit'			=> 'ucp_set_settings_submit',
			'phpbbgallery.core.ucp.set_settings_nosubmit'		=> 'ucp_set_settings_nosubmit',
			'phpbbgallery.core.upload.prepare_file_before'		=> 'upload_prepare_file_before',
			'phpbbgallery.core.upload.update_image_before'		=> 'upload_update_image_before',
			'phpbbgallery.core.upload.update_image_after'		=> 'capture_after_upload',
			//'phpbbgallery.core.upload.update_image_nofilechange'	=> 'upload_update_image_nofilechange',
			'phpbbgallery.core.user.get_default_values'			=> 'user_get_default_values',
			'phpbbgallery.core.user.validate_data'				=> 'user_validate_data',
			'phpbbgallery.core.viewimage'						=> 'viewimage',
		];
	}

	/**
	* Constructor
	* NOTE: The parameters of this method must match in order and type with
	* the dependencies defined in the services.yml file for this service.
	*
	* @param \phpbb\user					$user			User object
	* @param \phpbbgallery\core\config		$gallery_config	Core gallery config object
	* @param \phpbbgallery\core\user		$gallery_user	Core gallery user wrapper
	* @param \phpbbgallery\core\storage\workspace $storage_workspace Active storage workspace
	* @param \phpbbgallery\exif\capture_index $capture_index Capture-date index
	* @param \phpbbgallery\exif\capture_sync $capture_sync Capture-date synchronizer
	* @param string $capture_table EXIF capture index table
	*/

	public function __construct(
		\phpbb\user $user,
		\phpbbgallery\core\config $gallery_config,
		\phpbbgallery\core\user $gallery_user,
		\phpbbgallery\core\storage\workspace $storage_workspace,
		\phpbbgallery\exif\capture_index $capture_index,
		\phpbbgallery\exif\capture_sync $capture_sync,
		string $capture_table
	)
	{
		$this->user = $user;
		$this->gallery_config = $gallery_config;
		$this->gallery_user = $gallery_user;
		$this->storage_workspace = $storage_workspace;
		$this->capture_index = $capture_index;
		$this->capture_sync = $capture_sync;
		$this->capture_table = $capture_table;
	}

	public function sort_labels(\phpbb\event\data $event): void
	{
		$this->user->add_lang_ext('phpbbgallery/exif', 'info_exif');
		$sort_by_text = $event['sort_by_text'];
		$sort_by_text['et'] = $this->user->lang('EXIF_DATE');
		$event['sort_by_text'] = $sort_by_text;
	}

	public function sort_options(\phpbb\event\data $event): void
	{
		$this->sort_labels($event);
		$sort_by_sql = $event['sort_by_sql'];
		$sort_by_sql['et'] = 'COALESCE(NULLIF(gallery_exif_sort.exif_taken_time, 0), image_time)';
		$sort_from = $event['sort_from'];
		if ((string) $event['sort_key'] === 'et' && strpos($sort_from, ' gallery_exif_sort ') === false)
		{
			$sort_from .= ' LEFT JOIN ' . $this->capture_table . ' gallery_exif_sort
				ON gallery_exif_sort.exif_image_id = image_id';
		}
		$event['sort_by_sql'] = $sort_by_sql;
		$event['sort_from'] = $sort_from;
	}

	public function search_sort_options(\phpbb\event\data $event): void
	{
		$this->sort_labels($event);
		$sort_by_sql = $event['sort_by_sql'];
		$sort_by_sql['et'] = 'COALESCE(NULLIF(gallery_exif_sort.exif_taken_time, 0), i.image_time)';
		$search_sort_joins = $event['search_sort_joins'];
		if ((string) $event['sort_key'] === 'et')
		{
			$search_sort_joins[] = [
				'FROM' => [$this->capture_table => 'gallery_exif_sort'],
				'ON'   => 'gallery_exif_sort.exif_image_id = i.image_id',
			];
		}
		$event['sort_by_sql'] = $sort_by_sql;
		$event['search_sort_joins'] = $search_sort_joins;
	}

	public function capture_after_upload(\phpbb\event\data $event): void
	{
		$this->capture_index->replace(
			(int) $event['image_id'],
			(string) ($event['image_data']['image_exif_data'] ?? '')
		);
	}

	public function capture_after_import(\phpbb\event\data $event): void
	{
		$this->capture_after_upload($event);
	}

	public function capture_after_edit(\phpbb\event\data $event): void
	{
		if (!empty($event['file_changed']))
		{
			$this->capture_sync->refresh_image(
				(int) $event['image_id'],
				(string) $event['updated_image_data']['image_filename']
			);
		}
	}

	public function capture_deleted_images(\phpbb\event\data $event): void
	{
		$this->capture_index->delete($event['images']);
	}

	/**
	 * Every field prepare_data() can produce, mapped to the config value that
	 * decides whether it is shown. The config name is derived from the field name,
	 * so adding a field here is all it takes to make it individually switchable.
	 */
	public const DISPLAY_FIELDS = [
		'exif_date',
		'exif_focal',
		'exif_exposure',
		'exif_aperture',
		'exif_iso',
		'exif_whiteb',
		'exif_flash',
		'exif_cam_model',
		'exif_exposure_prog',
		'exif_exposure_bias',
		'exif_metering_mode',
	];

	/**
	 * Config name holding the display switch for one prepared field.
	 *
	 * @param string $field Key from DISPLAY_FIELDS
	 * @return string
	 */
	public static function display_config_name(string $field): string
	{
		return 'exif_show_' . substr($field, strlen('exif_'));
	}

	public function acp_config_get_display_vars(\phpbb\event\data $event): void
	{
		if ($event['mode'] == 'main')
		{
			global $template;

			$return_ary = $event['return_ary'];
			if (isset($return_ary['vars']['IMAGE_SETTINGS']))
			{
				$this->user->add_lang_ext('phpbbgallery/exif', 'info_exif');
				$template->assign_var('S_GALLERY_EXIF_CONFIG', true);

				$addon = ['id' => 'exif', 'name' => 'ACP_GALLERY_EXIF', 'accent' => '#0f766e'];
				$return_ary['vars']['IMAGE_SETTINGS']['disp_exifdata'] = ['lang' => 'DISP_EXIF_DATA',		'validate' => 'bool',	'type' => 'radio:yes_no', 'addon' => $addon];

				// One switch per field, registered the same way as the master switch
				// above, so the core config module reads and stores them natively.
				foreach (self::DISPLAY_FIELDS as $field)
				{
					$return_ary['vars']['IMAGE_SETTINGS'][self::display_config_name($field)] = [
						'lang'		=> 'DISP_' . strtoupper($field),
						'validate'	=> 'bool',
						'type'		=> 'radio:yes_no',
						'addon'		=> $addon,
					];
				}

				$event['return_ary'] = $return_ary;
			}
		}
	}

	/**
	 * Collect the prepared fields the administrator left enabled.
	 *
	 * @return array Field names
	 */
	protected function get_enabled_fields(): array
	{
		$enabled = [];
		foreach (self::DISPLAY_FIELDS as $field)
		{
			if ($this->gallery_config->get(self::display_config_name($field)))
			{
				$enabled[] = $field;
			}
		}

		return $enabled;
	}

	public function massimport_update_image_before(\phpbb\event\data $event): void
	{
		$additional_sql_data = $event['additional_sql_data'];

		$exif = new \phpbbgallery\exif\exif($event['file_link']);
		$exif->read();
		$additional_sql_data['image_exif_data'] = $exif->serialized;
		$additional_sql_data['image_has_exif'] = $exif->status;

		$event['additional_sql_data'] = $additional_sql_data;
		unset($exif);
	}

	public function massimport_update_image(\phpbb\event\data $event): void
	{
		if (!$event['file_updated'])
		{
			$additional_sql_data = $event['additional_sql_data'];

			$additional_sql_data['image_exif_data'] = '';
			$additional_sql_data['image_has_exif'] = \phpbbgallery\exif\exif::UNKNOWN;

			$event['additional_sql_data'] = $additional_sql_data;
		}
	}

	public function posting_edit_before_rotate(\phpbb\event\data $event): void
	{
		$image_data = $event['image_data'];

		if (($image_data['image_has_exif'] == \phpbbgallery\exif\exif::AVAILABLE) ||
		($image_data['image_has_exif'] == \phpbbgallery\exif\exif::UNKNOWN))
		{
			$additional_sql_data = $event['additional_sql_data'];

			$exif = new \phpbbgallery\exif\exif($event['file_link']);
			$exif->read();
			$additional_sql_data['image_exif_data'] = $exif->serialized;
			$additional_sql_data['image_has_exif'] = $exif->status;

			$event['additional_sql_data'] = $additional_sql_data;
			unset($exif);
		}
	}

	public function ucp_set_settings_nosubmit(): void
	{
		global $template, $phpbb_ext_gallery;
		$this->user->add_lang_ext('phpbbgallery/exif', 'info_exif');

		$template->assign_vars([
			'S_VIEWEXIFS'		=> $this->gallery_user->get_data('user_viewexif'),
		]);
	}

	public function upload_prepare_file_before(\phpbb\event\data $event): void
	{
		if (in_array($event['file']->get('extension'), ['jpg', 'jpeg']))
		{
			$additional_sql_data = $event['additional_sql_data'];

			$exif = new \phpbbgallery\exif\exif($event['file']->get('destination_file'));
			$exif->read();
			$additional_sql_data['image_exif_data'] = $exif->serialized;
			$additional_sql_data['image_has_exif'] = $exif->status;

			$event['additional_sql_data'] = $additional_sql_data;
			unset($exif);
		}
		else
		{
			$additional_sql_data = $event['additional_sql_data'];
			$additional_sql_data['image_exif_data'] = '';
			$additional_sql_data['image_has_exif'] = 0;
			$event['additional_sql_data'] = $additional_sql_data;
		}
	}

	public function upload_update_image_before(\phpbb\event\data $event): void
	{
		$image_data = $event['image_data'];

		if (($image_data['image_has_exif'] == \phpbbgallery\exif\exif::AVAILABLE) ||
		($image_data['image_has_exif'] == \phpbbgallery\exif\exif::UNKNOWN))
		{
			$additional_sql_data = $event['additional_sql_data'];

			$exif = new \phpbbgallery\exif\exif($event['file_link']);
			$exif->read();
			$additional_sql_data['image_exif_data'] = $exif->serialized;
			$additional_sql_data['image_has_exif'] = $exif->status;

			$event['additional_sql_data'] = $additional_sql_data;
			unset($exif);
		}
	}

	public function upload_update_image_nofilechange(\phpbb\event\data $event): void
	{
		$additional_sql_data = $event['additional_sql_data'];

		$additional_sql_data['image_exif_data'] = '';
		$additional_sql_data['image_has_exif'] = \phpbbgallery\exif\exif::UNKNOWN;

		$event['additional_sql_data'] = $additional_sql_data;
	}

	public function user_get_default_values(\phpbb\event\data $event): void
	{
		$default_values = $event['default_values'];
		if (!in_array('user_viewexif', $default_values))
		{
			$default_values['user_viewexif'] = (bool) \phpbbgallery\exif\exif::DEFAULT_DISPLAY;
			$event['default_values'] = $default_values;
		}
	}

	public function ucp_set_settings_submit(\phpbb\event\data $event): void
	{
		global $request;

		$additional_settings = $event['additional_settings'];
		if (!in_array('user_viewexif', $additional_settings))
		{
			$additional_settings['user_viewexif'] = $request->variable('viewexifs', false);
			$event['additional_settings'] = $additional_settings;
		}
	}

	public function user_validate_data(\phpbb\event\data $event): void
	{
		if ($event['name'] == 'user_viewexif')
		{
			$event['value'] = (bool) $event['value'];
			$event['is_validated'] = true;
		}
	}

	public function viewimage(\phpbb\event\data $event): void
	{
		$this->user->add_lang_ext('phpbbgallery/exif', 'info_exif');

		if ($this->gallery_config->get('disp_exifdata') && ($event['image_data']['image_has_exif'] != \phpbbgallery\exif\exif::UNAVAILABLE) && $this->is_jpeg_filename($event['image_data']['image_filename']) && function_exists('exif_read_data') && !$event['hide_private_data'])
		{
			$source = null;
			try
			{
				$source = $this->storage_workspace->materialize(
					\phpbbgallery\core\storage\provider_interface::SOURCE,
					(string) $event['image_data']['image_filename']
				);
				$exif = new \phpbbgallery\exif\exif($source->get_path(), (int) $event['image_id']);
				$exif->interpret($event['image_data']['image_has_exif'], $event['image_data']['image_exif_data']);

				if (!empty($exif->data['EXIF']))
				{
					$exif->send_to_template($this->gallery_user->get_data('user_viewexif'), 'exif_value', $this->get_enabled_fields());
				}
			}
			catch (\RuntimeException)
			{
				// Missing or unavailable provider objects simply have no EXIF block.
			}
			finally
			{
				if ($source !== null)
				{
					$source->release();
				}
			}
		}
	}

	/**
	 * Check whether a filename uses a JPEG extension supported by EXIF.
	 *
	 * @param string $filename Image filename
	 * @return bool
	 */
	protected function is_jpeg_filename(string $filename): bool
	{
		return in_array(strtolower(pathinfo($filename, PATHINFO_EXTENSION)), ['jpg', 'jpeg'], true);
	}
}
