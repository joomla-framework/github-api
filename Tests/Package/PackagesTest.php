<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Packages;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Packages.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Packages::class)]
class PackagesTest extends GitHubTestCase
{
    /**
     * @var    Packages  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Packages($this->options, $this->client);
    }

    /**
     * Test the getListForOrg method.
     *
     * @return  void
     */
    public function testGetListForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/packages?page=2&per_page=30&package_type=container&visibility=selected', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForOrg('joomla', 'container', ['visibility' => 'selected'], 2, 30)
        );
    }

    /**
     * Test the getListForOrg method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListForOrgFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/packages?page=2&per_page=30&package_type=container&visibility=selected', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListForOrg('joomla', 'container', ['visibility' => 'selected'], 2, 30);
    }

    /**
     * Test the getForOrg method.
     *
     * @return  void
     */
    public function testGetForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/packages/container/joomla%2Fcms', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForOrg('joomla', 'container', 'joomla/cms')
        );
    }

    /**
     * Test the getForOrg method with an unexpected response.
     *
     * @return  void
     */
    public function testGetForOrgFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/packages/container/joomla%2Fcms', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getForOrg('joomla', 'container', 'joomla/cms');
    }

    /**
     * Test the deleteForOrg method.
     *
     * @return  void
     */
    public function testDeleteForOrg()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/packages/container/joomla%2Fcms', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteForOrg('joomla', 'container', 'joomla/cms'));
    }

    /**
     * Test the deleteForOrg method with an unexpected response.
     *
     * @return  void
     */
    public function testDeleteForOrgFailure()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/packages/container/joomla%2Fcms', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->deleteForOrg('joomla', 'container', 'joomla/cms');
    }

    /**
     * Test the restoreForOrg method.
     *
     * @return  void
     */
    public function testRestoreForOrg()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/packages/container/joomla%2Fcms/restore?token=abc123', '', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->restoreForOrg('joomla', 'container', 'joomla/cms', ['token' => 'abc123']));
    }

    /**
     * Test the restoreForOrg method with an unexpected response.
     *
     * @return  void
     */
    public function testRestoreForOrgFailure()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/packages/container/joomla%2Fcms/restore?token=abc123', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->restoreForOrg('joomla', 'container', 'joomla/cms', ['token' => 'abc123']);
    }

    /**
     * Test the getListVersionsForOrg method.
     *
     * @return  void
     */
    public function testGetListVersionsForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/packages/container/joomla%2Fcms/versions?page=2&per_page=30&state=deleted', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListVersionsForOrg('joomla', 'container', 'joomla/cms', ['state' => 'deleted'], 2, 30)
        );
    }

    /**
     * Test the getListVersionsForOrg method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListVersionsForOrgFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/packages/container/joomla%2Fcms/versions?page=2&per_page=30&state=deleted', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListVersionsForOrg('joomla', 'container', 'joomla/cms', ['state' => 'deleted'], 2, 30);
    }

    /**
     * Test the getVersionForOrg method.
     *
     * @return  void
     */
    public function testGetVersionForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/packages/container/joomla%2Fcms/versions/836', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getVersionForOrg('joomla', 'container', 'joomla/cms', 836)
        );
    }

    /**
     * Test the getVersionForOrg method with an unexpected response.
     *
     * @return  void
     */
    public function testGetVersionForOrgFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/packages/container/joomla%2Fcms/versions/836', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getVersionForOrg('joomla', 'container', 'joomla/cms', 836);
    }

    /**
     * Test the deleteVersionForOrg method.
     *
     * @return  void
     */
    public function testDeleteVersionForOrg()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/packages/container/joomla%2Fcms/versions/836', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteVersionForOrg('joomla', 'container', 'joomla/cms', 836));
    }

    /**
     * Test the deleteVersionForOrg method with an unexpected response.
     *
     * @return  void
     */
    public function testDeleteVersionForOrgFailure()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/packages/container/joomla%2Fcms/versions/836', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->deleteVersionForOrg('joomla', 'container', 'joomla/cms', 836);
    }

    /**
     * Test the restoreVersionForOrg method.
     *
     * @return  void
     */
    public function testRestoreVersionForOrg()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/packages/container/joomla%2Fcms/versions/836/restore', '', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->restoreVersionForOrg('joomla', 'container', 'joomla/cms', 836));
    }

    /**
     * Test the restoreVersionForOrg method with an unexpected response.
     *
     * @return  void
     */
    public function testRestoreVersionForOrgFailure()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/packages/container/joomla%2Fcms/versions/836/restore', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->restoreVersionForOrg('joomla', 'container', 'joomla/cms', 836);
    }

    /**
     * Test the getListDockerConflictsForOrg method.
     *
     * @return  void
     */
    public function testGetListDockerConflictsForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/docker/conflicts', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListDockerConflictsForOrg('joomla')
        );
    }

    /**
     * Test the getListDockerConflictsForOrg method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListDockerConflictsForOrgFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/docker/conflicts', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListDockerConflictsForOrg('joomla');
    }

    /**
     * Test the getListForUser method.
     *
     * @return  void
     */
    public function testGetListForUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/packages?page=2&per_page=30&package_type=container&visibility=selected', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForUser('octocat', 'container', ['visibility' => 'selected'], 2, 30)
        );
    }

    /**
     * Test the getListForUser method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListForUserFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/packages?page=2&per_page=30&package_type=container&visibility=selected', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListForUser('octocat', 'container', ['visibility' => 'selected'], 2, 30);
    }

    /**
     * Test the getForUser method.
     *
     * @return  void
     */
    public function testGetForUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/packages/container/joomla%2Fcms', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForUser('octocat', 'container', 'joomla/cms')
        );
    }

    /**
     * Test the getForUser method with an unexpected response.
     *
     * @return  void
     */
    public function testGetForUserFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/packages/container/joomla%2Fcms', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getForUser('octocat', 'container', 'joomla/cms');
    }

    /**
     * Test the deleteForUser method.
     *
     * @return  void
     */
    public function testDeleteForUser()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/users/octocat/packages/container/joomla%2Fcms', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteForUser('octocat', 'container', 'joomla/cms'));
    }

    /**
     * Test the deleteForUser method with an unexpected response.
     *
     * @return  void
     */
    public function testDeleteForUserFailure()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/users/octocat/packages/container/joomla%2Fcms', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->deleteForUser('octocat', 'container', 'joomla/cms');
    }

    /**
     * Test the restoreForUser method.
     *
     * @return  void
     */
    public function testRestoreForUser()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/users/octocat/packages/container/joomla%2Fcms/restore?token=abc123', '', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->restoreForUser('octocat', 'container', 'joomla/cms', ['token' => 'abc123']));
    }

    /**
     * Test the restoreForUser method with an unexpected response.
     *
     * @return  void
     */
    public function testRestoreForUserFailure()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/users/octocat/packages/container/joomla%2Fcms/restore?token=abc123', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->restoreForUser('octocat', 'container', 'joomla/cms', ['token' => 'abc123']);
    }

    /**
     * Test the getListVersionsForUser method.
     *
     * @return  void
     */
    public function testGetListVersionsForUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/packages/container/joomla%2Fcms/versions', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListVersionsForUser('octocat', 'container', 'joomla/cms')
        );
    }

    /**
     * Test the getListVersionsForUser method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListVersionsForUserFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/packages/container/joomla%2Fcms/versions', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListVersionsForUser('octocat', 'container', 'joomla/cms');
    }

    /**
     * Test the getVersionForUser method.
     *
     * @return  void
     */
    public function testGetVersionForUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/packages/container/joomla%2Fcms/versions/836', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getVersionForUser('octocat', 'container', 'joomla/cms', 836)
        );
    }

    /**
     * Test the getVersionForUser method with an unexpected response.
     *
     * @return  void
     */
    public function testGetVersionForUserFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/packages/container/joomla%2Fcms/versions/836', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getVersionForUser('octocat', 'container', 'joomla/cms', 836);
    }

    /**
     * Test the deleteVersionForUser method.
     *
     * @return  void
     */
    public function testDeleteVersionForUser()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/users/octocat/packages/container/joomla%2Fcms/versions/836', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteVersionForUser('octocat', 'container', 'joomla/cms', 836));
    }

    /**
     * Test the deleteVersionForUser method with an unexpected response.
     *
     * @return  void
     */
    public function testDeleteVersionForUserFailure()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/users/octocat/packages/container/joomla%2Fcms/versions/836', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->deleteVersionForUser('octocat', 'container', 'joomla/cms', 836);
    }

    /**
     * Test the restoreVersionForUser method.
     *
     * @return  void
     */
    public function testRestoreVersionForUser()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/users/octocat/packages/container/joomla%2Fcms/versions/836/restore', '', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->restoreVersionForUser('octocat', 'container', 'joomla/cms', 836));
    }

    /**
     * Test the restoreVersionForUser method with an unexpected response.
     *
     * @return  void
     */
    public function testRestoreVersionForUserFailure()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/users/octocat/packages/container/joomla%2Fcms/versions/836/restore', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->restoreVersionForUser('octocat', 'container', 'joomla/cms', 836);
    }

    /**
     * Test the getListDockerConflictsForUser method.
     *
     * @return  void
     */
    public function testGetListDockerConflictsForUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/docker/conflicts', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListDockerConflictsForUser('octocat')
        );
    }

    /**
     * Test the getListDockerConflictsForUser method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListDockerConflictsForUserFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/users/octocat/docker/conflicts', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListDockerConflictsForUser('octocat');
    }

    /**
     * Test the getListForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetListForAuthenticatedUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/packages?page=2&per_page=30&package_type=container&visibility=selected', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForAuthenticatedUser('container', ['visibility' => 'selected'], 2, 30)
        );
    }

    /**
     * Test the getListForAuthenticatedUser method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListForAuthenticatedUserFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/packages?page=2&per_page=30&package_type=container&visibility=selected', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListForAuthenticatedUser('container', ['visibility' => 'selected'], 2, 30);
    }

    /**
     * Test the getForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetForAuthenticatedUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/packages/container/joomla%2Fcms', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForAuthenticatedUser('container', 'joomla/cms')
        );
    }

    /**
     * Test the getForAuthenticatedUser method with an unexpected response.
     *
     * @return  void
     */
    public function testGetForAuthenticatedUserFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/packages/container/joomla%2Fcms', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getForAuthenticatedUser('container', 'joomla/cms');
    }

    /**
     * Test the deleteForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testDeleteForAuthenticatedUser()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/packages/container/joomla%2Fcms', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteForAuthenticatedUser('container', 'joomla/cms'));
    }

    /**
     * Test the deleteForAuthenticatedUser method with an unexpected response.
     *
     * @return  void
     */
    public function testDeleteForAuthenticatedUserFailure()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/packages/container/joomla%2Fcms', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->deleteForAuthenticatedUser('container', 'joomla/cms');
    }

    /**
     * Test the restoreForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testRestoreForAuthenticatedUser()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/packages/container/joomla%2Fcms/restore?token=abc123', '', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->restoreForAuthenticatedUser('container', 'joomla/cms', ['token' => 'abc123']));
    }

    /**
     * Test the restoreForAuthenticatedUser method with an unexpected response.
     *
     * @return  void
     */
    public function testRestoreForAuthenticatedUserFailure()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/packages/container/joomla%2Fcms/restore?token=abc123', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->restoreForAuthenticatedUser('container', 'joomla/cms', ['token' => 'abc123']);
    }

    /**
     * Test the getListVersionsForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetListVersionsForAuthenticatedUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/packages/container/joomla%2Fcms/versions?page=2&per_page=30&state=deleted', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListVersionsForAuthenticatedUser('container', 'joomla/cms', ['state' => 'deleted'], 2, 30)
        );
    }

    /**
     * Test the getListVersionsForAuthenticatedUser method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListVersionsForAuthenticatedUserFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/packages/container/joomla%2Fcms/versions?page=2&per_page=30&state=deleted', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListVersionsForAuthenticatedUser('container', 'joomla/cms', ['state' => 'deleted'], 2, 30);
    }

    /**
     * Test the getVersionForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetVersionForAuthenticatedUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/packages/container/joomla%2Fcms/versions/836', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getVersionForAuthenticatedUser('container', 'joomla/cms', 836)
        );
    }

    /**
     * Test the getVersionForAuthenticatedUser method with an unexpected response.
     *
     * @return  void
     */
    public function testGetVersionForAuthenticatedUserFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/packages/container/joomla%2Fcms/versions/836', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getVersionForAuthenticatedUser('container', 'joomla/cms', 836);
    }

    /**
     * Test the deleteVersionForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testDeleteVersionForAuthenticatedUser()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/packages/container/joomla%2Fcms/versions/836', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteVersionForAuthenticatedUser('container', 'joomla/cms', 836));
    }

    /**
     * Test the deleteVersionForAuthenticatedUser method with an unexpected response.
     *
     * @return  void
     */
    public function testDeleteVersionForAuthenticatedUserFailure()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/packages/container/joomla%2Fcms/versions/836', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->deleteVersionForAuthenticatedUser('container', 'joomla/cms', 836);
    }

    /**
     * Test the restoreVersionForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testRestoreVersionForAuthenticatedUser()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/packages/container/joomla%2Fcms/versions/836/restore', '', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->restoreVersionForAuthenticatedUser('container', 'joomla/cms', 836));
    }

    /**
     * Test the restoreVersionForAuthenticatedUser method with an unexpected response.
     *
     * @return  void
     */
    public function testRestoreVersionForAuthenticatedUserFailure()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/packages/container/joomla%2Fcms/versions/836/restore', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->restoreVersionForAuthenticatedUser('container', 'joomla/cms', 836);
    }

    /**
     * Test the getListDockerConflictsForAuthenticatedUser method.
     *
     * @return  void
     */
    public function testGetListDockerConflictsForAuthenticatedUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/docker/conflicts', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListDockerConflictsForAuthenticatedUser()
        );
    }

    /**
     * Test the getListDockerConflictsForAuthenticatedUser method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListDockerConflictsForAuthenticatedUserFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/docker/conflicts', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListDockerConflictsForAuthenticatedUser();
    }
}
