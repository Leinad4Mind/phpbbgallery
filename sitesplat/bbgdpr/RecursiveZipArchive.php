<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr;

// Thanks to https://stackoverflow.com/a/21044047/2908600
class RecursiveZipArchive extends \ZipArchive
{
	public function addTree($dirname, $localname = '')
	{
		if ($localname)
		{
			$this->addEmptyDir($localname);
		}
		$this->_addTree($dirname, $localname);
	}

	protected function _addTree($dirname, $localname)
	{
		$dir = opendir($dirname);
		while ($filename = readdir($dir))
		{
			if ($filename == '.' || $filename == '..')
			{
				continue;
			}

			$path = $dirname . '/' . $filename;
			$localpath = $localname ? ($localname . '/' . $filename) : $filename;
			if (is_dir($path))
			{
				$this->addEmptyDir($localpath);
				$this->_addTree($path, $localpath);
			}
			else if (is_file($path))
			{
				$this->addFile($path, $localpath);
			}
		}
		closedir($dir);
	}

	public static function zipTree($dirname, $zipFilename, $flags = 0, $localname = '')
	{
		$zip = new self();
		$zip->open($zipFilename, $flags);
		$zip->addTree($dirname, $localname);
		$zip->close();
	}
}
