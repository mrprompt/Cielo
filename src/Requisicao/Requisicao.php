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
declare(strict_types = 1);

namespace MrPrompt\Cielo\Requisicao;

use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Transacao;
use SimpleXMLElement;

/**
 * Cada chamada ao webservice representa uma requisição
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
abstract class Requisicao
{
    /**
     * Dados de autorização
     *
     * @var Autorizacao
     */
    private $autorizacao;

    /**
     * Transação a ser enviada
     *
     * @var Transacao
     */
    protected $transacao;

    /**
     * XML de envio
     *
     * @var SimpleXMLElement
     */
    private $envio;

    /**
     * XML de resposta
     *
     * @var SimpleXMLElement
     */
    private $resposta;

    /**
     * Deve adicionar o TID?
     *
     * @var boolean
     */
    private $adicionarTid = true;

    /**
     * Inicializa o objeto
     *
     * @param Autorizacao $autorizacao
     * @param Transacao   $transacao
     */
    public function __construct(Autorizacao $autorizacao, Transacao $transacao)
    {
        $this->autorizacao  = $autorizacao;
        $this->transacao    = $transacao;
        $this->envio        = new SimpleXMLElement($this->getXmlInicial());

        $this->configuraTransacao();
        $this->configuraAutenticacao();
        $this->configuraEnvio();
    }

    /**
     * Retorna a modalidade de integração definida na autorização.
     * @return integer
     */
    public function getModalidadeIntegracao(): int
    {
        return (int) $this->autorizacao->getModalidade();
    }

    /**
     * Adiciona os dados de autenticação à requisição
     */
    protected function configuraAutenticacao()
    {
        $auth = $this->getEnvio()->addChild('dados-ec', '');

        $auth->addChild('numero', (string) $this->autorizacao->getNumero());
        $auth->addChild('chave', (string) $this->autorizacao->getChave());
    }

    /**
     * Adiciona os dados da transacao à requisição
     */
    protected function configuraTransacao()
    {
        if (!$this->deveAdicionarTid()) {
            return ;
        }

        $this->getEnvio()->addChild('tid', (string) $this->transacao->getTid());
    }

    /**
     * Retorna o XML de requisição
     *
     * @return \SimpleXMLElement
     */
    public function getEnvio(): \SimpleXMLElement
    {
        return $this->envio;
    }

    /**
     * Retorna o XML de resposta
     *
     * @return string
     */
    public function getResposta(): string
    {
        return (string) $this->resposta;
    }

    /**
     * Configura o objeto de resposta
     *
     * @param string $resposta
     */
    public function setResposta(string $resposta)
    {
        $this->resposta = $resposta;
    }

    /**
     * Retorna adicionarTid
     *
     * @return boolean
     */
    public function getAdicionarTid(): bool
    {
        return $this->adicionarTid;
    }

    /**
     * Configura adicionarTid
     *
     * @param bool $deve
     */
    public function setAdicionarTid(bool $deve)
    {
        $this->adicionarTid = $deve;
    }

    /**
     * Configura o objeto de envio de acordo com as requisições
     */
    protected function configuraEnvio()
    {
        // Fazer override quando necessário
    }

    /**
     * Verificação se deve ser enviado o TID na requisição
     *
     * @return boolean
     */
    protected function deveAdicionarTid(): bool
    {
        return $this->getAdicionarTid();
    }

    /**
     * Retorna o XML inicial da requisição
     *
     * @return string
     */
    protected function getXmlInicial(): string
    {
        // sempre é sobrescrito...
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->appendChild($dom->createElement('requisicao'));

        return $dom->saveXML();
    }
}
