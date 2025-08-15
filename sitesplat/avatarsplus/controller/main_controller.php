<?php
/**
*
* @package BBavatar+
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\avatarsplus\controller;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
* Main controller
*/
class main_controller
{
	protected $request;
	protected $user;
	protected $ext_root_path;
	public function __construct(\phpbb\request\request $request, \phpbb\user $user, $ext_root_path)
	{
		$this->request = $request;
		$this->user = $user;
		$this->ext_root_path = $ext_root_path;
	}

	public function json_data($gender)
	{
		return new BinaryFileResponse($this->ext_root_path . 'json/' . $gender . '.json');
	}

	public function send_to_gravatar()
	{
		//require "XML-RPC for PHP"
		require_once($this->ext_root_path . 'inc/xmlrpc.inc');

		// request data
		$rating = $this->request->variable('rating', 0);
		$datastring1 = $this->request->variable('datastring1', '', true);
		$datastring2 = $this->request->variable('datastring2', '', true);
		$imgdata = $this->request->variable('imgdata', '', true);

		//cheking for wrong data
		if (!$this->request->is_set_post('rating') || $rating > 3 || $rating < 0)
		{
			die('ratingfail');
		}
		elseif (!$this->request->is_set_post('datastring1') || empty($datastring1))
		{
			die('emailfail');
		}
		elseif (!$this->request->is_set_post('datastring2') || empty($datastring2))
		{
			die('passwordfail');
		}
		elseif (!$this->request->is_set_post('imgdata') || strpos($imgdata, 'data:image/png;base64') === false)
		{
			die('imagefail');
		}
		else {
			//removing 'data:image/png;base64' from string
			$data = $imgdata;
			list($type, $data) = explode(';', $data);
			list(, $data) = explode(',', $data);
			
			//saving temporary avatar in "temp-avatars" folder and getting its URL
			$data = base64_decode($data);
			$rnd = substr(md5(rand()), 0, 12);
			file_put_contents($this->ext_root_path . 'temp-avatars/' . $rnd . '.png', $data);
			$url = generate_board_url() . '/ext/sitesplat/avatarsplus/temp-avatars/' . $rnd . '.png';

			//creating email md5 hash
			$hash = md5(strtolower(trim($datastring1)));
			
			//creating XML values for method "grav.saveUrl"
			$values = new \xmlrpcval(
				array(
					"url" => new \xmlrpcval($url, "string"),
					"rating" => new \xmlrpcval($rating, "int"),
					"password" => new \xmlrpcval($datastring2, "string")
				),
				"struct"
			);
			
			//creating XML-RPC message, client, checking SSL cert of secure.gravatar.com, etc.
			$msg = new \xmlrpcmsg('grav.saveUrl', array($values), "array");
			$client = new \xmlrpc_client("/xmlrpc?user=" . $hash, "secure.gravatar.com", "https");
			//uncomment the line below if you wish to see debug messages in browser console via AJAX response
			//$client->setDebug( "2" );
			$client->setSSLVerifyPeer(true);
			$client->setSSLVerifyHost(2);
			$client->return_type = 'phpvals';
			$response = $client->send($msg);
			
			if (!$response->faultCode())
			{
				
				//getting avavar unique id from response from grav.saveUrl
				$avatar_id = $response->value();
				
				//creating new XML values for method "grav.useUserimage"
				$values = new \xmlrpcval(
					array(
						"userimage" => new \xmlrpcval($avatar_id, "string"),
						"addresses" => new \xmlrpcval(array(new \xmlrpcval($datastring1, "string")), "array"),
						"password" => new \xmlrpcval($datastring2, "string")
					),
					"struct"
				);

				//creating new XML-RPC message
				$msg = new \xmlrpcmsg('grav.useUserimage', array($values), "array");
				$response = $client->send($msg);
				if (!$response->faultCode())
				{
					die('success');
				}
				else
				{
					die(trim('faultcode' . htmlentities($response->faultCode())));
				}
			}
			else
			{
				die(trim('faultcode' . htmlentities($response->faultCode())));
			}
		}
	}

	public function save_temp_avatar()
	{
		$filename = $this->request->variable('filename', '', true);
		$data = $this->request->variable('imgdata', '', true);

		//cheking, that file is exactly png
		if (($data && strrpos($filename, 'png', -3) !== false) || ($data && strrpos($filename, 'svg', -3) !== false))
		{
			if (strrpos($filename, 'png', -3) !== false)
			{
				list($type, $data) = explode(';', $data);
				list($base, $data) = explode(',', $data);
				
				/*cheking that image data is base64 of png*/
				if ($type === 'data:image/png' && $base === 'base64')
				{
					$data = base64_decode($data);
					file_put_contents($this->ext_root_path . 'temp-avatars/' . $filename, $data);
					die('saved');
				}
				else
				{
					die('error');
				}
			}
		} else {
			die('error');
		}
	}

	public function download_temp_avatar()
	{
		/*getting file name and file type (png or svg) from GET*/
		$file = $this->ext_root_path . 'temp-avatars/' . $this->request->variable('filename', '', true);
		$type = $this->request->variable('filetype', '', true);

		/*Detect special conditions devices*/
		$user_agent = $this->request->variable('HTTP_USER_AGENT', '', false, \phpbb\request\request_interface::SERVER);
		$iPod    = strpos($user_agent, 'iPod');
		$iPhone  = strpos($user_agent, 'iPhone');
		$iPad    = strpos($user_agent, 'iPad');
		$Android = stripos($user_agent, 'Android');

		/*Checking if file exist (means that it has been written successfully earlier) and name is not empty*/
		if (file_exists($file) && $file != '../temp-avatars/')
		{
			header('Content-Length: ' . filesize($file));
			/*For iOS device in Safari force download is not possible*/
			if(!$iPad || !$iPhone || !$iPod)
			{
				# Android "Internet" Browser makes two GET request for a file.
				# If we change file name to "myAvatar" this will not work,
				# so we need to leave a temporary filename for Android
				if ($Android)
				{
					header('Content-Type: "image/png"');
					header('Content-Disposition: attachment; filename="' . basename($file) . '"');
				}
				else
				{
					header('Content-Type: "image/png"');
					header('Content-Disposition: attachment; filename="myAvatar.png"');
				}

				if (ob_get_length() > 0)
				{
					ob_clean();
				}

				flush();
				readfile($file);
				exit;
			}
		}
		else
		{
			die('File does not exist!');
		}
	}
}
