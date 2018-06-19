<?php
/**
 * FormaPagamento
 *
 * Dados do FormaPagamento.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo
 * @subpackage FormaPagamento
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Modelos;

use DateTime;
use JMS\Serializer\Annotation as Serializer;
use Respect\Validation\Validator as v;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use InvalidArgumentException;

/**
 * Class FormaPagamento
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class FormaPagamento
{

    /**
     * @Type("string")
     * @var string
     */
    private $bandeira;

    /**
     *
     * @Type("string")
     * @var string
     */
    private $produto;

    /**
     *
     * @Type("integer")
     * @var integer
     */
    private $parcelas;

    /**
     * Construtor
     *
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getBandeira()
    {
        return $this->bandeira;
    }

    /**
     * @param string $bandeira
     */
    public function setBandeira($bandeira)
    {
        $this->bandeira = $bandeira;
    }

    /**
     * @return string
     */
    public function getProduto()
    {
        return $this->produto;
    }

    /**
     * @param string $produto
     */
    public function setProduto($produto)
    {
        $this->produto = $produto;
    }

    /**
     * @return int
     */
    public function getParcelas()
    {
        return $this->parcelas;
    }

    /**
     * @param int $parcelas
     */
    public function setParcelas($parcelas)
    {
        $this->parcelas = $parcelas;
    }
}
