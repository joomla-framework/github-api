<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Actions;

use Joomla\Github\Package\Actions\Variables;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for the GitHub API package.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Variables::class)]
class VariablesTest extends GitHubTestCase
{
    /**
     * @var    Variables  Object under test.
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

        $this->object = new Variables($this->options, $this->client);
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
            ->with('/orgs/joomla/actions/variables?page=2&per_page=30', [], 0)
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
            ->with('/orgs/joomla/actions/variables', [], 0)
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
     * Tests the createForOrg method.
     *
     * @return  void
     */
    public function testCreateForOrg()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"selected_repository_ids":[1,2],"name":"name","value":"value","visibility":"visibility"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/actions/variables', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createForOrg('joomla', 'name', 'value', 'visibility', ['selected_repository_ids' => [1, 2]]));
    }

    /**
     * Tests the createForOrg method.
     *
     * @return  void
     */
    public function testCreateForOrgDefaults()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"name":"name","value":"value","visibility":"visibility"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/actions/variables', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createForOrg('joomla', 'name', 'value', 'visibility'));
    }

    /**
     * Tests the createForOrg method.
     *
     * @return  void
     */
    public function testCreateForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createForOrg('joomla', 'name', 'value', 'visibility', ['selected_repository_ids' => [1, 2]]);
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
            ->with('/orgs/joomla/actions/variables/my%20name', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getForOrg('joomla', 'my name'));
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

        $this->object->getForOrg('joomla', 'my name');
    }

    /**
     * Tests the editForOrg method.
     *
     * @return  void
     */
    public function testEditForOrg()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"name":"name"}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/actions/variables/my%20name', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->editForOrg('joomla', 'my name', ['name' => 'name']));
    }

    /**
     * Tests the editForOrg method.
     *
     * @return  void
     */
    public function testEditForOrgDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/actions/variables/my%20name', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->editForOrg('joomla', 'my name'));
    }

    /**
     * Tests the editForOrg method.
     *
     * @return  void
     */
    public function testEditForOrgFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('patch')
            ->willReturn($this->response);

        $this->object->editForOrg('joomla', 'my name', ['name' => 'name']);
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
            ->with('/orgs/joomla/actions/variables/my%20name', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteForOrg('joomla', 'my name'));
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

        $this->object->deleteForOrg('joomla', 'my name');
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
            ->with('/orgs/joomla/actions/variables/my%20name/repositories?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListSelectedRepositoriesForOrg('joomla', 'my name', 2, 30));
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
            ->with('/orgs/joomla/actions/variables/my%20name/repositories', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListSelectedRepositoriesForOrg('joomla', 'my name'));
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

        $this->object->getListSelectedRepositoriesForOrg('joomla', 'my name', 2, 30);
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
            ->with('/orgs/joomla/actions/variables/my%20name/repositories', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setSelectedRepositoriesForOrg('joomla', 'my name', [1, 2]));
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

        $this->object->setSelectedRepositoriesForOrg('joomla', 'my name', [1, 2]);
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
            ->with('/orgs/joomla/actions/variables/my%20name/repositories/1', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->addSelectedRepositoryForOrg('joomla', 'my name', 1));
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

        $this->object->addSelectedRepositoryForOrg('joomla', 'my name', 1);
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
            ->with('/orgs/joomla/actions/variables/my%20name/repositories/1', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->removeSelectedRepositoryForOrg('joomla', 'my name', 1));
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

        $this->object->removeSelectedRepositoryForOrg('joomla', 'my name', 1);
    }

    /**
     * Tests the getListOrganizationVariablesForRepo method.
     *
     * @return  void
     */
    public function testGetListOrganizationVariablesForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/organization-variables?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListOrganizationVariablesForRepo('joomla', 'joomla-platform', 2, 30));
    }

    /**
     * Tests the getListOrganizationVariablesForRepo method.
     *
     * @return  void
     */
    public function testGetListOrganizationVariablesForRepoDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/actions/organization-variables', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListOrganizationVariablesForRepo('joomla', 'joomla-platform'));
    }

    /**
     * Tests the getListOrganizationVariablesForRepo method.
     *
     * @return  void
     */
    public function testGetListOrganizationVariablesForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListOrganizationVariablesForRepo('joomla', 'joomla-platform', 2, 30);
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
            ->with('/repos/joomla/joomla-platform/actions/variables?page=2&per_page=30', [], 0)
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
            ->with('/repos/joomla/joomla-platform/actions/variables', [], 0)
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
     * Tests the createForRepo method.
     *
     * @return  void
     */
    public function testCreateForRepo()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"name":"name","value":"value"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/actions/variables', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createForRepo('joomla', 'joomla-platform', 'name', 'value'));
    }

    /**
     * Tests the createForRepo method.
     *
     * @return  void
     */
    public function testCreateForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createForRepo('joomla', 'joomla-platform', 'name', 'value');
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
            ->with('/repos/joomla/joomla-platform/actions/variables/my%20name', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getForRepo('joomla', 'joomla-platform', 'my name'));
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

        $this->object->getForRepo('joomla', 'joomla-platform', 'my name');
    }

    /**
     * Tests the editForRepo method.
     *
     * @return  void
     */
    public function testEditForRepo()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"name":"name"}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/actions/variables/my%20name', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->editForRepo('joomla', 'joomla-platform', 'my name', ['name' => 'name']));
    }

    /**
     * Tests the editForRepo method.
     *
     * @return  void
     */
    public function testEditForRepoDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/actions/variables/my%20name', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->editForRepo('joomla', 'joomla-platform', 'my name'));
    }

    /**
     * Tests the editForRepo method.
     *
     * @return  void
     */
    public function testEditForRepoFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('patch')
            ->willReturn($this->response);

        $this->object->editForRepo('joomla', 'joomla-platform', 'my name', ['name' => 'name']);
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
            ->with('/repos/joomla/joomla-platform/actions/variables/my%20name', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteForRepo('joomla', 'joomla-platform', 'my name'));
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

        $this->object->deleteForRepo('joomla', 'joomla-platform', 'my name');
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
            ->with('/repos/joomla/joomla-platform/environments/prod%2Feu/variables?page=2&per_page=30', [], 0)
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
            ->with('/repos/joomla/joomla-platform/environments/prod%2Feu/variables', [], 0)
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
     * Tests the createForEnvironment method.
     *
     * @return  void
     */
    public function testCreateForEnvironment()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"name":"name","value":"value"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/environments/prod%2Feu/variables', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->createForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'name', 'value'));
    }

    /**
     * Tests the createForEnvironment method.
     *
     * @return  void
     */
    public function testCreateForEnvironmentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->createForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'name', 'value');
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
            ->with('/repos/joomla/joomla-platform/environments/prod%2Feu/variables/my%20name', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'my name'));
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

        $this->object->getForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'my name');
    }

    /**
     * Tests the editForEnvironment method.
     *
     * @return  void
     */
    public function testEditForEnvironment()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"name":"name"}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/environments/prod%2Feu/variables/my%20name', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->editForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'my name', ['name' => 'name']));
    }

    /**
     * Tests the editForEnvironment method.
     *
     * @return  void
     */
    public function testEditForEnvironmentDefaults()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/repos/joomla/joomla-platform/environments/prod%2Feu/variables/my%20name', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->editForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'my name'));
    }

    /**
     * Tests the editForEnvironment method.
     *
     * @return  void
     */
    public function testEditForEnvironmentFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('patch')
            ->willReturn($this->response);

        $this->object->editForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'my name', ['name' => 'name']);
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
            ->with('/repos/joomla/joomla-platform/environments/prod%2Feu/variables/my%20name', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->deleteForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'my name'));
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

        $this->object->deleteForEnvironment('joomla', 'joomla-platform', 'prod/eu', 'my name');
    }
}
