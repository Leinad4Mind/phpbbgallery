<?php
/**
 * Created by PhpStorm.
 * User: lucifer
 * Date: 9/2/16
 * Time: 6:11 PM
 */

namespace phpbbgallery\core\file\types;


use phpbb\files\types\type_interface;
use phpbb\files\factory;
use phpbb\language\language;
use bantu\IniGetWrapper\IniGetWrapper;
use phpbb\files\upload;
use phpbb\request\request_interface;
use phpbb\files\filespec;

class multiform implements type_interface
{

	/** @var factory Files factory */
	protected $factory;
	/** @var language */
	protected $language;
	/** @var IniGetWrapper */
	protected $php_ini;
	/** @var plupload */
	protected $plupload;
	/** @var request_interface */
	protected $request;
	/** @var \phpbb\files\upload */
	protected $upload;
	/**
	 * Construct a form upload type
	 *
	 * @param factory			$factory	Files factory
	 * @param language			$language	Language class
	 * @param IniGetWrapper		$php_ini	ini_get() wrapper
	 * @param plupload			$plupload	Plupload
	 * @param request_interface	$request	Request object
	 */
	public function __construct(factory $factory, language $language, IniGetWrapper $php_ini, \phpbb\plupload\plupload $plupload, request_interface $request, \phpbb\files\upload $upload)
	{
		$this->factory = $factory;
		$this->language = $language;
		$this->php_ini = $php_ini;
		$this->plupload = $plupload;
		$this->request = $request;
		$this->upload = $upload;
		$files = $this->upload('files');

		return $files;
	}
	/**
	 * Handle upload for upload types. Arguments passed to this method will be
	 * handled by the upload type classes themselves.
	 *
	 * @return \phpbb\files\filespec|bool Filespec instance if upload is
	 *                                    successful or false if not
	 */
	public function upload()
	{
		$args = func_get_args();
		return $this->multiform_upload($args[0]);
	}

	/**
	 * Set upload instance
	 * Needs to be executed before every upload.
	 *
	 * @param upload $upload Upload instance
	 *
	 * @return type_interface Returns itself
	 */
	public function set_upload(upload $upload)
	{
		// TODO: Implement set_upload() method.
	}

	public function multiform_upload($form_name)
	{
		$uploads = ($this->request->variable($form_name, array('name'=> array('' => ''), 'type' => array('' => ''), 'tmp_name' => array('' => ''), 'error' =>  array('' => ''), 'size' => array('' => '')), true, \phpbb\request\request_interface::FILES));
		$upload_redy = array();
		for ($i = 0; $i < count($uploads['name']); $i++)
		{
			$upload_redy[$i] = array(
				'name' => $uploads['name'][$i],
				'type' => $uploads['type'][$i],
				'tmp_name' => $uploads['tmp_name'][$i],
				'error'	=> ($uploads['error'][$i] ? $uploads['error'][$i] : null),
				'size'	=> $uploads['size'][$i]
			);
		}
		$files = array();
		foreach ($upload_redy as $ID => $VAR)
		{
			$upload = array(
				'name' => $VAR['name'],
				'type' => $VAR['type'],
				'tmp_name' => $VAR['tmp_name'],
				'error'	=> $VAR['error'],
				'size'	=> $VAR['size']
			);

			$file = $this->factory->get('filespec')
				->set_upload_ary($upload)
				->set_upload_namespace($this->upload);

			if ($file->init_error())
			{
				$file->error[] = '';
				$files[$ID] = $file;
				continue;
			}
			// Error array filled?
			if (isset($upload['error']))
			{
				$error = $this->upload->assign_internal_error($upload['error']);

				if ($error !== false)
				{
					$file->error[] = $error;
					$files[$ID] = $file;
					continue;
				}
			}

			// Check if empty file got uploaded (not catched by is_uploaded_file)
			if (isset($upload['size']) && $upload['size'] == 0)
			{
				$file->error[] = $this->language->lang($this->upload->error_prefix . 'EMPTY_FILEUPLOAD');
				$files[$ID] = $file;
				continue;
			}

			// PHP Upload file size check
			$file = $this->check_upload_size($file);
			if (sizeof($file->error))
			{
				$files[$ID] = $file;
				continue;
			}

			// Not correctly uploaded
			if (!$file->is_uploaded())
			{
				$file->error[] = $this->language->lang($this->upload->error_prefix . 'NOT_UPLOADED');
				$files[$ID] = $file;
				continue;
			}
			$this->upload->common_checks($file);
			$files[$ID] = $file;
			continue;
		}

		return $files;
	}

	/**
	 * Check if upload exceeds maximum file size
	 *
	 * @param \phpbb\files\filespec $file Filespec object
	 *
	 * @return \phpbb\files\filespec Returns same filespec instance
	 */
	public function check_upload_size($file)
	{
		// PHP Upload filesize exceeded
		if ($file->get('filename') == 'none')
		{
			$max_filesize = $this->php_ini->getString('upload_max_filesize');
			$unit = 'MB';
			if (!empty($max_filesize))
			{
				$unit = strtolower(substr($max_filesize, -1, 1));
				$max_filesize = (int) $max_filesize;
				$unit = ($unit == 'k') ? 'KB' : (($unit == 'g') ? 'GB' : 'MB');
			}
			$file->error[] = (empty($max_filesize)) ? $this->language->lang($this->upload->error_prefix . 'PHP_SIZE_NA') : $this->language->lang($this->upload->error_prefix . 'PHP_SIZE_OVERRUN', $max_filesize, $this->language->lang($unit));
		}
		return $file;
	}
}