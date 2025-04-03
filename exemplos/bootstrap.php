<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;
use MrPrompt\Cielo\Infra\Ambiente;
use MrPrompt\Cielo\Infra\Autenticacao;
use MrPrompt\Cielo\Infra\HttpDriver;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required(['CIELO_MERCHANT_ID', 'CIELO_MERCHANT_KEY']);

define('MERCHANT_ID', $_ENV['CIELO_MERCHANT_ID']);
define('MERCHANT_KEY', $_ENV['CIELO_MERCHANT_KEY']);

$client = new Client;
$ambiente = new Ambiente(Ambiente::SANDBOX);
$autenticacao = new Autenticacao(MERCHANT_ID, MERCHANT_KEY);
$driver = new HttpDriver($ambiente, $client, $autenticacao);
