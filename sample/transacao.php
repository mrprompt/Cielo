<?php
require_once __DIR__ . '/resources/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cartao;
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

$cielo = new Cliente(new Autorizacao(NUMERO_CIELO, CHAVE_CIELO));
$cielo->setAmbiente('teste');
$requisicao = $cielo->iniciaTransacao($transacao, $cartao, 'http://google.com.br');

echo 'XML GERADO: ', $requisicao->getEnvio()->asXML(), PHP_EOL;
echo 'RETORNO: ', $requisicao->getResposta()->asXML(), PHP_EOL;
