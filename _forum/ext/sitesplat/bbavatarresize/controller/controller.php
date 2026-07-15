<?php
/**
*
* @package Avatar Resize
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbavatarresize\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use \phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\user;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\controller\helper;

/**
* Main controller
*/
class controller
{
	protected $config;
	protected $db;
	protected $user;
	protected $request;
	protected $template;
	protected $container;
	protected $helper;
	protected $php_ext;
	protected $root_path;

	public function __construct(config $config, driver_interface $db, user $user, request_interface $request, template $template, ContainerInterface $container, helper $helper, $php_ext, $root_path)
	{
		$this->config		= $config;
		$this->db			= $db;
		$this->user			= $user;
		$this->request		= $request;
		$this->template		= $template;
		$this->container	= $container;
		$this->helper		= $helper;
		$this->php_ext		= $php_ext;
		$this->root_path	= $root_path;
	}

	/**
	* Display the page
	*
	* @param string $route The route name for a page
	* @return Redirect
	* @access public
	*/
	public function display($route)
	{
		$this->request->enable_super_globals();
		
		$values = $_POST['slim'];

        $data = array();
        if (!is_array($values))
		{
            $values = array($values);
        }

        foreach ($values as $value)
		{
            $inputValue = $this->parseInput($value);
            if ($inputValue)
			{
                array_push($data, $inputValue);
            }
		}
		$data = $this->resize(array_shift($data));
		
		$result = array(
			'user_avatar_type' => 'avatar.driver.upload',
			'user_avatar' => $this->user->data['user_id'] . '_' . time() . '.' . $data['output']['ext'],
			'user_avatar_width' => $data['output']['width'],
			'user_avatar_height' => $data['output']['height'],
		);

		$sql = 'UPDATE ' . USERS_TABLE . '
			SET ' . $this->db->sql_build_array('UPDATE', $result) . '
			WHERE user_id = ' . (int) $this->user->data['user_id'];
		$this->db->sql_query($sql);

		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_langname = 'UCP_PROFILE_AVATAR'";
		$result = $this->db->sql_query($sql);
		$allowed_i = array();

		while ($row = $this->db->sql_fetchrow($result))
		{
			$allowed_i[] = $row['module_id'];
		}
		$this->db->sql_freeresult($result);
		
		$ucp_mode = 'ucp_profile&mode=avatar';
		$allowed_i[] = $ucp_mode;
		if ($this->user->page['page_name'] === 'ucp.' . $this->php_ext && in_array($this->request->variable('i', ''), $allowed_i))
		{
			return;
		}
		$url = append_sid('ucp.' . $this->php_ext, 'i=' . $ucp_mode);
	
        header('Content-Type: application/json');
		echo json_encode(array(
       		'status' => 'success',
        	'redirect' => $url
		));
		exit();
	}

    protected function parseInput($value)
	{
        // if no json received, exit, don't handle empty input values.
        if (empty($value)) {return null;}

        // Init
        $input = $actions = $output = $meta = null;
        $data = json_decode($value);

        if (isset ($data->input))
		{
            $inputData = isset($data->input->image) ? $this->getBase64Data($data->input->image) : null;
            $input = array(
                'data' => $inputData,
                'name' => $data->input->name,
                'type' => $data->input->type,
                'size' => $data->input->size,
                'width' => $data->input->width,
                'height' => $data->input->height,
            );
        }

        if (isset($data->output))
		{
            $outputData = isset($data->output->image) ? $this->getBase64Data($data->output->image) : null;
            $output = array(
                'data' => $outputData,
                'width' => $data->output->width,
                'height' => $data->output->height
            );
        }

        if (isset($data->actions))
		{
            $actions = array(
                'crop' => $data->actions->crop ? array(
                    'x' => $data->actions->crop->x,
                    'y' => $data->actions->crop->y,
                    'width' => $data->actions->crop->width,
                    'height' => $data->actions->crop->height,
                    'type' => $data->actions->crop->type
                ) : null,
                'size' => $data->actions->size ? array(
                    'width' => $data->actions->size->width,
                    'height' => $data->actions->size->height
                ) : null
            );
        }

        if (isset($data->meta))
		{
            $meta = $data->meta;
        }

        // We've sanitized the base64data and will now return the clean file object
        return array(
            'input' => $input,
            'output' => $output,
            'actions' => $actions,
            'meta' => $meta
        );
    }

    protected function getBase64Data($data)
	{
        return base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
    }

	protected function resize($data)
	{
		$nJPEGCompression = 100; 
		file_put_contents($data['meta']->filename, $data['output']['data']);

		$sImgSourceFilename = $data['meta']->filename;
		if ($arrImageData = getimagesize($sImgSourceFilename))
		{
			$type = $this->get_supported_image_types($arrImageData[2]);
			switch ($type['format'])
			{
				case IMG_JPG:
				  $imgSource = imagecreatefromjpeg($sImgSourceFilename);
				  break;
				case IMG_PNG:
				  $imgSource = imagecreatefrompng($sImgSourceFilename);
				  break;
				default:
				  $imgSource = null;
				  break;
			}
	
			if ($imgSource)
			{
				$nImgWidth = $data['output']['width'];
				$nImgHeight = $data['output']['height'];
	
				$doResize = false;
				if ($nImgHeight > $this->config['avatar_max_height'] || $nImgWidth > $this->config['avatar_max_width'])
				{ 
					$doResize = true;
					if ($nImgWidth > $this->config['avatar_max_width'])
					{
						$nRatio = ($nImgHeight / $nImgWidth);
						$nImgWidth = $this->config['avatar_max_width'];
						$nImgHeight = round($this->config['avatar_max_width'] * $nRatio);
					}
					if ($nImgHeight > $this->config['avatar_max_height'])
					{
						$nRatio = ($nImgWidth / $nImgHeight);
						$nImgHeight = $this->config['avatar_max_height'];
						$nImgWidth = round($this->config['avatar_max_height'] * $nRatio);
					}
				}
	
				if ($doResize)
				{
					$imgScaled = ImageCreateTrueColor($nImgWidth, $nImgHeight);
					if (imagecopyresampled($imgScaled, $imgSource, 0, 0, 0, 0, $nImgWidth, $nImgHeight, $data['output']['width'], $data['output']['height']))
					{
						switch ($type['format'])
						{
							case IMG_JPG:
								imagejpeg($imgScaled, $sImgSourceFilename);
							  break;
							case IMG_PNG:
								imagepng($imgScaled, $sImgSourceFilename);
							  break;
						}
					}
					imageDestroy($imgScaled);
					$data['output']['width'] = $nImgWidth;
					$data['output']['height'] = $nImgHeight;
					$data['output']['data'] = $imgScaled;
					$data['output']['ext'] = substr(strrchr($data['meta']->filename, '.'), 1);
					return $data;
				} else
				{
					$data['output']['width'] = $nImgWidth;
					$data['output']['height'] = $nImgHeight;
					$data['output']['data'] = $imgSource;
					$data['output']['ext'] = substr(strrchr($data['meta']->filename, '.'), 1);
					return $data;
				}
				imageDestroy($imgSource);
			}
		}
	}

	/**
	* Return supported image types
	*/
	protected function get_supported_image_types($type = false)
	{
		if (@extension_loaded('gd'))
		{
			$format = imagetypes();
			$new_type = 0;
	
			if ($type !== false)
			{
				// Type is one of the IMAGETYPE constants - it is fetched from getimagesize()
				switch ($type)
				{
					// JPG, JPC, JP2
					case IMAGETYPE_JPEG:
					case IMAGETYPE_JPC:
					case IMAGETYPE_JPEG2000:
					case IMAGETYPE_JP2:
					case IMAGETYPE_JPX:
					case IMAGETYPE_JB2:
						$new_type = ($format & IMG_JPG) ? IMG_JPG : false;
					break;
	
					// PNG
					case IMAGETYPE_PNG:
						$new_type = ($format & IMG_PNG) ? IMG_PNG : false;
					break;
				}
			} else
			{
				$new_type = array();
				$go_through_types = array(IMG_JPG, IMG_PNG);
	
				foreach ($go_through_types as $check_type)
				{
					if ($format & $check_type)
					{
						$new_type[] = $check_type;
					}
				}
			}
	
			return array(
				'gd'		=> ($new_type) ? true : false,
				'format'	=> $new_type,
				'version'	=> (function_exists('imagecreatetruecolor')) ? 2 : 1
			);
		}
	
		return array('gd' => false);
	}
}
