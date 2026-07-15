<?php
/**
*
* BBcompress
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbcompress\optimizers\driver;

class PHP implements \sitesplat\bbcompress\optimizers\driver\driver_interface
{
	protected $log;
	protected $user;

	public function __construct(\phpbb\log\log $log, \phpbb\user $user)
	{
		$this->log = $log;
		$this->user = $user;	
	}

	public function optimize_image($img_src)
	{
		$info = getimagesize($img_src);

		switch ($info['mime'])
		{
			case 'image/jpeg':

				$image = imagecreatefromjpeg($img_src);
				if (!$image || !imagejpeg($image, $img_src, 80))
				{
					$this->log->add('user', $this->user->data['user_id'] ?: 0, $this->user->ip ?: 0, 'LOG_PHP_JPEG_PROBLEM');
					return false;
				}

			break;

			case 'image/png':

				$image = imagecreatefrompng($img_src);
				$background = imagecolorallocatealpha($image, 255, 0, 255, 127);
				imagecolortransparent($image, $background);
				imagealphablending($image, false);
				imagesavealpha($image, true);

				if (!$image || !imagepng($image, $img_src, 9))
				{
					$this->log->add('user', $this->user->data['user_id'] ?: 0, $this->user->ip ?: 0, 'LOG_PHP_PNG_PROBLEM');
					return false;
				}

			break;
			
			default:
				if (substr($info['mime'], 0, 6) == 'image/')
				{
					// gif can't be compressed easily (see http://stackoverflow.com/a/18451734)
					// tga, tif nor tiff is not supported by vanilla php
					// BUT we will mark them optimized. Otherwise, cron task would run forever
					return true;
				}
				// else do nothing, source probably isn't image
				return false;
		}

		return true;
	}
}