/**
 *
 * @package phpBB Extension - Favicon Notifications
 * @copyright (c) 2016 kasimi
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */
jQuery(function(i){var n=new Favico({bgColor:"#d00",textColor:"#fff",fontFamily:"sans-serif",fontStyle:"bold",type:"circle",position:"down",animation:"popFade"}),o=function(i){n.badge(i)},t=parseInt(i("em, strong.badge","#notification_list_button").html());o(t);var a=phpbb.markNotifications;phpbb.markNotifications=function(i,n){return o(n),a(i,n)},i(phpbb).on("kasimi_faviconnotifications_update",function(i,n){o(n)})})