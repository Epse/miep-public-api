<?php

namespace Tests\MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\AccessToken;
use MaxImmo\ExternalParties\Exception\InvalidAccessTokenException;
use PHPUnit\Framework\TestCase;

class AccessTokenTest extends TestCase
{
    public function test_Constructor_Throws_InvalidArgumentException_When_Input_Is_Empty()
    {
        $this->expectException(InvalidAccessTokenException::class);
        new AccessToken('');
    }

    public function test_Constructor_Throws_InvalidArgumentException_When_Input_Is_Not_A_String()
    {
        $this->expectException(InvalidAccessTokenException::class);
        new AccessToken(1);
    }

    public function test_GetAccessToken_Returns_Correct_Value()
    {
        $accessToken = new AccessToken('value');
        $this->assertEquals('value', $accessToken->getAccessToken());
    }
}
