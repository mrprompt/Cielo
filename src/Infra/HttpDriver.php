<?php

namespace MrPrompt\Cielo\Infra;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use MrPrompt\Cielo\Exceptions\CieloApiErrors;
use MrPrompt\Cielo\Infra\Ambiente;

class HttpDriver
{
    private $defaultHeaders = [];

    public function __construct(
        private readonly Ambiente $ambiente,
        private readonly Client $client,
        private readonly Autenticacao $autenticacao,
    ) {
        $this->defaultHeaders = [
            'Content-Type' => 'application/json',
            'MerchantId' => $this->autenticacao->merchantId,
            'MerchantKey' => $this->autenticacao->merchantKey,
        ];
    }

    public function post(string $uri, array $data)
    {
        try {
            $content = [
                'headers' => $this->defaultHeaders,
            ];

            if (count($data) > 0) {
                $content['json'] = $data;
            }

            return $this->client->post($this->ambiente->transacional() . $uri, $content);
        } catch (RequestException $e) {
            $cieloException = new CieloApiErrors('Erro, confira em $erros', $e->getCode(), $e->getPrevious());
            $cieloException->setDetails($e);

            throw $cieloException;
        }
    }

    public function get(string $uri)
    {
        try {
            return $this->client->get($this->ambiente->consultas() . $uri, ['headers' => $this->defaultHeaders]);
        } catch (RequestException $e) {
            $cieloException = new CieloApiErrors('Erro, confira em $erros', $e->getCode(), $e->getPrevious());
            $cieloException->setDetails($e);

            throw $cieloException;
        }
    }

    public function put(string $uri, array $data = [])
    {
        try {
            $content = [
                'headers' => $this->defaultHeaders,
            ];

            if (count($data) > 0) {
                $content['json'] = $data;
            }

            return $this->client->put($this->ambiente->transacional() . $uri, $content);
        } catch (RequestException $e) {
            $cieloException = new CieloApiErrors('Erro, confira em $erros', $e->getCode(), $e->getPrevious());
            $cieloException->setDetails($e);

            throw $cieloException;
        }
    }
}
