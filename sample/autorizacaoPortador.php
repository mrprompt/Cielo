<?php
require_once __DIR__ . '/../vendor/autoload.php';

/* @var $transacao \MrPrompt\Cielo\Cliente */
$cielo      = require_once __DIR__ . '/resources/cliente.php';

/* @var $transacao \MrPrompt\Cielo\Transacao */
$transacao  = require_once __DIR__ . '/resources/transacao.php';

/* @var $transacao \MrPrompt\Cielo\Cartao */
$cartao     = require_once __DIR__ . '/resources/cartao.php';

$requisicao = $cielo->autorizaPortador($transacao, $cartao);

echo 'XML GERADO: ', $requisicao->getEnvio()->asXML(), PHP_EOL;
echo 'RETORNO: ', $requisicao->getResposta(), PHP_EOL;
