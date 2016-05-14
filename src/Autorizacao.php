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

namespace MrPrompt\Cielo;

use Respect\Validation\Validator as v;
use InvalidArgumentException;

/**
 * Dados de autorização da requisição
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class Autorizacao
{
    /**
     * Indica que a digitação dos dados do cartão ocorrerá no ambiente da Cielo.
     */
    const MODALIDADE_BUY_PAGE_CIELO = 1;

    /**
     * Indica que a digitação dos dados do cartão ocorrerá no ambiente da loja.
     */
    const MODALIDADE_BUY_PAGE_LOJA = 2;

    /**
     * Número de autorização
     *
     * @var string
     */
    private $numero;

    /**
     * Chave de autorização
     *
     * @var string
     */
    private $chave;

    /**
     * Modalidade de integração.
     * @var integer
     */
    private $modalidade = self::MODALIDADE_BUY_PAGE_LOJA;

    /**
     * Modalidades válidas.
     * @var array
     */
    private $modalidades = array(
        self::MODALIDADE_BUY_PAGE_CIELO,
        self::MODALIDADE_BUY_PAGE_LOJA
    );

    /**
     * Inicializa o objeto
     *
     * @param string  $numero
     * @param string  $chave
     * @param integer $modalidade 
     */
    public function __construct($numero, $chave, $modalidade = self::MODALIDADE_BUY_PAGE_LOJA)
    {
        $this->setNumero($numero);
        $this->setChave($chave);
        $this->setModalidade($modalidade);
    }

    /**
     * Retorna o número de autorização
     *
     * @return string
     */
    public function getNumero(): string
    {
        return (string) $this->numero;
    }

    /**
     * Configura o número de autorização
     *
     * @param  string                   $numero
     * @throws InvalidArgumentException
     */
    public function setNumero($numero)
    {
        if (!v::stringType()->notEmpty()->validate($numero)) {
            throw new InvalidArgumentException('O número de autenticação deve ser uma string não vazia');
        }

        $this->numero = substr($numero, 0, 20);
    }

    /**
     * Retorna a chave de autorização
     *
     * @return string
     */
    public function getChave(): string
    {
        return (string) $this->chave;
    }

    /**
     * Configura a chave de autorização
     *
     * @param  string $chave
     * @throws InvalidArgumentException
     */
    public function setChave($chave)
    {
        if (!v::stringType()->notEmpty()->validate($chave)) {
            throw new InvalidArgumentException('A chave de autenticação deve ser uma string não vazia');
        }

        $this->chave = substr($chave, 0, 100);
    }

    /**
     * Define a modalidade de integração.
     *
     * @return integer
     */
    public function getModalidade(): int
    {
        return (int) $this->modalidade;
    }
    
    /**
     * Define a modalidade de integração.
     *
     * @param integer $modalidade the modalidade
     * @throws InvalidArgumentException
     * @return self
     */
    public function setModalidade(int $modalidade = self::MODALIDADE_BUY_PAGE_LOJA)
    {
        $regras = v::intType()->notEmpty()->in($this->modalidades);
        
        if (!$regras->validate($modalidade)) {
            throw new InvalidArgumentException('Modalidade de integração inválida.');
        }

        $this->modalidade = $modalidade;

        return $this;
    }
}
