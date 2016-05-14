<?php
require_once __DIR__ . '/../vendor/autoload.php';

$transacao = require_once __DIR__ . '/resources/transacao.php';
$cartao    = require_once __DIR__ . '/resources/cartao.php';
$cielo     = require_once __DIR__ . '/resources/cliente.php';

$requisicao = $cielo->iniciaTransacao($transacao, $cartao, 'http://google.com.br');

echo 'XML GERADO: ', $requisicao->getEnvio()->asXML(), PHP_EOL;
echo 'RETORNO: ', $requisicao->getResposta(), PHP_EOL;
