<?php

namespace Tests\MaxImmo\ExternalParties;

use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use MaxImmo\ExternalParties\AccessToken;
use MaxImmo\ExternalParties\Client;
use MaxImmo\ExternalParties\Exception\NoAccessTokenException;
use MaxImmo\ExternalParties\ResponseEvaluator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ClientTest extends TestCase
{
    /** @var HttpClient | MockObject */
    private $httpClient;
    /** @var MessageFactory | MockObject */
    private $messageFactory;
    /** @var ResponseEvaluator | MockObject */
    private $responseEvaluator;
    /** @var AccessToken | MockObject */
    private $accessToken;
    /** @var RequestInterface | MockObject */
    private $request;
    /** @var ResponseInterface | MockObject */
    private $response;
    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpClient::class);
        $this->messageFactory = $this->createMock(MessageFactory::class);
        $this->responseEvaluator = $this->createMock(ResponseEvaluator::class);
        $this->accessToken = $this->createMock(AccessToken::class);
        $this->request = $this->createMock(RequestInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->client = new Client($this->httpClient, $this->messageFactory, $this->responseEvaluator);

        $this->httpClient
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn($this->response);
    }

    public function test_GetBrokers_Should_Perform_Request_Using_Correct_Parameters()
    {
        $this->messageFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with(
                'GET',
                '/api/brokers',
                ['Authorization' => 'Bearer ', 'Content-Type' => 'application/problem+json']
            )
            ->willReturn($this->request);

        $this->client->getBrokers($this->accessToken);
    }

    public function test_GetRealEstateListForBroker_Should_Perform_Request_Using_Correct_Parameters()
    {
        $this->messageFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with(
                'GET',
                '/api/brokers/brokerId/real-estate',
                ['Authorization' => 'Bearer ', 'Content-Type' => 'application/problem+json']
            )
            ->willReturn($this->request);

        $this->client->getRealEstateListForBroker('brokerId', $this->accessToken);
    }

    public function test_GetPropertyForBroker_Should_Perform_Request_Using_Correct_Parameters()
    {
        $this->messageFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with(
                'GET',
                '/api/brokers/brokerId/real-estate/properties/propertyId',
                ['Authorization' => 'Bearer ', 'Content-Type' => 'application/problem+json']
            )
            ->willReturn($this->request);

        $this->client->getPropertyForBroker('brokerId', 'propertyId', $this->accessToken);
    }

    public function test_GetProjectForBroker_Should_Perform_Request_Using_Correct_Parameters()
    {
        $this->messageFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with(
                'GET',
                '/api/brokers/brokerId/real-estate/projects/projectId',
                ['Authorization' => 'Bearer ', 'Content-Type' => 'application/problem+json']
            )
            ->willReturn($this->request);

        $this->client->getProjectForBroker('brokerId', 'projectId', $this->accessToken);
    }

    public function test_GetAccessToken_Should_Perform_Request_Using_Correct_Parameters()
    {
        $this->expectException(NoAccessTokenException::class);
        $this->messageFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with(
                'GET',
                '/api/oauth',
                ['Authorization' => 'Basic ', 'Content-Type' => 'application/problem+json']
            )
            ->willReturn($this->request);

        $this->client->getAccessToken(null);
    }

    public function test_GetAccessToken_Should_Return_AccessToken_If_Exists()
    {
        $this->messageFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with(
                'GET',
                '/api/oauth',
                ['Authorization' => 'Basic ', 'Content-Type' => 'application/problem+json']
            )
            ->willReturn($this->request);
        $this->responseEvaluator
            ->expects($this->any())
            ->method('evaluateResponse')
            ->willReturn(['access_token' => 'random_token']);

        $token = $this->client->getAccessToken(null);
        $this->assertEquals(new AccessToken('random_token'), $token);
    }
}
