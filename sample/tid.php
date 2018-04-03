<?php
require_once __DIR__ . '/../vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

/* @var $transacao \MrPrompt\Cielo\Cliente */
$cielo     = require_once __DIR__ . '/resources/cliente.php';

/* @var $transacao \MrPrompt\Cielo\Transacao */
$transacao = require_once __DIR__ . '/resources/transacao.php';

/* @var $transacao \MrPrompt\Cielo\Cartao */
$cartao    = require_once __DIR__ . '/resources/cartao.php';

$requisicao = $cielo->tid($transacao, $cartao);

// echo 'XML GERADO: ', $requisicao->getEnvio()->asXML(), PHP_EOL;
// echo 'RETORNO: ', $requisicao->getResposta(), PHP_EOL;

$serializer = JMS\Serializer\SerializerBuilder::create()->build();
$object = $serializer->deserialize($requisicao->getResposta(), 'MrPrompt\Cielo\Retorno\Tid', 'xml');

print_r($object);