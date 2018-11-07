# Cielo

[![Build Status](https://travis-ci.org/mrprompt/Cielo.png)](https://travis-ci.org/mrprompt/Cielo)
[![Maintainability](https://api.codeclimate.com/v1/badges/52ff4029d94a20f9759a/maintainability)](https://codeclimate.com/github/mrprompt/Cielo/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/52ff4029d94a20f9759a/test_coverage)](https://codeclimate.com/github/mrprompt/Cielo/test_coverage)

Cielo é uma biblioteca cliente para o web service da Cielo.

Com esta classe, sua aplicação será capaz de realizar transações a Crédito e Débito.

## ARQUIVADA 

A biblioteca foi arquiva, pois agora como a Cielo possui uma biblioteca oficial, esta cumpriu 
seu papel.

## ATENÇÃO

Esta biblioteca é baseada na versão 1.5.x da API da Cielo, porém a mesma foi descontinuada.
~Alterações neste projeto são apenas para bug fixes e melhorias para a versão mencionada.~
Caso você esteja implementando em um novo projeto, recomendo utilizar a versão 3.x da API.

* https://developercielo.github.io/
* https://developercielo.github.io/manual/webservice-1-5
* https://developercielo.github.io/tutorial/guia-de-migracao

## Requisitos

* PHP 7.1+
* SimpleXML

## Instalação

```console
composer.phar require "mrprompt/cielo"
```

## Exemplos

* [Autorização](#autorização)
* [Autorização Portador](#autorização-portador)
* [Cancelamento](#cancelamento)
* [Captura](#captura)
* [Consulta](#consulta)
* [TID](#tid)
* [Transação](#transação)

### Autorização

```php
use GuzzleHttp\Client;
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Ambiente\Teste;
use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Idioma\Portugues;

/* @var $transacao \MrPrompt\Cielo\Transacao */
$transacao = new Transacao();
$transacao->setTid('10069930691FB8C01001');
$transacao->setAutorizar(2);
$transacao->setCapturar(false);
$transacao->setDataHora(new DateTime());
$transacao->setDescricao('teste');
$transacao->setMoeda(986);
$transacao->setNumero(001);
$transacao->setParcelas(1);
$transacao->setValor(1.00);

/* @var $cielo \MrPrompt\Cielo\Cliente */
$cielo = new Cliente(
    new Autorizacao(NUMERO_CIELO, CHAVE_CIELO),
    new Client(),
    new Portugues(),
    new Teste()
);

try {
    $requisicao = $cielo->autoriza($transacao);

    print_r($requisicao);
} catch (\InvalidArgumentException $ex) {
    echo "# ERRO: {$ex->getCode()} - {$ex->getMessage()}" . PHP_EOL;
}
```

### Autorização Portador

```php
use GuzzleHttp\Client;
use MrPrompt\Cielo\Ambiente\Teste;
use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Idioma\Portugues;
use MrPrompt\Cielo\Cartao;
use MrPrompt\Cielo\Transacao;

/* @var $cielo \MrPrompt\Cielo\Cliente */
$cielo = new Cliente(
    new Autorizacao(NUMERO_CIELO, CHAVE_CIELO),
    new Client(),
    new Portugues(),
    new Teste()
);

/* @var $transacao \MrPrompt\Cielo\Transacao */
$transacao = new Transacao();
$transacao->setTid('10069930691FB8C01001');
$transacao->setAutorizar(2);
$transacao->setCapturar(false);
$transacao->setDataHora(new DateTime());
$transacao->setDescricao('teste');
$transacao->setMoeda(986);
$transacao->setNumero(001);
$transacao->setParcelas(1);
$transacao->setValor(1.00);

/* @var $transacao \MrPrompt\Cielo\Cartao */
$cartao = new Cartao();
$cartao->setBandeira('visa');
$cartao->setCartao('4012001037141112');
$cartao->setCodigoSeguranca('123');
$cartao->setIndicador(0);
$cartao->setNomePortador('Teste');
$cartao->setValidade('201612');

try {
    $requisicao = $cielo->autorizaPortador($transacao, $cartao);

    print_r($requisicao);
} catch (\InvalidArgumentException $ex) {
    echo "# ERRO: {$ex->getCode()} - {$ex->getMessage()}" . PHP_EOL;
}
```

### Cancelamento

```php
use GuzzleHttp\Client;
use MrPrompt\Cielo\Ambiente\Teste;
use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Idioma\Portugues;
use MrPrompt\Cielo\Transacao;

/* @var $transacao \MrPrompt\Cielo\Transacao */
$transacao = new Transacao();
$transacao->setTid('10069930691FB8C01001');

/* @var $transacao \MrPrompt\Cielo\Cliente */
$cielo     = new Cliente(
    new Autorizacao(NUMERO_CIELO, CHAVE_CIELO),
    new Client(),
    new Portugues(),
    new Teste()
);

try {
    $requisicao = $cielo->cancela($transacao);

    print_r($requisicao);
} catch (\InvalidArgumentException $ex) {
    echo "# ERRO: {$ex->getCode()} - {$ex->getMessage()}" . PHP_EOL;
}
```

### Captura

```php
use GuzzleHttp\Client;
use MrPrompt\Cielo\Ambiente\Teste;
use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Idioma\Portugues;
use MrPrompt\Cielo\Transacao;

/* @var $transacao \MrPrompt\Cielo\Transacao */
$transacao = new Transacao();
$transacao->setTid('10069930691FB8C01001');

/* @var $transacao \MrPrompt\Cielo\Cliente */
$cielo     = new Cliente(
    new Autorizacao(NUMERO_CIELO, CHAVE_CIELO),
    new Client(),
    new Portugues(),
    new Teste()
);

try {
    $requisicao = $cielo->captura($transacao);

    print_r($requisicao);
} catch (\InvalidArgumentException $ex) {
    echo "# ERRO: {$ex->getCode()} - {$ex->getMessage()}" . PHP_EOL;
}
```

### Consulta

```php
use GuzzleHttp\Client;
use MrPrompt\Cielo\Ambiente\Teste;
use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Idioma\Portugues;
use MrPrompt\Cielo\Transacao;

/* @var $transacao \MrPrompt\Cielo\Transacao */
$transacao = new Transacao();
$transacao->setTid('10069930691FB8C01001');

/* @var $transacao \MrPrompt\Cielo\Cliente */
$cielo     = new Cliente(
    new Autorizacao(NUMERO_CIELO, CHAVE_CIELO),
    new Client(),
    new Portugues(),
    new Teste()
);

try {
    $requisicao = $cielo->consulta($transacao);

    print_r($requisicao);
} catch (\InvalidArgumentException $ex) {
    echo "# ERRO: {$ex->getCode()} - {$ex->getMessage()}" . PHP_EOL;
}
```

### TID

```php
use GuzzleHttp\Client;
use MrPrompt\Cielo\Ambiente\Teste;
use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Idioma\Portugues;
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cartao;

/* @var $transacao \MrPrompt\Cielo\Cliente */
$cielo     = new Cliente(
    new Autorizacao(NUMERO_CIELO, CHAVE_CIELO),
    new Client(),
    new Portugues(),
    new Teste()
);

/* @var $transacao \MrPrompt\Cielo\Transacao */
$transacao = new Transacao();
$transacao->setAutorizar(2);
$transacao->setCapturar(false);
$transacao->setDataHora(new DateTime());
$transacao->setDescricao('teste');
$transacao->setMoeda(986);
$transacao->setNumero(001);
$transacao->setParcelas(1);
$transacao->setValor(1.00);

/* @var $transacao \MrPrompt\Cielo\Cartao */
$cartao = new Cartao();
$cartao->setBandeira('visa');
$cartao->setCartao('4012001037141112');
$cartao->setCodigoSeguranca('123');
$cartao->setIndicador(0);
$cartao->setNomePortador('Teste');
$cartao->setValidade('201612');

try {
    $requisicao = $cielo->tid($transacao, $cartao);

    print_r($requisicao);
} catch (\InvalidArgumentException $ex) {
    echo "# ERRO: {$ex->getCode()} - {$ex->getMessage()}" . PHP_EOL;
}
```

### Transação

```php
use GuzzleHttp\Client;
use MrPrompt\Cielo\Ambiente\Teste;
use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Idioma\Portugues;
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cartao;

/* @var $transacao \MrPrompt\Cielo\Transacao */
$transacao = new Transacao();
$transacao->setTid('10069930691FB8C01001');
$transacao->setAutorizar(2);
$transacao->setCapturar(false);
$transacao->setDataHora(new DateTime());
$transacao->setDescricao('teste');
$transacao->setMoeda(986);
$transacao->setNumero(001);
$transacao->setParcelas(1);
$transacao->setValor(1.00);

/* @var $transacao \MrPrompt\Cielo\Cartao */
$cartao = new Cartao();
$cartao->setBandeira('visa');
$cartao->setCartao('4012001037141112');
$cartao->setCodigoSeguranca('123');
$cartao->setIndicador(0);
$cartao->setNomePortador('Teste');
$cartao->setValidade('201612');

/* @var $transacao \MrPrompt\Cielo\Cliente */
$cielo     = new Cliente(
    new Autorizacao(NUMERO_CIELO, CHAVE_CIELO),
    new Client(),
    new Portugues(),
    new Teste()
);

try {
    $requisicao = $cielo->iniciaTransacao($transacao, $cartao, 'http://google.com.br');

    print_r($requisicao);
} catch (\InvalidArgumentException $ex) {
    echo "# ERRO: {$ex->getCode()} - {$ex->getMessage()}" . PHP_EOL;
}
```

## Versões anteriores

* PHP 5.5 ~ 5.6: Somente a versão 2.2 é compatível com PHP 5.5 e 5.6
* PHP 5.3 ~ 5.4: Até a versão 2.1, o PHP 5.3 é suportado.
