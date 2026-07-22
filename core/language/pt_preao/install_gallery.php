<?php

/**
 * @package phpbbgallery/core for phpBB.
 * phpBB Gallery - ACP Core Extension
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'BBCODES_NEEDS_REPARSE' => 'O BBCode precisa de ser reconstruído.',
	'CAT_CONVERT' => 'Converter phpBB2',
	'CAT_CONVERT_TS' => 'Converter TS Gallery',
	'CAT_UNINSTALL' => 'Desinstalar phpBB Gallery',
	'CHECK_TABLES' => 'Verificar tabelas',
	'CHECK_TABLES_EXPLAIN' => 'As tabelas seguintes têm de existir para que possam ser convertidas.',
	'CONVERT_SMARTOR_INTRO' => 'Conversor de “Album-MOD” por Smartor para “phpBB Gallery”',
	'CONVERT_SMARTOR_INTRO_BODY' => 'Este conversor permite converter os álbuns, imagens, classificações e comentários do <a href="http://www.phpbb.com/community/viewtopic.php?f=16&t=74772">Album-MOD</a> por Smartor (testado com a versão 2.0.56) e do <a href="http://www.phpbbhacks.com/download/5028">Full Album Pack</a> (testado com a versão 1.4.1) para o phpBB Gallery.<br /><br /><strong>Nota:</strong> As <strong>permissões</strong> <strong>não serão copiadas</strong>.',
	'CONVERT_TS_INTRO' => 'Conversor de “TS Gallery” para “phpBB Gallery”',
	'CONVERT_TS_INTRO_BODY' => 'Este conversor permite converter os álbuns, imagens, classificações e comentários do <a href="http://www.phpbb.com/community/viewtopic.php?f=70&t=610509">TS Gallery</a> (testado com a versão 0.2.1) para o phpBB Gallery.<br /><br /><strong>Nota:</strong> As <strong>permissões</strong> <strong>não serão copiadas</strong>.',
	'CONVERT_COMPLETE_EXPLAIN' => 'A conversão da sua galeria para o phpBB Gallery v%s foi concluída com sucesso.<br />Confirme que as definições foram transferidas correctamente antes de activar o fórum, eliminando o directório install.<br /><br /><strong>Tenha em atenção que as permissões não foram copiadas.</strong><br /><br />Também deverá limpar da base de dados as entradas antigas cujas imagens estejam em falta. Pode fazê-lo em “.MODs &gt; phpBB Gallery &gt; Limpar galeria”.',
	'CONVERTED_ALBUMS' => 'Os álbuns foram copiados com sucesso.',
	'CONVERTED_COMMENTS' => 'Os comentários foram copiados com sucesso.',
	'CONVERTED_IMAGES' => 'As imagens foram copiadas com sucesso.',
	'CONVERTED_MISC' => 'Foram convertidos os elementos diversos.',
	'CONVERTED_PERSONALS' => 'Os álbuns pessoais foram copiados com sucesso.',
	'CONVERTED_RATES' => 'As classificações foram copiadas com sucesso.',
	'CONVERTED_RESYNC_ALBUMS' => 'Ressincronizar as estatísticas dos álbuns.',
	'CONVERTED_RESYNC_COMMENTS' => 'Ressincronizar os comentários.',
	'CONVERTED_RESYNC_COUNTS' => 'Ressincronizar os contadores de imagens.',
	'CONVERTED_RESYNC_RATES' => 'Ressincronizar as classificações.',
	'FILE_DELETE_FAIL' => 'Não foi possível eliminar o ficheiro; terá de o eliminar manualmente.',
	'FILE_STILL_EXISTS' => 'O ficheiro ainda existe.',
	'FILES_REQUIRED_EXPLAIN' => '<strong>Obrigatório</strong> — Para funcionar correctamente, o phpBB Gallery precisa de aceder ou escrever em determinados ficheiros ou directórios. Se vir “Sem permissão de escrita”, altere as permissões do ficheiro ou directório para permitir que o phpBB escreva nele.',
	'FILES_DELETE_OUTDATED' => 'Eliminar ficheiros desactualizados',
	'FILES_DELETE_OUTDATED_EXPLAIN' => 'Ao eliminar os ficheiros, estes serão removidos definitivamente e não poderão ser restaurados.<br /><br />Tenha em atenção:<br />Se tiver outros estilos e idiomas instalados, terá de eliminar os ficheiros manualmente.',
	'FILES_OUTDATED' => 'Ficheiros desatualizados',
	'FILES_OUTDATED_EXPLAIN' => '<strong>Desatualizado</strong> - De modo a evitar tentativas de intrusão (hacking), por favor remova os seguintes ficheiros.',
	'FOUND_INSTALL' => 'Instalação dupla',
	'FOUND_INSTALL_EXPLAIN' => '<strong>Instalação dupla</strong> - Foi encontrada uma instalação da galeria! Se continuar, os dados existentes serão sobrescritos. Todos os álbuns, imagens e comentários serão eliminados! <strong>Por este motivo é recomendável uma %1$satualização%2$s.</strong>',
	'FOUND_VERSION' => 'Foi encontrada a seguinte versão',
	'FOUNDER_CHECK' => 'Você é "Fundador" deste fórum',
	'FOUNDER_NEEDED' => 'Precisa ser um "Fundador" do fórum!',
	'INSTALL_CONGRATS_EXPLAIN' => 'Instalou com sucesso o phpBB Gallery v%s.<br/><br/><strong>Por favor elimine, mova ou renomeie a pasta install antes de utilizar o fórum.</strong>',
	'INSTALL_INTRO_BODY' => 'Com esta opção, é possível instalar a phpBB Gallery no seu fórum.',
	'GOTO_GALLERY' => 'Ir para a phpBB Galeria',
	'GOTO_INDEX' => 'Ir para o Índice do Fórum',
	'MISSING_CONSTANTS' => 'Antes de poder correr o script de instalação, precisa de enviar (upload) os seus ficheiros editados.',
	'MODULES_CREATE_PARENT' => 'Criar módulo principal',
	'MODULES_PARENT_SELECT' => 'Escolha o módulo principal',
	'MODULES_SELECT_4ACP' => 'Escolha o módulo principal para o "Painel de Administração (ACP)"',
	'MODULES_SELECT_4LOG' => 'Escolha o módulo principal para o "Registo (Log) da Galeria"',
	'MODULES_SELECT_4MCP' => 'Escolha o módulo principal para o "Painel de Moderação (MCP)"',
	'MODULES_SELECT_4UCP' => 'Escolha o módulo principal para o "Painel de Utilizador (UCP)"',
	'MODULES_SELECT_NONE' => 'sem módulo pai',
	'NO_INSTALL_FOUND' => 'Não foi encontrada qualquer instalação!',
	'OPTIONAL_EXIFDATA' => 'A função "exif_read_data" existe',
	'OPTIONAL_EXIFDATA_EXP' => 'O módulo Exif não está carregado ou não se encontra instalado.',
	'OPTIONAL_EXIFDATA_EXPLAIN' => 'Se a função existir, os dados exif das imagens serão mostrados.',
	'OPTIONAL_IMAGEROTATE' => 'A função "imagerotate" existe',
	'OPTIONAL_IMAGEROTATE_EXP' => 'Aconselhamos a actualização da sua versão GD que neste momento é " %s ".',
	'OPTIONAL_IMAGEROTATE_EXPLAIN' => 'Se a função existir, poderá rodar imagens durante o upload e edição.',
	'PAYPAL_DEV_SUPPORT' => '</p><div class="errorbox"><h3>Notas do Autor</h3><p>Criar e actualizar este MOD exigiu/exige muito esforço...</p></div><p>',
	'PHP_SETTINGS' => 'Configurações PHP',
	'PHP_SETTINGS_EXP' => 'Estas configurações do PHP são necessárias para instalar e correr a galeria.',
	'PHP_SETTINGS_OPTIONAL' => 'Configurações PHP Opcionais',
	'PHP_SETTINGS_OPTIONAL_EXP' => 'Estas configurações <strong>NÃO</strong> são estritamente necessárias.',
	'REQ_GD_LIBRARY' => 'A biblioteca GD está instalada',
	'REQ_PHP_VERSION' => 'Versão do php >= %s',
	'REQ_PHPBB_VERSION' => 'Versão do phpBB >= %s',
	'REQUIREMENTS_EXPLAIN' => 'Antes de prosseguir com a instalação...',
	'STAGE_ADVANCED_EXPLAIN' => 'Por favor selecione o módulo principal. Em condições normais não deverá efectuar qualquer alteração.',
	'STAGE_COPY_TABLE' => 'Copiar tabelas da Base de Dados',
	'STAGE_COPY_TABLE_EXPLAIN' => 'As tabelas têm os mesmos nomes no TS Gallery e no phpBB Gallery...',
	'STAGE_CREATE_TABLE_EXPLAIN' => 'As tabelas de Base de Dados usadas pela phpBB Galeria foram criadas.',
	'STAGE_DELETE_TABLES' => 'Limpar Base de Dados',
	'STAGE_DELETE_TABLES_EXPLAIN' => 'Os conteúdos da Base de Dados referentes à phpBB Galeria foram eliminados.',
	'SUPPORT_BODY' => 'Poderá aceder a suporte sobre a Galeria...</p>',
	'TABLE_ALBUM' => 'tabela incluindo as imagens',
	'TABLE_ALBUM_CAT' => 'tabela incluindo os álbuns',
	'TABLE_ALBUM_COMMENT' => 'tabela com os comentários',
	'TABLE_ALBUM_CONFIG' => 'tabela com as configurações',
	'TABLE_ALBUM_RATE' => 'tabela com as votações (rates)',
	'TABLE_EXISTS' => 'existe',
	'TABLE_MISSING' => 'em falta',
	'TABLE_PREFIX_EXPLAIN' => 'Prefixo da instalação phpBB2',
	'UNINSTALL_INTRO' => 'Bem-vindo ao sistema de Desinstalação',
	'UNINSTALL_INTRO_BODY' => 'Com esta opção pode desinstalar a phpBB Gallery.<br /><br /><strong>Aviso: Todos os álbuns, imagens e comentários serão eliminados de forma irreversível!</strong>',
	'UNINSTALL_REQUIREMENTS' => 'Requisitos',
	'UNINSTALL_REQUIREMENTS_EXPLAIN' => 'Antes de prosseguir a desinstalação far-se-ão testes.',
	'UNINSTALL_START' => 'Desinstalar',
	'UNINSTALL_FINISHED' => 'Desinstalação quase concluída',
	'UNINSTALL_FINISHED_EXPLAIN' => 'Desinstalou com sucesso a galeria phpBB.',
	'UPDATE_INSTALLATION_EXPLAIN' => 'Aqui poderá Actualizar a sua Galeria phpBB.',
	'VERSION_NOT_SUPPORTED' => 'Lamentamos, mas as suas actualizações anteriores à versão 1.0.6 não são suportadas por este sistema.',
	'GALLERY_SUB_EXT_UNINSTALL' => [
		1 => 'Tem de desinstalar a extensão: <br /><strong>%s</strong><br /> antes de desinstalar a extensão principal.',
		2 => 'Tem de desinstalar as extensões: <br /><strong>%s</strong><br /> antes de desinstalar a extensão principal.',
	],
]);
