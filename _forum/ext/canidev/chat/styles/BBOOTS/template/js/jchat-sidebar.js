/*
* @name jchat-options.js
* @package cBB Chat
* @style: BBOOTS with SideBar
* @version v1.1.2 20/08/2016 $
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

var jchat_style_options = {
	positions: {
		chat: ['#contentje', 'prepend'],

		faq: {
			top		: ['h3:first', 'after'],
			bottom	: ['#contentje > .row:last', 'before']
		},
		index: {
			top		: ['#contentje', 'prepend'],
			bottom	: ['#contentje .panel:not(#chat-body):last', 'after']
		},
		mcp: {
			top		: ['#contentje h2:first', 'after'],
			bottom	: ['#contentje', 'append']
		},
		memberlist: {
			top		: ['h3:first', 'after'],
			bottom	: ['#contentje > .row:last', 'before']
		},
		search: {
			top		: ['h3:first', 'after'],
			bottom	: ['#contentje', 'append']
		},
		ucp: {
			top		: ['#contentje h2:first', 'after'],
			bottom	: ['#jumpbox', 'before']
		},
		viewforum: {
			top		: ['h3:first', 'after'],
			bottom	: ['#contentje > .side-segment:last', 'before']
		},
		viewonline: {
			top		: ['#contentje .panel:first', 'before'],
			bottom	: ['#contentje', 'append']
		},
		viewtopic: {
			top		: ['h3:first', 'after'],
			bottom	: ['#contentje > .side-segment:last', 'before']
		},
		undefined: {
			top		: ['#contentje', 'prepend'],
			bottom	: ['#contentje', 'append']
		}
	}
};
