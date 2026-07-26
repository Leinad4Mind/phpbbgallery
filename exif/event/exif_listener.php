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
	protected \phpbbgallery\core\auth\auth $gallery_auth;
	protected \phpbbgallery\core\url $gallery_url;
	protected \phpbbgallery\core\user $gallery_user;

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.acp.config.get_display_vars'		=> 'acp_config_get_display_vars',
			'phpbbgallery.core.config.load_config_sets'			=> 'config_load_config_sets',
			'phpbbgallery.acpimport.update_image_before'	=> 'massimport_update_image_before',
			'phpbbgallery.acpimport.update_image'			=> 'massimport_update_image',
			'phpbbgallery.core.posting.edit_before_rotate'		=> 'posting_edit_before_rotate',
			'phpbbgallery.core.ucp.set_settings_submit'			=> 'ucp_set_settings_submit',
			'phpbbgallery.core.ucp.set_settings_nosubmit'		=> 'ucp_set_settings_nosubmit',
			'phpbbgallery.core.upload.prepare_file_before'		=> 'upload_prepare_file_before',
			'phpbbgallery.core.upload.update_image_before'		=> 'upload_update_image_before',
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
	* @param \phpbbgallery\core\auth\auth	$gallery_auth	Core gallery auth object
	* @param \phpbbgallery\core\url			$gallery_url	Core gallery url object
	* @param \phpbbgallery\core\user		$gallery_user	Core gallery user wrapper
	*/

	public function __construct(\phpbb\user $user, \phpbbgallery\core\config $gallery_config, \phpbbgallery\core\auth\auth $gallery_auth, \phpbbgallery\core\url $gallery_url, \phpbbgallery\core\user $gallery_user)
	{
		$this->user = $user;
		$this->gallery_config = $gallery_config;
		$this->gallery_auth = $gallery_auth;
		$this->gallery_url	= $gallery_url;
		$this->gallery_user = $gallery_user;
	}

	public function acp_config_get_display_vars(\phpbb\event\data $event): void
	{
		if ($event['mode'] == 'main')
		{
			$return_ary = $event['return_ary'];
			if (isset($return_ary['vars']['IMAGE_SETTINGS']))
			{
				$this->user->add_lang_ext('phpbbgallery/exif', 'info_exif');

				$return_ary['vars']['IMAGE_SETTINGS']['disp_exifdata'] = ['lang' => 'DISP_EXIF_DATA',		'validate' => 'bool',	'type' => 'radio:yes_no'];
				$event['return_ary'] = $return_ary;
			}
		}
	}

	public function config_load_config_sets(\phpbb\event\data $event): void
	{
		$additional_config_sets = $event['additional_config_sets'];
		$additional_config_sets['exif'] = 'phpbb_ext_gallery_exif_config_sets_exif';
		$event['additional_config_sets'] = $additional_config_sets;
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

		// To do (test contests)
		if ($this->gallery_config->get('disp_exifdata') && ($event['image_data']['image_has_exif'] != \phpbbgallery\exif\exif::UNAVAILABLE) && $this->is_jpeg_filename($event['image_data']['image_filename']) && function_exists('exif_read_data') /*&& ($this->gallery_auth->acl_check('m_status', $event['image_data']['image_album_id'], $event['album_data']['album_user_id']) || ($event['image_data']['image_contest'] != phpbb_ext_gallery_core_image::IN_CONTEST))*/)
		{
			$exif = new \phpbbgallery\exif\exif($this->gallery_url->path('upload') . $event['image_data']['image_filename'], $event['image_id']);
			$exif->interpret($event['image_data']['image_has_exif'], $event['image_data']['image_exif_data']);

			if (!empty($exif->data['EXIF']))
			{
				$exif->send_to_template($this->gallery_user->get_data('user_viewexif'));
			}
			unset($exif);
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
