<?php
define('NUMERO_CIELO', getenv('NUMERO_CIELO'));
define('CHAVE_CIELO', getenv('CHAVE_CIELO'));

$load = require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$load->add('MrPrompt', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src');

use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cartao;
use MrPrompt\Cielo\Cliente;

$transacao = new Transacao;
$transacao->setTid(123123);

$cartao = new Cartao;
$cartao->setBandeira('visa');
$cartao->setCartao('00000000');
$cartao->setCodigoSeguranca(000);
$cartao->setIndicador(0);
$cartao->setNomePortador('Teste');
$cartao->setValidade('201512');

$cielo = new Cliente(NUMERO_CIELO, CHAVE_CIELO);  
$cielo->setAmbiente('teste');
$cielo->captura($transacao);

var_dump($cielo->getXml()->asXML());