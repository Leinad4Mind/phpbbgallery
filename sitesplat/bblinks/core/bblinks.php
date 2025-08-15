<?php
/**
*
* @package sitesplat BBlinks
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bblinks\core;

class bblinks
{
    protected $config;
    protected $config_text;
    protected $user;
    protected $auth;
    protected $db;
    protected $php_ext;
    protected $link_type_classes;
    protected $ids_to_fetch;
    protected $infos;
    public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, $php_ext)
    {
        $this->config = $config;
        $this->config_text = $config_text;
        $this->user = $user;
        $this->auth = $auth;
        $this->db = $db;
        $this->php_ext = $php_ext;
        $this->link_type_classes = array(
            'pdf'	                => 'pdf-link',
            'gif|jpg|jpeg|png|bmp'	=> 'img-link',
            'zip|rar|7z'	        => 'zip-link',
        );
        $this->ids_to_fetch = $this->infos = array();
		foreach (array('forum', 'topic', 'post', 'user') as $resource)
		{
			$this->ids_to_fetch[$resource]	= array();
			$this->infos[$resource]			= array();
        }
        
        define('LOCALURLTOTEXT_TYPE_FORUM', 1);
		define('LOCALURLTOTEXT_TYPE_TOPIC', 2);
		define('LOCALURLTOTEXT_TYPE_POST', 3);
		define('LOCALURLTOTEXT_TYPE_USER', 4);
    }

    public function modify_links($message = '')
	{
        // A quick check before we start using regular expressions
        if (strpos($message, '<a ') === false)
        {
            return $message;
        }

        preg_match_all('#(<a\s[^>]+?>)(.*?</a>)#i', $message, $matches, PREG_SET_ORDER);
        foreach ($matches as $links)
        {
            $link = $new_link = $links[1];
            $href = preg_replace('/^.*href="([^"]*)".*$/i', '$1', $link);
            if ($href == $link) //no link was found
            {
                continue;
            }
            $href = $this->decode_entities($href);
            $scheme = substr($href, 0, strpos($href, ':'));
            if ($scheme)
            {
                $scheme = strtolower($scheme);
                if ($scheme != 'http' && $scheme != 'https') // Only classify links for these schemes (or no scheme)
                {
                    continue;
                }
            }

            if ($this->config['bblinks_skip_link_types'] && preg_match('/\.(?:' . $this->config['bblinks_skip_link_types'] . ')(?:[#?]|$)/', $href))
            {
                continue;
            }

            $is_local = null;
            $is_local = ($this->config['bblinks_internal_link_types'] && preg_match('/\.(?:' . $this->config['bblinks_internal_link_types'] . ')(?:[#?]|$)/', $href)) ? true : $is_local;
            $is_local = ($this->config['bblinks_external_link_types'] && preg_match('/\.(?:' . $this->config['bblinks_external_link_types'] . ')(?:[#?]|$)/', $href)) ? false : $is_local;
            if ($is_local === null)
            {
                if ($this->config_text->get('bblinks_forbidden_domains') && $this->match_domain($href, $this->config_text->get('bblinks_forbidden_domains')))
                {
                    $searches[] = $link;
                    $replacements[] = $this->insert_attribute('href', $this->config['bblinks_forbidden_new_url'], $new_link, true);
                    continue;
                }
                $is_local = $this->is_link_local($href);
            }
            $new_class	= $is_local ? $this->config['bblinks_internal_link_class'] : $this->config['bblinks_external_link_class'];
            $new_target	= $is_local ? $this->config['bblinks_internal_link_target'] : $this->config['bblinks_external_link_target'];
            $new_rel	= $is_local ? $this->config['bblinks_internal_link_rel'] : $this->config['bblinks_external_link_rel'];

            // Check if this link needs a special class based on the type of file to which it points.
            foreach ($this->link_type_classes as $extensions => $class)
            {
                if ($class && $extensions && preg_match('/\.(?:' . $extensions . ')(?:[#?]|$)/', $href))
                {
                    $new_class .= ' ' . $class;
                    break;
                }
            }
            if ($new_class)
            {
                $new_link = $this->insert_attribute('class', $new_class, $new_link, 'postlink');
            }
            if ($new_rel)
            {
                $new_link = $this->insert_attribute('rel', $new_rel, $new_link);
            }
            if ($new_target)
            {
                $new_link = $this->insert_attribute('target', $new_target, $new_link, true);
            }
            // Remove the link?
            if ($new_target === false || ($this->config['bblinks_hide_links_from_guests'] && !$is_local && !$this->user->data['is_registered']))
            {
                $new_text = is_string($this->config_text->get('bblinks_hide_links_from_guests_text')) ? $this->config_text->get('bblinks_hide_links_from_guests_text') : substr($links[2], 0, -4);
                $new_link = '<span class="link_removed">' . $new_text . '</span>';
                $link = $links[0];
            }
            else if (!$is_local && $this->config['bblinks_external_prefix'])
            {
                $external_prefix = ($this->config['bblinks_skip_prefix_types'] && preg_match('/\.(?:' . $this->config['bblinks_skip_prefix_types'] . ')(?:[#?]|$)/', $href)) ? '' : $this->config['bblinks_external_prefix'];
                $new_link = str_replace('href="', 'href="' . $external_prefix, $new_link);
            }

            if (!$is_local && $this->config['bblinks_enable_modal'])
            {
                $new_link = $this->insert_attribute('data-toggle', 'modal', $new_link);
                $new_link = $this->insert_attribute('data-target', '#bblinks_modal', $new_link);
                $new_link = str_replace('href=', 'data-link=', $new_link);
            }

            $searches[] = $link;
            $replacements[]	= $new_link;
        }
        if (isset($searches) && isset($replacements))
        {
            $message = str_replace($searches, $replacements, $message);
        }
        return $message;
    }

    public function is_link_local($url)
    {
        $url = strtolower($url);

        // Compare the URLs
        if (!($is_local = $this->match_domain($url, generate_board_url(true))))
        {
            // If there is no scheme, then it's probably a relative, local link
            $scheme = substr($url, 0, strpos($url, '://'));
            //$is_local = !$scheme || ($scheme && !in_array($scheme, array('http', 'https', 'mailto', 'ftp', 'gopher')));
            $is_local = !$scheme || ($scheme && !preg_match('/^[a-z0-9.]{2,16}$/i', $scheme));
        }

        // Not local, now check forced local domains
        if (!$is_local && $this->config_text->get('bblinks_internal_link_domains'))
        {
            $is_local = $this->match_domain($url, $this->config_text->get('bblinks_internal_link_domains'));
        }
        return $is_local;
    }

    public function local_url_to_text($text)
    {
		$board_url = $this->board_url_to_regexp(generate_board_url());
		$matches = array();

		/*
		 * search for all links on the whole page with one expensive preg_match_all() call.
		 * the regular expression matches:
		 * <a ... class="... postlink-local ..." ... href="{YOUR BOARD URL}/{SCRIPT FILE}.{PHP FILE EXTENSION}{PARAMETERS}">{TEXT}</a>
		 *
		 * the $matches array then contains for each single match:
		 * [0]        the full match
		 * ['anchor'] the full opening anchor tag '<a ... >' of the matched link
		 * ['script'] the linked phpBB SCRIPT FILE - either 'viewforum', 'viewtopic' or 'memberlist'
		 *            also, if extension Pages is installed (see https://www.phpbb.com/customise/db/extension/pages/),
		 *            look for 'app.php/page/' (without mod_rewrite) and 'page/' (with mod_rewrite)
		 * ['params'] the PARAMETERS like '?f=123&t=456' or '?p=789'
		 * ['text']   the TEXT content of the <a> element (to skip replacing custom text)
		 * ['type']   filled later with link type
		 * ['id']     filled later with resource ID
		 */

		// construct the regular expression:
		// all characters that are not separators (i.e. that do not end attribute or element)
		$not_sep = '[^"<>]*?';
		// the class attribute must contain 'postlink-local', but there may be other classes appended or prepended
		$class = $not_sep . 'postlink-local'. $not_sep;
		// the href attribute must contain the board url,
		$href =  $board_url .'/'.
			// followed by one of the scripts we are looking for,
			'(?|'.
				// which is either one of the default scripts in the phpBB root,
				// NB: (?P<foo>) returns the match of that group as named subpattern 'foo'
				'(?P<script>viewforum|viewtopic|memberlist)\.'. $this->php_ext .
				'|'.
				// or that is the Pages extension script that may either
				'(?P<script>'.
					// be called as app.php/page/... (when mod_rewrite is disabled)
					'app\.'. $this->php_ext .'/page/'.
					'|'.
					// or as page/... (when mod_rewrite is enabled)
					'page/'.
				')'.
			')'.
			// followed by the parameters
			'(?P<params>'. $not_sep .')';

		// that was hard work - now do some regular expression magic and fetch us some links!
		if (preg_match_all('#'.
			// we need the full opening anchor tag <a ... >
			'(?P<anchor><a'.
				// the attributes are in arbitrary order, separated by whitespace
				'(?:\s+'.
					// the attribute may be one of:
					'(?:'.
						// class: we need to match this
						'class="'. $class .'"'.
						'|'.
						// href= we need to match this too
						'href="'. $href .'"'.
						'|'.
						// other attributes are not of interest to us
						'\w+="'. $not_sep . '"'.
					')'.
				')+'.
			'>)'.
			// we also need the link text <a ...>text</a>
			// NB: do not use $not_sep here as the text may contain the " character
			'(?P<text>[^<]+?)'.
			'</a>#si',
			$text, $matches, PREG_SET_ORDER)
		)
		{
			// get all forum, post, topic and user ids that need to by fetched from the DB
			foreach ($matches as $k => $match)
			{
				/*
				* if the link contains custom text, do not replace it!
				* e.g. a user added an _internal_ link with the [url] bbcode and custom text,
				* like this: [url=http://myforum.com/viewforum.php?f=1]custom text[/url]
				*/
				if ($match['script'] !== '' && strpos($match['text'], $match['script']) === false)
				{
					continue;
				}

				// we store link type and resource id so we don't need to preg_match() again later
				$matches[$k]['type'] = 0;
				$matches[$k]['id'] = 0;
				switch ($match['script'])
				{
					case 'viewforum':
						// after all of the regular expression magic, this one is fairly easy:
						// one of '?', '&' or '&amp' followed by 'f=' and the numerical id we are looking for
						if (preg_match('/(?:\?|&|&amp;)f=(\d+)/', $match['params'], $id))
						{
							$this->ids_to_fetch['forum'][] = $id[1];
							$matches[$k]['type'] = LOCALURLTOTEXT_TYPE_FORUM;
							$matches[$k]['id'] = $id[1];
						}
					break;

					case 'viewtopic':
						if (preg_match('/(?:\?|&|&amp;)p=(\d+)/', $match['params'], $id))
						{
							$this->ids_to_fetch['post'][] = $id[1];
							$matches[$k]['type'] = LOCALURLTOTEXT_TYPE_POST;
							$matches[$k]['id'] = $id[1];
						}
						// handle link 'viewtopic?...#pxxx' too, see https://github.com/Mar-tin-G/LocalUrlToText/issues/7
						else if (preg_match('/#p(\d+)/', $match['params'], $id))
						{
							$this->ids_to_fetch['post'][] = $id[1];
							$matches[$k]['type'] = LOCALURLTOTEXT_TYPE_POST;
							$matches[$k]['id'] = $id[1];
						}
						else if (preg_match('/(?:\?|&|&amp;)t=(\d+)/', $match['params'], $id))
						{
							$this->ids_to_fetch['topic'][] = $id[1];
							$matches[$k]['type'] = LOCALURLTOTEXT_TYPE_TOPIC;
							$matches[$k]['id'] = $id[1];
						}
					break;

					case 'memberlist':
						if (strpos($match['params'], 'mode=viewprofile') !== false && preg_match('/(?:\?|&|&amp;)u=(\d+)/', $match['params'], $id))
						{
							$this->ids_to_fetch['user'][] = $id[1];
							$matches[$k]['type'] = LOCALURLTOTEXT_TYPE_USER;
							$matches[$k]['id'] = $id[1];
						}
					break;
				}
			}

			foreach (array('forum', 'topic', 'post', 'user') as $resource)
			{
				$this->ids_to_fetch[$resource] = array_unique($this->ids_to_fetch[$resource]);
			}

			// first fetch the posts from the DB, since if we're lucky we get all needed topic titles,
			// forum names and user names from one single query
			if (sizeof($this->ids_to_fetch['post']))
			{
				$sql_ary = array(
					'SELECT'		=> 'p.post_id, p.post_subject, t.topic_id, t.topic_title, f.forum_id, f.forum_name, u.user_id, u.username, u.user_colour',
					'FROM'			=> array(POSTS_TABLE => 'p'),
					'LEFT_JOIN'		=> array(
						array(
							'FROM'	=> array(TOPICS_TABLE => 't'),
							'ON'	=> 'p.topic_id = t.topic_id',
						),
						array(
							'FROM'	=> array(FORUMS_TABLE => 'f'),
							'ON'	=> 't.forum_id = f.forum_id',
						),
						array(
							'FROM'	=> array(USERS_TABLE => 'u'),
							'ON'	=> 'p.poster_id = u.user_id',
						),
					),
					'WHERE'			=> $this->db->sql_in_set('p.post_id', $this->ids_to_fetch['post']),
				);
				$this->fetch_from_db($sql_ary);
			}

			// if there are topic IDs left to be fetched, we execute this query next, because
			// perhaps this query fetches also the missing forum names
			if ($this->ids_to_fetch['topic'])
			{
				$sql_ary = array(
					'SELECT'		=> 't.topic_id, t.topic_title, f.forum_id, f.forum_name',
					'FROM'			=> array(TOPICS_TABLE => 't'),
					'LEFT_JOIN'		=> array(
						array(
							'FROM'	=> array(FORUMS_TABLE => 'f'),
							'ON'	=> 't.forum_id = f.forum_id',
						),
					),
					'WHERE'			=> $this->db->sql_in_set('t.topic_id', $this->ids_to_fetch['topic']),
				);
				$this->fetch_from_db($sql_ary);
			}

			// bad luck, still forum IDs left, we have to query a third time...
			if (sizeof($this->ids_to_fetch['forum']))
			{
				$sql_ary = array(
					'SELECT'	=> 'f.forum_id, f.forum_name',
					'FROM'		=> array(FORUMS_TABLE => 'f'),
					'WHERE'		=> $this->db->sql_in_set('f.forum_id', $this->ids_to_fetch['forum']),
				);
				$this->fetch_from_db($sql_ary);
			}

			// ... and a fourth time for the missing user names
			if (sizeof($this->ids_to_fetch['user']))
			{
				$sql_ary = array(
					'SELECT'	=> 'u.user_id, u.username, u.user_colour',
					'FROM'		=> array(USERS_TABLE => 'u'),
					'WHERE'		=> $this->db->sql_in_set('u.user_id', $this->ids_to_fetch['user']),
				);
				$this->fetch_from_db($sql_ary);
			}

			// now that all topic titles, forum names and user names are fetched, we begin
			// and replace the local links with the configured text replacements
			foreach ($matches as $match)
			{
				if (empty($match['type']))
				{
					continue;
				}

				switch ($match['type'])
				{
					case LOCALURLTOTEXT_TYPE_FORUM:
						if (isset($this->infos['forum'][$match['id']]))
						{
							$text = str_replace(
								$match[0],
								$match['anchor'] . str_replace(
									'{FORUM_NAME}',
									$this->infos['forum'][$match['id']]['name'],
									htmlspecialchars_decode($this->config['bblinks_urltotext_forum'])
								) . '</a>',
								$text
							);
						}
					break;

					case LOCALURLTOTEXT_TYPE_POST:
						if (isset($this->infos['post'][$match['id']]))
						{
							$text = str_replace(
								$match[0],
								$match['anchor'] . str_replace(
									array(
										'{USER_NAME}',
										'{USER_COLOUR}',
										'{POST_SUBJECT}',
										'{TOPIC_TITLE}',
										'{FORUM_NAME}',
										'{POST_OR_TOPIC_TITLE}',
									),
									array(
										$this->infos['user'][$this->infos['post'][$match['id']]['user_id']]['username'],
										$this->infos['user'][$this->infos['post'][$match['id']]['user_id']]['usercolour'],
										$this->infos['post'][$match['id']]['subject'],
										$this->infos['topic'][$this->infos['post'][$match['id']]['topic_id']]['title'],
										$this->infos['forum'][$this->infos['post'][$match['id']]['forum_id']]['name'],
										($this->infos['post'][$match['id']]['subject'] == '' ? $this->infos['topic'][$this->infos['post'][$match['id']]['topic_id']]['title'] : $this->infos['post'][$match['id']]['subject']),
									),
									htmlspecialchars_decode($this->config['bblinks_urltotext_post'])
								) . '</a>',
								$text
							);
						}
					break;

					case LOCALURLTOTEXT_TYPE_TOPIC:
						if (isset($this->infos['topic'][$match['id']]))
						{
							$text = str_replace(
								$match[0],
								$match['anchor'] . str_replace(
									array(
										'{TOPIC_TITLE}',
										'{FORUM_NAME}',
									),
									array(
										$this->infos['topic'][$match['id']]['title'],
										$this->infos['forum'][$this->infos['topic'][$match['id']]['forum_id']]['name'],
									),
									htmlspecialchars_decode($this->config['bblinks_urltotext_topic'])
								) . '</a>',
								$text
							);
						}
					break;

					case LOCALURLTOTEXT_TYPE_USER:
						if (isset($this->infos['user'][$match['id']]))
						{
							$text = str_replace(
								$match[0],
								$match['anchor'] . str_replace(
									array(
										'{USER_NAME}',
										'{USER_COLOUR}',
									),
									array(
										$this->infos['user'][$match['id']]['username'],
										$this->infos['user'][$match['id']]['usercolour'],
									),
									htmlspecialchars_decode($this->config['bblinks_urltotext_user'])
								) . '</a>',
								$text
							);
						}
					break;
				}
			}
		}

		return $text;
	}

	/**
	* Fetch information about resources from the database
	*
	* Saves the fetched information to $infos property and removes ids of
	* already fetched resources from $ids_to_fetch property.
	*
	* @param	array		$sql_ary	Valid array for DBAL sql_build_query()
	* @return	null
	* @access	private
	*/
	private function fetch_from_db($sql_ary)
	{
		$ids_to_remove = array();
		foreach (array('forum', 'topic', 'post', 'user') as $resource)
		{
			$ids_to_remove[$resource] = array();
		}

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			if (isset($row['forum_id']))
			{
				if ($this->auth->acl_get('f_read', $row['forum_id']))
				{
					$this->infos['forum'][$row['forum_id']] = array(
						'name'	=> $row['forum_name'],
					);
				}
				$ids_to_remove['forum'][] = $row['forum_id'];
			}
			if (isset($row['topic_id']))
			{
				if (isset($row['forum_id']) && $this->auth->acl_get('f_read', $row['forum_id']))
				{
					$this->infos['topic'][$row['topic_id']] = array(
						'title'		=> $row['topic_title'],
						'forum_id'	=> $row['forum_id'],
					);
				}
				$ids_to_remove['topic'][] = $row['topic_id'];
			}
			if (isset($row['post_id']))
			{
				if (isset($row['forum_id']) && $this->auth->acl_get('f_read', $row['forum_id']))
				{
					$this->infos['post'][$row['post_id']] = array(
						'user_id'	=> $row['user_id'],
						'topic_id'	=> $row['topic_id'],
						'forum_id'	=> $row['forum_id'],
						'subject'	=> $row['post_subject'],
					);
				}
				$ids_to_remove['post'][] = $row['post_id'];
			}
			if (isset($row['user_id']))
			{
				$this->infos['user'][$row['user_id']] = array(
					'username'		=> $row['username'],
					'usercolour'	=> ($row['user_colour'] == '' ? 'inherit' : '#' . $row['user_colour']),
				);
				$ids_to_remove['user'][] = $row['user_id'];
			}
		}
		$this->db->sql_freeresult($result);

		foreach (array('forum', 'topic', 'post', 'user') as $resource)
		{
			$this->ids_to_fetch[$resource] = array_diff($this->ids_to_fetch[$resource], $ids_to_remove[$resource]);
		}
	}

	/**
	* Create regular expression from given URL, including common URL protocol
	* schemes "http:" and "https:"
	*
	* @param	string		$url	URL to be converted to regular expression
	* @return	string				URL in regular epxression format with common schemes
	* @access	private
	*/
	private function board_url_to_regexp($url)
	{
		$url_without_scheme = preg_replace('/^[a-z0-9.-]+:/', '', $url);
		return 'https?\:' . preg_quote($url_without_scheme);
	}

    private function decode_entities($text)
    {
        $text = html_entity_decode($text, ENT_QUOTES, 'ISO-8859-1');        //UTF-8 does not work!
        $text = preg_replace_callback('/&#(\d+);/m', function($match){
            return chr($match[1]);
        }, $text);             //decimal notation
        $text = preg_replace_callback('/&#x([a-f0-9]+);/mi', function($match){
            return chr('0x' . $match[1]);
        }, $text);   //hex notation
        return $text;
    }

    private function match_domain($url, $domains)
    {
        $url = $this->extract_host($url);
        $url = utf8_case_fold_nfc($url);
        $url_split = array_reverse(explode('.', $url));

        $domain_list = is_string($domains) ? explode(';', $domains) : $domains;
        foreach ($domain_list as $domain)
        {
            $domain = $this->extract_host($domain);
            $domain = utf8_case_fold_nfc($domain);

            // Ignoring all subdomains, so check if our URL ends with domain
            if (substr($url, -strlen($domain)) == $domain)
            {
                return true;
            }
            $domain_split = array_reverse(explode('.', $domain));
            $match_count = 0;
            $match_list = array();
            foreach ($domain_split as $index => $segment)
            {
                if (isset($url_split[$index]) && strcmp($url_split[$index], $segment) === 0)
                {
                    $match_count += 1;
                    array_splice($match_list, 0, 0, $segment);
                    continue;
                }
                break;
            }
            if ($match_count > 2 || ($match_count == 2 && strlen($match_list[0]) > 2)) // not the best check, but catches domains like 'co.jp'
            {
                return true;
            }
        }
        return false;
    }

    private function extract_host($url)
    {
        // Remove everything before and including the double slashes
        if (($double_slash_pos = strpos($url, '//')) !== false)
        {
            $url = substr($url, $double_slash_pos + 2);
        }

        // Remove everything after the domain, including the slash
        if (($domain_end_pos = strpos($url, '/')) !== false)
        {
            $url = substr($url, 0, $domain_end_pos);
        }
        return $url;
    }

    private function insert_attribute($attr_name, $new_attr, $html_tag, $overwrite = false)
    {
        $javascript	= (strpos($attr_name, 'on') === 0);	// onclick, onmouseup, onload, etc.
        $old_attr = preg_replace('/^.*' . $attr_name . '="([^"]*)".*$/i', '$1', $html_tag);
        $is_attr = !($old_attr == $html_tag);		// Does the attribute already exist?
        $old_attr = ($is_attr) ? $old_attr : '';

        if ($javascript)
        {
            if ($is_attr && !$overwrite)
            {
                $old_attr = ($old_attr && ($last_char = substr(trim($old_attr), -1)) && $last_char != '}' && $last_char != ';') ? $old_attr . ';' : $old_attr; // Ensure we can add code after any existing code
                $new_attr = $old_attr . $new_attr;
            }
            $overwrite = true;
        }

        if ($overwrite && is_string($overwrite))
        {
            if (strpos(' ' . $overwrite . ' ', ' ' . $old_attr . ' ') !== false)
            {
                // Overwrite the specified value if it exists, otherwise just append the value.
                $new_attr = trim(str_replace(' '  . $overwrite . ' ', ' ' . $new_attr . ' ', ' '  . $old_attr . ' '));
            }
            else
            {
                $overwrite = false;
            }
        }
        if (!$overwrite)
        {
                // Append the new one if it's not already there.
            $new_attr = strpos(' ' . $old_attr . ' ', ' ' . $new_attr . ' ') === false ? trim($old_attr . ' ' . $new_attr) : $old_attr;
        }

        $html_tag = $is_attr ? str_replace("$attr_name=\"$old_attr\"", "$attr_name=\"$new_attr\"", $html_tag) : str_replace('>', " $attr_name=\"$new_attr\">", $html_tag);
        return $html_tag;
    }
}