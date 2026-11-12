<?php

/**
 * @copyright  Copyright (C) 2005 - 2026 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github\Tests\Package;

use Joomla\Github\Package\Codespaces;
use Joomla\Github\Tests\Stub\GitHubTestCase;
use Joomla\Http\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Test class for Joomla\Github\Package\Codespaces.
 *
 * @since  __DEPLOY_VERSION__
 */
#[CoversClass(Codespaces::class)]
class CodespacesTest extends GitHubTestCase
{
    /**
     * @var    Codespaces  Object under test.
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

        $this->object = new Codespaces($this->options, $this->client);
    }

    /**
     * Test the getList method.
     *
     * @return  void
     */
    public function testGetList()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces?page=2&per_page=30&repository_id=1296269', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getList(['repository_id' => 1296269], 2, 30)
        );
    }

    /**
     * Test the getList method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces?page=2&per_page=30&repository_id=1296269', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getList(['repository_id' => 1296269], 2, 30);
    }

    /**
     * Test the create method.
     *
     * @return  void
     */
    public function testCreate()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/codespaces', '{"ref":"main","repository_id":1296269}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->create(1296269, ['ref' => 'main'])
        );
    }

    /**
     * Test the create method with a 202 response.
     *
     * @return  void
     */
    public function testCreateStatus202()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/codespaces', '{"ref":"main","repository_id":1296269}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 202));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->create(1296269, ['ref' => 'main'])
        );
    }

    /**
     * Test the create method with an unexpected response.
     *
     * @return  void
     */
    public function testCreateFailure()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/codespaces', '{"ref":"main","repository_id":1296269}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->create(1296269, ['ref' => 'main']);
    }

    /**
     * Test the get method.
     *
     * @return  void
     */
    public function testGet()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->get('monalisa-octocat-hello-world-g4wpq6h95q')
        );
    }

    /**
     * Test the get method with an unexpected response.
     *
     * @return  void
     */
    public function testGetFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->get('monalisa-octocat-hello-world-g4wpq6h95q');
    }

    /**
     * Test the edit method.
     *
     * @return  void
     */
    public function testEdit()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q', '{"machine":"standardLinux32gb"}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->edit('monalisa-octocat-hello-world-g4wpq6h95q', ['machine' => 'standardLinux32gb'])
        );
    }

    /**
     * Test the edit method with an unexpected response.
     *
     * @return  void
     */
    public function testEditFailure()
    {
        $this->client->expects($this->once())
            ->method('patch')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q', '{"machine":"standardLinux32gb"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->edit('monalisa-octocat-hello-world-g4wpq6h95q', ['machine' => 'standardLinux32gb']);
    }

    /**
     * Test the delete method.
     *
     * @return  void
     */
    public function testDelete()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 202));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->delete('monalisa-octocat-hello-world-g4wpq6h95q')
        );
    }

    /**
     * Test the delete method with an unexpected response.
     *
     * @return  void
     */
    public function testDeleteFailure()
    {
        $this->client->expects($this->once())
            ->method('delete')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->delete('monalisa-octocat-hello-world-g4wpq6h95q');
    }

    /**
     * Test the export method.
     *
     * @return  void
     */
    public function testExport()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q/exports', '', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 202));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->export('monalisa-octocat-hello-world-g4wpq6h95q')
        );
    }

    /**
     * Test the export method with an unexpected response.
     *
     * @return  void
     */
    public function testExportFailure()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q/exports', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->export('monalisa-octocat-hello-world-g4wpq6h95q');
    }

    /**
     * Test the getExport method.
     *
     * @return  void
     */
    public function testGetExport()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q/exports/latest', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getExport('monalisa-octocat-hello-world-g4wpq6h95q', 'latest')
        );
    }

    /**
     * Test the getExport method with an unexpected response.
     *
     * @return  void
     */
    public function testGetExportFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q/exports/latest', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getExport('monalisa-octocat-hello-world-g4wpq6h95q', 'latest');
    }

    /**
     * Test the publish method.
     *
     * @return  void
     */
    public function testPublish()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q/publish', '{"name":"joomla-codespace"}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->publish('monalisa-octocat-hello-world-g4wpq6h95q', ['name' => 'joomla-codespace'])
        );
    }

    /**
     * Test the publish method with an unexpected response.
     *
     * @return  void
     */
    public function testPublishFailure()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q/publish', '{"name":"joomla-codespace"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->publish('monalisa-octocat-hello-world-g4wpq6h95q', ['name' => 'joomla-codespace']);
    }

    /**
     * Test the start method.
     *
     * @return  void
     */
    public function testStart()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q/start', '', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->start('monalisa-octocat-hello-world-g4wpq6h95q')
        );
    }

    /**
     * Test the start method with an unexpected response.
     *
     * @return  void
     */
    public function testStartFailure()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q/start', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->start('monalisa-octocat-hello-world-g4wpq6h95q');
    }

    /**
     * Test the stop method.
     *
     * @return  void
     */
    public function testStop()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q/stop', '', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->stop('monalisa-octocat-hello-world-g4wpq6h95q')
        );
    }

    /**
     * Test the stop method with an unexpected response.
     *
     * @return  void
     */
    public function testStopFailure()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/user/codespaces/monalisa-octocat-hello-world-g4wpq6h95q/stop', '', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->stop('monalisa-octocat-hello-world-g4wpq6h95q');
    }

    /**
     * Test the getListForRepo method.
     *
     * @return  void
     */
    public function testGetListForRepo()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/codespaces?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListForRepo('joomla', 'joomla-platform', 2, 30)
        );
    }

    /**
     * Test the getListForRepo method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListForRepoFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/codespaces?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListForRepo('joomla', 'joomla-platform', 2, 30);
    }

    /**
     * Test the createForRepo method.
     *
     * @return  void
     */
    public function testCreateForRepo()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/codespaces', '{"ref":"main"}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForRepo('joomla', 'joomla-platform', ['ref' => 'main'])
        );
    }

    /**
     * Test the createForRepo method with a 202 response.
     *
     * @return  void
     */
    public function testCreateForRepoStatus202()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/codespaces', '{"ref":"main"}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 202));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForRepo('joomla', 'joomla-platform', ['ref' => 'main'])
        );
    }

    /**
     * Test the createForRepo method with an unexpected response.
     *
     * @return  void
     */
    public function testCreateForRepoFailure()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/codespaces', '{"ref":"main"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->createForRepo('joomla', 'joomla-platform', ['ref' => 'main']);
    }

    /**
     * Test the getListDevcontainers method.
     *
     * @return  void
     */
    public function testGetListDevcontainers()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/codespaces/devcontainers?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getListDevcontainers('joomla', 'joomla-platform', 2, 30)
        );
    }

    /**
     * Test the getListDevcontainers method with an unexpected response.
     *
     * @return  void
     */
    public function testGetListDevcontainersFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/codespaces/devcontainers?page=2&per_page=30', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getListDevcontainers('joomla', 'joomla-platform', 2, 30);
    }

    /**
     * Test the getDefaultAttributes method.
     *
     * @return  void
     */
    public function testGetDefaultAttributes()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/codespaces/new?ref=main', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->getDefaultAttributes('joomla', 'joomla-platform', ['ref' => 'main'])
        );
    }

    /**
     * Test the getDefaultAttributes method with an unexpected response.
     *
     * @return  void
     */
    public function testGetDefaultAttributesFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/codespaces/new?ref=main', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->getDefaultAttributes('joomla', 'joomla-platform', ['ref' => 'main']);
    }

    /**
     * Test the checkPermissions method.
     *
     * @return  void
     */
    public function testCheckPermissions()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/codespaces/permissions_check?ref=main&devcontainer_path=.devcontainer/example/devcontainer.json', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 200));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->checkPermissions('joomla', 'joomla-platform', 'main', '.devcontainer/example/devcontainer.json')
        );
    }

    /**
     * Test the checkPermissions method with an unexpected response.
     *
     * @return  void
     */
    public function testCheckPermissionsFailure()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->with('/repos/joomla/joomla-platform/codespaces/permissions_check?ref=main&devcontainer_path=.devcontainer/example/devcontainer.json', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->checkPermissions('joomla', 'joomla-platform', 'main', '.devcontainer/example/devcontainer.json');
    }

    /**
     * Test the createForPull method.
     *
     * @return  void
     */
    public function testCreateForPull()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/pulls/42/codespaces', '{"location":"WestUs2"}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 201));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForPull('joomla', 'joomla-platform', 42, ['location' => 'WestUs2'])
        );
    }

    /**
     * Test the createForPull method with a 202 response.
     *
     * @return  void
     */
    public function testCreateForPullStatus202()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/pulls/42/codespaces', '{"location":"WestUs2"}', [], 0)
            ->willReturn($this->getResponseObject($this->sampleString, 202));

        $this->assertEquals(
            json_decode($this->sampleString),
            $this->object->createForPull('joomla', 'joomla-platform', 42, ['location' => 'WestUs2'])
        );
    }

    /**
     * Test the createForPull method with an unexpected response.
     *
     * @return  void
     */
    public function testCreateForPullFailure()
    {
        $this->client->expects($this->once())
            ->method('post')
            ->with('/repos/joomla/joomla-platform/pulls/42/codespaces', '{"location":"WestUs2"}', [], 0)
            ->willReturn($this->getResponseObject($this->errorString, 500));

        $this->expectException(UnexpectedResponseException::class);

        $this->object->createForPull('joomla', 'joomla-platform', 42, ['location' => 'WestUs2']);
    }
}
