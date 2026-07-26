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
	'BBCODES_NEEDS_REPARSE'          => 'O BBCode precisa ser reconstruído.',
	'CAT_CONVERT'                    => 'Converter phpBB2',
	'CAT_CONVERT_TS'                 => 'Converter TS Gallery',
	'CAT_UNINSTALL'                  => 'Desinstalar phpBB Gallery',
	'CHECK_TABLES'                   => 'Verificar tabelas',
	'CHECK_TABLES_EXPLAIN'           => 'As tabelas a seguir precisam existir para que possam ser convertidas.',
	'CONVERT_SMARTOR_INTRO'          => 'Conversor de “Album-MOD” por Smartor para “phpBB Gallery”',
	'CONVERT_SMARTOR_INTRO_BODY'     => 'Este conversor permite converter os álbuns, imagens, avaliações e comentários do <a href="http://www.phpbb.com/community/viewtopic.php?f=16&t=74772">Album-MOD</a> por Smartor (testado com a versão 2.0.56) e do <a href="http://www.phpbbhacks.com/download/5028">Full Album Pack</a> (testado com a versão 1.4.1) para o phpBB Gallery.<br /><br /><strong>Nota:</strong> As <strong>permissões</strong> <strong>não serão copiadas</strong>.',
	'CONVERT_TS_INTRO'               => 'Conversor de “TS Gallery” para “phpBB Gallery”',
	'CONVERT_TS_INTRO_BODY'          => 'Este conversor permite converter os álbuns, imagens, avaliações e comentários do <a href="http://www.phpbb.com/community/viewtopic.php?f=70&t=610509">TS Gallery</a> (testado com a versão 0.2.1) para o phpBB Gallery.<br /><br /><strong>Nota:</strong> As <strong>permissões</strong> <strong>não serão copiadas</strong>.',
	'CONVERT_COMPLETE_EXPLAIN'       => 'A conversão da sua galeria para o phpBB Gallery v%s foi concluída com sucesso.<br />Confirme se as configurações foram transferidas corretamente antes de ativar o fórum e exclua o diretório install.<br /><br /><strong>As permissões não foram copiadas.</strong><br /><br />Remova também do banco de dados as entradas antigas cujas imagens estejam ausentes. Você pode fazer isso em “.MODs &gt; phpBB Gallery &gt; Limpar galeria”.',
	'CONVERTED_ALBUMS'               => 'Os álbuns foram copiados com sucesso.',
	'CONVERTED_COMMENTS'             => 'Os comentários foram copiados com sucesso.',
	'CONVERTED_IMAGES'               => 'As imagens foram copiadas com sucesso.',
	'CONVERTED_MISC'                 => 'Foram convertidos os elementos diversos.',
	'CONVERTED_PERSONALS'            => 'Os álbuns pessoais foram copiados com sucesso.',
	'CONVERTED_RATES'                => 'As avaliações foram copiadas com sucesso.',
	'CONVERTED_RESYNC_ALBUMS'        => 'Ressincronizar as estatísticas dos álbuns.',
	'CONVERTED_RESYNC_COMMENTS'      => 'Ressincronizar os comentários.',
	'CONVERTED_RESYNC_COUNTS'        => 'Ressincronizar os contadores de imagens.',
	'CONVERTED_RESYNC_RATES'         => 'Ressincronizar as avaliações.',
	'FILE_DELETE_FAIL'               => 'Não foi possível excluir o arquivo; você precisará excluí-lo manualmente.',
	'FILE_STILL_EXISTS'              => 'O arquivo ainda existe.',
	'FILES_REQUIRED_EXPLAIN'         => '<strong>Obrigatório</strong> — Para funcionar corretamente, o phpBB Gallery precisa acessar ou gravar determinados arquivos ou diretórios. Se aparecer “Sem permissão de gravação”, altere as permissões para permitir que o phpBB grave no local.',
	'FILES_DELETE_OUTDATED'          => 'Excluir arquivos desatualizados',
	'FILES_DELETE_OUTDATED_EXPLAIN'  => 'Ao excluir os arquivos, eles serão removidos permanentemente e não poderão ser restaurados.<br /><br />Se houver outros estilos e idiomas instalados, você precisará excluir os arquivos manualmente.',
	'FILES_OUTDATED'                 => 'Arquivos desatualizados',
	'FILES_OUTDATED_EXPLAIN'         => '<strong>Desatualizado</strong> — Para impedir tentativas de invasão, remova os arquivos a seguir.',
	'FOUND_INSTALL'                  => 'Instalação dupla',
	'FOUND_INSTALL_EXPLAIN'          => '<strong>Instalação dupla</strong> - Foi encontrada uma instalação da galeria! Se continuar, os dados existentes serão sobrescritos. Todos os álbuns, imagens e comentários serão excluídos! <strong>Por este motivo é recomendável uma %1$satualização%2$s.</strong>',
	'FOUND_VERSION'                  => 'Foi encontrada a seguinte versão',
	'FOUNDER_CHECK'                  => 'Você é fundador deste fórum',
	'FOUNDER_NEEDED'                 => 'Você precisa ser fundador deste fórum.',
	'INSTALL_CONGRATS_EXPLAIN'       => 'O phpBB Gallery v%s foi instalado com sucesso.<br/><br/><strong>Exclua, mova ou renomeie o diretório install antes de usar o fórum. Enquanto esse diretório existir, somente o Painel de Administração (ACP) ficará acessível.</strong>',
	'INSTALL_INTRO_BODY'             => 'Esta opção instala o phpBB Gallery no seu fórum.',
	'GOTO_GALLERY'                   => 'Ir para o phpBB Gallery',
	'GOTO_INDEX'                     => 'Ir para o Índice do Fórum',
	'MISSING_CONSTANTS'              => 'Antes de executar o script de instalação, envie os arquivos editados, especialmente includes/constants.php.',
	'MODULES_CREATE_PARENT'          => 'Criar módulo principal',
	'MODULES_PARENT_SELECT'          => 'Escolha o módulo principal',
	'MODULES_SELECT_4ACP'            => 'Escolha o módulo principal para o "Painel de Administração (ACP)"',
	'MODULES_SELECT_4LOG'            => 'Escolha o módulo principal para o "Registro (Log) da Galeria"',
	'MODULES_SELECT_4MCP'            => 'Escolha o módulo principal para o "Painel de Moderação (MCP)"',
	'MODULES_SELECT_4UCP'            => 'Escolha o módulo principal para o "Painel de Usuário (UCP)"',
	'MODULES_SELECT_NONE'            => 'sem módulo pai',
	'NO_INSTALL_FOUND'               => 'Nenhuma instalação foi encontrada.',
	'OPTIONAL_EXIFDATA'              => 'A função "exif_read_data" existe',
	'OPTIONAL_EXIFDATA_EXP'          => 'O módulo EXIF não está carregado ou instalado.',
	'OPTIONAL_EXIFDATA_EXPLAIN'      => 'Se a função existir, os dados EXIF das imagens serão exibidos na página da imagem.',
	'OPTIONAL_IMAGEROTATE'           => 'A função "imagerotate" existe',
	'OPTIONAL_IMAGEROTATE_EXP'       => 'Atualize sua versão do GD, que atualmente é “%s”.',
	'OPTIONAL_IMAGEROTATE_EXPLAIN'   => 'Se a função existir, você poderá girar imagens durante o envio e a edição.',
	'PAYPAL_DEV_SUPPORT'             => '</p><div class="errorbox"><h3>Notas do autor</h3><p>Criar, manter e atualizar este MOD exige muito tempo e esforço. Se você gosta do MOD e deseja agradecer por meio de uma doação, ela será muito bem-vinda. O PayPal do autor é <strong>nickvergessen@gmx.de</strong>; também é possível entrar em contato para obter o endereço postal.<br /><br />O valor sugerido é 25,00 €, mas qualquer quantia ajuda.</p><br /><a href="http://www.flying-bits.org/go/paypal"><input type="submit" value="Fazer doação pelo PayPal" name="paypal" id="paypal" class="button1" /></a></div><p>',
	'PHP_SETTINGS'                   => 'Configurações PHP',
	'PHP_SETTINGS_EXP'               => 'Estas configurações do PHP são necessárias para instalar e executar a galeria.',
	'PHP_SETTINGS_OPTIONAL'          => 'Configurações PHP Opcionais',
	'PHP_SETTINGS_OPTIONAL_EXP'      => 'Estas configurações <strong>NÃO</strong> são necessárias para o uso normal, mas habilitam recursos adicionais.',
	'REQ_GD_LIBRARY'                 => 'A biblioteca GD está instalada',
	'REQ_PHP_VERSION'                => 'Versão do php >= %s',
	'REQ_PHPBB_VERSION'              => 'Versão do phpBB >= %s',
	'REQUIREMENTS_EXPLAIN'           => 'Antes da instalação, o phpBB verificará a configuração e os arquivos do servidor. Leia os resultados e continue somente depois que todos os testes obrigatórios forem aprovados.',
	'STAGE_ADVANCED_EXPLAIN'         => 'Selecione o módulo pai dos módulos da galeria. Em condições normais, não é necessário alterar a seleção.',
	'STAGE_COPY_TABLE'               => 'Copiar tabelas do banco de dados',
	'STAGE_COPY_TABLE_EXPLAIN'       => 'As tabelas de álbuns e usuários têm os mesmos nomes no TS Gallery e no phpBB Gallery. Por isso, será criada uma cópia para permitir a conversão dos dados.',
	'STAGE_CREATE_TABLE_EXPLAIN'     => 'As tabelas usadas pelo phpBB Gallery foram criadas e receberam os dados iniciais. Continue para concluir a instalação.',
	'STAGE_DELETE_TABLES'            => 'Limpar Banco de Dados',
	'STAGE_DELETE_TABLES_EXPLAIN'    => 'Os dados do phpBB Gallery foram excluídos do banco de dados. Continue para concluir a desinstalação.',
	'SUPPORT_BODY'                   => 'A versão estável atual do phpBB Gallery recebe suporte gratuito para instalação, configuração, dúvidas técnicas, possíveis falhas, atualização de versões RC e conversão do Album-MOD ou TS Gallery.</p><p>O uso de versões beta é recomendado apenas de forma limitada; quando houver uma atualização, instale-a rapidamente.</p><p>O suporte está disponível nos fóruns a seguir:</p><ul><li><a href="http://www.flying-bits.org/">flying-bits.org — fórum do autor nickvergessen</a></li><li><a href="http://www.phpbb.de/">phpbb.de</a></li><li><a href="http://www.phpbb.com/">phpbb.com</a></li></ul><p>',
	'TABLE_ALBUM'                    => 'tabela que contém as imagens',
	'TABLE_ALBUM_CAT'                => 'tabela que contém os álbuns',
	'TABLE_ALBUM_COMMENT'            => 'tabela que contém os comentários',
	'TABLE_ALBUM_CONFIG'             => 'tabela que contém as configurações',
	'TABLE_ALBUM_RATE'               => 'tabela que contém as avaliações',
	'TABLE_EXISTS'                   => 'existe',
	'TABLE_MISSING'                  => 'ausente',
	'TABLE_PREFIX_EXPLAIN'           => 'Prefixo da instalação phpBB2',
	'UNINSTALL_INTRO'                => 'Desinstalar o phpBB Gallery',
	'UNINSTALL_INTRO_BODY'           => 'Com esta opção, você pode desinstalar o phpBB Gallery.<br /><br /><strong>Aviso: todos os álbuns, imagens e comentários serão excluídos permanentemente!</strong>',
	'UNINSTALL_REQUIREMENTS'         => 'Requisitos',
	'UNINSTALL_REQUIREMENTS_EXPLAIN' => 'Antes da desinstalação, o phpBB executará testes para confirmar que você tem permissão para remover o phpBB Gallery.',
	'UNINSTALL_START'                => 'Desinstalar',
	'UNINSTALL_FINISHED'             => 'Desinstalação quase concluída',
	'UNINSTALL_FINISHED_EXPLAIN'     => 'O phpBB Gallery foi desinstalado com sucesso.<br/><br/><strong>Agora reverta as etapas de install.xml e exclua os arquivos da galeria para removê-la completamente do fórum.</strong>',
	'UPDATE_INSTALLATION_EXPLAIN'    => 'Aqui você pode atualizar o phpBB Gallery.',
	'VERSION_NOT_SUPPORTED'          => 'Atualizações de versões anteriores à 1.0.6 não são compatíveis com este sistema.',
	'GALLERY_SUB_EXT_UNINSTALL'      => [
		1 => 'Você deve desinstalar a extensão: <br /><strong>%s</strong><br /> antes de desinstalar a extensão principal.',
		2 => 'Você deve desinstalar as extensões: <br /><strong>%s</strong><br /> antes de desinstalar a extensão principal.',
	],
]);
