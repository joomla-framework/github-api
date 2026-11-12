<?php

/**
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests;

use Joomla\Github\Package\Authorization;
use Joomla\Github\Tests\Stub\GitHubTestCase;

/**
 * Test class for Authorization.
 *
 * @since  1.0
 */
class AuthorizationsTest extends GitHubTestCase
{
    /**
     * @var Authorization
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     *
     * @since   1.0
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Authorization($this->options, $this->client);
    }

    /**
     * Tests the getRateLimit method
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetRateLimit()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/rate_limit')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->getRateLimit(),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the getRateLimit method for an unlimited user.
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetRateLimitUnlimited()
    {
        $this->response = $this->getResponseObject('', 404);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/rate_limit')
            ->willReturn($this->response);

        $this->assertFalse($this->object->getRateLimit()->limit, 'The limit should be false for unlimited');
    }

    /**
     * Tests the getRateLimit method - failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetRateLimitFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/rate_limit')
            ->willReturn($this->response);

        $this->object->getRateLimit();
    }

    /**
     * Tests the getAuthorizationLink method
     *
     * @return  void
     */
    public function testGetAuthorizationLink()
    {
        $this->response = $this->getResponseObject('https://github.com/login/oauth/authorize?client_id=12345'
            . '&redirect_uri=aaa&scope=bbb&state=ccc', 200);

        $response = (string) $this->response->getBody();

        $this->assertEquals(
            $response,
            $this->object->getAuthorizationLink('12345', 'aaa', 'bbb', 'ccc')
        );
    }

    /**
     * Tests the requestToken method
     *
     * @return  void
     */
    public function testRequestToken()
    {
        $this->response = $this->getResponseObject('');

        $this->client->expects($this->once())
            ->method('post')
            ->with('https://github.com/login/oauth/access_token')
            ->willReturn($this->response);

        $response = (string) $this->response->getBody();

        $this->assertEquals(
            $response,
            $this->object->requestToken('12345', 'aaa', 'bbb', 'ccc')
        );
    }

    /**
     * Tests the requestTokenJson method
     *
     * @return  void
     */
    public function testRequestTokenJson()
    {
        $this->response = $this->getResponseObject('');

        $this->client->expects($this->once())
            ->method('post')
            ->with('https://github.com/login/oauth/access_token')
            ->willReturn($this->response);

        $response = (string) $this->response->getBody();

        $this->assertEquals(
            $response,
            $this->object->requestToken('12345', 'aaa', 'bbb', 'ccc', 'json')
        );
    }

    /**
     * Tests the requestTokenXml method
     *
     * @return  void
     */
    public function testRequestTokenXml()
    {
        $this->response = $this->getResponseObject('');

        $this->client->expects($this->once())
            ->method('post')
            ->with('https://github.com/login/oauth/access_token')
            ->willReturn($this->response);

        $response = (string) $this->response->getBody();

        $this->assertEquals(
            $response,
            $this->object->requestToken('12345', 'aaa', 'bbb', 'ccc', 'xml')
        );
    }

    /**
     * Tests the requestTokenInvalidFormat method
     *
     * @return  void
     */
    public function testRequestTokenInvalidFormat()
    {
        $this->expectException(\UnexpectedValueException::class);

        $this->response = $this->getResponseObject('');

        $this->object->requestToken('12345', 'aaa', 'bbb', 'ccc', 'invalid');
    }
}
