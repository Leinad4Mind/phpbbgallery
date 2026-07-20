<?php

/**
 * Cloudflare IP
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'ACP_CLOUDFLARE'         => 'CloudFlare IP',
	'ACP_CLOUDFLARE_EXPLAIN' => 'Bem-vindo às definições do CloudFlare. Depois de introduzir o seu email, a Chave de API (API Key) e o Domínio do CloudFlare, será possível definir/ajustar o modo de desenvolvimento e limpar a cache a partir deste local.',
	'SS_HELPER_NOTY'         => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'CLOUDFLARE_NOTICE'      => '<div class="phpinfo"><p>Não existem definições específicas para esta extensão. Os endereços de IP encontram-se agora todos normalizados e os que surgirem serão IPs reais dos utilizadores. Divirta-se!<br />Poderá ser expulso ou deslogado do seu ACP após sair ou afastar-se desta página. Isto é uma atitude perfeitamente normal, visto que o seu IP actual encontra-se no processo de normalização. Caso isso lhe venha acontecer bastará que inicie a sua sessão de novo e faça Login.<br />As configurações da API do CloudFlare estão por debaixo do separador <strong>ACP &#62; EXTENSÕES</strong> e uma vez inseridas todas as informações relativas da sua API então lhe será dada a possibilidade de efectuar uma limpeza à cache do CF (CloudFlare) de modo mais direto através do separador <strong>ACP &#62; GERAL</strong>. Usufrua disto com grande agrado!</p></div>',

	'CLOUDFLARE_FETCH_FAILED'        => 'Incapaz de extrair e obter os dados do CloudFlare. Por favor, verifique o seu email, a sua chave de API (API key) e respetivo domínio. Erros de devolução perante o CloudFlare:<br><br>%s',
	'CLOUDFLARE_SETTINGS_SAVED'      => 'As definições locais perante o CloudFlare foram guardadas.',
	'CLOUDFLARE_DEV_MODE_FAILED'     => 'A alteração para com o Modo de Desenvolvimento do CloudFlare obteve insucesso:<br><br>%s.',
	'CLOUDFLARE_DEV_MODE_SUCCESS'    => 'A alteração para com o Modo de Desenvolvimento do CloudFlare culminou num sucesso.',
	'CLOUDFLARE_CLEAR_CACHE_FAILED'  => 'A limpeza à cache do CloudFlare obteve insucesso:<br><br>%s.',
	'CLOUDFLARE_CLEAR_CACHE_SUCCESS' => 'A limpeza à cache do CloudFlare culminou num sucesso.',

	'CLOUDFLARE_EMAIL'                    => 'Email da conta do CloudFlare',
	'CLOUDFLARE_API_KEY'                  => 'Chave API (Global API Key)',
	'CLOUDFLARE_API_KEY_EXPLAIN'          => 'Inicie a sua sessão com a devida autenticação efetuando o Login na sua conta do CloudFlare e visite a respetiva página de perfil associada com a Conta (Account). Aí, nessa mesma página associada ao que respeita perante a visão geral "Overview", irá encontrar situado num canto ao fundo do lado direito uma secção indicativa para que veja "API". Carregue de modo a avançar face à dita ligação designada que vai encontrar num endereço remetido como "Get your API key (Obtenha a sua chave API)". Nesse mesmo passo seguinte por debaixo das opções e indicações aí dispostas deverá procurar e clicar em ver no botão da "Global API Key". Assim que vir por debaixo as referências e a respetiva indicação das Chaves API geradas bastará na mesma selecionar e copiar toda essa exata codificação exposta e que lhe foi dada pelo painel e depois de efectuado isso colar/introduzir as referências e informações aqui neste preciso campo.',
	'CLOUDFLARE_DOMAIN'                   => 'Domínio (Domain)',
	'CLOUDFLARE_DOMAIN_EXPLAIN'           => 'Insira o domínio base associado ao seu Fórum que introduziu ou utilizou na entrada respectiva perante o CF (CloudFlare) (Atenção em que lhe chamamos ao facto de nesta opção apenas é exigida e pedida simplesmente o exato e mero endereço de domínio sem os complementos totais (http:// ou https://) e a inserção dos vulgares protocolos perante endereços ou url base neste parâmetro de configuração não são requeridos nem necessários de inserir para surtirem efeito). Muitas das vezes o seu aspeto resulta vulgarmente numa designação como um simples exemplo de: "meudominio.com".',
	'CLOUDFLARE_DEVELOPMENT_MODE'         => 'Modo de Desenvolvimento (Development Mode)',
	'CLOUDFLARE_DEVELOPMENT_MODE_EXPLAIN' => 'A Ativação em relação ao Modo de Desenvolvimento do CloudFlare de modo sumário permite-lhe providenciar a título estritamente ou numa forma temporária que possa entrar neste devido estado no respetivo site/fórum caso tenha de estar constantemente num entra e sai para ter de efectuar modificações nos seus conteúdos e prever rapidamente os mesmos online. Por intermédio disto este modo conseguirá com que consiga escapar de ser sujeito a dar a volta evitando e contornando a rapidez estipulada em que os dados são captados pela cache base (CloudFlare\'s accelerated cache), o que por conseguinte também terá um ligeiro impacto nas exibições em virtude para a sua normal velocidade/aceleramento tornando ou tornando o site mais lento e abrandando o seu carregamento e a capacidade de processamento, mas revela e traduz-se noutros propósitos em utilidades se estiver a tentar levar a avante alterações com conteúdos mais baseados perante os respetivos da sua cache em constantes actualizações (tais e ou como de exemplo nas constantes substituições e envios baseados em imagens estáticas ou com edições do css, ou mesmo na programação face ao JavaScript) e se pretendia prever em tempo real o aspeto dos mesmos e a ter o vislumbre dessas tais alterações perfeitamente de modo linear nos tempos exatos consoante as suas intervenções sem atrasos perante o aspeto da base na versão estática armazenada.',
	'CLOUDFLARE_CLEAR_CACHE'              => 'Limpar/Esvaziar Toda a Cache (Clear Cache)',
	'CLOUDFLARE_CLEAR_CACHE_EXPLAIN'      => 'Remover/esvaziar em absoluto com TODO e qualquer (ALL) ficheiro na totalidade do sistema em que é base e constituição proveniente e se preveja de encontrar alojada nos respetivos locais armazenados que ditam para a cache do sistema (CloudFlare\'s cache)',

	'CLOUDFLARE_CF_CLEAR_CACHE' => 'Limpar ou esvaziar cache alojada do CloudFlare',

	'LOG_PURGE_CLOUDFLARE_CACHE' => '<strong>A purgar/limpar a cache e o armazenamento local do seu CloudFlare</strong>',
]);
