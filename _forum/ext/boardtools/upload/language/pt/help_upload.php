<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 - 2019 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

// Some characters you may want to copy&paste:
// ’ » “ ” …

$help = array(
	array(
		0 => '--',
		1 => 'Módulos gerais'
	),
	array(
		0 => 'O que posso fazer com a funcionalidade “Carregar uma extensão”?',
		1 => 'Podes carregar extensões de várias fontes diferentes sem precisares de usar um cliente FTP. Quando carregas uma extensão que já existe no teu fórum, a versão antiga será automaticamente guardada na pasta especificada no teu fórum - verifica o módulo “Gestão Intensa de Ficheiros ZIP”. Podes também guardar um ficheiro zip da versão atualmente carregada - marca a opção “Guardar o pacote ZIP após extração” antes do processo. Podes garantir que estás a carregar o pacote verdadeiro se especificares o seu checksum no respetivo campo.'
	),
	array(
		0 => 'Qual a diferença entre o “Gestor do Carregar Extensões” e o “Gestor de Extensões” padrão do phpBB?',
		1 => 'Tal como o “Gestor de Extensões” padrão, este módulo é uma ferramenta que permite gerir todas as extensões e ver a sua informação. Mas pode ser encarado como uma “versão vitaminada” do módulo normal.<br /><br /><strong>Principais benefícios:</strong><ul><li>Todas as extensões carregadas são ordenadas alfabeticamente, quer estejam ativadas, desativadas ou desinstaladas. A única exceção: extensões corrompidas.</li><li>Extensões corrompidas aparecem separadamente no fundo da mesma página. São mostradas as razões para estarem indisponíveis e ser-te-á mostrado um alerta caso a extensão corrompida esteja instalada ou possua dados na base de dados. Podes clicar em qualquer extensão corrompida para ver os detalhes da mesma forma que as normais.</li><li>Qualquer extensão sã pode ser ativada com um simples clique no botão de alternar (toggle) que se encontra ao lado esquerdo do seu nome.</li></ul>'
	),
	array(
		0 => 'Para que preciso do módulo “Gestão Intensa de Ficheiros ZIP”?',
		1 => 'Por vezes é muito útil guardares um arquivo de versões antigas das tuas extensões para poderes reverter caso algo corra mal, ou até para partilhar os pacotes zip com outros. Estes arquivos podem ser versões geradas de forma automática pelo sistema, ou pacotes que tenhas selecionado salvaguardar ativamente. Podes extrair, transferir para ti, e apagar estes pacotes zip à vontade.'
	),
	array(
		0 => 'Como posso usar o módulo “Apagar fisicamente extensões”?',
		1 => 'O módulo permite-te remover os ficheiros e as pastas do teu servidor sem precisares do FTP. Quando já não precisas mesmo de uma extensão, podes varrê-la do mapa. Para o fazeres:<ul><li>Primeiro garante que não precisas mesmo da extensão. É recomendado teres backups caso decidas voltar atrás.</li><li>Depois vai ao Gestor, encontra a extensão e garante que está desativada (clicando no botão para ficar vermelho).</li><li>Garante que os dados da extensão também foram removidos da base de dados (se houver um ícone de caixote de lixo ativo, clica nele para purgar).</li><li>Finalmente vai a “Apagar fisicamente extensões”, clica no link “Apagar extensão” e diz adeus.</li></ul>'
	),
	array(
		0 => '--',
		1 => 'Processo de Carregamento'
	),
	array(
		0 => 'Como posso carregar extensões validadas oficiais da CDB do phpbb.com?',
		1 => 'Na página principal, clica em “Mostrar extensões oficiais validadas”. Seleciona a que queres e clica no botão para transferir. Jogo de palavras: a extensão será descarregada remotamente do site deles e carregada diretamente e automaticamente para as pastas do teu servidor!'
	),
	array(
		0 => 'Como fazer upload de recursos remotos?',
		1 => 'Copia o link <strong>direto</strong> para o pacote zip da extensão (geralmente terminará em <code>.zip</code>) e cola-o no campo de upload por link. Depois é só clicar no botão.'
	),
	array(
		0 => 'Como posso carregar a extensão que tenho aqui no meu PC?',
		1 => 'Clica no botão “Procurar...”, seleciona o ficheiro zip da extensão que descarregaste, e depois clica em “Carregar”.'
	),
	array(
		0 => 'Copiei o link, cliquei no botão, mas atirou-me um erro. O que se passa?',
		1 => 'Para poder ser carregado remotamente, garante o seguinte:<ol><li>O link tem de ser <strong>direto</strong>. Nada de links com adfly ou que levem para sites intermédios. (e deve terminar em <code>.zip</code>).</li><li>O link tem de levar mesmo ao <strong>ficheiro zipado</strong> em si, não à página que tem o botão de download dentro dela.</li></ol>'
	),
	array(
		0 => 'O que é o checksum? E de onde o arranjo?',
		1 => 'O Checksum é uma assinatura matemática usada para verificar a integridade do teu ficheiro. Confirma de forma segura que não há corrupção de ficheiros, perda de dados ou se hackers meteram código no zip pelo caminho. O Checksum costuma estar disponível na página principal de onde se saca a extensão.'
	),
	array(
		0 => '--',
		1 => 'O Gestor do Carregar Extensões'
	),
	array(
		0 => 'Como uso as manetes de Gestão?',
		1 => 'O estado de cada extensão é mostrado como um interruptor.<ul><li>Verde = ativada. Clicar lá vai <strong>desativar</strong> a extensão com rapidez.</li><li>Vermelho = desativada. Clicar lá vai <strong>ativar</strong> a extensão de volta no fórum.</li><li>Se a extensão estiver desligada mas não tiver sido expurgada da base de dados, vês um caixote de lixo ao lado dela. Ao clicares no caixote de lixo, todos os dados dessa extensão são apagados no servidor.</li></ul><br />Podes configurar atualizações e checar compatibilidade exatamente da mesma forma que no Gestor padrão do phpBB.'
	),
	array(
		0 => 'Extensões corrompidas ou estragadas. Dá para arrancar?',
		1 => 'Sim, óbvio! Extensões lixadas ou partidas são mandadas para o fundo da página, longe das extensões saudáveis. Se clicares na linha de uma extensão estragada, vais ver em detalhe a razão pela qual o fórum diz que está morta, para que possas resolver o problema ou eliminá-la de vez.'
	),
	array(
		0 => 'O botão interruptor está cinzento inativo. O que fiz eu?',
		1 => 'Botões cinzentos indicam que algo está bloqueado ou em processamento ativo. Ou o servidor ainda está a pensar no que mandaste fazer, ou estás a olhar para a própria extensão “Carregar Extensões”. O Upload Extensions não tem o poder de se suicidar e desativar-se a si próprio — por motivos óbvios de segurança.'
	),
	array(
		0 => '--',
		1 => 'Página de detalhes da extensão'
	),
	array(
		0 => 'Que informação é exumada para as extensões?',
		1 => 'Tudo o que possa ser útil:<ul><li>A descrição original do autor no <code>composer.json</code>.</li><li>A versão exata atual.</li><li>O conteúdo original do ficheiro <code>README.md</code>.</li><li>O registo de novidades no <code>CHANGELOG.md</code>.</li><li>Todos os pacotes de idiomas em vigor nessa extensão.</li><li>Toda a árvore hierárquica e navegação pelas pastas do código, onde podes espreitar todos os ficheiros da extensão.</li></ul>'
	),
	array(
		0 => 'Que poderes tenho dentro da página de detalhes?',
		1 => 'Podes fazer literalmente tudo:<ul><li>Ativar e desativar a extensão se clicares na rodela.</li><li>Purgar dados do servidor se a rodela vermelha tiver um ícone de caixote do lixo disponível.</li><li>Receber automaticamente o aviso de atualizações: se vires que a versão está numa bolha vermelha, a extensão está desatualizada. Podes clicar no ícone de atualização automática para ele extrair a nova versão sem abrires FTP!</li><li>Gerir idiomas e apagar ou instalar novos pacotes de idiomas zipados para a extensão ficar logo a falar pt-PT.</li><li>Transferir um backup zip da extensão com um clique.</li></ul>'
	),
	array(
		0 => 'Como meto idiomas nestas extensões?',
		1 => 'Temos um processo otimizado brutal que assimila ZIPs de traduções se estiverem estruturados desta forma:<ul><li><code>RAIZ_DO_ZIP/ficheiros_language_soltos</code>, ou</li><li><code>RAIZ_DO_ZIP/nome_da_pasta_unica/ficheiros_language_soltos</code>, ou</li><li><code>RAIZ_DO_ZIP/nome_da_pasta_unica/pt/ficheiros_language_soltos</code>.</li></ul>'
	),
	array(
		0 => 'O que faz o botão de “Descarregar a extensão empacotada”?',
		1 => 'Pega no código que tens dessa extensão atualmente instalada, com as tuas edições, e varre-a inteira num arquivo ZIP limpinho que podes descarregar para casa ou enviar para partilhar com os teus utilizadores.'
	),
	array(
		0 => '--',
		1 => 'Gestão Intensa de Ficheiros ZIP'
	),
	array(
		0 => 'Onde decido a morada em que o meu servidor guarda as preciosas cópias de segurança ZIP?',
		1 => 'Vai no ACP a <code>Geral -> Configuração do servidor -> Caminhos -> Caminho principal de arquivo onde os pacotes ZIP ficarão guardados</code>.'
	),
	array(
		0 => 'Como varro dezenas de zips velhos de uma assentada?',
		1 => 'Primeiro certifica-te que não vais precisar mais de reverter as extensões para versões antigas que estejas a tentar apagar. Em caso de certeza absoluta, vais à “Gestão de ZIPs”, marcas o Visinho nas linhas dos pacotes que queres queimar, clicas em “Apagar marcados” e tchau!'
	),
	array(
		0 => '--',
		1 => 'Ferramenta de Limpeza de Extensões'
	),
	array(
		0 => 'Mas que ferramenta é esta?',
		1 => 'A Ferramenta de Limpeza de Extensões é a secção fatal de "Apagar fisicamente extensões", que elimina fisicamente o código e apaga de vez as pastas da extensão dentro da pasta /ext/ do fórum.'
	),
	array(
		0 => 'Maldita extensão! Eu tento apagá-la daqui e o botão diz que não!',
		1 => 'Toda a extensão necessita de passar por um protocolo sagrado de desinstalação segura do phpBB antes de lhe poderes deitar fogo. Ou seja: Tens de a Desativar PRIMEIRO. Tens de a Purgar e apagar os dados dela da base de dados DEPOIS. E APENAS DEPOIS de a extensão estar desativada e morta na base de dados, é que lhe podes aplicar a ferramenta de limpeza e rebentar as pastas do teu servidor sem quebrar o fórum!'
	),
	array(
		0 => 'Tenho aqui muito lixo, posso apagar vários de rajada?',
		1 => 'Sim, da mesma forma brutal. Marca os quadrados correspondentes das vítimas a exterminar e aperta "Apagar marcados". <strong>As pastas desvanecerão do teu FTP na totalidade, portanto tem a certeza ou tem backups feitos do teu site!</strong>'
	),
	array(
		0 => '--',
		1 => 'Interface Dinâmica'
	),
	array(
		0 => 'Porque é que me falas nas maravilhas do JavaScript?',
		1 => 'Porque foi esse JavaScript que permitiu a revolução de não teres de fazer reload à página completa inteira do phpBB de cada vez que clicas num botão, além de carregar dicas coloridas de ajuda quando passas o rato.'
	),
);
