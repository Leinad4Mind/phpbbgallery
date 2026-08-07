<?php
/**
 *
 * Advanced Polls [Russian]
 *
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 * @author Translation by edualla (https://github.com/edualla)
 * @author Translation by FomenkoAndrey (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1294503)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'AP_TITLE_ACP'					=> 'Расширенные опросы',
	'AP_SETTINGS_ACP'				=> 'Настройки',

	'AP_TITLE'						=> 'Расширенные опросы',
	'AP_TITLE_EXPLAIN'				=> 'Расширяет систему опросов PHPBB новыми функциями, такими как скрытие голосований до конца опроса, просмотр пользователей, которые проголосовали, ограничение голосования и мн. др.',

	'AP_SETTINGS'					=> 'Настройки расширенных опросов',
	'AP_GLOBAL_SETTINGS'			=> 'Глобальные настройки Расширенных опросов (относятся ко всем опросам)',
	'AP_PER_POLL_SETTINGS'			=> 'Персональные настройки Расширенных опросов (выбираются в опросе со значениями по умолчанию, установленными ниже)',
	'AP_DEFAULT_POLL_VISIBILITY' => 'Видимость результатов по умолчанию',
	'AP_DEFAULT_POLL_VISIBILITY_EXPLAIN' => 'Режим видимости, изначально выбранный при создании опроса.',
	'AP_DEFAULT_POLL_VOTE_MODE' => 'Режим изменения голоса по умолчанию',
	'AP_DEFAULT_POLL_VOTE_MODE_EXPLAIN' => 'Режим изменения голоса, изначально выбранный при создании опроса.',
	'AP_VISIBILITY_PUBLIC' => 'Публичные — всегда показывать результаты',
	'AP_VISIBILITY_DEFAULT' => 'После первого голоса',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'После использования всех доступных голосов',
	'AP_VISIBILITY_PRIVATE' => 'Закрытые — только после завершения опроса',
	'AP_VOTE_MODE_NO_CHANGE' => 'Без изменений',
	'AP_VOTE_MODE_INCREMENTAL' => 'Постепенное голосование',
	'AP_VOTE_MODE_CHANGE' => 'Разрешить изменения',
	'AP_DEFAULT_SCORE_RESULT' => 'Результат оценки по умолчанию',
	'AP_DEFAULT_SCORE_RESULT_EXPLAIN' => 'Выберите, должны ли новые опросы с числовой оценкой сначала показывать сумму баллов или среднее арифметическое каждой опции.',
	'AP_DEFAULT_SHOW_PERCENT' => 'Показывать проценты по умолчанию',
	'AP_DEFAULT_SHOW_PERCENT_EXPLAIN' => 'Начальная видимость процентов для новых опросов с числовой оценкой.',
	'AP_SCORE_RESULT_TOTAL' => 'Сумма баллов',
	'AP_SCORE_RESULT_AVERAGE' => 'Средняя оценка',

	'AP_ACT_VOTES_HIDE'				=> 'Включить скрытие голосований',
	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Включает опцию для выбора, чтобы голосования до конца опроса были скрыты.',
	'AP_ACT_VOTERS_SHOW'			=> 'Включить отображение пользователей, которые проголосовали',
	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Включает опцию для выбора, чтобы пользователи, которые проголосовали, отображались для каждого варианта голосования.',
	'AP_ACT_VOTERS_LIMIT'			=> 'Включить ограничение голосования',
	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Включает опцию для выбора, чтобы могли голосовать только те пользователи, которые уже ответили в этой теме.',
	'AP_ACT_POLL_NO_VOTE'			=> 'Разрешить не голосовать',
	'AP_ACT_POLL_NO_VOTE_EXPLAIN'	=> 'Изменяет стандартное значение ссылки "Результаты голосования"  на "Не хочу  голосовать, посмотреть результаты", что не позволит голосовать после просмотра результатов, если "Переголосование" не выбрано.',
	'AP_ACT_SHOW_ABSTAINERS' => 'Показывать число воздержавшихся',
	'AP_ACT_SHOW_ABSTAINERS_EXPLAIN' => 'Показывает число зарегистрированных пользователей, явно решивших не голосовать. Имена отображаются только при включённом списке голосовавших и наличии разрешения.',
	'AP_ACT_VOTE_DELETE' => 'Разрешить удаление голоса',
	'AP_ACT_VOTE_DELETE_EXPLAIN' => 'Позволяет зарегистрированным пользователям удалить свой голос, пока опрос открыт и разрешает изменения.',
	'AP_ACT_SHOW_ORDERED'			=> 'Включить порядок отображения результатов',
	'AP_ACT_SHOW_ORDERED_EXPLAIN'	=> 'Включает возможность выбора результатов по порядку убывания полученных голосов (наибольшее количество голосов вверху).',
	'AP_ACT_POLL_SCORING'			=> 'Включить вес вариантов опроса',
	'AP_ACT_POLL_SCORING_EXPLAIN'	=> 'Предоставляет возможность назначать различные балы в параметрах опроса.',
	'AP_ACT_INCREMENTAL_VOTES'		=> 'Включить поэтапное голосование',
	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> 'Позволяет голосовать постепенно до тех пор, пока вы не исчерпаете доступные для опроса лимиты.',
	'AP_ACT_CLOSED_VOTING'			=> 'Включить голосование в закрытых темах',
	'AP_ACT_CLOSED_VOTING_EXPLAIN'	=> 'Позволяет  голосовать в актуальном опросе, даже если выбранная тема закрыта.',
	'AP_ACT_POLL_END'				=> 'Включить дату окончания опроса',
	'AP_ACT_POLL_END_EXPLAIN'		=> 'Позволяет указать дату/время окончания опроса (не только продолжительность в днях с момента начала).',
	'AP_ACT_POLL_NOTIFICATIONS'				=> 'Активировать уведомления опроса',
	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'		=> 'Включает уведомления, когда результаты скрытого опроса становятся видны и когда в опрос, в котором голосовал пользователь, добавляются новые варианты.',
	'AP_ACT_POLL_COLLAPSIBLE'				=> 'Включить сворачиваемые опросы',
	'AP_ACT_POLL_COLLAPSIBLE_EXPLAIN'		=> 'Показывает настройку сворачивания при создании или редактировании опроса. При установке она включается автоматически, если установлено расширение «Collapsible Forum Categories»; администраторы всегда могут изменить её.',
	'AP_SHOW_POLL_LIST_NAVBAR' => 'Показывать ссылку на опросы в панели навигации',
	'AP_SHOW_POLL_LIST_NAVBAR_EXPLAIN' => 'Добавляет в панель навигации форума ссылку на список доступных опросов.',

	'AP_DEFAULT_VOTES_CHANGE'		=> 'По умолчанию выбрано значение разрешать переголосование',
	'AP_DEFAULT_VOTES_HIDE'			=> 'По умолчанию выбрано значение скрытия голосовавших',
	'AP_DEFAULT_VOTERS_SHOW'		=> 'По умолчанию выбрано значение отображения проголосовавших',
	'AP_DEFAULT_VOTERS_LIMIT'		=> 'По умолчанию выбрано значение ограничения проголосовавших',
	'AP_DEFAULT_SHOW_ORDERED'		=> 'По умолчанию выбрано значение порядка отображения',

	'AP_ENABLE_NOTICE' => '<br /><br /><div class="phpinfo"><p><strong>Следующие шаги</strong></p><ol><li>Проверьте настройки расширения в <strong>%1$s » %2$s » %3$s</strong> и настройте функции опросов и значения по умолчанию, необходимые вашему форуму.</li><li>Проверьте разрешения <strong>%8$s</strong> и <strong>%9$s</strong> в <strong>%4$s » %5$s » %6$s</strong> (участники) и <strong>%4$s » %5$s » %7$s</strong> (модераторы). Назначайте их только ролям или группам, которым разрешено видеть личности голосовавших.</li></ol><p>Остальные функции опросов не требуют дополнительной настройки.</p></div>',
]);
