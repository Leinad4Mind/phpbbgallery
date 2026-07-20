<?php

/**
 * @package phpbbgallery/core for phpBB.
 * phpBB Gallery - ACP Core Extension
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ALBUM_ALREADY_EXISTS'           => 'Já existe um álbum que tem esse nome na Galeria.',
	'COLLIDING_ALBUM_NAME'           => 'Existem alguns conflitos de nomes (mais do que um álbum com o mesmo nome). Por favor renomeie um dos álbuns.',
	'COLLIDING_PREFIX'               => 'Foi encontrado um prefixo em conflito (%s).',
	'CREATE_MODULES'                 => 'Criar módulos',
	'CREATE_TABLES'                  => 'Criar tabelas de base de dados',
	'DB_NOT_SUPPORTED'               => 'O tipo da sua base de dados ainda não é suportado pelo nosso script de instalação.',
	'FILES_OUTDATED'                 => 'Arquivos desatualizados',
	'FILES_OUTDATED_EXPLAIN'         => '<strong>Desatualizado</strong> - De modo a evitar tentativas de intrusão (hacking), por favor remova os seguintes arquivos.',
	'FOUND_INSTALL'                  => 'Instalação dupla',
	'FOUND_INSTALL_EXPLAIN'          => '<strong>Instalação dupla</strong> - Foi encontrada uma instalação da galeria! Se continuar, os dados existentes serão sobrescritos. Todos os álbuns, imagens e comentários serão excluídos! <strong>Por este motivo é recomendável uma %1$satualização%2$s.</strong>',
	'FOUND_VERSION'                  => 'Foi encontrada a seguinte versão',
	'FOUNDER_CHECK'                  => 'Você é "Fundador" deste fórum',
	'FOUNDER_NEEDED'                 => 'Precisa ser um "Fundador" do fórum!',
	'INSTALL_CONGRATS_EXPLAIN'       => 'Instalou com sucesso o phpBB Gallery v%s.<br/><br/><strong>Por favor elimine, mova ou renomeie a pasta install antes de utilizar o fórum.</strong>',
	'INSTALL_INTRO_BODY'             => 'Com esta opção, é possível instalar a phpBB Gallery no seu fórum.',
	'GOTO_GALLERY'                   => 'Ir para a phpBB Galeria',
	'GOTO_INDEX'                     => 'Ir para o Índice do Fórum',
	'MISSING_CONSTANTS'              => 'Antes de poder correr o script de instalação, precisa de enviar (upload) os seus arquivos editados.',
	'MODULES_CREATE_PARENT'          => 'Criar módulo principal',
	'MODULES_PARENT_SELECT'          => 'Escolha o módulo principal',
	'MODULES_SELECT_4ACP'            => 'Escolha o módulo principal para o "Painel de Administração (ACP)"',
	'MODULES_SELECT_4LOG'            => 'Escolha o módulo principal para o "Registro (Log) da Galeria"',
	'MODULES_SELECT_4MCP'            => 'Escolha o módulo principal para o "Painel de Moderação (MCP)"',
	'MODULES_SELECT_4UCP'            => 'Escolha o módulo principal para o "Painel de Usuário (UCP)"',
	'MODULES_SELECT_NONE'            => 'sem módulo pai',
	'NO_INSTALL_FOUND'               => 'Não foi encontrada qualquer instalação!',
	'OPTIONAL_EXIFDATA'              => 'A função "exif_read_data" existe',
	'OPTIONAL_EXIFDATA_EXP'          => 'O módulo Exif não está carregado ou não se encontra instalado.',
	'OPTIONAL_EXIFDATA_EXPLAIN'      => 'Se a função existir, os dados exif das imagens serão mostrados.',
	'OPTIONAL_IMAGEROTATE'           => 'A função "imagerotate" existe',
	'OPTIONAL_IMAGEROTATE_EXP'       => 'Aconselhamos a atualização da sua versão GD que neste momento é " %s ".',
	'OPTIONAL_IMAGEROTATE_EXPLAIN'   => 'Se a função existir, poderá rodar imagens durante o upload e edição.',
	'PAYPAL_DEV_SUPPORT'             => '</p><div class="errorbox"><h3>Notas do Autor</h3><p>Criar e atualizar este MOD exigiu/exige muito esforço...</p></div><p>',
	'PHP_SETTINGS'                   => 'Configurações PHP',
	'PHP_SETTINGS_EXP'               => 'Estas configurações do PHP são necessárias para instalar e correr a galeria.',
	'PHP_SETTINGS_OPTIONAL'          => 'Configurações PHP Opcionais',
	'PHP_SETTINGS_OPTIONAL_EXP'      => 'Estas configurações <strong>NÃO</strong> são estritamente necessárias.',
	'REQ_GD_LIBRARY'                 => 'A biblioteca GD está instalada',
	'REQ_PHP_VERSION'                => 'Versão do php >= %s',
	'REQ_PHPBB_VERSION'              => 'Versão do phpBB >= %s',
	'REQUIREMENTS_EXPLAIN'           => 'Antes de prosseguir com a instalação...',
	'STAGE_ADVANCED_EXPLAIN'         => 'Por favor selecione o módulo principal. Em condições normais não deverá efetuar qualquer alteração.',
	'STAGE_COPY_TABLE'               => 'Copiar tabelas da Base de Dados',
	'STAGE_COPY_TABLE_EXPLAIN'       => 'As tabelas têm os mesmos nomes no TS Gallery e no phpBB Gallery...',
	'STAGE_CREATE_TABLE_EXPLAIN'     => 'As tabelas de Base de Dados usadas pela phpBB Galeria foram criadas.',
	'STAGE_DELETE_TABLES'            => 'Limpar Base de Dados',
	'STAGE_DELETE_TABLES_EXPLAIN'    => 'Os conteúdos da Base de Dados referentes à phpBB Galeria foram excluídos.',
	'SUPPORT_BODY'                   => 'Poderá aceder a suporte sobre a Galeria...</p>',
	'TABLE_ALBUM'                    => 'tabela incluindo as imagens',
	'TABLE_ALBUM_CAT'                => 'tabela incluindo os álbuns',
	'TABLE_ALBUM_COMMENT'            => 'tabela com os comentários',
	'TABLE_ALBUM_CONFIG'             => 'tabela com as configurações',
	'TABLE_ALBUM_RATE'               => 'tabela com as votações (rates)',
	'TABLE_EXISTS'                   => 'existe',
	'TABLE_MISSING'                  => 'em falta',
	'TABLE_PREFIX_EXPLAIN'           => 'Prefixo da instalação phpBB2',
	'UNINSTALL_INTRO'                => 'Bem-vindo ao sistema de Desinstalação',
	'UNINSTALL_INTRO_BODY'           => 'Com esta opção pode desinstalar a phpBB Gallery.<br /><br /><strong>Aviso: Todos os álbuns, imagens e comentários serão excluídos de forma irreversível!</strong>',
	'UNINSTALL_REQUIREMENTS'         => 'Requisitos',
	'UNINSTALL_REQUIREMENTS_EXPLAIN' => 'Antes de prosseguir a desinstalação far-se-ão testes.',
	'UNINSTALL_START'                => 'Desinstalar',
	'UNINSTALL_FINISHED'             => 'Desinstalação quase concluída',
	'UNINSTALL_FINISHED_EXPLAIN'     => 'Desinstalou com sucesso a galeria phpBB.',
	'UPDATE_INSTALLATION_EXPLAIN'    => 'Aqui poderá Atualizar a sua Galeria phpBB.',
	'VERSION_NOT_SUPPORTED'          => 'Lamentamos, mas as suas atualizações anteriores à versão 1.0.6 não são suportadas por este sistema.',
	'GALLERY_SUB_EXT_UNINSTALL'      => [
		1 => 'Tem de desinstalar a extensão: <br /><strong>%s</strong><br /> antes de desinstalar a extensão principal.',
		2 => 'Tem de desinstalar as extensões: <br /><strong>%s</strong><br /> antes de desinstalar a extensão principal.',
	],
]);
