/*
* @name jchat-options.js
* @package cBB Chat
* @style: FLATBOOTS
* @version v1.1.1 01/07/2015 $
*
* @copyright (c) 2015 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

var jchat_style_options = {
	positions: {
		chat: ['main', 'append'],

		faq: {
			top		: ['h2:first', 'after'],
			bottom	: ['main > .row:last', 'before']
		},
		index: {
			top		: ['.panel-forum:first', 'before'],
			bottom	: ['.panel-stats', 'before']
		},
		mcp: {
			top		: ['h2:first', 'after'],
			bottom	: ['main', 'append']
		},
		memberlist: {
			top		: ['h3:first', 'after'],
			bottom	: ['main > .row:last', 'before']
		},
		search: {
			top		: ['h3:first', 'after'],
			bottom	: ['main', 'append']
		},
		ucp: {
			top		: ['h2:first', 'after'],
			bottom	: ['main', 'append']
		},
		viewforum: {
			top		: ['h3:first', 'after'],
			bottom	: ['main > .row:last', 'before']
		},
		viewonline: {
			top		: ['.panel-forum:first', 'before'],
			bottom	: ['.panel-forum:not(#chat-body):last', 'after']
		},
		viewtopic: {
			top		: ['h3:first', 'after'],
			bottom	: ['main > .row:last', 'before']
		},
		undefined: {
			top		: ['main', 'prepend'],
			bottom	: ['main', 'append']
		}
	}
};
