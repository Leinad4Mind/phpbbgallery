<?php
/**
* @package Splicker Giphy Embed
* @copyright (c) 2021 SplickerSnap.com
* @author Splicker
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace splicker\giphyembed\event;

use phpbb\db\driver\factory;
use phpbb\event\dispatcher;
use phpbb\json_response;
use phpbb\request\request;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\user;
use phpbb\auth\auth;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
    
    protected $config;    
    protected $helper;    
    protected $template;    
    protected $user;	
	protected $db;
	protected $auth;
	protected $config_text;
    
    public function __construct(config $config, helper $helper, template $template, user $user, factory $db, auth $auth, \phpbb\config\db_text $config_text)
    {
        $this->config = $config;
        $this->helper = $helper;
        $this->template = $template;
        $this->user = $user;
		$this->db = $db;
		$this->auth = $auth;
		$this->config_text = $config_text;
    }

    static public function getSubscribedEvents()
    {
        return array(
			'core.user_setup'	 				  => 'load_language_on_setup',
			'core.posting_modify_template_vars'	=> 'load_giphyembed_vars',				
        );
    }	
		
	public function load_language_on_setup($event)
	{
		$this->user->add_lang_ext('splicker/giphyembed', 'common');
	}	
		
	public function load_giphyembed_vars($event)
	{
		$this->template->assign_vars(array(
			'GE_ENABLED'	=> ($this->config['giphyembed_enable'])? true : false,
			'GE_APIKEY'	 => $this->config['giphyembed_apikey'],
			'GE_RATING'	 => $this->config['giphyembed_rating'],
			'GE_SCROLL'	 => ($this->config['giphyembed_scroll'])? false : true,
		));
	}
}
