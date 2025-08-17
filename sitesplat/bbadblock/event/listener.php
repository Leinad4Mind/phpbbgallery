<?php
/**
*
* BBadblock extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbadblock\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	protected $db;
	protected $request;
	protected $template;
	protected $user;
	protected $auth;
	protected $config;
	protected $helper;
	protected $phpbb_root_path;
	protected $php_ext;
	protected $exclude_forums;

	/**
	 * Constructor
	 *
	 * @access	public
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\controller\helper $helper, $phpbb_root_path, $php_ext)
	{
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->auth = $auth;
		$this->config = $config;
		$this->helper = $helper;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->exclude_forums = json_decode($this->config['bbadblock_hide_forums'], true);
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'						=> 'add_usersetup',
			'core.viewtopic_modify_post_data'		=> 'modify_post_data'
		);
	}

	public function modify_post_data($event)
	{
		if ($this->user->data['group_id'] == $this->config['bbadblock_group'] || $this->user->data['is_bot'] == 1 || $this->user->data['user_type'] == USER_FOUNDER)
		{
			return;			
		}
		
		if ($this->user->data['user_id'] == ANONYMOUS)
		{
			$bbadblock = explode('~', $this->request->variable($this->config['cookie_name'] . '_bbadblock', '', false, \phpbb\request\request_interface::COOKIE));
		} else
		{
			$bbadblock = explode('~', $this->user->data['bbadblock']);
		}
		if (!in_array($event['forum_id'], $this->exclude_forums) && isset($bbadblock[1]) && $bbadblock[1] > 0)
		{
			$this->user->add_lang_ext('sitesplat/bbadblock', 'bbadblock');
			$first = $event['start'];
			$postrow = $event['rowset'];
			foreach($postrow as $key => $value)
			{
				$postrow[$key]['hide_post'] = ($first) ? 1 : 0;
				$postrow[$key]['post_text'] = ($first) ? $this->config['bbadblock_message'] : $postrow[$key]['post_text'];
				$first = true;
			}
			$event['rowset'] = $postrow;
		}
	}
	
	
	public function add_usersetup($event)
	{
		if ($this->user->data['group_id'] == $this->config['bbadblock_group'] || $this->user->data['is_bot'] == 1 || $this->user->data['user_type'] == USER_FOUNDER)
		{
			return;			
		}
		
		$this->user->add_lang_ext('sitesplat/bbadblock', 'bbadblock');
		if ($this->user->data['user_id'] == ANONYMOUS)
		{
			$bbadblock = explode('~', $this->request->variable($this->config['cookie_name'] . '_bbadblock', '', false, \phpbb\request\request_interface::COOKIE));
		} else
		{
			$bbadblock = explode('~', $this->user->data['bbadblock']);
		}
		
		$check_ary = array(
			$this->user->page['page_name'] == 'ucp.php' && $this->request->variable('mode', '') == 'login',
			$this->user->page['page_name'] == 'ucp.php' && $this->request->variable('mode', '') == 'logout',
			$this->user->page['page_name'] == 'ucp.php' && $this->request->variable('mode', '') == 'register',
			(strpos( $this->user->page['page_name'], strstr($this->config['bbadblock_redirect'], '/memberships')) !== false)
		);

		if ($this->config['bbadblock_redirect'] && $event['user_data']['user_type'] != USER_FOUNDER && (isset($bbadblock[1]) && $bbadblock[1] > 0) && !array_sum($check_ary))
		{			
			redirect($this->config['bbadblock_redirect']);
		}
		
		$this->template->assign_vars(array(
			'BBADBLOCK'	=> $this->minify_js(
				'var ads = \'' . $this->config['bbadblock_classname'] . '\';
				var msg = \'' . addslashes($this->config['bbadblock_message']) . '\';
				var php_url = \'' . $this->helper->route('sitesplat_bbadblock_controller') . '\';
					
				function createXMLHttpRequest(){ 
					try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) {} 
					try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) {} 
					try { return new XMLHttpRequest(); } catch(e) {} 
					alert("XMLHttpRequest not supported"); 
					return null; 
				}
				
				function recordBlock(b){
					if ((b < 0 && ' . ((isset($bbadblock[1]) && $bbadblock[1] > 0) ? 1 : 0) . ') || (b > 0))
					{
						xmlPost = createXMLHttpRequest(); 
						// add our "blocked" value to our request 
						xmlPost.open( "GET", php_url+"?b="+b+"&u=' . $this->user->data['user_id'] . '&t=' . time() . '", true ); 
						// attach request header 
						xmlPost.setRequestHeader("X-Requested-With", "XMLHttpRequest"); 
						xmlPost.send( null );' .
						(($this->config['bbadblock_modal_alert']) ?
							(($this->config['bbadblock_autoreset'] && isset($bbadblock[1]) && $bbadblock[1] > 0) ? 
							'if (b == -1) {phpbb.alert("Information", \'' . (($bbadblock[1] -1 > 0) ? 
							$bbadblock[1] - 1 : 0)  . ' ' . addslashes($this->user->lang['BBADBLOCK_TOGO']) . '\') } else 
							{ phpbb.alert("Information", msg)}' : 'if (b == 1) phpbb.alert("Information", msg)') : '') . '
					}
				}
				
				onload=function(){
					// IE doesn\'t have a getElementByClassName function!
					if (document.getElementsByClassName == undefined) {
						document.getElementsByClassName = function(className)
						{
							var hasClassName = new RegExp("(?:^|\\s)" + className + "(?:$|\\s)");
							var allElements = document.getElementsByTagName("*");
							var results = [];
				
							var element;
							for (var i = 0; (element = allElements[i]) != null; i++) {
								var elementClass = element.className;
								if (elementClass && elementClass.indexOf(className) != -1 && hasClassName.test(elementClass))
									results.push(element);
							}
				
							return results;
						}
					}
				
				blocked = 0; 	
				var ad_nodes = document.getElementsByClassName(ads);
				for(i in ad_nodes){
					// detect if container has a height (has content) 
					if (ad_nodes[i].offsetHeight == 0){ 
						blocked = 1;
						ad_nodes[i].innerHTML = \'' . addslashes($this->user->lang['BBADBLOCK_MSG']) . '\';
					}else if (ad_nodes[i].offsetHeight > 0)
					{
						blocked = -1;	
					}
				}
				// activate recordBlock function 
				recordBlock(blocked); 
			}')
		));
	}

	protected function minify_js($input) { 
		 if(trim($input) === "") return $input; 
		 return preg_replace( 
			 array( 
				 // Remove comment(s) 
				 '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#', 
				 // Remove white-space(s) outside the string and regex 
				 '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s', 
				 // Remove the last semicolon 
				 '#;+\}#', 
				 // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}` 
				 '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i', 
				 // --ibid. From `foo['bar']` to `foo.bar` 
				 '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i' 
			 ), 
			 array( 
				 '$1', 
				 '$1$2', 
				 '}', 
				 '$1$3', 
				 '$1.$3' 
			 ), 
		 $input); 
	} 
}
