/**
* @package Quick Title Edition
* @copyright (c) 2016 ErnadoO
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
head.ready(function(){var t;t=jQuery,phpbb.addAjaxCallback("qte.attr_apply",function(e){var p=e.NEW_ATTRIBUTE,a=t("h2.topic-title .qte-attr");p?a.length?a.replaceWith(p):t("h2.topic-title").prepend(p+"&nbsp;"):t("h2.topic-title").html(t("h2.topic-title a")),phpbb.closeDarkenWrapper(3e3)})});