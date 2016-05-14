<?php
require_once __DIR__ . '/../vendor/autoload.php';

$transacao = require_once __DIR__ . '/resources/transacao.php';
$cielo     = require_once __DIR__ . '/resources/cliente.php';

$requisicao = $cielo->cancela($transacao);

echo 'XML GERADO: ', $requisicao->getEnvio()->asXML(), PHP_EOL;
echo 'RETORNO: ', $requisicao->getResposta(), PHP_EOL;
