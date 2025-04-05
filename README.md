# Cielo

[![Tests](https://github.com/mrprompt/cielo-v4/actions/workflows/tests.yml/badge.svg)](https://github.com/mrprompt/cielo-v4/actions/workflows/tests.yml)

Esta é uma biblioteca cliente para a API da [Cielo](https://www.cielo.com.br/).

## AVISO

**Esta versão foi inteiramente reescrita e é totalmente incompatível com as versões anteriores da biblioteca.**

## Requisitos

* PHP 8.2+

## Instalação

```console
composer require mrprompt/cielo "^4.0"
```

## Exemplos

Para todos os recursos suportados pela biblioteca, existe um exemplo de código no diretório de [exemplos](./exemplos/).
Para executa-los, copie o arquivo .env.example do diretório .env e edite os campos:

* CIELO_MERCHANT_ID
* CIELO_MERCHANT_KEY

Você pode obter as credencias diretamente na [documentação](https://docs.cielo.com.br/) da [Cielo](https://www.cielo.com.br/).

## Recursos disponíveis

* **Consulta BIN**
  * [Consultar BIN do cartão](https://docs.cielo.com.br/ecommerce-cielo/reference/consulta-bin-cartao)
* **Zero Auth**
  * [Validar cartão com o Zero Auth](https://docs.cielo.com.br/ecommerce-cielo/reference/validar-cartao)
  * [Validar cartão tokenizado](https://docs.cielo.com.br/ecommerce-cielo/reference/validar-cartao-tokenizado)
  * [Validar cartão de e-wallet](https://docs.cielo.com.br/ecommerce-cielo/reference/validar-cartao-e-wallet)
* **Cartão de crédito**
  * [Criar pagamento com cartão de crédito](https://docs.cielo.com.br/ecommerce-cielo/reference/criar-pagamento-credito)
  * [Capturar transação de crédito após a autorização](https://docs.cielo.com.br/ecommerce-cielo/reference/capturar-apos-autorizacao)
  * [Cancelar transação de crédito via PaymentId](https://docs.cielo.com.br/ecommerce-cielo/reference/cancelamento-paymentid)
  * [Cancelar transação de crédito via MerchantOrderId](https://docs.cielo.com.br/ecommerce-cielo/reference/cancelamento-merchantorderid)
* **Cartão de débito**
  * [Criar pagamento com cartão de débito](https://docs.cielo.com.br/ecommerce-cielo/reference/debito)
  * [Cancelar transação de débito via PaymentId](https://docs.cielo.com.br/ecommerce-cielo/reference/cancelamento-d%C3%A9bito-paymentid)
  * [Cancelar transação de débito via MerchantOrderId](https://docs.cielo.com.br/ecommerce-cielo/reference/cancelamento-debito-merchantorderid)
* **PIX**
  * [Criar pagamento com QRCode Pix](https://docs.cielo.com.br/ecommerce-cielo/reference/qrcode-pix)
  * [Solicitar uma devolução Pix](https://docs.cielo.com.br/ecommerce-cielo/reference/devolu%C3%A7ao-pix-api)
* **Boleto**
  * [Criar pagamento com boleto](https://docs.cielo.com.br/ecommerce-cielo/reference/boleto-api)
* **Tokenização**
  * [Criar cartão tokenizado antes da autorização](https://docs.cielo.com.br/ecommerce-cielo/reference/criar-cardtoken)

## Adicionais

Para [Laravel](https://laravel.com/)/[Lumen](https://lumen.laravel.com) foi desenvolvido um _Service Provider_ para facilitar o uso da biblioteca.
Você pode obter mais detalhes sobre uso ou instalação diretamente no [repositório](https://github.com/mrprompt/cielo-service-provider).

## Debug

Para todas as requisições/recursos, você pode obter no retorno as propriedades `jsonEnvio` e `jsonRecebimento`, com o corpo da requisição
e da resposta da API.
