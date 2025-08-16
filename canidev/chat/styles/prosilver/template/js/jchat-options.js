/*
* @name jchat-options.js
* @package cBB Chat
* @style: proSilver
* @version v1.1.3 10/03/2017 $
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

var jchat_style_options = {
	positions: {
		faq: {
			top		: ['#faqlinks', 'before'],
			bottom	: ['.panel:last', 'after']
		},
		index: {
			top		: ['.forabg:has(.topiclist):first', 'before'],
			bottom	: ['.forabg:has(.topiclist):last', 'after']
		},
		mcp: {
			top		: ['#tabs', 'before'],
			bottom	: ['#page-body', 'append']
		},
		memberlist: {
			top		: ['h2:first', 'after'],
			bottom	: ['#jumpbox', 'before']
		},
		search: {
			top		: ['h2:first', 'after'],
			bottom	: ['#page-body', 'append']
		},
		ucp: {
			top		: ['#tabs', 'before'],
			bottom	: ['#page-body', 'append']
		},
		viewforum: {
			top		: ['.action-bar.top', 'before'],
			bottom	: ['.action-bar.bottom', 'after']
		},
		viewonline: {
			top		: ['.action-bar.top', 'before'],
			bottom	: ['.action-bar.bottom', 'after']
		},
		viewtopic: {
			top		: ['.action-bar.top', 'before'],
			bottom	: ['.action-bar.bottom', 'after']
		},
		undefined: {
			top		: ['#page-body', 'prepend'],
			bottom	: ['#page-body', 'append']
		}
	}
};
