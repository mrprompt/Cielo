<?php
/**
 * Cielo
 *
 * Cliente para o Web Service da Cielo.
 *
 * O Web Service permite efetuar vendas com cartões de bandeira
 * VISA e Mastercard, tanto no débito quanto em compras a vista ou parceladas.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo
 * @subpackage Cliente
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2013
 * @license    GPL-3.0+
 */
namespace MrPrompt\Cielo;

use MrPrompt\Cielo\Requisicao\AutorizacaoTransacao;
use MrPrompt\Cielo\Requisicao\Requisicao;
use MrPrompt\Cielo\Cliente\Exception;
use Guzzle\Http\Client;
use SimpleXMLElement;

/**
 * Cliente de integração com a Cielo
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class Cliente
{
    /**
     * URL de retorno para a página da loja
     *
     * @var string
     */
    private $urlRetorno;

    /**
     * Dados de autorização na Cielo
     *
     * @var Autorizacao
     */
    private $autorizacao;

    /**
     * XML da menasgem de chamada ao serviço
     *
     * @var SimpleXMLElement
     */
    private $xml;

    /**
     * Idioma do pedido
     *
     * PT (português)
     * EN (inglês)
     * ES (espanhol).
     *
     * Com base nessa informação é definida a
     * língua a ser utilizada nas telas da Cielo.
     * Caso não preenchido, assume-se PT.
     *
     * @var string
     */
    private $idioma = 'PT';

    /**
     * Ambiente (teste ou producao)
     *
     * Default: producao
     *
     * @var string
     */
    private $ambiente = 'producao';

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * Identificador de chamada do tipo transacao
     *
     * @const integer
     */
    const TRANSACAO_ID     = 1;

    /**
     * Cabeçalho xml de chamada do tipo transacao
     *
     * @const string
     */
    const TRANSACAO_HEADER = 'requisicao-transacao';

    /**
     * Identificador para transação de captura
     *
     * @const integer
     */
    const CAPTURA_ID = 3;

    /**
     * Cabeçalho xml para transação de captura
     *
     * @const string
     */
    const CAPTURA_HEADER = 'requisicao-captura';

    /**
     * Identificador de chamada do tipo cancelamento
     *
     * @const integer
     */
    const CANCELAMENTO_ID = 4;

    /**
     * Cabeçalho xml de chamada do tipo cancelamento
     *
     * @const string
     */
    const CANCELAMENTO_HEADER = 'requisicao-cancelamento';

    /**
     * Identificador de chamada do tipo consulta
     *
     * @const integer
     */
    const CONSULTA_ID = 5;

    /**
     * Cabeçalho xml de chamada do tipo consulta
     *
     * @const string
     */
    const CONSULTA_HEADER = 'requisicao-consulta';

    /**
     * Identificador de chamada para requisição de um TID
     *
     * @const integer
     */
    const TID_ID = 6;

    /**
     * Cabeçalho xml de chamada para requisição de um TID
     *
     * @const string
     */
    const TID_HEADER = 'requisicao-tid';

    /**
     * Transação com autorização ao portador
     *
     * @const integer
     */
    const AUTORIZACAO_PORTADOR_ID = 7;

    /**
     * Cabeçalho xml da chamada de captura com autorização ao portador
     *
     * @const string
     */
    const AUTORIZACAO_PORTADOR_HEADER = 'requisicao-autorizacao-portador';

    /**
     * Versão do web service em uso pelo cliente.
     *
     * @const float
     */
    const VERSAO = '1.1.0';

    /**
     * Construtor da aplicação
     *
     * Aqui é configurada o número e a chave de acesso do afiliado a Cielo
     *
     * @access public
     * @param  integer $numero
     * @param  mixed $chave
     */
    public function __construct(
        Autorizacao $autorizacao,
        Client $httpClient = null
    ) {
        $this->autorizacao = $autorizacao;
        $this->httpClient = $httpClient ?: new Client();
    }

    /**
     * Retorna a URL de Retorno setada para a transação
     *
     * @acess public
     * @return string
     */
    public function getUrlRetorno()
    {
        return $this->urlRetorno;
    }

    /**
     * Define a URL de Retorno da transação
     *
     * @access public
     * @param  string $url
     * @return Cielo
     */
    public function setUrlRetorno($url = null)
    {
        $valida = filter_var(
            $url,
            FILTER_VALIDATE_URL,
            FILTER_FLAG_SCHEME_REQUIRED
        );

        if ($valida == false) {
            throw new Exception('URL de retorno inválida.');
        }

        $this->urlRetorno = substr($url, 0, 1024);

        return $this;
    }

    /**
     * Retorna o último XML configurado
     *
     * @access public
     * @return SimpleXMLElement
     */
    public function getXML()
    {
        return $this->xml;
    }

    /**
     * Retorna o idioma da venda
     *
     * @access public
     * @return string
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * Idioma do pedido
     *
     * PT (português)
     * EN (inglês)
     * ES (espanhol).
     *
     * Com base nessa informação é definida a
     * língua a ser utilizada nas telas da Cielo.
     * Caso não preenchido, assume-se PT.
     *
     * @access public
     * @param  string $idioma
     * @return Cielo
     */
    public function setIdioma($idioma)
    {
        switch ($idioma) {
            case 'PT':
            case 'EN':
            case 'ES':
                $this->idioma = $idioma;

                return $this;
            default:
                throw new Exception('Idioma inválido.');
        }
    }

    /**
     * Retorna o ambiente utilizado para as chamadas de transação
     *
     * @access public
     * @return string
     */
    public function getAmbiente()
    {
        return $this->ambiente;
    }

    /**
     * Configura o ambiente a ser utilizado nas chamadas de transações
     *
     * @access public
     * @param  string $ambiente teste | produção (default)
     * @return Cielo
     */
    public function setAmbiente($ambiente)
    {
        switch ($ambiente) {
            case 'teste':
            case 'produção':
            case 'producao':
                $this->ambiente = $ambiente;

                return $this;
            default:
                throw new Exception('Ambiente inválido.');
        }
    }

    /**
     * Seta o caminho para o arquivo certificado SSL (ex.: certificado.crt)
     *
     * @access public
     * @param  string $sslCertificate
     * @return Cielo
     */
    public function setSslCertificate($sslCertificate = '')
    {
        if (!is_string($sslCertificate)
            || (trim($sslCertificate) != '' && !is_readable($sslCertificate))) {
            throw new Exception('Parâmetro inválido.');
        }

        if ($sslCertificate != '') {
            $this->httpClient->setSslVerification(
                $sslCertificate,
                true,
                2
            );
        } else {
            $this->httpClient->setSslVerification(false);
        }

        return $this;
    }

    /**
     * Cria o nó com os dados de acesso.
     *
     */
    private function dadosEC()
    {
        $ec  = $this->xml->addChild('dados-ec', '');
        $ec->addChild('numero', $this->autorizacao->getNumero());
        $ec->addChild('chave', $this->autorizacao->getChave());
    }

    /**
     * Cria o nó com dados do portador do cartão de crédito
     *
     * @param \MrPrompt\Cielo\Cartao $cartao
     */
    private function dadosPortador(Cartao $cartao)
    {
        $dc = $this->xml->addChild('dados-portador', '');
        $dc->addChild('numero', $cartao->getCartao());
        $dc->addChild('validade', $cartao->getValidade());
        $dc->addChild('indicador', $cartao->getIndicador());
        $dc->addChild('codigo-seguranca', $cartao->getCodigoSeguranca());
        $dc->addChild('nome-portador', $cartao->getNomePortador());

        return $dc;
    }

    /**
     * Cria o nó com dados do portador do cartão de crédito
     *
     * @param \MrPrompt\Cielo\Cartao $cartao
     */
    private function dadosCartao(Cartao $cartao)
    {
        $dc = $this->xml->addChild('dados-cartao', '');
        $dc->addChild('numero', $cartao->getCartao());
        $dc->addChild('validade', $cartao->getValidade());
        $dc->addChild('indicador', $cartao->getIndicador());
        $dc->addChild('codigo-seguranca', $cartao->getCodigoSeguranca());
        $dc->addChild('nome-portador', $cartao->getNomePortador());

        return $dc;
    }

    /**
     * Cria os dados do pedido
     *
     * @param \MrPrompt\Cielo\Transacao $transacao
     * @return SimpleXMLElement
     */
    private function pedido(Transacao $transacao)
    {
        $dp = $this->xml->addChild('dados-pedido', '');
        $dp->addChild('numero', $transacao->getTid());
        $dp->addChild('valor', $transacao->getValor());
        $dp->addChild('moeda', $transacao->getMoeda());
        $dp->addChild('data-hora', $transacao->getDataHora());
        $dp->addChild('descricao', $transacao->getDescricao());
        $dp->addChild('idioma', $this->idioma);

        return $dp;
    }

    /**
     * Cria o nó com os campos de pagamento a serem utilizados pelo cliente.
     *
     * @param \MrPrompt\Cielo\Transacao $transacao
     * @param \MrPrompt\Cielo\Cartao $cartao
     */
    private function pagamento(Transacao $transacao, Cartao $cartao)
    {
        $fp  = $this->xml->addChild('forma-pagamento', '');
        $fp->addChild('bandeira', $cartao->getBandeira());
        $fp->addChild('produto', $transacao->getProduto());
        $fp->addChild('parcelas', $transacao->getParcelas());

        return $fp;
    }

    /**
     * Transacao
     *
     * Inicia uma transação de venda, retornando seu TID e demais valores
     *
     * @param Transacao $transacao
     * @param Cartao $cartao
     * @access public
     */
    public function transacao(Transacao $transacao, Cartao $cartao)
    {
        $xml = sprintf(
            '<%s id="%d" versao="%s"></%s>',
            self::TRANSACAO_HEADER,
            self::TRANSACAO_ID,
            self::VERSAO,
            self::TRANSACAO_HEADER
        );
        $this->xml = new SimpleXMLElement($xml);
        $this->dadosEC();
        $this->dadosPortador($cartao);
        $this->pedido($transacao);
        $this->pagamento($transacao, $cartao);
        $this->xml->addChild('url-retorno', $this->urlRetorno);
        $this->xml->addChild('autorizar', $transacao->getAutorizar());
        $this->xml->addChild('capturar', $transacao->getCapturar());
        $this->xml->addChild('campo-livre', '');
        $this->xml->addChild('bin', substr($cartao->getCartao(), 0, 6));
    }

    /**
     * Autorização
     *
     * Com base na resposta de autenticação, autenticada ou não-autenticada,
     * e nas escolhas efetuadas na criação da transação, a autorização é a
     * próxima etapa. Nesse cenário ela é cunhada de autorização automática.
     * Embora essa escolha caiba a loja virtual, em conjunto são consideradas
     * outras regras:
     * - Se o portador não se autenticou com sucesso, ela não é executada
     * - Se o portador autenticou-se com sucesso, ela pode ser executada
     * - Se o emissor não forneceu mecanismos de autenticação, ela pode ser
     *   executada
     * - Se a resposta do emissor não pôde ser validada, ela não é executada
     *
     * Nota: é nessa etapa que o saldo disponível do cartão do comprador é
     * sensibilizado caso a transação tenha sido autorizada.
     *
     * @param \MrPrompt\Cielo\Transacao $transacao
     * @access public
     */
    public function autoriza(Transacao $transacao)
    {
        $requisicao = new AutorizacaoTransacao(
            $this->autorizacao,
            $transacao
        );

        $this->enviaRequisicao($requisicao);

        return $requisicao;
    }

    /**
     * Captura
     *
     * Uma transação autorizada somente gera crédito para o estabelecimento
     * comercial caso ela seja capturada. Por isso, todo pedido de compra que
     * o lojista queira efetivar, deve ter a transação capturada.
     *
     * Para venda na modalidade de Crédito, essa confirmação pode ocorrer
     * - Logo após a autorização (valor total)
     * - Ou num momento posterior (valor total ou parcial)
     *
     * Essa definição é feita através do parâmetro capturar. Já na modalidade
     * de Débito não existe essa abertura: toda transação de débito autorizada
     * é automaticamente capturada.
     *
     * @param \MrPrompt\Cielo\Transacao $transacao
     * @access public
     */
    public function captura(Transacao $transacao)
    {
        $xml = sprintf(
            '<%s id="%d" versao="%s"></%s>',
            self::CAPTURA_HEADER,
            self::CAPTURA_ID,
            self::VERSAO,
            self::CAPTURA_HEADER
        );
        $this->xml = new SimpleXMLElement($xml);
        $this->xml->addChild('tid', $transacao->getTid());
        $this->dadosEC();
    }

    /**
     * Cancelamento
     *
     * É empregado quando o lojista decide não efetivar um pedido de compra,
     * seja por insuficiência de estoque, desistência da compra, entre outros
     * motivos. Seu uso faz-se necessário principalmente se a transação estiver
     * capturada, caso contrário haverá débito na fatura do cliente para um
     * pedido de compra não efetivado.
     *
     * Nota: se a transação estiver apenas autorizada e a loja queira
     * cancelá-la, o pedido de cancelamento não é de fato necessário:
     * vencido o prazo de captura, ela é cancelada automaticamente.
     *
     * @param \MrPrompt\Cielo\Transacao $transacao
     * @access public
     */
    public function cancelamento(Transacao $transacao)
    {
        $xml = sprintf(
            '<%s id="%d" versao="%s"></%s>',
            self::CANCELAMENTO_HEADER,
            self::CANCELAMENTO_ID,
            self::VERSAO,
            self::CANCELAMENTO_HEADER
        );
        $this->xml = new SimpleXMLElement($xml);
        $this->xml->addChild('tid', $transacao->getTid());
        $this->dadosEC();
    }

    /**
     * Consulta
     *
     * Funcionalidade de extrema importância na integração.
     * É através dela que a loja virtual obtém uma “foto” da transação.
     * É sempre utilizada após a loja ter recebido o retorno do fluxo da Cielo.
     *
     * @access public
     */
    public function consulta(Transacao $transacao)
    {
        $xml = sprintf(
            '<%s id="%d" versao="%s"></%s>',
            self::CONSULTA_HEADER,
            self::CONSULTA_ID,
            self::VERSAO,
            self::CONSULTA_HEADER
        );
        $this->xml = new SimpleXMLElement($xml);
        $this->xml->addChild('tid', $transacao->getTid());
        $this->dadosEC();
    }

    /**
     * TID
     *
     * Requisita um TID (Identificador de transação) ao Web Service
     *
     * @param \MrPrompt\Cielo\Transacao $transacao
     * @param \MrPrompt\Cielo\Cartao $cartao
     * @access public
     * @return SimpleXMLElement
     */
    public function tid(Transacao $transacao, Cartao $cartao)
    {
        $xml = sprintf(
            '<%s id="%d" versao="%s"></%s>',
            self::TID_HEADER,
            self::TID_ID,
            self::VERSAO,
            self::TID_HEADER
        );
        $this->xml = new SimpleXMLElement($xml);
        $this->dadosEC();
        $this->pagamento($transacao, $cartao);
    }

    /**
     * Autorização Direta
     *
     * É o pedido de autorização sem autenticação.
     * É aquela que a loja virtual solicita os dados do cartão em seu
     * próprio ambiente e submete um pedido de autorização. Dessa forma o
     * lojista deve estar atento as regras de segurança.
     *
     * Essa funcionalidade é executada em duas etapas: a primeira, para a
     * obtenção de um identificador e na outra, o pedido de autorização de
     * fato. Mas por que é necessário solicitar um TID? Essa informação é
     * uma forma de garantir que o portador não seja debitado mais de uma
     * vez. Na ocorrência de erros durante a autorização (um timeout, por
     * exemplo), a loja virtual deve consultar àquela transação (via TID)
     * antes de tentar submeter uma nova. Pois num caso como esse, há
     * possibilidade da transação ter sido autorizada.
     *
     * @param Transacao $trans
     * @param Cartao $cartao
     * @access public
     * @return SimpleXMLElement
     */
    public function autorizacaoPortador(Transacao $trans, Cartao $card)
    {
        $xml = sprintf(
            '<%s id="%d" versao="%s"></%s>',
            self::AUTORIZACAO_PORTADOR_HEADER,
            self::AUTORIZACAO_PORTADOR_ID,
            self::VERSAO,
            self::AUTORIZACAO_PORTADOR_HEADER
        );
        $this->xml = new SimpleXMLElement($xml);
        $this->xml
             ->addChild('tid', $trans->getTid());
        $this->dadosEC();
        $this->dadosCartao($card);
        $this->pedido($trans);
        $this->pagamento($trans, $card);
        $this->xml
             ->addChild('capturar-automaticamente', $trans->getCapturar());
        $this->xml
             ->addChild('campo-livre', '');
    }

    /**
     * Envia a chamada para o Web Service da Cielo
     *
     * @access public
     * @return SimpleXMLElement
     */
    public function enviaChamada()
    {
        if (!$this->xml instanceof SimpleXMLElement) {
            throw new Exception('XML não criado.');
        }

        // URL para o ambiente de produção
        $url = 'https://ecommerce.cbmp.com.br/servicos/ecommwsec.do';

        // URL para o ambiente de teste
        if ($this->ambiente === 'teste') {
            $url = 'https://qasecommerce.cielo.com.br/servicos/ecommwsec.do';
        }

        $request = $this->httpClient->post($url)
                                    ->addPostFields(array('mensagem' => $this->xml->asXML()));

        $response = $request->send();

        return $this->xml = $response->xml();
    }

    /**
     * Realiza o envio da requisição à Cielo
     *
     * @param Requisicao $requisicao
     */
    protected function enviaRequisicao(Requisicao $requisicao)
    {
        $request = $this->httpClient->post($this->getEndpoint())
                                    ->addPostFields(
                                        array(
                                            'mensagem' => $requisicao->getEnvio()->asXML()
                                        )
                                    );

        $requisicao->setResposta($request->send()->xml());
    }

    /**
     * Retorna o endereço de destino das requisições
     *
     * @return string
     */
    protected function getEndpoint()
    {
        if ($this->ambiente === 'teste') {
            return 'https://qasecommerce.cielo.com.br/servicos/ecommwsec.do';
        }

        return 'https://ecommerce.cbmp.com.br/servicos/ecommwsec.do';
    }
}
