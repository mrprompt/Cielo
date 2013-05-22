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
$cielo->autorizacao($transacao);

echo 'XML GERADO: ', $cielo->getXml()->asXML(), PHP_EOL;
echo 'RETORNO: ', $cielo->enviaChamada()->asXML(), PHP_EOL;
