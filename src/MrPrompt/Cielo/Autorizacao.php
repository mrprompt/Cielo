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

use Respect\Validation\Validator as v;
use InvalidArgumentException;

/**
 * Dados de autorização da requisição
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class Autorizacao
{
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
     * Inicializa o objeto
     *
     * @param string $numero
     * @param string $chave
     */
    public function __construct($numero, $chave)
    {
        $this->setNumero($numero);
        $this->setChave($chave);
    }

    /**
     * Retorna o número de autorização
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Configura o número de autorização
     *
     * @param string $chave
     * @throws InvalidArgumentException
     */
    public function setNumero($numero)
    {
        if (!v::string()->notEmpty()->validate($numero)) {
            throw new InvalidArgumentException('O número de autenticação deve ser uma string não vazia');
        }

        $this->numero = substr($numero, 0, 20);
    }

    /**
     * Retorna a chave de autorização
     *
     * @return string
     */
    public function getChave()
    {
        return $this->chave;
    }

    /**
     * Configura a chave de autorização
     *
     * @param string $chave
     * @throws InvalidArgumentException
     */
    public function setChave($chave)
    {
        if (!v::string()->notEmpty()->validate($chave)) {
            throw new InvalidArgumentException('A chave de autenticação deve ser uma string não vazia');
        }

        $this->chave = substr($chave, 0, 100);
    }
}
