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
     * Tests the createAuthorisation method
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testCreate()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $authorisation = '{'
            . '"scopes":["public_repo"],'
            . '"note":"My test app",'
            . '"note_url":"http:\/\/www.joomla.org"'
            . '}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/authorizations', $authorisation)
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->create(['public_repo'], 'My test app', 'http://www.joomla.org'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the createAuthorisation method - simulated failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testCreateFailure()
    {
        $exception = false;

        $this->response = $this->getResponseObject($this->errorString, 500);

        $authorisation = '{'
            . '"scopes":["public_repo"],'
            . '"note":"My test app",'
            . '"note_url":"http:\/\/www.joomla.org"'
            . '}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/authorizations', $authorisation)
            ->willReturn($this->response);

        try {
            $this->object->create(['public_repo'], 'My test app', 'http://www.joomla.org');
        } catch (\DomainException $e) {
            $exception = true;

            $this->assertThat(
                $e->getMessage(),
                $this->equalTo(json_decode($this->errorString)->message)
            );
        }

        $this->assertTrue($exception);
    }

    /**
     * Tests the delete method
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testDelete()
    {
        $this->response = $this->getResponseObject($this->sampleString, 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/authorizations/42')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->delete(42),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the delete method - simulated failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testDeleteFailure()
    {
        $exception = false;

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/authorizations/42')
            ->willReturn($this->response);

        try {
            $this->object->delete(42);
        } catch (\DomainException $e) {
            $exception = true;

            $this->assertThat(
                $e->getMessage(),
                $this->equalTo(json_decode($this->errorString)->message)
            );
        }

        $this->assertTrue($exception);
    }

    /**
     * Tests the deleteGrant method
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testDeleteGrant()
    {
        $this->response = $this->getResponseObject($this->sampleString, 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/authorizations/grants/42')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->deleteGrant(42),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the deleteGrant method - simulated failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testDeleteGrantFailure()
    {
        $exception = false;

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/authorizations/grants/42')
            ->willReturn($this->response);

        try {
            $this->object->deleteGrant(42);
        } catch (\DomainException $e) {
            $exception = true;

            $this->assertThat(
                $e->getMessage(),
                $this->equalTo(json_decode($this->errorString)->message)
            );
        }

        $this->assertTrue($exception);
    }

    /**
     * Tests the editAuthorisation method - Add scopes
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testEditAddScopes()
    {
        $authorisation = '{'
            . '"add_scopes":["public_repo","gist"],'
            . '"note":"My test app",'
            . '"note_url":"http:\/\/www.joomla.org"'
            . '}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/authorizations/42', $authorisation)
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->edit(42, [], ['public_repo', 'gist'], [], 'My test app', 'http://www.joomla.org'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the editAuthorisation method - Remove scopes
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testEditRemoveScopes()
    {
        $authorisation = '{'
            . '"remove_scopes":["public_repo","gist"],'
            . '"note":"My test app",'
            . '"note_url":"http:\/\/www.joomla.org"'
            . '}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/authorizations/42', $authorisation)
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->edit(42, [], [], ['public_repo', 'gist'], 'My test app', 'http://www.joomla.org'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the editAuthorisation method - Scopes param
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testEditScopes()
    {
        $authorisation = '{'
            . '"scopes":["public_repo","gist"],'
            . '"note":"My test app",'
            . '"note_url":"http:\/\/www.joomla.org"'
            . '}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/authorizations/42', $authorisation)
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->edit(42, ['public_repo', 'gist'], [], [], 'My test app', 'http://www.joomla.org'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the editAuthorisation method - simulated failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testEditFailure()
    {
        $exception = false;

        $this->response = $this->getResponseObject($this->errorString, 500);

        $authorisation = '{'
            . '"add_scopes":["public_repo","gist"],'
            . '"note":"My test app",'
            . '"note_url":"http:\/\/www.joomla.org"'
            . '}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/authorizations/42', $authorisation)
            ->willReturn($this->response);

        try {
            $this->object->edit(42, [], ['public_repo', 'gist'], [], 'My test app', 'http://www.joomla.org');
        } catch (\DomainException $e) {
            $exception = true;

            $this->assertThat(
                $e->getMessage(),
                $this->equalTo(json_decode($this->errorString)->message)
            );
        }

        $this->assertTrue($exception);
    }

    /**
     * Tests the editAuthorisation method - too many scope params
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testEditTooManyScopes()
    {
        $this->expectException(\RuntimeException::class);

        $this->object->edit(42, [], ['public_repo', 'gist'], ['public_repo', 'gist'], 'My test app', 'http://www.joomla.org');
    }

    /**
     * Tests the get method
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/authorizations/42')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->get(42),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the get method - failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/authorizations/42')
            ->willReturn($this->response);

        $this->object->get(42);
    }

    /**
     * Tests the getGrant method
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetGrant()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/authorizations/grants/42')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->getGrant(42),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the getGrant method - failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetGrantFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/authorizations/grants/42')
            ->willReturn($this->response);

        $this->object->getGrant(42);
    }

    /**
     * Tests the getList method
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/authorizations')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->getList(),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the getList method - failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetListFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/authorizations')
            ->willReturn($this->response);

        $this->object->getList();
    }

    /**
     * Tests the getListGrants method
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetListGrants()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/authorizations/grants')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->getListGrants(),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the getListGrants method - failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testGetListGrantsFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/authorizations/grants')
            ->willReturn($this->response);

        $this->object->getListGrants();
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

    /**
     * Tests the revokeGrantForApplication method
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testRevokeGrantForApplication()
    {
        $this->response = $this->getResponseObject($this->sampleString, 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/applications/42/grants/1a2b3c')
            ->willReturn($this->response);

        $this->assertThat(
            $this->object->revokeGrantForApplication(42, '1a2b3c'),
            $this->equalTo(json_decode($this->sampleString))
        );
    }

    /**
     * Tests the revokeGrantForApplication method - failure
     *
     * @return  void
     *
     * @since   1.0
     */
    public function testRevokeGrantForApplicationFailure()
    {
        $this->expectException(\DomainException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/applications/42/grants/1a2b3c')
            ->willReturn($this->response);

        $this->object->revokeGrantForApplication(42, '1a2b3c');
    }
}
