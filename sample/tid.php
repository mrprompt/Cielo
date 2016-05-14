<?php
require_once __DIR__ . '/../vendor/autoload.php';

$cielo     = require_once __DIR__ . '/resources/cliente.php';
$transacao = require_once __DIR__ . '/resources/transacao.php';
$cartao    = require_once __DIR__ . '/resources/cartao.php';

$requisicao = $cielo->tid($transacao, $cartao);

echo 'XML GERADO: ', $requisicao->getEnvio()->asXML(), PHP_EOL;
echo 'RETORNO: ', $requisicao->getResposta(), PHP_EOL;
