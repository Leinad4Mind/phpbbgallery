<?php
/**
 * phpBB Gallery Contest frontend language.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'CONTEST_RATING_HIDDEN' => 'скрыто',
	'CONTEST_RESULT_HIDDEN' => 'Оценка этого фото скрыта до завершения конкурса %s.',
	'CONTEST_COMMENTS_STARTS' => 'Комментарии к снимкам в этом конкурсе разрешены с %s.',
	'CONTEST_ENDED'           => 'Конкурс завершился %s.',
	'CONTEST_ENDS'            => 'Конкурс завершится %s.',
	'CONTEST_RATING_STARTED'  => 'Голосование для этого конкурса началось %s.',
	'CONTEST_RATING_STARTS'   => 'Голосование для этого конкурса начнётся %s.',
	'CONTEST_RESULT'          => 'Конкурс',
	'CONTEST_RESULT_1'        => 'Победитель',
	'CONTEST_RESULT_2'        => 'Второй',
	'CONTEST_RESULT_3'        => 'Третий',
	'CONTEST_STARTED'         => 'Конкурс начался %s.',
	'CONTEST_STARTS'          => 'Конкурс начнётся %s.',
	'CONTEST_USERNAME'        => '<strong>Конкурс</strong>',
	'CONTEST_IMAGE_DESC'      => '<strong>Конкурс</strong> » Описание фотографии скрыто до окончания конкурса %s.',
	'CONTEST_WINNERS_OF'      => 'Победители конкурса «%s»',
	'SEARCH_CONTEST'                    => 'Победители конкурса',
	'VIEW_SEARCH_CONTESTS'  => 'Победители конкурсов',
	'CONTEST_STATUS' => 'Состояние конкурса',
	'CONTEST_PHASE_UPCOMING' => 'Запланирован',
	'CONTEST_PHASE_UPCOMING_EXPLAIN' => 'Приём изображений начнётся %s.',
	'CONTEST_PHASE_UPLOAD' => 'Приём открыт',
	'CONTEST_PHASE_UPLOAD_EXPLAIN' => 'Изображения можно отправлять до %s. Голосование и комментарии пока недоступны.',
	'CONTEST_PHASE_RATING' => 'Голосование открыто',
	'CONTEST_PHASE_RATING_EXPLAIN' => 'Приём изображений закрыт. Голосование доступно до %s; комментарии откроются после него.',
	'CONTEST_PHASE_FINISHED' => 'Завершён',
	'CONTEST_PHASE_FINISHED_EXPLAIN' => 'Конкурс завершён. Результаты и комментарии теперь доступны.',
	'CONTEST_SCHEDULE_TIMEZONE' => 'Даты показаны в вашем часовом поясе: %s.',
]);
