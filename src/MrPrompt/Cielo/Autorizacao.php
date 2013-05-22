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
        $this->numero = substr($numero, 0, 20);
        $this->chave  = substr($chave, 0, 100);
    }

    /**
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @return string
     */
    public function getChave()
    {
        return $this->chave;
    }
}
