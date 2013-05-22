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
 * Este código fonte está sob a licença MIT
 *
 * @category   Classes
 * @package    Cliente
 * @subpackage Cielo
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    MIT
 */
namespace MrPrompt\Cielo;

class Cliente
{
    /**
     * URL de retorno para a página da loja
     *
     * @var string
     */
    private $_urlRetorno;
    /**
     * Número de registro
     *
     * @var integer
     */
    private $_numero;
    /**
     * Chave de registro
     *
     * @var string
     */
    private $_chave;
    /**
     * TID da transação
     *
     * @var integer
     */
    private $_tid;
    /**
     * XML da menasgem de chamada ao serviço
     *
     * @var string
     */
    private $_xml;
    /**
     * Tipo de compra
     *
     * Código do produto:
     * 1 (Crédito à Vista)
     * 2 (Parcelado loja)
     * 3 (Parcelado administradora)
     * A (Débito)
     *
     * @var string
     */
    private $_produto = 1;
    /**
     * Número de parcelas da venda
     *
     * @var integer
     */
    private $_parcelas = 1;
    /**
     * Bandeira do cartão
     *
     * vista ou mastercard (sempre minúsculo)
     *
     * @var string
     */
    private $_bandeira = 'visa';
    /**
     * Código numérico da moeda na ISO 4217 (R$ é 986 - default)
     *
     * @var integer
     */
    private $_moeda = 986;
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
    private $_idioma = 'PT';
    /**
     * Define se a transação será automaticamente capturada caso
     * seja autorizada.
     *
     * @var string
     */
    private $_capturar = 'false';
    /**
     * Indicador de autorização automática:
     *
     * 0 (não autorizar)
     * 1 (autorizar somente se autenticada)
     * 2 (autorizar autenticada e não-autenticada)
     * 3 (autorizar sem passar por autenticação – válido somente para crédito)
     *
     * @var integer
     */
    private $_autorizar = 0;
    /**
     * Data hora do pedido.
     *
     * Formato: AAAA-MM-DDTHH:MM:SS
     *
     * @var datetime
     */
    private $_dataHora;
    /**
     * Número do pedido da loja.
     *
     * @var integer
     */
    private $_numeroPedido;
    /**
     * Valor do pedido
     *
     * @var integer
     */
    private $_valorPedido;
    /**
     * Número do cartão.
     *
     * @var integer
     */
    private $_cartao;
    /**
     * Indicador do código de segurança:
     *
     * 0 (não informado)
     * 1 (informado)
     * 2 (ilegível)
     * 9 (inexistente)
     *
     * @var integer
     */
    private $_indicador = 0;
    /**
     * Código de segurança do cartão, obrigatório se o indicador for 1
     *
     * @var string
     */
    private $_codigoSeguranca;
    /**
     * Nome impresso no cartão.
     *
     * @var string
     */
    private $_nomePortador;
    /**
     * Validade do cartão no formato aaaamm.
     * Exemplos: 201212 (dez 2012).
     *
     * @var integer
     */
    private $_validade;
    /**
     * Descricao da transação
     *
     * @var string 
     */
    private $_descricao;
    /**
     * Certificado SSL
     *
     * @var string
     */
    private $_sslCertificate;
    /**
     * Ambiente (teste ou producao)
     *
     * Default: producao
     *
     * @var string
     */
    private $_ambiente = 'producao';
    /**
     * Mostrar XML de chamada (para fins de debug)
     *
     * Default: false
     *
     * @var boolean
     */
    private $_debug = false;

    /**
     * Construtor da aplicação
     *
     * Aqui é configurada o número e a chave de acesso do afiliado a Cielo
     *
     * @access public
     * @param  integer $numero
     * @param  mixed $chave
     */
    public function __construct($numero = null, $chave = null)
    {
        if (strlen($numero) === 0 || strlen($chave) === 0) {
            throw new Exception\Cliente('Número/Chave inválidos.');
        }

        if (strlen($numero) > 20) {
            throw new Exception\Cliente('Número inválido.');
        }

        if (strlen($chave) > 100) {
            throw new Exception\Cliente('Chave inválida.');
        }

        if (!class_exists('SimpleXmlElement')) {
            throw new Exception\Cliente('Classe SimpleXmlElement inexistente.');
        }

        $this->_numero = substr($numero, 0, 20);
        $this->_chave = substr($chave, 0, 100);
    }

    /**
     * Retorna o nome do classe
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        return __CLASS__;
    }

    /**
     * Erro para chamadas a métodos inválidos.
     *
     * @access public
     * @param  string $nome
     * @param  mixed  $argumentos
     * @return Exception\Cliente
     */
    public function __call($nome, $argumentos)
    {
        throw new Exception\Cliente("Método inexistente: {$nome}.");
    }

    /**
     * Retorna a URL de Retorno setada para a transação
     *
     * @acess public
     * @return string
     */
    public function getUrlRetorno()
    {
        return $this->_urlRetorno;
    }

    /**
     * Define a URL de Retorno da transação
     *
     * @access public
     * @param  string $_url
     * @return Cielo
     */
    public function setUrlRetorno($_url = null)
    {
        $valida = filter_var($_url, FILTER_VALIDATE_URL,
                        FILTER_FLAG_SCHEME_REQUIRED);

        if ($valida == false) {
            throw new Exception\Cliente('URL de retorno inválida.');
        }

        $this->_urlRetorno = substr($_url, 0, 1024);

        return $this;
    }

    /**
     * Configura o valor do TID
     *
     * @access public
     * @return string
     */
    public function getTid()
    {
        return $this->_tid;
    }

    /**
     * Configura o TID
     *
     * @access public
     * @param  string $_tid
     * @return Cielo
     */
    public function setTid($_tid)
    {
        $this->_tid = $_tid;

        return $this;
    }

    /**
     * Retorna o último XML configurado
     *
     * @access public
     * @return string
     */
    public function getXml()
    {
        return $this->_xml;
    }

    /**
     * Seta o XML da chamada ou retorno
     *
     * @access public
     * @param  string $_xml
     * @return Cielo
     */
    public function setXml($_xml)
    {
        $this->_xml = $_xml;

        return $this;
    }

    /**
     * Retorna o tipo de compra/produto
     *
     * @access public
     * @return integer
     */
    public function getProduto()
    {
        return $this->_produto;
    }

    /**
     * Configura o Tipo de compra/produto
     *
     * Código do produto:
     * 1 (Crédito à Vista)
     * 2 (Parcelado loja)
     * 3 (Parcelado administradora)
     * A (Débito)
     *
     * @access public
     * @param  mixed $_produto
     * @return Cielo
     */
    public function setProduto($_produto)
    {
        switch ($_produto) {
            case '1':
            case '2':
            case '3':
            case 'A':
                $this->_produto = $_produto;

                return $this;
            default:
                throw new Exception\Cliente('Tipo de produto inválido.');
                break;
        }
    }

    /**
     * Retorna o número de parcelas
     *
     * @access public
     * @return integer
     */
    public function getParcelas()
    {
        return $this->_parcelas;
    }

    /**
     * Configura o número de parcelas da venda
     *
     * @access public
     * @param  integer $_parcelas
     * @return Cielo
     */
    public function setParcelas($_parcelas)
    {
        $this->_parcelas = (integer) $_parcelas;

        return $this;
    }

    /**
     * Retorna a bandeira do cartão
     *
     * @access public
     * @return string
     */
    public function getBandeira()
    {
        return $this->_bandeira;
    }

    /**
     * Configura a bandeira do cartão
     *
     * @access public
     * @param  string $_bandeira
     * @return Cielo
     */
    public function setBandeira($_bandeira)
    {
        if (preg_match('/(visa|mastercard)/i', $_bandeira)) {
            $this->_bandeira = strtolower($_bandeira);

            return $this;
        } else {
            throw new Exception\Cliente('Bandeira inválida.');
        }
    }

    /**
     * Retorna o tipo de moeda utilizado na venda
     *
     * @access public
     * @return integer
     */
    public function getMoeda()
    {
        return $this->_moeda;
    }

    /**
     * Código numérico da moeda na ISO 4217 (R$ é 986 - default)
     *
     * @access public
     * @param  integer $_moeda
     * @return Cielo
     */
    public function setMoeda($_moeda = 986)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $_moeda)) {
            throw new Exception\Cliente('Moeda inválida');
        } else {
            $this->_moeda = (integer) substr($_moeda, 0, 3);

            return $this;
        }
    }

    /**
     * Retorna o idioma da venda
     *
     * @access public
     * @return string
     */
    public function getIdioma()
    {
        return $this->_idioma;
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
     * @param  string $_idioma
     * @return Cielo
     */
    public function setIdioma($_idioma)
    {
        switch ($_idioma) {
            case 'PT':
            case 'EN':
            case 'ES':
                $this->_idioma = $_idioma;

                return $this;
                break;
            default:
                throw new Exception\Cliente('Idioma inválido.');
        }
    }

    /**
     * Retorna se é ou não para capturar automaticamente a venda
     *
     * @access public
     * @return string
     */
    public function getCapturar()
    {
        return $this->_capturar;
    }

    /**
     * Informa se é para capturar automaticamente a venda
     *
     * @access public
     * @param  string $_capturar
     * @return Cielo
     */
    public function setCapturar($_capturar)
    {
        switch ($_capturar) {
            case 'true':
            case 'false':
                $this->_capturar = $_capturar;

                return $this;
                break;
            default:
                throw new Exception\Cliente('Parâmetro inválido.');
        }
    }

    /**
     * Retorna o Indicador de autorização automática:
     *
     * 0 (não autorizar)
     * 1 (autorizar somente se autenticada)
     * 2 (autorizar autenticada e não-autenticada)
     * 3 (autorizar sem passar por autenticação – válido somente para crédito)
     *
     * @access public
     * @return integer
     */
    public function getAutorizar()
    {
        return $this->_autorizar;
    }

    /**
     * Seta o Indicador de autorização automática:
     *
     * 0 (não autorizar)
     * 1 (autorizar somente se autenticada)
     * 2 (autorizar autenticada e não-autenticada)
     * 3 (autorizar sem passar por autenticação – válido somente para crédito)
     *
     * @access public
     * @param  integer $_autorizar
     * @return integer
     */
    public function setAutorizar($_autorizar)
    {
        switch ((integer) $_autorizar) {
            case 0:
            case 1:
            case 2:
            case 3:
                $this->_autorizar = (integer) $_autorizar;

                return $this;
            default:
                throw new Exception\Cliente('Indicador de autorização inválido.');
        }
    }

    /**
     * Retorna a data e hora configurada para a transação
     *
     * @access public
     * @return datetime
     */
    public function getDataHora()
    {
        return $this->_dataHora;
    }

    /**
     * Seta a data e hora da venda
     *
     * @access public
     * @param datetime $_dataHora AAAA-MM-DDTHH:MM:SS
     * @return Cielo
     */
    public function setDataHora($_dataHora)
    {
        if (strlen($_dataHora) !== 19) {
            throw new Exception\Cliente('Formato inválido.');
        } else {
            $this->_dataHora = $_dataHora;

            return $this;
        }
    }

    /**
     * Retorna o número do pedido
     *
     * @access public
     * @return integer
     */
    public function getNumero()
    {
        return $this->_numeroPedido;
    }

    /**
     * Configura o número do pedido
     *
     * @access public
     * @param  integer $_numero
     * @return Cielo
     */
    public function setNumero($_numero)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $_numero)) {
            throw new Exception\Cliente('Número do pedido inválido.');
        } else {
            $this->_numeroPedido = substr($_numero, 0, 50);

            return $this;
        }
    }

    /**
     * Retorna o valo da venda
     *
     * @access public
     * @return integer
     */
    public function getValor()
    {
        return $this->_valorPedido;
    }

    /**
     * Configura o valor da venda
     *
     * O valor da venda é um inteiro sem separador, onde os dois últimos
     * digitos referem-se aos centavos. Ex.: 1200 = R$ 12,00
     *
     * @access public
     * @param  integer $_valor
     * @return Cielo
     */
    public function setValor($_valor)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $_valor)) {
            throw new Exception\Cliente('Valor inválido.');
        } else {
            $this->_valorPedido = substr($_valor, 0, 12);

            return $this;
        }
    }

    /**
     * Retorna o número do cartão
     *
     * @access public
     * @return integer
     */
    public function getCartao()
    {
        return $this->_cartao;
    }

    /**
     * Configura o número do cartão
     *
     * @access public
     * @param  integer $_cartao
     * @return Cielo
     */
    public function setCartao($_cartao)
    {
        $this->_cartao = preg_replace('/[^[:digit:]]/', '', $_cartao);

        return $this;
    }

    /**
     * Retorna o indicador do código de segurança setado
     *
     * @access public
     * @return integer
     */
    public function getIndicador()
    {
        return $this->_indicador;
    }

    /**
     * Indicador do código de segurança:
     *
     * 0 (não informado)
     * 1 (informado)
     * 2 (ilegível)
     * 9 (inexistente)
     *
     * @var integer
     */
    public function setIndicador($_indicador)
    {
        switch ((integer) $_indicador) {
            case 0:
            case 1:
            case 2:
            case 9:
                $this->_indicador = (integer) substr($_indicador, 0, 1);

                return $this;
                break;
            default:
                throw new Exception\Cliente('Indicador de segurança inválido.');
        }
    }

    /**
     * Retorna o código de segurança configurado para cartão
     *
     * @access public
     * @return string
     */
    public function getCodigoSeguranca()
    {
        return $this->_codigoSeguranca;
    }

    /**
     * Seta o código de segurança do cartão
     *
     * @access public
     * @param  string $_codigo
     * @return Cielo
     */
    public function setCodigoSeguranca($_codigo)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $_codigo)) {
            throw new Exception\Cliente('Código de segurança inválido.');
        } else {
            $this->_codigoSeguranca = filter_var($_codigo, FILTER_SANITIZE_STRING);

            return $this;
        }
    }

    /**
     * Retorna o nome do portador do cartão
     *
     * @access public
     * @return string
     */
    public function getNomePortador()
    {
        return $this->_nomePortador;
    }

    /**
     * Seta o nome do portador do cartão
     *
     * @access public
     * @param  string $_nomePortador
     * @return Cielo
     */
    public function setNomePortador($_nomePortador)
    {
        if (preg_match('/[[:alnum:]]/i', $_nomePortador)) {
            $this->_nomePortador = substr($_nomePortador, 0, 50);

            return $this;
        } else {
            throw new Exception\Cliente('Caracteres inválidos no nome do portador.');
        }
    }

    /**
     * Retorna a data de validade setada para o cartão
     *
     * @access public
     * @return integer
     */
    public function getValidade()
    {
        return $this->_validade;
    }

    /**
     * Configura a data de validade do cartão
     *
     * @access public
     * @param  integer $_validade AAAAMM
     * @return Cielo
     */
    public function setValidade($_validade)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $_validade)) {
            throw new Exception\Cliente('Data de validade inválida.');
        }

        if (strlen($_validade) != 6) {
            throw new Exception\Cliente('Data de validade inválida.');
        }

        if ($_validade < date('Ym')) {
            throw new Exception\Cliente('Cartão com validade ultrapassada.');
        }

        $this->_validade = substr($_validade, 0, 6);

        return $this;
    }
    
    /**
     * Informa a descrição da operação
     *
     * @access public
     * @param  string $_descricao
     * @return Cielo 
     */
    public function setDescricao($_descricao)
    {
        $this->_descricao = $_descricao;
        
        return $this;
    }
    
    /**
     * Retorna a descrição configurada para a transação
     *
     * @access public
     * @return string 
     */
    public function getDescricao()
    {
        return $this->_descricao;
    }

    /**
     * Retorna o status do debug
     *
     * @access public
     * @return boolean
     */
    public function getDebug()
    {
        return $this->_debug;
    }

    /**
     * Seta o status do debug da classe, caso verdadeiro, imprime os XMLs
     * gerados para as chamadas e seus retornos.
     *
     * @access public
     * @param  boolean $_debug
     * @return Cielo
     */
    public function setDebug($_debug = true)
    {
        if (!is_bool($_debug)) {
            throw new Exception\Cliente('Parâmetro inválido.');
        }

        $this->_debug = $_debug;

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
        return $this->_ambiente;
    }

    /**
     * Configura o ambiente a ser utilizado nas chamadas de transações
     *
     * @access public
     * @param  string $_ambiente teste | produção (default)
     * @return Cielo
     */
    public function setAmbiente($_ambiente)
    {
        switch ($_ambiente) {
            case 'teste':
            case 'produção':
            case 'producao':
                $this->_ambiente = $_ambiente;

                return $this;
            default:
                throw new Exception\Cliente('Ambiente inválido.');
        }
    }
    
/**
	 * Retorna o caminho do certificado SSL
	 *
	 * @access public
	 * @return string
	 */
	public function getSslCertificate()
	{
		return $this->_sslCertificate;
	}


	/**
	 * Seta o caminho para o arquivo certificado SSL (ex.: certificado.crt)
	 *
	 * @access public
	 * @param  string $_sslCertificate
	 * @return Cielo
	 */
	public function setSslCertificate($_sslCertificate = '')
	{
		if (!is_string($_sslCertificate)) {
			throw new Exception('Parâmetro inválido.');
		}

		$this->_sslCertificate = $_sslCertificate;

		return $this;
	}


    /**
     * Envia a chamada para o Web Service da Cielo
     *
     * @access private
     * @return void
     */
    private function _enviaChamada()
    {
        // URL para o ambiente de produção
        $url = 'https://ecommerce.cbmp.com.br/servicos/ecommwsec.do';

        // URL para o ambiente de teste
        if ($this->_ambiente === 'teste') {
            $url = 'https://qasecommerce.cielo.com.br/servicos/ecommwsec.do';
        }

        if ($this->_debug === true) {
            echo $this->_xml . "\n\n";
        }

        // Iniciando o objeto Curl
        $_curl = curl_init();

        // Retornar a transferência ao objeto
        curl_setopt($_curl, CURLOPT_RETURNTRANSFER, 1);

        // Sempre utilizar uma nova conexão
        curl_setopt($_curl, CURLOPT_FRESH_CONNECT, 1);

        // Retornar Header
        curl_setopt($_curl, CURLOPT_HEADER, 0);

        // Modo verboso
        curl_setopt($_curl, CURLOPT_VERBOSE, 0);

        // Mostrar o corpo da requisição
        curl_setopt($_curl, CURLOPT_NOBODY, 0);

        // Seguir redirecionamentos
        curl_setopt($_curl, CURLOPT_FOLLOWLOCATION, 1);

        // Abrindo a url
        curl_setopt($_curl, CURLOPT_URL, $url);

        // Habilitando o método POST
        curl_setopt($_curl, CURLOPT_POST, true);

        // envio os campos
        curl_setopt($_curl, CURLOPT_POSTFIELDS, "mensagem={$this->_xml}");
        
        //  o tempo em segundos de espera para obter uma conexão
		curl_setopt($_curl, CURLOPT_CONNECTTIMEOUT, 10);
	
		//  o tempo máximo em segundos de espera para a execução da requisição (curl_exec)
		curl_setopt($_curl, CURLOPT_TIMEOUT, 40);
		
		if ($this->getSslCertificate() != '') {
			//  verifica a validade do certificado
			curl_setopt($_curl, CURLOPT_SSL_VERIFYPEER, true);
	
			//  verifica se a identidade do servidor bate com aquela informada no certificado
			curl_setopt($_curl, CURLOPT_SSL_VERIFYHOST, 2);
		
			//  informa a localização do certificado para verificação com o peer
			curl_setopt($_curl, CURLOPT_CAINFO, $this->getSslCertificate());
			curl_setopt($_curl, CURLOPT_SSLVERSION, 3);
		}

        // Faz a requisição HTTP
        $this->setXml(curl_exec($_curl));

        // Fecho a conexão
        curl_close($_curl);
    }

    /**
     * Transacao
     *
     * Inicia uma transação de venda, retornando seu TID e demais valores
     *
     * @access public
     * @return string
     */
    public function transacao()
    {
        $_xml = "<requisicao-transacao id='1' versao='1.1.0'>"
                . "</requisicao-transacao>";

        $xml = new SimpleXMLElement($_xml);

        // dados-ec
        $ec = $xml->addChild('dados-ec', '');
        $ec->addChild('numero', $this->_numero);
        $ec->addChild('chave', $this->_chave);

        // dados-portador
        $dc = $xml->addChild('dados-portador', '');
        $dc->addChild('numero', $this->_cartao);
        $dc->addChild('validade', $this->_validade);
        $dc->addChild('indicador', $this->_indicador);
        $dc->addChild('codigo-seguranca', $this->_codigoSeguranca);
        $dc->addChild('nome-portador', $this->_nomePortador);

        // dados-pedido
        $dp = $xml->addChild('dados-pedido', '');
        $dp->addChild('numero', $this->_numeroPedido);
        $dp->addChild('valor', $this->_valorPedido);
        $dp->addChild('moeda', $this->_moeda);
        $dp->addChild('data-hora', $this->_dataHora);
        $dp->addChild('idioma', $this->_idioma);

        // forma-pagamento
        $fp = $xml->addChild('forma-pagamento');
        $fp->addChild('bandeira', $this->_bandeira);
        $fp->addChild('produto', $this->_produto);
        $fp->addChild('parcelas', $this->_parcelas);

        // url-retorno
        $xml->addChild('url-retorno', $this->_urlRetorno);

        // autorizar
        $xml->addChild('autorizar', $this->_autorizar);

        // capturar
        $xml->addChild('capturar', $this->_capturar);

        $this->_xml = $xml->asXML();

        $this->_enviaChamada();

        return $this->getXml();
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
     * @return string
     */
    public function autorizacao()
    {
        $_xml = "<requisicao-autorizacao-tid id='2' versao='1.1.0'>"
                . "</requisicao-autorizacao-tid>";

        $xml = new SimpleXMLElement($_xml);

        // tid
        $xml->addChild('tid', $this->_tid);

        // dados-ec
        $ec = $xml->addChild('dados-ec', '');
        $ec->addChild('numero', $this->_numero);
        $ec->addChild('chave', $this->_chave);

        $this->_xml = $xml->asXML();

        $this->_enviaChamada();

        return $this->getXml();
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
     * @return string
     */
    public function captura()
    {
        $_xml = "<requisicao-captura id='3' versao='1.1.0'>"
                . "</requisicao-captura>";

        $xml = new SimpleXMLElement($_xml);

        // tid
        $xml->addChild('tid', $this->_tid);

        // dados-ec
        $ec = $xml->addChild('dados-ec', '');
        $ec->addChild('numero', $this->_numero);
        $ec->addChild('chave', $this->_chave);

        $this->_xml = $xml->asXML();

        $this->_enviaChamada();

        return $this->getXml();
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
     * @return string
     */
    public function cancelamento()
    {
        $_xml = "<requisicao-cancelamento id='4' versao='1.1.0'>"
                . "</requisicao-cancelamento>";

        $xml = new SimpleXMLElement($_xml);

        // tid
        $xml->addChild('tid', $this->_tid);

        // dados-ec
        $ec = $xml->addChild('dados-ec', '');
        $ec->addChild('numero', $this->_numero);
        $ec->addChild('chave', $this->_chave);

        $this->_xml = $xml->asXML();

        $this->_enviaChamada();

        return $this->getXml();
    }

    /**
     * Consulta
     *
     * Funcionalidade de extrema importância na integração.
     * É através dela que a loja virtual obtém uma “foto” da transação.
     * É sempre utilizada após a loja ter recebido o retorno do fluxo da Cielo.
     *
     * @access public
     * @return string
     */
    public function consulta()
    {
        $_xml = "<requisicao-consulta id='5' versao='1.1.0'>"
                . "</requisicao-consulta>";

        $xml = new SimpleXMLElement($_xml);

        // tid
        $xml->addChild('tid', $this->_tid);

        // dados-ec
        $ec = $xml->addChild('dados-ec', '');
        $ec->addChild('numero', $this->_numero);
        $ec->addChild('chave', $this->_chave);

        $this->_xml = $xml->asXML();

        $this->_enviaChamada();

        return $this->getXml();
    }

    /**
     * TID
     *
     * Requisita um TID (Identificador de transação) ao Web Service
     *
     * @access public
     * @return string
     */
    public function tid()
    {
        $_xml = "<requisicao-tid id='6' versao='1.1.0'>"
                . "</requisicao-tid>";

        $xml = new SimpleXMLElement($_xml);

        // dados-ec
        $ec = $xml->addChild('dados-ec', '');
        $ec->addChild('numero', $this->_numero);
        $ec->addChild('chave', $this->_chave);

        // forma-pagamento
        $fp = $xml->addChild('forma-pagamento');
        $fp->addChild('bandeira', $this->_bandeira);
        $fp->addChild('produto', $this->_produto);
        $fp->addChild('parcelas', $this->_parcelas);

        $this->_xml = $xml->asXML();

        $this->_enviaChamada();

        return $this->getXml();
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
     * @access public
     * @return string
     */
    public function autorizacaoPortador()
    {
        $_xml = "<requisicao-autorizacao-portador id='7' versao='1.1.0'>"
                . "</requisicao-autorizacao-portador>";

        $xml = new SimpleXMLElement($_xml);

        // tid
        $xml->addChild('tid', $this->_tid);

        // dados-ec
        $ec = $xml->addChild('dados-ec', '');
        $ec->addChild('numero', $this->_numero);
        $ec->addChild('chave', $this->_chave);

        // dados-cartão
        $dc = $xml->addChild('dados-cartao', '');
        $dc->addChild('numero', $this->_cartao);
        $dc->addChild('validade', $this->_validade);
        $dc->addChild('indicador', $this->_indicador);
        $dc->addChild('codigo-seguranca', $this->_codigoSeguranca);
        $dc->addChild('nome-portador', $this->_nomePortador);

        // dados-pedido
        $dp = $xml->addChild('dados-pedido', '');
        $dp->addChild('numero', $this->_numeroPedido);
        $dp->addChild('valor', $this->_valorPedido);
        $dp->addChild('moeda', $this->_moeda);
        $dp->addChild('data-hora', $this->_dataHora);
        $dp->addChild('descricao', $this->_descricao);
        $dp->addChild('idioma', $this->_idioma);

        // forma-pagamento
        $fp = $xml->addChild('forma-pagamento');
        $fp->addChild('bandeira', $this->_bandeira);
        $fp->addChild('produto', $this->_produto);
        $fp->addChild('parcelas', $this->_parcelas);

        // capturar automaticamente
        $xml->addChild('capturar-automaticamente', $this->_capturar);

        $this->_xml = $xml->asXML();

        $this->_enviaChamada();

        return $this->getXml();
    }
}