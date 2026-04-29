<?php

namespace MrPrompt\Cielo\Infra;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use MrPrompt\Cielo\Exceptions\CieloApiErrors;
use MrPrompt\Cielo\Contratos\Ambiente as AmbienteInterface;
use Psr\Http\Message\ResponseInterface;

class HttpDriver
{
    private readonly array $defaultHeaders;

    public function __construct(
        private readonly AmbienteInterface $ambiente,
        private readonly Client $client,
        private readonly Autenticacao $autenticacao,
    ) {
        $this->defaultHeaders = [
            'Content-Type' => 'application/json',
            'MerchantId' => $this->autenticacao->merchantId,
            'MerchantKey' => $this->autenticacao->merchantKey,
        ];
    }

    public function post(string $uri, array $data): ResponseInterface
    {
        try {
            $content = [
                'headers' => $this->defaultHeaders,
                ...($data !== [] ? ['json' => $data] : []),
            ];

            return $this->client->post($this->ambiente->transacional() . $uri, $content);
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    public function get(string $uri): ResponseInterface
    {
        try {
            return $this->client->get(
                $this->ambiente->consultas() . $uri,
                ['headers' => $this->defaultHeaders]
            );
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    public function put(string $uri, array $data = []): ResponseInterface
    {
        try {
            $content = [
                'headers' => $this->defaultHeaders,
                ...($data !== [] ? ['json' => $data] : []),
            ];

            return $this->client->put($this->ambiente->transacional() . $uri, $content);
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        }
    }

    private function handleRequestException(RequestException $e): never
    {
        $cieloException = new CieloApiErrors('Erro, confira em $erros', $e->getCode(), $e->getPrevious());
        $cieloException->setDetails($e);
        throw $cieloException;
    }
}
