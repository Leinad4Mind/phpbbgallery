<?php
/**
*
* Cloudflare IP
*
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\cloudflareip\acp;

class cf_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main($id, $mode)
	{
        global $user, $request, $config, $template;

		$this->tpl_name = 'cloudflare';
		$this->page_title = $user->lang('ACP_CLOUDFLARE');

        $error = array();
        $cf_zone = false;
        if ($config['sitesplat_cf_email'] && $config['sitesplat_cf_api_key'] && $config['sitesplat_cf_domain'])
        {
            try
            {
                $cf_api_instance = new \Cloudflare\Api($config['sitesplat_cf_email'], $config['sitesplat_cf_api_key']);
                $cf_zone_instance = new \Cloudflare\Zone($cf_api_instance);
                $cf_settings = new \Cloudflare\Zone\Settings($cf_api_instance);
                $cf_zones = $cf_zone_instance->zones($config['sitesplat_cf_domain']);
                if (isset($cf_zones->result[0]->id))
                {
                    $cf_zone = $cf_zones->result[0]->id;
                }
                else
                {
                    $errors = array();
                    foreach ($cf_zones->errors as $err)
                    {
                        $errors[] = $err->message;
                    }
                    $error[] = $user->lang('CLOUDFLARE_FETCH_FAILED', implode('<br>', $errors));
                }
            }
            catch (Exception $e)
            {
                $error[] = $user->lang('CLOUDFLARE_FETCH_FAILED', $e->getMessage());
            }
        }

        if ($request->is_set_post('sitesplat_cf_clear_cache'))
        {
            if (!$request->is_ajax() && !check_form_key('sitesplat/cloudflareip'))
			{
				trigger_error('FORM_INVALID');
			}

            if ($cf_zone)
            {
                $cf_cache = new \Cloudflare\Zone\Cache($cf_api_instance);
                $cf_purge = $cf_cache->purge($cf_zone, true);

                if (!isset($cf_purge->success) || empty($cf_purge->success))
                {
                    foreach($cf_purge->errors as $error)
                    {
                        $errors[] = $error->message;
                    }
                    trigger_error($user->lang('CLOUDFLARE_CLEAR_CACHE_FAILED', implode('<br>', $errors)) . adm_back_link($this->u_action), E_USER_WARNING);
                }
				trigger_error($user->lang('CLOUDFLARE_CLEAR_CACHE_SUCCESS') . adm_back_link($this->u_action));
            }
        }

        if ($request->is_set_post('submit'))
        {
            if (!check_form_key('sitesplat/cloudflareip'))
			{
				trigger_error('FORM_INVALID');
			}

            $response = array($user->lang('CLOUDFLARE_SETTINGS_SAVED'));
            $response_type = E_USER_NOTICE;

            // store local settings
            $config->set('sitesplat_cf_email', $request->variable('sitesplat_cf_email', ''));
            $config->set('sitesplat_cf_api_key', $request->variable('sitesplat_cf_api_key', ''));
            $config->set('sitesplat_cf_domain', $request->variable('sitesplat_cf_domain', ''));

            // set Cloudflare development mode
            if ($cf_zone && $config['sitesplat_cf_email'] && $config['sitesplat_cf_api_key'] && $config['sitesplat_cf_domain'])
            {
                $value = $request->variable('sitesplat_cf_dev_mode', '');

                $cf_return = $cf_settings->change_development_mode($cf_zone, $value);
                if (!isset($cf_return->success) || empty($cf_return->success))
                {
                    foreach ($cf_return->errors as $error)
                    {
                        $errors[] = $error->message;
                    }

                    $response[] = $user->lang('CLOUDFLARE_DEV_MODE_FAILED', implode('<br>', $errors));
                    $response_type = E_USER_WARNING;
                }
                else
                {
                    $response[] = $user->lang('CLOUDFLARE_DEV_MODE_SUCCESS');
                }
            }

            trigger_error(implode('<br>', $response) . adm_back_link($this->u_action), $response_type);
        }

        add_form_key('sitesplat/cloudflareip');
        $template->assign_vars(array(
			'U_ACTION'				        => $this->u_action,
            'ERROR'                         => implode('<br>', $error),
			'SITESPLAT_CF_EMAIL'	        => $config['sitesplat_cf_email'],
			'SITESPLAT_CF_API_KEY'	        => $config['sitesplat_cf_api_key'],
			'SITESPLAT_CF_DOMAIN'	        => $config['sitesplat_cf_domain'],
            'SITESPLAT_CF_DEV_MODE_STATUS'  => $cf_zone ? $cf_settings->development_mode($cf_zone)->result->value : false,
		));
	}
}
