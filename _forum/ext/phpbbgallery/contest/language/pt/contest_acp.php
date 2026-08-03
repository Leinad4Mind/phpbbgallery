<?php
/**
 * phpBB Gallery Contest ACP language.
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
	'ALBUM_TYPE_CONTEST'                  => 'Concurso',
	'CONTEST_CREATION'                     => 'Permitir novos concursos',
	'CONTEST_CREATION_EXPLAIN'             => 'Permite aos administradores criar novos álbuns de concurso. Os concursos existentes permanecem ativos e editáveis quando esta opção está desativada.',
	'CONTEST_CREATION_DISABLED'            => 'A criação de novos álbuns de concurso está desativada na configuração da Galeria.',
	'ALBUM_NO_TYPE_CHANGE_TO_CONTEST'      => 'Um Álbum de Não-Concurso não pode ser transformado em um Álbum de Concurso.',
	'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE'    => 'Não é possível alterar o tipo de álbum devido à existência de um concurso neste álbum.',
	'CONTEST_DATE_EXPLAIN'                 => 'Tens de fornecer uma data e hora no formato AAAA-MM-DD HH:MM.',
	'CONTEST_END'                          => 'Término da Classificação e/ou Votação',
	'CONTEST_END_BEFORE_RATING'            => 'O fim do concurso não pode ser antes do início da votação do concurso.',
	'CONTEST_END_BEFORE_START'             => 'O concurso deverá terminar após o seu início.',
	'CONTEST_END_EXPLAIN'                  => 'Fim da classificação/votação (exibição dos resultados do concurso).',
	'CONTEST_END_INVALID'                  => 'Fim do concurso inválido (%s). Por favor, insere a data no formato AAAA-MM-DD HH:MM.',
	'CONTEST_RATING'                       => 'Início da votação',
	'CONTEST_RATING_BEFORE_START'          => 'O início da votação do concurso não pode ser antes do início do concurso.',
	'CONTEST_RATING_EXPLAIN'               => 'Após o "Início da votação", os utilizadores não podem mais fazer upload de imagens.',
	'CONTEST_RATING_INVALID'               => 'Votação do concurso inválida (%s). Por favor, insere a data no formato AAAA-MM-DD HH:MM.',
	'CONTEST_SETTINGS'                     => 'Configurações do concurso',
	'CONTEST_START'                        => 'Início da Classificação/Votação',
	'CONTEST_START_EXPLAIN'                => 'A partir deste momento já não se permite adicionar qualquer imagem. A partir de agora e de acordo com as permissões fornecidas, poderá efetuar um comentário a quem desejar.',
	'CONTEST_START_INVALID'                => 'Início do concurso inválido (%s). Por favor, insere a data no formato AAAA-MM-DD HH:MM.',
]);
