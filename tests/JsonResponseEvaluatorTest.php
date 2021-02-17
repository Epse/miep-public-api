<?php

namespace Tests\MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\Exception\BadRequestException;
use MaxImmo\ExternalParties\Exception\NotFoundException;
use MaxImmo\ExternalParties\Exception\ServiceUnavailableException;
use MaxImmo\ExternalParties\Exception\TooManyRequestsException;
use MaxImmo\ExternalParties\Exception\UnauthorizedException;
use MaxImmo\ExternalParties\Exception\UnexpectedResponseException;
use MaxImmo\ExternalParties\Http\StatusCode;
use MaxImmo\ExternalParties\JsonResponseEvaluator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class JsonResponseEvaluatorTest extends TestCase
{
    /** @var JsonResponseEvaluator */
    private $evaluator;
    /** @var ResponseInterface | MockObject */
    private $response;
    /** @var StreamInterface | MockObject */
    private $body;

    public function setUp(): void
    {
        $this->evaluator = new JsonResponseEvaluator();
        $this->response = $this->createMock(ResponseInterface::class);
        $this->body = $this->createMock(StreamInterface::class);
        $this->response->expects($this->any())->method('getBody')->willReturn($this->body);
    }

    public function test_EvaluateResponse_Should_Return_JsonDecoded_Content()
    {
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::OK);
        $this->body->expects($this->any())->method('getContents')->willReturn('{"someKey": "someValue"}');
        $result = $this->evaluator->evaluateResponse($this->response);
        $this->assertEquals(['someKey' => 'someValue'], $result);
    }

    public function test_EvaluateResponse_Should_Throw_BadRequestException_On_Bad_Request()
    {
        $this->expectException(BadRequestException::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::BAD_REQUEST);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function test_EvaluateResponse_Should_Throw_UnauthorizedException_On_Unauthorized()
    {
        $this->expectException(UnauthorizedException::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::UNAUTHORIZED);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function test_EvaluateResponse_Should_Throw_NotFoundException_On_Not_Found()
    {
        $this->expectException(NotFoundException::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::NOT_FOUND);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function test_EvaluateResponse_Should_Throw_TooManyRequestsException_On_Too_Many_Requests()
    {
        $this->expectException(TooManyRequestsException::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::TOO_MANY_REQUESTS);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function test_EvaluateResponse_Should_Throw_TooManyRequestsException_On_Service_Unavailable()
    {
        $this->expectException(ServiceUnavailableException::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::SERVICE_UNAVAILABLE);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function test_EvaluateResponse_Should_Throw_UnexpectedResponseException_On_Unknown_StatusCode()
    {
        $this->expectException(UnexpectedResponseException::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn('unknown');
        $this->evaluator->evaluateResponse($this->response);
    }
}
