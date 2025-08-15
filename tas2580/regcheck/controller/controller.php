<?php

/**
 * @author    MarkusWME <markuswme@pcgamingfreaks.at>
 * @copyright 2017 MarkusWME
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace pcgf\ajaxregistrationcheck\controller;

use phpbb\db\driver\factory;
use phpbb\event\dispatcher;
use phpbb\json_response;
use phpbb\request\request;
use phpbb\user;
use rmcgirr83\stopforumspam\event\main_listener;

/** @version 1.0.0 */
class controller
{
    /** @var request $request Request object */
    protected $request;

    /** @var factory $db Database object */
    protected $db;

    /** @var user $user User object */
    protected $user;

    /** @var dispatcher $dispatcher phpBB event dispatcher */
    protected $dispatcher;

    /** @var null|main_listener $sfs Stop Forum Spam listener object */
    protected $sfs;

    /**
     * Controller constructor
     *
     * @access public
     * @since  1.0.0
     *
     * @param request            $request    Request object
     * @param factory            $db         Database object
     * @param user               $user       User object
     * @param dispatcher         $dispatcher phpBB event dispatcher
     * @param main_listener|null $sfs        Stop Forum Spam listener object
     */
    public function __construct(request $request, factory $db, user $user, dispatcher $dispatcher, main_listener $sfs = null)
    {
        $this->request = $request;
        $this->db = $db;
        $this->user = $user;
        $this->dispatcher = $dispatcher;
        $this->sfs = $sfs;
    }

    /**
     * Function that checks the user input
     *
     * @access public
     * @since  1.0.0
     *
     * @param string $type The input type
     */
    public function check($type)
    {
        // Load needed language data
        $this->user->add_lang('ucp');
        $this->user->add_lang_ext('pcgf/ajaxregistrationcheck', array('ajaxregistrationcheck'));
        $response = new json_response();
        $response_text = array('INVALID QUERY', $this->user->lang('PCGF_AJAXREGISTRATIONCHECK_INVALID_QUERY'));
        if ($this->request->is_ajax())
        {
            switch ($type)
            {
                case 'username':
                    $username = $this->request->variable('search', '');
                    if ($username !== '')
                    {
                        $username_escaped = $this->db->sql_escape($username);
                        // Check if the name is already used
                        $query = 'SELECT username
                                    FROM ' . USERS_TABLE . "
                                    WHERE username = '" . $username_escaped . "'";
                        $result = $this->db->sql_query($query);
                        if ($this->db->sql_fetchrow($result))
                        {
                            $response_text[0] = 'NOT OK';
                            $response_text[1] = $this->user->lang('USERNAME_TAKEN_USERNAME');
                        }
                        $this->db->sql_freeresult($result);
                        if ($response_text[0] !== 'NOT OK')
                        {
                            // Check if the username is blocked by the board admin
                            $query = 'SELECT disallow_username
                                        FROM ' . DISALLOW_TABLE;
                            $result = $this->db->sql_query($query);
                            while ($disallowed_user = $this->db->sql_fetchrow($result))
                            {
                                // Check if the username matches the rule
                                if (preg_match('/^' . str_replace('%', '.*', $disallowed_user['disallow_username']) . '$/i', $username))
                                {
                                    $response_text[0] = 'NOT OK';
                                    $response_text[1] = $this->user->lang('USERNAME_DISALLOWED_USERNAME');
                                    break;
                                }
                            }
                            $this->db->sql_freeresult($result);
                            if ($response_text[0] !== 'NOT OK')
                            {
                                // All checks passed - set status to OK
                                $response_text[0] = 'OK';
                                $response_text[1] = $this->user->lang('PCGF_AJAXREGISTRATIONCHECK_USERNAME_OK');
                            }
                        }
                    }
                break;
                case 'email':
                    $email = $this->request->variable('search', '');
                    if ($email !== '')
                    {
                        $email_escaped = $this->db->sql_escape($email);
                        // Check if the email is already used
                        $query = 'SELECT user_email
                                    FROM ' . USERS_TABLE . "
                                    WHERE user_email = '" . $email_escaped . "'";
                        $result = $this->db->sql_query($query);
                        if ($this->db->sql_fetchrow($result))
                        {
                            $response_text[0] = 'NOT OK';
                            $response_text[1] = $this->user->lang('EMAIL_TAKEN_EMAIL');
                        }
                        $this->db->sql_freeresult($result);
                        if ($response_text[0] !== 'NOT OK')
                        {
                            // Check if the username is blocked by the board admin
                            $query = 'SELECT ban_email
                                        FROM ' . BANLIST_TABLE . "
                                        WHERE ban_email = '" . $email_escaped . "'";
                            $result = $this->db->sql_query($query);
                            while ($disallowed_email = $this->db->sql_fetchrow($result))
                            {
                                // Check if the username matches the rule
                                if (preg_match('/^' . str_replace('%', '.*', $disallowed_email['ban_email']) . '$/i', $email))
                                {
                                    $response_text[0] = 'NOT OK';
                                    $response_text[1] = $this->user->lang('EMAIL_BANNED_EMAIL');
                                    break;
                                }
                            }
                            $this->db->sql_freeresult($result);
                            if ($response_text[0] !== 'NOT OK')
                            {
                                // All checks passed - set status to OK
                                $response_text[0] = 'OK';
                                $response_text[1] = $this->user->lang('PCGF_AJAXREGISTRATIONCHECK_EMAIL_OK');
                            }
                        }
                    }
                break;
            }
            if ($this->sfs !== null)
            {
                // Check if user is banned via Stop Forum Spam
                $error = array();
                $data = array(
                    'username' => isset($username) ? $username : '',
                    'email'    => isset($email) ? $email : '',
                );
                // Trigger registration check event to get the Stom Forum Spam result
                $vars = array('error', 'data');
                extract($this->dispatcher->trigger_event('core.ucp_register_data_after', compact($vars)));
                $response_text[2] = $error[0];
            }
        }
        $response->send($response_text);
    }
}
