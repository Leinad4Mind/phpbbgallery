<?php

/**
 * @package   Upload Extensions
 * @author    John Peskens, Igor Lavrov, Leinad4Mind
 * @copyright (c) 2014 - 2021 John Peskens, Igor Lavrov | (c) 2022-2026 Leinad4Mind
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'ACP_UPLOAD_EXT_TITLE'         => 'Carregar Extensões',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'  => 'Carregar extensões',
	'ACP_UPLOAD_EXT_DESCRIPTION'   => 'Instalar/atualizar/apagar extensões, gerir os seus arquivos ZIP e mais sem utilizar FTP.',
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN' => 'O Carregar Extensões permite-lhe carregar pacotes zip de extensões ou apagar as pastas das extensões do servidor.<br />Com esta extensão você pode instalar/atualizar/apagar extensões sem utilizar FTP. Se a extensão carregada já existir, será atualizada com os arquivos carregados.',
	'ACP_UPLOAD_EXT_HELP'          => 'Carregar Extensões: Guia de utilização',
	'UPLOAD'                       => 'Carregar',
	'BROWSE'                       => 'Procurar...',
	'EXTENSION_UPLOAD'             => 'Carregar uma extensão',
	'EXTENSION_UPLOAD_EXPLAIN'     => 'Aqui você pode carregar um pacote zip de uma extensão contendo os arquivos necessários para efetuar a instalação a partir do seu computador local ou de um servidor remoto. O “Carregar Extensões” irá então tentar extrair o arquivo e tê-lo pronto para instalação.<br />Escolha um arquivo ou digite um link nos campos abaixo.',
	'EXT_UPLOAD_ERROR'             => 'A extensão não foi carregada.',
	'EXT_UPLOAD_INIT_FAIL'         => 'Ocorreu um erro ao inicializar o processo de carregamento da extensão.',
	'EXT_NOT_WRITABLE'             => [
		'error'    => 'A pasta ext/ não tem permissões de escrita. Isto é necessário para que o “Carregar Extensões” funcione corretamente.',
		'solution' => 'Por favor, ajusta as permissões ou configurações e tenta novamente.',
	],
	'EXT_TMP_NOT_WRITABLE' => [
		'error'    => 'A pasta ext/boardtools/upload/tmp/ não tem permissões de escrita. Isto é necessário para que o “Carregar Extensões” funcione corretamente.',
		'solution' => 'Por favor, ajusta as permissões ou configurações e tenta novamente.',
	],
	'EXT_ALLOW_URL_FOPEN_DISABLED' => [
			'error'    => 'A configuração allow_url_fopen deve estar habilitada de modo a carregar informação de um recurso remoto.',
			'solution' => 'Por favor, confirme que a configuração allow_url_fopen está habilitada no seu php.ini e tente novamente.',
	],
	'EXT_OPENSSL_DISABLED' => [
			'error'    => 'A extensão openssl deve estar habilitada de modo a carregar informação de um recurso https.',
			'solution' => 'Por favor, confirme que a extensão openssl está habilitada no seu php.ini e tente novamente.',
	],
	'NO_UPLOAD_FILE' => [
		'error'    => 'Nenhum arquivo especificado ou ocorreu um erro durante o processo de carregamento.',
		'solution' => 'Por favor, confirme que está carregando o verdadeiro arquivo zip da extensão e tente novamente.',
	],
	'NOT_AN_EXTENSION' => 'O arquivo zip carregado não é uma extensão phpBB. O arquivo não foi guardado no servidor.',
	'EXT_ACTION_ERROR' => 'A ação pedida não pode ser executada para a extensão phpBB selecionada.<br />Nota: O “Carregar Extensões” apenas pode ser gerido através do Gestor de Extensões padrão.',

	'SOURCE'                          => 'Fonte',
	'EXTENSION_UPDATE_NO_LINK'        => 'O link de transferência não foi fornecido.',
	'EXTENSION_TO_BE_ENABLED'         => 'O Carregar Extensões será desativado durante o processo de atualização e ativado novamente após a atualização.',
	'EXTENSION_UPLOAD_UPDATE'         => 'Atualizar a extensão',
	'EXTENSION_UPLOAD_UPDATE_EXPLAIN' => 'O “Carregar Extensões” irá realizar o carregamento a partir do link mostrado abaixo.',

	'EXTENSION_UPLOADED'             => 'A extensão “%s” foi carregada com sucesso.',
	'EXTENSIONS_AVAILABLE'           => 'Extensões desinstaladas',
	'EXTENSIONS_UPLOADED'            => 'Extensões carregadas',
	'EXTENSIONS_UNAVAILABLE'         => 'Extensões corrompidas',
	'EXTENSIONS_UNAVAILABLE_EXPLAIN' => 'As extensões listadas abaixo estão carregadas no seu fórum mas encontram-se corrompidas por algum motivo e, por isso, estão indisponíveis e não podem ser habilitadas. Por favor, verifique os arquivos corretos e use a Ferramenta de Limpeza de Extensões se pretender apagar os arquivos das extensões corrompidas do servidor.',
	'EXTENSION_BROKEN'               => 'Extensão corrompida',
	'EXTENSION_BROKEN_ENABLED'       => 'Esta extensão corrompida está habilitada!',
	'EXTENSION_BROKEN_DISABLED'      => 'Esta extensão corrompida está desabilitada!',
	'EXTENSION_BROKEN_TITLE'         => 'Esta extensão está corrompida!',
	'EXTENSION_BROKEN_DETAILS'       => 'Clique aqui para ver os detalhes.',
	'EXTENSION_BROKEN_EXPLAIN'       => '<strong>Alguns dados desta extensão ainda estão guardados no servidor.</strong> Por favor, verifique a razão pela qual esta extensão está corrompida. Você poderá precisar de pedir ajuda aos desenvolvedores da extensão e usar o FTP para alterar alguns arquivos (ou você pode carregar uma versão com correções). Depois disso, você poderá gerenciar a extensão novamente.<br /><h3>O que você pode fazer:</h3><br /><strong>Atualizar a extensão corrompida.</strong><br /><ul><li>Certifique-se de que a extensão está desabilitada (clique no alternador se necessário).</li><li>Descubra se existe uma nova versão da extensão disponível. Tente carregá-la.</li><li>Se o problema não ficar resolvido, você pode pedir ajuda aos desenvolvedores da extensão.</ul><strong>ou</strong><br /><br /><strong>Remover totalmente a extensão corrompida.</strong><br /><ul><li>Certifique-se de que a extensão está desabilitada (clique no alternador se necessário).</li><li>Certifique-se de que os dados da extensão estão apagados (clique no botão do caixote do lixo se necessário).</li><li>Remova os arquivos da extensão usando a Ferramenta de Limpeza de Extensões.</ul>',

	'EXTENSION_UPLOADED_ENABLE' => 'Habilitar a extensão carregada',
	'ACP_UPLOAD_EXT_UNPACK'     => 'Descompactar extensão',
	'ACP_UPLOAD_EXT_CONT'       => 'Conteúdo do pacote “%s”',

	'EXT_LIST_DOWNLOAD'                => 'Baixar a lista completa',
	'EXT_LIST_DOWNLOAD_ENGLISH'        => 'Usar nomes de estados em Inglês',
	'EXT_LIST_DOWNLOAD_GROUP'          => 'Agrupar por',
	'EXT_LIST_DOWNLOAD_GROUP_STANDARD' => 'carregadas/corrompidas',
	'EXT_LIST_DOWNLOAD_GROUP_DISABLED' => 'habilitadas/desabilitadas/corrompidas',
	'EXT_LIST_DOWNLOAD_GROUP_PURGED'   => 'habilitadas/desabilitadas/desinstaladas/corrompidas',
	'EXT_LIST_DOWNLOAD_SHOW'           => 'Incluir nomes',
	'EXT_LIST_DOWNLOAD_SHOW_FULL'      => 'nomes de exibição e nomes limpos',
	'EXT_LIST_DOWNLOAD_SHOW_CLEAN'     => 'apenas nomes limpos',
	'EXT_LIST_DOWNLOAD_SHOW_NAME'      => 'apenas nomes de exibição',
	'EXT_LIST_DOWNLOAD_TITLE'          => 'Lista completa de extensões carregadas',
	'EXT_LIST_DOWNLOAD_FOOTER'         => 'Gerado pelo Carregar Extensões',

	'EXT_ROW_ENABLED'      => 'habilitada',
	'EXT_ROW_DISABLED'     => 'desabilitada',
	'EXT_ROW_UNINSTALLED'  => 'desinstalada',
	'EXT_ROWS_ENABLED'     => 'Habilitadas:',
	'EXT_ROWS_DISABLED'    => 'Desabilitadas:',
	'EXT_ROWS_UNINSTALLED' => 'Desinstaladas:',
	'EXT_ROWS_UPLOADED'    => 'Carregadas:',
	'EXT_ROWS_BROKEN'      => 'Corrompidas:',

	'EXTENSION_DELETE'          => 'Apagar extensão',
	'EXTENSION_DELETE_CONFIRM'  => 'Tem a certeza de que desejas apagar a extensão “%s”?',
	'EXTENSIONS_DELETE_CONFIRM' => [
		2 => 'Tem a certeza de que desejas apagar <strong>%1$s</strong> extensões?',
	],
	'EXT_DELETE_SUCCESS'   => 'A extensão foi apagada com sucesso.',
	'EXTS_DELETE_SUCCESS'  => 'As extensões foram apagadas com sucesso.',
	'EXT_DELETE_ERROR'     => 'Nenhum arquivo especificado ou ocorreu um erro durante a eliminação.',
	'EXT_DELETE_NO_FILE'   => 'Nenhum arquivo foi especificado para a eliminação.',
	'EXT_CANNOT_BE_PURGED' => 'Os dados da extensão habilitada não podem ser purgados. Desativa a extensão para poderes purgar os seus dados.',

	'EXTENSION_ZIP_DELETE'          => 'Apagar arquivo zip',
	'EXTENSION_ZIP_DELETE_CONFIRM'  => 'Tem a certeza de que desejas apagar o arquivo zip “%s”?',
	'EXTENSIONS_ZIP_DELETE_CONFIRM' => [
		2 => 'Tem a certeza de que desejas apagar <strong>%1$s</strong> arquivos zip?',
	],
	'EXT_ZIP_DELETE_SUCCESS'  => 'O arquivo zip da extensão foi apagado com sucesso.',
	'EXT_ZIPS_DELETE_SUCCESS' => 'Os arquivos zip das extensões foram apagados com sucesso.',
	'EXT_ZIP_DELETE_ERROR'    => 'Nenhum arquivo especificado ou ocorreu um erro durante a eliminação.',

	'ACP_UPLOAD_EXT_ERROR_DEST'      => 'Nenhuma pasta de autor (vendor) ou de destino no arquivo zip carregado. O arquivo não foi guardado no servidor.',
	'ACP_UPLOAD_EXT_ERROR_COMP'      => 'O composer.json não foi encontrado no arquivo zip carregado. O arquivo não foi guardado no servidor.',
	'ACP_UPLOAD_EXT_ERROR_NOT_SAVED' => 'O arquivo não foi guardado no servidor.',
	'ACP_UPLOAD_EXT_ERROR_TRY_SELF'  => 'O “Carregar Extensões” só pode ser atualizado pelo Updater especial ou através de FTP.',
	'ACP_UPLOAD_EXT_WRONG_RESTORE'   => 'Ocorreu um erro durante a atualização de uma extensão instalada. Tente atualizá-la novamente.',

	'DEVELOPER'  => 'Desenvolvedor',
	'DEVELOPERS' => 'Desenvolvedores',

	'EXT_UPLOAD_SAVE_ZIP'        => 'Guardar o arquivo zip carregado',
	'CHECKSUM'                   => 'Checksum',
	'RESTORE'                    => 'Restaurar',
	'ZIP_UPLOADED'               => 'Pacotes zip de extensões carregados',
	'EXT_ENABLE'                 => 'Habilitar',
	'EXT_ENABLE_DISABLE'         => 'Habilitar/Desabilitar a extensão',
	'EXT_ENABLED'                => 'A extensão foi habilitada com sucesso.',
	'EXT_DISABLED'               => 'A extensão foi desabilitada com sucesso.',
	'EXT_PURGE'                  => 'Purgar dados da extensão',
	'EXT_PURGED'                 => 'Os dados da extensão foram purgados com sucesso.',
	'EXT_UPLOADED'               => 'O carregamento foi concluído com sucesso.',
	'EXT_UPDATE_ENABLE'          => 'Clique no alternador para habilitar a extensão.',
	'EXT_UPDATE_CHECK_FILETREE'  => 'Por favor, verifique a árvore de arquivos da extensão.',
	'EXT_UPDATE_ERROR'           => 'O processo de atualização encontrou um erro.',
	'EXT_UPDATE_TIMEOUT'         => 'O processo de atualização excedeu o tempo limite (timeout).',
	'EXT_UPDATES_AVAILABLE'      => 'Existem atualizações disponíveis',
	'EXT_UPDATE_METHODS_TITLE'   => 'Métodos de atualização disponíveis',
	'EXT_UPLOAD_UPDATE_METHODS'  => 'Você pode atualizar a extensão tomando uma das seguintes ações:<ul><li><strong>Método Updater.</strong> O Carregar Extensões pode ser atualizado com o Upload Extensions Updater. Verifica se esta ferramenta já se encontra disponível. Caso não tenhas esta ferramenta, precisarás de usar o segundo método.</li><li><strong>Método FTP.</strong> O Carregar Extensões pode ser atualizado da forma padrão. Descarrega os novos arquivos para o seu PC (clica no botão abaixo), desativa a extensão no Gestor de Extensões padrão, copia os novos arquivos utilizando um cliente FTP e ativa a extensão no Gestor de Extensões padrão.</li></ul>',
	'EXT_UPDATED'                => 'A atualização foi concluída com sucesso.',
	'EXT_UPDATED_LATEST_VERSION' => 'atualizada para a versão mais recente',
	'EXT_SAVED_OLD_ZIP'          => '<strong>NOTA:</strong> a versão anterior da extensão foi guardada no arquivo <strong>%s</strong> no seu servidor. Verifica o módulo “Gestão de arquivos ZIP”.',
	'EXT_RESTORE_LANGUAGE'       => '<strong>Uma pasta de idioma está ausente na versão carregada da extensão.</strong> Você pode restaurar a pasta %s a partir do arquivo zip guardado da versão anterior. Depois poderás precisar de atualizar os arquivos dessa pasta para garantir a compatibilidade com a versão carregada da extensão.',
	'EXT_RESTORE_LANGUAGES'      => '<strong>Algumas pastas de idiomas estão ausentes na versão carregada da extensão.</strong> Você pode restaurar as pastas %1$s e %2$s a partir do arquivo zip guardado da versão anterior. Depois poderás precisar de atualizar os arquivos dessas pastas para garantir a compatibilidade com a versão carregada da extensão.',
	'EXT_LANGUAGES_RESTORED'     => 'O processo de restauro foi concluído com sucesso.',
	'EXT_SHOW_DESCRIPTION'       => 'Mostrar a descrição da extensão',
	'EXT_UPLOAD_BACK'            => '« Voltar ao Carregar Extensões',
	'EXT_RELOAD_PAGE'            => 'Recarregar a página',
	'EXT_REFRESH_PAGE'           => 'Atualizar a página',
	'EXT_REFRESH_NOTICE'         => 'O menu de navegação pode estar desatualizado.',

	'ERROR_COPY_FILE'                  => 'A tentativa de copiar o arquivo “%1$s” para a localização “%2$s” falhou.',
	'ERROR_CREATE_DIRECTORY'           => 'A tentativa de criar a pasta “%s” falhou.',
	'ERROR_REMOVE_DIRECTORY'           => 'A tentativa de remover a pasta “%s” falhou.',
	'ERROR_CHECKSUM_MISMATCH'          => 'O hash %s do arquivo carregado difere do checksum fornecido. O arquivo não foi guardado no servidor.',
	'ERROR_ZIP_NO_COMPOSER'            => 'O composer.json não foi encontrado no pacote zip solicitado.',
	'ERROR_DIRECTORIES_NOT_RESTORED'   => 'O processo de restauro não pôde ser concluído devido a erros.',
	'ERROR_LANGUAGE_UNKNOWN_STRUCTURE' => 'A estrutura do pacote de idioma carregado não é reconhecida. O arquivo não foi guardado no servidor.',
	'ERROR_LANGUAGE_NO_EXTENSION'      => 'O nome da extensão não está especificado para o pacote de idioma.',
	'ERROR_LANGUAGE_NOT_DEFINED'       => 'O código ISO do idioma deve ser definido para o carregamento adequado do pacote de idioma. Por favor, preencha o campo obrigatório do formulário e tente novamente.',

	'ACP_UPLOAD_EXT_DIR'         => 'Caminho de armazenamento dos pacotes zip das extensões',
	'ACP_UPLOAD_EXT_DIR_EXPLAIN' => 'Caminho a partir da sua pasta raiz do phpBB, ex. <samp>ext</samp>.<br />Você pode alterar este caminho para armazenar os pacotes zip numa pasta especial (por exemplo, se quiseres permitir que os usuários descarreguem esses arquivos, você pode alterá-lo para <em>downloads</em>, e se quiseres proibir essas descargas, você pode alterá-lo para o caminho que está um nível acima da raiz http do seu site (ou você pode criar uma pasta com o arquivo .htaccess apropriado)).',

	'ACP_UPLOAD_EXT_UPDATED'         => 'A extensão instalada foi atualizada.',
	'ACP_UPLOAD_EXT_UPDATED_EXPLAIN' => 'Você carregou um arquivo zip para uma extensão já instalada. Essa extensão <strong>foi desabilitada automaticamente</strong> para tornar o processo de atualização mais seguro. Agora, por favor <strong>verifique</strong> se os arquivos carregados estão corretos e <strong>habilite</strong> a extensão se ela ainda dever ser usada no fórum.',

	'ACP_UPLOAD_EXT_NO_CHECKSUM_TITLE' => 'Nenhum checksum foi fornecido para o arquivo carregado.',
	'ACP_UPLOAD_EXT_NO_CHECKSUM'       => 'O Carregar Extensões não conseguiu realizar verificações de segurança porque o <strong>checksum não foi fornecido</strong> para o arquivo zip carregado. O checksum é utilizado para garantir que o arquivo carregado não está corrompido nem comprometido.',

	'VALID_PHPBB_EXTENSIONS'            => 'Extensões validadas',
	'SHOW_VALID_PHPBB_EXTENSIONS'       => 'Mostrar extensões validadas',
	'VALID_PHPBB_EXTENSIONS_TITLE'      => 'Você pode baixar extensões validadas a partir da CDB no phpbb.com ou consultar as suas páginas oficiais.',
	'VALID_PHPBB_EXTENSIONS_EMPTY_LIST' => 'Nenhuma extensão está sendo sugerida no momento. Por favor, verifique se existem atualizações para o Carregar Extensões.',
	'POSSIBLE_SOLUTIONS'                => 'Soluções possíveis',

	'ACP_UPLOAD_EXT_MANAGER_EXPLAIN' => 'O Gestor de Extensões do Carregar Extensões é uma ferramenta no seu Fórum phpBB que lhe permite gerenciar todas as suas extensões e ver informação sobre as mesmas.',
	'ACP_UPLOAD_ZIP_TITLE'           => 'Gestão de arquivos ZIP',
	'ACP_UPLOAD_UNINSTALLED_TITLE'   => 'Apagar extensões',

	'EXT_DETAILS_README'    => 'Readme',
	'EXT_DETAILS_CHANGELOG' => 'Changelog',
	'EXT_DETAILS_LANGUAGES' => 'Idiomas',
	'EXT_DETAILS_FILETREE'  => 'Árvore de arquivos',
	'EXT_DETAILS_TOOLS'     => 'Ferramentas',

	'DEFAULT'                      => 'padrão',
	'EXT_LANGUAGE_ISO_CODE'        => 'Código ISO',
	'EXT_LANGUAGES'                => 'Pacotes de idioma carregados',
	'EXT_LANGUAGES_UPLOAD'         => 'Carregar um pacote de idioma',
	'EXT_LANGUAGES_UPLOAD_EXPLAIN' => 'Aqui você pode carregar um pacote zip contendo os arquivos de idioma necessários para esta extensão a partir do seu computador local ou de um servidor remoto. O “Carregar Extensões” irá então tentar descompactar os arquivos e movê-los para a localização correta.<br />Escolha um arquivo ou digite um link nos campos abaixo.<br />Não se esqueça de especificar o código ISO do idioma no campo correspondente abaixo (exemplo: <strong>pt_br</strong>).<br /><strong>IMPORTANTE!</strong> A pasta atual do idioma dessa extensão com esse código ISO será apagada se existir, <strong>nenhum arquivo zip será feito para ela</strong>.',
	'EXT_LANGUAGE_UPLOADED'        => 'O pacote de idioma “%s” foi carregado com sucesso.',
	'EXT_LANGUAGE_DELETE_CONFIRM'  => 'Tem a certeza de que desejas apagar o pacote de idioma “%s”?',
	'EXT_LANGUAGES_DELETE_CONFIRM' => [
		2 => 'Tem a certeza de que desejas apagar <strong>%1$s</strong> pacotes de idioma?',
	],
	'EXT_LANGUAGE_DELETE_SUCCESS'  => 'O pacote de idioma da extensão foi apagado com sucesso.',
	'EXT_LANGUAGES_DELETE_SUCCESS' => 'Os pacotes de idioma da extensão foram apagados com sucesso.',
	'EXT_LANGUAGE_DELETE_ERROR'    => 'Nenhum arquivo especificado ou ocorreu um erro durante a eliminação.',

	'EXT_TOOLS_DOWNLOAD_TITLE'         => 'Baixar extensão empacotada',
	'EXT_TOOLS_DOWNLOAD'               => 'Você pode baixar um arquivo ZIP adequadamente empacotado da extensão para o seu PC. Você pode também optar por apagar o sufixo da versão de desenvolvimento (ex. para encurtar o tempo de preparação da extensão para a CDB).',
	'EXT_TOOLS_DOWNLOAD_DELETE_SUFFIX' => 'Apagar o sufixo de desenvolvimento, caso exista',
	'EXT_DOWNLOAD_ERROR'               => 'A tentativa de baixar a extensão “%s” falhou.',

	'EXT_LOAD_ERROR'         => 'Ocorreu um erro no carregamento',
	'EXT_LOAD_TIMEOUT'       => 'O carregamento excedeu o tempo limite',
	'EXT_LOAD_ERROR_EXPLAIN' => 'Ocorreu um erro durante o processo de carregamento.',
	'EXT_LOAD_ERROR_SHOW'    => 'Mostrar os erros ocorridos',
	'EXT_LOAD_SOLUTIONS'     => 'Por favor, verifique os arquivos de registro (log) de erros no seu servidor, elimine o problema e tente novamente.',

	'UPLOAD_DESCRIPTION_UPLOAD'         => 'Carregar extensões phpBB',
	'UPLOAD_DESCRIPTION_UPLOAD_CDB'     => 'CDB em phpbb.com',
	'UPLOAD_DESCRIPTION_UPLOAD_LOCAL'   => 'PC Local',
	'UPLOAD_DESCRIPTION_UPLOAD_REMOTE'  => 'Servidor remoto',
	'UPLOAD_DESCRIPTION_UPDATE'         => 'Atualizar extensões phpBB',
	'UPLOAD_DESCRIPTION_UPDATE_ABOUT'   => 'Você pode atualizar qualquer uma das extensões já carregadas. A extensão que pretendes atualizar será desabilitada automaticamente para que quaisquer atualizações sejam seguras.',
	'UPLOAD_DESCRIPTION_MANAGE'         => 'Gerir extensões phpBB',
	'UPLOAD_DESCRIPTION_MANAGE_ACTIONS' => 'Instalar/desinstalar quaisquer extensões',
	'UPLOAD_DESCRIPTION_MANAGE_LANG'    => 'Carregar e gerir os pacotes de idioma das extensões',
	'UPLOAD_DESCRIPTION_MANAGE_DETAILS' => 'Ver os detalhes e as árvores de arquivos',
	'UPLOAD_DESCRIPTION_DESIGN'         => 'Interface interativa',
	'UPLOAD_DESCRIPTION_DESIGN_ABOUT'   => 'Você pode executar ações mais rapidamente devido à funcionalidade JavaScript. Mensagens coloridas e dicas ajudarão você a tomar as decisões corretas.',
	'UPLOAD_DESCRIPTION_ZIP'            => 'Gestão de arquivos ZIP',
	'UPLOAD_DESCRIPTION_ZIP_SAVE'       => 'Guardar os arquivos zip numa pasta à sua escolha',
	'UPLOAD_DESCRIPTION_ZIP_UNPACK'     => 'Descompactar um arquivo zip para instalar uma extensão',
	'UPLOAD_DESCRIPTION_ZIP_DOWNLOAD'   => 'Baixar pacotes zip adequados de extensões',
	'UPLOAD_DESCRIPTION_CLEANER'        => 'Ferramenta de Limpeza de Extensões',
	'UPLOAD_DESCRIPTION_CLEANER_ABOUT'  => 'Você pode apagar as pastas das extensões ou os arquivos zip de extensões do servidor.',
]);
