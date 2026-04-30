<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;
use MrPrompt\Cielo\Enum\Ambiente\Ambiente;
use MrPrompt\Cielo\Infra\Autenticacao;
use MrPrompt\Cielo\Infra\HttpDriver;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required(['CIELO_MERCHANT_ID', 'CIELO_MERCHANT_KEY']);

define('MERCHANT_ID', $_ENV['CIELO_MERCHANT_ID']);
define('MERCHANT_KEY', $_ENV['CIELO_MERCHANT_KEY']);

$client = new Client();
$autenticacao = new Autenticacao(
    merchantId: MERCHANT_ID,
    merchantKey: MERCHANT_KEY,
);
$driver = new HttpDriver(
    ambiente: Ambiente::match('sandbox'),
    client: $client,
    autenticacao: $autenticacao,
);
