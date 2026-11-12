<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Apps;

use Joomla\Github\Package\Apps\Installations;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Apps\Installations.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Installations::class)]
class InstallationsTest extends GitHubTestCase
{
    /**
     * @var    Installations  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture.
     *
     * @return  void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Installations($this->options, $this->client);
    }

    /**
     * Tests the getListRepositories method.
     *
     * @return  void
     */
    public function testGetListRepositories()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/installation/repositories?page=2&per_page=10', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListRepositories(2, 10)
        );
    }

    /**
     * Tests the getListRepositories method - failure.
     *
     * @return  void
     */
    public function testGetListRepositoriesFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListRepositories(2, 10);
    }

    /**
     * Tests the revokeAccessToken method.
     *
     * @return  void
     */
    public function testRevokeAccessToken()
    {
        $this->response = $this->getResponseObject('', 204);
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/installation/token', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->revokeAccessToken());
    }

    /**
     * Tests the revokeAccessToken method - failure.
     *
     * @return  void
     */
    public function testRevokeAccessTokenFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->revokeAccessToken();
    }

    /**
     * Tests the getListForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetListForAuthenticatedUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/installations?page=2&per_page=10', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForAuthenticatedUser(2, 10)
        );
    }

    /**
     * Tests the getListForAuthenticatedUser method - failure.
     *
     * @return  void
     */
    public function testGetListForAuthenticatedUserFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForAuthenticatedUser(2, 10);
    }

    /**
     * Tests the getListRepositoriesForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetListRepositoriesForAuthenticatedUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/installations/7/repositories?page=2&per_page=10', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListRepositoriesForAuthenticatedUser(7, 2, 10)
        );
    }

    /**
     * Tests the getListRepositoriesForAuthenticatedUser method - failure.
     *
     * @return  void
     */
    public function testGetListRepositoriesForAuthenticatedUserFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListRepositoriesForAuthenticatedUser(7, 2, 10);
    }

    /**
     * Tests the addRepository method.
     *
     * @return  void
     */
    public function testAddRepository()
    {
        $this->response = $this->getResponseObject('', 204);
        $this->client->expects($this->once())
            ->method('put')
            ->with('/user/installations/7/repositories/9', '', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->addRepository(7, 9));
    }

    /**
     * Tests the addRepository method - failure.
     *
     * @return  void
     */
    public function testAddRepositoryFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->addRepository(7, 9);
    }

    /**
     * Tests the removeRepository method.
     *
     * @return  void
     */
    public function testRemoveRepository()
    {
        $this->response = $this->getResponseObject('', 204);
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/installations/7/repositories/9', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->removeRepository(7, 9));
    }

    /**
     * Tests the removeRepository method - failure.
     *
     * @return  void
     */
    public function testRemoveRepositoryFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->removeRepository(7, 9);
    }
}
