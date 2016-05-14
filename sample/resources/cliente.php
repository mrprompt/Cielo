<?php
require_once __DIR__ . '/config.php';

use GuzzleHttp\Client;
use MrPrompt\Cielo\Ambiente\Teste;
use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Idioma\Portugues;

$cielo     = new Cliente(
    new Autorizacao(NUMERO_CIELO, CHAVE_CIELO),
    new Client(),
    new Portugues(),
    new Teste()
);

return $cielo;