<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package\Actions;

use Joomla\Github\Package\Actions\RunnerGroups;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for the GitHub API package.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(RunnerGroups::class)]
class RunnerGroupsTest extends GitHubTestCase
{
    /**
     * @var    RunnerGroups  Object under test.
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

        $this->object = new RunnerGroups($this->options, $this->client);
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/runner-groups?page=2&per_page=30&visible_to_repository=visible-to-repository-value', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getList('joomla', ['visible_to_repository' => 'visible-to-repository-value'], 2, 30));
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetListDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/runner-groups', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getList('joomla'));
    }

    /**
     * Tests the getList method.
     *
     * @return  void
     */
    public function testGetListFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getList('joomla', ['visible_to_repository' => 'visible-to-repository-value'], 2, 30);
    }

    /**
     * Tests the create method.
     *
     * @return  void
     */
    public function testCreate()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"visibility":"visibility","name":"name"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/actions/runner-groups', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->create('joomla', 'name', ['visibility' => 'visibility']));
    }

    /**
     * Tests the create method.
     *
     * @return  void
     */
    public function testCreateDefaults()
    {
        $this->response = $this->getResponseObject($this->sampleString, 201);

        $body = '{"name":"name"}';

        $this->client->expects($this->once())
            ->method('post')
            ->with('/orgs/joomla/actions/runner-groups', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->create('joomla', 'name'));
    }

    /**
     * Tests the create method.
     *
     * @return  void
     */
    public function testCreateFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('post')
            ->willReturn($this->response);

        $this->object->create('joomla', 'name', ['visibility' => 'visibility']);
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/runner-groups/1', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->get('joomla', 1));
    }

    /**
     * Tests the get method.
     *
     * @return  void
     */
    public function testGetFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->get('joomla', 1);
    }

    /**
     * Tests the edit method.
     *
     * @return  void
     */
    public function testEdit()
    {
        $body = '{"visibility":"visibility","name":"name"}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/actions/runner-groups/1', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->edit('joomla', 1, 'name', ['visibility' => 'visibility']));
    }

    /**
     * Tests the edit method.
     *
     * @return  void
     */
    public function testEditDefaults()
    {
        $body = '{"name":"name"}';

        $this->client->expects($this->once())
            ->method('patch')
            ->with('/orgs/joomla/actions/runner-groups/1', $body, [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->edit('joomla', 1, 'name'));
    }

    /**
     * Tests the edit method.
     *
     * @return  void
     */
    public function testEditFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('patch')
            ->willReturn($this->response);

        $this->object->edit('joomla', 1, 'name', ['visibility' => 'visibility']);
    }

    /**
     * Tests the delete method.
     *
     * @return  void
     */
    public function testDelete()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/actions/runner-groups/1', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->delete('joomla', 1));
    }

    /**
     * Tests the delete method.
     *
     * @return  void
     */
    public function testDeleteFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->delete('joomla', 1);
    }

    /**
     * Tests the getListHostedRunners method.
     *
     * @return  void
     */
    public function testGetListHostedRunners()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/runner-groups/1/hosted-runners?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListHostedRunners('joomla', 1, 2, 30));
    }

    /**
     * Tests the getListHostedRunners method.
     *
     * @return  void
     */
    public function testGetListHostedRunnersDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/runner-groups/1/hosted-runners', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListHostedRunners('joomla', 1));
    }

    /**
     * Tests the getListHostedRunners method.
     *
     * @return  void
     */
    public function testGetListHostedRunnersFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListHostedRunners('joomla', 1, 2, 30);
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
            ->with('/orgs/joomla/actions/runner-groups/1/repositories?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListRepositories('joomla', 1, 2, 30));
    }

    /**
     * Tests the getListRepositories method.
     *
     * @return  void
     */
    public function testGetListRepositoriesDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/runner-groups/1/repositories', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListRepositories('joomla', 1));
    }

    /**
     * Tests the getListRepositories method.
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

        $this->object->getListRepositories('joomla', 1, 2, 30);
    }

    /**
     * Tests the setRepositories method.
     *
     * @return  void
     */
    public function testSetRepositories()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"selected_repository_ids":[1,2]}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/runner-groups/1/repositories', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setRepositories('joomla', 1, [1, 2]));
    }

    /**
     * Tests the setRepositories method.
     *
     * @return  void
     */
    public function testSetRepositoriesFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setRepositories('joomla', 1, [1, 2]);
    }

    /**
     * Tests the addRepository method.
     *
     * @return  void
     */
    public function testAddRepository()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/runner-groups/1/repositories/2', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->addRepository('joomla', 1, 2));
    }

    /**
     * Tests the addRepository method.
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

        $this->object->addRepository('joomla', 1, 2);
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
            ->with('/orgs/joomla/actions/runner-groups/1/repositories/2', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->removeRepository('joomla', 1, 2));
    }

    /**
     * Tests the removeRepository method.
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

        $this->object->removeRepository('joomla', 1, 2);
    }

    /**
     * Tests the getListRunners method.
     *
     * @return  void
     */
    public function testGetListRunners()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/runner-groups/1/runners?page=2&per_page=30', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListRunners('joomla', 1, 2, 30));
    }

    /**
     * Tests the getListRunners method.
     *
     * @return  void
     */
    public function testGetListRunnersDefaults()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/orgs/joomla/actions/runner-groups/1/runners', [], 0)
            ->willReturn($this->response);

        $this->assertEquals(json_decode($this->sampleString), $this->object->getListRunners('joomla', 1));
    }

    /**
     * Tests the getListRunners method.
     *
     * @return  void
     */
    public function testGetListRunnersFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->object->getListRunners('joomla', 1, 2, 30);
    }

    /**
     * Tests the setRunners method.
     *
     * @return  void
     */
    public function testSetRunners()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '{"runners":[1,2]}';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/runner-groups/1/runners', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->setRunners('joomla', 1, [1, 2]));
    }

    /**
     * Tests the setRunners method.
     *
     * @return  void
     */
    public function testSetRunnersFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->setRunners('joomla', 1, [1, 2]);
    }

    /**
     * Tests the addRunner method.
     *
     * @return  void
     */
    public function testAddRunner()
    {
        $this->response = $this->getResponseObject('', 204);

        $body = '';

        $this->client->expects($this->once())
            ->method('put')
            ->with('/orgs/joomla/actions/runner-groups/1/runners/2', $body, [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->addRunner('joomla', 1, 2));
    }

    /**
     * Tests the addRunner method.
     *
     * @return  void
     */
    public function testAddRunnerFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('put')
            ->willReturn($this->response);

        $this->object->addRunner('joomla', 1, 2);
    }

    /**
     * Tests the removeRunner method.
     *
     * @return  void
     */
    public function testRemoveRunner()
    {
        $this->response = $this->getResponseObject('', 204);

        $this->client->expects($this->once())
            ->method('delete')
            ->with('/orgs/joomla/actions/runner-groups/1/runners/2', [], 0)
            ->willReturn($this->response);

        $this->assertNull($this->object->removeRunner('joomla', 1, 2));
    }

    /**
     * Tests the removeRunner method.
     *
     * @return  void
     */
    public function testRemoveRunnerFailure()
    {
        $this->expectException(UnexpectedResponseException::class);

        $this->response = $this->getResponseObject($this->errorString, 500);

        $this->client->expects($this->once())
            ->method('delete')
            ->willReturn($this->response);

        $this->object->removeRunner('joomla', 1, 2);
    }
}
