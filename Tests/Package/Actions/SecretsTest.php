<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Actions;

use Joomla\Github\Package\Actions\Secrets;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for the GitHub API package.
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
     */
    public function testGetListForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/secrets?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForOrg('joomla', 2, 30));
    }

    /**
     * Tests the getListForOrg method.
     *
     * @return  void
     */
    public function testGetListForOrgDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/secrets', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForOrg('joomla'));
    }

    /**
     * Tests the getListForOrg method.
     *
     * @return  void
     */
    public function testGetListForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForOrg('joomla', 2, 30);
    }

    /**
     * Tests the getPublicKeyForOrg method.
     *
     * @return  void
     */
    public function testGetPublicKeyForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/secrets/public-key', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getPublicKeyForOrg('joomla'));
    }

    /**
     * Tests the getPublicKeyForOrg method.
     *
     * @return  void
     */
    public function testGetPublicKeyForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getPublicKeyForOrg('joomla');
    }

    /**
     * Tests the getForOrg method.
     *
     * @return  void
     */
    public function testGetForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/secrets/MY_SECRET', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getForOrg('joomla', 'MY_SECRET'));
    }

    /**
     * Tests the getForOrg method.
     *
     * @return  void
     */
    public function testGetForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getForOrg('joomla', 'MY_SECRET');
    }

    /**
     * Tests the createOrUpdateForOrg method.
     *
     * @return  void
     */
    public function testCreateOrUpdateForOrg()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"selected_repository_ids":[1,2],"encrypted_value":"encrypted-value","key_id":"key-id","visibility":"visibility"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/secrets/MY_SECRET', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createOrUpdateForOrg('joomla', 'MY_SECRET', 'encrypted-value', 'key-id', 'visibility', ['selected_repository_ids' => [1, 2]]));
    }

    /**
     * Tests the createOrUpdateForOrg method.
     *
     * @return  void
     */
    public function testCreateOrUpdateForOrgStatus204()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"selected_repository_ids":[1,2],"encrypted_value":"encrypted-value","key_id":"key-id","visibility":"visibility"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/secrets/MY_SECRET', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->createOrUpdateForOrg('joomla', 'MY_SECRET', 'encrypted-value', 'key-id', 'visibility', ['selected_repository_ids' => [1, 2]]));
    }

    /**
     * Tests the createOrUpdateForOrg method.
     *
     * @return  void
     */
    public function testCreateOrUpdateForOrgDefaults()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"encrypted_value":"encrypted-value","key_id":"key-id","visibility":"visibility"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/secrets/MY_SECRET', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createOrUpdateForOrg('joomla', 'MY_SECRET', 'encrypted-value', 'key-id', 'visibility'));
    }

    /**
     * Tests the createOrUpdateForOrg method.
     *
     * @return  void
     */
    public function testCreateOrUpdateForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->createOrUpdateForOrg('joomla', 'MY_SECRET', 'encrypted-value', 'key-id', 'visibility', ['selected_repository_ids' => [1, 2]]);
    }

    /**
     * Tests the deleteForOrg method.
     *
     * @return  void
     */
    public function testDeleteForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/actions/secrets/MY_SECRET', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteForOrg('joomla', 'MY_SECRET'));
    }

    /**
     * Tests the deleteForOrg method.
     *
     * @return  void
     */
    public function testDeleteForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteForOrg('joomla', 'MY_SECRET');
    }

    /**
     * Tests the getListSelectedRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testGetListSelectedRepositoriesForOrg()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/secrets/MY_SECRET/repositories?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListSelectedRepositoriesForOrg('joomla', 'MY_SECRET', 2, 30));
    }

    /**
     * Tests the getListSelectedRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testGetListSelectedRepositoriesForOrgDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/secrets/MY_SECRET/repositories', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListSelectedRepositoriesForOrg('joomla', 'MY_SECRET'));
    }

    /**
     * Tests the getListSelectedRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testGetListSelectedRepositoriesForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListSelectedRepositoriesForOrg('joomla', 'MY_SECRET', 2, 30);
    }

    /**
     * Tests the setSelectedRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testSetSelectedRepositoriesForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"selected_repository_ids":[1,2]}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/secrets/MY_SECRET/repositories', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setSelectedRepositoriesForOrg('joomla', 'MY_SECRET', [1, 2]));
    }

    /**
     * Tests the setSelectedRepositoriesForOrg method.
     *
     * @return  void
     */
    public function testSetSelectedRepositoriesForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setSelectedRepositoriesForOrg('joomla', 'MY_SECRET', [1, 2]);
    }

    /**
     * Tests the addSelectedRepositoryForOrg method.
     *
     * @return  void
     */
    public function testAddSelectedRepositoryForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/secrets/MY_SECRET/repositories/1', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->addSelectedRepositoryForOrg('joomla', 'MY_SECRET', 1));
    }

    /**
     * Tests the addSelectedRepositoryForOrg method.
     *
     * @return  void
     */
    public function testAddSelectedRepositoryForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->addSelectedRepositoryForOrg('joomla', 'MY_SECRET', 1);
    }

    /**
     * Tests the removeSelectedRepositoryForOrg method.
     *
     * @return  void
     */
    public function testRemoveSelectedRepositoryForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/actions/secrets/MY_SECRET/repositories/1', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->removeSelectedRepositoryForOrg('joomla', 'MY_SECRET', 1));
    }

    /**
     * Tests the removeSelectedRepositoryForOrg method.
     *
     * @return  void
     */
    public function testRemoveSelectedRepositoryForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->removeSelectedRepositoryForOrg('joomla', 'MY_SECRET', 1);
    }

    /**
     * Tests the getListOrganizationSecretsForRepo method.
     *
     * @return  void
     */
    public function testGetListOrganizationSecretsForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/organization-secrets?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListOrganizationSecretsForRepo('joomla', 'joomla-platform', 2, 30));
    }

    /**
     * Tests the getListOrganizationSecretsForRepo method.
     *
     * @return  void
     */
    public function testGetListOrganizationSecretsForRepoDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/organization-secrets', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListOrganizationSecretsForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getListOrganizationSecretsForRepo method.
     *
     * @return  void
     */
    public function testGetListOrganizationSecretsForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListOrganizationSecretsForRepo('joomla', 'joomla-platform', 2, 30);
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     */
    public function testGetListForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/secrets?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRepo('joomla', 'joomla-platform', 2, 30));
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     */
    public function testGetListForRepoDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/secrets', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getListForRepo method.
     *
     * @return  void
     */
    public function testGetListForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForRepo('joomla', 'joomla-platform', 2, 30);
    }

    /**
     * Tests the getPublicKeyForRepo method.
     *
     * @return  void
     */
    public function testGetPublicKeyForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/secrets/public-key', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getPublicKeyForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getPublicKeyForRepo method.
     *
     * @return  void
     */
    public function testGetPublicKeyForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getPublicKeyForRepo('joomla', 'joomla-platform');
    }

    /**
     * Tests the getForRepo method.
     *
     * @return  void
     */
    public function testGetForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/secrets/MY_SECRET', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getForRepo('joomla', 'joomla-platform', 'MY_SECRET'));
    }

    /**
     * Tests the getForRepo method.
     *
     * @return  void
     */
    public function testGetForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getForRepo('joomla', 'joomla-platform', 'MY_SECRET');
    }

    /**
     * Tests the createOrUpdateForRepo method.
     *
     * @return  void
     */
    public function testCreateOrUpdateForRepo()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"encrypted_value":"encrypted-value","key_id":"key-id"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/secrets/MY_SECRET', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createOrUpdateForRepo('joomla', 'joomla-platform', 'MY_SECRET', 'encrypted-value', 'key-id'));
    }

    /**
     * Tests the createOrUpdateForRepo method.
     *
     * @return  void
     */
    public function testCreateOrUpdateForRepoStatus204()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"encrypted_value":"encrypted-value","key_id":"key-id"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/actions/secrets/MY_SECRET', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->createOrUpdateForRepo('joomla', 'joomla-platform', 'MY_SECRET', 'encrypted-value', 'key-id'));
    }

    /**
     * Tests the createOrUpdateForRepo method.
     *
     * @return  void
     */
    public function testCreateOrUpdateForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->createOrUpdateForRepo('joomla', 'joomla-platform', 'MY_SECRET', 'encrypted-value', 'key-id');
    }

    /**
     * Tests the deleteForRepo method.
     *
     * @return  void
     */
    public function testDeleteForRepo()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/actions/secrets/MY_SECRET', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteForRepo('joomla', 'joomla-platform', 'MY_SECRET'));
    }

    /**
     * Tests the deleteForRepo method.
     *
     * @return  void
     */
    public function testDeleteForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteForRepo('joomla', 'joomla-platform', 'MY_SECRET');
    }

    /**
     * Tests the getListForEnvironment method.
     *
     * @return  void
     */
    public function testGetListForEnvironment()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/environments/prod%2Feu/secrets?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForEnvironment('joomla', 'joomla-platform', 'prod/eu', 2, 30));
    }

    /**
     * Tests the getListForEnvironment method.
     *
     * @return  void
     */
    public function testGetListForEnvironmentDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/environments/prod%2Feu/secrets', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListForEnvironment('joomla', 'joomla-platform', 'prod/eu'));
    }

    /**
     * Tests the getListForEnvironment method.
     *
     * @return  void
     */
    public function testGetListForEnvironmentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListForEnvironment('joomla', 'joomla-platform', 'prod/eu', 2, 30);
    }

    /**
     * Tests the getPublicKeyForEnvironment method.
     *
     * @return  void
     */
    public function testGetPublicKeyForEnvironment()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/environments/prod%2Feu/secrets/public-key', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getPublicKeyForEnvironment('joomla', 'joomla-platform', 'prod/eu'));
    }

    /**
     * Tests the getPublicKeyForEnvironment method.
     *
     * @return  void
     */
    public function testGetPublicKeyForEnvironmentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getPublicKeyForEnvironment('joomla', 'joomla-platform', 'prod/eu');
    }

    /**
     * Tests the getForEnvironment method.
     *
     * @return  void
     */
    public function testGetForEnvironment()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/environments/prod%2Feu/secrets/MY_SECRET', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'MY_SECRET'));
    }

    /**
     * Tests the getForEnvironment method.
     *
     * @return  void
     */
    public function testGetForEnvironmentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'MY_SECRET');
    }

    /**
     * Tests the createOrUpdateForEnvironment method.
     *
     * @return  void
     */
    public function testCreateOrUpdateForEnvironment()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"encrypted_value":"encrypted-value","key_id":"key-id"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/environments/prod%2Feu/secrets/MY_SECRET', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createOrUpdateForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'MY_SECRET', 'encrypted-value', 'key-id'));
    }

    /**
     * Tests the createOrUpdateForEnvironment method.
     *
     * @return  void
     */
    public function testCreateOrUpdateForEnvironmentStatus204()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"encrypted_value":"encrypted-value","key_id":"key-id"}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/repos/joomla/joomla-platform/environments/prod%2Feu/secrets/MY_SECRET', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->createOrUpdateForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'MY_SECRET', 'encrypted-value', 'key-id'));
    }

    /**
     * Tests the createOrUpdateForEnvironment method.
     *
     * @return  void
     */
    public function testCreateOrUpdateForEnvironmentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->createOrUpdateForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'MY_SECRET', 'encrypted-value', 'key-id');
    }

    /**
     * Tests the deleteForEnvironment method.
     *
     * @return  void
     */
    public function testDeleteForEnvironment()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/repos/joomla/joomla-platform/environments/prod%2Feu/secrets/MY_SECRET', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'MY_SECRET'));
    }

    /**
     * Tests the deleteForEnvironment method.
     *
     * @return  void
     */
    public function testDeleteForEnvironmentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->deleteForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'MY_SECRET');
    }
}
