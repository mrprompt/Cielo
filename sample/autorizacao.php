<?php
require_once __DIR__ . '/resources/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cliente;

$transacao = new Transacao;
$transacao->setTid('10017348980059031001');

$cielo = new Cliente(new Autorizacao(NUMERO_CIELO, CHAVE_CIELO));
$cielo->setAmbiente('teste');
$requisicao = $cielo->autoriza($transacao);

echo 'XML GERADO: ', $requisicao->getEnvio()->asXML(), PHP_EOL;
echo 'RETORNO: ', $requisicao->getResposta()->asXML(), PHP_EOL;
