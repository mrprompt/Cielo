<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use MrPrompt\Cielo\Transacao;

$transacao = new Transacao();
$transacao->setTid('10069930691FB8C01001');
$transacao->setAutorizar(0);
$transacao->setCapturar('false');
$transacao->setDataHora(date('Y-m-d\Th:i:s'));
$transacao->setDescricao('teste');
$transacao->setMoeda(986);
$transacao->setNumero(001);
$transacao->setParcelas(1);
$transacao->setValor(1.00);

return $transacao;