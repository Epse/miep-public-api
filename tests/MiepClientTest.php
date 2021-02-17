<?php

namespace Tests\MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\AccessToken;
use MaxImmo\ExternalParties\Client;
use MaxImmo\ExternalParties\Exception\UnauthorizedException;
use MaxImmo\ExternalParties\MiepClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MiepClientTest extends TestCase
{
    /** @var Client | MockObject */
    private $client;
    /** @var AccessToken | MockObject */
    private $accessToken;
    /** @var MiepClient */
    private $miepClient;

    public function setUp(): void
    {
        $this->client = $this->createMock('MaxImmo\ExternalParties\Client');
        $this->accessToken = $this->createMock('MaxImmo\ExternalParties\AccessToken');
        $this->miepClient = new MiepClient('client_id', 'secret', $this->client);
    }

    /**
     * GetBrokers
     */
    public function test_GetBrokers_Calls_Client_GetBrokers_Once_On_Immediate_Success()
    {
        $this->client->expects($this->once())->method('getBrokers');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getBrokers();
    }

    public function test_GetBrokers_Calls_Client_GetBrokers_Should_Return_Client_Result()
    {
        $this->client->expects($this->any())->method('getBrokers')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getBrokers();
        $this->assertEquals('something', $result);
    }

    public function test_GetBrokers_Calls_Client_GetBrokers_Exactly_Twice_When_First_Call_Throws_UnauthorizedException()
    {
        $this->expectException(UnauthorizedException::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getBrokers')
            ->willThrowException(new UnauthorizedException());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $this->miepClient->getBrokers();
    }

    /**
     * GetInformationForBroker
     */
    public function test_GetInformationForBroker_Calls_Client_GetInformationForBroker_Once_On_Immediate_Success()
    {
        $this->client->expects($this->once())->method('getInformationForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getInformationForBroker('brokerId');
    }

    public function test_GetInformationForBroker_Calls_Client_GetInformationForBroker_Should_Return_Client_Result()
    {
        $this->client->expects($this->any())->method('getInformationForBroker')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getInformationForBroker('brokerId');
        $this->assertEquals('something', $result);
    }

    public function test_GetInformationForBroker_Calls_Client_GetInformationForBroker_Exactly_Twice_When_First_Call_Throws_UnauthorizedException()
    {
        $this->expectException(UnauthorizedException::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getInformationForBroker')
            ->willThrowException(new UnauthorizedException());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $this->miepClient->getInformationForBroker('brokerId');
    }

    /**
     * GetRealEstateListForBroker
     */
    public function test_GetRealEstateListForBroker_Calls_Client_GetRealEstateListForBroker_Once_On_Immediate_Success()
    {
        $this->client->expects($this->once())->method('getRealEstateListForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getRealEstateListForBroker('brokerId');
    }

    public function test_GetRealEstateListForBroker_Calls_Client_GetRealEstateListForBroker_Should_Return_Client_Result()
    {
        $this->client->expects($this->any())->method('getRealEstateListForBroker')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getRealEstateListForBroker('brokerId');
        $this->assertEquals('something', $result);
    }

    public function test_GetRealEstateListForBroker_Calls_Client_GetRealEstateListForBroker_Exactly_Twice_When_First_Call_Throws_UnauthorizedException()
    {
        $this->expectException(UnauthorizedException::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getRealEstateListForBroker')
            ->willThrowException(new UnauthorizedException());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $this->miepClient->getRealEstateListForBroker('brokerId');
    }

    /**
     * GetPropertyForBroker
     */
    public function test_GetPropertyForBroker_Calls_Client_GetPropertyForBroker_Once_On_Immediate_Success()
    {
        $this->client->expects($this->once())->method('getPropertyForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getPropertyForBroker('brokerId', 'propertyId');
    }

    public function test_GetPropertyForBroker_Calls_Client_GetPropertyForBroker_Should_Return_Client_Result()
    {
        $this->client->expects($this->any())->method('getPropertyForBroker')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getPropertyForBroker('brokerId', 'propertyId');
        $this->assertEquals('something', $result);
    }

    public function test_GetPropertyForBroker_Calls_Client_GetPropertyForBroker_Exactly_Twice_When_First_Call_Throws_UnauthorizedException()
    {
        $this->expectException(UnauthorizedException::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getPropertyForBroker')
            ->willThrowException(new UnauthorizedException());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $this->miepClient->getPropertyForBroker('brokerId', 'propertyId');
    }

    /**
     * GetProjectForBroker
     */
    public function test_GetProjectForBroker_Calls_Client_GetProjectForBroker_Once_On_Immediate_Success()
    {
        $this->client->expects($this->once())->method('getProjectForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getProjectForBroker('brokerId', 'projectId');
    }

    public function test_GetProjectForBroker_Calls_Client_GetProjectForBroker_Should_Return_Client_Result()
    {
        $this->client->expects($this->any())->method('getProjectForBroker')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getProjectForBroker('brokerId', 'projectId');
        $this->assertEquals('something', $result);
    }

    public function test_GetProjectForBroker_Calls_Client_GetProjectForBroker_Exactly_Twice_When_First_Call_Throws_UnauthorizedException()
    {
        $this->expectException(UnauthorizedException::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getProjectForBroker')
            ->willThrowException(new UnauthorizedException());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $this->miepClient->getProjectForBroker('brokerId', 'projectId');
    }
}
