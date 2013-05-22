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

use MrPrompt\Cielo\Requisicao\SolicitacaoTransacao;

use MrPrompt\Cielo\Requisicao\IdentificacaoTransacao;

use MrPrompt\Cielo\Requisicao\Consulta;

use MrPrompt\Cielo\Requisicao\Captura;

use MrPrompt\Cielo\Requisicao\CancelamentoTransacao;
use MrPrompt\Cielo\Requisicao\AutorizacaoTransacao;
use MrPrompt\Cielo\Requisicao\AutorizacaoPortador;
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
     * @param Autorizacao $autorizacao
     * @param Client $httpClient
     */
    public function __construct(
        Autorizacao $autorizacao,
        Client $httpClient = null
    ) {
        $this->autorizacao = $autorizacao;
        $this->httpClient = $httpClient ?: new Client();
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
     * @access public
     * @param Transacao $transacao
     * @param Cartao $cartao
     * @param string $urlRetorno
     * @return SolicitacaoTransacao
     */
    public function transacao(Transacao $transacao, Cartao $cartao, $urlRetorno)
    {
        return $this->enviaRequisicao(
            new SolicitacaoTransacao(
                $this->autorizacao,
                $transacao,
                $cartao,
                $urlRetorno,
                $this->idioma
            )
        );
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
     * @access public
     * @param Transacao $transacao
     * @return AutorizacaoTransacao
     */
    public function autoriza(Transacao $transacao)
    {
        return $this->enviaRequisicao(
            new AutorizacaoTransacao($this->autorizacao, $transacao)
        );
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
     * @access public
     * @param Transacao $transacao
     * @return Captura
     */
    public function captura(Transacao $transacao)
    {
        return $this->enviaRequisicao(
            new Captura($this->autorizacao, $transacao)
        );
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
     * @access public
     * @param Transacao $transacao
     * @return CancelamentoTransacao
     */
    public function cancela(Transacao $transacao)
    {
        return $this->enviaRequisicao(
            new CancelamentoTransacao($this->autorizacao, $transacao)
        );
    }

    /**
     * Consulta
     *
     * Funcionalidade de extrema importância na integração.
     * É através dela que a loja virtual obtém uma “foto” da transação.
     * É sempre utilizada após a loja ter recebido o retorno do fluxo da Cielo.
     *
     * @access public
     * @param Transacao $transacao
     * @return Consulta
     */
    public function consulta(Transacao $transacao)
    {
        return $this->enviaRequisicao(
            new Consulta($this->autorizacao, $transacao)
        );
    }

    /**
     * TID
     *
     * Requisita um TID (Identificador de transação) ao Web Service
     *
     * @access public
     * @param Transacao $transacao
     * @param Cartao $cartao
     * @return IdentificacaoTransacao
     */
    public function tid(Transacao $transacao, Cartao $cartao)
    {
        return $this->enviaRequisicao(
            new IdentificacaoTransacao($this->autorizacao, $transacao, $cartao)
        );
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
     * @param Transacao $transacao
     * @param Cartao $cartao
     * @access public
     * @return AutorizacaoPortador
     */
    public function autorizaPortador(Transacao $transacao, Cartao $cartao)
    {
        return $this->enviaRequisicao(
            new AutorizacaoPortador(
                $this->autorizacao,
                $transacao,
                $cartao,
                $this->idioma
            )
        );
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

        return $requisicao;
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
