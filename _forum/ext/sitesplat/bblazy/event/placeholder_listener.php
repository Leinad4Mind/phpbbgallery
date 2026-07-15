<?php
/**
*
* @package BBlazy
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bblazy\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Intervention\Image\ImageManagerStatic as Image;

class placeholder_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.modify_uploaded_file'					=> 'generate_attachment_lqip',
			'core.modify_attachment_sql_ary_on_submit'	=> 'save_attachment_lqip', // TODO: new
			'core.modify_attachment_sql_ary_on_upload'	=> 'save_attachment_lqip', // TODO: new

			'core.parse_attachments_modify_template_data'	=> 'assign_attachment_lqip',
		);
	}

	protected $root_path;
	private $lqip;
	public function __construct($root_path)
	{
		$this->root_path = $root_path;
	}

	public function generate_attachment_lqip($event)
	{
		if ($event['is_image'])
		{
			$file = $this->root_path . 'files/' . $event['filedata']['physical_filename'];
			$img = false;
			switch ($event['filedata']['extension'])
			{
				case 'jpg':
				case 'jpeg':
					$img = imagecreatefromjpeg($file);
				break;

				case 'png':
					$img = imagecreatefrompng($file);
				break;

				case 'gif':
					$img = imagecreatefromgif($file);
				break;
			}

			if ($img)
			{
				$width = imagesx($img);
				$height = imagesy($img);
				$smaller_dim = min($width, $height);

				// heavily pixelate (smaller size will have 10 pixels)
				imagefilter($img, IMG_FILTER_PIXELATE, $smaller_dim / 10);

				if ($smaller_dim == $width)
				{
					$thumb_width = 10;
					$thumb_height = ($height / $width) * 10;
				}
				else
				{
					$thumb_width = ($width / $height) * 10;
					$thumb_height = 10;
				}

				// resize to smaller size being 10px
				$thumb = imagecreatetruecolor($thumb_width, $thumb_height);
				imagecopyresized($thumb, $img, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);

				ob_start();
					imagepng($thumb, null, 9);
				$image = ob_get_clean();
				$this->lqip = $width . ',' . $height . ',data:image/png;base64,' . base64_encode($image);
			}
		}
	}

	public function save_attachment_lqip($event)
	{
		$event->update_subarray('sql_ary', 'lqip', $this->lqip);
	}

	public function assign_attachment_lqip($event)
	{
		$block_array = $event['block_array'];
		$block_array['U_INLINE_LINK'] .= '" data-lqip="' . $event['attachment']['lqip'];
		$event['block_array'] = $block_array;
	}
}
