<?php

namespace MrPrompt\Cielo\Tests\Infra;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use MrPrompt\Cielo\Contratos\Ambiente;
use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\Infra\Autenticacao;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class HttpDriverTest extends TestCase
{
    private $mockClient;
    private $mockAmbiente;
    private $mockAutenticacao;
    private $httpDriver;

    public function setUp(): void
    {
        parent::setUp();

        // Cria mocks para as dependências
        $this->mockClient = $this->createMock(Client::class);
        $this->mockAmbiente = $this->createMock(Ambiente::class);
        $this->mockAutenticacao = $this->getMockBuilder(Autenticacao::class)
                                        ->setConstructorArgs(['test-merchant-id', 'test-merchant-key'])
                                        ->getMock();
        $this->httpDriver = new HttpDriver($this->mockAmbiente, $this->mockClient, $this->mockAutenticacao);
    }

    #[Test]
    public function construtor()
    {
        // Verifica se a instância foi criada corretamente
        $this->assertInstanceOf(HttpDriver::class, $this->httpDriver);
    }

    #[Test]
    public function postWithValidUrl()
    {
        // Define valores para o mock de Client
        $this->mockClient->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('test-uri'),
                $this->equalTo([
                    'json' => ['test-data'],
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'MerchantId' => 'test-merchant-id',
                        'MerchantKey' => 'test-merchant-key',
                    ],
                ])
            );

        // Chama o método post da classe HttpClient
        $this->httpDriver->post('test-uri', ['test-data']);
    }

    #[Test]
    public function postWithInvalidUrl()
    {
        $jsonObject = json_encode([]);
        $mockResponse = $this->getMockBuilder(Response::class)->getMock();
        $mockResponse->method('getBody')->willReturn(new Stream(fopen('data://application/json,' . $jsonObject,'r')));

        // Define valores para o mock de Client
        $this->mockClient->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('test-uri-error'),
                $this->equalTo([
                    'json' => ['test-data'],
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'MerchantId' => 'test-merchant-id',
                        'MerchantKey' => 'test-merchant-key',
                    ],
                ])
            )
            ->willReturn($mockResponse);

        // Chama o método post da classe HttpClient
        $this->httpDriver->post('test-uri-error', ['test-data']);
    }

    #[Test]
    public function getWithValidUrl()
    {
        // Define valores para o mock de Client
        $this->mockClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('test-uri'),
                $this->equalTo([
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'MerchantId' => 'test-merchant-id',
                        'MerchantKey' => 'test-merchant-key',
                    ],
                ])
            );

        // Chama o método get da classe HttpClient
        $this->httpDriver->get('test-uri', []);
    }

    #[Test]
    public function getWithInvalidUrl()
    {
        $jsonObject = json_encode([]);
        $mockResponse = $this->getMockBuilder(Response::class)->getMock();
        $mockResponse->method('getBody')->willReturn(new Stream(fopen('data://application/json,' . $jsonObject,'r')));

        // Define valores para o mock de Client
        $this->mockClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('test-uri-error'),
                $this->equalTo([
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'MerchantId' => 'test-merchant-id',
                        'MerchantKey' => 'test-merchant-key',
                    ],
                ])
            )
            ->willReturn($mockResponse);

        // Chama o método post da classe HttpClient
        $this->httpDriver->get('test-uri-error');
    }

    #[Test]
    public function putWithValidUrl()
    {
        // Define valores para o mock de Client
        $this->mockClient->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo('test-uri'),
                $this->equalTo([
                    'json' => ['test-data'],
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'MerchantId' => 'test-merchant-id',
                        'MerchantKey' => 'test-merchant-key',
                    ],
                ])
            );

        // Chama o método post da classe HttpClient
        $this->httpDriver->put('test-uri', ['test-data']);
    }

    #[Test]
    public function putWithInvalidUrl()
    {
        $jsonObject = json_encode([]);
        $mockResponse = $this->getMockBuilder(Response::class)->getMock();
        $mockResponse->method('getBody')->willReturn(new Stream(fopen('data://application/json,' . $jsonObject,'r')));

        // Define valores para o mock de Client
        $this->mockClient->expects($this->once())
            ->method('put')
            ->with(
                $this->equalTo('test-uri-error'),
                $this->equalTo([
                    'json' => ['test-data'],
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'MerchantId' => 'test-merchant-id',
                        'MerchantKey' => 'test-merchant-key',
                    ],
                ])
            )
            ->willReturn($mockResponse);

        // Chama o método post da classe HttpClient
        $this->httpDriver->put('test-uri-error', ['test-data']);
    }
}
