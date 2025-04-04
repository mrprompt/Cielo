# Cielo

[![Tests](https://github.com/mrprompt/cielo-v4/actions/workflows/tests.yml/badge.svg)](https://github.com/mrprompt/cielo-v4/actions/workflows/tests.yml)

Cielo é uma biblioteca cliente para o web service da Cielo.

Com esta classe, sua aplicação será capaz de realizar transações a Crédito e Débito.

## AVISO

**Esta versão é totalmente incompatível com as versões anteriores da biblioteca.**

## Requisitos

* PHP 8.2+

## Instalação

```console
composer require mrprompt/cielo "^4.0"
```

## Exemplos

Para executar os exemplos, copie o arquivo .env.example do diretório exemplos para .env e edite os campos:

* CIELO_MERCHANT_ID
* CIELO_MERCHANT_KEY

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

## Versões anteriores

* PHP 8.2 ~ 8.4: Somente versão 4 em diante
* PHP 5.5 ~ 5.6: Somente a versão 2.2 é compatível com PHP 5.5 e 5.6
* PHP 5.3 ~ 5.4: Até a versão 2.1, o PHP 5.3 é suportado.
