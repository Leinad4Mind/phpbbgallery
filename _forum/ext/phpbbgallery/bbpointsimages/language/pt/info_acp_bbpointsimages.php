<?php
/**
 * phpBB Gallery - BBPoints Images
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'BBPOINTSIMAGES_DEPENDENCIES_MISSING' => 'As extensões necessárias não estão ativadas: %s.',
	'ACP_BBPOINTSIMAGES_SETTINGS' => 'BBPoints nas imagens',
	'ACP_BBPOINTSIMAGES_SETTINGS_EXPLAIN' => 'Configura as recompensas pela publicação na Galeria e o custo de acesso aos ficheiros originais.',
	'ACP_BBPOINTSIMAGES_GLOBAL' => 'Definições globais',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD' => 'Recompensa por imagem aprovada',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD_EXPLAIN' => 'Pontos atribuídos uma única vez ao autor final quando a imagem é aprovada. Define 0 para desativar as recompensas.',
	'ACP_BBPOINTSIMAGES_SOURCE_COST' => 'Custo do ficheiro original',
	'ACP_BBPOINTSIMAGES_SOURCE_COST_EXPLAIN' => 'Pontos necessários para comprar o acesso ao ficheiro original. Define 0 para permitir o acesso gratuito.',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES' => 'Substituições por álbum',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Cada valor substitui, de forma independente, o valor do antecessor mais próximo. Usa -1 para herdar.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Álbum',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Usa -1 para herdar o valor do antecessor configurado mais próximo ou da definição global.',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'Não existem álbuns disponíveis na Galeria.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'As definições do BBPoints nas imagens foram guardadas.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Recompensas de imagens antigas',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Analisa as imagens antigas aprovadas e atribui a recompensa de publicação configurada. As recompensas existentes e os ficheiros exatamente duplicados são ignorados.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Sincronizar recompensas antigas',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => 'Tens a certeza de que pretendes recompensar todas as imagens antigas elegíveis com as regras atuais dos álbuns?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'A sincronização continua. Foram analisadas %1$d imagens e atribuídas %2$d recompensas até ao momento.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'A sincronização terminou. Foram analisadas %1$d imagens e atribuídas %2$d recompensas.',
	'BBPOINTSIMAGES_SOURCE_LOGIN' => 'Tens de iniciar sessão para comprar este ficheiro de imagem original.',
	'BBPOINTSIMAGES_SOURCE_PURCHASE_CONFIRM' => 'Transferir este ficheiro de imagem original custa %1$d pontos. Pretendes continuar?',
	'BBPOINTSIMAGES_INSUFFICIENT_FUNDS' => 'Tens %1$d pontos, mas este ficheiro de imagem original requer %2$d pontos.',
	'BBPOINTSIMAGES_SOURCE_UNAVAILABLE' => 'Não é possível comprar o ficheiro de imagem original neste momento.',
	'BBPOINTSIMAGES_DOWNLOADS' => 'Transferências do original',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS' => 'Permitir atribuir colaboradores',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Permite que os autores e editores das imagens indiquem colaboradores. Os colaboradores existentes mantêm a atribuição e a sua parte das transferências pagas quando esta opção é desativada.',
	'BBPOINTSIMAGES_CONTRIBUTORS' => 'Colaboradores',
	'BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Introduz um nome de utilizador registado por linha, até ao máximo de %1$d. O autor da imagem é excluído automaticamente.',
	'BBPOINTSIMAGES_CONTRIBUTORS_UNKNOWN' => 'Não foi possível encontrar estes colaboradores ou estão inativos: %1$s.',
	'BBPOINTSIMAGES_CONTRIBUTORS_TOO_MANY' => 'Uma imagem não pode ter mais de %1$d colaboradores.',
]);
