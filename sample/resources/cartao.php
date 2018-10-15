<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use MrPrompt\Cielo\Cartao;

$cartao = new Cartao();
$cartao->setBandeira('visa');
$cartao->setCartao('4012001037141112');
$cartao->setCodigoSeguranca('123');
$cartao->setIndicador(1);
$cartao->setNomePortador('Teste');
$cartao->setValidade('202012');

return $cartao;