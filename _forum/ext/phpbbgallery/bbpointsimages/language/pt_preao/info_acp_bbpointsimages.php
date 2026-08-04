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
	'BBPOINTSIMAGES_DEPENDENCIES_MISSING' => 'As extensões necessárias não estão activadas: %s.',
	'ACP_BBPOINTSIMAGES_SETTINGS' => 'BBPoints nas imagens',
	'ACP_BBPOINTSIMAGES_SETTINGS_EXPLAIN' => 'Configura as recompensas pela publicação na Galeria e o custo de acesso aos ficheiros originais.',
	'ACP_BBPOINTSIMAGES_GLOBAL' => 'Definições globais',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD' => 'Recompensa por imagem aprovada',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD_EXPLAIN' => 'Pontos atribuídos uma única vez ao autor final quando a imagem é aprovada. Define 0 para desactivar as recompensas.',
	'ACP_BBPOINTSIMAGES_SOURCE_COST' => 'Custo do ficheiro original',
	'ACP_BBPOINTSIMAGES_SOURCE_COST_EXPLAIN' => 'Pontos necessários para comprar o acesso ao ficheiro original. Define 0 para permitir o acesso gratuito.',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES' => 'Substituições por álbum',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Esta visão geral, apenas de leitura, segue a hierarquia da Galeria. Edita um álbum para alterar os valores definidos directamente; os valores a negrito são os que estão actualmente em vigor.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Álbum',
	'ACP_BBPOINTSIMAGES_ALBUM_SETTINGS' => 'BBPoints Images',
	'ACP_BBPOINTSIMAGES_ALBUM_SETTINGS_EXPLAIN' => 'Usa -1 para cada valor numérico herdar, de forma independente, do antecessor configurado mais próximo ou da definição global.',
	'ACP_BBPOINTSIMAGES_INHERIT' => 'Herdar',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Usa -1 para herdar o valor do antecessor configurado mais próximo ou da definição global.',
	'ACP_BBPOINTSIMAGES_EFFECTIVE_VALUE' => 'Valor efectivo: %1$d.',
	'ACP_BBPOINTSIMAGES_EFFECTIVE_TOGGLE' => 'Definição efectiva: %1$s.',
	'ACP_BBPOINTSIMAGES_INHERITED' => 'Herdado',
	'ACP_BBPOINTSIMAGES_DIRECT_VALUE' => 'Valor definido: %1$d',
	'ACP_BBPOINTSIMAGES_DIRECT_SETTING' => 'Definição directa',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'Não existem álbuns disponíveis na Galeria.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'As definições do BBPoints nas imagens foram guardadas.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Recompensas de imagens antigas',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Analisa as imagens antigas aprovadas e atribui a recompensa de publicação configurada. As recompensas existentes e os ficheiros exactamente duplicados são ignorados.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Sincronizar recompensas antigas',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => 'Tens a certeza de que pretendes recompensar todas as imagens antigas elegíveis com as regras actuais dos álbuns?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'A sincronização continua. Foram analisadas %1$d imagens e atribuídas %2$d recompensas até ao momento.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'A sincronização terminou. Foram analisadas %1$d imagens e atribuídas %2$d recompensas.',
	'BBPOINTSIMAGES_SOURCE_LOGIN' => 'Tens de iniciar sessão para comprar este ficheiro de imagem original.',
	'BBPOINTSIMAGES_SOURCE_PURCHASE_CONFIRM' => 'Transferir este ficheiro de imagem original custa %1$d pontos. Pretendes continuar?',
	'BBPOINTSIMAGES_INSUFFICIENT_FUNDS' => 'Tens %1$d pontos, mas este ficheiro de imagem original requer %2$d pontos.',
	'BBPOINTSIMAGES_SOURCE_UNAVAILABLE' => 'Não é possível comprar o ficheiro de imagem original neste momento.',
	'BBPOINTSIMAGES_DOWNLOADS' => 'Transferências do original',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS' => 'Permitir atribuir colaboradores',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Permite que os autores e editores das imagens indiquem colaboradores. Os colaboradores existentes mantêm a atribuição e a sua parte das transferências pagas quando esta opção é desactivada.',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK' => 'Colaboradores em todos os álbuns',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_EXPLAIN' => 'Define uma escolha explícita em todos os álbuns públicos ou repõe todos para herdarem a definição global. As substituições de recompensa e custo são preservadas.',
	'ACP_BBPOINTSIMAGES_INHERIT_GLOBAL' => 'Fazer todos os álbuns herdar',
	'ACP_BBPOINTSIMAGES_ENABLE_ALL' => 'Activar em todos os álbuns',
	'ACP_BBPOINTSIMAGES_DISABLE_ALL' => 'Desactivar em todos os álbuns',
	'ACP_BBPOINTSIMAGES_APPLY_ALL' => 'Aplicar a todos os álbuns',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_CONFIRM' => 'Tens a certeza de que queres alterar a atribuição de colaboradores em todos os álbuns públicos da Galeria?',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_SAVED' => 'A atribuição de colaboradores foi actualizada em todos os álbuns públicos da Galeria.',
	'BBPOINTSIMAGES_CONTRIBUTORS' => 'Colaboradores',
	'BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Introduz um nome de utilizador registado por linha, até ao máximo de %1$d. O autor da imagem é excluído automaticamente.',
	'BBPOINTSIMAGES_CONTRIBUTORS_UNKNOWN' => 'Não foi possível encontrar estes colaboradores ou estão inactivos: %1$s.',
	'BBPOINTSIMAGES_CONTRIBUTORS_TOO_MANY' => 'Uma imagem não pode ter mais de %1$d colaboradores.',
	'NOTIFICATION_TYPE_BBPOINTSIMAGES_REWARD' => 'Recompensas de imagens da Galeria',
	'NOTIFICATION_BBPOINTSIMAGES_REWARD' => 'Recebeste %1$d pontos pela publicação da imagem <strong>%2$s</strong>.',
	'NOTIFICATION_TYPE_BBPOINTSIMAGES_SOURCE_PURCHASE' => 'Vendas de originais da Galeria',
	'NOTIFICATION_BBPOINTSIMAGES_SOURCE_PURCHASE' => '%1$s comprou o ficheiro original de <strong>%3$s</strong>; recebeste %2$d pontos.',
]);
