<?php

/**
 * SiteSplat Filesystem
 * @copyright (c) 2020 Dion Designs. All rights reserved.
 * @license Proprietary
 */

namespace sitesplat;

function fs_instance()
{
	static $fs;
	if (empty($fs)) {
		$fs = new \sitesplat\filesystem;
	}
	return $fs;
}
class filesystem
{
	public $phpbb_root_dir;
	public $fs_type = false;
	public $direct = false;
	public $ftp_error = '';
	protected $config, $root_ptr, $conn, $fs_root_dir;
	function __construct()
	{
		global $phpbb_container;
		$s = DIRECTORY_SEPARATOR;
		$ss = "{$s}ext{$s}sitesplat";
		$this->phpbb_root_dir = strstr(__DIR__, $ss, true);
		$this->config = $phpbb_container->get('config');
		$this->root_ptr = strlen($this->phpbb_root_dir) + 1;
		$filesystem = $phpbb_container->get('filesystem');
		if ($filesystem->is_writable($this->phpbb_root_dir) && $filesystem->is_writable("{$this->phpbb_root_dir}{$s}styles") && $filesystem->is_writable("{$this->phpbb_root_dir}{$ss}")) {
			$this->direct = true;
			$this->fs_type = 'direct';
		}
	}
	function __destruct()
	{
		if ($this->fs_type == 'ftp') {
			$this->fs_type = false;
			@ftp_quit($this->conn);
		}
	}
	function init()
	{
		static $already_called;
		if (!isset($already_called)) {
			$already_called = true;
			if (!$this->fs_type && function_exists('ftp_connect') && function_exists('gzinflate') && $this->connect()) {
				$this->fs_type = 'ftp';
			}
		}
		return $this->fs_type;
	}
	function connect()
	{
		if (empty($this->config['dd_fs'])) {
			$this->ftp_error = 'FTP_NO_CONFIG_DATA';
			return false;
		}
		$fs_data = json_decode(gzinflate(base64_decode($this->config['dd_fs'])), true);
		if (!is_array($fs_data) || empty($fs_data[4]) || (!empty($fs_data[5]) && !function_exists('ftp_ssl_connect'))) {
			$this->ftp_error = 'FTP_BAD_CONFIG_DATA';
			return false;
		}
		$this->fs_root_dir = $fs_data[2];
		if ($fs_data[5]) {
			$this->conn = @ftp_ssl_connect(($fs_data[0]) ?: 'localhost', $fs_data[1], 60);
		} else {
			$this->conn = @ftp_connect(($fs_data[0]) ?: 'localhost', $fs_data[1], 60);
		}
		if (!$this->conn) {
			$this->ftp_error = 'FTP_CANNOT_CONNECT';
			return false;
		}
		if (!@ftp_login($this->conn, $fs_data[3], $fs_data[4])) {
			@ftp_quit($this->conn);
			$this->ftp_error = 'FTP_BAD_USERPASS';
			return false;
		}
		@ftp_pasv($this->conn, true);
		if (!@ftp_chdir($this->conn, $this->fs_root_dir)) {
			@ftp_quit($this->conn);
			$this->ftp_error = 'FTP_BAD_ROOTDIR';
			return false;
		}
		return true;
	}
	function mkdir($dir, $perms = 0755)
	{
		if (!$dir || $dir == '/') {
			return false;
		}
		if (substr($dir, -1, 1) == '/') {
			$dir = substr($dir, 0, -1);
		}
		if (strpos($dir, '/') === false) {
			return false;
		}
		$parent = substr($dir, 0, strrpos($dir, '/') + 1);
		$reldir = substr(strrchr($dir, '/'), 1);
		if (file_exists($dir)) {
			return true;
		}
		if ($this->fs_type != 'ftp') {
			return @mkdir($dir, $perms);
		}
		if (!file_exists($parent)) {
			return false;
		}
		$parent = $this->fs_root_dir . substr(realpath($parent), $this->root_ptr - 1);
		@ftp_chdir($this->conn, $parent);
		if ($result = @ftp_mkdir($this->conn, $reldir)) {
			@ftp_chmod($this->conn, $perms, $reldir);
		}
		@ftp_chdir($this->conn, $this->fs_root_dir);
		return $result;
	}
	function rmdir($dir)
	{
		if (!$dir || $dir == '/') {
			return false;
		}
		if (substr($dir, -1, 1) == '/') {
			$dir = substr($dir, 0, -1);
		}
		if (strpos($dir, '/') === false) {
			return false;
		}
		if (!file_exists($dir)) {
			return true;
		}
		if ($this->fs_type != 'ftp') {
			return @rmdir($dir);
		}
		$parent = substr($dir, 0, strrpos($dir, '/') + 1);
		$reldir = substr(strrchr($dir, '/'), 1);
		$parent = $this->fs_root_dir . substr(realpath($parent), $this->root_ptr - 1);
		@ftp_chdir($this->conn, $parent);
		$result = @ftp_rmdir($this->conn, $reldir);
		@ftp_chdir($this->conn, $this->fs_root_dir);
		return $result;
	}
	function rename($old_handle, $new_handle)
	{
		if (!file_exists($old_handle) || file_exists($new_handle)) {
			return false;
		}
		if ($this->fs_type != 'ftp') {
			return @rename($old_handle, $new_handle);
		}
		if (@is_dir($old_handle)) {
			if (substr($old_handle, -1, 1) == '/') {
				$old_handle = substr($old_handle, 0, -1);
			}
			if (substr($new_handle, -1, 1) == '/') {
				$new_handle = substr($new_handle, 0, -1);
			}
		}
		$old_handle = realpath(substr($old_handle, 0, strrpos($old_handle, '/'))) . strrchr($old_handle, '/');
		$old_handle = substr($old_handle, $this->root_ptr);
		$new_handle = realpath(substr($new_handle, 0, strrpos($new_handle, '/'))) . strrchr($new_handle, '/');
		$new_handle = substr($new_handle, $this->root_ptr);
		return @ftp_rename($this->conn, $old_handle, $new_handle);
	}
	function chdir($dir = '')
	{
		if ($this->fs_type != 'ftp') {
			return @chdir($dir);
		}
		if (!$dir || $dir == '.') {
			return true;
		}
		if ($dir != '/') {
			if (substr($dir, -1, 1) == '/') {
				$dir = substr($dir, 0, -1);
			}
			$dir = substr(realpath($dir), $this->root_ptr);
		}
		return @ftp_chdir($this->conn, $dir);
	}
	function chmod($file, $perms, $override = false)
	{
		if (!file_exists($file)) {
			return false;
		}
		if ($override || $this->fs_type != 'ftp') {
			return @chmod($file, $perms);
		}
		$file = realpath(substr($file, 0, strrpos($file, '/'))) . strrchr($file, '/');
		$file = substr(realpath($file), $this->root_ptr);
		return @ftp_chmod($this->conn, $perms, $file);
	}
	function copy($from_file, $to_file, $delete_first = false)
	{
		if (!$this->fs_type || !file_exists($from_file)) {
			return false;
		}
		if ($delete_first) {
			$this->delete($to_file);
			clearstatcache();
		}
		if ($this->fs_type != 'ftp') {
			return @copy($from_file, $to_file);
		}
		$to_file = realpath(substr($to_file, 0, strrpos($to_file, '/'))) . strrchr($to_file, '/');
		$to_file = substr($to_file, $this->root_ptr);
		$result = @ftp_put($this->conn, $to_file, realpath($from_file), FTP_BINARY);
		return $result;
	}
	function put($file, $string, $delete_first = false)
	{
		if (!$this->fs_type) {
			return false;
		}
		if ($delete_first) {
			$this->delete($file);
			clearstatcache();
		}
		if ($this->fs_type != 'ftp') {
			return @file_put_contents($file, $string);
		}
		$fullfile = $file;
		$file = realpath(substr($file, 0, strrpos($file, '/'))) . strrchr($file, '/');
		$file = substr($file, $this->root_ptr);
		$handle = fopen('php://memory', 'r+');
		if ($string) {
			fwrite($handle, $string);
			rewind($handle);
		}
		$result = @ftp_fput($this->conn, $file, $handle, FTP_BINARY);
		fclose($handle);
		clearstatcache();
		if ($result) {
			$result = @filesize(realpath($fullfile));
		} else if (!$string) {
			return 0;
		}
		return $result;
	}
	function delete($file)
	{
		if ($this->fs_type != 'ftp') {
			return @unlink($file);
		}
		$file = substr(realpath($file), $this->root_ptr);
		return @ftp_delete($this->conn, $file);
	}
	function cwd()
	{
		if ($this->fs_type != 'ftp') {
			return getcwd();
		}
		return @ftp_pwd($this->conn);
	}
	function rmrf($target, $delete_top_dir = true)
	{
		if (is_dir($target)) {
			$files = glob($target . DIRECTORY_SEPARATOR . "*");
			if (!empty($files)) {
				foreach ($files as $file) {
					$this->rmrf($file);
				}
			}
			if ($delete_top_dir) {
				$this->rmdir($target);
			}
		} else {
			$this->delete($target);
		}
	}
	function zip_extract($archive, $destdir)
	{
		global $user;
		if (!is_dir($destdir)) {
			$this->ftp_error = sprintf($user->lang['FILE_NOT_FOUND'], $destdir);
			return false;
		}
		if (!defined('IN_ADMIN') || !$this->fs_type) {
			$this->ftp_error = $user->lang['SS_FILESYSTEM_NOT_AVAILABLE'];
			return false;
		}
		$fp = @fopen($archive, 'rb');
		if (!$fp) {
			$this->ftp_error = sprintf($user->lang['FILE_NOT_FOUND'], $archive);
			return false;
		}
		$dd_try = $topdir = false;
		rewind($fp);
		while (!feof($fp)) {
			$signature = fread($fp, 4);
			if ($signature == "\x50\x4b\x01\x02" || $signature == "\x50\x4b\x05\x06") {
				break;
			} else if ($signature == 'PK00') {
				continue;
			} else if ($signature == "\x50\x4b\x03\x04") {
				$data = unpack("@4/vc_method/@10/Vcrc/Vc_size/Vuc_size/vname_len/vextra_field", fread($fp, 26));
				$file_name = fread($fp, $data['name_len']);
				if ($data['extra_field']) {
					fread($fp, $data['extra_field']);
				}
				$target_filename = "{$destdir}/{$file_name}";
				if (!$data['uc_size'] && !$data['crc'] && substr($file_name, -1, 1) == '/' && !is_dir($target_filename)) {
					$dirpath = $destdir;
					$folders = explode('/', $file_name);
					foreach ($folders as $folder) {
						$folder = trim($folder);
						if (empty($folder)) {
							continue;
						}
						$dirpath .= "/{$folder}";
						if (!is_dir($dirpath)) {
							if (!$this->mkdir($dirpath, 0777)) {
								$this->ftp_error = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $dirpath);
								return false;
							}
							$this->chmod($dirpath, 0755);
							if (!$topdir) {
								$topdir = $dirpath;
							}
						}
					}
					continue;
				} else if (strpos($file_name, '/')) {
					if (!is_dir(pathinfo($target_filename, PATHINFO_DIRNAME))) {
						$dirpath = $destdir;
						$folders = explode('/', pathinfo($file_name, PATHINFO_DIRNAME));
						foreach ($folders as $folder) {
							$folder = trim($folder);
							if (empty($folder)) {
								continue;
							}
							$dirpath .= "/{$folder}";
							if (!is_dir($dirpath)) {
								if (!$this->mkdir($dirpath, 0777)) {
									$this->ftp_error = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $dirpath);
									return false;
								}
								$this->chmod($dirpath, 0755);
								if (!$topdir) {
									$topdir = $dirpath;
								}
							}
						}
					}
				}
				if (!$data['uc_size']) {
					$content = '';
				} else {
					$content = fread($fp, $data['c_size']);
				}
				if ($data['c_method'] == 0) {
					$this->put($target_filename, $content, true);
				} else if ($data['c_method'] == 8) {
					$this->put($target_filename, gzinflate($content, $data['uc_size']), true);
				} else {
					$this->ftp_error = $user->lang['UNSUPPORTED_ZIP_COMPRESSION_METHOD'];
					return false;
				}
			} else {
				if (!$dd_try) {
					$dd_try = true;
					fseek($fp, 8, SEEK_CUR);
					continue;
				}
				$this->ftp_error = $user->lang['UNEXPECTED_ZIP_HEADER'];
				return false;
			}
			$dd_try = false;
		}
		return $topdir;
	}
}
