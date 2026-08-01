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
	'ACP_BBPOINTSIMAGES_SETTINGS_EXPLAIN' => 'Configure as recompensas pela publicação na Galeria e o custo de acesso aos arquivos originais.',
	'ACP_BBPOINTSIMAGES_GLOBAL' => 'Configurações globais',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD' => 'Recompensa por imagem aprovada',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD_EXPLAIN' => 'Pontos concedidos uma única vez ao autor final quando a imagem é aprovada. Defina 0 para desativar as recompensas.',
	'ACP_BBPOINTSIMAGES_SOURCE_COST' => 'Custo do arquivo original',
	'ACP_BBPOINTSIMAGES_SOURCE_COST_EXPLAIN' => 'Pontos necessários para comprar o acesso ao arquivo original. Defina 0 para permitir acesso gratuito.',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES' => 'Substituições por álbum',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Cada valor substitui, de forma independente, o valor do ancestral mais próximo. Use -1 para herdar.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Álbum',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Use -1 para herdar o valor do ancestral configurado mais próximo ou da configuração global.',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'Não há álbuns disponíveis na Galeria.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'As configurações do BBPoints nas imagens foram salvas.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Recompensas de imagens antigas',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Analisa imagens antigas aprovadas e concede a recompensa de publicação configurada. Recompensas existentes e arquivos exatamente duplicados são ignorados.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Sincronizar recompensas antigas',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => 'Tem certeza de que deseja recompensar todas as imagens antigas elegíveis usando as regras atuais dos álbuns?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'A sincronização continua. %1$d imagens analisadas e %2$d recompensas concedidas até agora.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'A sincronização terminou. %1$d imagens foram analisadas e %2$d recompensas foram concedidas.',
]);
