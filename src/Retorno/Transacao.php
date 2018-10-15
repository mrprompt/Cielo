<?php
/**
 * Transacao
 *
 * Dados do Transacao.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo\Retorno
 * @subpackage Transacao
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Retorno;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use MrPrompt\Cielo\Retorno\Traits\GetterSetter;

/**
 * Class Transacao
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class Transacao
{
    use GetterSetter;

    /**
     * @Type("string")
     * @var string
     */
    private $tid;

    /**
     * @Type("string")
     * @var string
     */
    private $pan;

    /**
     * @Type("integer")
     * @var integer
     */
    private $status;

    /**
     * @SerializedName("dados-pedido")
     * @Type("MrPrompt\Cielo\Retorno\DadosPedido")
     * @var \MrPrompt\Cielo\Retorno\DadosPedido
     */
    private $dadosPedido;

    /**
     * @SerializedName("forma-pagamento")
     * @Type("MrPrompt\Cielo\Retorno\FormaPagamento")
     * @var \MrPrompt\Cielo\Retorno\FormaPagamento
     */
    private $formaPagamento;

    /**
     * @Type("MrPrompt\Cielo\Retorno\Autenticacao")
     * @var \MrPrompt\Cielo\Retorno\Autenticacao
     */
    private $autenticacao;

    /**
     * @Type("MrPrompt\Cielo\Retorno\Autorizacao")
     * @var \MrPrompt\Cielo\Retorno\Autorizacao
     */
    private $autorizacao;

    /**
     * @Type("MrPrompt\Cielo\Retorno\Captura")
     * @var \MrPrompt\Cielo\Retorno\Captura
     */
    private $captura;

    /**
     * @Type("MrPrompt\Cielo\Retorno\Token")
     * @var \MrPrompt\Cielo\Retorno\Token
     */
    private $token;
}
