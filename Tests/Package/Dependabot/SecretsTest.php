<?php

/**
 * Part of the Joomla Framework Github Package
 *
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Dependabot;

use Joomla\Github\Package\Dependabot\Secrets;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Dependabot\Secrets.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Secrets::class)]
class SecretsTest extends GitHubTestCase
{
    /**
     * @var    Secrets  Object under test.
     * @since  __DEPLOY_VERSION__
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new Secrets($this->options, $this->client);
    }

    /**
     * Tests the getListForOrg method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetListForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/dependabot/secrets?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForOrg('joomla', 2, 30)
        );
    }

    /**
     * Tests the getListForOrg method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetListForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/dependabot/secrets', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForOrg('joomla');
    }

    /**
     * Tests the getPublicKeyForOrg method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetPublicKeyForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/dependabot/secrets/public-key', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getPublicKeyForOrg('joomla')
        );
    }

    /**
     * Tests the getPublicKeyForOrg method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetPublicKeyForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/dependabot/secrets/public-key', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getPublicKeyForOrg('joomla');
    }

    /**
     * Tests the getForOrg method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForOrg('joomla', 'MY SECRET')
        );
    }

    /**
     * Tests the getForOrg method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getForOrg('joomla', 'MY SECRET');
    }

    /**
     * Tests the createOrUpdateForOrg method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreateOrUpdateForOrg()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET', json_encode(['encrypted_value' => 'c2VjcmV0', 'key_id' => '012345678912345678', 'visibility' => 'selected']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createOrUpdateForOrg('joomla', 'MY SECRET', 'selected', ['encrypted_value' => 'c2VjcmV0', 'key_id' => '012345678912345678'])
        );
    }

    /**
     * Tests the createOrUpdateForOrg method with a 204 response.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreateOrUpdateForOrg204()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET', json_encode(['encrypted_value' => 'c2VjcmV0', 'key_id' => '012345678912345678', 'visibility' => 'selected']), [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->createOrUpdateForOrg('joomla', 'MY SECRET', 'selected', ['encrypted_value' => 'c2VjcmV0', 'key_id' => '012345678912345678']));
    }

    /**
     * Tests the createOrUpdateForOrg method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreateOrUpdateForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET', json_encode(['visibility' => 'selected']), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->createOrUpdateForOrg('joomla', 'MY SECRET', 'selected');
    }

    /**
     * Tests the deleteForOrg method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testDeleteForOrg()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteForOrg('joomla', 'MY SECRET'));
    }

    /**
     * Tests the deleteForOrg method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testDeleteForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteForOrg('joomla', 'MY SECRET');
    }

    /**
     * Tests the getSelectedRepositories method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetSelectedRepositories()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET/repositories?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getSelectedRepositories('joomla', 'MY SECRET', 2, 30)
        );
    }

    /**
     * Tests the getSelectedRepositories method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetSelectedRepositoriesFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET/repositories', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getSelectedRepositories('joomla', 'MY SECRET');
    }

    /**
     * Tests the setSelectedRepositories method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testSetSelectedRepositories()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET/repositories', json_encode(['selected_repository_ids' => [1296269, 1296270]]), [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->setSelectedRepositories('joomla', 'MY SECRET', [1296269, 1296270]));
    }

    /**
     * Tests the setSelectedRepositories method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testSetSelectedRepositoriesFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET/repositories', json_encode(['selected_repository_ids' => [1296269, 1296270]]), [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->setSelectedRepositories('joomla', 'MY SECRET', [1296269, 1296270]);
    }

    /**
     * Tests the addSelectedRepository method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testAddSelectedRepository()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET/repositories/1296269', '', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->addSelectedRepository('joomla', 'MY SECRET', 1296269));
    }

    /**
     * Tests the addSelectedRepository method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testAddSelectedRepositoryFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET/repositories/1296269', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->addSelectedRepository('joomla', 'MY SECRET', 1296269);
    }

    /**
     * Tests the removeSelectedRepository method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testRemoveSelectedRepository()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET/repositories/1296269', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->removeSelectedRepository('joomla', 'MY SECRET', 1296269));
    }

    /**
     * Tests the removeSelectedRepository method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testRemoveSelectedRepositoryFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/dependabot/secrets/MY%20SECRET/repositories/1296269', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->removeSelectedRepository('joomla', 'MY SECRET', 1296269);
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetListForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependabot/secrets?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForRepo('joomla', 'joomla-platform', 2, 30)
        );
    }

    /**
     * Tests the getListForRepo method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetListForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependabot/secrets', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getListForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the getPublicKeyForRepo method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetPublicKeyForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependabot/secrets/public-key', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getPublicKeyForRepo('joomla', 'joomla-platform')
        );
    }

    /**
     * Tests the getPublicKeyForRepo method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetPublicKeyForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependabot/secrets/public-key', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getPublicKeyForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the getForRepo method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependabot/secrets/MY%20SECRET', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getForRepo('joomla', 'joomla-platform', 'MY SECRET')
        );
    }

    /**
     * Tests the getForRepo method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testGetForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/dependabot/secrets/MY%20SECRET', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->getForRepo('joomla', 'joomla-platform', 'MY SECRET');
    }

    /**
     * Tests the createOrUpdateForRepo method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreateOrUpdateForRepo()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/dependabot/secrets/MY%20SECRET', json_encode(['encrypted_value' => 'c2VjcmV0', 'key_id' => '012345678912345678']), [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createOrUpdateForRepo('joomla', 'joomla-platform', 'MY SECRET', ['encrypted_value' => 'c2VjcmV0', 'key_id' => '012345678912345678'])
        );
    }

    /**
     * Tests the createOrUpdateForRepo method with a 204 response.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreateOrUpdateForRepo204()
    {
        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/dependabot/secrets/MY%20SECRET', json_encode(['encrypted_value' => 'c2VjcmV0', 'key_id' => '012345678912345678']), [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->createOrUpdateForRepo('joomla', 'joomla-platform', 'MY SECRET', ['encrypted_value' => 'c2VjcmV0', 'key_id' => '012345678912345678']));
    }

    /**
     * Tests the createOrUpdateForRepo method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testCreateOrUpdateForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/dependabot/secrets/MY%20SECRET', '{}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->createOrUpdateForRepo('joomla', 'joomla-platform', 'MY SECRET');
    }

    /**
     * Tests the deleteForRepo method.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testDeleteForRepo()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/dependabot/secrets/MY%20SECRET', [], 0)
            ->willReturn($this->getResponseObject('', 204));

        $this->assertNull($this->object->deleteForRepo('joomla', 'joomla-platform', 'MY SECRET'));
    }

    /**
     * Tests the deleteForRepo method - failure.
     *
     * @return  void
     *
     * @since   __DEPLOY_VERSION__
     */
    public function testDeleteForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/dependabot/secrets/MY%20SECRET', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->object->deleteForRepo('joomla', 'joomla-platform', 'MY SECRET');
    }
}
