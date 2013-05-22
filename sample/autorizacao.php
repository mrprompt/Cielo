<?php
define('NUMERO_CIELO', getenv('NUMERO_CIELO'));
define('CHAVE_CIELO', getenv('CHAVE_CIELO'));

$load = require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$load->add('MrPrompt', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src');

use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cliente;

$transacao = new Transacao;
$transacao->setTid('10017348980059031001');

$cielo = new Cliente(NUMERO_CIELO, CHAVE_CIELO);  
$cielo->setAmbiente('teste');
$cielo->autorizacao($transacao);

echo 'XML GERADO: ', $cielo->getXml()->asXML(), PHP_EOL;
echo 'RETORNO: ', $cielo->enviaChamada()->asXML(), PHP_EOL;