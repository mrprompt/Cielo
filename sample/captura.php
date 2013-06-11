<?php
require_once __DIR__ . '/resources/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Cliente;

$transacao = require_once __DIR__ . '/resources/transacao.php';
$cielo     = new Cliente(new Autorizacao(NUMERO_CIELO, CHAVE_CIELO));
$cielo->setAmbiente('teste');
$requisicao = $cielo->captura($transacao);

echo 'XML GERADO: ', $requisicao->getEnvio()->asXML(), PHP_EOL;
echo 'RETORNO: ', $requisicao->getResposta()->asXML(), PHP_EOL;
