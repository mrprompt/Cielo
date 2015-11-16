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

use Guzzle\Http\Client;
use InvalidArgumentException;
use MrPrompt\Cielo\Requisicao\AutorizacaoPortador;
use MrPrompt\Cielo\Requisicao\AutorizacaoTransacao;
use MrPrompt\Cielo\Requisicao\CancelamentoTransacao;
use MrPrompt\Cielo\Requisicao\Captura;
use MrPrompt\Cielo\Requisicao\Consulta;
use MrPrompt\Cielo\Requisicao\IdentificacaoTransacao;
use MrPrompt\Cielo\Requisicao\Requisicao;
use MrPrompt\Cielo\Requisicao\SolicitacaoTransacao;
use MrPrompt\Cielo\Requisicao\SolicitacaoToken;
use Respect\Validation\Validator as v;

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
     * Ambiente (teste ou produção)
     *
     * Default: produção
     *
     * @var string
     */
    private $ambiente = 'produção';

    /**
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
     * Idiomas válidos
     *
     * @var array 
     */
    private $idiomas = array('PT', 'EN', 'ES');
    
    /**
     * Ambientes válidos
     * 
     * @var array
     */
    private $ambientes = array('teste', 'produção');

    /**
     * Opções de configuração do cURL.
     *
     * @var array
     */
    private $curlOpcoes = array(array('nome' => CURLOPT_SSLVERSION, 'valor' => 3));

    /**
     * Construtor da aplicação
     *
     * Aqui é configurada o número e a chave de acesso do afiliado a Cielo
     *
     * @access public
     * @param Autorizacao $autorizacao
     * @param Client      $httpClient
     */
    public function __construct(
        Autorizacao $autorizacao,
        Client $httpClient = null
    ) {
        $this->autorizacao = $autorizacao;
        $this->httpClient = $httpClient ?: new Client();
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
     * Com base nessa informação é definida a língua a ser utilizada nas telas 
     * da Cielo.
     * Caso não preenchido, assume-se PT.
     *
     * @param  string $idioma
     * @return Cielo
     */
    public function setIdioma($idioma)
    {
        $idioma = strtoupper($idioma);
        $regras = v::string()->notEmpty()
                             ->in($this->idiomas);
        
        if (!$regras->validate($idioma)) {
            throw new InvalidArgumentException(
                sprintf('Idioma inválido: %s.', $idioma)
            );
        }
        
        $this->idioma = $idioma;

        return $this;
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
     * @param  string                   $ambiente teste | produção (default)
     * @throws InvalidArgumentException
     * @return Cielo
     */
    public function setAmbiente($ambiente)
    {
        $regras = v::string()->notEmpty()
                             ->in($this->ambientes);
        
        if (!$regras->validate($ambiente)) {
            throw new InvalidArgumentException('Ambiente inválido.');
        }
        
        $this->ambiente = $ambiente;

        return $this;
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
            throw new InvalidArgumentException('Parâmetro inválido.');
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
     * Transacao
     *
     * Inicia uma transação de venda, retornando seu TID e demais valores
     *
     * @access public
     * @param  Transacao            $transacao
     * @param  Cartao               $cartao
     * @param  string               $urlRetorno
     * @return SolicitacaoTransacao
     */
    public function iniciaTransacao(Transacao $transacao, Cartao $cartao, $urlRetorno)
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
     * Solicita Token
     *
     * Solicita um Token para trasações futuras com um determinado Cartão de Crédito
     *
     * @access public
     * @param  Cartao               $cartao
     */
    public function solicitaToken(Transacao $transacao, Cartao $cartao)
    {
        return $this->enviaRequisicao(
            new SolicitacaoToken($this->autorizacao, $transacao, $cartao)
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
     * @param  Transacao            $transacao
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
     * @param  Transacao $transacao
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
     * @param  Transacao             $transacao
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
     * @param  Transacao $transacao
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
     * @param  Transacao              $transacao
     * @param  Cartao                 $cartao
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
     * @param Cartao    $cartao
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
     * Realiza o envio da requisição à Cielo
     *
     * @param Requisicao $requisicao
     */
    protected function enviaRequisicao(Requisicao $requisicao)
    {
        $request = $this->httpClient->post($this->getEndpoint())
                                    ->addPostFields(array(
                                        'mensagem' => $requisicao->getEnvio()->asXML()
                                    ));

        foreach ($this->curlOpcoes as $opcao) {
            $request->getCurlOptions()->set($opcao['nome'], $opcao['valor']);
        }

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
    
    /**
     * Recupera os idiomas válidos
     * 
     * @return array
     */
    public function getIdiomas()
    {
        return $this->idiomas;
    }
    
    /**
     * Recupera os ambientes válidos
     * 
     * @return array
     */
    public function getAmbientes()
    {
        return $this->ambientes;
    }

    /**
     * Recupera as configurações do cURL.
     * @return array
     */
    public function getCurlOpcoes()
    {
        return $this->curlOpcoes;
    }

    /**
     * Define as configurações do cURL.
     *
     * @param array $curlOpcoes
     * @return self
     */
    public function setCurlOpcoes(array $curlOpcoes = array())
    {
        $this->curlOpcoes = $curlOpcoes;
        return $this;
    }
}
