<?php

/**
 * @package   Upload Extensions
 * @author    John Peskens, Igor Lavrov, Leinad4Mind
 * @copyright (c) 2014 - 2021 John Peskens, Igor Lavrov | (c) 2022-2026 Leinad4Mind
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACP_UPLOAD_EXT_TITLE'         => 'Upload de Extensões',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'  => 'Upload de extensões',
	'ACP_UPLOAD_EXT_DESCRIPTION'   => 'Instalar/atualizar/apagar extensões, gerir os teus ficheiros ZIP e mais sem utilizar FTP.',
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN' => 'O Upload de Extensões permite-te fazer upload de pacotes zip de extensões ou apagar as pastas das extensões do servidor.<br />Com esta extensão podes instalar/atualizar/apagar extensões sem utilizar FTP. Se a extensão enviada já existir, será atualizada com os ficheiros enviados.',
	'ACP_UPLOAD_EXT_HELP'          => 'Upload de Extensões: Guia de utilização',
	'UPLOAD'                       => 'Upload',
	'BROWSE'                       => 'Procurar...',
	'EXTENSION_UPLOAD'             => 'Upload de uma extensão',
	'EXTENSION_UPLOAD_EXPLAIN'     => 'Aqui podes fazer upload de um pacote zip de uma extensão contendo os ficheiros necessários para efetuar a instalação a partir do teu computador local ou de um servidor remoto. O “Upload de Extensões” irá então tentar extrair o ficheiro e tê-lo pronto para instalação.<br />Escolhe um ficheiro ou digita um link nos campos abaixo.',
	'EXT_UPLOAD_ERROR'             => 'A extensão não foi enviada.',
	'EXT_UPLOAD_INIT_FAIL'         => 'Ocorreu um erro ao inicializar o processo de upload da extensão.',
	'EXT_NOT_WRITABLE'             => [
		'error'    => 'A pasta ext/ não tem permissões de escrita. Isto é necessário para que o “Upload de Extensões” funcione corretamente.',
		'solution' => 'Por favor, ajusta as permissões ou configurações e tenta novamente.',
	],
	'EXT_TMP_NOT_WRITABLE' => [
		'error'    => 'A pasta ext/boardtools/upload/tmp/ não tem permissões de escrita. Isto é necessário para que o “Upload de Extensões” funcione corretamente.',
		'solution' => 'Por favor, ajusta as permissões ou configurações e tenta novamente.',
	],
	'EXT_ALLOW_URL_FOPEN_DISABLED' => [
			'error'    => 'A configuração allow_url_fopen deve estar ativada de modo a carregar informação de um recurso remoto.',
			'solution' => 'Por favor, confirma que a configuração allow_url_fopen está ativada no teu php.ini e tenta novamente.',
	],
	'EXT_OPENSSL_DISABLED' => [
			'error'    => 'A extensão openssl deve estar ativada de modo a carregar informação de um recurso https.',
			'solution' => 'Por favor, confirma que a extensão openssl está ativada no teu php.ini e tenta novamente.',
	],
	'NO_UPLOAD_FILE' => [
		'error'    => 'Nenhum ficheiro especificado ou ocorreu um erro durante o processo de upload.',
		'solution' => 'Por favor, confirma que estás a fazer upload do verdadeiro ficheiro zip da extensão e tenta novamente.',
	],
	'NOT_AN_EXTENSION' => 'O ficheiro zip enviado não é uma extensão phpBB. O ficheiro não foi guardado no servidor.',
	'EXT_ACTION_ERROR' => 'A ação pedida não pode ser executada para a extensão phpBB selecionada.<br />Nota: O “Upload de Extensões” apenas pode ser gerido através do Gestor de Extensões padrão.',

	'SOURCE'                          => 'Fonte',
	'EXTENSION_UPDATE_NO_LINK'        => 'O link de transferência não foi fornecido.',
	'EXTENSION_TO_BE_ENABLED'         => 'O Upload de Extensões será desativado durante o processo de atualização e ativado novamente após a atualização.',
	'EXTENSION_UPLOAD_UPDATE'         => 'Atualizar a extensão',
	'EXTENSION_UPLOAD_UPDATE_EXPLAIN' => 'O “Upload de Extensões” irá realizar o upload a partir do link mostrado abaixo.',

	'EXTENSION_UPLOADED'             => 'A extensão “%s” foi enviada com sucesso.',
	'EXTENSIONS_AVAILABLE'           => 'Extensões desinstaladas',
	'EXTENSIONS_UPLOADED'            => 'Extensões enviadas',
	'EXTENSIONS_UNAVAILABLE'         => 'Extensões corrompidas',
	'EXTENSIONS_UNAVAILABLE_EXPLAIN' => 'As extensões listadas abaixo estão enviadas no teu fórum mas encontram-se corrompidas por algum motivo e, por isso, estão indisponíveis e não podem ser ativadas. Por favor, verifica os ficheiros corretos e usa a Ferramenta de Limpeza de Extensões se pretenderes apagar os ficheiros das extensões corrompidas do servidor.',
	'EXTENSION_BROKEN'               => 'Extensão corrompida',
	'EXTENSION_BROKEN_ENABLED'       => 'Esta extensão corrompida está ativada!',
	'EXTENSION_BROKEN_DISABLED'      => 'Esta extensão corrompida está desativada!',
	'EXTENSION_BROKEN_TITLE'         => 'Esta extensão está corrompida!',
	'EXTENSION_BROKEN_DETAILS'       => 'Clica aqui para ver os detalhes.',
	'EXTENSION_BROKEN_EXPLAIN'       => '<strong>Alguns dados desta extensão ainda estão guardados no servidor.</strong> Por favor, verifica a razão pela qual esta extensão está corrompida. Poderás precisar de pedir ajuda aos desenvolvedores da extensão e usar o FTP para alterar alguns ficheiros (ou podes fazer upload de uma versão com correções). Depois disso, poderás gerir a extensão novamente.<br /><h3>O que podes fazer:</h3><br /><strong>Atualizar a extensão corrompida.</strong><br /><ul><li>Certifica-te de que a extensão está desativada (clica no alternador se necessário).</li><li>Descobre se existe uma nova versão da extensão disponível. Tenta enviá-la.</li><li>Se o problema não ficar resolvido, podes pedir ajuda aos desenvolvedores da extensão.</ul><strong>ou</strong><br /><br /><strong>Remover totalmente a extensão corrompida.</strong><br /><ul><li>Certifica-te de que a extensão está desativada (clica no alternador se necessário).</li><li>Certifica-te de que os dados da extensão estão apagados (clica no botão do caixote do lixo se necessário).</li><li>Remove os ficheiros da extensão usando a Ferramenta de Limpeza de Extensões.</ul>',

	'EXTENSION_UPLOADED_ENABLE' => 'Ativar a extensão enviada',
	'ACP_UPLOAD_EXT_UNPACK'     => 'Descompactar extensão',
	'ACP_UPLOAD_EXT_CONT'       => 'Conteúdo do pacote “%s”',

	'EXT_LIST_DOWNLOAD'                => 'Transferir a lista completa',
	'EXT_LIST_DOWNLOAD_ENGLISH'        => 'Usar nomes de estados em Inglês',
	'EXT_LIST_DOWNLOAD_GROUP'          => 'Agrupar por',
	'EXT_LIST_DOWNLOAD_GROUP_STANDARD' => 'enviadas/corrompidas',
	'EXT_LIST_DOWNLOAD_GROUP_DISABLED' => 'ativadas/desativadas/corrompidas',
	'EXT_LIST_DOWNLOAD_GROUP_PURGED'   => 'ativadas/desativadas/desinstaladas/corrompidas',
	'EXT_LIST_DOWNLOAD_SHOW'           => 'Incluir nomes',
	'EXT_LIST_DOWNLOAD_SHOW_FULL'      => 'nomes de exibição e nomes limpos',
	'EXT_LIST_DOWNLOAD_SHOW_CLEAN'     => 'apenas nomes limpos',
	'EXT_LIST_DOWNLOAD_SHOW_NAME'      => 'apenas nomes de exibição',
	'EXT_LIST_DOWNLOAD_TITLE'          => 'Lista completa de extensões enviadas',
	'EXT_LIST_DOWNLOAD_FOOTER'         => 'Gerado pelo Upload de Extensões',

	'EXT_ROW_ENABLED'      => 'ativada',
	'EXT_ROW_DISABLED'     => 'desativada',
	'EXT_ROW_UNINSTALLED'  => 'desinstalada',
	'EXT_ROWS_ENABLED'     => 'Ativadas:',
	'EXT_ROWS_DISABLED'    => 'Desativadas:',
	'EXT_ROWS_UNINSTALLED' => 'Desinstaladas:',
	'EXT_ROWS_UPLOADED'    => 'Enviadas:',
	'EXT_ROWS_BROKEN'      => 'Corrompidas:',

	'EXTENSION_DELETE'          => 'Apagar extensão',
	'EXTENSION_DELETE_CONFIRM'  => 'Tens a certeza de que desejas apagar a extensão “%s”?',
	'EXTENSIONS_DELETE_CONFIRM' => [
		2 => 'Tens a certeza de que desejas apagar <strong>%1$s</strong> extensões?',
	],
	'EXT_DELETE_SUCCESS'   => 'A extensão foi apagada com sucesso.',
	'EXTS_DELETE_SUCCESS'  => 'As extensões foram apagadas com sucesso.',
	'EXT_DELETE_ERROR'     => 'Nenhum ficheiro especificado ou ocorreu um erro durante a eliminação.',
	'EXT_DELETE_NO_FILE'   => 'Nenhum ficheiro foi especificado para a eliminação.',
	'EXT_CANNOT_BE_PURGED' => 'Os dados da extensão ativada não podem ser purgados. Desativa a extensão para poderes purgar os teus dados.',

	'EXTENSION_ZIP_DELETE'          => 'Apagar ficheiro zip',
	'EXTENSION_ZIP_DELETE_CONFIRM'  => 'Tens a certeza de que desejas apagar o ficheiro zip “%s”?',
	'EXTENSIONS_ZIP_DELETE_CONFIRM' => [
		2 => 'Tens a certeza de que desejas apagar <strong>%1$s</strong> ficheiros zip?',
	],
	'EXT_ZIP_DELETE_SUCCESS'  => 'O ficheiro zip da extensão foi apagado com sucesso.',
	'EXT_ZIPS_DELETE_SUCCESS' => 'Os ficheiros zip das extensões foram apagados com sucesso.',
	'EXT_ZIP_DELETE_ERROR'    => 'Nenhum ficheiro especificado ou ocorreu um erro durante a eliminação.',

	'ACP_UPLOAD_EXT_ERROR_DEST'      => 'Nenhuma pasta de autor (vendor) ou de destino no ficheiro zip enviado. O ficheiro não foi guardado no servidor.',
	'ACP_UPLOAD_EXT_ERROR_COMP'      => 'O composer.json não foi encontrado no ficheiro zip enviado. O ficheiro não foi guardado no servidor.',
	'ACP_UPLOAD_EXT_ERROR_NOT_SAVED' => 'O ficheiro não foi guardado no servidor.',
	'ACP_UPLOAD_EXT_ERROR_TRY_SELF'  => 'O “Upload de Extensões” só pode ser atualizado pelo Updater especial ou através de FTP.',
	'ACP_UPLOAD_EXT_WRONG_RESTORE'   => 'Ocorreu um erro durante a atualização de uma extensão instalada. Tenta atualizá-la novamente.',

	'DEVELOPER'  => 'Desenvolvedor',
	'DEVELOPERS' => 'Desenvolvedores',

	'EXT_UPLOAD_SAVE_ZIP'        => 'Guardar o ficheiro zip enviado',
	'CHECKSUM'                   => 'Checksum',
	'RESTORE'                    => 'Restaurar',
	'ZIP_UPLOADED'               => 'Pacotes zip de extensões enviados',
	'EXT_ENABLE'                 => 'Ativar',
	'EXT_ENABLE_DISABLE'         => 'Ativar/Desativar a extensão',
	'EXT_ENABLED'                => 'A extensão foi ativada com sucesso.',
	'EXT_DISABLED'               => 'A extensão foi desativada com sucesso.',
	'EXT_PURGE'                  => 'Purgar dados da extensão',
	'EXT_PURGED'                 => 'Os dados da extensão foram purgados com sucesso.',
	'EXT_UPLOADED'               => 'O upload foi concluído com sucesso.',
	'EXT_UPDATE_ENABLE'          => 'Clica no alternador para ativar a extensão.',
	'EXT_UPDATE_CHECK_FILETREE'  => 'Por favor, verifica a árvore de ficheiros da extensão.',
	'EXT_UPDATE_ERROR'           => 'O processo de atualização encontrou um erro.',
	'EXT_UPDATE_TIMEOUT'         => 'O processo de atualização excedeu o tempo limite (timeout).',
	'EXT_UPDATES_AVAILABLE'      => 'Existem atualizações disponíveis',
	'EXT_UPDATE_METHODS_TITLE'   => 'Métodos de atualização disponíveis',
	'EXT_UPLOAD_UPDATE_METHODS'  => 'Podes atualizar a extensão tomando uma das seguintes ações:<ul><li><strong>Método Updater.</strong> O Upload de Extensões pode ser atualizado com o Upload Extensions Updater. Verifica se esta ferramenta já se encontra disponível. Caso não tenhas esta ferramenta, precisarás de usar o segundo método.</li><li><strong>Método FTP.</strong> O Upload de Extensões pode ser atualizado da forma padrão. Transfere os novos ficheiros para o teu PC (clica no botão abaixo), desativa a extensão no Gestor de Extensões padrão, copia os novos ficheiros utilizando um cliente FTP e ativa a extensão no Gestor de Extensões padrão.</li></ul>',
	'EXT_UPDATED'                => 'A atualização foi concluída com sucesso.',
	'EXT_UPDATED_LATEST_VERSION' => 'atualizada para a versão mais recente',
	'EXT_SAVED_OLD_ZIP'          => '<strong>NOTA:</strong> a versão anterior da extensão foi guardada no ficheiro <strong>%s</strong> no teu servidor. Verifica o módulo “Gestão de ficheiros ZIP”.',
	'EXT_RESTORE_LANGUAGE'       => '<strong>Uma pasta de idioma está ausente na versão enviada da extensão.</strong> Podes restaurar a pasta %s a partir do ficheiro zip guardado da versão anterior. Depois poderás precisar de atualizar os ficheiros dessa pasta para garantir a compatibilidade com a versão enviada da extensão.',
	'EXT_RESTORE_LANGUAGES'      => '<strong>Algumas pastas de idiomas estão ausentes na versão enviada da extensão.</strong> Podes restaurar as pastas %1$s e %2$s a partir do ficheiro zip guardado da versão anterior. Depois poderás precisar de atualizar os ficheiros dessas pastas para garantir a compatibilidade com a versão enviada da extensão.',
	'EXT_LANGUAGES_RESTORED'     => 'O processo de restauro foi concluído com sucesso.',
	'EXT_SHOW_DESCRIPTION'       => 'Mostrar a descrição da extensão',
	'EXT_UPLOAD_BACK'            => '« Voltar ao Upload de Extensões',
	'EXT_RELOAD_PAGE'            => 'Recarregar a página',
	'EXT_REFRESH_PAGE'           => 'Atualizar a página',
	'EXT_REFRESH_NOTICE'         => 'O menu de navegação pode estar desatualizado.',

	'ERROR_COPY_FILE'                  => 'A tentativa de copiar o ficheiro “%1$s” para a localização “%2$s” falhou.',
	'ERROR_CREATE_DIRECTORY'           => 'A tentativa de criar a pasta “%s” falhou.',
	'ERROR_REMOVE_DIRECTORY'           => 'A tentativa de remover a pasta “%s” falhou.',
	'ERROR_CHECKSUM_MISMATCH'          => 'O hash %s do ficheiro enviado difere do checksum fornecido. O ficheiro não foi guardado no servidor.',
	'ERROR_ZIP_NO_COMPOSER'            => 'O composer.json não foi encontrado no pacote zip solicitado.',
	'ERROR_DIRECTORIES_NOT_RESTORED'   => 'O processo de restauro não pôde ser concluído devido a erros.',
	'ERROR_LANGUAGE_UNKNOWN_STRUCTURE' => 'A estrutura do pacote de idioma enviado não é reconhecida. O ficheiro não foi guardado no servidor.',
	'ERROR_LANGUAGE_NO_EXTENSION'      => 'O nome da extensão não está especificado para o pacote de idioma.',
	'ERROR_LANGUAGE_NOT_DEFINED'       => 'O código ISO do idioma deve ser definido para o upload adequado do pacote de idioma. Por favor, preenche o campo obrigatório do formulário e tenta novamente.',

	'ACP_UPLOAD_EXT_DIR'         => 'Caminho de armazenamento dos pacotes zip das extensões',
	'ACP_UPLOAD_EXT_DIR_EXPLAIN' => 'Caminho a partir da tua pasta raiz do phpBB, ex. <samp>ext</samp>.<br />Podes alterar este caminho para armazenar os pacotes zip numa pasta especial (por exemplo, se quiseres permitir que os utilizadores transfiram esses ficheiros, podes alterá-lo para <em>downloads</em>, e se quiseres proibir essas transferências, podes alterá-lo para o caminho que está um nível acima da raiz http do teu site (ou podes criar uma pasta com o ficheiro .htaccess apropriado)).',

	'ACP_UPLOAD_EXT_UPDATED'         => 'A extensão instalada foi atualizada.',
	'ACP_UPLOAD_EXT_UPDATED_EXPLAIN' => 'Enviaste um ficheiro zip para uma extensão já instalada. Essa extensão <strong>foi desativada automaticamente</strong> para tornar o processo de atualização mais seguro. Agora, por favor <strong>verifica</strong> se os ficheiros enviados estão corretos e <strong>ativa</strong> a extensão se ela ainda dever ser usada no fórum.',

	'ACP_UPLOAD_EXT_NO_CHECKSUM_TITLE' => 'Nenhum checksum foi fornecido para o ficheiro enviado.',
	'ACP_UPLOAD_EXT_NO_CHECKSUM'       => 'O Upload de Extensões não conseguiu realizar verificações de segurança porque o <strong>checksum não foi fornecido</strong> para o ficheiro zip enviado. O checksum é utilizado para garantir que o ficheiro enviado não está corrompido nem comprometido.',

	'VALID_PHPBB_EXTENSIONS'            => 'Extensões validadas',
	'SHOW_VALID_PHPBB_EXTENSIONS'       => 'Mostrar extensões validadas',
	'VALID_PHPBB_EXTENSIONS_TITLE'      => 'Podes transferir extensões validadas a partir da CDB no phpbb.com ou consultar as tuas páginas oficiais.',
	'VALID_PHPBB_EXTENSIONS_EMPTY_LIST' => 'Nenhuma extensão está a ser sugerida no momento. Por favor, verifica se existem atualizações para o Upload de Extensões.',
	'POSSIBLE_SOLUTIONS'                => 'Soluções possíveis',

	'ACP_UPLOAD_EXT_MANAGER_EXPLAIN' => 'O Gestor de Extensões do Upload de Extensões é uma ferramenta no teu Fórum phpBB que te permite gerir todas as tuas extensões e ver informação sobre as mesmas.',
	'ACP_UPLOAD_ZIP_TITLE'           => 'Gestão de ficheiros ZIP',
	'ACP_UPLOAD_UNINSTALLED_TITLE'   => 'Apagar extensões',

	'EXT_DETAILS_README'    => 'Readme',
	'EXT_DETAILS_CHANGELOG' => 'Changelog',
	'EXT_DETAILS_LANGUAGES' => 'Idiomas',
	'EXT_DETAILS_FILETREE'  => 'Árvore de ficheiros',
	'EXT_DETAILS_TOOLS'     => 'Ferramentas',

	'DEFAULT'                      => 'padrão',
	'EXT_LANGUAGE_ISO_CODE'        => 'Código ISO',
	'EXT_LANGUAGES'                => 'Pacotes de idioma enviados',
	'EXT_LANGUAGES_UPLOAD'         => 'Upload de um pacote de idioma',
	'EXT_LANGUAGES_UPLOAD_EXPLAIN' => 'Aqui podes fazer upload de um pacote zip contendo os ficheiros de idioma necessários para esta extensão a partir do teu computador local ou de um servidor remoto. O “Upload de Extensões” irá então tentar descompactar os ficheiros e movê-los para a localização correta.<br />Escolhe um ficheiro ou digita um link nos campos abaixo.<br />Não te esqueças de especificar o código ISO do idioma no campo correspondente abaixo (exemplo: <strong>pt</strong>).<br /><strong>IMPORTANTE!</strong> A pasta atual do idioma dessa extensão com esse código ISO será apagada se existir, <strong>nenhum ficheiro zip será feito para ela</strong>.',
	'EXT_LANGUAGE_UPLOADED'        => 'O pacote de idioma “%s” foi enviado com sucesso.',
	'EXT_LANGUAGE_DELETE_CONFIRM'  => 'Tens a certeza de que desejas apagar o pacote de idioma “%s”?',
	'EXT_LANGUAGES_DELETE_CONFIRM' => [
		2 => 'Tens a certeza de que desejas apagar <strong>%1$s</strong> pacotes de idioma?',
	],
	'EXT_LANGUAGE_DELETE_SUCCESS'  => 'O pacote de idioma da extensão foi apagado com sucesso.',
	'EXT_LANGUAGES_DELETE_SUCCESS' => 'Os pacotes de idioma da extensão foram apagados com sucesso.',
	'EXT_LANGUAGE_DELETE_ERROR'    => 'Nenhum ficheiro especificado ou ocorreu um erro durante a eliminação.',

	'EXT_TOOLS_DOWNLOAD_TITLE'         => 'Transferir extensão empacotada',
	'EXT_TOOLS_DOWNLOAD'               => 'Podes transferir um ficheiro ZIP adequadamente empacotado da extensão para o teu PC. Podes também optar por apagar o sufixo da versão de desenvolvimento (ex. para encurtar o tempo de preparação da extensão para a CDB).',
	'EXT_TOOLS_DOWNLOAD_DELETE_SUFFIX' => 'Apagar o sufixo de desenvolvimento, caso exista',
	'EXT_DOWNLOAD_ERROR'               => 'A tentativa de transferir a extensão “%s” falhou.',

	'EXT_LOAD_ERROR'         => 'Ocorreu um erro no carregamento',
	'EXT_LOAD_TIMEOUT'       => 'O carregamento excedeu o tempo limite',
	'EXT_LOAD_ERROR_EXPLAIN' => 'Ocorreu um erro durante o processo de carregamento.',
	'EXT_LOAD_ERROR_SHOW'    => 'Mostrar os erros ocorridos',
	'EXT_LOAD_SOLUTIONS'     => 'Por favor, verifica os ficheiros de registo (log) de erros no teu servidor, elimina o problema e tenta novamente.',

	'UPLOAD_DESCRIPTION_UPLOAD'         => 'Upload de extensões phpBB',
	'UPLOAD_DESCRIPTION_UPLOAD_CDB'     => 'CDB em phpbb.com',
	'UPLOAD_DESCRIPTION_UPLOAD_LOCAL'   => 'PC Local',
	'UPLOAD_DESCRIPTION_UPLOAD_REMOTE'  => 'Servidor remoto',
	'UPLOAD_DESCRIPTION_UPDATE'         => 'Atualizar extensões phpBB',
	'UPLOAD_DESCRIPTION_UPDATE_ABOUT'   => 'Podes atualizar qualquer uma das extensões já enviadas. A extensão que pretendes atualizar será desativada automaticamente para que quaisquer atualizações sejam seguras.',
	'UPLOAD_DESCRIPTION_MANAGE'         => 'Gerir extensões phpBB',
	'UPLOAD_DESCRIPTION_MANAGE_ACTIONS' => 'Instalar/desinstalar quaisquer extensões',
	'UPLOAD_DESCRIPTION_MANAGE_LANG'    => 'Fazer upload e gerir os pacotes de idioma das extensões',
	'UPLOAD_DESCRIPTION_MANAGE_DETAILS' => 'Ver os detalhes e as árvores de ficheiros',
	'UPLOAD_DESCRIPTION_DESIGN'         => 'Interface interativa',
	'UPLOAD_DESCRIPTION_DESIGN_ABOUT'   => 'Podes executar ações mais rapidamente devido à funcionalidade JavaScript. Mensagens coloridas e dicas ajudar-te-ão a tomar as decisões corretas.',
	'UPLOAD_DESCRIPTION_ZIP'            => 'Gestão de ficheiros ZIP',
	'UPLOAD_DESCRIPTION_ZIP_SAVE'       => 'Guardar os ficheiros zip numa pasta à tua escolha',
	'UPLOAD_DESCRIPTION_ZIP_UNPACK'     => 'Descompactar um ficheiro zip para instalar uma extensão',
	'UPLOAD_DESCRIPTION_ZIP_DOWNLOAD'   => 'Transferir pacotes zip adequados de extensões',
	'UPLOAD_DESCRIPTION_CLEANER'        => 'Ferramenta de Limpeza de Extensões',
	'UPLOAD_DESCRIPTION_CLEANER_ABOUT'  => 'Podes apagar as pastas das extensões ou os ficheiros zip de extensões do servidor.',
]);
