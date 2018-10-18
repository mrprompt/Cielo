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
 * @package    MrPrompt\Cielo\Retorno\Traits
 * @subpackage Serializer
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2013
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Traits;

use MrPrompt\Cielo\Retorno\Erro;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
trait Serializer
{
    protected function deserialize($content, $object = 'SimpleXMLElement', $format = 'xml')
    {
        $strategy = new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy());
        $serializer = SerializerBuilder::create()->build();

        if (preg_match('/<erro/i', $content)) {
            $object = Erro::class;
        }

        return $serializer->deserialize($content, $object, $format);
    }
}
