<?php
/**
 * Cliente
 *
 * Cliente para o Web Service da Cielo.
 *
 * O Web Service permite efetuar vendas com cartões de crédito de várias 
 * bandeiras, homologadas pela Cielo.
 * Com a integração, é possível efetuar vendas através do crédito ou 
 * débito, em compras a vista ou parceladas.
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

use GuzzleHttp\Client;
use MrPrompt\Cielo\Idioma\Idioma;
use MrPrompt\Cielo\Idioma\Portugues;
use MrPrompt\Cielo\Ambiente\Ambiente;
use MrPrompt\Cielo\Ambiente\Producao;
use MrPrompt\Cielo\Requisicao\Captura;
use MrPrompt\Cielo\Requisicao\Consulta;
use MrPrompt\Cielo\Requisicao\Requisicao;
use MrPrompt\Cielo\Requisicao\SolicitacaoToken;
use MrPrompt\Cielo\Requisicao\AutorizacaoPortador;
use MrPrompt\Cielo\Requisicao\AutorizacaoTransacao;
use MrPrompt\Cielo\Requisicao\SolicitacaoTransacao;
use MrPrompt\Cielo\Requisicao\CancelamentoTransacao;
use MrPrompt\Cielo\Requisicao\IdentificacaoTransacao;

use MrPrompt\Cielo\Retorno\Traits\Serializer;
use MrPrompt\Cielo\Retorno\Transacao as RetornoTransacao;
use MrPrompt\Cielo\Retorno\Tid as RetornoTid;
use MrPrompt\Cielo\Retorno\Autorizacao as RetornoAutorizacao;
use MrPrompt\Cielo\Retorno\Token as RetornoToken;

/**
 * Cliente de integração com a Cielo
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class Cliente
{
    use Serializer;

    /**
     * Dados de autorização na Cielo
     *
     * @var Autorizacao
     */
    private $autorizacao;

    /**
     * Idioma do pedido
     *
     * Com base nessa informação é definida a língua a ser utilizada nas telas da Cielo.
     *
     * @var Idioma
     */
    private $idioma;

    /**
     * Ambiente (teste ou produção)
     *
     * @var Ambiente
     */
    private $ambiente;

    /**
     * Cliente Http a ser utilizado
     *
     * @var Client
     */
    private $httpClient;

    /**
     * Versão do web service em uso pelo cliente.
     *
     * @const float
     */
    const VERSAO = '1.2.0';

    /**
     * Construtor da aplicação
     *
     * @access public
     * @param Autorizacao $autorizacao
     * @param Client      $httpClient
     * @param Idioma      $idioma
     * @param Ambiente    $ambiente
     */
    public function __construct(
        Autorizacao $autorizacao,
        Client $httpClient = null,
        Idioma $idioma = null,
        Ambiente $ambiente = null
    ) {
        $this->autorizacao  = $autorizacao;
        $this->httpClient   = $httpClient ?: new Client();
        $this->idioma       = $idioma ?: new Portugues();
        $this->ambiente     = $ambiente ?: new Producao();
    }

    /**
     * Transacao
     *
     * Inicia uma transação de venda, retornando seu TID e demais valores
     *
     * @access public
     * @param  Transacao            $transacao
     * @param  Cartao               $cartao
     * @param  string               $urlRetorno
     * @return RetornoTransacao
     */
    public function iniciaTransacao(Transacao $transacao, Cartao $cartao, $urlRetorno): object
    {
        $solicitacao = new SolicitacaoTransacao(
            $this->autorizacao,
            $transacao,
            $cartao,
            $urlRetorno,
            $this->idioma
        );

        $resposta = $this->enviaRequisicao($solicitacao);

        return $this->deserialize($resposta, RetornoTransacao::class);
    }

    /**
     * Solicita Token
     *
     * Solicita um Token para trasações futuras com um determinado Cartão de Crédito
     *
     * @access public
     * @param  Cartao $cartao
     * @return RetornoToken
     */
    public function solicitaToken(Transacao $transacao, Cartao $cartao): object
    {
        $solicitacao = new SolicitacaoToken($this->autorizacao, $transacao, $cartao);
        $resposta = $this->enviaRequisicao($solicitacao);

        return $this->deserialize($resposta, RetornoToken::class);
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
     * @param  Transacao            $transacao
     * @return RetornoAutorizacao
     */
    public function autoriza(Transacao $transacao): object
    {
        $autorizacao = new AutorizacaoTransacao($this->autorizacao, $transacao);
        $resposta = $this->enviaRequisicao($autorizacao);

        return $this->deserialize($resposta, RetornoAutorizacao::class);
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
     * @param  Transacao $transacao
     * @return RetornoCaptura
     */
    public function captura(Transacao $transacao): object
    {
        $captura = new Captura($this->autorizacao, $transacao);
        $resposta = $this->enviaRequisicao($captura);

        return $this->deserialize($resposta, RetornoCaptura::class);
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
     * @param  Transacao             $transacao
     * @return RetornoAutorizacao
     */
    public function cancela(Transacao $transacao): object
    {
        $cancelamento = new CancelamentoTransacao($this->autorizacao, $transacao);
        $resposta = $this->enviaRequisicao($cancelamento);

        return $this->deserialize($resposta, RetornoAutorizacao::class);
    }

    /**
     * Consulta
     *
     * Funcionalidade de extrema importância na integração.
     * É através dela que a loja virtual obtém uma “foto” da transação.
     * É sempre utilizada após a loja ter recebido o retorno do fluxo da Cielo.
     *
     * @access public
     * @param  Transacao $transacao
     * @return RetornoTransacao
     */
    public function consulta(Transacao $transacao): object
    {
        $consulta = new Consulta($this->autorizacao, $transacao);
        $resposta = $this->enviaRequisicao($consulta);

        return $this->deserialize($resposta, RetornoTransacao::class);
    }

    /**
     * TID
     *
     * Requisita um TID (Identificador de transação) ao Web Service
     *
     * @access public
     * @param  Transacao              $transacao
     * @param  Cartao                 $cartao
     * @return RetornoTid
     */
    public function tid(Transacao $transacao, Cartao $cartao): object
    {
        $requisicao = new IdentificacaoTransacao($this->autorizacao, $transacao, $cartao);
        $resposta = $this->enviaRequisicao($requisicao);
        
        return $this->deserialize($resposta, RetornoTid::class);
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
     * @param Cartao    $cartao
     * @access public
     * @return RetornoAutorizacao
     */
    public function autorizaPortador(Transacao $transacao, Cartao $cartao): object
    {
        $autorizacao = new AutorizacaoPortador(
            $this->autorizacao,
            $transacao,
            $cartao,
            $this->idioma
        );

        $resposta = $this->enviaRequisicao($autorizacao);

        return $this->deserialize($resposta, RetornoAutorizacao::class);
    }

    /**
     * Realiza o envio da requisição à Cielo
     *
     * @param Requisicao $requisicao
     * @return Transacao
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function enviaRequisicao(Requisicao $requisicao): String
    {
        $response = $this
            ->httpClient
            ->request(
                'POST',
                $this->ambiente->getUrl(),
                [
                    'form_params' => [
                        'mensagem' => $requisicao->getEnvio()->asXML()
                    ]
                ]
            );

        $requisicao->setResposta($response->getBody()->getContents());

        return $requisicao->getResposta();
    }
}
