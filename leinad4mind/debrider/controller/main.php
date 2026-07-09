<?php

/**
 * Debrider extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\debrider\controller;

use Exception;

const PROXY_HTTP = 1;
const PROXY_HTTPS = 2;

const PROVIDER_REAL_DEBRID = 1;
const PROVIDER_ALL_DEBRID = 2;

const API_SPEC = [
  PROVIDER_REAL_DEBRID => [
    'host' => 'https://api.real-debrid.com/rest/1.0',
    'endpoint' => '/unrestrict/link',
    'httpMethod' => 'POST',
  ],
  PROVIDER_ALL_DEBRID =>  [
    'host' => 'https://api.alldebrid.com/v4',
    'endpoint' => '/link/unlock',
    'httpMethod' => 'GET',
  ],
];

const PROXY_TYPE = [
  1 => CURLPROXY_HTTP,
  2 => CURLPROXY_HTTPS,
  3 => CURLPROXY_HTTP_1_0,
  4 => CURLPROXY_SOCKS4,
  5 => CURLPROXY_SOCKS4A,
  6 => CURLPROXY_SOCKS5,
  7 => CURLPROXY_SOCKS5_HOSTNAME,
];


class main
{
  /* @var \phpbb\config\config */
  protected $config;

  /* @var \phpbb\controller\helper */
  protected $helper;

  /* @var \phpbb\language\language */
  protected $language;

  /* @var \phpbb\template\template */
  protected $template;

  /* @var \phpbb\auth\auth */
  protected $auth;

  /* @var \phpbb\user */
  protected $user;

  /* @var \phpbb\cache\driver\driver_interface */
  protected $cache;

  public function __construct(
    \phpbb\config\config $config,
    \phpbb\controller\helper $helper,
    \phpbb\language\language $language,
    \phpbb\template\template $template,
    \phpbb\request\request $request,
    \phpbb\auth\auth $auth,
    \phpbb\user $user,
    \phpbb\cache\driver\driver_interface $cache
  ) {
    $this->config   = $config;
    $this->helper   = $helper;
    $this->language = $language;
    $this->template = $template;
    $this->request = $request;
    $this->auth = $auth;
    $this->user = $user;
    $this->cache = $cache;
  }


  protected function callAPI($method, $uri, $data)
  {
    $headers = [
      'Accept: application/json',
    ];

    $url = API_SPEC[$this->config['debrider_provider']]['host'] . $uri;

    if ($this->config['debrider_provider'] == PROVIDER_REAL_DEBRID) {
      $headers[] = 'Authorization: Bearer ' . $this->config['debrider_api_key'];
      $headers[] = 'Content-Type: application/x-www-form-urlencoded';
      if (is_array($data)) {
        $data = http_build_query($data);
      }
    } else if ($this->config['debrider_provider'] == PROVIDER_ALL_DEBRID) {
      $data['apikey'] = $this->config['debrider_api_key'];
    }

    $curl = curl_init();

    $use_proxy = $this->config['debrider_use_proxy'] && $this->config['debrider_proxy_host']
      && $this->config['debrider_proxy_credentials'];

    if ($use_proxy) {
      $proxy = $this->config['debrider_proxy_host'];
      $proxyauth = $this->config['debrider_proxy_credentials'];
      curl_setopt($curl, CURLOPT_PROXY, $proxy);
      curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxyauth);

      $proxy_type_key = (int) $this->config['debrider_proxy_type'];
      if (isset(PROXY_TYPE[$proxy_type_key])) {
          curl_setopt($curl, CURLOPT_PROXYTYPE, PROXY_TYPE[$proxy_type_key]);
      } else {
          throw new \RuntimeException('Invalid proxy type configured.');
      }
    }

    switch ($method) {
      case 'POST':
        curl_setopt($curl, CURLOPT_POST, 1);
        if ($data) {
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        break;
      case 'PUT':
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        if ($data) {
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        break;
      default:
        if ($data) {
          $url = sprintf("%s?%s", $url, http_build_query($data));
        }
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);

    // Timeout and SSL
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($curl, CURLOPT_TIMEOUT, 60);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);

    $result = curl_exec($curl);

    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
        curl_close($curl);
        throw new \RuntimeException("cURL error: $error_msg");
    }

    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    if (!$result) {
        throw new \RuntimeException('API returned empty response');
    }

    if ($http_code >= 400) {
        throw new \RuntimeException($this->language->lang('DEBRIDER_API_ERROR'));
    }

    $resp = json_decode($result);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \RuntimeException('Invalid JSON response: ' . json_last_error_msg());
    }

    return $resp;
  }

  /**
   * Controller for route /debrider/convert
   *
   * @throws \phpbb\exception\http_exception
   */
  public function handle()
  {

    $this->language->add_lang('debrider_common', 'leinad4mind/debrider');

    if ($this->request->is_ajax()) {
      $urls = $this->request->variable('urls', ['' => '']);

      $json_response = new \phpbb\json_response();

      // Check if user has permissions
      if (!$this->auth->acl_get('u_debrider_can_generate_url')) {
        return $json_response->send([
          'error' => $this->language->lang('DEBRIDER_NO_PERMISSION'),
        ]);
      }

      // Check empty URLs
      if (empty($urls)) {
        return $json_response->send([
          'error' => $this->language->lang('DEBRIDER_NO_URLS_PROVIDED'),
        ]);
      }

      $new_urls = [];

      $url_chunks = array_chunk($urls, 10);
      foreach ($url_chunks as $chunk) {
        foreach ($chunk as $url) {
            if ($this->config['debrider_provider'] == PROVIDER_REAL_DEBRID) {
              $data = 'link=' . $url;
            } else if ($this->config['debrider_provider'] == PROVIDER_ALL_DEBRID) {
              $data = [
                'agent' => 'mipony',
                'link' => $url,
              ];
            } else {
              throw new Exception('Unknown provider');
            }

            $key = '_leinad4mind_debrider_' . sha1($url);
            $cached = $this->cache->get($key);
            if ($cached !== false) {
              $new_urls[] = $cached;
              continue;
            }

            try {
              $resp = $this->callAPI(
                API_SPEC[$this->config['debrider_provider']]['httpMethod'],
                API_SPEC[$this->config['debrider_provider']]['endpoint'],
                $data
              );
            } catch (\Exception $e) {
              $result = ['original_url' => $url, 'error' => $e->getMessage()];
              $this->cache->put($key, $result, 3600); // error cache
              continue;
            }

            if ($this->config['debrider_provider'] == PROVIDER_REAL_DEBRID) {
              if (isset($resp->error)) {
                $result = ['original_url' => $url, 'error' => isset($resp->error_details) ? $resp->error_details : $resp->error];
                $this->cache->put($key, $result, 3600); // error cache
                continue;
              }
              $result = ['original_url' => $url, 'new_url' => $resp->download];
              $this->cache->put($key, $result, 259200 ); // 3 days
            } else if ($this->config['debrider_provider'] == PROVIDER_ALL_DEBRID) {
              if ($resp->status == 'error') {
                $result = ['original_url' => $url, 'error' => isset($resp->error->message) ? $resp->error->message : $resp->error];
                $this->cache->put($key, $result, 3600); // error cache
                continue;
              }
              if ($resp->status == 2) {
                $result = ['original_url' => $url, 'error' => $resp->data->time_left];
                $this->cache->put($key, $result, 3600); // error cache
                continue;
              }
              $result = ['original_url' => $url, 'new_url' => $resp->data->link];
              $this->cache->put($key, $result, 259200 ); // 3 days
            }
            $new_urls[] = $result;

            if ($cached == false) {
                $minute_key = '_leinad4mind_debrider_users_' . date('YmdHi');
                $user_id = (int) $this->user->data['user_id'];

                $users = $this->cache->get($minute_key);
                if ($users === false) {
                    $users = [];
                }

                if (!in_array($user_id, $users)) {
                    $users[] = $user_id;
                    $this->cache->put($minute_key, $users, 300);
                }

                $count = count($users);
                usleep(200000 * $count);
            }
        }
      }

      return $json_response->send([
        'results' => $new_urls,
      ]);
    }
  }
}
