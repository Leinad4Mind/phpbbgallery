<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\file\types;

use bantu\IniGetWrapper\IniGetWrapper;
use phpbb\files\factory;
use phpbb\files\filespec;
use phpbb\language\language;
use phpbb\plupload\plupload;
use phpbb\request\request_interface;

class multiform extends \phpbb\files\types\base
{
	/** @var factory Files factory */
	protected factory $factory;
	/** @var plupload */
	protected plupload $plupload;
	/** @var request_interface */
	protected request_interface $request;
	/**
	 * Construct a form upload type
	 *
	 * @param factory			$factory	Files factory
	 * @param language			$language	Language class
	 * @param IniGetWrapper		$php_ini	ini_get() wrapper
	 * @param plupload			$plupload	Plupload
	 * @param request_interface	$request	Request object
	 */
	public function __construct(factory $factory, language $language, IniGetWrapper $php_ini, plupload $plupload, request_interface $request)
	{
		$this->factory = $factory;
		$this->language = $language;
		$this->php_ini = $php_ini;
		$this->plupload = $plupload;
		$this->request = $request;
	}
	/**
	 * {@inheritdoc}
	 */
	public function upload(): array
	{
		$args = func_get_args();
		if (!isset($args[0]))
		{
			return [];
		}
		return $this->form_upload($args[0]);
	}
	/**
	 * Form upload method
	 * Upload file from users hard disk
	 *
	 * @param string $form_name Form name assigned to the file input field (if it is an array, the key has to be specified)
	 *
	 * @return filespec $file Object "filespec" is returned, all further operations can be done with this object
	 * @access public
	 */
	protected function form_upload(string $form_name): array
	{

		$uploads = ($this->request->variable($form_name, ['name'=> ['' => ''], 'type' => ['' => ''], 'tmp_name' => ['' => ''], 'error' =>  ['' => ''], 'size' => ['' => '']], true, $this->request::FILES));
		$upload_ready = [];
		for ($i = 0; $i < count($uploads['name']); $i++)
		{
			$upload_ready[$i] = [
				'name' => $uploads['name'][$i],
				'type' => $uploads['type'][$i],
				'tmp_name' => $uploads['tmp_name'][$i],
				'error'	=> ($uploads['error'][$i] ? $uploads['error'][$i] : null),
				'size'	=> $uploads['size'][$i]
			];
		}
		$files = [];
		foreach ($upload_ready as $id => $upload_data)
		{
			$upload = [
				'name' => $upload_data['name'],
				'type' => $upload_data['type'],
				'tmp_name' => $upload_data['tmp_name'],
				'error'	=> $upload_data['error'],
				'size'	=> $upload_data['size']
			];

			$file = $this->factory->get('filespec')
				->set_upload_ary($upload)
				->set_upload_namespace($this->upload);

			if ($file->init_error())
			{
				$file->error[] = '';
				$files[$id] = $file;
				continue;
			}
			// Error array filled?
			if (isset($upload['error']))
			{
				$error = $this->upload->assign_internal_error($upload['error']);

				if ($error !== false)
				{
					$file->error[] = $error;
					$files[$id] = $file;
					continue;
				}
			}

			// Check if empty file got uploaded (not catched by is_uploaded_file)
			if (isset($upload['size']) && $upload['size'] == 0)
			{
				$file->error[] = $this->language->lang($this->upload->error_prefix . 'EMPTY_FILEUPLOAD');
				$files[$id] = $file;
				continue;
			}

			// PHP Upload file size check
			$file = $this->check_upload_size($file);
			if (sizeof($file->error))
			{
				$files[$id] = $file;
				continue;
			}

			// Not correctly uploaded
			if (!$file->is_uploaded())
			{
				$file->error[] = $this->language->lang($this->upload->error_prefix . 'NOT_UPLOADED');
				$files[$id] = $file;
				continue;
			}
			$this->upload->common_checks($file);
			$files[$id] = $file;
			continue;
		}

		return $files;
	}
}
