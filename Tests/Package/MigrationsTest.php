<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Migrations;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Migrations.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Migrations::class)]
class MigrationsTest extends GitHubTestCase
{
    /**
     * @var    Migrations  Object under test.
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

        $this->object = new Migrations($this->options, $this->client);
    }

    /**
     * Tests the getListForOrg method.
     *
     * @return  void
     */
    public function testGetListForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/migrations?page=2&per_page=10&exclude=repositories', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForOrg('joomla', ['exclude' => ['repositories']], 2, 10)
        );
    }

    /**
     * Tests the getListForOrg method.
     *
     * @return  void
     */
    public function testGetListForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/migrations?page=2&per_page=10&exclude=repositories', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForOrg('joomla', ['exclude' => ['repositories']], 2, 10);
    }

    /**
     * Tests the startForOrg method.
     *
     * @return  void
     */
    public function testStartForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/migrations', json_encode(['lock_repositories' => 'value', 'repositories' => ['joomla-platform']]), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->startForOrg('joomla', ['joomla-platform'], ['lock_repositories' => 'value'])
        );
    }

    /**
     * Tests the startForOrg method.
     *
     * @return  void
     */
    public function testStartForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/migrations', json_encode(['lock_repositories' => 'value', 'repositories' => ['joomla-platform']]), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->startForOrg('joomla', ['joomla-platform'], ['lock_repositories' => 'value']);
    }

    /**
     * Tests the getStatusForOrg method.
     *
     * @return  void
     */
    public function testGetStatusForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/migrations/42?exclude=repositories', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getStatusForOrg('joomla', 42, ['exclude' => ['repositories']])
        );
    }

    /**
     * Tests the getStatusForOrg method.
     *
     * @return  void
     */
    public function testGetStatusForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/migrations/42?exclude=repositories', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getStatusForOrg('joomla', 42, ['exclude' => ['repositories']]);
    }

    /**
     * Tests the downloadArchiveForOrg method.
     *
     * @return  void
     */
    public function testDownloadArchiveForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/migrations/42/archive', [], 0)
            ->willReturn($this->getResponseObject('', 302, ['Location' => 'https://example.com/archive.tar.gz']));

        $this->assertSame(
            'https://example.com/archive.tar.gz',
            $this->object->downloadArchiveForOrg('joomla', 42)
        );
    }

    /**
     * Tests the downloadArchiveForOrg method.
     *
     * @return  void
     */
    public function testDownloadArchiveForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/migrations/42/archive', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->downloadArchiveForOrg('joomla', 42);
    }

    /**
     * Tests the deleteArchiveForOrg method.
     *
     * @return  void
     */
    public function testDeleteArchiveForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/migrations/42/archive', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->deleteArchiveForOrg('joomla', 42));
    }

    /**
     * Tests the deleteArchiveForOrg method.
     *
     * @return  void
     */
    public function testDeleteArchiveForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/migrations/42/archive', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteArchiveForOrg('joomla', 42);
    }

    /**
     * Tests the unlockRepoForOrg method.
     *
     * @return  void
     */
    public function testUnlockRepoForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/migrations/42/repos/joomla-platform/lock', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->unlockRepoForOrg('joomla', 42, 'joomla-platform'));
    }

    /**
     * Tests the unlockRepoForOrg method.
     *
     * @return  void
     */
    public function testUnlockRepoForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/migrations/42/repos/joomla-platform/lock', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->unlockRepoForOrg('joomla', 42, 'joomla-platform');
    }

    /**
     * Tests the getRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testGetRepositoriesForOrg(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/migrations/42/repositories?page=2&per_page=10', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getRepositoriesForOrg('joomla', 42, 2, 10)
        );
    }

    /**
     * Tests the getRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testGetRepositoriesForOrgFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/migrations/42/repositories?page=2&per_page=10', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getRepositoriesForOrg('joomla', 42, 2, 10);
    }

    /**
     * Tests the getListForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetListForAuthenticatedUser(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/migrations?page=2&per_page=10', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForAuthenticatedUser(2, 10)
        );
    }

    /**
     * Tests the getListForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetListForAuthenticatedUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/migrations?page=2&per_page=10', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForAuthenticatedUser(2, 10);
    }

    /**
     * Tests the startForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testStartForAuthenticatedUser(): void
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/migrations', json_encode(['lock_repositories' => 'value', 'repositories' => ['joomla-platform']]), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->startForAuthenticatedUser(['joomla-platform'], ['lock_repositories' => 'value'])
        );
    }

    /**
     * Tests the startForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testStartForAuthenticatedUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/migrations', json_encode(['lock_repositories' => 'value', 'repositories' => ['joomla-platform']]), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->startForAuthenticatedUser(['joomla-platform'], ['lock_repositories' => 'value']);
    }

    /**
     * Tests the getStatusForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetStatusForAuthenticatedUser(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/migrations/42?exclude=repositories', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getStatusForAuthenticatedUser(42, ['exclude' => ['repositories']])
        );
    }

    /**
     * Tests the getStatusForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetStatusForAuthenticatedUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/migrations/42?exclude=repositories', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getStatusForAuthenticatedUser(42, ['exclude' => ['repositories']]);
    }

    /**
     * Tests the downloadArchiveForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testDownloadArchiveForAuthenticatedUser(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/migrations/42/archive', [], 0)
            ->willReturn($this->getResponseObject('', 302, ['Location' => 'https://example.com/archive.tar.gz']));

        $this->assertSame(
            'https://example.com/archive.tar.gz',
            $this->object->downloadArchiveForAuthenticatedUser(42)
        );
    }

    /**
     * Tests the downloadArchiveForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testDownloadArchiveForAuthenticatedUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/migrations/42/archive', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->downloadArchiveForAuthenticatedUser(42);
    }

    /**
     * Tests the deleteArchiveForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testDeleteArchiveForAuthenticatedUser(): void
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/migrations/42/archive', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->deleteArchiveForAuthenticatedUser(42));
    }

    /**
     * Tests the deleteArchiveForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testDeleteArchiveForAuthenticatedUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/migrations/42/archive', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteArchiveForAuthenticatedUser(42);
    }

    /**
     * Tests the unlockRepoForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testUnlockRepoForAuthenticatedUser(): void
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/migrations/42/repos/joomla-platform/lock', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 204));

        $this->assertNull($this->object->unlockRepoForAuthenticatedUser(42, 'joomla-platform'));
    }

    /**
     * Tests the unlockRepoForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testUnlockRepoForAuthenticatedUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/migrations/42/repos/joomla-platform/lock', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->unlockRepoForAuthenticatedUser(42, 'joomla-platform');
    }

    /**
     * Tests the getRepositoriesForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetRepositoriesForAuthenticatedUser(): void
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/migrations/42/repositories?page=2&per_page=10', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getRepositoriesForAuthenticatedUser(42, 2, 10)
        );
    }

    /**
     * Tests the getRepositoriesForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetRepositoriesForAuthenticatedUserFailure(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/migrations/42/repositories?page=2&per_page=10', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getRepositoriesForAuthenticatedUser(42, 2, 10);
    }
}
