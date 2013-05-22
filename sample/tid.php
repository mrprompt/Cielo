<?php
define('NUMERO_CIELO', getenv('NUMERO_CIELO'));
define('CHAVE_CIELO', getenv('CHAVE_CIELO'));

$load = require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$load->add('MrPrompt', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src');

use MrPrompt\Cielo\Cartao;
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cliente;

$transacao = new Transacao;
$transacao->setTid('10017348980059039999');
$transacao->setAutorizar(0);
$transacao->setCapturar('false');
$transacao->setDataHora(date('Y-m-d\Th:i:s'));
$transacao->setDescricao('teste');
$transacao->setMoeda(986);
$transacao->setNumero(001);
$transacao->setParcelas(1);
$transacao->setValor(1.00);

$cartao = new Cartao;
$cartao->setBandeira('visa');
$cartao->setCartao('4923993827951627');
$cartao->setCodigoSeguranca('123');
$cartao->setIndicador(0);
$cartao->setNomePortador('Teste');
$cartao->setValidade('201512');

$cielo = new Cliente(NUMERO_CIELO, CHAVE_CIELO);  
$cielo->setAmbiente('teste');
$cielo->tid($transacao, $cartao);

echo 'XML GERADO: ', $cielo->getXml()->asXML(), PHP_EOL;
echo 'RETORNO: ', $cielo->enviaChamada()->asXML(), PHP_EOL;