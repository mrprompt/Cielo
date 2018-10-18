# Cielo

[![Build Status](https://travis-ci.org/mrprompt/Cielo.png)](https://travis-ci.org/mrprompt/Cielo)
[![Maintainability](https://api.codeclimate.com/v1/badges/52ff4029d94a20f9759a/maintainability)](https://codeclimate.com/github/mrprompt/Cielo/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/52ff4029d94a20f9759a/test_coverage)](https://codeclimate.com/github/mrprompt/Cielo/test_coverage)

Cielo é uma biblioteca cliente para o web service da Cielo.

Com esta classe, sua aplicação será capaz de realizar transações a Crédito e Débito.

## ATENÇÃO

Esta biblioteca é baseada na versão 1.5.x da API da Cielo, porém a mesma foi descontinuada.
Alterações neste projeto são apenas para bug fixes e melhorias para a versão mencionada. 
Caso você esteja implementando em um novo projeto, recomendo utilizar a versão 3.x da API.

* https://developercielo.github.io/
* https://developercielo.github.io/manual/webservice-1-5
* https://developercielo.github.io/tutorial/guia-de-migracao

## ATENÇÃO 2

Não use a branch de desenvolvimento em ambientes de produção. Nela estão correções de bugs 
mas também experimentos de refatoração para melhorar a qualidade do código, por isso, a mesma
é extremamente passível de erros e bugs.

## Requisitos

* PHP 7.2+
* SimpleXML

## Instalação

```console
composer.phar require "mrprompt/cielo"
```

## Exemplos

* [Ambiente](#ambiente)
* [Autorização](#autorização)
* [Autorização Portador](#autorização-portador)
* [Cancelamento](#cancelamento)
* [Captura](#captura)
* [Consulta](#consulta)
* [TID](#tid)
* [Transação](#transação)

### Ambiente

```php
use GuzzleHttp\Client as ClienteHttp;
use MrPrompt\Cielo\Ambiente\Teste;
use MrPrompt\Cielo\Idioma\Portugues;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Autorizacao;

/* @var $cielo \MrPrompt\Cielo\Cliente */
$cielo = new Cliente(
    new Autorizacao(NUMERO_CIELO, CHAVE_CIELO),
    new ClienteHttp(),
    new Portugues(),
    new Teste()
);
```

### Autorização

```php
use MrPrompt\Cielo\Transacao;

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

$requisicao = $cielo->autoriza($transacao);

print_r($requisicao);
```

### Autorização Portador

```php
use MrPrompt\Cielo\Cartao;
use MrPrompt\Cielo\Transacao;

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

$requisicao = $cielo->autorizaPortador($transacao, $cartao);

print_r($requisicao);
```

### Cancelamento

```php
use MrPrompt\Cielo\Transacao;

/* @var $transacao \MrPrompt\Cielo\Transacao */
$transacao = new Transacao();
$transacao->setTid('10069930691FB8C01001');

$requisicao = $cielo->cancela($transacao);

print_r($requisicao);
```

### Captura

```php
use MrPrompt\Cielo\Transacao;

/* @var $transacao \MrPrompt\Cielo\Transacao */
$transacao = new Transacao();
$transacao->setTid('10069930691FB8C01001');

$requisicao = $cielo->captura($transacao);

print_r($requisicao);
```

### Consulta

```php
use MrPrompt\Cielo\Transacao;

/* @var $transacao \MrPrompt\Cielo\Transacao */
$transacao = new Transacao();
$transacao->setTid('10069930691FB8C01001');

$requisicao = $cielo->consulta($transacao);

print_r($requisicao);
```

### TID

```php
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cartao;

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

$requisicao = $cielo->tid($transacao, $cartao);

print_r($requisicao);
```

### Transação

```php
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

$requisicao = $cielo->iniciaTransacao($transacao, $cartao, 'http://google.com.br');

print_r($requisicao);
```

## Versões anteriores

* PHP 5.5 ~ 5.6: Somente a versão 2.2 é compatível com PHP 5.5 e 5.6
* PHP 5.3 ~ 5.4: Até a versão 2.1, o PHP 5.3 é suportado.
