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

class ImageOptim implements \sitesplat\bbcompress\optimizers\driver\driver_interface
{
	protected $log;
	protected $user;
	protected $image_optim;

	public function __construct(\phpbb\config\config $config, \phpbb\log\log $log, \phpbb\user $user)
	{
		$this->log = $log;
		$this->user = $user;

		$this->image_optim = new \ImageOptim\API($config['imageoptim_username']);
	}

	public function optimize_image($img_src)
	{
        try
        {
            $optimized_image = $this->image_optim->imageFromPath($img_src)->getBytes();
            file_put_contents($img_src, $optimized_image);
        }
        catch(\ImageOptim\InvalidArgumentException $e)
		{
			$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_IMAGEOPTIM_ARGUMENT_PROBLEM', false, array($e->getMessage(), 'reportee_id' => 0));
			return false;
		}
        catch(\ImageOptim\NetworkException $e)
		{
			$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_IMAGEOPTIM_NETWORK_PROBLEM', false, array($e->getMessage(), 'reportee_id' => 0));
			return false;
		}
        catch(\ImageOptim\NotFoundException $e)
		{
			$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_IMAGEOPTIM_NOT_FOUND_PROBLEM', false, array($e->getMessage(), 'reportee_id' => 0));
			return false;
		}
        catch(\ImageOptim\OriginServerException $e)
		{
			$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_IMAGEOPTIM_SERVER_PROBLEM', false, array($e->getMessage(), 'reportee_id' => 0));
			return false;
		}
        catch(Exception $e) {
			// Something else went wrong, unrelated to the ImageOptim API.
			return false;
		}

		return true;
	}
}